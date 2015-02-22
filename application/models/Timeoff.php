<?php
/**
 * Model for leave/timeoff
 */
class Timeoff extends BaseEntity  {
	
	public function setTableDefinition() {
		parent::setTableDefinition();
		
		$this->setTableName('timeoff');
		$this->hasColumn('userid', 'integer', null, array('notblank' => true));
		$this->hasColumn('typeid', 'integer', null, array('notblank' => true));
		$this->hasColumn('startdate','date', null, array('notblank' => true));
		$this->hasColumn('starttime', 'string', 15);
		$this->hasColumn('enddate','date', null, array('notblank' => true));
		$this->hasColumn('endtime', 'string', 15);
		$this->hasColumn('returndate','date', null, array('default' => NULL));
		$this->hasColumn('returntime', 'string', 15);
		$this->hasColumn('duration', 'decimal', 10, array('scale' => '2','default' => '0','notblank' => true));
		$this->hasColumn('durationtype', 'integer', null, array('default' => '1'));
		$this->hasColumn('status', 'integer', null, array('default' => NULL));
		$this->hasColumn('remarks', 'string', 1000);
		$this->hasColumn('dateapproved','date', null, array('default' => NULL));
		$this->hasColumn('approvedbyid', 'integer', null, array('default' => NULL));
		$this->hasColumn('reason', 'string', 1000);
	}
	
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array("startdate","enddate","returndate"));
		
		// set the custom error messages
		$this->addCustomErrorMessages(array(
										"userid.notblank" => $this->translate->_("timeoff_userid_error"),
										"type.notblank" => $this->translate->_("timeoff_type_error"),
										"startdate.notblank" => $this->translate->_("leave_startdate_error"),
										"enddate.notblank" => $this->translate->_("timeoff_enddate_error"),
										"duration.notblank" => $this->translate->_("timeoff_duration_error")
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
		$this->hasOne('TimeoffType as type',
						array(
								'local' => 'typeid',
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
		if(isArrayKeyAnEmptyString('returndate', $formvalues)){
			unset($formvalues['returndate']);
		}
		if(isArrayKeyAnEmptyString('durationtype', $formvalues)){
			unset($formvalues['durationtype']);
		}
		if(isArrayKeyAnEmptyString('dateapproved', $formvalues)){
			unset($formvalues['dateapproved']);
		}
		if(isArrayKeyAnEmptyString('approvedbyid', $formvalues)){
			unset($formvalues['approvedbyid']);
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
		if(isArrayKeyAnEmptyString('returntime', $formvalues)){
			unset($formvalues['returntime']);
		} else {
			$formvalues['returntime'] = date("H:i:s", strtotime($formvalues['returntime']));
		}
		// debugMessage($formvalues); // exit();
		parent::processPost($formvalues);
	}
	
	# determine if request has pending approval
	function isPending(){
		return $this->getStatus() == 0 ? true : false;
	}
	# determine if request is approved
	function isApproved(){
		return $this->getStatus() == 1 ? true : false;
	}
	# determine if request is rejected
	function isRejected(){
		return $this->getStatus() == 2 ? true : false;
	}
	# determine if user has completed their leave
	function isOnLeave(){
		return $this->getStatus() == 3 ? true : false;
	}
	# determine if user has completed their leave
	function hasCompletedLeave(){
		return $this->getStatus() == 4 ? true : false;
	}
	# send notifications
	function afterApprove(){
		return true;
	}
}

?>