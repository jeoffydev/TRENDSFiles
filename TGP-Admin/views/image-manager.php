
<?php //
    /* at the top of 'check.php' */ 
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) { 
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 ); 
        die( header( 'location: /' ) ); 
    } 
 
?>
<?php include('header.php') ?>

  <!-- Breadcrumbs-->
  <ol class="breadcrumb"> <li class="breadcrumb-item active"><i class="fa  fa-image"></i> Image Manager</li> </ol>
   
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
                                <tr ng-repeat="product in products | filter:query" ng-click="selectImageItem(product.Prim)">
                                    <td><span class="edit-product" data-id="{{product.Prim}}" >{{product.Code}}</span></td>
                                    <td><span class="edit-product" data-id="{{product.Prim}}" >{{product.Name}}</a></td>
                                    <td><span class="edit-product" data-id="{{product.Prim}}" >{{product.Active}}</a></td>
                                </tr>
                            </table>
                    
                </div> 

             
            
            <div class="row margin-top"  ng-show="editImagesActive"> 
                <div class="col-md-1">&nbsp; </div>
                <div class="col-md-9">
                    <h4 class="alert alert-secondary"> {{editImages.Name}} - {{editImages.Code}} </h4>
                    <div class="row images-loop margin-top"   >
                         
                        <div class="col-md-3 margin-top-light images-cols images-margin" ng-repeat=" imgs in editImages.ImagesLoop">

                            <span ng-show="editImageCountOrig == $index" class="deleteImage" ng-click="removeImage(editImagePrim, editImages.Code, $index)"> <i class="fa  fa-trash "></i></span>
                            <span class="remove-selected  remove-selected{{$index}}"   >  
                                <div class="radio radio-primary">
                                    <input type="radio" name="radioSelected" id="radioSelected{{$index}}"   ng-value="{{$index}}" ng-model="editImageForm.selectImageToReplace">
                                    <label for="radioSelected{{$index}}">
                                        
                                    </label>
                                </div>
                            </span>
                            <div class="card image-card" id="card{{$index}}" style=""     >
                                <img src="../../Images/ProductImg/{{imgs.value}}?{{random}}" class="card-img-top img-responsive img-fluid" />  
                                <div class="card-body">
                                    <h5 class="card-title text-center">Image {{$index}}   </h5> 
                                    <div class="row stockcode-select" >
                                        <div class="col-md-6 column text-center" ng-show="$index != 0">
                                            
                                            <span>StockCode:</span>  <br />
                                            <!--<span ng-repeat =" stock in productStocks"  class="pointer highlightlabel"   ng-if="stock.ComponentCode === imgs.key"   data-toggle="modal" data-target="#stockModal{{imgs.imgNum}}"   > {{stock.PartName}} - {{stock.ComponentCode}}</span>
                                            <span   ng-if="imgs.key == 0 || !imgs.key"  data-toggle="modal" data-target="#stockModal{{imgs.imgNum}}" class="pointer highlightlabel"    >  [Select]</span>--> 

                                            <span ng-repeat =" stock in productStocks"    ng-if="stock.ComponentCode === imgs.key"    ><strong> {{stock.PartName}} - {{stock.ComponentCode}} </strong></span>
                                            <span    data-toggle="modal" data-target="#stockModal{{imgs.imgNum}}" class="pointer highlightlabel display-block text-center"    >  [Update]</span>
                            
                                             
                                            
                                            <!--
                                            <select class="form-control" ng-model="stock.ComponentCode" ng-change="stockcodeChange(stock.ComponentCode, imgs.imgNum, editImages.Code)"  ng-if="SelectStockActivate" >
                                                <option   value=""  ng-model="stock.ComponentCode"     selected>-- Select --</option>
                                                <option ng-repeat =" stock in productStocks"  ng-value="stock.ComponentCode" ng-selected="stock.ComponentCode === imgs.key"  ng-model="stock.ComponentCode"    > {{stock.ComponentCode}}</option>
                                            </select>  --> 
                                            
                                        </div>
                                        <div class="col-md-6 column text-center" ng-show="$index != 0">
                                            <span>Colour:</span> <br />
                                            
                                            <!--<span ng-repeat ="colour in coloursSelects"  class="pointer highlightlabel"   ng-if="colour === imgs.cols"   data-toggle="modal" data-target="#colourModal{{imgs.imgNum}}"   >{{colour}}</span>
                                            <span   ng-if="imgs.cols == 0 || !imgs.cols"  data-toggle="modal" data-target="#colourModal{{imgs.imgNum}}" class="pointer highlightlabel"    >  [Select]</span>--> 
                                            <span ng-repeat ="colour in coloursSelects"     ng-if="colour === imgs.cols"   ><strong>{{colour}}</strong></span>
                                            <span   data-toggle="modal" data-target="#colourModal{{imgs.imgNum}}" class="pointer highlightlabel display-block  text-center"    >  [Update]</span>
                                             
                                            
                                            <!--
                                            <select class="form-control "   ng-model="colour"  ng-click="stockcolourChange(colour, imgs.imgNum, editImages.Code)"   >
                                                <option   value="0"  ng-model="colour"  ng-click="stockcolourChange(null, imgs.imgNum, editImages.Code)"  selected>-- Select --</option>
                                                <option ng-repeat =" colour in coloursSelects" ng-value="colour"   ng-selected="colour === imgs.cols"  ng-model="colour"  ng-click="stockcolourChange(colour, imgs.imgNum, editImages.Code)"   > {{colour}}</option>
                                            </select> --> 

                                        </div>
                                    </div>         
                                    
                                </div>
                            </div>
                             <!--  
                            <div class="wrapperStock" ng-if="visibleStock$index" id="visible_{{$index}}">
                                        <ul class="list-group stockImg-list">
                                            <li   value=""  ng-model="stock.ComponentCode"  ng-click="stockcodeChange(null, imgs.imgNum, editImages.Code)"    selected>--<i class="fa  fa-trash "></i> Remove --</li>
                                            <li   ng-repeat =" stock in productStocks"  ng-value="stock.ComponentCode"   ng-model="stock.ComponentCode"  ng-click="stockcodeChange(stock.ComponentCode, imgs.imgNum, editImages.Code)"    >{{stock.PartName}} - {{stock.ComponentCode}}</li> 
                                        </ul>
                            </div> -->            
                           
                            <!-- modals -->
                            <div class="modal fade allStockModel" id="stockModal{{imgs.imgNum}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalLabel">Image - {{imgs.imgNum}}  / Stock Code</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body"> 
                                        <ul class="list-group stockImg-list">
                                            <li   value=""  ng-model="stock.ComponentCode"  ng-click="stockcodeChange(null, imgs.imgNum, editImages.Code, editImages.Prim)"    selected>--<i class="fa  fa-trash "></i> Remove --</li>
                                            <li   ng-repeat =" stock in productStocks"  ng-value="stock.ComponentCode"   ng-model="stock.ComponentCode"  ng-click="stockcodeChange(stock.ComponentCode, imgs.imgNum, editImages.Code, editImages.Prim)"    >{{stock.PartName}} - {{stock.ComponentCode}}</li> 
                                        </ul>
                                    </div>
                                    <div class="modal-footer"> 
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                    </div>
                                </div>
                            </div>  

 

                            <div class="modal fade allStockModel" id="colourModal{{imgs.imgNum}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalLabel">Image - {{imgs.imgNum}}  / Colour</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body"> 
                                        <ul class="list-group stockImg-list">
                                            <li   value=""   ng-model="colour"  ng-click="stockcolourChange(null, imgs.imgNum, editImages.Code, editImages.Prim)"    selected> <i class="fa  fa-trash "></i> Remove </li>
                                            <li   ng-repeat =" colour in coloursSelects"   ng-value="colour"    ng-model="colour"   ng-click="stockcolourChange(colour, imgs.imgNum, editImages.Code, editImages.Prim)"    >  {{colour}} </li> 
                                        </ul>
                                    </div>
                                    <div class="modal-footer"> 
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                    </div>
                                </div>
                            </div>  
                            <!-- modals -->
                             


                             
                        </div>

                        <div class="col-md-3 margin-top-light images-cols" >
                            <span class="remove-selected  remove-selected"   >  
                                <div class="radio radio-primary">
                                    <input type="radio" name="radioSelected" id="radioSelected" value="main"  ng-nit="selectDefault()" ng-model="editImageForm.selectImageToReplace"  >
                                    <label for="radioSelected">
                                        
                                    </label>
                                </div>
                            </span>
                            <div class="card default image-card" id="card" style=""     >
                                <img src="<?php echo $baseUrl; ?>/assets/images/default.jpg" class="card-img-top img-responsive img-fluid" />  
                                <div class="card-body cardbody-default">
                                    <h5 class="card-title text-center defaulth5">&nbsp;</h5> 
                                    <p class="defaulth5">&nbsp;</p>
                                </div>
                            </div>
                             
                        </div>

                       
                    </div>
                </div>
                <div class="col-md-2">&nbsp;</div>
            </div>    

         <p>&nbsp;</p>


    


                     

            </div>            
    </div>
</div>

 
 
                        <div class="floating-uploader"  ng-show="editImagesActive" >
                            
                            <form name="imageForm" id="imageForm"  > 
                                <div class="file-uploader text-center">
                                    <!---<input type="file" name='file' id='file' class="hide" ng-file='uploadfiles'  accept="image/jpeg" />  
                                    <input type='button' value='Upload' id='upload' ng-click='imageFormSubmitted()' >
                                    <label for="file" class="btn btn-danger">Select file</label>-->
                                    <!--<select class="form-control selectpicker"  name="userType"     ng-model="editImageForm.selectImageToReplace">
                                        <option value="main" selected>Select image to replace</option>
                                        <option ng-repeat="imgs in editImages.ImagesLoop"> {{imgs}}</option>
                                    </select> -->
                                    
                                    <!-- <input type="file" id='file'  class="mainfile hide" file-input="files" ng-file-drop ng-file-select ng-click="editImageForm.FormFile =  editImageForm.selectImageToReplace" ng-model="editImageForm.FormFile" accept="image/jpeg"    /> -->
                                    
                                    <input type="file" id='file'  class="mainfile hide" file-input="files"  ng-click="editImageForm.FormFile =  editImageForm.selectImageToReplace" ng-model="editImageForm.FormFile" accept="image/jpeg"    /> 
                                    
                                    <p><img src="<?php echo $baseUrl; ?>/assets/images/upload-arrow.png" class="arrow-upload" /><label for="file"  class="btn btn-danger btn-image-float">Select</label> </p>
                                    <!--<button class="btn btn-danger" ng-click="uploadFile()"  >Upload</button>  -->
                                </div>
                            </form>   
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