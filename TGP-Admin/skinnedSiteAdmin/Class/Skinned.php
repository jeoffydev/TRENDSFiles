<?php 
/*
#This is the Skinned class
*/
class Skinned{

    //Declare properties
    private $skinnedTable = 'skinnedUserData';   

    public function insertSkinnedUserData($conn, $data){  
        
        $stmt = $conn->prepare('SELECT * FROM '.$this->skinnedTable.'  WHERE  customsiteID=? AND skinnedCustomerNumber=? AND skinnedUserEmail=? ');
        $stmt->bindParam(1, $data['customsiteID'], PDO::PARAM_INT); 
        $stmt->bindParam(2, $data['skinnedCustomerNumber'], PDO::PARAM_INT); 
        $stmt->bindParam(3, $data['skinnedUserEmail'], PDO::PARAM_INT); 
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC); 
        if($row > 0)
        {
            $insert = 0;
           
        }else{
            $skinnedUserSalt = md5($data['customsiteID'].'-'.$data['skinnedUserEmail']);
            $sql = $conn->prepare("INSERT INTO ".$this->skinnedTable." (customsiteID, skinnedCustomerNumber, skinnedUserEmail, skinnedUserName, skinnedUserCompany, skinnedUserPassword, skinnedPwReset, skinnedHash, skinnedUserSalt) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)"); 
            $insert = $sql->execute(array($data['customsiteID'], $data['skinnedCustomerNumber'], $data['skinnedUserEmail'], $data['skinnedUserName'], $data['skinnedUserCompany'], null, null, null, $skinnedUserSalt));  
             
        } 
        return $insert;    
    }

       
    public function listSkinnedUser($conn, $data){  
        $query = $conn->prepare('SELECT * FROM '.$this->skinnedTable.' WHERE customsiteID=? AND skinnedCustomerNumber=? ORDER BY skinnedUserID DESC');
        //using bindParam helps prevent SQL Injection
        $query->bindParam(1, $data['customsiteID'], PDO::PARAM_INT);
        $query->bindParam(2, $data['skinnedCustomerNumber'], PDO::PARAM_INT);
        $query->execute();
        //$results is now an associative array with the result
        $result = $query->fetchAll(PDO::FETCH_ASSOC); 
        return $result;
    }  
    
    public function selectSkinnedUser($conn, $id){
        $query = $conn->prepare('SELECT * FROM '.$this->skinnedTable.'  WHERE skinnedUserID = '.$id.' '); 
        $query->execute(); 
        $result = $query->fetchAll(PDO::FETCH_ASSOC);   
        return $result;  
    }

    //Remove User
    public function deleteSkinnedUser($conn, $id)
    {    
        $command = " DELETE FROM ".$this->skinnedTable."  WHERE skinnedUserID=:id";
        $stmt = $conn ->prepare($command);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $done = $stmt->execute();
        return $done;
    }

    //update user
    public function skinnedUserUpdate($conn, $data){
        $sql = "UPDATE ".$this->skinnedTable." SET  skinnedUserName ='".$data['skinnedUserName']."', skinnedUserCompany = '".$data['skinnedUserCompany']."'  WHERE skinnedUserID='".$data['skinID']."'";
        $update = $conn->query($sql);
        if($update){
            $response = 'success';  
       }else{
            $response = 'error';  
       } 
    }


    public function resetView($conn, $data){
        $query = $conn->prepare('SELECT * FROM '.$this->skinnedTable.'  WHERE skinnedUserID = '.$data['id'].' '); 
        $query->execute(); 
        $results = $query->fetchAll(PDO::FETCH_ASSOC);   
        if($results)
        {
            foreach($results as $row ){
                if($row['skinnedPwReset']==null){
                    $returnOut = 0;
                }else{
                    $returnOut = 1;
                }
            }
        } 
        return $returnOut;  
    }

    //Update PWreset column
    public function updateResetPw($conn, $data){ 
       $uniqueID = uniqid(); 
       $resetpwCode = md5($data['skinEmail'].''.$data['id']).'.' .$uniqueID; 
        
       $sql = "UPDATE ".$this->skinnedTable."   SET  skinnedPwReset ='".$resetpwCode."', skinnedHash = '".$uniqueID."'  WHERE skinnedUserID ='".$data['id']."'";
        $update = $conn->query($sql);
        if($update){
            $response =  1;  
       }else{
            $response = 0;  
       }  
       return $response;
    }

    public function getResetPW($conn, $data){
        $query = $conn->prepare('SELECT * FROM '.$this->skinnedTable.' LEFt JOIN customSite  ON skinnedUserData.customsiteID =  customSite.themeID WHERE  skinnedUserData.skinnedUserID =  '.$data['id'].' '); 
        $query->execute(); 
        $results = $query->fetchAll(PDO::FETCH_ASSOC);    
        return $results;  
    }


    public function removeResetPw($conn, $data){   
        $resetpwCode = null;
        $sql = "UPDATE ".$this->skinnedTable."   SET  skinnedPwReset ='".$resetpwCode."'  WHERE skinnedUserID ='".$data['id']."'";
        $update = $conn->query($sql);
        if($update){
            $response =  1;  
       }else{
            $response = 0;  
       }  
       return $response;
    }


    //Update Password
    public function updatePassword($conn, $data){  
        $newPassword = md5($data['pw']); 
         
        $sql = "UPDATE ".$this->skinnedTable."   SET skinnedUserPassword ='".$newPassword."',  skinnedPwReset=null , skinnedHash=null  WHERE skinnedUserID ='".$data['id']."'";
         $update = $conn->query($sql);
         if($update){
             $response =  1;  
        }else{
             $response = 0;  
        }  
        return $response;
     }

     //Login user
     public function loginSkinUser($conn, $data){ 
        
        $hashPassword = md5($data['pw']); 
       // echo $hashPassword. ' ' .$data['emailad'];
        $query = $conn->prepare('SELECT * FROM '.$this->skinnedTable.'  WHERE skinnedUserEmail = "'.$data['emailad'].'" AND  skinnedUserPassword ="'.$hashPassword.'" '); 
        $query->execute(); 
        $results = $query->fetchAll(PDO::FETCH_ASSOC);   
        if($results)
        {
           
            $returnOut = '1';  
        }else{
            $returnOut = '0';  
        } 
        return $returnOut;  

     }


     //Login user
     public function verifyEmailforget($conn, $data){ 
           
        $query = $conn->prepare('SELECT * FROM '.$this->skinnedTable.'  WHERE skinnedUserEmail = "'.$data['email'].'" AND  customsiteID ="'.$data['themeID'].'" AND skinnedCustomerNumber ="'.$data['customerNumber'].'"  '); 
        $query->execute(); 
        $results = $query->fetchAll(PDO::FETCH_ASSOC);   
        if($results)
        {  
            $returnOut = '1';  
        }else{
            $returnOut = '0';  
        } 
        return $returnOut;  

     }

     //New changes april 06
     public function selectNewSkinnedUser($conn, $data){
        $query = $conn->prepare('SELECT * FROM '.$this->skinnedTable.'  WHERE customsiteID = "'.$data['customsiteID'].'" AND skinnedCustomerNumber = "'.$data['skinnedCustomerNumber'].'" AND skinnedUserEmail = "'.$data['skinnedUserEmail'].'"  '); 
        $query->execute(); 
        $result = $query->fetchAll(PDO::FETCH_ASSOC);   
        return $result;  
    }
  
}

?>