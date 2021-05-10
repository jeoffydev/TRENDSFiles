
						 
 
						 
						  <!-- ng-mouseover="getHitPromoAPI(homeItems.HitSKU, homeItems.Code); "  -->
						<div  ng-mouseleave="hovercontainerLeave()" class="card item-card cursorpoint  <?php if( ($customArray['themeArray'][0]->showPricing == 1 || $skinnedUserCheck['skinnedLoggedIn'] == 1) ||  $siteLogcheck['loggedIn'] == 1 ): ?> adjust_itemcard_price <?php endif; ?>">
							<div class="hover-icons"> 
								<span ng-show="!details"  ng-click="getQuickViewData('details', homeItems.Prim, homeItems.Code, homeItems.getColour  )" data-toggle="tooltip" data-placement="top" title="Details">D  </span> 
								<span  ng-click="closeQuickView()" ng-show="details" data-toggle="tooltip" data-placement="top" title="Details">D  </span>

								<span ng-show="!stocks"  ng-click="getQuickViewData('stock', homeItems.Prim, homeItems.Code, homeItems.getColour)" data-toggle="tooltip" data-placement="top" title="Stock">S</span> 
								<span  ng-show="stocks"  ng-click="closeQuickView()"  data-toggle="tooltip" data-placement="top" title="Stock">S</span>
								
								<?php if($siteLogcheck['loggedIn'] == 1 || (count($customArray['themeArray']) > 0 && $skinnedUserCheck['skinnedLoggedIn'] == 1) || (count($customArray['themeArray']) > 0 && $customArray['themeArray'][0]->showPricing == 1) ): ?> 
									<span ng-show="!pricing" ng-click="getQuickViewData('pricing', homeItems.Prim, homeItems.Code, homeItems.getColour)"  data-toggle="tooltip" data-placement="top" title="Pricing">P</span>
									<span  ng-show="pricing"  ng-click="closeQuickView()"  data-toggle="tooltip" data-placement="top" title="Pricing">P</span>
								<?php endif; ?> 

								<!-- ng-click="getQuickViewData('branding', homeItems.Prim, homeItems.Code)" This is for branding -->
								<span ng-if="homeItems.brandingExists == 1 " class="quickviewBranding"     data-toggle="tooltip" data-placement="top" title="Branding Template"><a href="<?=base_url()?>PDFWires/{{homeItems.Code}}.pdf?{{homeItems.Random}}" target="_blank"> B </a> </span>
								
								<span ng-show="!images" ng-click="getQuickViewData('images', homeItems.Prim, homeItems.Code, homeItems.getColour)" data-toggle="tooltip" data-placement="top" title="Images">I</span>
								<span  ng-show="images"  ng-click="closeQuickView()"  data-toggle="tooltip" data-placement="top" title="Images">I</span>
								
								<span class="zoom-span zoomspan{{homeItems.Prim}}"> 
									<span ng-if="!homeItems.getColour"  ng-click="imgZoom(homeItems.Code)" class="zoom-plus" data-toggle="tooltip" data-placement="top" title="High Resolution Image">+</span>
									<span ng-if="homeItems.getColour"  ng-click="imgZoom(homeItems.Code, homeItems.getColour)" class="zoom-plus" data-toggle="tooltip" data-placement="top" title="High Resolution Image">+</span>
								</span> 
							</div> 
							<div class="hovericons-container hovericons-container{{homeItems.Prim}}_{{homeItems.getColour}}">
								<h6>{{homeItems.Code}} - <strong> {{homeItems.FullName}}</strong></h6>
								<div class="quickView-scrollbox text-left">
									
									<!-- Details -->	
									<div ng-if="details">
										<?php $this->load->view('module/details'); ?> 
									</div>
									<!-- Details -->	

									<!-- Stocks -->	
									<div ng-if="stocks" class="stock_wrapper"> 
										<div ng-bind-html="stocks | trust"></div>
									</div>
									<!-- Stocks -->

									<!-- Pricing -->	
									<div ng-if="pricing"> 
										<div ng-bind-html="pricing | trust"></div>
									</div>
									<!-- Pricing -->

									<!-- Images -->	
									 
									<div ng-if="images">
										<ul class="quickview-images" ng-if="images">
											<li ng-repeat="img in images">
												<span class="cursorpoint" ng-click="viewImageInCard(img, homeItems.Prim, homeItems.Code, $index,  homeItems.Random, imgx)">
													<img ng-src="/Images/ProductImgSML/{{ img }}?<?=$this->general_model->random();?>" />
												<span>
											</li>
										</ul>	
									</div>

									<!-- Images -->

									
								</div>

							</div>
							<a href="/item/{{homeItems.Code}}<?=strtoupper($customArray['customID'])?>" class="normalhyperlink"> 
								<span ng-if="!homeItems.getColour" class="quickviewIMG{{homeItems.Prim}}"><img class="card-img-top" src="<?=base_url();?>Images/ProductImgSML/{{homeItems.Code}}.jpg" alt="{{homeItems.Name}}"></span>
								<?php if($this->uri->segment(1) == "" || $this->uri->segment(1) == "home" || $angularFile == "home"): $imagePath = 'resizer/470/'; else: $imagePath = 'resizer/470/'; endif;  ?>
								<span ng-if="homeItems.getColour" class="quickviewIMG{{homeItems.Prim}}"><img class="card-img-top" src="<?=base_url();?><?=$imagePath?>{{homeItems.Code}}-{{homeItems.getColour}}.jpg?<?=$this->general_model->random();?>x" alt="{{homeItems.Name}}"></span>
								<span id="removeImg{{imgx}}"  class="qv-image quickviewNewIMG{{homeItems.Prim}}"  > </span>
								<div class="card-body loop-items">
									
									<p>{{homeItems.Code}} </p>
									<h6 class="card-title" ><strong> <span ng-if="homeItems.Overlap == 0 "> {{homeItems.Name}} </span>  <span ng-if="homeItems.Overlap == 1"  class="titledisplay"   ng-mouseover="toggleFullNameItem(homeItems.Prim, homeItems.getColour)" ng-mouseleave="toggleFullNameItemMouseleave()" > {{homeItems.Name}} </span> </strong> <span  style="visibility:hidden" class="tooltip-{{homeItems.Prim}}{{homeItems.getColour}} tooltip-alternative"> {{homeItems.FullName}} </span> </h6>
									<p class="card-text" ng-bind-html="homeItems.price2Use | trust">  </p>
								 
									<p class="item-icons"><span ng-repeat="icons in homeItems.Icons" ng-if="icons.html !== null " > <span ng-bind-html="icons.htm | trust"   ></span>  </span>
									

									
									</p>
									
								</div>
							</a>
						</div>
						
