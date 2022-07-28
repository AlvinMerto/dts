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
    	<div class="content-header" style="color: #084B8A; font-family: 'Calibri';"><Strong>PROPERTY CARD</Strong></div>

    	<div  style="background-color: #fff; display: inline-block;">

<!--Content-->
<div class="pl-3 ml-3 pr-1 mr-1" style="margin-left: 10px; margin-right: 1px;">
	<div class="row justify-content-center">
		<div>
			<div class="card" style="background: #A9D0F5;">
				<div class="card-header">
					<div align="justify-content-center">
						<div align="center" class="p-3"><img src="{{url('/images/JxnkUJGd89gKjgGjhvbKjhFTjhLkhnBkjuh_lkhkjn-khnkB__kjGguyu7.png')}}" width="50%" height="50%"></div>
						<span class="card p-4" style="background: #DF0101; font-size: 30px; color: #ffffff">No Item found from the date range selected</span>
					</div>
					<div class="mt-4" style="float: right;"><button onclick="return_back();"  class="btn btn-small btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Back</button></div>
				</div>
			</div>
		</div>
	</div>
</div>


<!--Content End-->
    </div>

</section>

</div>

</div>

<script>
	function return_back()
	{
		window.history.back();
	}
</script>
@endsection