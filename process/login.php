<?php
/*=============================================
  ログイン処理用のページ
  処理が終わればリダイレクト
============================================= */

require_once $_SERVER["DOCUMENT_ROOT"] . "/chatPHP/assets/_inc/process.php";

$dbuser = new DBUsers();
$dblogin_fail = new DBLogin_fails();

// メールアドレス、パスワードを取得
$mail = htmlspecialchars($_POST["mail"], ENT_QUOTES, "UTF-8");
$pass = htmlspecialchars($_POST["pass"], ENT_QUOTES, "UTF-8");

// csrf対策
check_token();

// DB処理
try {
  $dbuser->dbh->beginTransaction();

  // 入力されたメールアドレスと、同じアドレスのユーザーを取得
  $member = $dbuser->get_user_by_mail($mail);

  // メールアドレスに合致するユーザーがいなかった場合
  if ($member == null) {
    $_SESSION["error"] = "ご入力のメールアドレスは登録されていません。";
    // ログインフォームにリダイレクト
    header("Location: ../login_form.php");
    exit();
  }

  // ログイン失敗回数が制限を越えていたら、アカウントロック
  if (
    $dblogin_fail->count_login_fails($member["user_id"], FAIL_MINUTES) >=
    FAIL_COUNTS
  ) {
    $_SESSION["error"] =
      "ログインの失敗が続いたため、アカウントをロックしました。";

    header("location: ../login_form.php");
    exit();
  }

  // アドレスが合致するユーザーの、パスワードハッシュも合致した場合にログイン
  if (password_verify($pass, $member["pass"])) {
    // セッションハイジャック対策
    session_regenerate_id();
    // login_id としてセッションIDを付与、ゲスト用のセッションIDは削除
    $_SESSION["login_id"] = session_id();
    unset($_SESSION["guest_id"]);

    // DBのユーザー情報をセッションに保存
    $_SESSION["user_id"] = $member["user_id"];
    $_SESSION["user_name"] = $member["user_name"];
    $_SESSION["status"] = $member["status"];

    // ユーザーのログイン失敗データを削除
    $dblogin_fail->delete_login_fails($user_id);

    // 成功文とともにindexにリダイレクト
    $msg = "ログインしました。";
    header("Location: ../index.php");

    // パスワードがマッチしない場合
  } else {
    // ログインを試みたユーザーのID,IPアドレスを、ログイン失敗DBに登録
    $ip = (string) $_SERVER["REMOTE_ADDR"];
    $dblogin_fail->post_login_fails($member["user_id"], $ip);

    $_SESSION["error"] = "メールアドレスもしくはパスワードが間違っています。";
    // ログインフォームにリダイレクト
    header("Location: ../login_form.php");
  }

  $dbuser->dbh->commit();
} catch (Exception $e) {
  $dbuser->dbh->rollBack();
  echo "失敗しました。" . $e->getMessage();
}