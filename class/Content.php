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
class Content extends \XoopsObject
{
    /**
     * Xcontent constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('storyid', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('parent_id', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('blockid', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('catid', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('weight', \XOBJ_DTYPE_INT, 1, false);
        $this->initVar('uid', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('visible', \XOBJ_DTYPE_INT, true, false);
        $this->initVar('homepage', \XOBJ_DTYPE_INT, false, false);
        $this->initVar('nohtml', \XOBJ_DTYPE_INT, false, false);
        $this->initVar('nosmiley', \XOBJ_DTYPE_INT, false, false);
        $this->initVar('nobreaks', \XOBJ_DTYPE_INT, false, false);
        $this->initVar('nocomments', \XOBJ_DTYPE_INT, false, false);
        $this->initVar('link', \XOBJ_DTYPE_INT, false, false);
        $this->initVar('address', \XOBJ_DTYPE_TXTBOX, 'http://', false, 255);
        $this->initVar('submenu', \XOBJ_DTYPE_INT, false, false);
        $this->initVar('date', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('assoc_module', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('tags', \XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('publish', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('publish_storyid', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('expire', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('expire_storyid', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('password', \XOBJ_DTYPE_TXTBOX, null, false, 32);
    }
}
