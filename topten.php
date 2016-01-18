<?php
include "header.php";
$myts =& MyTextSanitizer::getInstance(); // MyTextSanitizer object
include_once XOOPS_ROOT_PATH."/class/xoopstree.php";
$mytree = new XoopsTree($xoopsDB->prefix("addresses_cat"),"cid","pid");
$xoopsOption['template_main'] = 'addresses_topten.html';
include XOOPS_ROOT_PATH."/header.php";
//generates top 10 charts by rating and hits for each main category

if(isset($rate))
	{
	$sort = _MD_RATING;
	$sortDB = "rating";
	}
else
	{
	$sort = _MD_HITS;
	$sortDB = "hits";
	}
$xoopsTpl->assign('lang_sortby' ,$sort);
$xoopsTpl->assign('lang_rank' , _MD_RANK);
$xoopsTpl->assign('lang_title' , _MD_TITLE);
$xoopsTpl->assign('lang_category' , _MD_CATEGORY);
$xoopsTpl->assign('lang_hits' , _MD_HITS);
$xoopsTpl->assign('lang_rating' , _MD_RATING);
$xoopsTpl->assign('lang_vote' , _MD_VOTE);
$arr=array();
$result=$xoopsDB->query("select cid, title from ".$xoopsDB->prefix("addresses_cat")." where pid=0");
$e = 0;
$rankings = array();
while(list($cid, $ctitle)=$xoopsDB->fetchRow($result))
	{
	$rankings[$e]['title'] = sprintf(_MD_TOP10, $myts->htmlSpecialChars($ctitle));
	$query = "SELECT aid, cid, title, hits, rating, votes";
	$query.= " FROM ".$xoopsDB->prefix("addresses_addresses")."";
	$query.= " WHERE status>0 AND (cid=$cid";
	// get all child cat ids for a given cat id
	$arr=$mytree->getAllChildId($cid);
	$size = count($arr);
	for($i=0;$i<$size;$i++)
		{
		$query.= " OR cid=".$arr[$i]."";
		}
	$query.= ") ORDER BY ".$sortDB." DESC";
	$result2 = $xoopsDB->query($query,10,0);
	$rank = 1;
	while(list($aid,$lcid,$ltitle,$hits,$rating,$votes)=$xoopsDB->fetchRow($result2))
		{
		$catpath = $mytree->getPathFromId($lcid, "title");
		$catpath= substr($catpath, 1);
		$catpath = str_replace("/"," <span class='fg2'>&raquo;</span> ",$catpath);
		$rankings[$e]['addresses'][] = array(
			'id' => $aid,
			'cid' => $cid,
			'rank' => $rank,
			'title' => $myts->htmlSpecialChars($ltitle),
			'category' => $catpath,
			'hits' => $hits,
			'rating' => number_format($rating, 2),
			'votes' => $votes
			);
		$rank++;
		}
	$e++;
	}
$xoopsTpl->assign('rankings', $rankings);
include XOOPS_ROOT_PATH.'/footer.php';
?>
