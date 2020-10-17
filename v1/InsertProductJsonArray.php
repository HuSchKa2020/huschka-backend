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
                $db->InsertProducts($Item['ListenID'],$item['ProduktID'],$item['Anzahl'])==false
                ){

                    $isError=true;
                    
                }
            }
            
            if($isError){
                 $response['error'] = true;
                 $response['message'] = "Products couldn´t be added, try Again please!";
            } else{
                $response['error'] = false;
                $response['message'] = "hat funktioniert";
              
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