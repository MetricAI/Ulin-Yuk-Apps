<?php

namespace Modules\File\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\File\Repositories\FileRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use Illuminate\Support\Facades\DB;
use Validator;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_fileRepository = new FileRepository;
        $this->module               = "File";
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

        $files = $this->_fileRepository->getAll();

        return view('file::index', compact('files'));
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

        return view('file::create');
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
            return redirect('file')
                ->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();

        $this->_fileRepository->insert(DataHelper::_normalizeParams($request->all()));
        $this->_logHelper->store($this->module, $request->file_name, 'create');
        DB::commit();


        return redirect('file')->with('message', 'Berkas berhasil ditambahkan');
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

        return view('file::show');
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

        return view('file::edit');
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
            return redirect('file')
                ->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();
        $this->_fileRepository->update(DataHelper::_normalizeParams($request->all()), $id);
        $this->_logHelper->store($this->module, $request->file_name, 'update');
        DB::commit();

        return redirect('file')->with('message', 'Berkas berhasil diubah');
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
        $detail  = $this->_fileRepository->getById($id);

        if (!$detail) {
            // return redirect('file');
            $response['status'] = 0;
            $response['message'] = 'Data tidak ditemukan!';
        }else {
            DB::beginTransaction();
            $this->_fileRepository->delete($id);
            $this->_logHelper->store($this->module, $detail->file_name, 'delete');
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
        $getDetail  = $this->_fileRepository->getById($id);

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
                'file_name' => 'required|unique:files',
            ];
        } else {
            return [
                'file_name' => 'required|unique:files,file_name,' . $id . ',file_id',
            ];
        }
    }
}
