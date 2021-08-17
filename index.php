<?php
/*=============================================
  index.php
  スレッドの一覧を表示するインデックスページ
============================================= */

require_once dirname(__FILE__) . "/assets/_inc/require.php";

// DB接続の準備
$dbuser = new DBusers();
$dbthread = new DBthreads();

// セッションのユーザー情報を登録
$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["user_name"];
$status = $_SESSION["status"];

// 表示メッセージを登録
$msg =
  "こんにちは " . htmlspecialchars($user_name, \ENT_QUOTES, "UTF-8") . "さん";

// DB処理
try {
  // トランザクション開始
  $dbthread->dbh->beginTransaction();

  // スレッドの総数をカウント（ページネーション用）
  $count = $dbthread->count_threads();

  // ページネーション処理の準備
  $arr = pagination_start($count, THREAD_MAX);

  // 全スレッドを取得
  $stmt = $dbthread->get_threads($arr["start"], THREAD_MAX);

  $dbthread->dbh->commit();
} catch (Exception $e) {
  $dbthread->dbh->rollback();
  echo "失敗しました。" . $e->getMessage();
}

// view読み込み
include dirname(__FILE__) . "/view/index.php"; ?>
