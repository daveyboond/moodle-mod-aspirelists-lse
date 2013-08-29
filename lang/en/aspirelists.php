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
 *                            en-lang file                            *
 *                                                                    *
 **********************************************************************/

defined('MOODLE_INTERNAL') || die();

/*********************************
 *            General            * 
 *********************************/

$string['modulename'] = 'Reading lists';
$string['modulenameplural'] = 'Reading lists';
$string['newmodulename'] = 'Reading lists';
$string['streamingvideo'] = 'Reading lists';
$string['pluginadministration'] = 'Reading lists administration';
$string['pluginname'] = 'Reading lists';
$string['shortnameoverride'] = 'New course code';
$string['shortnameoverride_help'] = 'If the shortname of this course does not contain
    the course code for the list that you want to link to on Reading Lists @ LSE, you
    can enter a different course code here. You will need to save changes and return
    to this form in order to select a category from the list below.';

/*********************************
 *            Settings           * 
 *********************************/

$string['settings:timeout'] = 'Timeout';
$string['settings:configtimeout'] = 'Set timeout value for the request';

$string['settings:baseurl'] = 'Timeout';
$string['settings:configbaseurl'] = 'Target Aspire base URL (e.g. http://lists.broadminsteruniversity.org)';

$string['settings:group'] = 'Target knowledge group';
$string['settings:configgroup'] = 'Choose target knowledge group';

$string['settings:group:courses'] = 'Courses';
$string['settings:group:modules'] = 'Modules';
$string['settings:group:units'] = 'Units';
$string['settings:group:programmes'] = 'Programmes';
$string['settings:group:subjects'] = 'Subjects';

$string['settings:redirect'] = 'Redirect';
$string['settings:configredirect'] = 'Redirect on single reading lists';

$string['config_timePeriod'] = 'Display time period';
$string['config_timePeriod_desc'] = 'Enter the time period you want to display (1 = 2011/2012, 2 = 2012/2013, etc)';
$string['config_timePeriod_ex'] = '2';

/*********************************
 *             Errors            * 
 *********************************/

$string['error:nocourse'] = 'No course found for: ';
$string['error:nolist'] = '<p>Sorry, you are unable to add a reading list resource to a course at this time. This error has occured because there does not seem to be a list for this module on the reading list system.</p>';
$string['error:nolistcat'] = 'No lists found; try a different course code.';
$string['error:studentnolist'] = '<p>Sorry, but the reading list resource is unavailable for this course.  This Moodle course is not yet linked to the resource lists system.  You may be able to find your list through searching the resource lists system, or you can consult your Moodle module or lecturer for further information.</p>';
$string['error:staffnolist'] = '<p>Sorry, but the reading list resource is unavailable for this course.</p>';
$string['error:defaultnolist'] = '<p>Sorry, but the reading list resource is unavailable for this course.<p>';