<?php

namespace Modules\TransactionDetail\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\TransactionDetail\Repositories\TransactionDetailRepository;
use Modules\TransactionTotal\Repositories\TransactionTotalRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use DB;

class TransactionDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_transactionDetailRepository = new TransactionDetailRepository;
        $this->_transactionTotalRepository = new TransactionTotalRepository;
        $this->module               = "TransactionDetail";
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

        $transactionDetails      = $this->_transactionDetailRepository->getAll();
        $transactionTotals    = $this->_transactionTotalRepository->getAll();

        return view('transactiondetail::index', compact('transactionDetails', 'transactionTotals'));
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

        return view('transactiondetail::create');
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

        $this->_transactionDetailRepository->insert(DataHelper::_normalizeParams($request->all(), true));

        $this->_logHelper->store($this->module, $request->transaction_total_id, 'create');

        DB::commit();

        return redirect('transaction-detail')->with('message', 'Transaksi Detail berhasil ditambahkan');
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

        return view('transactiondetail::show');
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

        return view('transactiondetail::edit');
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

        $this->_transactionDetailRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
        $this->_logHelper->store($this->module, $request->transaction_total_id, 'update');

        DB::commit();

        return redirect('transaction-detail')->with('message', 'Transaksi Detail berhasil diubah');
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
         $detail  = $this->_transactionDetailRepository->getById($id);

         if (!$detail) {
             return redirect('transaction-detail');
         }
        DB::beginTransaction();
        $this->_transactionDetailRepository->delete($id);
        $this->_logHelper->store($this->module, $detail->transaction_total_id, 'delete');
        DB::commit();


        return redirect('transaction-detail')->with('message', 'Transaksi Detail berhasil dihapus');
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function getdata($id){

        $response   = array('status' => 0, 'result' => array());
        $getDetail  = $this->_transactionDetailRepository->getById($id);

        if ($getDetail) {
            $response['status'] = 1;
            $response['result'] = $getDetail;
        }

        return $response;

    }
}
