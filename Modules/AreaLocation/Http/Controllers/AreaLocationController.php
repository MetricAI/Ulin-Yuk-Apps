<?php

namespace Modules\AreaLocation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\AreaLocation\Repositories\AreaLocationRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use Illuminate\Support\Facades\DB;
use Validator;

class AreaLocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_areaLocationRepository = new AreaLocationRepository;
        $this->module               = "AreaLocation";
        $this->_logHelper           = new LogHelper;
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

        $areaLocations = $this->_areaLocationRepository->getAll();

        return view('arealocation::index', compact('areaLocations'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        // Authorize
        if (Gate::denies(__FUNCTION__, $this->module)) {
            return redirect('unauthorize');
        }

        return view('arealocation::create');
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
            return redirect('area-location')
                ->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();

        $this->_areaLocationRepository->insert(DataHelper::_normalizeParams($request->all()));
        $this->_logHelper->store($this->module, $request->area_location_name, 'create');
        DB::commit();


        return redirect('area-location')->with('message', 'Lokasi berhasil ditambahkan');
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

        return view('arealocation::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        // Authorize
        if (Gate::denies(__FUNCTION__, $this->module)) {
            return redirect('unauthorize');
        }

        return view('arealocation::edit');
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
        $validator = Validator::make($request->all(), $this->_validationRules($id));

        if ($validator->fails()) {
            return redirect('area-location')
                ->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();
        $this->_areaLocationRepository->update(DataHelper::_normalizeParams($request->all()), $id);
        $this->_logHelper->store($this->module, $request->area_location_name, 'update');
        DB::commit();

        return redirect('area-location')->with('message', 'Lokasi berhasil diubah');
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


        $response   = array('status' => 0, 'result' => array());

        // Check detail to db
        $detail  = $this->_areaLocationRepository->getById($id);

        if (!$detail) {
            // return redirect('area-location');
            $response['status'] = 0;
            $response['message'] = 'Data tidak ditemukan!';
        }else {
            DB::beginTransaction();
            $this->_areaLocationRepository->delete($id);
            $this->_logHelper->store($this->module, $detail->area_location_name, 'delete');
            DB::commit();

            $response['status'] = 1;
            $response['message'] = 'Data berhasil dihapus!';
        }

        return $response;
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function getdata($id)
    {

        $response   = array('status' => 0, 'result' => array());
        $getDetail  = $this->_areaLocationRepository->getById($id);

        if ($getDetail) {
            $response['status'] = 1;
            $response['result'] = $getDetail;
        }

        return $response;
    }

    private function _validationRules($id = '')
    {
        if ($id == '') {
            return [
                'area_location_name' => 'required|unique:area_locations',
            ];
        } else {
            return [
                'area_location_name' => 'required|unique:area_locations,area_location_name,' . $id . ',area_location_id',
            ];
        }
    }
}
