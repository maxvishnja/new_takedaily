<footer class="b-footer">
    <div class="l">
        <div class="b-footer__top">
            <!-- Lang -->
            <span class="b-footer__lang">
                <div class="b-footer__lang__flag flag-{{App::getLocale()}}"></div>
                <span class="b-footer__lang__arrow"></span>
                <span class="b-footer__lang__dropdown hidden">
                    @foreach(config('app.locales') as $locale)
                        @if(App::getLocale() != $locale['code'])
                            <a rel="alternate" hreflang="{{ $locale['code'] }}"
                               href="{{ \App\Apricot\Helpers\DomainHelper::convertTldTo($locale['tld']) }}">
                                <span class="b-footer__lang__flag flag-{{ $locale['code'] }}"></span>
                            </a>
                        @endif
                    @endforeach
                </span>
            </span>
            <!-- Footer Navigation -->
            <nav class="c-nav-footer">
                <ul class="c-nav-footer__list">
                    <li class="c-nav-footer__item">
                        <a href="/flow" class="c-nav-footer__link">{{ trans('footer2.links.vitamins') }}</a>
                    </li>
                    <li class="c-nav-footer__item">
                        <a href="/about-us" class="c-nav-footer__link">{{ trans('footer2.links.about') }}</a>
                    </li>
                    <li class="c-nav-footer__item">
                        <a href="/faq" class="c-nav-footer__link">{{ trans('footer2.links.faq') }}</a>
                    </li>
                    <li class="c-nav-footer__item">
                        <a href="/page/terms" class="c-nav-footer__link">{{ trans('footer2.links.conditions') }}</a>
                    </li>
                </ul>
            </nav>
            <!-- Copy && Payment -->
            <div class="b-footer__top__right">
                <div class="b-footer__payment">
                    <span class="b-footer__payment__card icon-card-mastercard"></span>
                    <span class="b-footer__payment__card icon-card-visa"></span>
                    <span class="b-footer__payment__card icon-card-dk"></span>
                </div>
                <p class="b-footer__copy">{{ trans('footer2.copyright') }}</p>
            </div>
        </div>
        <div class="b-footer__bottom">
            <div class="b-footer__col">
                <div class="b-footer__info">
                    <h4 class="b-footer__info__title">{{ trans('footer2.column1.contact') }}</h4>
                    <p class="b-footer__info__txt">{{ trans('footer2.column1.call') }}</p>
                    <p class="b-footer__info__txt">
                        {{ trans('footer2.column1.phone') }}
                        <br>
                        {{ trans('footer2.column1.email') }}
                    </p>
                </div>
            </div>
            <div class="b-footer__col">
                <div class="b-footer__info">
                    <h4 class="b-footer__info__title">{{ trans('footer2.column2.general') }}</h4>
                    <p class="b-footer__info__txt">{{ trans('footer2.column2.company') }}</p>
                    <p class="b-footer__info__txt">
                        {!! trans('footer2.column2.address') !!}
                    </p>
                    <p class="b-footer__info__txt">
                        @if(App::getLocale() == 'nl')
                            {{ trans('footer2.column2.kvknumm') }}
                            <br>
                            {{ trans('footer2.column2.btwnumm') }}
                        @else
                            {{ trans('footer2.column2.email') }}
                            <br>
                            {{ trans('footer2.column2.phone') }}
                        @endif
                    </p>
                </div>
            </div>
            <div class="b-footer__col">
                <div class="b-footer__info">
                    <h4 class="b-footer__info__title">{{ trans('footer2.column3.subscribe') }}</h4>
                    <div class="c-newsletter">
                        <form action="https://client3.mailmailmail.net/form.php?form=656" method="post"
                              id="frmSS656"
                              onsubmit="return CheckForm656(this);">
                            <input type="email" name="email" id="input_newsletters_email" placeholder="{{ trans('footer2.column3.email_placeholder') }}">
                            {{ csrf_field() }}
                            <button type="submit" class="hp-btn">{{ trans('footer2.column3.subscribe_btn') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="b-footer__col b-footer__col--socials">
                <div class="b-footer__info">
                    <h4 class="b-footer__info__title">{{ trans('footer2.column4.follow') }}</h4>
                    <div class="b-footer__social">
                        <div class="b-footer__social__item"><a href="{{ trans('footer2.column4.instagram') }}"><img src="/images/home/insta.png" alt=""></a></div>
                        <div class="b-footer__social__item"><a href="{{ trans('footer2.column4.facebook') }}"><img src="/images/home/fb.png" alt=""></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

{{--@if(Auth::user() && Auth::user()->isUser() && Config::get('app.debug') == 1)--}}
    {{--@include('includes.modal')--}}
{{--@endif--}}

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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
</script>

<script>
    $(document).ready(function () {
        $('.b-footer__lang').mouseenter(function () {
            console.log('works')
            $('.b-footer__lang__dropdown').removeClass('hidden');
        })
        $('.b-footer__lang__dropdown').mouseleave(function () {
            $('.b-footer__lang__dropdown').addClass('hidden');
        })
    })
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
                var txt = $('#twitters').val();
                var url = "https://twitter.com/intent/tweet?text=" + txt.replace(/#/g,'') + "&url={{ \App\Apricot\Helpers\ShareLink::get(Auth::user()->id) }}";

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
{{--<script type="text/javascript">--}}
    {{--var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();--}}
    {{--(function () {--}}
        {{--var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];--}}
        {{--s1.async = true;--}}
        {{--s1.src = 'https://embed.tawk.to/{{ trans('general.tawk_id') }}/default';--}}
        {{--s1.charset = 'UTF-8';--}}
        {{--s1.setAttribute('crossorigin', '*');--}}
        {{--s0.parentNode.insertBefore(s1, s0);--}}
    {{--})();--}}
{{--</script>--}}
<!--End of Tawk.to Script-->

<script>

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