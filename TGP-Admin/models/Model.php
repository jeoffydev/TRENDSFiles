<?php 
 
class Model{

    public function getModel() {
        $url = "//".$_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        //var_dump(parse_url($url));
        $parseUrl = explode("/", $url);
        //print_r($parseUrl); 
        return $parseUrl[4];
    }
    public function callModel($model) {  
        $link = 'models/' . $model . '_model.php';
        if (file_exists($link)) {
            require_once($link);  
        }else{
            die( header( 'location: ../' ) ); 
            exit;
        } 
        
    }

     /* General Access of Model */
    public function getPageNumber($page) {
        $conn = Db::getInstance();
        $req = $conn->query("SELECT * FROM cmsAccess WHERE accessPage = '".$page."' AND mainPage = '0' "); 
        $req->execute();
        $results = $req->fetch();
        //print_r($results);
        return $results['pageNumber'];
    }

    public function getUserPages($userID) {
        $conn = Db::getInstance();
        $req = $conn->query("SELECT * FROM userData WHERE userID  = '".$userID."' AND userAcct = '10105'   "); 
        $req->execute();
        $results = $req->fetch(); 
        return $results['userAccess'];
    }

    public function getAllPages() {
        $conn = Db::getInstance();
        $req = $conn->query("SELECT accessid, accessPage, orderPages, pageNumber FROM cmsAccess WHERE mainPage = 0 AND orderPages != 0 ORDER BY orderPages ASC "); 
        $req->execute();
        $results = $req->fetchAll();
        //print_r($results);
        return $results;
    }

}


?>