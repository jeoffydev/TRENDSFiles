 
<?php 
/* Category Items */
  
$json_data=array();  
$searchCountDefault = count($getCategoryProducts['categories']);
$categoriesAllCount= $getCategoryProducts['categoriesAllCount'];
foreach($getCategoryProducts['categories']  as $rec)//foreach loop  
{    
    
    
    $json_array = $this->productsdisplay_model->productsLoop($rec, $siteLogcheck, $customArray, $skinnedUserCheck);
    $json_array['Name'] = $this->general_model->cleanString($json_array['Name'], 1); 
	$json_array['FullName'] = $this->general_model->cleanString($json_array['FullName']); 

    array_push($json_data,$json_array);
} 
$categoryLists = json_encode($json_data,JSON_PRETTY_PRINT);  
 
 

 //If submitted by search Form
if($this->input->get('Colour') || $this->input->get('rangeFrom') || $this->input->get('rangeTo')  || $this->input->get('stockNumber') || $this->input->get('Branding')|| $this->input->get('priceSort')){
    $colourForm =  $this->general_model->cleanURLs($this->input->get('Colour'));
    $brandingForm =  $this->general_model->cleanURLs($this->input->get('Branding'));
    $rangeFrom= $this->general_model->cleanURLs($this->input->get('rangeFrom')); 
    $rangeTo = $this->general_model->cleanURLs($this->input->get('rangeTo')); 
    $stockNumber = $this->general_model->cleanURLs($this->input->get('stockNumber'));
    $priceSort = $this->general_model->cleanURLs($this->input->get('priceSort'));
}
 //If submitted by search Form
  
 //Breakdown
 $changeURLActive = 0;
 $productsURL = 0;
 $getTheDomain = "";
		 
 if($url['query']){
    $queryVar =  $url['query'];
    $resultKey = substr($queryVar, 0, 10); 
    if($resultKey == "Categories"){
        
        $changeURLActive = 1;
        if($categoryCode == 'products'){
            $productsURL = 1;
        }
        $path = parse_url($_SERVER['REQUEST_URI']); 
        $getTheDomain = $path['path'];
    }

 }

 /* Back URL for the category page */
 $activeBackUrl = 0;
 if($this->input->get('rowParam') && $this->input->get('rowParam') > 32){   
    $rowParameter =  $this->input->get('rowParam'); 
    if(!$rowParameter){
        $rowParameter = 0;
    } 
    $activeBackUrl = 1;
 }

 $rowScroll = 32;
 if($this->input->get('scroll')){   
    $rowScroll =  $this->input->get('scroll');  
 }
 //This is where the scrollActive = 1 was triggered *********** where the browser will remember the URL **************
 $rowID = 0;
 $idTrue = 0;
 if($this->input->get('scrollActive')){   
    $rowID =  $this->input->get('scrollActive');  
    $idTrue = 1;
 }
 
?>
  
 
<script> 
//JQuery 
        $("input[type='number']").inputSpinner(); 

        var elem = 'menu_category';
		 
        window.onscroll = function() {fixOnTop()};

        // Get the header
        var header = document.getElementById(elem);

        // Get the offset position of the navbar
        var sticky = header.offsetTop;

        var backTop = '#topBtn'; 
		$(backTop).hide();

        // Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
        function fixOnTop() {
            if (window.pageYOffset > sticky) {
                header.classList.add("sticky");
                $( ".container-cats" ).addClass( "adjustCatcontainer" );

                $(backTop).show();

               //Select 2 close 
                $("#searchbrandform, #searchcolourform, #searchsortform").select2("close"); 
                 
            } else {
                $( ".container-cats" ).removeClass( "adjustCatcontainer" );
                header.classList.remove("sticky");
                $(backTop).hide();
            }
        }

           
        $('#topBtn').on('click', function (e) {
			e.preventDefault();
			$('html,body').animate({
				scrollTop: 0
			}, 700);
        });     
        
       
       //Window scroll for the back to top button
       $(window).scroll(function() {
            if($(window).scrollTop()) {
                let topScroll = $(window).scrollTop();
                sessionStorage.setItem("scrollPosition", topScroll);
            }
 
        });  
        
       //If idTrue = 1 and found sessionStorage scroll to the element
        <?php  if($idTrue == 1){   ?>
            $("#clickmeScrollDiv").click(function() {  
                var rowId = sessionStorage.itemCode;
                //two options of scroll down here for luck 
                if(sessionStorage.getItem("scrollPosition")){
                    $('html, body').scrollTop(sessionStorage.getItem("scrollPosition"));
                } 
                // if above ios not working then use this 
                // RowID example - id="Row108031" - this item code was set from the sessionStorage above  
                if($("#Row" + rowId).length){ 
                    $('html, body').animate({
                        scrollTop: $("#Row" + rowId).offset().top
                      }, 5);
                } 
                return false;   
            }); 
        <?php  }   ?>     

 //JQuery 

tgpApp.controller("categoryCtrl",  ['$scope', '$http',  'Upload', '$timeout', '$window', '$sce', '$compile',   function($scope,  $http, Upload, $timeout, $window, $sce, $compile){    


    $scope.testinng = "Testing CATEGORY";

    $scope.categoryLists = <?php echo $categoryLists; ?>;
    $scope.query = {}
    $scope.queryBy = '$';
    $scope.searchAdvanceForms = {};
    $scope.categoryAll = '<?php echo $customArray['category']; ?>';
  
    var flag = 0; 
    
    $scope.row = 0;
    //Show the item per load
    $scope.rowperpageDefault = 32;
    $scope.rowperpage = 32;
    //$scope.posts = [];
    $scope.busy = false;
    $scope.loading = false;
    $scope.loading2 = false;
    $scope.categoryCount = 0;
    $scope.searchAdvanceForms.Colours = null;
    $scope.searchAdvanceForms.Branding = null;
    $scope.searchAdvanceForms.lowPrice = 0;
    $scope.searchAdvanceForms.highPrice = 0; 
    $scope.searchAdvanceForms.priceSort = null;
    $scope.searchAdvanceForms.stockNumber = 0;
    $scope.trigger = 0;
    $scope.noResults = false;
    $scope.btnForm = 0;
    $scope.searchCountShow = false;
    

    $scope.searchResults = '<?=$categoriesAllCount?>';
    $scope.countvisible = true;
    //If Keyword from search form main header
    $scope.searchAdvanceForms.keyword  = '<?=$keyword?>';
    $scope.searchAdvanceForms.triggerForm = 0;
    $scope.triggerFormActive = $scope.searchAdvanceForms.triggerForm;
    $scope.getCategoryUrl = '<?=$this->input->get('Categories');?>';
    $scope.changeURLActive = '<?=$changeURLActive?>';
    $scope.productsURL = '<?=$productsURL?>';
    $scope.getTheDomain = '<?=$getTheDomain?>';
    $scope.loopCount= 0;
    $scope.activeScroll = false;
    $scope.triggerScroll= '<?=$rowScroll?>';
    $scope.itemUrl = '';
    $scope.itemTrigger = 0;
    $scope.backUrl = true;

    $scope.searchCount = '...'; 
    <?php if($customArray['category']  == "all"): ?>
       // $scope.searchCount = '<?=$searchCountDefault?>'; 
       
    <?php endif; ?>
  
        /**
         * @property range
         * @type {{from: number, to: number}}
         */
        $scope.searchAdvanceForms.range = { from: 0, to: 200 };

        /**
         * @property max
         * @type {Number}
         */
        $scope.max = 200;

        var _timeout;
        
        $scope.advanceSearchNumbers = function(){

             /********* SLOW TYPING *****/
            var textInputLow = document.getElementById('lowInput'); 
            var textInputHigh = document.getElementById('highInput'); 
            
            if(_timeout) { // if there is already a timeout in process cancel it
                $timeout.cancel(_timeout);
            }
            _timeout = $timeout(function() {
                 
                 $scope.advanceSearch();
                 
                _timeout = null;
            }, 1500); 

        }    
         /********* SLOW TYPING *****/  
 
            
    // Fetch data
    $scope.getCategoriesScroll = function(){ 
            if ($scope.busy) return; 
            $scope.busy = true;  
            $scope.requestPullCategories();    
    } 

    $scope.advanceSearch = function(){
         
        $scope.busy = false;
        $scope.loading = false;
        $scope.loading2 = false;

        $scope.row = 0; 
        $scope.rowperpage = 32;
        $scope.categoryLists = '';
        //console.log($scope.searchAdvanceForms.range);
         
        
        $scope.searchAdvanceForms.lowPrice = $scope.searchAdvanceForms.range.from;
        $scope.searchAdvanceForms.highPrice = $scope.searchAdvanceForms.range.to;
       

        if ($scope.busy) return; 
        $scope.busy = true;
        $scope.btnForm = 1;

        //FORM USED HERE
        <?php if($this->input->get('Colour') || $this->input->get('rangeFrom') || $this->input->get('rangeTo') || $this->input->get('stockNumber') || $this->input->get('Branding') || $this->input->get('priceSort') ): ?>
                //remove the default items showing
                $scope.categoryLists = '';
                <?php if($categoryCode == 'products'): ?>
                    $scope.categoryLists = <?php echo $categoryLists; ?>;  
                    
                <?php endif; ?> 
                
        <?php else: ?>      
                $scope.categoryLists = <?php echo $categoryLists; ?>;     
        <?php endif; ?>  

         /* REDIRECT IF USING THE POPUP FORM */
         if($scope.changeURLActive == 1){
             
             if($scope.searchAdvanceForms.triggerForm > 0  ){ 
                 if($scope.searchAdvanceForms.Branding == null){
                     $scope.searchAdvanceForms.Branding = "";
                 }
                 if($scope.searchAdvanceForms.priceSort == null){
                     $scope.searchAdvanceForms.priceSort = "";
                 }
                 var urlRedirect = $scope.getTheDomain + "?Categories=" + $scope.getCategoryUrl + "&Branding=" +  $scope.searchAdvanceForms.Branding  + "&Colour=" + $scope.searchAdvanceForms.Colours + "&rangeFrom=" + $scope.searchAdvanceForms.lowPrice + "&rangeTo=" + $scope.searchAdvanceForms.highPrice + "&stockNumber=" + $scope.searchAdvanceForms.stockNumber + "&priceSort=" + $scope.searchAdvanceForms.priceSort;
                 window.location.href = urlRedirect;  
             }  
         } 
         /* REDIRECT IF USING THE POPUP FORM */
        
        /* IF NOT GET FORM URL TRIGGER = 1 ON Form search hidden field */ 
         
        if( ($scope.getCategoryUrl == "" || $scope.getCategoryUrl == null) || $scope.searchAdvanceForms.triggerForm > 0){
             
                //console.log("Pasok");
                $scope.requestPullCategories(); 
             
        }
         /* IF NOT GET FORM URL TRIGGER = 1 ON Form search hidden field */ 
        
 
    }

/**** NEW SEARCH ****************************************/
    $scope.ScrollVal = 0;
    $scope.getdataScroll = function(){
            //increment to 1
            $scope.ScrollVal += 1;   
            $scope.rowperpage = <?=$rowScroll?>; //this will be in cookies
            $scope.activeScroll = true;  
            <?php  if($idTrue == 1){   ?> 
              
                setTimeout(function() { 
                    $scope.$apply(function(){  
                        const element = document.querySelector('#clickmeScrollDiv');
                        element.click(); 
                    });

                }, 700); 
            <?php  }   ?>
        //}  
    }
    //Initiate this function
    $scope.getdataScroll(); 
    $scope.getThisItem = function(code){ 
        
        if($scope.itemTrigger == 1 && code){  
            $scope.itemUrl = code;
            $scope.changeUrl($scope.getCategoryUrl, $scope.searchAdvanceForms, $scope.row, $scope.itemUrl);    
        } 
    }

    /**** NEW SEARCH ****************************************/

    $scope.requestPullCategories = function(){
         
        // Fetch data 
        $scope.searchAdvanceForms.categoriesAll = $scope.categoryAll;
        $scope.noResults = false;
 
       
         
        $http({
                method: 'post',
                url: "<?php echo base_url();?>Angular/AngularPostScrollBottom",
                data: { option: 1,  categoryCode: '<?=$categoryCode?>', customID: '<?=$customID?>',  flag:   $scope.row, rowperpage:   $scope.rowperpage, parameters: $scope.searchAdvanceForms   }
            }).then(function successCallback(response) {
                //console.log("YUN OH ");
                
                // console.log(response.data);
                $scope.searchCount =  response.data.length;
               
               // console.log("$scope.searchCount =  " + $scope.searchCount);
                /* reset to all if done scrolling */
                if($scope.searchCount == 0 && $scope.row != 0){
                    $scope.searchCount =   $scope.searchResults; 
                    
                }
               
                if($scope.searchCount == 0 && $scope.btnForm == 1){ 

                    $scope.noResults = true; 
                    $scope.categoryLists = false;
                    $scope.searchResults = 0; 
                }



                if(response.data !='' ){  

                        /* ANOTHER QUERY FOR GETTING THE WHOLE REAULT OF QUERY */
                        $http({
                            method: 'post',
                            url: "<?php echo base_url();?>Angular/AngularPostScrollBottom",
                            data: { option: 2,  categoryCode: '<?=$categoryCode?>', customID: '<?=$customID?>',  flag:   $scope.row, rowperpage:   $scope.rowperpage, parameters: $scope.searchAdvanceForms   }
                        }).then(function successCallback(responseC) {
                                $scope.searchResults = responseC.data;
                             }, function errorCallback(responseC) {
                            console.log("Error retrieving the Count Results ");
                        }); 

                        /* ANOTHER QUERY FOR GETTING THE WHOLE REAULT OF QUERY */ 
  
                        // New row value 
                        $scope.row+=$scope.rowperpage;
                        $scope.searchCountShow = false;
                        $scope.loading = true;
                      
                        $scope.noResults = false;
                        $scope.btnForm = 0;
 
                        
                        //Reset the row scroll
                        if($scope.activeScroll == true){
                            $scope.rowperpage = $scope.rowperpageDefault;
                            $scope.activeScroll == false;
                            $scope.backUrl = false;
                        } 

                        <?php  if($idTrue == 1):   ?>
                            $scope.loading2 = true;

                            $timeout(function() { 
                                $scope.loading2 = false; 
                            }, 800); 


                        <?php endif; ?>

                          
                       
                        setTimeout(function() { 
                            $scope.$apply(function(){ 
                                // Assign response to posts Array 
                                    $scope.catlist = response.data; 
                                    // console.log("This ones - " + $scope.categoryLists.length);
                                    
                                    //console.log(response.data);
                                    if($scope.categoryLists.length < $scope.rowperpage){ 
                                        $scope.categoryLists = [];
                                       // console.log("This less than 32");
                                       // console.log( $scope.categoryLists);
                                    }
                                   
                                    angular.forEach(response.data,function(item) {
                                        $scope.categoryLists.push(item);
                                    });  
                                    $scope.searchCountShow = true;
                                    $scope.searchCount =  $scope.categoryLists.length;

 

                                    //Post to URL autopost
                                    var FullUrl = window.location.protocol + "//" + window.location.host +  window.location.pathname;
                                    //console.log(FullUrl);
                                    //console.log($scope.searchAdvanceForms);

                                    /*
                                    *
                                    * get each variables in the URL
                                    * 
                                    * 
                                    * 
                                    *   
                                    */

                                    if($scope.searchAdvanceForms){
                                        if($scope.getCategoryUrl == null){
                                            $scope.getCategoryUrl = '';
                                        } 
                                        if($scope.searchAdvanceForms.Branding == null ){
                                            $scope.searchAdvanceForms.Branding = '';
                                        }
                                        if($scope.searchAdvanceForms.Colours == null ){
                                            $scope.searchAdvanceForms.Colours = '';
                                        }
                                        if( $scope.searchAdvanceForms.range.from == null ){
                                            $scope.searchAdvanceForms.range.from = '';
                                        }
                                        if($scope.searchAdvanceForms.range.to == null ){
                                            $scope.searchAdvanceForms.range.to = '';
                                        }
                                        if($scope.searchAdvanceForms.stockNumber == null ){
                                            $scope.searchAdvanceForms.stockNumber= '';
                                        }
                                        if($scope.searchAdvanceForms.priceSort == null ){
                                            $scope.searchAdvanceForms.priceSort = '';
                                        } 
                                        $scope.itemTrigger = 1; 

                                        $scope.changeUrl($scope.getCategoryUrl, $scope.searchAdvanceForms, $scope.row);

                                    }  

                                   
                                    
                                    $scope.busy = false;
                                    $scope.loading = false;  
                                   
                                 
                                
                            });

                        }, <?php  if($idTrue == 1):   ?>  80 <?php else: ?>  600 <?php endif; ?>);

                       
                         //Show the search
                        setTimeout(function() { 
                                        var elementTopSearch = angular.element('.categoryscroll'); 
                                        elementTopSearch.css('visibility', 'visible'); 
                        }, 400);  
                        
                        setTimeout(function() { 
                            var element = angular.element('#stickyCounter'); 
                            element.css('display', 'block');

                             $timeout(function() { 
                                var element2 = angular.element('#stickyCounter'); 
                                element2.css('display', 'none');
                            }, 2000); 

                        }, 2000);  
 

                }  

        });
    }

    //This is where the URL push state happened, note: once the user scroll and hover an item this itemUrl will set from null to 1 and it means that is ready to scroll to the products ID
    // RowID example - id="Row108031" - this item code was set from the sessionStorage of the item page 
    $scope.changeUrl = function(getCategoryUrl, searchAdvanceForms, row, itemUrl){
       
        var row = row || null;
        var itemUrl = itemUrl || null;
        
        if(itemUrl != null){
            itemUrl = 1;
        }
    
        var newFullUrl = '?Categories=' + getCategoryUrl + '&Branding='+ searchAdvanceForms.Branding + '&Colour=' + searchAdvanceForms.Colours + '&rangeFrom=' + searchAdvanceForms.range.from  + '&rangeTo=' + searchAdvanceForms.range.to + '&stockNumber=' +   searchAdvanceForms.stockNumber + '&priceSort=' + searchAdvanceForms.priceSort  + '&scroll=' +  row + '&scrollActive='+  itemUrl;
        window.history.pushState({ path: newFullUrl }, '', newFullUrl);  
    }

    // MAIN FUNCTION OF SCROLL TO BOTTOM ***************************************************/
    $scope.getCategoriesScroll();
     
      

    $scope.priceAdjust = function(lowprice, highprice){
         
         if(highprice !== 0){
            if(lowprice >= highprice){
                $scope.searchAdvanceForms.highPrice = lowprice + 1;
            }
         }  

    }
 
    /* IF FORM USED */ 
    <?php if($this->input->get('Colour') || $this->input->get('rangeFrom') || $this->input->get('rangeTo') || $this->input->get('stockNumber') || $this->input->get('Branding') || $this->input->get('priceSort') ){ ?>
  
            $scope.searchAdvanceForms.Colours = '<?=$colourForm?>';
            $scope.searchAdvanceForms.Branding = '<?=$brandingForm?>';
             

            //Stock NUmber
            <?php  if($this->input->get('stockNumber')){ ?>
                $scope.searchAdvanceForms.stockNumber = <?=$stockNumber?>;
            <?php } ?>
           
            
            //Range Number
            $scope.searchAdvanceForms.lowPrice = '<?=$rangeFrom?>';
            $scope.searchAdvanceForms.highPrice = '<?=$rangeTo?>';
            
            <?php if($this->input->get('rangeFrom')){ ?>
                $scope.searchAdvanceForms.range.from = <?=$rangeFrom?>;
            <?php } ?>

            <?php if($this->input->get('rangeTo')){ ?>
                $scope.searchAdvanceForms.range.to = <?=$rangeTo?>;
            <?php } ?>
             //Range Number

             //Sortby
             <?php if($this->input->get('priceSort')){ ?>
                $scope.searchAdvanceForms.priceSort = '<?=$priceSort?>';
            <?php } ?>
             


            <?php if($customArray['category']  == "all"): ?>
                $scope.advanceSearch(); 
            <?php endif; ?>
           
    <?php } ?>
   /* IF FORM USED */ 
 
 

}]); // end controller
 
 
</script>
