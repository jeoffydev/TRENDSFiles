 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? 
	
	
	
	include_once("headTags.php"); ?>
	<?
		$userCode = $_GET['cd'];
		$userCodeExp = explode(".", $userCode);
		$activateForm = 0;
		$functionType = "";
		$checker = "";
		$bodyBG = '';
		$colorText = '';
		$userCodeExp2 = $userCodeExp[1];
		include_once("../functions.php"); 
		
		$tI = 'skinnedUserData'; 
		$query = "SELECT customsiteID, skinnedCustomerNumber, skinnedUserID, skinnedUserEmail, skinnedUserCompany, skinnedHash FROM ".$tI." WHERE skinnedHash ='".$userCodeExp2."' "; 
		$error = 0;		 
		
		$result = dbPuller($query,0);
		//$num_rows = mysql_num_rows($result);
		$countRows = $result->num_rows;
		//print_r($result); 
		$countar = 0;
		if($countRows > 0){
			
			while($usePw = mysqli_fetch_array($result)) {
				
				$usePwEmail .= $usePw['skinnedUserEmail'];
				$usePwCompany .= $usePw['skinnedUserCompany'];
				$usePwName .= $usePw['skinnedUserName'];
				$usePwID .= $usePw['skinnedUserID'];
				$useHash .= $usePw['skinnedHash'];
				$themeID .= $usePw['customsiteID'];
				$customerNumber .= $usePw['skinnedCustomerNumber'];
				
				$countar++;
			}
			//echo $useHash. "<br />";
			$hashMe = md5($usePwEmail.''.$usePwID).'.'.$useHash; 
			 //echo $hashMe;
			if($hashMe == $userCode){
				$activateForm = 1;
			}
			
			$queryThemer = "SELECT * FROM customSite WHERE themeID LIKE '".$themeID."' AND CustomerNumber LIKE '".$customerNumber."';";
			$resultThemer = dbPuller($queryThemer,0,0);
			if($themeResults = mysqli_fetch_array($resultThemer)) {
				 $bodyBG = $themeResults["BackgroundColour"];
				 $colorText = $themeResults["paragraphTextColour"];
				 $domainLink = $themeResults["Domain"];
				 $thisDomain = $_SERVER['SERVER_NAME'];	
				 if($domainLink != null){
					//$domainLink = '/';
					$domainLink = '//' .$domainLink;
				 }else{
					$domainLink = '/ID'.$customerNumber.''.$themeID;
				 } 
			}
		}
		


		 
	?>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,700" rel="stylesheet">
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="/Scripts/jquery.validationEngine-en.js?<? echo $randNum; ?>" charset="utf-8"></script>
	<script type="text/javascript" src="/Scripts/jquery.validationEngine.js?<? echo $randNum; ?>" charset="utf-8"></script>
    <script type="text/javascript">
		$(document).ready(function(){
			$("#pwchange").validationEngine('attach', {promptPosition : "bottomLeft", scroll: false});
		
			$("a#submitterResetPW").fadeTo(0,0.5);
			$("a#submitterResetPW").css('cursor', 'default');
			$("a#submitterResetPW").addClass('settingsToolbarDisableHover');
			$("a#submitterResetPW").removeClass('changeThisPW');
			
			 
			$('#pw').keyup(function() {
				if($('#pw').val().length === 0 || $('#pw2').val().length === 0){
						$("a#submitterResetPW").prop("href", "#");
						$("a#submitterResetPW").css('cursor', 'default');
						$("a#submitterResetPW").fadeTo(0,0.5);
						$("a#submitterResetPW").addClass('settingsToolbarDisableHover');
						$("a#submitterResetPW").removeClass('changeThisPW');
				}
			});
			 
			$('#pw2').keyup(function() {
				var pass1 = document.getElementById('pw');
				var pass2 = document.getElementById('pw2');
				
				if(pass1.value == pass2.value){
					$("a#submitterResetPW").addClass('changeThisPW');
					$("a#submitterResetPW").css('cursor', 'pointer');
					$("a#submitterResetPW").fadeTo(0,1);
					$("a#submitterResetPW").removeClass('settingsToolbarDisableHover');
				} else {
					$("a#submitterResetPW").prop("href", "#");
					$("a#submitterResetPW").css('cursor', 'default');
					$("a#submitterResetPW").fadeTo(0,0.5);
					$("a#submitterResetPW").addClass('settingsToolbarDisableHover');
					$("a#submitterResetPW").removeClass('changeThisPW');
				}
			});

			$('.btn-reset-user-pw').on('click', '.changeThisPW', function(){ 
				var changepw = $('#pw').val();  
				var changeIDpw = $('#pwid').val();  
				 //alert('Test next ' + changepw + ' ' + changeIDpw);
				 $.ajax({
						url: '/skinnedSiteAdmin/customSiteAddFunction.php',
						type: 'POST',
						data: {
							option: 8, 
							id: changeIDpw, 
							pw: changepw
						}, 
						dataType: "html",
						success: function (result) { 
								$('.pwform-reset, #submitterResetPW').remove();
								$('#pwreset-login').show();
								//$('.success-pw').html('<p class="text-center"><i class="fa fa-check text-red" aria-hidden="true"></i> New password Saved </p> <p style="margin-top:20px;" class="margin-top"><a data-fancybox-type="iframe" id="loginne"  href="<?php echo '/skinnedSiteAdmin/loginskin.php?idskin='.$themeID.'&customerId='.$customerNumber.'' ?>" class="btn btn-default skinneduser-btn necessary">Close and login</a></p>');
								 $('.success-pw').html('<p class="text-center"><i class="fa fa-check text-red" aria-hidden="true"></i> New password Saved </p> <p style="margin-top:20px;" class="margin-top"><a class="btn btn-default skinneduser-btn necessary" href="<?php echo $domainLink; ?>" target="_parent"> Close and login</a></p>'); 
								 
								//parent.location.reload(true);
								//window.parent.location = "<?php echo $domainLink; ?>"; 
								setTimeout(function(){window.parent.location = "<?php echo $domainLink; ?>"} , 1000);   
						}
				});	 
			});
		});
	</script>
    <link type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='../css/normal.css?<? echo $randNum; ?>' rel='stylesheet' type='text/css' media='screen' />
    <link href='../css/validationEngine.jquery.css?<? echo $randNum; ?>' rel='stylesheet' type='text/css'/>
	
	<style type="text/css">
		.HeaderSmall legend{
			font-size:14px !important;
			font-weight: 400;
		}
		
	</style>
	<?php if($bodyBG){  ?>
		<style type="text/css">
			body { 
				background-color: #<?php echo $bodyBG; ?> !important; background-image: none !important; 
			}
			body, #pwchange, .HeaderSmall, .HeaderSmall legend, .ProdTitleLargeCat, .bodyText, .HeaderSmallSettings legend{
				color: #<?php echo $colorText; ?> !important;
			}
		</style>	
	<?php } ?>
	 
<body>
	<div class="emailBox">
		<div class='ProdTitleLargeCat' style='width:100%;margin-top:0px !important;padding-left: 5px;'>Reset Password</div>
		<br />
			<? if($activateForm == 1) { ?>
				<div class="success-pw"></div>
                <form id="pwchange" name="pwchange" class="emailForm" method="post" action="loginmeFGT4.php">
                    <div class="HeaderSmallSettings pwform-reset" style="padding-left: 15px;">
                        <div class='HeaderSmall' style="margin-top:0px !important;">
                            <legend>Email: <? echo $usePwEmail; ?></legend>
			<!--<?php if($usePwCompany){ ?><legend>Company: <? echo $usePwCompany; ?></legend><?php } ?>-->
                            </div><br />
                        <fieldset>
                            <div class='HeaderSmall' style="margin-top:0px !important;">
                                <legend>ENTER NEW PASSWORD</legend>
                                <input type="password" name="pw" id="pw" style="width:281px" value="" class="validate[required,minSize[6]] text-input" />
                            </div>
                        </fieldset><br />
                        <fieldset>
                            <div class='HeaderSmall' style="margin-top:0px !important;">
                                <legend>CONFIRM NEW PASSWORD</legend>
                                <input type="password" name="pw2" id="pw2" style="width:281px" value="" class="validate[required,equals[pw]] text-input" />
                            </div>
                        </fieldset>
                        <fieldset>  
                            <input type="hidden" name="cd" id="pwcd" value="<? echo $useHash; ?>" />
                            <input type="hidden" name="id" id="pwid" value="<? echo $usePwID; ?>" />
                        </fieldset>
                    </div>
                    <div class="bottomBarPopup btn-reset-user-pw">
                        <a href="#" class='settingsToolbarButt1' id="submitterResetPW" >UPDATE</a>  <a href='/index.php?page=products' target='_parent' class='settingsToolbarButt3' >CLOSE THIS POPUP</a> 
                    </div>
                </form>
            <? } else { ?>
                <div class='bodyText' style="padding-left: 15px;">Sorry, your link did not seem to work, please go back to the email and try copy/pasting the link.</div>
                <div class='bodyText' style="padding-left: 15px;">#15SLT<? echo $userID; ?></div>
                <div class='bodyText' style="padding-left: 15px;"><a href="mailto:webmaster@trendscollection<? echo $emailExtension; ?>?Subject=Error%20%2315SLT<? echo $userID; ?>%20on%20FGT3">Click here to email us about this error.</a></div>
                <div class="bottomBarPopup">
                    <a href='/index.php?page=products' target='_parent' class='settingsToolbarButt3' >CLOSE THIS POPUP</a>
                </div>
                <? debug_to_console( "Code didn't match. was: ".$userCode." expected: ".$checker,1); ?>
            <? } ?>
		</div>
</body>
</html>