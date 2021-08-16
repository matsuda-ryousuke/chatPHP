<?php

require "config/function.php";
session_start();
//var_dump($_SESSION);

// ログイン時の挙動
if (isset($_SESSION["login_id"])) {
    $link = '<a href="/logout.php">ログアウト</a>';
} else {
    $link = '<a href="/login_form.php">ログイン</a>';

    // セッションIDが全て付与されていない場合、guest_id を付与
    if (!isset($_SESSION["guest_id"])) {
        // セッションハイジャック対策
        session_regenerate_id();
        // ゲストユーザー用のセッションID
        $_SESSION["guest_id"] = session_id();

        $_SESSION["user_id"] = 1;
        $_SESSION["user_name"] = "ゲスト";
        $_SESSION["status"] = 0;
    }
}

// エラー、登録完了ステートメントがあるならば、変数に登録
if (isset($_SESSION["error"])) {
    $error = $_SESSION["error"];
    unset($_SESSION["error"]);
}
if (isset($_SESSION["success"])) {
    $success = $_SESSION["success"];
    unset($_SESSION["success"]);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/reset.css" />
    <link rel="stylesheet" href="/css/style.css" />

</head>

<body>

    <header class="header">
        <a href="index.php">
            <div class="header-logo">
            </div>
        </a>

        <form action="/search.php" method="get">
            <input type="text" name="search" id="search">
            <button type="submit">検索</button>
        </form>
        <?php echo $link; ?>
    </header>

    <section class="message">
        <?php if (isset($success)): ?>
        <div class="message-success">
            <p>
                <?php echo $success; ?>
            </p>
        </div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
        <div class="message-error">
            <p>
                <?php echo $error; ?>
            </p>
        </div>
        <?php endif; ?>



    </section>