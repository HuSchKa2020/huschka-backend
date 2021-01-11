<?php
require_once '../include/DbOperations.php';
$response = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    if(isset($_POST['ProductArray']))
        {
            
            $db=new DbOperations();
            
            $Arr=json_decode($_POST['ProductArray'],true);
            
            $isError=false;
            
            foreach((array)$Arr as $Item){
                
                if(
                $db->InsertProducts($_POST['ListenID'], $Item['ProduktID'], $Item['Anzahl'])==false
                ){
                
                    $isError=true;
                    
                }                       
            }
            
            if($isError){
                 $response['error'] = true;
                 $response['message'] = "Die Produkte konnten der Einkaufsliste leider nicht hinzugefügt werden.";
            } else{
                $price = $db->TotalPrice($_POST['ListenID']);
                $response['error'] = false;
                $response['message'] = "Produkte wurden der Einkaufsliste erfolgreich hinzugefügt.";
                $response['Gesamtpreis'] = $price['Gesamtpreis'];
                $response['Scores'] = $db->getScores($_POST['ListenID']);
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
?>