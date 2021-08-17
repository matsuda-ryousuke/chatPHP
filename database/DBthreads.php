<?php

require_once "database.php";

/**
 * threadsテーブルへの接続用クラス
 */
class DBThreads extends Database
{
  public function __construct()
  {
    parent::database_access();
  }

  // スレッドの総数をカウント
  public function count_threads()
  {
    $sql = "SELECT COUNT(*) FROM threads";
    $stmt = $this->dbh->prepare($sql);
    $stmt->execute();
    $count = $stmt->fetchColumn(0);
    return !empty($count) ? $count : null;
  }

  // スレッドの総数をカウント（検索アリ）
  public function count_threads_search($search)
  {
    $sql_count = "SELECT COUNT(*) FROM threads where title like :search";
    $stmt_count = $this->dbh->prepare($sql_count);
    $stmt_count->bindValue(":search", "%" . $search . "%", PDO::PARAM_STR);
    $stmt_count->execute();
    $count = $stmt_count->fetchColumn(0);
    return !empty($count) ? $count : null;
  }

  // 全スレッドを取得（ページネーション対応）
  public function get_threads($start, $max)
  {
    $sql =
      "SELECT * FROM threads order by updated_at desc limit :start_thread, :thread_max";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(":start_thread", $start, PDO::PARAM_INT);
    $stmt->bindValue(":thread_max", $max, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt;
  }

  // 検索結果の全スレッドを取得（ページネーション対応）
  public function get_threads_search($search, $start, $max)
  {
    $sql =
      "SELECT * FROM threads where title like :search order by updated_at desc limit :start_thread, :thread_max";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(":search", "%" . $search . "%", PDO::PARAM_STR);
    $stmt->bindValue(":start_thread", $start, PDO::PARAM_INT);
    $stmt->bindValue(":thread_max", $max, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt;
  }

  // スレッドIDからスレッドの内容を取得
  public function get_thread_by_id($thread_id)
  {
    $sql = "SELECT * FROM threads where thread_id = :thread_id";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(":thread_id", $thread_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();
    return !empty($result) ? $result : null;
  }

  // スレッドのコメント数を取得
  public function get_count_comment($thread_id)
  {
    $sql = "SELECT comment_count from threads where thread_id = :thread_id";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(":thread_id", $thread_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchColumn(0);
    return !empty($result) ? $result : null;
  }

  // スレッドを作成
  public function create_thread($title, $user_id, $user_name)
  {
    $sql =
      "INSERT into threads (title, user_id, user_name) values (:title, :user_id, :user_name)";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(":title", $title, PDO::PARAM_STR);
    $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->bindValue(":user_name", $user_name, PDO::PARAM_STR);
    return $stmt->execute();
  }

  // スレッドのコメント数を更新
  public function update_count_comment($comment_id, $thread_id)
  {
    $sql =
      "UPDATE threads set comment_count = :comment_id where thread_id = :thread_id";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(":comment_id", $comment_id, PDO::PARAM_INT);
    $stmt->bindValue(":thread_id", $thread_id, PDO::PARAM_INT);
    return $stmt->execute();
  }
}
