<?php
/**
 * Created by PhpStorm.
 * User: m_sea
 * Date: 25/11/2018
 * Time: 12:30
 */

namespace App\Http\Controllers;


class AssetController extends Controller
{

    /**
     * AssetController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index($id = null) {
        $data['data'] = json_decode(file_get_contents('https://images-assets.nasa.gov/image/' . $id . '/metadata.json'), true);
        $data['img'] = json_decode(file_get_contents('https://images-api.nasa.gov/asset/' . $id ), true);
        return view('asset', $data);
    }

}