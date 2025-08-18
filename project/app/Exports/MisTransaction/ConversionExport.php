<?php
namespace App\Exports\MisTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromArray;

class ConversionExport implements FromArray,WithTitle {
    protected $data;
    

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Land Conversion';
    }


    public function array(): array
    {
        $type = isset($this->data['type'])? $this->data['type']:"";
        if($type == ""){
            $conversion_excel = $this->data;       

            $conversion_new_arr = [
                ['Transaction ID', 'Registration No', 'Survey No.', 'Transaction Type', 'Transaction Date', 'Remarks',
                'State', 'District', 'Block/Taluk', 'Village'],
                $conversion_excel,
            ];
        }else{
            $single_conversion_excel = $this->data['conversion_arr'];       

            $conversion_new_arr = [
                ['Transaction ID', 'Registration No', 'Survey No.', 'Transaction Type', 'Transaction Date', 'Remarks',
                'State', 'District', 'Block/Taluk', 'Village'],
                $single_conversion_excel,
            ];
        }
        return $conversion_new_arr;
    }

}


?>