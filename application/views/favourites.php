
<?php
	$this->load->view('header/header');
?> 
<div class="container">
	<div class="jumbotron" >
		<h2>Favourites </h2>
	</div>
</div>

<div class="container" style="min-height: 660px"  ng-cloak >
 
	<div class="row margin-bottom margin-top" ng-if="myFavouriteItems"> 
		<div class="col-md-3 col-sm-6 text-center itemproducts favouritesPage" ng-repeat="homeItems in myFavouriteItems" id="removeFavourite{{homeItems.Prim}}"> 
			<span class="removeIcon text-danger" ng-click="removeFavouritePage(homeItems.Prim, homeItems.Code, '<?=$siteLogcheck['userDatas'][0]->userID?>')"><i class="fa  fa-minus-circle"></i></span>
			<?php
				$this->load->view('module/productitems');
			?> 		 
		</div>
	</div>	

	<div class="row margin-bottom margin-top fullheight" ng-if="myFavouriteItems == 0"> 
		<div class="col-md-12 text-center fullheight"  > 
			<p>You have no items saved to Favourites</p>
		</div>
	</div>	


</div>	


<?php
	$this->load->view('footer/footer');
?> 