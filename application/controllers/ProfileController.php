<?php

class ProfileController extends SecureController  {
	
	/**
	 * @see SecureController::getResourceForACL()
	 *
	 * @return String
	 */
	function getResourceForACL() {
		return "User Account";
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
		if($action == "add" || $action == "other" || $action == "processother" || $action == "processadd" ) {
			return ACTION_CREATE; 
		}
		if($action == "resetpassword" || $action == "inviteuser"){
			return ACTION_EDIT; 
		}
		if($action == "view" || $action == "picture" || $action == "processpicture" || $action == "uploadpicture" || $action == "croppicture" || $action == "changepassword" || $action == "processchangepassword" || $action == "changeusername" || 
			$action == "processchangeusername" || $action == "changeemail" || $action == "processchangeemail"){
			return ACTION_VIEW;
		}
		return parent::getActionforACL();
    }
    
    public function viewAction() {
    	$session = SessionWrapper::getInstance();
    	$failurl = $this->view->baseUrl("index/accessdenied");
    	$acl = getACLInstance();
    	$id = decode($this->_getParam('id'));
    		
    	if(!isEmptyString($id) && isTimesheetEmployee() && !isCompanyAdmin() && !isAdmin()){
    		if($session->getVar('userid') != $id){
    			$this->_helper->redirector->gotoUrl($failurl);
    		}
    	}
    	parent::viewAction();
    }
    
	function addAction(){}
	
 	function addsuccessAction(){
		$session = SessionWrapper::getInstance(); 
     	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$formvalues = $this->_getAllParams();
		
		$session->setVar(SUCCESS_MESSAGE, "Successfully saved");
   		if(!isArrayKeyAnEmptyString('successmessage', $formvalues)){
			$session->setVar(SUCCESS_MESSAGE, decode($formvalues['successmessage']));
		}
		
		/*$user = new UserAccount();
		$id = $user->getLastInsertID();*/
		$this->_helper->redirector->gotoUrl($this->view->baseUrl("profile/list"));
    }
	
	function changepasswordAction()  {}
    
    function processchangepasswordAction(){
    	$session = SessionWrapper::getInstance(); 
        $this->_translate = Zend_Registry::get("translate"); 
    	if(!isEmptyString($this->_getParam('password'))){
	        $user = new UserAccount(); 
	    	$user->populate(decode($this->_getParam('id')));
	    	// debugMessage($user->toArray());
	    	#validate that the passwords aint the same
	    	if($this->_getParam('oldpassword') == $this->_getParam('password')){
	    		$session->setVar(SUCCESS_MESSAGE, "New Password should be the same as the current passowrd!");
	    				$this->_redirect($this->view->baseUrl('profile/view/id/'.encode($user->getID()).'/tab/account'));
	    	}
	    	# Change password
	    	try {
	    		$user->changePassword($this->_getParam('password'));
	    		$session->setVar(SUCCESS_MESSAGE, "Password successfully updated");
	    		$this->_redirect($this->view->baseUrl('index/profileupdatesuccess'));
	    	} catch (Exception $e) {
	    		$session->setVar(ERROR_MESSAGE, "Error in changing Password. ".$e->getMessage());
	    	}
		}
    }
    
    function changeusernameAction()  {}
	
	function processchangeusernameAction()  {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
    	$session = SessionWrapper::getInstance(); 
        $this->_translate = Zend_Registry::get("translate");
        $formvalues = $this->_getAllParams();
        
    	if(!isArrayKeyAnEmptyString('username', $formvalues)){
	        $user = new UserAccount(); 
	    	$user->populate(decode($formvalues['id']));
	    	// debugMessage($user->toArray());
	    	
	    	if($user->usernameExists($formvalues['username'])){
	    		$session->setVar(ERROR_MESSAGE, sprintf($this->_translate->translate("profile_username_unique_error"), $formvalues['username']));
	    		return false;
	    	}
	    	# save new username
	    	$user->setUsername($formvalues['username']);
	    	$user->save();
	    	
	    	$view = new Zend_View();
	    	$url = $this->view->serverUrl($this->view->baseUrl('profile/view/id/'.encode($user->getID())));
	    	$usecase = '1.17';
	    	$module = '1';
	    	$type = USER_CHANGE_EMAIL;
	    	$details = "Username for <a href='".$url."' class='blockanchor'>".$user->getName()."</a> Changed";
	    		
	    	$browser = new Browser();
	    	$audit_values = $session->getVar('browseraudit');
	    	$audit_values['module'] = $module;
	    	$audit_values['usecase'] = $usecase;
	    	$audit_values['transactiontype'] = $type;
	    	$audit_values['userid'] = $session->getVar('userid');
	    	$audit_values['url'] = $url;
	    	$audit_values['transactiondetails'] = $details;
	    	$audit_values['status'] = "Y";
	    	// debugMessage($audit_values);
	    	$this->notify(new sfEvent($this, $type, $audit_values));
	    	
	   		$this->_redirect($this->view->baseUrl('index/profileupdatesuccess'));
		}
    }
    
	function changeemailAction()  {
		$session = SessionWrapper::getInstance(); 
		
		$formvalues = $this->_getAllParams();
		if(!isArrayKeyAnEmptyString('actkey', $formvalues) && !isArrayKeyAnEmptyString('ref', $formvalues)){
        	$newemail = decode($formvalues['ref']);
		
			$user = new UserAccount();
			$user->populate(decode($formvalues['id']));
			$oldemail = $user->getEmail();
			
			# validate the activation code
			if($formvalues['actkey'] != $user->getActivationKey()){
				$session->setVar(ERROR_MESSAGE, "Invalid activation code specified for email activation");
				$failureurl = $this->view->baseUrl('profile/view/id/'.encode($user->getID()));
				$this->_helper->redirector->gotoUrl($failureurl);
			}
			
			$user->setActivationKey('');
			$user->setEmail($newemail);
			$user->setEmail2(''); 
			$user->save();
			
			$view = new Zend_View();
			$url = $this->view->serverUrl($this->view->baseUrl('profile/view/id/'.encode($user->getID())));
			$usecase = '1.12';
			$module = '1';
			$type = USER_CHANGE_EMAIL_CONFIRM;
			$details = "New Email (".$user->getEmail().") activated for <a href='".$url."' class='blockanchor'>".$user->getName()."</a>";
			 
			$browser = new Browser();
			$audit_values = $session->getVar('browseraudit');
			$audit_values['module'] = $module;
			$audit_values['usecase'] = $usecase;
			$audit_values['transactiontype'] = $type;
			$audit_values['userid'] = $session->getVar('userid');
			$audit_values['url'] = $url;
			$audit_values['transactiondetails'] = $details;
			$audit_values['status'] = "Y";
			// debugMessage($audit_values);
			$this->notify(new sfEvent($this, $type, $audit_values));
			
			$successmessage = "Successfully updated. Please note that you can no longer login using your previous Email Address";
	    	$session->setVar(SUCCESS_MESSAGE, $successmessage);
	   		$this->_helper->redirector->gotoUrl($this->view->baseUrl('profile/view/id/'.encode($user->getID())));
        }
    }
	
	function processchangeemailAction()  {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
    	$session = SessionWrapper::getInstance(); 
        $this->_translate = Zend_Registry::get("translate");
        $formvalues = $this->_getAllParams();
         
        if(!isArrayKeyAnEmptyString('email', $formvalues)){
	        $user = new UserAccount(); 
	    	$user->populate(decode($formvalues['id']));
	    	// debugMessage($user->toArray());
	    	
	    	if($user->emailExists($formvalues['email'])){
	    		$session->setVar(ERROR_MESSAGE, sprintf($this->_translate->translate("profile_email_unique_error"), $formvalues['email']));
	    		return false;
	    	}
	    	# save new username
	    	$user->setEmail2($formvalues['email']);
	    	$user->setActivationKey($user->generateActivationKey());
	    	$user->save();
	    	
	    	$user->sendNewEmailNotification($formvalues['email']);
    		$user->sendOldEmailNotification($formvalues['email']);
    		
    		$view = new Zend_View();
    		$url = $this->view->serverUrl($this->view->baseUrl('profile/view/id/'.encode($user->getID())));
    		$usecase = '1.11';
    		$module = '1';
    		$type = USER_CHANGE_EMAIL;
    		$details = "Email change request for <a href='".$url."' class='blockanchor'>".$user->getName()."</a> from ".$user->getEmail()." to ".$user->getEmail2();
    		 
    		$browser = new Browser();
    		$audit_values = $session->getVar('browseraudit');
    		$audit_values['module'] = $module;
    		$audit_values['usecase'] = $usecase;
    		$audit_values['transactiontype'] = $type;
    		$audit_values['userid'] = $session->getVar('userid');
    		$audit_values['url'] = $url;
    		$audit_values['transactiondetails'] = $details;
    		$audit_values['status'] = "Y";
    		// debugMessage($audit_values);
    		$this->notify(new sfEvent($this, $type, $audit_values));
    		
	    	$successmessage = "A request to change your login email has been recieved. <br />To complete this process check your new email Inbox and click on the activation link sent. ";
	   		$this->_redirect($this->view->baseUrl('index/updatesuccess/successmessage/'.encode($successmessage)));
		}
    }
    
	function resendemailcodeAction()  {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
    	$session = SessionWrapper::getInstance(); 
        $formvalues = $this->_getAllParams();
         
        $user = new UserAccount(); 
    	$user->populate(decode($formvalues['id']));
    	// debugMessage($user->toArray());
    	
    	$session->setVar('contactuslink', "<a href='".$this->view->baseUrl('contactus')."' title='Contact Support'>Contact us</a>");
    	$user->sendNewEmailNotification($user->getEmail2());
    	$successmessage = "A new activation code has been sent to your new email address. If you are still having any problems please do contact us";
    	$session->setVar(SUCCESS_MESSAGE, $successmessage);
   		$this->_redirect($this->view->baseUrl('profile/view/id/'.encode($user->getID())));
    }
    
	function resetpasswordAction(){
    	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
	   	$session = SessionWrapper::getInstance(); 
       	$this->_translate = Zend_Registry::get("translate"); 
       	$id = decode($this->_getParam('id')); // debugMessage($id);
       	
		$user = new UserAccount(); 
		$user->populate($id); debugMessage($user->toArray());
		// $formvalues = array('email'=>$user->getEmail());
    	$user->setEmail($user->getEmail());
    	// debugMessage('error '.$user->getErrorStackAsString()); exit();
    	if ($user->recoverPassword()) {
       		$session->setVar(SUCCESS_MESSAGE, sprintf($this->_translate->translate('profile_change_password_admin_confirmation'), $user->getName()));
   			// send a link to enable the user to recover their password 
   			// debugMessage('no error found ');
   			
       		$view = new Zend_View();
       		$url = $this->view->serverUrl($this->view->baseUrl('profile/view/id/'.encode($user->getID())));
       		$usecase = '1.9';
       		$module = '1';
       		$type = USER_RESET_PASSWORD;
       		$details = "Reset password request. Reset link sent to <a href='".$url."' class='blockanchor'>".$user->getName()."</a>";
       		 
       		$browser = new Browser();
       		$audit_values = $session->getVar('browseraudit');
       		$audit_values['module'] = $module;
       		$audit_values['usecase'] = $usecase;
       		$audit_values['transactiontype'] = $type;
       		$audit_values['userid'] = $session->getVar('userid');
       		$audit_values['url'] = $url;
       		$audit_values['transactiondetails'] = $details;
       		$audit_values['status'] = "Y";
       		// debugMessage($audit_values);
       		$this->notify(new sfEvent($this, $type, $audit_values));
       		
    	} else {
   			$session->setVar(ERROR_MESSAGE, $user->getErrorStackAsString());
   			$session->setVar(FORM_VALUES, $this->_getAllParams()); // debugMessage('no error found ');
    	}
    	// exit();
    	$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_SUCCESS)));
   	}
   	
    function inviteuserAction(){
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(TRUE);
    	$session = SessionWrapper::getInstance();
    	$formvalues = $this->_getAllParams(); debugMessage($this->_getAllParams());
    	
    	$user = new UserAccount();
    	$user->populate($formvalues['id']);
    	// debugMessage($user->toArray());
    	
    	try {
    		$user->inviteOne();
    		$session->setVar('invitesuccess', "Email Invitation sent to ".$user->getEmail());
    	} catch (Exception $e) {
    		$session->setVar(ERROR_MESSAGE, $e->getMessage());
    	}
    	
    	$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_SUCCESS)));
    	// exit();
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
