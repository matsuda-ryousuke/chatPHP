<?php
require 'config/database.php';

//フォームからの値をそれぞれ変数に代入
$user_name = $_POST['user_name'];
$mail = $_POST['mail'];
$pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

// DB接続
$dbh = database_access();

// フォームに入力されたmailがすでに登録されていないかチェック
$sql = "SELECT * FROM users WHERE mail = :mail";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':mail', $mail);
$stmt->execute();
$member = $stmt->fetch();

if($member == null){
    //登録されていなければinsert
    $sql = "INSERT INTO users(user_name, mail, pass, status) VALUES (:user_name, :mail, :pass, 1)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':user_name', $user_name);
    $stmt->bindValue(':mail', $mail);
    $stmt->bindValue(':pass', $pass);
    $stmt->execute();
    $msg = '会員登録が完了しました';
$link = '<a href="login_form.php">ログインページ</a>';
} else {
    $msg = '同じメールアドレスが存在します。';
    $link = '<a href="signup.php">戻る</a>';
}

?>

<h1><?php echo $msg; ?>
</h1>
<!--メッセージの出力-->
<?php echo $link;
