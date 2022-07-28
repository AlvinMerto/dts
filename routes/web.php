<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InternalController;
use App\Http\Controllers\ExternalController;
use App\Http\Controllers\OutgoingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ImportExcelController;
use App\Http\Controllers\Controller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/', function(){
	echo phpinfo();
});
*/

 Route::get('/',[HomeController::class, 'index'])->name('home');

/*
Route::get("/", function(){
	echo phpinfo();
});
*/

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get("/test",function(){
	echo "hello world";
});

Auth::routes();

//\\hide external//\\
//<< external >>
Route::get('/external-document-new-entry', [ExternalController::class, 'new_document']);

Route::post('/external-document/save-entry', [ExternalController::class, 'save_new_documnent']);

Route:: get('/external-document-list-view',[ExternalController::class, 'list_document']);

Route::post('/external-document/forward/{id}',[ExternalController::class, 'ff_doc']);

Route:: get('/external-document-list-view-sort-az',[ExternalController::class, 'list_document_ascending']);

Route::get('/external-document-track-list-view/view-document-tracking/{id}',[ExternalController::class, 'track_list_document']);

Route::post('/external-document/doc-tracking-complete/{id}',[ExternalController::class, 'tracking_complete']);

Route:: get('/external-document-list-view/pending',[ExternalController::class, 'pending_list']);

Route:: get('/external-document-list-view/on-going',[ExternalController::class, 'ongoing_list']);

Route:: get('/external-document-list-view/approve',[ExternalController::class, 'approve_list']);

Route:: get('/external-document-list-view/disapprove',[ExternalController::class, 'disapprove_list']);

Route:: get('/external-document-list-view/complete',[ExternalController::class, 'complete_list']);

Route::get('/external-document/search-document/{barcode}',[ExternalController::class, 'search_barcode']);

//
Route::get('/external-document/filter-date/{date}',[ExternalController::class, 'filter_date']);

Route::get('/external-document/filter-type/{type}',[ExternalController::class, 'filter_type']);

Route::get('/external-document/edit-document-details/{ref_id}',[ExternalController::class, 'edit_docs_details']);

Route::post('/external-document/update-document-details/{ref_id}',[ExternalController::class, 'update_docs_details']);

Route::get('/external-document-new-entry/upload-image/{id}',[ExternalController::class, 'upload_image']);

Route::post('/external-document-new-entry/save-image/{id}',[ExternalController::class, 'save_image']);

Route::get('/external-document/remove-image/{id}/{ref_id}/{img}',[ExternalController::class, 'remove_file']);

Route::post('/external-document/doc-tracking-approve/{id}',[ExternalController::class, 'tracking_approve']);

Route::post('/external-document/doc-tracking-disapprove/{id}',[ExternalController::class, 'tracking_disapprove']);

Route::post('/external-document/confidential/{id}',[ExternalController::class, 'class_confide_name']);

Route::post('/external-document/docclass/{id}',[ExternalController::class, 'class_confidential']);

Route::get('/external-document/document-return-category/{id}',[ExternalController::class, 'get_return_value']);

Route::get('/external-document/division-record-summary/{s}/{e}',[ReportController::class, 'export_external_division_range']);

Route::get('/external-document/barcode-number/{bnum}',[ExternalController::class, 'get_barcode_value']);

//
//////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\///////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\

//<< INTERNAL >>
Route::get('/internal-document-new-entry',[InternalController::class, 'new_document']);

Route::post('/internal-document/save-entry',[InternalController::class, 'save_new_documnent']);

Route:: get('/internal-document-list-view',[InternalController::class, 'list_document']);

Route:: get('/internal-document-list-view-sort-az',[InternalController::class, 'list_document_ascending']);

Route::post('/internal-document/forward/{id}',[InternalController::class, 'ff_doc']);

Route::get('/internal-document-track-list-view/view-document-tracking/{id}',[InternalController::class, 'track_list_document']);

Route::post('/internal-document/doc-tracking-complete/{id}',[InternalController::class, 'tracking_complete']);

Route:: get('/internal-document-list-view/pending',[InternalController::class, 'pending_list']);

Route:: get('/internal-document-list-view/on-going',[InternalController::class, 'ongoing_list']);

Route:: get('/internal-document-list-view/approve',[InternalController::class, 'approve_list']);

Route:: get('/internal-document-list-view/disapprove',[InternalController::class, 'disapprove_list']);

Route:: get('/internal-document-list-view/complete',[InternalController::class, 'complete_list']);

Route::get('/internal-document/search-document/{barcode}',[InternalController::class, 'search_barcode']);

Route::get('/internal-document/filter-date/{date}',[InternalController::class, 'filter_date']);

Route::post('/internal-document/docclass/{id}',[InternalController::class, 'class_confidential']);

Route::post('/internal-document/confidential/{id}',[InternalController::class, 'class_confide_name']);
//
Route::get('/internal-document/edit-document-details/{ref_id}',[InternalController::class, 'edit_docs_details']);

Route::post('/internal-document/update-document-details/{ref_id}',[InternalController::class, 'update_docs_details']);

Route::get('/internal-document-new-entry/upload-image/{id}',[InternalController::class, 'upload_image']);

Route::post('/internal-document-new-entry/save-image/{id}',[InternalController::class, 'save_image']);

Route::get('/internal-document/remove-image/{id}/{ref_id}/{img}',[InternalController::class, 'remove_file']);

Route::post('/internal-document/doc-tracking-approve/{id}',[InternalController::class, 'tracking_approve']);

Route::post('/internal-document/doc-tracking-disapprove/{id}',[InternalController::class, 'tracking_disapprove']);

Route::get('/internal-document/document-return-category/{id}',[InternalController::class, 'get_return_value']);

Route::get('/internal-document/division-record-summary/{s}/{e}',[ReportController::class, 'internal_division_summary']);

Route::get('/internal-document/barcode-number/{bnum}',[InternalController::class, 'get_barcode_value']);

Route::get('/get-users/{d}',[InternalController::class,'get_user_list']);

//

//<< OUTGOING >>

Route::get('/outgoing-document-new-entry',[OutgoingController::class, 'new_document']);

Route::post('/outgoing-document/save-entry',[OutgoingController::class, 'save_new_documnent']);

Route:: get('/outgoing-document-list-view',[OutgoingController::class, 'list_document']);

Route:: get('/outgoing-document-list-view-sort-az',[OutgoingController::class, 'list_document_ascending']);

Route::post('/outgoing-document/forward/{id}',[OutgoingController::class, 'ff_doc']);

Route::get('/outgoing-document-track-list-view/view-document-tracking/{id}',[OutgoingController::class, 'track_list_document']);

Route::post('/outgoing-document/doc-tracking-complete/{id}',[OutgoingController::class, 'tracking_complete']);

Route:: get('/outgoing-document-list-view/pending',[OutgoingController::class, 'pending_list']);

Route:: get('/outgoing-document-list-view/approve',[OutgoingController::class, 'approve_list']);

Route:: get('/outgoing-document-list-view/disapprove',[OutgoingController::class, 'disapprove_list']);

Route:: get('/outgoing-document-list-view/complete',[OutgoingController::class, 'complete_list']);

Route::get('/outgoing-document/search-document/{barcode}',[OutgoingController::class, 'search_barcode']);

Route::get('/outgoing-document/filter-date/{date}',[OutgoingController::class, 'filter_date']);

Route::post('/outgoing-documents/docclass/{id}',[OutgoingController::class, 'class_out_confidential']);

Route::post('/outgoing-documents/confidential/{id}',[OutgoingController::class, 'class_out_confide_name']);

Route::get('/outgoing-document/document-return-category/{id}',[OutgoingController::class, 'get_return_value']);

//

Route::get('/outgoing-document-new-entry/upload-image/{id}',[OutgoingController::class, 'upload_image']);

Route::post('/outgoing-document-new-entry/save-image/{id}',[OutgoingController::class, 'save_image']);

Route::get('/outgoing-document/remove-image/{id}/{ref_id}/{img}',[OutgoingController::class, 'remove_file']);

Route::get('/outgoing-document/edit-document-details/{ref_id}',[OutgoingController::class, 'edit_docs_details']);

Route::post('/outgoing-document/update-document-details/{ref_id}',[OutgoingController::class, 'update_docs_details']);

Route::post('/outgoing-document/doc-tracking-approve/{id}',[OutgoingController::class, 'tracking_approve']);

Route::post('/outgoing-document/doc-tracking-disapprove/{id}',[OutgoingController::class, 'tracking_disapprove']);

Route::get('/outgoing-document/barcode-number/{bnum}',[OutgoingController::class, 'get_barcode_value']);

Route::get('/outgoing-document/division-record-summary/{s}/{e}',[ReportController::class, 'export_outgoing_division_range']);

//Tracking Number

Route::get('/tracking-numbers',[HomeController::class, 'tracking_number']);

Route::get('/tracking-numbers/filter-type/{type}',[HomeController::class, 'filter_number']);
//

//<< COUNT INCOMING DOCS >>

Route::get('/count-external-docs',[ExternalController::class, 'count_all']);

Route::get('/count-internal-docs',[InternalController::class, 'count_all']);

Route::get('/count-outgoing-docs',[OutgoingController::class, 'count_all']);

//<<SETTINGS>>

Route::get('/setting-read-json',[SettingController::class, 'read_json']);

Route::get('/setting/read-json',[SettingController::class, 'incsv']);

Route::get('/setting/my-account/{id}',[SettingController::class, 'view_profile']);

Route::get('/setting/my-account/update/{id}',[SettingController::class, 'update_profile']);

Route::get('/settings/change-account-password/{id}',[SettingController::class, 'change_credentials']);

Route::post('/settings/update-password/{id}',[SettingController::class, 'update_credential']);

Route::post('/settings/update-profile/{id}',[SettingController::class, 'save_profile_data']);

Route::post('/settings/my-account/upload-image/{id}',[SettingController::class, 'upload_image']);

//TRACKING DETAILS

Route::get('/document-tracking-details/{id}',[HomeController::class, 'tracking_details']);

Route::get('/document-tracking-number/{id}',[HomeController::class, 'tracking_barcode']);

//IMPORT EXCEL DATA

Route::get('/import-excel', [ImportExcelController::class, 'index']);

Route::post('/import-excel/import', [ImportExcelController::class, 'import']);

Route::post('/import', [ImportExcelController::class, 'import'])->name('import');

//////////////////////////AUTO-EMAIL///////////////////////////////////////////////

Route::get('/sendautomail',[InternalController::class, 'send_email']);

//////////////////////////ADMIN///////////////////////////////////////////////

Route::get('/admin',[HomeController::class, 'admin_users_control']);

Route::post('/admin/access-level/{id}',[HomeController::class, 'admin_users_control_edit']);

Route::get('/admin/division/{division}',[HomeController::class, 'filter_by_division']);

Route::get('/admin/employee/{name}',[HomeController::class, 'filter_by_name']);

Route::get('/library/library',[HomeController::class, 'view_library']);

Route::get('/library/library/new-entry',[HomeController::class, 'entry_library']);

Route::post('/library/library/save-entry',[HomeController::class, 'save_library']);

Route::get('/library/library/edit-entry/{id}',[HomeController::class, 'edit_library']);

Route::post('/library/library/update-entry/{id}',[HomeController::class, 'update_library']);

Route::get('/library/library/remove-entry/{id}',[HomeController::class, 'remove_library']);

/////////////////////////////////////////////////////////////

Route::get('/courier/library',[HomeController::class, 'courier_view_library']);

Route::get('/courier/library/new-entry',[HomeController::class, 'courier_entry_library']);

Route::post('/courier/library/save-entry',[HomeController::class, 'courier_save_library']);

Route::get('/courier/library/edit-entry/{id}',[HomeController::class, 'courier_edit_library']);

Route::post('/courier/library/update-entry/{id}',[HomeController::class, 'courier_update_library']);

Route::get('/courier/library/remove-entry/{id}',[HomeController::class, 'courier_remove_library']);

//EXPORT EXCEL

Route::get('/export-excel-internal/excel-file-report/document-tracking/{id}',[ReportController::class, 'excel_internal']);

Route::get('/export-excel-external/excel-file-report/document-tracking/{id}',[ReportController::class, 'excel_external']);

Route::get('/export-excel-outgoing/excel-file-report/document-tracking/{id}',[ReportController::class, 'excel_outgoing']);

Route::get('/export-excel/internal-records',[ReportController::class, 'export_internal_all']);

Route::get('/export-excel/external-records',[ReportController::class, 'export_external_all']);

Route::get('/export-excel/outgoing-records',[ReportController::class, 'export_outgoing_all']);

Route::get('/export-excel/internal-records-range/{s}/{e}',[ReportController::class, 'export_internal_range']);

Route::get('/export-excel/external-records-range/{s}/{e}',[ReportController::class, 'export_external_range']);

Route::get('/export-excel/outgoing-records-range/{s}/{e}',[ReportController::class, 'export_outgoing_range']);

Route::get('/acknowledment-receipt/{id}',[ReportController::class, 'acknowledgementreceipt']);
///export-excel/external-records-range

//BARCODE READER

Route::get('/barcode-reader',[HomeController::class, 'barcode']);

Route::get('/sendMail-data',[MailController::class, 'external_confirmation']);