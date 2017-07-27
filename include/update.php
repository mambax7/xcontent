<?php

/*
Module: xContent

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

function xoops_module_update_xcontent(XoopsModule $module)
{
    if ($module->getVar('version') <= 213) {
        $textHandler = xoops_getModuleHandler('text', 'xcontent');

        $texts = $textHandler->getObjects(null, false);

        foreach ($texts as $xcontentid => $text) {
            $text->setVar('title', urldecode($text->getVar('title')));
            $text->setVar('ptitle', urldecode($text->getVar('ptitle')));
            $text->setVar('text', urldecode($text->getVar('text')));
            $text->setVar('rss', urldecode($text->getVar('rss')));
            $text->setVar('keywords', urldecode($text->getVar('keywords')));
            $text->setVar('page_description', urldecode($text->getVar('page_description')));
            $textHandler->insert($text);
        }
    }

    return true;
}
