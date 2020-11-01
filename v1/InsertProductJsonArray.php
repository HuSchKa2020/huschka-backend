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
                $db->InsertProducts($_POST['ListenID'],$Item['ProduktID'],$Item['Anzahl'])==false
                ){
                
                    $isError=true;
                    
                }                       
            }
            
            if($isError){
                 $response['error'] = true;
                 $response['message'] = "Products couldn´t be added, try Again please!";
            } else{
                $price = $db->TotalPrice($_POST['ListenID']);
                $response['error'] = false;
                $response['message'] = "hat funktioniert";
                $response['Gesamtpreis'] = $price['Gesamtpreis'];
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