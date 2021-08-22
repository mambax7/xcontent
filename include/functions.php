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

/**
 * @return string
 */
function xcontent_getpostinglocal()
{
    if (0 == mb_strpos($_SERVER['SCRIPT_NAME'], '/admin/index.php')) {
        return '/manage.php';
    }

    return '/admin/index.php';
}

/**
 * @param $op
 * @param $fct
 * @param $storyid
 * @param $catid
 * @param $blockid
 * @param $securitymode
 * @return bool|void
 */
function xcontent_checkperm($op, $fct, $storyid, $catid, $blockid, $securitymode)
{
    /** @var \XoopsGroupPermHandler $grouppermHandler */
    $grouppermHandler = xoops_getHandler('groupperm');
    /** @var \XoopsConfigHandler $configHandler */
    $configHandler = xoops_getHandler('config');
    $groups        = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : [XOOPS_GROUP_ANONYMOUS];
    /** @var \XoopsModuleHandler $moduleHandler */
    $moduleHandler = xoops_getHandler('module');
    $xoModule      = $moduleHandler->getByDirname('xcontent');
    $modid         = $xoModule->getVar('mid');
    $xoConfig      = $configHandler->getConfigList($modid, 0);
    if ('' === $securitymode) {
        $securitymode = $xoConfig['security'];
    }

    switch ($op) {
        case _XCONTENT_URL_OP_SAVE:
            switch ($securitymode) {
                default:
                case _XCONTENT_SECURITY_BASIC:
                    return true;
                    break;
                case _XCONTENT_SECURITY_INTERMEDIATE:
                case _XCONTENT_SECURITY_ADVANCED:
                    switch ($fct) {
                        case _XCONTENT_URL_FCT_PAGES:
                            foreach ($catid as $id => $val) {
                                if (!$grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ADD . _XCONTENT_PERM_TYPE_CATEGORY, $val, $groups, $modid)) {
                                    return false;
                                }
                            }

                            return true;
                            break;
                        case _XCONTENT_URL_FCT_XCONTENT:
                            if (0 == $storyid) {
                                return $grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ADD . _XCONTENT_PERM_TYPE_XCONTENT, $catid, $groups, $modid);
                            }

                            return true;
                            break;
                    }
                    break;
            }
        // no break
        case _XCONTENT_URL_OP_EDIT:
            switch ($securitymode) {
                case _XCONTENT_SECURITY_BASIC:
                case _XCONTENT_SECURITY_INTERMEDIATE:
                    switch ($fct) {
                        case _XCONTENT_URL_FCT_XCONTENT:
                            return $grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_EDIT_XCONTENT, $groups, $modid);
                            break;
                        case _XCONTENT_URL_FCT_CATEGORY:
                        case _XCONTENT_URL_FCT_CATEGORIES:
                            return $grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_EDIT_CATEGORY, $groups, $modid);
                            break;
                        case _XCONTENT_URL_FCT_BLOCK:
                        case _XCONTENT_URL_FCT_BLOCKS:
                            return $grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_EDIT_BLOCK, $groups, $modid);
                            break;
                    }
                    break;
                case _XCONTENT_SECURITY_ADVANCED:
                    switch ($fct) {
                        case _XCONTENT_URL_FCT_XCONTENT:
                            if (!$grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_EDIT_XCONTENT, $groups, $modid)) {
                                return false;
                            }

                            return $grouppermHandler->checkRight(_XCONTENT_PERM_MODE_EDIT . _XCONTENT_PERM_TYPE_XCONTENT, $storyid, $groups, $modid);
                            break;
                        case _XCONTENT_URL_FCT_CATEGORY:
                        case _XCONTENT_URL_FCT_CATEGORIES:
                            if (!$grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_EDIT_CATEGORY, $groups, $modid)) {
                                return false;
                            }

                            return $grouppermHandler->checkRight(_XCONTENT_PERM_MODE_EDIT . _XCONTENT_PERM_TYPE_CATEGORY, $catid, $groups, $modid);
                            break;
                        case _XCONTENT_URL_FCT_BLOCK:
                        case _XCONTENT_URL_FCT_BLOCKS:
                            if ($grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_EDIT_BLOCK, $groups, $modid)) {
                                return false;
                            }

                            return $grouppermHandler->checkRight(_XCONTENT_PERM_MODE_EDIT . _XCONTENT_PERM_TYPE_BLOCK, $blockid, $groups, $modid);
                            break;
                    }
                    break;
            }
        // no break
        case _XCONTENT_URL_OP_ADD:
            switch ($fct) {
                case _XCONTENT_URL_FCT_XCONTENT:
                    return $grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_ADD_XCONTENT, $groups, $modid);
                    break;
                case _XCONTENT_URL_FCT_CATEGORY:
                case _XCONTENT_URL_FCT_CATEGORIES:
                    return $grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_ADD_CATEGORY, $groups, $modid);
                    break;
                case _XCONTENT_URL_FCT_BLOCK:
                case _XCONTENT_URL_FCT_BLOCKS:
                    return $grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_ADD_BLOCK, $groups, $modid);
                    break;
            }
            break;
        case _XCONTENT_URL_OP_DELETE:
            switch ($fct) {
                case _XCONTENT_URL_FCT_XCONTENT:
                    return $grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_DELETE_XCONTENT, $groups, $modid);
                    break;
                case _XCONTENT_URL_FCT_CATEGORY:
                case _XCONTENT_URL_FCT_CATEGORIES:
                    return $grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_DELETE_CATEGORY, $groups, $modid);
                    break;
                case _XCONTENT_URL_FCT_BLOCK:
                case _XCONTENT_URL_FCT_BLOCKS:
                    return $grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_DELETE_BLOCK, $groups, $modid);
                    break;
            }
            break;
        case _XCONTENT_URL_OP_COPY:
            switch ($fct) {
                case _XCONTENT_URL_FCT_XCONTENT:
                    return $grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_COPY_XCONTENT, $groups, $modid);
                    break;
                case _XCONTENT_URL_FCT_CATEGORY:
                case _XCONTENT_URL_FCT_CATEGORIES:
                    return $grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_COPY_CATEGORY, $groups, $modid);
                    break;
                case _XCONTENT_URL_FCT_BLOCK:
                case _XCONTENT_URL_FCT_BLOCKS:
                    return $grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_COPY_BLOCK, $groups, $modid);
                    break;
            }
            break;
        case _XCONTENT_URL_OP_MANAGE:
            switch ($fct) {
                case _XCONTENT_URL_FCT_XCONTENT:
                    return $grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_MANAGE_XCONTENT, $groups, $modid);
                    break;
                case _XCONTENT_URL_FCT_CATEGORY:
                case _XCONTENT_URL_FCT_CATEGORIES:
                    return $grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_MANAGE_CATEGORY, $groups, $modid);
                    break;
                case _XCONTENT_URL_FCT_BLOCKS:
                case _XCONTENT_URL_FCT_BLOCK:
                    return $grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_MANAGE_BLOCK, $groups, $modid);
                    break;
            }
            break;
        case _XCONTENT_URL_OP_PERMISSIONS:
            return $grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, _XCONTENT_PERM_TEMPLATE_PERMISSIONS, $groups, $modid);
            break;
    }
}

/**
 * @param        $currentoption
 * @param string $breadcrumb
 * @return string
 */
function loadUserMenu($currentoption, $breadcrumb = '')
{
    $adminmenu = [];
    $j         = 0;

    $adminmenu[_XCONTENT_PERM_TEMPLATE_MANAGE_XCONTENT]['title'] = _XCONTENT_XCONTENT_ADMENU1;
    $adminmenu[_XCONTENT_PERM_TEMPLATE_MANAGE_XCONTENT]['link']  = 'manage.php?op=' . _XCONTENT_URL_OP_MANAGE . '&fct=' . _XCONTENT_URL_FCT_XCONTENT;
    $adminmenu[_XCONTENT_PERM_TEMPLATE_ADD_XCONTENT]['title']    = _XCONTENT_XCONTENT_ADMENU2;
    $adminmenu[_XCONTENT_PERM_TEMPLATE_ADD_XCONTENT]['link']     = 'manage.php?op=' . _XCONTENT_URL_OP_ADD . '&fct=' . _XCONTENT_URL_FCT_XCONTENT;
    $adminmenu[_XCONTENT_PERM_TEMPLATE_MANAGE_CATEGORY]['title'] = _XCONTENT_XCONTENT_ADMENU3;
    $adminmenu[_XCONTENT_PERM_TEMPLATE_MANAGE_CATEGORY]['link']  = 'manage.php?op=' . _XCONTENT_URL_OP_MANAGE . '&fct=' . _XCONTENT_URL_FCT_CATEGORIES;
    $adminmenu[_XCONTENT_PERM_TEMPLATE_ADD_CATEGORY]['title']    = _XCONTENT_XCONTENT_ADMENU4;
    $adminmenu[_XCONTENT_PERM_TEMPLATE_ADD_CATEGORY]['link']     = 'manage.php?op=' . _XCONTENT_URL_OP_ADD . '&fct=' . _XCONTENT_URL_FCT_CATEGORY;
    $adminmenu[_XCONTENT_PERM_TEMPLATE_MANAGE_BLOCK]['title']    = _XCONTENT_XCONTENT_ADMENU5;
    $adminmenu[_XCONTENT_PERM_TEMPLATE_MANAGE_BLOCK]['link']     = 'manage.php?op=' . _XCONTENT_URL_OP_MANAGE . '&fct=' . _XCONTENT_URL_FCT_BLOCKS;
    $adminmenu[_XCONTENT_PERM_TEMPLATE_ADD_BLOCK]['title']       = _XCONTENT_XCONTENT_ADMENU6;
    $adminmenu[_XCONTENT_PERM_TEMPLATE_ADD_BLOCK]['link']        = 'manage.php?op=' . _XCONTENT_URL_OP_ADD . '&fct=' . _XCONTENT_URL_FCT_BLOCKS;
    $adminmenu[_XCONTENT_PERM_TEMPLATE_PERMISSIONS]['title']     = _XCONTENT_XCONTENT_ADMENU7;
    $adminmenu[_XCONTENT_PERM_TEMPLATE_PERMISSIONS]['link']      = 'manage.php?op=' . _XCONTENT_URL_OP_PERMISSIONS . '&fct=' . _XCONTENT_URL_FCT_TEMPLATE . '&mode=' . _XCONTENT_PERM_MODE_ALL;

    //    $breadcrumb  = empty($breadcrumb) ? $adminmenu[$currentoption]['title'] : $breadcrumb;
    $breadcrumb  = empty($breadcrumb) ? array_values($adminmenu)[$currentoption - 1]['title'] : $breadcrumb;
    $module_link = XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/';
    $image_link  = XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/images';

    $adminMenu_text = '
        <style type="text/css">
        <!--
        #buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0;}
        #buttonbar { float:left; width:100%; background: #e7e7e7 url("' . $image_link . '/modadminbg.gif") repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px;}
        #buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
        #buttonbar li { display:inline; margin:0; padding:0; }
        #buttonbar a { float:left; background:url("' . $image_link . '/left_both.gif") no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }
        #buttonbar a span { float:left; display:block; background:url("' . $image_link . '/right_both.gif") no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
        /* Commented Backslash Hack hides rule from IE5-Mac \*/
        #buttonbar a span {float:none;}
        /* End IE5-Mac hack */
        #buttonbar a:hover span { color:#333; }
        #buttonbar .current a { background-position:0 -150px; border-width:0; }
        #buttonbar .current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
        #buttonbar a:hover { background-position:0% -150px; }
        #buttonbar a:hover span { background-position:100% -150px; }
        //-->
        </style>
        <div id="buttontop">
         <table style="width: 100%; padding: 0; " cellspacing="0">
             <tr>
                 <td style="width: 70%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;">
                     <a href="index.php">' . $GLOBALS['xoopsModule']->getVar('name') . '</a>
                 </td>
                 <td style="width: 30%; font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;">
                     <strong>' . $GLOBALS['xoopsModule']->getVar('name') . '</strong>&nbsp;' . $breadcrumb . '
                 </td>
             </tr>
         </table>
        </div>
        <div id="buttonbar">
         <ul>
        ';

    /** @var \XoopsGroupPermHandler $grouppermHandler */
    $grouppermHandler = xoops_getHandler('groupperm');
    $groups           = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : [XOOPS_GROUP_ANONYMOUS];
    /** @var \XoopsModuleHandler $moduleHandler */
    $moduleHandler = xoops_getHandler('module');
    $xoModule      = $moduleHandler->getByDirname(_XCONTENT_DIRNAME);
    $modid         = $xoModule->getVar('mid');

    foreach (array_keys($adminmenu) as $key) {
        $j++;
        if ($grouppermHandler->checkRight(_XCONTENT_PERM_MODE_ALL . _XCONTENT_PERM_TYPE_TEMPLATE, $key, $groups, $modid)) {
            $adminMenu_text .= (($currentoption == $j) ? '<li class="current">' : '<li>') . '<a href="' . $module_link . $adminmenu[$key]['link'] . '"><span>' . $adminmenu[$key]['title'] . '</span></a></li>';
        }
    }
    $adminMenu_text .= '</ul>
        </div>
        <br style="clear:both;">';

    return $adminMenu_text;
}

if (!function_exists('xoops_sef')) {
    /**
     * @param        $datab
     * @param string $char
     * @return string
     */
    function xoops_sef($datab, $char = '-')
    {
        $datab             = urldecode(mb_strtolower($datab));
        $datab             = urlencode($datab);
        $datab             = str_replace(urlencode('æ'), 'ae', $datab);
        $datab             = str_replace(urlencode('ø'), 'oe', $datab);
        $datab             = str_replace(urlencode('å'), 'aa', $datab);
        $replacement_chars = [
            ' ',
            '|',
            '=',
            '\\',
            '+',
            '-',
            '_',
            '{',
            '}',
            ']',
            '[',
            '\'',
            '"',
            ';',
            ':',
            '?',
            '>',
            '<',
            '.',
            ',',
            ')',
            '(',
            '*',
            '&',
            '^',
            '%',
            '$',
            '#',
            '@',
            '!',
            '`',
            '~',
            ' ',
            '',
            '¡',
            '¦',
            '§',
            '¨',
            '©',
            'ª',
            '«',
            '¬',
            '®',
            '­',
            '¯',
            '°',
            '±',
            '²',
            '³',
            '´',
            'µ',
            '¶',
            '·',
            '¸',
            '¹',
            'º',
            '»',
            '¼',
            '½',
            '¾',
            '¿',
        ];
        $return_data       = str_replace($replacement_chars, $char, urldecode($datab));
        #print $return_data."<br><br>";
        switch ($char) {
            default:
                return urldecode($return_data);
                break;
            case '-':

                return urlencode($return_data);
                break;
        }
    }
}

if (!function_exists('clear_unicodeslashes')) {
    /**
     * @param $text
     * @return array|string|string[]
     */
    function clear_unicodeslashes($text)
    {
        $text = str_replace(["\\'"], "'", $text);
        $text = str_replace(["\\\\\\'"], "'", $text);
        $text = str_replace(['\\"'], '"', $text);

        return $text;
    }
}

/**
 * @param $storyid
 * @return array
 */
function xcontent_getBreadcrumb($storyid)
{
    $helper          = Helper::getInstance();
    $xcontentHandler = $helper->getHandler(_XCONTENT_CLASS_XCONTENT);
    $xcontent        = $xcontentHandler->get($storyid);
    if (0 != $xcontent->getVar('parent_id')) {
        $children = xcontent_getChildrenTree([], $storyid);
    } else {
        $children = [0 => $storyid];
    }

    $crumb = [];
    $j     = 0;
    foreach (array_reverse($children) as $storyid) {
        ++$j;
        $crumb[$storyid]['title']  = xcontent_getField($storyid, 'title');
        $crumb[$storyid]['ptitle'] = xcontent_getField($storyid, 'ptitle');
        $crumb[$storyid]['url']    = XOOPS_URL . '/modules/xcontent/?storyid=' . $storyid;
        if ($j == count($children)) {
            $crumb[$storyid]['last'] = true;
        }
    }

    return $crumb;
}

/**
 * @param     $children
 * @param int $storyid
 * @return mixed
 */
function xcontent_getChildrenTree($children, $storyid = 0)
{
    $helper          = Helper::getInstance();
    $xcontentHandler = $helper->getHandler(_XCONTENT_CLASS_XCONTENT);
    $xcontent        = $xcontentHandler->get($storyid);
    if (0 != $xcontent->getVar('parent_id')) {
        $children[$storyid] = $storyid;
        $children           = xcontent_getChildrenTree($children, $xcontent->getVar('parent_id'));
    } else {
        $children[$storyid] = $storyid;
    }

    return $children;
}

/**
 * @return string
 */
function xcontent_passkey()
{
    return md5(sha1(XOOPS_LICENSE_KEY) . date('Ymd'));
}

/**
 * @param $storyid
 * @return mixed|string
 */
function xcontent_getPageTitle($storyid)
{
    $helper          = Helper::getInstance();
    $xcontentHandler = $helper->getHandler(_XCONTENT_CLASS_XCONTENT);
    $xcontent        = $xcontentHandler->get($storyid);
    if ($xcontent->getVar('catid') > 0) {
        return xcontent_getTitle($storyid) . _XCONTENT_PAGETITLESEP . xcontent_getCatTitle($xcontent->getVar('catid'));
    }

    return xcontent_getTitle($storyid);
}

/**
 * @param $storyid
 * @return mixed|string
 */
function xcontent_getMetaKeywords($storyid)
{
    $helper          = Helper::getInstance();
    $xcontentHandler = $helper->getHandler(_XCONTENT_CLASS_XCONTENT);
    $xcontent        = $xcontentHandler->get($storyid);
    if ($xcontent->getVar('catid') > 0) {
        return xcontent_getField($storyid, 'keywords') . ', ' . xcontent_getCatField($xcontent->getVar('catid'), 'keywords');
    }

    return xcontent_getField($storyid, 'keywords');
}

/**
 * @param $storyid
 * @return mixed|string
 */
function xcontent_getMetaDescription($storyid)
{
    $helper          = Helper::getInstance();
    $xcontentHandler = $helper->getHandler(_XCONTENT_CLASS_XCONTENT);
    $xcontent        = $xcontentHandler->get($storyid);
    if ($xcontent->getVar('catid') > 0) {
        $catid = $xcontent->getVar('catid');
        $desc  = xcontent_getField($storyid, 'page_description');
        if (empty($desc)) {
            return xcontent_getCatField($catid, 'page_description');
        }

        return $desc;
    }

    return xcontent_getField($storyid, 'page_description');
}

/**
 * @param $storyid
 * @return mixed
 */
function xcontent_getTitle($storyid)
{
    $helper      = Helper::getInstance();
    $textHandler = $helper->getHandler(_XCONTENT_CLASS_TEXT);
    $criteria    = new \CriteriaCompo(new \Criteria('storyid', $storyid));
    $criteria->add(new \Criteria('language', $GLOBALS['xoopsConfig']['language']));
    $criteria->add(new \Criteria('type', _XCONTENT_ENUM_TYPE_XCONTENT));
    $texts = $textHandler->getObjects($criteria);
    if ($texts) {
        return $texts[0]->getVar('title');
    }
    $criteria = new \CriteriaCompo(new \Criteria('storyid', $storyid));
    $criteria->add(new \Criteria('type', _XCONTENT_ENUM_TYPE_XCONTENT));
    $texts = $textHandler->getObjects($criteria);
    if ($texts) {
        return $texts[0]->getVar('title');
    }

    return _XCONTENT_NOTITLESPECIFIED;
}

/**
 * @param $blockid
 * @return mixed
 */
function xcontent_getBlockTitle($blockid)
{
    $helper      = Helper::getInstance();
    $textHandler = $helper->getHandler(_XCONTENT_CLASS_TEXT);
    $criteria    = new \CriteriaCompo(new \Criteria('blockid', $blockid));
    $criteria->add(new \Criteria('language', $GLOBALS['xoopsConfig']['language']));
    $criteria->add(new \Criteria('type', _XCONTENT_ENUM_TYPE_BLOCK));
    $texts = $textHandler->getObjects($criteria);
    if ($texts) {
        return $texts[0]->getVar('title');
    }
    $criteria = new \CriteriaCompo(new \Criteria('blockid', $blockid));
    $criteria->add(new \Criteria('type', _XCONTENT_ENUM_TYPE_BLOCK));
    $texts = $textHandler->getObjects($criteria);
    if ($texts) {
        return $texts[0]->getVar('title');
    }

    return _XCONTENT_NOTITLESPECIFIED;
}

/**
 * @param $catid
 * @return mixed
 */
function xcontent_getCatTitle($catid)
{
    $helper      = Helper::getInstance();
    $textHandler = $helper->getHandler(_XCONTENT_CLASS_TEXT);
    $criteria    = new \CriteriaCompo(new \Criteria('catid', $catid));
    $criteria->add(new \Criteria('type', _XCONTENT_ENUM_TYPE_CATEGORY));
    $criteria->add(new \Criteria('language', $GLOBALS['xoopsConfig']['language']));
    $texts = $textHandler->getObjects($criteria);
    if ($texts) {
        return $texts[0]->getVar('title');
    }
    $criteria = new \CriteriaCompo(new \Criteria('catid', $catid));
    $criteria->add(new \Criteria('type', _XCONTENT_ENUM_TYPE_CATEGORY));
    $texts = $textHandler->getObjects($criteria);
    if ($texts) {
        return $texts[0]->getVar('title');
    }

    return _XCONTENT_NOTCATITLESPECIFIED;
}

/**
 * @param $storyid
 * @param $field
 * @return mixed|string
 */
function xcontent_getField($storyid, $field)
{
    $helper      = Helper::getInstance();
    $textHandler = $helper->getHandler(_XCONTENT_CLASS_TEXT);
    $criteria    = new \CriteriaCompo(new \Criteria('storyid', $storyid));
    $criteria->add(new \Criteria('language', $GLOBALS['xoopsConfig']['language']));
    $criteria->add(new \Criteria('type', _XCONTENT_ENUM_TYPE_XCONTENT));
    $texts = $textHandler->getObjects($criteria);
    if ($texts) {
        return clear_unicodeslashes($texts[0]->getVar($field));
    }
    $criteria = new \CriteriaCompo(new \Criteria('storyid', $storyid));
    $criteria->add(new \Criteria('type', _XCONTENT_ENUM_TYPE_XCONTENT));
    $texts = $textHandler->getObjects($criteria);
    if ($texts) {
        return clear_unicodeslashes($texts[0]->getVar($field));
    }

    return '';
}

/**
 * @param $catid
 * @param $field
 * @return mixed|string
 */
function xcontent_getCatField($catid, $field)
{
    $helper      = Helper::getInstance();
    $textHandler = $helper->getHandler(_XCONTENT_CLASS_TEXT);
    $criteria    = new \CriteriaCompo(new \Criteria('catid', $catid));
    $criteria->add(new \Criteria('type', _XCONTENT_ENUM_TYPE_CATEGORY));
    $criteria->add(new \Criteria('language', $GLOBALS['xoopsConfig']['language']));
    $texts = $textHandler->getObjects($criteria);
    if ($texts) {
        return clear_unicodeslashes($texts[0]->getVar($field));
    }
    $criteria = new \CriteriaCompo(new \Criteria('catid', $catid));
    $criteria->add(new \Criteria('type', _XCONTENT_ENUM_TYPE_CATEGORY));
    $texts = $textHandler->getObjects($criteria);
    if ($texts) {
        return clear_unicodeslashes($texts[0]->getVar($field));
    }

    return '';
}

/**
 * @param $blockid
 * @param $field
 * @return mixed|string
 */
function xcontent_getBlockField($blockid, $field)
{
    $helper      = Helper::getInstance();
    $textHandler = $helper->getHandler(_XCONTENT_CLASS_TEXT);
    $criteria    = new \CriteriaCompo(new \Criteria('blockid', $blockid));
    $criteria->add(new \Criteria('type', _XCONTENT_ENUM_TYPE_BLOCK));
    $criteria->add(new \Criteria('language', $GLOBALS['xoopsConfig']['language']));
    $texts = $textHandler->getObjects($criteria);
    if ($texts) {
        return clear_unicodeslashes($texts[0]->getVar($field));
    }
    $criteria = new \CriteriaCompo(new \Criteria('blockid', $blockid));
    $criteria->add(new \Criteria('type', _XCONTENT_ENUM_TYPE_BLOCK));
    $texts = $textHandler->getObjects($criteria);
    if ($texts) {
        return clear_unicodeslashes($texts[0]->getVar($field));
    }

    return '';
}
