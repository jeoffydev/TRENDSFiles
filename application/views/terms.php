
<?php
	$this->load->view('header/header');
?> 
 

 

<div class="container margin-top">
	<div class="row">
		<div class="col-md-12 minheight">
			<?php if($customArray['themeArray'] > 0 && $siteLogcheck['loggedIn'] == 0 ): ?>
				<?php	foreach($customArray['themeArray'] as $theme){  ?> 
					<?=htmlspecialchars_decode($theme->termsConditionText)?> 
				<?php }  ?> 
			<?php endif; ?>   
		</div>
	</div>
</div>
<?php
	$this->load->view('footer/footer');
?> 