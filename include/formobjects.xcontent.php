<?php

/*
Module: xContent

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FORMLOADER);

require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FORM_LANGUAGES);
require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FORM_CATEGORIES);
require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FORM_PAGES);
require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FORM_BLOCKS);
require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FORM_HTMLTEMPLATES);

if (file_exists($GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FORM_TAG)) && $GLOBALS['xoopsModuleConfig']['tags']) {
    require_once $GLOBALS['xoops']->path(_XCONTENT_PATH_PHP_FORM_TAG);
}

xoops_load('pagenav');
