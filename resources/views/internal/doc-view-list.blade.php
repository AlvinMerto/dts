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

<style>
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

    .borderwhite {
        border: 1px solid #cacaca !important;
    }

    .whiteboxes {

    }

    .whiteboxes input[type="text"]{
        background: none !important;
    }

    .input-group-btn button {
        background: none !important;
    }

    .highprio {
        background: #F00;
        color: #fff;
        padding: 6px;
        text-align: center;
        border-radius: 99px;
    }

    .modprio {
         background: #3549B5;
        color: #fff;
        padding: 6px;
        text-align: center;
        border-radius: 99px;
    }

    .lowprio {
         background: #c3c3c3;
        color: #fff;
        padding: 6px;
        text-align: center;
        border-radius: 99px;
    }

    .confi {
         background: #FF6361;
        color: #fff;
        padding: 6px;
        text-align: center;
        border-radius: 99px;
    }

    .undef {
         background: #333333;
        color: #fff;
        padding: 6px;
        text-align: center;
        border-radius: 99px;
    }

    .thedatenavs {
        padding: 0px;
        margin: 0px;
    }

    .thedatenavs li{
        display: inline-block;
        margin-right: 2px;
        font-size: 14px;
        color: #737373;
        border: 1px solid #ccc;
        padding: 7px;
    }

    .thedatenavs li:hover{
        background: #f1f1f1;
    }
</style>

<input type="hidden" name="type_input" id="type_input" value="internal">
<div class="content-wrapper ml-2" style="width: 115%">
    <div class="row justify-content-center" style="width: 100%">
        <div class="col-md-8" style="width: 100%">
            <div class="card mt-3">
                <div style="font-size: 18px; color: #3b5998; font-weight: normal;" class="card-header"> Internal Document Lists 
                                            <div style='display: flex;'>
                                                <div class="sidebar-form borderwhite" style="width: 200px; margin-left: 5px;">
                                                    <div class="input-group whiteboxes">
                                                        <input type="text" id="q" name="q" class="form-control" placeholder="Barcode search...">
                                                        <span class="input-group-btn">
                                                            <button type="submit" name="search" id="search-btn" class="searchbtn btn btn-flat" style="height: 25pt; margin-top: -1px;" >
                                                              <i class="fa fa-search"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="sidebar-form borderwhite" style="width: 200px; margin-left: 5px;">
                                                    <div class="input-group whiteboxes">
                                                        <input type="text" list="datelist" placeholder="Filter by date" name="ff_date" id="ff_date" class="form-control">
                                                        <span class="input-group-btn">
                                                            <button type="submit" name="search" id="search-btn-date" class="searchbtn-date btn btn-flat" >
                                                              <i class="fa fa-search"></i>
                                                            </button>
                                                        </span>
                                                            <datalist id="datelist">
                                                                @if($datefilter->count()>0)
                                                                    @foreach($datefilter as $l)
                                                                        <option value="{{ date('M d, Y', strtotime($l->doc_receive)) }}">
                                                                    @endforeach
                                                                @endif
                                                            </datalist>
                                                    </div>
                                                </div>
                                            </div>
                </div>
                	<div class="card-body" style="display: flex; justify-content: center;">

    					<section style="width: 100%">
                            
    						      <!-- search form   -->

								<table>
                                    <tr>
                                        <input type="hidden" id="q_user_level" name="q_user_level" class="form-control" value="{{ Auth::user()->access_level }}">

                                        <?php $date = date("Y-m-d"); $today = "?date=".$date; ?>
                                        <td class="d-flex" style='padding-left: 0px !important; padding-top: 0px !important; overflow-x: auto;'>
                                            <ul class='thedatenavs'>
                                                <a href='<?php echo $today; ?>'/> <li style="font-size: 15px;font-weight: bold;color: #f2f2f2;background: #18a43b;"> Today - <?php echo date("M. d, Y"); ?></li> </a>
                                                <?php
                                                    for($i = 1 ; $i <= 4; $i++) {
                                                        $thedates = date("Y-m-d", strtotime("-{$i} days"));
                                                        echo "<a href='?date={$thedates}'/><li>";
                                                            echo date("D - M. d, Y", strtotime("-{$i} days"));
                                                        echo "</li></a>";
                                                    }
                                                ?>
                                            </ul>
                                        </td>
                                        <td>
                                            <div class="d-flex" style="float: right;">
                                                <div>
                                                    <div style="font-weight: bold;">SORT</div>
                                                    <a onClick="sortView(); return false;" href="{{url('/internal-document-list-view-sort')}}">
                                                        <img src="{{ url('/images/sort.png') }}" alt="sort" width="20" height="20">
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
								   
								    
								      <!-- /.search form -->
    					<!--Content-->
                            @if($data->count()>0)

    						<table class='theinnertbl'>
    							<tr class="border_bottom">
                                    <th>Document Date</th>
    								<th>Barcode</th>
    								<th>Document Category/Type</th>
    								<th>Description</th>
    								<th>Office/Division</th>
    								<th>Status</th>
    								<th># Days</th>
                                    <th>Classification</th>
    								<th>Action</th>
    							</tr>

                                <?php $priority = null; ?>
    							@foreach($data as $d)
                                <tr>
                                    @if($d->actioned == 0)
                                        @if($d->classification == 1 && $d->confi_name == Auth::user()->f_name)
                                             @if($d->days_count>5)
                                                <?php $priority = "Confidential"; $class='confi'; ?>
                                                <!--td>{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td>{{$d->barcode}}</td>
                                                <td>{{$d->doctitle}}</td>
                                                <td>{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td>{{$d->agency}}</td>
                                                <td><a href="#" style="text-decoration: none; color: #DF013A;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}" class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td>{{$d->days_count}}</td>
                                                <td>Confidential</td-->
                                             @else
                                                <?php $priority = "Confidential"; $class='confi'; ?>
                                                <!--td>{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td>{{$d->barcode}}</td>
                                                <td>{{$d->doctitle}}</td>
                                                <td>{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td>{{$d->agency}}</td>
                                                <td><a href="#" style="text-decoration: none; color: #FE0001;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{$d->date_forwared }}<br><br>{{$d->remarks}}" class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td>{{$d->days_count}}</td>
                                                <td>Confidential</td-->
                                            @endif
                                        @elseif($d->classification == 1 && $d->confi_name == Auth::user()->f_name || $d->classification == 1 && Auth::user()->access_level==5)
                                            @if($d->days_count>5)
                                                <?php $priority = "Confidential"; $class='confi'; ?>
                                                <!--td>{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td>{{$d->barcode}}</td>
                                                <td>{{$d->doctitle}}</td>
                                                <td>{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td>{{$d->agency}}</td>
                                                <td><a href="#" style="text-decoration: none; color: #DF013A;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}" class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td>{{$d->days_count}}</td>
                                                <td>Confidential</td-->
                                            @else
                                                <?php $priority = "Confidential"; $class='confi'; ?>
                                                <!--td align="center" style="color: #045FB4; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #045FB4;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #045FB4;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="color: #045FB4; font-weight: bold;">{{$d->agency}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: bold;"><a href="#" style="text-decoration: none; color: #045FB4;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}" class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="color: #045FB4; font-weight: bold;">{{$d->days_count}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: bold;">Confidential</td-->
                                            @endif
                                        @elseif($d->classification == 1 && $d->confi_name != Auth::user()->f_name)
                                            @if($d->days_count>5)
                                                <?php $priority = "Confidential"; $class='confi'; ?>
                                                <!--td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;background: #F4A8A9; color: #434243;">Confidential</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;background: #F4A8A9; color: #434243;">Confidential</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">Confidential</td>
                                                <td align="center"><div id="stattooltip_{{$d->id}}" style="background: #F4A8A9; color: #434243; font-weight: bold;">Confidential></td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">Confidential</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">Confidential</td-->
                                            @else
                                                <?php $priority = "Confidential"; $class='confi'; ?>
                                                <!--td align="center" style="color: #DF013A; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #DF013A; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #DF013A;">Confidential</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #DF013A;">Confidential</td>
                                                <td align="center" style="color: #DF013A; font-weight: bold;">Confidential</td>
                                                <td align="center"><span style="color: #DF013A; font-weight: bold;">Confidential></td>
                                                <td align="center" style="color: #DF013A; font-weight: bold;">Confidential</td>
                                                <td align="center" style="color: #DF013A; font-weight: bold;">Confidential</td-->
                                            @endif
                                        @elseif($d->classification == 2)
                                            @if($d->days_count>5)
                                                <?php $priority = "High Priority"; $class='highprio'; ?>
                                                <!--td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;background: #F4A8A9; color: #434243;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;background: #F4A8A9; color: #434243;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->agency}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;"><a href="#" style="text-decoration: none; color: #DF013A;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}" class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->days_count}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">High Priority</td-->
                                            @else
                                                <?php $priority = "High Priority"; $class='highprio'; ?>
                                                <!--td align="center" style="color: #DF013A; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #DF013A; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #DF013A;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #DF013A;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="color: #DF013A; font-weight: bold;">{{$d->agency}}</td>
                                                <td align="center" style="color: #DF013A; font-weight: bold;"><a href="#" style="text-decoration: none; color: #DF013A;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}" class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="color: #DF013A; font-weight: bold;">{{$d->days_count}}</td>
                                                <td align="center" style="color: #DF013A; font-weight: bold;">High Priority</td-->
                                            @endif
                                        @elseif($d->classification == 3)
                                            @if($d->days_count>5)
                                                <?php $priority = "Moderate Priority"; $class='modprio'; ?>
                                                <!--td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;background: #F4A8A9; color: #434243;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->agency}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;"><a href="#" style="text-decoration: none; color: #DF013A;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}" class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->days_count}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">Moderate Priority</td-->
                                            @else
                                                <?php $priority = "Moderate Priority"; $class='modprio'; ?>
                                                <!--td align="center" style="color: #B505AE; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #B505AE; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #B505AE;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #B505AE;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="color: #B505AE; font-weight: bold;">{{$d->agency}}</td>
                                                <td align="center" style="color: #B505AE; font-weight: bold;"><a href="#" style="text-decoration: none; color: #B505AE;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}" class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="color: #B505AE; font-weight: bold;">{{$d->days_count}}</td>
                                                <td align="center" style="color: #B505AE; font-weight: bold;">Moderate Priority</td-->
                                            @endif
                                        @elseif($d->classification == 4)
                                            @if($d->days_count>5)
                                                <?php $priority = "Low Priority"; $class='lowprio'; ?>
                                                <!--td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;background: #F4A8A9; color: #434243;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;background: #F4A8A9; color: #434243;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->agency}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;"><a href="#" style="text-decoration: none; color: #DF013A;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}" class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->days_count}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">Low Priority</td-->
                                            @else
                                                <?php $priority = "Low Priority"; $class='lowprio'; ?>
                                                <!--td align="center" style="color: #045FB4; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #045FB4;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #045FB4;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="color: #045FB4; font-weight: bold;">{{$d->agency}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: bold;"><a href="#" style="text-decoration: none; color: #045FB4;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}" class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="color: #045FB4; font-weight: bold;">{{$d->days_count}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: bold;">Low Priority</td-->
                                            @endif
                                        @else
                                            @if($d->days_count>5)
                                                <?php $priority = "Undefined"; $class='undef'; ?>
                                                <!--td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;background: #F4A8A9; color: #434243;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;background: #F4A8A9; color: #434243;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->agency}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;"><a href="#" style="text-decoration: none; color: #DF013A;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}" class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->days_count}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">Undefined</td-->
                                            @else
                                                <?php $priority = "Undefined"; $class='undef'; ?>
                                                <!--td align="center" style="color: #0A610A; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #0A610A; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #0A610A;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #0A610A;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="color: #0A610A; font-weight: bold;">{{$d->agency}}</td>
                                                <td align="center" style="color: #0A610A; font-weight: bold;"><a href="#" style="text-decoration: none; color: #0A610A;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}" class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="color: #0A610A; font-weight: bold;">{{$d->days_count}}</td>
                                                <td align="center" style="color: #0A610A; font-weight: bold;">Undefined</td-->
                                            @endif
                                        @endif

                                    @else

                                        @if($d->classification == 1 && $d->confi_name == Auth::user()->f_name)
                                            @if($d->days_count>5)
                                                <?php $priority = "Confidential"; $class='confi'; ?>
                                                <!--td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;"><a href="#" style="text-decoration: none; color: #DF013A;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}" class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">Confidential</td-->
                                            @else
                                                <?php $priority = "Confidential"; $class='confi'; ?>
                                                <!--td align="center" style="color: #045FB4; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #045FB4;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #045FB4;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;"><a href="#" style="text-decoration: none; color: #045FB4;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}" class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">Confidential</td-->
                                            @endif
                                        @elseif($d->classification == 1 && $d->confi_name == Auth::user()->f_name || $d->classification == 1 && Auth::user()->access_level==5)
                                            @if($d->days_count>5)
                                                <?php $priority = "Confidential"; $class='confi'; ?>
                                                <!--td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;"><a href="#" style="text-decoration: none; color: #DF013A;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">Confidential</td-->
                                            @else
                                                <?php $priority = "Confidential"; $class='confi'; ?>   
                                                <!--td align="center" style="color: #045FB4; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #045FB4;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #045FB4;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;"><a href="#" style="text-decoration: none; color: #045FB4;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">Confidential</td-->
                                            @endif
                                        @elseif($d->classification == 1 && $d->confi_name != Auth::user()->f_name)
                                            @if($d->days_count>5)
                                                <?php $priority = "Confidential"; $class='confi'; ?>
                                                <!--td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">Confidential</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">Confidential</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">Confidential</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">Confidential</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">Confidential</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">Confidential</td-->
                                            @else
                                                <?php $priority = "Confidential"; $class='confi'; ?>
                                                <!--td align="center" style="color: #DF013A; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #DF013A; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #DF013A;">Confidential</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #DF013A;">Confidential</td>
                                                <td align="center" style="color: #DF013A; font-weight: normal;">Confidential</td>
                                                <td align="center" style="color: #DF013A; font-weight: normal;">Confidential</td>
                                                <td align="center" style="color: #DF013A; font-weight: normal;">Confidential</td>
                                                <td align="center" style="color: #DF013A; font-weight: normal;">Confidential</td-->
                                            @endif
                                        @elseif($d->classification == 2)
                                            @if($d->days_count>5)
                                                 <?php $priority = "High Priority"; $class='highprio'; ?>
                                                <!--td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">
                                                    <a href="#" style="text-decoration: none; color: #DF013A;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a>
                                                </td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">High Priority</td-->
                                            @else
                                                <?php $priority = "High Priority"; $class='highprio'; ?>
                                                <!--td align="center" style="color: #DF013A; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #DF013A; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #DF013A;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #DF013A;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="color: #DF013A; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="color: #DF013A; font-weight: normal;">
                                                    <a href="#" style="text-decoration: none; color: #DF013A;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a>
                                                    
                                                </td>
                                                <td align="center" style="color: #DF013A; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="color: #DF013A; font-weight: normal;">High Priority</td-->
                                            @endif
                                        @elseif($d->classification == 3)
                                            @if($d->days_count>5)
                                                <?php $priority = "Moderate Priority"; $class='modprio'; ?>
                                                <!--td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;"><a href="#" style="text-decoration: none; color: #DF013A;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">Moderate Priority</td-->
                                            @else
                                                <?php $priority = "Moderate Priority"; $class='modprio'; ?>
                                                <!--td align="center" style="color: #B505AE; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #B505AE; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #B505AE;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #B505AE;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="color: #B505AE; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="color: #B505AE; font-weight: normal;"><a href="#" style="text-decoration: none; color: #B505AE;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="color: #B505AE; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="color: #B505AE; font-weight: normal;">Moderate Priority</td-->
                                            @endif
                                        @elseif($d->classification == 4)
                                            @if($d->days_count>5)
                                                <?php $priority = "Low Priority"; $class='lowprio'; ?>
                                                <!--td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;"><a href="#" style="text-decoration: none; color: #DF013A;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">Low Priority</td-->
                                            @else
                                                <?php $priority = "Low Priority"; $class='lowprio'; ?>
                                                <!--td align="center" style="color: #045FB4; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #045FB4;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #045FB4;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;"><a href="#" style="text-decoration: none; color: #045FB4;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">Low Priority</td-->
                                            @endif
                                        @else
                                            @if($d->days_count>5)
                                                <?php $priority = "undefined"; $class='undef'; ?>
                                                <!--td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;"><a href="#" style="text-decoration: none; color: #DF013A;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">Undefined</td-->
                                            @else
                                                <?php $priority = "undefined"; $class='undef'; ?>
                                                <!--td align="center" style="color: #0A610A; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #0A610A; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #0A610A;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #0A610A;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="color: #0A610A; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="color: #0A610A; font-weight: normal;"><a href="#" style="text-decoration: none; color: #0A610A;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="color: #0A610A; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="color: #0A610A; font-weight: normal;">Undefined</td-->
                                            @endif
                                        @endif
                                    @endif
                                        <?php if ($priority != null): ?>
                                            <td>{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                            <td>{{$d->barcode}}</td>
                                            <td>{{$d->doctitle}}</td>
                                            <td style='white-space: normal;'>{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                            <td>{{$d->agency}}</td>
                                            <td><a href="#" style="text-decoration: none; color: #0A610A;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}" class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                            <td>{{$d->days_count}}</td>
                                            <td> 
                                                <?php 
                                                    echo "<p class='{$class}'>".$priority."</p>"; 
                                                ?>
                                            </td>
                                        <?php endif; ?>
                                    @if($d->days_count>5)
                                        <!--td align="center">
                                            @if($d->confi_name == Auth::user()->f_name && $d->classification == 1 || $d->classification == 1 && Auth::user()->access_level==5)
                                                <a href="{{url('/internal-document-track-list-view/view-document-tracking')}}/{{$d->ref_id}}" id="{{$d->id}}" class="btn btn-success pl-4 pr-4"><span class="fa fa-envelope-open-o" aria-hidden="true"></span> View</a>
                                            @elseif($d->classification != 1)
                                                <a href="{{url('/internal-document-track-list-view/view-document-tracking')}}/{{$d->ref_id}}" id="{{$d->id}}" class="btn btn-success pl-4 pr-4"><span class="fa fa-envelope-open-o" aria-hidden="true"></span> View</a>
                                            @endif
                                            @if($d->status=='complete' && Auth::user()->division == $d->dept)
                                                @if(Auth::user()->access_level==5)
                                                    <br>
                                                    <a href="javascript:void(0);" id="{{$d->ref_id}}" class="go_edit_btn btn btn-small btn-danger mt-2  pl-4 pr-4"><span class="fa fa-pencil-square-o" aria-hidden="true"></span> Edit </a>
                                                @endif
                                            @else
                                                    <br>
                                                @if($d->confi_name == Auth::user()->f_name && $d->classification == 1)
                                                    <a href="#" id="{{$d->ref_id}}" class="btn-ff btn btn-primary mt-2  pl-3 pr-3"><span class="fa fa-exclamation-triangle" aria-hidden="true"></span> Action</a>
                                                @elseif($d->confi_name != Auth::user()->f_name && $d->classification == 1)
                                                    <a href="#" id="{{$d->ref_id}}" class="btn-ff btn btn-primary mt-2  pl-3 pr-3"><span class="fa fa-exclamation-triangle" aria-hidden="true"></span> Action</a>
                                                @elseif($d->classification != 1)
                                                    <a href="#" id="{{$d->ref_id}}" class="btn-ff btn btn-primary mt-2  pl-3 pr-3"><span class="fa fa-exclamation-triangle" aria-hidden="true"></span> Action</a>
                                                @endif

                                                @if(Auth::user()->access_level==5)
                                                    <br>
                                                    <a href="javascript:void(0);" id="{{$d->ref_id}}" class="go_edit_btn btn btn-small btn-danger mt-2  pl-4 pr-4"><span class="fa fa-pencil-square-o" aria-hidden="true"></span> Edit </a>
                                                @endif
                                            @endif
                                        </td-->
                                    @else
                                        <!--td align="center" >
                                            @if($d->confi_name == Auth::user()->f_name && $d->classification == 1 || $d->classification == 1 && Auth::user()->access_level==5)
                                                <a href="{{url('/internal-document-track-list-view/view-document-tracking')}}/{{$d->ref_id}}" id="{{$d->id}}" class="btn btn-success pl-4 pr-4"><span class="fa fa-envelope-open-o" aria-hidden="true"></span> View</a>
                                            @elseif($d->classification != 1)
                                                <a href="{{url('/internal-document-track-list-view/view-document-tracking')}}/{{$d->ref_id}}" id="{{$d->id}}" class="btn btn-success pl-4 pr-4"><span class="fa fa-envelope-open-o" aria-hidden="true"></span> View</a>
                                            @endif
                                            @if($d->status=='complete' && Auth::user()->division == $d->dept)
                                                @if(Auth::user()->access_level==5)
                                                    <br>
                                                    <a href="javascript:void(0);" id="{{$d->ref_id}}" class="go_edit_btn btn btn-small btn-danger mt-2  pl-4 pr-4"><span class="fa fa-pencil-square-o" aria-hidden="true"></span> Edit </a>
                                                @endif
                                            @else
                                                    <br>
                                                @if($d->confi_name == Auth::user()->f_name && $d->classification == 1)
                                                    <a href="#" id="{{$d->ref_id}}" class="btn-ff btn btn-primary mt-2  pl-3 pr-3"><span class="fa fa-exclamation-triangle" aria-hidden="true"></span> Action</a>
                                                @elseif($d->confi_name != Auth::user()->f_name && $d->classification == 1)
                                                    <a href="#" id="{{$d->ref_id}}" class="btn-ff btn btn-primary mt-2  pl-3 pr-3"><span class="fa fa-exclamation-triangle" aria-hidden="true"></span> Action</a>
                                                @elseif($d->classification != 1)
                                                    <a href="#" id="{{$d->ref_id}}" class="btn-ff btn btn-primary mt-2  pl-3 pr-3"><span class="fa fa-exclamation-triangle" aria-hidden="true"></span> Action</a>
                                                @endif

                                                @if(Auth::user()->access_level==5)
                                                    <br>
                                                    <a href="javascript:void(0);" id="{{$d->ref_id}}" class="go_edit_btn btn btn-small btn-danger mt-2  pl-4 pr-4"><span class="fa fa-pencil-square-o" aria-hidden="true"></span> Edit </a>
                                                @endif
                                            @endif
                                        </td-->
                                    @endif
                                        <td align="center" >
                                            @if($d->confi_name == Auth::user()->f_name && $d->classification == 1 || $d->classification == 1 && Auth::user()->access_level==5)
                                                <a href="{{url('/internal-document-track-list-view/view-document-tracking')}}/{{$d->ref_id}}" id="{{$d->id}}" class="btn btn-default pl-4 pr-4"><span class="fa fa-envelope-open-o" aria-hidden="true"></span> View</a>
                                            @elseif($d->classification != 1)
                                                <a href="{{url('/internal-document-track-list-view/view-document-tracking')}}/{{$d->ref_id}}" id="{{$d->id}}" class="btn btn-default pl-4 pr-4"><span class="fa fa-envelope-open-o" aria-hidden="true"></span> View</a>
                                            @endif
                                            @if($d->status=='complete' && Auth::user()->division == $d->dept)
                                                @if(Auth::user()->access_level==5)
                                                    <br>
                                                    <a href="javascript:void(0);" id="{{$d->ref_id}}" class="go_edit_btn btn btn-small btn-default mt-2  pl-4 pr-4"><span class="fa fa-pencil-square-o" aria-hidden="true"></span> Edit </a>
                                                @endif
                                            @else
                                                    <br>
                                                @if($d->confi_name == Auth::user()->f_name && $d->classification == 1)
                                                    <a href="#" id="{{$d->ref_id}}" class="btn-ff btn btn-default mt-2  pl-3 pr-3"><span class="fa fa-exclamation-triangle" aria-hidden="true"></span> Action</a>
                                                @elseif($d->confi_name != Auth::user()->f_name && $d->classification == 1)
                                                    <a href="#" id="{{$d->ref_id}}" class="btn-ff btn btn-default mt-2  pl-3 pr-3"><span class="fa fa-exclamation-triangle" aria-hidden="true"></span> Action</a>
                                                @elseif($d->classification != 1)
                                                    <a href="#" id="{{$d->ref_id}}" class="btn-ff btn btn-default mt-2  pl-3 pr-3"><span class="fa fa-exclamation-triangle" aria-hidden="true"></span> Action</a>
                                                @endif

                                                @if(Auth::user()->access_level==5)
                                                    <br>
                                                    <a href="javascript:void(0);" id="{{$d->ref_id}}" class="go_edit_btn btn btn-small btn-default mt-2  pl-4 pr-4"><span class="fa fa-pencil-square-o" aria-hidden="true"></span> Edit </a>
                                                @endif
                                            @endif
                                        </td>
                                </tr>
    							@endforeach

    	
    						</table>

                            @else
                                <div class="justify-content-center bg-danger p-5" style="font-size: 16px; color: #fff; width: 70vw; text-align: center;">No Record Found</div>
                            @endif

    						@if($data->count() > 0)
								<div class="justify-content-center" style="font-size: 10px; margin-top: 10px; margin-bottom: 50px;">{{ $data->links() }}</div>
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
      <div class="modal-header"><span style="font-size: 17px; color: #97918F; text-align: center;"><strong>DOCUMENT TRACKING SYSTEM</strong></span>
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


<!-- Edit Modal -->
<div class="modal fade" id="doc-edit" tabindex="-1" role="dialog"aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog  modal-lg" style="min-width: auto; max-width: 50%;"  role="document">
    <div class="modal-content">
      <div class="modal-header"><span style="font-size: 24px; color: #FF4000; text-align: center;"><strong>EDIT DOCUMENT TRACKING SYSTEM (INTERNAL DOCUMENTS)</strong></span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <span id="form_result"></span>

      <table border="1px #fff solid;" style="align-self: center;" width="auto">

        <tr>
            <td><span style="margin-left: 30px;">Date</span></td>
            <td><input class="form-control ml-5" style="width: auto;" type="date" name="docdate" id="docdate" value="" required placeholder="Date Received" title="Date Received"></td>
        </tr>
        <tr>
            <td><span style="margin-left: 30px;">Briefer Number</span></td>
            <td><input class="form-control ml-5" style="width: 200px;" type="text" name="briefer" id="briefer" value="" required placeholder="Briefer Number"></td>
        </tr>
        <tr>
            <td><span style="margin-left: 30px;">Barcode</span></td>
            <td><input class="form-control ml-5" style="width: 200px;" type="text" name="barcode" id="barcode" value="" required placeholder="Barcode Number"></td>
        </tr>
        <tr>
            <td><span style="margin-left: 30px;">Division/Office</span></td>
            <td>
                <input list="division_datalist" name="agency" id="agency" class="form-control ml-5" style="width: 200px;" required placeholder="Division/Office"></td>
                                        <datalist id="division_datalist">
                                            @if($div->count()>0)
                                            @foreach($div as $u)
                                                <option value="{{ $u->division }}">
                                            @endforeach
                                            @endif
                                        </datalist>
                                        <input type="hidden" id="userselect" name="userselect">
            </td>
        </tr>
        <tr>
            <td><span style="margin-left: 30px;">Signatory</span></td>
            <td>
            
                <input list="user_datalist" name="signature" id="signature" class="form-control ml-5" style="width: 200px;" required placeholder="Signatory"></td>
                                        <datalist id="user_datalist">
                                            @if($userlist->count()>0)
                                            @foreach($userlist as $u)
                                                <option value="{{ $u->f_name }}">
                                            @endforeach
                                            @endif
                                        </datalist>
                                        <input type="hidden" id="userselect" name="userselect">
                
            </td>
        </tr>
        <tr>
            <td><span style="margin-left: 30px;">Document Category/Type</span></td>
            <td>
                <input list="memo_datalist" name="doctitle" id="doctitle" class="form-control ml-5" style="width: 300px;" required placeholder="Document Category/Type"></td>
                                        <datalist id="memo_datalist">
                                            @if($lib->count()>0)
                                            @foreach($lib as $l)
                                                <option value="{{ $l->doc_full_desc }}">
                                            @endforeach
                                            @endif
                                        </datalist>
                                        <input type="hidden" id="optselect" name="optselect">
            </td>
        </tr>
        <tr>
            <td><span style="margin-left: 30px;">Document Description</span></td>
            <td><input class="form-control mr-5  ml-5" style="width: 300px;" type="text" name="docdesc" id="docdesc" value="" required placeholder="Subject/Description"></td>
        </tr>
        <tr>
            <td colspan="2"><span style="margin-left: 30px;">
                <input type="checkbox" name="chkdocreturn" id="chkdocreturn" class="checkbox-success" style="vertical-align: text-bottom;"> Return this Document
            </td>
        </tr>
        <input type="hidden" name="edit_id" id="edit_id" value="">

        <tr>
            <td colspan="2"><button class="btn-upload btn btn-warning"><span class="fa fa-paperclip" aria-hidden="true"></span> Attach Files</button> <button class="btn_save btn btn-success" style="padding-left: 20px; padding-right: 20px; float: right;"><span class="fa fa-floppy-o" aria-hidden="true"></span> Save</button></td>
        </tr>
    </table>
  </div>
</div>
</div>


<script src="{{ asset('js/moment.min.js') }}"></script>
<script>
    $(document).ready(function() {

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
                    $dropdown.val('').text('');

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

    var recipients_lists = [];

    var months = ["January","February","March","April","May","June","July","August","September","October","November","December"];

    //document.getElementById("date").innerHTML = months[n.getMonth()] + " " + d + ", " + y;
    //document.getElementById("date").innerHTML = months[n.getMonth()] + " " + y;

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
                    console.log(response);

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
                    swal({
                              position: 'center',
                              icon: 'error',
                              title: 'Sending mail failed!, please check your internet connection and Email Addresses',
                              showConfirmButton: false
                            });
                    //alert(JSON.stringify(ex));
                    // window.location.href="{{ url('/home') }}";
                  },
                });
    }
    
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


    $(document).ready(function() {

        $(document).on("click", ".searchbtn", function() {
             //var x = document.getElementById("q").value;

             var x =  $('input#q').val();

            if(x.length > 0){
                window.location = "{{ url('/internal-document/search-document') }}/" + x
            }else{
                swal({
                              position: 'center',
                              icon: 'warning',
                              dangerMode: true,
                              title: 'Search Criteria is empty!',
                              showConfirmButton: false,
                              timer: 1500
                            });
            }
        });       
    });


    $(document).ready(function() {

        $(document).on("click", ".searchbtn-date", function() {
             //var x = document.getElementById("q").value;

             var x =  $('input#ff_date').val();

            if(x.length > 0){
                window.location = "{{ url('/internal-document/filter-date') }}/" + x
            }else{
                swal({
                              position: 'center',
                              icon: 'warning',
                              dangerMode: true,
                              title: 'Search Criteria is empty!',
                              showConfirmButton: false,
                              timer: 1500
                            });
            }
        });       
    });

    $(document).ready(function() {
        var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');

        $(document).on("click", ".go_edit_btn", function(e) {
            var x_id        =   this.id;

             $.ajax({
                url: "{{ url('/internal-document/edit-document-details') }}/"+x_id,
                type: "GET",
                data: {_token: CSRF_TOKEN,_id: x_id},

                success: function(response){
                    console.log(response);

                    var doccheck = response.data[0].retdoc;

                    if(doccheck == 1){
                        $('input#chkdocreturn').prop('checked', true);
                    }else{
                        $('input#chkdocreturn').prop('checked', false);
                    }

                    $('input#edit_id').val(response.data[0].id);
                    $('input#docdate').val(response.data[0].doc_receive);
                    $('input#barcode').val(response.data[0].barcode);
                    $('input#agency').val(response.data[0].agency);
                    $('input#signature').val(response.data[0].signatory);
                    $('input#doctitle').val(response.data[0].doctitle);
                    $('input#docdesc').val(response.data[0].description);
                    $('input#briefer').val(response.data[0].briefer_number);

                    $('#doc-edit').modal('show');
                    
                  },
                  error: function(ex){
                    //alert(JSON.stringify(ex));
                    window.location.href="{{ url('/home') }}";
                  },
                });
                e.preventDefault();

            //alert('Edit Clicked '+x_id);
            
        });       
    });

    $(document).ready(function() {
        $(document).on("click", ".btn_save", function(e) {

            //alert('Save clicked');

            var CSRF_TOKEN  =       $('meta[name="csrf-token"]').attr('content');
            var x_id        =       $('input#edit_id').val();
            var docdate     =       $('input#docdate').val();
            var barcode     =       $('input#barcode').val();
            var agency      =       $('input#agency').val();
            var signature   =       $('input#signature').val();
            var doctitle    =       $('input#doctitle').val();
            var desc        =       $('input#docdesc').val(); 
            var briefer     =       $('input#briefer').val();
            var retdoc      =       0;

            var a_level=0;

            if (document.getElementById('chkdocreturn').checked) {
                retdoc=1;
            }else{
                retdoc=0;
            }

             $.ajax({
                url: "{{ url('/internal-document/update-document-details') }}/"+x_id,
                type: "POST",
                data: {_token: CSRF_TOKEN,_id: x_id, _docdate: docdate, _barcode: barcode, _agency: agency, _signature: signature, _doctitle: doctitle,_desc: desc,_briefer: briefer, returndoc:retdoc},

                success: function(response){
                    //console.log(response);

                    //tempAlert("Update Successful....",2000);

                    swal({
                              position: 'center',
                              icon: 'info',
                              title: 'Update Successful...',
                              showConfirmButton: false,
                              timer: 1500
                            });

                    $('#doc-edit').modal('hide');
                    window.location.href="{{ url('/internal-document-list-view') }}";
                  },
                  error: function(e){
                    //alert(JSON.stringify(e));
                    window.location.href="{{ url('/home') }}";
                  },
                });
                e.preventDefault();
            
        });       
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

function warnAlert(msg,duration)

    {
     var elx = document.createElement("div");
     elx.setAttribute("style","position:fixed;top:50%;left:45%;margin: 0 auto;background-color:#FF0000; border: solid thin #DF0101; border-radius: 3px; padding-left: 25px; padding-right: 25px; padding-top: 12px; padding-bottom: 12px; background: #F4A8A9; color: #434243;box-shadow:2px 5px 5px #585858;-moz-box-shadow:2px 5px 5px #585858;-webkit-box-shadow:2px 5px 5px #585858;");
     elx.innerHTML = msg;

     setTimeout(function(){
      elx.parentNode.removeChild(elx);
     },duration);
     document.body.appendChild(elx);
     $(elx).hide().fadeIn('slow');
    }

$('#tt').on({
  "click": function() {
    $(this).tooltip({ items: "#tt", content: "Displaying on click"});
    $(this).tooltip("open");
  },
  "mouseout": function() {      
     $(this).tooltip("disable");   
  }
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

        //if(e > 3){
        //    document.getElementById("ff_employees").disabled = true;
        //    document.getElementById("ff_employees").value="";
        //}else{
        //    document.getElementById("ff_employees").disabled = false;
        //}

            //alert(doctype);

            $.ajax({
                url: "{{ url('/internal-document/docclass') }}/"+x_id,
                type: "POST",
                data: {_token: CSRF_TOKEN,_id: x_id,docclass: doctype},

                    success: function(response){
                        console.log(response);

                        //tempAlert("Autosaving....Please refresh the page...",2000);
                        swal({
                              position: 'center',
                              icon: 'info',
                              title: 'Autosaving....Please refresh the page...',
                              showConfirmButton: false,
                              timer: 1500
                            });

                            //$('#doc-ff').modal('hide');
                            //window.location.href="{{ url('/internal-document-list-view') }}";
                    },
                        error: function(ex){
                        //alert(JSON.stringify(ex));
                        window.location.href="{{ url('/internal-document-list-view') }}";
                    },
        }); 
    //}
}


function confideName(){

    var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
    var dept        =   $('input#ff_divisions').val();
    var x_id        =   $('input#_id').val();
    var doctype     =   $('select#docclassification').val();
    var cname       =   $('input#ff_employees').val();

    //if(dept.length === 0){
    //        alert("Please specify the Division first");
    //}else{
    

            $.ajax({
                url: "{{ url('/internal-document/confidential') }}/"+x_id,
                type: "POST",
                data: {_token: CSRF_TOKEN,_id: x_id,docclass: doctype, confiname: cname},

                success: function(response){
                    console.log(response);

                    //tempAlert("Autosaving....",2000);
                    if(cname.length>0)
                    {
                        swal({
                                  position: 'bottom',
                                  icon: 'info',
                                  title: 'Autosaving....Please refresh the page...',
                                  showConfirmButton: false,
                                  showClass: {
                                    popup: `
                                      animate__animated
                                      animate__fadeInUp
                                      animate__faster
                                    `
                                  },
                                  timer: 1500
                                });
                    }

                    //$('#doc-ff').modal('hide');
                    //window.location.href="{{ url('/internal-document-list-view') }}";
                  },
                  error: function(ex){
                    //alert(JSON.stringify(ex));
                    window.location.href="{{ url('/internal-document-list-view') }}";
                  },
                });
    //}

    
//    alert(doctype);
}


function sortView(){
    var arr = (window.location.pathname).split("/");
    var val = (arr[arr.length-1]);
    var sortval = 0;

    if(val.includes('sort-az')){
        var sortval = 2;
    }else{
       var sortval = 1; 
    }

    if(sortval === 1){
        window.location.href="{{ url('/internal-document-list-view-sort-az') }}";
    }else{
        window.location.href="{{ url('/internal-document-list-view') }}";
    }

}

$(document).ready(function() {

    $(document).on("click", ".btn-upload", function() {
        var x_id        =   $('input#edit_id').val();

        window.location.href="{{ url('/internal-document-new-entry/upload-image') }}/"+x_id;
    });
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


</script>
@endsection