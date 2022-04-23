<?php

namespace Modules\Voucher\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\Voucher\Repositories\VoucherRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use Illuminate\Support\Facades\DB;
use Validator;

class VoucherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_voucherRepository = new VoucherRepository;
        $this->module               = "Voucher";
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

        $vouchers = $this->_voucherRepository->getAll();

        return view('voucher::index', compact('vouchers'));
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

        return view('voucher::create');
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
            return redirect('voucher')
                ->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();

        $this->_voucherRepository->insert(DataHelper::_normalizeParams($request->all()));
        $this->_logHelper->store($this->module, $request->voucher_code, 'create');
        DB::commit();


        return redirect('voucher')->with('message', 'Voucher berhasil ditambahkan');
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

        return view('voucher::show');
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

        return view('voucher::edit');
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
            return redirect('voucher')
                ->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();
        $this->_voucherRepository->update(DataHelper::_normalizeParams($request->all()), $id);
        $this->_logHelper->store($this->module, $request->voucher_code, 'update');
        DB::commit();

        return redirect('voucher')->with('message', 'Voucher berhasil diubah');
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
        $detail  = $this->_voucherRepository->getById($id);

        if (!$detail) {
            // return redirect('voucher');
            $response['status'] = 0;
            $response['message'] = 'Data tidak ditemukan!';
        }else {
            DB::beginTransaction();
            $this->_voucherRepository->delete($id);
            $this->_logHelper->store($this->module, $detail->voucher_code, 'delete');
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
        $getDetail  = $this->_voucherRepository->getById($id);

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
                'voucher_code' => 'required|unique:vouchers',
            ];
        } else {
            return [
                'voucher_code' => 'required|unique:vouchers,voucher_code,' . $id . ',voucher_id',
            ];
        }
    }
}
