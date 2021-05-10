
<?php
	$this->load->view('header/header');
?> 
 
<div class="container margin-top">
	<div class="row">
		<div class="col-md-12 abouttext " style="min-height:680px;">
			<?php if($customArray['themeArray'] > 0 ):     ?>
				<?php	//foreach($customArray['themeArray'] as $theme){   
					  ?> 
					<?php if($AboutUsText = $customArray['themeArray'][0]->AboutUsText): ?>
						<?php $decodeAbout = $this->general_model->cleanAbout(htmlspecialchars_decode($AboutUsText));
							$content = html_entity_decode(mb_convert_encoding($decodeAbout, 'ISO-8859-15','utf-8'));  
							echo $content;
						?> 
						 
						
						<div class="margin-bottom">&nbsp;</div>
					<?php else: ?>   
						<div class="margin-bottom">&nbsp;</div>
						<div class="margin-bottom">&nbsp;</div>
						<div class="margin-bottom">&nbsp;</div>
						<div class="margin-bottom">&nbsp;</div>
					<?php endif; ?>  
				<?php // }  ?> 
			<?php endif; ?>   
			<?php if(count($customArray['themeArray']) == 0 && $siteLogcheck['loggedIn'] == 0): ?>

					
							<h4>Printed Pens – Promotional Products – Business Gifts</h4>
								<p>TRENDS has the largest range of promotional products and business gifts. With 30 years of experience and over 500 ex stock products to choose from; we are the clear market leader in our industry.</p>
								<p>At TRENDS we offer a complete one stop service. With our own modern, well equipped printing factory we offer unsurpassed branding solutions for all of the promotional products in our range.</p>
								<p>We are the specialists when it comes to full colour printing solutions and through constant research and development the number of our products that can be branded in full colour is growing continuously.</p>
								<p>From typesetting and design through to final printing and despatch, your promotional products are produced in house by our experienced team .</p>
								<p>We are strictly a trade only supplier and do not sell to end users but you can purchase our products with confidence from our network of distributors. Simply ask your promotional products supplier about our range and always specify that you want TRENDS products when you order.</p>
								<p>Click here to email us for more information:  <strong> <?=$EmailHidden?> </strong></p>
								
						

					
			<?php endif; ?>
		</div>		
	</div>	
</div>
<?php
	$this->load->view('footer/footer');
?> 