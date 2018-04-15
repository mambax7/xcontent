<?php

/*
Module: xContent

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

include  dirname(dirname(__DIR__)) . '/mainfile.php';
include __DIR__ . '/include/functions.php';

$com_itemid = \Xmf\Request::getInt('com_itemid', 0, 'GET');
if ($com_itemid > 0) {
    // Get link title
    $com_replytitle = xcontent_getPageTitle($com_itemid);
    include XOOPS_ROOT_PATH . '/include/comment_new.php';
}
