<?php

namespace Modules\Photo\Repositories;

use App\Implementations\QueryBuilderImplementation;

class PhotoRepository extends QueryBuilderImplementation
{
    public $fillable = ['photo_name', 'photo_location', 'photo_location_link', 'created_at', 'created_by', 'updated_at', 'updated_by'];

    public function __construct()
    {
        $this->table = 'photos';
        $this->pk = 'photo_id';
    }
}
