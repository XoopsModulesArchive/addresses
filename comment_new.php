<?php
include '../../mainfile.php';
$com_itemid = isset($_GET['com_itemid']) ? intval($_GET['com_itemid']) : 0;
if ($com_itemid > 0)
	{
	// Get link title
	$sql = "SELECT title FROM " . $xoopsDB->prefix('addresses_addresses') . " WHERE aid=" . $com_itemid . "";
	$result = $xoopsDB->query($sql);
	$row = $xoopsDB->fetchArray($result);
	$com_replytitle = $row['title'];
	include XOOPS_ROOT_PATH.'/include/comment_new.php';
	}
?>
