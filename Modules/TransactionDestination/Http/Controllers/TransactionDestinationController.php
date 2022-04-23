<?php

namespace Modules\TransactionDestination\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\TransactionDestination\Repositories\TransactionDestinationRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use Illuminate\Support\Facades\DB;
use Validator;

class TransactionDestinationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_transactionDestinationRepository = new TransactionDestinationRepository;
        $this->module               = "TransactionDestination";
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

        $transactiondestinations = $this->_transactionDestinationRepository->getAll();

        return view('transactiondestination::index', compact('transactiondestinations'));
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

        return view('transactiondestination::create');
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

        $this->_transactionDestinationRepository->insert(DataHelper::_normalizeParams($request->all(), true));

        $this->_logHelper->store($this->module, $request->destination_place_id, 'create');

        DB::commit();

        return redirect('transaction-destination')->with('message', 'Transaksi Destinasi berhasil ditambahkan');
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

        return view('transactiondestination::show');
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

        return view('transactiondestination::edit');
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

        $this->_transactionDestinationRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
        $this->_logHelper->store($this->module, $request->destination_place_id, 'update');

        DB::commit();

        return redirect('transaction-destination')->with('message', 'Transaksi Destinasi berhasil diubah');
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
         $detail  = $this->_transactionDestinationRepository->getById($id);

         if (!$detail) {
             return redirect('transaction-destination');
         }
        DB::beginTransaction();
        $this->_transactionDestinationRepository->delete($id);
        $this->_logHelper->store($this->module, $detail->destination_place_id, 'delete');
        DB::commit();


        return redirect('transaction-destination')->with('message', 'Transaksi Destinasi berhasil dihapus');
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function getdata($id){

        $response   = array('status' => 0, 'result' => array());
        $getDetail  = $this->_transactionDestinationRepository->getById($id);

        if ($getDetail) {
            $response['status'] = 1;
            $response['result'] = $getDetail;
        }

        return $response;

    }
}
