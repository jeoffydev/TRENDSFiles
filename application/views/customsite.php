
<?php
	$this->load->view('header/header');
?> 
 

<div class="container">
	<div class="jumbotron" >
		<h2>Custom Site</h2>
	</div>
</div>

<div class="container page_<?=$angularFile ?>">
	<div class="row">
		<div class="col-md-12">


	<div class="accordion" id="accordionCustomsite">
		<div class="card">
			<div class="card-header" id="headingInfo">
			<h5 class="mb-0">
				<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseInfo" aria-expanded="false" aria-controls="collapseInfo">
					Skinned Website Information
				</button>
			</h5>
			</div>

			<div id="collapseInfo" class="collapse" aria-labelledby="headingInfo" data-parent="#accordionCustomsite">
			<div class="card-body">
					
			
							<h5>What is a Skinned Website?</h5>
							<p>A skinned website allows you to take your business online in the easiest manner possible!  Our simple management tool lets you take the generic TRENDS website, rebrand, customise,  and publish it as your own. You can  use the site under your own domain e.g. <strong>www.promotionalcompany.com</strong> or use our generic URL e.g. <strong>www.trends.nz/ID12345</strong> should you prefer. </p>
							
							<h5>How can I customise my site?</h5>
							<p>Scroll down to start customising your site via our interactive control panel. Busy? No stress &#8211; we can do it for you! Just email us your hi res logo and mark ups and we will send back a link to your new website. </p>
							
							
							<h5>What can be customised?</h5>
							
								<ul>
									<li>Upload your own logo</li>
									<li>Add a phone number into the header</li>
									<li>Colour Scheme</li>
									<li>Pricing  (optional)
										<ul>
											<li>Choose different mark ups for branding costs, setup costs and each quantity break</li>
											<li>Customise the pricing additional information, MOQ fee and split delivery charge</li>
										</ul>
									</li>
									<li>About Us information</li>
									<li>Contact Us information including paragraph text, email address for enquiries and optionally, social media information, physical address, phone number and skype name</li>
								</ul>
							
							
							
							<h5>Search Engine Optimisation (SEO)</h5>
							<p>Most features added into <strong>www.trends.nz</strong> to improve the SEO, will also directly improve your skinned sites ranking. Here are some ideas for ways you can improve your skinned sites ranking:</p>
								<ul>
									<li>Company Name &#8211; this field is used to customise the Title text in Web Browser tabs. Make sure it includes any key words relevant to your company name. For example, instead of shortening your company name to &lsquo;Promoline&rsquo; you could consider using &lsquo;Promoline Promotional Merchandise Solutions&rsquo;</li>
									<li>Keywords &#8211; integrate key words about your service offering into your About Us and Contact Us text</li>
									<li>Links &#8211; create as many links to your skinned site as possible &#8211; from social media, blog posts and other websites</li>
								</ul>
							
							<h5>What’s next?</h5> 
							<p>Soon you will be able to upload your own web banners &#8211; we can even help you with the design!
								<br />Additional features in the pipeline include:</p>
							<ul>
								<li>An enquiry cart allowing a user to submit an enquiry for multiple products</li>
								<li>Login ability for your customers</li>
							</ul>
							
							
							<h5>Support</h5>
							<p>We are here to help you create your site &#8211; please contact <a href="mailto:support@trends.nz">support@trends.nz</a></strong> for assistance.</p>
							



			</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header" id="headingSelectTheme">
			<h5 class="mb-0">
				<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSelectTheme" aria-expanded="true" aria-controls="collapseSelectTheme">
					<?php if($siteLogcheck['userDatas'][0]->userType == 0): ?>Manage A Custom Website <?php else: ?> Manage Your Custom Website <?php endif; ?>
				</button>
			</h5>
			</div>
			<div id="collapseSelectTheme" class="collapse  show" aria-labelledby="headingSelectTheme" data-parent="#accordionCustomsite">
			<div class="card-body">

			<?php if($siteLogcheck['userDatas'][0]->userType == 0): ?> 
					<p>Please note that this page is only for customers access. If you're an admin, please <a href="<?=base_url()?>TGP-Admin/skinned-website" target="_blank">click here</a> to manage a custom website</p>
			<?php endif; ?>
					
			<?php if($siteLogcheck['userDatas'][0]->userType == 1): ?>
					
					<!--<span ng-init="readyTheme()"></span>-->	
					<span ng-init="selectCustomer('<?=$CustomerNumber?>','<?=$CustomerName?>', '<?=$themeMax?>')"></span>	
					<div class=" margin-bottom main-customersTable" ng-if="lists"  >  
								
								<form name="addNewTheme" id="addNewTheme" ng-submit="addnewThemeForm()" novalidate  ng-if="disabledThemeAddField">     
									<div class="row "> 
										<div class="col-md-4"> 
													<div class="input-group mb-3 margin-top">
														
														<input type="text"   class="form-control" placeholder="Skinned site name" aria-label="newTheme" aria-describedby="basic-addon1" name="newtheme"    ng-model="formData.newTheme"  ng-pattern="eml_add" ng-required="true" autocomplete="off"  >
														
													</div>  
										</div>  
										<div class="col-md-2 text-left">  <button type="submit" name="update" class="btn btn-danger margin-top" ng-disabled="!formData.newTheme" >Add New Theme</button>  </div>
										<div class="col-md-3">&nbsp;</div>  
										<div class="col-md-3">&nbsp;</div>
									</div>
								</form>

							<div class="row " ng-cloak > 
									<div class="col-md-4">
											
											<p class="alert alert-secondary">  <strong>{{customerName}} - {{customerNumber}}</strong> <span ng-if="displayThemelimit" > / <strong>{{displayListCount}} of {{displayThemelimit}}</strong> used </span>  </p> 
											<div class="second-customersTable">
												
												<table class="table table-striped table-hover "   >
														<tr> 
															
															<th>Theme ID</th> 
															<th>Company Name</th>   
															<th>&nbsp;</th> 
														</tr>
														<tr ng-repeat="list in lists" id="{{list.themeID}}" class="themeTables"> 
															<td ng-click="selectTheme(list.themeID)"  ><span class="list-customer-res cursorpoint" data-id="{{list.themeID}}"   >  {{list.themeID}}</span> </td>  
															<td ng-click="selectTheme(list.themeID)"  ><span class="list-customer-res cursorpoint" data-id="{{list.CompanyTag}}"   > {{list.CompanyTag}} </span></td> 
															<td  ><span class="list-customer-res cursorpoint"  ng-click="deleteTheme(list.CustomerNumber, list.themeID, customerName)" > <i class="fa fa-trash text-red"></i>  </span></td>  
														</tr>
												</table>        
											</div>
									</div>        
									<div class="col-md-8">


										<!-- start FORM-->

		
									
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
																			<input   class="form-control" type="text"  ng-value="ThemeLoops.Domain" ng-model="ThemeLoops.Domain"  readonly >
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
																			<span class="padding-top"> Enquiry Email Address:  </span>
																		</div>
																		<div class="col-md-7"> 
																			<input class="form-control" type="text"  ng-value="ThemeLoops.Email" ng-model="ThemeLoops.Email"  >
																			<div   class="CodeReq text-red labelreq reqfield" ng-show="EmailError">{{EmailError}}</div>
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
																			<div   text-angular  class="text-editor-format" ng-paste="pasteAboutCheck($event)" ng-model="ThemeLoops.AboutUsTextEditor" ta-toolbar="[['h1','h2','h3','h4'],['bold','italics','underline','ul'],['justifyLeft', 'justifyCenter', 'justifyRight'],['html','insertLink']]" name="about-editor" ta-text-editor-class="clearfix border-around container " ></div>
																		</div>
																	</div> 

																	<div class="row margin-top-light" ng-if="!formDisabled"> 
																		<div class="col-md-3 text-right">  
																			<span class="padding-top"> Contact Us Text: </span>
																		</div>
																		<div class="col-md-7 " >  
																			<div text-angular class="text-editor-format" ng-paste="pasteContactCheck($event)"   ng-model="ThemeLoops.ContactUsTextEditor" ta-toolbar="[['h1','h2','h3','h4'],['bold','italics','underline','ul'],['justifyLeft', 'justifyCenter', 'justifyRight'],['html','insertLink']]" name="contact-editor" ta-text-editor-class="clearfix border-around container " ta-html-editor-class="border-around"></div>
																					
																		</div>
																	</div> 

																	
																	<div class="row margin-top-light" ng-if="!formDisabled"> 
																		<div class="col-md-3 text-right">  
																			<span class="padding-top"> Terms & Conditions: </span>
																		</div>
																		<div class="col-md-7 " >  
																			<div text-angular class="text-editor-format" ng-paste="pasteTermsCheck($event)" ng-model="ThemeLoops.termsConditionTextEditor" ta-toolbar="[['h1','h2','h3','h4'],['bold','italics','underline','ul'],['justifyLeft', 'justifyCenter', 'justifyRight'],['html','insertLink']]" name="terms-editor" ta-text-editor-class="clearfix border-around container " ta-html-editor-class="border-around"></div>
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
																				<div class="table-responsive">
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
																				 .miniTopMenu:hover, .miniBottomMenu:hover  {
																					color: #{{ThemeLoops.headerTextColour}} !important; 
																					background-color: #{{ThemeLoops.headerBackground}};    
																				} 
																				.miniTopMenuSep {
																					padding:0px 5px 0px 5px !important;
																				    color: #{{ThemeLoops.headerTrimColour}}; 
																					
																				}
																				.searchBoxMini {
																					float:right;
																					width:40% !important;
																					border-radius:2px;
																					font-size:9px; 
																					margin-top:9px;
																					margin-bottom:7px;
																					margin-right:10px;
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
																				.miniTabInactive {
																					padding:2px 5px; 
																					width:auto;
																					float:left;
																					background-color:#{{ThemeLoops.tabColour}}; 
																					border-color:#{{ThemeLoops.tabColour}}; 
																					color: #{{ThemeLoops.tabTextColour}}; 
																					
																					
																				}
																				.miniTabActive { 
																					padding:2px 5px; 
																					width:auto;
																					float:left;
																					color: #{{ThemeLoops.tabSelectedText}}; 
																					background-color:#{{ThemeLoops.tabSelectedColour}}; 
																					border-color:#{{ThemeLoops.tabSelectedColour}}; 
																				}
																				.miniTabInactive:hover {
																					/* color: #{{ThemeLoops.tabTextColourHover}}; */
																				}
																				.datagridTiny { 
																					clear:both;
																					 border: 1px solid #9a9b9c;  
																					
																				}
																				.datagridTiny table thead th {
																					background-color: #{{ThemeLoops.tableHeaderColour}};
																					color: #{{ThemeLoops.tableHeaderTextColour}};  
																				}
																				.datagridTiny table tbody td {
																					color: #{{ThemeLoops.tableCellTextColour}}; 
																					background-color: #{{ThemeLoops.tableCellColour}}; 
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
																				.miniTopMenu{
																					width:auto;
																					float:left;
																					font-size:9px !important;
																				}
																				.miniTopMenuSep{
																					float:left;
																				}
																				.backgroundOne{
																					float: left;
																					width:100%;
																					background-color: #{{ThemeLoops.headerTrimColour}};
																				}
																				.themeconfig-menu{
																					 
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
																				.searchBoxMini{
																					border: 1px solid #{{ThemeLoops.searchBoxTextColour}};
																				}
																				.searchBoxMini:hover{
																					border:1px solid #{{ThemeLoops.textHighlightColour}};
																				}
																				.pixBox {
																					box-shadow: 0px 2px 3px  rgba(0, 0, 0, 0.5);
																					margin-left: 5px;
																					margin-top: 4px;
																					width: 95%;
																					min-height: 140px;
																					background: white;
																					border-radius: 0px;
																					cursor: default;
																				}
																				.pixBoxLittle {
																					box-shadow: 0px 2px 3px  rgba(0, 0, 0, 0.5);
																					margin-left: 3px;
																					margin-top: 4px;
																					width: 15.4%;
																					height: 25px;
																					background: white;
																					border-radius: 0px;
																					display: inline-block;
																					cursor: default;
																				}
																				
					
																				
																		</style> 

																		<?php 
																			$themeHeader = '<div id="ThemeMenuBG" class="miniMenu" style="width:90%;margin-left:auto; margin-right:auto; background-color: #{{ThemeLoops.headerBackground}}">
																			<div style="width:100%; background:#0a0a0a;">
																				<div id="ThemeTopMenuMain" style="width:100%;font-size:10px; font-family:Open Sans, sans-serif; background-color: #{{ThemeLoops.headerBackground}}">
																					<div class="backgroundOne">
																						<a href="#" class="miniTopMenu" style="margin-left:2%; color: #{{ThemeLoops.menuHighlightColour}}">TOP MENU</a>
																						<div class="miniTopMenuSep" >|</div>
																						<a href="#" class="miniTopMenu" style="color: #{{ThemeLoops.menuHighlightColour}}" >TOP MENU</a>
																						<div class="miniTopMenuSep">|</div>
																						<a href="#" class="miniTopMenu" style="color: #{{ThemeLoops.menuHighlightColour}}">TOP MENU</a>
																						<div class="miniTopMenuSep">|</div>
																						<a href="#" class="miniTopMenu" style="color: #{{ThemeLoops.menuHighlightColour}}">TOP MENU</a>
																						<div class="miniTopMenuSep">|</div>
																						<a href="#" class="miniTopMenu" style="color: #{{ThemeLoops.menuHighlightColour}}">TOP MENU</a>
																						<div class="miniTopMenuSep">|</div>
																						<a href="#" class="miniTopMenu" style="color: #{{ThemeLoops.menuHighlightColour}}">TOP MENU</a>
																						<div class="miniTopMenuSep">|</div>
																						<a href="#" class="miniTopMenu" style="color: #{{ThemeLoops.menuHighlightColour}}">TOP MENU</a>
																						<div class="miniTopMenuSep">|</div>
																						<a href="#" class="miniTopMenu" style="color: #{{ThemeLoops.menuHighlightColour}}">TOP MENU</a>
																					</div>	
																				</div>
																			</div>
																			<span class="menuImg">
																				<img src="{{LogoLink}}" ng-if="LogoLink"  height="40px" />
																				<span ng-if="!LogoLink" class="margin-top-light">   <i class="fa fa-image font-size-18"></i> </span>
																			</span>
																			<div id="ThemeSearch" class="searchBoxMini"><em>Search products, categories and colours</em></div>
																			<div style="clear:both"></div>
																			<div class="themeconfig-menu" style="width:100%;font-size:10px;color:#ffffff;font-family:Open Sans, sans-serif;">
																				<a href="#" class="miniBottomMenu" style="margin-left:5%;  ">MENU</a>
																				<a href="#" class="miniBottomMenu"   >MENU</a>
																				<a href="#" class="miniBottomMenu"   >MENU</a>
																				<a href="#" class="miniBottomMenu"   >MENU</a>
																				<a href="#" class="miniBottomMenu"  >MENU</a>
																				<a href="#" class="miniBottomMenu" >MENU</a>
																				<a href="#" class="miniBottomMenu"  >MENU</a>
																				<a href="#" class="miniBottomMenu" >MENU</a>
																				<a href="#" class="miniBottomMenu"  >MENU</a>
																				<a href="#" class="miniBottomMenu"  >MENU</a>
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

																									<div class="prodHeaders" style="width:90%; margin-left:auto; margin-right:auto; color: #{{ThemeLoops.paragraphTextColour}}; padding-left:25px;padding-right:25px;">
																										<div style="float:left;margin-left:5px">Category Name</div><div style="float:right;margin-right:5px;font-size:12px">Page 1 of 1</div>
																									</div>
																									<div style="clear: both"></div>

																									<div  style="width:90%;margin-left:auto; margin-right:auto; margin-bottom:20px;padding-left:25px;padding-right:25px; color: #{{ThemeLoops.paragraphTextColour}};"> 
																										<div class="row margin-top-light">
																											<?Php for($i = 0; $i <= 3; $i++ ){  ?>
																												<div class="col-md-3">
																													<span style="position:relative;display:block; ">
																														<span class="categoryBox-200" style="width:100%; border-radius:10%;">
																															<div class="fancy-200" style="background-color:#fff; padding:4px; " id="fancy-200Txt">
																																<img src="<?=base_url()?>/Images/product.jpg" width="100%" height="auto" border="0" class="fancyX"/>
																																<div class='categoryTextTiny' style="text-align:center; padding-bottom:7px;">
																																	<span style="font-size:10px"><strong>PRODUCT NAME</strong></span><br />
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
																									<small> {{rgbheaderBackground}} </small>
																								</div>
																								<div class="col-md-2"> 
																									<input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.headerBackground, 'headerbg')" ng-model="ThemeLoops.headerBackground" style="background-color:#{{ThemeLoops.headerBackground}}" />
																								</div>
																								<div class="col-md-1 text-left">
																									<span class="undo" ng-click="undoColor('headerbg')"  title="Undo Colour" ><i class="fa fa-undo"></i></span>
																								</div>

																								<div class="col-md-3 text-right">
																									<span> Search Box </span>
																									<small> {{rgbsearchBoxColour}} </small>
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
																									<span> Menu Hover </span>
																									<small> {{rgbheaderTextColour}} </small>
																								</div>
																								<div class="col-md-2"> 
																									<input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.headerTextColour, 'headertext')" ng-model="ThemeLoops.headerTextColour" style="background-color:#{{ThemeLoops.headerTextColour}}" />
																								</div>
																								<div class="col-md-1 text-left">
																									<span class="undo" ng-click="undoColor('headertext')"  title="Undo Colour" ><i class="fa fa-undo"></i></span>
																								</div>

																								<div class="col-md-3 text-right">
																									<span> Search Box Text </span>
																									<small> {{rgbsearchBoxTextColour}} </small>
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
																									<small> {{rgbheaderTrimColour}} </small>
																								</div>
																								<div class="col-md-2"> 
																									<input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.headerTrimColour, 'headertrim')" ng-model="ThemeLoops.headerTrimColour" style="background-color:#{{ThemeLoops.headerTrimColour}}" />
																								</div>
																								<div class="col-md-1 text-left">
																									<span class="undo" ng-click="undoColor('headertrim')" title="Undo Colour"  ><i class="fa fa-undo"></i></span>
																								</div> 


																								<div class="col-md-3 text-right">
																									<span> Search Border Focus </span>
																									<small> {{rgbtextHighlightColour}} </small>
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
																									<span> Top Menu Colour </span>
																									<small> {{rgbmenuHighlightColour}} </small>
																								</div>
																								<div class="col-md-2"> 
																									<input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.menuHighlightColour, 'menuhighlight')" ng-model="ThemeLoops.menuHighlightColour" style="background-color:#{{ThemeLoops.menuHighlightColour}}" />
																								</div>
																								<div class="col-md-1 text-left">
																									<span class="undo" ng-click="undoColor('menuhighlight')" title="Undo Colour"  ><i class="fa fa-undo"></i></span>
																								</div> 
																								<div class="col-md-3 text-right">
																									<span> Body Text Colour </span>
																									<small> {{rgbparagraphTextColour}} </small>
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
																									<small> {{rgbCategoryIconOverlay}} </small>
																								</div>
																								<div class="col-md-2"> 
																									<input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.CategoryIconOverlay, 'bottommenubg')" ng-model="ThemeLoops.CategoryIconOverlay" style="background-color:#{{ThemeLoops.CategoryIconOverlay}}" />
																								</div>
																								<div class="col-md-1 text-left">
																									<span class="undo" ng-click="undoColor('bottommenubg')" title="Undo Colour"  ><i class="fa fa-undo"></i></span>
																								</div> 
																								<div class="col-md-3 text-right">
																									<span> Product Text Colour </span>
																									<small> {{rgbcategoryTextColour}} </small>
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
																									<small> {{rgbtabTextColourHover}} </small>
																								</div>
																								<div class="col-md-2"> 
																								<input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.tabTextColourHover, 'tabTextColourHover')" ng-model="ThemeLoops.tabTextColourHover" style="background-color:#{{ThemeLoops.tabTextColourHover}}" />
																								</div>
																								<div class="col-md-1 text-left">
																								<span class="undo" ng-click="undoColor('tabTextColourHover')"  title="Undo Colour" ><i class="fa fa-undo"></i></span>
																								</div> 
																								<div class="col-md-3 text-right">
																									<span>Body Background </span>
																									<small> {{rgbBackgroundColour}} </small>
																								</div>
																								<div class="col-md-2"> 
																									<input colorpicker="hex"  class="form-control" type="text" ng-change="removeHash(ThemeLoops.BackgroundColour, 'body')" ng-model="ThemeLoops.BackgroundColour" style="background-color:#{{ThemeLoops.BackgroundColour}}" />
																								</div>
																								<div class="col-md-1 text-left">
																									<span class="undo" ng-click="undoColor('body')" title="Undo Colour"  ><i class="fa fa-undo"></i></span>
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
																									<div style="width:90%;margin-left:auto; margin-right:auto; font-size:9px ">
																												
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

																											<?php
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
																											<span>  Tab Colour </span>
																											<small> {{rgbtabColour}} </small>
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
																											<span>  Tab Text Colour </span>
																											<small> {{rgbtabTextColour}} </small>
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
																											<small> {{rgbtabSelectedColour}} </small>
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
																											<small> {{rgbtabSelectedText}} </small>
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
																												<span>Icon Box Colour</span>
																												<small> {{rgbtableBorderColour}} </small>
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
																												<small> {{rgbtableHeaderColour}} </small>
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
																												<small> {{rgbtableHeaderTextColour}} </small>
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
																												<small> {{rgbtableCellColour}} </small>
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
																												<small> {{rgbtableCellTextColour}} </small>
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
																			<span class="padding-top"> Tracking ID: </span>
																		</div>
																		<div class="col-md-7"> 
																			<input class="form-control" type="text"  ng-value="ThemeLoops.googleAnalyticsID" ng-model="ThemeLoops.googleAnalyticsID"  >
																		</div>
																	</div>  
																												

																</div>
															</div>
														</div>

														
													</div>  <!-- END accordion-->


													

													<!--<div class="floating-uploader save-btn-floating">-->
														<div class="row margin-top"> 
															<div class="col-md-12 text-left"> 
																<button type="submit" name="update" class="btn btn-danger btn-large"  >  <i class="fa  fa-save"></i> Save {{ThemeLoops.CompanyTag}} </button>  <span class="general-error" ng-if="generalError"> <i class="fa fa-times text-red"></i> {{generalError}} </span>
															</div>
														</div>  
													<!--</div>    -->

												</fieldset>
											</form>


										<!-- End Form -->

										

									</div>
								</div> 
								
								
					</div>
		
				<?php endif; ?>

					
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