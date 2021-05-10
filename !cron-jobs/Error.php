<?
	$code = $_GET['code'];
	$logoName = "Trends Collection";
	$logoLocation = 'Images/TopMenu/logo.png';
	$logoRef = "";
	include("scripts.php");
?>
<body>
	<div style="width:100%; height:100%">
		<? include("menuError.php"); ?>
		<div class="centerBoxProgs">
			<div class="centerBox">
				<div class="catBanner">
					<div class='ProdTitleLargeCat'>Website Error</div>
					<div class='middleBoxTextHdr3 bodyText'>
						<span class='PagesSmallItm'><? echo mysqli_connect_errno(); ?></span>
					</div>
				</div>
				<div align="center" style="padding-bottom: 50px;">
					<div class="fourOHfour">
						<img src="Images/porblem.png" width="207" height="173" alt="error">
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
			</div>
		</div>
	</div>
</body>
</html>