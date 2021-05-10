

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
         
        <li class="breadcrumb-item active">Email Banner Uploader </li>
      </ol>

         
      <!-- Icon Cards-->
     
      
<div class="row" ng-cloak>
    <div class="col-md-2">&nbsp;</div> 
    <div class="col-md-8">
        <div class="alert alert-secondary text-center" role="alert">
            <p><label for="mainfileUpload">Upload Files <small>(Upload not more than 6MB)</small></label></p>
            <div ngf-drop="uploadFile($files )" ngf-select="uploadFile($files )"  ng-model="files" class="drop-box"   
                    ngf-drag-over-class="'dragover'" ngf-multiple="false" ngf-allow-dir="true"
                    accept="image/*,application/pdf" 
                    ngf-pattern="'image/*,application/pdf'"  > <span>Click or Drag and Drop Files </span>   </div>
            <div ngf-no-file-drop>File Drag/Drop is not supported for this browser</div>
        </div>

         <div class="row margin-top" >
             <div class="col-md-2 text-right"><i class="fa text-success fa-check" ng-if="success"></i> URL: </div>
             <div class="col-md-7"><input type="text" class="form-control" ng-model="emailBannerUrl" /> <small> If TRENDS.NZ homepage and no redirect, just type in - home<br />
             <span class="text-danger">Ex. /item/100104 and  https://www.youtube.com for external link  </span></small> </div> 
             <div class="col-md-3"> <button type="button" ng-click="submitEmailURL(emailBannerUrl)" class="btn btn-dark  btn-sm">Save</button></div> 
         </div>
            
        <div class="row margin-top" >
            <div class="col-md-3">&nbsp;</div> 
            <div class="col-md-6">
                <ul ng-if="FilesUploaded" class="list-group"> 
                        <li class="list-group-item " ng-repeat="filesRow in FilesUploaded"><a target="_blank" href="/Downloads-folder/email/{{filesRow}}" class="cursorpoint" ><i class="fa  fa-caret-right"></i> {{filesRow}}   <i class="margin-right fa fa-search-plus"></i>   </a>    </li> 
                </ul>  
            </div>       
            <div class="col-md-3">&nbsp;</div>         
        </div>
        <div class="row margin-top margin-bottom" ng-if="FilesUploaded" >
            <div class="col-md-2">&nbsp;</div> 
            <div class="col-md-8"><span ng-repeat="filesRow in FilesUploaded"><a target="_blank" href="/Downloads-folder/email/{{filesRow}}?{{randomNumber}}" class="cursorpoint" ><img src="/Downloads-folder/email/{{filesRow}}?{{randomNumber}}" class="img-fluid img-thumbnail" /></a></span></div>
            <div class="col-md-2">&nbsp;</div> 
        </div>
    </div>       
    <div class="col-md-2">&nbsp;</div>  
</div>    





<?php include('footer.php') ?>