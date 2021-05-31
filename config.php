<?php

$db_host = "us-cdbr-east-04.cleardb.com:3306";
$db_user = "bc824471867531";
$db_pass = "ce77d49b";
$db_name = "heroku_7198d5e8fe4265e";

try {    
    //create PDO connection 
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
} catch(PDOException $e) {
    //show error
    die("Terjadi masalah: " . $e->getMessage());
}