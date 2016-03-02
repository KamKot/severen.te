
<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 27.02.16
 * Time: 21:35
 */
session_start();
include("header.php");
include("config_connect.php");
include("functions.php");

$link = new Connect_DB();
$link->connect();

if(!$_POST['do'] OR $_POST['do'] =='') {
//Генерируем шестизначный ключ для капчи
    if ($_SESSION['uid'] == '') {
        $_SESSION['uid'] = mt_rand(100000, 999999);
    }
}

if(!$_POST['do'] OR $_POST['do'] =='') {
//Генерируем шестизначный ключ для капчи
    if($_SESSION['uid'] =='') {
        $_SESSION['uid'] = mt_rand(100000,999999);
    }
//Выводим форму
    echo '<div class="row small-centered">
    <form id="regform" class="small-5 column small-centered" action="" method="POST">
        <label for="nick">Никнэйм</label><input  name="nick" type="text" value=""><div id="content"></div>
        <label for="pass">Пароль</label><input name="pass" type="password" value="">
        <label for="rpass">Ввести пароль еще раз</label><input name="rpass" type="password" value="">
        <label for="email">E-mail</label><input name="mail" type="text" value="">
        <label for="tel">Телефон</label><input name="tel" type="text" value="">
        <label for="sid">Цифровой код</label><input class="" name="sid" type="text" value=""><b class="small-7 small-centered">'.$_SESSION['uid'].'</b>
        <input class="tiny button success round right"  name="do" type="submit" value="Зарегистрировать">
</div>

';
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
                    $session_id = md5(date("dmY H:i:s"));
                    $pass = $_POST['pass'];
                    $email = $_POST['mail'];
                    $tel = $_POST['tel'];
//Создаем запрос для записи данных в БД
                    $r = mysql_query("INSERT INTO users VALUES(NULL,'".strtolower($nick)."','".md5($pass)."','".$email."','".$session_id."','".date("d-m-Y H:i:s")."','".$tel."')");

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

