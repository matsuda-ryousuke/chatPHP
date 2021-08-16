<?php
/*===========================================
  お気に入りを登録するためのPHP,ajax専用
===========================================*/
 
include dirname(__FILE__) . "/assets/_inc/process.php";


// POSTアクセス時のみ処理
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // user_id, thread_idをセッションから取得
    $user_id = $_SESSION["user_id"];
    $thread_id = $_SESSION["thread_id"];

    // DBアクセス
    $dbh = database_access();

    try {
        $dbh->beginTransaction();

        // すでにお気に入りされていないかチェック
        $sql = "select * from favorites where user_id = :user_id and thread_id = :thread_id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindValue(":thread_id", $thread_id, PDO::PARAM_INT);
        $stmt->execute();
        $favorite = $stmt->fetch();

        // されていなければお気に入り登録
        if ($favorite == null) {
            $sql = "insert into favorites (user_id, thread_id) values (:user_id, :thread_id)";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindValue(":thread_id", $thread_id, PDO::PARAM_INT);
            $stmt->execute();
        // されていれば、お気に入り解除
        } else {
            $sql = "delete from favorites where user_id = :user_id and thread_id = :thread_id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindValue(":thread_id", $thread_id, PDO::PARAM_INT);
            $stmt->execute();
        }

        $dbh->commit();
    } catch (Exception $e) {
        $dbh->rollBack();
        echo "失敗しました。" . $e->getMessage();
    }

    exit;
}