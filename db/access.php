<?php  // $Id$
/**
 * Capability definitions for the aspire module.
 *
 * For naming conventions, see lib/db/access.php.
 */
$capabilities = array(

    'mod/aspirelists:addinstance' => array(
        'riskbitmask' => RISK_SPAM | RISK_XSS,

        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ),

        'clonepermissionsfrom' => 'moodle/site:manageblocks'
    ),
    
    // Ability to manage/publish reading lists
    'mod/aspirelists:pub' => array(
        'riskbitmask' => RISK_MANAGETRUST & RISK_CONFIG,
        'captype' => 'write',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'guest' => CAP_PREVENT,
            'student' => CAP_PREVENT,
        )
    ),

);