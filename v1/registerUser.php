
<?php

require_once '../include/DbOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['email']) and 
            isset($_POST['password']) and
            isset($_POST['vorname'] ) and
            isset($_POST['nachname'])
        ){
            $db = new DbOperations();            
            
            if(($db->checkIfUserExist($_POST['email'])) == true){ 
                
                $response['error'] = true;
                $response['message'] = "User already registered";
            
            }else{

                if($db->createUser($_POST['email'], $_POST['password'], $_POST['vorname'], $_POST['nachname'])){
                    $response['error'] = false;
                    $response['message'] = "User registered successfully";
                } else{
    
                    $response['error'] = true;
                    $response['message'] = "User registered not successfully, try Again please!";
    
                }
            
            }
            
    }else{
        
        $response['error'] = true;
        $response['message'] = "Required fields are missing";
    }

}else{
    $response['error'] = true;
    $response['message'] = "Invalid Request...";
}

echo json_encode($response);