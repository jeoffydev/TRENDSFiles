
<?php
	$this->load->view('header/header');
?> 
 

<div class="container">
	<div class="jumbotron" >
		<h2>Skinned User</h2>
	</div>
</div>

<div class="container page_<?=$angularFile ?>">
	<div class="row">
		<div class="col-md-12 whitebackground">


			<?php if($siteLogcheck['userDatas'][0]->userType == 0): ?>
                <div id="imaginary_container margin-bottom " class="margin-top"> 
                    <div class="stylish-input-group ">
                        <input type="text" class="form-control col-md-4" id="edit-search"  placeholder="Apply Filter Ex. Tuapeka Gold Print" ng-model="query[queryBy]"  data-toggle="tooltip" data-placement="right" title="Click below to select" >
                         
                    </div>
                  
                </div> 
           
                <div class="main-itemTable extend margin-top" ng-cloak > 
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
			<?php endif; ?>

			<?php if($siteLogcheck['userDatas'][0]->userType == 1): ?>
				<span ng-init="selectCustomer('<?=$CustomerNumber?>','<?=$CustomerName?>')"></span>	
			<?php endif; ?>
			<div class="margin-top margin-bottom main-customersTable" ng-if="lists" ng-cloak > 
                      
                 

					  	<div class="row "> 
							<div class="col-md-4">
									
									<p class="alert alert-secondary"> Existing theme of   <strong>{{customerName}} - {{customerNumber}}</strong>  </p> 
									<div class="second-customersTable">
										<table class="table table-striped table-hover "   >
												<tr>  
													<th>Theme ID</th> 
													<th>Company Name</th>   
												</tr>
												<tr ng-repeat="list in lists" ng-click="selectTheme(customerNumber, list.themeID, list.CompanyTag, list.Domain)" id="{{list.themeID}}" class="themeTables"> 
													<td ><span class="list-customer-res cursorpoint" data-id="{{list.themeID}}"   >  {{list.themeID}}</span> </td>  
													<td  ><span class="list-customer-res cursorpoint" data-id="{{list.CompanyTag}}"   > {{list.CompanyTag}} <span ng-if="list.Domain" > - {{list.Domain}}</span> </span>  </td> 
												</tr>
										</table>        
									</div>
							</div>        
							<div class="col-md-8 formskinneduser">

								<!-- FORM --> 
									<h6 class="alert alert-secondary"  ><strong>Add skinned site user   </strong> </h6>
									<form name="addNewUser" id="addNewUser" class="addNewUserForm" ng-submit="addNewUserForm(selectedThemeIDValid, customerNumberValid)" novalidate  >    
										<fieldset ng-disabled="formDisabled">   
											<input type="hidden" name="customerNumber" id="customerNumber"  ng-model="selectedThemeIDValid" class="form-control" >
											<input type="hidden" name="siteid" id="siteid" ng-model="customerNumberValid" > 
											<input type="hidden" name="mainCompany" id="mainCompany" ng-model="companyTagNameLabel"  > 
											<input type="hidden" name="customerName" id="customerName" ng-model="customerName"  > 
											<div class="row ">  
												<div class="col-md-3">
													<label class="sr-only" for="skinnedInputName">Full Name</label>
													<input type="text" name="fullname" class="form-control" id="skinnedInputFullName" ng-model="formData.skinnedName" placeholder="Full Name (Optional)" >
												</div>
												<div class="col-md-3">
													<label class="sr-only" for="skinnedInputEmail">Email address</label>
													<input type="email" name="email" class="form-control" id="skinnedInputEmail" ng-change="validateThisEmail(formData.skinnedEmail, selectedThemeIDValid, customerNumberValid)" ng-model="formData.skinnedEmail" placeholder="Email Address" required=""  >
													
													<div class="CodeReq text-red labelreq reqfield" ng-show="emailValidateBtnMsg"> {{emailValidateBtnMsg}}</div>
												</div>
												<div class="col-md-3">
													<label class="sr-only" for="skinnedInputCompany">Company</label>
													<input type="text" name="company" id="skinnedInputCompany" class="form-control" ng-model="formData.skinnedCompany" placeholder="Company Name"  >
												</div>
												<div class="col-md-3">
													<input type="submit" class="btn btn-danger btn-small" value="Add User" ng-disabled="emailValidateBtn"  >
												</div>
												
											
											</div>
										</fieldset>    
									</form>
								<!--FORM-->

								<!-- USER details--> 
									<div class="row margin-top">
										<div class="col-md-12"> 
											<p class="alert alert-secondary" ng-if="usersExist == '1'"> <strong> Skinned site users of  {{companyTagNameLabel}}</strong>  | View theme URL <a ng-if="themeUrl" href="{{themeUrl}}" target="_blank"> <i class="fa  fa-external-link text-red font-size-18"></i> </a>   </p> 
											<p class="alert alert-secondary" ng-if="!usersExist"> <strong> 0 user </strong>  </p>
											
											<div class="skinuser-box table-responsive" ng-if="usersExist"> 
												<table class="table">
													<thead class="thead-dark">
														<tr>
															<th scope="col"><i class="fa fa-lock"></i></th>
															<th scope="col">Name</th>
															<th scope="col">Company</th>
															<th scope="col">Email</th>
															<th scope="col">View/Reset URL</th>
															<th scope="col">Delete</th>
														</tr>
													</thead>
													<tbody>
														<tr ng-repeat="userList in userLists" >
															<td> <i class="fa fa-check" aria-hidden="true" ng-if="userList.skinnedUserPassword" ></i>   <i class="fa fa-exclamation-circle text-red" ng-if="!userList.skinnedUserPassword" title="Password needs to be reset"  ></i> </td>
															<td>{{userList.skinnedUserName}}</td>
															<td>{{userList.skinnedUserCompany}}</td>
															<td>{{userList.skinnedUserEmail}}</td>
															<td> <span class="cursorpoint margin-right"  ng-if="userList.skinnedUserPassword == null || userList.skinnedUserPassword == '' "  title="View and Copy Reset URL" ng-click="viewResetPW(userList.skinnedUserID, userList.skinnedUserEmail, 1)" > <i class="fa fa-eye"></i>  &nbsp; |    </span> <span class="cursorpoint margin-right"     ng-click="resetPW(userList.skinnedUserID, userList.skinnedUserEmail, 2)" title="Force to Reset Password" >  Reset Password </span>    </td>
															<td>   <span class="cursorpoint text-red" ng-click="deleteSkinUser(userList.skinnedUserID, customerNumberValid, customerName, companyTagNameLabel)" > <i class="fa fa-trash-o" aria-hidden="true"  ></i>  </span>  </td>
														</tr>
														
													</tbody>
												</table> 
											</div>


										</div>    
									</div>   
								<!-- Uder details--> 
					

							</div>
						</div>  


			</div> <!-- end main-customersTable -->


			<div class="modal fade" id="resetModal" tabindex="-1" role="dialog" aria-labelledby="resetModalLabel" aria-hidden="true" >
				<div class="modal-dialog" role="document">
					<div class="modal-content"> 
						<div class="modal-header"> 
							<h5 class="modal-title">Reset password for {{headingModal}} </h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body text-left"> 
							
								
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text cursorpoint" id="basic-addon1" ng-click="copyUrl(generateSkinReset)" title="Copy URL" ><i class="fa fa-link"></i></span>
									</div>
									<input type="text" class="form-control" id="copyUrl" value="{{generateSkinReset}}">
								</div>
								<button class="btn" ng-click="copyUrl(generateSkinReset)" > Copy </button> 

						</div> 
						<div class="modal-footer">
							<span class="btn btn-danger btn-small" ng-click="resetPW(skinnedUserIDModal, headingModal, 2)" >Generate new  URL </span>
							<button type="button" class="btn btn-secondary btn-small" data-dismiss="modal" ng-click="refresh()">Close</button> 
						</div>
					</div>
				</div>
			</div>



		</div>
	</div>
</div>



<?php
	$this->load->view('footer/footer');
?> 