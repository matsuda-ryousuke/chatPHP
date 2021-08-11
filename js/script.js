$(function () {
  // thread をクリック時、その要素のthread_id を取得
  $(".thread").click(function () {
    console.log($(this).attr("data-id"));
  });
});
