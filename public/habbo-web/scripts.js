"use strict";
angular.module("payment.popup", ["config", "google.analytics", "notifier", "popup", "purse.service", "system.data"]).factory("paymentPopup", ["$q", "$translate", "$window", "CONFIG", "SystemData", "googleAnalytics", "notifier", "popup", "purse", function (e, t, o, r, a, n, i, s, l) {
    function c(e) {
        return "/proceed/" + [e.requestPath, e.purchaseParams.countryId, e.purchaseParams.pricePointId, e.purchaseParams.paymentMethodId].join("/")
    }

    function u(e) {
        var t = a.getShopCountry();
        t !== e && n.trackEvent("Payment", "Country changed", "Used: " + e + ", Default: " + t)
    }

    var d = {};
    return d.getItemName = function (o) {
        var r = ["CREDITS_AMOUNT"];
        return o.creditAmount ? (o.doubleCredits && r.push("DOUBLE_CREDITS_PREFIX"), t(r, {value: o.creditAmount}).then(function (e) {
            return _([e.DOUBLE_CREDITS_PREFIX, e.CREDITS_AMOUNT]).compact().join(" ")
        })) : e.when(o.name)
    }, d.sendShopTrackingEvents = function (e, t, r) {
        var a = "Item: " + t + ", Method: " + r;
        switch (e) {
            case"SUCCESS":
                n.trackEvent("Payment", "Succeeded", a), o.piwikTrack && (o._spef.push(["trackGoal", 2, a]), o.piwikTrack());
                break;
            case"PENDING":
                n.trackEvent("Payment", "Pending", a);
                break;
            case"ERROR":
                n.trackEvent("Payment", "Failed", a);
                break;
            default:
                n.trackEvent("Payment", "Aborted", a)
        }
    }, d.open = function (e, t) {
        function a(o) {
            o.originalEvent.data && o.originalEvent.data.status && (p = o.originalEvent.data.status, "SUCCESS" !== p && "PENDING" !== p || (l.update(), u(t.countryCode), d.getItemName(t).then(function (e) {
                var r = o.originalEvent.data.txId, a = o.originalEvent.data.currency,
                    i = o.originalEvent.data.priceInCents, s = _(t.categories).sort().join(", "),
                    l = Number(i / 100).toFixed(2);
                n.trackTransaction(r, e, t.id, s, l, a)
            })), d.sendShopTrackingEvents(p, t.id, e.id))
        }

        function m() {
            "SUCCESS" === p && d.getItemName(t).then(function (e) {
                i.success("SHOP_PAYMENT_SUCCESS", {name: e})
            })
        }

        var p, h = c(e);
        return angular.element(o).on("message", a), s.open(r.shopUrl + h).then(function () {
            m(), angular.element(o).off("message", a)
        })
    }, d
}]), angular.module("sub.product.icons", ["locale", "templates"]).component("habboSubProductIcons", {
    bindings: {subProducts: "<"},
    controllerAs: "SubProductIconsController",
    templateUrl: "shop/payment-details/product-payment-details/sub-product-icons/sub-product-icons.html"
}), angular.module("payment.premium.sms", ["config", "locale", "templates", "voucher.redeem"]).component("habboPremiumSms", {
    bindings: {method: "<"},
    controller: ["CONFIG", function (e) {
        var t = this, o = [e.localizationSite, t.method.localizationKey].join("_");
        t.methodSmallPrintKey = ["SHOP_PAYMENTMETHOD_SMALLPRINT", o].join("_").toUpperCase(), t.methodInstructionKey = ["SHOP_PAYMENTMETHOD_INSTRUCTION", o].join("_").toUpperCase()
    }],
    controllerAs: "PremiumSmsController",
    templateUrl: "shop/payment-details/payment-steps/premium-sms/premium-sms.html",
    transclude: !0
}), angular.module("payment.methods", ["locale", "payment.button", "security", "shop.filters", "templates"]).component("habboPaymentMethods", {
    require: {PaymentStepsController: "^habboPaymentSteps"},
    bindings: {item: "<", selectedCategory: "@"},
    controllerAs: "PaymentMethodsController",
    templateUrl: "shop/payment-details/payment-steps/payment-methods/payment-methods.html"
}), angular.module("payment.disclaimer", ["ngSanitize", "config", "locale", "payment.button", "templates"]).component("habboPaymentDisclaimer", {
    bindings: {
        item: "<",
        method: "<"
    },
    controller: ["CONFIG", function (e) {
        var t = this, o = [e.localizationSite, t.method.localizationKey].join("_");
        t.methodSmallPrintKey = ["SHOP_PAYMENTMETHOD_SMALLPRINT", o].join("_").toUpperCase(), t.methodInstructionKey = ["SHOP_PAYMENTMETHOD_INSTRUCTION", o].join("_").toUpperCase()
    }],
    controllerAs: "PaymentDisclaimerController",
    templateUrl: "shop/payment-details/payment-steps/payment-disclaimer/payment-disclaimer.html"
}), angular.module("payment.button", ["events", "locale", "payment.popup", "security", "templates"]).component("habboPaymentButton", {
    bindings: {
        item: "<",
        method: "<"
    },
    controller: ["$scope", "EVENTS", "Session", "loginModal", "paymentPopup", function (e, t, o, r, a) {
        function n() {
            return _.includes(i, s.method.category)
        }

        var i = ["builders", "subscription"], s = this;
        s.translationKey = n() ? "SHOP_SUBSCRIPTION_SUBSCRIBE_BUTTON" : "SHOP_PAYMENT_BUTTON", s.paymentInProgress = !1, o.hasSession() ? s.purchase = function () {
            s.paymentInProgress = !0, a.open(s.method, s.item).then(function () {
                e.$emit(t.shopPaymentClose)
            })["finally"](function () {
                s.paymentInProgress = !1
            })
        } : s.purchase = r.open
    }],
    controllerAs: "PaymentButtonController",
    templateUrl: "shop/payment-details/payment-steps/payment-button/payment-button.html"
}), angular.module("adyen.service", ["adyen-cse-js", "config"]).factory("adyen", ["$http", "CONFIG", "adyenCse", function (e, t, o) {
    return {
        encryptAndSend: function (r, a, n) {
            var i = {
                number: r.number,
                cvc: r.cvc,
                holderName: r.name,
                expiryMonth: r.expMonth.toString(),
                expiryYear: r.expYear.toString(),
                generationtime: a
            }, s = {
                countryId: n.purchaseParams.countryId,
                pricePointId: n.purchaseParams.pricePointId,
                paymentMethodId: n.id,
                creditCardNonce: o.encrypt(i)
            };
            return e.post(t.shopUrl + "/payment/adyen/", s)
        }
    }
}]), angular.module("adyen-cse-js", ["config"]).factory("adyenCse", ["$window", "CONFIG", function (e, t) {
    var o = t.adyenPublicKey, r = {}, a = e.adyen.encrypt.createEncryption(o, r);
    return a
}]), angular.module("payment.adyen", ["adyen.service", "config", "credit.card", "events", "locale", "notifier", "purse.service", "templates"]).component("habboAdyen", {
    bindings: {
        method: "<",
        item: "<"
    },
    controller: ["$window", "$http", "$scope", "$rootScope", "$translate", "CONFIG", "EVENTS", "adyen", "notifier", "paymentPopup", "purse", function (e, t, o, r, a, n, i, s, l, c, u) {
        var d = this;
        d.state = "AWAITING_INPUT", d.transactionId = "", d.close = function () {
            r.$broadcast(i.accordionClose), r.$broadcast(i.accordionUpdate)
        }, d.showInputForm = function () {
            d.transactionId = "", d.state = "AWAITING_INPUT"
        }, d.onSend = function (e) {
            var o = n.apiUrl + "/public/info/time";
            return t.get(o).then(function (t) {
                var o = new Date(t.data.time).toISOString();
                return s.encryptAndSend(e, o, d.method).then(function (e) {
                    if (e.data.success === !0) u.update(), d.transactionId = e.data.transactionId, d.state = "SUCCESS", d.card = {}, c.getItemName(d.item).then(function (e) {
                        l.success("SHOP_PAYMENT_SUCCESS", {name: e})
                    }), c.sendShopTrackingEvents("SUCCESS", d.item.id, d.method.id); else switch (d.state = "FAILURE", e.data.message) {
                        case"LIMIT_EXCEEDED":
                            d.errorType = "LIMIT_EXCEEDED";
                            break;
                        case"RISK_CHECK_FAILED":
                            d.errorType = "RISK_CHECK_FAILED";
                            break;
                        case"CONNECTION_FAILED:422":
                            d.errorType = "USER_DATA";
                            break;
                        default:
                            Bugsnag.notify("Adyen integration returned unexpected result", {
                                groupingHash: "Payments",
                                response: e.data.message
                            }, "info"), d.errorType = "HTTP_ERROR"
                    }
                })["catch"](function (e) {
                    d.state = "FAILURE", d.errorType = "HTTP_ERROR", d.errorMsg = e.data.errorDetail.content.instructions
                })
            })["catch"](function () {
                l.error("ERROR_SERVER")
            })
        }
    }],
    controllerAs: "AdyenController",
    templateUrl: "shop/payment-details/payment-steps/adyen/adyen.html",
    transclude: !0
}), angular.module("remote.data", []).directive("habboRemoteData", function () {
    function e(e) {
        return "remoteData" + t(e)
    }

    function t(e) {
        return e.charAt(0).toUpperCase() + e.slice(1)
    }

    function o(e) {
        return "$" !== e[0]
    }

    return {
        restrict: "A", require: ["^form", "ngModel"], link: function (t, r, a, n) {
            var i, s = n[0], l = n[1], c = t.$eval(a.habboRemoteData);
            t.$on("remote-data-invalid", function (t, o) {
                _(c).includes(o) && (i = e(o), l.$setValidity(i, !1))
            }), t.$watch(function () {
                return l.$viewValue
            }, function () {
                i && _(s).keys().filter(o).forEach(function (e) {
                    s[e].$setValidity(i, !0)
                })
            })
        }
    }
}), angular.module("password.pattern", []).directive("habboPasswordPattern", function () {
    return {
        require: "ngModel", restrict: "A", link: function (e, t, o, r) {
            function a() {
                var e = r.$viewValue;
                return !e || r.$pristine || i(e)
            }

            function n(e) {
                r.$setValidity("passwordPattern", e)
            }

            function i(e) {
                return /(?=.*[A-Za-z])(?=.*[0-9-=?!@:.])/.test(e)
            }

            e.$watch(a, n)
        }
    }
}), angular.module("password.name", []).directive("habboPasswordName", function () {
    return {
        require: "ngModel", restrict: "A", link: function (e, t, o, r) {
            function a(e) {
                return n && (_(e).includes(n) || _(e).includes(i))
            }

            var n, i;
            o.$observe("habboPasswordName", function (e) {
                n = e, i = n.split("").reverse().join(""), r.$validate()
            }), r.$validators.passwordName = function (e, t) {
                return r.$isEmpty(e) || !a(t)
            }
        }
    }
}), angular.module("password.email", []).directive("habboPasswordEmail", function () {
    return {
        require: "ngModel", restrict: "A", link: function (e, t, o, r) {
            function a(e) {
                return n && (_(e).includes(n) || _(e).includes(i))
            }

            var n, i;
            o.$observe("habboPasswordEmail", function (e) {
                n = e, i = n.split("").reverse().join(""), r.$validate()
            }), r.$validators.passwordEmail = function (e, t) {
                return r.$isEmpty(e) || !a(t)
            }
        }
    }
}), angular.module("matches", []).directive("habboMatches", function () {
    return {
        require: ["^form", "ngModel"], restrict: "A", scope: {habboMatches: "@"}, link: function (e, t, o, r) {
            function a() {
                var t = i[e.habboMatches], o = s.$viewValue;
                return !o || s.$pristine || t.$invalid || t.$viewValue === o
            }

            function n(e) {
                s.$setValidity("matches", e)
            }

            var i = r[0], s = r[1];
            e.$watch(a, n)
        }
    }
}), angular.module("email", []).directive("habboEmail", function () {
    var e = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i;
    return {
        require: "ngModel", restrict: "A", link: function (t, o, r, a) {
            a && a.$validators.email && (a.$validators.email = function (t) {
                return a.$isEmpty(t) || e.test(t)
            })
        }
    }
}), angular.module("password.strength.service", []).factory("passwordStrength", function () {
    var e = "abcdefghijklmnopqrstuvwxyz", t = "01234567890", o = /\d/g, r = "\\!@#$%&/()=?¿",
        a = /[$-\/:-?{-~!^_`\[\]]/g, n = /(?=([a-z]{2}))/g, i = /(?=([A-Z]{2}))/g, s = /(?=(\d{2}))/g, l = /^[0-9]*$/g,
        c = /^([a-z]|[A-Z])*$/g;
    return function (u) {
        var d, m, p, h, f = 0, b = {pos: {}, neg: {}}, g = {pos: {}, neg: {seqLetter: 0, seqNumber: 0, seqSymbol: 0}};
        if (u) {
            for (b.pos.lower = u.match(/[a-z]/g), b.pos.upper = u.match(/[A-Z]/g), b.pos.numbers = u.match(o), b.pos.symbols = u.match(a), b.pos.middleNumber = u.slice(1, -1).match(o), b.pos.middleSymbol = u.slice(1, -1).match(a), g.pos.lower = b.pos.lower ? b.pos.lower.length : 0, g.pos.upper = b.pos.upper ? b.pos.upper.length : 0, g.pos.numbers = b.pos.numbers ? b.pos.numbers.length : 0, g.pos.symbols = b.pos.symbols ? b.pos.symbols.length : 0, p = _.reduce(g.pos, function (e, t) {
                return e + Math.min(1, t)
            }, 0), g.pos.numChars = u.length, p += g.pos.numChars >= 8 ? 1 : 0, g.pos.requirements = p >= 3 ? p : 0, g.pos.middleNumber = b.pos.middleNumber ? b.pos.middleNumber.length : 0, g.pos.middleSymbol = b.pos.middleSymbol ? b.pos.middleSymbol.length : 0, b.neg.consecLower = u.match(n), b.neg.consecUpper = u.match(i), b.neg.consecNumbers = u.match(s), b.neg.onlyNumbers = u.match(l), b.neg.onlyLetters = u.match(c), g.neg.consecLower = b.neg.consecLower ? b.neg.consecLower.length : 0, g.neg.consecUpper = b.neg.consecUpper ? b.neg.consecUpper.length : 0, g.neg.consecNumbers = b.neg.consecNumbers ? b.neg.consecNumbers.length : 0, h = 0; h < e.length - 2; h++) {
                var v = u.toLowerCase();
                m = e.substring(h, parseInt(h + 3, 10)), d = m.split("").reverse().join(""), -1 === v.indexOf(m) && -1 === v.indexOf(d) || g.neg.seqLetter++
            }
            for (h = 0; h < t.length - 2; h++)m = t.substring(h, parseInt(h + 3, 10)), d = m.split("").reverse().join(""), -1 === u.indexOf(m) && -1 === u.toLowerCase().indexOf(d) || g.neg.seqNumber++;
            for (h = 0; h < r.length - 2; h++)m = r.substring(h, parseInt(h + 3, 10)), d = m.split("").reverse().join(""), -1 === u.indexOf(m) && -1 === u.toLowerCase().indexOf(d) || g.neg.seqSymbol++;
            return g.neg.repeated = _(u.toLowerCase().split("")).countBy(function (e) {
                return e
            }).reject(function (e) {
                return 1 === e
            }).reduce(function (e, t) {
                return e + t
            }, 0), f += 4 * g.pos.numChars, g.pos.upper && (f += 2 * (g.pos.numChars - g.pos.upper)), g.pos.lower && (f += 2 * (g.pos.numChars - g.pos.lower)), (g.pos.upper || g.pos.lower) && (f += 4 * g.pos.numbers), f += 6 * g.pos.symbols, f += 2 * (g.pos.middleSymbol + g.pos.middleNumber), f += 2 * g.pos.requirements, f -= 2 * g.neg.consecLower, f -= 2 * g.neg.consecUpper, f -= 2 * g.neg.consecNumbers, f -= 3 * g.neg.seqNumber, f -= 3 * g.neg.seqLetter, f -= 3 * g.neg.seqSymbol, b.neg.onlyNumbers && (f -= g.pos.numChars), b.neg.onlyLetters && (f -= g.pos.numChars), g.neg.repeated && (f -= g.neg.repeated / g.pos.numChars * 10), Math.max(0, Math.min(100, Math.round(f)))
        }
    }
}), angular.module("password.strength.indicator", ["ngAnimate"]).directive("habboPasswordStrengthIndicator", ["$animate", function (e) {
    return {
        restrict: "A", link: function (t, o, r) {
            var a = "10%";
            t.$watch(r.habboPasswordStrengthIndicator, function (t) {
                var r = t + "%";
                e.animate(o, {width: a}, {width: r}), a = r
            })
        }
    }
}]), angular.module("password.strength.filters", []).filter("strengthRating", function () {
    return function (e) {
        switch (Math.round(e / 25)) {
            case 1:
                return "poor";
            case 2:
                return "fair";
            case 3:
                return "ok";
            case 4:
                return "good";
            default:
                return "fail"
        }
    }
}).filter("ratingTranslation", function () {
    return function (e) {
        return "PASSWORD_STRENGTH_RATING_" + e.toUpperCase()
    }
}), angular.module("password.strength", ["locale", "password.strength.filters", "password.strength.indicator", "password.strength.service", "templates"]).component("habboPasswordStrength", {
    require: {FormController: "^form"},
    bindings: {modelValue: "<", modelName: "@"},
    controller: ["$scope", "passwordStrength", function (e, t) {
        var o = this;
        e.$watch("PasswordStrengthController.modelValue", function (e) {
            o.FormController[o.modelName].$valid && (o.score = t(e))
        }), e.$watch("PasswordStrengthController.FormController." + o.modelName + ".$invalid", function (e) {
            e && (o.score = 10)
        })
    }],
    controllerAs: "PasswordStrengthController",
    templateUrl: "common/form/password-new/password-strength/password-strength.html",
    transclude: !0
}), angular.module("voucher.icon", ["templates"]).component("habboVoucherIcon", {
    bindings: {
        credits: "<?",
        product: "<?"
    }, controllerAs: "VoucherIconController", templateUrl: "shop/voucher-redeem/voucher-icon/voucher-icon.html"
}), angular.module("shop.transactions.history", ["locale", "templates"]).component("habboTransactionsHistory", {
    bindings: {
        transactions: "<",
        limitTo: "@"
    },
    controllerAs: "TransactionsHistoryController",
    templateUrl: "shop/transactions/transactions-history/transactions-history.html"
}), angular.module("subscription.thumbnail", ["credit.icon", "locale", "templates"]).component("habboSubscriptionThumbnail", {
    bindings: {item: "<"},
    controllerAs: "SubscriptionThumbnailController",
    templateUrl: "shop/thumbnails/subscription-thumbnail/subscription-thumbnail.html"
}), angular.module("product.thumbnail", ["product.icon", "templates"]).component("habboProductThumbnail", {
    bindings: {item: "<"},
    controllerAs: "ProductThumbnailController",
    templateUrl: "shop/thumbnails/product-thumbnail/product-thumbnail.html"
}), angular.module("offer.thumbnail", ["locale", "product.icon", "templates"]).component("habboOfferThumbnail", {
    bindings: {item: "<"},
    controllerAs: "OfferThumbnailController",
    templateUrl: "shop/thumbnails/offer-thumbnail/offer-thumbnail.html"
}), angular.module("credit.thumbnail", ["credit.icon", "credit.title", "templates"]).component("habboCreditThumbnail", {
    bindings: {item: "<"},
    controllerAs: "CreditThumbnailController",
    templateUrl: "shop/thumbnails/credit-thumbnail/credit-thumbnail.html"
}), angular.module("shop.targeted.offer", ["accordion", "offer.payment.details", "offer.thumbnail", "templates"]).component("habboTargetedOffer", {
    bindings: {offer: "<"},
    controller: function () {
        var e = this;
        e.offerPaymentDetails = {
            imageUrl: e.offer.imageUrl,
            smallImageUrl: e.offer.smallImageUrl,
            name: e.offer.header,
            description: e.offer.description,
            price: e.offer.pricePoint.price,
            paymentMethods: e.offer.pricePoint.paymentMethods
        }
    },
    controllerAs: "TargetedOfferController",
    templateUrl: "shop/store/targeted-offer/targeted-offer.html"
}), angular.module("products", ["accordion", "locale", "product.payment.details", "product.thumbnail", "templates"]).component("habboProducts", {
    bindings: {
        items: "<",
        selectedCategory: "@"
    }, controllerAs: "ProductsController", templateUrl: "shop/store/inventory/products.html"
}), angular.module("shop.inventory", ["credits", "products", "shop.filters", "templates"]).component("habboInventory", {
    bindings: {
        inventory: "<",
        selectedCategory: "@"
    }, controller: ["creditFilter", "paymentFilter", "productFilter", function (e, t, o) {
        var r = this, a = t(r.inventory.pricePoints, r.selectedCategory);
        r.creditItems = e(a), r.productItems = o(a), r.isDoubleCreditsActive = r.inventory.doubleCredits
    }], controllerAs: "InventoryController", templateUrl: "shop/store/inventory/inventory.html"
}), angular.module("credits", ["accordion", "credit.payment.details", "credit.thumbnail", "locale", "templates"]).component("habboCredits", {
    bindings: {
        items: "<",
        selectedCategory: "@"
    }, controllerAs: "CreditsController", templateUrl: "shop/store/inventory/credits.html"
}), angular.module("category.filter", ["locale", "templates"]).component("habboCategoryFilter", {
    bindings: {
        paymentCategories: "<",
        selectedCategory: "="
    }, controller: ["$location", function (e) {
        var t = this;
        t.isActive = function (e) {
            return e === t.selectedCategory || "all" === e && !t.selectedCategory
        }, t.update = function (o) {
            var r = t.selectedCategory;
            t.selectedCategory = "all" === o ? null : o, t.selectedCategory !== r && e.search(_.extend(e.search(), {category: t.selectedCategory}))
        }
    }], controllerAs: "CategoryFilterController", templateUrl: "shop/store/category-filter/category-filter.html"
}), angular.module("subscription.payment.details", ["locale", "payment.info", "payment.steps", "product.icon", "templates"]).component("habboSubscriptionPaymentDetails", {
    bindings: {item: "<"},
    controllerAs: "SubscriptionPaymentDetailsController",
    templateUrl: "shop/payment-details/subscription-payment-details/subscription-payment-details.html"
}), angular.module("product.payment.details", ["payment.info", "payment.steps", "product.icon", "sub.product.icons", "templates"]).component("habboProductPaymentDetails", {
    bindings: {
        item: "<",
        selectedCategory: "@"
    },
    controllerAs: "ProductPaymentDetailsController",
    templateUrl: "shop/payment-details/product-payment-details/product-payment-details.html"
}), angular.module("payment.steps", ["config", "locale", "payment.adyen", "payment.disclaimer", "payment.methods", "payment.premium.sms", "security", "templates"]).component("habboPaymentSteps", {
    bindings: {
        item: "<",
        selectedCategory: "@"
    },
    controller: ["$scope", "CONFIG", "EVENTS", "Session", function (e, t, o, r) {
        function a() {
            i.disclaimerMethod = null, i.premiumSmsMethod = null, i.adyenMethod = null
        }

        function n() {
            e.$emit(o.accordionUpdate)
        }

        var i = this;
        i.user = r.user, i.disclaimerMethod = null, i.premiumSmsMethod = null, i.adyenMethod = null, i.setDisclaimer = function (e) {
            i.disclaimerMethod = e, n()
        }, i.setPremiumSms = function (e) {
            i.premiumSmsMethod = e, n()
        }, i.setAdyen = function (e) {
            i.adyenMethod = e, n()
        }, i.reset = function () {
            a(), n()
        }, i.getMethodTitleKey = function (e) {
            var o = [t.localizationSite, e.localizationKey].join("_");
            return ["SHOP_PAYMENTMETHOD_TITLE", o].join("_").toUpperCase()
        }, e.$on(o.accordionClose, a)
    }],
    controllerAs: "PaymentStepsController",
    templateUrl: "shop/payment-details/payment-steps/payment-steps.html",
    transclude: !0
}), angular.module("payment.info", ["locale", "templates"]).directive("habboPaymentInfo", function () {
    return {
        restrict: "E", scope: {}, templateUrl: function (e, t) {
            return ["shop/payment-details/payment-info/payment-info-", t.type, ".html"].join("")
        }
    }
}), angular.module("offer.payment.details", ["locale", "payment.info", "payment.steps", "templates"]).component("habboOfferPaymentDetails", {
    bindings: {offerPaymentDetails: "<"},
    controllerAs: "OfferPaymentDetailsController",
    templateUrl: "shop/payment-details/offer-payment-details/offer-payment-details.html"
}), angular.module("credit.payment.details", ["credit.icon", "credit.title", "locale", "payment.info", "payment.steps", "templates"]).component("habboCreditPaymentDetails", {
    bindings: {
        item: "<",
        selectedCategory: "@"
    },
    controllerAs: "CreditPaymentDetailsController",
    templateUrl: "shop/payment-details/credit-payment-details/credit-payment-details.html"
}), angular.module("earn.credits.frame", ["locale", "security", "templates"]).component("habboEarnCreditsFrame", {
    bindings: {offerWallUrl: "@"},
    controllerAs: "EarnCreditsFrameController",
    templateUrl: "shop/earn-credits/earn-credits-frame/earn-credits-frame.html"
}), angular.module("credit.card.icon", ["templates"]).component("habboCreditCardIcon", {
    bindings: {
        credits: "<?",
        product: "<?"
    },
    controllerAs: "CreditCardIconController",
    templateUrl: "shop/credit-card-form/credit-card-icon/credit-card-icon.html"
}), angular.module("activation.status", ["locale", "message.container", "notifier", "security", "settings.service", "templates"]).component("habboActivationStatus", {
    controller: ["Session", "notifier", "settings", function (e, t, o) {
        var r = this;
        r.user = e.user, r.resendInProgress = !1, r.isSent = !1, r.resend = function () {
            r.resendInProgress = !0, o.resendActivationEmail().then(function () {
                r.isSent = !0, t.success("ACTIVATION_RESEND_SUCESS")
            })["catch"](function () {
                t.error("ERROR_SERVER")
            })["finally"](function () {
                r.resendInProgress = !1
            })
        }
    }],
    controllerAs: "ActivationStatusController",
    templateUrl: "settings/email-change/activation-status/activation-status.html"
}), angular.module("avatar.selector", ["avatar.service", "imager", "locale", "notifier", "security", "templates"]).component("habboAvatarSelector", {
    bindings: {avatar: "<"},
    controller: ["$window", "Session", "avatar", "notifier", function (e, t, o, r) {
        var a = this;
        a.isSelected = a.avatar.uniqueId === t.user.uniqueId, a.selectionInProgress = !1, a.select = function () {
            a.selectionInProgress = !0, o.select(a.avatar).then(function () {
                e.location.href = "/settings/avatars"
            })["catch"](function () {
                r.error("ERROR_SERVER"), a.selectionInProgress = !1
            })
        }
    }],
    controllerAs: "AvatarSelectorController",
    templateUrl: "settings/avatar-selection/avatar-search/avatar-selector.html"
}), angular.module("avatar.search", ["avatar.selector", "by.name.description.or.motto.filter", "empty.results", "form", "templates"]).component("habboAvatarSearch", {
    bindings: {avatars: "<"},
    controllerAs: "AvatarSearchController",
    templateUrl: "settings/avatar-selection/avatar-search/avatar-search.html"
}), angular.module("avatar.name.check", ["avatar.service"]).directive("habboAvatarNameCheck", ["$q", "avatar", function (e, t) {
    return {
        restrict: "A", require: "ngModel", link: function (o, r, a, n) {
            n.$asyncValidators.name = function (o, r) {
                return r ? t.isNameAvailable(r) : e.when()
            }
        }
    }
}]), angular.module("avatar.create.modal", ["avatar.create.form", "templates", "ui.bootstrap"]).factory("avatarCreateModal", ["$uibModal", function (e) {
    var t, o = {};
    return o.open = function () {
        return t = e.open({
            size: "sm",
            templateUrl: "settings/avatar-selection/avatar-create/avatar-create-modal.html"
        }), t.result
    }, o
}]), angular.module("avatar.create.form", ["avatar.name.check", "avatar.service", "locale", "notifier", "templates"]).component("habboAvatarCreateForm", {
    bindings: {
        onCreate: "&",
        onCancel: "&"
    },
    controller: ["$scope", "avatar", "notifier", function (e, t, o) {
        var r = this;
        r.createInProgress = !1, r.create = function () {
            e.avatarCreateForm.$valid && !e.avatarCreateForm.$pending && (r.createInProgress = !0, t.create(r.name).then(r.onCreate)["catch"](function (e) {
                403 !== e.status && o.error("ERROR_SERVER")
            })["finally"](function () {
                r.createInProgress = !1
            }))
        }
    }],
    controllerAs: "AvatarCreateFormController",
    templateUrl: "settings/avatar-selection/avatar-create/avatar-create-form.html"
}), angular.module("avatar.create", ["avatar.create.modal", "locale", "security", "templates"]).directive("habboAvatarCreate", ["$window", "Session", "avatarCreateModal", "safetyLockModal", function (e, t, o, r) {
    return {
        restrict: "E",
        scope: {avatars: "="},
        templateUrl: "settings/avatar-selection/avatar-create/avatar-create.html",
        link: function (a) {
            function n() {
                o.open().then(function () {
                    e.location.href = "/hotel"
                })
            }

            a.emailVerified = t.user.emailVerified, a.identityVerified = t.user.identityVerified, a.MAX_AVATARS = window.chocolatey.maxAvatars, a.open = function () {
                t.isTrusted() ? n() : r.open().then(n)
            }
        }
    }
}]), angular.module("safety.questions.modal", ["safety.questions.form", "templates", "ui.bootstrap"]).factory("safetyQuestionsModal", ["$uibModal", function (e) {
    var t, o = {};
    return o.open = function () {
        return t = e.open({templateUrl: "settings/account-security/safety-questions/safety-questions-modal.html"}), t.result
    }, o
}]), angular.module("safety.questions.form", ["account.security.service", "form", "locale", "notifier", "safety.question.filters", "templates"]).constant("QUESTIONS", _.range(1, 10).map(function (e) {
    return {questionId: e.toString(), questionKey: "IDENTITY_SAFETYQUESTION_" + e}
})).component("habboSafetyQuestionsForm", {
    bindings: {onSave: "&", onCancel: "&"},
    controller: ["$scope", "QUESTIONS", "accountSecurity", "notifier", function (e, t, o, r) {
        var a = this;
        a.saveInProgress = !1, a.questions = t, a.selectedQuestion1 = a.questions[0], a.selectedQuestion2 = a.questions[1], a.save = function () {
            e.safetyQuestionsForm.$valid && (a.saveInProgress = !0, o.save(a.selectedQuestion1.questionId, a.answer1, a.selectedQuestion2.questionId, a.answer2, a.password).then(function () {
                a.onSave(), r.success("ACCOUNT_SECURITY_SAVED_OK")
            })["catch"](function (t) {
                var o = t.data && t.data.error;
                "invalid_password" === o ? e.$broadcast("remote-data-invalid", "password") : 403 !== t.status && r.error("ERROR_SERVER")
            })["finally"](function () {
                a.saveInProgress = !1
            }))
        }
    }],
    controllerAs: "SafetyQuestionsFormController",
    templateUrl: "settings/account-security/safety-questions/safety-questions-form.html"
}), angular.module("safety.question.filters", []).filter("question", function () {
    return function (e, t) {
        return _.without(e, t)
    }
}), angular.module("security.login.rpx", ["locale", "security.rpx"]).directive("habboRpxLogin", ["$timeout", "rpxSecurity", function (e, t) {
    return {
        restrict: "E",
        scope: {},
        template: '<a class="janrainEngage" translate="LOGIN_RPX"></a>',
        link: function (o, r) {
            var a = e(t.init);
            r.on("$destroy", function () {
                e.cancel(a), t.destroy()
            })
        }
    }
}]), angular.module("security.facebook.connect", ["locale", "notifier", "security.service", "templates"]).component("habboFacebookConnect", {
    bindings: {
        onLogin: "&",
        translationKey: "@"
    }, controller: ["notifier", "security", function (e, t) {
        var o = this;
        o.loginInProgress = !1, o.fbLogin = function () {
            o.loginInProgress = !0, t.fbLogin().then(o.onLogin)["catch"](function (t) {
                var o = t.data && t.data.message;
                "fb.sdk_not_loaded" === o ? e.error("ERROR_FB_SDK") : "unknown" !== t.status && "force.pending" !== t.status && e.error("ERROR_SERVER")
            })["finally"](function () {
                o.loginInProgress = !1
            })
        }
    }], controllerAs: "FacebookConnectController", templateUrl: "security/login/facebook-connect/facebook-connect.html"
}), angular.module("recover.password.modal", ["claim.password.form", "locale", "templates", "ui.bootstrap"]).controller("RecoverPasswordController", ["email", function (e) {
    var t = this;
    t.email = e
}]).factory("recoverPasswordModal", ["$uibModal", function (e) {
    var t = {};
    return t.open = function (t) {
        return e.open({
            controller: "RecoverPasswordController",
            controllerAs: "RecoverPasswordController",
            resolve: {email: _.constant(t)},
            size: "sm",
            templateUrl: "security/login/claim-password/recover-password-modal.html"
        }).result
    }, t
}]), angular.module("claim.password.form", ["form", "locale", "notifier", "password.reset.service", "templates"]).component("habboClaimPasswordForm", {
    bindings: {
        cancel: "&",
        emailAddress: "<?"
    },
    controller: ["$scope", "notifier", "passwordReset", function (e, t, o) {
        var r = this;
        r.sent = !1, r.sendingInProgress = !1, r.send = function () {
            e.claimPasswordForm.$valid && (r.sendingInProgress = !0, o.send(r.emailAddress).then(function (e) {
                r.emailAddress = e.data.email, r.sent = !0
            })["catch"](function () {
                t.error("ERROR_SERVER")
            })["finally"](function () {
                r.sendingInProgress = !1
            }))
        }
    }],
    controllerAs: "ClaimPasswordFormController",
    templateUrl: "security/login/claim-password/claim-password-form.html",
    transclude: !0
}), angular.module("claim.password", ["claim.password.form", "form", "locale", "templates", "ui.bootstrap"]).factory("claimPasswordModal", ["$uibModal", function (e) {
    var t = {};
    return t.open = function () {
        return e.open({size: "sm", templateUrl: "security/login/claim-password/claim-password-modal.html"}).result
    }, t
}]).component("habboClaimPassword", {
    controller: ["claimPasswordModal", function (e) {
        var t = this;
        t.openModal = e.open
    }],
    controllerAs: "ClaimPasswordController",
    template: '<small><a ng-click="ClaimPasswordController.openModal()" translate="LOGIN_FORGOT_LABEL"></a></small>'
}), angular.module("captcha.modal", ["form", "templates", "ui.bootstrap"]).controller("CaptchaController", ["$scope", "$uibModalInstance", function (e, t) {
    e.$watch("captchaToken", function (e) {
        e && t.close(e)
    })
}]).factory("captchaModal", ["$uibModal", function (e) {
    var t = {};
    return t.open = function () {
        return e.open({
            controller: "CaptchaController",
            size: "sm",
            templateUrl: "security/login/captcha-modal/captcha-modal.html",
            windowClass: "captcha-modal"
        }).result
    }, t
}]), angular.module("security.force.tos.modal", ["locale", "security.force.service", "security.force.tos.form", "templates", "ui.bootstrap"]).factory("forceTOSModal", ["$uibModal", "FORCE", function (e, t) {
    var o = {};
    return o.open = function (o) {
        return e.open({
            size: "sm",
            templateUrl: "security/force/force-tos/force-tos-modal.html"
        }).result.then(function () {
            return o.force = _.without(o.force, t.TOS), o
        })
    }, o
}]), angular.module("security.force.tos.form", ["locale", "notifier", "security.force.service", "templates"]).component("habboForceTosForm", {
    bindings: {
        onDismiss: "&",
        onSuccess: "&"
    }, controller: ["$scope", "force", "notifier", function (e, t, o) {
        var r = this;
        r.acceptInProgress = !1, r.accept = function () {
            r.acceptInProgress = !0, t.acceptTOS().then(function () {
                r.onSuccess(), o.success("FORCED_TOS_CHANGE_SUCCESS")
            })["catch"](function () {
                o.error("ERROR_SERVER")
            })["finally"](function () {
                r.acceptInProgress = !1
            })
        }
    }], controllerAs: "ForceTosFormController", templateUrl: "security/force/force-tos/force-tos-form.html"
}), angular.module("security.force.password.modal", ["locale", "security.force.password.form", "security.force.service", "templates", "ui.bootstrap"]).factory("forcePasswordModal", ["$uibModal", "FORCE", function (e, t) {
    var o = {};
    return o.open = function (o) {
        return e.open({
            size: "sm",
            templateUrl: "security/force/force-password/force-password-modal.html"
        }).result.then(function () {
            return o.force = _.without(o.force, t.password), o
        })
    }, o
}]), angular.module("security.force.password.form", ["form", "locale", "notifier", "security.force.service", "templates"]).component("habboForcePasswordForm", {
    bindings: {
        onDismiss: "&",
        onSuccess: "&"
    },
    controller: ["$scope", "force", "notifier", function (e, t, o) {
        var r = this;
        r.changeInProgress = !1, r.passwords = {}, r.change = function () {
            e.forcePasswordChangeForm.$valid && (r.changeInProgress = !0, t.changePassword(r.passwords.password).then(function () {
                r.onSuccess(), o.success("PASSWORD_CHANGE_SUCCESS")
            })["catch"](function (t) {
                var r = t.data && t.data.error;
                "password.too_similar_to_username" === r ? e.$broadcast("remote-data-invalid", "passwordName") : "password.too_similar_to_email" === r ? e.$broadcast("remote-data-invalid", "passwordEmail") : "password.used_earlier" === r ? e.$broadcast("remote-data-invalid", "passwordUsed") : o.error("ERROR_SERVER")
            })["finally"](function () {
                r.changeInProgress = !1
            }))
        }
    }],
    controllerAs: "ForcePasswordFormController",
    templateUrl: "security/force/force-password/force-password-form.html"
}), angular.module("security.force.email.modal", ["locale", "security.force.email.form", "security.force.service", "templates", "ui.bootstrap"]).controller("ForceEmailController", ["emailAddress", function (e) {
    var t = this;
    t.oldEmailAddress = e
}]).factory("forceEmailModal", ["$uibModal", "FORCE", function (e, t) {
    var o = {};
    return o.open = function (o) {
        return e.open({
            controller: "ForceEmailController",
            controllerAs: "ForceEmailController",
            size: "sm",
            templateUrl: "security/force/force-email/force-email-modal.html",
            resolve: {emailAddress: _.constant(o.email)}
        }).result.then(function (e) {
            return o.email = e, o.force = _.without(o.force, t.email), o
        })
    }, o
}]), angular.module("security.force.email.form", ["form", "locale", "notifier", "security.force.service", "templates"]).component("habboForceEmailForm", {
    bindings: {
        oldEmailAddress: "@",
        onDismiss: "&",
        onSuccess: "&"
    }, controller: ["$scope", "force", "notifier", function (e, t, o) {
        var r = this;
        r.saveInProgress = !1, r.save = function () {
            e.forceEmailChangeForm.$valid && (r.saveInProgress = !0, t.changeEmail(r.emailAddress).then(function (e) {
                r.onSuccess({email: e.email}), o.success("EMAIL_FORCE_CHANGE_SUCCESS")
            })["catch"](function (t) {
                var r = t.data && t.data.error;
                "changeEmail.invalid_email" === r ? e.$broadcast("remote-data-invalid", "emailInvalid") : "changeEmail.email_already_in_use" === r ? e.$broadcast("remote-data-invalid", "emailUsedInChange") : o.error("ERROR_SERVER")
            })["finally"](function () {
                r.saveInProgress = !1
            }))
        }
    }], controllerAs: "ForceEmailFormController", templateUrl: "security/force/force-email/force-email-form.html"
}), angular.module("room.icon", ["remove.on.error", "show.on.load", "templates"]).component("habboRoomIcon", {
    bindings: {url: "@"}, controllerAs: "RoomIconController", templateUrl: "profile/item-lists/room-icon/room-icon.html"
}), angular.module("report.service", ["config"]).factory("reporter", ["$http", "CONFIG", function (e, t) {
    function o(e) {
        return t.extraDataUrl + "/private/creation/" + e.id + "/report"
    }

    var r = {};
    return r.sendReport = function (t) {
        return e.post(o(t), {reason: t.reportReason})
    }, r
}]), angular.module("report.modal", ["report.form", "templates", "ui.bootstrap"]).controller("ReportController", ["creation", function (e) {
    var t = this;
    t.creation = e
}]).factory("reportModal", ["$uibModal", function (e) {
    var t, o = {};
    return o.open = function (o) {
        return t = e.open({
            size: "lg",
            controller: "ReportController",
            controllerAs: "ReportController",
            templateUrl: "profile/creation/report/report-modal.html",
            resolve: {creation: _.constant(o)}
        }), t.result
    }, o
}]), angular.module("report.form", ["ngMessages", "locale", "notifier", "report.service", "reported.photos", "templates"]).component("habboReportForm", {
    bindings: {
        creation: "<",
        onSuccess: "&",
        onCancel: "&"
    }, controller: ["$location", "$scope", "notifier", "reportedPhotos", "reporter", function (e, t, o, r, a) {
        var n = this;
        n.sendInProgress = !1, n.reasonCodes = [19, 20, 1, 32, 8], n.send = function () {
            t.reportForm.$valid && (n.sendInProgress = !0, a.sendReport(n.creation).then(function () {
                n.onSuccess(), r.save(n.creation.id), e.path("/community/photos").replace(), o.success("REPORT_SUCCESS")
            })["catch"](function (e) {
                429 === e.status ? o.error("ERROR_TOO_MANY_REPORTS") : 401 !== e.status && o.error("ERROR_SERVER")
            })["finally"](function () {
                n.sendInProgress = !1
            }))
        }
    }], controllerAs: "ReportFormController", templateUrl: "profile/creation/report/report-form.html"
}), angular.module("report", ["locale", "report.modal", "templates"]).component("habboReport", {
    bindings: {creation: "<"},
    controller: ["reportModal", function (e) {
        var t = this;
        t.click = function () {
            e.open(t.creation)
        }
    }],
    controllerAs: "ReportController",
    templateUrl: "profile/creation/report/report.html"
}), angular.module("photo.delete.service", ["ngResource", "config", "storage"]).factory("photoDelete", ["$http", "CONFIG", "httpCache", function (e, t, o) {
    var r = {};
    return r["delete"] = function (r) {
        return e["delete"](t.extraDataUrl + "/private/photo/" + r).then(function () {
            o.shortCache.removeAll()
        })
    }, r
}]), angular.module("photo.delete", ["locale", "photo.delete.service", "security", "templates"]).component("habboPhotoDelete", {
    bindings: {creation: "<"},
    controller: ["$location", "$translate", "$window", "Session", "notifier", "photoDelete", function (e, t, o, r, a, n) {
        function i() {
            n["delete"](s.creation.id).then(function () {
                e.path("/profile/" + r.user.name).replace(), a.success("PHOTO_DELETION_SUCCESS")
            })["catch"](function (e) {
                401 !== e.status && a.error("ERROR_SERVER")
            })
        }

        var s = this;
        s["delete"] = function () {
            t("PHOTO_DELETION_CONFIRMATION").then(function (e) {
                o.confirm(e) && i()
            })
        }
    }],
    controllerAs: "PhotoDeleteController",
    templateUrl: "profile/creation/photo-delete/photo-delete.html"
}), angular.module("interstitial.service", ["client.messenger", "google.analytics"]).factory("interstitial", ["$rootScope", "$timeout", "$window", "clientMessenger", "googleAnalytics", function (e, t, o, r, a) {
    var n = {}, i = 15e3;
    return n.started = !1, n.loaded = !1, n.start = function (s) {
        function l(e) {
            var o = e.originalEvent.data && e.originalEvent.data.category;
            if ("interstitial" === o) {
                var r = e.originalEvent.data && e.originalEvent.data.name;
                b[r] && t(function () {
                    b[r](e.originalEvent.data)
                })
            }
        }

        function c() {
            n.loaded = !0, f = e.$on("$locationChangeStart", function (e) {
                e.preventDefault()
            })
        }

        function u() {
            a.trackEvent("Interstitial", "Start"), t.cancel(g)
        }

        function d(e) {
            var t = _.upperFirst(e.name), o = e.remaining || 0, r = e.duration ? 1e3 * (e.duration - o) : null;
            a.trackEvent("Interstitial", "End", t, r), h("complete")
        }

        function m() {
            a.trackEvent("Interstitial", "Error", "Player"), h("incomplete")
        }

        function p() {
            a.trackEvent("Interstitial", "Error", "Timeout"), h("incomplete")
        }

        function h(e) {
            n.started = !1, n.loaded = !1, t.cancel(g), angular.element(o).off("message", l), f && f(), "midroll" === s && r.handle({interstitial: e})
        }

        var f, b = {load: c, start: u, complete: d, skip: d, error: m}, g = t(p, i);
        angular.element(o).on("message", l), n.started = !0, a.trackEvent("Interstitial", "Init")
    }, n.hasStarted = function () {
        return n.started
    }, n.hasLoaded = function () {
        return n.loaded
    }, n
}]), angular.module("interstitial", ["config", "interstitial.service", "locale", "templates"]).component("habboInterstitial", {
    controller: ["$scope", "CONFIG", "interstitial", function (e, t, o) {
        var r = this;
        r.habboWebAdsUrl = t.habboWebAdsUrl, r.lang = t.lang, e.$watch(o.hasStarted, function (e) {
            r.started = e
        }), e.$watch(o.hasLoaded, function (e) {
            r.loaded = e
        })
    }], controllerAs: "InterstitialController", templateUrl: "hotel/client/interstitial/interstitial.html"
}), angular.module("client.reload", ["locale", "templates"]).component("habboClientReload", {
    bindings: {reload: "&"},
    controllerAs: "ClientReloadController",
    templateUrl: "hotel/client/client-reload/client-reload.html"
}), angular.module("client.error", ["config", "locale", "templates"]).component("habboClientError", {
    controller: ["CONFIG", function (e) {
        var t = this;
        t.appStoreUrl = e.appStoreUrl, t.googlePlayUrl = e.googlePlayUrl
    }], controllerAs: "ClientErrorController", templateUrl: "hotel/client/client-error/client-error.html"
}), angular.module("client.closed", ["hotel.closed", "templates"]).component("habboClientClosed", {templateUrl: "hotel/client/client-closed/client-closed.html"}), angular.module("client.close.expander", ["client.close.expand", "events"]).directive("habboClientCloseExpander", ["$timeout", "EVENTS", function (e, t) {
    return {
        restrict: "A", link: function (o, r) {
            function a() {
                c(), s = e(n, l)
            }

            function n() {
                e(function () {
                    o.$broadcast("expander-shrink")
                })
            }

            function i() {
                e.cancel(s), e(function () {
                    o.$broadcast("expander-expand")
                })
            }

            var s, l = 3e4, c = o.$on(t.clientOpen, a);
            r.mouseenter(i), r.mouseleave(n)
        }
    }
}]), angular.module("client.close.expand", ["ngAnimate"]).directive("habboClientCloseExpand", ["$animate", function (e) {
    return {
        restrict: "A", link: function (t, o) {
            function r() {
                n(), i(c, 0)
            }

            function a() {
                n(), i(l, c)
            }

            function n() {
                c || (c = o.width())
            }

            function i(t, r) {
                s && e.cancel(s), l = r, s = e.animate(o, {width: t}, {width: r})
            }

            var s, l, c;
            t.$on("expander-expand", a), t.$on("expander-shrink", r)
        }
    }
}]), angular.module("local.register.banner", ["config", "language", "locale", "templates"]).component("habboLocalRegisterBanner", {
    controller: ["CONFIG", "language", function (e, t) {
        var o = this, r = t.toSite();
        r && r.hotel !== e.hotel && (o.site = r)
    }],
    controllerAs: "LocalRegisterBannerController",
    templateUrl: "home/register-banner/local-register-banner/local-register-banner.html"
}), angular.module("language", []).factory("language", ["$window", function (e) {
    var t = {};
    return t.toSite = function () {
        var t = e.navigator.language ? e.navigator.language.substr(0, 2) : null;
        switch (t) {
            case"de":
                return {hotel: "hhde", href: "https://www.habbo.de", localization: "DE", title: "Habbo.de"};
            case"en":
                return {hotel: "hhus", href: "https://www.habbo.com", localization: "EN", title: "Habbo.com"};
            case"es":
                return {hotel: "hhes", href: "https://www.habbo.es", localization: "ES", title: "Habbo.es"};
            case"fr":
                return {hotel: "hhfr", href: "https://www.habbo.fr", localization: "FR", title: "Habbo.fr"};
            case"fi":
                return {hotel: "hhfi", href: "https://www.habbo.fi", localization: "FI", title: "Habbo.fi"};
            case"it":
                return {hotel: "hhit", href: "https://www.habbo.it", localization: "IT", title: "Habbo.it"};
            case"nl":
                return {hotel: "hhnl", href: "https://www.habbo.nl", localization: "NL", title: "Habbo.nl"};
            case"pt":
                return {hotel: "hhbr", href: "https://www.habbo.com.br", localization: "PT", title: "Habbo.com.br"};
            case"tr":
                return {hotel: "hhtr", href: "https://www.habbo.com.tr", localization: "TR", title: "Habbo.com.tr"};
            default:
                return null
        }
    }, t
}]), angular.module("moderation.notification", ["google.analytics", "locale", "message.container", "moderation.service", "templates"]).component("habboModerationNotification", {
    controller: ["PhotoModerations", "googleAnalytics", function (e, t) {
        var o = this;
        o.moderations = e.recentModerations(), o.moderations.$promise.then(function (e) {
            e.length > 0 && t.trackEvent("Moderation", "Notification viewed")
        })
    }],
    controllerAs: "ModerationNotificationController",
    templateUrl: "home/news/moderation-notification/moderation-notification.html"
}), angular.module("moderation.service", ["ngResource", "config", "storage"]).factory("PhotoModerations", ["$resource", "CONFIG", "httpCache", function (e, t, o) {
    return e(t.extraDataUrl + "/private/moderations/recentModerations", null, {
        recentModerations: {
            method: "GET",
            isArray: !0,
            cache: o.shortCache
        }
    })
}]), angular.module("discussions", ["avatar", "empty.results", "flash", "locale", "templates"]).component("habboDiscussions", {
    bindings: {items: "<"},
    controller: function () {
        var e = this;
        e.getParticipant = function (e) {
            return _.values(e)[0]
        }
    },
    controllerAs: "DiscussionsController",
    templateUrl: "home/messaging/discussions/discussions.html"
}), angular.module("local.storage", []).factory("localStorage", ["$window", function (e) {
    var t = {};
    return t.get = function (t) {
        try {
            var o = e.localStorage.getItem(t);
            return o ? angular.fromJson(o) : null
        } catch (r) {
            return Bugsnag.notifyException(r, "LocalStorage not supported", {groupingHash: "LocalStorage"}, "info"), null
        }
    }, t.set = function (t, o) {
        try {
            e.localStorage.setItem(t, angular.toJson(o))
        } catch (r) {
            Bugsnag.notifyException(r, "LocalStorage not supported", {groupingHash: "LocalStorage"}, "info")
        }
    }, t
}]), angular.module("cache", ["angular-cache", "config"]).config(["CacheFactoryProvider", function (e) {
    angular.extend(e.defaults, {maxAge: 3e5, deleteOnExpire: "aggressive"})
}]).factory("httpCache", ["CacheFactory", function (e) {
    return {shortCache: e.createCache("shortHttpCache"), longCache: e.createCache("longHttpCache", {maxAge: 36e5})}
}]), angular.module("user.menu", ["encode.uri.component", "false.on.outside.click", "imager", "locale", "router", "security", "templates", "zendesk.url"]).component("habboUserMenu", {
    controller: ["$state", "Session", "notifier", "security", function (e, t, o, r) {
        var a = this;
        a.user = t.user, a.isMyProfileActive = function () {
            return e.is("profile", {name: t.user.name})
        }, a.isSettingsActive = function () {
            return e.includes("settings")
        }, a.logout = function () {
            r.logout()["catch"](function () {
                o.errorSticky("ERROR_LOGOUT_TITLE", "ERROR_LOGOUT_TEXT")
            })
        }
    }], controllerAs: "UserMenuController", templateUrl: "common/header/user-menu/user-menu.html"
}), angular.module("navigation", ["encode.uri.component", "flash", "hotel.button", "locale", "security", "templates"]).component("habboNavigation", {
    bindings: {active: "@"},
    controllerAs: "NavigationController",
    templateUrl: "common/header/navigation/navigation.html"
}), angular.module("hotel.button", ["locale", "templates"]).component("habboHotelButton", {templateUrl: "common/header/hotel-button/hotel-button.html"}), angular.module("header.ad", ["templates"]).component("habboHeaderAd", {
    controller: ["$scope", "$location", function (e, t) {
        function o() {
            n.hasAd = r()
        }

        function r() {
            return !_(a).some(function (e) {
                return _(t.path()).includes(e)
            })
        }

        var a = ["/playing-habbo/help", "/registration", "/reset-password", "/settings", "/shop"], n = this;
        o(), e.$on("$stateChangeSuccess", o)
    }], controllerAs: "HeaderAdController", templateUrl: "common/header/header-ad/header-ad.html"
}), angular.module("validators", ["email", "matches", "password.email", "password.name", "password.pattern", "password.strength", "remote.data"]), angular.module("search", ["locale", "templates"]).component("habboSearch", {
    bindings: {query: "="},
    controllerAs: "SearchController",
    templateUrl: "common/form/search/search.html"
}), angular.module("password.toggle.mask", []).directive("habboPasswordToggleMask", function () {
    return {
        restrict: "A", link: function (e, t, o) {
            function r(e) {
                angular.element(e.currentTarget).toggleClass("active"), o.$set("type", "password" === o.type ? "text" : "password"), t.focus()
            }

            t.after(angular.element("<i/>", {
                "class": "password-toggle-mask__icon", click: r, mousedown: function (e) {
                    e.preventDefault()
                }
            }))
        }
    }
}), angular.module("password.new", ["ngMessages", "locale", "password.strength", "password.toggle.mask", "templates", "validators"]).component("habboPasswordNew", {
    require: {FormController: "^form"},
    bindings: {isNew: "@", passwordNew: "=", passwordNewRepeated: "=", userName: "@", userEmail: "@"},
    controllerAs: "PasswordNewController",
    templateUrl: "common/form/password-new/password-new.html"
}), angular.module("password.current", ["ngMessages", "locale", "templates", "validators"]).component("habboPasswordCurrent", {
    require: {FormController: "^form"},
    bindings: {passwordCurrent: "="},
    controllerAs: "PasswordCurrentController",
    templateUrl: "common/form/password-current/password-current.html"
}), angular.module("email.address", ["ngMessages", "locale", "templates", "validators"]).component("habboEmailAddress", {
    require: {FormController: "^form"},
    bindings: {emailAddress: "="},
    controllerAs: "EmailAddressController",
    templateUrl: "common/form/email-address/email-address.html",
    transclude: !0
}), angular.module("captcha", ["config", "locale", "noCAPTCHA", "templates"]).constant("CAPTCHA_EVENTS", {reset: "captcha-reset"}).component("habboCaptcha", {
    require: {FormController: "^form"},
    bindings: {captchaToken: "="},
    controller: ["$scope", "CAPTCHA_EVENTS", function (e, t) {
        var o = this;
        o.noCaptchaController = {}, o.onExpire = function () {
            o.captchaToken = null
        }, e.$on(t.reset, function () {
            o.noCaptchaController.reset(), o.FormController.captchaToken.$setViewValue(null)
        })
    }],
    controllerAs: "CaptchaController",
    templateUrl: "common/form/captcha/captcha.html"
}), angular.module("columns.profile", ["card", "infinite-scroll", "templates"]).component("habboColumnsProfile", {
    bindings: {items: "<"},
    controllerAs: "ColumnsProfileController",
    templateUrl: "common/columns/columns-profile/columns-profile.html"
}), angular.module("columns.channel", ["avatar", "card", "infinite-scroll", "templates"]).component("habboColumnsChannel", {
    bindings: {items: "<"},
    controllerAs: "ColumnsChannelController",
    templateUrl: "common/columns/columns-channel/columns-channel.html"
}), angular.module("card", ["creation.href", "like", "locale", "templates"]).component("habboCard", {
    bindings: {item: "<"},
    controllerAs: "CardController",
    templateUrl: "common/columns/card/card.html",
    transclude: !0
}), angular.module("ad.double.click", ["config", "locale", "ngDfp", "templates"]).constant("DOUBLE_CLICK_UNITS", {
    inlineRectangle: {
        id: "div-gpt-ad-1",
        size: [300, 250]
    }, leaderboard: {id: "div-gpt-ad-2", size: [728, 90]}, mobileLeaderboard: {size: [320, 50]}
}).config(["DOUBLE_CLICK_UNITS", "DoubleClickProvider", function (e, t) {
    var o = "";
    t.defineSlot(o, [e.inlineRectangle.size], e.inlineRectangle.id).defineSlot(o, [e.leaderboard.size, e.mobileLeaderboard.size], e.leaderboard.id), t.defineSizeMapping(e.leaderboard.id).addSize([768, 0], e.leaderboard.size).addSize([0, 0], e.mobileLeaderboard.size)
}]).component("habboAdDoubleClick", {
    bindings: {unit: "@"},
    controller: ["$scope", "$timeout", "$window", "DOUBLE_CLICK_UNITS", "DoubleClick", function (e, t, o, r, a) {
        function n() {
            var e = o.innerWidth;
            e !== c && (a.refreshAds(l.id), c = e)
        }

        function i() {
            s = t(function () {
                a.refreshAds(l.id)
            })
        }

        var s, l = this, c = o.innerWidth;
        l.id = r[l.unit].id, angular.element(o).on("orientationchange resize", n), e.$on("$stateChangeSuccess", i), e.$on("$destroy", function () {
            t.cancel(s), angular.element(o).off("orientationchange resize", n)
        })
    }],
    controllerAs: "AdDoubleClickController",
    templateUrl: "common/ad-unit/ad-double-click/ad-double-click.html"
}), angular.module("voucher.redeem.service", ["config", "google.analytics"]).factory("voucherRedeem", ["$http", "CONFIG", "googleAnalytics", function (e, t, o) {
    return function (r) {
        return e.post(t.shopUrl + "/voucher/redeem", {voucherCode: r}).then(function (e) {
            return o.trackEvent("Voucher", "Redeemed"), e
        })
    }
}]), angular.module("voucher.redeem", ["events", "form", "locale", "notifier", "purse.service", "templates", "voucher.icon", "voucher.redeem.service"]).component("habboVoucherRedeem", {
    controller: ["$compile", "$scope", "$timeout", "$translate", "EVENTS", "notifier", "purse", "voucherRedeem", function (e, t, o, r, a, n, i, s) {
        function l() {
            t.voucherRedeemForm.$setPristine(), d.voucherCode = ""
        }

        function c(e) {
            return r("VOUCHER_REDEEM_NOTIFICATION_AWARDED").then(function (r) {
                var a = t.$new();
                a.credits = e.data.credits, a.product = e.data.product, a.credits && o(function () {
                    var e = u(a, '<habbo-voucher-icon credits="credits"></habbo-voucher-icon>');
                    n.success(r + " " + e)
                }), a.product && o(function () {
                    var e = u(a, '<habbo-voucher-icon product="product"></habbo-voucher-icon>');
                    n.success(r + " " + e)
                })
            })
        }

        function u(t, o) {
            var r = e(angular.element("<div>" + o + "</div>"))(t);
            return t.$digest(), r.html()
        }

        var d = this;
        d.redeemInProgress = !1, d.redeem = function () {
            (d.redeemInProgress = !0, s(d.voucherCode).then(function (e) {
                return i.update(), c(e)
            })["catch"](function (e) {
                var o = e.data && e.data.error;
                "purse.redeem.code.dont_exist" === o ? t.$broadcast("remote-data-invalid", "nonexistent") : "purse.redeem.code.already_redeemed" === o ? t.$broadcast("remote-data-invalid", "redeemed") : t.$broadcast("remote-data-invalid", "failed")
            })["finally"](function () {
                d.redeemInProgress = !1
            }))
        }, t.$on(a.accordionClose, l), t.$watchGroup(["voucherRedeemForm.$invalid", "voucherRedeemForm.$pristine", "voucherRedeemForm.$submitted"], function () {
            t.$emit(a.accordionUpdate)
        })
    }], controllerAs: "VoucherRedeemController", templateUrl: "shop/voucher-redeem/voucher-redeem.html"
}), angular.module("transactions", ["locale", "router", "shop.purse", "shop.service", "shop.transactions.list", "templates", "voucher.redeem", "web.pages"]).config(["$stateProvider", function (e) {
    e.statePrivate("shop.transactions", {
        url: "/history",
        data: {title: "HEAD_TITLE_SHOP_HISTORY"},
        controller: "TransactionsController",
        controllerAs: "TransactionsController",
        resolve: {
            transactions: ["Shop", function (e) {
                return e.history().$promise
            }]
        },
        parent: "shop",
        templateUrl: "shop/transactions/transactions.html"
    })
}]).controller("TransactionsController", ["transactions", function (e) {
    var t = this;
    t.items = e
}]), angular.module("shop.transactions.list", ["empty.results", "locale", "shop.transactions.history", "templates"]).component("habboTransactionsList", {
    bindings: {transactions: "<"},
    controller: function () {
        var e = this;
        e.transactionLimit = 10, e.showAll = function () {
            e.transactionLimit = 1 / 0, e.hideShowAll = !0
        }
    },
    controllerAs: "TransactionsListController",
    templateUrl: "shop/transactions/transactions-list.html"
}), angular.module("subscriptions", ["events", "locale", "router", "shop.countries", "shop.purse", "templates", "voucher.redeem", "web.pages"]).config(["$stateProvider", function (e) {
    e.statePrivate("shop.subscriptions", {
        url: "/subscriptions",
        parent: "shop",
        data: {title: "HEAD_TITLE_SHOP_SUBSCRIPTIONS"},
        templateUrl: "shop/subscriptions/subscriptions.html"
    })
}]),angular.module("store", ["category.filter", "events", "locale", "router", "shop.countries", "shop.inventory", "shop.purse", "shop.service", "shop.targeted.offer", "templates", "voucher.redeem", "web.pages"]).config(["$stateProvider", function (e) {
    e.statePublic("shop.store", {
        url: "?category",
        controller: "StoreController",
        controllerAs: "StoreController",
        data: {title: "HEAD_TITLE_SHOP"},
        resolve: {
            countries: ["Shop", function (e) {
                return e.countries().$promise
            }], inventory: ["countryCode", "Shop", function (e, t) {
                return t.inventory({countryCode: e}).$promise
            }]
        },
        parent: "shop",
        templateUrl: "shop/store/store.html"
    })
}]).controller("StoreController", ["$interval", "$location", "$scope", "$state", "$stateParams", "EVENTS", "countries", "inventory", "scrolltop", function (e, t, o, r, a, n, i, s, l) {
    var c, u = this;
    u.countries = i, u.offer = s.offer, u.inventory = s, u.selectedCategory = a.category, u.offer && (c = e(function () {
        moment(u.offer.expirationDate).isBefore() && (u.offer = null, e.cancel(c))
    }, 1e3)), o.$on("$stateChangeStart", function (e, t) {
        l.setEnabled("shop.store" !== t.name)
    }), o.$on(n.securityLogin, function () {
        "/shop" === t.path() && r.reload()
    })
}]),angular.module("shop.footer", ["locale", "templates", "zendesk.url"]).component("habboShopFooter", {templateUrl: "shop/shop-footer/shop-footer.html"}),angular.module("shop.countries", ["locale", "templates"]).component("habboShopCountries", {
    bindings: {
        country: "<",
        countries: "<"
    }, controller: ["$scope", "$location", function (e, t) {
        e.$watch("ShopCountriesController.country", function (e, o) {
            var r = e && e.countryCode || null, a = o && o.countryCode || null;
            r && r !== a && t.search({country: r})
        })
    }], controllerAs: "ShopCountriesController", templateUrl: "shop/shop-countries/shop-countries.html"
}),angular.module("purse.service", ["ngResource", "config"]).factory("purse", ["$resource", "CONFIG", function (e, t) {
    var o = {}, r = {
        creditBalance: "...",
        diamondBalance: "...",
        habboClubDays: "...",
        buildersClubDays: "..."
    }, a = e(t.shopUrl + "/purse");
    return o.get = function () {
        return r
    }, o.update = function () {
        a.get().$promise.then(function (e) {
            r = e
        })
    }, o
}]),angular.module("shop.purse", ["config", "locale", "purse.service", "templates"]).component("habboPurse", {
    controller: ["$scope", "purse", function (e, t) {
        var o = this;
        t.update(), e.$watch(t.get, function (e) {
            o.purse = e
        })
    }], controllerAs: "PurseController", templateUrl: "shop/purse/purse.html"
}),angular.module("product.icon", []).component("habboProductIcon", {
    bindings: {iconId: "@"},
    controllerAs: "ProductIconController",
    template: '<div ng-class="\'product-icon--\' + ProductIconController.iconId" class="product-icon"></div>'
}),angular.module("prepaid", ["compile", "locale", "router", "shop.purse", "shop.service", "templates", "voucher.redeem", "web.pages"]).config(["$stateProvider", function (e) {
    e.statePublic("shop.prepaid", {
        url: "/prepaid",
        controller: "PrepaidController",
        controllerAs: "PrepaidController",
        data: {title: "HEAD_TITLE_SHOP_PREPAID"},
        resolve: {
            countries: ["Shop", function (e) {
                return e.countries().$promise
            }], country: ["countries", "countryCode", function (e, t) {
                return _(e).find({countryCode: t}) || _(e).find({countryCode: "all"}) || e[0]
            }], page: ["country", "webPages", function (e, t) {
                return t.get("store/prepaid/prepaid_" + e.countryCode)
            }]
        },
        parent: "shop",
        templateUrl: "shop/prepaid/prepaid.html"
    })
}]).controller("PrepaidController", ["countries", "country", "page", function (e, t, o) {
    var r = this;
    r.countries = e, r.country = t, r.page = o
}]),angular.module("earn.credits", ["earn.credits.frame", "earn.credits.service", "locale", "router", "shop.purse", "templates", "web.pages"]).config(["$stateProvider", function (e) {
    e.statePrivate("shop.earnCredits", {
        url: "/earn-credits",
        controller: "EarnCreditsController",
        controllerAs: "EarnCreditsController",
        data: {title: "HEAD_TITLE_SHOP_EARN_CREDITS"},
        parent: "shop",
        resolve: {
            offerWallUrl: ["OfferWallUrl", function (e) {
                return e.get().$promise
            }]
        },
        templateUrl: "shop/earn-credits/earn-credits.html"
    })
}]).controller("EarnCreditsController", ["offerWallUrl", function (e) {
    var t = this;
    t.offerWallUrl = e
}]),angular.module("earn.credits.service", ["ngResource", "config"]).factory("OfferWallUrl", ["$resource", "CONFIG", function (e, t) {
    return e(t.shopUrl + "/offerwall/url")
}]),angular.module("credit.title", ["locale", "templates"]).component("habboCreditTitle", {
    bindings: {
        amount: "@",
        doubleCredits: "@"
    }, controller: function () {
        var e = this;
        e.isDouble = "true" === e.doubleCredits
    }, controllerAs: "CreditTitleController", templateUrl: "shop/credit-title/credit-title.html"
}),angular.module("credit.icon", ["templates"]).component("habboCreditIcon", {
    bindings: {
        amount: "@",
        doubleCredits: "@"
    }, controller: function () {
        var e = [0, 30, 50, 80, 100, 250, 1e3], t = this;
        t.isDouble = "true" === t.doubleCredits, t.getIndex = function (t) {
            var o = _.curry(function (e, t) {
                return t > e
            });
            return _.findIndex(e, o(parseInt(t, 10)))
        }
    }, controllerAs: "CreditIconController", templateUrl: "shop/credit-icon/credit-icon.html"
}),angular.module("credit.card", ["credit-cards", "credit.card.icon", "events", "form", "locale", "notifier", "purse.service", "templates"]).component("habboCreditCardForm", {
    bindings: {
        onSubmit: "&",
        card: "="
    },
    controller: ["$compile", "$rootScope", "$scope", "$timeout", "$translate", "EVENTS", function (e, t, o, r, a, n) {
        var i = this;
        i.paymentInProgress = !1, i.markActiveAndSubmit = function (e) {
            i.paymentInProgress = !0, i.onSubmit(e).then(function () {
                i.paymentInProgress = !1
            })
        }, o.$watch(function () {
            return _.size(o.creditCardForm.$error)
        }, function () {
            t.$broadcast(n.accordionResize)
        })
    }],
    controllerAs: "CreditCardController",
    templateUrl: "shop/credit-card-form/credit-card-form.html"
}),angular.module("privacy.settings", ["locale", "privacy.settings.form", "privacy.settings.service", "router", "templates"]).config(["$stateProvider", function (e) {
    e.statePrivate("settings.privacy", {
        url: "/privacy",
        controller: "PrivacySettingsController",
        controllerAs: "PrivacySettingsController",
        parent: "settings",
        data: {title: "HEAD_TITLE_PRIVACY_SETTINGS"},
        resolve: {
            privacySettings: ["PrivacySettings", function (e) {
                return e.query().$promise
            }]
        },
        templateUrl: "settings/privacy-settings/privacy-settings.html"
    })
}]).controller("PrivacySettingsController", ["privacySettings", function (e) {
    var t = this;
    t.privacySettings = e
}]),angular.module("privacy.settings.form", ["google.analytics", "locale", "notifier", "privacy.settings.service", "templates"]).component("habboPrivacySettingsForm", {
    bindings: {privacySettings: "<"},
    controller: ["$scope", "googleAnalytics", "notifier", function (e, t, o) {
        var r = this;
        r.save = function () {
            e.privacySettingsForm.$pristine ? o.success("SETTINGS_SAVED_OK") : (r.sendInProgress = !0, r.privacySettings.$save().then(function () {
                t.trackEvent("Privacy settings", "Saved"), o.success("SETTINGS_SAVED_OK"), e.privacySettingsForm.$setPristine()
            })["catch"](function () {
                o.error("ERROR_SERVER")
            })["finally"](function () {
                r.sendInProgress = !1
            }))
        }
    }],
    controllerAs: "PrivacySettingsFormController",
    templateUrl: "settings/privacy-settings/privacy-settings-form.html"
}),angular.module("privacy.settings.service", ["ngResource", "config"]).factory("PrivacySettings", ["$resource", "CONFIG", function (e, t) {
    return e(t.apiUrl + "/user/preferences", {}, {
        query: {method: "GET", isArray: !1},
        save: {method: "POST", url: t.apiUrl + "/user/preferences/save"}
    })
}]),angular.module("password.change", ["locale", "password.change.form", "router", "templates"]).config(["$stateProvider", function (e) {
    e.stateHabboAccountTrusted("settings.password", {
        url: "/password",
        parent: "settings",
        data: {title: "HEAD_TITLE_PASSWORD_CHANGE"},
        templateUrl: "settings/password-change/password-change.html"
    })
}]),angular.module("password.change.form", ["form", "locale", "notifier", "security", "settings.service", "templates"]).component("habboPasswordChangeForm", {
    controller: ["$scope", "Session", "notifier", "settings", function (e, t, o, r) {
        function a() {
            e.changePasswordForm.$setPristine(), n.passwords = {}
        }

        var n = this;
        n.user = t.user, n.updateInProgress = !1, n.update = function () {
            e.changePasswordForm.$valid && (n.updateInProgress = !0, r.changePassword(n.passwords).then(function () {
                a(), o.success("PASSWORD_CHANGE_SUCCESS")
            })["catch"](function (t) {
                if (409 === t.status) {
                    var r = t.data && t.data.error;
                    "password.used_earlier" === r ? e.$broadcast("remote-data-invalid", "passwordUsed") : "password.too_similar_to_username" === r ? e.$broadcast("remote-data-invalid", "passwordName") : "password.too_similar_to_email" === r ? e.$broadcast("remote-data-invalid", "passwordEmail") : e.$broadcast("remote-data-invalid", "password")
                } else 403 !== t.status && o.error("ERROR_SERVER")
            })["finally"](function () {
                n.updateInProgress = !1
            }))
        }
    }], controllerAs: "PasswordChangeFormController", templateUrl: "settings/password-change/password-change-form.html"
}),angular.module("email.change", ["activation.status", "email.change.form", "locale", "router", "templates"]).config(["$stateProvider", function (e) {
    e.stateHabboAccountTrusted("settings.email", {
        url: "/email",
        parent: "settings",
        data: {title: "HEAD_TITLE_EMAIL_CHANGE"},
        templateUrl: "settings/email-change/email-change.html"
    })
}]),angular.module("email.change.form", ["form", "locale", "notifier", "security", "settings.service", "templates"]).component("habboEmailChangeForm", {
    controller: ["$scope", "Session", "notifier", "settings", function (e, t, o, r) {
        function a() {
            e.emailChangeForm.$setPristine(), n.emailChangeData = {}
        }

        var n = this;
        n.user = t.user, n.updateInProgress = !1, n.update = function () {
            e.emailChangeForm.$valid && (n.updateInProgress = !0, r.changeEmail(n.emailChangeData).then(function () {
                a(), o.success("EMAIL_CHANGE_SUCCESS")
            })["catch"](function (t) {
                var r = t.data && t.data.error;
                "registration_email" === r || "changeEmail.invalid_email" === r ? e.$broadcast("remote-data-invalid", "emailInvalid") : "changeEmail.email_already_in_use" === r ? e.$broadcast("remote-data-invalid", "emailUsedInChange") : "changeEmail.invalid_password" === r ? e.$broadcast("remote-data-invalid", "password") : 403 !== t.status && o.error("ERROR_SERVER")
            })["finally"](function () {
                n.updateInProgress = !1
            }))
        }
    }], controllerAs: "EmailChangeFormController", templateUrl: "settings/email-change/email-change-form.html"
}),angular.module("avatar.service", ["config", "google.analytics", "security", "security.session"]).factory("avatar", ["$http", "$q", "CONFIG", "Session", "googleAnalytics", function (e, t, o, r, a) {
    var n = {};
    return n.query = function () {
        return e.get(o.apiUrl + "/user/avatars").then(function (e) {
            return e.data
        })
    }, n.create = function (t) {
        return e.post(o.apiUrl + "/user/avatars", {name: t}).then(function (e) {
            return a.trackEvent("Avatar", "Created"), r.update(e.data), e.data
        })
    }, n.isNameAvailable = function (r) {
        return e.get(o.apiUrl + "/user/avatars/check-name?name=" + r).then(function (e) {
            return e.data.isAvailable ? t.when() : t.reject()
        })
    }, n.select = function (t) {
        return e.post(o.apiUrl + "/user/avatars/select", t).then(function (e) {
            return a.trackEvent("Avatar", "Changed"), r.update(e.data), e.data
        })
    }, n
}]),angular.module("avatar.selection", ["avatar.create", "avatar.search", "avatar.service", "locale", "router", "security", "templates", "security.session"]).config(["$stateProvider", "$urlRouterProvider", function (e, t) {
    e.statePrivate("settings.avatar", {
        url: "/avatars",
        parent: "settings",
        controller: "AvatarSelectionController",
        controllerAs: "AvatarSelectionController",
        data: {title: "HEAD_TITLE_AVATAR_SELECTION"},
        resolve: {
            avatars: ["avatar", function (e) {
                return e.query()
            }]
        },
        templateUrl: "settings/avatar-selection/avatar-selection.html"
    }), t.when("/avatars", "/settings/avatars")
}]).controller("AvatarSelectionController", ["avatars", function (e) {
    var t = this;
    t.avatars = e
}]),angular.module("trusted.locations.reset", ["account.security.service", "locale", "notifier", "templates"]).component("habboTrustedLocationsReset", {
    controller: ["$translate", "$window", "accountSecurity", "notifier", function (e, t, o, r) {
        function a() {
            o.reset().then(function () {
                r.success("ACCOUNT_SECURITY_TRUSTED_LOGINS_RESET_OK")
            })["catch"](function (e) {
                403 !== e.status && r.error("ERROR_SERVER")
            })["finally"](function () {
                n.inProgress = !1
            })
        }

        var n = this;
        n.reset = function () {
            n.inProgress = !0, e("ACCOUNT_SECURITY_RESET_LOCATIONS_CONFIRMATION").then(function (e) {
                t.confirm(e) ? a() : n.inProgress = !1
            })
        }
    }],
    controllerAs: "TrustedLocationsResetController",
    templateUrl: "settings/account-security/trusted-locations-reset.html"
}),angular.module("account.security.service", ["config", "google.analytics"]).factory("accountSecurity", ["$http", "CONFIG", "googleAnalytics", function (e, t, o) {
    var r = {};
    return r.status = function () {
        return e.get(t.apiUrl + "/safetylock/featureStatus").then(function (e) {
            return e.data
        })
    }, r.save = function (r, a, n, i, s) {
        return e.post(t.apiUrl + "/safetylock/save", {
            questionId1: r,
            answer1: a,
            questionId2: n,
            answer2: i,
            password: s
        }).then(function () {
            o.trackEvent("Safety lock", "Questions saved")
        })
    }, r.disable = function () {
        return e.get(t.apiUrl + "/safetylock/disable").then(function () {
            o.trackEvent("Safety lock", "Disabled")
        })
    }, r.reset = function () {
        return e.get(t.apiUrl + "/safetylock/resetTrustedLogins").then(function () {
            o.trackEvent("Safety lock", "Trusted locations reset")
        })
    }, r
}]),angular.module("account.security", ["account.security.edit", "account.security.service", "locale", "router", "templates", "trusted.locations.reset"]).config(["$stateProvider", function (e) {
    e.stateHabboAccountTrusted("settings.security", {
        url: "/security",
        controller: "AccountSecurityController",
        controllerAs: "AccountSecurityController",
        parent: "settings",
        data: {title: "HEAD_TITLE_ACCOUNT_SECURITY"},
        resolve: {
            accountSecurityStatus: ["accountSecurity", function (e) {
                return e.status()
            }]
        },
        templateUrl: "settings/account-security/account-security.html"
    })
}]).controller("AccountSecurityController", ["accountSecurityStatus", function (e) {
    var t = this;
    t.accountSecurityStatus = e
}]),angular.module("account.security.edit", ["account.security.service", "locale", "message.container", "notifier", "safety.questions.modal", "templates"]).component("habboAccountSecurityEdit", {
    bindings: {accountSecurityStatus: "="},
    controller: ["$translate", "$window", "accountSecurity", "notifier", "safetyQuestionsModal", function (e, t, o, r, a) {
        function n() {
            o.disable().then(function () {
                i.accountSecurityStatus = "disabled", r.success("ACCOUNT_SECURITY_DISABLED_OK")
            })["catch"](function (e) {
                403 !== e.status && r.error("ERROR_SERVER")
            })["finally"](function () {
                i.disableInProgress = !1
            })
        }

        var i = this;
        i.modal = a, i.openModal = function () {
            a.open().then(function () {
                i.accountSecurityStatus = "enabled"
            })
        }, i.disable = function () {
            i.disableInProgress = !0, e("ACCOUNT_SECURITY_DISABLE_CONFIRMATION").then(function (e) {
                t.confirm(e) ? n() : i.disableInProgress = !1
            })
        }
    }],
    controllerAs: "AccountSecurityEditController",
    templateUrl: "settings/account-security/account-security-edit.html"
}),angular.module("security.require.session", ["security.session"]).directive("habboRequireSession", ["Session", "ngIfDirective", function (e, t) {
    var o = t[0];
    return {
        restrict: "A",
        priority: o.priority,
        terminal: o.terminal,
        transclude: o.transclude,
        link: function (t, r, a) {
            a.ngIf = function () {
                return e.hasSession()
            }, o.link.apply(o, arguments)
        }
    }
}]).directive("habboRequireNoSession", ["Session", "ngIfDirective", function (e, t) {
    var o = t[0];
    return {
        restrict: "A",
        priority: o.priority,
        terminal: o.terminal,
        transclude: o.transclude,
        link: function (t, r, a) {
            a.ngIf = function () {
                return !e.hasSession()
            }, o.link.apply(o, arguments)
        }
    }
}]),angular.module("security.require.non.staff.account.session", ["security.session"]).directive("habboRequireNonStaffAccountSession", ["Session", "ngIfDirective", function (e, t) {
    var o = t[0];
    return {
        restrict: "A",
        priority: o.priority,
        terminal: o.terminal,
        transclude: o.transclude,
        link: function (t, r, a) {
            a.ngIf = function () {
                return !e.isStaff()
            }, o.link.apply(o, arguments)
        }
    }
}]),angular.module("security.require.staff.account.session", ["security.session"]).directive("habboRequireStaffAccountSession", ["Session", "ngIfDirective", function (e, t) {
    var o = t[0];
    return {
        restrict: "A",
        priority: o.priority,
        terminal: o.terminal,
        transclude: o.transclude,
        link: function (t, r, a) {
            a.ngIf = function () {
                return e.isStaff()
            }, o.link.apply(o, arguments)
        }
    }
}]),angular.module("security.require.habbo.account.session", ["security.session"]).directive("habboRequireHabboAccountSession", ["Session", "ngIfDirective", function (e, t) {
    var o = t[0];
    return {
        restrict: "A",
        priority: o.priority,
        terminal: o.terminal,
        transclude: o.transclude,
        link: function (t, r, a) {
            a.ngIf = function () {
                return e.isHabboAccountSession()
            }, o.link.apply(o, arguments)
        }
    }
}]),angular.module("security.session", ["security.require.habbo.account.session", "security.require.staff.account.session", "security.require.non.staff.account.session", "security.require.session", "security.session.service"]),angular.module("security.session.store", []).factory("SessionStore", ["$window", function (e) {
    var t = {};
    return t.create = function (t) {
        try {
            e.sessionStorage.setItem("session", angular.toJson(t))
        } catch (o) {
            Bugsnag.notifyException(o, "SessionStorage not supported", {groupingHash: "SessionStorage"}, "info")
        }
    }, t.get = function () {
        try {
            var t = e.sessionStorage.getItem("session");
            return t ? angular.fromJson(t) : null
        } catch (o) {
            return Bugsnag.notifyException(o, "SessionStorage not supported", {groupingHash: "SessionStorage"}, "info"), null
        }
    }, t.destroy = function () {
        try {
            e.sessionStorage.removeItem("session")
        } catch (t) {
            Bugsnag.notifyException(t, "SessionStorage not supported", {groupingHash: "SessionStorage"}, "info")
        }
    }, t
}]),angular.module("security.session.service", ["config", "events", "security.bugsnag.session", "security.ga.session", "security.session.store"]).factory("Session", ["$rootScope", "BugsnagSession", "CONFIG", "EVENTS", "GaSession", "SessionStore", function (e, t, o, r, a, n) {
    var i = {};
    return i.user = null, i.init = function (e) {
        return e = e || n.get(), e ? i.create(e) : void 0
    }, i.create = function (o) {
        return i.user = o, t.create(i.user), a.create(i.user), n.create(i.user), e.$broadcast(r.securityLogin), i.user
    }, i.update = function (e) {
        return angular.extend(i.user, e), t.create(i.user), a.create(i.user), n.create(i.user), i.user
    }, i.hasSession = function () {
        return Boolean(i.user)
    }, i.isTrusted = function () {
        return i.hasSession() && Boolean(i.user.trusted)
    }, i.isHabboAccountSession = function () {
        return i.hasSession() && "fblogin" !== i.user.email && "rpxlogin" !== i.user.email
    }, i.hasAds = function () {
        return !i.hasSession() || !(i.user.buildersClubMember || i.user.habboClubMember)
    }, i.hasPreRollAd = function () {
        return i.hasSession() && !(i.user.buildersClubMember || i.user.habboClubMember) && !_.includes(i.user.traits, "NEW_USER") && !_.includes(i.user.traits, "STAFF") && !i.isTestUser()
    }, i.isTestUser = function () {
        return "hhs1" === o.hotel && i.hasSession() && i.user.email && (_(i.user.email).includes("@dev.habbo.fi") || _(i.user.email).includes("@test.habbo.fi"))
    }, i.isCurrentUser = function (e) {
        return i.hasSession() && i.user.uniqueId === e
    }, i.destroy = function () {
        n.destroy()
    }, i.isStaff = function () {
        return i.hasSession() && _.includes(i.user.traits, "STAFF")
    }, i
}]),angular.module("security.ga.session", ["angular-md5"]).factory("GaSession", ["$window", "md5", function (e, t) {
    var o = {};
    return o.create = function (o) {
        try {
            e.ga("set", "userId", t.createHash(o.identityId.toString()))
        } catch (r) {
            Bugsnag.notifyException(r, "GA session not created", {}, "info")
        }
    }, o
}]),angular.module("security.bugsnag.session", ["angular-md5"]).factory("BugsnagSession", ["$window", "md5", function (e, t) {
    var o = {};
    return o.create = function (o) {
        e.Bugsnag && (e.Bugsnag.user = {id: t.createHash(o.identityId.toString())})
    }, o
}]),angular.module("security.safety.lock.service", ["config", "google.analytics", "security"]).factory("safetyLock", ["$http", "$location", "CONFIG", "Session", "googleAnalytics", function (e, t, o, r, a) {
    var n = {};
    return n.getQuestions = function () {
        return e.get(o.apiUrl + "/safetylock/questions")
    }, n.unlock = function (n) {
        return e.post(o.apiUrl + "/safetylock/unlock", n).then(function () {
            var e = {trusted: !0};
            return r.hasSession() && r.update(e), a.trackEvent("Safety lock", "Unlocked", t.path()), e
        })
    }, n
}]),angular.module("security.safety.lock", ["security.safety.lock.form", "security.safety.lock.service", "templates", "ui.bootstrap"]).controller("SafetyLockController", ["questions", function (e) {
    var t = this;
    t.questions = e.data
}]).factory("safetyLockModal", ["$uibModal", "safetyLock", function (e, t) {
    var o, r = {};
    return r.open = function () {
        return o = e.open({
            controller: "SafetyLockController",
            controllerAs: "SafetyLockController",
            resolve: {questions: t.getQuestions},
            templateUrl: "security/safety-lock/safety-lock-modal.html"
        }), o.result
    }, r.isOpen = function () {
        return Boolean(o) && o.open
    }, r
}]),angular.module("security.safety.lock.form", ["form", "locale", "notifier", "security.safety.lock.service", "templates"]).directive("habboSafetyLockForm", ["notifier", "safetyLock", function (e, t) {
    return {
        restrict: "E",
        scope: {questions: "=", onUnlock: "&", onCancel: "&"},
        templateUrl: "security/safety-lock/safety-lock-form.html",
        link: function (o) {
            o.answers = {trust: !1}, o.unlockingInProgress = !1, o.isTrustedLocationEnabled = !0, o.unlock = function () {
                o.safetyLockForm.$valid && (o.unlockingInProgress = !0, t.unlock(o.answers).then(o.onUnlock)["catch"](function (t) {
                    var r = t.status;
                    409 === r ? o.$broadcast("remote-data-invalid", "answer") : 429 === r ? e.error("ERROR_TOO_MANY_ATTEMPTS", {time: moment(t.data.nextValidRequestDate).fromNow(!0)}) : e.error("ERROR_SERVER")
                })["finally"](function () {
                    o.unlockingInProgress = !1
                }))
            }
        }
    }
}]),angular.module("security.safety.answering.modal", ["locale", "security.safety.answering.form", "templates", "ui.bootstrap"]).controller("SafetyAnsweringController", ["data", "questions", "targetAction", function (e, t, o) {
    var r = this;
    r.questions = t, r.data = e, r.targetAction = o
}]).factory("safetyAnsweringModal", ["$uibModal", function (e) {
    var t = {};
    return t.open = function (t, o, r) {
        return e.open({
            controller: "SafetyAnsweringController",
            controllerAs: "SafetyAnsweringController",
            resolve: {questions: _.constant(t), data: _.constant(o), targetAction: _.constant(r)},
            templateUrl: "security/safety-lock/safety-answering-modal.html"
        }).result
    }, t
}]),angular.module("security.safety.answering.form", ["form", "locale", "notifier", "templates"]).directive("habboSafetyAnsweringForm", ["notifier", function (e) {
    return {
        restrict: "E",
        scope: {data: "=", questions: "=", targetAction: "&", onSuccess: "&", onCancel: "&"},
        templateUrl: "security/safety-lock/safety-lock-form.html",
        link: function (t) {
            t.answers = {}, t.unlockingInProgress = !1, t.isTrustedLocationEnabled = !1, t.unlock = function () {
                t.safetyLockForm.$valid && (t.unlockingInProgress = !0, _.assign(t.data, t.answers), t.targetAction({data: t.data}).then(t.onSuccess)["catch"](function (o) {
                    var r = o.status;
                    409 === r ? t.$broadcast("remote-data-invalid", "answer") : 429 === r ? e.error("ERROR_TOO_MANY_ATTEMPTS", {time: moment(o.data.nextValidRequestDate).fromNow(!0)}) : e.error("ERROR_SERVER")
                })["finally"](function () {
                    t.unlockingInProgress = !1
                }))
            }
        }
    }
}]),angular.module("security.rpx.service", ["config"]).factory("rpxSecurity", ["$document", "$window", "CONFIG", function (e, t, o) {
    var r, a = {};
    return a.init = function () {
        t.janrain = {}, t.janrain.settings = {}, t.janrain.settings.language = o.rpxLocale, t.janrain.settings.tokenUrl = o.rpxTokenUrl, t.janrain.ready = !0, r = e[0].createElement("script"), r.id = "janrainAuthWidget", r.src = "https://rpxnow.com/js/lib/login.habbo.com/engage.js", e[0].body.appendChild(r)
    }, a.destroy = function () {
        r && (delete t.janrain, angular.element(r).remove(), angular.element('script[src^="https://d29usylhdk1xyu.cloudfront.net"]').remove(), angular.element("#janrainModal, #janrainModalOverlay").remove())
    }, a
}]),angular.module("security.rpx.message", ["notifier"]).factory("rpxMessage", ["notifier", function (e) {
    var t = {}, o = "💩", r = "🐳", a = "🙊";
    return t.show = function (t) {
        switch (t) {
            case o:
                e.error("LOGIN_RPX_REGISTRATION_DISABLED");
                break;
            case r:
                e.error("ERROR_SERVER_MAINTENANCE");
                break;
            case a:
                e.error("ERROR_SERVER")
        }
    }, t
}]).run(["$location", "rpxMessage", function (e, t) {
    t.show(e.search().error)
}]),angular.module("security.rpx", ["security.rpx.message", "security.rpx.service"]),angular.module("security.login.shake", []).constant("LOGIN_EVENTS", {invalidCredentials: "login-invalid-credentials"}).directive("habboShake", ["LOGIN_EVENTS", function (e) {
    return {
        restrict: "A", link: function (t, o) {
            t.$on(e.invalidCredentials, function () {
                var e = angular.element(".modal-dialog"), t = e.is(":visible") ? e : o;
                t.addClass("animated shake").one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", function () {
                    t.removeClass("animated shake")
                })
            })
        }
    }
}]),angular.module("security.login", ["security.login.form", "templates", "ui.bootstrap"]).factory("loginModal", ["$uibModal", function (e) {
    var t, o = {};
    return o.open = function () {
        return t = e.open({templateUrl: "security/login/login-modal.html"}), t.result
    }, o.isOpen = function () {
        return Boolean(t) && t.open
    }, o
}]),angular.module("security.login.form", ["air.download.link", "captcha.modal", "claim.password", "form", "locale", "notifier", "recover.password.modal", "security.facebook.connect", "security.login.shake", "security.service", "templates"]).component("habboLoginForm", {
    bindings: {onLogin: "&"},
    controller: ["$element", "$location", "$scope", "$window", "LOGIN_EVENTS", "captchaModal", "notifier", "recoverPasswordModal", "security", function (e, t, o, r, a, n, i, s, l) {
        function c() {
            n.open().then(function (e) {
                u({email: p.email, password: p.password, captchaToken: e})
            })
        }

        function u(e) {
            p.loginInProgress = !0, l.login(e).then(p.onLogin)["catch"](d)["finally"](function () {
                p.loginInProgress = !1
            })
        }

        function d(e) {
            var t = e.status, o = e.data && e.data.message;
            h = Boolean(e.data && e.data.captcha), 401 === t ? "login.staff_login_not_allowed" === o ? i.error("ERROR_LOGIN_STAFF_NOT_ALLOWED") : "invalid-captcha" === o ? c() : m() : 429 === t ? i.error("ERROR_TOO_MANY_ATTEMPTS", {time: moment(e.data.nextValidRequestDate).fromNow(!0)}) : "force.pending" !== t && i.error("ERROR_SERVER")
        }

        function m() {
            f++, f === b ? (b *= 2, s.open(p.email)) : (o.$broadcast(a.invalidCredentials), o.$broadcast("remote-data-invalid", "credentials"))
        }

        var p = this, h = !1, f = 0, b = 3;
        p.loginInProgress = !1, p.login = function () {
            var o = t.search().captchaToken || r.captchaToken;
            p.email = e.find("[type=email]").val(), p.password = e.find("[type=password]").val(), o ? u({
                email: p.email,
                password: p.password,
                captchaToken: o
            }) : h ? c() : u({email: p.email, password: p.password})
        }
    }],
    controllerAs: "LoginController",
    templateUrl: "security/login/login-form.html"
}),angular.module("security.use.force.service", ["security.force.email.modal", "security.force.password.modal", "security.force.service", "security.force.tos.modal", "security.safety.lock"]).factory("useForce", ["$q", "FORCE", "forceEmailModal", "forcePasswordModal", "forceTOSModal", "safetyLockModal", function (e, t, o, r, a, n) {
    function i(e, t) {
        return function (o) {
            var r = o && o.force;
            return _.includes(r, e) ? t(o) : o
        }
    }

    function s(e) {
        return l(e).then(r.open)
    }

    function l(t) {
        return t.trusted ? e.when(t) : n.open().then(function (e) {
            return _.assign(t, e)
        })
    }

    var c = {};
    return c.handleForces = function (r) {
        return e.when(r).then(i(t.email, o.open)).then(i(t.password, s)).then(i(t.TOS, a.open))
    }, c
}]),angular.module("security.force.service", ["config", "google.analytics"]).constant("FORCE", {
    email: "EMAIL",
    password: "PASSWORD",
    TOS: "TOS"
}).factory("force", ["$http", "CONFIG", "googleAnalytics", function (e, t, o) {
    var r = {};
    return r.changeEmail = function (r) {
        return e.post(t.apiUrl + "/force/email-change", {newEmail: r}).then(function (e) {
            return o.trackEvent("Email", "Forced change"), e.data
        })
    }, r.changePassword = function (r) {
        return e.post(t.apiUrl + "/force/password-change", {newPassword: r}).then(function (e) {
            return o.trackEvent("Password", "Forced change"), e.data
        })
    }, r.acceptTOS = function () {
        return e.post(t.apiUrl + "/force/tos-accept").then(function (e) {
            return o.trackEvent("TOS", "Forced accept"), e.data
        })
    }, r
}]),angular.module("security.fingerprint", ["security.fingerprint.interceptor", "security.fingerprint.service.init"]),angular.module("security.fingerprint.service", []).factory("fingerprint", function () {
    var e = {};
    return e.getFingerprint = function () {
        return e.fingerprint
    }, e.calculateFingerprint = function () {
        (new Fingerprint2).get(function (t) {
            e.fingerprint = t
        })
    }, e
}),angular.module("security.fingerprint.service.init", ["security.fingerprint.service"]).run(["fingerprint", function (e) {
    e.calculateFingerprint()
}]),angular.module("security.fingerprint.service.mock", []).factory("fingerprint", function () {
    var e = {};
    return e.getFingerprint = function () {
        return e.fingerprint
    }, e.calculateFingerprint = _.noop, e
}),angular.module("security.fingerprint.interceptor", ["config", "security.fingerprint.service"]).factory("fingerprintInterceptor", ["CONFIG", "fingerprint", function (e, t) {
    var o = {};
    return o.request = function (o) {
        return t.getFingerprint() && _(o.url).includes(e.apiUrl) && (o.headers["x-habbo-fingerprint"] = t.getFingerprint()), o
    }, o
}]).config(["$httpProvider", function (e) {
    e.interceptors.push("fingerprintInterceptor")
}]),angular.module("spinner", ["security", "templates", "ui.bootstrap", "ui.router"]).factory("spinner", ["$rootScope", "$timeout", "$uibModal", "loginModal", "safetyLockModal", function (e, t, o, r, a) {
    function n() {
        t.cancel(c), l || (c = t(s, 200))
    }

    function i() {
        t.cancel(c), l && (l.close(), l = null, u = !0)
    }

    function s() {
        r.isOpen() || a.isOpen() || (l = o.open({
            animation: !1,
            backdrop: "static",
            backdropClass: u ? "spinner-backdrop--transparent" : "spinner-backdrop--solid",
            keyboard: !1,
            templateUrl: "router/spinner/spinner.html",
            windowClass: u ? "spinner spinner--transparent" : "spinner spinner--solid"
        }))
    }

    var l, c, u = !1, d = {};
    return d.init = function () {
        s(), e.$on("$stateChangeStart", n), e.$on("$stateChangeSuccess", i), e.$on("$stateChangeError", i)
    }, d
}]),angular.module("scrolltop", ["ui.router"]).factory("scrolltop", function () {
    var e = {};
    return e.enabled = !0, e.setEnabled = function (e) {
        this.enabled = e
    }, e.isEnabled = function () {
        return this.enabled
    }, e
}).run(["$rootScope", "$window", "scrolltop", function (e, t, o) {
    e.$on("$viewContentLoaded", function () {
        o.isEnabled() && t.scrollTo(0, 0)
    })
}]),angular.module("prerender.status.code", []).directive("prerenderStatusCode", ["$location", function (e) {
    return {
        restrict: "A", link: function (t, o, r) {
            var a = e.absUrl();
            t.$on("$stateChangeStart", function (e, t) {
                t.resolve && t.resolve.auth && r.$set("content", 401)
            }), t.$on("$stateChangeSuccess", function (t, o) {
                "notFound" === o.name ? r.$set("content", 404) : r.$set("content", a === e.absUrl() ? 200 : 301)
            }), t.$on("$stateChangeError", function () {
                r.$set("content", 404)
            })
        }
    }
}]),angular.module("prerender.ready", []).run(["$browser", "$timeout", "$window", function (e, t, o) {
    e.notifyWhenNoOutstandingRequests(function () {
        t(function () {
            o.prerenderReady = !0
        })
    })
}]),angular.module("prerender.header", []).directive("prerenderHeader", ["$location", function (e) {
    return {
        restrict: "A", link: function (t, o, r) {
            var a = e.absUrl();
            t.$on("$stateChangeSuccess", function (t, o) {
                var n = e.absUrl();
                "notFound" !== o.name && a !== n && r.$set("content", "Location: " + n)
            })
        }
    }
}]),angular.module("prerender", ["prerender.header", "prerender.ready", "prerender.status.code"]),angular.module("head.title", ["head.service"]).directive("title", ["Head", function (e) {
    return {
        restrict: "E", link: function (t, o) {
            function r(e) {
                o.html(e)
            }

            t.$watch(e.getFullTitle, r)
        }
    }
}]),angular.module("head", ["head.content", "head.service", "head.title", "head.url"]),angular.module("head.url", []).directive("habboHeadUrl", ["$location", function (e) {
    return {
        restrict: "A", link: function (t, o, r) {
            function a() {
                return e.absUrl()
            }

            function n(e) {
                r.$set(r.habboHeadUrl, e)
            }

            t.$watch(a, n)
        }
    }
}]),angular.module("head.content", ["head.service"]).constant("META_ATTRS", {
    "og:title": "title",
    "og:description": "description",
    "og:image": "image",
    "og:image:height": "imageHeight",
    "og:image:width": "imageWidth",
    "twitter:title": "title",
    "twitter:description": "description",
    "twitter:card": "twitter:card",
    "twitter:image": "image",
    name: "title",
    description: "description",
    image: "image"
}).directive("content", ["Head", "META_ATTRS", function (e, t) {
    return {
        restrict: "A", link: function (o, r, a) {
            function n() {
                return e[s]
            }

            function i(e) {
                a.$set("content", e)
            }

            var s = t[a.name || a.property || a.itemprop];
            s && o.$watch(n, i)
        }
    }
}]),angular.module("head.service", ["locale", "ui.router"]).constant("HEAD_DEFAULTS", {
    title: window.chocolatey.name,
    description: "Join millions in the planet's most popular virtual world for teens. Create your avatar, meet new friends, role play, and build amazing spaces.",
    image: "https://habboo-a.akamaihd.net/habbo-web/america/en/assets/images/app_summary_image-1200x628.85a9f5dc.png",
    imageHeight: 628,
    imageWidth: 1200,
    "twitter:card": "summary_large_image"
}).factory("Head", ["$translate", "HEAD_DEFAULTS", function (e, t) {
    var o = {}, r = " - " + window.chocolatey.name;
    return o.setDefaults = function () {
        o.title = t.title, o.title = t.title, o.description = t.description, o.image = t.image, o.imageHeight = t.imageHeight, o.imageWidth = t.imageWidth, o["twitter:card"] = t["twitter:card"]
    }, o.set = function (e, t) {
        var r = e || {};
        r.title && o.setTitle(r.title, t), r.description && (o.description = r.description), r.image && (o.image = r.image), r.imageHeight && (o.imageHeight = r.imageHeight), r.imageWidth && (o.imageWidth = r.imageWidth), r["twitter:card"] && (o["twitter:card"] = r["twitter:card"])
    }, o.setTitle = function (t, r) {
        e(t, r).then(function (e) {
            o.title = e
        })
    }, o.getFullTitle = function () {
        return window.chocolatey.name === o.title ? o.title : o.title + r
    }, o
}]).run(["$rootScope", "Head", function (e, t) {
    e.$on("$stateChangeStart", function () {
        t.setDefaults()
    }), e.$on("$stateChangeSuccess", function (e, o, r) {
        t.set(o.data, r)
    })
}]),angular.module("ban.error", ["ban.message", "ban.redirect"]),angular.module("ban.redirect", ["locale", "security"]).factory("banRedirect", ["$injector", "$q", function (e, t) {
    function o(e) {
        var t = e.status, o = e.data && e.data.message;
        return (403 === t || 401 === t) && r(o)
    }

    function r(e) {
        return _.includes(i, e)
    }

    function a(t) {
        var o = t.data;
        return n = n || e.get("security"), n.forceLogout("/?error=banned&" + $.param(o))
    }

    var n,
        i = ["login.user_banned", "login.identity_banned", "login.avatar_banned", "user.identity_banned", "user.avatar_banned"],
        s = {};
    return s.responseError = function (e) {
        return o(e) ? a(e) : t.reject(e)
    }, s
}]).config(["$httpProvider", function (e) {
    e.interceptors.push("banRedirect")
}]),angular.module("ban.message", ["locale", "notifier"]).factory("banMessage", ["$q", "$translate", "dateFilter", "notifier", function (e, t, o, r) {
    function a(e, t, o) {
        var r = _(e).includes("avatar_banned") ? "USER_AVATAR" : "USER_IDENTITY";
        return r += t ? "_PERMANENT_BAN_TEXT" : "_BAN_TEXT", o && (r += "_WITH_GUIDE"), r
    }

    var n = {};
    return n.show = function (n) {
        if ("banned" === n.error) {
            var i = n.sanctionReasonId ? "CFH_REASON_" + n.sanctionReasonId.toUpperCase() : "CFH_REASON_AUTO_TRIGGER",
                s = "true" === n.permanentBan ? "CFH_REASON_RESOLVED_TARGET_BAN_PERMANENT" : "CFH_REASON_RESOLVED_TARGET_BAN",
                l = "MODERATOR_MSG_POSTFIX";
            return e.all([t(s), t(i), t(l)]).then(function (e) {
                var t = e[0], i = e[1], s = e[2], l = -1 === t.indexOf("%") ? t : t.substring(0, t.indexOf("%")),
                    c = n.reason;
                _.endsWith(n.reason, s) && -1 !== n.reason.indexOf(i) && _.startsWith(n.reason, l) || (c = i);
                var u = n.expiryTime, d = {
                    message: n.message,
                    avatarName: n.avatarName,
                    reason: c,
                    expiryTime: u ? o(u, "short") : u,
                    permanentBan: "true" === n.permanentBan,
                    provideExtraSupport: "true" === n.provideExtraSupport
                }, m = a(d.message, d.permanentBan, d.provideExtraSupport);
                r.errorSticky("USER_BAN_TITLE", m, d)
            })
        }
    }, n
}]).run(["$location", "banMessage", function (e, t) {
    t.show(e.search())
}]),angular.module("room.restricted", ["locale", "templates"]).component("habboRoomRestricted", {
    bindings: {room: "<"},
    controllerAs: "RoomRestrictedController",
    templateUrl: "room/room-restricted/room-restricted.html"
}),angular.module("room.picture", ["templates"]).component("habboRoomPicture", {
    bindings: {url: "@"},
    templateUrl: "room/room-picture/room-picture.html",
    controllerAs: "RoomPictureController"
}),angular.module("room.open", ["avatar", "locale", "official.room.avatar", "room.info", "room.picture", "templates"]).component("habboRoomOpen", {
    bindings: {room: "<"},
    controllerAs: "RoomOpenController",
    templateUrl: "room/room-open/room-open.html",
    controller: ["$window", function (e) {
        var t = this, o = e.btoa(t.room.name.replace(/[^\x00-\x7F]/g, "").trim());
        t.room.hotelReportLink = "/hotel?link=navigator/report/" + t.room.uniqueId + "/" + o
    }]
}),angular.module("room.info", ["templates"]).component("habboRoomInfo", {
    bindings: {description: "@", tags: "<"},
    templateUrl: "room/room-info/room-info.html",
    controllerAs: "RoomInfoController"
}),angular.module("registration.policies", ["locale", "templates"]).component("habboPolicies", {
    require: {FormController: "^form"},
    bindings: {policies: "="},
    controllerAs: "PoliciesController",
    templateUrl: "registration/policies/policies.html"
}),angular.module("registration.partner", ["locale", "templates"]).component("habboPartnerRegistration", {
    bindings: {value: "="},
    controller: function () {
        var e = this;
        e.value = !0
    },
    controllerAs: "PartnerRegistrationController",
    templateUrl: "registration/partner-registration/partner-registration.html"
}),angular.module("birthdate.filters", []).filter("daysInMonth", function () {
    var e = [4, 6, 9, 11];
    return function (t, o, r) {
        return o = parseInt(o, 10), r = parseInt(r, 10), 2 === o ? moment([r]).isLeapYear() ? _(t).take(29).value() : _(t).take(28).value() : _(e).includes(o) ? _(t).take(30).value() : t
    }
}),angular.module("birthdate", ["ngMessages", "birthdate.filters", "locale", "templates"]).component("habboBirthdate", {
    require: {FormController: "^form"},
    bindings: {birthdate: "="},
    controller: ["$scope", "daysInMonthFilter", function (e, t) {
        var o = 7, r = 1900, a = (new Date).getFullYear() - o, n = this;
        n.days = _.range(1, 32), n.months = [{value: 1, translationKey: "MONTH_JANUARY"}, {
            value: 2,
            translationKey: "MONTH_FEBRUARY"
        }, {value: 3, translationKey: "MONTH_MARCH"}, {value: 4, translationKey: "MONTH_APRIL"}, {
            value: 5,
            translationKey: "MONTH_MAY"
        }, {value: 6, translationKey: "MONTH_JUNE"}, {value: 7, translationKey: "MONTH_JULY"}, {
            value: 8,
            translationKey: "MONTH_AUGUST"
        }, {value: 9, translationKey: "MONTH_SEPTEMBER"}, {value: 10, translationKey: "MONTH_OCTOBER"}, {
            value: 11,
            translationKey: "MONTH_NOVEMBER"
        }, {
            value: 12,
            translationKey: "MONTH_DECEMBER"
        }], n.years = _.range(r, a).reverse(), e.$watchGroup(["BirthdateController.month", "BirthdateController.year"], function (e) {
            var o = parseInt(n.day, 10), r = e[0], a = e[1];
            _(t(n.days, r, a)).includes(o) || (n.day = "")
        }), e.$watchGroup(["BirthdateController.day", "BirthdateController.month", "BirthdateController.year"], function (e) {
            var t = parseInt(e[0], 10), o = parseInt(e[1], 10), r = parseInt(e[2], 10);
            _.isNaN(t) || _.isNaN(o) || _.isNaN(r) ? n.FormController.birthdate.$pristine || n.FormController.birthdate.$setViewValue(null) : n.FormController.birthdate.$setViewValue({
                day: t,
                month: o,
                year: r
            })
        })
    }],
    controllerAs: "BirthdateController",
    templateUrl: "registration/birthdate/birthdate.html"
}),angular.module("profile.modal", ["by.name.description.or.motto.filter", "empty.results", "form", "locale", "profile.item.lists", "templates", "ui.bootstrap"]).controller("ProfileModalController", ["items", "type", function (e, t) {
    var o = this;
    o.items = e, o.type = t
}]).component("habboProfileModal", {
    bindings: {items: "<", type: "@"},
    controller: ["$uibModal", function (e) {
        var t = this;
        t.openModal = function () {
            e.open({
                transclude: !0,
                templateUrl: "profile/profile-modal/profile-modal.html",
                controller: "ProfileModalController",
                controllerAs: "ProfileModalController",
                resolve: {items: _.constant(t.items), type: _.constant(t.type)}
            })
        }
    }],
    controllerAs: "ProfileModalComponentController",
    template: '<a ng-click="ProfileModalComponentController.openModal()" class="profile-modal__link" translate="SEE_ALL"></a>'
}),angular.module("profile.header", ["encode.uri.component", "imager", "templates"]).component("habboProfileHeader", {
    bindings: {
        figure: "@",
        user: "@",
        motto: "@",
        profile: "@"
    },
    controller: function () {
        var e = this;
        e.isCroco = function (e) {
            return Boolean(e) && "crikey" === e.toLowerCase()
        }
    },
    controllerAs: "ProfileHeaderController",
    templateUrl: "profile/profile-header/profile-header.html",
    transclude: !0
}),angular.module("profile.item.lists", ["badge", "by.name.description.or.motto.filter", "encode.uri.component", "flash", "group.badge", "imager", "infinite-scroll", "room.icon", "templates"]).component("habboBadgeList", {
    bindings: {
        badges: "<",
        query: "<"
    }, controllerAs: "BadgeListController", templateUrl: "profile/item-lists/badges.html"
}).component("habboFriendList", {
    bindings: {friends: "<", query: "<"},
    controllerAs: "FriendListController",
    templateUrl: "profile/item-lists/friends.html"
}).component("habboRoomList", {
    bindings: {rooms: "<", query: "<"},
    controllerAs: "RoomListController",
    templateUrl: "profile/item-lists/rooms.html"
}).component("habboGroupList", {
    bindings: {groups: "<", query: "<"},
    controllerAs: "GroupListController",
    templateUrl: "profile/item-lists/groups.html"
}),angular.module("creation", ["creation.content", "creation.service", "header", "locale", "profile.header", "router", "social.share", "templates"]).config(["$stateProvider", "$urlRouterProvider", function (e, t) {
    var o = ["$q", "$stateParams", "creations", function (e, t, o) {
        var r = _.findIndex(o, {id: t.creationId});
        return r >= 0 ? r : e.reject()
    }];
    e.statePublic("photo", {
        url: "/profile/:name/photo/:creationId?pool",
        controller: "CreationController",
        controllerAs: "CreationController",
        onEnter: ["creations", "index", "Head", function (e, t, o) {
            o.setTitle("HEAD_TITLE_PHOTO", {name: e[t].creator_name}), o.image = e[t].url, o.imageHeight = e[t].contentHeight, o.imageWidth = e[t].contentWidth
        }],
        resolve: {
            creations: ["$stateParams", "Creations", function (e, t) {
                return t.photos({pool: e.pool, name: e.name})
            }], index: o
        },
        templateUrl: "profile/creation/creation.html"
    }), e.statePublic("story", {
        url: "/profile/:name/story/:creationId?pool",
        controller: "CreationController",
        controllerAs: "CreationController",
        onEnter: ["creations", "index", "Head", function (e, t, o) {
            var r = e[t];
            "SELFIE" === r.type ? o.setTitle("HEAD_TITLE_SELFIE", {name: r.creator_name}) : o.setTitle("HEAD_TITLE_CREATION", {
                creation: r.title,
                name: r.creator_name
            }), o.image = r.url, o.imageHeight = r.contentHeight, o.imageWidth = r.contentWidth
        }],
        resolve: {
            creations: ["$stateParams", "Creations", function (e, t) {
                return t.stories({pool: e.pool, name: e.name})
            }], index: o
        },
        templateUrl: "profile/creation/creation.html"
    }), t.when("/profile/:name/creation/:id", "/profile/:name/story/:id")
}]).controller("CreationController", ["$scope", "creations", "index", "scrolltop", function (e, t, o, r) {
    var a = this;
    a.creation = t[o], a.next = t[o + 1], a.previous = t[o - 1], e.$on("$stateChangeStart", function (e, t) {
        "photo" === t.name || "story" === t.name ? r.setEnabled(!1) : r.setEnabled(!0)
    })
}]),angular.module("creation.content", ["creation.href", "like", "locale", "navigate.to.on.key", "photo.delete", "report", "security", "templates"]).component("habboCreationContent", {
    bindings: {
        creation: "<",
        previous: "<",
        next: "<"
    }, controller: ["Session", function (e) {
        var t = this;
        t.isDeletable = function () {
            return e.isCurrentUser(t.creation.creator_uniqueId)
        }
    }], controllerAs: "CreationContentController", templateUrl: "profile/creation/creation-content.html"
}),angular.module("creation.service", ["photos.service", "profile.creations"]).factory("Creations", ["CreationsProfile", "Photos", function (e, t) {
    var o = {};
    return o.photos = function (o) {
        return "photos" === o.pool ? t.query().$promise : e.photosForUser(o.name)
    }, o.stories = function (t) {
        return e.storiesForUser(t.name)
    }, o
}]),angular.module("client.messenger", []).factory("clientMessenger", function () {
    function e(e) {
        a.postMessage({call: "open-link", target: e.link}, "*")
    }

    function t(e) {
        a.postMessage({call: "open-room", target: e.room}, "*")
    }

    function o(e) {
        a.postMessage({call: "interstitial-status", target: e.interstitial}, "*")
    }

    var r = {}, a = null, n = {link: e, room: t, interstitial: o};
    return r.init = function (e) {
        a = e
    }, r.handle = function (e) {
        var t = _(e).pickBy(_.isString).keys().head(), o = n[t];
        o && o(e)
    }, r
}),angular.module("client.listener", ["client.heartbeat.ping.service", "interstitial", "notifier", "security"]).factory("clientListener", ["$location", "$rootScope", "EVENTS", "Session", "clientHeartbeatPing", "interstitial", "notifier", "security", function (e, t, o, r, a, n, i, s) {
    function l() {
        C = !0
    }

    function c() {
        y = moment(), (null === E || moment().diff(E, "seconds") > _) && (E = moment(), a.ping())
    }

    function u() {
        s.logout()["catch"](function () {
            t.$emit(o.clientClose), i.errorSticky("ERROR_LOGOUT_TITLE", "ERROR_LOGOUT_TEXT")
        })
    }

    function d(t) {
        e.url(t)
    }

    function m(e) {
        r.update({figureString: e})
    }

    function p(e) {
        r.update({name: e})
    }

    function h() {
        return moment().diff(y, "seconds") < 60
    }

    function f() {
        n.start("midroll")
    }

    function b(e) {
        r.update({buildersClubMember: e})
    }

    function g(e) {
        r.update({habboClubMember: e})
    }

    var _ = 300, v = {}, C = !1, y = null, E = null, S = {
        disconnect: l,
        heartbeat: c,
        logout: u,
        "open-page": d,
        "update-figure": m,
        "update-name": p,
        "show-interstitial": f,
        "update-builders-club": b,
        "update-habbo-club": g
    };
    return v.init = function () {
        C = !1, y = null
    }, v.handle = function (e) {
        var t = S[e.call];
        t && t(e.target)
    }, v.isAlive = function () {
        return Boolean(y) && h()
    }, v.hasDied = function () {
        return Boolean(y) && !h()
    }, v.hasDisconnected = function () {
        return C
    }, v
}]),angular.module("client.heartbeat.ping.service", ["config"]).factory("clientHeartbeatPing", ["$http", "CONFIG", function (e, t) {
    var o = {};
    return o.ping = function () {
        return e.get(t.apiUrl + "/user/ping")
    }, o
}]),angular.module("client.communication", ["client.listener", "client.messenger", "events"]).directive("habboClientCommunication", ["$timeout", "$window", "EVENTS", "clientListener", "clientMessenger", function (e, t, o, r, a) {
    return {
        restrict: "A", link: function (n, i) {
            function s(t) {
                e(function () {
                    r.handle(t.originalEvent.data)
                })
            }

            var l = i.get(0).contentWindow;
            a.init(l), n.$on(o.clientOpen, function (e, t) {
                var o = n.$watch(r.isAlive, function (e) {
                    e && (a.handle(t), o())
                });
                r.init()
            }), angular.element(t).on("message", s), i.on("$destroy", function () {
                angular.element(t).off("message", s)
            })
        }
    }
}]),angular.module("client", ["client.component", "client.disable.scrollbars"]),angular.module("client.disable.scrollbars", ["events"]).directive("habboClientDisableScrollbars", ["EVENTS", function (e) {
    return {
        restrict: "A", link: function (t, o) {
            t.$on(e.clientOpen, function () {
                o.css("overflow", "hidden")
            }), t.$on(e.clientClose, function () {
                o.css("overflow", "")
            })
        }
    }
}]),angular.module("client.component", ["angularScreenfull", "client.close.expander", "client.close.fullscreen.on.hide", "client.closed", "client.communication", "client.error", "client.reload", "client.service", "events", "flash", "interstitial", "locale", "notifier", "router", "security", "storage", "system.data", "templates"]).component("habboClient", {
    controller: ["$location", "$rootScope", "$scope", "$state", "Client", "EVENTS", "Session", "SystemData", "clientListener", "flash", "interstitial", "localStorage", "notifier", function (e, t, o, r, a, n, i, s, l, c, u, d, m) {
        function p() {
            var e = d.get("hotelLastAccess");
            return moment().subtract(60, "minutes").isBefore(e)
        }

        function h() {
            return g.client = a.get(), g.running = !0, g.client.$promise["catch"](function () {
                g.running = !1, m.error("ERROR_SERVER")
            })
        }

        function f(e) {
            e && (g.running = !1)
        }

        function b() {
            !_ && i.hasPreRollAd() && (u.start("preroll"), _ = !0)
        }

        var g = this, _ = !1;
        g.visible = !1, g.flashEnabled = c.isEnabled(), g.isOpen = s.isHotelOpen(), p() || "/logout" === e.path() || h(), g.close = function () {
            t.$broadcast(n.clientClose)
        }, g.reload = function () {
            t.$broadcast(n.clientOpen)
        }, o.$on(n.clientOpen, function () {
            b(), g.running || h(), d.set("hotelLastAccess", Date.now()), g.visible = !0
        }), o.$on(n.clientClose, function (e, t) {
            g.visible = !1, t || r.back()
        }), o.$on("$stateChangeSuccess", function (e, o, r, a) {
            "hotel" === a.name && t.$broadcast(n.clientClose, !0)
        }), o.$watch(l.hasDied, f), o.$watch(l.hasDisconnected, f)
    }], controllerAs: "ClientController", templateUrl: "hotel/client/client.html"
}),angular.module("client.close.fullscreen.on.hide", ["angularScreenfull", "events"]).directive("habboClientCloseFullscreenOnHide", ["EVENTS", function (e) {
    return {
        restrict: "A", require: "ngsfFullscreen", link: function (t, o, r, a) {
            t.$on(e.clientClose, function () {
                a.isFullscreen() && a.toggleFullscreen()
            })
        }
    }
}]),angular.module("client.service", ["ngResource", "config"]).factory("Client", ["$resource", "CONFIG", function (e, t) {
    return e(t.apiUrl + "/client/clienturl")
}]),angular.module("register.banner", ["air.download.link", "locale", "templates"]).component("habboRegisterBanner", {templateUrl: "home/register-banner/register-banner.html"}),angular.module("promos.service", ["config"]).factory("promos", ["$http", "$q", "CONFIG", function (e, t, o) {
    return {
        get: function () {
            var r = o.habboWebNewsUrl + "front.html";
            return e.get(r).then(function (e) {
                return {html: e.data}
            })["catch"](function () {
                return t.when({
                    html: ""
                })
            })
        }
    }
}]),angular.module("news", ["compile", "locale", "moderation.notification", "promos.service", "router", "templates", "web.pages"]).config(["$stateProvider", function (e) {
    e.statePublic("home.news", {
        url: "/",
        controller: "NewsController",
        controllerAs: "NewsController",
        data: {title: "HEAD_TITLE_NEWS"},
        resolve: {
            promos: ["promos", function (e) {
                return e.get()
            }]
        },
        parent: "home",
        templateUrl: "home/news/news.html"
    })
}]).controller("NewsController", ["promos", function (e) {
    var t = this;
    t.promos = e.html
}]),angular.module("housekeeping", ["security", "compile", "locale", "moderation.notification", "router", "templates", "web.pages"]).config(["$stateProvider", function (e) {
    e.statePublic("home.housekeeping", {
        url: "/housekeeping",
        data: {title: "Housekeeping"},
        resolve: {},
        parent: "home",
        templateUrl: "home/housekeeping/housekeeping.html"
    })
}]),angular.module("messaging", ["discussions", "locale", "router", "templates", "user.service"]).config(["$stateProvider", function (e) {
    e.statePrivate("home.messaging", {
        url: "/messaging",
        controller: "MessagingController",
        controllerAs: "MessagingController",
        data: {title: "HEAD_TITLE_MESSAGING"},
        resolve: {
            discussions: ["User", function (e) {
                return e.discussions().$promise
            }]
        },
        parent: "home",
        templateUrl: "home/messaging/messaging.html"
    })
}]).controller("MessagingController", ["discussions", function (e) {
    var t = this;
    t.discussions = e
}]),angular.module("user.service", ["ngResource", "config", "storage"]).factory("User", ["$resource", "CONFIG", "httpCache", function (e, t, o) {
    return e(t.apiUrl + "/user/:resource", null, {
        discussions: {
            method: "GET",
            isArray: !0,
            params: {resource: "discussions"},
            cache: o.shortCache
        }
    })
}]),angular.module("email.report.unauthorized.service", ["config", "google.analytics"]).factory("reportUnauthorized", ["$http", "CONFIG", "googleAnalytics", function (e, t, o) {
    return function (r, a) {
        return e.get(t.apiUrl + "/public/email/unauthorized/" + r + "/" + a).then(function () {
            o.trackEvent("Email", "Unauthorized email reported")
        })
    }
}]),angular.module("email.report.unauthorized", ["email.report.unauthorized.form", "header", "locale", "message.container", "router"]).config(["$stateProvider", function (e) {
    e.statePublic("reportUnauthorized", {
        url: "/identity/report_unauthorized_usage?email&hash",
        controller: "EmailReportUnauthorizedController",
        controllerAs: "EmailReportUnauthorizedController",
        data: {title: "HEAD_TITLE_EMAIL_REPORT_UNAUTHORIZED"},
        templateUrl: "email/email-report-unauthorized/email-report-unauthorized.html"
    })
}]).controller("EmailReportUnauthorizedController", ["$stateParams", function (e) {
    var t = this;
    t.email = e.email, t.hash = e.hash
}]),angular.module("email.report.unauthorized.form", ["email.report.unauthorized.service", "locale", "notifier", "router", "templates"]).component("habboEmailReportUnauthorizedForm", {
    bindings: {
        emailaddress: "<",
        hash: "<"
    },
    controller: ["$state", "notifier", "reportUnauthorized", function (e, t, o) {
        var r = this;
        r.reportInProgress = !1, r.report = function () {
            r.reportInProgress = !0, o(r.emailaddress, r.hash).then(function () {
                t.success("EMAIL_REPORT_UNAUTHORIZED_SUCCESS"), e.go("home.news")
            })["catch"](function () {
                t.error("ERROR_SERVER")
            })["finally"](function () {
                r.reportInProgress = !1
            })
        }
    }],
    controllerAs: "EmailReportUnauthorizedFormController",
    templateUrl: "email/email-report-unauthorized/email-report-unauthorized-form.html"
}),angular.module("optout.service", ["config", "google.analytics"]).factory("optout", ["$http", "CONFIG", "googleAnalytics", function (e, t, o) {
    return function (r, a) {
        return e.get(t.apiUrl + "/public/email/optout/" + r + "/" + a).then(function () {
            o.trackEvent("Email", "Optout")
        })
    }
}]),angular.module("email.optout", ["locale", "notifier", "optout.service", "router"]).config(["$stateProvider", function (e) {
    e.statePublic("optout", {
        url: "/email/marketing_off?email&hash",
        controller: "OptOutController",
        resolve: {
            optingout: ["$stateParams", "optout", function (e, t) {
                return t(e.email, e.hash)
            }]
        }
    })
}]).controller("OptOutController", ["$state", "notifier", function (e, t) {
    t.success("OPTOUT_SUCCESS"), e.go("home.news")
}]),angular.module("rooms", ["avatar", "config", "leaderboard.service", "locale", "official.room.avatar", "router"]).config(["$stateProvider", function (e) {
    e.statePublic("community.rooms", {
        url: "/rooms",
        parent: "community",
        controller: "RoomsController",
        controllerAs: "RoomsController",
        templateUrl: "community/rooms/rooms.html",
        data: {title: "HEAD_TITLE_ROOMS"},
        resolve: {
            rooms: ["Leaderboard", "CONFIG", function (e, t) {
                return e.get({site: t.hotel, leaderboard: "visited-rooms", timeframe: "daily", date: "latest"}).$promise
            }]
        }
    })
}]).controller("RoomsController", ["rooms", function (e) {
    var t = this;
    t.rooms = e
}]),angular.module("photos", ["columns", "locale", "photos.service", "router"]).config(["$stateProvider", function (e) {
    e.statePublic("community.photos", {
        url: "/photos",
        parent: "community",
        controller: "PhotosController",
        controllerAs: "PhotosController",
        templateUrl: "community/photos/photos.html",
        data: {title: "HEAD_TITLE_PHOTOS"},
        resolve: {
            photos: ["Photos", function (e) {
                return e.query().$promise
            }]
        }
    })
}]).controller("PhotosController", ["photos", function (e) {
    var t = this;
    t.photos = e
}]),angular.module("staff", ["locale", "router"]).config(["$stateProvider", function (e) {
    e.statePublic("community.staff", {
        url: "/staff",
        parent: "community",
        controller: "StaffController",
        controllerAs: "StaffController",
        templateUrl: "community/staff/staff.html",
        data: {title: "HEAD_TITLE_STAFF"},
    })
}]).controller("StaffController", [function () {
    var t = this;
}]),angular.module("photos.service", ["ngResource", "config", "reported.photos", "safe.transform.response", "storage"]).factory("Photos", ["$resource", "CONFIG", "httpCache", "reportedPhotosFilter", "safeTransformResponse", function (e, t, o, r, a) {
    return e(t.extraDataUrl + "/public/photos", null, {
        query: {
            isArray: !0,
            cache: o.shortCache,
            transformResponse: a.fromJson(function (e) {
                var t = r(e);
                return _.map(t, function (e) {
                    return _.assign(e, {
                        url: "https:" + e.url,
                        contentWidth: 320,
                        contentHeight: 320,
                        parentTitle: "PHOTOS_TITLE",
                        pool: "photos"
                    })
                })
            })
        }
    })
}]),angular.module("fansites", ["locale", "router", "templates", "web.pages"]).config(["$stateProvider", function (e) {
    e.statePublic("community.fansites", {
        url: "/fansites",
        controller: "FansitesController",
        controllerAs: "FansitesController",
        data: {title: "HEAD_TITLE_FANSITES"},
        resolve: {
            fansites: ["webPages", function (e) {
                return e.get("community/fansites")
            }]
        },
        parent: "community",
        templateUrl: "community/fansites/fansites.html"
    })
}]).controller("FansitesController", ["fansites", function (e) {
    var t = this;
    t.fansites = e
}]),angular.module("category.service", ["config"]).factory("category", ["$http", "CONFIG", function (e, t) {
    return {
        get: function (o, r) {
            var a = o.replace(/-/g, "_"), n = t.habboWebNewsUrl + a + "_" + r + ".html";
            return e.get(n).then(function (e) {
                return {
                    titleKey: angular.element(e.data).find(".news-category__link--active").attr("translate"),
                    html: e.data
                }
            })
        }
    }
}]),angular.module("category", ["category.service", "compile", "locale", "router", "templates", "web.pages"]).config(["$stateProvider", "$urlRouterProvider", function (e, t) {
    e.statePublic("community.category", {
        url: "/category/{category:(?:[^/]+)}{archive:(?:/[^0-9lst/]+)?}/{page}",
        controller: "CategoryController",
        controllerAs: "CategoryController",
        onEnter: ["category", "Head", function (e, t) {
            t.setTitle(e.titleKey)
        }],
        resolve: {
            category: ["$location", "$q", "$stateParams", "category", function (e, t, o, r) {
                var a = o.archive.replace("/", "_");
                return r.get(o.category + a, o.page)["catch"](function (r) {
                    return 0 !== a.length || "1" !== o.page && "last" !== o.page ? a.length > 0 && "1" === o.page ? (e.path("/community/category").replace(), t.when({})) : t.reject(r) : (e.path("/community/category/" + o.category + "/archive/1").replace(), t.when({}))
                })
            }]
        },
        parent: "community",
        templateUrl: "community/category/category.html"
    }), t.when("/community/category", "/community/category/all"), t.when("/community/category/:category", "/community/category/:category/1")
}]).controller("CategoryController", ["category", function (e) {
    var t = this;
    t.category = e.html
}]),angular.module("article.service", ["config"]).factory("article", ["$http", "CONFIG", function (e, t) {
    return {
        get: function (o, r) {
            var a = r.replace(/-/g, "_"), n = t.habboWebNewsUrl + "articles/" + o + "_" + a + ".html";
            return e.get(n).then(function (e) {
                var t = angular.element(e.data);
                return {
                    title: t.find("h1, h2, h3, h4, h5, h6").eq(0).text(),
                    summary: t.find(".news-header__summary").text(),
                    image: t.find("img").eq(0).attr("src"),
                    html: e.data
                }
            })
        }
    }
}]),angular.module("article", ["article.service", "compile", "lightbox", "locale", "router", "social.share", "templates", "web.pages"]).config(["$stateProvider", "$urlRouterProvider", function (e, t) {
    e.statePublic("community.article", {
        url: "/article/:id/:title",
        controller: "ArticleController",
        controllerAs: "ArticleController",
        onEnter: ["article", "Head", function (e, t) {
            t.title = e.title, t.description = e.summary, t.image = e.image, t.imageHeight = 300, t.imageWidth = 759
        }],
        resolve: {
            article: ["$stateParams", "article", function (e, t) {
                return t.get(e.id, e.title)
            }]
        },
        parent: "community",
        templateUrl: "community/article/article.html"
    }), t.when("/article/:id/:slug", "/community/article/:id/:slug"), t.when("/articles/{id:[0-9]*}-{slug:[a-z-]*}", "/article/:id/:slug")
}]).controller("ArticleController", ["article", function (e) {
    var t = this;
    t.article = e.html
}]),angular.module("zendesk.url", ["config", "security"]).filter("zendeskRedirectUrl", ["CONFIG", "Session", function (e, t) {
    var o = function (o, r) {
        return r === !0 || t.hasSession() && _(o).includes("help.habbo") ? e.apiUrl + "/public/help?returnTo=" + o : o
    };
    return o.$stateful = !0, o
}]),angular.module("web.pages.service", ["config"]).factory("webPages", ["$http", "CONFIG", function (e, t) {
    return {
        get: function (o) {
            var r = t.habboWebPagesUrl + o + "." + t.lang + ".html";
            return e.get(r).then(function (e) {
                return e.data
            })
        }
    }
}]),angular.module("web.pages", ["web.pages.service"]).component("habboWebPages", {
    bindings: {key: "@"},
    controller: ["$animate", "$compile", "$element", "$scope", "webPages", function (e, t, o, r, a) {
        e.addClass(o, "ng-hide"), r.$watch("WebPagesController.key", function (n) {
            a.get(n).then(function (a) {
                var n = o.children().first();
                n.html(a), t(n.contents())(r), e.removeClass(o, "ng-hide")
            })
        })
    }],
    controllerAs: "WebPagesController",
    template: '<aside class="static-content"></aside>'
}),angular.module("tabs", ["locale", "tab", "templates"]).component("habboTabs", {
    bindings: {titleKey: "@"},
    controller: function () {
        var e = this;
        e.open = !1, e.tabs = [], e.activeTab = null, e.setTab = function (t) {
            e.tabs.push(t)
        }, e.setActive = function (t) {
            e.open = !1, e.activeTab = _.find(e.tabs, {path: t})
        }
    },
    controllerAs: "TabsController",
    templateUrl: "common/tabs/tabs.html",
    transclude: !0
}),angular.module("tab", ["locale", "templates"]).component("habboTab", {
    require: {HabboTabsController: "^habboTabs"},
    bindings: {path: "@", alternativePath: "@", strictPath: "@", translationKey: "@"},
    controller: ["$scope", "$location", function (e, t) {
        function o() {
            a.active = "true" === a.strictPath ? t.path() === a.path : r(), a.active && a.HabboTabsController.setActive(a.path)
        }

        function r() {
            return 0 === t.path().indexOf(a.path) || 0 === t.path().indexOf(a.alternativePath)
        }

        var a = this;
        a.open = !1, a.$onInit = function () {
            a.HabboTabsController.setTab({path: a.path, translationKey: a.translationKey}), o()
        }, e.$on("$stateChangeSuccess", o)
    }],
    controllerAs: "TabController",
    templateUrl: "common/tabs/tab.html"
}),angular.module("system.data", []).factory("SystemData", ["$window", function (e) {
    var t = {};
    return t.geoLocation = {
        continent: e.geoLocation ? e.geoLocation.continent : null,
        country: e.geoLocation ? e.geoLocation.country : null
    }, t.getShopCountry = function () {
        return "gb" === t.geoLocation.country ? "uk" : t.geoLocation.country
    }, t.isHotelOpen = function () {
        var t = e.systemData && e.systemData.open;
        return t !== !1
    }, t.isIDCGamesCountry = function () {
        var t = e.partnerCodeInfo && e.partnerCodeInfo.partner;
        return "idcse" === t
    }, t
}]),angular.module("storage", ["cache", "local.storage"]),angular.module("sticky.header", []).directive("habboStickyHeader", ["$window", function (e) {
    return {
        restrict: "A", link: function (t, o) {
            function r() {
                var t = e.pageYOffset > 0 ? e.pageYOffset : 0, r = i - t;
                t <= o.height() ? o.addClass("sticky-header--top") : o.removeClass("sticky-header--top"), 0 === t && o.removeClass("sticky-header--fixed"), r > 0 && a(r) && t > o.height() ? o.addClass("sticky-header--fixed") : 0 > r && a(r) && (o.hasClass("sticky-header--fixed") && o.addClass("sticky-header--hidden"), o.removeClass("sticky-header--fixed")), (o.hasClass("sticky-header--fixed") || o.hasClass("sticky-header--top")) && o.removeClass("sticky-header--hidden"), i = t
            }

            function a(e) {
                return Math.abs(e) > n
            }

            var n = 5, i = e.pageYOffset;
            i <= o.height() ? o.addClass("sticky-header sticky-header--top") : o.addClass("sticky-header sticky-header--fixed"), angular.element(e).on("orientationchange resize scroll", r), o.on("$destroy", function () {
                angular.element(e).off("orientationchange resize scroll", r)
            })
        }
    }
}]),angular.module("social.share", ["config", "google.analytics", "locale", "popup", "router", "templates"]).component("habboSocialShare", {
    controller: ["$location", "CONFIG", "Head", "googleAnalytics", "popup", function (e, t, o, r, a) {
        var n = this;
        n.shareOnFacebook = function () {
            var t = $.param({u: e.absUrl()}), o = "http://www.facebook.com/sharer.php?" + t;
            r.trackSocial("Facebook", "Share", e.url()), a.open(o, 626, 436)
        }, n.shareOnTwitter = function () {
            var n = $.param({
                url: e.absUrl(),
                text: o.title,
                hashtags: "Habbo",
                related: t.twitterAccount.substring(1)
            }), i = "https://twitter.com/intent/tweet?" + n;
            r.trackSocial("Twitter", "Tweet", e.url()), a.open(i, 550, 420)
        }
    }], controllerAs: "SocialShareController", templateUrl: "common/social-share/social-share.html"
}),angular.module("show.on.load", []).directive("habboShowOnLoad", function () {
    return {
        restrict: "A", link: function (e, t) {
            t.hide(), t.on("load", function () {
                t.show()
            })
        }
    }
}),angular.module("safe.transform.response", []).factory("safeTransformResponse", function () {
    var e = {};
    return e.fromJson = function (e) {
        return function (t) {
            var o;
            try {
                return o = angular.fromJson(t), e(o)
            } catch (r) {
                return t
            }
        }
    }, e
}),angular.module("reported.photos.service", ["storage"]).factory("reportedPhotos", ["localStorage", function (e) {
    var t = "reportedPhotos", o = {}, r = e.get(t) || [];
    return o.save = function (o) {
        r.push(o), e.set(t, r)
    }, o.get = function () {
        return r
    }, o
}]),angular.module("reported.photos", ["reported.photos.service"]).filter("reportedPhotos", ["reportedPhotos", function (e) {
    return function (t) {
        var o = e.get();
        return _.filter(t, function (e) {
            return !_.includes(o, e.id)
        })
    }
}]),angular.module("remove.on.error", []).directive("habboRemoveOnError", function () {
    return {
        restrict: "A", link: function (e, t) {
            t[0].onerror = function () {
                t.remove()
            }
        }
    }
}),angular.module("popup", []).factory("popup", ["$interval", "$q", "$window", function (e, t, o) {
    function r(e, t) {
        var r = o.innerWidth, i = o.innerHeight;
        return e = e || n, t = t || a, ["width=" + (r >= e ? e : r), "height=" + (i >= t ? t : i)].join(",")
    }

    var a = 768, n = 1024, i = {};
    return i.open = function (a, n, i) {
        var s = t.defer(), l = o.open(a, "_blank", r(n, i)), c = e(function () {
            l && !l.closed || (s.resolve(), e.cancel(c))
        }, 100);
        return s.promise
    }, i
}]),angular.module("official.room.avatar", ["locale", "templates"]).component("officialRoomAvatar", {templateUrl: "common/official-room-avatar/official-room-avatar.html"}),angular.module("notifier", ["locale"]).factory("notifier", ["$q", "$translate", function (e, t) {
    var o = {
            extendedTimeOut: 1e3,
            hideDuration: 300,
            positionClass: "toast-top-center",
            preventDuplicates: !0,
            progressBar: !0,
            showDuration: 300,
            timeOut: 2e4
        }, r = _.extend({}, o, {
            extendedTimeOut: 0,
            hideDuration: 0,
            positionClass: "toast-top-center toast-sticky",
            timeOut: 0,
            tapToDismiss: !1
        }), a = _.partialRight(toastr.success, "", o), n = _.partialRight(toastr.error, "", o),
        i = _.partialRight(toastr.error, r), s = function (e) {
            return function (o, r) {
                t(o, r).then(e)["catch"](e)
            }
        }, l = function (o) {
            return function (r, a, n) {
                e.all([t(a, n), t(r), t("OK_BUTTON")]).then(function (e) {
                    var t = o(e[0] + '<button class="toast-button">' + e[2] + "</button>", e[1]);
                    t.delegate("button", "click", function () {
                        toastr.options.hideDuration = 0, toastr.clear(t, {force: !0})
                    })
                })
            }
        };
    return {success: s(a), error: s(n), errorSticky: l(i)}
}]),angular.module("navigate.to.on.key", []).directive("habboNavigateToOnKey", ["$document", function (e) {
    function t(e) {
        var t = {left: 37, right: 39};
        return t[e]
    }

    return {
        restrict: "A", link: function (o, r, a) {
            function n(e) {
                e.which === i && (e.preventDefault(), r.trigger("click"))
            }

            var i = t(a.habboNavigateToOnKey);
            angular.element(e).keydown(n), r.on("$destroy", function () {
                angular.element(e).unbind("keydown", n)
            })
        }
    }
}]),angular.module("message.container", ["angular-multiple-transclusion", "templates"]).component("habboMessageContainer", {
    templateUrl: "common/message-container/message-container.html",
    transclude: !0
}),angular.module("my.like.cache", []).factory("myLikeCache", function () {
    var e = {}, t = {};
    return e.like = function (e) {
        t[e] = "like"
    }, e.unlike = function (e) {
        t[e] = "unlike"
    }, e.hasLike = function (e) {
        return "like" === t[e]
    }, e.hasUnlike = function (e) {
        return "unlike" === t[e]
    }, e
}),angular.module("like.service", ["config", "like.filters", "my.like.cache", "security"]).factory("like", ["$http", "CONFIG", "Session", "myLikeCache", function (e, t, o, r) {
    function a(e, t) {
        401 !== t && (r.like(e.id), e.likes = _.uniq(e.likes.concat(o.user.name)))
    }

    function n(e, t) {
        401 !== t && (r.unlike(e.id), _.remove(e.likes, _.matches(o.user.name)))
    }

    var i = {};
    return i.like = function (o) {
        e.post(t.extraDataUrl + "/private/like/" + o.id).then(function (e) {
            a(o, e.status)
        })["catch"](function (e) {
            a(o, e.status)
        })
    }, i.unlike = function (o) {
        e.post(t.extraDataUrl + "/private/unlike/" + o.id).then(function (e) {
            n(o, e.status)
        })["catch"](function (e) {
            n(o, e.status)
        })
    }, i
}]),angular.module("like.filters", ["security"]).filter("myLike", ["Session", function (e) {
    return function (t) {
        return _.find(t.likes, function (t) {
            return e.hasSession() ? t === e.user.name : !1
        })
    }
}]).filter("othersLikes", ["Session", function (e) {
    return function (t) {
        return _.filter(t.likes, function (t) {
            return e.hasSession() ? t !== e.user.name : !0
        })
    }
}]),angular.module("like", ["avatar", "false.on.outside.click", "like.filters", "like.service", "locale", "my.like.cache", "security", "templates"]).component("habboLike", {
    bindings: {data: "="},
    controller: ["$timeout", "Session", "like", "myLikeCache", "myLikeFilter", function (e, t, o, r, a) {
        var n = this, i = a(n.data);
        r.hasLike(n.data.id) && !i && n.data.likes.push(t.user.name), r.hasUnlike(n.data.id) && i && _.remove(n.data.likes, _.matches(i)), n.show = !1, n.mouseenter = function () {
            e(function () {
                n.show = !0
            })
        }, n.like = function () {
            o.like(n.data)
        }, n.unlike = function () {
            o.unlike(n.data)
        }
    }],
    controllerAs: "LikeController",
    templateUrl: "common/like/like.html"
}),angular.module("lightbox.modal", ["templates", "ui.bootstrap"]).controller("LightboxController", ["src", function (e) {
    var t = this;
    t.src = e
}]).factory("lightbox", ["$uibModal", function (e) {
    var t = {};
    return t.open = function (t) {
        return e.open({
            animation: !1,
            backdropClass: "lightbox-backdrop",
            controller: "LightboxController",
            controllerAs: "LightboxController",
            resolve: {src: _.constant(t)},
            templateUrl: "common/lightbox/lightbox-modal.html",
            windowClass: "lightbox-modal"
        }).result
    }, t
}]),angular.module("lightbox", ["lightbox.modal"]).directive("habboLightbox", ["lightbox", function (e) {
    return {
        restrict: "A", link: function (t, o, r) {
            o.click(function (t) {
                t.preventDefault(), e.open(r.href)
            })
        }
    }
}]),angular.module("leaderboard.service", ["ngResource", "config", "storage"]).factory("Leaderboard", ["$resource", "CONFIG", "httpCache", function (e, t, o) {
    return e(t.habboWebLeaderboardsUrl + "/:site/:leaderboard/:timeframe/:date.json", null, {
        get: {
            method: "GET",
            isArray: !0,
            cache: o.shortCache
        }
    })
}]),angular.module("imager.service", ["angular-md5", "config"]).factory("imager", ["CONFIG", "md5", function (e, t) {
    function o(e) {
        return _(e).transform(function (e, t, o) {
            return e.push(o + "-" + t), e
        }, []).join(".")
    }

    var r = {}, a = "ef2356a4926bf225eb86c75c52309c32";
    return r.generatePose = function (e) {
        var t = e.size || "big", o = e.direction || "sw", r = e.headDirection || o, a = e.action || "stand",
            n = e.gesture || "smile", i = {};
        return i.s = {big: 0, bighead: 2, smallhead: 3, large: 4, largehead: 5}[t.toLowerCase()], i.g = {
            none: 0,
            smile: 1,
            angry: 2,
            surprise: 3,
            sad: 4,
            speak: 5,
            eyebrows: 6
        }[n.toLowerCase()], i.d = {nw: 0, w: 1, sw: 2, s: 3, se: 4, e: 5, ne: 6, n: 7}[o.toLowerCase()], i.h = {
            nw: 0,
            w: 1,
            sw: 2,
            s: 3,
            se: 4,
            e: 5,
            ne: 6,
            n: 7
        }[r.toLowerCase()], i.a = {stand: 0, sit: 1, walk: 2, wave: 3, lay: 4, carry: 5, drink: 6}[a.toLowerCase()], i
    }, r.get2xSize = function (e) {
        return {big: "large", bighead: "largehead", smallhead: "bighead"}[e || "big"]
    }, r.getDimensions = function (e) {
        return {
            big: {width: 64, height: 110},
            bighead: {width: 54, height: 62},
            smallhead: {width: 27, height: 30},
            large: {width: 128, height: 220},
            largehead: {width: 108, height: 124}
        }[e || "big"]
    }, r.getBodyImageUrl = function (r, n) {
        var i = o(n), s = t.createHash(r + i + a);
        return window.chocolatey.url + "habbo-imaging/avatar/" + encodeURIComponent(r + "," + i + "," + s) + ".png"
    }, r.getImagerUrl = function (r, n) {
        var i = o(n), s = t.createHash(r + i + a);
        return window.chocolatey.url + "habbo-imaging/avatarimage?figure=" + encodeURIComponent(r + "," + i + "," + s) + "&size=l&headonly=1"
    }, r.getLegacyImagerUrl = function (t, o) {
        return window.chocolatey.url + "habbo-imaging/avatarimage?" + $.param({
                user: t,
                headonly: 2 === o.s || 3 === o.s || 5 === o.s ? 1 : 0,
                size: {0: "b", 1: "s", 2: "b", 3: "s", 4: "l", 5: "l"}[o.s],
                gesture: {0: "", 1: "sml", 2: "agr", 3: "srp", 4: "sad", 5: "spk", 6: "eyb"}[o.g],
                direction: o.d,
                head_direction: o.h,
                action: {0: "std", 1: "sit", 2: "wlk", 3: "wav", 4: "lay", 5: "crr", 6: "drk"}[o.a]
            })
    }, r
}]),angular.module("imager", ["imager.service", "templates"]).component("habboImager", {
    bindings: {
        figure: "@",
        user: "@",
        name: "@",
        size: "@",
        direction: "@",
        headDirection: "@",
        action: "@",
        gesture: "@"
    }, controller: ["$scope", "imager", function (e, t) {
        function o(e) {
            var o = {
                size: e || r.size,
                direction: r.direction,
                headDirection: r.headDirection,
                action: r.action,
                gesture: r.gesture
            }, a = t.generatePose(o);
            return r.action ? t.getBodyImageUrl(r.figure, a) : r.figure ? t.getImagerUrl(r.figure, a) :
                r.user ? t.getLegacyImagerUrl(r.user, a) : void 0
        }

        var r = this;
        r.dimensions = t.getDimensions(r.size), r.src = o();
        var a = "bighead" === r.size && r.figure ? null : t.get2xSize(r.size);
        a && (r.src2x = o(a))
    }], controllerAs: "ImagerController", templateUrl: "common/imager/imager.html"
}),angular.module("hotel.closed", ["locale", "templates"]).component("habboHotelClosed", {templateUrl: "common/hotel-closed/hotel-closed.html"}),angular.module("header", ["header.ad", "locale", "navigation", "security", "sticky.header", "templates", "user.menu"]).component("habboHeaderLarge", {
    bindings: {active: "@"},
    controllerAs: "HeaderLargeController",
    templateUrl: "common/header/header-large.html",
    transclude: !0
}).component("habboHeaderSmall", {
    bindings: {active: "@"}, controller: ["loginModal", function (e) {
        var t = this;
        t.openLoginModal = e.open
    }], controllerAs: "HeaderSmallController", templateUrl: "common/header/header-small.html", transclude: !0
}),angular.module("group.badge", ["config", "templates"]).component("habboGroupBadge", {
    bindings: {
        code: "@",
        name: "@"
    }, controller: ["CONFIG", function (e) {
        var t = this;
        t.imagingUrl = e.groupBadgeUrl
    }], controllerAs: "GroupBadgeController", templateUrl: "common/group-badge/group-badge.html"
}),angular.module("google.analytics", []).factory("googleAnalytics", ["$window", function (e) {
    function t(t) {
        e.Bugsnag && e.Bugsnag.notifyException(t, "GA not supported", {groupingHash: "GA"}, "info")
    }

    var o = {};
    return o.trackEvent = function (o, r, a, n) {
        try {
            e.ga("send", "event", o, r, a, n)
        } catch (i) {
            t(i)
        }
    }, o.trackPageView = function (o) {
        try {
            e.ga("send", "pageview", o)
        } catch (r) {
            t(r)
        }
    }, o.trackSocial = function (o, r, a) {
        try {
            e.ga("send", "social", o, r, a)
        } catch (n) {
            t(n)
        }
    }, o.trackTransaction = function (o, r, a, n, i, s) {
        try {
            e.ga("ecommerce:addTransaction", {id: o, currency: s, revenue: i}), e.ga("ecommerce:addItem", {
                id: o,
                name: r,
                sku: a,
                category: n,
                price: i,
                quantity: "1"
            }), e.ga("ecommerce:send")
        } catch (l) {
            t(l)
        }
    }, o
}]).run(["$location", "$rootScope", "$timeout", "googleAnalytics", function (e, t, o, r) {
    t.$on("$stateChangeSuccess", function () {
        o(function () {
            r.trackPageView(e.url())
        })
    })
}]),angular.module("form", ["captcha", "email.address", "password.current", "password.new", "password.toggle.mask", "search", "validators"]),angular.module("footer", ["locale", "templates", "zendesk.url"]).constant("FOOTER_LINKS", ["FOOTER_SAFETY", "FOOTER_PARENTS", "FOOTER_TOS_AND_PRIVACY", "FOOTER_ADVERTISERS"]).component("habboFooter", {
    controller: ["FOOTER_LINKS", function (e) {
        var t = this;
        t.links = e, t.currentYear = (new Date).getFullYear()
    }], controllerAs: "FooterController", templateUrl: "common/footer/footer.html"
}),angular.module("flash.require", ["flash.service"]).directive("habboRequireFlash", ["flash", "ngIfDirective", function (e, t) {
    var o = t[0];
    return {
        restrict: "A",
        priority: o.priority,
        terminal: o.terminal,
        transclude: o.transclude,
        link: function (t, r, a) {
            a.ngIf = e.isSupported, o.link.apply(o, arguments)
        }
    }
}]),angular.module("flash", ["flash.href", "flash.require", "flash.service"]),angular.module("flash.service", []).factory("flash", function () {
    var e = {};
    return e.isEnabled = function () {
        return swfobject.hasFlashPlayerVersion("11")
    }, e.isSupported = function () {
        return e.isEnabled() || !bowser.mobile
    }, e
}),angular.module("flash.href", ["flash.service"]).directive("habboFlashHref", ["flash", function (e) {
    return {
        restrict: "A", link: function (t, o, r) {
            e.isSupported() && r.$observe("habboFlashHref", function (e) {
                e && r.$set("href", e)
            })
        }
    }
}]),angular.module("false.on.outside.click", []).directive("habboFalseOnOutsideClick", function () {
    return {
        restrict: "A", link: function (e, t, o) {
            function r(r) {
                0 === angular.element(r.target).closest(t).length && e.$apply(function () {
                    e.$eval(o.habboFalseOnOutsideClick + " = false;")
                })
            }

            e.$watch(o.habboFalseOnOutsideClick, function (e) {
                e ? angular.element("body").on("click touchstart", r) : angular.element("body").off("click touchstart", r)
            }), t.on("$destroy", function () {
                angular.element("body").off("click touchstart", r)
            })
        }
    }
}),angular.module("eu.cookie.banner", ["locale", "storage", "system.data", "templates"]).component("habboEuCookieBanner", {
    controller: ["SystemData", "localStorage", function (e, t) {
        var o = this;
        o.show = !1, t.get("acceptCookies") || (window.chocolatey.cookieBanner == true ? o.show = !0 : t.set("acceptCookies", !0)), o.close = function () {
            o.show = !1, t.set("acceptCookies", !0)
        }
    }], controllerAs: "EuCookieBannerController", templateUrl: "common/eu-cookie-banner/eu-cookie-banner.html"
}),angular.module("encode.uri.component", []).filter("encodeURIComponent", ["$window", function (e) {
    return e.encodeURIComponent
}]),angular.module("empty.results", ["locale", "templates"]).component("habboEmptyResults", {
    bindings: {translationKey: "@"},
    controllerAs: "EmptyResultsController",
    templateUrl: "common/empty-results/empty-results.html"
}),angular.module("creation.href", ["encode.uri.component"]).directive("habboCreationHref", ["encodeURIComponentFilter", function (e) {
    return {
        restrict: "A", link: function (t, o, r) {
            t.$watch(r.habboCreationHref, function (t) {
                if (t) {
                    var o = "PHOTO" === t.type ? "photo" : "story",
                        a = ["profile", e(t.creator_name), o, t.id].join("/");
                    t.pool && (a += "?pool=" + t.pool), r.$set("href", "/" + a)
                }
            })
        }
    }
}]),angular.module("console.warning", ["locale"]).factory("warning", function () {
    var e = {};
    return e.HEADER = ["                                                                        ,,,   ", "  ,,,,,,,,,,,,,,, ,,,,,,,,,,,,,,,,,,,,,,, ,,,,,,,,,,,,    ,,,,,,,,,,   ,::,,  ", ",,@@@@@@@@@@@@@@:,:@@@@@@@@::@@@@@@@@@@@::@@@@@@@@@@@@:,,,:@@@@@@@@:,,,::: :, ", ",,@@@@@@@@@@@@@@@:@@@@@@@@@@:@@@@@@@@@@@@@@@@@@@@@@@@@@:,:@@@@@@@@@@:,:   : ,,", ",,@@,,,,,@,,,,,,@@,,,,,,,,,,@@,,,,,,,,,,,@@@,,,,,,,,,,@@@@,,,,,,,,,,@@:  :: ,,", ",,@@,,,,,@,,,,,,@@,,,,,,,,,,@@,,,,,,,,,,,,@@,,,,,,,,,,,@@@,,,,,,,,,,@@:::: :,,", ",,@@,,,,,@,,,,,,@,,,,,,,,,,,,@,,,,,,,,,,,,@@,,,,,,,,,,,,@,,,,,,,,,,,,@@@::,,, ", ",,@@,,,,,@,,,,,,@,,,,,,,,,,,,@,,,,,,,,,,,,@@,,,,,,,,,,,,@,,,,,,,,,,,,@@@:,,,  ", ",,@@,,,,,@,,,,,,@,,,,,@@,,,,,@,,,,,,@,,,,,@@,,,,,@,,,,,,@,,,,,@@,,,,,@;;@@,,  ", ",,@@,,,,,@,,,,,,@,,,,,@@,,,,,@,,,,,,@,,,,,@@,,,,,@,,,,,,@,,,,,@@,,,,,@;;@@:,  ", ",,@@,,,,,,,,,,,,@,,,,,@@,,,,,@,,,,,,@,,,,,@@,,,,,@,,,,,,@,,,,,@@,,,,,@;;;;@:, ", ",,@@,,,,,,,,,,,,@,,,,,@@,,,,,@,,,,,,,,,,,,@@,,,,,,,,,,,,@,,,,,@@,,,,,@;;;;@@,,", ",,@@,,,,,,,,,,,,@,,,,,@@,,,,,@,,,,,,,,,,@@@@,,,,,,,,,,@@@,,,,,@@,,,,,@;;;;@@,,", ",,@@::::::::::::@:::::@@:::::@::::::::::@@@@::::::::::@@@:::::@@:::::@;;;;@@,,", ",,@@::::::::::::@::::::::::::@::::::::::::@@::::::::::::@:::::@@:::::@;;;;@@,,", ",,@@::::::::::::@::::::::::::@::::::@:::::@@:::::@::::::@:::::@@:::::@;;;;@@,,", ",,@@:::::@::::::@::::::::::::@::::::@:::::@@:::::@::::::@:::::@@:::::@;;;;@@,,", ",,@@:::::@::::::@:::::@@:::::@::::::@:::::@@:::::@::::::@:::::@@:::::@;;;;@@,,", ",,@@:::::@::::::@:::::@@:::::@::::::::::::@@::::::::::::@::::::::::::@;;;;@@,,", ",,@@:::::@::::::@:::::@@:::::@::::::::::::@@::::::::::::@::::::::::::@;;;;@@,,", ",,@@:::::@::::::@:::::@@:::::@::::::::::::@@:::::::::::@@@::::::::::@@;;;;@@,,", ",,@@:::::@::::::@:::::@@:::::@:::::::::::@@@::::::::::@@@@::::::::::@@;;;;@@,,", ",,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@;;;@@@@@@@@@@;;;;;;@@,,", ",,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@;;@@@@@@@@@@@;;;;;@@@@@@@@@;;;;;;;@@,,", ",,,:@@;;;;@@;;;;;@@;;;;;@@;;;;@@;;;;;;;;;;;;@@;;;;;;;;;;;;;;@@;;;;;;;;;;;;@@,,", " ,,,@@;;;;;@@;;;;;@@;;;;@@;;;;;@@;;;;;;;;;;;@@;;;;;;;;;;;;;;@@;;;;;;;;;;;;@:,,", "  ,,,:@@;;;;@@;;;;;@@;;;;;@@;;;;@@;;;;;;;;;;@@@@;;;;;;;;;;@@@:@@;;;;;;;;@@:,, ", "   ,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@:,@@@@@@@@@@@@,,, ", "    ,,,:::::::::::::::::::::::::::::::::::::::,::::::::::::,,,,,::::::::,,,,  ", "     ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,   ", "      ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,   ,,,,,,,,,,     ", "                                                                              ", "                                                                              "], e.FOOTER = ["                                                                              ", "                                                                   - Chocolatey"], e.format = function (t) {
        var o = [], r = "";
        return t.split(" ").forEach(function (t) {
            r.length + t.length + 5 > e.HEADER[0].length && (o.push(r), r = ""), r += t + " "
        }), r && o.push(r), _.map(o, function (e) {
            return "  " + e.trim()
        })
    }, e
}).run(["$log", "$translate", "warning", function (e, t, o) {
    t("CONSOLE_WARNING").then(function (t) {
        var r = o.format(t);
        e.info(o.HEADER.join("\n") + "\n" + r.join("\n") + "\n" + o.FOOTER.join("\n"))
    })
}]),angular.module("compile", []).component("habboCompile", {
    bindings: {data: "<"},
    controller: ["$compile", "$element", "$scope", function (e, t, o) {
        var r = this;
        t.html(r.data), e(t.contents())(o)
    }]
}),angular.module("columns", ["columns.channel", "columns.profile"]),angular.module("by.name.description.or.motto.filter", []).filter("byNameDescriptionOrMotto", function () {
    return function (e, t) {
        return _.filter(e, function (e) {
            return !t || e.name && _(e.name.toLowerCase()).includes(t.toLowerCase()) || e.description && _(e.description.toLowerCase()).includes(t.toLowerCase()) || e.motto && _(e.motto.toLowerCase()).includes(t.toLowerCase())
        })
    }
}),angular.module("badge", ["config", "templates"]).component("habboBadge", {
    bindings: {code: "@", name: "@"},
    controller: ["CONFIG", function (e) {
        var t = this;
        t.badgeUrl = e.badgeUrl
    }],
    controllerAs: "BadgeController",
    templateUrl: "common/badge/badge.html"
}),angular.module("avatar", ["encode.uri.component", "imager", "templates"]).component("habboAvatar", {
    bindings: {
        big: "@",
        user: "@"
    }, controllerAs: "AvatarController", templateUrl: "common/avatar/avatar.html"
}),angular.module("ios.download.link", ["config", "google.analytics"]).directive("habboIosDownloadLink", ["CONFIG", "googleAnalytics", function (e, t) {
    return {
        restrict: "A", link: function (o, r, a) {
            bowser.ios && (a.$set("href", e.appStoreUrl), a.$set("target", "_blank"), a.$set("rel", "noopener noreferrer"), r.click(function () {
                t.trackEvent("Download", "App Store")
            }))
        }
    }
}]),angular.module("air.download.link", ["android.download.link", "ios.download.link"]),angular.module("android.download.link", ["config", "google.analytics"]).directive("habboAndroidDownloadLink", ["CONFIG", "googleAnalytics", function (e, t) {
    return {
        restrict: "A", link: function (o, r, a) {
            bowser.android && (a.$set("href", e.googlePlayUrl), a.$set("target", "_blank"), a.$set("rel", "noopener noreferrer"), r.click(function () {
                t.trackEvent("Download", "Google Play")
            }))
        }
    }
}]),angular.module("ad.unit", ["ad.double.click", "security", "templates"]).component("habboAdUnit", {
    bindings: {unit: "@"},
    controller: ["$location", "Session", function (e, t) {
        var o = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i,
            r = this;
        r.hasAds = t.hasAds, r.isAdsPrevented = function () {
            var t = e.search(), r = _(t).values().find(function (e) {
                return o.test(e)
            });
            return Boolean(r)
        }
    }],
    controllerAs: "AdUnitController",
    templateUrl: "common/ad-unit/ad-unit.html"
}),angular.module("accordion", ["accordion.grid", "accordion.item", "accordion.item.content", "accordion.item.preview"]),angular.module("accordion.item.preview", []).component("habboAccordionItemPreview", {
    require: {AccordionItemController: "^habboAccordionItem"},
    controllerAs: "AccordionItemPreviewController",
    template: '<div ng-click="AccordionItemPreviewController.AccordionItemController.toggle()" ng-transclude></div>',
    transclude: !0
}),angular.module("accordion.item.content", ["ngAnimate", "events", "templates"]).component("habboAccordionItemContent", {
    require: {
        AccordionItemController: "^habboAccordionItem"
    },
    controller: ["$animate", "$element", "$scope", "$timeout", "EVENTS", function (e, t, o, r, a) {
        function n() {
            m = u()
        }

        function i() {
            angular.isUndefined(m) && n(), c({height: 0, opacity: 0}, {height: m, opacity: 1}), p.height = m
        }

        function s() {
            c({height: m, opacity: 1}, {
                height: 0,
                opacity: 0
            }), m = void 0, p.height = 0, p.AccordionItemController.expanded = !1
        }

        function l() {
            0 !== p.height && r(function () {
                var e = u();
                c({height: p.height}, {height: e}), p.height = e
            })
        }

        function c(t, o) {
            d && e.cancel(d), d = e.animate(h, t, o)
        }

        function u() {
            var e = h.css("height", "").actual("outerHeight");
            return h.css("height", p.height), e
        }

        var d, m, p = this, h = t.children().first();
        p.height = 0, o.$on(a.accordionOpen, i), o.$on(a.accordionClose, s), o.$on(a.accordionResize, function () {
            n(), l()
        }), o.$on(a.accordionUpdate, l), o.$watch("AccordionItemContentController.height", function (e) {
            p.AccordionItemController.setContentHeight(e)
        })
    }],
    controllerAs: "AccordionItemContentController",
    templateUrl: "common/accordion/accordion-item-content.html",
    transclude: !0
}),angular.module("accordion.item", ["events", "templates"]).component("habboAccordionItem", {
    require: {AccordionGridController: "^habboAccordionGrid"},
    controller: ["$element", "$scope", "EVENTS", function (e, t, o) {
        var r = this;
        r.expanded = !1, r.contentHeight = 0, r.offset = 0, r.$onInit = function () {
            r.AccordionGridController.registerItem(r)
        }, r.toggle = function () {
            r.expanded ? r.AccordionGridController.collapseItem(r) : (r.offset = e.offset().top, r.AccordionGridController.expandItem(r))
        }, r.setContentHeight = function (e) {
            r.contentHeight = e
        }, t.$watch("AccordionItemController.expanded", function (e, r) {
            e ? t.$broadcast(o.accordionOpen) : r && t.$broadcast(o.accordionClose)
        })
    }],
    controllerAs: "AccordionItemController",
    templateUrl: "common/accordion/accordion-item.html",
    transclude: !0
}),angular.module("accordion.grid", ["events"]).component("habboAccordionGrid", {
    controller: ["$scope", "$window", "EVENTS", function (e, t, o) {
        function r() {
            angular.forEach(l, s.collapseItem)
        }

        function a(e, t) {
            return t && parseInt(t.offset, 10) < parseInt(e.offset, 10) ? e.offset - t.contentHeight : e.offset
        }

        function n() {
            e.$broadcast(o.accordionResize)
        }

        var i = 150, s = this, l = [];
        s.expandedItem = null, s.registerItem = function (e) {
            l.push(e)
        }, s.expandItem = function (e) {
            r(), e.expanded = !0, s.expandedItem = e
        }, s.collapseItem = function (e) {
            e.expanded && (e.expanded = !1, s.expandedItem = null)
        }, angular.element(t).on("orientationchange resize", n), e.$on("$destroy", function () {
            angular.element(t).off("orientationchange resize", n)
        }), e.$watch("HabboAccordionGridController.expandedItem", function (e, t) {
            if (e) {
                var o = a(e, t);
                angular.element("html, body").animate({scrollTop: o}, i)
            }
        })
    }], controllerAs: "HabboAccordionGridController", template: "<ul ng-transclude></ul>", transclude: !0
}),angular.module("shop", ["config", "earn.credits", "header", "locale", "prepaid", "router", "shop.footer", "store", "subscriptions", "system.data", "tabs", "templates", "transactions"]).config(["$stateProvider", "$urlRouterProvider", function (e, t) {
    e.statePublic("shop", {
        url: "/shop?country",
        "abstract": !0,
        controller: "ShopController",
        controllerAs: "ShopController",
        resolve: {
            countryCode: ["$stateParams", "SystemData", function (e, t) {
                return e.country || t.getShopCountry() || "all"
            }]
        },
        templateUrl: "shop/shop.html"
    }), t.when("/credits", "/shop")
}]).controller("ShopController", ["CONFIG", function (e) {
    var t = this;
    t.earnCreditsEnabled = "true" === e.offerToroEnabled
}]),angular.module("shop.filters", []).filter("credit", function () {
    return function (e) {
        return _.filter(e, function (e) {
            return e.creditAmount > 0
        })
    }
}).filter("product", function () {
    return function (e) {
        return _.filter(e, function (e) {
            return 0 === e.creditAmount
        })
    }
}).filter("paymentCategory", function () {
    return function (e, t) {
        return t ? _.filter(e, function (e) {
            return e.category === t
        }) : e
    }
}).filter("payment", ["paymentCategoryFilter", function (e) {
    return function (t, o) {
        return _.filter(t, function (t) {
            return e(t.paymentMethods, o).length > 0
        })
    }
}]),angular.module("shop.service", ["ngResource", "config", "safe.transform.response", "security", "storage"]).factory("Shop", ["$resource", "CONFIG", "Session", "httpCache", "safeTransformResponse", function (e, t, o, r, a) {
    function n(e) {
        return e = e || [], 1 === e.length ? [] : (e.unshift("all"), _.map(e, function (e) {
            return {key: e, translateKey: "SHOP_PAYMENT_METHOD_" + e.toUpperCase()}
        }))
    }

    var i = e(t.shopUrl + "/:resource/:subresource", {}, {
        countries: {
            url: t.shopUrl + "/:public/:subresource",
            method: "GET",
            isArray: !0,
            params: {subresource: "countries"},
            cache: r.longCache
        },
        inventory: {
            url: t.shopUrl + "/:public/inventory/:countryCode",
            method: "GET",
            cache: r.longCache,
            transformResponse: a.fromJson(function (e) {
                return e.paymentCategories = n(e.paymentCategories), e
            })
        },
        history: {url: t.shopUrl + "/history", method: "GET", isArray: !0}
    }), s = i.inventory, l = i.countries;
    return i.inventory = function () {
        return arguments[0] = arguments[0] || {}, _.extend(arguments[0], {"public": o.hasSession() ? null : "public"}), s.apply(this, arguments)
    }, i.countries = function () {
        return l.apply(this, [{"public": o.hasSession() ? null : "public"}])
    }, i
}]),angular.module("settings.service", ["config", "google.analytics"]).factory("settings", ["$http", "CONFIG", "googleAnalytics", function (e, t, o) {
    var r = {};
    return r.changePassword = function (r) {
        return e.post(t.apiUrl + "/settings/password/change", r).then(function (e) {
            return o.trackEvent("Password", "Changed"), e
        })
    }, r.changeEmail = function (r) {
        return e.post(t.apiUrl + "/settings/email/change", r).then(function (e) {
            return o.trackEvent("Email", "Changed"), e
        })
    }, r.resendActivationEmail = function () {
        return e.post(t.apiUrl + "/settings/email/verification-resend").then(function (e) {
            return o.trackEvent("Email", "Activation resent"), e
        })
    }, r
}]),angular.module("settings", ["account.security", "avatar.selection", "email.change", "header", "locale", "password.change", "privacy.settings", "router", "security", "tabs", "templates", "web.pages"]).config(["$stateProvider", "$urlRouterProvider", function (e, t) {
    e.statePrivate("settings", {
        url: "/settings",
        "abstract": !0,
        templateUrl: "settings/settings.html"
    }), t.when("/settings", "/settings/privacy")
}]),angular.module("security.service", ["config", "google.analytics", "security.fb", "security.session", "security.use.force.service"]).factory("security", ["$http", "$location", "$q", "$window", "CONFIG", "Session", "fbSecurity", "googleAnalytics", "useForce", function (e, t, o, r, a, n, i, s, l) {
    function c(e) {
        return l.handleForces(e)["catch"](function () {
            return u()["finally"](function () {
                return o.reject({status: "force.pending"})
            })
        })
    }

    function u() {
        return e.post(a.apiUrl + "/public/authentication/logout")
    }

    function d(e) {
        return n.destroy(), r.location.href = e || "/", o.defer().promise
    }

    var m = {};
    return m.init = function (e) {
        var t = e || r.session;
        return c(t).then(n.init)
    }, m.login = function (o) {
        return e.post(a.apiUrl + "/public/authentication/login", o).then(function (e) {
            return s.trackEvent("Login", "Credentials", t.path()), e.data
        }).then(c).then(n.create)
    }, m.fbLogin = function () {
        return i.login().then(function (o) {
            return e.post(a.apiUrl + "/public/authentication/facebook", o).then(function (e) {
                return s.trackEvent("Login", "Facebook", t.path()), e.data
            }).then(c).then(n.create)
        })
    }, m.logout = function (e) {
        return u().then(function () {
            return s.trackEvent("Logout", "Succeeded", t.path()), d(e)
        })["catch"](function () {
            return s.trackEvent("Logout", "Failed", t.path()), o.reject()
        })
    }, m.forceLogout = function (e) {
        return u()["finally"](function () {
            return s.trackEvent("Logout", "Forced", t.path()), d(e)
        })
    }, m
}]),angular.module("security", ["security.authorization", "security.credentials", "security.fingerprint", "security.login", "security.safety.answering.modal", "security.safety.lock", "security.service", "security.session"]),angular.module("security.fb", ["ezfb"]).factory("fbSecurity", ["$q", "ezfb", function (e, t) {
    function o() {
        var o = e.defer();
        return t.getLoginStatus(function (e) {
            "connected" === e.status ? o.resolve(e.authResponse) : o.reject(e)
        }), o.promise
    }

    function r() {
        var o = e.defer();
        return t.login(function (e) {
            "connected" === e.status ? o.resolve(e.authResponse) : o.reject(e)
        }, {scope: "public_profile,email"}), o.promise
    }

    var a = {};
    return a.login = function () {
        return t.isSdkLoaded() ? o()["catch"](r) : e.reject({data: {message: "fb.sdk_not_loaded"}})
    }, a
}]),angular.module("security.credentials", ["config"]).factory("credentials", ["CONFIG", function (e) {
    var t = {};
    return t.request = function (t) {
        return (_(t.url).includes(e.apiUrl) || _(t.url).includes(e.extraDataUrl) || _(t.url).includes(e.shopUrl)) && (t.withCredentials = !0), t
    }, t
}]).config(["$httpProvider", function (e) {
    e.interceptors.push("credentials")
}]),angular.module("security.authorization", ["security.login", "security.safety.lock", "security.session"]).factory("authorization", ["$q", "Session", "loginModal", "safetyLockModal", function (e, t, o, r) {
    var a = {};
    return a.hasAccessToPrivate = function () {
        return t.hasSession() ? e.when() : o.open()["catch"](function () {
            return e.reject({access: !1})
        })
    }, a.hasAccessToTrusted = function () {
        return a.hasAccessToPrivate().then(function () {
            return t.isTrusted() ? e.when() : r.open()["catch"](function () {
                return e.reject({access: !1})
            })
        })
    }, a.hasAccessToHabboAccountTrusted = function () {
        return a.hasAccessToTrusted().then(function () {
            return t.isHabboAccountSession() ? e.when() : e.reject({access: !1})
        })
    }, a
}]),angular.module("router.service", ["security", "ui.router"]).config(["$locationProvider", "$urlMatcherFactoryProvider", function (e, t) {
    e.hashPrefix("!"), e.html5Mode({enabled: !0, requireBase: !1}), t.strictMode(!1)
}]).config(["$stateProvider", function (e) {
    function t(e, t, l) {
        return t["abstract"] !== !0 && (o("auth", t), t.resolve.auth = ["$injector", function (e) {
            return a = a || e.get("$q"), n = n || e.get("$state"), i = i || e.get("authorization"), i[l]()["catch"](r)
        }]), s(e, t)
    }

    function o(e, t) {
        t.resolve = t.resolve || {}, _(t.resolve).keys().forEach(function (o) {
            _(t.resolve[o]).includes(e) || t.resolve[o].splice(t.resolve[o].length - 1, 0, e)
        })
    }

    function r(e) {
        return n.hasPrevious() || n.go("home.news"), a.reject(e)
    }

    var a, n, i, s = e.state;
    e.statePublic = function (e, t) {
        return s(e, t)
    }, e.statePrivate = function (e, o) {
        return t(e, o, "hasAccessToPrivate")
    }, e.state = function (e, o) {
        return t(e, o, "hasAccessToTrusted")
    }, e.stateHabboAccountTrusted = function (e, o) {
        return t(e, o, "hasAccessToHabboAccountTrusted")
    }
}]).run(["$rootScope", "$state", "security", function (e, t, o) {
    var r = e.$on("$stateChangeStart", function (e, a, n) {
        e.preventDefault(), o.init()["finally"](function () {
            r(), t.go(a, n)
        })
    })
}]),angular.module("refresh.dosarrest.cookie", []).factory("refreshDosarrestCookie", ["$q", "$window", function (e, t) {
    function o(e) {
        return e.match(/\.html$/)
    }

    function r(e) {
        return _.isString(e) && a.test(e)
    }

    var a = /<title>Client Validation<\/title>/gi, n = {};
    return n.response = function (a) {
        var n = e.defer();
        return !o(a.config.url) && r(a.data) ? t.location.reload() : n.resolve(a), n.promise
    }, n
}]).config(["$httpProvider", function (e) {
    e.interceptors.push("refreshDosarrestCookie")
}]),angular.module("prompt.safety.lock", ["http.buffer", "security"]).factory("promptSafetyLock", ["$injector", "$q", "httpBuffer", function (e, t, o) {
    function r(e) {
        return e.data && "account.safety_locked" === e.data.error
    }

    function a(e) {
        return _(e).includes("/public/forgotPassword")
    }

    function n(e) {
        var r = t.defer();
        return o.pushError(e.config, r), i().open().then(o.flush)["catch"](function () {
            o.reject(403)
        }), r.promise
    }

    function i() {
        return s || e.get("safetyLockModal")
    }

    var s, l = {};
    return l.responseError = function (e) {
        return e && r(e) && !a(e.config.url) ? n(e) : t.reject(e)
    }, l
}]).config(["$httpProvider", function (e) {
    e.interceptors.push("promptSafetyLock")
}]),angular.module("prompt.login", ["http.buffer", "security"]).factory("promptLogin", ["$injector", "$location", "$q", "Session", "httpBuffer", function (e, t, o, r, a) {
    function n(e) {
        return _(e).includes("/login") || _(e).includes("/facebook") || _(e).includes("/logout")
    }

    function i() {
        return u || e.get("security")
    }

    function s(e) {
        var t = o.defer(), r = l();
        return a.pushError(e.config, t), r.isOpen() || r.open().then(a.flush)["catch"](function () {
            a.reject(401)
        }), t.promise
    }

    function l() {
        return c || e.get("loginModal")
    }

    var c, u, d = {};
    return d.responseError = function (e) {
        return e && 401 === e.status && !n(e.config.url) ? r.hasSession() ? i().forceLogout(t.url()) : s(e) : o.reject(e)
    }, d
}]).config(["$httpProvider", function (e) {
    e.interceptors.push("promptLogin")
}]),angular.module("error.maintenance", ["notifier"]).factory("maintenanceError", ["$q", "notifier", function (e, t) {
    var o = {};
    return o.responseError = function (o) {
        return 503 === o.status && t.error("ERROR_SERVER_MAINTENANCE"), e.reject(o)
    }, o
}]).config(["$httpProvider", function (e) {
    e.interceptors.push("maintenanceError")
}]),angular.module("router", ["ban.error", "error.maintenance", "head", "prerender", "prompt.login", "prompt.safety.lock", "refresh.dosarrest.cookie", "router.service", "scrolltop", "spinner"]),angular.module("http.buffer", []).factory("httpBuffer", ["$injector", function (e) {
    function t(t, r) {
        o = o || e.get("$http"), o(t).then(function (e) {
            r.resolve(e)
        })["catch"](function (e) {
            r.reject(e)
        })
    }

    var o, r = {}, a = [];
    return r.pushError = function (e, t) {
        a.push({config: e, deferred: t})
    }, r.flush = function () {
        angular.forEach(a, function (e) {
            t(e.config, e.deferred)
        }), a = []
    }, r.reject = function (e) {
        angular.forEach(a, function (t) {
            t.deferred.reject({status: e, data: {}})
        }), a = []
    }, r
}]),angular.module("room", ["flash", "locale", "remove.on.error", "room.open", "room.restricted", "room.service", "router", "templates"]).config(["$stateProvider", function (e) {
    e.statePublic("room", {
        url: "/room/:id",
        controller: "RoomController",
        controllerAs: "RoomController",
        onEnter: ["room", "Head", function (e, t) {
            function o(e) {
                return e.replace(/[|ƒ†‡‘•—¥ª¬±µ¶º»]/g, " ").replace(/[ ]+/g, " ").trim()
            }

            t.title = o(e.name)
        }],
        resolve: {
            room: ["$stateParams", "Room", function (e, t) {
                return t.get({id: e.id}).$promise
            }]
        },
        templateUrl: "room/room.html"
    })
}]).controller("RoomController", ["room", function (e) {
    var t = this;
    t.room = e
}]),angular.module("room.service", ["ngResource", "config", "storage"]).factory("Room", ["$resource", "CONFIG", "httpCache", function (e, t, o) {
    return e(t.apiUrl + "/public/rooms/:id", null, {get: {method: "GET", cache: o.shortCache}})
}]),angular.module("registration.service", ["config", "google.analytics", "registration.age.gate", "security"]).factory("registration", ["$http", "$q", "$window", "CONFIG", "ageGate", "googleAnalytics", "security", function (e, t, o, r, a, n, i) {
    var s = {};
    return s.register = function (s) {
        return a.register(s.birthdate), a.isLocked() ? t.reject({data: {error: "age"}}) : e.post(r.apiUrl + "/public/registration/new", s).then(function (e) {
            var r = t.defer();
            return 204 === e.status ? (n.trackEvent("Registration", "Registered", "Staff"), r.resolve(e)) : (n.trackEvent("Registration", "Registered", "User"), o.piwikTrack && (o._spef.push(["trackGoal", 1]), o.piwikTrack()), i.init(e.data).then(function () {
                r.resolve(e)
            })), r.promise
        })
    }, s
}]),angular.module("registration", ["events", "header", "hotel.closed", "locale", "registration.form", "router", "security", "system.data", "templates"]).config(["$stateProvider", function (e) {
    e.statePublic("registration", {
        url: "/registration?captchaToken",
        controller: "RegistrationController",
        controllerAs: "RegistrationController",
        data: {title: "HEAD_TITLE_REGISTRATION"},
        templateUrl: "registration/registration.html"
    })
}]).controller("RegistrationController", ["$scope", "$state", "EVENTS", "SystemData", function (e, t, o, r) {
    var a = this;
    a.isOpen = r.isHotelOpen(), e.$on(o.securityLogin, function () {
        t.go("home.news", null, {location: "replace"})
    })
}]).run(["$rootScope", "$state", "Session", function (e, t, o) {
    e.$on("$stateChangeStart", function (e, r) {
        "registration" === r.name && (o.hasSession()) && (e.preventDefault(), t.go("home.news"))
    })
}]),angular.module("registration.form", ["ngMessages", "birthdate", "config", "form", "google.analytics", "locale", "notifier", "registration.partner", "registration.policies", "registration.service", "router", "security", "system.data", "templates"]).component("habboRegistrationForm", {
    controller: ["$scope", "$state", "$stateParams", "CAPTCHA_EVENTS", "CONFIG", "SystemData", "googleAnalytics", "notifier", "registration", function (e, t, o, r, a, n, i, s, l) {
        function c() {
            return "hhtr" === a.hotel
        }

        var u = this;
        u.hasCaptchaToken = Boolean(o.captchaToken), u.registration = {captchaToken: o.captchaToken}, u.registerInProgress = !1, u.showPartnerRegistration = n.isIDCGamesCountry() || c(), u.register = function () {
            var o = _(e.registrationForm.$error).values().flatten().map("$name").uniq().sort().join(", ");
            i.trackEvent("Registration", "Clicked", o), e.registrationForm.$valid && (u.registerInProgress = !0, l.register(u.registration).then(function (e) {
                204 === e.status ? t.go("home.news") : t.go("hotel")
            })["catch"](function (t) {
                var o = t.data && t.data.error;
                "age" === o ? s.error("ERROR_BIRTHDATE_AGE") : ("registration_email" === o || "registration.error.invalid_email" === o ? e.$broadcast("remote-data-invalid", "emailInvalid") : "registration_email_in_use" === o ? e.$broadcast("remote-data-invalid", "emailUsedInRegistration") : 429 === t.status ? s.error("ERROR_TOO_MANY_ATTEMPTS", {time: moment(t.data.nextValidRequestDate).fromNow(!0)}) : s.error("ERROR_SERVER"), e.$broadcast(r.reset))
            })["finally"](function () {
                u.registerInProgress = !1
            }))
        }, u.fbRegister = function () {
            t.go("hotel")
        }
    }], controllerAs: "RegistrationFormController", templateUrl: "registration/registration-form.html"
}),angular.module("registration.age.gate", ["config", "google.analytics", "local.storage"]).factory("ageGate", ["CONFIG", "googleAnalytics", "localStorage", function (e, t, o) {
    function r(t) {
        return moment({day: t.day, month: t.month - 1, year: t.year}).add(e.minAge, "years").isAfter(moment())
    }

    var a = {}, n = !1;
    return a.register = function (e) {
        r(e) && (n = !0, o.set("ageGate", !0), t.trackEvent("Registration", "Age gate", moment(e).format("YYYY-MM-DD")))
    }, a.isLocked = function () {
        return n || o.get("ageGate")
    }, a
}]),angular.module("profile", ["header", "locale", "profile.creations", "profile.header", "profile.item.lists", "profile.modal", "profile.service", "router", "security", "social.share", "templates"]).config(["$stateProvider", "$urlRouterProvider", function (e, t) {
    e.statePublic("profile", {
        url: "/profile/:name",
        controller: "ProfileController",
        controllerAs: "ProfileController",
        data: {title: "HEAD_TITLE_PROFILE"},
        resolve: {
            profile: ["$stateParams", "Profile", function (e, t) {
                return t.get({name: e.name}).$promise
            }]
        },
        templateUrl: "profile/profile.html"
    }), t.when("/home/:name", "/profile/:name"), t.when("/profile", "/")
}]).controller("ProfileController", ["CreationsProfile", "Profile", "Session", "profile", function (e, t, o, r) {
    var a = this;
    a.profile = r, o.hasSession() && r.uniqueId === o.user.uniqueId ? a.items = t["private"]() : r.profileVisible && (a.items = t.items({uniqueId: r.uniqueId})), a.stories = e.stories({uniqueId: r.uniqueId}), a.photos = e.photos({uniqueId: r.uniqueId}), a.random = function () {
        return .5 - Math.random()
    }
}]),angular.module("profile.service", ["ngResource", "config", "storage"]).factory("Profile", ["$resource", "CONFIG", "httpCache", function (e, t, o) {
    return e(t.apiUrl + "/public/users/:uniqueId/:resource", null, {
        get: {method: "GET", cache: o.shortCache},
        items: {method: "GET", params: {resource: "profile"}, cache: o.shortCache},
        "private": {method: "GET", url: t.apiUrl + "/user/profile", cache: o.shortCache}
    })
}]),angular.module("profile.creations", ["ngResource", "config", "profile.service", "reported.photos", "safe.transform.response", "storage"]).factory("CreationsProfile", ["$resource", "CONFIG", "Profile", "httpCache", "reportedPhotosFilter", "safeTransformResponse", function (e, t, o, r, a, n) {
    function i(e) {
        return function (t) {
            return o.get({name: t}).$promise.then(function (t) {
                return s[e]({uniqueId: t.uniqueId}).$promise
            })
        }
    }

    var s = e(t.extraDataUrl + "/public/users/:uniqueId/:resource", null, {
        photos: {
            method: "GET",
            isArray: !0,
            params: {resource: "photos"},
            cache: r.shortCache,
            transformResponse: n.fromJson(function (e) {
                var t = a(e);
                return _.map(t, function (e) {
                    return _.assign(e, {
                        url: "https:" + e.url,
                        contentHeight: 320,
                        contentWidth: 320,
                        parentTitle: "PHOTOS_TITLE"
                    })
                })
            })
        },
        stories: {
            method: "GET",
            isArray: !0,
            params: {resource: "stories"},
            cache: r.shortCache,
            transformResponse: n.fromJson(function (e) {
                return _.map(e, function (e) {
                    return e.url && -1 === e.url.indexOf("https:") && (e.url = "https:" + e.url), e
                })
            })
        }
    });
    return s.photosForUser = i("photos"), s.storiesForUser = i("stories"), s
}]),angular.module("playing.habbo", ["header", "locale", "router", "tabs", "templates", "web.pages"]).config(["$stateProvider", "$urlRouterProvider", function (e, t) {
    var o = ["what-is-habbo", "how-to-play", "habbo-way", "safety", "help"];
    e.statePublic("playingHabbo", {
        url: "/playing-habbo",
        templateUrl: "playing-habbo/playing-habbo.html",
        "abstract": !0
    }), _.forEach(o, function (t) {
        var o = "HEAD_TITLE_PLAYING_HABBO_" + t.toUpperCase().replace(/-/g, "_");
        e.statePublic("playingHabbo." + t, {
            url: "/" + t,
            controller: "PlayingHabboController",
            controllerAs: "PlayingHabboController",
            data: {title: o},
            resolve: {
                page: ["webPages", function (e) {
                    return e.get("playing_habbo/" + _.snakeCase(t))
                }]
            },
            templateUrl: "playing-habbo/" + t + ".html"
        })
    }), t.when("/playing-habbo", "/playing-habbo/what-is-habbo")
}]).controller("PlayingHabboController", ["page", function (e) {
    var t = this;
    t.page = e
}]),angular.module("password.reset.service", ["config", "google.analytics"]).factory("passwordReset", ["$http", "CONFIG", "googleAnalytics", function (e, t, o) {
    var r = {};
    return r.send = function (r) {
        return e.post(t.apiUrl + "/public/forgotPassword/send", {email: r}).then(function (e) {
            return o.trackEvent("Password", "Reset requested"), e
        })
    }, r.changePassword = function (r) {
        return e.post(t.apiUrl + "/public/forgotPassword/changePassword", r).then(function (e) {
            return o.trackEvent("Password", "Password reset"), e
        })
    }, r
}]),angular.module("password.reset", ["header", "locale", "password.reset.form", "router", "security", "templates"]).config(["$stateProvider", function (e) {
    e.statePublic("resetPassword", {
        url: "/reset-password/:token",
        controller: "PasswordResetController",
        controllerAs: "PasswordResetController",
        data: {title: "HEAD_TITLE_PASSWORD_RESET"},
        onEnter: ["$location", "security", "Session", function (e, t, o) {
            return o.hasSession() ? t.forceLogout(e.url()) : void 0
        }],
        templateUrl: "password-reset/password-reset.html"
    })
}]).controller("PasswordResetController", ["$stateParams", function (e) {
    var t = this;
    t.token = e.token
}]),angular.module("password.reset.form", ["form", "locale", "notifier", "password.reset.service", "router", "security", "templates"]).component("habboPasswordResetForm", {
    bindings: {token: "<"},
    controller: ["$scope", "$state", "notifier", "passwordReset", "safetyAnsweringModal", function (e, t, o, r, a) {
        function n() {
            o.success("PASSWORD_RESET_SUCCESS"), t.go("home.news")
        }

        var i = this;
        i.passwords = {}, i.updateInProgress = !1, i.update = function () {
            if (e.resetPasswordForm.$valid) {
                i.updateInProgress = !0;
                var t = {token: i.token, password: i.passwords.password};
                r.changePassword(t).then(n)["catch"](function (i) {
                    var s = i.data && i.data.error;
                    return 403 === i.status && "account.safety_locked" === s ? a.open(i.data.questions, t, r.changePassword).then(n) : void(404 === i.status ? o.error("ERROR_PASSWORD_RESET_EXPIRED") : "password.too_similar_to_username" === s ? e.$broadcast("remote-data-invalid", "passwordName") : "password.too_similar_to_email" === s ? e.$broadcast("remote-data-invalid", "passwordEmail") : "password.used_earlier" === s ? e.$broadcast("remote-data-invalid", "passwordUsed") : o.error("ERROR_SERVER"))
                })["finally"](function () {
                    i.updateInProgress = !1
                })
            }
        }
    }],
    controllerAs: "PasswordResetFormController",
    templateUrl: "password-reset/password-reset-form.html"
}),angular.module("not.found", ["google.analytics", "header", "locale", "router", "templates"]).config(["$stateProvider", function (e) {
    e.statePublic("notFound", {templateUrl: "not-found/not-found.html", data: {title: "HEAD_TITLE_NOT_FOUND"}})
}]).config(["$urlRouterProvider", function (e) {
    e.otherwise(function (e, t) {
        var o = e.get("googleAnalytics"), r = e.get("$state");
        o.trackEvent("Error", "Not found", t.url()), r.go("notFound")
    })
}]).run(["$location", "$log", "$rootScope", "$state", "googleAnalytics", function (e, t, o, r, a) {
    o.$on("$stateChangeError", function (o, n, i, s, l, c) {
        c && c.access === !1 || (o.preventDefault(), t.error(c), a.trackEvent("Error", "Not found", e.url()), r.go("notFound"))
    })
}]),angular.module("logout", ["locale", "notifier", "router", "security"]).config(["$stateProvider", function (e) {
    e.statePublic("logout", {
        url: "/logout", resolve: {
            logout: ["$state", "notifier", "security", function (e, t, o) {
                return o.logout()["catch"](function () {
                    e.go("home.news"), t.errorSticky("ERROR_LOGOUT_TITLE", "ERROR_LOGOUT_TEXT")
                })
            }]
        }
    })
}]),angular.module("hotel", ["client", "events", "locale", "router", "security", "templates"]).config(["$stateProvider", "$urlRouterProvider", function (e, t) {
    e.statePrivate("hotel", {
        url: "/hotel?link&room",
        controller: "HotelController",
        data: {title: "HEAD_TITLE_HOTEL"},
        template: '<div class="hotel"></div>'
    }), t.when("/client", "/hotel")
}]).controller("HotelController", ["$rootScope", "$stateParams", "$timeout", "EVENTS", "Session", "safetyLockModal", function (e, t, o, r, a, n) {
    a.isTrusted() || n.open(), o(function () {
        e.$broadcast(r.clientOpen, t)
    })
}]),angular.module("home", ["header", "locale", "housekeeping", "messaging", "news", "register.banner", "router", "tabs", "templates"]).config(["$stateProvider", "$urlRouterProvider", function (e, t) {
    e.statePublic("home", {
        url: "?captchaToken",
        "abstract": !0,
        controller: "HomeController",
        controllerAs: "HomeController",
        templateUrl: "home/home.html"
    }), t.when("/login_popup", "/")
}]).controller("HomeController", ["$state", "Session", function (e, t) {
    var o = this;
    o.hasHeaderLarge = function () {
        return !t.hasSession() && e.is("home.news")
    }
}]),angular.module("help.login", ["router", "security", "zendesk.url"]).config(["$stateProvider", function (e) {
    e.statePrivate("helpLogin", {
        url: "/help-login?return_to",
        controller: "HelpLoginController",
        data: {title: "HEAD_TITLE_HELP_LOGIN"},
        template: '<div class="help-login-backdrop"></div>'
    })
}]).controller("HelpLoginController", ["$stateParams", "$window", "zendeskRedirectUrlFilter", function (e, t, o) {
    t.location.href = o(e.return_to, !0)
}]),angular.module("dev", ["header", "router", "templates", "web.pages"]).config(["$stateProvider", function (e) {
    e.statePublic("dev", {
        url: "/dev/:page",
        templateUrl: "dev/dev.html",
        controller: "DevController",
        controllerAs: "DevController"
    })
}]).controller("DevController", ["$stateParams", function (e) {
    var t = this;
    t.page = e.page.replace(/-/g, "_")
}]),angular.module("ui.router").config(["$provide", function (e) {
    e.decorator("$state", ["$delegate", "$rootScope", function (e, t) {
        var o, r;
        return e.hasPrevious = function () {
            return Boolean(o) && Boolean(o.name)
        }, e.back = function () {
            e.hasPrevious() ? e.go(o.name, r) : e.go("home.news")
        }, t.$on("$stateChangeSuccess", function (e, t, a, n, i) {
            o = n, r = i
        }), e
    }])
}]),angular.module("ui.bootstrap").config(["$provide", function (e) {
    e.decorator("$uibModal", ["$delegate", "$rootScope", function (e, t) {
        var o = e.open;
        return e.open = function (e) {
            var r, a, n = o(e);
            return n.open = !0, r = t.$on("$stateChangeSuccess", function () {
                n.dismiss("cancel")
            }), a = t.$on("$locationChangeSuccess", function (e, t, o) {
                t !== o && n.dismiss("cancel")
            }), n.result["finally"](function () {
                n.open = !1, r(), a()
            }), n
        }, e
    }])
}]),angular.module("ezfb").config(["$provide", "ezfbProvider", function (e, t) {
    var o = !1;
    t.setLoadSDKFunction(["$window", "$document", "ezfbAsyncInit", "ezfbLocale", function (e, t, r, a) {
        var n = t[0].createElement("script");
        n.id = "facebook-jssdk", n.async = !0, n.src = "//connect.facebook.net/" + a + "/sdk.js", t[0].body.appendChild(n), e.fbAsyncInit = function () {
            r(), o = !0
        }
    }]), e.decorator("ezfb", ["$delegate", function (e) {
        return e.isSdkLoaded = function () {
            return o
        }, e
    }])
}]),angular.module("community", ["article", "category", "fansites", "header", "staff", "photos", "rooms", "router", "tabs", "templates"]).config(["$stateProvider", "$urlRouterProvider", function (e, t) {
    e.statePublic("community", {
        url: "/community",
        "abstract": !0,
        templateUrl: "community/community.html"
    }), t.when("/community", "/community/photos")
}]),angular.module("activate.service", ["config", "google.analytics", "security"]).factory("activate", ["$http", "CONFIG", "Session", "googleAnalytics", function (e, t, o, r) {
    return function (a) {
        return e.post(t.apiUrl + "/public/registration/activate", {token: a}).then(function (e) {
            r.trackEvent("Email", "Activated"), 200 === e.status && o.hasSession() && o.update(e.data)
        })
    }
}]),angular.module("activate", ["activate.service", "locale", "notifier", "router"]).config(["$stateProvider", function (e) {
    e.statePublic("activate", {
        url: "/activate/:token",
        controller: "ActivateController",
        resolve: {
            activation: ["$stateParams", "activate", function (e, t) {
                return t(e.token)
            }]
        }
    })
}]).controller("ActivateController", ["$state", "notifier", function (e, t) {
    t.success("ACTIVATE_SUCCESS"), e.go("home.news")
}]),angular.module("templates", []).run(["$templateCache", function (e) {
    e.put("community/community.html",
        '<habbo-header-small active="community"></habbo-header-small><habbo-tabs><habbo-tab path="/community/photos" translation-key="COMMUNITY_PHOTOS_TAB"></habbo-tab><habbo-tab path="/community/rooms" translation-key="COMMUNITY_ROOMS_TAB"></habbo-tab><habbo-tab path="/community/fansites" translation-key="COMMUNITY_FANSITES_TAB"></habbo-tab><habbo-tab path="/community/category" alternative-path="/community/article" translation-key="COMMUNITY_NEWS_TAB"></habbo-tab><habbo-tab path="/community/staff" translation-key="COMMUNITY_STAFF_TAB"></habbo-tab></habbo-tabs><main ui-view></main>'
    ), e.put("dev/dev.html",
        '<habbo-header-small></habbo-header-small><section class="wrapper wrapper--content"><habbo-web-pages key="{{:: \'dev/\' + DevController.page}}" class="main"></habbo-web-pages><habbo-web-pages key="{{:: \'dev/\' + DevController.page + \'_box\'}}" class="aside aside--box aside--push-down"></habbo-web-pages></section>'
    ), e.put("home/home.html",
        '<habbo-header-small ng-if="!HomeController.hasHeaderLarge()" active="home"></habbo-header-small><habbo-header-large ng-if="HomeController.hasHeaderLarge()" active="home"><habbo-register-banner></habbo-register-banner></habbo-header-large><habbo-tabs><habbo-tab path="/" strict-path="true" translation-key="HOME_NEWS_TAB"></habbo-tab><habbo-tab habbo-require-session path="/messaging" translation-key="HOME_MESSAGING_TAB"></habbo-tab></habbo-tabs><main class="wrapper wrapper--content" ui-view></main>'
    ), e.put("not-found/not-found.html",
        '<habbo-header-small></habbo-header-small><main class="wrapper wrapper--content not-found"><section class="not-found__content"><h3 translate="NOT_FOUND_PAGE_TITLE"></h3><div translate="NOT_FOUND_PAGE_TEXT"></div></section></main>'
    ), e.put("password-reset/password-reset-form.html",
        '<form ng-submit="PasswordResetFormController.update()" name="resetPasswordForm" novalidate class="form form--left"><habbo-password-new is-new="true" password-new="PasswordResetFormController.passwords.password" password-new-repeated="PasswordResetFormController.passwords.passwordRepeated"></habbo-password-new><div class="form__footer"><button ng-disabled="PasswordResetFormController.updateInProgress" type="submit" class="form__submit" translate="FORM_BUTTON_CHANGE"></button></div></form>'
    ), e.put("password-reset/password-reset.html",
        '<habbo-header-small></habbo-header-small><main class="wrapper wrapper--content"><h1 translate="PASSWORD_RESET_TITLE"></h1><habbo-password-reset-form token="PasswordResetController.token" class="password-reset-form"></habbo-password-reset-form></main>'
    ), e.put("playing-habbo/habbo-way.html",
        '<article class="main main--fixed static-content"><habbo-compile data="PlayingHabboController.page"></habbo-compile></article><habbo-ad-unit unit="inlineRectangle" class="aside aside--fixed aside--push-down"></habbo-ad-unit><habbo-web-pages key="common/box_learn_how_to_stay_safe" class="aside aside--box aside--fixed"></habbo-web-pages><habbo-web-pages key="common/box_parents_guide" class="aside aside--box aside--fixed"></habbo-web-pages>'
    ), e.put("playing-habbo/help.html",
        '<article class="main main--fixed static-content"><habbo-compile data="PlayingHabboController.page"></habbo-compile></article><habbo-web-pages key="playing_habbo/box_helplines" class="aside aside--box aside--fixed aside--push-down"></habbo-web-pages>'
    ), e.put("playing-habbo/how-to-play.html",
        '<article class="main main--fixed static-content"><habbo-compile data="PlayingHabboController.page"></habbo-compile></article><habbo-ad-unit unit="inlineRectangle" class="aside aside--fixed aside--push-down"></habbo-ad-unit><habbo-web-pages key="common/box_habbo_way" class="aside aside--box aside--fixed"></habbo-web-pages><habbo-web-pages key="common/box_learn_how_to_stay_safe" class="aside aside--box aside--fixed"></habbo-web-pages><habbo-web-pages key="common/box_need_help" class="aside aside--box aside--fixed"></habbo-web-pages>'
    ), e.put("playing-habbo/playing-habbo.html",
        '<habbo-header-small active="playingHabbo"></habbo-header-small><habbo-tabs><habbo-tab path="/playing-habbo/what-is-habbo" translation-key="PLAYING_HABBO_WHAT_IS_HABBO_TAB"></habbo-tab><habbo-tab path="/playing-habbo/how-to-play" translation-key="PLAYING_HABBO_HOW_TO_PLAY_TAB"></habbo-tab><habbo-tab path="/playing-habbo/habbo-way" translation-key="PLAYING_HABBO_HABBO_WAY_TAB"></habbo-tab><habbo-tab path="/playing-habbo/safety" translation-key="PLAYING_HABBO_SAFETY_TAB"></habbo-tab><habbo-tab path="/playing-habbo/help" translation-key="PLAYING_HABBO_HELP_TAB"></habbo-tab></habbo-tabs><main class="wrapper wrapper--content" ui-view></main>'
    ),
        e.put("playing-habbo/safety.html",
            '<article class="main main--fixed static-content"><habbo-compile data="PlayingHabboController.page"></habbo-compile></article><habbo-ad-unit unit="inlineRectangle" class="aside aside--fixed aside--push-down"></habbo-ad-unit><habbo-web-pages key="common/box_parents_guide" class="aside aside--box aside--fixed"></habbo-web-pages><habbo-web-pages key="common/box_need_help" class="aside aside--box aside--fixed"></habbo-web-pages>'
        ), e.put("playing-habbo/what-is-habbo.html",
        '<article class="main main--fixed static-content"><habbo-compile data="PlayingHabboController.page"></habbo-compile></article><habbo-ad-unit unit="inlineRectangle" class="aside aside--fixed aside--push-down"></habbo-ad-unit><habbo-web-pages key="common/box_how_to_play" class="aside aside--box aside--fixed"></habbo-web-pages><habbo-web-pages key="common/box_habbo_way" class="aside aside--box aside--fixed"></habbo-web-pages><habbo-web-pages key="common/box_parents_guide" class="aside aside--box aside--fixed"></habbo-web-pages>'
    ), e.put("profile/profile.html",
        '<habbo-header-small class="profile__header"><habbo-profile-header figure="{{:: ProfileController.profile.figureString}}" user="{{:: ProfileController.profile.name}}" motto="{{:: ProfileController.profile.motto}}" profile="true"><h1>{{:: ProfileController.profile.name}}</h1><div ng-if="ProfileController.profile.motto" class="profile__motto">{{:: ProfileController.profile.motto}}</div></habbo-profile-header></habbo-header-small><habbo-social-share type="profile"></habbo-social-share><main class="wrapper wrapper--content"><div ng-if="ProfileController.items.badges.length > 0\n                || ProfileController.items.friends.length > 0\n                || ProfileController.items.rooms.length > 0\n                || ProfileController.items.groups.length > 0" class="profile__section"><div ng-if="ProfileController.profile.selectedBadges.length > 0" class="profile__card__wrapper--badges"><section class="profile__card__aligner"><div class="profile__card"><h2 translate="PROFILE_BADGES_TITLE" class="profile__card__title"></h2><habbo-badge-list badges="ProfileController.profile.selectedBadges" class="item-list--grid"></habbo-badge-list><div class="profile__card__footer"><habbo-profile-modal items="ProfileController.items.badges" type="badges"></habbo-profile-modal></div></div></section></div><div ng-if="ProfileController.items.friends.length > 0" class="profile__card__wrapper--friends"><section class="profile__card__aligner"><div class="profile__card"><h2 class="profile__card__title"><span translate="PROFILE_FRIENDS_TITLE"></span> <span class="profile__friends__count" translate="PROFILE_FRIENDS_COUNT" translate-values="{ current: ProfileController.items.friends.length > 5 ? 5 : ProfileController.items.friends.length, all: ProfileController.items.friends.length }"></span></h2><habbo-friend-list ng-init="fiveFriends = (ProfileController.items.friends | orderBy: random | limitTo: 5)" friends="fiveFriends" class="item-list--grid"></habbo-friend-list><div class="profile__card__footer"><habbo-profile-modal items="ProfileController.items.friends" type="friends"></habbo-profile-modal></div></div></section></div><div ng-if="ProfileController.items.rooms.length > 0" class="profile__card__wrapper--rooms"><section class="profile__card__aligner"><div class="profile__card"><h2 translate="PROFILE_ROOMS_TITLE" class="profile__card__title"></h2><habbo-room-list ng-init="fiveRooms = (ProfileController.items.rooms | orderBy: random | limitTo: 5)" rooms="fiveRooms" class="item-list--grid"></habbo-room-list><div class="profile__card__footer"><habbo-profile-modal items="ProfileController.items.rooms" type="rooms"></habbo-profile-modal></div></div></section></div><div ng-if="ProfileController.items.groups.length > 0" class="profile__card__wrapper--groups"><section class="profile__card__aligner"><div class="profile__card"><h2 translate="PROFILE_GROUPS_TITLE" class="profile__card__title"></h2><habbo-group-list ng-init="fiveGroups = (ProfileController.items.groups | orderBy: random | limitTo: 5)" groups="fiveGroups" class="item-list--grid"></habbo-group-list><div class="profile__card__footer"><habbo-profile-modal items="ProfileController.items.groups" type="groups"></habbo-profile-modal></div></div></section></div></div></main><section ng-if="ProfileController.photos.length > 0" class="wrapper wrapper--content"><div class="profile__creations"><h2 class="profile__creations__title" translate="PROFILE_PHOTOS_TITLE"></h2><habbo-columns-profile items="ProfileController.photos"></habbo-columns-profile><a href="/community/photos" class="profile__photos__link" translate="PHOTOS_TITLE"></a></div></section><section ng-if="ProfileController.stories.length > 0" class="wrapper wrapper--content"><div class="profile__creations"><h2 class="profile__creations__title" translate="PROFILE_CREATIONS_TITLE"></h2><habbo-columns-profile items="ProfileController.stories"></habbo-columns-profile></div></section><footer class="wrapper wrapper--content"><h2 class="profile__joined" translate="PROFILE_JOINED" translate-values="{ date: (ProfileController.profile.memberSince | date: \'longDate\') }"></h2><div class="profile__hearts"><i class="icon icon--heart"></i><i class="icon icon--heart"></i><i class="icon icon--heart"></i></div></footer>'
    ), e.put("registration/registration-form.html",
        '<h1 translate="REGISTRATION_TITLE"></h1><form ng-submit="RegistrationFormController.register()" name="registrationForm" novalidate class="form form--left registration-form"><div class="registration-form__social__wrapper"><div class="registration-form__social"><h3 class="registration-form__connect" translate="REGISTRATION_SOCIAL"></h3><habbo-facebook-connect on-login="RegistrationFormController.fbRegister()" type="large" translation-key="FACEBOOK_CONNECT"></habbo-facebook-connect></div></div><habbo-email-address email-address="RegistrationFormController.registration.email"><label for="email-address" class="form__label" translate="FORM_EMAIL_LABEL"></label><p translate="EMAIL_NEW_HELP"></p></habbo-email-address><habbo-password-new password-new="RegistrationFormController.registration.password" password-new-repeated="RegistrationFormController.registration.passwordRepeated" user-email="{{RegistrationFormController.registration.email}}"></habbo-password-new><habbo-partner-registration ng-if="RegistrationFormController.showPartnerRegistration" value="RegistrationFormController.registration.partnerRegister"></habbo-partner-registration><habbo-birthdate birthdate="RegistrationFormController.registration.birthdate"></habbo-birthdate><habbo-policies policies="RegistrationFormController.registration"></habbo-policies><habbo-captcha ng-if="!RegistrationFormController.hasCaptchaToken" captcha-token="RegistrationFormController.registration.captchaToken"></habbo-captcha><p class="registration-form__safety" translate="REGISTRATION_SAFETY"></p><div class="form__footer"><button ng-disabled="RegistrationFormController.registerInProgress" type="submit" class="form__submit registration-form__button" translate="REGISTRATION_BUTTON"></button></div><p class="registration-form__purchases" translate="REGISTRATION_PURCHASES"></p></form>'
    ), e.put("registration/registration.html",
        '<habbo-header-small active="register"></habbo-header-small><main class="wrapper wrapper--content"><habbo-registration-form ng-if="RegistrationController.isOpen"></habbo-registration-form><habbo-hotel-closed ng-if="!RegistrationController.isOpen" class="main"></habbo-hotel-closed></main>'
    ), e.put("room/room.html",
        '<habbo-header-small></habbo-header-small><habbo-room-restricted ng-if="RoomController.room.doorMode != \'open\'" room="RoomController.room"></habbo-room-restricted><habbo-room-open ng-if="RoomController.room.doorMode == \'open\'" room="RoomController.room"></habbo-room-open>'
    ), e.put("settings/settings.html",
        '<habbo-header-small active="settings"></habbo-header-small><habbo-tabs title-key="SETTINGS_TITLE"><habbo-tab path="/settings/privacy" translation-key="SETTINGS_PRIVACY_TAB"></habbo-tab><habbo-tab habbo-require-habbo-account-session path="/settings/security" translation-key="SETTINGS_ACCOUNT_SECURITY_TAB"></habbo-tab><habbo-tab habbo-require-habbo-account-session path="/settings/password" translation-key="SETTINGS_PASSWORD_TAB"></habbo-tab><habbo-tab habbo-require-habbo-account-session path="/settings/email" translation-key="SETTINGS_EMAIL_TAB"></habbo-tab><habbo-tab path="/settings/avatars" translation-key="SETTINGS_AVATAR_TAB"></habbo-tab></habbo-tabs><main class="wrapper wrapper--content"><section class="main" ui-view></section><habbo-web-pages key="common/box_learn_how_to_stay_safe" class="aside aside--box aside--push-down"></habbo-web-pages><habbo-web-pages key="common/box_need_help" class="aside aside--box"></habbo-web-pages></main>'
    ), e.put("shop/shop.html",
        '<habbo-header-small active="shop"></habbo-header-small><habbo-tabs><habbo-tab path="/shop" strict-path="true" translation-key="SHOP_BUY_TAB"></habbo-tab><habbo-tab path="/shop/subscriptions" translation-key="SHOP_SUBSCRIPTIONS_TAB"></habbo-tab><habbo-tab ng-if="ShopController.earnCreditsEnabled" path="/shop/earn-credits" translation-key="SHOP_EARN_CREDITS_TAB"></habbo-tab><habbo-tab path="/shop/history" translation-key="SHOP_HISTORY_TAB"></habbo-tab></habbo-tabs><main class="wrapper wrapper--content" ui-view></main><habbo-shop-footer class="wrapper wrapper--content"></habbo-shop-footer>'
    ), e.put("common/accordion/accordion-item-content.html",
        '<div ng-hide="AccordionItemContentController.height === 0" class="accordion-item-content ng-hide" ng-transclude></div>'
    ), e.put("common/accordion/accordion-item.html",
        '<li ng-class="{ \'accordion-item--expanded\': AccordionItemController.expanded }" class="accordion-item" ng-transclude></li>'
    ), e.put("common/ad-unit/ad-unit.html",
        '<habbo-ad-double-click ng-if="AdUnitController.hasAds() && !AdUnitController.isAdsPrevented()" unit="{{:: AdUnitController.unit}}"></habbo-ad-double-click>'
    ), e.put("common/avatar/avatar.html",
        '<a ng-href="/profile/{{:: AvatarController.user | encodeURIComponent}}" class="avatar"><habbo-imager user="{{:: AvatarController.user}}" size="{{:: AvatarController.big ? \'largehead\' : \'bighead\'}}" class="avatar__image"></habbo-imager><h6 class="avatar__title" ng-class="{ \'avatar__title--big\': AvatarController.big }">{{:: AvatarController.user}}</h6></a>'
    ), e.put("common/badge/badge.html",
        "<img ng-src=\"{{:: BadgeController.badgeUrl + '/' + BadgeController.code + '.gif'}}\" alt=\"{{:: BadgeController.name}}\">"
    ), e.put("common/empty-results/empty-results.html",
        "<span translate=\"{{:: EmptyResultsController.translationKey || 'EMPTY_RESULTS_TEXT' }}\"></span>"
    ), e.put("common/eu-cookie-banner/eu-cookie-banner.html",
        '<div ng-show="EuCookieBannerController.show" class="eu-cookie-banner ng-hide"><div class="wrapper"><span translate="EU_COOKIE_BANNER"></span> <a ng-href="{{\'EU_COOKIE_BANNER_READ_MORE_LINK\' | translate}}" translate="EU_COOKIE_BANNER_READ_MORE" target="_blank" rel="noopener noreferrer"></a></div><i ng-click="EuCookieBannerController.close()" class="eu-cookie-banner__close icon icon--close"></i></div>'
    ), e.put("common/footer/footer.html",
        '<footer class="wrapper"><div class="footer__media"><p class="footer__media__label" translate="FOLLOW_HABBO"></p><ul itemscope itemtype="http://schema.org/Organization"><link itemprop="url" ng-href="{{\'HOTEL_URI\' | translate}}"><li class="footer__media__item"><a ng-href="{{\'FACEBOOK_URI\' | translate}}" class="footer__media__link" target="_blank" itemprop="sameAs" rel="noopener noreferrer"><i class="icon icon--facebook"></i></a></li><li class="footer__media__item"><a ng-href="{{\'TWITTER_URI\' | translate}}" class="footer__media__link" target="_blank" itemprop="sameAs" rel="noopener noreferrer"><i class="icon icon--twitter"></i></a></li><li class="footer__media__item"><a ng-href="{{\'YOUTUBE_URI\' | translate}}" class="footer__media__link" target="_blank" itemprop="sameAs" rel="noopener noreferrer"><i class="icon icon--youtube"></i></a></li><li class="footer__media__item"><a ng-href="{{\'RSS_URI\'  | translate}}" class="footer__media__link" target="_blank" itemprop="sameAs" rel="noopener noreferrer"><i class="icon icon--rss"></i></a></li></ul></div><div class="footer__content"><ul class="footer__nav"><li ng-repeat="link in FooterController.links" class="footer__nav__item"><a ng-href="{{link + \'_LINK\' | translate | zendeskRedirectUrl}}" class="footer__nav__link" target="_blank" rel="noopener noreferrer" translate="{{:: link}}"></a></li></ul><p class="footer__copyright" translate="FOOTER_COPYRIGHT" translate-values="{ year: FooterController.currentYear }"></p></div></footer>'
    ), e.put("common/group-badge/group-badge.html",
        "<img ng-src=\"{{:: GroupBadgeController.imagingUrl + '/badge/' + GroupBadgeController.code + '.gif'}}\" alt=\"{{:: GroupBadgeController.name}}\">"
    ), e.put("common/header/header-large.html",
        '<div habbo-sticky-header class="header__top sticky-header sticky-header--top"><div class="wrapper"><div class="header__top__content"><div ng-init="toggle = false;"><button ng-click="toggle = true;" ng-disabled="toggle" ng-hide="toggle" class="header__top__toggle">{{\'LOGIN\' | translate}}</button><div ng-show="toggle" class="header__login-form ng-hide"><habbo-login-form></habbo-login-form></div></div></div></div></div><div class="header__content" ng-transclude></div><header class="header__wrapper wrapper"><a href="/" class="header__habbo__logo"><h1 class="header__habbo__name" id="ga-linkid-habbo-large">Habbo</h1></a></header><habbo-navigation active="{{:: HeaderLargeController.active}}"></habbo-navigation>'
    ), e.put("common/header/header-small.html",
        '<habbo-header-ad></habbo-header-ad><div class="header__hotel"></div><header class="header__wrapper wrapper"><a href="/" class="header__habbo__logo"><h1 class="header__habbo__name" id="ga-linkid-habbo">Habbo</h1></a><habbo-user-menu habbo-require-session class="header__aside header__aside--user-menu"></habbo-user-menu><div habbo-require-no-session class="header__aside"><button ng-click="HeaderSmallController.openLoginModal()" class="header__login__button"><span class="header__login__icon" translate="LOGIN"></span></button></div></header><habbo-navigation active="{{:: HeaderSmallController.active}}"></habbo-navigation><div class="wrapper" ng-transclude></div>'
    ), e.put("common/hotel-closed/hotel-closed.html",
        '<div class="hotel-closed"><h1 translate="HOTEL_CLOSED_TITLE"></h1><h3 translate="HOTEL_CLOSED_HOURS"></h3><p translate="HOTEL_CLOSED_DESCRIPTION"></p><ul class="hotel-closed__list"><li><a href="/community/photos" translate="COMMUNITY_PHOTOS_TAB"></a></li><li><a href="/community/category/all" translate="COMMUNITY_NEWS_TAB"></a></li><li><a href="/shop" translate="NAVIGATION_SHOP"></a></li></ul></div>'
    ), e.put("common/imager/imager.html",
        '<img ng-src="{{:: ImagerController.src}}" ng-srcset="{{:: ImagerController.src + \' 1x\' + (ImagerController.src2x ? (\', \' + ImagerController.src2x + \' 2x\') : \'\')}}" ng-style="{ \'min-width\': ImagerController.dimensions.width }" alt="{{:: ImagerController.name || ImagerController.user }}" width="{{:: ImagerController.dimensions.width }}" height="{{:: ImagerController.dimensions.height }}" class="imager">'
    ), e.put("common/lightbox/lightbox-modal.html",
        '<button ng-click="$dismiss()" class="lightbox__close modal__close"></button> <img ng-src="{{:: LightboxController.src}}" class="lightbox__image">'
    ), e.put("common/like/like.html",
        '<div class="like__action"><a ng-click="(LikeController.data | myLike) ? LikeController.unlike() : LikeController.like()"><span translate="{{ (LikeController.data | myLike) ? \'UNLIKE\' : \'LIKE\' }}"></span> <span class="like__count">{{LikeController.data.likes.length}}</span></a></div><div ng-click="LikeController.show = !LikeController.show;" ng-mouseenter="LikeController.mouseenter()" ng-mouseleave="LikeController.show = false;" habbo-false-on-outside-click="LikeController.show" class="like__thumb"><div ng-if="LikeController.data.likes.length > 0" ng-show="LikeController.show" class="like__users ng-hide"><ul><li ng-if="LikeController.data | myLike" class="like__user"><habbo-avatar user="{{:: LikeController.data | myLike}}"></habbo-avatar></li><li ng-repeat="liker in LikeController.data | othersLikes | limitTo: ((LikeController.data | myLike) ? 4 : 5) track by liker" class="like__user"><habbo-avatar user="{{:: liker}}"></habbo-avatar></li></ul><small ng-if="LikeController.data.likes.length > 5" class="like__more">...{{ \'MORE_LIKES\' | translate: { count: LikeController.data.likes.length - 5 } }}</small></div><i class="like__icon icon icon--like"></i></div>'
    ), e.put("common/message-container/message-container.html",
        '<section class="message-container" ng-transclude></section>'), e.put(
        "common/official-room-avatar/official-room-avatar.html",
        '<div class="room-official-avatar__wrapper"><div class="room-official-avatar__inner"><div class="room-official-avatar__image"></div><h6 class="room-official-avatar__text" translate="ROOM_OFFICIAL_OWNER"></h6></div></div>'
    ), e.put("common/social-share/social-share.html",
        '<div class="social-share"><a ng-click="SocialShareController.shareOnTwitter()" class="social-share__link"><i class="icon icon--twitter"></i></a> <a ng-click="SocialShareController.shareOnFacebook()" class="social-share__link"><i class="icon icon--facebook"></i></a> <span class="social-share__text" translate="SOCIAL_SHARE"></span></div>'
    ), e.put("common/tabs/tab.html",
        '<li class="tab"><a ng-href="{{:: TabController.path}}" ng-class="{ \'tab__link--active\': TabController.active }" class="tab__link" translate="{{:: TabController.translationKey}}"></a></li>'
    ), e.put("common/tabs/tabs.html",
        '<nav ng-hide="TabsController.tabs.length < 2" class="tabs"><h1 ng-if="TabsController.titleKey" class="tabs__title" translate="{{:: TabsController.titleKey}}"></h1><div ng-click="TabsController.open = !TabsController.open" class="tabs__toggle"><div ng-class="{\'tabs__toggle__title--active\': TabsController.open}" class="tabs__toggle__title" translate="{{TabsController.activeTab.translationKey}}"></div></div><ul class="tabs__menu ng-hide" ng-hide="!TabsController.open" ng-transclude></ul></nav>'
    ), e.put("community/article/article.html",
        '<section class="wrapper wrapper--content"><habbo-compile data="ArticleController.article" class="main main--fixed"></habbo-compile><habbo-ad-unit unit="inlineRectangle" class="aside aside--fixed"></habbo-ad-unit><habbo-web-pages key="common/box_learn_how_to_stay_safe" class="aside aside--box aside--fixed"></habbo-web-pages></section>'
    ), e.put("community/category/category.html",
        '<section class="wrapper wrapper--content"><habbo-compile data="CategoryController.category" class="main main--fixed"></habbo-compile><habbo-ad-unit unit="inlineRectangle" class="aside aside--fixed"></habbo-ad-unit><habbo-web-pages key="common/box_learn_how_to_stay_safe" class="aside aside--box aside--fixed"></habbo-web-pages></section>'
    ), e.put("community/fansites/fansites.html",
        '<section class="wrapper wrapper--content"><article class="main main--fixed static-content"><habbo-compile data="FansitesController.fansites"></habbo-compile></article><habbo-ad-unit unit="inlineRectangle" class="aside aside--fixed aside--push-down"></habbo-ad-unit><habbo-web-pages key="common/box_habbo_way" class="aside aside--box aside--fixed"></habbo-web-pages></section>'
    ), e.put("community/photos/photos.html",
        '<header class="photos__header"><div class="photos__header__container wrapper"><div class="photos__header__image__wrapper"><div class="photos__header__image"></div></div><div class="photos__header__content"><h1 class="photos__header__title" translate="PHOTOS_TITLE"></h1><p translate="PHOTOS_DESCRIPTION"></p></div></div></header><section class="wrapper wrapper--content"><habbo-columns-channel items="PhotosController.photos"></habbo-columns-channel></section>'
    ), e.put("community/staff/staff.html",
        '<section class="wrapper wrapper--content"><article class="main main--fixed static-content"><habbo-web-pages key="common/staff_team"></habbo-web-pages></article><habbo-web-pages key="common/staff_about" class="aside aside--box aside--fixed"></habbo-web-pages></section>'
    ), e.put("community/rooms/rooms.html",
        '<header class="rooms__header"><div class="rooms__header__container wrapper"><div class="rooms__header__image__wrapper"><div class="rooms__header__image"></div></div><div class="rooms__header__content"><h1 class="rooms__header__title" translate="ROOMS_TITLE"></h1><p translate="ROOMS_DESCRIPTION"></p></div></div></header><section class="wrapper wrapper--content rooms-wrapper"><div ng-repeat="room in RoomsController.rooms" class="room-item"><a ng-href="/room/{{:: room.id}}" class="room-item__link"><div class="room-item__thumbnail"><img habbo-remove-on-error class="room-item__thumbnail__image" ng-src="{{room.thumbnailUrl}}"></div></a> <a ng-href="/room/{{:: room.id}}" class="room-item__link"><h2 class="room-item__title">{{:: room.name}}</h2></a><p class="room-item__description">{{:: room.description}}</p><div ng-switch="room.publicRoom"><official-room-avatar ng-switch-when="true" class="room-item__owner--official"></official-room-avatar><habbo-avatar ng-switch-when="false" class="room-item__owner--user" user="{{:: room.ownerName}}"></habbo-avatar></div></div></section>'
    ), e.put("email/email-report-unauthorized/email-report-unauthorized-form.html",
        '<form ng-submit="EmailReportUnauthorizedFormController.report()" name="emailReportUnauthorizedForm" novalidate><div class="form__footer"><a href="/" class="form__cancel" translate="FORM_CANCEL_LABEL"></a> <button ng-disabled="EmailReportUnauthorizedFormController.reportInProgress" type="submit" class="form__submit" translate="EMAIL_REPORT_UNAUTHORIZED_BUTTON"></button></div></form>'
    ), e.put("email/email-report-unauthorized/email-report-unauthorized.html",
        '<habbo-header-small></habbo-header-small><main class="wrapper wrapper--content"><section class="main"><habbo-message-container type="exclamation"><h2 translate="EMAIL_REPORT_UNAUTHORIZED_TITLE"></h2><h4 class="email-report-unauthorized-form__email">{{:: EmailReportUnauthorizedController.email}}</h4><p translate="EMAIL_REPORT_UNAUTHORIZED_TEXT"></p><habbo-email-report-unauthorized-form emailaddress="EmailReportUnauthorizedController.email" hash="EmailReportUnauthorizedController.hash"></habbo-email-report-unauthorized-form></habbo-message-container></section></main>'
    ), e.put("home/messaging/messaging.html",
        '<section><h1 translate="MESSAGING_TITLE"></h1><habbo-discussions items="MessagingController.discussions"></habbo-discussions></section>'
    ), e.put("home/housekeeping/housekeeping.html",
        '<section><h1>Housekeeping</h1><habbo-web-pages key="common/housekeeping"></habbo-web-pages></section>'
    ), e.put("home/news/news.html",
        '<habbo-moderation-notification habbo-require-session></habbo-moderation-notification><section><h1 translate="NEWS_TITLE"></h1><div class="main main--fixed"><habbo-compile data="NewsController.promos"></habbo-compile><div class="news__navigation"><a href="/community/category/all" class="news__more" translate="NEWS_MORE"></a></div></div><habbo-ad-unit unit="inlineRectangle" class="aside aside--fixed"></habbo-ad-unit><habbo-web-pages key="common/box_learn_how_to_stay_safe" class="aside aside--box aside--fixed"></habbo-web-pages><habbo-web-pages key="common/box_parents_guide" class="aside aside--box aside--fixed"></habbo-web-pages></section>'
    ), e.put("home/register-banner/register-banner.html",
        '<div class="register-banner__hotel"></div><div class="register-banner__wrapper"><div class="register-banner__register"><h1 class="register-banner__logo">Habbo</h1><h2 class="register-banner__title" translate="HEADER_TITLE"></h2><a href="/registration" class="register-banner__button" translate="REGISTER_PROMPT"></a><habbo-local-register-banner></habbo-local-register-banner></div></div>'
    ), e.put("hotel/client/client.html",
        '<div ngsf-fullscreen habbo-client-close-fullscreen-on-hide ng-class="{ \'client--visible\': ClientController.visible }" class="client"><div class="client__buttons"><button ng-click="ClientController.close()" habbo-client-close-expander class="client__close"><i class="client__close__icon icon icon--habbo"></i><div habbo-client-close-expand class="client__close__expand"><div class="client__close__text" translate="CLIENT_TO_WEB_BUTTON"></div></div></button> <button ngsf-toggle-fullscreen class="client__fullscreen"><i show-if-fullscreen="false" class="client__fullscreen__icon icon icon--fullscreen"></i> <i show-if-fullscreen class="client__fullscreen__icon icon icon--fullscreen-back"></i></button></div><iframe id="hotel-client" ng-if="ClientController.isOpen && ClientController.flashEnabled" ng-src="{{ ClientController.client.clienturl }}" habbo-client-communication class="client__frame"></iframe><habbo-client-reload ng-if="ClientController.isOpen && ClientController.flashEnabled && !ClientController.running" reload="ClientController.reload()"></habbo-client-reload><habbo-client-error ng-if="ClientController.isOpen && !ClientController.flashEnabled"></habbo-client-error><habbo-client-closed ng-if="!ClientController.isOpen"></habbo-client-closed><habbo-interstitial></habbo-interstitial></div>'
    ), e.put("profile/creation/creation-content.html",
        '<section class="creation-content" ng-style="{ \'max-width\': CreationContentController.creation.contentWidth }"><div class="creation-content__expander"><h2 ng-if="CreationContentController.creation.title" class="creation-content__title">{{:: CreationContentController.creation.title}}</h2><div class="creation-content__view"><a habbo-creation-href="CreationContentController.previous" habbo-navigate-to-on-key="left" ng-class="{ \'creation-content__link--disabled\' : !CreationContentController.previous }" class="creation-content__link"><i class="icon icon--arrow-prev"></i></a> <img ng-src="{{:: CreationContentController.creation.url}}" width="{{:: CreationContentController.creation.contentWidth}}" height="{{:: CreationContentController.creation.contentHeight}}" class="creation-content__creation"> <a habbo-creation-href="CreationContentController.next" habbo-navigate-to-on-key="right" ng-class="{ \'creation-content__link--disabled\' : !CreationContentController.next }" class="creation-content__link"><i class="icon icon--arrow-next"></i></a></div><div class="creation-content__meta"><time ng-if="CreationContentController.creation.time">{{:: CreationContentController.creation.time | date: \'longDate\'}}</time><habbo-report ng-if="CreationContentController.creation.type === \'PHOTO\'" creation="CreationContentController.creation"></habbo-report><habbo-like data="CreationContentController.creation" class="creation-content__like"></habbo-like></div><div ng-if="CreationContentController.creation.type === \'PHOTO\'" class="creation-content__actions"><a href="/community/photos" class="creation-content__channel-link" translate="PHOTOS_TITLE"></a><habbo-photo-delete ng-if="CreationContentController.isDeletable()" creation="CreationContentController.creation" class="creation-content__delete"></habbo-photo-delete></div></div></section>'
    ), e.put("profile/creation/creation.html",
        '<habbo-header-small class="profile__header"><habbo-profile-header user="{{:: CreationController.creation.creator_name}}"><h1><small class="creation__header-by" translate="BY"></small> <span>{{:: CreationController.creation.creator_name}}</span></h1></habbo-profile-header></habbo-header-small><habbo-social-share type="creation"></habbo-social-share><main class="wrapper wrapper--content"><habbo-creation-content creation="CreationController.creation" previous="CreationController.previous" next="CreationController.next"></habbo-creation-content></main>'
    ), e.put("profile/item-lists/badges.html",
        '<ul ng-init="limit = 20" infinite-scroll="limit = limit + 10" infinite-scroll-container="\'.modal\'" infinite-scroll-distance="1"><li ng-repeat="badge in BadgeListController.badges | byNameDescriptionOrMotto: BadgeListController.query | limitTo: limit" class="item item--small item--badge"><div class="item__content"><div class="item__icon"><div class="item__icon__aligner"><habbo-badge code="{{:: badge.code}}" name="{{:: badge.name}}"></habbo-badge></div></div><div class="item__text"><h6 class="item__title item__title--multi-line">{{:: badge.name}}</h6><p class="item__description">{{:: badge.description}}</p></div></div></li></ul>'
    ), e.put("profile/item-lists/friends.html",
        '<ul ng-init="limit = 14" infinite-scroll="limit = limit + 7" infinite-scroll-container="\'.modal\'" infinite-scroll-distance="1"><li ng-repeat="friend in FriendListController.friends | byNameDescriptionOrMotto: FriendListController.query | limitTo: limit" class="item item--friend"><a ng-href="/profile/{{:: friend.name | encodeURIComponent}}" ng-init="wave = false" ng-mouseenter="wave = true" ng-mouseleave="wave = false" class="item__content"><div class="item__icon" ng-switch="wave"><habbo-imager ng-switch-when="false" figure="{{:: friend.figureString}}" name="{{:: friend.name}}" direction="s" action="stand" class="item__icon__friend"></habbo-imager><habbo-imager ng-switch-when="true" figure="{{:: friend.figureString}}" name="{{:: friend.name}}" direction="s" action="wave" class="item__icon__friend"></habbo-imager></div><div class="item__text"><h6 class="item__title item__title--single-line">{{:: friend.name}}</h6><p ng-if="friend.motto" class="item__description">{{:: friend.motto}}</p></div></a></li></ul>'
    ), e.put("profile/item-lists/groups.html",
        '<ul ng-init="limit = 20" infinite-scroll="limit = limit + 10" infinite-scroll-container="\'.modal\'" infinite-scroll-distance="1"><li ng-repeat="group in GroupListController.groups | byNameDescriptionOrMotto: GroupListController.query | limitTo: limit" class="item item--small item--group"><a habbo-flash-href="{{:: group.roomId ? \'/hotel?room=\' + group.roomId : \'\'}}" class="item__content"><div class="item__icon"><div class="item__icon__aligner"><habbo-group-badge code="{{:: group.badgeCode}}" name="{{:: group.name}}"></habbo-group-badge></div></div><div class="item__text"><h6 class="item__title item__title--multi-line">{{:: group.name}}</h6><p ng-if="group.description" class="item__description">{{:: group.description}}</p></div></a></li></ul>'
    ), e.put("profile/item-lists/rooms.html",
        '<ul ng-init="limit = 16" infinite-scroll="limit = limit + 8" infinite-scroll-container="\'.modal\'" infinite-scroll-distance="1"><li ng-repeat="room in RoomListController.rooms | byNameDescriptionOrMotto: RoomListController.query | limitTo: limit" class="item item--room"><a ng-href="/room/{{:: room.id}}" class="item__content"><habbo-room-icon class="item__icon" url="{{:: room.thumbnailUrl}}"></habbo-room-icon><div class="item__text"><h6 class="item__title item__title--single-line">{{:: room.name}}</h6><p ng-if="room.description" class="item__description">{{:: room.description}}</p></div></a></li></ul>'
    ), e.put("profile/profile-header/profile-header.html",
        '<div class="profile-header__avatar"><div ng-if="ProfileHeaderController.profile === \'true\'" class="profile-header__link"><habbo-imager action="stand" ng-if="!ProfileHeaderController.isCroco(ProfileHeaderController.motto)" figure="{{:: ProfileHeaderController.figure}}" user="{{:: ProfileHeaderController.figure ? \'\' : ProfileHeaderController.user}}" name="{{:: ProfileHeaderController.user}}" class="profile-header__image"></habbo-imager><div ng-if="ProfileHeaderController.isCroco(ProfileHeaderController.motto)" class="profile-header__image profile-header__image--croco"><img src="https://habboo-a.akamaihd.net/habbo-web/america/en/assets/images/croco.dcdb9e74.png"></div></div><a ng-if="ProfileHeaderController.profile !== \'true\'" ng-href="/profile/{{:: ProfileHeaderController.user | encodeURIComponent}}" class="profile-header__link"><habbo-imager figure="{{:: ProfileHeaderController.figure}}" user="{{:: ProfileHeaderController.figure ? \'\' : ProfileHeaderController.user}}" name="{{:: ProfileHeaderController.user}}" size="largehead" class="profile-header__image profile-header__image--largehead"></habbo-imager></a></div><div class="profile-header__details"><div ng-if="ProfileHeaderController.profile === \'true\'" ng-transclude></div><a ng-if="ProfileHeaderController.profile !== \'true\'" ng-href="/profile/{{:: ProfileHeaderController.user | encodeURIComponent}}" class="profile-header__details__link" ng-transclude></a></div>'
    ),
        e.put("profile/profile-modal/profile-modal.html",
            '<button ng-click="$dismiss()" class="modal__close"></button><h3 translate="{{:: \'PROFILE_\' + ProfileModalController.type.toUpperCase() + \'_TITLE\'}}" class="modal__title"></h3><habbo-search query="query"></habbo-search><div class="item-list--stacked" ng-switch="ProfileModalController.type"><habbo-badge-list ng-switch-when="badges" badges="ProfileModalController.items" query="query"></habbo-badge-list><habbo-friend-list ng-switch-when="friends" friends="ProfileModalController.items" query="query"></habbo-friend-list><habbo-room-list ng-switch-when="rooms" rooms="ProfileModalController.items" query="query"></habbo-room-list><habbo-group-list ng-switch-when="groups" groups="ProfileModalController.items" query="query"></habbo-group-list></div><habbo-empty-results ng-if="(ProfileModalController.items | byNameDescriptionOrMotto: query).length === 0" class="profile-modal__empty"></habbo-empty-results>'
        ), e.put("registration/birthdate/birthdate.html",
        '<fieldset class="form__fieldset"><label for="birthdate-day" class="form__label" translate="FORM_BIRTHDATE_LABEL"></label><p translate="BIRTHDATE_HELP"></p><div class="form__field"><select id="birthdate-day" ng-model="BirthdateController.day" ng-class="{ \'ng-invalid\': (BirthdateController.FormController.birthdate.$invalid && !day|| BirthdateController.FormController.birthdate.$error.remoteDataAge)\n                && (!BirthdateController.FormController.birthdate.$pristine || BirthdateController.FormController.$submitted) }" class="form__select birthdate__day"><option translate="BIRTHDATE_DAY"></option><option ng-repeat="day in BirthdateController.days | daysInMonth: BirthdateController.month : BirthdateController.year" ng-value="{{day}}">{{day}}</option></select><select ng-model="BirthdateController.month" ng-class="{ \'ng-invalid\': (BirthdateController.FormController.birthdate.$invalid && !month || BirthdateController.FormController.birthdate.$error.remoteDataAge)\n                && (!BirthdateController.FormController.birthdate.$pristine || BirthdateController.FormController.$submitted) }" class="form__select birthdate__month"><option translate="BIRTHDATE_MONTH"></option><option ng-repeat="month in BirthdateController.months" ng-value="{{month.value}}" translate="{{month.translationKey}}"></option></select><select ng-model="BirthdateController.year" ng-class="{ \'ng-invalid\': (BirthdateController.FormController.birthdate.$invalid && !year || BirthdateController.FormController.birthdate.$error.remoteDataAge)\n                && (!BirthdateController.FormController.birthdate.$pristine || BirthdateController.FormController.$submitted) }" class="form__select birthdate__year"><option translate="BIRTHDATE_YEAR"></option><option ng-repeat="year in BirthdateController.years" ng-value="{{year}}">{{year}}</option></select><input name="birthdate" ng-model="BirthdateController.birthdate" required type="hidden"><div ng-if="BirthdateController.FormController.birthdate.$invalid && (!BirthdateController.FormController.birthdate.$pristine || BirthdateController.FormController.$submitted)" ng-messages="BirthdateController.FormController.birthdate.$error" class="form__popover form__popover--error"><div ng-message="required">{{ \'ERROR_FIELD_REQUIRED\' | translate }}</div></div></div></fieldset>'
    ), e.put("registration/partner-registration/partner-registration.html",
        '<fieldset class="form__fieldset form__fieldset--box partner-registration"><label for="partner-register" class="form__label" translate="PARTNER_REGISTRATION_LABEL"></label><p translate="PARTNER_REGISTRATION_HELP"></p><div class="form__field"><label for="partner-register" class="form__label--checkbox partner-registration__checkbox"><input id="partner-register" ng-model="PartnerRegistrationController.value" type="checkbox" class="form__checkbox"> <span translate="PARTNER_REGISTRATION_ACCEPT"></span></label></div></fieldset>'
    ), e.put("registration/policies/policies.html",
        '<fieldset class="form__fieldset form__fieldset--box"><div class="form__field"><label for="terms-of-service" class="form__label form__label--checkbox"><input id="terms-of-service" name="termsOfServiceAccepted" ng-model="PoliciesController.policies.termsOfServiceAccepted" required type="checkbox" class="form__checkbox"> <span translate="POLICIES_TERMS_OF_SERVICE"></span></label><div ng-if="PoliciesController.FormController.termsOfServiceAccepted.$invalid\n             && (!PoliciesController.FormController.termsOfServiceAccepted.$pristine\n             || PoliciesController.FormController.$submitted)" ng-messages="PoliciesController.FormController.termsOfServiceAccepted.$error" class="form__popover form__popover--error"><div ng-message="required">{{ \'ERROR_FIELD_REQUIRED\' | translate }}</div></div></div><div class="form__field"><label for="marketing" class="form__label form__label--checkbox"><input id="marketing" ng-model="PoliciesController.policies.marketingAllowed" type="checkbox" class="form__checkbox"> <span translate="POLICIES_MARKETING"></span></label></div></fieldset>'
    ), e.put("room/room-info/room-info.html",
        '<ul class="room-info"><li class="room-info__row"><h3 class="room-info__header" translate="ROOM_DESCRIPTION"></h3><span class="room-info__value room-info--description">{{:: RoomInfoController.description}}</span></li><li class="room-info__row"><h3 class="room-info__header" translate="ROOM_TAGS"></h3><span class="room-info__value">{{:: RoomInfoController.tags.join(\', \')}}</span></li></ul>'
    ), e.put("room/room-open/room-open.html",
        '<main><section class="wrapper wrapper--content"><div class="room__thumbnail"><img habbo-remove-on-error class="room__thumbnail__image" ng-src="{{:: RoomOpenController.room.thumbnailUrl}}"></div><div class="room__content"><h1 class="room__content__title">{{:: RoomOpenController.room.name}}</h1><div class="room__content__left"><div ng-switch="RoomOpenController.room.publicRoom"><official-room-avatar ng-switch-when="true" class="room__owner--official"></official-room-avatar><habbo-avatar ng-switch-when="false" class="room__owner--user" user="{{:: RoomOpenController.room.ownerName}}"></habbo-avatar></div><habbo-room-info description="{{:: RoomOpenController.room.description}}" tags="RoomOpenController.room.tags"></habbo-room-info><a habbo-require-flash ng-href="/hotel?room={{:: RoomOpenController.room.id}}" class="room__enter-button"><span class="room__enter-button__text" translate="ROOM_ENTER_BUTTON"></span></a></div><div class="room__content__right"><div class="room__details"><h3 translate="ROOM_DETAILS"></h3><dl><dt translate="ROOM_RATING"></dt><dd>{{:: RoomOpenController.room.rating}}</dd><dt translate="ROOM_MAX_USERS"></dt><dd>{{:: RoomOpenController.room.maximumVisitors}}</dd></dl></div><div class="room__actions"><a class="room__report" habbo-require-flash ng-href="{{:: RoomOpenController.room.hotelReportLink}}"><span class="room__report__text" translate="ROOM_REPORT_ACTION"></span></a></div></div></div></section><habbo-room-picture url="{{:: RoomOpenController.room.imageUrl}}"></habbo-room-picture></main>'
    ), e.put("room/room-picture/room-picture.html",
        '<section class="room-picture__wrapper"><img habbo-remove-on-error class="room-picture__image" ng-src="{{:: RoomPictureController.url}}"></section>'
    ), e.put("room/room-restricted/room-restricted.html",
        '<main class="wrapper wrapper--content room-restricted"><section class="room-restricted__content"><h3 translate="ROOM_RESTRICTED_TITLE"></h3><h4 class="room-restricted__name">{{:: RoomRestrictedController.room.name}}</h4><div class="room-restricted__explanation" translate="ROOM_RESTRICTED_TEXT"></div><a habbo-require-flash ng-href="/hotel?room={{:: RoomRestrictedController.room.id}}" class="room__enter-button"><span class="room__enter-button__text" translate="ROOM_ENTER_BUTTON"></span></a></section></main>'
    ), e.put("router/spinner/spinner.html",
        '<div class="spinner"><h1 class="spinner__logo">Habbo</h1><div class="spinner__indicator"></div></div>'
    ), e.put("security/login/login-form.html",
        '<form ng-submit="LoginController.login()" name="loginForm" novalidate habbo-shake class="login-form__form"><fieldset class="form__fieldset login-form__fieldset"><div class="form__field"><input name="email" type="email" ng-model="LoginController.email" ng-model-options="{ updateOn: \'default blur\', debounce: { default: 500, blur: 0 } }" required habbo-email habbo-remote-data="\'credentials\'" autofocus placeholder="{{\'FORM_EMAIL_LABEL\' | translate}}" class="form__input login-form__input"></div></fieldset><fieldset class="form__fieldset login-form__fieldset"><div class="form__field"><input name="password" type="password" ng-model="LoginController.password" ng-model-options="{ updateOn: \'default blur\', debounce: { default: 500, blur: 0 } }" required habbo-remote-data="\'credentials\'" placeholder="{{\'FORM_PASSWORD_LABEL\' | translate}}" class="form__input login-form__input"></div><habbo-claim-password class="form__helper login-form__helper"></habbo-claim-password></fieldset><button ng-disabled="LoginController.loginInProgress" type="submit" class="login-form__button" translate="LOGIN_BUTTON"></button></form><div class="login-form__social"><habbo-facebook-connect on-login="LoginController.onLogin()" type="large" translation-key="FACEBOOK_LOGIN"></habbo-facebook-connect><habbo-facebook-connect on-login="LoginController.onLogin()" type="small"></habbo-facebook-connect><div class="login-form__rpx"><habbo-rpx-login></habbo-rpx-login></div></div><div class="login-form__register"><a href="/registration" habbo-android-download-link habbo-ios-download-link translate="LOGIN_REGISTER"></a></div>'
    ), e.put("security/login/login-modal.html",
        '<div class="login"><button ng-click="$dismiss()" class="modal__close"></button><h3 translate="LOGIN" class="modal__title"></h3><div class="modal__content"><habbo-login-form on-login="$close()"></habbo-login-form></div></div>'
    ), e.put("security/safety-lock/safety-answering-modal.html",
        '<button ng-click="$dismiss()" class="modal__close"></button><h3 translate="SAFETY_LOCK_TITLE" class="modal__title"></h3><div class="modal__content"><habbo-safety-answering-form data="SafetyAnsweringController.data" questions="SafetyAnsweringController.questions" target-action="SafetyAnsweringController.targetAction(SafetyAnsweringController.data)" on-success="$close()" on-cancel="$dismiss()"></habbo-safety-answering-form></div>'
    ), e.put("security/safety-lock/safety-lock-form.html",
        '<form ng-submit="unlock()" name="safetyLockForm" novalidate class="form"><p translate="SAFETY_LOCK_ANSWER"></p><div ng-if="safetyLockForm.$error.remoteDataAnswer" class="form__message form__message--error" translate="ERROR_SAFETY_LOCK_ANSWER"></div><fieldset class="form__fieldset"><label for="safety-lock-answer1" class="form__label" translate="{{questions[0].questionKey}}"></label><div class="form__field"><input id="safety-lock-answer1" name="answer1" type="password" ng-model="answers.answer1" ng-model-options="{ updateOn: \'default blur\', debounce: { default: 500, blur: 0 } }" required habbo-remote-data="\'answer\'" habbo-password-toggle-mask autocomplete="off" class="form__input"><div ng-if="safetyLockForm.answer1.$error.required && (!safetyLockForm.answer1.$pristine || safetyLockForm.$submitted)" class="form__popover form__popover--error">{{ \'ERROR_FIELD_REQUIRED\' | translate }}</div></div></fieldset><fieldset class="form__fieldset"><label for="safety-lock-answer2" class="form__label" translate="{{questions[1].questionKey}}"></label><div class="form__field"><input id="safety-lock-answer2" name="answer2" type="password" ng-model="answers.answer2" ng-model-options="{ updateOn: \'default blur\', debounce: { default: 500, blur: 0 } }" required habbo-remote-data="\'answer\'" habbo-password-toggle-mask autocomplete="off" class="form__input"><div ng-if="safetyLockForm.answer1.$error.required && (!safetyLockForm.answer2.$pristine || safetyLockForm.$submitted)" class="form__popover form__popover--error">{{ \'ERROR_FIELD_REQUIRED\' | translate }}</div></div></fieldset><div ng-if="isTrustedLocationEnabled"><fieldset class="form__fieldset form__fieldset--box"><div class="form__field"><label for="trust-once" class="form__label form__label--radiobutton"><input id="trust-once" ng-model="answers.trust" ng-value="false" type="radio" class="form__radiobutton"> <span translate="SAFETY_LOCK_SET_TRUSTED_ONCE"></span></label></div><div class="form__field"><label for="trust-save" class="form__lable form__label--radiobutton"><input id="trust-save" ng-model="answers.trust" ng-value="true" type="radio" class="form__radiobutton"> <span translate="SAFETY_LOCK_SET_TRUSTED_SAVE"></span></label></div></fieldset></div><div class="form__footer"><a ng-click="onCancel()" class="form__cancel" translate="FORM_CANCEL_LABEL"></a> <button ng-disabled="unlockingInProgress" type="submit" class="form__submit" translate="FORM_BUTTON_UNLOCK"></button></div></form>'
    ), e.put("security/safety-lock/safety-lock-modal.html",
        '<button ng-click="$dismiss()" class="modal__close"></button><h3 translate="SAFETY_LOCK_TITLE" class="modal__title"></h3><div class="modal__content"><habbo-safety-lock-form questions="SafetyLockController.questions" on-unlock="$close()" on-cancel="$dismiss()"></habbo-safety-lock-form></div>'
    ), e.put("settings/account-security/account-security-edit.html",
        '<habbo-message-container ng-if="AccountSecurityEditController.accountSecurityStatus === \'enabled\'" type="check"><h3 translate="ACCOUNT_SECURITY_STATUS_ENABLED_TITLE"></h3><div class="account-security__status"><button ng-click="AccountSecurityEditController.openModal()" class="account-security__edit" translate="ACCOUNT_SECURITY_EDIT_BUTTON"></button> <button ng-click="AccountSecurityEditController.disable()" ng-disabled="AccountSecurityEditController.disableInProgress" class="account-security__disable" translate="ACCOUNT_SECURITY_DISABLE"></button></div></habbo-message-container><habbo-message-container ng-if="AccountSecurityEditController.accountSecurityStatus === \'disabled\'" type="exclamation"><h3 translate="ACCOUNT_SECURITY_STATUS_DISABLED_TITLE"></h3><button ng-click="AccountSecurityEditController.openModal()" class="account-security__enable" translate="ACCOUNT_SECURITY_ENABLE_BUTTON"></button></habbo-message-container><habbo-message-container ng-if="AccountSecurityEditController.accountSecurityStatus === \'identity_verification_required\'" type="exclamation"><h3 translate="ACCOUNT_SECURITY_STATUS_VERIFICATION_REQUIRED_TITLE"></h3><a ng-href="/settings/email" translate="ACCOUNT_SECURITY_STATUS_VERIFICATION_REQUIRED_LINK_TEXT"></a></habbo-message-container>'
    ), e.put("settings/account-security/account-security.html",
        '<h2 translate="ACCOUNT_SECURITY_TITLE"></h2><p translate="ACCOUNT_SECURITY_DESCRIPTION"></p><habbo-account-security-edit account-security-status="AccountSecurityController.accountSecurityStatus"></habbo-account-security-edit><div ng-if="AccountSecurityController.accountSecurityStatus === \'enabled\'" class="account-security__trusted-locations"><h2 translate="ACCOUNT_SECURITY_TRUSTED_LOCATIONS_TITLE"></h2><p translate="ACCOUNT_SECURITY_TRUSTED_LOCATIONS_DESCRIPTION"></p><habbo-trusted-locations-reset></habbo-trusted-locations-reset></div>'
    ), e.put("settings/account-security/trusted-locations-reset.html",
        '<button ng-click="TrustedLocationsResetController.reset()" ng-disabled="TrustedLocationsResetController.inProgress" class="account-security__reset" translate="ACCOUNT_SECURITY_RESET_TRUSTED_LOGINS_BUTTON"></button>'
    ), e.put("settings/avatar-selection/avatar-selection.html",
        '<h2 translate="AVATAR_SELECTION_TITLE"></h2><habbo-avatar-create habbo-require-non-staff-account-session avatars="AvatarSelectionController.avatars"></habbo-avatar-create><habbo-avatar-search avatars="AvatarSelectionController.avatars"></habbo-avatar-search>'
    ), e.put("settings/email-change/email-change-form.html",
        '<form ng-submit="EmailChangeFormController.update()" name="emailChangeForm" autocomplete="off" novalidate class="form form--left"><habbo-password-current password-current="EmailChangeFormController.emailChangeData.currentPassword"></habbo-password-current><habbo-email-address email-address="EmailChangeFormController.emailChangeData.newEmail" type="box"><label for="email-address" class="form__label" translate="FORM_NEW_EMAIL_LABEL"></label><p translate="EMAIL_NEW_HELP"></p></habbo-email-address><div class="form__footer"><button ng-disabled="EmailChangeFormController.updateInProgress" type="submit" class="form__submit" translate="FORM_BUTTON_CHANGE"></button></div></form>'
    ), e.put("settings/email-change/email-change.html",
        '<habbo-activation-status></habbo-activation-status><h2 translate="EMAIL_CHANGE_TITLE"></h2><habbo-email-change-form></habbo-email-change-form>'
    ), e.put("settings/password-change/password-change-form.html",
        '<form ng-submit="PasswordChangeFormController.update()" name="changePasswordForm" autocomplete="off" novalidate class="form form--left"><habbo-password-current password-current="PasswordChangeFormController.passwords.currentPassword"></habbo-password-current><habbo-password-new is-new="true" password-new="PasswordChangeFormController.passwords.password" password-new-repeated="PasswordChangeFormController.passwords.passwordRepeated" user-name="{{:: PasswordChangeFormController.user.name}}" user-email="{{:: PasswordChangeFormController.user.email}}"></habbo-password-new><div class="form__footer"><button ng-disabled="PasswordChangeFormController.updateInProgress" type="submit" class="form__submit" translate="FORM_BUTTON_CHANGE"></button></div></form>'
    ), e.put("settings/password-change/password-change.html",
        '<h2 translate="PASSWORD_CHANGE_TITLE"></h2><habbo-password-change-form></habbo-password-change-form>'
    ), e.put("settings/privacy-settings/privacy-settings-form.html",
        '<form ng-submit="PrivacySettingsFormController.save()" name="privacySettingsForm" novalidate class="form form--left"><fieldset class="form__fieldset"><h4 translate="SETTINGS_PROFILE_VISIBILITY_TITLE"></h4><p translate="SETTINGS_PROFILE_VISIBILITY_DESCRIPTION"></p><div class="form__field"><label class="form__label form__label--radiobutton"><input name="profileVisible" ng-model="PrivacySettingsFormController.privacySettings.profileVisible" ng-value="true" type="radio" class="form__radiobutton"> <span translate="SETTINGS_EVERYONE_LABEL"></span></label></div><div class="form__field"><label class="form__label form__label--radiobutton"><input name="profileVisible" ng-model="PrivacySettingsFormController.privacySettings.profileVisible" ng-value="false" type="radio" class="form__radiobutton"> <span translate="SETTINGS_ME_LABEL"></span></label></div></fieldset><fieldset class="form__fieldset form__fieldset--box"><h4 translate="SETTINGS_ONLINE_STATUS_TITLE"></h4><p translate="SETTINGS_ONLINE_STATUS_DESCRIPTION"></p><div class="form__field"><label class="form__label form__label--radiobutton"><input name="onlineStatusVisible" ng-model="PrivacySettingsFormController.privacySettings.onlineStatusVisible" ng-value="true" type="radio" class="form__radiobutton"> <span translate="SETTINGS_EVERYONE_LABEL"></span></label></div><div class="form__field"><label class="form__label form__label--radiobutton"><input name="onlineStatusVisible" ng-model="PrivacySettingsFormController.privacySettings.onlineStatusVisible" ng-value="false" type="radio" class="form__radiobutton"> <span translate="SETTINGS_ME_LABEL"></span></label></div></fieldset><fieldset class="form__fieldset"><h4 translate="SETTINGS_FRIENDS_CAN_FOLLOW_TITLE"></h4><div class="form__field"><label for="friend-can-follow" class="form__label form__label--checkbox"><input id="friend-can-follow" name="friendCanFollow" ng-model="PrivacySettingsFormController.privacySettings.friendCanFollow" type="checkbox" class="form__checkbox"> <span translate="SETTINGS_ENABLE_FRIEND_CAN_FOLLOW_LABEL"></span></label></div></fieldset><fieldset class="form__fieldset form__fieldset--box"><h4 translate="SETTINGS_FRIEND_REQUESTS_ENABLED_TITLE"></h4><div class="form__field"><label for="friend-request-enable" class="form__label form__label--checkbox"><input id="friend-request-enable" name="friendRequestEnabled" ng-model="PrivacySettingsFormController.privacySettings.friendRequestEnabled" type="checkbox" class="form__checkbox"> <span translate="SETTINGS_ENABLE_FRIEND_REQUESTS_LABEL"></span></label></div></fieldset><fieldset class="form__fieldset"><h4 translate="SETTINGS_OFFLINE_MESSAGING_ENABLED_TITLE"></h4><div class="form__field"><label for="offline-messaging-enable" class="form__label form__label--checkbox"><input id="offline-messaging-enable" name="offlineMessagingEnabled" ng-model="PrivacySettingsFormController.privacySettings.offlineMessagingEnabled" type="checkbox" class="form__checkbox"> <span translate="SETTINGS_ENABLE_OFFLINE_MESSAGING_LABEL"></span></label></div></fieldset><fieldset class="form__fieldset form__fieldset--box"><h4 translate="SETTINGS_EMAIL_NOTIFICATIONS_TITLE"></h4><div class="form__field"><label for="email-newsletter-enable" class="form__label form__label--checkbox"><input id="email-newsletter-enable" name="emailNewsletterEnabled" ng-model="PrivacySettingsFormController.privacySettings.emailNewsletterEnabled" type="checkbox" class="form__checkbox"> <span translate="SETTINGS_ENABLE_NEWSLETTER_LABEL"></span></label></div><div class="form__field"><span translate="SETTINGS_EMAIL_NOTIFICATIONS_SUBTITLE"></span><label class="form__label form__label--checkbox"><input name="emailMiniMailNotificationEnabled" ng-model="PrivacySettingsFormController.privacySettings.emailMiniMailNotificationEnabled" type="checkbox" class="form__checkbox"> <span translate="SETTINGS_ENABLE_NOTIFICATION_MINIMAIL_LABEL"></span></label><label class="form__label form__label--checkbox"><input name="emailFriendRequestNotificationEnabled" ng-model="PrivacySettingsFormController.privacySettings.emailFriendRequestNotificationEnabled" type="checkbox" class="form__checkbox"> <span translate="SETTINGS_ENABLE_NOTIFICATION_FRIEND_REQUEST_LABEL"></span></label><label class="form__label form__label--checkbox"><input name="emailGiftNotificationEnabled" ng-model="PrivacySettingsFormController.privacySettings.emailGiftNotificationEnabled" type="checkbox" class="form__checkbox"> <span translate="SETTINGS_ENABLE_NOTIFICATION_GIFT_LABEL"></span></label><label class="form__label form__label--checkbox"><input name="emailRoomMessageNotificationEnabled" ng-model="PrivacySettingsFormController.privacySettings.emailRoomMessageNotificationEnabled" type="checkbox" class="form__checkbox"> <span translate="SETTINGS_ENABLE_NOTIFICATION_ROOM_LABEL"></span></label><label class="form__label form__label--checkbox"><input name="emailGroupNotificationEnabled" ng-model="PrivacySettingsFormController.privacySettings.emailGroupNotificationEnabled" type="checkbox" class="form__checkbox"> <span translate="SETTINGS_ENABLE_NOTIFICATION_GROUP_LABEL"></span></label></div></fieldset><div class="form__footer"><button ng-disabled="PrivacySettingsFormController.sendInProgress" type="submit" class="form__submit" translate="FORM_BUTTON_SAVE"></button></div></form>'
    ), e.put("settings/privacy-settings/privacy-settings.html",
        '<h2 translate="PRIVACY_SETTINGS_TITLE"></h2><habbo-privacy-settings-form privacy-settings="PrivacySettingsController.privacySettings"></habbo-privacy-settings-form>'
    ), e.put("shop/credit-card-form/credit-card-form.html",
        '<form ng-submit="CreditCardController.markActiveAndSubmit({ data: CreditCardController.card })" name="creditCardForm" novalidate class="form credit-card-form"><p translate="SHOP_CREDIT_CARD_INSTRUCTION"></p><fieldset class="form__fieldset form__fieldset--inline credit-card-form__input-section"><div class="form__field"><label for="card-number" class="form__label" translate="SHOP_CREDIT_CARD_NUMBER"></label><input id="card-number" name="number" ng-model="CreditCardController.card.number" class="form__input" ng-required="true" cc-number cc-type="cardType" cc-format="true"><div ng-if="creditCardForm.number.$invalid && !creditCardForm.number.$pristine && creditCardForm.number.$touched" class="form__popover form__popover--error form__popover--inline" ng-required="true"><p translate="SHOP_CREDIT_CARD_INVALID_NUMBER"></p></div></div><div class="credit-card-form__expiry-cvc-row form__fieldset"><div class="form__field credit-card-form__expiry-field"><label class="form__label" translate="SHOP_CREDIT_CARD_EXPIRY_DATE"></label><div cc-exp class="credit-card-form__expiry"><input name="month" ng-model="CreditCardController.card.expMonth" cc-exp-month ng-required="true" class="form__input credit-card-form__expiry-input" placeholder="{{\'SHOP_CREDIT_CARD_EXPIRY_HINT_MM\' | translate}}"> <span class="credit-card-form__expiry-slash">/</span> <input name="year" ng-model="CreditCardController.card.expYear" cc-exp-year ng-required="true" class="form__input credit-card-form__expiry-input" placeholder="{{\'SHOP_CREDIT_CARD_EXPIRY_HINT_YY\' | translate}}"></div><div ng-if="(creditCardForm.month.$invalid && !creditCardForm.month.$pristine && creditCardForm.month.$touched)\n                              || (creditCardForm.year.$invalid && !creditCardForm.year.$pristine && creditCardForm.year.$touched)\n                              || (creditCardForm.$error.ccExp && !(creditCardForm.month.$pristine || creditCardForm.year.$pristine) && creditCardForm.month.$touched && creditCardForm.year.$touched)" class="form__popover form__popover--error form__popover--inline"><p translate="SHOP_CREDIT_CARD_INVALID_DATE"></p></div></div><div class="form__field credit-card-form__cvc-field"><label class="form__label" translate="SHOP_CREDIT_CARD_CVC"></label><input name="cvc" ng-required="true" ng-model="CreditCardController.card.cvc" class="form__input credit-card-form__cvc-input" cc-cvc> <img src="https://habboo-a.akamaihd.net/habbo-web/america/en/assets/images/cc_cvc_instruction.345e33e4.png" class="credit-card-form__cvc-icon"><div ng-if="creditCardForm.cvc.$invalid && !creditCardForm.cvc.$pristine && creditCardForm.cvc.$touched" class="form__popover form__popover--error form__popover--inline"><p translate="SHOP_CREDIT_CARD_INVALID_CVC"></p></div></div></div><div class="form__field"><label class="form__label" translate="SHOP_CREDIT_CARD_NAME"></label><input name="name" ng-model="CreditCardController.card.name" class="form__input" ng-required="true"></div><h3 translate="SHOP_SMALLPRINT_TITLE"></h3><p class="payment-steps__legal" translate="SHOP_CREDIT_CARD_SMALLPRINT"></p></fieldset><button ng-disabled="CreditCardController.paymentInProgress || creditCardForm.$invalid" type="submit" translate="SHOP_PAYMENT_BUTTON" class="payment-methods__button payment-button"></button></form>'
    ), e.put("shop/credit-icon/credit-icon.html",
        "<div ng-class=\"[{ 'credit-icon--double': CreditIconController.isDouble },\n               'credit-icon--' + CreditIconController.getIndex(CreditIconController.amount) ]\" class=\"credit-icon\"></div>"
    ), e.put("shop/credit-title/credit-title.html",
        '<span ng-if="CreditTitleController.isDouble" translate="DOUBLE_CREDITS_PREFIX" class="credit-title__prefix"></span> <span translate="CREDITS_AMOUNT" translate-values="{ value: CreditTitleController.amount }"></span>'
    ), e.put("shop/earn-credits/earn-credits.html",
        '<section class="main"><habbo-web-pages key="store/earn-credits/earn-credits"></habbo-web-pages><habbo-earn-credits-frame offer-wall-url="{{:: EarnCreditsController.offerWallUrl.url }}"></habbo-earn-credits-frame></section><habbo-purse habbo-require-session class="aside aside--box aside--push-down"></habbo-purse><habbo-web-pages key="store/earn-credits/box_help" class="aside aside--box"></habbo-web-pages>'
    ), e.put("shop/prepaid/prepaid.html",
        '<header class="shop__header"><h1 translate="SHOP_PREPAID_TITLE" class="shop__header__title"></h1><habbo-shop-countries ng-if="PrepaidController.countries.length > 1" country="PrepaidController.country" countries="PrepaidController.countries" class="shop__header__country"></habbo-shop-countries></header><section><article class="main static-content"><habbo-compile data="PrepaidController.page"></habbo-compile></article><habbo-purse habbo-require-session class="aside aside--box"></habbo-purse><aside habbo-require-session class="aside aside--box"><h3 translate="SHOP_REDEEM_TITLE"></h3><habbo-voucher-redeem></habbo-voucher-redeem></aside><habbo-web-pages key="common/box_account_issues" class="aside aside--box"></habbo-web-pages></section>'
    ), e.put("shop/purse/purse.html",
        '<aside><h3 translate="SHOP_PURSE_TITLE"></h3><div class="purse"><div class="purse__columns"><div class="purse__column"><div translate="SHOP_PURSE_CREDITS" translate-values="{ creditBalance: PurseController.purse.creditBalance }" class="purse__item purse__item--credits"></div><div translate="SHOP_PURSE_DIAMONDS" translate-values="{ diamondBalance: PurseController.purse.diamondBalance }" class="purse__item purse__item--diamonds"></div></div><div class="purse__column"><div class="purse__item purse__item--habbo-club"><span ng-if="PurseController.purse.habboClubDays !== 0" translate="SHOP_PURSE_HC_DAYS" translate-values="{ habboClubDays: PurseController.purse.habboClubDays }"></span> <span ng-if="PurseController.purse.habboClubDays === 0" translate="SHOP_PURSE_NO_HC"></span></div><div class="purse__item purse__item--builders-club"><span ng-if="PurseController.purse.buildersClubDays !== 0" translate="SHOP_PURSE_BC_DAYS" translate-values="{ buildersClubDays: PurseController.purse.buildersClubDays }"></span> <span ng-if="PurseController.purse.buildersClubDays === 0" translate="SHOP_PURSE_NO_BC"></span></div></div></div></div><div class="purse__footer"><a href="/hotel?link=habboUI/open/hccenter" class="purse__hc-center" translate="SHOP_PURSE_HC_LINK"></a></div></aside>'
    ), e.put("shop/shop-countries/shop-countries.html",
        '<label for="shop-country" class="form__label form__label--inline"><small translate="SHOP_COUNTRY_LABEL" translate-values="{ countryName: ShopCountriesController.country.name }"></small></label><select id="shop-country" ng-model="ShopCountriesController.country" ng-options="country.name for country in ShopCountriesController.countries track by country.countryCode" class="form__select form__select--inline"></select>'
    ), e.put("shop/shop-footer/shop-footer.html",
        '<footer class="shop-footer"><section class="main shop-footer__main"><h3 translate="SHOP_NOTICE_TITLE" class="shop-footer__title"></h3><p translate="SHOP_NOTICE_CONTENTS" class="shop-footer__text"></p></section><aside class="aside shop-footer__aside"><h4 translate="SHOP_NOTICE_PROVIDER_TITLE" class="shop-footer__title--aside"></h4><p translate="SHOP_NOTICE_PROVIDER" class="shop-footer__text"></p></aside></footer>'
    ), e.put("shop/store/store.html",
        '<header class="shop__header"><h1 translate="SHOP_TITLE" class="shop__header__title"></h1><habbo-shop-countries ng-if="StoreController.countries.length > 1" country="StoreController.inventory.country" countries="StoreController.countries" class="shop__header__country"></habbo-shop-countries></header><section><div class="main"><habbo-targeted-offer offer="StoreController.offer" ng-if="StoreController.offer"></habbo-targeted-offer><habbo-category-filter ng-show="StoreController.inventory.paymentCategories.length > 0" payment-categories="StoreController.inventory.paymentCategories" selected-category="StoreController.selectedCategory"></habbo-category-filter><habbo-inventory inventory="StoreController.inventory" selected-category="{{StoreController.selectedCategory}}"></habbo-inventory></div><habbo-purse habbo-require-session class="aside aside--box"></habbo-purse><aside habbo-require-session class="aside aside--box"><h3 translate="SHOP_REDEEM_TITLE"></h3><habbo-voucher-redeem></habbo-voucher-redeem></aside><habbo-web-pages key="common/box_mall_info" class="aside aside--box"></habbo-web-pages></section>'
    ), e.put("shop/subscriptions/subscriptions.html",
        '<section><div class="main"><habbo-message-container type="exclamation"><h3 translate="SHOP_RECURRING_SUBSCRIPTION_NOT_SUPPORTED_TITLE"></h3><p translate="SHOP_RECURRING_SUBSCRIPTION_NOT_SUPPORTED_DESCRIPTION"></p></habbo-message-container></div><habbo-purse class="aside aside--box"></habbo-purse><aside class="aside aside--box"><h3 translate="SHOP_REDEEM_TITLE"></h3><habbo-voucher-redeem></habbo-voucher-redeem></aside><habbo-web-pages key="common/box_mall_info" class="aside aside--box"></habbo-web-pages></section>'
    ),
        e.put("shop/transactions/transactions-list.html",
            '<div ng-if="TransactionsListController.transactions.length > 0"><habbo-transactions-history transactions="TransactionsListController.transactions" limit-to="{{TransactionsListController.transactionLimit}}"></habbo-transactions-history><div class="transactions__footer"><p class="transactions__notice" translate="TRANSACTIONS_NOTICE"></p><button ng-if="!TransactionsListController.hideShowAll\n                       && TransactionsListController.transactions.length > TransactionsListController.transactionLimit" ng-click="TransactionsListController.showAll()" class="transactions__button" translate="TRANSACTIONS_SHOW_ALL"></button></div></div><habbo-empty-results ng-if="TransactionsListController.transactions.length === 0" translation-key="TRANSACTIONS_EMPTY"></habbo-empty-results>'
        ), e.put("shop/transactions/transactions.html",
        '<header class="shop__header"><h1 class="shop__header__title shop__header__title--single" translate="SHOP_TRANSACTIONS_TITLE"></h1></header><section><habbo-transactions-list transactions="TransactionsController.items" class="main"></habbo-transactions-list><habbo-purse class="aside aside--box"></habbo-purse><habbo-web-pages key="common/box_account_issues" class="aside aside--box"></habbo-web-pages></section>'
    ), e.put("shop/voucher-redeem/voucher-redeem.html",
        '<form ng-submit="VoucherRedeemController.redeem()" name="voucherRedeemForm" novalidate class="form"><button ng-disabled="VoucherRedeemController.redeemInProgress" type="submit" translate="SHOP_REDEEM_BUTTON" class="form__submit form__submit--inline"></button><fieldset class="form__fieldset form__fieldset--inline"><div class="form__field"><input placeholder="{{\'SHOP_REDEEM_PLACEHOLDER\' | translate}}" name="voucherCode" ng-model="VoucherRedeemController.voucherCode" ng-model-options="{ updateOn: \'default blur\', debounce: { default: 500, blur: 0 } }" required autocomplete="off" habbo-remote-data="[\'nonexistent\', \'redeemed\', \'failed\']" class="form__input voucher-redeem__input"><div ng-if="voucherRedeemForm.voucherCode.$invalid && (!voucherRedeemForm.voucherCode.$pristine || voucherRedeemForm.$submitted)" ng-messages="voucherRedeemForm.voucherCode.$error" class="form__popover form__popover--error form__popover--inline"><div ng-message="required">{{\'ERROR_FIELD_REQUIRED\' | translate}}</div><div ng-message="pattern">{{\'ERROR_VOUCHER_CODE_PATTERN\' | translate}}</div><div ng-message="remoteDataNonexistent">{{\'ERROR_VOUCHER_CODE_NONEXISTENT\' | translate}}</div><div ng-message="remoteDataRedeemed">{{\'ERROR_VOUCHER_CODE_REDEEMED\' | translate}}</div><div ng-message="remoteDataFailed">{{\'ERROR_VOUCHER_CODE_FAILED\' | translate}}</div></div></div></fieldset><small class="form__helper" translate="PREPAID_ORDER_INSTRUCTION"></small></form>'
    ), e.put("common/ad-unit/ad-double-click/ad-double-click.html",
        '<div ng-dfp-ad="{{:: AdDoubleClickController.id}}" translation="{{ \'THIRD_PARTY_AD\' | translate }}" class="ad-double-click"></div>'
    ), e.put("common/columns/card/card.html",
        '<div class="card"><div class="card__content"><a habbo-creation-href="CardController.item" class="card__link"><div class="card__image__aligner"><img ng-src="{{:: CardController.item.url}}" ng-class="{\n                       \'card__image--selfie\': CardController.item.type === \'SELFIE\',\n                       \'card__image--photo\': CardController.item.type === \'PHOTO\',\n                       \'card__image--wide\': CardController.item.type === \'USER_CREATION\' && CardController.item.contentHeight < CardController.item.contentWidth,\n                       \'card__image--tall\': CardController.item.type === \'USER_CREATION\' && CardController.item.contentHeight >= CardController.item.contentWidth\n                     }" class="card__image" alt="{{:: CardController.item.title}}"></div></a><div class="card__meta"><h5 ng-if="CardController.item.title" class="card__title">{{:: CardController.item.title}}</h5><time class="card__date">{{:: CardController.item.timestamp * 1000 | date: \'shortDate\'}}</time><habbo-like data="CardController.item" class="card__like"></habbo-like></div></div><div ng-transclude></div></div>'
    ), e.put("common/columns/columns-channel/columns-channel.html",
        '<div><div class="columns" ng-init="limit = 16" infinite-scroll="limit = limit + 8" infinite-scroll-distance="1"><habbo-card ng-repeat="card in ColumnsChannelController.items | limitTo: limit" item="card" class="columns__column"><habbo-avatar class="card__creator" user="{{:: card.creator_name}}"></habbo-avatar></habbo-card></div></div>'
    ), e.put("common/columns/columns-profile/columns-profile.html",
        '<div><div ng-init="limit = 16" infinite-scroll="limit = limit + 8" infinite-scroll-distance="1" class="columns"><habbo-card ng-repeat="card in ColumnsProfileController.items | limitTo: limit" item="card" class="columns__column"></habbo-card></div></div>'
    ), e.put("common/form/captcha/captcha.html",
        '<fieldset class="form__fieldset captcha__wrapper"><div class="form__field"><no-captcha g-recaptcha-response="CaptchaController.captchaToken" control="CaptchaController.noCaptchaController" expired-callback="CaptchaController.onExpire" class="captcha"></no-captcha><input name="captchaToken" ng-model="CaptchaController.captchaToken" required type="hidden"><div ng-if="CaptchaController.FormController.captchaToken.$invalid\n                    && (!CaptchaController.FormController.captchaToken.$pristine\n                    || CaptchaController.FormController.$submitted)" class="form__popover form__popover--error form__popover--captcha" translate="ERROR_CAPTCHA_REQUIRED"></div></div></fieldset>'
    ), e.put("common/form/email-address/email-address.html",
        '<fieldset class="form__fieldset"><div ng-transclude></div><div class="form__field"><input id="email-address" name="emailAddress" type="email" ng-model="EmailAddressController.emailAddress" ng-model-options="{ updateOn: \'default blur\', debounce: { default: 500, blur: 0 } }" required habbo-email habbo-remote-data="[\'emailInvalid\', \'emailUsedInRegistration\', \'emailUsedInChange\']" autocomplete="off" class="form__input"><div ng-if="EmailAddressController.FormController.emailAddress.$invalid\n                    && (!EmailAddressController.FormController.emailAddress.$pristine\n                    || EmailAddressController.FormController.$submitted)" ng-messages="EmailAddressController.FormController.emailAddress.$error" class="form__popover form__popover--error"><div ng-message="email, remoteDataEmailInvalid">{{ \'ERROR_EMAIL_INVALID\' | translate }}</div><div ng-message="required">{{ \'ERROR_FIELD_REQUIRED\' | translate }}</div><div ng-message="remoteDataEmailUsedInRegistration">{{ \'ERROR_EMAIL_REGISTRATION_USED\' | translate }}</div><div ng-message="remoteDataEmailUsedInChange">{{ \'ERROR_EMAIL_CHANGE_USED\' | translate }}</div></div></div></fieldset>'
    ), e.put("common/form/password-current/password-current.html",
        '<fieldset class="form__fieldset"><label for="password-current" translate="CURRENT_PASSWORD_LABEL" class="form__label"></label><div class="form__field"><input id="password-current" name="passwordCurrent" type="password" ng-model="PasswordCurrentController.passwordCurrent" ng-model-options="{ updateOn: \'default blur\', debounce: { default: 500, blur: 0 } }" required habbo-password-toggle-mask habbo-remote-data="\'password\'" autocomplete="off" class="form__input"><div ng-if="PasswordCurrentController.FormController.passwordCurrent.$invalid\n                    && (!PasswordCurrentController.FormController.passwordCurrent.$pristine\n                    || PasswordCurrentController.FormController.$submitted)" ng-messages="PasswordCurrentController.FormController.passwordCurrent.$error" class="form__popover form__popover--error"><div ng-message="required">{{\'ERROR_FIELD_REQUIRED\' | translate}}</div><div ng-message="remoteDataPassword">{{\'ERROR_INCORRECT_PASSWORD\' | translate}}</div></div></div></fieldset>'
    ), e.put("common/form/password-new/password-new.html",
        '<fieldset class="form__fieldset form__fieldset--box form__fieldset--box-top"><label for="password-new" class="form__label" translate="{{:: PasswordNewController.isNew === \'true\' ? \'NEW_PASSWORD_LABEL\' : \'PASSWORD_LABEL\'}}"></label><p translate="PASSWORD_CHANGE_HELP"></p><div class="form__field"><input id="password-new" name="passwordNew" type="password" ng-model="PasswordNewController.passwordNew" ng-model-options="{ updateOn: \'default blur\', debounce: { default: 500, blur: 0 } }" required ng-maxlength="32" ng-minlength="6" habbo-password-email="{{:: PasswordNewController.userEmail}}" habbo-password-name="{{:: PasswordNewController.userName}}" habbo-password-pattern habbo-password-toggle-mask habbo-remote-data="[\'passwordName\', \'passwordEmail\', \'passwordUsed\']" autocomplete="off" class="form__input"><div ng-if="(PasswordNewController.FormController.passwordNew.$invalid\n                    && (!PasswordNewController.FormController.passwordNew.$pristine\n                    || PasswordNewController.FormController.$submitted))\n                    || (!PasswordNewController.FormController.passwordNew.$pristine\n                    && PasswordNewController.FormController.passwordNew.$valid)" ng-messages="PasswordNewController.FormController.passwordNew.$error" ng-class="{ \'form__popover--error\': PasswordNewController.FormController.passwordNew.$invalid }" class="form__popover"><div ng-message="required">{{\'ERROR_FIELD_REQUIRED\' | translate}}</div><habbo-password-strength ng-if="!PasswordNewController.FormController.passwordNew.$error.required" model-value="PasswordNewController.passwordNew" model-name="passwordNew"><div ng-message="maxlength">{{\'ERROR_PASSWORD_MAX_LENGTH\' | translate}}</div><div ng-message="minlength">{{\'ERROR_PASSWORD_MIN_LENGTH\' | translate}}</div><div ng-message="passwordPattern">{{\'ERROR_PASSWORD_PATTERN\' | translate}}</div><div ng-message="passwordName, remoteDataPasswordName">{{\'ERROR_PASSWORD_CONTAINS_NAME\' | translate}}</div><div ng-message="passwordEmail, remoteDataPasswordEmail">{{\'ERROR_PASSWORD_CONTAINS_EMAIL\' | translate}}</div><div ng-message="passwordUsed, remoteDataPasswordUsed">{{\'ERROR_PASSWORD_USED_EARLIER\' | translate}}</div></habbo-password-strength></div></div></fieldset><fieldset class="form__fieldset form__fieldset--box form__fieldset--box-bottom"><label for="password-new-repeated" class="form__label" translate="PASSWORD_REPEAT_LABEL"></label><div class="form__field"><input id="password-new-repeated" name="passwordNewRepeated" type="password" ng-model="PasswordNewController.passwordNewRepeated" ng-model-options="{ updateOn: \'default blur\', debounce: { default: 500, blur: 0 } }" required habbo-matches="passwordNew" habbo-password-toggle-mask autocomplete="off" class="form__input"><div ng-if="PasswordNewController.FormController.passwordNew.$valid\n                    && PasswordNewController.FormController.passwordNewRepeated.$invalid" ng-messages="PasswordNewController.FormController.passwordNewRepeated.$error" class="form__popover form__popover--error"><div ng-message="required">{{\'ERROR_FIELD_REQUIRED\' | translate}}</div><div ng-message="matches">{{\'ERROR_PASSWORDS_NOT_MATCHING\' | translate}}</div></div></div></fieldset>'
    ), e.put("common/form/search/search.html",
        '<input ng-model="SearchController.query" class="form__input search__input" placeholder="{{ \'SEARCH_PLACEHOLDER\' | translate }}"> <button class="search__clear" ng-click="SearchController.query = \'\';"></button>'
    ), e.put("common/header/header-ad/header-ad.html",
        '<div ng-if="HeaderAdController.hasAd" class="header-ad"><habbo-ad-unit unit="leaderboard" class="header-ad__ad"></habbo-ad-unit></div>'
    ), e.put("common/header/hotel-button/hotel-button.html",
        '<a href="/hotel" class="hotel-button" id="ga-linkid-hotel"><span class="hotel-button__text" translate="NAVIGATION_HOTEL"></span></a>'
    ), e.put("common/header/navigation/navigation.html",
        '<nav class="navigation"><ul class="navigation__menu"><li class="navigation__item"><a href="/" ng-class="{ \'navigation__link--active\': NavigationController.active === \'home\' }" class="navigation__link navigation__link--home" translate="NAVIGATION_HOME" id="ga-linkid-home"></a></li><li class="navigation__item"><a href="/community" ng-class="{ \'navigation__link--active\': NavigationController.active === \'community\' }" class="navigation__link navigation__link--community" translate="NAVIGATION_COMMUNITY" id="ga-linkid-community"></a></li><li class="navigation__item"><a href="/shop" ng-class="{ \'navigation__link--active\': NavigationController.active === \'shop\' }" class="navigation__link navigation__link--shop" translate="NAVIGATION_SHOP" id="ga-linkid-shop"></a></li><li class="navigation__item"><a href="/playing-habbo" ng-class="{ \'navigation__link--active\': NavigationController.active === \'playingHabbo\' }" class="navigation__link navigation__link--playing-habbo" translate="NAVIGATION_PLAYING_HABBO" id="ga-linkid-playing-habbo"></a></li><li habbo-require-session class="navigation__item navigation__item--aside navigation__item--hotel"><habbo-hotel-button habbo-require-flash></habbo-hotel-button></li></ul></nav>'
    ), e.put("common/header/user-menu/user-menu.html",
        '<div ng-init="toggle = false;" habbo-false-on-outside-click="toggle" class="user-menu"><div class="user-menu__header"><a ng-click="toggle = !toggle;" class="user-menu__toggle"><div class="user-menu__name__wrapper"><div class="user-menu__name" ng-class="{ \'user-menu__name--open\': toggle }">{{:: UserMenuController.user.name}}</div></div><habbo-imager figure="{{:: UserMenuController.user.figureString}}" name="{{:: UserMenuController.user.name}}" size="bighead" class="user-menu__avatar"></habbo-imager></a></div><ul ng-hide="!toggle" class="user-menu__list ng-hide"><li class="user-menu__item"><a ng-href="/profile/{{:: UserMenuController.user.name | encodeURIComponent}}" ng-class="{ \'user-menu__link--active\': UserMenuController.isMyProfileActive() }" class="user-menu__link user-menu__link--profile" translate="NAVIGATION_PROFILE"></a></li><li class="user-menu__item"><a href="/settings" ng-class="{ \'user-menu__link--active\': UserMenuController.isSettingsActive() }" class="user-menu__link user-menu__link--settings" translate="NAVIGATION_SETTINGS"></a></li><li class="user-menu__item" habbo-require-staff-account-session><a href="/housekeeping" habbo-require-staff-account-session class="user-menu__link user-menu__link--housekeeping" translate="NAVIGATION_HOUSEKEEPING"></a></li><li class="user-menu__item"><a ng-click="UserMenuController.logout()" class="user-menu__link user-menu__link--logout" translate="NAVIGATION_LOGOUT"></a></li></ul></div>'
    ), e.put("home/messaging/discussions/discussions.html",
        '<ul ng-if="DiscussionsController.items.length > 0"><li ng-repeat="discussion in DiscussionsController.items" class="discussions__item"><div class="discussions__participant"><habbo-avatar user="{{:: DiscussionsController.getParticipant(discussion.participants).name}}" big="true"></habbo-avatar></div><div class="discussions__wrapper"><h6 ng-if="discussion.messages.length > 0" am-time-ago="discussion.latestTime" class="discussions__timeago"></h6><ul><li ng-repeat="message in discussion.messages | limitTo: 3" class="discussions__message"><p class="discussions__text">{{:: message.message}}</p><time class="discussions__date"><small>{{:: message.sendTime | date: \'medium\'}}</small></time></li></ul><a ng-href="/hotel?link=friendlist/openchat/{{discussion.discussionId}}" habbo-require-flash translate="DISCUSSIONS_REPLY" class="discussions__reply"></a></div></li></ul><habbo-empty-results ng-if="DiscussionsController.items.length === 0" translation-key="DISCUSSIONS_EMPTY"></habbo-empty-results>'
    ), e.put("home/news/moderation-notification/moderation-notification.html",
        '<habbo-message-container ng-if="ModerationNotificationController.moderations.length > 0" type="exclamation" class="moderation-notification static-content"><h3 translate="MODERATION_MESSAGE_TITLE"></h3><p translate="MODERATION_MESSAGE_TEXT" translate-values="{moderationCount: ModerationNotificationController.moderations.length}"></p><ul><li ng-repeat="moderation in ModerationNotificationController.moderations">{{:: moderation.createdAt | date: "fullDate" }}</li></ul><p translate="MODERATION_MESSAGE_INSTRUCTIONS"></p></habbo-message-container>'
    ), e.put("home/register-banner/local-register-banner/local-register-banner.html",
        '<small ng-if="LocalRegisterBannerController.site" class="local-register-banner">{{ \'LOCAL_REGISTER_BANNER_\' + LocalRegisterBannerController.site.localization | translate }} <a ng-href="{{LocalRegisterBannerController.site.href}}">{{LocalRegisterBannerController.site.title}}</a></small>'
    ), e.put("hotel/client/client-closed/client-closed.html",
        "<habbo-hotel-closed></habbo-hotel-closed>"), e.put(
        "hotel/client/client-error/client-error.html",
        '<div class="client-error"><h1 class="client-error__title" translate="CLIENT_ERROR_TITLE"></h1><p translate="CLIENT_ERROR_FLASH"></p><div class="client-error__downloads"><a ng-href="{{\'CLIENT_ERROR_FLASH_LINK\' | translate}}" target="_blank" rel="noopener noreferrer" class="client-error__flash"></a></div><p translate="CLIENT_ERROR_MOBILE"></p><div class="client-error__downloads"><a ng-href="{{:: ClientErrorController.appStoreUrl}}" target="_blank" rel="noopener noreferrer" class="client-error__appstore"></a> <a ng-href="{{:: ClientErrorController.googlePlayUrl}}" target="_blank" rel="noopener noreferrer" class="client-error__googleplay"></a></div></div>'
    ), e.put("hotel/client/client-reload/client-reload.html",
        '<h1 translate="RELOAD_TITLE"></h1><button ng-click="ClientReloadController.reload()" class="client-reload__button" translate="RELOAD_BUTTON"></button>'
    ), e.put("hotel/client/interstitial/interstitial.html",
        '<div ng-if="InterstitialController.started" ng-class="{ \'interstitial--visible\': InterstitialController.loaded }" class="interstitial"><div class="interstitial__stage"><iframe ng-src="{{InterstitialController.habboWebAdsUrl + \'interstitial.\' + InterstitialController.lang + \'.html\'}}" class="interstitial__ad"></iframe></div><p class="interstitial__text" translate="INTERS_DESCRIPTION"></p><p class="interstitial__text" translate="INTERS_INSTRUCTION"></p></div>'
    ), e.put("profile/creation/photo-delete/photo-delete.html",
        '<button type="button" ng-click="PhotoDeleteController.delete()" class="photo-delete">{{\'CREATION_DELETE\' | translate}}</button>'
    ), e.put("profile/creation/report/report-form.html",
        '<form ng-submit="ReportFormController.send()" name="reportForm" novalidate class="form"><p translate="REPORT_EXPLANATION"></p><img ng-src="{{:: ReportFormController.creation.url}}" class="report-form__creation"><fieldset class="form__fieldset form__fieldset--box"><p class="report-form__description" translate="REPORT_REMOVE_BECAUSE"></p><div ng-repeat="reason in ReportFormController.reasonCodes" class="form__field"><label class="form__label form__label--radiobutton"><input name="reportReason" ng-model="ReportFormController.creation.reportReason" ng-value="reason" required type="radio" class="form__radiobutton"> <span translate="REPORT_REASON_{{reason}}"></span></label></div></fieldset><div ng-if="reportForm.$invalid && reportForm.$submitted" ng-messages="reportForm.$error" class="form__popover form__popover--error"><div ng-message="required">{{\'ERROR_FIELD_REQUIRED\' | translate}}</div></div><p translate="REPORT_REPORT_FAIRLY"></p><div class="form__footer"><a ng-click="ReportFormController.onCancel()" class="form__cancel" translate="FORM_CANCEL_LABEL"></a> <button type="submit" class="form__submit report-form__submit" ng-disabled="ReportFormController.sendInProgress" translate="REPORT_SUBMIT"></button></div></form>'
    ), e.put("profile/creation/report/report-modal.html",
        '<button ng-click="$dismiss()" class="modal__close"></button><h4 class="modal__title" translate="REPORT_TITLE"></h4><div class="modal__content"><habbo-report-form creation="ReportController.creation" on-success="$close()" on-cancel="$dismiss()"></habbo-report-form></div>'
    ), e.put("profile/creation/report/report.html",
        '<a ng-click="ReportController.click()" class="report"><i class="report__icon icon icon--report"></i></a>'
    ), e.put("profile/item-lists/room-icon/room-icon.html",
        '<div class="room-icon"><img habbo-show-on-load habbo-remove-on-error ng-src="{{:: RoomIconController.url}}" class="room-icon__thumbnail"></div>'
    ), e.put("security/force/force-email/force-email-form.html",
        '<form ng-submit="ForceEmailFormController.save()" name="forceEmailChangeForm" autocomplete="off" novalidate class="form"><p translate="FORCED_EMAIL_CHANGE_TEXT"></p><h4 class="force-email__email">{{:: ForceEmailFormController.oldEmailAddress}}</h4><habbo-email-address email-address="ForceEmailFormController.emailAddress" type="box"><label for="email-address" class="form__label" translate="FORM_NEW_EMAIL_LABEL"></label></habbo-email-address><div class="form__footer"><a ng-click="ForceEmailFormController.onDismiss()" class="form__cancel" translate="FORM_CANCEL_LABEL"></a> <button ng-disabled="ForceEmailFormController.saveInProgress" type="submit" class="form__submit" translate="FORM_BUTTON_CHANGE"></button></div></form>'
    ), e.put("security/force/force-email/force-email-modal.html",
        '<button ng-click="$dismiss()" class="modal__close"></button><h3 translate="FORCED_EMAIL_CHANGE_TITLE" class="modal__title"></h3><div class="modal__content"><habbo-force-email-form old-email-address="{{:: ForceEmailController.oldEmailAddress}}" on-dismiss="$dismiss()" on-success="$close(email)"></habbo-force-email-form></div>'
    ), e.put("security/force/force-password/force-password-form.html",
        '<form ng-submit="ForcePasswordFormController.change()" name="forcePasswordChangeForm" autocomplete="off" novalidate class="form"><p translate="FORCED_PASSWORD_CHANGE_TEXT"></p><habbo-password-new is-new="true" password-new="ForcePasswordFormController.passwords.password" password-new-repeated="ForcePasswordFormController.passwords.passwordRepeated"></habbo-password-new><div class="form__footer"><a ng-click="ForcePasswordFormController.onDismiss()" class="form__cancel" translate="FORM_CANCEL_LABEL"></a> <button ng-disabled="ForcePasswordFormController.changeInProgress" type="submit" class="form__submit" translate="FORM_BUTTON_CHANGE"></button></div></form>'
    ), e.put("security/force/force-password/force-password-modal.html",
        '<button ng-click="$dismiss()" class="modal__close"></button><h3 translate="FORCED_PASSWORD_CHANGE_TITLE" class="modal__title"></h3><div class="modal__content"><habbo-force-password-form on-dismiss="$dismiss()" on-success="$close()"></habbo-force-password-form></div>'
    ), e.put("security/force/force-tos/force-tos-form.html",
        '<form ng-submit="ForceTosFormController.accept()" name="forceTOSAcceptForm" novalidate class="form"><p translate="NEW_USER_AGREEMENT_INFO_TEXT"></p><p translate="NEW_USER_AGREEMENT_GUIDE_TEXT"></p><div class="form__footer"><a ng-click="ForceTosFormController.onDismiss()" class="form__cancel" translate="FORM_CANCEL_LABEL"></a> <button ng-disabled="ForceTosFormController.acceptInProgress" type="submit" class="form__submit" translate="NEW_USER_AGREEMENT_BUTTON"></button></div></form>'
    ), e.put("security/force/force-tos/force-tos-modal.html",
        '<button ng-click="$dismiss()" class="modal__close"></button><h3 translate="NEW_USER_AGREEMENT_TITLE" class="modal__title"></h3><div class="modal__content"><habbo-force-tos-form on-dismiss="$dismiss()" on-success="$close()"></habbo-force-tos-form></div>'
    ), e.put("security/login/captcha-modal/captcha-modal.html",
        '<button ng-click="$dismiss()" class="modal__close"></button><h3 translate="CAPTCHA_TITLE" class="modal__title"></h3><div class="modal__content"><form novalidate><p translate="CAPTCHA_DESCRIPTION"></p><habbo-captcha captcha-token="captchaToken"></habbo-captcha></form></div>'
    ), e.put("security/login/claim-password/claim-password-form.html",
        '<form ng-submit="ClaimPasswordFormController.send()" name="claimPasswordForm" novalidate class="form"><div ng-hide="ClaimPasswordFormController.sent"><div ng-transclude></div><habbo-email-address email-address="ClaimPasswordFormController.emailAddress"><label for="email-address" class="form__label" translate="FORM_ACCOUNT_EMAIL_LABEL"></label></habbo-email-address><div class="form__footer"><a ng-click="ClaimPasswordFormController.cancel()" class="form__cancel" translate="FORM_CANCEL_LABEL"></a> <button ng-disabled="ClaimPasswordFormController.sendingInProgress" type="submit" class="form__submit" translate="FORM_BUTTON_SEND"></button></div></div><div ng-show="ClaimPasswordFormController.sent" class="ng-hide"><p translate="CLAIM_PASSWORD_SUCCESS"></p><h4 class="claim-password__email">{{ClaimPasswordFormController.emailAddress}}</h4><p><b translate="CLAIM_PASSWORD_SUCCESS_NOTE"></b></p></div></form>'
    ), e.put("security/login/claim-password/claim-password-modal.html",
        '<button ng-click="$dismiss()" class="modal__close"></button><h3 class="modal__title" translate="CLAIM_PASSWORD_TITLE"></h3><div class="modal__content"><habbo-claim-password-form cancel="$dismiss()"></habbo-claim-password-form></div>'
    ), e.put("security/login/claim-password/recover-password-modal.html",
        '<button ng-click="$dismiss()" class="modal__close"></button><h3 class="modal__title" translate="RECOVER_PASSWORD_TITLE"></h3><div class="modal__content"><habbo-claim-password-form email-address="RecoverPasswordController.email" cancel="$dismiss()"><div class="form__message form__message--error" translate="RECOVER_PASSWORD_ERROR"></div></habbo-claim-password-form></div>'
    ), e.put("security/login/facebook-connect/facebook-connect.html",
        '<button ng-click="FacebookConnectController.fbLogin()" ng-disabled="FacebookConnectController.loginInProgress" class="facebook-connect">{{ FacebookConnectController.translationKey | translate }}</button>'
    ), e.put("settings/account-security/safety-questions/safety-questions-form.html",
        '<form ng-submit="SafetyQuestionsFormController.save()" name="safetyQuestionsForm" novalidate class="form"><p translate="ACCOUNT_SECURITY_FORM_DESCRIPTION"></p><fieldset class="form__fieldset form__fieldset--box form__fieldset--box-top"><label for="safety-questions-question1" class="form__label" translate="ACCOUNT_SECURITY_QUESTION1_LABEL"></label><div class="form__field"><select id="safety-questions-question1" name="question1" ng-options="question.questionKey | translate for question in SafetyQuestionsFormController.questions | question: SafetyQuestionsFormController.selectedQuestion2" ng-model="SafetyQuestionsFormController.selectedQuestion1" class="form__select"></select></div><label for="safety-questions-answer1" class="form__label" translate="ACCOUNT_SECURITY_ANSWER1_LABEL"></label><div class="form__field"><input id="safety-questions-answer1" type="password" name="answer1" ng-model="SafetyQuestionsFormController.answer1" ng-model-options="{ updateOn: \'default blur\', debounce: { default: 500, blur: 0 } }" required maxlength="255" habbo-password-toggle-mask autocomplete="off" class="form__input"><div ng-if="safetyQuestionsForm.answer1.$invalid && (!safetyQuestionsForm.answer1.$pristine || safetyQuestionsForm.$submitted)" ng-messages="safetyQuestionsForm.answer1.$error" class="form__popover form__popover--error"><div ng-message="required">{{\'ERROR_FIELD_REQUIRED\' | translate}}</div></div></div></fieldset><fieldset class="form__fieldset form__fieldset--box form__fieldset--box-bottom"><label for="safety-questions-question2" class="form__label" translate="ACCOUNT_SECURITY_QUESTION2_LABEL"></label><div class="form__field"><select id="safety-questions-question2" name="question2" ng-options="question.questionKey | translate for question in SafetyQuestionsFormController.questions | question: SafetyQuestionsFormController.selectedQuestion1" ng-model="SafetyQuestionsFormController.selectedQuestion2" class="form__select"></select></div><label for="safety-questions-answer2" class="form__label" translate="ACCOUNT_SECURITY_ANSWER2_LABEL"></label><div class="form__field"><input id="safety-questions-answer2" type="password" name="answer2" ng-model="SafetyQuestionsFormController.answer2" ng-model-options="{ updateOn: \'default blur\', debounce: { default: 500, blur: 0 } }" required maxlength="255" habbo-password-toggle-mask autocomplete="off" class="form__input"><div ng-if="safetyQuestionsForm.answer2.$invalid && (!safetyQuestionsForm.answer2.$pristine || safetyQuestionsForm.$submitted)" ng-messages="safetyQuestionsForm.answer2.$error" class="form__popover form__popover--error"><div ng-message="required">{{\'ERROR_FIELD_REQUIRED\' | translate}}</div></div></div></fieldset><habbo-password-current password-current="SafetyQuestionsFormController.password"></habbo-password-current><div class="form__footer"><a ng-click="SafetyQuestionsFormController.onCancel()" class="form__cancel" translate="FORM_CANCEL_LABEL"></a> <button ng-disabled="SafetyQuestionsFormController.saveInProgress" type="submit" translate="FORM_BUTTON_SAVE" class="form__submit"></button></div></form>'
    ), e.put("settings/account-security/safety-questions/safety-questions-modal.html",
        '<button ng-click="$dismiss()" class="modal__close"></button><h3 translate="ACCOUNT_SECURITY_TITLE" class="modal__title"></h3><div class="modal__content"><habbo-safety-questions-form on-save="$close()" on-cancel="$dismiss()"></habbo-safety-questions-form></div>'
    ), e.put("settings/avatar-selection/avatar-create/avatar-create-form.html",
        '<form ng-submit="AvatarCreateFormController.create()" name="avatarCreateForm" novalidate class="form avatar-create-form"><fieldset class="form__fieldset"><label for="avatar-name" class="form__label" translate="AVATAR_CREATE_LABEL"></label><div class="form__field"><input id="avatar-name" name="name" ng-model="AvatarCreateFormController.name" ng-model-options="{ updateOn: \'default blur\', debounce: { default: 500, blur: 0 } }" required ng-minlength="3" ng-maxlength="15" ng-pattern="/^[a-zA-Z0-9_\\-\\=\\?\\!@\\:\\.,\\$]+$/" ng-trim="true" habbo-avatar-name-check autofocus class="form__input"><div ng-if="avatarCreateForm.name.$invalid && (!avatarCreateForm.name.$pristine || avatarCreateForm.$submitted)" ng-messages="avatarCreateForm.name.$error" class="form__popover form__popover--error"><div ng-message="required">{{\'ERROR_FIELD_REQUIRED\' | translate}}</div><div ng-message="minlength">{{\'ERROR_FIELD_MINLENGTH\' | translate: \'{ min: 3 }\'}}</div><div ng-message="maxlength">{{\'ERROR_FIELD_MAXLENGTH\' | translate: \'{ max: 15 }\'}}</div><div ng-message="pattern">{{\'ERROR_FIELD_NAME_FORMAT\' | translate}}</div><div ng-message="name">{{\'ERROR_FIELD_NAME_TAKEN\' | translate}}</div></div></div><small class="form__helper" translate="AVATAR_CREATE_HELP"></small></fieldset><div class="form__footer"><a ng-click="AvatarCreateFormController.onCancel()" class="form__cancel" translate="FORM_CANCEL_LABEL"></a> <button ng-disabled="AvatarCreateFormController.createInProgress" type="submit" translate="FORM_BUTTON_CREATE" class="form__submit"></button></div></form>'
    ), e.put("settings/avatar-selection/avatar-create/avatar-create-modal.html",
        '<button ng-click="$dismiss()" class="modal__close"></button><h3 translate="AVATAR_CREATE_TITLE" class="modal__title"></h3><div class="modal__content"><habbo-avatar-create-form on-create="$close()" on-cancel="$dismiss()"></habbo-avatar-create-form></div>'
    ), e.put("settings/avatar-selection/avatar-create/avatar-create.html",
        '<div habbo-require-non-staff-account-session class="avatar-create" ng-class="{ \'avatar-create--disabled\': avatars.length === MAX_AVATARS || (!emailVerified && !identityVerified) }"><div ng-if="avatars.length < MAX_AVATARS && identityVerified" class="avatar-create__text" translate="AVATAR_CREATE_MORE" translate-values="{ count: MAX_AVATARS - avatars.length }"></div><div ng-if="!emailVerified && !identityVerified" class="avatar-create__text" translate="AVATAR_CREATE_EMAIL_UNVERIFIED"></div><div ng-if="avatars.length === MAX_AVATARS" class="avatar-create__text" translate="AVATAR_CREATE_MAX"></div><div class="avatar-create__button__wrapper"><button ng-click="open()" ng-disabled="avatars.length === MAX_AVATARS || (!emailVerified && !identityVerified)" class="avatar-create__button" translate="AVATAR_CREATE_BUTTON"></button></div></div>'
    ),
    e.put("settings/avatar-selection/avatar-search/avatar-search.html",
        '<habbo-search query="query"></habbo-search><ul class="avatar-search__avatars"><habbo-avatar-selector ng-repeat="avatar in AvatarSearchController.avatars | byNameDescriptionOrMotto: query | orderBy: [\'-lastWebAccess\', \'name\']" avatar="avatar"></habbo-avatar-selector></ul><habbo-empty-results ng-if="(AvatarSearchController.avatars | byNameDescriptionOrMotto: query).length === 0"></habbo-empty-results>'
    ), e.put("settings/avatar-selection/avatar-search/avatar-selector.html",
        '<li ng-class="{ \'avatar-selector--selected\': AvatarSelectorController.isSelected }" class="avatar-selector"><habbo-imager figure="{{:: AvatarSelectorController.avatar.figureString}}" name="{{:: AvatarSelectorController.avatar.name}}" direction="s" action="stand" class="avatar-selector__avatar"></habbo-imager><div class="avatar-selector__content"><h4 class="avatar-selector__name">{{:: AvatarSelectorController.avatar.name}}</h4><p ng-if="AvatarSelectorController.avatar.motto" class="avatar-selector__details">{{:: AvatarSelectorController.avatar.motto}}</p><p class="avatar-selector__details avatar-selector__details--last-access">{{\'AVATAR_SELECTION_LAST_LOGIN\' | translate}} <time am-time-ago="AvatarSelectorController.avatar.lastWebAccess"></time></p><p ng-if="AvatarSelectorController.avatar.banned" class="avatar-selector__details--banned" translate="AVATAR_SELECTION_BANNED"></p></div><div ng-if="!AvatarSelectorController.isSelected && !AvatarSelectorController.avatar.banned" class="avatar-selector__select"><button habbo-require-non-staff-account-session ng-click="AvatarSelectorController.select()" ng-disabled="AvatarSelectorController.selectionInProgress" class="avatar-selector__button" translate="AVATAR_SELECTION_SELECT_BUTTON"></button></div></li>'
    ), e.put("settings/email-change/activation-status/activation-status.html",
        '<habbo-message-container ng-if="ActivationStatusController.user.emailVerified" type="check"><h3 translate="EMAIL_VERIFIED_TITLE" class="activation-status__title"></h3><p translate="EMAIL_VERIFIED_TEXT" translate-values="{{:: ActivationStatusController.user}}" class="activation-status__text"></p></habbo-message-container><habbo-message-container ng-if="!ActivationStatusController.user.emailVerified" type="exclamation"><h3 translate="ACTIVATION_RESEND_TITLE" class="activation-status__title"></h3><p translate="ACTIVATION_RESEND_TEXT" translate-values="{{:: ActivationStatusController.user}}" class="activation-status__text"></p><div class="activation-status__controls"><button ng-click="ActivationStatusController.resend()" ng-disabled="ActivationStatusController.resendInProgress || ActivationStatusController.isSent" class="activation-status__submit" translate="ACTIVATION_RESEND_BUTTON"></button></div></habbo-message-container>'
    ), e.put("shop/credit-card-form/credit-card-icon/credit-card-icon.html",
        '<span ng-if="VoucherIconController.product.icons[0]">&nbsp;<img ng-src="{{:: VoucherIconController.product.icons[0]}}" class="credit-card-icon__product"> {{:: CreditCardIconController.product.name}}</span> <span ng-if="VoucherIconController.credits">&nbsp;<i class="credit-card-icon__credits"></i> {{:: CreditCardIconController.credits}}</span>'
    ), e.put("shop/earn-credits/earn-credits-frame/earn-credits-frame.html",
        '<iframe ng-src="{{:: EarnCreditsFrameController.offerWallUrl }}" class="earn-credits-frame"></iframe>'
    ), e.put("shop/payment-details/credit-payment-details/credit-payment-details.html",
        '<habbo-credit-icon amount="{{:: CreditPaymentDetailsController.item.creditAmount}}" double-credits="{{:: CreditPaymentDetailsController.item.doubleCredits}}" class="payment-details__icon"></habbo-credit-icon><div class="payment-details"><header class="payment-details__header"><h3 class="payment-details__title"><habbo-credit-title amount="{{:: CreditPaymentDetailsController.item.creditAmount}}" double-credits="{{:: CreditPaymentDetailsController.item.doubleCredits}}"></habbo-credit-title></h3><div class="payment-details__price">{{:: CreditPaymentDetailsController.item.price }}</div></header><p ng-if="CreditPaymentDetailsController.item.doubleCredits" translate="SHOP_DOUBLE_CREDITS_DESCRIPTION" translate-values="{ value: CreditPaymentDetailsController.item.creditAmount }"></p><p ng-if="!CreditPaymentDetailsController.item.doubleCredits" translate="SHOP_CREDITS_DESCRIPTION" translate-values="{ value: CreditPaymentDetailsController.item.creditAmount }"></p><habbo-payment-steps item="CreditPaymentDetailsController.item" selected-category="{{CreditPaymentDetailsController.selectedCategory}}"><habbo-payment-info type="store"></habbo-payment-info></habbo-payment-steps></div>'
    ), e.put("shop/payment-details/offer-payment-details/offer-payment-details.html",
        '<img ng-src="{{:: OfferPaymentDetailsController.offerPaymentDetails.smallImageUrl}}" class="payment-details__icon"><div class="payment-details"><header class="payment-details__header"><h3 class="payment-details__title">{{:: OfferPaymentDetailsController.offerPaymentDetails.name }}</h3><span class="payment-details__price">{{:: OfferPaymentDetailsController.offerPaymentDetails.price }}</span></header><p>{{:: OfferPaymentDetailsController.offerPaymentDetails.description }}</p><img ng-src="{{:: OfferPaymentDetailsController.offerPaymentDetails.imageUrl}}" class="payment-details__image"><habbo-payment-steps item="OfferPaymentDetailsController.offerPaymentDetails"><habbo-payment-info type="store"></habbo-payment-info></habbo-payment-steps></div>'
    ), e.put("shop/payment-details/payment-info/payment-info-store.html",
        '<h3 class="payment-steps__title" translate="SHOP_PAYMENT_METHOD"></h3><p class="payment-steps__legal" translate="SHOP_PAYMENT_METHOD_INFO"></p>'
    ), e.put("shop/payment-details/payment-info/payment-info-subscription.html",
        '<h3 class="payment-steps__title" translate="SHOP_SUBSCRIPTION_METHOD"></h3><p class="payment-steps__legal" translate="SHOP_SUBSCRIPTION_METHOD_INFO"></p>'
    ), e.put("shop/payment-details/payment-steps/payment-steps.html",
        '<div ng-if="!PaymentStepsController.disclaimerMethod && !PaymentStepsController.premiumSmsMethod && !PaymentStepsController.adyenMethod" class="payment-steps"><div ng-if="PaymentStepsController.user" class="payment-steps__step"><h3 class="payment-steps__title" translate="SHOP_PAYMENT_DETAILS"></h3><table class="payment-steps__user"><tr><td translate="FORM_NAME_LABEL"></td><td>{{:: PaymentStepsController.user.name}}</td></tr><tr habbo-require-habbo-account-session><td translate="FORM_EMAIL_LABEL"></td><td>{{:: PaymentStepsController.user.email}}</td></tr></table></div><div ng-transclude class="payment-steps__step"></div><habbo-payment-methods item="PaymentStepsController.item" selected-category="{{PaymentStepsController.selectedCategory}}" class="payment-steps__step"></habbo-payment-methods></div><habbo-payment-disclaimer ng-if="PaymentStepsController.disclaimerMethod" item="PaymentStepsController.item" method="PaymentStepsController.disclaimerMethod"></habbo-payment-disclaimer><habbo-premium-sms ng-if="PaymentStepsController.premiumSmsMethod" method="PaymentStepsController.premiumSmsMethod"></habbo-premium-sms><habbo-adyen ng-if="PaymentStepsController.adyenMethod" item="PaymentStepsController.item" method="PaymentStepsController.adyenMethod"></habbo-adyen><div ng-if="PaymentStepsController.disclaimerMethod || PaymentStepsController.premiumSmsMethod || PaymentStepsController.adyenMethod" class="payment-steps__cancel"><a ng-click="PaymentStepsController.reset()" translate="SHOP_DISCLAIMER_CANCEL"></a></div>'
    ), e.put("shop/payment-details/product-payment-details/product-payment-details.html",
        '<habbo-product-icon icon-id="{{:: ProductPaymentDetailsController.item.iconId}}" class="payment-details__icon"></habbo-product-icon><div class="payment-details"><header class="payment-details__header"><h3 class="payment-details__title">{{:: ProductPaymentDetailsController.item.name}}</h3><div class="payment-details__price">{{:: ProductPaymentDetailsController.item.price}}</div></header><p>{{:: ProductPaymentDetailsController.item.description}}</p><habbo-sub-product-icons ng-if="ProductPaymentDetailsController.item.subProducts" sub-products="ProductPaymentDetailsController.item.subProducts"></habbo-sub-product-icons><habbo-payment-steps item="ProductPaymentDetailsController.item" selected-category="{{ProductPaymentDetailsController.selectedCategory}}"><habbo-payment-info type="store"></habbo-payment-info></habbo-payment-steps></div>'
    ), e.put(
        "shop/payment-details/subscription-payment-details/subscription-payment-details.html",
        '<habbo-product-icon icon-id="{{:: SubscriptionPaymentDetailsController.item.iconId}}" class="payment-details__icon"></habbo-product-icon><div class="payment-details"><header class="payment-details__header"><h3 class="payment-details__title">{{:: SubscriptionPaymentDetailsController.item.name}}</h3><div class="payment-details__price">{{:: SubscriptionPaymentDetailsController.item.price}}<small class="subscription__price-unit" translate="SHOP_SUBSCRIPTION_PER_MONTH"></small></div></header><p>{{:: SubscriptionPaymentDetailsController.item.description}}</p><habbo-payment-steps item="SubscriptionPaymentDetailsController.item" selected-category="{{SubscriptionPaymentDetailsController.selectedCategory}}"><habbo-payment-info type="subscription"></habbo-payment-info></habbo-payment-steps></div>'
    ), e.put("shop/store/category-filter/category-filter.html",
        '<ul class="category-filter"><li class="category-filter__item" ng-repeat="category in CategoryFilterController.paymentCategories"><a ng-click="CategoryFilterController.update(category.key)" translate="{{:: category.translateKey}}" ng-class="{ \'category-filter__link--active\': CategoryFilterController.isActive(category.key) }" class="category-filter__link"></a></li></ul>'
    ), e.put("shop/store/inventory/credits.html",
        '<section><h3 class="inventory__section__title" translate="SHOP_CREDITS_TITLE"></h3><habbo-accordion-grid class="inventory__grid"><habbo-accordion-item ng-repeat="item in CreditsController.items track by item.id"><habbo-accordion-item-preview><habbo-credit-thumbnail item="item"></habbo-credit-thumbnail></habbo-accordion-item-preview><habbo-accordion-item-content><habbo-credit-payment-details item="item" selected-category="{{CreditsController.selectedCategory}}"></habbo-credit-payment-details></habbo-accordion-item-content></habbo-accordion-item></habbo-accordion-grid></section>'
    ), e.put("shop/store/inventory/inventory.html",
        '<div ng-if="InventoryController.isDoubleCreditsActive"><habbo-credits ng-if="InventoryController.creditItems.length > 0" items="InventoryController.creditItems" selected-category="{{InventoryController.selectedCategory}}"></habbo-credits><habbo-products ng-if="InventoryController.productItems.length > 0" items="InventoryController.productItems" selected-category="{{InventoryController.selectedCategory}}"></habbo-products></div><div ng-if="!InventoryController.isDoubleCreditsActive"><habbo-products ng-if="InventoryController.productItems.length > 0" items="InventoryController.productItems" selected-category="{{InventoryController.selectedCategory}}"></habbo-products><habbo-credits ng-if="InventoryController.creditItems.length > 0" items="InventoryController.creditItems" selected-category="{{InventoryController.selectedCategory}}"></habbo-credits></div>'
    ), e.put("shop/store/inventory/products.html",
        '<section><h3 class="inventory__section__title" translate="SHOP_OFFERINGS_TITLE"></h3><habbo-accordion-grid class="inventory__grid"><habbo-accordion-item ng-repeat="item in ProductsController.items track by item.id"><habbo-accordion-item-preview><habbo-product-thumbnail item="item"></habbo-product-thumbnail></habbo-accordion-item-preview><habbo-accordion-item-content><habbo-product-payment-details item="item" selected-category="{{ProductsController.selectedCategory}}"></habbo-product-payment-details></habbo-accordion-item-content></habbo-accordion-item></habbo-accordion-grid></section>'
    ), e.put("shop/store/targeted-offer/targeted-offer.html",
        '<habbo-accordion-grid class="offer__grid"><habbo-accordion-item class="accordion__item--single"><habbo-accordion-item-preview><habbo-offer-thumbnail item="TargetedOfferController.offer" class="offer__item__thumbnail"></habbo-offer-thumbnail></habbo-accordion-item-preview><habbo-accordion-item-content><habbo-offer-payment-details offer-payment-details="TargetedOfferController.offerPaymentDetails"></habbo-offer-payment-details></habbo-accordion-item-content></habbo-accordion-item></habbo-accordion-grid>'
    ), e.put("shop/thumbnails/credit-thumbnail/credit-thumbnail.html",
        '<div class="inventory-thumbnail"><div class="inventory-thumbnail__body"><habbo-credit-icon amount="{{:: CreditThumbnailController.item.creditAmount}}" double-credits="{{:: CreditThumbnailController.item.doubleCredits}}" class="inventory-thumbnail__icon"></habbo-credit-icon><div class="inventory-thumbnail__text"><h3 class="inventory-thumbnail__title"><habbo-credit-title amount="{{:: CreditThumbnailController.item.creditAmount}}" double-credits="{{:: CreditThumbnailController.item.doubleCredits}}"></habbo-credit-title></h3></div><div class="inventory-thumbnail__banner"><span class="inventory-thumbnail__price">{{:: CreditThumbnailController.item.price}}</span></div></div></div>'
    ), e.put("shop/thumbnails/offer-thumbnail/offer-thumbnail.html",
        '<div class="inventory-thumbnail inventory-thumbnail--offer"><div class="inventory-thumbnail__body"><div class="inventory-thumbnail__highlight__banner"><span class="inventory-thumbnail__highlight-wrapper"><span ng-if="OfferThumbnailController.item.highlight" class="inventory-thumbnail__highlight">{{:: OfferThumbnailController.item.highlight}} |</span> <span translate="SHOP_TARGETED_OFFER_EXPIRY_TITLE"></span> <time am-time-ago="OfferThumbnailController.item.expirationDate"></time></span></div><img ng-src="{{:: OfferThumbnailController.item.imageUrl}}" class="inventory-thumbnail__icon inventory-thumbnail__icon--large"> <img ng-src="{{:: OfferThumbnailController.item.smallImageUrl}}" class="inventory-thumbnail__icon"><div class="inventory-thumbnail__text"><h3 class="inventory-thumbnail__title">{{:: OfferThumbnailController.item.header}}</h3><p class="inventory-thumbnail__description">{{:: OfferThumbnailController.item.description}}</p></div><div class="inventory-thumbnail__banner"><span class="inventory-thumbnail__price">{{:: OfferThumbnailController.item.pricePoint.price}}</span></div></div></div>'
    ), e.put("shop/thumbnails/product-thumbnail/product-thumbnail.html",
        '<div class="inventory-thumbnail"><div class="inventory-thumbnail__body"><habbo-product-icon icon-id="{{:: ProductThumbnailController.item.iconId}}" class="inventory-thumbnail__icon"></habbo-product-icon><div class="inventory-thumbnail__text"><h3 class="inventory-thumbnail__title">{{:: ProductThumbnailController.item.name}}</h3></div><div class="inventory-thumbnail__banner"><span class="inventory-thumbnail__price">{{:: ProductThumbnailController.item.price}}</span></div></div></div>'
    ), e.put("shop/thumbnails/subscription-thumbnail/subscription-thumbnail.html",
        '<div class="inventory-thumbnail"><div class="inventory-thumbnail__body"><habbo-product-icon icon-id="{{:: SubscriptionThumbnailController.item.iconId}}" class="inventory-thumbnail__icon"></habbo-product-icon><div class="inventory-thumbnail__text"><h3 class="inventory-thumbnail__title">{{:: SubscriptionThumbnailController.item.name}}</h3></div><div class="inventory-thumbnail__banner"><div class="inventory-thumbnail__price">{{:: SubscriptionThumbnailController.item.price}}<small class="subscription__price-unit" translate="SHOP_SUBSCRIPTION_PER_MONTH"></small></div></div></div></div>'
    ), e.put("shop/transactions/transactions-history/transactions-history.html",
        '<table class="transactions-history"><thead><tr><th translate="TRANSACTIONS_TABLE_DATE"></th><th translate="TRANSACTIONS_TABLE_PURCHASE"></th><th translate="TRANSACTIONS_TABLE_VALUE"></th></tr></thead><tbody><tr ng-repeat="item in TransactionsHistoryController.transactions | orderBy: \'-creationTime\' | limitTo: TransactionsHistoryController.limitTo track by $index"><td data-th="{{\'TRANSACTIONS_TABLE_DATE\' | translate}}">{{:: item.creationTime | amDateFormat: \'D MMM YYYY\'}}</td><td data-th="{{\'TRANSACTIONS_TABLE_PURCHASE\' | translate}}"><span ng-if="item.product" class="product-name">{{:: item.product.name}}</span> <span ng-if="item.credits > 0" class="credits" translate="CREDITS_AMOUNT" translate-values="{ value: item.credits }"></span></td><td data-th="{{\'TRANSACTIONS_TABLE_VALUE\' | translate}}">{{:: item.price}}</td></tr></tbody></table>'
    ), e.put("shop/voucher-redeem/voucher-icon/voucher-icon.html",
        '<span ng-if="VoucherIconController.product.icons[0]">&nbsp;<img ng-src="{{:: VoucherIconController.product.icons[0]}}" class="voucher-icon__product"> {{:: VoucherIconController.product.name}}</span> <span ng-if="VoucherIconController.credits">&nbsp;<i class="voucher-icon__credits"></i> {{:: VoucherIconController.credits}}</span>'
    ), e.put("common/form/password-new/password-strength/password-strength.html",
        '<div class="password-strength__label"><span>{{ \'PASSWORD_STRENGTH_LABEL\' | translate }}</span> <span>{{ PasswordStrengthController.score | strengthRating | ratingTranslation | translate }}</span></div><div class="password-strength__field"><div habbo-password-strength-indicator="PasswordStrengthController.score" ng-class="\'password-strength__indicator--\' + (PasswordStrengthController.score | strengthRating)" class="password-strength__indicator"></div></div><p ng-transclude class="password-strength__error"></p>'
    ), e.put("shop/payment-details/payment-steps/adyen/adyen.html",
        '<div ng-if="AdyenController.state === \'AWAITING_INPUT\'"><h3 translate="SHOP_PAYMENT_ADYEN_CARD_DETAILS" class="adyen__form-header"></h3><img ng-src="{{:: AdyenController.method.buttonLogoUrl}}" class="adyen__form-header-icon"><div class="adyen__form-wrapper"><habbo-credit-card-form class="adyen__form" card="AdyenController.card" on-submit="AdyenController.onSend(data)"></habbo-credit-card-form></div></div><habbo-message-container ng-if="AdyenController.state === \'SUCCESS\'" type="check" class="adyen__result-box"><h3 translate="SHOP_PAYMENT_COMPLETED" class="adyen__form-header"></h3><p translate="SHOP_PAYMENT_TRANSACTION_DETAILS" translate-values="{ transactionId: AdyenController.transactionId }"></p><button type="submit" translate="OK" class="payment-methods__button payment-button" ng-click="AdyenController.close()"></button></habbo-message-container><habbo-message-container ng-if="AdyenController.state === \'FAILURE\'" type="x" class="adyen__result-box"><h3 translate="SHOP_PAYMENT_FAILED" class="adyen__form-header"></h3><p ng-if="AdyenController.errorType === \'HTTP_ERROR\'">{{:: AdyenController.errorMsg}}</p><p ng-if="AdyenController.errorType === \'USER_DATA\'" translate="SHOP_PLEASE_CHECK_CREDIT_CARD"></p><p ng-if="AdyenController.errorType === \'LIMIT_EXCEEDED\'" translate="SHOP_LIMIT_EXCEEDED"></p><p ng-if="AdyenController.errorType === \'RISK_CHECK_FAILED\'" translate="SHOP_RISK_CHECK_FAILED"></p><button type="submit" translate="OK" class="payment-methods__button payment-button" ng-click="AdyenController.showInputForm()"></button></habbo-message-container>'
    ), e.put("shop/payment-details/payment-steps/payment-button/payment-button.html",
        '<button ng-click="PaymentButtonController.purchase()" ng-disabled="PaymentButtonController.paymentInProgress" class="payment-button" translate="{{:: PaymentButtonController.translationKey}}"></button>'
    ), e.put("shop/payment-details/payment-steps/payment-disclaimer/payment-disclaimer.html",
        '<h3 class="payment-steps__title payment-steps__title--single" translate="SHOP_SMALLPRINT_TITLE"></h3><small class="payment-steps__step payment-steps__legal" translate="{{:: PaymentDisclaimerController.methodSmallPrintKey}}"></small><ul class="payment-steps__step"><li class="payment-methods__method"><habbo-payment-button item="PaymentDisclaimerController.item" method="PaymentDisclaimerController.method" class="payment-methods__button"></habbo-payment-button></li></ul>'
    ), e.put("shop/payment-details/payment-steps/payment-methods/payment-methods.html",
        '<ul><li ng-repeat="paymentMethod in PaymentMethodsController.item.paymentMethods | paymentCategory: PaymentMethodsController.selectedCategory" class="payment-methods__method"><img ng-if="paymentMethod.buttonLogoUrl" ng-src="{{:: paymentMethod.buttonLogoUrl}}" class="payment-methods__icon"> <span ng-if="!paymentMethod.buttonLogoUrl && (paymentMethod.category === \'online\' || paymentMethod.category === \'prepaid\')" class="payment-methods__label">{{:: paymentMethod.name}}</span> <span ng-if="!paymentMethod.buttonLogoUrl && (paymentMethod.category === \'mobile\' || paymentMethod.category === \'landline\')" class="payment-methods__label" translate="{{:: PaymentMethodsController.PaymentStepsController.getMethodTitleKey(paymentMethod)}}"></span><habbo-payment-button ng-if="!paymentMethod.disclaimerRequired && !paymentMethod.premiumSms && paymentMethod.requestPath !== \'direct\'" item="PaymentMethodsController.item" method="paymentMethod" class="payment-methods__button"></habbo-payment-button><button ng-if="paymentMethod.disclaimerRequired && !paymentMethod.premiumSms && paymentMethod.requestPath !== \'direct\'" ng-click="PaymentMethodsController.PaymentStepsController.setDisclaimer(paymentMethod)" class="payment-methods__button payment-button" translate="SHOP_CONTINUE_BUTTON"></button> <button ng-if="paymentMethod.premiumSms" ng-click="PaymentMethodsController.PaymentStepsController.setPremiumSms(paymentMethod)" class="payment-methods__button payment-button" translate="SHOP_CONTINUE_BUTTON"></button> <button ng-if="paymentMethod.requestPath === \'direct\'" ng-click="PaymentMethodsController.PaymentStepsController.setAdyen(paymentMethod)" class="payment-methods__button payment-button" translate="SHOP_CONTINUE_BUTTON"></button></li></ul>'
    ), e.put("shop/payment-details/payment-steps/premium-sms/premium-sms.html",
        '<h3 translate="SHOP_PAYMENT_PSMS_INSTRUCTIONS"></h3><p translate="{{:: PremiumSmsController.methodInstructionKey}}"></p><div class="premium-sms__voucher-redeem__wrapper"><habbo-voucher-redeem class="premium-sms__voucher-redeem"></habbo-voucher-redeem></div><p translate="SHOP_PAYMENT_PSMS_HELP"></p><h3 translate="SHOP_SMALLPRINT_TITLE"></h3><small class="premium-sms__legal" translate="{{:: PremiumSmsController.methodSmallPrintKey}}"></small>'
    ), e.put(
        "shop/payment-details/product-payment-details/sub-product-icons/sub-product-icons.html",
        '<p class="sub-product-icons__description" translate="SHOP_PRODUCT_SUBPRODUCTS_DESCRIPTION"></p><ul><li ng-repeat="subProduct in SubProductIconsController.subProducts" class="sub-product-icons__icon" data-count="{{:: subProduct.count }}"><img ng-src="{{:: subProduct.imgUrl}}"></li></ul>'
    )
}]),angular.module("events", []).constant("EVENTS", {
    accordionOpen: "accordion-item-open",
    accordionClose: "accordion-item-close",
    accordionResize: "accordion-item-resize",
    accordionUpdate: "accordion-item-update",
    clientOpen: "client-open",
    clientClose: "client-close",
    securityLogin: "security-login",
    shopPaymentClose: "payment-close"
}),angular.module("app", ["ngAnimate", "activate", "community", "console.warning", "creation", "email.optout", "email.report.unauthorized", "eu.cookie.banner", "footer", "help.login", "home", "hotel", "logout", "not.found", "password.reset", "playing.habbo", "profile", "registration", "room", "security", "settings", "shop"]).config(["$provide", function (e) {
    e.decorator("$exceptionHandler", ["$delegate", function (e) {
        return function (t, o) {
            Bugsnag.notifyException(t, {diagnostics: {cause: o}}), e(t, o)
        }
    }])
}]).run(["spinner", function (e) {
    e.init()
}]),function () {
    var e = !0;
    window.Bugsnag || (window.Bugsnag = {
        notify: _.noop,
        notifyException: _.noop
    }), angular.module("app").config(["$sceDelegateProvider", function (e) {
        var t = e.resourceUrlWhitelist(),
            o = "https://*.habbo.com/**,https://habboo-a.akamaihd.net/**,https://www.offertoro.com/**".split(",");
        t = t.concat(o), e.resourceUrlWhitelist(t)
    }]).config(["$compileProvider", function (t) {
        t.debugInfoEnabled(!e)
    }]), angular.module("config", []).constant("CONFIG", {
        apiUrl: window.chocolatey.url + "api",
        extraDataUrl: window.chocolatey.url + "extradata",
        shopUrl: window.chocolatey.url + "shopapi",
        appStoreUrl: "https://itunes.apple.com/app/id794866182",
        badgeUrl: window.chocolatey.album,
        googlePlayUrl: "https://play.google.com/store/apps/details?id=air.com.sulake.habboair",
        habboWebAdsUrl: window.chocolatey.url + "habbo-web-ads/",
        habboWebLeaderboardsUrl: window.chocolatey.url + "habbo-web-leaderboards",
        habboWebNewsUrl: window.chocolatey.url + "habbo-web-news/en/production/",
        habboWebPagesUrl: window.chocolatey.url + "habbo-web-pages/production/",
        imagingUrl: "https://www.habbo.de/habbo-imaging",
        groupBadgeUrl: window.chocolatey.url + "habbo-imaging",
        lang: window.chocolatey.plang,
        hotel: "hhus",
        localizationSite: window.chocolatey.lang,
        minAge: parseInt("0", 10),
        rpxLocale: "en",
        rpxTokenUrl: window.chocolatey.url + "api/public/authentication/rpx",
        offerToroEnabled: false,
        twitterAccount: "@Habbo",
        adyenPublicKey: "10001|DB119F7832E23CBEDA2A330D3C13310D78ABA07136CDFFFA3D798BDFE4A903D5A079EE09710BBEC72573F0CA80D48DD0380D8AC1B0FDBCB978E69E9BE92ABDC27020858A52DC8D7A9C2D77B071FE1E6A3177E4E73E8E7CFC4A13C881BBBEF3C2EFBB24475818AB9E56BC597BABFD306593C3DF2B16F49D38F560212C183492EE7D0750CE84AB3509563CB3C99EC0B815CF5211E793500110B2A53DCAD793E267677BBE89035E5E9662FD2DB94A5EECBD6FB81F5DAF7205F9EBF15963639FC72DF0875CC2249FB31B300CC8183B2C948B3B3843C414677C9EC82C6A2D4CBF937B57FD03A53B0A8A56369AD490CEAB9EED18FE77E7B9032445A57A06CE23DE6115"
    }), angular.module("locale", ["angularMoment", "pascalprecht.translate"]), angular.module("angularMoment").run(["amMoment", function (e) {
        e.changeLocale("en")
    }]), angular.module("ezfb").config(["ezfbProvider", function (e) {
        e.setInitParams({appId: window.chocolatey.facebook}), e.setLocale("en_US")
    }]), angular.module("noCAPTCHA").config(["noCAPTCHAProvider", function (e) {
        e.setLanguage("en"), e.setSiteKey(window.chocolatey.captcha)
    }]), angular.module("pascalprecht.translate").config(["$translateProvider", function (e) {
        e.preferredLanguage(window.chocolatey.lang), e.useStaticFilesLoader({
            prefix: window.chocolatey.url + "habbo-web-l10n/",
            suffix: ".json"
        }), e.useSanitizeValueStrategy("escapeParameters")
    }])
}();
