
<?php

require_once '../include/DbOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['email']) and 
            isset($_POST['password']) and
            isset($_POST['vorname'] ) and
            isset($_POST['nachname']) and 
            isset($_POST['adresse'])
        ){
            $db = new DbOperations();            
            
            if(($db->checkIfUserExist($_POST['email'])) == true){ 
                
                $response['error'] = true;
                $response['message'] = "User already registered";
            
            }else{

                if($db->createUser($_POST['email'], $_POST['password'], $_POST['vorname'], $_POST['nachname'], $_POST['adresse'])){
                    $user = $db->idAusgeben($_POST['email']);                                                       //variable, die auf die function idAusgeben zugreift siehe Skript DbOperations                                              
                    $response['error'] = false;
                    $response['message'] = "User registered successfully";
                    $response['id'] = $user['id'];         
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