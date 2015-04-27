<?php

require_once 'eventdispatcher/sfEventDispatcher.php';
require_once 'eventdispatcher/sfEvent.php';

# event hander functionality
require_once APPLICATION_PATH.'/includes/eventhandlerfunctions.php';

class IndexController extends Zend_Controller_Action  {

	/**
	 * Logger instance
	 * 
	 * @var Zend_Log
	 */
	protected $_logger; 
	/**
	 * Translation instance
	 * 
	 * @var Zend_Translate 
	 */
	protected $_translate; 
	/**
	 * Dispatcher to handle events
	 *
	 * @var sfEventDispatcher
	 */
	protected $_eventdispatcher; 
	
	public function init(){
        // Initialize logger and translate actions
		$this->_logger = Zend_Registry::get("logger"); 
		$this->_translate = Zend_Registry::get("translate");
		// set the redirector to ignore the baseurl for redirections
		$this->_helper->redirector->setPrependBase(false); 
		
		$this->_eventdispatcher = initializeSFEventDispatcher();
		
		// load the application configuration
		loadConfig(); 
		
		$this->view->referer = $this->getRequest()->getHeader('referer');
		$this->view->viewurl = $_SERVER['REQUEST_URI'];
		// debugMessage($this->view->viewurl);
		// debugMessage($this->getRequest()); 
		$isvalid = false;
		$host = giveHost($this->view->serverUrl()); // debugMessage($host);
		$this->view->domain = str_replace('http://','',strtolower($host));
		$subdomain = getSubdomain($this->view->serverUrl());
		$this->view->subdomain = strtolower($subdomain);
		
		if($subdomain == "www"){
			$this->_helper->redirector->gotoUrl('http://'.$host);
			exit;
		}
		// debugMessage('subdomain '.$subdomain);
		if(!isEmptyString($subdomain) && strtolower($host) == "hrmagic.ug"){
			$session = SessionWrapper::getInstance();
			$session->setVar('companyid', '');
			
			$company = new Company();
			if($company->isRenderable($subdomain)){
				$isvalid = true; // debugMessage('valid');
			} else { 
				// debugMessage('invalid');
			}
			
			if($isvalid){
				// if valid subdomain, set id to session
				$companyid = $company->findByUsername($subdomain);
				$session->setVar('cid', $companyid);
			} else {
				// subdomain not found. redirect to 404 page.
				$domain = str_replace($subdomain.'.', '', $this->view->serverUrl());
				// debugMessage('d is '.$domain);
				$this->_helper->redirector->gotoUrl(stripUrl($domain).'/index/error');
			}
		}
		
		$url = array(
		    'http://www.domain.com', // www
		    'http://domain.com', // --nothing--
		    'https://domain.com', // --nothing--
		    'www.domain.com', // www
		    'domain.com', // --nothing--
		    'www.domain.com/some/path', // www
		    'http://sub.domain.com/domain.com', // sub
		    'http://sub-domain.domain.net/domain.net', // sub-domain
		    'sub-domain.third-Level_DomaIN.domain.uk.co/domain.net' // sub-domain
		);
		/* foreach ($url as $u) {
		    debugMessage(getSubdomain($u));
		} */
		// exit();
		
		# set default timezone based on company in session
		# date_default_timezone_set(getTimeZine());
    }
    
    /**
     * Application landing page 
     */
    public function indexAction()  {
    	$session = SessionWrapper::getInstance(); 
    	if($this->getRequest()->getControllerName() == 'index' && !isEmptyString($session->getVar('userid'))){
    		$this->_helper->redirector->gotoUrl($this->view->baseUrl("dashboard"));
    	}
   	 	if($this->getRequest()->getControllerName() == 'index' && isEmptyString($session->getVar('userid'))){
    		$this->_helper->redirector->gotoUrl($this->view->baseUrl("user/login"));
    	}
    }
    
	/**
     * Action to display the access denied page when a user cannot execute the specified action on a resource    
     */
    public function accessdeniedAction()  {
        // do nothing 
    }
    
   public function createAction() {
    	// debugMessage($this->_getAllParams()); exit();
   		// $this->_setParam('id', NULL); // exit();
   		$session = SessionWrapper::getInstance(); 
    	// the name of the class to be instantiated
    	$classname = $this->_getParam("entityname");
    	$new_object = new $classname();
    	
    	// parameters for the response - default do not prepend the baseurl 
    	$response_params = array(); 
    	// add the createdby using the id of the user in session
    	if (isEmptyString($this->_getParam('id'))) {
    		// new entity
    		$this->_setParam('createdby', $session->getVar('userid'));
    		
    		// merge the post data to enable loading of any relationships in process post
    		//  TODO: Verify if this breaks any other functionality
			$new_object->merge(array_remove_empty($this->_getAllParams()), false); 
    	} else {
    		// id is already encoded during update so no need to encode it again 
    		$response_params['id'] = $this->_getParam('id'); 
    		// decode the id field and add it back to the array otherwise it will cause a type error during processPost
    		$this->_setParam('id', decode($this->_getParam('id'))); 
    		// load the details for the current entity from the database 
    		$new_object->populate($this->_getParam('id'));
    		$this->_setParam('lastupdatedby', $session->getVar('userid'));
    	}
    	
    	// populate the object with data from the post and validate the object
    	// to ensure that its wellformed 
    	$new_object->processPost($this->_getAllParams());
		/* debugMessage($new_object->toArray());
		debugMessage('errors are '.$new_object->getErrorStackAsString());
		exit(); */
    	if ($new_object->hasError()) {
    		// there were errors - add them to the session
    		$this->_logger->info("Validation Error for ".$classname." - ".$new_object->getErrorStackAsString());
    		$session->setVar(FORM_VALUES, $this->_getAllParams());
    		$session->setVar(ERROR_MESSAGE, $new_object->getErrorStackAsString());
    		$response_params['id'] = encode($this->_getParam('id'));  
    		 
    		// return to the create page
    		if (isEmptyString($this->_getParam(URL_FAILURE))) {
    			$this->_helper->redirector->gotoSimple('index', # the action 
	    							    $this->getRequest()->getControllerName(), # the current controller
	    								$this->getRequest()->getModuleName(), # the current module,
	    								$response_params
    	                             );
    	        return false; 
    		} else {
    			$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_FAILURE)), $response_params); 
    			return false; 
    		}
    	} // end check for whether errors occured during the population of the object instance from the submitted data
    	
    	// save the object to the database
    	try {
    		switch ($this->_getParam('action')) {
				case "" :
				case ACTION_CREATE :
					if(in_array($new_object->getTableName(), array('useraccount'))){
						$new_object->transactionSave();
					} else {
						$new_object->beforeSave(); 
						$new_object->save(); 
						// there are no errors so call the afterSave() hook
						$new_object->afterSave();
					}
					/* debugMessage($new_object->toArray());
					debugMessage('errors are '.$new_object->getErrorStackAsString()); exit(); */
					break;
				case ACTION_EDIT:  
					// update the entity 
					$new_object->beforeUpdate();
					$new_object->save(); 
					// there are no errors so call the afterSave() hook
					$new_object->afterUpdate();
					// debugMessage('errors are '.$new_object->getErrorStackAsString()); exit();
					break; 
				case ACTION_DELETE:  
					// update the entity 
					$new_object->delete(); 
					// there are no errors so call the afterSave() hook
					$new_object->afterDelete();
					break;
				case ACTION_APPROVE:  
					// update the entity 
					$new_object->approve(); 
					// there are no errors so call the afterSave() hook
					$new_object->afterApprove();
					break;  
				default :
					break;
    		}
    		# exit();
    		// add a success message, if any, to the session for display
    		if (!isEmptyString($this->_getParam(SUCCESS_MESSAGE))) {
    			$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate($this->_getParam(SUCCESS_MESSAGE)));
    		}
    		if (isEmptyString($this->_getParam(URL_SUCCESS))) {
    			// add the id of the new object created which is encoded 
    			$response_params['id'] = encode($new_object->getID()); 
	    		$this->_helper->redirector->gotoSimple('view', # the action 
	    							    $this->getRequest()->getControllerName(), # the current controller
	    								$this->getRequest()->getModuleName(), # the current module,     															
	    	                             $response_params # the parameters for the response
	    	                             );
	    	    return false; 
    		} else {
    			$url = decode($this->_getParam(URL_SUCCESS));
    			if(!isArrayKeyAnEmptyString('nosuccessid', $this->_getAllParams())){
    				$this->_helper->redirector->gotoUrl($url);	
    			} else {
    				// check if the last character is a / then add it
	    			if (substr($url, -1) != "/") {
	    				 // add the slash
	    				 $url.= "/"; 
	    			}
	    			// add the ID parameter
	    			$url.= "id/".encode($new_object->getID()); 
	    			$this->_helper->redirector->gotoUrl($url, $response_params); 
    			}
    			
    			return false; 
    		}
    	} catch (Exception $e) {
    		$session->setVar(FORM_VALUES, $this->_getAllParams());
    		$session->setVar(ERROR_MESSAGE, $e->getMessage()); 
    		$this->_logger->err("Saving Error ".$e->getMessage());
    		// debugMessage($e->getMessage()); exit();
    		
    		// return to the create page
    		if (isEmptyString($this->_getParam(URL_FAILURE))) {
    			$this->_helper->redirector->gotoSimple('index', # the action 
	    							    $this->getRequest()->getControllerName(), # the current controller
	    								$this->getRequest()->getModuleName(), # the current module, 
	    								$response_params 
    	                             );
    	        return false; 
    		} else {
    			$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_FAILURE)), $response_params); 
    			return false; 
    		}
    	}
    	// exit();
    }

    public function editAction() {
    	$this->_setParam("action", ACTION_EDIT); 
    	$this->createAction();
    }
    
	public function deleteAction() {
    	$this->_setParam("action", ACTION_DELETE);
    
    	$session = SessionWrapper::getInstance();
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(TRUE);
    
    	$formvalues = $this->_getAllParams(); // debugMessage($formvalues); // exit;
    	$successurl = decode($formvalues[URL_SUCCESS]);
    	if(!isArrayKeyAnEmptyString(SUCCESS_MESSAGE, $formvalues)){
    		$successmessage = decode($formvalues[SUCCESS_MESSAGE]);
    	}
    	$classname = $formvalues['entityname'];
    	$altclassname = '';
    	if(!isArrayKeyAnEmptyString('altdeleteentity', $formvalues)){
    		$altclassname = $formvalues['altdeleteentity'];
    	}
    	// debugMessage($successurl);
    
    	$obj = new $classname;
    	$id = is_numeric($formvalues['id']) ? $formvalues['id'] : decode($formvalues['id']); // debugMessage($id);
    	$obj->populate($id); // debugMessage($obj->toArray());
    	$beforedelete = $obj->toArray(true); // debugMessage($beforedelete);
    	$prejson = json_encode($beforedelete); // debugMessage($postjson);
    	/* debugMessage($obj->toArray());
    	 exit(); */
    	
    	# prepare to notify depending on the action
    	switch ($classname) {
    		case 'UserAccount':
				$module = '1';
				$usecase = '1.5';
				$type = USER_DELETE;
				$deletedetails = 'User Profile <b>'.$obj->getName().'</b> successfully deleted';
    	
    			break;
    		case 'LookupTypeValue':
    			$module = '0';
    			$usecase = '0.3';
    			$type = SYSTEM_DELETEVARIABLE;
    			$var_type = 'Variable';
    			if($classname == 'LookupTypeValue'){
    				$var_type = 'Variable ';
    				$deletedetails = 'Variable - <b>'.$obj->getlookupvaluedescription().' </b>('.$obj->getLookupType()->getdisplayname().') successfully deleted';
    			}
    			break;
    		case 'AclGroup':
    			$module = '0';
    			$usecase = '0.6';
    			$type = SYSTEM_DELETEROLE;
    			$deletedetails = 'Role <b>'.$obj->getName().'</b> successfully deleted';
    			break;
    		default:
    			break;
    	}
    	
    	$browser = new Browser();
    	$audit_values = $session->getVar('browseraudit');
    	$audit_values['module'] = $module;
    	$audit_values['usecase'] = $usecase;
    	$audit_values['transactiontype'] = $type;
    	$audit_values['status'] = "Y";
    	$audit_values['userid'] = $session->getVar('userid');
    	$audit_values['transactiondetails'] = $deletedetails;
    	$audit_values['prejson'] = $prejson;
    	// debugMessage($audit_values); 
    	// exit(); 
    	
    	if($obj->delete()) {
    		if(!isArrayKeyAnEmptyString('altdeleteid', $formvalues)){
    			$altobj = new $altclassname;
    			$altobj->populate($formvalues['altdeleteid']);
    			if(!isEmptyString($altobj->getID())){
    				$altobj->delete();
    			}
    		}
    		$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate("global_delete_success"));
    		$successmessage = $this->_getParam(SUCCESS_MESSAGE);
    		if(!isEmptyString($successmessage)){
    			$session->setVar(SUCCESS_MESSAGE, $successmessage);
    		}
    		$this->notify(new sfEvent($this, $type, $audit_values));
    	}
    	$this->_helper->redirector->gotoUrl($successurl);
    }
    
	public function approveAction() {
    	$this->_setParam("action", ACTION_APPROVE); 
    	$this->createAction();
    }
    
	public function rejectAction() {
    	$this->_setParam("action", ACTION_APPROVE); 
    	$this->createAction();
    }
    
    public function listAction() {
    	$listcount = new LookupType();
    	$listcount->setName("LIST_ITEM_COUNT_OPTIONS");
    	$values = $listcount->getOptionValues(); 
    	asort($values, SORT_NUMERIC); 
    	$session = SessionWrapper::getInstance();
    	
    	$dropdown = new Zend_Form_Element_Select('itemcountperpage',
							array(
								'multiOptions' => $values, 
								'view' => new Zend_View(),
								'decorators' => array('ViewHelper'),
							    'class' => array('form-control','width75','inline','input-sm','perpageswitcher')
							)
						);
		if (isEmptyString($this->_getParam('itemcountperpage'))) {
			if(!isEmptyString($session->getVar('itemcountperpage'))){			
				$dropdown->setValue($session->getVar('itemcountperpage'));
				if($session->getVar('itemcountperpage') == 'ALL'){
					$session->setVar('itemcountperpage', '');
					$dropdown->setValue('50');
				}
			} else {
				$dropdown->setValue('50');
			}
		} else {
			$session->setVar('itemcountperpage', $this->_getParam('itemcountperpage'));
			$dropdown->setValue($session->getVar('itemcountperpage'));
		}
		
	    $this->view->listcountdropdown = '<span>Per page: '.$dropdown->render().'</span>'; 
    }
    /**
     * Redirect list searches to maintain the urls as per zend format 
     */
    public function listsearchAction() {
    	//debugMessage($this->getRequest()->getQuery());
    	// debugMessage($this->_getAllParams()); exit();
    	$this->_helper->redirector->gotoSimple(ACTION_LIST, $this->getRequest()->getControllerName(), 
    											$this->getRequest()->getModuleName(),
    											array_remove_empty(array_merge_maintain_keys($this->_getAllParams(), $this->getRequest()->getQuery())));
    }
    public function viewAction() {
    	
    }
    
    public function returntolistAction(){
    	$this->_helper->redirector->gotoSimple(ACTION_LIST, $this->getRequest()->getControllerName(), 
    											$this->getRequest()->getModuleName(), 
    											array_remove_empty(array_merge_maintain_keys($this->_getAllParams(), $this->getRequest()->getQuery())));    
    }
    public function newAction(){
    	$this->_helper->redirector->gotoSimple(ACTION_INDEX, $this->getRequest()->getControllerName(), 
    											$this->getRequest()->getModuleName(), 
    											array_remove_empty(array_merge_maintain_keys($this->_getAllParams(), $this->getRequest()->getQuery())));  
    }	
    
    function overviewAction() {
    	
    }
	
    public function exportAction() {
    	
    }
	/**
     * Notify all listeners of the event, through the event dispatcher instance for the class. This is just a convenience method to
     * avoid accessing the event dispatcher directly
     *
     * @param sfEvent $event The event that has occured
     */
    function notify($event) {
    	$this->_eventdispatcher->notify($event); 
    }
    
    function selectchainAction() {
	    $select_type = $this->_getParam(SELECT_CHAIN_TYPE); 
		
    	switch ($select_type) { 		
			default:
				echo '';
				break;
		}
		
		// disable rendering of the view and layout so that we can just echo the AJAX output 
	    $this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(TRUE);
	}
	function selectchaincustomAction() {
		// disable rendering of the view and layout so that we can just echo the AJAX output 
	    $this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(TRUE);    
		$select_type = $this->_getParam(SELECT_CHAIN_TYPE); 
		
		switch ($select_type) {
			
			default:
				# get all the villages in a parishes
				echo '';
				break;
		}
	}
	/**
     * Action to download details into MS Excel
    */
    public function exceldownloadAction()  {
    	// disable rendering of the view and layout so that we can just echo the AJAX output
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

        // required for IE, otherwise Content-disposition is ignored
		if(ini_get('zlib.output_compression')) {
			ini_set('zlib.output_compression', 'Off');
		}
		
		$response = $this->getResponse();
		
		# This line will stream the file to the user rather than spray it across the screen
		$response->setHeader("Content-type", "application/vnd.ms-excel");
		
		# replace excelfile.xls with whatever you want the filename to default to
		$response->setHeader("Content-Disposition", "attachment;filename=".time().rand(1, 10).".xls");
		$response->setHeader("Expires", 0);
		$response->setHeader("Cache-Control", "private");
		session_cache_limiter("public");
		
		$session = SessionWrapper::getInstance();
		
		# the coluumns that have numbers, these have to be formatted differently from the rest of the
		# columns
		$number_column_array = explode(",", $this->_getParam(EXPORT_NUMBER_COLUMN_LIST));
		
		$xml = new ExcelXML();
		// the number of columns to ignore in the query, these are usually ids
		$xml->setStartingColumn(trim($this->_getParam(EXPORT_IGNORE_COLUMN_COUNT)));
		echo $xml->generateXMLFromQuery($session->getVar(CURRENT_RESULTS_QUERY));
    }
	/**
     * Action to download details into MS Excel
    */
    public function printerfriendlyAction()  {
    	
    }
    /**
     * Clear user specific cache items on expiry of the session or logout of the user
     *
     */
    public function clearUserCache() {
    	$session = SessionWrapper::getInstance(); 
    	
    	// clear the acl instance for the user
        $aclkey = "acl".$session->getVar('userid'); 
        $cache = Zend_Registry::get('cache');
        $cache->remove($aclkey); 
    }
    /**
     * Clear the user session and any cache files 
     *
     */
    function clearSession() {
    	// clear user specific cache
    	$this->clearUserCache();
    	
        // clear the session
        $session = SessionWrapper::getInstance(); 
        $session->clearSession();
    }
    
    /**
     * Pre-processing for all actions
     *
     * - Disable the layout when displaying printer friendly pages 
     *
     */
    function preDispatch(){
    	// disable rendering of the layout so that we can just echo the AJAX output
    	if(!isEmptyString($this->_getParam(PAGE_CONTENTS_ONLY))) { 
    		$this->_helper->layout->disableLayout();
    	}
    } 
    
    public function addsuccessAction(){
		$session = SessionWrapper::getInstance(); 
     	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$formvalues = $this->_getAllParams();
		$this->_setParam("action", ACTION_VIEW);
		
		$session->setVar(SUCCESS_MESSAGE, "Successfully saved");
   		if(!isArrayKeyAnEmptyString('successmessage', $formvalues)){
			$session->setVar(SUCCESS_MESSAGE, decode($formvalues['successmessage']));
		}
		
    } 

	public function adderrorAction(){
		$session = SessionWrapper::getInstance(); 
     	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$formvalues = $this->_getAllParams();
		
		$currenterror = $session->getVar(ERROR_MESSAGE);
		if(isEmptyString($currenterror)){
			$session->setVar(ERROR_MESSAGE, "An error occured in updating database");
		}  
	}
	
	public function profileupdatesuccessAction(){
		$session = SessionWrapper::getInstance(); 
     	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$formvalues = $this->_getAllParams();
		
		$session->setVar(SUCCESS_MESSAGE, "Profile successfully updated");
		if(!isArrayKeyAnEmptyString('successmessage', $formvalues)){
			$session->setVar(SUCCESS_MESSAGE, decode($formvalues['successmessage']));
		}
	}
	
	public function updatesuccessAction(){
		$session = SessionWrapper::getInstance(); 
     	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$formvalues = $this->_getAllParams();
    	
		$session->setVar(SUCCESS_MESSAGE, "Successfully updated");
		if(!isArrayKeyAnEmptyString('successmessage', $formvalues)){
			$session->setVar(SUCCESS_MESSAGE, decode($formvalues['successmessage']));
		}
    }
	
	public function themechangeAction(){
		$session = SessionWrapper::getInstance();
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$formvalues = $this->_getAllParams();
		$conn = Doctrine_Manager::connection();
		$session->setVar($this->_getParam('type'), $this->_getParam('value'));
		$layout = $this->_getParam('type');
		$query = "UPDATE company set ".$layout." = '".$this->_getParam('value')."' where id = '".getCompanyID()."' "; // debugMessage($query);
		$result = $conn->execute($query);
	}
	
	public function colorchangeAction(){
		$session = SessionWrapper::getInstance();
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$formvalues = $this->_getAllParams();
		$conn = Doctrine_Manager::connection();
		$session->setVar('colortheme', $this->_getParam('value'));
		// echo 'colortheme now '.$session->getVar('colortheme');
		$query = "UPDATE company set colortheme = '".$this->_getParam('value')."' where id = '".getCompanyID()."' ";
		$result = $conn->execute($query);
	}
	
	public function sidebarconfigAction(){
		$session = SessionWrapper::getInstance();
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$formvalues = $this->_getAllParams();
		$conn = Doctrine_Manager::connection();
		$session->setVar('showsidebar', $this->_getParam('value'));
		// echo 'toggle now is '.$session->getVar('show_sidebar');
		$query = "UPDATE company set showsidebar = '".$this->_getParam('value')."' where id = '".getCompanyID()."' ";
		$result = $conn->execute($query);
	}
	
	public function changecompanyAction(){
		$session = SessionWrapper::getInstance();
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$formvalues = $this->_getAllParams(); // debugMessage($formvalues); exit;
		$session->setVar('companyid', $this->_getParam('companyid'));
		
		$company = new Company();
		$company->populate($this->_getParam('companyid'));
		$companyname = $company->getName();
		$session->setVar(SUCCESS_MESSAGE, "Successfully switched default Company to ".$companyname.".");
		$url = decode($this->_getParam(URL_SUCCESS));
		/* if($url == "hrmagic.ug" && !isEmptyString($company->getUsername())){
			$url = "http://".$company->getUsername().".".$url;
		} */
		$this->_helper->redirector->gotoUrl($url);
	}

	// generate payslip, save to user's inbox and send emails
	public function issuepayslipsAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$session = SessionWrapper::getInstance();
		$formvalues = $this->_getAllParams(); // debugMessage($formvalues); exit;
		$config = Zend_Registry::get("config");
	
		// generate the payslips silently via ajax
		$payroll = new Payroll();
		$payroll->populate($this->_getParam('id'));
	
		$employees = $payroll->getdetails(); // debugMessage($employees->toArray());
		foreach ($employees as $employee){
			if(/* $employee->getUserID() == 15 &&  */$employee->getIsIgnored() != 1 && $employee->getNetPay() > 0){ // ignore users who are skipped on payroll or have 0 netpay
				$payrolldetailid = $employee->getID();
				$path = $employee->getPDFPath();
				$pdfurl = $this->view->serverUrl($this->view->baseUrl('user/view/id/'.encode($employee->getUserID()).'/tab/payment/payrollid/'.$payrolldetailid.'/ref/view/print/1/pgc/1/payslipview/1/pdf/1/source/payroll'));
				// debugMessage($pdfurl);
				$pdfresult = trim(file_get_contents($pdfurl));
				$html = decode($pdfresult); // debugMessage($html); // exit;
	
				if(!isEmptyString($html)){
					try {
						$mpdfpath = BASE_PATH.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'mpdf'.DIRECTORY_SEPARATOR.'mpdf.php'; // debugMessage('pdf '.$mpdfpath);
						ini_set('memory_limit','128M');
							
						require_once($mpdfpath);
						// ob_get_clean();
						$mpdf = new mPDF('win-1252','A4','','',20,15,40,20,10,10);
						$mpdf->useOnlyCoreFonts = true;    // false is default
						$mpdf->SetProtection(array('print'));
						$mpdf->SetTitle("Payslip - ".$employee->getUser()->Name());
						$mpdf->SetAuthor(getAppName());
						$mpdf->SetWatermarkText(getCompanyName());
						$mpdf->showWatermarkText = true;
						$mpdf->watermark_font = 'DejaVuSansCondensed';
						$mpdf->watermarkTextAlpha = 0.1;
						$mpdf->SetDisplayMode('fullpage');
						$mpdf->WriteHTML($html);
						$mpdf->Output($path);
						// $mpdf->Output($employee->getPDFName().'.pdf', 'I');
	
					} catch (Exception $e) {
						debugMessage('error '.$e->getMessage());
					}
	
					if(file_exists($path)){
						debugMessage('pdf '.$employee->getPDFName().' created ');
						// $employee->afterPayslipGeneration();
					} else {
						debugMessage('pdf missing');
					}
				}
			}
		}
		$session->setVar("issuepayslips", '0'); // reset flag for determining if payslips are sent
	}
	
	public function errorAction(){
		//$this->_helper->layout->disableLayout();
		// $this->_helper->viewRenderer->setNoRender(TRUE);
		$session = SessionWrapper::getInstance();
	
	}
}