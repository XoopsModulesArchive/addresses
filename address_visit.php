<?php
include '../../mainfile.php';
$myts =& MyTextSanitizer::getInstance(); // MyTextSanitizer object
include_once XOOPS_ROOT_PATH."/class/xoopstree.php";
$mytree = new XoopsTree($xoopsDB->prefix("addresses_cat"),"cid","pid");
$aid = intval($_GET['aid']);
$cid = intval($_GET['cid']);
$sql = sprintf("UPDATE %s SET hits = hits+1 WHERE aid = %u AND status > 0", $xoopsDB->prefix("addresses_addresses"), $aid);
$xoopsDB->queryF($sql);
$result = $xoopsDB->query("select url from ".$xoopsDB->prefix("addresses_addresses")." where aid=$aid and status>0");
list($url) = $xoopsDB->fetchRow($result);
$xoopsOption['template_main'] = 'addresses_singleaddress.html';
include XOOPS_ROOT_PATH."/header.php";

$sql = "SELECT l.aid, l.cid, l.title, l.address, l.zip, l.city, l.country, l.lon, l.lat, l.zoom, l.phone, l.mobile, l.fax, l.contemail, l.url, l.opentime, l.logourl, l.status, l.date, l.hits, l.rating, l.votes, l.comments, t.description";
$sql.= " FROM ".$xoopsDB->prefix("addresses_addresses")." l, ".$xoopsDB->prefix("addresses_addresses_text")." t";
$sql.= " WHERE l.aid=$aid AND l.aid=t.aid AND status>0";
$result = $xoopsDB->query($sql);
list($aid, $cid, $ltitle, $address, $zip, $city, $country, $lon, $lat, $zoom, $phone, $mobile, $fax, $contemail, $url, $opentime, $logourl, $status, $time, $hits, $rating, $votes, $comments, $description) = $xoopsDB->fetchRow($result);

$pathstring = "";
//$pathstring = "<a href='index.php'>"._MD_MAIN."</a> : ";
$pathstring .= $mytree->getNicePathFromId($cid, "title", "cat_view.php?op=");
$pathstring = str_replace(':', '>', $pathstring);
//$pathstring = "<a href='index.php'>"._MD_MAIN."</a>&nbsp;:&nbsp;";
//$pathstring .= $mytree->getNicePathFromId($cid, "title", "cat_view.php?op=");
$xoopsTpl->assign('category_path', $pathstring);
$xoopsTpl->assign('category_id', $cid);
$sql = "SELECT title, imgurl, show_map";
$sql.= " FROM ".$xoopsDB->prefix("addresses_cat");
$sql.= " WHERE cid=".$cid;
$result=$xoopsDB->query($sql) or exit("Error");
list($title, $imgurl, $show_map) = $xoopsDB->fetchRow($result);
if ($imgurl && $imgurl != "http://")
	{$imgurl = $myts->makeTboxData4Edit($imgurl);}
else
	{$imgurl = '';}
$xoopsTpl->assign('category_title', $myts->makeTboxData4Show($title));
$xoopsTpl->assign('category_imgurl', $imgurl);
$xoopsTpl->assign('category_show_map', $show_map);

if ($xoopsUser && $xoopsUser->isAdmin($xoopsModule->mid()))
	{$adminlink = '<a href="'.XOOPS_URL.'/modules/addresses/admin/index.php?op=Address_mod&amp;aid='.$aid.'">';
	 $adminlink.= '<img src="'.XOOPS_URL.'/modules/addresses/images/editicon.gif" border="0" alt="'._MD_EDITTHISLINK.'"  align="middle"/>';
	 $adminlink.= '</a>';}
else
	{$adminlink = '';}
if ($votes == 1)
	{$votestring = _MD_ONEVOTE;}
	else
	{$votestring = sprintf(_MD_NUMVOTES,$votes);}

$xoopsTpl->assign('api_key', $xoopsModuleConfig['api_key']);
$xoopsTpl->assign('default_lat', $xoopsModuleConfig['default_lat']);
$xoopsTpl->assign('default_lon', $xoopsModuleConfig['default_lon']);
$xoopsTpl->assign('default_zoom', $xoopsModuleConfig['default_zoom']);
$xoopsTpl->assign('default_address', $xoopsModuleConfig['default_address']);

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
//$new = newlinkgraphic($time, $status);
//$pop = popgraphic($hits);

if ($logourl!='')
$logourl = XOOPS_URL.'/'.$xoopsModuleConfig['shot_path'].'/'.$logourl;

$xoopsTpl->assign('address', array(
	'id'           => $aid,
	'cid'          => $cid,
	'rating'       => number_format($rating, 2),
	'title'        => $myts->makeTboxData4Show($ltitle),
	'category'     => $path,
	'logourl'      => $myts->makeTboxData4Show($logourl),
	'address'      => $myts->makeTboxData4Show($address),
	'zip'          => $myts->makeTboxData4Show($zip),
	'city'         => $myts->makeTboxData4Show($city),
	'country'      => $myts->makeTboxData4Show($country),
	'lon'          => $lon,
	'lat'          => $lat,
	'zoom'         => $zoom,
	'phone'        => $myts->makeTboxData4Show($phone),
	'fax'          => $myts->makeTboxData4Show($fax),
	'mobile'       => $myts->makeTboxData4Show($mobile),
	'contemail'    => $myts->makeTboxData4Show($contemail),
	'url'          => $myts->makeTboxData4Show($url),
	'opentime'     => $myts->makeTareaData4Show($opentime),
	'updated'      => formatTimestamp($time,"m"),
	'description'  => $myts->makeTareaData4Show($description,1),
	'adminlink'    => $adminlink,
	'hits'         => $hits,
	'votes'        => $votestring,
	'comments'     => $comments,
	'mail_subject' => rawurlencode(sprintf(_MD_INTRESTLINK,$xoopsConfig['sitename'])),
	'mail_body'    => rawurlencode(sprintf(_MD_INTLINKFOUND,$xoopsConfig['sitename']).':  '.XOOPS_URL.'/modules/addresses/visitlink.php?aid='.$aid)
	));

$xoopsTpl->assign('lang_description', _MD_DESCRIPTIONC);
$xoopsTpl->assign('lang_address', _MD_ADDRESS);
$xoopsTpl->assign('lang_zip', _MD_ZIP);
$xoopsTpl->assign('lang_city', _MD_CITY);
$xoopsTpl->assign('lang_country', _MD_COUNTRY);
$xoopsTpl->assign('lang_map', _MD_MAP);
$xoopsTpl->assign('lang_phone', _MD_PHONE);
$xoopsTpl->assign('lang_fax', _MD_FAX);
$xoopsTpl->assign('lang_mobile', _MD_MOBILE);
$xoopsTpl->assign('lang_contemail', _MD_CONTEMAIL);
$xoopsTpl->assign('lang_website', _MD_WEBSITE);
$xoopsTpl->assign('lang_opened', _MD_OPENED);
$xoopsTpl->assign('lang_previous', _MD_PREVIOUS);
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
//include XOOPS_ROOT_PATH.'/include/comment_view.php';
include XOOPS_ROOT_PATH.'/footer.php';
?>
