
<?php
	$this->load->view('header/header');
?> 
  
	 
 <span id="clickmeScrollDiv"></span>
<section class=" container-cats">
<div class="container margin-top lessmagrin-top"  >
		<div class="row categoryscroll"  <?php  if($this->input->get('rowID')): ?> style="visibility: hidden;" <?php endif; ?> >
			<div class="col-md-12 category-title">

				<?php if($keyword): ?>  <span>Search Results: </span> <?php endif; ?>
				<h2> <?php if(!$keyword): ?> <?=$pageTitleExtension?><?php endif; ?> 
						<?php if($keyword):  ?>
						<?=ucwords($keyword)?> 
					<?php endif; ?>
					<span class="counterCats">
						<?php 
							$categoriesCountStatus = '<span class="badge badge-secondary" ng-show="searchCountShow" ng-if="searchCount != 0 ">Showing {{searchCount}} of  {{searchResults}} results</span>  ';
							echo '<span ng-if="searchCount != 0" ng-cloak>'.$categoriesCountStatus.'</span>';  
						?>
					</span>
				</h2> 	
				 
			</div>
		</div>   
		<div class="row margin-top-light search-wrapper categoryscroll" <?php  if($this->input->get('rowID')): ?> style="visibility: hidden;" <?php endif; ?>>
			<div class="col-md-4"> 
				<?=$breadcrumbs?>
			</div>
			<div class="col-md-8"> 
				<?php $this->load->view('module/searchForm'); ?> 
			</div>
		</div>   
		 
		

		
		<div class="stickyCounter" id="stickyCounter"  style="display:none" >
			<h5><?=$categoriesCountStatus?></h5>
		</div>   

		<div class="category-pop loading categoryscroll" ng-show='searchCount == "..." ' <?php  if($this->input->get('rowID')): ?> style="visibility: hidden;" <?php endif; ?>  > Searching... </div>
		<p class="text-center display_zero" ng-if="noResults || searchCount == 0"  ng-cloak   ><strong> 0 </strong> results found </p>

		 
		<div class="row margin-bottom categoryscroll"  infinite-scroll="getCategoriesScroll();" ng-cloak  ng-if="searchCount > 0" ng-mouseover="searchHoverFormOut()" <?php  if($this->input->get('rowID')): ?> style="visibility: hidden;" <?php endif; ?>> 
			 
				<div class="col-md-3 col-sm-6 text-center itemproducts itemScroll{{homeItems.Code}}" ng-repeat="homeItems in categoryLists  " id="Row{{$index}}" ng-mouseover="getThisItem(homeItems.Code)" > 
					<div class="categoryIdPosition"  id="Row{{homeItems.Code}}"></div>
					<?php
						$this->load->view('module/productitems');
					?> 		 
				</div>
			 
				<div class="category-pop loading" ng-show='loading'  >  <img src="<?php echo base_url();?>Images/loading-img.gif" width="50" height="50"/> Loading... </div> 
		</div>	

		<?php  if($this->input->get('rowID')): ?> <div class="category-pop loading categoryscroll" ng-show='searchCount == "..." || loading2' style="position:absolute; top: 45%; left:0px; "  > <img src="<?php echo base_url();?>Images/loading-img.gif" width="50" height="50"/> Loading... </div> <?php endif; ?>
		 
		 
		<p id="scrollID">&nbsp;</p>
		 
			<p id="scrollID">&nbsp;</p>
			<p id="scrollID">&nbsp;</p>
			<p id="scrollID">&nbsp;</p>
			<p id="scrollID">&nbsp;</p>
		 
		
	
		

</div>
</section>
 


<?php
	$this->load->view('footer/footer');
?> 