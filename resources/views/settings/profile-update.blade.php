@extends('layouts.master')

@section('content')

<script src="{{ asset('js/dropzone/dropzone.js') }}" defer></script>
<link rel="stylesheet" href="{{ asset('css/dropzone/dropzone.css')}}">

<script>
        $(document).ready(function() {
            var msg = '{{Session::get('alert')}}';
            var exist = '{{Session::has('alert')}}';
            if(exist){
                setTimeout(function () { alert(msg); }, 100);
            }
        });
     </script>


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<script>
$(document).ready(function(e){
        $(function() {
        $(".preload").fadeOut(100, function() {
            $(".content").fadeIn(100);        
        });
    });

});
</script>

<style type="text/css">
.img-grid {
    position: relative;
    width: 205;
    margin: 0 auto;
}
  
.img-grid ul {
    display: block;
    list-style: none;
    padding: 0;
    margin: 0;
}

.img-grid ul > li {
    display: block;
    float: left;
    list-style: none;
    border: solid 1px #3b5998;
    padding: 10px;
    margin: 10px;
    margin-bottom: 50px;
}


.img-grid ul > li:nth-child(4n+4) {
    clear: right;
}

.img-grid li img {
    display: block;
    width: 100%;
    min-width: 100%;
    border: 0;
}
</style>

<input type="hidden" name="type_input" id="type_input" value="outgoing">
<div class="content-wrapper ml-2" style="width: auto;">
    <div class="row justify-content-center" style="width: 100%">
        <div class="col-md-8">
            <div class="card mt-3">
                <div class="card-header bg-primary" style="font-size: 16px; font-weight: bold; color: #fff;">{{Auth::user()->f_name}}'s Profile</div>
                    <div class="card-body" style="display: flex; justify-content: center;">

                        <section style="width: 100%">

                            <!--content-->
                            @if($data->count()>0)
                            @foreach($data as $d)
                            <table>
                                <tr>
                                    <td colspan="2" align="left"><img src="{{ url('public/dist/profile')}}/{{Auth::user()->profile_img }}" class="user-image" alt="User Image" height="200" width="auto"><br><span class="btn-save-profile btn btn-success btn-flat mt-2">Save Profile</span> <span class="btn-profile btn btn-default btn-flat mt-2">Upload Profile Picture</span></td>
                                </tr>
                                <tr>
                                    <td>Username</td>
                                    <td><input type="text" name="uname" id="uname" value="{{$d->name}}"></td>
                                </tr>
                                <tr>
                                    <td>Name</td>
                                    <td><input type="text" name="fname" id="fname" value="{{$d->f_name}}"></td>
                                </tr>
                                <tr>
                                    <td>Password</td>
                                    <td><span class="btn-password btn btn-success btn-flat">Change password</span></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><input type="text" name="email" id="email" value="{{$d->email}}"> <span id='result'></span></td>
                                </tr>
                                <tr>
                                    <td>Designation</td>
                                    <td>{{$d->position}}</td>
                                </tr>
                                <tr>
                                    <td>Division</td>
                                    <td>{{$d->division}}</td>
                                </tr>
                            </table>
                            @endforeach
                            @endif

                            <h2 id='result'></h2>
                            <!--Content End-->
                        </section>
                    </div>

                
            </div>
        </div>
    </div>
</div>

<!-- Popup Modal -->

<div class="modal fade" id="user-profile" tabindex="-1" role="dialog"aria-labelledby="ff-modal-label" aria-hidden="true" style="text-align: center;">
  <div class="modal-dialog  modal-lg" style="min-width: auto; max-width: 50%"  role="document">
    <div class="modal-content">
      <div class="modal-header"><span style="font-size: 24px; color: #FF4000; text-align: center;"><strong>{{Auth::user()->f_name}}</strong></span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();"><span aria-hidden="true">&times;</span>
        </button>
      </div>
        <span id="form_result"></span>
            <form method="POST" action="{{ url('/settings/my-account/upload-image')}}/{{$d->id}}" accept-charset="utf-8" enctype="multipart/form-data">
            @csrf
                <span style="margin-top: 0;">Click the box to choose file<br>or Drag your file into the box</span>
                    <div class="fallback" style="left: 50%;margin-left: 36%;">
                        <input class="dropzone" type="file" name="img_file" id="img_file" style="width: 200px; background: #E6E6E6;" accept="image/x-png,image/gif,image/jpeg,image/bmp,image/jpg,application/pdf" onchange="PreviewImage();">
                    </div><br>

                    <button type="submit" id="upload" name="upload" class="btn btn-medium btn-primary"><span class="fa fa-upload"></span> Upload</button><br><br>

                    <div id="image-holder" class="photo-container" style="float: right; display: none;">
                        <object data="" width="200" height="auto" id="image" class="photo-info ml-5 mt-1" style="height: 20%; border: 1px solid #08298A; margin: 5px;box-shadow:2px 5px 5px #585858;-moz-box-shadow:2px 5px 5px #585858;-webkit-box-shadow:2px 5px 5px #585858;"><br>            
                        </object>

                    </div>
                    
                <div id="err"></div>

            <input type="hidden" name="_id" id="_id" value="{{Auth::user()->id}}">
            </form>

 
        <div class="modal-footer">

      </div>
    </div>
  </div>
</div>

<!-- Popup Modal Password-->

<div class="modal fade" id="user-password" tabindex="-1" role="dialog"aria-labelledby="ff-modal-label" aria-hidden="true" style="text-align: center;">
  <div class="modal-dialog  modal-lg" style="min-width: auto; max-width: 50%"  role="document">
    <div class="modal-content">
      <div class="modal-header"><span style="font-size: 24px; color: #FF4000; text-align: center;"><strong>{{Auth::user()->f_name}}</strong></span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();"><span aria-hidden="true">&times;</span>
        </button>
      </div>
        <span id="form_result"></span>
            <table>
                <tr>
                    <td width="180" align="right">Enter your New Password</td>
                    <td><input type="Password" name="new_pass" id="new_pass" class="form-control" style="width: 160px;"></td>
                </tr>
                <tr>
                    <td width="180" align="right">Confirm Password</td>
                    <td><input type="Password" name="confirm_pass" id="confirm_pass" class="form-control" style="width: 160px;"></td>
                </tr>
                <tr>
                    <td width="180" colspan="2" align="left"><button type="submit" name="change_pass" id="change_pass" class="update_password btn btn-primary" style="margin-left: 220px;"><span class="fa fa-floppy-o" aria-hidden="true"></span> Update Password</button></td>
                </tr>
                <span id="p1" style="display: none;text-align: center; color: #FF0000;">Password should be 5 characters or more</span>
                <span id="p2" style="display: none;text-align: center; color: #FF0000;">Password did not match</span>
            </table>

 
        <div class="modal-footer">

      </div>
    </div>
  </div>
</div>

<script src="{{ asset('js/moment.min.js') }}"></script>
<script>

    $(document).ready(function() {

        $(document).on("click", ".btn-profile", function() {
            $('#user-profile').modal('show');
        });

    });

    $(document).ready(function() {

        $(document).on("click", ".btn-password", function() {
            $('#user-password').modal('show');
        });

    });

    $(document).ready(function() {

        $(document).on("click", ".update_password", function(e) {
             //var x = document.getElementById("q").value;
             var CSRF_TOKEN     = $('meta[name="csrf-token"]').attr('content');
             var user =  {!! json_encode((array)auth()->user()->id) !!};

             var np =  $('input#new_pass').val();
             var cp =  $('input#confirm_pass').val();

             
            if(np.length > 4 && np == cp){
                $.ajax({
              url: "{{ url('/settings/update-password') }}"+"/"+user,
              type: "POST",
              data: {_token: CSRF_TOKEN,newpassword: np},

              success: function(response){
                console.log(response);
                response = JSON.parse(JSON.stringify(response))

                tempAlert("Password change",2000);
                $('#user-password').modal('hide');

                window.location.reload();

              },
              error: function(){
                alert("Error processing request, please try again");
              }
            });
            
            
            e.preventDefault();

            }else if(np.length < 5){
                warnAlert("Password should be 5 characters or more",2000);
                document.getElementById("p1").style.display="block";
                document.getElementById("p2").style.display="none";
            }else{
                warnAlert("Password did not match",2000);
                document.getElementById("p1").style.display="none";
                document.getElementById("p2").style.display="block";
            }

        });   

    });


    $(document).ready(function() {

        $(document).on("click", ".btn-save-profile", function(e) {
             //var x = document.getElementById("q").value;
             var CSRF_TOKEN     = $('meta[name="csrf-token"]').attr('content');
             var user =  {!! json_encode((array)auth()->user()->id) !!};

             const email    =   $("input#email").val();
             var name       =   $('input#uname').val();
             var fullname   =   $('input#fname').val();

             if (validateEmail(email)) {

                $.ajax({
                  url: "{{ url('/settings/update-profile') }}"+"/"+user,
                  type: "POST",
                  data: {_token: CSRF_TOKEN,uname: name,fname:fullname,email:email},

                  success: function(response){
                    console.log(response);
                    response = JSON.parse(JSON.stringify(response))

                    tempAlert("Profile updated",2000);

                    window.location = '/setting/my-account/'+user;

                  },
                  error: function(){
                    alert("Error processing request, please try again");
                  }
                });
                
                
                e.preventDefault();

              } else {
                warnAlert("Invalid email address",2000);
              }

        });   

    });

    function PreviewImage() {
        var oFReader = new FileReader();
        
        oFReader.readAsDataURL(document.getElementById("img_file").files[0]);

        var extension = document.getElementById("img_file").files[0].type

        //alert(extension);

        oFReader.onload = function (oFREvent) {
            //document.getElementById("image").src = oFREvent.target.result;

            $(".photo-info").attr("data", oFREvent.target.result);
            document.getElementById("image-holder").style.display = "block";
            $(".photo-info").attr("data", oFREvent.target.result);

            $(".photo-container").animate({
                opacity: 0.10,
            }, 200, function () {
                if(extension=='application/pdf'){
                    $(".photo-info").attr("data", {!! json_encode(url('/public/images/pdf_icon_small.png')) !!});
                }else{
                    $(".photo-info").attr("data", oFREvent.target.result);
                }
            }).animate({ opacity: 1 }, 800);

        };
    
    };

    function tempAlert(msg,duration)

    {
     var el = document.createElement("div");
     el.setAttribute("style","position:fixed;top:50%;left:45%;margin: 0 auto;background-color:#088A08; border: solid thin #01A9DB; border-radius: 3px; padding-left: 15px; padding-right: 15px; padding-top: 6px; padding-bottom: 6px; color: #fff;box-shadow:2px 5px 5px #585858;-moz-box-shadow:2px 5px 5px #585858;-webkit-box-shadow:2px 5px 5px #585858;");
     el.innerHTML = msg;

     setTimeout(function(){
      el.parentNode.removeChild(el);
     },duration);
     document.body.appendChild(el);
     $(el).hide().fadeIn('slow');
    }

function warnAlert(msg,duration)

    {
     var elx = document.createElement("div");
     elx.setAttribute("style","position:fixed;top:50%;left:45%;margin: 0 auto;background-color:#FF0000; border: solid thin #DF0101; border-radius: 3px; padding-left: 25px; padding-right: 25px; padding-top: 12px; padding-bottom: 12px; color: #ffffff;box-shadow:2px 5px 5px #585858;-moz-box-shadow:2px 5px 5px #585858;-webkit-box-shadow:2px 5px 5px #585858;");
     elx.innerHTML = msg;

     setTimeout(function(){
      elx.parentNode.removeChild(elx);
     },duration);
     document.body.appendChild(elx);
     $(elx).hide().fadeIn('slow');
    }


function validateEmail(email) {
const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

function validate() {
  const $result = $("#result");
  const email = $("inut#email").val();
  $result.text("");

  if (validateEmail(email)) {
    //$result.text("valid email address");
    $result.css("color", "green");
  } else {
    $result.text("invalid email address");
    $result.css("color", "red");
  }
  return false;
}

$("input#email").on("blur", validate);

</script>
@endsection