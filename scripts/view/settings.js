"use strict";
$(function () {
    var baseRow = $(".gpios .row.hidden");
    var createFolderRow = function (values) {
        baseRow.find("select").selectpicker("destroy");
        var clone = baseRow.clone();
        clone.removeClass("hidden");
        if (values) {
            for (var i in values) {
                var e = clone.find("[name='gpio[" + i + "][]']");
                e.val(values[i]);
            }
        }
        $(".gpios").append(clone);
        clone.find("select").selectpicker();
    };
    // set all gpio
    (function () {
        if (owg.gpios && owg.gpios.length) {
            for (var i in owg.gpios) {
                createFolderRow(owg.gpios[i]);
            }
        } else {
            createFolderRow();
        }
    })();

    // set all setting values
    (function () {
        if (owg.settings) {
            for (var i in owg.settings) {
                var f = $("form").find("[name='setting[" + i + "]']");
                if (f.hasClass("selectpicker")) {
                    f.selectpicker("val", owg.settings[i]);
                } else {
                    f.val(owg.settings[i]);
                }
            }
        }
    })();
    // bind add gpio and delete gpio clicks
    $("form").on("click", ".add-gpio", function () {
        createFolderRow();
    }).on("click", ".delete-gpio", function () {
        $(this).closest(".row").remove();
        if ($("form .gpios .row").not(".hidden").length == 0) {
            createFolderRow();
        }
    });
});