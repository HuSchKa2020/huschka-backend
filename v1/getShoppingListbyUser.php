<?php

require_once'../include/DbOperations.php';

$response = array();
session_start();
if($_SERVER['REQUEST_METHOD']=='POST'){

  if(isset($_POST['KundenID']) ){

      $db = new DbOperations();


        $response = $db->getShoppingListbyUser($_POST['KundenID']);


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
