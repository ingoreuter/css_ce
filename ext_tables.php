<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// Register Plugin
//\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
//	$_EXTKEY, 
//	'Csscode', 
//	'LLL:EXT:css_ce/Resources/Private/Language/locallang_be.xlf:tx_cssce.plugin.name'
//); 

// Static template
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'CSS for content elements');

// Page TSSetup
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:css_ce/Configuration/TypoScript/page.txt">');

// Add field to TCA
$TCA['tt_content']['columns'] += array(	
	'tx_cssce_css' => array(
		'exclude' => 1,
		'label' => '', // Heading goes heere!
		'config' => array(
			'type' => 'flex',
			'ds' => array(
				'default' => 'FILE:EXT:css_ce/Configuration/FlexForm/Setup.xml',
			)
		)
	)
);

	// Display field in all content element types
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
	'tt_content', 
	'
	--div--;LLL:EXT:css_ce/Resources/Private/Language/locallang_be.xlf:tx_cssce.be.tabname,
	tx_cssce_css
	'
);

?>