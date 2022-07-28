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

<input type="hidden" name="type_input" id="type_input" value="external">
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-8" style="margin-bottom: 40px;">
            <div class="card">
                <div class="card-header bg-success" style="font-size: 16px; font-weight: bold; color: #fff;">New External Document</div>
                <div class="card-body" style="display: flex; justify-content: center;">
                   <!-- content --> 
                   		<form method="POST" action="{{ url('/external-document/save-entry')}}" accept-charset="utf-8" enctype="multipart/form-data">
						@csrf
				    	<table border="1px #fff solid;" style="align-self: center;">

				    		<tr>
				    			<td><input class="form-control" style="width: auto;" type="date" name="docdate" id="docdate" value="<?php 
				    			$startDate = time(); echo date('Y-m-d', strtotime('+1 day', $startDate)); ?>" required placeholder="Date Received" title="Date Received"></td>
				    			
				    		</tr>
				    		{{--<tr>
				    			<td><input class="form-control" style="width: 200px;" type="text" name="briefer" id="briefer" value="" required placeholder="Briefer Number"></td>
				    		</tr>--}}
				    		<tr>
				    			<td><input class="form-control" style="width: 200px;" type="text" name="barcode" id="barcode" value="" required placeholder="Barcode Number" onblur="checkDuplicate();"></td>
				    		</tr>
				    		<tr>
				    			<td>
				    				<input list="division_datalist" name="agency" id="agency" class="form-control p-2" style="width: 200px;" required placeholder="Agency to"></td>
										<datalist id="division_datalist">
								            @if($div->count()>0)
								            @foreach($div as $u)
												<option value="{{ $u->division }}">
											@endforeach
											@endif
										</datalist>
										<input type="hidden" id="userselect" name="userselect">
				    			</td>
				    		</tr>
				    		<tr>
				    			{{--<td><input class="form-control" style="width: 200px;" type="text" name="signature" id="signature" value="" required placeholder="Sender/Signatory"></td>--}}
				    			<td>
				    				<input list="user_datalist" name="signature" id="signature" class="form-control p-2" style="width: 200px;" required placeholder="Signatory/Route To"></td>
										<datalist id="user_datalist">
								            @if($userlist->count()>0)
								            @foreach($userlist as $u)
												<option value="{{ $u->f_name }}">
											@endforeach
											@endif
										</datalist>
										<input type="hidden" id="userselect" name="userselect">

				    			</td>
				    		</tr>
				    		<tr>
				    			<td><input class="form-control" style="width: 200px;" type="text" name="sendername" id="sendername" value="" required placeholder="Sender's Name"></td>
				    		</tr>
				    		<tr>
				    			<td><input class="form-control" style="width: 200px;" type="Email" name="sigEmail" id="sigEmail" value="" required placeholder="Sender's Email"></td>
				    		</tr>
				    		<tr>
				    			<td>
				    				<input list="memo_datalist" name="doctitle" id="doctitle" class="form-control p-2" style="width: 300px;" required placeholder="Document Category/Type"></td>
										<datalist id="memo_datalist">
								            @if($lib->count()>0)
								            @foreach($lib as $l)
												<option value="{{ $l->doc_full_desc }}">
											@endforeach
											@endif
										</datalist>
										<input type="hidden" id="optselect" name="optselect">
				    			</td>
				    		</tr>
				    		<tr>
				    			<td><input class="form-control mr-5" style="width: 300px;" type="text" name="docdesc" id="docdesc" value="" required placeholder="Subject/Description"></td>
				    		</tr>
				    		
				    		<tr>
				    			<td>
					    			<select id="doctype" name="doctype" class="form-control">
					    				<option value="Admin" selected>Admin</option>
					    				<option value="Operation">Operation</option>
					    			</select>
					    		</td>
				    		</tr>
				    		<tr>
				    			<td><input class="form-control" style="width: 150px;" type="Number" name="numcopy" id="numcopy" value="" required placeholder="Number of Copy"></td>
				    		</tr>
				    		<tr>
				    			<td><input class="form-control" style="width: 150px;" type="Number" name="numpages" id="numpages" value="" required placeholder="Number of Pages"></td>
				    		</tr>
				    		<tr>
				    			<td>
					    			<select id="docclassification" name="docclassification" class="form-control">
					    				<option value="1" selected>Confidential</option>
					    				<option value="2">High Priority</option>
					    				<option value="3">Moderate Priority</option>
					    				<option value="4">Low Priority</option>
					    			</select>
					    		</td>
				    		</tr>
				    		<tr>
				    			<td>
				    				<input type="checkbox" name="chkdocreturn" id="chkdocreturn" class="checkbox-success" style="vertical-align: text-bottom;"> Return this Document
				    			</td>
				    		</tr>
				    		<tr id="busywait" style="display: none;">
			                    <td colspan="2" align="center"><span style="color: #3A01DF;"><img src="{{ url('/images/busy_wait.gif') }}" height="40px">
			                        <b>Sending mails... Please wait...</b></span>
			                    </td>
			                </tr>
				    		<tr>
				    			<td colspan="2"><button type="submit" class="btn-exentry btn btn-success" style="padding-left: 20px; padding-right: 20px; float: right;" onclick="document.getElementById('busywait').style.display = 'table-row'; window.scrollTo(0,document.querySelector('.scrollingContainer').scrollHeight);"><span class="fa fa-floppy-o" aria-hidden="true"></span> Save</button></td>
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

function checkClass() {
	//var e = document.getElementById("docclassification");
	var e = $("#docclassification :selected").val();

	//alert(e);

	//var strClass = e.options[e.selectedIndex].value;

	

	if(e != 1){
		document.getElementById("ff_employee").disabled = true;
		document.getElementById("ff_employee").value="";
	}else{
		document.getElementById("ff_employee").disabled = false;
	}
  
}

$(document).ready(function () {
	$(document).on("click", ".btn-exentry", function(e) {
		document.getElementById('busywait').style.display = "table-row";
	}
}


function checkDuplicate() {
	var CSRF_TOKEN  = 	$('meta[name="csrf-token"]').attr('content');
   	var barnum      =   $('input#barcode').val();

   	//alert(barnum);

   	if(!barnum==""){
	   	$.ajax({
	   		url: "{{ url('/external-document/barcode-number') }}/"+barnum,
	                type: "GET",
	                data: {_token: CSRF_TOKEN,_id: barnum},

	                success: function(response){
	                    console.log(response);

	                    var dupbarcode =  response.dup;

		                    if(dupbarcode == 1){
		                    	swal({
	                              position: 'center',
	                              icon: 'error',
	                              title: 'This barcode number is already taken, Please enter another barcode number',
	                              showConfirmButton: false
	                            });
		                    	document.getElementById("barcode").value="";
		                    }

	                 	},
	                  error: function(ex){
	                    alert(JSON.stringify(ex));
	                    //window.location.href="{{ url('/home') }}";
	                  }
	                 
	   	});
   	}
   	
}
</script>
@endsection
