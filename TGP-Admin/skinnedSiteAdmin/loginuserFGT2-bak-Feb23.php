<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? include_once("../headTags.php"); ?>
	<?
	 
		include("../setup.php");
		include_once("../functions.php");
		include("../encrypt.php");
		$whichDomain = "";
		//require_once "Mail.php";
		
		$acctEmail = $_POST['accteml'];
		$themeID = $_GET['idskin'];
		$customerNumber = $_GET['customerId']; 
		$bodyBG = '';
		$colorText = ''; 
	
		$queryThemer = "SELECT * FROM customSite WHERE themeID LIKE '".$themeID."' AND CustomerNumber LIKE '".$customerNumber."';";
		$resultThemer = dbPuller($queryThemer,0,0);
		if($themeResults = mysqli_fetch_array($resultThemer)) {
			 $bodyBG = $themeResults["BackgroundColour"];
			 $colorText = $themeResults["paragraphTextColour"];
			 $customsiteAdminEmail = $themeResults["customsiteAdminEmail"];
			 $Domain = $themeResults["Domain"];
		} 

		if($acctEmail == ""){
			$acctEmailBlank = 1;	
		} else {
			$acctEmailBlank = 0;
		}

		$rootUrl =  url();
		$rpUrl = '/reset-user';
		function url(){
            if(isset($_SERVER['HTTPS'])){
                $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
            }
            else{
                $protocol = 'http';
            }
            return $protocol . "://" . $_SERVER['HTTP_HOST'];
        }
		
		//$acctEmail = stripslashes($acctEmail); 
		//$result = checkUser($acctEmail,1);

		include("../salty.php");		
?>
<link type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link href='../css/normal.css?<? echo $randNum; ?>' rel='stylesheet' type='text/css' media='screen' />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,700" rel="stylesheet">
	<?php if($bodyBG){  ?>
		<style type="text/css">
			body { 
				background-color: #<?php echo $bodyBG; ?> !important; background-image: none !important; 
			}
			body, #pwchange, .HeaderSmall, .HeaderSmall legend{
				color: #<?php echo $colorText; ?> !important;
			}
		</style>	
	<?php } ?>
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
 
						$queryThemers = "SELECT * FROM skinnedUserData WHERE customsiteID= '".$themeID."' AND skinnedUserEmail= '".$acctEmail."' AND skinnedCustomerNumber = '".$customerNumber."';";
						$userOutputs = dbPuller($queryThemers,0,0); 
						if ($results = mysqli_fetch_array($userOutputs)) { 
							/*echo $results["skinnedUserID"];
							echo "<br />";
							echo $results["skinnedUserEmail"];*/
							$uniqueID = uniqid(); 
							$resetpwCode = md5($results["skinnedUserEmail"].''.$results["skinnedUserID"]).'.' .$uniqueID; 
							/*echo "<br />";
							echo $customsiteAdminEmail;
							echo "<br />";
							echo $Domain; */
							$sql = "UPDATE skinnedUserData SET skinnedPwReset ='".$resetpwCode."', skinnedHash = '".$uniqueID."' WHERE skinnedUserID=".$results['skinnedUserID']; 
							$resultz = dbPuller($sql,1);
							if($resultz){
								 	//echo "<br />";
									 if($Domain == null){
										$domainUrl =  $rootUrl.$rpUrl.'/ID'.$results['skinnedCustomerNumber'].''.$results['customsiteID'].'/'; 
									}else{
										$domainUrl = $Domain.$rpUrl.'/';
									}
									$urlLink = $resetpwCode;
									$finResetPw = $domainUrl.''.$urlLink; 
									
							}

							//Email settings
									
							$to = $customsiteAdminEmail;
							$from = $results["skinnedUserEmail"];
							$subject = $results['skinnedUserName']. " Password Reset Request";
							$body = "<html>You have received a request to reset the password associated with this email address ".$acctEmail.", Customer Number: ".$results['skinnedCustomerNumber']."
							and Theme ID: ".$results['customsiteID']."<br />"; 
							//$body .= "<a href='http://".$whichDomain."/pwReset.php?cd=".$acctEmailLink."'>Click here to reset your password</a></html><br /><br />";
							$body .= "Please send this reset password link " .$finResetPw;
							 
							$headers = "From: ".$results["skinnedUserCompany"]." <webmaster@trendscollection.co.nz>\r\n";
							$headers .= "Reply-To: ".$results["skinnedUserEmail"]."\r\n";
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

						}else{
							?>
								<div class='bodyText' style="padding-left: 15px;">Sorry, we could not find that email address.</div>
								<div class='bodyText' style="padding-left: 15px;">Please go back and try typing it again.</div>							
								<div class="bottomBarPopup"> 
									<a href='javascript:parent.jQuery.fancybox.close();' class='settingsToolbarButt3' >CLOSE THIS POPUP</a>
								</div>

							<?php

						} 	

						/*if ($result = mysqli_fetch_array($result)) {
							
							if($result['Currency'] == "NZD") {
								$whichDomain = "www.trendscollection.co.nz";
							} else {
								$whichDomain = "www.trendscollection.com.au";
							}
							
							//$newSalt = grind_salt();
							$newSalt = $result['userSalt'];
							$acctEmailLink = $newSalt.".".$result['userID'];
							
							$sql = "UPDATE userData SET pwReset='".$acctEmailLink."' WHERE userID=".$result['userID'];
							
							$resultz = dbPuller($sql,1);
							
							$_SESSION['userID'] = $userID;
							
							//Email
							ini_set ("sendmail_from","webmaster@trendscollection.co.nz");
							$to = $result['userEmail'];
							$subject = "Trends Collection Password Reset";
							$body = "<html>We have received a request to reset the password associated with your email address.<br />";
							$body .= "If you made this request please follow the link below.<br />";
							$body .= "<a href='http://".$whichDomain."/pwReset.php?cd=".$acctEmailLink."'>Click here to reset your password</a></html><br /><br />";
							//$body .= "If this wasn't you, please click the link below to reset the request.<br />";
							//$body .= "<a href='http://www.trendscollection.co.nz/pwResetReset.php?cd=".$acctEmailLink."'>Click here to remove this request</a></html>";
							
							$headers = "From: Trends Collection <webmaster@trendscollection.co.nz>\r\n";
							$headers .= "Reply-To: info@tuapeka.co.nz\r\n";
							$headers .= "MIME-Version: 1.0\r\n";
							$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
							
							if (mail($to, $subject, $body, $headers)) { ?>
								<div class='bodyText' style="padding-left: 15px;">Password Reset email sent!</div>
								<div class="bottomBarPopup">
									<a href='javascript:parent.jQuery.fancybox.close();' class='settingsToolbarButt3' >CLOSE THIS POPUP</a>
								</div>
							<? } else { ?>
								<div class='bodyText' style="padding-left: 15px;">Something went wrong</div>
								<div class='bodyText' style="padding-left: 15px;">#99EML47</div>
								<div class='bodyText' style="padding-left: 15px;"><a href="mailto:webmaster@trendscollection<? echo $acctEmailExtension ?>?Subject=Error%20%2399EML47%20on%20FGT2">Click here to email us about this error.</a></div>
								<div class="bottomBarPopup">
									<a href="loginmeFGT.php" class='settingsToolbarButt6' >GO BACK AND TRY AGAIN</a>
									<a href='javascript:parent.jQuery.fancybox.close();' class='settingsToolbarButt3' >CLOSE THIS POPUP</a>
								</div>
                                <? debug_to_console( "Email didnt send, address was: ".$acctEmail." and converted to: ".$to,1); ?>
							<? } 
						} else { ?>
							<div class='bodyText' style="padding-left: 15px;">Sorry, we could not find that email address.</div>
							<div class='bodyText' style="padding-left: 15px;">Please go back and try typing it again.</div>							
							<div class="bottomBarPopup">
								<a href="loginmeFGT.php" class='settingsToolbarButt6' >GO BACK AND TRY AGAIN</a>
								<a href='javascript:parent.jQuery.fancybox.close();' class='settingsToolbarButt3' >CLOSE THIS POPUP</a>
							</div>
                            <? debug_to_console( "Wrong address, address was: ".$acctEmail." and converted to: ".$to,1); ?>
						<? }*/
					}
				?>
			</div>
		</div>
</body>
</html>