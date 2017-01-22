/* PLEASE DO NOT COPY AND PASTE THIS CODE. */
(function () {
    if (!window['___grecaptcha_cfg']) {
        window['___grecaptcha_cfg'] = {};
    }
    ;
    if (!window['___grecaptcha_cfg']['render']) {
        window['___grecaptcha_cfg']['render'] = 'explicit';
    }
    ;
    if (!window['___grecaptcha_cfg']['onload']) {
        window['___grecaptcha_cfg']['onload'] = 'recaptchaOnloadCallback';
    }
    ;
    window['__google_recaptcha_client'] = true;
    var po = document.createElement('script');
    po.type = 'text/javascript';
    po.async = true;
    po.src = '/public/web-img/js/recaptcha__nl.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(po, s);
})();