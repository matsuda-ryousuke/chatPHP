<?php

// エラー表示、本番環境で入れ替え
ini_set("display_errors", 1);

// DB登録用
define("DSN", "mysql:host=10.0.20.205;dbname=chatPHP;charset=utf8");
define("DB_USER", "mysql-user");
define("DB_PASS", '8QLQ"u>P>S89');

// ページネーションで表示する要素数
define("THREAD_MAX", 5);
define("COMMENT_MAX", 5);
define("FAVORITE_MAX", 5);

// DB登録要素の文字列長を指定
define("THREAD_TITLE_LENGTH", 64);
define("COMMENT_LENGTH", 255);
define("NAME_LENGTH", 20);

// ログイン失敗の設定、30分以内に5回失敗でアカウントロック
define("FAIL_MINUTES", 30);
define("FAIL_COUNTS", 5);