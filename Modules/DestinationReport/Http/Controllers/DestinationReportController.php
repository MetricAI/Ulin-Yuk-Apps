<?php

namespace Modules\DestinationReport\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\DestinationPlace\Repositories\DestinationPlaceRepository;
use Modules\DestinationReport\Repositories\DestinationReportRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use DB;

class DestinationReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_destinationPlaceRepository   = new DestinationPlaceRepository;
        $this->_destinationReportRepository = new DestinationReportRepository;
        $this->module = "DestinationReport";

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

        $destinationPlaces = $this->_destinationPlaceRepository->getAll();
        $destinationReports     = $this->_destinationReportRepository->getAll();

        return view('destinationreport::index', compact('destinationPlaces', 'destinationReports'));
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

        return view('destinationreport::create');
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

        $this->_destinationReportRepository->insert(DataHelper::_normalizeParams($request->all(), true));

        $this->_logHelper->store($this->module, $request->destination_place_id, 'create');

        DB::commit();

        return redirect('destination-report')->with('message', 'Kunjungan Destinasi berhasil ditambahkan');
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

        return view('destinationreport::show');
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

        return view('destinationreport::edit');
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

        $this->_destinationReportRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
        $this->_logHelper->store($this->module, $request->destination_place_id, 'update');

        DB::commit();

        return redirect('destination-report')->with('message', 'Kunjungan Destinasi berhasil diubah');
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
         $detail  = $this->_destinationReportRepository->getById($id);

         if (!$detail) {
             return redirect('destination-report');
         }
        DB::beginTransaction();
        $this->_destinationReportRepository->delete($id);
        $this->_logHelper->store($this->module, $detail->destination_place_id, 'delete');
        DB::commit();


        return redirect('destination-report')->with('message', 'Kunjungan Destinasi berhasil dihapus');
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function getdata($id){

        $response   = array('status' => 0, 'result' => array());
        $getDetail  = $this->_destinationReportRepository->getById($id);

        if ($getDetail) {
            $response['status'] = 1;
            $response['result'] = $getDetail;
        }

        return $response;

    }
}
