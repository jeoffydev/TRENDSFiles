 
<!-- popup --> 
<?php
	$this->load->view('footer/popup');
?> 	 
<!-- popup -->
<div class="footer-spacing"></div>

<?php
	$this->load->view('footer/floating-footer');
?> 	 

</div> <!-- end of general Control--> 

<!--<div class="footer-spacing"></div>-->




 <!-- Bootstrap core JavaScript -->
 <script src="<?=base_url();?>public/js/jquery.min.js"></script>
 <script src="<?=base_url();?>public/js/popper.min.js"></script>
 <script src="<?=base_url();?>public/js/blob.js"></script>
 <script src="<?=base_url();?>public/js/bootstrap.min.js"></script>
 <script src="<?=base_url();?>public/js/jquery.mobile.custom.min.js"></script>
 <?php if($angularFile == 'customer'): ?>  
	<script src="<?=base_url();?>public/js/moment.min.js"></script>  
<?php endif; ?> 
 <script src="<?=base_url();?>public/js/angularjs.min.js"></script>  
 <script src="<?=base_url();?>public/js/angular-ui.min.js"></script>  
 <script src="<?=base_url();?>public/js/angular-ui-bootstrap.js"></script>

 <script src="<?=base_url();?>public/js/angularjs-sanitize.js"></script> 
 <script src="<?=base_url();?>public/js/select2.min.js"></script> 
 <?php if($angularFile == 'item'): ?> 
	<script src="<?=base_url();?>public/js/canvas2image.js"></script>
	<script src="<?=base_url();?>public/js/html2canvas.min.js"></script>  
	<script src="<?=base_url();?>public/js/canvas_custom.js"></script> 
<?php endif; ?> 
<script src="<?=base_url();?>public/js/slick.js"></script> 
<script src="<?=base_url();?>public/js/angular-slick.js"></script>
<script src="<?=base_url();?>public/js/pagination.js"></script>   
<script src="<?=base_url();?>public/js/ng-file-upload-shim.min.js"></script>
<script src="<?=base_url();?>public/js/ng-file-upload.min.js"></script> 
<script src="<?=base_url();?>public/js/textAngular-rangy.min.js"></script>
<script src="<?=base_url();?>public/js/textAngular-sanitize.min.js"></script> 
<script src="<?=base_url();?>public/js/textAngular.min.js"></script> 
<script src="<?=base_url();?>public/js/colorpicker.min.js"></script> 
<script src="<?=base_url();?>public/js/angular-select.js"></script>  
<script src="<?=base_url();?>public/js/ng-infinite-scroll.min.js"></script>   
<script src="<?=base_url();?>public/js/input-spinner.js"></script>
<script src="<?=base_url();?>public/js/ngclipboard.min.js"></script>
<script src="<?=base_url();?>public/js/ngclipboard.js"></script>
<script src="<?=base_url();?>public/js/underscore.js"></script>
<script src="<?=base_url();?>public/js/ng-range-slider.js"></script>
<script src="<?=base_url();?>public/angular/app.js?<?=date("Ymd")?>"></script>  


  
 <?php
	  $this->load->view('angularjs/'.$angularFile.'_angular');
 ?> 
 <?php
	  $this->load->view('angularjs/general_angular');
 ?> 
</body>
</html>