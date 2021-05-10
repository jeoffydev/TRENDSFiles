 
<?php  
    if($this->general_model->mobileDetector() == 0){  
        $mobile = 0;
        $limitDisplay = 11;
    }else{
        $mobile = 1;
        $limitDisplay = 3;
    } 
?>
<ui-select ng-model="ctrl.productItem.selected" theme="bootstrap" ng-click="checkSearch($select.search)"    ng-change="hitEnter(ctrl.productItem.selected.Code, ctrl.productItem.selected.Optin, '<?=strtoupper($customArray['customID'])?>' )"  >
                    
                    <ui-select-match placeholder="Search products, categories and keywords"   > <span ng-if="ctrl.productItem.selected.Code != 0"> {{$select.selected.Name}} </span>  <span ng-if="ctrl.productItem.selected.Code == 0"> ... </span></ui-select-match> 
                        
                   
                        <ui-select-choices repeat="item in ctrl.allproductSearch | filter: $select.search | limitTo:<?=$limitDisplay?>"      >  
                            
                            <a href="/category/products<?=strtoupper($customArray['customID'])?>?{{$select.search}}"  ng-if="item.Optin == '0'"    >  
                                <input type="text"  id="myvalsearch" ng-value="$select.search" class=" displaynone"  />
                                <div class="row"> 
                                    <div class="col-md-2">  <span class="arrowsearch"  ><i class="fa  fa-angle-right"></i></span>    </div>
                                    <div class="col-md-10">   
                                            <div ng-bind-html="item.Name | highlight: $select.search" class=" displaynone" ng-cloak ></div> 
                                            <div class="moreresults" > View All Results </div> 
                                    </div>
                                </div>
                            </a> 

                            
                            <a href="/item/{{item.Code}}<?=strtoupper($customArray['customID'])?>"  ng-if="item.Optin == '1'"   > 
                                <div class="row"> 
                                    <div class="col-md-2"> <span class="fullline" ng-bind-html="item.img | trust"></span>    </div>
                                    <div class="col-md-10">   
                                            <div ng-bind-html="item.Name | highlight: $select.search" ></div> 
                                    </div>
                                </div>
                            </a> 

                            <!--<a href="/searchColours/{{item.Code}} "  ng-if="item.Optin == '3'"   > 
                                <div class="row"> 
                                    <div class="col-md-2">  <span class="badge colourbox" style="background: {{item.colourCode}}">&nbsp;</span>   </div>
                                    <div class="col-md-8">   
                                            <div ng-bind-html="item.Name | highlight: $select.search" ></div> 
                                    </div>
                                </div>
                            </a> -->

                            <a href="/category/{{item.Code}}<?=strtoupper($customArray['customID'])?>"  ng-if="item.Optin == '2'"   > 
                                <div class="row"> 
                                    <div class="col-md-2">  <span class="arrowsearch"  ><i class="fa  fa-angle-right"></i></span> </div>
                                    <div class="col-md-10">   
                                            <div ng-bind-html="item.Name | highlight: $select.search" ></div>
                                            <!--<small ng-bind-html="item.Code | highlight: $select.search"></small> -->
                                    </div>
                                </div>
                            </a>  

                            

                           

                        </ui-select-choices>
                      
                        
</ui-select>