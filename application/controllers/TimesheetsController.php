<?php

class TimesheetsController extends SecureController  {
	
	/**
	 * @see SecureController::getResourceForACL()
	 *
	 * @return String
	 */
	function getResourceForACL() {
		$action = strtolower($this->getRequest()->getActionName());
		if($action == "checkin" || $action == "checkout" || $action == "attendance" || $action == "attendancesearch") {
			return "Attendance";
		}
		return "Timesheets";
	}
	
	/**
	 * Override unknown actions to enable ACL checking
	 *
	 * @see SecureController::getActionforACL()
	 *
	 * @return String
	 */
	public function getActionforACL() {
		$action = strtolower($this->getRequest()->getActionName());
		if($action == "checkin" || $action == "checkout" || $action == "processattendance" || $action == "submit" || $action == "request") {
			if($action == "checkin" && $this->_getParam('type') == 3){
				return ACTION_DELETE;
			}
			return ACTION_CREATE;
		}
		if($action == "attendance" || $action == "attendancesearch") {
			return ACTION_LIST;
		}
		if($action == "approve" || $action == "forapproval") {
			return ACTION_APPROVE;
		}
		return parent::getActionforACL();
	}
	
	function checkinAction(){
		
	}
	
	function processattendanceAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$session = SessionWrapper::getInstance();
    	$config = Zend_Registry::get("config");
    	$this->_translate = Zend_Registry::get("translate");
    	$validshift = false;
    	
    	$formvalues = $this->_getAllParams();
    	/* $formvalues = array(
    	 "id" => "",
    			"successmessage" => "Check-In Successfull",
    			"datein" => "Apr 24, 2015",
    			"timein" => "8:40 PM",
    			"inremarks" => "",
    			"status" => "",
    			"userid" => "93"
    	); */
    	// debugMessage($formvalues);  //  exit;
    	$id =  decode($formvalues['id']);
    	$formvalues['id'] = $id;
    	
    	$timesheet = new Timesheet();
    	$user = new UserAccount();
    	$user->populate($formvalues['userid']);
    	
    	# no shift available at all on profile
    	// validate that user is checking into right shift
    	if(isEmptyString($id)){
    		$checkindate = date('Y-m-d', strtotime($formvalues['datein']));
    		$checkintime = date('H:i:s', strtotime($formvalues['timein']));
    		$checkinfulldate = $checkindate.' '.$checkintime; debugMessage('checkin: '.$checkinfulldate);
    		// if user is already checkin, throw exception
    		if(isCheckedIn($formvalues['userid'], $checkindate)){
    			$message = "Check-In failed. Active session already exists";
    			$session->setVar(ERROR_MESSAGE, $message);
    			exit();
    		}
    		$hasshift = false;
    		$scheduleentry = getSessionEntry($user->getID()); // debugMessage($scheduleentry);
    		if(!isEmptyString($scheduleentry['id']) && !isEmptyString($user->getShift()) && $scheduleentry['status'] == 1){
    			$hasshift = true;
    		}
    		
    		if($hasshift){
    			$shift = new ShiftSchedule();
    			$shift->populate($scheduleentry['id']); // debugMessage($shift->toArray());
    			 
    			$validstartdate = $checkindate;
    			$validstarttime = !isEmptyString($shift->getStartTime()) ? $shift->getStartTime() : $shift->getSession()->getStartTime();
    			$validfullstartdate = $validstartdate.' '.$validstarttime; debugMessage('startin: '.$validfullstartdate);
    			 
    			# compute end date and time
    			$endtime = !isEmptyString($shift->getEndTime()) ? $shift->getEndTime() : $shift->getSession()->getEndTime();
    			$endday = $checkindate;
    			$starthr = date('H', strtotime($validstarttime)); //debugMessage($starthr);
    			$endhr = date('H', strtotime($endtime)); //debugMessage($endhr);
    			if($endhr < $starthr){
	    			$nxtday = date('Y-m-d', strtotime($checkindate." + 1 day"));
	    			$endday = $nxtday;
    			}
    			 
    			$validenddate = $endday;
    			$validendtime = $endtime;
    			$validfullenddate = $validenddate.' '.$validendtime; debugMessage('ending: '.$validfullenddate);
    			 
    			// validate start and end dates for each session
    			$rangevalid = false;
    			if(strtotime($checkinfulldate) >= strtotime($shift->getStartDate().' 00:00:00')){
    				$rangevalid = true;
    				if(!isEmptyString($shift->getEndDate())){
    					$rangevalid = false;
    					if(strtotime($checkinfulldate) <= strtotime($shift->getEndDate().' 23:00:00')){
    						$rangevalid = true;
    					}
    				}
    			}
    			// also check if the days of the week are in the valid range
    			if($rangevalid){
	    			$todaywkno = date('w', strtotime($checkinfulldate)); // debugMessage($todaywkno);
	    			$wkdaysprofiled = $user->getDaysOfWeekArray(); // debugMessage($wkdaysprofiled);
    				if(!isEmptyString($scheduleentry['workingdays'])){
    					$wkdaysprofiled = explode(',',preg_replace('!\s+!', '', trim($scheduleentry['workingdays'])));  // debugMessage($wkdaysprofiled);
    				}
    				if(count($wkdaysprofiled) > 0){
    					if(!in_array($todaywkno, $wkdaysprofiled)){
    						$rangevalid = false;
    					}
    				}
    			}
    			 
    			// now validate the time within the session
    			if($rangevalid){
	    			if(strtotime($checkinfulldate) >= strtotime($validfullstartdate) && strtotime($checkinfulldate) < strtotime($validfullenddate)){
	    				$validshift = true;
	    				$browser = new Browser();
	    				$audit_values = $browser_session = array(
    						"browserdetails" => $browser->getBrowserDetailsForAudit(),
    						"browser"=>$browser->getBrowser(),
    						"version"=>$browser->getVersion(),
    						"useragent"=>$browser->getUserAgent(),
    						"os"=>$browser->getPlatform(),
    						"ismobile"=>$browser->isMobile() ? '1' : 0,
    						"ipaddress"=>$browser->getIPAddress()
	    				);
	    				
	    				$formvalues['sessionid'] = $scheduleentry['sessionid'];
	    				$formvalues['ipaddress'] = $audit_values['ipaddress'];
	    				$formvalues['browser_details'] = json_encode($audit_values);
	    			}
    			}
    		}
    	}
    	
    	/* if(!$validshift){
    		 debugMessage('shift fail');
    	} else {
    		debugMessage('shift passed');
    	}
    	debugMessage($formvalues);
    	exit; */
    		 
    	if(isEmptyString($id)){
    		$formvalues['createdby'] = $session->getVar('userid');
    		if(isArrayKeyAnEmptyString('isrequest', $formvalues)){
    			$formvalues['isrequest'] = 0;
    			$formvalues['status'] = 0;
    			$formvalues['timesheetdate'] = date('Y-m-d', strtotime($formvalues['datein']));
    		} else {
    			$formvalues['isrequest'] = 1;
    			if(isArrayKeyAnEmptyString('status', $formvalues)){
    				$formvalues['status'] = 2;
    			}
    		}
    	}
    		 
    	if(!isEmptyString($id)){
    		$timesheet->populate($id);
    		$formvalues['lastupdatedby'] = $session->getVar('userid');
    		if(isArrayKeyAnEmptyString('isrequest', $formvalues)){
    			if(isEmptyString($timesheet->getHours())){
    				$timesheet->setHours($timesheet->getComputedHours());
    			}
    			$formvalues['isrequest'] = 0;
    		} else {
    			$formvalues['isrequest'] = 1;
    		}
    		$validshift = true;
    	}
    	
    	if($validshift){
    		$timesheet->processPost($formvalues);
    		/* debugMessage($timesheet->toArray());
    		 debugMessage('error '.$timesheet->getErrorStackAsString()); exit(); */
    	
    		if($timesheet->hasError()){
    			$session->setVar(ERROR_MESSAGE, $timesheet->getErrorStackAsString());
    		} else {
    			try {
    				$timesheet->save();
    				$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate($this->_getParam(SUCCESS_MESSAGE)));
    			} catch (Exception $e) {
    				$session->setVar(ERROR_MESSAGE, $e->getMessage());
    			}
    		}
    	} else {
    		$message = "Check-In failed. Invalid shift or session time detected. <br/> Contact admin for resolution.";
    		$session->setVar('contactadmin', 1);
    		if(isAdmin() || isCompanyAdmin()){
    			$session->setVar('contactadmin', '');
    			$url = $this->view->baseUrl('config/shifts/tab/schedules/userid/'.$user->getID());
    			$message = 'Check-In failed. Invalid shift or session time detected. <br/> <a href="'.$url.'">Click here</a> to update schedule for '.$user->getName();
    		}
    		$session->setVar(ERROR_MESSAGE, $message);
    	}
	}
	
	function attendanceAction(){
		
	}
	function attendancesearchAction(){
		$this->_helper->redirector->gotoSimple("attendance", "timesheets",
				$this->getRequest()->getModuleName(),
				array_remove_empty(array_merge_maintain_keys($this->_getAllParams(), $this->getRequest()->getQuery())));
	}
	
	function submitAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$session = SessionWrapper::getInstance();
		$config = Zend_Registry::get("config");
		$this->_translate = Zend_Registry::get("translate");
		 
		$formvalues = $this->_getAllParams(); 
		
		if(!isArrayKeyAnEmptyString('id', $formvalues)){
			$formvalues['status'] = 2;
			// debugMessage($formvalues);
			
			$timesheet = new Timesheet();
			$timesheet->populate(decode($formvalues['id']));
			$timesheet->setStatus($formvalues['status']);
			$timesheet->setDateSubmitted(DEFAULT_DATETIME);
			
			try {
				$timesheet->save();
				$session->setVar(SUCCESS_MESSAGE, "Successfully submitted for Approval");
			} catch (Exception $e) {
				$session->setVar(ERROR_MESSAGE, $e->getMessage());
			}
		}
		
		if(!isArrayKeyAnEmptyString('ids', $formvalues)){
			// debugMessage($formvalues);
			$idsarray = array_remove_empty(explode(',', $formvalues['ids'])); // debugMessage($idsarray);
			$formvalues['status'] = 2;
			
			$timesheet_collection = new Doctrine_Collection(Doctrine_Core::getTable("Timesheet"));
			if(count($idsarray) > 0){
				$hrs = 0;
				foreach ($idsarray as $key => $id){
					$timesheet = new Timesheet();
					$timesheet->populate($id);
					$timesheet->setStatus($formvalues['status']);
					$timesheet->setDateSubmitted(DEFAULT_DATETIME);
					$timesheet_collection->add($timesheet);
				}
				
				try {
					$timesheet_collection->save();
					$session->setVar(SUCCESS_MESSAGE, "Successfully submitted for Approval");
				} catch (Exception $e) {
					$session->setVar(ERROR_MESSAGE, $e->getMessage());
				}
			}
		}
		$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_SUCCESS)));
	}
	
	function approveAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$session = SessionWrapper::getInstance();
		$config = Zend_Registry::get("config");
		$this->_translate = Zend_Registry::get("translate");
			
		$formvalues = $this->_getAllParams(); debugMessage($formvalues); // exit;
	
		if(!isArrayKeyAnEmptyString('id', $formvalues)){
			if(isArrayKeyAnEmptyString('status', $formvalues)){
				$formvalues['status'] = 3;
			}
			$timesheet = new Timesheet();
			$timesheet->populate(decode($formvalues['id']));
			$timesheet->setStatus($formvalues['status']);
			if(!isEmptyString($timesheet->getDateIn()) && !isEmptyString($timesheet->getDateOut())){
				$timesheet->setHours($timesheet->getComputedHours());
			}
			$timesheet->setDateApproved(DEFAULT_DATETIME);
			$timesheet->setApprovedByID($session->getVar('userid'));
			if(!isArrayKeyAnEmptyString('reason', $formvalues)){
				$timesheet->setComments("<br/>Rejected with remarks: ".$formvalues['reason']);
			}
			// debugMessage($timesheet->toArray());
				
			try {
				if($timesheet->save()){
					$session->setVar(SUCCESS_MESSAGE, "Successfully Approved");
				}
				$timesheet->afterApprove();
			} catch (Exception $e) {
				$session->setVar(ERROR_MESSAGE, $e->getMessage());
			}
		}
		// exit;
		if(!isArrayKeyAnEmptyString('ids', $formvalues)){
			$idsarray = array_remove_empty(explode(',', $formvalues['ids'])); // debugMessage($idsarray);
			if(isArrayKeyAnEmptyString('status', $formvalues)){
				$formvalues['status'] = 3;
			}
			$timesheet_collection = new Doctrine_Collection(Doctrine_Core::getTable("Timesheet"));
			if(count($idsarray) > 0){
				$hrs = 0;
				foreach ($idsarray as $key => $id){
					$timesheet = new Timesheet();
					$timesheet->populate($id);
					$timesheet->setStatus($formvalues['status']);
					$timesheet->setHours($timesheet->getComputedHours()); // debugMessage($timesheet->getComputedHours());
					$timesheet->setDateApproved(DEFAULT_DATETIME);
					$timesheet->setApprovedByID($session->getVar('userid'));
					$timesheet_collection->add($timesheet); // debugMessage($timesheet->toArray());
				}
				
				try {
					if($timesheet_collection->save()){
						$msg = "Successfully Approved";
						if($formvalues['status'] == 4){
							$msg = "Successfully Rejected";
						}
						$session->setVar(SUCCESS_MESSAGE, $msg);
						foreach($timesheet_collection as $timesheet){
							$timesheet->afterApprove();
						}
					}
				} catch (Exception $e) {
					$session->setVar(ERROR_MESSAGE, $e->getMessage());
				}
			}
		}
		$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_SUCCESS)));
	}
	
	function forapprovalAction(){
	
	}
	function requestAction(){
	
	}
}
