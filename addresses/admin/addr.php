<?php   
/**
 * ****************************************************************************
 *  - A Project by Developers TEAM For Xoops - ( http://www.xoops.org )
 * ****************************************************************************
 *  ADDRESSES - MODULE FOR XOOPS
 *  Copyright (c) 2007 - 2012
 *  TXMod Xoops (Timgno) ( http://www.txmodxoops.org )
 *  Created by TDMCreate version 1.37
 *
 *  You may not change or alter any portion of this comment or credits
 *  of supporting developers from this source code or any supporting
 *  source code which is considered copyrighted (c) material of the
 *  original comment or credit authors.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  ---------------------------------------------------------------------------
 *  @copyright  TXMod Xoops (Timgno) ( http://www.txmodxoops.org )
 *  @license    GNU GPL see License
 *  @since      2.5.0
 *  @package    addresses
 *  @author     TXMod Xoops (Timgno) ( support@txmodxoops.org )
 *
 *  Version : 1.73 Tue 2012/06/26 13:30:40 : Timgno Exp $
 * ****************************************************************************
 */

include "admin_header.php";
//It recovered the value of argument op in URL$
$op = addresses_CleanVars($_REQUEST, 'op', 'list', 'string');
switch ($op) 
{   
    case "list": 
    default:               
		echo $adminMenu->addNavigation('addr.php');
		$adminMenu->addItemButton(_AM_ADDRESSES_NEWADDR, 'addr.php?op=new_addr', 'add');
		echo $adminMenu->renderButton();
		$criteria = new CriteriaCompo();
		$criteria->setSort("addr_id");
		$criteria->setOrder("ASC");
		$numrows = $addrHandler->getCount();
		$addr_arr = $addrHandler->getall($criteria);
	
		//Affichage du tableau
		if ($numrows>0) 
		{			
			echo "<table width='100%' cellspacing='1' class='outer'>
				<tr>
					<th class='center'>"._AM_ADDRESSES_ADDR_CID."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_TITLE."</th>						
					<th class='center'>"._AM_ADDRESSES_ADDR_URL."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_ADDRESS."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_ZIP."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_CITY."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_COUNTRY."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_LONG."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_LAT."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_ZOOM."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_PHONE."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_MOBILE."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_FAX."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_CONTEMAIL."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_OPENTIME."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_LOGOURL."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_SUBMITTER."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_STATUS."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_DATE."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_HITS."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_RATING."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_VOTES."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_COMMENTS."</th>						
					<th align='center' width='10%'>"._AM_ADDRESSES_FORMACTION."</th>
				</tr>";
					
			$class = "odd";
			
			foreach (array_keys($addr_arr) as $i) 
			{	
				echo "<tr class='".$class."'>";
				$class = ($class == "even") ? "odd" : "even";				
				$cat =& $catHandler->get($addr_arr[$i]->getVar("addr_cid"));
				$title_cat = $cat->getVar("cat_pid");	
				echo "<td class='center'>".$title_cat."</td>";
				echo "<td class='center'>".$addr_arr[$i]->getVar("addr_title")."</td>";	
				echo "<td class='center'>".$addr_arr[$i]->getVar("addr_description")."</td>";	
				echo "<td class='center'>".$addr_arr[$i]->getVar("addr_url")."</td>";	
				echo "<td class='center'>".$addr_arr[$i]->getVar("addr_address")."</td>";	
				echo "<td class='center'>".$addr_arr[$i]->getVar("addr_zip")."</td>";	
				echo "<td class='center'>".$addr_arr[$i]->getVar("addr_city")."</td>";	
				echo "<td class='center'>".$addr_arr[$i]->getVar("addr_country")."</td>";	
				echo "<td class='center'>".$addr_arr[$i]->getVar("addr_long")."</td>";	
				echo "<td class='center'>".$addr_arr[$i]->getVar("addr_lat")."</td>";	
				
				$verif_addr_zoom = ( $addr_arr[$i]->getVar("addr_zoom") == 1 ) ? _YES : _NO;
				echo "<td class='center'>".$verif_addr_zoom."</td>";	
				echo "<td class='center'>".$addr_arr[$i]->getVar("addr_phone")."</td>";	
				echo "<td class='center'>".$addr_arr[$i]->getVar("addr_mobile")."</td>";	
				echo "<td class='center'>".$addr_arr[$i]->getVar("addr_fax")."</td>";	
				echo "<td class='center'>".$addr_arr[$i]->getVar("addr_contemail")."</td>";	
				echo "<td class='center'>".$addr_arr[$i]->getVar("addr_opentime")."</td>";	
				echo "<td class='center'>".$addr_arr[$i]->getVar("addr_logourl")."</td>";	
				echo "<td class='center'>".XoopsUser::getUnameFromId($addr_arr[$i]->getVar("addr_submitter"),"S")."</td>";	
				
				$verif_addr_status = ( $addr_arr[$i]->getVar("addr_status") == 1 ) ? _YES : _NO;
				echo "<td class='center'>".$verif_addr_status."</td>";	
				echo "<td class='center'>".formatTimeStamp($addr_arr[$i]->getVar("addr_date"),"S")."</td>";	
				echo "<td class='center'>".$addr_arr[$i]->getVar("addr_hits")."</td>";	
				echo "<td class='center'>".$addr_arr[$i]->getVar("addr_rating")."</td>";	
				echo "<td class='center'>".$addr_arr[$i]->getVar("addr_votes")."</td>";	
				echo "<td class='center'>".$addr_arr[$i]->getVar("addr_comments")."</td>";	
				
				echo "<td align='center' width='10%'>
					<a href='addr.php?op=edit_addr&addr_id=".$addr_arr[$i]->getVar("addr_id")."'><img src=".$pathIcon16."/edit.png alt='"._EDIT."' title='"._EDIT."'></a>
					<a href='addr.php?op=delete_addr&addr_id=".$addr_arr[$i]->getVar("addr_id")."'><img src=".$pathIcon16."/delete.png alt='"._DELETE."' title='"._DELETE."'></a>
					</td>";
				echo "</tr>";				
			}
			echo "</table><br /><br />";
		} else {
		    echo "<table width='100%' cellspacing='1' class='outer'>
				<tr>
					<th class='center'>"._AM_ADDRESSES_ADDR_CID."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_TITLE."</th>						
					<th class='center'>"._AM_ADDRESSES_ADDR_URL."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_ADDRESS."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_ZIP."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_CITY."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_COUNTRY."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_LONG."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_LAT."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_ZOOM."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_PHONE."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_MOBILE."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_FAX."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_CONTEMAIL."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_OPENTIME."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_LOGOURL."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_SUBMITTER."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_STATUS."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_DATE."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_HITS."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_RATING."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_VOTES."</th>
					<th class='center'>"._AM_ADDRESSES_ADDR_COMMENTS."</th>						
					<th align='center' width='10%'>"._AM_ADDRESSES_FORMACTION."</th>
				</tr><tr class='errorMsg'><td colspan='24'>No Address</td></tr>";
			echo "</table><br /><br />";
		}
	
    break;

    case "new_addr":        
        echo $adminMenu->addNavigation("addr.php");
        $adminMenu->addItemButton(_AM_ADDRESSES_ADDRLIST, 'addr.php?op=list', 'list');
        echo $adminMenu->renderButton();

        $obj =& $addrHandler->create();
        $form = $obj->getForm();
		$form->display();
    break;	
	
	case "save_addr":
		if ( !$GLOBALS["xoopsSecurity"]->check() ) {
           redirect_header("addr.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
        }
        if (isset($_REQUEST["addr_id"])) {
           $obj =& $addrHandler->get($_REQUEST["addr_id"]);
        } else {
           $obj =& $addrHandler->create();
        }
		
		//Form addr_cid
		$obj->setVar("addr_cid", $_REQUEST["addr_cid"]);
		//Form addr_title
		$obj->setVar("addr_title", $_REQUEST["addr_title"]);
		//Form addr_description
		$obj->setVar("addr_description", $_REQUEST["addr_description"]);
		//Form addr_url
		$obj->setVar("addr_url", $_REQUEST["addr_url"]);
		//Form addr_address
		$obj->setVar("addr_address", $_REQUEST["addr_address"]);
		//Form addr_zip
		$obj->setVar("addr_zip", $_REQUEST["addr_zip"]);
		//Form addr_city
		$obj->setVar("addr_city", $_REQUEST["addr_city"]);
		//Form addr_country
		$obj->setVar("addr_country", $_REQUEST["addr_country"]);
		//Form addr_long
		$obj->setVar("addr_long", $_REQUEST["addr_long"]);
		//Form addr_lat
		$obj->setVar("addr_lat", $_REQUEST["addr_lat"]);
		//Form addr_zoom
		$verif_addr_zoom = ($_REQUEST["addr_zoom"] == 1) ? "1" : "0";
		$obj->setVar("addr_zoom", $verif_addr_zoom);
		//Form addr_phone
		$obj->setVar("addr_phone", $_REQUEST["addr_phone"]);
		//Form addr_mobile
		$obj->setVar("addr_mobile", $_REQUEST["addr_mobile"]);
		//Form addr_fax
		$obj->setVar("addr_fax", $_REQUEST["addr_fax"]);
		//Form addr_contemail
		$obj->setVar("addr_contemail", $_REQUEST["addr_contemail"]);
		//Form addr_opentime
		$obj->setVar("addr_opentime", $_REQUEST["addr_opentime"]);
		//Form addr_logourl
		$obj->setVar("addr_logourl", $_REQUEST["addr_logourl"]);
		//Form addr_submitter
		$obj->setVar("addr_submitter", $_REQUEST["addr_submitter"]);
		//Form addr_status
		$verif_addr_status = ($_REQUEST["addr_status"] == 1) ? "1" : "0";
		$obj->setVar("addr_status", $verif_addr_status);
		//Form addr_date
		$obj->setVar("addr_date", strtotime($_REQUEST["addr_date"]));
		//Form addr_hits
		$obj->setVar("addr_hits", $_REQUEST["addr_hits"]);
		//Form addr_rating
		$obj->setVar("addr_rating", $_REQUEST["addr_rating"]);
		//Form addr_votes
		$obj->setVar("addr_votes", $_REQUEST["addr_votes"]);
		//Form addr_comments
		$obj->setVar("addr_comments", $_REQUEST["addr_comments"]);
		
		
        if ($addrHandler->insert($obj)) {
           redirect_header("addr.php?op=list", 2, _AM_ADDRESSES_FORMOK);
        }

        echo $obj->getHtmlErrors();
        $form =& $obj->getForm();
		$form->display();
	break;
	
	case "edit_addr":
	    echo $adminMenu->addNavigation("addr.php");
        $adminMenu->addItemButton(_AM_ADDRESSES_NEWADDR, 'addr.php?op=new_addr', 'add');
		$adminMenu->addItemButton(_AM_ADDRESSES_ADDRLIST, 'addr.php?op=list', 'list');
        echo $adminMenu->renderButton();
		$obj = $addrHandler->get($_REQUEST["addr_id"]);
		$form = $obj->getForm();
		$form->display();
	break;
	
	case "delete_addr":
		$obj =& $addrHandler->get($_REQUEST["addr_id"]);
		if (isset($_REQUEST["ok"]) && $_REQUEST["ok"] == 1) {
			if ( !$GLOBALS["xoopsSecurity"]->check() ) {
				redirect_header("addr.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
			}
			if ($addrHandler->delete($obj)) {
				redirect_header("addr.php", 3, _AM_ADDRESSES_FORMDELOK);
			} else {
				echo $obj->getHtmlErrors();
			}
		} else {
			xoops_confirm(array("ok" => 1, "addr_id" => $_REQUEST["addr_id"], "op" => "delete_addr"), $_SERVER["REQUEST_URI"], sprintf(_AM_ADDRESSES_FORMSUREDEL, $obj->getVar("addr")));
		}
	break;	
}
include "admin_footer.php";
?>