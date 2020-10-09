<?php
define('DB_HOST','localhost');
define('DB_USER','willi');
define('DB_PASS','1234');
define('DB_NAME','huschka');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if(mysqli_connect_error()){
    echo"Failed to connect to MySQL:" . mysqli_connect_error();
    die();
}

//require_once'../include/DbOperations.php';

$stmt = $conn->prepare("SELECT e.ListenID, p.Name, 
                        FROM einkaufsliste.e,  produkt.p, 
                        WHERE   e.ListenID = l.ListenID
                                l.ProduktID = p.ProduktID;");

$stmt->execute();
$stmt->bind_result($e.ListenID, $p.Name);

$einkaufsliste = array();

    while($stmt->fetch()){
        $temp = array();
    
       $temp['ListenID']=$e.ListenID;
 //      $temp['Erstelldatum']=$Erstelldatum;
 //      $temp['Supermarkt']=$Supermarkt;
       $temp['Produktname']=$p.Name;
 //      $temp['Anzahl']=$Anzahl;
    
    array_push($einkaufsliste,$temp);
    }

echo json_encode($einkaufsliste);

?>