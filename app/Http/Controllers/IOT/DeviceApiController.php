<?php

namespace App\Http\Controllers\IOT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bouy;
use App\Models\WaterLevel;

class DeviceApiController extends Controller
{
    public function storeDataWLMS(Request $request) {
        return $request;
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
                    $newWlms->level = $request->level;
                    $newWlms->temperature = $request->temp;
                    $newWlms->humidity = $request->hum;
                    $newWlms->save();
    
                    return response()->json([
                        'ID' => $request->id,
                        'waterLevel' => $validated >= -0.50 && $validated <= 0.50,
                        'temperature' => $request->temp,
                        'humidity' => $request->hum,
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
            $newWlms->save();
    
            return response()->json([
                'ID' => $request->id,
                'waterLevel' => $request->level,
                'temperature' => $request->temp,
                'humidity' => $request->hum,
            ]);
        }
    }

    public function storeDataBMS(Request $request){

        return $request;
    }
}
