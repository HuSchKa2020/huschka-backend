<?php

require_once '../include/DbOperations.php';
$response = array();


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    if(isset($_POST['productID'])){
        
        

        $db = new DbOperations();

        $product = $db->getProductInfo($_POST['productID']);
        
        if($product != null){
            $response['error'] = false;
            $response['message'] = "Product exist";
            $response['id'] = $product['ProduktID'];
            $response['hersteller'] = $product['Hersteller'];
            $response['name'] = $product['Name'];
            $response['preis'] = $product['Preis'];
            $response['kcal'] = $product['Kcal'];;
            $response['kategorie'] = $product['Kategorie'];;
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




/*if(!$conn){
    $response['error'] = true;
    $response['message'] = "Error in Connection";
}else{
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['productID'])
            ){
                $productID = $_POST['productID'];
                           
                $sql_query = "SELECT * FROM 'Produkt' WHERE 'ProduktID' = '$productID';";
                echo $sql_query;
                $result = mysqli_query($conn, $sql_query);
                
                echo $result;

                while($row = mysqli_fetch_array($result)){
                    array_push($result, $row);
                }
   
        }else{
            $response['error'] = true;
            $response['message'] = "Required fields are missing";
        }
    }
//}*/

echo json_encode($response);