
<?php

require_once '../include/DbOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['userID']) and 
            isset($_POST['date']) and
            isset($_POST['supermarkt'])
        ){
            $db = new DbOperations();            

            if($db->addShoppingList($_POST['userID'], $_POST['date'], $_POST['supermarkt'])){
                $response['error'] = false;
                $response['message'] = "Shoppinglist created successfully";
            } else{
    
                $response['error'] = true;
                $response['message'] = "Shoppinglist created successfully, try Again please!";
    
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