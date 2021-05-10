<?
	$code = $_GET['code'];
	$logoName = "Trends Collection";
	$logoLocation = '/Images/TopMenu/logo.png';
	$logoRef = "";
	include("scripts.php");
?>
<body>
	<div class='ProdTitleLargeCat' style='float:none;margin-top:0px !important;padding-left:5px;'>Error: <? echo mysqli_connect_errno(); ?></div>
	<div align="center" style="padding-bottom: 50px;">
		<div class="fourOHfour">
			<img src="/Images/porblem.png" width="207" height="173" alt="error">
			<br />
			<div class="fourOHfourBody">
				<div>Sorry, there seems to be a problem with our website currently.</div>
				<br />
				<div>Please try again later.</div>
				<br />
				<div><i><? echo $errorType; ?></i></div>
			</div>
		</div>
	</div>
	<div class="bottomBarPopup">
		<a href='javascript:parent.jQuery.fancybox.close();' class='settingsToolbarButt3' >CLOSE THIS POPUP</a>
	</div>
</body>
</html>