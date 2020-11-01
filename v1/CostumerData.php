<?php

require_once '../include/DbOperations.php';
$response = array();


if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['id'])){



        $db = new DbOperations();

        $product = $db->GetCostumerData($_POST['id']);

        if($product != null){
            $response['error'] = false;
            $response['message'] = "Costumer exist";
            $response['id'] = $product['id'];
            $response['Vorname'] = $product['Vorname'];
            $response['Nachname'] = $product['Nachname'];
            $response['Adresse'] = $product['Adresse'];
            $response['Bankverbindung'] = $product['Bankverbindung'];;
            $response['email'] = $product['email'];;
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
