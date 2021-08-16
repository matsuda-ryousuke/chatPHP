<?php
/*=============================================
  ログイン処理用のページ
  処理が終わればリダイレクト
============================================= */

include dirname(__FILE__) . "/../assets/_inc/process.php";

$dbuser = new DBUsers();

$mail = htmlspecialchars($_POST["mail"]);
$pass = htmlspecialchars($_POST["pass"]);

// DB処理
try {
  $dbuser->dbh->beginTransaction();

  // ログインフォームに入力されたメールアドレスと、同じものをDBから取得
  $member = $dbuser->get_user_by_mail($mail);

  $dbuser->dbh->commit();
} catch (Exception $e) {
  $dbuser->dbh->rollBack();
  echo "失敗しました。" . $e->getMessage();
}

//指定したハッシュがパスワードにマッチしているかチェック
if (!$member == null && password_verify($pass, $member["pass"])) {
  // セッションハイジャック対策
  session_regenerate_id();
  // login_id としてセッションIDを付与、ゲスト用のセッションIDは削除
  $_SESSION["login_id"] = session_id();
  unset($_SESSION["guest_id"]);

  // DBのユーザー情報をセッションに保存
  $_SESSION["user_id"] = $member["user_id"];
  $_SESSION["user_name"] = $member["user_name"];
  $_SESSION["status"] = $member["status"];

  $msg = "ログインしました。";
  header("Location: ../index.php");

  // メールアドレスに合致するユーザーがいない or パスワードがマッチしない
} else {
  $_SESSION["error"] = "メールアドレスもしくはパスワードが間違っています。";
  // ログインフォームにリダイレクト
  header("Location: ../login_form.php");
}
