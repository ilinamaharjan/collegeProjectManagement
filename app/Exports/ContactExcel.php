<?php

namespace App\Exports;

use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;



class ContactExcel implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Contact::all();
    // }
    
    public function view(): View
    {
        return view('exports.contactExcelFile');
    }
}
