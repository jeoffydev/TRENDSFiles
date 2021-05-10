 

<!-- PRICING CHANGES WITH IMAGE SCREENSHOT QUOTE -->
<?php if(count($customArray['themeArray']) == 0 || $siteLogcheck['loggedIn'] == 1):  ?> 
		<div style="opacity:0; display: none; font-family: Verdana, 'Open Sans', Geneva, sans-serif;   font-style: normal; font-variant: normal; width:949px;   " class="hidequote" ng-cloak  >

		 
			<div class="datagrid datagridEight margin-top" id="datagrid8" style="width:949px;   padding:25px 25px 23px ">  
				<h4 style="     font-weight: 500 !important; font-size: 29px; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;">  <?=$productItem[0]->Code?> -  <?=$productItem[0]->Name?>  </h4> 
				<div class="row productTable-row">
					<div class="col-md-4 quick-4"  >
					<img src="<?=base_url()?>Images/ProductImgSML/<?=$productItem[0]->Code?>.jpg" style="width:100%; height:auto" ng-if="!imgNum" />
						<img src="<?=base_url()?>resizer/470/<?=$productItem[0]->Code?>-{{imgNum}}.jpg" style="width:100%; height:auto" ng-if="imgNum" />
					</div>
					<div class="col-md-8 quick-8" style="padding-left:0">

						<p class="productTable-description"><?=$productItem[0]->Description?></p>
						<form name="additionalCosts">

							<div class="row" style="max-width: 598px; margin-left:0px; margin-bottom:20px">
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-12" style="background: #626469; color: #fff; text-align: center; padding:5px; font-size:15px">  <strong>{{productCode}} - <?php echo strtoupper($productItem[0]->Name); ?></strong>  </div>
									</div>
									<div class="row">
										<div class="col-md-3" style="max-width:20% !important;   border-left:1px solid #63676b; padding-right: 0px; padding-left: 0px;   ">   </div>
										<div class="col-md-2 text-center" style="max-width:13.3% !important; border-left:1px solid #63676b; padding-right: 0px; padding-left: 0px;  ">   <span ng-if="headingQuantity1 != 0">{{priceResults.Quantity1}} </span> </div> 
										<div class="col-md-2 text-center" style="max-width:13.3% !important; border-left:1px solid #63676b;  padding-right: 0px; padding-left: 0px;  "> <span ng-if="headingQuantity2 != 0">{{priceResults.Quantity2}} </span> </div> 
										<div class="col-md-2 text-center" style="max-width:13.3% !important; border-left:1px solid #63676b;  padding-right: 0px; padding-left: 0px;  "> <span ng-if="headingQuantity3 != 0">{{priceResults.Quantity3}} </span> </div> 
										<div class="col-md-2 text-center" style="max-width:13.3% !important; border-left:1px solid #63676b; padding-right: 0px; padding-left: 0px;   "> <span ng-if="headingQuantity4 != 0">{{priceResults.Quantity4}} </span> </div> 
										<div class="col-md-2 text-center" style="max-width:13.3% !important; border-left:1px solid #63676b;  padding-right: 0px; padding-left: 0px;  "> <span ng-if="headingQuantity5 != 0">{{priceResults.Quantity5}} </span> </div> 
										<div class="col-md-2 text-center" style="max-width:13.5% !important; border-left:1px solid #63676b; border-right:1px solid #63676b;   padding-right: 5px; padding-left: 5px;  "> <span ng-if="headingQuantity6 != 0">{{priceResults.Quantity6}} </span> </div>  
									</div>
									<div class="row" style="border-top:1px solid #63676b;  font-size:14px; ">
										<div class="col-md-3 text-left" style="max-width:20% !important; border-left:1px solid #63676b; font-size:14px; padding-right: 5px; padding-left: 5px;  ">  Price (per unit) {{buysetup}}  </div>
										<div class="col-md-2 text-center" style="max-width:13.3% !important; border-left:1px solid #63676b;  padding-right: 0px; padding-left: 0px; ">   <span ng-if="headingQuantity1 != 0" ng-show="hideMOQ1">${{price1 | number : 2}} </span>  </div> 
										<div class="col-md-2 text-center" style="max-width:13.3% !important; border-left:1px solid #63676b;  padding-right: 0px; padding-left: 0px;  "> <span ng-if="headingQuantity2 != 0" ng-show="hideMOQ2">${{price2 | number : 2}} </span>  </div> 
										<div class="col-md-2 text-center" style="max-width:13.3% !important; border-left:1px solid #63676b;  padding-right: 0px; padding-left: 0px;  "> <span ng-if="headingQuantity3 != 0" ng-show="hideMOQ3">${{price3 | number : 2}} </span> </div> 
										<div class="col-md-2 text-center" style="max-width:13.3% !important; border-left:1px solid #63676b;  padding-right: 0px; padding-left: 0px;  ">  <span ng-if="headingQuantity4 != 0" ng-show="hideMOQ4">${{price4 | number : 2}} </span> </div> 
										<div class="col-md-2 text-center" style="max-width:13.3% !important; border-left:1px solid #63676b;  padding-right: 0px; padding-left: 0px;  "> <span ng-if="headingQuantity5 != 0"> ${{price5 | number : 2}}  </span> </div> 
										<div class="col-md-2 text-center" style="max-width:13.5% !important; border-left:1px solid #63676b; border-right:1px solid #63676b;  padding-right: 0px; padding-left: 0px;   "> <span ng-if="headingQuantity6 != 0" ng-show="hideMOQ6">${{price6 | number : 2}} </span></div>  
									</div>
									<div class="row" style="border-top:1px solid #63676b; border-bottom:1px solid #63676b; font-size:14px;">
										<div class="col-md-3 text-left" style="max-width:20% !important; border-left:1px solid #63676b;  font-size:14px; padding-right: 5px; padding-left: 5px;   ">  Price (total) {{buysetup}}  </div>
										<div class="col-md-2 text-center" style="max-width:13.3% !important; border-left:1px solid #63676b;  padding-right: 0px; padding-left: 0px;  font-size:13px" >   <span ng-if="headingQuantity1 != 0" ng-show="hideMOQ1"> ${{ priceResults.Quantity1    * (price1 | number : 2)  | number : 2  }}  </span>  </div> 
										<div class="col-md-2 text-center" style="max-width:13.3% !important; border-left:1px solid #63676b;  padding-right: 0px; padding-left: 0px; font-size:13px "> <span ng-if="headingQuantity2 != 0" ng-show="hideMOQ2"> ${{  priceResults.Quantity2  * (price2 | number : 2) | number : 2  }}  </span>  </div> 
										<div class="col-md-2 text-center" style="max-width:13.3% !important; border-left:1px solid #63676b;  padding-right: 0px; padding-left: 0px; font-size:13px "> <span ng-if="headingQuantity3 != 0" ng-show="hideMOQ3"> ${{ priceResults.Quantity3  * (price3 | number : 2)  | number : 2 }} </span> </div> 
										<div class="col-md-2 text-center" style="max-width:13.3% !important; border-left:1px solid #63676b;  padding-right: 0px; padding-left: 0px; font-size:13px ">  <span ng-if="headingQuantity4 != 0" ng-show="hideMOQ4"> ${{ priceResults.Quantity4   * (price4 | number : 2)   | number : 2 }} </span> </div> 
										<div class="col-md-2 text-center" style="max-width:13.3% !important; border-left:1px solid #63676b; padding-right: 0px; padding-left: 0px; font-size:13px    "> <span ng-if="headingQuantity5 != 0"> ${{ priceResults.Quantity5  * (price5 | number : 2)  | number : 2 }} </span> </div> 
										<div class="col-md-2 text-center" style="max-width:13.5% !important; border-left:1px solid #63676b; border-right:1px solid #63676b;   padding-right: 0px; padding-left: 0px; font-size:13px "> <span ng-if="headingQuantity6 != 0" ng-show="hideMOQ6"> ${{ priceResults.Quantity6  * (price6 | number : 2)  | number : 2 }} </span></div>  
									</div>
								</div>
							</div>


							<div class="row" style="max-width: 598px; margin-left:0px; margin-bottom:20px">
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-12" style="background: #626469; color: #fff; text-align: center; padding:5px; font-size:15px">  <strong>DETAIL  </strong>  </div>
									</div>
									<div class="row">
										<div class="col-md-6" style="border-left:1px solid #63676b;    ">   </div>
										<div class="col-md-3 text-center" style="border-left:1px solid #63676b;   ">  Qty Per Unit  </div> 
										<div class="col-md-3 text-center" style="border-left:1px solid #63676b;   border-right:1px solid #63676b;  "> Setup </div> 
										 
									</div>
									<div class="row" style="border-top:1px solid #63676b;"      ng-repeat="additional in detailsArray"  ng-if="additional['additonalperunit'] != 0 || additional['additionalsetup'] != 0" >
										<div class="col-md-6" style="border-left:1px solid #63676b;    "> {{additional['additionalvalue'] }}   </div>
										<div class="col-md-3 text-center" style="border-left:1px solid #63676b;   ">  <span ng-if="additional['additonalperunit'] == 0"> - </span> <span ng-if="additional['additonalperunit'] != 0">{{additional['additionalqty']}}</span>  </div> 
										<div class="col-md-3 text-center" style="border-left:1px solid #63676b;  border-right:1px solid #63676b;   "> <span ng-if="additional['setupqty'] > 0 && showbsetupMarkup"> ${{additional['soatFinal']}} </span>  <span ng-if="additional['setupqty'] == 0 && showbsetupMarkup && additional['soatFinal'] > 0"> ${{additional['soatFinal']}} </span> <span ng-if="additional['setupqty'] == 0 && showbsetupMarkup && additional['soatFinal'] == 0"> - </span>  <span ng-if="!showbsetupMarkup"> Included </span>  </div>  
									</div> 
									<div class="row" style="border-top:1px solid #63676b;"       ng-if="!showbsetupMarkup" > </div>

									<div class="row"   ng-if="showbsetupMarkup"  style="border-top:1px solid #63676b; border-bottom:1px solid #63676b;"   >
										<div class="col-md-9" style="border-left:1px solid #63676b;    "><strong>Setup Total:</strong>  </div>
										<div class="col-md-3 text-center" style="border-left:1px solid #63676b; border-right:1px solid #63676b;    "> ${{setupOverAllTotalFinal  | number : 2}}  </div> 
									</div>

									
									 
								</div>
							</div>
 

						</form>	

						<!-- changes on module.css and added controller on Scripts/app.js and angularscriptpost.php -->
						<p class=" font-tablequote" style="margin-bottom:0px; "> 
 	
							<span   ng-if="quickComment == '2'" > {{quickQuoteComment}}</span> <span ng-if="quickComment == '1' " ng-bind-html="quickMessage | trust"></span> <span ng-if="quickComment == '0'  "    > {{quickMessage}} </span> 
							 
						
						</p>
						 
					</div>
				</div>			
			</div>	
		</div>	
<?php endif; ?>	




<?php if(count($customArray['themeArray']) > 0 || $siteLogcheck['loggedIn'] == 0): ?> 
<div style="opacity:0; display:none; font-family: Verdana, 'Open Sans', Geneva, sans-serif;   font-style: normal; font-variant: normal; width:949px;   " class="hidequote" ng-cloak  >

		 
			<div class="datagrid datagridEight margin-top" id="datagrid8" style="width:949px;   color:#<?=$customArray['themeArray'][0]->paragraphTextColour?>">  
				
					<?php  $logoLocation = '/Images/TopMenu/customerLogos/'.$customArray['themeArray'][0]->themeID.'.png';   
							if(file_exists($_SERVER['DOCUMENT_ROOT'].$logoLocation)): ?> 
							<div class="logo-qv-container" style="padding:10px 7px; background-color:#<?=$customArray['themeArray'][0]->headerBackground?>;  ">
								<img src="<?=base_url()?>Images/TopMenu/customerLogos/<?=$customArray['themeArray'][0]->themeID?>.png" style="max-height: 70px;"  /> 
							</div>	
					<?php endif; ?>	

				<div style="padding:25px 25px 23px; background-color:#<?=$customArray['themeArray'][0]->BackgroundColour?>;"> 	
							
					<h4 style="margin-top:14px;     font-weight: 500 !important; font-size: 29px; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;">  <?=$productItem[0]->Code?> -  <?=$productItem[0]->Name?>  </h4> 
					<div class="row productTable-row">
						<div class="col-md-4 quick-4"  >
						<img src="<?=base_url()?>Images/ProductImgSML/<?=$productItem[0]->Code?>.jpg" style="width:100%; height:auto" ng-if="!imgNum" />
							<img src="<?=base_url()?>resizer/470/<?=$productItem[0]->Code?>-{{imgNum}}.jpg" style="width:100%; height:auto" ng-if="imgNum" />
						</div>
						<div class="col-md-8 quick-8" style="padding-left:0">

							<p class="productTable-description" style="margin-bottom:1rem !important; "><?=$this->general_model->cleanString($productItem[0]->Description)?></p>

							<!--Pricing-->	
							<div class="datagrid   table-responsive" id="datagrid3" style="position:relative; top:-2px;" > 
								<form name="priceSummary">
									<table class="table table-items table-striped  table-bordered table-sm table-small-font"   border="0" cellspacing="0" cellpadding="0">
										<thead class="thead-dark">
											<tr>
												
													<th colspan="7" align="center"> PRICING</th> 
											
											</tr>
										</thead>
										<tbody>
											<tr>
												<td width="25%" align="left">Quantity</td>
												<td width="12%" align="center"  >    {{priceResults.Quantity1}}  </td>
												<td width="12%" align="center"   > {{priceResults.Quantity2}}  </td>
												<td width="12%" align="center" >  {{priceResults.Quantity3}}  </td>
												<td width="12%" align="center"   >  {{priceResults.Quantity4}}  </td>
												<td width="12%" align="center"   >  {{priceResults.Quantity5}}  </td>
												<td width="12%" align="center"   >  {{priceResults.Quantity6}}  </td> 
											
											</tr>
											
											<tr ng-if="qtyBuyExcludeSetupAlls">

												
													<td width="25%" align="left"> <span>Buy (ea) {{buysetup}}   </span> </td> 

													<td width="12%" align="center"> <span ng-if="priceResults.Quantity1 != 0 " ng-show="hideMOQ1" title="Rounded from {{qtyBuyExcludeSetup1 | number : 4}}"   > ${{qtyBuyExcludeSetup1 | number : 2}}  </span>   &nbsp; </td>
													<td width="12%" align="center"> <span ng-if="priceResults.Quantity2 != 0 " ng-show="hideMOQ2" title="Rounded from {{qtyBuyExcludeSetup2 | number : 4}}"  > ${{qtyBuyExcludeSetup2 | number : 2}}  </span> </td>
													<td width="12%" align="center"> <span ng-if="priceResults.Quantity3 != 0 " ng-show="hideMOQ3" title="Rounded from {{qtyBuyExcludeSetup3 | number : 4}}"  > ${{qtyBuyExcludeSetup3 | number : 2}}</span> </td>
													<td width="12%" align="center"> <span ng-if="priceResults.Quantity4 != 0 " ng-show="hideMOQ4" title="Rounded from {{qtyBuyExcludeSetup4 | number : 4}}"   > ${{qtyBuyExcludeSetup4 | number : 2}}</span> </td>
													<td width="12%" align="center"> <span ng-if="priceResults.Quantity5 != 0 " ng-show="hideMOQ5" title="Rounded from {{qtyBuyExcludeSetup5 | number : 4}}"   > ${{qtyBuyExcludeSetup5 | number : 2}}</span> </td>
													<td width="12%" align="center"> <span ng-if="priceResults.Quantity6 != 0 " ng-show="hideMOQ6" title="Rounded from {{qtyBuyExcludeSetup6 | number : 4}}" > ${{qtyBuyExcludeSetup6 | number : 2}}</span> </td> 

												
												
											</tr>  

											<tr ng-if="qtyBuyExcludeSetupAlls">
												<td width="25%" align="left"> <span>Buy (total) {{buysetup}}  {{incFreightMsg}}  </span> </td>
												<td width="12%" align="center"> <span ng-if="priceResults.Quantity1 != 0 " ng-show="hideMOQ1"> ${{qtyBuyExcludeTotal1 | customNumber}} </span> &nbsp; </td>
												<td width="12%" align="center"> <span ng-if="priceResults.Quantity2 != 0 " ng-show="hideMOQ2"> ${{qtyBuyExcludeTotal2 | customNumber}} </span> </td>
												<td width="12%" align="center"> <span ng-if="priceResults.Quantity3 != 0  " ng-show="hideMOQ3"> ${{qtyBuyExcludeTotal3 | customNumber}}</span> </td>
												<td width="12%" align="center"> <span ng-if="priceResults.Quantity4 != 0 " ng-show="hideMOQ4"> ${{qtyBuyExcludeTotal4 | customNumber}}</span> </td>
												<td width="12%" align="center"> <span ng-if="priceResults.Quantity5 != 0  " ng-show="hideMOQ5"> ${{qtyBuyExcludeTotal5 | customNumber}}</span> </td>
												<td width="12%" align="center"> <span ng-if="priceResults.Quantity6 != 0" ng-show="hideMOQ6"> ${{qtyBuyExcludeTotal6 | customNumber}}</span> </td>
											</tr>         
										

										</tbody> 
									</table>
								
									
								</form>	
								
							</div>	

							<!--Details section-->
							<div class="datagrid  " id="datagrid7"  > 
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


							<!-- Information--> 

							
							<div class="datagrid  " id="datagrid5" ng-if="PricingInformation1" style="font-size:11px; position:relative; top:-2px;  " >  
								

													<span class="para additionaltext"  ng-if="priceResults.AdditionalText" class="font12">{{priceResults.AdditionalText}}<br /></span> 

													

													<span class="para"  ng-if="PricingInformation1" class="font12">&bull; {{PricingInformation1}}<br /></span> 

													<span class="para" ng-if="LessThanMOQ == 'Y' &&  allowMOQ == 1">&bull;  Less than minimum quantities are available for a <span class="debossHighlights">${{MOQSurcharge}}</span> surcharge on ex-stock orders.<br /> </span>
													<span class="para" ng-if="LessThanMOQ == 'N' &&  allowMOQ == 0">&bull;  Less than minimum quantities are not available for this item.<br /> </span>
													
														<span class="para"  ng-if="PricingInformation2" class="font12">&bull; {{PricingInformation2}}<br /></span> 
														<span class="para"  ng-if="PricingInformation3" class="font12">&bull; {{PricingInformation3}}<br /></span> 
														<span class="para"  ng-if="PricingInformation4" class="font12">&bull; {{PricingInformation4}}<br /></span> 
														<span class="para"  ng-if="PricingInformation5" class="font12">&bull; {{PricingInformation5}}<br /></span> 
														<span class="para"  ng-if="PricingInformation6" class="font12">&bull; {{PricingInformation6}}<br /></span> 
														<span class="para"  ng-if="PricingInformation7" class="font12">&bull; {{PricingInformation7}}<br /></span> 
														<span class="para"  ng-if="PricingInformation8" class="font12">&bull; {{PricingInformation8}}<br /></span> 
														<span class="para"  ng-if="PricingInformation9" class="font12">&bull; {{PricingInformation9}}<br /></span> 
														<span class="para"  ng-if="PricingInformation10" class="font12">&bull; {{PricingInformation10}}<br /></span>  

													
													
													



										
							</div>
							<!-- Information--> 


							
	
						</div>
					</div>	
				
				

				</div><!--padding-->	


			</div>	
</div>	

<?php endif; ?>