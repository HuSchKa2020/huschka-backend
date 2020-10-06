<?php

    class DbOperations{

        private $con;

        function __construct(){
            require_once dirname(__FILE__).'/DbConnect.php';
            $db = new DbConnect;
            
            $this->con = $db->connect();
        }

        function createUser($email, $passw, $vorname, $nachname, $adresse){
            $password = md5($passw); // Hash Password

            $stmt = $this->con->prepare("INSERT INTO `Kunde` (`email`, `password`, `Vorname`, `Nachname`, `Adresse` ) 
                VALUES (?, ?, ?, ?, ?);");

            $stmt->bind_param("sssss", $email, $password, $vorname, $nachname, $adresse);

            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
        }

            public function idAusgeben($email){                                     //function die Mittels Email die zuletzt erstellte ID ausgibt.
            $stmt = $this->con->prepare("SELECT id FROM kunde ORDER BY id DESC;");  
            $stmt ->bind_param("s",$email);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
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

        public function userLogin($email, $passw){
            $password = md5($passw);
            $stmt = $this->con->prepare("SELECT id FROM Kunde WHERE email = ? AND password =?;");
            $stmt->bind_param("ss",$email,$password);
            $stmt->execute();
            $stmt->store_result();
            return $stmt->num_rows >0;
        }

        public function getUserbyUsername($email){
            $stmt = $this->con->prepare("SELECT * FROM Kunde WHERE email = ?;");
            $stmt ->bind_param("s",$email);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        function addShoppingList($userID, $date, $supermarkt){
            $stmt = $this->con->prepare("INSERT INTO `Einkaufsliste` (KundenID, Erstelldatum, Supermarkt) 
                VALUES (?, ?, ?);");

            $stmt->bind_param("sss", $userID, $date, $supermarkt);

            if($stmt->execute()){
                return true;
            }else{
                return false;
            }

        }
    }