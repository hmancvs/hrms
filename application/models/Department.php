<?php
/**
 * Model for department
 */
class Department extends BaseEntity  {
	
	public function setTableDefinition() {
		parent::setTableDefinition();
		
		$this->setTableName('department');
		$this->hasColumn('name', 'string', 255);
		$this->hasColumn('headid', 'integer', null, array('default' => NULL));
		$this->hasColumn('companyid', null, array('default' => NULL));
		$this->hasColumn('description', 'string', 1000);
	}
	
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		// set the custom error messages
		$this->addCustomErrorMessages(array(
										"name.notblank" => $this->translate->_("department_name_error")
       	       						));     
	}
	/*
	 * Relationships for the model
	 */
	public function setUp() {
		parent::setUp(); 
		
		$this->hasOne('UserAccount as head',
						array(
							'local' => 'headid',
							'foreign' => 'id'
						)
		);
		
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
		if(isArrayKeyAnEmptyString('headid', $formvalues)){
			if(isArrayKeyAnEmptyString('headid_old', $formvalues)){
				unset($formvalues['headid']);
			} else {
				$formvalues['headid'] = NULL;
			}
		}
		if(isArrayKeyAnEmptyString('companyid', $formvalues)){
			$formvalues['companyid'] = 1;
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