<?php
namespace App\Exports\MisTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;
use DB;


class HypotheticationExport implements FromArray,WithTitle {

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
   
    public function title(): string
    {
        return 'Hypothecation';
    }

    public function array(): array
    {
       
        $type = isset($this->data['type'])? $this->data['type']:'';
        if($type == ""){
            $hypothetication_excel = $this->data;
            $arr = [
                ['Transaction ID', 'Transaction Date', 'Hypothecate Name', 'Transaction Type', 'Registration No.', 'Hypothecate With', 'Date', 'Value', 'Remarks'],
                $hypothetication_excel,
            ];
        }else{
            $single_hypo_excel = $this->data['hypo_arr'];
            $arr = [
                ['Transaction ID', 'Transaction Date', 'Hypothecate Name', 'Transaction Type', 'Registration No.', 'Hypothecate With', 'Date', 'Value', 'Remarks'],
                $single_hypo_excel,
            ];
        }
   
        
        return $arr;
    }

}




?>