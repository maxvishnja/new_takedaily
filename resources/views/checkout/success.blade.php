@extends('layouts.app')

@section('pageClass', 'page-checkout-success')

@section('mainClasses', 'm-b-50 m-t-50')
@section('title', trans('checkout.success.page-title'))

@section('content')
    <div class="container">

        {{--@if(session('upsell', false) && Session::has('upsell_token'))--}}
        <div class="text-center">
            @if( isset($code) )
            <h2>{{ trans('success.upsell') }}</h2>
            <h2>{{ trans('success.upsell_code') }} {{ $code }}</h2>
            @endif
            {{--<div class="button  button--rounded button--medium coupon-button">{{ $code }}--}}
                {{--<span class="share-icon"><img src="{{ asset('/images/icons/icon-share.png') }}" height="24"--}}
                                              {{--alt=""></span>--}}
                {{--<div class="social-icons">--}}
                    {{--<img class="share-fb" data-url="{{ App::getLocale() != 'nl' ? 'https://takedaily.dk/' : 'https://takedaily.nl/'  }}" onclick="fbShare()" src="{{ asset('/images/icons/icon-fb.png') }}" height="24" alt="">--}}
                    {{--<button  id="copy-button" aria-label = "{{ $code }}"  data-clipboard-action="copy">--}}
                        {{--<img class="share-copy" src="{{ asset('/images/icons/icon-copy.png') }}" height="24" alt="">--}}
                    {{--</button>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<form method="post" action="{{ URL::route('flow-upsell') }}">--}}
            {{--<button type="submit" class="button button--green button--medium button--rounded">{{ trans('success.upsell-btn') }}</button>--}}

            {{--<input type="hidden" name="upsell_token" value="{{ Session::get('upsell_token') }}"/>--}}
            {{--{{ csrf_field() }}--}}
            {{--</form>--}}
        </div>

        <hr/>
        {{--@endif--}}

        @if( isset($vitamins) )
            <div class="print_label print_label--shadow hidden-xs">
                <div class="print_label_left">

                    @foreach($vitamins as $vitamin)
                        <div class="print_label_line">
                            <div class="print_label_line_full">
                                {{ \App\Apricot\Helpers\PillName::get(strtolower($vitamin->code)) }}
                            </div>
                        </div>
                    @endforeach

                    <div class="text-center">
                        <span class="logo logo-color m-t-50"></span>
                    </div>
                </div>
                <div class="print_label_right text-right">
                    <div class="print_label_info_line"><strong>{{ Auth::user()->getName() }}</strong></div>
                    <div class="print_label_info_line">{{ Auth::user()->getCustomer()->getCustomerAttribute('address_line1') }},{{ Auth::user()->getCustomer()->getCustomerAttribute('address_number') }}</div>
                    <div class="print_label_info_line">{{ Auth::user()->getCustomer()->getCustomerAttribute('address_postal') }}
                        , {{ Auth::user()->getCustomer()->getCustomerAttribute('address_city') }}</div>
                    <div class="print_label_info_line">{{ trans('countries.' . Auth::user()->getCustomer()->getCustomerAttribute('address_country')) }}</div>


                    <div class="m-t-50">
                        @foreach($vitamins as $vitamin)
                            <div style="display: inline-block;" class="m-t-15 icon pill-{{ $vitamin->code }}"></div>
                        @endforeach
                    </div>
                </div>

                <div class="clear"></div>
            </div>

            <div class="text-center">
                <h1>{{ trans('checkout.success.title') }}</h1>
                <p>{{ trans('checkout.success.text') }}</p>

                <a href="/account"
                   class="button button--green button--rounded button--medium">{{ trans('checkout.success.button-text') }}</a>
            </div>
        @endif

        @if(isset($giftcardToken))
            <div class="text-center">
                <h3>{{ trans('checkout.success.giftcard.title') }}</h3>
                <h1>{{ $giftcardToken }}</h1>
                <p>{{ trans('checkout.success.giftcard.text') }}</p>
            </div>
        @endif
    </div>

@endsection
@section('footer_scripts')
        <!-- Adform Tracking Code BEGIN -->
    <script type="text/javascript">
        window._adftrack = Array.isArray(window._adftrack) ? window._adftrack : (window._adftrack ? [window._adftrack] : []);
        window._adftrack.push({
            pm: 788995,
            divider: encodeURIComponent('|'),
            pagename: encodeURIComponent('Take Daily conversion')
        });
        (function () { var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = 'https://track.adform.net/serving/scripts/trackpoint/async/'; var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x); })();

    </script>
        @if(!isset($giftcardToken))
    <noscript>
        <p style="margin:0;padding:0;border:0;">
            <img src="https://track.adform.net/Serving/TrackPoint/?pm=788995&ADFPageName=Take%20Daily%20conversion&ADFdivider=|" width="1" height="1" alt="" />
        </p>
    </noscript>
    <!-- Adform Tracking Code END -->
    @if(App::getLocale() == 'nl')
        <img src="http://oa1.nl/m/5824/19fa5023ff43b6545d455e24a6a475f880acd6a1/?transactie_id={{$user_email}}"
             style="width: 1px; height: 1px; border: 0px;">
    @endif

    @if(App::getLocale() != 'nl')
        <script src="https://online.adservicemedia.dk/cgi-bin/API/ConversionService/js?camp_id=6123&order_id={{$order_id}}"
                type="text/javascript"></script>
        <noscript>
            <img src="https://online.adservicemedia.dk/cgi-bin/API/ConversionService/p?camp_id=6123" width="1" height="1"
                 border="0">
        </noscript>
        <img src="https://online.digital-advisor.com/aff_l?offer_id=1903" width="1" height="1" />
     @endif
    @endif
    <script>
        $('.share-icon').on('click', function () {
            $('.social-icons').toggle(500);
        });
        new Clipboard('#copy-button',{
            text: function (trigger) {
                return document.getElementById('copy-button').getAttribute('aria-label');
            }
        });


        function fbShare() {
            var shareText = encodeURIComponent($('#copy-button').attr('aria-label'));
            var shareUrl = encodeURIComponent($('.share-fb').data('url'));
            var winWidth = 520;
            var winHeight = 350;
            var winTop = (screen.height / 2) - (winHeight / 2);
            var winLeft = (screen.width / 2) - (winWidth / 2);
            window.open('https://www.facebook.com/dialog/share?%20app_id={{ env('FACEBOOK_APP_ID') }}&&href='+shareUrl+'flow&display=iframe&quote='+shareText+'', 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight)
        }

        dataLayer.push({

            'event': 'orderComplete',

            'orderId': '{{$order_id}}'

            });

        @if(\Cookie::get('utm_source')!=null)

                dataLayer.push({
                    'event': 'p_source',
                    'source': '{!! \Cookie::get('utm_source') !!}',    //source from cookie first_source
                    'medium': '{!! \Cookie::get('utm_medium') !!}',      //medium from cookie first_source
                    'campaign': '{!! \Cookie::get('utm_campaign') !!}'   //campaign from cookie first_source
                    });

                dataLayer.push({
                    "event": "purchase",
                    "ecommerce": {
                        "purchase": {
                            "actionField": {
                                "id": "{{$order_id}}", //transaction ID
                                "affiliation": "Online Store",     //affiliate store
                                "revenue": '{{ Auth::user()->getCustomer()->getPlan()->getTotal()/100 }}',                       //revenue
                                "tax": '{{ Auth::user()->getCustomer()->getPlan()->getPrice()/100 }}',                                //tax
                                "shipping": '{{ Auth::user()->getCustomer()->getPlan()->getShippingPrice()/100 }}',                         //shipping
                                "coupon": '{{ Auth::user()->getCustomer()->getPlan()->getLastCoupon() }}'         // If user added a coupon code at checkout.
                            },
                            "products": [{
                                "id": "subscription",                   //ID product
                                "name": "subscription",   //product name
                                "price": "{{ Auth::user()->getCustomer()->getPlan()->getTotal()/100 }}",              //price
                                "category": "Pills",        //category
                                "variant": "full",              //variant
                                "quantity": 1                  //quantity, example: 2
                            }]
                        }
                    }
                });

        @endif











    </script>
@endsection

@section('tracking-scripts')
    <script>
        fbq('track', 'Purchase', {
            value: '{{ session('order_price', '0.00') }}',
            currency: '{{ session('order_currency', 'EUR') }}'
        });

        @if(Auth::check())
            fbq('track', 'CompleteRegistration');
        @endif
    </script>

    <noscript>

        <img src="//dk.cpdelivery.com/sad/m/takedaily_track_2017_01/track.php" width="1" height="1" border="0" alt=""/>

    </noscript>


@endsection