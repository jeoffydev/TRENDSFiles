<?php
	ini_set('default_socket_timeout', 4);
	date_default_timezone_set('Pacific/Auckland');
	error_reporting(0);
	$code = $_GET['code'];
	if(empty($code)) {
		$error = 1;
		die;
	} else {
		$error = 0;
	}
	$blurbText = "";
	$whoops = "no";
	$hitProduct = 0;
	
//-----------------------------------------------------------------------------------------------------------------------------------------------

function getMOnth($monthNum){ 
	$dateObj   = DateTime::createFromFormat('!m', $monthNum);
	$monthNames = $dateObj->format('F'); 
	return $monthNames;
}

function checkTotalRoundUpNew($tempTotal){

	if($tempTotal <= 100){
		//echo "Less or equal 100 <br />";
		$valRound =  $tempTotal;
	}
	if($tempTotal >= 100 && $tempTotal <= 1000){
		//echo "Greater 100/Less than 1k  <br />";
		$valRound =  roundUp($tempTotal, 10);
	}
	if($tempTotal >= 1000 && $tempTotal <= 5000){
		//echo "Greater 1000/Less than 5k  <br />";
		$valRound =  roundUp($tempTotal, 50);
	} 
	if($tempTotal >= 5000){
		//echo "Greater than 5k  <br />";
		$valRound =  roundUp($tempTotal, 100);
	} 
	return $valRound;  
}

function roundUp($totalFormat, $num){
	$roundTotal = floor($totalFormat / $num) * $num;
	return $roundTotal;
}
	
	function debug_to_console($data,$alert=0) {
		if($_SERVER['SERVER_NAME'] == "logosource.co.nz" || $_SERVER['SERVER_NAME'] == "www.logosource.co.nz"){
			if(is_array( $data )) {
				$output = "<script>console.log(\"Debug Objects: ".implode(',',$data)."\");</script>";
			} else {
				$output = "<script>console.log(\"Debug Objects: ".$data."\");</script>";
			}
			
			if($alert == 1) {
				$output .= "<script>alert('".$data."')</script>";
			}
			
			echo $output;
		}
	}
	
	function dbPuller($queryInput,$queryMode,$showOutput=1) {
		if($showOutput == 1){ debug_to_console( "queryInput: ".$queryInput);}
		$rnd1 = rand(1,5);
		do {
		  $rnd2 = rand(1,5);
		} while ($rnd1 == $rnd2);
		
		$queryTXT = str_replace(array("'", "\"", "&quot;","\n", "\t"), "", $queryInput);
		
		if($showOutput == 1){ debug_to_console( "queryTXT: ".$queryTXT);}
		
		$SQLHost = "localhost";
	
		$SQLNameRD = "trends_WebView".$rnd1;
		$SQLNameRDBackup = "trends_WebView".$rnd2;
		$SQLPwdRD = "JtmNbJ06yA";
		
		$SQLNameWR = "trends_WebWrite";
		$SQLPwdWR = "cwpTtvtC5VkA3kOVyFko";
		
		$SQLdb = "trends_collection";
		
		if($queryMode == 0) { //read mode
			$userUsed = "Main";
			if($showOutput == 1){ debug_to_console( "READ MODE, Main: ".$SQLNameRD.", Backup: ".$SQLNameRDBackup.", Used: ".$userUsed.", Query: ".$queryTXT);}
			
			$global_dbh = mysqli_connect($SQLHost, $SQLNameRD, $SQLPwdRD, $SQLdb, 3306);
			
			$queryOutput = mysqli_query( $global_dbh, $queryInput);
			
			if(!$queryOutput) {
				$global_dbh = mysqli_connect($SQLHost, $SQLNameRDBackup, $SQLPwdRD, $SQLdb, 3306);
				$queryOutput = mysqli_query( $global_dbh, $queryInput);
				$userUsed = "Backup";
			}
			//if($showOutput == 1){ debug_to_console( "Number of Rows returned: ".mysqli_num_rows($queryOutput));}
			
		} else { //write mode
			if($showOutput == 1){ debug_to_console( "WRITE MODE, Query: ".$queryTXT);}
			$global_dbh = mysqli_connect($SQLHost, $SQLNameWR, $SQLPwdWR, $SQLdb, 3306);
			$queryOutput = mysqli_query( $global_dbh, $queryInput);
			if($queryMode == 2) {
				$queryOutput = mysqli_insert_id($global_dbh);
				if($showOutput == 1){ debug_to_console( "New Primary key: ".$queryOutput);}
			}
		}
		
		if(!$queryOutput) {
			if($showOutput == 1){ debug_to_console("Error: ".mysqli_error($queryOutput));}
			echo "<h3>Please contact us for stock availability.<h3>";
			exit;	
		}
		
		//mysqli_close($global_dbh);
		//mysqli_close($global_dbh_Backup);
		
		return $queryOutput;
	}
//-----------------------------------------------------------------------------------------------------------------------------------------------
	
	$itemPricingType = dbPuller("SELECT Quantity1, Quantity2, Quantity3, Quantity4, Quantity5 FROM productsPricing WHERE Coode = ".$code." AND Currency LIKE 'NZD' AND PriceOrder='1'",0);
	if ($pricingTyper = mysqli_fetch_array($itemPricingType)) {
		$pb5 = $pricingTyper['Quantity5'];
		debug_to_console("pb5 ".$pb5);
	} else {
		if($pb5 == "") {
			$pb5 = 10000000000;
		} else {
			$whoops = "yes";
		}
	}
	
	$blurbFinder = dbPuller("SELECT StockComment, HitSKU FROM productsCurrent WHERE Code=".$code,0);
	while ($row = mysqli_fetch_array($blurbFinder)) {
		if ($row['StockComment'] != NULL ) {
			$blurbText = $row['StockComment']."<br /><br />";
		}
		if($row['HitSKU'] != "0") {
			$hitProduct = 1;
			$hitSKU = $row['HitSKU'];
		}
	}
	
	if($hitProduct != "0") {
		try {
			//$client = new SoapClient('http://ds.hitpromo.net/inventory', array("exceptions" => true, "connection_timeout"=>4));
			$client = new SoapClient('https://ppds.hitpromo.net/inventoryV2', array("exceptions" => true, "connection_timeout"=>4));
		} catch ( SoapFault $e ) { // Do NOT try and catch "Exception" here
			$blurbText = "Please contact your Account Manager for stock availability information.";
			$hitProduct = 0;
		}
		
		set_error_handler('handlePhpErrors');
		function handlePhpErrors($errno, $errmsg, $filename, $linenum, $vars) {
			if (stristr($errmsg, "SoapClient::SoapClient")) {
				 error_log($errmsg); // silently log error
				 $hitProduct = 0;
				 return; // skip error handling
			}
		}
		
		try {
			$params = array(
				"wsVersion" => '2.0.0',
				"id" => '790056',
				"password" => 'a20b62225690643668bcbd84d6f788ad',
				"productId" =>  $hitSKU,
			  ); 
			   
			$response = $client->getInventoryLevels($params);
			$arrayOne = json_decode(json_encode($response), True); 
			$arraytwo = $arrayOne['Inventory']['PartInventoryArray']['PartInventory'];
			
			
			if($arraytwo['partId']){
				$qtyFinal = $arraytwo['quantityAvailable']['Quantity']['value']; 
				$OneResult = array('color'=> $arraytwo['partColor'], 'quantity_available'=> $qtyFinal);
			}else{
				$countAPI = count($arraytwo) - 1;
				/* echo '<pre>';
				print_r($arrayOne['Inventory']['PartInventoryArray']['PartInventory']);
				echo '</pre>'; */ 
				
				for($i = 0; $i <= $countAPI; $i++){ 
					 $qtyFinal = $arraytwo[$i]['quantityAvailable']['Quantity']['value']; 
					 $MoreResults[] = array('color'=> $arraytwo[$i]['partColor'], 'quantity_available'=> $qtyFinal);
				}

			}
			 
			 
		} catch ( SoapFault $e ) { 
			$blurbText = "Please contact your Account Manager for stock availability information.";
			$hitProduct = 0;
		} 

		/* try {
			$hitStock = $client->getLevels('790056', 'a20b62225690643668bcbd84d6f788ad', $row['HitSKU']);
			$array = json_decode(json_encode($hitStock), True);
		} catch ( SoapFault $e ) { 
			$blurbText = "Please contact your Account Manager for stock availability information.";
			$hitProduct = 0;
		} */
	}
	debug_to_console("HitSKU: ".$hitSKU);
	 
	
	echo "<h3>".$blurbText."</h3>";
	if($hitProduct == 0) {	
		$resultExtra2 = dbPuller("SELECT * FROM productsStock WHERE Code=".$code." ORDER BY SortCode",0);
		$resultExtra3 = dbPuller("SELECT DateTimeValue FROM CustomFormData",0);
		
		if(mysqli_num_rows($resultExtra2) !=0) { ?>
		<table class="trendsnz1"  width="485" border="1" id="tableStyle">
			<thead>
				<tr>
					<th width="190" style='padding-left:5px;'>Item</th>
					<th width="110" style='padding-left:5px;'>Quantity</th>
					<th width="180" style='padding-left:5px;'>Next Shipment</th>
				</tr>
			</thead>
			<tbody>
				<? while ($rowX = mysqli_fetch_array($resultExtra2)) { 
					if($rowX['SortCode'] != "" && $rowX['SortCode'] != "0") { ?>  
					<tr>
						<td id="tableStyleName" style='padding-left:5px;'>
							<? echo $rowX['PartName']; ?>
						</td>
						<td id="tableStyleQuantity" style='padding-left:5px;'>
							<? 
								$QtyCurrent = $rowX['Quantity'];
								
								if($whoops == "no") {
									if($QtyCurrent >= $pb5) {
										echo number_format($pb5)."+";
									} else {
										echo number_format($QtyCurrent);
									}
								}
							?>
						</td>
						<td id="tableStyleDate" style='padding-left:5px;'>
							<? 
								if($rowX['DueDate'] == '1900-01-01 00:00:00') {
									echo "-";
								} else {
									/* $CleanedDate = rtrim($rowX['DueDate']);
									$CleanedDate2 = explode(" ", $CleanedDate);
									$CleanedDate3 = explode("-", $CleanedDate2[0]);
									$timestamp = mktime(0, 0, 0, $CleanedDate3[1], 1, 2005);
									$CleanedDate3[1] = date("M", $timestamp);
									$curYear = date('Y'); 
									if($CleanedDate3[2] < 10) {
										$CleanedDate3[2] = "Early";
									} else {
										if($CleanedDate3[2] < 20) {
											$CleanedDate3[2] = "Mid";
										} else {
											$CleanedDate3[2] = "Late";
										}
									}
									if($curYear == $CleanedDate3[0]) {
										echo $CleanedDate3[2]." ".$CleanedDate3[1];
									} else {
										echo $CleanedDate3[2]." ".$CleanedDate3[1]." ".$CleanedDate3[0];
									} */

									if($rowX['FutureAvailableQty'] > 0){ 
										echo  number_format(checkTotalRoundUpNew($rowX['FutureAvailableQty'])). " - ";
									}

									$CleanedDate = rtrim($rowX['DueDate']);
									$CleanedDate2 = explode(" ", $CleanedDate);
									$CleanedDate3 = explode("-", $CleanedDate2[0]);
									 
									//print_r($CleanedDate3);
									 
									$monthNum  = $CleanedDate3[1];
									$dayNum  = $CleanedDate3[2];
									$monthName = getMOnth($monthNum);

									if($dayNum <= 10){
										echo "Mid ".$monthName;
									}
									if($dayNum >= 11 && $dayNum <= 20 ){
										echo "Late ".$monthName;
									} 
									if($dayNum >= 21 && $dayNum <= 31 ){
										$monthNumTemp = $monthNum + 1;
										$monthName = getMOnth($monthNumTemp); 
										echo "Early ". $monthName;
									}



								}
							}
						} ?>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="bodyTextSmall" style="font-size: 12px;">
			<?php
				$rowXX = mysqli_fetch_array($resultExtra3);
				
				$date1 = strtotime($rowXX['DateTimeValue']);
				$fixedDate1 = date("Y-m-d H:i",$date1);
				
				$date2 = time();
				$fixedDate2 = date("Y-m-d H:i",$date2);
				
				
				debug_to_console("stored time: ".$fixedDate1);
				debug_to_console("   now time: ".$fixedDate2);
				
				$diff = abs($date2 - $date1); 
				
				$years   = floor($diff / (365*60*60*24)); 
				
				$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
				
				$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
				
				$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
				
				$minutes  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 
				
				
				/*if($days > 0) {
					$timeFilled = 1;
					if($days > 1) {
						$textTime = $days." days, ";
					} else {
						$textTime = $days." day, ";
					}
				}*/
				if($hours > 0) {
					if($hours > 1) {
						$textTime = $textTime.$hours." hours ";
					} else {
						$textTime = $textTime.$hours." hour ";
					}
				} else {
					if($minutes < 55) {
						$textTime = 5 * ceil($minutes / 5)." minutes";
					} else {
						$textTime = "55 minutes";
					}
				}
				
				echo "Last Updated ".$fixedDate1." (".$textTime." ago)";
			?> 
		</div>
	<? 	}
	} else {
		$kount1 = 0;
	?>
        <table class="trendsnz2" width="485" border="1" id="tableStyle">
            <thead>
                <tr>
                    <th width="50%" style='padding-left:5px;'>Item</th>
                    <th width="50%" style='padding-left:5px;'>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <? if($OneResult) { ?>
					<tr>
						<td style='padding-left:5px;'>
							<? echo ucwords(strtolower($OneResult['color'])); ?>
						</td>
						<td style='padding-left:5px;'>
							<? echo $OneResult['quantity_available']; ?>
						</td>
					</tr> 
				<? } else {
						foreach($MoreResults as $item) {
							/* $kount2 = max(array_keys($item));
							$kount3 = -1; 
							while($kount3 < $kount2) {
							$kount3++; */ ?> 
							<tr>
								<td style='padding-left:5px;'>
									<?
										// echo ucwords(strtolower($item[$kount3]['color']));
										echo ucwords(strtolower($item['color']));
									?>
								</td>
								<td style='padding-left:5px;'>
									<? 
										//echo $item[$kount3]['quantity_available'];
										echo $item['quantity_available'];
									?>
								</td>
							</tr>
							<? //}
								//$kount1++;
						}
					}
						/* foreach($array as $item) {
							$kount2 = max(array_keys($item));
							$kount3 = -1; 
							while($kount3 < $kount2) {
							$kount3++; ?> 
                            <tr>
                                <td style='padding-left:5px;'>
                                    <?
                                        echo ucwords(strtolower($item[$kount3]['color']));
                                    ?>
                                </td>
                                <td style='padding-left:5px;'>
                                    <? 
                                        echo $item[$kount3]['quantity_available'];
                                    ?>
                                </td>
							</tr>
                            <? }
								$kount1++;
							} */ ?>
            </tbody>
        </table>
<?			/*if($devStuff == 1){			
				echo "<div class='bodyText' style='margin-left: 0px !important;'>
					<a href='/hitCheck.php?code=".$row['HitSKU']."' target='_blank'>Check these figures (DEV)</a>
				</div>";
			}*/
}	?>