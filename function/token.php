<?php
// CSRF対策用トークンを生成する関数

// トークンを生成し、セッションに保存
function set_token()
{
  if (!isset($_SESSION["token"])) {
    $_SESSION["token"] = bin2hex(random_bytes(32));
  }
}

function check_token()
{
  if (
    empty($_POST["token"]) ||
    htmlspecialchars($_POST["token"]) != $_SESSION["token"]
  ) {
    $_SESSION["error"] = "不正な処理が行われました。";
    exit();
  } else {
    unset($_SESSION["token"]);
  }
}