
<?php
	$this->load->view('header/header');
?> 
	<?php // print_r($allProducts); ?>

	<div class="jumbotron" >
		<h1>TRACK TRACE =  </h1>
		<p><?=print_r($dhlTrackTrace)?> </p>
		<?=$dhlTrackTrace['trackTraceNumber']?>
	</div>
	
	<?php 
		/* echo "<pre>";
		print_r($trackTraceRequest);
		echo "</pre>"; */
	?>

	<div class="container margin-top body-font  main-track"  >  
			<!-- logos-->
			<div class="row">
				<div class="col-md-6 dhl">
					<div class="row">
						<div class="col-md-2 text-left"><img src="/Images/TrackTrace/nz-map.png" class="nz-map img-responsive" alt="DHL" /></div>
						<div class="col-md-8 text-center"><span class="crossing">Crossing the ditch</span></div>
						<div class="col-md-2 text-right"><img src="/Images/TrackTrace/aus-map.png" class="aus-map img-responsive" alt="DHL" /></div>
					</div>
				</div>
				<div class="col-md-6 startrack">
					<img src="/Images/TrackTrace/star-track.png" class="img-responsive" alt="StarTrack" />
					<span class="pull-right phone"><i class="fa fa-phone-square" aria-hidden="true"></i> 13 2345</span>
				</div>
			</div>
		<!-- logos--> 
		<!--Headings-->  
		<div class="row main-status seven-cols">
				<div class="col-md-1s dhl heading">
					<span>Departing Trends Collection</span>
				</div>
				<div class="col-md-1s  dhl heading">
					<span>International Freight</span>
				</div>
				<div class="col-md-1s  dhl heading">
					<span>Arrived and Customs Cleared</span>
				</div> 
				<div class="col-md-1s heading">
				<span>In Transit </span>
				</div>
				<div class="col-md-1s heading">
				<span>At Delivery Depot</span>
				</div>
				<div class="col-md-1s heading">
					<span>On Board for Delivery</span>
				</div>
				<div class="col-md-1s heading">
					<span>Delivered</span>
				</div> 
		</div> 
		<!--Headings-->  
		<div class="row status chart-status seven-cols">
				<?=$trackTraceData?>
		</div>  
	</div>


	<!--Start TRACKING Details-->  
 
   
	<div class="container margin-top no-padding body-font main-track"> 
        <div class="card">
            <div class="card-body">
				<h3 class="title">Tracking Events</h3> 
				
                <?php if($datas['consignments']){  ?>
                    <div class="card">
                         <div class="card-body">
                            <h5 class="summary-consignment-title">StarTrack Consignment Summary</h5>
                                <div class="row">
								<?php
							 
                                        $consignment = $datas['consignments'];		// The i-th consignment	 
										
                                        //Get the type value
                                        foreach ($types as $key => $value){
                                            if($consignment->type == $key){
                                                $type = $value;
                                            }
                                        } 
                                         //Get the status value
                                        foreach ($stats as $key => $value){
                                            if($consignment->status == $key){
                                                $status = $value;
                                            }
										}
										
										$destination = '';
                                        $receiver[$i]=$consignment->receiver->contactDetails[0]->address; 
                                          
                                        if($receiver[$i]){ 
                                            $destination = $receiver[$i]->addressLine[0].' '.$receiver[$i]->suburbOrLocation.', '.$receiver[$i]->state. ' ' .$receiver[$i]->postCode; 
										} 
										
										if($oC->locationDescription($consignment->despatchDepot) == ''){
                                            $desDepot = $consignment->despatchDepot;
                                        }else{
                                            $desDepot = $oC->locationDescription($consignment->despatchDepot);
                                        }
                                        
                                        if($oC->locationDescription($consignment->deliveryDepot) == ''){
                                            $delDepot = $consignment->deliveryDepot;
                                        }else{
                                            $delDepot = $oC->locationDescription($consignment->deliveryDepot);
										}
										
										echo "<div class='col-md-6 border-right track-summary'>
													<div class='row'>
														<div class='col-md-4'>Tracking No.: </div>
														<div class='col-md-8'><a href='https://msto.startrack.com.au/track-trace/?id=".$datas['id2']."' class='link-startrack' target='_blank'>".$datas['id2']."</a></div> 

														<div class='col-md-4'>Type: </div>
														<div class='col-md-8'> ".$type. "</div> 
														
														<div class='col-md-4'>Service: </div>
														<div class='col-md-8'>".$oC->serviceDescription($consignment->serviceCode)." (".$consignment->serviceCode.")"."</div>  
													
														<div class='col-md-4'>Despatch Depot: </div>
														<div class='col-md-8'> ".$desDepot."   &nbsp; </div>

														<div class='col-md-4'>Despatch Date: </div>
														<div class='col-md-8'>".date('d/m/Y', strtotime(str_replace('/', '-', $consignment->despatchDate)))."</div> 
													</div>
												</div>";
											
										echo "<div class='col-md-6 track-summary'>  
													<div class='row'>
														<div class='col-md-4'>Delivery Depot: </div>
														<div class='col-md-8'>".$delDepot."  &nbsp; </div> 
														<div class='col-md-4'>ETA Date: </div>
														<div class='col-md-8'>".$this->tracktrace_model->dateOnly($consignment->etaDate)."</div> 

														<div class='col-md-4'>Destination: </div>
														<div class='col-md-8'>".$destination."</div>  

														<div class='col-md-4'>Status: </div>
														<div class='col-md-8'><h5><span class='badge badge-secondary '>".$status."</span></h5></div> 
													</div>
												</div>";
                                         
                                     
                                ?>
                                </div>
                                
                        </div>   
                    </div>
				<?php }    ?> 

					 

							<table class="table table-striped event-details table-hover  margin-top">
								<thead id="fix-top-event">
									<tr class="event text-left">
									<th class="carrier">Carrier</th>
									<th class="date-time">Date/Time(Local)</th>
									<th class="event">Event</th>
									<th class="location">Location</th>
									</tr>
								</thead>
								<tbody> 
										<?php 
										if($dhlTrackTrace['dhlNumber']   && $dhlTrackTrace['trackTraceNumber'] ){
											// Get DHL Events
											echo $selectHawb; 
											// Get StarTrack Events
											$data = array(
												'id1' => $id1,
												'id2' => $id2,
												'dhl' => $dhl,
												'conn'=> $conn,
												'option' => 1,
												'consignments' => $consignments,
												'consignmentCount' => $consignmentCount
											);
											if($datas['consignments']){ 
												echo $getTrackingDetails;
											} 
										}
										?>
								</tbody>  
							</table>
					 
                
            </div>
        </div>    
   </div> 
   <!--Start TRACKING Details-->   
	








	 
<?php
	$this->load->view('footer/footer');
?> 