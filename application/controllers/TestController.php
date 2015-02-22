<?php

class TestController extends IndexController  {
	
	function emailAction(){
    	$this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(TRUE);
	    
	    sendTestMessage('test email','this is a test message please ignore - '.APPLICATION_ENV);
    }
    
    function checkinAction(){
    	$session = SessionWrapper::getInstance();
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(TRUE);
    	$formvalues = $this->_getAllParams();
    	debugMessage('test');
    
    	$testarray = array(
    			"userid" => 15,
    			'datein' => 'Jan 27, 2015',
    			'timein' => '08:00 AM',
    			'dateout' => '',
    			'timeout' => '',
    			'reason' => '',
    			'createdby' => 15
    
    	);
    	$attendance = new Attendance();
    	debugMessage($attendance->toArray());
    	$attendance->processPost($testarray);
    	debugMessage($attendance->toArray());
    	debugMessage('errors are '.$attendance->getErrorStackAsString());
    	try {
    		$attendance->save();
    		debugMessage('saved successfully');
    		debugMessage($attendance->toArray());
    			
    	} catch (Exception $e) {
    		debugMessage('error: '.$e->getMessage());
    	}
    }
}
