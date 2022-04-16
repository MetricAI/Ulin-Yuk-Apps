<?php

namespace Modules\LogStatistic\Http\Controllers;

use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Modules\LogStatistic\Repositories\LogStatisticRepository;

use Yajra\DataTables\Facades\DataTables;

class LogStatisticController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->_logStatisticRepository       = new LogStatisticRepository;
        $this->_logHelper                   = new LogHelper;
        $this->module                       = "LogStastistic";
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // Authorize
        if (Gate::denies(__FUNCTION__, $this->module)) {
            return redirect('unauthorize');
        }

        return view('logstatistic::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('logstatistic::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // Authorize
        if (Gate::denies(__FUNCTION__, $this->module)) {
            return redirect('unauthorize');
        }

        $validator = Validator::make($request->all(), $this->_validationRules(''));

        if ($validator->fails()) {
            return redirect('logstatistic')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $this->_logStatisticRepository->insert(DataHelper::_normalizeParams($request->all(), true));
            $this->_logHelper->store($this->module, $request->ip_address, 'create');

            DB::commit();
            return DataHelper::_successResponse(null, 'Data statistik berhasil ditambahkan');
        } catch (\Throwable $th) {

            DB::rollBack();
            return DataHelper::_errorResponse(null, 'Gagal menambahkan data');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        // Authorize
        if (Gate::denies(__FUNCTION__, $this->module)) {
            return redirect('unauthorize');
        }

        $getDetail  = $this->_logStatisticRepository->getById($id);

        if ($getDetail) {
            return DataHelper::_successResponse($getDetail, 'Data berhasil ditemukan.');
        } else {
            return DataHelper::_errorResponse(null, 'Gagal mengambil data!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('logstatistic::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        // Authorize
        if (Gate::denies(__FUNCTION__, $this->module)) {
            return redirect('unauthorize');
        }

        DB::beginTransaction();
        try {
            $this->_logStatisticRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
            $this->_logHelper->store($this->module, $request->ip_address, 'update');

            DB::commit();

            return DataHelper::_successResponse(null, 'Data statistik berhasil diubah');
        } catch (\Throwable $th) {

            DB::rollBack();
            return DataHelper::_errorResponse(null, 'Gagal mengubah data');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        // Authorize
        if (Gate::denies(__FUNCTION__, $this->module)) {
            return redirect('unauthorize');
        }
        // Check detail to db
        $detail  = $this->_logStatisticRepository->getById($id);

        if (!$detail) {
            return DataHelper::_errorResponse(null, 'Data tidak ditemukan');
        }
        DB::beginTransaction();
        try {
            $this->_logStatisticRepository->delete($id);
            $this->_logHelper->store($this->module, $detail->ip_address, 'delete');

            DB::commit();
            return DataHelper::_successResponse(null, 'Data log berhasil dihapus');
        } catch (\Throwable $th) {

            DB::rollBack();
            return DataHelper::_errorResponse(null, 'Gagal menghapus data');
        }
    }

    /**
     * Letter Log Activity Validator
     * @param int $id
     */
    private function _validationRules($id = '')
    {
        if ($id == '') {
            return [
                'browser_access' => 'required',
            ];
        } else {
            return [
                'browser_access' => 'required',
            ];
        }
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function getdata($id)
    {
        $getDetail  = $this->_logStatisticRepository->getById($id);

        if ($getDetail) {
            return DataHelper::_successResponse($getDetail, 'Data berhasil ditemukan.');
        } else {
            return DataHelper::_errorResponse(null, 'Gagal mengambil data!');
        }
    }

    public function getDataYajra()
    {
        $data = $this->_logStatisticRepository->getAllYajra();
        return DataTables::of($data)
            ->addIndexColumn()

            ->addColumn('ip_address', function ($row) {
                $i = 1;
                $ip_address = substr($row->ip_address, 0, 40);
                return '<span class="text" title="' . $row->ip_address . '">' . $ip_address . '</span>';

                $i++;
            })
            ->addColumn('url_access', function ($row) {
                $url_access = substr($row->url_access, 0, 40);
                return '<span class="text" title="' . $row->url_access . '">' . $url_access . '</span>';
            })
            ->addColumn('page_access', function ($row) {
                $page_access = substr($row->page_access, 0, 40);
                return '<span class="text" title="' . $row->page_access . '">' . $page_access . '</span>';
            })
            ->addColumn('hits_url_access', function ($row) {
                $hits_url_access = substr($row->hits_url_access, 0, 40);
                return '<span class="text" title="' . $row->hits_url_access . '">' . $hits_url_access . '</span>';
            })
            ->addColumn('browser_access', function ($row) {
                $browser_access = substr($row->browser_access, 0, 40);
                return '<span class="text" title="' . $row->browser_access . '">' . $browser_access . '</span>';
            })
            ->addColumn('device_access', function ($row) {
                $device_access = substr($row->device_access, 0, 40);
                return '<span class="text" title="' . $row->device_access . '">' . $device_access . '</span>';
            })
            ->addColumn('operating_system_access', function ($row) {
                $operating_system_access = substr($row->operating_system_access, 0, 40);
                return '<span class="text" title="' . $row->operating_system_access . '">' . $operating_system_access . '</span>';
            })
            ->addColumn('created_at', function ($row) {
                $created_at = substr($row->created_at, 0, 40);
                return '<span class="text" title="' . $row->created_at . '">' . $created_at . '</span>';
            })
            ->addColumn('action', function ($row) {

                $btnDetail = '<a href="javascript:void(0)" class="btn btn-icon btnDetail btn-outline-primary mr-1"
                    data-id="' . $row->log_statistic_id . '" data-toggle="tooltip" data-placement="top"
                    title="Detail"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';

                $btnEdit = '<a href="javascript:void(0)" class="btn btn-icon btnEdit btn-outline-info mr-1"
                    data-id="' . $row->log_statistic_id . '" data-toggle="tooltip" data-placement="top"
                    title="Ubah"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>';

                $btnDelete =  '<a href="javascript:void(0)" class="btn btn-icon btnDelete btn-outline-danger mr-1"
                    data-id="' . $row->log_statistic_id . '" data-toggle="tooltip" data-placement="top"
                    title="Hapus"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';

                $btn = $btnDetail . $btnEdit  . $btnDelete;
                return $btn;
            })
            ->rawColumns(['no', 'ip_address', 'url_access', 'page_access', 'hits_url_access','browser_access', 'device_access', 'operating_system_access', 'created_at', 'action'])
            ->make(true);
    }
}
