<?php

class TestController extends IndexController  {
	
	function emailAction(){
    	$this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(TRUE);
	    
	    sendTestMessage('test email','this is a test message please ignore - '.APPLICATION_ENV);
    }
}
