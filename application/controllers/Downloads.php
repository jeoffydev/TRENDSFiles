<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Downloads extends CI_Controller {
 
	
	public function __construct(){ 
		parent:: __construct();  
		$this->load->model('home_model');  
		$this->load->model('general_model'); 
		$this->load->helper('download');
 
		$this->siteLogcheck = $this->general_model->getLogcheck();  
 
		$this->name = null;
		$this->data = null; 
		$this->tb = "productsCurrent";
		$this->pT = "productsPricing";
		$this->cT = "productsChanges";
		$this->tableAdditionalOptions = "additionalOptions";
	}

	function _remap($param, $custom) {
        $this->index($param, $custom);
	}

	
	 
	public function  index($param, $custom){ 
		 
		if(empty($custom) || empty($param)){
			 redirect('/'); 
		} 

		
	 
		if($this->siteLogcheck['loggedIn'] == 1):
			
			//ZIP------------------------------------------------------------------
			if($param == 'Zip'):
			 
				if($custom[0] == 1){ 
					$this->name = 'Products.zip';
					//$iFileName = base_url()."Images/Products.zip";
					$this->data = file_get_contents("./Images/Products.zip");  
					
				}  
				if($custom[0] == 2){ 
					$this->name = 'New-Products.zip';
					//$iFileName = base_url()."Images/New-Products.zip";
					$this->data = file_get_contents("./Images/New-Products.zip");  
				} 
				if($custom[0] == 3){ 
					$this->name = 'testzip.zip';
					//$iFileName = base_url()."Images/New-Products.zip";
					$this->data = file_get_contents("./Images/testzip.zip");  
				} 
				return force_download($this->name, $this->data); 
				 
			endif;

			//Excel------------------------------------------------------------------
			if($param == 'Excel'):
				$Currency = $custom[0];

				if($Currency == "AUD") {
					$avail = "   AND availAU = 1  ";
			    }
		  
			    if($Currency == "NZD") {
					$avail = "   AND availNZ = 1  ";
				}

				if($Currency == "SGD") {
					$avail = "   AND availSG = 1  ";
				}
				
				if($Currency == "MYR") {
					$avail = "   AND availMY = 1  ";
			    }

				$query1 = "SELECT
						".$this->tb.".Code,
						".$this->tb.".Name,
						".$this->tb.".Category1,
						".$this->tb.".Category2,
						".$this->tb.".Category3,
						".$this->tb.".Category4,
						".$this->tb.".Category5,
						".$this->tb.".Category6,
						".$this->tb.".Description,
						".$this->tb.".Colours,
						".$this->tb.".ColoursSecondary,
						".$this->tb.".ThirdColours,
						".$this->tb.".ImageCount,
						".$this->tb.".Dimension1,
						".$this->tb.".Dimension2,
						".$this->tb.".Dimension3,
						
						 

						".$this->tb.".Packing,
						".$this->pT.".PrimaryPriceDes,
						".$this->pT.".Quantity1,
						".$this->pT.".Quantity2,
						".$this->pT.".Quantity3,
						".$this->pT.".Quantity4,
						".$this->pT.".Quantity5,
						".$this->pT.".Quantity6,
						".$this->pT.".Price1,
						".$this->pT.".Price2,
						".$this->pT.".Price3,
						".$this->pT.".Price4,
						".$this->pT.".Price5,
						".$this->pT.".Price6,

					 

						".$this->pT.".AdditionalText,
						".$this->tb.".cartonLength,
						".$this->tb.".cartonWidth,
						".$this->tb.".cartonHeight,
						".$this->tb.".cartonQuantity,
						".$this->tb.".cartonWeight, 
						".$this->tb.".IsMixMatch,
						".$this->tb.".IsIndentExpress,
						".$this->tb.".IsIndent,
						DATE_FORMAT(".$this->tb.".releaseDate, '%d/%m/%Y')  as releaseDate
						
						
					FROM ".$this->tb."
					JOIN ".$this->pT."
						ON ".$this->pT.".Coode = ".$this->tb.".Code
						AND (".$this->pT.".Currency = '".$Currency."')
						AND (".$this->pT.".PriceOrder = '1')
					WHERE ".$this->tb.".Active != 0
						AND ".$this->tb.".Category1 NOT LIKE '100-%'
						AND ".$this->tb.".Category1 NOT LIKE '200-%'
						AND ".$this->tb.".Category2 NOT LIKE '100-%'
						AND ".$this->tb.".Category2 NOT LIKE '200-%'
						AND ".$this->tb.".Category3 NOT LIKE '100-%'
						AND ".$this->tb.".Category3 NOT LIKE '200-%'
						AND ".$this->tb.".Category4 NOT LIKE '100-%'
						AND ".$this->tb.".Category4 NOT LIKE '200-%'
						AND ".$this->tb.".Category5 NOT LIKE '100-%'
						AND ".$this->tb.".Category5 NOT LIKE '200-%'
						AND ".$this->tb.".Category6 NOT LIKE '100-%'
						AND ".$this->tb.".Category6 NOT LIKE '200-%'
						AND ".$this->tb.".Status NOT LIKE 'D' 
						".$avail." 
					ORDER BY ".$this->tb.".Code";
				$result1 = $this->db->query($query1); 

				$query2 = "SELECT * FROM categoriesCurrent ORDER BY CategoryOrder";
				$result2 = $this->db->query($query2);
			  
			 

				$today = date("Y-m-d H:i:s");
	
				header('Content-Type: text/csv');
				if($this->siteLogcheck['userDatas'][0]->multiCurrency == 1){ 
					header('Content-Disposition: attachment;filename="Trends Export - '.$Currency." - ".$today.'.csv"');
				} else {
					header('Content-Disposition: attachment;filename="Trends Export - '.$today.'.csv"');
				}


				foreach($result2->result_array() as $row2){
					 $arrayMenu[$row2["CategoryNum"]] = $row2["CategoryName"];
				}
				 

				echo "sep=~\n";
				if ($result1) { 
					echo "~Code~Name~Category1~Category2~Category3~Category4~Category5~Category6~Description~Colours~Colours 2~Colours 3~ImageCount~Dimension1~Dimension2~Dimension3~PrintType1~PrintDescription1~PrintType2~PrintDescription2~PrintType3~PrintDescription3~PrintType4~PrintDescription4~PrintType5~PrintDescription5~PrintType6~PrintDescription6~PrintType7~PrintDescription7~PrintType8~PrintDescription8~Packing~PrimaryPriceDes~Quantity1~Quantity2~Quantity3~Quantity4~Quantity5~Quantity6~Price1~Price2~Price3~Price4~Price5~Price6~AdditionalCostDesc1~AdditionalCost1~SetupCharge1~AdditionalCostDesc2~AdditionalCost2~SetupCharge2~AdditionalCostDesc3~AdditionalCost3~SetupCharge3~AdditionalCostDesc4~AdditionalCost4~SetupCharge4~AdditionalCostDesc5~AdditionalCost5~SetupCharge5~AdditionalCostDesc6~AdditionalCost6~SetupCharge6~AdditionalCostDesc7~AdditionalCost7~SetupCharge7~AdditionalCostDesc8~AdditionalCost8~SetupCharge8~AdditionalCostDesc9~AdditionalCost9~SetupCharge9~AdditionalCostDesc10~AdditionalCost10~SetupCharge10~AdditionalCostDesc11~AdditionalCost11~SetupCharge11~AdditionalCostDesc12~AdditionalCost12~SetupCharge12~AdditionalText~CartonLength~CartonWidth~CartonHeight~CartonQuantity~CartonWeight~IsMixMatch~IndentLeadTime~ReleaseDate~\r\n";
				}

				$tempArray[] = "";
				foreach($result1->result_array() as $row1){
					 
					$tempArray['Code'] = $row1['Code'];
					$tempArray['Name'] = $this->general_model->cleanExcel($this->general_model->cleanStrExcel($row1['Name']));


					if($row1["Category1"]){
						 
						$tempExp = explode("-",$row1["Category1"]);
						$tempArray["Category1"] = $arrayMenu[$tempExp[0]."-0"]."/".$this->general_model->cleanExcel($arrayMenu[$row1["Category1"]]);
						if($tempArray["Category1"] == "/") {
							$tempArray["Category1"] = " ";
						}  
					}else{
						$tempArray["Category1"] = " ";
					} 

					
					if($row1["Category2"]){
						 
						$tempExp = explode("-",$row1["Category2"]);
						$tempArray["Category2"] = $arrayMenu[$tempExp[0]."-0"]."/".$this->general_model->cleanExcel($arrayMenu[$row1["Category2"]]);
						if($tempArray["Category2"] == "/") {
							$tempArray["Category2"] = " ";
						} 
						 
					}else{
						$tempArray["Category2"] = " ";
					} 

					if($row1["Category3"]){
						 
						$tempExp = explode("-",$row1["Category3"]);
						$tempArray["Category3"] = $arrayMenu[$tempExp[0]."-0"]."/".$this->general_model->cleanExcel($arrayMenu[$row1["Category3"]]);
						if($tempArray["Category3"] == "/") {
							$tempArray["Category3"] = " ";
						}   
					}else{
						$tempArray["Category3"] = " ";
					} 

					if($row1["Category4"]){
						 
						$tempExp = explode("-",$row1["Category4"]);
						$tempArray["Category4"] = $arrayMenu[$tempExp[0]."-0"]."/".$this->general_model->cleanExcel($arrayMenu[$row1["Category4"]]);
						if($tempArray["Category4"] == "/") {
							$tempArray["Category4"] = " ";
						}  
					}else{
						$tempArray["Category4"] = " ";
					}   

					if($row1["Category5"]){
						 
						$tempExp = explode("-",$row1["Category5"]);
						$tempArray["Category5"] = $arrayMenu[$tempExp[0]."-0"]."/".$this->general_model->cleanExcel($arrayMenu[$row1["Category5"]]);
						if($tempArray["Category5"] == "/") {
							$tempArray["Category5"] = " ";
						}  
					}else{
						$tempArray["Category5"] = " ";
					}   
 
					if($row1["Category6"]){
						 
						$tempExp = explode("-",$row1["Category6"]);
						$tempArray["Category6"] = $arrayMenu[$tempExp[0]."-0"]."/".$this->general_model->cleanExcel($arrayMenu[$row1["Category6"]]);
						if($tempArray["Category6"] == "/") {
							$tempArray["Category6"] = " ";
						}  
					}else{
						$tempArray["Category6"] = " ";
					} 

					$tempArray['Description'] = $this->general_model->cleanExcel($row1['Description']);
					$tempArray['Colours'] = $row1['Colours'];
					$tempArray['ColoursSecondary'] = $row1['ColoursSecondary'];
					$tempArray['ThirdColours'] = $row1['ThirdColours'];
					$tempArray["ImageCount"] = $row1["ImageCount"] + 1;

					$tempArray['Dimension1'] = $row1['Dimension1'];
					$tempArray['Dimension2'] = $row1['Dimension2'];
					$tempArray['Dimension3'] = $row1['Dimension3'];



					/***************** BRANDING ******************************/ 

					$arraysBrandingFinalTemp = $this->additionalOptionsDataByCode($row1['Code']);
						/* echo "<pre>";
						print_r($arraysBrandingFinalTemp);
						echo "</pre>";  */


						for($x = 1; $x < 9; $x++){

							$tempArray["PrintType".$x] = " ";
							$tempArray["PrintDescription".$x] = " ";

							if($arraysBrandingFinalTemp[$x]["brandingMethod"]){ 
								$tempArray["PrintType".$x] =  $arraysBrandingFinalTemp[$x]["brandingMethod"];
								$tempArray["PrintDescription".$x] =  $this->general_model->cleanExcel($arraysBrandingFinalTemp[$x]["brandingArea"]);
										 
							}  

						}  	 
					 
					//$tempArray["additionalOptionCategory"] = $arraysBrandingFinalTemp[1]["additionalOptionCategory"];  

					/***************** BRANDING ******************************/ 
					
					$tempArray['Packing'] = $row1['Packing'];
					$tempArray['PrimaryPriceDes'] = $row1['PrimaryPriceDes'];
					$tempArray['Quantity1'] = $row1['Quantity1'];
					$tempArray['Quantity2'] = $row1['Quantity2'];
					$tempArray['Quantity3'] = $row1['Quantity3'];
					$tempArray['Quantity4'] = $row1['Quantity4'];
					$tempArray['Quantity5'] = $row1['Quantity5'];
					$tempArray['Quantity6'] = $row1['Quantity6'];

					$tempArray['Price1'] = $row1['Price1'];
					$tempArray['Price2'] = $row1['Price2'];
					$tempArray['Price3'] = $row1['Price3'];
					$tempArray['Price4'] = $row1['Price4'];
					$tempArray['Price5'] = $row1['Price5'];
					$tempArray['Price6'] = $row1['Price6'];


					/* UPGRADE ADDITIONAL COST ********************/

					for($ac = 1; $ac < 13; $ac++){

						$tempArray["AdditionalCostDesc".$ac] = " ";
						$tempArray["AdditionalCost".$ac] = " ";
						$tempArray["SetupCharge".$ac] = " ";

						if($arraysBrandingFinalTemp[$ac]["costDescription"]){ 
							$tempArray["AdditionalCostDesc".$ac] =  $arraysBrandingFinalTemp[$ac]["costDescription"];
							$tempArray["AdditionalCost".$ac] =   $arraysBrandingFinalTemp[$ac][$Currency."UnitPrice"];
							$tempArray["SetupCharge".$ac] =   $arraysBrandingFinalTemp[$ac][$Currency."OrderPrice"];
									 
						}  

					}  	 
					/* UPGRADE  ADDITIONAL COST ********************/



					/*
 					$tempArray['AdditionalCostDesc1'] = $row1['AdditionalCostDesc1'];
					$tempArray['AdditionalCost1'] = $row1['AdditionalCost1'];
					$tempArray['SetupCharge1'] = $row1['SetupCharge1'];

					$tempArray['AdditionalCostDesc2'] = $row1['AdditionalCostDesc2'];
					$tempArray['AdditionalCost2'] = $row1['AdditionalCost2'];
					$tempArray['SetupCharge2'] = $row1['SetupCharge2'];

					$tempArray['AdditionalCostDesc3'] = $row1['AdditionalCostDesc3'];
					$tempArray['AdditionalCost3'] = $row1['AdditionalCost3'];
					$tempArray['SetupCharge3'] = $row1['SetupCharge3'];

					$tempArray['AdditionalCostDesc4'] = $row1['AdditionalCostDesc4'];
					$tempArray['AdditionalCost4'] = $row1['AdditionalCost4'];
					$tempArray['SetupCharge4'] = $row1['SetupCharge4'];

					$tempArray['AdditionalCostDesc5'] = $row1['AdditionalCostDesc5'];
					$tempArray['AdditionalCost5'] = $row1['AdditionalCost5'];
					$tempArray['SetupCharge5'] = $row1['SetupCharge5'];

					$tempArray['AdditionalCostDesc6'] = $row1['AdditionalCostDesc6'];
					$tempArray['AdditionalCost6'] = $row1['AdditionalCost6'];
					$tempArray['SetupCharge6'] = $row1['SetupCharge6'];

					$tempArray['AdditionalCostDesc7'] = $row1['AdditionalCostDesc7'];
					$tempArray['AdditionalCost7'] = $row1['AdditionalCost7'];
					$tempArray['SetupCharge7'] = $row1['SetupCharge7'];

					$tempArray['AdditionalCostDesc8'] = $row1['AdditionalCostDesc8'];
					$tempArray['AdditionalCost8'] = $row1['AdditionalCost8'];
					$tempArray['SetupCharge8'] = $row1['SetupCharge8'];

					$tempArray['AdditionalCostDesc9'] = $row1['AdditionalCostDesc9'];
					$tempArray['AdditionalCost9'] = $row1['AdditionalCost9'];
					$tempArray['SetupCharge9'] = $row1['SetupCharge9'];

					$tempArray['AdditionalCostDesc10'] = $row1['AdditionalCostDesc10'];
					$tempArray['AdditionalCost10'] = $row1['AdditionalCost10'];
					$tempArray['SetupCharge10'] = $row1['SetupCharge10'];

					$tempArray['AdditionalCostDesc11'] = $row1['AdditionalCostDesc11'];
					$tempArray['AdditionalCost11'] = $row1['AdditionalCost11'];
					$tempArray['SetupCharge11'] = $row1['SetupCharge11'];

					$tempArray['AdditionalCostDesc12'] = $row1['AdditionalCostDesc12'];
					$tempArray['AdditionalCost12'] = $row1['AdditionalCost12'];
					$tempArray['SetupCharge12'] = $row1['SetupCharge12'];  */

					$tempArray['AdditionalText'] = $row1['AdditionalText'];
					$tempArray['CartonLength'] = $row1['cartonLength'];
					$tempArray['CartonWidth'] = $row1['cartonWidth'];

					$tempArray['CartonHeight'] = $row1['cartonHeight'];  
					$tempArray['CartonQuantity'] = $row1['cartonQuantity'];
					$tempArray['CartonWeight'] = $row1['cartonWeight'];

					$tempArray['IsMixMatch'] = $row1['IsMixMatch'];

					 if($row1['IsIndentExpress'] !== "") {
						$tempArray['IndentLeadTime'] = $row1['IsIndentExpress']." days";
					} else {
						if($row1['IsIndent'] !== "") {
							$tempArray['IndentLeadTime'] = $row1['IsIndent']." weeks";
						} else {
							$tempArray['IndentLeadTime'] = "   ";
						}
					}

					$tempArray['releaseDate'] =  $row1['releaseDate'];  

					 $this->echocsv($tempArray); 

					 /* echo "<pre>";
						print_r($tempArray);
						echo "</pre>";  */
					 
				 
				} 
				

			endif;	

			//APPA------------------------------------------------------------------
			if($param == 'APPA'):
				$Currency = $custom[0];

				if($Currency == "AUD") {
					$avail = "   AND ".$this->tb.".availAU = 1  ";
			    }
		  
			    if($Currency == "NZD") {
					$avail = "   AND ".$this->tb.".availNZ = 1  ";
				}
				
				
				if($Currency == "SGD") {
					$avail = "   AND ".$this->tb.".availSG = 1  ";
				}
				
				if($Currency == "MYR") {
					$avail = "   AND ".$this->tb.".availMY = 1  ";
			    }

				$query1 = "SELECT
							'' as member_supplier_name,
							'' as membership_number,
							'' as catalogue_name,
							'' as brand_name,
							'' as label_name,
							'' as appa_product_code,
							".$this->tb.".Code as product_code,
							".$this->tb.".Name as product_name,
							'' as product_code_group,
							".$this->tb.".Category1 as categorisation,
							".$this->tb.".Category2 as 'category_ /_ sub category',
							'' as additional_keywords,
							'' as product_tags,
							'No' as discontinued_stock,
							".$this->tb.".Description as product_description,
							'' as description_additional,
							'' as product_features,
							'' as product_materials,
							".$this->tb.".Dimension1 as product_item_size,
							".$this->tb.".Packing as product_packaging_inner,
							CONCAT(".$this->tb.".Code, '-0.jpg') AS product_image_file_name,
							'' as alternate_views_image_file_names,
							'' as group_image_file_name,
							".$this->tb.".ColorSearch as colours_available_appa,
							'' as colours_available_supplier,
							".$this->tb.".ImageCount as colour_image_file_names,
							'' as colour_product_codes,
							'' as product_sizes,
							'' as size_images,
							'' as size_product_code,
							 
							'' as decoration_options_available,	
						 
							'' as decoration_areas,
							 
							'' as indent_only,
							'' as branded,
							'' as custom_field_1,
							'' as custom_field_2,
							'' as custom_field_3,
							'' as price_decoration_description,
							'' as price_by_size,
							'' as price_by_colour,
							'' as decoration_type,
							'' as price_product_code,
							'' as price_notes,
							".$this->pT.".Quantity1 as MOQ,
							'' as IOQ,
							".$this->pT.".Quantity1 as qty_1,
							".$this->pT.".Price1 as price_1,
							".$this->pT.".Quantity2 as qty_2,
							".$this->pT.".Price2 as price_2,
							".$this->pT.".Quantity3 as qty_3,
							".$this->pT.".Price3 as price_3,
							".$this->pT.".Quantity4 as qty_4,
							".$this->pT.".Price4 as price_4,
							".$this->pT.".Quantity5 as qty_5,
							".$this->pT.".Price5 as price_5,
							'' as qty_6,
							'' as price_6,
							'' as qty_7,
							'' as price_7,
							'' as qty_8,
							'' as price_8,
						 

							'' as additional_charges_name1,
							'' as additional_charge_value1,
							'' as additional_charges_notes1,

							'' as additional_charges_name2,
							'' as additional_charge_value2,
							'' as additional_charges_notes2,

 
							".$this->tb.".cartonHeight as carton_height,
							".$this->tb.".cartonWidth as carton_width,
							".$this->tb.".cartonLength as carton_depth,
							".$this->tb.".cartonWeight as carton_weight,
							".$this->tb.".cartonQuantity as carton_qty,
							((".$this->tb.".cartonLength * ".$this->tb.".cartonWidth * ".$this->tb.".cartonHeight) / 1000000) as carton_cubic,
							'' as carton_notes,
							'' as freight_description,			
							CONCAT('http://www.trends.nz/item/', ".$this->tb.".Code) AS product_URL
						FROM ".$this->tb."

						 

						JOIN ".$this->pT."
							ON ".$this->pT.".Coode = ".$this->tb.".Code
							AND (".$this->pT.".Currency = '".$Currency."')
							AND (".$this->pT.".PriceOrder = '1')
						WHERE ".$this->tb.".Active != 0
							AND ".$this->tb.".Category1 NOT LIKE '100-%'
							AND ".$this->tb.".Category1 NOT LIKE '200-%'
							AND ".$this->tb.".Category2 NOT LIKE '100-%'
							AND ".$this->tb.".Category2 NOT LIKE '200-%'
							AND ".$this->tb.".Category3 NOT LIKE '100-%'
							AND ".$this->tb.".Category3 NOT LIKE '200-%'
							AND ".$this->tb.".Category4 NOT LIKE '100-%'
							AND ".$this->tb.".Category4 NOT LIKE '200-%'
							AND ".$this->tb.".Category5 NOT LIKE '100-%'
							AND ".$this->tb.".Category5 NOT LIKE '200-%'
							AND ".$this->tb.".Category6 NOT LIKE '100-%'
							AND ".$this->tb.".Category6 NOT LIKE '200-%'
							AND ".$this->tb.".Status NOT LIKE 'D' 
							".$avail."  
					ORDER BY ".$this->tb.".Code";
					$result1 = $this->db->query($query1); 

					$query2 = "SELECT * FROM categoriesCurrent ORDER BY CategoryOrder";
					$result2 = $this->db->query($query2);
				  
				 
	
					$today = date("Y-m-d H:i:s");
		 
				    header('Content-Type: text/csv');
					if($this->siteLogcheck['userDatas'][0]->multiCurrency == 1){ 
						header('Content-Disposition: attachment;filename="APPA Export  - '.$Currency." - ".$today.'.csv"');
					} else {
						header('Content-Disposition: attachment;filename="APPA Export  - '.$today.'.csv"');
					}  
	
					$row1 = $result1->result_array();
					foreach($result2->result_array() as $row2){
						 $arrayMenu[$row2["CategoryNum"]] = $row2["CategoryName"];
					}
					 
					 
					echo "sep=~\n";
					if ($row1) {
						$this->echocsv(array_keys($row1[0]));
					}

					$tempArray[] = "";
					foreach($result1->result_array() as $row1){
					  
						$tempArray = $row1; 
						$tempArray["product_description"] = $this->general_model->cleanExcel($tempArray["product_description"]);
						$tempArray["product_name"] = $this->general_model->cleanExcel($this->general_model->cleanStrExcel($tempArray["product_name"]));
						/*$tempDecs1 = preg_replace('/\|\|+/', '', $tempArray["decoration_options_available"]);
						$tempArray["decoration_options_available"] = $tempDecs1; */

						/*************** UPGRADE BRANDING PRINT1 to PRINT 12 ****************/	
						$arraysBrandingFinalTemp = $this->additionalOptionsDataByCode($row1['product_code']);
						/* echo "<pre>";
						print_r($arraysBrandingFinalTemp);
						echo "</pre>"; */ 
						
						$branding = $this->additionaOptionsBrandingData($arraysBrandingFinalTemp);  
						$tempArray["decoration_options_available"] =  $branding; 
						/*************** UPGRADE BRANDING PRINT1 to PRINT 12 ****************/	 

						
						/*$tempDecs2 = preg_replace('/\| \|+/', '', $this->general_model->cleanExcel($tempArray["decoration_areas"]));
						$tempDecs3 = preg_replace('/\s\s+/', '', $tempDecs2);
						$tempArray["decoration_areas"] = rtrim($tempDecs3, '|'); */


						/*************** UPGRADE BRANDING PRINT1 to PRINT 12 ****************/	 
						$brandingComplete = $this->additionaOptionsBrandingDataComplete($arraysBrandingFinalTemp);  
						$tempArray["decoration_areas"] =  $brandingComplete; 
						/*************** UPGRADE BRANDING PRINT1 to PRINT 12 ****************/	



						/*************** UPGRADE ADDITIONAL COST 1 to 2 ****************/	 
						$additionalCosts = $this->additionaOptionsAdditionalCostData($arraysBrandingFinalTemp, $Currency, 3);
						//print_r($additionalCosts);
						for($ads = 1; $ads < 3; $ads++){
							$tempArray["additional_charges_name".$ads] =  $additionalCosts[$ads]['costDescription']; 
							$tempArray["additional_charge_value".$ads] =  $additionalCosts[$ads][$Currency.'UnitPrice']; 
						}
						
						/*************** UPGRADE ADDITIONAL COST 1 to 2 ****************/	



						
						$tempCols = preg_replace('/\s+/', '|', $tempArray["colours_available_appa"]);
						$tempCols2 = str_replace('bgreen', 'bright green', $tempCols);
						$tempCols3 = str_replace('dgreen', 'dark green', $tempCols2);
						$tempCols4 = str_replace('lBlue', 'light blue', $tempCols3);
						$tempArray["colours_available_appa"] = $tempCols4;
						
						$tempArray["colour_image_file_names"] = "";

						$x = 1;
						while($x <= $row1["colour_image_file_names"]) {
							if($x == 1) {
								$tempArray["colour_image_file_names"] .= $tempArray["product_code"]."-".$x.".jpg";
							}
							$tempArray["colour_image_file_names"] .= "|".$tempArray["product_code"]."-".$x.".jpg";
							$x++;
						}
						$tempExp = explode("-",$row1["categorisation"]);
						$tempArray["categorisation"] = $this->general_model->cleanExcel($arrayMenu[$tempExp[0]."-0"]);
						$tempArray["category_ /_ sub category"] = $this->general_model->cleanExcel($tempArray["categorisation"])."/".$this->general_model->cleanExcel($arrayMenu[$row1["categorisation"]]);
						$this->echocsv($tempArray);

						

						/* echo "<pre>";
					 	print_r($tempArray);
					 	echo "</pre>"; */
					}

			endif;



			//Xebra------------------------------------------------------------------
			if($param == 'Xebra'):
				$Currency = $custom[0];

				if($Currency == "NZD") {
					$priceBlurb = "New Zealand.";
					$avail = "   AND ".$this->tb.".availNZ = 1  ";
				} /*else {
					$priceBlurb = "Australia or New Zealand.";
					$avail = "   AND ".$this->tb.".availAU = 1  ";
				} */
				if($Currency == "AUD") {
					$priceBlurb = "Australia.";
					$avail = "   AND ".$this->tb.".availAU = 1  ";
				} 
				if($Currency == "SGD") {
					$priceBlurb = "Singapore.";
					$avail = "   AND ".$this->tb.".availSG = 1  ";
				}
				if($Currency == "MYR") {
					$priceBlurb = "Malaysia.";
					$avail = "   AND ".$this->tb.".availMY = 1  ";
				}
 

				$query1 = "SELECT
							".$this->tb.".Code as Item,
							".$this->tb.".Name,
							".$this->tb.".Description as ShortDescription,
							CONCAT(".$this->tb.".Code,'-0.jpg') as Image,
							".$this->tb.".Category1 as Cat1,
							".$this->tb.".Category1 as Cat1Sub1,
							'' as Cat1Sub2,
							'' as Cat2,
							'' as Cat2Sub1,
							'' as Cat2Sub2,
							CONCAT(".$this->tb.".Description,' Colours: ',".$this->tb.".Colours,' Dimension: ',".$this->tb.".Dimension1,' Print Description: ',".$this->tb.".PrintDescription1,' Print Type: ',".$this->tb.".PrintType1,'. Packing: ',".$this->tb.".Packing, if(".$this->pT.".LessThanMOQ = 'N',' Less than minimum quantities are not available for this item.',''),' ',".$this->pT.".AdditionalText) as LongDescription1,
							'Ea' as UOM,
							".$this->pT.".Quantity1 as MinimumQuantity,
							".$this->pT.".Price1 * 2.5 as SRP,
							'Catalogue Updated ".date("d/m/y").". Price includes delivery to one location in ".$priceBlurb."' as OrderingInfo1,
							'QUANTITIES' as A1,
							".$this->pT.".Quantity1 as A2,
							".$this->pT.".Quantity2 as A3,
							".$this->pT.".Quantity3 as A4,
							".$this->pT.".Quantity4 as A5,
							".$this->pT.".Quantity5 as A6,
							'' as A7,
							'' as A8,
							'' as A9,
							".$this->pT.".PrimaryPriceDes as B1,
							".$this->pT.".Price1 as B2,
							".$this->pT.".Price2 as B3,
							".$this->pT.".Price3 as B4,
							".$this->pT.".Price4 as B5,
							".$this->pT.".Price5 as B6,
							'' as B7,
							'' as B8,
							'' as B9, 


							'' as C1,
							'' as C2,
							'' as C3,
							'' as C4,
							'' as C5, 
							'' as C6,
							'' as C7,
							'' as C8,
							'' as C9,

							'' as D1,
							'' as D2,
							'' as D3,
							'' as D4,
							'' as D5, 
							'' as D6,
							'' as D7,
							'' as D8,
							'' as D9, 

							'' as E1,
							'' as E2,
							'' as E3,
							'' as E4, 
							'' as E5,
							'' as E6,
							'' as E7,
							'' as E8,
							'' as E9,

							'' as F1,
							'' as F2,
							'' as F3,
							'' as F4,
							'' as F5,
							'' as F6,
							'' as F7,
							'' as F8,
							'' as F9,
							
							'' as G1,
							'' as G2,
							'' as G3,
							'' as G4, 
							'' as G5,
							'' as G6,
							'' as G7,
							'' as G8,
							'' as G9,

							'' as H1,
							'' as H2,
							'' as H3,
							'' as H4, 
							'' as H5,
							'' as H6,
							'' as H7,
							'' as H8,
							'' as H9,

							'' as I1,
							'' as I2,
							'' as I3,
							'' as I4, 
							'' as I5,
							'' as I6,
							'' as I7,
							'' as I8,
							'' as I9,

							'' as J1,
							'' as J2,
							'' as J3,
							'' as J4, 
							'' as J5,
							'' as J6,
							'' as J7,
							'' as J8,
							'' as J9 
 


						FROM ".$this->tb."
						JOIN ".$this->pT."
							ON ".$this->pT.".Coode = ".$this->tb.".Code
							AND (".$this->pT.".Currency = '".$Currency."')
							AND (".$this->pT.".PriceOrder = '1')
						WHERE ".$this->tb.".Active != 0
							AND ".$this->tb.".Category1 NOT LIKE '100-%'
							AND ".$this->tb.".Category1 NOT LIKE '200-%'
							AND ".$this->tb.".Category2 NOT LIKE '100-%'
							AND ".$this->tb.".Category2 NOT LIKE '200-%'
							AND ".$this->tb.".Category3 NOT LIKE '100-%'
							AND ".$this->tb.".Category3 NOT LIKE '200-%'
							AND ".$this->tb.".Category4 NOT LIKE '100-%'
							AND ".$this->tb.".Category4 NOT LIKE '200-%'
							AND ".$this->tb.".Category5 NOT LIKE '100-%'
							AND ".$this->tb.".Category5 NOT LIKE '200-%'
							AND ".$this->tb.".Category6 NOT LIKE '100-%'
							AND ".$this->tb.".Category6 NOT LIKE '200-%'
							AND ".$this->tb.".Status NOT LIKE 'D' 
							".$avail." 
						ORDER BY ".$this->tb.".Code";
						$result1 = $this->db->query($query1); 
						$query2 = "SELECT * FROM categoriesCurrent ORDER BY CategoryOrder";
						$result2 = $this->db->query($query2);


						$today = date("Y-m-d H:i:s");
					 
						header('Content-Type: text/csv');
						if($this->siteLogcheck['userDatas'][0]->multiCurrency == 1){ 
							header('Content-Disposition: attachment;filename="Xebra Export   - '.$Currency." - ".$today.'.csv"');
						} else {
							header('Content-Disposition: attachment;filename="Xebra Export   - '.$today.'.csv"');
						}   
		
						$row1 = $result1->result_array(); 

						foreach($result2->result_array() as $row2){
							$renamer1[$row2["CategoryNum"]] = $row2["XebraCode1"];
							$renamer2[$row2["CategoryNum"]] = $row2["XebraCode2"];
						}

						echo "sep=~\n";
						if ($row1) {
							//echocsv(array_keys($row1));
							echo "Item~Name~ShortDescription~Image~Cat1~Cat1Sub1~Cat1Sub2~Cat2~Cat2Sub1~Cat2Sub2~LongDescription1~UOM~MinimumQuantity~SRP~OrderingInfo1~A1~A2~A3~A4~A5~A6~A7~A8~A9~B1~B2~B3~B4~B5~B6~B7~B8~B9~C1~C2~C3~C4~C5~C6~C7~C8~C9~D1~D2~D3~D4~D5~D6~D7~D8~D9~E1~E2~E3~E4~E5~E6~E7~E8~E9~F1~F2~F3~F4~F5~F6~F7~F8~F9~G1~G2~G3~G4~G5~G6~G7~G8~G9~H1~H2~H3~H4~H5~H6~H7~H8~H9~I1~I2~I3~I4~I5~I6~I7~I8~I9~J1~J2~J3~J4~J5~J6~J7~J8~J9~\r\n";
						}

						$tempArray[] = "";
						foreach($result1->result_array() as $row1){
							 
							$tempArray =  $row1;
							$tempArray["Name"] =$this->general_model->cleanExcel($this->general_model->cleanStrExcel($row1["Name"]));
							$tempExp = explode("-",$row1["Cat1"]);
							$tempArray["Cat1"] = $renamer1[$row1["Cat1"]];
							$tempArray["Cat1Sub1"] = $renamer2[$row1["Cat1Sub1"]];


								/*************** UPGRADE ADDITIONAL COST 1 to 9 ****************/	
							 
								$arraysBrandingFinalTemp = $this->additionalOptionsDataByCode($row1['Item']); 
								//$additionalCosts = $this->additionaOptionsAdditionalCostData($arraysBrandingFinalTemp, $Currency, 10);
								  
	
								 for($ads = 1; $ads < 10; $ads++){
	
										if($ads == 1){
											if($arraysBrandingFinalTemp[$ads]["costDescription"]){
												$tempArray["C1"] =  $arraysBrandingFinalTemp[$ads]["costDescription"];  
												$tempArray["C2"] =  $arraysBrandingFinalTemp[$ads][$Currency."UnitPrice"];  
												$tempArray["C3"] =  "SETUP"; 
												$tempArray["C4"] =  $arraysBrandingFinalTemp[$ads][$Currency."OrderPrice"];  
											} 
										} 
	
										if($ads == 2){
											if($arraysBrandingFinalTemp[$ads]["costDescription"]){
												$tempArray["D1"] =  $arraysBrandingFinalTemp[$ads]["costDescription"];  
												$tempArray["D2"] =  $arraysBrandingFinalTemp[$ads][$Currency."UnitPrice"];  
												$tempArray["D3"] =  "SETUP"; 
												$tempArray["D4"] =  $arraysBrandingFinalTemp[$ads][$Currency."OrderPrice"];  
											}
											
										} 
	
										if($ads == 3){
											if($arraysBrandingFinalTemp[$ads]["costDescription"]){
												$tempArray["E1"] =  $arraysBrandingFinalTemp[$ads]["costDescription"];  
												$tempArray["E2"] =  $arraysBrandingFinalTemp[$ads][$Currency."UnitPrice"];  
												$tempArray["E3"] =  "SETUP"; 
												$tempArray["E4"] =  $arraysBrandingFinalTemp[$ads][$Currency."OrderPrice"];   
											} 
										} 
	
										if($ads == 4){
											if($arraysBrandingFinalTemp[$ads]["costDescription"]){
												$tempArray["F1"] =  $arraysBrandingFinalTemp[$ads]["costDescription"];  
												$tempArray["F2"] =  $arraysBrandingFinalTemp[$ads][$Currency."UnitPrice"];  
												$tempArray["F3"] =  "SETUP"; 
												$tempArray["F4"] =  $arraysBrandingFinalTemp[$ads][$Currency."OrderPrice"];   
											} 
										} 
	
										if($ads == 5){
											if($arraysBrandingFinalTemp[$ads]["costDescription"]){
												$tempArray["G1"] =  $arraysBrandingFinalTemp[$ads]["costDescription"];  
												$tempArray["G2"] =  $arraysBrandingFinalTemp[$ads][$Currency."UnitPrice"];  
												$tempArray["G3"] =  "SETUP"; 
												$tempArray["G4"] =  $arraysBrandingFinalTemp[$ads][$Currency."OrderPrice"];   
											} 
										} 
	
										if($ads == 6){
											if($arraysBrandingFinalTemp[$ads]["costDescription"]){
												$tempArray["H1"] =  $arraysBrandingFinalTemp[$ads]["costDescription"];  
												$tempArray["H2"] =  $arraysBrandingFinalTemp[$ads][$Currency."UnitPrice"];  
												$tempArray["H3"] =  "SETUP"; 
												$tempArray["H4"] =  $arraysBrandingFinalTemp[$ads][$Currency."OrderPrice"];   
											} 
										} 
	
										if($ads == 7){
											if($arraysBrandingFinalTemp[$ads]["costDescription"]){
												$tempArray["I1"] =  $arraysBrandingFinalTemp[$ads]["costDescription"];  
												$tempArray["I2"] =  $arraysBrandingFinalTemp[$ads][$Currency."UnitPrice"];  
												$tempArray["I3"] =  "SETUP"; 
												$tempArray["I4"] =  $arraysBrandingFinalTemp[$ads][$Currency."OrderPrice"];   
											} 
										} 
	
										if($ads == 8){
											if($arraysBrandingFinalTemp[$ads]["costDescription"]){
												$tempArray["J1"] =  $arraysBrandingFinalTemp[$ads]["costDescription"];  
												$tempArray["J2"] =  $arraysBrandingFinalTemp[$ads][$Currency."UnitPrice"];  
												$tempArray["J3"] =  "SETUP"; 
												$tempArray["J4"] =  $arraysBrandingFinalTemp[$ads][$Currency."OrderPrice"];   
											} 
										} 
										
									 
								 
								 }  
								 
								
								/*************** UPGRADE ADDITIONAL COST 1 to 9 ****************/	 


							$this->echocsv($tempArray); 

							/*	echo "<pre>";
					 		print_r($tempArray);
							 echo "</pre>"; */
							 

						}


			endif;

			//Changes------------------------------------------------------------------
			if($param == 'Changes'):

				 
				 if($custom[0] == 1):
						$availOnly = "";
						if($this->siteLogcheck['loggedIn'] == 1){

							$Currency = $this->siteLogcheck['userDatas'][0]->Currency;
							 
							$NZDID = 1;
							$AUDID = 7;
							$SGDID = 13;
							$MYRID = 14; 

							if($Currency == "NZD"){
								$changeTypeID = $NZDID;
								$NZDID = null;
							}
							if($Currency == "AUD"){
								$changeTypeID = $AUDID;
								$AUDID = null;
							}
							if($Currency == "SGD"){
								$changeTypeID = $SGDID;
								$SGDID = null;
							}
							if($Currency == "MYR"){
								$changeTypeID = $MYRID;
								$MYRID = null;
							}
 		

							$arrayCurrency = array(
								$NZDID, 
								$AUDID, 
								$SGDID, 
								$MYRID
							);
						 
							foreach($arrayCurrency as $c){
								if($c != null || $c != ""){
									$arrs[] = $c;
								}
							}
							$implodes = implode (", ", $arrs);
							 
							//echo $implodes;
 
							//$availOnly = "  WHERE ".$this->cT.".ChangeType =  ".$changeTypeID;
							$availOnly = "  WHERE ".$this->cT.".ChangeType  NOT IN (".$implodes.")";
							//echo $availOnly;
						}
						$query1 = "SELECT
								".$this->cT.".DateChange,
								".$this->tb.".Code,
								".$this->tb.".Name,
								".$this->cT.".ChangeType,
								".$this->cT.".Description
							FROM ".$this->cT."
							LEFT JOIN ".$this->tb."
								ON ".$this->cT.".Code = ".$this->tb.".Code 
								".$availOnly."
							ORDER BY ".$this->cT.".DateChange DESC";
							$result1 = $this->db->query($query1); 
							
						
						$query2 = "SELECT * FROM productChangeTypes";
						$result2 = $this->db->query($query2);
						 
 
				 		$today = date("Y-m-d H:i:s"); 
						header('Content-Type: text/csv');
						header('Content-Disposition: attachment;filename="Trends Changelog - '.$today.'.csv"');
 

						foreach($result2->result_array() as $row2){
							$arrayMenu[$row2["indexNum"]] = $row2["changeType"]; 
						}

						
						$row1 = $result1->result_array(); 
						 
						
						echo "sep=~\n";
						if ($row1) { 
							echo "Date~Product Code~Product Name~Change Type~Change Description~\r\n";
						}
 
						$tempArray[] = "";
						foreach($result1->result_array() as $row1){
							$tempArray = $row1;
							$tempArray["Name"] =  $this->general_model->cleanExcel($this->general_model->cleanStrExcel($row1["Name"]));
							$tempArray["ChangeType"] = $arrayMenu[$row1["ChangeType"]];
							$tempArray["DateChange"] = date('Y-m-d', strtotime($row1["DateChange"]));
							$this->echocsv($tempArray); 
						}   


				endif; 
				
			endif;

			
		else: 
			
			redirect('/'); 
		endif;   
	}



	public function additionalOptionsDataByCode($code){

		$resultsBrandingFinal1 = []; 
		$resultsBrandingFinal2 = [];
		$resultsBrandingFinal3 = [];


		$queryBranding1 = "SELECT ProductCode, PricingType, costDescription, brandingMethod, brandingArea, additionalOptionCategory, NZDUnitPrice, NZDOrderPrice, AUDUnitPrice, AUDOrderPrice FROM ".$this->tableAdditionalOptions." WHERE ProductCode = '".$code."' AND PricingType='Stock'  ORDER BY orderRow  ASC  ";
		$resultBranding1 = $this->db->query($queryBranding1);
		$resultsBrandingFinal1 = $resultBranding1->result_array(); 

		$queryBranding2 = "SELECT ProductCode, PricingType, costDescription, brandingMethod, brandingArea, additionalOptionCategory, NZDUnitPrice, NZDOrderPrice, AUDUnitPrice, AUDOrderPrice FROM ".$this->tableAdditionalOptions." WHERE ProductCode = '".$code."' AND PricingType='Indent - Air'  ORDER BY orderRow  ASC  ";
		$resultBranding2 = $this->db->query($queryBranding2);
		$resultsBrandingFinal2 = $resultBranding2->result_array(); 

		$queryBranding3 = "SELECT ProductCode, PricingType, costDescription, brandingMethod, brandingArea, additionalOptionCategory, NZDUnitPrice, NZDOrderPrice, AUDUnitPrice, AUDOrderPrice FROM ".$this->tableAdditionalOptions." WHERE ProductCode = '".$code."' AND PricingType='Indent - Sea'  ORDER BY orderRow  ASC  ";
		$resultBranding3 = $this->db->query($queryBranding3);
		$resultsBrandingFinal3 = $resultBranding3->result_array(); 

 		$arrayMerge = array_merge($resultsBrandingFinal1, $resultsBrandingFinal2, $resultsBrandingFinal3); 

		$arraysBrandingFinalTemp = array_combine(range(1, count($arrayMerge)), array_values($arrayMerge));

		return $arraysBrandingFinalTemp;


	}	


	
	function additionaOptionsBrandingData($arraysBrandingFinalTemp){
		$countBranding = count($arraysBrandingFinalTemp) + 1; 
		$tempArray = [];
		for($x = 1; $x < $countBranding; $x++){  
			if($arraysBrandingFinalTemp[$x]["brandingMethod"]){
				$tempArray[] =  $arraysBrandingFinalTemp[$x]["brandingMethod"];  	 
			} 	
		}  	 
		$result = implode(" | ",$tempArray);
		return $result;

	}

	function additionaOptionsBrandingDataComplete($arraysBrandingFinalTemp){
		$countBranding = count($arraysBrandingFinalTemp) + 1; 
		$tempArray = [];
		for($x = 1; $x < $countBranding; $x++){  

			if($arraysBrandingFinalTemp[$x]["brandingMethod"]){
				$tempArray[] =  $arraysBrandingFinalTemp[$x]["brandingMethod"]. "   " .$this->general_model->cleanExcel( str_replace("|","/", $arraysBrandingFinalTemp[$x]["brandingArea"]) );
			}
				  	 
		}  	 
		$result = implode(" | ",$tempArray);
		return $result;

	}


	function additionaOptionsAdditionalCostData($arraysBrandingFinalTemp, $Currency, $count){
		 
		$tempArray = [];
		for($x = 1; $x < $count; $x++){  
				$tempArray[$x]["costDescription"] =  $arraysBrandingFinalTemp[$x]["costDescription"];  	
				$tempArray[$x][$Currency."UnitPrice"] =  $arraysBrandingFinalTemp[$x][$Currency."UnitPrice"];  
		}  	 
	 
		return $tempArray;

	}

	 
		
 
	function echocsv($fields) {
		$separator = '';
		foreach ($fields as $field) {
			if (preg_match('/\\r|\\n|,|"/', $field)) {
				$field = '"' . str_replace('"', '""', $field) . '"';
			}
			echo $separator . $field;
			$separator = '~';
		}
		echo "\r\n";
	}
 
	
	
}
