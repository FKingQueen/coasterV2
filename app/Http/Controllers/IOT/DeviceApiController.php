<?php

namespace App\Http\Controllers\IOT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bouy;
use App\Models\WaterLevel;
use App\Models\BuoyVersionTwo;
use Carbon\Carbon;

class DeviceApiController extends Controller
{
    public function storeDataWLMS(Request $request) {
        
        $newWlms = new WaterLevel;
        $newWlms->wlms_id = $request->id;
        $newWlms->level = $request->wl;
        $newWlms->temperature = $request->temp;
        $newWlms->humidity = $request->hum;

        // Date Time
        $datetimeString = $request->dateTime;
        $datetimeString = substr($datetimeString, 0, 14); // '24/09/20,09:12'

        $datetime = Carbon::createFromFormat('y/m/d,H:i', $datetimeString);

        $newWlms->created_at = $datetime;

        $newWlms->save();

        if($newWlms->save()){
            return response()->json([
                'id' => $newWlms->wlms_id,
                'waterLevel' => $newWlms->wl,
                'temperature' => $newWlms->temperature,
                'humidity' => $newWlms->humidity,
                'dateTime' => $newWlms->created_at,
            ]);
        } else {
            return $request;
        }
    }

    public function storeDataBMS(Request $request){
        return $request;
        // Example input from request
        // $rawData = $request->data; 
        // e.g., "T25:07:45Z24:0.11,0.03,0.05,0.11,..."

        // $newBuoyData->water_temperature = $request->wt;
        // $newBuoyData->barometric_temperature = $request->bt;
        // $newBuoyData->ultrasonic = $request->th;
        // $newBuoyData->altitude_pressure = $request->ap;
        // $newBuoyData->compass = $request->hd;
        // $newBuoyData->significant_wave_height = $request->swh;
        // $newBuoyData->wave_period = $request->wp;

        // // Date Time
        // $datetimeString = $request->dateTime;
        // $datetimeString = substr($datetimeString, 0, 14); // '24/09/20,09:12'

        // $datetime = Carbon::createFromFormat('y/m/d,H:i', $datetimeString);

        // $newBuoyData->created_at = $datetime;

        // $newBuoyData->save();

        // if($newBuoyData->save()){
        //     return response()->json([
        //         'id' => $newBuoyData->bouy_id,
        //         'air temperature' => $newBuoyData->data,
        //     ]);
        // } else {
        //     return $request;
        // }

        
    }
}
