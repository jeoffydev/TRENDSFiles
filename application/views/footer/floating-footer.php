 


<?php 	if($angularFile == "category"): ?> <div class="footer_category_Elem" ng-show="searchCount == searchResults || searchCount == 0"> <?php endif; ?>

 
<div class="floating-footer footer_<?=$angularFile ?>" ng-cloak  > 


	<?php if($siteLogcheck['loggedIn'] == 1 && count($customArray['themeArray'])==0): ?>
	<!--
		<div class="footer-popup favourites" ng-if="open"   >
			<div class="container " >
				<div class="row footer-pops"   ng-mouseover="openFav()" ng-mouseleave="closeFav()" ng-cloak >
					<div class="col-md-12 fav-slick text-center"> 
							
							<slick class="favourite-main margin-bottom-light" ng-if="dataLoaded" init-onload="false" data="dataLoaded" slides-to-show="6" dots="false"> 
								
									<div   ng-repeat="favs in favouritesSlider">
										<a href="<?=base_url()?>item/{{favs.Code}}" class="thumbnail">
													<span class="img-favs">
														<img class="favs-img" src="<?=base_url()?>Images/ProductImgSML/{{favs.Code}}.jpg?<?=$this->general_model->random()?>" alt="{{favs.Code}}"  class="img-thumbnail"   >
														<h5><small>{{favs.Code}}</small><br />{{favs.Name |  cutTitle}}</h5>
													</span> 
										</a>
									</div>

								
							</slick>	
							<p ng-if="footerLoading">Loading...</p>
							<p ng-if="!dataLoaded && !footerLoading"> You don't seem to have any favourites saved, please go to an item and click on the + button to add the item. </p>
					</div> 
				</div>
			</div>	
		</div>	
		<div class="footer-popup viewed" ng-if="openTwo"   >
			<div class="container " >
				<div class="row footer-pops"  ng-mouseover="openView()" ng-mouseleave="closeView()"  ng-cloak  >
					<div class="col-md-12 fav-slick text-center">
							
							<?php  /*
								if( $storedCode = $this->general_model->getRecentlyViewed($siteLogcheck['userDatas'][0]->userID) ){
									$getCode = array_unique($storedCode, SORT_STRING); 
									$getCode = array_reverse($getCode);  

									 
									if(count($getCode) == 0 || $storedCode == 0 || $storedCode == null){
										echo '<p class="text-center"> 0 item viewed.</p>';
									}else{ 

								?>
									<slick class="favourite-main margin-bottom-light"   init-onload="false" data="dataLoaded" slides-to-show="6" dots="false"> 
										<?php foreach($getCode as $myViewed){  list($code, $name) = explode(",", $myViewed);  ?>
											<div> 
												<a href="<?=base_url()?>item/<?=$code?>" class="thumbnail">
															<span class="img-favs">
																<img class="favs-img" src="<?=base_url()?>Images/ProductImgSML/<?=$code?>.jpg?<?=$this->general_model->random()?>" alt="<?=$code?>"  class="img-thumbnail"   >
																<h5><small><?=$code?></small><br /><?=$name?></h5>
															</span> 
												</a>
											</div> 
										<?php } ?>
									</slick>	

								<?php
									}

								} 
							 */
							
							?>
					</div> 
				</div>
			</div>	
		</div>	-->
	<?php endif; ?>


	<?php $dataVar = 'Copyright   &copy; '.date("Y").'  TRENDS. All Rights Reserved. ';		?>					
	<div class="container footer-container" >
		
		<div class="row">
			<?php if($siteLogcheck['loggedIn'] == 1 && count($customArray['themeArray'])==0): ?>
				 
				<div class="col-md-6 footertgp tgprights">  <?=$dataVar?> 
					<!--
					<span ng-init="userFavourites('<?=$siteLogcheck['userDatas'][0]->userID?>')"></span>  
					<div class="footer-menu">
						<span class="text-right footer-fav scrollBottom" ng-mouseover="openFav()"     >FAVOURITES  </span> 
						<span class=" footer-viewed text-left scrollBottom"  ng-mouseover="openView()"   >RECENTLY VIEWED</span>
					</div> -->
				</div>  
				<div class="col-md-6 text-right footertgp tgplogo">  <a href="<?=strtoupper($customArray['customHome'])?>"> <img src="<?=base_url()?>Images/footer-logo.png" class="footer-logo" title="Trends" /> </a> </div>
			<?php endif; ?>
			<?php if($siteLogcheck['loggedIn'] == 0 && count($customArray['themeArray'])==0): ?><div class="col-md-6 footertgp tgprights"> <?=$dataVar?> </div> <div class="col-md-6 text-right footertgp tgplogo">  <a href="<?=strtoupper($customArray['customHome'])?>"> <img src="<?=base_url()?>Images/footer-logo.png" class="footer-logo"  title="Trends" /> </a> </div> <?php endif; ?>
			<?php if($siteLogcheck['loggedIn'] == 0 && count($customArray['themeArray']) > 0): ?><div class="col-md-6 skinnedfooter">  <?php if(count($customArray['themeArray']) > 0 && $customArray['themeArray'][0]->termsConditionText): ?><a href="<?=base_url()?>terms_conditions<?=strtoupper($customArray['customID'])?>"> Terms &amp; Conditions </a><?php endif; ?> </div> <div class="col-md-6 text-right skinnedfooter"> <?=$customArray['themeArray'][0]->CompanyTag?> </div> <?php endif; ?>
		</div>	
	</div>
</div>	

<?php 	if($angularFile == "category"): ?> </div> <?php endif; ?>