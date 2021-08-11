<?php
require 'config.php';

session_start();
$mail = $_POST['mail'];
try {
    $dbh = new PDO(DSN, DB_USER, DB_PASS);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}

$sql = "SELECT * FROM users WHERE mail = :mail";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':mail', $mail);
$stmt->execute();
$member = $stmt->fetch();
//指定したハッシュがパスワードにマッチしているかチェック
if (password_verify($_POST['pass'], $member['pass'])) {
    // セッションハイジャック対策
    session_regenerate_id();
    $_SESSION['id'] = session_id();
    
    //DBのユーザー情報をセッションに保存
    $_SESSION['name'] = $member['name'];
    $msg = 'ログインしました。';
    $link = '<a href="index.php">ホーム</a>';
} else {
    $msg = 'メールアドレスもしくはパスワードが間違っています。';
    $link = '<a href="login_form.php">戻る</a>';
}
?>

<h1><?php echo $msg; ?>
</h1>
<?php echo $link;
