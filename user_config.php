<?php
/*=============================================
  user_config.php
  ユーザー設定表示ページ
============================================= */

include dirname(__FILE__) . "/assets/_inc/require.php";

// DB接続の準備
$dbuser = new DBUsers();
$dbthread = new DBThreads();
$dbfavorite = new DBFavorites();

// セッションのユーザー情報を登録
$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["user_name"];

// DB処理
try {
  $dbfavorite->dbh->beginTransaction();

  // ログインユーザーのお気に入りの総数を取得
  $favorite_count = $dbfavorite->count_favorites($user_id);

  // ページネーション処理の準備
  $arr = pagination_start($favorite_count, FAVORITE_MAX);

  // ログインユーザーのお気に入りスレッドを取得
  $stmt = $dbfavorite->get_favorites_of_user(
    $user_id,
    $arr["start"],
    FAVORITE_MAX
  );

  $dbfavorite->dbh->commit();
} catch (Exception $e) {
  $dbfavorite->dbh->rollBack();
  echo "失敗しました。" . $e->getMessage();
}

// view読み込み
include dirname(__FILE__) . "/view/user_config.php"; ?>
