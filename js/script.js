$(function () {
  /*======================================================
    モーダルの挙動 
   ======================================================*/
  var scrollPos;
  $(".js-modal-open").click(function () {
    scrollPos = $(window).scrollTop();
    $("body").addClass("no_scroll").css({ top: -scrollPos });
    var id = $(this).data("id");
    $("#overlay, .modal-window[data-id='modal-" + id + "']").fadeIn();
    if ($(this).attr("id") == "form_btn") {
      var form_user_name = $("#form_user_name");
      var form_title = $("#form_title");
      var user_name = $("#user_name").val();
      var title = $("#title").val();
      form_user_name.html(user_name);
      form_title.html(title);
    }
    if ($(this).attr("id") == "form_thread_btn") {
      var form_user_name = $("#form_user_name");
      var form_title = $("#form_title");

      var user_name = $("#user_name").val();
      var title = $("#title").val();

      if (user_name == "") {
        user_name = "ゲスト";
      }
      form_user_name.html(user_name);
      form_title.html(title);
    }
    if ($(this).attr("id") == "form_comment_btn") {
      var form_user_name = $("#form_user_name");
      var form_comment = $("#form_comment");
      var user_name = $("#user_name").val();
      var comment = $("#comment").val();
      if (user_name == null) {
        user_name = "ゲスト";
      }
      form_user_name.html(user_name);
      form_comment.html(comment);
    }
  });

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
});
