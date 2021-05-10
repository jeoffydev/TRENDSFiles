
<?php
	$this->load->view('header/header');
?> 
 
<div class="container-fluid">
	<div class="jumbotron customer" >
        <div class="row">
            <div class="col-md-6"> <h2>Order Dashboard  </h2> </div>
            <div class="col-md-6 text-right"> 

                
                
            </div>
        </div>
        
	</div>
</div>
<div class="main-customer-wrapper" >
    <div class="container-fluid " >
        <div class="abouttext" ng-cloak >  
            <div class="row">
                <div class="col-md-12 text-center margin-top">
                   
                    <?php if($siteLogcheck['userDatas'][0]->OrderDashboardAccess == 1  && $siteLogcheck['loggedIn'] == 1  ){ ?>
                        <span ng-init="reloadToDashboard()" > </span> 
                    <?php }else{ ?>
                        <a href="#" id="navbarDropdownAccount" data-toggle="modal" data-target="#loginFormModal"><u>Please login to access your order dashboard</u></a>  
                    <?php } ?>
                    
                    
                </div>
            </div>
        </div>
        
    </div>
</div>

  


<?php
	$this->load->view('footer/footer');
?> 