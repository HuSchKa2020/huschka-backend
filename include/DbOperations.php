<?php

    class DbOperations{

        private $con;

        function __construct(){
            require_once dirname(__FILE__).'/DbConnect.php';
            $db = new DbConnect;
            
            $this->con = $db->connect();
        }

        function createUser($Email, $Passw, $Vorname, $Nachname, $Adresse){
            $Password = md5($Passw); // Hash Password

            $stmt = $this->con->prepare("INSERT INTO `Kunde` (`email`, `password`, `Vorname`, `Nachname`, `Adresse` ) 
                VALUES (?, ?, ?, ?, ?);");

            $stmt->bind_param("sssss", $Email, $Password, $Vorname, $Nachname, $Adresse);

            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
        }
        


            public function idAusgeben($Email){                                     //function die Mittels Email die zuletzt erstellte ID ausgibt.
            $stmt = $this->con->prepare("SELECT id FROM Kunde ORDER BY id DESC;");  

            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }
        
        function checkIfUserExist($Email){
            $stmt = $this->con->prepare("SELECT email FROM Kunde WHERE email = ?;");
        
            $stmt->bind_param("s", $Email);
            $stmt->execute();
            $stmt->store_result();
            return $stmt->num_rows>0;
        }

        function getProductInfo($ProductID){         
            $stmt = $this->con->prepare("SELECT * FROM Produkt WHERE ProduktID = ?;");
            $stmt->bind_param("s", $ProductID);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();          
        }

        public function userLogin($Email, $Passw){
            $Password = md5($Passw);
            $stmt = $this->con->prepare("SELECT id FROM Kunde WHERE email = ? AND password =?;");
            $stmt->bind_param("ss",$Email,$Password);
            $stmt->execute();
            $stmt->store_result();
            return $stmt->num_rows >0;
        }

        public function getUserbyUsername($Email){
            $stmt = $this->con->prepare("SELECT * FROM Kunde WHERE email = ?;");
            $stmt ->bind_param("s",$Email);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        function addShoppingList($UserID, $Date, $Supermarkt){
            $stmt = $this->con->prepare("INSERT INTO `Einkaufsliste` (KundenID, Erstelldatum, Supermarkt) 
                VALUES (?, ?, ?);");

            $stmt->bind_param("sss", $UserID, $Date, $Supermarkt);

            if($stmt->execute()){
                return true;
            }else{
                return false;
            }

        }
        
        function InsertProducts($ListenID, $ProduktID, $Anzahl){
            $stmt = $this->con->prepare("INSERT INTO `Liste_Produkte` (ListenID, ProduktID, Anzahl) 
                VALUES (?, ?, ?);");

            $stmt->bind_param("sss", $ListenID, $ProduktID, $Anzahl);

            if($stmt->execute()){
                return true;
            }else{
                return false;
            }

        }
        
        public function getShoppingListbyUser($ID){
            $stmt = $this->con->prepare("SELECT * FROM Einkaufsliste WHERE KundenID = ?;");
            
            $stmt ->bind_param("s",$ID);
            $stmt->execute();
            $stmt->bind_result($Listenid, $Erstelldatum, $Supermarkt, $Status, $KundenID);
            
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
        function DeleteProduct($ListenID){
            $stmt = $this->con->prepare("DELETE FROM Liste_Produkte where ListenID = ?;");

            $stmt->bind_param("s", $ListenID);

            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
            

        }
        
                function DeleteShoppinglist($ListenID){
            $stmt = $this->con->prepare("DELETE FROM Einkaufsliste where ListenID = ?;");

            $stmt->bind_param("s", $ListenID);
            
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
            

        }
        
        public function getProductsbyListenID($ListenID){
            $stmt = $this->con->prepare("SELECT * FROM Liste_Produkte l, Produkt p WHERE ListenID = ? AND l.ProduktID = p.ProduktID;");
            
            $stmt ->bind_param("s",$ListenID);
            $stmt->execute();
            $stmt->bind_result($ListenID, $ProduktID, $Anzahl, $ProduktID, $Hersteller, $Name, $Kategorie, $Preis, $Kcal);
            
            $response=array();
            
            while($stmt->fetch()){
                $temp = array();
            
            
                $temp['ListenID'] = $ListenID;
                $temp['ProduktID'] = $ProduktID;
                $temp['Hersteller'] = $Hersteller;
                $temp['Name'] = $Name;
                $temp['$Kategorie'] = $Kategorie;
                $temp['Preis'] = $Preis;
                $temp['Kcal'] = $Kcal;
                $temp['Anzahl'] = $Anzahl;

                array_push($response,$temp);
            }
            return $response;
            
            
        }
    }
 