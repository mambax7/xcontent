<?php

/*
Module: xContent

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

// defined('XOOPS_ROOT_PATH') || exit('Restricted access.');

/**
 * Class for Blue Room xContent
 * @author    Simon Roberts <simon@xoops.org>
 * @copyright copyright (c) 2009-2003 XOOPS.org
 * @package   kernel
 */
class XcontentCategory extends XoopsObject
{
    public function __construct($id = null)
    {
        $this->initVar('catid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('parent_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('rssenabled', XOBJ_DTYPE_INT, false, false);
    }
}

/**
 * XOOPS policies handler class.
 * This class is responsible for providing data access mechanisms to the data source
 * of XOOPS user class objects.
 *
 * @author  Simon Roberts <simon@chronolabs.coop>
 * @package kernel
 */
class XcontentCategoryHandler extends XoopsPersistableObjectHandler
{
    public function __construct(XoopsDatabase $db)
    {
        $this->db = $db;
        parent::__construct($db, _XCONTENT_TABLE_CATEGORY, 'XcontentCategory', 'catid', 'title');
    }

    public function createnew()
    {
        $ret         = [];
        $textHandler = xoops_getModuleHandler(_XCONTENT_CLASS_TEXT, _XCONTENT_DIRNAME);
        $ret['text'] = $textHandler->create();
        $ret['cat']  = $this->create();

        return $ret;
    }

    public function getCategory($catid = 0, $language = '')
    {
        $ret = [];
        if (empty($language)) {
            $language = $GLOBALS['xoopsConfig']['language'];
        }
        $textHandler = xoops_getModuleHandler(_XCONTENT_CLASS_TEXT, _XCONTENT_DIRNAME);
        $criteria    = new CriteriaCompo(new Criteria('catid', $catid));
        $criteria->add(new Criteria('language', $language));
        $criteria->add(new Criteria('type', _XCONTENT_ENUM_TYPE_CATEGORY));
        if ($texts = $textHandler->getObjects($criteria)) {
            $ret['text'] = $texts[0];
            $ret['cat']  = $this->get($catid);

            return $ret;
        }

        $ret['text'] = $textHandler->create();
        $ret['text']->setVar('language', $language);
        $ret['cat'] = $this->get($catid);

        return $ret;
    }
}
