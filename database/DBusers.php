<?php
require_once "database.php";

class DBUsers extends Database
{
  public function __construct()
  {
    parent::database_access();
  }

  // ユーザーIDからユーザー名を取得
  public function get_username_by_id($user_id)
  {
    $sql = "SELECT user_name from users where user_id = :user_id";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user_name = $stmt->fetch();
    return !empty($user_name["user_name"]) ? $user_name["user_name"] : null;
  }

  // 入力メールアドレスに合致するユーザーを取得
  public function get_user_by_mail($mail)
  {
    $sql = "SELECT * FROM users WHERE mail = :mail";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(":mail", $mail, PDO::PARAM_STR);
    $stmt->execute();
    $member = $stmt->fetch();
    return !empty($member) ? $member : null;
  }

  // ユーザーを登録
  public function register_user($user_name, $mail, $pass)
  {
    $sql =
      "INSERT INTO users(user_name, mail, pass, status) VALUES (:user_name, :mail, :pass, 1)";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(":user_name", $user_name, PDO::PARAM_STR);
    $stmt->bindValue(":mail", $mail, PDO::PARAM_STR);
    $stmt->bindValue(":pass", $pass, PDO::PARAM_STR);
    return $stmt->execute();
  }
}
