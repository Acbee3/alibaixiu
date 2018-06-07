<?php 
    // 文件名后缀
    
    $ext = pathinfo($_FILES['feature']['name'])['extension'];

    // 创建一存储位置
    $path = '../uploads/' . time() . '.' . $ext;

    move_uploaded_file($_FILES['feature']['tmp_name'], $path);

    echo $path;