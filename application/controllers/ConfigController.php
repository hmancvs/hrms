<?php
class ConfigController extends SecureController   {

	/**
	 * @see SecureController::getResourceForACL()
	 * 
	 * Return the Application Settings since we need to make the url more friendly 
	 *
	 * @return String
	 */
	function getResourceForACL() {
		return "System Variables"; 
	}
	/**
	 * Get the name of the resource being accessed 
	 *
	 * @return String 
	 */
	function getActionforACL() {
		$action = strtolower($this->getRequest()->getActionName()); 
		if($action == "processvariables" || $action == "processglobalconfig" || $action == "add" || $action = "timeoff" || $action = "timeoffcreate" || $action = "timeoffindex" || $action = "shifts" || $action = "shiftscreate" || $action = "shiftsindex"){
			return ACTION_EDIT;
		}
		if($action == "variables" || $action == "globalconfig" || $action = "timeofflistsearch") {
			return ACTION_LIST; 
			// return ACTION_VIEW;
		}
		return parent::getActionforACL(); 
	}
	
	function addAction(){
    	// parent::listAction();
    }
    
	function variablesAction(){
    	// parent::listAction();
		if($this->_getParam('type') == 10){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl('config/timeoff'));
		}
		if($this->_getParam('type') == 11){
    		$this->_helper->redirector->gotoUrl($this->view->baseUrl('department/list'));
    	}
    	if($this->_getParam('type') == 12){
    		$this->_helper->redirector->gotoUrl($this->view->baseUrl('config/shifts'));
    	}
    }
    
	function variablessearchAction(){
		$this->_helper->redirector->gotoSimple("variables", "config", 
    											$this->getRequest()->getModuleName(),
    											array_remove_empty(array_merge_maintain_keys($this->_getAllParams(), $this->getRequest()->getQuery())));
	}
	
	function processvariablesAction(){
		$session = SessionWrapper::getInstance(); 
     	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$formvalues = $this->_getAllParams(); // debugMessage($formvalues); exit;
		if(isArrayKeyAnEmptyString('noreload', $formvalues)){
			$hasnoreload = false; 	
		} else {
			$hasnoreload = true;
		}
		
		$haserror = false;
		if(isArrayKeyAnEmptyString('value', $formvalues) && !$hasnoreload){
			$haserror = true;
			$session->setVar(ERROR_MESSAGE, 'Error: No value specified for addition');
			$session->setVar(FORM_VALUES, $formvalues);
			$this->_helper->redirector->gotoUrl($this->view->baseUrl('config/variables/'.$formvalues['lookupid']));
		}
		$successurl = $this->view->baseUrl('config/variables/type/'.$formvalues['lookupid']);
		$type_ext = '';
		$alias = '';
		if(!isArrayKeyAnEmptyString('alias', $formvalues)){
			$alias= trim($formvalues['alias']);
			if($alias == 'undefined'){
				$alias = '';
			}
		}
		if($formvalues['lookupid'] == 7){
			if(!isArrayKeyAnEmptyString('departmentid', $formvalues)){
				$alias = $formvalues['departmentid'];
			}
		}
		// exit;
		// debugMessage()
		switch ($formvalues['lookupid']){
			case 9:
				$formvalues['defaultamount'] = decode($formvalues['alias']);
				$formvalues['amounttype'] = $formvalues['alias2'];
				$formvalues['name'] = decode(trim($formvalues['value']));
				
				$benefittype = new BenefitType();
				if(!isArrayKeyAnEmptyString('id', $formvalues)){
					$benefittype->populate($formvalues['id']);
					$formvalues['lastupdatedby'] = $session->getVar('userid');
				} else {
					$formvalues['createdby'] = $session->getVar('userid');
				}
				$benefittype->processPost($formvalues);
				/* debugMessage($benefittype->toArray());
				debugMessage('errors are '.$benefittype->getErrorStackAsString()); exit(); */
				
				$result = array('id'=>'', 'name'=>'', 'error'=>'');
				if($benefittype->hasError()){
					$session->setVar(ERROR_MESSAGE, $benefittype->getErrorStackAsString());
					$session->setVar(FORM_VALUES, $formvalues);
					$result['error'] = $benefittype->getErrorStackAsString();
				} else {
					try {
						$benefittype->save(); // debugMessage($benefittype->toArray()); exit;
						$result = array('id'=>$benefittype->getID(), 'name'=>$benefittype->getName(), 'alias'=>$benefittype->getdefaultamount(), 'alias2'=>$benefittype->getamounttype());
						$session->setVar(SUCCESS_MESSAGE, "Successfully saved");
						
					} catch (Exception $e) {
						$session->setVar(ERROR_MESSAGE, $e->getMessage()."<br />".$benefittype->getErrorStackAsString());
						$session->setVar(FORM_VALUES, $formvalues);
						$result['error'] = $benefittype->getErrorStackAsString();
					}
				}
				break;
				
			case 11:
				$formvalues['name'] = trim($formvalues['value']);
				$department = new Department();
				if(!isArrayKeyAnEmptyString('id', $formvalues)){
					$department->populate($formvalues['id']);
					$formvalues['lastupdatedby'] = $session->getVar('userid');
				} else {
					$formvalues['createdby'] = $session->getVar('userid');
				}
				$department->processPost($formvalues);
				/* debugMessage($department->toArray());
				debugMessage('errors are '.$department->getErrorStackAsString()); // exit(); */
			
				$result = array('id'=>'', 'name'=>'', 'error'=>'');
				if($department->hasError()){
					$session->setVar(ERROR_MESSAGE, $department->getErrorStackAsString());
					$session->setVar(FORM_VALUES, $formvalues);
					$result['error'] = $department->getErrorStackAsString();
				} else {
					try {
						$department->save(); 
						$result = array('id'=>$department->getID(), 'name'=>$department->getName(), 'error'=>'');
						$session->setVar(SUCCESS_MESSAGE, "Successfully saved");
			
					} catch (Exception $e) {
						$session->setVar(ERROR_MESSAGE, $e->getMessage()."<br />".$department->getErrorStackAsString());
						$session->setVar(FORM_VALUES, $formvalues);
						$result['error'] = $department->getErrorStackAsString();
					}
				}
				break;
					
			default:
				$lookupvalue = new LookupTypeValue();
				$lookuptype = new LookupType();
				$lookuptype->populate($formvalues['lookupid']);
					
				$index = '';
				if($hasnoreload){
					$index = $lookuptype->getNextInsertIndex();
					$value  = trim($formvalues['value']);
				} else {
					if(!isArrayKeyAnEmptyString('index', $formvalues)){
						$index = $formvalues['index'];
					} else {
						$index = $lookuptype->getNextInsertIndex();
					}
					$value  = addslashes(decode(trim($formvalues['value'])));
				}
				
				$dataarray = array('id' => $formvalues['id'],
									'lookuptypeid' => $formvalues['lookupid'], 
									'lookuptypevalue' => $index, 
									'lookupvaluedescription' => $value,
									'alias' => $alias,
									'createdby' => $session->getVar('userid')
							);
				// debugMessage($dataarray);
				if(!isArrayKeyAnEmptyString('id', $formvalues)){
					$lookupvalue->populate($formvalues['id']);
					$beforesave = $lookupvalue->toArray(); // debugMessage($beforesave);
				}
				// unset($dataarray['id']);
				$lookupvalue->processPost($dataarray);
				/* debugMessage($lookupvalue->toArray());
		    	debugMessage('errors are '.$lookupvalue->getErrorStackAsString()); exit(); */
				
		    	$result = array('id'=>'', 'name'=>'', 'error' => '');
				if($lookupvalue->hasError()){
					$haserror = true;
					$session->setVar(ERROR_MESSAGE, $lookupvalue->getErrorStackAsString());
					$session->setVar(FORM_VALUES, $formvalues);
					$result['error'] = $lookupvalue->getErrorStackAsString();
				} else {
					try {
						$lookupvalue->save();
						if(!$hasnoreload){
							$url = $this->view->serverUrl($this->view->baseUrl("config/variables/lookupid/".$formvalues['lookupid']));
							$module = '0';
							if(isArrayKeyAnEmptyString('id', $formvalues)){
								$session->setVar(SUCCESS_MESSAGE, "Successfully saved");
								$type = SYSTEM_ADDVARIABLE;
								$usecase = '0.1';
								$details = 'Variable - <b>'.$lookupvalue->getlookupvaluedescription().' </b>('.$lookupvalue->getLookupType()->getdisplayname().') addded';
							} else {
								$session->setVar(SUCCESS_MESSAGE, "Successfully updated");
								$type = SYSTEM_UPDATEVARIABLE;
								$usecase = '0.2';
								$details = 'Variable - <b>'.$lookupvalue->getlookupvaluedescription().' </b>('.$lookupvalue->getLookupType()->getdisplayname().') updated';
								$prejson = json_encode($beforesave);
								$lookupvalue->clearRelated();
								$after = $lookupvalue->toArray(); // debugMessage($after);
								$postjson = json_encode($after); // debugMessage($postjson);
								$diff = array_diff($beforesave, $after);  // debugMessage($diff);
								$jsondiff = json_encode($diff); // debugMessage($jsondiff);
							}
							
							$browser = new Browser();
							$audit_values = $session->getVar('browseraudit');
							$audit_values['module'] = $module;
							$audit_values['usecase'] = $usecase;
							$audit_values['transactiontype'] = $type;
							$audit_values['status'] = "Y";
							$audit_values['userid'] = $session->getVar('userid');
							$audit_values['transactiondetails'] = $details;
							$audit_values['url'] = $url;
							if(!isArrayKeyAnEmptyString('id', $formvalues)){
								$audit_values['isupdate'] = 1;
								$audit_values['prejson'] = $prejson;
								$audit_values['postjson'] = $postjson;
								$audit_values['jsondiff'] = $jsondiff;
							}
							// debugMessage($audit_values);
							$this->notify(new sfEvent($this, $type, $audit_values));
						}
						$result = array('id'=>$lookupvalue->getlookuptypevalue(), 'name'=>$lookupvalue->getlookupvaluedescription(), 'alias'=>$lookupvalue->getalias(), 'error'=>'');
					} catch (Exception $e) {
						$session->setVar(ERROR_MESSAGE, $e->getMessage()."<br />".$lookupvalue->getErrorStackAsString());
						$session->setVar(FORM_VALUES, $formvalues);
					}
				}
				break;
		}
		// debugMessage($successurl);exit(); 
		
		if(!$hasnoreload){
			$this->_helper->redirector->gotoUrl($successurl);	
		} else {
			echo json_encode($result);
		}
	}
    
	function globalconfigAction(){
    	// parent::listAction();
    }
    
	function globalconfigsearchAction(){
		$this->_helper->redirector->gotoSimple("globalconfig", "config", 
    											$this->getRequest()->getModuleName(),
    											array_remove_empty(array_merge_maintain_keys($this->_getAllParams(), $this->getRequest()->getQuery())));
	}
	
	function processglobalconfigAction(){
		$session = SessionWrapper::getInstance(); 
     	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$formvalues = $this->_getAllParams();
		$successurl = decode($formvalues[URL_SUCCESS]);
		// debugMessage($formvalues);
		$postarray = array();
		for ($i = 1; $i <= $formvalues['t']; $i++) {
			$postarray[$i]['id'] = $formvalues['id_'.$i];
			$postarray[$i]['displayname'] = $formvalues['displayname_'.$i];
			$postarray[$i]['optionvalue'] = $formvalues['optionvalue_'.$i];
		}

		$config_collection = new Doctrine_Collection(Doctrine_Core::getTable("AppConfig"));
		foreach ($postarray as $line){
			$appconfig = new AppConfig();
			$appconfig->populate($line['id']);

			$appconfig->processPost($line);
			/*debugMessage('error is '.$appconfig->getErrorStackAsString());
			debugMessage($appconfig->toArray());*/
			if($appconfig->isValid()) {
				$config_collection->add($appconfig);
			}	
		}
		// check for atleast one option and save
		if($config_collection->count() > 0){
			try {
				// debugMessage($config_collection->toArray());
				$config_collection->save();
				$session->setVar(SUCCESS_MESSAGE, $formvalues[SUCCESS_MESSAGE]);
				
				# clear cache after updating options
				$temppath = APPLICATION_PATH.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR; // debugMessage($temppath);
				$files = glob($temppath.'zend_cache---config*');
				foreach($files as $file){
					debugMessage($file);
					if(is_file($file)){
						unlink($file);
				  	}
				}
			} catch (Exception $e) {
				$session->setVar(ERROR_MESSAGE, "An error occured in updating the parameters. ".$e->getMessage());
			}
		}
		// debugMessage($successurl);
		$this->_helper->redirector->gotoUrl($successurl);	
		// exit();
	}
	
	function timeoffAction(){
		
	}
	function timeoffcreateAction(){
		$session = SessionWrapper::getInstance();
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
	
		// parent::createAction();
		$formvalues = $this->_getAllParams(); // debugMessage($formvalues); exit();
		$formvalues['id'] = $id = decode($formvalues['id']);
			
		$timeoff = new TimeoffType();
		if(!isArrayKeyAnEmptyString('id', $formvalues)){
			$timeoff->populate($id);
			$formvalues['lastupdatedby'] = $session->getVar('userid');
		} else {
			$formvalues['createdby'] = $session->getVar('userid');
		}
			
		$timeoff->processPost($formvalues);
		if($timeoff->hasError()){
			/* debugMessage($timeoff->toArray());
			 debugMessage('errors are '.$timeoff->getErrorStackAsString());
			exit(); */
			$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_FAILURE)));
		}
		
		try {
			$timeoff->save(); //debugMessage($timeoff->toArray());
			$session->setVar(SUCCESS_MESSAGE, $this->_getParam('successmessage'));
			$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_SUCCESS)));
		} catch (Exception $e) {
			$session->setVar(ERROR_MESSAGE, $e->getMessage()); 
			//debugMessage('save error '.$e->getMessage());
			$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_FAILURE)));
		}
	}
	function timeoffindexAction(){
		
	}
	function timeofflistsearchAction(){
		$this->_helper->redirector->gotoSimple("timeoff", "config",
				$this->getRequest()->getModuleName(),
				array_remove_empty(array_merge_maintain_keys($this->_getAllParams(), $this->getRequest()->getQuery())));
	}
	
	function shiftsAction(){
	
	}
	function shiftscreateAction(){
		$session = SessionWrapper::getInstance();
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
	
		// parent::createAction();
		$formvalues = $this->_getAllParams(); debugMessage($formvalues); // exit();
		$formvalues['id'] = $id = decode($formvalues['id']);
			
		$shift = new Shift();
		if(!isArrayKeyAnEmptyString('id', $formvalues)){
			$shift->populate($id);
			$formvalues['lastupdatedby'] = $session->getVar('userid');
		} else {
			$formvalues['createdby'] = $session->getVar('userid');
		}
			
		$shift->processPost($formvalues); debugMessage($shift->toArray());
		if($shift->hasError()){
			// debugMessage('errors are '.$shift->getErrorStackAsString()); exit();
			$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_FAILURE)));
		}
		// exit;
		try {
			$shift->save(); //debugMessage($timeoff->toArray());
			$session->setVar(SUCCESS_MESSAGE, $this->_getParam('successmessage'));
			$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_SUCCESS)));
		} catch (Exception $e) {
			$session->setVar(ERROR_MESSAGE, $e->getMessage());
			//debugMessage('save error '.$e->getMessage());
			$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_FAILURE)));
		}
	}
	function shiftsindexAction(){
	
	}
	function shiftslistsearchAction(){
		$this->_helper->redirector->gotoSimple("shifts", "config",
				$this->getRequest()->getModuleName(),
				array_remove_empty(array_merge_maintain_keys($this->_getAllParams(), $this->getRequest()->getQuery())));
	}
}

