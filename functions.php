<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 27.02.16
 * Time: 21:36
 */
//проверка емайла на валидность
function checkmail($mail)
{
    // режем левые символы и крайние пробелы
    $mail = trim($mail);
    // если пусто - выход
    if (strlen($mail) == 0) return -1;
    if (!preg_match("/^[a-z0-9_-]{1,20}+(\.){0,2}+([a-z0-9_-]){0,5}@(([a-z0-9-]+\.)+(com|net|org|ru|" .
        "edu|gov|info|biz|[a-z]{2})|[0-9]{1,3}\.[0-9]{1,3}\.[0-" . "9]{1,3}\.[0-9]{1,3})$/is", $mail)
    )
        return -1;
    return $mail;
}
?>