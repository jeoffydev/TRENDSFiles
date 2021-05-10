
<?php
	$this->load->view('header/header');

	
?> 

   
<div class="container">
	<div class="row">
				<div class="col-md-12">
					<?=$breadcrumbs?>
				</div>
	</div> 

	<div class="jumbotron magintop-less" >
		<p class="mobile-code mobile-only"></p>
	
		<h2 class="itempage-title"><?=$this->general_model->cleanString($pageTitleExtension)?>
						<?php 
						/* Icons */
							$icons = $this->item_model->itemIcons($productItem);
							
							foreach ($icons as $icon){ 
								if($icon['htm'] != null){
									 echo '<span class="itemIcons position-relative"  >'.$icon['htm'].'</span>'; 
								} 
							}
						/* Icons */	 
						?>
						
			<span class="pull-right itemcodeTransfer"><?php echo $itemcode; ?></span>			
		</h2>	 
		
	</div>
</div>

<div class="container page_<?=$angularFile ?>"  >
	<!-- Admin preview-->
	<?php if($getItemDetails['preview'] == 1 || $getItemDetails['preview'] == 2):  ?>
		<div class="row">
				<div class="col-md-12">
					<?php if($getItemDetails['preview'] == 1): ?>
						<div class="alert alert-danger" role="alert">
							<i class="fa  fa-exclamation-triangle"></i> Admin Preview - This item is Inactive 
						</div>
					<?php endif; ?>	
					<?php if($getItemDetails['preview'] == 2): ?>
						<div class="alert alert-success" role="alert">
							<i class="fa  fa-check"></i> Admin Preview - This item is Active 
						</div>
					<?php endif; ?>	
				</div>
		</div>
	<?php endif; ?>
	<!-- Admin preview-->

 <!--
	<div class="row">
			<div class="col-md-12">
				<?=$breadcrumbs?>
			</div>
	</div>  -->
	 
	<div class="row  " ng-cloak>
			<div class="col-md-5">
					 
					<?php $this->load->view('items/image'); ?> 
			</div>
			<div class="col-md-6 item_tabcontent"  >
		 
					<!-- TABS-->
					<!-- Initiate Details tab--><span ng-init="getQuickViewData('details', '<?=$productItem[0]->Prim?>', '<?=$productItem[0]->Code?>')"></span>	 
					 <ul class="nav nav-tabs TGPContentTabs mobile-hide" id="myTab" role="tablist" ng-show="openTabs"  >
							<li class="nav-item">
								<a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="true" ng-click="getQuickViewData('details', '<?=$productItem[0]->Prim?>', '<?=$productItem[0]->Code?>')">   Details</a> 
								 
							</li>
							<li class="mobile-active details-list">   </li>
							<li class="nav-item">
								<a class="nav-link" id="stock-tab" data-toggle="tab" href="#stock" role="tab" aria-controls="stock" aria-selected="false" ng-click="getQuickViewData('stock', '<?=$productItem[0]->Prim?>', '<?=$productItem[0]->Code?>', 'item')" >   Stock</a>
							</li>
							<li class="mobile-active stock-list"> </li>
							<?php if($siteLogcheck['loggedIn'] == 1 || $skinnedUserCheck['skinnedLoggedIn'] == 1 || $customArray['themeArray'][0]->showPricing == 1): ?>
								<?Php  

										//Get mobile detector
										if($this->general_model->mobileDetector() == 0){  
											$mobile = 0;
										}else{
											$mobile = 1;
										}

										$firstTab = '';
										$secondTab = ''; 
										$Nzd = '';
										$Aud = '';
										$nzdTab = ' - NZD'; 
										$audTab = ' - AUD'; 

										$nzdClass = 'nzdclass'; 
										$audClass = 'audclass'; 

										//If skinned sites TAbs
										if(count($customArray['themeArray']) > 0 || $siteLogcheck['userDatas'][0]->multiCurrency == 0){
											$nzdTab = ''; 
											$audTab = ''; 
										}
										//print_r($this->general_model->getCurrencyData());

										/********************************************* NEW CODE ********************/
											if($currencyDatas = $this->general_model->getCurrencyData()){
												foreach($currencyDatas as $rowOfCurrency){

													//If login user and If NOT skinned sites
													if($siteLogcheck['loggedIn'] == 1 && $skinnedUserCheck['skinnedLoggedIn'] == 0){
														if($rowOfCurrency->currencyName == $siteLogcheck['userDatas'][0]->Currency){
															$smallLetterCurrency =  strtolower($rowOfCurrency->currencyName);
															//$pricingExtension = '';
															//if($siteLogcheck['secondaryIDActive']): $pricingExtension = ' - '.$rowOfCurrency->currencyName; endif;
															$pricingExtension = ' - '.$rowOfCurrency->currencyName; 

															echo '<li class="nav-item  "><a class="nav-link" id="pricing'.$smallLetterCurrency.'-tab" data-toggle="tab" href="#pricing'.$smallLetterCurrency.'" role="tab" aria-controls="pricing'.$smallLetterCurrency.'" ng-click="getCurrency('.$rowOfCurrency->currencyID.')" aria-selected="false"> Pricing '.$pricingExtension.' </a></li>';
															
															$btnQuickView = '<a href="#" id="btnSave" data-toggle="modal" data-target="#quickQuoteModal"  class="quickQuote margin-top btn btn-dark" ng-show="showData" ng-click="getQuoteMessage()" > Quick Quote </a> ';
															//$btnQuickView2 = '<a href="#" id="btnSave2" data-toggle="modal" data-target="#quickQuoteModal"  class="quickQuote margin-top btn btn-dark" ng-show="showData" ng-click="getQuoteMessage()" > Quick Quote </a> ';

														}
													}

													if(count($customArray['themeArray']) > 0){
														
														if($rowOfCurrency->currencyName == $customArray['customerAccount'][0]->Currency){
															$smallLetterCurrency =  strtolower($rowOfCurrency->currencyName);
															echo '<li class="nav-item  "><a class="nav-link" id="pricing'.$smallLetterCurrency.'-tab" data-toggle="tab" href="#pricing'.$smallLetterCurrency.'" role="tab" aria-controls="pricing'.$smallLetterCurrency.'" ng-click="getCurrency('.$rowOfCurrency->currencyID.')" aria-selected="false"> Pricing  </a></li>';
														}
													}
												}
											
											}  
										/********************************************* NEW CODE ********************/ 

										 
								?>
												 






							<?php endif; ?>
							
							<?php if($siteLogcheck['loggedIn'] == 1 && $skinnedUserCheck['skinnedLoggedIn'] == 0): ?>	
								<li class="nav-item">
									<a class="nav-link" id="changes-tab" data-toggle="tab" href="#changes" role="tab" aria-controls="changes" aria-selected="false">   Changes {{changesCount}}</a>
								</li>
								<li class="mobile-active changes-list"></li>
							<?php endif; ?>
					</ul> 

					<div class="tab-content TGPContent" id="TGPContent" >
							<div class="tab-pane fade show active details-mobile" id="details" role="tabpanel" aria-labelledby="details-tab"> 

									 
									<!-- Details -->	
									<div ng-if="details" class="item-content details-content">
										<?php $this->load->view('module/details'); ?> 
										<?php $this->load->view('items/compliance'); ?>  
									</div>
									<!-- Details -->
							</div>
							<div class="tab-pane fade stock-mobile" id="stock" role="tabpanel" aria-labelledby="stock-tab"> 
								
								<!-- Stocks -->	 
								 	<?php  if($productItem[0]->HitSKU != 0){  
										 
									  
										$cacheStockWorldSource = "_StockWorldSource_cache_".$itemcode;
										$hitSKU = $productItem[0]->HitSKU;

										if(!$hitSKUArray = $this->cache->get($cacheStockWorldSource)){
											//For admin preview link item/100090/preview
											$hitSKUArray = $this->hitpromo->index($hitSKU); 
											$this->cache->save($cacheStockWorldSource, $hitSKUArray, 1200); 
											
										} 
										
										if($hitSKUArray){
											echo $this->item_model->hitPromoTable($hitSKUArray);
										}else{
											$msgHitNone = 'Please contact your Account Manager for stock availability information.';
											echo $msgHitNone;
										}   
											/* $msgHitNone = $this->productsdisplay_model->getMessageNonHitPromo();
											echo $msgHitNone; */
										?>
												<!--<span ng-init="getHitPromoAPI('<?=$productItem[0]->HitSKU?>', '<?=$productItem[0]->Code?>')" ></span>	
												<div ng-bind-html="hitPromoAPITable | trust"></div> -->
												 
										
									<?php	

									 }else{ ?>	  
										<div ng-if="stocks"> 
												<div ng-bind-html="stocks | trust"></div>
										</div>
									<?php } ?>
								 
								<!-- Stocks -->

							</div>
							<?php if($siteLogcheck['loggedIn'] == 1 || $skinnedUserCheck['skinnedLoggedIn'] == 1 ||  $customArray['themeArray'][0]->showPricing == 1): ?>
								
							<!-- Pricing -->

								<?php 

									/********************************************* NEW CODE PRICING BOARD ********************/
									if($currencyDatas = $this->general_model->getCurrencyData()){
										foreach($currencyDatas as $rowOfCurrency){

											 //If login user and If NOT skinned sites
											 if($siteLogcheck['loggedIn'] == 1 && $skinnedUserCheck['skinnedLoggedIn'] == 0){
													
												if($rowOfCurrency->currencyName == $siteLogcheck['userDatas'][0]->Currency){
														$smallLetterCurrency =  strtolower($rowOfCurrency->currencyName);
														 
														echo '<div class="tab-pane fade pricing'.$smallLetterCurrency.'-mobile" id="pricing'.$smallLetterCurrency.'" role="tabpanel" aria-labelledby="pricing'.$smallLetterCurrency.'-tab">';
															if($getPricingDetails['pricing'.$smallLetterCurrency] == 0):
																echo $notAvail;
															elseif($getPricingDetails['pricing'.$smallLetterCurrency] == 2): 
																echo $csrMsg;
															else:
																$this->load->view('items/pricingCalculator');
																if($siteLogcheck['loggedIn'] == 1 && $skinnedUserCheck['skinnedLoggedIn'] == 0):
																	echo $btnQuickView;
																endif;
															endif;
														echo '</div>'; 
												}
											}

											if(count($customArray['themeArray']) > 0){
														
												if($rowOfCurrency->currencyName == $customArray['customerAccount'][0]->Currency){
														$smallLetterCurrency =  strtolower($rowOfCurrency->currencyName);
														echo '<div class="tab-pane fade pricing'.$smallLetterCurrency.'-mobile" id="pricing'.$smallLetterCurrency.'" role="tabpanel" aria-labelledby="pricing'.$smallLetterCurrency.'-tab">';
														 
														if($getPricingDetails['pricing'.$smallLetterCurrency] == 0): 
																echo $notAvail;
															elseif($getPricingDetails['pricing'.$smallLetterCurrency] == 2):  
																echo $csrMsg;
															else: 
																$this->load->view('items/pricingCalculator');
																 
															endif;
														echo '</div>';  
												}
											}
											 
 
										}

									}  
									/********************************************* NEW CODE PRICING BOARD********************/



								?>

								 
								 
							<?php endif; ?>	


							<?php if($siteLogcheck['loggedIn'] == 1 && $skinnedUserCheck['skinnedLoggedIn'] == 0): ?>	
								<div class="tab-pane fade changes-mobile" id="changes" role="tabpanel" aria-labelledby="changes-tab">
									<?php  $this->load->view('items/changes'); ?> 
								</div>
							<?php endif; ?>	
					</div>
					 
					
					
					<!--END TABS -->


					



<!-- MOBILE TABS ACCORDION ****************************************************************************************************************** --> 
			<?php 
			if($this->general_model->mobileDetector() == 0){  
				$mobile = 0;
			}else{
				$mobile = 1;
			}
		 
			if($mobile == 1): ?> 

			<!-- Details -->
			<div id="accordionOne" class="mobile-item-accordion  mobile-only">
						<div class="card">
							<div class="card-header" id="headingOneM">
							 
								<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOneM" aria-expanded="true" aria-controls="collapseOne" ng-click="getQuickViewData('details', '<?=$productItem[0]->Prim?>', '<?=$productItem[0]->Code?>')">
									<i class="fa fa-plus"></i> Details
								</button>
							 
							</div>

							<div id="collapseOneM" class="collapse multi-collapse" aria-labelledby="headingOneM" data-parent="#accordionM">
								<div class="card-body">
									<!-- Details -->	
									<div ng-if="details" class="item-content details-content">
											<?php $this->load->view('module/details'); ?> 
											<?php $this->load->view('items/compliance'); ?>  
									</div>
									<!-- Details -->
								</div>
							</div>
						</div>
			</div>
			
			<!-- Stock -->
			<div id="accordionTwo" class="mobile-item-accordion  mobile-only">
						<div class="card-header" id="headingTwoM">
							 
							 <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwoM" aria-expanded="false" aria-controls="collapseTwoM" ng-click="getQuickViewData('stock', '<?=$productItem[0]->Prim?>', '<?=$productItem[0]->Code?>', 'item')" >
								 <i class="fa fa-plus"></i> Stock
							 </button>
						  
						 </div>
						<div id="collapseTwoM" class="collapse multi-collapse" aria-labelledby="headingTwoM" data-parent="#accordionTwo">
							<div class="card-body">
										<!-- Stocks -->	 
										<?php  if($productItem[0]->HitSKU > 0){   
												 
													echo $msgHitNone;
												 
		
												}else{ ?>	  
												<div ng-if="stocks"> 
														<div ng-bind-html="stocks | trust"></div>
												</div>
										<?php } ?>
											
										<!-- Stocks --> 
								</div>
						 </div>
			</div>

				<!-- Pricing -->
 

					<div id="accordion" class="mobile-item-accordion  mobile-only pricemobile">
						 

						<?php if($siteLogcheck['loggedIn'] == 1 || $skinnedUserCheck['skinnedLoggedIn'] == 1 || $customArray['themeArray'][0]->showPricing == 1): ?>

								<?php 

										/********************************************* NEW CODE MOBILE ********************/
										if($currencyDatas = $this->general_model->getCurrencyData()){
											foreach($currencyDatas as $rowOfCurrency){

												//If login user and If NOT skinned sites
												if($siteLogcheck['loggedIn'] == 1 && $skinnedUserCheck['skinnedLoggedIn'] == 0){
													if($rowOfCurrency->currencyName == $siteLogcheck['userDatas'][0]->Currency){
														$smallLetterCurrency =  strtolower($rowOfCurrency->currencyName);
														$pricingExtension = '';
														if($siteLogcheck['secondaryIDActive']): $pricingExtension = ' - '.$rowOfCurrency->currencyName; endif;
														?>

															<div class="card"> 
																<div class="card-header" id="heading<?=$smallLetterCurrency?>">
																	
																		<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse<?=$smallLetterCurrency?>" aria-expanded="false" aria-controls="collapse<?=$smallLetterCurrency?>" ng-click="getCurrency(<?=$rowOfCurrency->currencyID?>)">
																			<i class="fa fa-plus"></i> <span id="pricing<?=$smallLetterCurrency?>-tab" class="price-tab-mobile"    > Pricing   <?=$pricingExtension?></a> 
																		</button>
																	
																</div>
																<div id="collapse<?=$smallLetterCurrency?>" class="collapse multi-collapse" aria-labelledby="heading<?=$smallLetterCurrency?>" data-parent="#accordion">
																	<div class="card-body">
																		
																		<?php 
																			if($getPricingDetails['pricing'.$smallLetterCurrency] == 0):
																				echo $notAvail;
																			elseif($getPricingDetails['pricing'.$smallLetterCurrency] == 2): 
																				echo $csrMsg;
																			else:
																				$this->load->view('items/pricingCalculator');
																				if($siteLogcheck['loggedIn'] == 1 && $skinnedUserCheck['skinnedLoggedIn'] == 0):
																					echo $btnQuickView;
																				endif;
																			endif;

																				
																		?>

																	</div>
																</div>
															</div>



														<?php
													}
												}

												if(count($customArray['themeArray']) > 0){
													
													if($rowOfCurrency->currencyName == $customArray['customerAccount'][0]->Currency){
														$smallLetterCurrency =  strtolower($rowOfCurrency->currencyName);
														?>

															<div class="card"> 
																<div class="card-header" id="heading<?=$smallLetterCurrency?>">
																	
																		<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse<?=$smallLetterCurrency?>" aria-expanded="false" aria-controls="collapse<?=$smallLetterCurrency?>" ng-click="getCurrency(<?=$rowOfCurrency->currencyID?>)">
																			<i class="fa fa-plus"></i> <span id="pricing<?=$smallLetterCurrency?>-tab" class="price-tab-mobile"    > Pricing  </a> 
																		</button>
																	
																</div>
																<div id="collapse<?=$smallLetterCurrency?>" class="collapse multi-collapse" aria-labelledby="heading<?=$smallLetterCurrency?>" data-parent="#accordion">
																	<div class="card-body">
																		
																		<?php 
																			if($getPricingDetails['pricing'.$smallLetterCurrency] == 0):
																				echo $notAvail;
																			elseif($getPricingDetails['pricing'.$smallLetterCurrency] == 2): 
																				echo $csrMsg;
																			else:
																				$this->load->view('items/pricingCalculator');
																				 
																			endif;

																				
																		?>

																	</div>
																</div>
															</div>
													
														<?php
													}
												}
											}
										
										}  

										/********************************************* NEW CODE  MOBILE ********************/ 


								?>				
								 
 
						<?php endif; ?>

						

						
					</div>



					<?php if($siteLogcheck['loggedIn'] == 1 && $skinnedUserCheck['skinnedLoggedIn'] == 0): ?>	
							 
							<div id="accordionThree" class="mobile-item-accordion  mobile-only">
								<div class="card-header" id="headingThreeM">
									
									<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThreeM" aria-expanded="false" aria-controls="collapseThreeM" ng-click="getQuickViewData('stock', '<?=$productItem[0]->Prim?>', '<?=$productItem[0]->Code?>', 'item')" >
										<i class="fa fa-plus"></i> Changes {{changesCount}}
									</button>
								
								</div>
								<div id="collapseThreeM" class="collapse multi-collapse" aria-labelledby="headingThreeM" data-parent="#accordionThree">
										<div class="card-body">
										<?php  $this->load->view('items/changes'); ?> 
										</div>
								</div>
							</div>			
					 <?php endif; ?>	

							





			<?php endif; ?> 
<!-- MOBILE TABS ACCORDION ****************************************************************************************************************** --> 				




 







					
			</div>
			<div class="col-md-1 icons-sidebar text-center" style="padding-right: 5px;padding-left: 5px;">
				<?php $this->load->view('items/icons'); ?> 
			</div>

	</div>  

	<div class="row margin-top margin-bottom">
			<div class="col-md-12 text-center">
					<!--RELATED ITEMS-->
					<?php //  $this->load->view('items/related_items'); ?>
					<!--RELATED ITEMS-->					
			</div>
	</div>  

	<!--QUICK QUOTE-->
		<?php  $this->load->view('items/quickQuote'); ?>
	<!--QUICK QUOTE-->


</div>	



<?php
	$this->load->view('footer/footer');
?> 