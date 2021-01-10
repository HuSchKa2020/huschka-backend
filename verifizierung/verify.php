<?php

require_once '../include/DbOperations.php';

  if(isset($_GET['vkey'])) {
    echo "verified";
    $db = new DbOperations();
    $db->setUserverified($_GET['vkey']);
    
  } else {
    echo "Fehler";
  }

  echo $_GET['vkey'];