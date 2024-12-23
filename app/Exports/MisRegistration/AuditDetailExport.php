<?php
namespace App\Exports\MisRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;
use DB;


class AuditDetailExport implements FromArray,WithTitle {

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
   
    public function title(): string
    {
        return 'Audit Details';
    }

    public function array(): array
    {
        $audit_detail_excel = $this->data;
   
        $arr = [
            ['Reg No', 'Description', 'Date', 'Verified', 'Remarks', 'Audited By'],
            $audit_detail_excel,
        ];
        return $arr;
    }

}




?>