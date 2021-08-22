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
class XlanguageExt extends \XoopsObject
{
    /**
     * XlanguageExt constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->initVar('lang_id', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('weight', \XOBJ_DTYPE_INT, null, false);
        $this->initVar('lang_name', \XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('lang_desc', \XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('lang_code', \XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('lang_charset', \XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('lang_image', \XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('lang_base', \XOBJ_DTYPE_TXTBOX, null, true, 255);
    }
}
