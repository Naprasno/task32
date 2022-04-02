<?php
session_start();
unset($_SESSION['user']);
setcookie("cookie_login", $login, time()-60, "/");
setcookie("cookie_password", $login, time()-60, "/");

header('Location: ../index.php');