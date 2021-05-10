 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
	<?
	  
		
		$acctEmail = 'jeoffy_hipolito@yahoo.com';
		$customsiteAdminEmail = 'jeoffyh@tuapeka.co.nz';
		$themeID = 'THEMEID220000'; 
		$customerNumber = 'CUSTOMERNUM110000'; 
		$finResetPw = 'http://localhost/test-url';
		$bodyBG = '';
		$colorText = ''; 
		$distributorCompanyName = 'Sample Company Name';
		 
		 

		if($acctEmail == ""){
			$acctEmailBlank = 1;	
		} else {
			$acctEmailBlank = 0;
		}

		  
	 	
?>
 
</head>
<body>
	<div class="emailBox">
		<div class='ProdTitleLargeCat' style='width:100%;margin-top:0px !important;padding-left: 5px;'>Forgot Password</div>
		<div class="HeaderSmallSettings">
				<?
					if($acctEmailBlank == 1) { ?>
						<div class='bodyText' style="padding-left: 15px;">Sorry, we could not find that email address.</div>
						<div class='bodyText' style="padding-left: 15px;">Please go back and try typing it again.</div>				
						<div class="bottomBarPopup"> 
							<a href='javascript:parent.jQuery.fancybox.close();' class='settingsToolbarButt3' >CLOSE THIS POPUP</a>
						</div>
                        <? debug_to_console( "Blank acct num",1); ?>
				<?	} else {
 
						 

							//Email settings
									
							$to = $customsiteAdminEmail;
							$from = $acctEmail;
							$subject =  "Test Password Reset Request";
							$body = "<html>You have received a request to reset the password associated with this email address ".$acctEmail.", Customer Number: ".$customerNumber."
							and Theme ID: ".$themeID."<br />"; 
							//$body .= "<a href='http://".$whichDomain."/pwReset.php?cd=".$acctEmailLink."'>Click here to reset your password</a></html><br /><br />";
							$body .= "Please send this reset password link " .$finResetPw;
							 
							$headers = "From: ".$distributorCompanyName." <webmaster@trendscollection.co.nz>\r\n";
							$headers .= "Reply-To: ".$acctEmail."\r\n";
							$headers .= "MIME-Version: 1.0\r\n";
							$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
							/*
							echo $to;
							echo $subject;
							echo $body;
							echo $headers; */

							if (mail($to, $subject, $body, $headers)) { ?>
								<div class='bodyText' style="padding-left: 15px;">Password Reset request sent!</div>
								<div class="bottomBarPopup">
									<a href='javascript:parent.jQuery.fancybox.close();' class='settingsToolbarButt3' >CLOSE THIS POPUP</a>
								</div> 
							<?php	
							} else { ?>
								<div class='bodyText' style="padding-left: 15px;">Something went wrong</div>
								<div class='bodyText' style="padding-left: 15px;">#99EML47</div>
								<div class='bodyText' style="padding-left: 15px;"><a href="mailto:webmaster@trendscollection<? echo $acctEmailExtension ?>?Subject=Error%20%2399EML47%20on%20FGT2">Click here to email us about this error.</a></div>
								<div class="bottomBarPopup">
								<a href="loginuserFGT.php" class='settingsToolbarButt6' >GO BACK AND TRY AGAIN</a>
								<a href='javascript:parent.jQuery.fancybox.close();' class='settingsToolbarButt3' >CLOSE THIS POPUP</a>
							<?php
							}

						 

						 
					}
				?>
			</div>
		</div>
</body>
</html>