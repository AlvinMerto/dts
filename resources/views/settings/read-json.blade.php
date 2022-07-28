@extends('layouts.master')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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


<div class="content-wrapper ml-2" style="width: 115%">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-3">
                <div class="card-header bg-success" style="font-size: 16px; font-weight: bold; color: #fff;">Document Lists</div>
                	<div class="card-body" style="display: flex; justify-content: center;">

    					<section>

    					<!--Content-->
    						<div><a href="/setting/read-json">Read JSON</a></div>
    					<!--Content End-->

    					{{--
    					@foreach($content as $c)
    						<div>{{$c->f_name}}</div>
    					@endforeach

    					<div>{{$content}}</div>
    					--}}

    					
    					</section>
    				</div>

				
			</div>
		</div>
	</div>
</div>
@endsection