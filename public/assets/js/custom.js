function debounce(func, delay) {
    let debounceTimer;
    return function () {
        const context = this;
        const args = arguments;
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => func.apply(context, args), delay);
    };
}
$('[button-action="show"]').on("click", function () {
    let modalId = $(this).attr("modal-id");
    $.ajax({
        url: $(this).attr("button-url"),
        type: "GET",
        success: function (response) {
            $(".app-main").append(response);
            $(modalId).modal("show");
        },
    });
});
