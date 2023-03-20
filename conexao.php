<?php
    $host = "localhost";
    $user = "root";
    $pass = "senha usada no PHPMyAdmin";
    $dbname = "projeto"; 
    $port = "3306";

    //conexão sem a porta 
    //$conn = new PDO('mysql:host=$host;dbname=' . $dbname, $user,$pass);

    //conexão com a porta
    $conn = new PDO("mysql:host=$host;port=$port;dbname=" . $dbname, $user,$pass);
    //conectamos com o banco de dados, de forma a colocar a prota

?>