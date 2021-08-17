<?php
/*=============================================
  thread_content.php
  スレッドの内容ページ
  コメント一覧や、コメント入力フォームを表示
============================================= */

include dirname(__FILE__) . "/assets/_inc/require.php";

$dbuser = new DBUsers();
$dbthread = new DBThreads();
$dbcomment = new DBComments();
$dbfavorite = new DBFavorites();

$user_id = $_SESSION["user_id"];

try {
  // トランザクション開始
  $dbthread->dbh->beginTransaction();

  // スレッドの総数を取得
  $thread_count = $dbthread->count_threads();

  // thread_id が取得できなければ、index.phpにリダイレクト
  if (!isset($_GET["id"])) {
    $_SESSION["error"] = "エラーが発生しました。";
    header("Location: ./index.php");
  } else {
    $thread_id = (int) htmlspecialchars($_GET["id"], ENT_QUOTES, "UTF-8");
    // thread_id が不正な値だった場合も同様
    if ($thread_id < 1 || $thread_id > $thread_count) {
      $_SESSION["error"] = "エラーが発生しました。";
      header("Location: ./index.php");
    }

    // 適正であれば、thread_idを SESSIONに登録
    $_SESSION["thread_id"] = $thread_id;
  }

  // thread_id からスレッド本体を取得
  $thread = $dbthread->get_thread_by_id($thread_id);

  // スレッド本体から、各データを取得
  $comment_count = $thread["comment_count"];
  $title = $thread["title"];
  $user_name = $dbuser->get_username_by_id($thread["user_id"]);

  // ページネーション処理の準備
  $arr = pagination_start($comment_count, COMMENT_MAX);

  // スレッドのコメントを取得、ページネーション対応
  $stmt = $dbcomment->get_comments_of_thread(
    $thread_id,
    $arr["start"],
    COMMENT_MAX
  );

  // スレッドがすでにお気に入りされていないかチェック
  $favorite = $dbfavorite->get_favorites($user_id, $thread_id);

  // お気に入りされていれば、フラグをたてる（お気に入りボタンをactive にする用）
  if ($favorite != null) {
    $favorite_flag = true;
  }

  $dbthread->dbh->commit();
} catch (Exception $e) {
  $dbthread->dbh->rollBack();
  echo "失敗しました。" . $e->getMessage();
}

$status = $_SESSION["status"];

// view読み込み
include dirname(__FILE__) . "/view/thread_content.php";
