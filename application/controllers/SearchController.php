<?php

class SearchController extends IndexController  {
	
	function indexAction() {
    	$session = SessionWrapper::getInstance(); 
    	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$conn = Doctrine_Manager::connection();
		$formvalues = $this->_getAllParams();
		$userid = $session->getVar('userid');
		$acl = getACLInstance();
		
		$q = $formvalues['searchword'];
		$html = '';
		$hasdata = false;
		
		// ) 
		# search users if loggedin user has access
		if($acl->checkPermission('User Account', ACTION_LIST)){
			$query = "SELECT u.id FROM useraccount as u 
				WHERE
			   (u.firstname like '%".$q."%' or 
				u.lastname like '%".$q."%' or 
				u.othername like '%".$q."%' or 
				u.displayname like '%".$q."%' or 
				u.email like '%".$q."%' or 
				u.phone like '%".$q."%' or 
				u.username like '%".$q."%') 
				GROUP BY u.id
				order by u.displayname asc LIMIT 5 ";
			// debugMessage($query);
			$result = $conn->fetchAll($query);
			$count_results = count($result);
			// debugMessage($result);
			if($count_results > 0){
				$hasdata = true;
				$html .= '<div class="separator"><span>Employees</span>
					<div class="allresults"><a href="'.$this->view->baseUrl('profile/list/searchterm/'.$q).'" class="blockanchor">...see more results</a></div>
				</div><ul>';
				foreach ($result as $row){
					$user = new UserAccount();
					$user->populate($row['id']);
					
					$b_q='<b>'.$q.'</b>';
					$name= $user->getDisplayName(); $name = str_ireplace($q, $b_q, $name);
					$position= getDatavariables('EMPLOYEE_POSITIONS', $user->getPosition(), true);
					$phone = $user->getPhone(); $phone = str_ireplace($q, $b_q, $phone);
					$email = $user->getEmail(); $email = str_ireplace($q, $b_q, $email);
					$media = $user->getMediumPicturePath();
					$viewurl = $this->view->baseUrl('profile/view/id/'.encode($row['id']));
					$html .= '
					<li style="height:auto; min-height:90px;" class="display_box" align="left" url="'.$viewurl.'" theid="'.$row['id'].'">
						<img class="imagecontainer" src="'.$media.'" style="width:78px; height:auto; float:left; margin-right:6px;" />
						<div style="margin-left: 70px;">
							<span class="name blocked">'.$name.'</span>
							<span class="name blocked">'.$position.'</span>
							<span class="blocked" style="margin-top:5px;">Email: '.$email.'</span>
							<span class="blocked">Phone: '.$phone.'</span>
							
						</div>
					</li>';
					
				}
			}
		}
		
		# add navigation to searchable parameters
		$result = array(
			'id' => 1,
			'users' => ''
		);
		
		# check no data is available for all areas and return no results message
		if(!$hasdata){
			$html .= '
				<li class="display_box" align="center" style="height:30px;">
					<span style="width:100%; display:block; text-align:center;">No results for <b>'.$q.'</b></span>
				</li>';
		}
		$html .= '</ul>';
		echo $html;
    }
}