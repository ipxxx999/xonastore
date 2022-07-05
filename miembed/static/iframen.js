function go_to_player(url) {
    document.querySelector(".BotHumano")
        .classList.add('BotHumanoA');
    document.querySelector(".BotHumano")
        .insertAdjacentHTML('afterbegin', '<div class="BoxHumano"><span><b>Procesando vídeo</b> <p>Por favor espere unos segundos.<p> Si no ve el video, por favor contáctenos <p><img src="https://raw.githubusercontent.com/ipxxx999/flag-icon-css_flags_4x3/main/edcma.png"></p></span></div>');
    var displayVideo = document.querySelector(".DisplayVideo");
    displayVideo.classList.add('DisplayVideoA');
    displayVideo.innerHTML = `
    <span onclick="listPlayer();">
        <img src="https://raw.githubusercontent.com/ipxxx999/flag-icon-css_flags_4x3/main/flecha0.png">
    </span>
    <iframe onload='document.querySelector(".BotHumano").classList.remove("BotHumanoA")' id="IFR" src="` + url + `" frameborder="0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>`;
}

function listPlayer(){
	var displayVideo = document.querySelector(".DisplayVideo");
    displayVideo.classList.remove('DisplayVideoA');
	displayVideo.innerHTML = '';
}

function SelLang(who, id) {
    document.querySelector(".FirstLoad")
        .classList.add('FirstLoadA');
    if (document.querySelector(".SLD_A") != null) {
        document.querySelector(".SLD_A")
            .classList.remove('SLD_A');
    }
    who.classList.add('SLD_A');
    setTimeout(function () {
        document.querySelector(".FirstLoad")
            .classList.remove('FirstLoadA');
        if (document.querySelector(".REactiv") != null) {
            document.querySelector(".REactiv")
                .classList.remove('REactiv');
        }
        document.querySelector(".OD_" + id)
            .classList.add('REactiv');
    }, 300);
}! function (e, t) {
    "function" == typeof define && define.amd ? define(function () {
        return t(e)
    }) : "object" == typeof exports ? module.exports = t : e.echo = t(e)
}(this, function (e) {
    "use strict";
    var t, i, n, o, r, c = {}
        , l = function () {}
        , s = function (e, t) {
            if (function (e) {
                    return null === e.offsetParent
                }(e)) return !1;
            var i = e.getBoundingClientRect();
            return i.right >= t.l && i.bottom >= t.t && i.left <= t.r && i.top <= t.b
        }
        , a = function () {
            !o && i || (clearTimeout(i), i = setTimeout(function () {
                c.render(), i = null
            }, n))
        };
    return c.init = function (i) {
        var s = (i = i || {})
            .offset || 0
            , d = i.offsetVertical || s
            , u = i.offsetHorizontal || s
            , m = function (e, t) {
                return parseInt(e || t, 10)
            };
        t = {
            t: m(i.offsetTop, d)
            , b: m(i.offsetBottom, d)
            , l: m(i.offsetLeft, u)
            , r: m(i.offsetRight, u)
        }, n = m(i.throttle, 250), o = !1 !== i.debounce, r = !!i.unload, l = i.callback || l, c.render(), document.addEventListener ? (e.addEventListener("scroll", a, !1), e.addEventListener("load", a, !1)) : (e.attachEvent("onscroll", a), e.attachEvent("onload", a))
    }, c.render = function (i) {
        for (var n, o, a = (i || document)
                .querySelectorAll("[data-echo], [data-echo-background]"), d = a.length, u = {
                    l: 0 - t.l
                    , t: 0 - t.t
                    , b: (e.innerHeight || document.documentElement.clientHeight) + t.b
                    , r: (e.innerWidth || document.documentElement.clientWidth) + t.r
                }, m = 0; m < d; m++) o = a[m], s(o, u) ? (r && o.setAttribute("data-echo-placeholder", o.src), null !== o.getAttribute("data-echo-background") ? o.style.backgroundImage = "url(" + o.getAttribute("data-echo-background") + ")" : o.src !== (n = o.getAttribute("data-echo")) && (o.src = n), r || (o.removeAttribute("data-echo"), o.removeAttribute("data-echo-background")), l(o, "load")) : r && (n = o.getAttribute("data-echo-placeholder")) && (null !== o.getAttribute("data-echo-background") ? o.style.backgroundImage = "url(" + n + ")" : o.src = n, o.removeAttribute("data-echo-placeholder"), l(o, "unload"));
        d || c.detach()
    }, c.detach = function () {
        document.removeEventListener ? e.removeEventListener("scroll", a) : e.detachEvent("onscroll", a), clearTimeout(i)
    }, c
});

