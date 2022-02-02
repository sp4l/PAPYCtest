<?php

//Если не заполнены обязательные поля
if (!isset($_POST['surname']) || !isset($_POST['firstname']) || !isset($_POST['secondname']) || !isset($_POST['phone'])) {
    header("Location: index.php?req=fio");
} else if ($_POST['email'] != false) {
    //Если эл. почта существует, @gmail.com запрещен
    $email = strip_tags($_POST['email']);
    $domain = strstr($email, '@');
    if ($domain === '@gmail.com') {
        header("Location: index.php?req=email");
    } else {
        header("Location: index.php?req=ok");
    }
} else {
    header("Location: index.php?req=ok");
}
