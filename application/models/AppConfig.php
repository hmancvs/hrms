<?php

class AppConfig extends BaseEntity {
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		$this->setTableName('appconfig');
		$this->hasColumn('section', 'string', 50);
		$this->hasColumn('sectiondisplay', 'string', 50);
		$this->hasColumn('description', 'string', 255);
		$this->hasColumn('optionname', 'string', 50);
		$this->hasColumn('optiontype', 'string', 255);
		$this->hasColumn('optionvalue', 'string', 50);
		$this->hasColumn('displayname', 'string', 50);
		$this->hasColumn('active', 'enum', array('values' => array(0 => 'Y', 1 => 'N'), 'default' => 'Y'));
		$this->hasColumn('editable', 'interger', null, array('default' => '1'));
		$this->hasColumn('companyid', 'integer', null, array('default' => NULL));
	}
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									/*"optionname.notblank" => $this->translate->_("appconfig_optionname_error"),								
       									"optionvalue.unique" => $this->translate->_("appconfig_optionvalue _error"),
       									"section.notblank" => $this->translate->_("appconfig_section_error")*/
       	       						));
	}
	/*
	 * Process object
	 */
	function processPost($formvalues){
		// check if the active is not specified and set to default value
		if(isArrayKeyAnEmptyString('active', $formvalues)) {
			unset($formvalues['active']);
		}
		if(isArrayKeyAnEmptyString('editable', $formvalues)) {
			unset($formvalues['editable']);
		}
		# debugMessage($formvalues);
		parent::processPost($formvalues);
	}
	/*
	 * Invalidate the cached application configuration
	 */
	function afterUpdate() {
		$cache = Zend_Registry::get('cache');
		$cache->remove('config');
		return true;
	}
	function getCurrentSection($section){
		$q = Doctrine_Query::create()->from('Appconfig a')->where("a.section = '".$section."' ");
		
		$result = $q->execute();
		return $result->get(0);
	}
	function getConfigByName($name){
		$q = Doctrine_Query::create()->from('Appconfig a')->where("a.optionname = '".$name."' ");
		
		$result = $q->execute();
		return $result->get(0);
	}
	function getLookupOptions($section){
		$q = Doctrine_Query::create()->from('Appconfig a')->where("a.section = '".$section."' ")->orderby("a.id");
		
		$result = $q->execute();
		return $result;
	}
	function isEditable(){
		return $this->getEditable() == 1 ? true : false;
	}
}
?>
