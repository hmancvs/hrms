<?php
/**
 * Model for company
 */
class Company extends BaseEntity  {
	
	public function setTableDefinition() {
		parent::setTableDefinition();
		
		$this->setTableName('company');
		$this->hasColumn('refno', 'string', 15);
		$this->hasColumn('name', 'string', 255, array('notblank' => true));
		$this->hasColumn('slogan', 'string', 255);
		$this->hasColumn('addressline1', 'string', 255);
		$this->hasColumn('addressline2', 'string', 255);
		$this->hasColumn('city', 'string', 255);
		$this->hasColumn('phonenumber', 'string', 15);
		$this->hasColumn('state', 'string', 2);
		$this->hasColumn('zipcode', 'string', 10);
		$this->hasColumn('email', 'string', 255);
		$this->hasColumn('industrycode', 'string', 15);
		$this->hasColumn('status', 'integer', null, array('default' => NULL));
		$this->hasColumn('defaultdepartmentid', 'integer', null, array('default' => NULL));
		$this->hasColumn('defaultuserid', 'integer', null, array('default' => NULL));
		$this->hasColumn('numberofemployeesoffperday', 'integer', null, array('default' => 3));
		$this->hasColumn('regularleavehrs', 'integer', null, array('default' => DEFAULT_REGULAR_LEAVE_HRS));
		$this->hasColumn('regularleavedays', 'integer', null, array('default' => DEFAULT_REGULAR_LEAVE_DAYS));
		$this->hasColumn('regularleavetype', 'integer', null, array('default' => 1));
		$this->hasColumn('sickleavehrs', 'integer', null, array('default' => DEFAULT_SICK_LEAVE_HRS));
		$this->hasColumn('sickleavedays', 'integer', null, array('default' => DEFAULT_SICK_LEAVE_DAYS));
		$this->hasColumn('sickleavetype', 'integer', null, array('default' => 1));
		$this->hasColumn('accrualtype', 'integer', null, array('default' => 1));
		$this->hasColumn('accrualfrequency', 'integer', null, array('default' => 4));
		$this->hasColumn('maxhoursperday', 'string', 50);
		$this->hasColumn('maxhoursperweek', 'string', 50);
	}
	
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		// set the custom error messages
		$this->addCustomErrorMessages(array(
										"name.notblank" => $this->translate->_("company_name_error")
       	       						));     
	}
	/*
	 * Relationships for the model
	 */
	public function setUp() {
		parent::setUp(); 
		
		$this->hasOne('UserAccount as defaultuser',
						array(
							'local' => 'userid',
							'foreign' => 'id'
						)
		);
		
		$this->hasOne('Department as defaultdepartment',
						array(
							'local' => 'defaultdepartmentid',
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
		if(isArrayKeyAnEmptyString('status', $formvalues)){
			unset($formvalues['status']);
		}
		if(isArrayKeyAnEmptyString('defaultdepartmentid', $formvalues)){
			unset($formvalues['defaultdepartmentid']);
		}
		if(isArrayKeyAnEmptyString('defaultuserid', $formvalues)){
			unset($formvalues['defaultuserid']);
		}
		if(isArrayKeyAnEmptyString('numberofemployeesoffperday', $formvalues)){
			unset($formvalues['numberofemployeesoffperday']);
		}
		if(isArrayKeyAnEmptyString('regularleavehrs', $formvalues)){
			unset($formvalues['regularleavehrs']);
		}
		if(isArrayKeyAnEmptyString('regularleavedays', $formvalues)){
			unset($formvalues['regularleavehrs']);
		}
		if(isArrayKeyAnEmptyString('regularleavetype', $formvalues)){
			unset($formvalues['regularleavetype']);
		}
		if(isArrayKeyAnEmptyString('sickleavehrs', $formvalues)){
			unset($formvalues['sickleavehrs']);
		}
		if(isArrayKeyAnEmptyString('sickleavedays', $formvalues)){
			unset($formvalues['sickleavedays']);
		}
		if(isArrayKeyAnEmptyString('sickleavetype', $formvalues)){
			unset($formvalues['sickleavetype']);
		}
		if(isArrayKeyAnEmptyString('accrualtype', $formvalues)){
			unset($formvalues['accrualtype']);
		}
		if(isArrayKeyAnEmptyString('accrualfrequency', $formvalues)){
			unset($formvalues['accrualfrequency']);
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
		$query = "SELECT id FROM department WHERE name = '".$name."' AND name <> '' ".$id_check;
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