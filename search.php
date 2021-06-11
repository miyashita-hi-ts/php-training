<link href="custom.scss" rel="stylesheet">

<?php
include('./header.php');
include('./config.php');

// 変数の初期化
$current_date = null;
$message = array();
$message_array = array();
$success_message = null;
$error_message = array();
$pdo = null;
$stmt = null;
$res = null;
$option = null;

session_start();

// データベースに接続
try {
    $option = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => false
    );
    $pdo = new PDO('mysql:charset=UTF8;dbname='.DB_NAME.';host='.DB_HOST , DB_USER, DB_PASS, $option);

} catch(PDOException $e) {

    // 接続エラーのときエラー内容を取得する
    $error_message[] = $e->getMessage();
}

if( !empty($_GET['search_submit_name']) ) {
    try {
        $stmt = $pdo->prepare("SELECT view_name,message,post_date FROM message WHERE view_name LIKE ? ESCAPE '!' ORDER BY post_date DESC");
        $stmt->bindValue(1, '%' . $_GET["search_name"] . '%', PDO::PARAM_STR);
        $stmt->execute();
    } catch(Exception $e) {
        // エラーが発生した時はロールバック
        $pdo->rollBack();
    }
}

if( !empty($_GET['search_submit_message']) ) {
    try {
        $stmt = $pdo->prepare("SELECT view_name,message,post_date FROM message WHERE message LIKE ? ESCAPE '!' ORDER BY post_date DESC");
        $stmt->bindValue(1, '%' . $_GET["search_message"] . '%', PDO::PARAM_STR);
        $stmt->execute();
    } catch(Exception $e) {
        // エラーが発生した時はロールバック
        $pdo->rollBack();
    }
}



// データベースの接続を閉じる
$pdo = null;
?>

<body>
<h1>ひと言掲示板</h1>
<?php if( empty($_POST['btn_submit']) && !empty($_SESSION['success_message']) ): ?>
    <p class="success_message"><?php echo htmlspecialchars( $_SESSION['success_message'], ENT_QUOTES, 'UTF-8'); ?></p>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>
<?php if (!empty($error_message)): ?>
	<ul class="error_message">
		<?php foreach ($error_message as $value): ?>
			<li>・<?php echo $value; ?></li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

<!-- 検索フォーム -->
    <form id ="search" method="get" action="./search.php" class="search_container">
        <input type="text" name="search_name" placeholder="表示名検索">
        <!-- 送信ボタンを用意する -->
        <input type="submit" name="search_submit_name" value="&#xf002">
    </form>

    <form id ="search" method="get" action="./search.php" class="search_container">
        <input type="text" name="search_message" placeholder="メッセージ検索">
        <!-- 送信ボタンを用意する -->
        <input type="submit" name="search_submit_message" value="&#xf002">
    </form>

<section>
<?php if (!empty($stmt)) { ?>
<?php foreach ($stmt as $value) { ?>
    <article>
        <div class="info">
            <h2><?php echo htmlspecialchars($value['view_name'], ENT_QUOTES, 'UTF-8'); ?></h2>
            <time><?php echo date('Y年m月d日 H:i', strtotime($value['post_date'])); ?></time>
        </div>
        <p><?php echo nl2br(htmlspecialchars($value['message'], ENT_QUOTES, 'UTF-8')); ?></p>
    </article>
<?php
    } ?>
<?php
} ?>
</section>

</body>

<?php include('./footer.php'); ?>