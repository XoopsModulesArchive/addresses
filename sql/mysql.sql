# phpMyAdmin MySQL-Dump
# version 2.2.2
# http://phpwizard.net/phpMyAdmin/
# http://phpmyadmin.sourceforge.net/ (download page)
#
# --------------------------------------------------------
#
# Table structure for table `addresses_cat`
#
CREATE TABLE addresses_cat (
  cid int(5) unsigned NOT NULL auto_increment,
  pid int(5) unsigned NOT NULL default '0',
  title varchar(50) NOT NULL default '',
  imgurl varchar(150) NOT NULL default '',
# --- hack LUCIO - start
  show_map tinyint(1) NOT NULL default '1',
# --- hack LUCIO - end
  PRIMARY KEY  (cid),
  KEY pid (pid)
) ENGINE=MyISAM;
# --- hack LUCIO - start
# --------------------------------------------------------
#
# Table structure for table `addresses_cat_text`
#
CREATE TABLE addresses_cat_text (
  cid int(11) unsigned NOT NULL default '0',
  description text NOT NULL,
  KEY cid (cid)
) ENGINE=MyISAM;
# --- hack LUCIO - end
# --------------------------------------------------------
#
# Table structure for table `addresses_addresses`
#
CREATE TABLE addresses_addresses (
  aid int(11) unsigned NOT NULL auto_increment,
  cid int(5) unsigned NOT NULL default '0',
  title varchar(100) NOT NULL default '',
  url varchar(250) NOT NULL default '',
  address varchar(100) NOT NULL default '',
  zip varchar(20) NOT NULL default '',
  city varchar(100) NOT NULL default '',
  country varchar(100) NOT NULL default '',
# --- hack LUCIO - start
  lon float NOT NULL default '0',
  lat float NOT NULL default '0',
  zoom tinyint(2) NOT NULL default '0',
# --- hack LUCIO - end
  phone varchar(40) NOT NULL default '',
  mobile varchar(40) NOT NULL default '',
  fax varchar(40) NOT NULL default '',
  contemail varchar(100) NOT NULL default '',
  opentime text NOT NULL,
  logourl varchar(150) NOT NULL default '',
  submitter int(11) unsigned NOT NULL default '0',
  status tinyint(2) NOT NULL default '0',
  date int(10) NOT NULL default '0',
  hits int(11) unsigned NOT NULL default '0',
  rating double(6,4) NOT NULL default '0.0000',
  votes int(11) unsigned NOT NULL default '0',
  comments int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (aid),
  KEY cid (cid),
  KEY status (status),
  KEY title (title(40))
) ENGINE=MyISAM;
# --------------------------------------------------------
#
# Table structure for table `addresses_addresses_text`
#
CREATE TABLE addresses_addresses_text (
  aid int(11) unsigned NOT NULL default '0',
  description text NOT NULL,
  KEY aid (aid)
) ENGINE=MyISAM;
# --------------------------------------------------------
#
# Table structure for table `addresses_mod`
#
CREATE TABLE addresses_mod (
  requestid int(11) unsigned NOT NULL auto_increment,
  aid int(11) unsigned NOT NULL default '0',
  cid int(5) unsigned NOT NULL default '0',
  title varchar(100) NOT NULL default '',
  url varchar(250) NOT NULL default '',
  address varchar(100) NOT NULL default '',
  zip varchar(20) NOT NULL default '',
  city varchar(100) NOT NULL default '',
  country varchar(100) NOT NULL default '',
# --- hack LUCIO - start
  lon float NOT NULL default '0',
  lat float NOT NULL default '0',
  zoom tinyint(2) NOT NULL default '0',
# --- hack LUCIO - end
  phone varchar(40) NOT NULL default '',
  mobile varchar(40) NOT NULL default '',
  fax varchar(40) NOT NULL default '',
  contemail varchar(100) NOT NULL default '',
  opentime text NOT NULL,
  logourl varchar(150) NOT NULL default '',
  description text NOT NULL,
  modifysubmitter int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (requestid)
) ENGINE=MyISAM;
# --------------------------------------------------------
#
# Table structure for table `addresses_broken`
#
CREATE TABLE addresses_broken (
  reportid int(5) NOT NULL auto_increment,
  aid int(11) unsigned NOT NULL default '0',
  sender int(11) unsigned NOT NULL default '0',
  ip varchar(20) NOT NULL default '',
  PRIMARY KEY  (reportid),
  KEY aid (aid),
  KEY sender (sender),
  KEY ip (ip)
) ENGINE=MyISAM;
# --------------------------------------------------------
#
# Table structure for table `addresses_votedata`
#
CREATE TABLE addresses_votedata (
  ratingid int(11) unsigned NOT NULL auto_increment,
  aid int(11) unsigned NOT NULL default '0',
  ratinguser int(11) unsigned NOT NULL default '0',
  rating tinyint(3) unsigned NOT NULL default '0',
  ratinghostname varchar(60) NOT NULL default '',
  ratingtimestamp int(10) NOT NULL default '0',
  PRIMARY KEY  (ratingid),
  KEY ratinguser (ratinguser),
  KEY ratinghostname (ratinghostname)
) ENGINE=MyISAM;
