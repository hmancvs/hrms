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
	
	/**
	 * Override unknown actions to enable ACL checking
	 *
	 * @see SecureController::getActionforACL()
	 *
	 * @return String
	 */
	public function getActionforACL() {
		$action = strtolower($this->getRequest()->getActionName());
		if($action == "request" || $action == "processrequest" || $action == "upload") {
			return ACTION_VIEW;
		}
		if($action == "approve" || $action == "forapproval") {
			return ACTION_APPROVE;
		}
		return parent::getActionforACL();
	}
	
	function createAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$session = SessionWrapper::getInstance();
		$this->_translate = Zend_Registry::get("translate");
	
		$formvalues = $this->_getAllParams(); // debugMessage($formvalues); // exit();
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
	function requestAction(){
	
	}
	public function uploadAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$formvalues = $this->_getAllParams(); // debugMessage($formvalues);
		$config = Zend_Registry::get("config"); 
		$this->_translate = Zend_Registry::get("translate"); 
		$session = SessionWrapper::getInstance();
		$profileid = $formvalues['userid'];
		
		if(isset($_FILES["FileInput"]) && $_FILES["FileInput"]["error"] == UPLOAD_ERR_OK) {
			if(!isset($_FILES['FileInput']['name'])){
		    	$error = "<span class='alert alert-danger blocked'>Error: Please select a File to Upload.</span>";
		    	$result = array('msg'=>$error, 'result'=>'');
		    	echo $error; exit;
		    }
	 		
			// base path for profile pictures
	    	$destination_path = BASE_PATH.DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."users".DIRECTORY_SEPARATOR."user_";
	    	// determine if user has destination avatar folder. Else user is editing there picture
	    	if(!is_dir($destination_path.$profileid)){
	    		// no folder exits. Create the folder
	    		mkdir($destination_path.$profileid, 0775);
	    	}
	    	
	    	$destination_path = $destination_path.$profileid.DIRECTORY_SEPARATOR."benefits";
	    	if(!is_dir($destination_path)){
	    		mkdir($destination_path, 0775);
	    	}
	    	// create archive folder for each user
	    	$archivefolder = $destination_path.DIRECTORY_SEPARATOR."archive";
	    	if(!is_dir($archivefolder)){
	    		mkdir($archivefolder, 0775);
	    	}
			
			$File_Name = strtolower($_FILES['FileInput']['name']);
			$File_Ext = findExtension($File_Name); //get file extention
			$ext = strtolower($_FILES['FileInput']['type']); // debugMessage($ext);
			$allowedformatsarray = explode(',', str_replace(' ', '', $config->uploads->docallowedformats)); // debugMessage($allowedformatsarray);exit();
			
			$uploadedext = findExtension($File_Name);
			$currenttime = time(); //Random number to be added to name.
			$currenttime_file = $currenttime.'.'.$uploadedext;
			
			$thefilename = $destination_path.DIRECTORY_SEPARATOR.$currenttime_file;
			if(isEmptyString($profileid)){
				$destination_path = BASE_PATH.DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."temp";
				if(!is_dir($destination_path)){
					// no folder exits. Create the folder
					mkdir($destination_path, 0775);
				}
				$thefilename = $destination_path.DIRECTORY_SEPARATOR.$currenttime_file;
			}
		
			// check if this is an ajax request
			if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
				$error = "<span class='alert alert-danger blocked'>Error: No Request received.</span>";
				$result = array('msg'=>$error, 'result'=>'');
				echo $error; exit;
			}
			// debugMessage('size '.$_FILES["FileInput"]["size"]);
			// validate maximum allowed size
			$size = $_FILES["FileInput"]["size"];
			if ($size > $config->uploads->docmaximumfilesize) {
				$error = "<span class='alert alert-danger blocked'>Error: Maximum allowed size exceeded.</span>";
				$result = array('msg'=>$error, 'result'=>'');
				echo $error; exit;
			}
			// validate allowed formats
			if(!in_array($File_Ext, $allowedformatsarray)){
				$error = "<span class='alert alert-danger blocked'>Error: Format '".$File_Ext."' not supported. Only formats '".$config->uploads->docallowedformats."' allowed</span>";
				$result = array('msg'=>$error, 'result'=>'');
				echo $error; exit;
			}
			
			# move the file
			try {
				move_uploaded_file($_FILES['FileInput']['tmp_name'], $thefilename);
			
				// die('File '.$NewFileName.' Uploaded.');
				$result = array('oldfilename' =>'', 'newfilename'=>$currenttime_file, 'msg'=>'Successfully uploaded', 'result'=>1, 'filesize'=>$size);
				// debugMessage($result);
				echo json_encode($result); exit;
			} catch (Exception $e) {
				$error = 'Error in uploading File '.$File_Name.'. '.$e->getMessage();
				$result = array('msg'=>$error, 'result'=>'');
				echo $error; exit;
			}
		}
	}
	function processrequestAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$session = SessionWrapper::getInstance();
		$this->_translate = Zend_Registry::get("translate");
		$config = Zend_Registry::get("config");
		
		$formvalues = $this->_getAllParams(); // debugMessage($formvalues); // exit();
		$formvalues['id'] = $id = decode($formvalues['id']);
		$profilefolder = $formvalues['userid'];
		
		$ledger = new Ledger();
		if(!isArrayKeyAnEmptyString('id', $formvalues)){
			$ledger->populate($id);
			$formvalues['lastupdatedby'] = $session->getVar('userid');
		} else {
			$formvalues['createdby'] = $session->getVar('userid');
		}
		if(stringContains('>', $formvalues['filename'])){
			$formvalues['filename'] = '';
		}
		
		$ledger->processPost($formvalues);
		/* debugMessage($ledger->toArray());
		debugMessage('errors are '.$ledger->getErrorStackAsString()); exit(); */
		
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
	
	function approveAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$session = SessionWrapper::getInstance();
		$config = Zend_Registry::get("config");
		$this->_translate = Zend_Registry::get("translate");
			
		$formvalues = $this->_getAllParams(); // debugMessage($formvalues);
		$id = decode($formvalues['id']);
		$formvalues['id'] = $id;
		$successmessage = "";
		
		if(!isArrayKeyAnEmptyString('id', $formvalues)){
			if(isArrayKeyAnEmptyString('status', $formvalues)){
				$formvalues['status'] = 1;
			}
			
			$ledger = new Ledger();
			$ledger->populate($id);
			if(!isArrayKeyAnEmptyString('reason', $formvalues)){
				$formvalues['remarks'] = $ledger->getRemarks()."<br/><br/> Rejected: ".$formvalues['reason'];
			}
			
			$ledger->processPost($formvalues);
			/* debugMessage($ledger->toArray());
			debugMessage('errors are '.$ledger->getErrorStackAsString());
			exit(); */
			try {
				$ledger->save();
				$msg = "Successfully Approved";
				if($formvalues['status'] == 4){
					$msg = "Successfully Rejected";
				}
				$session->setVar(SUCCESS_MESSAGE, $msg);
			} catch (Exception $e) {
				$session->setVar(ERROR_MESSAGE, $e->getMessage());
			}
		}
	
		$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_SUCCESS)));
	}
	
	function forapprovalAction(){
	
	}
}
