<?php

require_once'../include/DbOperations.php';

$response = array();
session_start();
if($_SERVER['REQUEST_METHOD']=='POST'){

  if(isset($_POST['neuesPasswort']) and
      isset($_POST['altesPasswort']) and 
      isset($_POST['KundenID'])){

      $db = new DbOperations();

        if(($db->checkPasswort($_POST['altesPasswort'], $_POST['KundenID'])) == false){
            $response['error'] = true;
            $response['message'] = "eingegebenes Passwort ist falsch";
        }else{

            if($db->UpdatePassword($_POST['neuesPasswort'], $_POST['KundenID'])){
                $response['error'] = false;
                $response['message'] = "Passwort wurde geändert";
            } else {
                $response['error'] = true;
                $response['message'] = "Passwort konnte nicht geändert werden";
            }
        
        }
        
  } else {

    $response['error'] = true;

    $response['message'] = "Required fields are missing";

    }
}else{

  $response['error'] = true;

  $response['message'] = "Invalid Request";
}

echo json_encode($response);
 ?>
