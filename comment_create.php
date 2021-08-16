<?php
/*=============================================
  コメント登録処理用のページ
  処理が終わればリダイレクト
============================================= */

include dirname(__FILE__) . "/assets/_inc/process.php";

if ($_POST["comment"]) {
    // POSTでコメントが送られている：コメント登録

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

    // DBアクセス
    $dbh = database_access();

    try {
        $dbh->beginTransaction();

        // スレッドのコメント数を取得
        $sql = "select comment_count from threads where thread_id = :thread_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(":thread_id", $thread_id);
        $stmt->execute();
        $comment_id = $stmt->fetchColumn() + 1;

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

        // スレッドのコメント数を更新
        $sql =
      "update threads set comment_count = :comment_id where thread_id = :thread_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(":comment_id", $comment_id);
        $stmt->bindValue(":thread_id", $thread_id);
        $stmt->execute();

        $dbh->commit();
    } catch (Exception $e) {
        $dbh->rollBack();
        echo "失敗しました。" . $e->getMessage();
    }

    $_SESSION["success"] = "コメントの投稿が完了しました。";

    $status = $_SESSION["status"];

    $uri = $_SERVER["HTTP_REFERER"];
    header("Location: " . $uri);
} else {
    $_SESSION["error"] = "エラーが発生しました。";
    header("Location: ./index.php");
}