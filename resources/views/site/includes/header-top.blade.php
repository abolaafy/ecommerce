

  <div class="header-top hidden-sm-down">
    <div class="container">
      <div class="content">
        <div class="row">
          <div class="header-top-left col-lg-6 col-md-6 d-flex justify-content-start align-items-center">
            <div class="detail-email d-flex align-items-center justify-content-center">
              <i class="icon-email"></i>
              <p>Email :  </p>
                              <span>
                  abolaafy@gmail.com
                </span>
                          </div>
            <div class="detail-call d-flex align-items-center justify-content-center">
              <i class="icon-deal"></i>
              <p>Today Deals </p>
            </div>
          </div>



          <div class="col-lg-6 col-md-6 d-flex justify-content-end align-items-center header-top-right">
                        <div class="register-out">
              <i class="zmdi zmdi-account"></i>
              @guest
              <a class="register" href="{{route('register')}}" data-link-action="display-register-form">
                Register
              </a>
              <span class="or-text">or</span>
              <a class="login" href="http://localhost/shop7/public/login" rel="nofollow" title="تسجيل الدخول إلى حسابك">Sign in</a>
              @endguest


            @auth('site')

            <a href="{{ route('user.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>

            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: block;">
                {{ csrf_field() }}
            </form>
            @endauth
        </div>
                        <div id="_desktop_currency_selector" class="currency-selector groups-selector hidden-sm-down currentcy-selector-dropdown">
  <div class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="main">
      <span class="expand-more">GBP</span>
  </div>
  <div class="currency-list dropdown-menu">
    <div class="currency-list-content text-left">
                  <div class="currency-item current flex-first">
            <a title="جنيه إسترليني" rel="nofollow" href="http://demo.bestprestashoptheme.com/savemart/ar/home-appliance/4-the-adventure-begins-framed-poster.html?SubmitCurrency=1&amp;id_currency=1">UK£ GBP</a>
          </div>
                  <div class="currency-item">
            <a title="دولار أمريكي" rel="nofollow" href="http://demo.bestprestashoptheme.com/savemart/ar/home-appliance/4-the-adventure-begins-framed-poster.html?SubmitCurrency=1&amp;id_currency=2">US$ USD</a>
          </div>
            </div>
  </div>
</div>




<div id="_desktop_language_selector" class="language-selector groups-selector hidden-sm-down language-selector-dropdown">
  <div class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="main">
                                                                                                <span class="expand-more">{{LaravelLocalization::getCurrentLocaleNative()  }}<img class="img-fluid" src="/savemart/img/l/6.jpg" alt="" width="16" height="11"/></span>
                </div>
  <div class="languavge-list dropdown-menu">
    <div class="language-list-content text-left">

    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    <div class="language-item">
    <div>
            <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
            <img class="img-fluid" src="/savemart/img/l/1.jpg" alt="" width="16" height="11"/>
                <span> {{ $properties['native'] }}</span> </a>
</div>
</div>


    @endforeach
</div>

            </div>
  </div>
</div>

          </div>
        </div>
      </div>
    </div>
  </div>

