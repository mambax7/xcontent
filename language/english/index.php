<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project (https://xoops.org)
 * @license      GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @author       XOOPS Development Team
 */

use Xmf\Module\Admin;
use XoopsModules\Xcontent\Common;

require_once __DIR__ . '/admin_header.php';
// Display Admin header
xoops_cp_header();
$adminObject = Admin::getInstance();

//check or upload folders
$configurator = new Common\Configurator();
foreach (array_keys($configurator->uploadFolders) as $i) {
    $utility::createFolder($configurator->uploadFolders[$i]);
    $adminObject->addConfigBoxLine($configurator->uploadFolders[$i], 'folder');
}

//-------------------------------------
//count "total quotes"
$quotesCount = $quotesHandler->getCount();
// InfoBox quotes
$adminObject->addInfoBox(_AM_RANDOMQUOTE_STATISTICS);
// InfoBox quotes
$adminObject->addInfoBoxLine(sprintf(_AM_RANDOMQUOTE_THEREARE_QUOTES, $quotesCount));

// or

$adminObject->addInfoBox(_AM_LEXIKON_SUMMARY);
$adminObject->addInfoBoxLine(sprintf(_AM_LEXIKON_TOTALENTRIES2, '<span class="green">' . $summary['publishedEntries'] . '</span>'), '', 'green');
$adminObject->addInfoBoxLine(sprintf(_AM_LEXIKON_TOTALCATS2, '<span class="green">' . $summary['availableCategories'] . '</span>'), '', 'green');
$adminObject->addInfoBoxLine(sprintf(_AM_LEXIKON_TOTALSUBM2, '<span class="red">' . $summary['submittedEntries'] . '</span>'), '', 'red');
$adminObject->addInfoBoxLine(sprintf(_AM_LEXIKON_TOTALREQ2, '<span class="red">' . $summary['requestedEntries'] . '</span>'), '', 'red');

$adminObject->addInfoBox(_AM_SOAPBOX_MODCONTENT);
if ($totcol > 0) {
    $adminObject->addInfoBoxLine(sprintf('<infolabel>' . '<a href="main.php">' . _AM_SOAPBOX_TOTCOL . '</a>' . '</infolabel>', '<span class="green">' . $totcol . '</span>'), '', 'green');
} else {
    $adminObject->addInfoBoxLine(sprintf('<infolabel>' . _AM_SOAPBOX_TOTCOL . '</infolabel>', '<span class="green">' . $totcol . '</span>'), '', 'Green');
}
if ($totpub > 0) {
    $adminObject->addInfoBoxLine(sprintf('<infolabel>' . '<a href="main.php">' . _AM_SOAPBOX_TOTART . '</a>' . '</infolabel>', '<span class="green">' . $totpub . '</span>'), '', 'green');
} else {
    $adminObject->addInfoBoxLine(sprintf('<infolabel>' . _AM_SOAPBOX_TOTART . '</infolabel>', '<span class="green">' . $totpub . '</span>'), '', 'green');
}
if ($totoff > 0) {
    $adminObject->addInfoBoxLine(sprintf('<infolabel>' . '<a href="main.php">' . _AM_SOAPBOX_TOTOFF . '</a>' . '</infolabel>', '<span class="red">' . $totoff . '</span>'), '', 'red');
} else {
    $adminObject->addInfoBoxLine(sprintf('<infolabel>' . _AM_SOAPBOX_TOTOFF . '</infolabel>', '<span class="green">' . $totoff . '</span>'), '', 'green');
}
if ($totall > 0) {
    $adminObject->addInfoBoxLine(sprintf('<infolabel>' . '<a href="main.php">' . _AM_SOAPBOX_TOTSUB . '</a>' . '</infolabel>', '<span class="green">' . $totall . '</span>'), '', 'green');
} else {
    $adminObject->addInfoBoxLine(sprintf('<infolabel>' . _AM_SOAPBOX_TOTSUB . '</infolabel>', '<span class="green">' . $totall . '</span>'), '', 'green');
}

if ($totsub > 0) {
    $adminObject->addInfoBoxLine(sprintf('<infolabel>' . '<a href="submissions.php">' . _AM_SOAPBOX_NEED_APPROVAL . '</a>' . '</infolabel>', '<span class="green">' . $totsub . '</span>'), '', 'red');
} else {
    $adminObject->addInfoBoxLine(sprintf('<infolabel>' . _AM_SOAPBOX_NEED_APPROVAL . '</infolabel>', '<span class="green">' . $totsub . '</span>'), '', 'green');
}

$adminObject->displayNavigation(basename(__FILE__));

//check for latest release
//$newRelease = $utility::checkVerModule($helper);
//if (!empty($newRelease)) {
//    $adminObject->addItemButton($newRelease[0], $newRelease[1], 'download', 'style="color : Red"');
//}

//------------- Test Data Buttons ----------------------------
if ($helper->getConfig('displaySampleButton')) {
    TestdataButtons::loadButtonConfig($adminObject);
    $adminObject->displayButton('left', '');
}
$op = Request::getString('op', 0, 'GET');
switch ($op) {
    case 'hide_buttons':
        TestdataButtons::hideButtons();
        break;
    case 'show_buttons':
        TestdataButtons::showButtons();
        break;
}
//------------- End Test Data Buttons ----------------------------

$adminObject->displayIndex();

echo $utility::getServerStats();

require_once __DIR__ . '/admin_footer.php';
