<?php
/*=============================================
  スレッドの内容表示ページ
  コメントの表示や、コメント入力フォームを表示
============================================= */

include dirname(__FILE__) . "/assets/_inc/require.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (isset($_GET["id"])) {
    // thread_id 取得
    $thread_id = htmlspecialchars($_GET["id"]);
    $_SESSION["thread_id"] = $thread_id;
  } else {
    $_SESSION["error"] = "エラーが発生しました。";
    header("Location: ./index.php");
  }
  $dbuser = new DBUsers();
  $dbthread = new DBThreads();
  $dbcomment = new DBComments();
  $dbfavorite = new DBFavorites();

  $user_id = $_SESSION["user_id"];

  try {
    // トランザクション開始
    $dbthread->dbh->beginTransaction();

    $thread = $dbthread->get_thread_by_id($thread_id);
    // ページネーション処理の準備

    // comment件数
    $comment_count = $thread["comment_count"];
    $title = $thread["title"];
    $user_name = $dbuser->get_username_by_id($thread["user_id"]);

    $arr = pagination_start($comment_count, COMMENT_MAX);

    // スレッドのコメントを取得
    $stmt = $dbcomment->get_comments_of_thread(
      $thread_id,
      $arr["start"],
      COMMENT_MAX
    );

    // すでにお気に入りされていないかチェック
    $favorite = $dbfavorite->get_favorites($user_id, $thread_id);

    // されていなければお気に入り登録
    if ($favorite != null) {
      $favorite_flag = true;
    }

    $dbthread->dbh->commit();
  } catch (Exception $e) {
    $dbthread->dbh->rollBack();
    echo "失敗しました。" . $e->getMessage();
  }

  $status = $_SESSION["status"];
}
include dirname(__FILE__) . "/view/thread_content.php";
?>
