
<?php //
    /* at the top of 'check.php' */ 
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) { 
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 ); 
        die( header( 'location: /' ) ); 
    } 
 
?>
<?php include('header.php') ?>

  <!-- Breadcrumbs-->
  <ol class="breadcrumb"> <li class="breadcrumb-item active"><i class="fa fa-fw fa-dollar"></i> Edit Pricing</li> </ol>
   
<div class="row">
    <div class="col-md-12">
            <div class="body-controller" >     
           
              
            <!--<div id="custom-search-input">
                <div class="input-group col-md-4">
                    <input type="text" class="form-control input-lg" placeholder="Ex. Fan FLyer or 114084" ng-model="query[queryBy]"  /> 
                </div>
            </div>-->
            
                <div id="imaginary_container"> 
                    <div class="input-group stylish-input-group col-md-4">
                        <input type="text" class="form-control" id="editpricing-search"  placeholder="Apply Filter Ex. Name or Item Code" ng-model="query[queryBy]"  data-toggle="tooltip" data-placement="right" title="Click below to select" >
                        <span class="input-group-addon">
                            <button type="submit">
                             <i class="fa fa-fw fa-search"></i>
                            </button>  
                        </span>
                    </div>
                </div>
           
                    

           
                <div class="main-itemTable" > 
                            <table class="table table-striped table-hover "  >
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Currency</th>
                                </tr>
                                <tr ng-repeat="pricing in pricings | filter:query" ng-click="selectItem(pricing.index, pricing.Coode, pricing.Currency)">
                                    <td><span class="edit-pricing" data-id="{{pricing.index}}" >{{pricing.Coode}}</span></td>
                                    <td><span class="edit-pricing" data-id="{{pricing.index}}" >{{pricing.Naame}}</a></td>
                                    <td><span class="edit-pricing" data-id="{{pricing.index}}" >{{pricing.Currency}}</a></td>
                                </tr>
                            </table>
                </div> 
                
                
                <!-- Forms --> 
                <div class="main-form margin-top margin-bottom" ng-if="editPricingForms" >    
                <form name="formEditPricingAngular" ng-submit="updatePricing()">
                    <input type="hidden" id="Options" name="Options" value="{{editPricingForms.Options}}"  ng-model="editPricingForms.Options" >
                    <input type="hidden" id="index" name="index"  value="{{editPricingForms.index}}"  ng-model="editPricingForms.index" >
                    <fieldset > 
                        <h4 class="product-title scale-up-center ">{{editPricingForms.Coode}} - {{editPricingForms.Naame}} - <span class="badge badge-secondary">{{editPricingForms.Currency}}</span></h4>
                        <div class="getIndex"  id="{{editPricingForms.index}}"></div>


 
 
<!-- Start Collapse-->
<div class="accordion" id="accordion"> 


 <!-- Collapse 1-->
<div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-link btn-100" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            Main 
        </button>
      </h5>
    </div>

<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
    <div class="card-body">
       


            <div class='row'> 
                        <div class='col-sm-2'>
                            <div class='form-group'>
                                <label for="Coode">Code</label>
                                 <input  class="form-control editInput" id="Coode" name="Coode"  value="{{editPricingForms.Coode}}"   ng-model="editPricingForms.Coode"  size="30" type="text"   /> 
                                <?php  //echo "<pre>"; print_r(getCode($table, 2)); echo "</pre>";  ?>
                                <!--<select class="form-control selectpicker" name="Coode" ng-if="editPricingForms.Coode"  ng-model="editPricingForms.Coode">  
                               <?php  /*  $selectCodes = getCode($table, 2); 
                                        $count = count($selectCodes);
                                        $count = $count - 1; 
                                        for ($i = 0; $i <= $count; $i++){
                                            $lists = $selectCodes[$i]['Code'];
                                            echo '<option value="'.$lists.'"    ng-selected="editPricingForms.Coode === '.$lists.' " >'.$lists.'</option>';  
                                        } */
                                  ?>   
                                </select> -->
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorCode">{{errorCode}}</div>
                            </div>
                        </div>
                        <div class='col-sm-4'>
                            <div class='form-group'>
                                <label for="Naame">Name</label>
                                <input class="form-control editInput" id="Naame" name="Naame"  value="{{editPricingForms.Naame}}"   ng-model="editPricingForms.Naame"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorName">{{errorName}}</div>
                            </div>
                        </div>
                        <div class='col-sm-2'>
                            <div class='form-group'>
                                <label for="Status">Currency</label>
                                <!--<input class="form-control" id="Currency" name="Currency"  value="{{editPricingForms.Currency}}"  ng-model="editPricingForms.Currency" size="30" type="text" />-->
                                <?php $currency = getCurrency(); ?>
                                <select class="form-control selectpicker" name="Currency"  ng-model="editPricingForms.Currency">  
                                        <?php
                                            foreach ($currency as $key => $value){
                                                echo '<option value="'.$value.'"    ng-selected="editPricingForms.Currency === '.$value.' " >'.$value.'</option>';  
                                            }

                                        ?>
                                               
                                </select>       
                                        
                           
                            </div>
                        </div>
                        <div class='col-sm-2'>
                            <div class='form-group'>
                                <label for="PricingType">Pricing Type</label>
                                <input class="form-control" id="PricingType" name="PricingType"  value="{{editPricingForms.PricingType}}"  ng-model="editPricingForms.PricingType" size="30" type="text" />
                            </div>
                        </div>
                        <div class='col-sm-2'>
                            <div class='form-group'>
                                <label for="PriceOrder">Price Order</label>
                                <input class="form-control" id="PriceOrder" name="PriceOrder"  value="{{editPricingForms.PriceOrder}}"  ng-model="editPricingForms.PriceOrder" size="30" type="text" />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorPriceOrder">{{errorPriceOrder}}</div>
                            </div>
                        </div>
            </div>

            <div class='row'> 
                        <div class='col-sm-6'>
                            <div class='form-group'>
                                <label for="PrimaryPriceDes">Primary Price Des</label>
                                <input class="form-control editInput" id="PrimaryPriceDes" name="PrimaryPriceDes"  value="{{editPricingForms.PrimaryPriceDes}}"   ng-model="editPricingForms.PrimaryPriceDes"  size="30" type="text"   />
                                
                            </div>
                        </div>
                        <div class='col-sm-3'>
                            <div class='form-group'>
                                <label for="PriceType">Price Type</label>
                                <input class="form-control" id="PriceType" name="PriceType"  value="{{editPricingForms.PriceType}}"  ng-model="editPricingForms.PriceType" size="30" type="text" />
                            </div>
                        </div>
                       
                        <div class='col-sm-3'>
                            <div class='form-group'>
                                <label for="LessThanMOQ">Less Than MOQ</label>
                                <input class="form-control" id="LessThanMOQ" name="LessThanMOQ"  value="{{editPricingForms.LessThanMOQ}}"  ng-model="editPricingForms.LessThanMOQ" size="30" type="text" />
                            </div>
                        </div>
            </div>




        <!-- Collapse 1-->
        </div>             
    </div>
</div>
  <!-- Collapse 1-->



 <!-- Collapse 2-->
 <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link btn-100" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            Quantity
        </button>
      </h5>
    </div>

<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
    <div class="card-body">
       


            <div class='row'> 
                        <div class='col-sm-2'>
                            <div class='form-group'>
                                <label for="Quantity1">Quantity1</label>
                                <input class="form-control editInput" id="Quantity1" name="Quantity1"  value="{{editPricingForms.Quantity1}}"   ng-model="editPricingForms.Quantity1"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorQuantity1">{{errorQuantity1}}</div>
                            </div>
                        </div>    
                        <div class='col-sm-2'>
                            <div class='form-group'>
                                <label for="Quantity2">Quantity2</label>
                                <input class="form-control editInput" id="Quantity2" name="Quantity2"  value="{{editPricingForms.Quantity2}}"   ng-model="editPricingForms.Quantity2"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorQuantity2">{{errorQuantity2}}</div>
                            </div>
                        </div>    
                        <div class='col-sm-2'>
                            <div class='form-group'>
                                <label for="Quantity3">Quantity3</label>
                                <input class="form-control editInput" id="Quantity3" name="Quantity3"  value="{{editPricingForms.Quantity3}}"   ng-model="editPricingForms.Quantity3"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorQuantity3">{{errorQuantity3}}</div>
                            </div>
                        </div>    
                        <div class='col-sm-2'>
                            <div class='form-group'>
                                <label for="Quantity4">Quantity4</label>
                                <input class="form-control editInput" id="Quantity4" name="Quantity4"  value="{{editPricingForms.Quantity4}}"   ng-model="editPricingForms.Quantity4"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorQuantity4">{{errorQuantity4}}</div>
                            </div>
                        </div>    
                        <div class='col-sm-2'>
                            <div class='form-group'>
                                <label for="Quantity5">Quantity5</label>
                                <input class="form-control editInput" id="Quantity5" name="Quantity5"  value="{{editPricingForms.Quantity5}}"   ng-model="editPricingForms.Quantity5"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorQuantity5">{{errorQuantity5}}</div>
                            </div>
                        </div>     
            </div>

           



        <!-- Collapse 2-->
        </div>             
    </div>
</div>
  <!-- Collapse 2 -->




 <!-- Collapse 3-->
 <div class="card">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-link btn-100" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
            Prices
        </button>
      </h5>
    </div>

<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
    <div class="card-body">
       


            <div class='row'> 
                        <div class='col-sm-2'>
                            <div class='form-group'>
                                <label for="Price1">Price1</label>
                                <input class="form-control editInput" id="Price1" name="Price1"  value="{{editPricingForms.Price1}}"   ng-model="editPricingForms.Price1"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorPrice1">{{errorPrice1}}</div>
                            </div>
                        </div>    
                        <div class='col-sm-2'>
                            <div class='form-group'>
                                <label for="Price2">Price2</label>
                                <input class="form-control editInput" id="Price2" name="Price2"  value="{{editPricingForms.Price2}}"   ng-model="editPricingForms.Price2"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorPrice2">{{errorPrice2}}</div>
                            </div>
                        </div>    
                        <div class='col-sm-2'>
                            <div class='form-group'>
                                <label for="Price3">Price3</label>
                                <input class="form-control editInput" id="Price3" name="Price3"  value="{{editPricingForms.Price3}}"   ng-model="editPricingForms.Price3"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorPrice3">{{errorPrice3}}</div>
                            </div>
                        </div>    
                        <div class='col-sm-2'>
                            <div class='form-group'>
                                <label for="Price4">Price4</label>
                                <input class="form-control editInput" id="Price4" name="Price4"  value="{{editPricingForms.Price4}}"   ng-model="editPricingForms.Price4"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorPrice4">{{errorPrice4}}</div>
                            </div>
                        </div>    
                        <div class='col-sm-2'>
                            <div class='form-group'>
                                <label for="Price5">Price5</label>
                                <input class="form-control editInput" id="Price5" name="Price5"  value="{{editPricingForms.Price5}}"   ng-model="editPricingForms.Price5"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorPrice5">{{errorPrice5}}</div>
                            </div>
                        </div>     
            </div>

           



        <!-- Collapse 3-->
        </div>             
    </div>
</div>
  <!-- Collapse 3 -->




 <!-- Collapse 4-->
 <div class="card">
    <div class="card-header" id="headingFour">
      <h5 class="mb-0">
        <button class="btn btn-link btn-100" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
           Additional Cost and Setup Charge
        </button>
      </h5>
    </div>

<div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
    <div class="card-body">
       
       
<!-- Additional-->
            <div class="row">
                <div class="col-md-6">

                    <div class="card division">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="AdditionalCostDesc1">AdditionalCostDesc1</label>    
                                <input class="form-control editInput" id="AdditionalCostDesc1" name="AdditionalCostDesc1"  value="{{editPricingForms.AdditionalCostDesc1}}"   ng-model="editPricingForms.AdditionalCostDesc1"  size="30" type="text"   />
                            </div>
                            <div class="col-md-3">
                                <label for="AdditionalCost1">AdditionalCost1</label>
                                <input class="form-control editInput" id="AdditionalCost1" name="AdditionalCost1"  value="{{editPricingForms.AdditionalCost1}}"   ng-model="editPricingForms.AdditionalCost1"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorAdditionalCost1">{{errorAdditionalCost1}}</div>
                            </div> 
                            <div class="col-md-3">
                                <label for="SetupCharge1">SetupCharge1</label>
                                <input class="form-control editInput" id="SetupCharge1" name="SetupCharge1"  value="{{editPricingForms.SetupCharge1}}"   ng-model="editPricingForms.SetupCharge1"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorSetupCharge1">{{errorSetupCharge1}}</div>
                            </div> 
                        </div> 
                    </div> 
                    
 
                </div>    
                <div class="col-md-6">


                    <div class="card division">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="AdditionalCostDesc2">AdditionalCostDesc2</label>    
                                <input class="form-control editInput" id="AdditionalCostDesc2" name="AdditionalCostDesc2"  value="{{editPricingForms.AdditionalCostDesc2}}"   ng-model="editPricingForms.AdditionalCostDesc2"  size="30" type="text"   />
                            </div>
                            <div class="col-md-3">
                                <label for="AdditionalCost1">AdditionalCost2</label>
                                <input class="form-control editInput" id="AdditionalCost2" name="AdditionalCost2"  value="{{editPricingForms.AdditionalCost2}}"   ng-model="editPricingForms.AdditionalCost2"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorAdditionalCost2">{{errorAdditionalCost2}}</div>
                            </div> 
                            <div class="col-md-3">
                                <label for="SetupCharge1">SetupCharge2</label>
                                <input class="form-control editInput" id="SetupCharge2" name="SetupCharge2"  value="{{editPricingForms.SetupCharge2}}"   ng-model="editPricingForms.SetupCharge2"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorSetupCharge2">{{errorSetupCharge2}}</div>
                            </div> 
                        </div> 
                    </div> 


                </div> 
            </div>    
<!-- Additional-->



      
<!-- Additional-->
<div class="row margin-division">
                <div class="col-md-6">

                    <div class="card division">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="AdditionalCostDesc3">AdditionalCostDesc3</label>    
                                <input class="form-control editInput" id="AdditionalCostDesc3" name="AdditionalCostDesc3"  value="{{editPricingForms.AdditionalCostDesc3}}"   ng-model="editPricingForms.AdditionalCostDesc3"  size="30" type="text"   />
                            </div>
                            <div class="col-md-3">
                                <label for="AdditionalCost3">AdditionalCost3</label>
                                <input class="form-control editInput" id="AdditionalCost3" name="AdditionalCost3"  value="{{editPricingForms.AdditionalCost3}}"   ng-model="editPricingForms.AdditionalCost3"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorAdditionalCost3">{{errorAdditionalCost3}}</div>
                            </div> 
                            <div class="col-md-3">
                                <label for="SetupCharge3">SetupCharge3</label>
                                <input class="form-control editInput" id="SetupCharge3" name="SetupCharge3"  value="{{editPricingForms.SetupCharge3}}"   ng-model="editPricingForms.SetupCharge3"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorSetupCharge3">{{errorSetupCharge3}}</div>
                            </div> 
                        </div> 
                    </div> 
                    
 
                </div>    
                <div class="col-md-6">


                    <div class="card division">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="AdditionalCostDesc4">AdditionalCostDesc4</label>    
                                <input class="form-control editInput" id="AdditionalCostDesc4" name="AdditionalCostDesc4"  value="{{editPricingForms.AdditionalCostDesc4}}"   ng-model="editPricingForms.AdditionalCostDesc4"  size="30" type="text"   />
                            </div>
                            <div class="col-md-3">
                                <label for="AdditionalCost4">AdditionalCost4</label>
                                <input class="form-control editInput" id="AdditionalCost4" name="AdditionalCost4"  value="{{editPricingForms.AdditionalCost4}}"   ng-model="editPricingForms.AdditionalCost4"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorAdditionalCost4">{{errorAdditionalCost4}}</div>
                            </div> 
                            <div class="col-md-3">
                                <label for="SetupCharge4">SetupCharge4</label>
                                <input class="form-control editInput" id="SetupCharge4" name="SetupCharge4"  value="{{editPricingForms.SetupCharge4}}"   ng-model="editPricingForms.SetupCharge4"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorSetupCharge4">{{errorSetupCharge4}}</div>
                            </div> 
                        </div> 
                    </div> 


                </div> 
            </div>    
<!-- Additional-->






      
<!-- Additional-->
<div class="row margin-division">
                <div class="col-md-6">

                    <div class="card division">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="AdditionalCostDesc3">AdditionalCostDesc5</label>    
                                <input class="form-control editInput" id="AdditionalCostDesc5" name="AdditionalCostDesc5"  value="{{editPricingForms.AdditionalCostDesc5}}"   ng-model="editPricingForms.AdditionalCostDesc5"  size="30" type="text"   />
                            </div>
                            <div class="col-md-3">
                                <label for="AdditionalCost5">AdditionalCost5</label>
                                <input class="form-control editInput" id="AdditionalCost5" name="AdditionalCost5"  value="{{editPricingForms.AdditionalCost5}}"   ng-model="editPricingForms.AdditionalCost5"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorAdditionalCost5">{{errorAdditionalCost5}}</div>
                            </div> 
                            <div class="col-md-3">
                                <label for="SetupCharge5">SetupCharge5</label>
                                <input class="form-control editInput" id="SetupCharge5" name="SetupCharge5"  value="{{editPricingForms.SetupCharge5}}"   ng-model="editPricingForms.SetupCharge5"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorSetupCharge5">{{errorSetupCharge5}}</div>
                            </div> 
                        </div> 
                    </div> 
                    
 
                </div>    
                <div class="col-md-6">


                    <div class="card division">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="AdditionalCostDesc6">AdditionalCostDesc6</label>    
                                <input class="form-control editInput" id="AdditionalCostDesc6" name="AdditionalCostDesc6"  value="{{editPricingForms.AdditionalCostDesc6}}"   ng-model="editPricingForms.AdditionalCostDesc6"  size="30" type="text"   />
                            </div>
                            <div class="col-md-3">
                                <label for="AdditionalCost6">AdditionalCost6</label>
                                <input class="form-control editInput" id="AdditionalCost6" name="AdditionalCost6"  value="{{editPricingForms.AdditionalCost6}}"   ng-model="editPricingForms.AdditionalCost6"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorAdditionalCost6">{{errorAdditionalCost6}}</div>
                            </div> 
                            <div class="col-md-3">
                                <label for="SetupCharge6">SetupCharge6</label>
                                <input class="form-control editInput" id="SetupCharge6" name="SetupCharge6"  value="{{editPricingForms.SetupCharge6}}"   ng-model="editPricingForms.SetupCharge6"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorSetupCharge6">{{errorSetupCharge6}}</div>
                            </div> 
                        </div> 
                    </div> 


                </div> 
            </div>    
<!-- Additional-->




      
<!-- Additional-->
<div class="row margin-division">
                <div class="col-md-6">

                    <div class="card division">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="AdditionalCostDesc7">AdditionalCostDesc7</label>    
                                <input class="form-control editInput" id="AdditionalCostDesc7" name="AdditionalCostDesc7"  value="{{editPricingForms.AdditionalCostDesc7}}"   ng-model="editPricingForms.AdditionalCostDesc7"  size="30" type="text"   />
                            </div>
                            <div class="col-md-3">
                                <label for="AdditionalCost7">AdditionalCost7</label>
                                <input class="form-control editInput" id="AdditionalCost7" name="AdditionalCost7"  value="{{editPricingForms.AdditionalCost7}}"   ng-model="editPricingForms.AdditionalCost7"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorAdditionalCost7">{{errorAdditionalCost7}}</div>
                            </div> 
                            <div class="col-md-3">
                                <label for="SetupCharge7">SetupCharge7</label>
                                <input class="form-control editInput" id="SetupCharge7" name="SetupCharge7"  value="{{editPricingForms.SetupCharge7}}"   ng-model="editPricingForms.SetupCharge7"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorSetupCharge7">{{errorSetupCharge7}}</div>
                            </div> 
                        </div> 
                    </div> 
                    
 
                </div>    
                <div class="col-md-6">


                    <div class="card division">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="AdditionalCostDesc8">AdditionalCostDesc8</label>    
                                <input class="form-control editInput" id="AdditionalCostDesc8" name="AdditionalCostDesc8"  value="{{editPricingForms.AdditionalCostDesc8}}"   ng-model="editPricingForms.AdditionalCostDesc8"  size="30" type="text"   />
                            </div>
                            <div class="col-md-3">
                                <label for="AdditionalCost8">AdditionalCost8</label>
                                <input class="form-control editInput" id="AdditionalCost8" name="AdditionalCost8"  value="{{editPricingForms.AdditionalCost8}}"   ng-model="editPricingForms.AdditionalCost8"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorAdditionalCost8">{{errorAdditionalCost8}}</div>
                            </div> 
                            <div class="col-md-3">
                                <label for="SetupCharge8">SetupCharge8</label>
                                <input class="form-control editInput" id="SetupCharge8" name="SetupCharge8"  value="{{editPricingForms.SetupCharge8}}"   ng-model="editPricingForms.SetupCharge8"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorSetupCharge8">{{errorSetupCharge8}}</div>
                            </div> 
                        </div> 
                    </div> 


                </div> 
            </div>    
<!-- Additional-->






      
<!-- Additional-->
<div class="row margin-division">
                <div class="col-md-6">

                    <div class="card division">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="AdditionalCostDesc9">AdditionalCostDesc9</label>    
                                <input class="form-control editInput" id="AdditionalCostDesc9" name="AdditionalCostDesc9"  value="{{editPricingForms.AdditionalCostDesc9}}"   ng-model="editPricingForms.AdditionalCostDesc9"  size="30" type="text"   />
                            </div>
                            <div class="col-md-3">
                                <label for="AdditionalCost9">AdditionalCost9</label>
                                <input class="form-control editInput" id="AdditionalCost9" name="AdditionalCost9"  value="{{editPricingForms.AdditionalCost9}}"   ng-model="editPricingForms.AdditionalCost9"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorAdditionalCost9">{{errorAdditionalCost9}}</div>
                            </div> 
                            <div class="col-md-3">
                                <label for="SetupCharge9">SetupCharge9</label>
                                <input class="form-control editInput" id="SetupCharge9" name="SetupCharge9"  value="{{editPricingForms.SetupCharge9}}"   ng-model="editPricingForms.SetupCharge9"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorSetupCharge9">{{errorSetupCharge9}}</div>
                            </div> 
                        </div> 
                    </div> 
                    
 
                </div>    
                <div class="col-md-6">


                    <div class="card division">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="AdditionalCostDesc10">AdditionalCostDesc10</label>    
                                <input class="form-control editInput" id="AdditionalCostDesc10" name="AdditionalCostDesc10"  value="{{editPricingForms.AdditionalCostDesc10}}"   ng-model="editPricingForms.AdditionalCostDesc10"  size="30" type="text"   />
                            </div>
                            <div class="col-md-3">
                                <label for="AdditionalCost10">AdditionalCost10</label>
                                <input class="form-control editInput" id="AdditionalCost10" name="AdditionalCost10"  value="{{editPricingForms.AdditionalCost10}}"   ng-model="editPricingForms.AdditionalCost10"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorAdditionalCost10">{{errorAdditionalCost10}}</div>
                            </div> 
                            <div class="col-md-3">
                                <label for="SetupCharge10">SetupCharge10</label>
                                <input class="form-control editInput" id="SetupCharge10" name="SetupCharge10"  value="{{editPricingForms.SetupCharge10}}"   ng-model="editPricingForms.SetupCharge10"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorSetupCharge10">{{errorSetupCharge10}}</div>
                            </div> 
                        </div> 
                    </div> 


                </div> 
            </div>    
<!-- Additional-->





      
<!-- Additional-->
<div class="row margin-division">
                <div class="col-md-6">

                    <div class="card division">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="AdditionalCostDesc11">AdditionalCostDesc11</label>    
                                <input class="form-control editInput" id="AdditionalCostDesc11" name="AdditionalCostDesc11"  value="{{editPricingForms.AdditionalCostDesc11}}"   ng-model="editPricingForms.AdditionalCostDesc11"  size="30" type="text"   />
                            </div>
                            <div class="col-md-3">
                                <label for="AdditionalCost11">AdditionalCost11</label>
                                <input class="form-control editInput" id="AdditionalCost11" name="AdditionalCost11"  value="{{editPricingForms.AdditionalCost11}}"   ng-model="editPricingForms.AdditionalCost11"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorAdditionalCost11">{{errorAdditionalCost11}}</div>
                            </div> 
                            <div class="col-md-3">
                                <label for="SetupCharge11">SetupCharge11</label>
                                <input class="form-control editInput" id="SetupCharge11" name="SetupCharge11"  value="{{editPricingForms.SetupCharge11}}"   ng-model="editPricingForms.SetupCharge11"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorSetupCharge11">{{errorSetupCharge11}}</div>
                            </div> 
                        </div> 
                    </div> 
                    
 
                </div>    
                <div class="col-md-6">


                    <div class="card division">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="AdditionalCostDesc12">AdditionalCostDesc12</label>    
                                <input class="form-control editInput" id="AdditionalCostDesc12" name="AdditionalCostDesc12"  value="{{editPricingForms.AdditionalCostDesc12}}"   ng-model="editPricingForms.AdditionalCostDesc12"  size="30" type="text"   />
                            </div>
                            <div class="col-md-3">
                                <label for="AdditionalCost12">AdditionalCost12</label>
                                <input class="form-control editInput" id="AdditionalCost12" name="AdditionalCost12"  value="{{editPricingForms.AdditionalCost12}}"   ng-model="editPricingForms.AdditionalCost12"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorAdditionalCost12">{{errorAdditionalCost12}}</div>
                            </div> 
                            <div class="col-md-3">
                                <label for="SetupCharge12">SetupCharge12</label>
                                <input class="form-control editInput" id="SetupCharge12" name="SetupCharge12"  value="{{editPricingForms.SetupCharge12}}"   ng-model="editPricingForms.SetupCharge12"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorSetupCharge12">{{errorSetupCharge12}}</div>
                            </div> 
                        </div> 
                    </div> 


                </div> 
            </div>    
<!-- Additional-->





        <!-- Collapse 4-->
        </div>             
    </div>
</div>
  <!-- Collapse 4 -->




 <!-- Collapse 5-->
 <div class="card">
    <div class="card-header" id="headingFive">
      <h5 class="mb-0">
        <button class="btn btn-link btn-100" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
           Additional Text
        </button>
      </h5>
    </div>

<div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
    <div class="card-body">
       
    <textarea class="form-control" id="AdditionalText" name="AdditionalText"    ng-model="editPricingForms.AdditionalText">{{editPricingForms.AdditionalText}}</textarea>



        <!-- Collapse 5-->
        </div>             
    </div>
</div>
  <!-- Collapse 5 -->





</div> <!-- Collapse-->    

 



<div class="modal fade" id="checkTableModal" tabindex="-1" role="dialog" aria-labelledby="checkTableModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Check <?php echo getTheTable($table); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <?php echo checkTheTable($table, 1); ?>
      </div>
      <div class="modal-footer"> 
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
      </div>
    </div>
  </div>
</div>



<div class="row margin-top">
   <!-- <div class="col-md-2"><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#saveChangesModal" >Change Log</button></div> -->
    <div class="col-md-7">
        <button type="submit" name="update" class="btn btn-danger btn-large"  > <i class="fa fa-save"></i> Update Pricing - {{editPricingForms.Naame}} ({{editPricingForms.Currency}})</button>  <span class="updated-check"  ng-show="successUpdate"  > <span ng-if="icon1 == true"><i class="fa fa-times text-red"></i> {{successUpdate}}</span> <span ng-if="icon2 == true"><i class="fa fa-check"></i> {{successUpdate}}</span>  </span>
    </div> 
    <div class="col-md-5 text-right">   
        <span class="btn link"   data-toggle="modal" data-target="#checkTableModal">Check Status</span> <!-- / <span  class="btn link"   data-toggle="modal" data-target="#repairTableModal"  >Repair</span>--> - <?php echo getTheTable($table); ?> 
    </div>
</div>
<p>&nbsp;</p> 

                  
                    
                    </fieldset>
            </form>    
            </div>   
            <!--Forms-->
                     

            </div>            
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="edit-product-results">

            
           
            

        </div>  
    </div>
</div>    

<?php include('footer.php') ?>