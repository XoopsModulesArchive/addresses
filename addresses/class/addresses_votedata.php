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
	
if (!defined("XOOPS_ROOT_PATH")) {
	die("XOOPS root path not defined");
}

class addresses_votedata extends XoopsObject
{ 
	//Constructor
	function __construct()
	{
		$this->XoopsObject();
		$this->initVar("votedata_rid", XOBJ_DTYPE_INT, null, false, 8);
		$this->initVar("votedata_aid", XOBJ_DTYPE_INT, null, false, 5);
		$this->initVar("votedata_ruser", XOBJ_DTYPE_INT, null, false, 11);
		$this->initVar("votedata_rating", XOBJ_DTYPE_INT, null, false, 3);
		$this->initVar("votedata_rhostname", XOBJ_DTYPE_TXTBOX, null, false, 60);
		$this->initVar("votedata_rtimestamp", XOBJ_DTYPE_INT, null, false, 10);					
	}

	function addresses_votedata()
	{
		$this->__construct();
	}	
}
class addressesaddresses_votedataHandler extends XoopsPersistableObjectHandler 
{
	function __construct(&$db) 
	{
		parent::__construct($db, "addresses_votedata", "addresses_votedata", "votedata_id", "votedata_aid");
	}
}	
?>