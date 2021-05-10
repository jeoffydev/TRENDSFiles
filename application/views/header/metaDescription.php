 <?php   
/* Header meta description */

 
switch ($angularFile){
    case 'home':  
        $content = "Australasia's largest range of promotional products and corporate gifts.";
        break;  
    case 'category':  
        $content = "Collection of ".$pageTitleExtension." for all your promotional and corporate gifting requirements.";
        break;  
    case 'item':  
        $cutDescription = "";
        if($getItemDetails['productDetails'][0]->Prim && $getItemDetails['productDetails'][0]->Code){
            $prim = $getItemDetails['productDetails'][0]->Prim;
            $code = $getItemDetails['productDetails'][0]->Code;
            $descriptionFull = $this->productsdisplay_model->getItemDescription($prim, $code, 'Description'); 
            $cutDescription = substr($descriptionFull[0]->Description, 0, 160);
        }
        $content = $cutDescription;
        break; 
    case 'about':  
        $content = "TRENDS has the largest range of promotional products and business gifts. With 30 years of experience and over 500 ex stock products to choose from; we are the clear market leader in our industry.";
        
        if($customArray['themeArray'] > 0 ): 
            if($AboutUsText = $customArray['themeArray'][0]->AboutUsText){
                $decodeAbout = strip_tags($this->general_model->cleanAbout(htmlspecialchars_decode($AboutUsText)));
                $contentDecoded = html_entity_decode(mb_convert_encoding($decodeAbout, 'ISO-8859-15','utf-8'));   
                $content = substr($contentDecoded, 0, 160);
            }  	
        endif; 
        break; 
    case 'contact':  
        $content = "Contact TRENDS for your promotional products and corporate gifts.";
        if($customArray['themeArray'] > 0 ):  
            if($CompanyTag = $customArray['themeArray'][0]->CompanyTag){
                $content = "Contact ".$CompanyTag." for your promotional products and corporate gifts.";
            }  	
        endif;  
        break;  

    default:
        $content = "A comprehensive range of promotional products, merchandise items and corporate gifts available in Australia, New Zealand and the Pacific Islands.";
        break;
}

?>
 

    <meta name="description" content="<?=$content?>">
    <meta name="author" content="">