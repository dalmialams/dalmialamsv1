<?php
namespace App\Exports\MisRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;
use DB;


class DocumentDetailExport implements FromArray,WithTitle {

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
   
    public function title(): string
    {
        return 'Document Details';
    }

    public function array(): array
    {
        $document_detail_excel = $this->data;
   
        $arr = [
            ['Reg No', 'Doc Type', 'Physical Location', 'Uploaded Documents', 'Remarks'],
            $document_detail_excel,
        ];
        return $arr;
    }

}




?>