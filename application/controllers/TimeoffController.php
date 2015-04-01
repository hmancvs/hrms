<?php

class TimeoffController extends SecureController  {
	
	/**
	 * @see SecureController::getResourceForACL()
	 *
	 * @return String
	 */
	function getResourceForACL() {
		return "Time off";
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
	
		$formvalues = $this->_getAllParams(); 
		$session = SessionWrapper::getInstance();
		$this->_translate = Zend_Registry::get("translate");
	
		$formvalues['id'] = $id = $formvalues['id'];
		$formvalues['dateapproved'] = date("Y-m-d H:i:s", strtotime('now'));
		$formvalues['approvedbyid'] = $session->getVar('userid');
		// debugMessage($formvalues);
		
		$timeoff = new Timeoff();
		$timeoff->populate($id);
	
		$timeoff->processPost($formvalues);
		/* debugMessage('error is '.$timeoff->getErrorStackAsString());
		debugMessage($timeoff->toArray()); exit(); */
	
		if($timeoff->hasError()){
			$session->setVar(ERROR_MESSAGE, $timeoff->getErrorStackAsString());
		} else {
			try {
				$timeoff->save();
				$timeoff->afterApprove($formvalues['status']);
				$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate($formvalues[SUCCESS_MESSAGE]));
			} catch (Exception $e) {
				$session->setVar(ERROR_MESSAGE, $e->getMessage());
			}
		}
		// exit();
		$this->_helper->redirector->gotoUrl(decode($formvalues[URL_SUCCESS]));
	}
}
