<?php
include "header.php";
$myts = MyTextSanitizer::getInstance();// MyTextSanitizer object
include_once XOOPS_ROOT_PATH."/class/xoopstree.php";
include_once XOOPS_ROOT_PATH."/class/module.errorhandler.php";
include_once XOOPS_ROOT_PATH."/include/xoopscodes.php";

$eh = new ErrorHandler; //ErrorHandler object
$mytree = new XoopsTree($xoopsDB->prefix("addresses_cat"),"cid","pid");
//Catz edit..... Changed to !is_object rather than using !$xoopsUser  
if (!is_object($xoopsUser) && !$xoopsModuleConfig['anonpost'])
	{
	redirect_header(XOOPS_URL."/user.php",2,_MD_MUSTREGFIRST);
	exit();
	}
//End Catz edit

if (!empty($_POST['submit']))
	{
	$submitter = !empty($xoopsUser) ? $xoopsUser->getVar('uid') : 0;

	// RMV - why store submitter on form??
	//if (!$_POST['submitter'] and $xoopsUser) {
	//$submitter = $xoopsUser->uid();
	//}elseif(!$_POST['submitter'] and !$xoopsUser) {
	//	$submitter = 0;
	//}else{
	//	$submitter = intval($_POST['submitter']);
	//}

	// Check if Title exist
	if ($_POST["title"]=="")
		{
		$eh->show("1001");
		}

	// Check if URL exist for addresses 
	// SHINE: BECAUSE URL ISN'T IMPORTANT WITHIN ADDRESSES THIS FEATURE IS DISABLED
	//$url = $_POST["url"];
	//if ($url=="" || !isset($url)) {
	//   	$eh->show("1016");
	//}

	// Check if Description exist
	if ($_POST['message']=="")
		{
		$eh->show("1008");
		}

	$notify = !empty($_POST['notify']) ? 1 : 0;

	if ( !empty($_POST['cid']) )
		{
		$cid = intval($_POST['cid']);
		}
	else
		{
		$cid = 0;
		}
	//Catz edit....Replaced URL back into form submit 
	// Shine: url was already there just not within template submitform. disabled this
	//$url = urlencode($url);
	//$url = $myts->makeTboxData4Save($url);
	//stop
	$title       = $myts->makeTboxData4Save($_POST["title"]);
	$address     = $myts->makeTboxData4Save($_POST["address"]);
	$zip         = $myts->makeTboxData4Save($_POST["zip"]);
	$city        = $myts->makeTboxData4Save($_POST["city"]);
	$country     = $myts->makeTboxData4Save($_POST["country"]);
// hack LUCIO - start
	$lon         = $myts->makeTareaData4Save($_POST["lon"]);
	$lat         = $myts->makeTareaData4Save($_POST["lat"]);
	$zoom        = $myts->makeTareaData4Save($_POST["zoom"]);
// hack LUCIO - end
	$phone       = $myts->makeTboxData4Save($_POST["phone"]);
	$mobile      = $myts->makeTboxData4Save($_POST["mobile"]);
	$fax         = $myts->makeTboxData4Save($_POST["fax"]);
	$contemail   = $myts->makeTboxData4Save($_POST["contemail"]);
	$opentime    = $myts->makeTareaData4Save($_POST["opentime"]);
	$url         = $myts->makeTboxData4Save($_POST["url"]);
	$description = $myts->makeTareaData4Save($_POST["message"]);
	$date        = time();
	$newid       = $xoopsDB->genId($xoopsDB->prefix("addresses_addresses")."_aid_seq");
	if ( $xoopsModuleConfig['autoapprove'] == 1 )
		{
		// RMV-FIXME: shouldn't this be 'APPROVE' or something (also in mydl)?
		$status = $xoopsModuleConfig['autoapprove'];
		}
	else
		{
		$status = 0;
		}
	//SHINE: ENTERED %s same as within admin/index.php

// hack LUCIO - start - non testato
	$sql = "INSERT INTO %s (aid, cid, title, address, zip,  city, country, lon, lat, zoom, phone, mobile, fax,  contemail, opentime, url,  logourl, submitter, status, date, hits, rating, votes, comments)";
	$sql.= " VALUES        (%u,  %u,  '%s',  '%s',   '%s', '%s', '%s',    %f,  %f,  %u,   '%s',  '%s',   '%s', '%s',      '%s',     '%s', '%s',    %u,        %u,     %u,   %u,   %u,     %u,    %u)";
	$sql = sprintf($sql, $xoopsDB->prefix("addresses_addresses"), $newid, $cid, $title, $address, $zip, $city, $country, $lon, $lat, $zoom, $phone, $mobile, $fax, $contemail, $opentime, $url, ' ', $submitter, $status, $date, 0, 0, 0, 0);
// hack LUCIO - end - non testato
	$xoopsDB->query($sql) or $eh->show("0013");
	if ($newid == 0)
		{
		$newid = $xoopsDB->getInsertId();
		}
	$sql = sprintf("INSERT INTO %s (aid, description) VALUES (%u, '%s')", $xoopsDB->prefix("addresses_addresses_text"), $newid, $description);
	$xoopsDB->query($sql) or $eh->show("0013");
	// RMV-NEW
	// Notify of new address (anywhere) and new addres in category.
	$notification_handler =& xoops_gethandler('notification');
	$tags = array();
	$tags['LINK_NAME'] = $title;
	$tags['LINK_URL'] = XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/address_single.php?cid='.$cid.'&aid='.$newid;
	$sql = "SELECT title";
	$sql.= " FROM ".$xoopsDB->prefix("addresses_cat")."";
	$sql.= " WHERE cid=".$cid;
	$result = $xoopsDB->query($sql);
	$row = $xoopsDB->fetchArray($result);
	$tags['CATEGORY_NAME'] = $row['title'];
	$tags['CATEGORY_URL'] = XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/cat_view.php?cid='.$cid;
	if ( $xoopsModuleConfig['autoapprove'] == 1 )
		{
		$notification_handler->triggerEvent('global', 0, 'new_address', $tags);
		$notification_handler->triggerEvent('category', $cid, 'new_address', $tags);
		redirect_header("index.php",2,_MD_RECEIVED."<br />"._MD_ISAPPROVED."");
		}
	else
		{
		$tags['WAITINGLINKS_URL'] = XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/admin/index.php?op=listNewLinks';
		$notification_handler->triggerEvent('global', 0, 'address_submit', $tags);
		$notification_handler->triggerEvent('category', $cid, 'address_submit', $tags);
		if ($notify)
			{
			include_once XOOPS_ROOT_PATH.'/include/notification_constants.php';
			$notification_handler->subscribe('address', $newid, 'approve', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE);
			}
		redirect_header("index.php",2,_MD_RECEIVED);
		}
	exit();
	}
else
	{
	$xoopsOption['template_main'] = 'addresses_submit.html';
	include XOOPS_ROOT_PATH."/header.php";
	ob_start();
	xoopsCodeTarea("message",37,8);
	$xoopsTpl->assign('xoops_codes', ob_get_contents());
	ob_end_clean();
	ob_start();
	xoopsSmilies("message");
	$xoopsTpl->assign('xoops_smilies', ob_get_contents());
	ob_end_clean();
	$xoopsTpl->assign('notify_show', !empty($xoopsUser) && !$xoopsModuleConfig['autoapprove'] ? 1 : 0);
// hack LUCIO - start
	$xoopsTpl->assign('api_key', $xoopsModuleConfig['api_key']);
	$xoopsTpl->assign('default_lat', $xoopsModuleConfig['default_lat']);
	$xoopsTpl->assign('default_lon', $xoopsModuleConfig['default_lon']);
	$xoopsTpl->assign('default_zoom', $xoopsModuleConfig['default_zoom']);
	$xoopsTpl->assign('default_address', $xoopsModuleConfig['default_address']);
	$xoopsTpl->assign('popup_options', $xoopsModuleConfig['popup_options']);
// hack LUCIO - end
	$xoopsTpl->assign('lang_submitonce', _MD_SUBMITONCE);
	$xoopsTpl->assign('lang_submitlinkh', _MD_SUBMITLINKHEAD);
	$xoopsTpl->assign('lang_allpending', _MD_ALLPENDING);
	$xoopsTpl->assign('lang_dontabuse', _MD_DONTABUSE);
	$xoopsTpl->assign('lang_wetakeshot', _MD_TAKESHOT);
	$xoopsTpl->assign('lang_bannertise', _MD_BANNERTISE);
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
	$xoopsTpl->assign('lang_mobile', _MD_MOBILE);
	$xoopsTpl->assign('lang_fax', _MD_FAX);	
	$xoopsTpl->assign('lang_contemail', _MD_CONTEMAIL);
	$xoopsTpl->assign('lang_opened', _MD_OPENED);
	$xoopsTpl->assign('lang_siteurl', _MD_SITEURL);
	$xoopsTpl->assign('lang_category', _MD_CATEGORYC);
	$xoopsTpl->assign('lang_options', _MD_OPTIONS);
	$xoopsTpl->assign('lang_notify', _MD_NOTIFYAPPROVE);
	$xoopsTpl->assign('lang_description', _MD_DESCRIPTIONC);
	$xoopsTpl->assign('lang_submit', _SUBMIT);
	$xoopsTpl->assign('lang_cancel', _CANCEL);
	ob_start();
	$mytree->makeMySelBox("title", "title",0,1);
	$selbox = ob_get_contents();
	ob_end_clean();
	$xoopsTpl->assign('category_selbox', $selbox);
	include XOOPS_ROOT_PATH.'/footer.php';
	}
?>
