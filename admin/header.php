<?php

/*
Module: xContent

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

require_once __DIR__ . '/../../../include/cp_header.php';

require_once __DIR__ . '/../../../include/cp_header.php';

if (!defined('_CHARSET')) {
    define('_CHARSET', 'UTF-8');
}
if (!defined('_CHARSET_ISO')) {
    define('_CHARSET_ISO', 'ISO-8859-1');
}

$GLOBALS['myts'] = MyTextSanitizer::getInstance();

require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FUNCTIONS);
require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FORMOBJECTS);
require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FORMS);
require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_TEMPLATE);

$myts = MyTextSanitizer::getInstance();

$op         = isset($_REQUEST['op']) ? strtolower($_REQUEST['op']) : 'dashboard';
$fct        = isset($_REQUEST['fct']) ? strtolower($_REQUEST['fct']) : '';
$storyid    = isset($_REQUEST['storyid']) ? (int)$_REQUEST['storyid'] : 0;
$xcontentid = isset($_REQUEST['xcontentid']) ? (int)$_REQUEST['xcontentid'] : 0;
$catid      = isset($_REQUEST['catid']) ? (int)$_REQUEST['catid'] : 0;
$blockid    = isset($_REQUEST['blockid']) ? (int)$_REQUEST['blockid'] : 0;
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

$GLOBALS['contentTpl'] = new XoopsTpl();

/** @var XoopsModuleHandler $moduleHandler */
$moduleHandler                   = xoops_getHandler('module');
$configHandler                   = xoops_getHandler('config');
$GLOBALS['xcontentModule']       = $moduleHandler->getByDirname('xcontent');
$GLOBALS['xcontentModuleConfig'] = $configHandler->getConfigList($GLOBALS['xcontentModule']->getVar('mid'));

xoops_load('pagenav');
xoops_load('xoopslists');
xoops_load('xoopsformloader');

require_once $GLOBALS['xoops']->path('class/xoopsmailer.php');
require_once $GLOBALS['xoops']->path('class/xoopstree.php');

if (file_exists($GLOBALS['xoops']->path('Frameworks/moduleclasses/moduleadmin/moduleadmin.php'))) {
    require_once $GLOBALS['xoops']->path('Frameworks/moduleclasses/moduleadmin/moduleadmin.php');
    //return true;
} else {
    echo xcontent_error("Error: You don't use the Frameworks \"admin module\". Please install this Frameworks");
    //return false;
}
$GLOBALS['xcontentImageIcon']  = \Xmf\Module\Admin::iconUrl('', 16);
$GLOBALS['xcontentImageAdmin'] = XOOPS_URL . '/' . $GLOBALS['xcontentModule']->getInfo('icons32');

if ($GLOBALS['xoopsUser']) {
    $modulepermHandler = xoops_getHandler('groupperm');
    if (!$modulepermHandler->checkRight('module_admin', $GLOBALS['xcontentModule']->getVar('mid'), $GLOBALS['xoopsUser']->getGroups())) {
        redirect_header(XOOPS_URL, 1, _NOPERM);
    }
} else {
    redirect_header(XOOPS_URL . '/user.php', 1, _NOPERM);
}

if (!isset($GLOBALS['xoopsTpl']) || !is_object($GLOBALS['xoopsTpl'])) {
    require_once XOOPS_ROOT_PATH . '/class/template.php';
    $GLOBALS['xoopsTpl'] = new XoopsTpl();
}

$GLOBALS['xoopsTpl']->assign('pathImageIcon', $GLOBALS['xcontentImageIcon']);
$GLOBALS['xoopsTpl']->assign('pathImageAdmin', $GLOBALS['xcontentImageAdmin']);
