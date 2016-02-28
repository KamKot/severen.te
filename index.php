<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 27.02.16
 * Time: 21:33
 */
session_start();
//Поключаем конфиг
include("config_connect.php");
$link = new Connect_DB();
$link->connect();
//Необходимо подключиться к БД
#$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
#or die("Не могу подключиться" );
// сделать $DB текущей базой данных
#mysql_select_db($DB, $link) or die ('Не могу выбрать БД');
//Если нет сессий
if(md5(crypt($_SESSION['user'],$_SESSION['password'])) != $_SESSION['SID']) {
        echo '
<a href="registration.php">регистрация</a> <br/><br/>
<form name="1" action="" method="post">
     <input name="login" type="text" value=""> <br/>
     <input name="password" type="password" value="">  <br/>
     <input name="do" type="submit" value="Войти">
</form>';
//Если кнопка нажата
    if($_POST['do']) {
//Проверяем данные
        $login = $_POST['login'];
        $pass = $_POST['password'];
        if ($login != '' AND $pass != '') {
//Создаем запрос
            $sel = new Connect_DB();
            $res = $sel->select('users', "nickname='". $login ."' AND password='" . md5($pass) . "' AND status='". 1 ."'");
            #$result=mysql_query("SELECT * FROM users WHERE nickname='".$login."' AND password='".md5($pass)."' AND status=1");
//Проверяем существует ли хоть одна запись
            if (mysql_num_rows($res) === 1) {
                //Если есть, то создаем сессии и перенаправляем на эту страницу
                $_SESSION['user'] = $login;
                $_SESSION['password'] = $pass;

                $_SESSION['SID'] = md5(crypt($_SESSION['user'], $_SESSION['password']));
                Header("Location: index.php");
            }
            else {
                echo 'Неверный логин/пароль';
            }
        }
        else {
            echo 'Пустой логин/пароль';
        }
    }
    else {
        echo 'Введите данные';
    }
}
else {
    echo 'Вы вошли в профиль редактирования пользователей';
        $result = mysql_query("SELECT * FROM users WHERE nickname='".$_SESSION['user']."' AND password='".$_SESSION['password']."' AND status=1");
        $r2 = mysql_fetch_array($result);
        echo '<br/><p>Вы: '.ucfirst($_SESSION['user']).'</p><br/>';
        echo '<a href="index.php">главная</a>   ';
        echo '<br/><br/><a href="index.php?exit=1">выход</a>';

}
if($_GET['exit']) {
    @session_destroy();
    unset($_GET['exit']);
    mysql_close($link);
    Header("Location: index.php");
}
?>