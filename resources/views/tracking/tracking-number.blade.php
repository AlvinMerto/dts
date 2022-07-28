@extends('layouts.master')

@section('content')

<script src="{{ asset('js/dropzone/dropzone.js') }}" defer></script>
<link rel="stylesheet" href="{{ asset('css/dropzone/dropzone.css')}}">

<script>
        $(document).ready(function() {
            var msg = '{{Session::get('alert')}}';
            var exist = '{{Session::has('alert')}}';
            if(exist){
                setTimeout(function () { 

                    alert(msg); 

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

});
</script>

<input type="hidden" name="type_input" id="type_input" value="tracking">
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info" style="font-size: 16px; font-weight: bold; color: #fff;">Tracking Numbers</div>
                <div class="card-body" style="display: flex; justify-content: center;">
                    <!-- content --> 

                    <section style="width: 100%">

                    <table>
                        <tr>
                            <td class="d-flex">
                                <div class="sidebar-form" style="width: 200px; margin-left: 5px;">
                                    <div class="input-group">
                                         <input list="datelist" placeholder="Filter" name="ff_type" id="ff_type" class="form-control">
                                        <span class="input-group-btn">
                                            <button type="submit" name="search" id="search-btn-date" class="searchbtn-doc-type btn btn-flat" >
                                              <i class="fa fa-filter"></i>
                                            </button>
                                        </span>
                                            <datalist id="datelist">
                                                <option value="Internal" selected="selected">Internal</option>
                                                <option value="External">External</option>
                                            </datalist>
                                    </div>
                                </div>
                                <div class="sidebar-form" style="width: 200px; margin-left: 5px;">
                                    <div class="input-group">
                                         <input list="datalist" placeholder="Search" name="q" id="q" class="form-control">
                                        <span class="input-group-btn">
                                            <button type="submit" name="search" id="search-btn-barcode" class="searchbtn-barcode btn btn-flat" >
                                              <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                            <datalist id="datalist">
                                                @if($data->count()>0)
                                                @foreach($data as $t)
                                                    <option value="{{$t->barcode}}">
                                                @endforeach
                                                @endif
                                            </datalist>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    </table>
                    

                    <table style="align-self: center; table-layout: inherit;">
                        <tr class="border_bottom">
                            <td align="center" style="padding: 10px; background-color: #3b5998; color: #fafafa; font-weight: bold; border-bottom: solid 1px #f2f2f2 !important;">Tracking/Barcode Number</td>
                            {{--<td align="center" style="padding: 10px; background-color: #3b5998; color: #fafafa; font-weight: bold; border-bottom: solid 1px #f2f2f2 !important;">Barcode</td>--}}
                            <td align="center" style="padding: 10px; background-color: #3b5998; color: #fafafa; font-weight: bold; border-bottom: solid 1px #f2f2f2 !important;">Document Category/Type</td>
                            <td align="center" style="padding: 10px; background-color: #3b5998; color: #fafafa; font-weight: bold; border-bottom: solid 1px #f2f2f2 !important;" 
                                    >Description</td>
                            <td align="center" style="padding: 10px; background-color: #3b5998; color: #fafafa; font-weight: bold; border-bottom: solid 1px #f2f2f2 !important;">Document Source</td>
                                    
                        </tr>

                        @if($data->count()>0)
                        @foreach($data as $t)
                        <tr>
                            {{--<td style="padding: 10px; color: #0B173B; font-weight: bold; border-bottom: solid 1px #e6e6e6 !important;"><a href="javascript:void(0);" id="{{$t->id}}" class="viewtrack"> {{$t->tracking_series}}</a></td>--}}
                            <td style="padding: 10px; color: #0B173B; font-weight: bold; border-bottom: solid 1px #e6e6e6 !important;"><a href="javascript:void(0);" id="{{$t->id}}" class="viewtrack">{{$t->barcode}}</a></td>
                            <td style="padding: 10px; color: #151515; font-weight: normal; border-bottom: solid 1px #e6e6e6 !important;">{{$t->doctitle}}</td>
                            <td style="padding: 10px; color: #151515; font-weight: normal; border-bottom: solid 1px #e6e6e6 !important;">{{$t->docdescription}}</td>
                            <td style="padding: 10px; color: #151515; font-weight: normal; border-bottom: solid 1px #e6e6e6 !important;">{{$t->doctype}}</td>

                        </tr>
                        @endforeach
                        @endif
                        <tr>
                            <td colspan="5" style="padding: 20px;"></td>
                        </tr>
                    </table>


                    <!-- content end -->
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
        var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');

        $(document).on("click", ".viewtrack", function(e) {
            var x_id        =   this.id;

            //alert('Edit Clicked '+x_id);
            
             $.ajax({
                url: "{{ url('/document-tracking-details') }}/"+x_id,
                type: "GET",
                data: {_token: CSRF_TOKEN,_id: x_id},

                success: function(response){
                    console.log(response);

                    var r_id = response.data[0].ref_id;
                    var d_type = response.data[0].doctype;

                    if(d_type == 'External'){
                        
                        window.location.href="{{ url('/external-document-track-list-view/view-document-tracking') }}"+"/"+r_id;
                        
                    }else{
                        window.location.href="{{url('internal-document-track-list-view/view-document-tracking')}}"+"/"+r_id;
                    }
                    
                  },
                  error: function(ex){
                    alert(JSON.stringify(ex));
                  },
                });
                e.preventDefault();
            
            
            
        });       


        $(document).on("click", ".searchbtn-barcode", function(e) {
            var x_id        =   this.id;
            var track_id    =   $('input#q').val();

            //alert('Edit Clicked '+track_id);
            
             $.ajax({
                url: "{{ url('/document-tracking-number') }}/"+track_id,
                type: "GET",
                data: {_token: CSRF_TOKEN,_id: track_id},

                success: function(response){
                    console.log(response);

                    var r_id = response.data[0].ref_id;
                    var d_type = response.data[0].doctype;

                    if(d_type == 'External'){
                        
                        window.location.href="{{ url('/external-document-track-list-view/view-document-tracking') }}"+"/"+r_id;
                        
                    }else{
                        window.location.href="{{url('internal-document-track-list-view/view-document-tracking')}}"+"/"+r_id;
                    }
                    
                  },
                  error: function(ex){
                    alert(JSON.stringify(ex));
                  },
                });
                e.preventDefault();
            
            
            
        });       
    });

$(document).ready(function() {

        $(document).on("click", ".searchbtn-doc-type", function() {
             //var x = document.getElementById("q").value;

             var x =  $('input#ff_type').val();

            if(x.length > 0){
                window.location = "{{ url('/tracking-numbers/filter-type') }}/" + x
            }else{
                warnAlert("Search criteria is empty",2000);
            }
        });       
    });
</script>
@endsection