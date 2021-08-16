<?php
/*=============================================
  会員登録処理用のページ
  処理が終われば別ページへリダイレクト
============================================= */
include dirname(__FILE__) . "/assets/_inc/process.php";


//フォームからの値をそれぞれ変数に代入
$user_name = htmlspecialchars($_POST["user_name"]);
$mail = htmlspecialchars($_POST["mail"]);
$pass = password_hash(htmlspecialchars($_POST["pass"]), PASSWORD_DEFAULT);

// DB接続
$dbh = database_access();

try {
    $dbh->beginTransaction();

    // フォームに入力されたmailがすでに登録されていないかチェック
    $sql = "SELECT * FROM users WHERE mail = :mail";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(":mail", $mail);
    $stmt->execute();
    $member = $stmt->fetch();

    if ($member == null) {
        //登録されていなければinsert
        $sql =
      "INSERT INTO users(user_name, mail, pass, status) VALUES (:user_name, :mail, :pass, 1)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(":user_name", $user_name);
        $stmt->bindValue(":mail", $mail);
        $stmt->bindValue(":pass", $pass);
        $stmt->execute();
        $_SESSION["success"] = "会員登録が完了しました。";
    } else {
        $_SESSION["error"] = "同じメールアドレスが存在します。";
    }

    $dbh->commit();
} catch (Exception $e) {
    $dbh->rollBack();
    echo "失敗しました。" . $e->getMessage();
}

// DB処理成功の可否に応じてリダイレクト先を変更
if ($_SESSION["success"]) {
    header("Location: ./login_form.php");
} else {
    header("Location: ./signup.php");
}