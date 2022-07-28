<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Outgoing;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\ProjectCount;
use App\Jobs\SendEmailOutgoing;
use Auth;
use DB;
use Mail;

class OutgoingController extends Controller
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

        $courier = DB::table('courier')
                    ->orderBy('courier.id','asc')
                    ->get();
        
    	return view('outgoing.doc-new-entry',compact('userlist','lib','courier'));
    }

    public function save_new_documnent(Request $request)
    {
    	$data = new Outgoing;

    	if($request->hasFile('img_file')) {
            $filenameWithExt = $request->file('img_file')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);            
            $extension = $request->file('img_file')->getClientOriginalExtension();
            $fileNameToStore = time().'_'.$filename.'.'.$extension;                       

            $file = $request->file('img_file');
            $file->getClientOriginalName();
            $encryp = md5($file);
            $destinationPath = 'uploads';
            $file->move($destinationPath,$encryp.'.'.$extension);

        } else {
            $encryp='noimage';
            $extension='jpg';
        }

        $data->doctitle         =   $request->get('doctitle');
        $data->description      =   $request->get('docdesc'); //'Document added on '.Carbon::now('Asia/Hong_Kong')->format('F j, Y').' @ '.Carbon::now('Asia/Hong_Kong')->format('g:i:s a');//$request->get('docdesc');
        $data->briefer_number   =   $request->get('briefer');
        $data->barcode          =   $request->get('barcode');
        //new added
        $data->signatory        =   $request->get('signature');
        $data->agency           =   $request->get('agency');
        $data->sendto           =   $request->get('agencyto');
        $data->sendto_email     =   $request->get('signatureemail');
        $data->releasemode      =   $request->get('releasemode');
        //
        $data->sender           =   Auth::user()->division;  //$request->get('docfrom');
        $data->type             =   'Outgoing Documents';   //$request->get('doctype');
        $data->doc_receive      =   $request->get('docdate');
        $data->doc_date_ff      =   Carbon::now();
        $data->image            =   $encryp.'.'.$extension;

        if($request->has('chkdocreturn')){
            $data->retdoc  = 1;
        }else{
            $data->retdoc  = 0;
        }
        
        $data->save();

        $dept = DB::insert('insert into outgoing_departments (ff_id, dept, stat) values (?, ?, ?)',
            [
                $data->id,
                Auth::user()->division,
                'pending',
            ]);

        $classification =  $request->get('docclassification');
        $confidential =  $request->get('ff_employee');
        $history = DB::insert('insert into outgoing_history (ref_id, remarks, date_ff, date_forwared, days_count, department, stat,classification,confi_name,destination) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $data->id,
               'Document Tracking Started',
               Carbon::now(),
                Carbon::now('Asia/Hong_Kong')->format('F j, Y').' @ '.Carbon::now('Asia/Hong_Kong')->format('g:i:s a'),    //$request->get('docdate'),
                '0',
                Auth::user()->division,
                'pending',
                $classification,
                $confidential,
                Auth::user()->division,
            ]);

        if(!is_null($request->get('signatureemail')))
        {

            $this->send_to_receiver($request->get('signatureemail'), $classification,$request->get('docdesc'),$request->get('barcode'),$request->get('releasemode'));
        }
        //return redirect('/outgoing-document-new-entry')->with('alert','New Document save');

        return redirect('/outgoing-document-new-entry/upload-image/'.$data->id);
    }

    public function upload_image(Request $request, $id){
        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        $datefilter = DB::table('outgoings')
                        ->groupBy('outgoings.doc_receive')
                        ->orderBy('outgoings.id','asc')
                        ->get();

        $data = DB::table('outgoings')
                    ->where(['outgoings.id'=>$id])
                    ->get();

        $docimages = DB::table('outgoing_files')
                    ->where(['outgoing_files.ref_id'=>$id])
                    ->orderBy('outgoing_files.id','asc')
                    ->get();

        return view('outgoing.doc-upload-image',compact('data','papcode','userlist','datefilter','docimages'));
    }

    public function save_image(Request $request, $id){
        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        $datefilter = DB::table('outgoings')
                        ->groupBy('outgoings.doc_receive')
                        ->orderBy('outgoings.id','asc')
                        ->get();

        $data = DB::table('outgoings')
                    ->where(['outgoings.id'=>$id])
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

                $docimage = DB::insert('insert into outgoing_files (ref_id,img_file,doc_title) values (?, ?, ?)',
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


        return redirect('/outgoing-document-new-entry/upload-image/'.$id);

    }

    public function remove_file($id,$ref_id,$img)
    {
        $docimage = DB::table('outgoing_files')
                    ->where(['outgoing_files.id'=>$id])
                    ->delete();

        //File::delete($img);
        $image_path = public_path().'/uploads'.$img; 
        //unlink($image_path);

        File::delete('public/uploads/'.$img);

        return redirect('/outgoing-document-new-entry/upload-image/'.$ref_id);
    }

    public function list_document()
    {
        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        $datefilter = DB::table('outgoings')
                        ->groupBy('outgoings.doc_date_ff')
                        ->orderBy('outgoings.id','asc')
                        ->get();

        $lib = DB::table('library')
                    ->orderBy('library.id','asc')
                    ->get();

        $courier = DB::table('courier')
                    ->orderBy('courier.id','asc')
                    ->get();

        $docs = DB::table('outgoings')
            ->get();

        if(Auth::user()->access_level=='5' and Auth::user()->division=='RECORDS'){
            $div = DB::table('users')
                    ->where(['users.division'=>'OC'])
                    ->orWhere(['users.division'=>'OED'])
                    ->orWhere(['users.division'=>'RECORDS'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        }else if(Auth::user()->division=='RECORDS' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'RECORDS'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        }else if(Auth::user()->division=='OC' and Auth::user()->access_level=='4'){
            $div = DB::table('users')
                    ->where(['users.division'=>'OFAS'])
                    ->orWhere(['users.division'=>'PPPDO'])
                    ->orWhere(['users.division'=>'IPPAO'])
                    ->orWhere(['users.division'=>'OC'])
                    ->orWhere(['users.division'=>'OED'])
                    ->orWhere(['users.division'=>'RECORDS'])
                    ->orWhere('users.division',"like",'AMO%')
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        }else if(Auth::user()->division=='OC' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'OC'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        }else if(Auth::user()->division=='PPPDO' and Auth::user()->access_level=='3'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PPPDO'])
                    ->orWhere(['users.division'=>'PRD'])
                    ->orWhere(['users.division'=>'PFD'])
                    ->orWhere(['users.division'=>'PDD'])
                    ->orWhere(['users.division'=>'KMD'])
                    ->orWhere(['users.division'=>'OC'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='PPPDO' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PPPDO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='IPPAO' and Auth::user()->access_level=='3'){
            $div = DB::table('users')
                    ->where(['users.division'=>'IPPAO'])
                    ->orWhere(['users.division'=>'IPD'])
                    ->orWhere(['users.division'=>'IRD'])
                    ->orWhere(['users.division'=>'PuRD'])
                    ->orWhere(['users.division'=>'OC'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='IPPAO' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'IPPAO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='OFAS' and Auth::user()->access_level=='3'){
            $div = DB::table('users')
                    ->where(['users.division'=>'OFAS'])
                    ->orWhere(['users.division'=>'FD'])
                    ->orWhere(['users.division'=>'AD'])
                    ->orWhere(['users.division'=>'OC'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='OFAS' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'OFAS'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='PRD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PRD'])
                    ->orWhere(['users.division'=>'PPPDO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='PRD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PRD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='PFD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PFD'])
                    ->orWhere(['users.division'=>'PPPDO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='PFD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PFD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='PDD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PDD'])
                    ->orWhere(['users.division'=>'PPPDO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='PDD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PDD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='KMD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'KMD'])
                    ->orWhere(['users.division'=>'PPPDO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='KMD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'KMD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='IPD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'IPD'])
                    ->orWhere(['users.division'=>'IPPAO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='IPD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'IPD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='IRD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'IRD'])
                    ->orWhere(['users.division'=>'IPPAO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='IRD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'IRD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='PuRD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PuRD'])
                    ->orWhere(['users.division'=>'IPPAO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='PuRD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PuRD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='FD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'FD'])
                    ->orWhere(['users.division'=>'OFAS'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='FD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'FD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='AD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AD'])
                    ->orWhere(['users.division'=>'OFAS'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='AD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='AMO-CM' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-CM'])
                    ->orWhere(['users.division'=>'OC'])
                    ->orWhere(['users.division'=>'OED'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='AMO-CM' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-CM'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='AMO-NM' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-NM'])
                    ->orWhere(['users.division'=>'OC'])
                    ->orWhere(['users.division'=>'OED'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='AMO-NM' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-NM'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='AMO-WM' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-WM'])
                    ->orWhere(['users.division'=>'OC'])
                    ->orWhere(['users.division'=>'OED'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='AMO-WM' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-WM'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='AMO-NEM' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-NEM'])
                    ->orWhere(['users.division'=>'OC'])
                    ->orWhere(['users.division'=>'OED'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='AMO-NEM' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-NEM'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='AMO-SCM' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-SCM'])
                    ->orWhere(['users.division'=>'OC'])
                    ->orWhere(['users.division'=>'OED'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='AMO-SCM' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-SCM'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else{
            $div = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }



        foreach ($docs as $i)
            {
                $prevdate = $i->doc_date_ff;
                $doc_id = $i->id;

                    $curdate = Carbon::now();

                    $diff = Carbon::parse($curdate)->diffInDays($prevdate);

                    $update_doc = DB::table('outgoings')
                            ->where(['outgoings.id'=>$doc_id,'outgoings.status'=>'pending'])
                            ->update([
                                'day_count'=>$diff,
                            ]);
            }

        if (Auth::user()->access_level==5 || Auth::user()->access_level==4)
        {
            $data = DB::table('outgoing_departments')
                ->join('outgoings','outgoing_departments.ff_id','=','outgoings.id')
                ->join('outgoing_history','outgoing_departments.ff_id','=','outgoing_history.ref_id')
                //->where(['outgoing_departments.dept'=>Auth::user()->division])
                //->where(['outgoing_history.department'=>Auth::user()->division])
                ->groupBy('outgoings.barcode')
                ->orderBy('outgoing_history.days_count','desc')
                ->orderBy('outgoings.created_at','asc')
                ->paginate(10)
                ->onEachSide(2);
        }else{
            $data = DB::table('outgoing_departments')
                ->join('outgoings','outgoing_departments.ff_id','=','outgoings.id')
                ->join('outgoing_history','outgoing_departments.ff_id','=','outgoing_history.ref_id')
                ->where(['outgoing_departments.dept'=>Auth::user()->division])
                ->where(['outgoing_history.department'=>Auth::user()->division])
                ->groupBy('outgoings.barcode')
                ->orderBy('outgoing_history.days_count','desc')
                ->orderBy('outgoings.created_at','asc')
                ->paginate(10)
                ->onEachSide(2);
        }


        //dd($data);
        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

    	return view('outgoing.doc-view-list',compact('data','papcode','userlist','datefilter','lib','courier','div'));
    }

    public function list_document_ascending()
    {
        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        $datefilter = DB::table('outgoings')
                        ->groupBy('outgoings.doc_date_ff')
                        ->orderBy('outgoings.id','asc')
                        ->get();

        $docs = DB::table('outgoings')
            ->get();

        $lib = DB::table('library')
                    ->orderBy('library.id','asc')
                    ->get();

        $courier = DB::table('courier')
                    ->orderBy('courier.id','asc')
                    ->get();

        if(Auth::user()->access_level=='5' and Auth::user()->division=='RECORDS'){
            $div = DB::table('users')
                    ->where(['users.division'=>'OC'])
                    ->orWhere(['users.division'=>'OED'])
                    ->orWhere(['users.division'=>'RECORDS'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        }else if(Auth::user()->division=='RECORDS' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'RECORDS'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        }else if(Auth::user()->division=='OC' and Auth::user()->access_level=='4'){
            $div = DB::table('users')
                    ->where(['users.division'=>'OFAS'])
                    ->orWhere(['users.division'=>'PPPDO'])
                    ->orWhere(['users.division'=>'IPPAO'])
                    ->orWhere(['users.division'=>'OC'])
                    ->orWhere(['users.division'=>'OED'])
                    ->orWhere(['users.division'=>'RECORDS'])
                    ->orWhere('users.division',"like",'AMO%')
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        }else if(Auth::user()->division=='OC' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'OC'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        }else if(Auth::user()->division=='PPPDO' and Auth::user()->access_level=='3'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PPPDO'])
                    ->orWhere(['users.division'=>'PRD'])
                    ->orWhere(['users.division'=>'PFD'])
                    ->orWhere(['users.division'=>'PDD'])
                    ->orWhere(['users.division'=>'KMD'])
                    ->orWhere(['users.division'=>'OC'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='PPPDO' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PPPDO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='IPPAO' and Auth::user()->access_level=='3'){
            $div = DB::table('users')
                    ->where(['users.division'=>'IPPAO'])
                    ->orWhere(['users.division'=>'IPD'])
                    ->orWhere(['users.division'=>'IRD'])
                    ->orWhere(['users.division'=>'PuRD'])
                    ->orWhere(['users.division'=>'OC'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='IPPAO' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'IPPAO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='OFAS' and Auth::user()->access_level=='3'){
            $div = DB::table('users')
                    ->where(['users.division'=>'OFAS'])
                    ->orWhere(['users.division'=>'FD'])
                    ->orWhere(['users.division'=>'AD'])
                    ->orWhere(['users.division'=>'OC'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='OFAS' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'OFAS'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='PRD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PRD'])
                    ->orWhere(['users.division'=>'PPPDO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='PRD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PRD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='PFD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PFD'])
                    ->orWhere(['users.division'=>'PPPDO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='PFD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PFD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='PDD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PDD'])
                    ->orWhere(['users.division'=>'PPPDO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='PDD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PDD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='KMD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'KMD'])
                    ->orWhere(['users.division'=>'PPPDO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='KMD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'KMD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='IPD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'IPD'])
                    ->orWhere(['users.division'=>'IPPAO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='IPD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'IPD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='IRD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'IRD'])
                    ->orWhere(['users.division'=>'IPPAO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='IRD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'IRD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='PuRD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PuRD'])
                    ->orWhere(['users.division'=>'IPPAO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='PuRD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PuRD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='FD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'FD'])
                    ->orWhere(['users.division'=>'OFAS'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='FD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'FD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='AD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AD'])
                    ->orWhere(['users.division'=>'OFAS'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='AD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='AMO-CM' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-CM'])
                    ->orWhere(['users.division'=>'OC'])
                    ->orWhere(['users.division'=>'OED'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='AMO-CM' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-CM'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='AMO-NM' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-NM'])
                    ->orWhere(['users.division'=>'OC'])
                    ->orWhere(['users.division'=>'OED'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='AMO-NM' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-NM'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='AMO-WM' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-WM'])
                    ->orWhere(['users.division'=>'OC'])
                    ->orWhere(['users.division'=>'OED'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='AMO-WM' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-WM'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='AMO-NEM' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-NEM'])
                    ->orWhere(['users.division'=>'OC'])
                    ->orWhere(['users.division'=>'OED'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='AMO-NEM' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-NEM'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='AMO-SCM' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-SCM'])
                    ->orWhere(['users.division'=>'OC'])
                    ->orWhere(['users.division'=>'OED'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='AMO-SCM' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-SCM'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else{
            $div = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        foreach ($docs as $i)
            {
                $prevdate = $i->doc_date_ff;
                $doc_id = $i->id;

                    $curdate = Carbon::now();

                    $diff = Carbon::parse($curdate)->diffInDays($prevdate);

                    $update_doc = DB::table('outgoings')
                            ->where(['outgoings.id'=>$doc_id,'outgoings.status'=>'pending'])
                            ->update([
                                'day_count'=>$diff,
                            ]);
            }

        if (Auth::user()->access_level==5 || Auth::user()->access_level==4)
        {
            $data = DB::table('outgoing_departments')
                ->join('outgoings','outgoing_departments.ff_id','=','outgoings.id')
                ->join('outgoing_history','outgoing_departments.ff_id','=','outgoing_history.ref_id')
                //->where(['outgoing_departments.dept'=>Auth::user()->division])
                //->where(['outgoing_history.department'=>Auth::user()->division])
                ->groupBy('outgoings.barcode')
                ->orderBy('outgoing_history.days_count','desc')
                ->orderBy('outgoings.created_at','desc')
                ->paginate(10)
                ->onEachSide(2);
        }else{   
            $data = DB::table('outgoing_departments')
                ->join('outgoings','outgoing_departments.ff_id','=','outgoings.id')
                ->join('outgoing_history','outgoing_departments.ff_id','=','outgoing_history.ref_id')
                ->where(['outgoing_departments.dept'=>Auth::user()->division])
                ->where(['outgoing_history.department'=>Auth::user()->division])
                ->groupBy('outgoings.barcode')
                ->orderBy('outgoing_history.days_count','desc')
                ->orderBy('outgoings.created_at','desc')
                ->paginate(10)
                ->onEachSide(2);
        }                


        //dd($data);
        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        return view('outgoing.doc-view-list',compact('data','papcode','userlist','datefilter','lib','courier','div'));
    }

    public function pending_list()
    {
        if (Auth::user()->access_level==5 || Auth::user()->access_level==4)
        {   
            $data = DB::table('outgoing_departments')
                ->join('outgoings','outgoing_departments.ff_id','=','outgoings.id')
                ->join('outgoing_history','outgoing_departments.ff_id','=','outgoing_history.ref_id')
                //->where(['outgoing_departments.dept'=>Auth::user()->division])
                ->where(['outgoing_history.stat'=>'pending'])
                ->groupBy('outgoings.barcode')
                ->orderBy('outgoings.day_count','desc')
                ->orderBy('outgoings.created_at','desc')
                ->paginate(10)
                ->onEachSide(2);
        }else{
            $data = DB::table('outgoing_departments')
                ->join('outgoings','outgoing_departments.ff_id','=','outgoings.id')
                ->join('outgoing_history','outgoing_departments.ff_id','=','outgoing_history.ref_id')
                ->where(['outgoing_departments.dept'=>Auth::user()->division])
                ->where(['outgoing_history.department'=>Auth::user()->division, 'outgoing_history.stat'=>'pending'])
                ->groupBy('outgoings.barcode')
                ->orderBy('outgoings.day_count','desc')
                ->orderBy('outgoings.created_at','desc')
                ->paginate(10)
                ->onEachSide(2);
        }

        $datefilter = DB::table('outgoings')
                        ->groupBy('outgoings.doc_date_ff')
                        ->orderBy('outgoings.id','asc')
                        ->get();
        //dd($data);
        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        $lib = DB::table('library')
                    ->orderBy('library.id','asc')
                    ->get();

        $courier = DB::table('courier')
                    ->orderBy('courier.id','asc')
                    ->get();

        return view('outgoing.doc-view-list',compact('data','papcode','datefilter','userlist','lib','courier'));
    }

    public function approve_list()
    {
        if (Auth::user()->access_level==5 || Auth::user()->access_level==4)
        {   
            $data = DB::table('outgoing_departments')
                ->join('outgoings','outgoing_departments.ff_id','=','outgoings.id')
                ->join('outgoing_history','outgoing_departments.ff_id','=','outgoing_history.ref_id')
                //->where(['outgoing_departments.dept'=>Auth::user()->division])
                ->where(['outgoing_history.stat'=>'approve'])
                ->groupBy('outgoings.barcode')
                ->orderBy('outgoings.day_count','desc')
                ->orderBy('outgoings.created_at','desc')
                ->paginate(10)
                ->onEachSide(2);
        }else{
            $data = DB::table('outgoing_departments')
                ->join('outgoings','outgoing_departments.ff_id','=','outgoings.id')
                ->join('outgoing_history','outgoing_departments.ff_id','=','outgoing_history.ref_id')
                ->where(['outgoing_departments.dept'=>Auth::user()->division])
                ->where(['outgoing_history.department'=>Auth::user()->division, 'outgoing_history.stat'=>'approve'])
                ->groupBy('outgoings.barcode')
                ->orderBy('outgoings.day_count','desc')
                ->orderBy('outgoings.created_at','desc')
                ->paginate(10)
                ->onEachSide(2);
        }

        $datefilter = DB::table('outgoings')
                        ->groupBy('outgoings.doc_date_ff')
                        ->orderBy('outgoings.id','asc')
                        ->get();

        //dd($data);
        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        $lib = DB::table('library')
                    ->orderBy('library.id','asc')
                    ->get();

        $courier = DB::table('courier')
                    ->orderBy('courier.id','asc')
                    ->get();

        return view('outgoing.doc-view-list',compact('data','papcode','datefilter','userlist','lib','courier'));
    }

    public function disapprove_list()
    {
        if (Auth::user()->access_level==5 || Auth::user()->access_level==4)
        {   
            $data = DB::table('outgoing_departments')
                ->join('outgoings','outgoing_departments.ff_id','=','outgoings.id')
                ->join('outgoing_history','outgoing_departments.ff_id','=','outgoing_history.ref_id')
                //->where(['outgoing_departments.dept'=>Auth::user()->division])
                ->where(['outgoing_history.stat'=>'disapprove'])
                ->groupBy('outgoings.barcode')
                ->orderBy('outgoings.day_count','desc')
                ->orderBy('outgoings.created_at','desc')
                ->paginate(10)
                ->onEachSide(2);
        }else{
            $data = DB::table('outgoing_departments')
                ->join('outgoings','outgoing_departments.ff_id','=','outgoings.id')
                ->join('outgoing_history','outgoing_departments.ff_id','=','outgoing_history.ref_id')
                ->where(['outgoing_departments.dept'=>Auth::user()->division])
                ->where(['outgoing_history.department'=>Auth::user()->division, 'outgoing_history.stat'=>'disapprove'])
                ->groupBy('outgoings.barcode')
                ->orderBy('outgoings.day_count','desc')
                ->orderBy('outgoings.created_at','desc')
                ->paginate(10)
                ->onEachSide(2);
        }

        $datefilter = DB::table('outgoings')
                        ->groupBy('outgoings.doc_date_ff')
                        ->orderBy('outgoings.id','asc')
                        ->get();

        //dd($data);
        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        $lib = DB::table('library')
                    ->orderBy('library.id','asc')
                    ->get();

        $courier = DB::table('courier')
                    ->orderBy('courier.id','asc')
                    ->get();

        return view('outgoing.doc-view-list',compact('data','papcode','datefilter','userlist','lib','courier'));
    }

    public function complete_list()
    {
        if (Auth::user()->access_level==5 || Auth::user()->access_level==4)
        {   
            $data = DB::table('outgoing_departments')
                ->join('outgoings','outgoing_departments.ff_id','=','outgoings.id')
                ->join('outgoing_history','outgoing_departments.ff_id','=','outgoing_history.ref_id')
                //->where(['outgoing_departments.dept'=>Auth::user()->division])
                ->where(['outgoing_history.stat'=>'complete'])
                ->groupBy('outgoings.barcode')
                ->orderBy('outgoings.day_count','desc')
                ->orderBy('outgoings.created_at','desc')
                ->paginate(10)
                ->onEachSide(2);
        }else{
            $data = DB::table('outgoing_departments')
                ->join('outgoings','outgoing_departments.ff_id','=','outgoings.id')
                ->join('outgoing_history','outgoing_departments.ff_id','=','outgoing_history.ref_id')
                ->where(['outgoing_departments.dept'=>Auth::user()->division])
                ->where(['outgoing_history.department'=>Auth::user()->division, 'outgoing_history.stat'=>'complete'])
                ->groupBy('outgoings.barcode')
                ->orderBy('outgoings.day_count','desc')
                ->orderBy('outgoings.created_at','desc')
                ->paginate(10)
                ->onEachSide(2);
        }

        $datefilter = DB::table('outgoings')
                        ->groupBy('outgoings.doc_date_ff')
                        ->orderBy('outgoings.id','asc')
                        ->get();

        //dd($data);
        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        $lib = DB::table('library')
                    ->orderBy('library.id','asc')
                    ->get();

        $courier = DB::table('courier')
                    ->orderBy('courier.id','asc')
                    ->get();

        return view('outgoing.doc-view-list',compact('data','papcode','datefilter','userlist','lib','courier'));
    }

        public function get_return_value($id)
    {

        if(request()->ajax())
        {
            $data = DB::table('outgoings')
                    ->join('outgoing_history','outgoings.id','=','outgoing_history.ref_id')
                    ->where(['outgoings.id'=>$id])
                    ->get();

            return response()->JSON(['data' => $data]);
        }
        
    }

    public function ff_doc(Request $request, $id)
    {
        if(request()->ajax())
        {

            $history_update = DB::table('outgoing_history')
                        ->where(['outgoing_history.ref_id'=>$id, 'outgoing_history.department'=>Auth::user()->division])
                        ->update([
                            'stat'=>'forwarded',
                        ]);

            $dept_update = DB::table('outgoing_departments')
                        ->where(['outgoing_departments.ff_id'=>$id, 'outgoing_departments.dept'=>Auth::user()->division])
                        ->update([
                            'stat'=>'forwarded',
                        ]);
                        
            $docs = DB::table('outgoings')
                    ->where(['outgoings.id'=>$id])
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

            $data = DB::insert('insert into outgoing_history (ref_id, remarks, date_ff, date_forwared, days_count, department,stat, destination) values (?, ?, ?, ?, ?, ?, ?, ?)', 
                [
                $request->get('_id'),
                $action_remarks,
                Carbon::now(),
                Carbon::now('Asia/Hong_Kong')->format('F j, Y').' @ '.Carbon::now('Asia/Hong_Kong')->format('g:i:s a'),
                $diff,
                $request->get('division'),
                'pending',
                Auth::user()->f_name. ' from '. Auth::user()->division.' Forwared to '.$request->get('division'),
            ]);

            $dept = DB::insert('insert into outgoing_departments (ff_id, dept, stat) values (?, ?, ?)',
            [
                $request->get('_id'),
                $request->get('division'),
                'pending',
            ]);

            $update_doc = DB::table('outgoings')
                    ->where(['outgoings.id'=>$id])
                    ->update([
                        'doc_date_ff'=>Carbon::now(),
                        'status'=>'forwarded',
                    ]);

            if(is_null($request->get('confi'))){
                $this->send_email($request->get('division'),$request->get('_classification'),$id);
            }else{
                $this->send_to_user($request->get('confi'),$request->get('_classification'),$id);
            }

            return response()->JSON(['data' => $data]);
        }
    }

    public function send_email($division,$class,$id) {
      //if(is_null($name){
        if(Auth::user()->division !=$division AND Auth::user()->access_level==5){
            $subscriber_emails = DB::table('users')
                        ->where(['users.division' => $division])
                        ->where(['users.access_level'=>4]) //Chairman
                        ->get();

        }elseif (Auth::user()->division==$division AND Auth::user()->access_level==5) {
            $subscriber_emails = DB::table('users')
                        ->where(['users.division' => $division])
                        ->get();

        }elseif (Auth::user()->division !=$division AND Auth::user()->access_level==4) {
            if($division=="RECORDS"){
                $subscriber_emails = DB::table('users')
                        ->where(['users.division' => $division])
                        ->where(['users.access_level'=>5]) //Records
                        ->get();
            }else{
                $subscriber_emails = DB::table('users')
                            ->where(['users.division' => $division])
                            ->where(['users.access_level'=>3]) //Director
                            ->get();
            }
        }elseif (Auth::user()->division==$division AND Auth::user()->access_level==4) {
            $subscriber_emails = DB::table('users')
                        ->where(['users.division' => $division])
                        ->get();
        }elseif (Auth::user()->division==$division AND Auth::user()->access_level==3) {
            if($division=="OC"){
                $subscriber_emails = DB::table('users')
                        ->where(['users.division' => $division])
                        ->where(['users.access_level'=>4])
                        ->get();
            }elseif ($division=="OED") {
                $subscriber_emails = DB::table('users')
                        ->where(['users.division' => $division])
                        ->where(['users.access_level'=>4])
                        ->get();

            }else{
                $subscriber_emails = DB::table('users')
                            ->where(['users.division' => $division])
                            ->where(['users.access_level'=>2])
                            ->get();
            }
            
        }elseif (Auth::user()->division==$division AND Auth::user()->access_level==3) {
            $subscriber_emails = DB::table('users')
                        ->where(['users.division' => $division])
                        ->get();
        }



        elseif (Auth::user()->division!=$division AND Auth::user()->access_level==2) {
            if($division=="PPPDO"){
                $subscriber_emails = DB::table('users')
                        ->where(['users.division' => $division])
                        ->where(['users.access_level'=>3])
                        ->get();
            }elseif($division=="IPPAO"){
                $subscriber_emails = DB::table('users')
                        ->where(['users.division' => $division])
                        ->where(['users.access_level'=>3])
                        ->get();
            }elseif($division=="OFAS"){
                $subscriber_emails = DB::table('users')
                        ->where(['users.division' => $division])
                        ->where(['users.access_level'=>3])
                        ->get();
            }elseif($division=="OC"){
                $subscriber_emails = DB::table('users')
                        ->where(['users.division' => $division])
                        ->where(['users.access_level'=>4])
                        ->get();
            }elseif($division=="OED"){
                $subscriber_emails = DB::table('users')
                        ->where(['users.division' => $division])
                        ->where(['users.access_level'=>4])
                        ->get();
        
            }else{
                $subscriber_emails = DB::table('users')
                        ->where(['users.division' => $division])
                        ->where(['users.access_level'=>1])
                        ->get();
            }
        }elseif (Auth::user()->division==$division AND Auth::user()->access_level==2) {
            $subscriber_emails = DB::table('users')
                        ->where(['users.division' => $division])
                        ->get();


        }elseif(Auth::user()->access_level==1){
            if($division=="RECORDS"){
                $subscriber_emails = DB::table('users')
                            ->where(['users.division' => "RECORDS"])
                            ->where(['users.access_level'=>5]) //Chairman
                            ->get();

            }elseif ($division=="OC") {
                $subscriber_emails = DB::table('users')
                            ->where(['users.division' => "OC"])
                            ->where(['users.access_level'=>4]) //Director
                            ->get();
            }elseif ($division=="OED") {
                $subscriber_emails = DB::table('users')
                            ->where(['users.division' => "OED"])
                            ->where(['users.access_level'=>4]) //Director
                            ->get();
            }elseif ($division=="PPPDO") {
                $subscriber_emails = DB::table('users')
                            ->where(['users.division' => "PPPDO"])
                            ->where(['users.access_level'=>3]) //Director
                            ->get();
            }elseif ($division=="IPPAO") {
                $subscriber_emails = DB::table('users')
                            ->where(['users.division' => "IPPAO"])
                            ->where(['users.access_level'=>3]) //Director
                            ->get();
            }elseif ($division=="OFAS") {
                $subscriber_emails = DB::table('users')
                            ->where(['users.division' => "OFAS"])
                            ->where(['users.access_level'=>3]) //Director
                            ->get();
            }elseif ($division=="AMO-CM") {
                $subscriber_emails = DB::table('users')
                            ->where(['users.division' => "AMO-CM"])
                            ->where(['users.access_level'=>2]) //Director
                            ->get();
            }elseif ($division=="AMO-NEM") {
                $subscriber_emails = DB::table('users')
                            ->where(['users.division' => "AMO-NEM"])
                            ->where(['users.access_level'=>2]) //Director
                            ->get();
            }elseif ($division=="AMO-NM") {
                $subscriber_emails = DB::table('users')
                            ->where(['users.division' => "AMO-NM"])
                            ->where(['users.access_level'=>2]) //Director
                            ->get();
            }elseif ($division=="AMO-WM") {
                $subscriber_emails = DB::table('users')
                            ->where(['users.division' => "AMO-WM"])
                            ->where(['users.access_level'=>2]) //Director
                            ->get();
            }elseif ($division=="AMO-SCM") {
                $subscriber_emails = DB::table('users')
                            ->where(['users.division' => "AMO-SCM"])
                            ->where(['users.access_level'=>2]) //Director
                            ->get();
            }elseif ($division=="IPD") {
                $subscriber_emails = DB::table('users')
                            ->where(['users.division' => "IPD"])
                            ->where(['users.access_level'=>2]) //Director
                            ->get();
            }elseif ($division=="IRD") {
                $subscriber_emails = DB::table('users')
                            ->where(['users.division' => "IRD"])
                            ->where(['users.access_level'=>2]) //Director
                            ->get();
            }elseif ($division=="PuRD") {
                $subscriber_emails = DB::table('users')
                            ->where(['users.division' => "PuRD"])
                            ->where(['users.access_level'=>2]) //Director
                            ->get();
            }elseif ($division=="FD") {
                $subscriber_emails = DB::table('users')
                            ->where(['users.division' => "FD"])
                            ->where(['users.access_level'=>2]) //Director
                            ->get();
            }elseif ($division=="AD") {
                $subscriber_emails = DB::table('users')
                            ->where(['users.division' => "AD"])
                            ->where(['users.access_level'=>2]) //Director
                            ->get();
            }
        }

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

                        
                        Mail::send('mailer.mail-outgoing', $mdata, function($message) use ($receiptient,$pr){
                            $message->from('no-reply@minda.gov.ph');
                            $message->to($receiptient);
                            $message->subject($pr.' Mail from Document Tracking System');
                        });
                    }
            }
                //}
   }

   public function send_to_user($name,$class,$id){
        $subscriber_emails = DB::table('users')
                    ->where(['users.f_name' => $name])
                    ->get();

            $mdata = array('name'=>"Document Tracking Notification");

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

                
                Mail::send('mailer.mail-outgoing-user', $mdata, function($message) use ($receiptient,$pr){
                      $message->from('no-reply@minda.gov.ph');
                      $message->to($receiptient);
                      $message->subject($pr.' Mail from Document Tracking System');
               
                  });
                

            }
   }

   public function send_to_receiver($email,$class,$docdesc,$ref,$cor)
   {
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

            $mdata = [
                'name'      =>  "Mindanao Development Authority",
                'dsc'       =>  $docdesc,
                'prio'      =>  $pr,
                'barcode'   =>  $ref,
                'corier'    =>  $cor
            ];

            $r_mail = $email;
            $ddesc = $docdesc;

                
                    
                    Mail::send('mailer.outgoing-mail-receiver', ['data1'=>$mdata] , function($message) use ($r_mail,$pr){
                          $message->from('no-reply@minda.gov.ph');
                          $message->to($r_mail);
                          $message->subject($pr.' Mail from Document Tracking System');
                      });
      
            
   }

    public function count_all()
    {
        if(request()->ajax())
        {
            if(Auth::user()->access_level==5 || Auth::user()->access_level==4)
            {
                $outgoing_cnt = DB::table('outgoing_departments')
                            ->join('outgoings','outgoing_departments.ff_id','=','outgoings.id')
                            ->groupBy('outgoings.barcode')
                            ->get()
                            ->count();

            $outgoing_cnt_pending = DB::table('outgoing_history')
                            ->join('outgoings','outgoing_history.ref_id','=','outgoings.id')
                            ->where(['outgoing_history.stat'=>'pending'])
                            ->groupBy('outgoings.barcode')
                            ->get()
                            ->count();

            $outgoing_cnt_approve = DB::table('outgoing_history')
                            ->join('outgoings','outgoing_history.ref_id','=','outgoings.id')
                            ->where(['outgoing_history.stat'=>'approve'])
                            ->groupBy('outgoings.barcode')
                            ->get()
                            ->count();

            $outgoing_cnt_disapprove = DB::table('outgoing_history')
                            ->join('outgoings','outgoing_history.ref_id','=','outgoings.id')
                            ->where(['outgoing_history.stat'=>'disapprove'])
                            ->groupBy('outgoings.barcode')
                            ->get()
                            ->count();

            $outgoing_cnt_complete = DB::table('outgoing_history')
                            ->join('outgoings','outgoing_history.ref_id','=','outgoings.id')
                            ->where(['outgoing_history.stat'=>'complete'])
                            ->groupBy('outgoings.barcode')
                            ->get()
                            ->count();

            return response()->JSON(['outgoing_data' => $outgoing_cnt, 'outgoing_cnt_p' => $outgoing_cnt_pending, 'outgoing_appr' => $outgoing_cnt_approve, 'outgoing_disapp' => $outgoing_cnt_disapprove, 'outgoing_complete' => $outgoing_cnt_complete]);

            }else{
                $outgoing_cnt = DB::table('outgoing_departments')
                            ->join('outgoings','outgoing_departments.ff_id','=','outgoings.id')
                            ->where(['outgoing_departments.dept'=>Auth::user()->division])
                            ->groupBy('outgoings.barcode')
                            ->get()
                            ->count();

            $outgoing_cnt_pending = DB::table('outgoing_history')
                            ->join('outgoings','outgoing_history.ref_id','=','outgoings.id')
                            ->where(['outgoing_history.stat'=>'pending','outgoing_history.department'=>Auth::user()->division])
                            ->groupBy('outgoings.barcode')
                            ->get()
                            ->count();

            $outgoing_cnt_approve = DB::table('outgoing_history')
                            ->join('outgoings','outgoing_history.ref_id','=','outgoings.id')
                            ->where(['outgoing_history.stat'=>'approve','outgoing_history.department'=>Auth::user()->division])
                            ->groupBy('outgoings.barcode')
                            ->get()
                            ->count();

            $outgoing_cnt_disapprove = DB::table('outgoing_history')
                            ->join('outgoings','outgoing_history.ref_id','=','outgoings.id')
                            ->where(['outgoing_history.stat'=>'disapprove','outgoing_history.department'=>Auth::user()->division])
                            ->groupBy('outgoings.barcode')
                            ->get()
                            ->count();

            $outgoing_cnt_complete = DB::table('outgoing_history')
                            ->join('outgoings','outgoing_history.ref_id','=','outgoings.id')
                            ->where(['outgoing_history.stat'=>'complete','outgoing_history.department'=>Auth::user()->division])
                            ->groupBy('outgoings.barcode')
                            ->get()
                            ->count();

            return response()->JSON(['outgoing_data' => $outgoing_cnt, 'outgoing_cnt_p' => $outgoing_cnt_pending, 'outgoing_appr' => $outgoing_cnt_approve, 'outgoing_disapp' => $outgoing_cnt_disapprove, 'outgoing_complete' => $outgoing_cnt_complete]);
            }
        }
    }

    public function tracking_approve(Request $request,$id)
    {
        if(request()->ajax())
        {
            $docs = DB::table('outgoings')
                    ->get();

            foreach ($docs as $i)
                {
                    $prevdate = $i->doc_date_ff;
                    $doc_id = $i->id;

                        $curdate = Carbon::now();

                        $diff = Carbon::parse($curdate)->diffInDays($prevdate);

                        $update_doc = DB::table('outgoings')
                                ->where(['outgoings.id'=>$doc_id,'outgoings.status'=>'pending'])
                                ->update([
                                    'day_count'=>$diff,
                                ]);
                }


            $data = DB::table('outgoings')
                    ->where(['outgoings.id'=>$id])
                    ->update([
                        'status'=>'approve',
                    ]);

                    
            $data = DB::table('outgoing_departments')
                    ->where(['outgoing_departments.ff_id'=>$id,'outgoing_departments.dept'=>Auth::user()->division])
                    ->update([
                        'stat'=>'approve',
                    ]);
            
                    /*
            $data = DB::table('outgoing_history')
                    ->where(['outgoing_history.ref_id'=>$id,'outgoing_history.department'=>Auth::user()->division])
                    ->update([
                        'stat'=>'approve',
                        'destination' => Auth::user()->division.' approve this document',
                        'remarks'=>'approve on '.Carbon::now()->format('F j, Y').' @ '.Carbon::now()->format('H:i:s'),
                    ]);

                    */

            $data = DB::insert('insert into outgoing_history (ref_id, remarks, date_ff, date_forwared, days_count, department,stat, destination) values (?, ?, ?, ?, ?, ?, ?, ?)', 
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
            $docs = DB::table('outgoings')
                    ->get();

            foreach ($docs as $i)
                {
                    $prevdate = $i->doc_date_ff;
                    $doc_id = $i->id;

                        $curdate = Carbon::now();

                        $diff = Carbon::parse($curdate)->diffInDays($prevdate);

                        $update_doc = DB::table('outgoings')
                                ->where(['outgoings.id'=>$doc_id,'outgoings.status'=>'pending'])
                                ->update([
                                    'day_count'=>$diff,
                                ]);
                }

            $data = DB::table('outgoings')
                    ->where(['outgoings.id'=>$id])
                    ->update([
                        'status'=>'disapprove',
                    ]);

                    
            $data = DB::table('outgoing_departments')
                    ->where(['outgoing_departments.ff_id'=>$id,'outgoing_departments.dept'=>Auth::user()->division])
                    ->update([
                        'stat'=>'disapprove',
                    ]);
            
            /*
            $data = DB::table('outgoing_history')
                    ->where(['outgoing_history.ref_id'=>$id,'outgoing_history.department'=>Auth::user()->division])
                    ->update([
                        'stat'=>'disapprove',
                        'destination' => Auth::user()->division.' disapprove this document',
                        'remarks'=>'disapprove on '.Carbon::now()->format('F j, Y').' @ '.Carbon::now()->format('H:i:s'),
                    ]);
                    */

            $data = DB::insert('insert into outgoing_history (ref_id, remarks, date_ff, date_forwared, days_count, department,stat, destination) values (?, ?, ?, ?, ?, ?, ?, ?)', 
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

            $dept = DB::insert('insert into outgoing_departments (ff_id, dept, stat) values (?, ?, ?)',
            [
                $request->get('_id'),
                $request->get('division'),
                'disapprove',
            ]);

            return response()->JSON(['data' => $data]);      
        }
    }

    public function track_list_document($id)
    {
        $data = DB::table('outgoing_history')
                    ->join('outgoings','outgoing_history.ref_id','=','outgoings.id')
                    ->where(['outgoings.id'=>$id])
                    //->groupBy('outgoings.barcode')
                    ->orderBy('outgoing_history.id','desc')
                    ->get();

        $datefilter = DB::table('outgoings')
                        ->groupBy('outgoings.doc_date_ff')
                        ->orderBy('outgoings.id','asc')
                        ->get();

        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        $docimages = DB::table('outgoing_files')
                    ->where(['outgoing_files.ref_id'=>$id])
                    ->orderBy('outgoing_files.id','asc')
                    ->get();

        $lib = DB::table('library')
                    ->orderBy('library.id','asc')
                    ->get();

        $courier = DB::table('courier')
                    ->orderBy('courier.id','asc')
                    ->get();

        if(Auth::user()->access_level=='5' and Auth::user()->division=='RECORDS'){
            $div = DB::table('users')
                    ->where(['users.division'=>'OC'])
                    ->orWhere(['users.division'=>'OED'])
                    ->orWhere(['users.division'=>'RECORDS'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        }else if(Auth::user()->division=='RECORDS' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'RECORDS'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        }else if(Auth::user()->division=='OC' and Auth::user()->access_level=='4'){
            $div = DB::table('users')
                    ->where(['users.division'=>'OFAS'])
                    ->orWhere(['users.division'=>'PPPDO'])
                    ->orWhere(['users.division'=>'IPPAO'])
                    ->orWhere(['users.division'=>'OC'])
                    ->orWhere(['users.division'=>'OED'])
                    ->orWhere(['users.division'=>'RECORDS'])
                    ->orWhere('users.division',"like",'AMO%')
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        }else if(Auth::user()->division=='OC' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'OC'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        }else if(Auth::user()->division=='PPPDO' and Auth::user()->access_level=='3'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PPPDO'])
                    ->orWhere(['users.division'=>'PRD'])
                    ->orWhere(['users.division'=>'PFD'])
                    ->orWhere(['users.division'=>'PDD'])
                    ->orWhere(['users.division'=>'KMD'])
                    ->orWhere(['users.division'=>'OC'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='PPPDO' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PPPDO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='IPPAO' and Auth::user()->access_level=='3'){
            $div = DB::table('users')
                    ->where(['users.division'=>'IPPAO'])
                    ->orWhere(['users.division'=>'IPD'])
                    ->orWhere(['users.division'=>'IRD'])
                    ->orWhere(['users.division'=>'PuRD'])
                    ->orWhere(['users.division'=>'OC'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='IPPAO' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'IPPAO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='OFAS' and Auth::user()->access_level=='3'){
            $div = DB::table('users')
                    ->where(['users.division'=>'OFAS'])
                    ->orWhere(['users.division'=>'FD'])
                    ->orWhere(['users.division'=>'AD'])
                    ->orWhere(['users.division'=>'OC'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='OFAS' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'OFAS'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='PRD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PRD'])
                    ->orWhere(['users.division'=>'PPPDO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='PRD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PRD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='PFD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PFD'])
                    ->orWhere(['users.division'=>'PPPDO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='PFD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PFD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='PDD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PDD'])
                    ->orWhere(['users.division'=>'PPPDO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='PDD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PDD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='KMD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'KMD'])
                    ->orWhere(['users.division'=>'PPPDO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='KMD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'KMD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='IPD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'IPD'])
                    ->orWhere(['users.division'=>'IPPAO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='IPD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'IPD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='IRD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'IRD'])
                    ->orWhere(['users.division'=>'IPPAO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='IRD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'IRD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='PuRD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PuRD'])
                    ->orWhere(['users.division'=>'IPPAO'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='PuRD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'PuRD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='FD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'FD'])
                    ->orWhere(['users.division'=>'OFAS'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='FD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'FD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='AD' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AD'])
                    ->orWhere(['users.division'=>'OFAS'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='AD' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AD'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='AMO-CM' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-CM'])
                    ->orWhere(['users.division'=>'OC'])
                    ->orWhere(['users.division'=>'OED'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='AMO-CM' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-CM'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='AMO-NM' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-NM'])
                    ->orWhere(['users.division'=>'OC'])
                    ->orWhere(['users.division'=>'OED'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='AMO-NM' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-NM'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='AMO-WM' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-WM'])
                    ->orWhere(['users.division'=>'OC'])
                    ->orWhere(['users.division'=>'OED'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='AMO-WM' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-WM'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='AMO-NEM' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-NEM'])
                    ->orWhere(['users.division'=>'OC'])
                    ->orWhere(['users.division'=>'OED'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='AMO-NEM' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-NEM'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else if(Auth::user()->division=='AMO-SCM' and Auth::user()->access_level=='2'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-SCM'])
                    ->orWhere(['users.division'=>'OC'])
                    ->orWhere(['users.division'=>'OED'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }else if(Auth::user()->division=='AMO-SCM' and Auth::user()->access_level=='1'){
            $div = DB::table('users')
                    ->where(['users.division'=>'AMO-SCM'])
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        else{
            $div = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();
        }

        $isopen = DB::table('outgoing_history')
                    ->where(['outgoing_history.department'=>Auth::user()->division,'outgoing_history.ref_id'=>$id])
                    ->update([
                        'actioned' => 1,
                    ]);


        return view('outgoing.doc-view-track-list', compact('papcode','data','datefilter','userlist','docimages','lib','courier','div'));
    }

     public function edit_docs_details($ref_id)
    {
        if(request()->ajax())
        {
            $data = DB::table('outgoings')
                    ->where(['outgoings.id'=>$ref_id])
                    ->get();

            return response()->JSON(['data' => $data]); 
        }
    }

    public function update_docs_details(Request $request, $ref_id)
    {
        if(request()->ajax())
        {
            $data = DB::table('outgoings')
                    ->where(['outgoings.id'=>$ref_id])
                    ->update([
                        'agency'            => $request->get('_agency'),
                        'doctitle'          => $request->get('_doctitle'),
                        'description'       => $request->get('_desc'),
                        'barcode'           => $request->get('_barcode'),
                        'sendto'            => $request->get('_agencyto'),
                        'signatory'         => $request->get('_signature'),
                        'sendto_email'      => $request->get('_signaturemail'),
                        'doc_receive'       => $request->get('_docdate'),
                        'briefer_number'    => $request->get('_briefer'),
                        'retdoc'            => $request->get('returndoc'),
                        'releasemode'       => $request->get('_releasemode'),
                    ]);

            return response()->JSON(['data' => $data]); 
        }
    }


    public function tracking_complete(Request $request,$id)
    {
        if(request()->ajax())
        {
            $data = DB::table('outgoings')
                    ->where(['outgoings.id'=>$id])
                    ->update([
                        'status'=>'complete',
                    ]);

                    
            $data = DB::table('outgoing_departments')
                    ->where(['outgoing_departments.ff_id'=>$id,'outgoing_departments.dept'=>Auth::user()->division])
                    ->update([
                        'stat'=>'complete',
                    ]);
            

            $data = DB::table('outgoing_history')
                    ->where(['outgoing_history.ref_id'=>$id,'outgoing_history.department'=>Auth::user()->division])
                    ->update([
                        'stat'=>'complete',
                    ]);

            return response()->JSON(['data' => $data]);      
        }
    }

    public function class_out_confidential(Request $request, $id){
        //echo($id);
        if(request()->ajax())
        {
            $classcategory = $request->get('docclass');

            if($classcategory === 1){
                $data = DB::table('outgoing_history')
                        ->where(['outgoing_history.ref_id' => $id])
                        ->update([
                            'classification' => $request->get('docclass'),
                            'confi_name' => $request->get('confiname'),
                        ]);
            }else{
                $data = DB::table('outgoing_history')
                        ->where(['outgoing_history.ref_id' => $id])
                        ->update([
                            'classification' => $request->get('docclass'),
                            'confi_name' => null,
                        ]);

            }

            return response()->JSON(['data' => $data]);  
        }

    }

    public function class_out_confide_name(Request $request, $id){
        //echo($id);
        if(request()->ajax())
        {
            $data = DB::table('outgoing_history')
                    ->where(['outgoing_history.ref_id' => $id])
                    ->update([
                        'classification' => $request->get('docclass'),
                        'confi_name' => $request->get('confiname'),
                    ]);


            return response()->JSON(['data' => $data]);  
        }

    }

    public function search_barcode($barcode)
    {
        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        $datefilter = DB::table('outgoings')
                        ->groupBy('outgoings.doc_date_ff')
                        ->orderBy('outgoings.id','asc')
                        ->get();

        if (Auth::user()->access_level==5 || Auth::user()->access_level==4)
        {   
            $data = DB::table('outgoing_departments')
                ->join('outgoings','outgoing_departments.ff_id','=','outgoings.id')
                ->join('outgoing_history','outgoing_history.ref_id','=','outgoing_departments.ff_id')
                ->where(['outgoings.barcode'=>$barcode])
                ->groupBy('outgoings.barcode')
                ->orderBy('outgoings.day_count','desc')
                ->orderBy('outgoings.created_at','desc')
                ->paginate(10)
                ->onEachSide(2);
        
        }else{
            $data = DB::table('outgoing_departments')
                ->join('outgoings','outgoing_departments.ff_id','=','outgoings.id')
                ->join('outgoing_history','outgoing_history.ref_id','=','outgoing_departments.ff_id')
                ->where(['outgoing_departments.dept'=>Auth::user()->division,'outgoings.barcode'=>$barcode])
                ->groupBy('outgoings.barcode')
                ->orderBy('outgoings.day_count','desc')
                ->orderBy('outgoings.created_at','desc')
                ->paginate(10)
                ->onEachSide(2);
        }

        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        $lib = DB::table('library')
                    ->orderBy('library.id','asc')
                    ->get();

        $div = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        $courier = DB::table('courier')
                    ->orderBy('courier.id','asc')
                    ->get();

        //dd($data);
        return view('outgoing.doc-view-list',compact('data','papcode','userlist','datefilter','lib','div','courier'));
    }

    public function filter_date($date)
    {
        $search = date('Y-m-d', strtotime($date));
        $userlist = DB::table('users')
                    ->orderBy('users.f_name')
                    ->get();

        if (Auth::user()->access_level==5 || Auth::user()->access_level==4)
        {
            $data = DB::table('outgoing_departments')
                ->join('outgoings','outgoing_departments.ff_id','=','outgoings.id')
                ->join('outgoing_history','outgoing_history.ref_id','=','outgoing_departments.ff_id')
                ->where(['outgoings.doc_date_ff'=>$search])
                ->groupBy('outgoings.barcode')
                ->orderBy('outgoings.day_count','desc')
                ->orderBy('outgoings.created_at','desc')
                ->paginate(10)
                ->onEachSide(2);
        }else{
            $data = DB::table('outgoing_departments')
                ->join('outgoings','outgoing_departments.ff_id','=','outgoings.id')
                ->join('outgoing_history','outgoing_history.ref_id','=','outgoing_departments.ff_id')
                ->where(['outgoing_departments.dept'=>Auth::user()->division,'outgoings.doc_date_ff'=>$search])
                ->groupBy('outgoings.barcode')
                ->orderBy('outgoings.day_count','desc')
                ->orderBy('outgoings.created_at','desc')
                ->paginate(10)
                ->onEachSide(2);
        }

        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        $datefilter = DB::table('outgoings')
                        ->groupBy('outgoings.doc_date_ff')
                        ->orderBy('outgoings.id','asc')
                        ->get();

        $lib = DB::table('library')
                    ->orderBy('library.id','asc')
                    ->get();

        $div = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        $courier = DB::table('courier')
                    ->orderBy('courier.id','asc')
                    ->get();

        //dd($data);
        return view('outgoing.doc-view-list',compact('data','papcode','userlist','datefilter','lib','div','courier'));
    }

    public function get_barcode_value($bnum)
    {
        if(request()->ajax())
        {

            $data = DB::table('outgoings')
                    ->where(['outgoings.barcode'=>$bnum])
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
