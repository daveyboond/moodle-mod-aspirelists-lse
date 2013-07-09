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
        $options['all']    = 'All';

        // Check if we're editing an existing list, and get shortname override if set
        if ($readinglist = $DB->get_record('aspirelists', array('id'=>$this->_instance), '*')
            and !empty($readinglist->shortnameoverride)) {
      
            $shortnames = array($readinglist->shortnameoverride);
        } else {
            // Otherwise get the course code from the course short name
            $shortname_full = explode(' ', $COURSE->shortname);
            $shortnames = explode('/', strtolower($shortname_full[0]));
        }
        //-------------------------------------------------------

        $foundlist = false;
        foreach ($shortnames as $shortname) {
            $url = "$config->baseurl/$config->group/$shortname/lists.json";

            $data = curlSource($url);

            if(isset($data["$config->baseurl/$config->group/$shortname"]['http://purl.org/vocab/resourcelist/schema#usesList'][0]['value'])) {
                $list_url = $data["$config->baseurl/$config->group/$shortname"]['http://purl.org/vocab/resourcelist/schema#usesList'][0]['value'];
                $level = 0;
                $d = aspirelists_getCats($list_url, $options, $level, $shortname);
                $foundlist = true;
            }

        }
        
        // Check whether any lists were found; if not, report this in the Category box
        if (!$foundlist) {
            $shortnamelist = implode(',', $shortnames);
            $options = array('null' => 'No lists found; try a different course code.');
        }
                
        $mform->addElement('select', 'category', 'Category', $options, array('size'=>20));

        // add standard buttons, common to all modules
        $this->standard_coursemodule_elements();
        $this->add_action_buttons();
        return;
    }



}