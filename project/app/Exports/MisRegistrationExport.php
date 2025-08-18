<?php
namespace App\Exports;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\MisRegistration\RegistrationExport;
use App\Exports\MisRegistration\SurveyDetailExport;
use App\Exports\MisRegistration\DocumentDetailExport;
use App\Exports\MisRegistration\PaymentDetailDocsExport;
use App\Exports\MisRegistration\AuditDetailExport;


class MisRegistrationExport implements WithMultipleSheets
{
    protected $data;    

    public function __construct($data)
    {
        $this->data = $data;
    }
   
    public function sheets(): array
    {
        return [
            'Sheet1' => new RegistrationExport($this->data['reg_arr']),
            'Sheet2' => new SurveyDetailExport($this->data['survey_arr']),
            'Sheet3' => new DocumentDetailExport($this->data['document_arr']),
            'Sheet4' => new PaymentDetailDocsExport($this->data['payment_arr']),
            'Sheet5' => new AuditDetailExport($this->data['audit_arr']),
        ];
    }
}
?>