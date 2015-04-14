<?php

class CompanyController extends SecureController  {
	
	/**
	 * @see SecureController::getResourceForACL()
	 *
	 * @return String
	 */
	function getResourceForACL() {
		return "Company";
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
	 	if($action == "updatestatus") {
	 		return ACTION_APPROVE;
	 	}
	 	if($action == "logo" || $action == "updatestatus" || $action == "processlogo" || $action == "croplogo") {
	 		return ACTION_EDIT;
	 	}
		return parent::getActionforACL();
    }
    
    public function viewAction() {
    	$session = SessionWrapper::getInstance();
    	$failurl = $this->view->baseUrl("index/accessdenied");
    	$acl = getACLInstance();
    	$id = decode($this->_getParam('id'));
    		
    	if(!isEmptyString($id) && isCompanyAdmin()){
    		if(getCompanyID() != $id){
    			$this->_helper->redirector->gotoUrl($failurl);
    		}
    	}
    	parent::viewAction();
    }
    
    function updatestatusAction() {
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(TRUE);
    
    	$formvalues = $this->_getAllParams(); debugMessage($formvalues);
    	$session = SessionWrapper::getInstance();
    	$this->_translate = Zend_Registry::get("translate");
    
    	$formvalues['id'] = $id = !is_numeric($formvalues['id']) ? decode($formvalues['id']) : $formvalues['id'];
    	$formvalues['dateapproved'] = DEFAULT_DATETIME;
    	$formvalues['approvedbyid'] = $session->getVar('userid');
    	if(!isArrayKeyAnEmptyString('reason', $formvalues)){
    		$formvalues['remarks'] = $formvalues['reason'];
    	}
    	// debugMessage($formvalues);
    
    	$company = new Company();
    	$company->populate($id);
    	$currentstatus = $company->getStatus();
    
    	$company->processPost($formvalues);
    	/* debugMessage('error is '.$company->getErrorStackAsString());
    	debugMessage($company->toArray()); exit(); */
    
    	if($company->hasError()){
    		$session->setVar(ERROR_MESSAGE, $company->getErrorStackAsString());
    	} else {
    		try {
    			$company->save();
    			if($formvalues['status'] == 1 && $currentstatus == 2){
    				$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate('global_approve_success'));
    			}
    			if($formvalues['status'] == 3){
    				$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate('global_reject_success'));
    			}
    			if($formvalues['status'] == 0){
    				$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate('global_deactivate_success'));
    			}
    			if($formvalues['status'] == 1 && $currentstatus == 0){
    				$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate('global_reactivate_success'));
    			}
    			$company->afterApprove($currentstatus);
    		} catch (Exception $e) {
    			$session->setVar(ERROR_MESSAGE, $e->getMessage());
    		}
    	}
    	// exit();
    	$this->_helper->redirector->gotoUrl(decode($formvalues[URL_SUCCESS]));
    }
    
    public function logoAction() {
    }
    
    public function processlogoAction() {
    	// disable rendering of the view and layout so that we can just echo the AJAX output
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(TRUE);
    
    	$session = SessionWrapper::getInstance();
    	$config = Zend_Registry::get("config");
    	$this->_translate = Zend_Registry::get("translate");
    
    	$formvalues = $this->_getAllParams(); debugMessage($this->_getAllParams()); // exit();
    
    	$company = new Company();
    	$company->populate(decode($this->_getParam('id')));
    
    	// only upload a file if the attachment field is specified
    	$upload = new Zend_File_Transfer();
    	// set the file size in bytes
    	$upload->setOptions(array('useByteString' => false));
    
    	// Limit the extensions to the specified file extensions
    	$upload->addValidator('Extension', false, $config->uploads->photoallowedformats);
    	$upload->addValidator('Size', false, $config->uploads->photomaximumfilesize);
    
    	// base path for profile pictures
    	$destination_path = BASE_PATH.DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."company".DIRECTORY_SEPARATOR."comp_";
    
    	// determine if user has destination avatar folder. Else user is editing there picture
    	if(!is_dir($destination_path.$company->getID())){
    		// no folder exits. Create the folder
    		mkdir($destination_path.$company->getID(), 0777);
    	}
    
    	// set the destination path for the image
    	$profilefolder = $company->getID();
    	$destination_path = $destination_path.$profilefolder.DIRECTORY_SEPARATOR."logo";
    
    	if(!is_dir($destination_path)){
    		mkdir($destination_path, 0777);
    	}
    	// create archive folder for each user
    	$archivefolder = $destination_path.DIRECTORY_SEPARATOR."archive";
    	if(!is_dir($archivefolder)){
    		mkdir($archivefolder, 0777);
    	}
    
    	$oldfilename = $company->getLogo();
    
    	// debugMessage($destination_path); exit;
    	$upload->setDestination($destination_path);
    
    	// the profile image info before upload
    	$file = $upload->getFileInfo('logoimage');
    	$uploadedext = findExtension($file['logoimage']['name']);
    	$currenttime = mktime();
    	$currenttime_file = $currenttime.'.'.$uploadedext;
    
    	$thefilename = $destination_path.DIRECTORY_SEPARATOR.'base_'.$currenttime_file;
    	$thelargefilename = $destination_path.DIRECTORY_SEPARATOR.'large_'.$currenttime_file;
    	$updateablefile = $destination_path.DIRECTORY_SEPARATOR.'base_'.$currenttime;
    	$updateablelarge = $destination_path.DIRECTORY_SEPARATOR.'large_'.$currenttime;
    
    	// rename the base image file
    	$upload->addFilter('Rename',  array('target' => $thefilename, 'overwrite' => true)); // exit();
    
    	// process the file upload
    	if($upload->receive()){
    		// debugMessage('Completed');
    		$file = $upload->getFileInfo('logoimage');
    		// debugMessage($file);
    			
    		$basefile = $thefilename;
    		// convert png to jpg
    		if(in_array(strtolower($uploadedext), array('png','PNG','gif','GIF'))){
    			ak_img_convert_to_jpg($thefilename, $updateablefile.'.jpg', $uploadedext);
    			unlink($thefilename);
    		}
    		$basefile = $updateablefile.'.jpg';
    			
    		// new profilenames
    		$newlargefilename = "large_".$currenttime_file;
    		// generate and save thumbnails for sizes 250, 125 and 50 pixels
    		resizeImage($basefile, $destination_path.DIRECTORY_SEPARATOR.'large_'.$currenttime.'.jpg', 400);
    		resizeImage($basefile, $destination_path.DIRECTORY_SEPARATOR.$currenttime.'.jpg', 165);
    			
    		// unlink($thefilename);
    		unlink($destination_path.DIRECTORY_SEPARATOR.'base_'.$currenttime.'.jpg');
    			
    		// exit();
    		// update the useraccount with the new profile images
    		try {
    			$company->setLogo($currenttime.'.jpg');
    			$company->save();
    
    			// check if user already has profile picture and archive it
    			$ftimestamp = current(explode('.', $company->getLogo()));
    
    			$allfiles = glob($destination_path.DIRECTORY_SEPARATOR.'*.*');
    			$currentfiles = glob($destination_path.DIRECTORY_SEPARATOR.'*'.$ftimestamp.'*.*');
    			// debugMessage($currentfiles);
    			$deletearray = array();
    			foreach ($allfiles as $value) {
    				if(!in_array($value, $currentfiles)){
    					$deletearray[] = $value;
    				}
    			}
    			// debugMessage($deletearray);
    			if(count($deletearray) > 0){
    				foreach ($deletearray as $afile){
    					$afile_filename = basename($afile);
    					rename($afile, $archivefolder.DIRECTORY_SEPARATOR.$afile_filename);
    				}
    			}
    
    			$session->setVar(SUCCESS_MESSAGE, "Successfully uploaded. Crop to resize the image and click 'Crop' to save changes.");
    			$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_SUCCESS)));
    		} catch (Exception $e) {
    			$session->setVar(ERROR_MESSAGE, $e->getMessage());
    			$session->setVar(FORM_VALUES, $this->_getAllParams());
    			$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_FAILURE)));
    		}
    	} else {
    		// debugMessage($upload->getMessages());
    		$uploaderrors = $upload->getMessages();
    		$customerrors = array();
    		if(!isArrayKeyAnEmptyString('fileUploadErrorNoFile', $uploaderrors)){
    			$customerrors['fileUploadErrorNoFile'] = "Please browse for image on computer";
    		}
    		if(!isArrayKeyAnEmptyString('fileExtensionFalse', $uploaderrors)){
    			$custom_exterr = sprintf($this->_translate->translate('upload_invalid_ext_error'), $config->uploads->photoallowedformats);
    			$customerrors['fileExtensionFalse'] = $custom_exterr;
    		}
    		if(!isArrayKeyAnEmptyString('fileUploadErrorIniSize', $uploaderrors)){
    			$custom_exterr = sprintf($this->_translate->translate('upload_invalid_size_error'), formatBytes($config->uploads->photomaximumfilesize,0));
    			$customerrors['fileUploadErrorIniSize'] = $custom_exterr;
    		}
    		if(!isArrayKeyAnEmptyString('fileSizeTooBig', $uploaderrors)){
    			$custom_exterr = sprintf($this->_translate->translate('upload_invalid_size_error'), formatBytes($config->uploads->photomaximumfilesize,0));
    			$customerrors['fileSizeTooBig'] = $custom_exterr;
    		}
    		$session->setVar(ERROR_MESSAGE, 'The following errors occured <ul><li>'.implode('</li><li>', $customerrors).'</li></ul>');
    		$session->setVar(FORM_VALUES, $this->_getAllParams());
    		$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_FAILURE)));
    	}
    }
    
    function croplogoAction(){
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(TRUE);
    	$session = SessionWrapper::getInstance();
    	$formvalues = $this->_getAllParams();
    
    	$company = new Company();
    	$company->populate(decode($formvalues['id']));
    	$companyfolder = $company->getID();
    	/* debugMessage($formvalues);
    	debugMessage($company->toArray()); */ // exit;
    
    	$oldfile = "large_".$company->getLogo();
    	$base = BASE_PATH.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR."company".DIRECTORY_SEPARATOR.'comp_'.$companyfolder.''.DIRECTORY_SEPARATOR.'logo'.DIRECTORY_SEPARATOR;
    
    	// debugMessage($company->toArray());
    	$src = $base.$oldfile;
    
    	$currenttime = mktime();
    	$currenttime_file = $currenttime.'.jpg';
    	$newlargefilename = $base."large_".$currenttime_file;
    	$newmediumfilename = $base.$currenttime_file;
    	
    	$newheight = ($formvalues['h'] / $formvalues['w']) * 150;
    	
    	// exit();
    	$image = WideImage::load($src);
    	$cropped1 = $image->crop($formvalues['x1'], $formvalues['y1'], $formvalues['w'], $formvalues['h']);
    	$resized_1 = $cropped1->resize(150, $newheight, 'fill');
    	$resized_1->saveToFile($newlargefilename);
    
    	//$image2 = WideImage::load($src);
    	$cropped2 = $image->crop($formvalues['x1'], $formvalues['y1'], $formvalues['w'], $formvalues['h']);
    	// $resized_2 = $cropped2->resize(165, 165, 'fill');
    	$resized_2 = $cropped2->resize($formvalues['w'], $formvalues['h'], 'fill');
    	$resized_2->saveToFile($newmediumfilename);
    	
    	$company->setLogo($currenttime_file);
    	$company->save();
    		
    	// check if user already has profile picture and archive it
    	$ftimestamp = current(explode('.', $company->getLogo()));
    
    	$allfiles = glob($base.DIRECTORY_SEPARATOR.'*.*');
    	$currentfiles = glob($base.DIRECTORY_SEPARATOR.'*'.$ftimestamp.'*.*');
    	// debugMessage($currentfiles);
    	$deletearray = array();
    	foreach ($allfiles as $value) {
    		if(!in_array($value, $currentfiles)){
    			$deletearray[] = $value;
    		}
    	}
    	// debugMessage($deletearray);
    	if(count($deletearray) > 0){
    		foreach ($deletearray as $afile){
    			$afile_filename = basename($afile);
    			rename($afile, $base.DIRECTORY_SEPARATOR.'archive'.DIRECTORY_SEPARATOR.$afile_filename);
    		}
    	}
    
    	$session->setVar(SUCCESS_MESSAGE, "Successfully updated");
    	if(!isEmptyString($this->_getParam(URL_SUCCESS))){
    		$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_SUCCESS)));
    	}

    		$this->_helper->redirector->gotoUrl($this->view->baseUrl('company/view/id/'.encode($company->getID())));    	
    }
}
