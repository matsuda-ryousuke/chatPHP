<?php
session_start();
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION["error"]);
}
?>


<h1>ログインページ</h1>
<?php if (isset($error)) {
    echo $error;
}?>
<form action="login.php" method="post">
    <div>
        <label>メールアドレス：<label>
                <input type="text" name="mail" required>
    </div>
    <div>
        <label>パスワード：<label>
                <input type="password" name="pass" required>
    </div>
    <input type="submit" value="ログイン">
</form>
<p>新規登録は<a href="signup.php">こちら</a></p>
<p>簡単ログインは<a href="login_nopass.php">こちら</a></p>
