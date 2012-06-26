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
		echo $adminMenu->addNavigation('cat.php');
		$adminMenu->addItemButton(_AM_ADDRESSES_CATLIST, 'cat.php?op=list', 'list');
		$adminMenu->addItemButton(_AM_ADDRESSES_NEWCAT, 'cat.php?op=new_cat', 'add');
		echo $adminMenu->renderButton();
		$criteria = new CriteriaCompo();
		$criteria->setSort("cat_id");
		$criteria->setOrder("ASC");
		$numrows = $catHandler->getCount();
		$cat_arr = $catHandler->getall($criteria);
	
		//Affichage du tableau
		if ($numrows>0) 
		{			
			echo "<table width='100%' cellspacing='1' class='outer'>
				<tr>
					<th class='center'>"._AM_ADDRESSES_CAT_PID."</th>
					<th class='center'>"._AM_ADDRESSES_CAT_TITLE."</th>
					<th class='center'>"._AM_ADDRESSES_CAT_DESCRIPTION."</th>
					<th class='center'>"._AM_ADDRESSES_CAT_IMGURL."</th>
					<th class='center'>"._AM_ADDRESSES_CAT_SHOW_MAP."</th>						
					<th align='center' width='10%'>"._AM_ADDRESSES_FORMACTION."</th>
				</tr>";
					
			$class = "odd";
			
			foreach (array_keys($cat_arr) as $i) 
			{	
				if ( $cat_arr[$i]->getVar("topic_pid") == 0)
				{
					echo "<tr class='".$class."'>";
					$class = ($class == "even") ? "odd" : "even";
					echo "<td class='center'>".$cat_arr[$i]->getVar("cat_pid")."</td>";	
					echo "<td class='center'>".$cat_arr[$i]->getVar("cat_title")."</td>";	
					echo "<td class='center'>".$cat_arr[$i]->getVar("cat_description")."</td>";	
					echo "<td class='center'>".$cat_arr[$i]->getVar("cat_imgurl")."</td>";	
					
					$verif_cat_show_map = ( $cat_arr[$i]->getVar("cat_show_map") == 1 ) ? _YES : _NO;
					echo "<td class='center'>".$verif_cat_show_map."</td>";	
					
					echo "<td align='center' width='10%'>
						<a href='cat.php?op=edit_cat&cat_id=".$cat_arr[$i]->getVar("cat_id")."'><img src=".$pathIcon16."/edit.png alt='"._EDIT."' title='"._EDIT."'></a>
						<a href='cat.php?op=delete_cat&cat_id=".$cat_arr[$i]->getVar("cat_id")."'><img src=".$pathIcon16."/delete.png alt='"._DELETE."' title='"._DELETE."'></a>
						</td>";
					echo "</tr>";
				}	
			}
			echo "</table><br /><br />";
		} else {
		    echo "<table width='100%' cellspacing='1' class='outer'>
				<tr>
					<th class='center'>"._AM_ADDRESSES_CAT_PID."</th>
					<th class='center'>"._AM_ADDRESSES_CAT_TITLE."</th>
					<th class='center'>"._AM_ADDRESSES_CAT_DESCRIPTION."</th>
					<th class='center'>"._AM_ADDRESSES_CAT_IMGURL."</th>
					<th class='center'>"._AM_ADDRESSES_CAT_SHOW_MAP."</th>						
					<th align='center' width='10%'>"._AM_ADDRESSES_FORMACTION."</th>
				</tr><tr class='errorMsg'><td colspan='6'>No Broken</td></tr>";
			echo "</table><br /><br />";
		}
	
    break;

    case "new_cat":        
        echo $adminMenu->addNavigation("cat.php");
        $adminMenu->addItemButton(_AM_ADDRESSES_CATLIST, 'cat.php?op=list', 'list');
        echo $adminMenu->renderButton();

        $obj =& $catHandler->create();
        $form = $obj->getForm();
		$form->display();
    break;	
	
	case "save_cat":
		if ( !$GLOBALS["xoopsSecurity"]->check() ) {
           redirect_header("cat.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
        }
        if (isset($_REQUEST["cat_id"])) {
           $obj =& $catHandler->get($_REQUEST["cat_id"]);
        } else {
           $obj =& $catHandler->create();
        }
		
		//Form cat_pid
		$obj->setVar("cat_pid", $_REQUEST["cat_pid"]);
		//Form cat_title
		$obj->setVar("cat_title", $_REQUEST["cat_title"]);
		//Form cat_description
		$obj->setVar("cat_description", $_REQUEST["cat_description"]);
		//Form cat_imgurl
		$obj->setVar("cat_imgurl", $_REQUEST["cat_imgurl"]);
		//Form cat_show_map
		$verif_cat_show_map = ($_REQUEST["cat_show_map"] == 1) ? "1" : "0";
		$obj->setVar("cat_show_map", $verif_cat_show_map);
		
		
        if ($catHandler->insert($obj)) {
           redirect_header("cat.php?op=list", 2, _AM_ADDRESSES_FORMOK);
        }

        echo $obj->getHtmlErrors();
        $form =& $obj->getForm();
		$form->display();
	break;
	
	case "edit_cat":
	    echo $adminMenu->addNavigation("cat.php");
        $adminMenu->addItemButton(_AM_ADDRESSES_NEWCAT, 'cat.php?op=new_cat', 'add');
		$adminMenu->addItemButton(_AM_ADDRESSES_CATLIST, 'cat.php?op=list', 'list');
        echo $adminMenu->renderButton();
		$obj = $catHandler->get($_REQUEST["cat_id"]);
		$form = $obj->getForm();
		$form->display();
	break;
	
	case "delete_cat":
		$obj =& $catHandler->get($_REQUEST["cat_id"]);
		if (isset($_REQUEST["ok"]) && $_REQUEST["ok"] == 1) {
			if ( !$GLOBALS["xoopsSecurity"]->check() ) {
				redirect_header("cat.php", 3, implode(",", $GLOBALS["xoopsSecurity"]->getErrors()));
			}
			if ($catHandler->delete($obj)) {
				redirect_header("cat.php", 3, _AM_ADDRESSES_FORMDELOK);
			} else {
				echo $obj->getHtmlErrors();
			}
		} else {
			xoops_confirm(array("ok" => 1, "cat_id" => $_REQUEST["cat_id"], "op" => "delete_cat"), $_SERVER["REQUEST_URI"], sprintf(_AM_ADDRESSES_FORMSUREDEL, $obj->getVar("cat")));
		}
	break;	
}
include "admin_footer.php";
?>