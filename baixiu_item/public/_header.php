<?php
    include_once './static/select.php';
    $sql = "select * from categories where id != 1";
    $arr = select($sql);

?>
<div class="header">
      <h1 class="logo"><a href="index.html"><img src="../static/assets/img/logo.png" alt=""></a></h1>
      <ul class="nav">
            <?php foreach($arr as $key => $value): ?>
        <li><a href="list.php?catagoryId=<?php echo $value['id']; ?>"><i class="fa <?php echo $value['classname']; ?>"></i><?php echo $value['name']; ?></a></li>
          <?php endforeach; ?>
    </ul>
      <div class="search">
        <form>
          <input type="text" class="keys" placeholder="输入关键字">
          <input type="submit" class="btn" value="搜索">
        </form>
      </div>
      <div class="slink">
        <a href="javascript:;">链接01</a> | <a href="javascript:;">链接02</a>
      </div>
</div>    