<?php

  include '../functions.php';

  checkLogin();
  $btnText = '';
  // 通过 categories.php 处理 分类的增删改查操作

    // 1. 当没有 action 参数时（任何情况下都需要），查询列表
  $sql = 'SELECT * FROM categories';

  $categories = query($sql);

  // 获取 action 的值，然后根据它的值来区分相应的操作
  $action = isset($_GET['action']) ? $_GET['action'] : 'add';
  // 2. 当 action 参数值为 add 时，添加

  if($action == 'add') {

    // print_r($_GET);
    $btnText = '添 加';
    unset($_GET['action']);

    $res = insert('categories', $_GET);

    if($res) {
      header('Location: ./categories.php');
    }

  } 

  // 3. 当 action 参数值为 update 时，修改

  if($action == 'update') {
    // print_r($_GET);
    unset($_GET['action']);

    $res = update('categories', $_GET);

    if($res) {
      header('Location: ./categories.php');
    }
    
  }

  // 4. 当 action 参数值为 edit 时，查询旧的内容
  if($action == 'edit') {

    $action = 'update';

    $btnText = '修 改';

    $sql = 'SELECT * FROM categories WHERE id=' . $_GET['id'];
    // 将旧的数据通过表单展示，用户可以再次修改
    $category = query($sql);

    // print_r($category);
  }

  // 5. 当 action 参数值为 delete 时，删除
  if($action == 'delete') {
    // 批量删除
    if(isset($_GET['ids'])) {
      $sql = 'DELETE FROM categories WHERE id IN (' . $_GET['ids'] .')';
    }
    // 单个删除
    if(isset($_GET['id'])) {
      $id = $_GET['id'];
      $sql = 'DELETE FROM categories WHERE id=' . $id;
    }
    

    // 执行删除
    $res = delete($sql);

    if($res) {
        // 删除成功，回到列表页
        header('Location: ./categories.php');
    }
  }
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <!-- 引入公共头 -->
    <?php include './inc/navbar.php'; ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <form action="./categories.php" method="GET">
          <input type="hidden" name="action" value="<?php echo $action; ?>">
          <input type="hidden" name="id" value="<?php echo @$category[0]['id'] ?>">
            <h2>添加新分类目录</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" value="<?php echo @$category[0]['name'] ?>" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" value="<?php echo @$category[0]['slug'] ?>" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit"><?php echo $btnText ?></button>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" id="all" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($categories as $key => $val) { ?>
              <tr>
                <td class="text-center">
                  <input type="checkbox" value="<?php echo $val['id']; ?>">
                </td>
                <td><?php echo $val['name']; ?></td>
                <td><?php echo $val['slug']; ?></td>
                <td class="text-center">
                  <a href="?action=edit&id=<?php echo $val['id']; ?>" class="btn btn-info btn-xs">编辑</a>
                  <a href="?action=delet&id=<?php echo $val['id']; ?>" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php 
    $actives = array('post', 'add', 'cate');

    $active = 'cate';

  ?>
  <!-- 公共的侧边栏 -->
  <?php include './inc/aside.php'; ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>
  
    NProgress.done()

    var ids = [];
                
    $('table').on('click', 'input', function() {
      var size = $(this).parents('tr').siblings().find('input:checked').size();

      var id = $(this).val();

      // 去除重复
      for(var i = 0;i < ids.length; i++) {
        if(ids[i] == id) {
          ids.splice(i, 1);
          break;
        }
      };

      if($(this).is(':checked')) {
        size += 1;
        // 存入选中的 id
        ids.push($(this).val());
      };
      console.log(ids);
      

      $('#all').attr('href', '?action=delete&ids=' + ids.join(','));

      $('#all').toggle(size != 0);

      // console.log(size);
      // if(size > 0) {
      //     $('#all').show();
      // } else {
      //     $('#all').hide();
      // }
    })
  </script>
</body>
</html>
