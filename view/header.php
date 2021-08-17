<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/reset.css" />
    <link rel="stylesheet" href="./css/style.css" />

</head>

<body>

    <header class="header">
        <a href="./index.php">
            <div class="header-logo">
            </div>
        </a>

        <form action="./search.php" method="get">
            <input type="text" name="search" id="search">
            <button type="submit">検索</button>
        </form>

        <?php if (isset($_SESSION["login_id"])): ?>
        <a href="./user_config.php"><button type="button" class="header-icon"></button></a><a class="logout"
            href="./process/logout.php"><button type="button" class="header-icon"></button></a>
        <?php else: ?>
        <a href="./login_form.php"> <img class="header-icon" src="image/login.png" alt=""></a>
        <?php endif; ?>
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