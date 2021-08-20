<?php
/*=============================================
  ログインフォーム表示ページ
============================================= */

include dirname(__FILE__) . "/header.php"; ?>



<section class="login">
    <h1>ログインページ</h1>
    <?php if (isset($error)) {
      echo $error;
    } ?>

    <form action="process/login.php" method="post">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars(
          $_SESSION["token"],
          ENT_QUOTES,
          "UTF-8"
        ); ?>">
        <div>
            <input type="text" name="mail" class="fa" placeholder="&#xf0e0; メールアドレス" required>
        </div>
        <div>
            <input type="password" name="pass" class="fa" placeholder="&#xf084; パスワード" required>
        </div>
        <button type="submit" class="reset submit-btn">ログイン</button>
    </form>


</section>
<div class="login-btn">
    <a href="./signup.php" class="a-btn"><span class="a-btn-icon"><i class="fas fa-user-plus"></i></span><span
            class="a-btn-text">新規登録はこちら</span></a>
</div>

<?php include dirname(__FILE__) . "/footer.php"; ?>