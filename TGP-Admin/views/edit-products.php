
<?php //
    /* at the top of 'check.php' */ 
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) { 
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 ); 
        die( header( 'location: /' ) ); 
    } 
 
?>
<?php include('header.php') ?>

  <!-- Breadcrumbs-->
  <ol class="breadcrumb"> <li class="breadcrumb-item active"><i class="fa fa-fw fa-edit"></i> Edit Products</li> </ol>
   
<div class="row">
    <div class="col-md-12">
            <div class="body-controller" >     
           
              
            <!--<div id="custom-search-input">
                <div class="input-group col-md-4">
                    <input type="text" class="form-control input-lg" placeholder="Ex. Fan FLyer or 114084" ng-model="query[queryBy]"  /> 
                </div>
            </div>-->

                <div class="row">
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
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#newProductModal">
                            <i class="fa  fa-plus"></i> Add New Product 
                        </button>
                    </div>
                </div>        
            
                    

           
                <div class="main-itemTable" > 
                            <table class="table table-striped table-hover "  >
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                </tr>
                                <tr ng-repeat="product in products | filter:query" ng-click="selectItem(product.Prim)" class="productstr active{{product.Prim}}">
                                    <td><span class="edit-product" data-id="{{product.Prim}}" >{{product.Code}}</span></td>
                                    <td><span class="edit-product" data-id="{{product.Prim}}" >{{product.Name}}</a></td>
                                    <td><span class="edit-product" data-id="{{product.Prim}}" >{{product.Active}}</a></td>
                                </tr>
                            </table>
                    
                </div> 

                <div class="alert alert-warning" role="alert">
                    Note: Administrators, if having difficulty viewing new updates made on the new website  Ex. content, images and pricing, please click this link  <a target="_blank" href="//trends.nz/refresh/all">www.trends.nz/refresh/all</a> to refresh website cache.
                </div>

                 <div class="main-form margin-top margin-bottom"  ng-if="userIsEditing">
                    This item is currently being edited by user  {{userEmailEditing}}  &nbsp; <a class="btn btn-sm btn-secondary" ng-click="overWrite(overwriteCode, overwritePrim)">Unlock user to edit this item?</a>
                </div>
               
 

                
                
                <!-- Forms --> 
                <div class="main-form margin-top margin-bottom" ng-if="editForms" >   
                    
                <form name="formEditAngular" id="formEditAngular" ng-submit="updateData()"   >
                    <input type="hidden" id="Options" name="Options" value="{{editForms.Options}}"  ng-model="editForms.Options" >
                    <input type="hidden" id="Prim" name="Prim" value="{{editForms.Prim}}"  ng-model="editForms.Prim" >
                    <input class="form-control" id="Size" name="Size" value="{{editForms.Size}}"  ng-change="editThisForm('Size', editForms.Size)" ng-model="editForms.Size" size="30" type="hidden" />
                    <fieldset > 
                        
                        <div class="pull-right col-md-3  text-right"><a href="/item/{{editForms.Code}}/preview" target="_blank" class="text-red"> <i class="fa fa-search" aria-hidden="true"></i> Preview</a></div>    
                        
                        <h4 class="product-title  scale-up-center  col-md-6">{{editForms.Code}} - {{editForms.Name}}</h4>
                        <div class="getPrim" data-id="{{editForms.Prim}}" id="{{editForms.Prim}}"></div>

                       

<?php //echo $userID; ?>
<?php $selectDefault = array('0' => 'No', '1'=>'Yes'); ?>

<!-- Start Collapse-->
<div class="accordion" id="accordion"> 



<div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-link btn-100" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" ng-click="updatePageTracking(editForms.Code, '<?php echo $userID; ?>', 'edit products')">
            Main 
        </button>
      </h5>
    </div>
    
<!-- put  show to open in default -->
<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
    <div class="card-body">
        <!-- Collapse 1-->
                    <div class='row'>
                        <div class='col-sm-3'>    
                            <div class='form-group'>
                                <label for="Code">Code</label>
                                <input class="form-control editInput" id="Code"  name="Code" value="{{editForms.Code}}" ng-change="editThisForm('Code', editForms.Code)" ng-model="editForms.Code" size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorCode">{{errorCode}}</div>
                                 
                            </div>
                        </div>
                        <div class='col-sm-4'>
                            <div class='form-group'>
                                <label for="Name">Name</label>
                                <input class="form-control editInput editNameProducts" id="Name" name="Name" value="{{editForms.Name}}" ng-change="checkThisForm('Name', editForms.Name)" ng-model="editForms.Name"  size="30" type="text"   />
                                <div   class="CodeReq text-red labelreq reqfield" ng-show="errorName">{{errorName}}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                                <div class='form-group '>
                                    <?php $selectActiveDefault = array('0' => 'No', '1'=>'Yes'); ?>
                                    <label for="ImageCount">Active</label>
                                    <!--<input class="form-control" id="Active" name="Active" value="{{editForms.Active}}" ng-model="editForms.Active" size="30" type="text" />-->
                                    <select class="form-control " name="Active"  ng-model="editForms.Active" ng-change="activeChanger(origActive, editForms.Active)"> 
                                        <?php 
                                            foreach ($selectActiveDefault as $key => $value){
                                                echo '<option value="'.$key.'"  ng-selected="editForms.Active === '.$key.'" >'.$value.'</option>';
                                            }
                                        ?> 
                                    </select>
                                </div>   
                        </div>
                        <div class="col-md-2">
                                <div class='form-group '> 
                                    <label for="ImageCount">On Demand Stock</label> 
                                    <select class="form-control " name="OnDemandStock"  ng-model="editForms.OnDemandStock"  > 
                                        <?php 
                                            foreach ($selectActiveDefault as $key => $value){
                                                echo '<option value="'.$key.'"  ng-selected="editForms.Active === '.$key.'" >'.$value.'</option>';
                                            }
                                        ?> 
                                    </select>
                                </div>   
                        </div>
                    </div>
                    <div class='row'>    
                        <div class='col-sm-4'>
                            <div class='form-group'>
                                <label for="Status">Status</label>
                                <!--<input class="form-control" id="Status" name="Status" value="{{editForms.Status}}" ng-change="editThisForm('Status', editForms.Status)" ng-model="editForms.Status" size="30" type="text" />-->
                                <?php $status = getStatus(); ?>
                                <select class="form-control selectpicker" name="Status"  ng-model="editForms.Status" ng-change="statusChanger(origStatus, editForms.Status)">  
                                        <?php
                                            foreach ($status as $key => $value){
                                                echo '<option value="'.$key.'"    ng-selected="editForms.Status === '.$key.' " >'.$value.'</option>';  
                                            }

                                        ?>
                                               
                                </select>       
                                        
                           
                            </div>
                        </div>
                        <div class="col-md-4">
                                <div class='form-group '>
                                    <?php $selectActiveDefault = array('0' => 'No', '1'=>'Yes'); ?>
                                    <label for="AvailableNZ">Available in New Zealand</label> 
                                    <select class="form-control " name="availNZ"  ng-model="editForms.availNZ"> 
                                        <?php 
                                            foreach ($selectActiveDefault as $key => $value){
                                                echo '<option value="'.$key.'"  ng-selected="editForms.availNZ === '.$key.'" >'.$value.'</option>';
                                            }
                                        ?> 
                                    </select>
                                </div>   
                        </div>

                        <div class="col-md-4">
                                <div class='form-group '>
                                    <?php $selectActiveDefault = array('0' => 'No', '1'=>'Yes'); ?>
                                    <label for="AvailableNZ">Available in Australia</label> 
                                    <select class="form-control " name="availAU"  ng-model="editForms.availAU"> 
                                        <?php 
                                            foreach ($selectActiveDefault as $key => $value){
                                                echo '<option value="'.$key.'"  ng-selected="editForms.availAU === '.$key.'" >'.$value.'</option>';
                                            }
                                        ?> 
                                    </select>
                                </div>   
                        </div>

                        <!--
                        <div class='col-sm-3'>
                            <div class='form-group'>
                                <label for="Size">Size</label>
                                
                            </div>
                        </div> -->
                    </div>


                    <div class='row'>
                            <div class='col-sm-12'>    
                                <div class='form-group'>
                                    <label for="Description">Description</label>
                                    <textarea class="form-control descriptionproducts" id="Description" name="Description" ng-change="checkThisForm('Description', editForms.Description)"   ng-model="editForms.Description">{{editForms.Description}}</textarea>
                                </div>
                            </div> 
                        </div>

                    <div class="row"> 
                             <div class='col-sm-6'> 
                                <div class='form-group'>
                                    <label for="Materials">Materials</label>
                                    <textarea class="form-control" id="Materials" name="Materials" ng-model="editForms.Materials">{{editForms.Materials}}</textarea>
                                </div> 
                            </div> 
                            <div class='col-sm-6'> 
                                 <div class='form-group'>
                                    <label for="Specifications">Specifications</label>
                                    <textarea class="form-control" id="Specifications" name="Specifications" ng-model="editForms.Specifications">{{editForms.Specifications}}</textarea>
                                </div> 
                            </div>  
                    </div> 

                    <div class='row'>
                            <div class='col-sm-4'>    
                                <div class='form-group'>
                                    <label for="Dimension1">Dimension1</label>
                                    <input class="form-control" id="Dimension1" name="Dimension1" value="{{editForms.Dimension1}}" ng-change="editThisForm('Dimension1', editForms.Dimension1)" ng-model="editForms.Dimension1" size="30" type="text" />
                                </div>
                            </div>
                            <div class='col-sm-4'>
                                <div class='form-group'>
                                    <label for="Dimension2">Dimension2</label>
                                    <input class="form-control" id="Dimension2" name="Dimension2" value="{{editForms.Dimension2}}" ng-change="editThisForm('Dimension2', editForms.Dimension2)" ng-model="editForms.Dimension2" size="30" type="text" />
                                </div>
                            </div>
                            <div class='col-sm-4'>
                                <div class='form-group'>
                                    <label for="Dimension3">Dimension3</label>
                                    <input class="form-control" id="Dimension3" name="Dimension3" value="{{editForms.Dimension3}}" ng-change="editThisForm('Dimension3', editForms.Dimension3)" ng-model="editForms.Dimension3" size="30" type="text" />
                                </div>
                            </div> 
                    </div>




<!-- Sizing -->
 




<!--
                        <div class='row'  > 
                            <div class='col-md-5'>     



                                    <div class="row">
                                        <div class='col-md-6'>    
                                            <div class='form-group'>
                                                <label for="sizingLine1">Sizing Line1 (Heading)</label>
                                                <input class="form-control" id="sizingLine1" name="sizingLine1[]" value="{{editForms.sizingLine1}}"  ng-model="editForms.sizingLine1"  size="30" type="text" />
                                                    
                                            </div>
                                        </div> 
                                        <div class='col-md-6'>
                                            <div class='form-group'>
                                                    <label for="sizingLine2">Sizing Line2 (Table Data)</label>
                                                    <input class="form-control" id="sizingLine2" name="sizingLine2[]" value="{{editForms.sizingLine2}}"   ng-model="editForms.sizingLine2"  size="30" type="text" />
                                            </div>
                                        </div>  
                                    </div>   -->
                                    
                                    
 <!-- Trigger Increment Sizing Line 1 and 2-->  
                     <!-- If Sizing is not empty -->
         
<!--         
                    <div class='row' ng-if="editForms.triggerEvent == true"     >   
                       
                       <span data-ng-init='plusCount("plus", editForms.sizeCount1)'></span> 
                       <div class='col-md-12'>    
                                       <div  ng-repeat="i in inputInc">
                                           <div class="row"   > 
                                               <div class='col-md-6' >   
                                                   <div class='form-group' >  
                                                       <input class="form-control" id="sizingLine1{{i}}" name="sizingLine1[]" value="{{editForms.sizeArray[i]}}"  ng-model="editForms.sizeArray[i]"  size="30" type="text" />
                                                       
                                                   </div>
                                               </div> 
                                               <div class='col-md-6'>
                                                   <div class='form-group'  > 
                                                       <input class="form-control" id="sizingLine2{{i}}" name="sizingLine2[]" value="{{editForms.sizeArray2[i]}}"  ng-model="editForms.sizeArray2[i]"  size="30" type="text" />
                                                       
                                                   </div>
                                               </div>  
                                           </div>    
                                       </div>  
                                       

                       </div>                 
                                    
                   </div>     -->

                   <!--If sizing is empty -->    
           <!--          <div class='row' ng-if="editForms.triggerEvent == false"  >
                           <!--<span > <span ng-init='plusCount("plus", editForms.sizeCount1)'></span> </span>-->
               <!--              <div class='col-md-12'>     
                                   
                                   <div ng-repeat="i in inputInc"  >  
                                   
                                       <div class="row">
                                           <div class='col-md-6'>    
                                               <div class='form-group'> 
                                                   <input class="form-control" id="sizingLine1{{i}}" name="sizingLine1[]" value="{{editForms.sizingValA[i]}}"  ng-model="editForms.sizingValA[i]"  size="30" type="text" />
                                                   
                                               </div>
                                           </div> 
                                           <div class='col-md-6'>
                                               <div class='form-group'> 
                                                   <input class="form-control" id="sizingLine2{{i}}" name="sizingLine2[]"  value="{{editForms.sizingValB[i]}}"   ng-model="editForms.sizingValB[i]"  size="30" type="text" />
                                               </div>
                                           </div>  
                                       </div>  

                                   </div> 


                           </div> 
                           
                    </div> -->

 <!-- Trigger Increment Sizing Line 1 and 2-->  

 

<!--  

                            </div> 
                            <div class='col-md-1 text-left' ng-if="editForms.triggerEvent == false" >
                                 <span ng-click='plusCount("plus")' class="btn btn-xs btn-info  btn-size">+</span>
                                 <span ng-click='plusCount("minus")' class="btn btn-xs btn-info btn-size">-</span> 
                            </div>  
                            <div class='col-md-1 text-left' ng-if="editForms.triggerEvent == true" >
                                 <span ng-click='plusCount("plus", editForms.sizeCount1, "sizetrue")' class="btn btn-xs btn-info  btn-size">+</span>
                                 <span ng-click='plusCount("minus", editForms.sizeCount1, "sizetrue")' class="btn btn-xs btn-info btn-size">-</span> 
                            </div>    
                             <div class='col-md-5'>     
                                    
                             
                                    <div class="row">
                                        <div class='col-md-6'>    
                                            <div class='form-group'>
                                                <label for="sizingLine3">Sizing Line3 (Heading)</label>
                                                <input class="form-control" id="sizingLine3" name="sizingLine3[]" value="{{editForms.sizingLine3}}"  ng-model="editForms.sizingLine3"  size="30" type="text" />
                                                    
                                            </div>
                                        </div> 
                                        <div class='col-md-6'>
                                            <div class='form-group'>
                                                    <label for="sizingLine4">Sizing Line4 (Table Data)</label>
                                                    <input class="form-control" id="sizingLine4" name="sizingLine4[]" value="{{editForms.sizingLine4}}"   ng-model="editForms.sizingLine4"  size="30" type="text" />
                                            </div>
                                        </div>  
                                    </div>    
                                    
                                        -->              


                <!-- Trigger Increment Sizing Line 3 and 4-->  
                     <!-- If Sizing is not empty -->
                  
                <!--       <div class='row' ng-if="editForms.triggerEvent3 == true"     >   
                       
                       <span data-ng-init='plusCount2("plus", editForms.sizeCount3)'></span> 
                       <div class='col-md-12'>    
                                       <div  ng-repeat="x in inputInc2">
                                           <div class="row"   > 
                                               <div class='col-md-6' >   
                                                   <div class='form-group' >  
                                                       <input class="form-control" id="sizingLine3{{x}}" name="sizingLine3[]" value="{{editForms.sizeArray3[x]}}"  ng-model="editForms.sizeArray3[x]"  size="30" type="text" />
                                                       
                                                   </div>
                                               </div> 
                                               <div class='col-md-6'>
                                                   <div class='form-group'  > 
                                                       <input class="form-control" id="sizingLine4{{x}}" name="sizingLine4[]" value="{{editForms.sizeArray4[x]}}"  ng-model="editForms.sizeArray4[x]"  size="30" type="text" />
                                                       
                                                   </div>
                                               </div>  
                                           </div>    
                                       </div>   
                       </div>                 
                                    
                   </div>   -->


                    
                   <!--If sizing 3 / 4 is empty -->    
             <!--        <div class='row' ng-if="editForms.triggerEvent3 == false"  > 
                           <div class='col-md-12'>     
                                   
                                   <div ng-repeat="x in inputInc2"  >  
                                   
                                       <div class="row">
                                           <div class='col-md-6'>    
                                               <div class='form-group'> 
                                                   <input class="form-control" id="sizingLine3{{x}}" name="sizingLine3[]" value="{{editForms.sizingValC[x]}}"  ng-model="editForms.sizingValC[x]"  size="30" type="text" />
                                                   
                                               </div>
                                           </div> 
                                           <div class='col-md-6'>
                                               <div class='form-group'> 
                                                   <input class="form-control" id="sizingLine4{{x}}" name="sizingLine4[]"  value="{{editForms.sizingValD[x]}}"   ng-model="editForms.sizingValD[x]"  size="30" type="text" />
                                               </div>
                                           </div>  
                                       </div>  

                                   </div> 


                           </div> 
                           
                    </div>
 
   
                            </div> 
                            <div class='col-md-1 text-left' ng-if="editForms.triggerEvent3 == false" > 
                                <span ng-click='plusCount2("plus")' class="btn btn-xs btn-info  btn-size">+</span>
                                <span ng-click='plusCount2("minus")' class="btn btn-xs btn-info btn-size">-</span> 
                            </div> 
                            <div class='col-md-1 text-left' ng-if="editForms.triggerEvent3 == true" >
                                 <span ng-click='plusCount2("plus", editForms.sizeCount3, "sizetrue")' class="btn btn-xs btn-info  btn-size">+</span>
                                 <span ng-click='plusCount2("minus", editForms.sizeCount3, "sizetrue")' class="btn btn-xs btn-info btn-size">-</span> 
                            </div>    

                    </div>

                     -->

   


                       

        <!-- Collapse 1-->
        </div>             
    </div>
</div>



<!-- Collapse Sizing Heading-->
<div class="card">
    <div class="card-header" id="headingSizing">
      <h5 class="mb-0">
        <button class="btn btn-link btn-100 collapsed" type="button" data-toggle="collapse" data-target="#collapseSizing" aria-expanded="false" aria-controls="collapseSizing" ng-click="updatePageTracking(editForms.Code, '<?php echo $userID; ?>', 'edit products')">
            Sizing
        </button>
      </h5>
    </div>
                    
    <div id="collapseSizing" class="collapse" aria-labelledby="headingSizing" data-parent="#accordion">
        <div class="card-body">
        <!-- Collapse Sizing -->


        
        <h5>Apparel Sizing Table</h5>    
         <p>Separate column data values with &#39;,&#39;. If a cell is to be left empty, enter two &#39;,&#39; in a row. E.g. Half Chest, S,M,L,, <small>(Note: &#39;Undefined&#39;  means the table data is not equal.)</small>   </p>  
         
         <div class="row">
             <div class="col-md-4"  >                          
                <label for="sizingLine1">Sizing Line1 (Heading)</label>
                <input class="form-control" id="sizingLine1" name="sizingLine1" value="{{editForms.sizingLine1}}"  ng-model="editForms.sizingLine1"  size="30" type="text" />
                <label for="sizingLine2" class="margin-top">Sizing Line2 (Table Data)</label>
                <input class="form-control" id="sizingLine2" name="sizingLine2" value="{{editForms.sizingLine2}}"   ng-model="editForms.sizingLine2"  size="30" type="text" />
                <label for="sizingLine3" class="margin-top">Sizing Line3 (Heading)</label>
                <input class="form-control" id="sizingLine3" name="sizingLine3" value="{{editForms.sizingLine3}}"  ng-model="editForms.sizingLine3"  size="30" type="text" />
                <label for="sizingLine4" class="margin-top">Sizing Line4 (Table Data)</label>
                <input class="form-control" id="sizingLine4" name="sizingLine4" value="{{editForms.sizingLine4}}"   ng-model="editForms.sizingLine4"  size="30" type="text" />
                <span class="btn btn-danger margin-top" ng-click="previewTable(editForms.sizingLine1, editForms.sizingLine2, editForms.sizingLine3, editForms.sizingLine4)">Preview</span>                                                                


             </div>  
             <div class="col-md-8" >
                                                     
                    <span  ng-init="previewTable(editForms.sizingLine1, editForms.sizingLine2, editForms.sizingLine3, editForms.sizingLine4)"><div ng-bind-html="PreviewTableResult | trust"></div></span>
             
             </div>
         </div>    



        <!-- Collapse Sizing-->
         </div>             
    </div>
</div>




<!-- Collapse Colours Heading-->
<div class="card">
    <div class="card-header" id="headingColours">
      <h5 class="mb-0">
        <button class="btn btn-link btn-100 collapsed" type="button" data-toggle="collapse" data-target="#collapseColours" aria-expanded="false" aria-controls="collapseColours" ng-click="updatePageTracking(editForms.Code, '<?php echo $userID; ?>', 'edit products')">
             Colours 
        </button>
      </h5>
    </div>
                    
<div id="collapseColours" class="collapse" aria-labelledby="headingColours" data-parent="#accordion">
    <div class="card-body">
        <!-- Collapse Colours -->

        
                        
                        <div class='row'>
                            <div class='col-sm-12'>    
                                <div class='form-group'>
                                    <label for="Colours">Line 1</label>
                                    <input class="form-control" id="Colours" name="Colours" value="{{editForms.Colours}}" ng-model="editForms.Colours" size="30" type="text" />
                                    
                                    
                                </div>
                            </div>
                        </div>    
                        <div class='row'>    
                            <div class='col-sm-12'>
                                <div class='form-group'>
                                    <label for="ColoursSecondary">Line 2</label>
                                    <input class="form-control" id="ColoursSecondary" name="ColoursSecondary" value="{{editForms.ColoursSecondary}}"  ng-model="editForms.ColoursSecondary" size="30" type="text" />
                                </div>
                            </div>
                        </div>    
                        <div class='row'>    
                            <div class='col-sm-12'>
                                <div class='form-group'>
                                    <label for="ThirdColours">Line 3</label>
                                    <input class="form-control" id="ThirdColours" name="ThirdColours" value="{{editForms.ThirdColours}}"  ng-model="editForms.ThirdColours" size="30" type="text" />
                                </div>
                            </div>
                        </div>    
                        <div class='row'>        
                            <div class="col-md-2">
                                <div class='form-group'>
                                    <label for="IsMixMatch">Mix and Match </label>
                                    <!--<input class="form-control" id="IsMixMatch" name="IsMixMatch" value="{{editForms.IsMixMatch}}" ng-model="editForms.IsMixMatch" size="30" type="text" />-->
                                    <select class="form-control " name="IsMixMatch"  ng-model="editForms.IsMixMatch"> 
                                        <?php 
                                            foreach ($selectDefault as $key => $value){
                                                echo '<option value="'.$key.'"  ng-selected="editForms.IsMixMatch === '.$key.'" >'.$value.'</option>';
                                            }
                                        ?> 
                                    </select>
                                </div>   
                            </div>

                           <!-- <div class='col-sm-4'>
                                <div class='form-group'>
                                    <label for="ColorSearch">Colour Search</label>
                                    <input class="form-control" id="ColorSearch" name="ColorSearch" value="{{editForms.ColorSearch}}"  ng-model="editForms.ColorSearch" size="30" type="text" />
                                </div>
                            </div> --> 
                        </div>

                        <div class="row">
                            <div class="col-md-12">  
                                    <label for="ColorSearch">Colour Search   </label> 

                                    <div class="alert alert-secondary" role="alert">
                                        <i class="fa fa-paint-brush margin-right"></i>  {{showSample}}  
                                    </div>
                                     
                                    <input  class="form-control" id="selectedCheckedOneValues"   name="selectedCheckedOneValues[]" value="editForms.selectedCheckedOneValues"  ng-model="editForms.selectedCheckedOneValues" size="30" type="hidden" />  
                                    
                                            
                            </div>   
                            <div class='col-md-2' ng-repeat="cs in editForms.ColorSearchVariables"   > 
                                <span ng-if="cs[3]"><span   ng-init="selectCheckbox(cs[1])"> </span></span>             
                                <div class="form-check colourstable"  >  
                                     <div ng-if="cs[3]">
                                        <span  class="badge show-{{cs[1]}} displayinline-block"     id="show-{{cs[1]}}"   ng-click="removeCheck(cs[1])" ng-model="removeMe[cs[3]]" ><i class="fa fa-toggle-on color-toggle" style="color: {{cs[4]}}" ></i> {{cs[0]}} </span>  
                                        <span class="badge hide-{{cs[1]}} displaynone"      id="hide-{{cs[1]}}"   ng-click="selectCheckbox(cs[1])"  ng-model="checkMe[cs[3]]"  >  <i class="fa fa-toggle-off color-toggle"></i> {{cs[0]}} </span> 
                                    </div>    
                                    <div ng-if="!cs[3]">
                                        <span  class="badge show-{{cs[1]}} displaynone"    id="show-{{cs[1]}}"   ng-click="removeCheck(cs[1])" ng-model="removeMe[cs[3]]" > <i class="fa fa-toggle-on color-toggle" style="color: {{cs[4]}}" ></i>  {{cs[0]}} </span>  
                                        <span class="badge hide-{{cs[1]}} displayinline-block"   id="hide-{{cs[1]}}"   ng-click="selectCheckbox(cs[1])"  ng-model="checkMe[cs[3]]"   > <i class="fa fa-toggle-off color-toggle"></i> {{cs[0]}} </span> 
                                    </div> 
                                    
                                </div> 
                            </div> 
                            <!-- 
                            <div class='col-md-3' ng-repeat="cs in editForms.ColorSearchArray" > 
                                <div class="form-check"> 
                                    <label class="form-check-label">
                                        <input class="form-check-input" name="ColorSearchArray[]" type="checkbox"   ng-model="cs" > {{cs}}
                                    </label> 
                                </div> 
                            </div> -->
                           
                            
                        <?php //echo '<pre>'; print_r(getColourSearch($table)); echo '</pre>';   
                            /*
                            $searchColour = getColourSearch($table);
                            $ci = 0;
                            foreach($searchColour as  $value){
                                echo "<div class='col-md-3'>";
                                ?>
                                
                                <?php 
                                echo '<div class="form-check"  > <label class="form-check-label">';
                                
                                ?> 
                                     <span ng-click="removeCheck('<?php echo strtolower ($value['nameSearch']); ?>')" >Remove </span>  
                                     <span ng-click="selectCheckbox('<?php echo strtolower ($value['nameSearch']); ?>')" > Select</span>  
 
                                <?php
                                echo "  <span class='badge badge-secondary' style='background-color: ".substr($value['hexCode'], 0, 7)."  '> &nbsp; </span> " .$value['nameTitle']; 
                                echo '</label> </div>';
                                echo '</div>'; 
                                $ci++;   
                            }  
                         */
                        ?>

                            <!--  <input class="form-check-input" name="ColorSearchArray[]" type="checkbox"  ng-click="selectCheckbox('<?php // echo strtolower ($value['nameSearch']); ?>')"    ng-true-value="'<?php // echo strtolower ($value['nameSearch']); ?>'" ng-false-value="'NO'" ng-model="editForms.ColorSearchArray[<?php echo $ci; ?>]"  > -->
                        </div>  
                        
                         
                     <div class="row margin-top">
                            <div class="col-md-12">  <label for="PMSCode">PMS Colours</label>  </div> 
                            <!--<div class="col-md-3 margin-top-light" ng-repeat ="editStocks in editForms.productStocks"   > 
                                <label for="PMSCode">{{editStocks.PartName}}</label>  
                                <input  class="form-control" id="stocks{{editStocks.ComponentCode}}"   name="productStocks" value="editStocks.PmsCode"  ng-model="editStocks.PmsCode" size="30" type="text" />  
                                    
                            </div> {{editForms.productStocks}} -->
                            
                            <div class="col-md-12">

                                   <table class="table">
                                        <thead class="thead-dark">
                                            <tr ng-if="editForms.productStocks">
                                                <th scope="col" style="width:20%" class="text-right">Part Name</th>
                                                <th scope="col" style="width:1.4%" >&nbsp;</th> 
                                                <th scope="col" style="width:40%" >PMS Colour  </th> 
                                                <th scope="col">&nbsp;</th> 
                                                <th scope="col">&nbsp;</th> 
                                                <th scope="col">&nbsp;</th> 
                                            </tr> 
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat ="editStocks in editForms.productStocks" > 
                                                <td class="text-right" style="width:20%" ><span class="partname">{{editStocks.PartName}}</span> </td>
                                                <td style="width:1.4%">&nbsp;</td> 
                                                <td style="width:40%"><input  class="form-control" id="stocks{{editStocks.ComponentCode}}"       name="productStocks" value="editStocks.PmsCode"  ng-model="editStocks.PmsCode" size="30" type="text" /></td> 
                                                <td>&nbsp;</td> 
                                                <td>&nbsp;</td> 
                                                <td>&nbsp;</td> 
                                            </tr> 
                                        </tbody>
                                    </table> 

                            </div>    

                        </div>  


                        
   <!-- Collapse Colours-->  
     </div>           
   </div>
</div>   








<!-- Collapse 2A Heading-->
<div class="card">
    <div class="card-header" id="headingTwoA">
      <h5 class="mb-0">
        <button class="btn btn-link btn-100 collapsed" type="button" data-toggle="collapse" data-target="#collapseTwoA" aria-expanded="false" aria-controls="collapseTwoA" ng-click="updatePageTracking(editForms.Code, '<?php echo $userID; ?>', 'edit products')">
            Categories 
        </button>
      </h5>
    </div>
                    
<div id="collapseTwoA" class="collapse" aria-labelledby="headingTwoA" data-parent="#accordion">
    <div class="card-body categories-select">
        <!-- Collapse 2A-->
 
                        <div class="row">
                            <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="Category1">Category1</label>
                                            <!--<input class="form-control" id="Category1" name="Category1" value="{{editForms.Category1}}"  ng-change="editThisForm('Category1', editForms.Category1)" ng-model="editForms.Category1" size="30" type="text" />-->
                                            <select class="form-control selectpicker" name="Category1"  ng-model="editForms.Category1">
                                                <optgroup label="Select Category">
                                                    <option value="" ng-if="!editForms.Category1"  ng-selected="{{editForms.Category1}}">Select Category</option>
                                                    <option value="0" ng-if="editForms.Category1 == 0" ng-selected="editForms.Category1 === 0">Select Category</option>
                                                    <option value="0" ng-hide="editForms.Category1 == 0" >--Remove Category--</option>
                                                </optgroup> 
                                                <?php
                                                    $results = getCategories($table);  
                                                    $select = "";          
                                                    foreach($results  as $mainCat) { 
                                                        echo '<optgroup label="'.$mainCat['CategoryName'].'">'.$mainCat['CategoryName']; 
                                                        $resultSubCat = getSubCategories($table, $mainCat['CategoryNum']);
                                                        foreach($resultSubCat  as $subCat) { 
                                                            echo '<option value="'.$subCat['CategoryNum'].'"    ng-selected="editForms.Category1 === '.$subCat['CategoryNum'].' " >'.$subCat['CategoryName'].'</option>';    
                                                        }  
                                                        echo '</optgroup>';
                                                    }  
                                                ?>
                                              </select>

                                            
                                        
                                        
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Category2">Category2</label>
                                            <!--<input class="form-control" id="Category2" name="Category2" value="{{editForms.Category2}}" ng-change="editThisForm('Category2', editForms.Category2)" ng-model="editForms.Category2" size="30" type="text" />-->
                                                    
                                            <select class="form-control selectpicker" name="Category2"  ng-model="editForms.Category2"  >
                                                <optgroup label="Select Category">
                                                    <option value="" ng-if="!editForms.Category2"  ng-selected="{{editForms.Category2}}">Select Category</option>
                                                    <option value="0" ng-if="editForms.Category2 == 0" ng-selected="editForms.Category2 === 0">Select Category</option>
                                                    <option value="0" ng-hide="editForms.Category2 == 0" >--Remove Category--</option>
                                                </optgroup> 
                                                
                                                <?php  
                                                    $select = "";          
                                                    foreach($results  as $mainCat) { 
                                                        echo '<optgroup label="'.$mainCat['CategoryName'].'">'.$mainCat['CategoryName']; 
                                                        $resultSubCat = getSubCategories($table, $mainCat['CategoryNum']);
                                                        foreach($resultSubCat  as $subCat) { 
                                                            echo '<option value="'.$subCat['CategoryNum'].'"    ng-selected="editForms.Category2 === '.$subCat['CategoryNum'].' " >'.$subCat['CategoryName'].'</option>';    
                                                        }  
                                                        echo '</optgroup>';
                                                    } 
                                                ?>
                                              </select>
                                        
                                        
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Category3">Category3</label>
                                            <!--<input class="form-control" id="Category3" name="Category3" value="{{editForms.Category3}}" ng-change="editThisForm('Category3', editForms.Category3)" ng-model="editForms.Category3" size="30" type="text" />-->
                                            
                                            <select class="form-control selectpicker" name="Category3"  ng-model="editForms.Category3"  >
                                                <optgroup label="Select Category"  >
                                                    <option value="" ng-if="!editForms.Category3"  ng-selected="{{editForms.Category3}}">Select Category</option>
                                                    <option value="0" ng-if="editForms.Category3 == 0" ng-selected="editForms.Category3 === 0">Select Category</option>
                                                    <option value="0" ng-hide="editForms.Category3 == 0" >--Remove Category--</option>
                                                </optgroup> 
                                                <?php  
                                                    $select = "";          
                                                    foreach($results  as $mainCat) { 
                                                        echo '<optgroup label="'.$mainCat['CategoryName'].'">'.$mainCat['CategoryName']; 
                                                        $resultSubCat = getSubCategories($table, $mainCat['CategoryNum']);
                                                        foreach($resultSubCat  as $subCat) { 
                                                            echo '<option value="'.$subCat['CategoryNum'].'"    ng-selected="editForms.Category3 === '.$subCat['CategoryNum'].' " >'.$subCat['CategoryName'].'</option>';    
                                                        }  
                                                        echo '</optgroup>';
                                                    } 
                                                ?>
                                              </select>

                                        </div>
                                        <div class="col-md-3">
                                            <label for="Category4">Category4</label>
                                            <!--<input class="form-control" id="Category4" name="Category4" value="{{editForms.Category4}}" ng-change="editThisForm('Category4', editForms.Category4)" ng-model="editForms.Category4" size="30" type="text" />-->
                                            <select class="form-control selectpicker" name="Category4"  ng-model="editForms.Category4"> 
                                                <optgroup label="Select Category">
                                                    
                                                    <option value="" ng-if="!editForms.Category4"  ng-selected="{{editForms.Category4}}">Select Category</option>
                                                    <option value="0" ng-if="editForms.Category4 == 0" ng-selected="editForms.Category4 === 0">Select Category</option>
                                                    <option value="0" ng-hide="editForms.Category4 == 0" >--Remove Category--</option>
                                                </optgroup>    
                                                <?php  
                                                    $select = "";          
                                                    foreach($results  as $mainCat) { 
                                                        echo '<optgroup label="'.$mainCat['CategoryName'].'">'.$mainCat['CategoryName']; 
                                                        $resultSubCat = getSubCategories($table, $mainCat['CategoryNum']); 
                                                        foreach($resultSubCat  as $subCat) {  
                                                            echo '<option value="'.$subCat['CategoryNum'].'"    ng-selected="editForms.Category4 === '.$subCat['CategoryNum'].' " >'.$subCat['CategoryName'].'</option>';    
                                                        }  
                                                        echo '</optgroup>';
                                                    } 
                                                ?>
                                              </select>       
                                        
                                        </div>
                                     </div>
                            </div> 
                            <div class="col-md-6">
                                 <div class="row">
                                        <div class="col-md-3">
                                            <label for="Category5">Category5</label>
                                            <!-- <input class="form-control" id="Category5" name="Category5" value="{{editForms.Category5}}" ng-change="editThisForm('Category5', editForms.Category5)" ng-model="editForms.Category5" size="30" type="text" /> -->
                                             <select class="form-control selectpicker" name="Category5"  ng-model="editForms.Category5"> 
                                                <optgroup label="Select Category">
                                                    <option value="" ng-if="!editForms.Category5"  ng-selected="{{editForms.Category5}}">Select Category</option>
                                                    <option value="0" ng-if="editForms.Category5 == 0" ng-selected="editForms.Category5 === 0">Select Category</option>
                                                    <option value="0" ng-hide="editForms.Category5 == 0" >--Remove Category--</option>
                                                </optgroup>   
                                                <?php  
                                                    $select = "";          
                                                    foreach($results  as $mainCat) { 
                                                        echo '<optgroup label="'.$mainCat['CategoryName'].'">'.$mainCat['CategoryName']; 
                                                        $resultSubCat = getSubCategories($table, $mainCat['CategoryNum']); 
                                                        foreach($resultSubCat  as $subCat) {  
                                                            echo '<option value="'.$subCat['CategoryNum'].'"    ng-selected="editForms.Category5 === '.$subCat['CategoryNum'].' " >'.$subCat['CategoryName'].'</option>';    
                                                        }  
                                                        echo '</optgroup>';
                                                    } 
                                                ?>
                                              </select>   
                                       
                                       
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Category6">Category6</label>
                                            <!--<input class="form-control" id="Category6" name="Category6" value="{{editForms.Category6}}" ng-change="editThisForm('Category6', editForms.Category6)" ng-model="editForms.Category6" size="30" type="text" />-->
                                            <select class="form-control selectpicker" name="Category6"  ng-model="editForms.Category6"> 
                                                <optgroup label="Select Category">
                                                    <option value="" ng-if="!editForms.Category6"  ng-selected="{{editForms.Category6}}">Select Category</option>
                                                    <option value="0" ng-if="editForms.Category6 == 0" ng-selected="editForms.Category6 === 0">Select Category</option>
                                                    <option value="0" ng-hide="editForms.Category6 == 0" >--Remove Category--</option>
                                                </optgroup>   
                                                <?php  
                                                    $select = "";          
                                                    foreach($results  as $mainCat) { 
                                                        echo '<optgroup label="'.$mainCat['CategoryName'].'">'.$mainCat['CategoryName']; 
                                                        $resultSubCat = getSubCategories($table, $mainCat['CategoryNum']); 
                                                        foreach($resultSubCat  as $subCat) {  
                                                            echo '<option value="'.$subCat['CategoryNum'].'"    ng-selected="editForms.Category6 === '.$subCat['CategoryNum'].' " >'.$subCat['CategoryName'].'</option>';    
                                                        }  
                                                        echo '</optgroup>';
                                                    } 
                                                ?>
                                              </select>           
                                        
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Category7">Category7</label>
                                            <!--<input class="form-control" id="Category7" name="Category7" value="{{editForms.Category7}}" ng-change="editThisForm('Category7', editForms.Category7)" ng-model="editForms.Category7" size="30" type="text" />-->
                                            <select class="form-control selectpicker" name="Category7"  ng-model="editForms.Category7"> 
                                                <optgroup label="Select Category">
                                                    <option value="" ng-if="!editForms.Category7"  ng-selected="{{editForms.Category7}}">Select Category</option>
                                                    <option value="0" ng-if="editForms.Category7 == 0" ng-selected="editForms.Category7 === 0">Select Category</option>
                                                    <option value="0" ng-hide="editForms.Category7 == 0" >--Remove Category--</option>
                                                </optgroup> 
                                                <?php  
                                                    $select = "";          
                                                    foreach($results  as $mainCat) { 
                                                        echo '<optgroup label="'.$mainCat['CategoryName'].'">'.$mainCat['CategoryName']; 
                                                        $resultSubCat = getSubCategories($table, $mainCat['CategoryNum']); 
                                                        foreach($resultSubCat  as $subCat) {  
                                                            echo '<option value="'.$subCat['CategoryNum'].'"    ng-selected="editForms.Category7 === '.$subCat['CategoryNum'].' " >'.$subCat['CategoryName'].'</option>';    
                                                        }  
                                                        echo '</optgroup>';
                                                    } 
                                                ?>
                                              </select>           
                                        
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Category8">Category8</label>
                                            <!--<input class="form-control" id="Category8" name="Category8" value="{{editForms.Category8}}" ng-change="editThisForm('Category8', editForms.Category8)" ng-model="editForms.Category8" size="30" type="text" />-->
                                            
                                            <select class="form-control selectpicker" name="Category8"  ng-model="editForms.Category8"> 
                                                <optgroup label="Select Category">
                                                    <option value="" ng-if="!editForms.Category8"  ng-selected="{{editForms.Category8}}">Select Category</option>
                                                    <option value="0" ng-if="editForms.Category8 == 0" ng-selected="editForms.Category8 === 0">Select Category</option>
                                                    <option value="0" ng-hide="editForms.Category8 == 0" >--Remove Category--</option>
                                                </optgroup> 
                                                <?php  
                                                    $select = "";          
                                                    foreach($results  as $mainCat) { 
                                                        echo '<optgroup label="'.$mainCat['CategoryName'].'">'.$mainCat['CategoryName']; 
                                                        $resultSubCat = getSubCategories($table, $mainCat['CategoryNum']); 
                                                        foreach($resultSubCat  as $subCat) {  
                                                            echo '<option value="'.$subCat['CategoryNum'].'"    ng-selected="editForms.Category8 === '.$subCat['CategoryNum'].' " >'.$subCat['CategoryName'].'</option>';    
                                                        }  
                                                        echo '</optgroup>';
                                                    } 
                                                ?>
                                              </select>           
                                        
                                        </div>
                                     </div>
                            </div>
                        </div>

    
   <!-- Collapse 2A-->      
    </div>       
   </div>
</div>       

<!-- Collapse 2 Heading-->
<div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link btn-100 collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" ng-click="updatePageTracking(editForms.Code, '<?php echo $userID; ?>', 'edit products')">
             Branding &amp;  Additional Cost 
        </button>
      </h5>
    </div>
                    
<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
    <div class="card-body">
        <!-- Collapse 2-->

 
                    <div class='row margin-top-light'  > 
                        <div class="col-md-2">
                                <div class='form-group'>
                                    <label for="FullColour">Full Colour</label>
                                    <!--<input class="form-control" id="FullColour" name="FullColour" value="{{editForms.FullColour}}" ng-model="editForms.FullColour" size="30" type="text" />-->
                                    
                                    <select class="form-control " name="FullColour"  ng-model="editForms.FullColour"> 
                                        <?php 
                                            foreach ($selectDefault as $key => $value){
                                                echo '<option value="'.$key.'"  ng-selected="editForms.FullColour === '.$key.'" >'.$value.'</option>';
                                            }
                                        ?> 
                                    </select>
                                </div>   
                        </div> 
                    </div>   

                                           

                     <p ng-if="editForms.UpgradeAddOptionsCount == 0 && editForms.UpgradeIfConverted== 0">  No Additional Cost and Branding found, <a href="/TGP-Admin/additional-cost-configurator" class="text-red"> click here </a> to convert  </p>

                     <div ng-if="editForms.UpgradeIfConverted== 1"> 

                     <hr />
                       
                            <div class="row"> 
                                <div class="col-md-3">    
                                    <div class='form-group small-text'>
                                                    <label for="selectTypesPricing">Pricing Type</label>            
                                                    <select class="form-control selectpicker "  name="selectTypesPricing"  ng-model="additionalPricingType"   > 
                                                        <option value="">Select Pricing Type: </option>
                                                        <option ng-repeat="typs in selectTypesPricing"  ng-value="typs">{{typs}}</option>
                                                    </select>
                                    </div>       
                                </div> 
                                <div class="col-md-3">    
                                    <span  ng-show="additionalPricingType" class="btn btn-danger  margin-top-btn" ng-click="formAdditionalBrandingSubmittedUpgrade(editForms.Prim, editForms.Name, editForms.Code, additionalPricingType )" >Add Branding &amp; Additional Cost</span> 
                                    <span  ng-show="!additionalPricingType" class="btn btn-light  margin-top-btn" ng-click="sendAlert()" >Add Branding &amp; Additional Cost</span> 
                                </div>     
                            </div>   

                     </div>
                    
                      
                    
                    <!-- UPGRADE BRANDING AND ADDITIONAL COST -->                       
                    <div class="panel-group " id="accordionBrandingNew"     >  
                        <div class="panel panel-default pricing-accordion brandingAdditionalcost"   ng-repeat="upgradeAdds in editForms.UpgradeFilterKeys" ng-if="editForms.UpgradeAddOptionsCount && editForms.UpgradeFilteredAdditionalList[upgradeAdds][0].PricingType" ng-class="editForms.UpgradeFilteredAdditionalList[upgradeAdds][0].brandAdditionalNew == 1? 'bgnewForm': '' "  > 
                           
                                    
                                    <div class="panel-heading">
                                        <p class="panel-title" style="margin-bottom: 0px !important">
                                            <a data-toggle="collapse" data-parent="#accordionBrandingNew" ng-click="collapseAll()" href="#collapse{{editForms.UpgradeFilteredAdditionalList[upgradeAdds][0].additionalCostID}}Drop" style="display:block">
                                                   {{editForms.UpgradeFilteredAdditionalList[upgradeAdds][0].PricingType}} 
                                               
                                            </a>
                                        </p>
                                    </div>

                                    <div id="collapse{{editForms.UpgradeFilteredAdditionalList[upgradeAdds][0].additionalCostID}}Drop" class="panel-collapse collapse "  style="width:97.7%">
                                        <div class="panel-body"> 


                                               <!-- Indside Accordion  -->

                                                 <hr />

                                                    <div class="panel-group margin-top" id="accordionBrandingNewTwo"    ui-sortable = "sortableOptions" ng-model="editForms.UpgradeFilteredAdditionalList[upgradeAdds]"  > 
                                                        
                                                        <div class="panel panel-default   brandingInside-accordion"   ng-repeat="ind in editForms.UpgradeFilteredAdditionalList[upgradeAdds]"   >  
                                                    
                                                                <div class="panel-heading brandingInsideTwo "> 
                                                                        <div class="row">
                                                                            <div class="col-md-11">
                                                                                <p class="panel-title text-white " style="margin-bottom: 0px !important">
                                                                                    <a data-toggle="collapse" data-parent="#accordionPricingNewTwo" href="#collapseBrand{{$index}}{{editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].additionalCostID}}" ng-click="collapseAll()" style="display:block" ng-class="(editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].Status=='New') ? 'bgnewFormBrand' : ' '">
                                                                                        <i class="fa  fa-arrows-alt"></i> &nbsp;  

                                                                                        <span ng-if="editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].brandingMethod">{{editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].brandingMethod}}</span> <span ng-if="!editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].brandingMethod"> N/A </span> 
                                                                                        |  <span ng-if="editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].brandingArea">{{cleanString(editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].brandingArea)}}</span> <span ng-if="!editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].brandingArea"> N/A </span> 
                                                                                        |  <span ng-if="editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].costDescription">{{editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].costDescription}}</span> <span ng-if="!editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].costDescription"> N/A </span> 
            
                                                                                    </a>
                                                                                </p> 
                                                                            </div>
                                                                            <div class="col-md-1">
                                                                                <span ng-if="editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].Status !='New' " ng-show="!editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].brandAdditionalNew"  class="trash_addbranding text-white  btn-removes" ng-click="removeAddsBranding(editForms.Prim, editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].additionalCostID)"> DELETE </span>   
                                                                            </div>
                                                                        </div> 
                                                                    
                                                                </div>

                                                                

                                                                <div id="collapseBrand{{$index}}{{editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].additionalCostID}}" class="panel-collapse collapse "  style="width:97.7%">
                                                                    <div class="panel-body"> 

                                                                          
                                                                                
                                                                            <div class="row margin-top">
                                                                                <div class="col-md-5">


                                                                                        <div class="row">
                                                                                            <div class="col-md-4 text-right">
                                                                                                Cost Type:
                                                                                            </div>
                                                                                            <div class="col-md-8 text-left">  
                                                                                                <select class="form-control selectpicker  "    name="additionalOptionCategory"  data-ng-options="aoc for aoc in jsonAdditionals[0].jsonArrays.additionalOptionCategory" ng-model="editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].additionalOptionCategory"  > </select>  
                                                                                                
                                                                                            </div> 
                                                                                        </div> 

                                                                                        <div class="row">
                                                                                            <div class="col-md-4 text-right">
                                                                                                Branding Method
                                                                                            </div>
                                                                                            <div class="col-md-8 text-left position-relative brands "> 
                                                                                                <input class="form-control" id="BrandingMethodAdds{{$index}}"  ng-click="searchBrandingOptions(upgradeAdds, $index)" name="BrandingMethodAdds" ng-value="editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].brandingMethod"  ng-model="editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].brandingMethod"  type="text" /> 
                                                                                                
                                                                                                <div class="floatBrandingOption floatBrand{{upgradeAdds}}{{$index}}"  >
                                                                                                    <i class="fa fa-times-circle removeBrandPop" ng-click="collapseAll()"></i>
                                                                                                    
                                                                                                    <ul>
                                                                                                        <li ng-repeat="brn in  BrandingOptionDropdown  | filter : editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].brandingMethod " ng-click="updateBranding(upgradeAdds, $parent.$index, brn)"> {{brn}}</li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                                
                                                                                                 
                                                                                                
                                                                                            </div> 
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-4 text-right">
                                                                                                Branding Area
                                                                                            </div>
                                                                                            <div class="col-md-8 text-left">
                                                                                                <input class="form-control" id="BrandingAreaAdds{{$index}}" name="BrandingAreaAdds" ng-value="cleanString(editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].brandingArea)"  ng-model="editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].brandingArea"  type="text" /> 
                                                                                            </div> 
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-4 text-right">
                                                                                                Max. Per Position
                                                                                            </div>
                                                                                            <div class="col-md-8 text-left">
                                                                                                <input class="form-control" id="MaxPerAdds{{$index}}" name="MaxPerAdds" ng-value="editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].maxPerUnit"  ng-model="editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].maxPerUnit"  type="text" />
                                                                                            </div> 
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-4 text-right">
                                                                                                Cost Description
                                                                                            </div>
                                                                                            <div class="col-md-8 text-left">
                                                                                                <input class="form-control" id="CostDescAdds{{$index}}" name="CostDescAdds" ng-value="editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].costDescription"  ng-model="editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].costDescription"  type="text" />
                                                                                            
                                                                                            </div> 
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-4 text-right">
                                                                                                Price Per Unit Code
                                                                                            </div>
                                                                                            <div class="col-md-8 text-left"> 
                                                                                                      <select class="form-control selectpicker"  ng-model="editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].pricePerUnitItemCode"   ng-options="item.StockCode as item.StockCode + ' - ' + item.ProductClass  + ' - ' +  item.Description01  for item in  FirstAPI  ">
                                                                                                           
                                                                                                      </select>   
                                                                                            </div> 
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div class="col-md-4 text-right">
                                                                                                Price Per order Code
                                                                                            </div>
                                                                                            <div class="col-md-8 text-left">

                                                                                                    <select class="form-control selectpicker"  ng-model="editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].pricePerOrderCode"   ng-options="item.StockCode as item.StockCode + ' - ' + item.ProductClass  + ' - ' +  item.Description01  for item in  SecondAPI  ">
                                                                                                           
                                                                                                    </select>   
                                                                                                
                                                                                            </div> 
                                                                                        </div>

                                                                                </div>
                                                                                <div class="col-md-7">


                                                                                    <!--Currency --> 

                                                                                        <table class="table table-bordered">
                                                                                                    <thead>
                                                                                                        <tr> 
                                                                                                            <th width="200" scope="col">Currency</th>
                                                                                                            <th scope="col">Unit Price</th>
                                                                                                            <th scope="col">Per Order Price</th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        <tr> 
                                                                                                            <th width="200"  scope="row">NZD</th>
                                                                                                            <td><input class="form-control" id="nzdUnitPrice{{$index}}" name="nzdUnitPrice" smart-float   ng-model="editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].NZDUnitPrice"  type="text"   /> </td>
                                                                                                            <td><input class="form-control" id="nzdOrderPrice{{$index}}" name="nzdOrderPrice" smart-float   ng-model="editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].NZDOrderPrice"  type="text" /></td>
                                                                                                        </tr>
                                                                                                        <tr> 
                                                                                                            <th width="200"  scope="row">AUD</th>
                                                                                                            <td><input class="form-control" id="audUnitPrice{{$index}}" name="audUnitPrice" smart-float   ng-model="editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].AUDUnitPrice"  type="text" /> </td>
                                                                                                            <td><input class="form-control" id="audOrderPrice{{$index}}" name="audOrderPrice" smart-float  ng-model="editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].AUDOrderPrice"  type="text" /></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <th width="200"  scope="row">SGD</th>
                                                                                                            <td><input class="form-control" id="sgdUnitPrice{{$index}}" name="sgdUnitPrice" smart-float  ng-model="editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].SGDUnitPrice"  type="text" /> </td>
                                                                                                            <td><input class="form-control" id="sgdOrderPrice{{$index}}" name="sgdOrderPrice" smart-float  ng-model="editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].SGDOrderPrice"  type="text" /></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <th width="200"  scope="row">MYR</th>
                                                                                                            <td><input class="form-control" id="myrUnitPrice{{$index}}" name="myrUnitPrice" smart-float   ng-model="editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].MYRUnitPrice"  type="text" /> </td>
                                                                                                            <td><input class="form-control" id="myrOrderPrice{{$index}}" name="myrOrderPrice" smart-float  ng-model="editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].MYROrderPrice"  type="text" /></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                        </table>


                                                                                    <!-- Currency -->





                                                                                </div>
                                                                            </div>
                                                                            <p>&nbsp;</p> 

                                                                       
                                                                            <p ng-if="editForms.UpgradeFilteredAdditionalList[upgradeAdds][$index].Status =='New'   " ng-click="cancelNewAddBranding(editForms.Prim)" class="text-right"><span class="btn btn-danger">Cancel</span> </p> 
                                                                        
                                                                    </div>
                                                                </div>

                                                                



 



                                                        </div>
                                                    </div>    

                                               <!-- Inside Accordion-->

                                                

                                              <span class="btn btn-trends margin-bottom margin-top" ng-if="editForms.UpgradeFilteredAdditionalList[upgradeAdds][0].brandAdditionalNew != 1 "  ng-click="addNewBrandingAdditionalCost(editForms.Prim, editForms.Code, editForms.UpgradeFilteredAdditionalList[upgradeAdds][0].PricingType, upgradeAdds)"> New </span>
                                              <p ng-if="editForms.UpgradeFilteredAdditionalList[upgradeAdds][0].brandAdditionalNew == 1  " ng-click="cancelNewAddBranding(editForms.Prim)" class="text-right"><span class="btn btn-danger">Cancel</span> </p>   
                                            

                                        </div>
                                    </div>  
                                    
                                   

                        </div>               
                    </div>    
                    <!-- UPGRADE BRANDING AND ADDITIONAL COST -->

 

   <!-- Collapse 2-->      
     </div>       
   </div>
</div>   


<!-- Collapse 3 Heading-->
<div class="card">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-link btn-100 collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" ng-click="updatePageTracking(editForms.Code, '<?php echo $userID; ?>', 'edit products')">
              Packing 
        </button>
      </h5>
    </div>
                    
<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
    <div class="card-body">
        <!-- Collapse 3 -->
                        
                        

                        <!--<hr />
                        <h4><span class="badge badge-secondary">Packing, Carton measurements & Quantity</span></h4>-->
                        <div class="row">
                            <div class='col-sm-6'>
                                <div class='form-group'>
                                    <label for="Packing">Packing</label>
                                    <input class="form-control" id="Packing" name="Packing" value="{{editForms.Packing}}" ng-model="editForms.Packing" size="30" type="text" />
                                </div>
                            </div>
                        </div>    
                        <div class="row cols-five">    
                            <div class="col-md-2 ">
                                <div class='form-group'>
                                    <label for="cartonLength">Carton Length</label>
                                    <input class="form-control" id="cartonLength" name="cartonLength" value="{{editForms.cartonLength}}" ng-model="editForms.cartonLength" size="30" type="text" />
                                    <div   class="errorCartonLengthReq text-red labelreq reqfield" ng-show="errorCartonLength">{{errorCartonLength}}</div>       
                                </div>  
                            </div>
                            <div class="col-md-2">
                                <div class='form-group'>
                                    <label for="cartonWidth">Carton Width</label>
                                    <input class="form-control" id="cartonWidth" name="cartonWidth" value="{{editForms.cartonWidth}}" ng-model="editForms.cartonWidth" size="30" type="text" />
                                    <div   class="errorCartonWidthReq text-red labelreq reqfield" ng-show="errorCartonWidth">{{errorCartonWidth}}</div>          
                                </div>  
                            </div>
                            <div class="col-md-2">
                                <div class='form-group'>
                                    <label for="cartonHeight">Carton Height</label>
                                    <input class="form-control" id="cartonHeight" name="cartonHeight" value="{{editForms.cartonHeight}}" ng-model="editForms.cartonHeight" size="30" type="text" />
                                    <div   class="errorCartonHeightReq text-red labelreq reqfield" ng-show="errorCartonHeight">{{errorCartonHeight}}</div>       
                                </div>   
                            </div>
                            <div class="col-md-2">
                                <div class='form-group'>
                                    <label for="cartonWeight">Carton Weight</label>
                                    <input class="form-control" id="cartonWeight" name="cartonWeight" value="{{editForms.cartonWeight}}" ng-model="editForms.cartonWeight" size="30" type="text" />
                                </div>   
                            </div>
                            <div class="col-md-2">
                                <div class='form-group'>
                                    <label for="cartonQuantity">Carton Quantity</label>
                                    <input class="form-control" id="cartonQuantity" name="cartonQuantity" value="{{editForms.cartonQuantity}}" ng-model="editForms.cartonQuantity" size="30" type="text" />
                                    <div   class="errorCartonQuantityReq text-red labelreq reqfield" ng-show="errorCartonQuantity">{{errorCartonQuantity}}</div>          
                                </div>   
                            </div>
                        </div>


                        
                       
   <!-- Collapse 3-->  
     </div>           
   </div>
</div>   



 
<!-- Collapse 5 Heading-->
 
<div class="card">
    <div class="card-header" id="headingFive">
      <h5 class="mb-0">
        <button class="btn btn-link btn-100 collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive" ng-click="updatePageTracking(editForms.Code, '<?php echo $userID; ?>', 'edit products')">
            Pricing
        </button>
      </h5>
    </div>
                    
<div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
    <div class="card-body">
        
        
                                            
 

        <p ng-if="editForms.UpgradePricingCount == 0"> The Additional Cost is not converted for this item, please <a href="/TGP-Admin/additional-cost-configurator" class="text-red"> click here </a> </p>
        
        <div ng-if="editForms.UpgradePricingCount > 0">

                <div class="alert alert-pricing" ng-if="!hideNewForm"  >
                    <div class="row"> 
                        <div class="col-md-3">    
                            <div class='form-group small-text'>
                                            <label for="selectTypesPricing">Pricing Type</label>            
                                            <select class="form-control selectpicker "  name="selectTypesPricing"  ng-model="formPricingTable.TypesPricingModel"   > 
                                                <option value="">Select Pricing Type: </option>
                                                <option ng-repeat="typs in selectTypesPricing"  ng-value="typs">{{typs}}</option>
                                            </select>
                            </div>       
                        </div> 
                        <div class="col-md-3">    
                            <span  ng-show="formPricingTable.TypesPricingModel" class="btn btn-danger  margin-top-btn" ng-click="formPricingSubmittedUpgrade(editForms.Prim, editForms.Name, editForms.Code, formPricingTable.TypesPricingModel )" >Add Price</span> 
                            <span  ng-show="!formPricingTable.TypesPricingModel" class="btn btn-light  margin-top-btn" ng-click="sendAlert()" >Add Price</span> 
                        </div>     
                    </div>  
                </div>




                 

 

 
                <div class="panel-group " id="accordionPricingNew"   ui-sortable = "sortableOptions" ng-model="editForms.UpgradeFilteredPricing" > 


 

                                            
                        <div class="panel panel-default pricing-accordion"  ng-if="editForms.UpgradeFilteredPricing[pricelist][0].PricingType"  ng-repeat="pricelist in editForms.UpgradeFilterKeys"  ng-class="(editForms.UpgradeFilteredPricing[pricelist][0].Status=='New') ? 'bgnewForm' : ' '"> 
                                
                                <div class="panel-heading">
                                    <p class="panel-title" style="margin-bottom: 0px !important">
                                        <a data-toggle="collapse" data-parent="#accordionPricingNew" href="#collapse{{$index}}{{editForms.UpgradeFilteredPricing[pricelist][0].Coode}}" style="display:block">
                                            <i class="fa  fa-arrows-alt"></i> &nbsp;  {{editForms.UpgradeFilteredPricing[pricelist][0].PricingType}} <span class="text-red" ng-if="editForms.UpgradeFilteredPricing[pricelist][0].Status == 'New'">(* Note: Please save the whole form for this new pricing)</span>
                                        </a>
                                    </p>
                                </div>
                            
                                <div id="collapse{{$index}}{{editForms.UpgradeFilteredPricing[pricelist][0].Coode}}" class="panel-collapse collapse "  style="width:97.7%">
                                    <div class="panel-body"> 

                                     
                                        <div class="row margin-top-light  margin-bottom"> 
                                            <div class="col-md-3">
                                                <label for="selectTypesPricing">Pricing Type</label>            
                                               <!-- <select class="form-control selectpicker "  name="selectTypesPricing"  ng-model="editForms.UpgradeFilteredPricing[pricelist][0].PricingType" ng-change="changePricingType()" readonly >  
                                                    <option value="">Select Pricing Type: </option>
                                                    <option ng-repeat="typs in selectTypesPricing"  ng-value="typs">{{typs}}</option>
                                                </select> -->
                                               
                                                <input class="form-control" id="selectTypesPricing" name="selectTypesPricing" ng-value="editForms.UpgradeFilteredPricing[pricelist][0].PricingType"   ng-model="editForms.UpgradeFilteredPricing[pricelist][0].PricingType" size="30" type="text" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="PricingOrder">Pricing Order</label>  
                                                <input class="form-control" id="PriceOrder" name="PriceOrder" ng-value="$index + 1"   ng-model="editForms.UpgradeFilteredPricing[pricelist][0].PriceOrder" size="30" type="text" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="LessthanMOQ">Less than MOQ Available</label>   
                                                <?php $selectYesNo = array('N' => 'No', 'Y'=>'Yes'); ?>
                                                <select class="form-control " name="LessthanMOQ"  ng-model="editForms.UpgradeFilteredPricing[pricelist][0].LessThanMOQ"> 
                                                    <?php 
                                                        foreach ($selectYesNo as $key => $value){
                                                            echo '<option value="'.$key.'"  ng-selected="editForms.UpgradeFilteredPricing[pricelist][0].LessThanMOQ === '.$key.'" >'.$value.'</option>';
                                                        }
                                                    ?> 
                                                </select>
                                            </div>
                                            <div class="col-md-2"> 
                                                <label for="selectPrimaryPriceDescription">Primary Price Type</label>   
                                                <?php $primType = getPrimaryPriceType(); ?>
                                                <select class="form-control selectpicker" name="PriceType"  ng-model="editForms.UpgradeFilteredPricing[pricelist][0].PriceType" >  
                                                    <?php
                                                        foreach ($primType as $key => $value){
                                                            echo '<option  value="'.$key.'"    ng-selected="editForms.UpgradeFilteredPricing[pricelist][0].PriceType === '.$key.' " >'.$value.'</option>';  
                                                        }

                                                    ?>     
                                                </select>       
                                            </div>
                                        </div>


                                        
                                        <div class="row margin-top-light margin-bottom">
                                                <div class="col-md-12">  
                                                    <label for="AdditionalText">Pricing Comment</label>      
                                                    <textarea class="form-control" id="AdditionalText" name="AdditionalText"   ng-model="editForms.UpgradeFilteredPricing[pricelist][0].AdditionalText"></textarea>    
                                                </div> 
                                        </div>       

                                          
                                          

                                            <table class="table  table-bordered" > 
                                                <thead>
                                                    <tr>
                                                        <th colspan="9">  <input class="form-control col-md-12 table-input" id="PrimaryPriceDes" name="PrimaryPriceDes" ng-value="editForms.UpgradeFilteredPricing[pricelist][0].PrimaryPriceDes"   ng-model="editForms.UpgradeFilteredPricing[pricelist][0].PrimaryPriceDes" placeholder="Primary Price Des" size="30" type="text"> </th> 
                                                    </tr>
                                                </thead>
                                            
                                                <tbody >
                                                    <tr  >
                                                        <th scope="row">Quantity</th>
                                                        <td> <input class="form-control  table-data-input quantity1" id="Quantity1" name="Quantity1" ng-value="editForms.UpgradeFilteredPricing[pricelist][0].Quantity1" allow-only-numbers    ng-model="editForms.UpgradeFilteredPricing[pricelist][0].Quantity1" size="30" type="text" placeholder="Quantity1"  > </td>
                                                        <td> <input class="form-control  table-data-input quantity2" id="Quantity2" name="Quantity2" ng-value="editForms.UpgradeFilteredPricing[pricelist][0].Quantity2" allow-only-numbers    ng-model="editForms.UpgradeFilteredPricing[pricelist][0].Quantity2" size="30" type="text" placeholder="Quantity2"  >  </td>
                                                        <td> <input class="form-control  table-data-input quantity3" id="Quantity3" name="Quantity3" ng-value="editForms.UpgradeFilteredPricing[pricelist][0].Quantity3" allow-only-numbers    ng-model="editForms.UpgradeFilteredPricing[pricelist][0].Quantity3" size="30" type="text" placeholder="Quantity3"  >  </td>
                                                        <td> <input class="form-control  table-data-input quantity4" id="Quantity4" name="Quantity4" ng-value="editForms.UpgradeFilteredPricing[pricelist][0].Quantity4" allow-only-numbers    ng-model="editForms.UpgradeFilteredPricing[pricelist][0].Quantity4" size="30" type="text" placeholder="Quantity4"  >  </td>
                                                        <td> <input class="form-control  table-data-input quantity5" id="Quantity5" name="Quantity5" ng-value="editForms.UpgradeFilteredPricing[pricelist][0].Quantity5" allow-only-numbers    ng-model="editForms.UpgradeFilteredPricing[pricelist][0].Quantity5" size="30" type="text" placeholder="Quantity5"  >  </td>
                                                        <td> <input class="form-control  table-data-input quantity6" id="Quantity6" name="Quantity6" ng-value="editForms.UpgradeFilteredPricing[pricelist][0].Quantity6" allow-only-numbers    ng-model="editForms.UpgradeFilteredPricing[pricelist][0].Quantity6" size="30" type="text" placeholder="Quantity6"  >  </td>
                                                        <td> &nbsp; </td>
                                                        <td> Use Change Log </td>
                                                    </tr>
                                                    <tr  ng-repeat="price in editForms.UpgradeFilteredPricing[pricelist]" id="removeCheckBox{{pricelist}}{{$index}}">
                                                        <th scope="row">{{price.Currency}}   </th>
                                                        <td> <input class="form-control  table-data-input Price1{{pricelist}}{{$index}}" id="Price1" name="Price1" ng-value="price.Price1"  smart-float ng-model="editForms.UpgradeFilteredPricing[pricelist][$index].Price1"  ng-keydown="changeTab($event, 1, 2, pricelist, $index)" size="30" type="text" placeholder="Price1" onfocus="this.select()" > </td>
                                                        <td> <input class="form-control  table-data-input Price2{{pricelist}}{{$index}}" id="Price2" name="Price2" ng-value="price.Price2"  smart-float ng-model="editForms.UpgradeFilteredPricing[pricelist][$index].Price2" ng-keydown="changeTab($event, 2, 2, pricelist, $index)" size="30" type="text" placeholder="Price2" onfocus="this.select()"> </td>
                                                        <td> <input class="form-control  table-data-input Price3{{pricelist}}{{$index}}" id="Price3" name="Price3" ng-value="price.Price3"  smart-float ng-model="editForms.UpgradeFilteredPricing[pricelist][$index].Price3" ng-keydown="changeTab($event, 3, 2, pricelist, $index)" size="30" type="text" placeholder="Price3" onfocus="this.select()" > </td>
                                                        <td> <input class="form-control  table-data-input Price4{{pricelist}}{{$index}}" id="Price4" name="Price4" ng-value="price.Price4"  smart-float ng-model="editForms.UpgradeFilteredPricing[pricelist][$index].Price4" ng-keydown="changeTab($event, 4, 2, pricelist, $index)" size="30" type="text" placeholder="Price4" onfocus="this.select()"> </td>
                                                        <td> <input class="form-control  table-data-input Price5{{pricelist}}{{$index}}" id="Price5" name="Price5" ng-value="price.Price5"  smart-float ng-model="editForms.UpgradeFilteredPricing[pricelist][$index].Price5" ng-keydown="changeTab($event, 5, 2, pricelist, $index)" size="30" type="text" placeholder="Price5" onfocus="this.select()"> </td>
                                                        <td> <input class="form-control  table-data-input Price6{{pricelist}}{{$index}}" id="Price6" name="Price6" ng-value="price.Price6"  smart-float ng-model="editForms.UpgradeFilteredPricing[pricelist][$index].Price6" ng-keydown="changeTab($event, 6, 2, pricelist, $index)" size="30" type="text" placeholder="Price6" onfocus="this.select()"> </td>
                                                        <td> <span class="cursorpoint text-red" ng-if="price.Status != 'New'" ng-click="removePricingCurrency(editForms.Prim, price.index, price.Coode, price.Currency)"> <i class="fa fa-times"></i> </span> </td>
                                                        <td> <span class="cursorpoint  " ng-if="price.Status != 'New'" ng-click="addToChangeLog(price.index, price.Coode, price.Currency, editForms.changeLogUpgrade[pricelist][$index], editForms.UpgradeFilteredPricing[pricelist][0].PricingType )"> <input type="checkbox" ng-model="editForms.changeLogUpgrade[pricelist][$index]"  />  </span> </td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                            <span class="text-red" ng-if="editForms.UpgradeFilteredPricing[pricelist][0].Status == 'New'"> * Note: Please save the whole form for this new pricing. <br />
                                                Leave the Quantities and Pricing to 0, this will not take any action neither save into the Database. 
                                            </span>
                                            

                                                    
                                           <!-- <span class="cursorpoint" ng-click="insertChangeLogAdditionalCost(1, editForms.UpgradeFilteredPricing[pricelist][$index].Currency, hereFin[editForms.UpgradeFilteredPricing[pricelist][$index].index], editForms.UpgradeFilteredPricing[pricelist][$index].PricingType,  $index )" ng-if="!changeLogsAdditional[pricelist]"> <i class="fa fa-toggle-off"></i> Add Auto Comment to Additional Costs </span> 
                                            <span class="cursorpoint" ng-click="insertChangeLogAdditionalCost(0, editForms.UpgradeFilteredPricing[pricelist][$index].Currency, hereFin[editForms.UpgradeFilteredPricing[pricelist][$index].index], editForms.UpgradeFilteredPricing[pricelist][$index].PricingType,   $index )" ng-if="changeLogsAdditional[pricelist]"> <i class="fa fa-toggle-on"></i> Remove Auto Comment from Additional Costs  </span>
                                        
                                             

                                            <div class="row margin-top-light changelog"  ng-if="editForms.changeTypePricingAdditional[pricelist] != 0" >  
                                                <div class="col-md-4">  
                                                    <?php // $changeTypes = getChangeTypes($table); ?>
                                                    <select   class="form-control "    ng-model="editForms.changeTypePricingAdditional[pricelist]"   >
                                                        <option value=""> --  Select -- </option>
                                                        <?php  /*
                                                                foreach($changeTypes as $ctypeKey => $ctypeValue){
                                                                    echo  '<option value='.$ctypeValue['indexNum'].'>' .$ctypeValue['changeType']. '</option>';
                                                                }  */
                                                        ?>
                                                        
                                                    </select> 
                                                </div>
                                                <div class="col-md-4">  
                                                    <textarea class="form-control"  ng-model="editForms.ChangeDescriptionPricingAdditional[pricelist]" placeholder="Enter Description"    ></textarea>
                                                    
                                                </div>
                                            </div>   
                                            
                                            <p>&nbsp;</p>-->
                                          
                                           
                                                                







                                            <p class="margin-top text-right"> <span class="btn btn-danger " ng-if="editForms.UpgradeFilteredPricing[pricelist][0].Status == 'New'" ng-click="cancelNewPricing(editForms.Prim)"  > Cancel </span>  <span class="btn btn-danger " ng-if="editForms.UpgradeFilteredPricing[pricelist][0].Status != 'New'" ng-click="removePricingUpgrade(editForms.Prim, editForms.Code, editForms.UpgradeFilteredPricing[pricelist][0].PricingType)" ng-show="!removeBtnPricing"> <i class="fa  fa-trash "></i> Remove Pricing</span> </p>
                                                        
                                            
                                                    
                                    </div> 
                                </div>         

                        </div> 
                </div>                                
                                       
        </div>
         


        <!-- Magic Ends -->
        
                                            

                                            
        <p>&nbsp;</p>
    </div>          
  </div>
</div>     
 <!-- Collapse 5-->   





<!-- Collapse 8 Heading-->
<div class="card">
    <div class="card-header" id="headingEight">
      <h5 class="mb-0">
        <button class="btn btn-link btn-100 collapsed" type="button" data-toggle="collapse" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight" ng-click="updatePageTracking(editForms.Code, '<?php echo $userID; ?>', 'edit products')">
                     Carrier Option
        </button>
      </h5>
    </div>
                    
<div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordion">
    <div class="card-body">
        <!-- Collapse 8 -->
                   <?php $resultDespatch = getDespatchLocation($table);    ?>   
                                                   
                   <div class="row">
                        <div class="col-sm-3">    
                            <div class="form-group"> 
                                <label for="despatchLocation">Despatch Location: </label>  
                                <select class="form-control selectpicker" name="despatchLocation"  ng-model="editForms.despatchLocation" ng-change="despatchChange(editForms.despatchLocation)" > 
                                    <?php 
                                        foreach($resultDespatch   as $resultdes) {  
                                            echo '<option value="'.$resultdes['Prim'].'"    ng-selected="editForms.despatchLocation === '.$resultdes['Prim'].' " >'.$resultdes['Name'].'</option>';               
                                        } 
                                     
                                    ?>
                                </select>
                                   
                                    
                            </div>
                        </div>
                    </div>   
                                      
                    <div class="row margin-top">
                        <div class="col-sm-8">    
                            <p><label for="freightOptions">Freight Options: </label>  </p>
                            <!-- ng-if="editForms.despatchLocation == freightName.despatchLocation"-->                
                            <label class="col-md-4" ng-repeat="freightName in freights"   >
                                <input
                                    class="usercheckbox"
                                    type="checkbox"
                                    name="selectedFreightIDs[]"
                                    value="{{freightName.Prim}}" 
                                    ng-checked="selectionFreights.indexOf(freightName.Prim) > -1"
                                    ng-click="toggleSelectionFreight(freightName.Prim)" 
                                    ng-disabled="editForms.despatchLocation != freightName.despatchLocation"
                                    >   {{freightName.Name}} - {{freightName.Carrier}}      
                            </label>   

                        </div>
                    </div>                                  

     <p>&nbsp;</p>
    </div>          
  </div>
</div>     
 <!-- Collapse 8-->   






<!-- Collapse 7 Heading-->
<div class="card">
    <div class="card-header" id="headingSeven">
      <h5 class="mb-0">
        <button class="btn btn-link btn-100 collapsed" type="button" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven" ng-click="updatePageTracking(editForms.Code, '<?php echo $userID; ?>', 'edit products')">
                     Images
        </button>
      </h5>
    </div>

<div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordion">
    <div class="card-body">
        <!-- Collapse 7 -->
                    
             <p class="text-red"><strong>Note: Uploading and modifying of images section including the Stock Code and Colour are auto save. If you have any changes on the other fields above or below please click the update button first. </strong></p>              

            <div class="row margin-top"  ng-show="editImagesActive">  
                <div class="col-md-12">
                   
                    <div class="row images-loop margin-top"   >
                         
                        <div class="col-md-3 margin-top-light images-cols images-margin" ng-repeat=" imgs in editForms.ImagesLoop"> 

                        <span ng-show="editImageCountOrig == $index" class="deleteImage" ng-click="removeImage(editImagePrim, editForms.Code, $index)"> <i class="fa  fa-trash "></i></span>
                            <span class="remove-selected  remove-selected{{$index}}"   >  
                                <div class="radio radio-primary">
                                    <input type="radio" name="radioSelected" id="radioSelected{{$index}}"   ng-value="{{$index}}" ng-model="editImageForm.selectImageToReplace">
                                    <label for="radioSelected{{$index}}">
                                        
                                    </label>
                                </div>
                            </span>


                            <div class="card image-card whitebackground" id="card{{$index}}" style="max-height: 440px;"     >

                            
                                <img src="../../Images/ProductImg/{{imgs.value}}?{{random}}" class="card-img-top img-responsive img-fluid" />  
                                <div class="card-body">
                                    <h5 class="card-title text-center">Image {{$index}}   </h5> 
                                    
                                    <div class="row stockcode-select" >
                                            
                                            <div class="col-md-12 column  "  >
                                                <span> <i>StockCode: </i></span>  <br />
                                                
                                                <div class="row">
                                                    <div class="col-md-10">    
                                                        <span class="stockCodeBox stockCodeBox{{imgs.imgNum}}" id="stockCode{{imgs.imgNum}}" >
                                                            <span  ng-repeat =" stock in productStocks"    ng-if="stock.ComponentCode === imgs.key"    > <strong> {{stock.PartName}} - {{stock.ComponentCode}} </strong> </span>
                                                        </span>    
                                                    </div>
                                                    <div class="col-md-2">    
                                                        <span    data-toggle="modal" data-target="#stockModal{{imgs.imgNum}}" class="pointer   display-block text-center"    >  <i class="fa fa-edit" style="font-size : 16px; position:relative; left:-4px;"></i> </span>
                                                    </div>   
                                                </div> 
                                            
                                            
                                            </div>
                                            <div class="col-md-12 margin-top-light column "  >
                                                <span><i>Colour:</i></span>  <br />

                                                <div class="row">
                                                    <div class="col-md-10">   
                                                        <span class="colourBox colourBox{{imgs.imgNum}}" id="colour{{imgs.imgNum}}">
                                                            <span ng-repeat ="colour in coloursSelects"     ng-if="colour === imgs.cols"   ><strong>{{colour}}</strong></span>
                                                        </span>
                                                    </div>
                                                    <div class="col-md-2">     
                                                        <span   data-toggle="modal" data-target="#colourModal{{imgs.imgNum}}" class="pointer display-block  text-center"    >  <i class="fa fa-edit" style="font-size : 16px; position:relative; left:-4px;"></i> </span>
                                                    </div>   
                                                </div>  
                                            </div>

                                            <div class="col-md-12 margin-top-light column "  > 
                                                <span><i>Caption:</i></span> <span ng-if="saving == imgs.imgNum">...saving</span> <br />
                                                <input class="form-control" type="text" style="font-size:12px" maxlength="20"  ng-change="captionUpdate(editForms.Code, imgs.Caption, imgs.imgNum )"  ng-model="imgs.Caption">  
                                            </div>


                                    </div>  

                                    
                                </div>
                            </div>
                                                    
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
                                            <li   value=""  ng-model="stock.ComponentCode"  ng-click="stockcodeChange(null, imgs.imgNum, editForms.Code, editForms.Prim)"    selected>--<i class="fa  fa-trash "></i> Remove --</li>
                                            <li   ng-repeat =" stock in productStocks"  ng-value="stock.ComponentCode"   ng-model="stock.ComponentCode"  ng-click="stockcodeChange(stock.ComponentCode, imgs.imgNum, editForms.Code, editForms.Prim, stock.PartName, stock.ComponentCode)"    >{{stock.PartName}} - {{stock.ComponentCode}}</li> 
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
                                            <li   value=""   ng-model="colour"  ng-click="stockcolourChange(null, imgs.imgNum, editForms.Code, editForms.Prim)"    selected> <i class="fa  fa-trash "></i> Remove </li>
                                            <li   ng-repeat =" colour in coloursSelects"   ng-value="colour"    ng-model="colour"   ng-click="stockcolourChange(colour, imgs.imgNum, editForms.Code, editForms.Prim)"    >  {{colour}} </li> 
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
                            <div class="card default image-card whitebackground" id="card" style=""     >
                                <img src="<?php echo $baseUrl; ?>/assets/images/default.jpg" class="card-img-top img-responsive img-fluid" />  
                                <div class="card-body cardbody-default">
                                    <h5 class="card-title text-center defaulth5">&nbsp;</h5> 
                                    <p class="defaulth5">&nbsp;</p>
                                </div>
                            </div>
                             
                        </div>

                       
                    </div>
                </div> 
            </div>  
            <p>&nbsp;</p>                                          
                                         
                             <form name="imageForm" id="imageForm"  > 
                                <div class="file-uploader text-center">
                                   <input type="file" id='file'  class="mainfile hide" ngf-select ng-model="picFile" ng-change="uploadFile(picFile)"  ng-click="editImageForm.FormFile =  editImageForm.selectImageToReplace" ng-model="editImageForm.FormFile" accept="image/jpeg"    /> 
                                    
                                    <p><img src="<?php echo $baseUrl; ?>/assets/images/upload-arrow.png" class="arrow-upload" /> <br /> <label for="file"  class="btn btn-danger btn-image-float">Select</label> </p>
                                  
                                </div>
                            </form>  
                            <p class="text-red"><strong>Note: Uploading and modifying of images section including the Stock Code and Colour are auto save.  If you have any changes on the other fields above or below please click the update button first.</strong></p>                                                



            <p>&nbsp;</p>                                   

                 
        <!-- Collapse 7-->   
  </div>          
  </div>
</div>     




<!-- Collapse 4 Heading-->
<div class="card">
    <div class="card-header" id="headingFour">
      <h5 class="mb-0">
        <button class="btn btn-link btn-100 collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" ng-click="updatePageTracking(editForms.Code, '<?php echo $userID; ?>', 'edit products')">
                     Miscellaneous
        </button>
      </h5>
    </div>
                    
<div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
    <div class="card-body">
        <!-- Collapse 4 -->
                         <!--<hr />
                         <h4><span class="badge badge-secondary">Miscellaneous</span></h4>-->
                        
                         <div class='row'>
                            <div class='col-sm-4'>    
                                <div class='form-group'>
                                    <label for="Keywords">Keywords</label>
                                    <input class="form-control" id="Keywords" name="Keywords" value="{{editForms.Keywords}}" ng-model="editForms.Keywords" size="30" type="text" />
                                </div>
                            </div>
                            <div class='col-sm-4'>
                                <div class='form-group'>
                                    <label for="Video">Video</label>
                                    <input class="form-control" id="Video" name="Video" value="{{editForms.Video}}" ng-model="editForms.Video" size="30" type="text" />
                                </div>
                            </div>
                            <div class='col-sm-4'>
                                <div class='form-group'>
                                    <label for="StockComment">Stock Comment</label>
                                    <input class="form-control" id="StockComment" name="StockComment" value="{{editForms.StockComment}}" ng-model="editForms.StockComment" size="30" type="text" />
                                </div>
                            </div>
                             
                        </div>


                        <div class="row miscellaneous ninecols">
                            <!--<div class="col-md-1">
                                <div class='form-group small-text'>
                                    <label for="PenIndent">Pen Indent</label>
                                    <input class="form-control" id="PenIndent" name="PenIndent" value="{{editForms.PenIndent}}" size="30" type="text" />
                                </div>  
                            </div>
                            <div class="col-md-1">
                                <div class='form-group small-text'>
                                    <label for="PlacementWeighting">Placement Weighting</label>
                                    <input class="form-control" id="PlacementWeighting" name="PlacementWeighting" value="{{editForms.PlacementWeighting}}" size="30" type="text" />
                                </div>  
                            </div>
                            <div class="col-md-1">
                                <div class='form-group small-text'>
                                    <label for="ImageCount">Image Count</label>
                                    <input class="form-control" id="ImageCount" name="ImageCount" value="{{editForms.ImageCount}}" size="30" type="text" />
                                </div>   
                            </div>-->
                            
                            
                            <!--<div class="col-md-1">
                                <div class='form-group small-text'>
                                    <label for="IsPen">Is Pen</label>
                                    <input class="form-control" id="IsPen" name="IsPen" value="{{editForms.IsPen}}" size="30" type="text" />
                                </div>   
                            </div>
                     
                            <div class="col-md-1">
                                <div class='form-group small-text'>
                                    <label for="StockWizDisable">StockWiz Disable</label>
                                    <input class="form-control" id="StockWizDisable" name="StockWizDisable" value="{{editForms.StockWizDisable}}" size="30" type="text" />
                                </div>  
                            </div>
                            <div class="col-md-1">
                                <div class='form-group small-text'>
                                    <label for="PDFDisable">PDF Disable</label>
                                    <input class="form-control" id="PDFDisable" name="PDFDisable" value="{{editForms.PDFDisable}}" size="30" type="text" />
                                </div>  
                            </div>-->
                           
                            <div class="col-md-2">
                                <div class='form-group small-text'>
                                    <label for="ExclusiveItem">Exclusive Item</label>
                                    <!--<input class="form-control" id="ExclusiveItem" name="ExclusiveItem" value="{{editForms.ExclusiveItem}}" ng-model="editForms.ExclusiveItem" size="30" type="text" />-->
                                    <select class="form-control " name="ExclusiveItem"  ng-model="editForms.ExclusiveItem"> 
                                        <?php 
                                            foreach ($selectDefault as $key => $value){
                                                echo '<option value="'.$key.'"  ng-selected="editForms.ExclusiveItem === '.$key.'" >'.$value.'</option>';
                                            }
                                        ?> 
                                    </select>        
                                
                                </div>   
                            </div>


                            <div class="col-md-2">
                                <div class='form-group small-text'>
                                    <label for="EcoItem">Eco Item</label>
                                    <select class="form-control " name="Eco"  ng-model="editForms.Eco"> 
                                        <?php 
                                            foreach ($selectDefault as $key => $value){
                                                echo '<option value="'.$key.'"  ng-selected="editForms.Eco === '.$key.'" >'.$value.'</option>';
                                            }
                                        ?> 
                                    </select>        
                                
                                </div>   
                            </div>

                            <div class="col-md-2">
                                <div class='form-group small-text'>
                                    <label for="RecycleItem">Recycle Item</label>
                                    <select class="form-control " name="Recycle"  ng-model="editForms.Recycle"> 
                                        <?php 
                                            foreach ($selectDefault as $key => $value){
                                                echo '<option value="'.$key.'"  ng-selected="editForms.Recycle === '.$key.'" >'.$value.'</option>';
                                            }
                                        ?> 
                                    </select>        
                                
                                </div>   
                            </div>



                            <div class="col-md-2">
                                <div class='form-group small-text'>
                                    <label for="visualsAvailable">Visuals Available</label>
                                    <!--<input class="form-control" id="visualsAvailable" name="visualsAvailable" value="{{editForms.visualsAvailable}}"  ng-model="editForms.visualsAvailable" size="30" type="text" />-->
                                    <select class="form-control " name="visualsAvailable"  ng-model="editForms.visualsAvailable"> 
                                        <?php 
                                            foreach ($selectDefault as $key => $value){
                                                echo '<option value="'.$key.'"  ng-selected="editForms.visualsAvailable === '.$key.'" >'.$value.'</option>';
                                            }
                                        ?> 
                                    </select>           
                                </div>   
                            </div>

                            <!--<div class='col-md-1'> 
                                <div class='form-group small-text'>
                                    <label for="featuredItem">Featured Item</label>
                                    <input class="form-control" id="featuredItem" name="featuredItem" value="{{editForms.featuredItem}}" ng-model="editForms.featuredItem" size="30" type="text" /> 
                                         

                                </div>
 
                            </div>-->
                            <div class='col-md-2'> 
                                <div class='form-group small-text'>
                                    <label for="HitSKU">HitSKU</label>
                                   <input class="form-control" id="HitSKU" name="HitSKU" value="{{editForms.HitSKU}}" ng-model="editForms.HitSKU" size="30" type="text" />
                                    <!-- <select class="form-control " name="HitSKU"  ng-model="editForms.HitSKU"> 
                                        <?php 
                                            /* foreach ($selectDefault as $key => $value){
                                                echo '<option value="'.$key.'"  ng-selected="editForms.HitSKU === '.$key.'" >'.$value.'</option>';
                                            } */
                                        ?> 
                                    </select>   -->
                                </div> 
                            </div>

                            <div class="col-md-2">
                                <div class='form-group small-text'>
                                    <label for="IsIndent">Is Indent</label>
                                    <input class="form-control" id="IsIndent" name="IsIndent" value="{{editForms.IsIndent}}" ng-model="editForms.IsIndent" size="30" type="text" />
                                </div>   
                            </div>
                            <div class='col-md-2'>
                                <div class='form-group small-text'>
                                    <label for="IsIndentExpress">Is Indent Express</label>
                                    <input class="form-control" id="IsIndentExpress" name="IsIndentExpress" value="{{editForms.IsIndentExpress}}" ng-model="editForms.IsIndentExpress" size="30" type="text" />
                                </div> 
                            </div>                 


                            
                        </div>


  
  <!-- Collapse 4-->   
    </div>          
  </div>
</div>      







</div> <!-- Collapse-->       


<!--NEW Change Log-->
<span ng-init="changeLogLooping()"></span>

 

<p class="margin-top"  ng-click="updatePageTracking(editForms.Code, '<?php echo $userID; ?>', 'edit products') ">
Change Log Form  <span ng-if="editForms.changeLogUpdate[0]['changeLogType']"> <span class="btn btn-secondary btn-sm"  ng-click="alertThis()" ng-show="!editForms.changeLogUpdate[getLoopCount].changeLogType" > Add (+) </span> <span class="btn btn-primary btn-sm"  ng-click="changeLogLooping(true)  " ng-show="editForms.changeLogUpdate[getLoopCount].changeLogType" > Add (+) </span> <span class="btn btn-danger btn-sm" ng-click="changeLogLooping('remove');  "> Remove (-) </span> </span>
</p>

<div class="alert alert-light" role="alert">  
    <div class="row " ng-repeat="loopchange in LoopFinalChangeLog" id="removeChangeLog{{editForms.changeLogUpdate[loopchange]['changeLogPlace']}}"> 
        <!--
        <div class="col-md-3 ">  
            <label for="default" class="btn btn-default btn-checkbox"> <input type="checkbox" id="default" class="badgebox" name="checkLog[]" ng-model="editForms.disableChange[loopchange]" ng-value="editForms.disableChange[loopchange]" ng-click="updatePageTracking(editForms.Code, '<?php echo $userID; ?>', 'edit products'); changeLogLoopingNew(editForms.disableChange[loopchange], $index)" ><span class="badge"> <i class="fa fa-check"></i> </span> Use Change Log Form</label>
        </div>  -->
        <div class="col-md-4">  
        <label for="IsIndentExpress">Select Change Type</label>
            <?php  $changeTypes = getChangeTypes($table); ?>
            <select   class="form-control " id="changeType" name="changeType"  ng-change="pushChangeLog(editForms.changeLogUpdate)" ng-model="editForms.changeLogUpdate[loopchange]['changeLogType']"   ng-checked="editForms.disableChange[loopchange] && 0" >
                <option value=""> --  Select -- </option>
                <?php 
                        foreach($changeTypes as $ctypeKey => $ctypeValue){
                            echo  '<option value='.$ctypeValue['indexNum'].'>' .$ctypeValue['changeType']. '</option>';
                        }  
                ?>
                
            </select>
        
            <div   class="CodeReq text-red labelreq reqfield" ng-show="errorchangeType">{{errorchangeType}}</div>
        </div>
        <div class="col-md-6"> 
            <label for="IsIndentExpress">&nbsp;</label>
            <textarea class="form-control" id="ChangeDescription" name="ChangeDescription" ng-model="editForms.changeLogUpdate[loopchange]['changeLogDescription']" placeholder="Enter Description" ng-disabled="!editForms.changeLogUpdate[loopchange]['changeLogType']"   ></textarea>
            <div   class="ChangeDescriptionReq text-red labelreq reqfield" ng-show="errorChangeDescription">{{errorChangeDescription}}</div>
           
        </div>
    </div>
</div>






<!--NEW Change Log-->




<!--

<div class="row margin-top changelog"> 
    <div class="col-md-3 ">
        <label for="default" class="btn btn-default btn-checkbox"> <input type="checkbox" id="default" class="badgebox" ng-model="editForms.disableChange" value="1" ng-click="updatePageTracking(editForms.Code, '<?php echo $userID; ?>', 'edit products'); changeLogLooping(editForms.disableChange)" ><span class="badge"> <i class="fa fa-check"></i> </span> Use Change Log Form</label>
    </div> 
    <div class="col-md-4"> 
     <label for="IsIndentExpress">Select Change Type</label>
        
             
        </select>
       
        <div   class="CodeReq text-red labelreq reqfield" ng-show="errorchangeType">{{errorchangeType}}</div>
    </div>
    <div class="col-md-4"> 
        <textarea class="form-control" id="ChangeDescription" name="ChangeDescription" ng-model="editForms.ChangeDescription" placeholder="Enter Description" ng-disabled="!editForms.disableChange" ng-checked="editForms.disableChange && 0" ></textarea>
        <div   class="ChangeDescriptionReq text-red labelreq reqfield" ng-show="errorChangeDescription">{{errorChangeDescription}}</div>
    </div>
</div>
                -->

 
<div class="modal fade" id="checkTableModal" tabindex="-1" role="dialog" aria-labelledby="checkTableModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Check  </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
      </div>
      <div class="modal-footer"> 
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
      </div>
    </div>
  </div>
</div>
 
 
 <div class="modal fade" id="repairTableModal" tabindex="-1" role="dialog" aria-labelledby="repairTableModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Repair  </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
             
      </div>
      <div class="modal-footer"> 
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
      </div>
    </div>
  </div>
</div>
 
 


<p >&nbsp;</p>

<div class="row margin-top">
   <!-- <div class="col-md-2"><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#saveChangesModal" >Change Log</button></div> -->
    <div class="col-md-7">
        <button type="submit" name="update" class="btn btn-danger btn-large"  > <i class="fa fa-save"></i> Update Item - {{editForms.Name}}</button>  <span class="updated-check"  ng-show="successUpdate"  > <span ng-if="icon1 == true" ><i class="fa fa-times text-red"></i> {{successUpdate}}</span> <span ng-if="icon2 == true"  ><i class="fa fa-check"></i> {{successUpdate}}</span>  </span>
    </div>
     <div class="col-md-5 text-right">   
         
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
 

 <!-- Modal -->
<div class="modal fade" id="newProductModal" tabindex="-1" role="dialog" aria-labelledby="newProductModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newProductModalLabel">Create New Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-sm-12">    
                            <div class="form-group">
                                <label for="Code">Code</label>
                                <input class="form-control" id="Code" name="Code" value="" allow-only-numbers ng-model="NewCode" ng-change="checkCode(NewCode)" size="30" type="text" > 
                                <div class="text-red" ng-if="existsMsg" ><small>{{existsMsg}}</small></div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="Name">Name</label>
                                <input class="form-control newName" id="Name" name="Name" value="" ng-disabled="!NewCode" ng-change="checkThisForm('newName', NewName)"  ng-model="NewName" size="30" type="text"  >
                                 
                            </div>
                        </div> 
                        <div class="col-sm-12">
                                <label for="selectTypesPricing">Pricing Type</label>            
                                <select class="form-control selectpicker "  name="NewPricingType"  ng-model="NewPricingType"   > 
                                    <option value="">Select Pricing Type: </option>
                                    <option ng-repeat="typs in selectTypesPricing"  ng-value="typs">{{typs}}</option>
                                </select>
                        </div>       

                    </div>
                     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" ng-disabled="!NewCode  || !NewName || !NewPricingType"   ng-click="addNewProduct(NewCode, NewName, NewPricingType)" >Continue</button>
      </div>
    </div>
  </div>
</div>

<?php include('footer.php') ?>