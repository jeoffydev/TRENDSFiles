 
 <?php if($getCompliance): ?>
    <strong>Compliance</strong><br />
  
    <ul class="compliance-list" >
            <?php foreach($getCompliance as $list) {  ?>
            <li><span class="<?php if($list->description){ ?>compliance-toggle cursorpoint<?php } ?> plus-icon"    
                <?php if($list->description){ ?>      title="Click to show the description"  <?php } ?> 
                    data-toggle="collapse" href="#collapseCompliance<?=$list->id?>" role="button" aria-expanded="false" aria-controls="collapseCompliance<?=$list->id?>" >
                    <span class="click-plus click-plus<?php echo $list->id; ?>"><?php if($list->description){ ?><i class="fa fa-plus" aria-hidden="true"></i><?php }else{  ?> <i class="fa fa-circle compliance-dot" aria-hidden="true"></i> <?php } ?></span>  
                        <?=$this->general_model->cleanCompliance($list->standard); ?> 
                    </span>
                    
                    <?php if($list->pdfFilename && count($customArray['themeArray'])==0 && $siteLogcheck['loggedIn'] == 1){ ?>
                        &nbsp; <a href="<?=base_url()?>compliancePDF/<?php echo $list->pdfFilename; ?>"  data-toggle="tooltip" data-placement="top"    title="Download PDF" target="_blank" class="compliance-pdf-link"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a> 
                    <?php } ?>	

                    <?php if($list->description){ ?>
                        <div class="collapse" id="collapseCompliance<?=$list->id?>">
                            <div class="alert alert-secondary">
                                <?=$this->general_model->cleanCompliance($list->description); ?>
                            </div>
                        </div> 
                    <?php } ?>	
                </li>
            <?php } // foreach end ?>
        </ul>

 <?php endif; ?>
 