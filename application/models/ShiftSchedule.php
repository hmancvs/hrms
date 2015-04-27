<?php
/**
 * Model for shift
 */
class ShiftSchedule extends BaseRecord  {
	
	public function setTableDefinition() {
		parent::setTableDefinition();
		
		$this->setTableName('shiftschedule');
		$this->hasColumn('userid', 'integer', null);
		$this->hasColumn('sessionid', 'integer', null, array('notblank' => true));
		$this->hasColumn('startdate','date', null, array('notblank' => true));
		$this->hasColumn('enddate','date', null);
		$this->hasColumn('starttime', 'string', 255);
		$this->hasColumn('endtime', 'string', 255);
		$this->hasColumn('status', 'integer', null, array('default' => 0));
		$this->hasColumn('dateadded','datetime', null, array('notblank' => true));
		$this->hasColumn('addedbyid', 'integer', null, array('notblank' => true));
		$this->hasColumn('workingdays', 'string', 50);
	}
	
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		// $this->addDateFields(array("startdate","enddate"));
		
		// set the custom error messages
		$this->addCustomErrorMessages(array(
			"sessionid.notblank" => $this->translate->_("shift_sessionid_error"),
			"startdate.notblank" => $this->translate->_("shift_startdate_error"),
			"dateadded.notblank" => $this->translate->_("shift_dateadded_error"),
			"addedbyid.notblank" => $this->translate->_("shift_addedbyid_error")
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
		$this->hasOne('UserAccount as addedby',
				array(
						'local' => 'addedbyid',
						'foreign' => 'id'
				)
		);
		$this->hasOne('Shift as session',
				array(
						'local' => 'sessionid',
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
		if(isArrayKeyAnEmptyString('starttime', $formvalues)){
			$formvalues['starttime'] = NULL;
		} else {
			$formvalues['starttime'] = date("H:i:s", strtotime($formvalues['starttime']));
		}
		if(isArrayKeyAnEmptyString('endtime', $formvalues)){
			$formvalues['endtime'] = NULL;
		} else {
			$formvalues['endtime'] = date("H:i:s", strtotime($formvalues['endtime']));
		}
		if(isArrayKeyAnEmptyString('startdate', $formvalues)){
			if(!isArrayKeyAnEmptyString('startdate_old', $formvalues)){
				$formvalues['startdate'] = NULL;
			} else {
				unset($formvalues['startdate']);
			}
		} else {
			$formvalues['startdate'] = date('Y-m-d', strtotime($formvalues['startdate']));
		}
		if(isArrayKeyAnEmptyString('enddate', $formvalues)){
			if(!isArrayKeyAnEmptyString('enddate_old', $formvalues)){
				$formvalues['enddate'] = NULL;
			} else {
				unset($formvalues['enddate']);
			}
		} else {
			$formvalues['enddate'] = date('Y-m-d', strtotime($formvalues['enddate']));
		}
		
		if(!isArrayKeyAnEmptyString('workingdaysids', $formvalues)) {
			$formvalues['workingdays'] = implode(',', $formvalues['workingdaysids']);
		} else {
			if(!isArrayKeyAnEmptyString('workingdays_old', $formvalues)){
				if(isArrayKeyAnEmptyString('workingdaysids', $formvalues)) {
					$formvalues['workingdays'] = NULL;
				}
			} else {
				unset($formvalues['workingdays']);
			}
		}
		// debugMessage($formvalues); exit();
		parent::processPost($formvalues);
	}
	# determine if shift is current 
	function getCurrentStatus(){
		$status = 0;
		if(!isEmptyString($this->getUser()->getShift())){
			if($this->getSessionID() == $this->getUser()->getShift() && $this->getStatus() == '1'){
				$status = 1;
			}
		}
		return $status;
	}
	# determine if is active based on status
	function isActive(){
		return $this->getSessionID() == $this->getUser()->getShift() && $this->getStatus() == '1' ? true : false;
	}
	# determine any previous active shifts before activating another 
	function getCurrentActiveShiftsForUser($userid){
		$q = Doctrine_Query::create()->from('ShiftSchedule s')->where("s.userid = '".$userid."' AND s.status = '1' AND s.id <> '".$this->getID()."' ");
		$result = $q->execute();
		return $result;
	}
	# determine number of active shifts
	function countActiveShifts($userid){
		return $this->getCurrentActiveShiftsForUser($userid)->count();
	}
	# determine the days of week for attendance as array
	function getDaysOfWeekArray() {
		return isEmptyString($this->getWorkingDays()) ? array() : explode(',',preg_replace('!\s+!', '', trim($this->getWorkingDays())));
	}
	# determine the days of week for attendance as comma list
	function getAttendanceDaysOfWeek(){
		$listarray = array(); $text = '';
		$allvalues = getDaysOfWeek();
		$thevalues = $this->getDaysOfWeekArray();
		if(isEmptyString($this->getWorkingDays())){
			return $text;
		}
		if(count($thevalues) > 0){
			foreach ($thevalues as $value) {
				if(!isArrayKeyAnEmptyString($value, $allvalues)){
					$listarray[] = $allvalues[$value];
				}
			}
		}
		if(count($listarray) > 0){
			$text = createHTMLCommaListFromArray($listarray, ', ');
		}
		return $text;
	}
}

?>