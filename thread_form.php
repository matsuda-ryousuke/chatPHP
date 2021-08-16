<?php
/*=============================================
  スレッドの内容表示ページ
  コメントの表示や、コメント入力フォームを表示
============================================= */

include dirname(__FILE__) . "/assets/_inc/require.php";
require_once dirname(__FILE__) . "/config/access_control.php";
// ログインしていない場合、ログインフォームへ遷移
access_control();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  // GETアクセス、ゲストユーザーの場合はインデックスにリダイレクト
  if ($_SESSION["status"] == 0) {
    $_SESSION["error"] = "ゲストアカウントではこの機能はご利用いただけません。";
    header("Location: ./index.php");
  }
}

include dirname(__FILE__) . "/view/thread_form.php"; ?>
