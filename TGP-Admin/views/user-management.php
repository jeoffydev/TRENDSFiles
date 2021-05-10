

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
         
        <li class="breadcrumb-item active"><i class="fa fa-fw fa-users"></i> User Management</li>
      </ol>

         
      <!-- Icon Cards-->
     
            <p class="user-collapse-holder"><a class="btn bg-dark text-white  btn-link user-collape btn-100" data-toggle="collapse" href="#multiCollapseDistributor" role="button" aria-expanded="true" aria-controls="multiCollapseExample1">Distributor</a></p>
            <div class="row ng-cloak"  >
                <div class="col-md-12">
                    <div class="collapse show multi-collapse collapse-100" id="multiCollapseDistributor">
                        <div class="card card-body">
                            
                           <!-- user top search --> 
                           
                           <div id="imaginary_container"> 
                               <div class="row">
                                    <div class=" stylish-input-group col-md-4">
                                        <input type="text" class="form-control" id="edit-search"  placeholder="Apply Filter Ex. Tuapeka Gold Print" ng-model="query[queryBy]"   >
                                         
                                    </div>
                                    <!--<div class="col-md-2 text-right  "> 
                                        <span class="adjusttop">Include On Hold Accounts </span>  
                                         
                                    </div>-->
                                    <div class="col-md-6"> 
                                        <label for="userHoldAccounts" class="margin-top-light">
                                            <input id="userHoldAccounts" type ="checkbox" ng-model="userHoldAccounts" ng-click="checkIfOnHold(userHoldAccounts)" >  Include On Hold Accounts
                                        </label>
                                       <!-- <select class="form-control selectpicker col-md-3" ng-change="showOnhold(onHoldSelectOne)"    name="onHold"  data-ng-options="hold for hold in selectYesNoOption" data-ng-model="onHoldSelectOne"  > </select> -->
                                    </div>
                                </div>
                            </div> 

                            <table class="table table-striped table-hover table-heading"  >
                                            <tr>
                                                <th width="200">Customer Number</th>
                                                <th width="300">Customer Name</th>
                                                <th width="300"> On Hold </th>
                                                <!--<th>Themed Site Max</th>-->
                                                <th width="200">CSR</th>
                                            </tr>
                                            
                            </table>
                            <div class="main-itemTable extend" > 
                                        <table class="table table-striped table-hover "  >  
                                            <tr class="toptable{{customer.CustomerNumber}}Row toptableRowBG   cursorpoint"  ng-repeat="customer in customers | filter:query" ng-click="selectCustomerFirstNew(customer.CustomerNumber, customer.CustomerName, 'emailallOff')"     ng-show="customer.CustomerOnHold == ansWerX || customer.CustomerOnHold == ansWerY " >
                                                <td width="200"><span class="list-customer" data-id="{{customer.CustomerNumber}}" >{{customer.CustomerNumber}}</span></td>
                                                <td width="300"><span class="list-customer" data-id="{{customer.CustomerName}}"  >    {{customer.CustomerName}}</span></td>
                                                <td width="300"><span class="list-customer" data-id="{{customer.CustomerOnHold}}" >{{customer.CustomerOnHold}}</span></td> 
                                                <td width="200"><span class="list-customer" data-id="{{customer.CSR}}" >{{customer.CSR}}@tuapeka.co.nz</a></td>
                                            </tr>
                                        </table>
                                
                            </div>  
                           <!--User top search ends --> 

                            <!-- NEW ACCOUNT--> 
                            <?php $selectDefault = array('0' => 'No', '1'=>'Yes'); ?>
                            <div class="margin-top distributors-box" ng-if="listsAccnt" >
                                <div class="alert alert-secondary" role="alert">
                                    <strong>Settings for Customer {{customerNamedFirst}} - {{customerNumberedFirst}} </strong>
                                </div>
 
                                    <!--  Visual Access -->
                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <span ng-if="visualAccessCheck"><i class="fa text-success fa-check"></i></span> Access to Visuals:  
                                        </div>
                                        <div class="col-md-2">  
                                             
                                            <select class="form-control " name="VASelectOption"  ng-model="listsAccnt.visualAccess" > 
                                                <?php 
                                                    foreach ($selectDefault as $key => $value){
                                                        echo '<option value="'.$key.'"  ng-selected="listsAccnt.visualAccess === '.$key.'" >'.$value.'</option>';
                                                    }
                                                ?> 
                                            </select>
                                        </div>
                                        <div class="col-md-8"> <span ng-click="changeVisualNew(customerNumberedFirst, listsAccnt.visualAccess)" class="btn btn-small btn-danger"  >Save Visual</span> </div>
                                    </div>
                                    <!--  Visual Access -->
                                    
                                     <!--  Add user -->
                                     <div class="row margin-top-light">
                                        <div class="col-md-2 text-right">
                                                Add User:
                                        </div>
                                        <div class="col-md-10">
                                            <form name="addNewUser" id="addNewUser" ng-submit="addnewUserForm()" novalidate >  
                                                <div class="row"> 
                                                        <div class="col-md-4"> 
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-envelope"></i></span>
                                                                    </div>  
                                                                    <input type="email"   class="form-control" placeholder="Email Address" aria-label="EmailAddress" aria-describedby="basic-addon1" name="userEmail"    ng-model="formData.userEmail"  ng-pattern="eml_add" ng-required="true" autocomplete="off"  >
                                                                    
                                                                </div>
                                                                <span class="alert alert-warning display-block" ng-show="userExists"> {{userExists}}</span> 
                                                        
                                                        </div>  
                                                        <div class="col-md-2 text-left">  <button type="submit" name="update" class="btn btn-danger " ng-disabled="addNewUser.$invalid" >Add New User</button>  </div>
                                                        <div class="col-md-3">&nbsp;</div>  
                                                        <div class="col-md-3">&nbsp;</div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!--  Add user end -->

                            </div>        


                            <!-- NEW ACCOUNT--> 



                           <!-- Distributors extension-->
                            <div class="margin-top distributors-box" ng-if="listsOne" >
                                <div class="alert alert-secondary" role="alert">
                                    <strong>Settings for Customer {{customerNamedFirst}} - {{customerNumberedFirst}} </strong>
                                </div>
 
                                    <!--  Visual Access -->
                                    <div class="row">
                                        <div class="col-md-2 text-right">
                                            <span ng-if="visualAccessCheck"><i class="fa text-success fa-check"></i></span> Access to Visuals:  
                                        </div>
                                        <div class="col-md-2"> {{VASelectOption}}
                                            <select class="form-control selectpicker" ng-change="changeVisual(customerNumbered, VASelectOption)"  name="visualAccesses"  data-ng-options="visNew for visNew in selectYesNoOption" data-ng-model="VASelectOption"  > </select>
                                            
                                        </div>
                                        <div class="col-md-8">&nbsp;</div>
                                    </div>
                                    <!--  Visual Access -->


                                    <!--  Add user -->
                                    <div class="row margin-top-light">
                                        <div class="col-md-2 text-right">
                                                Add User:
                                        </div>
                                        <div class="col-md-10">
                                            <form name="addNewUser" id="addNewUser" ng-submit="addnewUserForm()" novalidate >  
                                                <div class="row"> 
                                                        <div class="col-md-4"> 
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-envelope"></i></span>
                                                                    </div>  
                                                                    <input type="email"   class="form-control" placeholder="Email Address" aria-label="EmailAddress" aria-describedby="basic-addon1" name="userEmail"    ng-model="formData.userEmail"  ng-pattern="eml_add" ng-required="true" autocomplete="off"  >
                                                                    
                                                                </div>
                                                                <span class="alert alert-warning display-block" ng-show="userExists"> {{userExists}}</span> 
                                                        
                                                        </div>  
                                                        <div class="col-md-2 text-left">  <button type="submit" name="update" class="btn btn-danger " ng-disabled="addNewUser.$invalid" >Add New User</button>  </div>
                                                        <div class="col-md-3">&nbsp;</div>  
                                                        <div class="col-md-3">&nbsp;</div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!--  Add user end -->
                                
                            </div>   
                            <!-- Distributors extension-->

                        </div>
                    </div>
                </div> 
            </div>

            <p  class="user-collapse-holder"><a class="btn bg-dark text-white   btn-link user-collape btn-100" data-toggle="collapse" href="#multiCollapseUser" role="button" aria-expanded="true" aria-controls="multiCollapseExample2">User</a></p>
      
              

            <div class="row">
                <div class="col-md-12">
                    <div class="collapse show multi-collapse collapse-100" id="multiCollapseUser">
                        <div class="card card-body">


                           <!-- Find all users-->
                           <div class="spreadthis" ng-if="userlistBox != null"></div>
                            <div class="all-user-box {{userlistBox}}">
                                <!--<div class="row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="find-user"  placeholder="Look for all email Ex. johnd@trends.nz" ng-model="queryUsers[queryByUsers]"  ng-change="lookForemail(queryUsers[queryByUsers])" >
                                    </div>
                                    <div class="col-md-8">
                                            
                                    </div>
                                </div>-->
                                <div class="row margin-top"> 
                                   <!-- <div class="col-md-2 text-left  "> 
                                        <span class="adjusttop">Include On Hold User Accounts </span>  
                                         
                                    </div>-->
                                    <div class="col-md-6"> 
                                                
                                        <label for="userHoldAccounts2" class="margin-top-light">
                                            <input id="userHoldAccounts2" type ="checkbox" ng-model="userHoldAccounts2" ng-click="checkIfOnHold2(userHoldAccounts2)" >  Include On Hold User Accounts
                                        </label>
                                        
                                       <!-- <select class="form-control selectpicker col-md-3" ng-change="showOnholdC(onHoldSelectThree)"    name="onHold"  data-ng-options="hold for hold in selectYesNoOption" data-ng-model="onHoldSelectThree"  > </select> -->
                                    </div>
                                </div>
                                <div class="row "   >
                                    <div class="col-md-12">
                                            
                                            <span ng-if="refreshing"  class="alert alert-warning"> User data is reloading...</span>    
                                            <table class="table table-striped table-hover table-heading"   >
                                                <tr>         
                                                              
                                                    <th width="300">Distributor Email <input type="text" class="form-control col-md-8" placeholder="Ex. johnd@trends.nz"  ng-model="searchuser.userEmail"  ng-change="activateAllSearch()"   ></th>
                                                    <th width="300">Primary Account <input type="text" class="form-control col-md-8" placeholder="Ex. Tuapeka Gold Print"  ng-model="searchuser.CustomerName" ng-change="activateAllSearch()"   ></th>
                                                    <th width="100">Move User</th>
                                                    <th width="100">Main Currency</th> 
                                                    <th width="100">On Hold  </th> 
                                                    <th width="150">CSR</th>  
                                                    <th width="50">Delete</th>  
                                                </tr>
                                            </table>    
                                             
                                            <div class="main-itemTable extend"  > 
                                                    <table class="table table-striped table-hover "     > 
                                                        <tr ng-repeat="listuser in usersLists  | filter:searchusers" class="tableRowBG tableRow{{listuser.userID}} "   > 
                                                            
                                                            <td width="300" class="cursorpoint" ng-click="selectThisUser(listuser.CustomerNumber, listuser.CustomerName, listuser.userID, listuser.userEmail, listuser.userType, listuser.multiCurrency, listuser.customSiteUser, listuser.skinnedWebsites, listuser.userHash, listuser.CustomerNumber, listuser.apiAcc)"> <span class="list-customer-res  cursorpoint" data-id="{{listuser.userID}}" ><span ng-if="listuser.userHash == ''"   > <i class="fa fa-exclamation-triangle text-red"></i> </span>  {{listuser.userEmail}} </td>
                                                            <td width="350">{{listuser.CustomerName}} - {{listuser.CustomerNumber}}</td>
                                                            <td width="100" class="text-left"><span class="list-customer-res cursorpoint" data-id="{{listuser.userID}}" ng-click="moveUser(listuser.userID, listuser.userEmail, listuser.CustomerNumber, listuser.CustomerName, listuser.CustomerNumber)"  >  <i class="fa fa-arrows"></i> </td>
                                                            <td width="120">{{listuser.Currency}}</td>
                                                            <td width="100">{{listuser.CustomerOnHold}}</td>
                                                            <td width="150">{{listuser.CSR}}</td>  
                                                            <td width="50" class="text-right" ><span class="list-customer-res cursorpoint" data-id="{{listuser.userID}}" ng-click="removeCustomer(listuser.userID, listuser.userEmail)" > <i class="fa fa-trash text-red"></i> </span></td> 
                                                        </tr>
                                                    </table>
                                            </div>  

                                        
                                    </div>
                                </div>
                            </div>
                            <!-- Find all users-->
                            
                           <!-- user section --> 

                            <div class="margin-top main-customersTable" ng-if="lists"   >  

                                

                                 <!--Reset Modal-->
                                <div class="resetDIV margin-top" id="resetpwModal"    >  
                                    <div class="row">
                                        <div class="col-md-1"><button  class="btn btn-danger "ng-click="resetpw(generateUserID, generateUserEmail, generateUserHash, generateCustomerNumbered, 1);"  >Reset Password  </button>  </div>
                                        <div class="col-md-9">
                                            <p><input type="text" id="copyUrl"   class="form-control" value="{{userdatas.finalResetUrl}}" ng-disabled="!userdatas.finalResetUrl" /> </p>
                                        </div>   
                                        <div class="col-md-2"> 
                                            <p><button class="btn"  ng-click="copyUrl(userdatas.finalResetUrl)" ng-disabled="!userdatas.finalResetUrl" > Copy </button></p>
                                        </div> 
                                    </div> 

                                </div>
                                <!--Reset Modal-->
                                
                                <!-- Main user Box -->
                                <div class="userBox"  >

                                        <div class="alert alert-secondary" role="alert" >
                                            <strong>Settings for user {{userEmail}}   </strong>
                                        </div>

                                        <!--user settings -->                 
                                        <div class="alert alert-light" role="alert"  > 
                                                <form name="editUserForm" id="editUserForm" ng-submit="editUserFormsSubmitted()" novalidate  >  
                                                    <div class="row mt-2">
														<div class="col-md-4">
															<label for="userType">User Type</label>
															<?php if($userAccnt == '10105'):   ?>
																<select class="form-control selectpicker"  name="userType"  data-ng-options="typ for typ in selectUserType" data-ng-model="formEditUser.selectYesNoFin" ng-disabled="!selectUserType"> </select>
															<?php else: ?>
																<select class="form-control selectpicker"  name="userType"  data-ng-options="typ for typ in selectUserType" data-ng-model="formEditUser.selectYesNoFin" ng-disabled="true"> </select>
															<?php endif; ?>
														</div>
														<div class="col-md-4">
															<label for="skinnedWebsites">Skinned Website User Manager Access</label>
															<select class="form-control selectpicker"  name="customWebsites"  data-ng-options="cus for cus in selectYesNo" data-ng-model="formEditUser.selectYesNoCustom" ng-disabled="!selectYesNo"> </select>
														</div>
														<div class="col-md-4">
															<label for="order">Order Dashboard Access</label>
															<select class="form-control selectpicker"  name="order"  data-ng-options="ord for ord in selectYesNo" data-ng-model="formEditUser.selectYesNoOrderDashboard"  > </select>
														</div>
													</div>
													<div class="row mt-3">
														<div class="col-md-4">
															<label for="brandStoreAccess">BrandStore Access</label>
															<select class="form-control selectpicker"  name="brandStoreAccess" ng-options="key as value for (key , value) in brandStoreAccess" data-ng-model="formEditUser.brandStoreAccess">
															</select>
														</div>
													</div>
													<div class="row mt-4" ng-if="usertype == 0">
														<div class="col-sm-12">
															<label for="UsersCMSAccess">User CMS Access</label>
														</div>
														<div class="col-sm-12 mt-2">
															<div class="row px-1">
																<label class="col-md-3" ng-repeat="fruitName in fruits" >
																	<input
																		class="usercheckbox"
																		type="checkbox"
																		name="selectedPagesAccess[]"
																		value="{{fruitName.pageNumber}}"
																		ng-checked="selectionAccess.indexOf(fruitName.pageNumber) > -1"
																		ng-click="toggleSelectionAccess(fruitName.pageNumber)"
																	>   {{fruitName.accessPage}}
																</label>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12">
															<button type="submit" name="editUserBtn"  class="btn btn-danger margin-top" ng-disabled="!selectYesNo"> Save Changes</button>
														</div>
                                                    </div>   
                                                    
                                                    <div  class="alert alert-warning" ng-show="errorMarkup">{{errorMarkup}}</div> 

                                                </form> 
                                        </div>
                                        <!--End user settings-->
                                        
                                        <!-- Secondary account -->  

                                         <p class="user-collapse-holder"><a class="btn bg-dark text-white  btn-link  btn-100" data-toggle="collapse" href="#multiCollapseSecondary" role="button" aria-expanded="true" aria-controls="multiCollapseSecondary1"><strong>Secondary accounts for user - {{userEmail}}   </strong></a></p>
                                                
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="collapse multi-collapse collapse-100" id="multiCollapseSecondary">
                                                    <div class="card card-body">   
                                                        
                                                    
                                                            <!--<div class="alert alert-secondary" role="alert">
                                                                <strong>Secondary accounts for user - {{userEmail}}   </strong>
                                                            </div> -->
                                                            <div id="imaginary_container"> 
                                                                <div class="row">
                                                                        <div class=" stylish-input-group col-md-4">
                                                                            <input type="text" class="form-control" id="edit-search"  placeholder="Search Secondary Account" ng-model="querySecond[queryBySecond]"    >
                                                                        </div> 

                                                                       <!-- <div class="col-md-2 text-right  "> 
                                                                            <span class="adjusttop">Include On Hold Accounts </span>  
                                                                            
                                                                        </div>-->

                                                                         <label for="userHoldAccounts3" class="margin-top-light">
                                                                            <input id="userHoldAccounts3" type ="checkbox" ng-model="userHoldAccounts3" ng-click="checkIfOnHold3(userHoldAccounts3)" >  Include On Hold  Accounts
                                                                        </label>
                                                                        <!--
                                                                        <div class="col-md-6"> 
                                                                            <select class="form-control selectpicker col-md-3" ng-change="showOnholdB(onHoldSelectTwo)"    name="onHold"  data-ng-options="holdtwo for holdtwo in selectYesNoOption" data-ng-model="onHoldSelectTwo"  > </select> 
                                                                        </div>-->



                                                                    </div>
                                                            </div> 
                                                            <table class="table table-striped table-hover table-heading"  >
                                                                <tr> 
                                                                    <th width="100">Account Number</th>
                                                                    <th width="400">Distributor&apos;s Name</th>
                                                                    <th width="100"> On Hold </th> 
                                                                    <th width="200">Currency</th>
                                                                    <th width="100">Add</th>
                                                                </tr>
                                                                
                                                            </table>
                                                            <div class="main-itemTable extendlow" > 
                                                                    <table class="table table-striped table-hover "  >
                                                                            
                                                                        <tr  ng-repeat="customer2 in customers | filter:querySecond" class="cursorpoint"    ng-show="customer2.CustomerOnHold == ansWerXB || customer2.CustomerOnHold == ansWerYB " >
                                                                            <td width="100"><span   data-id="{{customer2.CustomerNumber}}" >{{customer2.CustomerNumber}}</span></td>
                                                                            <td width="400"><span   data-id="{{customer2.CustomerName}}"  >    {{customer2.CustomerName}}</span></td>
                                                                            <td width="100"><span  data-id="{{customer2.CustomerOnHold}}" >{{customer2.CustomerOnHold}}</span></td>
                                                                            <td width="200"><span  data-id="{{customer2.Currency}}" >{{customer2.Currency}}</span></td>
                                                                            <!--<td><span class="list-customer" data-id="{{customer.ThemedSiteMax}}" >{{customer.ThemedSiteMax}}</span></td>-->
                                                                        <!-- <td width="200">
                                                                                <span data-id="" >  
                                                                                    <select class="form-control selectpicker"  name="secondCurrency"  ng-options="currenc.currencyName as currenc.currencyName  for currenc in currencyDatas"  ng-model="currencyDataModel"  > </select>
                                                                            
                                                                                </span>
                                                                            </td>-->
                                                                            <td width="100"><span class="cursorpoint"   data-id="" ng-click="addSecondaryAccount(customerNumbered, customerNamed, customer2.Currency, customer2.CustomerNumber, customer2.CustomerName, generateUserID, userEmail, generateUsertype, generateCurrency, generateCustom, generateSkinned, generateUserHash, customer2.CustomerNumber, generateApiAcc)"  > <i class="fa  fa-plus-circle font-15 text-success"></i> </a></td>
                                                                        </tr>
                                                                    </table>
                                                                
                                                            </div>  

                                                            <div class="alert alert-secondary margin-top" role="alert">
                                                                <strong>Existing Secondary Accounts   </strong>
                                                            </div> 
                    
                                                        

                                                            <table class="table"  >
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">Distributor Name</th>
                                                                            <th scope="col">Secondary Account</th>
                                                                            <th scope="col">Primary Account</th>
                                                                            <th scope="col">Currency</th>
                                                                            <th class="text-center" scope="col">Delete</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        
                                                                        <tr ng-repeat="secs in secondaryAccounts"  class="{{secs.id}}_DeleteSecondary"  > 
                                                                            <td>{{secs.secondaryAccountName}}</td>
                                                                            <td>{{secs.secondaryAccountID}}</td>
                                                                            <td>{{secs.primaryAccountID}}</td>
                                                                            <td>{{secs.secondaryCurrency}}</td>
                                                                            <td class="text-center"> 
                                                                                <span class="cursorpoint" ng-click="removeSecondaryAccount(secs.id, secs.userID, secs.userEmail, secs.secondaryCurrency, secs.secondaryAccountID, secs.secondaryAccountName, secs.primaryAccountID, customerNamed, generateUsertype, generateCurrency, generateCustom, generateSkinned, generateUserHash, secs.secondaryAccountID, generateApiAcc)"> <i class="fa fa-trash text-red"></i> </span>
                                                                            </td>
                                                                        </tr>
                                                                        
                                                                    </tbody>    

                                                            </table>    
                                                    </div>         
                                                </div> 
                                            </div> 
                                        </div> 
                                        <!-- Secondary account end -->



                                </div>
                                <!--End  Main user Box -->

                            </div> 
                            <!--User section ends -->  


                        </div>
                    </div>
                </div> 
            </div>






 


<!--Move Modal-->
<div class="modal fade" id="moveModal" tabindex="-1" role="dialog" aria-labelledby="moveModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="moveModalLabel">Move  {{userEmail}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
          
        <p><small>Current Customer Name and Number: </small><br /> {{customerNamedModal}} - {{customerNumberedModal}}  </p>

        
          <?php
                $customerDataNo = getCustomerDataNo($table); 
                //print_r($customerDataNo);
          ?>
        <form name="moveUserForm" id="moveUserForm" ng-submit="moveUserFormsSubmitted()" novalidate > 

            <select class="form-control selectpicker" name="CustomerNumber"  ng-model="formMove.CustomerNumber" ng-change="clearMessage()">  
                    <option value="">Move login to: </option>
                    <?php
                        foreach ($customerDataNo as $customersNo){
                            echo '<option value="'.$customersNo['CustomerNumber'].', '.$customersNo['CustomerName'].'"     >'.$customersNo['CustomerName'].' - '.$customersNo['CustomerNumber'].'</option>';  
                        } 
                    ?>
            </select>      
           <!-- <select ng-model="formMove.CustomerNumber" class="form-control">
                <option ng-repeat="selectCustomer in selectCustomers"   
                        ng-selected="selectCustomer.CustomerNumber === userCustNum"
                        value="{{selectCustomer.CustomerNumber}}">
                        {{selectCustomer.CustomerName}} - {{selectCustomer.CustomerNumber}}
                </option>
            </select> -->
            <div class="alert alert-warning" ng-show="formMoveMessage">{{formMoveMessage}}</div>
            <button type="submit" name="moveuserBtn" ng-disabled="!formMove.CustomerNumber" class="btn btn-danger margin-top" >Move User</button> 
        </form>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         
      </div>
    </div>
  </div>
</div>




<!--editUser Modal-->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUserModalLabel">Edit  {{userEmail}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
          
         
        <form name="editUserForm" id="editUserForm" ng-submit="editUserFormsSubmitted()" novalidate > 

            <div class="row">
                 <div class="col-md-6">
                    <label for="userType">User Type</label> 
                     <?php if($userAccnt == '10105'):   ?>   
                        <select class="form-control selectpicker"  name="userType"  data-ng-options="typ for typ in selectYesNo" data-ng-model="formEditUser.selectYesNoFin"> </select> 
                    <?php else: ?> YY
                        <select class="form-control selectpicker"  name="userType"  disabled="true"><option val="">--</option> </select> 
                    <?php endif; ?>
                 </div> 
                 <div class="col-md-6">
                    <label for="multiCurrency">Multi Currency</label>  
                    <select class="form-control selectpicker"  name="multiCurrency"  data-ng-options="multi for multi in selectYesNo" data-ng-model="formEditUser.selectYesNoCurrency"> </select>
                 </div>
            </div>  
            <div class="row">
                 <div class="col-md-6">
                    <label class="margin-top-light" for="skinnedWebsites">Skinned Website User Manager Access</label>  
                    <select class="form-control selectpicker"  name="customWebsites"  data-ng-options="cus for cus in selectYesNo" data-ng-model="formEditUser.selectYesNoCustom"> </select>
                 </div> 
                 <div class="col-md-6"> 
                    <label class="margin-top-light" for="customWebsites">Skinned Site Manager Access</label>   
                    <select class="form-control selectpicker"  name="skinnedWebsites"  data-ng-options="skin for skin in selectYesNo" data-ng-model="formEditUser.selectYesNoSkinned"> </select>
                 </div>
            </div>       
            
            <div class="row margin-top-light">
                <div class="col-md-4"> 
                    <label for="markup1">markup1</label>  
                    <input type="text" id="markup1"   class="form-control" name="markup1" ng-value="{{formEditUser.markup1}}" data-ng-model="formEditUser.markup1"  /> 
                    
                </div>
                <div class="col-md-4"> 
                    <label for="markup2">markup2</label>  
                    <input type="text" id="markup2"   class="form-control" name="markup2" ng-value="{{formEditUser.markup2}}" data-ng-model="formEditUser.markup2"  /> 
                </div>
                <div class="col-md-4"> 
                    <label for="markup3">markup3</label>  
                    <input type="text" id="markup3"   class="form-control" name="markup3" ng-value="{{formEditUser.markup3}}" data-ng-model="formEditUser.markup3"  /> 
                </div>
            </div>    
            <div class="row">
                <div class="col-md-4"> 
                    <label for="markup4">markup4</label>  
                    <input type="text" id="markup4"   class="form-control" name="markup4" ng-value="{{formEditUser.markup4}}" data-ng-model="formEditUser.markup4"  /> 
                    
                </div>
                <div class="col-md-4"> 
                    <label for="markup5">markup5</label>  
                    <input type="text" id="markup5"   class="form-control" name="markup5" ng-value="{{formEditUser.markup5}}" data-ng-model="formEditUser.markup5"  /> 
                </div>
                <div class="col-md-4"> 
                    <label for="setupMarkup">setupMarkup</label>  
                    <input type="text" id="setupMarkup"   class="form-control" name="setupMarkup" ng-value="{{formEditUser.setupMarkup}}" data-ng-model="formEditUser.setupMarkup"  /> 
                </div>
            </div>
           
            <div  class="alert alert-warning" ng-show="errorMarkup">{{errorMarkup}}</div>
            
            

            

            <button type="submit" name="editUserBtn"  class="btn btn-danger margin-top" >Edit User</button> 
        </form>
        
      </div>
      
    </div>
  </div>
</div>




<?php include('footer.php') ?>
