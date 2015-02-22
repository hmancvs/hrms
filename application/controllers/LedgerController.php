<?php

class LedgerController extends SecureController  {
	
	/**
	 * @see SecureController::getResourceForACL()
	 *
	 * @return String
	 */
	function getResourceForACL() {
		return "Benefits";
	}
	
	function createAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$session = SessionWrapper::getInstance();
		$this->_translate = Zend_Registry::get("translate");
	
		$formvalues = $this->_getAllParams(); // debugMessage($formvalues); exit();
		$formvalues['id'] = $id = decode($formvalues['id']);
			
		$ledger = new Ledger();
		if(!isArrayKeyAnEmptyString('id', $formvalues)){
			$ledger->populate($id);
			$formvalues['lastupdatedby'] = $session->getVar('userid');
		} else {
			$formvalues['createdby'] = $session->getVar('userid');
		}
			
		$ledger->processPost($formvalues);
		/* debugMessage($ledger->toArray());
		debugMessage('errors are '.$ledger->getErrorStackAsString());
		exit; */
		if($ledger->hasError()){
			$session->setVar(ERROR_MESSAGE, $ledger->getErrorStackAsString());
		} else {
			try {
				$ledger->save(); // debugMessage($ledger->toArray());
				$session->setVar(SUCCESS_MESSAGE, $this->_getParam('successmessage'));
			} catch (Exception $e) {
				$session->setVar(ERROR_MESSAGE, $e->getMessage()); // debugMessage('save error '.$e->getMessage());
			}
		}
	}
}
