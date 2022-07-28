
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel='icon' href='favicon.ico' type='image/x-icon'/ >
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>MinDA Document Tracking System</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('css/minda.css') }}" rel="stylesheet">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family='Calibri':300,400,600,700,300italic,400italic,600italic">


    <style type="text/css">
      @import url("//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc2/css/bootstrap-glyphicons.css");
    </style>

    <style>
      [type="checkbox"]
        {
            vertical-align:middle;
        }

        .content 
        {
          display:none;
        }
        .preload
        {
          width:100px;
          height: 100px;
          position: fixed;
          top: 40%;
          left: 40%;
        }
    </style>

</head>
  <div class="preload">
    <div class="content"><img src="{{ url('/images/lkhwpoas8809uosijckn093eu4wqoa34uoij32434.gif') }}" width="250"></div>
  </div>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">


  <main class="py-4">
      @yield('content')
  </main>

</div>
</body>
</html>
