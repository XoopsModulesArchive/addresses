<?php
include_once "header.php";
include_once XOOPS_ROOT_PATH . "/class/xoopstree.php";
global $xoopsModuleConfig;

$myts =& MyTextSanitizer::getInstance();// MyTextSanitizer object
$mytree = new XoopsTree($xoopsDB->prefix("addresses_cat"),"cid","pid");

if (!isset($aid)) {$aid = isset($_GET['aid']) ? $_GET['aid'] : '';}
if (!isset($cid)) {$cid = isset($_GET['cid']) ? $_GET['cid'] : '';}

if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
    include_once(XOOPS_ROOT_PATH . "/class/template.php");
    $xoopsTpl = new XoopsTpl();
    }

//get default values
$xoopsTpl->assign('api_key', $xoopsModuleConfig['api_key']);
$xoopsTpl->assign('default_lat', $xoopsModuleConfig['default_lat']);
$xoopsTpl->assign('default_lon', $xoopsModuleConfig['default_lon']);
$xoopsTpl->assign('default_zoom', $xoopsModuleConfig['default_zoom']);
$xoopsTpl->assign('default_address', $xoopsModuleConfig['default_address']);


if ($xoopsModuleConfig['useshots'] == 1)
	{
	$xoopsTpl->assign('shotwidth', $xoopsModuleConfig['shotwidth']);
	$xoopsTpl->assign('tablewidth', $xoopsModuleConfig['shotwidth'] + 10);
	$xoopsTpl->assign('show_screenshot', true);
	$xoopsTpl->assign('lang_noscreenshot', _MD_NOSHOTS);
}


$xoopsTpl->assign('lang_description', _MD_DESCRIPTIONC);
$xoopsTpl->assign('lang_address', _MD_ADDRESS);
$xoopsTpl->assign('lang_zip', _MD_ZIP);
$xoopsTpl->assign('lang_city', _MD_CITY);
$xoopsTpl->assign('lang_country', _MD_COUNTRY);
$xoopsTpl->assign('lang_phone', _MD_PHONE);
$xoopsTpl->assign('lang_fax', _MD_FAX);
$xoopsTpl->assign('lang_mobile', _MD_MOBILE);
$xoopsTpl->assign('lang_contemail', _MD_CONTEMAIL);
$xoopsTpl->assign('lang_opened', _MD_OPENED);
$xoopsTpl->assign('lang_viewmore', _MD_VIEWMORE);
$xoopsTpl->assign('lang_lastupdate', _MD_LASTUPDATEC);
$xoopsTpl->assign('lang_hits', _MD_HITSC);
$xoopsTpl->assign('lang_rating', _MD_RATINGC);
$xoopsTpl->assign('lang_ratethissite', _MD_RATETHISSITE);
$xoopsTpl->assign('lang_reportbroken', _MD_REPORTBROKEN);
$xoopsTpl->assign('lang_tellafriend', _MD_TELLAFRIEND);
$xoopsTpl->assign('lang_modify', _MD_MODIFY);
$xoopsTpl->assign('lang_category' , _MD_CATEGORYC);
$xoopsTpl->assign('lang_visit' , _MD_VISIT);
$xoopsTpl->assign('show_addresses', true);
$xoopsTpl->assign('lang_comments' , _COMMENTS);


if (!empty($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->mid()))
    $isadmin = true;
else
    $isadmin = false;

if ($cid!='')
    $fullcountresult=$xoopsDB->query("SELECT count(*) FROM " . $xoopsDB->prefix("addresses_addresses") . " WHERE cid=$cid and status>0");
if ($aid!='')
    $fullcountresult=$xoopsDB->query("SELECT count(*) FROM " . $xoopsDB->prefix("addresses_addresses") . " WHERE aid=$aid and status>0");


list($numrows) = $xoopsDB->fetchRow($fullcountresult);
$page_nav = '';
if($numrows>0)
    {
    $sql = "SELECT l.aid, l.cid, l.title, l.address, l.zip, l.city, l.country, l.lon, l.lat, l.zoom, l.phone, l.mobile, l.fax, l.contemail, l.opentime, l.url, l.logourl, l.status, l.date, l.hits, l.rating, l.votes, l.comments, t.description";
    $sql.= " FROM " . $xoopsDB->prefix("addresses_addresses") . " l, " . $xoopsDB->prefix("addresses_addresses_text") . " t";
if ($aid!='')
    $sql.= " WHERE l.aid=$aid AND t.aid=$aid AND status>0";
else
    $sql.= " WHERE cid=$cid AND l.aid=t.aid AND status>0";

    $result=$xoopsDB->query($sql);

    while(list($aid, $cid, $ltitle, $address, $zip, $city, $country, $lon, $lat, $zoom, $phone, $mobile, $fax, $contemail, $opentime, $url, $logourl, $status, $time, $hits, $rating, $votes, $comments, $description) = $xoopsDB->fetchRow($result))
        {
        if ($isadmin)
            {
            $adminlink = '<a href="' . XOOPS_URL . '/modules/addresses/admin/index.php?op=Address_mod&amp;aid=' . $aid . '">';
            $adminlink.= '<img src="' . XOOPS_URL . '/modules/addresses/images/editicon.gif" border="0" alt="' . _MD_EDITTHISLINK . '" />';
            $adminlink.= '</a>';
            }
		else
			$adminlink = '';
		if ($votes == 1)
			$votestring = _MD_ONEVOTE;
		else
			$votestring = sprintf(_MD_NUMVOTES,$votes);

		$path = $mytree->getPathFromId($cid, "title");
		$path = substr($path, 1);
		$path = str_replace("/"," <img src='" . XOOPS_URL . "/modules/addresses/images/arrow.gif' board='0' alt=''> ",$path);
		$new = newlinkgraphic($time, $status);
		$pop = popgraphic($hits);
		//JE moet hieronder nog aanpassen ivm tonen...
if ($logourl!='') $logourl = XOOPS_URL . '/' . $xoopsModuleConfig['shot_path'] . '/' . $logourl;

        $xoopsTpl->append('addresses', array(
            'id'           => $aid,
            'cid'          => $cid,
            'rating'       => number_format($rating, 2),
            'title'        => $myts->makeTboxData4Show($ltitle),
            'new'          => $new,
            'pop'          => $pop,
            'category'     => $path,
            'logourl'      => $myts->makeTboxData4Show($logourl),
            'address'      => $myts->makeTboxData4Show($address),
            'zip'          => $myts->makeTboxData4Show($zip),
            'city'         => $myts->makeTboxData4Show($city),
            'country'      => $myts->makeTboxData4Show($country),
            'lon'          => $lon,
            'lat'          => $lat,
            'zoom'         => $zoom,
            'phone'        => $myts->makeTboxData4Show($phone),
            'fax'          => $myts->makeTboxData4Show($fax),
            'mobile'       => $myts->makeTboxData4Show($mobile),
            'contemail'    => $myts->makeTboxData4Show($contemail),
            'opentime'     => $myts->makeTboxData4Show($opentime),
            'updated'      => formatTimestamp($time,"m"),
            'description'  => $myts->makeTareaData4Show($description,0),
            'adminlink'    => $adminlink, 'hits' => $hits,
            'comments'     => $comments,
            'votes'        => $votestring,
            'mail_subject' => rawurlencode(sprintf(_MD_INTRESTLINK,$xoopsConfig['sitename'])),
            'mail_body'    => rawurlencode(sprintf(_MD_INTLINKFOUND,$xoopsConfig['sitename']) . ':  ' . XOOPS_URL . '/modules/addresses/address_single.php?cid=' . $cid . '&amp;aid=' . $aid)
            ));
        }
    }
    $xoopsTpl->display( 'db:addresses_google_maps.html' );
?>
