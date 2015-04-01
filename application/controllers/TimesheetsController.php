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
    	
    	$formvalues = $this->_getAllParams(); // debugMessage($formvalues);
    	$id =  decode($formvalues['id']);
    	$formvalues['id'] = $id;
    	 
    	$timesheet = new Timesheet();
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
    	} else {
    		$timesheet->populate($id);
    		$formvalues['lastupdatedby'] = $session->getVar('userid');
    		if(isArrayKeyAnEmptyString('isrequest', $formvalues)){
    			/* $formvalues['status'] = 1;
	    		if(!isArrayKeyAnEmptyString('timein', $formvalues) && !isArrayKeyAnEmptyString('timeout', $formvalues)){
	    			$formvalues['status'] = 1;
	    		} */
	    		if(isEmptyString($timesheet->getHours())){
	    			$timesheet->setHours($timesheet->getComputedHours());
	    		}
	    		$formvalues['isrequest'] = 0;
    		} else {
    			$formvalues['isrequest'] = 1;
    		}
    	}
    	
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
			
		$formvalues = $this->_getAllParams(); // debugMessage($formvalues);
	
		if(!isArrayKeyAnEmptyString('id', $formvalues)){
			if(isArrayKeyAnEmptyString('status', $formvalues)){
				$formvalues['status'] = 3;
			}
			$timesheet = new Timesheet();
			$timesheet->populate(decode($formvalues['id']));
			$timesheet->setStatus($formvalues['status']);
			$timesheet->setHours($timesheet->getComputedHours());
			$timesheet->setDateApproved(DEFAULT_DATETIME);
			$timesheet->setApprovedByID($session->getVar('userid'));
				
			try {
				$timesheet->save();
				$session->setVar(SUCCESS_MESSAGE, "Successfully Approved");
			} catch (Exception $e) {
				$session->setVar(ERROR_MESSAGE, $e->getMessage());
			}
		}
	
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
					$timesheet_collection->save();
					$msg = "Successfully Approved";
					if($formvalues['status'] == 4){
						$msg = "Successfully Rejected";
					}
					$session->setVar(SUCCESS_MESSAGE, $msg);
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
