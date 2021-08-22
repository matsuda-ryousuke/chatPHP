<?php
/*=============================================
  処理だけページ用インクルード
============================================= */
require_once $_SERVER["DOCUMENT_ROOT"] . "/chatPHP/function/function.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/chatPHP/function/access_control.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/chatPHP/database/database.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/chatPHP/database/DBusers.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/chatPHP/database/DBthreads.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/chatPHP/database/DBcomments.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/chatPHP/database/DBfavorites.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/chatPHP/database/DBlogin_fails.php";

session_start();
// 処理だけページにはgetアクセス禁止
post_only();