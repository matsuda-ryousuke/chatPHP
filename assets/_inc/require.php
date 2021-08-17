<?php

require_once dirname(__FILE__) . "/../../config/function.php";
require_once dirname(__FILE__) . "/../../database/database.php";
require_once dirname(__FILE__) . "/../../database/DBusers.php";
require_once dirname(__FILE__) . "/../../database/DBthreads.php";
require_once dirname(__FILE__) . "/../../database/DBcomments.php";
require_once dirname(__FILE__) . "/../../database/DBfavorites.php";

session_start();
var_dump($_SESSION);

// ログイン時の挙動
if (isset($_SESSION["login_id"])) {
  $link =
    '<a href="./user_config.php">ユーザー設定</a><a class="logout" href="./process/logout.php">ログアウト</a>';
} else {
  $link = '<a href="./login_form.php">ログイン</a>';

  // セッションIDが全て付与されていない場合、guest_id を付与
  if (!isset($_SESSION["guest_id"])) {
    // セッションハイジャック対策
    session_regenerate_id();
    // ゲストユーザー用のセッションID
    $_SESSION["guest_id"] = session_id();

    $_SESSION["user_id"] = 1;
    $_SESSION["user_name"] = "ゲスト";
    $_SESSION["status"] = 0;
  }
}

// エラー、登録完了ステートメントがあるならば、変数に登録
if (isset($_SESSION["error"])) {
  $error = $_SESSION["error"];
  unset($_SESSION["error"]);
}
if (isset($_SESSION["success"])) {
  $success = $_SESSION["success"];
  unset($_SESSION["success"]);
}
?>