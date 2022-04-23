<?php

namespace Modules\CulinaryPlace\Repositories;

use App\Implementations\QueryBuilderImplementation;

class CulinaryPlaceRepository extends QueryBuilderImplementation
{
    public $fillable = ['area_location_id', 'photo_id', 'culinary_place_title','culinary_place_description','culinary_place_price','culinary_place_status','culinary_place_rating', 'created_at', 'created_by', 'updated_at', 'updated_by'];

    public function __construct()
    {
        $this->table = 'culinary_places';
        $this->pk = 'culinary_place_id	';
    }
}
