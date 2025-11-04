<?php

namespace App\Http\Controllers\IOT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bouy;
use App\Models\WaterLevel;
use App\Models\Tide;
use App\Models\BuoyVersionTwo;
use Carbon\Carbon;

class DeviceApiController extends Controller
{
    public function storeDataWLMS(Request $request) {

        // 25/10/24,15:43:00+32+3.56+35.6+67.9+19+2.5#S+19.04+0+03:01:01:00:10:33
        // 25/10/24 = Date, 25 is Year, 10 is Month, 24 is Day
        // 15:43:00 = Time
        // 3.56 = Level
        // 35.6 = Temperature
        // 67.9 = Humidity

        // extract data from request
        $dataString = $request->data; // "25/10/24,15:43:00+32+3.56+35.6+67.9+19+2.5#S+19.04+0+03:01:01:00:10:33"
        $dataParts = explode('+', $dataString);
        $dateTimeString = $dataParts[0]; // "25/10/24,15:43:00"
        $level = floatval($dataParts[2]); // 3.56
        $temperature = floatval($dataParts[3]); // 35.6
        $humidity = floatval($dataParts[4]); // 67.9
        // parse date and time
        $dateTimeParts = explode(',', $dateTimeString);
        $datePart = $dateTimeParts[0]; // "25/10/24
        $timePart = $dateTimeParts[1]; // "15:43:00"
        $dateComponents = explode('/', $datePart);
        $year = 2000 + intval($dateComponents[0]); // 2024
        $month = intval($dateComponents[1]); // 10
        $day = intval($dateComponents[2]); // 24
        $timeComponents = explode(':', $timePart);
        $hour = intval($timeComponents[0]); // 15
        $minute = intval($timeComponents[1]); // 43
        $second = intval($timeComponents[2]); // 00
        $dateTime = Carbon::create($year, $month, $day, $hour, $minute, $second);
        

        // create new WaterLevel instance
        $newWlms = new WaterLevel;
        $newWlms->wlms_id = $request->id;
        $newWlms->level = $level;
        $newWlms->temperature = $temperature;
        $newWlms->humidity = $humidity;
        $newWlms->created_at = $dateTime;
        $newWlms->save();
        if($newWlms->save()){
            return response()->json([
                'id' => $newWlms->wlms_id,
                'waterLevel' => $newWlms->level,
                'temperature' => $newWlms->temperature,
                'humidity' => $newWlms->humidity,
                'dateTime' => $newWlms->created_at,
            ]);
        } else {
            return $request;
        }
    }

    public function storeTideData(Request $request){
        // Example input from request
        // 3.67+24.12+10-20-2025+10:05
        // 3.67 = tide height in cm
        // 24.12 = temperature in Celsius
        // 10-20-2025 = date
        // 10:05 = time
        $dataString = $request->data; // "3.67+24.12+10-20-2025+10:05"
        $dataParts = explode('+', $dataString);
        $tideHeight = floatval($dataParts[0]);
        $temperature = floatval($dataParts[1]);
        $date = Carbon::createFromFormat('m-d-Y', $dataParts[2]);
        $time = Carbon::createFromFormat('H:i', $dataParts[3]);
        $dateTime = Carbon::create(
            $date->year,
            $date->month,
            $date->day,
            $time->hour,
            $time->minute,
            0
        );
        $newTide = new Tide;
        $newTide->tide_height_cm = $tideHeight;
        $newTide->temperature = $temperature;
        $newTide->created_at = $dateTime;
        $newTide->save();
        if($newTide->save()){
            return response()->json([
                'tide_height_cm' => $newTide->tide_height_cm,
                'temperature' => $newTide->temperature,
                'dateTime' => $newTide->created_at,
            ]);
        } else {
            return $request;
        }
    }

    public function storeDataBMS(Request $request){

        $dataString = $request->data; // "3.67+24.12+10-20-2025+10:05"
        $dataParts = explode('+', $dataString);
        $tideHeight = floatval($dataParts[0]);
        $temperature = floatval($dataParts[1]);
        $date = Carbon::createFromFormat('m-d-Y', $dataParts[2]);
        $time = Carbon::createFromFormat('H:i', $dataParts[3]);
        $dateTime = Carbon::create(
            $date->year,
            $date->month,
            $date->day,
            $time->hour,
            $time->minute,
            0
        );
        $newTide = new Tide;
        $newTide->buoy_id = 1;
        $newTide->tide_height_cm = $tideHeight;
        $newTide->temperature = $temperature;
        $newTide->created_at = $dateTime;
        $newTide->save();
        if($newTide->save()){
            return response()->json([
                'tide_height_cm' => $newTide->tide_height_cm,
                'temperature' => $newTide->temperature,
                'dateTime' => $newTide->created_at,
            ]);
        } else {
            return $request;
        }
    }
}
