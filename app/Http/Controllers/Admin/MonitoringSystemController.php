<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bouy;
use App\Models\WaterLevel;

class MonitoringSystemController extends Controller
{
    // Bouy
    public function getBMSData()
    {
        $bms = Bouy::orderBy('id', 'desc')->get();

        for ($i = 0; $i < count($bms); $i++) {
            $bms[$i]->date = $bms[$i]->created_at->format('M d,Y-H:i:s');
        }

        return $bms;
    }

    public function deleteBMSData(Request $request)
    {
        $bouyData = Bouy::find($request->id);
        $bouyData->delete();
        return "Deleted";
    }

    public function getBouy($id)
    {
        $bouy = Bouy::where('bouy_id', $id)->orderBy('updated_at', 'ASC')->get();
        // return $bouy; 
        for ($i = 0; $i < count($bouy); $i++) {
            $parse = $bouy[$i]->updated_at->format('Y:m:d:H:i:s');
            $bouy[$i]->date = explode(':', $parse);
            // $bouy[$i]->date[0] = $parse;
        }
        return response()->json([
            'data'  =>  $bouy
        ]);
    }

    // Water Level
    public function getWLMSData()
    {
        $wlms = WaterLevel::orderBy('id', 'desc')->get();
        for ($i = 0; $i < count($wlms); $i++) {
            $wlms[$i]->date = $wlms[$i]->created_at->format('M d,Y-H:i:s');
        }
        return $wlms;
    }

    public function deleteWLMSData(Request $request)
    {
        $wlmsData = WaterLevel::find($request->id);
        $wlmsData->delete();
        return "Deleted";
    }
    public function getWaterLevel($id)
    {
        // return $id;
        $wmls = WaterLevel::where('wlms_id', $id)->orderBy('created_at', 'ASC')->get();

        for ($i = 0; $i < count($wmls); $i++) {
            $parse = $wmls[$i]->created_at->format('Y:m:d:H:i:s');
            $wmls[$i]->date = explode(':', $parse);
            // $wmls[$i]->date[0] = $parse;
        }
        return response()->json([
            'data'  =>  $wmls
        ]);
    }

    // public function getWaterLevel($id)
    // {
    //     // Get the latest record first
    //     $latestRecord = WaterLevel::where('wlms_id', $id)
    //         ->orderBy('created_at', 'DESC')
    //         ->first();

    //     if (!$latestRecord) {
    //         return response()->json([
    //             'data' => [],
    //             'message' => 'No data found'
    //         ]);
    //     }

    //     // Calculate 1 hour before the latest record
    //     $latestTime = $latestRecord->created_at;
    //     $oneHourBefore = $latestTime->copy()->subHour();

    //     // Get data from 1 hour before latest to latest
    //     $wmls = WaterLevel::where('wlms_id', $id)
    //         ->whereBetween('created_at', [$oneHourBefore, $latestTime])
    //         ->orderBy('created_at', 'ASC')
    //         ->get();

    //     // Transform the data
    //     for ($i = 0; $i < count($wmls); $i++) {
    //         $parse = $wmls[$i]->created_at->format('Y:m:d:H:i:s');
    //         $wmls[$i]->date = explode(':', $parse);
    //     }

    //     return response()->json([
    //         'data' => $wmls,
    //         'latest_timestamp' => $latestTime->timestamp * 1000, // For frontend use
    //         'range_start' => $oneHourBefore->timestamp * 1000,
    //         'total_records' => count($wmls)
    //     ]);
    // }
}
