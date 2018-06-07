<?php

  include '../functions.php';
  checkLogin();

  // print_r($_GET); 
  // 接收 $_GET['page'] 页码
  $page = isset($_GET['page']) ? $_GET['page'] : 1;

  // 防止有人故意挑负数
  if($page < 0) {
    header('Location: ./posts.php?page=1');
  }

  // 删除文章并保留在当前页
  if(isset($_GET['action']) && $_GET['action'] == 'delete') {
    $sql = 'DELETE FROM posts WHERE id=' . $_GET['id'];

    // 执行删除
    $res = delete($sql);

    if($res) {
      header('Location: ./posts.php?page=' . $page);
    }

    die();
  }


  $total = query('SELECT COUNT(*) AS total FROM posts')[0]['total'];
  // print_r($total);
  
  // 每页显示条数
  $pageSize = 10;
  $pageLength = ceil($total / $pageSize);

  // 防止有人故意挑大数
  if($page > $pageLength && $pageLength > 0) {
    header('Location: ./post.php?page=' . $pageLength);
  }
  // 每次显示 3 页
  $pages = 3;


  // 起点
  $start = ceil($page - $pages / 2);
  // 页码不能小于 1
  if($start < 1) {
    $start = 1;
  }

  // 终点
  $end = $start + $pages - 1;

  // 保证在界限内
  if($end >= $pageLength) {

    $end = $pageLength;

    $start = $end - $pages + 1;
    if($start < 1) {
      $start = 1;
    }
  }


  $pages = range($start, $end);
  // 从哪里开始取数据
  $offset = ($page - 1) * $pageSize;

  $post = query('SELECT posts.id, posts.title, users.nickname, categories.name, posts.created, posts.status FROM posts LEFT JOIN users ON posts.user_id = users.id LEFT JOIN categories ON posts.category_id = categories.id LIMIT ' . $offset . ', ' . $pageSize);

  // print_r($post);

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <!-- 引入导航栏 -->
    <?php include './inc/navbar.php' ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有文章</h1>
        <a href="post-add.php" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline">
          <select name="" class="form-control input-sm">
            <option value="">所有分类</option>
            <option value="">未分类</option>
          </select>
          <select name="" class="form-control input-sm">
            <option value="">所有状态</option>
            <option value="">草稿</option>
            <option value="">已发布</option>
          </select>
          <button class="btn btn-default btn-sm">筛选</button>
        </form>
        <ul class="pagination pagination-sm pull-right">
          <?php if($page > 1) { ?>
          <li><a href="?page=<?php echo $page - 1; ?>">上一页</a></li>
          <?php } ?>
          <?php foreach($pages as $key => $val) { ?>
            <?php if($val == $page) { ?>
            <li class="active"><a href="?page=<?php echo $val; ?>"><?php echo $val; ?></a></li>
            <?php } else { ?>
            <li><a href="?page=<?php echo $val; ?>"><?php echo $val; ?></a></li>  
            <?php } ?>
          <?php } ?>
          <?php if($page < $pageLength) { ?>
          <li><a href="?page=<?php echo $page + 1; ?>">下一页</a></li>
          <?php } ?>
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($post as $k => $v) { ?>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td><?php echo $v['title'] ?></td>
            <td><?php echo $v['nickname'] ?></td>
            <td><?php echo $v['name'] ?></td>
            <td class="text-center"><?php echo $v['created'] ?></td>
            <td class="text-center">
              <?php if($v['status'] == 'drafted') { ?>
                <td class="text-center">草稿</td>
              <?php } else if($v['status'] == 'published') { ?>
                <td class="text-center">已发布</td>
              <?php } else { ?>
                <td class="text-center">回收站</td>
              <?php } ?>
            </td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="?page=<?php echo $page; ?>&action=delete&id=<?php echo $val['id']; ?>" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php 
    $actives = array('post', 'add', 'cate');

    $active = 'post';

  ?>


  <!-- 引入侧边栏  -->
  <?php include './inc/aside.php' ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>