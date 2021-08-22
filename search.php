<?php
/*=============================================
  search.php
  検索結果の表示ページ
============================================= */

require_once $_SERVER["DOCUMENT_ROOT"] . "/chatPHP/assets/_inc/require.php";

// DB接続の準備
$dbuser = new DBUsers();
$dbthread = new DBThreads();

// セッションのユーザー情報を登録
$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["user_name"];
$status = $_SESSION["status"];

// 表示メッセージを登録
$msg =
  "こんにちは " . htmlspecialchars($user_name, \ENT_QUOTES, "UTF-8") . "さん";

// 検索欄を入力せずに検索した場合、index.php(全スレッド表示)
if ($_GET["search"] == null) {
  header("Location: ./index.php");
}

// 検索欄の入力値を取得
$search = (string) htmlspecialchars($_GET["search"], ENT_QUOTES, "UTF-8");

if (mb_strlen($search) > THREAD_TITLE_LENGTH) {
  $_SESSION["error"] = "不正な入力値です。";
  $uri = $_SERVER["HTTP_REFERER"];
  header("Location: " . $uri);
  exit();
}

// DB接続
try {
  // トランザクション開始
  $dbthread->dbh->beginTransaction();

  // 検索スレッド数をカウント（ページネーション用）
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

// 検索結果が0件ならば、エラー文とともにindex.phpにリダイレクト
if ($count == 0) {
  $_SESSION["error"] = $search . " を含むスレッドは見つかりませんでした";
  header("Location: ./index.php");
}

// view読み込み
include dirname(__FILE__) . "/view/index.php"; ?>