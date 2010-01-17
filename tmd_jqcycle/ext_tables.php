<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';

# Wir blenden die Standard Felder layout,select_key,pages,recursive  von Plugins aus
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key,pages,recursive';

# Dafür blenden wir das tt_content Feld pi_flexform ein
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1']='pi_flexform';

# Wir definieren die Datei, die unser Flexform Schema enth?lt
t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_pi1', 'FILE:EXT:'.$_EXTKEY.'/flexform_default.xml');

t3lib_extMgm::addPlugin(array(
	'LLL:EXT:jqcycle/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');

# TS Setup
t3lib_extMgm::addStaticFile($_EXTKEY,'static/defaultSetup/', 'Default Setup');
t3lib_extMgm::addStaticFile($_EXTKEY,'static/defaultCSS/', 'Default CSS');

?>