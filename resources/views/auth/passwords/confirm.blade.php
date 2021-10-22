<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Log In</title>

    <!-- Scripts -->
    <script src="{{ asset('site/js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('site/css/app.css') }}" rel="stylesheet">
</head>
<body>

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{asset('/') }}">
                 Not Now
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('password.rest.logout') }}">{{ __('Logout') }}</a>
                            </li>


                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">





<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Confirm Password') }}</div>

                <div class="card-body">
                    We Send Yuo Message SMS To verifid Code from 5 int

                        @csrf

                        <div class="form-group row">
                            <label for="code" class="col-md-4 col-form-label text-md-right">E_Code</label>

                            <div class="col-md-6">
                                <input id="code" type="text" class="form-control " name="code" >


                                    <span class="invalid-feedback" role="alert"  style="display: block;">
                                        <strong id="message"></strong>
                                    </span>

                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary" onclick="checkCode ()">
                                 Confirm Code
                                </button>


                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
</main>
</div>

<script>
    function checkCode ()
    {
          var code = document.getElementById('code').value;

        if (code.length == 5 && Number(code))
        {
            document.getElementById('message').innerHTML ='';
            var xml = new XMLHttpRequest ();
            xml.open('get' , 'http://localhost/shop7/public/password/rest/check-code?code=' +code);
            xml.send();
            xml.onreadystatechange = function ()
            {
                if(xml.readyState === 4 && xml.status == 200)
                {
                    var status = JSON.parse(xml.responseText).status;
                    console.log(status);
                    if (status == 'success')
                    {
                        window.location.replace('http://localhost/shop7/public/password/change-show');

                    }
                    else
                    {
                        document.getElementById('message').innerHTML = "هذا الكود غير صالح";

                     }
                }
            }
        }
        else
         {
            document.getElementById('message').innerHTML = "الكود غير صحيح";
          }

    }


</script>


</body>
</html>
