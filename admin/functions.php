<?php
function adminmenu($currentoption = 0, $breadcrumb = '')
	{
	global $xoopsModule, $xoopsConfig;

	include XOOPS_ROOT_PATH.'/modules/addresses/config.php';
	if (file_exists(XOOPS_ROOT_PATH . '/modules/addresses/language/' . $xoopsConfig['language'] . '/modinfo.php')) {
		include_once XOOPS_ROOT_PATH. '/modules/addresses/language/' . $xoopsConfig['language'] . '/modinfo.php';
		}
	else {
		include_once XOOPS_ROOT_PATH . '/modules/addresses/language/english/modinfo.php';
		}

	$tblColors = array('','','','','','','','','');
	if($currentoption>=0) {
		$tblColors[$currentoption] = 'current';
		}

	/* Nice buttons styles */
	echo "<style type='text/css'>";
	echo "	#buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }";
	echo "	#buttonbar { float:left; width:100%; background: #e7e7e7 url('". XOOPS_URL."/modules/addresses/images/bg.png') repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px; }";
	echo "	#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }";
	echo "	#buttonbar li { display:inline; margin:0; padding:0; }";
	echo "	#buttonbar a { float:left; background:url('".XOOPS_URL."/modules/addresses/images/left_both.png') no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }";
	echo "	#buttonbar a span { float:left; display:block; background:url('".XOOPS_URL."/modules/addresses/images/right_both.png') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }";
	echo "	/* Commented Backslash Hack hides rule from IE5-Mac \*/";
	echo "	#buttonbar a span {float:none;}";
	echo "	/* End IE5-Mac hack */";
	echo "	#buttonbar a:hover span { color:#333; }";
	echo "	#buttonbar #current a { background-position:0 -150px; border-width:0; }";
	echo "	#buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }";
	echo "	#buttonbar a:hover { background-position:0% -150px; }";
	echo "	#buttonbar a:hover span { background-position:100% -150px; }";
	echo "</style>";

	echo "<div id='buttontop'>";
	echo "<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\"><tr>";
	echo "<td style=\"width: 60%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;\"><a class=\"nobutton\" href=\"".XOOPS_URL."/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=".$xoopsModule->getVar('mid')."\">" . _AM_NEWS_GENERALSET . "</a> | <a href=\"../index.php\">" . _AM_NEWS_GOTOMOD . "</a> | <a href=\"#\">" . _AM_NEWS_HELP . "</a></td>";
	echo "<td style=\"width: 40%; font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;\"><b>" . $xoopsModule->name() . "  " . _AM_NEWS_MODULEADMIN . "</b> " . $breadcrumb . "</td>";
	echo "</tr></table>";
	echo "</div>";

	echo "<div id='buttonbar'>";
	echo "<ul>";
	echo "	<li id='" . $tblColors[0] . "'><a href=\"index.php?op=Menu_Categories\"><span>"._MI_MYADDRESSES_ADMENU1 ."</span></a></li>\n";
	echo "	<li id='" . $tblColors[1] . "'><a href=\"index.php?op=Menu_Addresses\"><span>" . _MI_MYADDRESSES_ADMENU2 . "</span></a></li>\n";
	echo "	<li id='" . $tblColors[2] . "'><a href=\"index.php?op=NewAddress_list\"><span>" . _MI_MYADDRESSES_ADMENU3 . "</span></a></li>\n";
	echo "	<li id='" . $tblColors[3] . "'><a href=\"index.php?op=BrokenAddress_list\"><span>" . _MI_MYADDRESSES_ADMENU4 . "</span></a></li>\n";
	echo "	<li id='" . $tblColors[4] . "'><a href=\"index.php?op=ModReqAddress_list\"><span>" . _MI_MYADDRESSES_ADMENU5 . "</span></a></li>\n";
	echo "</ul>";
	echo "</div>";
	echo "<br /><br /><pre>&nbsp;</pre><pre>&nbsp;</pre>";
	}



function collapsableBar()
	{
	?>
	<script type="text/javascript">
	<!--
	
	function goto_URL(object)
		{
		window.location.href = object.options[object.selectedIndex].value;
		}

	function toggle(id)
		{
		if (document.getElementById) { obj = document.getElementById(id); }
		if (document.all) { obj = document.all[id]; }
		if (document.layers) { obj = document.layers[id]; }
		if (obj) {
			if (obj.style.display == "none") {
				obj.style.display = "";
				}
			else {
				obj.style.display = "none";
				}
			}
		return false;
		}

	var iconClose = new Image();
	iconClose.src = '../images/close12.gif';
	var iconOpen = new Image();
	iconOpen.src = '../images/open12.gif';

	function toggleIcon(iconName)
		{
		if ( document.images[iconName].src == window.iconOpen.src ) {
			document.images[iconName].src = window.iconClose.src;
			}
		else if ( document.images[iconName].src == window.iconClose.src ) {
			document.images[iconName].src = window.iconOpen.src;
			}
		return;
		}

	//-->
	</script>
	<?php
	}
?>
