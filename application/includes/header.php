<?php 
# whether or not the session has errors
$session = SessionWrapper::getInstance(); 
$sessionhaserror = !isEmptyString($session->getVar(ERROR_MESSAGE));

$userid = $session->getVar("userid");
$companyid = isEmptyString($session->getVar('companyid')) ? DEFAULT_COMPANYID : $session->getVar("companyid");
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
}
$type = $session->getVar("type");

$default_theme_data = getDefaultThemeOptions(DEFAULT_COMPANYID); //debugMessage($default_theme_data);
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

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
# set default timezone based on company in session
date_default_timezone_set(getTimeZine());