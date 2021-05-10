
<?php
	$this->load->view('header/header');
?> 
	 
	 
	<div class="container">
		<div class="jumbotron" >
		<h2>PAGE NOT FOUND</h2> 
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center minheight">
					<h1 class="display-1">Sorry.</h1>
					<p>Looks like something went wrong on our end.  </p>
					<p><a class="btn btn-secondary btn-skinned btn-small" href="<?=strtoupper($customArray['customHome'])?>">Back to Homepage</a> </p>
			</div>		
		</div>	
	</div>
	 

<?php
	$this->load->view('footer/footer');
?> 