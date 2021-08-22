<?php

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project (https://xoops.org)
 * @license      GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @author      XOOPS Development Team
 */

use Xmf\Module\Admin;
use Xmf\Request;
use XoopsModules\Xcontent;
use XoopsModules\Xcontent\Helper;

require \dirname(__DIR__, 3) . '/include/cp_header.php';
require \dirname(__DIR__) . '/preloads/autoloader.php';
require_once \dirname(__DIR__) . '/include/common.php';

//require_once  \dirname(__DIR__, 3) . '/class/xoopsformloader.php';

$moduleDirName = \basename(\dirname(__DIR__));
$helper  = Helper::getInstance();
$utility = new Xcontent\Utility();

/** @var Xmf\Module\Admin $adminObject */
$adminObject = Admin::getInstance();

//$myts = \MyTextSanitizer::getInstance();

//if (!isset($GLOBALS['xoopsTpl']) || !($GLOBALS['xoopsTpl'] instanceof \XoopsTpl)) {
//    require_once $GLOBALS['xoops']->path('class/template.php');
//    $xoopsTpl = new XoopsTpl();
//}

//$pathIcon16      = Xmf\Module\Admin::iconUrl('', 16);
//$pathIcon32      = Xmf\Module\Admin::iconUrl('', 32);
//$pathModIcon32 = $helper->getModule()->getInfo('modicons32');

// Local icons path
//$xoopsTpl->assign('pathModIcon16', $pathIcon16);
//$xoopsTpl->assign('pathModIcon32', $pathIcon32);

// Load language files
$helper->loadLanguage('admin');
$helper->loadLanguage('modinfo');
$helper->loadLanguage('main');

//Module specific elements
//require_once $GLOBALS['xoops']->path("modules/{$moduleDirName}/include/functions.php");
//require_once $GLOBALS['xoops']->path("modules/{$moduleDirName}/config/config.php");

//xoops_cp_header();

// render output
//if (!isset($GLOBALS['xoTheme']) || !is_object($GLOBALS['xoTheme'])) {
//    require_once $GLOBALS['xoops']->path('/class/theme.php');
//    $GLOBALS['xoTheme'] = new \xos_opal_Theme();
//}

//=======================================

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

$op         = isset($_REQUEST['op']) ? mb_strtolower($_REQUEST['op']) : 'dashboard';
$fct        = isset($_REQUEST['fct']) ? mb_strtolower($_REQUEST['fct']) : '';
$storyid    = Request::getInt('storyid', 0, 'REQUEST');
$xcontentid = Request::getInt('xcontentid', 0, 'REQUEST');
$catid      = Request::getInt('catid', 0, 'REQUEST');
$blockid    = Request::getInt('blockid', 0, 'REQUEST');
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

//require_once $GLOBALS['xoops']->path('class/xoopsmailer.php');
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
