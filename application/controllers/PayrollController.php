<?php

class PayrollController extends SecureController  {
	/**
	 * Get the name of the resource being accessed
	 *
	 * @return String
	 */
	function getActionforACL() {
		$action = strtolower($this->getRequest()->getActionName());
		if($action == "history" || $action = "historysearch") {
			return ACTION_LIST;
		}
		return parent::getActionforACL();
	}
	
	function historyAction(){
		
	}
	
	function historylistsearchAction(){
		
	}
}
