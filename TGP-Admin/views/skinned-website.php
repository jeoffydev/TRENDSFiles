

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
         
        <li class="breadcrumb-item active"><i class="fa fa-fw fa-desktop"></i> Skinned Website Manager</li>
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
                                     
                                </tr>
                                <!-- <tr  ng-repeat="customer in customers | filter:query" ng-click="selectCustomer(customer.CustomerNumber, customer.CustomerName)" ng-class="{'value-no':  customer.CustomerOnHold == 'No'}"  ng-show="customer.CustomerOnHold == ansWer" >-->
                                <tr  ng-repeat="customer in customers | filter:query" ng-click="selectCustomer(customer.CustomerNumber, customer.CustomerName)"     >
                                    <td><span class="list-customer" data-id="{{customer.CustomerNumber}}" >{{customer.CustomerNumber}}</span></td>
                                    <td ><span class="list-customer" data-id="{{customer.CustomerName}}"  >    {{customer.CustomerName}}</span></td>
                                    
                                </tr>
                            </table>
                    
                </div> 

                <div class="alert alert-warning" role="alert">
                    Note: Administrators, if having difficulty viewing new updates made on the new website  Ex. content, images and pricing, please click this link  <a target="_blank" href="//trends.nz/refresh/all">www.trends.nz/refresh/all</a> to refresh website cache.
                </div>

                <div class="margin-top margin-bottom main-customersTable" ng-if="lists" > 
                      
                     
                       
                      <form name="addNewTheme" id="addNewTheme" ng-submit="addnewThemeForm()" novalidate  ng-if="disabledThemeAddField">     
                        <div class="row "> 
                            <div class="col-md-4">
                                
                                        <div class="input-group mb-3 margin-top">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-desktop"></i></span>
                                            </div>  
                                            <input type="text"   class="form-control" placeholder="Skinned site name" aria-label="newTheme" aria-describedby="basic-addon1" name="newtheme"    ng-model="formData.newTheme"  ng-pattern="eml_add" ng-required="true" autocomplete="off"  >
                                            
                                        </div>
                                    
                                
                            </div>  
                            <div class="col-md-2 text-left">  <button type="submit" name="update" class="btn btn-danger margin-top" ng-disabled="!formData.newTheme" >Add New Theme</button>  </div>
                            <div class="col-md-3">&nbsp;</div>  
                            <div class="col-md-3">&nbsp;</div>
                        </div>
                    </form>

                   <div class="row "> 
                        <div class="col-md-4">
                                
                                <p class="alert alert-secondary"> Existing theme of   <strong>{{customerName}} - {{customerNumber}}</strong>  </p> 
                                <div class="second-customersTable">
                                    <p ng-if="displayThemelimit" class="text-red"><b> <i class="fa  fa-info-circle font-size-18"></i> {{displayListCount}} of {{displayThemelimit}} used </b></p>
                                    <table class="table table-striped table-hover "   >
                                            <tr> 
                                                <th ng-if="disabledThemeAddField" >Copy</th> 
                                                <th>Theme ID</th> 
                                                <th>Company Name</th>   
                                                <th>&nbsp;</th> 
                                            </tr>
                                            <tr ng-repeat="list in lists" ng-click="selectTheme(list.themeID)" id="{{list.themeID}}" class="themeTables"> 
                                                <td ng-if="disabledThemeAddField" ><span class="list-customer-res cursorpoint" data-id="{{list.themeID}}" ng-click="duplicateTheme(list.CustomerNumber, list.themeID, customerName)"   >  <i class="fa  fa-copy"></i> </span> </td>  
                                                <td ><span class="list-customer-res cursorpoint" data-id="{{list.themeID}}"   >  {{list.themeID}}</span> </td>  
                                                <td  ><span class="list-customer-res cursorpoint" data-id="{{list.CompanyTag}}"   > {{list.CompanyTag}} </span></td> 
                                                <td  ><span class="list-customer-res cursorpoint"  ng-click="deleteTheme(list.CustomerNumber, list.themeID, customerName)" > <i class="fa fa-trash text-red"></i>  </span></td>  
                                            </tr>
                                    </table>        
                                </div>
                        </div>        
                        <div class="col-md-8">



                              


                            
                            <?php $selectActiveDefault = array('0' => 'No', '1'=>'Yes'); ?>
                            <?php $selectPricingDefault = array('0' => 'Off', '1'=>'Always', '2'=>'Password Protect'); ?>
                            
                            <form name="editThemeForm" id="editThemeForm" ng-submit="editThemeFormsSubmitted()" novalidate  >  
                                <fieldset ng-disabled="formDisabled">  


                                    <div class="accordion skinned-accordion" id="accordionExample"> <!-- START accordion-->


                                        <div class="card">
                                            <div class="card-header" id="headingOne">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        Step 1: Basic Details 
                                                    </button>
                                                </h5>
                                            </div>

                                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                <div class="card-body">

                                                    <div class="row margin-top"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top"> Company/Brand Name: </span>
                                                        </div>
                                                        <div class="col-md-7"> 
                                                            <input class="form-control" type="text"  ng-value="ThemeLoops.CompanyTag" ng-model="ThemeLoops.CompanyTag"  >
                                                            <div   class="CodeReq text-red labelreq reqfield" ng-show="CompanyTagError">{{CompanyTagError}}</div>
                                                        </div>
                                                    </div> 

                                                    <div class="row margin-top-light"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top"> Website URL:  </span>
                                                        </div>
                                                        <div class="col-md-6"> 
                                                            <input class="form-control" type="text"  ng-value="themeUrl" ng-model="themeUrl"  readonly >
                                                        </div>
                                                        <div class="col-md-1"> 
                                                            <a ng-if="themeUrl" href="{{themeUrl}}" target="_blank"> <i class="fa  fa-external-link text-red font-size-18"></i> </a>
                                                        </div>
                                                    </div> 

                                                    <div class="row margin-top-light"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top"> Custom Domain:  </span>
                                                        </div>
                                                        <div class="col-md-6">  
                                                            <input   class="form-control" type="text"  ng-value="ThemeLoops.Domain" ng-model="ThemeLoops.Domain"   >
                                                        </div>
                                                        <div class="col-md-1"> 
                                                            <a ng-if="ThemeLoops.Domain" href="//{{ThemeLoops.Domain}}" target="_blank"> <i class="fa  fa-external-link text-red font-size-18"></i> </a>
                                                        </div>
                                                    </div> 

                                                    <div class="row margin-top-light"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top"> Site Active:   </span>
                                                        </div>
                                                        <div class="col-md-7"> 
                                                            <select class="form-control col-md-4" name="live"  ng-model="ThemeLoops.Live"> 
                                                                <?php 
                                                                    foreach ($selectActiveDefault as $key => $value){
                                                                        echo '<option value="'.$key.'"  ng-selected="ThemeLoops.Live === '.$key.'" >'.$value.'</option>';
                                                                    }
                                                                ?> 
                                                            </select>
                                                        </div>
                                                    </div> 

                                                   

                                                    <div class="row margin-top-light"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top">  Contact Us Active:   </span>
                                                        </div>
                                                        <div class="col-md-7"> 
                                                            <select class="form-control col-md-4" name="contactusactive"  ng-model="ThemeLoops.ContactUsActive"> 
                                                                <?php 
                                                                    foreach ($selectActiveDefault as $key => $value){
                                                                        echo '<option value="'.$key.'"  ng-selected="ThemeLoops.ContactUsActive === '.$key.'" >'.$value.'</option>';
                                                                    }
                                                                ?> 
                                                            </select>
                                                        </div>
                                                    </div> 

                                                     <div class="row margin-top-light"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top">  Enquiry Form Active:   </span>
                                                        </div>
                                                        <div class="col-md-7"> 
                                                            <select class="form-control col-md-4" name="enquiryformactive"  ng-model="ThemeLoops.EnquiryFormActive"> 
                                                                <?php 
                                                                    foreach ($selectActiveDefault as $key => $value){
                                                                        echo '<option value="'.$key.'"  ng-selected="ThemeLoops.EnquiryFormActive === '.$key.'" >'.$value.'</option>';
                                                                    }
                                                                ?> 
                                                            </select>
                                                        </div>
                                                    </div> 

                                                    <div class="row margin-top-light"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top"> Enquiry Email Address:   </span>
                                                        </div>
                                                        <div class="col-md-7"> 
                                                            <input class="form-control" type="text"  ng-value="ThemeLoops.Email" ng-model="ThemeLoops.Email" ng-disabled ="ThemeLoops.EnquiryFormActive == '0' "  >
                                                            <div   class="CodeReq text-red labelreq reqfield" ng-show="EmailError">{{EmailError}}</div>
                                                        </div>
                                                    </div> 

                                                     <div class="row margin-top-light"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top"> Display Email Address on Contact Us Page:   </span>
                                                        </div>
                                                        <div class="col-md-7"> 
                                                            <select class="form-control col-md-4" name="displayemail"  ng-model="ThemeLoops.DisplayEmail"> 
                                                                <?php 
                                                                    foreach ($selectActiveDefault as $key => $value){
                                                                        echo '<option value="'.$key.'"  ng-selected="ThemeLoops.DisplayEmail === '.$key.'" >'.$value.'</option>';
                                                                    }
                                                                ?> 
                                                            </select>
                                                        </div>
                                                    </div> 

                                                     

                                                    <div class="row margin-top-light"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top"> Site Admin Email Address: </span>
                                                        </div>
                                                        <div class="col-md-7"> 
                                                            <input class="form-control" type="text"  ng-value="ThemeLoops.customsiteAdminEmail" ng-model="ThemeLoops.customsiteAdminEmail"  >
                                                            <div   class="CodeReq text-red labelreq reqfield" ng-show="customEmailError">{{customEmailError}}</div>
                                                        </div>
                                                    </div> 

                                                    
                                                    <div class="row margin-top-light" ng-if="!formDisabled"> 
                                                        <div class="col-md-3 text-right">  
                                                            <span class="padding-top"> About Us Text: </span>
                                                        </div>
                                                        <div class="col-md-7 " >  
                                                            <div   text-angular ng-paste="pasteAboutCheck($event)" class="text-editor-format abouttext" ng-model="ThemeLoops.AboutUsTextEditor" ta-toolbar="[['h1','h2','h3','h4'],['bold','italics','underline','ul'],['justifyLeft', 'justifyCenter', 'justifyRight'],['html','insertLink']]" name="about-editor" ta-text-editor-class="clearfix border-around container " ></div>
                                                        </div>
                                                    </div> 

                                                    <div class="row margin-top-light" ng-if="!formDisabled"> 
                                                        <div class="col-md-3 text-right">  
                                                            <span class="padding-top"> Contact Us Text: </span>
                                                        </div>
                                                        <div class="col-md-7 " >  
                                                            <div text-angular class="text-editor-format"  ng-paste="pasteContactCheck($event)" ng-model="ThemeLoops.ContactUsTextEditor" ta-toolbar="[['h1','h2','h3','h4'],['bold','italics','underline','ul'],['justifyLeft', 'justifyCenter', 'justifyRight'],['html','insertLink']]" name="contact-editor" ta-text-editor-class="clearfix border-around container " ta-html-editor-class="border-around"></div>
                                                                    
                                                        </div>
                                                    </div> 

                                                    
                                                    <div class="row margin-top-light" ng-if="!formDisabled"> 
                                                        <div class="col-md-3 text-right">  
                                                            <span class="padding-top"> Terms & Conditions: </span>
                                                        </div>
                                                        <div class="col-md-7 " >  
                                                            <div text-angular class="text-editor-format" ng-paste="pasteTermsCheck($event)"  ng-model="ThemeLoops.termsConditionTextEditor" ta-toolbar="[['h1','h2','h3','h4'],['bold','italics','underline','ul'],['justifyLeft', 'justifyCenter', 'justifyRight'],['html','insertLink']]" name="terms-editor" ta-text-editor-class="clearfix border-around container " ta-html-editor-class="border-around"></div>
                                                        </div>
                                                    </div> 

                                                    <div class="row margin-top"> 
                                                        <div class="col-md-10 text-left">  
                                                            <div class="alert alert-secondary"> Please enter the contact details you would like to show in your 'Contact Us' page. Any left blank will not be shown. </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="row margin-top-light"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top"> Contact Phone: </span>
                                                        </div>
                                                        <div class="col-md-7"> 
                                                            <input class="form-control" type="text"  ng-value="ThemeLoops.Phone" ng-model="ThemeLoops.Phone"  >
                                                        </div>
                                                    </div>  
                                                    <div class="row margin-top-light"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top"> Contact Address: </span>
                                                        </div>
                                                        <div class="col-md-7"> 
                                                             <!--<input class="form-control" type="text"  ng-value="ThemeLoops.Address" ng-model="ThemeLoops.Address"  >-->
                                                             <!--<div   text-angular class="text-editor-format" ng-model="ThemeLoops.Address" ta-toolbar="[['bold','italics','underline','ul']]" name="address-editor" ta-text-editor-class="clearfix border-around container " ta-html-editor-class="border-around" ></div>-->
                                                             <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" ng-model="ThemeLoops.Address" ></textarea>
                                                        </div>
                                                    </div>  
                                                    <div class="row margin-top-light"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top"> Facebook: </span>
                                                        </div>
                                                        <div class="col-md-7"> 
                                                            <input class="form-control" type="text"  ng-value="ThemeLoops.Facebook" ng-model="ThemeLoops.Facebook"  >
                                                        </div>
                                                    </div>  
                                                    <div class="row margin-top-light"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top"> Google Plus:  </span>
                                                        </div>
                                                        <div class="col-md-7"> 
                                                            <input class="form-control" type="text"  ng-value="ThemeLoops.GooglePlus" ng-model="ThemeLoops.GooglePlus"  >
                                                        </div>
                                                    </div>  
                                                    <div class="row margin-top-light"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top"> Twitter:  </span>
                                                        </div>
                                                        <div class="col-md-7"> 
                                                            <input class="form-control" type="text"  ng-value="ThemeLoops.Twitter" ng-model="ThemeLoops.Twitter"  >
                                                        </div>
                                                    </div>  
                                                    <div class="row margin-top-light"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top"> LinkedIn:  </span>
                                                        </div>
                                                        <div class="col-md-7"> 
                                                            <input class="form-control" type="text"  ng-value="ThemeLoops.LinkedIn" ng-model="ThemeLoops.LinkedIn"  >
                                                        </div>
                                                    </div>  
                                                    <div class="row margin-top-light"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top"> Instagram:  </span>
                                                        </div>
                                                        <div class="col-md-7"> 
                                                            <input class="form-control" type="text"  ng-value="ThemeLoops.Instagram" ng-model="ThemeLoops.Instagram"  >
                                                        </div>
                                                    </div>  
                                                    <div class="row margin-top-light"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top"> Skype: </span>
                                                        </div>
                                                        <div class="col-md-7"> 
                                                            <input class="form-control" type="text"  ng-value="ThemeLoops.Skype" ng-model="ThemeLoops.Skype"  >
                                                        </div>
                                                    </div>  
                                                    <div class="row margin-top-light"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top"> Website: </span>
                                                        </div>
                                                        <div class="col-md-7"> 
                                                            <input class="form-control" type="text"  ng-value="ThemeLoops.Website" ng-model="ThemeLoops.Website"  >
                                                        </div>
                                                    </div>  

                                                    
                                                </div>
                                            </div>
                                        </div>


                                        <div class="card">
                                            <div class="card-header" id="headingTwo">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        Step 2: Your Logo
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                <div class="card-body">

                                                    <div class="row margin-top-light"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top"> Logo File:</span>
                                                        </div>
                                                        <div class="col-md-4"> 
                                                            <form name="pdfForm" id="pdfForm" ng-app="fileUpload"     >
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input mainfileUploads" id="mainfileUpload" aria-describedby="inputGroupFileAddon04" ngf-select ng-model="picFile" name="file"  ng-change="uploadLogo(picFile, ThemeLoops.themeID, customerName, customerNumber, 1)"  ng-click="clickAlert()"  accept="image/*"  ngf-model-invalid="errorFile" >
                                                                        <label class="custom-file-label" for="mainfileUpload">Choose Logo</label>
                                                                    </div>
                                                                </div>  
                                                            </form>  
                                                        </div>
                                                        <div class="col-md-3 logo-thumb">
                                                            <img src="{{LogoLink}}" ng-if="LogoLink"  class="img-responsive img-thumbnail limit-logo" />
                                                            <p ng-if="!LogoLink" class="margin-top-light">   <i class="fa fa-image font-size-18"></i> </p>
                                                        </div> 
                                                    </div>  

                                                    <div class="row margin-top-light"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top"> Favicon File:</span>
                                                        </div>
                                                        <div class="col-md-4"> 
                                                            <form name="pdfForm" id="pdfForm" ng-app="fileUpload"     >
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input mainfileUploads" id="mainfileUpload" aria-describedby="inputGroupFileAddon04" ngf-select ng-model="picFile" name="file"  ng-change="uploadLogo(picFile, ThemeLoops.themeID, customerName, customerNumber, 2)"  ng-click="clickAlert()"  accept="image/*"  ngf-model-invalid="errorFile" >
                                                                        <label class="custom-file-label" for="mainfileUpload">Choose Favicon</label>
                                                                    </div>
                                                                </div>  
                                                            </form>  
                                                        </div>
                                                        <div class="col-md-3 logo-thumb">
                                                            <img src="{{FaviconLink}}" ng-if="FaviconLink" />
                                                            <p ng-if="!FaviconLink" class="margin-top-light">   <i class="fa fa-image font-size-18"></i> </p>
                                                        </div> 
                                                    </div>  

                                                    <div class="row margin-top-light"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top"> OG Image Logo File:</span><br />
                                                            <small> Preferred size: 1200px X 630px </small>
                                                        </div>
                                                        <div class="col-md-4"> 
                                                            <form name="pdfForm" id="pdfForm" ng-app="fileUpload"     >
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input mainfileUploads" id="mainfileUpload" aria-describedby="inputGroupFileAddon04" ngf-select ng-model="picFile" name="file"  ng-change="uploadLogo(picFile, ThemeLoops.themeID, customerName, customerNumber, 3)"  ng-click="clickAlert()"  accept="image/jpeg, image/png"  ngf-model-invalid="errorFile" >
                                                                        <label class="custom-file-label" for="mainfileUpload">Choose OG Image</label>
                                                                    </div>
                                                                </div>  
                                                            </form>  
                                                        </div>
                                                        <div class="col-md-3 logo-thumb">
                                                            <img src="{{OGImageLink}}" ng-if="OGImageLink" class="img-responsive img-thumbnail limit-logo"  />
                                                            <p ng-if="!OGImageLink" class="margin-top-light">   <i class="fa fa-image font-size-18"></i> </p>
                                                        </div> 
                                                    </div>  


                                                    <div class="row margin-top-light"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top">Mobile  Logo File:</span><br />
                                                            <small> Preferred size: 320px X 80px </small>
                                                        </div>
                                                        <div class="col-md-4"> 
                                                            <form name="pdfForm" id="pdfForm" ng-app="fileUpload"     >
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input mainfileUploads" id="mainfileUpload" aria-describedby="inputGroupFileAddon04" ngf-select ng-model="picFile" name="file"  ng-change="uploadLogo(picFile, ThemeLoops.themeID, customerName, customerNumber, 4)"  ng-click="clickAlert()"  accept="image/png"  ngf-model-invalid="errorFile" >
                                                                        <label class="custom-file-label" for="mainfileUpload">Choose Mobile Logo</label>
                                                                    </div>
                                                                </div>  
                                                            </form>  
                                                        </div>
                                                        <div class="col-md-3 logo-thumb">
                                                            <img src="{{MobileLogoLink}}" ng-if="MobileLogoLink" class="img-responsive img-thumbnail limit-logo"  />
                                                            <p ng-if="!MobileLogoLink" class="margin-top-light">   <i class="fa fa-image font-size-18"></i> </p>
                                                        </div> 
                                                    </div>  




                                                     
                                                </div>
                                            </div>
                                        </div>



                                        <div class="card">
                                            <div class="card-header" id="headingThree">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                        Step 3: Pricing
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                                <div class="card-body">

                                                        <div class="row margin-top-light"> 
                                                            <div class="col-md-3 text-right">
                                                                <span class="padding-top"> Show Pricing:   </span>
                                                            </div>
                                                            <div class="col-md-7"> 
                                                                <select class="form-control col-md-5" name="showPricing"  ng-model="ThemeLoops.showPricing"> 
                                                                    <?php 
                                                                        foreach ($selectPricingDefault as $key => $value){
                                                                            echo '<option value="'.$key.'"  ng-selected="ThemeLoops.showPricing === '.$key.'" >'.$value.'</option>';
                                                                        }
                                                                    ?> 
                                                                </select>
                                                                <div   class="CodeReq text-red labelreq reqfield" ng-show="customEmailError">{{customEmailError}}</div>
                                                            </div>
                                                        </div> 

                                                        <div class="row margin-top-light"> 
                                                            <div class="col-md-3 text-right">
                                                                <span class="padding-top"> Enter Mark Ups:  </span>
                                                            </div>
                                                            <div class="col-md-8"> 

                                                                    <table class="table margin-top table-striped table-bordered"  border="0" cellspacing="0" cellpadding="0">
                                                                        <thead  class="thead-dark" >
                                                                            <tr>
                                                                                <th scope="col" colspan="7" align="center" style="text-align:center"> MARK UP  </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td width="20%" align="left">  &nbsp; </td>
                                                                                <td width="12%" align="center"> <span class="font-11-size">Quantity 1</span> </td> 
                                                                                <td width="12%" align="center"> <span class="font-11-size">Quantity 2</span>  </td>
                                                                                <td width="12%" align="center"> <span class="font-11-size">Quantity 3</span>  </td>
                                                                                <td width="12%" align="center"> <span class="font-11-size">Quantity 4</span>  </td>
                                                                                <td width="12%" align="center"> <span class="font-11-size">Quantity 5</span>  </td>
                                                                                <td width="12%" align="center"> <span class="font-11-size">Quantity 6</span>  </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td width="20%" align="left"> Mark-up % </td>
                                                                                <td width="12%" align="center" class="whitebackground"> <input type="text" name="markUp1" class="form-control text-center markInput" id=""   allow-only-numbers  ng-model="ThemeLoops.Q1Markup"   ng-value="ThemeLoops.Q1Markup"   >  </td>
                                                                                <td width="12%" align="center" class="whitebackground"> <input type="text" name="markUp2" class="form-control text-center markInput" id=""   allow-only-numbers  ng-model="ThemeLoops.Q2Markup"   ng-value="ThemeLoops.Q2Markup"  >  </td>
                                                                                <td width="12%" align="center" class="whitebackground"> <input type="text" name="markUp3" class="form-control text-center markInput" id=""   allow-only-numbers  ng-model="ThemeLoops.Q3Markup"  ng-value="ThemeLoops.Q3Markup"   >  </td>
                                                                                <td width="12%" align="center" class="whitebackground"> <input type="text" name="markUp4" class="form-control text-center markInput" id=""   allow-only-numbers  ng-model="ThemeLoops.Q4Markup"  ng-value="ThemeLoops.Q4Markup"   >  </td>
                                                                                <td width="12%" align="center" class="whitebackground"> <input type="text" name="markUp5" class="form-control text-center markInput" id=""   allow-only-numbers  ng-model="ThemeLoops.Q5Markup"  ng-value="ThemeLoops.Q5Markup"   >  </td>
                                                                                <td width="12%" align="center" class="whitebackground"> <input type="text" name="markUp6" class="form-control text-center markInput" id=""   allow-only-numbers  ng-model="ThemeLoops.Q6Markup"   ng-value="ThemeLoops.Q6Markup"   >  </td> 
                                                                            </tr>
                                                                            <tr>
                                                                                <td width="20%" align="left"> <span class="font-11-size">Branding Mark-up %</span>  </td>
                                                                                <td width="25%" colspan="2" align="center" class="whitebackground">  <input type="text" name="BrandingPriceMarkup" class="form-control text-center" id=""   allow-only-numbers  ng-model="ThemeLoops.BrandingPriceMarkup"   ng-value="ThemeLoops.BrandingPriceMarkup"> </td>
                                                                                <td width="50%" colspan="4"  align="left">  &nbsp; </td> 
                                                                            </tr>
                                                                            <tr>
                                                                                <td width="20%" align="left"> <span class="font-11-size">Setup Mark-up %</span>  </td>
                                                                                <td width="25%" colspan="2" align="center" class="whitebackground">  <input type="text" name="SetupMarkup" class="form-control text-center" id=""   allow-only-numbers  ng-model="ThemeLoops.SetupMarkup"   ng-value="ThemeLoops.SetupMarkup"> </td>
                                                                                <td width="50%" colspan="4"  align="left">  &nbsp; </td> 
                                                                            </tr>
                                                                        </tbody> 
                                                                    </table> 

                                                            </div>
                                                        </div> 

                                                        
                                                        <div class="row margin-top-light"> 
                                                            <div class="col-md-3 text-right">
                                                                <span class="padding-top"> Include Setups in Unit Price:   </span>
                                                            </div>
                                                            <div class="col-md-7"> 
                                                                <select class="form-control col-md-4" name="includeUnitPrice"  ng-model="ThemeLoops.includeUnitPrice"> 
                                                                    <?php 
                                                                        foreach ($selectActiveDefault as $key => $value){
                                                                            echo '<option value="'.$key.'"  ng-selected="ThemeLoops.includeUnitPrice === '.$key.'" >'.$value.'</option>';
                                                                        }
                                                                    ?> 
                                                                </select>
                                                            </div>
                                                        </div> 

                                                        <div class="row margin-top-light"> 
                                                            <div class="col-md-3 text-right">
                                                                <span class="padding-top"> Allow Less Than MOQ:  </span>
                                                            </div>
                                                            <div class="col-md-7"> 
                                                                <input    type="checkbox" id="allowMOQ" ng-model="ThemeLoops.allowMOQ" ng-change="checkAllowMOQ(ThemeLoops.allowMOQ)" ng-true-value="'1'" ng-false-value="'0'"   />
                                          
                                                                 
                                                            </div>
                                                        </div> 
                                                        <div class="row margin-top-light"> 
                                                            <div class="col-md-3 text-right">
                                                                <span class="padding-top"> Less Than MOQ Surcharge: </span>
                                                            </div>
                                                            <div class="col-md-7"> 
                                                                <input class="form-control col-md-4" ng-disabled="ThemeLoops.allowMOQ == '0' " type="text"  allow-only-numbers   ng-value="ThemeLoops.MOQSurcharge" ng-model="ThemeLoops.MOQSurcharge"  >
                                                            </div>
                                                        </div>  

                                                        <div class="row margin-top-light"> 
                                                            <div class="col-md-3 text-right">
                                                                <span class="padding-top"> Additional Info Text: </span>
                                                            </div>
                                                            <div class="col-md-7"> 
                                                                <input class="form-control" type="text"  ng-value="ThemeLoops.PricingInformation1" ng-model="ThemeLoops.PricingInformation1"  >
                                                            </div>
                                                            <div class="col-md-3 text-right"><span class="padding-top">&nbsp;</span></div>
                                                            <div class="col-md-7"> 
                                                                <input class="form-control" type="text"  ng-value="ThemeLoops.PricingInformation2" ng-model="ThemeLoops.PricingInformation2"  >
                                                            </div>
                                                            <div class="col-md-3 text-right"><span class="padding-top">&nbsp;</span></div>
                                                            <div class="col-md-7"> 
                                                                <input class="form-control" type="text"  ng-value="ThemeLoops.PricingInformation3" ng-model="ThemeLoops.PricingInformation3"  >
                                                            </div>
                                                            <div class="col-md-3 text-right"><span class="padding-top">&nbsp;</span></div>
                                                            <div class="col-md-7"> 
                                                                <input class="form-control" type="text"  ng-value="ThemeLoops.PricingInformation4" ng-model="ThemeLoops.PricingInformation4"  >
                                                            </div>
                                                            <div class="col-md-3 text-right"><span class="padding-top">&nbsp;</span></div>
                                                            <div class="col-md-7"> 
                                                                <input class="form-control" type="text"  ng-value="ThemeLoops.PricingInformation5" ng-model="ThemeLoops.PricingInformation5"  >
                                                            </div>
                                                            <div class="col-md-3 text-right"><span class="padding-top">&nbsp;</span></div>
                                                            <div class="col-md-7"> 
                                                                <input class="form-control" type="text"  ng-value="ThemeLoops.PricingInformation6" ng-model="ThemeLoops.PricingInformation6"  >
                                                            </div>
                                                            <div class="col-md-3 text-right"><span class="padding-top">&nbsp;</span></div>
                                                            <div class="col-md-7"> 
                                                                <input class="form-control" type="text"  ng-value="ThemeLoops.PricingInformation7" ng-model="ThemeLoops.PricingInformation7"  >
                                                            </div>
                                                            <div class="col-md-3 text-right"><span class="padding-top">&nbsp;</span></div>
                                                            <div class="col-md-7"> 
                                                                <input class="form-control" type="text"  ng-value="ThemeLoops.PricingInformation8" ng-model="ThemeLoops.PricingInformation8"  >
                                                            </div>
                                                            <div class="col-md-3 text-right"><span class="padding-top">&nbsp;</span></div>
                                                            <div class="col-md-7"> 
                                                                <input class="form-control" type="text"  ng-value="ThemeLoops.PricingInformation9" ng-model="ThemeLoops.PricingInformation9"  >
                                                            </div>
                                                            <div class="col-md-3 text-right"><span class="padding-top">&nbsp;</span></div>
                                                            <div class="col-md-7"> 
                                                                <input class="form-control" type="text"  ng-value="ThemeLoops.PricingInformation10" ng-model="ThemeLoops.PricingInformation10"  >
                                                            </div>
                                                        </div>  

                                                     

                                                     
                                                </div>
                                            </div>
                                        </div>


                                        <div class="card">
                                            <div class="card-header" id="headingFour">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                        Step 4: Colour Configurator
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                                <div class="card-body">
                                                                        
                                                        <style>
                                                                .theme-wrapper{
                                                                    background-color:#{{ThemeLoops.BackgroundColour}};
                                                                }
                                                                #ThemeMenuBG, #ThemeTopMenuMain{
                                                                    background-color: #{{ThemeLoops.headerBackground}}; 
                                                                }
                                                                .prodHeaders{
                                                                    color: #{{ThemeLoops.paragraphTextColour}};
                                                                }
                                                               /* .miniTopMenu:hover, .miniBottomMenu:hover  {
                                                                    color: #{{ThemeLoops.textHighlightColour}} !important; 
                                                                    background-color: #{{ThemeLoops.menuHighlightColour}};    
                                                                } */
                                                                .miniTopMenuSep {
                                                                    width:12px !important;
                                                                    color: #{{ThemeLoops.headerTrimColour}};  
                                                                }
                                                                .searchBoxMini {
                                                                    color: #{{ThemeLoops.searchBoxTextColour}};
                                                                    background-color: #{{ThemeLoops.searchBoxColour}}; 
                                                                    border-color: #{{ThemeLoops.searchBoxTextColour}};
                                                                }
                                                                .categoryTextTiny {
                                                                    color: #{{ThemeLoops.paragraphTextColour}};
                                                                }
                                                                #fancy-200Txt:hover, .fancyBanner:hover,  .fancyBannerSML:hover, .pixBoxLittle:hover, .miniButton:hover {
                                                                    /* box-shadow: 0px 2px 3px rgba( {{categoryBoxShadow.r}},  {{categoryBoxShadow.g}},  {{categoryBoxShadow.b}}, 1) !important; */
                                                                }   
                                                                .fancy-200:hover{
                                                                    box-shadow: 0px 2px 3px #787878 !important; 

                                                                }
                                                                .miniTabInactive { 
                                                                    background-color: #{{ThemeLoops.tabColour}}; 
                                                                    color: #{{ThemeLoops.tabTextColour}};
                                                                }
                                                                .miniTabActive { 
                                                                    background: #{{ThemeLoops.tabSelectedColour}}; 
                                                                    color: #{{ThemeLoops.tabSelectedText}};
                                                                }
                                                                .miniTabInactive:hover {
                                                                    /* color: #{{ThemeLoops.tabTextColourHover}}; */
                                                                }
                                                                .datagridTiny { 
                                                                    /* border: 1px solid #{{ThemeLoops.tableBorderColour}}; */
                                                                    border: 1px solid #9a9b9c;  
                                                                }
                                                                .datagridTiny table thead th {
                                                                    background-color: #{{ThemeLoops.tableHeaderColour}};
                                                                    color: #{{ThemeLoops.tableHeaderTextColour}};  
                                                                }
                                                                .datagridTiny table tbody td {
                                                                    color: #{{ThemeLoops.tableCellTextColour}}; 
                                                                    background-color: #{{ThemeLoops.tableCellColour}}; 
                                                                    /* border-left: 1px solid #{{ThemeLoops.tableBorderColour}}; 
                                                                    border-bottom: 1px solid #{{ThemeLoops.tableBorderColour}}; */
                                                                    border-left: 1px solid #9a9b9c;   
																	border-bottom: 1px solid #9a9b9c;  
                                                                }
                                                                .miniHeading { 
                                                                    color: #{{ThemeLoops.paragraphTextColour}};
                                                                }
                                                                .miniButtonText { 
                                                                    color: #{{ThemeLoops.paragraphTextColour}};
                                                                } 
                                                                .miniTopMenu, .miniBottomMenu{
                                                                    color: #{{ThemeLoops.headerTextColour}};
                                                                }
                                                                .themeconfig-menu{
                                                                    bottom: 0px !important;
                                                                    background-color:#{{ThemeLoops.CategoryIconOverlay}};  
                                                                    
																}
																.miniBottomMenu{
																	padding:0px 3px 0px 3px;
																    color:#{{ThemeLoops.tabTextColourHover}}; 
																					
																}
																#ThemeMenuBG{
																	color: #{{ThemeLoops.paragraphTextColour}}; 
																}
																.buttonDiv .icon-box{
																	background-color:#{{ThemeLoops.tableBorderColour}};
                                                                }
                                                                .miniMenu { 
                                                                    border-bottom-right-radius: 0px !important;
                                                                    border-bottom-left-radius:  0px !important;
                                                                    box-shadow: 0px none;
                                                                }
                                                               /* .miniTopMenu:hover, #ThemeTopMenuMain a.miniTopMenu:hover, .miniBottomMenu:hover{
                                                                   
                                                                } */
                                                                 
                                                                 
                                                                .skinnedAdmin .fancy-200 { 
                                                                    border-radius: 0px; 
                                                                }
                                                              
																.searchBoxMini:hover{
																	border:1px solid #{{ThemeLoops.textHighlightColour}};
                                                                }

                                                                .pixBox {
																				  
																					border-radius: 0px  !important; 
																				 
																}
																.pixBoxLittle {
																					  
                                                                    border-radius: 0px  !important;  
																					 
                                                                }
                                                                .buttonDiv{
                                                                     width:60px;
                                                                     float:right;
                                                                }
                                                                .buttonDiv .icon-box{
                                                                                    background-color:#{{ThemeLoops.tableBorderColour}};
                                                                                    
                                                                }
                                                                .icon-box {
                                                                    display: block;
                                                                    width: 100%;
                                                                    height: auto;
                                                                    padding: 4px !important;
                                                                    text-align: center;
                                                                    background-color: #63676b;
                                                                    border-radius: 5%;
                                                                    margin-bottom: 15px;
                                                                    max-width: 50px;
                                                                }
                                                                .icon-box a, .icon-box i{
                                                                    color: #fff !important;
                                                                }
                                                                #ThemeTopMenuMain{
                                                                    position:relative;
                                                                }
                                                                .dropdown-menu-sample{
                                                                    position:absolute;
                                                                    top:19px;
                                                                    left:42%;
                                                                    width:103px;
                                                                    background-color:#fff;
                                                                    padding-top:4px;
                                                                    padding-bottom:4px;
                                                                    z-index:9999;
                                                                }
                                                                .dropMenuSample{
                                                                    display:block;
                                                                    padding:2px;    
                                                                }
                                                                .dropMenuSample:hover{ 
                                                                    color: #{{ThemeLoops.headerTextColour}} !important; 
																	background-color: #{{ThemeLoops.menuHoverBackground}};    
                                                                }
                                                                .miniTopMenu:hover  {
                                                                    color: #{{ThemeLoops.menuHighlightColour}} !important; 
                                                                   
                                                                }
                                                                .miniBottomMenu:hover{
                                                                    color: inherit !important;
                                                                }
                                                                .miniBottomMenu:hover, .miniTopMenu:hover {
                                                                    background: none !important;
                                                                    background-color: transparent !important;
                                                                }
                                                                
                                                                  
                                                        </style> 

                                                        <?php 
                                                            $themeHeader = '<div id="ThemeMenuBG" class="miniMenu" style="width:90%;margin-left:auto; margin-right:auto; background-color: #{{ThemeLoops.headerBackground}}">
                                                            <div style="width:100%; background:#0a0a0a;">
                                                                <div id="ThemeTopMenuMain" style="width:100%;font-size:10px; font-family:Open Sans, sans-serif; background-color: #{{ThemeLoops.headerTrimColour}}">
                                                                    <a href="#" class="miniTopMenu" style="margin-left:5%; color: #{{ThemeLoops.menuHighlightColour}}">TOP MENU</a>
                                                                    <div class="miniTopMenuSep" >|</div>
                                                                    <a href="#" class="miniTopMenu" style="color: #{{ThemeLoops.menuHighlightColour}}" >TOP MENU</a>
                                                                    <div class="miniTopMenuSep">|</div>
                                                                    <a href="#" class="miniTopMenu" style="color: #{{ThemeLoops.menuHighlightColour}}">TOP MENU</a>
                                                                    <div class="miniTopMenuSep">|</div>
                                                                    <a href="#" class="miniTopMenu" style="color: #{{ThemeLoops.menuHighlightColour}}">TOP MENU</a>
                                                                    <div class="miniTopMenuSep">|</div>
                                                                    <a href="#" class="miniTopMenu" style="color: #{{ThemeLoops.menuHighlightColour}}">TOP MENU</a>
                                                                    <div class="dropdown-menu-sample">
                                                                        <a href="#" class="dropMenuSample"  >DROPDOWN MENU</a>
                                                                        <a href="#" class="dropMenuSample"  >DROPDOWN MENU</a>
                                                                        <a href="#" class="dropMenuSample"  >DROPDOWN MENU</a>
                                                                    </div>
                                                                    <div class="miniTopMenuSep">|</div>
                                                                    <a href="#" class="miniTopMenu" style="color: #{{ThemeLoops.menuHighlightColour}}">TOP MENU</a>
                                                                    <div class="miniTopMenuSep">|</div>
                                                                    <a href="#" class="miniTopMenu" style="color: #{{ThemeLoops.menuHighlightColour}}">TOP MENU</a>
                                                                    <div class="miniTopMenuSep">|</div>
                                                                    <a href="#" class="miniTopMenu" style="color: #{{ThemeLoops.menuHighlightColour}}">TOP MENU</a>
                                                                </div>
                                                            </div>
                                                            <span class="menuImg">
                                                                <img src="{{LogoLink}}" ng-if="LogoLink"  height="40px" />
                                                                <span ng-if="!LogoLink" class="margin-top-light">   <i class="fa fa-image font-size-18"></i> </span>
                                                            </span>
                                                            <div id="ThemeSearch" class="searchBoxMini"><em>Search products, categories and colours</em></div>
                                                            <div style="clear:both"></div>
                                                            <div class="themeconfig-menu" style="width:100%;font-size:10px;color:#ffffff;font-family:Open Sans, sans-serif;">
                                                                <a href="#" class="miniBottomMenu" style="margin-left:5%; ">MENU</a>
                                                                <a href="#" class="miniBottomMenu"  >MENU</a>
                                                                <a href="#" class="miniBottomMenu"  >MENU</a>
                                                                <a href="#" class="miniBottomMenu" >MENU</a>
                                                                <a href="#" class="miniBottomMenu"  >MENU</a>
                                                                <a href="#" class="miniBottomMenu"  >MENU</a>
                                                                <a href="#" class="miniBottomMenu"  >MENU</a>
                                                                <a href="#" class="miniBottomMenu"   >MENU</a>
                                                                <a href="#" class="miniBottomMenu" >MENU</a>
                                                                <a href="#" class="miniBottomMenu" >MENU</a>
                                                                <a href="#" class="miniBottomMenu" >MENU</a>
                                                                <a href="#" class="miniBottomMenu"  >MENU</a> 
                                                            </div>
                                                        </div>';
                                                        ?>

                                                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="false">
                                                            

                                                            <div class="carousel-inner">
                                                                <div class="carousel-item active">


                                                                     <div class="row">
                                                                         <div class="col-md-1">&nbsp;</div>
                                                                         <div class="col-md-10">
                                                                            <h4>Colour Configurator – Page 1 of 2 </h4>
                                                                            <p> Click on the colour swatches to select colours. Your changes will be live once you click Save. </p>

                                                                            <div class="row margin-top" >
                                                                                <div class="col-md-12 theme-wrapper" style="background-color:#{{ThemeLoops.BackgroundColour}}">

                                                                                     <?php echo $themeHeader; ?>   

                                                                                    <div class="prodHeaders" style="width:90%;margin-left:auto; margin-right:auto; color: #{{ThemeLoops.paragraphTextColour}};">
                                                                                        <div style="float:left;margin-left:5px">Category Name</div><div style="float:right;margin-right:5px;font-size:12px">Page 1 of 1</div>
                                                                                    </div>
                                                                                    <div style="clear: both"></div>

                                                                                    <div class="skinnedAdmin" style="width:90%;margin-left:auto; margin-right:auto;"> 
                                                                                        <div class="row margin-top-light">
                                                                                            <?Php for($i = 0; $i <= 3; $i++ ){  ?>
                                                                                                <div class="col-md-3">
                                                                                                    <span style="position:relative;display:block; ">
                                                                                                        <span class="categoryBox-200" style="width:100%; border-radius:10%;">
                                                                                                            <div class="fancy-200" style="background-color:#fff; padding:4px; " id="fancy-200Txt">
                                                                                                                <img src="../../Images/product.jpg" width="100%" height="auto" border="0" class="fancyX"/>
                                                                                                                <div class='categoryTextTiny' style="text-align:center; padding-bottom:7px;">
                                                                                                                    <strong>PRODUCT NAME</strong><br />
                                                                                                                    <span style="font-size:7px">Branded from as low as</span><br />
                                                                                                                    <strong>$x.xx</strong>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </span>
                                                                                                    </span>
                                                                                                </div>
                                                                                            <?php } ?>    
                                                                                        </div>
                                                                                    </div>



                                                                                </div>    
                                                                            </div>

                                                                            <div class="row margin-top-light colour-select">
                                                                                <div class="col-md-3 text-right">
                                                                                    <span>Header Background  </span> 
                                                                                </div>
                                                                                <div class="col-md-2"> 
                                                                                    <input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.headerBackground, 'headerbg')" ng-model="ThemeLoops.headerBackground" style="background-color:#{{ThemeLoops.headerBackground}}" />
                                                                                </div>
                                                                                <div class="col-md-1 text-left">
                                                                                    <span class="undo" ng-click="undoColor('headerbg')"  title="Undo Colour" ><i class="fa fa-undo"></i></span>
                                                                                </div>

                                                                                <div class="col-md-3 text-right">
                                                                                    <span> Search Box </span> 
                                                                                </div>
                                                                                <div class="col-md-2"> 
                                                                                    <input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.searchBoxColour, 'searchbox')" ng-model="ThemeLoops.searchBoxColour" style="background-color:#{{ThemeLoops.searchBoxColour}}" />   
                                                                                </div>
                                                                                <div class="col-md-1 text-left">
                                                                                    <span class="undo" ng-click="undoColor('searchbox')"  title="Undo Colour" ><i class="fa fa-undo"></i></span>
                                                                                </div> 

                                                                               
                                                                            </div>    

                                                                             <div class="row margin-top-light colour-select">
                                                                                <div class="col-md-3 text-right">
                                                                                    <span> Menu Hover Text  Colour </span> 
                                                                                </div>
                                                                                <div class="col-md-2"> 
                                                                                    <input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.headerTextColour, 'headertext')" ng-model="ThemeLoops.headerTextColour" style="background-color:#{{ThemeLoops.headerTextColour}}" />
                                                                                </div>
                                                                                <div class="col-md-1 text-left">
                                                                                    <span class="undo" ng-click="undoColor('headertext')"  title="Undo Colour" ><i class="fa fa-undo"></i></span>
                                                                                </div>

                                                                                <div class="col-md-3 text-right">
                                                                                    <span> Search Box Text </span> 
                                                                                </div>
                                                                                <div class="col-md-2"> 
                                                                                    <input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.searchBoxTextColour, 'searchtext')" ng-model="ThemeLoops.searchBoxTextColour" style="background-color:#{{ThemeLoops.searchBoxTextColour}}" />   
                                                                                </div>
                                                                                <div class="col-md-1 text-left">
                                                                                    <span class="undo" ng-click="undoColor('searchtext')"  title="Undo Colour" ><i class="fa fa-undo"></i></span>
                                                                                </div> 
                                                                            </div>   

                                                                            <div class="row margin-top-light colour-select"> 
                                                                                <div class="col-md-3 text-right">
                                                                                    <span>Top Menu Background </span> 
                                                                                </div>
                                                                                <div class="col-md-2"> 
                                                                                    <input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.headerTrimColour, 'headertrim')" ng-model="ThemeLoops.headerTrimColour" style="background-color:#{{ThemeLoops.headerTrimColour}}" />
                                                                                </div>
                                                                                <div class="col-md-1 text-left">
                                                                                    <span class="undo" ng-click="undoColor('headertrim')" title="Undo Colour"  ><i class="fa fa-undo"></i></span>
                                                                                </div> 


                                                                                <div class="col-md-3 text-right">
                                                                                    <span> Search Border Focus </span> 
                                                                                </div>
                                                                                <div class="col-md-2"> 
                                                                                    <input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.textHighlightColour, 'texthighlight')" ng-model="ThemeLoops.textHighlightColour" style="background-color:#{{ThemeLoops.textHighlightColour}}" />
                                                                                </div>
                                                                                <div class="col-md-1 text-left">
                                                                                    <span class="undo" ng-click="undoColor('texthighlight')" title="Undo Colour"  ><i class="fa fa-undo"></i></span>
                                                                                </div>  


                                                                            </div>    

                                                                             <div class="row margin-top-light colour-select"> 
                                                                                <div class="col-md-3 text-right"> 
                                                                                    <span> Top Menu Text Colour </span> 
                                                                                </div>
                                                                                <div class="col-md-2"> 
                                                                                    <input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.menuHighlightColour, 'menuhighlight')" ng-model="ThemeLoops.menuHighlightColour" style="background-color:#{{ThemeLoops.menuHighlightColour}}" />
                                                                                </div>
                                                                                <div class="col-md-1 text-left">
                                                                                    <span class="undo" ng-click="undoColor('menuhighlight')" title="Undo Colour"  ><i class="fa fa-undo"></i></span>
                                                                                </div> 
                                                                                <div class="col-md-3 text-right">
                                                                                    <span> Body Text Colour </span> 
                                                                                </div>
                                                                                <div class="col-md-2"> 
                                                                                    <input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.paragraphTextColour, 'bodytext')" ng-model="ThemeLoops.paragraphTextColour" style="background-color:#{{ThemeLoops.paragraphTextColour}}" />
                                                                                </div>
                                                                                <div class="col-md-1 text-left">
                                                                                    <span class="undo" ng-click="undoColor('bodytext')"  title="Undo Colour" ><i class="fa fa-undo"></i></span>
                                                                                </div>  
                                                                            </div>   

                                                                             
                                                                             <div class="row margin-top-light colour-select"> 
                                                                                <div class="col-md-3 text-right">
                                                                                    <span> Bottom Menu Background </span> 
                                                                                </div>
                                                                                <div class="col-md-2"> 
                                                                                    <input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.CategoryIconOverlay, 'bottommenubg')" ng-model="ThemeLoops.CategoryIconOverlay" style="background-color:#{{ThemeLoops.CategoryIconOverlay}}" />
                                                                                </div>
                                                                                <div class="col-md-1 text-left">
                                                                                    <span class="undo" ng-click="undoColor('bottommenubg')" title="Undo Colour"  ><i class="fa fa-undo"></i></span>
                                                                                </div> 
                                                                                <div class="col-md-3 text-right">
                                                                                    <span> Product Text Colour </span> 
                                                                                </div>
                                                                                <div class="col-md-2"> 
                                                                                    <input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.categoryTextColour, 'producttext')" ng-model="ThemeLoops.categoryTextColour" style="background-color:#{{ThemeLoops.categoryTextColour}}" />
                                                                                </div>
                                                                                <div class="col-md-1 text-left">
                                                                                    <span class="undo" ng-click="undoColor('producttext')"  title="Undo Colour" ><i class="fa fa-undo"></i></span>
                                                                                </div>  
                                                                            </div>   
                                                                                
                                                                             

                                                                            <div class="row margin-top-light colour-select"> 
                                                                                <div class="col-md-3 text-right">
                                                                                    <span> Bottom Menu Colour </span> 
                                                                                </div>
                                                                                <div class="col-md-2"> 
                                                                                <input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.tabTextColourHover, 'tabTextColourHover')" ng-model="ThemeLoops.tabTextColourHover" style="background-color:#{{ThemeLoops.tabTextColourHover}}" />
                                                                                </div>
                                                                                <div class="col-md-1 text-left">
                                                                                <span class="undo" ng-click="undoColor('tabTextColourHover')"  title="Undo Colour" ><i class="fa fa-undo"></i></span>
                                                                                </div> 
                                                                                <div class="col-md-3 text-right">
                                                                                    <span>Body Background </span> 
                                                                                </div>
                                                                                <div class="col-md-2"> 
                                                                                    <input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.BackgroundColour, 'body')" ng-model="ThemeLoops.BackgroundColour" style="background-color:#{{ThemeLoops.BackgroundColour}}" />
                                                                                </div>
                                                                                <div class="col-md-1 text-left">
                                                                                    <span class="undo" ng-click="undoColor('body')" title="Undo Colour"  ><i class="fa fa-undo"></i></span>
                                                                                </div> 
                                                                            </div>   


                                                                            <div class="row margin-top-light colour-select"> 
                                                                                <div class="col-md-3 text-right">
                                                                                    <span> Menu Hover Background Colour </span> 
                                                                                </div>
                                                                                <div class="col-md-2"> 
                                                                                <input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.menuHoverBackground, 'menuHoverBackground')" ng-model="ThemeLoops.menuHoverBackground" style="background-color:#{{ThemeLoops.menuHoverBackground}}" />
                                                                                </div>
                                                                                <div class="col-md-1 text-left">
                                                                                <span class="undo" ng-click="undoColor('menuHoverBackground')"  title="Undo Colour" ><i class="fa fa-undo"></i></span>
                                                                                </div> 
                                                                                <div class="col-md-3 text-right">
                                                                                    &nbsp;
                                                                                </div>
                                                                                <div class="col-md-2"> 
                                                                                    &nbsp;
                                                                                </div>
                                                                                <div class="col-md-1 text-left">
                                                                                    &nbsp;
                                                                                </div> 
                                                                            </div>   
                                                                                
                                                                                



                                                                         </div>
                                                                         <div class="col-md-1">&nbsp;</div>
                                                                    </div>


                                                                </div>
                                                                <div class="carousel-item">

                                                                    <div class="row">
                                                                        <div class="col-md-1">&nbsp;</div>
                                                                         <div class="col-md-10">
                                                                            <h4>Colour Configurator – Page 2 of 2</h4>
                                                                            <p> Click on the colour swatches to select colours. Your changes will be live once you click Save. </p>

                                                                            <div class="row margin-top" >
                                                                                <div class="col-md-12 theme-wrapper" style="background-color:#{{ThemeLoops.BackgroundColour}}">
                                                                                    <?php echo $themeHeader; ?>   

                                                                                    <div class="prodHeaders" style="width:90%;margin-left:auto; margin-right:auto; color: #{{ThemeLoops.paragraphTextColour}};">
                                                                                        <div style="float:left;margin-left:5px">Product Name</div><div style="float:right;margin-right:5px;font-size:14px">Code</div>
                                                                                    </div>
                                                                                    <div style="clear: both"></div>                    
                                                                                    <div style="width:90%;margin-left:auto; margin-right:auto;  ">
                                                                                                
                                                                                    <div class="row margin-top-light">
                                                                                        <div class="col-md-4">
                                                                                            <div class="pixBox">&nbsp;</div>
                                                                                            <div style="padding-left:8px;padding-top:5px;cursor: default;">
                                                                                                <div class="pixBoxLittle">&nbsp;</div>
                                                                                                <div class="pixBoxLittle">&nbsp;</div>
                                                                                                <div class="pixBoxLittle">&nbsp;</div>
                                                                                                <div class="pixBoxLittle">&nbsp;</div>
                                                                                                <div class="pixBoxLittle">&nbsp;</div>
                                                                                            </div>
                                                                                            <div style="padding-left:8px;padding-top:5px;cursor: default;">
                                                                                                <div class="pixBoxLittle">&nbsp;</div>
                                                                                                <div class="pixBoxLittle">&nbsp;</div>
                                                                                                <div class="pixBoxLittle">&nbsp;</div>
                                                                                                <div class="pixBoxLittle">&nbsp;</div>
                                                                                                <div class="pixBoxLittle">&nbsp;</div>
                                                                                            </div>
                                                                                        </div>  
                                                                                        <div class="col-md-6">

                                                                                            <div class="miniTabInactive details-tab">Details</div><div class="miniTabActive">Stock</div> <div ng-if="ThemeLoops.showPricing == '1' " class="miniTabInactive">Pricing</div> 
                                                                                            <span class="tab-line"></span>
                                                                                            
                                                                                            <div class="datagridTiny">
                                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <th width="40%" style='padding-left:1px;'>Item</th>
                                                                                                            <th width="20%" style='padding-left:1px;'>Quantity</th>
                                                                                                            <th width="40%" style='padding-left:1px;'>Next Shipment</th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td style='padding-left:1px;'>Orange/White</td>
                                                                                                            <td style='padding-left:1px;'>1,095</td>
                                                                                                            <td style='padding-left:1px;'>-</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td style='padding-left:1px;'>Red/White</td>
                                                                                                            <td style='padding-left:1px;'>200</td>
                                                                                                            <td style='padding-left:1px;'>Late April</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td style='padding-left:1px;'>Green/White</td>
                                                                                                            <td style='padding-left:1px;'>1,068</td>
                                                                                                            <td style='padding-left:1px;'>-</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td style='padding-left:1px;'>Blue/White</td>
                                                                                                            <td style='padding-left:1px;'>580</td>
                                                                                                            <td style='padding-left:1px;'>-</td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>

                                                                                            <?
                                                                                                $past = date('Y-m-d G:i', strtotime("-6 Hours"))
                                                                                            ?>
                                                                                            <div class="miniBody">Last Updated <? echo $past; ?> (6 hours ago)</div>
                                                                                                



                                                                                        </div> 
                                                                                        <div class="col-md-2 text-center">
                                                                                                
                                                                                            <div class="buttonDiv">
                                                                                                                    <span class="icon-box branding-side"  >
																														<a href="#"  class="span-a"><i class="fa fa-file-pdf-o"></i></a>
																													</span> 
																													
																													<span class="icon-box zoom-side"  >
																														<i class="fa  fa-search-plus"></i> 
																													</span>
																													
																														<span class="icon-box mixmatch-side"  >
																															<span  >
																																<i class="fa fa-paint-brush"></i>
																															</span>
																														</span>
																													 
																														<span class="icon-box mail-side"  >
																															<span ><i class="fa fa-envelope"></i></span>
																														</span>    
                                                                                            </div>
                                                                                        
                                                                                        </div> 
                                                                                    </div>

                                                                                        
                                                                                    </div>    



                                                                                </div>
                                                                            </div>   
                                                                            
                                                                            <div class="row margin-top-light">
                                                                                <div class="col-md-6">
                                                                                    <!-- colours-->
                                                                                    <div class="row margin-top-light colour-select">
                                                                                        <div class="col-md-6 text-right">
                                                                                            <span> Tab Colour </span> 
                                                                                        </div>
                                                                                        <div class="col-md-4"> 
                                                                                            <input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.tabColour, 'tabColour')" ng-model="ThemeLoops.tabColour" style="background-color:#{{ThemeLoops.tabColour}}" />
                                                                                        </div>
                                                                                        <div class="col-md-2 text-left">
                                                                                            <span class="undo" ng-click="undoColor('tabColour')"  title="Undo Colour" ><i class="fa fa-undo"></i></span>
                                                                                        </div>
                                                                                    </div>    
                                                                                     <!-- colours-->

                                                                                     <!-- colours-->
                                                                                    <div class="row margin-top-light colour-select">
                                                                                        <div class="col-md-6 text-right">
                                                                                            <span> Tab Text Colour </span> 
                                                                                        </div>
                                                                                        <div class="col-md-4"> 
                                                                                            <input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.tabTextColour, 'tabTextColour')" ng-model="ThemeLoops.tabTextColour" style="background-color:#{{ThemeLoops.tabTextColour}}" />
                                                                                        </div>
                                                                                        <div class="col-md-2 text-left">
                                                                                            <span class="undo" ng-click="undoColor('tabTextColour')"  title="Undo Colour" ><i class="fa fa-undo"></i></span>
                                                                                        </div>
                                                                                    </div>    
                                                                                     <!-- colours-->

                                                                                     
                                                                                     <!-- colours-->
                                                                                     <!--
                                                                                    <div class="row margin-top-light colour-select">
                                                                                        <div class="col-md-6 text-right">
                                                                                            <span>Tab Text Hover Colour</span>
                                                                                            <small> {{rgbtabTextColourHover}} </small>
                                                                                        </div>
                                                                                        <div class="col-md-4"> 
                                                                                            <input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.tabTextColourHover, 'tabTextColourHover')" ng-model="ThemeLoops.tabTextColourHover" style="background-color:#{{ThemeLoops.tabTextColourHover}}" />
                                                                                        </div>
                                                                                        <div class="col-md-2 text-left">
                                                                                            <span class="undo" ng-click="undoColor('tabTextColourHover')"  title="Undo Colour" ><i class="fa fa-undo"></i></span>
                                                                                        </div>
                                                                                    </div>   --> 
                                                                                     <!-- colours-->

                                                                                      <!-- colours-->
                                                                                    <div class="row margin-top-light colour-select">
                                                                                        <div class="col-md-6 text-right">
                                                                                            <span>Selected Tab Colour</span> 
                                                                                        </div>
                                                                                        <div class="col-md-4"> 
                                                                                            <input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.tabSelectedColour, 'tabSelectedColour')" ng-model="ThemeLoops.tabSelectedColour" style="background-color:#{{ThemeLoops.tabSelectedColour}}" />
                                                                                        </div>
                                                                                        <div class="col-md-2 text-left">
                                                                                            <span class="undo" ng-click="undoColor('tabSelectedColour')"  title="Undo Colour" ><i class="fa fa-undo"></i></span>
                                                                                        </div>
                                                                                    </div>    
                                                                                     <!-- colours-->

                                                                                      <!-- colours-->
                                                                                    <div class="row margin-top-light colour-select">
                                                                                        <div class="col-md-6 text-right">
                                                                                            <span>Selected Tab Text Colour</span> 
                                                                                        </div>
                                                                                        <div class="col-md-4"> 
                                                                                            <input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.tabSelectedText, 'tabSelectedText')" ng-model="ThemeLoops.tabSelectedText" style="background-color:#{{ThemeLoops.tabSelectedText}}" />
                                                                                        </div>
                                                                                        <div class="col-md-2 text-left">
                                                                                            <span class="undo" ng-click="undoColor('tabSelectedText')"  title="Undo Colour" ><i class="fa fa-undo"></i></span>
                                                                                        </div>
                                                                                    </div>    
                                                                                     <!-- colours-->


                                                                                </div>   
                                                                                <div class="col-md-6">

                                                                                        <!-- colours-->
                                                                                        <div class="row margin-top-light colour-select">
                                                                                            <div class="col-md-6 text-right">
                                                                                                <span>Icon Box Colour </span> 
                                                                                            </div>
                                                                                            <div class="col-md-4"> 
                                                                                                <input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.tableBorderColour, 'tableBorderColour')" ng-model="ThemeLoops.tableBorderColour" style="background-color:#{{ThemeLoops.tableBorderColour}}" />
                                                                                            </div>
                                                                                            <div class="col-md-2 text-left">
                                                                                                <span class="undo" ng-click="undoColor('tableBorderColour')"  title="Undo Colour" ><i class="fa fa-undo"></i></span>
                                                                                            </div>
                                                                                        </div>    
                                                                                        <!-- colours-->

                                                                                        <!-- colours-->
                                                                                        <div class="row margin-top-light colour-select">
                                                                                            <div class="col-md-6 text-right">
                                                                                                <span>Table Header Colour</span> 
                                                                                            </div>
                                                                                            <div class="col-md-4"> 
                                                                                                <input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.tableHeaderColour, 'tableHeaderColour')" ng-model="ThemeLoops.tableHeaderColour" style="background-color:#{{ThemeLoops.tableHeaderColour}}" />
                                                                                            </div>
                                                                                            <div class="col-md-2 text-left">
                                                                                                <span class="undo" ng-click="undoColor('tableHeaderColour')"  title="Undo Colour" ><i class="fa fa-undo"></i></span>
                                                                                            </div>
                                                                                        </div>    
                                                                                        <!-- colours-->

                                                                                         <!-- colours-->
                                                                                         <div class="row margin-top-light colour-select">
                                                                                            <div class="col-md-6 text-right">
                                                                                                <span>Table Header Text Colour</span> 
                                                                                            </div>
                                                                                            <div class="col-md-4"> 
                                                                                                <input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.tableHeaderTextColour, 'tableHeaderTextColour')" ng-model="ThemeLoops.tableHeaderTextColour" style="background-color:#{{ThemeLoops.tableHeaderTextColour}}" />
                                                                                            </div>
                                                                                            <div class="col-md-2 text-left">
                                                                                                <span class="undo" ng-click="undoColor('tableHeaderTextColour')"  title="Undo Colour" ><i class="fa fa-undo"></i></span>
                                                                                            </div>
                                                                                        </div>    
                                                                                        <!-- colours-->

                                                                                         <!-- colours-->
                                                                                         <div class="row margin-top-light colour-select">
                                                                                            <div class="col-md-6 text-right">
                                                                                                <span>Table Cell Colour</span> 
                                                                                            </div>
                                                                                            <div class="col-md-4"> 
                                                                                                <input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.tableCellColour, 'tableCellColour')" ng-model="ThemeLoops.tableCellColour" style="background-color:#{{ThemeLoops.tableCellColour}}" />
                                                                                            </div>
                                                                                            <div class="col-md-2 text-left">
                                                                                                <span class="undo" ng-click="undoColor('tableCellColour')"  title="Undo Colour" ><i class="fa fa-undo"></i></span>
                                                                                            </div>
                                                                                        </div>    
                                                                                        <!-- colours-->

                                                                                        <!-- colours-->
                                                                                        <div class="row margin-top-light colour-select">
                                                                                            <div class="col-md-6 text-right">
                                                                                                <span>Table Cell Text Colour</span> 
                                                                                            </div>
                                                                                            <div class="col-md-4"> 
                                                                                                <input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.tableCellTextColour, 'tableCellTextColour')" ng-model="ThemeLoops.tableCellTextColour" style="background-color:#{{ThemeLoops.tableCellTextColour}}" />
                                                                                            </div>
                                                                                            <div class="col-md-2 text-left">
                                                                                                <span class="undo" ng-click="undoColor('tableCellTextColour')"  title="Undo Colour" ><i class="fa fa-undo"></i></span>
                                                                                            </div>
                                                                                        </div>    
                                                                                        <!-- colours-->




                                                                                </div>    
                                                                            </div>



                                                                         </div>
                                                                         <div class="col-md-1">&nbsp;</div>
                                                                     </div>

                                                                     
                                                                </div>
                                                                 
                                                            </div>
                                                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                <span class="sr-only">Previous</span>
                                                            </a>
                                                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                <span class="sr-only">Next</span>
                                                            </a>
                                                        </div>

                                                        <p class="margin-top   border-top-padding"><a ng-if="themeUrl" href="{{themeUrl}}" target="_blank"  > <i class="fa  fa-external-link text-red font-size-18"></i> Preview Theme</a></p>
                                                                            
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card">
                                            <div class="card-header" id="headingFive">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                        Step 5: Google Anayltics
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                                                <div class="card-body">

                                                    <div class="row margin-top-light"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top"> Google Account Reference: </span>
                                                        </div>
                                                        <div class="col-md-7"> 
                                                                <?php $selectGmailDefault = array('1' => 'tuapekagoldprint@gmail.com', '2'=>'tgpcsm@gmail.com'); ?>
                                                                <select class="form-control col-md-7" name="gmailAccount"  ng-model="ThemeLoops.gmailAccount"> 
                                                                    <?php 
                                                                        foreach ($selectGmailDefault as $key => $value){
                                                                            echo '<option value="'.$key.'"  ng-selected="ThemeLoops.gmailAccount === '.$key.'" >'.$value.'</option>';
                                                                        }
                                                                    ?> 
                                                                </select>
                                                        </div>
                                                    </div> 

                                                    <div class="row margin-top-light"> 
                                                        <div class="col-md-3 text-right">
                                                            <span class="padding-top"> Tracking ID: </span>
                                                        </div>
                                                        <div class="col-md-7"> 
                                                            <input class="form-control" type="text"  ng-value="ThemeLoops.googleAnalyticsID" ng-model="ThemeLoops.googleAnalyticsID"  >
                                                        </div>
                                                    </div>  

                                                    
                                                                                                   

                                                </div>
                                            </div>
                                        </div>



                                        <div class="card">
                                            <div class="card-header" id="headingSix">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                        Step 6: Skinned Site Banner
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
                                                <div class="card-body">

                                                        
                                                            <?php 
                                                                $selectDefault = array('0' => 'No', '1'=>'Yes'); 
                                                                $selectPopup = array('0' => 'Current Window', '1'=>'Open in Pop Up', '2'=>'Open in New Window'); 
                                                                $messageURL = '<small> 
                                                                <b>Link to Homepage</b> - / (slash symbol)<br />
                                                                <b>Link on TC Site</b> - /item/100144<br />
                                                                <b>Link to Pop Up on TC Site</b> - <span class="pointer" data-toggle="modal" data-target="#popOptionModal"><u> Popup options please click here </u></span> <br />
                                                                <b>External URL</b> - https://www.youtube.com
                                                                        
                                                                </small>';
                                                            
                                                            ?> 

                                                            <div class="alert alert-secondary" role="alert">  
                                                                <h6   > Add New Banner </h6> 
                                                                <hr>
                                                                <form name="addNewBanner" id="addNewBanner" class="addNewBanner"   ng-app="fileUpload" novalidate  >   
                                                                       
                                                                        <fieldset  >  
                                                                            <input type="hidden" class="form-check-input" id="formLocation" ng-model="bannerNewForm.ThemeIDUrl"/> 
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
                                                                                    <input type="submit" class="btn btn-danger btn-small text-center" style="width: auto;" value="Add Banner" ng-click="addNewBannerForm(picFile, ThemeLoops.themeID, customerName, customerNumber)" ng-disabled="!picFile"  >
                                                                                </div> 
                                                                            </div>    
                                                                        </fieldset> 
                                                                </form>
                                                            </div>

                                                            

                                                            <div class="row" ng-if="bannerSkinnedSiteForm">
                                                                <div class="col-md-12">
                                                                    
                                                                    <h4 class="margin-top">{{ThemeLoops.CompanyTag}} Banners </h4>     
                                                                    <form name="editBanner" id="editBanner" class="editBanner" ng-submit="editBannerForm(ThemeLoops.themeID)" novalidate  >    
                                                                            <fieldset  >    
                                                                            
                                                                            <p ><small><i>Note: please click the save button below after making your changes</i></small></p>

                                                                            
                                                                            <p><input type="submit" class="btn btn-danger btn-small " style="width: auto;" value="Save   Banner"   > </p>
                                                                                     
                                                                                
                                                                            <!-- start Public-->
                                                                            <div class="row margin-top " ui-sortable = "sortableOptions"  ng-model="bannerNewForm.bannerSkinnedSite" >  
                                                                                <div class="alert alert-secondary" id="bannerRemove{{publicForm.id}}" style="width:95%" ng-repeat="publicForm in  bannerNewForm.bannerSkinnedSite"  ng-class="publicForm.main == 1 ? 'row' : 'col-md-4' "  style="cursor:move; "   >  
                                                                                        
                                                                                        <div  ng-class="publicForm.main == 1 ? 'col-md-8' : 'col-md-12' " >  
                                                                                            <h2><i class="text-success fa  fa-check" ng-if="publicForm.active == '1' "></i> <i class="text-warning fa  fa-exclamation-triangle" ng-if="publicForm.active == '0' "></i></h2> 
                                                                                            <img src="../../Images/Banners/SkinnedSite/{{publicForm.location}}/{{publicForm.filename}}" class="img-fluid img-thumbnail" ng-style="{ 'height' : (publicForm.main == 0) ? '180px' : 'auto' }" />
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
                                                                                                <div class="col-md-3 text-right"> 
                                                                                                    <h4  ><span class="cursorpoint btn btn-danger" style="width: auto;"  ng-click="deleteBanner(publicForm.id, publicForm.location, publicForm.filename, ThemeLoops.themeID, customerName, customerNumber )" ><i class="fa fa-trash text-white"></i></span></h4>
                                                                                                </div>
                                                                                            </div>   



                                                                                        </div>
                                                                                </div>
                                                                            </div>    
                                                                            <!-- End Public--> 
                    



                                                                                <p><input type="submit" class="btn btn-danger btn-small " style="width: auto;" value="Save   Banner"   > </p>

                                                                            </fieldset> 
                                                                    </form>
                    
                                                                </div>
                                                            </div>








                                                                                                   

                                                </div>
                                            </div>
                                        </div>

                                        
                                    </div>  <!-- END accordion-->


                                    


                                    <!--<div class="alert alert-secondary skinned-section"> <b> Step 1: Basic Details </b> </div>  
                                    <div class="margin-top alert alert-secondary skinned-section"> <b>Step 2: Your Logo</b> </div>  
                                    <div class="margin-top alert alert-secondary skinned-section"> <b>Step 3: Pricing</b> </div> -->
                                    





                                    <!--<div class="floating-uploader save-btn-floating">-->
                                        <div class="row margin-top"> 
                                            <div class="col-md-12 text-left"> 
                                                <button type="submit" name="update" class="btn btn-danger btn-large"  >  <i class="fa  fa-save"></i> Save {{ThemeLoops.CompanyTag}} </button>  <span class="general-error" ng-if="generalError"> <i class="fa fa-times text-red"></i> {{generalError}} </span>
                                            </div>
                                        </div>  
                                    <!--</div>    -->

                                </fieldset>
                            </form>

                        </div>
                    </div>   
                </div>
      
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