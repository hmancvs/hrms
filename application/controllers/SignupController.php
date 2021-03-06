<?php

class SignupController extends IndexController {
	
	function indexAction() {
		$session = SessionWrapper::getInstance();
		$id = $this->_getParam('id');
		if(!isEmptyString($id)){
			$user = new UserAccount();
			$user->populate(decode($id));
			
			if($user->isUserActive()){
				$this->clearSession();
				$session->setVar("warningmessage", "Account already activated. Login to continue");
				$loginurl = $this->view->baseUrl("user/login");
				$this->_helper->redirector->gotoUrl($loginurl);
			}
		}
	}
	
	function createAction() {
		$session = SessionWrapper::getInstance();
		$formvalues = $this->_getAllParams(); // debugMessage($formvalues);
		
		if(!isEmptyString($this->_getParam('spamcheck'))){
			$session->setVar(ERROR_MESSAGE, 'Spam detected. Try again later'); 
			$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_FAILURE)));
		}
		
		$this->_setParam("action", ACTION_CREATE);
		$this->_setParam("entityname", 'UserAccount');
		$this->_setParam("firstname", ucfirst($formvalues['firstname']));
		$this->_setParam("lastname", ucfirst($formvalues['lastname']));
		$this->_setParam("status", 0);
		
		// debugMessage($formvalues); exit();
		parent::createAction();
	}
	
	function processinviteAction() {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$formvalues = $this->_getAllParams();
		$session = SessionWrapper::getInstance(); 
		$id = decode($formvalues['id']);
		$formvalues['id'] = $id; // debugMessage($formvalues);
		$formvalues['status'] = 1;
		$formvalues['password'] = $formvalues['password'];
		$formvalues['agreedtoterms'] = 1;
		$formvalues['activationdate'] = DEFAULT_DATETIME;
		$formvalues['hasacceptedinvite'] = 1;
		
		$user = new UserAccount();
		$user->populate($id);
		$user->processPost($formvalues);
		// debugMessage($user->toArray()); debugMessage("Error > ".$user->getErrorStackAsString()); exit();
		$user->save();
		// save notification to user's inbox
		$user->sendActivationConfirmationNotification();
		
		$url = $this->view->serverUrl($this->view->baseUrl('profile/view/id/'.encode($user->getID())));
		$usecase = '1.16';
		$module = '1';
		$type = USER_ACTIVATE;
		$details = "User Profile <a href='".$url."' class='blockanchor'>".$user->getName()."</a> activated";
		
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
		
		$this->clearSession();
		$session->setVar(SUCCESS_MESSAGE, "You can now login using your Username or Email and Password");
		// $loginurl = $this->view->baseUrl("user/checklogin/email/".$user->getEmail().'/password/'.$formvalues['password']);
		$loginurl = $this->view->baseUrl("user/login");
		$this->_helper->redirector->gotoUrl($loginurl);
		
		return false;
	}
	
	function activateAction() {
		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$session = SessionWrapper::getInstance(); 
		$formvalues = $this->_getAllParams();
		if(!isArrayKeyAnEmptyString('id', $formvalues)){
			// debugMessage($formvalues);
			$user = new UserAccount(); 
			$user->populate(decode($formvalues['id']));
			// debugMessage($user->toArray()); // exit;
			
			if($user->isUserActive() && isEmptyString($user->getActivationKey())) {
				// account already activated 
	    		$session->setVar(ERROR_MESSAGE, 'Account is already activated. Please login.'); 
				$this->_helper->redirector->gotoUrl($this->view->baseUrl("user/login"));
			}
			
			$this->_setParam(URL_FAILURE, encode($this->view->baseUrl("signup/confirm/id/".encode($user->getID()))));
			$key = $this->_getParam('actkey');
			
			$this->view->result = $user->activateAccount($key);
			// exit();
			if (!$this->view->result) {
				// activation failed
				$this->view->message = $user->getErrorStackAsString();
				$session->setVar(FORM_VALUES, $this->_getAllParams());
	    		$session->setVar(ERROR_MESSAGE, $user->getErrorStackAsString()); 
	    		// debugMessage('error '.$user->getErrorStackAsString());
			} else {
				# send activation confirmation
				$user->sendActivationConfirmationNotification();
				$session->setVar(SUCCESS_MESSAGE, "Account activated successfully. Please login to start.");
			}
		}
		$this->_helper->redirector->gotoUrl($this->view->baseUrl("user/login"));
		// exit;
	}
	
	function activateaccountAction() {
		$session = SessionWrapper::getInstance(); 
		// replace the decoded id with an undecoded value which will be used during processPost() 
		$id = decode($this->_getParam('id')); 
		$this->_setParam('id', $id); 
		
		$user = new UserAccount(); 
		$user->populate($id);
		$user->processPost($this->_getAllParams());
		
		if ($user->hasError()) {
			$session->setVar(FORM_VALUES, $this->_getAllParams());
    		$session->setVar(ERROR_MESSAGE, $user->getErrorStackAsString()); 
			$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_FAILURE)));
		}
		
		$result = $user->activateAccount($this->_getParam('activationkey'));
		if ($result) {
			// go to sucess page 
			$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_SUCCESS))); 
		} else {
			$session->setVar(FORM_VALUES, $this->_getAllParams());
    		$session->setVar(ERROR_MESSAGE, $user->getErrorStackAsString()); 
			$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_FAILURE)));
		}
	}
	
	function confirmAction() {
		
	}
	
	function activationerrorAction() {
		
	}
	
	function activationconfirmationAction() {
		
	}
	
	function inviteconfirmationAction() {
		
	}
	
	function getcaptchaAction(){
		$this->view->layout()->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(true);
		$session = SessionWrapper::getInstance(); 
		
		$string = '';
		for ($i = 0; $i < 5; $i++) {
			$string .= chr(rand(97, 122));
		}
		$session->setVar('random_number', $string);
		// $_SESSION['random_number'] = $string;

		$dir = $this->view->baseUrl("images/fonts/");
		//$dir = APPLICATION_PATH."/../public/images/fonts";
		// debugMessage($dir);
		$image = imagecreatetruecolor(165, 50);

		// random number 1 or 2
		
		echo $session->getVar('random_number');
	}
	function captchaAction() {
		$this->view->layout()->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(true);
		$session = SessionWrapper::getInstance();
		//include('dbcon.php');
		// debugMessage('scre is '.strtolower($this->_getParam('code')));
		// debugMessage('rand is '.strtolower($session->getVar('random_number')));
		if(strtolower($this->_getParam('code')) == strtolower($session->getVar('random_number'))){
			echo 1;// submitted 
		} else {
			echo 0; // invalid code
		}
	}
	
	function checkusernameAction(){
		$this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(true);
	    
		$formvalues = $this->_getAllParams();
		$username = trim($formvalues['username']);
		// debugMessage($formvalues);
		$user = new UserAccount();
		if(!isArrayKeyAnEmptyString('userid', $formvalues)){
			$user->populate($formvalues['userid']);
		}
		if($user->usernameExists($username)){
			echo '1';
		} else {
			echo '0';
		}
	}
	
	function checkemailAction(){
		$this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(true);
	    
		$formvalues = $this->_getAllParams();
		$email = trim($formvalues['email']);
		// debugMessage($formvalues);
		$user = new UserAccount();
		if(!isArrayKeyAnEmptyString('userid', $formvalues)){
			$user->populate($formvalues['userid']);
		}
		if($user->emailExists($email)){
			echo '1';
		} else {
			echo '0';
		}
	}
	
	function checkphoneAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		 
		$formvalues = $this->_getAllParams();
		$phone = trim($formvalues['phone']);
		// debugMessage($formvalues);
		$user = new UserAccount();
		if(!isArrayKeyAnEmptyString('userid', $formvalues)){
			$user->populate($formvalues['userid']);
		}
		if($user->phoneExists($phone)){
			echo '1';
		} else {
			echo '0';
		}
	}
	
	function checkcompanyusernameAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		 
		$formvalues = $this->_getAllParams();
		$username = trim($formvalues['username']);
		// debugMessage($formvalues);
		$company = new Company();
		if($company->usernameExists($username)){
			echo 'exists';
		} else {
			echo 'available';
		}
	}
}
