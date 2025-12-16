$(() => {
  $("#catalog-pjax").on("click", ".btn-cart-add", function (e) {
    e.preventDefault();
    $.ajax({
      url: $(this).attr("href"),
      method: "POST",
      success(data) {
        if (data) {
          $.ajax({
            url: "/account/cart/get-count",
            method: "POST",
            success(value) {
              $("#cart-items-count").html(value);
            },
          });
        }
      },
    });
  });

  $("#catalog-pjax").on("click", "i.icon-favourite", function (e) {
    $.ajax({
      url: $(this).data("url"),
      method: "POST",
      success(data) {
        if (data) {
          $.pjax.reload("#catalog-pjax");
        }
      },
    });
  });

  $("#catalog-pjax").on("click", ".like, .dislike", function (e) {
    $.ajax({
      url: $(this).data("url"),
      method: "POST",
      success(data) {
        if (data) {
          $.pjax.reload("#catalog-pjax");
        }
      },
    });
  });

  $("#catalog-pjax").on("change", "#catalogserach-category_id", function () {
    $("#form-search").submit();
  });
});
