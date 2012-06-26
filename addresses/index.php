<?php
include "header.php";
$myts =& MyTextSanitizer::getInstance(); // MyTextSanitizer object
include_once XOOPS_ROOT_PATH."/class/xoopstree.php";
$mytree = new XoopsTree($xoopsDB->prefix("addresses_cat"),"cid","pid");
$xoopsOption['template_main'] = 'addresses_index.html';
include XOOPS_ROOT_PATH."/header.php";

$sql = "SELECT cid, title, imgurl, show_map";
$sql.= " FROM ".$xoopsDB->prefix("addresses_cat");
$sql.= " WHERE pid = 0";
$sql.= " ORDER BY title";
$result=$xoopsDB->query($sql) or exit("Error");

$count = 1;
while($myrow = $xoopsDB->fetchArray($result))
	{
	$imgurl = '';
	if ($myrow['imgurl'] && $myrow['imgurl']!='')
		$imgurl = $myts->makeTboxData4Edit($myrow['imgurl']);
	$totallink = getTotalItems($myrow['cid'], 1);
	// get child category objects
	$arr = array();
	$arr = $mytree->getFirstChild($myrow['cid'], "title");
	$space = 0;
	$chcount = 0;
	$subcategories = '';
	foreach($arr as $ele)
		{
		$chtitle = $myts->makeTboxData4Show($ele['title']);
		if ($chcount > 5)
			{
			$subcategories .= "...";
			break;
			}
		if ($space>0)
			{
			$subcategories .= ", ";
			}
		$subcategories .= "<a href=\"".XOOPS_URL."/modules/addresses/cat_view.php?cid=".$ele['cid']."\">".$chtitle."</a>";
		$space++;
		$chcount++;
		}

	if ($imgurl!='') $imgurl = XOOPS_URL.'/'.$xoopsModuleConfig['shot_path'].'/'.$imgurl;

	$xoopsTpl->append('categories', array(
		'image' => $imgurl,
		'id' => $myrow['cid'],
		'title' => $myts->makeTboxData4Show($myrow['title']),
		'show_map' => $myrow['show_map'],
		'subcategories' => $subcategories,
		'totallink' => $totallink,
		'count' => $count
		));
	$count++;
	}
list($numrows) = $xoopsDB->fetchRow($xoopsDB->query("select count(*) from ".$xoopsDB->prefix("addresses_addresses")." where status>0"));
$xoopsTpl->assign('lang_thereare', sprintf(_MD_THEREARE,$numrows));

$xoopsTpl->assign('api_key', $xoopsModuleConfig['api_key']);

if ($xoopsModuleConfig['useshots'] == 1)
	{
	$xoopsTpl->assign('shotwidth', $xoopsModuleConfig['shotwidth']);
	$xoopsTpl->assign('tablewidth', $xoopsModuleConfig['shotwidth'] + 10);
	$xoopsTpl->assign('show_screenshot', true);
	$xoopsTpl->assign('lang_noscreenshot', _MD_NOSHOTS);
	}

if ($xoopsUser && $xoopsUser->isAdmin($xoopsModule->mid()))
	{
	$isadmin = true;
	}
else
	{
	$isadmin = false;
	}

// set language strings
$xoopsTpl->assign('lang_description', _MD_DESCRIPTIONC);
$xoopsTpl->assign('lang_address', _MD_ADDRESS);
$xoopsTpl->assign('lang_zip', _MD_ZIP);
$xoopsTpl->assign('lang_city', _MD_CITY);
$xoopsTpl->assign('lang_country', _MD_COUNTRY);
$xoopsTpl->assign('lang_phone', _MD_PHONE);
$xoopsTpl->assign('lang_mobile', _MD_MOBILE);
$xoopsTpl->assign('lang_fax', _MD_FAX);	
$xoopsTpl->assign('lang_contemail', _MD_CONTEMAIL);
$xoopsTpl->assign('lang_opened', _MD_OPENED);
$xoopsTpl->assign('lang_viewmore', _MD_VIEWMORE);
$xoopsTpl->assign('lang_lastupdate', _MD_LASTUPDATEC);
$xoopsTpl->assign('lang_hits', _MD_HITSC);
$xoopsTpl->assign('lang_rating', _MD_RATINGC);
$xoopsTpl->assign('lang_ratethissite', _MD_RATETHISSITE);
$xoopsTpl->assign('lang_reportbroken', _MD_REPORTBROKEN);
$xoopsTpl->assign('lang_tellafriend', _MD_TELLAFRIEND);
$xoopsTpl->assign('lang_modify', _MD_MODIFY);
$xoopsTpl->assign('lang_latestlistings' , _MD_LATESTLIST);
$xoopsTpl->assign('lang_category' , _MD_CATEGORYC);
$xoopsTpl->assign('lang_visit' , _MD_VISIT);
$xoopsTpl->assign('lang_comments' , _COMMENTS);

$sql = "SELECT l.aid, l.cid, l.title, l.address, l.zip, l.city, l.country, l.lon, l.lat, l.zoom, l.phone, l.mobile, l.fax, l.contemail, l.opentime, l.url, l.logourl, l.status, l.date, l.hits, l.rating, l.votes, l.comments, t.description";
$sql.= " FROM ".$xoopsDB->prefix("addresses_addresses")." l, ".$xoopsDB->prefix("addresses_addresses_text")." t";
$sql.= " WHERE l.status>0 AND l.aid=t.aid";
$sql.= " ORDER BY date DESC";
$result = $xoopsDB->query($sql, $xoopsModuleConfig['newaddresses'], 0);
while(list($aid, $cid, $ltitle, $address, $zip, $city, $country, $lon, $lat, $zoom, $phone, $mobile, $fax, $contemail, $opentime, $url, $logourl, $status, $time, $hits, $rating, $votes, $comments, $description) = $xoopsDB->fetchRow($result))
	{
	if ($isadmin)
		{$adminlink = '<a href="'.XOOPS_URL.'/modules/addresses/admin/index.php?op=Address_mod&amp;aid='.$aid.'">';
		 $adminlink.= '<img src="'.XOOPS_URL.'/modules/addresses/images/editicon.gif" border="0" alt="'._MD_EDITTHISLINK.'" align="middle" />';
		 $adminlink.= '</a>';}
	else
		{$adminlink = '';}

	if ($votes == 1)
		{$votestring = _MD_ONEVOTE;}
	else
		{$votestring = sprintf(_MD_NUMVOTES,$votes);}

	$path = $mytree->getPathFromId($cid, "title");
	$path = substr($path, 1);
	//Catz edit here.... Added align = 'middle' to place graphic within the middle of the cell.  Well it would have if the class object did not stop it from doing so.
	$path = str_replace("/"," <img src='".XOOPS_URL."/modules/addresses/images/arrow.gif' board='0' alt='' align = 'absmiddle'> ",$path);
	$new = newlinkgraphic($time, $status);
	$pop = popgraphic($hits);

	if ($logourl!='') $logourl = XOOPS_URL.'/'.$xoopsModuleConfig['shot_path'].'/'.$logourl;


	$xoopsTpl->append('addresses', array(
		'id'           => $aid,
		'cid'          => $cid,
		'rating'       => number_format($rating, 2),
		'title'        => $myts->makeTboxData4Show($ltitle),
		'new'          => $new,
		'pop'          => $pop,
		'category'     => $path,
		'logourl'      => $myts->makeTboxData4Show($logourl),
		'address'       => $myts->makeTboxData4Show($address),
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
		'opentime'     => $myts->makeTboxData4Show($opentime),
		'updated'      => formatTimestamp($time,"m"),
		'description'  => $myts->makeTareaData4Show($description,0),
		'adminlink'    => $adminlink,
		'hits'         => $hits,
		'votes'        => $votestring,
		'comments'     => $comments,
		'mail_subject' => rawurlencode(sprintf(_MD_INTRESTLINK,$xoopsConfig['sitename'])),
		'mail_body'    => rawurlencode(sprintf(_MD_INTLINKFOUND,$xoopsConfig['sitename']).':  '.XOOPS_URL.'/modules/addresses/address_single.php?cid='.$cid.'&amp;aid='.$aid)));
	}
include XOOPS_ROOT_PATH.'/footer.php';
?>
