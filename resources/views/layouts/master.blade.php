
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel='icon' href='favicon.ico' type='image/x-icon'/ >
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>MinDA Document Tracking System</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('css/minda.css') }}" rel="stylesheet">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css')}}">

    <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css')}}">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <style type="text/css">
      @import url("//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc2/css/bootstrap-glyphicons.css");
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <link href="{{ asset('css/lightbox.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="{{ asset('js/lightbox.js') }}" defer></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="{{ asset('css/docsupport/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('css/docsupport/chosen.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('css/docsupport/init.js') }}" type="text/javascript" charset="utf-8"></script>

    <style type="text/css">

       body
       {
          font-family: 'Calibri';
          font-size: 12px !important;
          font-weight: normal !important;
       }

       table {
        border: none !important;
        width: 100% !important;
        border-collapse: collapse;
        table-layout: fixed;
       }

       td, tr
       {
        font-weight: normal;
        padding: 5px;
        border: none;
        font-size: 12px !important;
       }

       tr.border_bottom td {
        border-bottom: 1px solid #BDBDBD;
        padding: 10px;
      }


      th, td {
        //text-align: left;
        padding: 8px;
      }

      tr:nth-child(even) {background-color: #f2f2f2;}

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

      .rem-tooltip + .tooltip > .tooltip-inner {
        background-color: #F6F8E1;
        color: #000;
        text-align: left;
        word-spacing: 3px;
        align-self: left;
        max-width: 80%;
        border: solid #000 1px;

      }
      .rem-tooltip + .tooltip > .tooltip-arrow { 
        border-bottom-color:#000; 
      }
      
    </style>

    <script>
 
      $(document).ready(function(){
          $('a').tooltip();
      });

    
    </script>

</head>
  <div class="preload">
    <div class="content"><img src="{{ url('/images/dsgdfgs456tvw45466w45656esry5y4.gif') }}" width="250"></div>
  </div>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  @include('backend.header')
    
  @include('backend.sidebar')

  <main class="py-4">
      @yield('content')
  </main>

@include('backend.footer')
</div>

<script src="{{ asset('bower_components/jquery/dist/jquery.min.js')}}"></script>

<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

</body>
</html>
