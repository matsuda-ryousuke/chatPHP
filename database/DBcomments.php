<?php
require_once "database.php";

class DBComments extends Database
{
  public function __construct()
  {
    parent::database_access();
  }

  // スレッドのコメントを取得、ページネーション対応
  public function get_comments_of_thread($thread_id, $start, $max)
  {
    $sql =
      "SELECT * FROM comments where thread_id = :thread_id limit :start_comment, :comment_max";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(":thread_id", $thread_id, PDO::PARAM_INT);
    $stmt->bindValue(":start_comment", $start, PDO::PARAM_INT);
    $stmt->bindValue(":comment_max", $max, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt;
  }

  // commentsテーブルにデータを登録
  public function post_comment(
    $comment_id,
    $thread_id,
    $user_id,
    $user_name,
    $comment
  ) {
    $sql =
      "INSERT into comments (comment_id, thread_id, user_id, user_name, comment) values (:comment_id, :thread_id, :user_id, :user_name, :comment)";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(":comment_id", $comment_id, PDO::PARAM_INT);
    $stmt->bindValue(":thread_id", $thread_id, PDO::PARAM_INT);
    $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->bindValue(":user_name", $user_name, PDO::PARAM_STR);
    $stmt->bindValue(":comment", $comment, PDO::PARAM_STR);
    return $stmt->execute();
  }
}
