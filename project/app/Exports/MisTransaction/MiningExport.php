<?php
namespace App\Exports\MisTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;
use DB;


class MiningExport implements FromArray,WithTitle {

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
   
    public function title(): string
    {
        return 'Mining Lease';
    }

    public function array(): array
    {
        $type = isset($this->data['type'])? $this->data['type']:"";
        if($type == ""){
            $mining_excel = $this->data;
    
            $arr = [
                ['Transaction ID', 'Registration No', 'Survey No.', 'Transaction Type', 'Transaction Date', 'GO', 'Remarks',
                'State', 'District', 'Block/Taluk', 'Village'],
                $mining_excel,
            ];
        }else{
            $single_mining_excel = $this->data['mining_arr'];
    
            $arr = [
                ['Transaction ID', 'Registration No', 'Survey No.', 'Transaction Type', 'Transaction Date', 'GO', 'Remarks',
                'State', 'District', 'Block/Taluk', 'Village'],
                $single_mining_excel,
            ];
        }
        return $arr;
    }

}




?>