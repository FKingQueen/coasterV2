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
        // return $bouy; z
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
        // Fetch water level data ordered by created_at in ascending order
        $wmls = WaterLevel::where('wlms_id', $id)->orderBy('created_at', 'ASC')->get();

        $data = [];
        $counter = 0;

        // Iterate through the water level data
        for ($i = 1; $i < count($wmls); $i++) {
            // Calculate the difference in level between consecutive records
            if($wmls[$i]->level != 0 ){
                $validated = $wmls[$i - 1]->level - $wmls[$i]->level;

                // Check if the difference is within the range
                if ($validated >= -0.50 && $validated <= 0.50) {
                    // Store valid data in the array
    
                    // Format the created_at date
                    $parse = $wmls[$i]->created_at->format('Y:m:d:H:i:s');
                    $wmls[$i]->date = explode(':', $parse);
    
                    // Increment counter
                    $data[$counter] = $wmls[$i];
                    $counter++;
                }
            }
            
        }

        // Return the filtered data as JSON
        return response()->json([
            'data' => $data
        ]);
    }

}
