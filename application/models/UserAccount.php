<?php

// include 'UserNotifications.php';

class UserAccount extends BaseEntity {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		$this->setTableName('useraccount');
		$this->hasColumn('type', 'integer', null);
		$this->hasColumn('companyid', 'integer', null);
		$this->hasColumn('empstatus', 'integer', null);
		$this->hasColumn('firstname', 'string', 255, array('notblank' => true));
		$this->hasColumn('lastname', 'string', 255, array('notblank' => true));
		$this->hasColumn('othername', 'string', 255);
		$this->hasColumn('displayname', 'string', 255);
		
		$this->hasColumn('country', 'string', 2, array('default' => getCountryCode()));
		$this->hasColumn('town', 'string', 255);
		$this->hasColumn('address1', 'string', 255);
		$this->hasColumn('address2', 'string', 255);
		$this->hasColumn('postalcode', 'string', 255);
		
		$this->hasColumn('email', 'string', 50); // only required during activation
		$this->hasColumn('email2', 'string', 50);
		$this->hasColumn('phone', 'string', 15);
		$this->hasColumn('phone2', 'string', 15);
		$this->hasColumn('ext', 'string', 15);
		$this->hasColumn('phone_isactivated', 'integer', null, array('default' => '0'));
		$this->hasColumn('phone_actkey', 'string', 15);
		$this->hasColumn('username', 'string', 15); // only required during activation
		$this->hasColumn('password', 'string', 255); // only required during activation
		$this->hasColumn('trx', 'string', 255);
		$this->hasColumn('status', 'integer', null, array('default' => '0')); # 0=Pending, 1=Active, 2=Deactivated
		$this->hasColumn('activationkey', 'string', 15);
		$this->hasColumn('activationdate', 'date');
		$this->hasColumn('agreedtoterms', 'integer', null, array('default' => '0'));	# 0=NO, 1=YES
		$this->hasColumn('securityquestion', 'integer', null);
		$this->hasColumn('securityanswer', 'integer', null);
		$this->hasColumn('isinvited', 'integer', null, array('default' => NULL));
		$this->hasColumn('invitedbyid', 'integer', null);
		$this->hasColumn('hasacceptedinvite', 'integer', null, array('default' => 0));
		$this->hasColumn('dateinvited','date');
		
		$this->hasColumn('bio', 'string', 65535);
		$this->hasColumn('gender', 'integer', null, array('default' => 1)); # 1=Male, 2=Female, 3=Unknown
		$this->hasColumn('dateofbirth','date');
		$this->hasColumn('profilephoto', 'string', 50);
		$this->hasColumn('contactname', 'string', 255);
		$this->hasColumn('contactphone', 'string', 15);
		$this->hasColumn('contactrshp', 'string', 15);
		$this->hasColumn('contactemail', 'string', 255);
		$this->hasColumn('contactaddress', 'string', 255);
		$this->hasColumn('notes', 'string', 1000);
		$this->hasColumn('startdate','date', null, array('default' => NULL));
		$this->hasColumn('enddate','date', null, array('default' => NULL));
		$this->hasColumn('probationend','date', null, array('default' => NULL));
		$this->hasColumn('idno', 'string', 50);
		$this->hasColumn('nationalid', 'string', 50);
		$this->hasColumn('nssfid', 'string', 15);
		$this->hasColumn('uratin', 'string', 15);
		$this->hasColumn('contributiontype', 'string', 25);
		$this->hasColumn('linkedin', 'string', 255);
		$this->hasColumn('skype', 'string', 255);
		$this->hasColumn('maritalstatus', 'string', 255);
		$this->hasColumn('salutation', 'string', 15);
		$this->hasColumn('position', 'string', 50);
		$this->hasColumn('qualifications', 'string', 1000);
		$this->hasColumn('education', 'string', 1000);
		$this->hasColumn('skills', 'string', 1000);
		$this->hasColumn('experience', 'string', 1000);
		$this->hasColumn('jobdescription', 'string', 1000);
		$this->hasColumn('empstatus', 'string', 15);
		$this->hasColumn('departmentid', 'integer', null, array('default' => NULL));
		$this->hasColumn('managerid', 'integer', null, array('default' => NULL));
		$this->hasColumn('workingdays', 'string', 50);
		$this->hasColumn('maxhoursperday', 'string', 50);
		$this->hasColumn('maxhoursperweek', 'string', 50);
		$this->hasColumn('shift', 'string', 50);
		$this->hasColumn('rate', 'string', 10);
		$this->hasColumn('ratetype', 'string', 15, array('default' => 4));
		$this->hasColumn('ratecurrency', 'string', 15);
		$this->hasColumn('bankname', 'string', 255);
		$this->hasColumn('accname', 'string', 255);
		$this->hasColumn('accno', 'string', 255);
		$this->hasColumn('swiftcode', 'string', 255);
		$this->hasColumn('branchname', 'string', 255);
		$this->hasColumn('istimesheetuser', 'integer', null, array('default' => 0));
		$this->hasColumn('payrolltype', 'integer', null, array('default' => 4));
		$this->hasColumn('employmentstatus', 'string', 15, array('default' => 1));
		$this->hasColumn('selfregistered', 'integer', null, array('default' => 0));
		
		$this->hasColumn('emailon_tsheet_approvalcompleted', 'integer', null, array('default' => 1));
		$this->hasColumn('emailon_tsheeton_approvalrequired', 'integer', null, array('default' => 0));
		$this->hasColumn('emailon_benefit_approvalcompleted', 'integer', null, array('default' => 1));
		$this->hasColumn('emailon_benefit_approvalrequired', 'integer', null, array('default' => 0));
		$this->hasColumn('emailon_leave_approvalcompleted', 'integer', null, array('default' => 1));
		$this->hasColumn('emailon_leave_approvalrequired', 'integer', null, array('default' => 0));
		$this->hasColumn('emailon_payslip_completed', 'integer', null, array('default' => 1));
		$this->hasColumn('emailon_directmessage_recieved', 'integer', null, array('default' => 1));
		
		# override the not null and not blank properties for the createdby column in the BaseEntity
		$this->hasColumn('createdby', 'integer', 11);
	}
	
	protected $oldpassword;
	protected $newpassword;
	protected $confirmpassword;
	protected $trx;
	protected $oldemail;
	protected $changeemail;
	protected $isinvited;
	protected $isphoneinvited;
	protected $preupdatedata;
	protected $controller;
	
	function getOldPassword(){
		return $this->oldpassword;
	}
	function setOldPassword($oldpassword) {
		$this->oldpassword = $oldpassword;
	}
	function getNewPassword(){
		return $this->newpassword;
	}
	function setNewPassword($newpassword) {
		$this->newpassword = $newpassword;
	}
	function getConfirmPassword(){
		return $this->confirmpassword;
	}
	function setConfirmPassword($confirmpassword) {
		$this->confirmpassword = $confirmpassword;
	}
	function getTrx(){
		return $this->trx;
	}
	function setTrx($trx) {
		$this->trx = $trx;
	}
	function getOldEmail(){
		return $this->oldemail;
	}
	function setOldEmail($oldemail) {
		$this->oldemail = $oldemail;
	}
	function getChangeEmail(){
		return $this->changeemail;
	}
	function setChangeEmail($changeemail) {
		$this->changeemail = $changeemail;
	}
	function getIsBeinginvited(){
		return $this->isbeinginvited;
	}
	function setIsBeingInvited($isbeinginvited) {
		$this->isbeinginvited = $isbeinginvited;
	}
	function getNameofUser(){
		return $this->nameofuser;
	}
	function setNameofUser($nameofuser) {
		$this->nameofuser = $nameofuser;
	}
	function getPreUpdateData(){
		return $this->preupdatedata;
	}
	function setPreUpdateData($preupdatedata) {
		$this->preupdatedata = $preupdatedata;
	}
	function getController(){
		return $this->controller;
	}
	function setController($controller) {
		$this->controller = $controller;
	}
	
	# Contructor method for custom initialization
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array("dateofbirth","activationdate","dateinvited","startdate","enddate","probationend"));
		
		# set the custom error messages
       	$this->addCustomErrorMessages(array(
       									// "type.notblank" => $this->translate->_("profile_type_error"),
       									"firstname.notblank" => $this->translate->_("profile_firstname_error"),
       									"lastname.notblank" => $this->translate->_("profile_lastname_error")
       	       						));
	}
	
	# Model relationships
	public function setUp() {
		parent::setUp(); 
		# copied directly from BaseEntity since the createdby can be NULL when a user signs up 
		# automatically set timestamp column values for datecreated and lastupdatedate 
		$this->actAs('Timestampable', 
						array('created' => array(
												'name' => 'datecreated'
											),
							 'updated' => array(
												'name'     =>  'lastupdatedate',    
												'onInsert' => false,
												'options'  =>  array('notnull' => false)
											)
						)
					);
		$this->hasMany('UserGroup as usergroups',
							array('local' => 'id',
									'foreign' => 'userid'
							)
						);
		$this->hasOne('UserAccount as creator', 
								array(
									'local' => 'createdby',
									'foreign' => 'id'
								)
						);
		$this->hasOne('UserAccount as invitedby', 
								array(
									'local' => 'invitedbyid',
									'foreign' => 'id',
								)
						);
		$this->hasOne('UserAccount as manager',
								array(
									'local' => 'managerid',
									'foreign' => 'id',
								)
						);
		$this->hasOne('Company as company',
								array(
										'local' => 'companyid',
										'foreign' => 'id',
								)
						);
		$this->hasMany('UserBenefit as userbenefits',
								array(
									'local' => 'id',
									'foreign' => 'userid'
								)
						);
	}
	/**
	 * Custom model validation
	 */
	function validate() {
		# execute the column validation 
		parent::validate();
		// debugMessage($this->toArray(true));
		# validate that username is unique
		if($this->usernameExists()){
			$this->getErrorStack()->add("username.unique", sprintf($this->translate->_("profile_username_unique_error"), $this->getUsername()));	
		}
		# validate that email is unique
		if($this->emailExists()){
			$this->getErrorStack()->add("email.unique", sprintf($this->translate->_("profile_email_unique_error"), $this->getEmail()));
		}
		
		# check that at least one group has been specified
		if ($this->getUserGroups()->count() == 0) {
			// $this->getErrorStack()->add("groups", $this->translate->_("profile_group_error"));
		}
		
		# validate attempt to change password with an invalid current password
		if(!isEmptyString($this->getNewPassword())){
			if(!isEmptyString($this->getOldPassword()) && sha1($this->getOldPassword()) != $this->getTrx()){
				$this->getErrorStack()->add("oldpassword", $this->translate->_("profile_oldpassword_invalid_error"));
			} else {
				$this->setPassword(sha1($this->getNewPassword()));
			}
		}
	}
	# determine if the username has already been assigned
	function usernameExists($username =''){
		$conn = Doctrine_Manager::connection();
		# validate unique username and email
		$id_check = "";
		if(!isEmptyString($this->getID())){
			$id_check = " AND id <> '".$this->getID()."' ";
		}
		
		if(isEmptyString($username)){
			$username = $this->getUsername();
		}
		$query = "SELECT id FROM useraccount WHERE username = '".$username."' AND username <> '' ".$id_check;
		// debugMessage($query);
		$result = $conn->fetchOne($query);
		// debugMessage($result);
		if(isEmptyString($result)){
			return false;
		}
		return true;
	}
	# determine if the email has already been assigned
	function emailExists($email =''){
		$conn = Doctrine_Manager::connection();
		# validate unique username and email
		$id_check = "";
		if(!isEmptyString($this->getID())){
			$id_check = " AND id <> '".$this->getID()."' ";
		}
		
		if(isEmptyString($email)){
			$email = $this->getEmail();
		}
		$query = "SELECT id FROM useraccount WHERE email = '".$email."' AND email <> '' AND companyid = '".$this->getCompanyID()."' ".$id_check;
		// debugMessage($ref_query);
		$result = $conn->fetchOne($query);
		// debugMessage($ref_result);
		if(isEmptyString($result)){
			return false;
		}
		return true;
	}
	# determine if the refno has already been assigned to another organisation
	function phoneExists($phone =''){
		$conn = Doctrine_Manager::connection();
		$id_check = "";
		if(!isEmptyString($this->getID())){
			$id_check = " AND id <> '".$this->getID()."' ";
		}
	
		$query_custom = '';
		if(isEmptyString($phone)){
			$phone = $this->getPhone();
		}
		
		# unique phone
		$phone_query = "SELECT id FROM useraccount WHERE phone = '".$phone."' ".$id_check;
		// debugMessage($phone_query);
		$result = $conn->fetchOne($phone_query);
		// debugMessage($result);exit();
		if(isEmptyString($result)){
			return false;
		} else {
			$user = new UserAccount();
			$user->populate($result);
			$this->setNameofUser($user->getfirstname().' '.$user->getlastname().' '.$user->getothername());
		}
		return true;
	}
	# check for user using password and phone number
	function validateUserUsingPhone($password, $phone){
		$formattedphone = getFullPhone($phone);
		$conn = Doctrine_Manager::connection();
		$query = "SELECT * from useraccount as m where (m.phone = '".$formattedphone."' || m.phone = '".$phone."') AND (m.password = '".sha1($password)."' || m.trx = '".sha1($password)."') ";
		// debugMessage($query);
		$result = $conn->fetchRow($query);
		// debugMessage($result);
		return $result;
	}
	# check for user using password and phone number
	function validateExistingPhone($phone){
		$formattedphone = getFullPhone($phone);
		$conn = Doctrine_Manager::connection();
		$query = " ";
		// debugMessage($query);
		$result = $conn->fetchRow($query);
		// debugMessage($result);
		return $result;
	}
	# Preprocess model data
	function processPost($formvalues){
		$session = SessionWrapper::getInstance(); //debugMessage($formvalues); 
		if(!isArrayKeyAnEmptyString('firstname', $formvalues)){
			$formvalues['firstname'] = ucwords(strtolower($formvalues['firstname']));
		}
		if(!isArrayKeyAnEmptyString('lastname', $formvalues)){
			$formvalues['lastname'] = ucwords(strtolower($formvalues['lastname']));
		}
		if(!isArrayKeyAnEmptyString('othername', $formvalues)){
			$formvalues['othername'] = ucwords(strtolower($formvalues['othername']));
		}
		if(!isArrayKeyAnEmptyString('displayname', $formvalues)){
			$formvalues['displayname'] = ucwords(strtolower($formvalues['displayname']));
		}
		# if the passwords are not changed , set value to null
		if(isArrayKeyAnEmptyString('password', $formvalues)){
			unset($formvalues['password']); 
		} else {
			$formvalues['password'] = sha1($formvalues['password']);
			// $formvalues['password'] = encode(sha1($formvalues['password']));
			$formvalues['trx'] = sha1('password');
		}
		if(!isArrayKeyAnEmptyString('oldpassword', $formvalues)){
			$this->setoldpassword($formvalues['oldpassword']);
		}
		if(!isArrayKeyAnEmptyString('confirmpassword', $formvalues)){
			$this->setconfirmpassword($formvalues['confirmpassword']);
		}
		if(!isArrayKeyAnEmptyString('newpassword', $formvalues)){
			$this->setNewPassword($formvalues['newpassword']);
			$formvalues['password'] = sha1($formvalues['newpassword']);
		}
		/*if(!isArrayKeyAnEmptyString('phone', $formvalues)){
			$formvalues['phone'] = str_pad(ltrim($formvalues['phone'], '0'), 12, getCountryCode(), STR_PAD_LEFT); 
		}*/
		if(!isArrayKeyAnEmptyString('email', $formvalues) && !isArrayKeyAnEmptyString('oldemail', $formvalues) && !isArrayKeyAnEmptyString('status', $formvalues)){
			if($formvalues['email'] != $formvalues['oldemail'] && $session->getVar('userid') == $formvalues['id']){
				$this->setChangeEmail('1');
				$this->setOldEmail($formvalues['oldemail']);
				$formvalues['email2'] = $formvalues['email'];
				$formvalues['email'] = $formvalues['oldemail'];
				$formvalues['activationkey'] = $this->generateActivationKey();
			}
		}
		# force setting of default none string column values. enum, int and date 	
		if(isArrayKeyAnEmptyString('companyid', $formvalues)){
			unset($formvalues['companyid']);
		}
		if(isArrayKeyAnEmptyString('status', $formvalues)){
			unset($formvalues['status']); 
		}
		if(isArrayKeyAnEmptyString('agreedtoterms', $formvalues)){
			unset($formvalues['agreedtoterms']); 
		}
		if(isArrayKeyAnEmptyString('gender', $formvalues)){
			unset($formvalues['gender']); 
		}
		if(isArrayKeyAnEmptyString('dateofbirth', $formvalues)){
			unset($formvalues['dateofbirth']);
		} else {
			$formvalues['dateofbirth'] = date('Y-m-d', strtotime($formvalues['dateofbirth']));
		}
		if(isArrayKeyAnEmptyString('activationdate', $formvalues)){
			unset($formvalues['activationdate']); 
		}
		if(isArrayKeyAnEmptyString('type', $formvalues)){
			unset($formvalues['type']); 
		}
		if(isArrayKeyAnEmptyString('salutation', $formvalues)){
			unset($formvalues['salutation']);
		}
		if(isArrayKeyAnEmptyString('maritalstatus', $formvalues)){
			unset($formvalues['maritalstatus']);
		}
		if(isArrayKeyAnEmptyString('profession', $formvalues)){
			unset($formvalues['profession']);
		}
		if(isArrayKeyAnEmptyString('contactid', $formvalues)){
			unset($formvalues['contactid']);
		}
		if(isArrayKeyAnEmptyString('isinvited', $formvalues)){
			$formvalues['isinvited'] = NULL;
		}
		if(isArrayKeyAnEmptyString('hasacceptedinvite', $formvalues)){
			$formvalues['hasacceptedinvite'] = NULL; 
		}
		if(isArrayKeyAnEmptyString('dateinvited', $formvalues)){
			unset($formvalues['dateinvited']); 
		}
		if(!isArrayKeyAnEmptyString('isinvited', $formvalues)){
			if($formvalues['isinvited'] == 1){
				$this->setIsBeingInvited($formvalues['isinvited']);
				$formvalues['invitedbyid'] = $session->getVar('userid');
				$formvalues['dateinvited'] = date('Y-m-d');
				$formvalues['hasacceptedinvite'] = 0;
			}
		}
		if(isArrayKeyAnEmptyString('county', $formvalues)){
			if(isArrayKeyAnEmptyString('county_old', $formvalues)){
				unset($formvalues['county']);
			} else {
				$formvalues['county'] = NULL;
			}
		}
		
		# move the data from $formvalues['usergroups_groupid'] into $formvalues['usergroups'] array
		# the key for each group has to be the groupid
		if(isArrayKeyAnEmptyString('id', $formvalues)) {
			if(!isArrayKeyAnEmptyString('type', $formvalues)) {
				if(!isArrayKeyAnEmptyString('type', $formvalues)) {
					$formvalues['usergroups_groupid'] = array($formvalues['type']);
				}
				if(isArrayKeyAnEmptyString('createdby', $formvalues)) {
					$formvalues['createdby'] = DEFAULT_ID;
				}
				$formvalues['activationkey'] = $this->generateActivationKey();
			}
		}
		
		if (array_key_exists('usergroups_groupid', $formvalues)) {
			$groupids = $formvalues['usergroups_groupid']; 
			$usergroups = array(); 
			foreach ($groupids as $id) {
				$usergroups[]['groupid'] = $id; 
			}
			$formvalues['usergroups'] = $usergroups; 
			# remove the usergroups_groupid array, it will be ignored, but to be on the safe side
			unset($formvalues['usergroups_groupid']); 
		}
		
		# add the userid if the UserAccount is being edited
		if (!isArrayKeyAnEmptyString('id', $formvalues)) {
			if (array_key_exists('usergroups', $formvalues)) {
				$usergroups = $formvalues['usergroups']; 
				foreach ($usergroups as $key=>$value) {
					$formvalues['usergroups'][$key]["userid"] = $formvalues["id"];
					if(!isArrayKeyAnEmptyString('type', $formvalues)){
						$formvalues['usergroups'][$key]["groupid"] = $formvalues['type'];
					}
				}
			} 
		}
		if(!isArrayKeyAnEmptyString('type', $formvalues) && !isArrayKeyAnEmptyString('type_old', $formvalues)) {
			if(!isEmptyString($formvalues['type']) && !isEmptyString($formvalues['type_old'])){
				if(!isArrayKeyAnEmptyString('id', $formvalues)){
					$formvalues['usergroups'][0]["userid"] = $formvalues["id"];
				}
				$formvalues['usergroups'][0]["groupid"] = $formvalues['type'];
			}
		}
		if(isArrayKeyAnEmptyString('contactname', $formvalues)){
			unset($formvalues['contactname']);
		}
		
		if(!isArrayKeyAnEmptyString('workingdaysids', $formvalues)) {
			$formvalues['workingdays'] = implode(',', $formvalues['workingdaysids']);
		} else {
			if(!isArrayKeyAnEmptyString('workingdays_old', $formvalues)){
				if(isArrayKeyAnEmptyString('workingdaysids', $formvalues)) {
					$formvalues['workingdays'] = NULL;
				}
			} else {
				unset($formvalues['workingdays']);
			}
		}
		if(isArrayKeyAnEmptyString('startdate', $formvalues)){
			unset($formvalues['startdate']);
		} else {
			$formvalues['startdate'] = date('Y-m-d', strtotime($formvalues['startdate']));
		}
		if(isArrayKeyAnEmptyString('enddate', $formvalues)){
			unset($formvalues['enddate']);
		} else {
			$formvalues['enddate'] = date('Y-m-d', strtotime($formvalues['enddate']));
		}
		if(isArrayKeyAnEmptyString('probationend', $formvalues)){
			unset($formvalues['probationend']);
		} else {
			$formvalues['probationend'] = date('Y-m-d', strtotime($formvalues['probationend']));
		}
		if(isArrayKeyAnEmptyString('managerid', $formvalues)){
			unset($formvalues['managerid']);
		}
		if(isArrayKeyAnEmptyString('departmentid', $formvalues)){
			unset($formvalues['departmentid']);
		}
		if(isArrayKeyAnEmptyString('istimesheetuser', $formvalues)){
			unset($formvalues['istimesheetuser']);
		}
		if(isArrayKeyAnEmptyString('payrolltype', $formvalues)){
			unset($formvalues['payrolltype']);
		}
		
		if(!isArrayKeyAnEmptyString('hasbenefits', $formvalues)){
			$benefitsarray = array();
			$totcash = countCashBenefits(); // debugMessage($totcash.' <<');
			$tottime = countTimeBenefits();  // debugMessage($tottime.' <<');
			
			$benefitsarray[md5(1)]['benefitid'] = $formvalues['benefitid_1'];
			$benefitsarray[md5(1)]['amount'] = isArrayKeyAnEmptyString('rate', $formvalues) ? "0" : $formvalues['rate'];
			$benefitsarray[md5(1)]['accrualfrequency'] = $formvalues['ratetype'];
			if(!isArrayKeyAnEmptyString('id_1', $formvalues)){
				$benefitsarray[md5(1)]['id'] = $formvalues['id_1'];
			}
			
			$counter = 0;
			for($i = 2; $i <= $totcash; $i++){
				if(!isArrayKeyAnEmptyString('amount_'.$i, $formvalues)){
					if($formvalues['amount_'.$i] > 0){
						if(!isArrayKeyAnEmptyString('id_'.$i, $formvalues)){
							$benefitsarray[md5($i)]['id'] = $formvalues['id_'.$i];
						}
						$benefitsarray[md5($i)]['type'] = 1;
						$benefitsarray[md5($i)]['benefitid'] = $formvalues['benefitid_'.$i];
						$benefitsarray[md5($i)]['amount'] = $formvalues['amount_'.$i];
						$benefitsarray[md5($i)]['benefitfrequency'] = $formvalues['benefitfrequency_'.$i];
						$benefitsarray[md5($i)]['benefitterms'] = $formvalues['benefitterms_'.$i];
						$benefitsarray[md5($i)]['accrualtype'] = NULL;
						$benefitsarray[md5($i)]['accrualfrequency'] = NULL;
						$benefitsarray[md5($i)]['accrualvalue'] = NULL;
						if(!isArrayKeyAnEmptyString('istaxable_'.$i, $formvalues)){
							$benefitsarray[md5($i)]['istaxable'] = $formvalues['istaxable_'.$i];
						} else {
							$benefitsarray[md5($i)]['istaxable'] = 0;
						}
						$counter++;
					}
				}
			}
			
			for($x = 0; $x <= ($tottime+$totcash+4); $x++){
				if(!isArrayKeyAnEmptyString('accrualvalue_'.$x, $formvalues)){
					// debugMessage($formvalues['accrualvalue_'.$x]);
					if($formvalues['accrualvalue_'.$x] > 0){
						if(!isArrayKeyAnEmptyString('id_'.$x, $formvalues)){
							$benefitsarray[md5($x)]['id'] = $formvalues['id_'.$x];
						}
						if(!isArrayKeyAnEmptyString('accrualfrequency_'.$x, $formvalues)){
							$benefitsarray[md5($x)]['accrualfrequency'] = $formvalues['accrualfrequency_'.$x];
						}
						$benefitsarray[md5($x)]['type'] = 2;
						$benefitsarray[md5($x)]['leavetypeid'] = $formvalues['leavetypeid_'.$x];
						$benefitsarray[md5($x)]['accrualtype'] = $formvalues['accrualtype_'.$x];
						$benefitsarray[md5($x)]['accrualvalue'] = $formvalues['accrualvalue_'.$x];
						$benefitsarray[md5($x)]['amount'] = NULL;
						$benefitsarray[md5($x)]['benefitfrequency'] = NULL;
						$benefitsarray[md5($x)]['benefitterms'] = NULL;
						$counter++;
					}
				}
			}
			if(count($benefitsarray) > 0){
				$formvalues['userbenefits'] = $benefitsarray;
			}
		}
		
		if(!isArrayKeyAnEmptyString("type", $formvalues) && !isArrayKeyAnEmptyString('selfregistered', $formvalues)){
			if($formvalues['type'] == 3 && $formvalues['selfregistered'] == '1'){
				$formvalues["company"]["name"] = $formvalues["companyname"];
				$formvalues["company"]["status"] = 1;
				if(companiesRequireApproval()){
					$formvalues["company"]["status"] = 2;
				}
				$formvalues["company"]["contactperson"] = $formvalues["firstname"]." ".$formvalues["lastname"];
				$formvalues["company"]["industrycode"] = $formvalues["industrycode"];
				$formvalues["company"]["createdby"] = NULL;
				$formvalues["company"]["datecreated"] = DEFAULT_DATETIME;
				$formvalues["company"]["email"] = $formvalues["email"];
				if(!isArrayKeyAnEmptyString('c_username', $formvalues)){
					$formvalues["company"]["username"] = $formvalues['c_username'];
				}
			}
		}
		
		if(isArrayKeyAnEmptyString("emailon_tsheet_approvalcompleted", $formvalues)){
			if(!isArrayKeyAnEmptyString("emailon_tsheet_approvalcompleted_old", $formvalues)){
				$formvalues["emailon_tsheet_approvalcompleted"] = 0;
			} else {
				unset($formvalues["emailon_tsheet_approvalcompleted"]);
			}
		}
		if(isArrayKeyAnEmptyString("emailon_tsheeton_approvalrequired", $formvalues)){
			if(!isArrayKeyAnEmptyString("emailon_tsheeton_approvalrequired_old", $formvalues)){
				$formvalues["emailon_tsheeton_approvalrequired"] = 0;
			} else {
				unset($formvalues["emailon_tsheeton_approvalrequired"]);
			}
		}
		if(isArrayKeyAnEmptyString("emailon_benefit_approvalcompleted", $formvalues)){
			if(!isArrayKeyAnEmptyString("emailon_benefit_approvalcompleted_old", $formvalues)){
				$formvalues["emailon_benefit_approvalcompleted"] = 0;
			} else {
				unset($formvalues["emailon_benefit_approvalcompleted"]);
			}
		}
		if(isArrayKeyAnEmptyString("emailon_benefit_approvalrequired", $formvalues)){
			if(!isArrayKeyAnEmptyString("emailon_benefit_approvalrequired_old", $formvalues)){
				$formvalues["emailon_benefit_approvalrequired"] = 0;
			} else {
				unset($formvalues["emailon_benefit_approvalrequired"]);
			}
		}
		if(isArrayKeyAnEmptyString("emailon_leave_approvalcompleted", $formvalues)){
			if(!isArrayKeyAnEmptyString("emailon_leave_approvalcompleted_old", $formvalues)){
				$formvalues["emailon_leave_approvalcompleted"] = 0;
			} else {
				unset($formvalues["emailon_leave_approvalcompleted"]);
			}
		}
		if(isArrayKeyAnEmptyString("emailon_leave_approvalrequired", $formvalues)){
			if(!isArrayKeyAnEmptyString("emailon_leave_approvalrequired_old", $formvalues)){
				$formvalues["emailon_leave_approvalrequired"] = 0;
			} else {
				unset($formvalues["emailon_leave_approvalrequired"]);
			}
		}
		if(isArrayKeyAnEmptyString("emailon_payslip_completed", $formvalues)){
			if(!isArrayKeyAnEmptyString("emailon_payslip_completed_old", $formvalues)){
				$formvalues["emailon_payslip_completed"] = 0;
			} else {
				unset($formvalues["emailon_payslip_completed"]);
			}
		}
		if(isArrayKeyAnEmptyString("emailon_directmessage_recieved", $formvalues)){
			if(!isArrayKeyAnEmptyString("emailon_directmessage_recieved_old", $formvalues)){
				$formvalues["emailon_directmessage_recieved"] = 0;
			} else {
				unset($formvalues["emailon_directmessage_recieved"]);
			}
		}
		/* debugMessage($formvalues); // debugMessage($benefitsarray);
		exit(); */
		parent::processPost($formvalues);
	}
	# Custom save logic
	function transactionSave(){
		$conn = Doctrine_Manager::connection();
		$session = SessionWrapper::getInstance();
		
		# begin transaction to save
		try {
			$conn->beginTransaction();
			# initial save
			$this->save();
			
			# commit changes
			$conn->commit();
			
			# update default userid on the companyid 
			if($this->isSelfRegistered() && !isEmptyString($this->getCompanyID()) && isEmptyString($this->getCompany()->getDefaultUserID())){
				$this->getCompany()->setDefaultUserID($this->getID());
				$this->setCreatedBy($this->getID());
				$this->save();
				// $this->getCompany()->save();
			}
			
			# send signup notification to email for public registration
			if($this->isSelfRegistered() && $this->isCompanyAdmin()){
				$this->sendSignupNotification();
			}
			
			# invite via email
			if($this->getIsInvited() == 1){
				$this->inviteViaEmail();
			}
			
			# check if shift has been defined 
			if(!isEmptyString($this->getShift())){
				$shift_data = array(
					"userid" => $this->getID(),
					"sessionid" => $this->getShift(),
					"startdate" => date('Y-m-d', strtotime($this->getDateCreated())),
					"status" => 1,
					"dateadded" => DEFAULT_DATETIME,
					"addedbyid" => $session->getVar('userid')
				);
				$shift = new ShiftSchedule();
				$shift->processPost($shift_data);
				$shift->save();
				/* debugMessage($shift->toArray());
				debugMessage('errors are '.$shift->getErrorStackAsString()); */
			}
			
			# add log to audit trail
			$view = new Zend_View();
			$controller = $this->getController();
			$url = $view->serverUrl($view->baseUrl('profile/view/id/'.encode($this->getID())));
			$profiletype = 'User Profile ';
			$usecase = '1.3';
			$module = '1';
			$type = USER_CREATE;
			
			$browser = new Browser();
			$audit_values = $session->getVar('browseraudit');
			$audit_values['module'] = $module;
			$audit_values['usecase'] = $usecase;
			$audit_values['transactiontype'] = $type;
			$audit_values['status'] = "Y";
			$audit_values['userid'] = $session->getVar('userid');
			$audit_values['transactiondetails'] = $profiletype." <a href='".$url."' class='blockanchor'>".$this->getName()."</a> created";
			$audit_values['url'] = $url;
			// debugMessage($audit_values);
			$this->notify(new sfEvent($this, $type, $audit_values));
			
		} catch(Exception $e){
			$conn->rollback();
			// debugMessage('Error is '.$e->getMessage());
			throw new Exception($e->getMessage());
			return false;
		}
		
		return true;
	}
	# update after
	function beforeUpdate(){
		$session = SessionWrapper::getInstance();
		# set object data to class variable before update
		$user = new UserAccount();
		$user->populate($this->getID());
		$this->setPreUpdateData($user->toArray());
		// exit;
		return true;
	}
	# update after
	function afterUpdate($savetoaudit = true){
		$session = SessionWrapper::getInstance();
		# check if user is being invited during update
		if($this->getIsBeingInvited() == 1){
			if(isEmptyString($this->getEmail())){
				$session->setVar('warningmessage', "Activation not sent. No email available on profile");
			} else {
		 		$this->inviteViaEmail();
		 		
		 		# add log to audit trail
		 		$view = new Zend_View();
		 		$url = $view->serverUrl($view->baseUrl('profile/view/id/'.encode($this->getID())));
		 		 
		 		$browser = new Browser();
		 		$audit_values = $session->getVar('browseraudit');
		 		$audit_values['module'] = '1';
		 		$audit_values['usecase'] = '1.15';
		 		$audit_values['transactiontype'] = USER_INVITE;
		 		$audit_values['status'] = "Y";
		 		$audit_values['userid'] = $session->getVar('userid');
		 		$audit_values['transactiondetails'] = "User <a href='".$url."' class='blockanchor'>".$this->getName()."</a> Invited via Email ";
		 		$audit_values['url'] = $url;
		 		// debugMessage($audit_values);
		 		$this->notify(new sfEvent($this, USER_INVITE, $audit_values));
			}
        }
		
        if($savetoaudit){
	        # set postupdate from class object, and then save to audit
	        $prejson = json_encode($this->getPreUpdateData()); // debugMessage($prejson);
	        
	        $this->clearRelated(); // clear any current object relations
	        $after = $this->toArray(); // debugMessage($after);
	        $postjson = json_encode($after); // debugMessage($postjson);
	        
	        // $diff = array_diff($prejson, $postjson);  // debugMessage($diff);
	        $diff = array_diff($this->getPreUpdateData(), $after);
	        $jsondiff = json_encode($diff); // debugMessage($jsondiff);
	        
	        $view = new Zend_View();
	        $controller = $this->getController();
	       	$url = $view->serverUrl($view->baseUrl('profile/view/id/'.encode($this->getID())));
        	$profiletype = 'User Profile ';
        	$usecase = '1.4';
        	$module = '1';
        	$type = USER_UPDATE;
	        
	        $browser = new Browser();
	        $audit_values = $session->getVar('browseraudit');
	        $audit_values['module'] = $module;
	        $audit_values['usecase'] = $usecase;
	        $audit_values['transactiontype'] = $type;
	        $audit_values['status'] = "Y";
	        $audit_values['userid'] = $session->getVar('userid');
	        $audit_values['transactiondetails'] = $profiletype." <a href='".$url."' class='blockanchor'>".$this->getName()."</a> updated";
	        $audit_values['isupdate'] = 1;
	        $audit_values['prejson'] = $prejson;
	        $audit_values['postjson'] = $postjson;
	        $audit_values['jsondiff'] = $jsondiff;
	        $audit_values['url'] = $url;
	        // debugMessage($audit_values);
	        $this->notify(new sfEvent($this, $type, $audit_values));
        }
        
        return true;
	}
	# find duplicates after save
	function getDuplicates(){
		$q = Doctrine_Query::create()->from('UserAccount u')->where("u.email = '".$this->getEmail()."' AND u.username = '".$this->getUserName()."' AND u.id <> '".$this->getID()."' ");
		
		$result = $q->execute();
		return $result;
	}
	# Send notification to invite person to create an account
	function sendProfileInvitationNotification() {
		$session = SessionWrapper::getInstance();
		$template = new EmailTemplate();
		# create mail object
		$mail = getMailInstance();
		$view = new Zend_View();
	
		// assign values
		$template->assign('inviter', $this->getName());
		$template->assign('type', $this->getType());
		$template->assign('company', $this->getCompany()->getName());
		$template->assign('firstname', isEmptyString($this->getFirstName()) ? 'Friend' : $this->getFirstName());
		$template->assign('inviter', $this->getInvitedBy()->getName());
		// the actual url will be built in the view
		$viewurl = $template->serverUrl($template->baseUrl('signup/index/id/'.encode($this->getID())."/"));
		$template->assign('invitelink', $viewurl);
		$contents = "";
		if($this->isCompanyAdmin()){
			$contents = '<p>Your company <b>'.$this->getCompany()->getName().'</b> has been successfully setup on <b>'.getDefaultAppName().'</b> and you have been invited by <b>'.$this->getInvitedBy()->getName().'</b> to activate your <b>'.getTrialDays().' day</b> free trial account.</p>
	
			<p><b>'.getDefaultAppName().'</b> is an online state of the art Human Resource application that automates almost ALL your company HR needs. All the way from Employee management, benefits, attendance and timesheets, leave time, payroll and many other HR functions.</p>';
		} else {
			$contents = '<p>You have been invited by <b>'.$this->getCompany()->getName().'</b> to activate your Employee HR account.</p>';
		}
		$template->assign('contents', $contents);
	
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
	
		// configure base stuff
		$mail->addTo($this->getEmail(), $this->getName());
		// set the send of the email address
		$mail->setFrom(getDefaultAdminEmail(), getDefaultAdminName());
		$subject = $this->translate->_('profile_email_subject_invite_user');
		$template->assign('subject', $subject);
		$mail->setSubject($subject);
		// render the view as the body of the email
		$mail->setBodyHtml($template->render('invitenotification.phtml'));
		// debugMessage($template->render('invitenotification.phtml')); exit();
	
		if(isEmptyString($this->getEmail())){
			$session->setVar('warningmessage', "Invitation not sent. No email available on profile");
		} else {
			try {
				$mail->send();
			} catch (Exception $e) {
				$session->setVar("warningmessage", 'Email notification not sent! '.$e->getMessage());
			}
		}
	
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		$mail->clearFrom();
	
		return true;
	}
	# Send a notification to agent that their account will be approved shortly
	function sendSignupNotification($prevstatus = 3) {
		$session = SessionWrapper::getInstance();
		$template = new EmailTemplate();
		# create mail object
		$mail = getMailInstance();
	
		# assign values
		$message_contents = "";
		$template->assign('type', 3);
		$template->assign('firstname', $this->getFirstName());
		$template->assign('requiresapproval', 0);
		$template->assign('isapproved', 1);
		$subject = "Account Activation";
		$save_toinbox = false;
		$type = "";
		$subtype = "";
		if($this->isCompanyAdmin()){
			$type = "company";
			$subject = "Account Activation";
			$template->assign('type', 3);
			$template->assign('company', $this->getCompany()->getName());
			$template->assign('trialdays', getTrialDays());
			if(companiesRequireApproval()){
				$template->assign('requiresapproval', 1);
				if($this->getCompany()->isPendingApproval()){
					$template->assign('isapproved', 0);
					$message_contents = "<p>Your company <b>".$this->getCompany()->getName()."</b> has been setup on <b>".getAppName()."</b> for a <b>".getTrialDays()."</b> day free Trial. </p> 
					<p>However, before you can get started, approval from Admin is required. We shall get back to you shortly with a confirmation email so that you can activate your account.</p>";
					$subtype = "signup_approvalrequired";
					$save_toinbox = true;
				} else {
					if($this->getCompany()->isActive() && $prevstatus == 3){
						$subject = $this->getCompany()->getName()." Account Approved";
						$message_contents = "<p>Your company <b>".$this->getCompany()->getName()."</b> has been successfully approved for a <b>".getTrialDays()."</b> day free Trial of <b>".getAppName()."</b>.</p>";
						$subtype = "approval_completed";
						$save_toinbox = true;
					}
					if($this->getCompany()->isActive() && $prevstatus == 0){
						$subject = $this->getCompany()->getName()." Account Activated";
						$message_contents = "<p>Your company <b>".$this->getCompany()->getName()."</b> has been activated on <b>".getAppName()."</b>.</p>";
						$subtype = "account_reactivated";
						$save_toinbox = true;
					}
					if($this->getCompany()->isRejected()){
						$template->assign('isapproved', 0);
						$subject = "Approval for ".$this->getCompany()->getName()." Failed";
						$message_contents = "<p>We regret to inform you that your company <b>".$this->getCompany()->getName()."</b> has been denied access to <b>".getAppName()."</b>. <br>
						<b>Reason:</b> <br>".$this->getCompany()->getRemarks()."
						</p>";
						$subtype = "approval_failed";
						$save_toinbox = true;
					}
					/* if($this->getCompany()->isInActive()){
						$template->assign('isapproved', 0);
						$subject = $this->getCompany()->getName()." Account Deactivated";
						$message_contents = "<p>This is to inform you that  <b>".$this->getCompany()->getName()."</b> has been deactivated from <b>".getAppName()."</b>. <br>
						Feel free to contact us if you have any concerns.
						</p>";
						$subtype = "account_deactivated";
						$save_toinbox = true;
					} */
				}
			} else {
				$message_contents = "<p>Thank you for showing interest in <b>".getAppName()."</b></p>";
			}
		}
		$template->assign('contents', $message_contents);

		$viewurl = $template->serverUrl($template->baseUrl('signup/activate/id/'.encode($this->getID())."/actkey/".$this->getActivationKey()."/"));
		$template->assign('activationurl', $viewurl);

		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');

		# configure base stuff
		$mail->addTo($this->getEmail(), $this->getName());
		$mail->setFrom(getDefaultAdminEmail(true), getDefaultAdminName(true));
		$mail->setSubject($subject);
		# render the view as the body of the email
		$html = $template->render('signupnotification.phtml');
		$mail->setBodyHtml($html);
		// debugMessage($html); // exit();
			
		if(isEmptyString($this->getEmail())){
			$session->setVar('warningmessage', "Invitation not sent. No email available on profile");
		} else {
			try {
				$mail->send();
				$session->setVar("invitesuccess", 'Email sent to '.$this->getEmail());
			} catch (Exception $e) {
				$session->setVar(ERROR_MESSAGE, 'Email notification not sent! '.$e->getMessage());
			}
		}
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		$mail->clearFrom();

		if($save_toinbox){
			# save copy of message to user's application inbox
			$message_dataarray = array(
					"senderid" => DEFAULT_ID,
					"subject" => $subject,
					"contents" => $message_contents,
					"html" => $html,
					"type" => $type,
					"subtype" => $subtype,
					"refid" => $this->getCompanyID(),
					"recipients" => array(
							md5(1) => array("recipientid" => $this->getID())
					)
			); // debugMessage($message_dataarray);
			// process message data
			$message = new Message();
			$message->processPost($message_dataarray);
			$message->save();
		}

		return true;
	}
	# Send notification to inform user that profile has been activated
	function sendActivationConfirmationNotification() {
		$template = new EmailTemplate();
		# create mail object
		$mail = getMailInstance();
		$view = new Zend_View();
		$session = SessionWrapper::getInstance();
	
		// assign values
		$template->assign('firstname', $this->getFirstName());
		$subject = "Account Activation";
		$save_toinbox = true;
		$type = "useraccount";
		$subtype = "profile_activated";
		$message_contents = "<p>This is to confirm that your Account has been successfully activated. </p>
		<p>You can login anytime at ".$view->serverUrl($view->baseUrl('user/login'))." using any of your identities(email or username) and the password you provided during registration. </p>
		<p>If you happen to forget your login credentials, go to ".$view->serverUrl($view->baseUrl('user/recoverpassword')).". For any other issues, questions or feedback, please feel free to contact us.</p>";
		$template->assign('contents', $message_contents);
	
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
	
		// configure base stuff
		$mail->addTo($this->getEmail(), $this->getName());
		// set the send of the email address
		$mail->setFrom(getDefaultAdminEmail(), getDefaultAdminName());
	
		$subject = sprintf($this->translate->_('profile_email_subject_invite_confirmation'), getAppName());
		$mail->setSubject($subject);
		// render the view as the body of the email
	
		$html = $template->render('default.phtml');
		$mail->setBodyHtml($html);
		// debugMessage($html); // exit();
			
		try {
			$mail->send();
		} catch (Exception $e) {
			$session->setVar(ERROR_MESSAGE, 'Email notification not sent! '.$e->getMessage());
		}
	
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		$mail->clearFrom();
	
		if($save_toinbox){
			# save copy of message to user's application inbox
			$message_dataarray = array(
					"senderid" => DEFAULT_ID,
					"subject" => $subject,
					"contents" => $message_contents,
					"html" => $html,
					"type" => $type,
					"subtype" => $subtype,
					"refid" => $this->getID(),
					"recipients" => array(
							md5(1) => array("recipientid" => $this->getID())
					)
			); // debugMessage($message_dataarray);
			// process message data
			$message = new Message();
			$message->processPost($message_dataarray);
			$message->save();
		}
	
		return true;
	}
	# set activation code to change user's email
	function triggerEmailChange($newemail) {
		$this->setActivationKey($this->generateActivationKey());
		$this->setTempEmail($newemail);
		$this->save();
		$this->sendNewEmailActivation();
		return true;
	}
	# send new email change confirmation
	function sendNewEmailActivation() {
		$session = SessionWrapper::getInstance();
		$template = new EmailTemplate();
		# create mail object
		$mail = getMailInstance();
		$view = new Zend_View();
		
		// assign values
		$template->assign('firstname', $this->getFirstName());
		$template->assign('newemail', $this->getTempEmail());
		$viewurl = $template->serverUrl($template->baseUrl('profile/newemail/id/'.encode($this->getID()).'/actkey/'.$this->getActivationKey()));
		$template->assign('activationurl', $viewurl);
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		
		// configure base stuff
		$mail->addTo($this->getEmail(), $this->getName());
		// set the send of the email address
		$mail->setFrom(getDefaultAdminEmail(), getDefaultAdminName());
		
		$mail->setSubject($this->translate->_('profile_email_subject_changeemail'));
		// render the view as the body of the email
		$mail->setBodyHtml($template->render('emailchangenotification.phtml'));
		// debugMessage($template->render('emailchangenotification.phtml')); exit();
		try {
			$mail->send();
		} catch (Exception $e) {
			$session->setVar(ERROR_MESSAGE, 'Email notification not sent! '.$e->getMessage());
		}
	
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		$mail->clearFrom();
	
		return true;
	}
	# Send a notification to agent that their account will be approved shortly
	function sendDeactivateNotification() {
		$session = SessionWrapper::getInstance();
		$template = new EmailTemplate();
		# create mail object
		$mail = getMailInstance();
		
		// assign values
		$template->assign('firstname', $this->getFirstName());
		// $template->assign('activationurl', array("action"=> "activate", "actkey" => $this->getActivationKey(), "id" => encode($this->getID())));
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		
		// configure base stuff
		$mail->addTo($this->getEmail(), $this->getName());
		// set the send of the email address
		$mail->setFrom(getDefaultAdminEmail(), getDefaultAdminName());
		
		$mail->setSubject("Account Deactivation");
		// render the view as the body of the email
		$mail->setBodyHtml($template->render('accountdeactivationconfirmation.phtml'));
		// debugMessage($template->render('accountdeactivationconfirmation.phtml')); // exit();
		try {
			$mail->send();
		} catch (Exception $e) {
			$session->setVar(ERROR_MESSAGE, 'Email notification not sent! '.$e->getMessage());
		}
	
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		$mail->clearFrom();
		
		return true;
	}
	# change email notification to new address
	function sendNewEmailNotification($newemail) {
		$session = SessionWrapper::getInstance();
		$template = new EmailTemplate();
		# create mail object
		$mail = getMailInstance();

		// assign values
		$template->assign('firstname', $this->getFirstName());
		$template->assign('fromemail', $this->getEmail());
		$template->assign('toemail', $newemail);
		$template->assign('code', $this->getActivationKey());
		$viewurl = $template->serverUrl($template->baseUrl('profile/changeemail/id/'.encode($this->getID())."/actkey/".$this->getActivationKey()."/ref/".encode($newemail)."/"));
				$template->assign('activationurl', $viewurl);

		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');

		// configure base stuff
		$mail->addTo($newemail, $this->getName());
		// set the send of the email address
		$mail->setFrom(getDefaultAdminEmail(), getDefaultAdminName());

		$mail->setSubject("Email Change Request");
		// render the view as the body of the email
		$mail->setBodyHtml($template->render('changeemail_newnotification.phtml'));
		// debugMessage($template->render('changeemail_newnotification.phtml')); exit();
		try {
			$mail->send();
		} catch (Exception $e) {
			$session->setVar(ERROR_MESSAGE, 'Email notification not sent! '.$e->getMessage());
		}

		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		$mail->clearFrom();

		return true;
	}
	# change email notification to old address
	function sendOldEmailNotification($newemail) {
		$session = SessionWrapper::getInstance();
		$template = new EmailTemplate();
		# create mail object
		$mail = getMailInstance();

		// assign values
		$template->assign('firstname', $this->getFirstName());
		$template->assign('fromemail', $this->getEmail());
		$template->assign('toemail', $newemail);

		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');

		// configure base stuff
		$mail->addTo($this->getEmail(), $this->getName());
		// set the send of the email address
		$mail->setFrom(getDefaultAdminEmail(), getDefaultAdminName());

		$mail->setSubject("Email Change Request");
		// render the view as the body of the email
		$mail->setBodyHtml($template->render('changeemail_oldnotification.phtml'));
		// debugMessage($template->render('changeemail_oldnotification.phtml')); //exit();
		
		try {
			$mail->send();
		} catch (Exception $e) {
			$session->setVar(ERROR_MESSAGE, 'Email notification not sent! '.$e->getMessage());
		}

		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		$mail->clearFrom();

		return true;
	}
	# invite one user to join. already existing persons
	function inviteOne() {
		$session = SessionWrapper::getInstance();
		$this->setDateInvited(date('Y-m-d'));
		$this->setIsInvited('1');
		$this->setHasAcceptedInvite('0');
		
		if($this->isCompanyAdmin()){
			$this->getCompany()->setDateInvited(date('Y-m-d'));
			$this->getCompany()->setIsInvited('1');
			$this->getCompany()->setHasAcceptedInvite('0');
			$this->getCompany()->setInvitedbyid($session->getVar('userid'));
		}
		// debugMessage($this->toArray()); exit();
		$this->save();

		// send email
		$this->sendProfileInvitationNotification();

		return true;
	}
	# Send contact us notification
	function sendContactNotification($dataarray) {
		$template = new EmailTemplate();
		# create mail object
		$mail = getMailInstance();
		$view = new Zend_View();

		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');

		// debugMessage($first);
		// assign values
		$template->assign('name', $dataarray['name']);
		$template->assign('email', $dataarray['email']);
		$template->assign('subject', $dataarray['subject']);
		$template->assign('message', nl2br($dataarray['message']));

		$mail->setSubject("New Contact Us Message: ".$dataarray['subject']);
		// set the send of the email address
		$mail->setFrom($dataarray['email'], $dataarray['name']);

		// configure base stuff
		$mail->addTo($this->config->notification->supportemailaddress);
		// render the view as the body of the email
		$mail->setBodyHtml($template->render('contactconfirmation.phtml'));
		// debugMessage($template->render('contactconfirmation.phtml')); exit();
		$mail->send();

		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		$mail->clearFrom();
	
		return true;
	}
	# invite user to activate via email
	function inviteViaEmail(){
		$session = SessionWrapper::getInstance();
		if($this->sendProfileInvitationNotification()){
			$session->setVar('invitesuccess', "Email Invitation sent to ".$this->getEmail());
		}
	
		return true;
	}
	/**
	 * Reset the password for  the user. All checks and validations have been completed
	 * 
	 * @param String $newpassword The new password. If the new password is not defined, a new random password is generated
	 *
	 * @return Boolean TRUE if the password is changed, FALSE if it fails to change the user's password.
	 */
	function resetPassword($newpassword = "") {
	 	# check if the password is empty 
	 	if (isEmptyString($newpassword)) {
	 		# generate a new random password
	 		$newpassword = $this->generatePassword(); 
	 	}
	 	return $this->changePassword($newpassword); 
	}
	/**
	 * Change the password for the user. All checks and validations have been completed
	 * 
	 * @param String $providedpassword The password provided on the screen
	 * @param String $newpassword The new password
	 *
	 * @return TRUE if the password is changed, FAlSE if it fails to change the user's password.
	 */
	function changePassword($newpassword){
		$session = SessionWrapper::getInstance();
		
		// now change the password
		$this->setPassword(sha1($newpassword));
		$this->setActivationKey('');
		
		try {
			$this->save();
			
			$view = new Zend_View();
			$url = $view->serverUrl($view->baseUrl('profile/view/id/'.encode($this->getID())));
			$usecase = '1.8';
			$module = '1';
			$type = USER_CHANGE_PASSWORD;
			$details = "Password for <a href='".$url."' class='blockanchor'>".$this->getName()."</a> Changed";
			
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
			
			return true;
		} catch (Exception $e) {
			// debugMessage($e->getMessage());
			$session->setVar(ERROR_MESSAGE, "Error in changing Password. ".$e->getMessage());
			return false;
		}
	}
	/*
	 * Reset the user's password and send a notification to complete the recovery  
	 *
	 * @return Boolean TRUE if resetting is successful and FALSE if emailaddress security questions and answer is invalid or has no record in the database
	 */
	function recoverPassword() {
		$session = SessionWrapper::getInstance();
		# reset the password and set the next password change date
		$this->setActivationKey($this->generateActivationKey()); // debugMessage($this->toArray());
		# save the activation key for the user 
		$this->save();
		
		# Send the user the reset password email
		$this->sendRecoverPasswordEmail();
		
		$view = new Zend_View();
		$url = $view->serverUrl($view->baseUrl('profile/view/id/'.encode($this->getID())));
		$usecase = '1.14';
		$module = '1';
		$type = USER_RECOVER_PASSWORD;
		$details = "Recover password request for <a href='".$url."' class='blockanchor'>".$this->getName()."</a>";
		
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
		
		return true;
	}
	/**
	 * Send an email with a link to activate the users' account
	 */
	function sendRecoverPasswordEmail() {
		$session = SessionWrapper::getInstance(); 
		$template = new EmailTemplate(); 
		// create mail object
		$mail = getMailInstance(); 

		// assign values
		$template->assign('firstname', $this->getFirstName());
		// just send the parameters for the activationurl, the actual url will be built in the view 
		// $template->assign('resetpasswordurl', array("controller"=> "user","action"=> "resetpassword", "actkey" => $this->getActivationKey(), "id" => encode($this->getID())));
		$viewurl = $template->serverUrl($template->baseUrl('user/resetpassword/id/'.encode($this->getID())."/actkey/".$this->getActivationKey()."/")); 
		$template->assign('resetpasswordurl', $viewurl);
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		
		// configure base stuff
		$mail->addTo($this->getEmail());
		// set the send of the email address
		$mail->setFrom(getDefaultAdminEmail(), getDefaultAdminName());
		
		$mail->setSubject($this->translate->_('profile_email_subject_recoverpassword'));
		// render the view as the body of the email
		$mail->setBodyHtml($template->render('recoverpassword.phtml'));
		// debugMessage($template->render('recoverpassword.phtml')); 
		try {
			$mail->send();
		} catch (Exception $e) {
			$session->setVar(ERROR_MESSAGE, 'Email notification not sent! '.$e->getMessage());
		}
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		$mail->clearFrom();
		
		return true;
   }
   /**
    * Process the activation key from the activation email
    * 
    * @param $actkey The activation key 
    * 
    * @return bool TRUE if the signup process completes successfully, false if activation key is invalid or save fails
    */
   function activateAccount($actkey, $checkkey = true) {
		# validate the activation key 
		if($this->getActivationKey() != $actkey && $checkkey){
			// debugMessage('failed');
			# Log to audit trail when an invalid activation key is used to activate account
			$audit_values = array("executedby" => $this->getID(), "transactiontype" => USER_SIGNUP, "success" => "N");
			$audit_values["transactiondetails"] = "Invalid Activation Code specified for User(".$this->getID().") (".$this->getEmail()."). "; 
			// $this->notify(new sfEvent($this, USER_SIGNUP, $audit_values));
			$this->getErrorStack()->add("user.activationkey", $this->translate->_("profile_invalid_actkey_error"));
			return false;
		}
		
		# set active to true and blank out activation key
		$this->setStatus(1);		
		$this->setActivationKey("");
		$startdate = DEFAULT_DATETIME;
		$this->setActivationDate($startdate);
		if($this->isCompanyAdmin()){
			$expirydate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($startdate)). " +".getTrialDays()." days "));
			
			$this->getCompany()->setStartDate($startdate);
			$this->getCompany()->setEndDate($expirydate);
			$this->getCompany()->setStatus(1);
		}
	
		# save
		try {
			$this->save();
			
			# Add to audittrail that a new user has been activated.
			$audit_values = array("executedby" => $this->getID(), "transactiontype" => USER_SIGNUP, "success" => "Y");
			$audit_values["transactiondetails"] = $this->getID()." (".$this->getEmail().") has completed the sign up process"; 
			// $this->notify(new sfEvent($this, USER_SIGNUP, $audit_values));
		
			return true;
			
		} catch (Exception $e){
			$this->getErrorStack()->add("user.activation", $this->translate->_("profile_activation_error"));
			$this->logger->err("Error activating User ".$this->getEmail()." ".$e->getMessage());
			// debugMessage($e->getMessage());
			# log to audit trail when an error occurs in updating payee details on user account
			$audit_values = array("executedby" => $this->getID(), "transactiontype" => USER_SIGNUP, "success" => "N");
			$audit_values["transactiondetails"] = "An error occured in activating account for User(".$this->getID().") (".$this->getEmail()."): ".$e->getMessage(); 
			// $this->notify(new sfEvent($this, USER_SIGNUP, $audit_values));
			return false;
		}
   	}
   
	/**
    * Process the deactivation for an agent
    * 
    * @param $actkey The activation key 
    * 
    * @return bool TRUE if the signup process completes successfully, false if activation key is invalid or save fails
    */
   function deactivateAccount($status = 0) {
   		# save to the audit trail
   		
		# set active to true and blank out activation key
		$this->setStatus($status);		
		$this->setActivationKey('');
		// $this->setActivationDate(NULL);
		if($this->getusergroups()->count() == 0){
			$this->getusergroups()->get(1)->setUserID($this->getID());
			$this->getusergroups()->get(1)->setGroupID($this->getType());
		}
		
		$this->save();
		
		return true;
   }
	/**
	 * Generate a new password incase a user wants a new password
	 * 
	 * @return String a random password 
	 */
    function generatePassword() {
		return $this->generateRandomString($this->config->password->passwordminlength);
    }
	/**
	 * Generate a 10 digit activation key  
	 * 
	 * @return String An activation key
	 */
    function generateActivationKey() {
		return substr(md5(uniqid(mt_rand(), 1)), 0, 6);
    }
   /**
    * Find a user account either by their email address 
    * 
    * @param String $email The email
    * @return UserAccount or FALSE if the user with the specified email does not exist 
    */
	function findByEmail($email) {
		# query active user details using email
		$q = Doctrine_Query::create()->from('UserAccount u')->where('u.email = ?', $email);
		$result = $q->fetchOne(); 
		
		# check if the user exists 
		if(!$result){
			# user with specified email does not exist, therefore is valid
			$this->getErrorStack()->add("user.invalid", $this->translate->_("profile_user_invalid_error"));
			return false;
		}
		
		$data = $result->toArray(); 

		# merge all the data including the user groups 
		$this->merge($data);
		# also assign the identifier for the object so that it can be updated
		$this->assignIdentifier($data['id']); 
		
		return true; 
	}
	# find user by email
	function populateByEmail($email) {
		# query active user details using email
		$q = Doctrine_Query::create()->from('UserAccount u')->where('u.email = ?', $email);
		$result = $q->fetchOne(); 
		
		# check if the user exists 
		if(!$result){
			$result = new UserAccount();
		}
		
		return $result; 
	}
	# find user by phone
	function populateByPhone($phone) {
		$query = Doctrine_Query::create()->from('UserAccount m')->where("m.phone = '".$phone."' || m.phone LIKE '%".getShortPhone($phone)."%'");
		//debugMessage($query->getSQLQuery());
		$result = $query->execute();
		return $result->get(0);
	}
	function findByUsername($username) {
		# query active user details using email
		$q = Doctrine_Query::create()->from('UserAccount u')->where('u.username = ?', $username);
		$result = $q->fetchOne(); 
		
		if($result){
			$data = $result->toArray(); 
		} else {
			$data = $this->toArray(); 
		}
		
		# merge all the data including the user groups 
		$this->merge($data);
		# also assign the identifier for the object so that it can be updated
		if($result){
			$this->assignIdentifier($data['id']);
		} 
		
		return true; 
	}
	/**
	 * Return the user's full names, which is a concatenation of the first and last names
	 *
	 * @return String The full name of the user
	 */
	function getName() {
		// return !isEmptyString($this->getDisplayName()) ? $this->getDisplayName() : $this->getFirstName()." ".$this->getLastName()." ".$this->getOtherName();
		return $this->getFirstName()." ".$this->getLastName()." ".$this->getOtherName();
	}
	function getDisplayName(){
		return $this->getName();
	}
	# function to determine the user's profile path
	function getProfilePath() {
		$path = "";
		$view = new Zend_View();
		// $path = '<a href="'.$view->serverUrl($view->baseUrl('user/'.strtolower($this->getUserName()))).'">'.$view->serverUrl($view->baseUrl('user/'.strtolower($this->getUserName()))).'</a>';
		$path = '<a href="javascript: void(0)">'.$view->serverUrl($view->baseUrl('user/'.strtolower($this->getUserName()))).'</a>';
		return $path;
	}
	/*
	 * TODO Put proper comments
	 */
	function generateRandomString($length) {
		$rand_array = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","0","1","2","3","4","5","6","7","8","9");
		$rand_id = "";
		for ($i = 0; $i <= $length; $i++) {
			$rand_id .= $rand_array[rand(0, 35)];
		}
		return $rand_id;
	}
 	/**
     * Return an array containing the IDs of the groups that the user belongs to
     *
     * @return Array of the IDs of the groups that the user belongs to
     */
    function getGroupIDs() {
        $ids = array();
        $groups = $this->getUserGroups();
        //debugMessage($groups->toArray());
        foreach($groups as $thegroup) {
            $ids[] = $thegroup->getGroupID();
        }
        return $ids;
    }
    /**
     * Display a list of groups that the user belongs
     *
     * @return String HTML list of the groups that the user belongs to
     */
    function displayGroups() {
        $groups = $this->getUserGroups();
        $str = "";
        if ($groups->count() == 0) {
            return $str;
        }
        $str .= '<ul class="list">';
        foreach($groups as $thegroup) {
            $str .= "<li>".$thegroup->getGroup()->getName()."</li>"; 
        }
        $str .= "</ul>";
        return $str; 
    }
	
	/**
     * Determine the gender strinig of a person
     * @return String the gender
     */
    function getGenderLabel(){
    	if($this->isMale()){
			return 'Male';
		}
		if($this->isFemale()){		
			return 'Female';
		}
		return '';
    }
 	/**
     * Determine if a person is male
     * @return bool
     */
    function isMale(){
    	return $this->getGender() == '1' ? true : false; 
    }
	/**
     * Determine if a person is female
     * @return bool
     */
    function isFemale(){
    	return $this->getGender() == '2' ? true : false; 
    }
	# Determine gender text depending on the gender
	function getGenderText(){
		if($this->isMale()){
			return 'Male';
		}
		if($this->isFemale()){		
			return 'Female';
		}
		return '';
	}
	# Determine if user profile has been activated
	function isActivated(){
		return $this->getStatus() == 1;
	}
	# Determine if user has accepted terms
	function hasAcceptedTerms(){
		return $this->getAgreedToTerms() == 1;
	}
    # Determine if user is active	 
	function isUserActive() {
		return $this->getStatus() == 1;
	}
	# determine text to display depending on the status of the user
	function getStatusLabel(){
		return $this->getStatus() == 1 ? 'Active' : 'Inactive';
	}
    # Determine if user is deactivated
	function isUserInActive() {
		return $this->getStatus() == 0 ? true : false;
	}
	# determine if user has been pending
	function isPending() {
		return $this->getStatus() == 1 ? true : false;
	}
	# determine if user has been deactivated
	function isDeactivated() {
		return $this->getStatus() == 2 ? true : false;
	}
	# function get user type
	function getUserTypeText(){
		return getUserType($this->getType());
	}
	# determine if is an admin
	function isAdmin(){
    	return $this->getType() == 1 ? true : false; 
    }
    # determinie if is a company admin
    function isCompanyAdmin() {
    	return $this->getType() == 3 ? true : false; 
    }
    # determine if is an employee
    function isEmployee(){
    	return $this->getType() == 2 ? true : false; 
    }
    # determine if loggedin user is data clerk
    function isTimesheetEmployee() {
    	$session = SessionWrapper::getInstance();
    	$acl = getACLInstance();
    
    	return $this->getType() == '2' && ($this->getIsTimesheetuser() == '1' || $this->getIsTimesheetuser() == '2') ? true : false;
    }
    # determine if user is a permanent staff
	function isPermanent(){
    	return $this->getEmpStatus() == 1 ? true : false; 
    }
	# determine if user is a temporally staff
	function isTemporally(){
    	return $this->getEmpStatus() == 2 ? true : false; 
    }
    # determine if an intern
    function isIntern(){
    	return $this->getEmpStatus() == 3 ? true : false;
    }
    # determine if person has not been invited
    function hasNotBeenInvited() {
    	return $this->getIsInvited() == 0 ? true : false;
    }
    # determine if person has been invited
    function hasBeenInvited() {
    	return $this->getIsInvited() == 1 ? true : false;
    }
    function hasAcceptedInvitation() {
    	return $this->getHasAcceptedInvite() == 1 ? true : false;
    }
    # determine if user has pending activation
    function hasPendingActivation() {
   		return $this->isUserInActive() && $this->hasBeenInvited() && !isEmptyString($this->getInvitedByID()) ? true : false;
    }
	# Return the date of birth 
	function getBirthDateFormatted() {
		$birth = "--";
		if(!isEmptyString($this->getDateOfBirth())){
			$birth = changeMySQLDateToPageFormat($this->getDateOfBirth());
		} 
		return $birth;
	}
	# relative path to profile image
	function hasProfileImage(){
		$real_path = BASE_PATH.DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."users".DIRECTORY_SEPARATOR."user_";
		$real_path = $real_path.$this->getID().DIRECTORY_SEPARATOR."avatar".DIRECTORY_SEPARATOR."medium_".$this->getProfilePhoto();
		// debugMessage($real_path);
		if(file_exists($real_path) && !isEmptyString($this->getProfilePhoto())){
			return true;
		}
		return false;
	}
	# determine if person has profile image
	function getRelativeProfilePicturePath(){
		$real_path = BASE_PATH.DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."users".DIRECTORY_SEPARATOR."user_";
		$real_path = $real_path.$this->getID().DIRECTORY_SEPARATOR."avatar".DIRECTORY_SEPARATOR."medium_".$this->getProfilePhoto();
		if(file_exists($real_path) && !isEmptyString($this->getProfilePhoto())){
			return $real_path;
		}
		$real_path = BASE_PATH.DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."users".DIRECTORY_SEPARATOR."user_0".DIRECTORY_SEPARATOR."avatar".DIRECTORY_SEPARATOR."default_medium_male.jpg";
		if($this->isFemale()){
			$real_path = BASE_PATH.DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."users".DIRECTORY_SEPARATOR."user_0".DIRECTORY_SEPARATOR."avatar".DIRECTORY_SEPARATOR."default_medium_female.jpg";
		}
		return $real_path;
	}
	# determine path to small profile picture
	function getSmallPicturePath() {
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$path = $baseUrl.'/uploads/default/default_small_male.jpg';
		if($this->isFemale()){
			$path = $baseUrl.'/uploads/default/default_small_female.jpg'; 
		}
		if($this->hasProfileImage()){
			$path = $baseUrl.'/uploads/users/user_'.$this->getID().'/avatar/small_'.$this->getProfilePhoto();
		}
		return $path;
	}
	# determine path to thumbnail profile picture
	function getThumbnailPicturePath() {
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$path = $baseUrl.'/uploads/default/default_thumbnail_male.jpg';
		if($this->isFemale()){
			$path = $baseUrl.'/uploads/default/default_thumbnail_female.jpg'; 
		}
		if($this->hasProfileImage()){
			$path = $baseUrl.'/uploads/users/user_'.$this->getID().'/avatar/thumbnail_'.$this->getProfilePhoto();
		}
		return $path;
	}
	# determine path to medium profile picture
	function getMediumPicturePath() {
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$path = "";
		$path = $baseUrl.'/uploads/default/default_medium_male.jpg';
		if($this->isFemale()){
			$path = $baseUrl.'/uploads/default/default_medium_female.jpg'; 
		}
		if($this->hasProfileImage()){
			$path = $baseUrl.'/uploads/users/user_'.$this->getID().'/avatar/medium_'.$this->getProfilePhoto();
		}
		// debugMessage($path);
		return $path;
	}
	# determine path to large profile picture
	function getLargePicturePath() {
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$path = $baseUrl.'/uploads/default/default_large_male.jpg';
		if($this->isFemale()){
			$path = $baseUrl.'/uploads/default/default_large_female.jpg'; 
		}
		if($this->hasProfileImage()){
			$path = $baseUrl.'/uploads/users/user_'.$this->getID().'/avatar/large_'.$this->getProfilePhoto();
		}
		# debugMessage($path);
		return $path;
	}
	# Get the full name of the country from the two digit code
	function getCountryName() {
		if(isEmptyString($this->getCountry())){
			return "--";
		}
		if($this->getCountry() == 'UG'){
			return "Uganda";
		}
		$countries = getCountries(); 
		return $countries[$this->getCountry()];
	}
	# determine full address
	function getFullAddress(){
		$str = '';
		if(!isEmptyString($this->getAddress1())){
			$str .= nl2br($this->getAddress1());
		}
		if(!isEmptyString($this->getAddress2())){
			$str .= '<br>'.nl2br($this->getAddress2());
		}
		return $str;
	}
	# determine the days of week for attendance as array
	function getDaysOfWeekArray() {
		return isEmptyString($this->getWorkingDays()) ? array() : explode(',',preg_replace('!\s+!', '', trim($this->getWorkingDays())));
	}
	# determine the days of week for attendance as comma list
	function getAttendanceDaysOfWeek(){
		$listarray = array(); $text = '';
		$allvalues = getDaysOfWeek();
		$thevalues = $this->getDaysOfWeekArray();
		if(isEmptyString($this->getWorkingDays())){
			return $text;
		}
		if(count($thevalues) > 0){
			foreach ($thevalues as $value) {
				if(!isArrayKeyAnEmptyString($value, $allvalues)){
					$listarray[] = $allvalues[$value];
				}
			}
		}
		if(count($listarray) > 0){
			$text = createHTMLCommaListFromArray($listarray, ', ');
		}
		return $text;
	}
	# determine the rate currency on profile
	function getCurrencyName(){
		$str = 'UGX';
		if(!isEmptyString($this->getRateCurrency()) && $this->getRateCurrency() != 'UGX'){
			$str = $this->getRateCurrency();
		}
		return $str;
	}
	# determine the leave events for user
	function getLeaveRequests($userid = '', $start, $end){
		return true;
		$q = Doctrine_Query::create()->from('Leave t')->where("t.userid = '".$this->getID()."' ")->orderby('t.datecreated desc');
		$result = $q->execute();
		return $result;
	}
	# generate approved timesheets for user within a period
	function getTimesheetDetails($startdate, $enddate, $status = 3) {
		# query active user details using email
		$q = Doctrine_Query::create()->from('Timesheet t')->where("t.userid = '".$this->getID()."' AND  TO_DAYS(t.timesheetdate) BETWEEN TO_DAYS('".$startdate."') AND TO_DAYS('".$enddate."') AND t.status = '".$status."' ");
		return $q->execute();;
	}
	# determine if the farmer registered themselves
	function isSelfRegistered(){
		return $this->getselfregistered() == '1' ? true : false;
	}
	# determine if user has allowed to receive email notifications
	function allowEmailForTimesheetApproval(){
		return $this->getemailon_tsheet_approvalcompleted() == '1' ? true : false;
	}
	function allowEmailForBenefitApproval(){
		return $this->getemailon_benefit_approvalcompleted() == '1' ? true : false;
	}
	function allowEmailForLeaveApproval(){
		return $this->getemailon_leave_approvalcompleted() == '1' ? true : false;
	}
	function allowEmailForPayslip(){
		return $this->getemailon_payslip_completed() == '1' ? true : false;
	}
	function allowEmailForPrivateMessage(){
		return $this->getemailon_directmessage_recieved() == '1' ? true : false;
	}
}
?>
