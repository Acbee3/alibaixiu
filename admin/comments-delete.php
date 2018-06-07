<?php

    header('Content-Type: application/json; charset=UTF-8');

    include '../functions.php';

    $id = $_GET['id'];

    $sql = 'DELETE FROM comments WHERE id=' . $id;

    $res = query($sql);

    if($res) {
        echo json_encode(array(
            'code' => 200,
            'msg' => '删除成功'
        ));
    } else {
        echo json_encode(array(
            'code' => 201,
            'msg' => '删除失败'
        ));
    };