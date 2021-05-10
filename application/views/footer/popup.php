<!--login form --> 
<?php if($siteLogcheck['loggedIn'] == 0  && count($customArray['themeArray'])==0): ?>
<div class="modal fade" id="loginFormModal" tabindex="-1" role="dialog" aria-labelledby="loginFormModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginFormModalLabel">Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

		    <div id="carouselMainLoginControls" class="carousel slide" data-ride="carousel" data-interval="false">
				<div class="carousel-inner">
					<div class="carousel-item active">


		 
						<div ng-show="userBox">
							<div class="row"> 
								<div class="col-md-9">
									<label for="InputEmail">Email Address</label>
									<div class="input-group mb-3" > 
										<div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon1">@</span>
										</div>
										<input type="text" class="form-control" placeholder="login@email.com"  ng-enter ="checkUserName(userName)" ng-model="userName">
										
									</div> 
								</div>	
								<div class="col-md-3"> 
									<button type="button" class="mainlogin-btn btn btn-primary pull-left btn-block" ng-click="checkUserName(userName)" ng-disabled="!userName">Next</button>
								</div>
							</div>	
							<p ng-if="errorUser"><small >{{errorUser}}</small></p>
							
						</div>	
						<div ng-if="passWord">
							<div class="row"> 
								<div class="col-md-9">
									<label for="InputPassword">Password</label>
									<div class="form-group">  
										<input type="password" class="form-control" id="InputPassword" ng-enter ="checkpw(userPassword)"  ng-model="userPassword">
									</div>
								</div>	
								<div class="col-md-3">
									<button type="button" class="mainlogin-btn btn btn-primary pull-left btn-block" ng-click="checkpw(userPassword)" ng-disabled="!userPassword">Next</button>
								</div>
							</div>	
								
							<p ng-if="errorPw"><small >{{errorPw}}</small></p>
							
						</div>	

						<div class="row">
								<div class="col-md-12 ">  <span class="cursorpoint  " ng-show="passWord" ng-click="resetLogin()"  data-toggle="tooltip" data-placement="left" title="Enter New Email Address" > <i class="fa  fa-arrow-left"></i>   </span> <span  ng-show="passWord"  > | </span>  <a href="#carouselMainLoginControls" role="button" data-slide="next" ><u>Forgot Password?</u></a> </div>
						</div>

						<div ng-if="correct">
							<p class="text-center"> <img src="<?php echo base_url();?>Images/loading-img.gif" width="50" height="50"/> </p>
						</div>	

					</div>
					<div class="carousel-item">
										<p>Please enter your registered email address. An email will be sent to you with a password reset link. </p>
										<form ng-submit="forgotPwMainUser(userMainEmail)">
											<div class="form-group">
												<label for="MainInputEmail1">Email address</label>
												<input type="email" class="form-control" id="MainInputEmail1" ng-model="userMainEmail"   > 
												<p ng-if="errorEmailForgot"><small ><span ng-bind-html="errorEmailForgotMsg | trust"></span> </small></p>
											</div>  
											<div class="form-group">
												<a href="#carouselMainLoginControls" role="button" data-slide="prev"  ><u>Already have login? click here</u></a>
											</div>  
											<button type="submit" class="btn btn-primary pull-right" ng-disabled="!userMainEmail">Reset</button>
										</form>
					</div>
				</div>				 
			</div>		




      </div>
      <!--<div class="modal-footer">
	  
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
      </div>-->
    </div>
  </div>
</div>
<?php endif; ?>
<!--login form -->






<!-- Branding popup--> 
<?php foreach($brandingMenu as $brandingMenuItem){ ?>

<!-- Modal -->
<div class="modal popup-branding fade" id="<?php echo $brandingMenuItem['imgUrl'];?>Modal" tabindex="-1" role="dialog" aria-labelledby="<?php echo $brandingMenuItem['imgUrl'];?>ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel">
			<?php 
			if($brandingMenuItem['title'] == "Sublimation Print"): $brandingMenuItem['title'] = "Sublimation Print – Dye Sublimation"; endif; 
			echo $brandingMenuItem['title'];
			?>
		</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

		<!-- start popup content-->
		<?php if($brandingMenuItem['title']=="Rotary Digital Print") { ?>
			<div class="brandingImageRight"> <img src="<?php echo base_url();?>Images/Branding/<?php echo $brandingMenuItem['imgUrl'];?>.png" width="100%" height="100%"   /> </div>
             
            <div class="bodyText">Direct to product rotary digital printing involves the transfer of UV ink directly from inkjet print heads and can be used to produce detailed artwork using both closely matched spot colours and full colour branding.</div>
            <div class="HeaderSmall">Advantages</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Ideal for large or complex full colour prints.</li>
				<li>The print is dry and ready to ship as soon as the product is printed.</li>
				<li>Only one setup charge is required regardless of the number of print colours.</li>
				<li>No loss of print vibrancy, even on darker products.</li>

 
			</ul>
            <div class="HeaderSmall">Limitations</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 
				<li>Production speed is limited so lead times can be longer in some cases.</li>
				<li>Some colours cannot be reproduced including metallic and neon/fluorescent colours.</li>
				<li>As the print does not wrap completely around the product, there is a small gap between the start and end of the print.</li>
				<li>More expensive than other branding options.</li> 
 
			</ul>
            <div class="HeaderSmall">Artwork Requirements</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 
				<li>Artwork can be supplied in either vector or bitmap format.</li>
				<li>Supplied bitmaps must be higher than 300DPI resolution at the actual print size.</li>
				<li>Fonts are advised to be converted to outlines/objects to avoid font conflicts.</li> 
			</ul>
		<?php } 
		if($brandingMenuItem['title']=="Pad Print") { ?>
			<div class="brandingImageRight"><img src="<?php echo base_url();?>Images/Branding/<?php echo $brandingMenuItem['imgUrl'];?>.png" width="100%" height="100%"  /></div>
            <div>&nbsp;</div>
            <div class="bodyText">Pad printing uses a silicone pad to transfer an image to a product from a laser etched printing plate. It is one of the most popular and affordable ways of branding promotional products due to its ability to reproduce images on uneven or curved products and print multiple colours in a single pass.</div>
            <div class="HeaderSmall">Advantages</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 
				<li>Ideal for printing on curved or uneven products.</li> 
				<li>Prints sharp, clean images with detail as fine as 0.4mm, minimum text size is 5pt.</li> 
				<li>Close PMS matches are possible on white or light-coloured products.</li> 
				<li>Metallic gold and silver ink are available.</li> 
				<li>Can offer a white under base for the darker products that require it.</li> 
				<li>Many products can print up to 6 colours with tight multi-colour registration.</li> 
 
			</ul>
            <div class="HeaderSmall">Limitations</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Halftones cannot be consistently reproduced.</li> 
				<li>Unable to print variable data such as individual naming.</li> 
				<li>Close PMS matches are more difficult on darker products and will only be approximate. In these instances, a white base will create a better print.</li> 
				<li>Some pad print inks require a curing period before the product can be shipped.</li> 
				<li>Each colour requires its own setup charge.</li> 
				<li>Neon/fluorescent colours are not available.</li> 

 
			</ul>
            <div class="HeaderSmall">Artwork Requirements</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 
				<li>Artwork must be supplied in a vector editable format.</li>
				<li>Fonts are advised to be converted to outlines/objects to avoid font conflicts.</li>
 
			</ul>
		<?php }
        if($brandingMenuItem['title']=="Rotary Screen Print") { ?>
			<div class="brandingImageRight"><img src="<?php echo base_url();?>Images/Branding/<?php echo $brandingMenuItem['imgUrl'];?>.png" width="100%" height="100%"  /></div>
            <div>&nbsp;</div>
            <div class="bodyText">Rotary Screen Printing is achieved by forcing ink through a fine mesh screen with a squeegee onto the product and is ideal for cylindrical objects.</div>
            <div class="HeaderSmall">Advantages</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Large print areas are possible on cylindrical products.</li> 
				<li>Close PMS matches are possible on white or light-coloured products.</li> 
				<li>Most screen print inks are quick drying and can be shipped immediately after printing.</li> 
				<li>Metallic gold and silver colours are available.</li> 
				<li>Many products can print five colours (including white) with tight multi-colour registration.</li> 
				<li>Halftones can be achieved on certain products.</li> 

 
			</ul>
            <div class="HeaderSmall">Limitations</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Close PMS matches are more difficult on darker products and will only be approximate. In some instances, a white base will create a better print.</li>
				<li>Unable to print variable data.</li>
				<li>Each colour requires its own setup charge.</li>

 
			</ul>
            <div class="HeaderSmall">Artwork Requirements</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important">  
				<li>Artwork must be supplied in editable vector format.</li>
				<li>Fonts are advised to be converted to outlines/objects to avoid font conflicts.</li>

				 
			</ul>
		<?php }


		if($brandingMenuItem['title']=="Flatbed Screen Print") { ?>
			<div class="brandingImageRight"><img src="<?php echo base_url();?>Images/Branding/<?php echo $brandingMenuItem['imgUrl'];?>.png" width="100%" height="100%"  /></div>
			<div>&nbsp;</div>
			<div class="bodyText">Flatbed Screen Printing is achieved by forcing ink through a fine mesh screen with a squeegee onto the product and is ideal for branding flat objects.</div>
			<div class="HeaderSmall">Advantages</div>
			<ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Large print areas are possible on flat products.</li> 
				<li>Close PMS matches are possible on white or light-coloured products.</li> 
				<li>Most screen print inks dry quickly and can be shipped immediately after printing.</li> 
				<li>Fluorescent, metallic gold and silver inks are available.</li> 
				<li>Many products can print with tight multi-colour registration, with some products able to be printed using up to six colours.</li> 
				<li>Halftones are achievable on some products.</li> 

 

			</ul>
			<div class="HeaderSmall">Limitations</div>
			<ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Close PMS matches are more difficult on darker products and will only be approximate. In some instances, a white base will create a better print.</li>
				<li>Unable to print variable data.</li>
				<li>Each colour requires its own setup charge.</li>
 

			</ul>
			<div class="HeaderSmall">Artwork Requirements</div>
			<ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important">  

				<li>Artwork must be supplied in editable vector format.</li>
				<li>Fonts are advised to be converted to outlines/objects to avoid font conflicts.</li> 
				
			</ul>
		<?php }

		
		if($brandingMenuItem['title']=="Direct Digital") { ?>
			<div class="brandingImageRight"><img src="<?php echo base_url();?>Images/Branding/<?php echo $brandingMenuItem['imgUrl'];?>.png" width="100%" height="100%"  /></div>
            <div>&nbsp;</div>
            <div class="bodyText">Direct digital printing involves the transfer of ink directly from the print heads of an inkjet machine to the product and can be used to produce both full colour and closely matched spot colour branding on flat or slightly curved surfaces.</div>
            <div class="HeaderSmall">Advantages</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Ideal for printing dark coloured products as a layer of white ink can be printed under the artwork.</li> 
				<li>Can print variable data including individual names.</li> 
				<li>Dried instantly so products can be shipped immediately.</li> 
				<li>Offers larger print areas on many products and can print very close to the edge of flat products.</li> 
				<li>Only one set up charge is required regardless of the number of print colours.</li> 

 
			</ul>
            <div class="HeaderSmall">Limitations</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 
				<li>Some colours cannot be reproduced including metallic and neon/fluorescent colours.</li> 
				<li>The size of branding areas is limited on curved surfaces.</li> 
				<li>Larger print areas can be more expensive.</li> 
 
			</ul>
            <div class="HeaderSmall">Artwork Requirements</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Artwork can be supplied in either vector or bitmap format.</li>
				<li>Supplied bitmaps must be higher than 300DPI resolution at the actual print size.</li>
				<li>A 3mm bleed must be added to the artwork if it bleeds off the product.</li>
 
			</ul>
		<?php }
		if($brandingMenuItem['title']=="Offset Transfer") { ?>
			<div class="brandingImageRight"><img src="<?php echo base_url();?>Images/Branding/<?php echo $brandingMenuItem['imgUrl'];?>.png" width="100%" height="100%"  /></div>
            <div>&nbsp;</div>
            <div class="bodyText">Offset transfers are used for branding fabrics and are printed on transfer paper using full colour CMYK offset printing then heat pressed onto the product.</div>
            <div class="HeaderSmall">Advantages</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 
				<li>Cost effective method for producing spot colour or full colour transfers.</li> 
				<li>Crisp, clear artwork reproduction is possible even on textured fabrics.</li> 
				<li>Has a bright, glossy finish and will not crack or fade under normal circumstances.</li>
				<li>Only one set up charge is required irrespective of the number of print colours.</li>
			</ul>
            <div class="HeaderSmall">Limitations</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 
				<li>15 working day lead time for transfer production.</li> 
				<li>Unable to print variable data.</li> 
				<li>Only approximate PMS colours can be reproduced.</li>
				<li>Metallic gold and silver is not available.</li>
				<li>A thin, clear line of glue can sometimes be seen around the edges of the image.</li>
			</ul>
            <div class="HeaderSmall">Artwork Requirements</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 
				<li>Artwork can be supplied in either vector or bitmap format.</li>
			</ul>
		<?php }
		if($brandingMenuItem['title']=="Digital Transfer") { ?>
			<div class="brandingImageRight"><img src="<?php echo base_url();?>Images/Branding/<?php echo $brandingMenuItem['imgUrl'];?>.png"  width="100%" height="100%"  /></div>
            <div>&nbsp;</div>
            <div class="bodyText">A digital transfer is a CMYK+W printing method used for branding fabrics. The artwork is printed on transfer paper using a digital printing machine, then heat pressed onto the product.</div>
            <div class="HeaderSmall">Advantages</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 
				<li>Cost effective method for producing full colour and closely matched spot colour transfers.</li>
				<li>High definition, complex, vibrant artwork suitable for a range of garment fabrics.</li>
				<li>Produces a matt finish that will not crack or fade under normal circumstances.</li>
				<li>Efficient self-weeding technology.</li>
				<li>Only one set up charge is required regardless of the number of print colours.</li>
				<li>Can be shipped straight after being printed.</li>
				<li>Uses eco-friendly water-based inks.</li>

 
			</ul>
            <div class="HeaderSmall">Limitations</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

					<li>Some colours cannot be reproduced such as metallic and neon/fluorescent colours.</li>
					<li>A thin keyline of glue can sometimes be seen around the edges of the image.</li>
					<li>Unable to print variable data.</li> 
 
			</ul>
            <div class="HeaderSmall">Artwork Requirements</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Artwork can be supplied in either vector or bitmap format.</li>
				<li>Supplied bitmaps must be higher than 300DPI resolution at the actual print size.</li> 
			 
			</ul>
		<?php }
		if($brandingMenuItem['title']=="Screen Print Transfer") { ?>
			<div class="brandingImageRight"><img src="<?php echo base_url();?>Images/Branding/<?php echo $brandingMenuItem['imgUrl'];?>.png" width="100%" height="100%"  /></div>
            <div>&nbsp;</div>
            <div class="bodyText">Screen print transfers are used for branding fabrics and are produced by screen printing spot colours onto transfer paper then heat pressing them onto the product.</div>
            <div class="HeaderSmall">Advantages</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 
				<li>Close PMS colour matches can be achieved.</li> 
				<li>Crisp, clear artwork reproduction is possible even on textured materials.</li> 
				<li>Metallic gold and silver is available.</li>
				<li>Will not crack or fade under normal circumstances.</li>
				<li>Ideal for improving the print quality of one colour prints on heavily textured material.</li>
			</ul>
            <div class="HeaderSmall">Limitations</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 
				<li>A set up charge is required for each colour to be printed.</li> 
				<li>Cannot print variable data.</li> 
				<li>Halftones and very fine lines are not recommended.</li>
				<li>Not cost effective for multi-colour prints.</li>
			</ul>
            <div class="HeaderSmall">Artwork Requirements</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 
				<li>The artwork should be supplied in vector format.</li>
			</ul>
		<?php }
		if($brandingMenuItem['title']=="Sublimation Print – Dye Sublimation") {   ?>
			<div class="brandingImageRight"><img src="<?php echo base_url();?>Images/Branding/<?php echo $brandingMenuItem['imgUrl'];?>.png" width="100%" height="100%"  /></div>
            <div>&nbsp;</div>
            <div class="bodyText">Dye sublimation print is used for branding products that have a special coating on them, or fabrics suitable for the sublimation process. A transfer is produced by printing sublimation ink onto transfer paper and then heat pressing it onto the product.</div>
            <div class="HeaderSmall">Advantages</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Sublimation ink is a dye so there is no ink build-up. The finished print is embedded in the product.</li> 
				<li>Ideal for producing vivid full colour images as well as closely matched spot colour branding.</li> 
				<li>Can print variable data including individual names.</li> 
				<li>Edge-to-edge branding can be achieved on some products.</li> 
				<li>Only one set up charge is required regardless of the number of print colours.</li> 
 
			</ul>
            <div class="HeaderSmall">Limitations</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Can only be used on suitable products with white surfaces.</li> 
				<li>Some colours cannot be reproduced including white, metallic, and neon/fluorescent colours.</li> 
				<li>Fine detail/text may experience minor colour bleed across adjacent design elements.</li> 

 
			</ul>
            <div class="HeaderSmall">Artwork Requirements</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Artwork can be supplied in either vector or bitmap format.</li>
				<li>Supplied bitmaps must be higher than 300DPI resolution at the actual print size.</li>
				<li>A 3mm bleed must be added to the artwork if it bleeds off the product.</li>

 
			</ul>
		<?php }
		if($brandingMenuItem['title']=="Digital Label") { ?>
			<div class="brandingImageRight"><img src="<?php echo base_url();?>Images/Branding/<?php echo $brandingMenuItem['imgUrl'];?>.png" width="100%" height="100%"  /></div>
            <div>&nbsp;</div>
            <div class="bodyText">Digital adhesive labels are used to brand products that cannot be branded with any other method. They are printed with a digital printing press and applied to the product.</div>
            <div class="HeaderSmall">Advantages</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Ideal for producing vivid full colour images as well as closely matched spot colour branding.</li>
				<li>Can print variable data including individual names.</li>
				<li>Only one set up charge is required regardless of the number of print colours.</li>
				<li>Edge-to-edge branding can be achieved.</li>
				<li>Can be cut to custom shapes.</li>

 
			</ul>
            <div class="HeaderSmall">Limitations</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Metallic and neon/fluorescent colours are not available.</li>
				<li>White print cannot be produced on clear, silver or gold stock.</li>
 
			</ul>
            <div class="HeaderSmall">Artwork Requirements</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Artwork can be supplied in either vector or bitmap format.</li>
				<li>Supplied bitmaps must be higher than 300DPI resolution at the actual print size.</li>
				<li>A 3mm bleed should be added to the artwork if it bleeds off the product.	</li>


				 
			</ul>
		<?php }
		if($brandingMenuItem['title']=="Digital Print") { ?>
			<div class="brandingImageRight"><img src="<?php echo base_url();?>Images/Branding/<?php echo $brandingMenuItem['imgUrl'];?>.png" width="100%" height="100%"  /></div>
            <div>&nbsp;</div>
            <div class="bodyText">This production method is used for printing media such as paper, vinyl and magnetic material used in the manufacture of labels, badges, and fridge magnets etc. This printing process uses CMYK values.</div>
            <div class="HeaderSmall">Advantages</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Ideal for producing vivid full colour images as well as closely matched spot colour branding.</li>
				<li>Can print variable data including individual names.</li>
				<li>Only one set up charge is required regardless of the number of print colours.</li>
				<li>Can be cut to custom shapes.</li>
				<li>Edge-to-edge branding can be achieved.</li>

 
			</ul>
            <div class="HeaderSmall">Limitations</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Metallic and neon/fluorescent colours are not available.</li>
				<li>White print cannot be produced on clear, silver or gold stock.</li> 
			 
			</ul>
            <div class="HeaderSmall">Artwork Requirements</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Artwork can be supplied in either vector or bitmap format.</li>
				<li>Supplied bitmaps must be higher than 300DPI resolution at the actual print size.</li>
				<li>A 3mm bleed should be added to the artwork if it bleeds off the product.</li>

				 
			</ul>
		<?php }
		if($brandingMenuItem['title']=="Imitation Etch") { ?>
			<div class="brandingImageRight"><img src="<?php echo base_url();?>Images/Branding/<?php echo $brandingMenuItem['imgUrl'];?>.png" width="100%" height="100%"  /></div>
            <div>&nbsp;</div>
            <div class="bodyText">Imitation etch is a special pad printing ink used for producing an etch-like effect on glass products.</div>
            <div class="HeaderSmall">Advantages</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 


				<li>Much more affordable than real etching.</li> 
				<li>Can brand curved or uneven products.</li> 
				<li>Produces a subtle finish with a higher perceived value that looks like etching.</li> 

 
			</ul>
            <div class="HeaderSmall">Limitations</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Halftones cannot be consistently reproduced.</li>
				<li>The size of branding areas is limited on curved surfaces.</li>
				<li>Requires a curing period before the product can be shipped.</li>
				<li>Unable to print variable data.</li>

 
			</ul>
            <div class="HeaderSmall">Artwork Requirements</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Artwork must be supplied in a vector editable format.</li>
				<li>Fonts are advised to be converted to outlines/objects to avoid font conflicts.</li>
 
			</ul>
		<?php }
		 
        if($brandingMenuItem['title']=="Laser Engraving") { ?>
			<div class="brandingImageRight"><img src="<?php echo base_url();?>Images/Branding/<?php echo $brandingMenuItem['imgUrl'];?>.png" width="100%" height="100%"  /></div>
            <div>&nbsp;</div>
            <div class="bodyText">Laser engraving is a permanent branding process that engraves artwork into the surface of the product using a laser. Different materials produce different engraving finishes, to avoid uncertainty pre-production samples are recommended.</div>
            <div class="HeaderSmall">Advantages</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Higher perceived value than other forms of branding.</li>
				<li>The branding becomes part of the surface and is permanent.</li>
				<li>Large branding areas available on curved products.</li>
				<li>Can produce variable data such as individual names.</li>
				<li>The product can be shipped straight away after being engraved.</li>

 
			</ul>
            <div class="HeaderSmall">Limitations</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 
				<li>Fine detail can be lost on smaller products like pens.</li>  
			</ul>
            <div class="HeaderSmall">Artwork Requirements</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Artwork must be supplied in editable vector format.</li>
				<li>Fonts are advised to be converted to outlines/objects to avoid font conflicts.</li>
 
			</ul>
		<?php }
        if($brandingMenuItem['title']=="Resin Coated Finish") { ?>
			<div class="brandingImageRight"><img src="<?php echo base_url();?>Images/Branding/<?php echo $brandingMenuItem['imgUrl'];?>.png" style="max-width:250px" /></div>
            <div>&nbsp;</div>
            <div class="bodyText">This CMYK branding process is produced by printing artwork onto a vinyl material with strong adhesive on the reverse. The branded area is then coated with a crystal-clear resin. Once dry, the finished decal is applied to the product and the adhesive forms a permanent bond.</div>
            <div class="HeaderSmall">Advantages</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Ideal for producing vivid full colour images as well as closely matched spot colour branding.</li>
				<li>Produces a stunning 3D effect that elevates the perceived value of a product.</li>
				<li>Can print variable data including individual names.</li>
				<li>Edge-to-edge branding can be achieved on the resin coated area.</li>
				<li>Only one set up charge is required regardless of the number of print colours.</li>

 
			</ul>
            <div class="HeaderSmall">Limitations</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Larger print areas can be more expensive.</li> 
				<li>White, metallic gold, silver and neon colours cannot be printed.</li> 
				<li>The resin needs to be cured for one day before shipping the product.</li> 
 
			</ul>
            <div class="HeaderSmall">Artwork Requirements</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Artwork can be supplied in either vector or bitmap format.</li>
				<li>Supplied bitmaps must be higher than 300DPI resolution at the actual print size.</li>
				<li>A 3mm bleed must be added to the artwork if it bleeds off the product.</li>
 
			</ul>
		<?php }
		if($brandingMenuItem['title']=="Debossing") { ?>
			<div class="brandingImageRight"><img src="<?php echo base_url();?>Images/Branding/<?php echo $brandingMenuItem['imgUrl'];?>.png" width="100%" height="100%"  /></div>
            <div>&nbsp;</div>
            <div class="bodyText">Commonly referred to as ‘Blind’ debossing, a heated custom metal plate is pressed firmly onto the product leaving an impression of the artwork. Thermo debossing is also available on certain products, using additional heat to create a unique and eye-catching two-tone finish. </div>
            <div class="HeaderSmall">Advantages</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Higher perceived value than other forms of branding.</li> 
				<li>The branding becomes part of the product and is permanent.</li> 
				<li>The product can be shipped as soon as heat pressing is finished.</li> 
				<li>Certain products can produce a two-tone finish.</li>  
 
			</ul>
            <div class="HeaderSmall">Limitations</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 
				<li> Unable to print variable data such as individual naming. </li>
			</ul>
            <div class="HeaderSmall">Artwork Requirements</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important">  

				<li>The artwork must be supplied in vector format.</li>
				<li>Fonts are advised to be converted to outlines/objects to avoid font conflicts.</li> 
			 

			</ul>
		<?php }
		if($brandingMenuItem['title']=="Offset Print") { ?>
			<div class="brandingImageRight"></div>
            <div>&nbsp;</div>
            <div class="bodyText">Offset printing is a printing method in which images on metal plates are transferred (offset) to rubber rollers and then use to print the substrate. The product does not come into direct contact with the metal plates.</div>
		<?php }
		if($brandingMenuItem['title']=="Embroidery") { ?>
			<div class="brandingImageRight"><img src="<?php echo base_url();?>Images/Branding/<?php echo $brandingMenuItem['imgUrl'];?>.png" width="100%" height="100%"  /></div>
            <div>&nbsp;</div>
            <div class="bodyText">Embroidery is an excellent way of branding bags, apparel, and other textile products. It offers higher perceived value and a depth of branding quality which other processes cannot match. Embroidery uses rayon thread which is stitched into the product and has a slightly raised effect.</div>
            <div class="HeaderSmall">Advantages</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 
				<li>Only one setup charge applies per position for up to 12 thread colours.</li>
			</ul>
            <div class="HeaderSmall">Limitations</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Only approximate PMS colour matches are possible - the threads to be used are chosen from those available to give the closest possible match. <a href='/Downloads-folder/MadeiraColourChart.pdf' target='_blank'>See our thread colour chart</a> for the colours available.</li>
				<li>We recommend avoiding fine detail and font sizes which are less than 4mm high.</li>
				<li>Unable to print variable data such as individual naming.</li>
				<li>Metallic embroidery colours have special pricing.</li> 
				
		 
			</ul>
            <div class="HeaderSmall">Artwork Requirements</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 
				<li>Vector artwork is preferred.</li> 
				<li>Fonts are advised to be converted to outlines/objects to avoid font conflicts.</li> 
			</ul>
		<?php } 
		if($brandingMenuItem['title']=="Silicone Digital Print") { ?>
			<div class="brandingImageRight"><img src="<?php echo base_url();?>Images/Branding/<?php echo $brandingMenuItem['imgUrl'];?>.png" width="100%" height="100%"  /></div>
            <div>&nbsp;</div>
            <div class="bodyText">This production method is a CMYK+W digital branding process designed specifically for silicone surfaces. </div>
            <div class="HeaderSmall">Advantages</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Provides crisp, clear, high-definition artwork.</li>
				<li>Durable, flexible branding that can be hand washed.</li>
				<li>Perfect for printing dark coloured products as a layer of white ink can be printed under the artwork.</li>
				<li>Ideal for producing full colour images as well as approximate spot colour branding.</li>
				<li>Has a matt finish and does not crack or fade with typical use of product.</li>
				<li>Only one set up charge is required regardless of the number of print colours.</li>

				 
			</ul>
            <div class="HeaderSmall">Limitations</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Some colours cannot be reproduced including metallic and neon/fluorescent colours.</li>
				<li>Unable to print variable data.</li>
				<li>Minimum detail is advised to be no finer than 0.7mm.</li> 
 
			</ul>
            <div class="HeaderSmall">Artwork Requirements</div>
            <ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

				<li>Artwork can be supplied in either vector or bitmap format.</li>
				<li>Supplied bitmaps must be higher than 300DPI resolution at the actual print size.</li>
				<li>Fonts are advised to be converted to outlines/objects to avoid font conflicts.</li>

 
			</ul>
		<?php } 

		if($brandingMenuItem['title']=="Colourflex Transfer") { ?>
				<div class="brandingImageRight"><img src="<?php echo base_url();?>Images/Branding/<?php echo $brandingMenuItem['imgUrl'];?>.png" width="100%" height="100%"  /></div>
				<div>&nbsp;</div>
				<div class="bodyText">Colourflex transfers are a CMYK+W digital print process, used for branding apparel and fabrics. </div>
				<div class="HeaderSmall">Advantages</div>
				<ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 


					<li>Ideal for producing full colour images (including gradients) as well as approximate spot colour branding.</li>
					<li>High definition, vibrant matt finish artwork that is suitable on a range of garment fabrics.</li>
					<li>Eco-friendly water-based inks.</li>
					<li>Durable, flexible, and machine washable with a soft-touch matt finish.</li>
					<li>Efficient self-weeding technology.</li>
					<li>Only one set up charge is required regardless of the number of print colours.</li>
					<li>Can be shipped straight after being printed.</li> 
				</ul>
				<div class="HeaderSmall">Limitations</div>
				<ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

					<li>Some colours cannot be reproduced including metallic and neon/fluorescent colours.</li>
					<li>A thin, clear line of glue can sometimes be seen around the edges of the image.</li>
					<li>Unable to print variable data.</li>
					<li>Minimum detail advised at 1mm.	</li>

 
				</ul>
				<div class="HeaderSmall">Artwork Requirements</div>
				<ul class="bodyText" style="margin-top:5px !important; margin-bottom:0px !important"> 

						<li>Artwork can be supplied in either vector or bitmap format.</li>
						<li>Supplied bitmaps must be higher than 300DPI resolution at the actual print size.</li>
						<li>Fonts are advised to be converted to outlines/objects to avoid font conflicts.</li>

 
				</ul>
			<?php } ?>
		<!-- start popup content-->



      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
      </div>
    </div>
  </div>
</div>

<?php } ?>
<!-- Branding popup--> 


<!--login form --> 
<?php if($siteLogcheck['loggedIn'] == 1 && count($customArray['themeArray'])==0): ?>

	<div class="modal fade" id="dataImageModal" tabindex="-1" role="dialog" aria-labelledby="dataImageModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="dataImageModalLabel">Data &amp; Image Downloads</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h6>Product Image Downloads</h6>
				<ul>
					<li><a  href="<?=base_url()?>Images/Products.zip">Image Library Medium (recommended) (<?=$this->general_model->getFilesize(1)?>)  </a> </li>
					<li><a  href="<?=base_url()?>Images/ProductsLarge.zip">Image Library Large (<?=$this->general_model->getFilesize(3)?>)  </a> </li>
					<li><a href="<?=base_url()?>Images/New-Products.zip"  >New Item Image Library (<?=$this->general_model->getFilesize(2)?>) </a></li> 
				</ul>
					
				<h6>Product Data Downloads</h6>
				<ul>
						<li><a  href="/downloads/Excel/<?=$siteLogcheck['userDatas'][0]->Currency?>"  >Trends Data Format - <?=$siteLogcheck['userDatas'][0]->Currency?></a> </li>
						<li> <a  href="/downloads/APPA/<?=$siteLogcheck['userDatas'][0]->Currency?>"  >APPA Data Format - <?=$siteLogcheck['userDatas'][0]->Currency?></a></li>
						<li> <a   href='/downloads/Xebra/<?=$siteLogcheck['userDatas'][0]->Currency?>'  >XebraSource Data Format - <?=$siteLogcheck['userDatas'][0]->Currency?></a></li>
						<?php // if($siteLogcheck['userDatas'][0]->multiCurrency == 1): ?>
							<!--<li><a  href="/downloads/Excel/NZD"  >Trends Data Format - NZD</a> </li>
							<li><a href="/downloads/Excel/AUD"    >Trends Data Format - AUD </a></li> 
							<li> <a  href="/downloads/APPA/NZD"  >APPA Data Format - NZD</a></li>
							<li> <a   href="/downloads/APPA/AUD"   >APPA Data Format - AUD</a></li>
							<li> <a   href='/downloads/Xebra/NZD'  >XebraSource Data Format - NZD</a></li>
							<li> <a   href='/downloads/Xebra/AUD'  >XebraSource Data Format - AUD</a></li>-->
						<?php // endif; ?>
						<?php //if($siteLogcheck['userDatas'][0]->multiCurrency == 0):   ?>
							<!--<li><a href="/downloads/Excel/<?=$siteLogcheck['userDatas'][0]->Currency?>"   >Trends Data Format</a></li> 
							<li><a href="/downloads/APPA/<?=$siteLogcheck['userDatas'][0]->Currency?>">APPA Data Format</a></li> 
							<li><a href="/downloads/Xebra/<?=$siteLogcheck['userDatas'][0]->Currency?>">XebraSource Data Format </a></li> -->
						<?php //endif; ?>
				</ul>

			</div>
			<!--<div class="modal-footer">
			
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
			</div>-->
			</div>
		</div>
	</div>

	<!-- Visual Request-->		
	<?php if(count($customArray['themeArray'])==0  &&   $siteLogcheck['loggedIn'] == 1): ?>   
		<div class="modal fade modal-visual" id="visualRequestsModal" tabindex="-1" role="dialog" aria-labelledby="visualRequestsModalLabel" aria-hidden="true" ng-click="hideVisualSuccess()" >
			<div class="modal-dialog" role="document">
				<div class="modal-content"> 

					<div class="modal-header paddingless">
						 
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					 
					<div class="modal-body " >   
						<p class="text-center" ng-if="loadingEffects == true"> <img src="<?php echo base_url();?>Images/loading-img.gif" width="50" height="50"/> </p>

						
						<form ng-submit="addVisualItem(userID)" ng-if="loadingEffects == false">
							
							<div class="row margin-bottom" >
								<div class="col-md-6 border-right">
									<h4 class="modal-title underline-bottom margin-bottom">Visualisation Request</h4> 
										
									 
										 
										<div class="form-group">
											<label for="ProjectName">Project Name:</label>
											<input type="text" class="form-control projectInputs" id="ProjectName"  ng-model="visualFormData.projectName" > 
										</div>
										<div class="form-group">
											<label for="ProjectInstructions">Project Instructions:</label>
											<textarea class="form-control projectInputs" id="ProjectInstructions" rows="1"  ng-model="visualFormData.instructions" ></textarea>
										</div>

										<?php if($siteLogcheck['userDatas'][0]->visualAccess == 1): ?> 
											<div class="form-group">
												<label for="ProjectInstructions"><span class="text-danger">*</span>Visual Type:</label>
												<select ng-model="visualFormData.VisualType"    class="form-control"> 
															<option ng-repeat="type in VisualTypeSelect"  ng-value="type">{{type}}</option>
												</select>
											</div>
										 
										<?php endif; ?>

										<div class="form-group" ng-if="visualUpdateBtn">
											<button type="button" class="btn btn-sm btn-primary" ng-click="updateProjectDetails(visualFormData.projectName, visualFormData.instructions)" >Update</button>
										</div>

										<div class="form-group">
											<label   for="ProjectInstructions">Logos/Artwork Files:  </label>

												<div class="file btn btn-sm btn-primary uploadartwork  pull-right" ng-app="fileUpload">
													<span ng-if="done"> <i class="fa fa-check  check"></i> </span>Upload Logos/Artwork
													<input type="file" name="file" ngf-select ng-model="picFile" name="file"  ng-change="uploadArtwork(visualFormData.projectName, visualFormData.instructions, userID, picFile)"    accept=".gif,.png,.jpg,.jpeg,.pdf,.ai,.cdr,.zip,.rar,.7z,.eps"  ngf-model-invalid="errorFile"/>
												</div>
																 
											<div class="logoArtworkBox">
												<ul>
													<li ng-repeat="file in userVisualFiles" class="relative" id="artworkFile_{{$index}}"> <span> {{file.visualFiles}} <span> <span class="artwork_delete" ng-click="deleteArtwork(userID, file.visualFiles, $index)"><i class="fa  fa-trash"></i></span> </li>
												</ul>	
											</div>	
										</div> 
										<div class="form-group">
											<label for="ProjectInstructions">Items to Visualise: </label><span class="countItemVisuals pull-right">{{countItem}}/{{countItemLimit}}</span>
											<div class="ItemsToVisualise" style="max-height:200px; min-height:200px">

												<!--Item Card-->
												<div class="card visual-items" style="width: 100%;" ng-repeat="requests in userVisualRequests" id="visualItems_{{$index}}"> 
													<span class="delete_items" ng-click="deleteItems(requests.uid, $index)" ng-show="deleteVisualButton" ><i class="fa  fa-trash"></i></span>
													<div class="card-body">
														<h6 class="card-title">{{requests.itemName}} - {{requests.itemCode}}</h6>
														<ul>
															<li  ><div class="row"><div class="col-md-4">Item Colours:</div> <div class="col-md-8">   <input  ng-click="getProductColoursVisual(requests.itemCode, requests.itemCols, requests.uid)"  type="text" class="form-control " id="itemCols_{{requests.uid}}"  ng-model="requests.itemCols"  readonly alt="Select Item Colours below" >  </div></div> <span class="editPen itemCols{{requests.uid}}" style="display:none"><i class="fa text-success fa-check"></i> </span> 
																<button type="button" class="close btn-primary font-15 float-left alertitemcolour itemcolour_{{requests.uid}}" aria-label="Close" style="display:none" ng-click="closeVisualDropdownOption()" >
																	<span aria-hidden="true">&times;</span> 
																</button>
																<div class="relative alert alert-secondary logoArtworkBox alertitemcolour itemcolour_{{requests.uid}}"  style="display:none" id="itemcolour_{{requests.uid}}"  >
																	
																	<ul> 
																		<li   	class="cursorpoint"
																				ng-repeat="avcolours in availableColoursVisual"
																				ng-click="updateThisItemVisual(requests.uid, 'itemCols', avcolours)">
																				{{avcolours}}
																		</li>
																	</ul>	
																</div>
															</li>
															<li  ><div class="row"><div class="col-md-4">Branding Option:</div> <div class="col-md-8">  <input ng-click="getProductColoursBranding(requests.itemCode, requests.itemCols, requests.uid)"  type="text" class="form-control " id="printOpt_{{requests.uid}}"  ng-model="requests.printOpt" readonly alt="Select Branding Option below"  > </div></div> <span class="editPen printOpt{{requests.uid}}" style="display:none"><i class="fa text-success fa-check"></i> </span>
																<button type="button" class="close btn-primary font-15 float-left alertbrandingcolour brandingcolour_{{requests.uid}}" aria-label="Close" style="display:none" ng-click="closeVisualDropdownOption()" >
																	<span aria-hidden="true">&times;</span> 
																</button>
																<div class="alert alert-secondary logoArtworkBox alertbrandingcolour brandingcolour_{{requests.uid}}"  style="display:none" id="brandingcolour_{{requests.uid}}"  >

																		<ul> 
																			<li   	class="cursorpoint"
																					ng-repeat="brand in newBrandingVisualize"
																					ng-click="updateThisItemBranding(requests.uid, 'printOpt', brand)">
																					{{brand}}
																			</li>
																		</ul>	

																</div>
														
														
															</li>
															<!--<li data-toggle="tooltip" data-placement="left" title="Click to edit"><div class="row"><div class="col-md-4">Branding Position:</div> <div class="col-md-8"> <input type="text" class="form-control " id="printPos_{{requests.uid}}"  ng-model="requests.printPos" ng-change="updateThisItem(requests.uid, 'printPos', requests.printPos)" > </div></div> <span class="editPen printPos{{requests.uid}}" style="display:none"><i class="fa text-success fa-check"></i> </span></li>-->
															<li  ><div class="row"><div class="col-md-4">Print Colours:</div> <div class="col-md-8">   <input type="text" class="form-control " id="printCols_{{requests.uid}}"  ng-model="requests.printCols" ng-change="updateThisItem(requests.uid, 'printCols', requests.printCols)" ></div></div> <span class="editPen printCols{{requests.uid}}" style="display:none"><i class="fa text-success fa-check"></i> </span></li>
															<li  ><div class="row"><div class="col-md-4">Other Instructions:</div> <div class="col-md-8">    <input type="text" class="form-control " id="instructionsItem_{{requests.uid}}"  ng-model="requests.instructionsItem" ng-change="updateThisItem(requests.uid, 'instructionsItem', requests.instructionsItem)" ></div></div> <span class="editPen instructionsItem{{requests.uid}}" style="display:none"><i class="fa text-success fa-check"></i> </span></li>
														</ul>	 
													</div>
												</div>

												
												<!--Item Card-->

											</div>	
										</div>
										
									
								</div>
								<div class="col-md-6">
									<h4 class="modal-title ">Add Item  </h4>
									<span class="text-danger underline-bottom "> <small>(*)Required fields</small></span>
									 
									


									<div class="row margin-top" ng-if="itemVisualiseActive">
										<div class="col-md-12"> 

											<div class="form-group">
													<label for="ProductA"><span class="text-danger">*</span>Product:</label>
													<select ng-model="visualFormData.productItem" ng-change="getProductColours(visualFormData.productItem)"   class="form-control">
														<option value="">Select Item</option>
														<option ng-repeat="itemList in userVisualItems" ng-value="itemList.Code">{{itemList.Name}}</option>
													</select>
											</div>	
											<div class="form-group">
													<label for="ProductB"><span class="text-danger">*</span>Item Colour:  </label>
													<!--<input type="text" class="form-control ItemColour" id="ItemColour"  ng-model="visualFormData.ItemColour" > 
													<small ng-if="availableColours"><strong>Available Colours:</strong> {{availableColours}} </small>-->
													<select class="form-control" ng-model="visualFormData.ItemColour" ng-disabled = "!availableColours" >
														<option   
																ng-repeat="avcolours in availableColours"
																value="{{avcolours}}">
																{{avcolours}}
														</option>
													</select>
											</div>
											<div class="form-group"> 
													<label for="ProductC"><span class="text-danger">*</span>Branding Option:  </label>
													<!--<input type="text" class="form-control BrandingOption" id="BrandingOption"  ng-model="visualFormData.BrandingOption" > 
													
													<small ng-if="availableBrandingOption" class="fullline"><strong >Available Branding Options: <br /></strong> </small>
													<small ng-if="availableBrandingOption"  ng-repeat="brand in availableBrandingOption"  > 
														<span class="fullline" ng-bind-html="brand | trust"></span>  
													</small> -->
													<select class="form-control" ng-model="visualFormData.BrandingOption"  ng-disabled = "!newBranding" >
														<option value="">Select Branding</option>
														<option   
																ng-repeat="brand in newBranding"
																value="{{brand}}">
																{{brand}}
														</option>
													</select>
											</div>

											<!--<div class="form-group">
													<label for="ProductD">Branding Position:</label>
													<input type="text" class="form-control BrandingPosition" id="BrandingPosition"  ng-model="visualFormData.BrandingPosition" > 
													
											</div>-->

											<div class="form-group">
													<label for="ProductE">Print Colour(s):</label>
													<input type="text" class="form-control PrintColours" id="PrintColours"  ng-model="visualFormData.PrintColours" > 
													
											</div>

											<div class="form-group">
													<label for="ProductF">Item Instructions:<br />
														<small>If you wish to show multiple branding options on this visual, please note the additional branding options here.</small>
													</label>
												 
													<input type="text" class="form-control ItemInstructions" id="ItemInstructions"  ng-model="visualFormData.ItemInstructions" > 
													
											</div>
												
											<button type="submit" class="btn btn-sm btn-primary" ng-if="visualFormData.productItem && visualFormData.ItemColour  && visualFormData.BrandingOption">Add Item</button> <span ng-hide="visualFormData.productItem && visualFormData.ItemColour  && visualFormData.BrandingOption " class="btn btn-sm btn-light btn-disabled"  disabled="disabled">Add Item </span> 
										
										</div>
									</div>
									<p ng-if="!itemVisualiseActive">You are not allowed to add more than {{countItemLimit}} items to Visualise.
									
								</div>
							</div>
							<div class="alert alert-dark text-center" role="alert" ng-show="visualSubmitted" >
								<i class="fa fa-check  check"></i> Your request has been submitted
							</div>

						<button type="button" class="btn btn-primary" ng-click="sendToEmail(userID)"   ng-disabled="!userVisualFiles || countItem == 0"><i class="fa  fa-envelope"></i> Send</button> 
						<!--<button type="button" class="btn btn-secondary pull-right" data-dismiss="modal">Close</button> -->
						
						</form>

						

					</div> 
				</div>
			</div>
		</div>  
	<?php endif; ?>
	<!-- Visual Request-->

<!-- Mailing modal-->
<div class="modal fade" id="mailingListModal" tabindex="-1" role="dialog" aria-labelledby="mailingListModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
			<div class="modal-header">
				<h5 class="modal-title" id="dataImageModalLabel">Mailing List Subscribe</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
      <div class="modal-body text-center"> 
	  
	



						<div id="carouselMailingControls" class="carousel slide" data-ride="carousel" data-interval="false">
							<div class="carousel-inner">
								<div class="carousel-item active subscribe" style="min-height:590px">  
									 	<!--<div class="mobile-container">
											<iframe src="https://confirmsubscription.com/h/y/1032343E066339C4" ng-if="iframeMail" class="campaignFrame" scrolling="no" style="min-height:620px"></iframe>  
										</div>--> 



													   
										<div class style="min-height: calc(100vh - 25rem);  background: #dddddd;">
											<div class="l-center-container"> <div>
												<div class="sc-bdVaJa iIDDUy">
													<div>
														<form class="js-cm-form" id="subForm" class="js-cm-form" action="https://www.createsend.com/t/subscribeerror?description=" target="_blank" method="post" data-id="191722FC90141D02184CB1B62AB3DC2638BF9D97DC2416DB53B9DF2D7B4563BA7B5387B13EFC0E9086F2965B1BEA9B0EA0F8E5784263C6ED2786102849122660">
																<div size="base" class="sc-jzJRlG bMslyb">
																	<div size="small" class="sc-jzJRlG liOVdz">
																		<div>
																			<label size="0.875rem" color="#5d5d65" class="sc-gzVnrw dEVaGV">Name <span class="sc-dnqmqq iFTUZ">*</span></label>
																			<input aria-label="Name" id="fieldName" maxLength="200" name="cm-name" required class="sc-iwsKbI iMsgpL" />
																		</div>
																	</div>
																	<div size="small" class="sc-jzJRlG liOVdz">
																		<div>
																			<label size="0.875rem" color="#5d5d65" class="sc-gzVnrw dEVaGV">Email <span class="sc-dnqmqq iFTUZ">*</span></label>
																			<input autoComplete="Email" aria-label="Email" id="fieldEmail" maxLength="200" name="cm-trjdtt-trjdtt" required type="email" class="js-cm-email-input qa-input-email sc-iwsKbI iMsgpL" />
																		</div>
																	</div>
																	<div size="small" class="sc-jzJRlG liOVdz">
																		<div>
																			<label size="0.875rem" color="#5d5d65" class="sc-gzVnrw dEVaGV">Company <span class="sc-dnqmqq iFTUZ">*</span></label>
																			<input aria-label="Company" id="fieldpyklyk" maxLength="200" name="cm-f-pyklyk" required class="sc-iwsKbI iMsgpL" />
																		</div>
																	</div>
																	<div size="small" class="sc-jzJRlG liOVdz">
																		<div>
																			<label size="0.875rem" color="#5d5d65" class="sc-gzVnrw dEVaGV">Country <span class="sc-dnqmqq iFTUZ">*</span></label>
																			<div class="sc-gZMcBi bvxAqN">
																				<select aria-label="Country" id="fieldpykljt" name="cm-fo-pykljt" required value class="sc-gqjmRU iQJYdv">
																					<option disabled selected value>Select...</option>
																					<option value="657916">New Zealand</option>
																					<option value="657917">Australia</option>
																				</select>
																				<svg aria-hidden="true" class="sc-VigVT ksvdB" fill="currentColor" viewBox="2 0 10 14">
																					<path d="M4.95 4.07L2.12 1.244c-.39-.39-1.023-.39-1.413 0-.39.39-.39 1.024 0 1.414L3.95 5.9c.187.187.44.292.707.292h.585c.266 0 .52-.105.708-.292l3.242-3.243c.39-.39.39-1.024 0-1.414-.39-.39-1.024-.39-1.414 0L4.95 4.07z" fill-rule="evenodd" transform="translate(0 4)"></path>
																				</svg>
																			</div>
																		</div>
																	</div>
																	<div size="small" class="sc-jzJRlG liOVdz">
																		<div>
																			<label size="0.875rem" color="#5d5d65" class="sc-gzVnrw dEVaGV">Customer Success Manager <span class="sc-dnqmqq iFTUZ">*</span></label>
																			<div class="sc-gZMcBi bvxAqN">
																				<select aria-label="Customer Success Manager" id="fieldyduyydt" name="cm-fo-yduyydt" required value class="sc-gqjmRU iQJYdv">
																					<option disabled selected value>Select...</option>
																					<option value="1304373">Susan Pillifeant</option>
																					<option value="1304374">Carla Humphreys</option>
																					<option value="1304375">Richard Bevin</option>
																					<option value="1311394">Kimberley Stewart</option>
																				</select>
																				<svg aria-hidden="true" class="sc-VigVT ksvdB" fill="currentColor" viewBox="2 0 10 14"><path d="M4.95 4.07L2.12 1.244c-.39-.39-1.023-.39-1.413 0-.39.39-.39 1.024 0 1.414L3.95 5.9c.187.187.44.292.707.292h.585c.266 0 .52-.105.708-.292l3.242-3.243c.39-.39.39-1.024 0-1.414-.39-.39-1.024-.39-1.414 0L4.95 4.07z" fill-rule="evenodd" transform="translate(0 4)"></path>
																			</svg>
																		</div>
																	</div>
																</div>
																<div size="base" class="sc-jzJRlG bMslyb"></div>
															</div>
															<button size="1rem" color="#fff" type="submit" class="btn btn-primary ">Subscribe</button>
														</form>
														</div>
													</div>
												</div>
											</div>
										</div>
										<style>
											.iIDDUy {
												background: rgb(255, 255, 255);
												border-radius: 0.3125rem;
												max-width: 35.25rem;
												margin-left: auto;
												margin-right: auto;
												padding: 2.5rem 2.75rem;
												position: relative;
											}

											.dEVaGV {
											
												display: block;
												font-size: 0.875rem;
												font-weight: 400;
												margin-bottom: 0.5rem;
												text-align:left;
											}

											.iFTUZ {
												color: rgb(221, 54, 42);
											}

											.iMsgpL {
												-webkit-appearance: none;
												background-color: rgb(255, 255, 255);
												border: 0px;
												border-radius: 0.1875rem;
												box-sizing: border-box;
												box-shadow: rgba(142, 154, 173, 0.1) 0px 2px 0px 0px inset, rgb(210, 215, 223) 0px 0px 0px 1px inset, rgb(255, 255, 255) 0px 1px 0px 0px;
												color: rgb(67, 77, 93);
												font-size: 0.875rem;
												line-height: 1.5;
												min-height: 2.8125rem;
												outline: 0px;
												padding: 0.75rem 1rem;
												transition: box-shadow 0.2s ease 0s;
												width: 100%;
											}

											.iMsgpL:focus {
												box-shadow: transparent 0px 0px 0px 0px inset, rgb(80, 156, 246) 0px 0px 0px 1px inset, rgba(80, 156, 246, 0.25) 0px 0px 0px 2px;
											}

											.bvxAqN {
												background-color: rgb(250, 250, 251);
												border-radius: 0.1875rem;
												box-shadow: rgb(255, 255, 255) 0px 2px 0px 0px inset, rgb(210, 215, 223) 0px 0px 0px 1px, rgba(142, 154, 173, 0.1) 0px 3px 0px 0px;
												display: block;
												position: relative;
											}

											.iQJYdv {
												-webkit-appearance: none;
												background: transparent;
												border: 0px;
												box-sizing: border-box;
												color: rgb(67, 77, 93);
												cursor: pointer;
												display: block;
												font-size: 0.875rem;
												min-height: 2.8125rem;
												outline: 0px;
												padding: 0.75rem 2.5rem 0.75rem 1rem;
												text-align: left;
												transition: box-shadow 0.2s ease 0s;
												width: 100%;
											}

											.iQJYdv:focus {
												box-shadow: transparent 0px 0px 0px 0px inset, rgb(80, 156, 246) 0px 0px 0px 1px inset, rgba(80, 156, 246, 0.25) 0px 0px 0px 2px;
											}

											.ksvdB {
												color: rgb(142, 154, 173);
												height: 1rem;
												line-height: 0;
												max-height: 100%;
												max-width: 100%;
												pointer-events: none;
												position: absolute;
												right: 1rem;
												top: 50%;
												transform: translateY(-50%);
												width: 1rem;
											}

											.bMslyb {
												margin-bottom: 1.5rem;
											}

											.liOVdz {
												margin-bottom: 1rem;
											}

											.dLkilY {
												margin-left: auto;
												margin-right: auto;
												max-width: 29.125rem;
												padding-bottom: 3.125rem;
											}

											.wSZJN {
												font-size: 3rem;
												text-align: center;
												letter-spacing: -1px;
												line-height: 1.17;
												-webkit-font-smoothing: antialiased;
												font-weight: 900;
												font-family: Lato, sans-serif;
												color: rgb(0, 0, 0);
											}

											.jHkwuK {
												background-color: rgb(123, 177, 61);
												border: none;
												border-radius: 3px;
												color: rgb(255, 255, 255);
												display: inline-block;
												font-family: Helvetica, Arial, sans-serif;
												font-size: 1rem;
												font-style: normal;
												font-weight: 700;
												line-height: 1;
												outline: 0px;
												padding: 0.75rem 1.5rem;
												text-decoration: none;
												transition: background-color 0.1s ease-in 0s, box-shadow 0.1s ease-in 0s;
											}

											.jHkwuK:hover {
												cursor: pointer;
											}
									

											</style>
											<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
											<script>WebFont.load( {
												google: {
													families: ['Lato:900:latin', 'Lato:300:latin', 'Playfair+Display:700italic:latin', 'Merriweather:700:latin', 'Crete+Round::latin', 'PT+Sans+Narrow:700:latin']
												}
											} );
											</script><script type="text/javascript" src="https://js.createsend1.com/javascript/copypastesubscribeformlogic.js"></script>
				
















									 	
								</div>
								<div class="carousel-item"> 

								<form name="unsubForm" target="_blank" class="emailForm" id="unsubForm" action="https://trendscollection.createsend.com/t/y/u/trjdtt/" method="post">
									<div class="row">
										<div class="col-md-3">
											<label for="fieldEmail2" class="cmLabel">
												Email
												<span class="cmds-input-help-text--error">*</span>
											</label>
										</div>
										<div class="col-md-5">
											<input id="fieldEmail2" name="cm-trjdtt-trjdtt" type="email" class="cmTextbox form-control" />
										</div>
										<div class="col-md-4">
											<button type="submit" class="btn btn-sm btn-primary">
												<span class="cmButton__inner">Unsubscribe</span>
											</button>
										</div>	
									</div>
								</form> 

									 

								</div> 
							</div> 
						</div> 
						<p class="margin-top"><a  href="#carouselMailingControls" role="button" data-slide="prev"> Subscribe </a> | <a  href="#carouselMailingControls" role="button" data-slide="next">  Unsubscribe  </a></p>
						 
		  	<!--<button type="button" class="btn btn-secondary pull-right" data-dismiss="modal">Close</button> -->
      </div> 
    </div>
  </div>
</div> 
<!--  Mailing modal-->


<!-- Reset User PW modal-->
<div class="modal fade" id="resetUserPWModal" tabindex="-1" role="dialog" aria-labelledby="resetUserPWModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
			<div class="modal-header">
				<h5 class="modal-title" id="resetUserPWModalLabel">Change Password</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
      <div class="modal-body "> 
	  
		<form ng-submit="resetUserPW(userID)" >
			 
			<div class="form-group">
				<label for="OldInputPassword1">Old Password <small class="text-danger" ><span ng-bind-html="oldPWMsg | trust"  ></span></small> </label>
				<input type="password" class="form-control" id="OldInputPassword1" ng-model="resetUserPWForm.oldpw" ng-change="checkOldPW(resetUserPWForm.oldpw)"  >
			</div>
			<div class="form-group">
				<label for="InputPassword1">Enter New Password</label>
				<input type="password" class="form-control" id="InputPassword1" ng-disabled="updateUserPW1" ng-model="resetUserPWForm.pw1" ng-change="checkNewPW(resetUserPWForm.pw1, resetUserPWForm.pw2)"  >
			</div>
			<div class="form-group">
				<label for="InputPassword2">Confirm New Password</label>
				<input type="password" class="form-control" id="InputPassword2" ng-disabled="updateUserPW2" ng-model="resetUserPWForm.pw2" ng-change="checkNewPW(resetUserPWForm.pw1, resetUserPWForm.pw2)" >
			</div>

			<p ng-if="userResetPWMsg"><small class="text-danger" >{{userResetPWMsg}}</small></p>

			<div ng-if="correct">
				 <p class="text-center"> <img src="<?php echo base_url();?>Images/loading-img.gif" width="50" height="50"/> </p>
			</div>	
			 
			<button type="submit" class="btn btn-primary pull-right" ng-disabled="updateUserPWBtn">Update</button>
		</form>

			 <!--<button type="button" class="btn btn-secondary pull-right" data-dismiss="modal">Close</button> -->
      </div> 
    </div>
  </div>
</div> 
<!-- Reset User PW modal-->



<!-- PMS modal-->
<div class="modal fade" id="PMSmodal" tabindex="-1" role="dialog" aria-labelledby="PMSModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
		<div class="modal-header"> 
			<h5 class="modal-title" id="PMSModalLabel">PMS Colours - {{pmsData.Title}}</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
      	</div>
      <div class="modal-body"> 
			   
	  				<p>Kindly Note</p>
	        		<ul class="pms-li" >
	        			<li>PMS colours are indicative only and should be use as a guide only</li>
						<li>Product colours can vary slightly between batches of stock</li>
						<li>If an order is colour critical, we highly recommend ordering a sample</li>
					</ul>	
					
					<div class=" margin-top " ng-class="pmsDataLength >= 11 ? 'pms-container-scroll' : 'pms-container'">
						<table class="table table-bordered table-sm table-striped table-pms">
							<thead class="thead-dark">
								<tr>
									<th scope="col">Item</th>
									<th scope="col">Approx PMS</th> 
								</tr>
							</thead>
							<tbody>
								
								<tr ng-repeat="pms in pmsData.pmsTables"  > 
									<td>{{pms.PartName}}</td>
									<td>{{pms.PmsCode}}</td>
								</tr>
								
							</tbody>
						</table>
					</div>	
			  
			  
	  </div> 
	  
    </div>
  </div>
</div> 
<!-- PMS modal-->











<!-- POPUP FOR TRANSIT TIMES --> 

<!-- Modal -->
<div class="modal fade trendsModal" id="transitModal" tabindex="-1" role="dialog" aria-labelledby="transitModalLabel" aria-hidden="true" style=" background-color: rgba(0, 0, 0, 0.5);  " ng-if="CurrencyUpdate == 'AUD' ">
  <div class="modal-dialog transitModal-width" role="document">
    <div class="modal-content"> 
		
			<div class="modal-header"> 
					<h5>Transit Times</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
      
      <div class="modal-body" ng-click="hideDropdown()" >
	  	  

			<div class="row"  > 
				<div class=" col-md-12"> 
					
					<div class="row row-no-padding table-transit-search">
						<div class="col-md-4 text-right">
							<span class="display-block position-top text-trend" ng-show="inputSearchBox || inputSearchResult">Delivery Suburb:</span>
							 

						</div>
						<div class="col-md-7">  
							<span class="result-transit" ng-click="showInputSearch()" ng-show="inputSearchResult"> {{ausTransitNew}} <span class="search-icon-input"><i class="fa fa-search"></i></span> </span>
							
							<span ng-if="loadingMsg">Loading...</span>
							<form ng-show="inputSearchBox" ng-if="getMelbourneTransit">
								<div class="form-group searchbox-control" > 
									<input type="text" class="form-control col-md-12" id="searchTransits"  ng-show="inputSearchBox" ng-focus="showDropdown(ausTransit)" ng-click="$event.stopPropagation()" ng-change="showDropdown(ausTransit)"  placeholder="Search postcode or suburb" ng-model="ausTransit"     > 
									<div class="dropdown-control" ng-show="dropDown"> 
										<div class="dropdown-container-control">
											<ul class="search-results-control">
												<li   ng-repeat="transit in getMelbourneTransit | filter: ausTransit | limitTo:25" ng-click="getSearchMelbourne(transit.Combined )"   > <span >  {{transit.Combined}} </span> </li>  
											</ul>
										</div>	
									</div>	
								</div> 
							</form>  


							<form ng-show="inputSearchBox" ng-if="getAUTransit">
								<div class="form-group searchbox-control" > 
									<input type="text" class="form-control col-md-12" id="searchTransit"  ng-show="inputSearchBox" ng-focus="showDropdown(ausTransit)" ng-click="$event.stopPropagation()" ng-change="showDropdown(ausTransit)"  placeholder="Search postcode or suburb" ng-model="ausTransit"     > 
									<div class="dropdown-control" ng-show="dropDown">
										<div class="dropdown-container-control">
											<ul class="search-results-control">
												<li   ng-repeat="transit in getAUTransit | filter: ausTransit | limitTo:25" ng-click="getSearch(transit.Combined, transit.State)"   > <span >  {{transit.Combined}} | {{transit.State}} </span> </li>  
											</ul>
										</div>	
									</div>	
								</div> 
							</form>  


 
 
						</div>
					</div>	

					

					<!-- MELBOURNE -->
							
					<p class=" margin-top" ng-show="showTableTransitMelbourne"> <i class="fa  fa-check text-success"></i> {{ausTransitNew}}  </p>
					<div class="datagrid " ng-show="showTableTransitMelbourne"  >  
						<div class="table-responsive">
							<table class="table table-items result-table  table-striped  table-bordered table-sm" width="510" border="0" cellspacing="0" cellpadding="0" >
								<thead class="thead-dark">
									<tr>
										<th colspan="{{FinalFreightCostsCount}}" align="center"> TRANSIT TIMES  </th>
									</tr>
								</thead>
								<tbody>
									<tr >
										<td ng-repeat="freightTransit  in FinalFreightCosts"  ng-if="(freightTransit.hideCarrier != 1   && freightTransit.shipCarrier != 'Startrack') " width="33%" align="center"><span>{{freightTransit.shipName}} </span></td> 
									</tr>
									<tr> 
										<td ng-repeat="freightTransit  in FinalFreightCosts"  ng-if="(freightTransit.hideCarrier != 1   && freightTransit.shipCarrier != 'Startrack')" width="33%" align="center"> 
											<span class="font-15 font-italic" ng-if="freightTransit.shipName == 'Economy' ">{{EconomyDataM}}</span> 
										</td>
									</tr>
								</tbody>		

							</table>
						</div>	
						
					</div>
					<p ng-show="showTableTransitMelbourne" >&nbsp;</p>

					<!--MELBOURNE --> 


  
				 
					<p class=" margin-top" ng-show="showTableTransit"> <i class="fa  fa-check text-success"></i> {{ausTransitNew}}  </p>
					<div class="datagrid " ng-show="showTableTransit"  > 
						<div class="table-responsive"> 
							<table class="table table-items result-table   table-striped  table-bordered table-sm" width="510" border="0" cellspacing="0" cellpadding="0" >
								<thead class="thead-dark">
									<tr>
										<th colspan="{{FinalFreightCostsCount}}" align="center">TRANSIT TIMES </th>
									</tr>
								</thead>
								<tbody>
									<tr >
										<td ng-repeat="freightTransit  in FinalFreightCosts"  ng-if="(freightTransit.hideCarrier != 1   && freightTransit.shipCarrier != 'Startrack') " width="33%" align="center"><span>{{freightTransit.shipName}} </span></td> 
									</tr>
									<tr> 
										<td ng-repeat="freightTransit  in FinalFreightCosts"  ng-if="(freightTransit.hideCarrier != 1   && freightTransit.shipCarrier != 'Startrack')" width="33%" align="center"> 
											<span class="font-15 font-italic" ng-if="freightTransit.shipName == 'Economy' ">{{EconomyData}}</span> 
											<span class="font-15 font-italic" ng-if="freightTransit.shipName == 'TNT' ">{{EconomyData}}</span>
											<span class="font-15 font-italic" ng-if="freightTransit.shipName == 'Priority' ">{{PriorityData}}</span>
											<span class="font-15 font-italic" ng-if="freightTransit.shipName == 'Regional Express' ">{{ExpressData}}</span>
										</td>
									</tr>
								</tbody>		

							</table>
						</div>	
						
					</div>
					<p ng-show="showTableTransit" >&nbsp;</p>

					<div class="datagrid "   > 
						<form name="freightCost">
							<div class="table-responsive">
								<table class="table table-items table-striped  table-bordered table-sm"    >
									<thead class="thead-dark">
										<tr>
											<th colspan="7" align="center" >FREIGHT COSTS  </th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td width="25%" align="left">Quantity  </td>
											<td width="12%" align="center" class="whitebackground">   <input type="text" name="inputQuantity1" class="col-md-12 adjustpadding text-center {{CurrencyUpdate}}priceSummary7 bgquantity1" id="{{CurrencyUpdate}}priceSummary7"   allow-only-numbers  ng-model="priceResults.Quantity1" ng-keydown="changeTab($event, 7, 3)"   ng-change="includeSetup(incSetup); noAdditionalCost(priceResults.Quantity1, '1')" ng-disabled="disabledQty1"   ng-value="priceResults.Quantity1">  </td>
											<td width="12%" align="center" class="whitebackground" >  <input type="text" name="inputQuantity2" class="col-md-12 adjustpadding text-center {{CurrencyUpdate}}priceSummary8 bgquantity2" id="{{CurrencyUpdate}}priceSummary8"   allow-only-numbers  ng-model="priceResults.Quantity2"  ng-keydown="changeTab($event, 8, 3)" ng-change="includeSetup(incSetup); noAdditionalCost(priceResults.Quantity2, '2')"  ng-disabled="disabledQty2" ng-value="priceResults.Quantity2">  </td>
											<td width="12%" align="center" class="whitebackground" >  <input type="text" name="inputQuantity3" class="col-md-12 adjustpadding text-center {{CurrencyUpdate}}priceSummary9 bgquantity3" id="{{CurrencyUpdate}}priceSummary9"   allow-only-numbers  ng-model="priceResults.Quantity3"  ng-keydown="changeTab($event, 9, 3)" ng-change="includeSetup(incSetup); noAdditionalCost(priceResults.Quantity3, '3')" ng-disabled="disabledQty3"  ng-value="priceResults.Quantity3">  </td>
											<td width="12%" align="center" class="whitebackground" >  <input type="text" name="inputQuantity4" class="col-md-12 adjustpadding text-center {{CurrencyUpdate}}priceSummary10 bgquantity4" id="{{CurrencyUpdate}}priceSummary10"   allow-only-numbers  ng-model="priceResults.Quantity4"  ng-keydown="changeTab($event, 10, 3)" ng-change="includeSetup(incSetup); noAdditionalCost(priceResults.Quantity4, '4')" ng-disabled="disabledQty4"   ng-value="priceResults.Quantity4">  </td>
											<td width="12%" align="center" class="whitebackground" >  <input type="text" name="inputQuantity5" class="col-md-12 adjustpadding text-center {{CurrencyUpdate}}priceSummary11 bgquantity5" id="{{CurrencyUpdate}}priceSummary11"  allow-only-numbers  ng-model="priceResults.Quantity5"  ng-keydown="changeTab($event, 11, 3)" ng-change="includeSetup(incSetup); noAdditionalCost(priceResults.Quantity5, '5')"  ng-disabled="disabledQty5"  ng-value="priceResults.Quantity5">  </td>
											<td width="12%" align="center" class="whitebackground" >  <input type="text" name="inputQuantity6" class="col-md-12 adjustpadding text-center {{CurrencyUpdate}}priceSummary12 bgquantity6" id="{{CurrencyUpdate}}priceSummary12"  allow-only-numbers  ng-model="priceResults.Quantity6" ng-keydown="changeTab($event, 12, 3)"  ng-change="includeSetup(incSetup); noAdditionalCost(priceResults.Quantity6, '6')"  ng-disabled="disabledQty6"  ng-value="priceResults.Quantity6">  </td> 
											
										</tr>
										<!--New freight cost table row result here -->
										<tr ng-repeat="freight  in FinalFreightCosts"  ng-if="freight.hideCarrier != 1"  >	
											<td width="25%" align="left">    <span > {{freight.shipName}}   </span>  </td> 
											<td width="12%" align="center"><span ng-if="headingQuantity1 != 0"  ng-show="hideMOQ1 || hideFreight1"> <span ng-if="freight.FreightCost1 == 'FREE' ">FREE</span> <span ng-if="freight.FreightCost1 != 'FREE' "> ${{freight.FreightCost1 | number : 2}} </span>   </span> </td> 
											<td width="12%" align="center"><span ng-if="headingQuantity2 != 0"  ng-show="hideMOQ2 || hideFreight2"> <span ng-if="freight.FreightCost2 == 'FREE' ">FREE</span> <span ng-if="freight.FreightCost2 != 'FREE' "> ${{freight.FreightCost2 | number : 2}} </span>   </span> </td>
											<td width="12%" align="center"><span ng-if="headingQuantity3 != 0"  ng-show="hideMOQ3 || hideFreight3"> <span ng-if="freight.FreightCost3 == 'FREE'  ">FREE</span> <span ng-if="freight.FreightCost3 != 'FREE' "> ${{freight.FreightCost3 | number : 2}} </span>   </span> </td>
											<td width="12%" align="center"><span ng-if="headingQuantity4 != 0"  ng-show="hideMOQ4 || hideFreight4"> <span ng-if="freight.FreightCost4 == 'FREE' ">FREE</span> <span ng-if="freight.FreightCost4 != 'FREE' "> ${{freight.FreightCost4 | number : 2}} </span>    </span> </td>
											<td width="12%" align="center"><span ng-if="headingQuantity5 != 0"  ng-show="hideMOQ5 || hideFreight5"> <span ng-if="freight.FreightCost5 == 'FREE' ">FREE</span> <span ng-if="freight.FreightCost5 != 'FREE' "> ${{freight.FreightCost5 | number : 2}} </span>   </span> </td>
											<td width="12%" align="center"><span ng-if="headingQuantity6 != 0"  ng-show="hideMOQ6 || hideFreight6"> <span ng-if="freight.FreightCost6 == 'FREE' ">FREE</span> <span ng-if="freight.FreightCost6 != 'FREE' "> ${{freight.FreightCost6 | number : 2}} </span>   </span> </td>
											
										</tr> 

										<!--New freight cost table row result here -->  
		
										
										<tr>
											<td width="25%" align="left">Split Deliveries</td>
											<td colspan="6"  align="center">
												$<?php echo $splitDevCharge; ?> per additional delivery location
											</td>
										</tr>   
													
													
									</tbody> 
								</table>
							</div>	
						</form>	
					</div>



				</div>
			</div>			

      </div>
      <!--<div class="modal-footer modalQuote">
	  	<a href="#" id="btnSave"  class="quickQuote btn btn-primary"   data-dismiss="modal"><i class="fa fa-times"></i>  Close</a> 
      </div>-->
    </div>
  </div>
</div>

<!-- POPUP FOR TRANSIT TIMES --> 

 

<!-- POPUP FOR STARTRACK POWER BANK --> 

<!-- Modal -->
<div class="modal fade trendsModal" id="powerbankModal" tabindex="-1" role="dialog" aria-labelledby="powerbankModalLabel" aria-hidden="true" style=" background-color: rgba(0, 0, 0, 0.5);  " ng-if="CurrencyUpdate == 'AUD' ">
  <div class="modal-dialog transitModal-width" role="document">
    <div class="modal-content">

		<div class="modal-header"> 
					<h5> Economy Freight Transit Times </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
      
      <div class="modal-body"   >
	  		
			 

			<div class="row"  > 
				<div class=" col-md-12"> 
					
					<div class="bodyText">Kindly note that all Power Bank orders are despatched on a Friday and the below transit times are from despatch. </div><br />
					<div class="datagrid"  style="width:99.5%">
						<table class="table table-items table-striped  table-bordered table-sm" width="100%" border="0" cellspacing="0" cellpadding="0">
							<thead class="thead-dark">
								<tr>
									<th colspan="8" align="center">Estimated Delivery Time From Despatch</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td width="143px">&nbsp;</td>
									<td width="57px"  align="center"><strong>NSW</strong></td>
									<td width="57px"  align="center"><strong>QLD</strong></td>
									<td width="57px"  align="center"><strong>Vic</strong></td>
									<td width="57px"  align="center"><strong>SA</strong></td>
									<td width="57px"  align="center"><strong>Tas</strong></td>
									<td width="57px"  align="center"><strong>WA</strong></td>
									<td width="57px"  align="center"><strong>NT</strong></td>
								</tr>
								<tr>
									<td style="padding-left:5px;"><strong>METRO</strong></td>
									<td align="center">3-4</td>
									<td align="center">3-4</td>
									<td align="center">3-4</td>
									<td align="center">5</td>
									<td align="center">7</td>
									<td align="center">7</td>
									<td align="center">7</td>
								</tr>
								<tr>
									<td style="padding-left:5px;"><strong>OUTER METRO</strong></td>
									<td align="center">3</td>
									<td align="center">5</td>
									<td align="center">5</td>
									<td align="center">5</td>
									<td align="center">7</td>
									<td align="center">8</td>
									<td align="center">7</td>
								</tr>
								<tr>
									<td style="padding-left:5px;"><strong>REGIONAL</strong></td>
									<td align="center">5</td>
									<td align="center">6</td>
									<td align="center">5</td>
									<td align="center">6</td>
									<td align="center">7</td>
									<td align="center">10</td>
									<td align="center">8</td>
								</tr>
								<tr>
									<td style="padding-left:5px;"><strong>COUNTRY</strong></td>
									<td align="center">5</td>
									<td align="center">7</td>
									<td align="center">5</td>
									<td align="center">6</td>
									<td align="center">7</td>
									<td align="center">10</td>
									<td align="center">13</td>
								</tr>
							</tbody>
						</table>
					</div>




				</div>
			</div>			

      </div>
      <!--<div class="modal-footer modalQuote">
	  	<a href="#" id="btnSave"  class="quickQuote btn btn-primary"   data-dismiss="modal"><i class="fa fa-times"></i>  Close</a> 
      </div>-->
    </div>
  </div>
</div>

<!-- POPUP FOR STARTRACK POWER BANK --> 








<!-- Modal -->
<div class="modal fade" id="quickQuoteModal" tabindex="-1" role="dialog" aria-labelledby="quickQuoteModalLabel" aria-hidden="true"   >
  <div class="modal-dialog" role="document"  >
    <div class="modal-content">
		<div class="modal-header"> 
					<h4>Quick Quote</h4>
					
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="triggerImage(2)">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
		<div class="modal-body">
					
		 
					
					<div class="row header-btns">
						<div class="col-md-7">
							<div class="bodyText  " id="blurbText"> Copy the quotation below and paste into an email to send to your client. <br />To change the image, select an alternative image from the main item page. </div>
						</div>
						<div class="col-md-5 text-right">
							<a href="#" ngclipboard data-clipboard-target="#img-out"  class="btn btn-trends btn-dark btn-small update-quote"  > <i class="fa  fa-copy"></i> Copy Image </a> 
							<span ng-click="downloadQuoteImg()"  class="quickQuote btn   btn-dark  btn-small "  ><i class="fa fa-save"></i> Download</span> 
						</div>
					</div>	

					<div style="margin-top:15px" id="img-out"></div> 
					
					
	<!-- Trigger -->
					 

					<!-- Jeoffy added-->
					<?php if( $siteLogcheck['loggedIn'] == 1): ?>  
					<div class="row"> 
						<div class="margin-top col-md-12">
							
							<h5 class="quickQuote">Change default standard comment:  </h5> 
							<div class="row margin-bottom">
								<div class="col-md-12">
									
									<?php  
										if(!$siteLogcheck['userDatas'][0]->quickQuoteComment){

											if($siteLogcheck['userDatas'][0]->Currency == "NZD"){ ?>
												<input type="text" id="quickMessageID" class="form-control" ng-value="quickMessage" ng-model="quickMessage" ng-init="quickMessage ='Price excludes GST. Freight is free to one location in New Zealand or Australia.'" ng-paste="$event.preventDefault()"   />  
												 
											<?php }else{ ?>
												<input type="text" id="quickMessageID" class="form-control" ng-value="quickMessage" ng-model="quickMessage" ng-init="quickMessage ='Price excludes GST. Freight is free to one location in New Zealand or Australia.'"  ng-paste="$event.preventDefault()"   /> 
												 
											<?php } 

										}else{    ?>
											<input type="text" id="quickMessageID" class="form-control" ng-value="quickMessage" ng-model="quickMessage" ng-paste="$event.preventDefault()"   />  
										<?php } ?>
										 
								 
								</div> 
							</div>
							<span id="filterUpdateComment" ng-click="updateQuoteMessage(quickMessage, userIDmarkup)"  class=" btn btn-trends btn-dark update-quote">Update</span>	 				 
						</div>	
					</div>
					<?php endif; ?>
					<!-- Jeoffy added-->											
	

		</div>
		<!--<div class="modal-footer modalQuote"> 
			<a href="#"   onClick="triggerImage(2)"  class="quickQuote btn   btn-secondary " data-dismiss="modal"><i class="fa fa-times"></i> Close</a> 
		</div>-->
    </div>
  </div>
</div>



 
<!-- PRICING CHANGES WITH IMAGE SCREENSHOT QUOTE -->




<!-- Changes modal-->
<div class="modal fade" id="Changesmodal" tabindex="-1" role="dialog" aria-labelledby="ChangesModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document"> 
    <div class="modal-content"> 
		<form ng-submit="changesTabFunctionSubmit()"> 
			<div class="modal-header"> 
					<h5>Add Change</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body  ">  
					<input type="hidden" class="form-control" ng-model="ChangesForm.opts" />
					<label for="inputType">Select Change Type</label>
					<select id="inputType" class="form-control margin-bottom" ng-model="ChangesForm.changesType"  > 
						<option ng-repeat="typ in getChangeType" ng-value="typ.indexNum" > {{typ.changeType}}</option>
					</select>
					<label for="inputDesc">Enter Description</label>
					<textarea class="form-control" id="FormControlTextarea1" ng-model="ChangesForm.changesDesc" rows="2"></textarea>					
				
			</div> 
			<div class="modal-footer">
					<button type="submit" class="btn btn-primary" ng-disabled="ChangesForm.changesType == '0'  "  >Save</button> 
					 
			</div> 
	  </form>	
    </div>
  </div>
</div> 
<!-- Changes modal-->

 

<!-- Modal -->
<div class="modal fade"  id="photoModal"  tabindex="-1" role="dialog" aria-labelledby="photoModalLabel" aria-hidden="true" > 
  <div class="modal-dialog" role="document" style="max-width: 700px;">
    <div class="modal-content"> 
		<div class="modal-header"> 
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
      	</div> 
		<div class="modal-body text-center">  				
											
			<span ng-if="baseImg == false">Loading image... </span>
			<span ng-if="baseImg" ng-bind-html="baseImg | trust"> </span>
        
		</div>
		 
    </div>
  </div>
</div>



<!-- Modal POD -->
<div class="modal fade"  id="podModal"  tabindex="-1" role="dialog" aria-labelledby="podModalLabel" aria-hidden="true" > 
  <div class="modal-dialog" role="document" style="max-width: 500px;">
    <div class="modal-content"> 
		<div class="modal-header"> 
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
      	</div> 
		<div class="modal-body ">  				
											
			<span ng-if="podYes == false">Loading image... </span>
			<p ng-if="deliveredDate">
				<b>Delivery Time:</b> {{deliveredDate}} <br />
				<b>Received By:</b> {{sign}}
			</p>
			<span ng-if="podYes" ng-bind-html="podImages | trust"> </span>
        
		</div>
		 
    </div>
  </div>
</div>



<!--videoPopup Modal -->
<div class="modal fade" id="videoPopup" tabindex="-1" role="dialog" aria-labelledby="videoPopupModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document" style="max-width: 700px; margin: 10px auto 1.75rem !important;">
    <div class="modal-content"> 
		<div class="modal-header" style="padding: 0.4rem;"> 
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"  id="pause-button">
				<span aria-hidden="true">&times;</span>
			</button>
      	</div> 
		<div class="modal-body text-center"> 
				<?php 
				if($productItem[0]->video){ 
					$video = explode('/', $productItem[0]->video);
					//print_r($video[3]);
					if($video[3]){ 
					?>
					<iframe class="video" width="660" height="335" src="https://www.youtube.com/embed/<?=$video[3]?>?enablejsapi=1&html5=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					 
				<?php 
					} 
				} 
				?>
				
		</div>
		 
    </div>
  </div>
</div> 




<!-- Modal Repeat Order -->
<div class="modal fade" id="repeatOrderModal" tabindex="-1" role="dialog" aria-labelledby="repeatOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<div class="modal-header"> 
			<h5 class="modal-title" id="repeatOrderModalLabel"> <span ng-if="repeatForm">Order Repeat - {{formOrderRepeat.SalesOrder}}</span> <span ng-if="!repeatForm">Repeat Order Submitted </span></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
      	</div> 
      <div class="modal-body">
			<form ng-submit="submitRepeatOrder(formOrderRepeat)" name="repeatFormName" ng-if="repeatForm">  
				<input type="hidden" class="form-control"  ng-model="formOrderRepeat.SalesOrder"   required> 
				 
				<div class="form-group or1" ng-class="repeatFormName.oRquantity.$error.required? 'text-danger': '' ">
					<label for="textquantity">*Quantity:</label>
					<input type="number" class="form-control or_1" ng-class="repeatFormName.oRquantity.$error.required? 'border-danger': '' " id="textquantity" name="oRquantity"  oninput="validity.valid||(value='');" ng-change="numberOnly(formOrderRepeat.Quantity)" ng-model="formOrderRepeat.Quantity"  required> 
					 
				</div>
				<div class="form-group or2" ng-class="repeatFormName.oRpon.$error.required? 'text-danger': '' ">
					<label for="textpon">*Purchase Order Number:</label>
					<input type="text" class="form-control or_2" ng-class="repeatFormName.oRpon.$error.required? 'border-danger': '' " id="textpon" name="oRpon" ng-model="formOrderRepeat.PON" required> 
				</div>
				<div class="form-group or3" ng-class="repeatFormName.oRaddress.$error.required? 'text-danger': '' ">
					<label for="textaddress">*Delivery Address:</label>
					<textarea class="form-control or_3" ng-class="repeatFormName.oRaddress.$error.required? 'border-danger': '' "  id="textaddress" name="oRaddress" rows="2" ng-model="formOrderRepeat.Address" required></textarea>
				</div>
				<div class="form-group or4" ng-class="repeatFormName.oRdate.$error.required? 'text-danger': '' ">
					<label for="textdate">*Required Date:</label>
					<input type="text" ng-class="repeatFormName.oRdate.$error.required? 'border-danger': '' " class="form-control or_4" id="textdate" name="oRdate" ng-model="formOrderRepeat.date" placeholder="dd/mm/yyyy" required> 
				</div>
				<div class="form-group or5" ng-class="repeatFormName.oRemail.$error.required? 'text-danger': '' ">
					<label for="textemail">*Email Contact:</label>
					<input type="email" class="form-control or_5" ng-class="repeatFormName.oRemail.$error.required? 'border-danger': '' "  id="textemail"  name="oRemail" ng-model="formOrderRepeat.email" placeholder="email@domain.com" ng-pattern="emailFormat" required > 
				</div>
				<div class="form-group">
					<label for="textnote">Note:</label>
					<textarea class="form-control" id="textnote" rows="2" ng-model="formOrderRepeat.Note" ></textarea>
				</div>
				 
				<button type="submit" class="btn btn-primary"  ng-disabled="(formOrderRepeat.SalesOrder && formOrderRepeat.Quantity && formOrderRepeat.PON && formOrderRepeat.Address && formOrderRepeat.date && formOrderRepeat.email)?  false : true">Submit</button>
			</form>
											
			<div ng-if="!repeatForm">
				<h6> Thank you for your order. You will receive an Order Confirmation and Artwork Approval within 4 working hours. </h6> 	
				<p class="text-right"> <button type="submit" class="btn btn-primary" data-dismiss="modal" aria-label="Close"  >Done</button></p>
			</div>

      </div>
      
    </div>
  </div>
</div>




<div class="modal fade" id="showRepeatOrderModal" tabindex="-1" role="dialog" aria-labelledby="showRepeatOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<div class="modal-header"> 
			<h5 class="modal-title" id="showRepeatOrderModalLabel">Order Repeat -  {{showRepeatsData.OriginalSONumber}}</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
      	</div> 
      <div class="modal-body"> 
			 
	  	<p>Previous SO Number: </p>
		<p>Distributor Name: </p> 
		<p>New PO: </p>
		<p>Quantity: </p>
		<p>Shipping Address:  </p>
		<p>Delivery Required by: </p>
		<p>Note: </p>

      </div>
      
    </div>
  </div>
</div>


<!-- Modal Repeat Order -->



<?php endif; ?>
<!--login form -->


<!-- Success modal-->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
      <div class="modal-body text-center"> 
            <span class="uploader-success">  {{successMsg}}</span> 
      </div> 
    </div>
  </div>
</div> 
<!-- Success modal-->


 

<?php if(count($customArray['themeArray']) > 0 || $siteLogcheck['loggedIn'] == 0): ?> 
<div class="modal fade quickquoteSkinnedsite" id="quickQuoteModalSkinnedsite" tabindex="-1" role="dialog" aria-labelledby="quickQuoteModalSkinnedsiteLabel" aria-hidden="true"   >
  <div class="modal-dialog" role="document"  >
    <div class="modal-content">
		
		<div class="modal-header"> 
					<h4>Quick Quote</h4>
					
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="triggerImage(2)" >
						<span aria-hidden="true">&times;</span>
					</button>
		</div>
		<div class="modal-body">
					
		  
		 
					
					<div class="row header-btns">
						<div class="col-md-7">
							<div class="bodyText  " id="blurbText"> Copy the quotation below and paste into an email to send to your client. <br />To change the image, select an alternative image from the main item page. </div>
						</div>
						<div class="col-md-5 text-right">
							<a href="#" ngclipboard data-clipboard-target="#img-out"  class="btn btn-trends btn-dark btn-small update-quote"  > <i class="fa  fa-copy"></i> Copy Image </a> 
							<span ng-click="downloadQuoteImg()"  class="quickQuote btn   btn-dark  btn-small "  ><i class="fa fa-save"></i> Download</span> 
						</div>
					</div>	

					 
				<div style="margin-top:15px" id="img-out"></div> 
				
				<span id="filterUpdateComment"    > </span>	 	
				 

		</div>


	 
    </div>
  </div>
</div>
 
<?php endif; ?>



 


<!-- Image Zoom-->
<div class="modal fade" id="imgZoomModal" tabindex="-1" role="dialog" aria-labelledby="imgZoomModalLabel" aria-hidden="true" >
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">

				<div id="image-zoom-carousel" class="carousel slide" data-interval="false" data-ride="carousel">

					<ol class="carousel-indicators carousel__indicators home-indicators">
						<li ng-repeat="(key, image) in imgZoomData.data" ng-class="{'active':key == imgZoomData.initialSlide}" data-target="#image-zoom-carousel" data-slide-to="{{ key }}"></li>
					</ol>

					<div class="carousel-inner">
						<div class="carousel-item" ng-class="{'active':key == imgZoomData.initialSlide}" ng-repeat="(key, image) in imgZoomData.data" ng-attr-data-slide-count="{{ key }}">
							<div class="carousel__image" style="background-image:url('<?=base_url();?>Images/ProductImg/{{ image.filename }}');">
								<img src="<?=base_url();?>Images/ProductImg/{{ image.filename }}" />
							</div>
							<p ng-if="image.caption" class="carousel__caption" ng-cloak>
								<span class="text-muted">
									{{ image.caption }}
								</span>
							</p>
						</div>
					</div>

					<a class="carousel__control carousel-control-prev ml-3" href="#image-zoom-carousel" role="button" data-slide="prev">
						<span class="item-arrow-carousel">
							<i class="fa fa-arrow-left"></i>
						</span>
					</a>
					<a class="carousel__control carousel-control-next mr-3" href="#image-zoom-carousel" role="button" data-slide="next">
						<span class="item-arrow-carousel">
							<i class="fa fa-arrow-right"></i>
						</span>
					</a>

				</div>
			</div>
		</div>
	</div>
</div> 
<!-- Image Zoom-->


<!-- MixMatch --> 

 <div class="modal fade mixmatch" id="mixMatchModal" tabindex="-1" role="dialog" aria-labelledby="mixMatchModalLabel" aria-hidden="true" ng-if="mixmatchCode">
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
		<div class="modal-header"> 
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
      	</div>
		<div class="modal-body text-center"> 
			<div class="iframe-container">
				<?php if($angularFile == 'item'): ?>
					 <span ng-bind-html="mixmatchCodeF | trust"></span>
				<?php endif; ?>	
			</div>
		</div>
		 
    </div>
  </div>
</div> 
 

<!--MixMatch-->

<!-- skinned sites area-->

<?php if( count($customArray['themeArray']) > 0): 
			if(count($resetUserDatas) > 0) {
				echo '<span ng-init="initialPopup()"></span>';
			}
			if($verifiedEmail):
?>

<!-- Reset skinned user modal-->
<div class="modal fade" id="resetUserModal" tabindex="-1" role="dialog" aria-labelledby="resetUserModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
      <div class="modal-body text-center"> 
	  		<legend>Email: <? echo $verifiedEmail; ?></legend>
	  		<?php // print_r($resetUserDatas); ?>

			<form ng-submit="validatePasswordChange()">
				<div class="form-group text-left">
					<label for="passwordCheck">Password: </label>
					<input type="password" class="form-control" id="passwordCheck" ng-model="formData.passwordCheck" ng-change="verifyPassword(formData.passwordCheck, formData.passwordConfirm)">
				</div>
				<div class="form-group text-left">
					<label for="passwordConfirm">Confirm Password:</label>
					<input type="password" class="form-control" id="passwordConfirm" ng-model="formData.passwordConfirm" ng-change="verifyPassword(formData.passwordCheck, formData.passwordConfirm)">
				</div>

				<div class="alert alert-warning" role="alert" ng-if="pwMsg">
					{{pwMsg}}
				</div>
				<button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary pull-right" ng-disabled="verifiedPassword">Submit</button>
			</form>		

      </div> 
    </div>
  </div>
</div> 
<!--  Reset skinned user modal-->
	<?php endif; ?>
<?php endif; ?>



<?php if( count($customArray['themeArray']) > 0):  ?>


	<!--  SKinned user login-->
	<?php if($customArray['themeArray'][0]->showPricing == 2): ?> 
		<div class="modal fade" id="skinnedLoginModal" tabindex="-1" role="dialog" aria-labelledby="skinnedLoginModalLabel" aria-hidden="true" >
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">{{skinnedLoginFormTitle}}</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div> 
					<div class="modal-body text-left"> 



						<div id="carouselLoginControls" class="carousel slide" data-ride="carousel" data-interval="false">
							<div class="carousel-inner">
								<div class="carousel-item active">
									
										<!--form--> 
										<form ng-submit="loginSkinnedUser()">
											<div class="form-group">
												<label for="skinnedInputEmail1">Email address</label>
												<input type="email" class="form-control" id="skinnedInputEmail1" ng-model="skinnedFormData.userName" ng-change="checkSkinnedLogin(skinnedFormData.userName, skinnedFormData.passWord)" > 
											</div>
											<div class="form-group">
												<label for="skinnedInputPassword1">Password</label>
												<input type="password" class="form-control" id="skinnedInputPassword1" ng-model="skinnedFormData.passWord" ng-change="checkSkinnedLogin(skinnedFormData.userName, skinnedFormData.passWord)" >
											</div> 
											<div class="form-group">
												<a href="#carouselLoginControls" role="button" data-slide="next" ng-click="skinnedLoginTitle('Forgot Password')"><u>Forgot Password?</u></a>
											</div> 
											<div class="alert alert-danger" role="alert" ng-if="errorSkinnedLoginMessage">
												{{errorSkinnedLoginMessage}}
											</div>
											<div ng-if="correct">
												<p class="text-center"> <img src="<?php echo base_url();?>Images/loading-img.gif" width="50" height="50"/> </p>
											</div>	
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<button type="submit" class="btn btn-primary pull-right" ng-disabled="skinnedLoginBtn">Submit</button>
										</form>
										<!--form-->

								</div>
								<div class="carousel-item">

										<!--form--> 
										<p>Please enter your registered email address. An email will be sent to you with a password reset link by the administrator. </p>
										<form ng-submit="forgotPwSkinnedUser(userNameEmail)">
											<div class="form-group">
												<label for="skinnedInputEmail1">Email address</label>
												<input type="email" class="form-control" id="skinnedInputEmail1" ng-model="userNameEmail"   > 
											</div> 
											
											<div class="alert alert-danger" role="alert" ng-if="errorSkinnedForgotMessage">
												{{errorSkinnedForgotMessage}}
											</div>
											<div class="alert alert-success" role="alert" ng-if="successSkinnedForgotMessage">
												{{successSkinnedForgotMessage}}
											</div>

											<div class="form-group">
												<a href="#carouselLoginControls" role="button" data-slide="prev" ng-click="skinnedLoginTitle('Login')"><u>Already have login? click here</u></a>
											</div> 
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<button type="submit" class="btn btn-primary pull-right" ng-disabled="!userNameEmail">Reset</button>
										</form>
										<!--form-->
									
								</div>
								 
							</div>
							<!--<a class="carousel-control-prev" href="#carouselLoginControls" role="button" data-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="carousel-control-next" href="#carouselLoginControls" role="button" data-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							</a>-->
						</div>






						
					</div> 
				</div>
			</div>
		</div>  
		

		 
	<?php endif; ?>
	<!--  SKinned user login-->



<div class="modal fade" id="enquiryForm" tabindex="-1" role="dialog" aria-labelledby="enquiryFormModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
		<div class="modal-header">
						<h5 class="modal-title">Enquire Now</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
		</div> 
		<div class="modal-body"> 
				 
				<form ng-submit="submitSkinnedForm()"  >  
					<fieldset ng-if="!enquiryMsg">
						<input type="text" class="form-control" id="InputName"  ng-model="BotValue"  style="display:none"   > 
						<div class="form-group">
							<label for="InputName">Name *:</label>
							<input type="text" class="form-control" id="InputName"  ng-model="skinnedEnquiryForm.Name"    > 
						</div>
						<div class="form-group">
							<label for="InputCompany">Company *:</label>
							<input type="text" class="form-control" id="InputCompany" ng-model="skinnedEnquiryForm.Company"   > 
						</div>
						<div class="form-group">
							<label for="InputEmail">Email *:</label>
							<input type="email" class="form-control" id="InputEmail"  ng-model="skinnedEnquiryForm.Email" ng-change="skinnedFormCheck('email', skinnedEnquiryForm.Email)"  > 
						</div>
						<div class="form-group">
							<label for="InputPhone">Phone:</label>
							<input type="tel" class="form-control" id="InputPhone"  ng-model="skinnedEnquiryForm.Phone"     > 
						</div>
						<div class="form-group">
							<label for="InputProduct">Product *:</label>
							<input type="text" class="form-control" id="InputProduct" ng-model="skinnedEnquiryForm.Product"    > 
						</div>
						<div class="form-group">
							<label for="InputDetails">Details:</label>
							<textarea class="form-control" id="textareaDetails" rows="2" ng-model="skinnedEnquiryForm.Details" ></textarea>
						</div>
						<div class="form-check margin-bottom">
							<label class="form-check-label" for="defaultCheck1">
								<input class="form-check-input" type="checkbox" ng-model="skinnedEnquiryForm.Human"  ng-click="makeBotTrue(skinnedEnquiryForm.Human)" > 
								Check this, if you are human/not a robot.
							</label>
						</div>
					</fieldset>	
					<div class="form-group text-center" ng-if="enquiryMsg">
						<i class='fa fa-check'></i>  {{enquiryMsg}}
					</div>
					<div class="form-group">
						<button type="submit" ng-if="!enquiryMsg" class="btn btn-primary contact-btn" ng-disabled="(skinnedEnquiryForm.Name && skinnedEnquiryForm.Company && skinnedEnquiryForm.Email   && skinnedEnquiryForm.Product && skinnedEnquiryForm.Human && alright  ) ?  false : true" >Send</button>
					</div>
				</form>	
		</div> 
    </div>
  </div>
</div> 



<?php endif; ?> 

<!-- skinned sites area-->
