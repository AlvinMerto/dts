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

<input type="hidden" name="type_input" id="type_input" value="internal">
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary" style="font-size: 16px; font-weight: bold; color: #fff;">New Internal Document</div>
                <div class="card-body" style="display: flex; justify-content: center;">
                   <!-- content --> 
                   		<form method="POST" action="{{ url('/internal-document/save-entry')}}" accept-charset="utf-8" enctype="multipart/form-data">
						@csrf
				    	<table border="1px #fff solid;" style="align-self: center;">

				    		<tr>
				    			<td><input class="form-control" style="width: 400px;" type="text" name="doctitle" id="doctitle" value="" required placeholder="Document Title"></td>
				    			<td rowspan="5" valign="top">
				    				<span style="margin-top: 0;">Click the box to choose file<br>or Drag your file into the box</span>
				    					<div class="fallback">
				    						<input class="dropzone" type="file" name="img_file" id="img_file" style="width: 200px; background: #E6E6E6;" accept="image/x-png,image/gif,image/jpeg,image/bmp,image/jpg,application/pdf" onchange="PreviewImage();">
				    					</div><br>

				    					<div id="image-holder" class="photo-container" style="float: right; display: none;"><img id="image" class="photo-info ml-5 mt-1" src="" style="height: 105px; border: 1px solid #08298A; margin: 5px;box-shadow:2px 5px 5px #585858;-moz-box-shadow:2px 5px 5px #585858;-webkit-box-shadow:2px 5px 5px #585858;"/></div><br>
							     		<div id="err"></div>
				    			</td>
				    				
				    		</tr>
				    		<tr>
				    			<td><textarea class="form-control" style="width: 400px;" type="text" name="docdesc" id="docdesc" value="" required placeholder="Description" cols="4" rows="3"></textarea></td>
				    		</tr>
				    		<tr>
				    			<td><input class="form-control" style="width: 200px;" type="text" name="barcode" id="barcode" value="" required placeholder="Barcode Number"></td>
				    		</tr>
				    		<tr>
				    			<td><input class="form-control" style="width: 300px;" type="text" name="docfrom" id="docfrom" value="" required placeholder="Document Sender"></td>
				    		</tr>
				    		<tr>
				    			<td><input class="form-control" style="width: 300px;" type="text" name="doctype" id="doctype" value="" required placeholder="Document Type"></td>
				    		</tr>
				    		<tr>
				    			<td><input class="form-control" style="width: auto;" type="date" name="docdate" id="docdate" value="" required placeholder="Date Received" title="Date Received"></td>
				    		</tr>
				    		<tr>
				    			<td colspan="2"><button type="submit" class="btn btn-success" style="padding-left: 20px; padding-right: 20px; float: right;"><span class="fa fa-floppy-o" aria-hidden="true"></span> Save</button></td>
				    		</tr>
				    	</table>
				    </form>
                   <!-- content end -->
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("img_file").files[0]);

        oFReader.onload = function (oFREvent) {
            //document.getElementById("image").src = oFREvent.target.result;
        document.getElementById("image-holder").style.display = "block";

        $(".photo-container").animate({
            opacity: 0.10,
        }, 200, function () {
            $(".photo-info").attr("src", oFREvent.target.result);
        }).animate({ opacity: 1 }, 800);
        };
    };


$(document).ready(function () {

	$("#container").height($(document).height());

});
</script>
@endsection
