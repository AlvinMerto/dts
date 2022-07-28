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

<style type="text/css">
.img-grid {
    position: relative;
    width: 205;
    margin: 0 auto;
}
  
.img-grid ul {
    display: block;
    list-style: none;
    padding: 0;
    margin: 0;
}

.img-grid ul > li {
    display: block;
    float: left;
    list-style: none;
    border: solid 1px #3b5998;
    padding: 10px;
    margin: 10px;
    margin-bottom: 50px;
}


.img-grid ul > li:nth-child(4n+4) {
    clear: right;
}

.img-grid li img {
    display: block;
    width: 100%;
    min-width: 100%;
    border: 0;
}
</style>

<input type="hidden" name="type_input" id="type_input" value="internal">
<div class="content-wrapper ml-2" style="width: 115%">
    <div class="row justify-content-center" style="width: 100%">
        <div class="col-md-8">
            <div class="card mt-3">
                <div class="card-header bg-primary" style="font-size: 16px; font-weight: bold; color: #fff;">Internal Document Lists</div>
                    <div class="card-body" style="display: flex; justify-content: center;">

                        <section style="width: 100%">
                        <!--Content-->
    						<table style="align-self: center; table-layout: inherit;">
    							<tr class="border_bottom">
                                    <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Document Date</td>
                                    <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Briefer #</td>
    								<td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Barcode</td>
    								<td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Document Category</td>
    								<td colspan="2" align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;" 
    								>Description</td>
    								<td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Office/Division</td>
    							</tr>
    					        @if($data->count()>0)
                                @foreach($data as $d)
                                
                                @endforeach
                                @endif
    							
                                    @if($d->confi_name == Auth::user()->f_name && $d->classification == 1)
                                        <tr class="border_bottom">
                                            <td align="center" >{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                            <td align="center" >{{$d->briefer_number}}</td>
                                            <td align="center" >{{$d->barcode}}</td>
                                            <td align="left" style="white-space: pre-wrap;">{{$d->doctitle}}</td>
                                            <td colspan="2" align="left" style="white-space: pre-wrap;">{{ $d->description }}</td>
                                            <td align="center" >{{$d->agency}}</td>
                                        </tr>
                                        <tr>
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Briefer Number</td>
                                            <td colspan="2" align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Document Type</td>

                                            <td colspan="4" align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Signatory</td>
                                        </tr>
                                        <tr class="border_bottom">
                                            <td align="center" >{{$d->briefer_number}}</td>
                                            <td colspan="2" align="center" >{{$d->type}}</td>
                                            <td colspan="4" align="center" >{{$d->signatory}}</td>
                                        </tr> 
                                    </table>
                                       <table style="width: 100%;" class="mt-4">
                                       <tr>
                                           <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Forwarded to</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Date Forwarded</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Status</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">No. of Days</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Action Taken</td>
                                       </tr>
                                       @if($data->count()>0)
                                        @foreach($data as $d)
                                        <tr class="border_bottom">
                                            <td align="center" >{{$d->destination}}</td>
                                            <td align="left" >{{ $d->date_forwared }}</td>
                                            <td align="left" style="white-space: pre-wrap;">{{ $d->stat }}</td>
                                            <td align="center" >{{$d->days_count}}</td>
                                            <td align="left" style="white-space: pre-wrap;">{!! nl2br($d->remarks) !!}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        <input type="hidden" name="img_src" id="img_src" value="{{ url('/uploads') }}/{{ $d->image }}">
                                        <tr>
                                            <td colspan="5" align="center" >
                                                <a href="{{ url('/uploads') }}/{{ $d->image }}" data-lightbox="{{ $d->image }}" data-title="" style="text-decoration: none; margin-right: 10px; color: #fff;">
                                                    <div id="image-holder" class="photo-container" style="float: right; display: none;"><img id="image" class="photo-info ml-5 mt-1" src="" style="height: 105px; border: 1px solid #08298A; margin: 5px;box-shadow:2px 5px 5px #585858;-moz-box-shadow:2px 5px 5px #585858;-webkit-box-shadow:2px 5px 5px #585858;"/></div><br>
                                                    <div id="err"></div>
                                                </a>
                                            </td>
                                        </tr>
                                    @elseif(Auth::user()->access_level == 5)
                                        <tr class="border_bottom">
                                            <td align="center" >{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                            <td align="center" >{{$d->briefer_number}}</td>
                                            <td align="center" >{{$d->barcode}}</td>
                                            <td align="left" style="white-space: pre-wrap;">{{$d->doctitle}}</td>
                                            <td colspan="2" align="left" style="white-space: pre-wrap;">{{ $d->description }}</td>
                                            <td align="center" >{{$d->agency}}</td>
                                        </tr>
                                        <tr>
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Briefer Number</td>
                                            <td colspan="2" align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Document Type</td>

                                            <td colspan="4" align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Signatory</td>
                                        </tr>
                                        <tr class="border_bottom">
                                            <td align="center" >{{$d->briefer_number}}</td>
                                            <td colspan="2" align="center" >{{$d->type}}</td>
                                            <td colspan="4" align="center" >{{$d->signatory}}</td>
                                        </tr> 
                                    </table>
                                       <table style="width: 100%;" class="mt-4">
                                       <tr>
                                           <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Forwarded to</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Date Forwarded</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Status</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">No. of Days</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Action Taken</td>
                                       </tr>
                                       @if($data->count()>0)
                                        @foreach($data as $d)
                                        <tr class="border_bottom">
                                            <td align="center" >{{$d->destination}}</td>
                                            <td align="left" >{{ $d->date_forwared }}</td>
                                            <td align="left" style="white-space: pre-wrap;">{{ $d->stat }}</td>
                                            <td align="center" >{{$d->days_count}}</td>
                                            <td align="left" style="white-space: pre-wrap;">{!! nl2br($d->remarks) !!}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        <input type="hidden" name="img_src" id="img_src" value="{{ url('/uploads') }}/{{ $d->image }}">
                                        <tr>
                                            <td colspan="5" align="center" >
                                                <a href="{{ url('/uploads') }}/{{ $d->image }}" data-lightbox="{{ $d->image }}" data-title="" style="text-decoration: none; margin-right: 10px; color: #fff;">
                                                    <div id="image-holder" class="photo-container" style="float: right; display: none;"><img id="image" class="photo-info ml-5 mt-1" src="" style="height: 105px; border: 1px solid #08298A; margin: 5px;box-shadow:2px 5px 5px #585858;-moz-box-shadow:2px 5px 5px #585858;-webkit-box-shadow:2px 5px 5px #585858;"/></div><br>
                                                    <div id="err"></div>
                                                </a>
                                            </td>
                                        </tr>
                                    @elseif($d->confi_name!= Auth::user()->f_name && $d->classification == 1)
                                        <tr>
                                            <td colspan="7" align="center" style="font-size: 30px !important; color: #ff0000; font-style: bold !important;">Oppppsss!! This document is not for you!!!</td>
                                        </tr>

                                    @elseif($d->confi_name != Auth::user()->f_name && $d->classification != 1)
                                        <tr class="border_bottom">
                                            <td align="center" >{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                            <td align="center" >{{$d->briefer_number}}</td>
                                            <td align="center" >{{$d->barcode}}</td>
                                            <td align="left" style="white-space: pre-wrap;">{{$d->doctitle}}</td>
                                            <td colspan="2" align="left" style="white-space: pre-wrap;">{{ $d->description }}</td>
                                            <td align="center" >{{$d->agency}}</td>
                                        </tr>
                                        <tr>
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Briefer Number</td>
                                            <td colspan="2" align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Document Type</td>

                                            <td colspan="4" align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Signatory</td>
                                        </tr>
                                        <tr class="border_bottom">
                                            <td align="center" >{{$d->briefer_number}}</td>
                                            <td colspan="2" align="center" >{{$d->type}}</td>
                                            <td colspan="4" align="center" >{{$d->signatory}}</td>
                                        </tr>
                                       </table>
                                       <table style="width: 100%;" class="mt-4">
                                       <tr>
                                           <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Forwarded to</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Date Forwarded</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Status</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">No. of Days</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 16px !important;">Action Taken</td>
                                       </tr>
                                       @if($data->count()>0)
                                        @foreach($data as $d)
                                        <tr class="border_bottom">
                                            <td align="center" >{{$d->destination}}</td>
                                            <td align="left" >{{$d->date_forwared}}</td>
                                            <td align="left" style="white-space: pre-wrap;">{{ $d->stat }}</td>
                                            <td align="center" >{{$d->days_count}}</td>
                                            <td align="left" style="white-space: pre-wrap;">{!! nl2br($d->remarks) !!}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        <input type="hidden" name="img_src" id="img_src" value="{{ url('public/uploads') }}/{{ $d->image }}">
                                        {{--
                                        <tr>
                                            
                                                <td><a href="{{ url('/internal-document-new-entry') }}" style="font-size: 12px;" class="btn btn-medium btn-primary"><i class="fa fa-edit"></i> New Internal Entry</a></td>
                                        

                                            <td colspan="4" align="center" >
                                                <a href="{{ url('public/uploads') }}/{{ $d->image }}" data-lightbox="{{ $d->image }}" data-title="" style="text-decoration: none; margin-right: 10px; color: #fff;">
                                                    <div id="image-holder" class="photo-container" style="float: right; display: none;">

                                                       <img id="image" class="photo-info ml-5 mt-1" src="" style="height: 105px; border: 1px solid #08298A; margin: 5px;box-shadow:2px 5px 5px #585858;-moz-box-shadow:2px 5px 5px #585858;-webkit-box-shadow:2px 5px 5px #585858;"/>
                                                    <iframe src="{{ url('public/uploads') }}/{{ $d->image }}" style="width: 100%;height: 100%;border: none;"></iframe>
                                                   
                                                    
                                                    <object data="{{ url('public/uploads') }}/{{ $d->image }}" height="105" id="image" class="photo-info ml-5 mt-1">
                                                        <a href="{{ url('/uploads') }}/{{ $d->image }}">{{ $d->image }}</a>
                                                    </object>
                                                   
                                                    <br>

                                                    <a href="{{ url('public/uploads') }}/{{ $d->image }}" target="blank">
                                                        <i class="fa fa-search-plus" aria-hidden="true"><span style="font-family: calibri;"> Full view</span></i>
                                                    </a>
                                                    </div><br>


                                                    <div id="err"></div>
                                                </a>
                                            </td>
                                        </tr>
                                        --}}

                                        
                                        
                                        
                                    @endif

                                    @if(Auth::user()->access_level == 5)
                                    <tr>
                                        
                                        <td colspan="6"><a href="{{ url('/internal-document-new-entry') }}" style="font-size: 12px; float: right;" class="btn btn-medium btn-primary"><i class="fa fa-edit"></i> New Internal Entry</a></td>

                                    </tr>
                                    @endif
    						</table>

                            @if($d->confi_name == Auth::user()->f_name && $d->classification == 1)
                                <div><span class="fa fa-paperclip"></span> Attachments</div>
                                @if($docimages->count()>0)
                                @foreach($docimages as $img)
                                <div class="img-grid">
                                    <ul class="photos-gallery-layout">
                                         <li class="photos-gallery-li">
                                            <div class="photo">
                                                <object data="{{ url('public/uploads') }}/{{ $img->img_file }}" type="application/pdf" height="105">
                                                <iframe  src="{{ url('public/uploads') }}/{{ $img->img_file }}&embedded=true"></iframe>
                                                </object><br>
                                                <a href="{{ url('public/uploads') }}/{{ $img->img_file }}" target="blank">
                                                    <i class="fa fa-search-plus" aria-hidden="true"><span style="font-family: calibri;"> Full view</span></i>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>

                                </div>

                            @endforeach
                            @endif

                            @elseif($d->classification != 1)
                                <div><span class="fa fa-paperclip"></span> Attachments</div>
                                @if($docimages->count()>0)
                                @foreach($docimages as $img)
                                <div class="img-grid">
                                    <ul class="photos-gallery-layout">
                                         <li class="photos-gallery-li">
                                            <div class="photo">
                                                <object data="{{ url('public/uploads') }}/{{ $img->img_file }}" type="application/pdf" height="105">
                                                <iframe  src="{{ url('public/uploads') }}/{{ $img->img_file }}&embedded=true"></iframe>
                                                </object><br>
                                                <a href="{{ url('public/uploads') }}/{{ $img->img_file }}" target="blank">
                                                    <i class="fa fa-search-plus" aria-hidden="true"><span style="font-family: calibri;"> Full view</span></i>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>

                                </div>

                            @endforeach
                            @endif

                            @endif

<!--Content End-->
                        </section>
                    </div>

                
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        //$(document).ajaxComplete(function () {
           //function PreviewImage() {

            var img = $('input#img_src').val();
            //document.getElementById("image-holder").style.display = "block";

            $(".photo-container").animate({
                opacity: 0.10,
            }, 200, function () {
                    
                    $(".photo-info").attr("src",img);
                }).animate({ opacity: 1 }, 2000);

                $("#container").height($(document).height());

});
</script>
@endsection