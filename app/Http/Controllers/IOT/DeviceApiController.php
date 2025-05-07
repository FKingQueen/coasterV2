<?php

namespace App\Http\Controllers\IOT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bouy;
use App\Models\WaterLevel;
use App\Models\BuoySegment;
use App\Models\BuoySession;
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

        // Example input from request
        $rawData = $request->data; 
        // e.g., "T25:07:45Z24:0.11,0.03,0.05,0.11,..."

        // Step 1: Parse timestamp part (e.g., T25:07:45)
        if (!preg_match('/T(\d+):(\d+):(\d+)Z(\d+):(.+)/', $rawData, $matches)) {
            return response()->json(['error' => 'Invalid data format'], 400);
        }

        $year = 2000 + intval($matches[1]);         // T25 → 2025
        $dayOfYear = intval($matches[2]);           // 07
        $minuteOfDay = intval($matches[3]);         // 45
        $startIndex = intval($matches[4]);          // Z24
        $valuesStr = $matches[5];                   // 0.11,0.03,...

        // Step 3: Find or create the session
        $session = BuoySession::firstOrCreate([
            'year' => $year,
            'day_of_year' => $dayOfYear,
            'minute_of_day' => $minuteOfDay,
        ]);

        // Step 4: Insert segment (avoid duplicates)
        $segment = BuoySegment::updateOrCreate(
            [
                'session_id' => $session->id,
                'start_index' => $startIndex,
            ],
            [
                'values' => $valuesStr,
            ]
        );

        return response()->json(['message' => 'Data saved successfully']);

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
