<?php
namespace App\Exports\MisTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromArray;

class ExchangeExport implements FromArray,WithTitle {
    protected $data;
    

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Land Exchange';
    }


    public function array(): array
    {
        $type = isset($this->data['type'])? $this->data['type']:"";
        if($type == ""){
            $exchange_excel = $this->data;
            $arr = [
                ['Transaction ID', 'Registration No', 'Survey No.', 'Transaction Date', 'Transferee', 'Date Of Exchange', 'Remarks',
                'State', 'District', 'Block/Taluk', 'Village'],
                $exchange_excel,
            ];
        }else{
            $single_exchange_excel = $this->data['exchange_arr'];
            $arr = [
                ['Transaction ID', 'Registration No', 'Survey No.', 'Transaction Date', 'Transferee', 'Date Of Exchange', 'Remarks',
                'State', 'District', 'Block/Taluk', 'Village'],
                $single_exchange_excel,
            ];
        }
        return $arr;
    }

}


?>