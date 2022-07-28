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

                            <table style="align-self: center; table-layout: inherit;">
                                <tr>
                                    <td style="font-size: 16px !important; background: #0B2F3A; font-weight: bold; color: #fff; padding: 20px;">Name</td>
                                    <td style="font-size: 16px !important; background: #0B2F3A; font-weight: bold; color: #fff; padding: 20px;">Email</td>
                                    <td style="font-size: 16px !important; background: #0B2F3A; font-weight: bold; color: #fff; padding: 20px;">Designation</td>
                                    <td style="font-size: 16px !important; background: #0B2F3A; font-weight: bold; color: #fff; padding: 20px;">Division</td>
                                    <td style="font-size: 16px !important; background: #0B2F3A; font-weight: bold; color: #fff; padding: 20px;">Access Level</td>
                                </tr>

                                @foreach($userlist as $user)
                                <tr>
                                    
                                        <td style="border-bottom: 1px solid #E6E6E6; padding-top: 15px; padding-bottom: 15px;">{{$user->f_name}}</td>
                                        <td style="border-bottom: 1px solid #E6E6E6; padding-top: 15px; padding-bottom: 15px;">{{$user->email}}</td>
                                        <td style="border-bottom: 1px solid #E6E6E6; padding-top: 15px; padding-bottom: 15px;">{{$user->position}}</td>
                                        <td style="border-bottom: 1px solid #E6E6E6; padding-top: 15px; padding-bottom: 15px;">{{$user->division}}</td>
                                        <td>
                                            <a href="javascript:void(0);" class="alevel btn btn-small btn-primary mr-3" id="{{$user->id}}"><span class="fa fa-expeditedssl" aria-hidden="true"></span> Set Access Level</a>

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
      <div class="modal-header"><span style="font-size: 24px; color: #0B2161; text-align: center;"><strong>SET ACCESS LEVEL</strong></span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <span id="form_result"></span>

      <table border="1px #fff solid;" style="align-self: center;">

        <tr>
            <td align="center">
                <span>
                    <input type="checkbox" name="chkuser" id="chkuser" class="checkboxes" style="vertical-align: text-bottom;"> User
                </span>
            <td align="center">
                <span>
                    <input type="checkbox" name="chkdchief" id="chkdchief" style="vertical-align: text-bottom;"> Division Chief
                </span>
            </td>
            <td align="center">
                <span>
                    <input type="checkbox" name="chkdirector" id="chkdirector" style="vertical-align: text-bottom;"> Director
                </span>
            </td>
            <td align="center">
                <span>
                    <input type="checkbox" name="chkoc" id="chkoc" style="vertical-align: text-bottom;"> OC/OED/ARMIK
                </span>
            </td>
            <td align="center">
                <span>
                    <input type="checkbox" name="chkadmin" id="chkadmin" style="vertical-align: text-bottom;"> Admin
                </span>
            </td>
            <td align="center">
                <span>
                    <input type="checkbox" name="chkrecord" id="chkrecord" style="vertical-align: text-bottom;"> Records
                </span>
            </td>
        </tr>
        <input type="hidden" name="_id" id="_id" value="">

        <tr>
            <td colspan="6"><button class="btn_save btn btn-success" style="padding-left: 20px; padding-right: 20px; float: right;"><span class="fa fa-floppy-o" aria-hidden="true"></span> Save</button></td>
        </tr>
    </table>
  </div>
</div>
</div>

<script src="{{ asset('js/moment.min.js') }}"></script>
<script>
    $(document).ready(function() {

        $(document).on("click", ".alevel", function() {
            var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
            var id   = $(this).attr("id");

            $('input#_id').val(id);

            $('#set-access').modal('show'); 

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