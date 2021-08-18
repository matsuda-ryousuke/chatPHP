$(function () {
  /*======================================================
    モーダルの挙動 
   ======================================================*/
  // 現在のスクロール量を取得するための変数定義
  var scrollPos;

  // モーダルオープン用ボタンのクリック時
  $(".js-modal-open").click(function () {
    // スレッド作成フォームのボタンクリック時
    if ($(this).attr("id") == "form_thread_btn") {
      // submitせずに、バリデーションチェック
      if ($(this).parent("form").get(0).reportValidity()) {
        // バリデーションOK の場合にモーダル表示
        var form_user_name = $("#form_user_name");
        var form_title = $("#form_title");

        var user_name = $("#user_name").val();
        var title = $("#title").val();

        // ユーザー名が未入力ならば、ゲストとする
        if (user_name == "") {
          user_name = "ゲスト";
        }
        // モーダル内にinputされたデータを描写
        form_user_name.html(user_name);
        form_title.html(title);
        // ボタンクリック時現在のスクロール量を取得
        scrollPos = $(window).scrollTop();
        // 背景をスクロールさせない
        $("body").addClass("no_scroll").css({ top: -scrollPos });
        // data-id = "form"
        var id = $(this).data("id");
        // オーバーレイ、モーダル（data-id が modal-form のもの）をフェードイン
        $("#overlay, .modal-window[data-id='modal-" + id + "']").fadeIn();
      }
    }

    // コメント投稿フォームのボタンクリック時（挙動はスレッド作成時とほぼ同じ）
    if ($(this).attr("id") == "form_comment_btn") {
      if ($(this).parents("form").get(0).reportValidity()) {
        var form_user_name = $("#form_user_name");
        var form_comment = $("#form_comment");
        var user_name = $("#user_name").val();
        var comment = $("#comment").val();
        if (user_name == null) {
          user_name = "ゲスト";
        }
        form_user_name.html(user_name);
        form_comment.html(comment);
        scrollPos = $(window).scrollTop();
        $("body").addClass("no_scroll").css({ top: -scrollPos });
        var id = $(this).data("id");
        $("#overlay, .modal-window[data-id='modal-" + id + "']").fadeIn();
      }
    }

    // ユーザー名変更フォームのボタンクリック時（挙動はスレッド作成時とほぼ同じ）
    if ($(this).attr("id") == "form_user_name_btn") {
      if ($(this).parents("form").get(0).reportValidity()) {
        var form_user_name = $("#form_user_name");
        var user_name = $("#user_name").val();

        form_user_name.html(user_name);
        scrollPos = $(window).scrollTop();
        $("body").addClass("no_scroll").css({ top: -scrollPos });
        var id = $(this).data("id");
        $("#overlay, .modal-window[data-id='modal-" + id + "']").fadeIn();
      }
    }
  });

  // モーダル閉じるボタン、もしくはオーバーレイのクリック時にモーダルをフェードアウト
  $(".js-modal-close, #overlay").click(function () {
    $("body").removeClass("no_scroll");
    $(window).scrollTop(scrollPos);
    $("#overlay, .modal-window").fadeOut();
  });

  /*======================================================
    お気に入りのajax
   ======================================================*/

  $(".comment-thread-favo").on("click", function () {
    // ajaxでお気に入り登録
    console.log($(this).data("id"));
    var data = { thread_id: $(this).data("id") };
    favorite_ajax(data);
    // ajaxに成功時、favoボタンのactiveと非active（色）をスイッチ
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
    } else {
      $(this).addClass("active");
    }
  });
  function favorite_ajax(data) {
    $.ajax({
      type: "POST",
      url: "process/favorite.php",
      data: data,
    }).done(function (data) {
      console.log("ttt");
      console.log(data);
    });
  }

  // ユーザー設定画面での☆クリック時
  $(".favorite-list").click(function (e) {
    var target = $(e.target);
    // クリック対象がアイコンだった場合、aタグの遷移をキャンセル
    if (target.hasClass("favo-icon")) {
      e.preventDefault();
    }
  });
});
