<?php

namespace App\Exports\MisRegistration;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SurveyDetailExport implements FromArray, WithTitle, ShouldAutoSize
{   

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Survey Details';
    }

    public function array(): array
    {
        $survey_detail_excel = $this->data;

        $arr = [
            ['Reg No', 'Survey No', 'State', 'District', 'Block/Taluk', 'Village', 'Doc Regn No', 'Extend Unit', 'Extend Value', 'Purchased Area', 'Purpose', 'Classification', 'Sub-Classification','Mutation Status', 'Encroachment', 'Land Reservation Status', 'Operation Status', 'Dispute Status', 'Mining Status','Land Ceiling Status', 'Land Conversion Status', 'Land Exchnage Status', 'Source'],
            $survey_detail_excel,
        ];
        return $arr;
    }

    

}
