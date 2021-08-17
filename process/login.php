<?php
/*=============================================
  ログイン処理用のページ
  処理が終わればリダイレクト
============================================= */

include dirname(__FILE__) . "/../assets/_inc/process.php";

$dbuser = new DBUsers();

// メールアドレス、パスワードを取得
$mail = htmlspecialchars($_POST["mail"], ENT_QUOTES, "UTF-8");
$pass = htmlspecialchars($_POST["pass"], ENT_QUOTES, "UTF-8");

// DB処理
try {
  $dbuser->dbh->beginTransaction();

  // 入力されたメールアドレスと、同じアドレスのユーザーを取得
  $member = $dbuser->get_user_by_mail($mail);

  $dbuser->dbh->commit();
} catch (Exception $e) {
  $dbuser->dbh->rollBack();
  echo "失敗しました。" . $e->getMessage();
}

// アドレスが合致するユーザーの、パスワードハッシュも合致した場合にログイン
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

  // 成功文とともにindexにリダイレクト
  $msg = "ログインしました。";
  header("Location: ../index.php");

  // メールアドレスに合致するユーザーがいない or パスワードがマッチしない場合
} else {
  $_SESSION["error"] = "メールアドレスもしくはパスワードが間違っています。";
  // ログインフォームにリダイレクト
  header("Location: ../login_form.php");
}
