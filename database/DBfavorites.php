<?php
require_once "database.php";

/**
 * favoritesテーブルへの接続用クラス
 */
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

  // 指定したユーザーのお気に入り総数を取得
  public function count_favorites($user_id)
  {
    $sql = "SELECT count(*) FROM favorites where user_id = :user_id";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchColumn(0);
    return !empty($result) ? $result : 0;
  }

  // 指定したユーザーのお気に入りを取得、ページネーション対応
  public function get_favorites_of_user(
    $user_id,
    $start_favorite,
    $favorite_max
  ) {
    $sql =
      "SELECT * FROM favorites where user_id = :user_id order by updated_at desc limit :start_favorite, :favorite_max";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->bindValue(":start_favorite", $start_favorite, PDO::PARAM_INT);
    $stmt->bindValue(":favorite_max", $favorite_max, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt;
  }
}
