<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bouy;
use App\Models\WaterLevel;
use App\Models\Tide;
use Carbon\Carbon;

class HomeMonitoringSystemController extends Controller
{
    // Bouy
    public function getBouy($id)
    {
        // $bouy = Bouy::where('bouy_id', $id)->orderBy('created_at', 'ASC')->get();
        // // return $bouy; z
        // for($i = 0; $i < count($bouy); $i++){
        //     $parse = $bouy[$i]->created_at->format('Y:m:d:H:i:s');
        //     $bouy[$i]->date = explode(':',$parse); 
        //     // $bouy[$i]->date[0] = $parse;

        // }

        $data = Bouy::where('bouy_id', $id)->orderBy('created_at', 'ASC')->get();

        $data1 = Tide::where('buoy_id', $id)->orderBy('created_at', 'ASC')->get();

        for ($i = 1; $i < count($data1); $i++) {

            $datetime = new \DateTime($data1[$i]->created_at->format('Y-m-d H:i:s'), new \DateTimeZone('UTC'));
            $milliseconds = $datetime->getTimestamp() * 1000;

            $tideData[] = [
                $milliseconds, // Converts to milliseconds
                floatval(round($data1[$i]->tide_height_cm * 100) / 100)
            ];

            $temperatureData[] = [
                $milliseconds, // Converts to milliseconds
                floatval(round($data1[$i]->temperature * 100) / 100)
            ];
        }



        $counter = 0;

        for ($i = 1; $i < count($data); $i++) {

            // $tideData[] = [
            //     Carbon::parse($data[$i]->created_at)->valueOf(), // Converts to milliseconds
            //     floatval((round($data[$i]->altitude_pressure * 100) / 100) / 100)
            // ];

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
                floatval(round($data[$i]->wave_period * 100) / 100)
            ];

            $compassData[] = [
                Carbon::parse($data[$i]->created_at)->valueOf(), // Converts to milliseconds
                floatval(round($data[$i]->significant_wave_height * 100) / 100),
                floatval(round($data[$i]->compass * 100) / 100)
            ];
        }



        return response()->json([
            'tide'  =>  $tideData,
            'temperature'  =>  $temperatureData,
            'airTemp'  =>  $airTempData,
            'waterTemp'  =>  $waterTempData,
            'waveHeight'  =>  $significantWaveHeightData,
            'wavePeriod'  =>  $wavePeriodData,
            'compass'  =>  $compassData,
        ]);
    }
    // Water Level
    public function getWaterLevel($id)
    {

        $data = WaterLevel::where('wlms_id', $id)
            ->orderBy('created_at', 'ASC')
            ->get();

        $temperatureData = [];
        $humidityData = [];
        $validatedLevelData = [];

        for ($i = 1; $i < count($data); $i++) {

            $datetime = new \DateTime($data[$i]->created_at->format('Y-m-d H:i:s'), new \DateTimeZone('UTC'));
            $milliseconds = $datetime->getTimestamp() * 1000;


            $temperatureData[] = [
                $milliseconds, // Converts to milliseconds
                floatval(round($data[$i]->temperature * 100) / 100)
            ];

            $humidityData[] = [
                $milliseconds, // Converts to milliseconds
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
                    $milliseconds, // Converts to milliseconds
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
    }

    public function getWaterLevelLatest($id)
    {

        $data = WaterLevel::where('wlms_id', $id)
            ->orderBy('created_at', 'DESC')
            ->first();

        $temperatureData = null;
        $humidityData = null;
        $validatedLevelData = null;

        if ($data) {
            $datetime = new \DateTime($data->created_at->format('Y-m-d H:i:s'), new \DateTimeZone('UTC'));
            $milliseconds = $datetime->getTimestamp() * 1000;

            $temperatureData = [
                $milliseconds, // Converts to milliseconds
                floatval(round($data->temperature * 100) / 100)
            ];

            $humidityData = [
                $milliseconds, // Converts to milliseconds
                floatval(round($data->humidity * 100) / 100)
            ];

            if ($data->level != 0) {
                $validatedLevelData = [
                    $milliseconds, // Converts to milliseconds
                    $id == 1
                        ? floatval(round((13.5 - $data->level) * 100) / 100)
                        : ($id == 2
                            ? floatval(round((26 - $data->level) * 100) / 100)
                            : floatval($data->level) // Default case if needed
                        )
                ];
            }
        }

        return response()->json([
            'level' => $validatedLevelData,
            'temperature' => $temperatureData,
            'humidity' => $humidityData
        ]);
    }

    public function getBuoyLatest($id)
    {

        $data = Tide::where('buoy_id', $id)
            ->orderBy('created_at', 'DESC')
            ->first();

        $tideData = null;
        $temperatureData = null;

        if ($data) {
            $datetime = new \DateTime($data->created_at->format('Y-m-d H:i:s'), new \DateTimeZone('UTC'));
            $milliseconds = $datetime->getTimestamp() * 1000;

            $temperatureData = [
                $milliseconds, // Converts to milliseconds
                floatval(round($data->temperature * 100) / 100)
            ];

            $tideData = [
                $milliseconds, // Converts to milliseconds
                floatval(round($data->tide_height_cm * 100) / 100)
            ];
        }

        return response()->json([
            'tide' => $tideData,
            'temperature' => $temperatureData
        ]);
    }
}
