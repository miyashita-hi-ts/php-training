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
$stmt2 = null;

session_start();

if (isset($_POST['messageId'])) {
    $is_active =  json_decode($_POST['isActive']); // 良いねしてるかどうか
    // データベースに接続
    try {
        $option = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_MULTI_STATEMENTS => false
        );
        $pdo = new PDO('mysql:charset=UTF8;dbname='.DB_NAME.';host='.DB_HOST, DB_USER, DB_PASS, $option);

        // 良いね数の更新
        if ($is_active) {
            $stmt = $pdo->prepare("UPDATE message SET like_count = like_count+1 WHERE id = :id");
        } else {
            $stmt = $pdo->prepare("UPDATE message SET like_count = like_count-1 WHERE id = :id");
        }
        $stmt->bindValue( ':id', $_POST['messageId'], PDO::PARAM_INT);

        // SQLクエリの実行
        $stmt->execute();

        // 良いね数の取得
        $stmt2 = $pdo->prepare("SELECT like_count FROM message WHERE id = :id");
        $stmt2->bindValue( ':id', $_POST['messageId'], PDO::PARAM_INT);
        $stmt2->execute();
        $like_count = $stmt2->fetch();

        // データベースの接続を閉じる
        $stmt = null;
        $pdo = null;

        var_dump($like_count["like_count"]);

    } catch (PDOException $e) {
        exit;
        // 管理者ページへリダイレクト
        header("Location: ./index.php");
        exit;
    }
}

?>
