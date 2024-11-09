<?php
    $login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
    $pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);

    $pass = md5($pass."dghH5R!l");

    $mysql = new mysqli('localhost', 'root', 'root', 'register');

    if ($mysql->connect_error) {
        die("Ошибка подключения: " . $mysql->connect_error);
    }

    $result = $mysql->query("SELECT * FROM `users` WHERE `login` = '$login' AND `pass` = '$pass'");
    if (!$result) {
        die("Ошибка выполнения запроса: " . $mysql->error);
    }

    $user = $result->fetch_assoc();
    if (!$user) {
        echo "Пользователь не найден";
        exit();
    }

    setcookie('user', $user['name'], time() + 3600, "/");
    header('Location: /checkout.php');

    $mysql->close();
    exit();
?>