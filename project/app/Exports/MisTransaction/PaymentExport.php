<?php
namespace App\Exports\MisTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;
use DB;


class PaymentExport implements FromArray,WithTitle {

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
   
    public function title(): string
    {
        return 'Payment';
    }

    public function array(): array
    {
        $type = isset($this->data['type'])? $this->data['type']:"";
        if($type == ""){
            $payment_excel = $this->data;
    
            $arr = [
                ['Transaction ID', 'Registration No.', 'Transaction Date', 'Payment Type', 'Mode', 'Amount', 'Ref No',
                'Date', 'Bank', 'Remarks'],
                $payment_excel,
            ];
        }else{
            $single_payment_excel = $this->data['payment_arr'];
    
            $arr = [
                ['Transaction ID', 'Registration No.', 'Transaction Date', 'Payment Type', 'Mode', 'Amount', 'Ref No',
                'Date', 'Bank', 'Remarks'],
                $single_payment_excel,
            ];
        }
        return $arr;
    }

}




?>