<?php

class MessageRecipient extends BaseRecord  {
	public function setTableDefinition() {
		parent::setTableDefinition();
		$this->setTableName('messagerecipient');
		$this->hasColumn('id', 'integer', 11, array('primary' => true, 'autoincrement' => true));
		$this->hasColumn('messageid', 'integer', 11, array("notblank" => true, "notnull" => true));
		$this->hasColumn('recipientid', 'integer', 11, array("notblank" => true, "notnull" => true));
		$this->hasColumn('isread', 'integer', 11, array("default" =>'0'));
	}
	
	public function setUp() {
		parent::setUp(); 
		$this->hasOne('Message as message',
							array('local' => 'messageid',
									'foreign' => 'id'
							)
						);	
		$this->hasOne('UserAccount as recipient',
							array('local' => 'recipientid',
									'foreign' => 'id'
							)
						);	
	}
	
   /**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"messageid.notblank" => $this->translate->_("message_messageid_error"),
       									"recipientid.notblank" => $this->translate->_("message_recipientid_error")
       	       						));
	}
	/*
	 * Custom model validation
	 */
	function validate() {
		// execute the column validation 
		parent::validate();
		
		// custom validatio for unique messageid and recipientid combination

	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues){
		# force setting of default none string column values. enum, int and date 	
		if(isArrayKeyAnEmptyString('isread', $formvalues)){
			$formvalues['isread'] = '0'; 
		}
		parent::processPost($formvalues);
	}
	/**
	 * 
	 * Determine if message has been read by the recipient
	 * @return Bool True if read and false otherwise
	 */
	function hasReadMessage() {
		if($this->getIsRead()== '0'){
			return false;
		} else {
			return true;
		}
	}
	/**
	 * Mark selected messages has read
	 * @param $msgdetailids an array of message recipient ids to be marked as read 
	 * @return Boolean True if successfull, false otherwise
	 */
	function markAsRead($msgdetailids, $flag) {
		$q = Doctrine_Query::create()->update('MessageRecipient')->set('isread', $flag)->whereIn('id', $msgdetailids);
			
		// $result = $q->execute(); 
		return $q->execute();
	}
	/**
	 * Calculate the number of unread messages currently availble
	 * @param $userid Integer the user's id
	 * @return Integer The number of unread messages  
	 */
	function countUnReadMessages($userid) {
		# query active user details using email
		$q = Doctrine_Query::create()
				->select('SUM(IF(mr.isread = 0, 1 , 0)) as total')
				->from('MessageRecipient mr')
				->where('mr.isread = ?', '0')
				->andWhere('mr.recipientid = ?', $userid)
				->groupBy('mr.recipientid');
				
		$result = $q->fetchOne();
		
		return isEmptyString($result['total']) ? '0' : $result['total'];
	}
	/**
	 * Delete multiple message
	 * @return Bool whether message is deleted false otherwise
	 */
	function deleteMultiple($idsarray) {
		// doctrine query to select all messages to be deleted
		$q = Doctrine_Query::create()->from('MessageRecipient m')->whereIn('m.id', $idsarray);
		// execute query
		$result = $q->execute();
	
		//debugMessage($result->toArray());
		return $result->delete();
	}
	/**
	 * Send a notification to a user that a private message has been sent to them
	 *
	 * @return Bool whether the email notification has been sent
	 *
	 */
	function sendInboxEmailNotification($fromemail ='', $fromname ='', $subject = '', $toemail = '', $toname = '', $content = '') {
		$template = new EmailTemplate();
		# create mail object
		$mail = getMailInstance();
		
		# sender name
		$sendername = getAppName();
		$sendername = $this->getMessage()->getSender()->getName();
		if(!isEmptyString($fromname)){
			$sendername = $fromname;
		}
		# sender email
		$senderemail = getDefaultAdminEmail();
		if(!isEmptyString($fromemail)){
			$senderemail = $fromemail;
		}
		
		# receipient name
		$receivername = $this->getMessage()->getSender()->getFirstName();
		if(!isEmptyString($toname)){
			$receivername = $toname;
		}
		# receipient email
		$receiveremail = $this->getMessage()->getSender()->getEmail();
		if(!isEmptyString($toemail)){
			$receiveremail = $toemail;
		}
		# email subject
		$msgsubject = sprintf($this->translate->_('message_private_email_subject'), getAppName(), $subject);
		
		# email content
		$intro = "<p><i><b>".$sendername."</b> sent you a private message via <b>".getAppName()."</b> </i></p>";
		$msgcontent = '<p>"'.$this->getMessage()->getContents().'"</p>';
		if(!isEmptyString($content)){
			$msgcontent = '<p>"'.$content.'"</p>';
		}
		
		$viewurl = $template->serverUrl($template->baseUrl('message/view/id/'.encode($this->getID())));
		if(isEmptyString($this->getID())){
			$viewurl = '';
		}
		$msgcontent .= '<p><a href="'.$viewurl.'">Click here</a> to view this message online</p>';
		// debugMessage($this->getRecipients()->toArray());
		// the message reciever's first name
		$template->assign('firstname', isEmptyString($toname) ? 'User' : $receivername);
		// the message sender's name
		$template->assign('emailsender', $sendername);
		// message subject
		$template->assign('subject', $msgsubject);
		$mail->setSubject($msgsubject);
		// add the recipient emails TODO if sent to many users, add all their emails
		$mail->addTo($toemail, $receivername);
		// set the send of the email address
		$mail->setFrom(getDefaultAdminEmail(), getAppName()." on behalf of ".$fromname);
		
		// message contents
		$template->assign('emailcontent', $intro.nl2br($msgcontent));
		// the actual url will be built in the view
		$template->assign('emaillink', $viewurl);
		// message html file
		$mail->setBodyHtml($template->render('messagenotification.phtml'));
		// debugMessage($template->render('messagenotification.phtml'));

		// send the message
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
}