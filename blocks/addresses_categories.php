<?php
/******************************************************************************
 * Function: b_addresses_categories_show
 * Input   : $options[0] = date for the most recent addresses
 *                    hits for the most popular addresses
 *           $block['content'] = The optional above content
 *           $options[1]   = How many reviews are displayes
 *           $options[2]   = Number of chars 
 * Output  : Returns the categories list
 ******************************************************************************/

function b_addresses_categories_show($options)
	{
	global $xoopsDB;
	$block = array();
	$myts =& MyTextSanitizer::getInstance();
//	$result = $xoopsDB->query("SELECT aid, cid, title, date, hits FROM ".$xoopsDB->prefix("addresses_addresses")." WHERE status>0 ORDER BY ".$options[0]." DESC",$options[1],0);
	$result = $xoopsDB->query("SELECT cid, title, imgurl FROM ".$xoopsDB->prefix("addresses_cat")." WHERE pid = 0 ORDER BY title") or exit("Error");
	while($myrow = $xoopsDB->fetchArray($result))
		{
		$category = array();
		$title = $myts->makeTboxData4Show($myrow["title"]);
		if ( !XOOPS_USE_MULTIBYTES )
			{
			if (strlen($myrow['title']) >= $options[0])
				{
				$title = $myts->makeTboxData4Show(substr($myrow['title'],0,($options[0] -1)))."...";
				}
			}
		$category['title'] = $title;
		$category['cid'] = $myrow['cid'];
		$imgurl = '';
		if ($myrow['imgurl'] && $myrow['imgurl'] != "http://")
			{
			$imgurl = $myts->makeTboxData4Edit($myrow['imgurl']);
			}
		$category['image'] = $imgurl;
		$block['categories'][] = $category;
		}
	return $block;
	}



function b_addresses_categories_edit($options)
	{
	$form = ""._MB_MYADDRESSES_CHARS."&nbsp;<input type='text' name='options[]' value='".$options[0]."' />&nbsp;"._MB_MYADDRESSES_LENGTH."";

	return $form;
	}
?>
