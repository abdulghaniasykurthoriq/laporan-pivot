<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SekolahController extends Controller
{
    public function index(Request $request)
    {

        $tingkat = $request->input('sekolah');
        // dd($tingkat);
        $response = Http::get('https://tes-web.landa.id/sekolah.json');
        $data = $response->json();
        $dataByLevel = ["SMP" => [],"SMA" => [],"SMK" => []];
        foreach($data as $key => $data){
            $part = explode(" ", $key);
            $level = $part[0];
            $dataByLevel[$level][$key] = $data;
        }
        $data = $dataByLevel[$tingkat] ?? [];
        // $data = [];
        return view('advanced',compact(['data','tingkat']));
    }
}
