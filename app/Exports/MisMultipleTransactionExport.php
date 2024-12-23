<?php
namespace App\Exports;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use App\Exports\MisTransaction\DisputeExport;
use App\Exports\MisTransaction\CeilingExport;
use App\Exports\MisTransaction\ConversionExport;
use App\Exports\MisTransaction\ExchangeExport;
use App\Exports\MisTransaction\InspectionExport;

use App\Exports\MisTransaction\ReservationExport;
use App\Exports\MisTransaction\LeaseExport;
use App\Exports\MisTransaction\MiningExport;
use App\Exports\MisTransaction\OperationExport;
use App\Exports\MisTransaction\PaymentExport;

use App\Exports\MisTransaction\MutationExport;
use App\Exports\MisTransaction\HypotheticationExport;
use App\Exports\MisTransaction\ParentExport;


class MisMultipleTransactionExport implements WithMultipleSheets
{
    protected $data;    

    public function __construct($data)
    {
        $this->data = $data;
    }
   
    public function sheets(): array
    {
        return [
            'Sheet1' => new DisputeExport($this->data['dispute_arr']),
            'Sheet2' => new CeilingExport($this->data['ceiling_arr']),
            'Sheet3' => new ConversionExport($this->data['conversion_arr']),
            'Sheet4' => new ExchangeExport($this->data['exchange_arr']),
            'Sheet5' => new InspectionExport($this->data['inspection_arr']),

            'Sheet6' => new ReservationExport($this->data['reservation_arr']),
            'Sheet7' => new LeaseExport($this->data['lease_arr']),
            'Sheet8' => new MiningExport($this->data['mining_arr']),
            'Sheet9' => new OperationExport($this->data['operation_arr']),
            'Sheet10' => new PaymentExport($this->data['payment_arr']),

            'Sheet11' => new MutationExport($this->data['mutation_arr']),
            'Sheet12' => new HypotheticationExport($this->data['hypo_arr']),
            'Sheet13' => new ParentExport($this->data['parent_arr']),
        ];
    }
}
?>