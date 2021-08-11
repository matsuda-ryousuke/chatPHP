<?php
require "config.php";

function database_access()
{
    try {
        $dbh = new PDO(DSN, DB_USER, DB_PASS);
        return $dbh;
    } catch (PDOException $e) {
        $msg = $e->getMessage();
        return $msg;
    }
}
