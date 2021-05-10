

<?php //
    /* at the top of 'check.php' */ 
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) { 
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 ); 
        die( header( 'location: /' ) ); 
    } 
 
?>
<?php include('header.php') ?>

 
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
         
        <li class="breadcrumb-item active">Featured Items</li>
      </ol>

         
      <!-- Icon Cards-->
     
      
<div class="row">
    <div class="col-md-12">
            <div class="body-controller" >     
           
             
            
                <div id="imaginary_container"> 
                    <div class="input-group stylish-input-group col-md-4">
                        <input type="text" class="form-control" id="edit-search"  placeholder="Apply Filter Ex. Fan Flyer or 114084" ng-model="query[queryBy]"  data-toggle="tooltip" data-placement="right" title="Click below to select" >
                        <span class="input-group-addon">
                            <button type="submit">
                             <i class="fa fa-fw fa-search"></i>
                            </button>  
                        </span>
                    </div>
                  
                </div>
           
                    

           
                <div class="main-itemTable" > 
                            <table class="table table-striped table-hover "  >
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Featured Item</th>
                                    <th>Status</th>
                                </tr>
                                <tr ng-repeat="product in products | filter:query" ng-click="selectItem(product.Prim, product.Code, product.Name, product.featuredItem)">
                                    <td><span class="edit-product" data-id="{{product.Prim}}" >{{product.Code}}</span></td>
                                    <td><span class="edit-product" data-id="{{product.Prim}}" >{{product.Name}}</a></td>
                                    <td><span class="edit-product" data-id="{{product.featuredItem}}" >{{product.featuredItem}}</a></td>
                                    <td><span class="edit-product" data-id="{{product.Prim}}" >{{product.Active}}</a></td>
                                </tr>
                            </table>
                    
                </div> 

                 <div class="alert alert-warning" role="alert">
                    Note: Administrators, if having difficulty viewing new updates made on the new website  Ex. content, images and pricing, please click this link  <a target="_blank" href="//trends.nz/refresh/all">www.trends.nz/refresh/all</a> to refresh website cache.
                </div>

                <div class="alert alert-warning text-center" role="alert" ng-show="addedCheck">
                    <i class="fa fa-check"></i> Added new item at the bottom of this page.
                </div>

                <p class="margin-top text-center"><i class="fa fa-exclamation-triangle"></i> Select a featured products above and  drag to re-order the items below</p>  
                <form name="formFeatured" id="formFeatured" ng-submit="updateFeatured()"   >  
                  
                  <div class="row">
                    <div class="col-md-3">&nbsp;</div>
                    <div class="col-md-6">  
                        <ul class="row margin-top main-body-featured"  ui-sortable = "sortableOptions"  ng-model="getFeaturedItems" >
                          
                            <span ng-init="getItems(featuredItems)"></span>
                          
                            <li class="col-md-3 featured-box removeFeatured{{featuredNew.Prim}}" ng-repeat="featuredNew in getFeaturedItems" >
                                <span class="close-feat" ng-click="removeFeaturedItem(featuredNew.Prim)"  ><i class="fa fa-times-circle"></i></span>
                                <div class="featItems "> 
                                    <img src="../../Images/ProductImg/{{featuredNew.Code}}-0.jpg" class="img-thumbnail" />
                                    <input type="hidden" class="  form-control" name="featuredName[]" type="text" ng-value="{{featuredNew.Code}}" ng-model="featuredItems.Code"      >
                                    <span class="codeFeatured">{{featuredNew.Code}}</span>
                                    <span class="titleFeatured"> {{featuredNew.Name}} </span>
                                </div>
                            </li>   
                        </ul>
                    </div>
                    <div class="col-md-3">&nbsp;</div>
                  </div>

                <div class="row">
                  <div class="col-md-3">&nbsp;</div>
                  <div class="col-md-6 text-center">  
                      <button type="submit" name="update" class="btn btn-danger btn-large"  >Update Featured Items</button>
                  </div>
                  <div class="col-md-3">&nbsp;</div>
                </div>

                  
                </form>
                <p>&nbsp; </p>
                  
        
    </div>
  </div>  
</div>    





<?php include('footer.php') ?>