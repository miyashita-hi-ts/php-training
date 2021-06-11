<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>

<script type="text/javascript" src="./javascripts/bbs.js"></script>

<link href="./styles/main.scss" rel="stylesheet">
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<body>



<div class="color-mode" style="display: inline-block; float: right">
    <input id="color-mode" name="dark"  type="checkbox">
    <label for="color-mode"></label>
</div>


<?php if($_SERVER['REQUEST_URI'] === '/' || $_SERVER['REQUEST_URI'] === '/admin.php' || strpos($_SERVER['REQUEST_URI'],'search') === 1): ?>

<form id ="search" method="get" action="./search.php" class="search_container" style="display: inline-block; float: right">
    <input type="text" name="search_name" placeholder="表示名検索">
    <!-- 送信ボタンを用意する -->
    <input type="submit" name="search_submit_name" value="&#xf002">
</form>
<form id ="search" method="get" action="./search.php" class="search_container" style="display: inline-block; float: right">
        <input type="text" name="search_message" placeholder="メッセージ検索">
        <!-- 送信ボタンを用意する -->
        <input type="submit" name="search_submit_message" value="&#xf002">
    </form>
  <?php endif; ?>


<h1 style="font-size: 70px; float: left; display: contents; font-family: serif"><a href="/">ひと言掲示板!</a></h1>
