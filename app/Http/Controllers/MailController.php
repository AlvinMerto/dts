<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mail\ExternalDocumentConfirm;

class MailController extends Controller
{
    //
    public function send_email() {
      $data = array('name'=>"Document Tracking Notification");
      Mail::send('mailer.mail-internal', $data, function($message) {
         $message->to('joules.rico@gmail.com', 'Document Tracking Notification')->subject
            ('Document Tracking Notification');
         $message->from('no-reply@minda.gov.ph','MinDA Document Tracking');
      });
      echo "HTML Email Sent. Check your inbox.";
   }

   public function external_confirmation()
   {
    /*
    $data = [
          'first_name'=>Auth::user()->name, 
          'last_name'=>Auth::user()->f_name, 
          'email'=>Auth::user()->email,
          'password'=>Auth::user()->position
      ];

      \Mail::to('joules.rico@gmail.com')->send(new ExternalDocumentConfirm($data));

      return redirect()->back();
      */


      $data = [
             'username' => Auth::user()->name,
             'password' => Auth::user()->password
      ];

      Mail::send('mailer.externalconfirm', ['data1'=>$data] , function($message){
              $message->from('no-reply@minda.gov.ph');
              $message->to('joules.rico@gmail.com', 'itsFromMe');
              $message->subject('thisIsMySucject');
         });

        return redirect()->back();

    }
}
