<?php

// print_r($_SESSION['is_login']);
include '../functions.php';
// 为了能是其他路径的也能引用 最好使用绝对路径
checkLogin();
  // include 'D:\WWW\program\baixiu\config.php';

  $post_total = query('SELECT COUNT(*) AS total FROM posts');
  $cate_total = query('SELECT COUNT(*) AS total FROM categories');
  $comm_total = query('SELECT COUNT(*) AS total FROM comments');

  // print_r($post_total);
  /* $connect = mysqli_connect('127.0.0.1', 'root', 'root');
  mysqli_select_db($connect, 'baixiu');

  // 文章数
  $sql = 'SELECT COUNT(*) AS total FROM posts';
  $res = mysqli_query($connect, $sql);
  $post_total = mysqli_fetch_assoc($res)['total'];
  // print_r($post_total);

  // 类别数
  $sql2 = 'SELECT COUNT(*) AS total FROM categories';
  $res2 = mysqli_query($connect, $sql2);
  $cate_total = mysqli_fetch_assoc($res2)['total'];
  // print_r($post_total);

  // 评论数
  $sql3 = 'SELECT COUNT(*) AS total FROM comments';
  $res3 = mysqli_query($connect, $sql3);
  $comm_total = mysqli_fetch_assoc($res3)['total']; */
  
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include './inc/navbar.php' ?>
    <div class="container-fluid">
      <div class="jumbotron text-center">
        <h1>One Belt, One Road</h1>
        <p>Thoughts, stories and ideas.</p>
        <p><a class="btn btn-primary btn-lg" href="post-add.php" role="button">写文章</a></p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">站点内容统计：</h3>
            </div>
            <ul class="list-group">
              <li class="list-group-item">
                <strong><?php echo $post_total[0]['total']; ?></strong>篇文章（<strong>2</strong>篇草稿）
              </li>
              <li class="list-group-item">
                <strong><?php echo $cate_total[0]['total']; ?></strong>个分类
              </li>
              <li class="list-group-item">
                <strong><?php echo $comm_total[0]['total']; ?></strong>条评论（<strong>1</strong>条待审核）
              </li>
            </ul>
          </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </div>


  <?php $active = 'dashboard'; ?>
  <!-- 引入侧边栏 -->
  <?php include './inc/aside.php' ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
