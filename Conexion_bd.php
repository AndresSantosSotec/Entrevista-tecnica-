<?php

$server="localhost";
$username="root";
$password="";
$dbname="test_entrevista";

$con= new mysqli($server,$username,$password,$dbname);

if($con->connect_error){
    die("comnexion fallida ".$conn->connect_error);
}
?>