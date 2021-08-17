<?php
/*=============================================
  スレッド作成ページ
============================================= */

include dirname(__FILE__) . "/../assets/_inc/process.php";

$dbthread = new DBThreads();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // POSTアクセス時、スレッド作成
  $title = htmlspecialchars($_POST["title"], ENT_QUOTES, "UTF-8");
  $comment = htmlspecialchars($_POST["comment"], ENT_QUOTES, "UTF-8");

  // セッションから、ユーザー情報を取得
  $user_id = $_SESSION["user_id"];

  // user_name がPOSTされている かつ ログインユーザーならばその値、なければゲスト
  if (isset($_POST["user_name"]) && $status == 1) {
    $user_name = htmlspecialchars($_POST["user_name"], ENT_QUOTES, "UTF-8");
  } else {
    $user_name = "ゲスト";
  }

  // DB処理
  try {
    $dbthread->dbh->beginTransaction();

    // threadsテーブルにデータを登録
    $dbthread->create_thread($title, $user_id, $user_name);

    $dbthread->dbh->commit();
  } catch (Exception $e) {
    $dbthread->dbh->rollBack();
    echo "失敗しました。" . $e->getMessage();
  }

  $_SESSION["success"] = "スレッドの作成が完了しました。";
  header("Location: ../index.php");
}
