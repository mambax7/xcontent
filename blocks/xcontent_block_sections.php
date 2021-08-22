<?php

/*
Module: xContent

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

use XoopsModules\Xcontent\Form\FormSelectPages;
use XoopsModules\Xcontent\Helper;

/**
 * @param $storyid
 * @return mixed
 */
function xcontent_block_sections_gettext($storyid)
{
    $helper = Helper::getInstance();
    /** @var \XoopsModules\Xcontent\TextHandler $textHandler */
    $textHandler = $helper->getHandler(_XCONTENT_CLASS_TEXT);
    $criteria    = new \CriteriaCompo(new \Criteria('storyid', $storyid));
    $criteria->add(new \Criteria('language', $GLOBALS['xoopsConfig']['language']));
    $criteria->add(new \Criteria('type', 'xcontent'));
    $texts = $textHandler->getObjects($criteria);
    if ($texts) {
        return $texts[0];
    }
    $criteria = new \CriteriaCompo(new \Criteria('storyid', $storyid));
    $criteria->add(new \Criteria('type', 'xcontent'));
    $texts = $textHandler->getObjects($criteria);
    if ($texts) {
        return $texts[0];
    }
}

/**
 * @param $options
 * @return array|bool
 */
function xcontent_block_sections_show($options)
{
    $helper = Helper::getInstance();
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
    $pages         = [];

    xoops_loadLanguage('modinfo', 'xcontent');

    $children = xcontent_block_sections_getChildrenTree([$options[0]], $options[0]);

    $criteria = new \CriteriaCompo(new \Criteria('parent_id', '(' . implode(',', $children) . ')', 'IN'));
    $criteria->add(new \Criteria('submenu', 1));
    $criteria->add(new \Criteria('visible', 1));

    $criteria_publish = new \CriteriaCompo(new \Criteria('publish', time(), '<'), 'OR');
    $criteria_publish->add(new \Criteria('publish', 0), 'OR');
    $criteria_expire = new \CriteriaCompo(new \Criteria('expire', time(), '>'), 'OR');
    $criteria_expire->add(new \Criteria('expire', 0), 'OR');

    $criteria->add($criteria_publish);
    $criteria->add($criteria_expire);

    $xcontentHandler = $helper->getHandler(_XCONTENT_CLASS_XCONTENT);

    $xcontents = $xcontentHandler->getObjects($criteria, true);
    if ($xcontents) {
        foreach ($xcontents as $storyid => $xcontent) {
            if (_XCONTENT_SECURITY_BASIC != $xoConfig['security']) {
                if ($grouppermHandler->checkRight(_XCONTENT_PERM_MODE_VIEW . _XCONTENT_PERM_TYPE_XCONTENT, $xcontent->getVar('storyid'), $groups, $modid)
                    && $grouppermHandler->checkRight(_XCONTENT_PERM_MODE_VIEW . _XCONTENT_PERM_TYPE_CATEGORY, $xcontent->getVar('catid'), $groups, $modid)) {
                    $pages[$storyid]['storyid'] = $storyid;
                    $pages[$storyid]['catid']   = $xcontent->getVar('catid');
                    $text                       = xcontent_block_sections_gettext($storyid);
                    if ($text) {
                        $pages[$storyid]['ptitle'] = $text->getVar('ptitle');
                        $pages[$storyid]['title']  = $text->getVar('title');
                    }

                    $criteriab = new \CriteriaCompo(new \Criteria('parent_id', $storyid));
                    $criteriab->add(new \Criteria('submenu', 1));
                    $j          = 0;
                    $xcontentsb = $xcontentHandler->getObjects($criteriab, true);
                    if ($xcontentsb) {
                        foreach ($xcontentsb as $storyidb => $xcontentb) {
                            if ($grouppermHandler->checkRight(_XCONTENT_PERM_MODE_VIEW . _XCONTENT_PERM_TYPE_XCONTENT, $xcontentb->getVar('storyid'), $groups, $modid)
                                && $grouppermHandler->checkRight(_XCONTENT_PERM_MODE_VIEW . _XCONTENT_PERM_TYPE_CATEGORY, $xcontentb->getVar('catid'), $groups, $modid)) {
                                ++$j;
                                $pages[$storyid]['sublinks'][$j]['storyid'] = $storyidb;
                                $pages[$storyid]['sublinks'][$j]['catid']   = $xcontentb->getVar('catid');
                                $text                                       = xcontent_block_sections_gettext($storyidb);
                                if ($text) {
                                    $pages[$storyid]['sublinks'][$j]['ptitle'] = $text->getVar('ptitle');
                                    $pages[$storyid]['sublinks'][$j]['title']  = $text->getVar('title');
                                }
                            }
                        }
                    }
                }
            } elseif ($grouppermHandler->checkRight(_XCONTENT_PERM_MODE_VIEW . _XCONTENT_PERM_TYPE_XCONTENT, $xcontent->getVar('storyid'), $groups, $modid)) {
                    $pages[$storyid]['storyid'] = $storyid;
                    $pages[$storyid]['catid']   = $xcontent->getVar('catid');
                    $text                       = xcontent_block_sections_gettext($storyid);
                    if ($text) {
                        $pages[$storyid]['ptitle'] = $text->getVar('ptitle');
                        $pages[$storyid]['title']  = $text->getVar('title');
                    }

                    $criteriab = new \CriteriaCompo(new \Criteria('parent_id', $storyid));
                    $criteriab->add(new \Criteria('submenu', 1));
                    $j          = 0;
                    $xcontentsb = $xcontentHandler->getObjects($criteriab, true);
                    if ($xcontentsb) {
                        foreach ($xcontentsb as $storyidb => $xcontentb) {
                            if ($grouppermHandler->checkRight(_XCONTENT_PERM_MODE_VIEW . _XCONTENT_PERM_TYPE_XCONTENT, $xcontentb->getVar('storyid'), $groups, $modid)) {
                                ++$j;
                                $pages[$storyid]['sublinks'][$j]['storyid'] = $storyidb;
                                $pages[$storyid]['sublinks'][$j]['catid']   = $xcontentb->getVar('catid');
                                $text                                       = xcontent_block_sections_gettext($storyidb);
                                if ($text) {
                                    $pages[$storyid]['sublinks'][$j]['ptitle'] = $text->getVar('ptitle');
                                    $pages[$storyid]['sublinks'][$j]['title']  = $text->getVar('title');
                                }
                            }
                        }
                    }
            }
        }
    }

    if (count($pages)) {
        return ['pages' => $pages];
    }

    return false;
}

/**
 * @param $options
 * @return string
 */
function xcontent_block_sections_edit($options)
{
    xoops_loadLanguage('main', 'xcontent');
    xoops_loadLanguage('modinfo', 'xcontent');
    //    require_once $GLOBALS['xoops']->path('modules/xcontent/include/formselectpages.php');
    if (class_exists(FormSelectPages::class)) {
        $cats = new FormSelectPages(_XCONTENT_AD_PAGE, 'options[]', $options[0]);
        $form .= "<div style='display:block;'>" . _XCONTENT_AD_PAGE . ':' . $cats->render() . '</div>';
    }

    return $form;
}

/**
 * @param     $children
 * @param int $storyid
 * @return mixed
 */
function xcontent_block_sections_getChildrenTree($children, $storyid = 0)
{
    $helper          = Helper::getInstance();
    $xcontentHandler = $helper->getHandler(_XCONTENT_CLASS_XCONTENT);
    $xcontent        = $xcontentHandler->get($storyid);
    if (0 != $xcontent->getVar('parent_id')) {
        $children[$storyid] = $storyid;
        $children           = xcontent_block_sections_getChildrenTree($children, $xcontent->getVar('parent_id'));
    } else {
        $children[$storyid] = $storyid;
    }

    return $children;
}
