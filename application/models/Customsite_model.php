<?php
 
class Customsite_Model extends CI_Model {

	 
	function getCustomerData(){
		$query = $this->db->query("SELECT CustomerNumber, CustomerName, CustomerOnHold, CSR FROM  customerData  ORDER BY customerName ");

		foreach($query->result() as $post) {
            $list[] =  $post;
        } 
        return $list; 
	}

	function getCustomersTheme($CustomerNumber, $CustomerName, $themeMax){
		$query = $this->db->query("SELECT * FROM  customSite WHERE customerNumber=".$CustomerNumber." ORDER BY CompanyTag");
		$results = $query->result();
		$results['ThemedSiteMax'] = $themeMax;
		 
		return  $results;
		 
	}
	function getMainCustomer($CustomerNumber){
		$query = $this->db->query("SELECT * FROM  customSite WHERE customerNumber=".$CustomerNumber." ORDER BY CompanyTag");
		$results = $query->result();  
	    return   $results;
	}
	 
	function getThemeData($selectedThemeID){
		$query = $this->db->query("SELECT * FROM  customSite WHERE themeID=".$selectedThemeID." "); 
		$results  = $query->result();  
        return $results; 
	}

	function insertNewTheme($newTheme, $customerNum){ 
		$data = array(
			'CompanyTag' => $newTheme,
			'CustomerNumber' => $customerNum, 
			'Live'=>0
		); 
		$this->db->insert('customSite', $data);
		$insertId = $this->db->insert_id();  
        return $insertId; 
	}

	function deleteTheme($selectedThemeID, $customerNumber){

		$data = array(
			'themeID' => $selectedThemeID,
			'CustomerNumber' =>  $customerNumber
		);
		$deleted = $this->db->delete('customSite', $data); 
		return $deleted; 
	}

	function updateTheme($request){
			$themeID = $request->themeID; 
			$CompanyTag = $this->RemoveSpecialChar($request->CompanyTag); 
			$Live = $request->Live;  
			$BackgroundColour = $request->BackgroundColour;
			$Phone = $request->Phone;
			$Email = $request->Email;
			$Address = $request->Address;
			$Twitter = $request->Twitter;
			$Facebook = $request->Facebook;
			$LinkedIn = $request->LinkedIn;
			$Skype = $request->Skype;
			$GooglePlus = $request->GooglePlus;
			$Website = $request->Website;
			$headerBackground = $request->headerBackground;
			$headerTrimColour = $request->headerTrimColour;
			$headerTextColour = $request->headerTextColour;
			$searchBoxColour = $request->searchBoxColour;
			$searchBoxTextColour = $request->searchBoxTextColour;
			$CategoryIconOverlay = $request->CategoryIconOverlay;
			$categoryTextColour = $request->categoryTextColour;
			$paragraphTextColour = $request->paragraphTextColour;
			$tabColour = $request->tabColour;
			$tabTextColour = $request->tabTextColour;
			$tabTextColourHover = $request->tabTextColourHover;
			$tabSelectedColour = $request->tabSelectedColour;
			$tabSelectedText = $request->tabSelectedText;
			$tableBorderColour = $request->tableBorderColour;
			$tableHeaderColour = $request->tableHeaderColour;
			$tableHeaderTextColour = $request->tableHeaderTextColour;
			$tableCellColour = $request->tableCellColour;
			$tableCellTextColour = $request->tableCellTextColour;
			$menuHighlightColour = $request->menuHighlightColour;
			$textHighlightColour = $request->textHighlightColour;
			$ContactUsText = htmlspecialchars($request->ContactUsTextEditor, ENT_QUOTES);
			$AboutUsText =    htmlspecialchars($request->AboutUsTextEditor, ENT_QUOTES);
			
			$AdditionalInformation = $request->AdditionalInformation;
			$Q1Markup = $request->Q1Markup;
			$Q2Markup = $request->Q2Markup;
			$Q3Markup = $request->Q3Markup;
			$Q4Markup = $request->Q4Markup;
			$Q5Markup = $request->Q5Markup;
			//$Q6Markup = $request->Q6Markup; PENDING COLUMN 
			$SetupMarkup = $request->SetupMarkup;
			$BrandingPriceMarkup = $request->BrandingPriceMarkup;
			$showPricing = $request->showPricing;
			$allowMOQ = $request->allowMOQ;
			//$MOQSurcharge = $request->MOQSurcharge;
			$PricingInformation1 = $request->PricingInformation1;
			$PricingInformation2 = $request->PricingInformation2;
			$PricingInformation3 = $request->PricingInformation3;
			$PricingInformation4 = $request->PricingInformation4;
			$termsConditionText = htmlspecialchars($request->termsConditionTextEditor, ENT_QUOTES);
			$customsiteAdminEmail = $request->customsiteAdminEmail;
			$googleAnalyticsID = $request->googleAnalyticsID;
			$includeUnitPrice = $request->includeUnitPrice;
			$Instagram = $request->Instagram;
			$PricingInformation5 = $request->PricingInformation5;
			$PricingInformation6 = $request->PricingInformation6;
			$PricingInformation7 = $request->PricingInformation7;
			$PricingInformation8 = $request->PricingInformation8;
			$PricingInformation9 = $request->PricingInformation9;
			$PricingInformation10 = $request->PricingInformation10;

			if($allowMOQ == 1){
					$MOQSurcharge = $request->MOQSurcharge;
			}else{
					$MOQSurcharge = null;
			} 
			
			$data = array(
				'CompanyTag' => $CompanyTag, 
				'Live' =>  $Live, 
				'BackgroundColour' => $BackgroundColour, 
				'Phone' => $Phone, 
				'Email' => $Email, 
				'Address' => $Address, 
				'Twitter' => $Twitter, 
				'Facebook' => $Facebook, 
				'LinkedIn' => $LinkedIn, 
				'Skype' => $Skype, 
				'GooglePlus' => $GooglePlus, 
				'Instagram' => $Instagram, 
				'Website' => $Website,
				'headerBackground' =>$headerBackground, 
				'headerTrimColour' =>$headerTrimColour, 
				'headerTextColour' =>$headerTextColour, 
				'searchBoxColour' =>$searchBoxColour, 
				'searchBoxTextColour' =>$searchBoxTextColour, 
				'CategoryIconOverlay' =>$CategoryIconOverlay, 
				'categoryTextColour' =>$categoryTextColour, 
				'paragraphTextColour' =>$paragraphTextColour, 
				'tabColour' =>$tabColour, 
				'tabTextColour' =>$tabTextColour, 
				'tabTextColourHover' =>$tabTextColourHover, 
				'tabSelectedColour' =>$tabSelectedColour, 
				'tabSelectedText' =>$tabSelectedText, 
				'tableBorderColour' =>$tableBorderColour, 
				'tableHeaderColour' =>$tableHeaderColour, 
				'tableHeaderTextColour' =>$tableHeaderTextColour, 
				'tableCellColour' =>$tableCellColour, 
				'tableCellTextColour' =>$tableCellTextColour, 
				'menuHighlightColour' =>$menuHighlightColour, 
				'textHighlightColour' =>$textHighlightColour, 
				'ContactUsText' =>$ContactUsText, 
				'AboutUsText' =>$AboutUsText, 
				'AdditionalInformation' =>$AdditionalInformation, 
				'termsConditionText' =>$termsConditionText,
				'Q1Markup' =>$Q1Markup, 
				'Q2Markup' =>$Q2Markup, 
				'Q3Markup' =>$Q3Markup, 
				'Q4Markup' =>$Q4Markup, 
				'Q5Markup' =>$Q5Markup, 
				'SetupMarkup' =>$SetupMarkup, 
				'BrandingPriceMarkup' =>$BrandingPriceMarkup, 
				'showPricing' =>$showPricing, 
				'allowMOQ' =>$allowMOQ, 
				'MOQSurcharge' =>$MOQSurcharge, 
				'PricingInformation1' =>$PricingInformation1, 
				'PricingInformation2' =>$PricingInformation2, 
				'PricingInformation3' =>$PricingInformation3, 
				'PricingInformation4' =>$PricingInformation4, 
				'PricingInformation5' =>$PricingInformation5, 
				'PricingInformation6' =>$PricingInformation6, 
				'PricingInformation7' =>$PricingInformation7, 
				'PricingInformation8' =>$PricingInformation8, 
				'PricingInformation9' =>$PricingInformation9, 
				'PricingInformation10' =>$PricingInformation10,  
				'customsiteAdminEmail' =>$customsiteAdminEmail, 
				'googleAnalyticsID' =>$googleAnalyticsID, 
				'includeUnitPrice' =>$includeUnitPrice  
		);
		
		$this->db->where('themeID', $themeID);
		$results = $this->db->update('customSite', $data);

		return $results;
	}

	 
	function RemoveSpecialChar($value){
		$title = str_replace( array( '\'', '"', ',' , ';', '<', '>' ), ' ', $value); 
		return $title;
	}
 

}
