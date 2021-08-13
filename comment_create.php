<?php include dirname(__FILE__) . "/assets/_inc/header.php"; ?>

<?php if ($_POST["submit"]) {
  // 投稿ボタン経由のPOST：コメント登録

  $comment = $_POST["comment"];
  $thread_id = $_SESSION["thread_id"];

  // セッションから、ユーザー情報を取得
  $user_id = $_SESSION["user_id"];

  // user_name がPOSTされていればその値、なければゲスト
  if ($_POST["user_name"]) {
    $user_name = $_POST["user_name"];
  } else {
    $user_name = "ゲスト";
  }

  // DBアクセス
  $dbh = database_access();

  // 新規コメントは現在の最新コメントのID +1
  $comment_id = count_comment($thread_id, $dbh) + 1;

  // commentsテーブルにデータを登録
  $sql =
    "insert into comments (comment_id, thread_id, user_id, user_name, comment) values (:comment_id, :thread_id, :user_id, :user_name, :comment)";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(":comment_id", $comment_id);
  $stmt->bindValue(":thread_id", $thread_id);
  $stmt->bindValue(":user_id", $user_id);
  $stmt->bindValue(":user_name", $user_name);
  $stmt->bindValue(":comment", $comment);
  $stmt->execute();

  $_SESSION["success"] = "コメントの投稿が完了しました。";

  $status = $_SESSION["status"];

  $uri = $_SERVER["HTTP_REFERER"];
  header("Location: " . $uri);
} else {
  $_SESSION["error"] = "エラーが発生しました。";
  header("Location: ./thread_list.php");
} ?>


<?php include dirname(__FILE__) . "/assets/_inc/footer.php"; ?>