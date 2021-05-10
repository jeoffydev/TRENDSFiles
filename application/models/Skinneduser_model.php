<?php
require_once APPPATH.'libraries/swift-mailer/swift_required.php';

class Skinneduser_Model extends CI_Model {

	 
	function getCustomerData(){
		$query = $this->db->query("SELECT CustomerNumber, CustomerName, CustomerOnHold, CSR FROM  customerData  ORDER BY customerName ");

		foreach($query->result() as $post) {
            $list[] =  $post;
        } 
        return $list; 
	}

	function getskinCustomersTheme($CustomerNumber){
		$query = $this->db->query("SELECT * FROM  customSite WHERE customerNumber=".$CustomerNumber." ORDER BY CompanyTag");
		$results = $query->result();
		 
		return  $results;
		 
	}

	function getskinUserData($selectedThemeID, $customerNumber){  

		$query = $this->db->query("SELECT * FROM  skinnedUserData WHERE customsiteID='".$selectedThemeID."' AND skinnedCustomerNumber='".$customerNumber."'  ORDER BY skinnedUserID DESC ");
		$results = $query->result();
		  
		return  $results;
	}

	function checkEmailIfExists($email, $ThemeID, $customerNumber){
		$query = $this->db->query("SELECT * FROM  skinnedUserData WHERE customsiteID='".$ThemeID."' AND skinnedCustomerNumber='".$customerNumber."' AND skinnedUserEmail='".$email."' ");
		  
		if ($query->num_rows() > 0) { 
			$results = 1;        
		}else{
			$results = 0;    
		} 
		return  $results;
	}

	function addNewSkinUser($skinnedName, $skinnedCompany, $skinnedEmail, $themeID, $customerNumber, $baseUrlDomain){
		$skinnedUserSalt = md5($themeID.'-'.$skinnedEmail); 
		$data = array(
			'customsiteID' => $themeID,
			'skinnedCustomerNumber' => $customerNumber, 
			'skinnedUserEmail'=>$skinnedEmail,
			'skinnedUserName'=>$skinnedName,
			'skinnedUserCompany' => $skinnedCompany,
			'skinnedUserPassword'=> null,
			'skinnedPwReset'=> null,
			'skinnedHash'=> null,
			'skinnedUserSalt'=> $skinnedUserSalt
		); 
		$query = $this->db->insert('skinnedUserData', $data);
		
		if($query){
			$insertId = $this->db->insert_id(); 
			$dataUser = array(
                'id' => $insertId,  
                'skinEmail' => $skinnedEmail, 
				'skinnedName' => $skinnedName, 
				'option' => 1, 
			);  
			$update = $this->updateResetPw($dataUser);
			$getDetailsEmail =  $this->getResetPW($dataUser,  $baseUrlDomain);
			 
		}
		if($update){
			$results = 1;
	    }else{
			$results = 0;
		} 
		 
		return $results; 
	 
	}

	function updateResetPw($data){ 
		$uniqueID = uniqid(); 
		$resetpwCode = md5($data['skinEmail'].''.$data['id']).'.' .$uniqueID;  
		$dataValues = array(
			'skinnedPwReset' => $resetpwCode, 
			'skinnedHash' => $uniqueID 

		);
        $this->db->where('skinnedUserID', $data['id']);
		$results = $this->db->update('skinnedUserData', $dataValues); 
        return $results;  
	}
	
	function getResetPW($data, $baseUrlDomain){

		$baseUrlDomain = substr($baseUrlDomain, 0, -1);
        $rpUrl = '/reset-user';

        $query = $this->db->query('SELECT * FROM skinnedUserData LEFt JOIN customSite  ON skinnedUserData.customsiteID =  customSite.themeID WHERE  skinnedUserData.skinnedUserID =  '.$data['id'].' '); 
        
        foreach($query->result() as  $rowx) {
			if($rowx->Domain == null){
				$domain =  $baseUrlDomain.$rpUrl.'/ID'.$rowx->CustomerNumber.''.$rowx->themeID.'/'; 
				$comp = "www.trends.nz";
			}else{
				$domain = $rowx->Domain.$rpUrl.'/ID'.$rowx->CustomerNumber.''.$rowx->themeID.'/';
				$comp = $rowx->Domain;
			}
			$urlLink = $rowx->skinnedPwReset;
            $finResetPw = $domain.''.$urlLink;
            $CompanyTag = $rowx->CompanyTag;
            $AdminEmail = $rowx->customsiteAdminEmail;
            if($AdminEmail != null){
				  $AdminEmail = $rowx->customsiteAdminEmail;     
            }else{
                  $AdminEmail = "webmaster@trends.nz";
            } 
		}

		//echo "Root URL " .$baseUrlDomain. "<br />";
		 //echo "Admin email: " .$AdminEmail." / comp: ".$comp."   / company: ".$CompanyTag." / url: ".$finResetPw." -- ";
		
		$transport = Swift_MailTransport::newInstance();
        // Create the message
		$message = Swift_Message::newInstance(); 
		
		if($data['option'] == 1){

			$message->setTo(array(
                $data['skinEmail'] => $data['skinnedName'] 
			));

			$body = "You have been invited to create a login to the ".$CompanyTag." website.<br />
			Once logged in you will be able to access pricing.<br />
			We recommend you keep your login information secure.<br />
			Your login name for the site is your email address (".$data['skinEmail'].").
			<br /><br />";  
			$body .= "<a href='" .$finResetPw."'>Click here to set up your login</a>"; 
			
			
			
			$message->setSubject($CompanyTag. " Login Setup");
			$message->setBody($body, 'text/html');
			$message->setFrom($AdminEmail, $comp); 

		}

		//Front end user forgot password
		if($data['option'] == 2){
				$message->setTo(array(
					$data['skinEmail'] => $data['skinnedName'] 
				));

				$body = "You have received a request to reset your password associated with this email address ".$data['skinEmail']."<br />"; 
				$body .= "Please click or copy and paste this link to reset your password <a href='" .$finResetPw."'>Click here</a>"; 

				$message->setSubject($data['skinnedName']. " Password reset request");
				$message->setBody($body, 'text/html');
				$message->setFrom($AdminEmail, $comp);
  
		}
       
        // Send the email
        $mailer = Swift_Mailer::newInstance($transport);
        $mailer->send($message); 
		
		if($mailer->send($message)){
            $results= "Email sent..";
		}else{
			$results= "Email not sent..";
		}
 
		return $results; 
        /* Email function end */

	}
	
	function deleteSkinUser($skinnedUserID){
		$data = array(
			'skinnedUserID' => $skinnedUserID 
		);
		$deleted = $this->db->delete('skinnedUserData', $data); 
		$results = 1;
		return $results;  

	}

	function viewSelectPassword($skinnedUserID){
		$query = $this->db->query("SELECT * FROM  skinnedUserData WHERE skinnedUserID = '".$skinnedUserID."' ");
		$results = $query->result();
		  
		return  $results;
 
	}
 
 

}
