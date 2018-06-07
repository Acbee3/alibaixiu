<?php

  include '../functions.php';

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <style>
    .first, .last {
        display: none!important;
    }
  </style>
</head>
<body>

  <div class="main">
    <!-- 引入公共头 -->
    <?php include './inc/navbar.php'; ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-info btn-sm">批量批准</button>
          <button class="btn btn-warning btn-sm">批量拒绝</button>
          <button class="btn btn-danger btn-sm">批量删除</button>
        </div>
        <div id="pagination" style="height: 40px;" class="pull-right">

        </div>  
        <!-- <ul class="pagination pagination-sm pull-right">
          <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li>
        </ul> -->
      </div>
      <table class="table table-striped table-bordered table-hover">
        
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
         <!-- 这里将来添加进来 模板引擎生成的html -->
        </tbody>
      </table>
    </div>
  </div>

  <?php $active = 'comments'; ?>
  <!-- 公共的侧边栏 -->
  <?php include './inc/aside.php'; ?>

  <script type="text/template" id='tpl'>
    {{each data val}}
      <tr>
        <td class="text-center">
          <input type="checkbox">
        </td>
        <td>{{val.author}}</td>
        <td>{{val.content}}</td>
        <td>{{val.title}}</td>
        <td>{{val.created}}</td>
        {{if (val.status == 'held')}}
        <td>待审核</td>
        {{else if (val.status == 'approved')}}
        <td>准许</td>
        {{else if (val.status == 'rejected')}}
        <td>拒绝</td>
        {{else}}
        <td>回收站</td>
        {{/if}}
        <td class="text-center">
          <a href="post-add.html" class="btn btn-warning btn-xs">驳回</a>
          <a href="javascript:;" data-id="{{val.id}}" class="btn btn-danger btn-xs delete">删除</a>
        </td>
      </tr>
    {{/each}}
  </script>

  <!-- <script src="../assets/vendors/jquery/jquery.js"></script> -->
  <!-- <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script> -->
  <script src="../libs/require.min.js"></script>
  <script>

    require.config({
      baseUrl: '../',

      paths: {
        jquery: 'assets/vendors/jquery/jquery.min',
        template: 'assets/vendors/art-template/template-web',
        twbsPagination: 'assets/vendors/twbs-pagination/jquery.twbsPagination.min',
        nprogress: 'assets/vendors/nprogress/nprogress',
        moment: 'assets/vendors/moment/moment'
      },
      // require.js 支持非标准模块的加载
      // 但是需要进行一些特殊的配置才可以
      shim: {
          twbsPagination: {
              // 指定非标准模块依赖的其它模块
              deps: ['jquery'],
              // 将非标准模块内容的功能开发出去
          }
      }
    });
   
    
    
    require(['libs/comments']);
  </script>
</body>
</html>
