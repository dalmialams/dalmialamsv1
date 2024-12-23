<?php
namespace App\Exports\MisRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromArray;

class RegistrationExport implements FromArray,WithTitle {
    protected $data;
    

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Registration';
    }


    public function array(): array
    {
        $registration_excel = $this->data;
        $arr = [
            ['Reg No', 'Legal Entity','Purchase Type', 'Name of Purchaser', 'Purchasing Team', 'Plot Type','Doc Regn No', 'Regn Date', 'Sub Registrar Office', 'Name of Vendor', 'Purchased Area Unit', 'Purchased Area Value', 'Purchased Area Value (Acre)','Total Cost', 'State', 'District', 'Block/Taluk', 'Village', 'Source'],
            $registration_excel,
        ];
        return $arr;
    }

}


?>