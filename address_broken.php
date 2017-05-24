<?php
include "header.php";
$myts = MyTextSanitizer::getInstance(); // MyTextSanitizer object

if (!empty($_POST['submit']))
	{
	if (empty($xoopsUser))
		{
		$sender = 0;
		}
	else
		{
		$sender = $xoopsUser->getVar('uid');
		}
	$aid = intval($_POST['aid']);
	$ip = getenv("REMOTE_ADDR");
	if ($sender != 0)
		{
		// Check if REG user is trying to report twice.
		$result=$xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix("addresses_broken")." WHERE aid=".$aid." AND sender=".$sender."");
		list($count)=$xoopsDB->fetchRow($result);
		if ($count > 0)
			{
			redirect_header("index.php",2,_MD_ALREADYREPORTED);
			exit();
			}
		}
	else
		{
		// Check if the sender is trying to vote more than once.
		$result=$xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix("addresses_broken")." WHERE aid=$aid AND ip = '$ip'");
		list($count)=$xoopsDB->fetchRow($result);
		if ($count > 0)
			{
			redirect_header("index.php",2,_MD_ALREADYREPORTED);
			exit();
			}
		}
	$newid = $xoopsDB->genId($xoopsDB->prefix("addresses_broken")."_reportid_seq");
	$sql = sprintf("INSERT INTO %s (reportid, aid, sender, ip) VALUES (%u, %u, %u, '%s')", $xoopsDB->prefix("addresses_broken"), $newid, $aid, $sender, $ip);
	$xoopsDB->query($sql) or exit();
	$tags = array();
	$tags['BROKENREPORTS_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/admin/index.php?op=BrokenAddress_list';
	$notification_handler =& xoops_gethandler('notification');
	$notification_handler->triggerEvent('global', 0, 'address_broken', $tags);
	redirect_header("index.php",2,_MD_THANKSFORINFO);
	exit();
	}
else
	{
	$xoopsOption['template_main'] = 'addresses_brokenaddress.html';
	include XOOPS_ROOT_PATH.'/header.php';
	$xoopsTpl->assign('lang_reportbroken', _MD_REPORTBROKEN);
	$xoopsTpl->assign('link_id', intval($_GET['aid']));
	$xoopsTpl->assign('lang_thanksforhelp', _MD_THANKSFORHELP);
	$xoopsTpl->assign('lang_forsecurity', _MD_FORSECURITY);
	$xoopsTpl->assign('lang_cancel', _MD_CANCEL);
	include_once XOOPS_ROOT_PATH.'/footer.php';
	}
?>
