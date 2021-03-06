<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
  <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <!-- <nav class="navbar">
      <button class="btn btn-default navbar-btn fa fa-bars"></button>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.html"><i class="fa fa-user"></i>个人中心</a></li>
        <li><a href="login.html"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav> -->
    <?php require_once './public/_navbar.php' ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form id="data-form" class="row">
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
            <input id="feature" class="form-control" name="feature" type="file">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category">
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
            <input id="btn-save" class="btn btn-primary" type="button" value="保存">
            <!-- <button class="btn btn-primary" type="submit">保存</button> -->
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- <div class="aside">
    <div class="profile">
      <img class="avatar" src="../static/uploads/avatar.jpg">
      <h3 class="name">布头儿</h3>
    </div>
    <ul class="nav">
      <li>
        <a href="index.html"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
      <li class="active">
        <a href="#menu-posts" data-toggle="collapse">
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-posts" class="collapse in">
          <li><a href="posts.html">所有文章</a></li>
          <li class="active"><a href="post-add.html">写文章</a></li>
          <li><a href="categories.html">分类目录</a></li>
        </ul>
      </li>
      <li>
        <a href="comments.html"><i class="fa fa-comments"></i>评论</a>
      </li>
      <li>
        <a href="users.html"><i class="fa fa-users"></i>用户</a>
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
  </div> -->
  <?php $current_page = 'post-add' ?>
  <?php require_once './public/_aside.php' ?>
  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <script src="../static/assets/vendors/ckeditor/ckeditor.js"></script>
  <script>
    $(function () {
      // 实现文件的上传功能
      $('#feature').on('change', function () {
        // 文件上传，获取到上传的文件
        // console.dir(this);
        // this下的files[0]就是我们所需要的图片
        var file = this.files[0];
        var data = new FormData();
        data.append("file", file);

        $.ajax({
          type: "post",
          url: "api/_uploadFile.php",
          data: data,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (res) {
            // console.log(res);
            if (res.code == 1) {
              $('.help-block').attr('src', res.src).show();
            }
          }
        });
      })

      // 富文本有格式的文本，运用插件CKEDITOR4
      // 1.使用富文本的步骤
      // 引入插件
      // 准备一个文本域，该文本域需要有id
      // 调用插件提供的方法，初始化，富文本编辑器
      // CKEDITOR.replace(对应文本域的id)

      // 富文本编辑器初始化的方法
      CKEDITOR.replace('content');

      // 给保存按钮注册点击事件
      $('#btn-save').on('click', function () {
        // 在收集数据之前，得把富文本编辑器的内容更新到我们的文本域中
        // 如果要把编辑器中的内容，更新到对应的文本域里面
        // 需要调用插件提供的一个方法：编辑器对象.updateElement()
        // 获取编辑器对象：CKEDITOR.instances.初始化的时候所使用的id
        // console.log(CKEDITOR.instances);
        CKEDITOR.instances.content.updateElement();
        
        // 点击保存按钮，收集表单数据，发送回服务器
        var data = $('#data-form').serialize();
        // console.log(data);
        $.ajax({
          type: "post",
          url: "api/_addPost.php",
          data: data,
          dataType: "json",
          success: function (response) {
            
          }
        });
      });
      
    });
  </script>
</body>
</html>
