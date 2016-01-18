<?php
include "header.php";
include_once XOOPS_ROOT_PATH."/class/module.errorhandler.php";
$myts =& MyTextSanitizer::getInstance(); // MyTextSanitizer object

if (!empty($_POST['submit']))
	{
	$eh = new ErrorHandler; //ErrorHandler object
	if(empty($xoopsUser))
		{
		$ratinguser = 0;
		}
	else
		{
		$ratinguser = $xoopsUser->getVar('uid');
		}

	//Make sure only 1 anonymous from an IP in a single day.
	$anonwaitdays = 1;
	$ip = getenv("REMOTE_ADDR");
	$aid = intval($_POST['aid']);
	$cid = intval($_POST['cid']);
	$rating = intval($_POST['rating']);

	// Check if Rating is Null
	if ($rating=="--")
		{
		redirect_header("address_rate.php?cid=".$cid."&amp;aid=".$aid."",4,_MD_NORATING);
		exit();
		}

	// Check if Link POSTER is voting (UNLESS Anonymous users allowed to post)
	if ($ratinguser != 0)
		{
		$result=$xoopsDB->query("select submitter from ".$xoopsDB->prefix("addresses_addresses")." where aid=$aid");
		while(list($ratinguserDB) = $xoopsDB->fetchRow($result))
			{
			if ($ratinguserDB == $ratinguser)
				{
				redirect_header("index.php",4,_MD_CANTVOTEOWN);
				exit();
				}
			}

		// Check if REG user is trying to vote twice.
		$result=$xoopsDB->query("select ratinguser from ".$xoopsDB->prefix("addresses_votedata")." where aid=$aid");
		while(list($ratinguserDB) = $xoopsDB->fetchRow($result))
			{
			if ($ratinguserDB == $ratinguser)
				{
				redirect_header("index.php",4,_MD_VOTEONCE2);
				exit();
				}
			}

		}
	else
		{

		// Check if ANONYMOUS user is trying to vote more than once per day.
		$yesterday = (time()-(86400 * $anonwaitdays));
		$result=$xoopsDB->query("select count(*) FROM ".$xoopsDB->prefix("addresses_votedata")." WHERE aid=$aid AND ratinguser=0 AND ratinghostname = '$ip' AND ratingtimestamp > $yesterday");
		list($anonvotecount) = $xoopsDB->fetchRow($result);
		if ($anonvotecount > 0)
			{
			redirect_header("index.php",4,_MD_VOTEONCE2);
			exit();
			}
		}
	if($rating > 10)
		{
		$rating = 10;
		}

	//All is well.  Add to Line Item Rate to DB.
	$newid = $xoopsDB->genId($xoopsDB->prefix("addresses_votedata")."_ratingid_seq");
	$datetime = time();
	$sql = sprintf("INSERT INTO %s (ratingid, aid, ratinguser, rating, ratinghostname, ratingtimestamp) VALUES (%u, %u, %u, %u, '%s', %u)", $xoopsDB->prefix("addresses_votedata"), $newid, $aid, $ratinguser, $rating, $ip, $datetime);
	$xoopsDB->query($sql) or $eh->show("0013");

	//All is well.  Calculate Score & Add to Summary (for quick retrieval & sorting) to DB.
	updaterating($aid);
	$ratemessage = _MD_VOTEAPPRE."<br />".sprintf(_MD_THANKURATE,$xoopsConfig[sitename]);
	redirect_header("index.php",2,$ratemessage);
	exit();
	}
else
	{
	$xoopsOption['template_main'] = 'addresses_rateaddress.html';
	include XOOPS_ROOT_PATH."/header.php";
	$aid = intval($_GET['aid']);
	$cid = intval($_GET['cid']);
	$result=$xoopsDB->query("select title from ".$xoopsDB->prefix("addresses_addresses")." where aid=$aid");
	list($title) = $xoopsDB->fetchRow($result);
	$xoopsTpl->assign('address', array('id' => $aid, 'cid' => $cid, 'title' => $myts->htmlSpecialChars($title)));
	$xoopsTpl->assign('lang_voteonce', _MD_VOTEONCE);
	$xoopsTpl->assign('lang_ratingscale', _MD_RATINGSCALE);
	$xoopsTpl->assign('lang_beobjective', _MD_BEOBJECTIVE);
	$xoopsTpl->assign('lang_donotvote', _MD_DONOTVOTE);
	$xoopsTpl->assign('lang_rateit', _MD_RATEIT);
	$xoopsTpl->assign('lang_cancel', _CANCEL);
	include XOOPS_ROOT_PATH.'/footer.php';
	}
?>
