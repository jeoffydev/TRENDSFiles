 
<?php 
   
   /* start angularjs for pricing */
   /* echo "<pre>";
   print_r($getPriceProductsForPricing['pricingData']);
   echo "</pre>"; */

   $userID = 0;
   if($siteLogcheck['loggedIn'] == 1){
	   $userID = $siteLogcheck['userDatas'][0]->userID;
   }

   $FGCurrency = $getPriceProductsForPricing['Currency'];

    //Get currencies data
   $getCurrencyDatas = $this->general_model->getCurrencyData();

   //Initial Pricing Currency
   foreach($getPriceProductsForPricing['pricingData'] as $rec)//foreach loop  
   {    
	   $makePriceTypeArray[] = $rec->PricingType;
   }
   $getPriceType = json_encode($makePriceTypeArray,JSON_PRETTY_PRINT); 

   //Product Details
   if($getPriceProductsForPricing['productData']){
	   $Prim= $getPriceProductsForPricing['productData'][0]->Prim;
	   $cartonQuantity = $getPriceProductsForPricing['productData'][0]->cartonQuantity;
	   $cartonWeight = $getPriceProductsForPricing['productData'][0]->cartonWeight;
	   $cartonLength = $getPriceProductsForPricing['productData'][0]->cartonLength;
	   $cartonWidth = $getPriceProductsForPricing['productData'][0]->cartonWidth;
	   $cartonHeight = $getPriceProductsForPricing['productData'][0]->cartonHeight;

	   $cartonVolume = ($cartonLength *  $cartonWidth * $cartonHeight )/5000;
   }

   //PricingType
   foreach($getPriceProductsForPricing['pricingType'] as $pricingTypeDefault)//foreach loop  
   {    
	   $pricingTypeResults[] = $pricingTypeDefault;
   }
   $ptrCount = count($pricingTypeResults) - 1;
   if(count($ptrCount) > 0){
	   for($ptr = 0; $ptr <= $ptrCount; $ptr++){
		   $pricingTypeDefaultOutput[] =  array('defaultCurrency' => $pricingTypeResults[$ptr]->Currency, 'defaultPricingType' => $pricingTypeResults[$ptr]->PricingType);  
	   }
   } 
   $pricingTypeDefaultOutputFin = json_encode($pricingTypeDefaultOutput,JSON_PRETTY_PRINT);  

   /* Freight Options */
   foreach($getPriceProductsForPricing['freightData'] as $reqfreightDefault)//foreach loop  
   {    
	   $reqfreightResults[] = $reqfreightDefault;
   }
   $rfCount = count($reqfreightResults) - 1;
   if(count($rfCount) > 0){
	   for($rfr = 0; $rfr <= $rfCount; $rfr++){
		   $reqfreightDefaultOutput[] =  array('Prim' => $reqfreightResults[$rfr]->Prim, 'Name' => $reqfreightResults[$rfr]->Name, 'Carrier' => $reqfreightResults[$rfr]->Carrier, 'despatchLocation' => $reqfreightResults[$rfr]->despatchLocation, 'NZD' => $reqfreightResults[$rfr]->NZD, 'AUD' => $reqfreightResults[$rfr]->AUD,  'SGD' => $reqfreightResults[$rfr]->SGD,  'MYR' => $reqfreightResults[$rfr]->MYR,  'KgRate' => $reqfreightResults[$rfr]->KgRate, 'baseCharge' => $reqfreightResults[$rfr]->baseCharge  );  
	   }
   }  
   $reqfreightDefaultOutputFin = json_encode($reqfreightDefaultOutput,JSON_PRETTY_PRINT);  
   

   $PricingInformation1 = null;
   $PricingInformation2 = null;
   $PricingInformation3 = null;
   $PricingInformation4 = null;
   $PricingInformation5 = null;
   $PricingInformation6 = null;
   $PricingInformation7 = null;
   $PricingInformation8 = null;
   $PricingInformation9 = null;
   $PricingInformation10 = null;
   $allowMOQ = 0;
   $MOQSurcharge = 0;
   $Place = null;
   $includeUnitPrice = 0;
	
   /* Quick Quote */
   $quickQuoteComment = null;
   $quickCommentMsg = $this->general_model->cleanString($siteLogcheck['userDatas'][0]->quickQuoteComment);

   if($quickCommentMsg){
	   $quickComment = 2;
	   $quickQuoteComment =  $quickCommentMsg; 
   }else{ 
	   $quickComment = 0;
   }
   /* Quick Quote */ 

   if(count($customArray['themeArray']) > 0 || $siteLogcheck['loggedIn'] == 0){ 
	
	   $PricingInformation1 = $customArray['themeArray'][0]->PricingInformation1;
	   $PricingInformation2 = $customArray['themeArray'][0]->PricingInformation2;
	   $PricingInformation3 = $customArray['themeArray'][0]->PricingInformation3;
	   $PricingInformation4 = $customArray['themeArray'][0]->PricingInformation4;
	   $PricingInformation5 = $customArray['themeArray'][0]->PricingInformation5;
	   $PricingInformation6 = $customArray['themeArray'][0]->PricingInformation6;
	   $PricingInformation7 = $customArray['themeArray'][0]->PricingInformation7;
	   $PricingInformation8 = $customArray['themeArray'][0]->PricingInformation8;
	   $PricingInformation9 = $customArray['themeArray'][0]->PricingInformation9;
	   $PricingInformation10 = $customArray['themeArray'][0]->PricingInformation10;
	   $allowMOQ = $customArray['themeArray'][0]->allowMOQ;
	   $MOQSurcharge = $customArray['themeArray'][0]->MOQSurcharge;
	   $includeUnitPrice = $customArray['themeArray'][0]->includeUnitPrice;

	   	foreach($getCurrencyDatas as $skinnedCurrency)//foreach loop  
   		{
			    //print_r($skinnedCurrency->currencyCountry);
			    if($FGCurrency == $skinnedCurrency->currencyName){
					$Place = $skinnedCurrency->currencyCountry;
				}
		}
	 
   }

   /* CHanges log */ 
   $changesCount =  $getChangesItem['resultChangesTwoCount'];
   $changesCountFin = " - ".$changesCount;
  


   // Changes type 
   if($getChangeType){
	   $makeChangesTypeArray[] = array('indexNum'=> 0, 'changeType'=> 'Select Option');
	   foreach($getChangeType as $type)//foreach loop  
	   {     
		   $makeChangesTypeArray[] = array('indexNum'=> $type->indexNum, 'changeType'=>$type->changeType);
		   
	   }
	   $getChangeTypeJson = json_encode($makeChangesTypeArray,JSON_PRETTY_PRINT); 
   }
   
   /* Secondary Account Active */
   $secondaryActiveIs = 0;
   if($siteLogcheck['secondaryIDActive']){
	  
	    $secondaryActiveIs = 1;
	    $secondaryIDActive = $siteLogcheck['secondaryIDActive'];
   }else{
		$secondaryIDActive = null; 
   } 
  
   //Currencies datas
   foreach($getCurrencyDatas as $gc)//foreach loop  
   {    
		$getCurrencyDatasArray[] = $gc;
   }
   $getCurrencyDatasFinal = json_encode($getCurrencyDatasArray,JSON_PRETTY_PRINT);  
   /* Secondary Account Active */  
	
?>

 

<script> 
 
//This is to set item code sessionStorage for main and skinned TRENDS websites 
$(document).ready(function (e) {   
		sessionStorage.setItem("itemCode", '<?=$itemcode?>'); 
});

 
tgpApp.controller("itemCtrl",  ['$scope', '$http',  'Upload', '$timeout', '$window', '$sce', '$compile',   function($scope,  $http, Upload, $timeout, $window, $sce, $compile){    


// Access user only 
<?php if ($siteLogcheck['loggedIn'] == 1 || $skinnedUserCheck['skinnedLoggedIn'] == 1 ||  $customArray['themeArray'][0]->showPricing == 1): ?>


/* Starts Pricing here */
/* Declare variables */
   $scope.priceTypeRadio = <?php echo $getPriceType; ?>;
   var selectedRadio = null;
   $scope.FGCode = <?=$itemcode?>; 
   $scope.FGCurrency =   '<?php echo $FGCurrency; ?>';
   $scope.qty1 = false;
   $scope.qty2 = false;
   $scope.qty3 = false;
   $scope.qty4 = false;
   $scope.qty5 = false;
   $scope.qty6 = false; 
   $scope.priceTypeRadioTabs = [];
   $scope.AdditionalCostsTotal = [];
   $scope.showbuttonSetup = false;
   $scope.buysetup = 'exc. setups';
   $scope.incSetup = false;
   $scope.priceadsCount= 0;
   $scope.setupAdditionalValues = [];
   $scope.IncSetupsAdditionalCostsTotal = [];
   var quantityArrayValues;
   $scope.SurchargeValue = 15;
   $scope.disabledQty1 = false;
   $scope.disabledQty2 = false;
   $scope.disabledQty3 = false;
   $scope.disabledQty4 = false;
   $scope.disabledQty5 = false;
   $scope.disabledQty6 = false; 
   $scope.cartonQuantity = <?=$cartonQuantity?>;
   $scope.cartonWeight = <?=$cartonWeight?>;
   $scope.cartonVolume = <?=$cartonVolume?>; 
   $scope.cartonLength = <?=$cartonLength?>;
   $scope.cartonWidth = <?=$cartonWidth?>;
   $scope.cartonHeight = <?=$cartonHeight?>; 

   $scope.productCode = <?=$itemcode?>;
   $scope.kgRate = 4;
   $scope.baseCharge = 10;
   $scope.userIDmarkup = <?=$userID?>;
   $scope.setupMarkupTemporaryOnly = 0;
   $scope.showData = true;
   $scope.productID = <?=$Prim?>;
   $scope.showSearchBox = false;  
   
   $scope.ausTransit = '';
   $scope.inputSearchBox = true; 
   $scope.inputSearchResult = false;  
   $scope.showTableTransit = false;  
   $scope.pricingTypeDefaultOutputFin = <?=$pricingTypeDefaultOutputFin?>;
   $scope.reqfreightDefaultOutputFin = <?=$reqfreightDefaultOutputFin?>;
   $scope.priceResultsUserMarks = [];
   $scope.MOQCharge = 15;
   $scope.SkinnedSiteDefaultMOQCharge = 20;
   $scope.PricingInformation1 = '<?=$PricingInformation1?>';
   $scope.PricingInformation2 = '<?=$PricingInformation2?>';
   $scope.PricingInformation3 = '<?=$PricingInformation3?>';
   $scope.PricingInformation4 = '<?=$PricingInformation4?>';
   $scope.PricingInformation5 = '<?=$PricingInformation5?>';
   $scope.PricingInformation6 = '<?=$PricingInformation6?>';
   $scope.PricingInformation7 = '<?=$PricingInformation7?>';
   $scope.PricingInformation8 = '<?=$PricingInformation8?>';
   $scope.PricingInformation9 = '<?=$PricingInformation9?>';
   $scope.PricingInformation10 = '<?=$PricingInformation10?>';
   $scope.allowMOQ = '<?=$allowMOQ?>';
   $scope.MOQSurcharge = '<?=$MOQSurcharge?>';
   $scope.Place = '<?=$Place?>';
   $scope.includeUnitPrice = '<?=$includeUnitPrice?>';
   $scope.quickComment = '<?=$quickComment?>';
   $scope.quickQuoteComment = '<?=$quickQuoteComment?>';
   $scope.changesCount = '<?=$changesCountFin?>';
   $scope.loadingMsg = true; 
   
   //Markup
   $scope.markup1NewVariable = 0;
   $scope.markup2NewVariable = 0;
   $scope.markup3NewVariable = 0;
   $scope.markup4NewVariable = 0;
   $scope.markup5NewVariable = 0;
   $scope.markup6NewVariable = 0;

   $scope.qtyBuyExcludeSetupAlls = 0; 
   $scope.secondaryIDActive = '<?=$secondaryIDActive?>';
   $scope.getCurrencyDatasFinal = <?=$getCurrencyDatasFinal?>;
   $scope.IncludeFreightUnitPrice = false;
   $scope.IncludeFreightUnitPriceNew = false;
   $scope.includeFreightActivate = false;
   $scope.isthisTrue = 0;
   $scope.firstTime = true;
   $scope.incFreightMsg = "";
   $scope.addsLoopLength = 0;
   $scope.refreshIncludeFreight = false;
   $scope.AdditionalsLoop = [];
   $scope.freightValue = 0; 
   $scope.globalFreightSelected = 0;
   $scope.FinalFreightCosts = 0;
   $scope.originalAdditionalLoopCount = 0;
   $scope.splitDeliveryFake = false;
   $scope.noteLessThanMOQ = false; 
   $scope.noteLessThanMOQDefault = false;
   $scope.selectedFreight = false;
   $scope.value2Touched = false;
   $scope.touched = false;
   /* Declare variables */



   
	   /* INclude Setup function */
	   $scope.includeSetup = function(condition, optc, optF, optG ){
 
		 
		   var optc = optc || null;
		   var optF = optF || null;
		   var optG = optG || null;
		  
		   
		   //Reset enabled quantity
		   $scope.defaultQtyEnabled();
		   
		    
		   /* Added new condition and update here for each user to save the include setup 1 or 0 in column quoteStyle */
		   var cond;
		   if(condition == true){
			   cond = 1;
		   }else{
			   cond = 0;
		   } 
		   if(optc == 'changethis'){  
			   $http({
						   method: "post",
						   url:  "<?php echo base_url();?>Pricing/PricingPost",
						   data: {  userID: $scope.userIDmarkup, option: 9, cond: cond } 

					   }).then(function successCallback(updateIncludeSetup) { 
						   //console.log(updateIncludeSetup.data);
					   }, function errorCallback(updateIncludeSetup) {
						   console.log("Error updating the updateIncludeSetup");
			   });   
		   }
		   /* Added new condition and update here for each user to save the include setup 1 or 0 in column quoteStyle */
 
		   
		   if(condition == true){
			   $scope.showbsetupMarkup = false;
			   $scope.showbuttonSetup = true;
			   $scope.buysetup = 'inc. setups';
			   $scope.incSetup = true; 
			   var newpriceCount = $scope.priceadsCount - 1;
			   //console.log(angular.element('#getAdditionalID0').val());
			   
			   if($scope.incSetup == true){ 
				//console.log($scope.AdditionalsLoop); 
				//console.log($scope.AdditionalCostsTotal);
				   //Message 
		   		   $scope.setupFreightConditions($scope.buysetup, optF); 
					 
					//Override

					if(optc != 'changethis' ){   
						$scope.includeFreight(optF, $scope.FGCurrency, $scope.buysetup, optG);
					}

					if( (optc  == 'changethis' &&  optF == true) || $scope.IncludeFreightUnitPrice == true){   
						 newpriceCount = newpriceCount + 1;
					} 
					 
				 
				    $scope.onchangeIncludeSetup(newpriceCount, $scope.incSetup);
				   
				   
			   }
 
			   
			   $scope.setupMarkupNew = 0; 
		   }else{  
			 
			   $scope.showbsetupMarkup = true;
			   $scope.showbuttonSetup = false;
			   $scope.buysetup = 'exc. setups';
			   $scope.incSetup = false; 
			   var newpriceCount = $scope.priceadsCount - 1; 

				//Message 
				$scope.setupFreightConditions($scope.buysetup, optF); 

				if(optc != 'changethis' ){   
						$scope.includeFreight(optF, $scope.FGCurrency, $scope.buysetup, optG);
				}

				 

			   $scope.onchangeIncludeSetup(newpriceCount, $scope.incSetup); 
			   $scope.setupMarkupNew = $scope.setupMarkup;
		   } 

		   	 
					
				 
		   
	   }  

	   $scope.onchangeIncludeSetup = function(newpriceCount, incSetup){ 

		   $scope.additionalCostCount = newpriceCount; 
		  
		  
		    if(newpriceCount > 0){
				for(var x = 0; x <= newpriceCount; x++){
					$scope.setupAdditionalValues = angular.element('#getAdditionalValues' + x).val();   
					
					if (typeof $scope.setupAdditionalValues === 'undefined') { 
						$scope.setupAdditionalValues = '0, 0, 0, 0, 0, 0, 0'; 
					} 
					var setupArrs = $scope.setupAdditionalValues.split(',');   
					
						// console.log(setupArrs[0] + " /1/ " + setupArrs[1] + " /2/ " + setupArrs[2] + " /3/ " + setupArrs[3] + " /4/ " + setupArrs[4] + " /5/ " + $scope.incSetup + " /6/ " + setupArrs[5])
					
					//Added the valueInput2 *************************
					$scope.getAdditionalCostQuantity(setupArrs[0], setupArrs[1], setupArrs[2], setupArrs[3], setupArrs[4],  $scope.incSetup, setupArrs[5] ); 
				
				} 
			 
		    }	
				
			<?php if ($skinnedUserCheck['skinnedLoggedIn'] == 1 ||  $customArray['themeArray'][0]->showPricing == 1){  ?>  
				if(newpriceCount == 0){
					$scope.getAdditionalCostQuantity(0, 0, 0, 0, 0,  $scope.incSetup, 0); 
				} 
			<?php } ?>	

			

		  
	   }

   /* INclude Setup function  */ 


	  /***** NEW UPGRADE PRICING **********************/
	$scope.getFreightValues = function(freights, incSetup, changethis,  IncludeFreightUnitPrice){
	 
		$scope.globalFreightSelected = freights; 
		$scope.freightValue = freights; 
		$scope.includeSetup(incSetup, null, IncludeFreightUnitPrice);
	}

   	/*************************************** INCLUDE FREIGHT NEW UPGRADE *********************************************/
	$scope.includeFreight = function(IncludeFreightUnitPrice, FGCurrency, buysetup, removeOnce){ 
		 
		// console.log(IncludeFreightUnitPrice + " / " + FGCurrency + " / " + buysetup + " / " + removeOnce);
		//Message   
		$scope.IncludeFreightUnitPriceNew = IncludeFreightUnitPrice;
		$scope.setupFreightConditions(buysetup, IncludeFreightUnitPrice);
  
		
	}
	

	$scope.setupFreightConditions = function(buysetup, opts){

		var opts = opts || null;

		//console.log(buysetup + " : " + opts) 
		 
		if($scope.IncludeFreightUnitPriceNew == true || opts == true){
			var ext;
			if(buysetup == ''){
				ext = ' inc ';
			}else{
				ext = ' and ';
			}
			$scope.incFreightMsg = ext + " freight";
		}

		if(opts == null || opts == ""){
			$scope.incFreightMsg = "";
		}
			
	}
  /*************************************** INCLUDE FREIGHT NEW UPGRADE *********************************************/

   /* First get the Currency when tab is clicked */
   $scope.getCurrency = function(Curr){ 
	    //console.log( $scope.getCurrencyDatasFinal );

	  	var variableCurr = Curr;

		Curr = $scope.foreachCurrencies($scope.getCurrencyDatasFinal, Curr);

	  
	   $scope.CurrencyUpdate = Curr;  

	   //$scope.getQuoteMessage();

	   //console.log($scope.pricingTypeDefaultOutputFin);
	   /*************************************************************************************NOTE IF PRICES IS NULL */
	   if($scope.pricingTypeDefaultOutputFin == null){
		   $scope.noData = true;
		   $scope.showData = false;
		   $scope.notAvailable = 'Prices not available, please contact your Account Manager for a quote.';
		   return;
	   }
	   /*************************************************************************************NOTE IF PRICES IS NULL */

	   var arrPT = [];
	   $scope.pricingTypeDefaultOutputFin.forEach(function(item){ 
		   if(Curr == item.defaultCurrency){
			   //console.log(Curr + " = " + item.defaultPricingType);
			   arrPT.push({
				   PricingType: item.defaultPricingType
			   });
		   } 
	   });
	   
	   $scope.outputCurrency = arrPT; 
	   
				   
				   if ($scope.outputCurrency === undefined || $scope.outputCurrency.length == 0) {
					   //console.log(" NO DATA " + Curr );
					   $scope.noData = true;
					   $scope.showData = false;
					   var notAvailTemp = 'This item is not available for delivery to ';

					   var CurrCountry =  $scope.foreachCurrencyCountry($scope.getCurrencyDatasFinal, variableCurr);
					   var cntry = CurrCountry; 
					   //console.log(CurrCountry);
					 
					   $scope.notAvailable = notAvailTemp + cntry;
					   
				   }else{ 
					   //console.log(" APPROVED ");
					   $scope.showData = true;
					   $scope.noData = false;
					   //console.log(responseCurrency.data);
					   $scope.priceTypeRadio = $scope.outputCurrency; 
					   //console.log($scope.priceTypeRadio);
					   $scope.FGCurrency =   Curr;   
					   $scope.currentPricingType = $scope.priceTypeRadio[0].PricingType; 
					   $scope.selectTypeRadio($scope.priceTypeRadio[0].PricingType);  
					   
				   } 
   }
   
   /* First get the Currency when tab is clicked */
   
   
   /* Radio button select and default value */ 
   $scope.selectTypeRadio = function(sel){ 
	 
	   if(sel == 0){ 
			
			   if($scope.priceTypeRadio == null){
				   return; 
			   }else{
				   var countpriceType = $scope.priceTypeRadio.length;  
				   /* Get the first array value by default */
				   selectedRadio = $scope.priceTypeRadio[0]; 
			   } 
	   }else{
			
		   selectedRadio = sel; 
	   } 

	   /* Reset Array values every selected priceType */
	   $scope.currentSelected = selectedRadio; 
	   $scope.AdditionalCostsTotal.length = 0;  

	   /* Reset Array values */
	   
		   //console.log(selectedRadio + $scope.FGCode);
		   /* Get the Pricing using the PriceType in productsPricing Table */
		   $http({
				   method: "post",
				   url:  "<?php echo base_url();?>Pricing/PricingPost",
				   data: {FGCode: $scope.FGCode, PriceType: selectedRadio, FGCurrency: $scope.FGCurrency, option: 1, userID: $scope.userIDmarkup, secondaryIDActive: $scope.secondaryIDActive  } 
				   
		   }).then(function successCallback(response) {
			    

					   /* QuoteSTyle */
					   
					   if(response.data.userMarkups == null  ){
								   //Soon for themesite
								   //$scope.priceResultsUserMarks = null; 

								   $http({
										   method: "post",
										   url:  "<?php echo base_url();?>Pricing/PricingPost",
										   data: {option: 14, skinnedCustomerNumber: '<?=$customArray['themeArray'][0]->CustomerNumber?>', skinnedThemeID: '<?=$customArray['themeArray'][0]->themeID?>' } 
										   
								   }).then(function successCallback(response) {
									      
										 

										   $scope.priceResultsUserMarks = response.data.userMarkups;
 

										   //Reset the Include Setup
										   if( $scope.priceResultsUserMarks.quoteStyle == 1){
												   $scope.includeSetup(true);
												   $scope.incSetup = true; 
										   }else{ 
												   $scope.includeSetup(false);
												   $scope.incSetup = false; 
										   } 
										   

									   }, function errorCallback(response) {
									   console.log("Error retrieving the skinned Markups");
								   });  
							   


					   }else{
						   
						   $scope.priceResultsUserMarks = response.data.userMarkups;
						   
						    
					   }

					  
					   
					   //console.log($scope.priceResultsUserMarks); 

					   if( $scope.priceResultsUserMarks.quoteStyle == 1){
							   $scope.includeSetup(true);
							   $scope.incSetup = true; 
							   
					   }else{ 
							   $scope.includeSetup(false);
							   $scope.incSetup = false; 
								
					   } 
					   /* QuoteSTyle End */	 

					   $scope.AdditionalCostsTotal = []; 

					   $scope.priceResults = response.data.resultData; 
					    //console.log("response.data:");	
					   // console.log(response.data);
					   
					   if(response.data.priceAdditionals == null){
						   $scope.AdditionalsLoop = [];
						   $scope.AdditionalsLoop[0]  = {adds: "-", cost: "0.00", setup:"0", fieldPosition: 1, inputVal: 0};
						   $scope.priceadsCount = 1;
							
					   }else{
						   
						   $scope.priceadsCount = response.data.priceAdditionals.length;
							 
						   <?php if(count($customArray['themeArray']) == 0 || $siteLogcheck['loggedIn'] == 1): ?>  
							   $scope.AdditionalsLoop = response.data.priceAdditionals;  
						   <?php endif;  ?>

						  
						   //console.log(response.data.priceAdditionalsBIGARRAYS);
						   
						   /* GET ADDITIONAL PRICE FOR SKINNED SITE */
						   <?php if ($skinnedUserCheck['skinnedLoggedIn'] == 1 ||  $customArray['themeArray'][0]->showPricing == 1){  ?> 
									   $http({
											   method: "post",
											   url:  "<?php echo base_url();?>Pricing/PricingPost",
											   data: {FGCode: $scope.FGCode, PriceType: selectedRadio, FGCurrency: $scope.FGCurrency, option: 15, skinnedSetupMarkups: '<?=$customArray['themeArray'][0]->SetupMarkup?>', skinnedBrandingMarkups: '<?=$customArray['themeArray'][0]->BrandingPriceMarkup?>'  } 
											   
									   }).then(function successCallback(responseAdds) { 
										 
											$scope.AdditionalsLoop = responseAdds.data.priceAdditionals;   
											//console.log("Skinnedsite");
											 //console.log($scope.AdditionalsLoop); 
									   
									   }, function errorCallback(responseAdds) {
										   console.log("Error retrieving the skinned site additional price");
									   });  

									   //Replace MOQ allow or no
									   var lmoq = '<?=$customArray['themeArray'][0]->allowMOQ?>';
									   var yon = null; 	//Yes Or No
									   var mq = 0;
									   if(lmoq == '1'){
										   yon = 'Y';
										   mq = '<?=$customArray['themeArray'][0]->MOQSurcharge?>'; 
										   if(mq == ""){
											   //Set to default
												mq = $scope.SkinnedSiteDefaultMOQCharge;
										   }
									   }
									   if(lmoq == '0'){
										   yon = 'N';
									   }
									   
										$scope.priceResults.LessThanMOQ  = yon;
										$scope.MOQSurcharge = parseInt(mq);
							   
						   <?php } ?>
						   /* GET ADDITIONAL PRICE FOR SKINNED SITE */  
						   
					   }
					   
					 


					   //Quantity changes for FreightCOst without additional cost
					   if($scope.additionalCostCount < 0){ 
						   $scope.noAdditionalCost();
					   }
					  
					   //console.log("$scope.priceResults.LessThanMOQ " + $scope.priceResults.LessThanMOQ + " / " + $scope.MOQSurcharge);
					   /* Less than MOQ */
					   $scope.LessThanMOQ = $scope.priceResults.LessThanMOQ; 
					   

					   /* Additional Description */
					   $scope.AdditionalText = $scope.priceResults.AdditionalText; 

					   /* heading quantity */
					   $scope.headingQuantity1	= $scope.priceResults.Quantity1;
					   
					   $scope.headingQuantity2	= $scope.priceResults.Quantity2;
					   
					   $scope.headingQuantity3	= $scope.priceResults.Quantity3;
					   
					   $scope.headingQuantity4	= $scope.priceResults.Quantity4;
					   
					   $scope.headingQuantity5	= $scope.priceResults.Quantity5;
					   
					   $scope.headingQuantity6	= $scope.priceResults.Quantity6;

					   
					   
					   
					   //console.log("Direct here 1 " + $scope.headingQuantity1);
					   $scope.checkQtyEnabled($scope.headingQuantity1, $scope.headingQuantity2, $scope.headingQuantity3, $scope.headingQuantity4, $scope.headingQuantity5, $scope.headingQuantity6);			
					   //console.log("XXX 1");

					   /* heading quantity */ 
					   /* Declare Price1 to 6 */
					   $scope.price1Temp =  parseFloat(response.data.resultData.Price1); 
					   $scope.price2Temp =  parseFloat(response.data.resultData.Price2); 
					   $scope.price3Temp =  parseFloat(response.data.resultData.Price3); 
					   $scope.price4Temp =  parseFloat(response.data.resultData.Price4); 
					   $scope.price5Temp =  parseFloat(response.data.resultData.Price5); 
					   $scope.price6Temp =  parseFloat(response.data.resultData.Price6); 

					   //console.log("CHECK IF PASOK HERE SKINNED SITE ==> " + $scope.price1Temp);

					   /* Declared Quantity */ 
					   $scope.Quantity1 = Number($scope.priceResults.Quantity1); 
					   $scope.Quantity2 = Number($scope.priceResults.Quantity2);
					   $scope.Quantity3 = Number($scope.priceResults.Quantity3);
					   $scope.Quantity4 = Number($scope.priceResults.Quantity4);
					   $scope.Quantity5 = Number($scope.priceResults.Quantity5);
					   $scope.Quantity6 = Number($scope.priceResults.Quantity6);  
					   
					   $scope.Price1 = $scope.priceResults.Price1; 
					   $scope.Price2 = $scope.priceResults.Price2;
					   $scope.Price3 = $scope.priceResults.Price3;
					   $scope.Price4 = $scope.priceResults.Price4;
					   $scope.Price5 = $scope.priceResults.Price5;
					   $scope.Price6 = $scope.priceResults.Price6;  
					  
					   /* ONLY FOR THE SKINNED SITE */
					   <?php if ($skinnedUserCheck['skinnedLoggedIn'] == 1 ||  $customArray['themeArray'][0]->showPricing == 1){  ?>
							   
						   //console.log("SKINNED SITE HERE TO INCREASE PRICING 6 = " + $scope.price6Temp);
							   $scope.priceResults.Price1 =  $scope.price1Temp  * (($scope.priceResultsUserMarks.markup1 * 0.01)+1); 
							   $scope.Price1 = $scope.priceResults.Price1;

							   $scope.priceResults.Price2 =  $scope.price2Temp  * (($scope.priceResultsUserMarks.markup2 * 0.01)+1); 
							   $scope.Price2 = $scope.priceResults.Price2;

							   $scope.priceResults.Price3 =  $scope.price3Temp  * (($scope.priceResultsUserMarks.markup3 * 0.01)+1); 
							   $scope.Price3 = $scope.priceResults.Price3;

							   $scope.priceResults.Price4 =  $scope.price4Temp  * (($scope.priceResultsUserMarks.markup4 * 0.01)+1); 
							   $scope.Price4 = $scope.priceResults.Price4;

							   $scope.priceResults.Price5 =  $scope.price5Temp  * (($scope.priceResultsUserMarks.markup5 * 0.01)+1); 
							   $scope.Price5 = $scope.priceResults.Price5;

							   $scope.priceResults.Price6 =  $scope.price6Temp  * (($scope.priceResultsUserMarks.markup6 * 0.01)+1); 
							   $scope.Price6 = $scope.priceResults.Price6; 

								

							   $scope.price1Temp =  parseFloat($scope.priceResults.Price1); 
							   $scope.price2Temp =  parseFloat($scope.priceResults.Price2); 
							   $scope.price3Temp =  parseFloat($scope.priceResults.Price3); 
							   $scope.price4Temp =  parseFloat($scope.priceResults.Price4); 
							   $scope.price5Temp =  parseFloat($scope.priceResults.Price5); 
							   $scope.price6Temp =  parseFloat($scope.priceResults.Price6); 
							   //replace 10 into MOQSurcharge 
							   //console.log("$scope.MOQSurcharge", $scope.MOQSurcharge)
							   $scope.SurchargeValue = $scope.MOQSurcharge; 

					   <?php } ?>
					   /* ONLY FOR THE SKINNED SITE */
					  
					   

					   //Refresh Markups
					   var elementMarkupSave = angular.element('.markupsave'); 
					   elementMarkupSave.css('display', 'none'); 
				   
					   var elementmarkInput = angular.element('.markInput'); 
					   elementmarkInput.css('border', '1px solid #494949'); 
					   
					   //console.log("NEwest ");
					   //console.log($scope.priceResults.userMarkups.setupMarkup);
					   /*$scope.setupMarkupsN =  response.data.userMarkups.setupMarkup; */
					   $scope.markup1 =  $scope.priceResultsUserMarks.markup1;
					   $scope.markup2 =  $scope.priceResultsUserMarks.markup2;
					   $scope.markup3 =  $scope.priceResultsUserMarks.markup3;
					   $scope.markup4 =  $scope.priceResultsUserMarks.markup4;
					   $scope.markup5 =  $scope.priceResultsUserMarks.markup5;
					   $scope.markup6 =  $scope.priceResultsUserMarks.markup6;  

					   

					   quantityArrayValues =new Array(
						   $scope.priceResults.Quantity1, $scope.priceResults.Quantity2,
						   $scope.priceResults.Quantity3, $scope.priceResults.Quantity4,
						   $scope.priceResults.Quantity5
					   );

					   
					   

		   }, function errorCallback(response) {
			   console.log("Error retrieving the data selectTypeRadio");
		   });  
	   
   }
   /* END Radio button  
	   ************
   */ 

   /****************** UPGRADE *******************************************/
   $scope.changeTheSame = function(valueInput, perUnit, rank, defaultInit, incSetupValue, setupBool, valueInput2){
		
 		
		var trigger = $scope.triggerDetector(rank);
		//console.log(trigger);
		if(trigger == 0){ 
			var rankFin = rank - 1;
			$scope.AdditionalsLoop[rankFin]['inputVal2'] = valueInput; 
		}

		

		//console.log(valueInput + "/" + rank);
   }

   $scope.triggerDetector = function(rank){
		var trigger = 0;
		if(angular.element('#qtyTd' + rank).hasClass('rankTd' + rank)){
		 	trigger = 1;
		} 
		return trigger;
   } 

    $scope.checkThisQty = function(valueInput, perUnit, rank, defaultInit, incSetupValue, setupBool, valueInput2){
		$scope.value2Touched = false;
		if(valueInput2){
			$scope.value2Touched = true;
		}
		
		var rankFin = rank - 1;
		if(rankFin == 0){ 
			if(valueInput2 == 0){
				//$scope.AdditionalsLoop[0]['inputVal2'] = 1; 
			}
		}	

		 
   }
 /****************** UPGRADE *******************************************/

   /* Get additional cost quantity */
   
   var addcost = null;
   var arrayAdditionals;
   var addcostAndSetup;
   var addcostAndSetupArray;
   $scope.getAdditionalCostQuantity = function(valueInput, perUnit, rank, defaultInit, incSetupValue, setupBool, valueInput2, opt){
	   var defaultInit = defaultInit || null;  
	   var setupBool = setupBool || null; 
	   var opt = opt || null;

	 //console.log(valueInput + " ////////////////// " + valueInput2  );
	   
	  //console.log(valueInput + " ////////////////// " + perUnit + " ////////////////// rank => " + rank + " ///////////////////////////// " + incSetupValue + " ///////////////setupBool = " + setupBool + " ////////////// valueInput2 = " + valueInput2 + "/////////////////////// opt = " + opt);
	  //console.log("$scope.AdditionalsLoop =>> ");
	   //console.log($scope.AdditionalsLoop);
 

	   $scope.checkQtyEnabled($scope.headingQuantity1, $scope.headingQuantity2, $scope.headingQuantity3, $scope.headingQuantity4, $scope.headingQuantity5, $scope.headingQuantity6);	

					   /* MOQ NEW */
					 

					   $scope.hideMOQ1 = true;
					   $scope.hideMOQ2 = true;
					   $scope.hideMOQ3 = true;
					   $scope.hideMOQ4 = true;
					   $scope.hideMOQ5 = true;
					   $scope.hideMOQ6 = true;

					   /* LESS THAN MOQ BGCOLOR AND HIDE ELEMENT */
					   //console.log("$scope.LessThanMOQ " + $scope.LessThanMOQ);
					   $scope.hideMOQFunction($scope.LessThanMOQ);
					   
					   
					   /* MOQ NEW */	
		   
   /* ONLY FOR THE SKINNED SITE */
   <?php if ($skinnedUserCheck['skinnedLoggedIn'] == 1 ||  $customArray['themeArray'][0]->showPricing == 1){  ?>  
		
	   if($scope.incSetup == true){  
	 
				
   <?php }else{  ?>

	   if($scope.incSetup == true && incSetupValue){
		 

   <?php }  ?>

  			 
			 
			   //Remove duplicate
			   var countAdditionals = $scope.AdditionalCostsTotal.length; 
			    
			   /* Looking for an existing array and remove */
			   if(countAdditionals > 0){
				   if(rank){
					   angular.forEach($scope.AdditionalCostsTotal, function(vals, keys){
						   //theArray[index] = "hello world";
						   if(rank == vals[0]){ 
							   $scope.AdditionalCostsTotal[keys] = 'x'; //assign an x so it will remove on splice
							   //console.log($scope.AdditionalCostsTotal);
							   $scope.AdditionalCostsTotal = $scope.removeRank($scope.AdditionalCostsTotal, $scope.AdditionalCostsTotal[keys]); 	 
						   }
					   });	
				   }
			   } 
		   
			   addcost =  Number(perUnit)  *  Number(valueInput);  
 
			   if( (valueInput > 0 && valueInput2 == 0)  ){ 
					valueInputFin = valueInput;  
					 
					if(opt == 2){   
						valueInputFin = valueInput2;   
					}


					<?php if(count($customArray['themeArray']) == 0 || $siteLogcheck['loggedIn'] == 1): ?>   
						 //If skinnedsites
						if(  (opt == "letmein"   && valueInput2 == 0) ||  (opt != 1   && valueInput2 == 0) ){ 
						//if(  opt == "letmein" || valueInput2 == 0){  
							valueInputFin = 0; 
						}
					<?php endif; ?>

			   }else{    
				 
				 
					valueInputFin = valueInput2;  

					if(opt == 1){    
						//Edit detector
						var trigger = $scope.triggerDetector(rank); 
						if(trigger == 0){ 
							valueInputFin = valueInput; 
						}
						
					}
					if(opt == "letmein"){  
						valueInputFin = 0; 
					}
			   }  
			   

			   addsetup =  Number(incSetupValue) *  Number(valueInputFin); 
			   addcostAndSetupArray =   [rank,addcost,addsetup];
			   $scope.AdditionalCostsTotal.push(addcostAndSetupArray); 
			  // console.log("$scope.AdditionalCostsTotal New = ");
			  // console.log($scope.AdditionalCostsTotal);
			   $scope.computeIncSetupAdditionalCostsTotal($scope.AdditionalCostsTotal); 
			  
			   //Get Details			
			  // $scope.getDetailLoopNew($scope.AdditionalsLoop); 
			   
		   

	   }else{
		   
		   /* Without Setup included */
		   
		   
		   /* if valueInput is not zero */ 
		   if(valueInput > 0 && perUnit != 0){  
			 
			   //Remove duplicate
			   var countAdditionals = $scope.AdditionalCostsTotal.length; 
			   /* Looking for an existing array and remove */
			   if(countAdditionals > 0){
				   if(rank){
					   angular.forEach($scope.AdditionalCostsTotal, function(vals, keys){
						   //theArray[index] = "hello world";
						   if(rank == vals[0]){ 
							   $scope.AdditionalCostsTotal[keys] = 'x'; //assign an x so it will remove on splice
							   $scope.AdditionalCostsTotal = $scope.removeRank($scope.AdditionalCostsTotal, $scope.AdditionalCostsTotal[keys]); 	 
						   }
					   });	
				   }
			   } 
			   /* add new array values */
			   addcost =  perUnit *  valueInput; 
			   addcost = Math.round(addcost * 100) / 100; //round off decimal
			   /*create array */
			   arrayAdditionals =   [rank,addcost];  
			   //console.log(arrayAdditionals);

			   /* add to object array values */
			   $scope.AdditionalCostsTotal.push(arrayAdditionals); 
			   //console.log("/*******************/");
			   
			   //console.log("Additionals here " + $scope.userIDmarkup);
			   //console.log($scope.AdditionalsLoop);

			   //Get Details			 
			   //$scope.getDetailLoop($scope.AdditionalsLoop, null, opt, valueInput2, rank);
			   
			   /* Total computation  */
			   $scope.computeAdditionalCostsTotal($scope.AdditionalCostsTotal);
		   }  

		   
		   /* Return back to Zero find the value and remove on array */
		   if(defaultInit == 0 &&  valueInput == 0 && perUnit != 0){   
			 
			   angular.forEach($scope.AdditionalCostsTotal, function(vals, keys){
				   if(rank == vals[0]){ 
					   $scope.AdditionalCostsTotal[keys] = 'x'; //assign an x so it will remove on splice
					   $scope.AdditionalCostsTotal = $scope.removeRank($scope.AdditionalCostsTotal, $scope.AdditionalCostsTotal[keys]); 	 
				   }
			   });
			   //$scope.AdditionalCostsTotal = $scope.removeRank($scope.AdditionalCostsTotal, rank); 
			   $scope.computeAdditionalCostsTotal($scope.AdditionalCostsTotal);

			   //Get Details 	
			   //$scope.getDetailLoop($scope.AdditionalsLoop, null, opt, valueInput2, rank);
		   } 
		   
		   if(defaultInit == 0 &&  valueInput == 0 && (perUnit == 0 || perUnit == '') ){   
			 

			   angular.forEach($scope.AdditionalCostsTotal, function(vals, keys){
				   if(rank == vals[0]){ 
					   $scope.AdditionalCostsTotal[keys] = 'x'; //assign an x so it will remove on splice
					   $scope.AdditionalCostsTotal = $scope.removeRank($scope.AdditionalCostsTotal, $scope.AdditionalCostsTotal[keys]); 	 
				   }
			   });
			   //$scope.AdditionalCostsTotal = $scope.removeRank($scope.AdditionalCostsTotal, rank); 
			   $scope.computeAdditionalCostsTotal($scope.AdditionalCostsTotal);

			   //Get Details 	
			   //$scope.getDetailLoop($scope.AdditionalsLoop, null, opt, valueInput2, rank);
			   
		   } 

		   //Get Details		
		   if(valueInput > 0 && perUnit == 0){  
			 
			   //console.log("Here 3"); 
			   //$scope.getDetailLoop($scope.AdditionalsLoop, null, opt, valueInput2, rank);
			   //Additional Jan 15, 2019
			   $scope.computeAdditionalCostsTotal($scope.AdditionalCostsTotal);
		   }

		  
		   <?php if ($skinnedUserCheck['skinnedLoggedIn'] == 1 ||  $customArray['themeArray'][0]->showPricing == 1){  ?>
		    if( $scope.AdditionalsLoop == null && valueInput  == 0 && perUnit  == 0 && rank  == 0 &&  incSetupValue  == 0 && setupBool  == null && valueInput2  == 0 && opt == null   ) {  
				
				 
				//$scope.getDetailLoop($scope.AdditionalsLoop, null, opt, valueInput2, rank); 
				$scope.AdditionalCostsTotal = [0, 0];
			    $scope.computeAdditionalCostsTotal($scope.AdditionalCostsTotal);
			} 
		   <?php } ?>


			 

	   }
	   
   }
   /* END Get additional cost quantity 
	   ************
   */

  /**** UPGRADE ********************* */
 
	$scope.resetAdditional = function(valueInput, perUnit, rank, defaultInit, incSetupValue, setupBool, valueInput2, disabled, fieldPositionDisabled){

	 
		
		if(fieldPositionDisabled == true){
			valueInput2  = valueInput;  
			$scope.AdditionalsLoop[disabled]['inputVal2'] = valueInput;
		} 
		//ISSUE ITH THE   
		$scope.getAdditionalCostQuantity(valueInput, perUnit, rank, defaultInit, incSetupValue, setupBool, valueInput2);
	}



/* No setup included  */	
   /* Total computation  */
   

   $scope.AdditionalCostsComputation = [];
   var tempTotal = [];
   
   $scope.computeAdditionalCostsTotal = function(totalCosts){
 
	      //console.log("HERE NO SETUP");
			   //////////////////////////////////IF FREIGHT BUT NO SETUPS INCLUDED
			  var splitSetup = null;
			  var spiltValue2 = null; 
			  var addSetupSplit1 = 0;
			  var addSetupSplit2 = 0;
			  var addSetupSplit3 = 0;
			  var addSetupSplit4 = 0;
			  var addSetupSplit5 = 0;
			  var addSetupSplit6 = 0; 
			
			  //console.log("$scope.IncludeFreightUnitPriceNew = " + $scope.IncludeFreightUnitPriceNew);
			  
			  if($scope.IncludeFreightUnitPriceNew == true){ 
				  //console.log("NO SETUP $scope.IncludeFreightUnitPrice => " + $scope.IncludeFreightUnitPrice + " / $scope.addsLoopLength => " + $scope.addsLoopLength);

				   

					//FREIGHT COST STARTS HERE
					//console.log("HERE FREIGHTS NO SETUP => ");
		     		//console.log($scope.FinalFreightCosts[$scope.globalFreightSelected].FreightCost1);

					 $scope.selectedFreight = $scope.FinalFreightCosts[$scope.globalFreightSelected];

					 if($scope.FinalFreightCosts[$scope.globalFreightSelected].FreightCost1 != "FREE" || $scope.FinalFreightCosts[$scope.globalFreightSelected].FreightCost2 != "FREE"){
						//console.log("FREIGHT CALCULATION HERE"); 

					    if($scope.priceResults.Quantity1){
							addFreightCost1 = $scope.FinalFreightCosts[$scope.globalFreightSelected].FreightCost1 /  $scope.priceResults.Quantity1;    
							addSetupSplit1 = addSetupSplit1 + addFreightCost1;
						}
						if($scope.priceResults.Quantity2){
							addFreightCost2 = $scope.FinalFreightCosts[$scope.globalFreightSelected].FreightCost2 /  $scope.priceResults.Quantity2;    
							addSetupSplit2 = addSetupSplit2 + addFreightCost2;
						}
						if($scope.priceResults.Quantity3){
							addFreightCost3 = $scope.FinalFreightCosts[$scope.globalFreightSelected].FreightCost3 /  $scope.priceResults.Quantity3;    
							addSetupSplit3 = addSetupSplit3 + addFreightCost3;
						}
						if($scope.priceResults.Quantity4){
							addFreightCost4 = $scope.FinalFreightCosts[$scope.globalFreightSelected].FreightCost4 /  $scope.priceResults.Quantity4;    
							addSetupSplit4 = addSetupSplit4 + addFreightCost4;
						}
						if($scope.priceResults.Quantity5){
							addFreightCost5 = $scope.FinalFreightCosts[$scope.globalFreightSelected].FreightCost5 /  $scope.priceResults.Quantity5;    
							addSetupSplit5 = addSetupSplit5 + addFreightCost5;
						}
						if($scope.priceResults.Quantity6){
							addFreightCost6 = $scope.FinalFreightCosts[$scope.globalFreightSelected].FreightCost6 /  $scope.priceResults.Quantity6;    
							addSetupSplit6 = addSetupSplit6 + addFreightCost6;
						}   


					 }

			  } 
			   
			  //////////////////////////////////IF FREIGHT BUT NO SETUPS INCLUDED  
			  
			 // console.log("addSetupSplit1 ++++++ = " + addSetupSplit1)
	 
	   //totalCosts.shift();
		   var sumTotal = 0;
		   for (var i = 0; i < totalCosts.length; i++) { 
			   sumTotal += totalCosts[i][1];
		   }  
		   sumTotal = parseFloat(sumTotal);
		   
		   //console.log("----"); 
		   $scope.sumTotalView = sumTotal; 
		   
		     
		   /* PRICE SUMMARY Buy Exculding Setup */
		   $scope.qtyBuyExcludeSetup1 = $scope.roundOff(sumTotal, $scope.price1Temp) + addSetupSplit1;
		   $scope.qtyBuyExcludeSetup2 = $scope.roundOff(sumTotal, $scope.price2Temp) + addSetupSplit2;
		   $scope.qtyBuyExcludeSetup3 = $scope.roundOff(sumTotal, $scope.price3Temp) + addSetupSplit3;
		   $scope.qtyBuyExcludeSetup4 = $scope.roundOff(sumTotal, $scope.price4Temp) + addSetupSplit4;
		   $scope.qtyBuyExcludeSetup5 = $scope.roundOff(sumTotal, $scope.price5Temp) + addSetupSplit5;
		   $scope.qtyBuyExcludeSetup6 = $scope.roundOff(sumTotal, $scope.price6Temp) + addSetupSplit6;  

		   
		   
		   <?php if ($skinnedUserCheck['skinnedLoggedIn'] == 1 ||  $customArray['themeArray'][0]->showPricing == 1){  ?>  
				if($scope.incSetup == false){
				
					$scope.qtyBuyExcludeSetup1 = $scope.roundOffNone(sumTotal, $scope.price1Temp) + addSetupSplit1;
					$scope.qtyBuyExcludeSetup2 = $scope.roundOffNone(sumTotal, $scope.price2Temp) + addSetupSplit2;
					$scope.qtyBuyExcludeSetup3 = $scope.roundOffNone(sumTotal, $scope.price3Temp) + addSetupSplit3;
					$scope.qtyBuyExcludeSetup4 = $scope.roundOffNone(sumTotal, $scope.price4Temp) + addSetupSplit4;
					$scope.qtyBuyExcludeSetup5 = $scope.roundOffNone(sumTotal, $scope.price5Temp) + addSetupSplit5;
					$scope.qtyBuyExcludeSetup6 = $scope.roundOffNone(sumTotal, $scope.price6Temp) + addSetupSplit6;
					
				}  

		   <?php } ?>
		   
		   /* PRICE SUMMARY Buy Exculding Setup */

		   /* PRICE SUMMARY Buy Exculding Total */
		   $scope.qtyBuyExcludeTotal1 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup1 * $scope.priceResults.Quantity1);
		   $scope.qtyBuyExcludeTotal2 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup2 * $scope.priceResults.Quantity2);
		   $scope.qtyBuyExcludeTotal3 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup3 * $scope.priceResults.Quantity3);
		   $scope.qtyBuyExcludeTotal4 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup4 * $scope.priceResults.Quantity4);
		   $scope.qtyBuyExcludeTotal5 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup5 * $scope.priceResults.Quantity5);
		   $scope.qtyBuyExcludeTotal6 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup6 * $scope.priceResults.Quantity6);

		   
		   $timeout(function() { 
			   $scope.qtyBuyExcludeSetupAlls = 1;
		   }, 1500);

		   /* PRICE SUMMARY Buy Exculding Total */ 
		   //console.log("$scope.Quantity1 =>  " + $scope.priceResults.Quantity1 + " < " + $scope.Quantity1 + " / $scope.SurchargeValue = " + $scope.SurchargeValue);
		   /* Quantity 1 */
		   
		   /* If qty1 is lower than the original quantity */
		   if($scope.priceResults.Quantity1 < $scope.Quantity1){ 
			//console.log("$scope.SurchargeValue", $scope.SurchargeValue);
		 	
			   //console.log($scope.priceResults.Quantity1 + ", eto yung qty1 orig " + $scope.Quantity1);
			   var priceSummaryExlSetupsTemp = $scope.SurchargeValue / $scope.priceResults.Quantity1;
			   //console.log("priceSummaryExlSetupsTemp =>  " + priceSummaryExlSetupsTemp  + " + " + $scope.qtyBuyExcludeSetup1);
			   $scope.price1TempA = parseFloat(priceSummaryExlSetupsTemp) + parseFloat($scope.qtyBuyExcludeSetup1);
			   //console.log("$scope.price1TempA =>  " + $scope.price1TempA);
			   $scope.qtyBuyExcludeSetup1 = $scope.price1TempA; 

			   //console.log("$scope.roundOffNumber =>  " + $scope.price1TempA + " * " + $scope.priceResults.Quantity1);
			   $scope.qtyBuyExcludeTotal1 = $scope.roundOffNumber($scope.price1TempA * $scope.priceResults.Quantity1);
			  // console.log("$scope.qtyBuyExcludeTotal1 =>  " + $scope.qtyBuyExcludeTotal1);
 
					
		   } 
		  
		   
		   if($scope.priceResults.Quantity1 >= $scope.Quantity2 && $scope.Quantity2 != 0){
			   //console.log($scope.priceResults.Quantity1 + ", eto yung qty2 orig " + $scope.Quantity2);
			   //console.log("ooops setup excluded... Turn into quantity 2");
			   $scope.qtyBuyExcludeSetup1 = $scope.qtyBuyExcludeSetup2; 
			   $scope.qtyBuyExcludeTotal1 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup2 * $scope.priceResults.Quantity1);
		   } 
		   if($scope.priceResults.Quantity1 >= $scope.Quantity3 && $scope.Quantity3 != 0){
			   //console.log($scope.priceResults.Quantity1 + ", eto yung qty3 orig " + $scope.Quantity3);
			   //console.log("ooops setup excluded... Turn into quantity 3");
			   $scope.qtyBuyExcludeSetup1 = $scope.qtyBuyExcludeSetup3; 
			   $scope.qtyBuyExcludeTotal1 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup3 * $scope.priceResults.Quantity1);
		   }
		   if($scope.priceResults.Quantity1 >= $scope.Quantity4 && $scope.Quantity4 != 0){
			   //console.log($scope.priceResults.Quantity1 + ", eto yung qty4 orig " + $scope.Quantity4);
			   //console.log("ooops setup excluded... Turn into quantity 4");
			   $scope.qtyBuyExcludeSetup1 = $scope.qtyBuyExcludeSetup4; 
			   $scope.qtyBuyExcludeTotal1 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup4 * $scope.priceResults.Quantity1);
		   }
		   if($scope.priceResults.Quantity1 >= $scope.Quantity5 && $scope.Quantity5 != 0){
			   //console.log($scope.priceResults.Quantity1 + ", eto yung qty5 orig " + $scope.Quantity5);
			   //console.log("ooops setup excluded... Turn into quantity 5");
			   $scope.qtyBuyExcludeSetup1 = $scope.qtyBuyExcludeSetup5; 
			   $scope.qtyBuyExcludeTotal1 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup5 * $scope.priceResults.Quantity1);
		   }
		   if($scope.priceResults.Quantity1 >= $scope.Quantity6 && $scope.Quantity6 != 0){
			   //console.log($scope.priceResults.Quantity1 + ", eto yung qty6 orig " + $scope.Quantity6);
			   //console.log("ooops setup excluded... Turn into quantity 6");
			   $scope.qtyBuyExcludeSetup1 = $scope.qtyBuyExcludeSetup6; 
			   $scope.qtyBuyExcludeTotal1 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup6 * $scope.priceResults.Quantity1);
		   }
		   /* Quantity 1 */

		   
		   /* Quantity 2 */
		   /* If qty2 is lower than the original quantity */
		   if($scope.priceResults.Quantity2 < $scope.Quantity2 && $scope.Quantity2 != 0 ){ 
			   //console.log($scope.priceResults.Quantity2 + ", eto yung qty2 orig " + $scope.Quantity2 + " this is the orig price1 " + $scope.price1Temp); 
			   if($scope.priceResults.Quantity2 < $scope.Quantity1){
				   //console.log("Mas mababa sa quantity1"); 
				   var priceSummaryExlSetupsTemp = $scope.SurchargeValue / $scope.priceResults.Quantity2;
				   var getPrice1Total = $scope.roundOff(sumTotal, $scope.price1Temp);
				   //console.log(getPrice1Total);
				   $scope.price1TempB = priceSummaryExlSetupsTemp + getPrice1Total;
				   $scope.qtyBuyExcludeSetup2 = $scope.price1TempB;
				   $scope.qtyBuyExcludeTotal2 = $scope.roundOffNumber($scope.price1TempB * $scope.priceResults.Quantity2);
			   }else{ 
				   $scope.qtyBuyExcludeSetup2 = $scope.roundOff(sumTotal, $scope.price1Temp);
				   $scope.qtyBuyExcludeTotal2 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup2 * $scope.priceResults.Quantity2);
			   }  
		   }  
		   if($scope.priceResults.Quantity2 >= $scope.Quantity3  && $scope.Quantity3 != 0 ){ 
			   $scope.qtyBuyExcludeSetup2 = $scope.qtyBuyExcludeSetup3; 
			   $scope.qtyBuyExcludeTotal2 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup3 * $scope.priceResults.Quantity2);
		   }
		   if($scope.priceResults.Quantity2 >= $scope.Quantity4  && $scope.Quantity4 != 0 ){ 
			   $scope.qtyBuyExcludeSetup2 = $scope.qtyBuyExcludeSetup4; 
			   $scope.qtyBuyExcludeTotal2 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup4 * $scope.priceResults.Quantity2);
		   } 
		   if($scope.priceResults.Quantity2 >= $scope.Quantity5  && $scope.Quantity5 != 0 ){ 
			   $scope.qtyBuyExcludeSetup2 = $scope.qtyBuyExcludeSetup5; 
			   $scope.qtyBuyExcludeTotal2 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup5 * $scope.priceResults.Quantity2);
		   }
		   if($scope.priceResults.Quantity2 >= $scope.Quantity6  && $scope.Quantity6 != 0 ){ 
			   $scope.qtyBuyExcludeSetup2 = $scope.qtyBuyExcludeSetup6; 
			   $scope.qtyBuyExcludeTotal2 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup6 * $scope.priceResults.Quantity2);
		   }
		   /* Quantity 2 */

		   /* Quantity 3 */
		   if($scope.priceResults.Quantity3 < $scope.Quantity3 && $scope.Quantity3 != 0 ){  

			   $scope.qtyBuyExcludeSetup3 = $scope.roundOff(sumTotal, $scope.price2Temp);
			   $scope.qtyBuyExcludeTotal3 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup3 * $scope.priceResults.Quantity3);

			   if($scope.priceResults.Quantity3 < $scope.Quantity2  ){
				   //console.log("Mas mababa sa quantity2 "); 
				   $scope.qtyBuyExcludeSetup3 = $scope.roundOff(sumTotal, $scope.price1Temp);
				   $scope.qtyBuyExcludeTotal3 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup3 * $scope.priceResults.Quantity3);
			   }  

			   if($scope.priceResults.Quantity3 < $scope.Quantity1){
				   //console.log("Mas mababa sa quantity1 " + $scope.priceResults.Quantity3); 
				   var priceSummaryExlSetupsTemp = $scope.SurchargeValue / $scope.priceResults.Quantity3;
				   var getPrice1Total = $scope.roundOff(sumTotal, $scope.price1Temp);
				   //console.log(getPrice1Total + priceSummaryExlSetupsTemp);
				   $scope.price1TempC = priceSummaryExlSetupsTemp + getPrice1Total;
				   $scope.qtyBuyExcludeSetup3 = $scope.price1TempC;
				   $scope.qtyBuyExcludeTotal3 = $scope.roundOffNumber($scope.price1TempC * $scope.priceResults.Quantity3);
				   //console.log($scope.price1TempC + " = " + $scope.qtyBuyExcludeSetup3);
			   }    
		   }  
		   if($scope.priceResults.Quantity3 >= $scope.Quantity4  && $scope.Quantity4 != 0 ){ 
			   $scope.qtyBuyExcludeSetup3 = $scope.qtyBuyExcludeSetup4; 
			   $scope.qtyBuyExcludeTotal3 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup4 * $scope.priceResults.Quantity3);
		   }
		   if($scope.priceResults.Quantity3 >= $scope.Quantity5  && $scope.Quantity5 != 0 ){ 
			   $scope.qtyBuyExcludeSetup3 = $scope.qtyBuyExcludeSetup5; 
			   $scope.qtyBuyExcludeTotal3 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup5 * $scope.priceResults.Quantity3);
		   }
		   if($scope.priceResults.Quantity3 >= $scope.Quantity6  && $scope.Quantity6 != 0 ){ 
			   $scope.qtyBuyExcludeSetup3 = $scope.qtyBuyExcludeSetup6; 
			   $scope.qtyBuyExcludeTotal3 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup6 * $scope.priceResults.Quantity3);
		   }
		   /* Quantity 3 */

		   /* Quantity 4 */
		   if($scope.priceResults.Quantity4 < $scope.Quantity4 && $scope.Quantity4 != 0 ){  

			   $scope.qtyBuyExcludeSetup4 = $scope.roundOff(sumTotal, $scope.price3Temp);
			   $scope.qtyBuyExcludeTotal4 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup4 * $scope.priceResults.Quantity4);

			   if($scope.priceResults.Quantity4 < $scope.Quantity3  ){
				   //console.log("Mas mababa sa quantity3 "); 
				   $scope.qtyBuyExcludeSetup4 = $scope.roundOff(sumTotal, $scope.price2Temp);
				   $scope.qtyBuyExcludeTotal4 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup4 * $scope.priceResults.Quantity4);
			   }   
			   if($scope.priceResults.Quantity4 < $scope.Quantity2  ){
				   //console.log("Mas mababa sa quantity2 "); 
				   $scope.qtyBuyExcludeSetup4 = $scope.roundOff(sumTotal, $scope.price1Temp);
				   $scope.qtyBuyExcludeTotal4 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup4 * $scope.priceResults.Quantity4);
			   }  
			   
			   if($scope.priceResults.Quantity4 < $scope.Quantity1){
				   //console.log("Mas mababa sa quantity1 " + $scope.priceResults.Quantity4); 
				   var priceSummaryExlSetupsTemp = $scope.SurchargeValue / $scope.priceResults.Quantity4;
				   var getPrice1Total = $scope.roundOff(sumTotal, $scope.price1Temp);
				   //console.log(getPrice1Total + priceSummaryExlSetupsTemp);
				   $scope.price1TempD = priceSummaryExlSetupsTemp + getPrice1Total;
				   $scope.qtyBuyExcludeSetup4 = $scope.price1TempD;
				   $scope.qtyBuyExcludeTotal4 = $scope.roundOffNumber($scope.price1TempD * $scope.priceResults.Quantity4);
				   //console.log($scope.price1TempD + " = " + $scope.qtyBuyExcludeSetup4);
			   }    

		   }  
		   if($scope.priceResults.Quantity4 >= $scope.Quantity5  && $scope.Quantity5 != 0 ){ 
			   $scope.qtyBuyExcludeSetup4 = $scope.qtyBuyExcludeSetup5; 
			   $scope.qtyBuyExcludeTotal4 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup5 * $scope.priceResults.Quantity4);
		   }
		   if($scope.priceResults.Quantity4 >= $scope.Quantity6  && $scope.Quantity6 != 0 ){ 
			   $scope.qtyBuyExcludeSetup4 = $scope.qtyBuyExcludeSetup6; 
			   $scope.qtyBuyExcludeTotal4 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup6 * $scope.priceResults.Quantity4);
		   }
		   /* Quantity 4 */

		   /* Quantity 5 */
		   if($scope.priceResults.Quantity5 < $scope.Quantity5 && $scope.Quantity5 != 0 ){  
			   $scope.qtyBuyExcludeSetup5 = $scope.roundOff(sumTotal, $scope.price4Temp);
			   $scope.qtyBuyExcludeTotal5 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup5 * $scope.priceResults.Quantity5);	

			   if($scope.priceResults.Quantity5 < $scope.Quantity4  ){
				   //console.log("Mas mababa sa quantity4 "); 
				   $scope.qtyBuyExcludeSetup5 = $scope.roundOff(sumTotal, $scope.price3Temp);
				   $scope.qtyBuyExcludeTotal5 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup5 * $scope.priceResults.Quantity5);
			   }   
			   if($scope.priceResults.Quantity5 < $scope.Quantity3  ){
				   //console.log("Mas mababa sa quantity3 "); 
				   $scope.qtyBuyExcludeSetup5 = $scope.roundOff(sumTotal, $scope.price2Temp);
				   $scope.qtyBuyExcludeTotal5 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup5 * $scope.priceResults.Quantity5);
			   }  
			   if($scope.priceResults.Quantity5 < $scope.Quantity2  ){
				   //console.log("Mas mababa sa quantity2 "); 
				   $scope.qtyBuyExcludeSetup5 = $scope.roundOff(sumTotal, $scope.price1Temp);
				   $scope.qtyBuyExcludeTotal5 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup5 * $scope.priceResults.Quantity5);
			   }  
			   if($scope.priceResults.Quantity5 < $scope.Quantity1){
				   //console.log("Mas mababa sa quantity1 " + $scope.priceResults.Quantity5); 
				   var priceSummaryExlSetupsTemp = $scope.SurchargeValue / $scope.priceResults.Quantity5;
				   var getPrice1Total = $scope.roundOff(sumTotal, $scope.price1Temp);
				   //console.log(getPrice1Total + priceSummaryExlSetupsTemp);
				   $scope.price1TempE = priceSummaryExlSetupsTemp + getPrice1Total;
				   $scope.qtyBuyExcludeSetup5 = $scope.price1TempE;
				   $scope.qtyBuyExcludeTotal5 = $scope.roundOffNumber($scope.price1TempE * $scope.priceResults.Quantity5);
				   //console.log($scope.price1TempE + " = " + $scope.qtyBuyExcludeSetup5);
			   }   
		   }
		   if($scope.priceResults.Quantity5 >= $scope.Quantity6  && $scope.Quantity6 != 0 ){ 
			   $scope.qtyBuyExcludeSetup5 = $scope.qtyBuyExcludeSetup6; 
			   $scope.qtyBuyExcludeTotal5 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup6 * $scope.priceResults.Quantity5);
		   }
		   /* Quantity 5 */

		   /* Quantity 6 */
		   if($scope.priceResults.Quantity6 < $scope.Quantity6 && $scope.Quantity6 != 0 ){  
			   $scope.qtyBuyExcludeSetup6 = $scope.roundOff(sumTotal, $scope.price5Temp);
			   $scope.qtyBuyExcludeTotal6 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup6 * $scope.priceResults.Quantity6);	

			   if($scope.priceResults.Quantity6 < $scope.Quantity5  ){
				   //console.log("Mas mababa sa quantity5 "); 
				   $scope.qtyBuyExcludeSetup6 = $scope.roundOff(sumTotal, $scope.price4Temp);
				   $scope.qtyBuyExcludeTotal6 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup6 * $scope.priceResults.Quantity6);
			   }  
			   if($scope.priceResults.Quantity6 < $scope.Quantity4  ){
				   //console.log("Mas mababa sa quantity4 "); 
				   $scope.qtyBuyExcludeSetup6 = $scope.roundOff(sumTotal, $scope.price3Temp);
				   $scope.qtyBuyExcludeTotal6 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup6 * $scope.priceResults.Quantity6);
			   } 
			   if($scope.priceResults.Quantity6 < $scope.Quantity3  ){
				   //console.log("Mas mababa sa quantity3 "); 
				   $scope.qtyBuyExcludeSetup6 = $scope.roundOff(sumTotal, $scope.price2Temp);
				   $scope.qtyBuyExcludeTotal6 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup6 * $scope.priceResults.Quantity6);
			   }  
			   if($scope.priceResults.Quantity6 < $scope.Quantity2  ){
				   //console.log("Mas mababa sa quantity2 "); 
				   $scope.qtyBuyExcludeSetup6 = $scope.roundOff(sumTotal, $scope.price1Temp);
				   $scope.qtyBuyExcludeTotal6 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup6 * $scope.priceResults.Quantity6);
			   } 
			   if($scope.priceResults.Quantity6 < $scope.Quantity1){
				   //console.log("Mas mababa sa quantity1 " + $scope.priceResults.Quantity6); 
				   var priceSummaryExlSetupsTemp = $scope.SurchargeValue / $scope.priceResults.Quantity6;
				   var getPrice1Total = $scope.roundOff(sumTotal, $scope.price1Temp);
				   //console.log(getPrice1Total + priceSummaryExlSetupsTemp);
				   $scope.price1TempF = priceSummaryExlSetupsTemp + getPrice1Total;
				   $scope.qtyBuyExcludeSetup6 = $scope.price1TempF;
				   $scope.qtyBuyExcludeTotal6 = $scope.roundOffNumber($scope.price1TempF * $scope.priceResults.Quantity6);
				   //console.log($scope.price1TempF + " = " + $scope.qtyBuyExcludeSetup6);
			   }      

		   }	
		   /* Quantity 6 */

   
		    

				
			<?php if ($skinnedUserCheck['skinnedLoggedIn'] == 1 ||  $customArray['themeArray'][0]->showPricing == 1){  ?>  
				
				 var surchargeAdded = parseInt($scope.MOQSurcharge); 
				 
				 
				
				 

				 if(sumTotal == 0 || isNaN(parseFloat(sumTotal))  || !$scope.sumTotalView){ 
					 $scope.qtyBuyExcludeSetup1s =$scope.price1Temp * $scope.priceResults.Quantity1; 
					 //$scope.qtyBuyExcludeSetup1 = $scope.qtyBuyExcludeSetup1s / $scope.priceResults.Quantity1; 
					 $scope.qtyBuyExcludeSetup2s =$scope.price2Temp * $scope.priceResults.Quantity2;
					 //$scope.qtyBuyExcludeSetup2 = $scope.qtyBuyExcludeSetup2s / $scope.priceResults.Quantity2;
					 $scope.qtyBuyExcludeSetup3s =$scope.price3Temp * $scope.priceResults.Quantity3;
					 //$scope.qtyBuyExcludeSetup3 = $scope.qtyBuyExcludeSetup3s / $scope.priceResults.Quantity3;
					 $scope.qtyBuyExcludeSetup4s =$scope.price4Temp * $scope.priceResults.Quantity4;
					 //$scope.qtyBuyExcludeSetup4 = $scope.qtyBuyExcludeSetup4s / $scope.priceResults.Quantity4;
					 $scope.qtyBuyExcludeSetup5s =$scope.price5Temp * $scope.priceResults.Quantity5;
					 //$scope.qtyBuyExcludeSetup5 = $scope.qtyBuyExcludeSetup5s / $scope.priceResults.Quantity5;
					 $scope.qtyBuyExcludeSetup6s =$scope.price6Temp * $scope.priceResults.Quantity6;
					 //$scope.qtyBuyExcludeSetup6 = $scope.qtyBuyExcludeSetup6s / $scope.priceResults.Quantity6;
 
				 }  
				 //Add the surcharge here 
				// $scope.surchargeAddedForSkinnedSite();
			<?php } ?>
		   

		   $scope.freightCosts($scope.cartonQuantity, $scope.cartonWeight, $scope.cartonVolume, $scope.priceResults.Quantity1, $scope.priceResults.Quantity2, $scope.priceResults.Quantity3, $scope.priceResults.Quantity4, $scope.priceResults.Quantity5, $scope.priceResults.Quantity6);
		   
		   //Get prices
		    
		   for(var mrk = 1; mrk <= 6; mrk++){  
			   $scope.getPrice(mrk, $scope['qtyBuyExcludeSetup' + mrk], $scope['markup' + mrk])
		   }
		   //$scope.getPrice(mOption, priceSummary, markupPercentage);

		   $scope.calculateTotal();
		   
   }
/* No setup included  */

    


/* Setup included  */	
   /* Total computation  */ 
   $scope.computeIncSetupAdditionalCostsTotal = function(totalCosts){ 

	 	
	   var sumTotalUnit = 0;
	   var sumTotalSetup = 0;
	   var sumTotalSetupUnit =0;
	   var sumTotalSetupDivide = 0;
	   var addFreightCost1 = 0;
	   var addFreightCost2 = 0;
	   var addFreightCost3 = 0;
	   var addFreightCost4 = 0;
	   var addFreightCost5 = 0;
	   var addFreightCost6 = 0;
 


	   for (var i = 0; i < totalCosts.length; i++) {  
		   sumTotalUnit += totalCosts[i][1];

		   /* FOR THE SKINNED SITE */
		   <?php if ($skinnedUserCheck['skinnedLoggedIn'] == 1 ||  $customArray['themeArray'][0]->showPricing == 1){  ?>

			   if(isNaN(totalCosts[i][2])){
				   totalCosts[i][2] = 0;
				   //console.log("PUMASOK SA NAN"); 
			   }
			   sumTotalSetup += totalCosts[i][2];

		   <?php }else{  ?> 
		   /* FOR THE SKINNED SITE */
			   //console.log(" totalCosts[i][2] => " + totalCosts[i][2]);
			   sumTotalSetup += totalCosts[i][2];

		   <?php } ?>
			
	   } 


	   

	   //FREIGHT STARTS HERE	
		if($scope.IncludeFreightUnitPriceNew == true){ 
			
			//console.log("HERE FREIGHTS WITH SETUP => ");
			//console.log($scope.FinalFreightCosts[$scope.globalFreightSelected]);

			$scope.selectedFreight = $scope.FinalFreightCosts[$scope.globalFreightSelected];

			if($scope.FinalFreightCosts[$scope.globalFreightSelected].FreightCost1 != "FREE" || $scope.FinalFreightCosts[$scope.globalFreightSelected].FreightCost2 != "FREE"){
						//console.log("FREIGHT CALCULATION HERE WITH SETUP "); 

					 	if($scope.priceResults.Quantity1){
							addFreightCost1 = $scope.FinalFreightCosts[$scope.globalFreightSelected].FreightCost1 /  $scope.priceResults.Quantity1;     
						} 
						if($scope.priceResults.Quantity2){
							addFreightCost2 = $scope.FinalFreightCosts[$scope.globalFreightSelected].FreightCost2 /  $scope.priceResults.Quantity2;     
						} 
						if($scope.priceResults.Quantity3){
							addFreightCost3 = $scope.FinalFreightCosts[$scope.globalFreightSelected].FreightCost3 /  $scope.priceResults.Quantity3;     
						} 
						if($scope.priceResults.Quantity4){
							addFreightCost4 = $scope.FinalFreightCosts[$scope.globalFreightSelected].FreightCost4 /  $scope.priceResults.Quantity4;     
						} 
						if($scope.priceResults.Quantity5){
							addFreightCost5 = $scope.FinalFreightCosts[$scope.globalFreightSelected].FreightCost5 /  $scope.priceResults.Quantity5;     
						} 
						if($scope.priceResults.Quantity6){
							addFreightCost6 = $scope.FinalFreightCosts[$scope.globalFreightSelected].FreightCost6 /  $scope.priceResults.Quantity6;     
						} 

			}


		}
  
	   		 
		 	 //console.log("sumTotalUnit = " + sumTotalUnit + " --/-- sumTotalSetup = " + sumTotalSetup + " / $scope.priceResults.Quantity1 = " +$scope.priceResults.Quantity1);  

		sumTotalSetupUnit1 = 0;
		sumTotalSetupUnit2 = 0;
		sumTotalSetupUnit3 = 0;
		sumTotalSetupUnit4 = 0;
		sumTotalSetupUnit5 = 0;
		sumTotalSetupUnit6 = 0;
	   
	   if($scope.priceResults.Quantity1){
		   sumTotalSetupDivide1 = sumTotalSetup / $scope.priceResults.Quantity1; 
		   sumTotalSetupUnit1 = sumTotalUnit + sumTotalSetupDivide1;  
	   }
	   if($scope.priceResults.Quantity2){
		   sumTotalSetupDivide2 = sumTotalSetup / $scope.priceResults.Quantity2; 
		   sumTotalSetupUnit2 = sumTotalUnit + sumTotalSetupDivide2; 
	   }
	   if($scope.priceResults.Quantity3){
		   sumTotalSetupDivide3 = sumTotalSetup / $scope.priceResults.Quantity3; 
		   sumTotalSetupUnit3 = sumTotalUnit + sumTotalSetupDivide3; 
	   }
	   if($scope.priceResults.Quantity4){
		   sumTotalSetupDivide4 = sumTotalSetup / $scope.priceResults.Quantity4; 
		   sumTotalSetupUnit4 = sumTotalUnit + sumTotalSetupDivide4; 
	   }
	   if($scope.priceResults.Quantity5){
		   sumTotalSetupDivide5 = sumTotalSetup / $scope.priceResults.Quantity5; 
		   sumTotalSetupUnit5 = sumTotalUnit + sumTotalSetupDivide5; 
	   }
	   if($scope.priceResults.Quantity6){
		   sumTotalSetupDivide6 = sumTotalSetup / $scope.priceResults.Quantity6; 
		   sumTotalSetupUnit6 = sumTotalUnit + sumTotalSetupDivide6; 
	   } 

	   /* If qty is lower than the original quantity */
	   if($scope.priceResults.Quantity1 < $scope.Quantity1){
			   //console.log("ooops setup included... lower qty1");
	   }

	   $scope.qtyBuyExcludeSetup1 = Number($scope.Price1) + Number(sumTotalSetupUnit1) +  Number(addFreightCost1);
	   $scope.qtyBuyExcludeSetup2 = Number($scope.Price2) + Number(sumTotalSetupUnit2) +  Number(addFreightCost2);
	   $scope.qtyBuyExcludeSetup3 = Number($scope.Price3) + Number(sumTotalSetupUnit3) +  Number(addFreightCost3);
	   $scope.qtyBuyExcludeSetup4 = Number($scope.Price4) + Number(sumTotalSetupUnit4) +  Number(addFreightCost4);
	   $scope.qtyBuyExcludeSetup5 = Number($scope.Price5) + Number(sumTotalSetupUnit5) +  Number(addFreightCost5);
	   $scope.qtyBuyExcludeSetup6 = Number($scope.Price6) + Number(sumTotalSetupUnit6) +  Number(addFreightCost6); 	  
		
	   
	   /* PRICE SUMMARY Buy Exculding Total */
	   $scope.qtyBuyExcludeTotal1 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup1 * $scope.priceResults.Quantity1);
	   $scope.qtyBuyExcludeTotal2 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup2 * $scope.priceResults.Quantity2);
	   $scope.qtyBuyExcludeTotal3 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup3 * $scope.priceResults.Quantity3);
	   $scope.qtyBuyExcludeTotal4 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup4 * $scope.priceResults.Quantity4);
	   $scope.qtyBuyExcludeTotal5 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup5 * $scope.priceResults.Quantity5);
	   $scope.qtyBuyExcludeTotal6 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup6 * $scope.priceResults.Quantity6);
	   /* PRICE SUMMARY Buy Exculding Total */
	   
	   $timeout(function() { 
			   $scope.qtyBuyExcludeSetupAlls = 1;
	   }, 1500);

	   

	   /* Quantity 1 with setup */
	   /* If qty1 is lower than the original quantity */
	   if($scope.priceResults.Quantity1 < $scope.Quantity1){  
		   
		  
		   var priceSummaryIncSetupsTemp = $scope.SurchargeValue / $scope.priceResults.Quantity1;
		   //console.log(priceSummaryIncSetupsTemp);
		   $scope.price1TempA = priceSummaryIncSetupsTemp + $scope.qtyBuyExcludeSetup1;
		   $scope.qtyBuyExcludeSetup1 = $scope.price1TempA;
		   $scope.qtyBuyExcludeTotal1 = $scope.roundOffNumber($scope.price1TempA * $scope.priceResults.Quantity1);
	   }  
	   if($scope.priceResults.Quantity1 >= $scope.Quantity2 && $scope.Quantity2 != 0){
		   $scope.qtyBuyExcludeSetup1 = Number($scope.Price2) + Number(sumTotalSetupUnit1);
		   $scope.qtyBuyExcludeTotal1 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup1 * $scope.priceResults.Quantity1);
	   }  
	   if($scope.priceResults.Quantity1 >= $scope.Quantity3 && $scope.Quantity3 != 0){
		   $scope.qtyBuyExcludeSetup1 = Number($scope.Price3) + Number(sumTotalSetupUnit1);
		   $scope.qtyBuyExcludeTotal1 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup1 * $scope.priceResults.Quantity1);
	   } 
	   if($scope.priceResults.Quantity1 >= $scope.Quantity4 && $scope.Quantity4 != 0){
		   $scope.qtyBuyExcludeSetup1 = Number($scope.Price4) + Number(sumTotalSetupUnit1);
		   $scope.qtyBuyExcludeTotal1 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup1 * $scope.priceResults.Quantity1);
	   } 
	   if($scope.priceResults.Quantity1 >= $scope.Quantity5 && $scope.Quantity5 != 0){
		   $scope.qtyBuyExcludeSetup1 = Number($scope.Price5) + Number(sumTotalSetupUnit1);
		   $scope.qtyBuyExcludeTotal1 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup1 * $scope.priceResults.Quantity1);
	   } 
	   if($scope.priceResults.Quantity1 >= $scope.Quantity6 && $scope.Quantity6 != 0){
		   $scope.qtyBuyExcludeSetup1 = Number($scope.Price6) + Number(sumTotalSetupUnit1);
		   $scope.qtyBuyExcludeTotal1 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup1 * $scope.priceResults.Quantity1);
	   } 
	   /* Quantity 1 with setup */

	   /* Quantity 2 with setup */
	   /* If qty2 is lower than the original quantity */
	   if($scope.priceResults.Quantity2 < $scope.Quantity2 && $scope.Quantity2 != 0 ){  
		   if($scope.priceResults.Quantity2 < $scope.Quantity1){ 
			   var priceSummaryIncSetupsTemp = $scope.SurchargeValue / $scope.priceResults.Quantity2;
			   var getPrice1Total = Number($scope.Price1) + Number(sumTotalSetupUnit2); 
			   $scope.price1TempB = priceSummaryIncSetupsTemp + getPrice1Total;
			   $scope.qtyBuyExcludeSetup2 = $scope.price1TempB;
			   $scope.qtyBuyExcludeTotal2 = $scope.roundOffNumber($scope.price1TempB * $scope.priceResults.Quantity2);

		   }else{ 
			   $scope.qtyBuyExcludeSetup2 = Number($scope.Price1) + Number(sumTotalSetupUnit2);
			   $scope.qtyBuyExcludeTotal2 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup2 * $scope.priceResults.Quantity2);
		   }  
	   }  
	   if($scope.priceResults.Quantity2 >= $scope.Quantity3 && $scope.Quantity3 != 0){
		   $scope.qtyBuyExcludeSetup2 = Number($scope.Price3) + Number(sumTotalSetupUnit2);
		   $scope.qtyBuyExcludeTotal2 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup2 * $scope.priceResults.Quantity2);
	   }  
	   if($scope.priceResults.Quantity2 >= $scope.Quantity4 && $scope.Quantity4 != 0){
		   $scope.qtyBuyExcludeSetup2 = Number($scope.Price4) + Number(sumTotalSetupUnit2);
		   $scope.qtyBuyExcludeTotal2 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup2 * $scope.priceResults.Quantity2);
	   }  
	   if($scope.priceResults.Quantity2 >= $scope.Quantity5 && $scope.Quantity5 != 0){
		   $scope.qtyBuyExcludeSetup2 = Number($scope.Price5) + Number(sumTotalSetupUnit2);
		   $scope.qtyBuyExcludeTotal2 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup2 * $scope.priceResults.Quantity2);
	   }  
	   if($scope.priceResults.Quantity2 >= $scope.Quantity6 && $scope.Quantity6 != 0){
		   $scope.qtyBuyExcludeSetup2 = Number($scope.Price6) + Number(sumTotalSetupUnit2);
		   $scope.qtyBuyExcludeTotal2 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup2 * $scope.priceResults.Quantity2);
	   }  
	   /* Quantity 2 with setup */

	   /* Quantity 3 with setup */
	   if($scope.priceResults.Quantity3 < $scope.Quantity3 && $scope.Quantity3 != 0 ){  

		   $scope.qtyBuyExcludeSetup3 = Number($scope.Price2) + Number(sumTotalSetupUnit3);
		   $scope.qtyBuyExcludeTotal3 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup3 * $scope.priceResults.Quantity3);
		   
		   if($scope.priceResults.Quantity3 < $scope.Quantity2  ){ 
			   $scope.qtyBuyExcludeSetup3 = Number($scope.Price1) + Number(sumTotalSetupUnit3);
			   $scope.qtyBuyExcludeTotal3 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup3 * $scope.priceResults.Quantity3);
		   }  

		   if($scope.priceResults.Quantity3 < $scope.Quantity1){
			   //console.log("Mas mababa sa quantity1 " + $scope.priceResults.Quantity3);   
			   var priceSummaryIncSetupsTemp = $scope.SurchargeValue / $scope.priceResults.Quantity3;
			   var getPrice1Total = Number($scope.Price1) + Number(sumTotalSetupUnit3); 
			   $scope.price1TempC = priceSummaryIncSetupsTemp + getPrice1Total;
			   $scope.qtyBuyExcludeSetup3 = $scope.price1TempC;
			   $scope.qtyBuyExcludeTotal3 = $scope.roundOffNumber($scope.price1TempC * $scope.priceResults.Quantity3);
		   }    

	   }  
	   if($scope.priceResults.Quantity3 >= $scope.Quantity4 && $scope.Quantity4 != 0){
		   $scope.qtyBuyExcludeSetup3 = Number($scope.Price4) + Number(sumTotalSetupUnit3);
		   $scope.qtyBuyExcludeTotal3 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup3 * $scope.priceResults.Quantity3);
	   }  
	   if($scope.priceResults.Quantity3 >= $scope.Quantity5 && $scope.Quantity5 != 0){
		   $scope.qtyBuyExcludeSetup3 = Number($scope.Price5) + Number(sumTotalSetupUnit3);
		   $scope.qtyBuyExcludeTotal3 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup3 * $scope.priceResults.Quantity3);
	   }  
	   if($scope.priceResults.Quantity3 >= $scope.Quantity6 && $scope.Quantity6 != 0){
		   $scope.qtyBuyExcludeSetup3 = Number($scope.Price6) + Number(sumTotalSetupUnit3);
		   $scope.qtyBuyExcludeTotal3 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup3 * $scope.priceResults.Quantity3);
	   } 
	   /* Quantity 3 with setup */

	   /* Quantity 4 with setup */
	   if($scope.priceResults.Quantity4 < $scope.Quantity4 && $scope.Quantity4 != 0 ){ 

		   $scope.qtyBuyExcludeSetup4 = Number($scope.Price3) + Number(sumTotalSetupUnit4);
		   $scope.qtyBuyExcludeTotal4 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup4 * $scope.priceResults.Quantity4);

		   if($scope.priceResults.Quantity4 < $scope.Quantity3  ){ 
			   $scope.qtyBuyExcludeSetup4 = Number($scope.Price2) + Number(sumTotalSetupUnit4);
			   $scope.qtyBuyExcludeTotal4 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup4 * $scope.priceResults.Quantity4);
		   }  
		   if($scope.priceResults.Quantity4 < $scope.Quantity2  ){ 
			   $scope.qtyBuyExcludeSetup4 = Number($scope.Price1) + Number(sumTotalSetupUnit4);
			   $scope.qtyBuyExcludeTotal4 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup4 * $scope.priceResults.Quantity4);
		   }  
		   
		   if($scope.priceResults.Quantity4 < $scope.Quantity1){   
			   var priceSummaryIncSetupsTemp = $scope.SurchargeValue / $scope.priceResults.Quantity4;
			   var getPrice1Total = Number($scope.Price1) + Number(sumTotalSetupUnit4); 
			   $scope.price1TempD = priceSummaryIncSetupsTemp + getPrice1Total;
			   $scope.qtyBuyExcludeSetup4 = $scope.price1TempD;
			   $scope.qtyBuyExcludeTotal4 = $scope.roundOffNumber($scope.price1TempD * $scope.priceResults.Quantity4);
		   }    

	   } 
	   if($scope.priceResults.Quantity4 >= $scope.Quantity5 && $scope.Quantity5 != 0){
		   $scope.qtyBuyExcludeSetup4 = Number($scope.Price5) + Number(sumTotalSetupUnit4);
		   $scope.qtyBuyExcludeTotal4 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup4 * $scope.priceResults.Quantity4);
	   }  
	   if($scope.priceResults.Quantity4 >= $scope.Quantity6 && $scope.Quantity6 != 0){
		   $scope.qtyBuyExcludeSetup4 = Number($scope.Price6) + Number(sumTotalSetupUnit4);
		   $scope.qtyBuyExcludeTotal4 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup4 * $scope.priceResults.Quantity4);
	   }  
	   /* Quantity 4 with setup */

	   /* Quantity 5 with setup */
	   if($scope.priceResults.Quantity5 < $scope.Quantity5 && $scope.Quantity5 != 0 ){ 

		   $scope.qtyBuyExcludeSetup5 = Number($scope.Price4) + Number(sumTotalSetupUnit5);
		   $scope.qtyBuyExcludeTotal5 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup5 * $scope.priceResults.Quantity5);

		   if($scope.priceResults.Quantity5 < $scope.Quantity4  ){ 
			   $scope.qtyBuyExcludeSetup5 = Number($scope.Price3) + Number(sumTotalSetupUnit5);
			   $scope.qtyBuyExcludeTotal5 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup5 * $scope.priceResults.Quantity5);
		   }  
		   if($scope.priceResults.Quantity5 < $scope.Quantity3  ){ 
			   $scope.qtyBuyExcludeSetup5 = Number($scope.Price2) + Number(sumTotalSetupUnit5);
			   $scope.qtyBuyExcludeTotal5 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup5 * $scope.priceResults.Quantity5);
		   } 
		   if($scope.priceResults.Quantity5 < $scope.Quantity2  ){ 
			   $scope.qtyBuyExcludeSetup5 = Number($scope.Price1) + Number(sumTotalSetupUnit5);
			   $scope.qtyBuyExcludeTotal5 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup5 * $scope.priceResults.Quantity5);
		   }  
		   if($scope.priceResults.Quantity5 < $scope.Quantity1){   
			   var priceSummaryIncSetupsTemp = $scope.SurchargeValue / $scope.priceResults.Quantity5;
			   var getPrice1Total = Number($scope.Price1) + Number(sumTotalSetupUnit5); 
			   $scope.price1TempE = priceSummaryIncSetupsTemp + getPrice1Total;
			   $scope.qtyBuyExcludeSetup5 = $scope.price1TempE;
			   $scope.qtyBuyExcludeTotal5 = $scope.roundOffNumber($scope.price1TempE * $scope.priceResults.Quantity5);
		   }    
		   
	   } 
	   if($scope.priceResults.Quantity5 >= $scope.Quantity6 && $scope.Quantity6 != 0){
		   $scope.qtyBuyExcludeSetup5 = Number($scope.Price6) + Number(sumTotalSetupUnit5);
		   $scope.qtyBuyExcludeTotal5 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup5 * $scope.priceResults.Quantity5);
	   } 
	   /* Quantity 5 with setup */

	   /* Quantity 6 with setup */
	   if($scope.priceResults.Quantity6 < $scope.Quantity6 && $scope.Quantity6 != 0 ){ 
		   $scope.qtyBuyExcludeSetup6 = Number($scope.Price5) + Number(sumTotalSetupUnit6);
		   $scope.qtyBuyExcludeTotal6 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup6 * $scope.priceResults.Quantity6);
		   
		   if($scope.priceResults.Quantity6 < $scope.Quantity5  ){ 
			   $scope.qtyBuyExcludeSetup6 = Number($scope.Price4) + Number(sumTotalSetupUnit6);
			   $scope.qtyBuyExcludeTotal6 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup6 * $scope.priceResults.Quantity6);
		   }  
		   if($scope.priceResults.Quantity6 < $scope.Quantity4  ){ 
			   $scope.qtyBuyExcludeSetup6 = Number($scope.Price3) + Number(sumTotalSetupUnit6);
			   $scope.qtyBuyExcludeTotal6 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup6 * $scope.priceResults.Quantity6);
		   }  
		   if($scope.priceResults.Quantity6 < $scope.Quantity3  ){ 
			   $scope.qtyBuyExcludeSetup6 = Number($scope.Price2) + Number(sumTotalSetupUnit6);
			   $scope.qtyBuyExcludeTotal6 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup6 * $scope.priceResults.Quantity6);
		   } 
		   if($scope.priceResults.Quantity6 < $scope.Quantity2  ){ 
			   $scope.qtyBuyExcludeSetup6 = Number($scope.Price1) + Number(sumTotalSetupUnit6);
			   $scope.qtyBuyExcludeTotal6 = $scope.roundOffNumber($scope.qtyBuyExcludeSetup6 * $scope.priceResults.Quantity6);
		   }  
		   if($scope.priceResults.Quantity6 < $scope.Quantity1){   
			   var priceSummaryIncSetupsTemp = $scope.SurchargeValue / $scope.priceResults.Quantity6;
			   var getPrice1Total = Number($scope.Price1) + Number(sumTotalSetupUnit6); 
			   $scope.price1TempF = priceSummaryIncSetupsTemp + getPrice1Total;
			   $scope.qtyBuyExcludeSetup6 = $scope.price1TempF;
			   $scope.qtyBuyExcludeTotal6 = $scope.roundOffNumber($scope.price1TempF * $scope.priceResults.Quantity6);
		   }  
		   
	   }	
	   /* Quantity 6 with setup */


	    <?php if ($skinnedUserCheck['skinnedLoggedIn'] == 1 ||  $customArray['themeArray'][0]->showPricing == 1){  ?>  
				if(isNaN(parseFloat(sumTotalSetup))){  
					$scope.qtyBuyExcludeSetup1s =$scope.price1Temp * $scope.priceResults.Quantity1;
					//$scope.qtyBuyExcludeSetup1 = $scope.qtyBuyExcludeSetup1s /  $scope.priceResults.Quantity1; 
					$scope.qtyBuyExcludeSetup2s =$scope.price2Temp * $scope.priceResults.Quantity2;
					//$scope.qtyBuyExcludeSetup2 = $scope.qtyBuyExcludeSetup2s /  $scope.priceResults.Quantity2;
					$scope.qtyBuyExcludeSetup3s =$scope.price3Temp * $scope.priceResults.Quantity3;
					//$scope.qtyBuyExcludeSetup3 = $scope.qtyBuyExcludeSetup3s /  $scope.priceResults.Quantity3;
					$scope.qtyBuyExcludeSetup4s =$scope.price4Temp * $scope.priceResults.Quantity4;
					//$scope.qtyBuyExcludeSetup4 = $scope.qtyBuyExcludeSetup4s /  $scope.priceResults.Quantity4;
					$scope.qtyBuyExcludeSetup5s =$scope.price5Temp * $scope.priceResults.Quantity5;
					//$scope.qtyBuyExcludeSetup5 = $scope.qtyBuyExcludeSetup5s /  $scope.priceResults.Quantity5;
					$scope.qtyBuyExcludeSetup6s =$scope.price6Temp * $scope.priceResults.Quantity6; 
					//$scope.qtyBuyExcludeSetup6 = $scope.qtyBuyExcludeSetup6s /  $scope.priceResults.Quantity6; 
				}  
				 //Add the surcharge here 
				//$scope.surchargeAddedForSkinnedSite();
   		<?php } ?>
	   
	   
	   $scope.freightCosts($scope.cartonQuantity,  $scope.cartonWeight, $scope.cartonVolume, $scope.priceResults.Quantity1, $scope.priceResults.Quantity2, $scope.priceResults.Quantity3, $scope.priceResults.Quantity4, $scope.priceResults.Quantity5, $scope.priceResults.Quantity6);
	   
	   /***** NEW UPGRADE PRICING **********************/
	   //$scope.arrayOfBuySetups = [$scope.qtyBuyExcludeSetup1, $scope.qtyBuyExcludeTotal1];
	   //console.log("$scope.arrayOfBuySetups => ");
	   //console.log($scope.arrayOfBuySetups);
	   /***** NEW UPGRADE PRICING **********************/

	   
	   //Get prices
	   for(var mrk = 1; mrk <= 6; mrk++){ 
			   $scope.getPrice(mrk, $scope['qtyBuyExcludeSetup' + mrk], $scope['markup' + mrk])
	   }

	   $scope.calculateTotal();
   }
/* Setup included  */



	$scope.surchargeAddedForSkinnedSite = function(){

		/* If qty1 is lower than the original quantity */
		if($scope.priceResults.Quantity1 < $scope.Quantity1){  
			//console.log("11111 " + " / " + $scope.qtyBuyExcludeSetup1 + " / " + $scope.SurchargeValue );
			//console.log($scope.priceResults.Quantity1);
			//if($scope.priceResults.Quantity1 > $scope.SurchargeValue){
				$scope.qtyBuyExcludeSetup1 = $scope.qtyBuyExcludeSetup1 + $scope.SurchargeValue;
			//} 	 
		}  
		/* If qty2 is lower than the original quantity */
		if($scope.priceResults.Quantity2 < $scope.Quantity2 && $scope.Quantity2 != 0 ){  
			if($scope.priceResults.Quantity2 < $scope.Quantity1){ 
				$scope.qtyBuyExcludeSetup2 = $scope.qtyBuyExcludeSetup2 + $scope.SurchargeValue;
			} 
		}   
		if($scope.priceResults.Quantity3 < $scope.Quantity3 && $scope.Quantity3 != 0 ){   
			if($scope.priceResults.Quantity3 < $scope.Quantity1){ 
				$scope.qtyBuyExcludeSetup3 = $scope.qtyBuyExcludeSetup3 + $scope.SurchargeValue;
			}    
		}   
		if($scope.priceResults.Quantity4 < $scope.Quantity4 && $scope.Quantity4 != 0 ){   
			if($scope.priceResults.Quantity4 < $scope.Quantity1){ 
				$scope.qtyBuyExcludeSetup4 = $scope.qtyBuyExcludeSetup4 + $scope.SurchargeValue;
			}    
		}    
		if($scope.priceResults.Quantity5 < $scope.Quantity5 && $scope.Quantity5 != 0 ){   
			if($scope.priceResults.Quantity5 < $scope.Quantity1){  
				$scope.qtyBuyExcludeSetup5 = $scope.qtyBuyExcludeSetup5 + $scope.SurchargeValue;
			}   
		} 
		if($scope.priceResults.Quantity6 < $scope.Quantity6 && $scope.Quantity6 != 0 ){   
			if($scope.priceResults.Quantity6 < $scope.Quantity1){  
				$scope.qtyBuyExcludeSetup6 = $scope.qtyBuyExcludeSetup6 + $scope.SurchargeValue;
			}    
		}	
		/* Quantity 6 */

	}


/* No additional cost computation */
$scope.noAdditionalCost = function(value, heading){
   var value = value || null;
   var heading = heading || null;
   
   if($scope.additionalCostCount < 0){
	   
	   $scope.hideMOQFalse();
	   
	   $scope.headingQuantitys1 = $scope.headingQuantity1;
	   $scope.headingQuantitys2 = $scope.headingQuantity2;
	   $scope.headingQuantitys3 = $scope.headingQuantity3;
	   $scope.headingQuantitys4 = $scope.headingQuantity4;
	   $scope.headingQuantitys5 = $scope.headingQuantity5;
	   $scope.headingQuantitys6 = $scope.headingQuantity6;

	   if(heading == 1){
		   $scope.headingQuantitys1 = value;
	   }
	   if(heading == 2){
		   $scope.headingQuantitys2 = value;
	   }
	   if(heading == 3){
		   $scope.headingQuantitys3 = value;
	   }
	   if(heading == 4){
		   $scope.headingQuantitys4 = value;
	   }
	   if(heading == 5){
		   $scope.headingQuantitys5 = value;
	   }
	   if(heading == 6){
		   $scope.headingQuantitys6 = value;
	   } 

	   $scope.hideFreight1 = true;
	   $scope.hideFreight2 = true;
	   $scope.hideFreight3 = true;
	   $scope.hideFreight4 = true;
	   $scope.hideFreight5 = true;
	   $scope.hideFreight6 = true;
	   $scope.hideMOQFunction($scope.LessThanMOQ);
	   //console.log("dito 3 " + value + " / " + $scope.headingQuantity1);
	   //console.log("Test " + $scope.cartonQuantity + " / " + $scope.cartonWeight + " / " + $scope.cartonVolume + " / " + $scope.headingQuantity1 + " / " +$scope.headingQuantity2 + " / " +$scope.headingQuantity3 + " / " +$scope.headingQuantity4 + " / " +$scope.headingQuantity5 + " / " +$scope.headingQuantity6)
	   $scope.freightCosts($scope.cartonQuantity,  $scope.cartonWeight, $scope.cartonVolume, $scope.headingQuantitys1, $scope.headingQuantitys2, $scope.headingQuantitys3, $scope.headingQuantitys4, $scope.headingQuantitys5, $scope.headingQuantitys6);
   }
   
}

$scope.hideMOQFalse = function(){
	   $scope.noteLessThanMOQ = false;
	   $scope.hideMOQ1 = false;
	   $scope.hideMOQ2 = false;
	   $scope.hideMOQ3 = false;
	   $scope.hideMOQ4 = false;
	   $scope.hideMOQ5 = false;
	   $scope.hideMOQ6 = false;
}

$scope.touchByUser = function(){
	$scope.noteLessThanMOQDefault = true;
}
   
$scope.hideMOQFunction = function(LessThanMOQ){ 
	//console.log("$scope.MOQSurcharge NEW   =>  "  +  $scope.priceResults.Quantity1 + " / " + $scope.Quantity1);

	 $scope.noteLessThanMOQ = false;	

					   var elementLow1 = angular.element('.bgquantity1'); 
					   elementLow1.css('background-color', '#fff'); 
					   var elementLow2 = angular.element('.bgquantity2'); 
					   elementLow2.css('background-color', '#fff'); 
					   var elementLow3 = angular.element('.bgquantity3'); 
					   elementLow3.css('background-color', '#fff'); 
					   var elementLow4 = angular.element('.bgquantity4'); 
					   elementLow4.css('background-color', '#fff'); 
					   var elementLow5 = angular.element('.bgquantity5'); 
					   elementLow5.css('background-color', '#fff'); 
					   var elementLow6 = angular.element('.bgquantity6'); 
					   elementLow6.css('background-color', '#fff'); 

	   if(LessThanMOQ == 'N'){
			var msg = "Note: You have entered a quantity below MOQ.";

		   if($scope.priceResults.Quantity1 < $scope.Quantity1 && $scope.Quantity1 != 0){ 
			   elementLow1.css('background-color', '#f8775d'); 
			   $scope.hideMOQ1 = false;
			   $scope.hideFreight1 = false;
			   $scope.noteLessThanMOQ = true;
			   $scope.noteLessThanMOQ =  msg;
		   }
		   if($scope.priceResults.Quantity2 < $scope.Quantity1 && $scope.Quantity2 != 0){ 
			   elementLow2.css('background-color', '#f8775d'); 
			   $scope.hideMOQ2 = false;
			   $scope.hideFreight2 = false;
			   $scope.noteLessThanMOQ = true;
			   $scope.noteLessThanMOQ =  msg;
		   }
		   if($scope.priceResults.Quantity3 < $scope.Quantity1 && $scope.Quantity3 != 0){ 
			   elementLow3.css('background-color', '#f8775d'); 
			   $scope.hideMOQ3 = false;
			   $scope.hideFreight3 = false;
			   $scope.noteLessThanMOQ = true;
			   $scope.noteLessThanMOQ =  msg;
		   }
		   if($scope.priceResults.Quantity4 < $scope.Quantity1 && $scope.Quantity4 != 0){ 
			   elementLow4.css('background-color', '#f8775d'); 
			   $scope.hideMOQ4 = false;
			   $scope.hideFreight4 = false;
			   $scope.noteLessThanMOQ = true;
			   $scope.noteLessThanMOQ =  msg;
		   }
		   if($scope.priceResults.Quantity5 < $scope.Quantity1 && $scope.Quantity5 != 0){ 
			   elementLow5.css('background-color', '#f8775d'); 
			   $scope.hideMOQ5 = false;
			   $scope.hideFreight5 = false;
			   $scope.noteLessThanMOQ = true;
			   $scope.noteLessThanMOQ =  msg;
		   }
		   if($scope.priceResults.Quantity6 < $scope.Quantity1 && $scope.Quantity6 != 0){ 
			   elementLow6.css('background-color', '#f8775d'); 
			   $scope.hideMOQ6 = false;
			   $scope.hideFreight6 = false;
			   $scope.noteLessThanMOQ = true;
			   $scope.noteLessThanMOQ =  msg;
		   }
	   }
	   if(LessThanMOQ == 'Y'){

		 /* ONLY FOR THE SKINNED SITE */
		<?php if ($skinnedUserCheck['skinnedLoggedIn'] == 1 ||  $customArray['themeArray'][0]->showPricing == 1){  ?> 
			
			//Replace the value with the MOQSurcharge from custom site MOQSurcharge column
			//console.log($scope.Quantity1 + " / " + $scope.priceResults.Quantity1);
			//$scope.Quantity1 = parseInt($scope.MOQSurcharge); 

			//console.log("$scope.MOQSurcharge NEW   =>  "  +  $scope.priceResults.Quantity1 + " / " + $scope.Quantity1);
		<?php } ?> 
		   //console.log(" MOQ " + LessThanMOQ);
		   var msg = "Note: You have entered a quantity less than the MOQ. The MOQ surcharge has been applied.";
		   if($scope.priceResults.Quantity1 < $scope.Quantity1){  
				//console.log(" PART1 = "  + $scope.priceResults.Quantity1 + " < " + $scope.Quantity1);
			   elementLow1.css('background-color', '#f3ee72'); 
			   $scope.hideMOQ1 = true;
			   if($scope.priceResults.Quantity1 != 0 &&  $scope.Quantity1 != 0 ){
					$scope.noteLessThanMOQ = true;
					$scope.noteLessThanMOQ =  msg;
			   }
			  
		   }
		   if($scope.priceResults.Quantity2 < $scope.Quantity1){ 
			   elementLow2.css('background-color', '#f3ee72'); 
			   $scope.hideMOQ2 = true;
			   if($scope.priceResults.Quantity2 != 0 &&  $scope.Quantity1 != 0 ){
					$scope.noteLessThanMOQ = true;
					$scope.noteLessThanMOQ =  msg;
			   }
		   }
		   if($scope.priceResults.Quantity3 < $scope.Quantity1){ 
			   elementLow3.css('background-color', '#f3ee72'); 
			   $scope.hideMOQ3 = true;
			   if($scope.priceResults.Quantity3 != 0 &&  $scope.Quantity1 != 0 ){
					$scope.noteLessThanMOQ = true;
					$scope.noteLessThanMOQ =  msg;
			   }
		   }
		   if($scope.priceResults.Quantity4 < $scope.Quantity1){ 
			   elementLow4.css('background-color', '#f3ee72'); 
			   $scope.hideMOQ4 = true;
			   if($scope.priceResults.Quantity4 != 0 &&  $scope.Quantity1 != 0 ){
					$scope.noteLessThanMOQ = true;
					$scope.noteLessThanMOQ =  msg;
			   }
		   }
		   if($scope.priceResults.Quantity5 < $scope.Quantity1){ 
			   elementLow5.css('background-color', '#f3ee72'); 
			   $scope.hideMOQ5 = true;
			   if($scope.priceResults.Quantity5 != 0 &&  $scope.Quantity1 != 0 ){
					$scope.noteLessThanMOQ = true;
					$scope.noteLessThanMOQ =  msg;
			   }
		   }
		   if($scope.priceResults.Quantity6 < $scope.Quantity1){ 
			   elementLow6.css('background-color', '#f3ee72'); 
			   $scope.hideMOQ6 = true;
			   if($scope.priceResults.Quantity6 != 0 &&  $scope.Quantity1 != 0 ){
					$scope.noteLessThanMOQ = true;
					$scope.noteLessThanMOQ =  msg;
			   }
		   }
	   }
	   
		
} 

   /* Freight Cost */ 
   $scope.freightCosts = function (cartonQuantity, cartonWeight, cartonVolume, quantity1, quantity2, quantity3, quantity4, quantity5, quantity6){
	   
		//console.log("Get the code and freightCosts " + $scope.FGCode + " / this is the ID = " + $scope.productID);
		//console.log($scope.reqfreightDefaultOutputFin);
		//console.log($scope.FGCurrency );

   
	   var arrFC = [];
	   $scope.reqfreightDefaultOutputFin.forEach(function(item){ 
		//console.log(item);
		   if($scope.FGCurrency == 'NZD'){
			   
			   if( item.NZD == 1){ 
				   arrFC.push({
					   reqfreightName: item.Name,
					   reqfreightCarrier: item.Carrier,
					   reqfreightKgRate: item.KgRate,
					   reqfreightbaseCharge: item.baseCharge
				   });
			   }  
		   }
		   
		   if($scope.FGCurrency == 'AUD'){
			   
			   if( item.AUD == 1){ 
				   arrFC.push({
					   reqfreightName: item.Name,
					   reqfreightCarrier: item.Carrier,
					   reqfreightKgRate: item.KgRate,
					   reqfreightbaseCharge: item.baseCharge
				   });
			   }  
		   }

		   if($scope.FGCurrency == 'SGD'){
			  if( item.SGD == 1){ 
				   arrFC.push({
					   reqfreightName: item.Name,
					   reqfreightCarrier: item.Carrier,
					   reqfreightKgRate: item.KgRate,
					   reqfreightbaseCharge: item.baseCharge
				   });
			   }  
		   }
		   if($scope.FGCurrency == 'MYR'){
			  if( item.MYR == 1){ 
				   arrFC.push({
					   reqfreightName: item.Name,
					   reqfreightCarrier: item.Carrier,
					   reqfreightKgRate: item.KgRate,
					   reqfreightbaseCharge: item.baseCharge
				   });
			   }  
		   }
		   
	   }); 
	   // console.log(arrFC);
	   $scope.arrayFreightCosts = arrFC;
   
   
		   var arrFinal = [];
		   var arrFinalBlank = [];
	   
		   for (var key in $scope.arrayFreightCosts) { 
			   var shipName = $scope.arrayFreightCosts[key].reqfreightName; 
			   var shipCarrier = $scope.arrayFreightCosts[key].reqfreightCarrier; 
			   var shipKgRate = parseFloat($scope.arrayFreightCosts[key].reqfreightKgRate); 
			   var shipbaseCharge = Number($scope.arrayFreightCosts[key].reqfreightbaseCharge); 	

			  // console.log("ONE = " + shipName + "/" + shipCarrier+ "/" + shipKgRate+ "/" + shipbaseCharge); 

			   var arrayFreightVariable = [shipKgRate, shipbaseCharge, cartonWeight, cartonQuantity, $scope.cartonLength, $scope.cartonWidth, $scope.cartonHeight];
			   //console.log("TWO = " + arrayFreightVariable); 
			   //console.log(arrayFreightVariable);
			   var FreightCost1, FreightCost2, FreightCost3, FreightCost4, FreightCost5;
			   FreightCost1 = $scope.getFreightComputation(arrayFreightVariable, quantity1);
			   
			   FreightCost2 = $scope.getFreightComputation(arrayFreightVariable, quantity2);
			   FreightCost3 = $scope.getFreightComputation(arrayFreightVariable, quantity3);
			   FreightCost4 = $scope.getFreightComputation(arrayFreightVariable, quantity4);
			   FreightCost5 = $scope.getFreightComputation(arrayFreightVariable, quantity5);
			   FreightCost6 = $scope.getFreightComputation(arrayFreightVariable, quantity6);
			   
			  // console.log("Ethis = " + FreightCost1 + "/" + FreightCost2+ "/" + FreightCost3+ "/" + FreightCost4+ "/" + FreightCost5); 

			   FreightCost1 = FreightCost1 || 'FREE';
			   FreightCost2 = FreightCost2 || 'FREE';
			   FreightCost3 = FreightCost3 || 'FREE';
			   FreightCost4 = FreightCost4 || 'FREE';
			   FreightCost5 = FreightCost5 || 'FREE';
			   FreightCost6 = FreightCost6 || 'FREE';

			   

			   if(shipKgRate == '0' || shipKgRate == '0.00' || shipKgRate == null || shipKgRate == ''
			   && shipbaseCharge == '0' || shipbaseCharge == '0.00' || shipbaseCharge == null || shipbaseCharge == ''){
				   FreightCost1 = 'FREE';
				   FreightCost2 = 'FREE';
				   FreightCost3 = 'FREE';
				   FreightCost4 = 'FREE';
				   FreightCost5 = 'FREE';
				   FreightCost6 = 'FREE';
			   } 
			   
			   var hideCarrier = 0;
			   if (FreightCost1 == 'FREE' || FreightCost2 == 'FREE'  || FreightCost3 == 'FREE'  || FreightCost4 == 'FREE'  || FreightCost5 == 'FREE' || FreightCost6 == 'FREE'){
				   /*if(shipName != 'TNT'){
					   hideCarrier = 1;
				   } */
				   if(!(shipName == "TNT"  ||  shipName == "Economy")){ 
						hideCarrier = 1;
				   }
			   }

			   if(quantity1 == 0 || quantity1 == ""){
					FreightCost1 = "-"
			   }
			   if(quantity2 == 0 || quantity2 == ""){
					FreightCost2 = "-"
			   }
			   if(quantity3 == 0 || quantity3 == ""){
					FreightCost3 = "-"
			   }
			   if(quantity4 == 0 || quantity4 == ""){
					FreightCost4 = "-"
			   }
			   if(quantity5 == 0 || quantity5 == ""){
					FreightCost5 = "-"
			   }
			   if(quantity6 == 0 || quantity6 == ""){
					FreightCost6 = "-"
			   }

			   var shipFinal = { 
					   'shipName':shipName,
					   'shipKgRate':shipKgRate,
					   'shipbaseCharge':shipbaseCharge,
					   'FreightCost1' : FreightCost1,
					   'FreightCost2' : FreightCost2,
					   'FreightCost3' : FreightCost3,
					   'FreightCost4' : FreightCost4,
					   'FreightCost5' : FreightCost5,
					   'FreightCost6' : FreightCost6,
					   'hideCarrier' : hideCarrier,
					   'shipCarrier' : shipCarrier
			   } 	
			   //console.log(responseFreight.data.resultsFreightDetails[key].Name); 
			   arrFinal.push(shipFinal); 

 


		   }
		   //console.log(arrFinal);

		   $scope.FinalFreightCosts = arrFinal;
		    
		   
		   if($scope.FinalFreightCosts.length > 0){
			   $scope.FinalFreightCostsCount = $scope.FinalFreightCosts.length;  
		   } 
		   

	   
	   
   } 

   //Result of each freight cost per quantity
   $scope.getFreightComputation = function(arrayValue, qty){
	   
	   var shipKgRate = arrayValue[0];
	   var shipbaseCharge = arrayValue[1];
	   var cartonWeight = arrayValue[2];
	   var cartonQuantity = arrayValue[3];
	   var cartonLength = arrayValue[4];
	   var cartonWidth = arrayValue[5];
	   var cartonHeight = arrayValue[6];

	   var ActualKG = cartonWeight * qty / cartonQuantity;
	   var VolumetricKG = (cartonLength / 100 * cartonWidth / 100 * cartonHeight / 100) * qty / cartonQuantity * 200;
	   //console.log(ActualKG1 +  "/" + VolumetricKG);
	   var findMax = [ActualKG, VolumetricKG];
	   var Finalmax = Math.max.apply(Math, findMax);
	   //console.log(Finalmax);
	   var freight = Finalmax * shipKgRate + shipbaseCharge;
	   var FreightCost = Math.ceil(freight/5)*5;  

	   return FreightCost;
   }

   //Result AUD
   $scope.resultAUD = function(ships, vols){ 
	   var shipNew;
	   var volNew;
	   var result;
	   if(ships > vols){
		   shipNew = (ships * $scope.kgRate) + $scope.baseCharge;
		   result = Math.ceil(shipNew/5)*5; 
	   }else{
		   volNew = (vols * $scope.kgRate) + $scope.baseCharge;
		   result = Math.ceil(volNew/5)*5; 
	   } 
	   return result;
   }
   /* Freight Cost */

   /* SetupMarkup save */ 
   $scope.setMarkUpNew = function(setupMarkup, markup1, markup2, markup3, markup4, markup5, markup6){
	   var setupMarkup = setupMarkup || null;   
	   //console.log(setupMarkup + " save");
	   $http({
				   method: "post",
				   url:  "<?php echo base_url();?>Pricing/PricingPost",
				   data: { userIDmarkup: $scope.userIDmarkup, setupMarkup: setupMarkup,  markup1: markup1, markup2: markup2, markup3: markup3, markup4: markup4, markup5: markup5, markup6: markup6, option: 3, secondaryIDActive: $scope.secondaryIDActive  } 
				   
		   }).then(function successCallback(responseMarkup) {  
			   //console.log("Done xx " + responseMarkup.data); 
				   if(responseMarkup.data == 1){
						   //console.log("Done"); 
						   var elementMarkupSave = angular.element('.markupsave'); 
						   elementMarkupSave.css('display', 'inline-block');  
						   var elementmarkInput = angular.element('.markInput'); 
						   elementmarkInput.css('border', '1px solid #02cd07'); 
						   $timeout(function() { 
							   elementMarkupSave.css('display', 'none');  
							   elementmarkInput.css('border', '1px solid #494949'); 
						   }, 1200);
				   }
		   }, function errorCallback(responseMarkup) {
			   console.log("Error retrieving the data");
	   });
   
   }
   /* SetupMarkup save */ 



   /* Price */
   $scope.getPrice = function(mOption, priceSummary, markupPercentage, optins){
		 // console.log("TRIGGER HERE!");
		 // console.log(mOption + "/" + priceSummary + "/" + markupPercentage);
		// console.log("Markup  naman " + $scope.markup1);

		var marknew;
		if(marknew = angular.element('.markInput' + mOption).val()){ 
			 //console.log("@@1 marknew" + mOption + " = " + marknew);
			markupPercentage = marknew;
		} 

		if(angular.element('.markInput' + mOption).val() == ""){
			markupPercentage = 0;
			 //console.log("@@2 marknew" + mOption + " = " + markupPercentage);
		}

	   var optins = optins || null; 

	   var markupPercentageTemp; 
	   var markupPercentageTotal; 
	   markupPercentageTemp = markupPercentage / 100;
	   markupPercentageTotal = 1 + markupPercentageTemp;
	   var pRank;

	   // console.log("ORIG MARK1 LAGI XXX - " + markupPercentage + "/" + optins);
	   if(mOption == 1){
			

		   if(optins == "optional"){
			   $scope.markup1NewVariable = markupPercentage;   
		   }
		   //console.log("MARKUP1 = " + $scope.markup1NewVariable); 
		   if($scope.markup1NewVariable != 0){
			   markupPercentageTemp = $scope.markup1NewVariable / 100;
			   markupPercentageTotal = 1 + markupPercentageTemp;
		   }  

		   $scope.price1 = markupPercentageTotal * priceSummary;	
		   pRank = 1;
		   $scope.calculateTotalHelper($scope.price1, pRank);
	   }
	   if(mOption == 2){

		   if(optins == "optional"){
			   $scope.markup2NewVariable = markupPercentage;   
		   }
		   //console.log("MARKUP2 = " + $scope.markup2NewVariable); 
		   if($scope.markup2NewVariable != 0){
			   markupPercentageTemp = $scope.markup2NewVariable / 100;
			   markupPercentageTotal = 1 + markupPercentageTemp;
		   }  

		   $scope.price2 = markupPercentageTotal * priceSummary;
		    
		   pRank = 2;
		   $scope.calculateTotalHelper($scope.price2, pRank);
	   }
	   if(mOption == 3){

		   if(optins == "optional"){
			   $scope.markup3NewVariable = markupPercentage;   
		   }
		   //console.log("MARKUP3 = " + $scope.markup3NewVariable); 
		   if($scope.markup3NewVariable != 0){
			   markupPercentageTemp = $scope.markup3NewVariable / 100;
			   markupPercentageTotal = 1 + markupPercentageTemp;
		   }  

		   $scope.price3 = markupPercentageTotal * priceSummary;	
		   pRank = 3;
		   $scope.calculateTotalHelper($scope.price3, pRank);
	   }
	   if(mOption == 4){

		   if(optins == "optional"){
			   $scope.markup4NewVariable = markupPercentage;   
		   }
		   //console.log("MARKUP4 = " + $scope.markup4NewVariable); 
		   if($scope.markup4NewVariable != 0){
			   markupPercentageTemp = $scope.markup4NewVariable / 100;
			   markupPercentageTotal = 1 + markupPercentageTemp;
		   }  

		   $scope.price4 = markupPercentageTotal * priceSummary;
		   pRank = 4;	
		   $scope.calculateTotalHelper($scope.price4, pRank);
	   }
	   if(mOption == 5){

		   if(optins == "optional"){
			   $scope.markup5NewVariable = markupPercentage;   
		   }
		   //console.log("MARKUP5 = " + $scope.markup5NewVariable); 
		   if($scope.markup5NewVariable != 0){
			   markupPercentageTemp = $scope.markup5NewVariable / 100;
			   markupPercentageTotal = 1 + markupPercentageTemp;
		   }  

		   $scope.price5 = markupPercentageTotal * priceSummary;	
		   pRank = 5;
		   $scope.calculateTotalHelper($scope.price5, pRank);
	   }
	   if(mOption == 6){

		   if(optins == "optional"){
			   $scope.markup6NewVariable = markupPercentage;   
		   }
		   //console.log("MARKUP6 = " + $scope.markup6NewVariable); 
		   if($scope.markup6NewVariable != 0){
			   markupPercentageTemp = $scope.markup6NewVariable / 100;
			   markupPercentageTotal = 1 + markupPercentageTemp;
		   }  

		   $scope.price6 = markupPercentageTotal * priceSummary;	
		   pRank = 6;
		   $scope.calculateTotalHelper($scope.price6, pRank);
	   }
	   


	   
   }
   /* Price */

 $scope.calculateTotalHelper = function(price, rank){
	 if(rank == 1){
		 $scope.price1 = price;
	 }
	 if(rank == 2){
		 $scope.price2 = price;
	 }
	 if(rank == 3){
		 $scope.price3 = price;
	 }
	 if(rank == 4){
		 $scope.price4 = price;
	 }
	 if(rank == 5){
		 $scope.price5 = price;
	 }
	 if(rank == 6){
		 $scope.price6 = price;
	 }
	 $scope.calculateTotal();
 }  

$scope.calculateTotal = function(){
	 
	$scope.totalPrice1  =  Number($scope.price1) * Number($scope.priceResults.Quantity1);
	$scope.totalPrice2  =  Number($scope.price2) * Number($scope.priceResults.Quantity2);
	$scope.totalPrice3  =  Number($scope.price3) * Number($scope.priceResults.Quantity3);
	$scope.totalPrice4  =  Number($scope.price4) * Number($scope.priceResults.Quantity4);
	$scope.totalPrice5  =  Number($scope.price5) * Number($scope.priceResults.Quantity5);
	$scope.totalPrice6  =  Number($scope.price6) * Number($scope.priceResults.Quantity6);
}


   /* GEt Detail Loop */

   $scope.getDetailLoopNew = function(AdditionalsLoop, setupMvar){
		var AdditionalsLoop = AdditionalsLoop || null;  
		var setupMvar = setupMvar || null; 
		 
		var additionalsArrayDetail = [];
		var detailArr;
		var setupQty;
		var setupPercent;
		var setupOverAllTotalTemp;
		var setupOverAllTotal = [];
		var setupOverAllTotalFinal = 0;
		var setupOverAllTotalEach;
		var soat;
		var soatTemp;
		var soatFin;
		var soatFinal;

 		if(setupMvar == null){
		   setupMvar = $scope.priceResultsUserMarks.setupMarkup;
	    } 
	 
		if(AdditionalsLoop == null){
		   AdditionalsLoop = $scope.AdditionalsLoop;
	    }
		
		angular.forEach(AdditionalsLoop, function(value, key){  

			if(  (value.inputVal != 0 && !value.splitdelivery)  || (value.inputVal2 > 0 && !value.splitdelivery) || (value.inputVal > 0 && value.inputVal2 > 0 &&  value.splitdelivery == 1)  || (value.inputVal == 0 && value.inputVal2 > 0) || (value.inputVal != 0  && value.inputVal2 > 0 && value.splitdelivery == 1 && $scope.incSetup == true)){ 

					/* ONLY FOR THE SKINNED SITE */
					<?php if ($skinnedUserCheck['skinnedLoggedIn'] == 1 ||  $customArray['themeArray'][0]->showPricing == 1){  ?> 
									setupPercent = null;
									setupQty = value.inputVal * value.setup; 
									soatFinal = value.inputVal * value.setup;   
									soatFinal =  (soatFinal % 5)  ?    parseInt(soatFinal / 5) * 5 + 5 : parseInt(soatFinal / 5) * 5; 

					<?php }else{  ?>  
					/* ONLY FOR THE SKINNED SITE */  
									
									setupPercent = 1 + (setupMvar / 100);
									setupQty = value.inputVal * value.setup; 
									
									soat = 1 * value.setup;	
								
									soatTemp = soat * setupPercent;  
									//soatFinal1 = 5 * Math.round(soatTemp/5); 
									soatFinal1 = soatTemp; 

									soatFinal2  = value.inputVal2 * soatFinal1;  
									
									//Round up to the nearest 5
									soatFinal =  (soatFinal2 % 5)  ?    parseInt(soatFinal2 / 5) * 5 + 5 : parseInt(soatFinal2 / 5) * 5;

								 //console.log(key + " //// soatFinal1 ==> " + soatFinal2 + " / soatFinal ==> " + soatFinal2); 

								 //console.log(key + " //// value.setup ==> " + value.setup + " / value.inputVal ==> " + value.inputVal + " /  value.inputVal2 ==>  " + value.inputVal2); 

					<?php } ?>
					
					 

					setupOverAllTotalTemp = soatFinal;  
					setupOverAllTotal.push(setupOverAllTotalTemp);  
					detailArr = {'additionalvalue': value.adds, 'additonalperunit':value.cost, 'additionalsetup':value.setup, 'additionalqty':value.inputVal, 'additionalmarkuppercentage':setupMvar, 'setupqty':setupQty, 'setup':setupPercent, 'soatFinal':soatFinal, 'splitdelivery': value.splitdelivery  };  
					additionalsArrayDetail.push(detailArr); 
						
				 
			}


		}); 

		$scope.detailsArray = additionalsArrayDetail; 
				   
		for (var i = 0; i < setupOverAllTotal.length; i++) {   
			setupOverAllTotalFinal += setupOverAllTotal[i]; 
		}   
		$scope.setupOverAllTotalFinal = setupOverAllTotalFinal; 
	    
   }


   $scope.getDetailLoop = function(AdditionalsLoop, setupMvar, opt, valueInputTwo, rank){
	   var AdditionalsLoop = AdditionalsLoop || null;  
	   var setupMvar = setupMvar || null;
	   var opt = opt || null;
	   var valueInputTwo = valueInputTwo || null;

	 	//console.log("opt= " + opt + " / valueInput2=  " + valueInputTwo + " / rank= " +  rank)
	    
	  

	   if(setupMvar == null){
		   setupMvar = $scope.priceResultsUserMarks.setupMarkup;
	   } 
	   if(AdditionalsLoop == null){
		   AdditionalsLoop = $scope.AdditionalsLoop;
	   }


	   

	   
	  

			   /* waiting ....... */
			   var additionalsArrayDetail = [];
			   var detailArr;
			   var setupQty;
			   var setupPercent;
			   var setupOverAllTotalTemp;
			   var setupOverAllTotal = [];
			   var setupOverAllTotalFinal = 0;
			   var setupOverAllTotalEach;
			   var soat;
			   var soatTemp;
			   var soatFin;
			   var soatFinal;
			   
			   

			   //if($scope.setupMarkupAdditionals){
			 
			  // if(setupMvar){

				      
					 
					   
				  
				  
				   angular.forEach(AdditionalsLoop, function(value, key){ 
						
					    
					   if( (value.inputVal != 0 && !value.splitdelivery) || (value.inputVal != 0  && value.inputVal2 > 0 && value.splitdelivery == 1 && $scope.incSetup == true)){ 

						   /* ONLY FOR THE SKINNED SITE */
						   <?php if ($skinnedUserCheck['skinnedLoggedIn'] == 1 ||  $customArray['themeArray'][0]->showPricing == 1){  ?> 
								   setupPercent = null;
								   setupQty = value.inputVal * value.setup; 
								   soatFinal = value.setup;    

						   <?php }else{  ?>  
						   /* ONLY FOR THE SKINNED SITE */  

									
								   setupPercent = 1 + (setupMvar / 100);
								   setupQty = value.inputVal * value.setup;

								    //console.log(" value.setup ==> " +  value.setup);
								   
								   soat = 1 * value.setup;	
								  
								   soatTemp = soat * setupPercent;  
								   soatFinal = 5 * Math.round(soatTemp/5); 

								    if(opt == 2 && value.fieldPosition == rank){
										soatFinal  = valueInputTwo * soatFinal;  
									} 

								  // console.log("soatFinal " + soatFinal);

								  // console.log(key + " //// value.setup ==> " + value.setup + " / value.inputVal ==> " + value.inputVal + " /  value.inputVal2 ==>  " + value.inputVal2); 

						   <?php } ?>

						     
							

						   setupOverAllTotalTemp = value.inputVal * soatFinal;  

						  
						   
						   setupOverAllTotal.push(setupOverAllTotalTemp); 
						    
						   detailArr = {'additionalvalue': value.adds, 'additonalperunit':value.cost, 'additionalsetup':value.setup, 'additionalqty':value.inputVal, 'additionalmarkuppercentage':setupMvar, 'setupqty':setupQty, 'setup':setupPercent, 'soatFinal':soatFinal  }; 
						     
						   additionalsArrayDetail.push(detailArr); 
						   //console.log("detailArr " );
						   // console.log(additionalsArrayDetail); 
						   
					   } 
					   
				   }); 


				   
				   
				   
				   
				   $scope.detailsArray = additionalsArrayDetail; 
				   
				   for (var i = 0; i < setupOverAllTotal.length; i++) {   
					   setupOverAllTotalFinal += setupOverAllTotal[i]; 
				   }   
				   $scope.setupOverAllTotalFinal = setupOverAllTotalFinal;


				 
				  
			   //} 
		    
				   
   }
   /* GEt Detail Loop */

   $scope.touchedThis = function(){


								/*var rankSetup = rankSetup || null;  
								var thisSetupValue = thisSetupValue || null;  

								console.log(rankSetup + " / " + thisSetupValue);
								$scope.thisSetupValue =  thisSetupValue;
								$scope.rankSetup = rankSetup;  
								 
								if($scope.rankSetup == value.fieldPosition){ 
									console.log("PASOK! " + $scope.thisSetupValue);
									var totalSetup = $scope.thisSetupValue  * soatFinal
									return  totalSetup;  
								}  */
	}


 

   /* Round off function scope */
   $scope.roundOff = function (sumTotal, prices){
	   var sum = sumTotal + prices;
	   return Math.round(sum * 100) / 100; 
   }

   $scope.roundOffNone = function (sumTotal, prices){
	   var sum = sumTotal + prices;
	   return sum.toFixed(2); 
   }

   $scope.roundOffNumber = function(num){
	   //console.log(num);
	   return Math.round(num * 100) / 100; 
   }

   /* Delete variable inside array */
   $scope.removeRank = function(costArray, rank){
	   var index = costArray.indexOf(rank); 
	   costArray.splice(index, 1); 
	   return costArray;  
   }

   $scope.checkQtyEnabled = function(headingQuantity1, headingQuantity2, headingQuantity3, headingQuantity4 ,headingQuantity5, headingQuantity6){
					   if(headingQuantity1 == 0){
						   $scope.disabledQty1 = true;
					   }else{
						   $scope.disabledQty1 = false;
					   } 
					   if(headingQuantity2 == 0){
						   $scope.disabledQty2 = true;
					   }else{
						   $scope.disabledQty2 = false;
					   } 
					   if(headingQuantity3 == 0){
						   $scope.disabledQty3 = true;
					   }else{
						   $scope.disabledQty3 = false;
					   }  
					   if(headingQuantity4 == 0){
						   $scope.disabledQty4 = true;
					   }else{
						   $scope.disabledQty4 = false;
					   }  
					   if(headingQuantity5 == 0){
						   $scope.disabledQty5 = true;
					   }else{
						   $scope.disabledQty5 = false;
					   }  
					   if(headingQuantity6 == 0){
						   $scope.disabledQty6 = true;
					   }else{
						   $scope.disabledQty6 = false;
					   } 
   }

   $scope.defaultQtyEnabled = function(){
	   $scope.disabledQty1 = false;
	   $scope.disabledQty2 = false;
	   $scope.disabledQty3 = false;
	   $scope.disabledQty4 = false;
	   $scope.disabledQty5 = false;
	   $scope.disabledQty6 = false;
   }



   $scope.getQuoteMessage = function(){
	   //console.log($scope.userIDmarkup + " user here " + $scope.FGCode); 
	   $scope.quickMsgComment = "";

	   <?php if($secondaryIDActive): ?> $scope.secAccount = '<?php echo $secondaryIDActive; ?>'; <?php else: ?> $scope.secAccount = null; <?php endif;?>
	   //console.log("THIIIIIIS " + $scope.secAccount);
		 $http({
				   method: "post",
				   url:  "<?php echo base_url();?>Pricing/PricingPost",
				   data: { userIDmsg: $scope.userIDmarkup, fgcode: $scope.FGCode,  option: 5, secAccount: $scope.secAccount } 
				   
		   }).then(function successCallback(responseQuote) {  
			   //console.log(responseQuote);  
			   if(responseQuote.data > 0 || responseQuote.data != " "){ 
				   
				   if(responseQuote.data.length > 0){
					   $scope.quickMessage = responseQuote.data;  
					   $scope.quickComment = 1;
				   }else{
					   $scope.quickMessage = $scope.quickMsgComment;
					   $scope.quickComment = 0;
				   }
				   
			   }else{
				   $scope.quickMessage = $scope.quickMsgComment;
				   $scope.quickComment = 0;
			   }  
			   //console.log($scope.quickComment);  
		   }, function errorCallback(responseQuote) {
			   console.log("Error retrieving the data responseQuote");
	   });
   }

   $scope.updateQuoteMessage = function(quickMsg, userIDquote){
	   //console.log(quickMsg + " // " +userIDquote); 
	   <?php if($secondaryIDActive): ?> $scope.secAccount = '<?php echo $secondaryIDActive; ?>'; <?php else: ?> $scope.secAccount = null; <?php endif;?>
	   $http({
				   method: "post",
				   url:  "<?php echo base_url();?>Pricing/PricingPost",
				   data: { quickMsg: quickMsg, userIDquote:userIDquote,  option: 6, secAccount: $scope.secAccount  } 
				   
		   }).then(function successCallback(responseQuoteR) {  
				   $scope.getQuoteMessage();	 
			   $timeout(function() {
				   updateQuote(); 
			   }, 200);   
		   }, function errorCallback(responseQuoteR) {
			   console.log("Error retrieving the data updateQuote");
	   });             
   }

   $scope.downloadQuoteImg = function(){
	   downloadQuoteImage(); 
   }

   
   $scope.changeTab = function(e, inputRow, eNum) {
	   
	   if (e.keyCode == 9){ 
		   var nextTab;
		   var currs = $scope.CurrencyUpdate;
		   if(eNum == 1){ 
			   var additionalCount = $scope.AdditionalsLoop.length - 1; 
			   //nextTab = inputRow + 1;  
			   nextTab = inputRow;  
			   angular.element('.'+currs+'getAdditionalID' + nextTab).focus();    
			   if(nextTab > additionalCount){
				   angular.element('.'+currs+'priceSummary1').focus();   
			   }
		   } 
		   if(eNum == 2){   
			   nextTab = inputRow; 
			   angular.element('.'+currs+'priceSummary' + nextTab).focus();   
			   if(nextTab > 6){
				   angular.element('.'+currs+'priceSummary7').focus();   
			   } 
		   }  
		   if(eNum == 3){  
			   nextTab = inputRow; 
			   angular.element('.'+currs+'priceSummary' + nextTab).focus();  
			   if(nextTab > 12){
				   angular.element('.'+currs+'markInput1').focus();   
			   }  
		   } 
		   if(eNum == 4){  
			   nextTab = inputRow; 
			   angular.element('.'+currs+'markInput' + nextTab).focus();   
		   } 
		   
	   } 
   } 
   
   /* TRansit Time */

   /* ACTIVATE TRANSIT */
   $scope.activateTransit = function(carrier){

	   var carrier = carrier || null;  

	   if(carrier == 'TNT - Ex Melb'){

			
			
		   $http({
				   method: "post",
				   url:  "<?php echo base_url();?>Pricing/PricingPost",
				   data: {    option: 12 } 
				   
		   }).then(function successCallback(responseGetTransits) {
				
			   $scope.loadingMsg = false;
			   $scope.getMelbourneTransit =	responseGetTransits.data;

		   }, function errorCallback(responseGetTransits) {
			   console.log("Error retrieving the responseGetTransits");
		   });  
		   
	   }else{

			

			$http({
				   method: "post",
				   url:  "<?php echo base_url();?>Pricing/PricingPost",
				   data: {    option: 11 } 
				   
		   }).then(function successCallback(responseGetTransit) {
				
			   $scope.loadingMsg = false;
			   $scope.getAUTransit =	responseGetTransit.data;

		   }, function errorCallback(responseGetTransit) {
			   console.log("Error retrieving the responseGetTransit");
		   });  


	   } 	
   }


	   /* ACTIVATE TRANSIT */

	   /* MELBOURNE */

	   $scope.getSearchMelbourne = function(name ){
	   //console.log(name ); 
			   if(name){ 
				   $scope.ausTransitNew = name; 
				   $scope.ausTransit = $scope.ausTransitNew; 
				   $scope.dropDown = false;
				   $scope.inputSearchResult = true; 
				   $scope.inputSearchBox = false;  

				   $http({
						   method: "post",
						   url:  "<?php echo base_url();?>Pricing/PricingPost",
						   data: {   name:name,  option: 13 } 
						   
				   }).then(function successCallback(responseTransitM) {  
					   //console.log(responseTransitM.data);  

					   
					   var economyValueM;

					   //Economy only for now
					   economyValueM = $scope.getValueEachTransit(responseTransitM.data.EconomyMin, responseTransitM.data.EconomyMax); 
					   $scope.EconomyDataM =   economyValueM;
					   
	   
					   $scope.showTableTransitMelbourne = true;
						   
				   }, function errorCallback(responseTransitM) {
					   console.log("Error retrieving the responseTransit");
				   });        


			   } 
	   }

	   /* MELBOURNE */

   //transfer this variables to top 
   $scope.getSearch = function(name, state){
	   //console.log(name + " // " +  state); 
	   if(name){ 
		   $scope.ausTransitNew = name; 
		   $scope.ausTransit = $scope.ausTransitNew; 
		   $scope.dropDown = false;
		   $scope.inputSearchResult = true; 
		   $scope.inputSearchBox = false;  

		   $http({
				   method: "post",
				   url:  "<?php echo base_url();?>Pricing/PricingPost",
				   data: {  state:  state, name:name,  option: 10 } 
				   
		   }).then(function successCallback(responseTransit) {  
			   //console.log(responseTransit.data);  

			   
			   var economyValue, expressValue, priorityValue;

			   //Economy
			   economyValue = $scope.getValueEachTransit(responseTransit.data.EconomyMin, responseTransit.data.EconomyMax); 
			   //var econom1 = parseInt(responseTransit.data.EconomyMin) + 1; 
			   //var econom2 = parseInt(responseTransit.data.EconomyMax) + 1;
			   //console.log(responseTransit.data.EconomyMin + " => " + econom1 + " / " + responseTransit.data.EconomyMax + " => " + econom2 );		
			   //economyValue = $scope.getValueEachTransit(econom1, econom2); 
			   $scope.EconomyData =   economyValue;
			   
			   //Priority
			   priorityValue  = $scope.getValueEachTransit(responseTransit.data.PriorityMin, responseTransit.data.PriorityMax); 
			   $scope.PriorityData =   priorityValue;

			   //Express
			   expressValue  = $scope.getValueEachTransit(responseTransit.data.ExpressMin, responseTransit.data.ExpressMax); 
			   $scope.ExpressData =   expressValue;

			   $scope.showTableTransit = true;
				   
		   }, function errorCallback(responseTransit) {
			   console.log("Error retrieving the responseTransit");
		   });        


	   } 
   }

   $scope.getValueEachTransit = function(min, max){
	   var wd = ' Working Days';
	   var cu = ' Contact Us ';
	   var outputValue;
	   if(min != max){
		   outputValue = min + "-" + max + wd;
	   }
	   if(min == max){
		   if(max == 1){
			   wd = ' Working Day';
		   }
		   outputValue = max  + wd;
	   } 
	   if(min == 0 || max == 0){
		   outputValue = cu;
	   } 

	   return outputValue;

   }

   $scope.showDropdown = function(va){
	   if(va){
		   $scope.dropDown = true;
	   }
	   
   };

   $scope.hideDropdown = function(){
	   $scope.dropDown = false;
   };	
   
   $scope.showInputSearch = function(){
	   $scope.inputSearchResult = false;   
	   $scope.inputSearchBox =  true;  
   };

/* TRansit Time */


<?php  endif;  // Access user only  ?>

/* ENd Pricing Here */




$scope.imgNum = null;
$scope.location =  '<?=base_url();?>';







   $scope.zoomImage = function(num, countImg){
	   angular.element(document.querySelector(".item-imgs")).removeClass("active"); 
	   for(var i = 0; i <= countImg; i++){
		   angular.element(document.querySelector(".activateThis-" + i)).removeClass("active");
	   }  
	   var elementAdd = angular.element(document.querySelector(".activateThis-" + num)).addClass("active");
	   $scope.imgNum = num;
   }

$scope.getLoopImg = function(act, loopNum){
   //console.log(loopNum);
   
   $scope.imageCaption = '';

   for(var i = 0; i <= loopNum; i++){
		   var elementC = angular.element('.activateThis-' + i ); 
		   if(angular.element(elementC).hasClass('active') ){
			   
			   var x;
			   if(act == 'prev'){
				   if(i != 0){
						   x = i - 1;
				   }else{
						   x = loopNum;
				   } 
			   
			   }
			   if(act == 'next' ){
				   if(i != loopNum){
					   x = i + 1;
				   }else{
						   x = 0;
				   } 
			   }  

			   $scope.imgNum = x;
			   //console.log("Item " + x + " is active");

		   }
   }
}


/* CHANGES  TAB */
$scope.ChangesForm = {};
$scope.getChangeType = <?=$getChangeTypeJson?>;
$scope.ChangesForm.changesType = 0;
$scope.ChangesForm.changesItemCode = $scope.productCode;

$scope.changesTabFunction = function(indexNum, optin){
   var indexNum = indexNum || null;
   var optin = optin || null;

   
   
   if(indexNum == null && optin == null){ 
		   $scope.ChangesForm.opts = 1;   
		   var element = angular.element('#Changesmodal'); 
				   element.modal('show');   
   }

   if(indexNum != null && optin == 2){
	   $scope.ChangesForm.opts = 2;  
	   
	   var element = angular.element('#Changesmodal'); 
				   element.modal('show');  


		   $http({
				   method: "post",
				   url:  "<?php echo base_url();?>Pricing/Changes",
				   data: {indexNum: indexNum, option: 2}
				   
		   }).then(function successCallback(response) {  
			   //console.log(response.data);  
			   
			   $scope.ChangesForm.indexNum = response.data.indexNum;
			   $scope.ChangesForm.changesType = response.data.ChangeType;
			   $scope.ChangesForm.changesDesc = response.data.Description;

				   
				   
		   }, function errorCallback(response) {
			   console.log("Error retrieving the Changes UPDATE ");
		   });    
   }

   if(indexNum != null && optin == 3){

	   if (confirm("Are you sure you want to delete this changes?")) {  
			   $scope.ChangesForm.opts = 3;  
			   $scope.ChangesForm.indexNum = indexNum;
			   $scope.ChangesForm.option = 3;
			   //console.log($scope.ChangesForm);


			   $http({
					   method: "post",
					   url:  "<?php echo base_url();?>Pricing/Changes",
					   data: $scope.ChangesForm
					   
			   }).then(function successCallback(response) {  
				   //console.log(response.data);  
				   $timeout(function() {
					   $window.location.reload();
				   }, 300);     
					   
			   }, function errorCallback(response) {
				   console.log("Error retrieving the Changes Delete ");
			   }); 
	   }   
   }

   
}

$scope.changesTabFunctionSubmit = function(){
	   
		   $scope.ChangesForm.option = 1;
		   //console.log($scope.ChangesForm);
	   $http({
				   method: "post",
				   url:  "<?php echo base_url();?>Pricing/Changes",
				   data: $scope.ChangesForm 
				   
		   }).then(function successCallback(response) {  
			   //console.log(response.data);  
				   $timeout(function() {
					   $window.location.reload();
				   }, 300);   
			   
		   }, function errorCallback(response) {
			   console.log("Error retrieving the Changes ");
		   });     
}

/* CHANGES  TAB */



/* Enquiry Form */
<?php if(count($customArray['themeArray']) > 0 || $siteLogcheck['loggedIn'] == 0): ?>    
   $scope.skinnedEnquiryForm = {}; 
   $scope.skinnedButton = true;
   $scope.skinnedFormMessage = false; 
   $scope.alright = false; 
   $scope.alrightP = false; 
   $scope.skinnedEnquiryForm.emailTo = '<?=$customArray['themeArray'][0]->Email?>';

   <?php if($customArray['themeArray'][0]->Domain): ?>
   		$scope.skinnedEnquiryForm.skinnedDomain = '<?=$customArray['themeArray'][0]->Domain?>';
	<?php else: ?>
		$scope.skinnedEnquiryForm.skinnedDomain = '<?=$_SERVER['SERVER_NAME'];?>/ID<?=$customArray['themeArray'][0]->CustomerNumber?><?=$customArray['themeArray'][0]->themeID?>';
   <?php endif; ?>

   $scope.enquiryMsg = false;
   $scope.enquiryForm = function(Code, Name){ 
	   $scope.skinnedEnquiryForm.Product = Name;
	   $scope.skinnedEnquiryForm.Code = Code;
   }
   $scope.skinnedFormCheck = function(opts, val){
	   if(opts == 'email'){
		   var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

		   if (!re.test(val))
		   {
			   $scope.alright = false;  
		   }else{
			   $scope.alright = true;  
		   }
	   }
	   if(opts == 'phone'){
		   var re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;

		   //if (!re.test(val))
		   if(isNaN(val))
		   { 
			   $scope.alrightP = false;  
		   }else{
			   $scope.alrightP = true;  
		   
		   
		   }
	   }
   }

   $scope.BotValue = false;
    $scope.makeBotTrue = function(val){
        if(val == true){
            $scope.BotValue = true;
        }else{
            $scope.BotValue = false;
        }
        
    }

   $scope.submitSkinnedForm = function(){
	   //console.log($scope.skinnedEnquiryForm);
	   $scope.skinnedEnquiryForm.option = 1;
	   $scope.skinnedEnquiryForm.BotValue = 0;

	    if($scope.BotValue == true){
            $scope.skinnedEnquiryForm.BotValue = 1;
		}
		console.log($scope.skinnedEnquiryForm);
		if($scope.skinnedEnquiryForm.Human == true && $scope.BotValue == true){
			 $http({
							method: "post",
							url:  "<?php echo base_url();?>Angular/enquiryForm",
							data: $scope.skinnedEnquiryForm
							
					}).then(function successCallback(response) {  
						//console.log(response.data);  
						
						$scope.enquiryMsg = true;   

						var msg1 = "Your enquiry for ";   
						var msg2 = ' has successfully been sent, you should hear back from us soon.';
						
						$scope.enquiryMsg = msg1 + $scope.skinnedEnquiryForm.Product + msg2;
						$timeout(function() { 
								$scope.enquiryMsg = false;  
								$scope.skinnedEnquiryForm = {};  
						}, 3000);
						
					}, function errorCallback(response) {
						console.log("Error retrieving the enquiry form ");
			});  
			
		}


   }
<?php endif; ?>    


   $scope.imageCaption = null;
   $scope.selectCaption = function(caption){
	   //console.log(caption);
	   $scope.imageCaption = caption;
   }

   $scope.mixmatchCode = false;
   $scope.getMixMatch = function(code){
	   $scope.mixmatchCode = true;
	   $scope.mixmatchCodeP = '<?php echo base_url();?>' + 'MixMatch/' + code + '/';
	   $scope.mixmatchCodeF = '<iframe  src=" ' + $scope.mixmatchCodeP + ' " allowfullscreen></iframe> ';
	   
   }

   /* Foreach for Currency Datas */

   $scope.foreachCurrencies = function(getCurrencyDatasFinal, Curr){
		getCurrencyDatasFinal.forEach(function(entryCurr) { 
			if(entryCurr.currencyID == Curr){
				Curr = entryCurr.currencyName;
			}
		});

		return Curr;
   }

    $scope.foreachCurrencyCountry = function(getCurrencyDatasFinal, Curr){
		getCurrencyDatasFinal.forEach(function(entryCurr) { 
			if(entryCurr.currencyID == Curr){ 
				Country = entryCurr.currencyCountry;
			}
		});

		return Country;
   }

   $scope.cleanStringAmp =function(str){

	   if(str){
			return str.replace(/&amp;|&amp/gi, "&");
	   }else{
		   return str ="";
	   }  

   }; 

   
   /* Foreach for Currency Datas end */

}]); // end controller


//Jquery 
/* Related Items Jquery */

$(document).ready(function(){

   $('.related-items').slick({ 
	   infinite: true,
	   slidesToShow: 6,
	   slidesToScroll: 1,
	   autoplay: true,
	   autoplaySpeed: 5000  
   });

   

   
});





</script>


