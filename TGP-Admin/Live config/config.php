<?php
  class Db {
    private static $instance = NULL;

    private static $Db = 'trends_collection';
    private static $user = 'trends_WebWrite';
    private static $pw = 'cwpTtvtC5VkA3kOVyFko';

    private function __construct() {}

    private function __clone() {}

    public static function getInstance() {
        if (!isset(self::$instance)) {
          $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
          self::$instance = new PDO('mysql:host=localhost;dbname='.self::$Db, self::$user, self::$pw, $pdo_options);
        }
        return self::$instance;
    }

    

  }


  class DBConfig {
     
    public function connectToDB() {

      define("DSN", "mysql:host=localhost;dbname=trends_collection" );
      define("USERNAME", "trends_WebWrite");
      define("PASSWORD", "cwpTtvtC5VkA3kOVyFko");
      $options = array(PDO::ATTR_PERSISTENT=>true);
      
      try{
              $conn = new PDO(DSN, USERNAME, PASSWORD, $options);
              $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
              if($conn){
                 return $conn;
              }
      
      }catch(PDOException $ex){
      
          echo "A database error occured - " .$ex->getMessage();
      
      }

  }

  }
?>