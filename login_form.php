<?php
/*=============================================
  login_form.php
  ログインフォーム表示ページ
============================================= */

include dirname(__FILE__) . "/assets/_inc/require.php";

// csrf対策
set_token();

// view読み込み
include dirname(__FILE__) . "/view/login_form.php";
?>