$(() => {
  $(".btn-comment").on("click", function (e) {
    e.preventDefault();
    $("#comment-text").val("");
    $("#comment-text").removeClass("is-valid");
    $("#comment-text").removeClass("is-invalid");

    $("#modal-comment").modal("show");
  });

  $(".btn-comment-edit").on("click", function (e) {
    e.preventDefault();
    $("#comment-pjax").data("close", 0);
    $.pjax.reload("#comment-pjax", {
      url: $(this).attr("href"),
      push: false,
      replace: false,
      timeout: 5000,
    });
    $("#modal-comment").modal("show");
  });

  $("#comment-pjax").on("pjax:end", function () {
    if ($(this).data("close")) {
      $("#modal-comment").modal("hide");
      $.pjax.reload("#product-comments-pjax");
      $(".btn-comment").addClass("d-none");
    } else {
      $(this).data("close", 1);
    }
  });

  $("#modal-comment").on("click", ".btn-cancel", function (e) {
    e.preventDefault();
    $("#modal-comment").modal("hide");
  });
});
