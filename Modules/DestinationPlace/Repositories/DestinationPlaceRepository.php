<?php

namespace Modules\DestinationPlace\Repositories;

use App\Implementations\QueryBuilderImplementation;

class DestinationPlaceRepository extends QueryBuilderImplementation
{
    public $fillable = ['area_location_id', 'destination_device_code', 'photo_id', 'destination_place_title', 'destination_place_latitude' , 'destination_place_longitude' ,'destination_place_description','destination_place_price','destination_place_status','destination_place_rating', 'created_at', 'created_by', 'updated_at', 'updated_by'];

    public function __construct()
    {
        $this->table = 'destination_places';
        $this->pk = 'destination_place_id	';
    }
}
