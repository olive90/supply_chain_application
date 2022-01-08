<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index(Request $request){
        // $response = Http::post('localhost:3000/queryblock', [
        //     'key' => '1'
        // ]);
        //Http::fake();
        $response = Http::get('localhost:3000/getblocks');
        $data = $response->json();

        $prepareData = array();
        foreach($data as $value){
            foreach($value as $key => $val){
                
                $prepareData[$key] = $val['Record'];
            }
        }
//         echo '<pre>';print_r($prepareData);
// die;
        //echo $data['AllData'];die;
        //echo '<pre>';print_r($data['AllData'][0]['Record']['DeliveryDate']);die;
        
        return view('welcome', ['allData' => $prepareData]);
        
    }
}
