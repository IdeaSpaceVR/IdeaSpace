<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <link rel="shortcut icon" type="image/png" href="{{ url('favicon.ico') }}"/>

    <meta name="abstract" content="" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="copyright" content="" />
    <meta name="robots" content="follow, index" />

    <meta property="og:site_name" content="" />
    <meta property="og:image:secure_url" content="" />
    <meta property="og:image" content="" />
    <meta property="og:description" content="" />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="" />

    <!-- Fonts -->
    <link href="{{ asset('public/font-awesome/css/font-awesome.min.css') }}" rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('public/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/layouts/app/css/app.css') }}">

    <?php 
    if (isset($css)) {
      foreach ($css as $c) { 
    ?>
    <link href="<?php echo $c; ?>" rel="stylesheet">
    <?php 
      }
    } 
    ?>
</head>
<body id="app-layout">
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}"><img alt="IdeaSpace" style="width:20px;display:inline" src="{{ asset('public/assets/layouts/app/images/isvr-logo-v2.png') }}"></a>
            </div>

        </div>
    </nav>

    @if (Auth::guest())
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
        
            @yield('content')

            </div>
        </div>
    </div>
    @endif

    <div class="footer clearfix" style="margin:50px 0 10px 0">
        <div class="text-center">
        Made with <span class="glyphicon glyphicon-heart" aria-hidden="true" style="color:red"></span> and <span class="glyphicon glyphicon-fire" aria-hidden="true" style="color:red"></span> 
        </div>
        <div class="pull-right" style="margin: 0 20px 0 0;font-size:12px">
        Version {{ env('VERSION') }} 
        </div>
    </div>

    <!-- jQuery first, then Bootstrap JS. -->
    <script src="{{ asset('public/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/assets/layouts/app/js/app.js') }}"></script>

    <?php 
    if (isset($js)) {
      foreach ($js as $j) { 
    ?>
    <script src="<?php echo $j; ?>" type="text/javascript"></script>
    <?php 
      }
    } 
    ?>

</body>
</html>
