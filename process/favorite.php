<?php
/*===========================================
  お気に入りを登録するためのPHP,ajax専用
===========================================*/

include dirname(__FILE__) . "/../assets/_inc/process.php";

// POSTアクセス時のみ処理
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $dbfavorite = new DBFavorites();

  // user_id, thread_idをセッションから取得
  $user_id = $_SESSION["user_id"];
  $thread_id = $_SESSION["thread_id"];

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
