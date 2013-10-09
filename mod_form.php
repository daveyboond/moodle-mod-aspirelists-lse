<?php

/**********************************************************************
 *                      @package Kent aspirelists                     *
 *                                                                    *
 *              University of Kent aspirelists resource               *
 *                                                                    *
 *                       Authors: jwk8, fg30, jw26                    *
 *                                                                    *
 *--------------------------------------------------------------------*
 *                                                                    *
 *                            Add/update form                         *
 *                                                                    *
 **********************************************************************/

defined('MOODLE_INTERNAL') || die;

require_once ($CFG->dirroot.'/course/moodleform_mod.php');
require_once("$CFG->libdir/resourcelib.php");

class mod_aspirelists_mod_form extends moodleform_mod {

	function definition() {
        global $CFG, $OUTPUT, $COURSE, $DB;

        $config = get_config('aspirelists');

        $mform =& $this->_form;

        //-------------------------------------------------------
        $mform->addElement('header', 'general', get_string('general', 'form'));
        $mform->addElement('text', 'name', get_string('name'), array('size'=>'48'));
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEANHTML);
        }
        $mform->addRule('name', null, 'required', null, 'client');
        $this->add_intro_editor();

        //-------------------------------------------------------
        // Additions by Steve Bond 20/06/13. Extra field for overriding shortname
        $mform->addElement('text', 'shortnameoverride', get_string('shortnameoverride','aspirelists'), array('maxlength' => 255, 'size' => 50));
        $mform->addHelpButton('shortnameoverride', 'shortnameoverride', 'aspirelists');

        $options=array();

        // Check if we're editing an existing list, and get shortname override if set
        if ($readinglist = $DB->get_record('aspirelists', array('id'=>$this->_instance), '*')
            and !empty($readinglist->shortnameoverride)) {
      
            $shortname = $readinglist->shortnameoverride;
        } else {
            // Otherwise get the course code from the course ID number
            $shortname = $COURSE->idnumber;
        }
        $shortnamelc = strtolower($shortname);
        
        //-------------------------------------------------------
        $foundlist = false;
        $privatelists = array();

        $url = "$config->baseurl/$config->group/$shortnamelc/lists.json";

        $data = curlSource($url);
        if (is_null($data)) {
            // No such course
            if (empty($shortnamelc)) {
                $options = array('null' => get_string('error:nocourseid', 'aspirelists'));
            } else {
                $options = array('null' => get_string('error:nocourse', 'aspirelists') . $shortname);
            }
        } else {
            $options['all'] = get_string('all', 'aspirelists'); // Default 'all' option

            // Loop through each list for this course (different terms)
            foreach ($data["$config->baseurl/$config->group/$shortnamelc"]['http://purl.org/vocab/resourcelist/schema#usesList'] as $use) {
                if(isset($use['value'])) {
                    $list_url = $use['value'];
                    // If this list is private, make a record of the term title
                    if (array_key_exists('http://purl.org/vocab/resourcelist/schema#visibility', $data[$list_url]) and
                        $data[$list_url]['http://purl.org/vocab/resourcelist/schema#visibility'][0]['value'] == 'http://purl.org/vocab/resourcelist/schema#private') {

                        $timePeriod = $data[$list_url]['http://lists.talis.com/schema/temp#hasTimePeriod'][0]['value'];
                        $privatelists[] = $data[$timePeriod]['http://purl.org/dc/terms/title'][0]['value'];
                    }
                    
                    $level = 0;
                    // Try to get categories (weeks) for this list and add them to the $options list
                    // If the list is private, nothing will be added to the options list
                    $d = aspirelists_getCats($list_url, $options, $level, $shortname);
                    $foundlist = true;
                }
            }

            $p = 0;
            foreach ($privatelists as $privatelist) {
                $p++;
                $options["private$p"] = get_string('error:privatelist', 'aspirelists') . $privatelist . get_string('error:clickhelp', 'aspirelists');
            }

            // Don't need an 'all' option in this case
            if ($p > 0) unset($options['all']);
            
            // Check whether any lists were found; if not, report this in the Category box
            if (!$foundlist) {
                $options = array('null' => get_string('error:nolistcat', 'aspirelists') . $shortname . '. ' . get_string('error:trydifferent', 'aspirelists'));
            }
        }
       
        $mform->addElement('select', 'category', 'Category', $options, array('size'=>20));
        $mform->addHelpButton('category', 'category', 'aspirelists');
        
        if (isset($options['private1'])) {
            $mform->setDefault('category', 'private1');
        } else {
            $mform->setDefault('category', 'all');            
        }
        
        $mform->addElement('select', 'display', get_string('displayselect', 'page'), resourcelib_get_displayoptions(array(RESOURCELIB_DISPLAY_OPEN, RESOURCELIB_DISPLAY_NEW)));
        $mform->setDefault('display', RESOURCELIB_DISPLAY_NEW);
                
        // add standard buttons, common to all modules
        $this->standard_coursemodule_elements();
        $this->add_action_buttons(true, false, null);
        return;
    }

    private function sort_options($opts) {
        // This takes so long that it times out. Probably this won't work. If there
        // is a way to sort from the JSON that might be better.
        $w = 1;
        $foundnextgroup = false;
        $foundanygroup = false;
        $chunk = array();
        $newopts = array();
        while(!$foundanygroup) {
            foreach ($opts as $key => $opt) {
                if (preg_match('/[Ww]eek\s*(\d+)/', $opt, $matches)) {
                    if ($matches[1] == $w) {
                        $foundnextgroup = true;
                        $foundanygroup = true;
                        $chunk[$key] = $opt;
                    } elseif ($foundnextgroup) {
                        array_merge($newopts, $chunk);
                        $chunk = array();
                        $w++;
                        break;
                    }
                } elseif ($foundnextgroup) {
                        $chunk[$key] = $opt;              
                }
            }
            if (!$foundnextgroup) {
                break;
            }
            $foundnextgroup = false;
        }
        return $newopts;
    }


}