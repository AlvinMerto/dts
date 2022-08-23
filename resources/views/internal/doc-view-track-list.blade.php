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
        table th td,table th,table td {
        padding-left: 16px;
    }

    table td p {
        margin-bottom: 3px;
    }

    #recipientsbox p:hover {
        cursor: pointer;
        color: red;
        text-decoration: underline;
        font-weight: bold;
    }

    #mailstatus p {
        padding: 5px;
        margin-bottom: 0px;
    }

    .theinnertbl {

    }

    .theinnertbl tr {
        border-left: 1px solid #e6e6e6;
        border-right: 1px solid #e6e6e6;
        border-bottom: 1px solid #e6e6e6;
    }

    .theinnertbl tr th{
        font-size: 12px;
font-weight: bold;
color: #86898a;
border: 1px solid #e6e6e6;
    }

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
float: left;
list-style: none;
border: solid 1px #d9d9d9;
padding: 4px 10px;
margin: 10px 4px;
border-radius: 4px;
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

.theboxtab {
    width: 100%;
    /*overflow-x: auto; */
}
    
.theboxtab ul {
   width: auto;
    padding: 0px;
    display: flex;
    margin-bottom: 0px;
}

.theboxtab ul li{
    display: inline-block;
    padding: 11px;
    margin-right: 4px;
    border-radius: 0px;
    text-align: center;
    font-size: 15px;
}

.theboxtab ul li a {
font-size: 15px;
color: #a4a4a4;
font-weight: normal;
}

.theboxtab ul li:hover > a{
    font-weight: bold;
    cursor: pointer;
    color: #3490dc;
}

.perrow {
display: flex;
border-bottom: 2px solid #3490dc;
border-left: 2px solid #3490dc;
border-right: 2px solid #3490dc;
border-radius: 0px 6px 6px 0px;
margin-top: -2px;
border-top: 2px solid #3490dc;
}

.perrow div{
padding: 7px;
width: auto;
font-weight: normal;
font-family: calibri;
font-size: 12px;
}

.perrow div.one{
    width: 43%;
}

.perrow div.two {
width: 12%;
border-left: 1px solid #ccc;
border-right: 1px solid #ccc;
margin-left: -1px;
}

.perrow div.three {

}

.destinationtext {
font-size: 12px;
font-weight: bold;
letter-spacing: 0.1px;
color: #3490dc;
}

.dateselected {
    background-color: #3490dc !important;
border-radius: 9px 9px 0px 0px !important;
box-shadow: 0px -2px 3px #cecece;
border-top: 1px solid #eaeaea;
}

.dateselected a {
    color: #fff !important;    
    font-weight: bold !important;
}

.theblack {
border: 1px solid #ccc;
height: auto;
z-index: 10000000;
width: auto;
box-shadow: 0px 0px 13px #938e8e;
background: #fff;
margin-top: 10px;
}

</style>

<input type="hidden" name="type_input" id="type_input" value="internal">
<div class="content-wrapper ml-2" style="width: 115%">
    <div class="row justify-content-center" style="width: 100%">
        <div class="col-md-8">
            <div class="card mt-3" style=" margin-bottom: 50px;">
                <!--div class="card-header bg-default" style="font-size: 17px; font-weight: normal; color: #666;"--> <h4 style="margin-left: 14px; margin-top: 18px;border-bottom: 1px solid #ccc;padding-bottom: 15px; margin-bottom:0px;"> Internal Document Lists </h4> <!--/div-->
                    <div class="card-body" style="display: flex; justify-content: center; padding-top:0px;">

                        <section style="width: 100%">
                        <!--Content-->
                            <table style="align-self: center; table-layout: inherit;">
                                
                                @if($data->count()>0)
                                @foreach($data as $d)
                                
                                @endforeach
                                @endif
                                
                                    @if($d->confi_name == Auth::user()->f_name && $d->classification == 1)
    
                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Document Date</td>
                                            <td align="left" style="font-weight: bold;font-size: 14px !important;" >{{date('M d, Y', strtotime($d->doc_receive))}}</td>

                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Briefer #</td>
                                             <td align="left" style="font-weight: bold;font-size: 14px !important;" >{{$d->briefer_number}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Barcode</td>
                                            <td align="left" style="font-weight: bold;font-size: 14px !important;">{{$d->barcode}}</td>

                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Office/Division</td>
                                            <td align="left" style="font-weight: bold;font-size: 14px !important;">{{$d->agency}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <!--td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Document Type</td>
                                            <td align="left" >{{$d->type}}</td-->
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Sender</td>
                                            <td align="left" style="font-weight: bold;font-size: 14px !important;" >{{$d->signatory}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Document Category</td>
                                            <td colspan="3" align="left" style="font-weight: bold;font-size: 14px !important;">{{$d->doctitle}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Description</td>
                                            <td colspan="3" align="left" style="font-weight: bold;font-size: 14px !important;">{{ $d->description }}</td>
                                        </tr>

                                    </table>
                                       <table style="width: 100%;" class="mt-4">
                                       <tr>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Forwarded to</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Date Forwarded</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Status</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">No. of Days</td>
                                           <td align="center" class="card-header" style="padding: 10px; color: #fff; font-weight: bold; font-size: 13px !important; background: #585858; border-top: 1px solid #0040FF; border-bottom: 1px solid #0040FF;">Action</td>
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
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Document Date</td>
                                            <td align="left" style="font-weight: bold;font-size: 14px !important;" >{{date('M d, Y', strtotime($d->doc_receive))}}</td>

                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Briefer #</td>
                                             <td align="left" style="font-weight: bold;font-size: 14px !important;">{{$d->briefer_number}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Barcode</td>
                                            <td align="left" style="font-weight: bold;font-size: 14px !important;">{{$d->barcode}}</td>

                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Office/Division</td>
                                            <td align="left" style="font-weight: bold;font-size: 14px !important;">{{$d->agency}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <!--td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Document Type</td>
                                            <td align="left" >{{$d->type}}</td-->
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Sender</td>
                                            <td align="left" style="font-weight: bold;font-size: 14px !important;">{{$d->signatory}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Document Category</td>
                                            <td colspan="3" align="left" style="font-weight: bold;font-size: 14px !important;">{{$d->doctitle}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Description</td>
                                            <td colspan="3" align="left" style="font-weight: bold;font-size: 14px !important;">{{ $d->description }}</td>
                                        </tr>

                                    </table>
                                    <h4 style='margin-top:25px;'> History of Actions </h4>
                                    <?php // var_dump($data); 
                                        // $data_arr = (array) $data;
                                    ?>
                                        @if($data->count()>0)
                                            <?php 
                                                $display = [];
                                                    foreach($data as $d) {
                                                        if (!in_array($d->date_ff,$display)) {
                                                            array_push($display, $d->date_ff);
                                                        }
                                                    }
                                            ?>

                                            <div class='theboxtab'>
                                                <ul>
                                                    <?php 
                                                        foreach($display as $ddd) {
                                                            $url = url()->current();
                                                            $class = null;

                                                            if (isset($_GET['date'])) {
                                                                if (date("mdY",strtotime($ddd)) == $_GET['date']) {
                                                                    $class = "dateselected";
                                                                }   
                                                            }
                                                            echo "<li class='{$class}'>";
                                                                echo "<a href='{$url}/?date=".date("mdY",strtotime($ddd))."'>".date("M. d, Y", strtotime($ddd))."</a>";
                                                            echo "</li>";
                                                        }
                                                    ?>
                                                </ul>
                                            </div>
                                        @endif
                                       
                                            <?php 
                                                if (isset($_GET['date'])) {
                                                    $thedate = $_GET['date'];
                                                    for($i = 0;$i<=count($data)-1; ++$i) {
                                                        if ( date("mdY", strtotime($data[$i]->date_ff)) == $thedate ) { 
                                                            ?>
                                                            <div class='perrow'>
                                                                <div class='one'>
                                                                    <p class='destinationtext'> Action: </p>
                                                                    <p> {{$data[$i]->destination}} </p>
                                                                </div>
                                                                <div class='two'> 
                                                                    <p class='destinationtext'> Forwarded on: </p> 
                                                                    <p> {{ $data[$i]->date_forwared }} </p>
                                                                </div>
                                                               <div class='two'>
                                                                    <p class='destinationtext'> Actions: </p>
                                                                    <?php 
                                                                        $rems = explode(",",$data[$i]->remarks); 
                                                                        $remarks = null;

                                                                        if ( preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/',$rems[count($rems)-1]) == 1) {
                                                                            $remarks = $rems[count($rems)-1];
                                                                            unset($rems[count($rems)-1]);
                                                                        } 

                                                                        echo implode(" ",$rems);
                                                                    ?>
                                                                    <!--p> {!! nl2br($data[$i]->remarks) !!} </p-->
                                                                </div>
                                                                <?php 
                                                                    if ($remarks != null) {
                                                                         echo "<div>";
                                                                            echo "<p class='destinationtext'> Remarks: </p>";
                                                                            echo "<p> {$remarks} </p>";
                                                                        echo "</div>";
                                                                    }
                                                                ?>
                                                            </div>
                                            <?php 
                                                        } 
                                                      // echo "<div style='border-bottom:1px solid #ccc; width:100%;'> </div>";
                                                    }
                                                }
                                            ?>
                                        <table style="width: 100%;" class="mt-4">

                                        <input type="hidden" name="img_src" id="img_src" value="{{ url('/uploads') }}/{{ $d->image }}">
                                        
                                    @elseif($d->confi_name != Auth::user()->f_name && $d->classification == 1)
                                        <tr>
                                            <td colspan="7" align="center" style="font-size: 30px !important; color: #ff0000; font-style: bold !important;">Oppppsss!! This document is not for you!!!</td>
                                        </tr>

                                    @elseif(Auth::user()->access_level != 5 && $d->confi_name == Auth::user()->f_name && $d->classification != 1)
    
                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Document Date</td>
                                            <td align="left" style="font-weight: bold;font-size: 14px !important;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>

                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Briefer #</td>
                                             <td align="left" style="font-weight: bold;font-size: 14px !important;">{{$d->briefer_number}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Barcode</td>
                                            <td align="left" style="font-weight: bold;font-size: 14px !important;">{{$d->barcode}}</td>

                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Office/Division</td>
                                            <td align="left" style="font-weight: bold;font-size: 14px !important;">{{$d->agency}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <!--td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Document Type</td>
                                            <td align="left" >{{$d->type}}</td-->
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Sender</td>
                                            <td align="left" style="font-weight: bold;font-size: 14px !important;">{{$d->signatory}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Document Title</td>
                                            <td colspan="3" align="left" style="font-weight: bold;font-size: 14px !important;">{{$d->doctitle}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Description</td>
                                            <td colspan="3" align="left" style="font-weight: bold;font-size: 14px !important;">{{ $d->description }}</td>
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
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Document Date</td>
                                            <td align="left" style="font-weight: bold;font-size: 14px !important;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>

                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Briefer #</td>
                                             <td align="left" style="font-weight: bold;font-size: 14px !important;">{{$d->briefer_number}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Barcode</td>
                                            <td align="left" style="font-weight: bold;font-size: 14px !important;">{{$d->barcode}}</td>

                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Office/Division</td>
                                            <td align="left" style="font-weight: bold;font-size: 14px !important;">{{$d->agency}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <!--td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-weight: bold; font-size: 13px !important;">Document Type</td>
                                            <td align="left" >{{$d->type}}</td-->
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Sender</td>
                                            <td align="left" style="font-weight: bold;font-size: 14px !important;">{{$d->signatory}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Document Title</td>
                                            <td colspan="3" align="left" style="font-weight: bold;font-size: 14px !important;">{{$d->doctitle}}</td>
                                        </tr>

                                        <tr class="border_bottom">
                                            <td align="center" class="card-header" style="padding: 10px; color: #0B4C5F; font-size: 13px !important; text-align: right;">Description</td>
                                            <td colspan="3" align="left" style="font-weight: bold;font-size: 14px !important;">{{ $d->description }}</td>
                                        </tr>

                                       </table>

                                       

                                        <h4 style='margin-top:25px;'> History of Actions </h4>
                                        @if($data->count()>0)
                                            <?php 
                                                $display = [];
                                                    foreach($data as $d) {
                                                        if (!in_array($d->date_ff,$display)) {
                                                            array_push($display, $d->date_ff);
                                                        }
                                                    }
                                            ?>

                                            <div class='theboxtab'>
                                                <ul>
                                                    <?php 
                                                        foreach($display as $ddd) {
                                                            $url = url()->current();
                                                            $class = null;

                                                            if (isset($_GET['date'])) {
                                                                if (date("mdY",strtotime($ddd)) == $_GET['date']) {
                                                                    $class = "dateselected";
                                                                }   
                                                            }
                                                            echo "<li class='{$class}'>";
                                                                echo "<a href='{$url}/?date=".date("mdY",strtotime($ddd))."'>".date("M. d, Y", strtotime($ddd))."</a>";
                                                            echo "</li>";
                                                        }
                                                    ?>
                                                </ul>
                                            </div>
                                        @endif
                                    
                                        <?php 
                                                if (isset($_GET['date'])) {
                                                    $thedate = $_GET['date'];

                                                    for($i = 0;$i<=count($data)-1; ++$i) {
                                                        if ( date("mdY", strtotime($data[$i]->date_ff)) == $thedate ) { 
                                        ?>

                                                            <div class='perrow'>
                                                                <div class='one'>
                                                                    <p class='destinationtext'> Action: </p>
                                                                    <p> {{$data[$i]->destination}} </p>
                                                                </div>
                                                                <div class='two'>
                                                                    <p class='destinationtext'> Forwarded on: </p> 
                                                                    <p> {{ $data[$i]->date_forwared }} </p>
                                                                </div>
                                                                <div class='two'>
                                                                    <p class='destinationtext'> Actions: </p>
                                                                    <?php 
                                                                        $rems = explode(",",$data[$i]->remarks); 
                                                                        $remarks = null;

                                                                        if ( preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/',$rems[count($rems)-1]) == 1) {
                                                                            // echo $rems[count($rems)-1];
                                                                            $remarks = strip_tags($rems[count($rems)-1]);
                                                                            unset($rems[count($rems)-1]);
                                                                        }

                                                                        echo implode(" ",$rems);
                                                                    ?>
                                                                    <!--p> {!! nl2br($data[$i]->remarks) !!} </p-->
                                                                </div>
                                                                <?php 
                                                                    if ($remarks != null) {
                                                                        echo "<div>";
                                                                            echo "<p class='destinationtext'> Remarks: </p>";
                                                                            echo "<p> {$remarks} </p>";
                                                                        echo "</div>";
                                                                    }
                                                                ?>
                                                                <!--div class='three'>
                                                                    <p class='destinationtext'> Status: </p>
                                                                    <p> {{ $data[$i]->stat }}</p>
                                                                </div-->
                                                            </div>
                                        <?php 
                                                        }
                                                    }
                                                }
                                        ?>
                                        <input type="hidden" name="img_src" id="img_src" value="{{ url('public/uploads') }}/{{ $d->image }}">
                                        
                                    @endif

                                    
                                <table>
                                    <tr>
                                        @if(Auth::user()->access_level == 5)
                                            <td colspan="5" style="padding: 0px;padding-bottom: 15px;">
                                                <button onclick="export_excel();" class="btnExport btn btn-medium btn-default" style="font-size: 12px; float: left;"><i class="fa fa-file-excel-o"></i> Export to Excel</button> 

                                                <a href="{{ url('/internal-document-new-entry') }}" style="font-size: 12px; float: right;" class="btn btn-medium btn-default"><i class="fa fa-edit"></i> New Internal Entry</a>

                                                <button id="{{$d->ref_id}}" class="btn-ff btn btn-default pl-3 pr-3" style="font-size: 12px; float: right; margin-right: 10px;"><span class="fa fa-exclamation-triangle" aria-hidden="true"></span> Action</button>

                                                <a href="{{url('/internal-document-list-view')}}" style="font-size: 12px; float: right; margin-right: 10px;" class="btn btn-medium btn-default"><i class="fa fa-chevron-left"></i> Back</a>
                                            </td>
                                        @else
                                            <td colspan="5" style="padding: 0px;padding-bottom: 15px;">
                                                <button onclick="export_excel();" class="btnExport btn btn-medium btn-default" style="font-size: 12px; float: left;"><i class="fa fa-file-excel-o"></i> Export to Excel</button>

                                                <a href="{{url('/internal-document-list-view')}}" style="font-size: 12px; float: right;" class="btn btn-medium btn-default"><i class="fa fa-edit"></i> Back</a>
                                        @endif
                                    </tr>
                                </table>

                                @if($d->confi_name == Auth::user()->f_name && $d->classification == 1)
                                            <div>Attachments</div>
                                            @if($docimages->count()>0)
                                            @foreach($docimages as $img)
                                            <div class="img-grid">
                                                <ul class="photos-gallery-layout">
                                                     <li class="photos-gallery-li">
                                                        <div class="photo">
                                                            <object data="{{ url('public/uploads') }}/{{ $img->img_file }}" type="application/pdf" height="105">
                                                                <iframe src="{{ url('public/uploads') }}/{{ $img->img_file }}&embedded=true"></iframe>
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
                                            <h4> Attachments</h4>
                                            @if($docimages->count()>0)
                                                @foreach($docimages as $img)
                                                <div class="img-grid">
                                                    <ul class="photos-gallery-layout">
                                                         <li class="photos-gallery-li">
                                                            <div class="photo" data-href="{{ url('public/uploads') }}/{{ $img->img_file }}"> 
                                                                <!--object data="{{ url('public/uploads') }}/{{ $img->img_file }}" type="application/pdf" height="105">
                                                                    <iframe  src="{{ url('public/uploads') }}/{{ $img->img_file }}&embedded=true"></iframe>
                                                                </object><br-->
                                                                <a href="{{ url('public/uploads') }}/{{ $img->img_file }}" target="blank">
                                                                    <span> <i class="fa fa-paperclip"> </i> Attached file  </span>
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

<!-- Forward Modal -->
<div class="modal fade" id="doc-ff" tabindex="-1" role="dialog" aria-labelledby="ff-modal-label" aria-hidden="true">
  <div class="modal-dialog  modal-lg" style="min-width: auto; max-width: 50%"  role="document">
    <div class="modal-content">
      <div class="modal-header"><span style="font-size: 17px; color: #97918F; text-align: center;"><strong>DOCUMENT TRACKING SYSTEMmmm</strong></span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <span id="form_result"></span>
            <table style="table-layout:fixed;border-collapse: collapse;">
                <tr>
                    <th style="font-size: 15px; color: #0B3861;" text-align="left"> 
                        Level of priority
                    </th>
                    <td> 
                        <select class="form-control btn btn-primary" id="docclassification" name="docclassification" onchange="checkClass()" style="width: 130px;"></select>
                    </td>
                </tr>
                <tr>
                    <th style="font-size: 15px; color: #0B3861;" text-align="left">Forward to:</th>
                    <td class="p-3" style="border-bottom: none; background: #f2f2f2">
                        <p> Division </p>
                        <select id='divisionselect' class='btn btn-default' style='width: 100%;'>
                            <?php 
                                if ($div->count()>0) {
                                    foreach($div as $d) {
                                        if (strlen($d->division) > 0) {
                                            echo "<option value='{$d->division}'>";
                                                echo $d->division;
                                            echo "</option>";
                                        }
                                    }
                                }
                            ?>
                        </select>

                        <input list="divisions" placeholder="Division" name="ff_divisions" id="ff_divisions" class="form-control" onchange="getUserList(this);" style='display:none;'>
                        <datalist id="divisions">
                            @if($div->count()>0)
                            @foreach($div as $d)
                                <option value="{{ $d->division }}"></option>
                            @endforeach
                            @endif
                        </datalist>

                        <input type="hidden" id="optselect" name="optselect">
                    </td>
                    <!-- mark here -->
                    <input type="hidden" id="_id" name="_id" value="">
                    <input type="hidden" id="person" name="person" value="">

                <!--/tr>
                <tr-->
                    
                    <td colspan="2" valign="middle" class="mt-1" align="left" style="margin-left: -5px !important;">
                        <p> Employee Name </p>
                        <input list="userlist" placeholder="MinDA Employee" name="ff_employees" id="ff_employees" class="form-control">
                            <datalist id="userlist">
                                @if($userlist->count()>0)
                                    @foreach($userlist as $l)
                                        <option value="{{ $l->f_name }}">
                                    @endforeach
                                @endif
                            </datalist>
                    </td>
                    <td style='padding: 0px;'>
                        <p> &nbsp; </p>
                        <button class='btn btn-default' id='addthisemp'> Add </button>                        
                    </td>
                </tr>
                <tr>
                    <td colspan="5" align="center"><span style="font-style: italic;">"Note: double-click the box or down arrow to show the list"</span></td>
                </tr>
        </table>
        <table>
                <tr style='border-top:1px solid #ccc; border-bottom: 1px solid #ccc;'>
                    <th style="font-size: 15px; color: #0B3861;" align="left">Action</th>
                    <!--th style="font-size: 15px; color: #0B3861;" align="left">Specific Instruction <span id='insfor'> </span> </th-->
                    <th style="font-size: 15px; color: #0B3861;" align="left"> Recipients </th>
                    <td> &nbsp; </td>
                </tr>
                <tr>
                    <td align="left" style="word-wrap: break-word; vertical-align:top;" >
                        <p>
                            <input type="checkbox" name="for_appro_action" id="for_appro_action" style="vertical-align: text-bottom;"><b> <label for='for_appro_action'>for appropriate action </label></b>
                        </p>
                        <p>
                            <input type="checkbox" name="for_info" id="for_info" style="vertical-align: text-bottom; font-weight: bold;"><b> <label for='for_info'> for information </label> </b>
                        </p>
                        <p>
                            <input type="checkbox" name="for_reference" id="for_reference" style="vertical-align: text-bottom; font-weight: bold;"><b> <label for='for_reference'> for reference </label></b>
                        </p>
                        <p>
                            <input type="checkbox" name="for_guidance" id="for_guidance" style="vertical-align: text-bottom; font-weight: bold;"><b> <label for='for_guidance'> for guidance </label></b>
                        </p>
                        <p>
                            <input type="checkbox" name="for_review" id="for_review" style="vertical-align: text-bottom;"><b> <label for='for_review'> for review and evaluation </label></b>
                        </p>
                        <p>
                            <input type="checkbox" name="for_signature" id="for_signature" style="vertical-align: text-bottom;"><b> <label for='for_signature'> for approval/signature </label> </b>
                        </p>
                    </td>
                    <td style="vertical-align: top;">
                        <div id='recipientsbox'>

                        </div>
                        <!--p> <input type="text" style="padding: 10px;width: 100%;border: 1px solid #ccc;border-radius: 4px;"> </p>
                        <p> <button class='btn btn-default'> Add Instruction </button> </p-->
                    </td>
                    <td style='vertical-align: top;'>
                        <!--div>
                            <p> Presentation </p>
                        </div-->
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td align="left" class="p-3" style="border-bottom: none; background: #fff">
                        <label for="remarks" style="font-size: 15px; color: #0B3861;" >Remarks</label><br>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <textarea id="remarks" name="remarks" rows="3" style="width: 100%; max-width: 100%;border: 1px solid #ccc;border-radius: 4px;resize: none;padding: 10px;" placeholder=""></textarea>
                    </td>
                </tr>
                
                <tr id="busywait" style="display: none;">
                    <td colspan="2" align="center"><span style="color: #3A01DF;"><img src="{{ url('/images/busy_wait.gif') }}" height="40px">
                        <b>Sending mails... Please wait...</b></span>
                    </td>
                </tr>

            </table>

            <div class="modal-footer">
                <table>
                    <tr>
                        {{--<input type="hidden" id="completedoc" name="completedoc" value="{{$data[0]->retdoc}}">--}}

                        <td class="p-3" style="border-top: solid thin #fff;">
                            <span style="float: left;" class="mr-3">
                            @if(Auth::user()->access_level==4)
                                <a href="javascript:void(0);" class="go_approve btn btn-small btn-default mr-3"><span class="fa fa-smile-o" aria-hidden="true"></span> Approve</a>

                                <a href="javascript:void(0);" class="go_disapprove btn btn-small btn-default mr-3"><span class="fa fa-frown-o" aria-hidden="true"></span> Disapprove</a>
                            @elseif(Auth::user()->access_level==5 and Auth::user()->division=='AD')
                                <a href="javascript:void(0);" class="go_approve btn btn-small btn-default mr-3"><span class="fa fa-smile-o" aria-hidden="true"></span> Approve</a>

                                <a href="javascript:void(0);" class="go_disapprove btn btn-small btn-default mr-3"><span class="fa fa-frown-o" aria-hidden="true"></span> Disapprove</a>
                            @endif

                            <a href="javascript:void(0);" class="go_complete btn btn-small btn-success mr-3"><span class="fa fa-check-square-o" aria-hidden="true"></span> Complete</a>

                            </span>
                            <span style='float:right;'> 
                                <a href="javascript:void(0);" class="go_btn btn btn-small btn-primary"><span class="fa fa-share-square-o" aria-hidden="true"></span> Forward</a>    
                            </span>
                        </td>
                    </tr>
                </table>
                <div id='mailstatus' style="width: 100%;background: #f9f9f9;text-align: left;font-weight: normal;">

                </div>
            </div>

    </div>

  </div>
</div>

<!--div class="modal fade" id="doc-ff" tabindex="-1" role="dialog" aria-labelledby="ff-modal-label" aria-hidden="true">
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

                        <input list="divisions" placeholder="Division" name="ff_divisions" id="ff_divisions" class="form-control" style="width: 200px;" onchange="getUserList(this);">
                        <datalist id="divisions">
                            @if($div->count()>0)
                            @foreach($div as $d)
                                <option value="{{ $d->division }}"></option>
                            @endforeach
                            @endif
                        </datalist>

                        <input type="hidden" id="optselect" name="optselect">
                    </td>


                
                    <input type="hidden" id="_id" name="_id" value="">
                    <input type="hidden" id="person" name="person" value="">

                </tr>
                <tr>
                    
                    <td colspan="2" valign="middle" class="mt-1" align="center" style="margin-left: -5px !important;">

                        <input list="userlist" placeholder="MinDA Employee (Optional)" name="ff_employees" id="ff_employees" class="form-control" style="width: 200px;">
                            <datalist id="userlist">
                                @if($userlist->count()>0)
                                    @foreach($userlist as $l)
                                        <option value="{{ $l->f_name }}">
                                    @endforeach
                                @endif
                            </datalist>
                    </td>
                
                <tr>
                    <td colspan="2" align="center"><span style="font-style: italic;">"Note: double-click the box or down arrow to show the list"</span></td>
                </tr>
                
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
                
                    <td>
                        <select class="form-control" id="docclassification" name="docclassification" onchange="checkClass()" style="width: 130px;"></select>
                    </td>
                    {{--<input type="hidden" id="completedoc" name="completedoc" value="{{$data[0]->retdoc}}">--}}

                    <td class="p-3" style="border-top: solid thin #fff;"><span style="float: right;" class="mr-3">
                        @if(Auth::user()->access_level==4)

                            <a href="javascript:void(0);" class="go_approve btn btn-small btn-info mr-3"><span class="fa fa-smile-o" aria-hidden="true"></span> Approve</a>

                            <a href="javascript:void(0);" class="go_disapprove btn btn-small btn-danger mr-3"><span class="fa fa-frown-o" aria-hidden="true"></span> Disapprove</a>
                        @elseif(Auth::user()->access_level==5 and Auth::user()->division=='AD')
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
</div-->

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

        // set the default value
        // division            
            var defval = $(document).find("#divisionselect").val();
        //    getUserList(false,defval);

            $(document).find("#ff_divisions").val(defval);

            // employees 
            $(document).find("#ff_employees").val("");

            $(document).on("change keyup paste","#ff_employees" ,function() {
                var thename = $(this).val();
                $(document).find("#insfor").text("for "+thename);
            });

        // end 

        $(document).on("click","#addthisemp",function(){
            var theemp = $(document).find("#ff_employees").val();
                         $(document).find("#ff_employees").val("");

                $("<p>"+theemp+"</p>")
                    .on("click", function(){
                        var conf = confirm("are you sure you want to remove?");

                        if (conf) { // confirmed delete
                            $(this).remove();
                        }
                    }).appendTo("#recipientsbox");
        });

        $(document).on("change","#divisionselect",function(){
            var theval = $(this).val();

            getUserList(false, theval);

            $(document).find("#ff_divisions").val( theval );
        });

        var recipients_lists = [];

        $(document).on("click", ".go_btn", function(e) {
        var CSRF_TOKEN  =   $('meta[name="csrf-token"]').attr('content');
        var dept        =   $('input#ff_divisions').val(); // mark here
        var x_id        =   $('input#_id').val();
        var rem         =   $('textarea#remarks').val();

        /*
        var faction     =   $('input#for_appro_action').val();
        var finfo       =   $('input#for_info').val();
        var fguidance   =   $('input#for_guidance').val();
        var freference  =   $('input#for_reference').val();
        var freview  =   $('input#for_review').val();
        */

        //alert(dept);

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

        var pr          = $('#docclassification option:selected').val();
        var confiname   =   $('input#ff_employees').val();

        if(dept.length === 0){
            //alert("Please specify the Division you want to forward this document");
            swal({
                              position: 'center',
                              icon: 'info',
                              title: 'Please specify the Division  you want to forward this document',
                              showConfirmButton: false
                            });
        }else{

            document.getElementById('busywait').style.display = "table-row";

            var els = $(document).find("#recipientsbox").children("p");

            for(var i=0;i<=els.length-1;i++) {
                // innerText
                recipients_lists.push(els[i].innerText);
            }

            // console.log(els[0].innerText);

        //    return;
        // send email
            forwardtoemps(0,CSRF_TOKEN,x_id,rem,dept,faction,finfo,fguidance,freference,freview,fsignature,confiname,pr);
        //     document.getElementById('busywait').style.display = "none"; 
        //    window.location.reload();
            e.preventDefault();
            
        }
        
    });
    
    function forwardtoemps(startswith, CSRF_TOKEN,x_id,rem,dept,faction,finfo,fguidance,freference,freview,fsignature,confiname,pr) {

        $.ajax({
                url: "{{ url('/internal-document/forward') }}/"+x_id,
                type: "POST",
                data: {_token: CSRF_TOKEN,
                       _id: x_id,
                       remarks: rem, 
                       division: dept, 
                       for_appro_action: faction, 
                       for_info:finfo, 
                       for_guidance:fguidance, 
                       for_reference:freference, 
                       for_review:freview, 
                       for_signature:fsignature, 
                       confi:recipients_lists[startswith],
                       _classification:pr},

                success: function(response){

                    //tempAlert("Document forwarded successfully save.",2000);

                    // sent email here
                    $("<p> Mail is sent to "+recipients_lists[startswith]+" </p>").appendTo("#mailstatus");

                    // swal({
                    //           position: 'center',
                    //           icon: 'info',
                    //           title: 'Document forwarded successfully.',
                    //           showConfirmButton: false,
                    //           timer: 1500
                    //         });

                    if (startswith < recipients_lists.length-1) {
                        var thenewstart = startswith+1;
                        forwardtoemps(thenewstart, CSRF_TOKEN,x_id,rem,dept,faction,finfo,fguidance,freference,freview,fsignature,confiname,pr);
                    }

                    if (startswith == recipients_lists.length-1) {
                        document.getElementById('busywait').style.display = "none";    
                    }

                    //$('#doc-ff').modal('hide');
                    //window.location.href="{{ url('/internal-document-list-view') }}";
                    
                  },
                  error: function(ex){
                    // swal({
                    //       position: 'center',
                    //       icon: 'error',
                    //       title: 'Sending mail failed!, please check your internet connection and Email Addresses',
                    //       showConfirmButton: false
                    //     });
                    // alert(JSON.stringify(ex));
                    // window.location.href="{{ url('/home') }}";
                  },
                });
    }

});

    function export_excel()
    {

        var url = window.location.pathname;
        var arr = (window.location.pathname).split("/");
        //var id = (arr[arr.length-2]);
        var id = (arr[arr.length-1]);
        
        //alert(id);
        window.location = "{{ url('/export-excel-internal/excel-file-report/document-tracking') }}/"+id;
    }


    $(document).ready(function() {
        $(document).on("mouseover",".photos-gallery-li .photo", function(e) {
            $(document).find(".theblack").remove();

            var href = $(this).data("href");
            // <p style='text-align: right;padding-right: 11px;font-size: 22px;background: #ccc;'> <i class='fa fa-times' aria-hidden='true'></i> </p>
            // var el = document.elementFromPoint(event.pageX, event.pageY);
            // 
            $("<div class='theblack' id='theblack'> <div class='displayhere'><object data='"+href+"' type='application/pdf' style='width:700px; height:800px';> <iframe  src='"+href+"&embedded=true'></iframe></object> </div> </div>")
                .css({'top' : 10, 'left' : e.pageX+10 , 'position' : 'absolute'})
                .appendTo( document.body );
        })

        $(document).on("mouseout","#theblack", function(e){
            if(e.target.id != "theblack") {
                $(document).find(".theblack").remove();
            }
        });

        $(document).on("click", ".btn-ff", function() {
            var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
            var id   = $(this).attr("id");
            var alvel = $('input#q_user_level').val(); 

            //alert(alvel);

            $.ajax({
                url: "{{ url('/internal-document/document-return-category') }}/"+id,
                type: "GET",
                data: {_token: CSRF_TOKEN,_id: id},

                success: function(response){
                    console.log(response);

                    $('input#completedoc').val(response.data[0].retdoc);

                    //$('input#docclassification').val('3');
                    //$('.id_100 option[value=val2]').attr('selected','selected');

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
                //ex.preventDefault();


            
            //checkClass(); 
            setTimeout(function (){
                $('input#ff_divisions').focus();
                
            }, 1000);
        });       
    });


    n =  new Date();
    y = n.getFullYear();
    m = n.getMonth() + 1;
    d = n.getDate();

    var months = ["January","February","March","April","May","June","July","August","September","October","November","December"];

    //document.getElementById("date").innerHTML = months[n.getMonth()] + " " + d + ", " + y;
    //document.getElementById("date").innerHTML = months[n.getMonth()] + " " + y;

    $(document).on("click", ".go_btn_not_in_use", function(e) {
        var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
        var dept        =   $('input#ff_divisions').val();
        var x_id        =   $('input#_id').val();
        var rem         =   $('textarea#remarks').val();
        var confiname   =   $('input#ff_employee').val();
        /*
        var faction     =   $('input#for_appro_action').val();
        var finfo       =   $('input#for_info').val();
        var fguidance   =   $('input#for_guidance').val();
        var freference  =   $('input#for_reference').val();
        var freview  =   $('input#for_review').val();
        */

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

            document.getElementById('busywait').style.display = "table-row";

            $.ajax({
                url: "{{ url('/internal-document/forward') }}/"+x_id,
                type: "POST",
                data: {_token: CSRF_TOKEN,_id: x_id,remarks: rem, division: dept, for_appro_action: faction, for_info:finfo, for_guidance:fguidance, for_reference:freference, for_review:freview, for_signature:fsignature, confi:confiname,_classification:pr},

                success: function(response){
                    console.log(response);

                    //tempAlert("Document forwarded successfully save.",2000);

                    swal({
                              position: 'center',
                              icon: 'info',
                              title: 'Document forwarded successfully.',
                              showConfirmButton: false,
                              timer: 1500
                            });

                    $('#doc-ff').modal('hide');
                    window.location.href="{{ url('/internal-document-list-view') }}";
                  },
                  error: function(ex){
                    //alert(JSON.stringify(ex));
                    swal({
                              position: 'center',
                              icon: 'error',
                              title: 'Error forwarding documents.',
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
                url: "{{ url('/internal-document/doc-tracking-complete') }}/"+x_id,
                type: "POST",
                data: {_token: CSRF_TOKEN,_id: x_id,division: dept},

                success: function(response){
                    console.log(response);

                    //tempAlert("Document tacking Complete.",2000);

                    swal({
                              position: 'center',
                              icon: 'info',
                              title: 'Document tacking Complete.',
                              showConfirmButton: false,
                              timer: 1500
                            });

                    $('#doc-ff').modal('hide');
                    window.location.href="{{ url('/internal-document-list-view') }}";
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
                url: "{{ url('/internal-document/doc-tracking-approve') }}/"+x_id,
                type: "POST",
                data: {_token: CSRF_TOKEN,_id: x_id,division: dept},

                success: function(response){
                    console.log(response);

                    //tempAlert("Document Approve",2000);

                    swal({
                              position: 'center',
                              icon: 'info',
                              title: 'Document Approve.',
                              showConfirmButton: false,
                              timer: 1500
                            });

                    $('#doc-ff').modal('hide');
                    window.location.href="{{ url('/internal-document-list-view') }}";
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
                url: "{{ url('/internal-document/doc-tracking-disapprove') }}/"+x_id,
                type: "POST",
                data: {_token: CSRF_TOKEN,_id: x_id,division: dept},

                success: function(response){
                    console.log(response);

                    //tempAlert("Document Approve",2000);

                    swal({
                              position: 'center',
                              icon: 'info',
                              title: 'Document Disapprove.',
                              showConfirmButton: false,
                              timer: 1500
                            });

                    $('#doc-ff').modal('hide');
                    window.location.href="{{ url('/internal-document-list-view') }}";
                  },
                  error: function(ex){
                    //alert(JSON.stringify(ex));
                    window.location.href="{{ url('/home') }}";
                  },
                });
                e.preventDefault();

    });

    function getUserList(ul, div = false){
        
        var u = null;

        if (ul != false) {
            u = (ul.value || ul.options[ul.selectedIndex].value);
        } else {
            if (div == false) {
                // alert("Division is empty");
            } else {
                u = div;
            }
        }

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

    // function getUserList(ul){
    //     var u = (ul.value || ul.options[ul.selectedIndex].value);
    //     $.ajax({
    //             url: "{{ url('/get-users') }}/"+u,
    //             context: document.body,
    //             success: function(data){
    //               console.log(data);

    //                 $('#userlist').find('option').remove();
    //                 $.each(data.data, function(key, value) {
                            
    //                         $('#userlist').append(`<option value="${value.f_name}">${value.f_name}</option>`);
                        
    //                 });
              
    //             }

    //     });
    // };


</script>
@endsection