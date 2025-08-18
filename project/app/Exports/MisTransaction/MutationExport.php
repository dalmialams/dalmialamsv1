<?php
namespace App\Exports\MisTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;
use DB;


class MutationExport implements FromArray,WithTitle {

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
   
    public function title(): string
    {
        return 'Mutation';
    }

    public function array(): array
    {
        $type = isset($this->data['type'])? $this->data['type']:"";
        if($type == ""){
            $mutation_excel = $this->data;
    
            $arr = [
                ['Transaction ID', 'Patta No.', 'Patta Owner', 'New Patta No.', 'New Patta Owner', 'Registration No', 'Survey No.', 'Transaction Date',
                'State', 'District', 'Block/Taluk', 'Village'],
                $mutation_excel,
            ];
        }else{
            $single_mutation_excel = $this->data['mutation_arr'];
    
            $arr = [
                ['Transaction ID', 'Patta No.', 'Patta Owner', 'New Patta No.', 'New Patta Owner', 'Registration No', 'Survey No.', 'Transaction Date',
                'State', 'District', 'Block/Taluk', 'Village'],
                $single_mutation_excel,
            ];
        }
        return $arr;
    }

}




?>