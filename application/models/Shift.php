<?php
/**
 * Model for shift
 */
class Shift extends BaseRecord  {
	
	public function setTableDefinition() {
		parent::setTableDefinition();
		
		$this->setTableName('shift');
		$this->hasColumn('name', 'string', 255, array('notblank' => true));
		$this->hasColumn('companyid', 'integer', null, array('default' => NULL));
		$this->hasColumn('starttime', 'string', 255);
		$this->hasColumn('endtime', 'string', 255);
		$this->hasColumn('overduestarttime', 'string', 255);
		$this->hasColumn('hours', 'decimal', 10, array('scale' => '2','default' => '0'));
		$this->hasColumn('breakhours', 'decimal', 10, array('scale' => '2','default' => '0'));
	}
	
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		// set the custom error messages
		$this->addCustomErrorMessages(array(
										"name.notblank" => $this->translate->_("shift_name_error")
       	       						));     
	}
	/*
	 * Relationships for the model
	 */
	public function setUp() {
		parent::setUp(); 
		
		$this->hasOne('Company as company',
						array(
							'local' => 'companyid',
							'foreign' => 'id'
						)
		);
	}
	/**
	 * Custom model validation
	 */
	function validate() {
		# execute the column validation
		parent::validate();
		// debugMessage($this->toArray(true));
		# validate that username is unique
		if($this->nameExists()){
		$this->getErrorStack()->add("name.unique", "The name <b>".$this->getName()."</b> already exists. Please specify another.");
	}
	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues) {
		// trim spaces from the name field
		if(isArrayKeyAnEmptyString('companyid', $formvalues)){
			$formvalues['companyid'] = 1;
		}
		if(isArrayKeyAnEmptyString('hours', $formvalues)){
			unset($formvalues['hours']);
		}
		if(isArrayKeyAnEmptyString('starttime', $formvalues)){
			unset($formvalues['starttime']);
		} else {
			$formvalues['starttime'] = date("H:i:s", strtotime($formvalues['starttime']));
		}
		if(isArrayKeyAnEmptyString('endtime', $formvalues)){
			unset($formvalues['endtime']);
		} else {
			$formvalues['endtime'] = date("H:i:s", strtotime($formvalues['endtime']));
		}
		if(isArrayKeyAnEmptyString('overduestarttime', $formvalues)){
			unset($formvalues['overduestarttime']);
		} else {
			$formvalues['overduestarttime'] = date("H:i:s", strtotime($formvalues['overduestarttime']));
		}
		if(isArrayKeyAnEmptyString('breakhrs', $formvalues)){
			unset($formvalues['breakhrs']);
		}
		// debugMessage($formvalues); exit();
		parent::processPost($formvalues);
	}
	
	# determine if the name has already been assigned
	function nameExists($name =''){
		$conn = Doctrine_Manager::connection();
		# validate unique username and email
		$id_check = "";
		if(!isEmptyString($this->getID())){
			$id_check = " AND id <> '".$this->getID()."' ";
		}
	
		if(isEmptyString($name)){
			$name = $this->getName();
		}
		$query = "SELECT id FROM shift WHERE name = '".$name."' AND name <> '' ".$id_check;
		// debugMessage($query);
		$result = $conn->fetchOne($query);
		// debugMessage($result);
		if(isEmptyString($result)){
			return false;
		}
		return true;
	}
}

?>