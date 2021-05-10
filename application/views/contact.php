
<?php
	$this->load->view('header/header');
?> 
 

<div class="container">
	<div class="jumbotron" >
		<h2>Contact Us  </h2>
	</div>
</div>


<div class="container margin-bottom">
	<div class="row">
		<div class="col-md-12">
			<?php if($customArray['themeArray'] > 0 ): ?>
				<?php	foreach($customArray['themeArray'] as $theme){  ?> 
					<?=htmlspecialchars_decode($theme->ContactUsText)?>  
				<?php }  ?> 
			<?php endif; ?>   
		</div>
	</div>	
	<div class="row  margin-top">
		<div class="col-md-6">
				<!-- FORM -->
					
				<form ng-submit="submitSkinnedContactForm()"  >  
					<fieldset  ng-if="!enquiryMsg">

						 
 
						 <input type="text" class="form-control" id="InputName"  ng-model="BotValue"  style="display:none"   > 
						<div class="form-group">
							<label for="InputName">Name *:</label>
							<input type="text" class="form-control" id="InputName"  ng-model="skinnedContactForm.Name"    > 
						</div>
					 
						<div class="form-group">
							<label for="InputEmail">Email *:</label>
							<input type="email" class="form-control" id="InputEmail"  ng-model="skinnedContactForm.Email" ng-change="skinnedFormCheck('email', skinnedContactForm.Email)"  > 
						</div>
						<div class="form-group">
							<label for="InputPhone">Phone:</label>
							<input type="tel" class="form-control" id="InputPhone"  ng-model="skinnedContactForm.Phone"     > 
						</div>
						 
						<div class="form-group">
							<label for="InputDetails">Enquiry:</label>
							<textarea class="form-control" id="textareaDetails" rows="2" ng-model="skinnedContactForm.Details" ></textarea>
						</div>
						<div class="form-check margin-bottom">
							<label class="form-check-label" for="defaultCheck1">
								<input class="form-check-input" type="checkbox" ng-model="skinnedContactForm.Human" ng-click="makeBotTrue(skinnedContactForm.Human)" > 
								Check this, if you are human/not a robot.
							</label>
						</div>
					</fieldset>	
					<div class="form-group" ng-if="enquiryMsg" >
						<i class='fa fa-check'></i>   {{enquiryMsg}}
					</div>
					<div class="form-group" ng-if="!enquiryMsg">
						<button type="submit" class="btn btn-primary contact-btn" ng-disabled="(skinnedContactForm.Name   && skinnedContactForm.Email   && skinnedContactForm.Human && alright  ) ?  false : true" >Submit Enquiry</button>
					</div>
				</form>	

				

				<!-- FORM-->
		</div>
		<div class="col-md-6">
			 	

				 <!--Start contact rightbar-->
				 <?php if($customArray['themeArray'] > 0 ):   ?>
				 	<?php	foreach($customArray['themeArray'] as $theme){  ?> 
							<? if($theme->Phone !="") { ?> 
								<div class="row">
									<div class="col-md-3 text-right">Phone: </div><div class="col-md-9" ><? echo $theme->Phone; ?></div>
								</div>	
								
							<? } if($theme->Email !=""  &&  $theme->DisplayEmail == 1) { ?>
								<div class="row margin-top-contact">	
									<div class="col-md-3 text-right">Email: </div><div class="col-md-9" ><a  href='mailto:<? echo $theme->Email; ?>'><? echo $theme->Email; ?></a></div>
								</div>	
							<? } if($theme->Address !="") { ?>
								<div class="row  margin-top-contact">
									<div class="col-md-3 text-right">Address: </div><div class="col-md-9" ><span style="display:inline-block;white-space: pre-wrap;"><? echo $theme->Address; ?></span></div>
								</div>	
							<? } if($theme->Skype !="") { ?>
								<div class="row  margin-top-contact">
									<div class="col-md-3 text-right">Skype: </div><div class="col-md-9" ><a href='skype:<? echo $theme->Skype; ?>'><? echo $theme->Skype; ?></a></div>
								</div>	
							<? } if($theme->Facebook !="") { ?>
								<div class="row  margin-top-contact">
									<div class="col-md-3 text-right">Facebook:</div><div class="col-md-9" ><a target='_blank'   href='https://<? echo $theme->Facebook; ?>'><? echo $theme->Facebook; ?></a></div>
								</div>	
							<? } if($theme->Twitter!="") { ?>
								<div class="row margin-top-contact">
									<div class="col-md-3 text-right">Twitter: </div><div class="col-md-9" ><a target='_blank' href='https://<? echo $theme->Twitter; ?>'><? echo $theme->Twitter; ?></a></div>
								</div>	
							<? } if($theme->LinkedIn !="") { ?>
								<div class="row margin-top-contact">	
									<div class="col-md-3 text-right">LinkedIn: </div><div class="col-md-9" ><a target='_blank'  href='https://<? echo $theme->LinkedIn; ?>'><? echo $theme->LinkedIn; ?></a></div>
								</div>	
							<? } if($theme->GooglePlus !="") { ?>
								<div class="row margin-top-contact">
									<div class="col-md-3 text-right">Google Plus: </div><div class="col-md-9" ><a target='_blank'   href='https://<? echo $theme->GooglePlus; ?>'><? echo $theme->GooglePlus; ?></a></div>
								</div>	
							<? } if($theme->Website != ""  ) { ?>
								<div class="row margin-top-contact">
									<div class="col-md-3 text-right">Website: </div><div class="col-md-9" ><a target='_blank'   href='https://<? echo $theme->Website; ?>'><? echo $theme->Website; ?></a></div>
								</div>	
							<? } if($theme->Instagram != ""  ) { ?>
								<div class="row margin-top-contact">
									<div class="col-md-3 text-right">Instagram: </div><div class="col-md-9" ><a target='_blank'  href='https://<? echo $theme->Instagram; ?>'><? echo $theme->Instagram; ?></a></div>
								</div>	
							<? } ?>
					<?php }  ?> 	
				<?php endif; ?>   
				 <!-- end contact rightbar -->
					  
				 
		</div>
	</div>	
	<div class="row">
		<div class="col-md-12 margin-bottom">&nbsp;</div>
		<div class="col-md-12 margin-bottom">&nbsp;</div>
	</div>
</div>

<?php
	$this->load->view('footer/footer');
?> 