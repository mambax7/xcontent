<?php

/*
Module: xContent

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

use Xmf\Request;
use XoopsModules\Xcontent;
use XoopsModules\Xcontent\Helper;

require_once \dirname(__DIR__, 2) . '/mainfile.php';

require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FUNCTIONS);
require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FORMOBJECTS);
require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FORMS);
require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_TEMPLATE);

$helper = Helper::getInstance();

$myts = \MyTextSanitizer::getInstance();

/** @var \XoopsGroupPermHandler $grouppermHandler */
$grouppermHandler = xoops_getHandler('groupperm');
$groups           = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : [XOOPS_GROUP_ANONYMOUS];
/** @var \XoopsModuleHandler $moduleHandler */
$moduleHandler = xoops_getHandler('module');
$xoModule      = $moduleHandler->getByDirname(_XCONTENT_DIRNAME);
$modid         = $xoModule->getVar('mid');

$op         = isset($_REQUEST['op']) ? mb_strtolower($_REQUEST['op']) : '';
$fct        = isset($_REQUEST['fct']) ? mb_strtolower($_REQUEST['fct']) : '';
$storyid    = Request::getInt('storyid', 0, 'REQUEST');
$xcontentid = Request::getInt('xcontentid', 0, 'REQUEST');
$catid      = Request::getInt('catid', 0, 'REQUEST');
$blockid    = Request::getInt('blockid', 0, 'REQUEST');
$form       = isset($_REQUEST['form']) ? mb_strtolower($_REQUEST['form']) : '';
$passkey    = isset($_REQUEST['passkey']) ? mb_strtolower($_REQUEST['passkey']) : '';
$mode       = isset($_REQUEST['mode']) ? mb_strtolower($_REQUEST['mode']) : _XCONTENT_PERM_MODE_VIEW;
$language   = $_REQUEST['language'] ?? $GLOBALS['xoopsConfig']['language'];

/** @var \XoopsModuleHandler $moduleHandler */
$moduleHandler = xoops_getHandler('module');
$criteria      = new \CriteriaCompo(new \Criteria('dirname', 'xlanguage'));
$criteria->add(new \Criteria('isactive', true));
if ($moduleHandler->getCount($criteria) > 0) {
    $GLOBALS['multilingual'] = true;
} else {
    $GLOBALS['multilingual'] = false;
}
