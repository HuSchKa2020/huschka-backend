<?php

require_once '../include/DbOperations.php';
$response = array();


if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['KundenID'])){



        $db = new DbOperations();

        $product = $db->GetCostumerData($_POST['KundenID']);

        if($product != null){
            $response['error'] = false;
            $response['message'] = "Costumer exist";
            $response['UserID'] = $product['id'];
            $response['Vorname'] = $product['Vorname'];
            $response['Nachname'] = $product['Nachname'];
            $response['Adresse'] = $product['Adresse'];
            $response['Bankverbindung'] = $product['Bankverbindung'];;
            $response['Email'] = $product['email'];;
        } else{
            $response['error'] = true;
            $response['message'] = "Product doesnt exist";
        }
    } else{
        $response['error'] = true;
        $response['message'] = "Required fields are missing";
    }
} else{
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

echo json_encode($response);
