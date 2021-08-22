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

use XoopsObject;



/**
 * Class for Blue Room xContent
 * @author    Simon Roberts <simon@xoops.org>
 * @copyright copyright (c) 2009-2003 XOOPS.org
 * @package   kernel
 */
class Category extends XoopsObject
{
    /**
     * Category constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('catid', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('parent_id', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('rssenabled', \XOBJ_DTYPE_INT, false, false);
    }
}
