<?php

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use AOE\AoeIpauth\Hooks\Tcemain;
if (!defined('TYPO3')) {
    die('Access denied.');
}
$_EXTKEY = 'aoe_ipauth';
$backendConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('backend');

// BE: Do not show the IP records in the listing
$allowedTablesTs = '
    mod.web_list.deniedNewTables := addToList(tx_aoeipauth_domain_model_ip)
    mod.web_list.hideTables := addToList(tx_aoeipauth_domain_model_ip)
';
ExtensionManagementUtility::addPageTSConfig($allowedTablesTs);

// FE Hooks
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['aoe_ipauth'] = Tcemain::class;
$extensionConfiguration = GeneralUtility::makeInstance(
    ExtensionConfiguration::class
)->get('aoe_ipauth');
$GLOBALS['TYPO3_CONF_VARS']['SVCONF']['auth']['setup']['FE_fetchUserIfNoSession'] =
    isset($extensionConfiguration['fetchFeUserIfNoSession']) ? boolval($extensionConfiguration['fetchFeUserIfNoSession']) : 1;
unset($extensionConfiguration);

// IP Authentication Service
ExtensionManagementUtility::addService('aoe_ipauth', 'auth', 'tx_aoeipauth_typo3_service_authentication',
    array(
        'title' => 'IP Authentication',
        'description' => 'Authenticates against IP addresses and ranges.',
        'subtype' => 'authUserFE,getUserFE,getGroupsFE',
        'available' => true,
        // Must be higher than for tx_sv_auth (50) or tx_sv_auth will deny request unconditionally
        'priority' => 80,
        'quality' => 50,
        'os' => '',
        'exec' => '',
        'classFile' => ExtensionManagementUtility::extPath('aoe_ipauth') . 'Classes/Typo3/Service/Authentication.php',
        'className' => 'AOE\AoeIpauth\Typo3\Service\Authentication',
    )
);
