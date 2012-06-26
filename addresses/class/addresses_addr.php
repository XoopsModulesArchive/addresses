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

class addresses_addr extends XoopsObject
{ 
	//Constructor
	function __construct()
	{
		$this->XoopsObject();
		$this->initVar("addr_id", XOBJ_DTYPE_INT, null, false, 8);
		$this->initVar("addr_cid", XOBJ_DTYPE_INT, null, false, 5);
		$this->initVar("addr_title", XOBJ_DTYPE_TXTBOX, null, false, 100);
		$this->initVar("addr_description", XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar("addr_url", XOBJ_DTYPE_TXTBOX, null, false, 250);
		$this->initVar("addr_address", XOBJ_DTYPE_TXTBOX, null, false, 100);
		$this->initVar("addr_zip", XOBJ_DTYPE_TXTBOX, null, false, 20);
		$this->initVar("addr_city", XOBJ_DTYPE_TXTBOX, null, false, 100);
		$this->initVar("addr_country", XOBJ_DTYPE_TXTBOX, null, false, 100);
		$this->initVar("addr_long", XOBJ_DTYPE_FLOAT, null, false);
		$this->initVar("addr_lat", XOBJ_DTYPE_FLOAT, null, false);
		$this->initVar("addr_zoom", XOBJ_DTYPE_INT, null, false, 2);
		$this->initVar("addr_phone", XOBJ_DTYPE_TXTBOX, null, false, 40);
		$this->initVar("addr_mobile", XOBJ_DTYPE_TXTBOX, null, false, 40);
		$this->initVar("addr_fax", XOBJ_DTYPE_TXTBOX, null, false, 40);
		$this->initVar("addr_contemail", XOBJ_DTYPE_TXTBOX, null, false, 100);
		$this->initVar("addr_opentime", XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar("addr_logourl", XOBJ_DTYPE_TXTBOX, null, false, 150);
		$this->initVar("addr_submitter", XOBJ_DTYPE_INT, null, false, 11);
		$this->initVar("addr_status", XOBJ_DTYPE_INT, null, false, 2);
		$this->initVar("addr_date", XOBJ_DTYPE_INT, null, false, 10);
		$this->initVar("addr_hits", XOBJ_DTYPE_INT, null, false, 11);
		$this->initVar("addr_rating", XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar("addr_votes", XOBJ_DTYPE_INT, null, false, 11);
		$this->initVar("addr_comments", XOBJ_DTYPE_INT, null, false, 11);
					
	}

	function addresses_addr()
	{
		$this->__construct();
	}

	function getForm($action = false)
	{
		global $xoopsDB, $xoopsModuleConfig;
	
		if ($action === false) {
			$action = $_SERVER["REQUEST_URI"];
		}
	
		$title = $this->isNew() ? sprintf(_AM_ADDRESSES_ADDR_ADD) : sprintf(_AM_ADDRESSES_ADDR_EDIT);

		include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

		$form = new XoopsThemeForm($title, "form", $action, "post", true);
		$form->setExtra('enctype="multipart/form-data"');
		
		
			include_once(XOOPS_ROOT_PATH."/class/tree.php");			
			$catHandler =& xoops_getModuleHandler("addresses_cat", "addresses");
			$criteria = new CriteriaCompo();
            $criteria->setSort('cat_id');
            $criteria->setOrder('ASC');
			$cat_arr = $catHandler->getall();
			$mytree = new XoopsObjectTree($cat_arr, "cat_id", "cat_pid");
			$form->addElement(new XoopsFormLabel(_AM_ADDRESSES_ADDR_CID, $mytree->makeSelBox("cat_pid", "cat_title","--", $this->getVar("cat_pid"),true)));
		$form->addElement(new XoopsFormText(_AM_ADDRESSES_ADDR_TITLE, "addr_title", 50, 255, $this->getVar("addr_title")), true);
		$editor_configs=array();
			$editor_configs["name"] ="addr_description";
			$editor_configs["value"] = $this->getVar("addr_description", "e");
			$editor_configs["rows"] = 10;
			$editor_configs["cols"] = 80;
			$editor_configs["width"] = "100%";
			$editor_configs["height"] = "400px";
			$editor_configs["editor"] = $GLOBALS["xoopsModuleConfig"]["addresses_editor"];				
			$form->addElement( new XoopsFormEditor(_AM_ADDRESSES_ADDR_DESCRIPTION, "addr_description", $editor_configs), true );
		$form->addElement(new XoopsFormText(_AM_ADDRESSES_ADDR_URL, "addr_url", 50, 255, $this->getVar("addr_url")), true);
		$form->addElement(new XoopsFormText(_AM_ADDRESSES_ADDR_ADDRESS, "addr_address", 50, 255, $this->getVar("addr_address")), true);
		$form->addElement(new XoopsFormText(_AM_ADDRESSES_ADDR_ZIP, "addr_zip", 50, 255, $this->getVar("addr_zip")), true);
		$form->addElement(new XoopsFormText(_AM_ADDRESSES_ADDR_CITY, "addr_city", 50, 255, $this->getVar("addr_city")), true);
		$form->addElement(new XoopsFormText(_AM_ADDRESSES_ADDR_COUNTRY, "addr_country", 50, 255, $this->getVar("addr_country")), true);
		$form->addElement(new XoopsFormText(_AM_ADDRESSES_ADDR_LONG, "addr_long", 50, 255, $this->getVar("addr_long")), true);
		$form->addElement(new XoopsFormText(_AM_ADDRESSES_ADDR_LAT, "addr_lat", 50, 255, $this->getVar("addr_lat")), true);
		 $addr_zoom = $this->isNew() ? 0 : $this->getVar("addr_zoom");
			$form->addElement(new XoopsFormRadioYN(_AM_ADDRESSES_ADDR_ZOOM, "addr_zoom", $addr_zoom, _YES, _NO), true);
		$form->addElement(new XoopsFormText(_AM_ADDRESSES_ADDR_PHONE, "addr_phone", 50, 255, $this->getVar("addr_phone")), true);
		$form->addElement(new XoopsFormText(_AM_ADDRESSES_ADDR_MOBILE, "addr_mobile", 50, 255, $this->getVar("addr_mobile")), true);
		$form->addElement(new XoopsFormText(_AM_ADDRESSES_ADDR_FAX, "addr_fax", 50, 255, $this->getVar("addr_fax")), true);
		$form->addElement(new XoopsFormText(_AM_ADDRESSES_ADDR_CONTEMAIL, "addr_contemail", 50, 255, $this->getVar("addr_contemail")), true);
		$form->addElement(new XoopsFormText(_AM_ADDRESSES_ADDR_OPENTIME, "addr_opentime", 50, 255, $this->getVar("addr_opentime")), true);
		$form->addElement(new XoopsFormText(_AM_ADDRESSES_ADDR_LOGOURL, "addr_logourl", 50, 255, $this->getVar("addr_logourl")), true);
		$form->addElement(new XoopsFormSelectUser(_AM_ADDRESSES_ADDR_SUBMITTER, "addr_submitter", false, $this->getVar("addr_submitter"), 1, false), true);
		 $addr_status = $this->isNew() ? 0 : $this->getVar("addr_status");
			$check_addr_status = new XoopsFormCheckBox(_AM_ADDRESSES_ADDR_STATUS, "addr_status", $addr_status);
			$check_addr_status->addOption(1, " ");
			$form->addElement($check_addr_status);
		$form->addElement(new XoopsFormTextDateSelect(_AM_ADDRESSES_ADDR_DATE, "addr_date", "", $this->getVar("addr_date")));
		$form->addElement(new XoopsFormText(_AM_ADDRESSES_ADDR_HITS, "addr_hits", 50, 255, $this->getVar("addr_hits")), false);
		$form->addElement(new XoopsFormText(_AM_ADDRESSES_ADDR_RATING, "addr_rating", 50, 255, $this->getVar("addr_rating")), false);
		$form->addElement(new XoopsFormText(_AM_ADDRESSES_ADDR_VOTES, "addr_votes", 50, 255, $this->getVar("addr_votes")), false);
		$form->addElement(new XoopsFormText(_AM_ADDRESSES_ADDR_COMMENTS, "addr_comments", 50, 255, $this->getVar("addr_comments")), false);
		
		$form->addElement(new XoopsFormHidden("op", "save_addr"));
		$form->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
		return $form;
	}
}
class addressesaddresses_addrHandler extends XoopsPersistableObjectHandler 
{
	function __construct(&$db) 
	{
		parent::__construct($db, "addresses_addr", "addresses_addr", "addr_id", "addr_cid");
	}
}	
?>