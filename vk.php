<?php
session_start();

$client_id = 8123186; // ID приложения
$client_secret = 'otCKbkkqnOdldXLxiSET'; // Защищённый ключ
$redirect_uri = 'http://тут был сайт на котором пробовал, вроде работает))/vk.php'; // Адрес сайта
$url = 'http://oauth.vk.com/authorize'; // Ссылка для авторизации на стороне ВК

$params = [ 'client_id' => $client_id, 'redirect_uri'  => $redirect_uri, 'response_type' => 'code']; // Массив данных, который нужно передать для ВК содержит ИД приложения код, ссылку для редиректа и запрос code для дальнейшей авторизации токеном


if (isset($_GET['code'])) {
    $result = true;
    $params = [
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'code' => $_GET['code'],
        'redirect_uri' => $redirect_uri
    ];

    $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);

    if (isset($token['access_token'])) {
        $params = [
            'uids' => $token['user_id'],
            'fields' => 'uid,first_name,last_name,screen_name,sex,bdate,photo_big',
            'access_token' => $token['access_token'],
            'v' => '5.101'];

        $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
        if (isset($userInfo['response'][0]['id'])) {
            $userInfo = $userInfo['response'][0];
            $result = true;
        }
    }

    if ($result) {
        /*echo "ID пользователя: " . $userInfo['id'] . '<br />';
        echo "Имя пользователя: " . $userInfo['first_name'] . '<br />';
        echo "Ссылка на профиль: " . $userInfo['screen_name'] . '<br />';
        echo "Пол: " . $userInfo['sex'] . '<br />';
        echo "День Рождения: " . $userInfo['bdate'] . '<br />';
        echo '<img src="' . $userInfo['photo_big'] . '" />'; echo "<br />";
*/
        $login = $userInfo['id'];
        $password = "testpassword000";
        
        require_once 'config/connect.php';
        
        $check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
        if (mysqli_num_rows($check_user) > 0) {
        
            $user = mysqli_fetch_assoc($check_user);
        
                $_SESSION['user'] = [
                    "id" => $user['id'],
                    "login" => $user['login'],
                    "vk_user" => $user['vk_user']
                ];
        } 
        else {
            mysqli_query($connect, "INSERT INTO `users` ( `login`,  `password`, `vk_user` ) VALUES ( '$login',  '$password', '1')");
            $check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");
            if (mysqli_num_rows($check_user) > 0) {
            
                $user = mysqli_fetch_assoc($check_user);
            
                $_SESSION['user'] = [
                    "id" => $user['id'],
                    "login" => $user['login'],
                    "vk_user" => $user['vk_user']
                ];
            } 
        }
        
        echo '<a href="/main.php">Вы авторизовались, перейти на главную</a>';
    }
}
else{
    echo $link = '<p><a href="' . $url . '?' . urldecode(http_build_query($params)) . '">авторизация ВКонтакте</a></p>';
}



