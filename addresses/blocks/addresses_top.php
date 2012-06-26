<?php
/******************************************************************************
 * Function: b_addresses_top_show
 * Input   : $options[0] = date for the most recent addresses
 *                    hits for the most popular addresses
 *           $block['content'] = The optional above content
 *           $options[1]   = How many reviews are displayes
 * Output  : Returns the desired most recent or most popular addresses
 ******************************************************************************/

//Shine: Is de function toekenning wel goed? Line 36 en 62
function b_addresses_top_show($options)
	{
	global $xoopsDB;
	$block = array();
	$myts =& MyTextSanitizer::getInstance();
	$result = $xoopsDB->query("SELECT aid, cid, title, date, hits FROM ".$xoopsDB->prefix("addresses_addresses")." WHERE status>0 ORDER BY ".$options[0]." DESC",$options[1],0);
	while($myrow = $xoopsDB->fetchArray($result))
		{
		$link = array();
		$title = $myts->makeTboxData4Show($myrow["title"]);
		if ( !XOOPS_USE_MULTIBYTES )
			{
			if (strlen($myrow['title']) >= $options[2])
				{
				$title = $myts->makeTboxData4Show(substr($myrow['title'],0,($options[2] -1)))."...";
				}
			}
		$link['id'] = $myrow['aid'];
		$link['cid'] = $myrow['cid'];
		$link['title'] = $title;
		if($options[0] == "date")
			{
			$link['date'] = formatTimestamp($myrow['date'],'s');
			}
		elseif($options[0] == "hits")
			{
			$link['hits'] = $myrow['hits'];
			}
		$block['addresses'][] = $link;
		}
	return $block;
	}


function b_addresses_top_edit($options)
	{
	$form = ""._MB_MYADDRESSES_DISP."&nbsp;";
	$form .= "<input type='hidden' name='options[]' value='";
	if($options[0] == "date")
		{
		$form .= "date'";
		}
	else
		{
		$form .= "hits'";
		}
	$form .= " />";
	$form .= "<input type='text' name='options[]' value='".$options[1]."' />&nbsp;"._MB_MYaddresses_addresses."";
	$form .= "&nbsp;<br>"._MB_MYADDRESSES_CHARS."&nbsp;<input type='text' name='options[]' value='".$options[2]."' />&nbsp;"._MB_MYADDRESSES_LENGTH."";

	return $form;
	}
?>
