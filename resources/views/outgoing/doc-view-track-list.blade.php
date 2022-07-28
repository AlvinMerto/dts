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
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF; width: 40%;">Forwarded to</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Date Forwarded</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF; width: 6%;">Status</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">No. of Days</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF; width: 10%;">Action</td>
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
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF; width: 40%;">Forwarded to</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Date Forwarded</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF; width: 6%;">Status</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">No. of Days</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF; width: 10%;">Action</td>
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
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF; width: 40%;">Forwarded to</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Date Forwarded</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF; width: 6%;">Status</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">No. of Days</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF; width: 10%;">Action</td>
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
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF; width: 40%;">Forwarded to</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Date Forwarded</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF; width: 6%;">Status</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">No. of Days</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF; width: 10%;">Action</td>
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
                                            @if(Auth::user()->access_level == 5)
                                            <td colspan="5">
                                                <button onclick="export_excel();" class="btnExport btn btn-medium btn-success" style="font-size: 12px; float: left;"><i class="fa fa-file-excel-o"></i> Export to Excel</button>    
                                                <a href="{{ url('/outgoing-document-new-entry') }}" style="font-size: 12px; float: right;" class="btn btn-medium btn-primary"><i class="fa fa-edit"></i> New Outgoing Entry</a>

                                                <button id="{{$d->ref_id}}" class="btn-ff btn btn-danger pl-3 pr-3" style="font-size: 12px; float: right; margin-right: 10px;"><span class="fa fa-exclamation-triangle" aria-hidden="true"></span> Action</button>

                                                <a href="{{url('/outgoing-document-list-view')}}" style="font-size: 12px; float: right; margin-right: 10px;" class="btn btn-medium btn-info"><i class="fa fa-chevron-left"></i> Back</a>
                                            </td>
                                        @else
                                            <td colspan="5"><button onclick="export_excel();" class="btnExport btn btn-medium btn-success" style="font-size: 12px; float: left;"><i class="fa fa-file-excel-o"></i> Export to Excel</button>
                                                <a href="{{url('/outgoing-document-list-view')}}" style="font-size: 12px; float: right;" class="btn btn-medium btn-success"><i class="fa fa-edit"></i> Back</a>
                                        @endif
                                            
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


<!-- Forward Modal -->

<div class="modal fade" id="doc-ff" tabindex="-1" role="dialog"aria-labelledby="ff-modal-label" aria-hidden="true">
  <div class="modal-dialog  modal-lg" style="min-width: auto; max-width: 50%"  role="document">
    <div class="modal-content">
      <div class="modal-header"><span style="font-size: 24px; color: #FF4000; text-align: center;"><strong>DOCUMENT TRACKING SYSTEM</strong></span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <span id="form_result"></span>
            <table width="100%" style="table-layout:fixed;border-collapse: collapse;">
                <th colspan="2" style="font-size: 20px; color: #0B3861;" align="center" class="text-center">Select Division to forward this document</th>
                <tr>
                    <td colspan="2" align="center" class="p-3" style="border-bottom: none; background: #F2F2F2">

                        <input list="division" placeholder="Division" name="ff_divisions" id="ff_divisions" class="form-control" style="width: 200px;" onchange="getUserList(this);">
                        <datalist id="division">
                            @if($div->count()>0)
                            @foreach($div as $l)
                                <option value="{{ $l->division }}">
                            @endforeach
                            @endif
                        </datalist>

                        <input type="hidden" id="optselect" name="optselect">
                    </td>
                
                    <input type="hidden" id="_id" name="_id" value="">
                    <input type="hidden" id="person" name="person" value="">

                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input list="userlist" placeholder="MinDA Employee" name="ff_employees" id="ff_employees" class="form-control" style="width: 200px;">
                            <datalist id="userlist">
                                @if($userlist->count()>0)
                                    @foreach($userlist as $l)
                                        <option value="{{ $l->f_name }}">
                                    @endforeach
                                @endif
                            </datalist>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <span style="font-style: italic;">"Note: double-click the box or down arrow to show the list"</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="font-weight: bold; font-size: 18px !important; color: #DF0101; border-top: 1px solid #0080FF;" align="center">Action</td>
                </tr>
                <tr>
                    <td colspan="2" align="center" style="border-bottom: 1px solid #0080FF; word-wrap: break-word;" >
                        <input type="checkbox" name="for_appro_action" id="for_appro_action" style="vertical-align: text-bottom;"><b> for appropriate action </b>&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="for_info" id="for_info" style="vertical-align: text-bottom; font-weight: bold;"><b> for information </b>&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="for_reference" id="for_reference" style="vertical-align: text-bottom; font-weight: bold;"><b> for reference </b><br><br>
                        <input type="checkbox" name="for_guidance" id="for_guidance" style="vertical-align: text-bottom; font-weight: bold;"><b> for guidance</b>&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="for_review" id="for_review" style="vertical-align: text-bottom;"><b> for review and evaluation</b> &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="for_signature" id="for_signature" style="vertical-align: text-bottom;"><b> for approval/signature</b> &nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
                <td colspan="2" align="center" class="p-3" style="border-bottom: none; background: #F2F2F2">
                        <label for="remarks" >Other Action</label><br>
                        <textarea id="remarks" name="remarks" rows="3" style="width: 80%; max-width: 100%;" placeholder="Other Action"></textarea>
                    </td>

                
                <tr>
                
                    <td valign="middle" class="d-flex mt-1">
                        <select class="form-control" id="docclassification" name="docclassification" style="width: 130px;">
                        </select>

                    </td>
               

                    {{--<input type="hidden" id="completedoc" name="completedoc" value="{{$data[0]->retdoc}}">--}}

                    <td class="p-3" style="border-top: solid thin #fff;"><span style="float: right;" class="mr-3">
                        @if(Auth::user()->access_level==4)

                            <a href="javascript:void(0);" class="go_approve btn btn-small btn-info mr-3"><span class="fa fa-smile-o" aria-hidden="true"></span> Approve</a>

                            <a href="javascript:void(0);" class="go_disapprove btn btn-small btn-danger mr-3"><span class="fa fa-frown-o" aria-hidden="true"></span> Disapprove</a>
                        @endif

                        <a href="javascript:void(0);" class="go_complete btn btn-small btn-primary mr-3"><span class="fa fa-check-square-o" aria-hidden="true"></span> Complete</a>
           
                        <a href="javascript:void(0);" class="go_btn btn btn-small btn-success"><span class="fa fa-share-square-o" aria-hidden="true"></span> Forward</a>

                    </span></td>
                </tr>
                <tr id="busywait" style="display: none;">
                    <td colspan="2" align="center"><span style="color: #3A01DF;"><img src="{{ url('/images/busy_wait.gif') }}" height="40px">
                        <b>Sending mails... Please wait...</b></span>
                    </td>
                </tr>

            </table>
            <div class="modal-footer">

      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {

        $(document).on("click", ".btn-ff", function() {
            var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
            var id   = $(this).attr("id"); 
            var alvel = $('input#q_user_level').val(); 

            $.ajax({
                url: "{{ url('/outgoing-document/document-return-category') }}/"+id,
                type: "GET",
                data: {_token: CSRF_TOKEN,_id: id},

                success: function(response){
                    console.log(response);

                    $('input#completedoc').val(response.data[0].retdoc);

                    var $dropdown = $('#docclassification');
                    var cls = response.data[0].classification;

                        if(cls==1){
                            $dropdown.append($("<option selected/>").val('1').text('Confidential'));
                            $dropdown.append($("<option />").val('2').text('High Priority'));
                            $dropdown.append($("<option />").val('3').text('Moderate Priority'));
                            $dropdown.append($("<option />").val('4').text('Low Priority'));
                            $dropdown.append($("<option />").val('5').text('Undefined'));
                        }else if(cls==2){
                            $dropdown.append($("<option />").val('1').text('Confidential'));
                            $dropdown.append($("<option selected/>").val('2').text('High Priority'));
                            $dropdown.append($("<option />").val('3').text('Moderate Priority'));
                            $dropdown.append($("<option />").val('4').text('Low Priority'));
                            $dropdown.append($("<option />").val('5').text('Undefined'));
                        }else if(cls==3){
                            $dropdown.append($("<option />").val('1').text('Confidential'));
                            $dropdown.append($("<option />").val('2').text('High Priority'));
                            $dropdown.append($("<option selected/>").val('3').text('Moderate Priority'));
                            $dropdown.append($("<option />").val('4').text('Low Priority'));
                            $dropdown.append($("<option />").val('5').text('Undefined'));
                        }else if(cls==4){
                            $dropdown.append($("<option />").val('1').text('Confidential'));
                            $dropdown.append($("<option />").val('2').text('High Priority'));
                            $dropdown.append($("<option />").val('3').text('Moderate Priority'));
                            $dropdown.append($("<option selected/>").val('4').text('Low Priority'));
                            $dropdown.append($("<option />").val('5').text('Undefined'));
                        }else{
                            $dropdown.append($("<option />").val('1').text('Confidential'));
                            $dropdown.append($("<option />").val('2').text('High Priority'));
                            $dropdown.append($("<option />").val('3').text('Moderate Priority'));
                            $dropdown.append($("<option />").val('4').text('Low Priority'));
                            $dropdown.append($("<option selected/>").val('5').text('Undefined'));
                        }
                    
                    $('input#_id').val(id);

                    if(response.data[0].retdoc == 1 && alvel != 5){
                        //document.getElementsByClassName('go_complete').style.display='none';
                        document.querySelector('.go_complete').style.display='none';
                    }

                    $('#doc-ff').modal('show');
                    
                  },
                  error: function(ex){
                    //alert(JSON.stringify(ex));
                    window.location.href="{{ url('/home') }}";
                  },
                });
            setTimeout(function (){
                $('input#ff_divisions').focus();
                
            }, 1000);
        });       
    });

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

    function checkClass() {
    //var e = document.getElementById("docclassification");
    var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
    var e           =   $("#docclassification :selected").val();
    var x_id        =   $('input#_id').val();
    var doctype     =   $('select#docclassification').val();
    var dept        =   $('input#ff_divisions').val();

    //if(dept.length === 0){
    //        alert("Please specify the Division first");
    //}else{
        /*
        if(e > 3){
            document.getElementById("ff_employees").disabled = true;
            document.getElementById("ff_employees").value="";
        }else{
                document.getElementById("ff_employees").disabled = false;
        }

        */
            $.ajax({
                url: "{{ url('/outgoing-documents/docclass') }}/"+x_id,
                type: "POST",
                data: {_token: CSRF_TOKEN,_id: x_id,docclass: doctype},

                    success: function(response){
                        console.log(response);

                        //tempAlert("Autosaving....",2000);
                        swal({
                              position: 'center',
                              icon: 'info',
                              title: 'Autosaving....Please refresh the page...',
                              showConfirmButton: false,
                              timer: 1500
                            });

                            //$('#doc-ff').modal('hide');
                            //window.location.href="{{ url('/outgoing-document-list-view') }}";
                    },
                        error: function(ex){
                        //alert(JSON.stringify(ex));
                        window.location.href="{{ url('/home') }}";
                    },
            }); 
        //}

        //alert(x_id);
}

  n =  new Date();
    y = n.getFullYear();
    m = n.getMonth() + 1;
    d = n.getDate();

    var months = ["January","February","March","April","May","June","July","August","September","October","November","December"];

    //document.getElementById("date").innerHTML = months[n.getMonth()] + " " + d + ", " + y;
    //document.getElementById("date").innerHTML = months[n.getMonth()] + " " + y;

    $(document).on("click", ".go_btn", function(e) {
        var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
        var dept        =   $('input#ff_divisions').val();
        var x_id        =   $('input#_id').val();
        var rem         =   $('textarea#remarks').val();
        var confiname   =   $('input#ff_employees').val();

        document.getElementById('busywait').style.display = "table-row";

        if (document.getElementById('for_appro_action').checked) {
            var faction = 1;
        } else {
             var faction = 0;
        }

        if (document.getElementById('for_info').checked) {
            var finfo = 1;
        } else {
             var finfo = 0;
        }

        if (document.getElementById('for_guidance').checked) {
            var fguidance = 1;
        } else {
             var fguidance = 0;
        }

        if (document.getElementById('for_reference').checked) {
            var freference = 1;
        } else {
             var freference = 0;
        }

        if (document.getElementById('for_review').checked) {
            var freview = 1;
        } else {
             var freview = 0;
        }

        if (document.getElementById('for_signature').checked) {
            var fsignature = 1;
        } else {
             var fsignature = 0;
        }

        var pr = $('#docclassification option:selected').val();

        if(dept.length === 0){
            //alert("Please specify the Division you want to forward this document");
            swal({
                              position: 'center',
                              icon: 'info',
                              title: 'Please specify the Division  you want to forward this document',
                              showConfirmButton: false
                            });

        }else{

            $.ajax({
                url: "{{ url('/outgoing-document/forward') }}/"+x_id,
                type: "POST",
                data: {_token: CSRF_TOKEN,_id: x_id,remarks: rem, division: dept, for_appro_action: faction, for_info:finfo, for_guidance:fguidance, for_reference:freference, for_review:freview, for_signature:fsignature, confi:confiname,_classification:pr},

                success: function(response){
                    console.log(response);

                    $('#doc-ff').modal('hide');
                    window.location.href="{{ url('/outgoing-document-list-view') }}";
                    //tempAlert("Document forwarded successfully save.",2000);
                    swal({
                              position: 'center',
                              icon: 'info',
                              title: 'Document forwarded successfully.',
                              showConfirmButton: false,
                              timer: 1500
                            });
                  },
                  error: function(ex){
                    swal({
                              position: 'center',
                              icon: 'error',
                              title: 'Sorry... Error sending mails.',
                              showConfirmButton: false,
                              timer: 1500
                            });
                            window.location.href="{{ url('/home') }}";
                  },
                });
                e.preventDefault();
            
        }
    });


    $(document).on("click", ".go_complete", function(e) {
        var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
        var dept        =   $('input#ff_divisions').val();
        var x_id        =   $('input#_id').val();

    

            $.ajax({
                url: "{{ url('/outgoing-document/doc-tracking-complete') }}/"+x_id,
                type: "POST",
                data: {_token: CSRF_TOKEN,_id: x_id,division: dept},

                success: function(response){
                    console.log(response);

                    $('#doc-ff').modal('hide');
                    window.location.href="{{ url('/outgoing-document-list-view') }}";
                    //tempAlert("Document tacking Complete.",2000);
                    swal({
                              position: 'center',
                              icon: 'info',
                              title: 'Document Tracking complete.',
                              showConfirmButton: false,
                              timer: 1500
                            });

                  },
                  error: function(ex){
                    //alert(JSON.stringify(ex));
                    window.location.href="{{ url('/home') }}";
                  },
                });
                e.preventDefault();
            
    });


    $(document).on("click", ".go_approve", function(e) {

        var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
        var dept        =   $('input#ff_divisions').val();
        var x_id        =   $('input#_id').val();

    

            $.ajax({
                url: "{{ url('/outgoing-document/doc-tracking-approve') }}/"+x_id,
                type: "POST",
                data: {_token: CSRF_TOKEN,_id: x_id,division: dept},

                success: function(response){
                    console.log(response);

                    $('#doc-ff').modal('hide');
                    //tempAlert("Document Approve",2000);
                    swal({
                              position: 'center',
                              icon: 'info',
                              title: 'Document Approve.',
                              showConfirmButton: false,
                              timer: 1500
                            });

                    window.location.href="{{ url('/outgoing-document-list-view') }}";
                  },
                  error: function(ex){
                    //alert(JSON.stringify(ex));
                    window.location.href="{{ url('/home') }}";
                  },
                });
                e.preventDefault();

    });

    $(document).on("click", ".go_disapprove", function(e) {

        var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
        var dept        =   $('input#ff_divisions').val();
        var x_id        =   $('input#_id').val();

    

            $.ajax({
                url: "{{ url('/outgoing-document/doc-tracking-disapprove') }}/"+x_id,
                type: "POST",
                data: {_token: CSRF_TOKEN,_id: x_id,division: dept},

                success: function(response){
                    console.log(response);

                    $('#doc-ff').modal('hide');
                    //tempAlert("Document Disapprove",2000);
                    swal({
                              position: 'center',
                              icon: 'info',
                              title: 'Document Disapprove.',
                              showConfirmButton: false,
                              timer: 1500
                            });
                    
                    window.location.href="{{ url('/outgoing-document-list-view') }}";
                  },
                  error: function(ex){
                    //alert(JSON.stringify(ex));
                    window.location.href="{{ url('/home') }}";
                  },
                });
                e.preventDefault();

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

function getUserList(ul){
        var u = (ul.value || ul.options[ul.selectedIndex].value);
        $.ajax({
                url: "{{ url('/get-users') }}/"+u,
                context: document.body,
                success: function(data){
                  console.log(data);

                    $('#userlist').find('option').remove();
                    $.each(data.data, function(key, value) {
                            
                            $('#userlist').append(`<option value="${value.f_name}">${value.f_name}</option>`);
                        
                    });
              
                }

        });
    };
</script>
@endsection