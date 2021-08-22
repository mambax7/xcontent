<?php

/*
Module: xContent

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

use Xmf\Module\Admin;
use Xmf\Request;
use XoopsModules\Xcontent;
use XoopsModules\Xcontent\Helper;

require \dirname(__DIR__, 3) . '/include/cp_header.php';
require \dirname(__DIR__) . '/preloads/autoloader.php';
require_once \dirname(__DIR__) . '/include/common.php';

$moduleDirName = \basename(\dirname(__DIR__));
$helper  = Helper::getInstance();
$utility = new Xcontent\Utility();

/** @var Xmf\Module\Admin $adminObject */
$adminObject = Admin::getInstance();

if (!defined('_CHARSET')) {
    define('_CHARSET', 'UTF-8');
}
if (!defined('_CHARSET_ISO')) {
    define('_CHARSET_ISO', 'ISO-8859-1');
}

$GLOBALS['myts'] = \MyTextSanitizer::getInstance();

require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FUNCTIONS);
require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FORMOBJECTS);
require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FORMS);
require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_TEMPLATE);

$myts = \MyTextSanitizer::getInstance();

$op         = Request::getCmd('op', 'dashboard');
$fct        = Request::getCmd('fct', '');
$storyid    = Request::getInt('storyid', 0, 'REQUEST');
$xcontentid = Request::getInt('xcontentid', 0, 'REQUEST');
$catid      = Request::getInt('catid', 0, 'REQUEST');
$blockid    = Request::getInt('blockid', 0, 'REQUEST');
$passkey    = Request::getCmd('passkey', '');
$mode       = Request::getCmd('mode', _XCONTENT_PERM_MODE_VIEW);
$language   = Request::getString('language', $GLOBALS['xoopsConfig']['language']);

/** @var \XoopsModuleHandler $moduleHandler */
$moduleHandler = xoops_getHandler('module');
$criteria      = new \CriteriaCompo(new \Criteria('dirname', 'xlanguage'));
$criteria->add(new \Criteria('isactive', true));
if ($moduleHandler->getCount($criteria) > 0) {
    $GLOBALS['multilingual'] = true;
} else {
    $GLOBALS['multilingual'] = false;
}

$GLOBALS['contentTpl'] = new \XoopsTpl();

/** @var \XoopsModuleHandler $moduleHandler */
$moduleHandler = xoops_getHandler('module');
/** @var \XoopsConfigHandler $configHandler */
$configHandler                   = xoops_getHandler('config');
$GLOBALS['xcontentModule']       = $moduleHandler->getByDirname('xcontent');
$GLOBALS['xcontentModuleConfig'] = $configHandler->getConfigList($GLOBALS['xcontentModule']->getVar('mid'));

xoops_load('pagenav');
xoops_load('xoopslists');
xoops_load('xoopsformloader');

require_once $GLOBALS['xoops']->path('class/xoopsmailer.php');
require_once $GLOBALS['xoops']->path('class/xoopstree.php');

$GLOBALS['xcontentImageIcon']  = Admin::iconUrl('', 16);
$GLOBALS['xcontentImageAdmin'] = XOOPS_URL . '/' . $GLOBALS['xcontentModule']->getInfo('icons32');

if ($GLOBALS['xoopsUser']) {
    /** @var \XoopsGroupPermHandler $grouppermHandler */
    $grouppermHandler = xoops_getHandler('groupperm');
    if (!$grouppermHandler->checkRight('module_admin', $GLOBALS['xcontentModule']->getVar('mid'), $GLOBALS['xoopsUser']->getGroups())) {
        redirect_header(XOOPS_URL, 1, _NOPERM);
    }
} else {
    redirect_header(XOOPS_URL . '/user.php', 1, _NOPERM);
}

if (!isset($GLOBALS['xoopsTpl']) || !is_object($GLOBALS['xoopsTpl'])) {
    require_once XOOPS_ROOT_PATH . '/class/template.php';
    $GLOBALS['xoopsTpl'] = new \XoopsTpl();
}

$GLOBALS['xoopsTpl']->assign('pathImageIcon', $GLOBALS['xcontentImageIcon']);
$GLOBALS['xoopsTpl']->assign('pathImageAdmin', $GLOBALS['xcontentImageAdmin']);
