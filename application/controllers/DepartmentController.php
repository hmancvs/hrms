<?php

class DepartmentController extends SecureController {
	
	/**
	 * @see SecureController::getResourceForACL()
	 *
	 * Return the Application Settings since we need to make the url more friendly
	 *
	 * @return String
	 */
	function getResourceForACL() {
		return "Departments";
	}
	
	function createAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$session = SessionWrapper::getInstance();
		$this->_translate = Zend_Registry::get("translate");
		
		$formvalues = $this->_getAllParams(); // debugMessage($formvalues); exit();
		$formvalues['id'] = $id = decode($formvalues['id']);
		 
		$department = new Department();
		if(!isArrayKeyAnEmptyString('id', $formvalues)){
			$department->populate($id);
			$formvalues['lastupdatedby'] = $session->getVar('userid');
		} else {
			$formvalues['createdby'] = $session->getVar('userid');
		}
		 
		$department->processPost($formvalues);
		 
		if($department->hasError()){
			$session->setVar(ERROR_MESSAGE, $department->getErrorStackAsString());
		} else {
			try {
				$department->save(); // debugMessage($department->toArray());
				$session->setVar(SUCCESS_MESSAGE, $this->_getParam('successmessage'));
			} catch (Exception $e) {
				$session->setVar(ERROR_MESSAGE, $e->getMessage()); // debugMessage('save error '.$e->getMessage());
			}
		}
	}
}