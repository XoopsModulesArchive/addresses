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

if (!defined('XOOPS_ROOT_PATH')){ exit(); }

$dirname = basename( dirname( __FILE__ ) ) ;
xoops_load('XoopsLists');

$modversion['name'] = _MI_ADDRESSES_ADMIN_NAME;
$modversion['version'] = 1.73;
$modversion['description'] = _MI_ADDRESSES_ADMIN_DESC;
$modversion['author'] = "TXMod Xoops (Timgno)";
$modversion['author_mail'] = "support@txmodxoops.org";
$modversion['author_website_url'] = "http://www.txmodxoops.org";
$modversion['author_website_name'] = "TXMod Xoops (Timgno)";
$modversion['credits'] = "Timgno";
$modversion['license'] = "GNU GPL see License";
$modversion['help'] = 'page=help';
$modversion['license'] = 'GNU GPL 2.0';
$modversion['license_url'] = "www.gnu.org/licenses/gpl-2.0.html/";

$modversion['release_info'] = "Beta 1 15/04/2012";
$modversion['release_file'] = XOOPS_URL."/modules/{$dirname}/docs/changelog.txt";
$modversion['release_date'] = "2012/06/26";

$modversion['manual'] = "Manual";
$modversion['manual_file'] = XOOPS_URL."/modules/{$dirname}/docs/install.txt";
$modversion['min_php'] = "5.2";
$modversion['min_xoops'] = "2.5";
$modversion['min_admin']= "1.1";
$modversion['min_db']= array('mysql'=>'5.0.7', 'mysqli'=>'5.0.7');
$modversion['image'] = "images/addresses_slogo.png";
$modversion['dirname'] = "{$dirname}";

$modversion['dirmoduleadmin'] = 'Frameworks/moduleclasses/moduleadmin';
$modversion['icons16'] = 'Frameworks/moduleclasses/icons/16';
$modversion['icons32'] = 'Frameworks/moduleclasses/icons/32';

//About
$modversion['demo_site_url'] = "http://www.txmodxoops.org/modules/addresses";
$modversion['demo_site_name'] = "Addresses TXMod Xoops";
$modversion['forum_site_url'] = "http://www.txmodxoops.org/modules/newbb";
$modversion['forum_site_name'] = "TXMod Xoops Community";
$modversion['module_website_url'] = "http://www.txmodxoops.org/";
$modversion['module_website_name'] = "TXMod Xoops";
$modversion['release'] = "15/04/2012";
$modversion['module_status'] = "Beta 1";

// Admin things
$modversion['hasAdmin'] = 1;
// Admin system menu
$modversion['system_menu'] = 1;

$modversion["adminindex"] = "admin/index.php";
$modversion["adminmenu"] = "admin/menu.php";

// Mysql file
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
// Tables
$modversion['tables'][1] = "addresses_broken";
$modversion['tables'][2] = "addresses_cat";
$modversion['tables'][3] = "addresses_addr";
$modversion['tables'][4] = "addresses_votedata";

// Scripts to run upon installation or update
$modversion["onInstall"] = "include/install.php";
//$modversion["onUpdate"] = "include/update.php";

// Menu
$modversion["hasMain"] = 1;

//Search
$modversion["hasSearch"] = 1;
$modversion["search"]["file"] = "include/search.inc.php";
$modversion["search"]["func"] = "addresses_search";

// Templates
$i = 1;
$modversion["templates"][$i]["file"] = "addresses_index.html";
$modversion["templates"][$i]["description"] = "addresses index page";
$i++;
$modversion["templates"][$i]["file"] = "addresses_broken.html";
$modversion["templates"][$i]["description"] = "addresses broken page";
$i++;
$modversion["templates"][$i]["file"] = "addresses_cat.html";
$modversion["templates"][$i]["description"] = "addresses cat page";
$i++;
$modversion["templates"][$i]["file"] = "addresses_addr.html";
$modversion["templates"][$i]["description"] = "addresses addr page";
$i++;
$modversion["templates"][$i]["file"] = "addresses_votedata.html";
$modversion["templates"][$i]["description"] = "addresses votedata page";
$i++;
$modversion["templates"][$i]["file"] = "addresses_header.html";
$modversion["templates"][$i]["description"] = "addresses header page";
$i++;
$modversion["templates"][$i]["file"] = "addresses_footer.html";
$modversion["templates"][$i]["description"] = "addresses footer page";
unset( $i );

//Blocs
$i = 1;
$modversion["blocks"][$i]["file"] = "blocks_broken.php";
$modversion["blocks"][$i]["name"] = _MI_ADDRESSES_BROKEN_BLOCK_RECENT;
$modversion["blocks"][$i]["description"] = "";
$modversion["blocks"][$i]["show_func"] = "b_addresses_broken";
$modversion["blocks"][$i]["edit_func"] = "b_addresses_broken_edit";
$modversion["blocks"][$i]["options"] = "recent|5|25|0";
$modversion["blocks"][$i]["template"] = "addresses_broken_block_recent.html";
$i++;
$modversion["blocks"][$i]["file"] = "blocks_broken.php";
$modversion["blocks"][$i]["name"] = _MI_ADDRESSES_BROKEN_BLOCK_DAY;
$modversion["blocks"][$i]["description"] = "";
$modversion["blocks"][$i]["show_func"] = "b_addresses_broken";
$modversion["blocks"][$i]["edit_func"] = "b_addresses_broken_edit";
$modversion["blocks"][$i]["options"] = "day|5|25|0";
$modversion["blocks"][$i]["template"] = "addresses_broken_block_day.html";
$i++;
$modversion["blocks"][$i]["file"] = "blocks_broken.php";
$modversion["blocks"][$i]["name"] = _MI_ADDRESSES_BROKEN_BLOCK_RANDOM;
$modversion["blocks"][$i]["description"] = "";
$modversion["blocks"][$i]["show_func"] = "b_addresses_broken";
$modversion["blocks"][$i]["edit_func"] = "b_addresses_broken_edit";
$modversion["blocks"][$i]["options"] = "random|5|25|0";
$modversion["blocks"][$i]["template"] = "addresses_broken_block_random.html"; 
$i++;
$modversion["blocks"][$i]["file"] = "blocks_cat.php";
$modversion["blocks"][$i]["name"] = _MI_ADDRESSES_CAT_BLOCK_RECENT;
$modversion["blocks"][$i]["description"] = "";
$modversion["blocks"][$i]["show_func"] = "b_addresses_cat";
$modversion["blocks"][$i]["edit_func"] = "b_addresses_cat_edit";
$modversion["blocks"][$i]["options"] = "recent|5|25|0";
$modversion["blocks"][$i]["template"] = "addresses_cat_block_recent.html";
$i++;
$modversion["blocks"][$i]["file"] = "blocks_cat.php";
$modversion["blocks"][$i]["name"] = _MI_ADDRESSES_CAT_BLOCK_DAY;
$modversion["blocks"][$i]["description"] = "";
$modversion["blocks"][$i]["show_func"] = "b_addresses_cat";
$modversion["blocks"][$i]["edit_func"] = "b_addresses_cat_edit";
$modversion["blocks"][$i]["options"] = "day|5|25|0";
$modversion["blocks"][$i]["template"] = "addresses_cat_block_day.html";
$i++;
$modversion["blocks"][$i]["file"] = "blocks_cat.php";
$modversion["blocks"][$i]["name"] = _MI_ADDRESSES_CAT_BLOCK_RANDOM;
$modversion["blocks"][$i]["description"] = "";
$modversion["blocks"][$i]["show_func"] = "b_addresses_cat";
$modversion["blocks"][$i]["edit_func"] = "b_addresses_cat_edit";
$modversion["blocks"][$i]["options"] = "random|5|25|0";
$modversion["blocks"][$i]["template"] = "addresses_cat_block_random.html"; 
$i++;
$modversion["blocks"][$i]["file"] = "blocks_addr.php";
$modversion["blocks"][$i]["name"] = _MI_ADDRESSES_ADDR_BLOCK_RECENT;
$modversion["blocks"][$i]["description"] = "";
$modversion["blocks"][$i]["show_func"] = "b_addresses_addr";
$modversion["blocks"][$i]["edit_func"] = "b_addresses_addr_edit";
$modversion["blocks"][$i]["options"] = "recent|5|25|0";
$modversion["blocks"][$i]["template"] = "addresses_addr_block_recent.html";
$i++;
$modversion["blocks"][$i]["file"] = "blocks_addr.php";
$modversion["blocks"][$i]["name"] = _MI_ADDRESSES_ADDR_BLOCK_DAY;
$modversion["blocks"][$i]["description"] = "";
$modversion["blocks"][$i]["show_func"] = "b_addresses_addr";
$modversion["blocks"][$i]["edit_func"] = "b_addresses_addr_edit";
$modversion["blocks"][$i]["options"] = "day|5|25|0";
$modversion["blocks"][$i]["template"] = "addresses_addr_block_day.html";
$i++;
$modversion["blocks"][$i]["file"] = "blocks_addr.php";
$modversion["blocks"][$i]["name"] = _MI_ADDRESSES_ADDR_BLOCK_RANDOM;
$modversion["blocks"][$i]["description"] = "";
$modversion["blocks"][$i]["show_func"] = "b_addresses_addr";
$modversion["blocks"][$i]["edit_func"] = "b_addresses_addr_edit";
$modversion["blocks"][$i]["options"] = "random|5|25|0";
$modversion["blocks"][$i]["template"] = "addresses_addr_block_random.html"; 
$i++;
$modversion["blocks"][$i]["file"] = "blocks_votedata.php";
$modversion["blocks"][$i]["name"] = _MI_ADDRESSES_VOTEDATA_BLOCK_RECENT;
$modversion["blocks"][$i]["description"] = "";
$modversion["blocks"][$i]["show_func"] = "b_addresses_votedata";
$modversion["blocks"][$i]["edit_func"] = "b_addresses_votedata_edit";
$modversion["blocks"][$i]["options"] = "recent|5|25|0";
$modversion["blocks"][$i]["template"] = "addresses_votedata_block_recent.html";
$i++;
$modversion["blocks"][$i]["file"] = "blocks_votedata.php";
$modversion["blocks"][$i]["name"] = _MI_ADDRESSES_VOTEDATA_BLOCK_DAY;
$modversion["blocks"][$i]["description"] = "";
$modversion["blocks"][$i]["show_func"] = "b_addresses_votedata";
$modversion["blocks"][$i]["edit_func"] = "b_addresses_votedata_edit";
$modversion["blocks"][$i]["options"] = "day|5|25|0";
$modversion["blocks"][$i]["template"] = "addresses_votedata_block_day.html";
$i++;
$modversion["blocks"][$i]["file"] = "blocks_votedata.php";
$modversion["blocks"][$i]["name"] = _MI_ADDRESSES_VOTEDATA_BLOCK_RANDOM;
$modversion["blocks"][$i]["description"] = "";
$modversion["blocks"][$i]["show_func"] = "b_addresses_votedata";
$modversion["blocks"][$i]["edit_func"] = "b_addresses_votedata_edit";
$modversion["blocks"][$i]["options"] = "random|5|25|0";
$modversion["blocks"][$i]["template"] = "addresses_votedata_block_random.html"; 
$i++;

// Config
$i = 1;
$modversion["config"][$i]["name"] = "addresses_editor";
$modversion["config"][$i]["title"] = "_MI_ADDRESSES_EDITOR";
$modversion["config"][$i]["description"] = "_MI_ADDRESSES_EDITOR_DESC";
$modversion["config"][$i]["formtype"] = "select";
$modversion["config"][$i]["valuetype"] = "text";
$modversion["config"][$i]["default"] = "dhtmltextarea";
$modversion["config"][$i]["options"] = XoopsLists::getEditorList();
$modversion["config"][$i]["category"] = "global";  
$i++;
$modversion["config"][$i]["name"] = "keywords";
$modversion["config"][$i]["title"] = "_MI_ADDRESSES_KEYWORDS";
$modversion["config"][$i]["description"] = "_MI_ADDRESSES_KEYWORDS_DESC";
$modversion["config"][$i]["formtype"] = "textbox";
$modversion["config"][$i]["valuetype"] = "text";
$modversion["config"][$i]["default"] = '';
$i++;
$modversion["config"][$i]["name"] = "advertise";
$modversion["config"][$i]["title"] = "_MI_ADDRESSES_ADVERTISE";
$modversion["config"][$i]["description"] = "_MI_ADDRESSES_ADVERTISE_DESC";
$modversion["config"][$i]["formtype"] = "textarea";
$modversion["config"][$i]["valuetype"] = "text";
$modversion["config"][$i]["default"] = '';
$i++;   
$modversion["config"][$i]["name"] = "barsocials";   
$modversion["config"][$i]["title"] = "_MI_ADDRESSES_BARSOCIALS";   
$modversion["config"][$i]["description"] = "_MI_ADDRESSES_BARSOCIALS_DESC";   
$modversion["config"][$i]["formtype"] = "yesno";  
$modversion["config"][$i]["aluetype"] = "int";  
$modversion["config"][$i]["default"] = 0; 
$i++; 
$modversion["config"][$i]["name"] = "fbcomments";   
$modversion["config"][$i]["title"] = "_MI_ADDRESSES_FBCOMMENTS";   
$modversion["config"][$i]["description"] = "_MI_ADDRESSES_FBCOMMENTS_DESC";   
$modversion["config"][$i]["formtype"] = "yesno";  
$modversion["config"][$i]["aluetype"] = "int";  
$modversion["config"][$i]["default"] = 0; 
unset($i);
?>