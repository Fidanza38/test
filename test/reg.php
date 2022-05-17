<?php
session_start();

/* Подключение к БД */
    $PDO = new PDO('mysql:host=wsr.loc;dbname=r18300;charset=utf8', 'R18300', 'R18300');

    $login = $_POST['login'];
    $email = $_POST['email'];
    $fio = $_POST['fio'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

/** Добавление пользователя в БД */
    $sql = "INSERT INTO `users`(`fio`, `login`, `email`, `password`) VALUES (:fio, :login,:email,:password)";
    $iQuery = $PDO->prepare($sql);
    $result = $iQuery->execute([
        ':fio' => $fio,
        ':login' => $login,
        ':email' => $email,
        ':password' => $password
    ]);

    if($result) {
        $_SESSION['ID'] = $PDO->lastInsertId();
        $_SESSION['AUTH'] = true;
        header('Location: /');
    }