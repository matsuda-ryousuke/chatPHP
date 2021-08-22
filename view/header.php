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
                <div>
                    <i class="far fa-comments"></i>
                    <p>まっちゃんねる</p>
                </div>
            </div>
        </a>

        <div>
            <nav class="header-nav">
                <div class="header-infos">

                    <form action="./search.php" method="get">
                        <input type="text" name="search" id="search" maxlength="<?php echo THREAD_TITLE_LENGTH; ?>"
                            class="fa" placeholder="&#xf002; 検索内容を入力">
                        <button type="submit" class="header-search-btn"></button>
                    </form>

                    <?php if (isset($_SESSION["login_id"])): ?>


                    <a href="./user_config.php" class="a-btn"><span class="a-btn-icon"><i
                                class="fas fa-user-cog"></i></span><span class="a-btn-text">ユーザー設定</span></a>
                    <a href="./process/logout.php" class="a-btn js-modal-open a-logout" data-id="logout"><span
                            class="a-btn-icon"><i class="fas fa-sign-out-alt"></i></span><span
                            class="a-btn-text">ログアウト</span></a>
                    <!-- ↓モーダル↓ -->
                    <div id="overlay" class="overlay"></div>
                    <div class="form-window modal-window" data-id="modal-logout">
                        <p class="modal-secttl">ログアウトしますか？</p>

                        <form action="./process/logout.php" method="post">

                            <div class="modal-btns">

                                <div class="cancel-div">
                                    <button type="button"
                                        class="reset submit-btn submit-btn-cancel submit-btn-cancel-user js-modal-close"
                                        id="close">
                                        キャンセル
                                    </button>
                                </div>
                                <div class="submit-div">
                                    <button type="submit" name="submit"
                                        class="reset submit-btn submit-btn-user js-modal-open-form"
                                        id="submit-btn">ログアウト</button>
                                </div>
                            </div>
                        </form>

                    </div>
                    <!-- ↑モーダル↑ -->


                    <?php else: ?>
                    <a href="./login_form.php" class="a-btn"><span class="a-btn-icon"><i
                                class="fas fa-sign-in-alt"></i></span><span class="a-btn-text">ログイン</span></a>
                    <?php endif; ?>
                </div>

            </nav>
            <div class="toggle_btn" id="btn13">
                <div class="nav-btns">
                    <div class="nav-box nav-search">
                        <i class="fas fa-search"></i>
                        <div class="nav-text">検索</div>
                    </div>
                    <!-- スマホ用の検索フォーム -->
                    <div class="header-under">
                        <form action="./search.php" method="get">
                            <input type="text" name="search" id="search-responsive" class="fa"
                                placeholder="&#xf002; 検索内容を入力">
                        </form>
                    </div>


                    <?php if (isset($_SESSION["login_id"])): ?>

                    <a href="./user_config.php">
                        <div class="nav-box">
                            <i class="fas fa-user-cog"></i>
                            <div class="nav-text">ユーザー設定</div>
                        </div>
                    </a>

                    <a href="./process/logout.php" class="js-modal-open a-logout" data-id="logout">
                        <div class="nav-box">
                            <i class="fas fa-sign-out-alt"></i>
                            <div class="nav-text">ログアウト</div>
                        </div>
                    </a>


                    <?php else: ?>

                    <a href="./login_form.php">
                        <div class="nav-box">
                            <i class="fas fa-sign-in-alt"></i>
                            <div class="nav-text">ログイン</div>
                        </div>
                    </a>
                    <?php endif; ?>
                </div>

            </div>
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