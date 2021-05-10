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
            
            if (e.which == 33 || e.which == 64 || e.which == 35 || e.which == 36 || e.which == 37 || e.which == 94   
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
                $(".account-transferOne").appendTo(".toolbox-account-wrapper"); 
                $(".account-transferTwo").appendTo(".toolbox-account-wrapper"); 
                $('.account-transferThree').appendTo(".toolbox-account-wrapper"); 
                $(".toolbar-transferOne").appendTo(".toolbox-account-wrapper"); 
                $(".toolbar-transferTwo").appendTo(".toolbox-account-wrapper");  
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

    $scope.deleteVisualButton = true;
     $scope.userName = '';
     $scope.userPassword = '';
     $scope.userBox= true;
     $scope.passWord = false;
     $scope.errorMessage = 'Username does not exist';
     $scope.errorPwMessage = 'Error: Password does not match';
     $scope.errorPwMessage2 = 'Error: Your account is currently on hold. Kindly contact info@trends.nz for assistance.';
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

     $scope.resetLogin = function(){
        $scope.passWord = false;
        $scope.errorUser = false; 
        $scope.userBox= true;
        $scope.userName = '';
        $scope.errorPw = '';

     }

     $scope.checkUserName = function(username){
        $http({
                method: "post",
                url:  "<?php echo base_url();?>Angular/AngularPost",
                data: { option: 2, username: username } 
            }).then(function successCallback(response) {
                    if(response.data == '1'){
                        $scope.errorUser = false; 
                        $scope.userName = username;  
                        $timeout(function() {
                            $scope.passWord = true;
                            $scope.userBox= false;
                        }, 800);   
                        
                    }else{
                        $scope.errorUser = true; 
                        $scope.errorUser  = $scope.errorMessage; 
                    }
            }, function errorCallback(response) {
                console.log("Error username query");
        });     
     }

     $scope.checkpw = function(pw){
        $http({
                method: "post",
                url:  "<?php echo base_url();?>Angular/AngularPost",
                data: { option: 3, userN: $scope.userName, passW: pw } 
            }).then(function successCallback(response) {
                  //console.log(response.data);
                if(response.data == '1'){
                   
                    $scope.passWord = false;
                    $scope.userBox= false;
                    $scope.correct = true;
                   
                    $timeout(function() {
                        $window.location.reload();
                    }, 600);   
                        
                }

                if(response.data == '0'){
                        $scope.errorPw = true; 
                        $scope.errorPw  = $scope.errorPwMessage; 
                }

                if(response.data == '2'){
                        $scope.errorPw = true; 
                        $scope.errorPw  = $scope.errorPwMessage2; 
                }


            }, function errorCallback(response) {
                console.log("Error pw query");
        }); 
     }

    $scope.logoutUser = function(e){
        e.preventDefault();
        $http({
                method: "post",
                url:  "<?php echo base_url();?>Angular/AngularPost",
                data: { option: 4 } 
            }).then(function successCallback(response) {
                 //console.log(response.data);
                if(response.data == '1'){ 
                    $timeout(function() {
                        $window.location.reload();
                    }, 600);       
                }
 
            }, function errorCallback(response) {
                console.log("Error pw query");
        }); 
    }

    $scope.forgotPwMainUser = function(userNameEmail){
        //console.log(userNameEmail); 
        <?php if($siteLogcheck['loggedIn'] == 0  && count($customArray['themeArray'])==0): ?> 

            if(userNameEmail) {
                $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/AngularPost",
                    data: { option: 19, userNameEmail:userNameEmail } 
                    }).then(function successCallback(response) {
                         console.log(response.data);

                        $scope.errorEmailForgot = true; 
                        if(response.data == 0){  
                            $scope.errorEmailForgotMsg = "Sorry, we could not find that email address.";
                        }
                        if(response.data == 1){ 
                            $scope.userMainEmail = "";
                            $scope.errorEmailForgotMsg = "<i class='fa fa-check' aria-hidden='true'></i> Password reset link was sent to your email.";
                            $timeout(function() {
                                $scope.errorEmailForgotMsg = "";
                            }, 1600);   
                        }
        
                    }, function errorCallback(response) {
                        console.log("Error forgot main user email");
                }); 
            } 

        <?php endif; ?>    
    }



    $scope.download = function(opts){
         
        $http({
                method: "post",
                url:  "<?php echo base_url();?>Angular/AngularPost",
                data: { option: 5, opts: opts } 
            }).then(function successCallback(response) {
                 console.log(response.data);
                 
 
            }, function errorCallback(response) {
                console.log("Error download query");
        }); 
    }


    $scope.loginSkinnedUser = function(){ 

        <?php if(count($customArray['themeArray']) > 0): ?>
            $scope.skinnedFormData.themeID = <?=$customArray['themeArray'][0]->themeID?>;
            $scope.skinnedFormData.customerNumber = <?=$customArray['themeArray'][0]->CustomerNumber?>;
        <?php endif; ?>
       
       
        $scope.skinnedFormData.option = 6;
        //console.log($scope.skinnedFormData);
        $http({
                method: "post",
                url:  "<?php echo base_url();?>Angular/AngularPost",
                data:  $scope.skinnedFormData,  
            }).then(function successCallback(response) {
                 //console.log(response.data); 
                 if(response.data == 1){
                    $scope.errorSkinnedLoginMessage = false;
                    $scope.correct = true;

                     $timeout(function() {
                        $window.location.reload();
                     }, 600);   
                 }

                 if(response.data == 0){
                    $scope.errorSkinnedLoginMessage = true;
                    $scope.errorSkinnedLoginMessage = 'Username or Password does not match';
                 }

            }, function errorCallback(response) {
                console.log("Error skinned login query");
        }); 
       
       
    }

    $scope.checkSkinnedLogin = function(userName, passWord){
        if( userName !== "" &&  passWord !== ""){
            $scope.skinnedLoginBtn = false;
        }else{
            $scope.skinnedLoginBtn = true;
        }
    }

    $scope.logoutSkinUser = function(e){
        e.preventDefault();
        $http({
                method: "post",
                url:  "<?php echo base_url();?>Angular/AngularPost",
                data: { option: 7 } 
            }).then(function successCallback(response) {
                 //console.log(response.data);
                if(response.data == '1'){ 
                    $timeout(function() {
                        $window.location.reload();
                    }, 600);       
                }
 
            }, function errorCallback(response) {
                console.log("Error pw query");
        }); 
    }

    $scope.skinnedLoginTitle = function(title){
        $scope.skinnedLoginFormTitle = title;
    }

    $scope.forgotPwSkinnedUser = function(userNameEmail){
        //console.log(userNameEmail); 
        <?php if(count($customArray['themeArray']) > 0): ?>
            $scope.themeID = <?=$customArray['themeArray'][0]->themeID?>;
            $scope.customerNumber = <?=$customArray['themeArray'][0]->CustomerNumber?>;
        <?php endif; ?>

        if(userNameEmail) {
            $http({
                method: "post",
                url:  "<?php echo base_url();?>Angular/AngularPost",
                data: { option: 8, userNameEmail:userNameEmail, themeID: $scope.themeID,  customerNumber: $scope.customerNumber } 
                }).then(function successCallback(response) {
                    console.log(response.data);
                    
                    if(response.data == 0){
                        $scope.successSkinnedForgotMessage = false;
                        $scope.errorSkinnedForgotMessage = true;
                        $scope.errorSkinnedForgotMessage = "Sorry, we could not find that email address.";
                    }
                    if(response.data == 1){
                        $scope.errorSkinnedForgotMessage = false;
                        $scope.successSkinnedForgotMessage = true;
                        $scope.successSkinnedForgotMessage = "Password reset link was sent to your email.";
                    }
    
                }, function errorCallback(response) {
                    console.log("Error forgot pw");
            }); 
        } 
    }

    /* Visuals Request */

    $scope.itemRequestVisuals = function(userID, Code){
        $scope.initiateUserVisuals(userID);
        $scope.getProductColours(Code);
        $scope.visualFormData.productItem = Code;
    }

    $scope.initiateUserVisuals = function(userID){
            $scope.loadingEffects = true;
            $scope.visualUpdateBtn = false;
            $scope.visualFormData.projectName = null;
            $scope.visualFormData.instructions = null;

            $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/AngularPost",
                    data: { option: 9, userID: userID } 
                }).then(function successCallback(response) { 
                   // console.log(response.data);
                    $scope.loadingEffects = false;
                    $scope.userVisualFiles = null;
                    $scope.userVisualRequests = null;
                    
                    $scope.userID = userID;
                    $scope.countItem = 0;

                    if(response.data.visualRequests !== 0){ 
                        $scope.countItem =   $scope.objectLength(response.data.visualRequests);
                        if($scope.countItem >= $scope.countItemLimit){
                            //Code here for form disabled
                            $scope.itemVisualiseActive = false;
                        }
                        $scope.userVisualRequests = response.data.visualRequests; 
                        $scope.visualFormData.projectName = response.data.visualRequests[0].projectName;
                        $scope.visualFormData.instructions = response.data.visualRequests[0].instructions;
                        $scope.visualUpdateBtn = true;
                    }

                    if(response.data.visualFiles !== 0){
                        $scope.userVisualFiles = response.data.visualFiles; 
                    }

                    //Select default Product item select option
                    //$scope.visualFormData.productItem = $scope.productVisuals[0].Name;
                    
                    $scope.userVisualItems = response.data.visualProductVisualLists;
                    
                    //console.log(response.data);
                    
                    
                   
                  
                }, function errorCallback(response) {
                    console.log("Error visual query");
            });     
    }

   
    $scope.getProductColoursVisual = function(itemCode, itemCols, id){

        var elementy = angular.element(".alertitemcolour"); 
                        elementy.css('display', 'none');
        var elementx = angular.element(".alertbrandingcolour"); 
                        elementx.css('display', 'none');

         var element = angular.element('.itemcolour_'+ id); 
                        element.css('display', 'block');  
                        //console.log("Eto ID " + id);
            
            $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/AngularPost",
                    data: { option: 12, itemCode: itemCode } 
                }).then(function successCallback(response) {
                         //console.log(response.data); 
                    if(response.data.length > 0){ 
                         
                            $scope.availableColoursR = response.data[0].Colours.split(',');
                           // console.log($scope.availableColoursR); 
                            var countR = $scope.availableColoursR.length - 1;
                            for(var x = 0; x <= countR; x++){
                                
                                $scope.findVal = $scope.availableColoursR[x].replace(/^\s/g, '');
                                //$scope.findVal = $scope.findVal.replace(/[.]/g,'');
                                //console.log($scope.findVal + " / " + itemCols); 
                                if ($scope.findVal == itemCols) {
                                   // console.log($scope.findVal); 
                                    $scope.itemColsRight = $scope.availableColoursR[x];
                                }
                            }
                            if($scope.availableColoursR){
                                $scope.availableColoursVisual = $scope.availableColoursR;
                            } 
                    }
                       
                }, function errorCallback(response) {
                    console.log("Error visual query");
            });   
        
    
    }
    

    $scope.updateThisItemVisual = function(uid, cols, details){
        $scope.updateThisItem(uid, cols, details);
        $scope.availableColoursVisual = false; 
        
        angular.element('#itemCols_'+uid).val(details); 
        var element = angular.element(".alertitemcolour"); 
                        element.css('display', 'none'); 
        //console.log("XXX " + details);
    }

    $scope.getProductColoursBranding = function(itemCode, itemCols, id){

        var elementx = angular.element(".alertbrandingcolour"); 
                        elementx.css('display', 'none');
        var elementy = angular.element(".alertitemcolour"); 
                        elementy.css('display', 'none');                

        var element = angular.element('.brandingcolour_'+ id); 
                        element.css('display', 'block');  
                        //console.log("Eto ID " + id);
            
            $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/AngularPost",
                    data: { option: 12, itemCode: itemCode } 
                }).then(function successCallback(response) {
                        //console.log(response.data); 
                    if(response.data.length > 0){ 
                        
                            var printType1 = response.data[0].PrintType1;
                            var printType2 = response.data[0].PrintType2;
                            var printType3 = response.data[0].PrintType3; 
                            var printType4 = response.data[0].PrintType4; 
                            var printType5 = response.data[0].PrintType5; 
                            var printType6 = response.data[0].PrintType6; 
                            var printType7 = response.data[0].PrintType7; 
                            var printType8 = response.data[0].PrintType8; 
                            var printType9 = response.data[0].PrintType9; 
                            var printType10 = response.data[0].PrintType10; 
                            var  PrintDescription1 = response.data[0].PrintDescription1;
                            var  PrintDescription2 = response.data[0].PrintDescription2;
                            var  PrintDescription3 = response.data[0].PrintDescription3;
                            var  PrintDescription4 = response.data[0].PrintDescription4;
                            var  PrintDescription5 = response.data[0].PrintDescription5;
                            var  PrintDescription6 = response.data[0].PrintDescription6;
                            var  PrintDescription7 = response.data[0].PrintDescription7;
                            var  PrintDescription8 = response.data[0].PrintDescription8;
                            var  PrintDescription9 = response.data[0].PrintDescription9;
                            var  PrintDescription10 = response.data[0].PrintDescription10;

                            var availableBrandingOptionArray = {  
                                "0" : {"pt" : printType1, "pd" : PrintDescription1},  
                                "1" : {"pt" : printType2, "pd" : PrintDescription2},  
                                "2" : {"pt" : printType3, "pd" : PrintDescription3}, 
                                "3" : {"pt" : printType4, "pd" : PrintDescription4}, 
                                "4" : {"pt" : printType5, "pd" : PrintDescription5}, 
                                "5" : {"pt" : printType6, "pd" : PrintDescription6}, 
                                "6" : {"pt" : printType7, "pd" : PrintDescription7}, 
                                "7" : {"pt" : printType8, "pd" : PrintDescription8}, 
                                "8" : {"pt" : printType9, "pd" : PrintDescription9}, 
                                "9" : {"pt" : printType10, "pd" : PrintDescription10}, 
                            };
                        
                            var arrBranding = [];  
                            Object.keys(availableBrandingOptionArray).forEach(function (key) {
                                if(availableBrandingOptionArray[key]['pt']){
                                    //newArray  = "<strong>" + availableBrandingOptionArray[key]['pt'] + "</strong>: " + availableBrandingOptionArray[key]['pd'];
                                    newArray  =  availableBrandingOptionArray[key]['pt'] + ": " + $scope.cleanString2(availableBrandingOptionArray[key]['pd']);
                                    arrBranding.push(newArray);
                                }
                            
                            });
                            
                            $scope.availableBrandingOptionVisuals =  arrBranding;
                             
                    }
                    
                }, function errorCallback(response) {
                    console.log("Error visual query");
            });   


    }
     
    $scope.updateThisItemBranding = function(uid, cols, details){
        $scope.updateThisItem(uid, cols, details);
        $scope.availableBrandingOptionVisuals = false; 
        
        angular.element('#printOpt_'+uid).val(details); 
        var element = angular.element(".alertbrandingcolour"); 
                        element.css('display', 'none'); 
        //console.log("XXX " + details);
    }

    $scope.closeVisualDropdownOption = function(){
        var elementx = angular.element(".alertbrandingcolour"); 
                        elementx.css('display', 'none');
        var elementy = angular.element(".alertitemcolour"); 
                        elementy.css('display', 'none');      
    }



    $scope.getProductColours = function(itemCode){
        //console.log(itemCode);

            $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/AngularPost",
                    data: { option: 12, itemCode: itemCode } 
                }).then(function successCallback(response) {
                         //console.log(response.data);
                        //console.log(response.data[0].Colours); 
                        //$scope.availableColours = response.data[0].Colours;
                    if(response.data.length > 0){


                            $scope.availableColours = response.data[0].Colours.split(',');
                            if($scope.availableColours){
                                $scope.visualFormData.ItemColour =   $scope.availableColours[0];
                            }
                        
                        

                       

                        var printType1 = response.data[0].PrintType1;
                        var printType2 = response.data[0].PrintType2;
                        var printType3 = response.data[0].PrintType3; 
                        var printType4 = response.data[0].PrintType4; 
                        var printType5 = response.data[0].PrintType5; 
                        var printType6 = response.data[0].PrintType6; 
                        var printType7 = response.data[0].PrintType7; 
                        var printType8 = response.data[0].PrintType8; 
                        var printType9 = response.data[0].PrintType9; 
                        var printType10 = response.data[0].PrintType10; 
                        var  PrintDescription1 = response.data[0].PrintDescription1;
                        var  PrintDescription2 = response.data[0].PrintDescription2;
                        var  PrintDescription3 = response.data[0].PrintDescription3;
                        var  PrintDescription4 = response.data[0].PrintDescription4;
                        var  PrintDescription5 = response.data[0].PrintDescription5;
                        var  PrintDescription6 = response.data[0].PrintDescription6;
                        var  PrintDescription7 = response.data[0].PrintDescription7;
                        var  PrintDescription8 = response.data[0].PrintDescription8;
                        var  PrintDescription9 = response.data[0].PrintDescription9;
                        var  PrintDescription10 = response.data[0].PrintDescription10;

                        var availableBrandingOptionArray = {  
                            "0" : {"pt" : printType1, "pd" : PrintDescription1},  
                            "1" : {"pt" : printType2, "pd" : PrintDescription2},  
                            "2" : {"pt" : printType3, "pd" : PrintDescription3}, 
                            "3" : {"pt" : printType4, "pd" : PrintDescription4}, 
                            "4" : {"pt" : printType5, "pd" : PrintDescription5}, 
                            "5" : {"pt" : printType6, "pd" : PrintDescription6}, 
                            "6" : {"pt" : printType7, "pd" : PrintDescription7}, 
                            "7" : {"pt" : printType8, "pd" : PrintDescription8}, 
                            "8" : {"pt" : printType9, "pd" : PrintDescription9}, 
                            "9" : {"pt" : printType10, "pd" : PrintDescription10}, 
                        };
                       
                        var arrBranding = [];  
                        Object.keys(availableBrandingOptionArray).forEach(function (key) {
                            if(availableBrandingOptionArray[key]['pt']){
                                //newArray  = "<strong>" + availableBrandingOptionArray[key]['pt'] + "</strong>: " + availableBrandingOptionArray[key]['pd'];
                                newArray  =  availableBrandingOptionArray[key]['pt'] + ": " + $scope.cleanString2(availableBrandingOptionArray[key]['pd']);
                                arrBranding.push(newArray);
                            }
                           
                        });
                        
                        $scope.availableBrandingOption =  arrBranding;
                        if($scope.availableBrandingOption){
                            $scope.visualFormData.BrandingOption =   arrBranding[0];
                        }
                       //console.log($scope.availableBrandingOption); 

                    }else{
                        $scope.availableColours = false;
                        $scope.availableBrandingOption = false;
                    }
                       
                }, function errorCallback(response) {
                    console.log("Error visual query");
            });     
    }

    $scope.objectLength = function(obj) {
        var result = 0;
        for(var prop in obj) {
            if (obj.hasOwnProperty(prop)) {
            // or Object.prototype.hasOwnProperty.call(obj, prop)
            result++;
            }
        }
        return result;
    }



    $scope.addVisualItem = function(userID){
            
            

            if(userID){
               // console.log($scope.visualFormData);
                $scope.visualFormData.userID = userID;
                $scope.visualFormData.option = 13;

                if(!$scope.visualFormData.ItemInstructions){
                    $scope.visualFormData.ItemInstructions = null;
                }

                $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/AngularPost",
                    data:  $scope.visualFormData  
                    }).then(function successCallback(response) { 
                        $scope.visualFormData = {}; 
                        $scope.initiateUserVisuals(userID);
                        $scope.done = true;  
                        $scope.availableColours = false; 
                        $scope.availableBrandingOption = false; 

                        $timeout(function() { 
                            $scope.done = false;  
                        }, 2000);

                    }, function errorCallback(response) {
                    console.log("Error  visual insert query");
                });    
            }
            
    }




    $scope.deleteArtwork= function(userID,  visualFiles, ind){
        if (confirm("Are you sure you want to delete this image?")) {  
            
            $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/AngularPost",
                    data: { option: 10, userID: userID, visualFiles: visualFiles } 
                }).then(function successCallback(response) { 
                    //console.log(response.data);
                    if(response.data.deleted == 1){

                        if(response.data.countFiles == 0){
                            $scope.userVisualFiles = null;
                        }

                        var element = angular.element('#artworkFile_'+ ind); 
                        element.css('background-color', '#c82333');  
                        
                        $timeout(function() { 
                            var element2 = angular.element('#artworkFile_'+ ind); 
                            element2.css('display', 'none'); 
                        }, 1000);
                        
                    }
                   

                }, function errorCallback(response) {
                    console.log("Error delete files visual query");
            });    
        }
    }

    $scope.deleteItems= function(uid, ind){
        $scope.deleteVisualButton = false;
        if (confirm("Are you sure you want to delete this item?")) {  
            //console.log(uid);
            $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/AngularPost",
                    data: { option: 14,  uid: uid } 
                }).then(function successCallback(response) { 
                    // console.log(response.data); 
                    
                   

                    if(response.data == 1){
                        var element = angular.element('#visualItems_'+ ind); 
                        element.css('background-color', '#c82333');  
                        
                        $timeout(function() { 
                            var element2 = angular.element('#visualItems_'+ ind); 
                            element2.css('display', 'none'); 

                             if($scope.countItem !== 0){
                                $scope.countItem =  $scope.countItem - 1;
                            }
                            

                            if($scope.countItem >= $scope.countItemLimit){ 
                                    $scope.itemVisualiseActive = false;
                            }else{
                                $scope.itemVisualiseActive = true;
                            }
                            
                            $scope.deleteVisualButton = true;
                            
                        }, 1000);
                    } 

                }, function errorCallback(response) {
                    console.log("Error delete files visual query");
            });    
        }
    }

    $scope.updateProjectDetails = function(projectName, instructions){
         
            $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/AngularPost",
                    data: { option: 11, projectName: projectName, instructions:instructions, userID: $scope.userID } 
                }).then(function successCallback(response) { 
                    //console.log(response.data); 
                    if(response.data == 1){
                       
                        var element = angular.element('.projectInputs'); 
                        element.css('border', '2px solid  #28a745'); 
                        $timeout(function() { 
                            var element2 = angular.element('.projectInputs'); 
                            element2.css('border', '1px solid #ced4da'); 
                        }, 2000);
                    }
                      

                }, function errorCallback(response) {
                    console.log("Error delete files visual query");
            });    
    }

    $scope.uploadArtwork = function(projName, projDesc, userID, file){

        

                    if(file){
                        //console.log(userID);
                        //console.log(file);
                       
                                file.upload = Upload.upload({
                                    url:  "<?php echo base_url();?>Angular/AngularPost",
                                    data: {option: 12, userID: userID, file: file },
                                });

                                file.upload.then(function (response) {  
                                   // console.log(response.data); 
                                    if(response.data == 1){
                                        $scope.initiateUserVisuals(userID);
                                        $scope.visualFormData.projectName = projName;
                                        $scope.visualFormData.instructions = projDesc;
                                        $scope.done = true;  

                                         $timeout(function() { 
                                            $scope.done = false;  
                                        }, 2000);
                                    }

                                }, function (response) {
                                if (response.status > 0)
                                    $scope.errorMsg = response.status + ': ' + response.data;
                                });  
                    }  
    }

   

    $scope.updateThisItem = function(uid, cols, details){
        //console.log(uid + " / " + cols + " / " + details);

            $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/AngularPost",
                    data: { option: 15, uid: uid, cols: cols, details: details } 
                }).then(function successCallback(response) { 
                    console.log(response.data);  

                    if(response.data == 1){
                        var element = angular.element("."+cols+uid); 
                        element.css('display', 'inline-block'); 
                        $timeout(function() { 
                            var element2 = angular.element("."+cols+uid); 
                            element2.css('display', 'none'); 
                       }, 2000); 

                      /* var element = angular.element('#'+cols+"_"+uid + " .editPen"); 
                       element.css('display', 'inline-block'); 
                       $timeout(function() { 
                           var element2 = angular.element('#'+cols+"_"+uid); 
                           element2.css('border', '0px none'); 
                           element2.css('border-bottom', '1px solid #ced4da'); 
                       }, 2000); */
                   }

                }, function errorCallback(response) {
                    console.log("Error delete files visual query");
            });    
    }
    
    $scope.sendToEmail = function(userID){
        if (confirm("This will send to Trends Visualisation Request. Click OK to continue.")) {  
            
            $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/AngularPost",
                    data: { option: 16,  userID: userID } 
                }).then(function successCallback(response) { 
                    //console.log(response.data); 
                    if(response.data == 1){ 
                            
                                $scope.initiateUserVisuals(userID);
                                $scope.done = true;    

                            $timeout(function() { 
                                $scope.done = false; 
                                $scope.visualSubmitted = true;   
                            }, 2000);

                             
                    } 

                }, function errorCallback(response) {
                    console.log("Error userID email visual query");
            });    
        }
    }

    $scope.hideVisualSuccess = function(){
        $scope.visualSubmitted = false;  
    }

    $scope.checkOldPW = function(oldpw){
        if(oldpw){
            $scope.resetUserPWForm['userID'] = '<?=$siteLogcheck['userDatas'][0]->userID?>';
            $scope.resetUserPWForm['seaSalt'] = '<?=$siteLogcheck['userDatas'][0]->userSalt?>';
            $scope.resetUserPWForm['userEmail'] = '<?=$siteLogcheck['userDatas'][0]->userEmail?>';
            $scope.resetUserPWForm.oldpw = oldpw;
            $scope.resetUserPWForm.option = 17;

             $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/AngularPost",
                    data: $scope.resetUserPWForm 
                }).then(function successCallback(response) { 
                     //console.log(response.data); 
                    if(response.data == 1){
                           $scope.oldPWMsg = '<i class="fa fa-check  check"></i> '; 
                           $scope.updateUserPW1 = false;
                           $scope.updateUserPW2 = false;
                    } 
                    if(response.data == 2){
                           $scope.oldPWMsg = 'old passwords didnt match'; 
                           $scope.updateUserPW1 = true;
                           $scope.updateUserPW2 = true;
                    } 
                    if(response.data == 0){
                        alert("Please contact Web Admin to reset your password");
                        $scope.updateUserPW1 = true;
                        $scope.updateUserPW2 = true;
                    } 

                }, function errorCallback(response) {
                    console.log("Error old password query");
            });   
        }
        //console.log($scope.resetUserPWForm);
           
    }

    $scope.checkNewPW = function(newpw, confirmpw){
        if(newpw !== confirmpw){ 
                $scope.userResetPWMsg = "Password doesn't match";
                $scope.updateUserPWBtn = true;
        }else{
                $scope.userResetPWMsg = false;  
                $scope.updateUserPWBtn = false;
        }
    }

    $scope.resetUserPW = function(userID){
            
            $scope.resetUserPWForm.option = 18; 
            $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/AngularPost",
                    data: $scope.resetUserPWForm 
                }).then(function successCallback(response) { 
                     console.log(response.data); 
                     if(response.data == 1){
                            $scope.correct = true;

                             $timeout(function() {
                                $window.location.reload();
                            }, 600);  
                     } 

                }, function errorCallback(response) {
                    console.log("Error update user password query");
            });               

    }

    $scope.resetMainUserPW = function(userID){
            
            $scope.resetMainUserPWForm.option = 20; 
            $scope.resetMainUserPWForm.userID = userID; 
            //console.log($scope.resetMainUserPWForm);

             $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/AngularPost",
                    data: $scope.resetMainUserPWForm
                }).then(function successCallback(response) { 
                    //console.log(response.data);
                    $scope.resetMainUserPWForm = {};

                    if(response.data == 1){
                        $scope.successMsg = 'Password updated. Please login  to continue to the website.';   
                        var element = angular.element('#successModal'); 
                        element.modal('show');  

                        $timeout(function() {
                            url = '/';
                            window.location.href = url; 
                        }, 2000);  

                        

                    }
                   

                }, function errorCallback(response) {
                    console.log("Error update user password query");
            });       


    }

    $scope.mailingList = function(){
        $scope.iframeMail = true;
    }

    /* Search Angularjs */

    var vm = this;

    vm.disabled = undefined;
    vm.searchEnabled = undefined;

    vm.setInputFocus = function (){
    $scope.$broadcast('UiSelectDemo1');
    };

    vm.enable = function() {
    vm.disabled = false;
    };

    vm.disable = function() {
    vm.disabled = true;
    };

    vm.enableSearch = function() {
    vm.searchEnabled = true;
    };

    vm.disableSearch = function() {
    vm.searchEnabled = false;
    };

     
   
    $scope.hitEnter = function(code, optin, ref){
        
        var ref = ref || "";
        var url; 
        if(optin == 0){
            var newcode = angular.element('#myvalsearch').val();
            url = '/category/products' + ref + '?' + newcode;
        }

        if(optin == 1){
            url = '/item/' + code + ref;
        }
        if(optin == 2){
            url = '/category/' + code + "" + ref;
        }

        if(optin == 3){
            url = '/searchColours/' + code + ref;
        }

         
        
       window.location.href = url;
        //location.reload("/item/" + code + ref);
    }

    $scope.notFoundEnter = function(value){
       var customID = $scope.customIDURL; 
       if(value){
            url = '/category/products' + customID + '?' + value;
            window.location.href = url;
       }
    }

    $scope.triggerSearch = function(){ 
            //Close search popup form
            $scope.stateForm = false;     
            vm.allproductSearch  = <?=json_encode($searchResults);?>;
            //console.log(vm.allproductSearch);
            
    }


    $scope.getQuickViewContainer = function(opts, id){
        var elementClose = angular.element('.hovericons-container'); 
            elementClose.css('display', 'none'); 

        
         var element = angular.element('.hovericons-container' +  id); 
            element.css('display', 'block'); 

           
    }

    $scope.hovercontainerLeave = function(){ 
           $scope.closeQuickView();
    }

    $scope.closeQuickView = function(){

        var elementClose = angular.element('.hovericons-container'); 
            elementClose.css('display', 'none'); 

           
           
            $scope.details = false;
            $scope.detailsPMS = false;
            $scope.stocks = false;
            $scope.branding = false;
            $scope.pricing   = false;
            $scope.images = false;
    }
    
    

    $scope.getQuickViewData= function(opts, prim, code, from){

        var from = from || "";
        
        //console.log("From = " + from);
         //console.log(opts + " / " +prim + " / " +code);

        <?php

        /* On mobile allow to open multiple accordion */ 
			if($this->general_model->mobileDetector() == 0){  
				$mobile = 0;
			}else{
				$mobile = 1;
			}
		 
            if($mobile == 0): 
        ?> 
            $scope.closeQuickView(); 
        <?php endif; ?>

        $scope.packagingCalc = false;

        

        /*
        if(opts == 'branding'){  
            var random =  Math.random();
            url = '/PDFWires/' + code + '.pdf?' + random; 
            //window.location.href = url;
            $window.open(
                url  
            );
            return;
        } */

        $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/AngularPostQuickView",
                    data: { option: 1, opts: opts,  prim: prim, code:code, loginUser: '<?=$siteLogcheck['loggedIn']?>',  skinnedSite: '<?=count($customArray['themeArray'])?>', skinned:  '<?=$customID?>', from: from } 
                }).then(function successCallback(response) { 
                       //console.log(response.data); 
                    
                     //console.log("DIto 0");

                      var element = angular.element('.hovericons-container' +  prim + "_" + from); 
                        element.css('display', 'block'); 

                        //console.log('.hovericons-container' +  prim + "_" + from);

                         $scope.openTabs = true;

                     if(opts == 'details'){
                        $scope.details = true;
                        $scope.details = response.data.itemDetails;
                        //response.data.itemDetails[0].Description)
                        //Clean Description
                        
                         
                        /* GET THE BRANDED THAT HAS A POPUP using $scope.addUnderline function */
                        
                        var ua = window.navigator.userAgent;
                        var msie = ua.indexOf("MSIE ");

                        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))  // If Internet Explorer, return version number
                        {
                            $scope.IEBrowser = true;
                        }
                        
                        
                        if( $scope.details[0]['PrintType1']){
                           // $scope.details[0]['PrintType1'] = $scope.removeSpacing(response.data.itemDetails[0].PrintType1);
                           // $scope.details[0]['PrintType1A'] = $scope.addUnderline($scope.details[0]['PrintType1']);
                            $scope.details[0]['PrintDescription1'] = $scope.cleanString2(response.data.itemDetails[0].PrintDescription1);
                        } 
                         
                         
                        
                        if( $scope.details[0]['PrintType2']){
                           // $scope.details[0]['PrintType2'] = $scope.removeSpacing(response.data.itemDetails[0].PrintType2);
                           // $scope.details[0]['PrintType2A'] = $scope.addUnderline($scope.details[0]['PrintType2']);
                            $scope.details[0]['PrintDescription2'] = $scope.cleanString2(response.data.itemDetails[0].PrintDescription2);
                        }

                        
                        if( $scope.details[0]['PrintType3']){
                          //  $scope.details[0]['PrintType3'] = $scope.removeSpacing(response.data.itemDetails[0].PrintType3);
                           // $scope.details[0]['PrintType3A'] = $scope.addUnderline($scope.details[0]['PrintType3']);
                            $scope.details[0]['PrintDescription3'] = $scope.cleanString2(response.data.itemDetails[0].PrintDescription3);
                        }

                        
                        if( $scope.details[0]['PrintType4']){
                           // $scope.details[0]['PrintType4'] = $scope.removeSpacing(response.data.itemDetails[0].PrintType4);
                           // $scope.details[0]['PrintType4A'] = $scope.addUnderline($scope.details[0]['PrintType4']);
                            $scope.details[0]['PrintDescription4'] = $scope.cleanString2(response.data.itemDetails[0].PrintDescription4);
                        }

                        
                        if( $scope.details[0]['PrintType5']){
                           // $scope.details[0]['PrintType5'] = $scope.removeSpacing(response.data.itemDetails[0].PrintType5);
                           // $scope.details[0]['PrintType5A'] = $scope.addUnderline($scope.details[0]['PrintType5']);
                            $scope.details[0]['PrintDescription5'] = $scope.cleanString2(response.data.itemDetails[0].PrintDescription5);
                        }

                        
                        if( $scope.details[0]['PrintType6']){
                           // $scope.details[0]['PrintType6'] = $scope.removeSpacing(response.data.itemDetails[0].PrintType6);
                           // $scope.details[0]['PrintType6A'] = $scope.addUnderline($scope.details[0]['PrintType6']);
                            $scope.details[0]['PrintDescription6'] = $scope.cleanString2(response.data.itemDetails[0].PrintDescription6);
                        }

                        
                        if( $scope.details[0]['PrintType7']){
                            //$scope.details[0]['PrintType7'] = $scope.removeSpacing(response.data.itemDetails[0].PrintType7);
                           // $scope.details[0]['PrintType7A'] = $scope.addUnderline($scope.details[0]['PrintType7']);
                            $scope.details[0]['PrintDescription7'] = $scope.cleanString2(response.data.itemDetails[0].PrintDescription7);
                        }

                        
                        if( $scope.details[0]['PrintType8']){
                           // $scope.details[0]['PrintType8'] = $scope.removeSpacing(response.data.itemDetails[0].PrintType8);
                           // $scope.details[0]['PrintType8A'] = $scope.addUnderline($scope.details[0]['PrintType8']);
                            $scope.details[0]['PrintDescription8'] = $scope.cleanString2(response.data.itemDetails[0].PrintDescription8);
                        }

                        
                        if( $scope.details[0]['PrintType9']){
                            //$scope.details[0]['PrintType9'] = $scope.removeSpacing(response.data.itemDetails[0].PrintType9);
                           // $scope.details[0]['PrintType9A'] = $scope.addUnderline($scope.details[0]['PrintType9']);
                            $scope.details[0]['PrintDescription9'] = $scope.cleanString2(response.data.itemDetails[0].PrintDescription9);
                        }

                        
                        if( $scope.details[0]['PrintType10']){
                            //$scope.details[0]['PrintType10'] = $scope.removeSpacing(response.data.itemDetails[0].PrintType10);
                           // $scope.details[0]['PrintType10A'] = $scope.addUnderline($scope.details[0]['PrintType10']);
                            $scope.details[0]['PrintDescription10'] = $scope.cleanString2(response.data.itemDetails[0].PrintDescription10);
                        }
                        
                        $scope.details[0]['Description'] = $scope.cleanString(response.data.itemDetails[0].Description);

                       
                         
                        
                       
                        
                         
                        //console.log($scope.details);
                        
                        if(response.data.PMSColours != null){
                            $scope.detailsPMS = response.data.PMSColours;
                        }else{
                            $scope.detailsPMS = false;
                        } 
                        
                        
                        $scope.previewTable(response.data.itemDetails[0].sizingLine1, response.data.itemDetails[0].sizingLine2, response.data.itemDetails[0].sizingLine3, response.data.itemDetails[0].sizingLine4);
                        
                        $scope.cL  = response.data.itemDetails[0].cartonLength;
                        $scope.cW  = response.data.itemDetails[0].cartonWidth;
                        $scope.cH  = response.data.itemDetails[0].cartonHeight;
                        $scope.cQ  = response.data.itemDetails[0].cartonQuantity;
                        $scope.cWt = response.data.itemDetails[0].cartonWeight;
                        
                        if(response.data.itemDetails[0].Packing){
                            $scope.packagingCalc = true;
                            //console.log("DIto 1 " + response.data[0].Packing);
                            
                        }

                        if($scope.$cL !== 0 && $scope.$cW !== 0 && $scope.cH !== 0){
                            //console.log("DIto 2");
                            var roundOff = $scope.cL * $scope.cW * $scope.cH; 
                            $scope.totalCartonCube = (Math.round(roundOff) / 1000000).toFixed(2); 
                            $scope.cartonWt = $scope.cWt + 0;
                        }  
                        
                        
                     }

                     if(opts == 'stock'){
                         //console.log("STOCK HERE");
                        $scope.stocks = true;
                        $scope.stocks = response.data;   
                     }

                      if(opts == 'pricing'){
                        //console.log("PRICING HERE");
                        //console.log(response.data);
                            $scope.pricing = true;
                            $scope.pricing = response.data; 
                      }

                       if(opts == 'images'){
                            //console.log("IMAGES HERE ");
                            //console.log(response.data);
                            $scope.images = true;
                            $scope.images = response.data; 
                       }

                }, function errorCallback(response) {
                    console.log("Error quickview query");
        });              

    }

 

    $scope.addUnderline = function(orig){
            var ext;
            let arr = ["Embossing", "Colour Fill", "Colour Over Print", "Debossed"]; 
            var und = "<u class='cursorpoint'>";
            var ine = "</u>";

            if(arr.includes(orig)){
                ext =  orig;
                
            }else{
                ext = und + orig + ine;
            }

            return ext;

    }

    $scope.removeSpacing = function(strings){
        var str = strings; 
        return str.trim();
    }

    $scope.checkSpecChar = function(searchItem){
        
       /* var elementOpen = angular.element('.open ul.dropdown-menusearch'); 
        elementOpen.css('visibility','visible'); */

        $scope.newSearchValue = $scope.searchCleanString(searchItem);
        var element = angular.element('#searchInputID'); 
        element.val($scope.newSearchValue); 
        //searchInputID

        //show the dropdown lists
        var countsearchItem = searchItem.length;
        //console.log(countsearchItem);
        var elementShow = angular.element('.open .dropdown-menusearch'); 
        if(countsearchItem >= 3){ 
            elementShow.css('visibility','visible');
        }else{
            elementShow.css('visibility','hidden'); 
        }

    }

    $scope.checkSearch = function(typedText){
        var elementShow = angular.element('.open .dropdown-menusearch'); 
        elementShow.css('visibility','hidden'); 
        $scope.checkSpecChar(typedText);
        //console.log("ETO " + typedText);
    }

    $scope.cleanString = function(string){
        
        var str = string.replace(/&amp;|&amp/gi, '');
            str = str.replace("&#039;", "'");
        return str.replace(/[&\\\;$~:*?<>{}]/g, '');

    } 

    $scope.searchCleanString = function(string){
        
        var str = string.replace(/&amp;|&amp/gi, '');
            str = str.replace("&#039;", "'");
        return str.replace(/[,\/\\#;+'@%!^()$~":*?<>{}]/g, '');

    } 


    $scope.cleanString2 = function(string){ 
        var str = string.replace(/&amp;|&amp/gi, ' & '); 
        str = str.replace("amp", "");
        return str;

    } 

  

    $scope.getPMS = function(code, name){
       // console.log("Eto " + code + name);

            $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/AngularPostQuickView",
                    data: { option: 3, code: code, name: name } 
                }).then(function successCallback(response) { 
                      //console.log(response.data); 
                      $scope.pmsData = response.data;
                      $scope.pmsDataLength = response.data.pmsTables.length;
                      
                     // console.log($scope.pmsDataLength); 
                      var element = angular.element('#PMSmodal'); 
                        element.modal('show');  


                }, function errorCallback(response) {
                    console.log("Error quickview query");
            });   

        
    }
    $scope.countObject = function(obj){
        
            var size = 0, key;
            for (key in obj) {
                if (obj.hasOwnProperty(key)) size++;
            }
            return size; 

    }

    $scope.viewthisImage = function(img, prim, code, i,  random, imgNum){
        $scope.closeQuickView();

       

         

        if(imgNum !== null){
             imgNum = imgNum;
             var elementR = angular.element('.quickviewNewIMG' + prim + ' img' ); 
             elementR.remove();   
             //console.log("THIS ONE "); 
        } 

        if(i > 0){
            var elementZ = angular.element('.zoomspan'  + prim + ' span'  ); 
             elementZ.remove();  
            
             var elementSpanZoom = angular.element('.zoomspan'  + prim   ); 
            
                var htmlx = '<span ng-click="imgZoom('+ prim +', ' + code +', '+ i +', '+ random +' )" class="zoom-plus new-spanzoom" data-toggle="tooltip" data-placement="top" title="High Resolution Image"    >+</span>';

                // Step 1: parse HTML into DOM element
                var templatex = angular.element(htmlx);

                // Step 2: compile the template
                var linkFn = $compile(templatex);

                // Step 3: link the compiled template with the scope.
                var elementx = linkFn($scope);

                // Step 4: Append to DOM (optional)
                elementSpanZoom.append(elementx);
                //console.log("THIS TWO ");
        }

        //$scope.viewImg = true; 
        $scope.codeImg = code;
        $scope.viewImg  = img;
        //$scope.imgx = i;

        var element = angular.element('.quickviewIMG' +  prim); 
        element.css('display', 'none'); 

        var elementX = angular.element('.quickviewNewIMG' +  prim + ' img'  ); 
             elementX.remove();  

        var element2 = angular.element('.quickviewNewIMG' +  prim); 
        element2.css('display', 'block'); 

        

        var imgLoc = $scope.location + "Images/ProductImg/" + $scope.viewImg + "?" +random;
        var svg = angular.element('<img  class="img-fluid removeImg' + i + ' " src=" '+ imgLoc +' " />'); 
        element2.append(svg);

       // console.log(img + "/" +prim + " / " + $scope.imgx + " / " + imgNum)
    }

    $scope.imgZoom = function(prim, code, imgx, random ){
       
        var elementR = angular.element('.popupZoomImg  img' ); 
        elementR.remove();   

        if(imgx == null){
            var imgSrc = $scope.location+ "Images/ProductImg/" +code + "-0.jpg?" + random;
        }else{
            var imgSrc = $scope.location + "Images/ProductImg/" +code + "-" + imgx + ".jpg?" + random;
        }
        var element = angular.element('.popupZoomImg' ); 
        var svg = angular.element('<img  class="img-fluid   " src=" '+ imgSrc +' " />'); 
        element.append(svg);
        
        var elementPop = angular.element('#imgZoomModal'); 
        elementPop.modal('show'); 

    }

    
        //Preview Table
        $scope.previewTable = function(size1, size2, size3, size4 ){
                        var th = '<th class="text-center"> No sizing data </th>'; 
                        var td1= ''; 
                        var th3= ''; 
                        var td4= '';  
                        //Sizing 1
                        if(size1){
                            var size1Array = size1.split(',');
                            //SIze1
                            if(size1Array.length > 0){
                                th = '<thead class="thead-dark"><tr>';
                                for(var tx = 0; tx <= size1Array.length; tx++ ){
                                    if(typeof size1Array[tx] === 'undefined'){
                                        false;
                                    }else{
                                        th  += '<th >' + size1Array[tx] + '</th>';
                                    } 
                                }
                                th += '</tr></thead>'; 
                            }
                        }
                        //Sizing 2
                        if(size2){
                            var size2Array = size2.split(',');
                            if(size2Array.length > 0){ 
                                //SIze2
                                td1 = '<tr>';
                                for(var tx1 = 0; tx1 <= size2Array.length; tx1++ ){
                                    if(typeof size2Array[tx1] === 'undefined'){
                                    false;
                                    }else{
                                        td1  += '<td>' + size2Array[tx1] + '</td>';
                                    } 
                                }
                                td1 += '<tr>';
                            }
                        }

                        //Sizing 3
                        if(size3){
                            var size3Array = size3.split(',');
                            if(size3Array.length > 0){
                                th3 = '<tr>';
                                for(var tx3 = 0; tx3 <= size3Array.length; tx3++ ){
                                    if(typeof size3Array[tx3] === 'undefined'){
                                        false;
                                    }else{
                                        th3  += '<td>' + size3Array[tx3] + '</td>';
                                    } 
                                }
                                th3 += '</tr>';
                            
                            }
                        }

                        //Sizing 4
                        if(size4){
                                var size4Array = size4.split(',');
                                if(size4Array.length > 0){
                            
                                    td4 = '<tr>';
                                    for(var tx4 = 0; tx4 <= size4Array.length; tx4++ ){
                                        if(typeof size2Array[tx4] === 'undefined'){
                                            false;
                                        }else{
                                            td4  += '<td>' + size4Array[tx4] + '</td>';
                                        } 
                                    }
                                    td4 += '<tr>';
                                } 
                        } 
                        $scope.PreviewTableResult =  '<table class="table table-striped table-bordered  small-table-font  table-sm tableSizer"> ' + th + td1 +  th3 + td4 +' </table>';
        }
        //Preview Table 

        $scope.getPopup = function(brand){
           console.log(brand);
           $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/AngularPostQuickView",
                    data: { option: 2, brand: brand } 
                }).then(function successCallback(response) { 
                      console.log(response.data); 
                     var modalID = response.data;
                     var element = angular.element('#'+ modalID +'Modal'); 
                         element.modal('show'); 
                     

                }, function errorCallback(response) {
                    console.log("Error quickview query");
            });          
        }


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

   /************************Switch Accounts **************************************/
   $scope.switchAccount = function(id, userID){
       console.log(id + " / " + userID);

        $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Switchaccount/requestSwitch",
                    data: { option: 1,  id: id, userID: userID   } 
                }).then(function successCallback(response) { 
                        console.log(response.data); 
                        if(response.data == 1){
                            $timeout(function() {
                                var urlDashboard = window.location.href;
                                var separatedArray = urlDashboard.split('?');
                                if(separatedArray[1]=="all=1"){
                                    window.location.href = separatedArray[0];
                                }else{
                                    $window.location.reload();
                                }  
                                
                            }, 600);   
                        }

                }, function errorCallback(response) {
                    console.log("Error switching account");
        });     

   }

   $scope.backtoPrimaryAccount = function(userID){
        $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Switchaccount/requestSwitch",
                    data: { option: 2, userID: userID   } 
                }).then(function successCallback(response) { 
                        console.log(userID);
                        console.log(response.data); 

                        if(response.data == 1){
                            $timeout(function() {
                                
                                var urlDashboard = window.location.href;
                                var separatedArray = urlDashboard.split('?');
                                if(separatedArray[1]=="all=1"){
                                    window.location.href = separatedArray[0];
                                }else{
                                    $window.location.reload();
                                }  

                            }, 600);   
                        }
                         
                }, function errorCallback(response) {
                    console.log("Error switching to primary account");
        });     
   }

 /************************Switch Accounts **************************************/
   
}]); // end controller

 

</script>
        