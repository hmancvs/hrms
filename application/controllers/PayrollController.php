<?php

class PayrollController extends SecureController  {
	/**
	 * Get the name of the resource being accessed
	 *
	 * @return String
	 */
	function getActionforACL() {
		$action = strtolower($this->getRequest()->getActionName());
		if($action == "history" || $action = "historysearch" ||  $action = "changedays"  ||  $action = "complete") {
			return ACTION_LIST;
		}
		if($action == "issuepayslips"){
			
		}
		return parent::getActionforACL();
	}
	
	function historyAction(){
		
	}
	
	function historylistsearchAction(){
		
	}
	
	function changedaysAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$session = SessionWrapper::getInstance();
		$this->_translate = Zend_Registry::get("translate");
	
		$formvalues = $this->_getAllParams(); // debugMessage($formvalues); exit();
		
		$session->setVar($formvalues['id'], $formvalues['value']);
		// debugMessage('>>'.$session->getVar($formvalues['id']));
		$this->_helper->redirector->gotoUrl(decode($this->_getParam('return')));
	}
	
	function createAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$session = SessionWrapper::getInstance(); 
		
		/* debugMessage('pms: '.ini_get('post_max_size'));
		debugMessage('ums: '.ini_get("upload_max_filesize"));
		$size = (int) $_SERVER['CONTENT_LENGTH']; debugMessage('content length '.$size);
		ini_set("memory_limit", "1024M");
		$memory_limit = ini_get('memory_limit'); debugMessage('memory is '.$memory_limit); */
		
		$formvalues = $this->_getAllParams(); // debugMessage($formvalues); 
		$restoredata = objectToArray(json_decode(decode($session->getVar('restoredata'))));
		$formvalues = array_merge_maintain_keys($formvalues, $restoredata);
		// debugMessage($formvalues); 
		// exit;
		
		// determine employees on the payroll
		$employees = array();
		$all_results_query = decode($formvalues['employeequery']); // debugMessage($all_results_query); exit;
		$conn = Doctrine_Manager::connection();
		$employees = $conn->fetchAll($all_results_query); // debugMessage($employees);
		
		// format payroll data
		$dataarray = array();
		$dataarray['companyid'] = getCompanyID();
		$dataarray['type'] = $formvalues['payrolltype'];
		$dataarray['status'] = $formvalues['status'];
		$dataarray['payrolldate'] = changeDateFromPageToMySQLFormat($formvalues['enddate']);
		$dataarray['url'] = $formvalues['failureurl'];
		$dataarray['startdate'] = changeDateFromPageToMySQLFormat($formvalues['startdate']);
		$dataarray['enddate'] = changeDateFromPageToMySQLFormat($formvalues['enddate']);
		$dataarray['middate'] = changeDateFromPageToMySQLFormat($formvalues['middate']);
		$dataarray['createdby'] = $session->getVar('userid');
		$dataarray['remarks'] = isArrayKeyAnEmptyString('remarks', $formvalues) ? '' : $formvalues['remarks'];
		$dataarray['ignorelist'] = $formvalues['ignorelist'];
		
		if(count($employees) > 0){
			foreach($employees as $key => $employee){
				$dataarray['details'][$key]['userid'] = $employee['id'];
				$dataarray['details'][$key]['empstatus'] = $employee['empstatus'];
				$dataarray['details'][$key]['ratetype'] = $employee['ratetype'];
				$dataarray['details'][$key]['payrolltype'] = $employee['payrolltype'];
				$dataarray['details'][$key]['rate'] = $employee['rate'];
				$dataarray['details'][$key]['istimesheetuser'] = $employee['istimesheetuser'];
				$dataarray['details'][$key]['daysworked'] = $formvalues['daysworked_'.$employee['id']];
				$dataarray['details'][$key]['hourspending'] = $formvalues['_'.$employee['id']];
				$dataarray['details'][$key]['halfhoursworked'] = $formvalues['halfhoursworked_'.$employee['id']];
				$dataarray['details'][$key]['fullhoursworked'] = $formvalues['fullhoursworked_'.$employee['id']];
				$dataarray['details'][$key]['leavehrs'] = $formvalues['leavehrs_'.$employee['id']];
				$dataarray['details'][$key]['sickhrs'] = $formvalues['sickhrs_'.$employee['id']];
				
				$dataarray['details'][$key]['midgross'] = str_replace(',','',$formvalues['midgross_'.$employee['id']]);
				$dataarray['details'][$key]['endgross'] = str_replace(',','',$formvalues['endgross_'.$employee['id']]);
				$dataarray['details'][$key]['nssf'] = str_replace(',','',$formvalues['nssf_'.$employee['id']]);
				$dataarray['details'][$key]['paye'] = str_replace(',','',$formvalues['paye_'.$employee['id']]);
				$dataarray['details'][$key]['otherdebit'] = str_replace(',','',$formvalues['otherdebit_'.$employee['id']]);
				$dataarray['details'][$key]['netearning'] = str_replace(',','',$formvalues['netearning_'.$employee['id']]);
				$dataarray['details'][$key]['transport'] = str_replace(',','',$formvalues['transport_'.$employee['id']]);
				$dataarray['details'][$key]['othercredit'] = str_replace(',','',$formvalues['othercredit_'.$employee['id']]);
				$dataarray['details'][$key]['netpay'] = str_replace(',','',$formvalues['netpay_'.$employee['id']]);
				$dataarray['details'][$key]['totaltaxable'] = str_replace(',','',$formvalues['totaltaxable_'.$employee['id']]);
				$dataarray['details'][$key]['totalbenefits'] = str_replace(',','',$formvalues['totalbenefits_'.$employee['id']]);
				$dataarray['details'][$key]['benefitdetails'] = $formvalues['benefitdetails_'.$employee['id']];
				$dataarray['details'][$key]['deductiondetails'] = $formvalues['deductiondetails_'.$employee['id']];
				$dataarray['details'][$key]['recurringtrxns'] = $formvalues['recurringtrxns_'.$employee['id']];
				$dataarray['details'][$key]['isignored'] = $formvalues['isignored_'.$employee['id']];
			}
		}
		// debugMessage('url '.decode($this->_getParam(URL_SUCCESS))); // exit; 
		
		$payroll = new Payroll();
		if(!isArrayKeyAnEmptyString('reloadid', $formvalues)){
			$payroll->populate($formvalues['reloadid']);
		}
		$payroll->processPost($dataarray); 
		/* debugMessage($payroll->toArray());
		debugMessage('errors are '.$payroll->getErrorStackAsString()); exit(); */
		
		if($payroll->hasError()){
			$url = decode($formvalues[URL_FAILURE]);
			$session->setVar(ERROR_MESSAGE, $payroll->getErrorStackAsString());
		} else {
			try {
				if($payroll->payrollExists() && isArrayKeyAnEmptyString('reloadid', $formvalues)){
					$id = $payroll->existingPayroll();
					$proll = new Payroll();
					$proll->populate($id);
					// debugMessage($proll->toArray()); exit();
					$proll->delete();
				}
				
				// debugMessage($payroll->toArray()); exit();
				$payroll->save();
				$session->setVar(SUCCESS_MESSAGE, "Successfully saved as Draft");
				if($dataarray['status'] == 2){
					$session->setVar(SUCCESS_MESSAGE, "Successfully marked as Completed and Locked");
				}
				$url = decode($formvalues[URL_SUCCESS]).encode($payroll->getID());
			} catch (Exception $e) {
				$session->setVar(ERROR_MESSAGE, $e->getMessage()); // debugMessage($e->getMessage());
				$url = decode($formvalues[URL_FAILURE]);
			}
		}
		// debugMessage($url);
		$this->_helper->redirector->gotoUrl($url);
	}
	
	function completeAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$session = SessionWrapper::getInstance();
		$formvalues = $this->_getAllParams(); // debugMessage($formvalues); exit;
		$config = Zend_Registry::get("config");
		
		$payroll = new Payroll();
		$payroll->populate($this->_getParam('id'));
		$payroll->setStatus($this->_getParam('status'));
		// debugMessage($payroll->getStartDate()." - ".$payroll->getEndDate());
		
		$ledger_collection = new Doctrine_Collection(Doctrine_Core::getTable("Ledger"));
		$timesheet_collection = new Doctrine_Collection(Doctrine_Core::getTable("Timesheet"));
		$leave_collection = new Doctrine_Collection(Doctrine_Core::getTable("Ledger"));
		
		$employees = $payroll->getdetails(); // debugMessage($employees->toArray());
		foreach ($employees as $employee){
			$results_credits_array = array();
			// check of benefit additions
			if(decode($employee->getbenefitdetails()) != "[]" && $employee->getbenefitdetails() != "W10="){
				$results_credits_array = objectToArray(json_decode(decode($employee->getbenefitdetails())));
				// debugMessage($results_credits_array);
				foreach($results_credits_array as $line){
					if(!isArrayKeyAnEmptyString('ids', $line)){
						$ids_array = explode(',', $line['ids']);
						if(count($ids_array) > 0){
							foreach ($ids_array as $id){
								$ledger = new Ledger();
								$ledger->populate($id);
								$ledger->setPayrollID($employee->getPayrollID());
								$ledger_collection->add($ledger);
								// debugMessage($ledger->toArray());
							}
						}
					}
				}
			}
			// check for deductions
			if(decode($employee->getdeductiondetails()) != "[]" && $employee->getdeductiondetails() != "W10="){
				$results_debits_array = objectToArray(json_decode(decode($employee->getdeductiondetails())));
				// debugMessage($results_credits_array);
				foreach($results_debits_array as $line){
					if(!isArrayKeyAnEmptyString('ids', $line)){
						$ids_array = explode(',', $line['ids']);
						if(count($ids_array) > 0){
							foreach ($ids_array as $id){
								$ledger = new Ledger();
								$ledger->populate($id);
								$ledger->setPayrollID($employee->getPayrollID());
								$ledger_collection->add($ledger);
								// debugMessage($ledger->toArray());
							}
						}
					}
				}
			}
			
			// fetch timesheets for each employeee
			$timesheets = $employee->getUser()->getTimesheetDetails($payroll->getStartDate(), $payroll->getEndDate());
			if($timesheets->count() > 0) {
				// debugMessage($timesheets->toArray());
				foreach ($timesheets as $timesheet){
					$timesheet->setPayrollID($employee->getPayrollID());
					$timesheet_collection->add($timesheet);
				}
			}
			
			// generate leave accruals for period
			if($employee->getLeaveHrs() > '0.00' && $employee->getUser()->getIsTimesheetuser() == 1){
				// debugMessage('>'.$employee->getLeaveHrs());
				$leave = new Ledger();
				$leave_array = array(
					"payrollid" => $payroll->getID(),
					"userid" => $employee->getUserID(),
					"ledgertype" => 2,
					"trxntype" => 1,
					"leaveid" => 1,
					"trxndate" => $payroll->getEndDate(),
					"startdate" => $payroll->getStartDate(),
					"enddate" => $payroll->getEndDate(),
					"leavelength" => $employee->getLeaveHrs() * getHoursInDay(),
					"lengthtype" => 1,
					"status" => 1,
					"remarks" => "Auto Accrual from Payroll (".changeMySQLDateToPageFormat($payroll->getStartDate())." - ".changeMySQLDateToPageFormat($payroll->getEndDate()).") ",
					"createdby" => $session->getVar("userid"),
					"approvedbyid" => $session->getVar("userid"),
					"dateapproved" => date('Y-m-d'),
					"payrolltrigger" => 1
				);
				$leave->processPost($leave_array);
				/* debugMessage($leave->toArray());
				debugMessage('errors are '.$leave->getErrorStackAsString()); */
				if(!$leave->hasError()){
					$leave_collection->add($leave);
				}
			}
			if($employee->getSickHrs() > '0.00' && $employee->getUser()->getIsTimesheetuser() == 1){
				// debugMessage('>'.$employee->getLeaveHrs());
				$leave = new Ledger();
				$leave_array = array(
						"payrollid" => $payroll->getID(),
						"userid" => $employee->getUserID(),
						"ledgertype" => 2,
						"trxntype" => 1,
						"leaveid" => 2,
						"trxndate" => $payroll->getEndDate(),
						"startdate" => $payroll->getStartDate(),
						"enddate" => $payroll->getEndDate(),
						"leavelength" => $employee->getSickHrs() * getHoursInDay(),
						"lengthtype" => 1,
						"status" => 1,
						"remarks" => "Auto Accrued from Payroll (".changeMySQLDateToPageFormat($payroll->getStartDate())." - ".changeMySQLDateToPageFormat($payroll->getEndDate()).") ",
						"createdby" => $session->getVar("userid"),
						"approvedbyid" => $session->getVar("userid"),
						"dateapproved" => date('Y-m-d'),
						"payrolltrigger" => 1
				);
				$leave->processPost($leave_array);
				/*debugMessage($leave->toArray());
				debugMessage('errors are '.$leave->getErrorStackAsString()); */
				if(!$leave->hasError()){
					$leave_collection->add($leave);
				}
			}
			
			// generate recurring monthly benefits
			$newledgertrxns = array();
			if(decode($employee->getrecurringtrxns()) != "[]" && $employee->getrecurringtrxns() != "W10="){
				$newledgertrxns = objectToArray(json_decode(decode($employee->getrecurringtrxns())));
				// debugMessage($newledgertrxns);
				foreach($newledgertrxns as $line){
					// debugMessage($line);
					foreach ($line as $key => $value){
						$ledger = new Ledger();
						$ledger_array = array(
								"payrollid" => $payroll->getID(),
								"payrolltrigger" => 1,
								"userid" => $employee->getUserID(),
								"ledgertype" => 1,
								"trxntype" => $value['trxntype'],
								"benefitid" => $value['benefitid'],
								"trxndate" => $payroll->getEndDate(),
								"startdate" => $payroll->getStartDate(),
								"enddate" => $payroll->getEndDate(),
								"amount" => $value['amount'],
								"status" => 1,
								"remarks" => "Auto Accrued from Payroll (".changeMySQLDateToPageFormat($payroll->getStartDate())." - ".changeMySQLDateToPageFormat($payroll->getEndDate()).") ",
								"createdby" => $session->getVar("userid"),
								"approvedbyid" => $session->getVar("userid"),
								"dateapproved" => date('Y-m-d'),
								"istaxable" => isArrayKeyAnEmptyString('istaxable', $value) ? 0 : $value['istaxable']
						);
						$ledger->processPost($ledger_array);
						/* debugMessage($ledger->toArray());
						debugMessage('errors are '.$ledger->getErrorStackAsString()); */
						if(!$ledger->hasError()){
							$ledger_collection->add($ledger);
						}
					}
				}
			}
			
			// add nssf to benefits if it exists
			if($employee->getNssf() > 0){
				$ledger = new Ledger();
				$ledger_array = array(
					"payrollid" => $payroll->getID(),
					"payrolltrigger" => 1,
					"userid" => $employee->getUserID(),
					"ledgertype" => 1,
					"trxntype" => 2,
					"benefitid" => 19,
					"trxndate" => $payroll->getEndDate(),
					"startdate" => $payroll->getStartDate(),
					"enddate" => $payroll->getEndDate(),
					"amount" => $employee->getNssf(),
					"status" => 1,
					"remarks" => "Auto Accrued from Payroll (".changeMySQLDateToPageFormat($payroll->getStartDate())." - ".changeMySQLDateToPageFormat($payroll->getEndDate()).") ",
					"createdby" => $session->getVar("userid"),
					"approvedbyid" => $session->getVar("userid"),
					"dateapproved" => date('Y-m-d')
				);
				$ledger->processPost($ledger_array);
				/* debugMessage($ledger->toArray());
				 debugMessage('errors are '.$ledger->getErrorStackAsString()); */
				if(!$ledger->hasError()){
					$ledger_collection->add($ledger);
				}
			}
			
			// add paye to benefits if it exists
			if($employee->getPaye() > 0){
				$ledger = new Ledger();
				$ledger_array = array(
					"payrollid" => $payroll->getID(),
					"payrolltrigger" => 1,
					"userid" => $employee->getUserID(),
					"ledgertype" => 1,
					"trxntype" => 2,
					"benefitid" => 20,
					"trxndate" => $payroll->getEndDate(),
					"startdate" => $payroll->getStartDate(),
					"enddate" => $payroll->getEndDate(),
					"amount" => $employee->getPaye(),
					"status" => 1,
					"remarks" => "Auto Accrued from Payroll (".changeMySQLDateToPageFormat($payroll->getStartDate())." - ".changeMySQLDateToPageFormat($payroll->getEndDate()).") ",
					"createdby" => $session->getVar("userid"),
					"approvedbyid" => $session->getVar("userid"),
					"dateapproved" => date('Y-m-d')
				);
				$ledger->processPost($ledger_array);
				/* debugMessage($ledger->toArray());
				 debugMessage('errors are '.$ledger->getErrorStackAsString()); */
				if(!$ledger->hasError()){
					$ledger_collection->add($ledger);
				}
			}
		}
		// debugMessage('exiting here');
		// exit;
		
		// save collection
		try {
			// update payroll status
			$payroll->save();
			// update benefits on the payroll
			if($ledger_collection->count() > 0){
				// debugMessage($ledger_collection->toArray());
				$ledger_collection->save();
			}
			// update timesheets on the payroll
			if($timesheet_collection->count() > 0){
				// debugMessage($timesheet_collection->toArray());
				$timesheet_collection->save();
			}
			// assign leave benefits 
			if($leave_collection->count() > 0){
				// debugMessage($leave_collection->toArray());
				$leave_collection->save();
			}
			
			// set success message
			$msg = "Payroll Successfully Completed and Approved. Please note that this has been locked from any further updates. ";
			if(!isEmptyString($this->_getParam(SUCCESS_MESSAGE))){
				$msg = $this->_getParam($this->_translate->translate($this->_getParam(SUCCESS_MESSAGE)));
			}
			$session->setVar(SUCCESS_MESSAGE, $msg);
			// debugMessage('success '); exit;
		} catch (Exception $e) {
			$session->setVar(ERROR_MESSAGE, "Error in saving Payroll. ".$e->getMessage()); 
			// debugMessage('Error in completing payroll. '.$e->getMessage()); exit;
		}
		
		$url = $this->view->baseUrl('payroll/list/id/'.encode($payroll->getID()).'/issuepayslips/1');
		if(!isEmptyString($this->_getParam(URL_SUCCESS))){
			$url = decode($this->_getParam(URL_SUCCESS));
		}
		$session->setVar("issuepayslips", '1');
		
		$this->_helper->redirector->gotoUrl($url);
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
		// debugMessage($successurl);
	
		$payroll = new Payroll;
		$id = is_numeric($formvalues['id']) ? $formvalues['id'] : decode($formvalues['id']); // debugMessage($id);
		$payroll->populate($id); debugMessage($payroll->toArray());
		
		$deletetrxns = $payroll->getLedgerDeleteTrxns();
		if($deletetrxns->count() > 0){
			$deletetrxns->delete();
		}
		/* debugMessage($payroll->getLedgerDeleteTrxns()->toArray());
		exit(); */
		if($payroll->delete()) {
			$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate("global_delete_success"));
			$successmessage = $this->_getParam(SUCCESS_MESSAGE);
			if(!isEmptyString($successmessage)){
				$session->setVar(SUCCESS_MESSAGE, $successmessage);
			}
		}
		
		$this->_helper->redirector->gotoUrl($successurl);
	}
	
}
