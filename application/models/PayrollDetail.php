<?php

class PayrollDetail extends BaseRecord  {
	public function setTableDefinition() {
		parent::setTableDefinition();
		$this->setTableName('payrolldetail');
		
		$this->hasColumn('id', 'integer', 11, array('primary' => true, 'autoincrement' => true));
		$this->hasColumn('payrollid', 'integer', 11, array("notblank" => true));
		$this->hasColumn('userid', 'integer', 11, array("notblank" => true));
		
		$this->hasColumn('empstatus', 'string', 15);
		$this->hasColumn('rate', 'decimal', 10, array('scale' => '0','default' => '0'));
		$this->hasColumn('ratetype', 'string', 15, array('default' => 1));
		$this->hasColumn('istimesheetuser', 'integer', null, array('default' => 1));
		$this->hasColumn('payrolltype', 'integer', null, array('default' => 4));
		
		$this->hasColumn('daysworked', 'string', 15);
		$this->hasColumn('hourspending', 'string', 15);
		$this->hasColumn('halfhoursworked', 'string', 15);
		$this->hasColumn('fullhoursworked', 'string', 15);
		$this->hasColumn('leavehrs', 'string', 15);
		$this->hasColumn('sickhrs', 'string', 15);
		
		$this->hasColumn('midgross', 'string', 15);
		$this->hasColumn('endgross', 'string', 15);
		$this->hasColumn('nssf', 'string', 15);
		$this->hasColumn('totalbenefits', 'string', 15);
		$this->hasColumn('totaltaxable', 'string', 15);
		$this->hasColumn('paye', 'string', 15);
		$this->hasColumn('otherdebit', 'string', 15);
		$this->hasColumn('netearning', 'string', 15);
		$this->hasColumn('transport', 'string', 15);
		$this->hasColumn('othercredit', 'string', 15);
		$this->hasColumn('netpay', 'string', 15);
		$this->hasColumn('benefitdetails', 'string', 65535);
		$this->hasColumn('deductiondetails', 'string', 65535);
		$this->hasColumn('recurringtrxns', 'string', 65535);
		$this->hasColumn('isignored', 'integer', null, array('default' => 0));
		$this->hasColumn('comment', 'string', 255);
	}
	
	public function setUp() {
		parent::setUp(); 
		$this->hasOne('Payroll as payroll',
							array('local' => 'payrollid',
									'foreign' => 'id'
							)
						);	
		$this->hasOne('UserAccount as user',
							array('local' => 'userid',
									'foreign' => 'id'
							)
						);	
	}
	
   /**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
	}
	/*
	 * Custom model validation
	 */
	function validate() {
		// execute the column validation 
		parent::validate();
		
		// custom validatio for unique messageid and recipientid combination

	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues){
		# force setting of default none string column values. enum, int and date 	
		if(isArrayKeyAnEmptyString('empstatus', $formvalues)){
			unset($formvalues['empstatus']);
		}
		if(isArrayKeyAnEmptyString('rate', $formvalues)){
			unset($formvalues['rate']);
		}
		if(isArrayKeyAnEmptyString('ratetype', $formvalues)){
			unset($formvalues['ratetype']);
		}
		if(isArrayKeyAnEmptyString('istimesheetuser', $formvalues)){
			unset($formvalues['istimesheetuser']);
		}
		if(isArrayKeyAnEmptyString('payrolltype', $formvalues)){
			unset($formvalues['payrolltype']);
		}
		if(isArrayKeyAnEmptyString('isignored', $formvalues)){
			unset($formvalues['isignored']);
		}
		if(isArrayKeyAnEmptyString('daysworked', $formvalues)){
			unset($formvalues['daysworked']);
		}
		if(isArrayKeyAnEmptyString('hourspending', $formvalues)){
			unset($formvalues['hourspending']);
		}
		if(isArrayKeyAnEmptyString('halfhoursworked', $formvalues)){
			unset($formvalues['halfhoursworked']);
		}
		if(isArrayKeyAnEmptyString('fullhoursworked', $formvalues)){
			unset($formvalues['fullhoursworked']);
		}
		if(isArrayKeyAnEmptyString('leavehrs', $formvalues)){
			unset($formvalues['leavehrs']);
		}
		if(isArrayKeyAnEmptyString('sickhrs', $formvalues)){
			unset($formvalues['sickhrs']);
		}
		if(isArrayKeyAnEmptyString('midgross', $formvalues)){
			unset($formvalues['midgross']);
		}
		if(isArrayKeyAnEmptyString('endgross', $formvalues)){
			unset($formvalues['endgross']);
		}
		if(isArrayKeyAnEmptyString('nssf', $formvalues)){
			unset($formvalues['nssf']);
		}
		if(isArrayKeyAnEmptyString('paye', $formvalues)){
			unset($formvalues['paye']);
		}
		if(isArrayKeyAnEmptyString('otherdebit', $formvalues)){
			unset($formvalues['otherdebit']);
		}
		if(isArrayKeyAnEmptyString('netearning', $formvalues)){
			unset($formvalues['netearning']);
		}
		if(isArrayKeyAnEmptyString('transport', $formvalues)){
			unset($formvalues['transport']);
		}
		if(isArrayKeyAnEmptyString('othercredit', $formvalues)){
			unset($formvalues['othercredit']);
		}
		if(isArrayKeyAnEmptyString('netpay', $formvalues)){
			unset($formvalues['netpay']);
		}
		if(isArrayKeyAnEmptyString('totaltaxable', $formvalues)){
			unset($formvalues['totaltaxable']);
		}
		if(isArrayKeyAnEmptyString('totalbenefits', $formvalues)){
			unset($formvalues['totalbenefits']);
		}
		parent::processPost($formvalues);
	}
}