		
#
# Table structure for table `addresses_broken` 4
#
		
CREATE TABLE  `addresses_broken` (
`broken_id` int (8) unsigned NOT NULL  auto_increment,
`broken_aid` int (11) unsigned NOT NULL default '0',
`broken_sender` int (11) unsigned NOT NULL default '0',
`broken_ip` varchar (20)   NOT NULL default ' ',
PRIMARY KEY (`broken_id`),
KEY `broken_aid` (`broken_aid`),
KEY `broken_sender` (`broken_sender`),
KEY `broken_ip` (`broken_ip`)
) ENGINE=MyISAM;		
#
# Table structure for table `addresses_cat` 6
#
		
CREATE TABLE  `addresses_cat` (
`cat_id` int (8) unsigned NOT NULL  auto_increment,
`cat_pid` int (5) unsigned NOT NULL default '0',
`cat_title` varchar (50)   NOT NULL default ' ',
`cat_description` text   NOT NULL ,
`cat_imgurl` varchar (150)   NOT NULL default ' ',
`cat_show_map` tinyint (1) unsigned NOT NULL default '0',
PRIMARY KEY (`cat_id`),
KEY `cat_pid` (`cat_pid`)
) ENGINE=MyISAM;		
#
# Table structure for table `addresses_addr` 25
#
		
CREATE TABLE  `addresses_addr` (
`addr_id` int (8) unsigned NOT NULL  auto_increment,
`addr_cid` int (5) unsigned NOT NULL default '0',
`addr_title` varchar (100)   NOT NULL default ' ',
`addr_description` text   NOT NULL ,
`addr_url` varchar (250)   NOT NULL default ' ',
`addr_address` varchar (100)   NOT NULL default ' ',
`addr_zip` varchar (20)   NOT NULL default ' ',
`addr_city` varchar (100)   NOT NULL default ' ',
`addr_country` varchar (100)   NOT NULL default ' ',
`addr_long` float ( )   NOT NULL default '0.0000',
`addr_lat` float ( )   NOT NULL default '0.0000',
`addr_zoom` tinyint (2) unsigned NOT NULL default '0',
`addr_phone` varchar (40)   NOT NULL default ' ',
`addr_mobile` varchar (40)   NOT NULL default ' ',
`addr_fax` varchar (40)   NOT NULL default ' ',
`addr_contemail` varchar (100)   NOT NULL default ' ',
`addr_opentime` text   NOT NULL ,
`addr_logourl` varchar (150)   NOT NULL default ' ',
`addr_submitter` int (11) unsigned NOT NULL default '0',
`addr_status` tinyint (2) unsigned NOT NULL default '0',
`addr_date` int (10) unsigned NOT NULL default '0',
`addr_hits` int (11) unsigned NOT NULL default '0',
`addr_rating` double (6,4)   NOT NULL default '0.0000',
`addr_votes` int (11) unsigned NOT NULL default '0',
`addr_comments` int (11) unsigned NOT NULL default '0',
PRIMARY KEY (`addr_id`),
KEY `addr_cid` (`addr_cid`),
KEY `addr_title` (`addr_title`)
) ENGINE=MyISAM;		
#
# Table structure for table `addresses_votedata` 6
#
		
CREATE TABLE  `addresses_votedata` (
`votedata_rid` int (8) unsigned NOT NULL  auto_increment,
`votedata_aid` int (5) unsigned NOT NULL default '0',
`votedata_ruser` int (11) unsigned NOT NULL default '0',
`votedata_rating` tinyint (3) unsigned NOT NULL default '0',
`votedata_rhostname` varchar (60)   NOT NULL default ' ',
`votedata_rtimestamp` int (10) unsigned NOT NULL default '0',
PRIMARY KEY (`votedata_rid`),
KEY `votedata_ruser` (`votedata_ruser`),
KEY `votedata_rhostname` (`votedata_rhostname`)
) ENGINE=MyISAM;