<?php

namespace Modules\MenuSetting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Storage;

use Modules\MenuSetting\Repositories\MenuSettingRepository;
use App\Helpers\DataHelper;
use App\Helpers\LogHelper;
use DB;
use Validator;

class MenuSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->_menusettingRepository = new MenuSettingRepository;
        $this->_logHelper           = new LogHelper;
        $this->module               = "MenuSetting";
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

        $menusettings = $this->_menusettingRepository->getAll();

        return view('menusetting::index', compact('menusettings'));
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

        return view('menusetting::create');
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
            return redirect('menu-setting')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        $this->_menusettingRepository->insert(DataHelper::_normalizeParams($request->all(), true));
        $this->_logHelper->store($this->module, $request->menu_setting_name, 'create');
        DB::commit();

        return redirect('menu-setting')->with('message', 'Pengaturan menu berhasil ditambahkan');
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

        return view('menusetting::show');
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

        return view('menusetting::edit');
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
            return redirect('menu-setting')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        $this->_menusettingRepository->update(DataHelper::_normalizeParams($request->all(), false, true), $id);
        $this->_logHelper->store($this->module, $request->menu_setting_name, 'update');

        DB::commit();

        return redirect('menu-setting')->with('message', 'Pengaturan menu berhasil diubah');
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
        $detail  = $this->_menusettingRepository->getById($id);

        if (!$detail) {
            return redirect('menu-setting');
        }

        DB::beginTransaction();

        $this->_menusettingRepository->delete($id);
        $this->_logHelper->store($this->module, $detail->menu_setting_name, 'delete');

        DB::commit();

        return redirect('menu-setting')->with('message', 'Pengaturan menu berhasil dihapus');
    }

    /**
     * Get data the specified resource in storage.
     * @param int $id
     * @return Response
     */
    public function getdata($id)
    {
        $response   = array('status' => 0, 'result' => array());
        $getDetail  = $this->_menusettingRepository->getById($id);

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
                'menu_setting_name' => 'required',
            ];
        } else {
            return [
                'menu_setting_name' => 'required',
            ];
        }
    }
}
