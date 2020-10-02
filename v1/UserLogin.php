<?php

require_once'../include/DbOperations.php';

$response = array();
session_start();
if($_SERVER['REQUEST_METHOD']=='POST'){
    
  if(isset($_POST['email']) and 
            isset($_POST['password'])){
      
      $db = new DbOperations();
      
      if($db->userLogin($_POST['email'], $_POST['password'])){
        $user = $db->getUserbyUsername($_POST['email']);
        $response['error'] = false;
        $response['id'] = $user['id'];
        $response['email'] = $user['email'];
        $response['nachname'] = $user['Nachname'];
        $response['vorname'] = $user['Vorname'];
        
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
