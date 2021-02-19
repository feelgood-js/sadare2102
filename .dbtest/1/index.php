<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js" integrity="sha384-BOsAfwzjNJHrJ8cZidOg56tcQWfp6y72vEJ8xQ9w6Quywb24iOsW913URv1IS4GD" crossorigin="anonymous"></script>
</head>

<body>
    <ul class="nav justify-content-end">
        <?php
        if (isset($_SESSION['userId'])) {
            echo "{$_SESSION['userId']}님 환영합니다  ";
        ?>
            <li class="nav-item d-flex align-items-center" onclick="logout()">로그아웃</li>
        <?php
        } else {
        ?>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="signup.php">회원가입 </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="login.php">로그인</a>
            </li>

        <?php
        }
        ?>
    </ul>
    <script>
        function logout() {
            console.log("hello");
            const data = confirm("로그아웃 하시겠습니까?");
            if (data) {
                location.href = "logoutPrcoess.php";
            }

        }
    </script>
</body>

</html>