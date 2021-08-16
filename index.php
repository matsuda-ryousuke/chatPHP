<?php
/*=============================================
  インデックスページ
  スレッドの一覧を表示
============================================= */

require_once dirname(__FILE__) . "/assets/_inc/require.php";
$dbuser = new DBusers();
$dbthread = new DBthreads();

// セッションのユーザー情報を登録
$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["user_name"];
$status = $_SESSION["status"];

$msg =
  "こんにちは " . htmlspecialchars($user_name, \ENT_QUOTES, "UTF-8") . "さん";

// GETアクセス：全表示
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  try {
    // スレッド総数をカウント
    $count = $dbthread->count_threads();

    // ページネーション処理の準備
    $arr = pagination_start($count, THREAD_MAX);

    var_dump($arr);
    // 全スレッドを取得
    $stmt = $dbthread->get_threads($arr["start"], THREAD_MAX);
  } catch (Exception $e) {
    echo "失敗しました。" . $e->getMessage();
  }
}

include dirname(__FILE__) . "/view/index.php"; ?>
