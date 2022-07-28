<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;
use PDF;
use DateTime;
use DateInterval;
use DatePeriod;

class ReportController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function excel_internal($id)
    {
    	$unitfont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => '000000'),
		        'size'  => 11,
		        'name'  => 'Calibri'
		    ));

    	$headtitlefont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => 'ffffff'),
		        'size'  => 11,
		        'name'  => 'Calibri'
		    ));

    	$rpfont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => '000000'),
		        'size'  => 11,
		        'name'  => 'Calibri'
		    ));

    	$mindafont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => '000000'),
		        'size'  => 16,
		        'name'  => 'Calibri'
		    ));

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

        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet = $spreadsheet->getActiveSheet()->setTitle($data[0]->barcode);

		$sheet->getColumnDimension('A')->setAutoSize(false);
		$sheet->getColumnDimension('A')->setWidth(45.67);
		$sheet->getColumnDimension('B')->setAutoSize(false);
		$sheet->getColumnDimension('B')->setWidth(28);
		$sheet->getColumnDimension('C')->setAutoSize(false);
		$sheet->getColumnDimension('C')->setWidth(14.44);
		$sheet->getColumnDimension('D')->setAutoSize(false);
		$sheet->getColumnDimension('D')->setWidth(15.22);
		$sheet->getColumnDimension('E')->setAutoSize(false);
		$sheet->getColumnDimension('E')->setWidth(26.11);

		$sheet->getRowDimension('1')->setRowHeight(24.60);
		$sheet->getRowDimension('2')->setRowHeight(24.60);
		$sheet->getRowDimension('3')->setRowHeight(24.60);
		$sheet->getRowDimension('4')->setRowHeight(24.60);
		$sheet->getRowDimension('5')->setRowHeight(24.60);
		$sheet->getRowDimension('6')->setRowHeight(26.60);

		$sheet->getStyle('A1:E5')->getAlignment()->setVertical('center');

		$sheet->setCellValue('A1','Republic of the Philippines');
		$sheet->setCellValue('A2','Office of the President');
		$sheet->setCellValue('A3','Mindanao Development Authority');

		$sheet->mergeCells('A1:E1');
		$sheet->mergeCells('A2:E2');
		$sheet->mergeCells('A3:E3');
		$sheet->getStyle('A1:E3')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('A1:E2')->applyFromArray($rpfont);
		$sheet->getStyle('A3:E3')->applyFromArray($mindafont);

		$sheet->setCellValue('A4', 'Document Date');
		$sheet->setCellValue('B4', date('F d, Y', strtotime($data[0]->doc_receive)));
		$sheet->setCellValue('D4', 'Briefer #');
		$sheet->setCellValue('E4', " ".$data[0]->briefer_number);
		$sheet->setCellValue('A5', 'Barcode');
		$sheet->setCellValue('B5', " ".$data[0]->barcode);
		$sheet->setCellValue('D5', 'Office/Division');
		$sheet->setCellValue('E5', $data[0]->agency);
		$sheet->setCellValue('A6', 'Document Type');
		$sheet->setCellValue('B6', $data[0]->type);
		$sheet->setCellValue('D6', 'Signatory');
		$sheet->setCellValue('E6', $data[0]->signatory);
		$sheet->setCellValue('A7', 'Document Category/Type');
		$sheet->setCellValue('B7', $data[0]->doctitle);
		$sheet->setCellValue('A8', 'Description');
		$sheet->setCellValue('B8', $data[0]->description);

		$sheet->getStyle('B4:B8')->applyFromArray($unitfont);
		$sheet->getStyle('E4:E8')->applyFromArray($unitfont);

		$sheet->setCellValue('A9', 'Forwarded to');
		$sheet->setCellValue('B9', 'Date Forwarded');
		$sheet->setCellValue('C9', 'Status');
		$sheet->setCellValue('D9', 'No. of Days');
		$sheet->setCellValue('E9', 'Action');

		$sheet->getStyle('A9:E9')->applyFromArray($headtitlefont);
		$sheet->getStyle('A9:E9')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('A9:E9')->getAlignment()->setVertical('center');
		$sheet->getStyle('A9:E9')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('3b5998');

		$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

		$row = 10;

		if($data->count()>0)
		{
	        foreach($data as $d)
	        {
	        	$sheet->setCellValue('A'.$row, $d->destination);
	            $sheet->setCellValue('B'.$row, $d->date_forwared);
	            $sheet->setCellValue('C'.$row, $d->stat);
	            $sheet->setCellValue('D'.$row, $d->days_count);
	            $rem = $d->remarks;
	            $find = ['<br>'];
	            $repl = [''];
	            $finalRemarks = Str::replaceArray('<br>', [''], $rem);
	            $sheet->setCellValue('E'.$row, $finalRemarks);
	            $sheet->getStyle('E'.$row)->getAlignment()->setWrapText(true);
	            $sheet->getStyle('A'.$row.':E'.$row)->getAlignment()->setVertical('center');
	            $row++;
	        }
    	}

    	$sheet->setCellValue('A'.$row+1, 'Note: Attachment should be downloaded separately.');

    	/*
		$protect = Str::random(10);

		$sheet->getProtection()->setSheet(true);
		$sheet->getProtection()->setSort(true);
		$sheet->getProtection()->setInsertRows(true);
		$sheet->getProtection()->setFormatCells(true);

		$sheet->getProtection()->setPassword($protect);
		*/

		$writer = new Xlsx($spreadsheet);
		$writer->save($data[0]->barcode.'-Internal.xlsx');

		$filename=$data[0]->barcode."-Internal.xlsx";
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
		$spreadsheet = $reader->load("$filename");

		return redirect('/'.$filename);
    }

    public function excel_external($id)
    {
    	$unitfont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => '000000'),
		        'size'  => 11,
		        'name'  => 'Calibri'
		    ));

    	$headtitlefont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => 'ffffff'),
		        'size'  => 11,
		        'name'  => 'Calibri'
		    ));

    	$rpfont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => '000000'),
		        'size'  => 11,
		        'name'  => 'Calibri'
		    ));

    	$mindafont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => '000000'),
		        'size'  => 16,
		        'name'  => 'Calibri'
		    ));

    	$data = DB::table('external_history')
                    ->join('externals','external_history.ref_id','=','externals.id')
                    ->where(['externals.id'=>$id])
                    //->groupBy('internals.barcode')
                    ->orderBy('external_history.id','desc')
                    ->get();
        $datefilter = DB::table('externals')
                        ->groupBy('externals.doc_receive')
                        ->orderBy('externals.id','asc')
                        ->get();

        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        $uname = Auth::user()->f_name;

        $docimages = DB::table('external_files')
                    ->where(['external_files.ref_id'=>$id])
                    ->orderBy('external_files.id','asc')
                    ->get();

        $lib = DB::table('library')
                    ->orderBy('library.id','asc')
                    ->get();

        $div = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet = $spreadsheet->getActiveSheet()->setTitle($data[0]->barcode);

		$sheet->getColumnDimension('A')->setAutoSize(false);
		$sheet->getColumnDimension('A')->setWidth(45.67);
		$sheet->getColumnDimension('B')->setAutoSize(false);
		$sheet->getColumnDimension('B')->setWidth(28);
		$sheet->getColumnDimension('C')->setAutoSize(false);
		$sheet->getColumnDimension('C')->setWidth(14.44);
		$sheet->getColumnDimension('D')->setAutoSize(false);
		$sheet->getColumnDimension('D')->setWidth(15.22);
		$sheet->getColumnDimension('E')->setAutoSize(false);
		$sheet->getColumnDimension('E')->setWidth(26.11);

		$sheet->getRowDimension('1')->setRowHeight(24.60);
		$sheet->getRowDimension('2')->setRowHeight(24.60);
		$sheet->getRowDimension('3')->setRowHeight(24.60);
		$sheet->getRowDimension('4')->setRowHeight(24.60);
		$sheet->getRowDimension('5')->setRowHeight(24.60);
		$sheet->getRowDimension('6')->setRowHeight(26.60);

		$sheet->getStyle('A1:E5')->getAlignment()->setVertical('center');

		$sheet->setCellValue('A1','Republic of the Philippines');
		$sheet->setCellValue('A2','Office of the President');
		$sheet->setCellValue('A3','Mindanao Development Authority');

		$sheet->mergeCells('A1:E1');
		$sheet->mergeCells('A2:E2');
		$sheet->mergeCells('A3:E3');
		$sheet->getStyle('A1:E3')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('A1:E2')->applyFromArray($rpfont);
		$sheet->getStyle('A3:E3')->applyFromArray($mindafont);

		$sheet->setCellValue('A4', 'Document Date');
		$sheet->setCellValue('B4', date('F d, Y', strtotime($data[0]->doc_receive)));
		//$sheet->setCellValue('D1', 'Briefer #');
		//$sheet->setCellValue('E1', " ".$data[0]->briefer_number);
		$sheet->setCellValue('A5', 'Barcode');
		$sheet->setCellValue('B5', " ".$data[0]->barcode);
		$sheet->setCellValue('D4', 'Office/Division');
		$sheet->setCellValue('E4', $data[0]->agency);
		$sheet->setCellValue('A6', 'File Type');
		$sheet->setCellValue('B6', $data[0]->type);
		$sheet->setCellValue('D5', 'Signatory');
		$sheet->setCellValue('E5', $data[0]->signatory);
		$sheet->setCellValue('A7', 'Document Category/Type');
		$sheet->setCellValue('B7', $data[0]->doctitle);
		$sheet->setCellValue('A8', 'Description');
		$sheet->setCellValue('B8', $data[0]->description);

		$sheet->getStyle('B4:B8')->applyFromArray($unitfont);
		$sheet->getStyle('E4:E8')->applyFromArray($unitfont);

		$sheet->setCellValue('A9', 'Forwarded to');
		$sheet->setCellValue('B9', 'Date Forwarded');
		$sheet->setCellValue('C9', 'Status');
		$sheet->setCellValue('D9', 'No. of Days');
		$sheet->setCellValue('E9', 'Action');

		$sheet->getStyle('A9:E9')->applyFromArray($headtitlefont);
		$sheet->getStyle('A9:E9')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('A9:E9')->getAlignment()->setVertical('center');
		$sheet->getStyle('A9:E9')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('3b5998');

		$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

		$row = 10;

		if($data->count()>0)
		{
	        foreach($data as $d)
	        {
	        	$sheet->setCellValue('A'.$row, $d->destination);
	            $sheet->setCellValue('B'.$row, $d->date_forwared);
	            $sheet->setCellValue('C'.$row, $d->stat);
	            $sheet->setCellValue('D'.$row, $d->days_count);
	            $rem = $d->remarks;
	            $finalRemarks = Str::replaceArray('<br>', [''], $rem);
	            $sheet->setCellValue('E'.$row, $finalRemarks);
	            $sheet->getStyle('E'.$row)->getAlignment()->setWrapText(true);
	            $sheet->getStyle('A'.$row.':E'.$row)->getAlignment()->setVertical('center');
	            $row++;
	        }
    	}

    	$sheet->setCellValue('A'.$row+1, 'Note: Attachment should be downloaded separately.');

    	/*
		$protect = Str::random(10);

		$sheet->getProtection()->setSheet(true);
		$sheet->getProtection()->setSort(true);
		$sheet->getProtection()->setInsertRows(true);
		$sheet->getProtection()->setFormatCells(true);

		$sheet->getProtection()->setPassword($protect);
		*/

		$writer = new Xlsx($spreadsheet);
		$writer->save($data[0]->barcode.'-External.xlsx');

		$filename=$data[0]->barcode."-External.xlsx";
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
		$spreadsheet = $reader->load("$filename");

		return redirect('/'.$filename);
    }

    public function excel_outgoing($id)
    {
    	$unitfont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => '000000'),
		        'size'  => 11,
		        'name'  => 'Calibri'
		    ));

    	$headtitlefont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => 'ffffff'),
		        'size'  => 11,
		        'name'  => 'Calibri'
		    ));

    	$rpfont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => '000000'),
		        'size'  => 11,
		        'name'  => 'Calibri'
		    ));

    	$mindafont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => '000000'),
		        'size'  => 16,
		        'name'  => 'Calibri'
		    ));

    	$data = DB::table('outgoing_history')
                    ->join('outgoings','outgoing_history.ref_id','=','outgoings.id')
                    ->where(['outgoings.id'=>$id])
                    //->groupBy('internals.barcode')
                    ->orderBy('outgoing_history.id','desc')
                    ->get();
        $datefilter = DB::table('outgoings')
                        ->groupBy('outgoings.doc_receive')
                        ->orderBy('outgoings.id','asc')
                        ->get();

        $papcode = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('division','asc')
                    ->get();

        $uname = Auth::user()->f_name;

        $docimages = DB::table('outgoing_files')
                    ->where(['outgoing_files.ref_id'=>$id])
                    ->orderBy('outgoing_files.id','asc')
                    ->get();

        $lib = DB::table('library')
                    ->orderBy('library.id','asc')
                    ->get();

        $div = DB::table('users')
                    ->groupBy('users.division')
                    ->orderBy('users.division', 'asc')
                    ->get();

        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet = $spreadsheet->getActiveSheet()->setTitle($data[0]->barcode);

		$sheet->getColumnDimension('A')->setAutoSize(false);
		$sheet->getColumnDimension('A')->setWidth(45.67);
		$sheet->getColumnDimension('B')->setAutoSize(false);
		$sheet->getColumnDimension('B')->setWidth(28);
		$sheet->getColumnDimension('C')->setAutoSize(false);
		$sheet->getColumnDimension('C')->setWidth(14.44);
		$sheet->getColumnDimension('D')->setAutoSize(false);
		$sheet->getColumnDimension('D')->setWidth(15.22);
		$sheet->getColumnDimension('E')->setAutoSize(false);
		$sheet->getColumnDimension('E')->setWidth(26.11);

		$sheet->getRowDimension('1')->setRowHeight(24.60);
		$sheet->getRowDimension('2')->setRowHeight(24.60);
		$sheet->getRowDimension('3')->setRowHeight(24.60);
		$sheet->getRowDimension('4')->setRowHeight(24.60);
		$sheet->getRowDimension('5')->setRowHeight(24.60);
		$sheet->getRowDimension('6')->setRowHeight(26.60);

		$sheet->getStyle('A1:E5')->getAlignment()->setVertical('center');

		$sheet->setCellValue('A1','Republic of the Philippines');
		$sheet->setCellValue('A2','Office of the President');
		$sheet->setCellValue('A3','Mindanao Development Authority');

		$sheet->mergeCells('A1:E1');
		$sheet->mergeCells('A2:E2');
		$sheet->mergeCells('A3:E3');
		$sheet->getStyle('A1:E3')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('A1:E2')->applyFromArray($rpfont);
		$sheet->getStyle('A3:E3')->applyFromArray($mindafont);

		$sheet->setCellValue('A4', 'Document Date');
		$sheet->setCellValue('B4', date('F d, Y', strtotime($data[0]->doc_receive)));
		$sheet->setCellValue('D4', 'Briefer #');
		$sheet->setCellValue('E4', " ".$data[0]->briefer_number);
		$sheet->setCellValue('A5', 'Barcode');
		$sheet->setCellValue('B5', " ".$data[0]->barcode);
		$sheet->setCellValue('D5', 'Office/Division');
		$sheet->setCellValue('E5', $data[0]->agency);
		$sheet->setCellValue('A6', 'File Type');
		$sheet->setCellValue('B6', $data[0]->type);
		$sheet->setCellValue('D6', 'Signatory');
		$sheet->setCellValue('E6', $data[0]->signatory);
		$sheet->setCellValue('A7', 'Document Category/Type');
		$sheet->setCellValue('B7', $data[0]->doctitle);
		$sheet->setCellValue('A8', 'Description');
		$sheet->setCellValue('B8', $data[0]->description);

		$sheet->getStyle('B4:B8')->applyFromArray($unitfont);
		$sheet->getStyle('E4:E8')->applyFromArray($unitfont);

		$sheet->setCellValue('A9', 'Forwarded to');
		$sheet->setCellValue('B9', 'Date Forwarded');
		$sheet->setCellValue('C9', 'Status');
		$sheet->setCellValue('D9', 'No. of Days');
		$sheet->setCellValue('E9', 'Action');

		$sheet->getStyle('A9:E9')->applyFromArray($headtitlefont);
		$sheet->getStyle('A9:E9')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('A9:E9')->getAlignment()->setVertical('center');
		$sheet->getStyle('A9:E9')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('3b5998');

		$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

		$row = 7;

		if($data->count()>0)
		{
	        foreach($data as $d)
	        {
	        	$sheet->setCellValue('A'.$row, $d->destination);
	            $sheet->setCellValue('B'.$row, $d->date_forwared);
	            $sheet->setCellValue('C'.$row, $d->stat);
	            $sheet->setCellValue('D'.$row, $d->days_count);
	            $rem = $d->remarks;
	            $finalRemarks = Str::replaceArray('<br>', [''], $rem);
	            $sheet->setCellValue('E'.$row, $finalRemarks);
	            $sheet->getStyle('E'.$row)->getAlignment()->setWrapText(true);
	            $sheet->getStyle('A'.$row.':E'.$row)->getAlignment()->setVertical('center');
	            $row++;
	        }
    	}

    	$sheet->setCellValue('A'.$row+1, 'Note: Attachment should be downloaded separately.');

    	/*
		$protect = Str::random(10);

		$sheet->getProtection()->setSheet(true);
		$sheet->getProtection()->setSort(true);
		$sheet->getProtection()->setInsertRows(true);
		$sheet->getProtection()->setFormatCells(true);

		$sheet->getProtection()->setPassword($protect);
		*/

		$writer = new Xlsx($spreadsheet);
		$writer->save($data[0]->barcode.'-Outgoing.xlsx');

		$filename=$data[0]->barcode."-Outgoing.xlsx";
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
		$spreadsheet = $reader->load("$filename");

		return redirect('/'.$filename);
    }

    public function export_internal_all()
    {

    	$unitfont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => '000000'),
		        'size'  => 12,
		        'name'  => 'Calibri'
		    ));

    	$headtitlefont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => 'ffffff'),
		        'size'  => 11,
		        'name'  => 'Calibri'
		    ));

    	$rpfont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => '000000'),
		        'size'  => 11,
		        'name'  => 'Calibri'
		    ));

    	$mindafont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => '000000'),
		        'size'  => 16,
		        'name'  => 'Calibri'
		    ));

    	$borderThin = array(
			    'borders' => array(
			        'outline' => array(
			            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			            'color' => array('argb' => '000000'),
			        ),
			    ),
			);
    	
         $data = DB::table('internals')
         			->orderBy('internals.id','desc')
         			->get();

        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet = $spreadsheet->getActiveSheet()->setTitle('Internal Records');

		$sheet->getColumnDimension('A')->setAutoSize(false);
		$sheet->getColumnDimension('A')->setWidth(3);
		$sheet->getColumnDimension('B')->setAutoSize(false);
		$sheet->getColumnDimension('B')->setWidth(16.22);
		$sheet->getColumnDimension('C')->setAutoSize(false);
		$sheet->getColumnDimension('C')->setWidth(16.22);
		$sheet->getColumnDimension('D')->setAutoSize(false);
		$sheet->getColumnDimension('D')->setWidth(18.22);
		$sheet->getColumnDimension('E')->setAutoSize(false);
		$sheet->getColumnDimension('E')->setWidth(13.22);
		$sheet->getColumnDimension('F')->setAutoSize(false);
		$sheet->getColumnDimension('F')->setWidth(17.22);
		$sheet->getColumnDimension('G')->setAutoSize(false);
		$sheet->getColumnDimension('G')->setWidth(18.56);
		$sheet->getColumnDimension('H')->setAutoSize(false);
		$sheet->getColumnDimension('H')->setWidth(35.22);
		$sheet->getColumnDimension('I')->setAutoSize(false);
		$sheet->getColumnDimension('I')->setWidth(20.78);
		$sheet->getColumnDimension('J')->setAutoSize(false);
		$sheet->getColumnDimension('J')->setWidth(17);
		$sheet->getColumnDimension('K')->setAutoSize(false);
		$sheet->getColumnDimension('K')->setWidth(12.33);
		$sheet->getColumnDimension('L')->setAutoSize(false);
		$sheet->getColumnDimension('L')->setWidth(8.11);
		$sheet->getColumnDimension('M')->setAutoSize(false);
		$sheet->getColumnDimension('M')->setWidth(36.22);

		$sheet->setCellValue('A1','Republic of the Philippines');
		$sheet->setCellValue('A2','Office of the President');
		$sheet->setCellValue('A3','Mindanao Development Authority');

		$sheet->mergeCells('A1:M1');
		$sheet->mergeCells('A2:M2');
		$sheet->mergeCells('A3:M3');
		$sheet->getStyle('A1:M3')->getAlignment()->setHorizontal('center');

		$sheet->getStyle('A1:M1')->applyFromArray($mindafont);
		$sheet->getStyle('A2:M3')->applyFromArray($unitfont);

		$sheet->setCellValue('A4','INTERNAL DOCUMENTS');
		$sheet->getStyle('A4')->applyFromArray($unitfont);

		$sheet->setCellValue('A5','#');
		$sheet->setCellValue('B5','Document Date');
		$sheet->setCellValue('C5','Briefer #');
		$sheet->setCellValue('D5','Barcode');
		$sheet->setCellValue('E5','Office/Division');
		$sheet->setCellValue('F5','Signatory');
		$sheet->setCellValue('G5','Document Category');
		$sheet->setCellValue('H5','Description');
		$sheet->setCellValue('I5','Forwarded To');
		$sheet->setCellValue('J5','Date Forwarded');
		$sheet->setCellValue('K5','Status');
		$sheet->setCellValue('L5','# of Days');
		$sheet->setCellValue('M5','Action Taken');

		$sheet->getStyle('A5:M5')->applyFromArray($rpfont);

		$row = 6;
		$s = 1;

		if($data->count()>0)
		{

			foreach ($data as $d) 
			{
				$b_id = $d->id;

				$sheet->setCellValue('A'.$row, $s);
				$sheet->setCellValue('B'.$row, date('m-d-Y', strtotime($d->doc_receive)));
	            $sheet->setCellValue('C'.$row, $d->briefer_number);
	            $sheet->setCellValue('D'.$row, $d->barcode);
	            $sheet->setCellValue('E'.$row, $d->agency);
	            $sheet->setCellValue('F'.$row, $d->signatory);
	            $sheet->setCellValue('G'.$row, $d->doctitle);
	            $sheet->setCellValue('H'.$row, $d->description);
	            $sheet->getStyle('H'.$row)->getAlignment()->setWrapText(true);

	            $sheet->getStyle('A'.$row.':H'.$row)->getAlignment()->setVertical('top');

	            $history = DB::table('internal_history')
	            			->where(['internal_history.ref_id'=>$b_id])
	            			->orderBy('internal_history.id','desc')
	            			->get();

	            		if($history->count()>0)
	            		{
	            			foreach ($history as $h) {
	            				$rem = $h->remarks;

	            				$rep = str_replace('<br>', "\r\n", $rem);

	            				 $sheet->setCellValue('I'.$row, $h->destination);
	            				 $sheet->setCellValue('J'.$row, $h->date_forwared);
	            				 $sheet->setCellValue('K'.$row, $h->stat);
	            				 $sheet->setCellValue('L'.$row, $h->days_count);
	            				 $sheet->setCellValue('M'.$row, $rep);
	            				 $sheet->getStyle('I'.$row)->getAlignment()->setWrapText(true);
	            				 $sheet->getStyle('J'.$row)->getAlignment()->setWrapText(true);
	            				 $sheet->getStyle('M'.$row)->getAlignment()->setWrapText(true);

	            				 $sheet->getStyle('I'.$row.':M'.$row)->getAlignment()->setVertical('top');

	            				 $row++;
	            			}
	            		}
	            $row=$row-1;


	            $sheet->getStyle('A'.$row.':M'.$row)->applyFromArray($borderThin);
	            $s++;
	            $row++;
			}
		}

		$writer = new Xlsx($spreadsheet);
		$writer->save('Internal-'.Carbon::now()->format('m-d-Y').'.xlsx');

		$filename="Internal-".Carbon::now()->format('m-d-Y').".xlsx";
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
		$spreadsheet = $reader->load("$filename");

		return redirect('/'.$filename);


    }

    public function export_external_all()
    {

    	$unitfont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => '000000'),
		        'size'  => 12,
		        'name'  => 'Calibri'
		    ));

    	$headtitlefont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => 'ffffff'),
		        'size'  => 11,
		        'name'  => 'Calibri'
		    ));

    	$rpfont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => '000000'),
		        'size'  => 11,
		        'name'  => 'Calibri'
		    ));

    	$mindafont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => '000000'),
		        'size'  => 16,
		        'name'  => 'Calibri'
		    ));

    	$borderThin = array(
			    'borders' => array(
			        'outline' => array(
			            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			            'color' => array('argb' => '000000'),
			        ),
			    ),
			);
    	
         $data = DB::table('externals')
         			->orderBy('externals.id','desc')
         			->get();

        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet = $spreadsheet->getActiveSheet()->setTitle('External Records');

		$sheet->getColumnDimension('A')->setAutoSize(false);
		$sheet->getColumnDimension('A')->setWidth(3);
		$sheet->getColumnDimension('B')->setAutoSize(false);
		$sheet->getColumnDimension('B')->setWidth(16.22);
		$sheet->getColumnDimension('C')->setAutoSize(false);
		$sheet->getColumnDimension('C')->setWidth(16.22);
		$sheet->getColumnDimension('D')->setAutoSize(false);
		$sheet->getColumnDimension('D')->setWidth(18.22);
		$sheet->getColumnDimension('E')->setAutoSize(false);
		$sheet->getColumnDimension('E')->setWidth(13.22);
		$sheet->getColumnDimension('F')->setAutoSize(false);
		$sheet->getColumnDimension('F')->setWidth(17.22);
		$sheet->getColumnDimension('G')->setAutoSize(false);
		$sheet->getColumnDimension('G')->setWidth(18.56);
		$sheet->getColumnDimension('H')->setAutoSize(false);
		$sheet->getColumnDimension('H')->setWidth(35.22);
		$sheet->getColumnDimension('I')->setAutoSize(false);
		$sheet->getColumnDimension('I')->setWidth(20.78);
		$sheet->getColumnDimension('J')->setAutoSize(false);
		$sheet->getColumnDimension('J')->setWidth(17);
		$sheet->getColumnDimension('K')->setAutoSize(false);
		$sheet->getColumnDimension('K')->setWidth(12.33);
		$sheet->getColumnDimension('L')->setAutoSize(false);
		$sheet->getColumnDimension('L')->setWidth(8.11);
		$sheet->getColumnDimension('M')->setAutoSize(false);
		$sheet->getColumnDimension('M')->setWidth(36.22);

		$sheet->setCellValue('A1','Republic of the Philippines');
		$sheet->setCellValue('A2','Office of the President');
		$sheet->setCellValue('A3','Mindanao Development Authority');

		$sheet->mergeCells('A1:M1');
		$sheet->mergeCells('A2:M2');
		$sheet->mergeCells('A3:M3');
		$sheet->getStyle('A1:M3')->getAlignment()->setHorizontal('center');

		$sheet->getStyle('A1:M1')->applyFromArray($mindafont);
		$sheet->getStyle('A2:M3')->applyFromArray($unitfont);

		$sheet->setCellValue('A4','EXTERNAL DOCUMENTS');
		$sheet->getStyle('A4')->applyFromArray($unitfont);

		$sheet->setCellValue('A5','#');
		$sheet->setCellValue('B5','Document Date');
		$sheet->setCellValue('C5','Briefer #');
		$sheet->setCellValue('D5','Barcode');
		$sheet->setCellValue('E5','Office/Division');
		$sheet->setCellValue('F5','Signatory');
		$sheet->setCellValue('G5','Document Category');
		$sheet->setCellValue('H5','Description');
		$sheet->setCellValue('I5','Forwarded To');
		$sheet->setCellValue('J5','Date Forwarded');
		$sheet->setCellValue('K5','Status');
		$sheet->setCellValue('L5','# of Days');
		$sheet->setCellValue('M5','Action Taken');

		$sheet->getStyle('A5:M5')->applyFromArray($rpfont);

		$row = 6;
		$s = 1;

		if($data->count()>0)
		{

			foreach ($data as $d) 
			{
				$b_id = $d->id;

				$sheet->setCellValue('A'.$row, $s);
				$sheet->setCellValue('B'.$row, date('m-d-Y', strtotime($d->doc_receive)));
	            $sheet->setCellValue('C'.$row, $d->briefer_number);
	            $sheet->setCellValue('D'.$row, $d->barcode);
	            $sheet->setCellValue('E'.$row, $d->agency);
	            $sheet->setCellValue('F'.$row, $d->signatory);
	            $sheet->setCellValue('G'.$row, $d->doctitle);
	            $sheet->setCellValue('H'.$row, $d->description);
	            $sheet->getStyle('H'.$row)->getAlignment()->setWrapText(true);

	            $sheet->getStyle('A'.$row.':H'.$row)->getAlignment()->setVertical('top');

	            $history = DB::table('external_history')
	            			->where(['external_history.ref_id'=>$b_id])
	            			->orderBy('external_history.id','desc')
	            			->get();

	            		if($history->count()>0)
	            		{
	            			foreach ($history as $h) {
	            				$rem = $h->remarks;

	            				$rep = str_replace('<br>', "\r\n", $rem);

	            				 $sheet->setCellValue('I'.$row, $h->destination);
	            				 $sheet->setCellValue('J'.$row, $h->date_forwared);
	            				 $sheet->setCellValue('K'.$row, $h->stat);
	            				 $sheet->setCellValue('L'.$row, $h->days_count);
	            				 $sheet->setCellValue('M'.$row, $rep);
	            				 $sheet->getStyle('I'.$row)->getAlignment()->setWrapText(true);
	            				 $sheet->getStyle('J'.$row)->getAlignment()->setWrapText(true);
	            				 $sheet->getStyle('M'.$row)->getAlignment()->setWrapText(true);

	            				 $sheet->getStyle('I'.$row.':M'.$row)->getAlignment()->setVertical('top');

	            				 $row++;
	            			}
	            		}
	            $row=$row-1;


	            $sheet->getStyle('A'.$row.':M'.$row)->applyFromArray($borderThin);
	            $s++;
	            $row++;
			}
		}

		$writer = new Xlsx($spreadsheet);
		$writer->save('External-'.Carbon::now()->format('m-d-Y').'.xlsx');

		$filename="External-".Carbon::now()->format('m-d-Y').".xlsx";
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
		$spreadsheet = $reader->load("$filename");

		return redirect('/'.$filename);


    }

    public function export_outgoing_all()
    {

    	$unitfont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => '000000'),
		        'size'  => 12,
		        'name'  => 'Calibri'
		    ));

    	$headtitlefont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => 'ffffff'),
		        'size'  => 11,
		        'name'  => 'Calibri'
		    ));

    	$rpfont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => '000000'),
		        'size'  => 11,
		        'name'  => 'Calibri'
		    ));

    	$mindafont = array(
		    'font'  	=> array(
		        'bold'  => true,
		        'color' => array('rgb' => '000000'),
		        'size'  => 16,
		        'name'  => 'Calibri'
		    ));

    	$borderThin = array(
			    'borders' => array(
			        'outline' => array(
			            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			            'color' => array('argb' => '000000'),
			        ),
			    ),
			);
    	
         $data = DB::table('outgoings')
         			->orderBy('outgoings.id','desc')
         			->get();

        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet = $spreadsheet->getActiveSheet()->setTitle('Outgoing Records');

		$sheet->getColumnDimension('A')->setAutoSize(false);
		$sheet->getColumnDimension('A')->setWidth(3);
		$sheet->getColumnDimension('B')->setAutoSize(false);
		$sheet->getColumnDimension('B')->setWidth(16.22);
		$sheet->getColumnDimension('C')->setAutoSize(false);
		$sheet->getColumnDimension('C')->setWidth(16.22);
		$sheet->getColumnDimension('D')->setAutoSize(false);
		$sheet->getColumnDimension('D')->setWidth(18.22);
		$sheet->getColumnDimension('E')->setAutoSize(false);
		$sheet->getColumnDimension('E')->setWidth(13.22);
		$sheet->getColumnDimension('F')->setAutoSize(false);
		$sheet->getColumnDimension('F')->setWidth(17.22);
		$sheet->getColumnDimension('G')->setAutoSize(false);
		$sheet->getColumnDimension('G')->setWidth(18.56);
		$sheet->getColumnDimension('H')->setAutoSize(false);
		$sheet->getColumnDimension('H')->setWidth(35.22);
		$sheet->getColumnDimension('I')->setAutoSize(false);
		$sheet->getColumnDimension('I')->setWidth(20.78);
		$sheet->getColumnDimension('J')->setAutoSize(false);
		$sheet->getColumnDimension('J')->setWidth(17);
		$sheet->getColumnDimension('K')->setAutoSize(false);
		$sheet->getColumnDimension('K')->setWidth(12.33);
		$sheet->getColumnDimension('L')->setAutoSize(false);
		$sheet->getColumnDimension('L')->setWidth(8.11);
		$sheet->getColumnDimension('M')->setAutoSize(false);
		$sheet->getColumnDimension('M')->setWidth(36.22);

		$sheet->setCellValue('A1','Republic of the Philippines');
		$sheet->setCellValue('A2','Office of the President');
		$sheet->setCellValue('A3','Mindanao Development Authority');

		$sheet->mergeCells('A1:M1');
		$sheet->mergeCells('A2:M2');
		$sheet->mergeCells('A3:M3');
		$sheet->getStyle('A1:M3')->getAlignment()->setHorizontal('center');

		$sheet->getStyle('A1:M1')->applyFromArray($mindafont);
		$sheet->getStyle('A2:M3')->applyFromArray($unitfont);

		$sheet->setCellValue('A4','EXTERNAL DOCUMENTS');
		$sheet->getStyle('A4')->applyFromArray($unitfont);

		$sheet->setCellValue('A5','#');
		$sheet->setCellValue('B5','Document Date');
		$sheet->setCellValue('C5','Briefer #');
		$sheet->setCellValue('D5','Barcode');
		$sheet->setCellValue('E5','Sender');
		$sheet->setCellValue('F5','Addressee');
		$sheet->setCellValue('G5','Mode of Release');
		$sheet->setCellValue('H5','Description');
		$sheet->setCellValue('I5','Forwarded To');
		$sheet->setCellValue('J5','Date Forwarded');
		$sheet->setCellValue('K5','Status');
		$sheet->setCellValue('L5','# of Days');
		$sheet->setCellValue('M5','Action Taken');

		$sheet->getStyle('A5:M5')->applyFromArray($rpfont);

		$row = 6;
		$s = 1;

		if($data->count()>0)
		{

			foreach ($data as $d) 
			{
				$b_id = $d->id;

				$sheet->setCellValue('A'.$row, $s);
				$sheet->setCellValue('B'.$row, date('m-d-Y', strtotime($d->doc_receive)));
	            $sheet->setCellValue('C'.$row, $d->briefer_number);
	            $sheet->setCellValue('D'.$row, $d->barcode);
	            $sheet->setCellValue('E'.$row, $d->agency);
	            $sheet->setCellValue('F'.$row, $d->signatory);
	            $sheet->setCellValue('G'.$row, $d->releasemode);
	            $sheet->setCellValue('H'.$row, $d->description);
	            $sheet->getStyle('H'.$row)->getAlignment()->setWrapText(true);

	            $sheet->getStyle('A'.$row.':H'.$row)->getAlignment()->setVertical('top');

	            $history = DB::table('outgoing_history')
	            			->where(['outgoing_history.ref_id'=>$b_id])
	            			->orderBy('outgoing_history.id','desc')
	            			->get();

	            		if($history->count()>0)
	            		{
	            			foreach ($history as $h) {
	            				$rem = $h->remarks;

	            				$rep = str_replace('<br>', "\r\n", $rem);

	            				 $sheet->setCellValue('I'.$row, $h->destination);
	            				 $sheet->setCellValue('J'.$row, $h->date_forwared);
	            				 $sheet->setCellValue('K'.$row, $h->stat);
	            				 $sheet->setCellValue('L'.$row, $h->days_count);
	            				 $sheet->setCellValue('M'.$row, $rep);
	            				 $sheet->getStyle('I'.$row)->getAlignment()->setWrapText(true);
	            				 $sheet->getStyle('J'.$row)->getAlignment()->setWrapText(true);
	            				 $sheet->getStyle('M'.$row)->getAlignment()->setWrapText(true);

	            				 $sheet->getStyle('I'.$row.':M'.$row)->getAlignment()->setVertical('top');

	            				 $row++;
	            			}
	            		}
	            $row=$row-1;


	            $sheet->getStyle('A'.$row.':M'.$row)->applyFromArray($borderThin);
	            $s++;
	            $row++;
			}
		}

		$writer = new Xlsx($spreadsheet);
		$writer->save('External-'.Carbon::now()->format('m-d-Y').'.xlsx');

		$filename="External-".Carbon::now()->format('m-d-Y').".xlsx";
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
		$spreadsheet = $reader->load("$filename");

		return redirect('/'.$filename);


    }

    public function export_internal_range($s,$e)
    {
    	if(request()->ajax())
    	{
    		$sdate    	= (new DateTime(Carbon::parse($s)->format('Y-m-d')))->modify('first day of this month');
			$edate      = (new DateTime(Carbon::parse($e)->format('Y-m-d')))->modify('last day of this month');
			$interval 	= DateInterval::createFromDateString('1 month');
			$period   	= new DatePeriod($sdate, $interval, $edate); 

    		$result="";

    		if($sdate > $edate){
    			$result = 'End Date is lower than start date';
    		}else{
    			if($edate > $sdate){
    				//$result = 'Not Equal';
					$to = Carbon::createFromFormat('Y-m-d', $s);
					$from = Carbon::createFromFormat('Y-m-d', $e);
					$Months = $to->diffInMonths($from);

					$unitfont = array(
					    'font'  	=> array(
					        'bold'  => true,
					        'color' => array('rgb' => '000000'),
					        'size'  => 12,
					        'name'  => 'Calibri'
						    ));

				    	$headtitlefont = array(
						    'font'  	=> array(
						        'bold'  => true,
						        'color' => array('rgb' => 'ffffff'),
						        'size'  => 11,
						        'name'  => 'Calibri'
						    ));

				    	$rpfont = array(
						    'font'  	=> array(
						        'bold'  => true,
						        'color' => array('rgb' => '000000'),
						        'size'  => 11,
						        'name'  => 'Calibri'
						    ));

				    	$mindafont = array(
						    'font'  	=> array(
						        'bold'  => true,
						        'color' => array('rgb' => '000000'),
						        'size'  => 16,
						        'name'  => 'Calibri'
						    ));

				    	$borderThin = array(
							    'borders' => array(
							        'outline' => array(
							            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							            'color' => array('argb' => '000000'),
							        ),
							    ),
							);
			    		

			    		$spreadsheet = new Spreadsheet();
						$sheet = $spreadsheet->getActiveSheet();
						$sheet = $spreadsheet->getActiveSheet()->setTitle('Record Summary');

						$sheet->getColumnDimension('A')->setAutoSize(false);
						$sheet->getColumnDimension('A')->setWidth(3);
						$sheet->getColumnDimension('B')->setAutoSize(false);
						$sheet->getColumnDimension('B')->setWidth(16.22);
						$sheet->getColumnDimension('C')->setAutoSize(false);
						$sheet->getColumnDimension('C')->setWidth(16.22);
						$sheet->getColumnDimension('D')->setAutoSize(false);
						$sheet->getColumnDimension('D')->setWidth(18.22);
						$sheet->getColumnDimension('E')->setAutoSize(false);
						$sheet->getColumnDimension('E')->setWidth(13.22);
						$sheet->getColumnDimension('F')->setAutoSize(false);
						$sheet->getColumnDimension('F')->setWidth(17.22);
						$sheet->getColumnDimension('G')->setAutoSize(false);
						$sheet->getColumnDimension('G')->setWidth(35.22);
						$sheet->getColumnDimension('H')->setAutoSize(false);
						$sheet->getColumnDimension('H')->setWidth(20.78);
						$sheet->getColumnDimension('I')->setAutoSize(false);
						$sheet->getColumnDimension('I')->setWidth(17);
						$sheet->getColumnDimension('J')->setAutoSize(false);
						$sheet->getColumnDimension('J')->setWidth(12.33);
						$sheet->getColumnDimension('K')->setAutoSize(false);
						$sheet->getColumnDimension('K')->setWidth(8.11);
						$sheet->getColumnDimension('L')->setAutoSize(false);
						$sheet->getColumnDimension('L')->setWidth(36.22);

						$sheet->setCellValue('A1','Republic of the Philippines');
						$sheet->setCellValue('A2','Office of the President');
						$sheet->setCellValue('A3','Mindanao Development Authority');

						$sheet->mergeCells('A1:M1');
						$sheet->mergeCells('A2:M2');
						$sheet->mergeCells('A3:M3');
						$sheet->getStyle('A1:M3')->getAlignment()->setHorizontal('center');

						$sheet->getStyle('A1:M1')->applyFromArray($mindafont);
						$sheet->getStyle('A2:M3')->applyFromArray($unitfont);

						$sheet->setCellValue('A4','INTERNAL RECORDS');
						$sheet->getStyle('A4')->applyFromArray($unitfont);

						$sheet->setCellValue('A5','#');
						$sheet->setCellValue('B5','Document Date');
						$sheet->setCellValue('C5','Briefer #');
						$sheet->setCellValue('D5','Barcode');
						$sheet->setCellValue('E5','Office/Division');
						$sheet->setCellValue('F5','Signatory');
						$sheet->setCellValue('G5','Description');
						$sheet->setCellValue('H5','Forwarded To');
						$sheet->setCellValue('I5','Date Forwarded');
						$sheet->setCellValue('J5','Status');
						$sheet->setCellValue('K5','# of Days');
						$sheet->setCellValue('L5','Action Taken');

						$sheet->getStyle('A5:M5')->applyFromArray($rpfont);

						$row = 6;
						$brow = 6;
						$s = 1;

					
					foreach ($period as $dt) {

						
						$year = Carbon::parse($dt)->year;
						$month = Carbon::parse($dt)->month;	

						$data = DB::table('internals')
				                ->join('internal_departments','internals.id','=','internal_departments.ff_id')
				                ->join('internal_history','internals.id','=','internal_history.ref_id')
								->whereYear('internals.doc_receive','=',$year)
								->whereMonth('internals.doc_receive','=',$month)
								->groupBy('internals.barcode')
			         			->get();

			         	foreach ($data as $d) 
							{

								if(!$data->isEmpty()){
							         	$b_id = $d->ref_id;

										$sheet->setCellValue('A'.$row, $s);
										$sheet->setCellValue('B'.$row, date('m-d-Y', strtotime($d->doc_receive)));
							            $sheet->setCellValue('C'.$row, $d->briefer_number);
							            $sheet->setCellValue('D'.$row, $d->barcode);
							            $sheet->setCellValue('E'.$row, $d->agency);
							            $sheet->setCellValue('F'.$row, $d->signatory);
							            $sheet->setCellValue('G'.$row, $d->description);
							            $sheet->getStyle('G'.$row)->getAlignment()->setWrapText(true);

							            $sheet->getStyle('A'.$row.':G'.$row)->getAlignment()->setVertical('top');

							            $history = DB::table('internal_history')
							            			->where(['internal_history.ref_id'=>$b_id])
							            			->orderBy('internal_history.id','desc')
							            			->get();

							            		if($history->count()>0)
							            		{
							            			foreach ($history as $h) {
							            				$rem = $h->remarks;

							            				$rep = str_replace('<br>', "\r\n", $rem);

							            				 $sheet->setCellValue('H'.$row, $h->destination);
							            				 $sheet->setCellValue('I'.$row, $h->date_forwared);
							            				 $sheet->setCellValue('J'.$row, $h->stat);
							            				 $sheet->setCellValue('K'.$row, $h->days_count);
							            				 $sheet->setCellValue('L'.$row, $rep);
							            				 $sheet->getStyle('H'.$row)->getAlignment()->setWrapText(true);
							            				 $sheet->getStyle('I'.$row)->getAlignment()->setWrapText(true);
							            				 $sheet->getStyle('L'.$row)->getAlignment()->setWrapText(true);

							            				 $sheet->getStyle('H'.$row.':L'.$row)->getAlignment()->setVertical('top');
							            				 $sheet->getStyle('H'.$row.':L'.$row)->applyFromArray($borderThin);
							            				 $row++;
							            			}
							            		}

							            	$row=$row-1;
							            	//$brow = $brow-1;

							            	$sheet->getStyle('A6'.':L'.$row)->applyFromArray($borderThin);
							            
							            $s++;
							            $row++;
							            $brow++;
							          }
    							}
					}
					

	    		}
    		}

	    		

			$writer = new Xlsx($spreadsheet);
			$writer->save('Internal-'.Carbon::now()->format('m-d-Y').'.xlsx');

			$filename="Internal-".Carbon::now()->format('m-d-Y').".xlsx";
			$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
			$spreadsheet = $reader->load("$filename");

			//return response()->JSON(['data' => $result]);

			return response()->json([
			    'url' => $filename
			]);

    	}
    }

    public function internal_division_summary($s,$e)
    {
        if(request()->ajax())
    	{
    		$sdate    	= (new DateTime(Carbon::parse($s)->format('Y-m-d')))->modify('first day of this month');
			$edate      = (new DateTime(Carbon::parse($e)->format('Y-m-d')))->modify('last day of this month');
			$interval 	= DateInterval::createFromDateString('1 month');
			$period   	= new DatePeriod($sdate, $interval, $edate); 

    		$result="";

    		if($sdate > $edate){
    			$result = 'End Date is lower than start date';
    		}else{
    			if($edate > $sdate){

					$unitfont = array(
					    'font'  	=> array(
					        'bold'  => true,
					        'color' => array('rgb' => '000000'),
					        'size'  => 12,
					        'name'  => 'Calibri'
						    ));

				    	$headtitlefont = array(
						    'font'  	=> array(
						        'bold'  => true,
						        'color' => array('rgb' => 'ffffff'),
						        'size'  => 11,
						        'name'  => 'Calibri'
						    ));

				    	$rpfont = array(
						    'font'  	=> array(
						        'bold'  => true,
						        'color' => array('rgb' => '000000'),
						        'size'  => 11,
						        'name'  => 'Calibri'
						    ));

				    	$mindafont = array(
						    'font'  	=> array(
						        'bold'  => true,
						        'color' => array('rgb' => '000000'),
						        'size'  => 16,
						        'name'  => 'Calibri'
						    ));

				    	$borderThin = array(
							    'borders' => array(
							        'outline' => array(
							            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							            'color' => array('argb' => '000000'),
							        ),
							    ),
							);
			    		

			    		$spreadsheet = new Spreadsheet();
						$sheet = $spreadsheet->getActiveSheet();
						$sheet = $spreadsheet->getActiveSheet()->setTitle(Auth::user()->division.' Record Summary');

						$sheet->getColumnDimension('A')->setAutoSize(false);
						$sheet->getColumnDimension('A')->setWidth(3);
						$sheet->getColumnDimension('B')->setAutoSize(false);
						$sheet->getColumnDimension('B')->setWidth(16.22);
						$sheet->getColumnDimension('C')->setAutoSize(false);
						$sheet->getColumnDimension('C')->setWidth(16.22);
						$sheet->getColumnDimension('D')->setAutoSize(false);
						$sheet->getColumnDimension('D')->setWidth(18.22);
						$sheet->getColumnDimension('E')->setAutoSize(false);
						$sheet->getColumnDimension('E')->setWidth(13.22);
						$sheet->getColumnDimension('F')->setAutoSize(false);
						$sheet->getColumnDimension('F')->setWidth(17.22);
						$sheet->getColumnDimension('G')->setAutoSize(false);
						$sheet->getColumnDimension('G')->setWidth(35.22);
						$sheet->getColumnDimension('H')->setAutoSize(false);
						$sheet->getColumnDimension('H')->setWidth(20.78);
						$sheet->getColumnDimension('I')->setAutoSize(false);
						$sheet->getColumnDimension('I')->setWidth(17);
						$sheet->getColumnDimension('J')->setAutoSize(false);
						$sheet->getColumnDimension('J')->setWidth(12.33);
						$sheet->getColumnDimension('K')->setAutoSize(false);
						$sheet->getColumnDimension('K')->setWidth(8.11);
						$sheet->getColumnDimension('L')->setAutoSize(false);
						$sheet->getColumnDimension('L')->setWidth(36.22);

						$sheet->setCellValue('A1','Republic of the Philippines');
						$sheet->setCellValue('A2','Office of the President');
						$sheet->setCellValue('A3','Mindanao Development Authority');

						$sheet->mergeCells('A1:M1');
						$sheet->mergeCells('A2:M2');
						$sheet->mergeCells('A3:M3');
						$sheet->getStyle('A1:M3')->getAlignment()->setHorizontal('center');

						$sheet->getStyle('A1:M1')->applyFromArray($mindafont);
						$sheet->getStyle('A2:M3')->applyFromArray($unitfont);

						$sheet->setCellValue('A4','INTERNAL DOCUMENTS (DIVISION:'.Auth::user()->division.')');
						$sheet->getStyle('A4')->applyFromArray($unitfont);

						$sheet->setCellValue('A5','#');
						$sheet->setCellValue('B5','Document Date');
						$sheet->setCellValue('C5','Briefer #');
						$sheet->setCellValue('D5','Barcode');
						$sheet->setCellValue('E5','Office/Division');
						$sheet->setCellValue('F5','Signatory');
						$sheet->setCellValue('G5','Description');
						$sheet->setCellValue('H5','Forwarded To');
						$sheet->setCellValue('I5','Date Forwarded');
						$sheet->setCellValue('J5','Status');
						$sheet->setCellValue('K5','# of Days');
						$sheet->setCellValue('L5','Action Taken');

						$sheet->getStyle('A5:M5')->applyFromArray($rpfont);

						$row = 6;
						$brow = 6;
						$s = 1;

					
					foreach ($period as $dt) {

						
						$year = Carbon::parse($dt)->year;
						$month = Carbon::parse($dt)->month;	

						$data = DB::table('internals')
				                ->join('internal_departments','internals.id','=','internal_departments.ff_id')
				                ->join('internal_history','internals.id','=','internal_history.ref_id')
								->whereYear('internals.doc_receive','=',$year)
								->whereMonth('internals.doc_receive','=',$month)
								->where(['internal_departments.dept'=>Auth::user()->division])
								->groupBy('internals.barcode')
			         			->get();

			         	foreach ($data as $d) 
							{
								if(!$data->isEmpty())
								{
							         	$b_id = $d->ref_id;

										$sheet->setCellValue('A'.$row, $s);
										$sheet->setCellValue('B'.$row, date('m-d-Y', strtotime($d->doc_receive)));
							            $sheet->setCellValue('C'.$row, $d->briefer_number);
							            $sheet->setCellValue('D'.$row, $d->barcode);
							            $sheet->setCellValue('E'.$row, $d->agency);
							            $sheet->setCellValue('F'.$row, $d->signatory);
							            $sheet->setCellValue('G'.$row, $d->description);
							            $sheet->getStyle('G'.$row)->getAlignment()->setWrapText(true);

							            $sheet->getStyle('A'.$row.':G'.$row)->getAlignment()->setVertical('top');

							            $history = DB::table('internal_history')
							            			->where(['internal_history.ref_id'=>$b_id])
							            			->orderBy('internal_history.id','desc')
							            			->get();

							            		if($history->count()>0)
							            		{
							            			foreach ($history as $h) {
							            				$rem = $h->remarks;

							            				$rep = str_replace('<br>', "\r\n", $rem);

							            				 $sheet->setCellValue('H'.$row, $h->destination);
							            				 $sheet->setCellValue('I'.$row, $h->date_forwared);
							            				 $sheet->setCellValue('J'.$row, $h->stat);
							            				 $sheet->setCellValue('K'.$row, $h->days_count);
							            				 $sheet->setCellValue('L'.$row, $rep);
							            				 $sheet->getStyle('H'.$row)->getAlignment()->setWrapText(true);
							            				 $sheet->getStyle('I'.$row)->getAlignment()->setWrapText(true);
							            				 $sheet->getStyle('L'.$row)->getAlignment()->setWrapText(true);

							            				 $sheet->getStyle('H'.$row.':L'.$row)->getAlignment()->setVertical('top');
							            				 $sheet->getStyle('H'.$row.':L'.$row)->applyFromArray($borderThin);
							            				 $row++;
							            			}
							            		}

							            	$row=$row-1;
							            	//$brow = $brow-1;

							            	$sheet->getStyle('A6'.':L'.$row)->applyFromArray($borderThin);
							            
							            $s++;
							            $row++;
							            $brow++;
							        }
					     	}
    					
    				}
					
				}
	 
    		}

	    		

			$writer = new Xlsx($spreadsheet);
			$writer->save('Internal-'.Carbon::now()->format('m-d-Y').'.xlsx');

			$filename="Internal-".Carbon::now()->format('m-d-Y').".xlsx";
			$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
			$spreadsheet = $reader->load("$filename");

			//return response()->JSON(['data' => $result]);

			return response()->json([
			    'url' => $filename
			]);

    	}
    }


    //External Export Report

    public function export_external_range($s,$e)
    {
    	if(request()->ajax())
    	{
    		
    		$sdate    	= (new DateTime(Carbon::parse($s)->format('Y-m-d')))->modify('first day of this month');
			$edate      = (new DateTime(Carbon::parse($e)->format('Y-m-d')))->modify('last day of this month');
			$interval 	= DateInterval::createFromDateString('1 month');
			$period   	= new DatePeriod($sdate, $interval, $edate); 		

    		$result="";

    		if($sdate > $edate){
    			$result = 'End Date is lower than start date';
    		}else{
    			if($edate > $sdate){

					$unitfont = array(
					    'font'  	=> array(
					        'bold'  => true,
					        'color' => array('rgb' => '000000'),
					        'size'  => 12,
					        'name'  => 'Calibri'
						    ));

				    	$headtitlefont = array(
						    'font'  	=> array(
						        'bold'  => true,
						        'color' => array('rgb' => 'ffffff'),
						        'size'  => 11,
						        'name'  => 'Calibri'
						    ));

				    	$rpfont = array(
						    'font'  	=> array(
						        'bold'  => true,
						        'color' => array('rgb' => '000000'),
						        'size'  => 11,
						        'name'  => 'Calibri'
						    ));

				    	$mindafont = array(
						    'font'  	=> array(
						        'bold'  => true,
						        'color' => array('rgb' => '000000'),
						        'size'  => 16,
						        'name'  => 'Calibri'
						    ));

				    	$borderThin = array(
							    'borders' => array(
							        'outline' => array(
							            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							            'color' => array('argb' => '000000'),
							        ),
							    ),
							);
			    		

			    		$spreadsheet = new Spreadsheet();
						$sheet = $spreadsheet->getActiveSheet();
						$sheet = $spreadsheet->getActiveSheet()->setTitle('Record Summary');

						$sheet->getColumnDimension('A')->setAutoSize(false);
						$sheet->getColumnDimension('A')->setWidth(3);
						$sheet->getColumnDimension('B')->setAutoSize(false);
						$sheet->getColumnDimension('B')->setWidth(16.22);
						$sheet->getColumnDimension('C')->setAutoSize(false);
						$sheet->getColumnDimension('C')->setWidth(16.22);
						$sheet->getColumnDimension('D')->setAutoSize(false);
						$sheet->getColumnDimension('D')->setWidth(18.22);
						$sheet->getColumnDimension('E')->setAutoSize(false);
						$sheet->getColumnDimension('E')->setWidth(13.22);
						$sheet->getColumnDimension('F')->setAutoSize(false);
						$sheet->getColumnDimension('F')->setWidth(17.22);
						$sheet->getColumnDimension('G')->setAutoSize(false);
						$sheet->getColumnDimension('G')->setWidth(17.22);
						$sheet->getColumnDimension('H')->setAutoSize(false);
						$sheet->getColumnDimension('H')->setWidth(35.22);
						$sheet->getColumnDimension('I')->setAutoSize(false);
						$sheet->getColumnDimension('I')->setWidth(20.78);
						$sheet->getColumnDimension('J')->setAutoSize(false);
						$sheet->getColumnDimension('J')->setWidth(17);
						$sheet->getColumnDimension('K')->setAutoSize(false);
						$sheet->getColumnDimension('K')->setWidth(12.33);
						$sheet->getColumnDimension('L')->setAutoSize(false);
						$sheet->getColumnDimension('L')->setWidth(8.11);
						$sheet->getColumnDimension('M')->setAutoSize(false);
						$sheet->getColumnDimension('M')->setWidth(36.22);

						$sheet->setCellValue('A1','Republic of the Philippines');
						$sheet->setCellValue('A2','Office of the President');
						$sheet->setCellValue('A3','Mindanao Development Authority');

						$sheet->mergeCells('A1:M1');
						$sheet->mergeCells('A2:M2');
						$sheet->mergeCells('A3:M3');
						$sheet->getStyle('A1:M3')->getAlignment()->setHorizontal('center');

						$sheet->getStyle('A1:M1')->applyFromArray($mindafont);
						$sheet->getStyle('A2:M3')->applyFromArray($unitfont);

						$sheet->setCellValue('A4','EXTERNAL RECORDS');
						$sheet->getStyle('A4')->applyFromArray($unitfont);

						$sheet->setCellValue('A5','#');
						$sheet->setCellValue('B5','Document Date');
						$sheet->setCellValue('C5','Briefer #');
						$sheet->setCellValue('D5','Barcode');
						$sheet->setCellValue('E5','Office/Division');
						$sheet->setCellValue('F5','Signatory');
						$sheet->setCellValue('G5','File Type');
						$sheet->setCellValue('H5','Description');
						$sheet->setCellValue('I5','Forwarded To');
						$sheet->setCellValue('J5','Date Forwarded');
						$sheet->setCellValue('K5','Status');
						$sheet->setCellValue('L5','# of Days');
						$sheet->setCellValue('M5','Action Taken');

						$sheet->getStyle('A5:M5')->applyFromArray($rpfont);

						$row = 6;
						$brow = 6;
						$s = 1;

					
					foreach ($period as $dt) {

						$year = Carbon::parse($dt)->year;
						$month = Carbon::parse($dt)->month;	

						$data = DB::table('externals')
				               // ->join('external_departments','externals.id','=','external_departments.ff_id')
				                //->join('external_history','externals.id','=','external_history.ref_id')
				                ->orderBy('externals.id','asc')
				                ->groupBy('externals.barcode')
								->whereMonth('externals.doc_receive','=',$month)
								->whereYear('externals.doc_receive','=',$year)
			         			->get();

			         			

			         	foreach ($data as $d) 
							{
								
								if(!$data->isEmpty())
								{
						         	$b_id = $d->id;

									$sheet->setCellValue('A'.$row, $s);
									$sheet->setCellValue('B'.$row, date('m-d-Y', strtotime($d->doc_receive)));
						            $sheet->setCellValue('C'.$row, $d->briefer_number);
						            $sheet->setCellValue('D'.$row, $d->barcode);
						            $sheet->setCellValue('E'.$row, $d->agency);
						            $sheet->setCellValue('F'.$row, $d->signatory);
						            $sheet->setCellValue('G'.$row, $d->type);
						            $sheet->setCellValue('H'.$row, $d->description);
						            $sheet->getStyle('H'.$row)->getAlignment()->setWrapText(true);

						            $sheet->getStyle('A'.$row.':H'.$row)->getAlignment()->setVertical('top');

						            $history = DB::table('external_history')
						            			->where(['external_history.ref_id'=>$b_id])
						            			->orderBy('external_history.id','desc')
						            			->get();

						            		if($history->count()>0)
						            		{
						            			foreach ($history as $h) {
						            				$rem = $h->remarks;

						            				$rep = str_replace('<br>', "\r\n", $rem);

						            				 $sheet->setCellValue('I'.$row, $h->destination);
						            				 $sheet->setCellValue('J'.$row, $h->date_forwared);
						            				 $sheet->setCellValue('K'.$row, $h->stat);
						            				 $sheet->setCellValue('L'.$row, $h->days_count);
						            				 $sheet->setCellValue('M'.$row, $rep);
						            				 $sheet->getStyle('I'.$row)->getAlignment()->setWrapText(true);
						            				 $sheet->getStyle('J'.$row)->getAlignment()->setWrapText(true);
						            				 $sheet->getStyle('K'.$row)->getAlignment()->setWrapText(true);

						            				 $sheet->getStyle('I'.$row.':M'.$row)->getAlignment()->setVertical('top');
						            				 $sheet->getStyle('M'.$row.':M'.$row)->applyFromArray($borderThin);
						            				 $row++;
						            			}
						            		}

						            	$row=$row-1;
						            	//$brow = $brow-1;

						            	$sheet->getStyle('A6'.':M'.$row)->applyFromArray($borderThin);
						            
						            $s++;
						            $row++;
						            $brow++;

						            
						          }
						          
						      }

							}

	    		}
    		}

	    		

			$writer = new Xlsx($spreadsheet);
			$writer->save('External-'.Carbon::now()->format('m-d-Y').'.xlsx');

			$filename="External-".Carbon::now()->format('m-d-Y').".xlsx";
			$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
			$spreadsheet = $reader->load("$filename");

			//return response()->JSON(['data' => $result]);

			return response()->json([
			    'url' => $filename
			]);

    	}
    }

   
   public function export_external_division_range($s,$e)
    {
    	if(request()->ajax())
    	{
    		
    		$sdate    	= (new DateTime(Carbon::parse($s)->format('Y-m-d')))->modify('first day of this month');
			$edate      = (new DateTime(Carbon::parse($e)->format('Y-m-d')))->modify('last day of this month');
			$interval 	= DateInterval::createFromDateString('1 month');
			$period   	= new DatePeriod($sdate, $interval, $edate); 		

    		$result="";

    		if($sdate > $edate){
    			$result = 'End Date is lower than start date';
    		}else{
    			if($edate > $sdate){

					$unitfont = array(
					    'font'  	=> array(
					        'bold'  => true,
					        'color' => array('rgb' => '000000'),
					        'size'  => 12,
					        'name'  => 'Calibri'
						    ));

				    	$headtitlefont = array(
						    'font'  	=> array(
						        'bold'  => true,
						        'color' => array('rgb' => 'ffffff'),
						        'size'  => 11,
						        'name'  => 'Calibri'
						    ));

				    	$rpfont = array(
						    'font'  	=> array(
						        'bold'  => true,
						        'color' => array('rgb' => '000000'),
						        'size'  => 11,
						        'name'  => 'Calibri'
						    ));

				    	$mindafont = array(
						    'font'  	=> array(
						        'bold'  => true,
						        'color' => array('rgb' => '000000'),
						        'size'  => 16,
						        'name'  => 'Calibri'
						    ));

				    	$borderThin = array(
							    'borders' => array(
							        'outline' => array(
							            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							            'color' => array('argb' => '000000'),
							        ),
							    ),
							);
			    		

			    		$spreadsheet = new Spreadsheet();
						$sheet = $spreadsheet->getActiveSheet();
						$sheet = $spreadsheet->getActiveSheet()->setTitle('Record Summary');

						$sheet->getColumnDimension('A')->setAutoSize(false);
						$sheet->getColumnDimension('A')->setWidth(3);
						$sheet->getColumnDimension('B')->setAutoSize(false);
						$sheet->getColumnDimension('B')->setWidth(16.22);
						$sheet->getColumnDimension('C')->setAutoSize(false);
						$sheet->getColumnDimension('C')->setWidth(16.22);
						$sheet->getColumnDimension('D')->setAutoSize(false);
						$sheet->getColumnDimension('D')->setWidth(18.22);
						$sheet->getColumnDimension('E')->setAutoSize(false);
						$sheet->getColumnDimension('E')->setWidth(13.22);
						$sheet->getColumnDimension('F')->setAutoSize(false);
						$sheet->getColumnDimension('F')->setWidth(17.22);
						$sheet->getColumnDimension('G')->setAutoSize(false);
						$sheet->getColumnDimension('G')->setWidth(17.22);
						$sheet->getColumnDimension('H')->setAutoSize(false);
						$sheet->getColumnDimension('H')->setWidth(35.22);
						$sheet->getColumnDimension('I')->setAutoSize(false);
						$sheet->getColumnDimension('I')->setWidth(20.78);
						$sheet->getColumnDimension('J')->setAutoSize(false);
						$sheet->getColumnDimension('J')->setWidth(17);
						$sheet->getColumnDimension('K')->setAutoSize(false);
						$sheet->getColumnDimension('K')->setWidth(12.33);
						$sheet->getColumnDimension('L')->setAutoSize(false);
						$sheet->getColumnDimension('L')->setWidth(8.11);
						$sheet->getColumnDimension('M')->setAutoSize(false);
						$sheet->getColumnDimension('M')->setWidth(36.22);

						$sheet->setCellValue('A1','Republic of the Philippines');
						$sheet->setCellValue('A2','Office of the President');
						$sheet->setCellValue('A3','Mindanao Development Authority');

						$sheet->mergeCells('A1:M1');
						$sheet->mergeCells('A2:M2');
						$sheet->mergeCells('A3:M3');
						$sheet->getStyle('A1:M3')->getAlignment()->setHorizontal('center');

						$sheet->getStyle('A1:M1')->applyFromArray($mindafont);
						$sheet->getStyle('A2:M3')->applyFromArray($unitfont);

						$sheet->setCellValue('A4','EXTERNAL RECORDS (DIVISION:'.Auth::user()->division.')');
						$sheet->getStyle('A4')->applyFromArray($unitfont);

						$sheet->setCellValue('A5','#');
						$sheet->setCellValue('B5','Document Date');
						$sheet->setCellValue('C5','Briefer #');
						$sheet->setCellValue('D5','Barcode');
						$sheet->setCellValue('E5','Office/Division');
						$sheet->setCellValue('F5','Signatory');
						$sheet->setCellValue('G5','File Type');
						$sheet->setCellValue('H5','Description');
						$sheet->setCellValue('I5','Forwarded To');
						$sheet->setCellValue('J5','Date Forwarded');
						$sheet->setCellValue('K5','Status');
						$sheet->setCellValue('L5','# of Days');
						$sheet->setCellValue('M5','Action Taken');

						$sheet->getStyle('A5:M5')->applyFromArray($rpfont);

						$row = 6;
						$brow = 6;
						$s = 1;

					
					foreach ($period as $dt) {

						$year = Carbon::parse($dt)->year;
						$month = Carbon::parse($dt)->month;	

						$data = DB::table('externals')
				                ->join('external_departments','externals.id','=','external_departments.ff_id')
				                ->join('external_history','externals.id','=','external_history.ref_id')
				                ->orderBy('externals.id','asc')
				                ->groupBy('externals.barcode')
								->whereMonth('externals.doc_receive','=',$month)
								->whereYear('externals.doc_receive','=',$year)
								->where(['external_departments.dept'=>Auth::user()->division])
			         			->get();
			         			

			         	foreach ($data as $d) 
							{
								
								if(!$data->isEmpty())
								{
						         	$b_id = $d->id;

									$sheet->setCellValue('A'.$row, $s);
									$sheet->setCellValue('B'.$row, date('m-d-Y', strtotime($d->doc_receive)));
						            $sheet->setCellValue('C'.$row, $d->briefer_number);
						            $sheet->setCellValue('D'.$row, $d->barcode);
						            $sheet->setCellValue('E'.$row, $d->agency);
						            $sheet->setCellValue('F'.$row, $d->signatory);
						            $sheet->setCellValue('G'.$row, $d->type);
						            $sheet->setCellValue('H'.$row, $d->description);
						            $sheet->getStyle('H'.$row)->getAlignment()->setWrapText(true);

						            $sheet->getStyle('A'.$row.':H'.$row)->getAlignment()->setVertical('top');

						            $history = DB::table('external_history')
						            			->where(['external_history.ref_id'=>$b_id])
						            			->orderBy('external_history.id','desc')
						            			->get();

						            		if($history->count()>0)
						            		{
						            			foreach ($history as $h) {
						            				$rem = $h->remarks;

						            				$rep = str_replace('<br>', "\r\n", $rem);

						            				 $sheet->setCellValue('I'.$row, $h->destination);
						            				 $sheet->setCellValue('J'.$row, $h->date_forwared);
						            				 $sheet->setCellValue('K'.$row, $h->stat);
						            				 $sheet->setCellValue('L'.$row, $h->days_count);
						            				 $sheet->setCellValue('M'.$row, $rep);
						            				 $sheet->getStyle('I'.$row)->getAlignment()->setWrapText(true);
						            				 $sheet->getStyle('J'.$row)->getAlignment()->setWrapText(true);
						            				 $sheet->getStyle('K'.$row)->getAlignment()->setWrapText(true);

						            				 $sheet->getStyle('I'.$row.':M'.$row)->getAlignment()->setVertical('top');
						            				 $sheet->getStyle('M'.$row.':M'.$row)->applyFromArray($borderThin);
						            				 $row++;
						            			}
						            		}

						            	$row=$row-1;
						            	//$brow = $brow-1;

						            	$sheet->getStyle('A6'.':M'.$row)->applyFromArray($borderThin);
						            
						            $s++;
						            $row++;
						            $brow++;

						            
						          }
						          
						      }

							}

	    		}
    		}

	    		

			$writer = new Xlsx($spreadsheet);
			$writer->save('External-'.Carbon::now()->format('m-d-Y').'.xlsx');

			$filename="External-".Carbon::now()->format('m-d-Y').".xlsx";
			$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
			$spreadsheet = $reader->load("$filename");

			//return response()->JSON(['data' => $result]);

			return response()->json([
			    'url' => $filename
			]);


    	}
    }

//External Export Report

    public function export_outgoing_range($s,$e)
    {
    	if(request()->ajax())
    	{
    		
    		$sdate    	= (new DateTime(Carbon::parse($s)->format('Y-m-d')))->modify('first day of this month');
			$edate      = (new DateTime(Carbon::parse($e)->format('Y-m-d')))->modify('last day of this month');
			$interval 	= DateInterval::createFromDateString('1 month');
			$period   	= new DatePeriod($sdate, $interval, $edate); 		

    		$result="";

    		if($sdate > $edate){
    			$result = 'End Date is lower than start date';
    		}else{
    			if($edate > $sdate){

					$unitfont = array(
					    'font'  	=> array(
					        'bold'  => true,
					        'color' => array('rgb' => '000000'),
					        'size'  => 12,
					        'name'  => 'Calibri'
						    ));

				    	$headtitlefont = array(
						    'font'  	=> array(
						        'bold'  => true,
						        'color' => array('rgb' => 'ffffff'),
						        'size'  => 11,
						        'name'  => 'Calibri'
						    ));

				    	$rpfont = array(
						    'font'  	=> array(
						        'bold'  => true,
						        'color' => array('rgb' => '000000'),
						        'size'  => 11,
						        'name'  => 'Calibri'
						    ));

				    	$mindafont = array(
						    'font'  	=> array(
						        'bold'  => true,
						        'color' => array('rgb' => '000000'),
						        'size'  => 16,
						        'name'  => 'Calibri'
						    ));

				    	$borderThin = array(
							    'borders' => array(
							        'outline' => array(
							            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							            'color' => array('argb' => '000000'),
							        ),
							    ),
							);
			    		

			    		$spreadsheet = new Spreadsheet();
						$sheet = $spreadsheet->getActiveSheet();
						$sheet = $spreadsheet->getActiveSheet()->setTitle('Record Summary');

						$sheet->getColumnDimension('A')->setAutoSize(false);
						$sheet->getColumnDimension('A')->setWidth(3);
						$sheet->getColumnDimension('B')->setAutoSize(false);
						$sheet->getColumnDimension('B')->setWidth(16.22);
						$sheet->getColumnDimension('C')->setAutoSize(false);
						$sheet->getColumnDimension('C')->setWidth(16.22);
						$sheet->getColumnDimension('D')->setAutoSize(false);
						$sheet->getColumnDimension('D')->setWidth(18.22);
						$sheet->getColumnDimension('E')->setAutoSize(false);
						$sheet->getColumnDimension('E')->setWidth(13.22);
						$sheet->getColumnDimension('F')->setAutoSize(false);
						$sheet->getColumnDimension('F')->setWidth(17.22);
						$sheet->getColumnDimension('G')->setAutoSize(false);
						$sheet->getColumnDimension('G')->setWidth(17.22);
						$sheet->getColumnDimension('H')->setAutoSize(false);
						$sheet->getColumnDimension('H')->setWidth(17.22);
						$sheet->getColumnDimension('I')->setAutoSize(false);
						$sheet->getColumnDimension('I')->setWidth(35.22);
						$sheet->getColumnDimension('J')->setAutoSize(false);
						$sheet->getColumnDimension('J')->setWidth(20.78);
						$sheet->getColumnDimension('K')->setAutoSize(false);
						$sheet->getColumnDimension('K')->setWidth(17);
						$sheet->getColumnDimension('L')->setAutoSize(false);
						$sheet->getColumnDimension('L')->setWidth(12.33);
						$sheet->getColumnDimension('M')->setAutoSize(false);
						$sheet->getColumnDimension('M')->setWidth(8.11);
						$sheet->getColumnDimension('N')->setAutoSize(false);
						$sheet->getColumnDimension('N')->setWidth(36.22);

						$sheet->setCellValue('A1','Republic of the Philippines');
						$sheet->setCellValue('A2','Office of the President');
						$sheet->setCellValue('A3','Mindanao Development Authority');

						$sheet->mergeCells('A1:M1');
						$sheet->mergeCells('A2:M2');
						$sheet->mergeCells('A3:M3');
						$sheet->getStyle('A1:M3')->getAlignment()->setHorizontal('center');

						$sheet->getStyle('A1:M1')->applyFromArray($mindafont);
						$sheet->getStyle('A2:M3')->applyFromArray($unitfont);

						$sheet->setCellValue('A4','OUTGOING RECORDS');
						$sheet->getStyle('A4')->applyFromArray($unitfont);

						$sheet->setCellValue('A5','#');
						$sheet->setCellValue('B5','Document Date');
						$sheet->setCellValue('C5','Briefer #');
						$sheet->setCellValue('D5','Barcode');
						$sheet->setCellValue('E5','Office/Division');
						$sheet->setCellValue('F5','Sender');
						$sheet->setCellValue('G5','From/Addressee');
						$sheet->setCellValue('H5','Receiver');
						$sheet->setCellValue('I5','Description');
						$sheet->setCellValue('J5','Forwarded To');
						$sheet->setCellValue('K5','Date Forwarded');
						$sheet->setCellValue('L5','Status');
						$sheet->setCellValue('M5','# of Days');
						$sheet->setCellValue('N5','Action Taken');

						$sheet->getStyle('A5:M5')->applyFromArray($rpfont);

						$row = 6;
						$brow = 6;
						$s = 1;

					
					foreach ($period as $dt) {

						$year = Carbon::parse($dt)->year;
						$month = Carbon::parse($dt)->month;	

						$data = DB::table('outgoings')
				               // ->join('external_departments','externals.id','=','external_departments.ff_id')
				                //->join('external_history','externals.id','=','external_history.ref_id')
				                ->orderBy('outgoings.id','asc')
				                ->groupBy('outgoings.barcode')
								->whereMonth('outgoings.doc_receive','=',$month)
								->whereYear('outgoings.doc_receive','=',$year)
			         			->get();

			         			

			         	foreach ($data as $d) 
							{
								
								if(!$data->isEmpty())
								{
						         	$b_id = $d->id;

									$sheet->setCellValue('A'.$row, $s);
									$sheet->setCellValue('B'.$row, date('m-d-Y', strtotime($d->doc_receive)));
						            $sheet->setCellValue('C'.$row, $d->briefer_number);
						            $sheet->setCellValue('D'.$row, $d->barcode);
						            $sheet->setCellValue('E'.$row, $d->agency);
						            $sheet->setCellValue('F'.$row, $d->sender);
						            $sheet->setCellValue('G'.$row, $d->signatory);
						            $sheet->setCellValue('H'.$row, $d->sendto);
						            $sheet->setCellValue('I'.$row, $d->description);
						            $sheet->getStyle('I'.$row)->getAlignment()->setWrapText(true);

						            $sheet->getStyle('A'.$row.':I'.$row)->getAlignment()->setVertical('top');

						            $history = DB::table('outgoing_history')
						            			->where(['outgoing_history.ref_id'=>$b_id])
						            			->orderBy('outgoing_history.id','desc')
						            			->get();

						            		if($history->count()>0)
						            		{
						            			foreach ($history as $h) {
						            				$rem = $h->remarks;

						            				$rep = str_replace('<br>', "\r\n", $rem);

						            				 $sheet->setCellValue('J'.$row, $h->destination);
						            				 $sheet->setCellValue('K'.$row, $h->date_forwared);
						            				 $sheet->setCellValue('L'.$row, $h->stat);
						            				 $sheet->setCellValue('M'.$row, $h->days_count);
						            				 $sheet->setCellValue('N'.$row, $rep);
						            				 $sheet->getStyle('J'.$row)->getAlignment()->setWrapText(true);
						            				 $sheet->getStyle('K'.$row)->getAlignment()->setWrapText(true);
						            				 $sheet->getStyle('L'.$row)->getAlignment()->setWrapText(true);

						            				 $sheet->getStyle('J'.$row.':N'.$row)->getAlignment()->setVertical('top');
						            				 $sheet->getStyle('N'.$row.':N'.$row)->applyFromArray($borderThin);
						            				 $row++;
						            			}
						            		}

						            	$row=$row-1;
						            	//$brow = $brow-1;

						            	$sheet->getStyle('A6'.':N'.$row)->applyFromArray($borderThin);
						            
						            $s++;
						            $row++;
						            $brow++;

						            
						          }
						          
						      }

							}

	    		}
    		}

	    		

			$writer = new Xlsx($spreadsheet);
			$writer->save('Outgoing-'.Carbon::now()->format('m-d-Y').'.xlsx');

			$filename="Outgoing-".Carbon::now()->format('m-d-Y').".xlsx";
			$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
			$spreadsheet = $reader->load("$filename");

			//return response()->JSON(['data' => $result]);

			return response()->json([
			    'url' => $filename
			]);

    	}
    }

   
   public function export_outgoing_division_range($s,$e)
    {
    	if(request()->ajax())
    	{
    		
    		$sdate    	= (new DateTime(Carbon::parse($s)->format('Y-m-d')))->modify('first day of this month');
			$edate      = (new DateTime(Carbon::parse($e)->format('Y-m-d')))->modify('last day of this month');
			$interval 	= DateInterval::createFromDateString('1 month');
			$period   	= new DatePeriod($sdate, $interval, $edate); 		

    		$result="";

    		if($sdate > $edate){
    			$result = 'End Date is lower than start date';
    		}else{
    			if($edate > $sdate){

					$unitfont = array(
					    'font'  	=> array(
					        'bold'  => true,
					        'color' => array('rgb' => '000000'),
					        'size'  => 12,
					        'name'  => 'Calibri'
						    ));

				    	$headtitlefont = array(
						    'font'  	=> array(
						        'bold'  => true,
						        'color' => array('rgb' => 'ffffff'),
						        'size'  => 11,
						        'name'  => 'Calibri'
						    ));

				    	$rpfont = array(
						    'font'  	=> array(
						        'bold'  => true,
						        'color' => array('rgb' => '000000'),
						        'size'  => 11,
						        'name'  => 'Calibri'
						    ));

				    	$mindafont = array(
						    'font'  	=> array(
						        'bold'  => true,
						        'color' => array('rgb' => '000000'),
						        'size'  => 16,
						        'name'  => 'Calibri'
						    ));

				    	$borderThin = array(
							    'borders' => array(
							        'outline' => array(
							            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							            'color' => array('argb' => '000000'),
							        ),
							    ),
							);
			    		

			    		$spreadsheet = new Spreadsheet();
						$sheet = $spreadsheet->getActiveSheet();
						$sheet = $spreadsheet->getActiveSheet()->setTitle('Record Summary');

						$sheet->getColumnDimension('A')->setAutoSize(false);
						$sheet->getColumnDimension('A')->setWidth(3);
						$sheet->getColumnDimension('B')->setAutoSize(false);
						$sheet->getColumnDimension('B')->setWidth(16.22);
						$sheet->getColumnDimension('C')->setAutoSize(false);
						$sheet->getColumnDimension('C')->setWidth(16.22);
						$sheet->getColumnDimension('D')->setAutoSize(false);
						$sheet->getColumnDimension('D')->setWidth(18.22);
						$sheet->getColumnDimension('E')->setAutoSize(false);
						$sheet->getColumnDimension('E')->setWidth(13.22);
						$sheet->getColumnDimension('F')->setAutoSize(false);
						$sheet->getColumnDimension('F')->setWidth(17.22);
						$sheet->getColumnDimension('G')->setAutoSize(false);
						$sheet->getColumnDimension('G')->setWidth(17.22);
						$sheet->getColumnDimension('H')->setAutoSize(false);
						$sheet->getColumnDimension('H')->setWidth(17.22);
						$sheet->getColumnDimension('I')->setAutoSize(false);
						$sheet->getColumnDimension('I')->setWidth(35.22);
						$sheet->getColumnDimension('J')->setAutoSize(false);
						$sheet->getColumnDimension('J')->setWidth(20.78);
						$sheet->getColumnDimension('K')->setAutoSize(false);
						$sheet->getColumnDimension('K')->setWidth(17);
						$sheet->getColumnDimension('L')->setAutoSize(false);
						$sheet->getColumnDimension('L')->setWidth(12.33);
						$sheet->getColumnDimension('M')->setAutoSize(false);
						$sheet->getColumnDimension('M')->setWidth(8.11);
						$sheet->getColumnDimension('N')->setAutoSize(false);
						$sheet->getColumnDimension('N')->setWidth(36.22);

						$sheet->setCellValue('A1','Republic of the Philippines');
						$sheet->setCellValue('A2','Office of the President');
						$sheet->setCellValue('A3','Mindanao Development Authority');

						$sheet->mergeCells('A1:M1');
						$sheet->mergeCells('A2:M2');
						$sheet->mergeCells('A3:M3');
						$sheet->getStyle('A1:M3')->getAlignment()->setHorizontal('center');

						$sheet->getStyle('A1:M1')->applyFromArray($mindafont);
						$sheet->getStyle('A2:M3')->applyFromArray($unitfont);

						$sheet->setCellValue('A4','OUTGOING RECORDS (DIVISION: '.Auth::user()->division.')');
						$sheet->getStyle('A4')->applyFromArray($unitfont);

						$sheet->setCellValue('A5','#');
						$sheet->setCellValue('B5','Document Date');
						$sheet->setCellValue('C5','Briefer #');
						$sheet->setCellValue('D5','Barcode');
						$sheet->setCellValue('E5','Office/Division');
						$sheet->setCellValue('F5','Sender');
						$sheet->setCellValue('G5','From/Addressee');
						$sheet->setCellValue('H5','Receiver');
						$sheet->setCellValue('I5','Description');
						$sheet->setCellValue('J5','Forwarded To');
						$sheet->setCellValue('K5','Date Forwarded');
						$sheet->setCellValue('L5','Status');
						$sheet->setCellValue('M5','# of Days');
						$sheet->setCellValue('N5','Action Taken');

						$sheet->getStyle('A5:M5')->applyFromArray($rpfont);

						$row = 6;
						$brow = 6;
						$s = 1;

					
					foreach ($period as $dt) {

						$year = Carbon::parse($dt)->year;
						$month = Carbon::parse($dt)->month;	

						$data = DB::table('outgoings')
				               	->join('outgoing_departments','outgoings.id','=','outgoing_departments.ff_id')
				                ->join('outgoing_history','outgoings.id','=','outgoing_history.ref_id')
				                ->orderBy('outgoings.id','asc')
				                ->groupBy('outgoings.barcode')
								->whereMonth('outgoings.doc_receive','=',$month)
								->whereYear('outgoings.doc_receive','=',$year)
								->where(['outgoing_departments.dept'=>Auth::user()->division])
			         			->get();

			         			

			         	foreach ($data as $d) 
							{
								
								if(!$data->isEmpty())
								{
						         	$b_id = $d->id;

									$sheet->setCellValue('A'.$row, $s);
									$sheet->setCellValue('B'.$row, date('m-d-Y', strtotime($d->doc_receive)));
						            $sheet->setCellValue('C'.$row, $d->briefer_number);
						            $sheet->setCellValue('D'.$row, $d->barcode);
						            $sheet->setCellValue('E'.$row, $d->agency);
						            $sheet->setCellValue('F'.$row, $d->sender);
						            $sheet->setCellValue('G'.$row, $d->signatory);
						            $sheet->setCellValue('H'.$row, $d->sendto);
						            $sheet->setCellValue('I'.$row, $d->description);
						            $sheet->getStyle('I'.$row)->getAlignment()->setWrapText(true);

						            $sheet->getStyle('A'.$row.':I'.$row)->getAlignment()->setVertical('top');

						            $history = DB::table('outgoing_history')
						            			->where(['outgoing_history.ref_id'=>$b_id])
						            			->orderBy('outgoing_history.id','desc')
						            			->get();

						            		if($history->count()>0)
						            		{
						            			foreach ($history as $h) {
						            				$rem = $h->remarks;

						            				$rep = str_replace('<br>', "\r\n", $rem);

						            				 $sheet->setCellValue('J'.$row, $h->destination);
						            				 $sheet->setCellValue('K'.$row, $h->date_forwared);
						            				 $sheet->setCellValue('L'.$row, $h->stat);
						            				 $sheet->setCellValue('M'.$row, $h->days_count);
						            				 $sheet->setCellValue('N'.$row, $rep);
						            				 $sheet->getStyle('J'.$row)->getAlignment()->setWrapText(true);
						            				 $sheet->getStyle('K'.$row)->getAlignment()->setWrapText(true);
						            				 $sheet->getStyle('L'.$row)->getAlignment()->setWrapText(true);

						            				 $sheet->getStyle('J'.$row.':N'.$row)->getAlignment()->setVertical('top');
						            				 $sheet->getStyle('N'.$row.':N'.$row)->applyFromArray($borderThin);
						            				 $row++;
						            			}
						            		}

						            	$row=$row-1;
						            	//$brow = $brow-1;

						            	$sheet->getStyle('A6'.':N'.$row)->applyFromArray($borderThin);
						            
						            $s++;
						            $row++;
						            $brow++;

						            
						          }
						          
						      }

							}

	    		}
    		}

	    		

			$writer = new Xlsx($spreadsheet);
			$writer->save('Outgoing-'.Carbon::now()->format('m-d-Y').'.xlsx');

			$filename="Outgoing-".Carbon::now()->format('m-d-Y').".xlsx";
			$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
			$spreadsheet = $reader->load("$filename");

			//return response()->JSON(['data' => $result]);

			return response()->json([
			    'url' => $filename
			]);

    	}
    }

    public function acknowledgementreceipt($id)
    {
    	$data = DB::table('externals')
    			->where(['externals.id'=>$id])
    			->get();


    	$reffont = array(
					    'font'  	=> array(
					        'bold'  => false,
					        'color' => array('rgb' => '000000'),
					        'size'  => 8,
					        'name'  => 'Calibri'
						    ));

    	$barcodefont = array(
					    'font'  	=> array(
					        'bold'  => true,
					        'color' => array('rgb' => '000000'),
					        'size'  => 14,
					        'name'  => 'Calibri'
						    ));

    	$republicfont = array(
					    'font'  	=> array(
					        'bold'  => true,
					        'color' => array('rgb' => '000000'),
					        'size'  => 11,
					        'name'  => 'Calibri'
						    ));



    	$borderBox = array(
		    'borders' => array(
		        'outline' => array(
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		            'color' => array('argb' => '000000'),
		        ),
		    ),
		);

    	$desc = new \PhpOffice\PhpSpreadsheet\Helper\Html();
		
    	$p1 = '&emsp;&emsp; 		The <b>MINDANAO DEVELOPMENT AUTHORITY</b> hereby acknowledge the receipt of your letter/request which has been uploaded to the MinDA Document Tracking System and routed to the appropriate office/s with the following information.';
    	

    		$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet = $spreadsheet->getActiveSheet()->setTitle('Acknowledgement Receipt');

			$sheet->getColumnDimension('A')->setAutoSize(false);
			$sheet->getColumnDimension('A')->setWidth(31.78);
			$sheet->getColumnDimension('B')->setAutoSize(false);
			$sheet->getColumnDimension('B')->setWidth(32.11);
			$sheet->getColumnDimension('C')->setAutoSize(false);
			$sheet->getColumnDimension('C')->setWidth(26.44);

			$drawing = new Drawing();
	        $drawing->setPath(public_path('/images/minda_logo.png'));
	        $drawing->setHeight(100);
	        $drawing->setCoordinates('B1');
        	$drawing->setWorksheet($sheet);

        	foreach ($data as $d) {
	        	$sheet->setCellValue('C3','In following up, pls cite Reference #');
	        	$sheet->setCellValue('C4',$d->barcode);
	        	$sheet->getStyle('C3')->getAlignment()->setHorizontal('center');
	        	$sheet->getStyle('C4')->getAlignment()->setHorizontal('center');
	        	$sheet->getStyle('C2:C5')->applyFromArray($borderBox);
	        	$sheet->getStyle('C3')->applyFromArray($reffont);
	        	$sheet->getStyle('C4')->applyFromArray($barcodefont);

	        	$sheet->setCellValue('A7',strtoupper('Republic of the Philippines'));
				$sheet->setCellValue('A8','Office of the President');
				$sheet->setCellValue('A9','Mindanao Development Authority');
				$sheet->setCellValue('A10','Old Airport Bldg., Old Airport Road,');
				$sheet->setCellValue('A11','Km. 9, Sasa, Davao City 8000 Philippines');
				$sheet->setCellValue('A13','ACKNOWLEGEMENT RECEIPT');
				$sheet->mergeCells('A7:C7');
				$sheet->mergeCells('A8:C8');
				$sheet->mergeCells('A9:C9');
				$sheet->mergeCells('A10:C10');
				$sheet->mergeCells('A11:C11');
				$sheet->mergeCells('A12:C12');
				$sheet->mergeCells('A13:C13');
				$sheet->getStyle('A7:C13')->getAlignment()->setHorizontal('center');
				$sheet->getStyle('A7')->applyFromArray($republicfont);
				$sheet->getStyle('A9')->applyFromArray($barcodefont);
				$sheet->getStyle('A13')->applyFromArray($barcodefont);

				$sheet->setCellValue('A15',$desc->toRichTextObject($p1));
				$sheet->mergeCells('A15:C15');
				$sheet->getRowDimension('15')->setRowHeight(47.40);
				$sheet->getStyle('A15')->getAlignment()->setWrapText(true);
				$sheet->getStyle('A15')->getAlignment()->setHorizontal('justify');
				$sheet->getStyle('A15')->getAlignment()->setVertical('top');

				$sheet->setCellValue('A17','Sender:');
				$sheet->setCellValue('B17',$d->sendername);
				$sheet->setCellValue('A19','Document Title:');
				$sheet->setCellValue('B19',$d->description);
				$sheet->setCellValue('A21','Document Reference No:');
				$sheet->setCellValue('B21',$d->barcode);
				$sheet->setCellValue('A23','Date and Time Uploaded:');
				$sheet->setCellValue('B23',Carbon::parse($d->created_at)->format('l jS \\of F Y @ h:i:s A'));
				$sheet->setCellValue('A25','Uploaded By:');
				$sheet->setCellValue('B25',strtoupper($d->uploadby));
				$sheet->setCellValue('A27','Routed To:');
				$sheet->setCellValue('B27',strtoupper($d->signatory));
				$sheet->setCellValue('B29','CC');
				$sheet->setCellValue('A31','Total no of pages received:');
				$sheet->setCellValue('B31',$d->n_copy.' copy and '.$d->n_pages.' pages');
				$sheet->setCellValue('A33','		The degtermination of the completeness of the documentary requirements submitted, if any, is subject to the evaluation of the technical person in charge.');
				$sheet->getRowDimension('33')->setRowHeight(35.40);
				$sheet->mergeCells('A33:C33');
				$sheet->getStyle('A33')->getAlignment()->setHorizontal('justify');
				$sheet->setCellValue('A35','		The receipt is the system generated and does not require signature.');
				$sheet->setCellValue('A37','Received by:');
			}

			$drawing2 = new Drawing();
	        $drawing2->setPath(public_path('/images/dts-image_minda-document_tracking_system.png'));
	        $drawing2->setHeight(100);
	        $drawing2->setCoordinates('A38');
        	$drawing2->setWorksheet($sheet);


			$writer = new Xlsx($spreadsheet);
			$writer->save('AcknowledgementReceipt'.'.xlsx');


			$filename="AcknowledgementReceipt".".xlsx";
			//$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
			//$spreadsheet = $reader->load("$filename");
			
			/////////////////////////
			//$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			//$reader->setReadDataOnly(true);
			//$spreadsheet = $reader->load($filename); 
			//$pdf_path = 'AcknowledgementReceipt.pdf';
			//$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
			//header('Content-Type: application/pdf');
			//header('Content-Disposition: attachment;filename='.$pdf_path);
			//header('Cache-Control: max-age=0');
			////////////////////////////
	
			//$writer->save($pdf_path);
			return redirect('/'.$filename);

    }
}
