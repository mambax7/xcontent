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

require_once \dirname(__DIR__, 2) . '/mainfile.php';
@require_once \dirname(__DIR__) . '/include/functions.php';

$com_itemid = Request::getInt('com_itemid', 0, 'GET');
if ($com_itemid > 0) {
    // Get link title
    $com_replytitle = xcontent_getPageTitle($com_itemid);
    require XOOPS_ROOT_PATH . '/include/comment_new.php';
}
