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

<input type="hidden" name="type_input" id="type_input" value="outgoing">
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-bottom: 50px;">
                <div class="card-header bg-danger" style="font-size: 16px; font-weight: bold; color: #fff;">New Outgoing Document</div>
                <div class="card-body" style="display: flex; justify-content: center;">
                   <!-- content --> 
                   		<form method="POST" action="{{ url('/outgoing-document/save-entry')}}" accept-charset="utf-8" enctype="multipart/form-data">
						@csrf
				    	<table border="1px #fff solid;" style="align-self: center;">

				    		<tr>
				    			<td><input class="form-control" style="width: auto;" type="date" name="docdate" id="docdate" value="<?php 
				    			$startDate = time(); echo date('Y-m-d', strtotime('+1 day', $startDate)); ?>" required placeholder="Date Received" title="Date Received"></td>
				    			<td rowspan="5" valign="top">
				    				
				    			</td>
				    				
				    		</tr>
				    		<tr>
				    			<td><input class="form-control" style="width: 200px;" type="text" name="briefer" id="briefer" value="" required placeholder="Briefer Number"></td>
				    		</tr>
				    		<tr>
				    			<td><input class="form-control" style="width: 200px;" type="text" name="barcode" id="barcode" value="" required placeholder="Barcode Number"  onblur="checkDuplicate();"></td>
				    		</tr>
				    		<tr>
				    			<td><input class="form-control" style="width: 200px;" type="text" name="agency" id="agency" value="" required placeholder="Sender"></td>
				    		</tr>
				    		<tr>
				    			<td><input class="form-control" style="width: 200px;" type="text" name="agencyto" id="agencyto" value="" required placeholder="Agency/Office"></td>
				    		</tr>
				    		<tr>
				    			<td><input class="form-control" style="width: 200px;" type="text" name="signature" id="signature" value="" required placeholder="Addressee"></td>
				    		</tr>
				    		<tr>
				    			<td><input class="form-control" style="width: 200px;" type="text" name="signatureemail" id="signatureemail" value="" placeholder="Addressee Email Address"></td>
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
				    				<input list="release_datalist" name="releasemode" id="releasemode" class="form-control p-2" style="width: 300px;" required placeholder="Mode of Releasing"></td>
										<datalist id="release_datalist">
								            @if($courier->count()>0)
								            @foreach($courier as $c)
												<option value="{{ $c->courier_abbv }}">
											@endforeach
											@endif
										</datalist>
										<input type="hidden" id="courierselect" name="courierselect">
				    			</td>
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

				    		{{--
				    		<tr>
				    			<td>
					    			<select id="docclassification" name="docclassification" onchange="checkClass()">
					    				<option value="1" selected>Technical</option>
					    				<option value="2">Admin</option>
					    			</select>
					    		</td>
				    		</tr>

				    		<tr>
				    			<td>
				    				<input list="userlist" placeholder="MinDA Employee" name="ff_employee" id="ff_employee" class="form-control" style="width: 200px;"><span style="font-style: italic;">"Note: double-click the box or down arrow to show the list"</span>
				                        <datalist id="userlist">
				                            @if($userlist->count()>0)
				                            @foreach($userlist as $l)
				                                <option value="{{ $l->f_name }}">
				                            @endforeach
				                            @endif
				                        </datalist>
				    			</td>
				    		</tr>

				    		--}}
				    		<tr id="busywait" style="display: none;">
			                    <td colspan="2" align="center"><span style="color: #3A01DF;"><img src="{{ url('/images/busy_wait.gif') }}" height="40px">
			                        <b>Sending mails... Please wait...</b></span>
			                    </td>
			                </tr>
				    		<tr>
				    			<td colspan="2"><button type="submit" class="btn btn-success" style="padding-left: 20px; padding-right: 20px; float: right;" onclick="document.getElementById('busywait').style.display = 'table-row'; window.scrollTo(0,document.querySelector('.scrollingContainer').scrollHeight);"><span class="fa fa-floppy-o" aria-hidden="true"></span> Save</button></td>
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

function checkDuplicate() {
	var CSRF_TOKEN  = 	$('meta[name="csrf-token"]').attr('content');
   	var barnum      =   $('input#barcode').val();

   	//alert(barnum);

   	if(!barnum==""){
	   	$.ajax({
	   		url: "{{ url('/outgoing-document/barcode-number') }}/"+barnum,
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
