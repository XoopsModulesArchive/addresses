<?php
include '../../../include/cp_header.php';
include_once XOOPS_ROOT_PATH.'/modules/addresses/admin/functions.php';

if ( file_exists("../language/".$xoopsConfig['language']."/main.php") )
	{include "../language/".$xoopsConfig['language']."/main.php";}
else
	{include "../language/english/main.php";}
include '../include/functions.php';

include_once XOOPS_ROOT_PATH."/class/xoopsmodule.php";
include_once XOOPS_ROOT_PATH."/include/cp_functions.php";
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
include_once XOOPS_ROOT_PATH.'/class/xoopstree.php';
include_once XOOPS_ROOT_PATH."/class/xoopslists.php";
include_once XOOPS_ROOT_PATH.'/class/uploader.php';
include_once XOOPS_ROOT_PATH."/include/xoopscodes.php";
include_once XOOPS_ROOT_PATH.'/class/module.errorhandler.php';
$myts =& MyTextSanitizer::getInstance();
$eh = new ErrorHandler;
$mytree = new XoopsTree($xoopsDB->prefix("addresses_cat"),"cid","pid");


/**
 * Shows published addresses
 *
 * This list can be view in the module's admin when you click on the tab named "Post/Edit Addresses"
 * Actually you can see the the address's ID, its title, the topic, the author, and two links.
 * The first link is used to edit the address while the second is used to remove the address.
 * The table only contains the last X published addresses.
 * You can modify the number of visible addresses with the module's option named
 * "Number of new addresses to display in admin area".
 * As the number of displayed addresses is limited, below this list you can find a text box
 * that you can use to enter a address's Id, then with the scrolling list you can select
 * if you want to edit or delete the address.
 */
function lastAddresses($faid=0,$limit=10)
	{
	global $dateformat, $xoopsDB, $eh;
	// debug
	$sql = "SELECT aid, ".$xoopsDB->prefix("addresses_addresses").".cid, ".$xoopsDB->prefix("addresses_cat").".title AS cat_title, ".$xoopsDB->prefix("addresses_addresses").".title, submitter, date";
	$sql.= " FROM ".$xoopsDB->prefix("addresses_addresses").",".$xoopsDB->prefix("addresses_cat");
	$sql.= " WHERE ".$xoopsDB->prefix("addresses_cat").".cid = ".$xoopsDB->prefix("addresses_addresses").".cid";
	$sql.= " LIMIT ".$limit." OFFSET ".$faid."";
	$query = $xoopsDB->query($sql) or $eh->show("0013");
	// debug
	collapsableBar();
	echo "<h4 style=\"color: #2F5376; margin: 6px 0 0 0; \">";
	echo "<img onclick=\"toggle('lastaddresses'); toggleIcon('toplastaddresses');\" id='toplastaddresses' name='toplastaddresses' src='".XOOPS_URL."/modules/addresses/images/close12.gif' alt='' />";
	echo "&nbsp;".sprintf(_MD_LASTNADDRESSES,"news_getmoduleoption('storycountadmin')");
	echo "</h4>";
	echo "<div id='lastaddresses'>";
	echo "<div style='text-align: center;'>";
	$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
	//$storyarray = NewsStory :: getAllPublished(news_getmoduleoption('storycountadmin'), $start, false, 0, 1 );
	//$storiescount = NewsStory :: getAllStoriesCount(4,false);
	//$pagenav = new XoopsPageNav( $storiescount, news_getmoduleoption('storycountadmin'), $start, 'start', 'op=newarticle');
	$class='';
	echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
	echo "<tr class='bg3'>";
	echo "<td align='center'>"._MD_LINKID."</td>";
	echo "<td align='center'>"._MD_SITETITLE."</td>";
	echo "<td align='center'>" ._MD_CATEGORYC."</td>";
	//echo "<td align='center'>"._MD_POSTER."</td>";
	echo "<td align='center' class='nw'>"._MD_PUBLISHED."</td>";
	//echo "<td align='center' class='nw'>"._MD_HITS."</td>";
	echo "<td align='center'>"._MD_ACTION."</td>";
	echo "</tr>";
	while($address = $xoopsDB->fetchArray($query))
		{
		$published = "";//formatTimestamp($eachstory->published(),$dateformat );
		// $expired = ( $eachstory -> expired() > 0 ) ? formatTimestamp($eachstory->expired(),$dateformat) : '---';
		$category = $address['cid'];
		$class = ($class == 'even') ? 'odd' : 'even';
		echo "<tr class='".$class."'>";
		echo "<td align='center'><b>".$address['aid']."</b></td>";
		echo "<td align='left'><a href='".XOOPS_URL."/modules/addresses/address_visit.php?cid=".$address['cid']."&aid=".$address['aid']."'>".$address['title']."</a></td>";
		echo "<td align='center'><a href='".XOOPS_URL."/modules/addresses/cat_view.php?cid=".$address['cid']."'>".$address['cat_title']."</a></td>";
		//echo "<td align='center'><a href='" . XOOPS_URL . "/userinfo.php?uid=" . "-" . "'>" . $address['subitter'] . "</a></td>";
		echo "<td align='center' class='nw'>" . formatTimestamp($address['date'],"m") . "</td>";
		//echo "<td align='center'>" . "counter" . "</td>";
		echo "<td align='center'>";
		echo "<a href='".XOOPS_URL."/modules/addresses/admin/index.php?op=Address_mod&aid=".$address['aid']."'>"._MD_MODIFY."</a>";
		echo " | ";
		echo "<a href='".XOOPS_URL."/modules/addresses/admin/index.php?op=Address_del&aid=".$address['aid']."'>"._MD_DELETE."</a>";
		echo "</td>";
		echo "</tr>\n";
		}
	echo "</table>";
	echo "<br />";
	//echo "<div align='right'>".$pagenav->renderNav().'</div><br />';
	
	echo "<form action='index.php' method='get'>"._MD_LINKID."&nbsp;<input type='text' name='aid' size='10' />";
	echo "&nbsp;<select name='op'>";
	echo "<option value='Address_mod' selected='selected'>"._MD_MODIFY."</option>";
	echo "<option value='Address_del'>"._MD_DELETE."</option>";
	echo "</select>";
	echo "<input type='hidden' name='returnside' value='1'>";
	echo "&nbsp;<input type='submit' value='"._MD_GO."' />";
	echo "</form>";
	echo "</div>";
	echo "</div>";
	echo "<br />";
	}


$op = 'mail';//default
if(isset($_GET['op'])) {$op = $_GET['op'];}
if(isset($_POST['op'])) {$op = $_POST['op'];}

switch ($op)
	{

	case "Category_add":         Category_add();break;
	case "Category_del":         Category_del();break;
	case "Category_mod":         Category_mod();break;
	case "Category_mod_S":       Category_mod_S();break;
	case "Address_add":          Address_add();break;
	case "Address_del":          Address_del();break;
	case "Address_mod":          Address_mod();break;
	case "Address_mod_S":        Address_mod_S();break;
	case "NewAddress_list":      NewAddress_list();break;
	case "NewAddress_del":       NewAddress_del();break;
	case "NewAddress_approve":   NewAddress_approve();break;
	case "BrokenAddress_list":   BrokenAddress_list();break;
	case "BrokenAddress_del":    BrokenAddress_del();break;
	case "BrokenAddress_ignore": BrokenAddress_ignore();break;
	case "ModReqAddress_list":   ModReqAddress_list();break;
	case "ModReqAddress_change": ModReqAddress_change();break;
	case "ModReqAddress_ignore": ModReqAddress_ignore();break;
	case "Vote_del":             Vote_del();break;
	case "Menu_Categories":      Menu_Categories();break;
	case "Menu_Addresses":       Menu_Addresses();break;
	case "main":                 Menu_main();break;
	default:                     Menu_main();break;
	}




function Menu_main()
	{
	global $xoopsDB, $xoopsModule;
	xoops_cp_header();
	adminmenu(-1);
	echo "<table width='100%' border='0' cellspacing='1' class='outer'>";
	echo "<tr class=\"odd\"><td>";

	$query1 = $xoopsDB->query("select count(*) from ".$xoopsDB->prefix("addresses_broken")."");
	list($totalbrokenaddresses) = $xoopsDB->fetchRow($query1);
	if($totalbrokenaddresses>0)
		$totalbrokenaddresses = "<span style='color: #ff0000; font-weight: bold'>$totalbrokenaddresses</span>";

	$query2 = $xoopsDB->query("select count(*) from ".$xoopsDB->prefix("addresses_mod")."");
	list($totalmodrequests) = $xoopsDB->fetchRow($query2);
	if($totalmodrequests>0)
		$totalmodrequests = "<span style='color: #ff0000; font-weight: bold'>$totalmodrequests</span>";

	$query3 = $xoopsDB->query("select count(*) from ".$xoopsDB->prefix("addresses_addresses")." where status=0");
	list($totalnewaddresses) = $xoopsDB->fetchRow($query3);
	if($totalnewaddresses>0)
		$totalnewaddresses = "<span style='color: #ff0000; font-weight: bold'>$totalnewaddresses</span>";

	echo " - <a href='".XOOPS_URL."/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=".$xoopsModule->getVar('mid')."'>"._MD_GENERALSET."</a>";
	echo "<br /><br />";
	echo " - <a href=index.php?op=Menu_Categories>"._MD_ADDMODDELCATEGORIES."</a>";
	echo "<br /><br />";
	echo " - <a href=index.php?op=Menu_Addresses>"._MD_ADDMODDELADDRESSES."</a>";
	echo "<br /><br />";
	echo " - <a href=index.php?op=NewAddress_list>"._MD_LINKSWAITING." ($totalnewaddresses)</a>";
	echo "<br /><br />";
	echo " - <a href=index.php?op=BrokenAddress_list>"._MD_BROKENREPORTS." ($totalbrokenaddresses)</a>";
	echo "<br /><br />";
	echo " - <a href=index.php?op=ModReqAddress_list>"._MD_MODREQUESTS." ($totalmodrequests)</a>";

	$query4 = $xoopsDB->query("select count(*) from ".$xoopsDB->prefix("addresses_addresses")." where status>0");
	list($numrows) = $xoopsDB->fetchRow($query4);
	echo "<br /><br />";
	echo "<div>";
	printf(_MD_THEREARE,$numrows);
	echo "</div>";
	echo"</td></tr></table>";
	xoops_cp_footer();
	}




function NewAddress_list()
	{
	global $xoopsDB, $xoopsConfig, $myts, $eh, $mytree, $xoopsModuleConfig, $op;
	// List addresses waiting for validation
	$linkimg_array = XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH.'/'.$xoopsModuleConfig['shot_path'].'/');

	$sql = "SELECT aid, cid, title, address, zip, city, country, lon, lat, zoom, phone, mobile, fax, contemail, opentime, url, logourl, submitter";
	$sql.= " FROM ".$xoopsDB->prefix("addresses_addresses");
	$sql.= " WHERE status=0";
	$sql.= " ORDER BY date DESC";
	$query = $xoopsDB->query($sql);
	$NewAddresses_num = $xoopsDB->getRowsNum($query);

	xoops_cp_header();
	adminmenu(2);
	echo "<h4>"._MD_LINKSWAITING."&nbsp;($NewAddresses_num)</h4>";

	if ($NewAddresses_num > 0)
		{
		$js = "<script type=\"text/javascript\">\n";
		$js.= "//<![CDATA[\n";
		$js.= "var address_value;\n";
		$js.= "var zip_value;\n";
		$js.= "var city_value;\n";
		$js.= "var country_value;\n";
		$js.= "var request_value;\n";
		$js.= "var lat_value;\n";
		$js.= "var lon_value;\n";
		$js.= "var zoom_value;\n";
		$js.= "var id_value;\n";
		$js.= "function getLatLonZoom(i)\n";
		$js.= "	{\n";
		$js.= "	if (document.getElementById)\n";
		$js.= "		{\n";
		$js.= "		id_value = i;\n";
		$js.= "		address_value = document.getElementById('input_address'+i).value;\n";
		$js.= "		zip_value = document.getElementById('input_zip'+i).value;\n";
		$js.= "		city_value = document.getElementById('input_city'+i).value;\n";
		$js.= "		country_value = document.getElementById('input_country'+i).value;\n";
		$js.= "		request_value = address_value+','+zip_value+','+city_value+','+country_value;\n";
		$js.= "		if (request_value == ',,,') request_value = '".$xoopsModuleConfig['default_address']."';\n";
		$js.= "		lat_value = document.getElementById('lat'+i).value;\n";
		$js.= "		lon_value = document.getElementById('lon'+i).value;\n";
		$js.= "		zoom_value = document.getElementById('zoom'+i).value;\n";
		$js.= "		}\n";
		$js.= "	if (!lat_value) lat_value = ".$xoopsModuleConfig['default_lat'].";\n";
		$js.= "	if (!lon_value) lon_value = ".$xoopsModuleConfig['default_lon'].";\n";
		$js.= "	if (!zoom_value) zoom_value = ".$xoopsModuleConfig['default_zoom'].";\n";
		$js.= "	}\n";
		$js.= "//]]>\n";
		$js.= "</script>\n";
		echo $js;

		while($NewAddresses = $xoopsDB->fetchArray($query))
		//list($aid, $cid, $title, $address, $zip, $city, $country, $lon, $lat, $zoom, $phone, $mobile, $fax, $contemail, $opentime, $url, $logourl, $submitterid) = $xoopsDB->fetchRow($query))
			{
			$aid         = $NewAddresses['aid'];
			$cid         = $NewAddresses['cid'];
			$title       = $myts->makeTboxData4Edit($NewAddresses['title']);
			$address     = $myts->makeTboxData4Edit($NewAddresses['address']);
			$zip         = $myts->makeTboxData4Edit($NewAddresses['zip']);
			$city        = $myts->makeTboxData4Edit($NewAddresses['city']);
			$country     = $myts->makeTboxData4Edit($NewAddresses['country']);
			$lon         = $myts->makeTboxData4Edit($NewAddresses['lon']);
			$lat         = $myts->makeTboxData4Edit($NewAddresses['lat']);
			$zoom        = $myts->makeTboxData4Edit($NewAddresses['zoom']);
			$phone       = $myts->makeTboxData4Edit($NewAddresses['phone']);
			$mobile      = $myts->makeTboxData4Edit($NewAddresses['mobile']);
			$fax         = $myts->makeTboxData4Edit($NewAddresses['fax']);
			$contemail   = $myts->makeTboxData4Edit($NewAddresses['contemail']);
			$opentime    = $myts->makeTareaData4Edit($NewAddresses['opentime']);
			$url         = $myts->makeTboxData4Edit($NewAddresses['url']);
			//$url = urldecode($url);
			$logourl     = $myts->makeTboxData4Edit($NewAddresses['logourl']);
			//$logourl = urldecode($logourl);
			$query_description = $xoopsDB->query("SELECT description FROM ".$xoopsDB->prefix("addresses_addresses_text")." WHERE aid=$aid");
			list($description) = $xoopsDB->fetchRow($query_description);
			$description = $myts->makeTareaData4Edit($description);
			$submitter   = XoopsUser::getUnameFromId($NewAddresses['submitter']);

			$form = new XoopsThemeForm(_MD_MODLINK, "op", xoops_getenv('PHP_SELF')."?op=$op");
			$form->setExtra('enctype="multipart/form-data"');

			$form->addElement(new XoopsFormLabel(_MD_SUBMITTER,"<a href=\"".XOOPS_URL."/userinfo.php?uid=".$NewAddresses['submitter']."\">$submitter</a>"));
			$form->addElement(new XoopsFormText(_MD_SITETITLE, "title", 50, 50, $title));
			ob_start() ;
			$mytree->makeMySelBox('title','title',$cid);
			$cat_selbox = ob_get_contents() ;
			ob_end_clean() ;
			$form->addElement(new XoopsFormLabel(_MD_CATEGORYC,$cat_selbox));	

			$form->addElement(new XoopsFormText(_MD_ADDRESS, 'input_address'.$aid, 50, 100, $address));
			$form->addElement(new XoopsFormText(_MD_ZIP, 'input_zip'.$aid, 20, 20, $zip));
			$form->addElement(new XoopsFormText(_MD_CITY, 'input_city'.$aid, 50, 100, $city));
			$form->addElement(new XoopsFormText(_MD_COUNTRY, 'input_country'.$aid, 50, 100, $country));
			$form->addElement(new XoopsFormText(_MD_LAT, 'lat'.$aid, 15, 30, $lat));		
			$form->addElement(new XoopsFormText(_MD_LON, 'lon'.$aid, 15, 30, $lon));
			$form->addElement(new XoopsFormText(_MD_ZOOM, 'zoom'.$aid, 15, 30, $zoom));
	
			$map_button = new XoopsFormButton (_MD_MAP, 'button', _MD_MAP, 'button');
			$map_button->setExtra("onclick=\"getLatLonZoom('".$aid."');window.open('../google_maps_popup.php?id=".$aid."&lat='+lat_value+'&lon='+lon_value+'&zoom='+zoom_value+'&request='+request_value,'google_map_window','".$xoopsModuleConfig['popup_options']."');\"");
			$form->addElement($map_button);
	
			$form->addElement(new XoopsFormText(_MD_PHONE, 'phone', 20, 40, $phone));
			$form->addElement(new XoopsFormText(_MD_MOBILE, 'mobile', 20, 40, $mobile));
			$form->addElement(new XoopsFormText(_MD_FAX, 'fax', 20, 40, $fax));
			$form->addElement(new XoopsFormText(_MD_CONTEMAIL, 'contemail', 50, 100, $contemail));
			$form->addElement(new XoopsFormText(_MD_SITEURL, 'url', 50, 250, $url));
	
			$form->addElement(new XoopsFormTextArea (_MD_OPENED, 'opentime', $opentime, 5, 60));
			$form->addElement(new XoopsFormDhtmlTextArea(_MD_DESCRIPTIONC, 'description', $description, 8, 8));
	
			// select/load image - start
			$uploadurl=$xoopsModuleConfig['shot_path'];
			$uploadirectory=XOOPS_ROOT_PATH.'/'.$uploadurl.'/';
			$linkimg_array = XoopsLists::getImgListAsArray($uploadirectory);
			$imgtray = new XoopsFormElementTray(_MD_SHOTIMAGE,'');
			$imgtray->setDescription(sprintf(_MD_SHOTIMAGEDESC,$xoopsModuleConfig['max_shot_size'],$xoopsModuleConfig['max_shot_width'],$xoopsModuleConfig['max_shot_height']));
				$imageselect= new XoopsFormSelect(sprintf(_MD_SHOTMUST,$uploadirectory).'<br />','logourl',$logourl);
//				$imageselect->addOption(' ','------');
				$imageselect->addOption('','------');
				foreach($linkimg_array as $image)
					$imageselect->addOption("$image",$image);
				$imageselect->setExtra("onchange='showImgSelected(\"image_imgurl\", \"imgurl\", \"".$uploadurl."\", \"\", \"".XOOPS_URL."\")'" );
			$imgtray->addElement($imageselect,false);
			$imgtray->addElement(new XoopsFormLabel('',"<br /><img src='".XOOPS_URL."/".$uploadurl."/".$logourl."' name='image_imgurl' id='image_imgurl' alt='' /><br />"));
				$fileseltray= new XoopsFormElementTray('<hr />'._AM_TOPIC_PICTURE.'<br />','');
				$fileseltray->addElement(new XoopsFormFile('', 'attachedfile', $xoopsModuleConfig['max_shot_size']), false);
				$fileseltray->addElement(new XoopsFormLabel(sprintf('<br />'._AM_UPLOAD_WARNING.'<br />',$uploadirectory)), false);
			$imgtray->addElement($fileseltray);
			$form->addElement($imgtray);
			// select/load image - end
	
			$form->addElement(new XoopsFormHidden('aid', $aid),false);
			$form->addElement(new XoopsFormHidden('op', 'NewAddress_approve'),false);
	
			$button_tray = new XoopsFormElementTray('', '');
				$modify_btn = new XoopsFormButton('', 'post', _MD_APPROVE, 'submit');
				$modify_btn->setExtra('accesskey="a"');
			$button_tray -> addElement($modify_btn);
				$delete_btn = new XoopsFormButton('', 'delete', _MD_DELETE, 'button');
				$delete_btn -> setExtra("onclick=\"javascript:location='index.php?op=NewAddress_del&aid=".$aid."'\"");
			$button_tray -> addElement($delete_btn);
				$cancel_btn = new XoopsFormButton('', 'cancel', _MD_CANCEL, 'button');
				$cancel_btn -> setExtra("onclick=\"javascript:history.go(-1)\"");
			$button_tray -> addElement($cancel_btn);
			$form -> addElement($button_tray);
	
			$form->display();
			echo "<hr />";
			}
		}
	else
		{
		echo ""._MD_NOSUBMITTED."";
		}
	xoops_cp_footer();
	}




function Menu_Categories()
	{
	global $xoopsDB,$xoopsConfig, $myts, $eh, $mytree, $xoopsModuleConfig, $op, $heading;

	xoops_cp_header();
	adminmenu(0);

	$linkimg_array = XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH.'/'.$xoopsModuleConfig['shot_path'].'/');
	// Add a New Main Category - start	
	$form = new XoopsThemeForm(_MD_ADDMAIN, "op", xoops_getenv('PHP_SELF')."?op=$op");
	$form->setExtra('enctype="multipart/form-data"');
	$form->addElement(new XoopsFormText(_MD_TITLEC, "title", 50, 50, ''));	
	$form->addElement(new XoopsFormDhtmlTextArea(_MD_DESCRIPTIONC, 'cat_description', '', 8, 8));

	$logourl='';
	// select/load image - start
	$uploadurl=$xoopsModuleConfig['shot_path'];
	$uploadirectory=XOOPS_ROOT_PATH.'/'.$uploadurl.'/';
	$linkimg_array = XoopsLists::getImgListAsArray($uploadirectory);
	$imgtray = new XoopsFormElementTray(_MD_SHOTIMAGE,'');
	$imgtray->setDescription(sprintf(_MD_SHOTIMAGEDESC,$xoopsModuleConfig['max_shot_size'],$xoopsModuleConfig['max_shot_width'],$xoopsModuleConfig['max_shot_height']));
		$imageselect= new XoopsFormSelect(sprintf(_MD_SHOTMUST,$uploadirectory).'<br />','imgurl',$logourl);
//		$imageselect->addOption(' ','------');
		$imageselect->addOption('','------');
		foreach($linkimg_array as $image)
			$imageselect->addOption("$image",$image);
		$imageselect->setExtra("onchange='showImgSelected(\"image_imgurl\", \"imgurl\", \"".$uploadurl."\", \"\", \"".XOOPS_URL."\")'" );
	$imgtray->addElement($imageselect,false);
	$imgtray->addElement(new XoopsFormLabel('',"<br /><img src='".XOOPS_URL."/".$uploadurl."/".$logourl."' name='image_imgurl' id='image_imgurl' alt='' /><br />"));
		$fileseltray= new XoopsFormElementTray('<hr />'._AM_TOPIC_PICTURE.'<br />','');
		$fileseltray->addElement(new XoopsFormFile('', 'attachedfile', $xoopsModuleConfig['max_shot_size']), false);
		$fileseltray->addElement(new XoopsFormLabel(sprintf('<br />'._AM_UPLOAD_WARNING.'<br />',$uploadirectory)), false);
	$imgtray->addElement($fileseltray);
	$form->addElement($imgtray);
	// select/load image - end
	
	$form->addElement(new XoopsFormRadioYN(_MD_SHOW_MAP, 'show_map', 1));	
	//Submit buttons
	$form->addElement(new XoopsFormHidden('cid', '0'),false);
	$form->addElement(new XoopsFormHidden('op', 'Category_add'),false);
	$button_tray = new XoopsFormElementTray('' ,'');
	$submit_btn = new XoopsFormButton('', 'post', _MD_ADD, 'submit');
	$submit_btn->setExtra('accesskey="s"');
	$button_tray->addElement($submit_btn);
	$form->addElement($button_tray);
	$form->display();
	// Add a New Main Category - end

	echo "<br />";

	$result=$xoopsDB->query("SELECT count(*) FROM ".$xoopsDB->prefix("addresses_cat")."");
	list($numrows)=$xoopsDB->fetchRow($result);
	if ( $numrows > 0 )
		{
		// Add a New Sub-Category - start
		$sform = new XoopsThemeForm(_MD_ADDSUB, "op", xoops_getenv('PHP_SELF')."?op=$op");
		$sform->setExtra('enctype="multipart/form-data"');
		$sform->addElement(new XoopsFormText(_MD_TITLEC, "title", 50, 50, ''));
		ob_start() ;
		$mytree->makeMySelBox('title', 'title');
		$cat_selbox = ob_get_contents() ;
		ob_end_clean() ;
		$sform->addElement(new XoopsFormLabel(_MD_IN,$cat_selbox));
		$sform->addElement(new XoopsFormDhtmlTextArea(_MD_DESCRIPTIONC, 'cat_description', '', 8, 8));
		$sform->addElement(new XoopsFormRadioYN(_MD_SHOW_MAP, 'show_map', 1));	
		//Submit buttons
		$sform->addElement(new XoopsFormHidden('op', 'Category_add'),false);
		$button_tray = new XoopsFormElementTray('' ,'');
		$submit_btn = new XoopsFormButton('', 'post', _MD_ADD, 'submit');
		$submit_btn->setExtra('accesskey="s"');
		$button_tray->addElement($submit_btn);
		$sform->addElement($button_tray);
		$sform->display();
		// Add a New Sub-Category - end

		echo "<br />\n";

		// Modify Category - start
		$mform = new XoopsThemeForm(_MD_MODCAT, "op", xoops_getenv('PHP_SELF')."?op=$op");
		$mform->setExtra('enctype="multipart/form-data"');
		ob_start() ;
		$mytree->makeMySelBox('title', 'title');
		$cat_selbox = ob_get_contents() ;
		ob_end_clean() ;
		$mform->addElement(new XoopsFormLabel(_MD_CATEGORYC,$cat_selbox ));
		//Submit buttons
		$mform->addElement(new XoopsFormHidden('op', 'Category_mod'),false);
		$button_tray = new XoopsFormElementTray('' ,'');
		$modify_btn = new XoopsFormButton('', 'post', _MD_MODIFY, 'submit');
		$modify_btn->setExtra('accesskey="s"');
		$button_tray->addElement($modify_btn);
		$mform->addElement($button_tray);
		$mform->display();
		// Modify Category - end
		
		echo "<br />";
		}

	xoops_cp_footer();
	}




function Menu_Addresses()
	{
	global $xoopsDB,$xoopsConfig, $myts, $eh, $mytree,$xoopsModule, $xoopsModuleConfig, $op;
	// Add a New Main Category
	xoops_cp_header();
	adminmenu(1);

	// Modify Address - start
	$result2 = $xoopsDB->query("select count(*) from ".$xoopsDB->prefix("addresses_addresses")."");
	list($numrows2) = $xoopsDB->fetchRow($result2);
	if ( $numrows2 > 0 )
		{
		//in progress
		$first_aid = 0;
		if(isset($_GET['f_aid'])) {$first_aid = $_GET['f_aid'];} // f_aid: offset address id (ref:MySQL,LIMIT)
		$limit_aid = 10;
		if(isset($_GET['l_aid'])) {$limit_aid = $_GET['l_aid'];} // l_aid: limit address id (ref:MySQL,LIMIT)
		//in progress
		lastAddresses($first_aid,$limit_aid);
		}
	// Modify Address - start
	$query=$xoopsDB->query("SELECT count(*) FROM ".$xoopsDB->prefix("addresses_cat")."");
	list($numcats)=$xoopsDB->fetchRow($query);
	if ( $numcats > 0 )
		{
		// Add a New Address - start
		$js = "<script type=\"text/javascript\">\n";
		$js.= "//<![CDATA[\n";
		$js.= "var address_value;\n";
		$js.= "var zip_value;\n";
		$js.= "var city_value;\n";
		$js.= "var country_value;\n";
		$js.= "var request_value;\n";
		$js.= "var lat_value;\n";
		$js.= "var lon_value;\n";
		$js.= "var zoom_value;\n";
		$js.= "function getLatLonZoom()\n";
		$js.= "	{\n";
		$js.= "	if (document.getElementById)\n";
		$js.= "		{\n";
		$js.= "		address_value = document.getElementById(\"input_address\").value;\n";
		$js.= "		zip_value = document.getElementById(\"input_zip\").value;\n";
		$js.= "		city_value = document.getElementById(\"input_city\").value;\n";
		$js.= "		country_value = document.getElementById(\"input_country\").value;\n";
		$js.= "		request_value = address_value+','+zip_value+','+city_value+','+country_value;\n";
		$js.= "		if (request_value == ',,,') request_value = '".$xoopsModuleConfig['default_address']."';\n";
		$js.= "		lat_value = document.getElementById(\"lat\").value;\n";
		$js.= "		lon_value = document.getElementById(\"lon\").value;\n";
		$js.= "		zoom_value = document.getElementById(\"zoom\").value;\n";
		$js.= "		}\n";
		$js.= "	if (!lat_value) lat_value = ".$xoopsModuleConfig['default_lat'].";\n";
		$js.= "	if (!lon_value) lon_value = ".$xoopsModuleConfig['default_lon'].";\n";
		$js.= "	if (!zoom_value) zoom_value = ".$xoopsModuleConfig['default_zoom'].";\n";
		$js.= "	}\n";
		$js.= "//]]>\n";
		$js.= "</script>\n";
		echo $js;

		$form = new XoopsThemeForm(_MD_ADDNEWLINK, "op", xoops_getenv('PHP_SELF')."?op=$op");
		$form->setExtra('enctype="multipart/form-data"');
		$form->addElement(new XoopsFormText(_MD_SITETITLE, "title", 50, 50, ''));
	
		ob_start() ;
		$mytree->makeMySelBox('title', 'title');
		$cat_selbox = ob_get_contents() ;
		ob_end_clean() ;
		$form->addElement(new XoopsFormLabel(_MD_CATEGORYC,$cat_selbox));	
		$form->addElement(new XoopsFormText(_MD_ADDRESS, 'input_address', 50, 100, ''));
		$form->addElement(new XoopsFormText(_MD_ZIP, 'input_zip', 20, 20, ''));
		$form->addElement(new XoopsFormText(_MD_CITY, 'input_city', 50, 100, ''));
		$form->addElement(new XoopsFormText(_MD_COUNTRY, 'input_country', 50, 100, ''));
		$form->addElement(new XoopsFormText(_MD_LAT, 'lat', 15, 30, ''));		
		$form->addElement(new XoopsFormText(_MD_LON, 'lon', 15, 30, ''));
		$form->addElement(new XoopsFormText(_MD_ZOOM, 'zoom', 15, 30, ''));

		$map_button = new XoopsFormButton (_MD_MAP, 'button', _MD_MAP, 'button');
		$map_button->setExtra("onclick=\"getLatLonZoom();window.open('../google_maps_popup.php?lat='+lat_value+'&lon='+lon_value+'&zoom='+zoom_value+'&request='+request_value,'google_map_window','".$xoopsModuleConfig['popup_options']."');\"");
		$form->addElement($map_button);

		$form->addElement(new XoopsFormText(_MD_PHONE, 'phone', 20, 40, ''));
		$form->addElement(new XoopsFormText(_MD_MOBILE, 'mobile', 20, 40, ''));
		$form->addElement(new XoopsFormText(_MD_FAX, 'fax', 20, 40, ''));
		$form->addElement(new XoopsFormText(_MD_CONTEMAIL, 'contemail', 50, 100, ''));
		$form->addElement(new XoopsFormText(_MD_SITEURL, 'url', 50, 250, ''));

		$form->addElement(new XoopsFormTextArea (_MD_OPENED, 'opentime', '', 5, 60));
		$form->addElement(new XoopsFormDhtmlTextArea(_MD_DESCRIPTIONA, 'description', '', 8, 8));

		$logourl='';
		$uploadurl=$xoopsModuleConfig['shot_path'];
		$uploadirectory=XOOPS_ROOT_PATH.'/'.$uploadurl.'/';
		$linkimg_array = XoopsLists::getImgListAsArray($uploadirectory);
		$imgtray = new XoopsFormElementTray(_MD_SHOTIMAGE,'');
		$imgtray->setDescription(sprintf(_MD_SHOTIMAGEDESC,$xoopsModuleConfig['max_shot_size'],$xoopsModuleConfig['max_shot_width'],$xoopsModuleConfig['max_shot_height']));
			$imageselect= new XoopsFormSelect(sprintf(_MD_SHOTMUST,$uploadirectory).'<br />','logourl',$logourl);
//			$imageselect->addOption(' ','------');
			$imageselect->addOption('','------');
			foreach($linkimg_array as $image)
				$imageselect->addOption("$image",$image);
			$imageselect->setExtra("onchange='showImgSelected(\"image_logourl\", \"logourl\", \"".$uploadurl."\", \"\", \"".XOOPS_URL."\")'" );
		$imgtray->addElement($imageselect,false);
		$imgtray->addElement(new XoopsFormLabel('',"<br /><img src='".XOOPS_URL."/".$uploadurl."/".$logourl."' name='image_logourl' id='image_logourl' alt='' /><br />"));
			$fileseltray= new XoopsFormElementTray('<hr />'._AM_TOPIC_PICTURE.'<br />','');
			$fileseltray->addElement(new XoopsFormFile('', 'attachedfile', $xoopsModuleConfig['max_shot_size']), false);
			$fileseltray->addElement(new XoopsFormLabel(sprintf('<br />'._AM_UPLOAD_WARNING.'<br />',$uploadirectory)), false);
		$imgtray->addElement($fileseltray);
		$form->addElement($imgtray);

		$form->addElement(new XoopsFormHidden('op', 'Address_add'),false);
		$button_tray = new XoopsFormElementTray('' ,'');
		$submit_btn = new XoopsFormButton('', 'post', _MD_ADD, 'submit');
		$submit_btn->setExtra('accesskey="s"');
		$button_tray->addElement($submit_btn);
		$form->addElement($button_tray);

		$form->display();
		// Add a New Address - end

		echo "<br />";
		}
	xoops_cp_footer();
	}




function Address_mod()
	{
	global $xoopsDB, $_GET, $myts, $eh, $mytree, $xoopsConfig, $xoopsModuleConfig, $op;
	$linkimg_array = XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH.'/'.$xoopsModuleConfig['shot_path'].'/');
	$aid = $_GET['aid'];
	xoops_cp_header();
	adminmenu(1);

	$sql = "SELECT cid, title, address, zip, city, country, lon, lat, zoom, phone, mobile, fax, contemail, opentime, url, logourl";
	$sql.= " FROM ".$xoopsDB->prefix("addresses_addresses");
	$sql.= " WHERE aid=".$aid."";
	$query = $xoopsDB->query($sql) or $eh->show("0013");

	list($cid, $title, $address, $zip, $city, $country, $lon, $lat, $zoom, $phone, $mobile, $fax, $contemail, $opentime, $url, $logourl) = $xoopsDB->fetchRow($query);
	$title     = $myts->makeTboxData4Edit($title);
	$address    = $myts->makeTboxData4Edit($address);
	$zip       = $myts->makeTboxData4Edit($zip);
	$city      = $myts->makeTboxData4Edit($city);
	$country   = $myts->makeTboxData4Edit($country);
	$lon       = $myts->makeTboxData4Edit($lon);
	$lat       = $myts->makeTboxData4Edit($lat);
	$zoom      = $myts->makeTboxData4Edit($zoom);
	$phone     = $myts->makeTboxData4Edit($phone);
	$mobile    = $myts->makeTboxData4Edit($mobile);
	$fax       = $myts->makeTboxData4Edit($fax);
	$contemail = $myts->makeTboxData4Edit($contemail);
	$opentime  = $myts->makeTareaData4Edit($opentime);
	$url       = $myts->makeTboxData4Edit($url);
	//$url = urldecode($url);
	$logourl   = $myts->makeTboxData4Edit($logourl);
	//$logourl = urldecode($logourl);
	$query_text  = $xoopsDB->query("SELECT description FROM ".$xoopsDB->prefix("addresses_addresses_text")." WHERE aid=$aid");
	list($description)=$xoopsDB->fetchRow($query_text);
	$GLOBALS['description'] = $myts->makeTareaData4Edit($description); // ???????????

		$js = "<script type=\"text/javascript\">\n";
		$js.= "//<![CDATA[\n";
		$js.= "var address_value;\n";
		$js.= "var zip_value;\n";
		$js.= "var city_value;\n";
		$js.= "var country_value;\n";
		$js.= "var request_value;\n";
		$js.= "var lat_value;\n";
		$js.= "var lon_value;\n";
		$js.= "var zoom_value;\n";
		$js.= "function getLatLonZoom()\n";
		$js.= "	{\n";
		$js.= "	if (document.getElementById)\n";
		$js.= "		{\n";
		$js.= "		address_value = document.getElementById(\"input_address\").value;\n";
		$js.= "		zip_value = document.getElementById(\"input_zip\").value;\n";
		$js.= "		city_value = document.getElementById(\"input_city\").value;\n";
		$js.= "		country_value = document.getElementById(\"input_country\").value;\n";
		$js.= "		request_value = address_value+','+zip_value+','+city_value+','+country_value;\n";
		$js.= "		if (request_value == ',,,') request_value = '".$xoopsModuleConfig['default_address']."';\n";
		$js.= "		lat_value = document.getElementById(\"lat\").value;\n";
		$js.= "		lon_value = document.getElementById(\"lon\").value;\n";
		$js.= "		zoom_value = document.getElementById(\"zoom\").value;\n";
		$js.= "		}\n";
		$js.= "	if (!lat_value) lat_value = ".$xoopsModuleConfig['default_lat'].";\n";
		$js.= "	if (!lon_value) lon_value = ".$xoopsModuleConfig['default_lon'].";\n";
		$js.= "	if (!zoom_value) zoom_value = ".$xoopsModuleConfig['default_zoom'].";\n";
		$js.= "	}\n";
		$js.= "//]]>\n";
		$js.= "</script>\n";
		echo $js;

		$form = new XoopsThemeForm(_MD_MODLINK, "op", xoops_getenv('PHP_SELF')."?op=$op");
		$form->setExtra('enctype="multipart/form-data"');
		$form->addElement(new XoopsFormLabel(_MD_LINKID, $aid,"aid"));
		$form->addElement(new XoopsFormText(_MD_SITETITLE, "title", 50, 50, $title));
		ob_start() ;
		$mytree->makeMySelBox('title','title',$cid);
		$cat_selbox = ob_get_contents() ;
		ob_end_clean() ;
		$form->addElement(new XoopsFormLabel(_MD_CATEGORYC,$cat_selbox));	

		$form->addElement(new XoopsFormText(_MD_ADDRESS, 'input_address', 50, 100, $address));
		$form->addElement(new XoopsFormText(_MD_ZIP, 'input_zip', 20, 20, $zip));
		$form->addElement(new XoopsFormText(_MD_CITY, 'input_city', 50, 100, $city));
		$form->addElement(new XoopsFormText(_MD_COUNTRY, 'input_country', 50, 100, $country));
		$form->addElement(new XoopsFormText(_MD_LAT, 'lat', 15, 30, $lat));		
		$form->addElement(new XoopsFormText(_MD_LON, 'lon', 15, 30, $lon));
		$form->addElement(new XoopsFormText(_MD_ZOOM, 'zoom', 15, 30, $zoom));

		$map_button = new XoopsFormButton (_MD_MAP, 'button', _MD_MAP, 'button');
		$map_button->setExtra("onclick=\"getLatLonZoom();window.open('../google_maps_popup.php?lat='+lat_value+'&lon='+lon_value+'&zoom='+zoom_value+'&request='+request_value,'google_map_window','".$xoopsModuleConfig['popup_options']."');\"");
		$form->addElement($map_button);

		$form->addElement(new XoopsFormText(_MD_PHONE, 'phone', 20, 40, $phone));
		$form->addElement(new XoopsFormText(_MD_MOBILE, 'mobile', 20, 40, $mobile));
		$form->addElement(new XoopsFormText(_MD_FAX, 'fax', 20, 40, $fax));
		$form->addElement(new XoopsFormText(_MD_CONTEMAIL, 'contemail', 50, 100, $contemail));
		$form->addElement(new XoopsFormText(_MD_SITEURL, 'url', 50, 250, $url));

		$form->addElement(new XoopsFormTextArea (_MD_OPENED, 'opentime', $opentime, 5, 60));
		$form->addElement(new XoopsFormDhtmlTextArea(_MD_DESCRIPTIONC, 'description', $description, 8, 8));






		// set/upload image/shot form - start // DA CORREGGERE DA CORREGGERE DA CORREGGERE
//		$logourl='';
		$uploadurl=$xoopsModuleConfig['shot_path'];
		$uploadirectory=XOOPS_ROOT_PATH.'/'.$uploadurl.'/';
		$linkimg_array = XoopsLists::getImgListAsArray($uploadirectory);
		$imgtray = new XoopsFormElementTray(_MD_SHOTIMAGE,'');
		$imgtray->setDescription(sprintf(_MD_SHOTIMAGEDESC,$xoopsModuleConfig['max_shot_size'],$xoopsModuleConfig['max_shot_width'],$xoopsModuleConfig['max_shot_height']));
			$imageselect= new XoopsFormSelect(sprintf(_MD_SHOTMUST,$uploadirectory).'<br />','logourl',$logourl);
//			$imageselect->addOption(' ','------');
			$imageselect->addOption('','------');
			foreach($linkimg_array as $image)
				$imageselect->addOption("$image",$image);
			$imageselect->setExtra("onchange='showImgSelected(\"image_logourl\", \"logourl\", \"".$uploadurl."\", \"\", \"".XOOPS_URL."\")'" );
		$imgtray->addElement($imageselect,false);
		$imgtray->addElement(new XoopsFormLabel('',"<br /><img src='".XOOPS_URL."/".$uploadurl."/".$logourl."' name='image_logourl' id='image_logourl' alt='' /><br />"));
			$fileseltray= new XoopsFormElementTray('<hr />'._AM_TOPIC_PICTURE.'<br />','');
			//$fileseltray->addElement(new XoopsFormFile(_AM_TOPIC_PICTURE , 'attachedfile', news_getmoduleoption('maxuploadsize')), false);
			$fileseltray->addElement(new XoopsFormFile('', 'attachedfile', $xoopsModuleConfig['max_shot_size']), false);
			$fileseltray->addElement(new XoopsFormLabel(sprintf('<br />'._AM_UPLOAD_WARNING.'<br />',$uploadirectory)), false);
		$imgtray->addElement($fileseltray);
		$form->addElement($imgtray);
		// set/upload image/shot form - end // DA CORREGGERE DA CORREGGERE DA CORREGGERE










		$form->addElement(new XoopsFormHidden('aid', $aid),false);
		$form->addElement(new XoopsFormHidden('op', 'Address_mod_S'),false);

		$button_tray = new XoopsFormElementTray('', '');
			$modify_btn = new XoopsFormButton('', 'post', _MD_SAVE, 'submit');
			$modify_btn->setExtra('accesskey="m"');
		$button_tray -> addElement($modify_btn);
			$delete_btn = new XoopsFormButton('', 'delete', _MD_DELETE, 'button');
			$delete_btn -> setExtra("onclick=\"javascript:location='index.php?op=Address_del&aid=".$aid."'\"");
		$button_tray -> addElement($delete_btn);
			$cancel_btn = new XoopsFormButton('', 'cancel', _MD_CANCEL, 'button');
			$cancel_btn -> setExtra("onclick=\"javascript:history.go(-1)\"");
		$button_tray -> addElement($cancel_btn);
		$form -> addElement($button_tray);

		$form->display();

	echo "<hr />";
	
	$result5=$xoopsDB->query("SELECT count(*) FROM ".$xoopsDB->prefix("addresses_votedata")." WHERE aid = $aid");
	list($totalvotes) = $xoopsDB->fetchRow($result5);
	echo "<table class='outer'>\n";
	echo "<tr class='head'><td colspan=7><b>".sprintf(_MD_TOTALVOTES,$totalvotes)."</b></td></tr>\n";
	// Show Registered Users Votes
	$result5=$xoopsDB->query("SELECT ratingid, ratinguser, rating, ratinghostname, ratingtimestamp FROM ".$xoopsDB->prefix("addresses_votedata")." WHERE aid = $aid AND ratinguser >0 ORDER BY ratingtimestamp DESC");
	$votes = $xoopsDB->getRowsNum($result5);
	echo "<tr class='head'><td colspan=7><b>".sprintf(_MD_USERTOTALVOTES,$votes)."</b></td></tr>\n";
	echo "<tr class='odd'>";
	echo "<td><b>" ._MD_USER."  </b></td>";
	echo "<td><b>" ._MD_IP."  </b></td>";
	echo "<td><b>" ._MD_RATING."  </b></td>";
	echo "<td><b>" ._MD_USERAVG."  </b></td>";
	echo "<td><b>" ._MD_TOTALRATE."  </b></td>";
	echo "<td><b>" ._MD_DATE."  </b></td>";
	echo "<td align=\"center\"><b>" ._MD_DELETE."</b></td>";
	echo "</tr>\n";
	if ($votes == 0)
		{
		echo "<tr><td align=\"center\" colspan=\"7\">" ._MD_NOREGVOTES."<br /></td></tr>\n";
		}
	$x=0;
	$colorswitch="dddddd";
	while(list($ratingid, $ratinguser, $rating, $ratinghostname, $ratingtimestamp)=$xoopsDB->fetchRow($result5))
		{
		//$ratingtimestamp = formatTimestamp($ratingtimestamp);
		//Individual user information
		$result2=$xoopsDB->query("SELECT rating FROM ".$xoopsDB->prefix("addresses_votedata")." WHERE ratinguser = '$ratinguser'");
		$uservotes = $xoopsDB->getRowsNum($result2);
		$useravgrating = 0;
		while ( list($rating2) = $xoopsDB->fetchRow($result2) )
			{
			$useravgrating = $useravgrating + $rating2;
			}
		$useravgrating = $useravgrating / $uservotes;
		$useravgrating = number_format($useravgrating, 1);
		$ratingusername = XoopsUser::getUnameFromId($ratinguser);
		echo "<tr class='odd'>";
		echo "<td bgcolor=\"".$colorswitch."\">".$ratingusername."</td>";
		echo "<td bgcolor=\"$colorswitch\">".$ratinghostname."</td>";
		echo "<td bgcolor=\"$colorswitch\">$rating</td>";
		echo "<td bgcolor=\"$colorswitch\">".$useravgrating."</td>";
		echo "<td bgcolor=\"$colorswitch\">".$uservotes."</td>";
		echo "<td bgcolor=\"$colorswitch\">".$ratingtimestamp."</td>";
		echo "<td bgcolor=\"$colorswitch\" align=\"center\"><b>".myTextForm("index.php?op=Vote_del&aid=$aid&rid=$ratingid", "X")."</b></td>";
		echo "</tr>\n";
		$x++;
		if ( $colorswitch == "dddddd" )
			{$colorswitch="ffffff";}
		else
			{$colorswitch="dddddd";}
		}
	// Show Unregistered Users Votes
	$result5=$xoopsDB->query("SELECT ratingid, rating, ratinghostname, ratingtimestamp FROM ".$xoopsDB->prefix("addresses_votedata")." WHERE aid = $aid AND ratinguser = 0 ORDER BY ratingtimestamp DESC");
	$votes = $xoopsDB->getRowsNum($result5);
	echo "<tr class='head'><td colspan=7><b>".sprintf(_MD_ANONTOTALVOTES,$votes)."</b></td></tr>\n";
	echo "<tr class='odd'>";
	echo "<td colspan=2><b>"._MD_IP."</b></td>";
	echo "<td colspan=3><b>"._MD_RATING."</b></td>";
	echo "<td><b>"._MD_DATE." </b></td>";
	echo "<td align=\"center\"><b>" ._MD_DELETE."</b></td>";
	echo "</tr>";
	if ( $votes == 0 )
		{
		echo "<tr><td colspan=\"7\" align=\"center\">" ._MD_NOUNREGVOTES."<br /></td></tr>";
		}
	$x=0;
	$colorswitch="dddddd";
	while ( list($ratingid, $rating, $ratinghostname, $ratingtimestamp)=$xoopsDB->fetchRow($result5) )
		{
		$formatted_date = formatTimestamp($ratingtimestamp);
		echo "<td colspan=\"2\" bgcolor=\"$colorswitch\">$ratinghostname</td>";
		echo "<td colspan=\"3\" bgcolor=\"$colorswitch\">$rating</td>";
		echo "<td bgcolor=\"$colorswitch\">$formatted_date</td>";
		echo "<td bgcolor=\"$colorswitch\" aling=\"center\"><b>".myTextForm("index.php?op=Vote_del&aid=$aid&rid=$ratingid", "X")."</b></td>";
		echo "</tr>";
		$x++;
		if ( $colorswitch == "dddddd" )
			{$colorswitch="ffffff";}
		else
			{$colorswitch="dddddd";}
		}
	echo "</table>\n";

	xoops_cp_footer();
	}




function Vote_del()
	{
	global $xoopsDB, $_GET, $eh;
	$rid = $_GET['rid'];
	$aid = $_GET['aid'];
	$sql = sprintf("DELETE FROM %s WHERE ratingid = %u", $xoopsDB->prefix("addresses_votedata"), $rid);
	$xoopsDB->query($sql) or $eh->show("0013");
	updaterating($aid);
	redirect_header("index.php",1,_MD_VOTEDELETED);
	exit();
	}




function BrokenAddress_list()
	{
	global $xoopsDB, $eh;
	$result = $xoopsDB->query("select * from ".$xoopsDB->prefix("addresses_broken")." group by aid order by reportid DESC");
	$totalbrokenaddresses = $xoopsDB->getRowsNum($result);
	xoops_cp_header();
	adminmenu(3);

	echo "<h4>"._MD_BROKENREPORTS." ($totalbrokenaddresses)</h4>";

	if ($totalbrokenaddresses==0)
		{
		echo _MD_NOBROKEN;
		}
	else
		{
		echo "<table width='100%' border='0' cellspacing='1' class='outer'>";
		echo "<tr class=\"odd\"><td>";
		echo "<b>"._MD_ACTION."</b>";
		echo "<br />";
		echo "<b>"._MD_IGNORE."</b> "._MD_IGNOREDESC."<br />";
		echo "<b>"._MD_MODIFY."</b> "._MD_MODIFYDESC."<br />";
		echo "<b>"._MD_DELETE."</b> "._MD_DELETEDESC."<br />";
		echo "</td></tr></table>";
		echo "<br /><br />";
		$class='';
		echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
		echo "<tr class='bg3'>";
		echo "<td align='center'>"._MD_SITETITLE."</td>\n";
		echo "<td align='center'>"._MD_REPORTER."</td>";
		echo "<td align='center'>"._MD_LINKSUBMITTER."</td>";
		echo "<td align='center'>"._MD_ACTION."</td>";
		echo "</tr>";
		while (list($reportid, $aid, $sender, $ip)=$xoopsDB->fetchRow($result))
			{
			$result2 = $xoopsDB->query("select title, url, submitter from ".$xoopsDB->prefix("addresses_addresses")." where aid=$aid");
			if ($sender != 0)
				{
				$result3 = $xoopsDB->query("select uname, email from ".$xoopsDB->prefix("users")." where uid=$sender");
				list($uname, $email)=$xoopsDB->fetchRow($result3);
				}
			list($title, $url, $ownerid)=$xoopsDB->fetchRow($result2);
			//$url=urldecode($url);
			$result4 = $xoopsDB->query("select uname, email from ".$xoopsDB->prefix("users")." where uid='$ownerid'");
			list($owner, $owneremail)=$xoopsDB->fetchRow($result4);
			$class = ($class == 'even') ? 'odd' : 'even';
			echo "<tr class='".$class."'>";
			echo "<td><a href=$url target='_blank'>$title</a></td>";
			echo "<td>";
			if ($email=='')
				echo $sender." (".$ip.")";
			else
				echo "<a href=\"mailto:".$email."\">".$uname."</a> (".$ip.")";
			echo "</td>";
			echo "<td>";
			if ($owneremail == '')
				echo $owner;
			else
				echo "<a href=\"mailto:".$owneremail."\">".$owner."</a>";
			echo "</td>";
			echo "<td align='center'>";
			echo "<a href='".XOOPS_URL."/modules/addresses/admin/index.php?op=BrokenAddress_ignore&aid=".$aid."' title='"._MD_IGNOREDESC."'>"._MD_IGNORE."</a>";
			echo " | ";
			echo "<a href='".XOOPS_URL."/modules/addresses/admin/index.php?op=Address_mod&aid=".$aid."' title='"._MD_MODIFYDESC."'>"._MD_MODIFY."</a>";
			echo " | ";
			echo "<a href='".XOOPS_URL."/modules/addresses/admin/index.php?op=BrokenAddress_del&aid=".$aid."' title='"._MD_DELETEDESC."'>"._MD_DELETE."</a>";
			echo "</td>";
			echo "</tr>\n";
			}
		echo "</table>";
		}
	xoops_cp_footer();
	}




function BrokenAddress_del() //SHINE need to change later
	{
	global $xoopsDB, $_GET, $eh;
	$aid = $_GET['aid'];
	$sql = sprintf("DELETE FROM %s WHERE aid = %u", $xoopsDB->prefix("addresses_broken"), $aid);
	$xoopsDB->queryF($sql) or $eh->show("0013");
	$sql = sprintf("DELETE FROM %s WHERE aid = %u", $xoopsDB->prefix("addresses_addresses"), $aid);
	$xoopsDB->queryF($sql) or $eh->show("0013");
	redirect_header("index.php",1,_MD_LINKDELETED);
	exit();
}




function BrokenAddress_ignore() //SHINE need to change later
	{
	global $xoopsDB, $_GET, $eh;
	$sql = sprintf("DELETE FROM %s WHERE aid = %u", $xoopsDB->prefix("addresses_broken"), $_GET['aid']);
	$xoopsDB->queryF($sql) or $eh->show("0013");
	redirect_header("index.php",1,_MD_BROKENDELETED);
	exit();
}




//Shine: MODIFICATION REQUESTS VIEW WITHIN ADMINAREA
function ModReqAddress_list()
	{
	global $xoopsDB, $xoopsConfig, $myts, $eh, $mytree, $xoopsModuleConfig, $op;
	//Catz edit from here
	//Changed this to select all fields from the database, instead of listing them all as this creates an error for some reason. Not sure why but it does?   	
	$sql = "SELECT *";
	$sql.= " FROM ".$xoopsDB->prefix("addresses_mod")."";
	$sql.= " ORDER BY requestid";
	$mod_query = $xoopsDB->query($sql);
	$totalmodrequests = $xoopsDB->getRowsNum($mod_query);
	
	xoops_cp_header();
	adminmenu(4);
	echo "<h4>"._MD_USERMODREQ." ($totalmodrequests)</h4>";

	if ($totalmodrequests > 0)
		{
		$lookup_aid = array();
		while ($mod = $xoopsDB->fetchArray($mod_query))
			{
			$lookup_aid[$mod['requestid']] = $mod['aid'];

			$sql = "SELECT *";
			$sql.= " FROM ".$xoopsDB->prefix("addresses_addresses")."";
			$sql.= " WHERE aid=".$mod['aid']."";			
			$original_query = $xoopsDB->query($sql);
			$original = $xoopsDB->fetchArray($original_query);
			$sql = "SELECT description";
			$sql.= " FROM ".$xoopsDB->prefix("addresses_addresses_text")."";
			$sql.= " WHERE aid=".$mod['aid']."";
			$original_query = $xoopsDB->query($sql);
			$original = array_merge($original,$xoopsDB->fetchArray($original_query));

			$sql = "SELECT uname, email";
			$sql.= " FROM ".$xoopsDB->prefix("users")."";
			$sql.= " WHERE uid='".$mod['modifysubmitter']."'";
			$mod_submitter_query = $xoopsDB->query($sql);
			list($submitter, $submitteremail)=$xoopsDB->fetchRow($mod_submitter_query);

			$sql = "SELECT uname, email";
			$sql.= " FROM ".$xoopsDB->prefix("users")."";
			$sql.= " WHERE uid='".$original['submitter']."'";
			$submitter_query = $xoopsDB->query($sql);
			list($owner, $owneremail)=$xoopsDB->fetchRow($submitter_query);

			$mod_cidtitle=$mytree->getPathFromId($mod['cid'], "title");
			$original_cidtitle=$mytree->getPathFromId($original['cid'], "title");

			$mod['title']     = $myts->makeTboxData4Show($mod['title']);
			$mod['address']   = $myts->makeTboxData4Show($mod['address']);
			$mod['zip']       = $myts->makeTboxData4Show($mod['zip']);
			$mod['city']      = $myts->makeTboxData4Show($mod['city']);
			$mod['country']   = $myts->makeTboxData4Show($mod['country']);
			$mod['lon']       = $myts->makeTboxData4Show($mod['lon']);
			$mod['lat']       = $myts->makeTboxData4Show($mod['lat']);
			$mod['zoom']      = $myts->makeTboxData4Show($mod['zoom']);
			$mod['phone']     = $myts->makeTboxData4Show($mod['phone']);
			$mod['mobile']    = $myts->makeTboxData4Show($mod['mobile']);
			$mod['fax']       = $myts->makeTboxData4Show($mod['fax']);
			$mod['contemail'] = $myts->makeTboxData4Show($mod['contemail']);
			$mod['opentime']  = $myts->makeTareaData4Show($mod['opentime']);

			// use original image file to prevent users from changing screen shots file
			$original['logourl'] = $myts->makeTboxData4Show($original['logourl']);
			$logourl = $original['logourl'];

			$mod['description'] = $myts->makeTareaData4Show($mod['description']);
			$original['description'] = $myts->makeTareaData4Show($original['description']);
			
			if ($owner == "") $owner="administration";

			// VIEW ORIGINAL // VIEW PROPOSEL
			echo "<table border=0 cellpadding=2 cellspacing=1 align=center width=100% class ='outer'>\n";
			echo "<tr><td class ='bg3'>&nbsp;</td>";
			echo "<td class ='bg3'><b>"._MD_ORIGINAL."</b></td>";
			echo "<td class ='bg3'><b>"._MD_PROPOSED."</b></td>";
			echo "</tr>\n";
			echo "<tr><td class ='head'>"._MD_SITETITLE."</td>";
			echo "<td class ='even'>".$original['title']."</td>";
			echo "<td class ='".($original['title']==$mod['title']?'even':'head')."'>".$mod['title']."</td>";
			echo "</tr>\n";
			echo "<tr><td class ='head'>"._MD_ADDRESS."</td>";
			echo "<td class ='even'>".$original['address']."</td>";
			echo "<td class ='".($original['address']==$mod['address']?'even':'head')."'>".$mod['address']."</td>";
			echo "</tr>\n";
			echo "<tr><td class ='head'>"._MD_ZIP."</td>";
			echo "<td class ='even'>".$original['zip']."</td>";
			echo "<td class ='".($original['zip']==$mod['zip']?'even':'head')."'>".$mod['zip']."</td>";
			echo "</tr>\n";
			echo "<tr><td class ='head'>"._MD_CITY."</td>";
			echo "<td class ='even'>".$original['city']."</td>";
			echo "<td class ='".($original['city']==$mod['city']?'even':'head')."'>".$mod['city']."</td>";
			echo "</tr>\n";
			echo "<tr><td class ='head'>"._MD_COUNTRY."</td>";
			echo "<td class ='even'>".$original['country']."</td>";
			echo "<td class ='".($original['country']==$mod['country']?'even':'head')."'>".$mod['country']."</td>";
			echo "</tr>\n";
			echo "<tr><td class ='head'>"._MD_LON."</td>";
			echo "<td class ='even'>".$original['lon']."</td>";
			echo "<td class ='".($original['lon']==$mod['lon']?'even':'head')."'>".$mod['lon']."</td>";
			echo "</tr>\n";
			echo "<tr><td class ='head'>"._MD_LAT."</td>";
			echo "<td class ='even'>".$original['lat']."</td>";
			echo "<td class ='".($original['lat']==$mod['lat']?'even':'head')."'>".$mod['lat']."</td>";
			echo "</tr>\n";
			echo "<tr><td class ='head'>"._MD_ZOOM."</td>";
			echo "<td class ='even'>".$original['zoom']."</td>";
			echo "<td class ='".($original['zoom']==$mod['zoom']?'even':'head')."'>".$mod['zoom']."</td>";
			echo "</tr>\n";
			echo "<tr><td class ='head'>"._MD_PHONE."</td>";
			echo "<td class ='even'>".$original['phone']."</td>";
			echo "<td class ='".($original['phone']==$mod['phone']?'even':'head')."'>".$mod['phone']."</td>";
			echo "</tr>\n";
			echo "<tr><td class ='head'>"._MD_MOBILE."</td>";
			echo "<td class ='even'>".$original['mobile']."</td>";
			echo "<td class ='".($original['mobile']==$mod['mobile']?'even':'head')."'>".$mod['mobile']."</td>";
			echo "</tr>\n";
			echo "<tr><td class ='head'>"._MD_FAX."</td>";
			echo "<td class ='even'>".$original['fax']."</td>";
			echo "<td class ='".($original['fax']==$mod['fax']?'even':'head')."'>".$mod['fax']."</td>";
			echo "</tr>\n";
			echo "<tr><td class ='head'>"._MD_CONTEMAIL."</td>";
			echo "<td class ='even'>".$original['contemail']."</td>";
			echo "<td class ='".($original['contemail']==$mod['contemail']?'even':'head')."'>".$mod['contemail']."</td>";
			echo "</tr>\n";
			echo "<tr><td class ='head'>"._MD_SITEURL."</td>";
			echo "<td class ='even'>".$original['url']."</td>";
			echo "<td class ='".($original['url']==$mod['url']?'even':'head')."'>".$mod['url']."</td>";
			echo "</tr>\n";
			echo "<tr><td class ='head'>"._MD_OPENED."</td>";
			echo "<td class ='even'>".$original['opentime']."</td>";
			echo "<td class ='".($original['opentime']==$mod['opentime']?'even':'head')."'>".$mod['opentime']."</td>";
			echo "</tr>\n";
			echo "<tr><td class ='head'>"._MD_DESCRIPTIONA."</td>";
			echo "<td class ='even'>".$original['description']."</td>";
			echo "<td class ='".($original['description']==$mod['description']?'even':'head')."'>".$mod['description']."</td>";
			echo "</tr>\n";
			echo "<tr><td class ='head'>"._MD_CATEGORYC."</td>";
			echo "<td class ='even'>".$original_cidtitle."</td>";
			echo "<td class ='even'>".$mod_cidtitle."</td>";
			echo "</tr>\n";
			echo "<tr><td class ='head'>"._MD_SHOTIMAGE."</td>";
			echo "<td class ='even'>";
			if ($xoopsModuleConfig['useshots'] && !empty($original['logourl']))
				{echo "<img src=\"".XOOPS_URL."/".$xoopsModuleConfig['shot_path']."/".$original['logourl']."\" width=\"".$xoopsModuleConfig['shotwidth']."\" />";}
			else
				{echo "&nbsp;";}
			echo "</td>";
			echo "<td class ='even'>";			
			if ($xoopsModuleConfig['useshots']==1 && !empty($mod['logourl']))
				{echo "<img src=\"".XOOPS_URL."/".$xoopsModuleConfig['shot_path']."/".$mod['logourl']."\" width=\"".$xoopsModuleConfig['shotwidth']."\" alt=\"/\" />";}
			else
				{echo "&nbsp;";}
			echo "</td>";
			echo "</tr>\n";
			echo "</table>\n";

			echo "<table border=0 cellpadding=2 cellspacing=1 align=center width=100% class='outer'>\n";
			echo "<tr class='bg3'>";
			echo "<td align='center'>"._MD_SUBMITTER."</td>";
			echo "<td align='center'>"._MD_OWNER."</td>";
			echo "<td align='center'>"._MD_ACTION."</td>";
			echo "</tr>";
			echo "<tr class='even'>";
			if ( $submitteremail == "" )
				{echo "<td align='center'>".$submitter."</td>";}
			else
				{echo "<td align='center'><a href='mailto:".$submitteremail."'>".$submitter."</a></td>\n";}
			if ( $owneremail == "" )
				{echo "<td align='center'>".$owner."</td>";}
			else {echo "<td align='center'><a href='mailto:".$owneremail."'>".$owner."</a></td>\n";}
			echo "<td align='center'>";
			// modview stops here. // 
			echo "<a href='index.php?op=ModReqAddress_change&requestid=".$mod['requestid']."'>"._MD_APPROVE."</a>";
			echo " | ";
			echo "<a href='index.php?op=Address_mod&aid=".$lookup_aid[$mod['requestid']]."'>"._EDIT."</a>";
			echo " | ";
			echo "<a href='index.php?op=ModReqAddress_ignore&requestid=".$mod['requestid']."'>"._MD_IGNORE."</a>";
			echo "</td></tr>\n";
			echo "</table>\n";
			}
		}
	else
		{
		echo _MD_NOMODREQ;
		}
	xoops_cp_footer();
	}




function ModReqAddress_change()
	{
	global $xoopsDB, $_GET, $eh, $myts;
	$requestid = $_GET['requestid'];

	$query = "SELECT aid, cid, title, address, zip, city, country, lon, lat, zoom, phone, mobile, fax, contemail, opentime, url, logourl, description";
	$query.= " FROM ".$xoopsDB->prefix("addresses_mod");
	$query.= " WHERE requestid=".$requestid."";
	$result = $xoopsDB->query($query);
	while ( list($aid, $cid, $title, $address, $zip, $city, $country, $lon, $lat, $zoom, $phone, $mobile, $fax, $contemail, $opentime, $url, $logourl, $description)=$xoopsDB->fetchRow($result) )
		{
		if ( get_magic_quotes_runtime() )
			{
			$title       = stripslashes($title);
			$address     = stripslashes($address);
			$zip         = stripslashes($zip);
			$city        = stripslashes($city);
			$country     = stripslashes($country);
			$lon         = stripslashes($lon);
			$lat         = stripslashes($lat);
			$zoom        = stripslashes($zoom);
			$phone       = stripslashes($phone);
			$mobile      = stripslashes($mobile);
			$fax         = stripslashes($fax);
			$contemail   = stripslashes($contemail);
			$opentime    = stripslashes($opentime);
			$url         = stripslashes($url);
			$logourl     = stripslashes($logourl);
			$description = stripslashes($description);
			}
		$title       = addslashes($title);
		$address     = addslashes($address);
		$zip         = addslashes($zip);
		$city        = addslashes($city);
		$country     = addslashes($country);
		$lon         = addslashes($lon);
		$lat         = addslashes($lat);
		$zoom        = addslashes($zoom);
		$phone       = addslashes($phone);
		$mobile      = addslashes($mobile);
		$fax         = addslashes($fax);
		$contemail   = addslashes($contemail);
		$opentime    = addslashes($opentime);
		$url         = addslashes($url);
		$logourl     = addslashes($logourl);
		$description = addslashes($description); 

		$sql = "UPDATE %s";
		$sql.= " SET cid = %u, title = '%s', address = '%s', zip = '%s', city = '%s', country = '%s', lon = %f, lat = %f, zoom = %u, phone = '%s', mobile = '%s', fax = '%s', contemail = '%s', opentime = '%s', url = '%s', logourl = '%s', status = 2, date = %u";
		$sql.= " WHERE aid = %u";
		$sql = sprintf($sql, $xoopsDB->prefix("addresses_addresses"), $cid, $title,  $address, $zip, $city, $country, $lon, $lat, $zoom, $phone, $mobile, $fax, $contemail, $opentime, $url, $logourl, time(), $aid);
		$xoopsDB->queryF($sql) or $eh->show("0013");
		$sql = sprintf("UPDATE %s SET description = '%s' WHERE aid = %u", $xoopsDB->prefix("addresses_addresses_text"), $description, $aid);
		$xoopsDB->queryF($sql) or $eh->show("0013");
		$sql = sprintf("DELETE FROM %s WHERE requestid = %u", $xoopsDB->prefix("addresses_mod"), $requestid);
		$xoopsDB->queryF($sql) or $eh->show("0013");
		}
	redirect_header("index.php",1,_MD_DBUPDATED);
	exit();
	}




function ModReqAddress_ignore()
	{
	global $xoopsDB, $_GET, $eh;
	$sql = sprintf("DELETE FROM %s WHERE requestid = %u", $xoopsDB->prefix("addresses_mod"), $_GET['requestid']);
	$xoopsDB->queryF($sql) or $eh->show("0013");
	redirect_header("index.php",1,_MD_MODREQDELETED);
	exit();
	}




//ADMIN MOD ADDRESS
function Address_mod_S() //SHINE need to change later
	{
	global $xoopsDB, $_POST, $myts, $eh;

	$cid = $_POST["cid"]; // get address's category
	$url = "";
	if (($_POST["url"]) || ($_POST["url"]!=""))
		{
		//$url = $myts->formatURL($_POST["url"]);
		//$url = urlencode($url);
		$url      = $myts->makeTboxData4Save($_POST["url"]);
		}

	$logourl = $myts->makeTboxData4Save($_POST["logourl"]);
	if(isset($_POST['xoops_upload_file']))
		{
		$fldname = $_FILES[$_POST['xoops_upload_file'][0]];
		$fldname = (get_magic_quotes_gpc()) ? stripslashes($fldname['name']) : $fldname['name']; // ??????????
		if ($fldname != '')
			{
			//load a new image and use it - start
			include_once XOOPS_ROOT_PATH.'/class/uploader.php';

			$upload_directory = XOOPS_ROOT_PATH.'/'.$xoopsModuleConfig['shot_path']; // migliorare il path... metterlo sotto xoops/upload
			$allowed_types = array('image/gif','image/jpeg','image/pjpeg','image/x-png','image/png','image/bmp');
			$uploader = new XoopsMediaUploader($upload_directory, $allowed_types, $xoopsModuleConfig['max_shot_size'], $xoopsModuleConfig['max_shot_width'], $xoopsModuleConfig['max_shot_height']);
			$uploader->setPrefix('img');
			$err = array();
	
			if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
				$uploader->setTargetFileName($fldname);
				if (!$uploader->upload()) $err[] = $uploader->getErrors();
				else $logourl= $uploader->getSavedFileName();
				}
			else
				{
				$err[] = sprintf(_FAILFETCHIMG, $fldname);
				$err = array_merge($err, $uploader->getErrors(false));
				}
			if (count($err) > 0) {
				xoops_cp_header();
				xoops_error($err);
				xoops_cp_footer();
				exit();
				}
			//load a new image and use it - end
			}
		}
	$title       = $myts->makeTboxData4Save($_POST["title"]);
	$address     = $myts->makeTboxData4Save($_POST["input_address"]);
	$zip         = $myts->makeTboxData4Save($_POST["input_zip"]);
	$city        = $myts->makeTboxData4Save($_POST["input_city"]);
	$country     = $myts->makeTboxData4Save($_POST["input_country"]);
	$lon         = $myts->makeTboxData4Save($_POST["lon"]);
	$lat         = $myts->makeTboxData4Save($_POST["lat"]);
	$zoom        = $myts->makeTboxData4Save($_POST["zoom"]);
	$phone       = $myts->makeTboxData4Save($_POST["phone"]);
	$mobile      = $myts->makeTboxData4Save($_POST["mobile"]);
	$fax         = $myts->makeTboxData4Save($_POST["fax"]);
	$contemail   = $myts->makeTboxData4Save($_POST["contemail"]);
	$opentime    = $myts->makeTareaData4Save($_POST["opentime"]);
	$description = $myts->makeTareaData4Save($_POST["description"]);
	$sql = "UPDATE ".$xoopsDB->prefix("addresses_addresses")." SET cid='$cid', title='$title', address='$address', zip='$zip', city='$city', country='$country', lon='$lon', lat='$lat', zoom='$zoom', phone='$phone', mobile='$mobile', fax='$fax', contemail='$contemail', opentime='$opentime', url='$url', logourl='$logourl', status=2, date=".time()."";
	$sql.= " WHERE aid=".$_POST['aid']; 
	$xoopsDB->query($sql) or $eh->show("0013");
	$sql = "UPDATE ".$xoopsDB->prefix("addresses_addresses_text")." SET description='$description'";
	$sql.= " WHERE aid=".$_POST['aid']."";
	$xoopsDB->query($sql) or $eh->show("0013");
	redirect_header("index.php",1,_MD_DBUPDATED);
	exit();
	}




function Address_del()
	{
	global $xoopsDB, $eh, $xoopsModule;
	$aid =  isset($_POST['aid']) ? intval($_POST['aid']) : intval($_GET['aid']);
	$ok =  isset($_POST['ok']) ? intval($_POST['ok']) : 0;
	if ($ok == 1)
		{
		$sql = sprintf("DELETE FROM %s WHERE aid = %u", $xoopsDB->prefix("addresses_addresses"), $aid);
		$xoopsDB->query($sql) or $eh->show("0013");
		$sql = sprintf("DELETE FROM %s WHERE aid = %u", $xoopsDB->prefix("addresses_addresses_text"), $aid);
		$xoopsDB->query($sql) or $eh->show("0013");
		$sql = sprintf("DELETE FROM %s WHERE aid = %u", $xoopsDB->prefix("addresses_votedata"), $aid);
		$xoopsDB->query($sql) or $eh->show("0013");
		// delete comments
		xoops_comment_delete($xoopsModule->getVar('mid'), $aid);
		// delete notifications
		xoops_notification_deletebyitem ($xoopsModule->getVar('mid'), 'address', $aid);
		
		redirect_header("index.php?op=Menu_Addresses",1,_MD_LINKDELETED); //SHINE need to change later
		exit();
		}
	else
		{
		xoops_cp_header();
		xoops_confirm(array('op' => 'Address_del', 'aid' => $aid, 'ok' => 1), 'index.php?op=Menu_Addresses', _MD_LINKWARNING);
		xoops_cp_footer();
		}
	}




function Category_mod()
	{
	global $xoopsDB, $_POST, $myts, $eh, $mytree, $op, $xoopsModuleConfig;
	$cid = $_POST["cid"];
	xoops_cp_header();
	adminmenu(0);
	$result=$xoopsDB->query("SELECT pid, title, imgurl, show_map FROM ".$xoopsDB->prefix("addresses_cat")." where cid=$cid");
	list($pid, $title, $imgurl, $show_map) = $xoopsDB->fetchRow($result);
	$title = $myts->makeTboxData4Edit($title);
	$imgurl = $myts->makeTboxData4Edit($imgurl);

	$result2  = $xoopsDB->query("SELECT description FROM ".$xoopsDB->prefix("addresses_cat_text")." WHERE cid=$cid");
	list($description)=$xoopsDB->fetchRow($result2);
	$GLOBALS['cat_subcat_description'] = $myts->makeTareaData4Edit($description);

	$form = new XoopsThemeForm(_MD_MODCAT, "op", xoops_getenv('PHP_SELF')."?op=$op");
	$form->setExtra('enctype="multipart/form-data"');
	$form->addElement(new XoopsFormText(_MD_TITLEC, "title", 50, 50, $title));	
	$form->addElement(new XoopsFormDhtmlTextArea(_MD_DESCRIPTIONC, 'cat_subcat_description', $description, 8, 8));

	$uploadurl=$xoopsModuleConfig['shot_path'];
	$uploadirectory=XOOPS_ROOT_PATH.'/'.$uploadurl.'/';
	$linkimg_array = XoopsLists::getImgListAsArray($uploadirectory);
	$imgtray = new XoopsFormElementTray(_MD_SHOTIMAGE,'');
	$imgtray->setDescription(sprintf(_MD_SHOTIMAGEDESC,$xoopsModuleConfig['max_shot_size'],$xoopsModuleConfig['max_shot_width'],$xoopsModuleConfig['max_shot_height']));
		$imageselect= new XoopsFormSelect(sprintf(_MD_SHOTMUST,$uploadirectory).'<br />','imgurl',$imgurl);
//		$imageselect->addOption(' ','------');
		$imageselect->addOption('','------');
		foreach($linkimg_array as $image)
			$imageselect->addOption("$image",$image);
		$imageselect->setExtra("onchange='showImgSelected(\"image_imgurl\", \"imgurl\", \"".$uploadurl."\", \"\", \"".XOOPS_URL."\")'" );
	$imgtray->addElement($imageselect,false);
	$imgtray->addElement(new XoopsFormLabel('',"<br /><img src='".XOOPS_URL."/".$uploadurl."/".$imgurl."' name='image_imgurl' id='image_imgurl' alt='' /><br />"));
		$fileseltray= new XoopsFormElementTray('<hr />'._AM_TOPIC_PICTURE.'<br />','');
		//$fileseltray->addElement(new XoopsFormFile(_AM_TOPIC_PICTURE , 'attachedfile', news_getmoduleoption('maxuploadsize')), false);
		$fileseltray->addElement(new XoopsFormFile('', 'attachedfile', $xoopsModuleConfig['max_shot_size']), false);
		$fileseltray->addElement(new XoopsFormLabel(sprintf('<br />'._AM_UPLOAD_WARNING.'<br />',$uploadirectory)), false);
	$imgtray->addElement($fileseltray);
	$form->addElement($imgtray);

	$form->addElement(new XoopsFormRadioYN(_MD_SHOW_MAP, 'show_map', $show_map));	
	ob_start() ;
	$mytree->makeMySelBox('title', 'title', $pid, 1, 'pid');
	$cat_selbox = ob_get_contents() ;
	ob_end_clean() ;
	$form->addElement(new XoopsFormLabel(_MD_PARENT,$cat_selbox));

	$form->addElement(new XoopsFormHidden('pid', $pid),false);
	$form->addElement(new XoopsFormHidden('cid', $cid),false);
	$form->addElement(new XoopsFormHidden('op', 'Category_mod_S'),false);

	$button_tray = new XoopsFormElementTray('', '');
		$modify_btn = new XoopsFormButton('', 'post', _MD_SAVE, 'submit');
		$modify_btn->setExtra('accesskey="m"');
	$button_tray -> addElement($modify_btn);
		$delete_btn = new XoopsFormButton('', 'delete', _MD_DELETE, 'button');
		$delete_btn -> setExtra("onClick=\"location='index.php?pid=$pid&amp;cid=$cid&amp;op=Category_del'\"");
	$button_tray -> addElement($delete_btn);
		$cancel_btn = new XoopsFormButton('', 'cancel', _MD_CANCEL, 'button');
		$cancel_btn -> setExtra("onclick=\"javascript:history.go(-1)\"");
	$button_tray -> addElement($cancel_btn);
	$form -> addElement($button_tray);

	$form->display();

	xoops_cp_footer();
	}



// DA MODIFICARE ... MODIFICA DESCRIPTION
function Category_mod_S()
	{
	global $xoopsDB, $_POST, $myts, $eh;
	$cid =  $_POST['cid'];
	$pid =  $_POST['pid'];
	$title =  $myts->makeTboxData4Save($_POST['title']);
	if (empty($title))
		{
		redirect_header("index.php", 2, _MD_ERRORTITLE);
		}
	$imgurl = '';
	if (($_POST["imgurl"]) || ($_POST["imgurl"]!=""))
		$imgurl = $myts->makeTboxData4Save($_POST["imgurl"]);
	$show_map = $myts->makeTboxData4Save($_POST["show_map"]);
	$sql = "UPDATE ".$xoopsDB->prefix("addresses_cat");
	$sql.= " SET pid=$pid, title='$title', imgurl='$imgurl', show_map='$show_map'";
	$sql.= " WHERE cid=$cid"; 
	$xoopsDB->query($sql) or $eh->show("0013");
	$description = $myts->makeTareaData4Save($_POST["cat_subcat_description"]);
	$sql = "UPDATE ".$xoopsDB->prefix("addresses_cat_text");
	$sql.= " SET description='$description'";
	$sql.= " WHERE cid=$cid"; 
	$xoopsDB->query($sql) or $eh->show("0013");
	redirect_header("index.php",1,_MD_DBUPDATED);
}



// DA MODIFICARE ... ELIMINA DESCRIPTION
function Category_del()
	{
	global $xoopsDB, $_GET, $_POST, $eh, $mytree, $xoopsModule;
	$cid =  isset($_POST['cid']) ? intval($_POST['cid']) : intval($_GET['cid']);
	$ok =  isset($_POST['ok']) ? intval($_POST['ok']) : 0;
	if ( $ok == 1 )
		{
		//get all subcategories under the specified category
		$arr=$mytree->getAllChildId($cid);
		$dcount=count($arr);
		for ( $i=0;$i<$dcount;$i++ )
			{
			//get all addresses in each subcategory
			$sql = "SELECT aid FROM ".$xoopsDB->prefix("addresses_addresses")." WHERE cid=".$arr[$i]."";
			$result=$xoopsDB->query($sql) or $eh->show("0013");
			//now for each link, delete the text data and vote ata associated with the link
			while ( list($aid)=$xoopsDB->fetchRow($result) )
				{
				$sql = sprintf("DELETE FROM %s WHERE aid = %u", $xoopsDB->prefix("addresses_addresses_text"), $aid);
				$xoopsDB->query($sql) or $eh->show("0013");
				$sql = sprintf("DELETE FROM %s WHERE aid = %u", $xoopsDB->prefix("addresses_votedata"), $aid);
				$xoopsDB->query($sql) or $eh->show("0013");
				$sql = sprintf("DELETE FROM %s WHERE aid = %u", $xoopsDB->prefix("addresses_addresses"), $aid);
				$xoopsDB->query($sql) or $eh->show("0013");
				xoops_comment_delete($xoopsModule->getVar('mid'), $aid);
				xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'address', $aid);
				}
			xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'category', $arr[$i]);

			//all addresses for each subcategory are deleted
			//delete the subcategory data
			$sql = sprintf("DELETE FROM %s WHERE cid = %u", $xoopsDB->prefix("addresses_cat"), $arr[$i]);
			$xoopsDB->query($sql) or $eh->show("0013");

			//delete the subcategory text/description
			$sql = sprintf("DELETE FROM %s WHERE cid = %u", $xoopsDB->prefix("addresses_cat_text"), $arr[$i]);
			$xoopsDB->query($sql) or $eh->show("0013");
			}
		//all subcategory and associated data are deleted, now delete category data and its associated data
		$sql = "SELECT aid FROM ".$xoopsDB->prefix("addresses_addresses")." WHERE cid=".$cid."";
		$result=$xoopsDB->query($sql) or $eh->show("0013");
		while ( list($aid)=$xoopsDB->fetchRow($result) )
			{
			$sql = sprintf("DELETE FROM %s WHERE aid = %u", $xoopsDB->prefix("addresses_addresses"), $aid);
			$xoopsDB->query($sql) or $eh->show("0013");
			$sql = sprintf("DELETE FROM %s WHERE aid = %u", $xoopsDB->prefix("addresses_addresses_text"), $aid);
			$xoopsDB->query($sql) or $eh->show("0013");
			$sql = sprintf("DELETE FROM %s WHERE aid = %u", $xoopsDB->prefix("addresses_votedata"), $aid);
			$xoopsDB->query($sql) or $eh->show("0013");
			// delete comments
			xoops_comment_delete($xoopsModule->getVar('mid'), $aid);
			// delete notifications
			xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'address', $aid);
			}
		// delete the category
		$sql = sprintf("DELETE FROM %s WHERE cid = %u", $xoopsDB->prefix("addresses_cat"), $cid);
		$xoopsDB->query($sql) or $eh->show("0013");

		// delete the category text/description
		$sql = sprintf("DELETE FROM %s WHERE cid = %u", $xoopsDB->prefix("addresses_cat_text"), $cid);
		$xoopsDB->query($sql) or $eh->show("0013");					
		xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'category', $cid);
		redirect_header("index.php",1,_MD_CATDELETED);
		exit();
		}
	else
		{
		xoops_cp_header();
		xoops_confirm(array('op' => 'Category_del', 'cid' => $cid, 'ok' => 1), 'index.php', _MD_WARNING);
		xoops_cp_footer();
		}
	}




function NewAddress_del() //SHINE need to change later
	{
	global $xoopsDB, $_GET, $eh, $xoopsModule;
	$sql = sprintf("DELETE FROM %s WHERE aid = %u", $xoopsDB->prefix("addresses_addresses"), $_GET['aid']);
	$xoopsDB->queryF($sql) or $eh->show("0013");
	$sql = sprintf("DELETE FROM %s WHERE aid = %u", $xoopsDB->prefix("addresses_addresses_text"), $_GET['aid']);
	$xoopsDB->queryF($sql) or $eh->show("0013");
	// delete comments
	xoops_comment_delete($xoopsModule->getVar('mid'), $_GET['aid']);
	// delete notifications
	xoops_notification_deletebyitem($xoopsModule->getVar('mid'), 'address', $_GET['aid']);
	redirect_header("index.php?op=NewAddress_list",1,_MD_LINKDELETED);
	}



// add a new category /sub-category
function Category_add()
	{
	global $xoopsDB, $myts, $eh, $xoopsModuleConfig;
	$pid = $_POST["cid"];
	$title = $myts->makeTboxData4Save($_POST["title"]);
	if (empty($title))
		{
		redirect_header("index.php",2,_MD_ERRORTITLE);
		exit();
		}
	$imgurl = "";
	if (isset($_POST["imgurl"]))
		{
		if (($_POST["imgurl"]) || ($_POST["imgurl"]!=""))
			{
			//$imgurl = $myts->formatURL($_POST["imgurl"]);
			//$imgurl = urlencode($imgurl);
			$imgurl = $myts->makeTboxData4Save($_POST["imgurl"]);
			}
		}
	//$imgurl = $myts->makeTboxData4Save($_POST["imgurl"]);
	if(isset($_POST['xoops_upload_file']))
		{
		$fldname = $_FILES[$_POST['xoops_upload_file'][0]];
		$fldname = (get_magic_quotes_gpc())?stripslashes($fldname['name']):$fldname['name']; // ??????????
		if ($fldname != '')
			{
			//load a new image and use it - start
			include_once XOOPS_ROOT_PATH.'/class/uploader.php';

			$upload_directory = XOOPS_ROOT_PATH.'/'.$xoopsModuleConfig['shot_path']; // migliorare il path... metterlo sotto xoops/upload
			$allowed_types = array('image/gif','image/jpeg','image/pjpeg','image/x-png','image/png','image/bmp');
			$uploader = new XoopsMediaUploader($upload_directory, $allowed_types, $xoopsModuleConfig['max_shot_size'], $xoopsModuleConfig['max_shot_width'], $xoopsModuleConfig['max_shot_height']);
			$uploader->setPrefix('img');
			$err = array();
	
			if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
				$uploader->setTargetFileName($fldname);
				if (!$uploader->upload()) $err[] = $uploader->getErrors();
				else $imgurl= $uploader->getSavedFileName();
				}
			else
				{
				$err[] = sprintf(_FAILFETCHIMG, $fldname);
				$err = array_merge($err, $uploader->getErrors(false));
				}
			if (count($err) > 0) {
				xoops_cp_header();
				xoops_error($err);
				xoops_cp_footer();
				exit();
				}
			//load a new image and use it - end
			}
		}





	$show_map = $myts->makeTboxData4Save($_POST["show_map"]);
	$newid = $xoopsDB->genId($xoopsDB->prefix("addresses_cat")."_cid_seq");
	$sql = sprintf("INSERT INTO %s (cid, pid, title, imgurl, show_map) VALUES (%u, %u, '%s', '%s', %u)", $xoopsDB->prefix("addresses_cat"), $newid, $pid, $title, $imgurl, $show_map);

	$xoopsDB->query($sql) or $eh->show("0013");

	$description = "";
	if (isset($_POST["cat_description"]))
		{$description = $myts->makeTareaData4Save($_POST["cat_description"]);}
	if (isset($_POST["subcat_description"]))
		{$description = $myts->makeTareaData4Save($_POST["subcat_description"]);}
	if ($newid == 0)
		{
		$newid = $xoopsDB->getInsertId();
		}
	$sql = sprintf("INSERT INTO %s (cid, description) VALUES (%u, '%s')", $xoopsDB->prefix("addresses_cat_text"), $newid, $description);
	$xoopsDB->query($sql) or $eh->show("0013");

	global $xoopsModule;
	$tags = array();
	$tags['CATEGORY_NAME'] = $title;
	$tags['CATEGORY_URL'] = XOOPS_URL .'/modules/'.$xoopsModule->getVar('dirname').'/cat_view.php?cid='.$newid;
	$notification_handler =& xoops_gethandler('notification');
	$notification_handler->triggerEvent('global', 0, 'new_category', $tags);
	redirect_header("index.php?op=Menu_Categories",1,_MD_NEWCATADDED);
	}




function Address_add() //SHINE need to change later
	{
	global $xoopsConfig, $xoopsDB, $myts, $xoopsUser, $xoopsModule, $eh, $xoopsModuleConfig;

	$url ="";
	if (isset($_POST["url"]))
		{
		if (($_POST["url"]) || ($_POST["url"]!=""))
			{
			//$url = $myts->formatURL($_POST["url"]);
			//$url = urlencode($url);
			$url = $myts->makeTboxData4Save($_POST["url"]);
			}
		}

	$logourl = $myts->makeTboxData4Save($_POST["logourl"]);
	if(isset($_POST['xoops_upload_file']))
		{
		$fldname = $_FILES[$_POST['xoops_upload_file'][0]];
		$fldname = (get_magic_quotes_gpc())?stripslashes($fldname['name']):$fldname['name']; // ??????????
		if ($fldname != '')
			{
			//load a new image and use it - start
			include_once XOOPS_ROOT_PATH.'/class/uploader.php';

			$upload_directory = XOOPS_ROOT_PATH.'/'.$xoopsModuleConfig['shot_path']; // migliorare il path... metterlo sotto xoops/upload
			$allowed_types = array('image/gif','image/jpeg','image/pjpeg','image/x-png','image/png','image/bmp');
			$uploader = new XoopsMediaUploader($upload_directory, $allowed_types, $xoopsModuleConfig['max_shot_size'], $xoopsModuleConfig['max_shot_width'], $xoopsModuleConfig['max_shot_height']);
			$uploader->setPrefix('img');
			$err = array();
	
			if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
				$uploader->setTargetFileName($fldname);
				if (!$uploader->upload()) $err[] = $uploader->getErrors();
				else $logourl= $uploader->getSavedFileName();
				}
			else
				{
				$err[] = sprintf(_FAILFETCHIMG, $fldname);
				$err = array_merge($err, $uploader->getErrors(false));
				}
			if (count($err) > 0) {
				xoops_cp_header();
				xoops_error($err);
				xoops_cp_footer();
				exit();
				}
			//load a new image and use it - end
			}
		}
	$title       = $myts->makeTboxData4Save($_POST["title"]);
	$address     = $myts->makeTboxData4Save($_POST["input_address"]);
	$zip         = $myts->makeTboxData4Save($_POST["input_zip"]);
	$city        = $myts->makeTboxData4Save($_POST["input_city"]);
	$country     = $myts->makeTboxData4Save($_POST["input_country"]);
	$lon         = $myts->makeTboxData4Save($_POST["lon"]);
	$lat         = $myts->makeTboxData4Save($_POST["lat"]);
	$zoom        = $myts->makeTboxData4Save($_POST["zoom"]);
	$phone       = $myts->makeTboxData4Save($_POST["phone"]);
	$mobile      = $myts->makeTboxData4Save($_POST["mobile"]);
	$fax         = $myts->makeTboxData4Save($_POST["fax"]);
	$contemail   = $myts->makeTboxData4Save($_POST["contemail"]);
	$opentime    = $myts->makeTareaData4Save($_POST["opentime"]);
	$description = $myts->makeTareaData4Save($_POST["description"]);
	$submitter   = $xoopsUser->uid();
	$result      = $xoopsDB->query("SELECT count(*) FROM ".$xoopsDB->prefix("addresses_addresses")." WHERE title='$title'"); //Original url='$url'
	list($numrows) = $xoopsDB->fetchRow($result);
	$errormsg = "";
	$error = 0;
	if ( $numrows > 0 )
		{
		$errormsg .= "<h4 style='color: #ff0000'>";
		$errormsg .= _MD_ERROREXIST."</h4>";
		$error = 1;
		}
	// Check if Title exist
	if ( $title == "" )
		{
		$errormsg .= "<h4 style='color: #ff0000'>";
		$errormsg .= _MD_ERRORTITLE."</h4>";
		$error =1;
		}

	// Check if Description exist
	// Disabled, cause admin should not be obligated to enter description
	//if ( $description == "" )
	//	{
	//	$errormsg .= "<h4 style='color: #ff0000'>";
	//	$errormsg .= _MD_ERRORDESC."</h4>";
	//	$error =1;
	//	}
	if ( $error == 1 )
		{
		xoops_cp_header();
		echo $errormsg;
		xoops_cp_footer();
		exit();
		}
	if (!empty($_POST['cid']))
		{$cid = $_POST['cid'];}
	else
		{$cid = 0;}

	// SHINE: Did put own fields and gave them %s which correspondent with earlier lines 
	$newid = $xoopsDB->genId($xoopsDB->prefix("addresses_addresses")."_aid_seq");

	$sql = "INSERT INTO %s (aid, cid, title, address, zip,  city, country, lon, lat, zoom, phone, mobile, fax,  contemail, opentime, url,  logourl, submitter, status, date, hits, rating, votes, comments)";
	$sql.= " VALUES        (%u,  %u,  '%s',  '%s',   '%s', '%s', '%s',    %f,  %f,  %u,   '%s',  '%s',   '%s', '%s',      '%s',     '%s', '%s',    %u,        %u,     %u,   %u,   %u,     %u,    %u)"; 
	$sql = sprintf($sql, $xoopsDB->prefix("addresses_addresses"), $newid, $cid, $title, $address, $zip, $city, $country, $lon, $lat, $zoom, $phone, $mobile, $fax, $contemail, $opentime, $url, $logourl, $submitter, 1, time(), 0, 0, 0, 0);
	$xoopsDB->query($sql) or $eh->show("0013");
	if ( $newid == 0 )
		{
		$newid = $xoopsDB->getInsertId();
		}
	$sql = sprintf("INSERT INTO %s (aid, description) VALUES (%u, '%s')", $xoopsDB->prefix("addresses_addresses_text"), $newid, $description);
	$xoopsDB->query($sql) or $eh->show("0013");
	$tags = array(); 
	$tags['LINK_NAME'] = $title;
	$tags['LINK_URL'] = XOOPS_URL . '/modules/'. $xoopsModule->getVar('dirname') . '/address_single.php?cid=' . $cid . '&amp;aid=' . $newid;
	$sql = "SELECT title FROM " . $xoopsDB->prefix("addresses_cat") . " WHERE cid=" . $cid;
	$result = $xoopsDB->query($sql);
	$row = $xoopsDB->fetchArray($result);
	$tags['CATEGORY_NAME'] = $row['title'];
	$tags['CATEGORY_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/cat_view.php?cid=' . $cid;
	$notification_handler =& xoops_gethandler('notification');
	$notification_handler->triggerEvent('global', 0, 'new_address', $tags);
	$notification_handler->triggerEvent('category', $cid, 'new_address', $tags);
	redirect_header("index.php?op=Menu_Addresses",1,_MD_NEWLINKADDED);
	}




function NewAddress_approve()
	{
	global $xoopsConfig, $xoopsDB, $_POST, $myts, $eh, $xoopsModuleConfig;
	$aid = $_POST['aid'];
	$title = $_POST['title'];
	$cid = $_POST['cid'];
	if ( empty($cid) )
		{
		$cid = 0;
		}
	$description = $_POST['description'];
	if (($_POST["url"]) || ($_POST["url"]!=""))
		{
		//$url = $myts->formatURL($_POST["url"]);
		//$url = urlencode($url);
		$url = $myts->makeTboxData4Save($_POST["url"]);
		}

	$logourl = $myts->makeTboxData4Save($_POST["logourl"]);
	if(isset($_POST['xoops_upload_file']))
		{
		$fldname = $_FILES[$_POST['xoops_upload_file'][0]];
		$fldname = (get_magic_quotes_gpc())?stripslashes($fldname['name']):$fldname['name']; // ??????????
		if ($fldname != '')
			{
			//load a new image and use it - start
			include_once XOOPS_ROOT_PATH.'/class/uploader.php';

			$upload_directory = XOOPS_ROOT_PATH.'/'.$xoopsModuleConfig['shot_path']; // migliorare il path... metterlo sotto xoops/upload
			$allowed_types = array('image/gif','image/jpeg','image/pjpeg','image/x-png','image/png','image/bmp');
			$uploader = new XoopsMediaUploader($upload_directory, $allowed_types, $xoopsModuleConfig['max_shot_size'], $xoopsModuleConfig['max_shot_width'], $xoopsModuleConfig['max_shot_height']);
			$uploader->setPrefix('img');
			$err = array();
	
			if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
				$uploader->setTargetFileName($fldname);
				if (!$uploader->upload()) $err[] = $uploader->getErrors();
				else $logourl= $uploader->getSavedFileName();
				}
			else
				{
				$err[] = sprintf(_FAILFETCHIMG, $fldname);
				$err = array_merge($err, $uploader->getErrors(false));
				}
			if (count($err) > 0) {
				xoops_cp_header();
				xoops_error($err);
				xoops_cp_footer();
				exit();
				}
			//load a new image and use it - end
			}
		}
	$title       = $myts->makeTboxData4Save($title);
	$address     = $myts->makeTboxData4Save($_POST["input_address".$aid]);
	$zip         = $myts->makeTboxData4Save($_POST["input_zip".$aid]);
	$city        = $myts->makeTboxData4Save($_POST["input_city".$aid]);
	$country     = $myts->makeTboxData4Save($_POST["input_country".$aid]);
	$lon         = $myts->makeTboxData4Save($_POST["lon".$aid]);
	$lat         = $myts->makeTboxData4Save($_POST["lat".$aid]);
	$zoom        = $myts->makeTboxData4Save($_POST["zoom".$aid]);
	$phone       = $myts->makeTboxData4Save($_POST["phone"]);
	$mobile      = $myts->makeTboxData4Save($_POST["mobile"]);
	$fax         = $myts->makeTboxData4Save($_POST["fax"]);
	$contemail   = $myts->makeTboxData4Save($_POST["contemail"]);
	$url         = $myts->makeTboxData4Save($_POST["url"]);
	$opentime    = $myts->makeTareaData4Save($_POST["opentime"]);
	$description = $myts->makeTareaData4Save($description);

	$query = "UPDATE ".$xoopsDB->prefix("addresses_addresses")." SET cid='$cid', title='$title', address='$address', zip='$zip', city='$city', country='$country', lon='$lon', lat='$lat', zoom='$zoom', phone='$phone', mobile='$mobile', fax='$fax', contemail='$contemail', opentime='$opentime', url='$url', logourl='$logourl', status=1, date=".time()."";
	$query.= " WHERE aid=".$aid."";
	$xoopsDB->query($query) or $eh->show("0013");
	$query = "UPDATE ".$xoopsDB->prefix("addresses_addresses_text")." SET description='$description'";
	$query.= " WHERE aid=".$aid."";
	$xoopsDB->query($query) or $eh->show("0013");

	global $xoopsModule;
	$tags=array(); 
	$tags['LINK_NAME'] = $title;
	$tags['LINK_URL'] = XOOPS_URL . '/modules/'. $xoopsModule->getVar('dirname') . '/address_single.php?cid=' . $cid . '&amp;aid=' . $aid;
	$sql = "SELECT title";
	$sql.= " FROM ".$xoopsDB->prefix("addresses_cat")."";
	$sql.= " WHERE cid=" . $cid;
	$result = $xoopsDB->query($sql);
	$row = $xoopsDB->fetchArray($result);
	$tags['CATEGORY_NAME'] = $row['title'];
	$tags['CATEGORY_URL'] = XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/cat_view.php?cid='.$cid;
	$notification_handler =& xoops_gethandler('notification');
	$notification_handler->triggerEvent('global', 0, 'new_address', $tags);
	$notification_handler->triggerEvent('category', $cid, 'new_address', $tags);
	$notification_handler->triggerEvent('address', $aid, 'approve', $tags);
	redirect_header("index.php?op=NewAddress_list",1,_MD_NEWLINKADDED);
	}
?>
