<?php

class LeaveController extends SecureController  {
	
	/**
	 * @see SecureController::getResourceForACL()
	 *
	 * @return String
	 */
	function getResourceForACL() {
		return "Leave";
	}
	
	# return action
	public function getActionforACL() {
		$action = strtolower($this->getRequest()->getActionName());
		if($action == "updatestatus") {
			return ACTION_EDIT;
		}
		if($action == "events" || $action == "calendar"){
			return ACTION_VIEW;
		}
		return parent::getActionforACL();
	}
	
	function updatestatusAction() {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
	
		$formvalues = $this->_getAllParams(); debugMessage($formvalues);
		$session = SessionWrapper::getInstance();
		$this->_translate = Zend_Registry::get("translate");
	
		$formvalues['id'] = $id = $formvalues['id'];
		$formvalues['dateapproved'] = date("Y-m-d H:i:s", strtotime('now'));
		$formvalues['approvedbyid'] = $session->getVar('userid');
		// debugMessage($formvalues);
		
		$leave = new Leave();
		$leave->populate($id);
	
		$leave->setStatus($formvalues['status']);
		$leave->setDateApproved(DEFAULT_DATETIME);
		$leave->setApprovedByID($session->getVar('userid'));
		if(!isArrayKeyAnEmptyString('reason', $formvalues)){
			$leave->setReason("<br/>Rejected with remarks: ".$formvalues['reason']);
		}
	
		try {
			$leave->save();
			$leave->afterApprove($formvalues['status']);
			$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate($formvalues[SUCCESS_MESSAGE]));
		} catch (Exception $e) {
			// debugMessage('error '.$e->getMessage());
			$session->setVar(ERROR_MESSAGE, $e->getMessage());
		}
		// exit();
		$this->_helper->redirector->gotoUrl(decode($formvalues[URL_SUCCESS]));
	}
}
