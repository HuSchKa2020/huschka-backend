<?php

require_once'../include/DbOperations.php';

$response = array();
session_start();
if($_SERVER['REQUEST_METHOD']=='POST'){

  if(isset($_POST['Adresse']) and
      isset($_POST['id'])){

      $db = new DbOperations();


        $response = $db->UpdateAdress($_POST['Adresse'], $_POST['id']);


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