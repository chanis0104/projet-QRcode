<?php
// creations des constantes a la base de donnee
define("USER","root");
define("PASSWORD","");
$HOST="localhost";
$dbNAME="qr_code_data";

// connexion a la base de donnee
try{
    $db=new PDO("mysql:host=$HOST;dbname=$dbNAME",USER,PASSWORD);
    return $db;
}

catch(PDOException $e){
    echo $e->getMessage();
}