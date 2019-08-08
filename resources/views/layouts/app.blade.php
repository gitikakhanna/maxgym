<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- Bootstrap 4 --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    {{-- font and icons --}}
    {{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
    
    <link rel="stylesheet" type="text/css" href="{{asset('css/skeleton.css')}}?v={{filemtime('css/skeleton.css')}}">
</head>
<body>
    @yield('modal')
    @guest
        <div id="app">
            <nav class="navbar bg-light">
                <div class="container-fluid">
                    <div class="row w-100 d-flex align-items-center justify-content-center">
                        <div class="col-3">
                            <a href="#" class="">Max Gym</a>
                        </div>
                        <div class="col-9 text-right">
                            <a href="{{route('login')}}" class="mr-3">Login</a>
                            <a href="{{route('register')}}" class="">Register</a>
                        </div>
                    </div>
                </div>
            </nav>
            @yield('content')
        </div>
    @else
        <div id="hub-page-wrapper"> 
            @if(session()->has('flashSuccess'))
                <div class="execution-message success">
                    <p class="lead">Perfect!</p>
                    <hr>
                    <div class="message">
                        {{session('flashSuccess')}}
                    </div>
                </div>
            @elseif($errors->any())
                <div class="execution-message danger">
                    <p class="lead">Something went wrong :(</p>
                    <hr>
                    <div class="message">
                        {{session('flashFailure')}}
                    </div>
                </div>
            @endif
        </div>
        <div class="page-wrapper chiller-theme toggled">
            <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
                <i class="fas fa-bars"></i>
            </a>
            <nav id = "sidebar" class="sidebar-wrapper">
                <div class="sidebar-content">
                    <div class="sidebar-brand">
                        <a href="#">Max Gym</a>
                        <div id="close-sidebar">
                            <i class="fas fa-times"></i>
                        </div>
                    </div>
                    <div class="sidebar-header">
                        <div class="user-info align-items-center">
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            <span class="user-role">Administrator</span>
                            <span class="user-status">
                                <i class="fa fa-circle"></i>
                                <span>Online</span>
                            </span>
                        </div>
                    </div>

                    <div class="sidebar-menu">
                        <ul>
                            <li class="header-menu">
                                <span>General</span>
                            </li>
                            <li class="sidebar-dropdown">
                                <a href="/home"><i class="fas fa-home"></i>Dashboard</a>   
                            </li>
                            <li class="sidebar-dropdown">
                                <a href="/add-member"><i class="fas fa-user-plus"></i>Membership</a>   
                            </li>
                            <li class="sidebar-dropdown">
                                <a href="/member-profile/view"><i class="fas fa-user"></i>Member Profile</a>   
                            </li>
                            <li class="sidebar-dropdown">
                                <a href="/packages"><i class="fas fa-file"></i>Packages</a>
                            </li>
                            <li class="sidebar-dropdown">
                                <a href="/trainer"><i class="fas fa-user"></i>Manage Trainer</a>
                            </li>
                             <li class="sidebar-dropdown">
                                <a href="/attendance"><i class="fas fa-file"></i>Attendance</a>
                            </li>
                            <li class="header-menu"> 
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fa fa-power-off"></i>Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>        
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="sidebar-footer">
                    <a href="#">
                        <i class="fa fa-bell">
                        </i>
                        <span class="badge badge-pill badge-warning notification">3</span>
                    </a>
                    <a href="#">
                        <i class="fa fa-power-off"></i>
                    </a>
                </div>
            </nav>
            <main class="page-content">
                @yield('content')
            </main>
        </div>
    @endguest
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/skeleton.js') }}"></script>
    {{-- jQuery --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    {{-- Bootstrap and Popper JS --}}
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.execution-message').delay(5000).fadeOut(750);
        });
    </script>
    @yield('js')
    @yield('extra-js')
</body>
</html>
