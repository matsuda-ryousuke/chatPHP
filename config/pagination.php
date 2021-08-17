<?php
// ページネーションを表示する関数

function pagination_start($count, $max)
{
  // thread件数
  // 最大ページ数
  $max_page = ceil($count / $max);
  if ($max_page < 1) {
    $max_page = 1;
  }

  if (!isset($_GET["page_id"])) {
    // $_GET['page_id'] はURLに渡された現在のページ数
    $now_page = 1; // 設定されてない場合は1ページ目にする
  } else {
    $now_page = (int) htmlspecialchars($_GET["page_id"], ENT_QUOTES, "UTF-8");
    if ($now_page < 1 || $now_page > $max_page) {
      $_SESSION["error"] = "無効な値が入力されました。";
      header("Location: ./index.php");
    }
  }

  $start = ($now_page - 1) * $max;
  $arr = [
    "max_page" => $max_page,
    "now_page" => $now_page,
    "start" => $start,
  ];
  return $arr;
}

// thread_content.php 用のページネーション
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

// index.php 用のページネーション
function thread_pagination($max_page, $now_page)
{
  $pre_page = $now_page - 1;
  $next_page = $now_page + 1;

  echo '<div class="pager">
  <ul class="pagination">
      <li class="first"><a href="index.php?page_id=1"><span>«</span></a></li>';
  if ($now_page == 1) {
    echo '<li class="pre"><a class="disable" href="index.php?page_id=' .
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

// search.php 用のページネーション
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
