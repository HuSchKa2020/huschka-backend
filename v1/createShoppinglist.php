
<?php

require_once '../include/DbOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['KundenID']) and 
            isset($_POST['Erstelldatum']) and
            isset($_POST['Supermarkt'])
        ){
            $db = new DbOperations();            

            if($db->addShoppingList($_POST['KundenID'], $_POST['Erstelldatum'], $_POST['Supermarkt'])){
                $user = $db->ListenidAusgeben($_POST['KundenID']); 
                //$Status = $db->StatusSetzen($_POST[$user'ListenID']);
                $response['error'] = false;
                $response['message'] = "Shoppinglist created successfully";
                $response['ListenID'] = $user['ListenID'];
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