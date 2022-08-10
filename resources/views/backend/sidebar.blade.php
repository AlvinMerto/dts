<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

<style type="text/css">
  html,
body {
  height: 100% !important;
}
.layout-boxed html,
.layout-boxed body {
  height: 100%;
}
</style>

<aside class="main-sidebar" style="height: 100%;">

    <section id="sidebar" class="sidebar">
      <ul class="sidebar-menu" data-widget="tree">
        <a href="{{ url('/home') }}">
          <li class="header" style="color: #FAFAFA; font-size: 16px;"><span class="fa fa-bar-chart" aria-hidden="true"></span> DASHBOARD</li>
        </a>

        <li class="treeview internaldocs">
          <a href="#" style="font-size: 14px;">
            <i class="fa fa-envelope"></i> <span>Internal Documents</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @if(Auth::user()->access_level == 5)
            <li style="font-size: 12px;"><a href="{{ url('/internal-document-new-entry') }}" style="font-size: 12px;"><i class="fa fa-edit"></i> New Internal Entry</a></li>
            @endif
            <li>
              <span id="internal-total-doc" class="label label-primary pull-right">0</span>
              <a href="{{url('/internal-document-list-view')}}" style="font-size: 12px;"><i class="fa fa-file-o" aria-hidden="true"></i> Internal Document Lists</a></li>
            <li>
              <span id="internal-total-pending" class="label label-warning pull-right">0</span>
              <a href="{{ url('/internal-document-list-view/pending') }}" style="font-size: 12px;"><i class="fa fa-file-o"aria-hidden="true"></i> Pending</a></li>
            <li>
              <span id="internal-total-ongoing" class="label label-info pull-right">0</span>
              <a href="{{ url('/internal-document-list-view/on-going') }}" style="font-size: 12px;"><i class="fa fa-file-o"aria-hidden="true"></i> On-going</a></li>
            <li>
              <span id="internal-total-approve" class="label label-success pull-right">0</span>
              <a href="{{ url('/internal-document-list-view/approve') }}" style="font-size: 12px;"><i class="fa fa-file-o"aria-hidden="true"></i> Approved</a></li>
            <li>
              <span id="internal-total-disapprove" class="label label-danger pull-right">0</span>
              <a href="{{url('/internal-document-list-view/disapprove')}}" style="font-size: 12px;"><i class="fa fa-file-o"aria-hidden="true"></i> Disapproved</a></li>

              <!--addon-->
            <li>
              <span id="internal-total-complete" class="label label-info pull-right">0</span>
              <a href="{{url('/internal-document-list-view/complete')}}" style="font-size: 12px;"><i class="fa fa-file-o"aria-hidden="true"></i> Complete</a></li>
            <li>

              <a href="#" style="font-size: 12px;" class="export_data_div"><i class="fa fa-cloud-download"aria-hidden="true"></i> Data Summary</a></li>
            @if(Auth::user()->access_level == 5)
            <li>
              <a href="#" style="font-size: 12px;" class="export_data"><i class="fa fa-cloud-download"aria-hidden="true"></i> Download Data</a></li>
            @endif
          </ul>
        </li>

        
        <li class="treeview indocs">
          <a href="#" style="font-size: 14px;">
            <i class="fa fa-envelope"></i> <span>External Documents</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @if(Auth::user()->access_level == 5)
            <li style="font-size: 12px;"><a href="{{ url('/external-document-new-entry') }}" style="font-size: 12px;"><i class="fa fa-edit"></i> New External Entry</a></li>
            @endif
            <li>
              <span id="total-doc" class="label label-primary pull-right">0</span>
              <a href="{{url('/external-document-list-view')}}" style="font-size: 12px;"><i class="fa fa-file-o" aria-hidden="true"></i> External Document Lists</a></li>
            <li>
              <span id="total-pending" class="label label-warning pull-right">0</span>
              <a href="{{ url('/external-document-list-view/pending') }}" style="font-size: 12px;"><i class="fa fa-file-o"aria-hidden="true"></i> Pending</a></li>
            <li>
              <span id="total-ongoing" class="label label-info pull-right">0</span>
              <a href="{{url('/external-document-list-view/on-going')}}" style="font-size: 12px;"><i class="fa fa-file-o"aria-hidden="true"></i> On-going</a></li>
            <li>
            <li>
              <span id="total-approve" class="label label-success pull-right">0</span>
              <a href="{{ url('/external-document-list-view/approve') }}" style="font-size: 12px;"><i class="fa fa-file-o"aria-hidden="true"></i> Approved</a></li>
            <li>
              <span id="total-disapprove" class="label label-danger pull-right">0</span>
              <a href="{{url('/external-document-list-view/disapprove')}}" style="font-size: 12px;"><i class="fa fa-file-o"aria-hidden="true"></i> Disapproved</a></li>

              <!--addon-->
            <li>
              <span id="total-complete" class="label label-info pull-right">0</span>
              <a href="#" style="font-size: 12px;"><i class="fa fa-file-o"aria-hidden="true"></i> Complete</a></li>
            <li>

              <a href="#" style="font-size: 12px;" class="external_export_data_div"><i class="fa fa-cloud-download"aria-hidden="true"></i> Data Summary</a></li>
            @if(Auth::user()->access_level == 5)
            <li>
              <a href="#" style="font-size: 12px;" class="external_export_data"><i class="fa fa-cloud-download"aria-hidden="true"></i> Download Data</a></li>
            @endif
          </ul>
        </li>

        
        <li class="treeview outdoc">
          <a href="#" style="font-size: 14px;">
            <i class="fa fa-envelope"aria-hidden="true"></i> <span>Outgoing Documents</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @if(Auth::user()->access_level == 5)
            <li style="font-size: 12px;"><a href="{{ url('/outgoing-document-new-entry') }}" style="font-size: 12px;"><i class="fa fa-edit"></i> New Outgoing Entry</a></li>
            @endif
            <li>
            <li>
                <span id="outgoing-total-doc" class="label label-primary pull-right">0</span>
              <a href="{{url('/outgoing-document-list-view')}}" style="font-size: 12px;"><i class="fa fa-file-o" aria-hidden="true"></i> Outgoing Document Lists</a></li>
            <li>
            <li>
              <span id="outgoing-total-pending" class="label label-warning pull-right">0</span>
              <a href="{{ url('/outgoing-document-list-view/pending') }}" style="font-size: 12px;"><i class="fa fa-file-o"aria-hidden="true"></i> Pending</a></li>
            <li>
              <span id="outgoing-total-ongoing" class="label label-info pull-right">0</span>
              <a href="#" style="font-size: 12px;"><i class="fa fa-file-o"aria-hidden="true"></i> On-going</a></li>
            <li>
              <span id="outgoing-total-approve" class="label label-success pull-right">0</span>
              <a href="{{ url('/outgoing-document-list-view/approve') }}" style="font-size: 12px;"><i class="fa fa-file-o"aria-hidden="true"></i> Approved</a></li>
            <li>
              <span id="outgoing-total-disapprove" class="label label-danger pull-right">0</span>
              <a href="{{url('/outgoing-document-list-view/disapprove')}}" style="font-size: 12px;"><i class="fa fa-file-o"aria-hidden="true"></i> Disapproved</a></li>
            <!--addon-->
            <li>
              <span id="outgoing-total-complete" class="label label-info pull-right">0</span>
              <a href="#" style="font-size: 12px;"><i class="fa fa-file-o"aria-hidden="true"></i> Complete</a></li>
            <li>

              <a href="#" style="font-size: 12px;" class="outgoing_export_data_div"><i class="fa fa-cloud-download"aria-hidden="true"></i> Data Summary</a></li>
            @if(Auth::user()->access_level == 5)
            <li>
              <a href="#" style="font-size: 12px;" class="outgoing_export_data"><i class="fa fa-cloud-download"aria-hidden="true"></i> Download Data</a></li>
            @endif
          </ul>
        </li>

        <!--li class="treeview track">
          <a href="#" style="font-size: 14px;">
            <i class="fa fa-list-ol"aria-hidden="true"></i> <span>Tracking Number</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li style="font-size: 12px;"><a href="{{url('/tracking-numbers')}}" style="font-size: 12px;"><i class="fa fa-search"></i> View Tracking Numbers</a></li>
          </ul>
        </li>

        <li class="treeview library">
          <a href="#" style="font-size: 14px;">
            <i class="fa fa-th-list"aria-hidden="true"></i> <span>Library</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li style="font-size: 12px;"><a href="{{url('/library/library/new-entry')}}" style="font-size: 12px;"><i class="fa fa-edit"></i> New Category/Type Entry</a></li>
          
            <li style="font-size: 12px;"><a href="{{url('/library/library')}}" style="font-size: 12px;"><i class="fa fa-search"></i> View Category/Type List</a></li>

            <li style="font-size: 12px;"><a href="{{url('/courier/library/new-entry')}}" style="font-size: 12px;"><i class="fa fa-edit"></i> New Entry of Mode of Releasing</a></li>
          
            <li style="font-size: 12px;"><a href="{{url('/courier/library')}}" style="font-size: 12px;"><i class="fa fa-search"></i> View Mode of Releasing List</a></li>
          </ul>
        </li>



        <li class="treeview track">
          <a href="#" style="font-size: 14px;">
            <i class="fa fa-list-ol"aria-hidden="true"></i> <span>Send Mail</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li style="font-size: 12px;"><a href="{{url('/sendMail-data')}}" style="font-size: 12px;"><i class="fa fa-search"></i> Send Mail Test</a></li>
          </ul>
        </li-->
      </ul>
    </section>
  </aside>

<!--Modal-->
<!--Modal Export Internal-->
  <div class="modal fade" id="export-internal" tabindex="-1" role="dialog"aria-labelledby="edit-modal-label" aria-hidden="true">
    <div class="modal-dialog  modal-lg" style="min-width: auto; max-width: 30%"  role="document">
      <div class="modal-content">
        <div class="modal-header"><span style="font-size: 24px; color: #2B3094; text-align: center;"><strong>EXPORT INTERNAL DOCUMENTS DATA</strong></span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();"><span aria-hidden="true">&times;</span>
          </button>
        </div>
        <span id="form_result"></span>

        <table border="1px #fff solid;" style="align-self: center;">

          <tr>
           <td colspan="2" style="font-weight: bolder !important;font-size: 20px !important;">Select Date Range</td>
          </tr>
          <tr>
              <td><span style="margin-left: 30px;">Date from</span></td>
              <td><input class="form-control ml-5" style="width: auto;" type="date" name="internalstartdate" id="internalstartdate" value="" required placeholder="Date From" title="Date From"></td>
          </tr>
          <tr>
             <td><span style="margin-left: 30px;">Date from</span></td>
              <td><input class="form-control ml-5" style="width: auto;" type="date" name="internalenddate" id="internalenddate" value="" required placeholder="Date To" title="Date To"></td>
          </tr>
          <tr>
            <td colspan="2" align="right"><button class="internal_report btn btn-sm btn-primary">Download</button></td>
          </tr>
      </table>
    </div>
  </div>
</div>


<!--Modal Export Internal Division-->

  <div class="modal fade" id="export-internal-division" tabindex="-1" role="dialog"aria-labelledby="edit-modal-label" aria-hidden="true">
    <div class="modal-dialog  modal-lg" style="min-width: auto; max-width: 30%"  role="document">
      <div class="modal-content">
        <div class="modal-header"><span style="font-size: 24px; color: #2B3094; text-align: center;"><strong>EXPORT INTERNAL DOCUMENTS DATA</strong></span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();"><span aria-hidden="true">&times;</span>
          </button>
        </div>
        <span id="form_result"></span>

        <table border="1px #fff solid;" style="align-self: center;">

          <tr>
           <td colspan="2" style="font-weight: bolder !important;font-size: 20px !important;">Select Date Range</td>
          </tr>
          <tr>
              <td><span style="margin-left: 30px;">Date from</span></td>
              <td><input class="form-control ml-5" style="width: auto;" type="date" name="divinternalstartdate" id="divinternalstartdate" value="" required placeholder="Date From" title="Date From"></td>
          </tr>
          <tr>
             <td><span style="margin-left: 30px;">Date from</span></td>
              <td><input class="form-control ml-5" style="width: auto;" type="date" name="divinternalenddate" id="divinternalenddate" value="" required placeholder="Date To" title="Date To"></td>
          </tr>
          <tr>
            <td colspan="2" align="right"><button class="internal_report_div btn btn-sm btn-success">Download</button></td>
          </tr>
      </table>
    </div>
  </div>
</div>

<!--Modal Export External-->
  <div class="modal fade" id="export-external" tabindex="-1" role="dialog"aria-labelledby="edit-modal-label" aria-hidden="true">
    <div class="modal-dialog  modal-lg" style="min-width: auto; max-width: 30%"  role="document">
      <div class="modal-content">
        <div class="modal-header"><span style="font-size: 24px; color: #2B3094; text-align: center;"><strong>EXPORT EXTERNAL DOCUMENTS DATA</strong></span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();"><span aria-hidden="true">&times;</span>
          </button>
        </div>
        <span id="form_result"></span>

        <table border="1px #fff solid;" style="align-self: center;">

          <tr>
           <td colspan="2" style="font-weight: bolder !important;font-size: 20px !important;">Select Date Range</td>
          </tr>
          <tr>
              <td><span style="margin-left: 30px;">Date from</span></td>
              <td><input class="form-control ml-5" style="width: auto;" type="date" name="externalstartdate" id="externalstartdate" value="" required placeholder="Date From" title="Date From"></td>
          </tr>
          <tr>
             <td><span style="margin-left: 30px;">Date from</span></td>
              <td><input class="form-control ml-5" style="width: auto;" type="date" name="externalenddate" id="externalenddate" value="" required placeholder="Date To" title="Date To"></td>
          </tr>
          <tr>
            <td colspan="2" align="right"><button class="external_report btn btn-sm btn-primary">Download</button></td>
          </tr>
      </table>
    </div>
  </div>
</div>


<!--Modal Export External Division-->

  <div class="modal fade" id="export-external-division" tabindex="-1" role="dialog"aria-labelledby="edit-modal-label" aria-hidden="true">
    <div class="modal-dialog  modal-lg" style="min-width: auto; max-width: 30%"  role="document">
      <div class="modal-content">
        <div class="modal-header"><span style="font-size: 24px; color: #2B3094; text-align: center;"><strong>EXPORT EXTERNAL DOCUMENTS DATA</strong></span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();"><span aria-hidden="true">&times;</span>
          </button>
        </div>
        <span id="form_result"></span>

        <table border="1px #fff solid;" style="align-self: center;">

          <tr>
           <td colspan="2" style="font-weight: bolder !important;font-size: 20px !important;">Select Date Range</td>
          </tr>
          <tr>
              <td><span style="margin-left: 30px;">Date from</span></td>
              <td><input class="form-control ml-5" style="width: auto;" type="date" name="divexternalstartdate" id="divexternalstartdate" value="" required placeholder="Date From" title="Date From"></td>
          </tr>
          <tr>
             <td><span style="margin-left: 30px;">Date from</span></td>
              <td><input class="form-control ml-5" style="width: auto;" type="date" name="divexternalenddate" id="divexternalenddate" value="" required placeholder="Date To" title="Date To"></td>
          </tr>
          <tr>
            <td colspan="2" align="right"><button class="external_report_div btn btn-sm btn-success">Download</button></td>
          </tr>
      </table>
    </div>
  </div>
</div>


<!--Modal Export Outgoing-->
  <div class="modal fade" id="export-outgoing" tabindex="-1" role="dialog"aria-labelledby="edit-modal-label" aria-hidden="true">
    <div class="modal-dialog  modal-lg" style="min-width: auto; max-width: 30%"  role="document">
      <div class="modal-content">
        <div class="modal-header"><span style="font-size: 24px; color: #2B3094; text-align: center;"><strong>EXPORT OUTGOING DOCUMENTS DATA</strong></span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();"><span aria-hidden="true">&times;</span>
          </button>
        </div>
        <span id="form_result"></span>

        <table border="1px #fff solid;" style="align-self: center;">

          <tr>
           <td colspan="2" style="font-weight: bolder !important;font-size: 20px !important;">Select Date Range</td>
          </tr>
          <tr>
              <td><span style="margin-left: 30px;">Date from</span></td>
              <td><input class="form-control ml-5" style="width: auto;" type="date" name="outgoingstartdate" id="outgoingstartdate" value="" required placeholder="Date From" title="Date From"></td>
          </tr>
          <tr>
             <td><span style="margin-left: 30px;">Date from</span></td>
              <td><input class="form-control ml-5" style="width: auto;" type="date" name="outgoingenddate" id="outgoingenddate" value="" required placeholder="Date To" title="Date To"></td>
          </tr>
          <tr>
            <td colspan="2" align="right"><button class="outgoing_report btn btn-sm btn-primary">Download</button></td>
          </tr>
      </table>
    </div>
  </div>
</div>


<!--Modal Export Outgoing Division-->

  <div class="modal fade" id="export-outgoing-division" tabindex="-1" role="dialog"aria-labelledby="edit-modal-label" aria-hidden="true">
    <div class="modal-dialog  modal-lg" style="min-width: auto; max-width: 30%"  role="document">
      <div class="modal-content">
        <div class="modal-header"><span style="font-size: 24px; color: #2B3094; text-align: center;"><strong>EXPORT OUTGOING DOCUMENTS DATA</strong></span>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();"><span aria-hidden="true">&times;</span>
          </button>
        </div>
        <span id="form_result"></span>

        <table border="1px #fff solid;" style="align-self: center;">

          <tr>
           <td colspan="2" style="font-weight: bolder !important;font-size: 20px !important;">Select Date Range</td>
          </tr>
          <tr>
              <td><span style="margin-left: 30px;">Date from</span></td>
              <td><input class="form-control ml-5" style="width: auto;" type="date" name="divoutgoingstartdate" id="divoutgoingstartdate" value="" required placeholder="Date From" title="Date From"></td>
          </tr>
          <tr>
             <td><span style="margin-left: 30px;">Date from</span></td>
              <td><input class="form-control ml-5" style="width: auto;" type="date" name="divoutgoingenddate" id="divoutgoingenddate" value="" required placeholder="Date To" title="Date To"></td>
          </tr>
          <tr>
            <td colspan="2" align="right"><button class="outgoing_report_div btn btn-sm btn-success">Download</button></td>
          </tr>
      </table>
    </div>
  </div>
</div>

<script>

$(document).ready(function() {
        var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');

        $(document).on("click", ".export_data", function(e) {
            var x_id        =   this.id;


            $('#export-internal').modal('show');
        });       
    });

//Internal
$(document).ready(function() {
        var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');

        $(document).on("click", ".export_data_div", function(e) {
            var x_id        =   this.id;

             $('#export-internal-division').modal('show');
        });       
    });


$(document).ready(function(){
    var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
    
    $(document).on("click",".internal_report", function(e){
      var startdate   = $('input#internalstartdate').val();
      var enddate     = $('input#internalenddate').val();

      if(!$.trim(startdate)) {
        //alert("Please enter starting date");
        swal({
                 position: 'center',
                 icon: 'error',
                 title: 'Please enter starting date',
                 showConfirmButton: false
               });
      }else{

        if(!$.trim(enddate)){
        swal({
                 position: 'center',
                 icon: 'error',
                 title: 'Please enter ending date',
                 showConfirmButton: false
               });

        }else{
          //alert(startdate);
          $.ajax({
            url: "{{url('/export-excel/internal-records-range')}}/"+startdate+"/"+enddate,
            type: "GET",
            data: {_token: CSRF_TOKEN,_startdate: startdate,_enddate:enddate},
            success:function(response){

              //alert(JSON.stringify(response));
              swal({
                 position: 'center',
                 icon: 'success',
                 title: 'Data exported to Excel',
                 showConfirmButton: false
               });

              window.location.href = response.url;
            },
            error: function(ex){
                    alert(JSON.stringify(ex));
                    //window.location.href="{{ url('/home') }}";
                  },
          });
          e.preventDefault();
        }
      }   
    });

});

$(document).ready(function(){
    var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
    
    $(document).on("click",".internal_report_div", function(e){
      var startdate   = $('input#divinternalstartdate').val();
      var enddate     = $('input#divinternalenddate').val();
      var idivision   = "{{ Auth::user()->division }}";


      if(!$.trim(startdate)) {
        //alert("Please enter starting date");
        swal({
                 position: 'center',
                 icon: 'error',
                 title: 'Please enter starting date',
                 showConfirmButton: false
               });
      }else{

        if(!$.trim(enddate)){
        swal({
                 position: 'center',
                 icon: 'error',
                 title: 'Please enter ending date',
                 showConfirmButton: false
               });

        }else{
          //alert(startdate);
          $.ajax({
            url: "{{url('/internal-document/division-record-summary')}}/"+startdate+"/"+enddate,
            type: "GET",
            data: {_token: CSRF_TOKEN,_startdate: startdate,_enddate:enddate,_division:idivision},
            success:function(response){

              swal({
                 position: 'center',
                 icon: 'success',
                 title: 'Data exported to Excel',
                 showConfirmButton: false
               });

              window.location.href = response.url;
              //alert(JSON.stringify(response));
            },
            error: function(ex){
                    alert(JSON.stringify(ex));
                    //window.location.href="{{ url('/home') }}";
                  },
          });
          e.preventDefault();
        }
      }   
    });

});

//External

$(document).ready(function() {
        var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');

        $(document).on("click", ".external_export_data", function(e) {
            var x_id        =   this.id;


            $('#export-external').modal('show');
        });       
    });

$(document).ready(function(){
    var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
    
    $(document).on("click",".external_report", function(e){
      var startdate   = $('input#externalstartdate').val();
      var enddate     = $('input#externalenddate').val();

      if(!$.trim(startdate)) {
        //alert("Please enter starting date");
        swal({
                 position: 'center',
                 icon: 'error',
                 title: 'Please enter starting date',
                 showConfirmButton: false
               });
      }else{

        if(!$.trim(enddate)){
        swal({
                 position: 'center',
                 icon: 'error',
                 title: 'Please enter ending date',
                 showConfirmButton: false
               });

        }else{
          //alert(startdate);
          $.ajax({
            url: "{{url('/export-excel/external-records-range')}}/"+startdate+"/"+enddate,
            type: "GET",
            data: {_token: CSRF_TOKEN,_startdate: startdate,_enddate:enddate},
            success:function(response){

              //alert(JSON.stringify(response));
              swal({
                 position: 'center',
                 icon: 'success',
                 title: 'Data exported to Excel',
                 showConfirmButton: false
               });

              window.location.href = response.url;
            },
            error: function(ex){
                    alert(JSON.stringify(ex));
                    //window.location.href="{{ url('/home') }}";
                  },
          });
          e.preventDefault();
        }
      }   
    });

});

$(document).ready(function() {
        var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');

        $(document).on("click", ".external_export_data_div", function(e) {
            var x_id        =   this.id;

             $('#export-external-division').modal('show');
        });       
    });

$(document).ready(function(){
    var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
    
    $(document).on("click",".external_report_div", function(e){
      var startdate   = $('input#divexternalstartdate').val();
      var enddate     = $('input#divexternalenddate').val();
      var idivision   = "{{ Auth::user()->division }}";


      if(!$.trim(startdate)) {
        //alert("Please enter starting date");
        swal({
                 position: 'center',
                 icon: 'error',
                 title: 'Please enter starting date',
                 showConfirmButton: false
               });
      }else{

        if(!$.trim(enddate)){
        swal({
                 position: 'center',
                 icon: 'error',
                 title: 'Please enter ending date',
                 showConfirmButton: false
               });

        }else{
          //alert(startdate);
          $.ajax({
            url: "{{url('/external-document/division-record-summary')}}/"+startdate+"/"+enddate,
            type: "GET",
            data: {_token: CSRF_TOKEN,_startdate: startdate,_enddate:enddate,_division:idivision},
            success:function(response){

              swal({
                 position: 'center',
                 icon: 'success',
                 title: 'Data exported to Excel',
                 showConfirmButton: false
               });

              window.location.href = response.url;
              //alert(JSON.stringify(response));
            },
            error: function(ex){
                    alert(JSON.stringify(ex));
                    //window.location.href="{{ url('/home') }}";
                  },
          });
          e.preventDefault();
        }
      }   
    });

});

//Outgoing///
$(document).ready(function() {
        var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');

        $(document).on("click", ".outgoing_export_data", function(e) {
            var x_id        =   this.id;


            $('#export-outgoing').modal('show');
        });       
    });

$(document).ready(function(){
    var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
    
    $(document).on("click",".outgoing_report", function(e){
      var startdate   = $('input#outgoingstartdate').val();
      var enddate     = $('input#outgoingenddate').val();

      if(!$.trim(startdate)) {
        //alert("Please enter starting date");
        swal({
                 position: 'center',
                 icon: 'error',
                 title: 'Please enter starting date',
                 showConfirmButton: false
               });
      }else{

        if(!$.trim(enddate)){
        swal({
                 position: 'center',
                 icon: 'error',
                 title: 'Please enter ending date',
                 showConfirmButton: false
               });

        }else{
          //alert(startdate);
          $.ajax({
            url: "{{url('/export-excel/outgoing-records-range')}}/"+startdate+"/"+enddate,
            type: "GET",
            data: {_token: CSRF_TOKEN,_startdate: startdate,_enddate:enddate},
            success:function(response){

              //alert(JSON.stringify(response));
              swal({
                 position: 'center',
                 icon: 'success',
                 title: 'Data exported to Excel',
                 showConfirmButton: false
               });

              window.location.href = response.url;
            },
            error: function(ex){
                    alert(JSON.stringify(ex));
                    //window.location.href="{{ url('/home') }}";
                  },
          });
          e.preventDefault();
        }
      }   
    });

});


$(document).ready(function() {
        var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');

        $(document).on("click", ".outgoing_export_data_div", function(e) {
            var x_id        =   this.id;

             $('#export-outgoing-division').modal('show');
        });       
    });

$(document).ready(function(){
    var CSRF_TOKEN  = $('meta[name="csrf-token"]').attr('content');
    
    $(document).on("click",".outgoing_report_div", function(e){
      var startdate   = $('input#divoutgoingstartdate').val();
      var enddate     = $('input#divoutgoingenddate').val();
      var idivision   = "{{ Auth::user()->division }}";


      if(!$.trim(startdate)) {
        //alert("Please enter starting date");
        swal({
                 position: 'center',
                 icon: 'error',
                 title: 'Please enter starting date',
                 showConfirmButton: false
               });
      }else{

        if(!$.trim(enddate)){
        swal({
                 position: 'center',
                 icon: 'error',
                 title: 'Please enter ending date',
                 showConfirmButton: false
               });

        }else{
          //alert(startdate);
          $.ajax({
            url: "{{url('/outgoing-document/division-record-summary')}}/"+startdate+"/"+enddate,
            type: "GET",
            data: {_token: CSRF_TOKEN,_startdate: startdate,_enddate:enddate,_division:idivision},
            success:function(response){

              swal({
                 position: 'center',
                 icon: 'success',
                 title: 'Data exported to Excel',
                 showConfirmButton: false
               });

              window.location.href = response.url;
              //alert(JSON.stringify(response));
            },
            error: function(ex){
                    alert(JSON.stringify(ex));
                    //window.location.href="{{ url('/home') }}";
                  },
          });
          e.preventDefault();
        }
      }   
    });

});
//End for Modal

  $(document).ready(function () {

  url = "{{url('/count-external-docs')}}";

  $.get(url, function (response) {
            console.log(response);  
            
            var r = response.data; 
            var p = response.cnt_p;
            var a = response.appr;
            var d = response.disapp;
            var c = response.excomplete;
            var o = response.external_ongoing;

            document.getElementById("total-doc").innerHTML=r;
            document.getElementById("total-pending").innerHTML=p;
            document.getElementById("total-approve").innerHTML=a;
            document.getElementById("total-disapprove").innerHTML=d;
            document.getElementById("total-complete").innerHTML=c;
            document.getElementById("total-ongoing").innerHTML=o;

      });

  internal_url = "{{url('/count-internal-docs')}}";

  $.get(internal_url, function (internal_response) {
            console.log(internal_response);  
            
            var internal_r = internal_response.internal_data; 
            var internal_p = internal_response.internal_cnt_p;
            var internal_a = internal_response.internal_appr;
            var internal_d = internal_response.internal_disapp;
            var internal_c = internal_response.internal_complete;
            var internal_o = internal_response.internal_ongoing;

            document.getElementById("internal-total-doc").innerHTML=internal_r;
            document.getElementById("internal-total-pending").innerHTML=internal_p;
            document.getElementById("internal-total-approve").innerHTML=internal_a;
            document.getElementById("internal-total-disapprove").innerHTML=internal_d;
            document.getElementById("internal-total-complete").innerHTML=internal_c;
            document.getElementById("internal-total-ongoing").innerHTML=internal_o;
            

      });

  outgoing_url = "{{url('/count-outgoing-docs')}}";

  $.get(outgoing_url, function (outgoing_response) {
            console.log(outgoing_response);  
            
            var outgoing_r = outgoing_response.outgoing_data; 
            var outgoing_p = outgoing_response.outgoing_cnt_p;
            var outgoing_a = outgoing_response.outgoing_appr;
            var outgoing_d = outgoing_response.outgoing_disapp;
            var outgoing_c = outgoing_response.outgoing_complete;

            document.getElementById("outgoing-total-doc").innerHTML=outgoing_r;
            document.getElementById("outgoing-total-pending").innerHTML=outgoing_p;
            document.getElementById("outgoing-total-approve").innerHTML=outgoing_a;
            document.getElementById("outgoing-total-disapprove").innerHTML=outgoing_d;
            document.getElementById("outgoing-total-complete").innerHTML=outgoing_c;

      });

    var type = $('input#type_input').val();

    if (type=='external'){
      $("li.indocs").removeClass("indocs").addClass("active indocs treeview");
    }else if(type=='internal'){
      $("li.internaldocs").removeClass("internaldocs").addClass("active internaldocs treeview");
    }else if(type=='outgoing'){
      $("li.outdoc").removeClass("outdoc").addClass("active outdoc treeview");
    }else if(type=='tracking'){
      $("li.track").removeClass("track").addClass("active track treeview");
    }else if(type=='library'){
      $("li.library").removeClass("library").addClass("active library treeview");
    }

});
</script>
