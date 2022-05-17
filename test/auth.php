<?php
    session_start();
    $PDO = new PDO('mysql:host=wsr.loc;dbname=r18300;charset=utf8', 'R18300', 'R18300');

    $login = $_POST['login'];
    $password = $_POST['password'];

    $sql = "SELECT `id`, `login`, `password` FROM `users` WHERE login = :login";
    
    $stmt = $PDO->prepare($sql);
    $stmt->execute([':login'=>$login]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if(password_verify($password,$data['password'])){   
        $_SESSION['ID'] = $data['id'];
        $_SESSION['AUTH'] = true;
        header('Location: /');
    }else{
        $_SESSION['AUTH'] = false;
        header ('Location: /index.php');
    } 
