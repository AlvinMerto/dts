@extends('layouts.master')

@section('content')

<input type="hidden" name="type_input" id="type_input" value="library">
<div class="content-wrapper ml-2" style="width: 115%">
    <div class="row justify-content-center" style="width: 100%">
        <div class="col-md-8">
            <div class="card mt-3">
                <div class="card-header bg-warning" style="font-size: 16px; font-weight: bold; color: #434243;">BARCODE RESULT</div>
                    <div class="card-body" style="display: flex; justify-content: center;">

                        <section style="width: 100%">
                        	<!--Content-->

								<div>
									<input type="text" name="barcode" id="barcode" value="">
								</div>

	                        <!--Content End-->
                        </section>
                    </div>

                
            </div>
        </div>
    </div>
</div>



@endsection