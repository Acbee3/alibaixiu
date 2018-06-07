<?php
// 为了能是其他路径的也能引用 最好使用绝对路径
// include 'D:\WWW\program\baixiu\admin\config.php';
// 不是 ./config.php 因为 这个页面要引入到 index.php 中 
// 路径是以 index.php 为标准的
// 这样也导致了 其他文件引入时路径错误
include '../config.php';

session_start();
function checkLogin () {
    
  if(!$_SESSION['is_login']) {
    header('Location: ./login.php');
  }
}

// 查询服务器
function connect() {
    // php 的常量定义后在函数内外都可以使用
    $connect = mysqli_connect(HOST, USER, PASSWORD);

    mysqli_select_db($connect, DATABASE);
    // 函数内的变量不能在函数外使用，要用返回值返回一下
    return $connect;
}

// 查询 SQL
function query($sql) {
    $connect = connect();

    $res = mysqli_query($connect, $sql);

    $rows = array();
    while ($row = mysqli_fetch_assoc($res)) {
        array_push($rows, $row);
    }
    return $rows;
}

// 删除操作
function delete($sql) {
    $connect = connect();

    $res = mysqli_query($connect, $sql);

    if($res) {
        return true;
    }

    return false;
}

// 插入数据
function insert($table, $data) {
    $connect = connect();
    // 将 $data 中的 key 取出，拼凑成 a, b, ...
    $keys = array_keys($data);
    $keys_str = implode(', ', $keys);

    // 将 $data 中的 value 取出，拼凑成 a, b, ...
    $values = array_values($data);

    // 前后各少一个引号
    $values_str = implode('", "', $values);

    $sql = 'INSERT INTO ' . $table . ' (' . $keys_str . ') VALUES("' . $values_str . '")';

    $res = mysqli_query($connect, $sql);
    if($res) {
        return true;
    }

    return false;
}

function update($table, $data) {
    // UPDATE posts SET key1=val1, key2=val2...
    $connect = connect();
    $id = $data['id'];
    unset($data['id']);
    print_r($data);

    $str = '';

    foreach($data as $k => $v) {
        $str .= $k . '="' . $v . '",';
    }

    $str = substr($str, 0, -1);

    $sql = 'UPDATE ' . $table . ' SET ' . $str . ' WHERE id=' . $id;

    $res = mysqli_query($connect, $sql);

    if($res) {
        return true;
    }

    return false;

}
