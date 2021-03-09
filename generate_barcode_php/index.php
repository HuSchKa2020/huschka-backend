<?php

require_once'../include/DbOperations.php';
include'QR_BarCode.php';

$response = array();
session_start();
if($_SERVER['REQUEST_METHOD']=='GET'){

  if(true/*isset($_POST['ListenID']*/) {

    $db = new DbOperations();

    $response = $db->TotalPrice($_GET['ListenID']);

    //QRcode Objekt
    $qr = new QR_BarCode();

    //Text QR code
    $qr->url($response['Gesamtpreis']);
    //("http://www.huschka.ddnss.de/huschka/v1/TotalPrice.php/{$_POST['ListenID']}");

    //save QRcode image


    $qr->qrCode(500);




    $response['error'] = false;
    $response['message'] = "QR-Code generiert";



  }else{

    $response['error'] = true;
    $response['message'] = "Required fields are missing";

        }

}else{

  $response['error'] = false;
  $response['message'] = "Invalid Request";
}


echo json_encode($response);
?>
