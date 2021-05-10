
	
 
 
	
<form  ng-submit="advanceSearch()" id="searchForm_category" class=" searchForm-categories" ng-click="searchHoverForm()"    >

		<input type="hidden" class="form-control text-center " id="lowInput"   ng-model="searchAdvanceForms.triggerForm"  ng-init="searchAdvanceForms.triggerForm = 1"       />
		 
		<div class="row searchForm-categories">

			<?php $addDivElement = '<div class="col-md-4 fillerdiv">&nbsp;</div>  '; ?>
			<?php if( ($siteLogcheck['loggedIn'] == 0 && count($customArray['themeArray']) == 0) ):  echo $addDivElement; endif; ?>
			<?php if(   count($customArray['themeArray']) > 0 && $skinnedUserCheck['skinnedLoggedIn'] == 0 && $customArray['themeArray'][0]->showPricing == 0 ):   echo $addDivElement; endif; ?>
			<?php if(   count($customArray['themeArray']) > 0 && $skinnedUserCheck['skinnedLoggedIn'] == 0 && $customArray['themeArray'][0]->showPricing == 2 ):   echo $addDivElement; endif; ?>

			 
			<?php // if($siteLogcheck['loggedIn'] == 1 || (count($customArray['themeArray']) > 0 && $skinnedUserCheck['skinnedLoggedIn'] == 1) || (count($customArray['themeArray']) > 0 && $customArray['themeArray'][0]->showPricing == 1) ): ?> 
				<div class="col-md-3 searchbranding">
							<lable>Select Branding:</lable>
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
							<select class="form-control " name="BrandingA"    ng-model="searchAdvanceForms.Branding" ng-change="advanceSearch()"  id="searchbrandform"> 
								<?php 
									echo '<option value=""   >Select Branding</option>'; 
									foreach($alphabetBranding as $rowBranding){ 
										echo '<option value="'.$rowBranding.'"   >'.$rowBranding.'</option>';
									}
								?>
							</select>
						
				</div>
			<?php // endif; ?>	
			<div class="   col-md-3  searchcolour ">
						<lable>Select Colour:</lable>
						<select class="form-control " name="Active"    ng-model="searchAdvanceForms.Colours" ng-change="advanceSearch()" id="searchcolourform" > 
							<?php 
									echo '<option value=""   >Select Colour</option>';
									foreach ($getcolourSearch as $colours){  
											echo '<option value="'.$colours->nameTitle.'"   >'.$colours->nameTitle.'</option>';
									}
							?> 
						</select>
					
			</div>
			<?php if($siteLogcheck['loggedIn'] == 1 || (count($customArray['themeArray']) > 0 && $skinnedUserCheck['skinnedLoggedIn'] == 1) || (count($customArray['themeArray']) > 0 && $customArray['themeArray'][0]->showPricing == 1) ): ?> 
				<div class="col-md-2 pricenum">
					<lable>Price From:</lable> 
					<input type="text" class="form-control text-center " id="lowInput" allow-only-numbers  ng-model="searchAdvanceForms.range.from"    ng-change="advanceSearchNumbers()"     />	
					 
				</div>
			 	<div class="col-md-2 pricenum">
				 	 <lable> To: </lable>
					<input type="text" class="form-control text-center " id="highInput" allow-only-numbers ng-model="searchAdvanceForms.range.to"  ng-change="advanceSearchNumbers()"     />	
				</div>

				
				
					<!--<section data-ticks="true" data-range-slider class="range-slider" step="1" ng-model="searchAdvanceForms.range" min="0" max="max" ng-click="advanceSearch()"   ></section>	-->
				<!--<div class="col-md-4 ">
					<section>&nbsp;</section>
					<div class="row no-padding no-btn">
						<div class="col-md-3 text-right"><lable><small>Price From:</small></lable></div>
						<div class="col-md-3 text-center">  <input type="text" class="form-control text-center" allow-only-numbers  ng-model="searchAdvanceForms.range.from"  ng-change="advanceSearch()"   />	 </div>
						<div class="col-md-2 text-right"><lable><small>Price To:</small></lable></div>
						<div class="col-md-3 text-center">  <input type="text" class="form-control text-center"  allow-only-numbers ng-model="searchAdvanceForms.range.to"  ng-change="advanceSearch()"     />	 </div>
					</div>
				</div>			-->			

			<?php endif; ?>	



			<div class="<?php if($siteLogcheck['loggedIn'] == 1 || (count($customArray['themeArray']) > 0 && $skinnedUserCheck['skinnedLoggedIn'] == 1) || (count($customArray['themeArray']) > 0 && $customArray['themeArray'][0]->showPricing == 1) ): ?> col-md-2  <?php else: ?> col-md-3 <?php endif; ?>"> 
				<lable> Stock Available: </lable>
				<input type="number"  ng-change="advanceSearchNumbers()"  class="form-control text-center stocknuminput"      ng-model="searchAdvanceForms.stockNumber" data-decimals="0" min="0"  step="5"/>			
			</div> 

			<div class="col-md-3   sortby">
						<lable>Sort By:</lable>
						<select class="form-control " name="priceSort"    ng-model="searchAdvanceForms.priceSort" ng-change="advanceSearch()" id="searchsortform" > 
							 <option value=""   >Select</option> 
							<?php 
								foreach ($this->general_model->sortByOptions() as $key => $value){  
									echo '<option value="'.$key.'"   >'.$value.'</option>';
								}

							?>
						</select>
					
				</div>
			

			<!--<div class="col-md-1 text-left"> 
				<button type="submit" class="btn btn-primary relative-top"><i class="fa  fa-search"></i></button>
			</div>-->
		</div>

		


</form>


