<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 27.02.16
 * Time: 21:33
 */
session_start();
include("header.php");
include("config_connect.php");
$link = new Connect_DB();
$link->connect();
//Если нет сессий
if(md5(crypt($_SESSION['user'],$_SESSION['password'])) != $_SESSION['SID']) {
        echo '<br>
     <div class="row small-centered">
     <form class=" small-5 column small-centered" action="" method="post">
     <input name="login" type="text" value=""> <br/>
     <input name="password" type="password" value="">  <br/>
     <input class="button round" name="do" type="submit" value="Войти">
     </form></div>';
//Если кнопка нажата
    if($_POST['do']) {
//Проверяем данные
        $login = $_POST['login'];
        $pass = $_POST['password'];
        if ($login != '' AND $pass != '') {
            #$sel = new Connect_DB();
            #$res = $sel->select('users', "nickname='". $login ."' AND password='" . md5($pass) . "'");
            $result=mysql_query("SELECT * FROM users WHERE nickname='".$login."' AND password='".md5($pass)."'");
//Проверяем существует ли хоть одна запись
            if (mysql_num_rows($result) == 1) {
                //Если есть, то создаем сессии и перенаправляем на эту страницу
                $_SESSION['user'] = $login;
                $_SESSION['password'] = $pass;
                $_SESSION['SID'] = md5(crypt($_SESSION['user'], $_SESSION['password']));
                Header("Location: index.php");
            }
            else {
                echo '<div class="row"><p class="small-7 column small-centered">Неверный логин/пароль, либо пользователь не зарегистрирован</p></div>';
            }
        }
        else {
            echo '<div class="row"><p class="small-3 column small-centered">Пустой логин/пароль</p></div>';
        }
    }
    else {
        echo '<div class="row"><p class="small-2 column  small-centered">Введите данные</p></div>';
    }
}
else {

    echo '<p class="row column">Вы вошли в профиль редактирования пользователей</p>';
    echo '<br/><br/><a class="row column" href="index.php?edit=1">Редактировать</a>';
    if($_GET['edit']==1) {
        $sql = "SELECT * FROM users";
        $res = mysql_query($sql);
        reset($res);

        for ($i = 0; $i < mysql_num_rows($res); $i++) {
            $f = mysql_fetch_assoc($res);
            echo '<form class="small-11 column" action="index.php?edit=1" method="post">';
            echo "<br><a class='' href='profile.php?id=$f[id]'>$f[nickname]</a>
                  <input class='small-0 column'  type='checkbox' name='user_del[]' value='$f[id]'><br>";

        }
            echo '<br><input class="button tiny round alert" name="del" type="submit" value="Удалить пользователя">
                  </form></div><br>';
        if ($_POST['del']){
            $user_del = $_POST['user_del'];
            if(empty($user_del))
            {
                echo "<p class=' small-12 column'>Вы ничего не выбрали.</p>";
            }
            else
            {
                $N = count($user_del);
                for($i=0; $i < $N; $i++)
                {
                    $query = mysql_query("DELETE FROM users WHERE id=$user_del[$i]");
                    header("Location: index.php?edit=1");

                }
            }
        }
    }

}
if($_GET['exit']) {
    @session_destroy();
    unset($_GET['exit']);
    mysql_close($link);
    Header("Location: index.php");
}
?>
</body>
</html>
