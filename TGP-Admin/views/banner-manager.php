

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
         
        <li class="breadcrumb-item active"> <i class="fa fa-image"></i> Banner Manager</li>
      </ol>

         
      <!-- Icon Cards-->
     
      
<div class="row">
    <div class="col-md-12">
            <div class="body-controller" >     
           
                <div class="alert alert-warning" role="alert">
                    Note: Administrators, if having difficulty viewing new updates made on the new website  Ex. content, images and pricing, please click this link  <a target="_blank" href="//trends.nz/refresh/all">www.trends.nz/refresh/all</a> to refresh website cache.
                </div>
                                
                   
                <?php 
                    $selectDefault = array('0' => 'No', '1'=>'Yes'); 
                    $selectPopup = array('0' => 'Current Window', '1'=>'Open in Pop Up', '2'=>'Open in New Window'); 
                    $messageURL = '<small> 
                    <b>Link to Homepage</b> - / (slash symbol)<br />
                    <b>Link on TC Site</b> - /item/100144<br />
                    <b>Link to Pop Up on TC Site</b> - <span class="pointer" data-toggle="modal" data-target="#popOptionModal" ><u> Popup options please click here </u></span><br />
                    <b>External URL</b> - https://www.youtube.com
                              
                    </small>';
                
                ?> 

                <div class="main-itemTables row" >
                    <div class="col-md-1">&nbsp;</div>
                    <div class="col-md-10" >


                        <div class="alert alert-secondary" role="alert">  
                            <h6   > Add New Banner </h6> 
                            <hr>
                            <form name="addNewBanner" id="addNewBanner" class="addNewBanner"   ng-app="fileUpload" novalidate  >    
                                    <fieldset  >  
                                                          
                                        <div class="row">
                                                <div class="col-md-12">
                                                    <label for="mainfileUpload">Upload Banner</label>
                                                    <input type="file" id="mainfileUpload" class="form-control" ngf-select ng-model="picFile" name="file"     accept="application/jpeg"   ngf-model-invalid="errorFile"> 
                                                </div>
                                        </div>  
                                        <div class="row margin-top-light">  
                                            <div class="col-md-1">
                                                <label  for="formLocation">Location:</label>
                                                <div class="form-check" ng-repeat="locs in selectLocation"> 
                                                    <input type="checkbox" class="form-check-input" id="{{locs}}" ng-model="bannerNewForm.location[locs]"/>
                                                    <label class="form-check-label" for="{{locs}}">{{locs}}</label> 
                                                </div>

                                            </div>
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

                                            <div class="col-md-4">
                                                <label  for="formUrl">Url:</label> <a data-toggle="collapse" href="#collapseURLForm" role="button" aria-expanded="false" aria-controls="collapseURLForm" style="cursor:pointer" class="text-danger" ng-click="getFormPopupLocation('formUrl', 'main')"> <i class="fa fa-info-circle"></i> read me </a><br />
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
                                           <!-- <div class="col-md-2">
                                                <label  for="formOpen">New Window:</label>
                                                <select class="form-control " id="formOpen" name="open"  ng-model="bannerNewForm.open" ng-init="bannerNewForm.open = selectDropdown[0]"> 
                                                    <option  ng-value="selectDropdown[0]"  > {{selectDropdown[0]}}</option>    
                                                    <option  ng-value="selectDropdown[1]"  > {{selectDropdown[1]}}</option>                          
                                                </select> 
                                            </div> -->

                                            
                                        </div>
                                        <div class="row margin-top">  
                                            <div class="col-md-12 text-left">
                                                <input type="submit" class="btn btn-danger btn-small" value="Add Banner" ng-click="addNewBannerForm(picFile)" ng-disabled="!picFile"  >
                                            </div> 
                                        </div>    
                                    </fieldset> 
                            </form>
                        </div>


                         <div class="btn-group margin-top" role="group" aria-label="Basic button">
                            <button type="button" class="btn btn-secondary {{publicActive}}" ng-click="activateBanner('public')">Public Banner</button>
                            <button type="button" class="btn btn-secondary {{nzActive}}" ng-click="activateBanner('nz')">New Zealand</button>
                            <button type="button" class="btn btn-secondary {{auActive}}" ng-click="activateBanner('au')">Australia</button>
                            <button type="button" class="btn btn-secondary {{sgActive}}" ng-click="activateBanner('sg')">Singapore</button>
                            <button type="button" class="btn btn-secondary {{myActive}}" ng-click="activateBanner('my')">Malaysia</button>
                        </div>
                         
                        
                       

                                        <div class="row" ng-if="publicBannerShow">
                                            <div class="col-md-12">
                                                
                                                <h4 class="margin-top">{{btn}} Banners </h4>     
                                                <form name="editBanner" id="editBanner" class="editBanner" ng-submit="editBannerForm(formCondition)" novalidate  >    
                                                        <fieldset  >   
                                                            
                                                        
                                                        
                                                        <p><small><i>Note: please click the save button below after making your changes</i></small></p>

                                                         <div class="row ">  
                                                                <div class="col-md-12">
                                                                    <input type="submit" class="btn btn-danger btn-small" value="Save {{btn}} Banner"   >
                                                                </div> 
                                                            </div>  

                                                        <!-- start Public-->
                                                        <div class="row margin-top banner-manager" ui-sortable = "sortableOptions"  ng-model="publicBanner" >  
                                                            <div class="jumbotron"  ng-repeat="publicForm in  publicBanner"  ng-class="publicForm.main == 1 ? 'row' : 'col-md-4' "  style="cursor:move; "   >  
                                                                    
                                                                    <div  ng-class="publicForm.main == 1 ? 'col-md-8' : 'col-md-12' " >  
                                                                        <h2><i class="text-success fa  fa-check" ng-if="publicForm.active == '1' "></i> <i class="text-warning fa  fa-exclamation-triangle" ng-if="publicForm.active == '0' "></i></h2> 
                                                                        <img src="../../Images/Banners/{{publicForm.location}}/{{publicForm.filename}}" class="img-fluid img-thumbnail" ng-style="{ 'max-width' : (publicForm.main == 0) ? '395px' : 'auto' }" />
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
                                                                                <label for="publicUrl">Url:</label> <a data-toggle="collapse" href="#collapseURL{{publicForm.id}}" role="button" aria-expanded="false" aria-controls="collapseURL{{publicForm.id}}" ng-click="getFormPopupLocation(publicForm.id, $index)" style="cursor:pointer" class="text-danger"> <i class="fa fa-info-circle"></i> read me </a><br />
                                                                                <div class="collapse" id="collapseURL{{publicForm.id}}" style="width:100%">
                                                                                    <div class="card card-body">
                                                                                        <?php echo $messageURL; ?>
                                                                                    </div>
                                                                                </div>
                                                                                <input type="text"  id="publicUrl{{publicForm.id}}" class="form-control" name="url" value="{{publicForm.url}}"  ng-model="publicForm.url" >
                                                                                
                                                                                
                                                                            </div>
                                                                        </div>   
                                                                        
                                                                        <div class="row margin-top-light">
                                                                            <div class="col-md-8">
                                                                                    <label for="publicPopup">Target:</label>
                                                                                    <select class="form-control " id="publicPopup" name="popup"  ng-model="publicForm.popup"> 
                                                                                        <?php 
                                                                                            foreach ($selectPopup as $key => $value){
                                                                                                echo '<option value="'.$key.'"  ng-selected="publicForm.popup === '.$key.'" >'.$value.'</option>';
                                                                                            }
                                                                                        ?> 
                                                                                    </select>
                                                                            </div>  
                                                                            <div class="col-md-4">
                                                                              <!--  <div class="form-group">
                                                                                    <label for="publicOpen">Open New Window:</label>
                                                                                    <select class="form-control " id="publicOpen" name="openWindow"  ng-model="publicForm.openWindow"> 
                                                                                        <?php 
                                                                                            foreach ($selectDefault as $key => $value){
                                                                                                echo '<option value="'.$key.'"  ng-selected="publicForm.openWindow === '.$key.'" >'.$value.'</option>';
                                                                                            }
                                                                                        ?> 
                                                                                    </select> 
                                                                                </div>-->
                                                                            </div> 
                                                                        </div>

                                                                         <div class="row margin-top">
                                                                            <div class="col-md-12 text-right"> 
                                                                                 <h4  ><span class="cursorpoint btn btn-danger"  ng-click="deleteBanner(publicForm.id, publicForm.location, publicForm.filename, locNew)" ><i class="fa fa-trash text-white"></i></span></h4>
                                                                            </div>
                                                                        </div>   



                                                                    </div>
                                                            </div>
                                                        </div>    
                                                        <!-- End Public--> 
 



                                                            <div class="row ">  
                                                                <div class="col-md-12">
                                                                    <input type="submit" class="btn btn-danger btn-small" value="Save {{btn}} Banner"   >
                                                                </div> 
                                                            </div>    

                                                        </fieldset> 
                                                </form>
 
                                            </div>
                                        </div>

 
                        

                    </div>
                    <div class="col-md-1">&nbsp;</div>
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


<!--- Popup options modal -->
<!-- Modal -->
<div class="modal fade" id="popOptionModal" tabindex="-1" role="dialog" aria-labelledby="popOptionModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="popOptionModalLabel">Select Popup</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
            <ul>
                    <li><span class="pointer" ng-click="putModalURLInput('PadPrintModal')">Pad Print  </span></li> 
                    <li><span class="pointer" ng-click="putModalURLInput('RotaryDigitalPrintModal')">Rotary Digital Print  </span></li>
                    <li><span class="pointer" ng-click="putModalURLInput('ScreenPrintModal')">Rotary Screen Print </span></li>
                    <li><span class="pointer" ng-click="putModalURLInput('FlatbedScreenPrintModal')">Flatbed Screen Print  </span></li>
                    
                    <li><span class="pointer" ng-click="putModalURLInput('ImitationEtchModal')">Imitation Etch  </span></li>
                    <li><span class="pointer" ng-click="putModalURLInput('LaserEngravingModal')">Laser Engraving  </span></li>
                    <li><span class="pointer" ng-click="putModalURLInput('ResinCoatedFinishModal')">Resin Coated Finish  </span></li>
                    <li><span class="pointer" ng-click="putModalURLInput('DigitalTransferModal')">Digital Transfer  </span></li>
                    <li><span class="pointer" ng-click="putModalURLInput('SublimationPrintModal')">Sublimation Print </span></li>
                    <li><span class="pointer" ng-click="putModalURLInput('DigitalMediaModal')">Digital Print </span></li>
                    <li><span class="pointer" ng-click="putModalURLInput('FullColourLabelModal')">Digital Label </span></li>
                    <li><span class="pointer" ng-click="putModalURLInput('DirectDigitalModal')">Direct Digital  </span></li>
                    <li><span class="pointer" ng-click="putModalURLInput('DebossingModal')">Debossing </span></li>
                    <li><span class="pointer" ng-click="putModalURLInput('EmbroideryModal')">Embroidery  </span></li>
            </ul>        
			 
                                                                                            
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>

 

<?php include('footer.php') ?>