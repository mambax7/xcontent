<?php

/*
Module: xContent

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

// defined('XOOPS_ROOT_PATH') || exit('Restricted access.');

$path = dirname(dirname(dirname(__DIR__)));
require_once $path . '/mainfile.php';

$dirname = basename(dirname(__DIR__));
/** @var XoopsModuleHandler $moduleHandler */
$moduleHandler   = xoops_getHandler('module');
$module          = $moduleHandler->getByDirname($dirname);
$pathIcon32      = $module->getInfo('icons32');
$pathModuleAdmin = $module->getInfo('dirmoduleadmin');
$pathLanguage    = $path . $pathModuleAdmin;

if (!file_exists($fileinc = $pathLanguage . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/' . 'main.php')) {
    $fileinc = $pathLanguage . '/language/english/main.php';
}

$adminmenu[] = [
    //'icon' =>  _XCONTENT_XCONTENT_ADMENU0_ICON,
    'image' => _XCONTENT_XCONTENT_ADMENU0_ICON,
    'title' => _XCONTENT_XCONTENT_ADMENU0,
    'link'  => 'admin/index.php?op=' . _XCONTENT_URL_OP_DASHBOARD,
    'icon'  => $pathIcon32 . '/home.png',
];

$adminmenu[] = [
    //'icon' =>  _XCONTENT_XCONTENT_ADMENU3_ICON,
    'image' => _XCONTENT_XCONTENT_ADMENU3_ICON,
    'icon'  => $pathIcon32 . '/category.png',
    'title' => _XCONTENT_XCONTENT_ADMENU3,
    'link'  => 'admin/index.php?op=' . _XCONTENT_URL_FCT_CATEGORIES,
];

$adminmenu[] = [
    //'icon' =>  _XCONTENT_XCONTENT_ADMENU1_ICON,
    'image' => _XCONTENT_XCONTENT_ADMENU1_ICON,
    'icon'  => $pathIcon32 . '/manage.png',
    'title' => _XCONTENT_XCONTENT_ADMENU1,
    'link'  => 'admin/index.php?op=' . _XCONTENT_URL_FCT_XCONTENT,
];

$adminmenu[] = [
    //'icon' =>  _XCONTENT_XCONTENT_ADMENU2_ICON,
    //'image' =>  _XCONTENT_XCONTENT_ADMENU2_ICON,
    //'title' =>  _XCONTENT_XCONTENT_ADMENU2,
    //'link' => "._XCONTENT_URL_FCT_XCONTENT,
];

$adminmenu[] = [
    //'icon' =>  _XCONTENT_XCONTENT_ADMENU4_ICON,
    //'image' =>  _XCONTENT_XCONTENT_ADMENU4_ICON,
    //'title' =>  _XCONTENT_XCONTENT_ADMENU4,
    //'link' => "._XCONTENT_URL_FCT_CATEGORIES,
];

$adminmenu[] = [
    //'icon' =>  _XCONTENT_XCONTENT_ADMENU5_ICON,
    'icon'  => $pathIcon32 . '/block.png',
    'image' => _XCONTENT_XCONTENT_ADMENU5_ICON,
    'title' => _XCONTENT_XCONTENT_ADMENU5,
    'link'  => 'admin/index.php?op=' . _XCONTENT_URL_FCT_BLOCKS,
];

$adminmenu[] = [
    //'icon' =>  _XCONTENT_XCONTENT_ADMENU6_ICON,
    //'image' =>  _XCONTENT_XCONTENT_ADMENU6_ICON,
    //'title' =>  _XCONTENT_XCONTENT_ADMENU6,
    //'link' => "._XCONTENT_URL_FCT_BLOCKS,
];

$adminmenu[] = [
    //'icon' =>  _XCONTENT_XCONTENT_ADMENU7_ICON,
    'image' => _XCONTENT_XCONTENT_ADMENU7_ICON,
    'icon'  => $pathIcon32 . '/permissions.png',
    'title' => _XCONTENT_XCONTENT_ADMENU7,
    'link'  => 'admin/index.php?op=' . _XCONTENT_PERM_MODE_ALL,
];

$adminmenu[] = [
    'icon'  => _XCONTENT_XCONTENT_ADMENU8_ICON,
    'image' => _XCONTENT_XCONTENT_ADMENU8_ICON,
    'title' => _XCONTENT_XCONTENT_ADMENU8,
    'link'  => 'admin/index.php?op=' . _XCONTENT_URL_OP_ABOUT,
];

//$adminmenu[] = [
//'title' =>  _AM_MODULEADMIN_ABOUT,
//$adminmenu[$i]["link"]  = "admin/about.php";
//$adminmenu[$i]["icon"]  = $pathIcon32 . '/about.png';
//];
