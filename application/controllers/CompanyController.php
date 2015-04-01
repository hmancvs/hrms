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
    
    function pictureAction() {}
    
    public function processpictureAction() {
    	// disable rendering of the view and layout so that we can just echo the AJAX output
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(TRUE);
    
    	$session = SessionWrapper::getInstance();
    	$config = Zend_Registry::get("config");
    	$this->_translate = Zend_Registry::get("translate");
    
    	$formvalues = $this->_getAllParams();
    
    	//debugMessage($this->_getAllParams());
    	$user = new UserAccount();
    	$user->populate(decode($this->_getParam('id')));
    
    	// only upload a file if the attachment field is specified
    	$upload = new Zend_File_Transfer();
    	// set the file size in bytes
    	$upload->setOptions(array('useByteString' => false));
    
    	// Limit the extensions to the specified file extensions
    	$upload->addValidator('Extension', false, $config->uploads->photoallowedformats);
    	$upload->addValidator('Size', false, $config->uploads->photomaximumfilesize);
    
    	// base path for profile pictures
    	$destination_path = BASE_PATH.DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."users".DIRECTORY_SEPARATOR."user_";
    
    	// determine if user has destination avatar folder. Else user is editing there picture
    	if(!is_dir($destination_path.$user->getID())){
    		// no folder exits. Create the folder
    		mkdir($destination_path.$user->getID(), 0777);
    	}
    
    	// set the destination path for the image
    	$profilefolder = $user->getID();
    	$destination_path = $destination_path.$profilefolder.DIRECTORY_SEPARATOR."avatar";
    
    	if(!is_dir($destination_path)){
    		mkdir($destination_path, 0777);
    	}
    	// create archive folder for each user
    	$archivefolder = $destination_path.DIRECTORY_SEPARATOR."archive";
    	if(!is_dir($archivefolder)){
    		mkdir($archivefolder, 0777);
    	}
    
    	$oldfilename = $user->getProfilePhoto();
    
    	//debugMessage($destination_path);
    	$upload->setDestination($destination_path);
    
    	// the profile image info before upload
    	$file = $upload->getFileInfo('profileimage');
    	$uploadedext = findExtension($file['profileimage']['name']);
    	$currenttime = time();
    	$currenttime_file = $currenttime.'.'.$uploadedext;
    
    	$thefilename = $destination_path.DIRECTORY_SEPARATOR.'base_'.$currenttime_file;
    	$thelargefilename = $destination_path.DIRECTORY_SEPARATOR.'large_'.$currenttime_file;
    	$updateablefile = $destination_path.DIRECTORY_SEPARATOR.'base_'.$currenttime;
    	$updateablelarge = $destination_path.DIRECTORY_SEPARATOR.'large_'.$currenttime;
    	//debugMessage($thefilename);
    	// rename the base image file
    	$upload->addFilter('Rename',  array('target' => $thefilename, 'overwrite' => true));
    	// exit();
    	// process the file upload
    	if($upload->receive()){
    		// debugMessage('Completed');
    		$file = $upload->getFileInfo('profileimage');
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
    		resizeImage($basefile, $destination_path.DIRECTORY_SEPARATOR.'medium_'.$currenttime.'.jpg', 165);
    		 
    		// unlink($thefilename);
    		unlink($destination_path.DIRECTORY_SEPARATOR.'base_'.$currenttime.'.jpg');
    		 
    		// exit();
    		// update the user with the new profile images
    		try {
    			$user->setProfilePhoto($currenttime.'.jpg');
    			$user->save();
    
    			// check if user already has profile picture and archive it
    			$ftimestamp = current(explode('.', $user->getProfilePhoto()));
    
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
    
    			$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate("global_update_success"));
    			$this->_helper->redirector->gotoUrl($this->view->baseUrl("profile/picture/id/".encode($user->getID()).'/crop/1'));
    		} catch (Exception $e) {
    			$session->setVar(ERROR_MESSAGE, $e->getMessage());
    			$session->setVar(FORM_VALUES, $this->_getAllParams());
    			$this->_helper->redirector->gotoUrl($this->view->baseUrl('profile/picture/id/'.encode($user->getID())));
    		}
    	} else {
    		// debugMessage($upload->getMessages());
    		$uploaderrors = $upload->getMessages();
    		$customerrors = array();
    		if(!isArrayKeyAnEmptyString('fileUploadErrorNoFile', $uploaderrors)){
    			$customerrors['fileUploadErrorNoFile'] = "Please browse for image on computer";
    		}
    		if(!isArrayKeyAnEmptyString('fileExtensionFalse', $uploaderrors)){
    			$custom_exterr = sprintf($this->_translate->translate('global_invalid_ext_error'), $config->uploads->photoallowedformats);
    			$customerrors['fileExtensionFalse'] = $custom_exterr;
    		}
    		if(!isArrayKeyAnEmptyString('fileUploadErrorIniSize', $uploaderrors)){
    			$custom_exterr = sprintf($this->_translate->translate('global_invalid_size_error'), formatBytes($config->uploads->photomaximumfilesize,0));
    			$customerrors['fileUploadErrorIniSize'] = $custom_exterr;
    		}
    		if(!isArrayKeyAnEmptyString('fileSizeTooBig', $uploaderrors)){
    			$custom_exterr = sprintf($this->_translate->translate('global_invalid_size_error'), formatBytes($config->uploads->photomaximumfilesize,0));
    			$customerrors['fileSizeTooBig'] = $custom_exterr;
    		}
    		$session->setVar(ERROR_MESSAGE, 'The following errors occured <ul><li>'.implode('</li><li>', $customerrors).'</li></ul>');
    		$session->setVar(FORM_VALUES, $this->_getAllParams());
    		 
    		$this->_helper->redirector->gotoUrl($this->view->baseUrl('profile/picture/id/'.encode($user->getID())));
    	}
    	// exit();
    }
    
    function croppictureAction(){
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(TRUE);
    	$session = SessionWrapper::getInstance();
    	$formvalues = $this->_getAllParams();
    
    	$user = new UserAccount();
    	$user->populate(decode($formvalues['id']));
    	$userfolder = $user->getID();
    	// debugMessage($formvalues);
    	//debugMessage($user->toArray());
    
    	$oldfile = "large_".$user->getProfilePhoto();
    	$base = BASE_PATH.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR."users".DIRECTORY_SEPARATOR.'user_'.$userfolder.''.DIRECTORY_SEPARATOR.'avatar'.DIRECTORY_SEPARATOR;
    
    	// debugMessage($user->toArray());
    	$src = $base.$oldfile;
    
    	$currenttime = time();
    	$currenttime_file = $currenttime.'.jpg';
    	$newlargefilename = $base."large_".$currenttime_file;
    	$newmediumfilename = $base."medium_".$currenttime_file;
    
    	// exit();
    	$image = WideImage::load($src);
    	$cropped1 = $image->crop($formvalues['x1'], $formvalues['y1'], $formvalues['w'], $formvalues['h']);
    	$resized_1 = $cropped1->resize(300, 300, 'fill');
    	$resized_1->saveToFile($newlargefilename);
    
    	//$image2 = WideImage::load($src);
    	$cropped2 = $image->crop($formvalues['x1'], $formvalues['y1'], $formvalues['w'], $formvalues['h']);
    	$resized_2 = $cropped2->resize(165, 165, 'fill');
    	$resized_2->saveToFile($newmediumfilename);
    
    	$user->setProfilePhoto($currenttime_file);
    	$user->save();
    
    	// check if UserAccount already has profile picture and archive it
    	$ftimestamp = current(explode('.', $user->getProfilePhoto()));
    
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
    	$session->setVar(SUCCESS_MESSAGE, "Successfully updated profile picture");
    		$this->_helper->redirector->gotoUrl($this->view->baseUrl('profile/view/id/'.encode($user->getID())));
    	// exit();
    }
}
