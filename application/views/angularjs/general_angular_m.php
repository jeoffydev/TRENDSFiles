<?php  
    /* General check for user's properties here */


    if($siteLogcheck['loggedIn'] == 1 && count($customArray['themeArray'])==0): 
        /* $visualProductVisualLists = $this->general_model->getProductsVisualList(); 

        $json_data=array();
        foreach($visualProductVisualLists as $rec)//foreach loop  
        {   
            $json_array['Name']= html_entity_decode($rec->Name, ENT_QUOTES); 
            array_push($json_data,$json_array);
        } 
        $myVisualProducts = json_encode($json_data,JSON_PRETTY_PRINT); 
        $scope.productVisuals = <?php echo $myVisualProducts; ?>;
        
        */
        
     
    endif;
    /* General check for user's properties here */

    /* echo "<pre>";
    print_r($searchResults);
    echo "</pre>"; */
   
?>

<script> 
/* JQUERY */
$(function () {

        /* Stock quick view and item toggle */
        $(document).on('click', 'div.parentStock', function () { 
                $(this).children("div").toggle();
        });
        
        /* Carousel swipe */
        $('.carousel').bcSwipe({ threshold: 50 });

        /* Tooltip */
        $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" }); 

        $("body").tooltip({
            selector: '[data-toggle="tooltip"]'
        });

        
        $('.mobile-item-accordion h5 .btn a').removeAttr('data-toggle');

        /* Delay added on Categories menu or bottom menu */
        $('.header-categories-menu ul.navbar-nav li.dropdown').hover(function() {
              $(this).find('.dropdown-menu').stop(true, true).delay(300).fadeIn();
             
        }, function() {
             
              $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut();
        });
        /* Delay added on Categories menu or bottom menu */
        
        /******** Search form disallow special characters *****/
        $('#searchInputID').keypress(function(e) {
             //console.log(e.shiftKey);
            // console.log(e.which);
            
            if (e.which == 33 || e.which == 64 || e.which == 35 || e.which == 36 || e.which == 37 || e.which == 94 || e.which == 38 
            || e.which == 42 || e.which == 40 || e.which == 41 ||  e.which == 95 || e.which == 92 || e.which == 63 || e.which == 58
             || e.which == 59 || e.which == 34 || e.which == 39 || e.which == 43  || e.which == 61  || e.which == 123  || e.which == 125
             || e.which == 91  || e.which == 93  || e.which == 124) {
                e.preventDefault();
                return;
            }
        });
        /******** Search form disallow special characters *****/

         /*  Mobile detector and events */
        <?php  if($this->general_model->mobileDetector() == 1): ?>  

            var sizeLimit = 980;
            
            //Only for item page
            <?php if($angularFile == 'item'): ?> 
                   // onFocusHandling();
                  /*  $(window).resize(function () {
                        onFocusHandling();
                    }); 
                    function onFocusHandling() { 
                        if (checkWidth()) {
                                window.location.reload(); 
                            return;
                        } else {
                                window.location.reload();     
                            return;
                        }
                    }
                    function checkWidth() {
                        return ($(window).width() < sizeLimit);
                    }  */
            <?php endif; ?>    
            //Only for item page

            if ($(window).width() <= sizeLimit) {  

                 

                $("#categories_mobile_menu").appendTo(".mobile-menu-transfer"); 
                $("#navbarSupportedContentMenu").appendTo(".mobile-dropdown-transfer");
                $(".headerSearch").appendTo("#mobile_popup_search"); 
                $('.combine_scroll').removeClass('menu_category'); 
                $(".mobile-dropdown-transfer li.nav-item > a").attr("data-toggle","dropdown");
                $(".new-item .nav-link").removeAttr("data-toggle");
                //New menu
                $(".toolbar-transferOne").appendTo(".toolbox-account-wrapper"); 
                $(".toolbar-transferTwo").appendTo(".toolbox-account-wrapper"); 
                $(".account-transferOne").appendTo(".toolbox-account-wrapper"); 
                $(".account-transferTwo").appendTo(".toolbox-account-wrapper"); 
                $('.account-transferThree').appendTo(".toolbox-account-wrapper"); 
                $('.itemcodeTransfer').appendTo(".mobile-code"); 

                $('.TGPContentTabs .nav-link').removeClass('active'); 
                $('#details').removeClass('show active'); 
                
            } 

             $(".collapse").on('show.bs.collapse', function() {
                $(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
            }).on('hide.bs.collapse', function() {
                $(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
            }); 
            
            
             /* if ($(window).width() <= 812 ) {    
                $(".details-mobile").appendTo(".details-list"); 
                $(".stock-mobile").appendTo(".stock-list"); 
                $('.pricingnzd-mobile').appendTo(".nzdclass"); 
                $('.pricingaud-mobile').appendTo(".audclass"); 
                $('.changes-mobile').appendTo(".changes-list"); 

                 $( ".TGPContentTabs .nav-link" ).click(function() {
                    $('.TGPContentTabs .mobile-active .tab-pane').removeClass('active show');  
                });  

                 
            }
            
            if ($(window).width() <= 580 ) {    
                $(".details-mobile").appendTo(".details-list"); 
                $(".stock-mobile").appendTo(".stock-list"); 
                $('.pricingnzd-mobile').appendTo(".nzdclass"); 
                $('.pricingaud-mobile').appendTo(".audclass"); 
                $('.changes-mobile').appendTo(".changes-list"); 

                $( ".TGPContentTabs .nav-link" ).click(function() {
                    $('.TGPContentTabs .mobile-active .tab-pane').removeClass('active show'); 
                });
            } */
            
            
        <?php endif; ?> 
            
        //Select 2 control for dropdowns
        $("#searchcatpopup, #searchbrandpopup, #searchcolourpopup, #searchsortpopup, #searchbrandform, #searchcolourform, #searchsortform").select2(); 
        $( ".nav-item " ).hover(function() { 
            $("#searchcatpopup, #searchbrandpopup, #searchcolourpopup, #searchsortpopup, #searchbrandform, #searchcolourform, #searchsortform").select2("close"); 
        });
});

 
/* END JQUERY */



//tgpApp.controller("generalCtrl",function($scope, $http, Upload, $timeout, $window){
tgpApp.controller("generalCtrl",  ['$scope', '$http',  'Upload', '$timeout', '$window', '$sce', '$compile',   function($scope,  $http, Upload, $timeout, $window, $sce, $compile){    

 
     $scope.userName = '';
     $scope.userPassword = '';
     $scope.userBox= true;
     $scope.passWord = false;
     $scope.errorMessage = 'Username does not exist';
     $scope.errorPwMessage = 'Error: Password does not match or on hold account';
     $scope.errorUser = false;
     $scope.errorPw = false;
     $scope.goodUser = false;
     $scope.correct = false;
     $scope.skinnedFormData = {};
     $scope.skinnedLoginBtn = true;
     $scope.skinnedFormData.themeID = null;
     $scope.skinnedFormData.customerNumber = null;
     $scope.errorSkinnedLoginMessage = false;
     $scope.skinnedLoginFormTitle = 'Login';
     $scope.errorSkinnedForgotMessage = false;
     $scope.successSkinnedForgotMessage = false; 
     $scope.visualFormData = {};
     $scope.visualUpdateBtn = false;
     $scope.itemVisualiseActive = true;
     $scope.countItemLimit = 10;
     $scope.done = false; 
     $scope.resetUserPWForm = {};
     $scope.resetMainUserPWForm = {};
     $scope.updateUserPWBtn = true; 
     $scope.updateUserPW1 = true; 
     $scope.updateUserPW2 = true; 
     $scope.iframeMail = false;
     $scope.PreviewTableResult ='';
     $scope.details = false;
     $scope.detailsPMS = false;
     $scope.viewImg = false;
     $scope.codeImg = false;
     $scope.imgx = null;
     $scope.images = false;
     $scope.location =  '<?=base_url();?>';
     $scope.customIDURL = '<?=strtoupper($customArray['customID'])?>';
     $scope.openTabs = false;
     $scope.visualFormData.projectName = null;
     $scope.visualFormData.instructions = null;  
     $scope.hitPromoAPITable = null;
     $scope.errorEmailForgot = false;  
     $scope.IEBrowser = false;
     $scope.requests = {};
     $scope.visualSubmitted = false;  

    $scope.checkUserName=function(o){$http({method:"post",url:"<?php echo base_url();?>Angular/AngularPost",data:{option:2,username:o}}).then(function(e){"1"==e.data?($scope.errorUser=!1,$scope.userName=o,$timeout(function(){$scope.passWord=!0,$scope.userBox=!1},800)):($scope.errorUser=!0,$scope.errorUser=$scope.errorMessage)},function(o){console.log("Error username query")})},$scope.checkpw=function(o){$http({method:"post",url:"<?php echo base_url();?>Angular/AngularPost",data:{option:3,userN:$scope.userName,passW:o}}).then(function(o){"1"==o.data&&($scope.passWord=!1,$scope.userBox=!1,$scope.correct=!0,$timeout(function(){$window.location.reload()},600)),"0"==o.data&&($scope.errorPw=!0,$scope.errorPw=$scope.errorPwMessage)},function(o){console.log("Error pw query")})},$scope.logoutUser=function(o){o.preventDefault(),$http({method:"post",url:"<?php echo base_url();?>Angular/AngularPost",data:{option:4}}).then(function(o){"1"==o.data&&$timeout(function(){$window.location.reload()},600)},function(o){console.log("Error pw query")})};
    $scope.forgotPwMainUser = function(userNameEmail){
        //console.log(userNameEmail); 
        <?php if($siteLogcheck['loggedIn'] == 0  && count($customArray['themeArray'])==0): ?> 

            userNameEmail&&$http({method:"post",url:"<?php echo base_url();?>Angular/AngularPost",data:{option:19,userNameEmail:userNameEmail}}).then(function(o){console.log(o.data),$scope.errorEmailForgot=!0,0==o.data&&($scope.errorEmailForgotMsg="Sorry, we could not find that email address."),1==o.data&&($scope.userMainEmail="",$scope.errorEmailForgotMsg="<i class='fa fa-check' aria-hidden='true'></i> Password reset link was sent to your email.",$timeout(function(){$scope.errorEmailForgotMsg=""},1600))},function(o){console.log("Error forgot main user email")});

        <?php endif; ?>    
    }
    $scope.download=function(o){$http({method:"post",url:"<?php echo base_url();?>Angular/AngularPost",data:{option:5,opts:o}}).then(function(o){console.log(o.data)},function(o){console.log("Error download query")})};
    $scope.loginSkinnedUser = function(){  
        <?php if(count($customArray['themeArray']) > 0): ?>
            $scope.skinnedFormData.themeID = <?=$customArray['themeArray'][0]->themeID?>;
            $scope.skinnedFormData.customerNumber = <?=$customArray['themeArray'][0]->CustomerNumber?>;
        <?php endif; ?>
        $scope.skinnedFormData.option=6,$http({method:"post",url:"<?php echo base_url();?>Angular/AngularPost",data:$scope.skinnedFormData}).then(function(o){1==o.data&&($scope.errorSkinnedLoginMessage=!1,$scope.correct=!0,$timeout(function(){$window.location.reload()},600)),0==o.data&&($scope.errorSkinnedLoginMessage=!0,$scope.errorSkinnedLoginMessage="Username or Password does not match")},function(o){console.log("Error skinned login query")});
        
    }
    $scope.checkSkinnedLogin=function(n,o){$scope.skinnedLoginBtn=""===n||""===o},$scope.logoutSkinUser=function(n){n.preventDefault(),$http({method:"post",url:"<?php echo base_url();?>Angular/AngularPost",data:{option:7}}).then(function(n){"1"==n.data&&$timeout(function(){$window.location.reload()},600)},function(n){console.log("Error pw query")})},$scope.skinnedLoginTitle=function(n){$scope.skinnedLoginFormTitle=n};
    $scope.forgotPwSkinnedUser = function(userNameEmail){
        //console.log(userNameEmail); 
        <?php if(count($customArray['themeArray']) > 0): ?>
            $scope.themeID = <?=$customArray['themeArray'][0]->themeID?>;
            $scope.customerNumber = <?=$customArray['themeArray'][0]->CustomerNumber?>;
        <?php endif; ?>
        userNameEmail&&$http({method:"post",url:"<?php echo base_url();?>Angular/AngularPost",data:{option:8,userNameEmail:userNameEmail,themeID:$scope.themeID,customerNumber:$scope.customerNumber}}).then(function(e){console.log(e.data),0==e.data&&($scope.successSkinnedForgotMessage=!1,$scope.errorSkinnedForgotMessage=!0,$scope.errorSkinnedForgotMessage="Sorry, we could not find that email address."),1==e.data&&($scope.errorSkinnedForgotMessage=!1,$scope.successSkinnedForgotMessage=!0,$scope.successSkinnedForgotMessage="Password reset link was sent to your email.")},function(e){console.log("Error forgot pw")});
    } 
    /* Visuals Request */ 
    $scope.itemRequestVisuals=function(e,t){$scope.initiateUserVisuals(e),$scope.getProductColours(t),$scope.visualFormData.productItem=t},$scope.initiateUserVisuals=function(e){$scope.loadingEffects=!0,$scope.visualUpdateBtn=!1,$scope.visualFormData.projectName=null,$scope.visualFormData.instructions=null,$http({method:"post",url:"<?php echo base_url();?>Angular/AngularPost",data:{option:9,userID:e}}).then(function(t){$scope.loadingEffects=!1,$scope.userVisualFiles=null,$scope.userVisualRequests=null,$scope.userID=e,$scope.countItem=0,0!==t.data.visualRequests&&($scope.countItem=$scope.objectLength(t.data.visualRequests),$scope.countItem>=$scope.countItemLimit&&($scope.itemVisualiseActive=!1),$scope.userVisualRequests=t.data.visualRequests,$scope.visualFormData.projectName=t.data.visualRequests[0].projectName,$scope.visualFormData.instructions=t.data.visualRequests[0].instructions,$scope.visualUpdateBtn=!0),0!==t.data.visualFiles&&($scope.userVisualFiles=t.data.visualFiles),$scope.userVisualItems=t.data.visualProductVisualLists},function(e){console.log("Error visual query")})},$scope.getProductColoursVisual=function(e,t,a){angular.element(".alertitemcolour").css("display","none"),angular.element(".alertbrandingcolour").css("display","none"),angular.element(".itemcolour_"+a).css("display","block"),$http({method:"post",url:"<?php echo base_url();?>Angular/AngularPost",data:{option:12,itemCode:e}}).then(function(e){if(e.data.length>0){$scope.availableColoursR=e.data[0].Colours.split(",");for(var a=$scope.availableColoursR.length-1,o=0;o<=a;o++)$scope.findVal=$scope.availableColoursR[o].replace(/^\s/g,""),$scope.findVal==t&&($scope.itemColsRight=$scope.availableColoursR[o]);$scope.availableColoursR&&($scope.availableColoursVisual=$scope.availableColoursR)}},function(e){console.log("Error visual query")})},$scope.updateThisItemVisual=function(e,t,a){$scope.updateThisItem(e,t,a),$scope.availableColoursVisual=!1,angular.element("#itemCols_"+e).val(a),angular.element(".alertitemcolour").css("display","none")},$scope.getProductColoursBranding=function(e,t,a){angular.element(".alertbrandingcolour").css("display","none"),angular.element(".alertitemcolour").css("display","none"),angular.element(".brandingcolour_"+a).css("display","block"),$http({method:"post",url:"<?php echo base_url();?>Angular/AngularPost",data:{option:12,itemCode:e}}).then(function(e){if(e.data.length>0){var t=e.data[0].PrintType1,a=e.data[0].PrintType2,o=e.data[0].PrintType3,s=e.data[0].PrintType4,n=e.data[0].PrintType5,i=e.data[0].PrintType6,l=e.data[0].PrintType7,r=e.data[0].PrintType8,u=e.data[0].PrintType9,p=e.data[0].PrintType10,c={0:{pt:t,pd:e.data[0].PrintDescription1},1:{pt:a,pd:e.data[0].PrintDescription2},2:{pt:o,pd:e.data[0].PrintDescription3},3:{pt:s,pd:e.data[0].PrintDescription4},4:{pt:n,pd:e.data[0].PrintDescription5},5:{pt:i,pd:e.data[0].PrintDescription6},6:{pt:l,pd:e.data[0].PrintDescription7},7:{pt:r,pd:e.data[0].PrintDescription8},8:{pt:u,pd:e.data[0].PrintDescription9},9:{pt:p,pd:e.data[0].PrintDescription10}},d=[];Object.keys(c).forEach(function(e){c[e].pt&&(newArray=c[e].pt+": "+$scope.cleanString2(c[e].pd),d.push(newArray))}),$scope.availableBrandingOptionVisuals=d}},function(e){console.log("Error visual query")})},$scope.updateThisItemBranding=function(e,t,a){$scope.updateThisItem(e,t,a),$scope.availableBrandingOptionVisuals=!1,angular.element("#printOpt_"+e).val(a),angular.element(".alertbrandingcolour").css("display","none")},$scope.closeVisualDropdownOption=function(){angular.element(".alertbrandingcolour").css("display","none"),angular.element(".alertitemcolour").css("display","none")},$scope.getProductColours=function(e){$http({method:"post",url:"<?php echo base_url();?>Angular/AngularPost",data:{option:12,itemCode:e}}).then(function(e){if(e.data.length>0){$scope.availableColours=e.data[0].Colours.split(","),$scope.availableColours&&($scope.visualFormData.ItemColour=$scope.availableColours[0]);var t=e.data[0].PrintType1,a=e.data[0].PrintType2,o=e.data[0].PrintType3,s=e.data[0].PrintType4,n=e.data[0].PrintType5,i=e.data[0].PrintType6,l=e.data[0].PrintType7,r=e.data[0].PrintType8,u=e.data[0].PrintType9,p=e.data[0].PrintType10,c={0:{pt:t,pd:e.data[0].PrintDescription1},1:{pt:a,pd:e.data[0].PrintDescription2},2:{pt:o,pd:e.data[0].PrintDescription3},3:{pt:s,pd:e.data[0].PrintDescription4},4:{pt:n,pd:e.data[0].PrintDescription5},5:{pt:i,pd:e.data[0].PrintDescription6},6:{pt:l,pd:e.data[0].PrintDescription7},7:{pt:r,pd:e.data[0].PrintDescription8},8:{pt:u,pd:e.data[0].PrintDescription9},9:{pt:p,pd:e.data[0].PrintDescription10}},d=[];Object.keys(c).forEach(function(e){c[e].pt&&(newArray=c[e].pt+": "+$scope.cleanString2(c[e].pd),d.push(newArray))}),$scope.availableBrandingOption=d,$scope.availableBrandingOption&&($scope.visualFormData.BrandingOption=d[0])}else $scope.availableColours=!1,$scope.availableBrandingOption=!1},function(e){console.log("Error visual query")})},$scope.objectLength=function(e){var t=0;for(var a in e)e.hasOwnProperty(a)&&t++;return t},$scope.addVisualItem=function(e){e&&($scope.visualFormData.userID=e,$scope.visualFormData.option=13,$scope.visualFormData.ItemInstructions||($scope.visualFormData.ItemInstructions=null),$http({method:"post",url:"<?php echo base_url();?>Angular/AngularPost",data:$scope.visualFormData}).then(function(t){$scope.visualFormData={},$scope.initiateUserVisuals(e),$scope.done=!0,$scope.availableColours=!1,$scope.availableBrandingOption=!1,$timeout(function(){$scope.done=!1},2e3)},function(e){console.log("Error  visual insert query")}))},$scope.deleteArtwork=function(e,t,a){confirm("Are you sure you want to delete this image?")&&$http({method:"post",url:"<?php echo base_url();?>Angular/AngularPost",data:{option:10,userID:e,visualFiles:t}}).then(function(e){1==e.data.deleted&&(0==e.data.countFiles&&($scope.userVisualFiles=null),angular.element("#artworkFile_"+a).css("background-color","#c82333"),$timeout(function(){angular.element("#artworkFile_"+a).css("display","none")},1e3))},function(e){console.log("Error delete files visual query")})},$scope.deleteItems=function(e,t){confirm("Are you sure you want to delete this item?")&&$http({method:"post",url:"<?php echo base_url();?>Angular/AngularPost",data:{option:14,uid:e}}).then(function(e){($scope.countItem=$scope.countItem-1,$scope.countItem>=$scope.countItemLimit?$scope.itemVisualiseActive=!1:$scope.itemVisualiseActive=!0,1==e.data)&&(angular.element("#visualItems_"+t).css("background-color","#c82333"),$timeout(function(){angular.element("#visualItems_"+t).css("display","none")},1e3))},function(e){console.log("Error delete files visual query")})},$scope.updateProjectDetails=function(e,t){$http({method:"post",url:"<?php echo base_url();?>Angular/AngularPost",data:{option:11,projectName:e,instructions:t,userID:$scope.userID}}).then(function(e){1==e.data&&(angular.element(".projectInputs").css("border","2px solid  #28a745"),$timeout(function(){angular.element(".projectInputs").css("border","1px solid #ced4da")},2e3))},function(e){console.log("Error delete files visual query")})},$scope.uploadArtwork=function(e,t,a,o){o&&(o.upload=Upload.upload({url:"<?php echo base_url();?>Angular/AngularPost",data:{option:12,userID:a,file:o}}),o.upload.then(function(o){1==o.data&&($scope.initiateUserVisuals(a),$scope.visualFormData.projectName=e,$scope.visualFormData.instructions=t,$scope.done=!0,$timeout(function(){$scope.done=!1},2e3))},function(e){e.status>0&&($scope.errorMsg=e.status+": "+e.data)}))},$scope.updateThisItem=function(e,t,a){$http({method:"post",url:"<?php echo base_url();?>Angular/AngularPost",data:{option:15,uid:e,cols:t,details:a}}).then(function(a){(console.log(a.data),1==a.data)&&(angular.element("."+t+e).css("display","inline-block"),$timeout(function(){angular.element("."+t+e).css("display","none")},2e3))},function(e){console.log("Error delete files visual query")})},$scope.sendToEmail=function(e){confirm("This will send to Trends Visualisation Request. Click OK to continue.")&&$http({method:"post",url:"<?php echo base_url();?>Angular/AngularPost",data:{option:16,userID:e}}).then(function(t){1==t.data&&($scope.initiateUserVisuals(e),$scope.done=!0,$timeout(function(){$scope.done=!1,$scope.visualSubmitted=!0},2e3))},function(e){console.log("Error userID email visual query")})},$scope.hideVisualSuccess=function(){$scope.visualSubmitted=!1};

    $scope.checkOldPW = function(oldpw){
        if(oldpw){
            $scope.resetUserPWForm['userID'] = '<?=$siteLogcheck['userDatas'][0]->userID?>';
            $scope.resetUserPWForm['seaSalt'] = '<?=$siteLogcheck['userDatas'][0]->userSalt?>';
            $scope.resetUserPWForm['userEmail'] = '<?=$siteLogcheck['userDatas'][0]->userEmail?>';
            $scope.resetUserPWForm.oldpw = oldpw;
            $scope.resetUserPWForm.option = 17;

            $http({method:"post",url:"<?php echo base_url();?>Angular/AngularPost",data:$scope.resetUserPWForm}).then(function(e){1==e.data&&($scope.oldPWMsg='<i class="fa fa-check  check"></i> ',$scope.updateUserPW1=!1,$scope.updateUserPW2=!1),2==e.data&&($scope.oldPWMsg="old passwords didnt match",$scope.updateUserPW1=!0,$scope.updateUserPW2=!0),0==e.data&&(alert("Please contact Web Admin to reset your password"),$scope.updateUserPW1=!0,$scope.updateUserPW2=!0)},function(e){console.log("Error old password query")});  
        }
        //console.log($scope.resetUserPWForm);
           
    }
    $scope.checkNewPW=function(e,o){e!==o?($scope.userResetPWMsg="Password doesn't match",$scope.updateUserPWBtn=!0):($scope.userResetPWMsg=!1,$scope.updateUserPWBtn=!1)},$scope.resetUserPW=function(e){$scope.resetUserPWForm.option=18,$http({method:"post",url:"<?php echo base_url();?>Angular/AngularPost",data:$scope.resetUserPWForm}).then(function(e){console.log(e.data),1==e.data&&($scope.correct=!0,$timeout(function(){$window.location.reload()},600))},function(e){console.log("Error update user password query")})},$scope.resetMainUserPW=function(e){$scope.resetMainUserPWForm.option=20,$scope.resetMainUserPWForm.userID=e,$http({method:"post",url:"<?php echo base_url();?>Angular/AngularPost",data:$scope.resetMainUserPWForm}).then(function(e){($scope.resetMainUserPWForm={},1==e.data)&&($scope.successMsg="Password updated. Please login  to continue to the website.",angular.element("#successModal").modal("show"),$timeout(function(){url="/",window.location.href=url},2e3))},function(e){console.log("Error update user password query")})};

    $scope.mailingList = function(){
        $scope.iframeMail = true;
    }

    /* Search Angularjs */

    var vm=this;vm.disabled=void 0,vm.searchEnabled=void 0,vm.setInputFocus=function(){$scope.$broadcast("UiSelectDemo1")},vm.enable=function(){vm.disabled=!1},vm.disable=function(){vm.disabled=!0},vm.enableSearch=function(){vm.searchEnabled=!0},vm.disableSearch=function(){vm.searchEnabled=!1},$scope.hitEnter=function(e,o,a){var n;a=a||"";0==o&&(n="/category/products"+a+"?"+angular.element("#myvalsearch").val());1==o&&(n="/item/"+e+a),2==o&&(n="/category/"+e+a),3==o&&(n="/searchColours/"+e+a),window.location.href=n},$scope.notFoundEnter=function(e){var o=$scope.customIDURL;e&&(url="/category/products"+o+"?"+e,window.location.href=url)};

    $scope.triggerSearch = function(){ 
            //Close search popup form
            $scope.stateForm = false;     
            vm.allproductSearch  = <?=json_encode($searchResults);?>;
            //console.log(vm.allproductSearch);
            
    }
    $scope.getQuickViewContainer=function(e,n){angular.element(".hovericons-container").css("display","none"),angular.element(".hovericons-container"+n).css("display","block")},$scope.hovercontainerLeave=function(){$scope.closeQuickView()},$scope.closeQuickView=function(){angular.element(".hovericons-container").css("display","none"),$scope.details=!1,$scope.detailsPMS=!1,$scope.stocks=!1,$scope.branding=!1,$scope.pricing=!1,$scope.images=!1};
    $scope.getQuickViewData= function(opts, prim, code, from){

        var from = from || "";
         
        $scope.closeQuickView();

        $scope.packagingCalc = false;
 
        $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/AngularPostQuickView",
                    data: { option: 1, opts: opts,  prim: prim, code:code, loginUser: '<?=$siteLogcheck['loggedIn']?>',  skinnedSite: '<?=count($customArray['themeArray'])?>', skinned:  '<?=$customID?>', from: from } 
                }).then(function successCallback(response) { 
                    console.log(response.data);var element=angular.element(".hovericons-container"+prim+"_"+from);if(element.css("display","block"),$scope.openTabs=!0,"details"==opts){$scope.details=!0,$scope.details=response.data.itemDetails;var ua=window.navigator.userAgent,msie=ua.indexOf("MSIE ");if((msie>0||navigator.userAgent.match(/Trident.*rv\:11\./))&&($scope.IEBrowser=!0),$scope.details[0].PrintType1&&($scope.details[0].PrintDescription1=$scope.cleanString2(response.data.itemDetails[0].PrintDescription1)),$scope.details[0].PrintType2&&($scope.details[0].PrintDescription2=$scope.cleanString2(response.data.itemDetails[0].PrintDescription2)),$scope.details[0].PrintType3&&($scope.details[0].PrintDescription3=$scope.cleanString2(response.data.itemDetails[0].PrintDescription3)),$scope.details[0].PrintType4&&($scope.details[0].PrintDescription4=$scope.cleanString2(response.data.itemDetails[0].PrintDescription4)),$scope.details[0].PrintType5&&($scope.details[0].PrintDescription5=$scope.cleanString2(response.data.itemDetails[0].PrintDescription5)),$scope.details[0].PrintType6&&($scope.details[0].PrintDescription6=$scope.cleanString2(response.data.itemDetails[0].PrintDescription6)),$scope.details[0].PrintType7&&($scope.details[0].PrintDescription7=$scope.cleanString2(response.data.itemDetails[0].PrintDescription7)),$scope.details[0].PrintType8&&($scope.details[0].PrintDescription8=$scope.cleanString2(response.data.itemDetails[0].PrintDescription8)),$scope.details[0].PrintType9&&($scope.details[0].PrintDescription9=$scope.cleanString2(response.data.itemDetails[0].PrintDescription9)),$scope.details[0].PrintType10&&($scope.details[0].PrintDescription10=$scope.cleanString2(response.data.itemDetails[0].PrintDescription10)),$scope.details[0].Description=$scope.cleanString(response.data.itemDetails[0].Description),null!=response.data.PMSColours?$scope.detailsPMS=response.data.PMSColours:$scope.detailsPMS=!1,$scope.previewTable(response.data.itemDetails[0].sizingLine1,response.data.itemDetails[0].sizingLine2,response.data.itemDetails[0].sizingLine3,response.data.itemDetails[0].sizingLine4),$scope.cL=response.data.itemDetails[0].cartonLength,$scope.cW=response.data.itemDetails[0].cartonWidth,$scope.cH=response.data.itemDetails[0].cartonHeight,$scope.cQ=response.data.itemDetails[0].cartonQuantity,$scope.cWt=response.data.itemDetails[0].cartonWeight,response.data.itemDetails[0].Packing&&($scope.packagingCalc=!0),0!==$scope.$cL&&0!==$scope.$cW&&0!==$scope.cH){var roundOff=$scope.cL*$scope.cW*$scope.cH;$scope.totalCartonCube=(Math.round(roundOff)/1e6).toFixed(2),$scope.cartonWt=$scope.cWt+0}}"stock"==opts&&($scope.stocks=!0,$scope.stocks=response.data),"pricing"==opts&&($scope.pricing=!0,$scope.pricing=response.data),"images"==opts&&($scope.images=!0,$scope.images=response.data);

                }, function errorCallback(response) {
                    console.log("Error quickview query");
        });              

    }
    $scope.addUnderline=function(e){return["Embossing","Colour Fill","Colour Over Print","Debossed"].includes(e)?e:"<u class='cursorpoint'>"+e+"</u>"},$scope.removeSpacing=function(e){return e.trim()},$scope.checkSpecChar=function(e){$scope.newSearchValue=$scope.searchCleanString(e),angular.element("#searchInputID").val($scope.newSearchValue);var a=e.length,o=angular.element(".open .dropdown-menusearch");a>=3?o.css("visibility","visible"):o.css("visibility","hidden")},$scope.checkSearch=function(e){angular.element(".open .dropdown-menusearch").css("visibility","hidden"),$scope.checkSpecChar(e)},$scope.cleanString=function(e){var a=e.replace(/&amp;|&amp/gi,"");return(a=a.replace("&#039;","'")).replace(/[&\\\#;+$~":*?<>{}]/g,"")},$scope.searchCleanString=function(e){var a=e.replace(/&amp;|&amp/gi,"");return(a=a.replace("&#039;","'")).replace(/[&\/\\#;+'@%!^()$~":*?<>{}]/g,"")},$scope.cleanString2=function(e){var a=e.replace(/&amp;|&amp/gi," & ");return a=a.replace("amp","")},$scope.getPMS=function(e,a){$http({method:"post",url:"<?php echo base_url();?>Angular/AngularPostQuickView",data:{option:3,code:e,name:a}}).then(function(e){$scope.pmsData=e.data,$scope.pmsDataLength=e.data.pmsTables.length,angular.element("#PMSmodal").modal("show")},function(e){console.log("Error quickview query")})},$scope.countObject=function(e){var a,o=0;for(a in e)e.hasOwnProperty(a)&&o++;return o},$scope.viewthisImage=function(e,a,o,n,t,l){($scope.closeQuickView(),null!==l)&&(l=l,angular.element(".quickviewNewIMG"+a+" img").remove());if(n>0){angular.element(".zoomspan"+a+" span").remove();var r=angular.element(".zoomspan"+a),c='<span ng-click="imgZoom('+a+", "+o+", "+n+", "+t+' )" class="zoom-plus new-spanzoom" data-toggle="tooltip" data-placement="top" title="High Resolution Image"    >+</span>',i=angular.element(c),s=$compile(i)($scope);r.append(s)}$scope.codeImg=o,$scope.viewImg=e,angular.element(".quickviewIMG"+a).css("display","none"),angular.element(".quickviewNewIMG"+a+" img").remove();var p=angular.element(".quickviewNewIMG"+a);p.css("display","block");var u=$scope.location+"Images/ProductImg/"+$scope.viewImg+"?"+t,m=angular.element('<img  class="img-fluid removeImg'+n+' " src=" '+u+' " />');p.append(m)},$scope.imgZoom=function(e,a,o,n){if(angular.element(".popupZoomImg  img").remove(),null==o)var t=$scope.location+"Images/ProductImg/"+a+"-0.jpg?"+n;else t=$scope.location+"Images/ProductImg/"+a+"-"+o+".jpg?"+n;var l=angular.element(".popupZoomImg"),r=angular.element('<img  class="img-fluid   " src=" '+t+' " />');l.append(r),angular.element("#imgZoomModal").modal("show")},$scope.previewTable=function(e,a,o,n){var t='<th class="text-center"> No sizing data </th>',l="",r="",c="";if(e){var i=e.split(",");if(i.length>0){t='<thead class="thead-dark"><tr>';for(var s=0;s<=i.length;s++)void 0===i[s]||(t+="<th >"+i[s]+"</th>");t+="</tr></thead>"}}if(a){var p=a.split(",");if(p.length>0){l="<tr>";for(var u=0;u<=p.length;u++)void 0===p[u]||(l+="<td>"+p[u]+"</td>");l+="<tr>"}}if(o){var m=o.split(",");if(m.length>0){r="<tr>";for(var g=0;g<=m.length;g++)void 0===m[g]||(r+="<td>"+m[g]+"</td>");r+="</tr>"}}if(n){var d=n.split(",");if(d.length>0){c="<tr>";for(var h=0;h<=d.length;h++)void 0===p[h]||(c+="<td>"+d[h]+"</td>");c+="<tr>"}}$scope.PreviewTableResult='<table class="table table-striped table-bordered  small-table-font  table-sm tableSizer"> '+t+l+r+c+" </table>"},$scope.getPopup=function(e){console.log(e),$http({method:"post",url:"<?php echo base_url();?>Angular/AngularPostQuickView",data:{option:2,brand:e}}).then(function(e){console.log(e.data);var a=e.data;angular.element("#"+a+"Modal").modal("show")},function(e){console.log("Error quickview query")})};

        /* Footer next */
<?php if(count($customArray['themeArray']) == 0 || $siteLogcheck['loggedIn'] == 1): ?>  
        $scope.favourites = false;
        $scope.viewed = false;
        $scope.footerBox = function(opts){
            if(opts == 'favourites'){
                $scope.favourites = true;
               // console.log("HEY");
            }
        }

        $scope.footerBoxLeave = function(){
            $scope.favourites = false;
            $scope.viewed = false;
        }

        $scope.open = false;
        $scope.openTwo = false;
        $scope.openFav = function(){
            $scope.openTwo = false;
            $scope.open = true;
           
        }
        $scope.closeFav = function(){
            $scope.open = false;
            $scope.openTwo = false;
               
        }

         $scope.openView = function(){
            $scope.open = false;
            $scope.openTwo = true; 
        }
        $scope.closeView = function(){
            $scope.openTwo = false;
            $scope.open = false;     
        }


        /* Favourites */

        $scope.favMinus = 0;
        $scope.favPlus = 0;

        $scope.addFavourite = function(userID, Code){
            $http({
                            method: "post",
                            url:  "<?php echo base_url();?>Angular/FavouriteItem",
                            data: {option: 2, userID: userID, Code: Code}
                            
                    }).then(function successCallback(responseFav) {  
                        console.log(responseFav.data);  
                        if(responseFav.data == 1){
                                $scope.favPlus = 0;
                                $scope.callDefaultSlider();
                                $scope.userFavourites(userID);
                                $scope.checkFavourite(userID, Code);
                        }
                    }, function errorCallback(responseFav) {
                        console.log("Error retrieving the Add Fav ");
            });     
        }

        $scope.removeFavourite = function(userID, Code){
            $http({
                            method: "post",
                            url:  "<?php echo base_url();?>Angular/FavouriteItem",
                            data: {option: 3, userID: userID, Code: Code}
                            
                    }).then(function successCallback(responseFav) {  
                        console.log(responseFav.data);  
                        if(responseFav.data == 1){
                                $scope.favMinus = 0;
                                $scope.callDefaultSlider();
                                $scope.userFavourites(userID);
                                $scope.checkFavourite(userID, Code);
                        }
                    }, function errorCallback(responseFav) {
                        console.log("Error retrieving the Add Fav ");
            });     
        }

         $scope.removeFavouritePage = function(prim, code, userID){
            $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/<?php echo $angularFile; ?>AngularPost",
                    data: { option: 1, code: code, userID: userID } 
                }).then(function successCallback(response) {
                         //console.log(response.data);
                       
                        if(response.data){ 
                            $scope.callDefaultSlider();
                            $scope.userFavourites(userID);

                            $timeout(function() { 
                                var element = angular.element('#removeFavourite'+ prim); 
                                element.css('display', 'none'); 
                            }, 500);
                        }
                    
                            

                }, function errorCallback(response) {
                    console.log("Error Remove Favourite data");
            });     
        }



        $scope.checkFavourite = function(userID, Code){
            
            $http({
                            method: "post",
                            url:  "<?php echo base_url();?>Angular/FavouriteItem",
                            data: {option: 1, userID: userID, Code: Code}
                            
                    }).then(function successCallback(response) {   
                       // console.log(response.data); 
                        if(response.data == '1'){
                                $scope.favMinus = 1;
                                $scope.favPlus = 0;
                        }else{
                                $scope.favPlus = 1;
                                $scope.favMinus = 0;
                        } 
                        
                    }, function errorCallback(response) {
                        console.log("Error retrieving the check Fav ");
            });     
        }



        $scope.favsLength = 0;
        $scope.favouritesSlider = 0;
        $scope.dataLoaded = false;
        $scope.footerLoading = false;

        $scope.callDefaultSlider = function(){
            $scope.favsLength = 0;
            $scope.favouritesSlider = 0;
            $scope.dataLoaded = false;
            $scope.footerLoading = false;
        }

        $scope.userFavourites = function(userID){
            
            $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/favouritesAngularPost",
                    data: { option: 2, userID: userID,   avail:'<?=$checkAvailCountry?>', custom: '<?=$customID?>' } 
                }).then(function successCallback(response) { 
                      $scope.favouritesSlider = false;
                      //console.log(response.data);  
                      $scope.footerLoading = true;
                      if(response.data == "null" || response.data == null || response.data == 0){
                            //console.log("Favs = No data ");  
                            $scope.myFavouriteItems = 0;
                            $scope.favouritesSlider = 0;
                            $scope.dataLoaded = false;
                            $scope.footerLoading = false;
                      }else{

                        $timeout(function(){ 
                            $scope.favouritesSlider = response.data;
                        
                            $scope.dataLoaded = true;
                            $scope.footerLoading = false;
                        }, 2000);
                            
                         $scope.favsLength = response.data.length;
                         console.log("Favsxx = " + $scope.favsLength);  
                      }

                }, function errorCallback(response) {
                    console.log("Error favourite initiate query");
            });          
        }
<?php endif; ?>   

/* Menus */

$scope.menuClicked = true;

  
$scope.closeMenus = function(){
    
    $scope.menuClicked = true;
    
            
            var element = angular.element('.main-menus'); 
            element.css('visibility', 'hidden');  
                 
         
}
//run default
 

$scope.openMainMenu = function(opts, mens){
    $scope.stateForm = false;  
    $scope.closeMenus();
    
    
     
     /*
    if(opts == 'products' && mens == 1){
        $scope.productsAZ = true; 
        $scope.menuClicked = 0;
    }  
    if(opts == 'products'  && mens ==   0){
        $scope.productsAZ = false;
        $scope.menuClicked = 1;
    } 

    if(opts == 'collections' && mens == 1){
        $scope.collections = true; 
        $scope.menuClicked = 0;
    }  
    if(opts == 'collections'  && mens ==   0){
        $scope.collections = false;
        $scope.menuClicked = 1;
    } */
        
    var element = angular.element('.'+ opts); 
        element.css('visibility', 'visible');  
        $scope.menuClicked = false;

        element.addClass('open_'+ opts);  

        if(element.hasClass('open_'+ opts) && mens == false ){
            element.removeClass('open_'+ opts); 
            element.css('visibility', 'hidden');  
            $scope.closeMenus();
        } 
        
}

 var _menutimeout; 
$scope.openMainMenuHover = function(opts, mens){

    $scope.closeMenus();

    $scope.stateForm = false;  

 

    if(_menutimeout) {  
                $timeout.cancel(_menutimeout);
    }
    _menutimeout = $timeout(function() {
                 
                 //console.log(opts + " / " + mens);    
            var element = angular.element('.'+ opts);  
                element.css('visibility', 'visible');
                 
                 _menutimeout = null;
    }, 300); 
    
  
}

$scope.stopMenu = function(){
    if(_menutimeout) {  
                $timeout.cancel(_menutimeout);
    }
    
}

$scope.hideSearchPopup = function(){
    $scope.stateForm = false;  
}

$scope.hoverOut = function(){
     
        $scope.closeMenus();
        
};

$scope.resetMenu = function(){
    //console.log("YEAH");
    $scope.menuClicked = true;
}
 
$scope.toggleSearchForm = function () {
      $scope.stateForm = !$scope.stateForm;
}; 

 $window.onclick = function (event) {
        $scope.closeMenus(); 
        $scope.$apply();
       
};

$scope.searchAdvanceFormPopup = {};
$scope.searchAdvanceFormPopup.range = { from: 0, to: 200 };
$scope.maxx = 200;

//$scope.newFormUrl =  $scope.location + 'category/' + '0-0' + $scope.customIDURL;
$scope.newFormUrl =  $scope.location + 'category/products'   + $scope.customIDURL;
$scope.changeFormURL = function(value){

    if(!value || value =="" || value==null){
        $scope.newFormUrl =  $scope.location + 'category/products'   + $scope.customIDURL;
        return; 
    }
    //var lastStr = value[value.length -1];
    var lastStr = value.substr(value.length - 1);
    var all = '';
    //console.log(lastStr);
    //if 10-10 or 10-15 etc
    if(value.length > 4){
        lastStr = value.substr(value.length - 2);
    }
     
    if(lastStr != '0'){
        all = '/all';
    }
    $scope.newFormUrl =  $scope.location + 'category/' + value + all + $scope.customIDURL;
}


$scope.toggleFullNameItem = function (prim, colors) {
    //console.log(prim + colors);
    var colors = colors || "";
    var element = angular.element('.tooltip-'+ prim + colors);  
        element.css('visibility', 'visible');  
}; 

$scope.toggleFullNameItemMouseleave = function (){
    var element = angular.element('.tooltip-alternative');  
        element.css('visibility', 'hidden');  
}

$scope.toggleIcons = function (prim, colors) {
    // console.log(prim + colors);
    var colors = colors || "";
    var element = angular.element('.tooltipicon-'+ prim + colors);  
        element.css('visibility', 'visible');  
}; 

$scope.toggleIconsMouseleave = function (){
    var element = angular.element('.tooltip-alternativeicon');  
        element.css('visibility', 'hidden');  
}

    $scope.closeTheCollapse = function(id){ 
        var element = angular.element('#'+ id);  
            element.removeClass('show'); 

    }


   //HITPROMO
   var _timeout;
   $scope.getHitPromoAPI = function(hitPromoAPIs, hitCode){
       if(hitPromoAPIs != 0){

            if(_timeout) { // if there is already a timeout in process cancel it
                $timeout.cancel(_timeout);
            }
            _timeout = $timeout(function() {
                 
                $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/HitPromoAngularPost",
                    data: { option: 1, hitPromoAPIs: hitPromoAPIs, hitCode: hitCode   } 
                }).then(function successCallback(response) { 
                        //console.log(response.data);

                        $scope.hitPromoAPITable = response.data;

                }, function errorCallback(response) {
                    console.log("Error getting Hit API query");
                });     
                 
                _timeout = null;
            },  100);

            

       }
                
   }

   
   $scope.searchHoverForm = function(){ 
        $scope.searchHoverTrigger();
   } 

   $scope.searchHoverFormOut = function(){  
        $scope.searchHoverTrigger();
   } 

   $scope.searchHoverTrigger = function(){
        var element = angular.element('.select2-container'); 
        var elementQuickviewHoverIcons  = angular.element('.item-card .hover-icons'); 
            if(element.hasClass('select2-container--open')){
                
                elementQuickviewHoverIcons.css('visibility','hidden');
            }else{
               
                elementQuickviewHoverIcons.css('visibility','visible');
            }
   }

 
   
}]); // end controller

 

</script>
        