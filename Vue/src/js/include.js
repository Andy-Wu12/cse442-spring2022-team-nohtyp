$(function () {
    $.get("navbar.html",function (data) {
        $("#navbar").html(data);
    });
});