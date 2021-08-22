<?php

namespace XoopsModules\Xcontent;

/*
Module: xContent

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

/**
 * Class for Blue Room xContent
 * @author    Simon Roberts <simon@xoops.org>
 * @copyright copyright (c) 2009-2003 XOOPS.org
 * @package   kernel
 */
class Text extends \XoopsObject
{
    /**
     * Text constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('xcontentid', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('storyid', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('catid', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('blockid', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('type', \XOBJ_DTYPE_ENUM, 'xcontent', false, false, false, ['xcontent', 'category', 'block']);
        $this->initVar('language', \XOBJ_DTYPE_TXTBOX, $GLOBALS['xoopsConfig']['language'], true, 32);
        $this->initVar('title', \XOBJ_DTYPE_TXTBOX, null, true, 255); // Removed Unicode in 2.10
        $this->initVar('ptitle', \XOBJ_DTYPE_TXTBOX, null, false, 255); // Removed Unicode in 2.10
        $this->initVar('text', \XOBJ_DTYPE_OTHER, null, false); // Removed Unicode in 2.10
        $this->initVar('rss', \XOBJ_DTYPE_OTHER, null, false); // Removed Unicode in 2.10
        $this->initVar('keywords', \XOBJ_DTYPE_OTHER, null, false); // Removed Unicode in 2.10
        $this->initVar('page_description', \XOBJ_DTYPE_OTHER, null, false); // Removed Unicode in 2.10
    }
}
