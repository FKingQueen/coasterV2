<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bouy;
use App\Models\WaterLevel;
use Carbon\Carbon;

class HomeMonitoringSystemController extends Controller
{
    // Bouy
    public function getBouy($id){
        // $bouy = Bouy::where('bouy_id', $id)->orderBy('created_at', 'ASC')->get();
        // // return $bouy; z
        // for($i = 0; $i < count($bouy); $i++){
        //     $parse = $bouy[$i]->created_at->format('Y:m:d:H:i:s');
        //     $bouy[$i]->date = explode(':',$parse); 
        //     // $bouy[$i]->date[0] = $parse;
            
        // }

        $data = Bouy::where('bouy_id', $id)->orderBy('created_at', 'ASC')->get();

        $counter = 0;

        for ($i = 1; $i < count($data); $i++) {

            $tideData[] = [
                Carbon::parse($data[$i]->created_at)->valueOf(), // Converts to milliseconds
                floatval((round($data[$i]->altitude_pressure * 100) / 100) / 100)
            ];

            $airTempData[] = [
                Carbon::parse($data[$i]->created_at)->valueOf(), // Converts to milliseconds
                floatval(round($data[$i]->air_temperature * 100) / 100)
            ];

            $waterTempData[] = [
                Carbon::parse($data[$i]->created_at)->valueOf(), // Converts to milliseconds
                floatval(round($data[$i]->water_temperature * 100) / 100)
            ];

            $significantWaveHeightData[] = [
                Carbon::parse($data[$i]->created_at)->valueOf(), // Converts to milliseconds
                floatval(round($data[$i]->significant_wave_height * 100) / 100)
            ];

            $wavePeriodData[] = [
                Carbon::parse($data[$i]->created_at)->valueOf(), // Converts to milliseconds
                floatval(round($data[$i]->significant_wave_height * 100) / 100)
            ]; 

            $compassData[] = [
                Carbon::parse($data[$i]->created_at)->valueOf(), // Converts to milliseconds
                floatval(round($data[$i]->significant_wave_height * 100) / 100),
                floatval(round($data[$i]->compass * 100) / 100)
            ];
        }

        return response()->json([
            'tide'  =>  $tideData,
            'airTemp'  =>  $airTempData,
            'waterTemp'  =>  $waterTempData,
            'waveHeight'  =>  $significantWaveHeightData,
            'waveHeight'  =>  $significantWaveHeightData,
            'wavePeriod'  =>  $wavePeriodData,
            'compass'  =>  $compassData,
        ]);
    }
    // Water Level
    public function getWaterLevel($id){
        // return $id;
        // Fetch water level data ordered by created_at in ascending order
        // $wmls = WaterLevel::where('wlms_id', $id)->orderBy('created_at', 'ASC')->get();

        // $data = [];
        // $counter = 0;

        // // Iterate through the water level data
        // for ($i = 1; $i < count($wmls); $i++) {
        //     // Calculate the difference in level between consecutive records
        //     if($wmls[$i]->level != 0 ){
        //         $validated = $wmls[$i - 1]->level - $wmls[$i]->level;

        //         // Check if the difference is within the range
        //         if ($validated >= -0.50 && $validated <= 0.50) {
        //             // Store valid data in the array
    
        //             // Format the created_at date
        //             $parse = $wmls[$i]->created_at->format('Y:m:d:H:i:s');
        //             $wmls[$i]->date = explode(':', $parse);
    
        //             // Increment counter
        //             $data[$counter] = $wmls[$i];
        //             $counter++;
        //         }
        //     }
            
        // }


        $data = WaterLevel::where('wlms_id', $id)
        ->orderBy('created_at', 'ASC')
        ->get();

        $counter = 0;

        for ($i = 1; $i < count($data); $i++) {

            $temperatureData[] = [
                Carbon::parse($data[$i]->created_at)->valueOf(), // Converts to milliseconds
                floatval(round($data[$i]->temperature * 100) / 100)
            ];

            $humidityData[] = [
                Carbon::parse($data[$i]->created_at)->valueOf(), // Converts to milliseconds
                floatval(round($data[$i]->humidity * 100) / 100)
            ];

            // Skip if current level is 0
            if ($data[$i]->level == 0) continue;

            // Calculate the difference in level between consecutive records
            $validated = $data[$i - 1]->level - $data[$i]->level;

            // Check if the difference is within the range
            if ($validated >= -0.50 && $validated <= 0.50) {
                // Convert to the format similar to your original code
                $validatedLevelData[] = [
                    Carbon::parse($data[$i]->created_at)->valueOf(), // Converts to milliseconds
                    $id == 1 
                        ? floatval(round((13.5 - $data[$i]->level) * 100) / 100)
                        : ($id == 2 
                            ? floatval(round((26 - $data[$i]->level) * 100) / 100)
                            : floatval($data[$i]->level) // Default case if needed
                        )
                ];
            }
        }
            

        return response()->json([
            'level' => $validatedLevelData,
            'temperature' => $temperatureData,
            'humidity' => $humidityData
        ]);
        

        // $data = WaterLevel::where('wlms_id', $id)
        // ->orderBy('created_at', 'ASC')
        // ->get();

        // $validatedData = [];
        // $counter = 0;

        // for ($i = 1; $i < count($data); $i++) {
        //     // Skip if current level is 0
        //     if ($data[$i]->level == 0) continue;

        //     // Calculate the difference in level between consecutive records
        //     $validated = $data[$i - 1]->level - $data[$i]->level;

        //     // Check if the difference is within the range
        //     if ($validated >= -0.50 && $validated <= 0.50) {
        //         // Convert to the format similar to your original code
        //         $validatedData[] = [
        //             Carbon::parse($data[$i]->created_at)->valueOf(), // Converts to milliseconds
        //             $id == 1 
        //                 ? floatval(round((13.5 - $data[$i]->level) * 100) / 100)
        //                 : ($id == 2 
        //                     ? floatval(round((26 - $data[$i]->level) * 100) / 100)
        //                     : floatval($data[$i]->level) // Default case if needed
        //                 )
        //         ];
        //     }
        // }

        // // return response()->json($validatedData);

        // // Return the filtered data as JSON
        // return response()->json([
        //     'level' => $validatedLevelData,
        //     'temperature' => $temperatureData,
        //     'humidity' => $humidity
        // ]);
    }

}
