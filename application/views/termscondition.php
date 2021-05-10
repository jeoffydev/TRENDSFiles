
<?php
	$this->load->view('header/header');
?> 
 <div class="jumbotron" >
	<h2> TERMS & CONDITION</h2>
	 
	 
</div>
<div class="container margin-bottom">
	<div class="row">
		<div class="col-md-12 minheight">
			<?php if($customArray['themeArray'] > 0 ): ?>
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