<?php
/*=============================================
  新規会員登録フォーム表示ページ
============================================= */

include dirname(__FILE__) . "/header.php"; ?>

<section class="login">

    <h1>新規会員登録</h1>
    <form action="./process/register.php" method="post">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars(
          $_SESSION["token"],
          ENT_QUOTES,
          "UTF-8"
        ); ?>">
        <div>
            <input type="text" name="user_name" maxlength="<?php echo NAME_LENGTH; ?>" class="fa"
                placeholder="&#xf007; ユーザー名" required>
        </div>
        <div>
            <input type="text" name="mail" class="fa" placeholder="&#xf0e0; メールアドレス" required>
        </div>
        <div>
            <input type="password" name="pass" class="fa" placeholder="&#xf084; パスワード" required>
        </div>
        <button type="submit" class="reset submit-btn submit-btn-register">新規登録</button>
    </form>
</section>
<div class="login-btn">
    <a href="./login_form.php" class="a-btn"><span class="a-btn-icon"><i class="fas fa-sign-in-alt"></i></span><span
            class="a-btn-text">すでに登録済みの方はこちら</span></a>
</div>

<?php include dirname(__FILE__) . "/footer.php";