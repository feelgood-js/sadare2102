<?php 
include "db.php"; 
?> 
<table> 
    <th>idx</th> 
    <th>id</th> 
    <th>password</th> 
    <th>name</th> 
    <th>created</th> 

<?php 
$sql = mq("select * from user"); 
while($data = $sql->fetch_array()) { 
?> 
<tr> 
    <td><?php echo $data["idx"]; ?></th> 
    <td><?php echo $data["id"]; ?></th> 
    <td><?php echo $data["password"]; ?></th> 
    <td><?php echo $data["name"]; ?></th> 
    <td><?php echo $data["created"]; ?></th> 
</tr> 

<?php 
} 
?>

