<?php
namespace DB;

class DB
{
    protected $dbh;
    // DBアクセス用の関数
    //function database_access()
    public function __construct()
    {
        try {
            $this->dbh = new PDO(DSN, DB_USER, DB_PASS);
        } catch (PDOException $e) {
            die("接続できません: " . $e->getMessage());
        }
    }
}