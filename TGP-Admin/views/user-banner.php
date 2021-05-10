

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
         
        <li class="breadcrumb-item active"><i class="fa fa-fw fa-users"></i> Distributor&apos;s Banner</li>
      </ol>

         
      <!-- Icon Cards-->
     
      
<div class="row">
    <div class="col-md-12">
            <div class="body-controller" >     
           
             
            
                <div id="imaginary_container"> 
                    <div class="input-group stylish-input-group col-md-4">
                        <input type="text" class="form-control" id="edit-search"  placeholder="Apply Filter Ex. Tuapeka Gold Print" ng-model="query[queryBy]"  data-toggle="tooltip" data-placement="right" title="Click below to select" >
                        <span class="input-group-addon">
                            <button type="submit">
                             <i class="fa fa-fw fa-search"></i>
                            </button>  
                        </span>
                    </div>
                  
                </div>
           
                    

           
                <div class="main-itemTable extend" > 
                            <table class="table table-striped table-hover "  >
                                <tr>
                                    <th>Customer Number</th>
                                    <th>Customer Name</th>
                                    <th>[<span class="pointer text-red" ng-click="showOnhold('No')">No</span>|<span class="pointer text-red" ng-click="showOnhold('Yes')">Yes</span>] On Hold </th>
                                    <!--<th>Themed Site Max</th>-->
                                    <th>CSR</th>
                                </tr>
                                <!-- <tr  ng-repeat="customer in customers | filter:query" ng-click="selectCustomer(customer.CustomerNumber, customer.CustomerName)" ng-class="{'value-no':  customer.CustomerOnHold == 'No'}"  ng-show="customer.CustomerOnHold == ansWer" >-->
                                <tr  ng-repeat="customer in customers | filter:query" ng-click="selectCustomer(customer.CustomerNumber, customer.CustomerName)"    ng-show="customer.CustomerOnHold == ansWer" >
                                    <td><span class="list-customer" data-id="{{customer.CustomerNumber}}" >{{customer.CustomerNumber}}</span></td>
                                    <td ><span class="list-customer" data-id="{{customer.CustomerName}}"  >    {{customer.CustomerName}}</span></td>
                                    <td><span class="list-customer" data-id="{{customer.CustomerOnHold}}" >{{customer.CustomerOnHold}}</span></td>
                                    <!--<td><span class="list-customer" data-id="{{customer.ThemedSiteMax}}" >{{customer.ThemedSiteMax}}</span></td>-->
                                    <td><span class="list-customer" data-id="{{customer.CSR}}" >{{customer.CSR}}@tuapeka.co.nz</a></td>
                                </tr>
                            </table>
                    
                </div> 

                <div class="margin-top main-customersTable" ng-if="lists" >

                     


                    <div class="row margin-top">
                        <div class="col-md-1">

                                 &nbsp;
                                

                        </div>
                        <div class="col-md-10">

                        
                                <!-- Edit user -->  
                                <div class="" id="editUserModal"  >
                                    
                                    <h5 class="alert alert-secondary"><i class="fa fa-edit"></i>  {{customerNumbered}} - {{customerNamed}} Banners</h5> 
                                    
                                </div>
                                 <!-- Edit user -->
 
                                
                                                        <?php 
                                                                $selectDefault = array('0' => 'No', '1'=>'Yes'); 
                                                                $selectPopup = array('0' => 'Current Window', '1'=>'Open in Pop Up', '2'=>'Open in New Window'); 
                                                                $messageURL = '<small> 
                                                                <b>Link to Homepage</b> - / (slash symbol)<br />
                                                                <b>Link on TC Site</b> - /item/100144<br />
                                                                <b>Link to Pop Up on TC Site</b> - /brandPopup.php?type=Debossing<br />
                                                                <b>External URL</b> - https://www.youtube.com
                                                                        
                                                                </small>';
                                                            
                                                        ?> 

                                                        <div class="alert alert-secondary" role="alert">  
                                                                <h6   > Add New Banner   </h6> 
                                                                <hr>
                                                                <form name="addNewBanner" id="addNewBanner" class="addNewBanner"   ng-app="fileUpload" novalidate  >   
                                                                       
                                                                        <fieldset ng-disabled="formfieldBanner" >   
                                                                            <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <label for="mainfileUpload">Upload Banner</label>
                                                                                        <input type="file" id="mainfileUpload" class="form-control" ngf-select ng-model="picFile" name="file"     accept="application/jpeg"   ngf-model-invalid="errorFile"> 
                                                                                    </div>
                                                                            </div>  
                                                                            <div class="row margin-top-light">  
                                                                                
                                                                                <div class="col-md-2">
                                                                                    <label  for="formActive">Active:</label>
                                                                                    <select class="form-control " id="formActive" name="active"  ng-model="bannerNewForm.active" ng-init="bannerNewForm.active = selectDropdown[0]"> 
                                                                                        <option  ng-value="selectDropdown[0]"  > {{selectDropdown[0]}}</option>    
                                                                                        <option  ng-value="selectDropdown[1]"  > {{selectDropdown[1]}}</option>                          
                                                                                    </select> 
                                                                                </div> 

                                                                                <div class="col-md-2">
                                                                                    <label  for="formMain">Large Banner:</label>
                                                                                    <select class="form-control " id="formMain" name="main"  ng-model="bannerNewForm.main" ng-init="bannerNewForm.main = selectDropdown[1]"> 
                                                                                        <option  ng-value="selectDropdown[0]"  > {{selectDropdown[0]}}</option>    
                                                                                        <option  ng-value="selectDropdown[1]"  > {{selectDropdown[1]}}</option>                          
                                                                                    </select> 
                                                                                </div> 

                                                                                <div class="col-md-5">
                                                                                    <label  for="formUrl">Url:</label> <a data-toggle="collapse" href="#collapseURLForm" role="button" aria-expanded="false" aria-controls="collapseURLForm" style="cursor:pointer" class="text-danger"> <i class="fa fa-info-circle"></i> read me </a><br />
                                                                                                                    <div class="collapse" id="collapseURLForm" style="width:100%">
                                                                                                                        <div class="card card-body">
                                                                                                                            <?php echo $messageURL; ?>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                    <input type="text"  id="formUrl" class="form-control" name="url" ng-value="bannerNewForm.url"  ng-model="bannerNewForm.url" placeholder="Ex. /item/100144" >
                                                                                                                    
                                                                                </div> 

                                                                                <div class="col-md-3">
                                                                                    <label  for="formPopup">Target:</label>
                                                                                    <select class="form-control " id="formPopup" name="popup"  ng-model="bannerNewForm.popup" ng-init="bannerNewForm.popup = selectPopup[0]"> 
                                                                                        <option  ng-value="selectPopup[0]"  > {{selectPopup[0]}}</option>    
                                                                                        <option  ng-value="selectPopup[1]"  > {{selectPopup[1]}}</option>    
                                                                                        <option  ng-value="selectPopup[2]"  > {{selectPopup[2]}}</option>                          
                                                                                    </select> 
                                                                                </div> 
                                                                          
                                                                                
                                                                            </div>
                                                                            <div class="row margin-top">  
                                                                                <div class="col-md-3 text-left">
                                                                                    <input type="submit" class="btn btn-danger btn-small text-center" style="width: auto;" value="Add Banner" ng-click="addNewBannerForm(picFile,    customerNamed, customerNumbered)" ng-disabled="!picFile"  >
                                                                                </div> 
                                                                            </div>    
                                                                        </fieldset> 
                                                                </form>
                                                        </div>


                                            <div ng-if="bannerSkinnedSiteForm">
                                                


                                                                    <form name="editBanner" id="editBanner" class="editBanner" ng-submit="editBannerForm(customerNamed, customerNumbered)" novalidate  >    
                                                                            <fieldset  >    
                                                                            
                                                                            <p ><small><i>Note: please click the save button below after making your changes</i></small></p>

                                                                            
                                                                            <p  ng-if="bannerSkinnedSiteForm"><input type="submit" class="btn btn-danger btn-small " style="width: auto;" value="Save   Banner for {{customerNamed}}"   > </p>
                                                                                     
                                                                                
                                                                            <!-- start Public-->
                                                                            <div class="row margin-top " ui-sortable = "sortableOptions"  ng-model="bannerNewForm.bannerSkinnedSite" >  
                                                                                <div class="alert alert-secondary" id="bannerRemove{{publicForm.id}}" style="width:97%; margin-left:1%" ng-repeat="publicForm in  bannerNewForm.bannerSkinnedSite"  ng-class="publicForm.main == 1 ? 'row' : 'col-md-4' "  style="cursor:move; "   >  
                                                                                        
                                                                                        <div  ng-class="publicForm.main == 1 ? 'col-md-8' : 'col-md-12' " >  
                                                                                            <h2><i class="text-success fa  fa-check" ng-if="publicForm.active == '1' "></i> <i class="text-warning fa  fa-exclamation-triangle" ng-if="publicForm.active == '0' "></i></h2> 
                                                                                            <img src="../../Images/Banners/{{publicForm.location}}/{{publicForm.filename}}" class="img-fluid img-thumbnail" ng-style="{ 'height' : (publicForm.main == 0) ? '180px' : 'auto' }" />
                                                                                        </div> 
                                                                                        <div  ng-class="publicForm.main == 1 ? 'col-md-4' : 'col-md-12' ">  

                                                                                            <div class="row">
                                                                                                <div class="col-md-6">
                                                                                                        <label for="publicActive">Active:</label>
                                                                                                        <select class="form-control " id="publicActive" name="active"  ng-model="publicForm.active"> 
                                                                                                            <?php 
                                                                                                                foreach ($selectDefault as $key => $value){
                                                                                                                    echo '<option value="'.$key.'"  ng-selected="publicForm.active === '.$key.'" >'.$value.'</option>';
                                                                                                                }
                                                                                                            ?> 
                                                                                                        </select>
                                                                                                </div>  
                                                                                                <div class="col-md-6">
                                                                                                    <div class="form-group">
                                                                                                        <label for="publicMain">Large Banner:</label>
                                                                                                        <select class="form-control " id="publicMain" name="main"  ng-model="publicForm.main"> 
                                                                                                            <?php 
                                                                                                                foreach ($selectDefault as $key => $value){
                                                                                                                    echo '<option value="'.$key.'"  ng-selected="publicForm.main === '.$key.'" >'.$value.'</option>';
                                                                                                                }
                                                                                                            ?> 
                                                                                                        </select> 
                                                                                                    </div>
                                                                                                </div> 
                                                                                            </div>

                                                                                            <div class="row">
                                                                                                <div class="col-md-12">
                                                                                                    <label for="publicUrl">Url:</label> <a data-toggle="collapse" href="#collapseURL{{publicForm.id}}" role="button" aria-expanded="false" aria-controls="collapseURL{{publicForm.id}}" style="cursor:pointer" class="text-danger"> <i class="fa fa-info-circle"></i> read me </a><br />
                                                                                                    <div class="collapse" id="collapseURL{{publicForm.id}}" style="width:100%">
                                                                                                        <div class="card card-body">
                                                                                                            <?php echo $messageURL; ?>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <input type="text"  id="publicUrl" class="form-control" name="url" value="{{publicForm.url}}"  ng-model="publicForm.url" >
                                                                                                    
                                                                                                    
                                                                                                </div>
                                                                                            </div>   
                                                                                            
                                                                                            <div class="row margin-top-light">
                                                                                                <div class="col-md-12">
                                                                                                        <label for="publicPopup">Target:</label>
                                                                                                        <select class="form-control " id="publicPopup" name="popup"  ng-model="publicForm.popup"> 
                                                                                                            <?php 
                                                                                                                foreach ($selectPopup as $key => $value){
                                                                                                                    echo '<option value="'.$key.'"  ng-selected="publicForm.popup === '.$key.'" >'.$value.'</option>';
                                                                                                                }
                                                                                                            ?> 
                                                                                                        </select>
                                                                                                </div>  
                                                                                                
                                                                                            </div>

                                                                                            <div class="row margin-top">
                                                                                                <div class="col-md-12 text-right"> 
                                                                                                    <h4  ><span class="cursorpoint btn btn-danger" style="width: auto;"  ng-click="deleteBanner(publicForm.id, publicForm.filename,   customerNamed, customerNumbered  )" ><i class="fa fa-trash text-white"></i></span></h4>
                                                                                                </div>
                                                                                            </div>   



                                                                                        </div>
                                                                                </div>
                                                                            </div>    
                                                                            <!-- End Public--> 
                    



                                                                                <p ng-if="bannerSkinnedSiteForm"><input type="submit" class="btn btn-danger btn-small " style="width: auto;" value="Save   Banner for {{customerNamed}}"   > </p>

                                                                            </fieldset> 
                                                                    </form>


                                            </div>
                                           



                            
                            
                        </div>  
                         <div class="col-md-1">

                                &nbsp;


                        </div>
                    </div>   

                </div>
                <p>&nbsp; </p>
                  
        
    </div>
  </div>  
</div>    


  
<!--Success Modal-->
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