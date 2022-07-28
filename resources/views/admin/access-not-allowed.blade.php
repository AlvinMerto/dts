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
                <div class="card-header bg-danger" style="font-size: 16px; font-weight: bold; color: #fff;">Insufficient Access</div>
                    <div class="card-body" style="display: flex; justify-content: center;">

                        <section style="width: 100%">
                            <div align="center" style="width: 100%;">
                                <img src="{{ url('/images/icon-declined.png') }}" alt="1" width="auto" height="auto" align="center"><br>
                                <span style="font-size: 18px; color: #6E6E6E;">Sorry, you do not have permission to view this page</span><br><br>
                                <p style="color: #084B8A; font-weight: bold; font-size: 20px;">Mindanao Development Authority</p>
                                <p style="color: #A4A4A4; font-weight: bold; font-family: Georgia, serif;">Old Airport Bldg., Old Airport Road, <br>
                                Km. 9, Sasa, Davao City 8000 Philippines<br></p>
                                <p>www.minda.gov.ph<br><br></p>
                                <p style="color: #A4A4A4;">Telefax No.: (082) 221-7060/(082) 221-6929</p>
                            </div>
                                    
                        <!--Content End-->
                        </section>
                    </div>

                
            </div>
        </div>
    </div>
</div>
@endsection