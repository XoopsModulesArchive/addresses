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
		echo $adminMenu->addNavigation('votedata.php');
		$adminMenu->addItemButton(_AM_ADDRESSES_NEWADDR, 'addr.php?op=new_addr', 'add');
		echo $adminMenu->renderButton();
		$criteria = new CriteriaCompo();
		$criteria->setSort("votedata_rid");
		$criteria->setOrder("ASC");
		$numrows = $votedataHandler->getCount();
		$votedata_arr = $votedataHandler->getall($criteria);
	
		//Affichage du tableau
		if ($numrows>0) 
		{			
			echo "<table width='100%' cellspacing='1' class='outer'>
				<tr>
					<th align=\"center\">"._AM_ADDRESSES_VOTEDATA_AID."</th>
					<th align=\"center\">"._AM_ADDRESSES_VOTEDATA_RUSER."</th>
					<th align=\"center\">"._AM_ADDRESSES_VOTEDATA_RATING."</th>
					<th align=\"center\">"._AM_ADDRESSES_VOTEDATA_RHOSTNAME."</th>
					<th align=\"center\">"._AM_ADDRESSES_VOTEDATA_RTIMESTAMP."</th>					
					<th align='center' width='10%'>"._AM_ADDRESSES_FORMACTION."</th>
				</tr>";
					
			$class = "odd";
			
			foreach (array_keys($votedata_arr) as $i) 
			{	
				if ( $votedata_arr[$i]->getVar("topic_pid") == 0)
				{
					echo "<tr class='".$class."'>";
					$class = ($class == "even") ? "odd" : "even";
					
						$addr =& $addrHandler->get($votedata_arr[$i]->getVar("votedata_aid"));
						$title_addr = $addr->getVar("addr_cid");	
						echo "<td align=\"center\">".$title_addr."</td>";
						echo "<td align=\"center\">".XoopsUser::getUnameFromId($votedata_arr[$i]->getVar("votedata_ruser"),"S")."</td>";	
					
					$verif_votedata_rating = ( $votedata_arr[$i]->getVar("votedata_rating") == 1 ) ? _YES : _NO;
					echo "<td align=\"center\">".$verif_votedata_rating."</td>";	
					echo "<td align=\"center\">".$votedata_arr[$i]->getVar("votedata_rhostname")."</td>";	
					echo "<td align=\"center\">".$votedata_arr[$i]->getVar("votedata_rtimestamp")."</td>";	
					
					echo "<td align='center' width='10%'>
						<a href='votedata.php?op=edit_votedata&votedata_rid=".$votedata_arr[$i]->getVar("votedata_rid")."'><img src=".$pathIcon16."/edit.png alt='"._EDIT."' title='"._EDIT."'></a>
						<a href='votedata.php?op=delete_votedata&votedata_rid=".$votedata_arr[$i]->getVar("votedata_rid")."'><img src=".$pathIcon16."/delete.png alt='"._DELETE."' title='"._DELETE."'></a>
						</td>";
					echo "</tr>";
				}	
			}
			echo "</table><br /><br />";
		} else {
		    echo "<table width='100%' cellspacing='1' class='outer'>
				<tr>
					<th align=\"center\">"._AM_ADDRESSES_VOTEDATA_AID."</th>
					<th align=\"center\">"._AM_ADDRESSES_VOTEDATA_RUSER."</th>
					<th align=\"center\">"._AM_ADDRESSES_VOTEDATA_RATING."</th>
					<th align=\"center\">"._AM_ADDRESSES_VOTEDATA_RHOSTNAME."</th>
					<th align=\"center\">"._AM_ADDRESSES_VOTEDATA_RTIMESTAMP."</th>					
					<th align='center' width='10%'>"._AM_ADDRESSES_FORMACTION."</th>
				</tr><tr class='errorMsg'><td colspan='6'>No Votedata</td></tr>";
			echo "</table><br /><br />";
		}
	
    break;	
	
	case "delete_votedata":
		$obj =& $votedataHandler->get($_REQUEST["votedata_rid"]);
		if (isset($_REQUEST["ok"]) && $_REQUEST["ok"] == 1) {
			if ( !$GLOBALS["xoopsSecurity"]->check() ) {
				redirect_header("votedata.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
			}
			if ($votedataHandler->delete($obj)) {
				redirect_header("votedata.php", 3, _AM_ADDRESSES_FORMDELOK);
			} else {
				echo $obj->getHtmlErrors();
			}
		} else {
			xoops_confirm(array("ok" => 1, "votedata_rid" => $_REQUEST["votedata_rid"], "op" => "delete_votedata"), $_SERVER["REQUEST_URI"], sprintf(_AM_ADDRESSES_FORMSUREDEL, $obj->getVar("votedata")));
		}
	break;	
}
include "admin_footer.php";
?>