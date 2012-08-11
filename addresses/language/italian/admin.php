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
	
//Menu
define("_AM_ADDRESSES_STATISTICS","addresses Statistics");
define("_AM_ADDRESSES_THEREARE_BROKEN","There are <span class='bold'>%s</span> Broken in the Database");
define("_AM_ADDRESSES_THEREARE_CAT","There are <span class='bold'>%s</span> Cat in the Database");
define("_AM_ADDRESSES_THEREARE_ADDR","There are <span class='bold'>%s</span> Addr in the Database");
define("_AM_ADDRESSES_THEREARE_VOTEDATA","There are <span class='bold'>%s</span> Votedata in the Database");//Buttons
define("_AM_ADDRESSES_NEWBROKEN","Add New votedata");
define("_AM_ADDRESSES_BROKENLIST","List votedata");//Buttons
define("_AM_ADDRESSES_NEWCAT","Add New votedata");
define("_AM_ADDRESSES_CATLIST","List votedata");//Buttons
define("_AM_ADDRESSES_NEWADDR","Add New votedata");
define("_AM_ADDRESSES_ADDRLIST","List votedata");//Buttons
define("_AM_ADDRESSES_NEWVOTEDATA","Add New votedata");
define("_AM_ADDRESSES_VOTEDATALIST","List votedata");
//Index

//General
define("_AM_ADDRESSES_FORMOK","Registered successfull");
define("_AM_ADDRESSES_FORMDELOK","Deleted successfull");
define("_AM_ADDRESSES_FORMSUREDEL","Are you sure you want to delete: <b><span style=\"color : Red\"> %s </span></b>");
define("_AM_ADDRESSES_FORMSURERENEW","Are you sure you want renew: <b><span style=\"color : Red\"> %s </span></b>");
define("_AM_ADDRESSES_FORMUPLOAD","Upload");
define("_AM_ADDRESSES_FORMIMAGE_PATH","File presents in %s");
define("_AM_ADDRESSES_FORMACTION","Action");

define("_AM_ADDRESSES_BROKEN_ADD","Add a broken");
define("_AM_ADDRESSES_BROKEN_EDIT","Edit a broken");
define("_AM_ADDRESSES_BROKEN_DELETE","Delete a broken");

define("_AM_ADDRESSES_BROKEN_ID","Id");

define("_AM_ADDRESSES_BROKEN_AID","Aid");

define("_AM_ADDRESSES_BROKEN_SENDER","Sender");

define("_AM_ADDRESSES_BROKEN_IP","Ip");


define("_AM_ADDRESSES_CAT_ADD","Add a cat");
define("_AM_ADDRESSES_CAT_EDIT","Edit a cat");
define("_AM_ADDRESSES_CAT_DELETE","Delete a cat");

define("_AM_ADDRESSES_CAT_ID","Id");

define("_AM_ADDRESSES_CAT_PID","Pid");

define("_AM_ADDRESSES_CAT_TITLE","Title");

define("_AM_ADDRESSES_CAT_DESCRIPTION","Description");

define("_AM_ADDRESSES_CAT_IMGURL","Imgurl");

define("_AM_ADDRESSES_CAT_SHOW_MAP","Show_map");


define("_AM_ADDRESSES_ADDR_ADD","Add a addr");
define("_AM_ADDRESSES_ADDR_EDIT","Edit a addr");
define("_AM_ADDRESSES_ADDR_DELETE","Delete a addr");

define("_AM_ADDRESSES_ADDR_ID","Id");

define("_AM_ADDRESSES_ADDR_CID","Cid");

define("_AM_ADDRESSES_ADDR_TITLE","Title");

define("_AM_ADDRESSES_ADDR_DESCRIPTION","Description");

define("_AM_ADDRESSES_ADDR_URL","Url");

define("_AM_ADDRESSES_ADDR_ADDRESS","Address");

define("_AM_ADDRESSES_ADDR_ZIP","Zip");

define("_AM_ADDRESSES_ADDR_CITY","City");

define("_AM_ADDRESSES_ADDR_COUNTRY","Country");

define("_AM_ADDRESSES_ADDR_LONG","Long");

define("_AM_ADDRESSES_ADDR_LAT","Lat");

define("_AM_ADDRESSES_ADDR_ZOOM","Zoom");

define("_AM_ADDRESSES_ADDR_PHONE","Phone");

define("_AM_ADDRESSES_ADDR_MOBILE","Mobile");

define("_AM_ADDRESSES_ADDR_FAX","Fax");

define("_AM_ADDRESSES_ADDR_CONTEMAIL","Contemail");

define("_AM_ADDRESSES_ADDR_OPENTIME","Opentime");

define("_AM_ADDRESSES_ADDR_LOGOURL","Logourl");

define("_AM_ADDRESSES_ADDR_SUBMITTER","Submitter");

define("_AM_ADDRESSES_ADDR_STATUS","Status");

define("_AM_ADDRESSES_ADDR_DATE","Date");

define("_AM_ADDRESSES_ADDR_HITS","Hits");

define("_AM_ADDRESSES_ADDR_RATING","Rating");

define("_AM_ADDRESSES_ADDR_VOTES","Votes");

define("_AM_ADDRESSES_ADDR_COMMENTS","Comments");


define("_AM_ADDRESSES_VOTEDATA_ADD","Add a votedata");
define("_AM_ADDRESSES_VOTEDATA_EDIT","Edit a votedata");
define("_AM_ADDRESSES_VOTEDATA_DELETE","Delete a votedata");

define("_AM_ADDRESSES_VOTEDATA_RID","Rid");

define("_AM_ADDRESSES_VOTEDATA_AID","Aid");

define("_AM_ADDRESSES_VOTEDATA_RUSER","Ruser");

define("_AM_ADDRESSES_VOTEDATA_RATING","Rating");

define("_AM_ADDRESSES_VOTEDATA_RHOSTNAME","Rhostname");

define("_AM_ADDRESSES_VOTEDATA_RTIMESTAMP","Rtimestamp");


//Blocks.php

define("_AM_ADDRESSES_BROKEN_BLOCK_DAY","brokens of today");
define("_AM_ADDRESSES_BROKEN_BLOCK_RANDOM","brokens random");
define("_AM_ADDRESSES_BROKEN_BLOCK_RECENT","brokens recents");

define("_AM_ADDRESSES_CAT_BLOCK_DAY","cats of today");
define("_AM_ADDRESSES_CAT_BLOCK_RANDOM","cats random");
define("_AM_ADDRESSES_CAT_BLOCK_RECENT","cats recents");

define("_AM_ADDRESSES_ADDR_BLOCK_DAY","addrs of today");
define("_AM_ADDRESSES_ADDR_BLOCK_RANDOM","addrs random");
define("_AM_ADDRESSES_ADDR_BLOCK_RECENT","addrs recents");

define("_AM_ADDRESSES_VOTEDATA_BLOCK_DAY","votedatas of today");
define("_AM_ADDRESSES_VOTEDATA_BLOCK_RANDOM","votedatas random");
define("_AM_ADDRESSES_VOTEDATA_BLOCK_RECENT","votedatas recents");

//Permissions
define("_AM_ADDRESSES_PERMISSIONS_ACCESS","Permissions to access");
define("_AM_ADDRESSES_PERMISSIONS_VIEW","Permissions to view");
define("_AM_ADDRESSES_PERMISSIONS_SUBMIT","Permissions to submit");
//Error NoFrameworks
define("_AM_ERROR_NOFRAMEWORKS","Error: You don&#39;t use the Frameworks \"admin module\". Please install this Frameworks");
define("_AM_ADDRESSES_MAINTAINEDBY","is maintained by the");
?>