<?php

/*
Module: xContent

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

use XoopsModules\Xcontent\Helper;

require_once __DIR__ . '/preloads/autoloader.php';
$helper = Helper::getInstance();

$moduleDirName      = basename(__DIR__);
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

$i = 0;
//$modversion['version']       = _XCONTENT_VERSION;
$modversion['version']                = '2.17';
$modversion['release_date']           = '2017/04/23';
$modversion['module_status']          = 'Beta 2';
$modversion['name']                   = _XCONTENT_MODULENAME;
$modversion['author']                 = _XCONTENT_AUTHOR;
$modversion['description']            = _XCONTENT_DESCRIPTION;
$modversion['credits']                = _XCONTENT_OWNER;
$modversion['license']                = _XCONTENT_LICENSE;
$modversion['official']               = _XCONTENT_OFFICIAL;
$modversion['image']                  = 'assets/images/logoModule.png'; //_XCONTENT_LOGOIMAGE;
$modversion['dirname']                = $moduleDirName; //_XCONTENT_DIRNAME;
$modversion['website']                = 'www.xoops.org';
$modversion['modicons16']             = 'assets/images/icons/16';
$modversion['modicons32']             = 'assets/images/icons/32';
$modversion['release_info']           = '2012/08/06';
$modversion['release_file']           = XOOPS_URL . '/modules/' . $modversion['dirname'] . '/docs/changelog.txt';
$modversion['author_realname']        = 'Simon Roberts';
$modversion['author_website_url']     = 'http://www.chronolabs.coop';
$modversion['author_website_name']    = 'Chronolabs Cooperative';
$modversion['author_email']           = 'simon@chronolabs.coop';
$modversion['demo_site_url']          = '';
$modversion['demo_site_name']         = '';
$modversion['support_site_url']       = '';
$modversion['support_site_name']      = '';
$modversion['submit_bug']             = '';
$modversion['submit_feature']         = '';
$modversion['usenet_group']           = 'sci.chronolabs';
$modversion['maillist_announcements'] = '';
$modversion['maillist_bugs']          = '';
$modversion['maillist_features']      = '';

// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = _XCONTENT_SQLFILE_MYSQL;

// Tables created by sql file (without prefix!)
$modversion['tables'][0] = _XCONTENT_TABLE_XCONTENT;
$modversion['tables'][1] = _XCONTENT_TABLE_CATEGORY;
$modversion['tables'][2] = _XCONTENT_TABLE_TEXT;
$modversion['tables'][3] = _XCONTENT_TABLE_BLOCK;

// Admin things
$modversion['hasAdmin']    = _XCONTENT_HASADMIN;
$modversion['adminindex']  = _XCONTENT_ADMIN_INDEX;
$modversion['adminmenu']   = _XCONTENT_ADMIN_MENU;
$modversion['system_menu'] = _XCONTENT_SYSTEM_MENU;
// Search
$modversion['hasSearch']      = _XCONTENT_HASSEARCH;
$modversion['search']['file'] = _XCONTENT_SEARCH_FILE;
$modversion['search']['func'] = _XCONTENT_SEARCH_FUNCTION;

// Comments
$modversion['hasComments']          = _XCONTENT_HASCOMMENT;
$modversion['comments']['itemName'] = _XCONTENT_COMMENT_ITEM;
$modversion['comments']['pageName'] = _XCONTENT_COMMENT_PAGE;

// Menu
$modversion['onInstall'] = _XCONTENT_INSTALL;
$modversion['onUpdate']  = _XCONTENT_UPDATE;

// Menu
$modversion['hasMain'] = _XCONTENT_HASMAIN;

// Smarty
$modversion['use_smarty'] = _XCONTENT_USESMARTY;

// ------------------- Help files ------------------- //
$modversion['helpsection'] = [
    ['name' => _MI_XCONTENT_OVERVIEW, 'link' => 'page=help'],
    ['name' => _MI_XCONTENT_DISCLAIMER, 'link' => 'page=disclaimer'],
    ['name' => _MI_XCONTENT_LICENSE, 'link' => 'page=license'],
    ['name' => _MI_XCONTENT_SUPPORT, 'link' => 'page=support'],
];

// ------------------- Templates ------------------- //

$modversion['templates'] = [
    ['file' => _XCONTENT_TEMPLATE_INDEX, 'description' => _XCONTENT_TEMPLATE_INDEX_DESC],
    ['file' => _XCONTENT_TEMPLATE_BREADCRUMB, 'description' => _XCONTENT_TEMPLATE_BREADCRUMB_DESC],
    ['file' => _XCONTENT_TEMPLATE_CPANEL_ADDEDITPAGE, 'description' => _XCONTENT_TEMPLATE_CPANEL_ADDEDITPAGE_DESC],
    ['file' => _XCONTENT_TEMPLATE_CPANEL_ADDEDITCATEGORY, 'description' => _XCONTENT_TEMPLATE_CPANEL_ADDEDITCATEGORY_DESC],
    ['file' => _XCONTENT_TEMPLATE_CPANEL_ADDEDITBLOCK, 'description' => _XCONTENT_TEMPLATE_CPANEL_ADDEDITBLOCK_DESC],
    ['file' => _XCONTENT_TEMPLATE_INDEX_ADDEDITPAGE, 'description' => _XCONTENT_TEMPLATE_INDEX_ADDEDITPAGE_DESC],
    ['file' => _XCONTENT_TEMPLATE_INDEX_ADDEDITCATEGORY, 'description' => _XCONTENT_TEMPLATE_INDEX_ADDEDITCATEGORY_DESC],
    ['file' => _XCONTENT_TEMPLATE_INDEX_ADDEDITBLOCK, 'description' => _XCONTENT_TEMPLATE_INDEX_ADDEDITBLOCK_DESC],
    ['file' => _XCONTENT_TEMPLATE_CPANEL_JSON_ADDEDITPAGE, 'description' => _XCONTENT_TEMPLATE_CPANEL_JSON_ADDEDITPAGE_DESC],
    ['file' => _XCONTENT_TEMPLATE_CPANEL_JSON_ADDEDITCATEGORY, 'description' => _XCONTENT_TEMPLATE_CPANEL_JSON_ADDEDITCATEGORY_DESC],
    ['file' => _XCONTENT_TEMPLATE_CPANEL_JSON_ADDEDITBLOCK, 'description' => _XCONTENT_TEMPLATE_CPANEL_JSON_ADDEDITBLOCK_DESC],
    ['file' => _XCONTENT_TEMPLATE_INDEX_JSON_ADDEDITPAGE, 'description' => _XCONTENT_TEMPLATE_INDEX_JSON_ADDEDITPAGE_DESC],
    ['file' => _XCONTENT_TEMPLATE_INDEX_JSON_ADDEDITCATEGORY, 'description' => _XCONTENT_TEMPLATE_INDEX_JSON_ADDEDITCATEGORY_DESC],
    ['file' => _XCONTENT_TEMPLATE_INDEX_JSON_ADDEDITBLOCK, 'description' => _XCONTENT_TEMPLATE_INDEX_JSON_ADDEDITBLOCK_DESC],
    ['file' => _XCONTENT_TEMPLATE_INDEX_MANAGE, 'description' => _XCONTENT_TEMPLATE_INDEX_MANAGE_DESC],
    ['file' => _XCONTENT_TEMPLATE_INDEX_PASSWORD, 'description' => _XCONTENT_TEMPLATE_INDEX_PASSWORD_DESC],
];

// Submenu Items
$xcontentHandler = $helper->getHandler(_XCONTENT_CLASS_XCONTENT);
$textHandler     = $helper->getHandler(_XCONTENT_CLASS_TEXT);
$criteria        = new \CriteriaCompo(new \Criteria('homepage', false));
$criteria->add(new \Criteria('submenu', true));
$criteria->add(new \Criteria('parent_id', 0));
$criteria->add(new \Criteria('visible', 1));

$criteria_publish = new \CriteriaCompo(new \Criteria('publish', time(), '<'), 'OR');
$criteria_publish->add(new \Criteria('publish', 0), 'OR');
$criteria_expire = new \CriteriaCompo(new \Criteria('expire', time(), '>'), 'OR');
$criteria_expire->add(new \Criteria('expire', 0), 'OR');

$criteria->add($criteria_publish);
$criteria->add($criteria_expire);

$xcontents = $xcontentHandler->getObjects($criteria, true);

/** @var \XoopsGroupPermHandler $grouppermHandler */
$grouppermHandler = \Xoops::getInstance()->getHandler('groupperm');
$groups           = is_object(\Xoops::getInstance()->user) ? \Xoops::getInstance()->user->getGroups() : [XOOPS_GROUP_ANONYMOUS];
/** @var \XoopsModuleHandler $moduleHandler */
$moduleHandler = \Xoops::getInstance()->getHandler('module');
$xoModule      = $moduleHandler->getByDirname('xcontent');
if ($xoModule) {
    $modid = $xoModule->getVar('mid');

    if ($grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_ADD_XCONTENT, $groups, $modid)) {
        $modversion['sub'][$i]['name'] = _XCONTENT_PERM_TEMPLATE_ADD_XCONTENT_DESC;
        $modversion['sub'][$i]['url']  = 'manage.php?op=' . _XCONTENT_URL_OP_ADD . '&fct=' . _XCONTENT_URL_FCT_XCONTENT;
        ++$i;
    }

    if ($grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_ADD_CATEGORY, $groups, $modid)) {
        $modversion['sub'][$i]['name'] = _XCONTENT_PERM_TEMPLATE_ADD_CATEGORY_DESC;
        $modversion['sub'][$i]['url']  = 'manage.php?op=' . _XCONTENT_URL_OP_ADD . '&fct=' . _XCONTENT_URL_FCT_CATEGORY;
        ++$i;
    }

    if ($grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_ADD_BLOCK, $groups, $modid)) {
        $modversion['sub'][$i]['name'] = _XCONTENT_PERM_TEMPLATE_ADD_BLOCK_DESC;
        $modversion['sub'][$i]['url']  = 'manage.php?op=' . _XCONTENT_URL_OP_ADD . '&fct=' . _XCONTENT_URL_FCT_BLOCKS;
        ++$i;
    }

    if ($grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_MANAGE_XCONTENT, $groups, $modid)) {
        $modversion['sub'][$i]['name'] = _XCONTENT_PERM_TEMPLATE_MANAGE_XCONTENT_DESC;
        $modversion['sub'][$i]['url']  = 'manage.php?op=' . _XCONTENT_URL_OP_MANAGE . '&fct=' . _XCONTENT_URL_FCT_XCONTENT;
        ++$i;
    }

    if ($grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_MANAGE_CATEGORY, $groups, $modid)) {
        $modversion['sub'][$i]['name'] = _XCONTENT_PERM_TEMPLATE_MANAGE_CATEGORY_DESC;
        $modversion['sub'][$i]['url']  = 'manage.php?op=' . _XCONTENT_URL_OP_MANAGE . '&fct=' . _XCONTENT_URL_FCT_CATEGORIES;
        ++$i;
    }

    if ($grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_MANAGE_BLOCK, $groups, $modid)) {
        $modversion['sub'][$i]['name'] = _XCONTENT_PERM_TEMPLATE_MANAGE_BLOCK_DESC;
        $modversion['sub'][$i]['url']  = 'manage.php?op=' . _XCONTENT_URL_OP_MANAGE . '&fct=' . _XCONTENT_URL_FCT_BLOCKS;
        ++$i;
    }

    if ($grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_PERMISSIONS, $groups, $modid)) {
        $modversion['sub'][$i]['name'] = _XCONTENT_PERM_TEMPLATE_PERMISSIONS_DESC;
        $modversion['sub'][$i]['url']  = 'manage.php?op=' . _XCONTENT_URL_OP_PERMISSIONS;
        ++$i;
    }

    foreach ($xcontents as $storyid => $xcontent) {
        if ($grouppermHandler->checkRight(_XCONTENT_PERM_MODE_VIEW . _XCONTENT_PERM_TYPE_XCONTENT, $xcontent->getVar('storyid'), $groups, $modid)
            && $grouppermHandler->checkRight(_XCONTENT_PERM_MODE_VIEW . _XCONTENT_PERM_TYPE_CATEGORY, $xcontent->getVar('catid'), $groups, $modid)) {
            $criteria = new \CriteriaCompo(new \Criteria('storyid', $storyid));
            $criteria->add(new \Criteria('language', \Xoops::getInstance()->getConfig('language')));
            $texts = $textHandler->getObjects($criteria);
            if ($texts) {
                $modversion['sub'][$i]['name'] = $texts[0]->getVar('title');
                $modversion['sub'][$i]['url']  = 'index.php?storyid=' . $storyid . '';
                ++$i;
            }
        }
    }
}

// ------------------- Blocks ------------------- //

$modversion['blocks'][] = [
    'file'        => 'xcontent_block_tag.php',
    'name'        => 'Module Tag Cloud',
    'description' => 'Show tag cloud',
    'show_func'   => 'xcontent_tag_block_cloud_show',
    'edit_func'   => 'xcontent_tag_block_cloud_edit',
    'options'     => '100|0|150|80',
    'template'    => 'xcontent_tag_block_cloud.tpl',
];

$modversion['blocks'][] = [
    'file'        => 'xcontent_block_tag.php',
    'name'        => 'Module Top Tags',
    'description' => 'Show top tags',
    'show_func'   => 'xcontent_tag_block_top_show',
    'edit_func'   => 'xcontent_tag_block_top_edit',
    'options'     => '50|30|c',
    'template'    => 'xcontent_tag_block_top.tpl',
];

$modversion['blocks'][] = [
    'file'        => 'xcontent_block_subitems.php',
    'name'        => 'Subitems Menu for xContent',
    'description' => 'Subitems Menu for xContent',
    'show_func'   => 'xcontent_block_subitems_show',
    'edit_func'   => 'xcontent_block_subitems_edit',
    'options'     => '',
    'template'    => 'xcontent_block_subitems.tpl',
];

$modversion['blocks'][] = [
    'file'        => 'xcontent_block_menu.php',
    'name'        => 'Menu for xContent',
    'description' => 'Menu for xContent',
    'show_func'   => 'xcontent_block_menu_show',
    'edit_func'   => 'xcontent_block_menu_edit',
    'options'     => '',
    'template'    => 'xcontent_block_menu.tpl',
];

$modversion['blocks'][] = [
    'file'        => 'xcontent_block_inheritable.php',
    'name'        => 'Linked Block for xContent',
    'description' => 'Linked Block for xContent',
    'show_func'   => 'xcontent_block_inheritable_show',
    'edit_func'   => 'xcontent_block_inheritable_edit',
    'options'     => '',
    'template'    => 'xcontent_block_inheritable.tpl',
];

$modversion['blocks'][] = [
    'file'        => 'xcontent_block_sections.php',
    'name'        => 'Section Block for xContent',
    'description' => 'Section Block for xContent',
    'show_func'   => 'xcontent_block_sections_show',
    'edit_func'   => 'xcontent_block_sections_edit',
    'options'     => '',
    'template'    => 'xcontent_block_sections.tpl',
];

$editorHandler = \Xoops::getInstance()->getHandler('editor');
$options = array_flip($editorHandler->getList());

$modversion['config'][] = [
    'name'        => 'editor',
    'title'       => '_XCONTENT_EDITORS',
    'description' => '_XCONTENT_EDITORS_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'tinymce',
    'options'     => $options,
];

$modversion['config'][] = [
    'name'        => 'json',
    'title'       => '_XCONTENT_USEJSON',
    'description' => '_XCONTENT_USEJSON_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];

$modversion['config'][] = [
    'name'        => 'rss',
    'title'       => '_XCONTENT_RSSICON',
    'description' => '_XCONTENT_RSSICON_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

$modversion['config'][] = [
    'name'        => 'print',
    'title'       => '_XCONTENT_PRINTICON',
    'description' => '_XCONTENT_PRINTICON_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

$modversion['config'][] = [
    'name'        => 'share',
    'title'       => '_XCONTENT_ADDTHIS',
    'description' => '_XCONTENT_ADDTHISICON_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

$modversion['config'][] = [
    'name'        => 'sharecode',
    'title'       => '_XCONTENT_ADDTHISCODE',
    'description' => '_XCONTENT_ADDTHISCODE_DESC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => '<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style">
<a href="http://www.addthis.com/bookmark.php?v=250&amp;username=xoops" class="addthis_button_compact">Share</a>
<span class="addthis_separator">|</span>
<a class="addthis_button_facebook"></a>
<a class="addthis_button_myspace"></a>
<a class="addthis_button_google"></a>
<a class="addthis_button_twitter"></a>
<a class="addthis_button_email"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xoops"></script>
<!-- AddThis Button END -->
',
];

$modversion['config'][] = [
    'name'        => 'pdf',
    'title'       => '_XCONTENT_PDFICON',
    'description' => '_XCONTENT_PDFICON_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

$modversion['config'][] = [
    'name'        => 'writtenby',
    'title'       => '_XCONTENT_WRITENBY',
    'description' => '_XCONTENT_WRITENBY_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

$modversion['config'][] = [
    'name'        => 'breadcrumb',
    'title'       => '_XCONTENT_BREADCRUMB',
    'description' => '_XCONTENT_BREADCRUMB_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

$modversion['config'][] = [
    'name'        => 'htaccess',
    'title'       => '_XCONTENT_HTACCESS',
    'description' => '_XCONTENT_HTACCESS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];

$modversion['config'][] = [
    'name'        => 'baseurl',
    'title'       => '_XCONTENT_BASEURL',
    'description' => '_XCONTENT_BASEURL_DESC',
    'formtype'    => 'text',
    'valuetype'   => 'text',
    'default'     => 'xcontent',
];

$modversion['config'][] = [
    'name'        => 'endofurl',
    'title'       => '_XCONTENT_ENDOFURL',
    'description' => '_XCONTENT_ENDOFURL_DESC',
    'formtype'    => 'text',
    'valuetype'   => 'text',
    'default'     => '.tpl',
];

$modversion['config'][] = [
    'name'        => 'endofurl_rss',
    'title'       => '_XCONTENT_ENDOFURLRSS',
    'description' => '_XCONTENT_ENDOFURLRSS_DESC',
    'formtype'    => 'text',
    'valuetype'   => 'text',
    'default'     => '.rss',
];

$modversion['config'][] = [
    'name'        => 'endofurl_pdf',
    'title'       => '_XCONTENT_ENDOFURLPDF',
    'description' => '_XCONTENT_ENDOFURLPDF_DESC',
    'formtype'    => 'text',
    'valuetype'   => 'text',
    'default'     => '.pdf',
];

$modversion['config'][] = [
    'name'        => 'force_jquery',
    'title'       => '_XCONTENT_FORCEJQUERY',
    'description' => '_XCONTENT_FORCEJQUERY_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];

$modversion['config'][] = [
    'name'        => 'force_cpanel_jquery',
    'title'       => '_XCONTENT_FORCECPANELJQUERY',
    'description' => '_XCONTENT_FORCECPANELJQUERY_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];

$modversion['config'][] = [
    'name'        => 'security',
    'title'       => '_XCONTENT_SECURITY',
    'description' => '_XCONTENT_SECURITY_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => _XCONTENT_SECURITY_BASIC,
    'options'     => [
        _XCONTENT_SECURITY_BASIC_DESC        => _XCONTENT_SECURITY_BASIC,
        _XCONTENT_SECURITY_INTERMEDIATE_DESC => _XCONTENT_SECURITY_INTERMEDIATE,
        _XCONTENT_SECURITY_ADVANCED_DESC     => _XCONTENT_SECURITY_ADVANCED,
    ],
];

$modversion['config'][] = [
    'name'        => 'multilingual',
    'title'       => '_XCONTENT_MUlTILINGUAL',
    'description' => '_XCONTENT_MUlTILINGUAL_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];

$modversion['config'][] = [
    'name'        => 'tags',
    'title'       => '_XCONTENT_SUPPORTTAGS',
    'description' => '_XCONTENT_SUPPORTTAGS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];

// default admin editor
$editorHandler = \Xoops::getInstance()->getHandler('editor');
$editorList    = array_flip($editorHandler->getList());

$modversion['config'][] = [
    'name'        => 'editorAdmin',
    'title'       => '_MI_XCONTENT_EDITOR_ADMIN',
    'description' => '_MI_XCONTENT_EDITOR_ADMIN_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'dhtmltextarea',
    'options'     => $editorList,
];

$modversion['config'][] = [
    'name'        => 'editorUser',
    'title'       => '_MI_XCONTENT_EDITOR_USER',
    'description' => '_MI_XCONTENT_EDITOR_USER_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'dhtmltextarea',
    'options'     => $editorList,
];

/**
 * Make Sample button visible?
 */
$modversion['config'][] = [
    'name'        => 'displaySampleButton',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

/**
 * Show Developer Tools?
 */
$modversion['config'][] = [
    'name'        => 'displayDeveloperTools',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];
