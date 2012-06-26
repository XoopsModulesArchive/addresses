<?php
// $Id: menu.php,v 1.7 2003/04/17 12:45:28 okazu Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

$i=0;
$adminmenu[$i]['title'] = _MI_MYADDRESSES_ADMENU1;
$adminmenu[$i]['link'] = "admin/index.php?op=Menu_Categories"; //Menu_Categories
$i++;
$adminmenu[$i]['title'] = _MI_MYADDRESSES_ADMENU2;
$adminmenu[$i]['link'] = "admin/index.php?op=Menu_Addresses"; //Menu_Addresses
$i++;
$adminmenu[$i]['title'] = _MI_MYADDRESSES_ADMENU3;
$adminmenu[$i]['link'] = "admin/index.php?op=NewAddress_list"; //NewAddress_list
$i++;
$adminmenu[$i]['title'] = _MI_MYADDRESSES_ADMENU4;
$adminmenu[$i]['link'] = "admin/index.php?op=BrokenAddress_list"; //BrokenAddress_list
$i++;
$adminmenu[$i]['title'] = _MI_MYADDRESSES_ADMENU5;
$adminmenu[$i]['link'] = "admin/index.php?op=ModReqAddress_list"; //listModAddresses
?>
