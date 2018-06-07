

<div class="aside">
    <div class="profile">
      <img class="avatar" src="<?php echo $_SESSION['current_user_avatar']; ?>">
      <h3 class="name"><?php echo $_SESSION['current_user_nickname']; ?></h3>
    </div>
    <ul class="nav">
      <li class="<?php if($active == 'dashboard') { echo 'active'; } ?>">
        <a href="index.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
      <li>
        <a href="#menu-posts" class="collapsed" data-toggle="collapse">
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <!-- 展开 或 折叠 -->
        <ul id="menu-posts" class="collapse <?php if(@in_array($active, $actives)) { echo 'in'; } ?>">
          <li class="<?php if($active == 'post') { echo 'active'; } ?>"><a href="posts.php">所有文章</a></li>
          <li class="<?php if($active == 'add') { echo 'active'; } ?>"><a href="post-add.php">写文章</a></li>
          <li class="<?php if($active == 'cate') { echo 'active'; } ?>"><a href="categories.php">分类目录</a></li>
        </ul>
      </li>
      <li class="<?php if($active == 'comments') { echo 'active'; } ?>">
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <li>
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <li>
        <a href="#menu-settings" class="collapsed" data-toggle="collapse">
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse">
          <li><a href="nav-menus.html">导航菜单</a></li>
          <li><a href="slides.html">图片轮播</a></li>
          <li><a href="settings.html">网站设置</a></li>
        </ul>
      </li>
    </ul>
</div>