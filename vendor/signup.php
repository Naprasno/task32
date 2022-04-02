<?php

    session_start();
    require_once '../config/connect.php';

    $login = trim($_POST['login']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if ($login == ''){
        $error = 'Логин не может быть пустым';
        $_SESSION['message'] = $error;
        $log = date('Y-m-d H:i:s') . " Ошибка регистрации: $error";
        file_put_contents('../log.txt', $log . PHP_EOL, FILE_APPEND);
        header('Location: ../register.php');
    }
    else{
        if ($password == ''){
            $error = 'Пароль не может быть пустым';
            $_SESSION['message'] = $error;
            $log = date('Y-m-d H:i:s') . " Ошибка регистрации: $error";
            file_put_contents('../log.txt', $log . PHP_EOL, FILE_APPEND);
            header('Location: ../register.php');
        }
        else {
            $check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login'");
            if (mysqli_num_rows($check_user) > 0) {
                $error = 'Такой логин уже занят';
                $_SESSION['message'] = $error;
                $log = date('Y-m-d H:i:s') . " Ошибка регистрации: $error";
                file_put_contents('../log.txt', $log . PHP_EOL, FILE_APPEND);
                header('Location: ../register.php');
        
            } else {
                if ($password === $password_confirm) {
        
                    $password = md5($password."MEGASECRET");
            
                    mysqli_query($connect, "INSERT INTO `users` ( `login`,  `password`, `vk_user` ) VALUES ( '$login',  '$password', '0')");
            
                    $_SESSION['message'] = 'Регистрация прошла успешно!';
                    header('Location: ../index.php');
            
            
                } else {
                    $error = 'Пароли не совпадают';
                    $_SESSION['message'] = $error;
                    $log = date('Y-m-d H:i:s') . " Ошибка регистрации: $error";
                    file_put_contents('../log.txt', $log . PHP_EOL, FILE_APPEND);
                    header('Location: ../register.php');
                }
            }

        }
      
    }









    

?>
