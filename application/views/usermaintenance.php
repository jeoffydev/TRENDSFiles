
<?php
	$this->load->view('header/header');
?> 
 

<div class="container">
	<div class="jumbotron" >
		<h2>User Maintenance</h2>
	</div>
</div>
 
<div class="container minheight page_<?=$angularFile ?>" style="min-height: 650px" >
	<div class="row">
		<div class="col-md-12 whitebackground " ng-cloak>

			
			<div id="imaginary_container margin-bottom " class="margin-top" > 
				<div  class="row">
					<div class="col-md-5">
						<div class="stylish-input-group ">
							<input type="text" class="form-control col-md-12" id="edit-search"  placeholder="Apply Filter Ex. Tuapeka Gold Print" ng-model="query[queryBy]"  data-toggle="tooltip" data-placement="right" title="Click below to select" >
							
						</div>
					</div>
					<div class="col-md-6">
						<div class="stylish-input-group ">
							<label for="userHoldAccount" class="margin-top-light">
								<input id="userHoldAccount" type ="checkbox" ng-model="userHoldAccount" ng-click="showOnhold(userHoldAccount)" >  Include On Hold Accounts
							</label>
							
						</div>
					</div>

				</div>	

                  
            </div> 
           
                <div class="main-itemTable userMaintenance-table extend margin-top"   ng-init="showOnhold(false)"> 
						<table class="table  table-hover "  >
							<thead class="thead-dark">
                                <tr>
                                    <th>Customer Number</th>
                                    <th>Customer Name</th>
                                    <th>   On Hold </th>
                                    <!--<th>Themed Site Max</th>-->
                                    <th>CSR</th>
								</tr>
							</thead>	
                                <!-- <tr  ng-repeat="customer in customers | filter:query" ng-click="selectCustomer(customer.CustomerNumber, customer.CustomerName)" ng-class="{'value-no':  customer.CustomerOnHold == 'No'}"  ng-show="customer.CustomerOnHold == ansWer" >-->
                                <tr class="cursorpoint" ng-repeat="customer in customers | filter:query" ng-click="selectCustomer(customer.CustomerNumber, customer.CustomerName)"  ng-show="customer.CustomerOnHold != ansWer "    >
                                    <td><span class="list-customer" data-id="{{customer.CustomerNumber}}" >{{customer.CustomerNumber}}</span></td>
                                    <td ><span class="list-customer" data-id="{{customer.CustomerName}}"  >    {{customer.CustomerName}}</span></td>
                                    <td><span class="list-customer" data-id="{{customer.CustomerOnHold}}" ng-if="customer.CustomerOnHold == 'N' " >No</span> <span class="list-customer" data-id="{{customer.CustomerOnHold}}" ng-if="customer.CustomerOnHold == 'Y' " >Yes</span></td>
                                    <!--<td><span class="list-customer" data-id="{{customer.ThemedSiteMax}}" >{{customer.ThemedSiteMax}}</span></td>-->
                                    <td><span class="list-customer" data-id="{{customer.CSR}}" >{{customer.CSR}}@tuapeka.co.nz</a></td>
                                </tr>
                            </table>
                    
				</div>




				<!-- Left and right --> 

				<div class="margin-top main-customersTable" ng-if="lists" ng-cloak >

					<form name="addNewUser" id="addNewUser" ng-submit="addnewUserForm()" novalidate >  
					<div class="row ">

						<div class="col-md-4">
							
							
								<div class="input-group mb-3 margin-top">
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="fa fa-envelope"></i></span>
									</div>  
									<input type="email"   class="form-control" placeholder="Email Address" aria-label="EmailAddress" aria-describedby="basic-addon1" name="userEmail"    ng-model="formData.userEmail"  ng-pattern="eml_add" ng-required="true" autocomplete="off"  >
									
								</div>
								<span class="alert alert-warning display-block" ng-show="userExists"> {{userExists}}</span>
								
						
						</div>  
						<div class="col-md-2 text-left">  <button type="submit" name="update" class="btn btn-danger margin-top" ng-disabled="addNewUser.$invalid" >Add New User</button>  </div>
						<div class="col-md-3">&nbsp;</div>  
						<div class="col-md-3">&nbsp;</div>
					</div>
					</form>

					<div class="row margin-top">
                        <div class="col-md-12"><p class="alert alert-secondary">  <i class="fa fa-lock"></i> Existing users of   {{customerNamed}} - {{customerNumbered}}  </p></div>
                    </div>
					<div class="row  ">
						<div class="col-md-4">

								 
								<div class="second-customersTable"   >
									<table class="table table-striped table-hover "   >
											<tr>
												<!--<th>User Account</th>-->
												<th>User Email</th>
												<!--<th>User Type</th> 
												<th>MultiCurrency</th> 
												<th>Reset PW</th>  
												<th>Move User</th>  -->
												<!--<th>Edit</th> -->
												<th>&nbsp;</th> 
											</tr>
											<tr ng-repeat="list in lists">
												<!--<td><span class="list-customer-res" data-id="{{list.userID}}" >{{list.userID}}</span></td>-->
												<td><span class="list-customer-res  cursorpoint" data-id="{{list.userID}}" ng-click="editUser(list.userID, list.userEmail, list.userType, list.multiCurrency, list.customSiteUser, list.skinnedWebsites, list.userHash, customerNumbered, list.apiAcc)" ><span ng-if="list.userHash == ''"   > <i class="fa fa-exclamation-triangle text-red"></i> </span> {{list.userEmail}}</span></td>
												<!--<td><span class="list-customer-res" data-id="{{list.userID}}" >{{list.userType}}</span></td> 
												<td><span class="list-customer-res" data-id="{{list.userID}}" >{{list.multiCurrency}}</span></td> 
												<td class="text-center"><span class="list-customer-res cursorpoint" data-id="{{list.userID}}"  ng-click="resetpw(list.userID, list.userEmail, list.userHash, customerNumbered)" >   <i class="fa  fa-window-restore"></i> </span></td> 
												<td class="text-center"><span class="list-customer-res cursorpoint" data-id="{{list.userID}}" ng-click="moveUser(list.userID, list.userEmail, customerNumbered)"  >  <i class="fa fa-arrows"></i> </td> -->
												<!--<td class="text-center"><span class="list-customer-res cursorpoint" data-id="{{list.userID}}" ng-click="editUser(list.userID, list.userEmail, list.userType, list.multiCurrency, list.customSiteUser, list.skinnedWebsites)"  >  <i class="fa fa-pencil"></i> </td>-->
												<td class="text-right" ><span class="list-customer-res cursorpoint" data-id="{{list.userID}}" ng-click="removeCustomer(list.userID, list.userEmail)" > <i class="fa fa-trash text-red"></i> </span></td> 
										
										
											</tr>
									</table>
								</div>  
								<p> Note: <i class="fa fa-exclamation-triangle text-red"></i> this needs to reset the password.</p>


						</div>
						<div class="col-md-8">

						
								<!-- Edit user -->  
								<div class="" id="editUserModal"  >
									
									<!--<p class="alert alert-secondary"><i class="fa fa-edit"></i> User  {{userEmail}}</p> -->
										<!--<form name="editUserForm" id="editUserForm" ng-submit="editUserFormsSubmitted()" novalidate > 

									<div class="row">
											 
											<div class="col-md-7">
												<label for="multiCurrency">Multi Currency</label>  
												<select class="form-control selectpicker"  name="multiCurrency"  data-ng-options="multi for multi in selectYesNo" data-ng-model="formEditUser.selectYesNoCurrency" ng-disabled="!selectYesNo"> </select>
											</div>
										 

										</div>  
										<!--
										<div class="row">
											<div class="col-md-6">
												<label class="margin-top-light" for="skinnedWebsites">Skinned Website User Manager Access</label>  
												<select class="form-control selectpicker"  name="customWebsites"  data-ng-options="cus for cus in selectYesNo" data-ng-model="formEditUser.selectYesNoCustom" ng-disabled="!selectYesNo"> </select>
											</div> 

											<div class="col-md-6"> 
												 
												<label class="margin-top-light" for="skinnedWebsites">Visual Access for {{customerNamed}}</label>  
												<select class="form-control selectpicker"  name="customWebsites"  data-ng-options="vis for vis in selectYesNo" data-ng-model="formEditUser.selectYesNoVisualAccess" ng-disabled="!selectYesNo"> </select>
											</div>
											
										</div> -->
										 
										
										 
										<!--<div class="row margin-top" ng-if="usertype == 0" >
											<div class="col-md-3" ng-repeat="access in   formEditUser.selectAccessPages">
												{{access.accessPage}}
											</div>
										</div>-->
									
										<!--<div  class="alert alert-warning" ng-show="errorMarkup">{{errorMarkup}}</div> 
										<button type="submit" name="editUserBtn"  class="btn btn-danger margin-top" ng-disabled="!selectYesNo"> Save Changes</button> 
									</form>-->
								
							</div>
						<!-- Edit user -->

								<!--Reset Modal-->
								<div class="resetDIV margin-top" id="resetpwModal"   >
								
									<p class="alert alert-secondary link cursorpoint" ng-click="resetpw(generateUserID, generateUserEmail, generateUserHash, generateCustomerNumbered, 1);" ng-show="userEmail"><u> <i class="fa fa-unlock"></i>  Reset password for  {{userEmail}} </u></p>
											
									<p><input type="text" id="copyUrl"   class="form-control" value="{{userdatas.finalResetUrl}}" ng-disabled="!userdatas.finalResetUrl" /> </p>
									<p><button class="btn"  ng-click="copyUrl(userdatas.finalResetUrl)" ng-disabled="!userdatas.finalResetUrl" > Copy </button></p>
									
								</div>
								<!--Reset Modal-->






							
							
						</div> 
					</div>   

					</div>
					<p>&nbsp; </p>


					<!-- Left and right -->
				

				


		</div> 
	</div>

				





</div>



<?php
	$this->load->view('footer/footer');
?> 