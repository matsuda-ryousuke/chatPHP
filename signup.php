<?php
/*=============================================
  signup.php
  新規会員登録フォーム表示ページ
============================================= */

include dirname(__FILE__) . "/assets/_inc/require.php";

// csrf対策
set_token();

// view読み込み
include dirname(__FILE__) . "/view/signup.php";