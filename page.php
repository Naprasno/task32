<?php 
session_start();

if (!$_SESSION['user']) {
    header('Location: /main.php');
}

?>

<p>Текст должен быть виден всем авторизованным пользователям (vk_user = 0), картинка — только пользователям с ролью  «пользователь VK» (vk_user = 1)</p>
<?php
if ($_SESSION['user']['vk_user'] == 1) {
    echo '<img src="/images/1455468516121493345.jpg" alt="">';
}
?>


