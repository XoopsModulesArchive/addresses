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
		echo $adminMenu->addNavigation('broken.php');		
		$adminMenu->addItemButton(_AM_ADDRESSES_NEWADDR, 'addr.php?op=new_addr', 'add');
		echo $adminMenu->renderButton();
		$criteria = new CriteriaCompo();
		$criteria->setSort("broken_id");
		$criteria->setOrder("ASC");
		$numrows = $brokenHandler->getCount();
		$broken_arr = $brokenHandler->getall($criteria);
	
		//Affichage du tableau
		if ($numrows>0) 
		{			
			echo "<table width='100%' cellspacing='1' class='outer'>
				<tr>
					<th class='center'>"._AM_ADDRESSES_BROKEN_AID."</th>
					<th class='center'>"._AM_ADDRESSES_BROKEN_SENDER."</th>
					<th class='center'>"._AM_ADDRESSES_BROKEN_IP."</th>						
					<th align='center' width='10%'>"._AM_ADDRESSES_FORMACTION."</th>
				</tr>";
					
			$class = "odd";
			
			foreach (array_keys($broken_arr) as $i) 
			{	
				if ( $broken_arr[$i]->getVar("topic_pid") == 0)
				{
					echo "<tr class='".$class."'>";
					$class = ($class == "even") ? "odd" : "even";
					
						$addr =& $addrHandler->get($broken_arr[$i]->getVar("broken_aid"));
						$title_addr = $addr->getVar("addr_cid");	
						echo "<td class='center'>".$title_addr."</td>";
						echo "<td class='center'>".XoopsUser::getUnameFromId($broken_arr[$i]->getVar("broken_sender"),"S")."</td>";	
					echo "<td class='center'>".$broken_arr[$i]->getVar("broken_ip")."</td>";	
					
					echo "<td align='center' width='10%'>
						<a href='broken.php?op=edit_broken&broken_id=".$broken_arr[$i]->getVar("broken_id")."'><img src=".$pathIcon16."/edit.png alt='"._EDIT."' title='"._EDIT."'></a>
						<a href='broken.php?op=delete_broken&broken_id=".$broken_arr[$i]->getVar("broken_id")."'><img src=".$pathIcon16."/delete.png alt='"._DELETE."' title='"._DELETE."'></a>
						</td>";
					echo "</tr>";
				}	
			}
			echo "</table><br /><br />";
		} else {
		    echo "<table width='100%' cellspacing='1' class='outer'>
				<tr>
					<th class='center'>"._AM_ADDRESSES_BROKEN_AID."</th>
					<th class='center'>"._AM_ADDRESSES_BROKEN_SENDER."</th>
					<th class='center'>"._AM_ADDRESSES_BROKEN_IP."</th>						
					<th align='center' width='10%'>"._AM_ADDRESSES_FORMACTION."</th>
				</tr><tr class='errorMsg'><td colspan='4'>No Broken</td></tr>";
			echo "</table><br /><br />";
		}
	
    break;    	
		
	case "edit_broken":
	    echo $adminMenu->addNavigation("broken.php");
        $adminMenu->addItemButton(_AM_ADDRESSES_NEWBROKEN, 'addr.php?op=new_addr', 'add');
		$adminMenu->addItemButton(_AM_ADDRESSES_BROKENLIST, 'broken.php?op=list', 'list');
        echo $adminMenu->renderButton();
		$obj = $brokenHandler->get($_REQUEST["broken_id"]);
		$form = $obj->getForm();
		$form->display();
	break;
	
	case "delete_broken":
		$obj =& $brokenHandler->get($_REQUEST["broken_id"]);
		if (isset($_REQUEST["ok"]) && $_REQUEST["ok"] == 1) {
			if ( !$GLOBALS["xoopsSecurity"]->check() ) {
				redirect_header("broken.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
			}
			if ($brokenHandler->delete($obj)) {
				redirect_header("broken.php", 3, _AM_ADDRESSES_FORMDELOK);
			} else {
				echo $obj->getHtmlErrors();
			}
		} else {
			xoops_confirm(array("ok" => 1, "broken_id" => $_REQUEST["broken_id"], "op" => "delete_broken"), $_SERVER["REQUEST_URI"], sprintf(_AM_ADDRESSES_FORMSUREDEL, $obj->getVar("broken")));
		}
	break;	
}
include "admin_footer.php";
?>