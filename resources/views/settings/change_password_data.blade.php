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

<input type="hidden" name="type_input" id="type_input" value="outgoing">
<div class="content-wrapper ml-2" style="width: 115%">
    <div class="row justify-content-center" style="width: 100%">
        <div class="col-md-8">
            <div class="card mt-3">
                <div class="card-header bg-primary" style="font-size: 16px; font-weight: bold; color: #fff;">Change Password</div>
                	<div class="card-body" style="display: flex; justify-content: center;">

    					<section style="width: 100%">
    					
						@csrf
    						<table>
    							<tr>
    								<td width="180" align="right">Enter your New Password</td>
    								<td><input type="Password" name="new_pass" id="new_pass" class="form-control" style="width: 160px;"></td>
    							</tr>
    							<tr>
    								<td width="180" align="right">Confirm Password</td>
    								<td><input type="Password" name="confirm_pass" id="confirm_pass" class="form-control" style="width: 160px;"></td>
    							</tr>
    							<tr>
    								<td width="180" colspan="2" align="left"><button type="submit" name="change_pass" id="change_pass" class="update_password btn btn-primary" style="margin-left: 220px;"><span class="fa fa-floppy-o" aria-hidden="true"></span> Update Password</button></td>
    							</tr>
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

        $(document).on("click", ".update_password", function(e) {
             //var x = document.getElementById("q").value;
             var CSRF_TOKEN 	= $('meta[name="csrf-token"]').attr('content');
             var user =  {!! json_encode((array)auth()->user()->name) !!};

             var np =  $('input#new_pass').val();
             var cp =  $('input#confirm_pass').val();

            if(np.length > 4 && np == cp){
                $.ajax({
		      url: "{{ url('/settings/update-password') }}"+"/"+user,
		      type: "POST",
		      data: {_token: CSRF_TOKEN,newpassword: np},

		      success: function(response){
		  		console.log(response);
		      	response = JSON.parse(JSON.stringify(response))

		       	tempAlert("Password change",2000);

		      },
		      error: function(){
		      	alert("Error processing request, please try again");
		      }
		    });
		 	
		 	e.preventDefault();

            }else if(np.length < 5){
            	warnAlert("Password should be 5 characters or more",2000);
            }else{
                warnAlert("Password didnot match",2000);
            }
        });       
    });

function tempAlert(msg,duration)

    {
     var el = document.createElement("div");
     el.setAttribute("style","position:fixed;top:50%;left:45%;margin: 0 auto;background-color:#088A08; border: solid thin #01A9DB; border-radius: 3px; padding-left: 15px; padding-right: 15px; padding-top: 6px; padding-bottom: 6px; color: #fff;box-shadow:2px 5px 5px #585858;-moz-box-shadow:2px 5px 5px #585858;-webkit-box-shadow:2px 5px 5px #585858;");
     el.innerHTML = msg;

     setTimeout(function(){
      el.parentNode.removeChild(el);
     },duration);
     document.body.appendChild(el);
     $(el).hide().fadeIn('slow');
    }

function warnAlert(msg,duration)

    {
     var elx = document.createElement("div");
     elx.setAttribute("style","position:fixed;top:50%;left:45%;margin: 0 auto;background-color:#FF0000; border: solid thin #DF0101; border-radius: 3px; padding-left: 25px; padding-right: 25px; padding-top: 12px; padding-bottom: 12px; color: #ffffff;box-shadow:2px 5px 5px #585858;-moz-box-shadow:2px 5px 5px #585858;-webkit-box-shadow:2px 5px 5px #585858;");
     elx.innerHTML = msg;

     setTimeout(function(){
      elx.parentNode.removeChild(elx);
     },duration);
     document.body.appendChild(elx);
     $(elx).hide().fadeIn('slow');
    }
</script>

@endsection