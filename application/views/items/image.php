	<?php 
		$imageCount = $productItem[0]->ImageCount; 
		if($imageCount != "" || $imageCount != null ){ 
	?>
			<!--<span class="zoom-Icon" ><i class="fa  fa-search-plus"></i> </span>-->
			<div id="carouselItemControls"  class="carousel  slide  " data-ride="carousel" data-interval="false" ng-cloak>
				
				<div class="carousel-inner">
					<?php  
						$imageCount = $productItem[0]->ImageCount;
						
						for($i=0; $i <= $imageCount; $i++){ 
							if($i == 0){
								$active = ' active ';
							}else{
								$active = "";
							}

							$caption = $this->item_model->getCaption($itemcode, $i);

							$fileName = $itemcode."-".$i.".jpg";
							 
							$checkImageLocation = '/resizer/470/'.$fileName;  
							
 
                            if(file_exists($_SERVER['DOCUMENT_ROOT'].$checkImageLocation)){ 
								$imageLocation = 'resizer/470/'.$fileName; 
								 
							}else{
								 
								$resizeDone = $this->resizer_model->index($fileName, 470);
							}

							$imageLocation = 'resizer/470/'.$fileName;
							/*else{
								$imageLocation = 'Images/ProductImg/'.$fileName; 
							}*/
							

					?>
						<div class="carousel-item item-imgs <?=$active?> activateThis-<?=$i?>" >
							<img class="d-block w-100 cursorpoint"  ng-click="imgZoom('<?=$itemcode?>', <?=$i?>)" src="<?=base_url().$imageLocation?>" alt="<?=$itemcode?>" title="Click to zoom image">
							<?php if($caption): ?>	
								<p class="margin-top-light text-center" id="captionImgBox" ng-cloak><span class="captionTransfer"><?=$caption?> </span> 
							<?php else: ?>	
								<p class="margin-top-light text-center" id="captionImgBox" ng-cloak> &nbsp; </p>
							<?php endif; ?>	
						</div> 

							
						
					<?php 
						}
					?>	
				</div>
				<?php if($imageCount > 0): ?>
					<a class="carousel-control-prev item-control" href="#carouselItemControls" role="button" data-slide="prev" ng-click="getLoopImg('prev', '<?=$imageCount?>')">
							<span class="item-arrow-carousel"  ><i class="fa  fa-arrow-left"></i></span> 
					</a>
					<a class="carousel-control-next item-control" href="#carouselItemControls" role="button" data-slide="next" ng-click="getLoopImg('next', '<?=$imageCount?>')"> 
							<span class="item-arrow-carousel"  ><i class="fa  fa-arrow-right"></i></span> 
							<span class="sr-only">Next</span>
					</a>
				<?php endif; ?>	
			</div>

	<?php 
		}else{ 
			echo '<span><img class="d-block w-100" src="/Images/no-image.jpg" alt="No image uploaded">';
		}
	?>
	<!--<p class="margin-top-light text-center" id="captionImgBox" ng-cloak> <span ng-if="imageCaption" class="img-caption" > {{imageCaption}} </span> <span ng-if="!imageCaption" class="img-caption"> &nbsp;</span> </p>-->

				<ul class="horizontal-list-img">
					<?php  for($i=0; $i <= $imageCount; $i++){  ?>
						<?php 
							$caption = $this->item_model->getCaption($itemcode, $i);
							if($caption){
								$captionLink = $caption;
							}else{
								$captionLink = null;
							}
						?> 
						<li ng-click="selectCaption('<?=$captionLink;?>')" ><span ng-click="zoomImage('<?=$i?>', '<?=$imageCount?>')" class="cursorpoint"><img class="img-thumbnail rounded" src="<?=base_url();?>Images/ProductImgSML/<?=$itemcode?>-<?=$i?>.jpg?<?=$this->general_model->random();?>" alt="<?=$itemcode?>"></span> 
							<?php if($captionLink): ?>	
								<span class="small-caption" data-toggle="tooltip" data-placement="bottom"  title="<?=$captionLink?>" ng-click="zoomImage('<?=$i?>', '<?=$imageCount?>')" ><?=$this->general_model->captionTitle($captionLink)?> </span>
							<?php else: ?>	
								<span class="small-caption"  > &nbsp; </span>
							<?php endif; ?>	
						</li>  
					<?php  } ?>	
				</ul>
