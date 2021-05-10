
<?php
	$this->load->view('header/header');
?> 
<?php $apiLocation = strtolower($getServerHost['domainLocation']); ?>

 
 
<div class="container">
	<div class="jumbotron" >
		<h2>TRENDS  Data API&apos;s </h2>
	</div>
</div>

<div class="container page_<?=$angularFile ?>">
	<div class="row">
		<div class="col-md-12 minheight" style="min-height: 660px"> 

			<div class="accordion" id="accordionAPI">

				<div class="card">
					<div class="card-header" id="headingOne">
					<h5 class="mb-0">
						<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							About
						</button>
					</h5>
					</div>

					<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionAPI">
					<div class="card-body"> 
						<p> The TRENDS Data API&apos;s provide an interface that allows you to connect your business systems to our product, image, stock, pricing, categories, and order data. It can be used to integrate websites, accounting software, quoting tools, ordering platforms and other business systems. It ensures your business systems are always up to date with real time data. </p>
						<p> The below documentation details on how to connect, utilise and read the data.</p>
					</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header" id="headingTwo">
					<h5 class="mb-0">
						<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
							Register
						</button>
					</h5>
					</div>
					<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionAPI">
					<div class="card-body">
						
						<?php if($siteLogcheck['loggedIn'] == 1  ): ?>
						<div ng-if="registerMessage">
							<p>To register, click the button below. Your access will then need to be approved by an administrator before you can begin to use the service.</p>
							<p><button class="btn btn-danger btn-teal" ng-click="registerAPI()" onClick=" " >Register Now</button></p>
						</div>
						<div ng-if="registerSuccessMessage">
							<p>A request has already been received for access for this account. Once an administrator has approved your access, your login credentials will be emailed to you. Please contact <a href="mailto:support@tuapeka.co.nz">support@tuapeka.co.nz </a> if you have not yet received this email or misplaced it.</p>
						</div>
						
						<? else: ?>
							<p>Please Login to register.</p>
						<? endif; ?>	

					</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header" id="headingThree">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
								Support
							</button>
						</h5>
					</div>
					<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionAPI">
						<div class="card-body">
							For support, please email <strong><a href="mailto:support@tuapeka.co.nz">support@tuapeka.co.nz</a></strong>. You are welcome to provide this email to third party IT providers to contact us directly for support.
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header" id="headingFour">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
								Documentation
							</button>
						</h5>
					</div>
					<div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionAPI">
						<div class="card-body">
							
							<p>The TRENDS Data API&apos;s is a RESTful web service and data is requested by submitting GET HTTP commands to the URL’s listed below. </p>
							<p>For more information about REST please see one of the following resources: <br />
							<a href="https://en.wikipedia.org/wiki/Representational_state_transfer">https://en.wikipedia.org/wiki/Representational_state_transfer</a> <br />
							 
							<h3 class="underline">Currency</h3>
							<div class="alert alert-secondary" role="alert">
								The below documentation and code examples using the NZD pricing endpoint as an example. To access AUD pricing, use https://au.api.trends.nz/api/v1 instead.
							</div>

							
							<h3 class="underline">Using Query Parameters</h3>
							<div class="alert alert-secondary" role="alert">
								Query parameters can be appended to the end of the URL or CURL command to provide a variable to customise the response data. See examples below:<br /> 
								<strong>One Parameter:</strong> https://nz.api.trends.nz/api/v1/products.json?category_no=13-0<br />
								<strong>Multiple Parameters:</strong> https://nz.api.trends.nz/api/v1/products.json?category_no=13-0&page_size=1500
							</div>

							<h3 class="underline">Categories</h3>  
							<div class="alert alert-secondary" role="alert">
								Returns a full list of product categories including subcategories.<br /> 
								<strong>URL:</strong> https://<?php echo $apiLocation; ?>.api.trends.nz/api/v1/categories.{format}<br />
								<strong>Curl:</strong> curl -X GET --header 'Accept: application/json' 'https://<?php echo $apiLocation; ?>.api.trends.nz/api/v1/categories.{format}'<br />
							
							</div>

							<h5>Parameters</h5>  
							<div class="table-responsive">
								<table  class="table table-striped" >
									<thead class="thead-dark">
										<tr>
											<th  >Parameter</th>
											<th >Description</th>
											<th >Parameter Type</th>
											<th >Data Type</th>
											<th >Required</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td >format</td>
											<td >Format of the response (json or xml)</td>
											<td >path</td>
											<td >string</td>
											<td ><strong>yes</strong> </td>
										</tr>
										<tr> 
											<td >inc_discontinued		</td>
											<td >Should clearance/discontinued categories be included</td>
											<td >query</td>
											<td >boolean</td>
											<td > &nbsp; </td>
										</tr>
									</tbody>
								</table>
							</div>	

							<h5>Response Format</h5>  	
							<div class="alert alert-secondary" role="alert"> 
								<pre class="prettyprint">
								{
								"status": 0,
								"country": "string",
								"data": {
									"number": "string",
									"name": "string",
									"sub_categories": {},
									"mps_category": "string",
									"xebra_code_1": "string",
									"xebra_code_2": "string"
									}
								}</pre>
							</div>
							<h5>Field Descriptions</h5>  	
							<div class="alert alert-secondary" role="alert"> 
								<strong>Number:</strong> The category number used to uniquely identify the category. Presented in the format of {Parent Category}-{Sub Category}<br />
								<strong>Name:</strong> The Category Name<br />
								<strong>Sub Categories:</strong> A list of relevant sub categories for the parent category<br />
								<strong>Mps_category:</strong>  MyPromoSource category<br />
								<strong>Xebra_code_1:</strong>  Xebrasource Category<br />
								<strong>Xebra_code_2:</strong>  Xebrasource Category
							</div>

							<h3 class="underline">Products - List</h3>  
							<div class="alert alert-secondary" role="alert"> 
								Returns a list of all products.<br /> 
								<strong style="padding-left:5px;">URL:</strong> https://<?php echo $apiLocation;  ?>.api.trends.nz/api/v1/products.{format} 
								<strong style="padding-left:5px;">Curl:</strong> curl -X GET --header 'Accept: application/json' 'https://<?php echo $apiLocation; ?>.api.trends.nz/api/v1/products.{format}'<br />
							</div>	

							<h5>Parameters</h5>
							<div class="table-responsive">
								<table  class="table table-striped">
									<thead class="thead-dark">
										<tr>
											<th  >Parameter</th>
											<th  >Description</th>
											<th >Parameter Type</th>
											<th  >Data Type</th>
											<th >Required</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td  >format</td>
											<td  >Format of the response (json or xml)</td>
											<td  >path</td>
											<td >string</td>
											<td  ><strong>yes</strong> </td>
										</tr>
										<tr>
											<td  >category_no</td>
											<td  >Category number to get products for</td>
											<td  >query</td>
											<td  >string</td>
											<td  >&nbsp;</td>
										</tr>
										<tr>
											<td  >page_size</td>
											<td  >Number of products per page, default is 100</td>
											<td  >query</td>
											<td  >string</td>
											<td  >&nbsp;</td>
										</tr>
										<tr>
											<td  >page_no</td>
											<td >Page number to get, default is 1</td>
											<td  >query</td>
											<td  >string</td>
											<td  >&nbsp;</td>
										</tr> 
										<tr>
											<td >inc_discontinued</td>
											<td >Should items flagged to be discontinued be included in results</td>
											<td >query	</td>
											<td >boolean</td>
											<td >&nbsp;</td>
										</tr>
										<tr>
											<td >inc_inactive		</td>
											<td >Should items, flagged as no longer available, be included in search results (a value of 0 = no, 1 = yes)</td>
											<td >query </td>
											<td >string</td>
											<td >&nbsp;</td>
										</tr>
										<tr>
											<td >last_updated	 		</td>
											<td >Only includes products updated since a particular date/time. Date must be in ISO 8601 format.</td>
											<td >query</td>
											<td >string</td>
											<td >&nbsp;</td>
										</tr>


									</tbody>
								</table>
							</div>		
							<h5>Response Format</h5>

							<div class="alert alert-secondary" role="alert"> 	
								<pre   class="prettyprint">
									{
									"status": 0,
									"country": "string",
									"page_count": 0,
									"page_current": 0,
									"page_size": 0,
									"total_items": 0,
									"data": {
											"code": 0,
											"name": "string",
											"description": "string",
											"active": "string",
											"status": "string",
											"last_updated": "string",
											"categories": [
											"string"
											],
											"colours": "string",
											"dimensions": [
											"string"
											],
											"sizing": [
											{
												"sizing_line": "string"
											}
											],
											"materials": "string",
											"specifications": "string",
											"branding_options": [
											{
												"print_type": "string",
												"print_description": "string"
											}
											],
											"packaging": "string",
											"carton": {
											"length": 0,
											"width": 0,
											"height": 0,
											"weight": "string",
											"quantity": 0
											},
											"full_colour": 0,
											"mix_and_match": 0,
											"image_count": 0,
											"images": [
											{
												"link": "string",
												"name": "string",
												"stock_code": 0,
												"colour": "string",
											  	"caption" : "string"
											}
											],
											"product_wire": "string",
											"pricing": [
											{
												"type": "string",
												"primary_price_description": "string",
												"less_than_moq": "string",
												"prices": [
												{
													"quantity": 0,
													"price": 0
												}
												],
												"additional_costs": [
												{
													"type": "string",
													"description": "string",
													"branding_option": "string",
													"branding_area": "string",
													"description": "string",
													"unit_price": 0,
													"price_per_unit_charge_code": 0,
													"setup_price": 0,
													"price_per_order_charge_code": 0
												}
												],
												"pricing_comment": "string"
											}
											]
										}
									}

								 

								</pre>
							</div>	
							<h5>Field Descriptions</h5>

							<div class="alert alert-secondary" role="alert">   
									<strong>Code:</strong> TRENDS 6 digit product code<br />
									<strong>Name:</strong> Product Name<br />
									<strong>Description:</strong> Product Description<br />
									<strong>Categories:</strong> A list of category codes which apply to the product<br />
									<strong>Colours:</strong> Colours in which the product is available<br />
									<strong>Dimensions:</strong> A list of  product and packaging dimensions<br />
									<strong>Active:</strong>  Is this item currently active and available for sale<br />
									<strong>Status:</strong>   New, Normal or Discontinued<br />
									<strong>Last Updated:</strong>  When was an update to the product data/images for this item last updated <br />
									<strong>Sizing:</strong> For Apparel items: each sizing line represents a row in a table<br />
									<strong>Materials:</strong> Not yet in use<br />
									<strong>Specifications:</strong> Not yet in use<br />
									<strong><u>Branding Options</u></strong><br />
										<div style="margin-left:25px; width:100%">
											<strong>Branding Options – Print Type:</strong> The name of the branding process<br />
											<strong>Branding Options – Print Description:</strong> Print area for the listed branding process<br />
										</div>	
									<strong>Packaging:</strong> Estimate carton measurements and quantities for finished product <br />
									<strong>Full Colour:</strong> Is full colour available 1: Yes 0: No<br />
									<strong>Mix and Match:</strong> Is the item a mix and match item 1: Yes 0: No<br />
									<strong>Image Count:</strong> Number of images available for this item<br />
									<strong><u>Images</u></strong><br />
										<div style="margin-left:25px; width:100%">
											<strong>Images - Link:</strong> a link to the image hosted on www.trends.nz<br />
											<strong>Images - Name:</strong> The file name of the image available in the download file on the toolbox menu of the TRENDS Website<br />
											<strong>Images - Stock Code:</strong> TRENDS internal 6 digit stock code <br />
											<strong>Images - Colour:</strong> Colour of the product <br />
											<strong>Images - Caption:</strong> Title of the image<br />
										</div>	 
									<strong>Product Wire</strong> A link to the product wire<br />

									<strong><u>Pricing</u></strong><br />
										<div style="margin-left:25px; width:100%">
											<strong>Pricing Type:</strong>  A description of the delivery method that applies to listed pricing e.g. Stock, Indent – Sea, Indent – Air<br />
											<strong>Primary Price Description: </strong> A description of what is included in the primary<br />
											<strong>Less than MOQ:</strong>  Is less than minimum order quantity available on this pricing option: Y: Yes N: No<br />
											<strong>Pricing – Quantity:</strong>  Quantity Break<br />
											<strong>Pricing – Price:</strong>  Price Break<br /> 
										</div>

									<strong><u>Additional Costs</u></strong><br /> 
										<div style="margin-left:25px; width:100%">
											<strong>Additional Cost - Type:</strong> Description of the cost type e.g. Decoration Option, Additional Extra, Branding Option on an Additional Extra <br />
											<strong>Additional Cost - Branding Option:</strong> Branding method <br />
											<strong>Additional Cost - Branding Area:</strong> Branding area measurement<br />

											<strong>Additional Cost - Description:</strong> A description of the additional cost <br />
											<strong>Additional Cost - Unit Price:</strong> The per unit price of the listed additional cost<br />
											<strong>Additional Cost - Price Per Unit Charge Code:</strong> List of TRENDS internal 6 digit stock code<br />
											<strong>Additional Cost - Setup:</strong> The per order setup price of the listed additional cost<br />
											<strong>Additional Cost - Price Per Order Charge Code:</strong> TRENDS internal 6 digit stock code<br />
										
										</div>
									<strong>Pricing Comment:</strong> Additional information regarding the pricing 	
							</div>
							
							<h3 class="underline">Products - Individual</h3>   
							<div class="alert alert-secondary" role="alert">   
								Returns product data for an individual product.<br /> 
								<strong  >URL:</strong> https://<?php echo $apiLocation; ?>.api.trends.nz/api/v1/products/{productCode}.{format}<br />
								<strong >Curl:</strong> curl -X GET --header 'Accept: application/json' 'https://<?php echo $apiLocation; ?>.api.trends.nz/api/v1/products/{productCode}.{format}' 
							</div>

							<h5>Parameters</h5> 
							<div class="table-responsive">
								<table class="table table-striped">
									<thead class="thead-dark">
										<tr>
											<th >Parameter</th>
											<th >Description</th>
											<th  >Parameter Type</th>
											<th >Data Type</th>
											<th >Required</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td  >productCode</td>
											<td >The code of the product to retrieve</td>
											<td >query</td>
											<td >string</td>
											<td  ><strong>yes</strong> </td>
										</tr>
										<tr>
											<td  >format</td>
											<td  >Format of the response</td>
											<td  >path</td>
											<td  >string</td>
											<td  ><strong>yes</strong> </td>
										</tr>
									</tbody>
								</table> 
							</div>	

							<h5>Response Format</h5>

							<div class="alert alert-secondary" role="alert"> 	
								<pre   class="prettyprint">

									{
										"status": 0,
										"country": "string",
										"data": {
											"code": 0,
											"name": "string",
											"description": "string",
											"active": "string",
											"status": "string",
											"last_updated": "string",
											"categories": [
											"string"
											],
											"colours": "string",
											"dimensions": [
											"string"
											],
											"sizing": [
											{
												"sizing_line": "string"
											}
											],
											"materials": "string",
											"specifications": "string",
											"branding_options": [
											{
												"print_type": "string",
												"print_description": "string"
											}
											],
											"packaging": "string",
											"carton": {
											"length": 0,
											"width": 0,
											"height": 0,
											"weight": "string",
											"quantity": 0
											},
											"full_colour": 0,
											"mix_and_match": 0,
											"image_count": 0,
											"images": [
											{
												"link": "string",
												"name": "string",
												"stock_code": 0,
												"colour": "string",
											  	"caption" : "string"
											}
											],
											"product_wire": "string",
											"stock": [
											{
												"stock_code": 0,
												"description": "string",
												"quantity": 0,
												"next_shipment" : 0,
												"due_date": "string"
											}
											],
											"pricing": [
											{
												"type": "string",
												"primary_price_description": "string",
												"less_than_moq": "string",
												"prices": [
												{
													"quantity": 0,
													"price": 0
												}
												],
												"additional_costs": [
												{
													"type": "string",
													"description": "string",
													"branding_option": "string",
													"branding_area": "string",
													"description": "string",
													"unit_price": 0,
													"price_per_unit_charge_code": 0,
													"setup_price": 0,
													"price_per_order_charge_code": 0
												}
												],
												"pricing_comment": "string"
											}
											]
										}
									}

								</pre>
							</div>	
							<h5>Field Descriptions</h5> 
							<div class="alert alert-secondary" role="alert">   
								
								<strong>Code:</strong> TRENDS 6 digit product code</br>
								<strong>Name:</strong> Product Name</br>
								<strong>Description:</strong> Product Description</br>
								<strong>Categories:</strong> A list of category codes which apply to the product</br>
								<strong>Colours:</strong> Colours in which the product is available</br>
								<strong>Dimensions:</strong> A list of  product and packaging dimensions</br>
								<strong>Active:</strong>  Is this item currently active and available for sale<br />
								<strong>Status:</strong>   New, Normal or Discontinued<br />
								<strong>Last Updated:</strong>  When was an update to the product data/images for this item last updated <br />
								<strong>Sizing:</strong> For Apparel items: each sizing line represents a row in a table</br>
								<strong>Materials:</strong> Not yet in use</br>
								<strong>Specifications:</strong> Not yet in use</br>
								<strong><u>Branding</u></strong><br /> 
										<div style="margin-left:25px; width:100%">
											<strong>Branding Options – Print Type:</strong> The name of the branding process</br>
											<strong>Branding Options – Print Description:</strong> Print area for the listed branding process</br>
										</div>
								
								<strong>Packaging:</strong> Estimate carton measurements and quantities for finished product </br>
								<strong>Full Colour:</strong> Is full colour available 1: Yes 0: No</br>
								<strong>Mix and Match:</strong> Is the item a mix and match item 1: Yes 0: No</br>
								<strong>Image Count:</strong> Number of images available for this item</br>
								<strong><u>Images</u></strong><br /> 
										<div style="margin-left:25px; width:100%">
											<strong>Images - Link:</strong> a link to the image hosted on www.trends.nz</br>
											<strong>Images - Name:</strong> The file name of the image available in the download file on the toolbox menu of the TRENDS Website</br>
											<strong>Images - Stock Code:</strong> TRENDS internal 6 digit stock code <br />
											<strong>Images - Colour:</strong> Colour of the product <br />
											<strong>Images - Caption:</strong> Title of the image<br />
										</div> 
								<strong>Product Wire:</strong> A link to the artwork wire</br>
								<strong><u>Stock</u></strong><br /> 
										<div style="margin-left:25px; width:100%">
											<strong>Stock - Code:</strong>  TRENDS internal 6 digit stock code</br>
											<strong>Stock - Description:</strong> Description of the stocked component</br>
											<strong>Stock - Quantity:</strong> Quantity available</br>
											<strong>Stock - Next Shipment:</strong>  The quantity of future shipment less any stock already allocated<br />
											<strong>Stock - Due Date:</strong> Approximate arrival date of the next shipment</br>
										</div> 

								<strong><u>Pricing</u></strong><br /> 
										<div style="margin-left:25px; width:100%">
											<strong>Pricing Type:</strong> A description of the delivery method that applies to listed pricing e.g. Stock, Indent -  Sea, Indent – Air</br>
											<strong>Primary Price Description:</strong> A description of what is included in the primary </br>
											<strong>Less than MOQ:</strong> Is less than minimum order quantity available on this pricing option: Y: Yes N: No</br>
											<strong>Pricing – Quantity:</strong> Quantity Break</br>
											<strong>Pricing – Price:</strong> Price Break</br>
										</div> 
								
								<strong><u>Additional Costs</u></strong><br /> 
										<div style="margin-left:25px; width:100%">
											<strong>Additional Cost - Type:</strong> Description of the cost type e.g. Decoration Option, Additional Extra, Branding Option on an Additional Extra</br> 
											<strong>Additional Cost - Branding Option:</strong> Branding method</br> 
											<strong>Additional Cost - Branding Area:</strong> Branding area measurement</br>
											<strong>Additional Cost - Description:</strong> A description of the additional cost </br>
											<strong>Additional Cost - Unit Price:</strong> The per unit price of the listed additional cost</br>
											<strong>Additional Cost - Price Per Unit Charge Code:</strong>  List of TRENDS internal 6 digit stock code</br>
											<strong>Additional Cost - Setup:</strong> The per order setup price of the listed additional cost</br>
											<strong>Additional Cost - Price Per Order Charge Code:</strong> TRENDS internal 6 digit stock code</br>
										</div> 

								<strong>Pricing Comment:</strong> Additional information regarding the pricing

							</div>		

							<h3 class="underline">Stock</h3>	
							<div class="alert alert-secondary" role="alert">  
								Returns a list of stock for the specified product.<br /> 
								<strong >URL:</strong> https://<?php echo $apiLocation; ?>.api.trends.nz/api/v1/stock/{productCode}.{format}<br />
								<strong >Curl:</strong> curl -X GET --header 'Accept: application/json' 'https://<?php echo $apiLocation; ?>.api.trends.nz/api/v1/stock/{productCode}.{format}' 
							
							</div>	
							<h5>Parameters</h5> 
							<div class="table-responsive">
								<table class="table table-striped">
									<thead class="thead-dark">
										<tr>
											<th  >Parameter</th>
											<th >Description</th>
											<th >Parameter Type</th>
											<th >Data Type</th>
											<th >Required</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td >productCode</td>
											<td >The code of the product to retrieve</td>
											<td >path</td>
											<td >string</td>
											<td ><strong>yes</strong> </td>
										</tr>
										<tr>
											<td >format</td>
											<td >Format of the response</td>
											<td >query</td>
											<td >string</td>
											<td ><strong>yes</strong> </td>
										</tr>
									</tbody>
								</table> 
							</div>		

						<h5>Response Format</h5>
						<div class="alert alert-secondary" role="alert"> 
							<pre   class="prettyprint">
								{
								"status": 0,
									"data": [
										{
										"stock_code": 0,
										"description": "string",
										"quantity": 0,
										"next_shipment" : 0,
										"due_date": "string"
										}
									]
								}
							</pre>
						</div>	

						<h5>Field Descriptions</h5> 
						<div class="alert alert-secondary" role="alert">   
							<strong>Stock - Code:</strong> TRENDS internal 6 digit stock code <br />
							<strong>Stock - Description:</strong> Description of the stocked component<br />
							<strong>Stock - Quantity:</strong> Quantity available<br />
							<strong>Stock - Next Shipment:</strong>  The quantity of future shipment less any stock already allocated<br />
							<strong>Stock - Due Date:</strong> Approximate arrival date of the next shipment 
						</div>	


						<h3 class="underline">Orders - List</h3>	
						<div class="alert alert-secondary" role="alert">  
							Returns a list of all the users’ open orders.<br /> 
								<strong >URL:</strong>: http://nz.api.trends.nz/api/v1/orders.{format}<br />
								<strong >Curl:</strong> curl -X GET --header 'Accept: application/json' 'http://nz.api.trends.nz/api/v1/orders.{format}' 
						</div>

						<h5>Parameters</h5> 
							<div class="table-responsive">
								<table class="table table-striped">
									<thead class="thead-dark">
										<tr>
											<th  >Parameter</th>
											<th >Description</th>
											<th >Parameter Type</th>
											<th >Data Type</th>
											<th >Required</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td >format</td>
											<td >format of the response (json or xml)</td>
											<td >path</td>
											<td >string</td>
											<td ><strong>yes</strong> </td>
										</tr>
										 
									</tbody>
								</table> 
							</div>

						<h5>Response Format</h5>
						<div class="alert alert-secondary" role="alert"> 
							<pre   class="prettyprint">
							{
							“status”: 0,
							“country”: “string”,
							“data”: [
										{
											“order_number”: “string”,
											“purchase_order_number”: “string”,
											“status”: “string”,
											“product”: “string”,
											“job_description”: “string”,
											“decoration_method”: “string”,
											“quantity”: 0,
											“value”: “string”,
											“order_date”: “string”,
											“ship_date”: “string”,
											“delivery_address”: {
												“ship_to_name”:”string”
												“delivery_address_line_1”: “string”,
												“delivery_address_line_2”: “string”,
												“delivery_address_line_3”: “string”,
												“delivery_address_line_4”: “string”,
												“delivery_address_line_5”: “string”,
												“postal_code”:”String”
											},
											“contact_email “: “string”,
											“invoice”: “string”,
											“invoice_number”: “string”,
											“proof”: “string”,
											“photo”: “string”,
											“tracking”: “string”,
											“order_lines”: [
													{
														“code”: “string”,
														“description”: “string”,
														“quantity”: 0,
														“price”: “string”,
														“gross”: “string”
													}, {},
												],
											“time_stamps”: {
												“order_received”: “string”,
												“last_proofed”: “string”,
												“order_approved”: “string”,
												“dispatch”: “string”,
												“invoiced”: “string”,
											} 
										}
									]
							}

							</pre>
						</div>	

						<h5>Field Descriptions</h5> 
						<div class="alert alert-secondary" role="alert">     
							<strong>Order Number:</strong> TRENDS order number<br />
							<strong>Purchase Order Number:</strong> Purchase number <br />
							<strong>Status:</strong> Order status in TRENDS production system<br />
							<strong>Product:</strong> Name of the product<br />
							<strong>Job Description:</strong> TRENDS description of the order, usually the most prominent text on the artwork<br />
							<strong>Decoration Method:</strong> Decoration process for the order<br />
							<strong>Quantity:</strong> Order quantity <br />
							<strong>Value:</strong> Total order value<br />
							<strong>Order Date:</strong> Date that the order was accepted<br />
							<strong>Ship Date:</strong> Date that the order is due to be shipped or was scheduled to be shipped on, indicative until order is approved<br />
							<strong>Delivery Address:</strong> shipping address<br />
							<strong>Contact Email:</strong> the distributors email contact for the order<br />
							<strong>Invoice:</strong> URL to the order invoice<br />
							<strong>Invoice Number:</strong> TRENDS invoice number<br />
							<strong>Proof:</strong> URL to the artwork proof<br />
							<strong>Photo:</strong> URL to the final product image<br />
							<strong>Tracking:</strong> URL to the shipment tracking<br />
							<strong><u>Order Lines</u></strong><br />
								<div style="margin-left:25px; width:100%">
									<strong>Code:</strong> TRENDS internal component code<br />
									<strong>Description:</strong> Description of the component<br />
									<strong>Quantity:</strong> Quantity of product ordered<br />
									<strong>Price:</strong> Unit cost of the product<br />
									<strong>Gross:</strong> Unit cost X the quantity<br />
								</div>
							<strong><u>Time Stamps</u></strong><br />
								<div style="margin-left:25px; width:100%">
									<strong>Order Received:</strong> Timestamp of when the order was entered into TRENDS system <br />
									<strong>Last Proofed:</strong> Timestamp of when the order proof was last updated<br />
									<strong>Order Approved:</strong> Timestamp of when the order was accepted by TRENDS<br />
									<strong>Dispatch:</strong> Timestamp of when the order was dispatched<br />
									<strong>Invoiced:</strong>  Timestamp of when the order was invoiced 
								</div>

						</div>	

						<h3 class="underline">Orders – Individual</h3>	
						<div class="alert alert-secondary" role="alert">   

							Returns order data for an individual order referenced by the order number. <br /> 
							<strong >URL:</strong> http://nz.api.trends.nz/api/v1/orders.{format}?salesordernum={orderNumber}   <br /> 
							Or http://nz.api.trends.nz/api/v1/orders.xml?ponum={purchaseOrder}<br /> 
							<strong >Curl:</strong> curl -X GET –header 'Accept: application/json' 'https:// http://nz.api.trends.nz/api/v1/orders.{format}?salesordernum={orderNumber}' <br /> 

						</div>

						<h5>Parameters</h5> 
							<div class="table-responsive">
								<table class="table table-striped">
									<thead class="thead-dark">
										<tr>
											<th  >Parameter</th>
											<th >Description</th>
											<th >Parameter Type</th>
											<th >Data Type</th>
											<th >Required</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td >orderNumber</td>
											<td >The TRENDS order number of the order to retrieve</td>
											<td >query</td>
											<td >string</td>
											<td ><strong>yes</strong>   if purchase order not specified</td>
										</tr>
										<tr>
											<td >purchaseOrder</td>
											<td >The customers purchase order number of the order to retrieve</td>
											<td >query</td>
											<td >string</td>
											<td ><strong>yes</strong>   if order number not specified</td>
										</tr>
										<tr>
											<td >Format</td>
											<td >Format of the response</td>
											<td >query</td>
											<td >string</td>
											<td ><strong>yes</strong>   </td>
										</tr>
										 
									</tbody>
								</table> 
							</div>

						<h5>Response Format</h5>
						<div class="alert alert-secondary" role="alert"> 
							<pre   class="prettyprint">
							{
								{
								“status”: 0,
								“country”: “string”,
								“data”: [
										{
										“order_number”: “string”,
										“purchase_order_number”: “string”,
										“status”: “string”,
										“product”: “string”,
										“job_description”: “string”,
										“decoration_method”: “string”,
										“quantity”: 0,
										“value”: “string”,
										“order_date”: “string”,
										“ship_date”: “string”,
										“delivery_address”: {
												“ship_to_name”:”string”
												“delivery_address_line_1”: “string”,
												“delivery_address_line_2”: “string”,
												“delivery_address_line_3”: “string”,
												“delivery_address_line_4”: “string”,
												“delivery_address_line_5”: “string”,
												“postal_code”:”string”
													},
										“contact_email”: “string”,
										“invoice”: “string”,
										“invoice_number”: “string”,
										“proof”: “string”,
										“photo”: “string”,
										“tracking”: “string”,
										“order_lines”: [
													{
												“code”: “string”,
												“description”: “string”,
												“quantity”: 0,
												“price”: “string”,
												“gross”: “string”
													}, {},
											],
										“time_stamps”: {
												“order_received”: “string”,
												“last_proofed”: “string”,
												“order_approved”: “string”,
												“dispatch”: “string”,
												“invoiced”: “string”,
											}
										}
									]

								}
							}

							</pre>
						</div>	


						<h5>Field Descriptions</h5> 
						<div class="alert alert-secondary" role="alert">     
							<strong>Order Number:</strong> TRENDS order number<br />
							<strong>Purchase Order Number:</strong> Purchase number <br />
							<strong>Status:</strong> Order status in TRENDS production system<br />
							<strong>Product:</strong> Name of the product<br />
							<strong>Job Description:</strong> TRENDS description of the order, usually the most prominent text on the artwork<br />
							<strong>Decoration Method:</strong> Decoration process for the order<br />
							<strong>Quantity:</strong> Order quantity <br />
							<strong>Value:</strong> Total order value<br />
							<strong>Order Date:</strong> Date that the order was accepted<br />
							<strong>Ship Date:</strong> Date that the order is due to be shipped or was scheduled to be shipped on, indicative until order is approved<br />
							<strong>Delivery Address:</strong> shipping address<br />
							<strong>Contact Email:</strong> the distributors email contact for the order<br />
							<strong>Invoice:</strong> URL to the order invoice<br />
							<strong>Invoice Number:</strong> TRENDS invoice number<br />
							<strong>Proof:</strong> URL to the artwork proof<br />
							<strong>Photo:</strong> URL to the final product image<br />
							<strong>Tracking:</strong> URL to the shipment tracking<br />
							<strong><u>Order Lines</u></strong><br />
								<div style="margin-left:25px; width:100%">
									<strong>Code:</strong> TRENDS internal component code<br />
									<strong>Description:</strong> Description of the component<br />
									<strong>Quantity:</strong> Quantity of product ordered<br />
									<strong>Price:</strong> Unit cost of the product<br />
									<strong>Gross:</strong> Unit cost X the quantity<br />
								</div>
							<strong><u>Time Stamps</u></strong><br />
								<div style="margin-left:25px; width:100%">
									<strong>Order Received:</strong> Timestamp of when the order was entered into TRENDS system <br />
									<strong>Last Proofed:</strong> Timestamp of when the order proof was last updated<br />
									<strong>Order Approved:</strong> Timestamp of when the order was accepted by TRENDS<br />
									<strong>Dispatch:</strong> Timestamp of when the order was dispatched <br />
									<strong>Invoiced:</strong>  Timestamp of when the order was invoiced<br />
								</div>

						</div>	





						<h3>Code Examples</h3> 
						<h5>PHP</h5> 
						<div class="alert alert-secondary" role="alert"> 
							<pre   class="prettyprint">
								/**
								* Returns categories with subcategories
								* @param $username for basic authentication
								* @param $password for basic authentication
								* @param $baseUrl base url for the curl call 
								i.e. https://<?php echo $apiLocation; ?>.api.trends.nz
								* @param $apiVersion api version
								* @param $format either json or xml
								*/
								function categories($username,$password,$baseUrl, $apiVersion, $format) {
									// create curl resource
									$ch = curl_init();

									$full_url = $baseUrl.'/api/'.$apiVersion."/categories.".$format;

									curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
									curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

									// set url
									curl_setopt($ch, CURLOPT_URL, $full_url);
									curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
									curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");


									$headers = array();
									$headers[] = "Accept: application/json";
									if($username !== '' && $password !== '')
									{
										$headers[] = "Authorization: Basic ". base64_encode($username.":".$password);
									}
									curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

									$result = curl_exec($ch);
									if (curl_errno($ch)) {
										echo 'Error:' . curl_error($ch);
									}
									curl_close ($ch);

									//do something with $result
									echo $result;
								}
							</pre>
						</div>	
						<h5>Javascript</h5> 
						<div class="alert alert-secondary" role="alert"> 
							<pre class="prettyprint">
								&lt;script type="text/javascript"&gt;
									function categories(username, password, baseUrl, apiVersion, format) {
										var fullUrl = baseUrl+'/api/'+apiVersion+"/categories."+format;
										var xhttp = new XMLHttpRequest();
										xhttp.withCredentials = true;
										xhttp.onreadystatechange = function() {
										if (this.readyState == 4 && this.status == 200) {
											/* do something with this.responseText */
											////console.log(this.responseText);
										}
										};
										
										xhttp.open("GET", fullUrl, true);
										xhttp.setRequestHeader("Access-Control-Allow-Origin", "*");
										xhttp.setRequestHeader("Content-Type", "application/json");
										if(username !== '' && password !== '')
										{
										xhttp.setRequestHeader("Authorization", "Basic " + btoa(username + ":" + password));
										}
										xhttp.send();
									}
								&lt;/script&gt;
							</pre>		
						</div>
						<h5>jQuery</h5> 
						<div class="alert alert-secondary" role="alert"> 
							<pre class="prettyprint">
								&lt;script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"&gt;&lt;/script&gt;
								&lt;script type="text/javascript"&gt;
									function categories(username, password, baseUrl, apiVersion, format) {
										var fullUrl = baseUrl + '/api/' + apiVersion + "/categories." + format;
										jQuery.ajax({
										type: "GET",
										xhrFields: {
											withCredentials: true
										},
										dataType: "json",
										contentType: "application/json",
										async: false,
										crossDomain: true,
										url: fullUrl,
										success: function (jsonData) {
											/* do something with jsonData */
											//console.log(jsonData);
										},
										beforeSend: function (xhr) {
											xhr.setRequestHeader('Authorization', 'Basic ' + btoa(username + ":" + password));
										}
										});
									}
								&lt;/script&gt;
							</pre>
						</div>		
						<h5>Java</h5> 
						<div class="alert alert-secondary" role="alert"> 
							<pre class="prettyprint">
								import java.io.BufferedReader;
								import java.io.InputStreamReader;
								import java.net.HttpURLConnection;
								import java.net.URL;
								import java.net.Proxy;
								import java.net.InetSocketAddress;
								import java.io.OutputStreamWriter;

								public class Curl { 
									public static void main(String[] args) {
										var username = args[0];
										var password = args[1];
										var baseUrl = args[2];
										var apiVersion = args[3];
										var format = args[4];

										try {
										String url = baseUrl + "/api/" + apiVersion + "/categories." + format;

										URL obj = new URL(url);
										HttpURLConnection conn = (HttpURLConnection) obj.openConnection();

										conn.setRequestProperty("Content-Type", "application/json");
										conn.setDoOutput(true);

										conn.setRequestMethod("GET");

										String userpass = username + ":" + password;
										String basicAuth = "Basic " + javax.xml.bind.DatatypeConverter.printBase64Binary(userpass.getBytes("UTF-8"));
										conn.setRequestProperty ("Authorization", basicAuth);

										String data =  "{\"format\":\"json\",\"pattern\":\"#\"}";
										OutputStreamWriter out = new OutputStreamWriter(conn.getOutputStream());
										out.write(data);
										out.close();

										new InputStreamReader(conn.getInputStream());

										} catch (Exception e) {
										e.printStackTrace();
										}

									} 
								}
							</pre>	
						</div>	



						</div>
					</div>
				</div>

			</div>

				
		</div> 
	</div>
</div>



<?php
	$this->load->view('footer/footer');
?> 