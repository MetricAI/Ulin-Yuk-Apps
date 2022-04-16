<?php

namespace Modules\MenuSetting\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Illuminate\Support\Facades\DB;

class MenuSettingRepository extends QueryBuilderImplementation
{
    public $fillable = ['menu_setting_name', 'menu_setting_url','menu_parent_setting_id','menu_setting_level','menu_setting_link_eksternal','menu_setting_status','menu_setting_position','created_at', 'created_by', 'updated_at', 'updated_by'];

    public function __construct()
    {
        $this->table = 'menu_settings';
        $this->pk = 'menu_setting_id';
    }
}