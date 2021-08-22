<?php

/*
Module: xContent

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

//require_once $GLOBALS['xoops']->path('modules/xcontent/include/formselectblocks.php');
use Xmf\Request;
use XoopsModules\Xcontent\Form\FormSelectBlocks;
use XoopsModules\Xcontent\Helper;

/**
 * @param $options
 * @return array|bool
 */
function xcontent_block_inheritable_show($options)
{
    $helper = Helper::getInstance();
    /** @var \XoopsModules\Xcontent\ContentHandler $xcontentHandler */
    $xcontentHandler = $helper->getHandler('Content');
    /** @var \XoopsModules\Xcontent\BlockHandler $blockHandler */
    $blockHandler = $helper->getHandler('Block');
    $xcontent     = $xcontentHandler->get(Request::getInt('storyid', 0, 'GET'));
    if (is_object($xcontent)) {
        if (0 == $xcontent->getVar('blockid') && 0 == $options[0]) {
            return false;
        } elseif (0 != $xcontent->getVar('blockid')) {
            $block = $blockHandler->getBlock($xcontent->getVar('blockid'), $GLOBALS['xoopsConfig']['language']);
        } elseif (0 != $options[0]) {
            $block = $blockHandler->getBlock($options[0], $GLOBALS['xoopsConfig']['language']);
        } else {
            return false;
        }
    } elseif (0 != $options[0]) {
        $block = $blockHandler->getBlock($options[0], $GLOBALS['xoopsConfig']['language']);
    } else {
        return false;
    }

    $myts = \MyTextSanitizer::getInstance();

    return [
        'html' => $myts->displayTarea(clear_unicodeslashes($block['text']->getVar('text')), true, true, true, true, false),
    ];
}

if (!function_exists('clear_unicodeslashes')) {
    /**
     * @param $text
     * @return mixed
     */
    function clear_unicodeslashes($text)
    {
        $text = str_replace(["\\'"], "'", $text);
        $text = str_replace(["\\\\\\'"], "'", $text);
        $text = str_replace(['\\"'], '"', $text);

        return $text;
    }
}

/**
 * @param $options
 * @return string
 */
function xcontent_block_inheritable_edit($options)
{
    $blockform = new FormSelectBlocks('', 'options[0]', $options[0]);

    return 'Default Block: ' . $blockform->render();
}
