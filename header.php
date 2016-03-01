<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 01.03.16
 * Time: 19:37
 */
echo '
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="static/foundation-5.5.3/css/foundation.css">
</head>
<title>User profile</title>
<body>
<div class="top-bar">
    <section class="top-bar-section">
        <ul class="title-area">
            <li class="name">
                <h1><a href="/">Главная</a></h1>
            </li>
        </ul>';
if (($_SESSION['SID'])==null){
    echo '<ul class="right">
            <li><a href="registration.php">Регистрация</a></li>
        </ul>';
}
echo'
        <ul class="right">
            <li><a href="index.php?exit=1">Выход: '.ucfirst($_SESSION['user']).' </a></li>
        </ul>
    </section>
</div>';
?>