<?php
    $host = 'localhost';
    $user = 'root';
    $pw = 'ladder3237';
    $dbName = 'test';
    $port = '3307';
    $mysqli = new mysqli($host, $user, $pw, $dbName, $port);
 
    if($mysqli){
        echo "MySQL 접속 성공";
    }else{
        echo "MySQL 접속 실패";
    }
?>