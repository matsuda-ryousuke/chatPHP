<?php
require_once "database.php";

/**
 * login_failsテーブルへの接続用クラス
 */
class DBLogin_fails extends Database
{
  public function __construct()
  {
    parent::database_access();
  }

  // ログイン失敗情報登録
  public function post_login_fails($user_id, $ip)
  {
    $sql = "INSERT into login_fails (user_id, ip) values (:user_id, :ip)";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->bindValue(":ip", $ip, PDO::PARAM_STR);
    return $stmt->execute();
  }

  // ログイン失敗データを解除
  public function delete_login_fails($user_id)
  {
    $sql = "DELETE from login_fails where user_id = :user_id";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
    return $stmt->execute();
  }

  // 指定したユーザーの直近30分のログイン失敗回数を取得
  public function count_login_fails($user_id, $fail_minutes)
  {
    $sql =
      "SELECT count(*) FROM login_fails where user_id = :user_id and created_at > CURRENT_TIMESTAMP + interval - :fail_minutes minute";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->bindValue(":fail_minutes", $fail_minutes, PDO::PARAM_INT);

    $stmt->execute();
    $result = $stmt->fetchColumn(0);
    return !empty($result) ? $result : 0;
  }
}
