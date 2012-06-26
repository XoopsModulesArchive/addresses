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
	

/***************Blocks***************/
function addresses_block_addCatSelect($cats) {
	if(is_array($cats)) 
	{
		$cat_sql = "(".current($cats);
		array_shift($cats);
		foreach($cats as $cat) 
		{
			$cat_sql .= ",".$cat;
		}
		$cat_sql .= ")";
	}
	return $cat_sql;
}

function addresses_checkModuleAdmin()
{
    if ( file_exists($GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php'))){
        include_once $GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php');
        return true;
    }else{
        echo xoops_error("Error: You don't use the Frameworks \"admin module\". Please install this Frameworks");
        return false;
    }
}

function addresses_CleanVars( &$global, $key, $default = '', $type = 'int' ) {
    switch ( $type ) {
        case 'string':
            $ret = ( isset( $global[$key] ) ) ? filter_var( $global[$key], FILTER_SANITIZE_MAGIC_QUOTES ) : $default;
            break;
        case 'int': default:
            $ret = ( isset( $global[$key] ) ) ? filter_var( $global[$key], FILTER_SANITIZE_NUMBER_INT ) : $default;
            break;
    }
    if ( $ret === false ) {
        return $default;
    }
    return $ret;
}

function xoops_meta_keywords($content)
{
	global $xoopsTpl, $xoTheme;
	$myts =& MyTextSanitizer::getInstance();
	$content= $myts->undoHtmlSpecialChars($myts->sanitizeForDisplay($content));
	if(isset($xoTheme) && is_object($xoTheme)) {
		$xoTheme->addMeta( 'meta', 'keywords', strip_tags($content));
	} else {	// Compatibility for old Xoops versions
		$xoopsTpl->assign('xoops_meta_keywords', strip_tags($content));
	}
}

function xoops_meta_description($content)
{
	global $xoopsTpl, $xoTheme;
	$myts =& MyTextSanitizer::getInstance();
	$content= $myts->undoHtmlSpecialChars($myts->displayTarea($content));
	if(isset($xoTheme) && is_object($xoTheme)) {
		$xoTheme->addMeta( 'meta', 'description', strip_tags($content));
	} else {	// Compatibility for old Xoops versions
		$xoopsTpl->assign('xoops_meta_description', strip_tags($content));
	}
}
?>