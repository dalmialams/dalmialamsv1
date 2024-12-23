<?php

namespace App\Exports\MisTransaction;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InspectionExport implements FromArray, WithTitle, ShouldAutoSize
{   

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Land Inspection';
    }

    public function array(): array
    {
        $type = isset($this->data['type'])? $this->data['type']:"";
        if($type == ""){
            $survey_detail_excel = $this->data;

            $arr = [
                ['Transaction ID', 'Registration No', 'Survey No.', 'Transaction Date', 'Inspection Date', 'Encroachment', 'Encroachment Type', 'Remarks','State', 'District', 'Block/Taluk', 'Village'],
                $survey_detail_excel,
            ];
        }else{
            $single_survey_detail_excel = $this->data['inspection_arr'];

            $arr = [
                ['Transaction ID', 'Registration No', 'Survey No.', 'Transaction Date', 'Inspection Date', 'Encroachment', 'Encroachment Type', 'Remarks','State', 'District', 'Block/Taluk', 'Village'],
                $single_survey_detail_excel,
            ];
        }
        return $arr;
    }

    

}
