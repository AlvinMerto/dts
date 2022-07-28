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

<div class="content-wrapper">

<div class="content-wrapper" style="margin-left: 20px;">
    <section class="content-header">
    	<div class="content-header" style="color: #084B8A; font-family: 'Calibri';"></div>
    		<div align="center" style="margin-right: 0; margin-left: 0;">
    			<img src="{{ url('/images/error-icon.png') }}" style="width:40%">
    		</div>
    		<div style="text-align: center;">
    			<span align="center" style="font-weight: bold;font-size: 16px; text-align: center;">Please setup the Signatures first in Settings <i class="fa fa-gears"></i></span>
    		</div>

    	<div  style="background-color: #fff; display: inline-block;">

<!--Content-->


<!--Content End-->
    </div>

</section>

</div>

</div>

@endsection