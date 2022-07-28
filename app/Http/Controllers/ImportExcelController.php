<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportExcelController extends Controller
{
   function index()
    {
         return view('importexcel.import');
    }

    function import(Request $request)
    {

        Excel::import(new UsersImport,request()->file('file'));
           
        return back()->with('success', 'Excel Data Imported successfully.');
    }
}
