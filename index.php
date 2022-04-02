<?php
session_start();
/*
if ($_SESSION['user']) {
    header('Location: main.php');
}
*/
$token = hash('gost-crypto', random_int(0,999999));
$_SESSION["CSRF"] = $token;
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Авторизация и регистрация</title>
    <link rel="stylesheet" href="/css/aut.css">
</head>
<body>

<!-- Форма авторизации -->

    <form action="vendor/signin.php" method="post">
        <label>Логин</label>
        <input type="text" name="login" placeholder="Введите свой логин">
        <label>Пароль</label>
        <input type="password" name="password" placeholder="Введите пароль">
        <input type="hidden" name="token" value="<?=$token?>"> <br/>
        <label> Запомнить меня <input type="checkbox" name="remember" checked> </label><br>
        <button type="submit">Войти</button>
        
            <p>У вас нет аккаунта? - <a href="/register.php">Зарегистрируйтесь!</a></p>
            
            <p>ИЛИ <a href="/main.php">продолжите без авторизации!</a></p>
            <p>ИЛИ <a href="vk.php">авторизуйтесь через ВК!</a></p>
        <?php
            if ($_SESSION['message']) {
                echo '<p class="msg"> ' . $_SESSION['message'] . ' </p>';
            }
            unset($_SESSION['message']);
        ?>
        
    </form>

</body>
</html>