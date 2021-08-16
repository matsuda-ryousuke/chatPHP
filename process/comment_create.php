<?php
/*=============================================
  コメント登録処理用のページ
  処理が終わればリダイレクト
============================================= */

include dirname(__FILE__) . "/../assets/_inc/process.php";

if ($_POST["comment"]) {
  // POSTでコメントが送られている：コメント登録

  $dbthread = new DBThreads();
  $dbcomment = new DBComments();

  $comment = htmlspecialchars($_POST["comment"]);
  $thread_id = $_SESSION["thread_id"];

  // セッションから、ユーザー情報を取得
  $user_id = $_SESSION["user_id"];
  $status = $_SESSION["status"];

  // user_name がPOSTされている かつ ログインユーザーならばその値、なければゲスト
  if (isset($_POST["user_name"]) && $status == 1) {
    $user_name = htmlspecialchars($_POST["user_name"]);
  } else {
    $user_name = "ゲスト";
  }

  // DB処理
  try {
    $dbthread->dbh->beginTransaction();

    // スレッドのコメント数を取得し、+1 の値を新規コメントのIDとする
    $comment_id = $dbthread->get_count_comment($thread_id) + 1;
    var_dump($comment_id);

    // commentsテーブルにデータを登録
    $dbcomment->post_comment(
      $comment_id,
      $thread_id,
      $user_id,
      $user_name,
      $comment
    );

    // スレッドのコメント数を更新
    $dbthread->update_count_comment($comment_id, $thread_id);

    $dbthread->dbh->commit();
  } catch (Exception $e) {
    $dbthread->dbh->rollBack();
    echo "失敗しました。" . $e->getMessage();
  }

  $_SESSION["success"] = "コメントの投稿が完了しました。";

  $uri = $_SERVER["HTTP_REFERER"];
  header("Location: " . $uri);
} else {
  $_SESSION["error"] = "エラーが発生しました。";
  header("Location: ../index.php");
}
