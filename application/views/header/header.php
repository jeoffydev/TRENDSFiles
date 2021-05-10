<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    if($this->general_model->mobileDetector() == 0){  
        $mobile = 0;
    }else{
        $mobile = 1;
    }
?>


<!DOCTYPE html>
<html id="csstyle" lang="en" ng-app='tgpApp' >

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
    <?php
        $this->load->view('header/metaDescription'); 
    ?> 
     <?php
        $this->load->view('header/ogMeta'); 
    ?> 
     
   

	<title><?=$pageTitle?></title> 
    <?php if(count($customArray['themeArray'])==0): ?>          
        <link rel="icon" href="<?=base_url()?>/Images/favicon.ico" type="image/ico">
    <?php else: ?>     

                        <?php 
                        $logoLocation = '/Images/TopMenu/customerLogos/favicon/'.$customArray['themeArray'][0]->themeID.'.ico';
                        if(file_exists($_SERVER['DOCUMENT_ROOT'].$logoLocation)): ?> 
                            <link rel="icon" href="<?=base_url()?>/Images/TopMenu/customerLogos/favicon/<?=$customArray['themeArray'][0]->themeID?>.ico" type="image/ico"> 
                        <?php else: ?>    
                            <link rel="icon" href="<?=base_url()?>/Images/favicon.ico" type="image/ico">
                        <?php endif; ?>
          
    <?php endif; ?>   
    
    <!-- Mobile and desktop -->
    <?php  if($mobile == 0): ?> 
        <link href="<?=base_url();?>public/css/bootstrap.css" rel="stylesheet">  
    <?php else: ?> 
        <link href="<?=base_url();?>public/css/bootstrap.min.css" rel="stylesheet">  
    <?php endif; ?> 
    <link href="<?=base_url();?>public/css/tgp-stylesheet.css?ver=<?=date("Ymdhis")?>" rel="stylesheet">  
    <?php  if($mobile == 1): ?> 
        <link href="<?=base_url();?>public/css/tgp-stylesheet-responsive.css?ver=<?=date("Ymdhis")?>" rel="stylesheet">   
    <?php endif; ?>
     <!-- Mobile and desktop -->

    <link href="<?=base_url();?>public/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url();?>public/css/textangular.css" rel="stylesheet">
    <link href="<?=base_url();?>public/css/colorpicker.css" rel="stylesheet">
    <link href="<?=base_url();?>public/css/angular-select.css" rel="stylesheet">  
    <link href="<?=base_url();?>public/css/select2.min.css" rel="stylesheet" />
	<link href="<?=base_url();?>public/css/main.css?v=100002" rel="stylesheet" />
  
    <?php if($stylesheet != "" || $stylesheet  != null): ?>  
        <link href="<?=base_url();?>public/css/<?=$stylesheet?>.css" rel="stylesheet">  
    <?php endif; ?> 
     
    <?php
	    $this->load->view('header/themefier');
    ?> 

</head> 
<body ng-controller="<?=$angularFile?>Ctrl"  >

<?php
	$this->load->view('header/googleAnalytics');
?> 
 
<div ng-controller="generalCtrl as ctrl" <?php  if($mobile == 0): ?> id="generalWrapper" <?php endif; ?>   > <!-- removed class="ng-cloak"  start of general Control--> 
<!-- menu -->
<?php
	$this->load->view('header/menu');
?> 	 
<!-- menu -->
