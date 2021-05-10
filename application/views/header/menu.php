 

 <?php // echo "<pre>";  print_r($this->general_model->getRecentlyViewed()); echo "</pre>"; ?> 
 
<?php //echo "<pre>"; 
     //print_r($siteLogcheck); 
//echo "</pre>";
 
?> 

 
 

<div class="mainMenu  <?php if(count($customArray['themeArray']) > 0 && $customArray['themeArray'][0]->showPricing == 2): ?> skinned_auth_menu <?endif;?> <?php if( (count($customArray['themeArray']) > 0 && $customArray['themeArray'][0]->showPricing == 1) || (count($customArray['themeArray']) > 0 && $customArray['themeArray'][0]->showPricing == 0)  ): ?> skinned_noauth_menu <?endif;?> ">
    <div class="hoverout" ng-mouseleave="hoverOut()" ></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 position-relative">
               

                <!-- MAIN MENUS--> 

                <div class="padding main-products-menu main-menus productsmenu" style="visibility:hidden" ng-mouseleave="hoverOut()"  ng-cloak>
                                    <div class="row">
                                        <div class="col-md-12"><h5>  Products A-Z  <span class="pull-right"> THE FUTURE OF PROMOTIONAL PRODUCTS </span> </h5></div>
                                    </div>
                                    <div class="row">        
                                         <?php  
                                            $i = 0;
                                            echo '<div class="col-md-2">';
                                            foreach($productsMenu as $productsMenuItem){
                                                $i++;
                                                echo '<a class="dropdown-item" href="/category/' .$productsMenuItem->CategoryNum. '/all'.strtoupper($customArray['customID']).'">' .$productsMenuItem->CategoryNameProducts. '</a>';

                                                if($i == 22) {  
                                                    echo '</div><div class="col-md-2">';
                                                    $i = 0;
                                                }
                                            }  
                                        ?>  
                                        </div>
                                    </div>    
                                    
                </div>

                 <div class="padding main-collections-menu main-menus collectionsmenu"  style="visibility:hidden"  ng-mouseleave="hoverOut()"  ng-cloak >
                                    <div class="row">
                                        <div class="col-md-12"><h5>Collections  <span class="pull-right"> PRODUCT IDEAS BY CATEGORY AND INDUSTRY </span> </h5></div>
                                    </div>
                                    <div class="row">
                                        <?php  
                                            $i = 0;
                                            echo '<div class="col-md-3">';
                                            foreach($collectionsMenu as $collectionsMenuItem){
                                                $i++;
                                                echo '<a class="dropdown-item" href="/category/' .$collectionsMenuItem->CategoryNum. '/all'.strtoupper($customArray['customID']).'">' .$collectionsMenuItem->CategoryName. '</a>';

                                                if($i == 6) {  
                                                    echo '</div><div class="col-md-3">';
                                                    $i = 0;
                                                }
                                            }  
                                        ?> 
                                        </div> 
                                    </div>
                </div>

                <div class="padding main-premium-menu main-menus premiummenu"  style="visibility:hidden" ng-mouseleave="hoverOut()"   ng-cloak>
                                    <div class="row">
                                        <div class="col-md-12"><h5> Brands   <span class="pull-right">  INTERNATIONAL BRANDS WITH PREMIUM DESIGN </span>  </h5></div>
                                    </div>
                                    <div class="row"> 
                                        <?php  
                                            $i = 0; 
                                            
                                            foreach($premiumMenu as $premiumMenuItem){
                                                $i++;
                                                echo '<div class="col-md-3">';
                                                echo '<a class="dropdown-item" href="/category/'.$premiumMenuItem['url'].'/all'.strtoupper($customArray['customID']).'"><img class="mr-3" src="'.base_url().'/Images/ProductCats/'.$premiumMenuItem['url'].'.jpg" alt=" " width="60" height="60" >' .$premiumMenuItem['title']. '</a>';
                                                echo '</div>';
                                                  
                                            }  
                                        ?>  
                                        
                                    </div>
                </div>

                <div class="padding main-worldsource-menu main-menus worldsourcemenu"  style="visibility:hidden"  ng-mouseleave="hoverOut()"  ng-cloak>
                                    <div class="row">
                                        <div class="col-md-12"><h5> World Source Express <span class="pull-right">  A WORLD OF PROMOTIONAL PRODUCTS AT YOUR FINGERTIPS </span>  </h5></div>  
                                    </div>
                                    <div class="row"> 
                                        <?php  
                                            $i = 0; 
                                            echo '<div class="col-md-2">';
                                            foreach($worldSourceMenu as $worldSourceMenuItem){
                                                $i++;
                                                if($worldSourceMenuItem->CategoryNum != "102-0"):
                                                    echo '<a class="dropdown-item" href="/category/'.$worldSourceMenuItem->CategoryNum.'/all'.strtoupper($customArray['customID']).'" >' .$worldSourceMenuItem->CategoryName. '</a>';
                                                endif;    
                                                if($i == 9) {  
                                                    echo '</div><div class="col-md-2">';
                                                    $i = 0;
                                                }
                                            }  
                                        ?>  
                                    </div>
                                </div>    
                 </div>

                 <div class="padding main-promoshop-menu main-menus promoshopmenu"  style="visibility:hidden"  ng-mouseleave="hoverOut()" ng-cloak>
                                    <div class="row">
                                        <div class="col-md-12"><h5>  Clearance  <span class="pull-right">  LIMITED EDITION PROMOTIONAL PRODUCTS AT GREAT PRICES </span></h5></div>
                                    </div>
                                    <div class="row"> 
                                        <?php  
                                            $i = 0; 
                                            echo '<div class="col-md-3">';
                                            foreach($promoShopMenu as $promoShopMenuItem){
                                                $i++;
                                                echo '<a class="dropdown-item" href="/category/'.$promoShopMenuItem['url'].'/all'.strtoupper($customArray['customID']).'"><img class="mr-3" src="'.base_url().'/Images/ProductCats/'.$promoShopMenuItem['url'].'.jpg" alt=" " width="60" height="60" >' .$promoShopMenuItem['title']. '</a>';

                                                if($i == 2) {  
                                                    echo '</div><div class="col-md-3">';
                                                    $i = 0;
                                                }
                                            }  
                                        ?> 
                                        </div> 
                                    </div>
                </div>

                <div class="padding main-branding-menu main-menus brandingmenu"  style="visibility:hidden" ng-mouseleave="hoverOut()"  ng-cloak>
                                    <div class="row">
                                        <div class="col-md-12"><h5> Branding Solutions <span class="pull-right">  A COMPLETE IN-HOUSE BRANDING PLATFORM </span> </h5></div>
                                    </div>
                                    <div class="row"> 
                                        <?php  
                                            $i = 0; 
                                            
                                            foreach($brandingMenu as $brandingMenuItem){
                                                $i++;
                                                if($brandingMenuItem['topMenu'] ==1 ){
                                                    echo '<div class="col-md-3">';
                                                    echo '<a class="dropdown-item" data-toggle="modal" data-target="#' .$brandingMenuItem['imgUrl']. 'Modal" href="#"> <img class="mr-3" src="'.base_url().'/Images/Branding/Icons/'.$brandingMenuItem['imgUrl'].'.jpg" alt=" " width="60" height="60" >' .$brandingMenuItem['title']. '</a>';
                                                    echo '</div>';
                                                } 
                                            }  
                                        ?>  
                                    
                                    </div>
                </div>    
                
                
                <?php if(count($customArray['themeArray'])==0  &&   $siteLogcheck['loggedIn'] == 1): ?>   

                                                <div class="padding main-toolbox-menu main-menus toolboxmenu"  style="visibility:hidden"  ng-mouseleave="hoverOut()"  ng-cloak>
                                                                <div class="row toolbar-transferOne">
                                                                    <div class="col-md-12"> <h5> Toolbox <span class="pull-right mobile-hide-menu"> DISTRIBUTOR TOOLS AND RESOURCES </span> </h5> </div> 
                                                                </div>
                                                                <div class="row toolbar-transferTwo">
                                                                    <div class="col-md-12 account-menus-user">
                                                                            
                                                                      
                                                                                    
                                                                                    <a class="dropdown-item col-md-3" href="/favourites"><img class="mr-3" src="<?=base_url()?>Images/ToolboxAccount/Favourite.jpg" alt="Favourite" width="60" height="60" > Favourites</a> 
                                                                                    <a class="dropdown-item col-md-3" data-toggle="modal" data-target="#dataImageModal"  href="#"><img class="mr-3" src="<?=base_url()?>Images/ToolboxAccount/Product-Data.jpg" alt="Image &amp; Downloads" width="60" height="60" >  Data &amp; Image Downloads</a> 
                                                                                    <a class="dropdown-item col-md-3" href="/Downloads-folder/TGP-TermsConditions.pdf" target="_blank"><img class="mr-3" src="<?=base_url()?>Images/ToolboxAccount/Terms-and-Condition.jpg" alt="Terms  &amp; Conditions" width="60" height="60" > Terms &amp; Conditions</a> 
                                                                                
                                                                                
                                                                                    
                                                                            
                                                                                    <a class="dropdown-item col-md-3" href="/catalogues"><img class="mr-3" src="<?=base_url()?>Images/ToolboxAccount/Digital-Catalogue.jpg" alt="Digital Catalogues" width="60" height="60" > Digital Catalogues</a> 
                                                                                    <a class="dropdown-item col-md-3" href="/api"><img class="mr-3" src="<?=base_url()?>Images/ToolboxAccount/Product-Data-API.jpg" alt="TRENDS Data API&apos;s" width="60" height="60" > TRENDS Data API&apos;s</a>  
                                                                                    <?php if($siteLogcheck['userDatas'][0]->skinnedWebsites == 1): ?> <a class="dropdown-item col-md-3" href="/customsite"><img class="mr-3" src="<?=base_url()?>Images/ToolboxAccount/Skinned-Website.jpg" alt="Skinned Website" width="60" height="60" > Skinned Website</a> <?php endif; ?>
                                                                                
                                                                            
                                                                                    <?php if($siteLogcheck['userDatas'][0]->customSiteUser == 1): ?> <a class="dropdown-item col-md-3" href="/skinneduser"><img class="mr-3" src="<?=base_url()?>Images/ToolboxAccount/Skinned-Site-User.jpg" alt="Skinned Site User" width="60" height="60" >  Skinned Site User</a> <?php endif; ?>
                                                                                    <a class="dropdown-item col-md-3" href="/category/200-2/all"><img class="mr-3" src="<?=base_url()?>Images/ToolboxAccount/Display-Stands.jpg" alt="Display Stands" width="60" height="60" > Display Stands</a> 
                                                                                    <a class="dropdown-item col-md-3" href="/downloads/Changes/1"><img class="mr-3" src="<?=base_url()?>Images/ToolboxAccount/Change-Log.jpg" alt="Product Change Log" width="60" height="60" > Product Change Log</a> 
                                                                            
                                                                    
                                                                                    
                                                                                    <?php if(count($customArray['themeArray'])==0  &&   $siteLogcheck['loggedIn'] == 1): ?>    <a class="dropdown-item col-md-3" data-toggle="modal" data-target="#visualRequestsModal" ng-click="initiateUserVisuals('<?=$siteLogcheck['userDatas'][0]->userID?>')"  href="#"><img class="mr-3" src="<?=base_url()?>Images/ToolboxAccount/Visualisation-Request.jpg" alt="Visualisation Request" width="60" height="60" > Visualisation Request</a> <?php endif; ?>
                                                                                    <?php if($siteLogcheck['userDatas'][0]->userType == 0 && $siteLogcheck['userDatas'][0]->CustomerNumber == '10105'): ?><a class="dropdown-item col-md-3" href="/usermaintenance"   ><img class="mr-3" src="<?=base_url()?>Images/ToolboxAccount/User-Maintenance.jpg" alt="User Maintenance" width="60" height="60" > User Maintenance</a> <?php endif; ?> 

                                                                                    <?php if($siteLogcheck['userDatas'][0]->userType == 0): ?><a class="dropdown-item col-md-3" href="#" data-toggle="modal" data-target="#mailingListModal" ng-click="mailingList()"><img class="mr-3" src="<?=base_url()?>Images/ToolboxAccount/Mailing-List.jpg" alt="Manage Mailing List" width="60" height="60" > Manage Mailing List</a> <?php endif; ?>
                                                                            
                                                                                    <?php if($siteLogcheck['userDatas'][0]->userType == 0  && $siteLogcheck['userDatas'][0]->CustomerNumber == '10105'): ?><a class="dropdown-item col-md-3" target="_blank" href="<?=base_url()?>TGP-Admin/home"><img class="mr-3" src="<?=base_url()?>Images/ToolboxAccount/CMS.jpg" alt="Content Management System" width="60" height="60" > <span style="font-size:12px">Content Management System </span></a> <?php endif; ?>
                                                                                    <!--<?php if($siteLogcheck['userDatas'][0]->OrderDashboardAccess == 1): ?><a class="dropdown-item col-md-3"  href="/dashboard"><img class="mr-3" src="<?=base_url()?>Images/ToolboxAccount/Product-Data.jpg" alt="Dashboard" width="60" height="60" > <span style="font-size:12px">Dashboard</span></a> <?php endif; ?>-->
                                                                                    <a class="dropdown-item col-md-3" href="/category/200-3/all"><img class="mr-3" src="<?=base_url()?>Images/ToolboxAccount/All.jpg" alt="Catalogues" width="60" height="60" >Catalogues</a>   
                                                                                    <a class="dropdown-item col-md-3" href="/category/200-4/all"><img class="mr-3" src="<?=base_url()?>Images/ToolboxAccount/Branded-Samples.jpg" alt="Catalogues" width="60" height="60" >Branded Samples</a>     
                                                                    </div>          
                                                                </div> 
                                                                 
                                                </div>    


                
                                                <div class="padding main-account-menu main-menus accountmenu new-account-box"  style="visibility:hidden"  ng-mouseleave="hoverOut()"  ng-cloak>
                                                     
                                                        <div class="row account-transferOne">
                                                            <div class="col-md-12"> <h5> &nbsp; <span class="accountfont"> <span class="userlogged">  <?=$siteLogcheck['userDatas'][0]->userEmail?> </span> <span class="usercompany"> - <?=$siteLogcheck['userDatas'][0]->CustomerName?> <?=$siteLogcheck['userDatas'][0]->Currency?></span> </span> </span> </h5> </div> 
                                                             
                                                        </div>
                                                          
                                                        <div class="row account-transferTwo">
                                                            <div class="col-md-12 account-menus-user-bottom">

                                                                            <?php if($secondaryAccounts = $siteLogcheck['secondaryAccounts']): ?>
                                                                                <h5 class="switchaccount-title">SWITCH ACCOUNT <?php //if($siteLogcheck['secondaryIDActive']): echo ' <small><span class="cursorpoint" ng-click="backtoPrimaryAccount('.$siteLogcheck['userDatas'][0]->userID.')"> [Back to primary account]</span></small>'; endif; ?> </h5> 
                                                                                
                                                                                
                                                                                <ul class="list-unstyled secondaryaccounts-list">
                                                                                    <?php if($siteLogcheck['secondaryIDActive']): ?>
                                                                                        <?php $primaryAccnt = $this->general_model->getTheMainAccount($secondaryAccounts);  ?>
                                                                                        <li  > <span  title="Primary Account" class="cursorpoint" ng-click="backtoPrimaryAccount(<?=$siteLogcheck['userDatas'][0]->userID?>)" > <i class="fa fa-circle"></i> <?=$primaryAccnt?>  </span> </li>
                                                                                     <?php  endif; ?>

                                                                                    <?php 
                                                                                       
                                                                                            foreach($secondaryAccounts as $secRows){ 
                                                                                                if( ($siteLogcheck['userDatas'][0]->CustomerNumber == $secRows->secondaryAccountID) && ($siteLogcheck['userDatas'][0]->Currency == $secRows->secondaryCurrency) ){
                                                                                                    echo '';
                                                                                                }else{
                                                                                                    echo '<li class="cursorpoint" ng-click="switchAccount('.$secRows->id.', '.$siteLogcheck['userDatas'][0]->userID.')"><span > <i class="fa fa-circle"></i> '  .$secRows->secondaryAccountName.' - '.$secRows->secondaryCurrency.'</span> </li>';
                                                                                                } 
                                                                                            }
                                                                                           
                                                                                    ?>
                                                                                    
                                                                                </ul>  
                                                                                <div class="underline-bottom margin-bottom-light">&nbsp;</div>
                                                                            <?php  endif; ?>

                                                                            <a class="dropdown-item col-md-8 account-new-bottom" href="#" data-toggle="modal" data-target="#resetUserPWModal"><!--<img class="mr-3" src="<?=base_url()?>Images/ToolboxAccount/Change-Password.jpg" alt="Change Password" width="60" height="60" >--> Change Password</a> 
                                                                      
                                                                           <a class="dropdown-item logoutuser   col-md-8  account-new-bottom" href="#" ng-click="logoutUser($event)"><!--<img class="mr-3" src="<?=base_url()?>Images/ToolboxAccount/Log-Out.jpg" alt="Logout" width="60" height="60" >--> Logout</a>
                                                            </div>          
                                                        </div> 
                                                     
                                                    
                                                </div> 
                <?php endif; ?>

                <!-- MAIN MENUS-->    
                
                               

                <nav class="navbar navbar-expand-lg navbar-light bg-light  header-top-menu <?php if(count($customArray['themeArray'])==0  &&   $siteLogcheck['loggedIn'] == 0): ?> loggedout-navtop <?php endif; ?> <?php if(count($customArray['themeArray'])==0  &&   $siteLogcheck['loggedIn'] == 1): ?> userloggedin-navtop <?php else: ?> normal-navtop <?php endif; ?> <?php if($customArray['themeArray'][0]->showPricing == 2 || $customArray['themeArray'][0]->showPricing == 1): ?> skinned_extendable <?php endif;?> <?php if($customArray['themeArray'][0]->showPricing == 0): ?> skinned_normal <?php endif;?> <?php if($skinnedUserCheck['skinnedLoggedIn'] == 1): ?> skinneduser_loggedin <?php endif; ?> "> 
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                                                                        <ul class="navbar-nav mr-auto <?php if(count($customArray['themeArray']) > 0 && $siteLogcheck['loggedIn'] == 0): ?> skinnedmenu  <?php if($customArray['themeArray'][0]->ContactUsActive == 0): ?> noContactActive<?php if($customArray['themeArray'][0]->showPricing == 0): ?>NoPricing<?php endif;?>   <?php endif;?> <?php endif;?>" >
                        
                            <li class="nav-item dropdown mobile-hide">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"    ng-mouseover="openMainMenuHover('productsmenu', menuClicked)" ng-mouseleave="stopMenu()"  >
                                    Products 
                                </a>
                                 
                            </li>

                            <li class="nav-item dropdown mobile-hide">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownColelctions" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-mouseleave="stopMenu()"   ng-mouseover="openMainMenuHover('collectionsmenu', menuClicked)">
                                    Collections 
                                </a>
                               
                            </li>

                            <li class="nav-item dropdown mobile-hide">
                                <a class="nav-link dropdown-toggle" href="/category/103-0<?=strtoupper($customArray['customID'])?>" id="navbarDropdownPremium" role="button"  ng-mouseleave="stopMenu()" ng-mouseover="openMainMenuHover('premiummenu', menuClicked)" >
                                    Brands
                                </a>
                                
                            </li>

                            <!--<li class="nav-item dropdown mobile-hide">
                                <a class="nav-link dropdown-toggle" href="/category/102-0<?=strtoupper($customArray['customID'])?>" id="navbarDropdownWorldSource" role="button"  ng-mouseleave="stopMenu()" ng-mouseover="openMainMenuHover('worldsourcemenu', menuClicked)" >
                                    World Source Express
                                </a>
                                
                            </li>-->

                            <li class="nav-item dropdown mobile-hide">
                                <a class="nav-link dropdown-toggle" href="/category/100-0<?=strtoupper($customArray['customID'])?>" id="navbarDropdownPromo" role="button" ng-mouseleave="stopMenu()"  ng-mouseover="openMainMenuHover('promoshopmenu', menuClicked)">
                                    Clearance
                                </a>
                                
                            </li>
                            
                            <li class="nav-item dropdown mobile-hide">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownBranding" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-mouseleave="stopMenu()" ng-mouseover="openMainMenuHover('brandingmenu', menuClicked)">
                                    Branding Solutions
                                </a> 
                                
                            </li>

                            <?php if(count($customArray['themeArray']) == 0  &&  $siteLogcheck['loggedIn'] == 1): ?> 
                                <li class="nav-item  dropdown mobile-active toolbox-list">
                                    <a class="nav-link  dropdown-toggle toolbox mobile-hide" href="#"  id="navbarDropdownToolbox" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  ng-mouseleave="stopMenu()" ng-mouseover="openMainMenuHover('toolboxmenu', menuClicked)" >
                                        Toolbox
                                    </a>
                                    <a class="nav-link  dropdown-toggle mobile-toolbox mobile-active hide-desktop" href="#"  id="navbarDropdownToolbox" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-mouseleave="stopMenu()" ng-mouseover="resetMenu()"  ng-click="openMainMenu('toolboxmenu', menuClicked)" >
                                        Toolbox 
                                    </a>
                                </li>       
                            <?php endif; ?>

                             <?php if(count($customArray['themeArray']) == 0  &&  $siteLogcheck['loggedIn'] == 1): ?> 
                                <li class="nav-item dropdown mobile-hide">
                                    <a class="nav-link tealcolour" href="/dashboard" id="navbarDashboard"  >
                                        Order Dashboard
                                    </a>  
                                </li>
                            <?php endif; ?>
                            

                            <?php if(count($customArray['themeArray']) > 0 || $siteLogcheck['loggedIn'] == 0): ?> 
                                <li class="nav-item mobile-hide">
                                    <a class="nav-link" href="/about<?=strtoupper($customArray['customID'])?>" >
                                        About Us
                                    </a>
                                </li> 
                                <?php if(count($customArray['themeArray']) > 0 && $customArray['themeArray'][0]->themeID > 0): ?> 

                                    <?php if($customArray['themeArray'][0]->ContactUsActive > 0): ?>                                                        
                                        <li class="nav-item mobile-hide">
                                                <a class="nav-link" href="/contact<?=strtoupper($customArray['customID'])?>" >
                                                    Contact Us
                                                </a>
                                        </li>  
                                    <?php endif; ?>    

                                    <?php if($customArray['themeArray'][0]->showPricing == 2): ?>
                                    <?php // print_r($skinnedUserCheck);   ?>
                                            <?php if($skinnedUserCheck['skinnedLoggedIn'] == 1): ?>    
                                                <li class="nav-item mobile-active skinned-last-link">
                                                    <a class="nav-link" href="#" ng-click="logoutSkinUser($event)"   >
                                                        <i class="fa fa-user-circle"></i> Logout
                                                    </a>
                                                </li>   
                                            <?php else: ?>   
                                                <li class="nav-item mobile-active skinned-last-link">
                                                    <a class="nav-link" href="#"  data-toggle="modal" data-target="#skinnedLoginModal"  >
                                                    <i class="fa fa-lock"></i> Login
                                                    </a>
                                                </li> 
                                            <?php endif; ?>  
                                    <?php endif; ?>   
                                <?php endif; ?>        

                            <?php endif; ?>                  
                            <?php if(count($customArray['themeArray'])==0): ?>                
                                <li class="nav-item dropdown mobile-active account-list last-menu">
                                            <?php 
                                                if($siteLogcheck['loggedIn'] == 1){
                                                    $addThisClass = ' dropdown-toggle ';
                                                    $addThisAttr = "ng-mouseleave=\"stopMenu()\" ng-mouseover=\"openMainMenuHover('accountmenu', menuClicked)\"  role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" ";
                                                    $addThisAttr2 = " ng-mouseover=\"resetMenu()\"  ng-click=\"openMainMenu('accountmenu', menuClicked)\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"  ";
                                                    $addThisIcon = ' Account ';
                                                }else{
                                                    $addThisClass = " ";
                                                    $addThisAttr = " data-toggle=\"modal\" data-target=\"#loginFormModal\" ";
                                                    $addThisIcon = '<i class="fa fa-lock"></i> Login ';
                                                    $addThisAttr2 = "  ";
                                                }

                                            ?>

                                            <a class="nav-link account-login  useraccount mobile-hide <?=$addThisClass?> " href="#" id="navbarDropdownAccount"   <?=$addThisAttr?>   >  <?=$addThisIcon?> </a> 
                                            <?php  if($siteLogcheck['loggedIn'] == 1): ?>
                                                <a class="nav-link account-login  useraccount mobile-active hide-desktop <?=$addThisClass?> " href="#" id="navbarDropdownAccount"    <?=$addThisAttr2?>  >  <?=$addThisIcon?> </a>
                                            <?php else: ?>
                                                <a class="nav-link account-login  useraccount mobile-active hide-desktop <?=$addThisClass?> " href="#" id="navbarDropdownAccount"    <?=$addThisAttr?>  >  <?=$addThisIcon?> </a>
                                            <?php endif; ?>


                                            
                                </li>
                            <?php endif; ?>                 
                        </ul>
                        
                    </div>
                </nav>



                 
                                
                                

            </div><!--end col-md-12-->
        </div><!--end row-->
    </div><!--end container-->


</div> <!-- mainmenu-->

<div class="mobile-account-transfer mobile-only"> </div>

<div class="combine_scroll main_logo_container menu_<?=$angularFile ?> " id="menu_<?=$angularFile ?>" ><!-- COMBINED SCROLL -->

    <!-- LOGO / SEARCH --> 
    <div class="container logo-container">

                        <?php 
                            $skinnedOrigLogo = 0;
                            $mobileLogoDIR = "";
                            $logoFullWidth = "";
                            $rowFullWidth = "";
                            if($this->general_model->mobileDetector() == 1){  
                                
                                $logoFullWidth = "mobile-logo-fullwidth";
                                $rowFullWidth = "row-fullwidth";
                                $mobileLogoDIR = "MobileLogos/";

                                $mobileLogoLocation1 = '/Images/TopMenu/customerLogos/'.$mobileLogoDIR.''.$customArray['themeArray'][0]->themeID.'.png'; 
                                $mobileLogoLocation2 = '/Images/TopMenu/customerLogos/'.$mobileLogoDIR.''.$customArray['themeArray'][0]->themeID.'.jpg'; 
                                $mobileLogoLocation3 = '/Images/TopMenu/customerLogos/'.$mobileLogoDIR.''.$customArray['themeArray'][0]->themeID.'.gif'; 

                                //If mobile logo exist then add the folder
                                if(file_exists($_SERVER['DOCUMENT_ROOT'].$mobileLogoLocation1) ||
                                    file_exists($_SERVER['DOCUMENT_ROOT'].$mobileLogoLocation2) ||
                                        file_exists($_SERVER['DOCUMENT_ROOT'].$mobileLogoLocation3) ){
                                        $mobileLogoDIR = "MobileLogos/";
                                }else{
                                        //else no mobile logo exist
                                        $mobileLogoDIR = "";
                                } 
                                 

                            } 

                        ?>
 
        <div class="row">
            <div class=" col-md-7 col-sm-6 logo-wrap  <?php if(count($customArray['themeArray']) > 0): ?>skinnedlogo<?php endif; ?> <?=$logoFullWidth?>">
                <?php if(count($customArray['themeArray'])==0): ?>          
                    <a href="<?=strtoupper($customArray['customHome'])?>"> <img src="<?=base_url()?>Images/logo.png" class="main-logo" title="Trends" /> </a>
                <?php else: ?>     
                        <?php 

                        $logoLocation = '/Images/TopMenu/customerLogos/'.$mobileLogoDIR.''.$customArray['themeArray'][0]->themeID.'.png'; 
                        if(file_exists($_SERVER['DOCUMENT_ROOT'].$logoLocation)): ?> 
                            <a href="<?=$customArray['customHome']?>"> <img src="<?=base_url()?>Images/TopMenu/customerLogos/<?=$mobileLogoDIR?><?=$customArray['themeArray'][0]->themeID?>.png"  /> </a> 
                        <?php else: ?>    
                            <?php 
                            $logoLocation2 = '/Images/TopMenu/customerLogos/'.$mobileLogoDIR.''.$customArray['themeArray'][0]->themeID.'.jpg'; 
                            $logoLocation3 = '/Images/TopMenu/customerLogos/'.$mobileLogoDIR.''.$customArray['themeArray'][0]->themeID.'.gif'; 
                            if(file_exists($_SERVER['DOCUMENT_ROOT'].$logoLocation2)){ ?>
                                 <a href="<?=$customArray['customHome']?>"> <img src="<?=base_url()?>Images/TopMenu/customerLogos/<?=$mobileLogoDIR?><?=$customArray['themeArray'][0]->themeID?>.jpg"   /> </a> 
                            <?php }elseif(file_exists($_SERVER['DOCUMENT_ROOT'].$logoLocation3)){  ?>
                                 <a href="<?=$customArray['customHome']?>"> <img src="<?=base_url()?>Images/TopMenu/customerLogos/<?=$mobileLogoDIR?><?=$customArray['themeArray'][0]->themeID?>.gif"   /> </a>   
                            <?php }else{ $skinnedOrigLogo = 1; ?>
                                <a href="<?=$customArray['customHome']?>"> <img src="<?=base_url()?>Images/logo.png" class="main-logo" title="Trends"   /> </a>
                            <?php }  ?>    
                        <?php endif; ?>
                <?php endif; ?>   
            </div>
            <div class="col-md-5 col-sm-6   mobile-menu-transfer <?php if(count($customArray['themeArray']) > 0): ?>skinnedsearchbox<?php endif; ?> <?=$rowFullWidth?>"  >

                <div class="row headerSearch <?php if($skinnedOrigLogo == 1): ?> skinnedoriglogo <?endif; ?>" ng-cloak  >                        
                    <div  class=" col-md-9 topbar col-sm-11 " ng-click="triggerSearch()"   >

                        <?php $this->load->view('module/search'); ?> 	
                        
                    </div> 
                    <div class="col-md-2 col-sm-1">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"  ng-click="toggleSearchForm()" >
                                &nbsp;
                            </button>
                        
                        </div>               
                    </div>
                                                
                    <?php  $this->load->view('module/searchPopup'); ?>                 

                </div>    


               

            </div>
        </div>
    </div>    
    <!-- LOGO / SEARCH -->


    <!-- FOr mobile menu only-->                                                     
     <div class="mobile-dropdown-transfer">

                        <!-- New account menu element-->
                        <?php if(count($customArray['themeArray'])==0): ?>  
                            <?php  if($siteLogcheck['loggedIn'] == 1): ?> 
                                <div class="collapse navbar-collapse navbar-account-mobile" id="navbarSupportedAccountToolbarMenu">
                                    <h5 class="mobile-only"> Account </h5>
                                    <div class="toolbox-account-wrapper   padding"> </div> 
                                </div>
                            <?php endif; ?>       
                        <?php endif; ?> 
                        <!-- New account menu element-->  
     </div>
     <!-- for mobile menu only-->

    <!-- CATEGORIES -->
    <div class="categories_menu " >

        <div class="container">
            <div class="row">
                <div class="col-md-12 " id="mobile_popup_search">


 


                    <nav class="header-categories-menu navbar navbar-expand-lg navbar-light bg-light " id="categories_mobile_menu" ng-mouseover="hideSearchPopup()"> 
                        <a class="navbar-brand  hide-desktop" href="#">&nbsp;</a>
                       <!-- New account menu button -->
                        <?php if(count($customArray['themeArray'])==0): ?>    
                                <?php  if($siteLogcheck['loggedIn'] == 1): ?> 
                                    <span ng-cloak class="mobilenew-login cursorpoint" id="navbarDropdownAccount" ng-click="closeTheCollapse('navbarSupportedContentMenu')" data-toggle="collapse" data-target="#navbarSupportedAccountToolbarMenu" aria-controls="navbarSupportedAccountToolbarMenu" aria-expanded="false" aria-label="Toggle navigation" ><i class="fa fa-user-circle"></i>  </span> 
                                <?php else: ?> 
                                    <span ng-cloak class="mobilenew-login cursorpoint" data-toggle="modal" data-target="#loginFormModal"><i class="fa fa-lock"></i> </span> 
                                <?php endif; ?>
                              
                        <?php endif; ?> 

                        <!--Skinned sites login mobile-->
                        <?php if(count($customArray['themeArray']) > 0 || $siteLogcheck['loggedIn'] == 0): ?> 
                                
                                    <?php if($customArray['themeArray'][0]->showPricing == 2): ?>
                                    <?php // print_r($skinnedUserCheck);   ?>
                                            <?php if($skinnedUserCheck['skinnedLoggedIn'] == 1): ?>    
                                                <span ng-cloak class="mobilenew-login cursorpoint themeskinned-menu-mobile"  ng-click="logoutSkinUser($event)"   >
                                                        <i class="fa fa-user-circle"></i> 
                                            </span>   
                                            <?php else: ?>    
                                                <span ng-cloak class="mobilenew-login cursorpoint themeskinned-menu-mobile"   data-toggle="modal" data-target="#skinnedLoginModal"  >
                                                    <i class="fa fa-lock"></i> 
                                                </span> 
                                            <?php endif; ?>  
                                    <?php endif; ?>   
                        <?php endif; ?>   
                        <!--Skinned sites login mobile--> 
                         <!-- New account menu button -->   

                        <button class="navbar-toggler pull-right" ng-cloak type="button" ng-click="closeTheCollapse('navbarSupportedAccountToolbarMenu')"  data-toggle="collapse" data-target="#navbarSupportedContentMenu" aria-controls="navbarSupportedContentMenu" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fa  fa-bars"></i>
                        </button>
                         

                        <div class="collapse navbar-collapse" id="navbarSupportedContentMenu">
                            <h5 class="mobile-only">Product Categories</h5>
                            <ul class="navbar-nav mr-auto">

                                <!--<li class="nav-item new-item">
                                    <a class="nav-link" href="/category/products<?=strtoupper($customArray['customID'])?>">All</a>
                                     
                                </li>-->
                                
                               <li class="nav-item  dropdown">
                                    <a class="nav-link dropdown-toggle mobile-toggle" id="navbarDropdown" href="/category/0-0<?=strtoupper($customArray['customID'])?>" role="button"   aria-haspopup="true" aria-expanded="false" >New</a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">  
                                                
                                        <a class="dropdown-item mobile-only"      href="/category/0-0<?=strtoupper($customArray['customID'])?>"    > All New</a> 
                                        <a class="dropdown-item"  href='/category/0-4/all<?=strtoupper($customArray['customID'])?>'>Apparel</a>
                                        <a class="dropdown-item" href='/category/0-10/all<?=strtoupper($customArray['customID'])?>'>Bags</a>
                                        <a class="dropdown-item" href='/category/0-7/all<?=strtoupper($customArray['customID'])?>'>Business</a>
                                        <a class="dropdown-item" href='/category/0-2/all<?=strtoupper($customArray['customID'])?>'>Drinkware</a> 
                                        <a class="dropdown-item" href='/category/0-3/all<?=strtoupper($customArray['customID'])?>'>Headwear</a>
                                        <a class="dropdown-item" href='/category/0-5/all<?=strtoupper($customArray['customID'])?>'>Key Rings</a>
                                        <a class="dropdown-item" href='/category/0-13/all<?=strtoupper($customArray['customID'])?>'>Leisure</a> 
                                        <a class="dropdown-item" href='/category/0-1/all<?=strtoupper($customArray['customID'])?>'>Pens</a>
                                        <a class="dropdown-item" href='/category/0-11/all<?=strtoupper($customArray['customID'])?>'>Personal</a>
                                        <a class="dropdown-item" href='/category/0-6/all<?=strtoupper($customArray['customID'])?>'>Print</a>
                                        <a class="dropdown-item" href='/category/0-8/all<?=strtoupper($customArray['customID'])?>'>Promotion</a>
                                        <a class="dropdown-item" href='/category/0-9/all<?=strtoupper($customArray['customID'])?>'>Technology</a>
                                        <a class="dropdown-item" href='/category/0-12/all<?=strtoupper($customArray['customID'])?>'>Tools</a> 
                                    </div> 
                                </li>  

                                <?php   
                                                $countGetCatSubMenu = count($getCatSubMenu);
                                                for($x = 0; $x <= $countGetCatSubMenu; $x++){
                                                    
                                                    foreach($getCatSubMenu[$x] as $key=> $value){
                                                        echo ' <li class="nav-item dropdown"> <a class="nav-link  dropdown-toggle mobile-toggle"      id="navbarDropdown" href="/category/'.$value['urlLink'].''.strtoupper($customArray['customID']).'" role="button"   aria-haspopup="true" aria-expanded="false" >' .$key.  '</a>';

                                                        
                                                        
                                                        $countSubMenus = count($value['subMenus']);
                                                        if($countSubMenus > 0){
                                                            echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';

                                                            echo '  <a class="dropdown-item mobile-only"      href="/category/'.$value['urlLink'].''.strtoupper($customArray['customID']).'"    > All ' .$key.  '</a>';

                                                            for($i = 0; $i <= $countSubMenus; $i++){ 
                                                                if(substr($value['subMenus'][$i]->CategoryNum, -2) != "-0") 
                                                                {
                                                                    /*if($value['subMenus'][$i]->CategoryNum == 13) { 		   
                                                                        $CatName = substr($value['subMenus'][$i]->CategoryName,6);   
                                                                        echo '<a class="dropdown-item" href="/category/'.$value['subMenus'][$i]->CategoryNum.'/all'.strtoupper($customArray['customID']).'">'.$CatName.'</a>'; 
                                                                    }else{*/
                                                                        if($value['subMenus'][$i]->CategoryNum){
                                                                            echo '<a class="dropdown-item" href="/category/'.$value['subMenus'][$i]->CategoryNum.'/all'.strtoupper($customArray['customID']).'">'.$value['subMenus'][$i]->CategoryName.'</a>'; 
                                                                        }
                                                                        
                                                                    //}
                                                                    
                                                                } 
                                                            }
                                                            echo ' </div>';
                                                        } 
                                                        
                                                        echo '</li>'; 
                                                    }
                                                }   
                                ?>  
                            
                                
                            </ul>
                            
                        </div>
                    </nav>


                </div>
            </div>
        </div>  

    </div>
    <!-- CATEGORIES -->
    <span   id="topBtn" data-toggle="tooltip" data-placement="right"    title="Back to top"> <i class="fa fa-arrow-up"></i> </span>
</div>  <!-- COMBINED SCROLL -->
 

 


 