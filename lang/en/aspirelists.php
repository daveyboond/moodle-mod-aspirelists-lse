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

$string['aspirelists:addinstance'] = 'Add reading list';
$string['aspirelists:pub'] = 'Publish reading list';
$string['category'] = 'Category';
$string['category_help'] = 'Select the category (week) to display from this menu. If
    an entry reads "List is marked private", choosing this entry will only display the
    top-level menu for all reading lists for this course. If you wish to display a
    particular week or category, you will need to make your list public first.';
$string['modulename'] = 'Reading list';
$string['modulenameplural'] = 'Reading lists';
$string['modulename_help'] = 'This resource allows you to link to the reading lists for your course on Reading Lists @ LSE.
    
If your lists on Reading Lists @ LSE are <strong>not</strong> marked private, you can use this resource to link directly to a particular week or section of the list.

If your list is marked private, you can only link to the top-level menu showing all reading lists for this course, and students will then have to navigate to the required week or section.

<a href="http://clt.lse.ac.uk/moodle/creating-a-reading-list.php" target="_blank">More information about Reading Lists @ LSE</a>
';
$string['newmodulename'] = 'Reading list';
$string['streamingvideo'] = 'Reading list';
$string['pluginadministration'] = 'Reading list administration';
$string['pluginname'] = 'Reading list';
$string['shortnameoverride'] = 'New course code';
$string['shortnameoverride_help'] = 'If the shortname of this course does not contain
    the course code for the list that you want to link to on Reading Lists @ LSE, you
    can enter a different course code here. You will need to save changes and return
    to this form in order to select a category from the list below.';
$string['all'] = 'All';

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

$string['error:clickhelp'] = ' (Click help button for details.)';
$string['error:nocourse'] = 'No course found on Talis Aspire for ';
$string['error:nocoursecode'] = 'No course code specified.';
$string['error:nolist'] = '<p>Sorry, you are unable to add a reading list resource to a course at this time. This error has occured because there does not seem to be a list for this module on the reading list system.</p>';
$string['error:nolistcat'] = 'No lists found in ';
$string['error:privatelist'] = 'Private list: weeks cannot be retrieved for ';
$string['error:trydifferent'] = 'Try a different course code.';
$string['error:studentnolist'] = '<p>Sorry, but the reading list resource is unavailable for this course.  This Moodle course is not yet linked to the resource lists system.  You may be able to find your list through searching the resource lists system, or you can consult your Moodle module or lecturer for further information.</p>';
$string['error:staffnolist'] = '<p>Sorry, but the reading list resource is unavailable for this course.</p>';
$string['error:defaultnolist'] = '<p>Sorry, but the reading list resource is unavailable for this course.<p>';