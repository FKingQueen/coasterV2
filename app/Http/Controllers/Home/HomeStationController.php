<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bouy;
use App\Models\WaterLevel;
use DateTime;

class HomeStationController extends Controller
{
    public function getStationCurrentData(){
        $datas = [];
        
        // WLMS stations
        $datas[0] = WaterLevel::where('wlms_id', 1)->latest('created_at')->first();
        $datas[1] = WaterLevel::where('wlms_id', 2)->latest('created_at')->first();
        
        // BUOY stations (fixed typo in comment)
        $datas[2] = Bouy::where('bouy_id', 1)->latest('created_at')->first();
        $datas[3] = Bouy::where('bouy_id', 2)->latest('created_at')->first();
        
        // Format dates for each data point if it exists
        foreach($datas as $key => $data) {
            if ($data) {  // Check if data exists
                $timestamp = $data->created_at;  // Access created_at directly
                
                // Create a DateTime object from the timestamp
                $date = new DateTime($timestamp);
                
                // Set the desired format
                $data->formatted_date = $date->format('h:i A, F d, Y');
            }
        }
        
        return $datas;  // Return the full array, not just the last item
    }
}
