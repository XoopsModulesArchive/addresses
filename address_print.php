<?php
include 'header.php';
include_once XOOPS_ROOT_PATH.'/class/xoopstree.php';

$myts =& MyTextSanitizer::getInstance();
$mytree = new XoopsTree($xoopsDB->prefix("addresses_cat"),"cid","pid");

foreach ($_POST as $k => $v) {${$k} = $v;}
foreach ($_GET  as $k => $v) {${$k} = $v;}
if (empty($aid)) {redirect_header("index.php");}


function PrintPage($aid)
	{
	global $xoopsDB, $xoopsConfig, $myts, $eh, $mytree, $xoopsModuleConfig, $xoopsModule;
// hack LUCIO - start
	$sql = "SELECT l.aid, l.cid, l.title, l.address, l.zip, l.city, l.country, l.lat, l.lon, l.zoom, l.phone, l.mobile, l.fax, l.contemail, l.url, l.opentime, l.logourl, l.status, l.date, l.hits, l.rating, l.votes, l.comments, t.description";
	$sql.= " FROM ".$xoopsDB->prefix("addresses_addresses")." l, ".$xoopsDB->prefix("addresses_addresses_text")." t";
	$sql.= " WHERE l.aid=$aid AND l.aid=t.aid AND status>0";
	$result = $xoopsDB->query($sql);
	list($aid, $cid, $ltitle, $address, $zip, $city, $country, $lat, $lon, $zoom, $phone, $mobile, $fax, $contemail, $url, $opentime, $logourl, $status, $time, $hits, $rating, $votes, $comments, $description) = $xoopsDB->fetchRow($result);
// hack LUCIO - end

// hack LUCIO - start
	$sql = "SELECT title, imgurl, show_map";
	$sql.= " FROM ".$xoopsDB->prefix("addresses_cat");
	$sql.= " WHERE cid=".$cid;
	$result=$xoopsDB->query($sql) or exit("Error");
	list($ctitle, $cimgurl, $show_map) = $xoopsDB->fetchRow($result);
	if ($cimgurl && $cimgurl != "http://")
		{$cimgurl = $myts->makeTboxData4Edit($cimgurl);}
	else
		{$cimgurl = '';}
	$ctitle =  $myts->makeTboxData4Show($ctitle);
	$cimgurl = $cimgurl;
	$show_map = $show_map;
// hack LUCIO - end

// hack LUCIO - start
	$api_key = $xoopsModuleConfig['api_key'];
	$default_zoom = $xoopsModuleConfig['default_zoom'];
// hack LUCIO - end

	$ltitle      = $myts->makeTboxData4Show($ltitle);
	$address     = $myts->makeTboxData4Show($address);
	$zip         = $myts->makeTboxData4Show($zip);
	$city        = $myts->makeTboxData4Show($city);
	$country     = $myts->makeTboxData4Show($country);
// hack LUCIO - start
	$lat         = $myts->makeTboxData4Show($lat);
	$lon         = $myts->makeTboxData4Show($lon);
	$zoom        = $myts->makeTboxData4Show($zoom);
// hack LUCIO - end
	$phone       = $myts->makeTboxData4Show($phone);
	$mobile      = $myts->makeTboxData4Show($mobile);
	$fax         = $myts->makeTboxData4Show($fax);
	$contemail   = $myts->makeTboxData4Show($contemail);
	$opentime    = $myts->makeTareaData4Show($opentime);
	$description = $myts->makeTareaData4Show($description);  
	$datetime    = formatTimestamp($time);


	echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>\n";
	echo "<html>\n";
	echo "<head>\n";
	echo "<title>" . $xoopsConfig['sitename'] . "</title>\n";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=" . _CHARSET . "' />\n";
	echo "<meta name='AUTHOR' content='" . $xoopsConfig['sitename'] . "' />\n";
	echo "<meta name='COPYRIGHT' content='Copyright (c) 2001 by " . $xoopsConfig['sitename'] . "' />\n";
	echo "<meta name='DESCRIPTION' content='" . $xoopsConfig['slogan'] . "' />\n";
	echo "<meta name='GENERATOR' content='" . XOOPS_VERSION . "' />\n";
	echo "</head>\n";

	echo "<body bgcolor='#ffffff' text='#000000' onload='window.print()'>\n";
	//echo "<body bgcolor='#ffffff' text='#000000'>\n";
	echo "<table border='0' width='650' cellpadding='0' cellspacing='1' bgcolor='#000000'>\n";
	echo "<tr><td>\n";
	echo "<table border='0' width='650' cellpadding='20' cellspacing='1' bgcolor='#ffffff'>\n";
	echo "<tr><td>\n";
	echo "<h2>".$ltitle."</h2>\n";
	if($show_map)
		{
?>
<!-- Google Maps - start -->
<script src="http://maps.google.com/maps?file=api&v=2&key=<? echo($api_key); ?>" type="text/javascript"></script>
<script type="text/javascript">
	var map = null;
	// Create new marker icon
	var icon = new Array();
		icon["red"] = new GIcon();icon["red"].image = "images/mm_20_red.png";icon["red"].iconSize = new GSize(12, 20);icon["red"].shadow = "images/mm_20_shadow.png";icon["red"].shadowSize = new GSize(22, 20);icon["red"].iconAnchor = new GPoint(6, 20);icon["red"].infoWindowAnchor = new GPoint(5, 1);
		icon["blue"] = new GIcon();icon["blue"].image = "images/mm_20_blue.png";icon["blue"].iconSize = new GSize(12, 20);icon["blue"].shadow = "images/mm_20_shadow.png";icon["blue"].shadowSize = new GSize(22, 20);icon["blue"].iconAnchor = new GPoint(6, 20);icon["blue"].infoWindowAnchor = new GPoint(5, 1);
	function createNewMarker(new_point,icon)
		{var marker = new GMarker(new_point,{icon:icon});map.addOverlay(marker);return marker;}
	function showMap()
		{
		if (GBrowserIsCompatible())
			{
			map_div = document.getElementById('google_map')
			map = new GMap2(map_div);
			map.addControl(new GScaleControl());
			map.setCenter(new GLatLng(45.5,10), 8);
			// marker
			var lat = parseFloat(<? echo($lat); ?>);
			var lon = parseFloat(<? echo($lon); ?>);
			var zoom = parseInt(<? echo($zoom); ?>);
			if (!zoom) {zoom = <? echo($default_zoom); ?>;}
			if (lat && lon) {createNewMarker(new GLatLng(lat,lon),icon["red"]);map.setCenter(new GLatLng(lat,lon),zoom);}
			}
		}
window.onload = showMap;
window.onunload = GUnload;
</script>
<div id="google_map" style="text-align:center; width:100%; height:400px; border:none;">
	<img src="<{$xoops_url}>/modules/addresses/images/loading.gif" alt="loading" />
</div>
<br />
<!-- Google Maps - end -->
<?php
		}
	echo "<table border=0 cellpadding=2 cellspacing=1 align=center width=100% class = 'outer'>\n";
	echo "<tr><td class ='head' width = 30%><b>"._MD_SITETITLE."</b></td> <td class ='even' >$ltitle</td></tr>\n";
	echo "<tr><td class ='head'><b>"._MD_ADDRESS.":</b></td> <td class ='even'>$address</td></tr>\n";
	echo "<tr><td class ='head'><b>"._MD_ZIP.":</b></td> <td class ='even'>$zip</td></tr>\n";
	echo "<tr><td class ='head'><b>"._MD_CITY.":</b></td><td class ='even'>$city</td></tr>\n";
	echo "<tr><td class ='head'><b>"._MD_COUNTRY.":</b></td><td class ='even'>$country</td></tr>\n";
	echo "<tr><td class ='head'><b>"._MD_PHONE.":</b></td><td class ='even'> $phone</td></tr>\n";
	echo "<tr><td class ='head'><b>"._MD_MOBILE.":</b></td><td class ='even'>$mobile</td></tr>\n";
	echo "<tr><td class ='head'><b>"._MD_FAX.":</b></td><td class ='even'> $fax</td></tr>\n";
	echo "<tr><td class ='head'><b>"._MD_CONTEMAIL.":</b></td><td class ='even'>$contemail</td></tr>\n";
	echo "<tr><td valign='top' class ='head'><b>"._MD_OPENED.":</b></td><td class ='even'>$opentime</td></tr>\n";
	echo "<tr><td class ='head'><b>"._MD_DESCRIPTIONC."</b></td><td class ='even'>$description</td></tr>";
	echo "</table>\n";
	echo "<hr />";
	echo "<b>"._MD_PUBLISHED. ":</b> ".$datetime."";
	echo "<hr />";
	printf(_MD_THISCOMESFROM,$xoopsConfig['sitename']);
	echo '&nbsp;<a href="'.XOOPS_URL.'/">'.XOOPS_URL.'</a><br />';
	echo ''._MD_URLFORSTORY.''; 
	echo '&nbsp;<a href="'.XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/address_visit.php?cid='.$cid.'&aid='.$aid.'">'.XOOPS_URL.'/address_visit.php?cid='.$cid.'&aid='.$aid.'</a>';
	echo "</td></tr></table>\n";
	echo "</td></tr></table\n>";
	echo "</body></html>";
	}



PrintPage($aid);
?>
