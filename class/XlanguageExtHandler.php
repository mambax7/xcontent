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
class XlanguageExtHandler extends XoopsPersistableObjectHandler
{
    /**
     * XlanguageExtHandler constructor.
     * @param \XoopsDatabase|null $db
     */
    public function __construct(XoopsDatabase $db = null)
    {
        $this->db = $db;
        parent::__construct($db, 'xlanguage_ext', XlanguageExt::class, 'lang_id', 'lang_name');
    }
/*
    function getLanguages()
    {
        $module_handler = xoops_gethandler('module');
        $xLanguage = $module_handler->getByDirname('xlanguage');
//        $xlanguageHandler = XoopsModules\Xlanguage\Helper::getInstance()->getHandler('Language');
        $ret = array();
        if (is_object($xLanguage)) {
            if ($xLanguage->getVar('active')) {
                foreach($this->getObjects(NULL,true) as $lang_id=>$lang)
                    $ret[$lang->getVar('lang_base')]=$lang->getVar('lang_name');
            } else {
                require_once(XOOPS_ROOT_PATH.'/class/xoopslists.php');
                $languages = \XoopsLists::getDirListAsArray(XOOPS_ROOT_PATH.'/language/');
                foreach($languages as $lang_id=>$lang)
                    $ret[$lang] = ucfirst($lang);
            }
        } else {
            require_once(XOOPS_ROOT_PATH.'/class/xoopslists.php');
            $languages = \XoopsLists::getDirListAsArray(XOOPS_ROOT_PATH.'/language/');
            foreach($languages as $lang_id=>$lang)
                $ret[$lang] = ucfirst($lang);

        }
        return $ret;
    }
*/

}
