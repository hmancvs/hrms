<?php

class ReportController extends SecureController   {
	
	/**
	 * Get the name of the resource being accessed 
	 *
	 * @return String 
	 */
	function getActionforACL() {
		return ACTION_VIEW;
	}
	/**
	 * @see SecureController::getResourceForACL()
	 * 
	 * Return the Application Settings since we need to make the url more friendly 
	 *
	 * @return String
	 */
	function getResourceForACL() {
		$action = strtolower($this->getRequest()->getActionName()); 
		if ($action == "dashboard" || $action == "reportsearch") {
			return "Report Dashboard";
		}
		if ($action == "audittrail") {
			return "Audit Trail Report";
		}
		
		if ($action == "payrolldata") {
			return "Payroll";
		}
		if ($action == "payslips") {
			return "Payslips";
		}
		if ($action == "bankadvice") {
			return "Bank Credit Instructions";
		}
		if ($action == "nssf") {
			return "Insurance Remittance";
		}
		if ($action == "paye") {
			return "Tax Remittance";
		}
		if ($action == "financestats") {
			return "Financial Statistics Report";
		}
		if ($action == "financedetails") {
			return "Financial Analysis Report";
		}
		
		/* if ($action == "employeestats") {
			return "Employee Analysis Report";
		} */
		if ($action == "employeestats" || $action == "employeedetails") {
			return "Employee Data Report";
		}
		
		if ($action == "attendancestats") {
			return "Attendance Analysis Report";
		}
		if ($action == "attendancedetails") {
			return "Attendance Detailed Report";
		}
		
		if ($action == "benefitstats") {
			return "Benefits Analysis Report";
		}
		if ($action == "benefitdetails") {
			return "Benefits Detailed Report";
		}
		
		if ($action == "timeoffstats") {
			return "Timeoff Analysis Report";
		}
		if ($action == "timeoffdetails") {
			return "Timeoff Accruals Report";
		}
		
	}
	
	public function init()    {
		parent::init();
	
		$current_timestamp = strtotime('now'); $now_iso = date('Y-m-d H:i:s', $current_timestamp); $this->view->now_iso = $now_iso; //debugMessage('now '.$now_iso.'-'.$current_timestamp);
		$onehourago_timestamp = strtotime('-1 hour'); $onehourago_iso = date('Y-m-d H:i:s', $onehourago_timestamp );
		$this->view->onehourago_iso = $onehourago_iso; $this->view->onehourago_timestamp = $onehourago_timestamp;// debugMessage('now '.$onehourago_iso.'-'.$onehourago_timestamp);
		$sixhourago_timestamp = strtotime('-6 hour'); $sixhourago_iso = date('Y-m-d H:i:s', $sixhourago_timestamp);
		$this->view->sixhourago_iso = $sixhourago_iso; $this->view->sixhourago_timestamp = $sixhourago_timestamp;
		$twelvehourago_timestamp = strtotime('-12 hour'); $twelvehourago_iso = date('Y-m-d H:i:s', $twelvehourago_timestamp);
		$this->view->twelvehourago_timestamp = $twelvehourago_timestamp; $this->view->twelvehourago_iso = $twelvehourago_iso;
	
		// debugMessage($logged_today_sql);
		$today_iso = date('Y-m-d'); $today = changeMySQLDateToPageFormat($today_iso);  $this->view->today_iso = $today_iso; //debugMessage('today '.$today_iso);
		$today_iso_short = date('M j', $current_timestamp);
		
		$yestday_iso = date('Y-m-d', strtotime('1 day ago')); $yestday = changeMySQLDateToPageFormat($yestday_iso); $this->view->yestday_iso = $yestday_iso; //debugMessage('yesterday '.$yestday_iso);
		$yestday_iso_short = date('M j', strtotime($yestday_iso));
		$weekday = date("N");
	
		// monday of week
		$mondaythisweek_iso = date('Y-m-d', strtotime('monday this week')); $mondaythisweek = changeMySQLDateToPageFormat($mondaythisweek_iso);
		if($weekday == 1){
			$mondaythisweek_iso = $today_iso;
			$mondaythisweek = $today;
		}
		if($weekday == 7){
			$mondaythisweek_iso = date('Y-m-d', strtotime('monday last week'));
			$mondaythisweek = changeMySQLDateToPageFormat($mondaythisweek_iso);
		}
		$this->view->mondaythisweek_iso = $mondaythisweek_iso; //debugMessage('monday this week '.$mondaythisweek_iso);
	
		// sunday of week
		$sundaythisweek_iso = date('Y-m-d', strtotime('sunday this week')); $sundaythisweek = changeMySQLDateToPageFormat($sundaythisweek_iso);
		if($weekday == 1){
			$sundaythisweek_iso = date('Y-m-d', strtotime('today + 7 days')); $sundaythisweek = changeMySQLDateToPageFormat($sundaythisweek_iso);
		}
		if($weekday == 7){
			$sundaythisweek_iso = $today_iso; $sundaythisweek = $today;
		}
		$this->view->sundaythisweek_iso = $sundaythisweek_iso; // debugMessage('sunday this week '.$sundaythisweek_iso);
	
		// monday last week
		$mondaylastweek_iso = date('Y-m-d', strtotime('-7 days', strtotime($mondaythisweek_iso))); //debugMessage('monday last week '.$mondaylastweek_iso);
		$this->view->mondaylastweek_iso = $mondaylastweek_iso;
		// sunday last week
		$sundaylastweek_iso = date('Y-m-d', strtotime('-7 days', strtotime($sundaythisweek_iso))); // debugMessage('sunday last week '.$sundaylastweek_iso);
		$this->view->sundaylastweek_iso = $sundaylastweek_iso;
		
		// firstday this month
		$firstdayofthismonth_iso = getFirstDayOfCurrentMonth(); //debugMessage('1st day this month '.$firstdayofthismonth_iso);
		$this->view->firstdayofthismonth_iso = $firstdayofthismonth_iso;
		// lastday this month
		$lastdayofthismonth_iso = getLastDayOfCurrentMonth(); //debugMessage('last day this month '.$lastdayofthismonth_iso);
		$this->view->lastdayofthismonth_iso = $lastdayofthismonth_iso;
		
		// firstday last month
		$firstdayoflastmonth_iso = getFirstDayOfMonth(date('m')-1, date('Y')); //debugMessage('1st day last month '.$firstdayoflastmonth_iso);
		$this->view->firstdayoflastmonth_iso = $firstdayoflastmonth_iso;
		// lastday last month
		$lastdayoflastmonth_iso = getLastDayOfMonth(date('m')-1, date('Y')); //debugMessage('last day last month '.$lastdayoflastmonth_iso);
		$this->view->lastdayoflastmonth_iso = $lastdayoflastmonth_iso;
		
		// firstday 2 month ago
		$firstdayof2monthago_iso = getFirstDayOfMonth(date('m')-2, date('Y')); //debugMessage('1st day 2 month ago '.$firstdayof2monthago_iso);
		$this->view->firstdayof2monthago_iso = $firstdayof2monthago_iso;
		// lastday 2 month ago
		$lastdayof2monthago_iso = getLastDayOfMonth(date('m')-2, date('Y')); //debugMessage('last day last month '.$lastdayof2monthago_iso);
		$this->view->lastdayof2monthago_iso = $lastdayof2monthago_iso;
		
		// firstday 3 month ago
		$firstdayof3monthago_iso = getFirstDayOfMonth(date('m')-3, date('Y')); //debugMessage('1st day 3 month ago '.$firstdayof3monthago_iso);
		$this->view->firstdayof3monthago_iso = $firstdayof3monthago_iso;
		// lastday 3 month ago
		$lastdayof3monthago_iso = getLastDayOfMonth(date('m')-3, date('Y')); //debugMessage('last day last month '.$lastdayof3monthago_iso);
		$this->view->lastdayof3monthago_iso = $lastdayof3monthago_iso;
		
		// firstday this year
		$firstdayofyear_iso = getFirstDayOfMonth(1, date('Y')); //debugMessage('1st day this year '.$firstdayofyear_iso);
		$this->view->firstdayofyear_iso = $firstdayofyear_iso;
		// lastday this year
		$lastdayofyear_iso = getLastDayOfMonth(12, date('Y')); //debugMessage('last day this year '.$lastdayofyear_iso);
		$this->view->lastdayofyear_iso = $lastdayofyear_iso;
		// first day of month one year ago
		$startofmonth_oneyearago = getFirstDayOfMonth(date('m', strtotime('1 year ago')), date('Y', strtotime('1 year ago')));
		$this->view->startofmonth_oneyearago = $startofmonth_oneyearago;
	
		$firstsystemday_iso = '2013-01-01';
		$this->view->firstsystemday_iso = $firstsystemday_iso;
	}
		
	function dashboardAction(){
	
	}
	function audittrailAction(){
	
	}
	
	function payrolldataAction(){
		
	}
	function payslipsAction(){
	
	}
	function bankadviceAction(){
	
	}
	function payeAction(){
	
	}
	function nssfAction(){
	
	}
	function employeestatsAction(){
	
	}
	function employeedetailsAction(){
	
	}
	function benefitstatsAction(){
	
	}
	function benefitdetailsAction(){
	
	}
	function timeoffstatsAction(){
	
	}
	function timeoffdetailsAction(){
	
	}
	function attendancestatsAction(){
	
	}
	function attendancedetailsAction(){
	
	}
	/**
     * Redirect list searches to maintain the urls as per zend format 
     */
    public function reportsearchAction() {
    	// debugMessage($this->getRequest()->getQuery());
    	// debugMessage($this->_getAllParams());
    	$action = $this->_getParam('page');
    	if(!isEmptyString($this->_getParam('pageaction'))){
    		$action = $this->_getParam('pageaction');
    	}
    	//exit();
    	if(!isEmptyString($action)){
    		$this->_helper->redirector->gotoSimple($action, $this->getRequest()->getControllerName(), 
    											$this->getRequest()->getModuleName(),
    											array_remove_empty(array_merge_maintain_keys($this->_getAllParams(), $this->getRequest()->getQuery())));
    	}
    }
	/**
     * Pre-processing for all actions
     *
     * - Disable the layout when displaying printer friendly pages 
     *
     */
    function preDispatch(){
		
		parent::preDispatch();
    	// disable rendering of the layout so that we can just echo the AJAX output
    	if(!isEmptyString($this->_getParam(EXPORT_TO_EXCEL))) { 
			
			// disable rendering of the view and layout so that we can just echo the AJAX output
			$this->_helper->layout->disableLayout();			
	
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
		} 
    } 
}

