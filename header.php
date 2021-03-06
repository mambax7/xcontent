<?php

/*
Module: xContent

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

require_once __DIR__ . '/../../mainfile.php';

require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FUNCTIONS);
require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FORMOBJECTS);
require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FORMS);
require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_TEMPLATE);

$myts = MyTextSanitizer::getInstance();

$gpermHandler = xoops_getHandler('groupperm');
$groups       = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : [XOOPS_GROUP_ANONYMOUS];
/** @var XoopsModuleHandler $moduleHandler */
$moduleHandler = xoops_getHandler('module');
$xoModule      = $moduleHandler->getByDirname(_XCONTENT_DIRNAME);
$modid         = $xoModule->getVar('mid');

$op         = isset($_REQUEST['op']) ? strtolower($_REQUEST['op']) : '';
$fct        = isset($_REQUEST['fct']) ? strtolower($_REQUEST['fct']) : '';
$storyid    = isset($_REQUEST['storyid']) ? (int)$_REQUEST['storyid'] : 0;
$xcontentid = isset($_REQUEST['xcontentid']) ? (int)$_REQUEST['xcontentid'] : 0;
$catid      = isset($_REQUEST['catid']) ? (int)$_REQUEST['catid'] : 0;
$blockid    = isset($_REQUEST['blockid']) ? (int)$_REQUEST['blockid'] : 0;
$form       = isset($_REQUEST['form']) ? strtolower($_REQUEST['form']) : '';
$passkey    = isset($_REQUEST['passkey']) ? strtolower($_REQUEST['passkey']) : '';
$mode       = isset($_REQUEST['mode']) ? strtolower($_REQUEST['mode']) : _XCONTENT_PERM_MODE_VIEW;
$language   = isset($_REQUEST['language']) ? $_REQUEST['language'] : $GLOBALS['xoopsConfig']['language'];

/** @var XoopsModuleHandler $moduleHandler */
$moduleHandler = xoops_getHandler('module');
$criteria      = new CriteriaCompo(new Criteria('dirname', 'xlanguage'));
$criteria->add(new Criteria('isactive', true));
if ($moduleHandler->getCount($criteria) > 0) {
    $GLOBALS['multilingual'] = true;
} else {
    $GLOBALS['multilingual'] = false;
}
