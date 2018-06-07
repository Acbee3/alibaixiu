<?php
// login 既可以用 get 也可以用 post
// 当为 get 时 用来展示 html 页面
// 当为 post 时 用来处理用户填写的表单数据
  $message = '';
  // print_r($_SERVER);

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // 是否填写信息
    if(empty($_POST['email']) || empty($_POST['password'])) {
      
      $message = '用户名或密码不能为空';
      // print_r($_POST);

    } else {

      $connect = mysqli_connect('127.0.0.1', 'root', 'root');
      mysqli_select_db($connect, 'baixiu');
      // 先看有没有用户名
      // 有用户名再去看密码
      // 都一致则登入成功 否则登入失败
      $sql = 'SELECT * FROM users WHERE email="' . $_POST['email'] . '"';
      $res = mysqli_query($connect, $sql);

      $users = mysqli_fetch_assoc($res);
      if($users) {
        // print_r($users);
        if($users['password'] == $_POST['password']) {
          // 记录下登录的状态
          session_start();
          $_SESSION['is_login'] = true;
          $_SESSION['current_user_id'] = $users['id'];

          $_SESSION['current_user_nickname'] = $users['nickname'];
          $_SESSION['current_user_avatar'] = $users['avatar'];
          header('Location: ./index.php');
        } else {
          // 为了防止别有用心的人找到 薄弱之处
          // echo '用户名或密码错误';
          $message = '用户名或密码错误';
        }
      } else {
        // echo '用户名或密码错误';
        $message = '用户名或密码错误';
      }
    }
  }

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <div class="login">
    <form class="login-wrap" method="POST" action="./login.php">
      <img class="avatar" src="../assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <?php if($message != '') { ?>
      <div class="alert alert-danger">
        <strong>错误！</strong> <?php echo $message ?>
      </div>
      <?php } ?>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" type="email" name="email" class="form-control" placeholder="邮箱" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" type="password" name="password" class="form-control" placeholder="密码">
      </div>
      <input class="btn btn-primary btn-block" type="submit" value="登 录">
    </form>
  </div>
</body>
</html>
