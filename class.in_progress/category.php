<?php
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}
/**
 * @package kernel
 * @copyright copyright &copy; 2000 XOOPS.org
 */
class AddressCategory extends XoopsObject
{
    function __construct() 
    {
        $this->initVar('cat_id', XOBJ_DTYPE_INT, null, true);
        $this->initVar('cat_title', XOBJ_DTYPE_TXTBOX);
        $this->initVar('cat_description', XOBJ_DTYPE_TXTAREA);
        $this->initVar('cat_weight', XOBJ_DTYPE_INT);
    }
/*
MySQL
CREATE TABLE `profile_category` (
  `cat_id`          smallint(5) unsigned    NOT NULL auto_increment,
  `cat_title`       varchar(255)            NOT NULL default '',
  `cat_description` text,
  `cat_weight`      smallint(5) unsigned    NOT NULL default '0',
  
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM;
*/
    function AddressCategory()
    {
        $this->__construct();
    }
    
    /**
    * Get {@link XoopsThemeForm} for adding/editing categories
    *
    * @param mixed $action URL to submit to or false for $_SERVER['REQUEST_URI']
    *
    * @return object
    */
    function getForm($action = false)
    {
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        $title = $this->isNew() ? sprintf(_PROFILE_AM_ADD, _PROFILE_AM_CATEGORY) : sprintf(_PROFILE_AM_EDIT, _PROFILE_AM_CATEGORY);

        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

        $form = new XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->addElement(new XoopsFormText(_PROFILE_AM_TITLE, 'cat_title', 35, 255, $this->getVar('cat_title')));
        if (!$this->isNew()) {
            //Load groups
            $form->addElement(new XoopsFormHidden('id', $this->getVar('cat_id')));
        }
        $form->addElement(new XoopsFormTextArea(_PROFILE_AM_DESCRIPTION, 'cat_description', $this->getVar('cat_description', 'e')));
        $form->addElement(new XoopsFormText(_PROFILE_AM_WEIGHT, 'cat_weight', 35, 35, $this->getVar('cat_weight', 'e')));

        $form->addElement(new XoopsFormHidden('op', 'save'));
        $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));

        return $form;
    }
}

/**
 * @package kernel
 * @copyright copyright &copy; 2000 XOOPS.org
 */
class AddressCategoryHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db)
    {
        parent::__construct($db, "profile_category", "profilecategory", "cat_id", 'cat_title');
    }
}
?>
