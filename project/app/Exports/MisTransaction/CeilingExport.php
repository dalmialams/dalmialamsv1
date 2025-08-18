<?php
namespace App\Exports\MisTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;
use DB;


class CeilingExport implements FromArray,WithTitle {

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
   
    public function title(): string
    {
        return 'Land Ceiling';
    }

    public function array(): array
    {
        $type = isset($this->data['type'])? $this->data['type']:'';
        if($type == ""){
            $ceiling_excel = $this->data;
    
            $arr = [
                ['Transaction ID', 'Registration No', 'Survey No.', 'Transaction Type', 'Transaction Date', 'Remarks',
                'State', 'District', 'Block/Taluk', 'Village'],
                $ceiling_excel,
            ];
        }else{
            $single_ceiling_excel = $this->data['ceiling_arr'];
            $arr = [
                ['Transaction ID', 'Registration No', 'Survey No.', 'Transaction Type', 'Transaction Date', 'Remarks',
                'State', 'District', 'Block/Taluk', 'Village'],
                $single_ceiling_excel,
            ];
        }
        return $arr;
    }

}




?>