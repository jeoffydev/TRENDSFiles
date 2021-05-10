
<?php
	$this->load->view('header/header');
?> 
<div class="container">
	<div class="jumbotron" >
		<h2>Reset Password</h2> 
	</div>
</div>

<div class="container minheight">
	<div class="row">
		<div class="col-md-4">&nbsp;</div>
		<div class="col-md-4">
				<p class="alert alert-light">Please enter your new password. </p>
				
				<form ng-submit="resetMainUserPW(<?=$userIDVerified;?>, '<?=$userHash;?>')" >
				
					 
					<div class="form-group">
						<label for="InputPassword1">Enter New Password</label>
						<input type="password" class="form-control" id="InputPassword1"  ng-model="resetMainUserPWForm.pw1" ng-change="checkNewPW(resetMainUserPWForm.pw1, resetMainUserPWForm.pw2)"  >
					</div>
					<div class="form-group">
						<label for="InputPassword2">Confirm New Password</label>
						<input type="password" class="form-control" id="InputPassword2" ng-model="resetMainUserPWForm.pw2" ng-change="checkNewPW(resetMainUserPWForm.pw1, resetMainUserPWForm.pw2)" >
					</div>
		
					<p ng-if="userResetPWMsg"><small class="text-danger" >{{userResetPWMsg}}</small></p>
		
					<div ng-if="correct">
						<p class="text-center"> <img src="<?php echo base_url();?>Images/loading-img.gif" width="50" height="50"/> </p>
					</div>	
					
					<button type="submit" class="btn btn-primary pull-right" ng-disabled="updateUserPWBtn">Update</button>
			</form>
			 
		</div>	
		<div class="col-md-4">&nbsp;</div>	
	</div>	
</div>
<?php
	$this->load->view('footer/footer');
?> 