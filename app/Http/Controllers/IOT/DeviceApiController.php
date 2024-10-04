<?php

namespace App\Http\Controllers\IOT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bouy;
use App\Models\WaterLevel;
use Carbon\Carbon;

class DeviceApiController extends Controller
{
    public function storeDataWLMS(Request $request) {
        // return $request;
        $count = WaterLevel::where('wlms_id', $request->id)->count();
    
        if ($count > 0) {
            // Data exists for the given wlms_id
            if ($request->level != 0) {

                $latestData = WaterLevel::where('wlms_id', $request->id)->latest()->first();

                $validated = $latestData->level - $request->level;

                if ($validated >= -0.50 && $validated <= 0.50) {
                    // Save new data
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
    
                    return response()->json([
                        'ID' => $request->id,
                        'waterLevel' => $newWlms->level,
                        'temperature' => $newWlms->temperature,
                        'humidity' => $newWlms->humidity,
                        'dateTime' => $newWlms->created_at,
                    ]);
                } else {
                    return response()->json([
                        'error' => "Water level data is invalid."
                    ]);
                }
            } else {
                return response()->json([
                    'error' => "Water level data is invalid."
                ]);
            }
        } else {
            // No data for the given wlms_id, save new data
            $newWlms = new WaterLevel;
            $newWlms->wlms_id = $request->id;
            $newWlms->level = $request->level;
            $newWlms->temperature = $request->temp;
            $newWlms->humidity = $request->hum;

            // Date Time
            $datetimeString = $request->dateTime;
            $datetimeString = substr($datetimeString, 0, 14); // '24/09/20,09:12'

            $datetime = Carbon::createFromFormat('y/m/d,H:i', $datetimeString);

            $newWlms->created_at = $datetime;

            $newWlms->save();
    
            return response()->json([
                'ID' => $request->id,
                'waterLevel' => $newWlms->level,
                'temperature' => $newWlms->temperature,
                'humidity' => $newWlms->humidity,
                'dateTime' => $newWlms->created_at,
            ]);
        }
    }

    public function storeDataBMS(Request $request){
        
        if($request->id == 3){
            return;
        }

        $newBuoyData = new Bouy;
        $newBuoyData->bouy_id = $request->id;
        $newBuoyData->air_temperature = $request->at;
        $newBuoyData->water_temperature = $request->wt;
        $newBuoyData->barometric_temperature = $request->bt;
        $newBuoyData->ultrasonic = $request->th;
        $newBuoyData->altitude_pressure = $request->ap;
        $newBuoyData->compass = $request->hd;
        $newBuoyData->significant_wave_height = $request->swh;
        $newBuoyData->wave_period = $request->wp;
        // if (!is_numeric($request->wp)) {
        //     $newBuoyData->wave_period = null; // Set to null if it's a string
        // } else {
        //     $newBuoyData->wave_period = 123;
        // }

        // Date Time
        $datetimeString = $request->dateTime;
        $datetimeString = substr($datetimeString, 0, 14); // '24/09/20,09:12'

        $datetime = Carbon::createFromFormat('y/m/d,H:i', $datetimeString);

        $newBuoyData->created_at = $datetime;

        $newBuoyData->save();

        if($newBuoyData->save()){
            return response()->json([
                'id' => $newBuoyData->bouy_id,
                'air temperature' => $newBuoyData->air_temperature,
                'water temperature' => $newBuoyData->water_temperature,
                'barometric temperature' => $newBuoyData->barometric_temperature,
                'ultrasonic' => $newBuoyData->ultrasonic,
                'altitude' => $newBuoyData->altitude_pressure,
                'compass' => $newBuoyData->compass,
                'significant wave height' => $newBuoyData->significant_wave_height,
                'wave period' => $newBuoyData->wave_period,
                'date time' => $newBuoyData->created_at,
            ]);
        } else {
            return $request;
        }

        
    }
}
