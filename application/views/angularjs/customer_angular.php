<?php 
		 
		 

		 //ORDERS
	 //echo $start. " / " . $end;
	 
		 
		$json_data=array(); 
		$limitStringOne = 23;
		$limitStringOneStatProduct = 28;
		$limitStringOneStat = 20;
		$limitStringTwo = 24;
		$limitStringDesc= 25;
		$limitStringThree = 22;
		$limitStringPON = 21;
 
		
        for($x = 0; $x < count($CustomerOrders); $x++){
			$json_array['OrderIndex']= $x; 

			if($x > $end || $x < $start  ){
				$json_array['HideMe']= 1; 
			}else{
				$json_array['HideMe']= 0; 
			}

			$json_array['SalesOrder']=$this->general_model->convert_to_utf8_recursively($CustomerOrders[$x]['SalesOrderNumber']); 
			if($CustomerOrders[$x]['SalesOrderNumber']){
				$json_array['JobNumberEncrypt'] = $this->general_model->getEncrypt($CustomerOrders[$x]['SalesOrderNumber']);
			}
			
			$json_array['DeliveryStatus']=$this->general_model->cleanCustomers($CustomerOrders[$x]['DeliveryStatus']);


			$json_array['Invoice']=$this->general_model->convert_to_utf8_recursively($CustomerOrders[$x]['Invoice']);
		 
			

			//$json_array['PON']=$CustomerOrders[$x]['PurchaseOrderNumber']; 

			$json_array['PONShortDisplay'] = 0; 
			$PurchaseOrderNumber = $this->general_model->cleanCustomers($this->general_model->convert_to_utf8_recursively($CustomerOrders[$x]['PurchaseOrderNumber'])); 
			$json_array['PONShort'] = ucfirst(strtolower($PurchaseOrderNumber));
			$json_array['PON']= ucfirst(strtolower($PurchaseOrderNumber)); 
			if($CustomerOrders[$x]['PurchaseOrderNumber']){
				if (strlen($json_array['PON']) > $limitStringPON){
					$json_array['PONShortDisplay'] = 1; 
					$json_array['PONShort'] = substr(ucfirst(strtolower($json_array['PON'])), 0, $limitStringPON);
				} 
			}
			
			//Status
			$json_array['StatusShortDisplay'] = 0; 
			$Status = $this->general_model->convert_to_utf8_recursively($this->general_model->cleanCustomers($CustomerOrders[$x]['Status'])); 
			$json_array['StatusShort'] = $Status;
			$json_array['Status']=$Status; 
			if($CustomerOrders[$x]['Status']){
				if (strlen($json_array['Status']) > $limitStringOneStat){
					$json_array['StatusShortDisplay'] = 1; 
					$json_array['StatusShort'] = substr($json_array['Status'], 0, $limitStringOneStat);
				} 
			}

			$stat = explode(" ", $CustomerOrders[$x]['Status']);
			$json_array['StatusColour'] = ""; 
			if($stat[0] > 0){  
				$json_array['StatusNumber'] = sprintf('%02d', $stat[0]);
			}

			if($stat[0] <= 8){
				$json_array['StatusColour'] =  "yellowbg";
			}
			if($stat[0] <= 20 && $stat[0] > 8){
				$json_array['StatusColour'] =  "tealbg";
			}

			if($stat[0] >=  21 ){
				$json_array['StatusColour'] =  "greenbg";
			}


			if(
					$CustomerOrders[$x]['Status'] == "2 - Waiting on Artwork" || 
					$CustomerOrders[$x]['Status'] == "2 - Artwork Requested" || 
					$CustomerOrders[$x]['Status']== "4 - On Hold" || 
					$CustomerOrders[$x]['Status'] == "5 - Proofed to Customer" || 
					$CustomerOrders[$x]['Status'] == "7 - Waiting on Payment" || 
					$CustomerOrders[$x]['Status'] == "20 - Despatch Hold"  
			){
					$json_array['rowBG'] = "rowRedBG";
			}else{
					$json_array['rowBG'] = "";
			}

			$statusNameOnly = explode("-", $CustomerOrders[$x]['Status']); 
			$json_array['StatusName'] = $this->general_model->convert_to_utf8_recursively(ltrim($statusNameOnly[1]));


			

			
			//Product Desc
			$json_array['ProductDescriptionShortDisplay'] = 0; 
			$productDesc = $this->general_model->cleanCustomers($this->general_model->convert_to_utf8_recursively($CustomerOrders[$x]['ProductDescription'])); 
			$json_array['ProductDescriptionShort'] = $productDesc;  
			$json_array['ProductDescription']=$productDesc;
			if($productDesc){
				if (strlen($json_array['ProductDescription']) > $limitStringOneStatProduct){
					$json_array['ProductDescriptionShortDisplay'] = 1; 
					$json_array['ProductDescriptionShort'] = substr($json_array['ProductDescription'], 0, $limitStringOneStatProduct);
				} 
			}


			//Job Desc
			$json_array['JobDescriptionShortDisplay'] = 0; 
			$jobDesc = $this->general_model->cleanCustomers($this->general_model->convert_to_utf8_recursively($CustomerOrders[$x]['JobDescription']));
			$json_array['JobDescriptionShort'] = ucfirst(strtolower($jobDesc));
			$json_array['JobDescription']= ucfirst(strtolower($jobDesc)); 
			if($jobDesc){
				if (strlen($json_array['JobDescription']) > $limitStringTwo){
					$json_array['JobDescriptionShortDisplay'] = 1; 
					$json_array['JobDescriptionShort'] = substr(ucfirst(strtolower($json_array['JobDescription'])), 0, $limitStringTwo);
				} 
			}


			$json_array['DecorationProcess']=$this->general_model->convert_to_utf8_recursively($CustomerOrders[$x]['DecorationProcess']); 
			 
			$json_array['Quantity']= $this->general_model->convert_to_utf8_recursively(intval($CustomerOrders[$x]['Quantity'])); 
			$json_array['OrderValue']=  $this->general_model->convert_to_utf8_recursively(round($CustomerOrders[$x]['OrderValue'], 4));

			 
			
			
			if($CustomerOrders[$x]['OrderDate']){ 
				 $OrderDate  =str_replace(":","-",$this->general_model->convert_to_utf8_recursively($CustomerOrders[$x]['OrderDate']));
				 $json_array['OrderDate'] = $OrderDate;
				/* $json_array['OrderDateParse'] = strtotime($OrderDate); */
				 $OrderDateArray = explode("-", $OrderDate);
				 $day = $OrderDateArray[0];
				 $month = $OrderDateArray[1];
				 $year = $OrderDateArray[2];
				 $json_array['OrderDateParse'] = $year. "-" .$month. "-" .$day;

			}else{
				$json_array['OrderDate']= null; 
			}
			


 

		   if($CustomerOrders[$x]['ShipDate']){ 
				$ShipDate  =str_replace(":","-",$this->general_model->convert_to_utf8_recursively($CustomerOrders[$x]['ShipDate']));
				$json_array['ShipDate'] = $ShipDate;
				/* $json_array['ShipDateParse'] = strtotime($OrderDate); */
				$ShipDateArray = explode("-", $ShipDate);
				$day = $ShipDateArray[0];
				$month = $ShipDateArray[1];
				$year = $ShipDateArray[2];
				$json_array['ShipDateParse'] = $year. "-" .$month. "-" .$day;
		   }else{
				$json_array['ShipDate'] = null; 
		   }
		   
			$json_array['FreightInstructions']=$this->general_model->cleanCustomers($this->general_model->convert_to_utf8_recursively($CustomerOrders[$x]['FreightInstructions'])); 

			$json_array['EmailContactShortDisplay'] = 0; 
			$emailAddress = $this->general_model->convert_to_utf8_recursively($CustomerOrders[$x]['EmailContact']);
			$json_array['EmailContactShort'] = $emailAddress;
			$json_array['EmailContact']= $emailAddress; 
			if($CustomerOrders[$x]['EmailContact']){
				if (strlen($json_array['EmailContact']) > $limitStringOne){
					$json_array['EmailContactShortDisplay'] = 1; 
					$json_array['EmailContactShort'] = substr(strtolower($json_array['EmailContact']), 0, $limitStringTwo);
				}
			}
 

			$json_array['ShipAddress1']=$this->general_model->cleanCustomers($this->general_model->convert_to_utf8_recursively($CustomerOrders[$x]['ShipAddress1'])); 
			$json_array['ShipAddress2']=$this->general_model->cleanCustomers($this->general_model->convert_to_utf8_recursively($CustomerOrders[$x]['ShipAddress2'])); 
			$json_array['ShipAddress3']=$this->general_model->cleanCustomers($this->general_model->convert_to_utf8_recursively($CustomerOrders[$x]['ShipAddress3'])); 
			$json_array['ShipAddress4']=$this->general_model->cleanCustomers($this->general_model->convert_to_utf8_recursively($CustomerOrders[$x]['ShipAddress4'])); 
			$json_array['ShipAddress5']=$this->general_model->cleanCustomers($this->general_model->convert_to_utf8_recursively($CustomerOrders[$x]['ShipAddress5'])); 
			$json_array['FreightTracking']=$this->general_model->cleanCustomers($this->general_model->convert_to_utf8_recursively($CustomerOrders[$x]['FreightTracking']));  

			$json_array['HasInvoice']=$CustomerOrders[$x]['HasInvoice']; 
			$json_array['HasPhoto']=$CustomerOrders[$x]['HasPhoto']; 
			$json_array['HasProof']=$CustomerOrders[$x]['HasProof']; 
			$json_array['OrderType']=$CustomerOrders[$x]['OrderType']; 

			/* $json_array['OrderRepeatStatus'] = 0;
			if($CustomerOrders[$x]['OrderType'] == 'FG' || $CustomerOrders[$x]['OrderType'] =='IN'){
				$resultRepeat=$this->dashboard_model->checkOrderRepeat($CustomerOrders[$x]['SalesOrderNumber'], 1);
				$json_array['OrderRepeatStatus'] = $resultRepeat; 
			}  */

			array_push($json_data, $json_array);
			
			 /*
			foreach($json_array as $key=>$value){
					if (preg_match('/[\'^âÂ�£$%*()}{#~?><>,–|=_+¬]/', $value))
					{
							echo $x. ": " .$key. " => " .$value. " &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ";
					} 
			}  */
						 
					 
		}
		
		$resultOrdersJson = json_encode($json_data,JSON_PRETTY_PRINT); 
		//echo "<pre>";
		//print_r($resultOrdersJson);
		//echo "</pre>";
		
		//echo json_last_error();
		/*
		switch (json_last_error()) {
			case JSON_ERROR_NONE:
				
			break;
			case JSON_ERROR_DEPTH:
				echo ' - Maximum stack depth exceeded';
			break;
			case JSON_ERROR_STATE_MISMATCH:
				echo ' - Underflow or the modes mismatch';
			break;
			case JSON_ERROR_CTRL_CHAR:
				echo ' - Unexpected control character found';
			break;
			case JSON_ERROR_SYNTAX:
				echo ' - Syntax error, malformed JSON';
			break;
			case JSON_ERROR_UTF8:
				echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
			break;
			default:
				echo ' - Unknown error';
			break; 
		} */

		
		 
 
?>


<script> 

$( document ).ready(function() {
	//$( "#appendThisToCount" ).appendTo( "#recordCount" );
    //$("#searchRow").appendTo("recordCountx");
});

tgpApp.filter('startFrom', function () {
	return function (input, start) {
		if (input) {
			start = +start;
			return input.slice(start);
		}
		return [];
	};
});
 

 
tgpApp.controller("customerCtrl",function($scope, $http, $timeout, $filter){
	 
    $scope.query = {}
	$scope.queryBy = '$'
	$scope.filter = {};
	
	//Decoration	
	$scope.decorationIncludes = []; 
	$scope.decorationIncludesFound = false; 
	$scope.checkboxes = [];
	$scope.selectAll = true;
	$scope.unselectAll = false;

	//Status
	$scope.statusIncludes = []; 
	$scope.checkboxesStatus = [];
	$scope.statusIncludesFound = false; 	
	$scope.selectAllStat = true;
	$scope.unselectAllStat = false;

	//Ordering
	$scope.orderByField = 'StatusNumber';
	$scope.reverseSort = false; 
	$scope.customers = <?php echo $resultOrdersJson; ?>; 
	$scope.accordionOpen = false;
	$scope.totalDisplayed = 10;	
	$scope.queryQ = {}
	var _timeout;
	$scope.loading = false;
	$scope.countShow = false;
	$scope.thisOrderDate="2010-01-01";
	$scope.thisShipDate="2032-01-01";
	$scope.queryQ.OrderDateTextbox = "";
	$scope.queryQ.ShipDateTextbox = "";
	$scope.clearfilter = false;
	$scope.formOrderRepeat = {};
	$scope.repeatForm = true;
 
 
	$scope.maxSizeValue = 0;
	$scope.currentPage = 1;
	$scope.totalItems = $scope.customers.length;
	$scope.entryLimit = <?=$defaultDisplay?>; // items per page
	$scope.noOfPages = Math.ceil($scope.totalItems / $scope.entryLimit);  
	$scope.searchLimit = <?=$searchLimit?>;
 
 
	 $scope.displayValue = false;
	 $scope.podYes = false;
	 $scope.podImages = "";

	 /* 
	 *
	 * 
	 * This two table here loop with different filters 
	 * One has pagination the other has not
	 * 
	 * 
	 */
	
	 $scope.tableOne = true;
	 $scope.tableTwo = false;
  
 	
		
  //Decoration
$scope.decorationsCheckBoxes = {
	0: "Colour Flex Transfer",
	1: "Debossing", 
	2: "Digital",  
	3: "Embroidery", 
	4: "Engraving", 
	5: "Multiple Process", 
	6: "Indent", 
	7: "Mel Production",
	8: "Pad Print", 
	9: "Resin Coated Finish", 
	10: "Rotary Digital", 
	11: "Screen Print",  
	12: "Sublimation", 
	13: "Unprinted", 
	14: "All Branded Orders"   
}

$scope.includeDecorationAuto = function(deco) { 
	var i = $.inArray(deco, $scope.decorationIncludes); 
	$scope.decorationIncludes.push(deco);
	$scope.decorationIncludesDisplay = $scope.decorationIncludes.join("/");  
}
    
 

 //Search
 $scope.timeoutChange = function(){ 
	 
	 
	 /* 
	 *
	 * 
	 * This two table here loop with different filters 
	 * One has pagination the other has not
	 * 
	 * 
	 */
	$scope.tableOne = false;
	$scope.tableTwo = true;


	 
 	 
	$scope.loading = true;  
	$scope.decorationIncludes =[]; 
	$scope.calendarOrderDate(true);  
 
	 
	if(_timeout) { // if there is already a timeout in process cancel it
		$timeout.cancel(_timeout);
	}
	_timeout = $timeout(function() { 
		$scope.loading = false;
		$scope.countShow = true;

	   //var check = angular.element('.parentDashboard').hasClass('displaynone');
	  
	   

		if($scope.queryQ.checkboxesStatusQ == null){
			$scope.queryQ.checkboxesStatusQ = undefined;
		}
		
		if($scope.queryQ.checkboxesDecorationsQ == null){
			$scope.queryQ.checkboxesDecorationsQ = undefined;
		}

	 
		//console.log(" Timeout = " + $scope.queryQ.OrderDate + " / " + $scope.queryQ.ShipDate);

		/* Order and ship */
		if($scope.queryQ.OrderDate && !$scope.queryQ.ShipDate){ 
			$scope.queryQ.OrderDate = convert($scope.queryQ.OrderDate); 
			//Textbox
			$scope.queryQ.OrderDateTextbox =  convert($scope.queryQ.OrderDate); 
			 //console.log("Order only");
		} 
		if($scope.queryQ.ShipDate && !$scope.queryQ.OrderDate){
			$scope.queryQ.ShipDate =   convert($scope.queryQ.ShipDate); 
			//Textbox
			$scope.queryQ.ShipDateTextbox = convert($scope.queryQ.ShipDate); 
			 //console.log("Ship only");
		} 

		if($scope.queryQ.checkboxesDecorationsQ == "All Branded Orders"){ 
			for(var i = 0; i < Object.keys($scope.decorationsCheckBoxes).length; i++){
				if(i != 13 && i != 14){ 
					$scope.includeDecorationAuto($scope.decorationsCheckBoxes[i]);  
				} 
			}  

			$scope.query = {"OrderDateParse": $scope.queryQ.OrderDate, "ShipDateParse": $scope.queryQ.ShipDate,  "Status": $scope.queryQ.checkboxesStatusQ,  "PON": $scope.queryQ.PONQ, "SalesOrder" : $scope.queryQ.SalesOrderQ, "ProductDescription": $scope.queryQ.ProductDescriptionQ, "JobDescription" : $scope.queryQ.JobDescriptionQ, "Quantity": $scope.queryQ.QuantityQ, "OrderValue": $scope.queryQ.OrderValueQ, "EmailContact": $scope.queryQ.EmailContactQ, "Invoice": $scope.queryQ.InvoiceQ }
			//console.log("One stats"); 
			 
		}else if($scope.queryQ.OrderDate && $scope.queryQ.ShipDate){
			//console.log("Order and Ship "); 
			$scope.queryQ.OrderDate =  convert($scope.queryQ.OrderDate); 
			$scope.queryQ.ShipDate =  convert($scope.queryQ.ShipDate);  

			//Textboxes
			$scope.queryQ.OrderDateTextbox =  convert($scope.queryQ.OrderDate); 
			$scope.queryQ.ShipDateTextbox = convert($scope.queryQ.ShipDate); 

			 //console.log("Two stat");

			$scope.query = {"OrderDateParse": $scope.queryQ.OrderDate, "ShipDateParse": $scope.queryQ.ShipDate,  "Status": $scope.queryQ.checkboxesStatusQ, "DecorationProcess": $scope.queryQ.checkboxesDecorationsQ, "PON": $scope.queryQ.PONQ, "SalesOrder" : $scope.queryQ.SalesOrderQ, "ProductDescription": $scope.queryQ.ProductDescriptionQ, "JobDescription" : $scope.queryQ.JobDescriptionQ, "Quantity": $scope.queryQ.QuantityQ, "OrderValue": $scope.queryQ.OrderValueQ, "EmailContact": $scope.queryQ.EmailContactQ, "Invoice": $scope.queryQ.InvoiceQ }
		} else{ 

			// console.log(" All in all");
			$scope.query = {"OrderDateParse": $scope.queryQ.OrderDate, "ShipDateParse": $scope.queryQ.ShipDate,  "Status": $scope.queryQ.checkboxesStatusQ, "DecorationProcess": $scope.queryQ.checkboxesDecorationsQ, "PON": $scope.queryQ.PONQ, "SalesOrder" : $scope.queryQ.SalesOrderQ, "ProductDescription": $scope.queryQ.ProductDescriptionQ, "JobDescription" : $scope.queryQ.JobDescriptionQ, "Quantity": $scope.queryQ.QuantityQ, "OrderValue": $scope.queryQ.OrderValueQ, "EmailContact": $scope.queryQ.EmailContactQ, "Invoice": $scope.queryQ.InvoiceQ }
			//console.log("Three stats"); 
		} 

		 //console.log($scope.query);
		$scope.checkFilter($scope.query, $scope.thisOrderDate, $scope.thisShipDate); 

	_timeout = null;
	}, 200); 

}


$scope.checkFilter = function(query, order, ship){ 

	
 //console.log($scope.customers.length);
	var found = 0;

	if($scope.decorationIncludes.length > 0){
		found = 1;
	}
	 
	if(order != "2010-01-01" || ship != "2032-01-01"){
		found = 1;
	}

	for (var key in query) { 
	   //console.log(query[key]); 
	   if(query[key]){
		   found = 1;
	   }
	}
	
	if(found == 1){
		$scope.clearfilter = true;
		//console.log("FOUND = 1"); 
  
	}else{
		$scope.clearfilter = false;
		//console.log("FOUND = 2");

		//Reset tables
		$scope.tableOne = true;
	 	$scope.tableTwo = false;
	}
}

 

$scope.clearAllFilter = function(){
	

	$scope.loading = true; 
	$scope.query = {}
	$scope.query = {}
	$scope.filter = {};
	$scope.queryQ = {}
	$scope.decorationIncludes =[]; 


	$scope.thisOrderDate="2010-01-01";
	$scope.thisShipDate="2032-01-01";
	$scope.queryQ.OrderDateTextbox = "";
	$scope.queryQ.ShipDateTextbox = "";
	$scope.clearfilter = false;


	if(_timeout) { // if there is already a timeout in process cancel it
		$timeout.cancel(_timeout);
	}
	_timeout = $timeout(function() { 
		$scope.loading = false; 

	_timeout = null;
	}, 200); 

	
}



$scope.inputChange = function(){ 

	//console.log($scope.queryQ.OrderDateTextbox + " / " + $scope.queryQ.ShipDateTextbox);

	if(!$scope.queryQ.OrderDateTextbox && $scope.queryQ.ShipDateTextbox){
		//console.log("Clear order");
		$scope.queryQ.OrderDate = undefined;
	}
	if($scope.queryQ.OrderDateTextbox && !$scope.queryQ.ShipDateTextbox){
		//console.log("Clear ship");
		$scope.queryQ.ShipDate = undefined;
	}

	if(!$scope.queryQ.OrderDateTextbox && !$scope.queryQ.ShipDateTextbox){
		//console.log("Clear both");

		$scope.queryQ.OrderDate = undefined;
		$scope.queryQ.ShipDate = undefined;

		$scope.thisOrderDate="2010-01-01";
		$scope.thisShipDate="2032-01-01";
	}
	$scope.timeoutChange();
	 
}
 


$scope.selectAllDecorations = function(){ 
	var x = 0;
	$scope.selectAll = false;
	$scope.unselectAll = true;
	angular.forEach($scope.decorationsCheckBoxes, function (item) { 
		
		$scope.includeDecorations(item);
		$scope.checkboxes[x] = true;
		x++;
	});
	 //   
}

$scope.unselectAllDecorations = function(){ 
	var x = 0;
	$scope.selectAll = true;
	$scope.unselectAll = false;
	angular.forEach($scope.decorationsCheckBoxes, function (item) { 
		
		$scope.checkboxes[x] = false; 
		$scope.decorationIncludes.splice(item, 1); 
		$scope.decorationIncludesFound = false; 
		x++;
	});
	 //   
}



$scope.includeDecorations = function(deco) {
	 
	var i = $.inArray(deco, $scope.decorationIncludes);
	if(i == 0){
			$scope.loading = true;
	}
	if(_timeout) { // if there is already a timeout in process cancel it
			$timeout.cancel(_timeout);
	}
	_timeout = $timeout(function() { 
			 
		if (i > -1) {
			$scope.decorationIncludes.splice(i, 1); 
			if($scope.decorationIncludes.length == 0){
				$scope.decorationIncludesFound = false; 
			}  
        } else {
			$scope.decorationIncludes.push(deco);
			$scope.decorationIncludesFound = true; 
		}
		$scope.loading = false;
		$scope.decorationIncludesDisplay = $scope.decorationIncludes.join("/");

		//console.log($scope.decorationIncludesDisplay);
			 
		_timeout = null;
	}, 100);    
       
}
    
$scope.decorationFilter = function(decos) {
        if ($scope.decorationIncludes.length > 0) {  
			if ($.inArray(decos.DecorationProcess, $scope.decorationIncludes) < 0)  
                return;
		} 
		 //console.log(decos);
        return decos;
}

 
//Status
$scope.statusCheckBoxes = { 
	0: "Waiting on Artwork", 
	1: "Proofed",
	2: "Waiting on Payment", 
	3: "In Production",
	4: "Production Complete", 
	5: "On Hold", 
	6: "Despatch Hold", 
	7: "Invoiced", 
	8: "Cancelled",
	
}
 

$scope.selectAllStatus = function(){ 
	var x = 0;
	$scope.selectAllStat = false;
	$scope.unselectAllStat = true;
	angular.forEach($scope.statusCheckBoxes, function (item) {  
		$scope.includeStatus(item);
		$scope.checkboxesStatus[x] = true;
		x++;
	});
	 //   
}

$scope.unselectAllStatus = function(){ 
	var x = 0;
	$scope.selectAllStat = true;
	$scope.unselectAllStat = false;
	angular.forEach($scope.statusCheckBoxes, function (item) { 
		$scope.checkboxesStatus[x] = false; 
		$scope.statusIncludes.splice(item, 1); 
		$scope.statusIncludesFound = false; 
		x++;
	});
	 //   
}

$scope.includeStatus = function(decostat) {
	 
		var i = $.inArray(decostat, $scope.statusIncludes);
		 
		if(i == 0){
			$scope.loading = true;
		}
		if(_timeout) { // if there is already a timeout in process cancel it
			$timeout.cancel(_timeout);
		}
		_timeout = $timeout(function() { 
			 
			if (i > -1) {
				$scope.statusIncludes.splice(i, 1);
				if($scope.statusIncludes.length == 0){
					$scope.statusIncludesFound = false; 
				}  
			} else {
				$scope.statusIncludes.push(decostat); 
				$scope.statusIncludesFound = true; 
			}
			$scope.loading = false;
			$scope.statusIncludesDisplay = $scope.statusIncludes.join("/");
			 
		_timeout = null;
		}, 100); 

        
        
}
    
$scope.statusNewFilter = function(decost) { 
	
        if ($scope.statusIncludes.length > 0) {   
			if ($.inArray(decost.StatusName, $scope.statusIncludes) < 0)  
                return;
		} 
        return decost;
}
// End status


$scope.getPhoto = function(jobnumber){
		//console.log(jobnumber);
		$scope.baseImg = false;

		$http({
				   method: "post",
				   url:  "<?php echo base_url();?>Angular/Customer",
				   data: {    option: 1, jobnumber: jobnumber } 
				   
		   }).then(function successCallback(response) { 
				 
				if(response.data){
					$scope.baseImg = '<img src="data:image/gif;base64, ' +  response.data + ' " class="img-fluid"   />'; 
				} 

		   }, function errorCallback(response) {
			   console.log("Error retrieving the customer photo");
		});  
}


	//Pagination

	//$scope.displayItems = $scope.customers.slice(0, <?//php=$pagination?>);
/*
	$scope.pageChanged = function() {
	  var startPos = ($scope.page - 1) * <?//=$pagination?>;  
	}; */

	$scope.checkOrderRow = function(order, status){
		console.log(order + " / " + status);
 
	}

/* date picker */
 
	
	
	$scope.ThisDate = {}
	$scope.calendarOpen = false;
	$scope.calendarOpenShip = false;
	$scope.tempdates = {}   
	$scope.maxDate = new Date();

		$scope.closeCalendar = function(opt1, opt2){ 
			$scope.calendarOrderDate(true);  
			$scope.calendarShipDate(true);
		}
 	 
	$scope.changeOrderDate = function(date){
		
		if(date == null || date == ""){ 
			$scope.thisOrderDate="2010-01-01"; 
			$scope.calendarOrderDate(true); 

			 
			$scope.loading = true; 
			if(_timeout) {  
				$timeout.cancel(_timeout);
			}
			_timeout = $timeout(function() {  
				$scope.loading = false; 
			_timeout = null;
			}, 100);  

		}else{ 
			$scope.selectDateOrder(date);
		}

		$scope.timeoutChange();
	} 

	$scope.selectDateOrder = function(dates){ 
		$scope.calendarOrderDate(true);  
		$scope.queryQ.OrderDate = undefined; 

		if(convert(dates) == "NaN-aN-aN"){
			$scope.tempdates.thisOrderDateTemp = "";
			$scope.thisOrderDate =  "2010-01-01";  
			
		}else{
			$scope.tempdates.thisOrderDateTemp = convert(dates); 
			$scope.thisOrderDate =  convert(dates); 
		}
		 

			/* if(convert(dates) == "NaN-aN-aN"){
				$scope.tempdates.thisOrderDateTemp = "";
				$scope.thisOrderDate =  "2010-01-01";   
				
			}else{
				
				if(!$scope.tempdates.thisShipDateTemp){

					console.log("NOOOOO");

					//Reset
					$scope.thisOrderDate =  $scope.thisOrderDate;    
					var date = convert(dates);   
					//Added this on $scope.query above *******************
					$scope.queryQ.OrderDate = date;


				}else{
					console.log("YESSS"); 

					//Reset *******************
					$scope.queryQ.OrderDate = undefined; 
					$scope.thisOrderDate =  convert(dates); 
				}

				$scope.timeoutChange();

				$scope.tempdates.thisOrderDateTemp = convert(dates); 
				console.log($scope.query);
			} */


		 
		 
	}

	

	$scope.calendarOrderDate = function(opt){  
		
		$scope.calendarOpenShip = false;
		if(opt == false){
			$scope.calendarOpen = true;
		}else{
			$scope.calendarOpen = false;
		}  
	}

	//Ship

	$scope.changeShipDate = function(date){
		
		if(date == null || date == ""){ 
			$scope.thisShipDate="2032-01-01";
			$scope.calendarOrderDate(true); 

			$scope.loading = true; 
			if(_timeout) {  
				$timeout.cancel(_timeout);
			}
			_timeout = $timeout(function() {  
				$scope.loading = false; 
			_timeout = null;
			}, 100);  

		}else{
			$scope.selectDateShip(date);
		}
	} 

	$scope.selectDateShip = function(dates){
		$scope.calendarShipDate(true);   
		$scope.queryQ.OrderDate = undefined;  

		if(convert(dates) == "NaN-aN-aN"){
			$scope.tempdates.thisShipDateTemp = "";
			$scope.thisShipDate="2032-01-01";
		}else{
			$scope.tempdates.thisShipDateTemp = convert(dates); 
			$scope.thisShipDate =  convert(dates);  
		} 
	}

	$scope.calendarShipDate = function(opt){  
		$scope.calendarOpen = false;
		if(opt == false){
			$scope.calendarOpenShip = true;
		}else{
			$scope.calendarOpenShip = false;
		}  
	}

	
	//Proof og image delivery signature
	$scope.podImage = function(val, signatory, delivered){ 
		$scope.podImages = "";
		$scope.sign = "";
		$scope.deliveredDate = "";
		if(val){ 
			$scope.podYes = true;
			$scope.sign = signatory;
			$scope.deliveredDate = delivered; 
			$scope.podImages = '<img src="data:image/gif;base64, ' +  val  + ' " class="img-fluid"  style="max-height:75px"  />'; 
		}  
	} 

	//Orderlines
	$scope.getOrderLines = function(ind, orderNum){
		
	   
	   var myEl = angular.element('#' + ind + 'customerRow'); 

	   if(myEl.hasClass('active-accordion')){
			$scope.closePopup();
	   }else{
            
			$scope.closePopup();

			  
			var elementOpen = angular.element('.'+ ind + 'customerRow'); 
				elementOpen.css('display', 'block');   
			
			myEl.addClass('active-accordion');  

			$scope.orderLines = "";
			//$scope.OrderTable ="";
			$scope.userId = '<?=$siteLogcheck['userDatas'][0]->userID?>';
			$scope.compAccount = '<?=$siteLogcheck['userDatas'][0]->CustomerNumber?>';
			$http({
					method: "get",
					url:  "<?php echo base_url();?>Angular/Customer/" + 2 + "/" + orderNum,
					data: {}
					//data: {    option: 2, orderNum: orderNum, userID: $scope.userId, comp: $scope.compAccount } 
					
			}).then(function successCallback(response) { 

					//$scope.loader(ind);
					 
					 // console.log( response.data); 
					$scope.orderLines = "";

					$scope.datas = response.data.OrderLines;  

					$scope.Dispatched = response.data.Dispatched;
					$scope.LastProofed = response.data.LastProofed;
					$scope.OrderApproved = response.data.OrderApproved;
					$scope.OrderReceived = response.data.OrderReceived;
					$scope.OrderTable = response.data.OrderTable;
					$scope.Delivered = response.data.Delivered;
					$scope.POD = response.data.POD;
					$scope.Signatory = response.data.Signatory;
				     

					$scope.tableRow = "";
					$scope.table = ' <table class="table text-left orderlines" ng-if="orderLines">';

					$scope.thead = '<thead><tr><th scope="col"> Code</th><th scope="col">Description</th><th scope="col">Quantity</th><th scope="col"><span class="priceheading">Price $</span></th><th scope="col">Gross Amount $</th></tr></thead>';
					$scope.tbody = '<tbody>  ';

					$scope.tbodyClose = '</tbody>';	     
					$scope.tableClose = '</table>';

					/* if($scope.datas.length > 0){  
						for(var i = 0; i < $scope.datas.length; i++){
							$scope.tableRow += "<tr><td> " + $scope.datas[i].StockCode + " </td><td> " + $scope.datas[i].StockDescription + " </td><td> <span class='qtyorder'>" + Number($scope.datas[i].Quantity) + "</span> </td><td> <span class='priceorder'>" + $scope.formatToCurrency($scope.datas[i].UnitPrice) + "</span> </td> <td> <span class='grossorder'>" + $scope.formatToCurrency($scope.datas[i].GrossAmount) + "</span> </td></tr>";
						}  
						$scope.orderLines = $scope.table + $scope.thead + $scope.tbody + $scope.tableRow + $scope.tbodyClose + $scope.tableClose;
					}else{
						if($scope.datas.StockCode != ""){
							$scope.tableRow += "<tr><td> " + $scope.datas.StockCode + " </td><td> " + $scope.datas.StockDescription + " </td><td> <span class='qtyorder'>" + Number($scope.datas.Quantity) + "</span> </td><td> <span class='priceorder'>" + $scope.formatToCurrency($scope.datas.UnitPrice) + "</span> </td> <td> <span class='grossorder'>" + $scope.formatToCurrency($scope.datas.GrossAmount) + "</span> </td></tr>";
							$scope.orderLines = $scope.table + $scope.thead + $scope.tbody + $scope.tableRow + $scope.tbodyClose + $scope.tableClose;
						}else{
							$scope.orderLines = "none";
						}
						
					} */

					 

					if($scope.OrderTable){
						$scope.orderLines = $scope.OrderTable;
					}else{
						$scope.orderLines = "none";
					}


					
					//Get the Order repeat Record
					 
					//Get the Order repeat Record 



					//console.log( orderNum);
					
			}, function errorCallback(response) {
				console.log("Error retrieving the customer orderlines");
			});   
	   } 
		

	}

	$scope.formatToCurrency = function(amount){  
		return Intl.NumberFormat('en-NZ', {style: 'currency', currency: 'NZD' }).format(amount).replace(/\$+/g, ''); 
	}

	$scope.checkTheOrderlinesCount = function(orderNum){

			$scope.userId = '<?=$siteLogcheck['userDatas'][0]->userID?>';
			$scope.compAccount = '<?=$siteLogcheck['userDatas'][0]->CustomerNumber?>';

			$http({
					method: "post",
					url:  "<?php echo base_url();?>Angular/Customer",
					data: {    option: 3, orderNum: orderNum, userID: $scope.userId, comp: $scope.compAccount } 
					
			}).then(function successCallback(response) {  
					 console.log( response.data);
					
			}, function errorCallback(response) {
				console.log("Error retrieving the   orderlines count");
			});   
	}

	$scope.closePopup = function(){
		var myEl = angular.element('.parentDashboard'); 
			myEl.removeClass('active-accordion');


		var element = angular.element('.popcustomer'); 
			element.css('display', 'none'); 
	}

	$scope.loadMore = function () {
		$scope.totalDisplayed += 20;  
	};

	function convert(str) {
		var date = new Date(str),
			mnth = ("0" + (date.getMonth() + 1)).slice(-2),
			day = ("0" + date.getDate()).slice(-2);
		return [date.getFullYear(), mnth, day  ].join("-");
	}

/* date picker */

$scope.checkNumber = function(opt, val){
	 
	if(opt == 1 ){
		var checked = $scope.checkPattern(val); 
		$scope.queryQ.QuantityQ = checked;
	}

	if(opt == 2){
		var checked = $scope.checkPattern(val); 
		$scope.queryQ.OrderValueQ = checked;
	}

	if(opt == 3){
		var checked = $scope.checkPattern(val); 
		$scope.queryQ.InvoiceQ = checked;
	}
	 
	   
   
}

$scope.checkPattern = function(val){
	var numberPattern = /^[0-9]+$/;
	var ans = val.match(numberPattern);
	if(ans == null){
		return '';
	}else{
		return val;
	}
}

$scope.numberOnly = function(val){
	//console.log(val);
	if(val <= 0){
		$scope.formOrderRepeat.Quantity = 1;
	}
}

$scope.loader = function(ind){
	var i = 0;

	var prog = angular.element('.'+ ind + 'myProgress'); 
	var myEl = angular.element('#' + ind + 'customerRow');   
	var elementOpen = angular.element('.'+ ind + 'customerRow'); 

	prog.css('display', 'block');  
	 
	if (i == 0) {
			i = 1;
			var elem = document.getElementById(ind + "loadingBar");
			var width = 10;
			var id = setInterval(frame, 10); 
			
			function frame() {
				if (width >= 100) {
					clearInterval(id);
					i = 0;
					 
					$scope.closePopup();
					
					elementOpen.css('display', 'block');  
					myEl.addClass('active-accordion');   
					prog.css('display', 'none');   

				} else {
					width++;
					elem.style.width = width + "%";
					//elem.innerHTML = width + "%";   
					
				} 
				
			}
	}
}

$scope.repeatOrder = function(ind, customer){
	 console.log(customer);
	$scope.resetRepeatOrder();
	$scope.formOrderRepeat.SalesOrder = customer.SalesOrder;
	$scope.formOrderRepeat.Quantity = customer.Quantity;
	//$scope.formOrderRepeat.PON = customer.PON;
	$scope.formOrderRepeat.Index = ind;
	$scope.formOrderRepeat.DecorationProcess = customer.DecorationProcess;
	$scope.formOrderRepeat.ProductDescription = customer.ProductDescription;
	<?php 
		$emailDashboard = "";
		if($siteLogcheck['userDatas'][0]->userEmail){
			$emailDashboard = $siteLogcheck['userDatas'][0]->userEmail;
		}
	?>
	$scope.formOrderRepeat.email = '<?=$emailDashboard?>';
	

	$scope.emailFormat = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

	//console.log("Address = " + customer.ShipAddress1 + "/" + customer.ShipAddress2 + "/" + customer.ShipAddress3 + "/" + customer.ShipAddress4 + "/" + customer.ShipAddress5);

	var address1= "", address2= "", address3= "", address4= "", address5 = "";

	if(customer.ShipAddress1 && customer.ShipAddress1 != ' ' && customer.ShipAddress1 != '&nbsp;'){
		address1 = customer.ShipAddress1 + " ";
	}
	if(customer.ShipAddress2 && customer.ShipAddress2 != ' ' && customer.ShipAddress2 != '&nbsp;'){
		address2 = customer.ShipAddress2 + " ";
	}
	if(customer.ShipAddress3 && customer.ShipAddress3 != ' ' && customer.ShipAddress3 != '&nbsp;'){
		address3 = customer.ShipAddress3 + " ";
	}
	if(customer.ShipAddress4 && customer.ShipAddress4 != ' ' && customer.ShipAddress4 != '&nbsp;'){
		address4 = customer.ShipAddress4 + " ";
	}
	if(customer.ShipAddress5 && customer.ShipAddress5 != ' ' && customer.ShipAddress5 != '&nbsp;'){
		address5 = customer.ShipAddress5 + " ";
	}

	$scope.formOrderRepeat.Address = address1 + address2 + address3 + address4 + address5;
	//console.log("YES REPEAT " + $scope.formOrderRepeat.Address);
}

$scope.resetRepeatOrder = function(){
	$scope.repeatForm = true;
	$scope.formOrderRepeat.date = ""; 
	$scope.formOrderRepeat.Note = ""; 
}

$scope.submitRepeatOrder=function(formOrderRepeat){
	 console.log($scope.formOrderRepeat);

	//Added variable 
	$scope.formOrderRepeat.userID = '<?=$siteLogcheck['userDatas'][0]->userID?>';
	$scope.formOrderRepeat.DistributorName = '<?=$this->general_model->cleanCustomers($siteLogcheck['userDatas'][0]->CustomerName)?>'; 
			$http({
					method: "post",
					url:  "<?php echo base_url();?>Angular/Customer",
					data: {    option: 4, data: $scope.formOrderRepeat } 
					
			}).then(function successCallback(response) {  

					console.log( response.data); 

					if(response.data == '1'){
						  
						//Make twice
						/* for(var x = 0; x < 2; x++){
							$scope.getOrderLines($scope.formOrderRepeat.Index, $scope.formOrderRepeat.SalesOrder);
						} */

						$timeout(function() { 
							$scope.repeatForm = false;
						}, 400);
					}

					if(response.data == '0'){
						console.log("Cannot send to email");
					} 
					
			}, function errorCallback(response) {
				console.log("Error repeating the order");
			});    
}
 

$scope.showRepeatOrder = function(salesorder, showRepeats){
	console.log(salesorder);
	console.log(showRepeats);
	$scope.showRepeatsData = showRepeats[0];
}

$scope.hideAccordion = function(){
	$scope.closePopup();
}


}); // end controller
 
 
</script>
