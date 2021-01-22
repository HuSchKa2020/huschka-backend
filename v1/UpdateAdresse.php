<?php

require_once'../include/DbOperations.php';

$response = array();
session_start();
if($_SERVER['REQUEST_METHOD']=='POST'){

  if(isset($_POST['Adresse']) and
      isset($_POST['KundenID'])){

      $db = new DbOperations();


      if($db->UpdateAdress($_POST['Adresse'], $_POST['KundenID'])) {
          $response['error'] = false;

          $response['message'] = "Ihre Nutzerdaten wurden erfolgreich aktualisiert!"; 
        
      } else {
          $response['error'] = true;

          $response['message'] = "Fehler beim aktualisieren ihrer Nutzerdaten. Bitte kontaktieren Sie den Support.  ";
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