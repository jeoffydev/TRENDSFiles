<?php 
 
class Controller{

    public function getController() {
        $url = "//".$_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        //var_dump(parse_url($url));
        $parseUrl = explode("/", $url);
        //print_r($parseUrl); 
        return $parseUrl[4];
    }
    public function callController($controller) {  
        $link = 'controllers/' . $controller . '_controller.php';
        if (file_exists($link)) {
            require_once($link);  
        }else{
            die( header( 'location: ../' ) ); 
            exit;
        } 
    }

    /* General Access of Controller */
    public function getPage($page) { 
        $model = new  Model();
        $pageNumber = $model->getPageNumber($page);
        return $pageNumber;
    }
    public function getUserPage($userID) { 
        $model = new  Model();
        $userPages = $model->getUserPages($userID);
        return $userPages;
    }

    public function getAllPages() { 
        $model = new  Model();
        $pages = $model->getAllPages();
        return $pages;
    }

}


?>