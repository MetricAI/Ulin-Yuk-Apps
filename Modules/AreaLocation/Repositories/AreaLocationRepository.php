<?php

namespace Modules\AreaLocation\Repositories;

use App\Implementations\QueryBuilderImplementation;

class AreaLocationRepository extends QueryBuilderImplementation
{
    public $fillable = ['area_location_name	', 'created_at', 'created_by', 'updated_at', 'updated_by'];

    public function __construct()
    {
        $this->table = 'area_locations';
        $this->pk = 'area_location_id	';
    }
}
