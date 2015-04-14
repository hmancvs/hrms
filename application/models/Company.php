<?php
/**
 * Model for company
 */
class Company extends BaseEntity {
	
	public function setTableDefinition() {
		parent::setTableDefinition();
		
		$this->setTableName('company');
		# override the not null and not blank properties for the createdby column in the BaseEntity
		$this->hasColumn('createdby', 'integer', 11, array('default' => NULL));
		
		$this->hasColumn('refno', 'string', 15);
		$this->hasColumn('name', 'string', 255, array('notblank' => true));
		$this->hasColumn('appname', 'string', 255);
		$this->hasColumn('headertype', 'integer', null, array('default' => 0));
		$this->hasColumn('slogan', 'string', 255);
		$this->hasColumn('username', 'string', 255);
		$this->hasColumn('abbrv', 'string', 255);
		$this->hasColumn('status', 'integer', null, array('default' => NULL));
		
		$this->hasColumn('contactperson', 'string', 255);
		$this->hasColumn('email', 'string', 255);
		$this->hasColumn('phone', 'string', 15);
		$this->hasColumn('country', 'string', 2, array('default' => 'UG'));
		$this->hasColumn('addressline1', 'string', 255);
		$this->hasColumn('addressline2', 'string', 255);
		$this->hasColumn('city', 'string', 255);
		$this->hasColumn('postalcode', 'string', 10);
		$this->hasColumn('industrycode', 'string', 15);
		$this->hasColumn('description', 'string', 1000);
		
		$this->hasColumn('remarks', 'string', 255);
		$this->hasColumn('yearstart','date', null, array('default' => getFirstDayOfMonth(1, date('Y'))));
		$this->hasColumn('yearend','date', null, array('default' => getLastDayOfMonth(12, date('Y'))));
		$this->hasColumn('ipsubnets', 'string', 255);
		$this->hasColumn('hoursinday', 'string', 50, array('default' => HOURS_IN_DAY));
		$this->hasColumn('openinghour', 'string', 50, array('default' => '08:00 AM'));
		$this->hasColumn('closinghour', 'string', 50, array('default' => '05:00 PM'));
		$this->hasColumn('lunchduration', 'string', 50 , array('default' => DEFAULT_LUNCH_DURATION));
		$this->hasColumn('payspaye', 'string', 50, array('default' => 1));
		$this->hasColumn('paysnssf', 'string', 50, array('default' => 1));
		$this->hasColumn('nssfemployeerate', 'string', 50, array('default' => DEFAULT_NSSF_EMP));
		$this->hasColumn('nssfcompanyrate', 'string', 50, array('default' => DEFAULT_NSSF_COM));
		$this->hasColumn('workingdays', 'string', 50);
		$this->hasColumn('maxhoursperday', 'string', 50, array('default' => HOURS_IN_DAY));
		$this->hasColumn('maxhoursperweek', 'string', 50, array('default' => HOURS_IN_WEEK));
		
		$this->hasColumn('defaultuserid', 'integer', null, array('default' => NULL));
		$this->hasColumn('dateapproved','date', null, array('default' => NULL));
		$this->hasColumn('approvedbyid', 'integer', null, array('default' => NULL));
		$this->hasColumn('isinvited', 'integer', null, array('default' => NULL));
		$this->hasColumn('invitedbyid', 'integer', null);
		$this->hasColumn('hasacceptedinvite', 'integer', null, array('default' => 0));
		$this->hasColumn('dateinvited','date');
		$this->hasColumn('startdate','date', null, array('default' => NULL));
		$this->hasColumn('enddate','date', null, array('default' => NULL));
		
		$this->hasColumn('layout', 'string', 25, array('default' => getDefaultLayout()));
		$this->hasColumn('topbar', 'string', 25, array('default' => getDefaultTopBar()));
		$this->hasColumn('sidebar', 'string', 25, array('default' => getDefaultSideBar()));
		$this->hasColumn('colortheme', 'string', 25, array('default' => getDefaultTheme()));
		$this->hasColumn('showsidebar', 'string', 25, array('default' => getDefaultShowSideBar()));
		$this->hasColumn('logo', 'string', 255);
		
		$this->hasColumn('defaultadminname', 'string', 255, array('default' => getDefaultAdminName()));
		$this->hasColumn('defaultadminemail', 'string', 255, array('default' => getDefaultAdminEmail()));
		$this->hasColumn('currencysymbol', 'string', 15, array('default' => getCountryCurrencySymbol()));
		$this->hasColumn('currencycode', 'string', 15, array('default' => getCountryCurrencyCode()));
		$this->hasColumn('currencydecimalplaces', 'string', 15, array('default' => getCurrencyDecimalPlaces()));
		$this->hasColumn('numberdecimalplaces', 'string', 15, array('default' => getNumberDecimalPlaces()));
		$this->hasColumn('countryisocode', 'string', 15, array('default' => getCountryCode()));
		$this->hasColumn('phonemaxlength', 'string', 15, array('default' => getMaxPhoneLength()));
		$this->hasColumn('phoneminlength', 'string', 15, array('default' => getMinPhoneLength()));
		$this->hasColumn('nationalidminlength', 'string', 15, array('default' => getNationalIDMaxLength()));
		$this->hasColumn('nationalidmaxlength', 'string', 15, array('default' => getNationalIDMinLength()));
		$this->hasColumn('countryphonecode', 'string', 15, array('default' => getDefaultPhoneCode()));
		$this->hasColumn('timezone', 'string', 255, array('default' => getTimeZine()));
	}
	
	protected $confirmpassword;
	
	function getIsBeinginvited(){
		return $this->isbeinginvited;
	}
	function setIsBeingInvited($isbeinginvited) {
		$this->isbeinginvited = $isbeinginvited;
	}
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		// set the custom error messages
		$this->addCustomErrorMessages(array(
										"name.notblank" => $this->translate->_("company_name_error")
       	       						));     
	}
	/*
	 * Relationships for the model
	 */
	public function setUp() {
		parent::setUp(); 
		
		$this->hasOne('UserAccount as defaultuser',
						array(
							'local' => 'defaultuserid',
							'foreign' => 'id'
						)
		);
		$this->hasOne('UserAccount as invitedby',
				array(
						'local' => 'invitedbyid',
						'foreign' => 'id'
				)
		);
		$this->hasMany('UserAccount as users',
				array(
						'local' => 'id',
						'foreign' => 'companyid'
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
		if($this->nameExists()){
		$this->getErrorStack()->add("name.unique", "The name <b>".$this->getName()."</b> already exists. Please specify another.");
	}
	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues) {
		$session = SessionWrapper::getInstance(); //debugMessage($formvalues);
		// trim spaces from the name field
		if(isArrayKeyAnEmptyString('status', $formvalues)){
			unset($formvalues['status']);
		}
		if(isArrayKeyAnEmptyString('defaultdepartmentid', $formvalues)){
			unset($formvalues['defaultdepartmentid']);
		}
		if(isArrayKeyAnEmptyString('defaultuserid', $formvalues)){
			unset($formvalues['defaultuserid']);
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
		if(isArrayKeyAnEmptyString('isinvited', $formvalues)){
			$formvalues['isinvited'] = NULL;
		}
		if(isArrayKeyAnEmptyString('hasacceptedinvite', $formvalues)){
			$formvalues['hasacceptedinvite'] = NULL;
		}
		if(isArrayKeyAnEmptyString('dateinvited', $formvalues)){
			unset($formvalues['dateinvited']);
		}
		if(isArrayKeyAnEmptyString('startdate', $formvalues)){
			$formvalues['startdate'] = DEFAULT_DATETIME;
		}
		if(!isArrayKeyAnEmptyString('isinvited', $formvalues)){
			if($formvalues['isinvited'] == 1){
				$this->setIsBeingInvited($formvalues['isinvited']);
				$formvalues['invitedbyid'] = $session->getVar('userid');
				$formvalues['dateinvited'] = DEFAULT_DATETIME;
				$formvalues['hasacceptedinvite'] = 0;
			}
		}
		if(isArrayKeyAnEmptyString('defaultuserid', $formvalues)){
			
			$names = explode(' ', $this->getContactPerson()); debugMessage($names);
			$formvalues['defaultuser']['firstname'] = $names[0];
			if(!isArrayKeyAnEmptyString(1, $names)){
				$formvalues['defaultuser']['lastname'] = $names[1];
			} else {
				$formvalues['defaultuser']['lastname'] = '.';
			}
			if(!isArrayKeyAnEmptyString(2, $names)){
				$formvalues['defaultuser']['othername'] = $names[2];
			}
			
			$formvalues['defaultuser']['email'] = $this->getEmail();
			$formvalues['defaultuser']['status'] = 0;
			$formvalues['defaultuser']['datecreated'] = date('Y-m-d', time());
			$formvalues['defaultuser']['createdby'] = $session->getVar('userid');
			$formvalues['defaultuser']['usergroups'][0]["groupid"] = 3;
			$formvalues['defaultuser']['type'] = 3;
			if(!isArrayKeyAnEmptyString('isinvited', $formvalues)){
				$formvalues['defaultuser']['hasacceptedinvite'] = 0;
				$formvalues['defaultuser']['dateinvited'] = date('Y-m-d', time());
				$formvalues['defaultuser']['invitedbyid'] = $session->getVar('userid');
				$formvalues['isinvited'] = 1;
			}
		}
		if(isArrayKeyAnEmptyString('openinghour', $formvalues)){
			unset($formvalues['openinghour']);
		} else {
			$formvalues['openinghour'] = date("H:i:s", strtotime($formvalues['openinghour']));
		}
		if(isArrayKeyAnEmptyString('closinghour', $formvalues)){
			unset($formvalues['closinghour']);
		} else {
			$formvalues['closinghour'] = date("H:i:s", strtotime($formvalues['closinghour']));
		}
		
		if(isArrayKeyAnEmptyString('yearstart', $formvalues)){
			unset($formvalues['yearstart']);
		} else {
			$formvalues['yearstart'] = date('Y-m-d', strtotime($formvalues['yearstart']));
		}
		if(isArrayKeyAnEmptyString('yearend', $formvalues)){
			unset($formvalues['yearend']);
		} else {
			$formvalues['yearend'] = date('Y-m-d', strtotime($formvalues['yearend']));
		}
		if(isArrayKeyAnEmptyString('headertype', $formvalues)){
			$formvalues['headertype'] = 0;
		}
		// debugMessage($formvalues); exit();
		parent::processPost($formvalues);
	}
	/*
	 * Custom save logic
	*/
	function afterSave(){
		$conn = Doctrine_Manager::connection();
		$session = SessionWrapper::getInstance();
		
		if(!isEmptyString($this->getDefaultUserID()) && isEmptyString($this->getDefaultUser()->getCompanyID())){
			$this->getDefaultUser()->setCompanyID($this->getID());
			$startdate = DEFAULT_DATETIME;
			$expirydate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($startdate)). " +".getTrialDays()." days "));
			if(isEmptyString($this->getStartDate()) && $this->getID() != DEFAULT_COMPANYID){
				$this->setStartDate($startdate);
			}
			if(isEmptyString($this->getEndDate()) && $this->getID() != DEFAULT_COMPANYID){
				$this->setEndDate($expirydate);
			}
			$this->save();
		}
		
		// invite via email
		if($this->getIsInvited() == 1){
			$this->getDefaultUser()->inviteViaEmail();
		}
		return true;
	}
	# update after
	function afterUpdate(){
		$session = SessionWrapper::getInstance();
		# check if user is being invited during update
		if(!isEmptyString($this->getDefaultUserID()) && isEmptyString($this->getDefaultUser()->getCompanyID())){
			$this->getDefaultUser()->setCompanyID($this->getID());
			$startdate = DEFAULT_DATETIME;
			$expirydate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($startdate)). " +".getTrialDays()." days "));
			if(isEmptyString($this->getStartDate()) && $this->getID() != DEFAULT_COMPANYID){
				$this->setStartDate($startdate);
			}
			if(isEmptyString($this->getEndDate()) && $this->getID() != DEFAULT_COMPANYID){
				$this->setEndDate($expirydate);
			}
			$this->save();
		}
		// invite via email
		if($this->getIsInvited() == 1){
			$this->getDefaultUser()->inviteViaEmail();
		}
		
		if($this->getID() == DEFAULT_ID){
			$config_collection = new Doctrine_Collection(Doctrine_Core::getTable("AppConfig"));
			$appconfig = new AppConfig();
			$appconfig->populate(61);
			$appconfig->setOptionValue($this->getAppName());
			$config_collection->add($appconfig);
		
			$appconfig = new AppConfig();
			$appconfig->populate(62);
			$appconfig->setOptionValue($this->getName());
			$config_collection->add($appconfig);
				
			if($config_collection->count() > 0){
				$config_collection->save();
			}
		}
		return true;
	}
	# determine if the name has already been assigned
	function nameExists($name =''){
		$conn = Doctrine_Manager::connection();
		# validate unique username and email
		$id_check = "";
		if(!isEmptyString($this->getID())){
			$id_check = " AND id <> '".$this->getID()."' ";
		}
	
		if(isEmptyString($name)){
			$name = $this->getName();
		}
		$query = "SELECT id FROM department WHERE name = '".$name."' AND name <> '' ".$id_check;
		// debugMessage($query);
		$result = $conn->fetchOne($query);
		// debugMessage($result);
		if(isEmptyString($result)){
			return false;
		}
		return true;
	}
	function isInActive(){
		return $this->getStatus() == 0;
	}
	function isActive() {
		return $this->getStatus() == 1;
	}
	function isPendingApproval() {
		return $this->getStatus() == 2;
	}
	function isRejected(){
		return $this->getStatus() == 3;
	}
	# determine full address
	function getFullAddress(){
		$str = '';
		if(!isEmptyString($this->getAddressLine1())){
			$str .= nl2br($this->getAddressLine1());
		}
		if(!isEmptyString($this->getAddressLine2())){
			$str .= '<br>'.nl2br($this->getAddressLine2());
		}
		return $str;
	}
	# determine the days of week for attendance as array
	function getDaysOfWeekArray() {
		return isEmptyString($this->getWorkingDays()) ? array(1,2,3,4,5) : explode(',',preg_replace('!\s+!', '', trim($this->getWorkingDays())));
	}
	# determine the days of week for attendance as comma list
	function getAttendanceDaysOfWeek(){
		$listarray = array(); $text = '';
		$allvalues = getDaysOfWeek();
		$thevalues = $this->getDaysOfWeekArray();
		if(isEmptyString($this->getWorkingDays())){
			// return $text;
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
	# determine default app name
	function getDefaultName(){
		if(isEmptyString($this->getAppName())){
			return $this->config->system->appname;
		} else {
			return $this->getAppName();
		}
	}
	# send notifications
	function afterApprove($oldstatus = ''){
		if(($this->isActive() || $this->isRejected()) && ($oldstatus = '2' || $oldstatus = '3') ){
			$this->getDefaultUser()->sendSignupNotification($oldstatus);
		}
		# deactivate all active accounts for the company 
		if($this->isInActive() && $oldstatus = '1'){
			$this->deactivateAllAccounts();
		}
		# reactivate all previously inactive accounts for the company
		if($this->isActive() && $oldstatus = '0'){
			$this->reactivateAllAccounts();
		}
		return true;
	}
	# deactivate all user accounts
	function deactivateAllAccounts(){
		$user_collection = new Doctrine_Collection(Doctrine_Core::getTable("UserAccount"));
		$users = $this->getUsers(); //debugMessage($users->toArray());
		if($users->count() > 0){
			foreach ($users as $user){
				if($user->isUserActive()){
					$user->setStatus(0);
					$user->setActivationKey(md5($this->getCompanyID()));
				}
				$user_collection->add($user);
			}
			// debugMessage($user_collection->toArray());
		}
		if($user_collection->count() > 0){
			try {
				$user_collection->save();
			} catch (Exception $e) {
				debugMessage("An error occured in updating status. ".$e->getMessage());
			}
		}
		
		return true;
	}
	# reactivate all user accounts
	function reactivateAllAccounts(){
		$user_collection = new Doctrine_Collection(Doctrine_Core::getTable("UserAccount"));
		$users = $this->getUsers(); //debugMessage($users->toArray());
		if($users->count() > 0){
			foreach ($users as $user){
				if($user->isUserInActive() && $user->getActivationKey() == md5($this->getCompanyID())){
					$user->setStatus(1);
					$user->setActivationKey('');
					$user_collection->add($user);
				}
			}
			// debugMessage($user_collection->toArray());
		}
		if($user_collection->count() > 0){
			try {
				$user_collection->save();
			} catch (Exception $e) {
				debugMessage("An error occured in updating status. ".$e->getMessage());
			}
		}
	
		return true;
	}
	
	# relative path to profile image
	function hasProfileImage(){
		$real_path = BASE_PATH.DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."company".DIRECTORY_SEPARATOR."comp_";
		$real_path = $real_path.$this->getID().DIRECTORY_SEPARATOR."logo".DIRECTORY_SEPARATOR.$this->getLogo();
		if(file_exists($real_path) && !isEmptyString($this->getLogo())){
			return true;
		}
		return false;
	}
	
	# determine path to medium profile picture
	function getPicturePath() {
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$path = "";
		$path = $baseUrl.'/images/logo.png';
		if($this->hasProfileImage()){
			$path = $baseUrl.'/uploads/company/comp_'.$this->getID().'/logo/'.$this->getLogo();
		}
		// debugMessage($path);
		return $path;
	}
	
	function getLargePicturePath() {
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$path = "";
		$path = $baseUrl.'/images/logo.png';
		if($this->hasProfileImage()){
			$path = $baseUrl.'/uploads/company/comp_'.$this->getID().'/logo/large_'.$this->getLogo();
		}
		// debugMessage($path);
		return $path;
	}
}

?>