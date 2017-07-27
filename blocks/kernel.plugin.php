<?php

function xoops_kernel_block_plugin_xcontent()
{
    return (int)$_GET['storyid'];
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
