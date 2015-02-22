<?php
/**
 * Model for benefit types
 */
class BenefitType extends BaseEntity  {
	
	public function setTableDefinition() {
		parent::setTableDefinition();
		
		$this->setTableName('benefittype');
		$this->hasColumn('name', 'string', 255, array('notblank' => true));
		$this->hasColumn('companyid', 'integer', null, array('default' => NULL));
		$this->hasColumn('defaultamount', 'string', 25);
		$this->hasColumn('amounttype', 'integer', null, array('default' => 1)); // 1 - Hours, 2 - Days 
	}
	
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		// set the custom error messages
		$this->addCustomErrorMessages(array(
										"name.notblank" => $this->translate->_("global_name_error")
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
		if(isArrayKeyAnEmptyString('defaultamount', $formvalues)){
			unset($formvalues['defaultamount']);
		}
		if(isArrayKeyAnEmptyString('amounttype', $formvalues)){
			unset($formvalues['amounttype']);
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
		$query = "SELECT id FROM benefittype WHERE name = '".$name."' AND name <> '' ".$id_check;
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