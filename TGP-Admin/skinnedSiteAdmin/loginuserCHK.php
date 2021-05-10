<?php 	session_start();
		include_once("../functions.php");
		include("../encrypt.php");

		$themeID = $_GET['idskin'];
		$customerNumber = $_GET['customerId']; 
		$bodyBG = '';
		$colorText = ''; 
	
		$queryThemer = "SELECT * FROM customSite WHERE themeID LIKE '".$themeID."' AND CustomerNumber LIKE '".$customerNumber."';";
		$resultThemer = dbPuller($queryThemer,0,0);
		if($themeResults = mysqli_fetch_array($resultThemer)) {
			 $bodyBG = $themeResults["BackgroundColour"];
			 $colorText = $themeResults["paragraphTextColour"];
		} 
		$emailAddy = $_POST['emailad'];
		$pwd = $_POST['pw']; 
		
		//debug_to_console("email: ".$emailAddy);
		
		//$emailAddy = stripslashes($emailAddy);
		
		$hashPassword = md5($pwd); 
		 
		$queryThemer = "SELECT * FROM skinnedUserData WHERE customsiteID= '".$themeID."' AND skinnedUserEmail= '".$emailAddy."' AND skinnedUserPassword = '".$hashPassword."';";
		$userOutput = dbPuller($queryThemer,0,0);
		$itsAllCool = 0;
		if ($result = mysqli_fetch_array($userOutput)) {
			//debug_to_console("calculating hash");
			/*$_SESSION["userskin_theme"] = $result['customsiteID'];
			$_SESSION["userskin_email"] = $result['skinnedUserEmail'];
			$_SESSION["userskin_id"] = $result['skinnedUserID'];
			$_SESSION["userskin_log"] = 1; */
			$itsAllCool = 1;
			
			//$date_of_expiry = time() + (60 * 10);  
			$date_of_expiry = time()+3600*24*30*3;
			setcookie('userskinlog', 1, $date_of_expiry, '/'); 
			setcookie('userskinemail', $result['skinnedUserEmail'], $date_of_expiry, '/'); 
			setcookie('userskintheme', $result['customsiteID'], $date_of_expiry, '/'); 
			setcookie('userskinid', $result['skinnedUserID'], $date_of_expiry, '/');   
		}  
		//Update the hash
		if ($itsAllCool == 1) {
			$newHash= md5($result['skinnedUserEmail'].'-'.uniqid());
			setcookie('userskincodehash', $newHash, $date_of_expiry, '/');   
			$sql = "UPDATE skinnedUserData SET skinnedUserSalt='".$newHash."' WHERE skinnedUserID=".$result['skinnedUserID']; 
			$resultz = dbPuller($sql,1);
		}
		 
		
		include("../salty.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? include_once("../headTags.php"); ?>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,700" rel="stylesheet">
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="../Scripts/jquery.validationEngine-en.js" charset="utf-8"></script>
	<script type="text/javascript" src="../Scripts/jquery.validationEngine.js" charset="utf-8"></script>
	<script type="text/javascript">
		$(document).ready(function(){
				// binds form submission and fields to the validation engine
				$("#pwchange").validationEngine({promptPosition : "bottomLeft", scroll: false});
				$("#pwchange").validationEngine('attach');
			});
	</script>
	<link href='../css/normal.css?<? echo $randNum; ?>' rel='stylesheet' type='text/css' media='screen' />
	<link href='../css/validationEngine.jquery.css' rel='stylesheet' type='text/css'/>
	<?php if($bodyBG){  ?>
		<style type="text/css">
			body { 
				background-color: #<?php echo $bodyBG; ?> !important; background-image: none !important; 
			}
			body, #pwchange, .HeaderSmall, .HeaderSmall legend, .bodyText{
				color: #<?php echo $colorText; ?> !important;
			}
		</style>	
	<?php } ?>
</head>
<body>
	<div class="emailBox">
		<div class='ProdTitleLargeCat' style='width:100%;margin-top:0px !important;padding-left: 5px;'>Login</div>
		<div class="HeaderSmallSettings">
				<?
					if ($itsAllCool == 1) {
						 
							echo "<script>setTimeout(function(){ parent.jQuery.fancybox.close(); }, 2000);</script>";
				?>
							
							<div class='bodyText'>You have been sucessfully logged in.</div>
                            <div class='bodyText'>This window should close automatically.</div>
							<div class="bottomBarPopup">
								<a href='javascript:parent.jQuery.fancybox.close();' class='settingsToolbarButt3' >CLOSE THIS POPUP</a>
							</div>
				<?  } else { ?>
							<div class='bodyText'>Sorry, your email or password may have been typed in incorrectly.</div>
							<div class='bodyText'>#05PWW48</div>
							<div class="bottomBarPopup">
								<a href="loginskin.php?idskin=<?php echo $themeID; ?>&customerId=<?php echo $customerNumber; ?>" class='settingsToolbarButt6' >GO BACK AND TRY AGAIN</a>
                                <a href="loginuserFGT.php?idskin=<?php echo $themeID; ?>&customerId=<?php echo $customerNumber; ?>" class='settingsToolbarButt5' >I FORGOT MY PASSWORD</a>
								<a href='javascript:parent.jQuery.fancybox.close();' class='settingsToolbarButt3' >CLOSE THIS POPUP</a>
							</div>
				<?		//debug_to_console( "hash mismatch1,  was: ".$newHash." expected: ".$oldHash,1);
					 }
					 ?>
			</div>
		</div>
</body>
</html>