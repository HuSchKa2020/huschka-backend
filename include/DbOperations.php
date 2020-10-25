<?php

    class DbOperations{

        private $con;

        function __construct(){
            require_once dirname(__FILE__).'/DbConnect.php';
            $db = new DbConnect;
            
            $this->con = $db->connect();
        }

        function createUser($email, $passw, $Vorname, $Nachname, $Adresse){
            $password = md5($passw); // Hash Password

            $stmt = $this->con->prepare("INSERT INTO `Kunde` (`email`, `password`, `Vorname`, `Nachname`, `Adresse` ) 
                VALUES (?, ?, ?, ?, ?);");

            $stmt->bind_param("sssss", $email, $password, $Vorname, $Nachname, $Adresse);

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

        function getProductInfo($ProduktID){         
            $stmt = $this->con->prepare("SELECT * FROM Produkt WHERE ProduktID = ?;");
            $stmt->bind_param("s", $ProduktID);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();          
        }

        public function userLogin($email, $passw){
            $Password = md5($Passw);
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

        function addShoppingList($KundenID, $Erstelldatum, $Supermarkt){
            $stmt = $this->con->prepare("INSERT INTO `Einkaufsliste` (KundenID, Erstelldatum, Supermarkt, ListStatus) 
                VALUES (?, ?, ?, 'erstellt');");


            $stmt->bind_param("sss", $KundenID, $Erstelldatum, $Supermarkt);
            
            if($stmt->execute()){

            
                return true;
            }else{
                return false;
            }

        }
        
        public function ListenidAusgeben($KundenID){                                     
            $stmt = $this->con->prepare("SELECT ListenID FROM Einkaufsliste WHERE KundenID = ? ORDER BY ListenID DESC;");  
            $stmt -> bind_param("s", $KundenID);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }
        
        public function StatusSetzen($ListenID){
            $stmt = $this->con->prepare("UPDATE einkaufsliste SET ListStatus = 'erstellt' WHERE ListenID = ?;");
            $stmt -> bind_param("s", $ListenID);
            $stmt -> execute();
            return $stmt->get_result()->fetch_assoc();
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
        
        public function getShoppingListbyUser($KundenID){
            $stmt = $this->con->prepare("SELECT * FROM Einkaufsliste WHERE KundenID = ?;");
            
            $stmt ->bind_param("s",$KundenID);
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
        function DeleteAllProduct($ListenID){
            $stmt = $this->con->prepare("DELETE FROM Liste_Produkte where ListenID = ?;");

            $stmt->bind_param("s", $ListenID);

            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
            

        }
        
        public function DeleteProduct($ListenID, $ProduktID){
            $stmt = $this->con->prepare("DELETE FROM Liste_Produkte where ListenID = ? AND ProduktID = ?;");

            $stmt->bind_param("ss", $ListenID, $ProduktID);

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
        
        public function AddUpAllPricesOfProducts($ListenID){
                $stmt=$this->con->prepare ("SELECT ListenID, SUM(b.Preis * a.Anzahl) FROM Liste_Produkte a, Produkt b WHERE ListenID = ? AND a.ProduktID = b.ProduktID;");
                $stmt->bind_param("s",$ListenID);
                $stmt->execute();
                $stmt->bind_result($ListenID, $Preis);
            
                $response=array();
            
                while($stmt->fetch()){
                    $temp = array();
                    
                    $temp['ListenID'] = $ListenID;
                    $temp['Gesamtpreis'] = $Preis;
                
                    array_push($response,$temp);
            }
            return $response;
            
        }
        
        public function TotalPrice($ListenID){
            $stmt = $this->con->prepare("SELECT SUM(b.Preis * a.Anzahl) as price FROM Liste_Produkte a, Produkt b WHERE ListenID = ? AND a.ProduktID = b.ProduktID;");
            $stmt -> bind_param("s", $ListenID);
            $stmt -> execute();
            return $stmt->get_result()->fetch_assoc();
        }
    }
 