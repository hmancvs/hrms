<?php

class DocumentController extends SecureController  {
	
	/**
	 * @see SecureController::getResourceForACL()
	 *
	 * @return String
	 */
	function getResourceForACL() {
		return "Document";
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
		if($action == "upload") {
			return ACTION_CREATE;
		}
		return parent::getActionforACL();
	}
	
	function createAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$session = SessionWrapper::getInstance();
		$this->_translate = Zend_Registry::get("translate");
		$config = Zend_Registry::get("config");
		
		$formvalues = $this->_getAllParams(); // debugMessage($formvalues); exit();
		$isuserdoc = false;
		$iscompanydoc = false;
		if(!isArrayKeyAnEmptyString('userid', $formvalues)){
			$isuserdoc = true;
			$folderid = $formvalues['userid'];
		} else {
			$iscompanydoc = true;
			$folderid = getCompanyID();
		}
		
		
		if(isset($_FILES["FileInput"]) && $_FILES["FileInput"]["error"] == UPLOAD_ERR_OK && !array_key_exists('submit', $formvalues)) {
			if(!isset($_FILES['FileInput']['name'])){
				$error = "<span class='alert alert-danger blocked'>Error: Please select a File to Upload.</span>";
				$result = array('msg'=>$error, 'result'=>'');
				echo $error; exit;
			}
			
			// if uploading a user document
			if($isuserdoc){
				// base path for user documents
				$destination_path = BASE_PATH.DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."users".DIRECTORY_SEPARATOR."user_";
				// determine if user has destination avatar folder. Else user is editing there picture
				if(!is_dir($destination_path.$folderid)){
					// no folder exits. Create the folder
					mkdir($destination_path.$folderid, 0775);
				}
			}
			
			// if uploading a company document
			if($iscompanydoc){
				// base path for user documents
				$destination_path = BASE_PATH.DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."company".DIRECTORY_SEPARATOR."comp_";
				// determine if user has destination avatar folder. Else user is editing there picture
				if(!is_dir($destination_path.$folderid)){
					// no folder exits. Create the folder
					mkdir($destination_path.$folderid, 0775);
				}
			}
			
			$destination_path = $destination_path.$folderid.DIRECTORY_SEPARATOR."documents";
			if(!is_dir($destination_path)){
				mkdir($destination_path, 0775);
			}
			// create archive folder for each user
			$archivefolder = $destination_path.DIRECTORY_SEPARATOR."archive";
			if(!is_dir($archivefolder)){
				mkdir($archivefolder, 0775);
			}
			
			$oldfile = $_FILES['FileInput']['name'];
			$File_Name = strtolower($oldfile);
			$File_Ext = findExtension($File_Name); //get file extention
			$ext = strtolower($_FILES['FileInput']['type']); // debugMessage($ext);
			$allowedformatsarray = explode(',', str_replace(' ', '', $config->uploads->docallowedformats)); // debugMessage($allowedformatsarray);exit();
		
			$uploadedext = findExtension($File_Name);
			$currenttime = time(); //Random number to be added to name.
			$currenttime_file = $currenttime.'.'.$uploadedext;
		
			$thefilename = $destination_path.DIRECTORY_SEPARATOR.$currenttime_file;
			if(isEmptyString($folderid)){
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
				$error = "<span class='alert alert-danger blocked'>Error: Format '.".$File_Ext."' not supported. Formats allowed include '".$config->uploads->docallowedformats."'</span>";
				$result = array('msg'=>$error, 'result'=>'');
				echo $error; exit;
			}
		
			# move the file
			try {
				move_uploaded_file($_FILES['FileInput']['tmp_name'], $thefilename);
		
				// die('File '.$NewFileName.' Uploaded.');
				$result = array('oldfilename' => $oldfile, 'newfilename'=>$currenttime_file, 'msg'=>'Successfully uploaded', 'result'=>1, 'filesize'=>$size);
				// debugMessage($result);
				echo json_encode($result); exit;
			} catch (Exception $e) {
				$error = 'Error in uploading File '.$File_Name.'. '.$e->getMessage();
				$result = array('msg'=>$error, 'result'=>'');
				echo $error; exit;
			}
		}
		
		if(array_key_exists('submit', $formvalues) || array_key_exists('id', $formvalues)){
			$this->_setParam('uploadedbyid', $session->getVar('userid'));
			$this->_setParam('dateuploaded', DEFAULT_DATETIME);
			$this->_setParam("action", ACTION_CREATE);
			if(!isArrayKeyAnEmptyString('id', $formvalues)){
				$this->_setParam("action", ACTION_EDIT);
			}
			// debugMessage($formvalues); exit();
			parent::createAction();
		}
	}
	
	public function uploadAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
	
		$formvalues = $this->_getAllParams(); // debugMessage($formvalues);
		$config = Zend_Registry::get("config");
		$this->_translate = Zend_Registry::get("translate");
		$session = SessionWrapper::getInstance();
		
	}
}
