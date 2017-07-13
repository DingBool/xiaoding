<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class SettingController
 * @package App\Http\Controllers
 */
class SettingController extends Controller
{
    /**
     * SettingController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('users.setting');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
//        $setting = array();
//        $settings = \GuzzleHttp\json_encode(array_merge($setting,array_only($request->all(),['city','bio'])));//第一个参数不是数组，暂时怀疑是MySQL问题
//        可以用 json_encode() 方法来代替 $this->user->settings 方法
//        user()->update(['settings' => $settings]);
        user()->settings()->merge($request->all());
        return back();
    }

}
