
<?php //
    /* at the top of 'check.php' */ 
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) { 
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 ); 
        die( header( 'location: /' ) ); 
    } 
 
?>
<?php include('header.php') ?>

  <!-- Breadcrumbs-->
  <ol class="breadcrumb"> <li class="breadcrumb-item active"><i class="fa fa-fw fa-edit"></i> On Demand Stock Management</li> </ol>
   
<div class="row">
    <div class="col-md-12">
            <div class="body-controller" >     
           
           

                  <!--<div class="row">
                    <div class="col-md-6">
                        <div id="imaginary_container"> 
                            <div class="input-group stylish-input-group col-md-10">
                                <input type="text" class="form-control" id="edit-search"  placeholder="Apply Filter Ex. Fan Flyer or 114084" ng-model="query[queryBy]"  data-toggle="tooltip" data-placement="right" title="Click below to select" >
                                <span class="input-group-addon">
                                    <button type="submit">
                                    <i class="fa fa-fw fa-search"></i>
                                    </button>  
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        
                    </div>
                </div>     -->


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">

                            <select class="form-control"  ng-options="option.Prim + ' / ' + option.Code + ' / ' + option.Name   as option.Code + ' - ' + option.Name   for option in products" 
                                    ng-model="selectedItem" 
                                    ng-change="selectItem(selectedItem)">  
                                    <option value="">-- Please choose an item --</option>
                            </select> 
                        </div>  
                    </div>
                    <div class="col-md-6">
                        
                    </div>
                </div>   


                     
            
                    

           <!--
                <div class="main-itemTable" > 

                     
                            <table class="table table-striped table-hover "  >
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>On Demand Stock</th>
                                </tr>
                                <tr ng-repeat="product in products | filter:query" ng-click="selectItem(product.Prim, product.Code, product.Name)" class="productstr active{{product.Prim}}">
                                    <td><span class="edit-product" data-id="{{product.Prim}}" >{{product.Code}}</span></td>
                                    <td><span class="edit-product" data-id="{{product.Prim}}" >{{product.Name}}</a></td>
                                    <td><span class="edit-product" data-id="{{product.Prim}}" >{{product.OnDemandStock}}</a></td>
                                </tr>
                            </table>
                    
                </div> -->


                <p class="margin-top alert alert-warning" ng-if="!editStocks.StocksLists && showNone == '1'"> No stock listed </p>

                <form name="formEditStock" ng-if="editStocks.StocksLists" id="formEditStock" ng-submit="updateStocks()"   >
                    <div class="row margin-top" >
                        <div class="col-md-6">
                            <h5> {{btnCode}} - {{btnName}}</h5>
                            <table class="table table-bordered small-table-font table-sm table-striped" border="0" cellspacing="0" cellpadding="0"  >
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th >Item</th>
                                        <th >In Stock</th>
                                        <th >On Demand</th>
                                        <!--<th >Clear</th>-->
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr ng-repeat="(key,value) in editStocks.StocksLists"> 
                                        <td class="text-left">{{value.PartName}} 
                                            <input type="hidden" class="filter-input col-md-12" ng-model="editStocks.code" ng-value="value.Code"  >
                                            <input type="hidden" class="filter-input col-md-12" ng-model="editStocks.partname" ng-value="value.PartName"  >
                                        </td>
                                        <td class="">{{value.ComponentCode}} <input type="hidden" class="filter-input col-md-12" ng-model="editStocks.component" ng-value="value.ComponentCode"  ></td>
                                        <td class=""> <input type="text" class="filter-input  form-control" ng-model="editStocks.ondemand[key]"  ng-value="value.OnDemandStock"   > </td>
                                        <!--<td> <span class="cursorpoint text-red" ng-if="value.OnDemandStock" ng-click="deleteStock(btnPrim, btnName, value.Code, value.ComponentCode)"><i class="fa fa-eraser"></i></span> </td>-->
                                    </tr>
                                    
                                </tbody>
                                
                            </table>

                        </div>
                        <div class="col-md-6"> &nbsp; </div>
                    </div>
                    <div class="row margin-top margin-bottom" >
                        <div class="col-md-6 text-right">
                            <button type="submit" name="update" class="btn btn-success"  > <i class="fa fa-save"></i> Save {{btnCode}} - {{btnName}}</button>  
                        </div>
                        <div class="col-md-6"> &nbsp; </div>
                    </div>

                    
                </form>
 

                
                     

            </div>            
    </div>
</div>

 
<!--Move Modal-->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
      <div class="modal-body text-center"> 
            <span class="uploader-success"><i class="fa fa-check"></i> {{successMsg}}</span> 
      </div> 
    </div>
  </div>
</div>
 
 

<?php include('footer.php') ?>