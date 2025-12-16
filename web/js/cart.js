$(() => {
  $("#cart-pjax").on("click", ".cart-btn", function (e) {
    e.preventDefault();
    $.ajax({
      url: $(this).attr("href"),
      method: "POST",
      success: (data) => {
        if (data) {
          $.pjax.reload("#cart-pjax");
        }
      },
    });
  });
});
