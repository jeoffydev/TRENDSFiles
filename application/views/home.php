
<?php
	$this->load->view('header/header');
?> 
	<?php // print_r($allProducts); ?>
	 
 

<div class="container-fluid home-slider">
	<?php if($homepageBanner['bannersArray']){    ?>
		<div class="row  ">
			<div class="col-md-12 p-0">

				<div id="carouselHomeControls" class="carousel slide carousel-fade" data-ride="carousel">
					<ol class="carousel-indicators home-indicators">
						<?php  
							$bn = 0;
							foreach($homepageBanner['bannersArray'] as $indicator){ 
								if($indicator->main == 1){  ?>
									<li  data-target="#carouselHomeControls" data-slide-to="<?=$bn?>"  <?php if($bn == 0){?> class="active" <?php } ?> > </li>
								
								<?php $bn++;
								} 
							} 
						?>  
					</ol>
					<div class="carousel-inner">
						<?php 

						$themeIDSaved = strtoupper($customArray['customID']); 
						$x = 0;
						foreach($homepageBanner['bannersArray'] as $banner){ 
							$activeClass = " ";
							if($x == 0){
								$activeClass = "active";
							}
							if($banner->main == 1){ 
								$bannerUrl = $this->home_model->eachBannerCheck($banner->url ); 

								

								$popUpOutput = $this->home_model->checkPopup($banner->popup, $bannerUrl,  strtoupper($customArray['customID']));
								 
								//print_r($popUpOutput);
								
								$skinnedFolder = "";
								if($homepageBanner['themeBanners'] == 1){ 
									 if($customArray['themeArray'][0]->themeID == $banner->location){
										$skinnedFolder = "SkinnedSite/";
									 }  
								}
							?> 
								<div class="carousel-item <?php echo $activeClass; ?>">
									<a  <?=$popUpOutput?> ><img class="d-block w-100" src="<?=base_url();?>Images/Banners/<?=$skinnedFolder;?><?=$banner->location;?>/<?=$banner->filename;?>?<?=$this->general_model->random();?>" ></a>
								</div>
							
							<?php } $x++; }  ?>	
					</div>
					<a class="carousel-control-prev" href="#carouselHomeControls" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="carousel-control-next" href="#carouselHomeControls" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
				

			</div>
		</div>	
	<?php } ?>

	
</div>

<div class="container-fluid minibanners">
	<?php if($homepageBanner['bannersArray']){     ?>
		<div class="row margin-bottom">
			<?php
				$countMiniBanner = $homepageBanner['miniBanners']; 
				if($countMiniBanner <= 12){
					$resultMiniColumns = 12 / $countMiniBanner;
					foreach($homepageBanner['bannersArray'] as $minibanner){ 
						if($minibanner->main == 0){  
							$bannerUrl = $this->home_model->eachBannerCheck($minibanner->url );

							 
							 
							$popUpOutput = $this->home_model->checkPopup($minibanner->popup, $bannerUrl, $themeIDSaved);

			?> 
				<div class="col-md-<?=$resultMiniColumns?>">
					<a <?=$popUpOutput?>   ><img class="d-block w-100" src="<?=base_url();?>Images/Banners/<?=$minibanner->location;?>/<?=$minibanner->filename;?>?<?=$this->general_model->random();?>" ></a>
				</div>
			<?php 
						}
					} 
				} 
			?>	
		</div>	
	<?php } ?>		
</div>

<div class="container-fluid featured-title"  > 
	<div class="row margin-bottom"> 
		<div class="col-md-4 text-center"> <span class="border-featured border-featured-left"></span> </div>  
		<div class="col-md-4 featured-center text-center"> <h2><span class="title-featured">FEATURED NEW ITEMS</span></h2> </div>  
		<div class="col-md-4 text-center"> <span class="border-featured border-featured-right"></span> </div>  
	</div>	
</div>	

<div class="container home-featured" ng-cloak >
	
	<div class="row margin-bottom"> 
		<div class="col-md-3  col-sm-6 text-center itemproducts" ng-repeat="homeItems in productFeaturedItems"> 
			<?php
				$this->load->view('module/productitems');
			?> 		 
		</div>
	</div>	

</div>	 

<?php
	$this->load->view('footer/footer');
?> 

 