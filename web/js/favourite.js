$(() => {
  $("#favourite-pjax").on("click", "i.icon-favourite", function (e) {
    $.ajax({
      url: $(this).data("url"),
      method: "POST",
      success(data) {
        if (data) {
          $.pjax.reload("#favourite-pjax");
        }
      },
    });
  });
});
