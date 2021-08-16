<?php

class Database
{
  public $dbh;
  // DBアクセス用の関数
  //function database_access()
  public function database_access()
  {
    try {
      $this->dbh = new PDO(DSN, DB_USER, DB_PASS);
    } catch (PDOException $e) {
      die("接続できません: " . $e->getMessage());
    }
  }
}
