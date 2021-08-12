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

function count_comment($thread_id, $dbh){
    // comment_id の最大値を取得
    $sql = "select comment_id from comments where thread_id = :thread_id order by comment_id desc limit 1";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':thread_id', $thread_id);
    $stmt->execute();
    $comment_id = $stmt->fetch();

    if($comment_id == null){
        return "0";
    }else{
        return $comment_id["comment_id"];
    }
}