<?php
/*=============================================
  検索結果の表示ページ
============================================= */

include dirname(__FILE__) . "/assets/_inc/require.php";
$dbuser = new DBUsers();
$dbthread = new DBThreads();

// セッションのユーザー情報を登録
$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["user_name"];
$status = $_SESSION["status"];

$msg =
  "こんにちは " . htmlspecialchars($user_name, \ENT_QUOTES, "UTF-8") . "さん";

// GETアクセス：全表示
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  // 検索欄を入力せずに検索した場合、GETアクセス
  if ($_GET["search"] == null) {
    header("Location: ./index.php");
  }

  $search = (string) htmlspecialchars($_GET["search"]);

  // DB接続

  try {
    $dbthread->dbh->beginTransaction();

    // 検索スレッド数をカウント
    $count = $dbthread->count_threads_search($search);
    // ページネーション処理の準備
    $arr = pagination_start($count, THREAD_MAX);

    // 検索結果の全スレッドを取得
    $stmt = $dbthread->get_threads_search($search, $arr["start"], THREAD_MAX);

    $dbthread->dbh->commit();
  } catch (Exception $e) {
    $dbthread->dbh->rollBack();
    echo "失敗しました。" . $e->getMessage();
  }
  if ($count == 0) {
    $_SESSION["error"] = $search . " を含むスレッドは見つかりませんでした";
    header("Location: ./index.php");
  }
}
include dirname(__FILE__) . "/view/search.php"; ?>
