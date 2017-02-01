function initializeExternalInterfaces() {
    "use strict";
    window.HabboFlashClient.init(document.getElementById("flash-container"))
}
!function () {
    "use strict";
    var n = "*";
    window.MainApp = {
        postMessage: function (e) {
            window.parent.postMessage(e, n)
        }
    }
}(), function () {
    "use strict";
    var n = !1;
    window.FlashExternalInterface = {}, window.FlashExternalInterface.closeHabblet = function (n) {
        window.MainApp.postMessage({call: "close-habblet", target: n})
    }, window.FlashExternalInterface.disconnect = function () {
        window.MainApp.postMessage({call: "disconnect"})
    }, window.FlashExternalInterface.heartBeat = function () {
        window.HabboFlashClient.started = !0, window.MainApp.postMessage({call: "heartbeat"})
    }, window.FlashExternalInterface.legacyTrack = function (n, e, a) {
        window.HabboFlashClient.started = !0, window.HabboTracking.track(n, e, a)
    }, window.FlashExternalInterface.loadConversionTrackingFrame = function () {
        var n = window.flashvars.unique_habbo_id;
        $("#conversion-tracking").attr("src", "/client/" + n + "/conversion-tracking")
    }, window.FlashExternalInterface.logCrash = function (n) {
        window.HabboFlashClient.started = !0, window.MainApp.postMessage({call: "disconnect"}), window.HabboWebApi.logCrash(n, function (n) {
            n && window.FlashExternalInterface.track("log", "fatal", "Can't log login crash: " + n)
        })
    }, window.FlashExternalInterface.logDebug = function (n) {
        window.FlashExternalInterface.track("log", "debug", n)
    }, window.FlashExternalInterface.logError = function (n) {
        window.HabboFlashClient.started = !0, window.HabboWebApi.logError(n, function (n) {
            n && window.FlashExternalInterface.track("log", "error", "Can't log login error: " + n)
        })
    }, window.FlashExternalInterface.logWarn = function (n) {
        window.FlashExternalInterface.track("log", "warn", n)
    }, window.FlashExternalInterface.logLoginStep = function (e, a) {
        window.FlashExternalInterface.track("clientload", e, a), window.HabboFlashClient.started = !0, n || "client.init.core.running" !== e || (n = !0, window.MainApp.postMessage({call: "hotel-ready"})), window.HabboWebApi.logLoginStep(e, a, function (n) {
            n && window.FlashExternalInterface.track("log", "error", "Can't log login step: " + n)
        })
    }, window.FlashExternalInterface.logout = function () {
        window.MainApp.postMessage({call: "logout"})
    }, window.FlashExternalInterface.openExternalPage = function (n) {
        window.MainApp.postMessage({call: "open-external", target: n})
    }, window.FlashExternalInterface.openHabblet = function (n, e) {
        window.HabboTracking.track("openhablet", "habletid", n);
        var a = window.HabboPageTransformer.transformHabblet(n, e);
        window.FlashExternalInterface.openPage(a)
    }, window.FlashExternalInterface.openWebHabblet = function (n, e) {
        window.HabboTracking.track("openwebhablet", n, e);
        var a = window.HabboPageTransformer.transformHabblet(n, e);
        window.FlashExternalInterface.openPage(a)
    }, window.FlashExternalInterface.openPage = function (n) {
        n = window.HabboPageTransformer.translate(n), window.HabboTracking.track("openpage", "", n), window.MainApp.postMessage({
            call: "open-page",
            target: n
        })
    }, window.FlashExternalInterface.track = function (n, e, a) {
        window.HabboFlashClient.started = !0, window.HabboTracking.track(n, e, a)
    }, window.FlashExternalInterface.updateFigure = function (n) {
        window.MainApp.postMessage({call: "update-figure", target: n})
    }, window.FlashExternalInterface.updateName = function (n) {
        window.MainApp.postMessage({call: "update-name", target: n})
    }, window.FlashExternalInterface.openMinimail = function (n) {
        window.HabboTracking.track("minimail", "open", n), window.MainApp.postMessage({call: "open-page", target: "/"})
    }, window.FlashExternalInterface.openNews = function () {
        window.HabboTracking.track("news", "open", ""), window.MainApp.postMessage({call: "open-page", target: "/"})
    }, window.FlashExternalInterface.openAvatars = function () {
        window.FlashExternalInterface.openPage("/settings/avatars")
    }, window.FlashExternalInterface.showInterstitial = function () {
        window.MainApp.postMessage({call: "show-interstitial"})
    }, window.FlashExternalInterface.subscriptionUpdated = function (n) {
        window.MainApp.postMessage({call: "update-habbo-club", target: n})
    }, window.FlashExternalInterface.updateBuildersClub = function (n) {
        window.MainApp.postMessage({call: "update-builders-club", target: n})
    }
}(), function () {
    "use strict";
    function n(n) {
        if (n.data) {
            var t = n.data;
            switch (console.log("Received event, with call: " + t.call), t.call) {
                case"open-link":
                    e(t.target);
                    break;
                case"open-room":
                    a(t.target);
                    break;
                case"interstitial-status":
                    o(t.target)
            }
        }
    }

    function e(n) {
        t.openlink(n)
    }

    function a(n) {
        n.indexOf("r-hh") >= 0 ? t.openroom(n) : e("navigator/goto/" + n)
    }

    function o(n) {
        window.HabboFlashClient.flashInterface.interstitialCompleted(n)
    }

    var t;
    window.addEventListener("message", n, !1), window.HabboFlashClient = {
        started: !1, init: function (n) {
            window.HabboTracking.track("clientload", "starting", "Initalizing Habbo Client."), window.FlashExternalInterface.logLoginStep("web.view.start"), n || (console.error("Invalid FlashClient. Can't use JS->Flash interface."), window.FlashExternalInterface.logLoginStep("web.flash_missing")), t = n, window.HabboFlashClient.flashInterface = n, setTimeout(function () {
                window.HabboFlashClient.started || window.FlashExternalInterface.logLoginStep("client.init.swf.error")
            }, 3e4)
        }
    }
}(), window.addEventListener("load", initializeExternalInterfaces, !1), function () {
    "use strict";
    function n(n, e) {
        return 0 === n.indexOf(e)
    }

    var e = {"/credits": "/shop", "/creditflow": "/shop", "/news": "/community/category/all/1"};
    window.HabboPageTransformer = {
        translate: function (a) {
            for (var o in e)if (e.hasOwnProperty(o) && n(a, o))return e[o];
            return a
        }, transformHabblet: function (n, e) {
            return "/" + n
        }
    }
}(), function () {
    "use strict";
    function n(n, e) {
        $.ajax({url: n, contentType: "application/json", dataType: "json", type: "GET"}).done(function (n) {
            e(null, n)
        }).fail(function (n) {
            e(n, null)
        })
    }

    window.HabboShopApi = {}, window.HabboShopApi.checkOffer = function (e) {
        n("/shopapi/checkoffer/", e)
    }
}(), function () {
    "use strict";
    var n = function (n, e, a) {
        "console" in window && "log" in console && console.log("action = [" + n + "], label = [" + e + "], value = [" + a + "]")
    };
    window.HabboTracking = {
        track: function (e, a, o) {
            n(e, a, o), "clientload" === e && window.HabboTracking.gaTrack(e, a)
        }, gaTrack: function (n, e) {
            window._gaq && window._gaq.push(["_trackEvent", n, e])
        }
    }
}(), function () {
    "use strict";
    function n(n, e, a) {
        $.ajax({
            url: n,
            contentType: "application/json",
            dataType: "json",
            type: "POST",
            data: JSON.stringify(e)
        }).done(function (n) {
            a(null, n)
        }).fail(function (n) {
            a(n, null)
        })
    }

    window.HabboWebApi = {}, window.HabboWebApi.checkName = function (e, a) {
        n("/api/newuser/name/check", {name: e}, a)
    }, window.HabboWebApi.claimName = function (e, a) {
        n("/api/newuser/name/select", {name: e}, a)
    }, window.HabboWebApi.saveFigure = function (e, a, o) {
        n("/api/user/look/save", {figure: e, gender: a}, o)
    }, window.HabboWebApi.selectRoom = function (e, a) {
        n("/api/newuser/room/select", {roomIndex: e}, a)
    }, window.HabboWebApi.logCrash = function (e, a) {
        n("/api/log/crash", {message: e}, a)
    }, window.HabboWebApi.logError = function (e, a) {
        n("/api/log/error", {message: e}, a)
    }, window.HabboWebApi.logLoginStep = function (e, a, o) {
        n("/api/log/loginstep", {step: e, data: a}, o)
    }
}(), function () {
    "use strict";
    window.NewUserReception = {}, window.NewUserReception.checkName = function (n) {
        console.log('Checking name: "' + n + '"...'), window.HabboWebApi.checkName(n, function (e, a) {
            return e ? (console.error("Checking name failed!"), void window.HabboFlashClient.flashInterface.newUserReceptionCheckNameFailed(n)) : void window.HabboFlashClient.flashInterface.newUserReceptionCheckNameResponse(n, a.code, a.validationResult || [], a.suggestions)
        })
    }, window.NewUserReception.chooseRoom = function (n) {
        console.log('Choosing room: "' + n + '"...'), window.HabboWebApi.selectRoom(n, function (n) {
            return n ? (console.error("Choosing room failed!"), void window.HabboFlashClient.flashInterface.newUserReceptionChooseRoomFailed()) : void window.HabboFlashClient.flashInterface.newUserReceptionChooseRoomResponse()
        })
    }, window.NewUserReception.claimName = function (n) {
        console.log('Claiming name: "' + n + '"...'), window.HabboWebApi.claimName(n, function (e, a) {
            return e ? (console.error("Claiming name failed!"), void window.HabboFlashClient.flashInterface.newUserReceptionClaimNameFailed(n)) : (window.HabboFlashClient.flashInterface.newUserReceptionClaimNameResponse(a.code, a.validationResult, a.suggestions), void("OK" === a.code && window.MainApp.postMessage({
                    call: "update-name",
                    target: n
                })))
        })
    }, window.NewUserReception.logStep = function (n) {
        window.HabboTracking.track("nux", "log", n)
    }, window.NewUserReception.saveOutfit = function (n, e) {
        console.log('Saving outfit: "' + n + '" - "' + e + '"...'), window.HabboWebApi.saveFigure(n, e, function (n, a) {
            return n ? (console.error("Saving outfit failed!"), void window.HabboFlashClient.flashInterface.newUserReceptionSaveOutfitFailed()) : (window.HabboFlashClient.flashInterface.newUserReceptionSaveOutfitResponse(a.figureString, e, "OK"), void window.MainApp.postMessage({
                    call: "update-figure",
                    target: a.figureString
                }))
        })
    }
}(), function () {
    "use strict";
    function n() {
        window._sp_video = new window.SPONSORPAY.Video.Iframe({
            appid: window._sp_appid,
            uid: window.flashvars.account_id,
            height: 1e3,
            width: 1e3,
            display_format: "bare_player",
            greyout: !1,
            callback_on_start: function (n) {
                window.HabboFlashClient.flashInterface.sponsorPayOnStart(n.icon_small)
            },
            callback_no_offers: function () {
                window.HabboFlashClient.flashInterface.sponsorPayNoOffers()
            },
            callback_on_close: function () {
                window.HabboFlashClient.flashInterface.sponsorPayOnClose()
            },
            callback_on_conversion: function () {
                window.HabboFlashClient.flashInterface.sponsorPayOnConversion()
            }
        });
        try {
            window.HabboFlashClient.flashInterface.sponsorPayLoaded()
        } catch (n) {
            console && console.error && console.error(n)
        }
    }

    window.SponsorPay = {
        loadIntegration: function (e) {
            window._sp_appid = e;
            var a = document.createElement("script");
            a.setAttribute("type", "text/javascript"), a.setAttribute("src", "//be.sponsorpay.com/assets/web_client.js"), a.addEventListener("load", n, !1), document.getElementsByTagName("head")[0].appendChild(a)
        }, backgroundLoad: function () {
            window._sp_video.backgroundLoad()
        }, showVideo: function () {
            window._sp_video.showVideo()
        }
    }
}(), function () {
    "use strict";
    function n() {
        window.SSA_CORE.BrandConnect.engage();
        var n = document.getElementById("ssaInterstitialTopBar"), e = n.innerHTML;
        n.innerHTML = "";
        var a = document.createElement("div");
        a.className = "ssaInterstitialTopBarInnerContainerLeft";
        var o = document.createElement("div");
        o.className = "ssaInterstitialTopBarInnerContainerRight";
        var t = document.createElement("div");
        t.className = "ssaTopBarCloseButton", t.setAttribute("onClick", 'SSA_CORE.close("ssaBrandConnect")'), t.innerHTML = "";
        var i = document.createElement("span");
        i.className = "ssaTopBarTextSpan", i.innerHTML = e, a.appendChild(t), a.appendChild(i), n.appendChild(o), n.appendChild(a);
        var s = document.getElementById("ssaInterstitialBottomBar"), r = document.createElement("div");
        r.className = "ssaBottomBarInnerLeft";
        var l = document.createElement("div");
        l.className = "ssaBottomBarInnerRight", s.appendChild(l), s.appendChild(r)
    }

    function e(n) {
        n && n.length > 0 ? window.HabboFlashClient.flashInterface.supersonicAdsOnCampaignsReady(n.length.toString()) : window.HabboFlashClient.flashInterface.supersonicAdsOnCampaignsReady("0")
    }

    function a() {
        window.HabboFlashClient.flashInterface.supersonicAdsOnCampaignOpen()
    }

    function o() {
        window.HabboFlashClient.flashInterface.supersonicAdsOnCampaignClose()
    }

    function t() {
        window.HabboFlashClient.flashInterface.supersonicAdsOnCampaignCompleted()
    }

    function i() {
        var n = document.createElement("script");
        n.setAttribute("src", s), document.getElementsByTagName("head")[0].appendChild(n)
    }

    var s = "https://a248.e.akamai.net/ssastatic.s3.amazonaws.com/inlineDelivery/delivery.min.gz.js", r = window.flashvars || {}, l = r.supersonic_devmode, c = r.supersonic_application_key, w = window.ssa_json = {
        applicationKey: c,
        onCampaignsReady: e,
        onCampaignOpen: a,
        onCampaignClose: o,
        onCampaignCompleted: t,
        pagination: !1,
        customCss: r.supersonic_custom_css
    };
    l ? (r.supersonic_demo_campaigns && (w.demoCampaigns = 1), w.applicationUserId = r.supersonic_admin_id || r.account_id) : w.applicationUserId = r.account_id, window.supersonicAdsCamapaignEngage = n, window.supersonicAdsOnCampaignsReady = e, window.supersonicAdsOnCampaignOpen = a, window.supersonicAdsOnCampaignClose = o, window.supersonicAdsOnCampaignCompleted = t, window.supersonicAdsLoadCampaigns = i
}(), function () {
    "use strict";
    window.TargetedWebOffer = {}, window.TargetedWebOffer.checkOffer = function () {
        console.log("Checking for offer..."), window.HabboShopApi.checkOffer(function (n, e) {
            return n ? void window.HabboFlashClient.flashInterface.targetedWebOfferCheckFailed() : void window.HabboFlashClient.flashInterface.targetedWebOfferCheckResponse(e)
        })
    }
}();