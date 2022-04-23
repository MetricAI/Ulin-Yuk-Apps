<?php

namespace Modules\Photo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

use Modules\Photo\Repositories\PhotoRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use Illuminate\Support\Facades\DB;
use Validator;

class PhotoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_photoRepository = new PhotoRepository;
        $this->module               = "Photo";
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

        $photos = $this->_photoRepository->getAll();

        return view('photo::index', compact('photos'));
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

        return view('photo::create');
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
            return redirect('photo')
                ->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();

        $this->_photoRepository->insert(DataHelper::_normalizeParams($request->all()));
        $this->_logHelper->store($this->module, $request->photo_name, 'create');
        DB::commit();


        return redirect('photo')->with('message', 'Gambar berhasil ditambahkan');
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

        return view('photo::show');
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

        return view('photo::edit');
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
            return redirect('photo')
                ->withErrors($validator)
                ->withInput();
        }
        DB::beginTransaction();
        $this->_photoRepository->update(DataHelper::_normalizeParams($request->all()), $id);
        $this->_logHelper->store($this->module, $request->photo_name, 'update');
        DB::commit();

        return redirect('photo')->with('message', 'Gambar berhasil diubah');
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

        $response = array('status' => 0, 'result' => array());

        // Check detail to db
        $detail  = $this->_photoRepository->getById($id);

        if (!$detail) {
            // return redirect('photo');
            $response['status'] = 0;
            $response['message'] = 'Data tidak ditemukan!';
        }else {
            DB::beginTransaction();
            $this->_photoRepository->delete($id);
            $this->_logHelper->store($this->module, $detail->photo_name, 'delete');
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
        $getDetail  = $this->_photoRepository->getById($id);

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
                'photo_name' => 'required|unique:photos',
            ];
        } else {
            return [
                'photo_name' => 'required|unique:photos,photo_name,' . $id . ',photo_id',
            ];
        }
    }
}
