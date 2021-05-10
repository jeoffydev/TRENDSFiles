<?php 
require_once APPPATH.'libraries/PHPMailer/PHPMailerAutoload.php';

class Resetuser_Model extends CI_Model {


	public function __construct(){ 
		parent:: __construct();  
	  

		$this->load->model('general_model'); 
	}

	function verifyThemeResetPassword($resetUserDatas){
		$themeIDOut = $resetUserDatas['themeID'];
		$themeID  = strip_tags(stripslashes(substr($themeIDOut,7)));
		 
		$userCodeExp = explode(".", $resetUserDatas['hassPw']);
		$userCodeExp2 = $userCodeExp[1];
	 
		$query = $this->db->query("SELECT customsiteID, skinnedCustomerNumber, skinnedUserID, skinnedUserEmail, skinnedUserCompany, skinnedHash FROM skinnedUserData WHERE customsiteID ='".$themeID."' AND skinnedHash ='".$userCodeExp2."' ");
		if ($query->num_rows() > 0) { 
			$exists = 1;
			$queryResults = $query->result();
		}else{
			$exists = 0;
		}  
		return $results = array('exists' => $exists, 'queryResults' => $queryResults );
	}

	function resetPassword($passwordCheck, $skinnedUserID, $customsiteID){
		$newPassword = md5($passwordCheck); 

		$dataValues = array(
			'skinnedUserPassword' => $newPassword, 
			'skinnedPwReset' => null,
			'skinnedHash' => null

		);
        $this->db->where('skinnedUserID', $skinnedUserID);
		$update = $this->db->update('skinnedUserData', $dataValues); 

		if($update){
			$results =  1;  
		}else{
			$results = 0;  
		}  
		return $results;  
		 
	}

	public function verifyMainUserEmailForgot($data){
		$results = 0;  

		if($username = $data['userNameEmail']){

			$emailCheck = $this->general_model->getUsername($username);
			if($emailCheck){

				$getUserDetails = $this->general_model->checkLogin($username);
				$userHashLink = $getUserDetails[0]->userSalt.".".$getUserDetails[0]->userID; 
				$userID = $getUserDetails[0]->userID;
				$dataValues = array( 
					'pwReset' => $userHashLink, 
		
				);
				$this->db->where('userID', $userID);
				$this->db->where('userEmail',$username);
				$results = $this->db->update('userData', $dataValues);  

				if($results){
					$emailSent = $this->emailUserResetPassword($username, $userID, $userHashLink);
				}

				$results = 1;
			}else{
				$results = 0; 
			} 
		}

		//print_r($userHashLink);

		return $results;
	}

	public function emailUserResetPassword($email, $userID, $userHashLink){
			$urlDomain = "https://www.trends.nz";
			$mail = new PHPMailer;

			$mail->isSMTP();
			$mail->Host = 'smtp.sitehost.co.nz';
			$mail->SMTPAuth = false; 
			$mail->Port = 25;

			$mail->setFrom('webmaster@trends.nz', 'TRENDS Password Reset' ); 
			$mail->addAddress($email);   
			//$mail->addBCC('jeoffyh@tuapeka.co.nz');   
			$mail->addReplyTo('webmaster@trends.nz');

			$domainUrl = $urlDomain. "/reset-password/" .$userHashLink; 
		 
			$subject = "TRENDS Password Reset";
			$body = "<html>We have received a request to reset the password associated with your email address.<br />";
			$body .= "If you made this request please follow the link below.<br />";
			$body .= "<a href='".$domainUrl."'>Click here to reset your password</a></html><br /><br />"; 
			
			$mail->isHTML(true);
			$mail->Subject = $subject;  

			$mail->Body    = $body;

			$result = false;

			if(!$mail->send()) { 
				echo 'Mailer Error: ' . $mail->ErrorInfo; 
				$result = false; 
			} else { 
				$result = true; 
			}  

			return $result;

			/*
							$result = false;
							 
							$urlDomain = "https://www.trends.nz";
        
         					$domainUrl = $urlDomain. "/reset-password/" .$userHashLink; 
							$to = $email;
							$subject = "TRENDS Password Reset";
							$body = "<html>We have received a request to reset the password associated with your email address.<br />";
							$body .= "If you made this request please follow the link below.<br />";
							$body .= "<a href='".$domainUrl."'>Click here to reset your password</a></html><br /><br />"; 
							
							$headers = "From: TRENDS <webmaster@trends.nz>\r\n";
							$headers .= "Reply-To: info@trends.nz\r\n";
							$headers .= "MIME-Version: 1.0\r\n";
							$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
							
							if (mail($to, $subject, $body, $headers)) { 
								$result = true; 
							}else{ 
								$result = false; 
							}

							return $result; */
	}

	public function verifyHash($hash){
		
		$results = array('confirmed'=> 0, 'userID' => null );
		$userCodeExp = explode(".", $hash);
		$userSalt = $userCodeExp[0];
		$userID = $userCodeExp[1];

		if($userSalt && $userID){

			$userDatas = $this->general_model->getUserByID($userID);
			//$userDatas[0]->userID
			if($userID == $userDatas[0]->userID && $userSalt == $userDatas[0]->userSalt){  
				$results = array('confirmed'=> 1, 'userID' =>$userID );
			}else{
				$results = $results;
			}
			
			
		}

		return $results;
	}
	 
	 

}
