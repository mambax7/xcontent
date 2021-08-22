<?php

use Xmf\Request;
use XoopsModules\Xcontent\Helper;

/**
 * @return int
 */
function xoops_kernel_block_plugin_xcontent()
{
    return Request::getInt('storyid', 0, 'GET');
}

/**
 * @return mixed
 */
function xoops_kernel_block_list_plugin_xcontent()
{
    $helper = Helper::getInstance();
    /** @var \XoopsModules\Xcontent\ContentHandler $xcontentHandler */
    $xcontentHandler = $helper->getHandler('Content');
    $xcontents       = $xcontentHandler->getObjects(null, true);
    /** @var \XoopsModules\Xcontent\Xcontent $xcontent */
    foreach ($xcontents as $storyid => $xcontent) {
        $data          = $xcontentHandler->getContent($storyid);
        $ret[$storyid] = $data['text']->getVar('title') . ' - ' . $data['text']->getVar('ptitle');
    }

    return $ret;
}
