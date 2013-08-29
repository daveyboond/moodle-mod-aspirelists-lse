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
            // Otherwise get the course code from the course short name
            $shortname = $COURSE->shortname;
        }
        $shortnamelc = strtolower($shortname);
        
        //-------------------------------------------------------
        $foundlist = false;
        $privatelists = array();

        $url = "$config->baseurl/$config->group/$shortnamelc/lists.json";

        $data = curlSource($url);
        if (is_null($data)) {
            // No such course
            $options = array('null' => get_string('error:nocourse', 'aspirelists') . $shortname);
        } else {
            // Loop through each list for this course (different terms)
            foreach ($data["$config->baseurl/$config->group/$shortnamelc"]['http://purl.org/vocab/resourcelist/schema#usesList'] as $use) {
                if(isset($use[0]['value'])) {
                    $list_url = $use[0]['value'];
                    // If this list is private, make a record of the term title

                    if ($data[$list_url]['http://purl.org/vocab/resourcelist/schema#visibility'][0]['value'] == 'http://purl.org/vocab/resourcelist/schema#private') {
                        $timePeriod = $data[$list_url]['http://lists.talis.com/schema/temp#hasTimePeriod']['value'];
                        $privatelists[] = $data[$timePeriod]['http://purl.org/dc/terms/title'][0]['value'];
                    }
                    $level = 0;
                    // Try to get categories (weeks) for this list and add them to the $options list
                    // If the list is private, nothing will be added to the options list
                    $d = aspirelists_getCats($list_url, $options, $level, $shortname);
                    $foundlist = true;
                    // ** NEXT STEP ** Need to determine the difference between "no options because no lists"
                    // and "no options because lists private". If private, give an option for "all", if
                    // no lists, show the warning message instead.
                }
            }
            // Check whether any lists were found; if not, report this in the Category box
            if (!$foundlist) {
                $options = array('null' => get_string('error:nolistcat', 'aspirelists') . $shortname . '. ' . get_string('error:trydifferent', 'aspirelists'));
            }
        }

        foreach ($privatelists as $privatelist) {
            $options['null'] = get_string('error:privatelist', 'aspirelists') . $privatelist;
        }
        
        array_unshift($options, 'All');
        
        $mform->addElement('select', 'category', 'Category', $options, array('size'=>20));

        // add standard buttons, common to all modules
        $this->standard_coursemodule_elements();
        $this->add_action_buttons();
        return;
    }



}