<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6" lang="ru_RU"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7" lang="ru_RU"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8" lang="ru_RU"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="js no-touch" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--<![endif]-->

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>@yield('title')</title>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="/js/html5shiv.js"></script>
      <script src="/js/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">
        window._wpemojiSettings = {
            baseUrl: "https:\/\/s.w.org\/images\/core\/emoji\/2.2.1\/72x72\/",
            ext: ".png",
            svgUrl: "https:\/\/s.w.org\/images\/core\/emoji\/2.2.1\/svg\/",
            svgExt: ".svg",
            source: {
                concatemoji: "http:\/\/gentsthemes.com\/demo\/stanleywp\/wp-includes\/js\/wp-emoji-release.min.js?ver=4.7.5"
            }
        };
        !(function(a, b, c) {
            function d(a) {
                var b, c, d, e, f = String.fromCharCode;
                if (!k || !k.fillText) return !1;
                switch (
                    (k.clearRect(0, 0, j.width, j.height),
                        (k.textBaseline = "top"),
                        (k.font = "600 32px Arial"),
                        a)
                ) {
                    case "flag":
                        return (
                            k.fillText(f(55356, 56826, 55356, 56819), 0, 0), !(j.toDataURL().length < 3e3) &&
                            (k.clearRect(0, 0, j.width, j.height),
                                k.fillText(f(55356, 57331, 65039, 8205, 55356, 57096), 0, 0),
                                (b = j.toDataURL()),
                                k.clearRect(0, 0, j.width, j.height),
                                k.fillText(f(55356, 57331, 55356, 57096), 0, 0),
                                (c = j.toDataURL()),
                                b !== c)
                        );
                    case "emoji4":
                        return (
                            k.fillText(
                                f(55357, 56425, 55356, 57341, 8205, 55357, 56507),
                                0,
                                0
                            ),
                            (d = j.toDataURL()),
                            k.clearRect(0, 0, j.width, j.height),
                            k.fillText(f(55357, 56425, 55356, 57341, 55357, 56507), 0, 0),
                            (e = j.toDataURL()),
                            d !== e
                        );
                }
                return !1;
            }

            function e(a) {
                var c = b.createElement("script");
                (c.src = a),
                (c.defer = c.type = "text/javascript"),
                b.getElementsByTagName("head")[0].appendChild(c);
            }
            var f, g, h, i, j = b.createElement("canvas"), k = j.getContext && j.getContext("2d");
            for (
                i = Array("flag", "emoji4"),
                c.supports = {
                    everything: !0,
                    everythingExceptFlag: !0
                },
                h = 0; h < i.length; h++
            )
                (c.supports[i[h]] = d(i[h])),
                (c.supports.everything = c.supports.everything && c.supports[i[h]]),
                "flag" !== i[h] &&
                (c.supports.everythingExceptFlag =
                    c.supports.everythingExceptFlag && c.supports[i[h]]);
            (c.supports.everythingExceptFlag =
                c.supports.everythingExceptFlag && !c.supports.flag),
            (c.DOeady = !1),
            (c.readyCallback = function() {
                c.DOeady = !0;
            }),
            c.supports.everything ||
                ((g = function() {
                        c.readyCallback();
                    }),
                    b.addEventListener ?
                    (b.addEventListener("DOMContentLoaded", g, !1),
                        a.addEventListener("load", g, !1)) :
                    (a.attachEvent("onload", g),
                        b.attachEvent("onreadystatechange", function() {
                            "complete" === b.readyState && c.readyCallback();
                        })),
                    (f = c.source || {}),
                    f.concatemoji ?
                    e(f.concatemoji) :
                    f.wpemoji && f.twemoji && (e(f.twemoji), e(f.wpemoji)));
        })(window, document, window._wpemojiSettings);
    </script>
    <script src="js/wp-emoji-release.js" type="text/javascript" defer="defer"></script>
    <style type="text/css">
        img.wp-smiley,
        img.emoji {
            display: inline !important;
            border: none !important;
            box-shadow: none !important;
            height: 1em !important;
            width: 1em !important;
            margin: 0 0.07em !important;
            vertical-align: -0.1em !important;
            background: none !important;
            padding: 0 !important;
        }
    </style>
    {{-- <link rel="stylesheet" id="bootstrap-css" href="{{ asset('stanleywp/css/bootstrap.css') }}" type="text/css" media="all" /> --}}
    <link rel="stylesheet" id="bootstrap-css" href="{{ asset('css/bootstrap.min.css') }}" type="text/css" media="all" />
    <link rel="stylesheet" id="wpbase-css" href="{{ asset('stanleywp/css/wpbase.css') }}" type="text/css" media="all" />
    <link rel="stylesheet" id="font-awesome-css" href="{{ asset('stanleywp/css/font-awesome') }}.css" type="text/css" media="all" />
    <link rel="stylesheet" id="magnific-css" href="{{ asset('stanleywp/css/magnific.css') }}" type="text/css" media="all" />
    <link rel="stylesheet" id="theme-style-css" href="{{ asset('stanleywp/css/style.css') }}" type="text/css" media="all" />
    <link rel="stylesheet" id="googleFonts-css" href="{{ asset('stanleywp/css/css.css') }}" type="text/css" media="all" />
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('stanleywp/js/jquery.js') }}"></script> --}}
    {{-- <script type="text/javascript" src="{{ asset('stanleywp/js/jquery-migrate.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('stanleywp/js/modernizr.js') }}"></script>
    <script type="text/javascript" src="{{ asset('stanleywp/js/magnific.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('stanleywp/js/bootstrap.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('stanleywp/js/hover.js') }}"></script>
    <script type="text/javascript" src="{{ asset('stanleywp/js/main.js') }}"></script>
    <script type="text/javascript">
        // <![CDATA[  jQuery(document).ready(function($){  	$("a[rel='magnific']").magnificPopup({  		type:'image'  	});  });    // ]]>
    </script>

    <style type="text/css">
        /*
 * contextMenu.js v 1.4.0
 * Author: Sudhanshu Yadav
 * s-yadav.github.com
 * Copyright (c) 2013 Sudhanshu Yadav.
 * Dual licensed under the MIT and GPL licenses
**/
        
        .iw-contextMenu {
            box-shadow: 0px 2px 3px rgba(0, 0, 0, 0.1) !important;
            border: 1px solid #c8c7cc !important;
            border-radius: 11px !important;
            display: none;
            z-index: 1000000132;
            max-width: 300px !important;
            width: auto !important;
        }
        
        .dark-mode .iw-contextMenu,
        .TnITTtw-dark-mode.iw-contextMenu,
        .TnITTtw-dark-mode .iw-contextMenu {
            border-color: #747473 !important;
        }
        
        .iw-cm-menu {
            background: #fff !important;
            color: #000 !important;
            margin: 0px !important;
            padding: 0px !important;
            overflow: visible !important;
        }
        
        .dark-mode .iw-cm-menu,
        .TnITTtw-dark-mode.iw-cm-menu,
        .TnITTtw-dark-mode .iw-cm-menu {
            background: #525251 !important;
            color: #fff !important;
        }
        
        .iw-curMenu {}
        
        .iw-cm-menu li {
            font-family: -apple-system, BlinkMacSystemFont, "Helvetica Neue", Helvetica, Arial, Ubuntu, sans-serif !important;
            list-style: none !important;
            padding: 10px !important;
            padding-right: 20px !important;
            border-bottom: 1px solid #c8c7cc !important;
            font-weight: 400 !important;
            cursor: pointer !important;
            position: relative !important;
            font-size: 14px !important;
            margin: 0 !important;
            line-height: inherit !important;
            border-radius: 0 !important;
            display: block !important;
        }
        
        .dark-mode .iw-cm-menu li,
        .TnITTtw-dark-mode .iw-cm-menu li {
            border-bottom-color: #747473 !important;
        }
        
        .iw-cm-menu li:first-child {
            border-top-left-radius: 11px !important;
            border-top-right-radius: 11px !important;
        }
        
        .iw-cm-menu li:last-child {
            border-bottom-left-radius: 11px !important;
            border-bottom-right-radius: 11px !important;
            border-bottom: none !important;
        }
        
        .iw-mOverlay {
            position: absolute !important;
            width: 100% !important;
            height: 100% !important;
            top: 0px !important;
            left: 0px !important;
            background: #fff !important;
            opacity: 0.5 !important;
        }
        
        .iw-contextMenu li.iw-mDisable {
            opacity: 0.3 !important;
            cursor: default !important;
        }
        
        .iw-mSelected {
            background-color: #f6f6f6 !important;
        }
        
        .dark-mode .iw-mSelected,
        .TnITTtw-dark-mode .iw-mSelected {
            background-color: #676766 !important;
        }
        
        .iw-cm-arrow-right {
            width: 0 !important;
            height: 0 !important;
            border-top: 5px solid transparent !important;
            border-bottom: 5px solid transparent !important;
            border-left: 5px solid #000 !important;
            position: absolute !important;
            right: 5px !important;
            top: 50% !important;
            margin-top: -5px !important;
        }
        
        .dark-mode .iw-cm-arrow-right,
        .TnITTtw-dark-mode .iw-cm-arrow-right {
            border-left-color: #fff !important;
        }
        
        .iw-mSelected>.iw-cm-arrow-right {}
        /*context menu css end */
    </style>
    <style type="text/css">
        @-webkit-keyframes load4 {
            0%,
            100% { box-shadow: 0 -3em 0 0.2em, 2em -2em 0 0em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 0 }
            12.5% { box-shadow: 0 -3em 0 0, 2em -2em 0 0.2em, 3em 0 0 0, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em }
            25% { box-shadow: 0 -3em 0 -0.5em, 2em -2em 0 0, 3em 0 0 0.2em, 2em 2em 0 0, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em }
            37.5% { box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 0, 2em 2em 0 0.2em, 0 3em 0 0em, -2em 2em 0 -1em, -3em 0em 0 -1em, -2em -2em 0 -1em }
            50% { box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 0em, 0 3em 0 0.2em, -2em 2em 0 0, -3em 0em 0 -1em, -2em -2em 0 -1em }
            62.5% { box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 0, -2em 2em 0 0.2em, -3em 0 0 0, -2em -2em 0 -1em }
            75% { box-shadow: 0em -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0.2em, -2em -2em 0 0 }
            87.5% { box-shadow: 0em -3em 0 0, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0, -2em -2em 0 0.2em }
        }
        
        @keyframes load4 {
            0%,
            100% { box-shadow: 0 -3em 0 0.2em, 2em -2em 0 0em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 0 }
            12.5% { box-shadow: 0 -3em 0 0, 2em -2em 0 0.2em, 3em 0 0 0, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em }
            25% { box-shadow: 0 -3em 0 -0.5em, 2em -2em 0 0, 3em 0 0 0.2em, 2em 2em 0 0, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em }
            37.5% { box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 0, 2em 2em 0 0.2em, 0 3em 0 0em, -2em 2em 0 -1em, -3em 0em 0 -1em, -2em -2em 0 -1em }
            50% { box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 0em, 0 3em 0 0.2em, -2em 2em 0 0, -3em 0em 0 -1em, -2em -2em 0 -1em }
            62.5% { box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 0, -2em 2em 0 0.2em, -3em 0 0 0, -2em -2em 0 -1em }
            75% { box-shadow: 0em -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0.2em, -2em -2em 0 0 }
            87.5% { box-shadow: 0em -3em 0 0, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0, -2em -2em 0 0.2em }
        }
    </style>
    <script src="https://kit.fontawesome.com/71b4759b3f.js"></script>
    @yield('head')
</head>

<body class="home page-template page-template-template-homepage page-template-template-homepage-php page page-id-5">
    <header>
        <nav role="navigation">
            <div class="navbar navbar-inverse navbar-static-top">
                <div class="container">
                    <!-- .navbar-toggle is used as the toggle for collapsed navbar content -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                            <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="/" title="ПромТранспортСервис" rel="homepage">
                            <img src="{{ asset('stanleywp/img/logo.png') }}" alt="ПромТранспортСервис">
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- end of header -->
    <div id="wrapper" class="clearfix">
        <div class="home-wrap clearfix py-5">
            @yield('content')
        </div>
        <!-- END home-wrap -->
    </div>
    <!-- end of wrapper-->

    <!-- +++++ Footer Section +++++ -->
    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div id="text-2" class="widget-wrapper widget_text">
                        <div class="footer-title">
                            <h4>О нас</h4>
                        </div>
                        <div class="textwidget">
                            <p>
                                <span style="display:block; margin-bottom: 15px">Транспортно-экспедиционная компания ООО "ПромТранспортСервис"</span>
                                <small>ИНН: 1646041540</small><br />
                                <small>АТИ: <a href="https://ati.su/firms/1642752/info">1642752</a></small>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div id="text-3" class="widget-wrapper widget_text">
                        <div class="footer-title">
                            <h4>Контакты</h4>
                        </div>
                        <div class="textwidget row">
                            <div class="col-xs-6 col-sm-3 col-lg-6" style="margin-bottom: 25px; color: #ccc">
                                Отдел продаж<br>
                                <a href="tel:+78003501398" class="small">8 (800) 350-13-98</a><br>
                                <a href="mailto:info@promtrans.pro" class="small">info@promtrans.pro</a><br>
                            </div>
                            <div class="col-xs-6 col-sm-3 col-lg-6" style="margin-bottom: 25px; color: #ccc">
                                Отдел логистики<br>
                                <a href="tel:+79600647706" class="small">+7 (960) 064-77-06</a><br>
                                <a href="mailto:logist@promtrans.pro" class="small">logist@promtrans.pro</a><br>
                            </div>
                            <div class="col-xs-6 col-sm-3 col-lg-6" style="margin-bottom: 25px; color: #ccc">
                                Финансовый отдел<br>
                                <a href="tel:+78555730049" class="small">+7 (85557) 3-00-49</a><br>
                                <a href="mailto:fin@promtrans.pro" class="small">fin@promtrans.pro</a><br>
                            </div>
                            <div class="col-xs-6 col-sm-3 col-lg-6" style="margin-bottom: 25px; color: #ccc">
                                Отдел кадров<br>
                                <a href="tel:+79172337638" class="small">+7 (917) 233-76-38</a><br>
                                <a href="mailto:hr@promtrans.pro" class="small">hr@promtrans.pro</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div id="text-4" class="widget-wrapper widget_text">
                        <div class="footer-title">
                            <h4>Наши партнёры</h4>
                        </div>
                        <div class="textwidget row" style="color: #ccc">
                            <div class="col-xs-6 col-sm-3 col-lg-6" style="margin-bottom: 25px">
                                <img src="{{ asset('stanleywp/img/alabuga-logo.svg') }}" alt="ОЭЗ &laquo;Алабуга&raquo;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </footer>
    <!-- end #footer -->

    <!-- Bitrix24 widget -->
    <script>
        (function(w, d, u) {
            var s = d.createElement('script');
            s.async = true;
            s.src = u + '?' + (Date.now() / 60000 | 0);
            var h = d.getElementsByTagName('script')[0];
            h.parentNode.insertBefore(s, h);
        })(window, document, 'https://cdn.bitrix24.ru/b10115193/crm/site_button/loader_2_k9wuc8.js');
    </script>
    <!-- End Bitrix24 widget -->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/comment-reply.js"></script>
    <script type="text/javascript" src="js/wp-embed.js"></script>
    @yield('scripts')
</body>

</html>