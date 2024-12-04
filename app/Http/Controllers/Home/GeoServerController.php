<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeoServerController extends Controller
{
    public function getGeoserverData(Request $request){
        // return $request;
        $url = 'http://localhost:3655/geoserver/cite/wms?' . http_build_query($request->all());
        // return $url;
        $response = Http::get($url);
        
        return response()->json($response->json());
    }

    public function proxyMVT($z, $x, $y)
    {
        $mvtUrl = "http://localhost:3655/geoserver/gwc/service/tms/1.0.0/ne:Ilocos_Norte_EPR_1977-2022@EPSG:3857@pbf/{$z}/{$x}/{$y}.pbf";
        
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/x-protobuf'
            ])->get($mvtUrl);

            if ($response->successful()) {
                return response($response->body(), 200)
                    ->header('Content-Type', 'application/x-protobuf');
            } else {
                return response()->json([
                    'error' => 'Failed to fetch MVT',
                    'status' => $response->status()
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
