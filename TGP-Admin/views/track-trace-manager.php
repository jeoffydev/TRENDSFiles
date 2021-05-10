

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
         
        <li class="breadcrumb-item active"> <i class="fa  fa-plane"></i> Track &amp; Trace Manager</li>
      </ol>

         
      <!-- Icon Cards-->
     
      
<div class="row">
    <div class="col-md-12">
            <div class="body-controller" >     
           
             
            
                                

           
                    

           
                <div class="main-itemTables row" >
                    <div class="col-md-1">&nbsp;</div>
                    <div class="col-md-10" >

                            <h6 class="alert alert-secondary"  ><strong>Add New DHL Tracking Date</strong> </h6>
                            <p class="text-red"><small><i> Required fields: HAWB Reference, Depart Dunedin &amp; Head Port </i></small></p>
                            <form name="addNewDhl" id="addNewDhl" class="addNewDhl" ng-submit="addNewDhlForm()" novalidate  >    
                                    <fieldset  >    
                                        <div class="row ">  
                                            <div class="col-md-2">
                                                <label class="sr-only" for="hawbreference">HAWB Reference</label>
                                                <input type="text" name="hawbreference" class="form-control" id="hawbreference" ng-model="formData.hawbreference" placeholder="HAWB Reference Ex. 7EDY100" ng-change="checkValidateHawb(formData.hawbreference, formData.departdunedin, formData.headport)"  >
                                                <div   class="CodeReq text-red labelreq reqfield" ng-show="exists">{{existsMsg}}</div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="sr-only" for="departdunedin">Depart Dunedin</label>
                                                <input type="text" name="departdunedin" class="form-control" id="departdunedin" ng-model="formData.departdunedin" placeholder="Depart Dunedin (Date only Ex. dd/mm/yyyy)" ng-change="checkValidateHawb(formData.hawbreference, formData.departdunedin, formData.headport)" > 
                                            </div>
                                            <div class="col-md-4">
                                                <label class="sr-only" for="arriveddestination">Arrived Destination</label>
                                                <input type="text" name="arriveddestination" class="form-control" id="arriveddestination" ng-model="formData.arriveddestination" placeholder="Arrived Destination &amp; time (Optional dd/mm/yyyy hh:mm AM/PM)" >
                                            </div>
                                            <div class="col-md-2">
                                                <label class="sr-only" for="headport">Head Port</label>
                                                <input type="text" name="headport" class="form-control" id="headport" ng-model="formData.headport" placeholder="Head Port Ex. PERTH, WA"  ng-change="checkValidateHawb(formData.hawbreference, formData.departdunedin, formData.headport)"   > 
                                                
                                            </div>
                                            <div class="col-md-1">
                                                <input type="submit" class="btn btn-danger btn-small" value="Add Track" ng-disabled= "formBtn"  >
                                            </div> 
                                        </div>
                                    </fieldset> 
                            </form>


                            <div id="imaginary_container" class="margin-top"> 
                                <div class="input-group stylish-input-group col-md-4">
                                    <input type="text" class="form-control" id="edit-search"  placeholder="Search Filter Ex. Hawb or Date" ng-model="query[queryBy]"  data-toggle="tooltip" data-placement="right" title="Click below to select" >
                                    <span class="input-group-addon">
                                        <button type="submit">
                                        <i class="fa fa-fw fa-search"></i>
                                        </button>  
                                    </span>
                                </div> 
                            </div>
                            
                            

                            <table class="table table-striped table-hover margin-top"  >
                                <tr>
                                    <th>Hawb Reference</th>
                                    <th>Depart Dunedin</th> 
                                    <th>Date Arrived Origin</th>
                                    <th>Date Arrived Destination</th>
                                    <th>Head Port</th>
                                    <th>Edit</th>
                                </tr>
                                <tr ng-repeat="product in products | filter:query" ng-click="selectItem(product.Code, product.Name)" ng-if="product.status == 1">
                                    <td><span class="edit-product spanhide spanhide{{product.id}}"  data-id="{{product.id}}" id="spanhide{{product.id}}"   > {{product.HawbReference}}</span>
                                        <!--<input type="text"   name="hawbRef" class="form-control col-md-6 traceEdit  traceEdit{{product.id}}"  ng-class="InputClass"  id=" traceEdit{{product.id}}" ng-model="product.HawbReference"  ng-value="product.HawbReference" >-->
                                    </td>
                                    <td><span class="edit-product" data-id="{{product.id}}" >{{product.departDunedin}} 5:00PM</span></td> 
                                    <td><span class="edit-product" data-id="{{product.id}}" > {{product.arrive}}  </span> </td>
                                    <td><span class="edit-product" data-id="{{product.id}}" > {{product.arriveDestination}}  </span> </td>
                                    <td><span class="edit-product" data-id="{{product.id}}" > {{product.headport}}  </span> </td>
                                    <td><span class="edit-product text-red margin-right" data-id="{{product.id}}" ng-click="openModal(product.id, product.arrive)" title="Update"> <i class="fa  fa-edit"></i> </span> <span class="edit-product text-red" data-id="{{product.id}}" ng-click="deleteDHL(product.id)"  title="Delete DHL Track"> <i class="fa  fa-trash "></i> </span> </td>
                                </tr>
                            </table>

                            <p class="margin-bottom cursorpoint"><span ng-click="refreshList()" class="btn btn-secondary"> <i class="fa fa-sync"></i> Refresh</span></p>
                    </div>
                    <div class="col-md-1">&nbsp;</div>
                </div> 
 
                

                
                  
        
    </div>
  </div>  
</div>    

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
         
      <div class="modal-body"> 

            <h4>Edit DHL Reference {{formUpdate[0].HawbReference}}</h4>
            <!--Editing
            {{formUpdate}} --- 
            <p>{{formUpdate[0].HawbReference}}</p>
            <p>{{formUpdate[0].departDunedin}}</p>
            <p>{{formUpdate.arriveUpdate}}</p>-->

            <form name="updateNewDhl" id="updateNewDhl" class="updateNewDhl"  ng-submit="updateDhlForm(formUpdate[0].id)" novalidate>
                <input type="hidden" name="IDHawbReference" class="form-control" id="IDHawbReference" ng-model="formUpdate[0].id"     > 
                <div class="form-group">
                    <label for="hawbreference"><strong>HAWB Reference</strong></label>
                    <input type="text" name="hawbreference" class="form-control" id="hawbreference" ng-model="formUpdate[0].HawbReference" placeholder="HAWB Reference Ex. 7EDY100"  ng-change="checkValidateHawb(formUpdate[0].HawbReference, formUpdate[0].departDunedin, formData.headport)"  >
                                         
                </div>
                <div class="form-group">
                    <label for="departdunedin"><strong>Depart Dunedin</strong></label>
                    <input type="text" name="departdunedin" class="form-control" id="departdunedin" ng-model="formUpdate[0].departDunedin" placeholder="Depart Dunedin (Date only Ex. dd/mm/yyyy)"   > 
                                            
                </div>
                <div class="form-group">
                    <label  for="arriveddestination"><strong>Date Arrived Origin</strong></label>
                    <input type="text" name="arriveddestination" class="form-control" id="arriveddestination" ng-model="formUpdate.arriveUpdate" disabled  >                    
                </div>
                <div class="form-group">
                    <label  for="arriveDestinationEdit"><strong>Date Arrived Destination (Please include time if necessary)</strong></label>
                    <input type="text" name="arriveDestinationEdit" class="form-control" id="arriveDestinationEdit" ng-model="formUpdate[0].arriveDestination" placeholder="dd/mm/yyyy hh:mm AM/PM"  >                    
                </div>
                <div class="form-group">
                    <label for="headport"><strong>Head Port</strong></label>
                    <input type="text" name="headport" class="form-control" id="headport" ng-model="formUpdate[0].headport"    > 
                                            
                </div>
                <i class="fa  fa-check text-success" style="font-size:24px" ng-if="successCheck"></i> <input type="submit" class="btn btn-danger btn-small" value="Update Track"   > 
            </form>



      </div> 
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" ng-click="refreshList()">Close</button>
        
      </div>
    </div>
  </div>
</div>



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