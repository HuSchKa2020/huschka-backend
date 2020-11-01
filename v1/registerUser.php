
<?php

require_once '../include/DbOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['email']) and 
            isset($_POST['Password']) and
            isset($_POST['Vorname'] ) and
            isset($_POST['Nachname']) and
            isset($_POST['Adresse'])
        ){
            $db = new DbOperations();

            if(($db->checkIfUserExist($_POST['Email'])) == true){

                $response['error'] = true;
                $response['message'] = "User already registered";

            }else{

                if($db->createUser($_POST['Email'], $_POST['Password'], $_POST['Vorname'], $_POST['Nachname'], $_POST['Adresse'])){
                    $user = $db->idAusgeben($_POST['Email']);                                                       //variable, die auf die function idAusgeben zugreift siehe Skript DbOperations
                    $response['error'] = false;
                    $response['message'] = "User registered successfully";
                    $response['UserID'] = $user['id'];
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
