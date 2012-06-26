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

include_once "header.php";
$xoopsOption['template_main'] = 'addresses_broken.html';	
include_once XOOPS_ROOT_PATH."/header.php";
//keywords
xoops_meta_keywords($GLOBALS['xoopsModuleConfig']['keywords']);
//description
xoops_meta_description(_MD_ADDRESSES_DESC);
//
$xoopsTpl->assign('xoops_mpageurl', ADDRESSES_URL."/broken.php"); 
$xoopsTpl->assign('addresses_url', ADDRESSES_URL);
$xoopsTpl->assign('adv', $GLOBALS['xoopsModuleConfig']['advertise']);
//
$xoopsTpl->assign('barsocials', $GLOBALS['xoopsModuleConfig']['barsocials']); 
$xoopsTpl->assign('fbcomments', $GLOBALS['xoopsModuleConfig']['fbcomments']); 
//
$xoopsTpl->assign('copyright', $mod_copyright);
//
include_once XOOPS_ROOT_PATH."/footer.php";	
?>