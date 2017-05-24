<?php
include "header.php";
$myts = MyTextSanitizer::getInstance();// MyTextSanitizer object
include_once XOOPS_ROOT_PATH."/class/xoopstree.php";
$mytree = new XoopsTree($xoopsDB->prefix("addresses_cat"),"cid","pid");
$aid = intval($_GET['aid']);
$cid = intval($_GET['cid']);
$xoopsOption['template_main'] = 'addresses_singleaddress.html';
include XOOPS_ROOT_PATH."/header.php";

$sql = "SELECT l.aid, l.cid, l.title, l.address, l.zip, l.city, l.country, l.phone, l.mobile, l.fax, l.contemail, l.opentime, l.url, l.logourl, l.status, l.date, l.hits, l.rating, l.votes, l.comments, t.description";
$sql.= " FROM ".$xoopsDB->prefix("addresses_addresses")." l, ".$xoopsDB->prefix("addresses_addresses_text")." t";
$sql.= " WHERE l.aid=$aid AND l.aid=t.aid AND status>0";
$result = $xoopsDB->query($sql);
list($aid, $cid, $ltitle, $address, $zip, $city, $country, $phone, $mobile, $fax, $contemail, $opentime, $url, $logourl, $status, $time, $hits, $rating, $votes, $comments, $description) = $xoopsDB->fetchRow($result);

$pathstring = "";
//$pathstring = "<a href='index.php'>"._MD_MAIN."</a> : ";
$pathstring .= $mytree->getNicePathFromId($cid, "title", "cat_view.php?op=");
$pathstring = str_replace(':', '>', $pathstring);
//$pathstring = "<a href='index.php'>"._MD_MAIN."</a>&nbsp;:&nbsp;";
//$pathstring .= $mytree->getNicePathFromId($cid, "title", "cat_view.php?op=");
// hack LUCIO - end
$xoopsTpl->assign('category_path', $pathstring);

if ($xoopsUser && $xoopsUser->isAdmin($xoopsModule->mid()))
	{$adminlink = '<a href="'.XOOPS_URL.'/modules/addresses/admin/?op=Address_mod&amp;aid='.$aid.'"><img src="'.XOOPS_URL.'/modules/addresses/images/editicon.gif" border="0" alt="'._MD_EDITTHISLINK.'" /></a>';}
else
	{$adminlink = '';}
if ($votes == 1)
	{$votestring = _MD_ONEVOTE;}
else
	{$votestring = sprintf(_MD_NUMVOTES,$votes);}

if ($xoopsModuleConfig['useshots'] == 1)
	{
	$xoopsTpl->assign('shotwidth', $xoopsModuleConfig['shotwidth']);
	$xoopsTpl->assign('tablewidth', $xoopsModuleConfig['shotwidth'] + 10);
	$xoopsTpl->assign('show_screenshot', true);
	$xoopsTpl->assign('lang_noscreenshot', _MD_NOSHOTS);
	}
$path = $mytree->getPathFromId($cid, "title");
$path = substr($path, 1);
$path = str_replace("/"," <img src='".XOOPS_URL."/modules/addresses/images/arrow.gif' board='0' alt=''> ",$path);
$new = newlinkgraphic($time, $status);
$pop = popgraphic($hits);
$logourl = XOOPS_URL.'/'.$xoopsModuleConfig['shot_path'].'/'.$logourl;

//JE moet hieronder nog aanpassen ivm tonen...
$xoopsTpl->assign('address', array(
	'id'           => $aid,
	'cid'          => $cid,
	'rating'       => number_format($rating, 2),
	'title'        => $myts->makeTboxData4Show($ltitle).$new.$pop,
	'category'     => $path,
	'logourl'      => $myts->makeTboxData4Show($logourl),
	'address'      => $myts->makeTboxData4Show($address),
	'zip'          => $myts->makeTboxData4Show($zip),
	'city'         => $myts->makeTboxData4Show($city),
	'country'      => $myts->makeTboxData4Show($country),
	'phone'        => $myts->makeTboxData4Show($phone),
	'fax'          => $myts->makeTboxData4Show($fax),
	'mobile'       => $myts->makeTboxData4Show($mobile),
	'contemail'    => $myts->makeTboxData4Show($contemail),
	'url'          => $myts->makeTboxData4Show($url),
	'opentime'     => $myts->makeTareaData4Show($opentime),
	'updated'      => formatTimestamp($time,"m"),
	'description'  => $myts->makeTareaData4Show($description,0),
	'adminlink'    => $adminlink,
	'hits'         => $hits,
	'votes'        => $votestring,
	'comments'     => $comments,
	'mail_subject' => rawurlencode(sprintf(_MD_INTRESTLINK,$xoopsConfig['sitename'])),
	'mail_body'    => rawurlencode(sprintf(_MD_INTLINKFOUND,$xoopsConfig['sitename']).':  '.XOOPS_URL.'/modules/addresses/address_single.php?aid='.$aid)
	));
$xoopsTpl->assign('lang_description', _MD_DESCRIPTIONC);
$xoopsTpl->assign('lang_address', _MD_ADDRESS);
$xoopsTpl->assign('lang_zip', _MD_ZIP);
$xoopsTpl->assign('lang_city', _MD_CITY);
$xoopsTpl->assign('lang_country', _MD_COUNTRY);
$xoopsTpl->assign('lang_phone', _MD_PHONE);
$xoopsTpl->assign('lang_fax', _MD_FAX);
$xoopsTpl->assign('lang_mobile', _MD_MOBILE);
$xoopsTpl->assign('lang_contemail', _MD_CONTEMAIL);
$xoopsTpl->assign('lang_website', _MD_WEBSITE);
$xoopsTpl->assign('lang_opened', _MD_OPENED);
//$xoopsTpl->assign('lang_previous', _MD_PREVIOUS); // disabled
$xoopsTpl->assign('lang_lastupdate', _MD_LASTUPDATEC);
$xoopsTpl->assign('lang_hits', _MD_HITSC);
$xoopsTpl->assign('lang_rating', _MD_RATINGC);
$xoopsTpl->assign('lang_ratethissite', _MD_RATETHISSITE);
$xoopsTpl->assign('lang_reportbroken', _MD_REPORTBROKEN);
$xoopsTpl->assign('lang_tellafriend', _MD_TELLAFRIEND);
$xoopsTpl->assign('lang_modify', _MD_MODIFY);
$xoopsTpl->assign('lang_print', _MD_PRINT);  //toegevoegd
$xoopsTpl->assign('lang_category' , _MD_CATEGORYC);
$xoopsTpl->assign('lang_visit' , _MD_VISIT);
$xoopsTpl->assign('lang_comments' , _COMMENTS);
include XOOPS_ROOT_PATH.'/include/comment_view.php';
include XOOPS_ROOT_PATH.'/footer.php';
?>
