<?php include(dirname(__FILE__).'/assets/_inc/header.php'); ?>


<?php

// セッションのユーザー情報を登録
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$status = $_SESSION['status'];

$msg = 'こんにちは ' . htmlspecialchars($user_name, \ENT_QUOTES, 'UTF-8') . 'さん';
    $link = '<a href="logout.php">ログアウト</a>';

?>

    <h1><?php echo $msg; ?>
    </h1>
    <?php echo $link; ?>

    <?php if ($status >= 1): ?>
    <p><a href="thread_create.php">スレッド作成</a></p>
    <?php else: ?>
        <p>ゲストアカウントでは、スレッド作成機能が制限されます。</p>
    <?php endif; ?>

    <p><a href="thread_list.php">スレッド一覧</a></p>

    

    <?php include(dirname(__FILE__).'/assets/_inc/footer.php'); ?>
