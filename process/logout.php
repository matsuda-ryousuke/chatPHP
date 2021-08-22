<?php
/*=============================================
  logout.php
  ログアウト処理用のページ
============================================= */

require_once $_SERVER["DOCUMENT_ROOT"] . "/chatPHP/assets/_inc/process.php";
//セッションの中身をすべて削除
$_SESSION = [];
//セッションを破壊
session_destroy();

// サクセス文登録用に、セッションを再開
session_start();
$_SESSION["success"] = "ログアウトしました。";
// index.php にリダイレクト
header("Location: ../index.php");