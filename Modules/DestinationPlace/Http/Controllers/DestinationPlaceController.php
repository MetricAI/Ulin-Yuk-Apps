<?php

namespace Modules\DestinationPlace\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\DestinationPlace\Repositories\DestinationPlaceRepository;
use Modules\AreaLocation\Repositories\AreaLocationRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use DB;

class DestinationPlaceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_destinationPlaceRepository   = new DestinationPlaceRepository;
        $this->_areaLocationRepository = new AreaLocationRepository;
        $this->module = "DestinationPlace";

        $this->_logHelper = new LogHelper;
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

        $destinationPlaces      = $this->_destinationPlaceRepository->getAll();
        $areaLocations    = $this->_areaLocationRepository->getAll();

        return view('destinationplace::index', compact('destinationPlaces', 'areaLocations'));
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

        return view('destinationplace::create');
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

        DB::beginTransaction();

        $this->_destinationPlaceRepository->insert(DataHelper::_normalizeParams($request->all(), true));

        $this->_logHelper->store($this->module, $request->destination_place_title, 'create');

        DB::commit();

        return redirect('destination-place')->with('message', 'Destinasi berhasil ditambahkan');
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

        return view('destinationplace::show');
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

        return view('destinationplace::edit');
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

        $this->_destinationPlaceRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
        $this->_logHelper->store($this->module, $request->destination_place_title, 'update');

        DB::commit();

        return redirect('destination-place')->with('message', 'Destinasi berhasil diubah');
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
         $detail  = $this->_destinationPlaceRepository->getById($id);

         if (!$detail) {
             return redirect('destination-place');
         }
        DB::beginTransaction();
        $this->_destinationPlaceRepository->delete($id);
        $this->_logHelper->store($this->module, $detail->destination_place_title, 'delete');
        DB::commit();


        return redirect('destination-place')->with('message', 'Destinasi berhasil dihapus');
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function getdata($id){

        $response   = array('status' => 0, 'result' => array());
        $getDetail  = $this->_destinationPlaceRepository->getById($id);

        if ($getDetail) {
            $response['status'] = 1;
            $response['result'] = $getDetail;
        }

        return $response;

    }
}
