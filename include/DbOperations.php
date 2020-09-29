<?php

    class DbOperations{

        private $con;

        function __construct(){
            require_once dirname(__FILE__).'/DbConnect.php';
            $db = new DbConnect;
            
            $this->con = $db->connect();
        }

        function createUser($email, $passw, $vorname, $nachname){
            $password = md5($passw); // Hash Password

            $stmt = $this->con->prepare("INSERT INTO `Kunde` (`email`, `password`, `Vorname`, `Nachname`) 
                VALUES (?, ?, ?, ?);");

            $stmt->bind_param("ssss", $email, $password, $vorname, $nachname);

            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
        }

        function checkIfUserExist($email){
            $stmt = $this->con->prepare("SELECT email FROM Kunde WHERE email = ?;");
        
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            return $stmt->num_rows>0;
        }

        function getProductInfo($productID){         
            $stmt = $this->con->prepare("SELECT * FROM Produkt WHERE ProduktID = ?;");
            $stmt->bind_param("s", $productID);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();          
        }
    }