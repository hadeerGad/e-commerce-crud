<?php

$host="localhost";
$password="";
$root="root";
$db_name="foodCRUD";

try{
$connection=new PDO("mysql:host=$host;dbname=$db_name",$root ,$password);
}catch(PDOException $error){
    echo "the error is ".$error->getMessage();
}
