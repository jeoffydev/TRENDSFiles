
<?php //
    /* at the top of 'check.php' */ 
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) { 
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 ); 
        die( header( 'location: /' ) ); 
    } 
 
?>
<?php include('header.php') ?>

  <!-- Breadcrumbs-->
  <ol class="breadcrumb"> <li class="breadcrumb-item active"><i class="fa  fa-plus"></i>   Add Products </li> </ol>
   
<div class="row">
    <div class="col-md-12">
            <div class="body-controller" >     

                <div class="excel-extension">
                    <h4>TGP Online Excel Browser <span class="cursorpoint" data-toggle="modal" data-target="#infoModal" ><i class="fa fa-info-circle"></i></span></h4> 
                    <div id="newproducts"></div>
                </div>    

                   
                    <div class="row margin-top">
                        <div class="col-md-3">
                            <p><small>Save first to Beta table - productsCurrentBeta</small></p>
                            <input type="button" value="Save  Products to Beta Table"  class="btn btn-danger" id="getDataButton">
                        </div>
                        <div class="col-md-3">
                        <p><small>Check if a duplicate code exists to the table below:</small></p> 
                            
                            <select class="form-control selectpicker col-md-5 selectforward"  name="selectTable"  ng-model="selectTableDuplicate" >  
                                    <option ng-repeat="sels in selectTable" ng-selected="selectTableDuplicate"  ng-value="sels">{{sels}}</option>
                                </select>  
                            <span  class="btn btn-danger buttonforward" ng-click="checkDuplicated(selectTableDuplicate)">Check</span>
                        </div>
                        <div class="col-md-3"> 
                            <form name="formForwardTable" id="formForwardTable" ng-submit="formForwardTableSubmitted()" novalidate > 
                                <p><small>Forward or save the products above to  DEV or Live table</small></p>
                                <!--<select class="form-control selectpicker"  name="selectTable"  data-ng-options="table for table in selectTable" data-ng-model="formForwardTable.selectTableForward" > </select>-->
                                <select class="form-control selectpicker col-md-5 selectforward"  name="selectTable"  ng-model="formForwardTable.selectTableForward" > 
                                    <option value="">Select Table: </option>
                                   <!-- <option ng-repeat="sels in selectTable"  ng-value="sels">{{sels}}</option> -->
                                </select> 
                                <button type="submit" name="selectTableForward" ng-disabled="!formForwardTable.selectTableForward" class="btn btn-danger margin-top-light buttonforward  " >Save and copy items</button> 
                            </form> 
                        </div> 
                       
                        <div class="col-md-3">
                        <p><small>Clear and delete all the items on table - productsCurrentBeta</small></p> 
                            <input type="button" value="Clear"  class="btn btn-danger" id="deleteDataButton">
                        </div>
                    </div>
                
                <p>&nbsp; </p>       
                     

            </div>            
    </div>
</div>

 <!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="infoModalLabel">How to use TGP Online Excel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <ol>
             <li>Make sure first your excel headings and database columns are matched. <br /><img src="<?php echo $baseUrl; ?>/assets/images/info-columns.jpg" class="img-thumbnail" />  </li>
             <li>Copy the items in your excel and paste it into the TGP Excel online browser. <br /><img src="<?php echo $baseUrl; ?>/assets/images/info-copy.jpg" class="img-thumbnail" /> </li>
             <li>Check and save the data on beta table - 'productsCurrentBETA'. <br /><img src="<?php echo $baseUrl; ?>/assets/images/info-save.jpg" class="img-thumbnail" /> </li>
             <li>You can edit, modify the data and click the same button to update. </li>
             <li>Right click on the TGP excel columns to add or delete rows. </li>
             <li>If all is good, you can forward and insert the new items by selecting the table below. <br /><img src="<?php echo $baseUrl; ?>/assets/images/info-forward.jpg" class="img-thumbnail" /></li>
             <li>Click 'Clear' button if you want to remove all the items on TGP Excel window.</li>   
        </ol>    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
      </div>
    </div>
  </div>
</div>
 
<!-- suucess Modal-->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
      <div class="modal-body text-center"> 
            <span class="uploader-success"><i class="fa fa-check"></i> {{successMsg}}</span> 
      </div> 
    </div>
  </div>
</div>


 
<!-- Duplicates Modal-->
<div class="modal fade" id="duplicatesModal" tabindex="-1" role="dialog" aria-labelledby="duplicatesModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 

        <div class="modal-header">
            <h6 class="modal-title"> List(s) of duplicate Code(s) in table {{ duplicatesTable }}</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
             <ul>
                <li ng-repeat="dups in duplicatesCode">   
                {{ dups.Code }}
                </li>
             </ul>   
        </div>
        <div class="modal-footer"> 
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

      
    </div>
  </div>
</div>


<?php include('footer.php') ?>