<?php
    session_start();

    $PDO = new PDO('mysql:host=wsr.loc;dbname=r18300;charset=utf8', 'R18300', 'R18300');

    $name = $_POST['name'];
    $category = $_POST['category'];
    $opisanie = $_POST['opisanie'];

    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {

        $img = $_FILES['img']['name'];
        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        $dir = '../uploaded_images/';
        $new_name = md5($img).'.'.$ext;
    
        $uploaded_dir = $dir.$new_name;
        
        if(move_uploaded_file($_FILES['img']['tmp_name'], $uploaded_dir)){
            $_SESSION['message'] = 'Файл успешно загружен';
        }else{
            $_SESSION['message'] = 'При загрузке файла произошла ошибка!';
        }

        $iQuery = "INSERT INTO `orders`(`name`, `opisanie`, `category`, `img`) VALUES (:name, :opisanie, :category, :img)";
    
        $stmt = $PDO->prepare($iQuery);
    
        $stmt->execute([
            ":name" => $name,
            ":opisanie" => $opisanie,
            ":category" => $category,
            ":img" => $uploaded_dir,
        ]);

        header('Location:/');
    }