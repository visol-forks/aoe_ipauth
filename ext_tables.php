<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (!defined('TYPO3')) {
    die('Access denied.');
}

// IP
ExtensionManagementUtility::addLLrefForTCAdescr(
    'tx_aoeipauth_domain_model_ip',
    'EXT:aoe_ipauth/Resources/Private/Language/locallang_csh_tx_aoeipauth_domain_model_ip.xlf'
);

ExtensionManagementUtility::addLLrefForTCAdescr(
    'fe_users',
    'EXT:aoe_ipauth/Resources/Private/Language/locallang_csh_fe_users.xlf'
);

ExtensionManagementUtility::addLLrefForTCAdescr(
    'fe_groups',
    'EXT:aoe_ipauth/Resources/Private/Language/locallang_csh_fe_groups.xlf'
);

// registering reports
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['aoe_ipauth'] = array(
    'AOE\\AoeIpauth\\Report\\IpGroupAuthenticationStatus',
    'AOE\\AoeIpauth\\Report\\IpUserAuthenticationStatus',
);
