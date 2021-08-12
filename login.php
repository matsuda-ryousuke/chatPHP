<?php
require 'config/database.php';

session_start();
$mail = $_POST['mail'];
// DB接続
$dbh = database_access();

// ログインフォームに入力されたメールアドレスと、同じものをDBから取得
$sql = "SELECT * FROM users WHERE mail = :mail";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':mail', $mail);
$stmt->execute();

// $member: 該当ユーザー
$member = $stmt->fetch();

//指定したハッシュがパスワードにマッチしているかチェック
if (!$member == null && password_verify($_POST['pass'], $member['pass'])) {
    // セッションハイジャック対策
    session_regenerate_id();
    $_SESSION['login_id'] = session_id();

    // DBのユーザー情報をセッションに保存
    $_SESSION['user_id'] = $member['user_id'];
    $_SESSION['user_name'] = $member['user_name'];
    $_SESSION['status'] = $member['status'];


    $msg = 'ログインしました。';
    header('Location: ./index.php');

// メールアドレスに合致するユーザーがいない or パスワードがマッチしない
} else {
    $_SESSION['error'] = "メールアドレスもしくはパスワードが間違っています。";
    // ログインフォームにリダイレクト
    header('Location: ./login_form.php');
}
