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

function user_from_comment($user_id, $dbh){

    // ユーザーIDからユーザー名を取得
    $sql = "select user_name from users where user_id = :user_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
    $user_name = $stmt->fetch();
    return $user_name["user_name"];
}
