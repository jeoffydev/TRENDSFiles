

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
         
        <li class="breadcrumb-item active">Compliance Manager</li>
      </ol>

         
      <!-- Icon Cards-->
     
      
<div class="row">
    <div class="col-md-12">
            <div class="body-controller" >     
           
             
            
                <div id="imaginary_container"> 
                    <div class="input-group stylish-input-group col-md-4">
                        <input type="text" class="form-control" id="edit-search"  placeholder="Apply Filter Ex. Fan Flyer or 114084" ng-model="query[queryBy]"  data-toggle="tooltip" data-placement="right" title="Click below to select" >
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
                                    <th>Status</th>
                                </tr>
                                <tr ng-repeat="product in products | filter:query" ng-click="selectItem(product.Code, product.Name)">
                                    <td><span class="edit-product" data-id="{{product.Prim}}" >{{product.Code}}</span></td>
                                    <td><span class="edit-product" data-id="{{product.Prim}}" >{{product.Name}}</a></td> 
                                    <td><span class="edit-product" data-id="{{product.Prim}}" >{{product.Active}}</a></td>
                                </tr>
                            </table>
                    
                </div> 

                <div class="main-form margin-top margin-bottom" ng-if="editCompliance" >   

                         <h4 class="alert alert-secondary"> {{itemName}} - {{pdfCode}} </h4>
                           
                          <form name="pdfForm" id="pdfForm" ng-app="fileUpload"     >
                             <div class="row">
                                 <div class="col-md-3"> 
                                    <label for="standard"><i class="fa fa-bars" aria-hidden="true"></i> Standard</label>
									<input class="form-control" name="standard" id="standard" placeholder="Enter Compliance Name"   minlength="2" type="text" value="{{editCompliance.PDFName}}"  ng-model="editCompliance.PDFName">
                                </div>
                                <div class="col-md-5"> 
                                    <label for="standard"><i class="fa fa-commenting" aria-hidden="true"></i> Description</label>
									<input class="form-control" name="description" id="description" placeholder="Enter Description"  minlength="2" type="text" value="{{editCompliance.PDFDesc}}"  ng-model="editCompliance.PDFDesc">
                                </div>
                                <div class="col-md-2"> 
                                    <label for="standard"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Upload PDF</label> 
                                    <input type="file" id="mainfileUpload" class="form-control" ngf-select ng-model="picFile" name="file" ng-disabled = "!editCompliance.PDFName"  ng-change="checkPDF(picFile)"   accept="application/pdf"   ngf-model-invalid="errorFile"> 
                                </div>
                                <div class="col-md-2"> 
                                    <label for="standard"> &nbsp;</label>
									<button type="submit" name="insertPDF" class="btn btn-danger"  ng-click="uploadPic(picFile, fileNull)" ng-disabled = "!editCompliance.PDFName" style="position:relative; top:45%" > <i class="fa fa-save"></i> Save and Upload PDF</button>
                                </div>
                             </div>
                         </form> 

                         <!--
                         <form ng-app="fileUpload"   name="form">
                         <input type="file" ngf-select ng-model="picFile" name="file"    
                            accept="file/*" ngf-max-size="2MB" required
                            ngf-model-invalid="errorFile">
                            <button   ng-click="uploadPic(picFile)">Submit</button>
                            </form> -->
                        <p>&nbsp; </p>  
                        <div class="lists-pdf margin-top" ng-if="resultPDFCount > 0"> 
                            <ul class=" margin-top main-body-pdf"  ui-sortable = "sortableOptions"  ng-model="pdfCompliance" > 
                                <li class="col-md-12 pdf-box removePDF " ng-repeat="pdfItems in pdfCompliance"> 
                                    <div class="pdfItem-box "    > 
                                        <div class="row">
                                            <div class="col-md-1 text-center">
                                            <i class="fa fa-arrows-v drag-order" title="" aria-hidden="true" aria-describedby="ui-id-11"></i>  
                                            </div>
                                            <div class="col-md-2"> 
                                                <input class="form-control table-data-input" id="Standard" name="Standard" ng-change="updatePDFCompliance(pdfItems.id, 'standard', pdfItems.standard)" ng-value="pdfItems.standard"   ng-model="pdfItems.standard" size="30"   type="text">
                                            </div>
                                            <div class="col-md-5"> 
                                                <input class="form-control table-data-input" id="Description" name="Description" ng-value="pdfItems.description" ng-change="updatePDFCompliance(pdfItems.id, 'description', pdfItems.description)"  ng-model="pdfItems.description" size="30"   type="text">
                                            </div>
                                            <div class="col-md-2"> 
                                                
                                                <span class="pdf-link" ng-if="pdfItems.pdfFilename"><small>  <a href="/compliancePDF/{{pdfItems.pdfFilename}}" target="_blank" class="text-red  margin-right"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> {{pdfItems.pdfFilename}}</a>  </small> <span class="cursorpoint" ng-click="deleteSelectedPDF(pdfItems.id, pdfItems.pdfFilename)" > <i class="fa fa-times-circle"></i> </span> </span>
                                                <form name="pdfForm" id="pdfForm" ng-app="fileUpload"   ng-if="!pdfItems.pdfFilename"   >  
                                                    <input type="file" id="changefileUpload" class="form-control changefileUpload" ngf-select ng-model="picFileChange" name="fileChange"   ng-change="changePDFUpload(picFileChange, pdfItems.id, pdfItems.pdfFilename)"   accept="application/pdf"    >  
                                                </form>  
                                            </div>
                                            <div class="col-md-1"> 
                                               <small> {{pdfItems.date}} </small>
                                            </div>
                                            <div class="col-md-1"> 
                                                <span class="pdf-remove cursorpoint" ng-click="deleteCompliance(pdfItems.id, pdfItems.pdfFilename)"><i class="fa fa-trash" aria-hidden="true"></i></span>
                                            </div>
                                         <!-- {{pdfItems.pdfFilename}} - {{pdfItems.sort}}-->
                                    </div>
                                </li>  
                                
                            </ul>
                        </div>

                        <div class="lists-pdf margin-top " ng-if="resultPDFCount > 0"> 
                            <div class="row">
                                <div class="col-md-3">&nbsp;</div>
                                <div class="col-md-6  padding">
                                    <h6 class="alert alert-secondary"><strong> Compliance</strong></h6> 
                                    <ul class="view-list-pdf">
                                        <li class="compliance-view" ng-repeat="pdfItems in pdfCompliance"> 
                                            <span ng-if="!pdfItems.description"><i class="fa fa-circle" aria-hidden="true"></i> {{pdfItems.standard}}</span> 
                                            <a class="hyperlinkpdf pdf-link" ng-if="pdfItems.description" data-toggle="collapse" href="#collapsePdf{{pdfItems.id}}" role="button" aria-expanded="false" aria-controls="collapsePdf{{pdfItems.id}}"><i class="fa fa-plus" aria-hidden="true"></i> {{pdfItems.standard}}</a> 
                                            <a ng-if="pdfItems.pdfFilename" href="/compliancePDF/{{pdfItems.pdfFilename}}" target="_blank" class="text-red pdf-view-link"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> </a> 
                                            <div class="collapse pdf-desc" id="collapsePdf{{pdfItems.id}}" ng-if="pdfItems.description" >
                                                <div class="card card-body">
                                                        <i>{{pdfItems.description}}</i>
                                                </div>
                                            </div>
                                            
                                        </li>  
                                    </ul>
                                </div>  
                                <div class="col-md-3">&nbsp;</div>  
                            </div>    

                        </div>    





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