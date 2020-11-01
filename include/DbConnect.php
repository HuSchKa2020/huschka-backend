<?php

class DbConnect{

    private $con;
    
    function __construct(){

    }

    function connect(){
        include_once dirname(__FILE__).'/Constants.php';
        
        $this->con = new mysqli(DB_Host, DB_User, DB_Password, DB_Name);
        
        if(mysqli_connect_errno()){
            echo "Failed Connection Database".mysqli_connect_error();
        }

        return $this->con;
    }

}