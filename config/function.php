<?php
require "config.php";

function database_access()
{
  try {
    $dbh = new PDO(DSN, DB_USER, DB_PASS);
    return $dbh;
  } catch (PDOException $e) {
    die("接続できません: " . $e->getMessage());
  }
}

function database_transaction_value($sql_arr, $value_arr, $dbh)
{
  try {
    $dbh->beginTransaction();

    $stmt_arr = [];

    for ($j = 0; $j < count($sql_arr); $j++) {
      $stmt = $dbh->prepare($sql_arr[$j]);
      for ($i = 1; $i <= count($value_arr[$j]); $i++) {
        $stmt->bindValue($i, $value_arr[$j][$i - 1]);
      }
      $stmt->execute();
      array_push($stmt_arr, $stmt);
    }

    $dbh->commit();
    return $stmt_arr;
  } catch (Exception $e) {
    $dbh->rollBack();
    echo "失敗しました。" . $e->getMessage();
  }
}

function user_from_comment($user_id, $dbh)
{
  // ユーザーIDからユーザー名を取得
  $sql = "select user_name from users where user_id = :user_id";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(":user_id", $user_id);
  $stmt->execute();
  $user_name = $stmt->fetch();
  return $user_name["user_name"];
}

function count_comment($thread_id, $dbh)
{
  // comment_id の最大値を取得
  $sql =
    "select comment_id from comments where thread_id = :thread_id order by comment_id desc limit 1";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(":thread_id", $thread_id);
  $stmt->execute();
  $comment_id = $stmt->fetch();

  if ($comment_id == null) {
    return "0";
  } else {
    return $comment_id["comment_id"];
  }
}

function comment_pagination($max_page, $now_page, $thread_id)
{
  $pre_page = $now_page - 1;
  $next_page = $now_page + 1;

  echo '<div class="pager">
  <ul class="pagination">
      <li class="first"><a href="thread_content.php?id=' .
    $thread_id .
    '&page_id=1"><span>«</span></a></li>';
  if ($now_page == 1) {
    echo '<li class="pre"><a class="disable" href="thread_content.php?id=' .
      $thread_id .
      "&page_id=" .
      $pre_page .
      '"><span><</span>
    </a></li>';
  } else {
    echo '<li class="pre"><a href="thread_content.php?id=' .
      $thread_id .
      "&page_id=" .
      $pre_page .
      '"><span><</span>
    </a></li>';
  }

  for ($i = 1; $i <= $max_page; $i++) {
    // 最大ページ数分リンクを作成
    if ($i == $now_page) {
      // 現在表示中のページ数の場合はリンクを貼らない
      echo '<li><a href="thread_content.php?id=' .
        $thread_id .
        "&page_id=" .
        $i .
        '"><span>' .
        $i .
        "</span></a></li>  ";
    } else {
      echo '<li><a href="thread_content.php?id=' .
        $thread_id .
        "&page_id=" .
        $i .
        '"><span>' .
        $i .
        "</span></a></li>  ";
    }
  }

  if ($now_page == $max_page) {
    echo '<li class="next"><a class="disable" href="thread_content.php?id=' .
      $thread_id .
      "&page_id=" .
      $next_page .
      '"><span>></span></a></li>';
  } else {
    echo '<li class="next"><a href="thread_content.php?id=' .
      $thread_id .
      "&page_id=" .
      $next_page .
      '"><span>></span></a></li>';
  }

  echo '<li class="last"><a href="thread_content.php?id=' .
    $thread_id .
    "&page_id=" .
    $max_page .
    '"><span>»</span></a></li>
  </ul>
  </div>';
}

function thread_pagination($max_page, $now_page)
{
  $pre_page = $now_page - 1;
  $next_page = $now_page + 1;

  echo '<div class="pager">
  <ul class="pagination">
      <li class="first"><a href="index.php?page_id=1"><span>«</span></a></li>';
  if ($now_page == 1) {
    echo '<li class="pre"><a class="disable" href=".php?page_id=' .
      $pre_page .
      '"><span><</span>
    </a></li>';
  } else {
    echo '<li class="pre"><a href="index.php?page_id=' .
      $pre_page .
      '"><span><</span>
    </a></li>';
  }

  for ($i = 1; $i <= $max_page; $i++) {
    // 最大ページ数分リンクを作成
    if ($i == $now_page) {
      // 現在表示中のページ数の場合はリンクを貼らない
      echo '<li><a href="index.php?page_id=' .
        $i .
        '"><span>' .
        $i .
        "</span></a></li>  ";
    } else {
      echo '<li><a href="index.php?page_id=' .
        $i .
        '"><span>' .
        $i .
        "</span></a></li>  ";
    }
  }

  if ($now_page == $max_page) {
    echo '<li class="next"><a class="disable" href="index.php?page_id=' .
      $next_page .
      '"><span>></span></a></li>';
  } else {
    echo '<li class="next"><a href="index.php?page_id=' .
      $next_page .
      '"><span>></span></a></li>';
  }

  echo '<li class="last"><a href="index.php?page_id=' .
    $max_page .
    '"><span>»</span></a></li>
  </ul>
  </div>';
}

function search_pagination($max_page, $now_page, $search)
{
  $pre_page = $now_page - 1;
  $next_page = $now_page + 1;

  echo '<div class="pager">
  <ul class="pagination">
      <li class="first"><a href="search.php?search=' .
    $search .
    '&page_id=1"><span>«</span></a></li>';
  if ($now_page == 1) {
    echo '<li class="pre"><a class="disable" href="search.php?search=' .
      $search .
      "&page_id=" .
      $pre_page .
      '"><span><</span>
    </a></li>';
  } else {
    echo '<li class="pre"><a href="search.php?search=' .
      $search .
      "&page_id=" .
      $pre_page .
      '"><span><</span>
    </a></li>';
  }

  for ($i = 1; $i <= $max_page; $i++) {
    // 最大ページ数分リンクを作成
    if ($i == $now_page) {
      // 現在表示中のページ数の場合はリンクを貼らない
      echo '<li><a href="search.php?search=' .
        $search .
        "&page_id=" .
        $i .
        '"><span>' .
        $i .
        "</span></a></li>  ";
    } else {
      echo '<li><a href="search.php?search=' .
        $search .
        "&page_id=" .
        $i .
        '"><span>' .
        $i .
        "</span></a></li>  ";
    }
  }

  if ($now_page == $max_page) {
    echo '<li class="next"><a class="disable" href="search.php?search=' .
      $search .
      "&page_id=" .
      $next_page .
      '"><span>></span></a></li>';
  } else {
    echo '<li class="next"><a href="search.php?search=' .
      $search .
      "&page_id=" .
      $next_page .
      '"><span>></span></a></li>';
  }

  echo '<li class="last"><a href="search.php?search=' .
    $search .
    "&page_id=" .
    $max_page .
    '"><span>»</span></a></li>
  </ul>
  </div>';
}
