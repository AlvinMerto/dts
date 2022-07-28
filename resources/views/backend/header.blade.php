
<header class="main-header">
    <div class="logo">
      <span class="logo-lg"><b>Document Tracking</span>
    </div>
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item d-sm-inline-block">
        <a class="nav-link" data-widget="pushmenu" data-toggle="push-menu" href="#" role="button" style="float: left; "><i class="fa fa-bars" aria-hidden="true" style="font-size: 16px; color: #E6E6E6;"></i></a>
      </li>
    </ul>
  <nav class="navbar navbar-static-top">

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ url('public/dist/profile')}}/{{Auth::user()->profile_img }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->f_name }}</span>
              <!--<span class="hidden-xs" id="rop">sffsfsdfsdf</span>-->
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="{{ url('public/dist/profile')}}/{{Auth::user()->profile_img }}" class="img-circle" alt="User Image">

                <p>
                  {{ Auth::user()->email }}<br>{{Auth::user()->division}}
                </p>
              </li>

              <li class="user-footer">

                <div class="pull-left">
                  <a href="{{ url('/setting/my-account')}}/{{Auth::user()->id}}" class="btn btn-primary btn-flat">My Profile</a>
                </div>

                <div class="pull-right">
                  <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger btn-flat">Sign out</a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                </div>
              </li>
            </ul>
          </li>

          <li class="dropdown user user-menu">
            {{--<a href="{{ url('/setting-read-json') }}"><i class="fa fa-cogs" aria-hidden="true"></i></a>--}}
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs" aria-hidden="true"></i></a>
            <ul class="dropdown-menu">
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ url('/setting/my-account')}}/{{Auth::user()->id}}" class="btn btn-primary btn-flat">My Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ url('/admin')}}" class="btn btn-success btn-flat">Admin Control</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>

    </nav>
</nav>
<script type="text/javascript">

function warnAlert(msg,duration)
    {
     var el = document.createElement("div");
     el.setAttribute("style","position:fixed;top:60%;left:45%;margin: 0 auto;background-color:#FF0000; border: solid thin #DF0101; border-radius: 3px; padding-left: 25px; padding-right: 25px; padding-top: 12px; padding-bottom: 12px; color: #ffffff;box-shadow:2px 5px 5px #585858;-moz-box-shadow:2px 5px 5px #585858;-webkit-box-shadow:2px 5px 5px #585858; font-size: 16px;");
     el.innerHTML = msg;

     setTimeout(function(){
      el.parentNode.removeChild(el);
     },duration);
     document.body.appendChild(el);
     $(el).hide().fadeIn('slow');
    }
</script>
</header>