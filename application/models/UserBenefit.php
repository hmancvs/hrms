<?php
/**
 * Model for user benefit
 */
class UserBenefit extends BaseRecord  {
	
	public function setTableDefinition() {
		parent::setTableDefinition();
		
		$this->setTableName('userbenefit');
		$this->hasColumn('userid', 'integer', null, array('notblank' => true));
		$this->hasColumn('type', 'integer', null, array('default' => 1));
		
		$this->hasColumn('benefitid', 'integer', null, array('default' => NULL));
		$this->hasColumn('amount', 'string', 10);
		$this->hasColumn('benefitfrequency', 'integer', null, array('default' => NULL)); // 1=>Per Hour, 2=>Per Day, 3=>Per Week,4=>Per Month, 5=>Per Year
		$this->hasColumn('benefitterms', 'integer', null, array('default' => NULL));
		$this->hasColumn('istaxable', 'integer', null, array('default' => 0));
		$this->hasColumn('taxabletype', 'integer', null, array('default' => NULL));
		$this->hasColumn('taxvalue', 'string', 10);
		
		$this->hasColumn('leavetypeid', 'integer', null, array('default' => NULL));
		$this->hasColumn('accrualtype', 'integer', null, array('default' => NULL));
		$this->hasColumn('accrualfrequency', 'integer', null, array('default' => NULL));
		$this->hasColumn('accrualvalue', 'decimal', 10, array('scale' => '0','default' => '0'));
	}
	
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		// set the custom error messages
		$this->addCustomErrorMessages(array(
										"userid.notblank" => "Please specify a User"
       	       						));     
	}
	/*
	 * Relationships for the model
	 */
	public function setUp() {
		parent::setUp(); 
		
		$this->hasOne('UserAccount as user',
						array(
							'local' => 'userid',
							'foreign' => 'id'
						)
		);
	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues) {
		// trim spaces from the name field
		if(isArrayKeyAnEmptyString('type', $formvalues)){
			unset($formvalues['type']);
		}
		if(isArrayKeyAnEmptyString('benefitid', $formvalues)){
			unset($formvalues['benefitid']);
		}
		if(isArrayKeyAnEmptyString('amount', $formvalues)){
			unset($formvalues['amount']);
		}
		if(isArrayKeyAnEmptyString('benefitfrequency', $formvalues)){
			unset($formvalues['benefitfrequency']);
		}
		if(isArrayKeyAnEmptyString('leavetypeid', $formvalues)){
			unset($formvalues['leavetypeid']);
		}
		if(isArrayKeyAnEmptyString('accrualtype', $formvalues)){
			unset($formvalues['accrualtype']);
		}
		if(isArrayKeyAnEmptyString('accrualfrequency', $formvalues)){
			unset($formvalues['accrualfrequency']);
		}
		if(isArrayKeyAnEmptyString('accrualvalue', $formvalues)){
			unset($formvalues['accrualvalue']);
		}
		// debugMessage($formvalues); exit();
		parent::processPost($formvalues);
	}
}

?>