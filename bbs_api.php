<?php
include('./config.php');
$view_name = $_POST['view_name'];
$message = $_POST['message'];
$current_date = date("Y-m-d H:i:s");
$option = null;

try {
    $pdo = new PDO('mysql:charset=UTF8;dbname='.DB_NAME.';host='.DB_HOST, DB_USER, DB_PASS, array(PDO::ATTR_EMULATE_PREPARES => false));
} catch (PDOException $e) {
    var_dump($e->getMessage());
    exit;
}
$stmt = $pdo->prepare("INSERT INTO message (view_name, message, post_date) VALUES ( :view_name, :message, :current_date)");
// 値をセット
$stmt->bindParam(':view_name', $view_name, PDO::PARAM_STR);
$stmt->bindParam(':message', $message, PDO::PARAM_STR);
$stmt->bindParam(':current_date', $current_date, PDO::PARAM_STR);
// SQLクエリの実行

$res = $stmt->execute();

$current_date = date("Y年m月d日 H:i");
$result = array('view_name' => $view_name, 'message' => $message, 'current_date' => $current_date);
header('Content-type: application/json');
echo(json_encode($result));
exit;
