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

<input type="hidden" name="type_input" id="type_input" value="outgoing">
<div class="content-wrapper ml-2" style="width: 115%">
    <div class="row justify-content-center" style="width: 100%">
        <div class="col-md-8">
            <div class="card mt-3">
                <div class="card-header bg-danger" style="font-size: 16px; font-weight: bold; color: #fff;">Outgoing Document Lists</div>
                    <div class="card-body" style="display: flex; justify-content: center;">

                        <section style="width: 100%">
                        <!--Content-->
    						<table style="align-self: center; table-layout: inherit;">
    					
    					        @if($data->count()>0)
                                @foreach($data as $d)
                                
                                @endforeach
                                @endif
    							
                                @if($d->confi_name == Auth::user()->f_name && $d->classification == 1)
                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Document Date</td>
                                            <td align="left" >{{date('M d, Y', strtotime($d->doc_receive))}}</td>

                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Briefer #</td>
                                             <td align="left" >{{$d->briefer_number}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Barcode</td>
                                            <td align="left" >{{$d->barcode}}</td>

                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Sender</td>
                                            <td align="left" >{{$d->agency}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Receiver</td>
                                            <td align="left" >{{$d->sendto}}</td>
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Addressee</td>
                                            <td align="left" >{{$d->signatory}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Document Title</td>
                                            <td colspan="3" align="left" style="white-space: pre-wrap;">{{$d->doctitle}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Description</td>
                                            <td align="left" style="white-space: pre-wrap;">{{ $d->description }}</td>
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Mode of Release</td>
                                            <td align="left" >{{$d->releasemode}}</td>
                                        </tr>

                                    </table>
                                       <table style="width: 100%;" class="mt-4">
                                       <tr>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Forwarded to</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Date Forwarded</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Status</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">No. of Days</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Action Taken</td>
                                       </tr>
                                       @if($data->count()>0)
                                        @foreach($data as $d)
                                        <tr class="border_bottom">
                                            <td align="center" >{{$d->department}}</td>
                                            <td align="left" >{{ date('F j, Y', strtotime($d->date_ff)) }}</td>
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
                                            <td colspan="4" align="center" style="font-size: 30px !important; color: #ff0000; font-style: bold !important;">Oppppsss!! This document is not for you!!!</td>
                                        </tr>

                                    @elseif(Auth::user()->access_level != 5 && $d->confi_name == Auth::user()->f_name && $d->classification != 1)
    
                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Document Date</td>
                                            <td align="left" >{{date('M d, Y', strtotime($d->doc_receive))}}</td>

                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Briefer #</td>
                                             <td align="left" >{{$d->briefer_number}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Barcode</td>
                                            <td align="left" >{{$d->barcode}}</td>

                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Sender</td>
                                            <td align="left" >{{$d->agency}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Receiver</td>
                                            <td align="left" >{{$d->sendto}}</td>
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Addressee</td>
                                            <td align="left" >{{$d->signatory}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Document Title</td>
                                            <td colspan="3" align="left" style="white-space: pre-wrap;">{{$d->doctitle}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Description</td>
                                            <td align="left" style="white-space: pre-wrap;">{{ $d->description }}</td>
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Mode of Release</td>
                                            <td align="left" >{{$d->releasemode}}</td>
                                        </tr>

                                    </table>
                                       <table style="width: 100%;" class="mt-4">
                                       <tr>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Forwarded to</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Date Forwarded</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Status</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">No. of Days</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Action Taken</td>
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

                                    @elseif(Auth::user()->access_level != 5 && $d->confi_name != Auth::user()->f_name && $d->classification != 1)
                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Document Date</td>
                                            <td align="left" >{{date('M d, Y', strtotime($d->doc_receive))}}</td>

                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Briefer #</td>
                                             <td align="left" >{{$d->briefer_number}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Barcode</td>
                                            <td align="left" >{{$d->barcode}}</td>

                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Sender</td>
                                            <td align="left" >{{$d->agency}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Receiver</td>
                                            <td align="left" >{{$d->sendto}}</td>
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Addressee</td>
                                            <td align="left" >{{$d->signatory}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Document Title</td>
                                            <td colspan="3" align="left" style="white-space: pre-wrap;">{{$d->doctitle}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Description</td>
                                            <td align="left" style="white-space: pre-wrap;">{{ $d->description }}</td>
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Mode of Release</td>
                                            <td align="left" >{{$d->releasemode}}</td>                                        </tr>

                                    </table>
                                       <table style="width: 100%;" class="mt-4">
                                       <tr>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Forwarded to</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Date Forwarded</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Status</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">No. of Days</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Action Taken</td>
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
                                        
                                    @endif

                                    @if(Auth::user()->access_level == 5)
                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Document Date</td>
                                            <td align="left" >{{date('M d, Y', strtotime($d->doc_receive))}}</td>

                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Briefer #</td>
                                             <td align="left" >{{$d->briefer_number}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Barcode</td>
                                            <td align="left" >{{$d->barcode}}</td>

                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Sender</td>
                                            <td align="left" >{{$d->agency}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Receiver</td>
                                            <td align="left" >{{$d->sendto}}</td>
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Addressee</td>
                                            <td align="left" >{{$d->signatory}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Document Title</td>
                                            <td colspan="3" align="left" style="white-space: pre-wrap;">{{$d->doctitle}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Description</td>
                                            <td align="left" style="white-space: pre-wrap;">{{ $d->description }}</td>
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Mode of Release</td>
                                            <td align="left" >{{$d->releasemode}}</td>
                                        </tr>

                                    </table>
                                       <table style="width: 100%;" class="mt-4">
                                       <tr>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Forwarded to</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Date Forwarded</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Status</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">No. of Days</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Action Taken</td>
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
                                            <td colspan="6"><button onclick="export_excel();" class="btnExport btn btn-medium btn-success" style="font-size: 12px; float: left;"><i class="fa fa-file-excel-o"></i> Export to Excel</button><a href="{{ url('/outgoing-document-new-entry') }}" style="font-size: 12px; float: right;" class="btn btn-medium btn-danger"><i class="fa fa-edit"></i> New Outgoing Entry</a></td>
                                            
                                        </tr>
                                    @endif
    						</table>

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

     function export_excel()
    {

        var url = window.location.pathname;
        var arr = (window.location.pathname).split("/");
        //var id = (arr[arr.length-2]);
        var id = (arr[arr.length-1]);
        

        //alert(id);
        window.location = "{{ url('/export-excel-outgoing/excel-file-report/document-tracking') }}/"+id;
    }
</script>
@endsection