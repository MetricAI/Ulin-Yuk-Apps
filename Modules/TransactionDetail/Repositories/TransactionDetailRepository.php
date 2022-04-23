<?php

namespace Modules\TransactionDetail\Repositories;

use App\Implementations\QueryBuilderImplementation;

class TransactionDetailRepository extends QueryBuilderImplementation
{
    public $fillable = ['transaction_total_id', 'culinary_place_id', 'transaction_total', 'transaction_total_price', 'created_at', 'created_by', 'updated_at', 'updated_by'];

    public function __construct()
    {
        $this->table = 'transaction_details';
        $this->pk = 'transaction_detail_id	';
    }
}
