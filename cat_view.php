<?php
include "header.php";
$myts =& MyTextSanitizer::getInstance(); // MyTextSanitizer object
include_once XOOPS_ROOT_PATH."/class/xoopstree.php";
$mytree = new XoopsTree($xoopsDB->prefix("addresses_cat"),"cid","pid");

$cid = intval($_GET['cid']);
$xoopsOption['template_main'] = 'addresses_viewcat.html';
include XOOPS_ROOT_PATH."/header.php";

if (isset($_GET['show']))
	$show = intval($_GET['show']);
else
	$show = $xoopsModuleConfig['perpage'];

$min = isset($_GET['min']) ? intval($_GET['min']) : 0;
if (!isset($max))
	$max = $min + $show;

if(isset($_GET['orderby']))
	$orderby = convertorderbyin($_GET['orderby']);
else
	$orderby = "title ASC";



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

$description = "";
$sql = "SELECT description";
$sql.= " FROM ".$xoopsDB->prefix("addresses_cat_text");
$sql.= " WHERE cid=".$cid;
$result=$xoopsDB->query($sql) or exit("Error");
list($description) = $xoopsDB->fetchRow($result);

if ($imgurl!='') $imgurl = XOOPS_URL.'/'.$xoopsModuleConfig['shot_path'].'/'.$imgurl;

$xoopsTpl->assign('category_title', $myts->makeTboxData4Show($title));
$xoopsTpl->assign('category_imgurl', $imgurl);
$xoopsTpl->assign('category_show_map', $show_map);
$xoopsTpl->assign('category_description', $myts->makeTareaData4Show($description,0));


// get child category objects
$arr=array();
$arr=$mytree->getFirstChild($cid, "title");
if ( count($arr) > 0 )
	{
	$scount = 1;
	foreach($arr as $ele)
		{
		$sub_arr=array();
		$sub_arr=$mytree->getFirstChild($ele['cid'], "title");
		$space = 0;
		$chcount = 0;
		$infercategories = "";
		foreach($sub_arr as $sub_ele)
			{
			$chtitle=$myts->makeTboxData4Show($sub_ele['title']);
			if ($chcount>5)
				{
				$infercategories .= "...";
				break;
				}
			if ($space>0)
				{
				$infercategories .= ", ";
				}
			$infercategories .= "<a href=\"".XOOPS_URL."/modules/addresses/cat_view.php?cid=".$sub_ele['cid']."\">".$chtitle."</a>";
			$space++;
			$chcount++;
			}
		$xoopsTpl->append('subcategories', array(
			'title' => $myts->makeTboxData4Show($ele['title']),
			'id' => $ele['cid'],
			'infercategories' => $infercategories,
			'totaladdresses' => getTotalItems($ele['cid'], 1),
			'count' => $scount
			));
		$scount++;
		}
	}

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

if (!empty($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->mid()))
	{
	$isadmin = true;
	}
else
	{
	$isadmin = false;
	}
$fullcountresult=$xoopsDB->query("SELECT count(*) FROM ".$xoopsDB->prefix("addresses_addresses")." WHERE cid=$cid and status>0");
list($numrows) = $xoopsDB->fetchRow($fullcountresult);
$page_nav = '';
if($numrows>0)
	{
	$xoopsTpl->assign('lang_description', _MD_DESCRIPTIONC);
	$xoopsTpl->assign('lang_address', _MD_ADDRESS);
	$xoopsTpl->assign('lang_zip', _MD_ZIP);
	$xoopsTpl->assign('lang_city', _MD_CITY);
	$xoopsTpl->assign('lang_country', _MD_COUNTRY);
	$xoopsTpl->assign('lang_phone', _MD_PHONE);
	$xoopsTpl->assign('lang_fax', _MD_FAX);
	$xoopsTpl->assign('lang_mobile', _MD_MOBILE);
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
	$xoopsTpl->assign('lang_category' , _MD_CATEGORYC);
	$xoopsTpl->assign('lang_visit' , _MD_VISIT);
	$xoopsTpl->assign('show_addresses', true);
	$xoopsTpl->assign('lang_comments' , _COMMENTS);

	$sql = "SELECT l.aid, l.cid, l.title, l.address, l.zip, l.city, l.country, l.lon, l.lat, l.zoom, l.phone, l.mobile, l.fax, l.contemail, l.opentime, l.url, l.logourl, l.status, l.date, l.hits, l.rating, l.votes, l.comments, t.description";
	$sql.= " FROM ".$xoopsDB->prefix("addresses_addresses")." l, ".$xoopsDB->prefix("addresses_addresses_text")." t";
	$sql.= " WHERE cid=$cid AND l.aid=t.aid AND status>0";
	$sql.= " ORDER BY $orderby";

	$result=$xoopsDB->query($sql,$show,$min);

	//if 2 or more items in result, show the sort menu
	if($numrows>1)
		{
		$xoopsTpl->assign('show_nav', true);
		$orderbyTrans = convertorderbytrans($orderby);
		$xoopsTpl->assign('lang_sortby', _MD_SORTBY);
		$xoopsTpl->assign('lang_title', _MD_TITLE);
		$xoopsTpl->assign('lang_date', _MD_DATE);
		$xoopsTpl->assign('lang_rating', _MD_RATING);
		$xoopsTpl->assign('lang_popularity', _MD_POPULARITY);
		$xoopsTpl->assign('lang_cursortedby', sprintf(_MD_CURSORTEDBY, convertorderbytrans($orderby)));
		}

	while(list($aid, $cid, $ltitle, $address, $zip, $city, $country, $lon, $lat, $zoom, $phone, $mobile, $fax, $contemail, $opentime, $url, $logourl, $status, $time, $hits, $rating, $votes, $comments, $description) = $xoopsDB->fetchRow($result))
		{
		if ($isadmin)
			{
			$adminlink = '<a href="'.XOOPS_URL.'/modules/addresses/admin/index.php?op=Address_mod&amp;aid='.$aid.'">';
			$adminlink.= '<img src="'.XOOPS_URL.'/modules/addresses/images/editicon.gif" border="0" alt="'._MD_EDITTHISLINK.'" />';
			$adminlink.= '</a>';
			}
		else
			$adminlink = '';
		if ($votes == 1)
			$votestring = _MD_ONEVOTE;
		else
			$votestring = sprintf(_MD_NUMVOTES,$votes);

		$path = $mytree->getPathFromId($cid, "title");
		$path = substr($path, 1);
		$path = str_replace("/"," <img src='".XOOPS_URL."/modules/addresses/images/arrow.gif' board='0' alt=''> ",$path);
		$new = newlinkgraphic($time, $status);
		$pop = popgraphic($hits);
		//JE moet hieronder nog aanpassen ivm tonen...
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
			'opentime'     => $myts->makeTboxData4Show($opentime),
			'updated'      => formatTimestamp($time,"m"),
			'description'  => $myts->makeTareaData4Show($description,0),
			'adminlink'    => $adminlink, 'hits' => $hits,
			'comments'     => $comments,
			'votes'        => $votestring,
			'mail_subject' => rawurlencode(sprintf(_MD_INTRESTLINK,$xoopsConfig['sitename'])),
			'mail_body'    => rawurlencode(sprintf(_MD_INTLINKFOUND,$xoopsConfig['sitename']).':  '.XOOPS_URL.'/modules/addresses/address_single.php?cid='.$cid.'&amp;aid='.$aid)
			));
		}
	$orderby = convertorderbyout($orderby);
	//Calculates how many pages exist.  Which page one should be on, etc...
	$linkpages = ceil($numrows / $show);
	//Page Numbering
	if ($linkpages!=1 && $linkpages!=0)
		{
		$cid = intval($_GET['cid']);
		$prev = $min - $show;
		if ($prev>=0)
			{
			$page_nav .= "<a href='cat_view.php?cid=$cid&amp;min=$prev&amp;orderby=$orderby&amp;show=$show'><b><u>&laquo;</u></b></a>&nbsp;";
			}
		$counter = 1;
		$currentpage = ($max / $show);
		while ( $counter<=$linkpages )
			{
			$mintemp = ($show * $counter) - $show;
			if ($counter == $currentpage)
				{
				$page_nav .= "<b>($counter)</b>&nbsp;";
				}
			else
				{
				$page_nav .= "<a href='cat_view.php?cid=$cid&amp;min=$mintemp&amp;orderby=$orderby&amp;show=$show'>$counter</a>&nbsp;";
				}
			$counter++;
			}
		if ( $numrows>$max )
			{
			$page_nav .= "<a href='cat_view.php?cid=$cid&amp;min=$max&amp;orderby=$orderby&amp;show=$show'>";
			$page_nav .= "<b><u>&raquo;</u></b></a>";
			}
		}
	}
	$xoopsTpl->assign('page_nav', $page_nav);
	include XOOPS_ROOT_PATH.'/footer.php';
?>
