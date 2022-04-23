<?php

namespace Modules\Voucher\Repositories;

use App\Implementations\QueryBuilderImplementation;

class VoucherRepository extends QueryBuilderImplementation
{
    public $fillable = ['voucher_nominal', 'voucher_status', 'created_at', 'created_by', 'updated_at', 'updated_by'];

    public function __construct()
    {
        $this->table = 'vouchers';
        $this->pk = 'voucher_id	';
    }
}
