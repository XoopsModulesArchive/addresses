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
	//count "total broken"
	$count_broken = $brokenHandler->getCount();
	//count "total cat"
	$count_cat = $catHandler->getCount();
	//count "total addr"
	$count_addr = $addrHandler->getCount();
	//count "total votedata"
	$count_votedata = $votedataHandler->getCount();
	// InfoBox votedata
  	$adminMenu->addInfoBox(_AM_ADDRESSES_STATISTICS);
	// InfoBox broken
	$adminMenu->addInfoBoxLine(_AM_ADDRESSES_STATISTICS,_AM_ADDRESSES_THEREARE_BROKEN, $count_broken); 
	// InfoBox cat
	$adminMenu->addInfoBoxLine(_AM_ADDRESSES_STATISTICS,_AM_ADDRESSES_THEREARE_CAT, $count_cat); 
	// InfoBox addr
	$adminMenu->addInfoBoxLine(_AM_ADDRESSES_STATISTICS,_AM_ADDRESSES_THEREARE_ADDR, $count_addr); 
	// InfoBox votedata
	$adminMenu->addInfoBoxLine(_AM_ADDRESSES_STATISTICS,_AM_ADDRESSES_THEREARE_VOTEDATA, $count_votedata); 
    // Render Index
    echo $adminMenu->addNavigation("index.php");
    echo $adminMenu->renderIndex();
include "admin_footer.php";
?>