<?php
namespace App\Exports\MisTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;
use DB;


class DisputeExport implements FromArray,WithTitle {

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
   
    public function title(): string
    {
        return 'Disputes';
    }

    public function array(): array
    {
        $type = isset($this->data['type'])? $this->data['type']:'';
        if($type == ""){
            $dispute_excel = $this->data;
    
            $arr = [
                ['Transaction ID', 'Registration NO', 'Survey No.', 'Date', 'Reminder Date', 'Next Hearing Date', 'Litigation Type', 'Remarks','State', 'District', 'Block/Taluk', 'Village'],
                $dispute_excel,
            ];
        }else{
            $single_dispute_excel = $this->data['dispute_arr'];
    
            $arr = [
                ['Transaction ID', 'Registration NO', 'Survey No.', 'Date', 'Reminder Date', 'Next Hearing Date', 'Litigation Type', 'Remarks','State', 'District', 'Block/Taluk', 'Village'],
                $single_dispute_excel,
            ];
        }
        return $arr;
    }

}




?>