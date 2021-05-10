<?php
	 
	$userCode = $_GET['resetPw'];
	$userCodeExp = explode(".", $userCode);
	 
	

	
	include_once("functions.php");
	include("encrypt.php");
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	echo error_reporting(E_ALL); 
?>
 
     
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
     
		<div style="display:none">
			<a data-fancybox-type="iframe" id="pwReset" href="skinnedSiteAdmin/resetpw-user.php?cd=<? echo $userCode; ?>">click</a>
		</div>
		 
 