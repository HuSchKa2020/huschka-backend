<?php

require_once'../include/DbOperations.php';

$response = array();
session_start();
if($_SERVER['REQUEST_METHOD']=='POST'){
    
  if(isset($_POST['listenid']) ){
      
      $db = new DbOperations();
      
      
        if($db->DeleteShoppinglist($_POST['listenid'])){
            $response['error'] = false;
            $response['message'] = "Shoppinglist delete succesfully";
            } else{
    
                $response['error'] = true;
                $response['message'] = "Shoppinglist couldn´t delete, try Again please!";
    
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