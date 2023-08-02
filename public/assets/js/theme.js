if ("undefined" == typeof jQuery) throw new Error("jQuery plugins need to be before this file");

function toggleFullScreen(e) {
    void 0 !== document.fullScreenElement && null === document.fullScreenElement || void 0 !== document.msFullscreenElement && null === document.msFullscreenElement || void 0 !== document.mozFullScreen && !document.mozFullScreen || void 0 !== document.webkitIsFullScreen && !document.webkitIsFullScreen ? e.requestFullScreen ? e.requestFullScreen() : e.mozRequestFullScreen ? e.mozRequestFullScreen() : e.webkitRequestFullScreen ? e.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT) : e.msRequestFullscreen && e.msRequestFullscreen() : document.cancelFullScreen ? document.cancelFullScreen() : document.mozCancelFullScreen ? document.mozCancelFullScreen() : document.webkitCancelFullScreen ? document.webkitCancelFullScreen() : document.msExitFullscreen && document.msExitFullscreen()
}

window.addEventListener("load", () => {
    // document ready
}), $(function () {
    "use strict";
    document.documentElement;
    $(".menu-toggle").on("click", function () {
        $(".sidebar").toggleClass("open")
    }), $(".btn-right a").on("click", function () {
        $(".rightbar").toggleClass("open")
    }), $(".sidebar-mini-btn").on("click", function () {
        $(".sidebar").toggleClass("sidebar-mini")
    }), $(".hamburger-icon").on("click", function () {
        $(this).toggleClass("active")
    }), $(".inbox .fa-star").on("click", function () {
        $(this).toggleClass("active")
    }), $(".main-search input").on("focus", function () {
        $(".search-result").addClass("show")
    }), $(".main-search input").on("blur", function () {
        setTimeout(function () {
            $(".search-result").removeClass("show")
        }, 200)
    }), $(".font_setting input:radio").on("click", function () {
        var e = $("[name='" + this.name + "']").map(function () {
            return this.value
        }).get().join(" ");
        console.log(e), $("body").removeClass(e).addClass(this.value)
    }), $("#font_apply").on("click", function () {
        var e = $("#font_url").val(), t = $("#font_family").val(), o = $("head");
        $("body").css("font-family", t), o.append('<link href="' + e + '" rel="stylesheet" data-type="font-url">'), e && t && $(".font_setting input[name=font]").attr("disabled", !0)
    }), $("#font_cancel").on("click", function () {
        var e = $("link").filter(function () {
            if ("font-url" == $(this)[0].getAttribute("data-type")) return $(this)[0]
        });
        $("body").css("font-family", ""), e[0].remove(), $("#font_url").val(""), $("#font_family").val("");
        $(".font_setting input[name=font]").attr("disabled", !1)
    }), $(".select-all.form-check-input").on("change", function () {
        var t = $(this).is(":checked"),
            e = $(this).parent().parent().parent().parent().parent().find(".row-selectable");
        0 < e.length && e.each(function (e) {
            $(this).find(".form-check-input")[0].checked = t
        })
    }), document.getElementById("NotificationsDiv") && document.getElementById("NotificationsDiv").addEventListener("click", function (e) {
        e.stopPropagation()
    });
    [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).map(function (e) {
        return new bootstrap.Tooltip(e)
    })
}), $(function () {
    $(".password-meter .form-control").on("input", function () {
        var e = 0, t = $(this).val(), o = new RegExp("[A-Z]"), c = new RegExp("[a-z]"), n = new RegExp("[0-9]"),
            r = new RegExp("^(?=.*?[#?!@$%^&*-]).{1,}$");
        7 < t.length && e++, 0 < t.length && t.match(o) && e++, 0 < t.length && t.match(c) && e++, 0 < t.length && t.match(n) && e++, 0 < t.length && t.match(r) && e++, $(".password-meter .progress-bar")[0].style.width = 20 * e + "%"
    })
}), $(function () {
    $(".image-input .form-control").on("change", function () {
        var e = URL.createObjectURL(this.files[0]);
        $(this).parent().parent().children(".avatar-wrapper")[0].style.background = "url(" + e + ") no-repeat"
    })
}), $(function () {
    $(".card-fullscreen").on("click", function (e) {
        return $(this).closest("div.card").toggleClass("fullscreen"), e.preventDefault(), !1
    })
}), document.onkeydown = function (e) {
    return 123 != event.keyCode && !(e.ctrlKey && e.shiftKey && e.keyCode == "I".charCodeAt(0) || e.ctrlKey && e.shiftKey && e.keyCode == "C".charCodeAt(0) || e.ctrlKey && e.shiftKey && e.keyCode == "J".charCodeAt(0) || e.ctrlKey && e.keyCode == "U".charCodeAt(0)) && void 0
}, $(document).on("contextmenu", function (e) {
    return !1
});
var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date;
!function () {
    var e = document.createElement("script"), t = document.getElementsByTagName("script")[0];
    e.async = !0, e.src = "https://embed.tawk.to/5c6d4867f324050cfe342c69/default", e.charset = "UTF-8", e.setAttribute("crossorigin", "*"), t.parentNode.insertBefore(e, t)
}();
