<?php
/*=============================================
  コメント登録処理用のページ
  処理が終わればリダイレクト
============================================= */

require_once $_SERVER["DOCUMENT_ROOT"] . "/chatPHP/assets/_inc/process.php";

if ($_POST["comment"]) {
  // POSTでコメントが送られている：コメント登録

  $dbthread = new DBThreads();
  $dbcomment = new DBComments();

  $comment = htmlspecialchars($_POST["comment"], ENT_QUOTES, "UTF-8");
  $thread_id = $_SESSION["thread_id"];

  // csrf対策
  check_token();

  // comment がPOSTされていない場合、もしくはタイトルの入力文字数が制限を超える場合、エラー
  if (empty($comment)) {
    $_SESSION["error"] = "エラーが発生しました。";
    $uri = $_SERVER["HTTP_REFERER"];
    header("Location: " . $uri);
    exit();
  } elseif (mb_strlen($comment) > COMMENT_LENGTH) {
    $_SESSION["error"] = "不正な入力値です。";
    $uri = $_SERVER["HTTP_REFERER"];
    header("Location: " . $uri);
    exit();
  }

  // セッションから、ユーザー情報を取得
  $user_id = $_SESSION["user_id"];
  $status = $_SESSION["status"];

  // user_name がPOSTされている かつ ログインユーザーならばその値、なければゲスト
  if (isset($_POST["user_name"]) && $status == 1) {
    $user_name = htmlspecialchars($_POST["user_name"], ENT_QUOTES, "UTF-8");
  } else {
    $user_name = "ゲスト";
  }

  // DB処理
  try {
    $dbthread->dbh->beginTransaction();

    // スレッドのコメント数を取得し、+1 の値を新規コメントのIDとする
    $comment_id = $dbthread->get_count_comment($thread_id) + 1;

    // スレッドのコメント数が1000件を越えていれば、書き込みを禁止
    if ($comment_id > 1000) {
      $_SESSION["error"] = "このスレッドは書き込み1000件を越えています";
      $uri = $_SERVER["HTTP_REFERER"];
      header("Location: " . $uri);
      die();
    }

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