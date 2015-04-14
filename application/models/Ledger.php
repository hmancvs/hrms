<?php
/**
 * Model for ledger
 */
class Ledger extends BaseEntity  {
	
	public function setTableDefinition() {
		parent::setTableDefinition();
		
		$this->setTableName('ledger');
		$this->hasColumn('userid', 'integer', null, array('notblank' => true));
		$this->hasColumn('companyid', 'integer', null, array('default' => NULL));
		$this->hasColumn('ledgertype', 'integer', null, array('default' => NULL)); // 1 => cash, 2=> time
		$this->hasColumn('trxntype', 'integer', null, array('default' => NULL)); // 1=> credit, 2=>debit 
		$this->hasColumn('trxndate', 'date', null, array('default' => NULL));
		$this->hasColumn('startdate','date', null, array('default' => NULL));
		$this->hasColumn('enddate','date', null, array('default' => NULL));
		
		$this->hasColumn('benefitid', 'integer', null, array('default' => NULL));
		$this->hasColumn('amount', 'decimal', 10, array('scale' => '0','default' => '0'));
		$this->hasColumn('paytype', 'integer', null, array('default' => NULL));
		$this->hasColumn('istaxable', 'integer', null, array('default' => 0));
		$this->hasColumn('taxabletype', 'integer', null, array('default' => NULL));
		$this->hasColumn('filename', 'string', 255);
		
		$this->hasColumn('leaveid', 'integer', null, array('default' => NULL));
		$this->hasColumn('leavelength', 'decimal', 10, array('scale' => '1','default' => '0'));
		$this->hasColumn('lengthtype', 'integer', null, array('default' => 1)); // 1=>hours, 2=>days
		$this->hasColumn('payrollid', 'integer', null, array('default' => NULL));
		$this->hasColumn('payrolltrigger', 'integer', null, array('default' => NULL));
		$this->hasColumn('isrequest', 'integer', null, array('default' => NULL));
		$this->hasColumn('dateapproved','date', null, array('default' => NULL));
		$this->hasColumn('approvedbyid', 'integer', null, array('default' => NULL));
		$this->hasColumn('status', 'integer', null, array('default' => 1)); // 0 requested, 1 =>approved
		$this->hasColumn('remarks', 'string', 255);
	}
	
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array("startdate","enddate","trxndate"));
		
		// set the custom error messages
		$this->addCustomErrorMessages(array(
										"userid.notblank" => $this->translate->_("ledger_userid_error")
       	       						));     
	}
	/*
	 * Relationships for the model
	 */
	public function setUp() {
		parent::setUp(); 
		
		$this->hasOne('UserAccount as user',
						array(
							'local' => 'userid',
							'foreign' => 'id'
						)
		);
		$this->hasOne('Company as company',
						array(
							'local' => 'companyid',
							'foreign' => 'id'
						)
		);
		$this->hasOne('BenefitType as benefittype',
				array(
						'local' => 'benefitid',
						'foreign' => 'id'
				)
		);
		$this->hasOne('LeaveType as leavetype',
				array(
						'local' => 'leaveid',
						'foreign' => 'id'
				)
		);
		$this->hasOne('Payroll as payroll',
				array(
						'local' => 'payrollid',
						'foreign' => 'id'
				)
		);
		$this->hasOne('UserAccount as approver',
				array(
						'local' => 'approvedbyid',
						'foreign' => 'id'
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
		/* if($this->payrollCompleted()){
			$this->getErrorStack()->add("payroll.unique", "Transaction date has been rejected! <br >Approved Payroll already exists for this period. Please cancel the payroll to proceed");
		} */
	}
	
	# determine if the username has already been assigned
	function payrollCompleted(){
		$conn = Doctrine_Manager::connection();
		# validate unique username and email
		$id_check = "";
		if(!isEmptyString($this->getID())){
			$id_check = " AND p.id <> '".$this->getID()."' ";
		}
	
		$query = "SELECT p.id FROM payroll p WHERE TO_DAYS('".$this->getTrxnDate()."') BETWEEN TO_DAYS(p.startdate) AND TO_DAYS(p.enddate) AND p.status = 2 ".$id_check;
		// debugMessage($query);
		$result = $conn->fetchOne($query);
		// debugMessage($result);
		if(isEmptyString($result)){
			return false;
		}
		return true;
	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues) {
		$config = Zend_Registry::get("config");
		
		// trim spaces from the name field
		if(isArrayKeyAnEmptyString('status', $formvalues)){
			unset($formvalues['status']);
		}
		if(isArrayKeyAnEmptyString('ledgertype', $formvalues)){
			unset($formvalues['ledgertype']);
		} else {
			if($formvalues['ledgertype'] == 1){
				$formvalues['leaveid'] = NULL;
				$formvalues['leavelength'] = NULL;
				$formvalues['lengthtype'] = NULL;
				$formvalues['debitpayroll'] = NULL;
			}
			if($formvalues['ledgertype'] == 2){
				$formvalues['amount'] = NULL;
				$formvalues['benefitid'] = NULL;
			}
		}
		if(isArrayKeyAnEmptyString('trxntype', $formvalues)){
			unset($formvalues['trxntype']);
		}
		if(isArrayKeyAnEmptyString('companyid', $formvalues)){
			$formvalues['companyid'] = 1;
		}
		if(isArrayKeyAnEmptyString('benefitid', $formvalues)){
			unset($formvalues['benefitid']);
		} 
		if(isArrayKeyAnEmptyString('leaveid', $formvalues)){
			unset($formvalues['leaveid']);
		}
		if(isArrayKeyAnEmptyString('trxndate', $formvalues)){
			unset($formvalues['trxndate']);
		}
		if(isArrayKeyAnEmptyString('startdate', $formvalues)){
			unset($formvalues['startdate']);
		}
		if(isArrayKeyAnEmptyString('enddate', $formvalues)){
			unset($formvalues['enddate']);
		}
		if(isArrayKeyAnEmptyString('leavelength', $formvalues)){
			unset($formvalues['leavelength']);
		}
		if(isArrayKeyAnEmptyString('lengthtype', $formvalues)){
			unset($formvalues['lengthtype']);
		} else {
			if($formvalues['lengthtype'] == 2){
				$formvalues['leavelength'] = $formvalues['leavelength'] * getHoursInDay();
				$formvalues['lengthtype'] = 1;
			}
		}
		
		if(isArrayKeyAnEmptyString('amount', $formvalues)){
			unset($formvalues['amount']);
		}
		if(isArrayKeyAnEmptyString('debitpayroll', $formvalues)){
			unset($formvalues['debitpayroll']);
		}
		if(isArrayKeyAnEmptyString('istaxable', $formvalues)){
			unset($formvalues['istaxable']);
		}
		if(isArrayKeyAnEmptyString('taxabletype', $formvalues)){
			unset($formvalues['taxabletype']);
		}
		if(!isArrayKeyAnEmptyString('istaxable', $formvalues)){
			$formvalues['istaxable'] = 1;
		} else {
			$formvalues['istaxable'] = NULL;
		}
		if(isArrayKeyAnEmptyString('payrollid', $formvalues)){
			unset($formvalues['payrollid']);
		}
		if(isArrayKeyAnEmptyString('payrolltrigger', $formvalues)){
			unset($formvalues['payrolltrigger']);
		}
		if(isArrayKeyAnEmptyString('isrequest', $formvalues)){
			unset($formvalues['isrequest']);
		}
		// debugMessage($formvalues); exit();
		parent::processPost($formvalues);
	}
	
	# relative path to file
	function hasAttachment(){
		$real_path = BASE_PATH.DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."users".DIRECTORY_SEPARATOR."user_";
		$real_path = $real_path.$this->getUserID().DIRECTORY_SEPARATOR."benefits".DIRECTORY_SEPARATOR.$this->getFilename();
		// debugMessage($real_path);
		if(file_exists($real_path) && !isEmptyString($this->getFilename())){
			return true;
		}
		return false;
	}
	# determine path to attachment
	function getFilePath() {
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$path = '';
		if($this->hasAttachment()){
			$path = $baseUrl.'/uploads/users/user_'.$this->getUserID().'/benefits/'.$this->getFilename();
		}
		return $path;
	}
	# check if timesheet is approved
	function isApproved(){
		return $this->getStatus() == 1 ? true: false;
	}
	# check if timesheet is rejected
	function isRejected(){
		return $this->getStatus() == 4 ? true: false;
	}
	# save approval alert to application inbox and send email if specified on profile
	function afterApprove(){
		$this->sendApprovalConfirmationNotification();
		return true;
	}
	# Send notification to inform user
	function sendApprovalConfirmationNotification() {
		$template = new EmailTemplate();
		# create mail object
		$mail = getMailInstance();
		$view = new Zend_View();
		$session = SessionWrapper::getInstance();
		
		// assign values
		$template->assign('firstname', $this->getUser()->getFirstName());
		
		$statuslabel = $this->isApproved() ? "Approved" : "Rejected";
		$subject = "Benefits Requisition ".$statuslabel;
		
		$save_toinbox = true;
		$type = "benefit";
		$subtype = "benefit_".strtolower($statuslabel);
		$viewurl = $template->serverUrl($template->baseUrl('ledger/list/ledgertype/1'));
		
		$rejectreason = "";
		if($this->isRejected()){
			$rejectreason = "<br><b>Synopsis:</b> ".$this->getRemarks()."";
		}
		$message_contents = "<p>This is to confirm that your requisition for <b>".changeMySQLDateToPageFormat($this->getTrxnDate())." (".getCountryCurrencyCode(). " ".formatMoneyOnly($this->getAmount()).")</b> has been successfully ".$statuslabel.$rejectreason.".</p>
		<p>To view status online <a href='".$viewurl."'>click here<a></p>
		<br />
		<p>".$this->getApprover()->getName()."<br />
		".getAppName()."</p>
		";
		$template->assign('contents', $message_contents);

		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');

		// configure base stuff
		$mail->addTo($this->getUser()->getEmail(), $this->getUser()->getName());
		// set the send of the email address
		$mail->setFrom(getDefaultAdminEmail(), getDefaultAdminName());
		
		$mail->setSubject($subject);
		// render the view as the body of the email
		
		$html = $template->render('default.phtml');
		$mail->setBodyHtml($html);
		// debugMessage($html); exit();
		
		if($this->getUser()->allowEmailForBenefitApproval() && !isEmptyString($this->getUser()->getEmail())){
			try {
				$mail->send();
				$session->setVar("custommessage1", "Email sent to ".$this->getUser()->getEmail());
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
				"refid" => $this->getID(),
				"recipients" => array(
					md5(1) => array("recipientid" => $this->getUserID())
				)
			); // debugMessage($message_dataarray);
			// process message data
			$message = new Message();
			$message->processPost($message_dataarray);
			$message->save();
		}
	
		return true;
	}
}

?>