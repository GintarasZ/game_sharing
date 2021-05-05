<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome-free-5.15.2-web/css/all.css') }}">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm header_background">
            <div class="container">
                <a class="navbar-brand header_site_name" href="{{ url('/') }}"><img src="https://i.gyazo.com/e46229bcbd91a475a9a3343289b6e6a5.png" height="50px"></a>
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
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link header_button" href="{{ route('login') }}">{{ __('Prisijungti') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link header_button" href="{{ route('register') }}">{{ __('Registruotis') }}</a>
                                </li>
                            @endif
                        @else
                            <?php if (Auth::user()->id == 13) { ?>
                                <li class="nav-item post_ad_button">
                                    <a class="nav-link header_button" href="{{url('/uploadGamePage')}}">{{ __('Įkelti žaidimą') }}</a>
                                </li>
                            <?php } else { ?>
                            <li class="nav-item post_ad_button">
                                <a class="nav-link header_button" href="{{url('/howTo')}}">{{ __('Kaip naudotis sistema?') }}</a>
                            </li>
                            <li class="nav-item post_ad_button">
                                <a class="nav-link header_button" href="{{url('post-classified-ads')}}">{{ __('Įkelti skelbimą') }}</a>
                            </li>
                            <?php } ?>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle dropdown_text" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{url('/profile/'.Auth::user()->id)}}">
                                        {{ __('Profilis') }}
                                    </a>
                                    <?php if (Auth::user()->id == 13) { ?>
                                    <a class="dropdown-item" href="{{url('/myGames')}}">
                                        {{ __('Visi žaidimai') }}
                                    </a>
                                    <?php } else { ?>
                                    <a class="dropdown-item" href="{{url('/myAds/'.Auth::user()->id)}}">
                                        {{ __('Mano skelbimai') }}
                                    </a>
                                    <a class="dropdown-item" href="{{url('/feedback/'.Auth::user()->id)}}">
                                        {{ __('Mano atsiliepimai') }}
                                    </a>
                                    <?php } ?>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Atsijungti') }}
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

        <div class="header_second_level_background" id="second_level_header">
            <div class="container header_second_level_background">
                <div class="col-lg-12 search_bar">
                    <div class="row">
                        <div class="col-lg-4 search_name">
                            <form class="form-horizontal" method="post" action="{{url('/product/search')}}">
                                {{csrf_field()}}
                                <div class="form-group row mobile_search">
                                    <div class="col-8">
                                        <input type="text" name="searchproduct" required="true" class="form-control" placeholder="Įveskite pavadinimą" autocomplete="off">
                                    </div>
                                    <div class="col-4">
                                        <input type="submit" name="" class="btn btn-default" value="Ieškoti">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-8">
                            <form class="form-horizontal" method="post" action="{{url('/search/advertisements')}}">
                                {{csrf_field()}}
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <input type="text" name="cities" id="city" class="form-control" placeholder="Įveskite miestą" required="true" autocomplete="off">
                                    </div>
                                    <div id="cityList"></div>
                                    <div class="col-lg-4">
                                        <select class="form-control dropdown" name="categories" id="categories">
                                            <option>Select</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="submit" name="searchads" class="btn btn-default" value="Ieškoti">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>

<script type="text/javascript">
    $(document).ready(function () {
        $('#city').keyup(function () {
            var data;
            var cities = $(this).val();
            if (cities != '') {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('searchlocation.fetch') }}",
                    method: "POST",
                    data: {cities:cities, _token: _token},
                    success: function(data) {
                        $('#cityList').fadeIn();
                        $('#cityList').html(data);
                    }
                });
            } else {
                $('#cityList').fadeOut();
                $('#cityList').html(data);
            }
        });

        $(document).on('click', '#search', function () {
            $('#city').val($(this).text());
            $('#cityList').fadeOut();
        });

        $('#gameId').keyup(function () {
            var data;
            var games = $(this).val();
            if (games != '') {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('searchgame.fetchGame') }}",
                    method: "POST",
                    data: {games:games, _token: _token},
                    success: function(data) {
                        $('#gameList').fadeIn();
                        $('#gameList').html(data);
                    }
                });
            } else {
                $('#gameList').fadeOut();
                $('#gameList').html(data);
            }
        });

        $(document).on('click', '#search2', function () {
            $('#gameId').val($(this).text());
            $('#gameList').fadeOut();
        });

        $(document).ready(function () {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('categories.retrieve') }}",
                method: "POST",
                data: {_token: _token},
                success: function(data) {
                    $('#categories').fadeIn();
                    $('#categories').html(data);
                }
            });
        });

        $(document).ready(function () {
            if (window.location == "http://127.0.0.1/Project_01/public/") {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('categories.ads') }}",
                    method: "GET",
                    data: {_token: _token},
                    success: function(data) {
                        $('#Advertisements').html(data);
                    }
                });
            }
        });

        $(document).ready(function () {
            $('p img').on('click', function () {
                $('.productView_main').attr('src', $(this).attr('src'));
            });
        });
    });

    if(document.getElementsByClassName('register_page').length>0 || document.getElementsByClassName('login_page').length>0 ||
        document.getElementsByClassName('profile_page').length>0 || document.getElementsByClassName('reset_page').length>0) {

            document.getElementById("second_level_header").classList.add("no_display");
        }

    if(document.getElementsByClassName('productView_info').length>0) {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1;
        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        }
        if(mm<10){
            mm='0'+mm
        }

        today = yyyy+'-'+mm+'-'+dd;
        if(document.getElementsByClassName('forADayStart').length>0) {
            document.getElementById("forADayStart").setAttribute("min", today);
            document.getElementById("forThreeDaysStart").setAttribute("min", today);
            document.getElementById("forAWeekStart").setAttribute("min", today);
            document.getElementById("forAMonthStart").setAttribute("min", today);
        }
    }

    if(document.getElementsByClassName('collapsible').length>0) {
        var coll = document.getElementsByClassName("collapsible");
        var i;

        for (i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.maxHeight){
                    content.style.maxHeight = null;
                } else {
                    content.style.maxHeight = content.scrollHeight + "px";
                }
            });
        }
    }

</script>
