<!DOCTYPE html>
<html lang="en"  ng-app='tgpApp'>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Pragma" content="no-cache">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Trends Collection - Admin</title>
  <!-- Bootstrap core CSS-->
  <link href="<?php echo $baseUrl; ?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="<?php echo $baseUrl; ?>/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="<?php echo $baseUrl; ?>/assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="<?php echo $baseUrl; ?>/assets/css/sb-admin.css" rel="stylesheet"> 
  <!-- Jquery Excel-->
  <link href="<?php echo $baseUrl; ?>/assets/css/jexcel.min.css" rel="stylesheet"> 
  <!-- Custom styles for this template-->
  <link href="<?php echo $baseUrl; ?>/assets/css/custom.css" rel="stylesheet">

  <link href="<?php echo $baseUrl; ?>/assets/css/textangular.css" rel="stylesheet">
  <link href="<?php echo $baseUrl; ?>/assets/css/colorpicker.css" rel="stylesheet"> 

</head>

<body class="fixed-nav sticky-footer bg-dark " id="page-top"  ng-controller="editCtrl"  >
 
<!-- Navigation-->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="<?php echo $navUrl; ?>/home"><img src="../Images/footer-logo.png" class="footerImg img-responsive" style="max-width:180px"></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

   
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">

      <?php 
      
        foreach($allPages as $rowpage):
 
              $removeDashed = str_replace("-"," ", $rowpage['accessPage']);
              if (in_array($rowpage['pageNumber'], $resultPages)): 
                
                     
                          $navName = ucwords($removeDashed);
                          if($navName == 'Home'){
                            $navName = "Dashboard";
                          }
                          if($navName == 'Edit Products'){
                              $navName = "Product Management";
                          }
                          if($navName == 'Skinned Website'){
                              $navName = "Skinned Website Manager";
                          }
                          echo '<li class="nav-item" data-toggle="tooltip" data-placement="right" title="'.$navName.'">'; 
                          echo '<a class="nav-link" href="'.$navUrl.'/'.$rowpage['accessPage'].'">'; 
                                echo '<span class="nav-link-text">'.$navName.'</span>';
                            echo '</a>';    
                          echo '</li>';
               
              endif;
         
         
        endforeach;


      ?>
        
         
       

         
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          
        </li>
        <li class="nav-item dropdown">
          
        </li>
        <li class="nav-item">
         
        </li>
        <li class="nav-item">
          <a class="nav-link" ><i class="fa fa-fw fa-user"></i> <?php echo trim($userEmail)." - ".trim(strtoupper($companyName)); ?></a>
        </li>
      </ul>
    </div>
  </nav>

<!-- wrapper -->
<div class="content-wrapper main-content ng-cloak">
    <div class="container-fluid">
 