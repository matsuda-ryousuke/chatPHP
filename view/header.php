<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/reset.css" />
    <link rel="stylesheet" href="./css/style.css" />
    <script src="https://kit.fontawesome.com/13de7bd245.js" crossorigin="anonymous"></script>
</head>

<body>

    <header class="header">
        <a href="./index.php">
            <div class="header-logo">
            </div>
        </a>

        <div class="header-infos">
            <form action="./search.php" method="get">
                <input type="text" name="search" id="search" class="fa" placeholder="&#xf002; 検索内容を入力">
            </form>

            <?php if (isset($_SESSION["login_id"])): ?>


            <a href="./user_config.php" class="a-btn"><span class="a-btn-icon"><i
                        class="fas fa-user-cog"></i></span><span class="a-btn-text">ユーザー設定</span></a>
            <a href="./process/logout.php" class="a-btn"><span class="a-btn-icon"><i
                        class="fas fa-sign-out-alt"></i></span><span class="a-btn-text">ログアウト</span></a>

            <?php else: ?>
            <a href="./login_form.php" class="a-btn"><span class="a-btn-icon"><i
                        class="fas fa-sign-in-alt"></i></span><span class="a-btn-text">ログイン</span></a>
            <?php endif; ?>
        </div>
    </header>

    <section class="message">
        <?php if (isset($success)): ?>
        <div class="message-success">
            <p>
                <?php echo $success; ?>
            </p>
        </div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
        <div class="message-error">
            <p>
                <?php echo $error; ?>
            </p>
        </div>
        <?php endif; ?>



    </section>