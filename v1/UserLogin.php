<?php

require_once'../include/DbOperations.php';

$response = array();
session_start();
if($_SERVER['REQUEST_METHOD']=='POST'){
    
  if(isset($_POST['Email']) and 
            isset($_POST['Password'])){
      
      $db = new DbOperations();
      
      if($db->userLogin($_POST['Email'], $_POST['Password'])){
        $user = $db->getUserbyUsername($_POST['Email']);
        $response['error'] = false;
        $response['UserID'] = $user['id'];
        $response['Email'] = $user['email'];
        $response['Nachname'] = $user['Nachname'];
        $response['Vorname'] = $user['Vorname'];
        
      }else{
          
        $response['error'] = true;
        
        $response['message'] = "invalid email or password";

    
      }
      
  } else{
      
    $response['error'] = true;
    
    $response['message'] = "Required fields are missing";
    
    } 
}else{
    
  $response['error'] = true;
  
  $response['message'] = "Invalid Request";
}

echo json_encode($response);
 ?>
