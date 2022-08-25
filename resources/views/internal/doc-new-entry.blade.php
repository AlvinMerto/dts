@extends('layouts.master')

@section('content')

<script src="{{ asset('js/dropzone/dropzone.js') }}" defer></script>
<link rel="stylesheet" href="{{ asset('css/dropzone/dropzone.css')}}">
<script src="{{ asset('js/moment.min.js') }}"></script>
<script>
		$(document).ready(function() {
		    var msg = '{{Session::get('alert')}}';
		    var exist = '{{Session::has('alert')}}';
		    if(exist){
		    	setTimeout(function () { 

		    		alert(msg); 
		    		//$('#doc-image').modal('show');
		    	}, 100);
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

	    $("input").on("change", function() {
    	this.setAttribute(
        "data-date",
        moment(this.value, "YYYY-MM-DD")
        .format( this.getAttribute("data-date-format") )
    		)
		}).trigger("change")

});
</script>

<input type="hidden" name="type_input" id="type_input" value="internal">
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-8" style='margin-top: 10px;'>
            <div class="card" style='flex-direction: unset;'>
                <div class="card-header bg-primary" style="font-size: 20px;  color: #fff;">New Internal Document</div>
                <div class="card-body" style="display: flex; justify-content: center;">
                   <!-- content --> 
                   		<form method="POST" action="{{ url('/internal-document/save-entry')}}" accept-charset="utf-8" enctype="multipart/form-data">
						@csrf
				    	<table border="1px #fff solid;" style="align-self: center;">

				    		<tr>
				    			<td><input class="form-control" style="width: auto;" type="date" name="docdate" id="docdate" value="<?php 
				    			$startDate = time(); echo date('Y-m-d'); ?>" required placeholder="Date Received" title="Date Received"></td>
				    			
				    			{{--
				    			<td rowspan="5" valign="top">
				    				<span style="margin-top: 0;">Click the box to choose file<br>or Drag your file into the box</span>
				    					<div class="fallback">
				    						<input class="dropzone" type="file" name="img_file" id="img_file" style=" background: #E6E6E6;" accept="image/x-png,image/gif,image/jpeg,image/bmp,image/jpg,application/pdf" onchange="PreviewImage();">
				    					</div><br>

				    					<div id="image-holder" class="photo-container" style="float: right; display: none;"><img id="image" class="photo-info ml-5 mt-1" src="" style="height: 105px; border: 1px solid #08298A; margin: 5px;box-shadow:2px 5px 5px #585858;-moz-box-shadow:2px 5px 5px #585858;-webkit-box-shadow:2px 5px 5px #585858;"/>

				    					</div><br>

				    					<div id="image-holder" class="photo-container" style="float: right; display: none;">
					    					<object data="" width="200" height="500" id="image" class="photo-info ml-5 mt-1" style="height: auto; border: 1px solid #08298A; margin: 5px;box-shadow:2px 5px 5px #585858;-moz-box-shadow:2px 5px 5px #585858;-webkit-box-shadow:2px 5px 5px #585858;"><br>            
	                                         </object>
                                     	</div>
							     		<div id="err"></div>
				    			</td>
				    				--}}
				    		</tr>
				    		<tr>
				    			<td><input class="form-control" type="text" name="briefer" id="briefer" value="" required placeholder="Briefer Number"></td>
				    		</tr>
				    		<tr>
				    			<td><input class="form-control" type="text" name="barcode" id="barcode" value="" required placeholder="Barcode Number" onblur="checkDuplicate();"></td>
				    		</tr>
				    		<tr>
				    			{{--<td><input class="form-control" type="text" name="agency" id="agency" value="" required placeholder="Agency"></td>--}}

				    			<td>
				    				<input list="division_datalist" name="agency" id="agency" class="form-control p-2" required placeholder="Division/Office"></td>
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
				    			{{--<td><input class="form-control" type="text" name="signature" id="signature" value="" required placeholder="Sender"></td>--}}

				    			<td>
				    				<input list="user_datalist" name="signature" id="signature" class="form-control p-2" required placeholder="Sender"></td>
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
				    			{{--<td><input class="form-control" type="text" name="doctitle" id="doctitle" value="" required placeholder="Document Category/Type"></td>--}}

				    			<td>
				    				<input list="memo_datalist" name="doctitle" id="doctitle" class="form-control p-2" required placeholder="Document Category/Type"></td>
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
				    			<td><input class="form-control mr-5" type="text" name="docdesc" id="docdesc" value="" required placeholder="Subject/Description"></td>
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
				    				<label> <input type="checkbox" name="chkdocreturn" id="chkdocreturn" class="checkbox-success" style="vertical-align: text-bottom;"> Return this Document </label>
				    			</td>
				    		</tr>


				    		{{--<tr>
				    			<td>
					    			<select id="doctype">
					    				<option value="Internal" selected>Internal</option>
					    				<option value="External">External</option>
					    			</select>
					    		</td>
				    		</tr>
				    		<tr>
				    			<td>
					    			<select id="docclassification" name="docclassification" onchange="checkClass()">
					    				<option value="1" selected>Confidential</option>
					    				<option value="2">High Priority</option>
					    				<option value="3">Moderate Priority</option>
					    				<option value="4">Low Priority</option>
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


				    		<tr>
				    			<td><button type="submit" class="btn btn-primary bg-primary btn-sm" style="padding-left: 20px; padding-right: 20px;"><span class="fa fa-floppy-o" aria-hidden="true"></span> Save</button></td>
				    		</tr>
				    	</table>
				    </form>
                   <!-- content end -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Popup Modal -->
<div class="modal fade" id="doc-image" tabindex="-1" role="dialog"aria-labelledby="ff-modal-label" aria-hidden="true">
  <div class="modal-dialog  modal-lg" style="min-width: auto; max-width: 50%"  role="document">
    <div class="modal-content">
      <div class="modal-header"><span style="font-size: 24px; color: #FF4000; text-align: center;"><strong>DOCUMENT TRACKING SYSTEM</strong></span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <span id="form_result"></span>


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
	   		url: "{{ url('/internal-document/barcode-number') }}/"+barnum,
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
