<?php
/*===========================================
  お気に入りを登録するためのPHP,ajax専用
===========================================*/

include dirname(__FILE__) . "/../assets/_inc/process.php";

header("Content-type: text/plain; charset= UTF-8");

// POSTアクセス時のみ処理
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $dbfavorite = new DBFavorites();

  // user_idをセッションから取得、thread_id はajaxでPOSTで送られる
  $user_id = $_SESSION["user_id"];
  $thread_id = $_POST["thread_id"];
  $status = $_SESSION["status"];
  // もしもログインしていない状態で送られてしまった場合、インデックスにリダイレクト
  if ($status == 0) {
    $_SESSION["error"] = "エラーが発生しました。";
    header("Location: ../index.php");
    exit();
  }

  // DB処理
  try {
    $dbfavorite->dbh->beginTransaction();

    // すでにお気に入りされていないかチェック
    $favorite = $dbfavorite->get_favorites($user_id, $thread_id);

    // されていなければお気に入り登録
    if ($favorite == null) {
      $dbfavorite->post_favorites($user_id, $thread_id);
      // されていれば、お気に入り解除
    } else {
      $dbfavorite->delete_favorites($user_id, $thread_id);
    }

    $dbfavorite->dbh->commit();
  } catch (Exception $e) {
    $dbfavorite->dbh->rollBack();
    echo "失敗しました。" . $e->getMessage();
  }

  exit();
}