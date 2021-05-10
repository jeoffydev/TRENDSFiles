
<?php
	$this->load->view('header/header');
?> 
 
 

<div class="container">
	<div class="jumbotron" >
		<h2>Success!</h2>
	</div>
</div>

<div class="container minheight">
	<div class="row">
 
		 
		<div class="col-md-12">
				
			<div class="alert alert-light" >
				<p>Thank you for subscribing to receive our updates. You will start recieving emails from us shortly. </p>
				<p>Click <a  href="#" data-toggle="modal" data-target="#mailingListModal"><strong>here</strong></a> to add another email to our subscriber list, or return to our <a  href="<?=strtoupper($customArray['customHome'])?>"><strong>website</strong></a>.</p>
			</div>
				
		</div>
		 
		
	
	</div> 
</div>

 

<?php
	$this->load->view('footer/footer');
?> 