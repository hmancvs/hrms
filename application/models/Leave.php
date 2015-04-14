<?php
/**
 * Model for leave
 */
class Leave extends BaseEntity  {
	
	public function setTableDefinition() {
		parent::setTableDefinition();
		
		$this->setTableName('leave');
		$this->hasColumn('userid', 'integer', null, array('notblank' => true));
		$this->hasColumn('typeid', 'integer', null, array('notblank' => true));
		$this->hasColumn('startdate','date', null, array('notblank' => true));
		$this->hasColumn('starttime', 'string', 15);
		$this->hasColumn('enddate','date', null, array('notblank' => true));
		$this->hasColumn('endtime', 'string', 15);
		$this->hasColumn('returndate','date', null, array('default' => NULL));
		$this->hasColumn('returntime', 'string', 15);
		$this->hasColumn('duration', 'decimal', 10, array('scale' => '2','default' => '0','notblank' => true));
		$this->hasColumn('durationtype', 'integer', null, array('default' => '1'));
		$this->hasColumn('status', 'integer', null, array('default' => NULL));
		$this->hasColumn('remarks', 'string', 1000);
		$this->hasColumn('dateapproved','date', null, array('default' => NULL));
		$this->hasColumn('approvedbyid', 'integer', null, array('default' => NULL));
		$this->hasColumn('reason', 'string', 1000);
	}
	
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array("startdate","enddate","returndate"));
		
		// set the custom error messages
		$this->addCustomErrorMessages(array(
										"userid.notblank" => $this->translate->_("leave_userid_error"),
										"type.notblank" => $this->translate->_("leave_type_error"),
										"startdate.notblank" => $this->translate->_("leave_startdate_error"),
										"enddate.notblank" => $this->translate->_("leave_enddate_error"),
										"duration.notblank" => $this->translate->_("leave_duration_error")
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
		$this->hasOne('LeaveType as type',
						array(
								'local' => 'typeid',
								'foreign' => 'id'
						)
		);
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
		if(isArrayKeyAnEmptyString('returndate', $formvalues)){
			unset($formvalues['returndate']);
		}
		if(isArrayKeyAnEmptyString('durationtype', $formvalues)){
			unset($formvalues['durationtype']);
		} else {
			if($formvalues['durationtype'] == 2){
				$formvalues['duration'] = $formvalues['duration'] * getHoursInDay();
				$formvalues['durationtype'] = 1;
			}
		}
		if(isArrayKeyAnEmptyString('dateapproved', $formvalues)){
			unset($formvalues['dateapproved']);
		}
		if(isArrayKeyAnEmptyString('approvedbyid', $formvalues)){
			unset($formvalues['approvedbyid']);
		}
		if(isArrayKeyAnEmptyString('starttime', $formvalues)){
			unset($formvalues['starttime']);
		} else {
			$formvalues['starttime'] = date("H:i:s", strtotime($formvalues['starttime']));
		}
		if(isArrayKeyAnEmptyString('endtime', $formvalues)){
			unset($formvalues['endtime']);
		} else {
			$formvalues['endtime'] = date("H:i:s", strtotime($formvalues['endtime']));
		}
		if(isArrayKeyAnEmptyString('returntime', $formvalues)){
			unset($formvalues['returntime']);
		} else {
			$formvalues['returntime'] = date("H:i:s", strtotime($formvalues['returntime']));
		}
		
		if(!isArrayKeyAnEmptyString('istaken', $formvalues)){
			$formvalues['status'] = 4;
		}
		// debugMessage($formvalues); //exit();
		parent::processPost($formvalues);
	}
	
	# determine if request has pending approval
	function isPending(){
		return $this->getStatus() == 0 ? true : false;
	}
	# determine if request is approved
	function isApproved(){
		return $this->getStatus() == 1 ? true : false;
	}
	# determine if request is rejected
	function isRejected(){
		return $this->getStatus() == 2 ? true : false;
	}
	# determine if user has completed their leave
	function isOnLeave(){
		return $this->getStatus() == 3 ? true : false;
	}
	# determine if user has completed their leave
	function hasCompletedLeave(){
		return $this->getStatus() == 4 ? true : false;
	}
	# send notifications
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
		$subject = "Leave ".$statuslabel;
	
		$save_toinbox = true;
		$type = "leave";
		$subtype = "leave_".strtolower($statuslabel);
		$viewurl = $template->serverUrl($template->baseUrl('leave/view/id/'.encode($this->getID())));
	
		$rejectreason = "";
		if($this->isRejected()){
			$rejectreason = "<br><b>Synopsis:</b> ".$this->getComments()."";
		}
		$days = $this->getDuration()/getHoursInDay();
		$message_contents = "<p>This is to confirm that your Leave Request from <b>".changeMySQLDateToPageFormat($this->getStartDate())."</b> to <b> ".changeMySQLDateToPageFormat($this->getEndDate())."</b> has been successfully ".$statuslabel.$rejectreason.".</p>
		<p>To view your request online <a href='".$viewurl."'>click here<a></p>
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