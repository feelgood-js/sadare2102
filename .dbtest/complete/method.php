<?php include "db.php"; 
$id = $_POST['id']; 
$pw = $_POST['password']; 
$name = $_POST['name']; 
$date = date("Y-m-d", time()); 
$result = mysqli_query($conn, "INSERT INTO user(id, password, name, created)VALUES('".$id."','".$pw."','".$name."','".$date."')") or die ("알수없는 오류"); ?>



