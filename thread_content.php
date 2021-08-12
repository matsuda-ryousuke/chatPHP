<?php include(dirname(__FILE__).'/assets/_inc/header.php'); ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if(isset($_GET['id'])){
        // thread_id 取得
        $thread_id = htmlspecialchars($_GET['id']);
        $_SESSION['thread_id'] = $thread_id;
    }else{
        $_SESSION['error'] = "エラーが発生しました。";
        header('Location: ./thread_list.php');
    }

    // DB接続
    $dbh = database_access();

    // 該当スレッドを取得
    $sql_thread = "SELECT * FROM threads where thread_id = :thread_id";
    $stmt_thread = $dbh->prepare($sql_thread);
    $stmt_thread->bindValue(':thread_id', $thread_id);
    $stmt_thread->execute();

    // スレッドのコメントを取得
    $sql_comment = "SELECT * FROM comments where thread_id = :thread_id";
    $stmt_comment = $dbh->prepare($sql_comment);
    $stmt_comment->bindValue(':thread_id', $thread_id);
    $stmt_comment->execute();
}

?>

<!-- thread一覧の表示 -->
<?php foreach ($stmt_thread as $row) : ?>
    <div class="thread" data-id="<?php echo $row['thread_id']; ?>">
        <div class="thread_title">
            <?php echo $row['title']; ?>
        </div>
        <div class="thread_user">
            <?php echo $row['user_id']; ?>
        </div>
    </div>
<?php endforeach; ?>


<!-- comment一覧の表示 -->
<?php foreach ($stmt_comment as $row) : ?>
    <div class="thread" data-id="<?php echo $thread_id; ?>">
        <p><?php echo $row['comment_id']; ?></p>
        <div class="comment">
            <?php echo $row['comment']; ?>
        </div>
        <div class="thread_user">            
            <?php echo user_from_comment($row['user_id'], $dbh); ?>
        </div>
        <?php echo $row['created_at']; ?>
    </div>
<?php endforeach; ?>


<form action="comment_create.php" method="post" name="thread_form">
    <input type="text" name="comment" value="">
    
    <input type="submit" name="submit"></button>
</form>





<?php include(dirname(__FILE__).'/assets/_inc/footer.php'); ?>
