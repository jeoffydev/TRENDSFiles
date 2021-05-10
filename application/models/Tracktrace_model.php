<?php
require_once APPPATH.'libraries/track-trace/eServices.php';
require_once APPPATH.'libraries/track-trace/CustomerConnect.php';

class Tracktrace_Model extends CI_Model {

	 
	function getConnection(){
		$oConnect = new ConnectDetails();
		$connection = $oConnect->getConnectDetails();

		return $connection;
	}

	function getRequest($connection, $trackNum){ 
		$trackError = '';
		$trackErrorLog  = '';
		$parameters = array(
			'header' => array(
								'source' => 'TEAM',
								'accountNo' => '5013388288',
								'userAccessKey' => $connection['userAccessKey']
							),	
			'consignmentId' => explode(" ", $trackNum)	// Allow for multiple consignments
		);
		$request = array('parameters' => $parameters);

		return $request;
	}
	 
	function getTrackTraceAPI($trackNum){
		$connection = $this->getConnection(); 
		$request = $this->getRequest($connection, $trackNum); 
		//Create the request, as per Request Schema described in eServices - Usage Guide.xls 
		 
		if($request){ 
				try
				{
					$oC = new STEeService();
					
				//	$oC = new startrackexpress\eservices\STEeService();	// *** If PHP V5.3 or later, uncomment this line and remove the line above ***
				
					$response = $oC->invokeWebService($connection,'getConsignmentDetails', $request);		// $response is as per Response Schema
					$consignments = $response->consignment;
					$consignmentCount = count($consignments);	
				 
				}
				catch (SoapFault $e)
				{
					 
					$consignments = 0;
					$consignmentCount = 0;
					 
				}

				$data = array(
					'consignments' => $consignments,
					'consignmentCount' => $consignmentCount
				);
		
		}  
		return $data;

	}



	function getLocationDescription(){  
		$oC = new STEeService();   
		return $oC; 
	}



	//Combination  of StarTrack and DHL
	function trackDhlStarTrack($data){ 
		$id1= $data['id1'];
		$id2= $data['id2']; 
		$option = $data['option']; 
		$consignments = $data['consignments'];
		$consignmentCount =  $data['consignmentCount'];
		
		$vars = array(
			'id1' => $id1,
			'id2' => $id2, 
			'option' => $option
		  ); 

	 
		 if($id1 && $id2){

			 
			// ID 2= STARTRACK
			if ($id2 != null) {    
				try {  
					$output = '';  
					if($consignments > 0){
						  
						$startrackChart  = false; 
						$startrackDHL= false;
						$values = '';
						//print_r($consignments);
						$stat1= '<div class="col-md-1s dhl active"><i class="fa fa-arrow-up" aria-hidden="true"></i></div>';
						$stat2 = '<div class="col-md-1s starttrack active"><i class="fa fa-arrow-up" aria-hidden="true"></i></div>';
						/*print_r($consignments->statusHistory);
						echo "<pre>";
						print_r($consignments);
						echo "</pre>"; */
						for ($i = 0; $i < $consignmentCount; $i++)
						{
							$consignment = $consignments->statusHistory;	
								 
							 
							$conCount = count($consignment);
							 
							for($x =0; $x < $conCount; $x++ ){ 
								//Filter only show the status with these values
								if($consignment[$x]->status == 'DF'
								|| $consignment[$x]->status == 'PD' 
								|| $consignment[$x]->status == 'UD' 
								|| $consignment[$x]->status == 'OD' 
								|| $consignment[$x]->status == 'AD'
								|| $consignment[$x]->status == 'IT'
								|| $consignment[$x]->status == 'DL' 
								){ 
									$values.= $consignment[$x]->status.','; 
								} 
							}
							
							list($first) = explode(',', $values);
							//$first = 'CO'; 
							if($first == 'DF'){
								$counter = 3; 
								$startrackChart= true;
							}
							if($first == 'PD'){
								$counter = 3; 
								$startrackChart= true;
							}
							if($first == 'DL'){
								$counter = 3; 
								$startrackChart= true;
							}
							if($first == 'FS'){
								$counter = 3; 
								$startrackChart= true;
							}

							if($first == 'OD'){
								$counter = 2;
								$startrackChart= true;
							} 
							
							if($first == 'UD'){
								$counter = 1;
								$startrackChart= true;
							} 
							if($first == 'AD'){
								$counter = 1;
								$startrackChart= true;
							} 
							if($first == 'RD'){
								$counter = 1;
								$startrackChart= true;
							} 
							if($first == 'BI'){
								$counter = 1;
								$startrackChart= true;
							} 

							if($first == 'IT'){
								$counter = 0;
								$startrackChart= true;
							} 
							if($first == 'PP'){
								$counter = 0;
								$startrackChart= true;
							} 
							if($first == 'PU'){
								$counter = 0;
								$startrackChart= true;
							}  

							if($first == 'RP' || $first == 'UC' || $first == 'RC' || $first == 'IC' || $first == 'DE' || $first == 'CO'){  
								$startrackDHLfull= true;
							}   
						}
						if($startrackChart == false){ 
							if($startrackDHLfull==true){
								for($i=0; $i<3; $i++){ 
									$output.= '<div class="col-md-1s dhl active"><i class="fa fa-arrow-up" aria-hidden="true"></i></div>';
								} 	
							}else{
								$output.=$this->selectHawb($id1, 0); 
							} 
						} 
						
						if($startrackChart== true){
							//Loop the default DHL status
							for($ia = 0; $ia <= 2; $ia++){   
								$output.= $stat1;
							}
							//Loop the starTrack status
							for($ib = 0; $ib <= $counter; $ib++){  
								$output.= $stat2;
							}
						}
					}else{
						//echo $consignmentCount;
						//echo " DHL output";
						$output.=$this->selectHawb($id1, 0);
					}
                    
				}
				catch (Exception $ex) {
				  $output.= 'Exception: ' . $ex->getMessage();
				}
				 return $output;
			}   
		}else{
			return '<div class="col-md-12 text-center notfound alert-warning">Please enter your tracking ID number...</div>';
		}  
	}


	function selectHawb($id1, $status, $id2=null){    

		$query = $this->db->query("SELECT * FROM dhl_status_table WHERE HawbReference = '".$id1."' ");

		//variables
        $res = '';
        $tdActive = '<div class="col-md-1s dhl active"><i class="fa fa-arrow-up" aria-hidden="true"></i></div>'; 
        $status == 1 ? $details = 'details': $details = 'ID'; 
        $tdNone =  '<div class="row dhl-details"><div class="col-md-12 text-center notfound alert-warning"><i class="fa fa-times-circle big" aria-hidden="true"></i> DHL '.$details.' not found </div></div>'; 
        $statusNull =  '<div class="row dhl-details"><div class="col-md-12 text-center notfound alert-warning"><i class="fa fa-search" aria-hidden="true"></i> DHL Tracking ID found but no status at the moment. </div></div> ';   
 

		 if ($query->num_rows() > 0) { 
				$active = $tdActive;
				foreach ($query->result() as $row) {   
						if($row->departDunedin != null ){ 
							$msg = $this->DhlDetails($row->departDunedin, 1, 1);
							$status == 1 ? $res.= $msg : $res.= $active;
						}
					
						$arrive =  $this->dateCompare($row->departDunedin, 1); 
						if($arrive != null){
							$msg = $this->DhlDetails($arrive, 2);
							$status == 1 ? $res.= $msg : $res.= $active;
						}

						if($row->arriveDestination != null ){ 
							
							$msg = $this->DhlDetails($row->arriveDestination, 3, null, $row->headport);
							$status == 1 ? $res.= $msg : $res.= $active;
						}  
						//If all NULL
						if($row->departDunedin == null &&  $arrive == null && $row->arriveDestination == null){ 
							$res.=$statusNull;
						}
				}  
		 }else{
            //else no found trackingID on DB
            $res.= $tdNone;
        }  

		return $res;

         
	}
	
	function DhlDetails($dateTime, $steps, $opt=null, $headport=null){
        if($opt ==1){
            $opt = ' 5:00 PM';
        } 
        if($headport != null){
            $headport = $headport;
        }else{
            $headport = 'PERTH, AU';
        } 
        $out = '';  
        $out.= '<tr>';
        $out.= '<td><span><em>DHL</em></span></td>';
        $out.= '<td><span>'.$dateTime.' '.$opt.'</span></td>';
        if($steps == 1){ 
             $out.= '<td><span>Departing Trends Collection</span></td>';
             $out.= '<td><span>DUNEDIN, NZ</span></td>';
        }
        if($steps == 2){ 
            $out.= '<td><span>Arrive DHL Depot</span></td>';
            $out.= '<td><span>CHRISTCHURCH, NZ</span></td>';
        }
        if($steps == 3){ 
            $out.= '<td><span>Arrive DHL Depot</span></td>';
            $out.= '<td><span>'.$headport.'</span></td>';
        }
        $out.= '</tr>';
        return $out;

	}
	
	function dateCompare($getDate, $opt=null){ 
        
		date_default_timezone_set('NZ');
		$day = date("d");
		$month = date("m");
		$year = date("Y"); 
		$today = date("d-m-Y");
		if($opt == 1){
			  $time = '9:00AM';
		}else{
			  $time = '';
		}
		$getDate = str_replace('/', "-", $getDate);  
	 

		 if(strtotime($today) > strtotime($getDate)){ 
			  //echo $today.  "<br />";
			  list($t1, $t2, $t3) = explode("-", $today); 
			  list($d1, $d2, $d3) = explode("-", $getDate); 
			  //echo $d2.  "<br />";
			  $arrayMos = array('04', '06', '09', '11');
			  $arrayMos2 = array('02');
		  //echo $d2.  "<br />";
			  if(in_array($d2, $arrayMos) && ($d1 == "30")){
					  $d2 = (int)$d2;
					  $d2new = $d2 + 1;
					  $arrive =  '01/'.$d2new.'/'.$d3. ' '.$time; 
					  //echo "eto 1";
			  }elseif(in_array($d2, $arrayMos2) && ($d1 == "28") ){
					  $d2 = (int)$d2;
					  $d2new = $d2 + 1;
					  $arrive =  '01/'.$d2new.'/'.$d3. ' '.$time; 
					  //echo "eto 2";
			  }else{ 
					  $d1 = (int)$d1;
					  $d1new = $d1 + 1;
					  if($d1  ==  "31" ){
						  $d1new = '01';
						  if($d2 != 12){
								$d2 = $d2 + 1;
						  }
						  if($d2 == 12){
								$d2 = '01';
						  }   
					  }
					  $arrive = $d1new.'/'.$d2.'/'.$d3. ' '.$time; 
			  } 
		  }else{
				  $arrive = null;
		  }  
		
		return $arrive;
  }

  	function consignmentTypes(){
		$consignmentType = array(
			'C'	=> 'Controlled Return',
			'D'	=> 'Despatch',
			'T'	=> 'Transfer',			
		);
		return $consignmentType;
	}

	function statusCodes(){
		$statusCodes = array(
			'AD' => 'At Delivery Depot',
			'BI' => 'Booked In',
			'CO' => 'Confirmed',
			'DE' => 'Deleted',
			'DF' => 'Delivered in Full',
			'DL' => 'Delivered',
			'FS' => 'Final Shortage',
			'IC' => 'Incomplete',
			'IT' => 'In Transit',
			'OD' => 'On Board for Delivery',
			'PD' => 'Partial Delivery',
			'PP'  => 'Partial Pickup',
			'PU'  => 'Picked Up',
			'RC'  => 'Re-Consigned',
			'RD'  => 'To be Re-Delivered',
			'RP'  => 'Ready for Pickup',
			'UC'  => 'Unconfirmed',
			'UD'  => 'Unsuccessful Delivery', 
		);
		return $statusCodes;
	}

	function dateOnly($formatDate){
		$formattedDated = explode("T", $formatDate);
		$firstDate = $formattedDated[0];
		$finalDate = date('d/m/Y', strtotime(str_replace('/', '-', $firstDate)));  
		return $finalDate;
	}


	function dateFormat($formatDate){
		$formattedDated = explode("T", $formatDate);
		$firstDate = $formattedDated[0];
		$firstTime = substr($formattedDated[1], 0, -9);  
		$finalDate = date('d/m/Y', strtotime(str_replace('/', '-', $firstDate)));  
		return $finalDate. " " .$firstTime;
	}
	//get Tracking events == 0 or 1
	function getTrackingDetails($data, $oC){
		$output = '';
		$stat1= '<div class="col-md-1s dhl active"><i class="fa fa-arrow-up" aria-hidden="true"></i></div>';
		$stat2 = '<div class="col-md-1s starttrack active"><i class="fa fa-arrow-up" aria-hidden="true"></i></div>';
		/* echo "<pre>";
		print_r($data['consignmentCount']);
		echo "</pre>"; */
		//If option 0 is Status
 		if($data['option'] == 0){ 
			//If status in StarTrack
			if($item['status'] == 'In transit' || $item['status'] == 'Delivered'  ) {  
					// the status selection from StarTrack API
					if($item['status'] == 'Delivered'){
						$counter = 3;
					}
					if($item['status'] == 'Initiated'){
						$counter = 2;
					}								
					if($item['status'] == 'Sealed'){
						$counter = 1;
					}
					if($item['status'] == 'In transit'){
						$counter = 0;
					} 
					//Loop the default DHL status
					for($i = 0; $i <= 2; $i++){   
						$output.= $stat1;
					}
					//Loop the starTrack status
					for($i = 0; $i <= $counter; $i++){  
						$output.= $stat2;
					}	 
			}else{
					//echo "DHL FIRST";
					//Get DHL First if StarTrack is existing but no status yet
					 
					//$output.=$vars['dhl']->selectHawb($vars['id1'], $vars['conn'], 0);
			} 	 							
		}
 
		//If option 1 is Details
		if($data['option'] == 1){ 
			$consignments = $data['consignments'];
			$consignmentCount =  $data['consignmentCount']; 
			if($consignments > 0){ 
				$transitStates = $this->TransitStates(); 

				$out = '';    
				 
						$trackingEvents = $consignments->trackingEvents; 
						$trackingEvents = array_reverse($trackingEvents);
						//print_r($trackingEvents);  
						 
						$trackEventCount= count($trackingEvents); 
						if(count($trackingEvents) > 0):
							for($x =0; $x < $trackEventCount; $x++ ){
								//echo $trackingEvents[$x]->transitState. " - "; 
								$out.= '<tr>';
								$out.= '<td><span><em>STARTRACK</em></span></td>';  
								$formatDate = $trackingEvents[$x]->eventDateTime; 
								$out.= '<td><span>'.$this->dateFormat($formatDate).'</span></td>'; 
								$statMessage='';

								//Reason for unsuccessful delivery
								$signatoryName = '';
								if($trackingEvents[$x]->transitState == 'R'){
									if($trackingEvents[$x]->signatoryName){
										$signatoryName = $trackingEvents[$x]->signatoryName;
										if($oC->podSignatoryDescription($signatoryName)){
											$signatoryName =  "<small> - " .$oC->podSignatoryDescription($signatoryName). "</small>";
										} 
									}
								}
								//Message for delivered item
								if($trackingEvents[$x]->transitState == 'D'){
									$statMessage = $trackingEvents[$x]->quantityDelivered. " of " . $trackingEvents[$x]->quantityOnHand;
								}
								//Message for on delivery item
								if($trackingEvents[$x]->transitState == 'M'){
									$statMessage = $trackingEvents[$x]->quantityDelivered. " item ";
								}
								//Get the value of Event
								foreach($transitStates as $key => $value){
									
									if($key == $trackingEvents[$x]->transitState ){   
										$out.= '<td><span>'.$statMessage. ' ' .$value.' ' .$signatoryName.'</span></td>';
									}
								}	
								//Get the scanDepot Location
								$scanDepot = $oC->locationDescription($trackingEvents[$x]->scanningDepot);  
								$out.= '<td><span>'.$scanDepot.'</span></td>';  
								$out.= '</tr>';

							} 
						endif;	
				 
			}  
			 
		 
		} 
		return $out; 
	}
 
	
	function TransitStates(){
		$transitStates = array(
			'AT'  => 'POD Attachment',
			'B'     => 'Booked in for Delivery',
			'C'     => 'Late Data',
			'D'     => 'Delivered',
			'E'     => 'Pickup Cancelled',
			'F'     => 'Final Shortage',
			'G'     => 'Refused - Pending further instructions',
			'H'     => 'Held',
			'I'     => 'Scanned in Transit',
			'IM'    => 'POD Image',
			'J'     => 'Held at Delivery Depot',
			'L'     => 'Label Scanned In Transit',
			'M'     => 'On Board for Delivery',
			'N'     => 'NZ Scanning',
			'O'     => 'POD On File',
			'P'     => 'Picked Up',
			'Q'     => 'Truck Out',
			'QC'    => 'Inspection Quality Control',
			'R'     => 'Unsuccessful Delivery',
			'S'     => 'Shortage',
			'T'     => 'POD Returned',
			'U'     => 'Left as Instructed',
			'V'     => 'Redeliver',
			'W'     => 'Transfer',
			'X'     => 'Reconsigned',
			'Y'     => 'Returned To Sender',
			'Z'     => 'Registered For Bookin', 
		);
		return $transitStates;
	}
 

}
