<?php
//%%%%%% Module Name 'Addresses' %%%%%

// Module Info

// The name of this module
define("_MI_MYADDRESSES_NAME","Addresses + Google Maps");

// A brief description of this module
define("_MI_MYADDRESSES_DESC","Creates an addresses section where users can search/submit/rate various addresses.");

// Names of blocks for this module (Not all module has blocks)
//hack LUCIO - start
define("_MI_MYADDRESSES_BNAME1","Recent Addresses");
define("_MI_MYADDRESSES_BDESC1","Shows recently added addresses");
define("_MI_MYADDRESSES_BNAME2","Top Addresses");
define("_MI_MYADDRESSES_BDESC2","Shows most viewed addresses");
define("_MI_MYADDRESSES_BNAME3","Categories");
define("_MI_MYADDRESSES_BDESC3","Shows main Categories");
//hack LUCIO - end


// Sub menu titles
define("_MI_MYADDRESSES_SMNAME1","Submit");
define("_MI_MYADDRESSES_SMNAME2","Popular");
define("_MI_MYADDRESSES_SMNAME3","Top Rated");

// Names of admin menu items
//define("_MI_MYADDRESSES_ADMENU1","Add/Edit Categories");
define("_MI_MYADDRESSES_ADMENU1","Categories");
//define("_MI_MYADDRESSES_ADMENU2","Add/Edit Addresses");
define("_MI_MYADDRESSES_ADMENU2","Addresses");
define("_MI_MYADDRESSES_ADMENU3","Submitted Addresses");
define("_MI_MYADDRESSES_ADMENU4","Broken Addresses");
define("_MI_MYADDRESSES_ADMENU5","Modified Addresses");
define("_MI_MYADDRESSES_ADMENU6","Addreslink Checker");

// Title of config items
define('_MI_MYADDRESSES_POPULAR','Select the number of views for Addresses to be marked as popular');
define('_MI_MYADDRESSES_NEWLINKS','Select the maximum number of new Addresses displayed on top page');
define('_MI_MYADDRESSES_PERPAGE','Select the maximum number of Addresses displayed in each page');
define('_MI_MYADDRESSES_USESHOTS','[Shots]<br />Select yes to display banner/logo images for each Address');
define('_MI_MYADDRESSES_USEFRAMES','Would you like to display the linked Address withing a frame?');
define('_MI_MYADDRESSES_SHOTWIDTH','Maximum allowed width of each banner/logo image');
define('_MI_MYADDRESSES_ANONPOST','Allow anonymous users to post Addresses?');
define('_MI_MYADDRESSES_AUTOAPPROVE','Auto approve new Addresses without admin intervention?');
//hack LUCIO - start
define('_MI_MYADDRESSES_API_KEY','[GoogleMaps]<br />Paste here your Google Maps API Key for:<br \>'.XOOPS_URL.'/modules/addresses/');
define('_MI_MYADDRESSES_DEFAULT_LAT','[GoogleMaps]<br />Default Google Maps latitude:');
define('_MI_MYADDRESSES_DEFAULT_LON','[GoogleMaps]<br />Default Google Maps longitude:');
define('_MI_MYADDRESSES_DEFAULT_ZOOM','[GoogleMaps]<br />Default Google Maps zoom level:');
define('_MI_MYADDRESSES_DEFAULT_ADDR','[GoogleMaps]<br />Default address:');
define('_MI_MYADDRESSES_POPUP_OPTIONS','[GoogleMaps]<br />Google Maps popup window attributes:');

define('_MI_MYADDRESSES_DEF_SHOT_PATH','[Shots]<br />Path to the shots images directory:');
define('_MI_MYADDRESSES_MAX_SHOT_SIZE','[Shots]<br />Maximum allowed size of each banner/logo image:');
define('_MI_MYADDRESSES_MAX_SHOT_WIDTH','[Shots]<br />Maximum allowed width of each banner/logo image:');
define('_MI_MYADDRESSES_MAX_SHOT_HEIGHT','[Shots]<br />Maximum allowed height of each banner/logo image:');

// Options of config items
define('_MI_MYADDRESSES_PERPAGE_ALL','All');
//hack LUCIO - end

// Description of each config items
define('_MI_MYADDRESSES_POPULARDSC','');
define('_MI_MYADDRESSES_NEWLINKSDSC','');
define('_MI_MYADDRESSES_PERPAGEDSC','');
define('_MI_MYADDRESSES_USEFRAMEDSC','');
define('_MI_MYADDRESSES_USESHOTSDSC','');
define('_MI_MYADDRESSES_SHOTWIDTHDSC','');
define('_MI_MYADDRESSES_AUTOAPPROVEDSC','');

//hack LUCIO - start
define('_MI_MYADDRESSES_API_KEYDSC','Get your API Key from:<br /><a href="http://code.google.com/apis/maps/signup.html" target="_blank">http://www.google.com/apis/maps/</a>');
define('_MI_MYADDRESSES_DEFAULT_LATDSC','Decimal, between -90 and +90');
define('_MI_MYADDRESSES_DEFAULT_LONDSC','Decimal, between -180 and +180');
define('_MI_MYADDRESSES_DEFAULT_ZOOMDSC','Integer, between 0 and 17');
define('_MI_MYADDRESSES_DEFAULT_ADDRDSC','');
define('_MI_MYADDRESSES_POPUP_OPTIONSDSC','Without &#39; or &quot;<br />See also Javascript method window.open() attributes');

define('_MI_MYADDRESSES_DEF_SHOT_PATHDSC','Relative to Xoops path<br />Example: modules/addresses/images/shots');
define('_MI_MYADDRESSES_MAX_SHOT_SIZEDSC','Byte');
define('_MI_MYADDRESSES_MAX_SHOT_WIDTHDSC','Pixel');
define('_MI_MYADDRESSES_MAX_SHOT_HEIGHTDSC','Pixel');
//hack LUCIO - start

// Text for notifications
define('_MI_MYADDRESSES_GLOBAL_NOTIFY','Global');
define('_MI_MYADDRESSES_GLOBAL_NOTIFYDSC','Global addresses notification options.');

define('_MI_MYADDRESSES_CATEGORY_NOTIFY','Category');
define('_MI_MYADDRESSES_CATEGORY_NOTIFYDSC','Notification options that apply to the current address category.');

define('_MI_MYADDRESSES_LINK_NOTIFY','Address');
define('_MI_MYADDRESSES_LINK_NOTIFYDSC','Notification options that aply to the current adsress.');

define('_MI_MYADDRESSES_GLOBAL_NEWCATEGORY_NOTIFY','New Category');
define('_MI_MYADDRESSES_GLOBAL_NEWCATEGORY_NOTIFYCAP','Notify me when a new address category is created.');
define('_MI_MYADDRESSES_GLOBAL_NEWCATEGORY_NOTIFYDSC','Receive notification when a new address category is created.');
define('_MI_MYADDRESSES_GLOBAL_NEWCATEGORY_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} auto-notify : New address category');

define('_MI_MYADDRESSES_GLOBAL_LINKMODIFY_NOTIFY','Modify Address Requested');
define('_MI_MYADDRESSES_GLOBAL_LINKMODIFY_NOTIFYCAP','Notify me of any address modification request.');
define('_MI_MYADDRESSES_GLOBAL_LINKMODIFY_NOTIFYDSC','Receive notification when any address modification request is submitted.');
define('_MI_MYADDRESSES_GLOBAL_LINKMODIFY_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} auto-notify : Address Modification Requested');

define('_MI_MYADDRESSES_GLOBAL_LINKBROKEN_NOTIFY','Broken Addresslink Submitted');
define('_MI_MYADDRESSES_GLOBAL_LINKBROKEN_NOTIFYCAP','Notify me of any broken addresslink report.');
define('_MI_MYADDRESSES_GLOBAL_LINKBROKEN_NOTIFYDSC','Receive notification when any broken addresslink report is submitted.');
define('_MI_MYADDRESSES_GLOBAL_LINKBROKEN_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} auto-notify : Broken Addresslink Reported');

define('_MI_MYADDRESSES_GLOBAL_LINKSUBMIT_NOTIFY','New Address Submitted');
define('_MI_MYADDRESSES_GLOBAL_LINKSUBMIT_NOTIFYCAP','Notify me when any new address is submitted (awaiting approval).');
define('_MI_MYADDRESSES_GLOBAL_LINKSUBMIT_NOTIFYDSC','Receive notification when any new address is submitted (awaiting approval).');
define('_MI_MYADDRESSES_GLOBAL_LINKSUBMIT_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} auto-notify : New address submitted');

define('_MI_MYADDRESSES_GLOBAL_NEWLINK_NOTIFY','New Address');
define('_MI_MYADDRESSES_GLOBAL_NEWLINK_NOTIFYCAP','Notify me when any new address is posted.');
define('_MI_MYADDRESSES_GLOBAL_NEWLINK_NOTIFYDSC','Receive notification when any new address is posted.');
define('_MI_MYADDRESSES_GLOBAL_NEWLINK_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} auto-notify : New address');

define('_MI_MYADDRESSES_CATEGORY_LINKSUBMIT_NOTIFY','New address Submitted');
define('_MI_MYADDRESSES_CATEGORY_LINKSUBMIT_NOTIFYCAP','Notify me when a new address is submitted (awaiting approval) to the current category.');
define('_MI_MYADDRESSES_CATEGORY_LINKSUBMIT_NOTIFYDSC','Receive notification when a new address is submitted (awaiting approval) to the current category.');
define('_MI_MYADDRESSES_CATEGORY_LINKSUBMIT_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} auto-notify : New address submitted in category');

define('_MI_MYADDRESSES_CATEGORY_NEWLINK_NOTIFY','New Address');
define('_MI_MYADDRESSES_CATEGORY_NEWLINK_NOTIFYCAP','Notify me when a new address is posted to the current category.');
define('_MI_MYADDRESSES_CATEGORY_NEWLINK_NOTIFYDSC','Receive notification when a new address is posted to the current category.');
define('_MI_MYADDRESSES_CATEGORY_NEWLINK_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} auto-notify : New address in category');

define('_MI_MYADDRESSES_LINK_APPROVE_NOTIFY','Address Approved');
define('_MI_MYADDRESSES_LINK_APPROVE_NOTIFYCAP','Notify me when this address is approved.');
define('_MI_MYADDRESSES_LINK_APPROVE_NOTIFYDSC','Receive notification when this address is approved.');
define('_MI_MYADDRESSES_LINK_APPROVE_NOTIFYSBJ','[{X_SITENAME}] {X_MODULE} auto-notify : Address approved');

?>
