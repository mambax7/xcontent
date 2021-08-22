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

use XoopsModules\Xcontent;

/**
 * XOOPS policies handler class.
 * This class is responsible for providing data access mechanisms to the data source
 * of XOOPS user class objects.
 *
 * @author  Simon Roberts <simon@chronolabs.coop>
 * @package kernel
 */
class ContentHandler extends \XoopsPersistableObjectHandler
{
    /**
     * ContentHandler constructor.
     * @param \XoopsDatabase|null $db
     */
    public function __construct(\XoopsDatabase $db = null)
    {
        $this->db = $db;
        parent::__construct($db, \_XCONTENT_TABLE_XCONTENT, Content::class, 'storyid');
    }

    /**
     * @return array
     */
    public function createnew()
    {
        $helper          = \XoopsModules\Xcontent\Helper::getInstance();
        $ret             = [];
        $textHandler     = $helper->getHandler(\_XCONTENT_CLASS_TEXT);
        $ret['text']     = $textHandler->create();
        $ret['xcontent'] = $this->create();

        return $ret;
    }

    /**
     * @param int    $storyid
     * @param string $language
     * @return array
     */
    public function getContent($storyid = 0, $language = '')
    {
        $helper = \XoopsModules\Xcontent\Helper::getInstance();
        $ret    = [];
        if (empty($language)) {
            $language = $GLOBALS['xoopsConfig']['language'];
        }
        $textHandler = $helper->getHandler(\_XCONTENT_CLASS_TEXT);
        $criteria    = new \CriteriaCompo(new \Criteria('storyid', $storyid));
        $criteria->add(new \Criteria('language', $language));
        $criteria->add(new \Criteria('type', \_XCONTENT_ENUM_TYPE_XCONTENT));
        $texts = $textHandler->getObjects($criteria);
        if ($texts) {
            $ret['text']               = $texts[0];
            $ret['xcontent']           = $this->get($storyid);
            $ret['perms']['hasEdit']   = \xcontent_checkperm(\_XCONTENT_URL_OP_EDIT, \_XCONTENT_URL_FCT_XCONTENT, $storyid, false, false, $GLOBALS['xoopsModuleConfig']['security']);
            $ret['perms']['hasCopy']   = \xcontent_checkperm(\_XCONTENT_URL_OP_COPY, \_XCONTENT_URL_FCT_XCONTENT, $storyid, false, false, $GLOBALS['xoopsModuleConfig']['security']);
            $ret['perms']['hasDelete'] = \xcontent_checkperm(\_XCONTENT_URL_OP_DELETE, \_XCONTENT_URL_FCT_XCONTENT, $storyid, false, false, $GLOBALS['xoopsModuleConfig']['security']);

            return $ret;
        }

        $ret['text'] = $textHandler->create();
        $ret['text']->setVar('language', $language);
        $ret['xcontent']           = $this->get($storyid);
        $ret['perms']['hasEdit']   = \xcontent_checkperm(\_XCONTENT_URL_OP_EDIT, \_XCONTENT_URL_FCT_XCONTENT, $storyid, false, false, $GLOBALS['xoopsModuleConfig']['security']);
        $ret['perms']['hasCopy']   = \xcontent_checkperm(\_XCONTENT_URL_OP_COPY, \_XCONTENT_URL_FCT_XCONTENT, $storyid, false, false, $GLOBALS['xoopsModuleConfig']['security']);
        $ret['perms']['hasDelete'] = \xcontent_checkperm(\_XCONTENT_URL_OP_DELETE, \_XCONTENT_URL_FCT_XCONTENT, $storyid, false, false, $GLOBALS['xoopsModuleConfig']['security']);

        return $ret;
    }

    /**
     * @param string $language
     * @return array
     */
    public function getHomepage($language = '')
    {
        $helper = \XoopsModules\Xcontent\Helper::getInstance();
        $ret    = [];

        if (empty($language)) {
            $language = $GLOBALS['xoopsConfig']['language'];
        }

        $textHandler = $helper->getHandler(\_XCONTENT_CLASS_TEXT);
        $criteria_a  = new \Criteria('homepage', true);
        $criteria_b  = new \CriteriaCompo(new \Criteria('language', $language));
        $criteria_b->add(new \Criteria('type', 'xcontent'));
        $xcontent = $this->getObjects($criteria_a);
        if ($xcontent) {
            $criteria_b->add(new \Criteria('storyid', $xcontent[0]->getVar('storyid')));
            $texts = $textHandler->getObjects($criteria_b);
            if ($texts) {
                $ret['text'] = $texts[0];
            }
            $ret['xcontent'] = $xcontent[0];

            return $ret;
        }

        return $this->createnew();
    }
}
