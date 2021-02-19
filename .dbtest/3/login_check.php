<?php
session_start();
$id=$_POST['id'];
$pw=$_POST['pw'];
$mysqli=mysqli_connect("localhost","root","ladder3237","test");

$check="SELECT * FROM user_info WHERE userid='$id'";
$result=$mysqli->query($check);
if($result->num_rows==1){
    $row=$result->fetch_array(MYSQLI_ASSOC); //하나의 열을 배열로 가져오기
    if($row['userpw']==$pw){    //MYSQLI_ASSOC 필드명으로 첨자 가능
        $_SESSION['userid']=$id;        //로그인 성공 시 세션 변수 만들기
        if(isset($_SESSION['userid']))
        {
            header('Location: ./main.php');
        }
        else {
            echo "세션 저장 실패";
        }
    }
    else {
        echo "wrong id or pw";
    }
}
else {
    echo "wrong id or pw";
}

?>