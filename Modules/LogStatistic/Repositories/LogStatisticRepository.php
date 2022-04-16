<?php

namespace Modules\LogStatistic\Repositories;

use App\Implementations\QueryBuilderImplementation;
use Exception;
use Illuminate\Support\Facades\DB;

class LogStatisticRepository extends QueryBuilderImplementation
{
    public $fillable = ['ip_address', 'url_access', 'page_access', 'hits_url_access', 'browser_access', 'device_access', 'operating_system_access', 'created_at', 'updated_at'];

    public function __construct()
    {
        $this->table = 'log_statistics';
        $this->pk = 'log_statistic_id';
    }

    public function getAllHit()
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->selectRaw("SUM(hits_url_access) as hit_total")
                ->groupBy('created_at')
                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAll()
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->orderBy('created_at', 'asc')
                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAllHitNews()
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->selectRaw("SUM(hits_url_access) as hit_news")
                ->groupBy('page_access')
                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAllNewsURL()
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->groupBy('url_access')
                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAllNewsList()
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->groupBy('page_access')
                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAllDate()
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->groupBy('created_at')
                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAllYajra()
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
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
                ->where($this->pk, '=', $id)
                ->first();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getRanking($date)
    {
        try {
            return DB::connection($this->db)
                ->table($this->table)
                ->selectRaw("SUM(hits_url_access) as hits_url_access")
                ->selectRaw("page_access as page_access")
                ->selectRaw("url_access as url_access")
                ->selectRaw("created_at as created_at")
                ->groupBy('page_access')
                ->orderBy('hits_url_access', 'desc')
                ->where('created_at', 'like', $date . '%')
                ->limit(5)
                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
