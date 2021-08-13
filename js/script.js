$(function () {
  // thread をクリック時、その要素のthread_id を取得
  $(".thread").click(function () {
    console.log($(this).attr("data-id"));
  });

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
  });

  $(".js-modal-close, #overlay").click(function () {
    $("body").removeClass("no_scroll");
    $(window).scrollTop(scrollPos);
    $("#overlay, .modal-window").fadeOut();
  });
});
