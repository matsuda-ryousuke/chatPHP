<?php
/*=============================================
  signup.php
  新規会員登録フォーム表示ページ
============================================= */

require_once $_SERVER["DOCUMENT_ROOT"] . "/chatPHP/assets/_inc/require.php";

// csrf対策
set_token();

// view読み込み
include dirname(__FILE__) . "/view/signup.php";