<?php

require_once'../include/DbOperations.php';

$response = array();
session_start();
if($_SERVER['REQUEST_METHOD']=='POST'){

  if(isset($_POST['Nachname']) and
      isset($_POST['Vorname']) and
      isset($_POST['KundenID'])){

      $db = new DbOperations();


        if ($db->UpdateLastName($_POST['Nachname'], $_POST['KundenID']) and $db->UpdateName($_POST['Vorname'], $_POST['KundenID'])) {

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
