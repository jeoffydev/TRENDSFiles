<?php
 
 require_once APPPATH.'libraries/PHPMailer/PHPMailerAutoload.php';

class Contact_Model extends CI_Model {

	public function __construct(){ 
		if($_SERVER['SERVER_NAME'] == "logosource.co.nz" || $_SERVER['SERVER_NAME'] == "www.logosource.co.nz" || $_SERVER['SERVER_NAME'] == "localhost"  ) { 
			$this->tableBanners = "bannersDEV";
			$this->tableProducts = "productsCurrentDEV";
			$this->tablePricing = "productsPricingDEV";
			$this->tableStockCode = "segmentStockCode";
			$this->categoriesTable = "categoriesCurrent";
			$this->productsChanges = "productsChangesDEV";
			$this->productChangeTypes = "productChangeTypes";
		} else { 
			$this->tableBanners = "banners";
			$this->tableProducts = "productsCurrent";
			$this->tablePricing = "productsPricing";
			$this->tableStockCode = "segmentStockCode";
			$this->categoriesTable = "categoriesCurrent";
			$this->productsChanges = "productsChanges";
			$this->productChangeTypes = "productChangeTypes";
		}

		$this->load->library('email');
	}
	/* Skinned popup form */
	function sendFormEnquiry($arraySend){
		if($arraySend){

			$to = $arraySend['emailTo'];
			$subject = "TRENDS Product Enquiry";
			$body = "An enquiry has been made on your skinned website ".$arraySend['skinnedDomain']."<br /><br />";
			$body .= "A customer has requested more information on the TRENDS item ".$arraySend['Product']." (".$arraySend['Code']."):<br />";
			$body .= "Customer Name: ".$arraySend['Name']."<br />";
			$body .= "Customer Email: ".$arraySend['Email']."<br />";
			$body .= "Customer Company: ".$arraySend['Company']."<br />";
			$body .= "Customer Phone: ".$arraySend['Phone']."<br />";
			$body .= "Customer Message: ".$arraySend['Details']."<br />";
			$body .= "<br /><br />"; 

		/*	$this->email->from('info@trends.nz', 'TRENDS');
			$this->email->to($to);
			$this->email->reply_to($arraySend['Email'], $arraySend['Name']);

			$this->email->subject($subject);
			$this->email->message($body);
			$this->email->set_mailtype("html");

			 
			if($this->email->send()){
				$results = 1;
			}else{
				$results = 0;
			}
			 */

			//PHP Mailer
			$results = $this->SMTPMail('TRENDS', $arraySend['Email'], $arraySend['Name'], $to, $subject, $body);

			return  $results; 


		}
		
	}

	/* Skinned contact form */
	function sendContactForm($arraySend){
		if($arraySend){

			$name = @trim(stripslashes($arraySend['Name'])); 
			$email = @trim(stripslashes($arraySend['Email']));  
			$phone = @trim(stripslashes($arraySend['Phone'])); 
			$message  = @trim(stripslashes($arraySend['Details'])); 

			$body = 'Name: ' . $name . "<br /> " . 'Email: ' . $email . "<br /> " . 'Phone: ' . $phone . "<br /> " . 'Message: ' . $message;
            $subject = "TRENDS Contact Enquiry";

			$to = $arraySend['emailTo'];
			$info = $arraySend['infoEmail'];



			/* 

			$this->email->from($info, $name);
			$this->email->to($to);

			$this->email->subject($subject);
			$this->email->message($body);
			$this->email->set_mailtype("html");

			 
			if($this->email->send()){
				$results = 1;
			}else{
				$results = 0;
			}
			return  $results;  */

			//PHP Mailer
			$results = $this->SMTPMail('info@trends.nz', $email, $name, $to, $subject, $body);
			 
			return  $results;  

		}
	}


	function SMTPMail($info, $email, $name, $to, $subject, $body){


			$mail = new PHPMailer;

			$mail->isSMTP();
			$mail->Host = 'smtp.sitehost.co.nz';
			$mail->SMTPAuth = false; 
			$mail->Port = 25;

			$mail->setFrom('info@trends.nz', $info ); 
			$mail->addAddress($to);   
			//$mail->addBCC('jeoffyh@tuapeka.co.nz');   
			$mail->addReplyTo($email, $name );

			 
			
			$mail->isHTML(true);
			$mail->Subject = $subject;  

			$mail->Body    = $body;

			if(!$mail->send()) { 
				echo 'Mailer Error: ' . $mail->ErrorInfo; 
				 $results = 0;  
			} else { 
				$results = 1; 
			}  


			return  $results; 

	}
	 
	
	 
}
