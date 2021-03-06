<nav class="c-nav-header">
    <ul class="c-nav-header__list">
        <li class="c-nav-header__item item-left">
            <a href="/pick-n-mix" class="c-nav-header__link">{{ trans('nav2.pick') }}</a>
        </li>
        <li class="c-nav-header__item item-left dropdown">
            <a href="#" class="c-nav-header__link navbar-toggle" data-toggle="dropdown">{{ trans('nav2.gifting') }}</a><span class="caret"></span>
            <ul class="dropdown-menu2">
                <li>
                    <a href="/gifting" class="c-nav-header__link">{{ trans('nav2.buy-gift') }}</a>
                    <a href="/use-giftcard" class="c-nav-header__link">{{ trans('nav2.reedem-gift') }}</a>
                </li>
            </ul>
        </li>
        <li class="c-nav-header__item">
            <a href="/how-it-works" class="c-nav-header__link">{{ trans('nav2.how-it-works') }}</a>
        </li>
        <li class="c-nav-header__item">
            <a href="/page/a-zink" class="c-nav-header__link">{{ trans('nav2.vitamins') }}</a>
        </li>
        @if(App::getLocale() == 'da')
            <li class="c-nav-header__item">
                <a href="https://takedaily.dk/blog" class="c-nav-header__link">Blog</a>
            </li>
        @endif
        <li class="c-nav-header__item c-nav-header__item--log">
            @if(Auth::user() && Auth::user()->isAdmin())
                <a href="/dashboard" class="c-nav-header__link">Dashboard </a>
            @elseif(Auth::user() && Auth::user()->isUser())
                <a href="/account" class="c-nav-header__link">{{ trans('nav2.my-takedaily') }}</a>
            @else
                <a href="/account" class="c-nav-header__link">{{ trans('nav2.account') }}</a>
            @endif
        </li>
    </ul>
</nav>