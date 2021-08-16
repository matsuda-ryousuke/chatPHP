<?php
require_once "database.php";

class DBFavorites extends Database
{
  public function __construct()
  {
    parent::database_access();
  }
  // 指定したユーザー、スレッドのお気に入りがあれば取得
  public function get_favorites($user_id, $thread_id)
  {
    $sql =
      "SELECT * from favorites where user_id = :user_id and thread_id = :thread_id";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->bindValue(":thread_id", $thread_id, PDO::PARAM_INT);
    $stmt->execute();
    $favorite = $stmt->fetch();
    return !empty($favorite) ? $favorite : null;
  }

  // お気に入り登録
  public function post_favorites($user_id, $thread_id)
  {
    $sql =
      "INSERT into favorites (user_id, thread_id) values (:user_id, :thread_id)";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->bindValue(":thread_id", $thread_id, PDO::PARAM_INT);
    return $stmt->execute();
  }

  // お気に入り解除
  public function delete_favorites($user_id, $thread_id)
  {
    $sql =
      "DELETE from favorites where user_id = :user_id and thread_id = :thread_id";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->bindValue(":thread_id", $thread_id, PDO::PARAM_INT);
    return $stmt->execute();
  }
}
