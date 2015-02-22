<?php
/**
 * Model for ledger
 */
class Ledger extends BaseEntity  {
	
	public function setTableDefinition() {
		parent::setTableDefinition();
		
		$this->setTableName('ledger');
		$this->hasColumn('userid', 'integer', null, array('notblank' => true));
		$this->hasColumn('companyid', 'integer', null, array('default' => NULL));
		$this->hasColumn('ledgertype', 'integer', null, array('default' => NULL)); // 1 => cash, 2=> time
		$this->hasColumn('trxntype', 'integer', null, array('default' => NULL)); // 1=> credit, 2=>debit 
		$this->hasColumn('trxndate', 'date', null, array('default' => NULL));
		$this->hasColumn('startdate','date', null, array('default' => NULL));
		$this->hasColumn('enddate','date', null, array('default' => NULL));
		
		$this->hasColumn('benefitid', 'integer', null, array('default' => NULL));
		$this->hasColumn('amount', 'decimal', 10, array('scale' => '0','default' => '0'));
		$this->hasColumn('timeoffid', 'integer', null, array('default' => NULL));
		$this->hasColumn('timeofflength', 'decimal', 10, array('scale' => '1','default' => '0'));
		$this->hasColumn('lengthtype', 'integer', null, array('default' => 1)); // 1=>hours, 2=>days
		$this->hasColumn('debitpayroll', 'integer', null, array('default' => 1));
		
		$this->hasColumn('status', 'integer', null, array('default' => 1));
		$this->hasColumn('remarks', 'string', 255);
	}
	
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array("startdate","enddate","trxndate"));
		
		// set the custom error messages
		$this->addCustomErrorMessages(array(
										"userid.notblank" => $this->translate->_("ledger_userid_error")
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
		$this->hasOne('Company as company',
						array(
							'local' => 'companyid',
							'foreign' => 'id'
						)
		);
		$this->hasOne('BenefitType as benefittype',
				array(
						'local' => 'benefitid',
						'foreign' => 'id'
				)
		);
		$this->hasOne('TimeoffType as timeofftype',
				array(
						'local' => 'timeoffid',
						'foreign' => 'id'
				)
		);
		
	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues) {
		// trim spaces from the name field
		if(isArrayKeyAnEmptyString('status', $formvalues)){
			unset($formvalues['status']);
		}
		if(isArrayKeyAnEmptyString('ledgertype', $formvalues)){
			unset($formvalues['ledgertype']);
		} else {
			if($formvalues['ledgertype'] == 1){
				$formvalues['timeoffid'] = NULL;
				$formvalues['timeofflength'] = NULL;
				$formvalues['lengthtype'] = NULL;
				$formvalues['debitpayroll'] = NULL;
			}
			if($formvalues['ledgertype'] == 2){
				$formvalues['amount'] = NULL;
				$formvalues['benefitid'] = NULL;
			}
		}
		if(isArrayKeyAnEmptyString('trxntype', $formvalues)){
			unset($formvalues['trxntype']);
		}
		if(isArrayKeyAnEmptyString('companyid', $formvalues)){
			$formvalues['companyid'] = 1;
		}
		if(isArrayKeyAnEmptyString('benefitid', $formvalues)){
			unset($formvalues['benefitid']);
		} 
		if(isArrayKeyAnEmptyString('timeoffid', $formvalues)){
			unset($formvalues['timeoffid']);
		}
		if(isArrayKeyAnEmptyString('trxndate', $formvalues)){
			unset($formvalues['trxndate']);
		}
		if(isArrayKeyAnEmptyString('startdate', $formvalues)){
			unset($formvalues['startdate']);
		}
		if(isArrayKeyAnEmptyString('enddate', $formvalues)){
			unset($formvalues['enddate']);
		}
		if(isArrayKeyAnEmptyString('timeofflength', $formvalues)){
			unset($formvalues['timeofflength']);
		}
		if(isArrayKeyAnEmptyString('lengthtype', $formvalues)){
			unset($formvalues['lengthtype']);
		}
		if(isArrayKeyAnEmptyString('amount', $formvalues)){
			unset($formvalues['amount']);
		}
		if(isArrayKeyAnEmptyString('debitpayroll', $formvalues)){
			unset($formvalues['debitpayroll']);
		}
		// debugMessage($formvalues); exit();
		parent::processPost($formvalues);
	}
}

?>