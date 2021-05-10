
 


<?php $brandingTemplate = $this->productsdisplay_model->getBranding($productItem[0]->Code);  if(file_exists($brandingTemplate)): ?>
<span class="icon-box branding-side"  data-toggle="tooltip" data-placement="right"  title="Branding Template" style="margin-bottom:0px; max-width:70px; margin:auto">
    <a href="<?=base_url();?>PDFWires/<?=$productItem[0]->Code;?>.pdf?<?=$this->general_model->random()?>" target="_blank" class="span-a">
        <i class="fa fa-file-pdf-o"></i> 
    </a> 
</span> 
<small style="font-size:9px; display: block; margin-bottom:6px;  text-align:center ">Branding Template</small>
<?php endif; ?>

<span class="icon-box zoom-side" ng-click="imgZoom('<?=$itemcode?>')" data-toggle="tooltip" data-placement="right"   title="High Resolution Image" style="margin-bottom:0px; max-width:70px; margin:auto">
    <i class="fa  fa-search-plus"></i> 
</span>
<small style="font-size:9px; display: block; margin-bottom:6px; letter-spacing: 0px;  text-align:center ">Hi-Res Image</small>

<?php if($getItemDetails['productDetails'][0]->IsMixMatch == 1): ?>
    <span class="icon-box mixmatch-side"   data-toggle="modal" data-target="#mixMatchModal" ng-click="getMixMatch('<?=$productItem[0]->Code?>')" style="margin-bottom:0px; max-width:70px; margin:auto" >
        <span   data-toggle="tooltip" data-placement="right"   title="Mix & Match "  >
            <i class="fa fa-paint-brush"></i>
        </span>
    </span>
    <small style="font-size:9px; display: block; margin-bottom:6px; letter-spacing: 0px;  text-align:center ">Mix & Match</small>
<?php endif; ?>

<?php if($siteLogcheck['loggedIn'] == 1  && count($customArray['themeArray'])==0): ?> 
    <span class="icon-box visual-side" style="margin-bottom:0px; max-width:70px; margin:auto"  data-toggle="modal" data-target="#visualRequestsModal" ng-click="itemRequestVisuals('<?=$siteLogcheck['userDatas'][0]->userID?>', '<?=$productItem[0]->Code?>')"  > 
        <span data-toggle="tooltip" data-placement="right"   title="Request Visuals"><i class="fa  fa-tv"></i></span>
    </span> 
    <small style="font-size:9px; display: block; margin-bottom:6px;    text-align:center ">Request Visuals</small>
<?php endif; ?> 

<?php  if($productItem[0]->video):  ?> 
    <span class="icon-box visual-side" data-toggle="modal" data-target="#videoPopup" style="margin-bottom:0px; max-width:70px; margin:auto"   > 
        <span data-toggle="tooltip" data-placement="right"   title="Video"> <i class="fa  fa-play-circle"></i></span>
    </span> 
    <small style="font-size:9px; display: block; margin-bottom:6px; letter-spacing: 0px;  text-align:center ">Video</small>
<?php endif; ?> 

<?php if($siteLogcheck['loggedIn'] == 1 && count($customArray['themeArray'])==0): ?>
    <span ng-init="checkFavourite('<?=$siteLogcheck['userDatas'][0]->userID?>', '<?=$productItem[0]->Code?>')"></span>
    
        <span ng-click="addFavourite('<?=$siteLogcheck['userDatas'][0]->userID?>', '<?=$productItem[0]->Code?>')" ng-show="favPlus == 1" class="icon-box fav-side"  style="margin-bottom:0px; max-width:70px; margin:auto"   > 
            <span  data-toggle="tooltip" data-placement="right"   title="Add to Favourites"  ><i class="fa  fa-star"></i><i class="fa  fa-check-circle smallfavicon"></i> </span> 
        </span>
        <small ng-show="favPlus == 1" style="font-size:9px; display: block; margin-bottom:6px;   text-align:center ">Add to Favourites</small>
    
    <span  data-toggle="tooltip" data-placement="right"   title="Remove from Favourites"   >
        <span ng-show="favMinus == 1" class="icon-box fav-side"  ng-click="removeFavourite('<?=$siteLogcheck['userDatas'][0]->userID?>', '<?=$productItem[0]->Code?>')"  style="margin-bottom:0px; max-width:70px; margin:auto" > 
            <i class="fa  fa-star"></i><i class="fa   fa-times-circle smallfavicon"></i> 
        </span> 
    </span>    
    <small ng-show="favMinus == 1"  style="font-size:9px; display: block; margin-bottom:6px;   text-align:center ">Remove from Favourites</small>
<?php endif; ?> 




<?php if($siteLogcheck['loggedIn'] == 0 && count($customArray['themeArray']) > 0 && $customArray['themeArray'][0]->EnquiryFormActive > 0): ?> 
    <span class="icon-box mail-side" style="margin-bottom:0px; max-width:70px; margin:auto"  data-toggle="modal" data-target="#enquiryForm" ng-click="enquiryForm('<?=$productItem[0]->Code?>', '<?=$this->general_model->cleanString($productItem[0]->Name)?>')">
        <span data-toggle="tooltip" data-placement="right"     title="Enquire Now"><i class="fa fa-envelope"></i></span>
    </span>    
    <small style="font-size:9px; display: block; margin-bottom:6px; letter-spacing: 0px;  text-align:center ">Enquire Now</small>
<?php endif; ?> 
