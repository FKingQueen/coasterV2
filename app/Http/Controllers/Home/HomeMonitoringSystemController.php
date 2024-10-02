<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bouy;
use App\Models\WaterLevel;

class HomeMonitoringSystemController extends Controller
{
    // Bouy
    public function getBouy($id){
        $bouy = Bouy::where('bouy_id', $id)->orderBy('created_at', 'ASC')->get();
        // return $bouy; 
        for($i = 0; $i < count($bouy); $i++){
            $parse = $bouy[$i]->created_at->format('Y:m:d:H:i:s');
            $bouy[$i]->date = explode(':',$parse); 
            // $bouy[$i]->date[0] = $parse;
        }
        return response()->json([
            'data'  =>  $bouy
        ]);
    }
    // Water Level
    public function getWaterLevel($id){
        // return $id;
        $wmls = WaterLevel::where('wlms_id', $id)->orderBy('created_at', 'ASC')->get();

        for($i = 0; $i < count($wmls); $i++){
            $parse = $wmls[$i]->created_at->format('Y:m:d:H:i:s');
            $wmls[$i]->date = explode(':',$parse); 
            // $wmls[$i]->date[0] = $parse;
        }
        return response()->json([
            'data'  =>  $wmls
        ]);
    }

}
