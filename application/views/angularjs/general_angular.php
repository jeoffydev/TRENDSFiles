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
            
            
            
            
        <?php endif; ?> 
            
        //Select 2 control for dropdowns
        $("#searchcatpopup, #searchbrandpopup, #searchcolourpopup, #searchsortpopup, #searchbrandform, #searchcolourform, #searchsortform").select2(); 
        $( ".nav-item " ).hover(function() { 
            $("#searchcatpopup, #searchbrandpopup, #searchcolourpopup, #searchsortpopup, #searchbrandform, #searchcolourform, #searchsortform").select2("close"); 
        });

       //YOUTUBE STOP EMBED 
       $( "#pause-button" ).on( "click", function() { 
                    $('.video').each(function(){
                        var el_src = $(this).attr("src");
                        $(this).attr("src",el_src);
                    });                 
                                    
		});
 

});

 
/* END JQUERY */



//tgpApp.controller("generalCtrl",function($scope, $http, Upload, $timeout, $window){
tgpApp.controller("generalCtrl",  ['$scope', '$http',  'Upload', '$timeout', '$window', '$sce', '$compile',   function($scope,  $http, Upload, $timeout, $window, $sce, $compile){    

 
    $scope.userName="",$scope.userPassword="",$scope.userBox=!0,$scope.passWord=!1,$scope.errorMessage="Username does not exist",$scope.errorPwMessage="Error: Password does not match",$scope.errorPwMessage2="Error: Your account is currently on hold. Kindly contact info@trends.nz for assistance.",$scope.errorUser=!1,$scope.errorPw=!1,$scope.goodUser=!1,$scope.correct=!1,$scope.skinnedFormData={},$scope.skinnedLoginBtn=!0,$scope.skinnedFormData.themeID=null,$scope.skinnedFormData.customerNumber=null,$scope.errorSkinnedLoginMessage=!1,$scope.skinnedLoginFormTitle="Login",$scope.errorSkinnedForgotMessage=!1,$scope.successSkinnedForgotMessage=!1,$scope.visualFormData={},$scope.visualUpdateBtn=!1,$scope.itemVisualiseActive=!0,$scope.countItemLimit=10,$scope.done=!1,$scope.resetUserPWForm={},$scope.resetMainUserPWForm={},$scope.updateUserPWBtn=!0,$scope.updateUserPW1=!0,$scope.updateUserPW2=!0,$scope.iframeMail=!1,$scope.PreviewTableResult="",$scope.details=!1,$scope.detailsPMS=!1,$scope.viewImg=!1,$scope.codeImg=!1,$scope.imgx=null,$scope.images=!1;
     $scope.location =  '<?=base_url();?>';
     $scope.deleteVisualButton = true;
     $scope.customIDURL = '<?=strtoupper($customArray['customID'])?>';
     $scope.VisualTypeSelect={0:"3D Visual", 1:"2D Visual"}
     $scope.visualFormData.VisualType = $scope.VisualTypeSelect[0];
     $scope.openTabs=!1,$scope.visualFormData.projectName=null,$scope.visualFormData.instructions=null,$scope.hitPromoAPITable=null,$scope.errorEmailForgot=!1,$scope.IEBrowser=!1,$scope.requests={},$scope.visualSubmitted=!1,$scope.resetLogin=function(){$scope.passWord=!1,$scope.errorUser=!1,$scope.userBox=!0,$scope.userName="",$scope.errorPw=""}; 
     $scope.checkUserName = function(username){ $http({ method: "post", url:  "<?php echo base_url();?>Angular/AngularPost", data: { option: 2, username: username } 
            }).then(function successCallback(response) { "1"==response.data?($scope.errorUser=!1,$scope.userName=username,$timeout(function(){$scope.passWord=!0,$scope.userBox=!1},800)):($scope.errorUser=!0,$scope.errorUser=$scope.errorMessage);
            }, function errorCallback(response) { console.log("Error username query"); });     
     } 
     $scope.checkpw = function(pw){ $http({ method: "post", url:  "<?php echo base_url();?>Angular/AngularPost", data: { option: 3, userN: $scope.userName, passW: pw } }).then(function successCallback(response) {
        "1"==response.data&&($scope.passWord=!1,$scope.userBox=!1,$scope.correct=!0,$timeout(function(){$window.location.reload()},600)),"0"==response.data&&($scope.errorPw=!0,$scope.errorPw=$scope.errorPwMessage),"2"==response.data&&($scope.errorPw=!0,$scope.errorPw=$scope.errorPwMessage2);
        }, function errorCallback(response) { console.log("Error pw query"); }); 
     } 
    $scope.logoutUser = function(e){ e.preventDefault(); $http({ method: "post", url:  "<?php echo base_url();?>Angular/AngularPost", data: { option: 4 }  }).then(function successCallback(response) {
        "1"==response.data&&$timeout(function(){$window.location.reload()},600); }, function errorCallback(response) { console.log("Error pw query"); }); 
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
        $http({ method: "post",  url:  "<?php echo base_url();?>Angular/AngularPost", data: { option: 5, opts: opts }  }).then(function successCallback(response) {
                 console.log(response.data);  }, function errorCallback(response) { console.log("Error download query"); }); 
    } 
    $scope.loginSkinnedUser = function(){ 

        <?php if(count($customArray['themeArray']) > 0): ?>
            $scope.skinnedFormData.themeID = <?=$customArray['themeArray'][0]->themeID?>;
            $scope.skinnedFormData.customerNumber = <?=$customArray['themeArray'][0]->CustomerNumber?>;
        <?php endif; ?> 
        $scope.skinnedFormData.option = 6; 
        $http({ method: "post", url:  "<?php echo base_url();?>Angular/AngularPost", data:  $scope.skinnedFormData,  
            }).then(function successCallback(response) {
                1==response.data&&($scope.errorSkinnedLoginMessage=!1,$scope.correct=!0,$timeout(function(){$window.location.reload()},600)),0==response.data&&($scope.errorSkinnedLoginMessage=!0,$scope.errorSkinnedLoginMessage="Username or Password does not match");
            }, function errorCallback(response) { console.log("Error skinned login query"); });  
    } 
    $scope.checkSkinnedLogin=function(n,c){$scope.skinnedLoginBtn=""===n||""===c}; 
    $scope.logoutSkinUser = function(e){ e.preventDefault(); $http({ method: "post", url:  "<?php echo base_url();?>Angular/AngularPost", data: { option: 7 }  }).then(function successCallback(response) {
        "1"==response.data&&$timeout(function(){$window.location.reload()},600);  }, function errorCallback(response) {  console.log("Error pw query"); }); 
    } 
    $scope.skinnedLoginTitle=function(n){$scope.skinnedLoginFormTitle=n};
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
    $scope.itemRequestVisuals=function(s,e){$scope.initiateUserVisuals(s),$scope.getProductColours(e),$scope.visualFormData.productItem=e}; 
    $scope.initiateUserVisuals = function(userID){ $scope.loadingEffects=!0,$scope.visualUpdateBtn=!1,$scope.visualFormData.projectName=null,$scope.visualFormData.instructions=null; 
            $scope.visualFormData.VisualType = $scope.VisualTypeSelect[0];   
            $http({  method: "post", url:  "<?php echo base_url();?>Angular/AngularPost", data: { option: 9, userID: userID }  }).then(function successCallback(response) { 
                    $scope.loadingEffects=!1,$scope.userVisualFiles=null,$scope.userVisualRequests=null,$scope.userID=userID,$scope.countItem=0,0!==response.data.visualRequests&&($scope.countItem=$scope.objectLength(response.data.visualRequests),$scope.countItem>=$scope.countItemLimit&&($scope.itemVisualiseActive=!1),$scope.userVisualRequests=response.data.visualRequests,$scope.visualFormData.projectName=response.data.visualRequests[0].projectName,$scope.visualFormData.instructions=response.data.visualRequests[0].instructions,$scope.visualUpdateBtn=!0),0!==response.data.visualFiles&&($scope.userVisualFiles=response.data.visualFiles),$scope.userVisualItems=response.data.visualProductVisualLists;
                }, function errorCallback(response) { console.log("Error visual query"); });     
    } 
    $scope.getProductColoursVisual = function(itemCode, itemCols, id){ 
            var elementy=angular.element(".alertitemcolour");elementy.css("display","none");var elementx=angular.element(".alertbrandingcolour");elementx.css("display","none");var element=angular.element(".itemcolour_"+id);element.css("display","block");
            
            $http({ method: "post", url:  "<?php echo base_url();?>Angular/AngularPost", data: { option: 12, itemCode: itemCode }  }).then(function successCallback(response) {
                if(response.data.length>0){$scope.availableColoursR=response.data[0].Colours.split(",");for(var countR=$scope.availableColoursR.length-1,x=0;x<=countR;x++)$scope.findVal=$scope.availableColoursR[x].replace(/^\s/g,""),$scope.findVal==itemCols&&($scope.itemColsRight=$scope.availableColoursR[x]);$scope.availableColoursR&&($scope.availableColoursVisual=$scope.availableColoursR)}
                 }, function errorCallback(response) { console.log("Error visual query"); });  
    } 
   $scope.updateThisItemVisual=function(e,a,l){$scope.updateThisItem(e,a,l),$scope.availableColoursVisual=!1,angular.element("#itemCols_"+e).val(l),angular.element(".alertitemcolour").css("display","none")};

    $scope.getProductColoursBranding = function(itemCode, itemCols, id){
        var elementx=angular.element(".alertbrandingcolour");elementx.css("display","none");var elementy=angular.element(".alertitemcolour");elementy.css("display","none");var element=angular.element(".brandingcolour_"+id);element.css("display","block");
        $scope.newBrandingVisualize = [];
            $http({ method: "post",  url:  "<?php echo base_url();?>Angular/AngularPost", data: { option: 12, itemCode: itemCode }  }).then(function successCallback(response) {
                if(response.data.length>0){ $scope.newBrandingVisualize = response.data[0].FinalBranding; var printType1=response.data[0].PrintType1,printType2=response.data[0].PrintType2,printType3=response.data[0].PrintType3,printType4=response.data[0].PrintType4,printType5=response.data[0].PrintType5,printType6=response.data[0].PrintType6,printType7=response.data[0].PrintType7,printType8=response.data[0].PrintType8,printType9=response.data[0].PrintType9,printType10=response.data[0].PrintType10,PrintDescription1=response.data[0].PrintDescription1,PrintDescription2=response.data[0].PrintDescription2,PrintDescription3=response.data[0].PrintDescription3,PrintDescription4=response.data[0].PrintDescription4,PrintDescription5=response.data[0].PrintDescription5,PrintDescription6=response.data[0].PrintDescription6,PrintDescription7=response.data[0].PrintDescription7,PrintDescription8=response.data[0].PrintDescription8,PrintDescription9=response.data[0].PrintDescription9,PrintDescription10=response.data[0].PrintDescription10,availableBrandingOptionArray={0:{pt:printType1,pd:PrintDescription1},1:{pt:printType2,pd:PrintDescription2},2:{pt:printType3,pd:PrintDescription3},3:{pt:printType4,pd:PrintDescription4},4:{pt:printType5,pd:PrintDescription5},5:{pt:printType6,pd:PrintDescription6},6:{pt:printType7,pd:PrintDescription7},7:{pt:printType8,pd:PrintDescription8},8:{pt:printType9,pd:PrintDescription9},9:{pt:printType10,pd:PrintDescription10}},arrBranding=[];Object.keys(availableBrandingOptionArray).forEach(function(i){availableBrandingOptionArray[i].pt&&(newArray=availableBrandingOptionArray[i].pt+": "+$scope.cleanString2(availableBrandingOptionArray[i].pd),arrBranding.push(newArray))}),$scope.availableBrandingOptionVisuals=arrBranding}
                }, function errorCallback(response) { console.log("Error visual query"); });  
    }
    $scope.updateThisItemBranding=function(a,e,n){$scope.updateThisItem(a,e,n),$scope.availableBrandingOptionVisuals=!1,angular.element("#printOpt_"+a).val(n),angular.element(".alertbrandingcolour").css("display","none")};
    $scope.closeVisualDropdownOption=function(){angular.element(".alertbrandingcolour").css("display","none"),angular.element(".alertitemcolour").css("display","none")};
    $scope.getProductColours = function(itemCode){  $http({ method: "post", url:  "<?php echo base_url();?>Angular/AngularPost", data: { option: 12, itemCode: itemCode }  }).then(function successCallback(response) {
        //console.log("Response ===> ");  console.log(response.data); 
        $scope.newBranding = response.data[0].FinalBranding;
        //$scope.visualFormData.BrandingOption = response.data[0].FinalBranding[0];
        if(response.data.length>0){$scope.availableColours=response.data[0].Colours.split(","),$scope.availableColours&&($scope.visualFormData.ItemColour=$scope.availableColours[0]);var printType1=response.data[0].PrintType1,printType2=response.data[0].PrintType2,printType3=response.data[0].PrintType3,printType4=response.data[0].PrintType4,printType5=response.data[0].PrintType5,printType6=response.data[0].PrintType6,printType7=response.data[0].PrintType7,printType8=response.data[0].PrintType8,printType9=response.data[0].PrintType9,printType10=response.data[0].PrintType10,PrintDescription1=response.data[0].PrintDescription1,PrintDescription2=response.data[0].PrintDescription2,PrintDescription3=response.data[0].PrintDescription3,PrintDescription4=response.data[0].PrintDescription4,PrintDescription5=response.data[0].PrintDescription5,PrintDescription6=response.data[0].PrintDescription6,PrintDescription7=response.data[0].PrintDescription7,PrintDescription8=response.data[0].PrintDescription8,PrintDescription9=response.data[0].PrintDescription9,PrintDescription10=response.data[0].PrintDescription10,availableBrandingOptionArray={0:{pt:printType1,pd:PrintDescription1},1:{pt:printType2,pd:PrintDescription2},2:{pt:printType3,pd:PrintDescription3},3:{pt:printType4,pd:PrintDescription4},4:{pt:printType5,pd:PrintDescription5},5:{pt:printType6,pd:PrintDescription6},6:{pt:printType7,pd:PrintDescription7},7:{pt:printType8,pd:PrintDescription8},8:{pt:printType9,pd:PrintDescription9},9:{pt:printType10,pd:PrintDescription10}},arrBranding=[];Object.keys(availableBrandingOptionArray).forEach(function(i){availableBrandingOptionArray[i].pt&&(newArray=availableBrandingOptionArray[i].pt+": "+$scope.cleanString2(availableBrandingOptionArray[i].pd),arrBranding.push(newArray))}),$scope.availableBrandingOption=arrBranding,$scope.availableBrandingOption&&($scope.visualFormData.BrandingOption=arrBranding[0])}else $scope.availableColours=!1,$scope.availableBrandingOption=!1;
               }, function errorCallback(response) { console.log("Error visual query"); });     
    } 
    $scope.objectLength=function(r){var n=0;for(var e in r)r.hasOwnProperty(e)&&n++;return n}; 
    $scope.addVisualItem = function(userID){ 
            if(userID){
                $scope.visualFormData.userID=userID,$scope.visualFormData.option=13,$scope.visualFormData.ItemInstructions||($scope.visualFormData.ItemInstructions=null);
                 $http({ method: "post",  url:  "<?php echo base_url();?>Angular/AngularPost", data:  $scope.visualFormData   }).then(function successCallback(response) { 
                    $scope.storeVisualTemp = $scope.visualFormData.VisualType;
                    $scope.visualFormData={},$scope.initiateUserVisuals(userID),$scope.done=!0,$scope.availableColours=!1,$scope.availableBrandingOption=!1,$timeout(function(){$scope.done=!1},2e3);
                    $scope.visualFormData.VisualType = $scope.setVisualType($scope.storeVisualTemp);
                }, function errorCallback(response) { console.log("Error  visual insert query"); });  
            }    
    } 
    $scope.setVisualType = function(visual){
        
        var results;
        if(visual == $scope.VisualTypeSelect[0]){
            results = $scope.VisualTypeSelect[0]; 
        }else{
            results = $scope.VisualTypeSelect[1]; 
        }

        return results;
       
    }
    $scope.deleteArtwork= function(userID,  visualFiles, ind){
        if (confirm("Are you sure you want to delete this image?")) {  
             $http({ method: "post", url:  "<?php echo base_url();?>Angular/AngularPost", data: { option: 10, userID: userID, visualFiles: visualFiles }  }).then(function successCallback(response) { 
                if(1==response.data.deleted){0==response.data.countFiles&&($scope.userVisualFiles=null);var element=angular.element("#artworkFile_"+ind);element.css("background-color","#c82333"),$timeout(function(){angular.element("#artworkFile_"+ind).css("display","none")},1e3)}
                }, function errorCallback(response) { console.log("Error delete files visual query"); });    
        }
    } 
    $scope.deleteItems= function(uid, ind){
       
        if (confirm("Are you sure you want to delete this item?")) {  
            //console.log(uid);
            $scope.deleteVisualButton = false;
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
            $http({ method: "post", url:  "<?php echo base_url();?>Angular/AngularPost", data: { option: 11, projectName: projectName, instructions:instructions, userID: $scope.userID }  }).then(function successCallback(response) { 
                if(1==response.data){var element=angular.element(".projectInputs");element.css("border","2px solid  #28a745"),$timeout(function(){angular.element(".projectInputs").css("border","1px solid #ced4da")},2e3)}
                }, function errorCallback(response) { console.log("Error delete files visual query"); });    
    } 
    $scope.uploadArtwork = function(projName, projDesc, userID, file){ 
                    $scope.tempVisual = $scope.visualFormData.VisualType;
                    if(file){  file.upload = Upload.upload({ url:  "<?php echo base_url();?>Angular/AngularPost", data: {option: 12, userID: userID, file: file }, }); 
                                file.upload.then(function(e){1==e.data&&($scope.initiateUserVisuals(userID), $scope.visualFormData.VisualType=$scope.setVisualType($scope.tempVisual),$scope.visualFormData.projectName=projName,$scope.visualFormData.instructions=projDesc,$scope.done=!0,$timeout(function(){$scope.done=!1},2e3))},function(e){e.status>0&&($scope.errorMsg=e.status+": "+e.data)});
                    }  
    } 
    $scope.updateThisItem = function(uid, cols, details){
          $http({ method: "post", url:  "<?php echo base_url();?>Angular/AngularPost",  data: { option: 15, uid: uid, cols: cols, details: details }  }).then(function successCallback(response) { 
            if(1==response.data){var element=angular.element("."+cols+uid);element.css("display","inline-block"),$timeout(function(){angular.element("."+cols+uid).css("display","none")},2e3)}
            }, function errorCallback(response) { console.log("Error delete files visual query"); });    
    }
    
    $scope.sendToEmail = function(userID){ if (confirm("This will send to Trends Visualisation Request. Click OK to continue.")) {   
        $scope.visualFormData.CustomerNumber = '<?=$siteLogcheck['userDatas'][0]->CustomerNumber?>';
        
        $http({ method: "post", url:  "<?php echo base_url();?>Angular/AngularPost", data: { option: 16,  userID: userID, visualForm: $scope.visualFormData  } 
                }).then(function successCallback(response) { //console.log(response.data);
                    1==response.data&&($scope.initiateUserVisuals(userID),$scope.done=!0,$timeout(function(){$scope.done=!1,$scope.visualSubmitted=!0},2e3)); 
                }, function errorCallback(response) { console.log("Error userID email visual query"); });     }
    }
    $scope.hideVisualSuccess=function(){$scope.visualSubmitted=!1}; 
    $scope.checkOldPW = function(oldpw){
        if(oldpw){ $scope.resetUserPWForm['userID'] = '<?=$siteLogcheck['userDatas'][0]->userID?>'; $scope.resetUserPWForm['seaSalt'] = '<?=$siteLogcheck['userDatas'][0]->userSalt?>'; $scope.resetUserPWForm['userEmail'] = '<?=$siteLogcheck['userDatas'][0]->userEmail?>'; $scope.resetUserPWForm.oldpw = oldpw; $scope.resetUserPWForm.option = 17;
            $http({ method: "post", url:  "<?php echo base_url();?>Angular/AngularPost", data: $scope.resetUserPWForm  }).then(function successCallback(response) { 
                1==response.data&&($scope.oldPWMsg='<i class="fa fa-check  check"></i> ',$scope.updateUserPW1=!1,$scope.updateUserPW2=!1),2==response.data&&($scope.oldPWMsg="old passwords didnt match",$scope.updateUserPW1=!0,$scope.updateUserPW2=!0),0==response.data&&(alert("Please contact Web Admin to reset your password"),$scope.updateUserPW1=!0,$scope.updateUserPW2=!0); 
                }, function errorCallback(response) { console.log("Error old password query"); });   
        }   
    }
    $scope.checkNewPW=function(e,s){e!==s?($scope.userResetPWMsg="Password doesn't match",$scope.updateUserPWBtn=!0):($scope.userResetPWMsg=!1,$scope.updateUserPWBtn=!1)}; 
    $scope.resetUserPW = function(userID){  $scope.resetUserPWForm.option = 18;  $http({ method: "post", url:  "<?php echo base_url();?>Angular/AngularPost", data: $scope.resetUserPWForm   }).then(function successCallback(response) { 
                console.log(response.data),1==response.data&&($scope.correct=!0,$timeout(function(){$window.location.reload()},600));
                }, function errorCallback(response) { console.log("Error update user password query"); });      
    }

    $scope.resetMainUserPW = function(userID, userHash){  $scope.resetMainUserPWForm.userHash = userHash; $scope.resetMainUserPWForm.option=20,$scope.resetMainUserPWForm.userID=userID; $http({ method:"post",url:"<?php echo base_url();?>Angular/AngularPost", data: $scope.resetMainUserPWForm
                }).then(function successCallback(response) {   if($scope.resetMainUserPWForm={},1==response.data){$scope.successMsg="Password updated. Please login  to continue to the website.";var element=angular.element("#successModal");element.modal("show"),$timeout(function(){url="/",window.location.href=url},2e3)} 
                }, function errorCallback(response) { console.log("Error update user password query"); });        
    }
    $scope.mailingList=function(){$scope.iframeMail=!0};
    /* Search Angularjs */
    var vm=this;vm.disabled=void 0,vm.searchEnabled=void 0,vm.setInputFocus=function(){$scope.$broadcast("UiSelectDemo1")},vm.enable=function(){vm.disabled=!1},vm.disable=function(){vm.disabled=!0},vm.enableSearch=function(){vm.searchEnabled=!0},vm.disableSearch=function(){vm.searchEnabled=!1}; 
    $scope.hitEnter = function(code, optin, ref){var url,ref=ref||"";if(0==optin){var newcode=angular.element("#myvalsearch").val();url="/category/products"+ref+"?"+newcode}1==optin&&(url="/item/"+code+ref),2==optin&&(url="/category/"+code+ref),3==optin&&(url="/searchColours/"+code+ref),window.location.href=url; }
    $scope.notFoundEnter=function(o){var c=$scope.customIDURL;o&&(url="/category/products"+c+"?"+o,window.location.href=url)}; 
    $scope.triggerSearch = function(){  $scope.stateForm = false;  vm.allproductSearch  = <?=json_encode($searchResults);?>;   }
    $scope.getQuickViewContainer=function(n,e){angular.element(".hovericons-container").css("display","none"),angular.element(".hovericons-container"+e).css("display","block")};
    $scope.hovercontainerLeave=function(){$scope.closeQuickView()};
    $scope.closeQuickView=function(){angular.element(".hovericons-container").css("display","none"),$scope.details=!1,$scope.detailsPMS=!1,$scope.stocks=!1,$scope.branding=!1,$scope.pricing=!1,$scope.images=!1};
    $scope.getQuickViewData= function(opts, prim, code, from){ var from = from || ""; 
        <?php 
        /* On mobile allow to open multiple accordion */ 
			if($this->general_model->mobileDetector() == 0){  
				$mobile = 0;
			}else{
				$mobile = 1;
			} 
            if($mobile == 0): 
        ?>  $scope.closeQuickView();  <?php endif; ?>
        $scope.packagingCalc = false;
         $http({ method: "post", url:  "<?php echo base_url();?>Angular/AngularPostQuickView",  data: { option: 1, opts: opts,  prim: prim, code:code, loginUser:'<?=$siteLogcheck['loggedIn']?>',  skinnedSite: '<?=count($customArray['themeArray'])?>', skinned:  '<?=$customID?>', from: from }  }).then(function successCallback(response) { 
             //console.log("Response++++");console.log(response.data); 
            var element=angular.element(".hovericons-container"+prim+"_"+from);if(element.css("display","block"),$scope.openTabs=!0,"details"==opts){$scope.details=!0,$scope.details=response.data.itemDetails;var ua=window.navigator.userAgent,msie=ua.indexOf("MSIE ");if((msie>0||navigator.userAgent.match(/Trident.*rv\:11\./))&&($scope.IEBrowser=!0),$scope.details[0].PrintType1&&($scope.details[0].PrintDescription1=$scope.cleanString2(response.data.itemDetails[0].PrintDescription1)),$scope.details[0].PrintType2&&($scope.details[0].PrintDescription2=$scope.cleanString2(response.data.itemDetails[0].PrintDescription2)),$scope.details[0].PrintType3&&($scope.details[0].PrintDescription3=$scope.cleanString2(response.data.itemDetails[0].PrintDescription3)),$scope.details[0].PrintType4&&($scope.details[0].PrintDescription4=$scope.cleanString2(response.data.itemDetails[0].PrintDescription4)),$scope.details[0].PrintType5&&($scope.details[0].PrintDescription5=$scope.cleanString2(response.data.itemDetails[0].PrintDescription5)),$scope.details[0].PrintType6&&($scope.details[0].PrintDescription6=$scope.cleanString2(response.data.itemDetails[0].PrintDescription6)),$scope.details[0].PrintType7&&($scope.details[0].PrintDescription7=$scope.cleanString2(response.data.itemDetails[0].PrintDescription7)),$scope.details[0].PrintType8&&($scope.details[0].PrintDescription8=$scope.cleanString2(response.data.itemDetails[0].PrintDescription8)),$scope.details[0].PrintType9&&($scope.details[0].PrintDescription9=$scope.cleanString2(response.data.itemDetails[0].PrintDescription9)),$scope.details[0].PrintType10&&($scope.details[0].PrintDescription10=$scope.cleanString2(response.data.itemDetails[0].PrintDescription10)),$scope.details[0].Description=$scope.cleanString(response.data.itemDetails[0].Description),null!=response.data.PMSColours?$scope.detailsPMS=response.data.PMSColours:$scope.detailsPMS=!1,$scope.previewTable(response.data.itemDetails[0].sizingLine1,response.data.itemDetails[0].sizingLine2,response.data.itemDetails[0].sizingLine3,response.data.itemDetails[0].sizingLine4),$scope.cL=response.data.itemDetails[0].cartonLength,$scope.cW=response.data.itemDetails[0].cartonWidth,$scope.cH=response.data.itemDetails[0].cartonHeight,$scope.cQ=response.data.itemDetails[0].cartonQuantity,$scope.cWt=response.data.itemDetails[0].cartonWeight,response.data.itemDetails[0].Packing&&($scope.packagingCalc=!0),0!==$scope.$cL&&0!==$scope.$cW&&0!==$scope.cH){var roundOff=$scope.cL*$scope.cW*$scope.cH;$scope.totalCartonCube=(Math.round(roundOff)/1e6).toFixed(2),$scope.cartonWt=$scope.cWt+0}}"stock"==opts&&($scope.stocks=!0,$scope.stocks=response.data),"pricing"==opts&&($scope.pricing=!0,$scope.pricing=response.data),"images"==opts&&($scope.images=!0,$scope.images=response.data);
            }, function errorCallback(response) { console.log("Error quickview query");  });   
    }
    $scope.addUnderline=function(o){return["Embossing","Colour Fill","Colour Over Print","Debossed"].includes(o)?o:"<u class='cursorpoint'>"+o+"</u>"};
    $scope.removeSpacing=function(e){return e.trim()};
    $scope.checkSpecChar=function(e){$scope.newSearchValue=$scope.searchCleanString(e),angular.element("#searchInputID").val($scope.newSearchValue);var n=e.length,a=angular.element(".open .dropdown-menusearch");n>=3?a.css("visibility","visible"):a.css("visibility","hidden")};
    $scope.checkSearch=function(e){angular.element(".open .dropdown-menusearch").css("visibility","hidden"),$scope.checkSpecChar(e)};
    $scope.cleanString=function(e){var a=e.replace(/&amp;|&amp/gi,"");return(a=a.replace("&#039;","'")).replace(/[&\\\;$~:*?<>{}]/g,"")};
    $scope.searchCleanString=function(e){var a=e.replace(/&amp;|&amp/gi,"");return(a=a.replace("&#039;","'")).replace(/[,\/\\#;+'@%!^()$~":*?<>{}]/g,"")};
    $scope.cleanString2=function(a){ if(a){ var e=a.replace(/&amp;|&amp/gi," & ");return e=e.replace("amp","") }else{ return null;} }; 
    $scope.getPMS = function(code, name){  $http({ method: "post", url:  "<?php echo base_url();?>Angular/AngularPostQuickView", data: { option: 3, code: code, name: name }  }).then(function successCallback(response) { 
                $scope.pmsData=response.data,$scope.pmsDataLength=response.data.pmsTables.length;var element=angular.element("#PMSmodal");element.modal("show");
                }, function errorCallback(response) { console.log("Error quickview query"); });   
    }
    $scope.countObject=function(n){var r,o=0;for(r in n)n.hasOwnProperty(r)&&o++;return o}; 
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
        $scope.getPopup = function(brand){ $http({ method: "post", url:  "<?php echo base_url();?>Angular/AngularPostQuickView", data: { option: 2, brand: brand }  }).then(function successCallback(response) { 
                console.log(response.data);var modalID=response.data,element=angular.element("#"+modalID+"Modal");element.modal("show"); }, function errorCallback(response) { console.log("Error quickview query"); });          
        }


        /* Footer next */
<?php if(count($customArray['themeArray']) == 0 || $siteLogcheck['loggedIn'] == 1): ?>  
$scope.favourites=!1,$scope.viewed=!1,$scope.footerBox=function(o){"favourites"==o&&($scope.favourites=!0)},$scope.footerBoxLeave=function(){$scope.favourites=!1,$scope.viewed=!1},$scope.open=!1,$scope.openTwo=!1,$scope.openFav=function(){$scope.openTwo=!1,$scope.open=!0},$scope.closeFav=function(){$scope.open=!1,$scope.openTwo=!1},$scope.openView=function(){$scope.open=!1,$scope.openTwo=!0},$scope.closeView=function(){$scope.openTwo=!1,$scope.open=!1};
$scope.favMinus=0,$scope.favPlus=0;
$scope.addFavourite = function(userID, Code){ $http({method: "post",url:  "<?php echo base_url();?>Angular/FavouriteItem",data: {option: 2, userID: userID, Code: Code}}).then(function successCallback(responseFav) {  
    console.log(responseFav.data),1==responseFav.data&&($scope.favPlus=0,$scope.callDefaultSlider(),$scope.userFavourites(userID),$scope.checkFavourite(userID,Code)); }, function errorCallback(responseFav) {  console.log("Error retrieving the Add Fav ");});     }
$scope.removeFavourite = function(userID, Code){ $http({method: "post",url:"<?php echo base_url();?>Angular/FavouriteItem",data: {option: 3, userID: userID, Code: Code}}).then(function successCallback(responseFav) {  
    console.log(responseFav.data),1==responseFav.data&&($scope.favMinus=0,$scope.callDefaultSlider(),$scope.userFavourites(userID),$scope.checkFavourite(userID,Code)); }, function errorCallback(responseFav) { console.log("Error retrieving the Add Fav ");});     }
$scope.removeFavouritePage = function(prim, code, userID){$http({method: "post",url:  "<?php echo base_url();?>Angular/<?php echo $angularFile; ?>AngularPost",data: { option: 1, code: code, userID: userID } }).then(function successCallback(response) {
    response.data&&($scope.callDefaultSlider(),$scope.userFavourites(userID),$timeout(function(){angular.element("#removeFavourite"+prim).css("display","none")},500));}, function errorCallback(response) {console.log("Error Remove Favourite data");});     }
$scope.checkFavourite = function(userID, Code){$http({method: "post",url:  "<?php echo base_url();?>Angular/FavouriteItem",data: {option: 1, userID: userID, Code: Code}}).then(function successCallback(response) {   
    "1"==response.data?($scope.favMinus=1,$scope.favPlus=0):($scope.favPlus=1,$scope.favMinus=0);}, function errorCallback(response) { console.log("Error retrieving the check Fav ");});}
$scope.favsLength=0,$scope.favouritesSlider=0,$scope.dataLoaded=!1,$scope.footerLoading=!1;
$scope.callDefaultSlider=function(){$scope.favsLength=0,$scope.favouritesSlider=0,$scope.dataLoaded=!1,$scope.footerLoading=!1};
$scope.userFavourites = function(userID){$http({method: "post",url:"<?php echo base_url();?>Angular/favouritesAngularPost",data: { option: 2, userID: userID,   avail:'<?=$checkAvailCountry?>', custom: '<?=$customID?>' } }).then(function successCallback(response) { 
    $scope.favouritesSlider=!1,$scope.footerLoading=!0,"null"==response.data||null==response.data||0==response.data?($scope.myFavouriteItems=0,$scope.favouritesSlider=0,$scope.dataLoaded=!1,$scope.footerLoading=!1):($timeout(function(){$scope.favouritesSlider=response.data,$scope.dataLoaded=!0,$scope.footerLoading=!1},2e3),$scope.favsLength=response.data.length,console.log("Favsxx = "+$scope.favsLength));}, function errorCallback(response) { console.log("Error favourite initiate query");});          }
<?php endif; ?>  
/* Menus */
$scope.menuClicked=!0,$scope.closeMenus=function(){$scope.menuClicked=!0,angular.element(".main-menus").css("visibility","hidden")};
//run default 
$scope.openMainMenu = function(opts, mens){
    $scope.stateForm=!1,$scope.closeMenus();var element=angular.element("."+opts);element.css("visibility","visible"),$scope.menuClicked=!1,element.addClass("open_"+opts),element.hasClass("open_"+opts)&&0==mens&&(element.removeClass("open_"+opts),element.css("visibility","hidden"),$scope.closeMenus());     
}
var _menutimeout; 
$scope.openMainMenuHover = function(opts, mens){
    $scope.closeMenus(),$scope.stateForm=!1,_menutimeout&&$timeout.cancel(_menutimeout),_menutimeout=$timeout(function(){angular.element("."+opts).css("visibility","visible"),_menutimeout=null},300);
} 
$scope.stopMenu=function(){_menutimeout&&$timeout.cancel(_menutimeout)};
$scope.hideSearchPopup = function(){ $scope.stateForm = false;   } 
$scope.hoverOut = function(){   $scope.closeMenus();  } 
$scope.resetMenu = function(){  $scope.menuClicked = true;  } 
$scope.toggleSearchForm = function () { $scope.stateForm = !$scope.stateForm; };  
$window.onclick = function (event) { $scope.closeMenus();  $scope.$apply(); };
$scope.searchAdvanceFormPopup = {};
$scope.searchAdvanceFormPopup.range = { from: 0, to: 200 };
$scope.maxx = 200; 
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
} 
$scope.toggleFullNameItemMouseleave = function (){
    var element = angular.element('.tooltip-alternative');  
        element.css('visibility', 'hidden');  
} 
$scope.toggleIcons = function (prim, colors) {
    // console.log(prim + colors);
    var colors = colors || "";
    var element = angular.element('.tooltipicon-'+ prim + colors);  
        element.css('visibility', 'visible');  
} 
$scope.toggleIconsMouseleave = function (){
    var element = angular.element('.tooltip-alternativeicon');  
        element.css('visibility', 'hidden');  
} 
    $scope.closeTheCollapse=function(e){angular.element("#"+e).removeClass("show")}; var _timeout;
   $scope.getHitPromoAPI = function(hitPromoAPIs, hitCode){ if(hitPromoAPIs != 0){ if(_timeout) { $timeout.cancel(_timeout); } _timeout = $timeout(function() {$http({ method: "post", url:  "<?php echo base_url();?>Angular/HitPromoAngularPost", data: { option:1,hitPromoAPIs:hitPromoAPIs,hitCode:hitCode}}).then(function successCallback(response) {$scope.hitPromoAPITable = response.data; }, function errorCallback(response) { console.log("Error getting Hit API query"); });_timeout = null; },  100);  } } 
   $scope.searchHoverForm=function(){$scope.searchHoverTrigger()};
   $scope.searchHoverFormOut=function(){$scope.searchHoverTrigger()};
   $scope.searchHoverTrigger=function(){var e=angular.element(".select2-container"),i=angular.element(".item-card .hover-icons");e.hasClass("select2-container--open")?i.css("visibility","hidden"):i.css("visibility","visible")};
   $scope.switchAccount = function(id, userID){ $http({ method: "post", url:  "<?php echo base_url();?>Switchaccount/requestSwitch", data: { option: 1,  id: id, userID: userID   } }).then(function successCallback(response) {  1==response.data&&$timeout(function(){var o=window.location.href.split("?");"all=1"==o[1]?window.location.href=o[0]:$window.location.reload()},600);
                 }, function errorCallback(response) { console.log("Error switching account"); });       } 
   $scope.backtoPrimaryAccount = function(userID){ $http({method: "post",url:"<?php echo base_url();?>Switchaccount/requestSwitch",data:{option:2,userID:userID}}).then(function successCallback(response) { 
            1==response.data&&$timeout(function(){var o=window.location.href.split("?");"all=1"==o[1]?window.location.href=o[0]:$window.location.reload()},600);    
                }, function errorCallback(response) { console.log("Error switching to primary account"); });      }

 /************************Switch Accounts **************************************/


 	//Site wide image zooming
	$scope.imgZoom = function(itemCode, activeSlide){

		activeSlide = activeSlide || 0;

		//Pull in image data for this item
		let data = { itemCode: itemCode };
		let url = '/item/image-data/' + itemCode;

		$scope.imgZoomData = {
			initialSlide: activeSlide,
			data: {}
		};

		//Request item image data
		$http
			.get(url, {data: data})
			.then(function successCallback(response) {

				$scope.imgZoomData.data = response.data;

				$('#imgZoomModal').modal('show');

			}, function errorCallback(response) {

				console.log('Error retrieving the image data for item: '+ itemCode);
				console.log(response);

			});

		//Post image modal show actions
		$('#imgZoomModal').on('shown.bs.modal', function(){

			//Focusing on navigation makes arrow keys work straight away
			$('#image-zoom-carousel .carousel-control-next').focus();

		});

	}

	$scope.viewImageInCard = function(img, prim, code, i,  random, imgNum){

		$scope.closeQuickView();

		if(imgNum !== null){
			imgNum = imgNum;
			var elementR = angular.element('.quickviewNewIMG' + prim + ' img' );
			elementR.remove();
			//console.log("THIS ONE ");
		}

		// if(i > 0){
			var elementZ = angular.element('.zoomspan'  + prim + ' span'  );
			elementZ.remove();

			var elementSpanZoom = angular.element('.zoomspan'  + prim   );

			var htmlx = '<span ng-click="imgZoom(' + code +', '+ i +')" class="zoom-plus new-spanzoom" data-toggle="tooltip" data-placement="top" title="High Resolution Image">+</span>';

			// Step 1: parse HTML into DOM element
			var templatex = angular.element(htmlx);

			// Step 2: compile the template
			var linkFn = $compile(templatex);

			// Step 3: link the compiled template with the scope.
			var elementx = linkFn($scope);

			// Step 4: Append to DOM (optional)
			elementSpanZoom.append(elementx);
			//console.log("THIS TWO ");
		// }

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

}]); // end controller

</script>
