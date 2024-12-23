<?php
namespace App\Exports\MisTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;
use DB;


class LeaseExport implements FromArray,WithTitle {

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
   
    public function title(): string
    {
        return 'Lease';
    }

    public function array(): array
    {
        $type = isset($this->data['type'])? $this->data['type']:"";
        if($type == ""){
            $lease_excel = $this->data;
    
            $arr = [
                ['Lease ID', 'Regn No.', 'Lessee', 'Lessor', 'Lease Rent p.a.', 'Period (From - To)', 'Escalation %', 'Status'],
                $lease_excel,
            ];
        }else{
            $single_lease_excel = $this->data['lease_arr'];
    
            $arr = [
                ['Lease ID', 'Regn No.', 'Lessee', 'Lessor', 'Lease Rent p.a.', 'Period (From - To)', 'Escalation %', 'Status'],
                $single_lease_excel,
            ];
        }
        return $arr;
    }

}




?>