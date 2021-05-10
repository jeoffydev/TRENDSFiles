<?php 
 
class Angular{

    public function getAngular() {
        $url = "//".$_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        //var_dump(parse_url($url));
        $parseUrl = explode("/", $url);
        //print_r($parseUrl); 
        return $parseUrl[4];
    }
    public function callAngular($angular) {  
        return 'views/angular/' . $angular . '_angular.php';  
    }

    public function callPostAngular($angular) { 
        return 'angu-post/' . $angular . '_angular.php';  
        //return '/TGP-Admin/' . $angular;  
    }

    public function getPostRequestAngular($angular) { 
        return 'angu-post/' . $angular . '_angular.php';   
    }

    public function getAngularController($angular) { 
        return  $angular . '_controller.php';  
    }

    public function getAngularModel($angular) { 
        return  $angular . '_model.php';  
    }


}


?>