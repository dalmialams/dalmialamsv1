<?php
namespace App\Exports\MisTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;
use DB;


class ReservationExport implements FromArray,WithTitle {

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
   
    public function title(): string
    {
        return 'Land Reservation';
    }

    public function array(): array
    {
        $type = isset($this->data['type'])? $this->data['type']:"";
        if($type == ""){
            $reservation_excel = $this->data;
    
            $arr = [
                ['Transaction ID', 'Registration No', 'Survey No.', 'Transaction Type', 'Transaction Date', 'Remarks',
                'State', 'District', 'Block/Taluk', 'Village'],
                $reservation_excel,
            ];
        }else{
            $single_reservation_excel = $this->data['reservation_arr'];
    
            $arr = [
                ['Transaction ID', 'Registration No', 'Survey No.', 'Transaction Type', 'Transaction Date', 'Remarks',
                'State', 'District', 'Block/Taluk', 'Village'],
                $single_reservation_excel,
            ];
        }
        return $arr;
    }

}




?>