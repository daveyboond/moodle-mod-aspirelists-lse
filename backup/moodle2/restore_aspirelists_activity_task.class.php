<?php

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/aspirelists/backup/moodle2/restore_aspirelists_stepslib.php');

class restore_aspirelists_activity_task extends restore_activity_task {

	/**
     * Define (add) particular settings this activity can have
     */
	protected function define_my_settings() {
        // No particular settings for this activity
    }

    /**
     * Define (add) particular steps this activity can have
     */
    protected function define_my_steps() {
        // url only has one structure step
        $this->add_step(new restore_aspirelists_activity_structure_step('aspirelists_structure', 'aspirelists.xml'));
    }

    /**
     * Define the contents in the activity that must be
     * processed by the link decoder
     */
    static public function define_decode_contents() {
        $contents = array();

        $contents[] = new restore_decode_content('aspirelists', array('intro'), 'aspirelists');

        return $contents;
    }

    /**
     * Define the decoding rules for links belonging
     * to the activity to be executed by the link decoder
     */
    static public function define_decode_rules() {
        $rules = array();

        $rules[] = new restore_decode_rule('ASPIRELISTSINDEX', '/mod/aspirelists/index.php?id=$1', 'course');
        $rules[] = new restore_decode_rule('ASPIRELISTSVIEWBYID', '/mod/aspirelists/view.php?id=$1', 'course_module');

        return $rules;

    }

    /**
     * Define the restore log rules that will be applied
     * by the {@link restore_logs_processor} when restoring
     * aspirelists logs. It must return one array
     * of {@link restore_log_rule} objects
     */
    static public function define_restore_log_rules() {
        $rules = array();

        $rules[] = new restore_log_rule('aspirelists', 'add', 'view.php?id={course_module}', '{aspirelists}');
        $rules[] = new restore_log_rule('aspirelists', 'update', 'view.php?id={course_module}', '{aspirelists}');
        $rules[] = new restore_log_rule('aspirelists', 'view', 'view.php?id={course_module}', '{aspirelists}');

        return $rules;
    }

    /**
     * Define the restore log rules that will be applied
     * by the {@link restore_logs_processor} when restoring
     * course logs. It must return one array
     * of {@link restore_log_rule} objects
     *
     * Note this rules are applied when restoring course logs
     * by the restore final task, but are defined here at
     * activity level. All them are rules not linked to any module instance (cmid = 0)
     */
    static public function define_restore_log_rules_for_course() {
        $rules = array();

        $rules[] = new restore_log_rule('aspirelists', 'view all', 'index.php?id={course}', null);

        return $rules;
    }
}