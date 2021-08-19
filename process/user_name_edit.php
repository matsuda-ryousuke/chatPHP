<?php

include dirname(__FILE__) . "/../assets/_inc/process.php";

$dbuser = new DBUsers();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // セッションから、ユーザー情報を取得
  $user_id = $_SESSION["user_id"];
  $status = $_SESSION["status"];

  // user_name がPOSTされていない もしくは ログインをしていない場合、エラー
  if (empty($_POST["user_name"]) || $status == 0) {
    $_SESSION["error"] = "エラーが発生しました。";
    header("Location: ../index.php");
    exit();
  }

  // POSTアクセス時、ユーザー名を変更
  $user_name = htmlspecialchars($_POST["user_name"], ENT_QUOTES, "UTF-8");

  // DB処理
  try {
    $dbuser->dbh->beginTransaction();

    // threadsテーブルにデータを登録
    $dbuser->edit_user_name($user_name, $user_id);

    $dbuser->dbh->commit();
  } catch (Exception $e) {
    $dbuser->dbh->rollBack();
    echo "失敗しました。" . $e->getMessage();
  }

  $_SESSION["success"] = "ユーザー名の変更が完了しました。";
  // セッションのユーザー名を登録
  $_SESSION["user_name"] = $user_name;
  header("Location: ../user_config.php");
}
