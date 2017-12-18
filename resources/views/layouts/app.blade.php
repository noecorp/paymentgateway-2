<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('HAsh', 'HAsh') }}</title>

    <!-- Styles -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
   
<!--          <link href="{{ asset('css/home.css') }}" rel="stylesheet">
 -->   
    
        <link href="{{ asset('css/theme1.css') }}" rel="stylesheet">
   
    
<body>
</head>
<body>
    <div id="app" >
        <nav class="navbar navbar-default navbar-static-top" style="position:fixed;min-width: 100%;">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a  class="navbar-brand" href="{{ url('/') }}">
                        {{ config('HAsh', 'HAsh') }}
                    
                    </a>
                    <div id="credentialbutton" class="credentialbutton btn btn-default btn-sm" style="margin-top:10px; box-shadow: 0px 2px 5px #888888; width:80px" >Credentials</div>

                </div>


                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->

                    <ul class="nav navbar-nav">
                        &nbsp;

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="credentialform">
                <form>
    <div class="form-group">
    <label for="pwd">Bussiness Name</label>
    <input type="text" class="form-control" id="Bname" placeholder="bussiness licence">
  </div>

  <div class="form-group">
    <label for="tin">Bussinesss Tax No</label>
    <input type="text" class="form-control" id="tin" placeholder="bussiness tax payer's no.">
  </div>
  <div class="form-group">
    <label for="pwd">Bussiness Licence</label>
    <input type="text" class="form-control" id="licence" placeholder="bussiness licence">
  </div>
    <button type="submit" class="btn btn-default">Register</button>
</form>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    @yield('script')
    <script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#credentialbutton").on("click",function(event){
                if($(".credentialform").css("display")=="none")
                $(".credentialform").css("display","block");
                else
                 $(".credentialform").css("display","none");   
            });
        });
    </script>
</body>
</html>
