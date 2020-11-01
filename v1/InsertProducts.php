<?php

require_once '../include/DbOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(         isset($_POST['ListenID']) and
                isset($_POST['ProduktID']) and 
                isset($_POST['Anzahl']) )
        {
            $db = new DbOperations();            

            if($db->InsertProducts($_POST['ListenID'], $_POST['ProduktID'], $_POST['Anzahl'])){
                $response['error'] = false;
                $response['message'] = "Products were added";
            } else{
    
                $response['error'] = true;
                $response['message'] = "Products couldn´t be added, try Again please!";
    
            }
            
        }else{
        
        $response['error'] = true;
        $response['message'] = "Required fields are missing";
    }

}else{
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

echo json_encode($response);