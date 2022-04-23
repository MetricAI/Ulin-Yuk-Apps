<?php

namespace Modules\File\Repositories;

use App\Implementations\QueryBuilderImplementation;

class FileRepository extends QueryBuilderImplementation
{
    public $fillable = ['file_name', 'file_location', 'file_location_link', 'created_at', 'created_by', 'updated_at', 'updated_by'];

    public function __construct()
    {
        $this->table = 'files';
        $this->pk = 'file_id';
    }
}
