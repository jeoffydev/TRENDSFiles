<?php
/* changes
added ng-click on Pricing tabs line 540 item.php
	added angularjs.min and app.js on item.php line 116 and function priceMe_firstPR()
	added ng-app='tgpAppView'  ng-controller="itemCtrls" on item.php body 373  
	added angularscript.php file on root and in item.php include on line 710 
	added angularscriptpost.php on root
	using one file priceShower.php on line 749 and 771
	Edit to remove the script line 923 on scripts.php
	item.php line 552 added angular function on tabs
	logcheck.php added a markup for 6 columns on line 118 while($markupCount < 7) 
	
	item.php for quickQuote at the bottom line part and button on every tab content
	item.php line 156 to stop the script to allowed only numbers for input quick message
*/

?>

 
<!-- main-->
<div ng-show="showData" >
<!-- main-->


<h4 class='HeaderQuoter'  >Price Calculator </h4>

 
		

			<span ng-init="selectTypeRadio('0')" ></span> 
			
			<span ng-repeat="radioType in priceTypeRadio" class="select-radio-btn" >   
					<!-- <input type="radio" id="radio$index" name="selectTypeRadio[]"  ng-model="radioTypeModel" ng-init="$index==0?(radioTypeModel=radioType.PricingType):''"    ng-value="radioType"  >   --> 
					<span class="pointer price-icon" ng-click="selectTypeRadio(radioType.PricingType)" > <span class="radioLabel pricetype-active" ng-if="currentSelected == radioType.PricingType"  > <span class="circleIconActive"></span> </span> <span class="radioLabel" ng-if="currentSelected != radioType.PricingType"> <span class="circleIcon"></span> </span>  {{radioType.PricingType}} </span>
			</span>

			<div class="datagrid margin-top " id="datagrid1"    > 
				<table class="table table-items table-striped  table-bordered table-sm"  border="0" cellspacing="0" cellpadding="0">
					<thead class="thead-dark">
						<tr>
							<th colspan="6" align="center"><span class="uppercase">{{priceResults.PrimaryPriceDes}}</span></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td width="16%" align="center"> <span ng-if="headingQuantity1 != 0"> {{headingQuantity1}} </span> </td>
							<td width="16%" align="center"> <span ng-if="headingQuantity2 != 0"> {{headingQuantity2}} </span> </td>
							<td width="16%" align="center"> <span ng-if="headingQuantity3 != 0"> {{headingQuantity3}} </span> </td>
							<td width="16%" align="center"> <span ng-if="headingQuantity4 != 0"> {{headingQuantity4}} </span> </td>
							<td width="16%" align="center"> <span ng-if="headingQuantity5 != 0"> {{headingQuantity5}} </span> </td>
							<td width="16%" align="center"> <span ng-if="headingQuantity6 != 0"> {{headingQuantity6}} </span> </td>
						</tr>

						 
							<tr  class="ng-cloak" ng-if="priceResults.Price1"   >
								<td  align="center"> <span ng-if="headingQuantity1 != 0  "> ${{priceResults.Price1 | number : 2}} </span> &nbsp; </td>
								<td  align="center"> <span ng-if="headingQuantity2 != 0  "> ${{priceResults.Price2 | number : 2}} </span> </td>
								<td  align="center"> <span ng-if="headingQuantity3 != 0  "> ${{priceResults.Price3 | number : 2}} </span> </td>
								<td  align="center"> <span ng-if="headingQuantity4 != 0  "> ${{priceResults.Price4 | number : 2}} </span> </td>
								<td  align="center"> <span ng-if="headingQuantity5 != 0  "> ${{priceResults.Price5 | number : 2}} </span> </td>
								<td  align="center"> <span ng-if="headingQuantity6 != 0 "> ${{priceResults.Price6 | number : 2}} </span> </td>
							</tr>
						 
						<tr class="ng-cloak" ng-if="!priceResults.Price1"  >
							<td  align="center" colspan="6">  ...Loading </td> 
						</tr>
					</tbody>
				</table>
			</div>	
		 
			<div class="datagrid margin-top additionalcosttable" id="datagrid2" ng-if="AdditionalsLoop" > 
				<form name="additionalCosts">
					<table class="table table-items table-striped  table-bordered table-sm"   border="0" cellspacing="0" cellpadding="0">
						<thead class="thead-dark">
							<tr>
								<th colspan="5" align="center">ADDITIONAL COSTS   </th>
							</tr>
						</thead>
						<tbody>
							<tr class="titles">
								<td width="36%" class="groupRightborder">&nbsp;</td>
								<td width="12%" align="center"> Per Unit </td> 
								<td width="12%" align="center" class="groupRightborder"> Qty </td>
								<td width="12%" align="center"  > Setup  </td>
								<?php if(count($customArray['themeArray']) == 0 || $siteLogcheck['loggedIn'] == 1): ?>   
									<td width="12%" align="center"> Qty </td>
								<?php endif; ?>	
							</tr>
							<tr    ng-repeat="additional in AdditionalsLoop"  ng-class="additional['splitdelivery'] == 1 ? 'splithideshow' : ' '"   ng-init="getAdditionalCostQuantity(additional['inputVal'], additional['cost'], additional['fieldPosition'], '1', additional['setup'], incSetup, additional['inputVal2'], additional['exception']); getDetailLoopNew(AdditionalsLoop)">
								<td  align="left" class="groupRightborder" > 
									<span ng-if="additional['adds'] == 'Debossing XL'   " class="debossHighlight"   > {{additional['adds'] }} </span> 
									<span ng-if="additional['adds'] == 'Thermo Debossing XL'   " class="debossHighlight"   > {{additional['adds'] }} </span> 
									<span ng-if="additional['adds'] == 'Silicone Debossed Per Position'  " class="debossHighlight"   > {{additional['adds'] }} </span> 
									
									<span ng-if="additional['adds'] != 'Debossing XL' &&  additional['adds'] != 'Silicone Debossed Per Position' && additional['adds'] != 'Thermo Debossing XL' "  > {{additional['adds'] }} </span>   
									<small ng-if="additional['brandingArea']" style="line-height:1.2; display:block"><i>{{cleanStringAmp(additional['brandingArea']) }}</i></small></span> 
								</td> 

								<td  align="center" > 
									<span ng-if="additional['cost'] != 0.00"> 

										<span ng-if="additional['adds'] == 'Debossing XL'   " class="debossHighlight"   > ${{additional['cost']  | number : 2 }} </span> 
										<span ng-if="additional['adds'] == 'Thermo Debossing XL'   " class="debossHighlight"   > ${{additional['cost']  | number : 2 }} </span> 
										<span ng-if="additional['adds'] == 'Silicone Debossed Per Position'  " class="debossHighlight"   > ${{additional['cost']  | number : 2 }} </span> 
			
										<span ng-if="additional['adds'] != 'Debossing XL' &&  additional['adds'] != 'Silicone Debossed Per Position' && additional['adds'] != 'Thermo Debossing XL'   "  > ${{additional['cost']  | number : 2 }} </span>   
									</span> 
								</td> 
								<td  align="center" style="padding: 0.2rem;"   ng-class="additional['splitdelivery'] == 1 ? 'greybg' : 'whitebackground'" class="groupRightborder" > <input type="text" name="Quantity{{$index}}" ng-class="additional['splitdelivery'] == 1 ? 'displaynone' : '' " class="col-md-12 text-center {{CurrencyUpdate}}getAdditionalID{{$index}}" id="{{CurrencyUpdate}}getAdditionalID{{$index}}"   ng-keydown="changeTab($event, $index, 1)" allow-only-numbers ng-model="additional['inputVal']" ng-change="getAdditionalCostQuantity(additional['inputVal'], additional['cost'], additional['fieldPosition'], '0', additional['setup'], incSetup, additional['inputVal2'], 1 ); changeTheSame(additional['inputVal'], additional['cost'], additional['fieldPosition'], '0', additional['setup'], incSetup, additional['inputVal2']); getDetailLoopNew(AdditionalsLoop)"   ng-value="additional['inputVal']">  
									<input type="hidden"   id="getAdditionalValues{{$index}}"  ng-class="additional['splitdelivery'] == 1 ? 'splitdelivery' : ''"  value="{{additional['inputVal']}}, {{additional['cost']}}, {{additional['fieldPosition']}}, 0, {{additional['setup']}}, {{additional['inputVal2']}}">

									 
								 

								</td>
								<td  align="center" >  
									<span ng-if="additional['setup'] != 0"> 

										<span ng-if="additional['adds'] == 'Debossing XL'   " class="debossHighlight"   >  ${{additional['setup'] }}  </span> 
										<span ng-if="additional['adds'] == 'Thermo Debossing XL'   " class="debossHighlight"   >  ${{additional['setup'] }}  </span>
										<span ng-if="additional['adds'] == 'Silicone Debossed Per Position'  " class="debossHighlight"   >  ${{additional['setup'] }}  </span> 

										
										<span ng-if="additional['adds'] != 'Debossing XL' &&  additional['adds'] != 'Silicone Debossed Per Position' && additional['adds'] != 'Thermo Debossing XL'  "  > ${{additional['setup'] }} </span>    
									</span> 
									 
								</td> 

								<!-- NEW Input Quantity--> 
								<?php if(count($customArray['themeArray']) == 0 || $siteLogcheck['loggedIn'] == 1): ?>   
									<td  align="center" style="padding: 0.2rem;"   ng-class="additional['fieldPositionDisabled'] ? 'greybg ' : 'whitebackground rankTd{{additional['fieldPosition']}}'" id="qtyTd{{additional['fieldPosition']}}" > <input type="text" ng-disabled="additional['fieldPositionDisabled'] && additional['splitdelivery'] != 1" name="Quantity2{{$index}}" ng-class="additional['splitdelivery'] == 1 ? 'col-md-12' : 'col-md-9' "    class="setupGetAdditionalClass{{$index + 1}} text-center {{CurrencyUpdate}}getAdditionalID2{{$index}}" id="{{CurrencyUpdate}}getAdditionalID2{{$index}}"    allow-only-numbers ng-model="additional['inputVal2']" ng-change="getAdditionalCostQuantity(additional['inputVal'], additional['cost'], additional['fieldPosition'], '0', additional['setup'], incSetup, additional['inputVal2'], 2 ); checkThisQty(additional['inputVal'], additional['cost'], additional['fieldPosition'], '0', additional['setup'], incSetup, additional['inputVal2']); getDetailLoopNew(AdditionalsLoop) "   ng-value="additional['inputVal2']"> 
										<span class="cursorpoint" ng-if="additional['splitdelivery'] != 1" ng-click="additional['fieldPositionDisabled'] = !additional['fieldPositionDisabled']; resetAdditional(additional['inputVal'], additional['cost'], additional['fieldPosition'], '0', additional['setup'], incSetup, additional['inputVal2'], additional['disabled'], additional['fieldPositionDisabled']); getDetailLoopNew(AdditionalsLoop)"> <i  data-toggle="tooltip" data-placement="right" title="Unlock to edit the number of run charges and setup charges independently. This is useful to account for artwork change-outs or multiple print positions on a product with the same artwork."  ng-class="additional['fieldPositionDisabled'] ? 'fa fa-lock' : 'fa fa-unlock'" ></i>     </span>  
									</td>
								<?php endif; ?>	
								<!-- NEW Input Quantity--> 
								
							</tr> 
							  
							
						</tbody>
					</table>
				</form>	
			</div>	
			

		 
			<div class="datagrid  margin-top table-responsive" id="datagrid3" > 
				<form name="priceSummary">
					<table class="table table-items table-striped  table-bordered table-sm table-small-font"   border="0" cellspacing="0" cellpadding="0">
						<thead class="thead-dark">
							<tr>
								<?php if( (count($customArray['themeArray']) > 0 || $siteLogcheck['loggedIn'] == 1) &&  $siteLogcheck['loggedIn'] == 0 ): ?> 
									<th colspan="7" align="center"> PRICING</th> 
								<?php else: ?>
									<th colspan="7" align="center">PRICE SUMMARY</th> 
								<?php endif;  ?>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td width="25%" align="left">Quantity</td>
								<td width="12%" align="center" class="whitebackground">   <input type="text" name="inputQuantity1" class="col-md-12 adjustpadding text-center {{CurrencyUpdate}}priceSummary1 bgquantity1" id="{{CurrencyUpdate}}priceSummary1" ng-keydown="changeTab($event, 1, 2)" allow-only-numbers  ng-model="priceResults.Quantity1"  ng-change="includeSetup(incSetup); noAdditionalCost(priceResults.Quantity1, '1'); touchByUser()" ng-disabled="disabledQty1"   ng-value="priceResults.Quantity1">  </td>
								<td width="12%" align="center" class="whitebackground" >  <input type="text" name="inputQuantity2" class="col-md-12 adjustpadding text-center {{CurrencyUpdate}}priceSummary2 bgquantity2" id="{{CurrencyUpdate}}priceSummary2" ng-keydown="changeTab($event, 2, 2)" allow-only-numbers  ng-model="priceResults.Quantity2"  ng-change="includeSetup(incSetup); noAdditionalCost(priceResults.Quantity2, '2'); touchByUser()"  ng-disabled="disabledQty2" ng-value="priceResults.Quantity2">  </td>
								<td width="12%" align="center" class="whitebackground" >  <input type="text" name="inputQuantity3" class="col-md-12 adjustpadding text-center {{CurrencyUpdate}}priceSummary3 bgquantity3" id="{{CurrencyUpdate}}priceSummary3" ng-keydown="changeTab($event, 3, 2)" allow-only-numbers  ng-model="priceResults.Quantity3"  ng-change="includeSetup(incSetup); noAdditionalCost(priceResults.Quantity3, '3'); touchByUser()" ng-disabled="disabledQty3"  ng-value="priceResults.Quantity3">  </td>
								<td width="12%" align="center" class="whitebackground" >  <input type="text" name="inputQuantity4" class="col-md-12 adjustpadding text-center {{CurrencyUpdate}}priceSummary4 bgquantity4" id="{{CurrencyUpdate}}priceSummary4" ng-keydown="changeTab($event, 4, 2)" allow-only-numbers  ng-model="priceResults.Quantity4"  ng-change="includeSetup(incSetup); noAdditionalCost(priceResults.Quantity4, '4'); touchByUser()" ng-disabled="disabledQty4"   ng-value="priceResults.Quantity4">  </td>
								<td width="12%" align="center" class="whitebackground" >  <input type="text" name="inputQuantity5" class="col-md-12 adjustpadding text-center {{CurrencyUpdate}}priceSummary5 bgquantity5" id="{{CurrencyUpdate}}priceSummary5" ng-keydown="changeTab($event, 5, 2)" allow-only-numbers  ng-model="priceResults.Quantity5"  ng-change="includeSetup(incSetup); noAdditionalCost(priceResults.Quantity5, '5'); touchByUser()"  ng-disabled="disabledQty5"  ng-value="priceResults.Quantity5">  </td>
								<td width="12%" align="center" class="whitebackground" >  <input type="text" name="inputQuantity6" class="col-md-12 adjustpadding text-center {{CurrencyUpdate}}priceSummary6 bgquantity6" id="{{CurrencyUpdate}}priceSummary6" ng-keydown="changeTab($event, 6, 2)" allow-only-numbers  ng-model="priceResults.Quantity6"  ng-change="includeSetup(incSetup); noAdditionalCost(priceResults.Quantity6, '6'); touchByUser()"  ng-disabled="disabledQty6"  ng-value="priceResults.Quantity6">  </td> 
							
							</tr>
							 
							<tr ng-if="qtyBuyExcludeSetupAlls">

								<?php if( (count($customArray['themeArray']) > 0 || $siteLogcheck['loggedIn'] == 1) &&  $siteLogcheck['loggedIn'] == 0 ): ?> 
									<td width="25%" align="left"> <span>Buy (ea) {{buysetup}}   </span> </td>
								<?php else: ?>
									<td width="25%" align="left"> <span>Buy (unit) {{buysetup}}  {{incFreightMsg}} </span> </td>
								<?php endif;  ?>

							 

									<td width="12%" align="center"> <span ng-if="priceResults.Quantity1 != 0 " ng-show="hideMOQ1" title="Rounded from {{qtyBuyExcludeSetup1 | number : 4}}"   > ${{qtyBuyExcludeSetup1 | number : 2}}  </span>   &nbsp; </td>
									<td width="12%" align="center"> <span ng-if="priceResults.Quantity2 != 0 " ng-show="hideMOQ2" title="Rounded from {{qtyBuyExcludeSetup2 | number : 4}}"  > ${{qtyBuyExcludeSetup2 | number : 2}}  </span> </td>
									<td width="12%" align="center"> <span ng-if="priceResults.Quantity3 != 0 " ng-show="hideMOQ3" title="Rounded from {{qtyBuyExcludeSetup3 | number : 4}}"  > ${{qtyBuyExcludeSetup3 | number : 2}}</span> </td>
									<td width="12%" align="center"> <span ng-if="priceResults.Quantity4 != 0 " ng-show="hideMOQ4" title="Rounded from {{qtyBuyExcludeSetup4 | number : 4}}"   > ${{qtyBuyExcludeSetup4 | number : 2}}</span> </td>
									<td width="12%" align="center"> <span ng-if="priceResults.Quantity5 != 0 " ng-show="hideMOQ5" title="Rounded from {{qtyBuyExcludeSetup5 | number : 4}}"   > ${{qtyBuyExcludeSetup5 | number : 2}}</span> </td>
									<td width="12%" align="center"> <span ng-if="priceResults.Quantity6 != 0 " ng-show="hideMOQ6" title="Rounded from {{qtyBuyExcludeSetup6 | number : 4}}" > ${{qtyBuyExcludeSetup6 | number : 2}}</span> </td> 

								 
								
							</tr>  
							<tr ng-if="!qtyBuyExcludeSetupAlls">
								<td colspan="7">Loading...</td>
							</tr> 

							<?php //if(count($customArray['themeArray']) == 0 || $siteLogcheck['loggedIn'] == 1): ?>   
								<tr ng-if="qtyBuyExcludeSetupAlls">
									<td width="25%" align="left"> <span>Buy (total) {{buysetup}}  {{incFreightMsg}}  </span> </td>
									<td width="12%" align="center"> <span ng-if="priceResults.Quantity1 != 0 " ng-show="hideMOQ1"> ${{qtyBuyExcludeTotal1 | customNumber}} </span> &nbsp; </td>
									<td width="12%" align="center"> <span ng-if="priceResults.Quantity2 != 0 " ng-show="hideMOQ2"> ${{qtyBuyExcludeTotal2 | customNumber}} </span> </td>
									<td width="12%" align="center"> <span ng-if="priceResults.Quantity3 != 0  " ng-show="hideMOQ3"> ${{qtyBuyExcludeTotal3 | customNumber}}</span> </td>
									<td width="12%" align="center"> <span ng-if="priceResults.Quantity4 != 0 " ng-show="hideMOQ4"> ${{qtyBuyExcludeTotal4 | customNumber}}</span> </td>
									<td width="12%" align="center"> <span ng-if="priceResults.Quantity5 != 0  " ng-show="hideMOQ5"> ${{qtyBuyExcludeTotal5 | customNumber}}</span> </td>
									<td width="12%" align="center"> <span ng-if="priceResults.Quantity6 != 0" ng-show="hideMOQ6"> ${{qtyBuyExcludeTotal6 | customNumber}}</span> </td>
								</tr>                
							<?php  //endif;  ?>	
							
							<!--New freight cost table row result here --> 
							<?php if(count($customArray['themeArray']) == 0 || $siteLogcheck['loggedIn'] == 1): ?> 
								<tr ng-repeat="freight  in FinalFreightCosts"  ng-if="freight.hideCarrier != 1"  >	
										<td width="25%" align="left">  
											<span ng-if="CurrencyUpdate == 'AUD' " > 
												<a href="#" data-toggle="modal" data-target="#powerbankModal" ng-if="freight.shipCarrier == 'Startrack' "  >  Freight - {{freight.shipName}} </a>  
												<a href="#" data-toggle="modal" data-target="#transitModal" ng-if="freight.shipCarrier != 'Startrack' " ng-click="activateTransit(freight.shipCarrier)"  title="Click for transit times"   id="shiptooltip" > Freight - {{freight.shipName}}     </a> 
											</span> 
											<span ng-if="CurrencyUpdate == 'NZD'  " >  Freight - {{freight.shipName}}   </span>     
											<!--<input type="radio"  ng-model="freightValue" ng-value="$index"  ng-click= "getFreightValues(freightValue, incSetup, null,  IncludeFreightUnitPriceNew)"    />  -->
											
										</td> 
										<td width="12%" align="center"><span ng-if="headingQuantity1 != 0" ng-show="hideMOQ1 || hideFreight1"> <span ng-if="freight.FreightCost1 == 'FREE' ">FREE</span> <span ng-if="freight.FreightCost1 == '-' "> - </span> <span ng-if="freight.FreightCost1 != 'FREE' && freight.FreightCost1 != '-' "> ${{freight.FreightCost1 | number : 2}} </span>   </span> </td> 
										<td width="12%" align="center"><span ng-if="headingQuantity2 != 0" ng-show="hideMOQ2 || hideFreight2"> <span ng-if="freight.FreightCost2 == 'FREE' ">FREE</span> <span ng-if="freight.FreightCost2 == '-' "> - </span> <span ng-if="freight.FreightCost2 != 'FREE' && freight.FreightCost2 != '-' "> ${{freight.FreightCost2 | number : 2}} </span>   </span> </td>
										<td width="12%" align="center"><span ng-if="headingQuantity3 != 0" ng-show="hideMOQ3 || hideFreight3"> <span ng-if="freight.FreightCost3 == 'FREE'  ">FREE</span> <span ng-if="freight.FreightCost3 == '-' "> - </span> <span ng-if="freight.FreightCost3 != 'FREE' && freight.FreightCost3 != '-' "> ${{freight.FreightCost3 | number : 2}} </span>   </span> </td>
										<td width="12%" align="center"><span ng-if="headingQuantity4 != 0" ng-show="hideMOQ4 || hideFreight4"> <span ng-if="freight.FreightCost4 == 'FREE' ">FREE</span> <span ng-if="freight.FreightCost4 == '-' "> - </span>  <span ng-if="freight.FreightCost4 != 'FREE' && freight.FreightCost4 != '-' "> ${{freight.FreightCost4 | number : 2}} </span>    </span> </td>
										<td width="12%" align="center"><span ng-if="headingQuantity5 != 0" ng-show="hideMOQ5 || hideFreight5"> <span ng-if="freight.FreightCost5 == 'FREE' ">FREE</span>  <span ng-if="freight.FreightCost5 == '-' "> - </span> <span ng-if="freight.FreightCost5 != 'FREE' && freight.FreightCost5 != '-' "> ${{freight.FreightCost5 | number : 2}} </span>   </span> </td>
										<td width="12%" align="center"><span ng-if="headingQuantity6 != 0" ng-show="hideMOQ6 || hideFreight6"> <span ng-if="freight.FreightCost6 == 'FREE' ">FREE</span>  <span ng-if="freight.FreightCost6 == '-' "> - </span> <span ng-if="freight.FreightCost6 != 'FREE' && freight.FreightCost6 != '-' "> ${{freight.FreightCost6 | number : 2}} </span>   </span> </td>
										
								</tr>  

								 


							<?php endif;  ?>	
							<!--New freight cost table row result here --> 

						</tbody> 
					</table>
				 
					<p><span ng-if="noteLessThanMOQ"  ><small> {{noteLessThanMOQ}} </small> </span></p>
				</form>	
				 
			</div>	
			
			
			<div class="row">
				<div class="col-md-6">

				<div class="squaredThree">
					<label for="mySetup" <?php if(count($customArray['themeArray']) == 0 || $siteLogcheck['loggedIn'] == 1): ?> ng-class="showbuttonSetup? 'teal text-white' : '' " <?php endif;?>  <?php if(count($customArray['themeArray']) > 0 || $siteLogcheck['loggedIn'] == 0): ?> ng-class="showbuttonSetup? 'yellow  ' : '' " <?php endif;?>   >
						<input id="mySetup" type="checkbox" ng-model="showbuttonSetup" ng-click="includeSetup(showbuttonSetup, 'changethis', IncludeFreightUnitPriceNew)"> Include Setups in Unit Price
						<span class="squaredOne" ng-class="showbuttonSetup? 'squaredTwo' : 'squaredOne' "></span>
					</label>
						 
				</div>
					
					<!--<span class="pointer price-icon includesetups" ng-click="includeSetup(true, 'changethis', IncludeFreightUnitPriceNew)" ng-if="!showbuttonSetup" > <span class="radioLabel pricetype-active"  >   <span class="circleIconSetup"><span></span></span> </span>    Include Setups in Unit Price </span>
					<span style="padding:1px" class="pointer price-icon includesetups teal text-white" ng-click="includeSetup(false, 'changethis', IncludeFreightUnitPriceNew)" ng-if="showbuttonSetup" > <span class="radioLabel pricetype-active"  > <span class="circleIconSetupActive"   ><span  ></span></span> </span>   Include Setups in Unit Price  </span> -->
				</div>
				<div class="col-md-6">   
					 <!--<span class="pointer price-icon includesetups" ng-click="IncludeFreightUnitPrice = !IncludeFreightUnitPrice;  includeSetup(incSetup, null,  IncludeFreightUnitPrice, 1)"   > <span class="radioLabel pricetype-active"  >   <span  ng-class="IncludeFreightUnitPrice ? 'circleIconSetupActive' : 'circleIconSetup'" ><span></span></span> </span>    Include Freight in Unit Price </span> -->
					<?php if(count($customArray['themeArray']) == 0 || $siteLogcheck['loggedIn'] == 1): ?> 
					 	<!--<span class="pointer price-icon includesetups" ng-click="IncludeFreightUnitPriceNew = !IncludeFreightUnitPriceNew;  includeSetup(incSetup, null,  IncludeFreightUnitPriceNew, 1)"   > <span class="radioLabel pricetype-active"  >   <span  ng-class="IncludeFreightUnitPriceNew ? 'circleIconSetupActive' : 'circleIconSetup'" ><span></span></span> </span>    Include Freight in Unit Price </span> -->
					<?php endif; ?>	
				</div>
			</div>

			
			<?php if(count($customArray['themeArray']) == 0 || $siteLogcheck['loggedIn'] == 1): ?> 
			 



				<div class="datagrid  margin-top" id="datagrid5" >  
					<table class="table table-items table-striped table-bordered table-sm "  border="0" cellspacing="0" cellpadding="0">
							<thead class="thead-dark">
								<tr>
									<th colspan="7" align="center">INFORMATION</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td width="100%" align="left"  colspan="7" > 
										<span class="para font12 teal text-white padding-badge"  ng-if="AdditionalText"  >{{AdditionalText}}<br /></span> 
										<span class="para" ng-if="LessThanMOQ == 'Y' "> Less than minimum quantities are available for a <span class="debossHighlights">${{MOQCharge}}</span> surcharge on ex-stock orders. <br /></span>
										<span class="para"  ng-if="LessThanMOQ == 'N' "> Less than minimum quantities are not available for this item. <br /></span>
										<span class="para" > Prices are in {{FGCurrency}} and exclude GST. <br /></span>
										<span class="para" > Freight is free of charge to one location in  <!--<span ng-if="FGCurrency == 'NZD' " >New Zealand</span><span ng-if="FGCurrency == 'AUD' " >Australia or New Zealand</span>--> New Zealand or Australia. <br /></span>
										<span class="para">Split delivery is available at <span class="debossHighlights">$<?php echo $splitDevCharge; ?></span> per additional delivery location.</span>
									</td> 
								</tr>
										
							</tbody> 
					</table> 
				</div>


				<h4 class='HeaderQuoter'  >Quote Calculator</h4> 

				<div class="datagrid  margin-top" id="datagrid6" >  
					<table class="table table-items table-striped table-bordered table-sm"   border="0" cellspacing="0" cellpadding="0">
							<thead class="thead-dark">
								<tr>
									<th colspan="7" align="center">MARK UP  </th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td width="25%" align="left">  &nbsp; </td>
									<td width="12%" align="center"> <span ng-if="headingQuantity1 != 0">{{priceResults.Quantity1}} </span> </td> 
									<td width="12%" align="center"> <span ng-if="headingQuantity2 != 0">{{priceResults.Quantity2}} </span> </td>
									<td width="12%" align="center"> <span ng-if="headingQuantity3 != 0">{{priceResults.Quantity3}} </span> </td>
									<td width="12%" align="center"> <span ng-if="headingQuantity4 != 0">{{priceResults.Quantity4}} </span> </td>
									<td width="12%" align="center"> <span ng-if="headingQuantity5 != 0">{{priceResults.Quantity5}} </span> </td>
									<td width="12%" align="center"> <span ng-if="headingQuantity6 != 0">{{priceResults.Quantity6}} </span> </td>
								</tr>
								<tr>
									<td width="25%" align="left"> Mark-up % </td>
									<td width="12%" align="center" class="whitebackground"> <input type="text" name="markUp1" class="col-md-12 adjustpadding text-center markInput {{CurrencyUpdate}}markInput1 markInput1"  id="{{CurrencyUpdate}}markInput1"   allow-only-numbers  ng-model="markup1"  ng-keydown="changeTab($event, 1, 4)"  ng-change="getPrice(1, qtyBuyExcludeSetup1, markup1, 'optional')" ng-value="markup1" ng-disabled="disabledQty1" >     </td>
									<td width="12%" align="center" class="whitebackground"> <input type="text" name="markUp2" class="col-md-12 adjustpadding text-center markInput {{CurrencyUpdate}}markInput2 markInput2" id="{{CurrencyUpdate}}markInput2"   allow-only-numbers  ng-model="markup2" ng-keydown="changeTab($event, 2, 4)" ng-change="getPrice(2, qtyBuyExcludeSetup2, markup2,  'optional')" ng-value="markup2"  ng-disabled="disabledQty2" >  </td>
									<td width="12%" align="center" class="whitebackground"> <input type="text" name="markUp3" class="col-md-12 adjustpadding text-center markInput {{CurrencyUpdate}}markInput3 markInput3" id="{{CurrencyUpdate}}markInput3"   allow-only-numbers  ng-model="markup3" ng-keydown="changeTab($event, 3, 4)" ng-change="getPrice(3, qtyBuyExcludeSetup3, markup3,  'optional')" ng-value="markup3"  ng-disabled="disabledQty3" >  </td>
									<td width="12%" align="center" class="whitebackground"> <input type="text" name="markUp4" class="col-md-12 adjustpadding text-center markInput {{CurrencyUpdate}}markInput4 markInput4" id="{{CurrencyUpdate}}markInput4"   allow-only-numbers  ng-model="markup4" ng-keydown="changeTab($event, 4, 4)" ng-change="getPrice(4, qtyBuyExcludeSetup4, markup4,  'optional')" ng-value="markup4"  ng-disabled="disabledQty4" >  </td>
									<td width="12%" align="center" class="whitebackground"> <input type="text" name="markUp5" class="col-md-12 adjustpadding text-center markInput {{CurrencyUpdate}}markInput5 markInput5" id="{{CurrencyUpdate}}markInput5"   allow-only-numbers  ng-model="markup5" ng-keydown="changeTab($event, 5, 4)" ng-change="getPrice(5, qtyBuyExcludeSetup5, markup5,  'optional')" ng-value="markup5"  ng-disabled="disabledQty5" >  </td>
									<td width="12%" align="center" class="whitebackground"> <input type="text" name="markUp6" class="col-md-12 adjustpadding text-center markInput {{CurrencyUpdate}}markInput6 markInput6" id="{{CurrencyUpdate}}markInput6"   allow-only-numbers  ng-model="markup6" ng-keydown="changeTab($event, 6, 4)"  ng-change="getPrice(6, qtyBuyExcludeSetup6, markup6, 'optional')" ng-value="markup6"  ng-disabled="disabledQty6" >  </td>  
								</tr>
								<tr ng-if="showbsetupMarkup"> 
									<td width="25%" align="left"> Setup Mark-up %  </td>
									<td width="12%" align="center" class="whitebackground">  <input type="text" name="setupMarkupsN" class="col-md-12 adjustpadding text-center  markInput" id="setupMarkupsN{{priceResultsUserMarks.setupMarkup}}"   allow-only-numbers  ng-model="priceResultsUserMarks.setupMarkup"  ng-change="getDetailLoopNew(null, priceResultsUserMarks.setupMarkup)" ng-value="priceResultsUserMarks.setupMarkup"> </td>
									<td width="50%" colspan="5"  align="left"> <span class="cursorMarkup" ng-click="setMarkUpNew(priceResultsUserMarks.setupMarkup, markup1, markup2, markup3, markup4, markup5, markup6)">SET MARKUPS AS DEFAULT</span> <span class="markupsave color-green text-success" style="display:none"><i class="fa fa-check"></i></span> </td> 
								</tr>
								<tr ng-if="!showbsetupMarkup">
									<td colspan="7"   align="left"> <span class="cursorMarkup" ng-click="setMarkUpNew(null, markup1, markup2, markup3, markup4, markup5, markup6)">SET MARKUPS AS DEFAULT</span> <span style="display:none" class="markupsave  color-green  text-success"><i class="fa fa-check"></i></span> </td> 
								</tr>
										
							</tbody> 
					</table> 
				</div>


 
				<div class="datagrid  margin-top" id="datagrid6" >  
					<table class="table table-items table-striped table-bordered table-sm"  border="0" cellspacing="0" cellpadding="0">
							<thead class="thead-dark">
								<tr>
									<th colspan="7" align="center"> {{productCode}} - <?=$this->general_model->cleanString(strtoupper($productItem[0]->Name)); ?>  </th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td width="25%" align="left">  &nbsp; </td>
									<td width="12%" align="center"> <span ng-if="headingQuantity1 != 0">{{priceResults.Quantity1}} </span> </td> 
									<td width="12%" align="center"> <span ng-if="headingQuantity2 != 0">{{priceResults.Quantity2}} </span> </td>
									<td width="12%" align="center"> <span ng-if="headingQuantity3 != 0">{{priceResults.Quantity3}} </span> </td>
									<td width="12%" align="center"> <span ng-if="headingQuantity4 != 0">{{priceResults.Quantity4}} </span> </td>
									<td width="12%" align="center"> <span ng-if="headingQuantity5 != 0">{{priceResults.Quantity5}} </span> </td>
									<td width="12%" align="center"> <span ng-if="headingQuantity6 != 0">{{priceResults.Quantity6}} </span> </td>
								</tr>

								<tr ng-if="IncludeFreightUnitPriceNew && selectedFreight != false"  style="display:none" >
									<td width="25%" align="left"> {{selectedFreight.shipName}} </td> 

									<td width="12%" align="center"> <span ng-if="selectedFreight.FreightCost1 == 'FREE' ">FREE</span> <span ng-if="selectedFreight.FreightCost1 != 'FREE' "> ${{selectedFreight.FreightCost1 | number : 2}} </span>   </td> 
									<td width="12%" align="center"> <span ng-if="selectedFreight.FreightCost2 == 'FREE' ">FREE</span> <span ng-if="selectedFreight.FreightCost2 != 'FREE' "> ${{selectedFreight.FreightCost2 | number : 2}} </span>    </td>
									<td width="12%" align="center"> <span ng-if="selectedFreight.FreightCost3 == 'FREE'  ">FREE</span> <span ng-if="selectedFreight.FreightCost3 != 'FREE' "> ${{selectedFreight.FreightCost3 | number : 2}} </span>    </td>
									<td width="12%" align="center"> <span ng-if="selectedFreight.FreightCost4 == 'FREE' ">FREE</span> <span ng-if="selectedFreight.FreightCost4 != 'FREE' "> ${{selectedFreight.FreightCost4 | number : 2}} </span>     </td>
									<td width="12%" align="center"> <span ng-if="selectedFreight.FreightCost5 == 'FREE' ">FREE</span> <span ng-if="selectedFreight.FreightCost5 != 'FREE' "> ${{selectedFreight.FreightCost5 | number : 2}} </span>    </td>
									<td width="12%" align="center"> <span ng-if="selectedFreight.FreightCost6 == 'FREE' ">FREE</span> <span ng-if="selectedFreight.FreightCost6 != 'FREE' "> ${{selectedFreight.FreightCost6 | number : 2}} </span>   </td>
									

								</tr>
								
								<tr>
									<td width="25%" align="left"> Price </td>
									<td width="12%" align="center" > <span ng-if="headingQuantity1 != 0   " ng-show="hideMOQ1" title="Rounded from {{price1 | number : 4}}" >${{price1 | number : 2}} </span> </td>
									<td width="12%" align="center" > <span ng-if="headingQuantity2 != 0  " ng-show="hideMOQ2" title="Rounded from {{price2 | number : 4}}">${{price2 | number : 2}} </span>  </td>
									<td width="12%" align="center" > <span ng-if="headingQuantity3 != 0  " ng-show="hideMOQ3" title="Rounded from {{price3 | number : 4}}">${{price3 | number : 2}} </span> </td>
									<td width="12%" align="center" > <span ng-if="headingQuantity4 != 0  " ng-show="hideMOQ4" title="Rounded from {{price4 | number : 4}}">${{price4 | number : 2}} </span>  </td>
									<td width="12%" align="center" > <span ng-if="headingQuantity5 != 0  " ng-show="hideMOQ5" title="Rounded from {{price5 | number : 4}}">${{price5 | number : 2}} </span> </td>
									<td width="12%" align="center" > <span ng-if="headingQuantity6 != 0  " ng-show="hideMOQ6" title="Rounded from {{price6 | number : 4}}">${{price6 | number : 2}} </span>  </td>
								</tr>
								
							</tbody> 
					</table> 
				</div>
			<?php endif; ?>	
 
			<div class="datagrid margin-top" id="datagrid7"  > 
				<form name="additionalCosts">
					<table class="table table-items table-striped table-bordered table-sm "  border="0" cellspacing="0" cellpadding="0">
						<thead class="thead-dark">
							<tr>
								<th colspan="3" align="center">DETAIL  </th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td width="30%">&nbsp;</td>
								<td width="13%" align="center">Quantity Per Unit </td> 
								<td width="17%" align="center"> Setup Totals</td>
							</tr>
							<tr ng-repeat="additional in detailsArray"  ng-if="additional['additonalperunit'] != 0 || additional['additionalsetup'] != 0" >
								<td  align="left" > {{additional['additionalvalue'] }} </td> 
								<td  align="center" > <span ng-if="additional['additonalperunit'] == 0"> - </span> <span ng-if="additional['additonalperunit'] != 0">{{additional['additionalqty']}}</span>  </td> 
								<td  align="center"> <span ng-if="additional['setupqty'] > 0 && showbsetupMarkup"> ${{additional['soatFinal']}} </span>  <span ng-if="additional['setupqty'] == 0 && showbsetupMarkup && additional['soatFinal'] > 0"> ${{additional['soatFinal']}} </span> <span ng-if="additional['setupqty'] == 0 && showbsetupMarkup && additional['soatFinal'] == 0"> - </span>  <span ng-if="!showbsetupMarkup"> Included </span>  </td>   
							</tr>
							<tr class="backgroundTotalTd" ng-if="showbsetupMarkup">
								<td width="30%" colspan="2"  ><strong>Setup Total:</strong></td> 
								<td width="17%" align="center" class="totalTd"> ${{setupOverAllTotalFinal  | number : 2}} </td>
							</tr>		
							
						</tbody>
					</table>
				</form>	
			</div>	

			<?php if(count($customArray['themeArray']) > 0 || $siteLogcheck['loggedIn'] == 0): ?> 

				<!--Skinned site button quick view-->
				<a href="#" id="btnSaveSkinnedsite" data-toggle="modal" data-target="#quickQuoteModalSkinnedsite"  class="quickQuote margin-top btn btn-dark skinnedQuickButton" ng-show="showData"   > Quick Quote </a> 
													

				<div class="datagrid  margin-top" id="datagrid5" >  
					<table class="table table-items table-striped table-bordered table-sm "   border="0" cellspacing="0" cellpadding="0">
							<thead class="thead-dark">
								<tr>
									<th colspan="7" align="center">INFORMATION</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td width="100%" align="left"  colspan="7" > 

										<span class="para additionaltext"  ng-if="priceResults.AdditionalText" class="font12">{{priceResults.AdditionalText}}<br /></span> 

										<span class="para"  ng-if="PricingInformation1" class="font12">{{PricingInformation1}}<br /></span> 
										<span class="para"  ng-if="!PricingInformation1 && AdditionalText" class="font12">{{AdditionalText}}<br /></span> 
										<span class="para" ng-if="LessThanMOQ == 'Y' &&  allowMOQ == 1">  Less than minimum quantities are available for a <span class="debossHighlights">${{MOQSurcharge}}</span> surcharge on ex-stock orders.<br /> </span>
										<span class="para" ng-if="LessThanMOQ == 'N' &&  allowMOQ == 0">  Less than minimum quantities are not available for this item.<br /> </span>
										<span class="para"  ng-if="!PricingInformation1"  >
											Prices are in  {{FGCurrency}}   and exclude GST.<br />
											Freight is free of charge to one location in {{Place}}.<br />
											Split delivery is available at $<?php echo $splitDevCharge; ?> per location.<br />
										</span> 
										
											<span class="para"  ng-if="PricingInformation2" class="font12">{{PricingInformation2}}<br /></span> 
											<span class="para"  ng-if="PricingInformation3" class="font12">{{PricingInformation3}}<br /></span> 
											<span class="para"  ng-if="PricingInformation4" class="font12">{{PricingInformation4}}<br /></span> 
											<span class="para"  ng-if="PricingInformation5" class="font12">{{PricingInformation5}}<br /></span> 
											<span class="para"  ng-if="PricingInformation6" class="font12">{{PricingInformation6}}<br /></span> 
											<span class="para"  ng-if="PricingInformation7" class="font12">{{PricingInformation7}}<br /></span> 
											<span class="para"  ng-if="PricingInformation8" class="font12">{{PricingInformation8}}<br /></span> 
											<span class="para"  ng-if="PricingInformation9" class="font12">{{PricingInformation9}}<br /></span> 
											<span class="para"  ng-if="PricingInformation10" class="font12">{{PricingInformation10}}<br /></span>  

										
										
										



										
									</td> 
								</tr>
										
							</tbody> 
					</table> 
				</div>

			<?php endif; ?>	


 

<!-- main-->
</div>
<!-- main-->
 
<div ng-show="noData">
	 {{notAvailable}}
</div>

 

 