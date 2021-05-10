<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? include_once("../headTags.php"); ?>
	<?
		include_once("../functions.php");
		include("../setup.php");
	?>

	
<?php
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

	?>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,700" rel="stylesheet">
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="../Scripts/jquery.validationEngine-en.js?<? echo $randNum; ?>" charset="utf-8"></script>
	<script type="text/javascript" src="../Scripts/jquery.validationEngine.js?<? echo $randNum; ?>" charset="utf-8"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#pwforgot").validationEngine('attach', {promptPosition : "bottomLeft", scroll: false});
			
			$("a#submitter").fadeTo(0,0.5);
			$("a#submitter").css('cursor', 'default');
			$("a#submitter").addClass('settingsToolbarDisableHover');
			
			$("form :input").bind("keyup change", function(e) {
				/*if($("#accteml").val().length > 0){
					$("a#submitter").prop("href", "javascript: document.pwforgot.submit()");
					$("a#submitter").css('cursor', 'pointer');
					$("a#submitter").fadeTo(0,1);
					$("a#submitter").removeClass('settingsToolbarDisableHover');
				} else {
					$("a#submitter").prop("href", "#");
					$("a#submitter").css('cursor', 'default');
					$("a#submitter").fadeTo(0,0.5);
					$("a#submitter").addClass('settingsToolbarDisableHover');
				} */	
					var accteml = $('#accteml').val();  
					$('.check-email').hide();
					$.ajax({
							url: '/skinnedSiteAdmin/customSiteAddFunction.php',
							type: 'POST',
							data: {
								option: 11, 
								email: accteml,
								themeID: <?php echo $themeID; ?>, 
								customerNumber: <?php echo $customerNumber; ?>, 
							}, 
							dataType: "html",
							success: function (result) {  
								 console.log(result);
								 if(result == 1){
									$('.check-email').show();
									$('.check-email').html('<i class="fa fa-check" aria-hidden="true"></i> Email found');
									$("a#submitter").prop("href", "javascript: document.pwforgot.submit()");
									$("a#submitter").css('cursor', 'pointer');
									$("a#submitter").fadeTo(0,1);
									$("a#submitter").removeClass('settingsToolbarDisableHover');
								 }else{
									$('.check-email').show();
									$('.check-email').html('<i class="fa fa-times" aria-hidden="true"></i> Email doesn\'t exists');
									$("a#submitter").prop("href", "#");
									$("a#submitter").css('cursor', 'default');
									$("a#submitter").fadeTo(0,0.5);
									$("a#submitter").addClass('settingsToolbarDisableHover');
								 }
							}
					});  
			});
		});
	</script>
	<script language="javascript">
		function send() {
			document.pwforgot.submit()
		}
	</script>
	
	<link type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link href='../css/normal.css?<? echo $randNum; ?>' rel='stylesheet' type='text/css' media='screen' />
	<link href='../css/validationEngine.jquery.css?<? echo $randNum; ?>' rel='stylesheet' type='text/css'/>
	<style type="text/css">
		.check-email{
			font-size: 12px;
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
</head>
<body>
	<div class="emailBox">
		<div class='ProdTitleLargeCat' style='width:100%;margin-top:0px !important;padding-left: 5px;'>Forgot Password</div>
		<div class="HeaderSmallSettings">
			<div class='bodyText' style="padding-left: 15px;">
				Please enter your registered email address.<br />
				An email will be sent to you with a password reset link by the administrator.
			</div><br />
				<form id="pwforgot" name="pwforgot" class="emailForm" method="post" action="loginuserFGT2.php?idskin=<?php echo $themeID; ?>&customerId=<?php echo $customerNumber; ?>">
					<fieldset>
						<div class='HeaderSmallSettings' style="padding-left: 15px;">
						
							<legend>EMAIL ADDRESS</legend>
							<input type="text" name="accteml" id="accteml" style="width:281px" value="" onUnfocus="send()" class="validate[required] text-input" />
							<div class="check-email" style="display:none"></div>
						</div>
					</fieldset>
					<div class="bottomBarPopup">
						<a href="javascript: document.pwforgot.submit()" id="submitter" class='settingsToolbarButt7' >SEND</a>
						<a href='javascript:parent.jQuery.fancybox.close();' class='settingsToolbarButt3' >CLOSE THIS POPUP</a>
					</div>
				</form>
			</div>
		</div>
</body>
</html>