<?php
/////////////////////////////////////////////////////////////
// Title    : Frame Branding Hack for Xoops Mylinks        //
// Author   : Freeop                                       //
// Email    : Webmaster@belizecountry.com                  //
// Website  : http://www.Belizecountry.com                 //
// System   : Xoops RC 3.0.4 / 3.0.5             10-14-02  //
// Filename : myheader.php                                 //
// Type     : Module Hack for MyLinks                      //
/////////////////////////////////////////////////////////////

// Code below uses users current selected theme style      //

include "../../mainfile.php";
$url = $_GET['url'];
$aid = intval($_GET['aid']);
$cid = intval($_GET['cid']);
echo "<html><head><style><!--.bg1 {    background-color : #E3E4E0;}.bg2 {    background-color : #e5e5e5;}.bg3 {     background-color : #f6f6f6;}.bg4 {    background-color : #f0f0f0;}.bg5 {    background-color : f8f8f8;}body { margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;font-family: Tahoma, taipei; color;#000000; font-size: 10px; background-color : #2F5376; color: #ffffff;}a {  font-weight: bold;font-family: Tahoma, taipei; font-size: 10px; text-decoration: none; color: #666666; font-style: normal}A:hover {  font-weight: bold;text-decoration: underline;  font-family: Tahoma, taipei; font-size: 10px; color: #FF9966; font-style: normal}td {  font-family: Tahoma, taipei; color: #000000; font-size: 10px;border-top-width : 1px; border-right-width : 1px; border-bottom-width : 1px; border-left-width : 1px;}img { border:0;}//--></style>";
$mail_subject = rawurlencode(sprintf(_MD_INTRESTLINK,$xoopsConfig['sitename']));
$mail_body = rawurlencode(sprintf(_MD_INTLINKFOUND,$xoopsConfig['sitename']).':  '.XOOPS_URL.'/modules/addresses/address_single.php?cid='.$cid.'&amp;aid='.$aid);
?>

</head><body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="150"><a href="<? echo XOOPS_URL; ?>" target="_BLANK"><img src="<? echo XOOPS_URL; ?>/images/logo.gif" alt="" /></a>
<td width="100%" align="center">
<table class="bg3" width=95% cellspacing="2" cellpadding="3" border="0" style="border: #e0e0e0 1px solid;"><tr>
<td style="border-bottom: #e0e0e0 1px solid;">
<b><? echo $xoopsConfig['sitename']; ?></b></td>
</tr>
<tr>
<td class='bg4' align="center"><small>
<a target="main" href="address_rate.php?cid=<? echo $cid; ?>&amp;aid=<? echo $aid; ?>"><? echo _MD_RATETHISSITE; ?></a> | <a target="main" href="address_mod.php?aid=<? echo $aid; ?>"><? echo _MD_MODIFY; ?></a> | <a target="main" href="address_broken.php?aid=<? echo $aid; ?>"><? echo _MD_REPORTBROKEN; ?></a> | <a target='_top' href='mailto:?subject=<? echo $mail_subject; ?>&body=<? echo $mail_body;?>'><? echo _MD_TELLAFRIEND; ?></a> | <a target='_top' href="<? echo XOOPS_URL; ?>">Back to <? echo $xoopsConfig['sitename']; ?></a> | <a target='_top' href="<? echo $url; ?>">Close Frame</a>
</small></td></tr></table>
</td></tr></table></body></html>
