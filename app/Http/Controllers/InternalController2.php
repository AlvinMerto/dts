<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Internal;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\ProjectCount;
use App\Jobs\SendEmail;
use Auth;
use DB;
use Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;

class InternalController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function new_document()
    {
        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        $lib = DB::table('library')
                    ->orderBy('library.id','asc')
                    ->get();

        $div = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        
    	return view('internal.doc-new-entry',compact('userlist','lib','div'));
    }

    public function save_new_documnent(Request $request)
    {
    	$data = new Internal;

    	if($request->hasFile('img_file')) {
            $filenameWithExt = $request->file('img_file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);            
            $extension = $request->file('img_file')->getClientOriginalExtension();
            $fileNameToStore = time().'_'.$filename.'.'.$extension;                       

            $file = $request->file('img_file');
            $file->getClientOriginalName();
            $encryp = md5($file);
            $destinationPath = 'public/uploads';
            $file->move($destinationPath,$encryp.'.'.$extension);

        } else {
            $encryp='noimage';
            $extension='jpg';
        }

        $data->doctitle			=	$request->get('doctitle');
        $data->description		=	$request->get('docdesc'); //'Document added on '.Carbon::now('Asia/Hong_Kong')->format('F j, Y').' @ '.Carbon::now('Asia/Hong_Kong')->format('g:i:s a');//$request->get('docdesc');
        $data->briefer_number   =   $request->get('briefer');
        $data->barcode			=	$request->get('barcode');
        //new added
        $data->signatory        =   $request->get('signature');
        $data->agency           =   $request->get('agency');
        //
        $data->sender			=	Auth::user()->division; //$request->get('division');
        $data->type 			=	'Internal Documents'; //$request->get('doctype'); //
        $data->doc_receive      =   $request->get('docdate');
        $data->doc_date_ff      =   Carbon::now();
        $data->image            =   $encryp.'.'.$extension;

        if($request->has('chkdocreturn')){
            $data->retdoc  = 1;
        }else{
            $data->retdoc  = 0;
        }
        

        $data->save();

        $dept = DB::insert('insert into internal_departments (ff_id, dept, stat) values (?, ?, ?)',
            [
                $data->id,
                Auth::user()->division,
                'pending',
            ]);

        $classification =  $request->get('docclassification');
        $confidential =  $request->get('ff_employee');

        $history = DB::insert('insert into internal_history (ref_id, remarks, date_ff, date_forwared, days_count, department, stat,classification,confi_name,destination) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
               $data->id,
               'Document Tracking Started',
                Carbon::now(),
                Carbon::now('Asia/Hong_Kong')->format('F j, Y').' @ '.Carbon::now('Asia/Hong_Kong')->format('g:i:s a'),   
                '0',
                Auth::user()->division,
                'pending',
                $classification,
                $confidential,
                Auth::user()->division,
            ]);

            $projectcounts = ProjectCount::firstOrCreate(
                    ['year' => Carbon::now()->format('Y')],
                    ['project_count' => 0]
                );
            $projectcounts->save();

            $countitem = ProjectCount::where('year', now()->year)->increment('project_count');

            $docscount = DB::table('project_counts')
                        ->where(['year' => Carbon::now()->format('Y')])
                        ->get(['project_count']);

            foreach ($docscount as $c) {
                $cc = $c->project_count;
            }

            $docs = 'MinDA-'.Carbon::now()->format('Y').'-'.str_pad($cc, 5, '0', STR_PAD_LEFT);

            $track = DB::insert('insert into tracking_number (ref_id,tracking_series,barcode,doctitle,docdescription,doctype) values (?, ?, ?, ?, ?, ?)',
                [
                    $data->id,
                    $docs,
                    $request->get('barcode'),
                    $request->get('doctitle'),
                    $request->get('docdesc'),
                    'Internal',
                ]);

        return redirect('/internal-document-new-entry/upload-image/'.$data->id);
    }

    public function upload_image(Request $request, $id){
        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        $datefilter = DB::table('internals')
                        ->groupBy('internals.doc_receive')
                        ->orderBy('internals.id','asc')
                        ->get();

        $data = DB::table('internals')
                    ->where(['internals.id'=>$id])
                    ->get();

        $docimages = DB::table('internal_files')
                    ->where(['internal_files.ref_id'=>$id])
                    ->orderBy('internal_files.id','asc')
                    ->get();

        return view('internal.doc-upload-image',compact('data','papcode','userlist','datefilter','docimages'));
    }

    public function save_image(Request $request, $id){
        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        $datefilter = DB::table('internals')
                        ->groupBy('internals.doc_receive')
                        ->orderBy('internals.id','asc')
                        ->get();

        $data = DB::table('internals')
                    ->where(['internals.id'=>$id])
                    ->get();


        if($request->hasFile('img_file')) {
            foreach ($request->file('img_file') as $xfile) {

                $filenameWithExt = $xfile->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);            
                $extension = $xfile->getClientOriginalExtension();
                $fileNameToStore = time().'_'.$filename.'.'.$extension;                       

                $file = $xfile;
                $file->getClientOriginalName();
                $encryp = md5($file);
                $destinationPath = 'public/uploads';
                $file->move($destinationPath,$encryp.'.'.$extension);

                $docimage = DB::insert('insert into internal_files (ref_id,img_file,doc_title) values (?, ?, ?)',
                [
                    $id,
                    $encryp.'.'.$extension,
                    $request->get('docname'),
                ]);
            }
        } else {
            $encryp='noimage';
            $extension='jpg';
        }
        

        return redirect('/internal-document-new-entry/upload-image/'.$id);

    }

    public function remove_file($id,$ref_id,$img)
    {
        $docimage = DB::table('internal_files')
                    ->where(['internal_files.id'=>$id])
                    ->delete();

        //File::delete($img);
        $image_path = public_path().'/uploads'.$img; 
        //unlink($image_path);

        File::delete('public/uploads/'.$img);

        return redirect('/internal-document-new-entry/upload-image/'.$ref_id);
    }

    public function list_document()
    {
        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        $docs = DB::table('internals')
            ->get();

        $datefilter = DB::table('internals')
                        ->groupBy('internals.doc_receive')
                        ->orderBy('internals.id','asc')
                        ->get();

        $div = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        $lib = DB::table('library')
                    ->orderBy('library.id','asc')
                    ->get();


        foreach ($docs as $i)
            {
                $prevdate = $i->doc_date_ff;
                $doc_id = $i->id;

                    $curdate = Carbon::now();

                    $diff = Carbon::parse($curdate)->diffInDays($prevdate);

                    $update_doc = DB::table('internals')
                            ->where(['internals.id'=>$doc_id,'internals.status'=>'pending'])
                            ->update([
                                'day_count'=>$diff,
                            ]);
            }

            
        $data = DB::table('internal_departments')
                ->join('internals','internal_departments.ff_id','=','internals.id')
                ->join('internal_history','internal_departments.ff_id','=','internal_history.ref_id')
                ->where(['internal_departments.dept'=>Auth::user()->division])
                ->where(['internal_history.department'=>Auth::user()->division])
                ->orderBy('internal_history.days_count','desc')
                ->orderBy('internal_history.actioned','asc')
                ->orderBy('internal_history.classification','desc')
                ->orderBy('internal_history.ref_id','desc')
                ->groupBy('internals.barcode')
                ->paginate(10)
                ->onEachSide(2);


        //dd($data);
        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        
    	return view('internal.doc-view-list',compact('data','papcode','userlist','datefilter','div','lib'));
    }

    public function list_document_ascending()
    {
        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        $docs = DB::table('internals')
            ->get();

        $datefilter = DB::table('internals')
                        ->groupBy('internals.doc_receive')
                        ->orderBy('internals.id','asc')
                        ->get();

        $lib = DB::table('library')
                    ->orderBy('library.id','asc')
                    ->get();

        $div = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        foreach ($docs as $i)
            {
                $prevdate = $i->doc_date_ff;
                $doc_id = $i->id;

                    $curdate = Carbon::now();

                    $diff = Carbon::parse($curdate)->diffInDays($prevdate);

                    $update_doc = DB::table('internals')
                            ->where(['internals.id'=>$doc_id,'internals.status'=>'pending'])
                            ->update([
                                'day_count'=>$diff,
                            ]);
            }

            
        $data = DB::table('internal_departments')
                ->join('internals','internal_departments.ff_id','=','internals.id')
                ->join('internal_history','internal_departments.ff_id','=','internal_history.ref_id')
                ->where(['internal_departments.dept'=>Auth::user()->division])
                ->where(['internal_history.department'=>Auth::user()->division])
                ->groupBy('internals.barcode')
                //->orderBy('internal_history.classification','asc')
                //->orderBy('internal_history.days_count','asc')
                ->orderBy('internals.created_at','asc')
                ->paginate(10)
                ->onEachSide(2);


        //dd($data);
        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        return view('internal.doc-view-list',compact('data','papcode','userlist','datefilter','lib','div'));
    }


    public function pending_list()
    {
        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        $datefilter = DB::table('internals')
                        ->groupBy('internals.doc_receive')
                        ->orderBy('internals.id','asc')
                        ->get();

        $lib = DB::table('library')
                    ->orderBy('library.id','asc')
                    ->get();

        $div = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        $data = DB::table('internal_departments')
                ->join('internals','internal_departments.ff_id','=','internals.id')
                ->join('internal_history','internal_departments.ff_id','=','internal_history.ref_id')
                ->where(['internal_departments.dept'=>Auth::user()->division])
                ->where(['internal_history.department'=>Auth::user()->division, 'internal_history.stat'=>'pending'])
                ->groupBy('internals.barcode')
                ->orderBy('internals.day_count','desc')
                ->orderBy('internals.created_at','desc')
                ->paginate(10)
                ->onEachSide(2);


        //dd($data);
        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        return view('internal.doc-view-list',compact('data','papcode','userlist','datefilter','lib','div'));
    }

    public function ongoing_list()
    {
        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        $datefilter = DB::table('internals')
                        ->groupBy('internals.doc_receive')
                        ->orderBy('internals.id','asc')
                        ->get();

        $lib = DB::table('library')
                    ->orderBy('library.id','asc')
                    ->get();

        $div = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        $data = DB::table('internal_departments')
                ->join('internals','internal_departments.ff_id','=','internals.id')
                ->join('internal_history','internal_departments.ff_id','=','internal_history.ref_id')
                ->where(['internal_departments.dept'=>Auth::user()->division])
                ->where(['internal_history.department'=>Auth::user()->division, 'internal_history.stat'=>'on-going'])
                ->groupBy('internals.barcode')
                ->orderBy('internals.day_count','desc')
                ->orderBy('internals.created_at','desc')
                ->paginate(10)
                ->onEachSide(2);


        //dd($data);
        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        return view('internal.doc-view-list',compact('data','papcode','userlist','datefilter','lib','div'));
    }

    public function approve_list()
    {
        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        $datefilter = DB::table('internals')
                        ->groupBy('internals.doc_receive')
                        ->orderBy('internals.id','asc')
                        ->get();

        $lib = DB::table('library')
                    ->orderBy('library.id','asc')
                    ->get();

        $div = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        $data = DB::table('internal_departments')
                ->join('internals','internal_departments.ff_id','=','internals.id')
                ->join('internal_history','internal_departments.ff_id','=','internal_history.ref_id')
                ->where(['internal_departments.dept'=>Auth::user()->division])
                ->where(['internal_history.department'=>Auth::user()->division, 'internal_history.stat'=>'approve'])
                ->groupBy('internals.barcode')
                ->orderBy('internals.day_count','desc')
                ->orderBy('internals.created_at','desc')
                ->paginate(10)
                ->onEachSide(2);


        //dd($data);
        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        return view('internal.doc-view-list',compact('data','papcode','userlist','datefilter','lib','div'));
    }

    public function disapprove_list()
    {
        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        $datefilter = DB::table('internals')
                        ->groupBy('internals.doc_receive')
                        ->orderBy('internals.id','asc')
                        ->get();

        $lib = DB::table('library')
                    ->orderBy('library.id','asc')
                    ->get();

        $div = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        $data = DB::table('internal_departments')
                ->join('internals','internal_departments.ff_id','=','internals.id')
                ->join('internal_history','internal_departments.ff_id','=','internal_history.ref_id')
                ->where(['internal_departments.dept'=>Auth::user()->division])
                ->where(['internal_history.department'=>Auth::user()->division, 'internal_history.stat'=>'disapprove'])
                ->groupBy('internals.barcode')
                ->orderBy('internals.day_count','desc')
                ->orderBy('internals.created_at','desc')
                ->paginate(10)
                ->onEachSide(2);


        //dd($data);
        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        return view('internal.doc-view-list',compact('data','papcode','userlist','datefilter','lib','div'));
    }

    public function complete_list()
    {
        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        $datefilter = DB::table('internals')
                        ->groupBy('internals.doc_receive')
                        ->orderBy('internals.id','asc')
                        ->get();

        $lib = DB::table('library')
                    ->orderBy('library.id','asc')
                    ->get();

        $div = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        $data = DB::table('internal_departments')
                ->join('internals','internal_departments.ff_id','=','internals.id')
                ->join('internal_history','internal_departments.ff_id','=','internal_history.ref_id')
                ->where(['internal_departments.dept'=>Auth::user()->division])
                ->where(['internal_history.department'=>Auth::user()->division, 'internal_history.stat'=>'complete'])
                ->groupBy('internals.barcode')
                ->orderBy('internals.day_count','desc')
                ->orderBy('internals.created_at','desc')
                ->paginate(10)
                ->onEachSide(2);


        //dd($data);
        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        return view('internal.doc-view-list',compact('data','papcode','userlist','datefilter','lib','div'));
    }

    public function ff_doc(Request $request, $id)
    {
        if(request()->ajax())
        {

            $history_update = DB::table('internal_history')
                        ->where(['internal_history.ref_id'=>$id, 'internal_history.department'=>Auth::user()->division])
                        ->update([
                            'stat'=>'on-going',
                        ]);

            $dept_update = DB::table('internal_departments')
                        ->where(['internal_departments.ff_id'=>$id, 'internal_departments.dept'=>Auth::user()->division])
                        ->update([
                            'stat'=>'on-going',
                        ]);
                        
            $docs = DB::table('internals')
                    ->where(['internals.id'=>$id])
                    ->get();

                foreach ($docs as $i)
                    {
                        $prevdate = $i->doc_date_ff;
                    }

            //echo $prevdate;

            $curdate = Carbon::now();

            $diff = Carbon::parse($curdate)->diffInDays($prevdate);

            $action_remarks = "";

            if($request->get('for_appro_action') == 1){
                $action_remarks = '*for appropriate action*, <br>';

            }

            if($request->get('for_info') == 1){
                $action_remarks = $action_remarks.' *for information*, <br>';

            }

            if($request->get('for_guidance')==1){
                $action_remarks = $action_remarks.' *for guidance*, <br>';

            }

            if($request->get('for_reference')==1){
                $action_remarks = $action_remarks.' *for reference*, <br>';

            }

            if($request->get('for_review')==1){
                $action_remarks = $action_remarks.' *for review and evaluation* <br>';

            }

            if($request->get('for_signature')==1){
                $action_remarks = $action_remarks.' *for approval/signature* <br>';

            }

            if($request->get('remarks') !=""){
                $action_remarks = $action_remarks.($request->get('remarks'));

            }

            $data = DB::insert('insert into internal_history (ref_id, remarks, date_ff, date_forwared, days_count, department,stat, destination,classification,actioned) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', 
                [
                $request->get('_id'),
                $action_remarks,
                Carbon::now(),
                Carbon::now('Asia/Hong_Kong')->format('F j, Y').' @ '.Carbon::now('Asia/Hong_Kong')->format('g:i:s a'),
                $diff,
                $request->get('division'),
                'pending',
                Auth::user()->f_name. ' from '. Auth::user()->division.' Forwarded to '.$request->get('division'),
                $request->get('_classification'),
                0,

            ]);

            $dept = DB::insert('insert into internal_departments (ff_id, dept, stat) values (?, ?, ?)',
            [
                $request->get('_id'),
                $request->get('division'),
                'pending',
            ]);

            $update_doc = DB::table('internals')
                    ->where(['internals.id'=>$id])
                    ->update([
                        'doc_date_ff'=>Carbon::now(),
                        'status'=>'on-going',
                    ]);

            /*
            if(is_null($request->get('confi'))){
                    $subscriber_emails = DB::table('users')
                            ->where(['users.division' => $request->get('division')])
                            ->get();

                    $mdata = array('name'=>"Document Tracking Notification");

                    foreach ($subscriber_emails as $mail){
                        $receiptient = $mail->email;

                        if(!is_null($receiptient)){
                            Mail::send('mailer.mail-internal', $mdata, function($message) use ($receiptient){
                                $message->from('no-reply@minda.gov.ph');
                                $message->to($receiptient);
                                $message->subject('Document Tracking Notification');
                            });
                        }
                    }
                }
                */

                if(is_null($request->get('confi'))){
                    $this->send_email($request->get('division'),$request->get('_classification'),$id);
                }else{
                    $this->send_to_user($request->get('confi'),$request->get('_classification'),$id);
                }

            return response()->JSON(['data' => $data]);
        }
    }

    public function get_return_value($id)
    {

        if(request()->ajax())
        {
            $data = DB::table('internals')
                    ->join('internal_history','internals.id','=','internal_history.ref_id')
                    ->where(['internals.id'=>$id])
                    ->get();

            return response()->JSON(['data' => $data]);
        }
        
    }

    public function send_email($division,$class,$id) {
      //if(is_null($name){
        $subscriber_emails = DB::table('users')
                    ->where(['users.division' => $division])
                    ->get();

        $mdata = array('name'=>$class." Mail from Document Tracking System");

            foreach ($subscriber_emails as $mail){
                $receiptient = $mail->email;

                    if(!is_null($receiptient)){

                        if($class==1){
                            $pr="Confidential";
                        }elseif ($class==2) {
                            $pr="High Priority";
                        }elseif ($class==3) {
                            $pr="Moderate Priority";
                        }elseif ($class==4) {
                            $pr="Low Priority";
                        }elseif ($class==0) {
                            $pr="Undefined";
                        }
                        
                        
                        Mail::send('mailer.mail-internal', $mdata, function($message) use ($receiptient,$pr){
                            $message->from('no-reply@minda.gov.ph');
                            $message->to($receiptient);
                            $message->subject($pr.' Mail from Document Tracking System');
                        });
                        

                    }
            }
            
   }

   public function send_to_user($name,$class,$id){
        $subscriber_emails = DB::table('users')
                    ->where(['users.f_name' => $name])
                    ->get();

            $mdata = ['name'=>"Mindanao Development Authority",'im'=>$id];

            foreach ($subscriber_emails as $mail){
                $receiptient = $mail->email;



                if($class==1){
                    $pr="Confidential";
                }elseif ($class==2) {
                    $pr="High Priority";
                }elseif ($class==3) {
                    $pr="Moderate Priority";
                }elseif ($class==4) {
                    $pr="Low Priority";
                }elseif ($class==0) {
                    $pr="Undefined";
                }
                    
                    Mail::send('mailer.mail-internal-user', $mdata, function($message) use ($receiptient,$pr){
                          $message->from('no-reply@minda.gov.ph');
                          $message->to($receiptient);
                          $message->subject($pr.' Mail from Document Tracking System');
                      });
      
            }
   }

    public function count_all()
    {
        if(request()->ajax())
        {
            $internal_cnt = DB::table('internal_departments')
                            ->join('internals','internal_departments.ff_id','=','internals.id')
                            ->where(['internal_departments.dept'=>Auth::user()->division])
                            ->groupBy('internals.barcode')
                            ->get()
                            ->count();

            $internal_cnt_pending = DB::table('internal_history')
                            ->join('internals','internal_history.ref_id','=','internals.id')
                            ->where(['internal_history.stat'=>'pending','internal_history.department'=>Auth::user()->division])
                            ->groupBy('internals.barcode')
                            ->get()
                            ->count();

            $internal_cnt_approve = DB::table('internal_history')
                            ->join('internals','internal_history.ref_id','=','internals.id')
                            ->where(['internal_history.stat'=>'approve','internal_history.department'=>Auth::user()->division])
                            ->groupBy('internals.barcode')
                            ->get()
                            ->count();

            $internal_cnt_disapprove = DB::table('internal_history')
                            ->join('internals','internal_history.ref_id','=','internals.id')
                            ->where(['internal_history.stat'=>'disapprove','internal_history.department'=>Auth::user()->division])
                            ->groupBy('internals.barcode')
                            ->get()
                            ->count();

            $internal_cnt_complete = DB::table('internal_history')
                            ->join('internals','internal_history.ref_id','=','internals.id')
                            ->where(['internal_history.stat'=>'complete','internal_history.department'=>Auth::user()->division])
                            ->groupBy('internals.barcode')
                            ->get()
                            ->count();

            $internal_cnt_ongoing = DB::table('internal_history')
                            ->join('internals','internal_history.ref_id','=','internals.id')
                            ->where(['internal_history.stat'=>'on-going','internal_history.department'=>Auth::user()->division])
                            ->groupBy('internals.barcode')
                            ->get()
                            ->count();

            return response()->JSON(['internal_data' => $internal_cnt, 'internal_cnt_p' => $internal_cnt_pending, 'internal_appr' => $internal_cnt_approve, 'internal_disapp' => $internal_cnt_disapprove, 'internal_complete' => $internal_cnt_complete, 'internal_ongoing' => $internal_cnt_ongoing]);
        }
    }

    public function track_list_document($id)
    {
        $data = DB::table('internal_history')
                    ->join('internals','internal_history.ref_id','=','internals.id')
                    ->where(['internals.id'=>$id])
                    //->groupBy('internals.barcode')
                    ->orderBy('internal_history.id','desc')
                    ->get();

        $datefilter = DB::table('internals')
                        ->groupBy('internals.doc_receive')
                        ->orderBy('internals.id','asc')
                        ->get();

        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        $uname = Auth::user()->f_name;

        $docimages = DB::table('internal_files')
                    ->where(['internal_files.ref_id'=>$id])
                    ->orderBy('internal_files.id','asc')
                    ->get();

        $lib = DB::table('library')
                    ->orderBy('library.id','asc')
                    ->get();

        $div = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        $isopen = DB::table('internal_history')
                    ->where(['internal_history.department'=>Auth::user()->division,'internal_history.ref_id'=>$id])
                    ->update([
                        'actioned' => 1,
                    ]);

        //dd($data);

        return view('internal.doc-view-track-list', compact('papcode','data', 'uname','datefilter','docimages','lib','div','userlist'));
    }

    public function edit_docs_details($ref_id)
    {
        if(request()->ajax())
        {
            $data = DB::table('internals')
                    ->where(['internals.id'=>$ref_id])
                    ->get();

            return response()->JSON(['data' => $data]); 
        }
    }

    public function update_docs_details(Request $request, $ref_id)
    {
        if(request()->ajax())
        {
            $data = DB::table('internals')
                    ->where(['internals.id'=>$ref_id])
                    ->update([
                        'agency'            =>  $request->get('_agency'),
                        'doctitle'          =>  $request->get('_doctitle'),
                        'description'       =>  $request->get('_desc'),
                        'barcode'           =>  $request->get('_barcode'),
                        'signatory'         =>  $request->get('_signature'),
                        'doc_receive'       =>  $request->get('_docdate'),
                        'briefer_number'    =>  $request->get('_briefer'),
                        'retdoc'            =>  $request->get('returndoc'),
                    ]);

            $track = DB::table('tracking_number')
                    ->where(['tracking_number.ref_id'=>$ref_id])
                    ->update([
                        'barcode' => $request->get('_barcode'),
                        'doctitle' => $request->get('_doctitle'),
                        'docdescription' => $request->get('_desc'),
                    ]);

            return response()->JSON(['data' => $data]); 
        }
    }

    public function tracking_complete(Request $request,$id)
    {
        if(request()->ajax())
        {
            $data = DB::table('internals')
                    ->where(['internals.id'=>$id])
                    ->update([
                        'status'=>'complete',
                    ]);

                    
            $data = DB::table('internal_departments')
                    ->where(['internal_departments.ff_id'=>$id,'internal_departments.dept'=>Auth::user()->division])
                    ->update([
                        'stat'=>'complete',
                    ]);
            

            $data = DB::table('internal_history')
                    ->where(['internal_history.ref_id'=>$id,'internal_history.department'=>Auth::user()->division])
                    ->update([
                        'stat'=>'complete',
                        'destination' => Auth::user()->division.' complete the tracking',
                        'remarks'=>'completed on '.Carbon::now()->format('F j, Y').' @ '.Carbon::now()->format('H:i:s'),
                        'actioned' => 1,
                    ]);

            return response()->JSON(['data' => $data]);      
        }
    }

    public function tracking_approve(Request $request,$id)
    {
        if(request()->ajax())
        {
            $docs = DB::table('internals')
                    ->get();

            foreach ($docs as $i)
                {
                    $prevdate = $i->doc_date_ff;
                    $doc_id = $i->id;

                        $curdate = Carbon::now();

                        $diff = Carbon::parse($curdate)->diffInDays($prevdate);

                        $update_doc = DB::table('internals')
                                ->where(['internals.id'=>$doc_id,'internals.status'=>'pending'])
                                ->update([
                                    'day_count'=>$diff,
                                ]);
                }

            $data = DB::table('internals')
                    ->where(['internals.id'=>$id])
                    ->update([
                        'status'=>'approve',
                    ]);

                    
            $data = DB::table('internal_departments')
                    ->where(['internal_departments.ff_id'=>$id,'internal_departments.dept'=>Auth::user()->division])
                    ->update([
                        'stat'=>'approve',
                    ]);
            
            /*
            $data = DB::table('internal_history')
                    ->where(['internal_history.ref_id'=>$id,'internal_history.department'=>Auth::user()->division])
                    ->update([
                        'stat'=>'approve',
                        'destination' => Auth::user()->division.' approve this document',
                        'remarks'=>'approve on '.Carbon::now()->format('F j, Y').' @ '.Carbon::now()->format('H:i:s'),
                    ]);
            */

            $data = DB::insert('insert into internal_history (ref_id, remarks, date_ff, date_forwared, days_count, department,stat, destination) values (?, ?, ?, ?, ?, ?, ?, ?)', 
                [
                $request->get('_id'),
                $request->get('remarks').' Approve by '.Auth::user()->division,
                Carbon::now(),
                Carbon::now('Asia/Hong_Kong')->format('F j, Y').' @ '.Carbon::now('Asia/Hong_Kong')->format('g:i:s a'),
                $diff,
                Auth::user()->division,
                'approve',
                Auth::user()->division.' Approve this document',
            ]);


            return response()->JSON(['data' => $data]);      
        }
    }

    public function tracking_disapprove(Request $request,$id)
    {
        if(request()->ajax())
        {
            $docs = DB::table('internals')
                    ->get();

            foreach ($docs as $i)
                {
                    $prevdate = $i->doc_date_ff;
                    $doc_id = $i->id;

                        $curdate = Carbon::now();

                        $diff = Carbon::parse($curdate)->diffInDays($prevdate);

                        $update_doc = DB::table('internals')
                                ->where(['internals.id'=>$doc_id,'internals.status'=>'pending'])
                                ->update([
                                    'day_count'=>$diff,
                                ]);
                }
                
            $data = DB::table('internals')
                    ->where(['internals.id'=>$id])
                    ->update([
                        'status'=>'disapprove',
                    ]);

                    
            $data = DB::table('internal_departments')
                    ->where(['internal_departments.ff_id'=>$id,'internal_departments.dept'=>Auth::user()->division])
                    ->update([
                        'stat'=>'disapprove',
                    ]);
            
            /*
            $data = DB::table('internal_history')
                    ->where(['internal_history.ref_id'=>$id,'internal_history.department'=>Auth::user()->division])
                    ->update([
                        'stat'=>'disapprove',
                        'destination' => Auth::user()->division.' disapprove this document',
                        'remarks'=>'disapprove on '.Carbon::now()->format('F j, Y').' @ '.Carbon::now()->format('H:i:s'),
                    ]);

            */

            $data = DB::insert('insert into internal_history (ref_id, remarks, date_ff, date_forwared, days_count, department,stat, destination) values (?, ?, ?, ?, ?, ?, ?, ?)', 
                [
                $request->get('_id'),
                $request->get('remarks').' Disapprove by '.Auth::user()->division,
                Carbon::now(),
                Carbon::now('Asia/Hong_Kong')->format('F j, Y').' @ '.Carbon::now('Asia/Hong_Kong')->format('g:i:s a'),
                $diff,
                Auth::user()->division,
                'disapprove',
                Auth::user()->division.' Disapprove this document',
            ]);


            return response()->JSON(['data' => $data]);      
        }
    }

    public function class_confidential(Request $request, $id){
        //echo($id);
        if(request()->ajax())
        {
            $classcategory = $request->get('docclass');

            if($classcategory === 1){
                $data = DB::table('internal_history')
                        ->where(['internal_history.ref_id' => $id])
                        ->update([
                            'classification' => $request->get('docclass'),
                            'confi_name' => $request->get('confiname'),
                        ]);
            }else{
                $data = DB::table('internal_history')
                        ->where(['internal_history.ref_id' => $id])
                        ->update([
                            'classification' => $request->get('docclass'),
                            'confi_name' => null,
                        ]);

            }



            return response()->JSON(['data' => $data]);  
        }

    }

    public function class_confide_name(Request $request, $id){
        //echo($id);
        if(request()->ajax())
        {
            $data = DB::table('internal_history')
                    ->where(['internal_history.ref_id' => $id])
                    ->update([
                        'classification' => $request->get('docclass'),
                        'confi_name' => $request->get('confiname'),
                    ]);

            /*

            $sendmail = DB::table('users')
                    ->where(['users.f_name' => $request->get('confiname')])
                    ->get()->toArray();


            foreach ($sendmail as $m) {
                if($m != ""){
                        $mdata = array('name'=>"Document Tracking Notification");
                        Mail::send('mailer.mail-internal', $mdata, function($message) {
                            $message->to($m->email, 'Document Tracking Notification')->subject('Document Tracking Notification');
                            $message->from('no-reply@minda.gov.ph','MinDA Document Tracking');
                        });
                }
            }
            */

            return response()->JSON(['data' => $data]);  
        }

    }

    public function search_barcode($barcode)
    {
        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        $data = DB::table('internal_departments')
                ->join('internals','internal_departments.ff_id','=','internals.id')
                ->join('internal_history','internal_history.ref_id','=','internal_departments.ff_id')
                ->where(['internal_departments.dept'=>Auth::user()->division,'internals.barcode'=>$barcode])
                ->groupBy('internals.barcode')
                ->orderBy('internals.day_count','desc')
                ->orderBy('internals.created_at','desc')
                ->paginate(10)
                ->onEachSide(2);

        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        $datefilter = DB::table('internals')
                        ->groupBy('internals.doc_receive')
                        ->orderBy('internals.id','asc')
                        ->get();

        $lib = DB::table('library')
                    ->orderBy('library.id','asc')
                    ->get();

        $div = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        //dd($data);
        return view('internal.doc-view-list',compact('data','papcode','userlist','datefilter','lib','div'));
    }

    public function filter_date($date)
    {
        $search = date('Y-m-d', strtotime($date));
        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        $data = DB::table('internal_departments')
                ->join('internals','internal_departments.ff_id','=','internals.id')
                ->join('internal_history','internal_history.ref_id','=','internal_departments.ff_id')
                ->where(['internal_departments.dept'=>Auth::user()->division,'internals.doc_receive'=>$search])
                ->groupBy('internals.barcode')
                ->orderBy('internals.day_count','desc')
                ->orderBy('internals.created_at','desc')
                ->paginate(10)
                ->onEachSide(2);

        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        $datefilter = DB::table('internals')
                        ->groupBy('internals.doc_receive')
                        ->orderBy('internals.id','asc')
                        ->get();

        $lib = DB::table('library')
                    ->orderBy('library.id','asc')
                    ->get();

        $div = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        //dd($data);
        return view('internal.doc-view-list',compact('data','papcode','userlist','datefilter','lib','div'));
    }

    public function get_barcode_value($bnum)
    {
        if(request()->ajax())
        {

            $data = DB::table('internals')
                    ->where(['internals.barcode'=>$bnum])
                    ->get();

            if($data->count()>0)
            {
                return response()->JSON(['dup' => 1]);  
            }else{
                return response()->JSON(['dup' => 0]); 
            }
            
        }
    }
 
}
