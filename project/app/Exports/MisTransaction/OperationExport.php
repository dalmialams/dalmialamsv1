<?php
namespace App\Exports\MisTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;
use DB;


class OperationExport implements FromArray,WithTitle {

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
   
    public function title(): string
    {
        return 'Under Operation';
    }

    public function array(): array
    {
        $type = isset($this->data['type'])? $this->data['type']:"";
        if($type == ""){
            $operation_excel = $this->data;
    
            $arr = [
                ['Transaction ID', 'Registration No', 'Survey No.', 'Transaction Date', 'Operation Type', 'Remarks',
                'State', 'District', 'Block/Taluk', 'Village'],
                $operation_excel,
            ];
        }else{
            $single_operation_excel = $this->data['operation_arr'];
    
            $arr = [
                ['Transaction ID', 'Registration No', 'Survey No.', 'Transaction Date', 'Operation Type', 'Remarks',
                'State', 'District', 'Block/Taluk', 'Village'],
                $single_operation_excel,
            ];
        }
        return $arr;
    }

}




?>