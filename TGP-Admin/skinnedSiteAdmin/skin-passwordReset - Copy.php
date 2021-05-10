<?php
	 
	$userCode = $_GET['resetPw'];
	$userCodeExp = explode(".", $userCode);
	 
	

	
	include_once("functions.php");
	include("encrypt.php");
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	echo error_reporting(E_ALL); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <? include_once("headTags.php"); ?>
    <?
        include_once("setup.php");
		include_once("scripts.php");
		
		
	if($userCode == "") {
		$error = 1;
		include("menu.php");
		include("404.php");
		echo "<title>$frontName | Error</title>\n";
		exit;
	} 
    ?>
    <script type="text/javascript">  
        $(document).ready(function() {
			$("a#pwReset").fancybox({
                'overlayShow'	: false,
                'transitionIn'	: 'elastic',
                'transitionOut'	: 'elastic',
                'autoSize'		: false,
                'width'			: 350,
                'height'		: 328,
                'closeBtn'		: false,
                'modal'			: true
            }).trigger('click');
        }); 
    </script>
    <title>Trends Collection</title>
</head>
<body>
	<div class="wrapper">
		<? include("menu.php"); ?>
		<div style="display:none">
			<a data-fancybox-type="iframe" id="pwReset" href="skinnedSiteAdmin/resetpw-user.php?cd=<? echo $userCode; ?>">click</a>
		</div>
		<? include("products.php"); ?>
        <div class="push"></div>
	</div>
	<? include("footer.php"); ?>
</body>
</html>