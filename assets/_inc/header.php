<?php

require "config/access_control.php";
require "config/database.php";

session_start();

// ログインしていない場合、ログインフォームへ遷移
access_control();

// エラー、登録完了ステートメントがあるならば、変数に登録
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION["error"]);
}
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
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
    <link rel="stylesheet" href="css/reset.css" />
</head>

<body>
    header

    <?php if (isset($success)) { echo $success; } ?>
    <?php if (isset($error)) { echo $error; } ?>
