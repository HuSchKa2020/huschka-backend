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
            $stmt = $this->con->prepare("SELECT id FROM Kunde ORDER BY id DESC;");  

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
        
        function InsertProducts($listenID, $produktID, $anzahl){
            $stmt = $this->con->prepare("INSERT INTO `Liste_Produkte` (ListenID, ProduktID, Anzahl) 
                VALUES (?, ?, ?);");

            $stmt->bind_param("sss", $listenID, $produktID, $anzahl);

            if($stmt->execute()){
                return true;
            }else{
                return false;
            }

        }
        
        public function getShoppingListbyUser($id){
            $stmt = $this->con->prepare("SELECT * FROM Einkaufsliste WHERE KundenID = ?;");
            
            $stmt ->bind_param("s",$id);
            $stmt->execute();
            $stmt->bind_result($ListenID, $Erstelldatum, $Supermarkt, $Status, $KundenID);
            
            $response=array();
            
            while($stmt->fetch()){
                $temp = array();
            
            
                $temp['ListenID'] = $ListenID;
                $temp['Erstelldatum'] = $Erstelldatum;
                $temp['Supermarkt'] = $Supermarkt;
                $temp['Status'] = $Status;
                $temp['KundenID'] = $KundenID;
            
        
                array_push($response,$temp);
            }
            return $response;
            
            
        }
        
        public function getProducts($Produktname){
            $sql="SELECT * FROM Produkt WHERE Name Like ?;";
            
            $stmt = $this->con->prepare($sql);
            
            $param="%".$Produktname."%";
            $stmt ->bind_param("s",$param);
            
            $stmt->execute();
            $stmt->bind_result($ProduktID, $Hersteller, $Name, $Kategorie, $Preis, $Kcal);
            
            $response=array();
            
            while($stmt->fetch()){
                $temp = array();
            
            
                $temp['ProduktID'] = $ProduktID;
                $temp['Hersteller'] = $Hersteller;
                $temp['Name'] = $Name;
                $temp['Kategorie'] = $Kategorie;
                $temp['Preis'] = $Preis;
                $temp['Kcal'] = $Kcal;
            
        
                array_push($response,$temp);
            }
            return $response;
            
            
        }
        function DeleteProduct($listenid){
            $stmt = $this->con->prepare("DELETE FROM Liste_Produkte where ListenID = ?;");

            $stmt->bind_param("s", $listenid);

            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
            

        }
        
                function DeleteShoppinglist($listenid){
            $stmt = $this->con->prepare("DELETE FROM Einkaufsliste where ListenID = ?;");

            $stmt->bind_param("s", $listenid);
            
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
            

        }
        
                public function getProductsbyListenID($listenid){
            $stmt = $this->con->prepare("SELECT * FROM Liste_Produkte WHERE ListenID = ?;");
            
            $stmt ->bind_param("s",$listenid);
            $stmt->execute();
            $stmt->bind_result($ListenID, $ProduktID, $Anzahl);
            
            $response=array();
            
            while($stmt->fetch()){
                $temp = array();
            
            
                $temp['ListenID'] = $ListenID;
                $temp['ProduktID'] = $ProduktID;
                $temp['Anzahl'] = $Anzahl;
             
            
        
                array_push($response,$temp);
            }
            return $response;
            
            
        }
    }
 