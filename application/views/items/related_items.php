<?php if($getRelatedItem['relatedItems']): ?>
    <div class="related-items related-box  " id="relateditems"     >
        <?php  foreach($getRelatedItem['relatedItems'] as $related){   
                    //Hide the item current item code page
                    if($itemcode != $related->Code ):    

                        $relatedItemNameShort = $this->general_model->shortTitle($related->Name);

        ?>
            <div style="float:left">
                <a href="<?=base_url()?>item/<?=$related->Code?><?=strtoupper($customArray['customID'])?>" class="thumbnail">
                            <span class="img-related">
                                <img class="related-img" src="<?=base_url()?>Images/ProductImgSML/<?=$related->Code?>.jpg?<?=$this->general_model->random()?>" alt="<?=$related->Code?>"  class="img-thumbnail"   >
                                <h5><small><?=$related->Code?></small><br /><?=$this->general_model->cleanString($relatedItemNameShort)?></h5>
                            </span> 
                </a>
            </div>
            
        <?php       endif; 
                } ?>
    </div>
<?php endif; ?>