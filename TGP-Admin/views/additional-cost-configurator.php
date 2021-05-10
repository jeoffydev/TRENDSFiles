

<?php //
    /* at the top of 'check.php' */ 
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) { 
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 ); 
        die( header( 'location: /' ) ); 
    } 
 
?>
<?php include('header.php') ?>

 
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
         
        <li class="breadcrumb-item active">Additional Cost Configurator</li>
      </ol> 
 
     
      
<div class="row margin-bottom additionalpage" ng-cloak> 

    

    <div class="col-md-8"> 

    
<form name="formAdditionalAngular" id="formAdditionalAngular" ng-submit="notificationUpdateData()"     >       
     
     <input type="hidden" ng-model="formUpdateData.itemCode"  />
     <input type="hidden" ng-model="formUpdateData.itemId"  />
     <input type="hidden" ng-model="formUpdateData.itemName"  />  
     <input type="hidden" ng-model="formUpdateData.additionalCostID"  />
     

    <!-- LEFT COLUMN-->
        <div class="row topform">
            <div class="col-md-2  "><h6><strong>Search Item</strong></h6></div>
            <div class="col-md-4 position-relative">
                <input type="text" ng-model="query[queryBy]" class="form-control" placeholder="Ex. 100144 or item name" ng-change="selectItem(query[queryBy])" />
                <div class="additional-config-main">
                    <div class="additional-config-searchbox">
                        <ul class="list-group">
                            <li class="list-group-item cursorpoint" ng-repeat="product in products | filter:query"  ng-click="getThisItem(product.Prim, product.Code, product.Name)" >  {{product.Code}} - {{product.Name}}</li> 
                        </ul>
                            
                    </div>
                </div>    
            </div>

            <div class="col-md-2 text-right">
                <h6>Price Set</h6>
            </div>
            <div class="col-md-4">
                    <select class="form-control selectpicker col-md-6" ng-change="selectAnother(formUpdateData.PriceType, formUpdateData.itemCode)"     name="priceType"    ng-model="formUpdateData.PriceType"  ng-disabled="!formUpdateData.itemCode"   > 
                        <option value=""> Select Price Set </option> 
                        <option  ng-repeat="priceT in  pricingTypeList"  ng-value="priceT.PricingType" > {{priceT.PricingType}} </option>
                    </select> 
                    <!--<select class="form-control selectpicker col-md-5" ng-change="checkIfExist(formUpdateData.itemCode, formUpdateData.PriceType)" ng-disabled="!formUpdateData.itemCode"  name="priceType"  data-ng-options="pt for pt in jsonAdditionals[0].jsonArrays.PriceType" data-ng-model="formUpdateData.PriceType"  > </select> --> 
                 
            </div>

        </div>
        
 

<hr />

 

<div class="alert alert-success" role="alert" ng-if="formEditActive">
    <h6><strong><i class="fa fa-exclamation-triangle"></i> This will update {{itemNameDisplay}}</strong></h6>
</div>


    <div class="alert alert-secondary text-center" role="alert" ng-if="itemNameDisplay"  >
        <h6 ><strong>{{itemNameDisplay}} <span ng-if="converted == 1"> |  <i class="fa fa-exclamation-triangle text-danger"></i> Converted </span> </strong></h6> 
    </div>
     
    <fieldset ng-disabled="!formUpdateData.PriceType">  
        
 
        <div class="row top-allowance">
            <div class="col-md-12  ">
                <h6><strong>1. Select Branding Option</strong></h6>    

                     
 
                <table class="table table-striped additionalTable table-bordered "   > 
                    <tbody>
                        <tr > 
                            <th>Print Method</th>
                            <th>Print Area</th> 
                            <th>Select</th>
                        </tr> 
                       <!-- <tr ng-repeat="bo in jsonAdditionals[0].jsonArrays.BrandingOption" ng-click="formUpdateData.brandingMethod = bo.pm; formUpdateData.brandingArea = bo.pa">  
                           
                                <td> <label for="{{$index}}ID">{{bo.pm}}</label>  </td>
                                <td> <label for="{{$index}}ID">{{bo.pa}}</label> </td> 
                                <td> 
                                    <input type="radio" name="radioSelected" id="{{$index}}ID"   ng-value="bo" ng-checked="(formUpdateData.brandingMethod  == bo.pm && formUpdateData.brandingArea  == bo.pa)" ng-model="formUpdateData.BrandingOption">
                                </td>
                        </tr> -->
                    
                        <tr  ng-repeat="bo in BrandingOptionsList" ng-if="formUpdateData.PriceType == 'Stock' || formUpdateData.PriceType == 'Indent - Air' ||  bo.pm == 'None' "   ng-click="formUpdateData.brandingMethod = bo.pm; formUpdateData.brandingArea = cleanString(bo.pa); checkIfExist(formUpdateData.itemCode, formUpdateData.PriceType, bo.pm)">  
                           
                           <td> <label for="{{$index}}ID">{{bo.pm}}</label>  </td>
                           <td> <label for="{{$index}}ID">{{cleanString(bo.pa)}}</label> </td> 
                           <td>  
                               <input type="radio" name="radioSelected" id="{{$index}}ID"   ng-value="bo"  ng-model="formUpdateData.BrandingOption">
                           </td>
                        </tr>

                         

                    </tbody>
                </table>    
                
            </div>
        </div>
    </fieldset>  
    <hr />

    <fieldset ng-disabled="formDisabled">  
        <div class="row top-allowance">
            <div class="col-md-12  ">
                <h6><strong>2. Pricing</strong></h6>  
                
                <div class="row">
                    <div class="col-md-6">

                        <h6>NZD</h6>  
                        <!--<table class="table table-striped additionalTable"> 
                            <tbody>
                                <tr > 
                                    <th>Description</th>
                                    <th>Unit Cost</th> 
                                    <th>Setup</th>
                                    <th>Select</th>
                                </tr> 
                                <tr ng-repeat="pnzd in jsonAdditionals[0].jsonArrays.Pricing.NZD" ng-click="formUpdateData.costDescription = pnzd.desc">  
                                
                                        <td> <label for="{{$index}}IDnzd">{{pnzd.desc }}</label>  </td>
                                        <td> <label for="{{$index}}IDnzd">{{pnzd.ucost }}</label> </td> 
                                        <td> <label for="{{$index}}IDnzd">{{pnzd.setup}}</label> </td> 
                                        <td> <input type="radio" name="radioSelectedpricingnzd" id="{{$index}}IDnzd"   ng-value="pnzd" ng-checked="(formUpdateData.PrizingNZD.ucost == pnzd.ucost  && formUpdateData.PrizingNZD.setup == pnzd.setup)" ng-model="formUpdateData.PrizingNZD"></td>
                                    
                                </tr> 
                            </tbody>
                        </table>    --> 

                        <table class="table table-striped additionalTable table-bordered"> 
                            <tbody>
                                <tr > 
                                    <th>Description</th>
                                    <th>Unit Cost</th> 
                                    <th>Setup</th>
                                    <th>Select</th>
                                </tr> 
                                <tr ng-repeat="pnzd in thispricingNZD" ng-click="formUpdateData.costDescription = pnzd.desc">  
                                
                                        <td> <label for="{{$index}}IDnzd">{{pnzd.desc }}</label>  </td>
                                        <td> <label for="{{$index}}IDnzd">{{pnzd.ucost }} </label> </td> 
                                        <td> <label for="{{$index}}IDnzd">{{pnzd.setup}}</label> </td> 
                                        <td> <input type="radio" name="radioSelectedpricingnzd" id="{{$index}}IDnzd"   ng-value="pnzd"  ng-model="formUpdateData.PrizingNZD"></td>
                                    
                                </tr> 
                            </tbody>
                        </table> 


                    </div>
                    <div class="col-md-6">
                        <h6>AUD</h6> 
                       <!-- <table class="table table-striped additionalTable"> 
                            <tbody>
                                <tr > 
                                    <th>Description</th>
                                    <th>Unit Cost</th> 
                                    <th>Setup</th>
                                    <th>Select</th>
                                </tr> 
                                <tr ng-repeat="paud in jsonAdditionals[0].jsonArrays.Pricing.AUD">   
                                        <td> <label for="{{$index}}IDaud">{{paud.desc}}</label>  </td>
                                        <td> <label for="{{$index}}IDaud">{{paud.ucost | number:2}}</label> </td> 
                                        <td> <label for="{{$index}}IDaud">{{paud.setup}}</label> </td> 
                                        <td><input type="radio" name="radioSelectedpricingaud" id="{{$index}}IDaud"   ng-value="paud" ng-checked="(formUpdateData.PrizingAUD.ucost == paud.ucost  && formUpdateData.PrizingAUD.setup == paud.setup)" ng-model="formUpdateData.PrizingAUD"></td>
                                    
                                </tr> 
                            </tbody>
                        </table>    -->
                        <table class="table table-striped additionalTable table-bordered"> 
                            <tbody>
                                <tr > 
                                    <th>Description</th>
                                    <th>Unit Cost</th> 
                                    <th>Setup</th>
                                    <th>Select</th>
                                </tr> 
                                <tr ng-repeat="paud in thispricingAUD"  >  
                                
                                        <td> <label for="{{$index}}IDaud">{{paud.desc }}</label>  </td>
                                        <td> <label for="{{$index}}IDaud">{{paud.ucost }}  </label> </td> 
                                        <td> <label for="{{$index}}IDaud">{{paud.setup}}</label> </td> 
                                        <td> <input type="radio" name="radioSelectedpricingaud" id="{{$index}}IDaud"   ng-value="paud"  ng-model="formUpdateData.PrizingAUD"></td>
                                    
                                </tr> 
                            </tbody>
                        </table> 

                    </div>
                </div>
                
            </div>
        </div>

           <hr />
  
        <div class="row top-allowance">
            <div class="col-md-12  ">

                <h6><strong>3. Details</strong></h6>  
                
                <div class="row top-allowance">
                    <div class="col-md-3 text-right">
                            Type:
                    </div>
                    <div class="col-md-9"> 
                         <select class="form-control selectpicker col-md-4"    name="additionalOptionCategory"  data-ng-options="aoc for aoc in jsonAdditionals[0].jsonArrays.additionalOptionCategory" data-ng-model="formUpdateData.additionalOptionCategory"  > </select> 
                    </div>
                </div>

                <div class="row top-allowance">
                    <div class="col-md-3 text-right">
                            Cost Description:
                    </div>
                    <div class="col-md-9">
                            <input type="text" class="form-control col-md-6" ng-model="formUpdateData.costDescription" />
                    </div>
                </div>

                <div class="row top-allowance">
                    <div class="col-md-3 text-right">
                            Branding Method:
                    </div>
                    <div class="col-md-9">
                            <input type="text" class="form-control col-md-6" ng-model="formUpdateData.brandingMethod"   />
                    </div>
                </div>

                <div class="row top-allowance">
                    <div class="col-md-3 text-right">
                            Branding Area:
                    </div>
                    <div class="col-md-9">
                            <input type="text" class="form-control col-md-6" ng-model="formUpdateData.brandingArea"   />
                    </div>
                </div>

                <div class="row top-allowance">
                    <div class="col-md-3 text-right">
                            Maximum per Position:
                    </div>
                    <div class="col-md-9">
                          <input type="number" class="form-control col-md-2" ng-model="formUpdateData.maxPerUnit"   />
                    </div>
                </div>

                <div class="row top-allowance">
                    <div class="col-md-3 text-right">
                            Order:
                    </div>
                    <div class="col-md-9">
                         <input type="number" class="form-control col-md-2" ng-model="formUpdateData.order" ng-change="getTheMax(formUpdateData.itemCode, formUpdateData.PriceType)"  />
                    </div>
                </div>

                <div class="row top-allowance">
                    <div class="col-md-3 text-right">
                            Price per Unit Charge Code:
                    </div>
                    <div class="col-md-9"> 
                            <select class="form-control selectpicker col-md-4" ng-if="componentsAPI.StockCode"   name="unitChargeCode"   ng-model="formUpdateData.componentPricePerUnitItemCode"  > 
                              <option value=""> --select-- </option>
                              <option  ng-value="{{componentsAPI.StockCode}}" ng-if="componentsAPI.ProductClass != 'DC02' "> {{componentsAPI.StockCode}} - {{componentsAPI.ProductClass}} - {{componentsAPI.Description01}}  </option>
                            </select> 

                            <select class="form-control selectpicker col-md-4"  ng-if="!componentsAPI.StockCode"   name="unitChargeCode"   ng-model="formUpdateData.componentPricePerUnitItemCode"  > 
                                <option value=""> --select-- </option>
                                <option  ng-repeat="api in  componentsAPI" ng-value="{{api.StockCode}}" ng-if="api.ProductClass != 'DC02' "> {{api.StockCode}} - {{api.ProductClass}} - {{api.Description01}}  </option>
                            </select> 
                          <!--<input type="number" class="form-control col-md-2" ng-model="formUpdateData.pricePerUnitItemCode"    />-->
                    </div>
                </div>

                 <div class="row top-allowance">
                    <div class="col-md-3 text-right">
                            Price per Order Charge Code:
                    </div>
                    <div class="col-md-9">
                        <!-- <input type="number" class="form-control col-md-2" ng-model="formUpdateData.pricePerOrderCode"  />-->

                         <select class="form-control selectpicker col-md-4"  ng-if="componentsAPI.StockCode"  name="unitChargeCode"   ng-model="formUpdateData.pricePerOrderCode"  > 
                              <option value=""> --select-- </option>
                              <option   ng-value="{{componentsAPI.StockCode}}" ng-if="api.ProductClass != 'DC01' "> {{componentsAPI.StockCode}} - {{componentsAPI.ProductClass}} - {{componentsAPI.Description01}} </option>
                        </select> 


                        <select class="form-control selectpicker col-md-4" ng-if="!componentsAPI.StockCode"   name="unitChargeCode"   ng-model="formUpdateData.pricePerOrderCode"  > 
                              <option value=""> --select-- </option>
                              <option  ng-repeat="api in  componentsAPI" ng-value="{{api.StockCode}}" ng-if="api.ProductClass != 'DC01' "> {{api.StockCode}} - {{api.ProductClass}} - {{api.Description01}}  </option>
                        </select> 
                    </div>
                </div>

                <div class="row top-allowance"> 
                    <div class="col-md-12">
                        <button   type="submit" name="update" class="btn btn-success" ng-disabled="formUpdateData.PriceType  == '--Select--' " > Add to Conversion List <span ng-if="itemNameDisplay"> - </span> {{itemNameDisplay}} </button>
                    </div>
                </div>
                
                <p>&nbsp;</p>
    
                
            </div>
        </div>  
    </fieldset> 
</form>     

    <!-- LEFT COLUMN-->     
    </div> 
    
    <!-- RIGHT COLUMN-->   
    <div class="col-md-4"> 

        <div class="row top-allowance">
            <div class="col-md-12  "> 
                <div class="right-bar border">
                    <h6> Preview</h6>
                    <!--
                    <div class="alert alert-success text-center" role="alert" ng-if="converted == 1" >
                         This item is already converted
                    </div>-->
                

                    <form name="formAdditionalOrder" id="formAdditionalOrder" ng-submit="updateAdditionalOrder()"   >  

                     <ul class="row main-body-featured additionalsort"  ui-sortable ="sortableOptions"  ng-model="dataItems" >
                          
                          <li class="col-md-12 featured-box  deleteThisAdditional{{data.additionalCostID}}"  ng-repeat="data in dataItems"   > 
                                
                                <input type="hidden" class="  form-control" name="additionalOrder[]" type="text" ng-value="{{data.additionalCostID}}" ng-model="data.additionalCostID"      >
                                <a ng-class="(converted == 0 ? 'btn-secondary' : 'btn-trends' )"  class="btn btn-secondary btn-additional-loop btn-full font-13-size" data-toggle="collapse" href="#multiCollapse{{data.additionalCostID}}" role="button" aria-expanded="false" aria-controls="multiCollapse{{data.additionalCostID}}"> {{formUpdateData.itemName}} - {{data.PricingType}} <span ng-if="data.brandingMethod">  / <small> {{data.brandingMethod}}  </small> </span> <span ng-if="data.costDescription">  / <small> {{data.costDescription}}  </small> </span>  </a>
                                <span class="btn btn-danger" ng-if="converted == 0" ng-click="removeAdditionalCost(data.additionalCostID, formUpdateData.itemId, formUpdateData.itemCode, formUpdateData.itemName, data.brandingMethod)"> <i class="fa fa-trash"></i></span>
                                <div class="row">
                                    <div class="col">
                                        <div class="collapse multi-collapse" id="multiCollapse{{data.additionalCostID}}">
                                            <div class="card card-body">

                                                
                                                
                                                <!--<p><span class="btn btn-success" ng-click="editAdditionalCost(data)" > Edit </span></p>-->
                                                <table class="table table-striped "> 
                                                    <tbody>
                                                        <tr> 
                                                            <th width="300">Branding Option</th>
                                                            <td width="600">&nbsp;</td> 
                                                        </tr> 
                                                        <tr> 
                                                            <td>Branding Method:</td>
                                                            <td>  {{data.brandingMethod}} </td> 
                                                        </tr>
                                                        <tr> 
                                                            <td>Branding Area:</td>
                                                            <td>  {{data.brandingArea}} </td> 
                                                        </tr>

                                                        <tr> 
                                                            <th> NZD Pricing</th>
                                                            <td>&nbsp;</td> 
                                                        </tr> 
                                                        <tr> 
                                                            <td>Unit Cost:</td>
                                                            <td>    {{data.NZDUnitPrice}}    </td> 
                                                        </tr> 
                                                        <tr> 
                                                            <td>Setup: </td>
                                                            <td>   {{data.NZDOrderPrice}} </td> 
                                                        </tr> 

                                                        <tr> 
                                                            <th> AUD Pricing</th>
                                                            <td>&nbsp;</td> 
                                                        </tr> 
                                                        <tr> 
                                                            <td>Unit Cost:</td>
                                                            <td>    {{data.AUDUnitPrice}}    </td> 
                                                        </tr> 
                                                        <tr> 
                                                            <td>Setup: </td>
                                                            <td>   {{data.AUDOrderPrice}} </td> 
                                                        </tr> 

                                                        <tr> 
                                                            <th>Details</th>
                                                            <td>&nbsp;</td> 
                                                        </tr> 
                                                        <tr> 
                                                            <td>Type: </td>
                                                            <td> {{data.additionalOptionCategory}} </td> 
                                                        </tr> 
                                                        <tr> 
                                                            <td>Cost Description: </td>
                                                            <td> {{data.costDescription}} </td> 
                                                        </tr> 
                                                        <tr> 
                                                            <td>Maximum per Position: </td>
                                                            <td> {{data.maxPerUnit}} </td> 
                                                        </tr> 
                                                        <tr> 
                                                            <td>Order: </td>
                                                            <td> {{data.orderRow}}  </td> 
                                                        </tr> 
                                                        <tr> 
                                                            <td>Price per Unit Charge Code: </td>
                                                            <td> {{data.pricePerUnitItemCode}} </td> 
                                                        </tr> 
                                                        <tr> 
                                                            <td>Price per Order charge Code: </td>
                                                            <td> {{data.pricePerOrderCode}}  </td> 
                                                        </tr> 

                                                    </tbody>
                                                </table>

                                                <div class="row  margin-top"> 
                                                    <div class="col-md-6 text-left">
                                                        <span class="btn btn-danger" ng-if="converted == 0" ng-click="removeAdditionalCost(data.additionalCostID, formUpdateData.itemId, formUpdateData.itemCode, formUpdateData.itemName)"> <i class="fa fa-trash"></i></span>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <!--<span  class="btn btn-trends btn-sm" ng-if="converted == 0" data-toggle="modal" data-target="#convertModal" ng-click="conversionCheck(data, formUpdateData.itemName, data.additionalCostID); updateAdditionalOrder()" > Convert Data </span>-->
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div> 
                                </div>
                          </li>  
                           
                      </ul>

                    <div class="row  margin-top" ng-if="dataItems[0].converted == 0" >
                        <div class="col-md-12 text-center">
                            <span ng-if="dataItems.length > 1" class=""> <span ng-if="successOrder"><i class="fa fa-check"></i></span> <button type="submit" name="updateOrder" class="btn btn-secondary btn-sm"  > Save Order</button></span> 
                        </div> 
                    </div>
                    
                     
                    
                     </form>


                      <div class="row  margin-top" ng-if="converted == 0" >
                        <div class="col-md-12 text-center">  
                            <span  class="btn btn-trends btn-sm"  ng-show="dataItems.length > 0" data-toggle="modal" data-target="#convertModal" ng-click="conversionCheckNew(dataItems[0].ProductCode, pricingTypeList, itemNameDisplay); updateAdditionalOrder()" > Convert Data </span>    
                        </div> 
                    </div>

                    

                </div>    
            </div>
        </div>
            
    </div>
    <!-- RIGHT COLUMN--> 
</div>    


<!-- Modal -->
<div class="modal fade conversionmodal" id="convertModal" tabindex="-1" role="dialog" aria-labelledby="convertModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="convertModalLabel">Conversion Check -  {{popupName}}    </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

                    <p><small> Clicking convert will update both the old and the new database with the changes. Please double check before clicking convert. </small> </p>
                    <hr />
                    

                    

                    


                    <div class="row" ng-repeat="pricetp in conversionDatasNew.PricingTypes" >
                        <div class="col-md-12">
                            <h5 style="color:#00B0B9"> {{pricetp}} </h5>
                            <hr />


                            <div class="row margin-bottom"  >
                                <div class="col-md-6" >
                                    <div ng-if="$index == 0" >
                                        <h6><strong>Branding Options - Old</strong></h6> 
                                        <ul class="simple">
                                            <li ng-repeat="brand in conversionDatasNew.BrandingOld"> <strong>{{brand.title}}</strong>: {{cleanString(brand.desc)}} </li>
                                        </ul>
                                    </div>    
                                </div> 
                                <div class="col-md-6">
                                    <h6><strong>Branding Options - New</strong></h6> 
                                     
                                    <div class="rowloop margin-bottom" ng-repeat="(key,val) in conversionDatasNew.BrandingOptionsNew" ng-show="key ==  pricetp"  >   
                                        <ul class="simple">
                                            <li ng-repeat="brandnew in val" ng-if="brandnew.brandingMethod != null" > <strong>{{brandnew.brandingMethod}}</strong>: {{cleanString(brandnew.brandingArea)}} </li>  
                                        </ul>
                                    </div>
                                    
                                    
                                </div> 
                            </div>

                            

                            <div class="row ">
                                <div class="col-md-5">
                                    <h6><strong>Additional Costs - NZD - Old</strong></h6>

                                    <table class="table table-striped modalConversion-table table-bordered  ">
                                        <thead>
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">Per Unit</th>
                                                <th scope="col">Setup Charge</th> 
                                            </tr>
                                        </thead>
                                        <tbody ng-repeat="(key,val) in conversionDatasNew.AdditionalCostNZDOld"   > 
                                            <tr ng-repeat="nzdold  in val"  ng-if="nzdold.ptype ==  pricetp" > 
                                                <td>  {{nzdold.desc}}</td>
                                                <td>{{nzdold.unit}}</td>
                                                <td>{{nzdold.setup}}</td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>


                                     <h6><strong>Additional Costs - AUD - Old</strong></h6>

                                    <table class="table table-striped modalConversion-table table-bordered  ">
                                        <thead>
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">Per Unit</th>
                                                <th scope="col">Setup Charge</th> 
                                            </tr>
                                        </thead>
                                        <tbody ng-repeat="(key,val) in conversionDatasNew.AdditionalCostAUDOld"   > 
                                            <tr ng-repeat="audold  in val"  ng-if="audold.ptype ==  pricetp" > 
                                                <td>{{audold.desc}}</td>
                                                <td>{{audold.unit}}</td>
                                                <td>{{audold.setup}}</td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>



                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-6">
                                    <h6><strong>Additional Costs - NZD - New</strong></h6> 
                                    <table class="table table-striped modalConversion-table table-bordered  ">
                                        <thead>
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">Per Unit</th>
                                                <th scope="col">Setup Charge</th> 
                                            </tr>
                                        </thead>
                                        <tbody  ng-repeat="(key,val) in conversionDatasNew.AdditionalCostNZDNew">
                                            <tr ng-repeat="nzdnew in val" ng-if="nzdnew.PricingType ==  pricetp"> 
                                                <td>{{nzdnew.costDescription}}</td>
                                                <td>{{nzdnew.NZDUnitPrice}}</td>
                                                <td>{{nzdnew.NZDOrderPrice}}</td>
                                            </tr>
                                            <tr>
                                            
                                        </tbody>
                                    </table>


                                    <h6><strong>Additional Costs - AUD - New</strong></h6> 
                                    <table class="table table-striped modalConversion-table table-bordered  ">
                                        <thead>
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">Per Unit</th>
                                                <th scope="col">Setup Charge</th> 
                                            </tr>
                                        </thead>
                                        <tbody  ng-repeat="(key,val) in conversionDatasNew.AdditionalCostAUDNew">
                                            <tr ng-repeat="audnew in val" ng-if="audnew.PricingType ==  pricetp"> 
                                                <td>{{audnew.costDescription}}</td>
                                                <td>{{audnew.AUDUnitPrice}}</td>
                                                <td>{{audnew.AUDOrderPrice}}</td>
                                            </tr>
                                            <tr>
                                            
                                        </tbody>
                                    </table>

                                </div> 


                             </div>



                        </div>
                    </div>    
 
                     
                    
                    <p class="margin-top text-right"> <button type="submit" name="convertFinalNew" class="btn btn-trends btn-lg" ng-click="convertToFinalNew(formUpdateData.itemCode, pricingTypeList, formUpdateData.itemId, formUpdateData.itemName)"  > Convert Data </button> </p>
                    <!--<p class="margin-top text-right"> <button type="submit" name="convertFinal" class="btn btn-trends btn-lg" ng-click="convertToFinal(conversionAdditionalcostID, formUpdateData.itemId, formUpdateData.itemCode, formUpdateData.itemName, popupConversion.PricingType)"  > Convert Data </button> </p>-->


      </div>
      
    </div>
  </div>
</div>


<?php include('footer.php') ?>