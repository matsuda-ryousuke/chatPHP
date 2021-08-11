<?php

function access_control()
{
    if (!isset($_SESSION['id'])) {
        $_SESSION['error'] = "ログインしていません。";
        header('Location: ./login_form.php');
    }
}
