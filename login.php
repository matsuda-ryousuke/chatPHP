<?php
require 'config/config.php';
require 'config/database.php';

session_start();
$mail = $_POST['mail'];
// DB接続
$dbh = database_access();


$sql = "SELECT * FROM users WHERE mail = :mail";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':mail', $mail);
$stmt->execute();
$member = $stmt->fetch();
//指定したハッシュがパスワードにマッチしているかチェック
if (password_verify($_POST['pass'], $member['pass'])) {
    // セッションハイジャック対策
    session_regenerate_id();
    $_SESSION['id'] = session_id();

    // DBのユーザー情報をセッションに保存
    $_SESSION['user_id'] = $member['user_id'];
    $_SESSION['user_name'] = $member['user_name'];
    $_SESSION['mail'] = $member['mail'];


    $msg = 'ログインしました。';
    header('Location: ./index.php');
} else {
    $_SESSION['error'] = "メールアドレスもしくはパスワードが間違っています。";
    header('Location: ./login_form.php');
}
