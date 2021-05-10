<?php
require_once APPPATH.'libraries/swift-mailer/swift_required.php';
require_once APPPATH.'libraries/PHPMailer/PHPMailerAutoload.php';

class Usermaintenance_Model extends CI_Model {

	 

	function getCustomerClients($CustomerNumber){
		 
		$query = $this->db->query("SELECT * FROM  userData WHERE userAcct=".$CustomerNumber." ORDER BY userEmail");
		$results = $query->result();
		 
		return  $results;
		 
	}


	public function insertNewTrendUser($data){
		$finalResults = array();
		$query = $this->db->query(" SELECT * FROM  userData WHERE  userEmail = '".$data['newUserEmail']."'   ");
		if ($query->num_rows() > 0) { 

			$resultsFIrst = $query->result(); 
			
			$req = $this->db->query('SELECT CustomerName FROM  customerData  WHERE CustomerNumber = "'.$resultsFIrst[0]->userAcct.'" '); 
            $resultExist = $req->result();
			
            // print_r();
            $finalResults['companyName'] = $resultExist[0]->CustomerName;
			$finalResults['found'] = 1;   
			
		}else{
			 
			$datas = array(
				//'adminEmail' => $data['adminEmail'],
				'userAcct' => $data['customerNumber'],
				'userEmail' => $data['newUserEmail'], 
				'userSalt'=> $data['newSalt'], 
				
			);

			
			 
			$sql = $this->db->insert('userData', $datas); 
 
			$lastIDinserted =  $this->db->insert_id(); 
			$newSalt = $data['newSalt'];
			$resetEmailLink = $newSalt.".".$lastIDinserted; 
		 
            $getCustomerData= $this->db->query("SELECT * FROM  customerData WHERE customerNumber='".$data['customerNumber']."' ");  
			$getCustomerDataResults = $getCustomerData->result();  
			 
			if($getCustomerDataResults[0]->Currency == "NZD") {
                $whichDomain = "www.trends.nz";
            } else {
                $whichDomain = "www.trends.nz";
			}  
			
			/***************** Email FUnction Here **************************/
			$newUserEmail = $data['newUserEmail'];
			$adminEmail = $data['adminEmail'];
			$mail = new PHPMailer;
			$mail->isSMTP();
            $mail->Host = 'smtp.sitehost.co.nz';
            //$mail->Host = 'tuapeka-co-nz.mail.protection.outlook.com';
           // $mail->SMTPAutoTLS = false;
			$mail->SMTPAuth = false; 
			$mail->Port = 25;

			$mail->setFrom($adminEmail, $whichDomain); 
            $mail->addAddress($newUserEmail);
            $mail->addAddress($adminEmail);
			 
			$mail->isHTML(true);
			$mail->Subject = "TRENDS Website Login"; 
			 
            $body = "You have been invited to create a login to the TRENDS website.<br />";
			$body .= "Once logged in you will be able to access stock and pricing information on the fly when viewing items.<br />";
			$body .= "Planned future updates will include access to order status, order history and account information.<br />";
			$body .= "We recommended to keep your login information secure.<br />";
			$body .= "Your login name for the site is your email address (".$newUserEmail.").<br />";
			$body .= "<br />";
			$body .= "Click here to set up your login <a href='https://".$whichDomain."/reset-password/".$resetEmailLink."'> https://".$whichDomain."/reset-password/".$resetEmailLink." </a><br /><br />";
 

			$mail->Body    = $body;

			if(!$mail->send()) {
				$finalResults = 'Mailer Error: ' . $mail->ErrorInfo;
				 
            } 
            $finalResults['found'] = 0; 

			/***************** Email FUnction Here **************************/


		}  
		//
		return $finalResults;
	}

	public function deleteUser($userID){
		$results = 0;
		$data = array(
			'userID' => $userID 
		);
		$deleted = $this->db->delete('userData', $data); 
		$results = 1;
		return $results;  
	} 
	
	public function getUserID($userID){
	 
		$query = $this->db->query("SELECT * FROM userData  WHERE userID=".$userID."  ");
		$results = $query->result();
		 
		return  $results;
	}

	public function getPages(){
	 
		$query = $this->db->query(" SELECT * FROM cmsAccess WHERE mainPage = '1' ORDER BY pageNumber ASC  ");
		$results = $query->result();
		 
		return  $results;
	}

	public function getVisualAccess($customerNumbered){
		$query = $this->db->query(" SELECT visualAccess FROM  customerData WHERE CustomerNumber=".$customerNumbered."    ");
		$results = $query->result();
		 
		return  $results;
	}


	public function getHashUser($data){
		
			$query =  $this->db->query("  SELECT * FROM  userData LEFT OUTER JOIN customerData ON customerData.CustomerNumber = userData.userAcct WHERE userID=".$data['userID']."  ");  
			$results = $query->result();
			 
			if($data['hash'] == 1){ 

				//Update first
				$userPW = $results[0]->userSalt.".".$results[0]->userID;  
				$dataValues = array( 
					'pwReset' => $userPW,  
				);
				$this->db->where('userID', $data['userID']); 
				$userReset = $this->db->update('userData', $dataValues);  

				//Reselect to get the pwReset value 
				$query = $this->db->query(" SELECT * FROM  userData  WHERE userID=".$data['userID']."    ");
				$resultReqUpdate = $query->result(); 
				$resetUrl = $resultReqUpdate[0]->pwReset; 
 

			}else{
				$resetUrl = $results[0]->userSalt.'.'.$results[0]->userID;
			}
			if($results[0]->Currency == 'NZD'){
				$urlDomain = "www.trends.nz";
			}else{
				$urlDomain = "www.trends.nz";
			} 
			// http://localhost/?changeid=3312&country=nzd
			$results['finalResetUrl'] = $urlDomain. "/reset-password/" .$resetUrl;   
			//print_r($results);
			return  $results;
	}


	public function updateUserAccess($data){

		$datasGood = array(); 
		
		$dataValues = array( 
			'userID' => $data['userID'],
			'multiCurrency'=> $data['multiCurrency'], 
			//'skinnedWebsites'=>$data['skinnedWebsites']
		);
		$this->db->where('userID', $data['userID']); 
		$userUpdated = $this->db->update('userData', $dataValues);  

		if($userUpdated){
			$datasGood["message"] = " User successfully Updated "; 
		}else{
			$datasGood["error"] = " Error on updating this user ";   
		}
		echo json_encode($datasGood);  
	}

}
