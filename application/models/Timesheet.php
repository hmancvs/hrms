<?php
/**
 * Model for Timesheet
 */
class Timesheet extends BaseEntity  {
	
	public function setTableDefinition() {
		parent::setTableDefinition();
		
		$this->setTableName('timesheet');
		$this->hasColumn('userid', 'integer', null, array('notblank' => true));
		$this->hasColumn('datein','date', null);
		$this->hasColumn('timein', 'string', 50);
		$this->hasColumn('dateout','date', null);
		$this->hasColumn('timeout', 'string', 50);
		$this->hasColumn('hours', 'decimal', 10, array('scale' => '2','default' => null));
		$this->hasColumn('status', 'integer', null, array('default' => 1));
		$this->hasColumn('inremarks', 'string', 1000);
		$this->hasColumn('outremarks', 'string', 1000);
		$this->hasColumn('timesheetdate','date', null, array('default' => NULL));
		//$this->hasColumn('datesubmitted', 'string', 255, array('default' => NULL));
		$this->hasColumn('dateapproved','date', null, array('default' => NULL));
		
		$this->hasColumn('hours', 'decimal', 10, array('scale' => '2','default' => '0.00'));
		$this->hasColumn('status', 'integer', null, array('default' => NULL)); // '0'=>'On Duty', '1'=>'Logged', '2'=>'Submitted', '3'=>'Approved', '4'=>'Rejected', '5'=>'Overdue'
		$this->hasColumn('approvedbyid', 'integer', null, array('default' => NULL));
		$this->hasColumn('notes', 'string', 1000);
		$this->hasColumn('comments', 'string', 255);
		$this->hasColumn('payrollid', 'integer', null, array('default' => NULL));
		$this->hasColumn('isrequest', 'integer', null, array('default' => NULL));
	}
	
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array("timesheetdate","dateapproved","datein","dateout","datesubmitted"));
		
		// set the custom error messages
		$this->addCustomErrorMessages(array(
										"userid.notblank" => $this->translate->_("timesheet_userid_error"),
										"hours.notblank" => $this->translate->_("timesheet_hours_error"),
				"timesheetdate.notblank" => $this->translate->_("timesheet_timesheetdate_error")
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
		$this->hasOne('UserAccount as approver',
				array(
						'local' => 'approvedbyid',
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
		if(isArrayKeyAnEmptyString('companyid', $formvalues)){
			unset($formvalues['companyid']);
		}
		if(isArrayKeyAnEmptyString('startdate', $formvalues)){
			unset($formvalues['startdate']);
		}
		if(isArrayKeyAnEmptyString('enddate', $formvalues)){
			unset($formvalues['enddate']);
		}
		if(isArrayKeyAnEmptyString('dateapproved', $formvalues)){
			unset($formvalues['dateapproved']);
		}
		if(isArrayKeyAnEmptyString('datesubmitted', $formvalues)){
			unset($formvalues['datesubmitted']);
		}
		if(isArrayKeyAnEmptyString('timesheetdate', $formvalues)){
			unset($formvalues['timesheetdate']);
		}
		if(isArrayKeyAnEmptyString('approvedbyid', $formvalues)){
			unset($formvalues['approvedbyid']);
		}
		if(isArrayKeyAnEmptyString('datein', $formvalues)){
			unset($formvalues['datein']);
		} else {
			$formvalues['datein'] = date('Y-m-d', strtotime($formvalues['datein']));
		}
		if(isArrayKeyAnEmptyString('dateout', $formvalues)){
			unset($formvalues['dateout']);
		} else {
			$formvalues['dateout'] = date('Y-m-d', strtotime($formvalues['dateout']));
		}
		if(isArrayKeyAnEmptyString('timein', $formvalues)){
			unset($formvalues['timein']);
		} else {
			$formvalues['timein'] = date("H:i:s", strtotime($formvalues['timein']));
		}
		if(isArrayKeyAnEmptyString('timeout', $formvalues)){
			unset($formvalues['timeout']);
		} else {
			$formvalues['timeout'] = date("H:i:s", strtotime($formvalues['timeout']));
		}
		if(isArrayKeyAnEmptyString('payrollid', $formvalues)){
			unset($formvalues['payrollid']);
		}
		if(isArrayKeyAnEmptyString('isrequest', $formvalues)){
			unset($formvalues['isrequest']);
		}
		// debugMessage($formvalues); exit();
		parent::processPost($formvalues);
	}
	
	# determine hours for an attendance record
	function getComputedHours(){
		$hours = 0;
		if(!isEmptyString($this->getTimeIn()) && !isEmptyString($this->getTimeOut())){
			$fulldatein = strtotime($this->getDateIn().' '.$this->getTimeIn()); 
			$fulldateout = strtotime($this->getDateOut().' '.$this->getTimeOut());
			$hours = $fulldateout - $fulldatein; 
			$hours = formatNumber($hours/3600); // debugMessage($hours);
		}
		return $hours;
	}
}

?>