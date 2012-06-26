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

class addresses_cat extends XoopsObject
{ 
	//Constructor
	function __construct()
	{
		$this->XoopsObject();
		$this->initVar("cat_id", XOBJ_DTYPE_INT, null, false, 8);
		$this->initVar("cat_pid", XOBJ_DTYPE_INT, null, false, 5);
		$this->initVar("cat_title", XOBJ_DTYPE_TXTBOX, null, false, 50);
		$this->initVar("cat_description", XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar("cat_imgurl", XOBJ_DTYPE_TXTBOX, null, false, 150);
		$this->initVar("cat_show_map", XOBJ_DTYPE_INT, null, false, 1);
					
	}

	function addresses_cat()
	{
		$this->__construct();
	}

	function getForm($action = false)
	{
		global $xoopsDB, $xoopsModuleConfig;
	
		if ($action === false) {
			$action = $_SERVER["REQUEST_URI"];
		}
	
		$title = $this->isNew() ? sprintf(_AM_ADDRESSES_CAT_ADD) : sprintf(_AM_ADDRESSES_CAT_EDIT);

		include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

		$form = new XoopsThemeForm($title, "form", $action, "post", true);
		$form->setExtra('enctype="multipart/form-data"');
		
		$form->addElement(new XoopsFormText(_AM_ADDRESSES_CAT_PID, "cat_pid", 50, 255, $this->getVar("cat_pid")), true);
		$form->addElement(new XoopsFormText(_AM_ADDRESSES_CAT_TITLE, "cat_title", 50, 255, $this->getVar("cat_title")), true);
		$editor_configs=array();
			$editor_configs["name"] ="cat_description";
			$editor_configs["value"] = $this->getVar("cat_description", "e");
			$editor_configs["rows"] = 10;
			$editor_configs["cols"] = 80;
			$editor_configs["width"] = "100%";
			$editor_configs["height"] = "400px";
			$editor_configs["editor"] = $GLOBALS["xoopsModuleConfig"]["addresses_editor"];				
			$form->addElement( new XoopsFormEditor(_AM_ADDRESSES_CAT_DESCRIPTION, "cat_description", $editor_configs), true );
		$form->addElement(new XoopsFormText(_AM_ADDRESSES_CAT_IMGURL, "cat_imgurl", 50, 255, $this->getVar("cat_imgurl")), true);
		 $cat_show_map = $this->isNew() ? 0 : $this->getVar("cat_show_map");
			$check_cat_show_map = new XoopsFormCheckBox(_AM_ADDRESSES_CAT_SHOW_MAP, "cat_show_map", $cat_show_map);
			$check_cat_show_map->addOption(1, " ");
			$form->addElement($check_cat_show_map);
		
		$form->addElement(new XoopsFormHidden("op", "save_cat"));
		$form->addElement(new XoopsFormButton("", "submit", _SUBMIT, "submit"));
		return $form;
	}
}
class addressesaddresses_catHandler extends XoopsPersistableObjectHandler 
{
	function __construct(&$db) 
	{
		parent::__construct($db, "addresses_cat", "addresses_cat", "cat_id", "cat_pid");
	}
}	
?>