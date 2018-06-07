<?php
  include '../functions.php';


  checkLogin();

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $res = insert('posts', $_POST);
    
    print_r($_POST);
    if($res) {
      header('Location: ./posts.php');

      die();
    }
  }
  
  ?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="../assets/vendors/simplemde/simplemde.min.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <!-- 引入导航栏 -->
    <?php include './inc/navbar.php' ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="row" action="./post-add.php" method="POST">
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">内容</label>
            <textarea id="content" class="form-control input-lg" name="content" cols="30" rows="10" placeholder="内容"></textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            <p class="help-block">https://zce.me/post/<strong>slug</strong></p>
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <img class="help-block thumbnail" style="display: none">
            <!-- 传递一个文件路径 -->
            <input type="hidden" name="feature" class="feature">
            <input id="feature" class="form-control" type="file">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category_id">
              <option value="1">未分类</option>
              <option value="2">潮生活</option>
            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="datetime-local">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted">草稿</option>
              <option value="published">已发布</option>
            </select>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit">保存</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php 
    $actives = array('post', 'add', 'cate');

    $active = 'add';

  ?>
  <!-- 引入公共的头 -->
  <?php include './inc/aside.php'; ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <!-- 富文本编辑器 -->
  <script src="../assets/vendors/simplemde/simplemde.min.js"></script>
  <script>
    NProgress.done();
    // 创建一个富文本编辑器
    var simplemde = new SimpleMDE({
            // 传入一个 DOM，富文本编辑器
            // 将会被创建在这个位置
            element: document.getElementById("content"),
            // 配置插入图片方式
            insertTexts: {
                image: ['<img src="', '">'],
            }
        });

    var input = document.querySelector('#feature');
    var thumbnail = document.querySelector('.thumbnail');
    var feature = document.querySelector('.feature');

    input.addEventListener('change', function () {
      console.log(this.files);
      
      var data = new FormData();
      data.append('feature', this.files[0]);

      var xhr = new XMLHttpRequest();
      xhr.open('post', './uploader.php');
      xhr.send(data);

      xhr.addEventListener('load', function() {
        thumbnail.src = this.responseText;
        thumbnail.style.display = 'block';

        feature.value = this.responseText;

      });
    });
    
  </script>
</body>
</html>
