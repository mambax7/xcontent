<?php

function xoops_kernel_block_plugin_xcontent()
{
    return \Xmf\Request::getInt('storyid', 0, 'GET');
}

function xoops_kernel_block_list_plugin_xcontent()
{
    $xcontentHandler = xoops_getModuleHandler('xcontent', 'xcontent');
    $xcontents       = $xcontentHandler->getObjects(null, true);
    foreach ($xcontents as $storyid => $xcontent) {
        $data          = $xcontentHandler->getContent($storyid);
        $ret[$storyid] = $data['text']->getVar('title') . ' - ' . $data['text']->getVar('ptitle');
    }

    return $ret;
}
