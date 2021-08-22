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

//use XoopsModules\Xcontent;
use Criteria;
use CriteriaCompo;
use XoopsDatabase;
use XoopsPersistableObjectHandler;





/**
 * XOOPS policies handler class.
 * This class is responsible for providing data access mechanisms to the data source
 * of XOOPS user class objects.
 *
 * @author  Simon Roberts <simon@chronolabs.coop>
 * @package kernel
 */
class CategoryHandler extends XoopsPersistableObjectHandler
{
    /**
     * CategoryHandler constructor.
     * @param \XoopsDatabase|null $db
     */
    public function __construct(XoopsDatabase $db = null)
    {
        $this->db = $db;
        parent::__construct($db, \_XCONTENT_TABLE_CATEGORY, Category::class, 'catid', 'title');
    }

    /**
     * @return array
     */
    public function createnew()
    {
        $helper      = Helper::getInstance();
        $ret         = [];
        $textHandler = $helper->getHandler(\_XCONTENT_CLASS_TEXT);
        $ret['text'] = $textHandler->create();
        $ret['cat']  = $this->create();

        return $ret;
    }

    /**
     * @param int    $catid
     * @param string $language
     * @return array
     */
    public function getCategory($catid = 0, $language = '')
    {
        $helper = \XoopsModules\Xcontent\Helper::getInstance();
        $ret    = [];
        if (empty($language)) {
            $language = $GLOBALS['xoopsConfig']['language'];
        }
        $textHandler = $helper->getHandler(\_XCONTENT_CLASS_TEXT);
        $criteria    = new CriteriaCompo(new Criteria('catid', $catid));
        $criteria->add(new Criteria('language', $language));
        $criteria->add(new Criteria('type', \_XCONTENT_ENUM_TYPE_CATEGORY));
        $texts = $textHandler->getObjects($criteria);
        if ($texts) {
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
