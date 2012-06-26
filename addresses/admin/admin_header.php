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
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/mainfile.php';
include_once XOOPS_ROOT_PATH . '/include/cp_header.php';
include_once '../include/config.php';
include_once '../include/functions.php';

$thisDirname = $GLOBALS['xoopsModule']->getVar('dirname');

$pathIcon16 = XOOPS_URL .'/'. $GLOBALS['xoopsModule']->getInfo('icons16');
$pathIcon32 = XOOPS_URL .'/'. $GLOBALS['xoopsModule']->getInfo('icons32');
$pathModuleAdmin = $GLOBALS['xoopsModule']->getInfo('dirmoduleadmin');
//load handlers
$brokenHandler =& xoops_getModuleHandler('addresses_broken', $thisDirname);
$catHandler =& xoops_getModuleHandler('addresses_cat', $thisDirname);
$addrHandler =& xoops_getModuleHandler('addresses_addr', $thisDirname);
$votedataHandler =& xoops_getModuleHandler('addresses_votedata', $thisDirname);

$myts =& MyTextSanitizer::getInstance();
if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
	include_once(XOOPS_ROOT_PATH."/class/template.php");
	$xoopsTpl = new XoopsTpl();
}

$xoopsTpl->assign('pathIcon16', $pathIcon16);
$xoopsTpl->assign('pathIcon32', $pathIcon32);
//Load languages
xoops_loadLanguage('admin', $thisDirname);
xoops_loadLanguage('modinfo', $thisDirname);
xoops_loadLanguage('main', $thisDirname);
// Locad admin menu class
if ( file_exists($GLOBALS['xoops']->path($pathModuleAdmin.'/moduleadmin.php'))){
	include_once $GLOBALS['xoops']->path($pathModuleAdmin.'/moduleadmin.php');
}else{
	redirect_header("../../../admin.php", 5, _AM_MODULEADMIN_MISSING, false);
}
xoops_cp_header();
$adminMenu = new ModuleAdmin();	