<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 27.02.16
 * Time: 21:35
 */
session_start();
include("config_connect.php");
include("functions.php");
//Необходимо подключиться к БД
$link = mysql_connect($DBSERVER, $DBUSER, $DBPASS)
or die("Не могу подключиться" );
// сделать $DB текущей базой данных
mysql_select_db($DB, $link) or die ('Не могу выбрать БД');

if(!$_POST['do'] OR $_POST['do'] =='') {
//Генерируем шестизначный ключ для капчи
    if($_SESSION['uid'] =='') {
        $_SESSION['uid'] = mt_rand(100000,999999);
    }

//Выводим форму
    echo '<html><head><title>Регистрация</title></head><body>';
    echo '<h2>Форма регистрации</h2>';
    echo'<form action="" method="POST"><table cellpadding=4 cellspacing=0 border=1 style="border-collapse:collapse">';
    echo '<tr><td>Никнэйм:</td><td><input name="nick" type="text" value=""></td></tr>';
    echo '<tr><td>Пароль:</td><td><input name="pass" type="password" value=""></td></tr>';
    echo '<tr><td>Ещё раз пароль:</td><td><input name="rpass" type="password" value=""></td></tr>';
    echo '<tr><td>Эл.адрес</td><td><input name="mail" type="text" value=""></td></tr>';
    echo '<tr align="center"><td colspan=2>'.$_SESSION['uid'].'<br/><input name="sid" type="text" value=""></td></tr>';
    echo '<tr><td colspan=2 align="right"><input name="do" type="submit" value="зарегистрировать"></td></tr>';
    echo '</table></form><a href="./">« Назад</a></body></html>';
}
//Если данные отправлены
if($_POST['do'] !='') {
//Начинаем проверять входящие данные
    if($_POST['sid'] == $_SESSION['uid']) {

//Создаем запрос к базе для проверки существования Пользователя
        $nick = $_POST['nick'];
        $result = mysql_query("SELECT * FROM users WHERE nickname='".strtolower($nick)."'");

//Проверка результата запроса
        if(mysql_num_rows($result)==0) {
//Проверка ввведенных паролей

            if($_POST['pass'] !='' AND $_POST['rpass'] !='' AND $_POST['pass'] === $_POST['rpass']){
//Проверяем на валидность электронный адрес
                if(checkmail($_POST['mail']) !== -1) {

//Осуществляем регистарацию
//Генерируем uniq_id
                    #$session_id = md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'].mktime());
                    $session_id = md5(date("dmY H:i:s"));
                    $pass = $_POST['pass'];
                    $email = $_POST['mail'];
//Создаем запрос для записи данных в БД
                    $r = mysql_query("INSERT INTO users VALUES(NULL,'".strtolower($nick)."','".md5($pass)."','".$email."','".$session_id."',1,'".date("d-m-Y H:i:s")."')");

//После запроса выводим сообщение о регистрации
                    if($r) {
                        echo 'Вы зарегистрированы <br/><br/>';
                        echo '<a href="index.php">Перейти на главную</a> <br/><br/>';
                    }
                        else {
                            echo 'Регистрация невозможна: Повторите запрос позднее';
                        }
                    }
                    else {
                        echo 'Регистрация невозможна: Электронный адрес должен соответствовать шаблону <b>name@domen.com</b><br/><a href="registration.php"/>назад</a>';
                    }
                }
                else {
                    echo 'Регистрация невозможна: Введенные пароли не совпадают<br/><a href="registration.php"/>назад</a>';
                }
            }
            else {
                echo 'Регистрация невозможна: Пользователь с таким именем уже существует<br/><a href="registration.php"/>назад</a>';
            }
        }
        else {
            echo 'Регистрация невозможна: код подтверждения введен не верно<br/><a href="registration.php"/>назад</a>';
        }
        session_destroy();
    }
    else {

    }
?>