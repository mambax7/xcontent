<?php

/*
Module: xContent

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

/**
 * @param $queryarray
 * @param $andor
 * @param $limit
 * @param $offset
 * @param $userid
 * @return array
 */
function xcontent_search($queryarray, $andor, $limit, $offset, $userid)
{
    if (is_file(XOOPS_ROOT_PATH . '/modules/xcontent/language/' . $GLOBALS['xoopsConfig']['language'] . '/modinfo.php')) {
        require_once XOOPS_ROOT_PATH . '/modules/xcontent/language/' . $GLOBALS['xoopsConfig']['language'] . '/modinfo.php';
    } elseif (is_file(XOOPS_ROOT_PATH . '/modules/xcontent/language/english/modinfo.php')) {
        require_once XOOPS_ROOT_PATH . '/modules/xcontent/language/english/modinfo.php';
    }

    if ($userid > 0) {
        $sql = 'SELECT a.storyid, a.title, a.text, b.uid FROM ' . $GLOBALS['xoopsDB']->prefix(_XCONTENT_TABLE_TEXT) . ' a INNER JOIN  FROM ' . $GLOBALS['xoopsDB']->prefix(_XCONTENT_TABLE_XCONTENT) . " b ON a.storyid = b.storyid WHERE b.visible='1' AND b.uid=" . $userid;
    } else {
        $sql = 'SELECT a.storyid, a.title, a.text, b.uid FROM ' . $GLOBALS['xoopsDB']->prefix(_XCONTENT_TABLE_TEXT) . ' a INNER JOIN  FROM ' . $GLOBALS['xoopsDB']->prefix(_XCONTENT_TABLE_XCONTENT) . " b ON a.storyid = b.storyid WHERE b.visible='1'";
    }

    // because count() returns 1 even if a supplied variable
    // is not an array, we must check if $querryarray is really an array
    if (is_array($queryarray) && $count = count($queryarray)) {
        $sql .= " AND ((a.text LIKE '%" . xoops_convert_encode($queryarray[0]) . "%' OR a.title LIKE '%" . xoops_convert_encode($queryarray[0]) . "%')";
        for ($i = 1; $i < $count; ++$i) {
            $sql .= " $andor ";
            $sql .= "(a.text LIKE '%$" . xoops_convert_encode($queryarray[$i]) . "%' OR a.title LIKE '%" . xoops_convert_encode($queryarray[$i]) . "%')";
        }
        $sql .= ')';
    }

    $sql    .= ' ORDER BY b.date ASC';
    $result = $GLOBALS['xoopsDB']->query($sql, $limit, $offset);
    $ret    = [];
    $i      = 0;
    if ($result instanceof \mysqli_result) {
        while (false !== ($myrow = $GLOBALS['xoopsDB']->fetchArray($result))) {
            $ret[$i]['image'] = '';
            $ret[$i]['link']  = 'index.php?storyid=' . $myrow['storyid'];
            $ret[$i]['title'] = xoops_convert_decode($myrow['title']);
            $ret[$i]['text']  = xoops_convert_decode($myrow['text']);
            $ret[$i]['uid']   = $myrow['uid'];
            ++$i;
        }
    }

    return $ret;
}
