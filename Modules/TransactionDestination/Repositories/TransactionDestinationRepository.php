<?php

namespace Modules\TransactionDestination\Repositories;

use App\Implementations\QueryBuilderImplementation;

class TransactionDestinationRepository extends QueryBuilderImplementation
{
    public $fillable = ['destination_place_id', 'transaction_detail_total_price', 'transaction_detail_total', 'transaction_detail_status', 'created_at', 'created_by', 'updated_at', 'updated_by'];

    public function __construct()
    {
        $this->table = 'transaction_destinations';
        $this->pk = 'transaction_destination_id	';
    }
}
