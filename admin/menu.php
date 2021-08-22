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
use XoopsModules\Xcontent\{Helper
};

/** @var Admin $adminObject */
/** @var Helper $helper */

require_once \dirname(__DIR__) . '/preloads/autoloader.php';

$moduleDirName      = \basename(\dirname(__DIR__));
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

$helper             = Helper::getInstance();
$helper->loadLanguage('common');
$helper->loadLanguage('feedback');

$pathIcon32 = Admin::menuIconPath('');
$pathModIcon32 = XOOPS_URL .   '/modules/' . $moduleDirName . '/assets/images/icons/32/';
if (is_object($helper->getModule()) && false !== $helper->getModule()->getInfo('modicons32')) {
    $pathModIcon32 = $helper->url($helper->getModule()->getInfo('modicons32'));
}

$adminmenu[] = [
    'title' => _MI_XCONTENT_HOME,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png',
];

//$adminmenu[] = [
//    //'icon' =>  _XCONTENT_XCONTENT_ADMENU0_ICON,
//    'image' => _XCONTENT_XCONTENT_ADMENU0_ICON,
//    'title' => _XCONTENT_XCONTENT_ADMENU0,
//    'link'  => 'admin/main.php?op=' . _XCONTENT_URL_OP_DASHBOARD,
//    'icon'  => $pathIcon32 . '/home.png',
//];

$adminmenu[] = [
    //'icon' =>  _XCONTENT_XCONTENT_ADMENU3_ICON,
    'image' => _XCONTENT_XCONTENT_ADMENU3_ICON,
    'icon'  => $pathIcon32 . '/category.png',
    'title' => _XCONTENT_XCONTENT_ADMENU3,
    'link'  => 'admin/main.php?op=' . _XCONTENT_URL_OP_MANAGE . '&fct=' . _XCONTENT_URL_FCT_CATEGORIES,
];

$adminmenu[] = [
    //'icon' =>  _XCONTENT_XCONTENT_ADMENU1_ICON,
    'image' => _XCONTENT_XCONTENT_ADMENU1_ICON,
    'icon'  => $pathIcon32 . '/manage.png',
    'title' => _XCONTENT_XCONTENT_ADMENU1,
    'link'  => 'admin/main.php?op=' . _XCONTENT_URL_OP_MANAGE . '&fct=' . _XCONTENT_URL_FCT_XCONTENT,
];

//$adminmenu[] = [
//'icon' =>  _XCONTENT_XCONTENT_ADMENU2_ICON,
//'image' =>  _XCONTENT_XCONTENT_ADMENU2_ICON,
//'title' =>  _XCONTENT_XCONTENT_ADMENU2,
//'link' => 'admin/main.php?op=' . _XCONTENT_URL_OP_ADD."&fct="._XCONTENT_URL_FCT_XCONTENT,
//];

//$adminmenu[] = [
//'icon' =>  _XCONTENT_XCONTENT_ADMENU4_ICON,
//'image' =>  _XCONTENT_XCONTENT_ADMENU4_ICON,
//'title' =>  _XCONTENT_XCONTENT_ADMENU4,
//'link' => 'admin/main.php?op='  ._XCONTENT_URL_OP_ADD."&fct="._XCONTENT_URL_FCT_CATEGORIES,
//];

$adminmenu[] = [
    //'icon' =>  _XCONTENT_XCONTENT_ADMENU5_ICON,
    'icon'  => $pathIcon32 . '/block.png',
    'image' => _XCONTENT_XCONTENT_ADMENU5_ICON,
    'title' => _XCONTENT_XCONTENT_ADMENU5,
    'link'  => 'admin/main.php?op=' . _XCONTENT_URL_OP_MANAGE . '&fct=' . _XCONTENT_URL_FCT_BLOCKS,
];

//$adminmenu[] = [
//'icon' =>  _XCONTENT_XCONTENT_ADMENU6_ICON,
//'image' =>  _XCONTENT_XCONTENT_ADMENU6_ICON,
//'title' =>  _XCONTENT_XCONTENT_ADMENU6,
//'link' => 'admin/main.php?op=' . _XCONTENT_URL_OP_ADD."&fct="._XCONTENT_URL_FCT_BLOCKS,
//];

$adminmenu[] = [
    //'icon' =>  _XCONTENT_XCONTENT_ADMENU7_ICON,
    'image' => _XCONTENT_XCONTENT_ADMENU7_ICON,
    'icon'  => $pathIcon32 . '/permissions.png',
    'title' => _XCONTENT_XCONTENT_ADMENU7,
    'link'  => 'admin/main.php?op=' . _XCONTENT_URL_OP_PERMISSIONS . '&fct=' . _XCONTENT_URL_FCT_TEMPLATE . '&mode=' . _XCONTENT_PERM_MODE_ALL,
];

$adminmenu[] = [
    'icon'  => _XCONTENT_XCONTENT_ADMENU8_ICON,
    'image' => _XCONTENT_XCONTENT_ADMENU8_ICON,
    'title' => _XCONTENT_XCONTENT_ADMENU8,
    'link'  => 'admin/main.php?op=' . _XCONTENT_URL_OP_ABOUT,
];

// Blocks Admin
$adminmenu[] = [
    'title' => constant('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS'),
    'link'  => 'admin/blocksadmin.php',
    'icon'  => $pathIcon32 . '/block.png',
];

if (is_object($helper->getModule()) && $helper->getConfig('displayDeveloperTools')) {
    $adminmenu[] = [
        'title' => constant('CO_' . $moduleDirNameUpper . '_' . 'ADMENU_MIGRATE'),
        'link'  => 'admin/migrate.php',
        'icon'  => $pathIcon32 . '/database_go.png',
    ];
}

$adminmenu[] = [
    'title' => _MI_XCONTENT_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png',
];
