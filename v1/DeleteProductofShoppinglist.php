<?php

require_once'../include/DbOperations.php';

$response = array();
session_start();
if($_SERVER['REQUEST_METHOD']=='POST'){
    
  if(isset($_POST['ListenID']) ){
      
      $db = new DbOperations();
      
      
        if($db->DeleteProduct($_POST['ListenID'])){
            $response['error'] = false;
            $response['message'] = "Contant of Shoppinglist delete succesfully";
            } else{
    
                $response['error'] = true;
                $response['message'] = "Contant of Shoppinglist couldn´t delete, try Again please!";
    
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