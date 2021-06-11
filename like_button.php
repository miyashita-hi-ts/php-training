<?php

// データベースの接続情報
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'board');

// 変数の初期化
$sql = null;
$pdo = null;
$option = null;
$stmt = null;

session_start();

if (isset($_POST['messageId'])) {
    // データベースに接続
    try {
        $option = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_MULTI_STATEMENTS => false
        );
        $pdo = new PDO('mysql:charset=UTF8;dbname='.DB_NAME.';host='.DB_HOST, DB_USER, DB_PASS, $option);

        if ($_POST['isActive']) {
            $stmt = $pdo->prepare("UPDATE message SET like_count = like_count-1 WHERE id = :id");
        } else {
            $stmt = $pdo->prepare("UPDATE message SET like_count = like_count+1 WHERE id = :id");
        }
        $stmt->bindValue( ':id', $_POST['messageId'], PDO::PARAM_INT);

        // SQLクエリの実行
        $stmt->execute();

        $stmt = $pdo->prepare("SELECT like_count FROM message WHERE id = :id");
        $stmt->bindValue( ':id', $_POST['messageId'], PDO::PARAM_INT);
        $stmt->execute();
        $like_count = $stmt->fetch();

        $_SESSION['like_list'][$_POST['messageId']] = $like_count;

        // データベースの接続を閉じる
        $stmt = null;
        $pdo = null;
    } catch (PDOException $e) {
        exit;
        // 管理者ページへリダイレクト
        header("Location: ./index.php");
        exit;
    }
}

?>
