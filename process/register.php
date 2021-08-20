<?php
/*=============================================
  会員登録処理用のページ
  処理が終われば別ページへリダイレクト
============================================= */
include dirname(__FILE__) . "/../assets/_inc/process.php";

$dbuser = new DBUsers();

//フォームからの値をそれぞれ変数に代入
$user_name = htmlspecialchars($_POST["user_name"], ENT_QUOTES, "UTF-8");
$mail = htmlspecialchars($_POST["mail"], ENT_QUOTES, "UTF-8");
$pass = password_hash(
  htmlspecialchars($_POST["pass"], ENT_QUOTES, "UTF-8"),
  PASSWORD_DEFAULT
);

// csrf対策
check_token();

// 各入力値のいずれかが空の場合、もしくはユーザー名の入力文字数が制限を超える場合、エラー
if (empty($user_name) || empty($mail) || empty($pass)) {
  $_SESSION["error"] = "エラーが発生しました。";
  header("Location: ../index.php");
  exit();
} elseif (mb_strlen($user_name) > NAME_LENGTH) {
  $_SESSION["error"] = "不正な入力値です。";
  $uri = $_SERVER["HTTP_REFERER"];
  header("Location: " . $uri);
  exit();
}

// DB処理
try {
  $dbuser->dbh->beginTransaction();

  // フォームに入力されたmailがすでに登録されていないかチェック
  $member = $dbuser->get_user_by_mail($mail);

  if ($member == null) {
    //登録されていなければinsert
    $dbuser->register_user($user_name, $mail, $pass);
    $_SESSION["success"] = "会員登録が完了しました。";
  } else {
    $_SESSION["error"] = "同じメールアドレスが存在します。";
  }

  $dbuser->dbh->commit();
} catch (Exception $e) {
  $dbuser->dbh->rollBack();
  echo "失敗しました。" . $e->getMessage();
}

// DB処理成功の可否に応じてリダイレクト先を変更
if ($_SESSION["success"]) {
  header("Location: ../login_form.php");
} else {
  header("Location: ../signup.php");
}