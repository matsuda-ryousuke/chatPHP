<?php

ini_set("display_errors", 1);

define("DSN", "mysql:host=localhost;dbname=chatPHP;charset=utf8");
define("DB_USER", "mysql-user");
define("DB_PASS", "4308Pillows");

define("THREAD_MAX", 5);
define("COMMENT_MAX", 5);
define("FAVORITE_MAX", 5);

define("THREAD_TITLE_LENGTH", 64);
define("COMMENT_LENGTH", 255);
define("NAME_LENGTH", 20);

// ログイン失敗の設定、30分以内に5回失敗でアカウントロック
define("FAIL_MINUTES", 30);
define("FAIL_COUNTS", 5);
