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

<input type="hidden" name="type_input" id="type_input" value="library">
<div class="content-wrapper ml-2" style="width: 115%">
    <div class="row justify-content-center" style="width: 100%">
        <div class="col-md-8">
            <div class="card mt-3">
                <div class="card-header bg-warning" style="font-size: 16px; font-weight: bold; color: #434243;">DOCUMENT CATEGORY/TYPE</div>
                    <div class="card-body" style="display: flex; justify-content: center;">

                        <section style="width: 100%">
                        <!--Content-->
                        	<table style="align-self: center; table-layout: inherit;">
                        		{{--<tr>
                        			<td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">ABBREVIATION</td>
                        			<td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">FULL DETAILS</td>
                        			<td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">ACTION</td>
                        		</tr>--}}
                        		@if($data->count()>0)
                        		@foreach($data as $d)
                        		<tr>
                        			{{--<td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">{{$d->doc_lib_abbrv}}</td>--}}
                        			<td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">{{$d->doc_full_desc}}</td>
                        			<td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">
                        				<a href="#" id="{{$d->id}}" class="btn-edit btn btn-warning mt-2  pl-4 pr-4"><span class="fa fa-pencil-square-o" aria-hidden="true"></span> Edit</a>
                        				<br>
                        				<a href="{{url('/library/library/remove-entry')}}/{{$d->id}}" id="{{$d->id}}" onclick="return confirm('Are you sure?')" class="btn btn-small btn-danger mt-2  pl-3 pr-3"><span class="fa fa-trash" aria-hidden="true"></span> Delete </a>
                        			</td>
                                    <input type="hidden" name="_id" id="_id" value="{{$d->id}}">
                        		</tr>

                        		@endforeach
                        		@endif
                        	</table>


                        <!--Content End-->
                        </section>
                    </div>

                
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $(document).on("click", ".btn-edit", function() {
             var x_id     =   $(this).attr('id');

            window.location.href="{{ url('/library/library/edit-entry') }}/"+x_id;
        });  


        $(document).on("click", ".delete-btn", function() {
             var x_id     =   $(this).attr('id');

             if (confirm("Press a button!")) {
                window.location.href="{{ url('/library/library/remove-entry') }}/"+x_id;
              } 
            
        });     
    });
</script>
@endsection