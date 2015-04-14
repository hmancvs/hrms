<?php
/**
 * Model for Timesheet
 */
class Timesheet extends BaseEntity  {
	
	public function setTableDefinition() {
		parent::setTableDefinition();
		
		$this->setTableName('timesheet');
		$this->hasColumn('userid', 'integer', null, array('notblank' => true));
		$this->hasColumn('datein','date', null);
		$this->hasColumn('timein', 'string', 50);
		$this->hasColumn('dateout','date', null);
		$this->hasColumn('timeout', 'string', 50);
		$this->hasColumn('hours', 'decimal', 10, array('scale' => '2','default' => null));
		$this->hasColumn('status', 'integer', null, array('default' => 1));
		$this->hasColumn('inremarks', 'string', 1000);
		$this->hasColumn('outremarks', 'string', 1000);
		$this->hasColumn('timesheetdate','date', null, array('default' => NULL));
		//$this->hasColumn('datesubmitted', 'string', 255, array('default' => NULL));
		$this->hasColumn('dateapproved','date', null, array('default' => NULL));
		
		$this->hasColumn('hours', 'decimal', 10, array('scale' => '2','default' => '0.00'));
		$this->hasColumn('status', 'integer', null, array('default' => NULL)); // '0'=>'On Duty', '1'=>'Logged', '2'=>'Submitted', '3'=>'Approved', '4'=>'Rejected', '5'=>'Overdue'
		$this->hasColumn('approvedbyid', 'integer', null, array('default' => NULL));
		$this->hasColumn('notes', 'string', 1000);
		$this->hasColumn('comments', 'string', 255);
		$this->hasColumn('payrollid', 'integer', null, array('default' => NULL));
		$this->hasColumn('isrequest', 'integer', null, array('default' => NULL));
	}
	
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array("timesheetdate","dateapproved","datein","dateout","datesubmitted"));
		
		// set the custom error messages
		$this->addCustomErrorMessages(array(
										"userid.notblank" => "No user specified for Timesheet",
										"timesheetdate.notblank" => "Please enter Timesheet Date"
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
		$this->hasOne('UserAccount as approver',
				array(
						'local' => 'approvedbyid',
						'foreign' => 'id'
				)
		);
	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues) {
		// trim spaces from the name field
		if(isArrayKeyAnEmptyString('status', $formvalues)){
			unset($formvalues['status']);
		}
		if(isArrayKeyAnEmptyString('companyid', $formvalues)){
			unset($formvalues['companyid']);
		}
		if(isArrayKeyAnEmptyString('userid', $formvalues)){
			unset($formvalues['userid']);
		}
		if(isArrayKeyAnEmptyString('startdate', $formvalues)){
			unset($formvalues['startdate']);
		}
		if(isArrayKeyAnEmptyString('enddate', $formvalues)){
			unset($formvalues['enddate']);
		}
		if(isArrayKeyAnEmptyString('dateapproved', $formvalues)){
			unset($formvalues['dateapproved']);
		}
		if(isArrayKeyAnEmptyString('datesubmitted', $formvalues)){
			unset($formvalues['datesubmitted']);
		}
		if(isArrayKeyAnEmptyString('timesheetdate', $formvalues)){
			unset($formvalues['timesheetdate']);
		}
		if(isArrayKeyAnEmptyString('approvedbyid', $formvalues)){
			unset($formvalues['approvedbyid']);
		}
		if(isArrayKeyAnEmptyString('datein', $formvalues)){
			unset($formvalues['datein']);
		} else {
			$formvalues['datein'] = date('Y-m-d', strtotime($formvalues['datein']));
		}
		if(isArrayKeyAnEmptyString('dateout', $formvalues)){
			unset($formvalues['dateout']);
		} else {
			$formvalues['dateout'] = date('Y-m-d', strtotime($formvalues['dateout']));
		}
		if(isArrayKeyAnEmptyString('timein', $formvalues)){
			unset($formvalues['timein']);
		} else {
			$formvalues['timein'] = date("H:i:s", strtotime($formvalues['timein']));
		}
		if(isArrayKeyAnEmptyString('timeout', $formvalues)){
			unset($formvalues['timeout']);
		} else {
			$formvalues['timeout'] = date("H:i:s", strtotime($formvalues['timeout']));
		}
		if(isArrayKeyAnEmptyString('payrollid', $formvalues)){
			unset($formvalues['payrollid']);
		}
		if(isArrayKeyAnEmptyString('isrequest', $formvalues)){
			unset($formvalues['isrequest']);
		}
		// debugMessage($formvalues); exit();
		parent::processPost($formvalues);
	}
	
	# determine hours for an attendance record
	function getComputedHours(){
		$hours = 0;
		if(!isEmptyString($this->getTimeIn()) && !isEmptyString($this->getTimeOut())){
			$fulldatein = strtotime($this->getDateIn().' '.$this->getTimeIn()); 
			$fulldateout = strtotime($this->getDateOut().' '.$this->getTimeOut());
			$hours = $fulldateout - $fulldatein; 
			$hours = formatNumber($hours/3600); // debugMessage($hours);
		}
		return $hours;
	}
	# check if timesheet is approved
	function isApproved(){
		return $this->getStatus() == 3 ? true: false;
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
		$subject = "Timesheet ".$statuslabel;
		
		$save_toinbox = true;
		$type = "timesheet";
		$subtype = "timesheet_".strtolower($statuslabel);
		$viewurl = $template->serverUrl($template->baseUrl('timesheets/attendance'));
		
		$rejectreason = "";
		if($this->isRejected()){
			$rejectreason = "<br><b>Synopsis:</b> ".$this->getComments()."";
		}
		$message_contents = "<p>This is to confirm that your Timesheet for <b>".changeMySQLDateToPageFormat($this->getTimesheetdate())." (".formatNumber($this->getHours())." Hours)</b> has been successfully ".$statuslabel.$rejectreason.".</p>
		<p>To view your Timesheet online <a href='".$viewurl."'>click here<a></p>
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

		if($this->getUser()->allowEmailForTimesheetApproval() && !isEmptyString($this->getUser()->getEmail())){
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