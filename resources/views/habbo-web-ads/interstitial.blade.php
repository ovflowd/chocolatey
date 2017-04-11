<head>
    <meta charset=UTF-8>
    <title></title>
    <style>body {
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            background-color: #000;
            border: 0;
            color: transparent;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            line-height: 0;
            margin: 0;
            min-height: 100vh;
            overflow: hidden;
            padding: 0;
            position: relative
        }

        .ad {
            height: 360px;
            position: relative;
            width: 640px
        }

        .ad > * {
            background-color: #000
        }

        .ad:not(.ad--started):before {
            -webkit-animation: play 2s steps(10) infinite;
            animation: play 2s steps(10) infinite;
            background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAApQAAABCCAQAAABDPo6sAAADoklEQVR4Ae3daY7cOBgD0Nz/0LPPBxQE96bhmCX4UX9t+dUipjuJrV+/fzoMwzCM/VMvkuf1DQwMDAyZi4cwDAwMDO9o2L78xhEbo29gYGBg+Dkgf3TXwMDAwBAoyusJ8+cxMDAwFAyBotwEZM5mYGBgeAODt5KBgeGLwRAgJBgMgTMnDAwMWzNtFOUmIDvfOYZJy7CEgYEhOV+AkGAcbnhNx7CEgYEh2Q8BQoBx9rFLCoarMDA81pA/NluTAfKGYdIyLCkYrsLA8HRDsB/2Cfmq3DVMWoYlBcNVGBiebgj2wz4hX5X7hr/SMywpGK7CwPAgQ/6MA4ryOMNrOoY1DAwMwX4IEAKM8w2TlmENAwNDsB8ShACDIWCYMDAwhNfmFwglxcDAwJAgBBgMDzJMzjYwTHqGG9aFomwYlNQahj3DpGVYUjAUinIlFBgMtxheUjKsYdgxvKRkWFIx3Lo2ldSdhpn9qSV1kSMNf6VnWFIwXOTYz2KZR1H2DZOzi1JRTvpFqSgn//vaXAm1mnqAYdIyLCkYLnKgYdIyLCkYLnLUZ7GxNhXlfYaL+RXlkYa/UjAoyjt+9VaUDC85uKwZXlIyLCkYbhhnFyWDX/8ZJjcaFOUQigyGBxkmZxsYJk3DTetCUTIwMDAoyraBgYFBUU7+E6JgYGBgYFCUDAwMDIqSgYGBQVHWDQwMDAz+MYeBgYFBUTIwMDAoSgYG/9n7AYZ+Ubp9kMFtlG4fPMbgXu++gcGDOTyQQlEqSobTH/XmEWcXCRk8Zk1RMvi1V1FuGzy411YQjzKcvh2FbRg62zDYCkJR2uDsqKK0sddji9LmYgy2zD2lrB+6VaztanuM9XoMTzFMWoYlPzZMWoYlDzBU14WiZFDWpxomTzH0i7LAWK/11gYGBgaGPMKHwcAwYRjD6UVZYKzXSRoYGCYtw2RxMJz8nSwwrq7BwJBfnllDoCAYjv1OZhEKgmHOeGpJXaRkYAieEZg0hj7fwDBpGZZkDYGCYDj0O7nPyC/N8w0Mk5ZhSd4QKAiGA7+T+4z80jzfwNA+dknBcJGwgaFwbGDqBJeBIV+VHUO+Hhj638k0IzAfA0OiKmuGJS0DQ3K+L04LQDZmOtzAwDCpGBjyM0UZ+Vn6BgYGBgZv5ReDgYGBIfDP64Hz3tjAwMDA8PM7HvJHv7WBgYGB4ceQycYRG6NvYGBgYNinXCf8FvQNDAwMDFnM3kwFAwMDA0OsKA3DMIw/AKOyAonpj9QXAAAAAElFTkSuQmCC);
            content: '';
            height: 64px;
            -ms-interpolation-mode: bicubic;
            image-rendering: -webkit-optimize-contrast;
            image-rendering: -moz-crisp-edges;
            image-rendering: pixelated;
            left: 288px;
            position: absolute;
            top: 148px;
            width: 64px
        }

        @-webkit-keyframes play {
            from {
                background-position: 0
            }
            to {
                background-position: -660px
            }
        }

        @keyframes play {
            from {
                background-position: 0
            }
            to {
                background-position: -660px
            }
        }</style>
</head>
<body>
<div id=adContainer class=ad></div>
<script>!function () {
        "use strict";
        function e() {
            google.ima.settings.setLocale("pt"), google.ima.settings.setVpaidMode(google.ima.ImaSdkSettings.VpaidMode.ENABLED)
        }

        function t() {
            A = new google.ima.AdDisplayContainer(y), A.initialize()
        }

        function n() {
            p = new google.ima.AdsLoader(A), p.addEventListener(google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED, i), p.addEventListener(google.ima.AdErrorEvent.Type.AD_ERROR, s)
        }

        function o() {
            var e = new google.ima.AdsRequest;
            e.adTagUrl = f, e.linearAdSlotWidth = 640, e.linearAdSlotHeight = 360, e.nonLinearAdSlotWidth = 640, e.nonLinearAdSlotHeight = 150, e.setAdWillAutoPlay(!0), p.requestAds(e)
        }

        function i(e) {
            var t = a();
            w = e.getAdsManager(y, t), w.addEventListener(google.ima.AdEvent.Type.LOADED, r), w.addEventListener(google.ima.AdEvent.Type.STARTED, g), w.addEventListener(google.ima.AdEvent.Type.COMPLETE, l), w.addEventListener(google.ima.AdEvent.Type.ALL_ADS_COMPLETED, d), w.addEventListener(google.ima.AdEvent.Type.SKIPPED, d), w.addEventListener(google.ima.AdErrorEvent.Type.AD_ERROR, s);
            try {
                w.init(640, 360, google.ima.ViewMode.FULLSCREEN), w.start()
            } catch (n) {
                s(n)
            }
        }

        function a() {
            var e = new google.ima.AdsRenderingSettings;
            return e.uiElements = [google.ima.UiElements.AD_ATTRIBUTION, google.ima.UiElements.COUNTDOWN], e
        }

        function r() {
            window.parent.postMessage({category: "interstitial", name: "load"}, "*")
        }

        function g() {
            window.parent.postMessage({category: "interstitial", name: "start"}, "*"), y.className += " ad--started"
        }

        function d(e) {
            l(e);
            var t = w.getRemainingTime(), n = E(e.type);
            m(-1 !== v ? {
                category: "interstitial",
                name: n,
                duration: v,
                remaining: -1 === t ? 0 : t
            } : {category: "interstitial", name: n})
        }

        function s(e) {
            var t = e.getError();
            window.Bugsnag && window.Bugsnag.notify(u(t), t.getMessage(), t, "info"), m({
                category: "interstitial",
                name: "error"
            })
        }

        function l(e) {
            var t = e.getAd().getDuration();
            t && (v = t)
        }

        function u(e) {
            return c(google.ima.AdError.ErrorCode, e.getErrorCode())
        }

        function E(e) {
            return e === google.ima.AdEvent.Type.SKIPPED ? "skip" : "complete"
        }

        function m(e) {
            setTimeout(function () {
                window.parent.postMessage(e, "*")
            }, 900)
        }

        function c(e, t) {
            return Object.keys(e).filter(function (n) {
                return e[n] === t
            })[0]
        }

        var A, p, w, v, f = "https://pubads.g.doubleclick.net/gampad/ads?sz=640x360&iu={{$chocolatey->ads->adseneKey}}&impl=s&gdfp_req=1&env=vp&output=vast&unviewed_position_start=1&url=[referrer_url]&description_url=https%3A%2F%2F{{$chocolatey->hotelUrl}}/&correlator=[timestamp]", y = document.getElementById("adContainer");
        window.onload = function () {
            e(), t(), n(), o()
        }, window.onerror = function (e) {
            window.Bugsnag && window.Bugsnag.notifyException(e, "onError", {}, "info"), window.parent.postMessage({
                category: "interstitial",
                name: "error"
            }, "*")
        }
    }();</script>
<script src="https://imasdk.googleapis.com/js/sdkloader/ima3.js" onload=onload onerror=onerror async></script>