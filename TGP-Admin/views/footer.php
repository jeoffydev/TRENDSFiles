 


    </div>
</div>
<!-- End wrapper -->

    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Trends.nz  © <?php echo date("Y"); ?></small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>

	<script src="<?php echo $baseUrl; ?>/assets/vendor/lodash/lodash.min.js"></script>
	<script src="<?php echo $baseUrl; ?>/assets/vendor/jquery/jquery.min.js"></script>

    


    <script src="<?php echo $baseUrl; ?>/assets/js/jquery-ui.js"></script>	
    <script src="<?php echo $baseUrl; ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $baseUrl; ?>/assets/js/jquery.jexcel.js"></script> 
    <!--<script src="<?php echo $baseUrl; ?>/assets/js/jquery.jexcelcsv.min.js"></script>-->
      <?php 
      //Find userID tracker
        $trackUser = detectUserID($table, $userID); 
        if($trackUser > 0){ 
            // echo "Delete user";
            detectDeleteUserID($table, $userID);
        } 
 
      ?> 
      
      <?php 
        if($request_uri[0] == $navUrl.'/add-products'){
            include('views/jquery/add-products_js.php');  
        } 
        if($request_uri[0] == $navUrl.'/add-pricing'){
          include('views/jquery/add-pricing_js.php');  
        } 
      ?>

    
    
   
    <script src="<?php echo $baseUrl; ?>/assets/js/custom.js"></script>  
    
    <!-- Core plugin JavaScript-->
    <script src="<?php echo $baseUrl; ?>/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?php echo $baseUrl; ?>/assets/js/sb-admin.min.js"></script> 
    <!-- Angularjs -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script> -->
    <script src="<?php echo $baseUrl; ?>/assets/js/angularjs.min.js"></script> 
    <script src="<?php echo $baseUrl; ?>/assets/js/angular-ui.min.js"></script> 
    <script src="<?php echo $baseUrl; ?>/assets/js/pagination.js"></script> 
    <script src="<?php echo $baseUrl; ?>/assets/js/angularjs-sanitize.js"></script>  
    <script src="<?php echo $baseUrl; ?>/assets/js/ng-file-upload-shim.min.js"></script>
    <script src="<?php echo $baseUrl; ?>/assets/js/ng-file-upload.min.js"></script>

    <script src="<?php echo $baseUrl; ?>/assets/js/textAngular-rangy.min.js"></script>
    <script src="<?php echo $baseUrl; ?>/assets/js/textAngular-sanitize.min.js"></script> 
    <script src="<?php echo $baseUrl; ?>/assets/js/textAngular.min.js"></script> 
    
    <script src="<?php echo $baseUrl; ?>/assets/js/colorpicker.min.js"></script> 
     
 
    <script src="<?php echo $baseUrl; ?>/assets/app/app.js"></script> 
    <?php  if($angularFooter){ include( $angularFooter ); } ?>
    
        
     

</body>

</html>
