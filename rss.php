<?php

/*
Module: xContent

Version: 2.01

Description: Multilingual Content Module with tags and lists with search functions

Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

Owner: Chronolabs

License: See /docs - GPL 2.0
*/

use Xmf\Request;
use XoopsModules\Xcontent\Helper;

require_once __DIR__ . '/header.php';

$helper = Helper::getInstance();

$catid = Request::getInt('catid', 0, 'GET');

if ($GLOBALS['xoopsModuleConfig']['htaccess']) {
    if (mb_strpos($_SERVER['REQUEST_URI'], 'odules/') > 0) {
        /** @var \XoopsModules\Xcontent\CategoryHandler $categoryHandler */
        $categoryHandler = $helper->getHandler(_XCONTENT_CLASS_CATEGORY);
        $category        = $categoryHandler->getCategory($catid);
        if ('' != $category['text']->getVar('title')) {
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . XOOPS_URL . '/' . $GLOBALS['xoopsModuleConfig']['baseurl'] . '/' . xoops_sef($category['text']->getVar('title')) . '/feed,' . $catid . $GLOBALS['xoopsModuleConfig']['endofurl_rss']);
        } else {
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . XOOPS_URL . '/' . $GLOBALS['xoopsModuleConfig']['baseurl'] . '/feed,' . $catid . $GLOBALS['xoopsModuleConfig']['endofurl_rss']);
        }
        exit(0);
    }
}

/**
 * @param $catid
 * @param $language
 * @return array
 */
function rss_data($catid, $language)
{
    $myts = \MyTextSanitizer::getInstance();
    $rss  = [];
    $helper = Helper::getInstance();
    /** @var \XoopsModules\Xcontent\ContentHandler $xcontentHandler */
    $xcontentHandler = $helper->getHandler(_XCONTENT_CLASS_XCONTENT);
    /** @var \XoopsModules\Xcontent\CategoryHandler $categoryHandler */
    $categoryHandler = $helper->getHandler(_XCONTENT_CLASS_CATEGORY);
    $criteria        = new \CriteriaCompo(new \Criteria('catid', $catid), 'AND');
    $criteria->setSort('weight');
    $xcontents = $xcontentHandler->getObjects($criteria, true);
    $category  = [];
    foreach ($xcontents as $storyid => $xcontent) {
        $txcontent               = $xcontentHandler->getContent($storyid, $language);
        $tcategory               = $categoryHandler->getCategory($xcontent->getVar('catid'));
        $download                = [];
        $download['title']       = strip_tags($myts->displayTarea(clear_unicodeslashes($txcontent['text']->getVar('ptitle')), 0, 0, 1));
        $download['description'] = htmlspecialchars($myts->displayTarea(clear_unicodeslashes($txcontent['text']->getVar('rss')), 1, 1, 1), ENT_QUOTES | ENT_HTML5);
        $download['url']         = XOOPS_URL . '/modules/xcontent/?id=' . $storyid . '&catid=' . $xcontent->getVar('catid');
        $download['dossier_url'] = XOOPS_URL . '/modules/xcontent/?id=' . $storyid . '&catid=' . $xcontent->getVar('catid');
        $download['date']        = date('D, d-m-y H:i:s e', $xcontent->getVar('date'));
        $download['category']    = $tcategory['text']->getVar('ptitle');
        $category[]              = ucfirst($download['category']);
        $rss['item'][$storyid]   = $download;
    }
    $rss['category'] = array_unique($category);

    return $rss;
}

$myts = \MyTextSanitizer::getInstance();

$rssfeed_data = rss_data($catid, $language);

header('content-type: text/xml; charset=' . _CHARSET);
?><?php echo '<?xml version="1.0" encoding="iso-8859-1"?>' . chr(10) . chr(13); ?>
<rss version="2.0">

    <channel>

        <?php if (!isset($_REQUEST['ms'])) {
            ?>
            <description><?php echo htmlspecialchars($xoopsConfig['slogan'], ENT_QUOTES | ENT_HTML5) . ' ' . htmlspecialchars(implode(', ', $rssfeed_data['category']), ENT_QUOTES | ENT_HTML5); ?></description>
            <lastBuildDate><?php echo date('D, d-m-y H:i:s e', time()); ?></lastBuildDate>
            <docs>http://backend.userland.com/rss/</docs>
            <generator><?php echo(htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES | ENT_HTML5)); ?></generator>
            <category><?php echo implode(', ', $rssfeed_data['category']); ?></category>
            <managingEditor><?php echo $xoopsConfig['adminmail']; ?></managingEditor>
            <webMaster><?php echo $xoopsConfig['adminmail']; ?></webMaster>
            <?php
        } ?>
        <language>en</language>
        <?php if (!isset($_REQUEST['ms'])) {
            ?>
            <image>
                <title><?php echo(htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES | ENT_HTML5)); ?></title>
                <url><?php echo XOOPS_URL; ?>/images/logo.png
                </url>
                <link><?php echo XOOPS_URL; ?>/</link>
            </image>
            <title>RSS Feed | <?php echo htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES | ENT_HTML5) . ' | ' . ucfirst($rssfeed_data['category'][0]); ?> </title>
            <link><?php echo XOOPS_URL; ?></link>
            <?php
        } ?>
        <?php

        foreach ($rssfeed_data['item'] as $item) {
            ?>
            <item>
                <title><?php echo htmlspecialchars($item['title'], ENT_QUOTES | ENT_HTML5); ?></title>
                <link><?php echo htmlspecialchars($item['url'], ENT_QUOTES | ENT_HTML5); ?></link>
                <description><?php echo $item['description']; ?></description>
                <?php if (!isset($_REQUEST['ms'])) {
                    ?>
                    <guid><?php echo htmlspecialchars($item['dossier_url'], ENT_QUOTES | ENT_HTML5); ?></guid>
                    <category><?php echo $item['category']; ?></category>
                    <?php
                } ?>
                <pubDate><?php echo $item['date']; ?></pubDate>
            </item>
            <?php
            /*
            Module: xContent

            Version: 2.01

            Description: Multilingual Content Module with tags and lists with search functions

            Author: Written by Simon Roberts aka. Wishcraft (simon@chronolabs.coop)

            Owner: Chronolabs

            License: See /docs - GPL 2.0
            */
        } ?>
    </channel>
</rss>
