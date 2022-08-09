@extends('layouts.master')

@section('content')

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

<style>
    .userslist tr:hover{
        background-color: #ccc;
    }

    .inactive {
        background: #aca7a8;
    }

    .settingstbl {

    }

    .settingstbl tr{
        
    }

    .settingstbl tr td{
        vertical-align: top;
        font-weight: bold;
    }
</style>

<input type="hidden" name="type_input" id="type_input" value="adminv">
<div class="content-wrapper ml-2" style="width: 115%">
    <div class="row justify-content-center" style="width: 100%">
        <div class="col-md-8" style="width: 100%">
            <div class="card mt-3">
                <div class="card-header bg-primary" style="font-size: 16px; font-weight: bold; color: #fff;">Employees Lists</div>
                    <div class="card-body" style="display: flex; justify-content: center;">

                        <section style="width: 100%">
                            @if($data->count()>0)
                                  <!-- search form   -->
                                <table>

                                    <tr>
                                        <td class="d-flex" style="border-bottom: 1px solid #0080FF;">
                                              <div class="sidebar-form" style="width: 200px; margin-left: 5px;">
                                                    <div class="input-group">
                                                        <input list="typelists" placeholder="Filter by Division" name="division" id="division" class="form-control">
                                                        <span class="input-group-btn">
                                                            <button type="submit" name="search" id="search-btn-type" class="searchbtn-type btn btn-flat" >
                                                              <i class="fa fa-search"></i>
                                                            </button>
                                                        </span>
                                                            <datalist id="typelists">
                                                                @if($data->count()>0)
                                                                    @foreach($data as $t)
                                                                        <option value="{{ $t->division }}">
                                                                    @endforeach
                                                                @endif
                                                            </datalist>
                                                    </div>
                                                </div>

                                        
                                              <div class="sidebar-form" style="width: 200px; margin-left: 5px;">
                                                    <div class="input-group">
                                                        <input list="userlist" placeholder="Filter by Employee" name="employee" id="employee" class="form-control">
                                                        <span class="input-group-btn">
                                                            <button type="submit" name="search" id="search-btn-type" class="searchbtn-employee btn btn-flat" >
                                                              <i class="fa fa-search"></i>
                                                            </button>
                                                        </span>
                                                            <datalist id="userlist">
                                                                @if($employees->count()>0)
                                                                    @foreach($employees as $t)
                                                                        <option value="{{ $t->f_name }}">
                                                                    @endforeach
                                                                @endif
                                                            </datalist>
                                                    </div>
                                                </div>
                                            
                                        </td>
                                        
                                    </tr>
                                </table>
                                   
                                    
                                      <!-- /.search form -->
                        <!--Content-->

                            <table style="align-self: center; table-layout: inherit;" class='userslist'>
                                <tr>
                                    <td style="font-size: 16px !important; background: #0B2F3A; font-weight: bold; color: #fff; padding: 20px;">Name</td>
                                    <td style="font-size: 16px !important; background: #0B2F3A; font-weight: bold; color: #fff; padding: 20px;">Email</td>
                                    <td style="font-size: 16px !important; background: #0B2F3A; font-weight: bold; color: #fff; padding: 20px;">Designation</td>
                                    <td style="font-size: 16px !important; background: #0B2F3A; font-weight: bold; color: #fff; padding: 20px;">Division</td>
                                    <td style="font-size: 16px !important; background: #0B2F3A; font-weight: bold; color: #fff; padding: 20px;">Action</td>
                                </tr>

                                <?php $thedivision = []; ?>

                                @foreach($userlist as $user)
                                <?php 
                                    
                                    $class = null;
                                    if ( strlen(trim($user->division)) == 0) {
                                        $class = "inactive";
                                    } else {
                                        $class = null;

                                        if (count($thedivision) > 0) {
                                            if (!in_array($user->division, $thedivision)) {
                                                array_push($thedivision,$user->division);
                                            }
                                        } else {
                                            array_push($thedivision,$user->division);
                                        }
                                    }

                                ?>
                                <tr class='<?php echo $class; ?>'>
                                        
                                        <td style="border-bottom: 1px solid #E6E6E6; padding-top: 15px; padding-bottom: 15px;">{{$user->f_name}}</td>
                                        <td style="border-bottom: 1px solid #E6E6E6; padding-top: 15px; padding-bottom: 15px;">{{$user->email}}</td>
                                        <td style="border-bottom: 1px solid #E6E6E6; padding-top: 15px; padding-bottom: 15px;">{{$user->position}}</td>
                                        <td style="border-bottom: 1px solid #E6E6E6; padding-top: 15px; padding-bottom: 15px;">{{$user->division}} </td>
                                        <td>
                                            <a href="javascript:void(0);" class="alevel btn btn-small btn-primary mr-3" id="{{$user->id}}" data-status='{{$class}}' data-email='{{$user->email}}' data-fullname='{{$user->f_name}}'>
                                                <span class="fa fa-expeditedssl" aria-hidden="true"></span> see actions
                                            </a>
                                        </td>                             
                                </tr>
                                @endforeach
                            </table>

                            @else
                                <div class="justify-content-center bg-danger p-5" style="font-size: 16px; color: #fff; width: 70vw; text-align: center;">No Record Found</div>
                            @endif

                            @if($userlist->count() > 0)
                                <div class="justify-content-center" style="font-size: 10px; margin-top: 10px; margin-bottom: 50px;">{{ $userlist->links() }}</div>
                            @endif
                        <!--Content End-->
                        </section>
                    </div>

                
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="set-access" tabindex="-1" role="dialog"aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog  modal-lg" style="min-width: auto; max-width: 50%"  role="document">
    <div class="modal-content">
      <div class="modal-header"><span style="font-size: 18px; color: #0B2161; text-align: center;"><strong>SET ACCESS LEVEL </strong> <small class='statustxt' style='color:red;'> </small></span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <span id="form_result"></span>

      <table border="1px #fff solid;" style="align-self: center;" class='settingstbl'>
        <tr>
            <td style="text-align: right;padding-top: 0px;padding-right: 20px; width: 25%;">
                <h4> Access Level </h4>
            </td>
            <td> 
                <p>
                    <label class='btn btn-default'>
                        <input type="checkbox" name="chkuser" id="chkuser" class="checkboxes" style="vertical-align: text-bottom;"> User
                    </label>
                </p>
                <p>
                    <label class='btn btn-default'>
                        <input type="checkbox" name="chkdchief" id="chkdchief" style="vertical-align: text-bottom;"> Division Chief
                    </label>
                </p>
                <p>
                    <label class='btn btn-default'>
                        <input type="checkbox" name="chkdirector" id="chkdirector" style="vertical-align: text-bottom;"> Director
                    </label>
                </p>
                <p>
                    <label class='btn btn-default'>
                        <input type="checkbox" name="chkoc" id="chkoc" style="vertical-align: text-bottom;"> OC/OED/ARMIK
                    </label>
                </p>
                <p>
                    <label class='btn btn-default'>
                        <input type="checkbox" name="chkadmin" id="chkadmin" style="vertical-align: text-bottom;"> Admin
                    </label>
                </p>
                 <p>
                    <label class='btn btn-default'>
                        <input type="checkbox" name="chkrecord" id="chkrecord" style="vertical-align: text-bottom;"> Records
                    </label>
                </p>
                <input type="hidden" name="_id" id="_id" value="">
                
                <button class="btn_save btn btn-primary" style="padding-left: 20px; padding-right: 20px; "><span class="fa fa-floppy-o" aria-hidden="true"></span> Save</button>
            </td>
        </tr>
        <tr>
            <td style="text-align: right;padding-top: 0px;padding-right: 20px; width: 25%;"> <h4> Set as inactive </h4> </td>
            <td> <button class='btn btn-default setinactive'> Set Inactive </button> </td>
        </tr>
        <tr>
            <td style="text-align: right;padding-top: 0px;padding-right: 20px; width: 25%;"> <h4> Set as active </h4> </td>
            <td> 
                <select class='btn btn-default' id='officeactive'>
                    <?php 
                        foreach($thedivision as $td) {
                            echo "<option>";
                                echo $td;
                            echo "</option>";
                        }
                    ?>
                </select> <br/>
                <button class='btn btn-primary setasactive' style="margin-top: 5px;"> Update office </button> 
            </td>
        </tr>
        <tr>
            <td style="text-align: right;padding-top: 0px;padding-right: 20px; width: 25%;"> <h4> Update email </h4> </td>
            <td> 
                <input type='text' id='theemail' class="form-control"/> <button class='btn btn-primary updateemail' style='margin-top: 5px;' > Update Email </button> 
            </td>
        </tr>
        <tr>
            <td style="text-align: right;padding-top: 0px;padding-right: 20px; width: 25%;"> <h4> Update Name </h4> </td>
            <td> 
                <input type='text' id='thefullname' class="form-control"/> <button class='btn btn-primary updatefullname' style='margin-top: 5px;' > Update fullname </button> 
            </td>
        </tr>
        <tr>
            <td style="text-align: right;padding-top: 0px;padding-right: 20px; width: 25%;"> <h4> Update password </h4> </td>
            <td> 
                <input type='password' id='password' class="form-control"/> <button class='btn btn-primary updatepassword' style='margin-top: 5px;' > Update Password </button> 
            </td>  
        </tr>
        <tr>
            <td style="text-align: right; padding-right: 20px; width: 25%;"> <h4> Account Status </h4> </td>
            <td> <h4 id='accountstatus'> </h4> </td>
        </tr>
    </table>

  </div>
</div>
</div>

<script src="{{ asset('js/moment.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var theselectedid = null;
        
        $(document).on("click", ".alevel", function() {
            var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
            var id   = $(this).attr("id");

            theselectedid = id;

            // setting the defaults
                $(document).find("#theemail").val( $(this).data("email") );
                $(document).find("#thefullname").val( $(this).data("fullname") );
            // end 

            if ($(this).data('status') == "inactive"){
                $(document).find("#accountstatus").text("Inactive account");
            } else {
                $(document).find("#accountstatus").text("This account is active");
            }

            $('input#_id').val(id);
            $('#set-access').modal('show'); 

        });

        $(document).on("click",".setinactive", function(){
            var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');

            if (theselectedid == null) { alert("no ID is selected"); return; }

            $.ajax({
                url : "{{ url('/admin/setuserinactive') }}",
                type: "POST",
                data : { _token: CSRF_TOKEN , id: theselectedid },
                dataType: "json",
                success : function(data) {
                    alert("Update successful! number of row updated: "+data['updatedrow']);
                    window.location.reload();
                }, error: function() {
                    alert('error in setting the user inactive');
                }
            });
        });

        $(document).on("click",".setasactive",function(){
            var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');

            if (theselectedid == null) { alert("no ID is selected"); return; }
            var theoffice   = $(document).find("#officeactive").val();

            $.ajax({
                url : "{{ url('/admin/setasactive') }}",
                type: "POST",
                data : { _token: CSRF_TOKEN , id: theselectedid , office : theoffice },
                dataType: "json",
                success : function(data) {
                    alert("Update successful! number of row updated: "+data['updatedrow']);
                    window.location.reload();
                }, error: function() {
                    alert('error in setting the user as active');
                }
            });
        });

        $(document).on("click",".updateemail", function(){
            var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
            
            $(document).find(".statustxt").html("updating please wait.")

            if (theselectedid == null) { alert("no ID is selected"); return; }
            var email   = $(document).find("#theemail").val();

            $.ajax({
                url : "{{ url('/admin/updateemail') }}",
                type: "POST",
                data : { _token: CSRF_TOKEN , id: theselectedid , email : email },
                dataType: "json",
                success : function(data) {
                    alert("Update successful! number of row updated: "+data['updatedrow']);
                    window.location.reload();
                }, error: function() {
                    alert('error in setting the user as active');
                }
            });
        });

        $(document).on("click", ".updatefullname", function(){
            var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
            
            $(document).find(".statustxt").html("updating please wait.")

            if (theselectedid == null) { alert("no ID is selected"); return; }
            var fullname   = $(document).find("#thefullname").val();

            $.ajax({
                url : "{{ url('/admin/updatefullname') }}",
                type: "POST",
                data : { _token: CSRF_TOKEN , id: theselectedid , fullname : fullname },
                dataType: "json",
                success : function(data) {
                    alert("Update successful! number of row updated: "+data['updatedrow']);
                    window.location.reload();
                }, error: function() {
                    alert('error in setting the user as active');
                }
            });
        });

         $(document).on("click",".updatepassword", function(){
            var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
            
            $(document).find(".statustxt").html("updating please wait.")

            if (theselectedid == null) { alert("no ID is selected"); return; }
            var password   = $(document).find("#password").val();

            $.ajax({
                url : "{{ url('/admin/updatepassword') }}",
                type: "POST",
                data : { _token: CSRF_TOKEN , id: theselectedid , password : password },
                dataType: "json",
                success : function(data) {
                    alert("Update successful! number of row updated: "+data['updatedrow']);
                    window.location.reload();
                }, error: function() {
                    alert('error updating the password');
                }
            });
        });
    });

    $(document).ready(function(){
        $(document).on("click",".btn_save", function(){
            var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');

            var x_id = $('input#_id').val();
            var a_level=0;

            if (document.getElementById('chkuser').checked) {
                a_level=0;
            }

            if (document.getElementById('chkdchief').checked) {
                a_level=1;
            }

            if (document.getElementById('chkdirector').checked) {
                a_level=2;
            }

            if (document.getElementById('chkoc').checked) {
                a_level=4;
            }

            if (document.getElementById('chkadmin').checked) {
                a_level=4;
            }

            if (document.getElementById('chkrecord').checked) {
                a_level=5;
            }

            $.ajax({
                url: "{{ url('/admin/access-level') }}/"+x_id,
                type: "POST",
                data: {_token: CSRF_TOKEN,_id: x_id, _accesslevel: a_level},

                success: function(response){
                    //console.log(response);

                    tempAlert("Access Level Changed....",2000);

                    $('#set-access').modal('hide');
                    window.location.href="{{ url('/admin') }}";
                  },
                  error: function(e){
                    alert(JSON.stringify(e));
                  },
                });
                e.preventDefault();

        });
    });

        function tempAlert(msg,duration)

            {
             var el = document.createElement("div");
             el.setAttribute("style","position:fixed;top:50%;left:45%;margin: 0 auto;background-color:#F4FA58; border: solid thin #01A9DB; border-radius: 3px; padding-left: 15px; padding-right: 15px; padding-top: 6px; padding-bottom: 6px; color: #0B2161;box-shadow:2px 5px 5px #585858;-moz-box-shadow:2px 5px 5px #585858;-webkit-box-shadow:2px 5px 5px #585858;");
             el.innerHTML = msg;

             setTimeout(function(){
              el.parentNode.removeChild(el);
             },duration);
             document.body.appendChild(el);
             $(el).hide().fadeIn('slow');
            }


        $(document).ready(function() {

            $('input[type="checkbox"]').on('change', function() {
                $('input[type="checkbox"]').not(this).prop('checked', false);
            });
        });

    $(document).ready(function() {

        $(document).on("click", ".searchbtn-type", function() {
                 //var x = document.getElementById("q").value;

            var x =  $('input#division').val();

                if(x.length > 0){
                    window.location = "{{ url('/admin/division') }}/" + x
                }else{
                    warnAlert("Search criteria is empty",2000);
                }
            });       
    });

    $(document).ready(function() {

        $(document).on("click", ".searchbtn-employee", function() {
                 //var x = document.getElementById("q").value;

            var x =  $('input#employee').val();

                if(x.length > 0){
                    window.location = "{{ url('/admin/employee') }}/" + x
                }else{
                    warnAlert("Search criteria is empty",2000);
                }
            });       
    });


</script>
@endsection