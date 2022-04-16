<?php

namespace Modules\LogActivity\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Exception;
use Illuminate\Support\Facades\DB;

class LogActivityRepository extends QueryBuilderImplementation
{
    public $fillable = ['log_description', 'created_at', 'created_by', 'updated_at', 'updated_by'];

    public function __construct()
    {
        $this->table = 'sys_log_activities';
        $this->pk = 'log_activity_id';
    }

    public function getAllYajra()
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->join('sys_users', 'sys_users.user_id', 'sys_log_activities.created_by')
                ->select(
                    'sys_log_activities.*',
                    'sys_users.user_name'
                )
                ->latest();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getById($id)
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->join('sys_users', 'sys_users.user_id', 'sys_log_activities.created_by')
                ->join('sys_user_groups', 'sys_user_groups.group_id', 'sys_users.group_id')
                ->select(
                    'sys_log_activities.*',
                    'sys_users.user_name',
                    'sys_users.user_email',
                    'sys_user_groups.group_name',
                )
                ->where($this->pk, '=', $id)
                ->first();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
