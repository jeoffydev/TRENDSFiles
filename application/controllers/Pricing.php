<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pricing extends CI_Controller {
 

	public function __construct(){ 
		parent:: __construct();  

		if($_SERVER['SERVER_NAME'] == "logosource.co.nz" || $_SERVER['SERVER_NAME'] == "www.logosource.co.nz" || $_SERVER['SERVER_NAME'] == "localhost"  ) { 
			$this->tableBanners = "bannersDEV";
			$this->tableProducts = "productsCurrentDEV";
			$this->tablePricing = "productsPricingDEV";
			$this->tableStockCode = "segmentStockCode";
			$this->categoriesTable = "categoriesCurrent";
			$this->additionalOptions = 'additionalOptions';
		} else { 
			$this->tableBanners = "banners";
			$this->tableProducts = "productsCurrent";
			$this->tablePricing = "productsPricing";
			$this->tableStockCode = "segmentStockCode";
			$this->categoriesTable = "categoriesCurrent";
			$this->additionalOptions = 'additionalOptions';
		}


		$this->load->model('home_model');  
		$this->load->model('general_model'); 
		$this->load->helper('download');
		$this->load->model('api_model'); 
		$this->load->model('customsite_model');  
		$this->load->model('skinneduser_model');
		$this->load->model('resetuser_model');
		$this->load->model('checkip_model'); 
		$this->load->model('productsdisplay_model');
		$this->load->library('simpleimage');  
		$this->load->library('phpico'); 
		$this->load->model('category_model'); 
		$this->load->model('favourites_model'); 
		$this->load->model('changes_model'); 
		
		$this->siteLogcheck = $this->general_model->getLogcheck();  
	}

	 
	public function  PricingPost(){
		$request=$this->request();  
		//Cache
		$this->load->driver('cache', array('adapter'   => 'file')); 

		/* START REQUEST */
			
			/* Get the priceType to show by default or radio select*/
			if($request->option == 1){
				$FGCode = $request->FGCode;
				$PriceType = $request->PriceType;
				$FGCurrency = $request->FGCurrency;

			
				$arrayOption1 = array('Coode' => $FGCode, 'Currency' => $FGCurrency, 'PricingType' => $PriceType); 
				$this->db->select('*');
				$this->db->from($this->tablePricing);
				$this->db->where($arrayOption1);
				$dbGet = $this->db->get(); 
				$resultsT = $dbGet->row(); 
 
				$results['resultData'] =   $resultsT;
				
			 
				//Create Loop for additional costs
				$resultPricing = $resultsT;
				//print_r($resultPricing->AdditionalCostDesc1 );


				/*******************UPGRADE PRICING *******************/

				$arrayAdditional = array('ProductCode' => $FGCode,  'PricingType' => $PriceType); 
				$this->db->select('*');
				$this->db->from($this->additionalOptions);
				$this->db->where($arrayAdditional);
				$reqAdditionalOptions = $this->db->get(); 
				$reqAdditionalOptionsArrays = $reqAdditionalOptions->result(); 
 
				///Get the converted results

				$arrayConverted = array('Coode' => $FGCode, 'Currency' => $FGCurrency, 'PricingType' => $PriceType, 'Converted' => 1); 
				$this->db->select('*');
				$this->db->from($this->tablePricing);
				$this->db->where($arrayConverted);
				$reqConverted = $this->db->get(); 
				$resultsConverted = $reqConverted->result(); 

 

				//IF ADDITIONAL COST IS NOT EXIST THEN GET THE OLD FORMAT
				if(count($reqAdditionalOptionsArrays) > 0 || count($resultsConverted) > 0){ 
					 	 

						$results['priceAdditionalsUpgradeCount'] = count($reqAdditionalOptionsArrays);  

						$pr=1;
						foreach($reqAdditionalOptionsArrays as $rowUpgradeAdds){

							if($pr == 1){
								$inputVal = 1;
							}else{
								$inputVal = 0;
							} 

							$prnew = $pr - 1;

							//if($rowUpgradeAdds->costDescription){ 
								$addsUpgradeArrays[] = array(
									'adds'=>$rowUpgradeAdds->costDescription, 
									'cost'=>$rowUpgradeAdds->{$FGCurrency."UnitPrice"}, 
									'setup'=>$rowUpgradeAdds->{$FGCurrency."OrderPrice"}, 
									'fieldPosition' => $pr,
									'inputVal' => $inputVal,
									'inputVal2' => $inputVal,
									'disabled' => $prnew,
									'fieldPositionDisabled' => $pr,
									'brandingArea' => $rowUpgradeAdds->brandingArea
								);  
							//} 
							$pr++;
						}

					    $splitDCount = count($reqAdditionalOptionsArrays) + 1;
						$addsUpgradeArrays[] = array(
									'adds'=>'Split Delivery', 
									'cost'=> 0, 
									'setup'=>20, 
									'fieldPosition' => $splitDCount,
									'inputVal' => 1,
									'inputVal2' => 0,
									'disabled' => 1,
									'fieldPositionDisabled' => $splitDCount,
									'brandingArea' => null,
									'splitdelivery' => 1,
									'exception' =>  "letmein",
									'brandingArea' => 'Per Additional Address in NZ/AU'  

						);  

						$results["priceAdditionals"] = $addsUpgradeArrays;  

				}else{

				 

						//Get the OLD Format in ProductsPricing
						$x = 1;
						for($pr=1; $pr <= 12; $pr++ ){   
							if($pr == 1){
								$inputVal = 1;
							}else{
								$inputVal = 0;
							} 

							$prnew = $pr - 1;

							if($resultPricing->{"AdditionalCostDesc".$pr} != ""){ 
								$resultPricingAdditionals[]  = array(
									'adds'=>$resultPricing->{"AdditionalCostDesc".$pr}, 
									'cost'=>$resultPricing->{"AdditionalCost".$pr}, 
									'setup'=>$resultPricing->{"SetupCharge".$pr}, 
									'fieldPosition' => $pr,
									'inputVal' => $inputVal,
									'inputVal2' => $inputVal,
									'disabled' => $prnew,
									'fieldPositionDisabled' => $pr,
									'brandingArea' => null
								); 
								$x++; 
							} 
							
						}   
						
						$resultPricingAdditionals[] = array(
							'adds'=>'Split Delivery',  
							'cost'=> 0, 
							'setup'=>20, 
							'fieldPosition' => $x,
							'inputVal' => 1,
							'inputVal2' => 0,
							'disabled' => 1,
							'fieldPositionDisabled' => $x,
							'brandingArea' => null,
							'splitdelivery' => 1,
							'exception' =>  "letmein",
							'brandingArea' => 'Per Additional Address in NZ/AU' 
							  
						);  

  
						$results["priceAdditionals"] = $resultPricingAdditionals;  
						//Get the OLD Format in ProductsPricing 

				}
				
	
				/*******************UPGRADE PRICING *******************/ 
				 
				 
				//userSetup
				  
				if($userID = $this->siteLogcheck['userDatas'][0]->userID){ 
				 
					$this->db->select('*');
					$this->db->from('userData');
					$this->db->where('userID', $userID);
					$reqUSer = $this->db->get(); 
					$resultUser = $reqUSer->result();  
				
					$results["userMarkups"] = $resultUser[0];  

				} 



				/************************* Secondary account ID ***********************************/

				if($secondaryIDActive = $this->siteLogcheck['secondaryIDActive']){

					$this->db->select('*');
					$this->db->from('secondaryUserAccount');
					$this->db->where('id', $secondaryIDActive);
					$reqSec = $this->db->get(); 
					$resultSec  = $reqSec->result(); 
					 
					$results["userMarkups"]->markup1 = $resultSec[0]->markup1;
					$results["userMarkups"]->markup2 = $resultSec[0]->markup2;
					$results["userMarkups"]->markup3 = $resultSec[0]->markup3;
					$results["userMarkups"]->markup4 = $resultSec[0]->markup4;
					$results["userMarkups"]->markup5 = $resultSec[0]->markup5;
					$results["userMarkups"]->markup6 = $resultSec[0]->markup6;
					$results["userMarkups"]->setupMarkup = $resultSec[0]->setupMarkup;
				} 

				/************************* Secondary account ID ***********************************/

				if(!$request->userID){
					$results["userMarkups"] = null;
				}
			 
				$someJSON = json_encode($results);
				echo $someJSON;  
			}


			if($request->option == 2){
				$FGCode = $request->FGCode;
				$priceCurrency = $request->priceCurrency;

				$data = array(
					'Coode' =>  $FGCode,
					'Currency'=>  $priceCurrency 
				);

				$this->db->select('PricingType');
				$this->db->from($this->tablePricing);
				$this->db->where($data);
				$this->db->order_by("PriceOrder", "asc");
				$req = $this->db->get(); 
				$results  = $req->result(); 
 
				
				$someJSON = json_encode($results);
				echo $someJSON; 
	
			}

			//if user loggedin only
			if($userIDmarkup = $this->siteLogcheck['userDatas'][0]->userID){ 

				if($request->option == 3){  
					$setupMarkup = $request->setupMarkup;
					$markup1 = $request->markup1;
					$markup2 = $request->markup2;
					$markup3 = $request->markup3;
					$markup4 = $request->markup4;
					$markup5 = $request->markup5;
					$markup6 = $request->markup6;
				

					$dataUpdate = array(
						'markup1' => $markup1, 
						'markup2' => $markup2,
						'markup3' => $markup3, 
						'markup4' => $markup4, 
						'markup5' => $markup5, 
						'markup6' => $markup6 
					);

					if($secondaryIDActive = $request->secondaryIDActive){
						$this->db->set($dataUpdate);
						if($setupMarkup || ($setupMarkup == 0 && $setupMarkup != null)){ 
							$this->db->set('setupMarkup', $setupMarkup);
						}
						$this->db->where('id', $secondaryIDActive);
						$sql = $this->db->update('secondaryUserAccount');

						
					}else{

						$this->db->set($dataUpdate);
						if($setupMarkup || ($setupMarkup == 0 && $setupMarkup != null)){ 
							$this->db->set('setupMarkup', $setupMarkup);
						}
						$this->db->where('userID', $userIDmarkup);
						$sql = $this->db->update('userData');
	
					}
					
					
					if($sql){
						echo "1";
					}  
				
				}

				
				 
				if($request->option == 5){
					
					$userIDmsg = $this->siteLogcheck['userDatas'][0]->userID;
					$fgcode = $request->fgcode;
					$secAccount = $request->secAccount;
	

					if($fgcode){
						$object =  array(
							'productCode' => $fgcode, 
							'userID' =>  $userIDmsg  
						);
						$this->db->insert('quickQuoteTracker', $object);
					}

					$this->db->select('*'); 

					if($secAccount){ 
						$this->db->from('secondaryUserAccount');
						$this->db->where('userID', $userIDmsg); 
						$this->db->where('id', $secAccount);   
					}else{ 
						$this->db->from('userData');
						$this->db->where('userID', $userIDmsg);  
					} 
					$req = $this->db->get();  
					$resultUser = $req->result();    
					
					//$cleanThis = html_entity_decode($resultUser[0]->quickQuoteComment, ENT_QUOTES);
					echo  $this->general_model->cleanString($resultUser[0]->quickQuoteComment);
				}

				
				if($request->option == 6){
					$quickMsg =   htmlspecialchars($request->quickMsg, ENT_QUOTES);
					$userIDquote = $this->siteLogcheck['userDatas'][0]->userID;
					$secAccount = $request->secAccount;

					
					
						$this->db->set('quickQuoteComment', $quickMsg);  

						if($secAccount){ 
							$this->db->where('userID', $userIDquote);
							$this->db->where('id', $secAccount);
							$sql = $this->db->update('secondaryUserAccount'); 
							
						}else{
							$this->db->where('userID', $userIDquote); 
							$sql = $this->db->update('userData'); 
						}  
						if($sql){
							echo "1";
						}
						
					
				}

				
				if($request->option == 9){
					$userID  = $this->siteLogcheck['userDatas'][0]->userID;
					$cond = $request->cond;
					
					$sql = "UPDATE userData SET quoteStyle = ? WHERE userID = ?";
					$updateSetup = $this->db->query($sql, array($cond, $userID));
					
					if($updateSetup){
						echo $cond;
					}

				}
			} //if user loggedin only

			
			if($request->option == 10){
				$name  = $request->name;
				$state = $request->state; 
				 

				$this->db->select('*');
				$this->db->from('auTransitTimes');
				$this->db->where('Combined', $name); 
				$req = $this->db->get(); 
				$resultTransit  = $req->row(); 

				
				$someJSON = json_encode($resultTransit);
				echo $someJSON; 
			}

			
			if($request->option == 11){
				 
				$cacheTransits = 'saveCache_auTransitTimes'; 
				if(!$resultTransit = $this->cache->get($cacheTransits)){

					
					$this->db->select('Combined,  Postcode_from');
					$this->db->from('auTransitTimes'); 
					$this->db->order_by("Postcode_from", "asc");
					$req = $this->db->get(); 
					$resultTransit  = $req->result();  
 
					$this->cache->save($cacheTransits, $resultTransit);
				}

				$someJSON =  json_encode($resultTransit);
				echo $someJSON; 
				
			}

			if($request->option == 12){
				

				$cacheMelbourne = 'saveCache_melbourneTransitTimes';
				if(!$resultTransit = $this->cache->get($cacheMelbourne)){
					$req = $this->db->query("SELECT Combined, Postcode_from FROM melbourneTransitTimes ORDER BY Postcode_from ASC  ");  
					$resultTransit =  $req->result(); 
					$this->cache->save($cacheMelbourne, $resultTransit);
				}


				$someJSON = json_encode($resultTransit);
				echo $someJSON; 
			}

			if($request->option == 13){
				$name  = $request->name;  
				$this->db->select('*');
				$this->db->from('melbourneTransitTimes'); 
				$this->db->where('Combined', $name);  
				$req = $this->db->get(); 
				$resultTransit = $req->row(); 
 
				$someJSON = json_encode($resultTransit);
				echo $someJSON; 
			}

			if($request->option == 14){

				$skinnedCustomerNumber = $request->skinnedCustomerNumber;
				$skinnedThemeID = $request->skinnedThemeID;

				
				$this->db->select('*');
				$this->db->from('customSite'); 
				$this->db->where('CustomerNumber', $skinnedCustomerNumber); 
				$this->db->where('themeID', $skinnedThemeID);  
				$req = $this->db->get(); 
				$resultsT  = $req->row();  
 
				 
				$results['userMarkups'] = array('quoteStyle' => $resultsT->includeUnitPrice, 'setupMarkup' => $resultsT->SetupMarkup, 'markup1' => $resultsT->Q1Markup, 'markup2' => $resultsT->Q2Markup, 'markup3' => $resultsT->Q3Markup, 'markup4' => $resultsT->Q4Markup,  'markup5' => $resultsT->Q5Markup,  'markup6' => $resultsT->Q6Markup );
				 
				$someJSON = json_encode($results);
				echo $someJSON; 
			}


			if($request->option == 15){
				$FGCode = $request->FGCode;
				$PriceType = $request->PriceType;
				$FGCurrency = $request->FGCurrency;
				$skinnedSetupMarkups = $request->skinnedSetupMarkups;
				$skinnedBrandingMarkups = $request->skinnedBrandingMarkups;

				$data = array(
					'Coode' => $FGCode,
					'Currency'=> $FGCurrency,
					'PricingType' => $PriceType
				);
					
				$this->db->select('*');
				$this->db->from($this->tablePricing); 
				$this->db->where($data);
				$req = $this->db->get(); 
				$resultsT = $req->row(); 
				  
				//Create Loop for additional costs
				$resultPricing = $resultsT;
				//print_r($resultPricing->AdditionalCostDesc1 ); 


				/*******************UPGRADE PRICING *******************/

				$dataAdditionals = array(
					'ProductCode' => $FGCode,
					'PricingType' => $PriceType
				);
				$this->db->select('*');
				$this->db->from($this->additionalOptions); 
				$this->db->where($dataAdditionals);
				$this->db->order_by("orderRow", "asc");
				$reqAdditionalOptions = $this->db->get(); 
				$reqAdditionalOptionsArrays = $reqAdditionalOptions->result(); 

			 
				//IF ADDITIONAL COST IS NOT EXIST THEN GET THE OLD FORMAT
				if(count($reqAdditionalOptionsArrays) > 0){

						$results['priceAdditionalsUpgradeCount'] = count($reqAdditionalOptionsArrays); 

						$pr=1;
						foreach($reqAdditionalOptionsArrays as $rowUpgradeAdds){

							if($pr == 1){
								$inputVal = 1;
							}else{
								$inputVal = 0;
							} 

							$resultAdditionalCost = $rowUpgradeAdds->{$FGCurrency."UnitPrice"} * (($skinnedBrandingMarkups * 0.01)+1);

							//Setup Charge here
							if( $rowUpgradeAdds->{$FGCurrency."OrderPrice"} != 0 || $rowUpgradeAdds->{$FGCurrency."OrderPrice"} !== "0"){
								$custSetupRounder =$rowUpgradeAdds->{$FGCurrency."OrderPrice"} * (($skinnedSetupMarkups * 0.01)+1);
								$resultPricingSkinned = round(($custSetupRounder+5/2)/5)*5;
							}else{
								$resultPricingSkinned = 0;
							}
								

								$prnew = $pr - 1; 
						 
								$resultPricingAdditionals[] = array(
									'adds'=>$rowUpgradeAdds->costDescription, 
									'cost'=>$resultAdditionalCost, 
									'setup'=>$resultPricingSkinned, 
									'fieldPosition' => $pr,
									'inputVal' => $inputVal,
									'inputVal2' => $inputVal,
									'disabled' => $prnew,
									'fieldPositionDisabled' => $pr,
									'brandingArea' => $rowUpgradeAdds->brandingArea 
								);  
							 
							$pr++;
						}
 

				}else{

					//OLD FORMAT
					$x = 1;
					for($pr=1; $pr <= 12; $pr++ ){   
					
						if($pr == 1){
							$inputVal = 1;
						}else{
							$inputVal = 0;
						} 
						
						if($resultPricing->{"AdditionalCostDesc".$pr} != ""){  

								//Cost here 
								$resultAdditionalCost = $resultPricing->{"AdditionalCost".$pr} * (($skinnedBrandingMarkups * 0.01)+1);

								//Setup Charge here
								if( $resultPricing->{"SetupCharge".$pr} != 0 || $resultPricing->{"SetupCharge".$pr} !== "0"){
									$custSetupRounder =$resultPricing->{"SetupCharge".$pr} * (($skinnedSetupMarkups * 0.01)+1);
									$resultPricingSkinned = round(($custSetupRounder+5/2)/5)*5;
								}else{
									$resultPricingSkinned = 0;
								}
									
								$prnew = $pr - 1; 

								$resultPricingAdditionals[]  = array(
									'adds'=>$resultPricing->{"AdditionalCostDesc".$pr}, 
									'cost'=>$resultAdditionalCost, 
									'setup'=> $resultPricingSkinned, 
									'fieldPosition' => $pr,
									'inputVal' => $inputVal,
									'inputVal2' => $inputVal,
									'disabled' => $prnew,
									'fieldPositionDisabled' => $pr,
									'brandingArea' => null
								); 
								$x++; 
						}  
					}   
 

					
				}
				 
				
				 
				$results["priceAdditionals"] = $resultPricingAdditionals;   
				$someJSON = json_encode($results);
				echo $someJSON;  
			}


		/* END REQUEST */
		

	}

	public function  Changes(){
		$request=$this->request();  

		//Authorized 
		if(!$this->siteLogcheck['userDatas'][0]->userID)
			return $this->general_model->UnAuthorized();

		if($request->option == 1){ 

			$changesType=$request->changesType;   
			$opts=$request->opts;  
			$changesDesc=$request->changesDesc; 
			$changesItemCode = $request->changesItemCode; 
			if($request->indexNum){
				$indexNum = $request->indexNum;
			}else{
				$indexNum = null;
			}

			$changesform = array(
				'changeType' => $changesType,
				'opts' => $opts,
				'changesDesc' =>  $changesDesc,
				'changesItemCode' => $changesItemCode,
				'indexNum' => $indexNum

			);



			$insertChanges = $this->changes_model->changesInsertUpdate($changesform);
			$someJSON = json_encode($insertChanges);
			echo $someJSON;  
		}

		if($request->option == 2){
			$indexNum = $request->indexNum;

			$getChanges = $this->changes_model->getChangesDetails($indexNum);
			$someJSON = json_encode($getChanges);
			echo $someJSON;  
		}

		if($request->option == 3){
			$indexNum = $request->indexNum;
			$delChanges = $this->changes_model->deleteChanges($indexNum);
			$someJSON = json_encode($delChanges);
			echo $someJSON;   
		}

	}

 

	function request()
    {
        $postdata = file_get_contents("php://input");
		$request = json_decode($postdata); 

		return $request;
    }
	
	
}
