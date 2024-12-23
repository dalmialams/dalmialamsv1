<?php
namespace App\Exports\MisTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;
use DB;


class ParentExport implements FromArray,WithTitle {

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
   
    public function title(): string
    {
        return 'Conversion To Parent Company';
    }

    public function array(): array
    {
        $type = isset($this->data['type'])? $this->data['type']:"";
        if($type == ""){
            $parent_excel = $this->data;
    
            $arr = [
                ['Transaction ID', 'Converted ID', 'Transaction Date', 'Old Registration No.', 'New Registration No', 'Purchaser', 'Legal Entity', 'Sub Registrar Office', 'Purchased Area', 'Cost',
                'State', 'District', 'Block/Taluk', 'Village'],
                $parent_excel,
            ];
        }else{
            $single_parent_excel = $this->data['parent_arr'];
    
            $arr = [
                ['Transaction ID', 'Converted ID', 'Transaction Date', 'Old Registration No.', 'New Registration No', 'Purchaser', 'Legal Entity', 'Sub Registrar Office', 'Purchased Area', 'Cost',
                'State', 'District', 'Block/Taluk', 'Village'],
                $single_parent_excel,
            ];
        }
        return $arr;
    }

}




?>