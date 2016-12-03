"use strict";
$(function () {
    var gpios = $(".gpio-buttons .gpio");
    var readall = function () {
        $.post(window.location.href, {"action": "readall"}, function (data) {
            data = JSON.parse(data);
            if (data) {
                for (var i in data) {
                    var e = gpios.filter("[data-index='" + i + "']");
                    e.find("input").prop("checked", data[i]);
                }
            }
            setTimeout(readall, 1000);
        });
    };
    readall();
    $(document).on("click", ".gpio-buttons .onoffswitch", function () {
        var e = $(this).closest(".gpio");
        console.log(e);
        setTimeout(function () {
            $.post(window.location.href, {
                "action": "set",
                "pin": e.attr("data-pin"),
                "value": e.find("input").prop("checked") ? "1" : "0",
                "mode": e.attr("data-mode")
            });
        }, 50);
    });
});