<?php
/**
 * Model for payroll
 */
class Payroll extends BaseEntity  {
	
	public function setTableDefinition() {
		parent::setTableDefinition();
		
		$this->setTableName('payroll');
		$this->hasColumn('companyid', 'integer', null, array('default' => NULL));
		$this->hasColumn('type', 'integer', null, array('default' => 4, 'notblank' => true)); // the payment types : daily, weekly, monthly etc. See dropdown lists
		$this->hasColumn('title', 'string', 255);
		$this->hasColumn('payrolldate', 'date', null, array('notblank' => true));
		$this->hasColumn('startdate','date', null, array('notblank' => true));
		$this->hasColumn('enddate','date', null, array('notblank' => true));
		$this->hasColumn('middate','date', null, array('notblank' => true));
		$this->hasColumn('status', 'integer', null, array('default' => 1));
		$this->hasColumn('remarks', 'string', 255);
		$this->hasColumn('url', 'string', 65535);
		$this->hasColumn('ignorelist', 'string', 255);
	}
	
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array("startdate","enddate","payrolldate"));
		
		// set the custom error messages
		$this->addCustomErrorMessages(array(
										"type.notblank" => $this->translate->_("payroll_type_error"),
										"payrolldate.notblank" => $this->translate->_("payroll_payrolldate_error"),
										"startdate.notblank" => $this->translate->_("payroll_startdate_error"),
										"enddate.notblank" => $this->translate->_("payroll_enddate_error")
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
		$this->hasMany('PayrollDetail as details',
				array('local' => 'id',
						'foreign' => 'payrollid'
				)
		);
	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues) {
		// trim spaces from the name field
		if(isArrayKeyAnEmptyString('companyid', $formvalues)){
			unset($formvalues['companyid']);
		}
		if(isArrayKeyAnEmptyString('status', $formvalues)){
			unset($formvalues['status']);
		}
		// debugMessage($formvalues); exit();
		parent::processPost($formvalues);
	}
	# determine if the username has already been assigned
	function payrollExists(){
		$result = $this->existingPayroll(); // debugMessage($result);
		if(isEmptyString($result)){
			return false;
		}
		return true;
	}
	function existingPayroll(){
		$conn = Doctrine_Manager::connection();
		# validate unique username and email
		$id_check = "";
		if(!isEmptyString($this->getID())){
			$id_check = " AND id <> '".$this->getID()."' ";
		}
		$companyid = getCompanyID();
		$query = "SELECT id FROM payroll p WHERE p.companyid = '".$companyid."' AND TO_DAYS(p.startdate) = TO_DAYS('".$this->getStartDate()."') AND TO_DAYS(p.enddate) = TO_DAYS('".$this->getEndDate()."') AND p.type = '".$this->getType()."' ".$id_check;
		// debugMessage($query);
		$result = $conn->fetchOne($query);
		return $result;
	}
	# determine the ledger transactions to delete when a payroll is deleted.
	function getLedgerDeleteTrxns(){
		$q = Doctrine_Query::create()->from('Ledger l')->where("l.payrollid = '".$this->getID()."' AND l.payrolltrigger = 1 ");
		$result = $q->execute();
		return $result;
	}
}

?>