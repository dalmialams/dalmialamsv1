<?php
namespace App\Exports\MisRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromArray;

class PaymentDetailDocsExport implements FromArray,WithTitle {
    protected $data;
    

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Payment Details';
    }


    public function array(): array
    {
        // Generate or retrieve data dynamically
        $payment_detail_excel = $this->data;       

        $nature_property_new_arr = [
            ['Reg No', 'Payment Type', 'Mode', 'Amount', 'Ref No', 'Date', 'Bank', 'Remarks', 'Uploaded Documents'],
            $payment_detail_excel,
        ];
        return $nature_property_new_arr;
    }

}


?>