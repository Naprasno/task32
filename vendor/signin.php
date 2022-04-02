<?php
    session_start();
    require_once '../config/connect.php';

    $login = trim($_POST['login']);
    $password = md5($_POST['password']."MEGASECRET");
    $remember = $_POST['remember'];


    if($_POST["token"] == $_SESSION["CSRF"])
    {
        if ($login == ''){
            $error = 'Логин не может быть пустым';
            $_SESSION['message'] = $error;
            $log = date('Y-m-d H:i:s') . " Ошибка авторизации: $error";
            file_put_contents('../log.txt', $log . PHP_EOL, FILE_APPEND);
            header('Location: ../index.php');
        }
        else{
            //Начинаем проверку логина и пароля в БД
            $check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
            if (mysqli_num_rows($check_user) > 0) {

                $user = mysqli_fetch_assoc($check_user);

                $_SESSION['user'] = [
                    "id" => $user['id'],
                    "login" => $user['login'],
                    "vk_user" => $user['vk_user']
                ];
                if ($remember){
                    setcookie("cookie_login", $login, time()+60, "/");
                    setcookie("cookie_password", $password, time()+60, "/"); 
                }
                $log = date('Y-m-d H:i:s') . " Авторизация: $login";
                file_put_contents('../log.txt', $log . PHP_EOL, FILE_APPEND);
                header('Location: ../main.php');

            } else {
                $error = 'Не верный логин или пароль';
                $_SESSION['message'] = $error;
                $log = date('Y-m-d H:i:s') . " Ошибка авторизации: $error";
                file_put_contents('../log.txt', $log . PHP_EOL, FILE_APPEND);
                header('Location: ../index.php');
            }
        }

        
    }
    ?>

<pre>
    <?php
    /*
    print_r($check_user);
    print_r($user);
    print_r($remember);
    */

    ?>
</pre>
