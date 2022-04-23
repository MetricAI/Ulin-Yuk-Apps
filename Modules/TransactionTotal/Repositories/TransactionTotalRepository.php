<?php

namespace Modules\TransactionDetail\Repositories;

use App\Implementations\QueryBuilderImplementation;

class TransactionDetailRepository extends QueryBuilderImplementation
{
    public $fillable = ['transaction_total', 'transaction_confirmation', 'transaction_status', 'created_at', 'created_by', 'updated_at', 'updated_by'];

    public function __construct()
    {
        $this->table = 'transaction_totals';
        $this->pk = 'transaction_total_id	';
    }
}
