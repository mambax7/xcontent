<?php

/*
Module: xContent

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

include __DIR__ . '/header.php';

$GLOBALS['xoopsOption']['template_main'] = _XCONTENT_TEMPLATE_INDEX_MANAGE;

if (!xcontent_checkperm($op, $fct, $storyid, $catid, $blockid, $mode, $GLOBALS['xoopsModuleConfig']['security'])) {
    redirect_header(XOOPS_URL, 6, _XCONTENT_NOPERMISSIONS);
    exit(0);
}

switch ($op) {
    case _XCONTENT_URL_OP_SAVE:
        switch ($fct) {
            case _XCONTENT_URL_FCT_PAGES:

                foreach ($_POST as $id => $val) {
                    ${$id} = $val;
                }

                $xcontentHandler = xoops_getModuleHandler(_XCONTENT_CLASS_XCONTENT, _XCONTENT_DIRNAME);

                foreach ($catid as $storyid => $val) {
                    $xcontent = $xcontentHandler->get($storyid);

                    $xcontent->setVar('catid', $catid[$storyid]);
                    $xcontent->setVar('parent_id', $parent_id[$storyid]);
                    $xcontent->setVar('submenu', $submenu[$storyid]);
                    $xcontent->setVar('weight', $weight[$storyid]);

                    if ($homepage[$storyid] === true) {
                        $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix(_XCONTENT_TABLE_XCONTENT) . ' SET homepage=0';
                        @$GLOBALS['xoopsDB']->queryF($sql);
                    }

                    $xcontent->setVar('homepage', $homepage[$storyid]);
                    @$xcontentHandler->insert($xcontent);
                }

                redirect_header('manage.php?op=' . _XCONTENT_URL_OP_MANAGE . '&fct=' . _XCONTENT_URL_FCT_XCONTENT, 7, _XCONTENT_MSG_XCONTENTSAVED);
                exit(0);
                break;

            case _XCONTENT_URL_FCT_CATEGORIES:

                foreach ($_POST as $id => $val) {
                    ${$id} = $val;
                }

                $categoryHandler = xoops_getModuleHandler(_XCONTENT_CLASS_CATEGORY, _XCONTENT_DIRNAME);

                foreach ($parent_id as $catid => $val) {
                    $category = $categoryHandler->get($catid);

                    $category->setVar('parent_id', $parent_id[$catid]);
                    $category->setVar('rssenabled', $rssenabled[$catid]);

                    @$categoryHandler->insert($category);
                }

                redirect_header('manage.php?op=' . _XCONTENT_URL_OP_MANAGE . '&fct=' . _XCONTENT_URL_FCT_CATEGORIES, 7, _XCONTENT_MSG_XCONTENTSAVED);
                exit(0);
                break;

            case _XCONTENT_URL_FCT_BLOCKS:

                foreach ($_POST as $id => $val) {
                    ${$id} = $val;
                }

                $blockHandler = xoops_getModuleHandler(_XCONTENT_CLASS_BLOCK, _XCONTENT_DIRNAME);

                if ($blockid == 0) {
                    $block = $blockHandler->createnew();
                } else {
                    $block = $blockHandler->getBlock($blockid, $language);
                }

                if ($block['block']->isNew()) {
                    $block['block']->setVar('created', time());
                }
                $block['block']->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'), true);

                if ($blockHandler->insert($block['block'])) {
                    $textHandler = xoops_getModuleHandler(_XCONTENT_CLASS_TEXT, _XCONTENT_DIRNAME);
                    $block['text']->setVar('type', _XCONTENT_ENUM_TYPE_BLOCK);
                    $block['text']->setVar('blockid', $block['block']->getVar('blockid'));
                    if (!empty($language)) {
                        $block['text']->setVar('language', $language);
                    }
                    if (!empty($title)) {
                        $block['text']->setVar('title', $title);
                    }
                    if (!empty($ptitle)) {
                        $block['text']->setVar('ptitle', $ptitle);
                    }
                    if (!empty($text)) {
                        $block['text']->setVar('text', $text);
                    }
                    if (!empty($keywords)) {
                        $block['text']->setVar('keywords', $keywords);
                    }
                    if (!empty($rss)) {
                        $block['text']->setVar('rss', $rss);
                    }
                    if (!empty($page_description)) {
                        $block['text']->setVar('page_description', $page_description);
                    }
                    if ($textHandler->insert($block['text'])) {
                        redirect_header('manage.php?op=' . _XCONTENT_URL_OP_MANAGE . '&fct=' . _XCONTENT_URL_FCT_BLOCKS, 6, _XCONTENT_MSG_BLOCKSAVED);
                    } else {
                        redirect_header('manage.php?op=' . _XCONTENT_URL_OP_MANAGE . '&fct=' . _XCONTENT_URL_FCT_BLOCKS, 6, _XCONTENT_MSG_BLOCKNOTSAVED);
                    }
                } else {
                    redirect_header('manage.php?op=' . _XCONTENT_URL_OP_MANAGE . '&fct=' . _XCONTENT_URL_FCT_BLOCKS, 6, _XCONTENT_MSG_BLOCKNOTSAVED);
                }
                exit(0);
                break;

            case _XCONTENT_URL_FCT_CATEGORY:

                foreach ($_POST as $id => $val) {
                    ${$id} = $val;
                }

                $categoryHandler = xoops_getModuleHandler(_XCONTENT_CLASS_CATEGORY, _XCONTENT_DIRNAME);

                if ($catid == 0) {
                    $category = $categoryHandler->createnew();
                } else {
                    $category = $categoryHandler->getCategory($catid, $language);
                }

                if (!empty($rssenabled)) {
                    $category['cat']->setVar('rssenabled', $rssenabled);
                }
                if (!empty($parent_id)) {
                    $category['cat']->setVar('parent_id', $parent_id, true);
                }

                if ($categoryHandler->insert($category['cat'])) {
                    $textHandler = xoops_getModuleHandler(_XCONTENT_CLASS_TEXT, _XCONTENT_DIRNAME);
                    $category['text']->setVar('type', _XCONTENT_ENUM_TYPE_CATEGORY);
                    $category['text']->setVar('catid', $category['cat']->getVar('catid'));
                    if (!empty($language)) {
                        $category['text']->setVar('language', $language);
                    }
                    if (!empty($title)) {
                        $category['text']->setVar('title', $title);
                    }
                    if (!empty($ptitle)) {
                        $category['text']->setVar('ptitle', $ptitle);
                    }
                    if (!empty($text)) {
                        $category['text']->setVar('text', $text);
                    }
                    if (!empty($keywords)) {
                        $category['text']->setVar('keywords', $keywords);
                    }
                    if (!empty($rss)) {
                        $category['text']->setVar('rss', $rss);
                    }
                    if (!empty($page_description)) {
                        $category['text']->setVar('page_description', $page_description);
                    }
                    if ($textHandler->insert($category['text'])) {
                        redirect_header('manage.php?op=' . _XCONTENT_URL_OP_MANAGE . '&fct=' . _XCONTENT_URL_FCT_CATEGORIES, 6, _XCONTENT_MSG_CATEGORYSAVED);
                    } else {
                        redirect_header('manage.php?op=' . _XCONTENT_URL_OP_MANAGE . '&fct=' . _XCONTENT_URL_FCT_CATEGORIES, 6, _XCONTENT_MSG_CATEGORYNOTSAVED);
                    }
                } else {
                    redirect_header('manage.php?op=' . _XCONTENT_URL_OP_MANAGE . '&fct=' . _XCONTENT_URL_FCT_CATEGORIES, 6, _XCONTENT_MSG_CATEGORYNOTSAVED);
                }
                exit(0);
                break;

            case _XCONTENT_URL_FCT_XCONTENT:

                foreach ($_POST as $id => $val) {
                    ${$id} = $val;
                }

                if ($homepage === true) {
                    $sql = 'UPDATE ' . $GLOBALS['xoopsDB']->prefix(_XCONTENT_TABLE_XCONTENT) . ' SET homepage=0';
                    @$GLOBALS['xoopsDB']->queryF($sql);
                }

                $xcontentHandler = xoops_getModuleHandler(_XCONTENT_CLASS_XCONTENT, _XCONTENT_DIRNAME);
                $textHandler     = xoops_getModuleHandler(_XCONTENT_CLASS_TEXT, _XCONTENT_DIRNAME);

                if ($storyid == 0) {
                    $xcontent = $xcontentHandler->createnew();
                } else {
                    $xcontent = $xcontentHandler->getContent($storyid, $language);
                }

                $xcontent['xcontent']->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
                $xcontent['xcontent']->setVar('parent_id', $parent_id);
                $xcontent['xcontent']->setVar('blockid', $blockid);
                $xcontent['xcontent']->setVar('catid', $catid);
                $xcontent['xcontent']->setVar('weight', $weight);
                $xcontent['xcontent']->setVar('visible', $visible);
                $xcontent['xcontent']->setVar('homepage', $homepage);
                $xcontent['xcontent']->setVar('nohtml', $nohtml);
                $xcontent['xcontent']->setVar('nosmiley', $nosmiley);
                $xcontent['xcontent']->setVar('nobreaks', $nobreaks);
                $xcontent['xcontent']->setVar('nocomments', $nocomments);
                $xcontent['xcontent']->setVar('link', $link);
                if (!empty($address)) {
                    $xcontent['xcontent']->setVar('address', $address);
                }
                $xcontent['xcontent']->setVar('submenu', $submenu);
                $xcontent['xcontent']->setVar('date', time());
                $xcontent['xcontent']->setVar('assoc_module', $assoc_module);
                if (!empty($password) && $passset && $password == $password_confirm) {
                    $xcontent['xcontent']->setVar('password', md5($password));
                } elseif (empty($password) && $passset) {
                    $xcontent['xcontent']->setVar('password', '');
                }

                if ($publishset) {
                    $xcontent['xcontent']->setVar('publish', strtotime($publish['date']) + $publish['time']);
                    $xcontent['xcontent']->setVar('publish_storyid', $publish_storyid);
                } else {
                    $xcontent['xcontent']->setVar('publish', 0);
                    $xcontent['xcontent']->setVar('publish_storyid', 0);
                }
                if ($expireset) {
                    $xcontent['xcontent']->setVar('expire', strtotime($expire['date']) + $expire['time']);
                    $xcontent['xcontent']->setVar('expire_storyid', $expires_storyid);
                } else {
                    $xcontent['xcontent']->setVar('expire', 0);
                    $xcontent['xcontent']->setVar('expire_storyid', 0);
                }

                if (!empty($tags)) {
                    $xcontent['xcontent']->setVar('tags', $tags);
                }
                if ($xcontentHandler->insert($xcontent['xcontent'])) {
                    $xcontent['text']->setVar('type', _XCONTENT_ENUM_TYPE_XCONTENT);
                    $xcontent['text']->setVar('storyid', $xcontent['xcontent']->getVar('storyid'));
                    if (!empty($language)) {
                        $xcontent['text']->setVar('language', $language);
                    }
                    if (!empty($title)) {
                        $xcontent['text']->setVar('title', $title);
                    }
                    if (!empty($ptitle)) {
                        $xcontent['text']->setVar('ptitle', $ptitle);
                    }
                    if (!empty($text)) {
                        $xcontent['text']->setVar('text', $text);
                    }
                    if (!empty($keywords)) {
                        $xcontent['text']->setVar('keywords', $keywords);
                    }
                    if (!empty($rss)) {
                        $xcontent['text']->setVar('rss', $rss);
                    }
                    if (!empty($page_description)) {
                        $xcontent['text']->setVar('page_description', $page_description);
                    }
                    if ($textHandler->insert($xcontent['text'])) {
                        $values['innerhtml']['forms'] = xcontent_addxcontent($xcontent['xcontent']->getVar('storyid'), $language);
                    }
                }

                if (file_exists($GLOBALS['xoops']->path('modules/tag/class/tag.php'))
                    && $GLOBALS['xoopsModuleConfig']['tags']) {
                    $tagHandler = xoops_getModuleHandler('tag', 'tag');
                    $tagHandler->updateByItem($_POST['tags'], $xcontent['xcontent']->getVar('storyid'), $GLOBALS['xoopsModule']->getVar('dirname'), $xcontent['xcontent']->getVar('catid'));
                }

                redirect_header('manage.php?op=' . _XCONTENT_URL_OP_EDIT . '&fct=' . _XCONTENT_URL_FCT_XCONTENT . '&storyid=' . $xcontent['xcontent']->getVar('storyid') . '&language=' . $xcontent['text']->getVar('language'), 7, _XCONTENT_MSG_XCONTENTSAVED);
                exit(0);

                break;

        }
        break;
    case _XCONTENT_URL_OP_EDIT:
        switch ($fct) {
            case _XCONTENT_URL_FCT_XCONTENT:
                if ($GLOBALS['xoopsModuleConfig']['json']) {
                    $GLOBALS['xoopsOption']['template_main'] = _XCONTENT_TEMPLATE_INDEX_JSON_ADDEDITPAGE;
                } else {
                    $GLOBALS['xoopsOption']['template_main'] = _XCONTENT_TEMPLATE_INDEX_ADDEDITPAGE;
                }
                require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_HEADER);
                $GLOBALS['xoopsTpl']->assign('usermenu', loadUserMenu(2, ''));
                if ($GLOBALS['xoopsModuleConfig']['json']) {
                    $GLOBALS['xoTheme']->addScript(XOOPS_URL . _XCONTENT_PATH_JS_CORE);
                }
                if ($GLOBALS['xoopsModuleConfig']['force_jquery']) {
                    $GLOBALS['xoTheme']->addScript(XOOPS_URL . _XCONTENT_PATH_JS_JQUERY);
                }

                $GLOBALS['xoopsTpl']->assign('passkey', xcontent_passkey());
                $GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
                $GLOBALS['xoopsTpl']->assign('xoModule', $GLOBALS['xoopsModule']->toArray());
                $xcontentHandler = xoops_getModuleHandler(_XCONTENT_CLASS_XCONTENT, _XCONTENT_DIRNAME);
                $xcontent        = $xcontentHandler->getContent($storyid, $_GET['language']);
                $GLOBALS['xoopsTpl']->assign('xcontent', array_merge($xcontent['xcontent']->toArray(), $xcontent['text']->toArray()));
                $GLOBALS['xoopsTpl']->assign('form', xcontent_addxcontent($storyid, $_GET['language']));
                $GLOBALS['xoopsTpl']->assign('storyid', $_GET['storyid']);
                require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FOOTER);
                break;
            case _XCONTENT_URL_FCT_CATEGORY:
                if ($GLOBALS['xoopsModuleConfig']['json']) {
                    $GLOBALS['xoopsOption']['template_main'] = _XCONTENT_TEMPLATE_INDEX_JSON_ADDEDITCATEGORY;
                } else {
                    $GLOBALS['xoopsOption']['template_main'] = _XCONTENT_TEMPLATE_INDEX_ADDEDITCATEGORY;
                }
                require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_HEADER);
                $GLOBALS['xoopsTpl']->assign('usermenu', loadUserMenu(4, ''));
                if ($GLOBALS['xoopsModuleConfig']['json']) {
                    $GLOBALS['xoTheme']->addScript(XOOPS_URL . _XCONTENT_PATH_JS_CORE);
                }
                if ($GLOBALS['xoopsModuleConfig']['force_jquery']) {
                    $GLOBALS['xoTheme']->addScript(XOOPS_URL . _XCONTENT_PATH_JS_JQUERY);
                }

                $GLOBALS['xoopsTpl']->assign('passkey', xcontent_passkey());
                $GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
                $GLOBALS['xoopsTpl']->assign('xoModule', $GLOBALS['xoopsModule']->toArray());
                $categoryHandler = xoops_getModuleHandler(_XCONTENT_CLASS_CATEGORY, _XCONTENT_DIRNAME);
                $category        = $categoryHandler->getCategory($catid, $_GET['language']);
                $GLOBALS['xoopsTpl']->assign('category', array_merge($category['cat']->toArray(), $category['text']->toArray()));
                $GLOBALS['xoopsTpl']->assign('form', xcontent_addcategory($catid, $language));
                require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FOOTER);
                break;

            case _XCONTENT_URL_FCT_BLOCKS:
                if ($GLOBALS['xoopsModuleConfig']['json']) {
                    $GLOBALS['xoopsOption']['template_main'] = _XCONTENT_TEMPLATE_INDEX_JSON_ADDEDITBLOCK;
                } else {
                    $GLOBALS['xoopsOption']['template_main'] = _XCONTENT_TEMPLATE_INDEX_ADDEDITBLOCK;
                }
                require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_HEADER);
                $GLOBALS['xoopsTpl']->assign('usermenu', loadUserMenu(6, ''));
                if ($GLOBALS['xoopsModuleConfig']['json']) {
                    $GLOBALS['xoTheme']->addScript(XOOPS_URL . _XCONTENT_PATH_JS_CORE);
                }
                if ($GLOBALS['xoopsModuleConfig']['force_jquery']) {
                    $GLOBALS['xoTheme']->addScript(XOOPS_URL . _XCONTENT_PATH_JS_JQUERY);
                }

                $GLOBALS['xoopsTpl']->assign('passkey', xcontent_passkey());
                $GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
                $GLOBALS['xoopsTpl']->assign('xoModule', $GLOBALS['xoopsModule']->toArray());
                $blockHandler = xoops_getModuleHandler(_XCONTENT_CLASS_BLOCK, _XCONTENT_DIRNAME);
                $block        = $blockHandler->getBlock($blockid, $_GET['language']);
                $GLOBALS['xoopsTpl']->assign('block', array_merge($block['block']->toArray(), $block['text']->toArray()));
                $GLOBALS['xoopsTpl']->assign('form', xcontent_addblock($blockid, $language));
                require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FOOTER);
                break;

        }
        break;

    case _XCONTENT_URL_OP_ADD:
        switch ($fct) {
            case _XCONTENT_URL_FCT_XCONTENT:
                $categoryHandler = xoops_getModuleHandler(_XCONTENT_CLASS_CATEGORY, _XCONTENT_DIRNAME);
                if ($categoryHandler->getCount(null) == 0) {
                    redirect_header('manage.php?op=' . _XCONTENT_URL_OP_ADD . '&fct=' . _XCONTENT_URL_FCT_CATEGORIES, 6, _XCONTENT_NEEDCATEGORIES);
                    exit(0);
                }
                if ($GLOBALS['xoopsModuleConfig']['json']) {
                    $GLOBALS['xoopsOption']['template_main'] = _XCONTENT_TEMPLATE_INDEX_JSON_ADDEDITPAGE;
                } else {
                    $GLOBALS['xoopsOption']['template_main'] = _XCONTENT_TEMPLATE_INDEX_ADDEDITPAGE;
                }
                require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_HEADER);
                $GLOBALS['xoopsTpl']->assign('usermenu', loadUserMenu(2, ''));
                if ($GLOBALS['xoopsModuleConfig']['json']) {
                    $GLOBALS['xoTheme']->addScript(XOOPS_URL . _XCONTENT_PATH_JS_CORE);
                }
                if ($GLOBALS['xoopsModuleConfig']['force_jquery']) {
                    $GLOBALS['xoTheme']->addScript(XOOPS_URL . _XCONTENT_PATH_JS_JQUERY);
                }

                $GLOBALS['xoopsTpl']->assign('passkey', xcontent_passkey());
                $GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
                $GLOBALS['xoopsTpl']->assign('xoModule', $GLOBALS['xoopsModule']->toArray());
                $GLOBALS['xoopsTpl']->assign('form', xcontent_addxcontent($storyid, $language));
                require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FOOTER);
                break;
            case _XCONTENT_URL_FCT_CATEGORY:
                if ($GLOBALS['xoopsModuleConfig']['json']) {
                    $GLOBALS['xoopsOption']['template_main'] = _XCONTENT_TEMPLATE_INDEX_JSON_ADDEDITCATEGORY;
                } else {
                    $GLOBALS['xoopsOption']['template_main'] = _XCONTENT_TEMPLATE_INDEX_ADDEDITCATEGORY;
                }
                require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_HEADER);
                $GLOBALS['xoopsTpl']->assign('usermenu', loadUserMenu(4, ''));
                if ($GLOBALS['xoopsModuleConfig']['json']) {
                    $GLOBALS['xoTheme']->addScript(XOOPS_URL . _XCONTENT_PATH_JS_CORE);
                }
                if ($GLOBALS['xoopsModuleConfig']['force_jquery']) {
                    $GLOBALS['xoTheme']->addScript(XOOPS_URL . _XCONTENT_PATH_JS_JQUERY);
                }

                $GLOBALS['xoopsTpl']->assign('passkey', xcontent_passkey());
                $GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
                $GLOBALS['xoopsTpl']->assign('xoModule', $GLOBALS['xoopsModule']->toArray());
                $GLOBALS['xoopsTpl']->assign('form', xcontent_addcategory($catid, $language));
                require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FOOTER);
                break;

            case _XCONTENT_URL_FCT_BLOCKS:
                if ($GLOBALS['xoopsModuleConfig']['json']) {
                    $GLOBALS['xoopsOption']['template_main'] = _XCONTENT_TEMPLATE_INDEX_JSON_ADDEDITBLOCK;
                } else {
                    $GLOBALS['xoopsOption']['template_main'] = _XCONTENT_TEMPLATE_INDEX_ADDEDITBLOCK;
                }
                require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_HEADER);
                $GLOBALS['xoopsTpl']->assign('usermenu', loadUserMenu(6, ''));
                if ($GLOBALS['xoopsModuleConfig']['json']) {
                    $GLOBALS['xoTheme']->addScript(XOOPS_URL . _XCONTENT_PATH_JS_CORE);
                }
                if ($GLOBALS['xoopsModuleConfig']['force_jquery']) {
                    $GLOBALS['xoTheme']->addScript(XOOPS_URL . _XCONTENT_PATH_JS_JQUERY);
                }

                $GLOBALS['xoopsTpl']->assign('passkey', xcontent_passkey());
                $GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
                $GLOBALS['xoopsTpl']->assign('xoModule', $GLOBALS['xoopsModule']->toArray());
                $GLOBALS['xoopsTpl']->assign('form', xcontent_addblock($blockid, $language));
                require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FOOTER);
                break;
        }
        break;
    case _XCONTENT_URL_OP_DELETE:
        switch ($fct) {
            case _XCONTENT_URL_FCT_XCONTENT:
                if (empty($_POST['confirmed'])) {
                    require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_HEADER);
                    xoops_confirm(array(
                                      'confirmed' => true,
                                      'op'        => _XCONTENT_URL_OP_DELETE,
                                      'fct'       => _XCONTENT_URL_FCT_XCONTENT,
                                      'storyid'   => $storyid
                                  ), $_SERVER['REQUEST_URI'], sprintf(_XCONTENT_AD_CONFIRM_DELETE, xcontent_getTitle($storyid)));
                    require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FOOTER);
                    exit(0);
                }
                $sql[0] = 'DELETE FROM ' . $GLOBALS['xoopsDB']->prefix(_XCONTENT_TABLE_XCONTENT) . " WHERE storyid = '" . $storyid . "'";
                $sql[1] = 'DELETE FROM ' . $GLOBALS['xoopsDB']->prefix(_XCONTENT_TABLE_TEXT) . " WHERE type = '" . _XCONTENT_ENUM_TYPE_XCONTENT . "' AND storyid = '" . $storyid . "'";
                @$GLOBALS['xoopsDB']->queryF($sql[0]);
                @$GLOBALS['xoopsDB']->queryF($sql[1]);
                redirect_header('manage.php?op=' . _XCONTENT_URL_OP_MANAGE . '&fct=' . _XCONTENT_URL_FCT_XCONTENT, 7, _XCONTENT_AD_MSG_DELETE);
                break;

            case _XCONTENT_URL_FCT_CATEGORY:
                if (empty($_POST['confirmed'])) {
                    require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_HEADER);
                    xoops_confirm(array(
                                      'confirmed' => true,
                                      'op'        => _XCONTENT_URL_OP_DELETE,
                                      'fct'       => _XCONTENT_URL_FCT_CATEGORY,
                                      'catid'     => $catid
                                  ), $_SERVER['REQUEST_URI'], sprintf(_XCONTENT_AD_CONFIRM_DELETE, xcontent_getCatTitle($catid)));
                    require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FOOTER);
                    exit(0);
                }
                $sql[0] = 'DELETE FROM ' . $GLOBALS['xoopsDB']->prefix(_XCONTENT_TABLE_CATEGORY) . " WHERE catid = '" . $catid . "'";
                $sql[1] = 'DELETE FROM ' . $GLOBALS['xoopsDB']->prefix(_XCONTENT_TABLE_TEXT) . " WHERE type = '" . _XCONTENT_ENUM_TYPE_CATEGORY . "' AND catid = '" . $catid . "'";
                @$GLOBALS['xoopsDB']->queryF($sql[0]);
                @$GLOBALS['xoopsDB']->queryF($sql[1]);
                redirect_header('manage.php?op=' . _XCONTENT_URL_OP_MANAGE . '&fct=' . _XCONTENT_URL_FCT_CATEGORIES, 7, _XCONTENT_AD_MSG_DELETE);
                break;

            case _XCONTENT_URL_FCT_BLOCKS:
                if (empty($_POST['confirmed'])) {
                    require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_HEADER);
                    xoops_confirm(array(
                                      'confirmed' => true,
                                      'op'        => _XCONTENT_URL_OP_DELETE,
                                      'fct'       => _XCONTENT_URL_FCT_BLOCKS,
                                      'blockid'   => $blockid
                                  ), $_SERVER['REQUEST_URI'], sprintf(_XCONTENT_AD_CONFIRM_DELETE, xcontent_getBlockTitle($blockid)));
                    require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FOOTER);
                    exit(0);
                }
                $sql[0] = 'DELETE FROM ' . $GLOBALS['xoopsDB']->prefix(_XCONTENT_TABLE_BLOCK) . " WHERE blockid = '" . $blockid . "'";
                $sql[1] = 'DELETE FROM ' . $GLOBALS['xoopsDB']->prefix(_XCONTENT_TABLE_TEXT) . " WHERE type = '" . _XCONTENT_ENUM_TYPE_BLOCK . "' AND blockid = '" . $blockid . "'";
                @$GLOBALS['xoopsDB']->queryF($sql[0]);
                @$GLOBALS['xoopsDB']->queryF($sql[1]);
                redirect_header('manage.php?op=' . _XCONTENT_URL_OP_MANAGE . '&fct=' . _XCONTENT_URL_FCT_BLOCKS, 7, _XCONTENT_AD_MSG_DELETE);
                break;

        }

    case _XCONTENT_URL_OP_COPY:
        switch ($fct) {
            default:
            case _XCONTENT_URL_FCT_XCONTENT:
                if (empty($_POST['confirmed'])) {
                    require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_HEADER);
                    xoops_confirm(array(
                                      'confirmed' => true,
                                      'op'        => _XCONTENT_URL_OP_COPY,
                                      'fct'       => _XCONTENT_URL_FCT_XCONTENT,
                                      'storyid'   => $storyid
                                  ), $_SERVER['REQUEST_URI'], sprintf(_XCONTENT_AD_CONFIRM_COPY, xcontent_getTitle($storyid)));
                    require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FOOTER);
                    exit(0);
                }

                $xcontentHandler = xoops_getModuleHandler(_XCONTENT_CLASS_XCONTENT, _XCONTENT_DIRNAME);
                $textHandler     = xoops_getModuleHandler(_XCONTENT_CLASS_TEXT, _XCONTENT_DIRNAME);
                $criteria        = new CriteriaCompo(new Criteria('storyid', $storyid));
                $criteria->add(new Criteria('type', _XCONTENT_ENUM_TYPE_XCONTENT));
                $xcontent  = $xcontentHandler->get($storyid);
                $texts     = $textHandler->getObjects($criteria);
                $xcontentb = $xcontentHandler->create();
                $xcontentb->setVar('storyid', 0);
                $xcontentb->setVar('parent_id', $xcontent->getVar('parent_id'), true);
                $xcontentb->setVar('blockid', $xcontent->getVar('blockid'), true);
                $xcontentb->setVar('catid', $xcontent->getVar('catid'), true);
                $xcontentb->setVar('visible', $xcontent->getVar('visible'), true);
                $xcontentb->setVar('homepage', $xcontent->getVar('homepage'), true);
                $xcontentb->setVar('nohtml', $xcontent->getVar('nohtml'), true);
                $xcontentb->setVar('nosmiley', $xcontent->getVar('nosmiley'), true);
                $xcontentb->setVar('nobreaks', $xcontent->getVar('nobreaks'), true);
                $xcontentb->setVar('nocomments', $xcontent->getVar('nocomments'), true);
                $xcontentb->setVar('link', $xcontent->getVar('link'), true);
                $xcontentb->setVar('address', $xcontent->getVar('address'), true);
                $xcontentb->setVar('submenu', $xcontent->getVar('submenu'), true);
                $xcontentb->setVar('date', time(), true);
                $xcontentb->setVar('assoc_module', $xcontent->getVar('assoc_module'), true);
                $xcontentb->setVar('tags', $xcontent->getVar('tags'), true);
                if ($xcontentHandler->insert($xcontentb)) {
                    ++$page;
                    foreach ($texts as $id => $text) {
                        $textb = $textHandler->create();
                        $textb->setVar('storyid', $xcontentb->getVar('storyid'), true);
                        $textb->setVar('type', $text->getVar('type'), true);
                        $textb->setVar('language', $text->getVar('language'), true);
                        $textb->setVar('title', $text->getVar('title'), true);
                        $textb->setVar('ptitle', $text->getVar('ptitle'), true);
                        $textb->setVar('text', $text->getVar('text'), true);
                        $textb->setVar('rss', $text->getVar('rss'), true);
                        $textb->setVar('keywords', $text->getVar('keywords'), true);
                        $textb->setVar('page_description', $text->getVar('page_description'), true);
                        if ($textHandler->insert($textb)) {
                            ++$page;
                        }
                    }
                } else {
                    require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_HEADER);
                    $GLOBALS['xoopsTpl']->assign('usermenu', loadUserMenu(1, ''));
                    xoops_error(implode('<b>', $xcontentb->getErrors()) . '<pre>' . print_r($xcontentb, true) . '</pre>');
                    require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FOOTER);
                    exit(0);
                }

                redirect_header('manage.php?op=' . _XCONTENT_URL_OP_MANAGE . '&fct=' . _XCONTENT_URL_FCT_XCONTENT, 7, sprintf(_XCONTENT_AD_MSG_COPY, $page));
                break;

            case _XCONTENT_URL_FCT_BLOCKS:
                if (empty($_POST['confirmed'])) {
                    require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_HEADER);
                    xoops_confirm(array(
                                      'confirmed' => true,
                                      'op'        => _XCONTENT_URL_OP_COPY,
                                      'fct'       => _XCONTENT_URL_FCT_BLOCKS,
                                      'blockid'   => $blockid
                                  ), $_SERVER['REQUEST_URI'], sprintf(_XCONTENT_AD_CONFIRM_COPY, xcontent_getBlockTitle($blockid)));
                    require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FOOTER);
                    exit(0);
                }

                $blockHandler = xoops_getModuleHandler(_XCONTENT_CLASS_BLOCK, _XCONTENT_DIRNAME);
                $textHandler  = xoops_getModuleHandler(_XCONTENT_CLASS_TEXT, _XCONTENT_DIRNAME);
                $criteria     = new CriteriaCompo(new Criteria('blockid', $blockid));
                $criteria->add(new Criteria('type', _XCONTENT_ENUM_TYPE_BLOCK));
                $block  = $blockHandler->get($blockid);
                $texts  = $textHandler->getObjects($criteria);
                $blockb = $blockHandler->create();
                $blockb->setVar('blockid', 0);
                $blockb->setVar('created', time(), true);
                $blockb->setVar('uid', $block->getVar('uid'), true);
                if ($blockHandler->insert($blockb)) {
                    ++$page;
                    foreach ($texts as $id => $text) {
                        $textb = $textHandler->create();
                        $textb->setVar('blockid', $blockb->getVar('blockid'), true);
                        $textb->setVar('type', $text->getVar('type'), true);
                        $textb->setVar('language', $text->getVar('language'), true);
                        $textb->setVar('title', $text->getVar('title'), true);
                        $textb->setVar('ptitle', $text->getVar('ptitle'), true);
                        $textb->setVar('text', $text->getVar('text'), true);
                        $textb->setVar('rss', $text->getVar('rss'), true);
                        $textb->setVar('keywords', $text->getVar('keywords'), true);
                        $textb->setVar('page_description', $text->getVar('page_description'), true);
                        if ($textHandler->insert($textb)) {
                            ++$page;
                        }
                    }
                } else {
                    require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_HEADER);
                    $GLOBALS['xoopsTpl']->assign('usermenu', loadUserMenu(5, ''));
                    xoops_error(implode('<b>', $categoryb->getErrors()) . '<pre>' . print_r($categoryb, true) . '</pre>');
                    require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FOOTER);
                    exit(0);
                }

                redirect_header('manage.php?op=' . _XCONTENT_URL_OP_MANAGE . '&fct=' . _XCONTENT_URL_FCT_BLOCKS, 7, sprintf(_XCONTENT_AD_MSG_COPY, $page));
                break;

            case _XCONTENT_URL_FCT_CATEGORY:
                if (empty($_POST['confirmed'])) {
                    require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_HEADER);
                    xoops_confirm(array(
                                      'confirmed' => true,
                                      'op'        => _XCONTENT_URL_OP_COPY,
                                      'fct'       => _XCONTENT_URL_FCT_CATEGORY,
                                      'catid'     => $catid
                                  ), $_SERVER['REQUEST_URI'], sprintf(_XCONTENT_AD_CONFIRM_COPY, xcontent_getCatTitle($catid)));
                    require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FOOTER);
                    exit(0);
                }

                $categoryHandler = xoops_getModuleHandler(_XCONTENT_CLASS_CATEGORY, _XCONTENT_DIRNAME);
                $textHandler     = xoops_getModuleHandler(_XCONTENT_CLASS_TEXT, _XCONTENT_DIRNAME);
                $criteria        = new CriteriaCompo(new Criteria('catid', $catid));
                $criteria->add(new Criteria('type', _XCONTENT_ENUM_TYPE_CATEGORY));
                $category  = $categoryHandler->get($catid);
                $texts     = $textHandler->getObjects($criteria);
                $categoryb = $categoryHandler->create();
                $categoryb->setVar('catid', 0);
                $categoryb->setVar('parent_id', $category->getVar('parent_id'), true);
                $categoryb->setVar('rssenabled', $category->getVar('rssenabled'), true);
                if ($categoryHandler->insert($categoryb)) {
                    ++$page;
                    foreach ($texts as $id => $text) {
                        $textb = $textHandler->create();
                        $textb->setVar('catid', $categoryb->getVar('catid'), true);
                        $textb->setVar('type', $text->getVar('type'), true);
                        $textb->setVar('language', $text->getVar('language'), true);
                        $textb->setVar('title', $text->getVar('title'), true);
                        $textb->setVar('ptitle', $text->getVar('ptitle'), true);
                        $textb->setVar('text', $text->getVar('text'), true);
                        $textb->setVar('rss', $text->getVar('rss'), true);
                        $textb->setVar('keywords', $text->getVar('keywords'), true);
                        $textb->setVar('page_description', $text->getVar('page_description'), true);
                        if ($textHandler->insert($textb)) {
                            ++$page;
                        }
                    }
                } else {
                    require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_HEADER);
                    $GLOBALS['xoopsTpl']->assign('usermenu', loadUserMenu(1, ''));
                    xoops_error(implode('<b>', $categoryb->getErrors()) . '<pre>' . print_r($categoryb, true) . '</pre>');
                    require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FOOTER);
                    exit(0);
                }

                redirect_header('manage.php?op=' . _XCONTENT_URL_OP_MANAGE . '&fct=' . _XCONTENT_URL_FCT_CATEGORIES, 7, sprintf(_XCONTENT_AD_MSG_COPY, $page));
                break;

        }
    default:
    case _XCONTENT_URL_OP_MANAGE:
        switch ($fct) {
            default:
            case _XCONTENT_URL_FCT_XCONTENT:
                require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_HEADER);
                $GLOBALS['xoopsTpl']->assign('usermenu', loadUserMenu(1, ''));
                $GLOBALS['xoopsTpl']->assign('list', xcontent_listuserxcontent());
                require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FOOTER);
                break;
            case _XCONTENT_URL_FCT_BLOCKS:
                require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_HEADER);
                $GLOBALS['xoopsTpl']->assign('usermenu', loadUserMenu(5, ''));
                $GLOBALS['xoopsTpl']->assign('list', xcontent_listuserblock());
                require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FOOTER);
                break;
            case _XCONTENT_URL_FCT_CATEGORIES:
                require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_HEADER);
                $GLOBALS['xoopsTpl']->assign('usermenu', loadUserMenu(3, ''));
                $GLOBALS['xoopsTpl']->assign('list', xcontent_listusercategory());
                require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FOOTER);
                break;
        }
        break;
    case _XCONTENT_URL_OP_PERMISSIONS:
        require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_HEADER);
        $GLOBALS['xoopsTpl']->assign('usermenu', loadUserMenu(7, ''));

        require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_GROUPPERMS);

        foreach ($_POST as $k => $v) {
            ${$k} = $v;
        }

        foreach ($_GET as $k => $v) {
            ${$k} = $v;
        }
        ob_start();
        echo '<div style="float:right; clear:both;"><form name="perms"><select name="permlinks" onChange="window.location=document.perms.permlinks.options[document.perms.permlinks.selectedIndex].value">';
        if ($GLOBALS['xoopsModuleConfig']['security'] == _XCONTENT_SECURITY_BASIC) {
            echo '<option value="' . XOOPS_URL . '/modules/xcontent/manage.php?op=' . _XCONTENT_URL_OP_PERMISSIONS . '&fct=' . _XCONTENT_URL_FCT_TEMPLATE . '&mode=' . _XCONTENT_PERM_MODE_ALL . '"';
            if ($fct == _XCONTENT_URL_FCT_TEMPLATE) {
                echo ' selected>' . _XCONTENT_PERM_DEFAULT_TEMPLATE . '</option>';
            } else {
                echo '>' . _XCONTENT_PERM_DEFAULT_TEMPLATE . '</option>';
            }
            if ($fct == _XCONTENT_URL_FCT_CATEGORIES && $_GET['mode'] == _XCONTENT_PERM_MODE_VIEW) {
                echo ' selected>' . _XCONTENT_PERM_VIEW_CATEGORY . '</option>';
            } else {
                echo '>' . _XCONTENT_PERM_VIEW_CATEGORY . '</option>';
            }
            echo '<option value="' . XOOPS_URL . '/modules/xcontent/manage.php?op=' . _XCONTENT_URL_OP_PERMISSIONS . '&fct=' . _XCONTENT_URL_FCT_XCONTENT . '&mode=' . _XCONTENT_PERM_MODE_VIEW . '"';
            if ($fct == _XCONTENT_URL_FCT_XCONTENT && $_GET['mode'] == _XCONTENT_PERM_MODE_VIEW) {
                echo ' selected>' . _XCONTENT_PERM_VIEW_XCONTENT . '</option>';
            } else {
                echo '>' . _XCONTENT_PERM_VIEW_XCONTENT . '</option>';
            }
        } elseif ($GLOBALS['xoopsModuleConfig']['security'] == _XCONTENT_SECURITY_INTERMEDIATE) {
            echo '<option value="' . XOOPS_URL . '/modules/xcontent/manage.php?op=' . _XCONTENT_URL_OP_PERMISSIONS . '&fct=' . _XCONTENT_URL_FCT_TEMPLATE . '&mode=' . _XCONTENT_PERM_MODE_ALL . '"';
            if ($fct == _XCONTENT_URL_FCT_TEMPLATE && $_GET['mode'] == _XCONTENT_PERM_MODE_ALL) {
                echo ' selected>' . _XCONTENT_PERM_DEFAULT_TEMPLATE . '</option>';
            } else {
                echo '>' . _XCONTENT_PERM_DEFAULT_TEMPLATE . '</option>';
            }
            echo '<option value="' . XOOPS_URL . '/modules/xcontent/manage.php?op=' . _XCONTENT_URL_OP_PERMISSIONS . '&fct=' . _XCONTENT_URL_FCT_CATEGORIES . '&mode=' . _XCONTENT_PERM_MODE_VIEW . '"';
            if ($fct == _XCONTENT_URL_FCT_CATEGORIES && $_GET['mode'] == _XCONTENT_PERM_MODE_VIEW) {
                echo ' selected>' . _XCONTENT_PERM_VIEW_CATEGORY . '</option>';
            } else {
                echo '>' . _XCONTENT_PERM_VIEW_CATEGORY . '</option>';
            }
            echo '<option value="' . XOOPS_URL . '/modules/xcontent/manage.php?op=' . _XCONTENT_URL_OP_PERMISSIONS . '&fct=' . _XCONTENT_URL_FCT_XCONTENT . '&mode=' . _XCONTENT_PERM_MODE_VIEW . '"';
            if ($fct == _XCONTENT_URL_FCT_XCONTENT && $_GET['mode'] == _XCONTENT_PERM_MODE_VIEW) {
                echo ' selected>' . _XCONTENT_PERM_VIEW_XCONTENT . '</option>';
            } else {
                echo '>' . _XCONTENT_PERM_VIEW_XCONTENT . '</option>';
            }
            echo '<option value="' . XOOPS_URL . '/modules/xcontent/manage.php?op=' . _XCONTENT_URL_OP_PERMISSIONS . '&fct=' . _XCONTENT_URL_FCT_BLOCKS . '&mode=' . _XCONTENT_PERM_MODE_VIEW . '"';
            if ($fct == _XCONTENT_URL_FCT_BLOCKS && $_GET['mode'] == _XCONTENT_PERM_MODE_VIEW) {
                echo ' selected>' . _XCONTENT_PERM_VIEW_BLOCK . '</option>';
            } else {
                echo '>' . _XCONTENT_PERM_VIEW_BLOCK . '</option>';
            }
            if ($fct == _XCONTENT_URL_FCT_CATEGORIES && $_GET['mode'] == _XCONTENT_PERM_MODE_ADD) {
                echo ' selected>' . _XCONTENT_PERM_ADD_XCONTENT . '</option>';
            } else {
                echo '>' . _XCONTENT_PERM_EDIT_BLOCK . '</option>';
            }
        } else {
            echo '<option value="' . XOOPS_URL . '/modules/xcontent/manage.php?op=' . _XCONTENT_URL_OP_PERMISSIONS . '&fct=' . _XCONTENT_URL_FCT_TEMPLATE . '&mode=' . _XCONTENT_PERM_MODE_ALL . '"';
            if ($fct == _XCONTENT_URL_FCT_TEMPLATE && $_GET['mode'] == _XCONTENT_PERM_MODE_ALL) {
                echo ' selected>' . _XCONTENT_PERM_DEFAULT_TEMPLATE . '</option>';
            } else {
                echo '>' . _XCONTENT_PERM_DEFAULT_TEMPLATE . '</option>';
            }

            echo '<option value="' . XOOPS_URL . '/modules/xcontent/manage.php?op=' . _XCONTENT_URL_OP_PERMISSIONS . '&fct=' . _XCONTENT_URL_FCT_CATEGORIES . '&mode=' . _XCONTENT_PERM_MODE_VIEW . '"';
            if ($fct == _XCONTENT_URL_FCT_CATEGORIES && $_GET['mode'] == _XCONTENT_PERM_MODE_VIEW) {
                echo ' selected>' . _XCONTENT_PERM_VIEW_CATEGORY . '</option>';
            } else {
                echo '>' . _XCONTENT_PERM_VIEW_CATEGORY . '</option>';
            }

            echo '<option value="' . XOOPS_URL . '/modules/xcontent/manage.php?op=' . _XCONTENT_URL_OP_PERMISSIONS . '&fct=' . _XCONTENT_URL_FCT_XCONTENT . '&mode=' . _XCONTENT_PERM_MODE_VIEW . '"';
            if ($fct == _XCONTENT_URL_FCT_XCONTENT && $_GET['mode'] == _XCONTENT_PERM_MODE_VIEW) {
                echo ' selected>' . _XCONTENT_PERM_VIEW_XCONTENT . '</option>';
            } else {
                echo '>' . _XCONTENT_PERM_VIEW_XCONTENT . '</option>';
            }

            echo '<option value="' . XOOPS_URL . '/modules/xcontent/manage.php?op=' . _XCONTENT_URL_OP_PERMISSIONS . '&fct=' . _XCONTENT_URL_FCT_BLOCKS . '&mode=' . _XCONTENT_PERM_MODE_VIEW . '"';
            if ($fct == _XCONTENT_URL_FCT_BLOCKS && $_GET['mode'] == _XCONTENT_PERM_MODE_VIEW) {
                echo ' selected>' . _XCONTENT_PERM_VIEW_BLOCK . '</option>';
            } else {
                echo '>' . _XCONTENT_PERM_VIEW_BLOCK . '</option>';
            }

            echo '<option value="' . XOOPS_URL . '/modules/xcontent/manage.php?op=' . _XCONTENT_URL_OP_PERMISSIONS . '&fct=' . _XCONTENT_URL_FCT_CATEGORIES . '&mode=' . _XCONTENT_PERM_MODE_EDIT . '"';
            if ($fct == _XCONTENT_URL_FCT_CATEGORIES && $_GET['mode'] == _XCONTENT_PERM_MODE_EDIT) {
                echo ' selected>' . _XCONTENT_PERM_EDIT_CATEGORY . '</option>';
            } else {
                echo '>' . _XCONTENT_PERM_EDIT_CATEGORY . '</option>';
            }

            echo '<option value="' . XOOPS_URL . '/modules/xcontent/manage.php?op=' . _XCONTENT_URL_OP_PERMISSIONS . '&fct=' . _XCONTENT_URL_FCT_XCONTENT . '&mode=' . _XCONTENT_PERM_MODE_EDIT . '"';
            if ($fct == _XCONTENT_URL_FCT_XCONTENT && $_GET['mode'] == _XCONTENT_PERM_MODE_EDIT) {
                echo ' selected>' . _XCONTENT_PERM_EDIT_XCONTENT . '</option>';
            } else {
                echo '>' . _XCONTENT_PERM_EDIT_XCONTENT . '</option>';
            }

            echo '<option value="' . XOOPS_URL . '/modules/xcontent/manage.php?op=' . _XCONTENT_URL_OP_PERMISSIONS . '&fct=' . _XCONTENT_URL_FCT_BLOCKS . '&mode=' . _XCONTENT_PERM_MODE_EDIT . '"';
            if ($fct == _XCONTENT_URL_FCT_BLOCKS && $_GET['mode'] == _XCONTENT_PERM_MODE_EDIT) {
                echo ' selected>' . _XCONTENT_PERM_EDIT_BLOCK . '</option>';
            } else {
                echo '>' . _XCONTENT_PERM_EDIT_BLOCK . '</option>';
            }

            echo '<option value="' . XOOPS_URL . '/modules/xcontent/manage.php?op=' . _XCONTENT_URL_OP_PERMISSIONS . '&fct=' . _XCONTENT_URL_FCT_XCONTENT . '&mode=' . _XCONTENT_PERM_MODE_ADD . '"';
            if ($fct == _XCONTENT_URL_FCT_XCONTENT && $_GET['mode'] == _XCONTENT_PERM_MODE_ADD) {
                echo ' selected>' . _XCONTENT_PERM_ADD_XCONTENT . '</option>';
            } else {
                echo '>' . _XCONTENT_PERM_ADD_XCONTENT . '</option>';
            }
        }

        echo '</select>&nbsp;<input type="button" name="go" value="' . _SUBMIT . '" onClick="window.location=document.perms.permlinks.options[document.perms.permlinks.selectedIndex].value"> </form></div>';

        switch ($fct) {
            case _XCONTENT_URL_FCT_CATEGORIES:
            default:
                // View Categories permissions
                $item_list_view = array();
                $block_view     = array();

                $result_view = $GLOBALS['xoopsDB']->query('SELECT catid FROM ' . $GLOBALS['xoopsDB']->prefix(_XCONTENT_TABLE_CATEGORY) . ' ');
                if ($GLOBALS['xoopsDB']->getRowsNum($result_view)) {
                    while ($myrow_view = $GLOBALS['xoopsDB']->fetcharray($result_view)) {
                        $item_list_view['cid']   = $myrow_view['catid'];
                        $item_list_view['title'] = xcontent_getCatTitle($myrow_view['catid']);
                        $form_view               = new XoopsGroupPermForm('', $GLOBALS['xoopsModule']->getVar('mid'), $mode . _XCONTENT_PERM_TYPE_CATEGORY, "<img id='toptableicon' src="
                                                                                                                                                            . XOOPS_URL
                                                                                                                                                            . '/modules/'
                                                                                                                                                            . $GLOBALS['xoopsModule']->dirname()
                                                                                                                                                            . "/assets/images/close12.gif alt=''></a>"
                                                                                                                                                            . _XCONTENT_PERMISSIONS_CATEGORY
                                                                                                                                                            . "</h3><div id='toptable'><span style=\"color: #567; margin: 3px 0 0 0; font-size: small; display: block; \">"
                                                                                                                                                            . ucfirst($mode)
                                                                                                                                                            . '</span>', 'admin/index.php?op=permissions&fct=template&mode=all');
                        $block_view[]            = $item_list_view;
                        foreach ($block_view as $itemlists) {
                            $form_view->addItem($itemlists['cid'], $itemlists['title']);
                        }
                    }
                    echo $form_view->render();
                } else {
                    echo "<img id='toptableicon' src="
                         . XOOPS_URL
                         . '/modules/'
                         . $GLOBALS['xoopsModule']->dirname()
                         . "/assets/images/close12.gif alt=''></a>&nbsp;"
                         . _XCONTENT_PERMISSIONSVIEWCATEGORY
                         . "</h3><div id='toptable'><span style=\"color: #567; margin: 3px 0 0 0; font-size: small; display: block; \">"
                         . _XCONTENT_NOPERMSSET
                         . '</span>';
                }
                echo '</div>';
                break;

            case _XCONTENT_URL_FCT_XCONTENT:

                // View Categories permissions
                $item_list_view = array();
                $block_view     = array();

                if ($mode == _XCONTENT_PERM_MODE_ADD) {
                    $result_view = $GLOBALS['xoopsDB']->query('SELECT catid FROM ' . $GLOBALS['xoopsDB']->prefix(_XCONTENT_TABLE_CATEGORY) . ' ');
                    if ($GLOBALS['xoopsDB']->getRowsNum($result_view)) {
                        while ($myrow_view = $GLOBALS['xoopsDB']->fetcharray($result_view)) {
                            $item_list_view['cid']   = $myrow_view['catid'];
                            $item_list_view['title'] = xcontent_getCatTitle($myrow_view['catid']);
                            $form_view               = new XoopsGroupPermForm('', $GLOBALS['xoopsModule']->getVar('mid'), $mode . _XCONTENT_PERM_TYPE_XCONTENT, "<img id='toptableicon' src="
                                                                                                                                                                . XOOPS_URL
                                                                                                                                                                . '/modules/'
                                                                                                                                                                . $GLOBALS['xoopsModule']->dirname()
                                                                                                                                                                . "/assets/images/close12.gif alt=''></a>"
                                                                                                                                                                . _XCONTENT_PERMISSIONS_XCONTENT
                                                                                                                                                                . "</h3><div id='toptable'><span style=\"color: #567; margin: 3px 0 0 0; font-size: small; display: block; \">"
                                                                                                                                                                . ucfirst($mode)
                                                                                                                                                                . '</span>', 'admin/index.php?op=permissions&fct=template&mode=all');
                            $block_view[]            = $item_list_view;
                            foreach ($block_view as $itemlists) {
                                $form_view->addItem($itemlists['cid'], $itemlists['title']);
                            }
                        }
                        echo $form_view->render();
                    } else {
                        echo "<img id='toptableicon' src="
                             . XOOPS_URL
                             . '/modules/'
                             . $GLOBALS['xoopsModule']->dirname()
                             . "/assets/images/close12.gif alt=''></a>&nbsp;"
                             . _XCONTENT_PERMISSIONS_XCONTENT
                             . "</h3><div id='toptable'><span style=\"color: #567; margin: 3px 0 0 0; font-size: small; display: block; \">"
                             . _XCONTENT_NOPERMSSET
                             . '</span>';
                    }
                } else {
                    $result_view = $GLOBALS['xoopsDB']->query('SELECT storyid FROM ' . $GLOBALS['xoopsDB']->prefix(_XCONTENT_TABLE_XCONTENT) . ' ');
                    if ($GLOBALS['xoopsDB']->getRowsNum($result_view)) {
                        while ($myrow_view = $GLOBALS['xoopsDB']->fetcharray($result_view)) {
                            $item_list_view['cid']   = $myrow_view['storyid'];
                            $item_list_view['title'] = xcontent_getTitle($myrow_view['storyid']);
                            $form_view               = new XoopsGroupPermForm('', $GLOBALS['xoopsModule']->getVar('mid'), $mode . _XCONTENT_PERM_TYPE_XCONTENT, "<img id='toptableicon' src="
                                                                                                                                                                . XOOPS_URL
                                                                                                                                                                . '/modules/'
                                                                                                                                                                . $GLOBALS['xoopsModule']->dirname()
                                                                                                                                                                . "/assets/images/close12.gif alt=''></a>"
                                                                                                                                                                . _XCONTENT_PERMISSIONS_XCONTENT
                                                                                                                                                                . "</h3><div id='toptable'><span style=\"color: #567; margin: 3px 0 0 0; font-size: small; display: block; \">"
                                                                                                                                                                . ucfirst($mode)
                                                                                                                                                                . '</span>', 'admin/index.php?op=permissions&fct=template&mode=all');
                            $block_view[]            = $item_list_view;
                            foreach ($block_view as $itemlists) {
                                $form_view->addItem($itemlists['cid'], $itemlists['title']);
                            }
                        }
                        echo $form_view->render();
                    } else {
                        echo "<img id='toptableicon' src="
                             . XOOPS_URL
                             . '/modules/'
                             . $GLOBALS['xoopsModule']->dirname()
                             . "/assets/images/close12.gif alt=''></a>&nbsp;"
                             . _XCONTENT_PERMISSIONS_XCONTENT
                             . "</h3><div id='toptable'><span style=\"color: #567; margin: 3px 0 0 0; font-size: small; display: block; \">"
                             . _XCONTENT_NOPERMSSET
                             . '</span>';
                    }
                }
                echo '</div>';
                break;

            case _XCONTENT_URL_FCT_BLOCKS:

                // View Categories permissions
                $item_list_view = array();
                $block_view     = array();

                $result_view = $GLOBALS['xoopsDB']->query('SELECT blockid FROM ' . $GLOBALS['xoopsDB']->prefix(_XCONTENT_TABLE_BLOCK) . ' ');
                if ($GLOBALS['xoopsDB']->getRowsNum($result_view)) {
                    while ($myrow_view = $GLOBALS['xoopsDB']->fetcharray($result_view)) {
                        $item_list_view['cid']   = $myrow_view['blockid'];
                        $item_list_view['title'] = xcontent_getBlockTitle($myrow_view['blockid']);
                        $form_view               = new XoopsGroupPermForm('', $GLOBALS['xoopsModule']->getVar('mid'), $mode . _XCONTENT_PERM_TYPE_BLOCK, "<img id='toptableicon' src="
                                                                                                                                                         . XOOPS_URL
                                                                                                                                                         . '/modules/'
                                                                                                                                                         . $GLOBALS['xoopsModule']->dirname()
                                                                                                                                                         . "/assets/images/close12.gif alt=''></a>"
                                                                                                                                                         . _XCONTENT_PERMISSIONS_BLOCKS
                                                                                                                                                         . "</h3><div id='toptable'><span style=\"color: #567; margin: 3px 0 0 0; font-size: small; display: block; \">"
                                                                                                                                                         . ucfirst($mode)
                                                                                                                                                         . '</span>', 'admin/index.php?op=permissions&fct=template&mode=all');
                        $block_view[]            = $item_list_view;
                        foreach ($block_view as $itemlists) {
                            $form_view->addItem($itemlists['cid'], $itemlists['title']);
                        }
                    }
                    echo $form_view->render();
                } else {
                    echo "<img id='toptableicon' src="
                         . XOOPS_URL
                         . '/modules/'
                         . $GLOBALS['xoopsModule']->dirname()
                         . "/assets/images/close12.gif alt=''></a>&nbsp;"
                         . _XCONTENT_PERMISSIONS_BLOCKS
                         . "</h3><div id='toptable'><span style=\"color: #567; margin: 3px 0 0 0; font-size: small; display: block; \">"
                         . _XCONTENT_NOPERMSSET
                         . '</span>';
                }
                echo '</div>';
                break;

            case _XCONTENT_URL_FCT_TEMPLATE:

                $permtypes = array(
                    _XCONTENT_PERM_TEMPLATE_ADD_XCONTENT    => _XCONTENT_PERM_TEMPLATE_ADD_XCONTENT_DESC,
                    _XCONTENT_PERM_TEMPLATE_ADD_CATEGORY    => _XCONTENT_PERM_TEMPLATE_ADD_CATEGORY_DESC,
                    _XCONTENT_PERM_TEMPLATE_ADD_BLOCK       => _XCONTENT_PERM_TEMPLATE_ADD_BLOCK_DESC,
                    _XCONTENT_PERM_TEMPLATE_EDIT_XCONTENT   => _XCONTENT_PERM_TEMPLATE_EDIT_XCONTENT_DESC,
                    _XCONTENT_PERM_TEMPLATE_EDIT_CATEGORY   => _XCONTENT_PERM_TEMPLATE_EDIT_CATEGORY_DESC,
                    _XCONTENT_PERM_TEMPLATE_EDIT_BLOCK      => _XCONTENT_PERM_TEMPLATE_EDIT_BLOCK_DESC,
                    _XCONTENT_PERM_TEMPLATE_VIEW_XCONTENT   => _XCONTENT_PERM_TEMPLATE_VIEW_XCONTENT_DESC,
                    _XCONTENT_PERM_TEMPLATE_VIEW_CATEGORY   => _XCONTENT_PERM_TEMPLATE_VIEW_CATEGORY_DESC,
                    _XCONTENT_PERM_TEMPLATE_VIEW_BLOCK      => _XCONTENT_PERM_TEMPLATE_VIEW_BLOCK_DESC,
                    _XCONTENT_PERM_TEMPLATE_COPY_XCONTENT   => _XCONTENT_PERM_TEMPLATE_COPY_XCONTENT_DESC,
                    _XCONTENT_PERM_TEMPLATE_COPY_CATEGORY   => _XCONTENT_PERM_TEMPLATE_COPY_CATEGORY_DESC,
                    _XCONTENT_PERM_TEMPLATE_COPY_BLOCK      => _XCONTENT_PERM_TEMPLATE_COPY_BLOCK_DESC,
                    _XCONTENT_PERM_TEMPLATE_DELETE_XCONTENT => _XCONTENT_PERM_TEMPLATE_DELETE_XCONTENT_DESC,
                    _XCONTENT_PERM_TEMPLATE_DELETE_CATEGORY => _XCONTENT_PERM_TEMPLATE_DELETE_CATEGORY_DESC,
                    _XCONTENT_PERM_TEMPLATE_DELETE_BLOCK    => _XCONTENT_PERM_TEMPLATE_DELETE_BLOCK_DESC,
                    _XCONTENT_PERM_TEMPLATE_MANAGE_XCONTENT => _XCONTENT_PERM_TEMPLATE_MANAGE_XCONTENT_DESC,
                    _XCONTENT_PERM_TEMPLATE_MANAGE_CATEGORY => _XCONTENT_PERM_TEMPLATE_MANAGE_CATEGORY_DESC,
                    _XCONTENT_PERM_TEMPLATE_MANAGE_BLOCK    => _XCONTENT_PERM_TEMPLATE_MANAGE_BLOCK_DESC,
                    _XCONTENT_PERM_TEMPLATE_PERMISSIONS     => _XCONTENT_PERM_TEMPLATE_PERMISSIONS_DESC
                );

                $form_view = new XoopsGroupPermForm('', $GLOBALS['xoopsModule']->getVar('mid'), $mode . _XCONTENT_PERM_TYPE_TEMPLATE, "<img id='toptableicon' src="
                                                                                                                                      . XOOPS_URL
                                                                                                                                      . '/modules/'
                                                                                                                                      . $GLOBALS['xoopsModule']->dirname()
                                                                                                                                      . "/assets/images/close12.gif alt=''></a>"
                                                                                                                                      . _XCONTENT_PERMISSIONS_DEFAULT
                                                                                                                                      . "</h3><div id='toptable'><span style=\"color: #567; margin: 3px 0 0 0; font-size: small; display: block; \">"
                                                                                                                                      . ucfirst($mode)
                                                                                                                                      . '</span>', 'admin/index.php?op=permissions&fct=template&mode=all');
                foreach ($permtypes as $id => $title) {
                    $form_view->addItem($id, $title);
                }
                echo $form_view->render();
                echo '</div>';
                break;

        }
        $GLOBALS['xoopsTpl']->assign('list', ob_get_content());
        ob_end_clean();

        require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FOOTER);
        break;

}
