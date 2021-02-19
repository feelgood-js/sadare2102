<?php

$host = 'localhost';
$user = 'root';
$pw = 'ladder3237';
$dbName = 'test';
$port = '3306';
$mysqli = new mysqli($host, $user, $pw, $dbName, $port);
$hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
echo $hashedPassword;
$sql = "
    INSERT INTO user
    (email, password, created)
    VALUES('{$_POST['email']}', '{$hashedPassword}', NOW()
    )";
echo $sql;
$result = mysqli_query($mysqli, $sql);

if ($result === false) {
    echo "저장에 문제가 생겼습니다. 관리자에게 문의해주세요.";
    echo mysqli_error($mysqli);
} else {
?>
    <script>
        alert("회원가입이 완료되었습니다");
        location.href = "index.php";
    </script>
<?php
}
?>