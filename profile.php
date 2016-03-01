<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 01.03.16
 * Time: 1:04
 */
if (isset($_GET['id'])) {
    session_start();
    include("header.php");
    include("config_connect.php");
    $link = new Connect_DB();
    $link->connect();
    $res = mysql_query("SELECT * FROM users WHERE id='".$_GET['id']."'");
    $r = mysql_fetch_assoc($res);
    /*foreach($r as $key => $value){
        echo "$key - $value<br>";
    }*/
    #echo var_dump($r);
    for($i=0; $i < mysql_num_rows($res); $i++){
        echo '
        <br>
        <div class="row column small-4">
        <form method="post" action="profile.php?id='.$_GET['id'].'">
        <label for="nick">Никнэйм</label><input name="nick"  type="text" value='.$r['nickname'].'>
        <label for="mail">E-mail</label><input name="mail"  type="email" value='.$r['email'].'>
        <label for="tel">Телефон</label><input name="tel"  type="tel" value='.$r['telephone'].'>
        <input class="button tiny round success" name="change_user" type="submit" value="Изменить данные"> <br>
        </form>
         </div>';
    }
    if($_POST['change_user']){
        $result = mysql_query("UPDATE users SET nickname='".$_POST['nick']."', email='".$_POST['mail']."',telephone='".$_POST['tel']."' WHERE id='".$_GET['id']."'");
        mysql_query($result);
        header("Location: profile.php?id=$_GET[id]");

    }
}
else
{
    echo 'Данные пользователя изменены';
}
?>