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

<input type="hidden" name="type_input" id="type_input" value="library">
<div class="content-wrapper ml-2">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-3">
                <div class="card-header bg-warning" style="font-size: 16px; font-weight: bold; color: #434243;">MODE OF RELEASE</div>
                    <div class="card-body" style="display: flex; justify-content: center;">

                        <section style="width: 30%">
                        <!--Content-->

                        @if($data->count()>0)
                        @foreach($data as $d)
                        	<table style="align-self: center; table-layout: inherit;">
                        		<tr>
                        			<td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">EDIT/UPDATE ENTRY</td>
                        		</tr>
                                {{--<tr>
                                    <td><input class="form-control" style="width: 200px;" type="text" name="doctypeabbv" id="doctypeabbv" required placeholder="Abbreviation" value="{{$d->courier_abbv}}"></td>
                                </tr>--}}
                                <tr>
                                    <td><input class="form-control" style="width: 400px;" type="text" name="doctypefull" id="doctypefull"  required placeholder="Full Description" value="{{$d->courier_desc}}"></td>
                                </tr>
                                <tr>
                                <td colspan="2"><button type="submit" class="btn-save btn btn-success" style="padding-left: 20px; padding-right: 20px; float: right;"><span class="fa fa-floppy-o" aria-hidden="true"></span> Save</button></td>
                            </tr>
                        	</table>
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
    $(document).on("click", ".btn-save", function(e) {
        var CSRF_TOKEN  =       $('meta[name="csrf-token"]').attr('content');
        var docabbr     =       $('input#doctypeabbv').val();
        var docfull     =       $('input#doctypefull').val();

        var arr = (window.location.pathname).split("/");
        var val = (arr[arr.length-1]);


        $.ajax({
                url: "{{ url('/courier/library/update-entry') }}/"+val,
                type: "POST",
                data: {_token: CSRF_TOKEN,_abbv: docabbr,_fulldetail: docfull},

                success: function(response){
                    console.log(response);

                    tempAlert("Document save successfully save.",2000);

                    $('input#doctypeabbv').val('');
                    $('input#doctypefull').val('');
                    //$('#doc-ff').modal('hide');
                    window.location.href="{{ url('/courier/library') }}";
                  },
                  error: function(ex){
                    //alert(JSON.stringify(ex));
                    window.location.href="{{ url('/home') }}";
                  },
                });
        
                e.preventDefault();

    });

    function tempAlert(msg,duration)

    {
     var el = document.createElement("div");
     el.setAttribute("style","position:fixed;top:50%;left:45%;margin: 0 auto;background-color:#F4FA58; border: solid thin #01A9DB; border-radius: 3px; padding-left: 15px; padding-right: 15px; padding-top: 6px; padding-bottom: 6px; color: #0B2161;box-shadow:2px 5px 5px #585858;-moz-box-shadow:2px 5px 5px #585858;-webkit-box-shadow:2px 5px 5px #585858;");
     el.innerHTML = msg;

     setTimeout(function(){
      el.parentNode.removeChild(el);
     },duration);
     document.body.appendChild(el);
     $(el).hide().fadeIn('slow');
    }
</script>
@endsection