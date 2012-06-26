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
 *  Version : 1.73 Tue 2012/06/26 12:31:43 : Timgno Exp $
 * ****************************************************************************
 */
$dirname = basename( dirname( dirname( __FILE__ ) ) ) ;
$module_handler =& xoops_gethandler("module");
$xoopsModule =& XoopsModule::getByDirname($dirname);
$moduleInfo =& $module_handler->get($xoopsModule->getVar("mid"));
$pathIcons32 = $moduleInfo->getInfo("icons32");		
$adminmenu = array(); 
$i = 1;
$adminmenu[$i]["title"] = _MI_ADDRESSES_ADMENU1;
$adminmenu[$i]["link"] = "admin/index.php";
$adminmenu[$i]["icon"] = "../../".$pathIcons32."/home.png";
$i++;
$adminmenu[$i]["title"] = _MI_ADDRESSES_ADMENU3;
$adminmenu[$i]["link"] = "admin/cat.php";
$adminmenu[$i]["icon"] = "images/32/addresses_cat.png";
$i++;
$adminmenu[$i]["title"] = _MI_ADDRESSES_ADMENU4;
$adminmenu[$i]["link"] = "admin/addr.php";
$adminmenu[$i]["icon"] = "images/32/addresses_add.png";
$i++;
$adminmenu[$i]["title"] = _MI_ADDRESSES_ADMENU2;
$adminmenu[$i]["link"] = "admin/broken.php";
$adminmenu[$i]["icon"] = "images/32/addresses_broken.png";
$i++;
$adminmenu[$i]["title"] = _MI_ADDRESSES_ADMENU5;
$adminmenu[$i]["link"] = "admin/votedata.php";
$adminmenu[$i]["icon"] = "images/32/addresses_stats.png";
$i++;
$adminmenu[$i]["title"] = _MI_ADDRESSES_ADMENU6;
$adminmenu[$i]["link"]  = "admin/about.php";
$adminmenu[$i]["icon"] = "../../".$pathIcons32."/about.png";
unset( $i );
?>