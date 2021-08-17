<?php

/**
 * DB接続用の親クラス
 */
class Database
{
  public $dbh;
  // DBアクセス用の関数
  public function database_access()
  {
    try {
      $this->dbh = new PDO(DSN, DB_USER, DB_PASS);
    } catch (PDOException $e) {
      die("接続できません: " . $e->getMessage());
    }
  }
}
