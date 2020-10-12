<?php

require_once '../include/DbOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(         isset($_POST['listenID']) and
                isset($_POST['produktID']) and 
                isset($_POST['anzahl']) )
        {
            $db = new DbOperations();            

            if($db->InsertProducts($_POST['listenID'], $_POST['produktID'], $_POST['anzahl'])){
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