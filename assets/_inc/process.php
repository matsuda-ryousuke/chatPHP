<?php
/*=============================================
  処理だけページ用インクルード
============================================= */
require_once dirname(__FILE__) . "/../../function/function.php";
require_once dirname(__FILE__) . "/../../function/access_control.php";
require_once dirname(__FILE__) . "/../../database/database.php";
require_once dirname(__FILE__) . "/../../database/DBusers.php";
require_once dirname(__FILE__) . "/../../database/DBthreads.php";
require_once dirname(__FILE__) . "/../../database/DBcomments.php";
require_once dirname(__FILE__) . "/../../database/DBfavorites.php";
require_once dirname(__FILE__) . "/../../database/DBLogin_fails.php";

session_start();
// 処理だけページにはgetアクセス禁止
post_only();