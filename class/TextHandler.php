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
 * XOOPS policies handler class.
 * This class is responsible for providing data access mechanisms to the data source
 * of XOOPS user class objects.
 *
 * @author  Simon Roberts <simon@chronolabs.coop>
 * @package kernel
 */
class TextHandler extends \XoopsPersistableObjectHandler
{
    /**
     * TextHandler constructor.
     * @param \XoopsDatabase|null $db
     */
    public function __construct(\XoopsDatabase $db = null)
    {
        $this->db = $db;
        parent::__construct($db, \_XCONTENT_TABLE_TEXT, Text::class, 'xcontentid', 'title');
    }
}
