<?php 
session_start();
require_once 'config/connect.php';
// если пользователь не авторизован
if (!isset($_SESSION['user'])) {
    // то проверяем его куки вдруг там есть логин и пароль
    if (isset($_COOKIE['cookie_login']) && isset($_COOKIE['cookie_password'])) {
        // если же такие имеются то пробуем авторизовать пользователя по этим логину и паролю
        $login = $_COOKIE['cookie_login'];
        $password = $_COOKIE['cookie_password'];
        // и по аналогии с авторизацией через форму:
        // делаем запрос к БД
        // и ищем пользователя с таким логином и паролем

		$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");

        if (mysqli_num_rows($check_user) > 0) {
			//если всё получилось, заносим в сессию
            $user = mysqli_fetch_assoc($check_user);

            $_SESSION['user'] = [
                "id" => $user['id'],
                "login" => $user['login'],
                "vk_user" => $user['vk_user']
            ];
		}
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<title>hw32</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Kreon" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="/css/style.css" />
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<div id="logo">

				</div>
				<div id="menu">
                    <ul>
                        <?php 
							if ($_SESSION['user']) {

    							echo '<li><a href="vendor/logout.php" class="logout">Выход</a></li>' ;
							}
							else {
								echo '<li><a href="index.php" class="logout">Войти</a></li>';
							}
						?>
                    </ul>
				</div>
			</div>

			<div id="page">
            <?php 
				if ($_SESSION['user']) {
    				echo "Вы вошли как <b>".$_SESSION['user']['login']  ;				
				}
                else {
                    echo "Пользователь не авторизован."  ;
                }
			?>
                <br>
                <a href="page.php">Страница, на которую нельзя попасть, пока пользователь не авторизован.</a>
            </div>
                
            <div id="footer">
		        <a href="/">hw32&copy; 2022</a>
	        </div>   
        </div>
          
</body>
</html>