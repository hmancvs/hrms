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
	
	function eventsAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$config = Zend_Registry::get("config");
		$session = SessionWrapper::getInstance();
		$formvalues = $this->_getAllParams();
		$acl = getACLInstance();
		
		$user = new UserAccount();
		$user->populate($formvalues['id']);
		$events = getTimeoffRequests($user->getID(), $config->system->yearstart, $config->system->yearend); // debugMessage($events);
		$jsondata = array();
		$i = 0;
		if(count($events) > 0){
			// $jsondata = $events;
			$timeoffoptions = getHoursDaysDropdown();
			foreach ($events as $key => $value){
				$jsondata[$key]['id'] = $value['id'];
				$unit = '';
				if(!isArrayKeyAnEmptyString($value['durationtype'], $timeoffoptions)){
					$unit = ' ('.number_format($value['duration'], 2).' Hours Off)';
				}
				$jsondata[$key]['title'] = $value['user'].$unit;
				$jsondata[$key]['start'] = $value['startdate'].'T'.$value['starttime'];
				$jsondata[$key]['end'] = $value['enddate'].'T'.$value['endtime'];
				if((isTimesheetEmployee() && $value['userid'] == $session->getVar('userid')) || ($acl->checkPermission('Time off', ACTION_APPROVE))){
					// $jsondata[$key]['url'] = $this->view->serverUrl($this->view->baseUrl('timeoff/view/id/'.encode($value['id'])));
				}
			}
		}	
		
		// debugMessage($jsondata);
		echo json_encode($jsondata); 
	}
	
	function calendarAction(){
		
	}
}
