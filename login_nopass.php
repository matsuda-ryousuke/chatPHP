<?php
require 'config/database.php';

session_start();

// DB接続
$dbh = database_access();

if (isset($_SESSION['id'])) {
    $_SESSION['error'] = "既にログインしています。";
    header('Location: ./index.php');
}



// ゲストユーザーアカウントをDBから取得
$sql = "select * from users where status = 0 order by user_id desc limit 1";
$stmt = $dbh->prepare($sql);
$stmt->execute();

// $member: ゲストユーザー
$member = $stmt->fetch();

// セッションハイジャック対策
session_regenerate_id();
$_SESSION['id'] = session_id();

// ゲストユーザー情報をセッションに保存
$_SESSION['user_id'] = $member['user_id'];
$_SESSION['user_name'] = $member['user_name'];
$_SESSION['status'] = $member['status'];

$_SESSION['success'] = "簡単ログイン機能でログインしました。";
header('Location: ./index.php');