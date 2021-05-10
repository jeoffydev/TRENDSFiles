

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
         
        <li class="breadcrumb-item active">Branding Template Manager</li>
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

                <div class="alert alert-warning" role="alert">
                    Note: Administrators, if having difficulty viewing new updates made on the new website  Ex. content, images and pricing, please click this link  <a target="_blank" href="//trends.nz/refresh/all">www.trends.nz/refresh/all</a> to refresh website cache.
                </div>

                <div class="main-form margin-top margin-bottom" ng-if="editBranding" >   

                        <h4>{{itemName}} - {{brandingCode}}</h4>

                        <div class="padding col-md-5"   ng-if="resultPDFCount == 0"> 
                                        <span class="badge badge-dark padding-badge margin-bottom">No branding template uploaded</span> <br />

                                       <form name="pdfForm" id="pdfForm" ng-app="fileUpload"     >
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input mainfileUploads" id="mainfileUpload" aria-describedby="inputGroupFileAddon04" ngf-select ng-model="picFile" name="file"  ng-change="uploadPic(picFile, brandingCode)"   accept="application/pdf"  ngf-model-invalid="errorFile" >
                                                    <label class="custom-file-label" for="mainfileUpload">Choose file</label>
                                                </div>
                                            </div> 
                                                
                                        </form>  
                                         
                                </div>  
                                <div  class="padding"   ng-if="resultPDFCount == 1"> 
                                   
                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Code</th>
                                                <th scope="col">File Name</th>
                                                <th scope="col">File size</th>
                                                <th scope="col">Date Uploaded</th>
                                                <th scope="col">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="brand in pdfBranding"  >
                                                <td >{{brand.code}}</td>
                                                <td ><a href="/PDFWires/{{brand.filename}}?{{random}}" class="text-red" target="_blank">{{brand.filename}}</a></td>
                                                <td >{{brand.formattedSize}}</td>
                                                <td >{{brand.dateupload}}</td>
                                                <td> <span class="delete-pdf-wires cursorpoint" ng-click="deleteBranding(brand.code, brand.filename)"><i class="fa fa-trash" aria-hidden="true"></i></span> </td>
                                            </tr> 
                                        </tbody>
                                    </table>
                                </div> 


                         
                         
                        <ul class="nav nav-tabs margin-top" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link branding-tabs active" id="multiple-tab" data-toggle="tab" href="#multiple" role="tab" aria-controls="multiple" aria-selected="false">Upload multiple branding</a>
                            </li>  
                            <!--<li class="nav-item">
                                <a class="nav-link branding-tabs active " id="main-tab" data-toggle="tab" href="#main" role="tab" aria-controls="main" aria-selected="true" ng-click="selectItem(brandingCode, itemName)">{{itemName}} - {{brandingCode}}</a>
                            </li>-->
                            <li class="nav-item">
                                <a class="nav-link branding-tabs" id="without-tab" data-toggle="tab" href="#without" role="tab" aria-controls="without" aria-selected="false" ng-click="selectWithoutWires(1)">Items without wires</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link branding-tabs" id="files-tab" data-toggle="tab" href="#files" role="tab" aria-controls="files" aria-selected="false" ng-click="fileSized(1, 1)">View file sizes</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="multiple" role="tabpanel" aria-labelledby="multiple-tab">
                                <div class="padding">
                                     
                                         <!--<div class="button btn btn-danger text-white margin-bottom" ngf-select="uploadMultiple($files)" ngf-multiple="true">Select File</div>  <br />-->
                                         <p><small>Note: Please make sure all the PDF branding templates have the same file name as the item code Ex. 100046.pdf </small> </p>
                                         <div ngf-drop="uploadMultiple($files )" ngf-select="uploadMultiple($files )"  ng-model="files" class="drop-box"   
                                            ngf-drag-over-class="'dragover'" ngf-multiple="true" ngf-allow-dir="true"
                                            accept="image/*,application/pdf" 
                                            ngf-pattern="'image/*,application/pdf'" ng-click="clickUpload()"> <span>Click or Drag and Drop PDF to edit</span>   </div>
                                        <div ngf-no-file-drop>File Drag/Drop is not supported for this browser</div>
                                        
                                        <ul ng-if="arrFileNameExist" class="list-none">
                                            <li ng-repeat="fname in arrFileName"><i class="fa fa-check" aria-hidden="true"></i> <a href="/PDFWires/{{fname}}" target="_blank" class="text-red"> {{fname}} </a> </li>
                                        </ul>  
                                        
                                         <!--<ul>
                                            <li ng-repeat="f in files" style="font:smaller">{{f.name}} {{f.$error}} {{f.$errorParam}}</li>
                                        </ul>-->
                                         
                                        <!--<button class="btn btn-danger" type="button"  ng-click="uploadMultiple(files)"  ng-if="buttonUpload" >  Upload Multiple PDFs </button> -->


                                </div>
                            </div>
                            <div class="tab-pane fade " id="main" role="tabpanel" aria-labelledby="main-tab">

                                <!-- <h4 class="alert alert-secondary"> {{itemName}} - {{brandingCode}} </h4>-->

                               <!-- <div class="padding col-md-5"   ng-if="resultPDFCount == 0"> 
                                        <span class="badge badge-dark padding-badge margin-bottom">No branding template uploaded</span> <br />

                                       <form name="pdfForm" id="pdfForm" ng-app="fileUpload"     >
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input mainfileUploads" id="mainfileUpload" aria-describedby="inputGroupFileAddon04" ngf-select ng-model="picFile" name="file"  ng-change="uploadPic(picFile, brandingCode)"   accept="application/pdf"  ngf-model-invalid="errorFile" >
                                                    <label class="custom-file-label" for="mainfileUpload">Choose file</label>
                                                </div>
                                            </div> 
                                                
                                        </form>  
                                         
                                </div>  
                                <div  class="padding"   ng-if="resultPDFCount == 1"> 
                                   
                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Code</th>
                                                <th scope="col">File Name</th>
                                                <th scope="col">File size</th>
                                                <th scope="col">Date Uploaded</th>
                                                <th scope="col">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="brand in pdfBranding"  >
                                                <td >{{brand.code}}</td>
                                                <td ><a href="/pdfWires/{{brand.filename}}" class="text-red" target="_blank">{{brand.filename}}</a></td>
                                                <td >{{brand.formattedSize}}</td>
                                                <td >{{brand.dateupload}}</td>
                                                <td> <span class="delete-pdf-wires cursorpoint" ng-click="deleteBranding(brand.code, brand.filename)"><i class="fa fa-trash" aria-hidden="true"></i></span> </td>
                                            </tr> 
                                        </tbody>
                                    </table>
                                </div> -->
                            
                            </div>
                            <div class="tab-pane fade" id="without" role="tabpanel" aria-labelledby="without-tab">
                                <div class="padding">
                                    <p><button type="button" class="btn btn-sm btn-outline-dark  " ng-click="selectWithoutWires(1)" ng-class="{activateOne: btndark1}">Active</button>  <button type="button" class="btn btn-sm btn-outline-dark  " ng-class="{activateTwo: btndark2}" ng-click="selectWithoutWires(0)">InActive</button> </p>

                                    <!-- <p ng-if="loading" class="loading">{{loading}}</p> -->

                                    <div ng-if="itemPaginates"> 

                                        <!-- start pagnation -->    
                                        
                              

                                        <div class="row">
                                            <div class="col-md-12" ng-if="itemPaginates" >    
                                                <dir-pagination-controls
                                                    max-size="5"
                                                    direction-links="true"
                                                    boundary-links="true" >
                                                </dir-pagination-controls>
                                            </div>
                                            <div class="col-md-12"  >
                                                       
                                                    <table class="table table-striped table-bordered"   >
                                                        <thead>
                                                            <th>Code&nbsp;<a ng-click="sort_by('Code');"><i class="glyphicon glyphicon-sort"></i></a></th>
                                                            <th>Name&nbsp;<a ng-click="sort_by('Name');"><i class="glyphicon glyphicon-sort"></i></a></th>
                                                            <th>Active&nbsp;  <span class="btn btn-sm btn-outline-dark  " ng-click="selectWithoutWires(1)" ng-class="{activateOne: btndark1}">Y</span> <span class="btn btn-sm btn-outline-dark  " ng-class="{activateTwo: btndark2}" ng-click="selectWithoutWires(0)">N</span> </th>
                                                            <th>Upload Wire&nbsp;  </th> 
                                                        </thead>
                                                        <tbody>
                                                            <tr dir-paginate="data  in itemPaginates|itemsPerPage: 15" id="removeTr{{data.Code}}">
                                                                <td>{{data.Code}}</td>
                                                                <td>{{data.Name}}</td>
                                                                <td><span ng-if="data.Active == 1 ">Active</span> <span ng-if="data.Active == 0 ">InActive</span></td>
                                                                <td> 
                                                                <form name="brandingPdfForm" id="brandingPdfForm" ng-app="fileUpload"    >  
                                                                    <label for="changefileUpload{{data.Code}}" class="upload_wire"><span   title="Update Branding Template"><i class="fa fa-pencil text-red" aria-hidden="true"></i></span></label>
                                                                    <input style="display:none" type="file" id="changefileUpload{{data.Code}}" class="form-control changefileUpload" ngf-select ng-model="picFile" name="file"  ng-change="uploadPic(picFile, data.Code)"  accept="application/pdf"    >  
                                                                </form>    

                                                                </td> 
                                                            </tr>
                                                             
                                                        </tbody>
                                                    </table>

                                            </div>
                                            <div class="col-md-12" ng-show="itemPaginates == 0"> 
                                                    <p>No item found</p> 
                                            </div>
                                            <div class="col-md-12" ng-if="itemPaginates" >    
                                                <dir-pagination-controls
                                                    max-size="5"
                                                    direction-links="true"
                                                    boundary-links="true" >
                                                </dir-pagination-controls>
                                            </div>
                                        </div>    

                                        <!-- end pagnation -->

                                    </div>    

                                </div>
                            </div>
                            <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">
                                <div class="padding">
                                    
                                   


                                     <!-- start pagnation -->    
                                        
                              

                                        <div class="row">
                                            <div class="col-md-12" ng-if="fileSizeResult" >    
                                                <dir-pagination-controls
                                                    max-size="5"
                                                    direction-links="true"
                                                    boundary-links="true" >
                                                </dir-pagination-controls>
                                            </div>
                                            <div class="col-md-12"  >
                                                       
                                                    <table class="table table-striped table-bordered"   >
                                                        <thead>
                                                            <th>Code&nbsp; <span class="btn btn-sm btn-outline-dark  " ng-click="fileSized(2, 1)"  > <i class="fa fa-arrows-v " aria-hidden="true"></i> </span> </a></th>
                                                            <th>File Name&nbsp;<a ng-click="sort_by('Name');"><i class="glyphicon glyphicon-sort"></i></a></th>
                                                            <th>File Size&nbsp;  <span class="btn btn-sm btn-outline-dark  " ng-click="fileSized(1, 1)"  ><i class="fa fa-long-arrow-up" aria-hidden="true"></i></span> <span class="btn btn-sm btn-outline-dark  "    ng-click="fileSized(1, 0)"><i class="fa fa-long-arrow-down" aria-hidden="true"></i></span> </th>
                                                            <th>View Item&nbsp;  </th>    
                                                        </thead>
                                                        <tbody>
                                                            <tr dir-paginate="data  in fileSizeResult|itemsPerPage: 15" id="removeTr{{data.code}}"  >
                                                                <td >{{data.code}}</td>
                                                                <td><a href="/pdfWires/{{data.filename}}" title="View PDF" target="_blank" class="text-red">{{data.filename}}</a></td>
                                                                <td>{{data.formattedSize}}</td>
                                                                <td> 
                                                                    <a href="/item/{{data.code}}" title="View Item Page" target="_blank"><i class="fa fa-search text-red" aria-hidden="true"></i></a>
                                                                </td> 
                                                            </tr>
                                                             
                                                        </tbody>
                                                    </table>

                                            </div>
                                            <div class="col-md-12" ng-show="fileSizeResult == 0"> 
                                                    <p>No item found</p> 
                                            </div>
                                            <div class="col-md-12" ng-if="fileSizeResult" >    
                                                <dir-pagination-controls
                                                    max-size="5"
                                                    direction-links="true"
                                                    boundary-links="true" >
                                                </dir-pagination-controls>
                                            </div>
                                        </div>    

                                        <!-- end pagnation -->   





                                </div>    
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