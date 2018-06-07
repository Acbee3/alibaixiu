<?php
   

    include '../functions.php';

    checkLogin();

    // 获取每页显示的条数
    $size = $_GET['size'];
    // $sql = 'SELECT * FROM comments';

    // 计算数据库 comments 中有多少条数据
    $sql = 'SELECT COUNT(*) AS total FROM comments LEFT JOIN posts ON comments.post_id=posts.id';

    // 数据库中的中评论数
    $total = query($sql)[0]['total'];
    // 总共有多少页
    $pages = ceil($total / $size);

    // 获取 当前的页码(默认第1页)
    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    // 从哪开始取数
    $offset = ($page - 1) * $size;

    // 查询
    $sql = 'SELECT comments.*, posts.title FROM comments LEFT JOIN posts ON comments.post_id=posts.id LIMIT ' . $offset . ' , ' . $size;

    $comments = query($sql);
    // echo json_encode($comments);

    echo json_encode(array(
        'data' => $comments,
        'pages'=>$pages
    ));




    