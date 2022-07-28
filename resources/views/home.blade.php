@extends('layouts.master')

@section('content')

<div class="content-wrapper" style="margin-left: 20px;">


<div class="content-wrapper">
    <section class="content-header">
        <div align="center" style="vertical-align: center;">
            {{--<img src="{{ url('/images/MinDA_Official.jpg') }}" alt="1" width="auto" height="auto">--}}

        <div class="card bg-gradient-info">
              <div class="card-header border-0">
              	<div style="height: 35px;" class="card-title" align="left"><span style="font-size: 24px; font-family: Calibri;">INTERNAL DOCUMENTS</span></div>
              </div>
              <div class="card-footer bg-transparent">
                <div class="row">
                  <div class="container-fluid mt-5">
	            <div class="row">
		            <div class="col-lg-3 col-6">
			            <div class="small-box bg-primary">
			              <div class="inner">
			                <h3><i class="fa fa-envelope" style="font-size: 60px;"></i> <span id="internall">0</span></h3>
			                <p>Internal Documents</p>
			              </div>
			              <div class="icon">
			                <i class="ion ion-bag"></i>
			              </div>
			              <a href="{{url('/internal-document-list-view')}}" class="small-box-footer" style="font-size: 18px; font-family: Calibri;">View Details <i class="fa fa-arrow-circle-right"></i></a>
			            </div>
			        </div>

			        <div class="col-lg-3 col-6">
			            <div class="small-box bg-success">
			              	<div class="inner">
			                	<h3><i class="fa fa-envelope" style="font-size: 60px; color: #fff;"></i> <span id="internpending" style="color: #fff;">0</span></h3>
			                	<p style="color: #fff;">Pending</p>
			              	</div>
			              	<div class="icon">
			                	<i class="ion ion-bag"></i>
			              	</div>
			              		<a href="{{ url('/internal-document-list-view/pending') }}" class="small-box-footer" style="color: #fff; font-size: 18px; font-family: Calibri;">View Details <i class="fa fa-arrow-circle-right"></i></a>
			            </div>
			        </div>

			        <div class="col-lg-3 col-6">
			            <div class="small-box btn-warning">
			              <div class="inner">
			                <h3><i class="fa fa-envelope" style="font-size: 60px; color: #fff;"></i> <span id="internapprove"  style="color: #fff;">0</span></h3>

			                <p style="color: #fff;">Approve</p>
			              </div>
			              <div class="icon">
			                <i class="ion ion-bag"></i>
			              </div>
			              <a href="{{ url('/internal-document-list-view/approve') }}" class="small-box-footer" style="font-size: 18px; font-family: Calibri;">View Details <i class="fa fa-arrow-circle-right"></i></a>
			            </div>
			        </div>

			        <div class="col-lg-3 col-6">
			            <div class="small-box btn-danger">
			              <div class="inner">
			                <h3><i class="fa fa-envelope" style="font-size: 60px; color: #fff;"></i> <span id="interndisapprove"  style="color: #fff;">0</span></h3>

			                <p style="color: #fff;">Disapprove</p>
			              </div>
			              <div class="icon">
			                <i class="ion ion-bag"></i>
			              </div>
			              <a href="{{url('/internal-document-list-view/disapprove')}}" class="small-box-footer" style="font-size: 18px; font-family: Calibri;">View Details <i class="fa fa-arrow-circle-right"></i></a>
			            </div>
			        </div>

			    </div>
			</div>
			</div>
            </div>
        </div>
            

       
			<!--2nd row-->
			<div class="card mt-5">
            <div class="card bg-gradient-info border-0">
              <div class="card-header border-0">
              	<div style="height: 35px;" class="card-title" align="left"><span style="font-size: 24px; font-family: Calibri;">EXTERNAL DOCUMENTS</span></div>
              </div>
              <div class="card-footer bg-transparent">
                <div class="row">
                  <div class="container-fluid mt-5">
	            <div class="row">
		            <div class="col-lg-3 col-6">
			            <div class="small-box bg-primary">
			              <div class="inner">
			                <h3><i class="fa fa-envelope" style="font-size: 60px;"></i> <span id="incomnall">0</span></h3>
			                <p>External Documents</p>
			              </div>
			              <div class="icon">
			                <i class="ion ion-bag"></i>
			              </div>
			              <a href="{{url('/external-document-list-view')}}" class="small-box-footer" style="font-size: 18px; font-family: Calibri;">View Details <i class="fa fa-arrow-circle-right"></i></a>
			            </div>
			        </div>

			        <div class="col-lg-3 col-6">
			            <div class="small-box bg-success">
			              	<div class="inner">
			                	<h3><i class="fa fa-envelope" style="font-size: 60px; color: #fff;"></i> <span id="incompending" style="color: #fff;">0</span></h3>
			                	<p style="color: #fff;">Pending</p>
			              	</div>
			              	<div class="icon">
			                	<i class="ion ion-bag"></i>
			              	</div>
			              		<a href="{{ url('/external-document-list-view/pending') }}" class="small-box-footer" style="color: #fff; font-size: 18px; font-family: Calibri;">View Details <i class="fa fa-arrow-circle-right"></i></a>
			            </div>
			        </div>

			        <div class="col-lg-3 col-6">
			            <div class="small-box btn-warning">
			              <div class="inner">
			                <h3><i class="fa fa-envelope" style="font-size: 60px; color: #fff;"></i> <span id="incomapprove"  style="color: #fff;">0</span></h3>

			                <p style="color: #fff;">Approve</p>
			              </div>
			              <div class="icon">
			                <i class="ion ion-bag"></i>
			              </div>
			              <a href="{{ url('/external-document-list-view/approve') }}" class="small-box-footer" style="font-size: 18px; font-family: Calibri;">View Details <i class="fa fa-arrow-circle-right"></i></a>
			            </div>
			        </div>

			        <div class="col-lg-3 col-6">
			            <div class="small-box btn-danger">
			              <div class="inner">
			                <h3><i class="fa fa-envelope" style="font-size: 60px; color: #fff;"></i> <span id="incomdisapprove"  style="color: #fff;">0</span></h3>

			                <p style="color: #fff;">Disapprove</p>
			              </div>
			              <div class="icon">
			                <i class="ion ion-bag"></i>
			              </div>
			              <a href="{{url('/external-document-list-view/disapprove')}}" class="small-box-footer" style="font-size: 18px; font-family: Calibri;">View Details <i class="fa fa-arrow-circle-right"></i></a>
			            </div>
			        </div>

			    </div>
			</div>
			</div>
            </div>
        </div>
		</div>

		
			        <!--3nd row-->
		<div class="card mt-5 mb-5">
            <div class="card bg-gradient-info border-0">
              <div class="card-header border-0">
              	<div style="height: 35px;" class="card-title" align="left"><span style="font-size: 24px; font-family: Calibri;">OUTGOING DOCUMENTS</span></div>
              </div>
              <div class="card-footer bg-transparent">
                <div class="row">
                  <div class="container-fluid mt-5">
	            <div class="row">
		            <div class="col-lg-3 col-6">
			            <div class="small-box bg-primary">
			              <div class="inner">
			                <h3><i class="fa fa-envelope" style="font-size: 60px;"></i> <span id="outall">0</span></h3>
			                <p>Outgoing Documents</p>
			              </div>
			              <div class="icon">
			                <i class="ion ion-bag"></i>
			              </div>
			              <a href="{{url('/outgoing-document-list-view')}}" class="small-box-footer" style="font-size: 18px; font-family: Calibri;">View Details <i class="fa fa-arrow-circle-right"></i></a>
			            </div>
			        </div>

			        <div class="col-lg-3 col-6">
			            <div class="small-box bg-success">
			              	<div class="inner">
			                	<h3><i class="fa fa-envelope" style="font-size: 60px; color: #fff;"></i> <span id="outpending" style="color: #fff;">0</span></h3>
			                	<p style="color: #fff;">Pending</p>
			              	</div>
			              	<div class="icon">
			                	<i class="ion ion-bag"></i>
			              	</div>
			              		<a href="{{ url('/outgoing-document-list-view/pending') }}" class="small-box-footer" style="color: #fff; font-size: 18px; font-family: Calibri;">View Details <i class="fa fa-arrow-circle-right"></i></a>
			            </div>
			        </div>

			        <div class="col-lg-3 col-6">
			            <div class="small-box btn-warning">
			              <div class="inner">
			                <h3><i class="fa fa-envelope" style="font-size: 60px; color: #fff;"></i> <span id="outapprove"  style="color: #fff;">0</span></h3>

			                <p style="color: #fff;">Approve</p>
			              </div>
			              <div class="icon">
			                <i class="ion ion-bag"></i>
			              </div>
			              <a href="{{ url('/outgoing-document-list-view/approve') }}" class="small-box-footer" style="font-size: 18px; font-family: Calibri;">View Details <i class="fa fa-arrow-circle-right"></i></a>
			            </div>
			        </div>

			        <div class="col-lg-3 col-6">
			            <div class="small-box btn-danger">
			              <div class="inner">
			                <h3><i class="fa fa-envelope" style="font-size: 60px; color: #fff;"></i> <span id="outdisapprove"  style="color: #fff;">0</span></h3>

			                <p style="color: #fff;">Disapprove</p>
			              </div>
			              <div class="icon">
			                <i class="ion ion-bag"></i>
			              </div>
			              <a href="{{url('/outgoing-document-list-view/disapprove')}}" class="small-box-footer" style="font-size: 18px; font-family: Calibri;">View Details <i class="fa fa-arrow-circle-right"></i></a>
			            </div>
			        </div>

			    </div>
			</div>
			</div>
            </div>
        </div>
		</div>

		<div style="height: 20px;" class="mb-5"></div>
    </section>

</div>

<script>

    var totapprove = 0;
	var totdisapprove = 0;

	$(document).ready(function () {

	  internal_url = "{{url('/count-internal-docs')}}";

	$.get(internal_url, function (internal_response) {
		            console.log(internal_response);  
		            
		            var internal_r = internal_response.internal_data; 
		            var internal_p = internal_response.internal_cnt_p;
		            var internal_a = internal_response.internal_appr;
		            var internal_d = internal_response.internal_disapp;


		            document.getElementById("internall").innerHTML=internal_r;
		            document.getElementById("internpending").innerHTML=internal_p;
		            document.getElementById("internapprove").innerHTML=internal_a;
		            document.getElementById("interndisapprove").innerHTML=internal_d;

		            totapprove = totapprove+internal_a;
		            totdisapprove = totdisapprove+internal_d;


		      });

		url = "{{url('/count-external-docs')}}";

  	$.get(url, function (response) {
            console.log(response);  
            
            var r = response.data; 
            var p = response.cnt_p;
            var a = response.appr;
            var d = response.disapp;

            document.getElementById("incomnall").innerHTML=r;
            document.getElementById("incompending").innerHTML=p;
            document.getElementById("incomapprove").innerHTML=a;
            document.getElementById("incomdisapprove").innerHTML=d;

            totapprove = totapprove+a;
            totdisapprove = totdisapprove+d;

      });

  outgoing_url = "{{url('/count-outgoing-docs')}}";

  $.get(outgoing_url, function (outgoing_response) {
            console.log(outgoing_response);  
            
            var outgoing_r = outgoing_response.outgoing_data; 
            var outgoing_p = outgoing_response.outgoing_cnt_p;
            var outgoing_a = outgoing_response.outgoing_appr;
            var outgoing_d = outgoing_response.outgoing_disapp;

            document.getElementById("outall").innerHTML=outgoing_r;
            document.getElementById("outpending").innerHTML=outgoing_p;
            document.getElementById("outapprove").innerHTML=outgoing_a;
            document.getElementById("outdisapprove").innerHTML=outgoing_d;

            totapprove = totapprove+outgoing_a;
            totdisapprove = totdisapprove+outgoing_d;



      });

   
            //document.getElementById("totlapprove").innerHTML=totapprove;
   			//document.getElementById("totldisapprove").innerHTML=totdisapprove;

});
</script>
@endsection
