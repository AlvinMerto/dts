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
<div class="content-wrapper ml-2" style="width: auto;">
    <div class="row justify-content-center" style="width: 100%">
        <div class="col-md-8">
            <div class="card mt-3">
                <div class="card-header bg-primary" style="font-size: 16px; font-weight: bold; color: #fff;"><span class="fa fa-paperclip"></span>  Attach Files</div>
                    <div class="card-body" style="display: flex; justify-content: center;">

                        <section style="width: 100%">
                        <!--Content-->
                            <table style="align-self: center; table-layout: inherit;">
                                <tr class="border_bottom">
                                    <td align="center" style="padding: 10px; background-color: #3b5998; color: #fafafa; font-weight: bold;">Document Date</td>
                                    <td align="center" style="padding: 10px; background-color: #3b5998; color: #fafafa; font-weight: bold;">Briefer #</td>
                                    <td align="center" style="padding: 10px; background-color: #3b5998; color: #fafafa; font-weight: bold;">Barcode</td>
                                    <td align="center" style="padding: 10px; background-color: #3b5998; color: #fafafa; font-weight: bold;">Document Category/Type</td>
                                    <td colspan="2" align="center" style="padding: 10px; background-color: #3b5998; color: #fafafa; font-weight: bold;" 
                                    >Subject/Description</td>
                                    <td align="center" style="padding: 10px; background-color: #3b5998; color: #fafafa; font-weight: bold;">Division</td>
                                </tr>

                                @if($data->count()>0)
                                @foreach($data as $d)
                                
                                @endforeach
                                @endif

                                <tr class="border_bottom">
                                    <td align="center" >{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                    <td align="center" >{{$d->briefer_number}}</td>
                                    <td align="center" >{{$d->barcode}}</td>
                                    <td align="left" style="white-space: pre-wrap;">{{$d->doctitle}}</td>
                                    <td colspan="2" align="left" style="white-space: pre-wrap;">{{ $d->description }}</td>
                                    <td align="center" >{{$d->agency}}</td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding: 10px; background-color: #3b5998; color: #fafafa; font-weight: bold;">Briefer Number</td>
                                   <td colspan="6" align="center" style="padding: 10px; background-color: #3b5998; color: #fafafa; font-weight: bold;">Signatory</td>
                                 </tr>
                                <tr class="border_bottom">
                                    <td align="center" >{{$d->briefer_number}}</td>
                                    <td colspan="6" align="center" >{{$d->signatory}}</td>
                                </tr>
                            
                                <tr>
                                    <td colspan="7">
                                        <form method="POST" action="{{ url('/internal-document-new-entry/save-image')}}/{{$d->id}}" accept-charset="utf-8" enctype="multipart/form-data">
                                        @csrf
                                            <span style="margin-top: 0;">Click the box to choose file<br>or Drag your file into the box</span>
                                            
                                                <div class="fallback">
                                                    <input class="dropzone" type="file" name="img_file[]" multiple style="width: 200px; background: #E6E6E6;" accept="image/x-png,
                                                                            image/gif,
                                                                            image/jpeg,
                                                                            image/bmp,
                                                                            image/jpg,
                                                                            application/pdf,
                                                                            text/csv,
                                                                            text/plain,
                                                                            application/vnd.openxmlformats-officedocument.wordprocessingml.document,
                                                                            application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,
                                                                            application/vnd.ms-excel,
                                                                            application/vnd.ms-powerpoint,
                                                                            application/mspowerpoint,
                                                                            application/x-mspowerpoint,
                                                                            application/vnd.openxmlformats-officedocument.presentationml.presentation,
                                                                            application/msword,
                                                                            application/csv,
                                                                            application/excel" onchange="PreviewImage();">
                                                </div><br>

                                                <div id="image-holder" class="photo-container" style="float: right; display: none;">
                                                    <object data="" width="200" height="auto" id="image" class="photo-info ml-5 mt-1" style="height: auto; border: 1px solid #08298A; margin: 5px;box-shadow:2px 5px 5px #585858;-moz-box-shadow:2px 5px 5px #585858;-webkit-box-shadow:2px 5px 5px #585858;"><br>            
                                                    </object>

                                                </div>

                                                <button type="submit" id="upload" name="upload" class="btn btn-medium btn-primary"><span class="fa fa-upload"></span> Upload</button>
                                                
                                            <div id="err"></div>
                                        

                                        <input type="hidden" name="docname" id="docname" value="{{$d->doctitle}}">
                                        </form>
                                    </td>
                                </tr>


                                    <td colspan="7"><a href="{{url('/internal-document-list-view')}}" class="btn_OK btn btn-success" style="padding-left: 20px; padding-right: 20px; float: right; float: right;"><span class="fa fa-check-square-o" aria-hidden="true"></span> Done</a></td>
                                </tr>
                            </table>

                            @if($docimages->count()>0)
                            @foreach($docimages as $img)
                            <div class="img-grid">
                                <ul class="photos-gallery-layout">
                                     <li class="photos-gallery-li">
                                        <div class="photo">
                                            <object data="{{ url('public/uploads') }}/{{ $img->img_file }}" type="application/pdf" height="205">
                                            <iframe  src="{{ url('public/uploads') }}/{{ $img->img_file }}&embedded=true"></iframe>
                                            </object><br>
                                            <a href="{{ url('public/uploads') }}/{{ $img->img_file }}" target="blank">
                                                <i class="fa fa-search-plus" aria-hidden="true"><span style="font-family: calibri;"> Full view</span></i>
                                            </a>

                                            <a href="{{ url('/internal-document/remove-image')}}/{{$img->id}}/{{$img->ref_id}}/{{$img->img_file}}" style="float: right;">
                                                <i class="fa fa-times-circle" aria-hidden="true" style="color: #DF0101;"><span style="font-family: calibri; color: #DF0101;"> Remove</span></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>

                            </div>

                            @endforeach
                            @endif
                        </section>
                    </div>
            </div>
        </div>
    </div>
</div>

<script>
    function PreviewImage() {
        var oFReader = new FileReader();
        
        oFReader.readAsDataURL(document.getElementById("img_file").files[0]);

        var extension = document.getElementById("img_file").files[0].type

        //alert(extension);

        oFReader.onload = function (oFREvent) {
            //document.getElementById("image").src = oFREvent.target.result;

            $(".photo-info").attr("data", oFREvent.target.result);
            document.getElementById("image-holder").style.display = "none";
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
</script>

@endsection