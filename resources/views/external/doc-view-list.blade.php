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

<input type="hidden" name="type_input" id="type_input" value="external">
<div class="content-wrapper ml-2" style="width: 115%">
    <div class="row justify-content-center" style="width: 100%">
        <div class="col-md-8" style="width: 100%">
            <div class="card mt-3">
                <div class="card-header bg-success" style="font-size: 16px; font-weight: bold; color: #fff;">External Document Lists</div>
                    <div class="card-body" style="display: flex; justify-content: center;">

                        <section style="width: 100%">
                            @if($data->count()>0)
                                  <!-- search form   -->
                                <table>
                                    <input type="hidden" id="q_user_level" name="q_user_level" class="form-control" value="{{ Auth::user()->access_level }}">
                                    <tr>
                                        <td class="d-flex">
                                              <div class="sidebar-form" style="width: 200px; margin-left: 5px;">
                                                    <div class="input-group">
                                                        <input type="text" id="q" name="q" class="form-control" placeholder="Barcode search...">
                                                        <span class="input-group-btn">
                                                            <button type="submit" name="search" id="search-btn" class="searchbtn btn btn-flat" style="height: 25pt; margin-top: -1px;" >
                                                              <i class="fa fa-search"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="sidebar-form" style="width: 200px; margin-left: 5px;">
                                                    <div class="input-group">
                                                        <input list="datelist" placeholder="Filter by date" name="ff_date" id="ff_date" class="form-control">
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

                                                <div class="sidebar-form" style="width: 200px; margin-left: 5px;">
                                                    <div class="input-group">
                                                        <input list="typelists" placeholder="Filter by Type" name="ff_type" id="ff_type" class="form-control">
                                                        <span class="input-group-btn">
                                                            <button type="submit" name="search" id="search-btn-type" class="searchbtn-type btn btn-flat" >
                                                              <i class="fa fa-search"></i>
                                                            </button>
                                                        </span>
                                                            <datalist id="typelists">
                                                                @if($tplist->count()>0)
                                                                    @foreach($tplist as $t)
                                                                        <option value="{{ $t->type }}">
                                                                    @endforeach
                                                                @endif
                                                            </datalist>
                                                    </div>
                                                </div>
                                        </td>
                                        <td>
                                            <div class="d-flex" style="float: right;">
                                                <div>
                                                    <div style="font-weight: bold;">SORT</div>
                                                    <a onClick="sortView(); return false;" href="{{url('/external-document-list-view-sort')}}">
                                                        <img src="{{ url('/images/sort.png') }}" alt="sort" width="20" height="20">
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                   
                                    
                                      <!-- /.search form -->
                        <!--Content-->

                            <table style="align-self: center; width: 100%;">
                                <tr class="border_bottom">
                                    <td align="center" style="padding: 10px; background-color: #3b5998; color: #fafafa; font-weight: bold;">Document Date</td>
                                    <td align="center" style="padding: 10px; background-color: #3b5998; color: #fafafa; font-weight: bold;">Barcode</td>
                                    <td align="center" style="padding: 10px; background-color: #3b5998; color: #fafafa; font-weight: bold;">Document Category/Type</td>
                                    <td align="center" style="width: 250px !important; padding: 10px; background-color: #3b5998; color: #fafafa; font-weight: bold;" 
                                    >Description</td>
                                    <td align="center" style="padding: 10px; background-color: #3b5998; color: #fafafa; font-weight: bold;">Agency/Office</td>
                                    <td align="center" style="padding: 10px; background-color: #3b5998; color: #fafafa; font-weight: bold;">File Type</td>
                                    <td align="center" style="padding: 10px; background-color: #3b5998; color: #fafafa; font-weight: bold;">Status</td>
                                    <td align="center" style="padding: 10px; background-color: #3b5998; color: #fafafa; font-weight: bold;"># Days</td>
                                    <td align="center" style="padding: 10px; background-color: #3b5998; color: #fafafa; font-weight: bold;">Classification</td>
                                    <td colspan="2" align="center" style="padding: 10px; background-color: #3b5998; color: #fafafa; font-weight: bold;">Action</td>
                                </tr>

                                @foreach($data as $d)

                                <tr>
                                    @if($d->actioned == 0)
                                        @if($d->classification == 1 && $d->confi_name == Auth::user()->f_name)
                                             @if($d->days_count>5)
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;background: #F4A8A9; color: #434243;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;background: #F4A8A9; color: #434243;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->agency}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->type}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;"><a href="#" style="text-decoration: none; color: #434243;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->days_count}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">Confidential</td>
                                             @else
                                                <td align="center" style="color: #FE0001; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #FE0001; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #FE0001;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #FE0001;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="color: #FE0001; font-weight: bold;">{{$d->agency}}</td>
                                                <td align="center" style="color: #FE0001; font-weight: bold;">{{$d->type}}</td>
                                                <td align="center" style="color: #FE0001; font-weight: bold;"><a href="#" style="text-decoration: none; color: #FE0001;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{$d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="color: #FE0001; font-weight: bold;">{{$d->days_count}}</td>
                                                <td align="center" style="color: #FE0001; font-weight: bold;">Confidential</td>
                                            @endif
                                        @elseif($d->classification == 1 && $d->confi_name == Auth::user()->f_name || $d->classification == 1 && Auth::user()->access_level==5)
                                            @if($d->days_count>5)
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;background: #F4A8A9; color: #434243;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;background: #F4A8A9; color: #434243;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->agency}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->type}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;"><a href="#" style="text-decoration: none; color: #434243;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->days_count}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">Confidential</td>
                                            @else
                                                <td align="center" style="color: #045FB4; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #045FB4;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #045FB4;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="color: #045FB4; font-weight: bold;">{{$d->agency}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: bold;">{{$d->type}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: bold;"><a href="#" style="text-decoration: none; color: #045FB4;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="color: #045FB4; font-weight: bold;">{{$d->days_count}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: bold;">Confidential</td>
                                            @endif
                                        @elseif($d->classification == 1 && $d->confi_name != Auth::user()->f_name)
                                            @if($d->days_count>5)
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;background: #F4A8A9; color: #434243;">Confidential</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;background: #F4A8A9; color: #434243;">Confidential</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">Confidential</td>
                                                <td align="center"><div id="stattooltip_{{$d->id}}" style="background: #F4A8A9; color: #434243; font-weight: bold;">Confidential></td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">Confidential</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">Confidential</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">Confidential</td>
                                            @else
                                                <td align="center" style="color: #DF013A; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #DF013A; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #DF013A;">Confidential</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #DF013A;">Confidential</td>
                                                <td align="center" style="color: #DF013A; font-weight: bold;">Confidential</td>
                                                <td align="center" style="color: #DF013A; font-weight: bold;">Confidential</td>
                                                <td align="center"><span style="color: #DF013A; font-weight: bold;">Confidential></td>
                                                <td align="center" style="color: #DF013A; font-weight: bold;">Confidential</td>
                                                <td align="center" style="color: #DF013A; font-weight: bold;">Confidential</td>
                                            @endif
                                        @elseif($d->classification == 2)
                                            @if($d->days_count>5)
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;background: #F4A8A9; color: #434243;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;background: #F4A8A9; color: #434243;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->agency}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->type}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;"><a href="#" style="text-decoration: none; color: #434243;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->days_count}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">High Priority</td>
                                            @else
                                                <td align="center" style="color: #DF013A; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #DF013A; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #DF013A;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #DF013A;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="color: #DF013A; font-weight: bold;">{{$d->agency}}</td>
                                                <td align="center" style="color: #DF013A; font-weight: bold;">{{$d->type}}</td>
                                                <td align="center" style="color: #DF013A; font-weight: bold;"><a href="#" style="text-decoration: none; color: #DF013A;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="color: #DF013A; font-weight: bold;">{{$d->days_count}}</td>
                                                <td align="center" style="color: #DF013A; font-weight: bold;">High Priority</td>
                                            @endif
                                        @elseif($d->classification == 3)
                                            @if($d->days_count>5)
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;background: #F4A8A9; color: #434243;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->agency}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->type}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;"><a href="#" style="text-decoration: none; color: #434243;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->days_count}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">Moderate Priority</td>
                                            @else
                                                <td align="center" style="color: #B505AE; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #B505AE; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #B505AE;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #B505AE;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="color: #B505AE; font-weight: bold;">{{$d->agency}}</td>
                                                <td align="center" style="color: #B505AE; font-weight: bold;">{{$d->type}}</td>
                                                <td align="center" style="color: #B505AE; font-weight: bold;"><a href="#" style="text-decoration: none; color: #B505AE;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="color: #B505AE; font-weight: bold;">{{$d->days_count}}</td>
                                                <td align="center" style="color: #B505AE; font-weight: bold;">Moderate Priority</td>
                                            @endif
                                        @elseif($d->classification == 4)
                                            @if($d->days_count>5)
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;background: #F4A8A9; color: #434243;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;background: #F4A8A9; color: #434243;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->agency}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->type}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;"><a href="#" style="text-decoration: none; color: #434243;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->days_count}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">Low Priority</td>
                                            @else
                                                <td align="center" style="color: #045FB4; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #045FB4;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #045FB4;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="color: #045FB4; font-weight: bold;">{{$d->agency}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: bold;">{{$d->type}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: bold;"><a href="#" style="text-decoration: none; color: #045FB4;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="color: #045FB4; font-weight: bold;">{{$d->days_count}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: bold;">Low Priority</td>
                                            @endif
                                        @else
                                            @if($d->days_count>5)
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;background: #F4A8A9; color: #434243;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;background: #F4A8A9; color: #434243;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->agency}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->type}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;"><a href="#" style="text-decoration: none; color: #434243;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">{{$d->days_count}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: bold;">Undefined</td>
                                            @else
                                                <td align="center" style="color: #0A610A; font-weight: bold;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #0A610A; font-weight: bold;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #0A610A;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: bold;color: #0A610A;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="color: #0A610A; font-weight: bold;">{{$d->agency}}</td>
                                                <td align="center" style="color: #0A610A; font-weight: bold;">{{$d->type}}</td>
                                                <td align="center" style="color: #0A610A; font-weight: bold;"><a href="#" style="text-decoration: none; color: #0A610A;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="color: #0A610A; font-weight: bold;">{{$d->days_count}}</td>
                                                <td align="center" style="color: #0A610A; font-weight: bold;">Undefined</td>
                                            @endif
                                        @endif

                                    @else

                                        @if($d->classification == 1 && $d->confi_name == Auth::user()->f_name)
                                            @if($d->days_count>5)
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->type}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;"><a href="#" style="text-decoration: none; color: #434243;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">Confidential</td>
                                            @else
                                                <td align="center" style="color: #045FB4; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #045FB4;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #045FB4;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;"><a href="#" style="text-decoration: none; color: #045FB4;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">Confidential</td>
                                            @endif
                                        @elseif($d->classification == 1 && $d->confi_name == Auth::user()->f_name || $d->classification == 1 && Auth::user()->access_level==5)
                                            @if($d->days_count>5)
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;"><a href="#" style="text-decoration: none; color: #434243;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">Confidential</td>
                                            @else
                                                <td align="center" style="color: #045FB4; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #045FB4;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #045FB4;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">{{$d->type}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;"><a href="#" style="text-decoration: none; color: #045FB4;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">Confidential</td>
                                            @endif
                                        @elseif($d->classification == 1 && $d->confi_name != Auth::user()->f_name)
                                            @if($d->days_count>5)
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">Confidential</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">Confidential</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">Confidential</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">Confidential</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">Confidential</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">Confidential</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">Confidential</td>
                                            @else
                                                <td align="center" style="color: #DF013A; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #DF013A; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #DF013A;">Confidential</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #DF013A;">Confidential</td>
                                                <td align="center" style="color: #DF013A; font-weight: normal;">Confidential</td>
                                                <td align="center" style="color: #DF013A; font-weight: normal;">Confidential</td>
                                                <td align="center" style="color: #DF013A; font-weight: normal;">Confidential</td>
                                                <td align="center" style="color: #DF013A; font-weight: normal;">Confidential</td>
                                                <td align="center" style="color: #DF013A; font-weight: normal;">Confidential</td>
                                            @endif
                                        @elseif($d->classification == 2)
                                            @if($d->days_count>5)
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->type}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">
                                                    <a href="#" style="text-decoration: none; color: #434243;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a>
                                                </td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">High Priority</td>
                                            @else
                                                <td align="center" style="color: #DF013A; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #DF013A; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #DF013A;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #DF013A;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="color: #DF013A; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="color: #DF013A; font-weight: normal;">{{$d->type}}</td>
                                                <td align="center" style="color: #DF013A; font-weight: normal;">
                                                    
                                                    <a href="#" style="text-decoration: none; color: #DF013A;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a>
                                                    
                                                </td>
                                                <td align="center" style="color: #DF013A; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="color: #DF013A; font-weight: normal;">High Priority</td>
                                            @endif
                                        @elseif($d->classification == 3)
                                            @if($d->days_count>5)
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->type}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;"><a href="#" style="text-decoration: none; color: #434243;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">Moderate Priority</td>
                                            @else
                                                <td align="center" style="color: #B505AE; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #B505AE; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #B505AE;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #B505AE;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="color: #B505AE; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="color: #B505AE; font-weight: normal;">{{$d->type}}</td>
                                                <td align="center" style="color: #B505AE; font-weight: normal;"><a href="#" style="text-decoration: none; color: #B505AE;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="color: #B505AE; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="color: #B505AE; font-weight: normal;">Moderate Priority</td>
                                            @endif
                                        @elseif($d->classification == 4)
                                            @if($d->days_count>5)
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->type}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;"><a href="#" style="text-decoration: none; color: #434243;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">Low Priority</td>
                                            @else
                                                <td align="center" style="color: #045FB4; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #045FB4;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #045FB4;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">{{$d->type}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;"><a href="#" style="text-decoration: none; color: #045FB4;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="color: #045FB4; font-weight: normal;">Low Priority</td>
                                            @endif
                                        @else
                                            @if($d->days_count>5)
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;background: #F4A8A9; color: #434243;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->type}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;"><a href="#" style="text-decoration: none; color: #DF013A;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="background: #F4A8A9; color: #434243; font-weight: normal;">Undefined</td>
                                            @else
                                                <td align="center" style="color: #0A610A; font-weight: normal;">{{date('M d, Y', strtotime($d->doc_receive))}}</td>
                                                <td align="center" style="color: #0A610A; font-weight: normal;">{{$d->barcode}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #0A610A;">{{$d->doctitle}}</td>
                                                <td align="left" style="white-space: pre-wrap; font-weight: normal;color: #0A610A;">{!! Str::limit($d->description, 100, ' ...') !!}</td>
                                                <td align="center" style="color: #0A610A; font-weight: normal;">{{$d->agency}}</td>
                                                <td align="center" style="color: #0A610A; font-weight: normal;">{{$d->type}}</td>
                                                <td align="center" style="color: #0A610A; font-weight: normal;"><a href="#" style="text-decoration: none; color: #0A610A;" data-toggle="tooltip" data-placement="auto" title="" data-original-title="<b>Latest Action:</b><br>{{$d->destination}}<br>{{ $d->date_forwared }}<br><br>{{$d->remarks}}"
       class="rem-tooltip" data-html="true">{{$d->status}}</a></td>
                                                <td align="center" style="color: #0A610A; font-weight: normal;">{{$d->days_count}}</td>
                                                <td align="center" style="color: #0A610A; font-weight: normal;">Undefined</td>
                                            @endif
                                        @endif
                                    @endif

                                    @if($d->days_count>5)
                                        <td align="center" style="background: #F4A8A9;">
                                            @if($d->confi_name == Auth::user()->f_name && $d->classification == 1 || $d->classification == 1 && Auth::user()->access_level==5)
                                                <a href="{{url('/external-document-track-list-view/view-document-tracking')}}/{{$d->ref_id}}" id="{{$d->id}}" class="btn btn-success pl-4 pr-4"><span class="fa fa-envelope-open-o" aria-hidden="true"></span> View</a>
                                            @elseif($d->classification != 1)
                                                <a href="{{url('/external-document-track-list-view/view-document-tracking')}}/{{$d->ref_id}}" id="{{$d->id}}" class="btn btn-success pl-4 pr-4"><span class="fa fa-envelope-open-o" aria-hidden="true"></span> View</a>
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
                                        </td>
                                    @else
                                        <td align="center" >
                                            @if($d->confi_name == Auth::user()->f_name && $d->classification == 1 || $d->classification == 1 && Auth::user()->access_level==5)
                                                <a href="{{url('/external-document-track-list-view/view-document-tracking')}}/{{$d->ref_id}}" id="{{$d->id}}" class="btn btn-success pl-4 pr-4"><span class="fa fa-envelope-open-o" aria-hidden="true"></span> View</a>
                                            @elseif($d->classification != 1)
                                                <a href="{{url('/external-document-track-list-view/view-document-tracking')}}/{{$d->ref_id}}" id="{{$d->id}}" class="btn btn-success pl-4 pr-4"><span class="fa fa-envelope-open-o" aria-hidden="true"></span> View</a>
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
                                        </td>
                                    @endif
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


<div class="modal fade" id="doc-edit" tabindex="-1" role="dialog"aria-labelledby="edit-modal-label" aria-hidden="true">
  <div class="modal-dialog  modal-lg" style="min-width: auto; max-width: 50%"  role="document">
    <div class="modal-content">
      <div class="modal-header"><span style="font-size: 24px; color: #FF4000; text-align: center;"><strong>EDIT DOCUMENT TRACKING SYSTEM</strong></span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <span id="form_result"></span>

      <table border="1px #fff solid;" style="align-self: center;">

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
            <td><span style="margin-left: 30px;">Agency/Office</span></td>
            <td>
                <input list="division_datalist" name="agency" id="agency" class="form-control ml-5" style="width: 200px;" required placeholder="Division/Office" onchange="getUserList(this);"></td>
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
            <td><input class="form-control ml-5" style="width: 200px;" type="text" name="signature" id="signature" value="" required placeholder="Signatory"></td>
        </tr>
        <tr>
            <td><span style="margin-left: 30px;">Sender's Name</span></td>
            <td><input class="form-control  ml-5" style="width: 200px;" type="text" name="sendername" id="sendername" value="" required placeholder="Sender's Name"></td>
            </tr>
        <tr>
            <td><span style="margin-left: 30px;">Sender's Email</span></td>
            <td><input class="form-control ml-5" style="width: 200px;" type="Email" name="sigEmail" id="sigEmail" value="" required placeholder="Receiver's Email"></td>
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
            <td><span style="margin-left: 30px;">Files For</span></td>
            <td>
                <select id="doctype" name="doctype" class="form-control mr-5  ml-5" style="width: 300px;">
                    <option value="Admin" selected>Admin</option>
                    <option value="Operation">Operation</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><span style="margin-left: 30px;">Number of Copy</span></td>
            <td><input class="form-control ml-5" style="width: 200px;" type="Number" name="numcopy" id="numcopy" value="" required placeholder="Number of Copy"></td>
        </tr>
        <tr>
            <td><span style="margin-left: 30px;">Number of Pages</span></td>
            <td><input class="form-control ml-5" style="width: 200px;" type="Number" name="numpages" id="numpages" value="" required placeholder="Number of Pages"></td>
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

        $(document).on("click", ".btn-ff", function() {
            var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
            var id   = $(this).attr("id"); 
            var alvel = $('input#q_user_level').val(); 

            $.ajax({
                url: "{{ url('/external-document/document-return-category') }}/"+id,
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
            swal({
                              position: 'center',
                              icon: 'info',
                              title: 'Please specify the Division  you want to forward this document',
                              showConfirmButton: false
                            });

        }else{

            document.getElementById('busywait').style.display = "table-row";

            $.ajax({
                url: "{{ url('/external-document/forward') }}/"+x_id,
                type: "POST",
                data: {_token: CSRF_TOKEN,_id: x_id,remarks: rem, division: dept, for_appro_action: faction, for_info:finfo, for_guidance:fguidance, for_reference:freference, for_review:freview,for_signature:fsignature,_classification:pr},

                success: function(response){
                    console.log(response);

                    //tempAlert("Document forwarded successfully save.",2000);
                    swal({
                              position: 'center',
                              icon: 'info',
                              title: 'Document forwarded successfully save',
                              showConfirmButton: false,
                              timer: 1500
                            });

                    //$('#doc-ff').modal('hide');
                   // window.location.href="{{ url('/external-document-list-view') }}";
                   document.getElementById('busywait').style.display = "none";
                  },
                  error: function(ex){
                    swal({
                              position: 'center',
                              icon: 'error',
                              title: 'Sending mail failed!, please check your internet coonnection and Email Addresses',
                              showConfirmButton: false
                            });
                    alert(JSON.stringify(ex));
                    //window.location.href="{{ url('/home') }}";
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
                url: "{{ url('/external-document/doc-tracking-complete') }}/"+x_id,
                type: "POST",
                data: {_token: CSRF_TOKEN,_id: x_id,division: dept},

                success: function(response){
                    console.log(response);

                    //tempAlert("Document tacking Complete.",2000);
                    swal({
                              position: 'center',
                              icon: 'info',
                              title: 'Document tracking complete.',
                              showConfirmButton: false,
                              timer: 1500
                            });

                    $('#doc-ff').modal('hide');
                    window.location.href="{{ url('/external-document-list-view') }}";
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
                url: "{{ url('/external-document/doc-tracking-approve') }}/"+x_id,
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
                    window.location.href="{{ url('/external-document-list-view') }}";
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
                url: "{{ url('/external-document/doc-tracking-disapprove') }}/"+x_id,
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
                    window.location.href="{{ url('/external-document-list-view') }}";
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
                window.location = "{{ url('/external-document/search-document') }}/" + x
            }else{
                //warnAlert("Search criteria is empty",2000);
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
                window.location = "{{ url('/external-document/filter-date') }}/" + x
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

        $(document).on("click", ".searchbtn-type", function() {
             //var x = document.getElementById("q").value;

             var x =  $('input#ff_type').val();

            if(x.length > 0){
                window.location = "{{ url('/external-document/filter-type') }}/" + x
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
                url: "{{ url('/external-document/edit-document-details') }}/"+x_id,
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
                    $('input#sigEmail').val(response.data[0].sig_email);
                    $('input#doctitle').val(response.data[0].doctitle);
                    $('input#docdesc').val(response.data[0].description);
                    $('input#briefer').val(response.data[0].briefer_number);
                    $('#doctype').val(response.data[0].type);
                    $('input#sendername').val(response.data[0].sendername);
                    $('input#numcopy').val(response.data[0].n_copy);
                    $('input#numpages').val(response.data[0].n_pages);

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
            var r_name      =       $('input#sendername').val();
            var r_email     =       $('input#sigEmail').val();
            var doctitle    =       $('input#doctitle').val();
            var desc        =       $('input#docdesc').val(); 
            var briefer     =       $('input#briefer').val();
            var ncopy       =       $('input#numcopy').val();
            var npages      =       $('input#numpages').val();
            var doctype     =       $('#doctype option:selected').text();
            var a_level=0;

            //alert(doctype);

            
            if (document.getElementById('chkdocreturn').checked) {
                retdoc=1;
            }else{
                retdoc=0;
            }

             $.ajax({
                url: "{{ url('/external-document/update-document-details') }}/"+x_id,
                type: "POST",
                data: {_token: CSRF_TOKEN,_id: x_id, _docdate: docdate, _barcode: barcode, _agency: agency, _signature: signature,_sigemail: r_email, _doctitle: doctitle,_desc: desc,_briefer: briefer, _ncopy: ncopy,_npages:npages, returndoc:retdoc, _doctype: doctype,_sendername:r_name},

                success: function(response){
                    //console.log(response);

                    //tempAlert("Update Successful....",2000);
                    swal({
                              position: 'center',
                              icon: 'info',
                              title: 'Update Successful.',
                              showConfirmButton: false,
                              timer: 1500
                            });

                    $('#doc-edit').modal('hide');
                    window.location.href="{{ url('/external-document-list-view') }}";
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
     elx.setAttribute("style","position:fixed;top:50%;left:45%;margin: 0 auto;background-color:#FF0000; border: solid thin #DF0101; border-radius: 3px; padding-left: 25px; padding-right: 25px; padding-top: 12px; padding-bottom: 12px; color: #ffffff;box-shadow:2px 5px 5px #585858;-moz-box-shadow:2px 5px 5px #585858;-webkit-box-shadow:2px 5px 5px #585858;");
     elx.innerHTML = msg;

     setTimeout(function(){
      elx.parentNode.removeChild(elx);
     },duration);
     document.body.appendChild(elx);
     $(elx).hide().fadeIn('slow');
    }


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

        if(e > 3){
            document.getElementById("ff_employees").disabled = true;
            document.getElementById("ff_employees").value="";
        }else{
            document.getElementById("ff_employees").disabled = false;
        }

            //alert(doctype);

            $.ajax({
                url: "{{ url('/external-document/docclass') }}/"+x_id,
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
                            //window.location.href="{{ url('/external-document-list-view') }}";
                    },
                        error: function(ex){
                        //alert(JSON.stringify(ex));
                        swal({
                              position: 'center',
                              icon: 'error',
                              title: 'Error checking document classification',
                              showConfirmButton: false
                            });
                        window.location.href="{{ url('/home') }}";
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
                url: "{{ url('/external-document/confidential') }}/"+x_id,
                type: "POST",
                data: {_token: CSRF_TOKEN,_id: x_id,docclass: doctype, confiname: cname},

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
                    //window.location.href="{{ url('/external-document-list-view') }}";
                  },
                  error: function(ex){
                    //alert(JSON.stringify(ex));
                    swal({
                              position: 'center',
                              icon: 'error',
                              title: 'Error checking list of users',
                              showConfirmButton: false
                            });
                    window.location.href="{{ url('/home') }}";
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
        window.location.href="{{ url('/external-document-list-view-sort-az') }}";
    }else{
        window.location.href="{{ url('/external-document-list-view') }}";
    }

}

$(document).ready(function() {

    $(document).on("click", ".btn-upload", function() {
        var x_id        =   $('input#edit_id').val();

        window.location.href="{{ url('/external-document-new-entry/upload-image') }}/"+x_id;
    });
});

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