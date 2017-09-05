<div class="clear"></div>

<footer>
    <div class="main">
        <div class="container">
            <div class="row">
                <div class="col-md-4 footer_column footer_column--newsletters text-center">
                    <h3 class="footer_title">{{ trans('footer.columns.one.title') }}</h3>
                    <form method="post" action="{{ url()->action('MailchimpEmailSignup@post') }}" class="m-t-20 m-b-10"
                          id="mailchimp_signup">
                        <div class="row">
                            <div class="col-sm-8">
                                <input type="email" name="email" id="input_newsletters_email"
                                       placeholder="{{ trans('footer.columns.one.input-placeholder') }}"
                                       class="input input--regular input--full input--plain"/>
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" class="button button--regular button--full button--green"
                                        style="padding-left: 0; padding-right: 0;">{{ trans('footer.columns.one.button-text') }}</button>
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    </form>
                </div>
                <div class="col-md-4 footer_column text-center">
                    <h3 class="footer_title">{{ trans('footer.columns.two.title') }}</h3>
                    @if(trans('footer.social.facebook') != '')
                        <a href="{{ trans('footer.social.facebook') }}" rel="nofollow" target="_blank"><span
                                    class="icon icon-facebook v-a-m m-r-10"></span></a>
                    @endif
                    @if(trans('footer.social.instagram') != '')
                        <a href="{{ trans('footer.social.instagram') }}" rel="nofollow" target="_blank"><span
                                    class="icon icon-instagram v-a-m m-l-10"></span></a>
                    @endif
                </div>
                <div class="col-md-4 footer_column text-center">
                    <h3 class="footer_title">{{ trans('footer.columns.three.title') }}</h3>
                    <p>{{ trans('footer.columns.three.text') }}</p>
                    <div class="m-b-10 m-t-10">
                        <p>
                            {!! trans('footer.columns.three.info') !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-4">
                    <span class="footer_bottom_copy">&copy; {{ date('Y') }} {{ trans('footer.copyright') }}.</span>

                    <div class="visible-sm m-t-10"></div>
                    @foreach(\App\Apricot\Helpers\PaymentMethods::getIconsForMethods(\App\Apricot\Helpers\PaymentMethods::getAcceptedMethodsForCountry(App::getLocale())) as $method)
                        <span class="icon icon-card-{{ $method }} m-r-5 v-a-m" title="{{ ucfirst($method) }}"></span>
                    @endforeach
                </div>
                <div class="col-lg-9 col-sm-8 text-right">
                    <ul class="footer_bottom_links">
                        <li class="input input--semibold input--transparent lang-selector-footer selector selector--up"
                            style="border: none !important;"><span
                                    class="icon v-a-m flag-{{ App::getLocale() }}"></span>
                            <span class="icon icon-arrow-up-small v-a-m m-l-5"></span>
                            <ul>
                                @foreach(config('app.locales') as $locale)
                                    <li>
                                        <a rel="alternate" hreflang="{{ $locale['code'] }}"
                                           href="{{ \App\Apricot\Helpers\DomainHelper::convertTldTo($locale['tld']) }}">
                                            <span class="icon flag-{{ $locale['code'] }}"></span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        {!! trans('footer.links') !!}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
        @if(Auth::user() && Auth::user()->isUser() && Config::get('app.debug') == 1)
            @include('includes.modal')
        @endif
        <!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
            try {
                w.yaCounter44444929 = new Ya.Metrika({
                    id: 44444929,
                    clickmap: true,
                    trackLinks: true,
                    accurateTrackBounce: true,
                    webvisor: true
                });
            } catch (e) {
            }
        });

        var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () {
                    n.parentNode.insertBefore(s, n);
                };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else {
            f();
        }
    })(document, window, "yandex_metrika_callbacks");
</script>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T6BSGJG"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<noscript>
    <div><img src="https://mc.yandex.ru/watch/44444929" style="position:absolute; left:-9999px;" alt=""/></div>
</noscript>
<!-- /Yandex.Metrika counter -->
<script>
    // this is important for IEs
    var polyfilter_scriptpath = '{{ asset('js/') }}';
</script>
<script src="{{ elixir('js/app.js') }}"></script>
<script src="{{ elixir('js/validator.js') }}"></script>
<!--[if lt IE 9]>
<script src="/js/placeholders.min.js"></script>
<![endif]-->
<script>


    $(function () {
        $('.kn_3').liKnopik();
        $('.kn_2').liKnopik({
            topPos: '50px',
            sidePos: 'left',
            startVisible: true
        });
        $('.kn_1').liKnopik({
            topPos: '300px',
            sidePos: 'right'
        });



    });
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
</script>

@yield('footer_scripts')
@if(Auth::user() && Auth::user()->isUser())
<script>
    $(function () {
        $('#twitters').on('keyup', function () {
            $newLength = 110 - $(this).val().length;
            if($(this).val().length > 110){
                $(this).val($(this).val().substring(0, (110)));
            } else{
                $('.twit-count').html($newLength);
            }


        });
        $('.sharedEmail').on('submit', function(e){
            e.preventDefault();

            $.ajax({
                type: 'POST',
                data: $('form.sharedEmail').serialize(),
                url: '{{ route("shared-email") }}',
                success: function (data) {
                    $('.tab-pane').removeClass('active');
                    $('.nav-tabs li').removeClass('active');
                    $('#thanks').addClass('active');

                }

            });


        });

            window.fbAsyncInit = function() {
            // init the FB JS SDK
            FB.init({
                appId: '{{ env('FACEBOOK_APP_ID') }}',
                xfbml: true,
                status     : true
            });

        };

            // Load the SDK asynchronously
            (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js";
            fjs.parentNode.insertBefore(js, fjs);
             }(document, 'script', 'facebook-jssdk'));

            function FBShareOp(){
            var description	   = $('#myFbMes').val() + '\r\n' +
                                 $('.fbMes').html();
            var share_url	   =	'{!! \App\Apricot\Helpers\ShareLink::get(Auth::user()->id) !!}';
            FB.ui({
            method: 'share',
            mobile_iframe: true,
            href: share_url,
            quote: description

        }, function(response) {
            if(response){
                $('.tab-pane').removeClass('active');
                $('.nav-tabs li').removeClass('active');
                $('#thanks').addClass('active');

            }
            else{}
        });

        }

        $(document).on('click', '.shareFb', function(){
            FBShareOp();

        });

        var popupSize = {
            width: 580,
            height: 360
        };

        $(document).on('click', '.shareTw', function(e){

            e.preventDefault();

            var
                    verticalPos = Math.floor(($(window).width() - popupSize.width) / 2),
                    horisontalPos = Math.floor(($(window).height() - popupSize.height) / 2);

            var url = "https://twitter.com/intent/tweet?text=" + $('#twitters').val() + "&url={{ \App\Apricot\Helpers\ShareLink::get(Auth::user()->id) }}";

            var popup = window.open(url, 'twitter',
                    'width='+popupSize.width+',height='+popupSize.height+
                    ',left='+verticalPos+',top='+horisontalPos+
                    ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

            if (popup) {
                popup.focus();
                e.preventDefault();

            }

            setTimeout(function() {
                $('.tab-pane').removeClass('active');
                $('.nav-tabs li').removeClass('active');
                $('#thanks').addClass('active');
            }, 2000);

        });


    });
</script>
@endif
@if(isset($errors))
    @if($errors->has())
        <script>
            swal({
                title: "{{ trans('message.error-title') }}",
                text: "{!! implode("<br/>", $errors->all()) !!}",
                type: "error",
                html: true,
                allowOutsideClick: true,
                confirmButtonText: "{{ trans('popup.button-close') }}",
                confirmButtonColor: "#3AAC87",
                timer: 6000
            });
        </script>
    @endif
@endif

@if(session('success'))
    <script>
        swal({
            title: "{{ trans('message.success-title') }}",
            text: "{{ session('success') }}",
            type: "success",
            html: true,
            allowOutsideClick: true,
            confirmButtonText: "{{ trans('popup.button-close') }}",
            confirmButtonColor: "#3AAC87",
            timer: 6000
        });
    </script>
@endif

@if(session('warning'))
    <script>
        swal({
            title: "{{ trans('message.warning-title') }}",
            text: "{{ session('warning') }}",
            type: "warning",
            html: true,
            allowOutsideClick: true,
            confirmButtonText: "{{ trans('popup.button-close') }}",
            confirmButtonColor: "#3AAC87",
            timer: 6000
        });
    </script>
@endif

@if( ! isset($_COOKIE['call-me-is-hidden'])  )

    <script>
        $("#call-me-form-hider").click(function () {
            $(".call-cta").slideUp();
            $("body").css('padding-bottom', 0);
//			Cookies.set('call-me-is-hidden', 1, {expires: 1});
        });

        $("#call-me-form-toggler").click(function () {
            $(".call-cta").toggleClass('call-cta--visible');
        });

        $("#call-me-form").submit(function (e) {
            e.preventDefault();

            var form = $(this);

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                dataType: 'JSON',
                data: form.serialize(),
                success: function (response) {
                    $(".call-cta").html('<strong>' + response.message + '</strong>');
                    setTimeout(function () {
                        $(".call-cta").slideUp();
                        $("body").css('padding-bottom', 0);
                        Cookies.set('call-me-is-hidden', 1, {expires: 3});
                    }, 2500);

                    fbq('track', 'Lead');
                }
            });
        });
    </script>
    @endif

            <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/{{ trans('general.tawk_id') }}/default';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->

    <script>

        $(window).scroll(function () {
            var hgt = $('.header-nav').height();
            var top = $(document).scrollTop();
            if (top > 2) $(".header-nav").css({position: 'fixed'});
            else $(".header-nav").css({position: 'relative'});
        });

        $("#mailchimp_signup").submit(function (e) {
            e.preventDefault();

            var $form = $(this);

            $.post($form.attr('action'), $form.serialize()).success(function (response) {
                swal({
                    title: "{{ trans('message.success-title') }}",
                    text: "{{ trans('mailchimp.thanks') }}",
                    type: "success",
                    html: true,
                    allowOutsideClick: true,
                    confirmButtonText: "{{ trans('popup.button-close') }}",
                    confirmButtonColor: "#3AAC87",
                    timer: 6000
                });
            }).error(function (response) {
                swal({
                    title: "{{ trans('message.error-title') }}",
                    text: response.responseJSON.errors,
                    type: "error",
                    html: true,
                    allowOutsideClick: true,
                    confirmButtonText: "{{ trans('popup.button-close') }}",
                    confirmButtonColor: "#3AAC87",
                    timer: 6000
                });
            });
        });
    </script>
    @if(App::environment() != 'local')
            
    @yield('tracking-scripts')
    @endif
    </body>
    </html>
