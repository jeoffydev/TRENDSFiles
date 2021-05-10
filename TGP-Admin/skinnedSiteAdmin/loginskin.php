 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? include_once("../headTags.php"); ?>
	<? include("../setup.php"); 
	include_once("../functions.php"); 	 
	
	?>
	<?php
		$themeID = $_GET['idskin'];
		$customerNumber = $_GET['customerId']; 

	$activateForm = 0;
	$functionType = "";
	$checker = "";
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
			$("#loginne").validationEngine('attach', {promptPosition : "bottomLeft", scroll: false});
			
			$("a#submitter").fadeTo(0,0.5);
			$("a#submitter").css('cursor', 'default');
			$("a#submitter").addClass('settingsToolbarDisableHover');
			
			$("form :input").bind("keyup change click", function(e) {
				var checkr = 1;
				if($("#emailad").val().length < 1){
					checkr = 0;
				}
				if($("#pw").val().length < 1){
					checkr = 0;
				}
				if(checkr == 1){
					$("a#submitter").prop("href", "javascript: document.login.submit()");
					//$("a#submitter").addClass('loginthisUser');
					$("a#submitter").css('cursor', 'pointer');
					$("a#submitter").fadeTo(0,1);
					$("a#submitter").removeClass('settingsToolbarDisableHover');
				} else {
					$("a#submitter").removeClass('loginthisUser');
					$("a#submitter").prop("href", "#");
					$("a#submitter").css('cursor', 'default');
					$("a#submitter").fadeTo(0,0.5);
					$("a#submitter").addClass('settingsToolbarDisableHover');
				}
				if(e.which == 13) {
					if(checkr == 1){
						document.login.submit();
					}
					return false;
				} 	
			});

			//Login here
			$('#loginne').on('click', '.loginthisUser', function(){ 
				$('.error-login').html('');
				var emailad = $('#emailad').val();  
				var pw = $('#pw').val();  
				 //alert('Test next ' + emailad + ' ' + pw);
				$.ajax({
						url: '/skinnedSiteAdmin/customSiteAddFunction.php',
						type: 'POST',
						data: {
							option: 9, 
							emailad: emailad, 
							pw: pw
						}, 
						dataType: "html",
						success: function (result) {  
							 
								console.log(result);
								if(result == 1){
									 //console.log('Youre GOOD!');
									 
									$('#loginne').remove();
									$('.success-login').html('<p class="text-center"><i class="fa fa-check" aria-hidden="true"></i> Loading...</p>');
									setTimeout(function(){ parent.jQuery.fancybox.close(); }, 2000);
									
								}else{
									$('.error-login').html('<i class="fa fa-times" aria-hidden="true"></i>  ooops.. Wrong username or password');
								}
						}
				}); 
			});
		});
	</script>
	<script language="javascript">
		function send() {
			document.login.submit()
		}
	</script>
	<link type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link href='../css/normal.css?<? echo $randNum; ?>' rel='stylesheet' type='text/css' media='screen' />
	<link href='../css/validationEngine.jquery.css?<? echo $randNum; ?>' rel='stylesheet' type='text/css'/>
	<?php if($bodyBG){  ?>
		<style type="text/css">
			body { 
				background-color: #<?php echo $bodyBG; ?> !important; background-image: none !important; 
			}
			body, #pwchange, .HeaderSmall, .HeaderSmall legend, .ProdTitleLargeCat{
				color: #<?php echo $colorText; ?> !important;
			}
		</style>	
	<?php } ?>
</head>
<body>
	<div class="emailBox">
		<div class='ProdTitleLargeCat' style='width:100%;margin-top:0px !important;padding-left: 5px;'>Login</div>
		<div class="HeaderSmallSettings">&nbsp;
				<div class="success-login"></div>
                <form id="loginne" name="login" class="emailForm" method="post" action="loginuserCHK.php?idskin=<?php echo $themeID; ?>&customerId=<?php echo $customerNumber; ?>">
                    <div class='HeaderSmallSettings' style="padding-left: 15px;">
					<div class="error error-login" style="font-size:13px; text-align:left"></div>
					 
                        <fieldset>
                            <div class='HeaderSmall' style="margin-top:0px !important;">
                                <legend>EMAIL ADDRESS</legend>
                                <input type="text" name="emailad" id="emailad" style="width:281px" value="" class="validate[required] text-input" />
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class='HeaderSmall' style="margin-top:0px !important;">
                                <legend>PASSWORD</legend>
                                <input type="password" name="pw" id="pw" style="width:281px" value="" onUnfocus="send()" class="validate[required] text-input" />
                            </div>
                        </fieldset>
                    </div>
                    <div class="bottomBarPopup">
                        <a href="#" id="submitter" class='settingsToolbarButt4' >LOGIN</a>
                        <a href="loginuserFGT.php?idskin=<?php echo $themeID; ?>&customerId=<?php echo $customerNumber; ?>" class='settingsToolbarButt5' >I FORGOT MY PASSWORD</a>
                        <a href='javascript:parent.jQuery.fancybox.close();' class='settingsToolbarButt3' >CLOSE THIS POPUP</a>
                    </div>
               </form>
		</div>
	</div>
</body>
</html>