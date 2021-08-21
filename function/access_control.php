<?php

// ログインしていなければログインフォームへリダイレクト
function access_control()
{
  if (!isset($_SESSION["login_id"])) {
    $_SESSION["error"] = "ログインしていません。";
    header("Location: /login_form.php");
  }
}

// processの処理について、GETアクセスの場合インデックスにリダイレクト
function post_only()
{
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $_SESSION["error"] = "無効なアクセスです。";
    header("Location: ../index.php");
    exit();
  }
}