<?php
/*=============================================
  新規会員登録フォーム表示ページ
============================================= */

include dirname(__FILE__) . "/assets/_inc/header.php";

?>

<h1>新規会員登録</h1>
<form action="register.php" method="post">
    <div>
        <label>名前：<label>
                <input type="text" name="user_name" required>
    </div>
    <div>
        <label>メールアドレス：<label>
                <input type="text" name="mail" required>
    </div>
    <div>
        <label>パスワード：<label>
                <input type="password" name="pass" required>
    </div>
    <input type="submit" value="新規登録">
</form>
<p>すでに登録済みの方は<a href="login_form.php">こちら</a></p>

<?php include dirname(__FILE__) . "/assets/_inc/footer.php";