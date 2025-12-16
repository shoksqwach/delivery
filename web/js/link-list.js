$(() => {
  $("#listform-category_id").on("change", () => {
    const value = $("#listform-category_id").val();
    if (value) {
      $("#listform-subcategory_id").html("");

      $.ajax({
        url: `/dmf/link-list/sub-list?category_id=${value}`,
        success(data) {
          const select = $("#listform-subcategory_id");
          select.append('<option value="">Выберете под-категорию</option>');

          if (data) {
            Object.keys(data).forEach((key) => {
              select.append(`<option value="${key}">${data[key]}</option>`);
            });
          }
        },
      });
    }
  });
});
