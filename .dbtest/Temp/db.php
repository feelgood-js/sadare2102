<?php session_start(); 
$conn = mysqli_connect("3.129.13.79", "ladder","ladder3237", "php"); 
$conn->set_charset("utf8"); 

function mq($sql) { 
    global $conn; 
    return $conn->query($sql); 
}

?>