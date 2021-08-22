<?php

require_once "/function/function.php";
require_once "/database/database.php";
require_once "/database/DBusers.php";
require_once "/database/DBthreads.php";
require_once "/database/DBcomments.php";
require_once "/database/DBfavorites.php";
require_once "/database/DBLogin_fails.php";

session_start();
// var_dump($_SESSION);

// セッションIDが全て付与されていない場合、guest_id を付与
if (!isset($_SESSION["login_id"]) && !isset($_SESSION["guest_id"])) {
  // セッションハイジャック対策
  session_regenerate_id();
  // ゲストユーザー用のセッションID
  $_SESSION["guest_id"] = session_id();

  $_SESSION["user_id"] = 1;
  $_SESSION["user_name"] = "ゲスト";
  $_SESSION["status"] = 0;
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