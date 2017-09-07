<?php

/*
Module: xContent

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

function xcontent_block_subitems_show($options)
{
    $gpermHandler  = xoops_getHandler('groupperm');
    $configHandler = xoops_getHandler('config');
    $groups        = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : [XOOPS_GROUP_ANONYMOUS];
    /** @var XoopsModuleHandler $moduleHandler */
    $moduleHandler = xoops_getHandler('module');
    $xoModule      = $moduleHandler->getByDirname('xcontent');
    $modid         = $xoModule->getVar('mid');
    $xoConfig      = $configHandler->getConfigList($modid, 0);

    xoops_loadLanguage('modinfo', 'xcontent');

    $criteria = new CriteriaCompo(new Criteria('parent_id', (!isset($_GET['storyid']) ? 0 : $_GET['storyid'])));
    $criteria->add(new Criteria('submenu', 1));
    $criteria->add(new Criteria('visible', 1));

    $criteria_publish = new CriteriaCompo(new Criteria('publish', time(), '<'), 'OR');
    $criteria_publish->add(new Criteria('publish', 0), 'OR');
    $criteria_expire = new CriteriaCompo(new Criteria('expire', time(), '>'), 'OR');
    $criteria_expire->add(new Criteria('expire', 0), 'OR');

    $criteria->add($criteria_publish);
    $criteria->add($criteria_expire);
    $criteria->setSort('weight');

    $xcontentHandler = xoops_getModuleHandler(_XCONTENT_CLASS_XCONTENT, _XCONTENT_DIRNAME);

    if ($xcontents = $xcontentHandler->getObjects($criteria, true)) {
        foreach ($xcontents as $storyid => $xcontent) {
            if ($xoConfig['security'] != _XCONTENT_SECURITY_BASIC) {
                if ($gpermHandler->checkRight(_XCONTENT_PERM_MODE_VIEW . _XCONTENT_PERM_TYPE_XCONTENT, $xcontent->getVar('storyid'), $groups, $modid)
                    && $gpermHandler->checkRight(_XCONTENT_PERM_MODE_VIEW . _XCONTENT_PERM_TYPE_CATEGORY, $xcontent->getVar('catid'), $groups, $modid)) {
                    $pages[$storyid]['storyid'] = $storyid;
                    $pages[$storyid]['catid']   = $xcontent->getVar('catid');
                    if ($text = xcontent_block_subitems_gettext($storyid)) {
                        $pages[$storyid]['ptitle'] = $text->getVar('ptitle');
                        $pages[$storyid]['title']  = $text->getVar('title');
                    }

                    $criteriab = new CriteriaCompo(new Criteria('parent_id', $storyid));
                    $criteriab->add(new Criteria('submenu', 1));
                    if ($xcontentsb = $xcontentHandler->getObjects($criteriab, true)) {
                        foreach ($xcontentsb as $storyidb => $xcontentb) {
                            if ($gpermHandler->checkRight(_XCONTENT_PERM_MODE_VIEW . _XCONTENT_PERM_TYPE_XCONTENT, $xcontentb->getVar('storyid'), $groups, $modid)
                                && $gpermHandler->checkRight(_XCONTENT_PERM_MODE_VIEW . _XCONTENT_PERM_TYPE_CATEGORY, $xcontentb->getVar('catid'), $groups, $modid)) {
                                $pages[$storyid]['sublinks'][$storyidb]['storyid'] = $storyidb;
                                $pages[$storyid]['sublinks'][$storyidb]['catid']   = $xcontentb->getVar('catid');
                                if ($text = xcontent_block_subitems_gettext($storyidb)) {
                                    $pages[$storyid]['sublinks'][$storyidb]['ptitle'] = $text->getVar('ptitle');
                                    $pages[$storyid]['sublinks'][$storyidb]['title']  = $text->getVar('title');
                                }
                            }
                        }
                    }
                }
            } else {
                if ($gpermHandler->checkRight(_XCONTENT_PERM_MODE_VIEW . _XCONTENT_PERM_TYPE_XCONTENT, $xcontent->getVar('storyid'), $groups, $modid)) {
                    $pages[$storyid]['storyid'] = $storyid;
                    $pages[$storyid]['catid']   = $xcontent->getVar('catid');
                    if ($text = xcontent_block_subitems_gettext($storyid)) {
                        $pages[$storyid]['ptitle'] = $text->getVar('ptitle');
                        $pages[$storyid]['title']  = $text->getVar('title');
                    }

                    $criteriab = new CriteriaCompo(new Criteria('parent_id', $storyid));
                    $criteriab->add(new Criteria('submenu', 1));
                    if ($xcontentsb = $xcontentHandler->getObjects($criteriab, true)) {
                        foreach ($xcontentsb as $storyidb => $xcontentb) {
                            if ($gpermHandler->checkRight(_XCONTENT_PERM_MODE_VIEW . _XCONTENT_PERM_TYPE_XCONTENT, $xcontentb->getVar('storyid'), $groups, $modid)) {
                                $pages[$storyid]['sublinks'][$storyidb]['storyid'] = $storyidb;
                                $pages[$storyid]['sublinks'][$storyidb]['catid']   = $xcontentb->getVar('catid');
                                if ($text = xcontent_block_subitems_gettext($storyidb)) {
                                    $pages[$storyid]['sublinks'][$storyidb]['ptitle'] = $text->getVar('ptitle');
                                    $pages[$storyid]['sublinks'][$storyidb]['title']  = $text->getVar('title');
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    if (isset($pages) && count($pages)) {
        return ['pages' => $pages];
    } else {
        return false;
    }
}

function xcontent_block_subitems_edit($options)
{
    return false;
}

function xcontent_block_subitems_gettext($storyid)
{
    $textHandler = xoops_getModuleHandler(_XCONTENT_CLASS_TEXT, _XCONTENT_DIRNAME);
    $criteria    = new CriteriaCompo(new Criteria('storyid', $storyid));
    $criteria->add(new Criteria('language', $GLOBALS['xoopsConfig']['language']));
    $criteria->add(new Criteria('type', 'xcontent'));
    if ($texts = $textHandler->getObjects($criteria)) {
        return $texts[0];
    } else {
        $criteria = new CriteriaCompo(new Criteria('storyid', $storyid));
        $criteria->add(new Criteria('type', 'xcontent'));
        if ($texts = $textHandler->getObjects($criteria)) {
            return $texts[0];
        }
    }
}
