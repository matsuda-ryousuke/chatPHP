<?php
/*=============================================
  thread_form.php
  スレッドの新規作成用フォームを表示
  ログインしていることが必須
============================================= */

include dirname(__FILE__) . "/assets/_inc/require.php";
require_once dirname(__FILE__) . "/function/access_control.php";
// ログインしていない場合、ログインフォームへ遷移
access_control();

// ゲストユーザーの場合はインデックスにリダイレクト
if ($_SESSION["status"] == 0) {
  $_SESSION["error"] = "ゲストアカウントではこの機能はご利用いただけません。";
  header("Location: ./index.php");
}

// csrf対策
set_token();

// view読み込み
include dirname(__FILE__) . "/view/thread_form.php";