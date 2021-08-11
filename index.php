<?php
require "config/access_control.php";
session_start();

if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION["error"]);
}
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION["success"]);
}


$id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$mail = $_SESSION['mail'];

// ログインしていない場合、ログインフォームへ遷移
access_control();

$msg = 'こんにちは' . htmlspecialchars($user_name, \ENT_QUOTES, 'UTF-8') . 'さん';
$link = '<a href="logout.php">ログアウト</a>';
var_dump($_SESSION['id']);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php if (isset($success)) {
    echo $success;
}
    ?>
    <?php if (isset($error)) {
        echo $error;
    }
    ?>

    <h1><?php echo $msg; ?>
    </h1>
    <?php echo $link; ?>
    <p><a href="thread.php">スレッド作成</a></p>
</body>

</html>