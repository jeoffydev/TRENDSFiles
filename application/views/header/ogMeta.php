
<meta property ="og:image:width" content="1200"/>
<meta property="og:image:height" content="630"/>
<meta property="og:url"                content="<?=current_url()?>" />
<meta property="og:type"               content="article" />
<meta property="og:title"              content="<?=$pageTitle?>" />
<meta property="og:description"        content="Australasia's largest range of promotional products and corporate gifts." />

<?php   
    /* OG META *********/

    $rand = rand(10,1000);
    
    $mainOG = base_url()."Images/TRENDS-1200x630.jpg";
    if(count($customArray['themeArray'])>0):  
        
        $logoLocation = '/OGImages/'.$customArray['themeArray'][0]->themeID.'.jpg'; 
        $logoLocation2 = '/OGImages/'.$customArray['themeArray'][0]->themeID.'.png'; 
        if(file_exists($_SERVER['DOCUMENT_ROOT'].$logoLocation)){
            $skinnedOG = base_url()."OGImages/".$customArray['themeArray'][0]->themeID.".jpg";
        }elseif(file_exists($_SERVER['DOCUMENT_ROOT'].$logoLocation2)){ 
            $skinnedOG = base_url()."OGImages/".$customArray['themeArray'][0]->themeID.".png";
        }
        /*else{
            $skinnedOG = $mainOG;
        } */
    ?> 
        <meta property="og:image" content="https:<?=$skinnedOG?>?v=<?=$rand?>"/>  
<?php else: ?>   
        <meta property="og:image" content="https:<?=$mainOG?>?v=<?=$rand?>"/>  
<?php endif; ?>
 