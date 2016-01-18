<?php
include "header.php";
$myts = &MyTextSanitizer::getInstance(); // MyTextSanitizer object
include_once XOOPS_ROOT_PATH . "/class/xoopstree.php";
include_once XOOPS_ROOT_PATH . "/class/module.errorhandler.php";
$mytree = new XoopsTree($xoopsDB->prefix("addresses_cat"), "cid", "pid");

if (!empty($_POST['submit']))
	{
	$eh = new ErrorHandler; //ErrorHandler object
	if (empty($xoopsUser))
		{
	redirect_header(XOOPS_URL . "/user.php", 2, _MD_MUSTREGFIRST);
	exit();
	}
else
	{
	$user = $xoopsUser->getVar('uid');
	}
	$aid = intval($_POST["aid"]);
	// Check if Title exist
	if ($_POST["title"] == "")
		{
		$eh->show("1001");
		}
	// Check if URL exist
	// if ($_POST["url"]=="") {
	// $eh->show("1016");
	// }
	// Check if Description exist
	//if ($_POST['description'] == ""){
	//    $eh->show("1008");
	//} 

	$url         = $myts->makeTboxData4Save($_POST["url"]);
	$logourl     = $myts->makeTboxData4Save($_POST["logourl"]);
	$cid         = intval($_POST["cid"]);
	$title       = $myts->makeTboxData4Save($_POST["title"]);
	$description = $myts->makeTareaData4Save($_POST["description"]);
	$address     = $myts->makeTareaData4Save($_POST["address"]);
	$zip         = $myts->makeTareaData4Save($_POST["zip"]);
	$city        = $myts->makeTareaData4Save($_POST["city"]);
	$country     = $myts->makeTareaData4Save($_POST["country"]);
	$lon         = $myts->makeTareaData4Save($_POST["lon"]);
	$lat         = $myts->makeTareaData4Save($_POST["lat"]);
	$zoom        = $myts->makeTareaData4Save($_POST["zoom"]);
	$phone       = $myts->makeTareaData4Save($_POST["phone"]);
	$mobile      = $myts->makeTareaData4Save($_POST["mobile"]);
	$fax         = $myts->makeTareaData4Save($_POST["fax"]);
	$contemail   = $myts->makeTareaData4Save($_POST["contemail"]);
	$opentime    = $myts->makeTareaData4Save($_POST["opentime"]);
	$newid       = $xoopsDB->genId($xoopsDB->prefix("addresses_mod") . "_requestid_seq"); 
	// % INVOEGEN ANDERS WERKT MODIFICATIE VERZOEK NIET
//hack LUCIO - start
	$sql = "INSERT INTO %s (requestid, aid, cid, title, address, zip,  city, country, lon, lat, zoom, phone, mobile, fax,  contemail, opentime, url,  logourl, description, modifysubmitter)";
	$sql.= " VALUES        (%u,        %u,  %u,  '%s',  '%s',   '%s', '%s', '%s',    %f,  %f,  %u,   '%s',  '%s',   '%s', '%s',      '%s',     '%s', '%s',    '%s',        %u)"; 
	$sql = sprintf($sql, $xoopsDB->prefix("addresses_mod"), $newid, $aid, $cid, $title, $address, $zip, $city, $country, $lon, $lat, $zoom, $phone, $mobile, $fax, $contemail, $opentime, $url, $logourl, $description, $user);
//hack LUCIO - end
	$xoopsDB->query($sql) or $eh->show("0013");
	$tags = array();
	$tags['MODIFYREPORTS_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/admin/index.php?op=ModReqAddress_list';
	$notification_handler = &xoops_gethandler('notification');
	$notification_handler->triggerEvent('global', 0, 'address_modify', $tags);
	redirect_header("index.php", 2, _MD_THANKSFORINFO);
	exit();
	}
else
	{
	$aid = intval($_GET['aid']);
	if (empty($xoopsUser))
		{
		redirect_header(XOOPS_URL . "/user.php", 2, _MD_MUSTREGFIRST);
		exit();
		}
	$xoopsOption['template_main'] = 'addresses_modaddress.html';
	include XOOPS_ROOT_PATH . "/header.php";
	$sql = "SELECT cid, title, address, zip, city, country, lon, lat, zoom, phone, mobile, fax, contemail, opentime, url, logourl, submitter, status, date, hits, rating";
	$sql.= " FROM " . $xoopsDB->prefix("addresses_addresses");
	$sql.= " WHERE aid=".$aid." AND status>0"; 
	$result = $xoopsDB->query($sql);
	$xoopsTpl->assign('lang_requestmod', _MD_REQUESTMOD);
	list($cid, $title, $address, $zip, $city, $country, $lon, $lat, $zoom, $phone, $mobile, $fax, $contemail, $opentime, $url, $logourl, $submitter, $status, $time, $hits, $rating) = $xoopsDB->fetchRow($result);
	$result2 = $xoopsDB->query("SELECT description FROM " . $xoopsDB->prefix("addresses_addresses_text") . " WHERE aid=$aid");
	list($description) = $xoopsDB->fetchRow($result2);

	$xoopsTpl->assign('address', array(
		'id'          => $aid,
		'rating'      => number_format($rating, 2),
		'title'       => $myts->htmlSpecialChars($title),
		'address'     => $myts->htmlSpecialChars($address),
		'zip'         => $myts->htmlSpecialChars($zip),
		'city'        => $myts->htmlSpecialChars($city),
		'country'     => $myts->htmlSpecialChars($country),
// hack LUCIO - start
		'lon'         => $myts->htmlSpecialChars($lon),
		'lat'         => $myts->htmlSpecialChars($lat),
		'zoom'        => $myts->htmlSpecialChars($zoom),
// hack LUCIO - end
		'phone'       => $myts->htmlSpecialChars($phone),
		'fax'         => $myts->htmlSpecialChars($fax),
		'mobile'      => $myts->htmlSpecialChars($mobile),
		'contemail'   => $myts->htmlSpecialChars($contemail),
		'opentime'    => $myts->htmlSpecialChars($opentime),
		'url'         => $myts->htmlSpecialChars($url),
		'logourl'     => $myts->htmlSpecialChars($logourl),
		'updated'     => formatTimestamp($time, "m"),
		'description' => $myts->htmlSpecialChars($description),
		'hits'        => $hits
		));

// hack LUCIO - start
	$xoopsTpl->assign('api_key', $xoopsModuleConfig['api_key']);
	$xoopsTpl->assign('default_lat', $xoopsModuleConfig['default_lat']);
	$xoopsTpl->assign('default_lon', $xoopsModuleConfig['default_lon']);
	$xoopsTpl->assign('default_zoom', $xoopsModuleConfig['default_zoom']);
	$xoopsTpl->assign('default_address', $xoopsModuleConfig['default_address']);
	$xoopsTpl->assign('popup_options', $xoopsModuleConfig['popup_options']);
// hack LUCIO - end

	$xoopsTpl->assign('lang_modify', _MD_MODLINK2);
	$xoopsTpl->assign('lang_linkid', _MD_LINKID);
	$xoopsTpl->assign('lang_sitetitle', _MD_SITETITLE);
	$xoopsTpl->assign('lang_address', _MD_ADDRESS);
	$xoopsTpl->assign('lang_zip', _MD_ZIP);
	$xoopsTpl->assign('lang_city', _MD_CITY);
	$xoopsTpl->assign('lang_country', _MD_COUNTRY);
// hack LUCIO - start
	$xoopsTpl->assign('lang_lon', _MD_LON);
	$xoopsTpl->assign('lang_lat', _MD_LAT);
	$xoopsTpl->assign('lang_zoom', _MD_ZOOM);
	$xoopsTpl->assign('lang_map', _MD_MAP);
// hack LUCIO - end
	$xoopsTpl->assign('lang_phone', _MD_PHONE);
	$xoopsTpl->assign('lang_fax', _MD_FAX);
	$xoopsTpl->assign('lang_mobile', _MD_MOBILE);
	$xoopsTpl->assign('lang_contemail', _MD_CONTEMAIL);
	$xoopsTpl->assign('lang_opened', _MD_OPENED);
	$xoopsTpl->assign('lang_siteurl', _MD_SITEURL);
	$xoopsTpl->assign('lang_category', _MD_CATEGORYC);
	ob_start();
	$mytree->makeMySelBox("title", "title", $cid);
	$selbox = ob_get_contents();
	ob_end_clean();
	$xoopsTpl->assign('category_selbox', $selbox);
	$xoopsTpl->assign('lang_description', _MD_DESCRIPTIONC);
	$xoopsTpl->assign('lang_sendrequest', _MD_SENDREQUEST);
	$xoopsTpl->assign('lang_cancel', _CANCEL);
	include XOOPS_ROOT_PATH . '/footer.php';
	}
?>
