<?php
/**
 * Created by PhpStorm.
 * User: m_sea
 * Date: 25/11/2018
 * Time: 21:24
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SearchController extends Controller
{

    public function index() {
        return view('search');
    }


    public function show(Request $request) {
        $searchValue = $request->input('search');
        $mediaType = $request->input('media_type');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://images-api.nasa.gov/search?q=" . urlencode($searchValue) . '&media_type=' . $mediaType);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $results = json_decode(curl_exec($ch), true);

        $return = [];

        foreach ($results['collection']['items'] as $key => $item) {
            switch ($item['data'][0]['media_type']) {
                case 'audio':
                    curl_setopt($ch, CURLOPT_URL, $item['href']);
                    $return[] = [
                        'type' => 'audio',
                        'nasa_id' => $item['data'][0]['nasa_id'],
                        'link' => json_decode(curl_exec($ch), true)[0]
                    ];
                    break;
                case 'image':
                    $return[] = [
                        'type' => 'image',
                        'nasa_id' => $item['data'][0]['nasa_id'],
                        'link' => $item['links'][0]['href']
                    ];
            }
        }
        header('Content-Type: application/json');
        echo json_encode($return);
        exit();
    }

}