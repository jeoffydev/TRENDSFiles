<div class="form-search-top"  ng-show="stateForm"   >

                     <?php 
                        $getcolourSearch= $this->productsdisplay_model->getcolourSearch(); 
                        $getCategories = $this->productsdisplay_model->getCategories();
                        
                     ?>

                    <form id="frmSearch" name="frmSearch" method="GET" action="{{newFormUrl}}">
 
                       <div class="row ">

							<div class="col-md-3"> Category: </div>
							<div class="col-md-9 position-relative">   
									<select class="form-control " id="searchcatpopup" name="Categories"  ng-change="changeFormURL(categoryNameSelect)"   ng-model="categoryNameSelect"  > 
										<?php 
												echo '<option value=""   >Select Category</option>';
												foreach ($getCategories as $mainCat){  
														$selectRemoved = substr($mainCat->CategoryNum, 0, 3);
														if($selectRemoved != '200' && $selectRemoved != '101' && $selectRemoved != '100' && $selectRemoved != '103' && $selectRemoved != '102'){
															echo '<option value="'.$mainCat->CategoryNum.'" class="optionGroup">--'.$mainCat->CategoryName.'--</option>';
															$getSubCat = $this->productsdisplay_model->getSubCategories($mainCat->CategoryNum);
															if($getSubCat){
																foreach($getSubCat  as $subCat) { 
																	echo '<option class="optionChild" value="'.$subCat->CategoryNum.'"   >'.$subCat->CategoryName.'</option>';    
																}  
															}
														} 
												}
										?> 
									</select>
							</div>	
						</div>


						<?php // if($siteLogcheck['loggedIn'] == 1 || (count($customArray['themeArray']) > 0 && $skinnedUserCheck['skinnedLoggedIn'] == 1) || (count($customArray['themeArray']) > 0 && $customArray['themeArray'][0]->showPricing == 1) ): ?> 
							<div class="row margin-top-light margin-bottom-light"> 
								<div class="col-md-3">  Branding:</div>
								<div class="col-md-9">   
											
											<?php 
												$getBrandingSearch = $this->general_model->getBrandingMenu(); 
												$getBrandingSearchCount = count($getBrandingSearch) - 1;
											?>

											<?php 
												$getBrandingSearch = $this->general_model->getBrandingMenu(); 
												$getBrandingSearchCount = count($getBrandingSearch) - 1;
												$alphabetBranding = array();
												for($brand = 0; $brand <= $getBrandingSearchCount; $brand++){ 
													if($getBrandingSearch[$brand]['selectOption'] == 1 ){
														$alphabetBranding[] = $getBrandingSearch[$brand]['title'];
													} 
												} 
												asort($alphabetBranding);
												//print_r( $alphabet );
												
											?>
							 
											<select class="form-control " name="Branding"  id="searchbrandpopup"   > 
												<?php 
													echo '<option value=""   >Select Branding</option>'; 
													foreach($alphabetBranding as $rowBranding){ 
														echo '<option value="'.$rowBranding.'"   >'.$rowBranding.'</option>';
													}
												?>
											</select>
								</div>	
							</div>
					 
						
						<div class="row margin-top-light margin-bottom-light"> 
							<div class="col-md-3"> Colour: </div>
							<div class="col-md-9">   
								<select class="form-control " name="Colour"  id="searchcolourpopup" > 
									<?php 
											echo '<option value=""   >Select Colour</option>';
											foreach ($getcolourSearch as $colours){ 
													echo '<option value="'.$colours->nameTitle.'"   >'.$colours->nameTitle.'</option>';
											}
									?> 
								</select>
							</div>	
						</div>
						
						<?php if($siteLogcheck['loggedIn'] == 1 || (count($customArray['themeArray']) > 0 && $skinnedUserCheck['skinnedLoggedIn'] == 1) || (count($customArray['themeArray']) > 0 && $customArray['themeArray'][0]->showPricing == 1) ): ?> 
							 
							 
								<!--<section data-ticks="true" data-range-slider class="range-slider" step="1" ng-model="searchAdvanceFormPopup.range" min="0" max="maxx"    ></section>--> 

								<!--<div class="row no-padding no-btn">
									<div class="col-md-3 text-right "><lable><small>Price From:</small></lable></div>
									<div class="col-md-3 text-center">  <input type="text" class="form-control text-center"  allow-only-numbers  ng-model="searchAdvanceFormPopup.range.from" name="rangeFrom"    />	 </div>
									<div class="col-md-2 text-right"><lable><small>Price To:</small></lable></div>
									<div class="col-md-3 text-center">  <input type="text" class="form-control text-center" allow-only-numbers  ng-model="searchAdvanceFormPopup.range.to"  name="rangeTo"    />	 </div>
								</div>-->

								<div class="row margin-top-light margin-bottom-light"> 
									<div class="col-md-3"> Price  </div>
									<div class="col-md-9">   
										 
									
										<div class="row">
											<div class="col-md-6 "><lable><small>From:</small></lable>
												 <input type="text" class="form-control text-center"  allow-only-numbers  ng-model="searchAdvanceFormPopup.range.from" name="rangeFrom"    />	 
											</div>
											<div class="col-md-6 ">
												<lable><small>To:</small></lable>
												<input type="text" class="form-control text-center" allow-only-numbers  ng-model="searchAdvanceFormPopup.range.to"  name="rangeTo"    />	 
											</div>
										</div>


									</div>	
								</div>
								
								<!--
								<div class="row margin-top-light margin-bottom-light"> 
									<div class="col-md-3"> Price To: </div>
									<div class="col-md-9">   
										<input type="text" class="form-control text-center" allow-only-numbers  ng-model="searchAdvanceFormPopup.range.to"  name="rangeTo"    />
									</div>	
								</div> -->

							
							 					

						<?php endif; ?>	


						<div class="row margin-top-light margin-bottom-light"> 
							<div class="col-md-3"> Stock: </div>
							<div class="col-md-9 no-btn">   
								<input type="number"  class="form-control  text-center"   placeholder="0"   name="stockNumber" data-decimals="0" min="0"   step="1"/>	
							</div>	
						</div>
						<!--					
						<div class="row  margin-top-light margin-bottom-light">			 
										<div class="col-md-3"> Sort By:  </div>
										<div class="col-md-9">   
											<select class="form-control " name="priceSort" id="searchsortpopup"    > 
												<option value=""   >Select</option> 
												<?php 
													foreach ($this->general_model->sortByOptions() as $key => $value){  
														echo '<option value="'.$key.'"   >'.$value.'</option>';
													}

												?>
											</select>
										
										</div>
						</div>	-->
								
                        
                         
                        <input type="submit" value="Submit" class="btn  btn-secondary margin-top-light btn-small pull-right"  >
                    </form>

</div>   