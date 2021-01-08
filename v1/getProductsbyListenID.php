<?php

require_once'../include/DbOperations.php';

$response = array();
session_start();
if($_SERVER['REQUEST_METHOD']=='POST'){
    
  if(isset($_POST['ListenID']) ){
      
      $db = new DbOperations();
      
      $responseProducts = $db->getProductsbyListenID($_POST['ListenID']);
      $responseScores = $db->getScores($_POST['ListenID']);

      $response["Produkte"] = $responseProducts;
      $response["Scores"] = $responseScores;

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