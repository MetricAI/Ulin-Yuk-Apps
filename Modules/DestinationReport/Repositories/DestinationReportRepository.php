<?php

namespace Modules\DestinationReport\Repositories;

use App\Implementations\QueryBuilderImplementation;

class DestinationReportRepository extends QueryBuilderImplementation
{
    public $fillable = ['destination_place_id', 'number_of_visits', 'destination_revenue', 'created_at', 'created_by', 'updated_at', 'updated_by'];

    public function __construct()
    {
        $this->table = 'destination_reports';
        $this->pk = 'destination_report_id	';
    }
}
