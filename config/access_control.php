<?php

function access_control()
{

    if (!isset($_SESSION['login_id'])) {
        $_SESSION['error'] = "ログインしていません。";
        header('Location: ./login_form.php');
    }
}
