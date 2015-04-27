<?php 
# whether or not the session has errors
$session = SessionWrapper::getInstance(); 
$sessionhaserror = !isEmptyString($session->getVar(ERROR_MESSAGE));

$userid = $session->getVar("userid");
$nosessionid = !isEmptyString($session->getVar('cid')) ? $session->getVar('cid') : DEFAULT_COMPANYID;
$companyid = isEmptyString($session->getVar('companyid')) ? $nosessionid : $session->getVar("companyid");
$company = new Company();
$company->populate(DEFAULT_ID);
$session->setVar('defaultcompany', $company->toArray());

$company->populate($companyid);
$session->setVar('currentcompany', $company->toArray());
$session->setVar('appname', $company->getDefaultName());
$appname = $company->getDefaultName();
$logotype = $company->getHeaderType();
$logourl = $company->getPicturePath();
$haslogo = $company->hasProfileImage() ? true : false;

$loggedinuser = new UserAccount();
$loggedinuser->populate($userid);
$istimesheetuser = false;
if(isTimesheetEmployee()){
	$istimesheetuser = true;
}

$isloggedin = false;
if(!isEmptyString($userid)){
	$isloggedin = true;
} else {
	$logourl = $this->baseUrl('images/logo.png');
}
$type = $session->getVar("type");

$default_theme_data = getDefaultThemeOptions($nosessionid); //debugMessage($default_theme_data);
$current_theme_data = getDefaultThemeOptions($companyid, $default_theme_data); //debugMessage($current_theme_data);
$layout = /*!isEmptyString($session->getVar("layout")) ? $session->getVar("layout") : */$current_theme_data['layout'];
$topbar = /*!isEmptyString($session->getVar("topbar")) ? $session->getVar("topbar") : */$current_theme_data['topbar'];
$sidebar = /*!isEmptyString($session->getVar("sidebar")) ? $session->getVar("sidebar") :*/ $current_theme_data['sidebar'];
$showsidebar = /*!isEmptyString($session->getVar("showsidebar")) ? $session->getVar("showsidebar") :*/ $current_theme_data['showsidebar'];
$colortheme = /*!isEmptyString($session->getVar("colortheme")) ? $session->getVar("colortheme") : */$current_theme_data['colortheme'];

# the request object instance
$request = Zend_Controller_Front::getInstance()->getRequest();
$isprint = false;
if($request->print == 1){
	$isprint = true;
}
# application config
$config = Zend_Registry::get('config');

# pagination defaults
Zend_Paginator::setDefaultScrollingStyle('Sliding');
Zend_View_Helper_PaginationControl::setDefaultViewPartial("index/pagination_control.phtml");

$hide_on_print_class = $request->getParam(PAGE_CONTENTS_ONLY) == "true" ? "hideonprint" : ""; 

// initialize the ACL for all views
$acl = getACLInstance(); 
$os = browser_detection('os');
$islinux = false;
if($os != 'nt'){
  $islinux = true;
}

$controller = $request->getControllerName();
$action = $request->getActionName();

$browserappend = " | ".getAppName();
$showsearch = true;
$homedir = $company->getName().' / ';
$blockcontent = '<h4><img src="'.$this->baseUrl('images/loader.gif').'" /> Please wait...</h4>';

// query for user's lattest 3 messages
$q = new Doctrine_RawSql();
$q->select('{m.*}, {mr.*}');
$q->from('message m INNER JOIN messagerecipient mr ON (m.id = mr.messageid)');
$q->where("(mr.recipientid = '".$userid."') ORDER BY m.datecreated DESC LIMIT 3");
$q->addComponent('m', 'Message m');
$q->addComponent('mr', 'm.recipients mr');
$latestmsg = $q->execute();
// debugMessage($latestmsg->toArray());

$c = new Doctrine_RawSql();
$c->select('{m.*}, {mr.*}');
$c->from('message m INNER JOIN messagerecipient mr ON (m.id = mr.messageid)');
$c->where("(mr.recipientid = '".$userid."' AND mr.isread = 0) ORDER BY m.datecreated");
$c->addComponent('m', 'Message m');
$c->addComponent('mr', 'm.recipients mr');

$unread_messages = $c->execute()->count();
$unread_label = ' &nbsp;<span class="pagedescription" style="color:red; font-size:12px;">('.$unread_messages.' Unread)</span>';
$session->setVar('unread', $unread_messages);

$checkindetails = getCheckInEntry($loggedinuser->getID(), date('Y-m-d'));
//  debugMessage($checkindetails);
$ischeckin = false;
$istimesheetuser = false;
$mytext = "";
$isoverdue = false;
if(isTimesheetEmployee()){
	$istimesheetuser = true;
	$ischeckin = isCheckedIn($session->getVar('userid'), date('Y-m-d')) ? true : false; // debugMessage($ischeckin);
	$mytext = "My ";
}
if($ischeckin){
	if(!isEmptyString($checkindetails['datein']) && isEmptyString($checkindetails['dateout']) && (strtotime(date('Y-m-d')) > strtotime($checkindetails['datein']))) {
		/* TODO: add function to check againist login and out time */
		$isoverdue = true;
	}
}

// no of hours accrues
$totalhrs = getHoursAccrued($loggedinuser->getID(), 1, getYearStart(), getYearEnd());
$hoursavailable = getHoursAvailable($loggedinuser->getID(), 1, getYearStart(), getYearEnd());
$daysavailable = $hoursavailable == 0 ? 0 : formatNumber($hoursavailable/8);
$takenhrs = getHoursTaken($loggedinuser->getID(), 1, getYearStart(), getYearEnd());

$firstdayofcurrentmonth = getFirstDayOfCurrentMonth();
$lastdayofcurrentmonth = getLastDayOfCurrentMonth();
$firstdayoflastmonth = getFirstDayOfMonth(date("n")-1, date("Y"));
$lastdayoflastmonth = getLastDayOfMonth(date("n")-1, date("Y"));
$currentmonthpayrollurl = $this->baseUrl('payroll/list/payrolltype/4/startdate/'.changeMySQLDateToPageFormat($firstdayofcurrentmonth).'/enddate/'.changeMySQLDateToPageFormat($lastdayofcurrentmonth));
$lastmonthpayrollurl = $this->baseUrl('payroll/list/payrolltype/4/startdate/'.changeMySQLDateToPageFormat($firstdayoflastmonth).'/enddate/'.changeMySQLDateToPageFormat($lastdayoflastmonth));
$thismonthpayroll = getPayrolls($firstdayofcurrentmonth, $lastdayofcurrentmonth); // debugMessage($thismonthpayroll);
if(!isEmptyString($thismonthpayroll['id'])){
	$currentmonthpayrollurl = $this->baseUrl('payroll/list/id/'.encode($thismonthpayroll['id']));
}
$lastmonthpayroll = getPayrolls($firstdayoflastmonth, $lastdayoflastmonth); // debugMessage($lastmonthpayroll);
if(!isEmptyString($lastmonthpayroll['id'])){
	$lastmonthpayrollurl = $this->baseUrl('payroll/list/id/'.encode($lastmonthpayroll['id']));
}

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
# set default timezone based on company in session
date_default_timezone_set(getTimeZine());