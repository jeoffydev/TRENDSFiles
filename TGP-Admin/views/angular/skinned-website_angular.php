
<?php

$sql= getCustomerData($table); 
 
$json_data=array();
foreach($sql as $rec)//foreach loop  
{  
  $json_array['CustomerNumber']=$rec['CustomerNumber']; 
  //$json_array['Currency']=$rec['Currency'];  
  $json_array['CustomerName']= $rec['CustomerName']; 
  //$json_array['ThemedSiteMax']=$rec['ThemedSiteMax']; 
  
  $csr = explode('@', $rec['CSR']);  
  $json_array['CSR']=$csr[0]; 
  if($rec['CustomerOnHold'] == 'N'){
      $CustomerOnHold = 'No';
  }else{
    $CustomerOnHold = 'Yes';
  }
  $json_array['CustomerOnHold'] = $CustomerOnHold;
  array_push($json_data,$json_array);
} 
$customerData = json_encode($json_data,JSON_PRETTY_PRINT); 

$baseUrlDomain = substr($baseUrl, 0, -9);

$randNum = rand();

function clean($string) { 
    return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
}
?>

<script>
// Define the `phonecatApp` module

tgpApp.controller("editCtrl",  ['$scope', '$http',  'Upload', '$timeout', '$window',  function($scope, $http, Upload, $timeout, $window){  
//tgpApp.controller("editCtrl",function($scope, $http, $window, $timeout){

  $scope.query = {}
  $scope.queryBy = '$'
  $scope.customers = <?php echo $customerData; ?>; 
  $scope.orderProp="CustomerName";  
  $scope.userAdminEmail = '<?php echo $userEmail; ?>'; 
  $scope.baseURL = '<?php echo $baseUrlDomain; ?>';
  $scope.bannerNewForm = {};
  $scope.selectDropdown = {0:"No", 1:"Yes"}; 
  $scope.selectPopup = {0:"Current Window", 1:"Open in Pop Up", 2: "Open in New Window"};
  $scope.bannerNewForm.bannerSkinnedSite = false;
  $scope.bannerSkinnedSiteForm = false;
  
  //console.log($scope.baseURL);

  $scope.selectCustomer = function(customerNumber, customerName, opts) {    
      //console.log(customerNumber); 
      var opts = opts || null;

      $http({
          method: "post",
          url:  "<?php  echo $angularPost; ?>",
          data: {
            customerNumber: customerNumber, 
              option: 1, 
          },
      }).then(function successCallback(response) { 
            console.log(response.data);  

            $scope.clearTableBG();

            //Back to default
            if(!opts){
                $scope.formDisabled = true;
            } 
            $scope.ThemeLoops = {};
            $scope.themeUrl = '';
            $scope.LogoLink = '';
            $scope.FaviconLink = '';
            $scope.OGImageLink = '';
            $scope.MobileLogoLink = '';

            //Result select company
            $scope.disabledThemeAddField = true;

            $scope.formData = {};

            $scope.customerName = customerName;
            $scope.customerNumber = customerNumber;
            var themelimit = response.data.ThemedSiteMax;

            var myObject = response.data;
            delete myObject.ThemedSiteMax;

            //console.log(myObject);  

            $scope.lists = myObject;  
                
            
            var listCount =  Object.keys(myObject).length;
            
            $scope.displayListCount = listCount;
            $scope.displayThemelimit = themelimit;
            
            if(themelimit <=  listCount){
                $scope.disabledThemeAddField = false;
            }
            //Result select company


            //Add new theme site
            $scope.addnewThemeForm = function(){
                //console.log('Eto ang form');
                $scope.formDisabled = false;
                //console.log($scope.formData);
                $scope.formData.option = 3;
                $scope.formData.customerNum = $scope.customerNumber;
                $http({
                    method: "post",
                    url:  "<?php  echo $angularPost; ?>",
                    data:  $scope.formData,  
                }).then(function successCallback(responseAddTheme) { 
                        console.log(responseAddTheme.data);
                        $scope.selectCustomer(customerNumber, customerName, 1);

                        //Refresh the new added theme 
                        $scope.selectTheme(responseAddTheme.data);
                        

                }, function errorCallback(responseAddTheme) {
                    alert("Error retrieving the data from responseTheme");
                });           
            }
            
           

            

              
             

      }, function errorCallback(response) {
          alert("Error retrieving the data");
      });
}

 //Select theme site
$scope.selectTheme = function(selectedThemeID){
                $scope.bannerSkinnedSiteForm = false;
                $scope.clearTableBG();

                $scope.formDisabled = false;
                //console.log(selectedThemeID);
                $http({
                    method: "post",
                    url:  "<?php  echo $angularPost; ?>",
                    data: {
                        selectedThemeID: selectedThemeID, 
                        option: 2, 
                    },
                }).then(function successCallback(responseTheme) { 

                    console.log(responseTheme.data);

                    var element = angular.element('#'+ selectedThemeID); 
                    element.css('background-color', 'rgb(171, 171, 171)');  
                     
                    $scope.ThemeLoops = responseTheme.data;
                    $scope.customerNumberUrl =   responseTheme.data.CustomerNumber;
                    $scope.ThemeIDUrl =   responseTheme.data.themeID;

                    $scope.bannerNewForm.ThemeIDUrl =   responseTheme.data.themeID;

                    $scope.bannerNewForm.bannerSkinnedSite =   responseTheme.data.skinnedBanner;

                    $scope.timeRand = Math.random();

                    if(responseTheme.data.skinnedBanner.length > 0){
                        $scope.bannerSkinnedSiteForm = true;
                    }

                    //Logo
                    if(responseTheme.data.LogoExist == 1){
                        //console.log(responseTheme.data.LogoUrl);
                        $scope.LogoLink =  $scope.baseURL + responseTheme.data.LogoUrl + "?" +  <?php echo  $randNum; ?> + $scope.timeRand;
                        //console.log($scope.LogoLink);

                    }else{
                        $scope.LogoLink = false;
                        responseTheme.data.LogoUrl = 0;
                        //console.log(responseTheme.data.LogoUrl);
                    }

                    if(responseTheme.data.FaviconExist == 1){  
                        $scope.FaviconLink =  $scope.baseURL + responseTheme.data.FaviconUrl + "?" +  <?php echo  $randNum; ?> + $scope.timeRand;   
                        //console.log($scope.FaviconLink);
                    }else{
                        $scope.FaviconLink = false;
                        responseTheme.data.FaviconUrl = 0; 
                        //console.log($scope.FaviconLink);
                    }

                    if(responseTheme.data.OGImageExist == 1){  
                        $scope.OGImageLink =  $scope.baseURL + responseTheme.data.OGImageUrl + "?" +  <?php echo  $randNum; ?> + $scope.timeRand;   
                    }else{
                        $scope.OGImageLink = false;
                        responseTheme.data.OGImageUrl = 0;  
                    }


                     if(responseTheme.data.MobileLogoExist == 1){  
                        $scope.MobileLogoLink =  $scope.baseURL + responseTheme.data.MobileLogoUrl + "?" +  <?php echo  $randNum; ?> + $scope.timeRand;   
                    }else{
                        $scope.MobileLogoLink = false;
                        responseTheme.data.MobileLogoUrl = 0;  
                    }



                    $scope.themeUrl = $scope.baseURL + 'ID' + $scope.customerNumberUrl + $scope.ThemeIDUrl;
                    
                    $scope.ThemeLoops['AboutUsTextEditor'] = responseTheme.data.AboutUsText;
                    $scope.ThemeLoops['ContactUsTextEditor'] = responseTheme.data.ContactUsText;
                    $scope.ThemeLoops['termsConditionTextEditor'] = responseTheme.data.termsConditionText;
                    
                    $scope.checkAllowMOQ= function(checkMoq){
                        console.log(checkMoq);
                        $scope.ThemeLoops['allowMOQ'] = checkMoq;
                    }


                    //Convert saved colour to RGB Part1
                    $scope.rgbheaderBackground = $scope.hexToRgbData("#" + $scope.ThemeLoops['headerBackground']);
                    $scope.rgbsearchBoxColour= $scope.hexToRgbData("#" + $scope.ThemeLoops['searchBoxColour']);
                    $scope.rgbheaderTextColour= $scope.hexToRgbData("#" + $scope.ThemeLoops['headerTextColour']);
                    $scope.rgbsearchBoxTextColour= $scope.hexToRgbData("#" + $scope.ThemeLoops['searchBoxTextColour']);
                    $scope.rgbheaderTrimColour= $scope.hexToRgbData("#" + $scope.ThemeLoops['headerTrimColour']);
                    $scope.rgbparagraphTextColour= $scope.hexToRgbData("#" + $scope.ThemeLoops['paragraphTextColour']);
                    $scope.rgbmenuHighlightColour= $scope.hexToRgbData("#" + $scope.ThemeLoops['menuHighlightColour']);
                    $scope.rgbcategoryTextColour= $scope.hexToRgbData("#" + $scope.ThemeLoops['categoryTextColour']);
                    $scope.rgbtextHighlightColour= $scope.hexToRgbData("#" + $scope.ThemeLoops['textHighlightColour']);
                    $scope.rgbCategoryIconOverlay = $scope.hexToRgbData("#" + $scope.ThemeLoops['CategoryIconOverlay']);
                    $scope.rgbBackgroundColour= $scope.hexToRgbData("#" + $scope.ThemeLoops['BackgroundColour']);
                    $scope.rgbmenuHoverBackground= $scope.hexToRgbData("#" + $scope.ThemeLoops['menuHoverBackground']);

                    //Convert saved colour to RGB Part 2
                    $scope.rgbtabColour= $scope.hexToRgbData("#" + $scope.ThemeLoops['tabColour']);
                    $scope.rgbtabTextColour= $scope.hexToRgbData("#" + $scope.ThemeLoops['tabTextColour']);
                    $scope.rgbtabTextColourHover= $scope.hexToRgbData("#" + $scope.ThemeLoops['tabTextColourHover']);
                    $scope.rgbtabSelectedColour= $scope.hexToRgbData("#" + $scope.ThemeLoops['tabSelectedColour']);
                    $scope.rgbtabSelectedText= $scope.hexToRgbData("#" + $scope.ThemeLoops['tabSelectedText']);
                    $scope.rgbtableBorderColour= $scope.hexToRgbData("#" + $scope.ThemeLoops['tableBorderColour']);
                    $scope.rgbtableHeaderColour= $scope.hexToRgbData("#" + $scope.ThemeLoops['tableHeaderColour']);
                    $scope.rgbtableHeaderTextColour= $scope.hexToRgbData("#" + $scope.ThemeLoops['tableHeaderTextColour']);
                    $scope.rgbtableCellColour = $scope.hexToRgbData("#" + $scope.ThemeLoops['tableCellColour']);
                    $scope.rgbtableCellTextColour= $scope.hexToRgbData("#" + $scope.ThemeLoops['tableCellTextColour']); 
                    

                    //Color Original
                    $scope.headerBackgroundOrig = responseTheme.data.headerBackground;
                    $scope.BackgroundColourOrig = responseTheme.data.BackgroundColour;
                    $scope.menuHoverBackgroundOrig = responseTheme.data.menuHoverBackground;
                    $scope.headerTextColourOrig = responseTheme.data.headerTextColour;
                    $scope.headerTrimColourOrig = responseTheme.data.headerTrimColour; 
                    $scope.menuHighlightColourOrig = responseTheme.data.menuHighlightColour; 
                    $scope.textHighlightColourOrig = responseTheme.data.textHighlightColour;
                    $scope.CategoryIconOverlayOrig = responseTheme.data.CategoryIconOverlay;

                    $scope.searchBoxTextColourOrig = responseTheme.data.searchBoxTextColour;
                    $scope.searchBoxColourOrig = responseTheme.data.searchBoxColour;
                    $scope.paragraphTextColourOrig = responseTheme.data.paragraphTextColour;
                    $scope.categoryTextColourOrig = responseTheme.data.categoryTextColour;
                     
                    //Convert HEx to RGB
                    $scope.categoryBoxShadow = $scope.hexToRgb("#" + responseTheme.data.textHighlightColour);
                     
                    //Part2
                    $scope.tabColourOrig = responseTheme.data.tabColour; 
                    $scope.tabTextColourOrig = responseTheme.data.tabTextColour; 
                    $scope.tabTextColourHoverOrig = responseTheme.data.tabTextColourHover; 
                    $scope.tabSelectedColourOrig = responseTheme.data.tabSelectedColour; 
                    $scope.tabSelectedTextOrig = responseTheme.data.tabSelectedText; 
                    $scope.tableBorderColourOrig = responseTheme.data.tableBorderColour; 
                    $scope.tableHeaderColourOrig = responseTheme.data.tableHeaderColour; 
                    $scope.tableHeaderTextColourOrig = responseTheme.data.tableHeaderTextColour;  
                    $scope.tableCellColourOrig  = responseTheme.data.tableCellColour; 
                    $scope.tableCellTextColourOrig  = responseTheme.data.tableCellTextColour;


                    $scope.removeHash = function(color, opts){
                        
                        var newColor;
                        if(color.substring(0,3) == 'rgb'){

                            var color = color.replace(';','');
                            var rgb = color; 
                            rgb = rgb.substring(4, rgb.length-1)
                                    .replace(/ /g, '')
                                    .split(','); 
                            //rgb(10, 20, 30); 
                            //#ff0000
                            newColor = $scope.fullColorHex(rgb[0], rgb[1], rgb[2]);

                        }else{
                            newColor = color.replace('#','');
                        }

                        
                       //console.log(newColor);
                        

                        if(opts == 'body'){ 
                            $scope.ThemeLoops['BackgroundColour'] = newColor;
                            $scope.rgbBackgroundColour = $scope.hexToRgbData("#" + newColor); 
                        }
                        if(opts == 'menuHoverBackground'){ 
                            $scope.ThemeLoops['menuHoverBackground'] = newColor;
                            $scope.rgbmenuHoverBackground = $scope.hexToRgbData("#" + newColor); 
                        }
                        if(opts == 'headerbg'){ 
                            $scope.ThemeLoops['headerBackground'] = newColor;
                            $scope.rgbheaderBackground = $scope.hexToRgbData("#" + newColor); 
                        }
                        if(opts == 'headertext'){ 
                            $scope.ThemeLoops['headerTextColour'] = newColor;
                            $scope.rgbheaderTextColour = $scope.hexToRgbData("#" + newColor); 
                        }
                        if(opts == 'headertrim'){ 
                            $scope.ThemeLoops['headerTrimColour'] = newColor;
                            $scope.rgbheaderTrimColour = $scope.hexToRgbData("#" + newColor); 
                        }
                        if(opts == 'menuhighlight'){ 
                            $scope.ThemeLoops['menuHighlightColour'] = newColor;
                            $scope.rgbmenuHighlightColour = $scope.hexToRgbData("#" + newColor); 
                        }
                        if(opts == 'texthighlight'){ 
                            $scope.ThemeLoops['textHighlightColour'] = newColor;
                            $scope.rgbtextHighlightColour = $scope.hexToRgbData("#" + newColor); 
                            //Convert HEx to RGB
                            $scope.categoryBoxShadow = $scope.hexToRgb("#" + newColor);
                        }

                       // $scope.rgbCategoryIconOverlay bottommenubg
                       if(opts == 'bottommenubg'){ 
                            $scope.ThemeLoops['CategoryIconOverlay'] = newColor;
                            $scope.rgbCategoryIconOverlay = $scope.hexToRgbData("#" + newColor);  
                        }

                        if(opts == 'searchbox'){ 
                            $scope.ThemeLoops['searchBoxColour'] = newColor;
                            $scope.rgbsearchBoxColour = $scope.hexToRgbData("#" + newColor);
                        }
                        if(opts == 'searchtext'){ 
                            $scope.ThemeLoops['searchBoxTextColour'] = newColor;
                            $scope.rgbsearchBoxTextColour = $scope.hexToRgbData("#" + newColor);
                        }
                        if(opts == 'bodytext'){ 
                            $scope.ThemeLoops['paragraphTextColour'] = newColor;
                            $scope.rgbparagraphTextColour = $scope.hexToRgbData("#" + newColor);
                        }
                        if(opts == 'producttext'){ 
                            $scope.ThemeLoops['categoryTextColour'] = newColor;
                            $scope.rgbcategoryTextColour = $scope.hexToRgbData("#" + newColor);
                        }
                        //Part 2
                        if(opts == 'tabColour'){ 
                            $scope.ThemeLoops['tabColour'] = newColor;
                            $scope.rgbtabColour = $scope.hexToRgbData("#" + newColor);
                        }
                        if(opts == 'tabTextColour'){ 
                            $scope.ThemeLoops['tabTextColour'] = newColor;
                            $scope.rgbtabTextColour = $scope.hexToRgbData("#" + newColor);
                        }
                        if(opts == 'tabTextColourHover'){ 
                            $scope.ThemeLoops['tabTextColourHover'] = newColor;
                            $scope.rgbtabTextColourHover = $scope.hexToRgbData("#" + newColor);
                        }
                        if(opts == 'tabSelectedColour'){ 
                            $scope.ThemeLoops['tabSelectedColour'] = newColor;
                            $scope.rgbtabSelectedColour = $scope.hexToRgbData("#" + newColor);
                        }
                        if(opts == 'tabSelectedText'){ 
                            $scope.ThemeLoops['tabSelectedText'] = newColor;
                            $scope.rgbtabSelectedText = $scope.hexToRgbData("#" + newColor);
                        }
                        if(opts == 'tableBorderColour'){ 
                            $scope.ThemeLoops['tableBorderColour'] = newColor;
                            $scope.rgbtableBorderColour = $scope.hexToRgbData("#" + newColor);
                        }
                        if(opts == 'tableHeaderColour'){ 
                            $scope.ThemeLoops['tableHeaderColour'] = newColor;
                            $scope.rgbtableHeaderColour = $scope.hexToRgbData("#" + newColor);
                        }
                        if(opts == 'tableHeaderTextColour'){ 
                            $scope.ThemeLoops['tableHeaderTextColour'] = newColor;
                            $scope.rgbtableHeaderTextColour = $scope.hexToRgbData("#" + newColor);
                        }
                        if(opts == 'tableCellColour'){ 
                            $scope.ThemeLoops['tableCellColour'] = newColor;
                            $scope.rgbtableCellColour = $scope.hexToRgbData("#" + newColor);
                        }
                        if(opts == 'tableCellTextColour'){ 
                            $scope.ThemeLoops['tableCellTextColour'] = newColor;
                            $scope.rgbtableCellTextColour = $scope.hexToRgbData("#" + newColor);
                        }
                        

                    }

                    $scope.undoColor = function(optsx){ 
                        //console.log(optsx);
                        if(optsx == 'body'){ 
                            $scope.ThemeLoops['BackgroundColour'] =  $scope.BackgroundColourOrig;
                            $scope.rgbBackgroundColour = $scope.hexToRgbData("#" + $scope.BackgroundColourOrig); 
                        }
                        if(optsx == 'menuHoverBackground'){ 
                            $scope.ThemeLoops['menuHoverBackground'] =  $scope.menuHoverBackgroundOrig;
                            $scope.rgbmenuHoverBackground = $scope.hexToRgbData("#" + $scope.menuHoverBackgroundOrig); 
                        }
                        if(optsx == 'headerbg'){
                            $scope.ThemeLoops['headerBackground'] = $scope.headerBackgroundOrig;
                            $scope.rgbheaderBackground= $scope.hexToRgbData("#" + $scope.headerBackgroundOrig); 
                        }
                        if(optsx == 'headertext'){ 
                            $scope.ThemeLoops['headerTextColour'] = $scope.headerTextColourOrig;
                            $scope.rgbheaderTextColour = $scope.hexToRgbData("#" + $scope.headerTextColourOrig); 
                        }
                        if(optsx == 'headertrim'){ 
                            $scope.ThemeLoops['headerTrimColour'] = $scope.headerTrimColourOrig;
                            $scope.rgbheaderTrimColour = $scope.hexToRgbData("#" + $scope.headerTrimColourOrig); 
                        }
                        if(optsx == 'menuhighlight'){ 
                            $scope.ThemeLoops['menuHighlightColour'] = $scope.menuHighlightColourOrig;
                            $scope.rgbmenuHighlightColour = $scope.hexToRgbData("#" + $scope.menuHighlightColourOrig);
                        }
                        if(optsx == 'texthighlight'){ 
                            $scope.ThemeLoops['textHighlightColour'] = $scope.textHighlightColourOrig;
                            $scope.rgbtextHighlightColour = $scope.hexToRgbData("#" + $scope.textHighlightColourOrig);
                            //Convert HEx to RGB
                            $scope.categoryBoxShadow = $scope.hexToRgb("#" + $scope.textHighlightColourOrig);
                        }

                        if(optsx == 'bottommenubg'){ 
                            $scope.ThemeLoops['CategoryIconOverlay'] = $scope.CategoryIconOverlayOrig;
                            $scope.rgbCategoryIconOverlay = $scope.hexToRgbData("#" + $scope.CategoryIconOverlayOrig);  
                        }


                        if(optsx == 'searchbox'){ 
                            $scope.ThemeLoops['searchBoxColour'] = $scope.searchBoxColourOrig;
                            $scope.rgbsearchBoxColour = $scope.hexToRgbData("#" + $scope.searchBoxColourOrig);
                        }
                        if(optsx == 'searchtext'){ 
                            $scope.ThemeLoops['searchBoxTextColour'] = $scope.searchBoxTextColourOrig;
                            $scope.rgbsearchBoxTextColour = $scope.hexToRgbData("#" + $scope.searchBoxTextColourOrig);
                        }
                        if(optsx == 'bodytext'){ 
                            $scope.ThemeLoops['paragraphTextColour'] = $scope.paragraphTextColourOrig;
                            $scope.rgbparagraphTextColour = $scope.hexToRgbData("#" + $scope.paragraphTextColourOrig);
                        }
                        if(optsx == 'producttext'){ 
                            $scope.ThemeLoops['categoryTextColour'] = $scope.categoryTextColourOrig;
                            $scope.rgbcategoryTextColour = $scope.hexToRgbData("#" + $scope.categoryTextColourOrig);
                        }
                        //Part 2
                        if(optsx == 'tabColour'){ 
                            $scope.ThemeLoops['tabColour'] = $scope.tabColourOrig;
                            $scope.rgbtabColour = $scope.hexToRgbData("#" + $scope.tabColourOrig);
                        }
                        if(optsx == 'tabTextColour'){ 
                            $scope.ThemeLoops['tabTextColour'] = $scope.tabTextColourOrig;
                            $scope.rgbtabTextColour = $scope.hexToRgbData("#" + $scope.tabTextColourOrig);
                        }
                        if(optsx == 'tabTextColourHover'){ 
                            $scope.ThemeLoops['tabTextColourHover'] = $scope.tabTextColourHoverOrig;
                            $scope.rgbtabTextColourHover = $scope.hexToRgbData("#" + $scope.tabTextColourHoverOrig);
                        }
                        if(optsx == 'tabSelectedColour'){ 
                            $scope.ThemeLoops['tabSelectedColour'] = $scope.tabSelectedColourOrig;
                            $scope.rgbtabSelectedColour = $scope.hexToRgbData("#" + $scope.tabSelectedColourOrig);
                        }
                        if(optsx == 'tabSelectedText'){ 
                            $scope.ThemeLoops['tabSelectedText'] = $scope.tabSelectedTextOrig;
                            $scope.rgbtabSelectedText = $scope.hexToRgbData("#" + $scope.tabSelectedTextOrig);
                        }
                        if(optsx == 'tableBorderColour'){ 
                            $scope.ThemeLoops['tableBorderColour'] = $scope.tableBorderColourOrig;
                            $scope.rgbtableBorderColour = $scope.hexToRgbData("#" + $scope.tableBorderColourOrig);
                        }
                        if(optsx == 'tableHeaderColour'){ 
                            $scope.ThemeLoops['tableHeaderColour'] = $scope.tableHeaderColourOrig;
                            $scope.rgbtableHeaderColour = $scope.hexToRgbData("#" + $scope.tableHeaderColourOrig);
                        }
                        if(optsx == 'tableHeaderTextColour'){ 
                            $scope.ThemeLoops['tableHeaderTextColour'] = $scope.tableHeaderTextColourOrig;
                            $scope.rgbtableHeaderTextColour = $scope.hexToRgbData("#" + $scope.tableHeaderTextColourOrig);
                        }
                        if(optsx == 'tableCellColour'){ 
                            $scope.ThemeLoops['tableCellColour'] = $scope.tableCellColourOrig;
                            $scope.rgbtableCellColour = $scope.hexToRgbData("#" + $scope.tableCellColourOrig);
                        }
                        if(optsx == 'tableCellTextColour'){ 
                            $scope.ThemeLoops['tableCellTextColour']  = $scope.tableCellTextColourOrig;
                            $scope.rgbtableCellTextColour = $scope.hexToRgbData("#" + $scope.tableCellTextColourOrig);
                        }
                    }

                    
                    
                 }, function errorCallback(responseTheme) {
                    alert("Error retrieving the data from responseTheme");
                });   

               
}

$scope.hexToRgb =function(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}

$scope.hexToRgbData =function(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        var res = 'rgb(' + parseInt(result[1], 16) + ', ' + parseInt(result[2], 16) + ', ' + parseInt(result[3], 16) + ')';
        
    return result ? res  : null;
}

//RGB to Hex Conversion
/*
$scope.rgbToHex = function (r, g, b) {
    return   $scope.componentToHex(r) + $scope.componentToHex(g) + $scope.componentToHex(b);
}

$scope.componentToHex = function (c) {
    var hex = c.toString(16);
    return hex.length == 1 ? "0" + hex : hex;
} */
$scope.rgbToHex = function (rgb) {
    var hex = Number(rgb).toString(16);
    if (hex.length < 2) {
        hex = "0" + hex;
    }
    return hex;
}

$scope.fullColorHex = function(r,g,b) {   
  var red = $scope.rgbToHex(r);
  var green = $scope.rgbToHex(g);
  var blue = $scope.rgbToHex(b);
  return red+green+blue;
} 





//RGB to Hex Conversion



$scope.editThemeFormsSubmitted = function (){
        
            $scope.ThemeLoops['option'] = 7;
            $scope.noError = 0;
            var errorMessage = ' Please check your entry ';
            //console.log($scope.ThemeLoops);

            if($scope.ThemeLoops.CompanyTag == ''){
                $scope.CompanyTagError = 'Company Name is required';
                $scope.noError = 1;
                $scope.generalError = errorMessage;
            }else{
                $scope.CompanyTagError = false;
            } 
            //If Enquiry is yes so Email is required
            if($scope.ThemeLoops.Email == '' && $scope.ThemeLoops.EnquiryFormActive == 1){
                $scope.EmailError = 'Enquiry Email Address is required';
                $scope.noError = 1;
                $scope.generalError = errorMessage;
            }else{
                $scope.EmailError = false;
            }

            //Email validaton
            if($scope.ThemeLoops.Email != ''){ 
                if($scope.validateEmail($scope.ThemeLoops.Email) == false){
                    $scope.EmailError = 'Enquiry Email is incorrect';
                    $scope.noError = 1;
                    $scope.generalError = errorMessage;
                }else{
                    $scope.EmailError = false;
                }
            }
            if($scope.ThemeLoops.showPricing == '2'){ 
                 
                if($scope.ThemeLoops.customsiteAdminEmail == '' || $scope.ThemeLoops.customsiteAdminEmail == null){ 
                    $scope.customEmailError = 'Site Admin Email Address is required';
                    alert($scope.customEmailError);
                    $scope.noError = 1;
                    $scope.generalError = errorMessage; 
                }else if($scope.ThemeLoops.customsiteAdminEmail != '' || $scope.ThemeLoops.customsiteAdminEmail != null){
                    
                   
                    if($scope.validateEmail($scope.ThemeLoops.customsiteAdminEmail) == false){
                        $scope.customEmailError = 'Site Admin Email Address is incorrect';
                        alert($scope.customEmailError);
                        $scope.noError = 1;
                        $scope.generalError = errorMessage;
                    }else{
                        $scope.customEmailError = false;
                    }

                }else{
                    $scope.customEmailError = false;
                } 

            }else{
                $scope.customEmailError = false;
            }
            //Email validation

            if($scope.noError == 0){
                $http({
                        method: "post",
                        url:  "<?php  echo $angularPost; ?>",
                        data: $scope.ThemeLoops
                }).then(function successCallback(responseUpdate) { 

                        //console.log(responseUpdate.data);  

                        if(responseUpdate.data == '1'){

                            //Default error 
                            $scope.generalError = false; 
                            //success message
                            var element = angular.element('#successModal'); 
                            element.modal('show'); 
                            $scope.successMsg = 'Skinned site updated!';
                                    
                            $timeout(function() { 
                                element.modal('hide'); 
                            }, 2000);

                        }
                        

                        
                }, function errorCallback(responseUpdate) {
                            alert("Error retrieving the data from responseUpdate");
                }); 
            }
            
}


$scope.duplicateTheme = function (custNumber, themeID, custName){
    if (confirm("Are you sure you want to duplicate this theme?")) {  
        
            $http({
                        method: "post",
                        url:  "<?php  echo $angularPost; ?>",
                        data: {
                            custName: custName, 
                            custNumber : custNumber,
                            themeID : themeID,
                            option: 6, 
                        },
            }).then(function successCallback(responseDuplicate) { 

                    //console.log(responseDuplicate.data); 
                    $scope.selectCustomer(custNumber, custName, 1);
                    $scope.selectTheme(responseDuplicate.data); 
                    
            }, function errorCallback(responseDuplicate) {
                        alert("Error retrieving the data from responseDuplicate");
            });   
    }
}

$scope.deleteTheme = function(customerNumber, selectedThemeID, companyName){
    if (confirm("Are you sure you want to delete  this skinned site?")) {  
            $http({
                        method: "post",
                        url:  "<?php  echo $angularPost; ?>",
                        data: {
                            selectedThemeID: selectedThemeID, 
                            customerNumber : customerNumber,
                            option: 4, 
                        },
            }).then(function successCallback(responseDelete) { 

                    console.log(responseDelete.data);
                    $scope.selectCustomer(customerNumber, companyName);
                    
            }, function errorCallback(responseDelete) {
                        alert("Error retrieving the data from responseDelete");
            });   
    }
}
 
 $scope.clickAlert = function(){
    alert("Uploading the logo or favicon will also save  and update the whole form. Do you want to continue?"); 
 }
 $scope.uploadLogo = function(file, themeID, customerName, customerNumber, opts) { 
     
    console.log(file);
       // console.log(file.name + " / " + file.type);
        /* console.log(themeID); 
        console.log(customerName); 
        console.log(customerNumber);  */

       
        
      
         
 
        if(file){

            if(opts == 3){
                    if(file.type !== 'image/jpeg' && file.type !== 'image/png'){
                        alert("Sorry, only .JPG or .PNG format is allowed.");
                        return;
                    }  
                    if(file.size > 8388608){
                        alert("Sorry, image must not exceed 8MB.");
                        return;
                    }

                    if(file.size  == 0){
                        alert("Something wrong with the image properties, file size = " + file.size + ", but we will try to save it anyway." ); 
                    }  
            }


             if(opts == 4){
                    if(file.type !== 'image/png'){
                        alert("Sorry, only   .PNG format is allowed.");
                        return;
                    }  

                    if(file.size > 8388608){
                        alert("Sorry, image must not exceed 8MB.");
                        return;
                    } 
                    if(file.size  == 0){
                        alert("Something wrong with the image properties, file size = " + file.size + ", but we will try to save it anyway." ); 
                    }  
            }

 

                    file.upload = Upload.upload({
                        url: '<?php echo $angularPost; ?>',
                        data: {options: 5, themeID:  themeID, file: file, opts: opts},
                    });

                    file.upload.then(function (response) {  
                        // console.log(response.data);
                       
                         if(response.data == 1){

                                var element = angular.element('#successModal'); 
                                element.modal('show'); 
                                $scope.successMsg = 'Uploaded and form updated';
                                $timeout(function() {
                                    element.modal('hide'); 
                                }, 900);   

                            $scope.editThemeFormsSubmitted(); 
                            //Refresh the new Customer  
                            $scope.selectCustomer(customerNumber, customerName, 1);
                            //Refresh the new added theme 
                            $scope.selectTheme(themeID); 
                                
                            var timeRand = Math.floor(Math.random() * 10);
                            $scope.LogoLink =  $scope.LogoLink + timeRand;  
                            $scope.OGImageLink =  $scope.OGImageLink + timeRand;
                            $scope.MobileLogoLink = $scope.MobileLogoLink  + timeRand;

                         }  
                            

                    }, function (response) {
                    if (response.status > 0)
                        $scope.errorMsg = response.status + ': ' + response.data;
                    });  
        }  
        
 }

$scope.clearTableBG = function(){
    var element = angular.element('.themeTables'); 
    element.css('background-color', 'transparent');  
}

$scope.validateEmail = function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(re.test(String(email).toLowerCase())){
        return true;
    }else{
        return false;
    }  
}




/* Banner */


  /* Add new form banner */
  $scope.addNewBannerForm = function(file,  themeID, customerName, customerNumber){

     
if($scope.bannerNewForm.url == "" || $scope.bannerNewForm.url == null){ 
      alert("URL is required and cannot be empty");
      return;
} 
if($scope.bannerNewForm.ThemeIDUrl == '' )
{ 
      alert("Location is required and cannot be empty");
      return;
} 

if( !file.name ){
      alert("File image is required and cannot be empty");
      return;
} 

if( file.type != 'image/jpeg' ){
      alert("File image must be jpeg");
      return;
} 
//console.log($scope.bannerNewForm); 

  if(file){ 
          file.upload = Upload.upload({
              url: '<?php echo $angularPost; ?>',
              data: {options: 8, file: file, bannerData: $scope.bannerNewForm },
          });

          file.upload.then(function (response ) {   
                 console.log(response.data);        
                  
                 if(response.data == 1){

                      

                      $scope.bannerNewForm.url = null;
                      $scope.picFile = {};
                      var inputElem = angular.element("input[type='file']");
                      angular.element(inputElem).val(null);

                      $scope.editThemeFormsSubmitted(); 
                      //Refresh the new Customer  
                      $scope.selectCustomer(customerNumber, customerName, 1);
                      //Refresh the new added theme 
                      $scope.selectTheme(themeID); 
                  }
                 
                          
          }, function (response) {
              if (response.status > 0)
                  $scope.errorMsg = response.status + ': ' + response.data;
          }); 
  }   

}



$scope.editBannerForm = function(themeID){
  //console.log($scope.bannerNewForm.bannerSkinnedSite); 
   
   $scope.bannerMsg = 'Banner updated successfuly!'; 
   
  $http({
          method: "post",
          url:  "<?php echo $angularPost; ?>",
          data: {  option: 9, updateData: $scope.bannerNewForm.bannerSkinnedSite, location: themeID } 
      }).then(function successCallback(responseUpdate) { 
          console.log(responseUpdate.data);   
          if(responseUpdate.data.success == '1'){
              $scope.success($scope.bannerMsg);        
          }else{
              alert("Banner items cannot be empty!");
          }  
      }, function errorCallback(responseUpdate) {
                  console.log("Error updating the skinned banner");
  });          
              
}

$scope.deleteBanner = function(id, location, filename,  themeID, customerName, customerNumber ){

      
  if (confirm("Are you sure you want to delete  this banner?")) { 

      
      // console.log(id + "/" + location + "/" + filename );
      $http({
              method: "post",
              url:  "<?php echo $angularPost; ?>",
              data: {
                  id: id,
                  location: location,
                  filename: filename,
                  option: 10 
              },
      }).then(function successCallback(responseDel) { 
          console.log(responseDel.data);

         

          if(responseDel.data == 'success'){
              //var elementDel = angular.element('#bannerRemove' + id); 
              //elementDel.css('display', 'none'); 
                  //Refresh the new Customer  
                  $scope.selectCustomer(customerNumber, customerName, 1);
                  //Refresh the new added theme 
                  $scope.selectTheme(themeID); 

          }
           
      }, function errorCallback(responseDel) {
          alert("Error retrieving the responseDel");
      });  
  }
}


$scope.success = function(msg){
  var element = angular.element('#successModal'); 
  element.modal('show'); 
  $scope.successMsg = msg;
  $timeout(function() {
      element.modal('hide'); 
  }, 900);  
}

 
 $scope.pasteAboutCheck = function($event){ 
        var htmls = $event.currentTarget.innerText;   
        $scope.ThemeLoops.AboutUsTextEditor = $scope.pasteEvent(htmls)   
    }

    $scope.pasteContactCheck = function($event){ 
        var htmls = $event.currentTarget.innerText;   
        $scope.ThemeLoops.ContactUsTextEditor = $scope.pasteEvent(htmls)
    
    }

    $scope.pasteTermsCheck = function($event){ 
        var htmls = $event.currentTarget.innerText;   
        $scope.ThemeLoops.termsConditionTextEditor = $scope.pasteEvent(htmls)
    
    }

    $scope.pasteEvent = function(htmls){

        var html = htmls.slice(11);
        temporalDivElement = document.createElement("div");
        // Set the HTML content with the providen
        temporalDivElement.innerHTML = html;
        // Retrieve the text property of the element (cross-browser support)
        return temporalDivElement.textContent || temporalDivElement.innerText || "";  
    }


}]); // end controller
/*
tgpApp.config(function($provide){ 
	$provide.decorator('taOptions', ['taRegisterTool', 'taSelection', '$window', 'taTranslations', '$delegate',  function(taRegisterTool, taSelection, $window, taTranslations, taOptions ){
		// $delegate is the taOptions we are decorating
        // register the tool with textAngular
        console.log(taOptions); 
		taRegisterTool('colourRed', {
			iconclass: "fa fa-unlink",
			action: function(event, $element, editorScope){

                //console.log(window.getSelection());

               if(taSelection.getOnlySelectedElements().length > 0){
                    console.log(taSelection.getOnlySelectedElements()[0].firstChild.parentElement.innerText);
                    var textReplace = taSelection.getOnlySelectedElements()[0].firstChild.parentElement.innerText;
                    var sel = window.getSelection();
                    if (sel.rangeCount) {
                        console.log(sel.getRangeAt(0));
                        range = sel.getRangeAt(0);     
                        range.deleteContents();
                        range.insertNode(document.createTextNode(textReplace)); 
                    }
                }  
               
 
                //console.log(taSelection.getOnlySelectedElements());
                //console.log(taSelection.getOnlySelectedElements()[0].firstChild.parentElement);
                //console.log(taSelection.getOnlySelectedElements()[0].firstChild.parentElement.outerHTML);
                 
                //console.log(this.$editor().html);
                //this.$editor().updateTaBindtaHtmlElement(); 
                //console.log(this.$editor());
			}
		});
		// add the button to the default toolbar definition
		taOptions.toolbar[1].push('colourRed');
		return taOptions;
	}]);
}); */
 
</script>

