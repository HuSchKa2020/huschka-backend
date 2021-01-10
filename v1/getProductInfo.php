<?php

require_once '../include/DbOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    if(isset($_POST['ProduktID'])){
        
        $db = new DbOperations();

        $product = $db->getProductInfo($_POST['ProduktID']);
        
        if($product != null){
            $response['error'] = false;
            $response['message'] = "Product exist";
            $response['ProduktID'] = $product['ProduktID'];
            $response['Hersteller'] = $product['Hersteller'];
            $response['Name'] = $product['Name'];
            $response['Preis'] = $product['Preis'];
            $response['Kcal'] = $product['Kcal'];
            $response['Kategorie'] = $product['Kategorie'];
            $response['GesundheitsScore'] = $product['GesundheitsScore'];
            $response['UmweltScore'] = $product['UmweltScore'];
            $response['Ernaehrungsform'] = $product['Ernaehrungsform'];
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