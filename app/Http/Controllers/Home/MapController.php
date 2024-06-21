<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Shapefile\ShapefileReader;
use Shapefile\ShapefileException;


class MapController extends Controller
{
    public function getLayerData(Request $request){
        if($request->layerName == 'epr' || $request->layerName == 'nsm'){
            if($request->layerName == 'epr'){
                $geojsonContent = file_get_contents(public_path('shapefile/Region1_EPR.geojson'));
                $geojsonData = json_decode($geojsonContent);
            }
            if($request->layerName == 'nsm'){
                $geojsonContent = file_get_contents(public_path('shapefile/Region1_NSM.geojson'));
                $geojsonData = json_decode($geojsonContent);
            }
        }

        $properties = [];

        foreach ($geojsonData->features as $key => $feature) {
            $properties[$key] = $feature->properties;
        }

        $Options = [];

        // Iterate over each feature to extract the 'NAME_2' property
        foreach ($geojsonData->features as $feature) {
            // Check if the feature has 'properties' and 'NAME_1' property
            if (isset($feature->properties->NAME_1)) {
                // Add the 'NAME_1' value to the $Options array
                $Options[] = [
                    'value' => $feature->properties->NAME_1,
                    'label' => $feature->properties->NAME_1
                ];
            }
        }
        
        // Remove duplicate values and re-index the array
        $Options = array_values(array_unique($Options, SORT_REGULAR));

        $chartData = [];
        foreach ($Options as $index => $value) {
            // Initialize counters for each trend
            $accretionCount = 0;
            $erosionCount = 0;
            $stableCount = 0;
        
            // Iterate over features to count occurrences of each trend
            foreach ($geojsonData->features as $feature) {
                // Use $value from the outer loop
                if ($feature->properties->NAME_1 === $value['value']) {
                    // Increment counters based on EPR trend
                    if($request->layerName == 'epr'){
                        switch ($feature->properties->EPR_trend) {
                            case 'accretion':
                                $accretionCount++;
                                break;
                            case 'erosion':
                                $erosionCount++;
                                break;
                            case 'stable':
                                $stableCount++;
                                break;
                        }
                    }
                    if($request->layerName == 'nsm'){
                        switch ($feature->properties->NSM_trend) {
                            case 'accretion':
                                $accretionCount++;
                                break;
                            case 'erosion':
                                $erosionCount++;
                                break;
                            case 'stable':
                                $stableCount++;
                                break;
                        }
                    }
                }
            }
        
            // Calculate percentages
            $totalFeaturesCount = count($geojsonData->features);
            $x = $accretionCount;
            $z = $erosionCount;
            $t = $stableCount;
        
            // Create chart data object
            $gData = [
                'name' => $value['value'],
                'y' => round((($x + $t + $z) / $totalFeaturesCount) * 100, 2), // Calculate the 't' value as the remainder
                'x' => round(($x / ($x + $t + $z)) * 100, 2),
                'z' => round(($z / ($x + $t + $z)) * 100, 2),
                't' => round(($t / ($x + $t + $z)) * 100, 2),
            ];
        
            // Store the chart data for this value in the array
            $chartData[$index] = $gData;
        }

        $Region1_Province = file_get_contents(public_path('shapefile/Region1_Province.geojson'));

        if ($geojsonData) {
            return response()->json([
                'chartData' => $chartData,
                'Options' => $Options,
                'data' => $geojsonData,
                'Region1_Province' => json_decode($Region1_Province, true),
                'properties' => $properties,
            ]);
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }
    
    public function getProvinceData(Request $request){

        if($request->layerName == 'epr' || $request->layerName == 'nsm'){
            if($request->layerName == 'epr'){
                $geojsonContent = file_get_contents(public_path('shapefile/Region1_EPR.geojson'));
                $geojsonData = json_decode($geojsonContent);
            }
            if($request->layerName == 'nsm'){
                $geojsonContent = file_get_contents(public_path('shapefile/Region1_NSM.geojson'));
                $geojsonData = json_decode($geojsonContent);
            }
        }

        // Filter features based on the NAME_1 property equal to "Ilocos Norte"
        $provinceName = $request->provinceName;
        $filteredFeatures = array_filter($geojsonData->features, function($feature) use ($provinceName) {
            return isset($feature->properties->NAME_1) && $feature->properties->NAME_1 === $provinceName;
        });

        $newArray = [];
        $i = 0;
        foreach ($filteredFeatures as $index => $value) {
            $newArray[$i] = $value;
            $i++;
        }  

        // Construct GeoJSON FeatureCollection
        $geojsonProvinceData = [
            'type' => 'FeatureCollection',
            'features' => $newArray,
        ];


        $properties = [];
        $Options = [];

        // Iterate over each feature to extract the 'NAME_2' property
        foreach ($geojsonProvinceData['features'] as $key => $feature) {
            // Check if the feature has 'properties' and 'NAME_1' property
            if (isset($feature->properties->NAME_2)) {
                // Add the 'NAME_1' value to the $Options array
                $Options[] = [
                    'value' => $feature->properties->NAME_2,
                    'label' => $feature->properties->NAME_2
                ];
            }
            $properties[$key] = $feature->properties;
        }
        
        // Remove duplicate values and re-index the array
        $Options = array_values(array_unique($Options, SORT_REGULAR));

        // getting the boundary PROVINCE
        $Region1_Province = file_get_contents(public_path('shapefile/Region1_Province.geojson'));
        $Region1_Province_GeojsonData = json_decode($Region1_Province);

        $filteredFeatures = array_filter($Region1_Province_GeojsonData->features, function($feature) use ($provinceName) {
            return isset($feature->properties->NAME_1) && $feature->properties->NAME_1 === $provinceName;
        });
        
        $newArray = [];
        $i = 0;
        foreach ($filteredFeatures as $index => $value) {
            $newArray[$i] = $value;
            $i++;
        }        

        $Region1_Province_GeojsonData = [
            'type' => 'FeatureCollection',
            'features' => $newArray,
        ];

        // getting the boundary Municipality
        $Region1_MuniCities = file_get_contents(public_path('shapefile/Region1_MuniCities.geojson'));
        $Region1_MuniCities_GeojsonData = json_decode($Region1_MuniCities);

        // Initialize an array to store filtered features
        $filteredFeatures = [];

        // Iterate over each option
        foreach ($Options as $index => $value) {
            $MuniCities = $value['value'];

            // Filter features based on provinceName and MuniCities
            $filteredFeatures[$index] = array_filter($Region1_MuniCities_GeojsonData->features, function($feature) use ($provinceName, $MuniCities) {
                return isset($feature->properties->NAME_1) && $feature->properties->NAME_1 === $provinceName && isset($feature->properties->NAME_2) && $feature->properties->NAME_2 === $MuniCities;
            });
        }

        $mergedFeatures = [];
        foreach ($filteredFeatures as $features) {
            $mergedFeatures = array_merge($mergedFeatures, $features);
        }

        $Region1_MuniCities_GeojsonData = [
            'type' => 'FeatureCollection',
            'features' => $mergedFeatures,
        ];


        $chartData = [];
        foreach ($Options as $index => $value) {
            // Initialize counters for each trend
            $accretionCount = 0;
            $erosionCount = 0;
            $stableCount = 0;
        
            // Iterate over features to count occurrences of each trend
            foreach ($geojsonProvinceData['features'] as $feature) {
                // Use $value from the outer loop
                if ($feature->properties->NAME_2 === $value['value']) {
                    // Increment counters based on trend
                    if ($request->layerName == 'epr' && isset($feature->properties->EPR_trend)) {
                        switch ($feature->properties->EPR_trend) {
                            case 'accretion':
                                $accretionCount++;
                                break;
                            case 'erosion':
                                $erosionCount++;
                                break;
                            case 'stable':
                                $stableCount++;
                                break;
                        }
                    } elseif ($request->layerName == 'nsm' && isset($feature->properties->NSM_trend)) {
                        switch ($feature->properties->NSM_trend) {
                            case 'accretion':
                                $accretionCount++;
                                break;
                            case 'erosion':
                                $erosionCount++;
                                break;
                            case 'stable':
                                $stableCount++;
                                break;
                        }
                    }
                }
            }
        
            // Calculate percentages
            $totalFeaturesCount = count($geojsonProvinceData['features']);
            $x = $accretionCount;
            $z = $erosionCount;
            $t = $stableCount;
        
            // Create chart data object
            $gData = [
                'name' => $value['value'],
                'y' => round((($x + $t + $z) / $totalFeaturesCount) * 100, 2), // Calculate the 't' value as the remainder
                'x' => round(($x / ($x + $t + $z)) * 100, 2),
                'z' => round(($z / ($x + $t + $z)) * 100, 2),
                't' => round(($t / ($x + $t + $z)) * 100, 2),
            ];
        
            // Store the chart data for this value in the array
            $chartData[$index] = $gData;
        }

        if ($geojsonProvinceData) {
            return response()->json([
                'chartData' => $chartData,
                'Region1_MuniCities_GeojsonData' => $Region1_MuniCities_GeojsonData,
                'Region1_Province_GeojsonData' => $Region1_Province_GeojsonData,
                'data' => $geojsonProvinceData,
                'Options' => $Options,
                'properties' => $properties,
            ]);
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }

        return 'success';
    }

    public function getMunicipalitiesData(Request $request){
        if($request->layerName == 'epr' || $request->layerName == 'nsm'){
            if($request->layerName == 'epr'){
                $geojsonContent = file_get_contents(public_path('shapefile/Region1_EPR.geojson'));
                $geojsonData = json_decode($geojsonContent);
            }
            if($request->layerName == 'nsm'){
                $geojsonContent = file_get_contents(public_path('shapefile/Region1_NSM.geojson'));
                $geojsonData = json_decode($geojsonContent);
            }
        }

        // Filter features based on the NAME_1 property equal to "Ilocos Norte"
        $provinceName = $request->provinceName;
        $muniName = $request->muniName;
        $filteredFeatures = array_filter($geojsonData->features, function($feature) use ($provinceName, $muniName) {
            return isset($feature->properties->NAME_1) && $feature->properties->NAME_1 === $provinceName && $feature->properties->NAME_2 === $muniName;
        });

        $newArray = [];
        $i = 0;
        foreach ($filteredFeatures as $index => $value) {
            $newArray[$i] = $value;
            $i++;
        }  

        // Construct GeoJSON FeatureCollection
        $geojsonMuniData = [
            'type' => 'FeatureCollection',
            'features' => $newArray,
        ];

        
        $properties = [];
        $Options = [];

        // Iterate over each feature to extract the 'NAME_2' property
        foreach ($geojsonMuniData['features'] as $key => $feature) {
            // Check if the feature has 'properties' and 'NAME_1' property
            if (isset($feature->properties->NAME_3)) {
                // Add the 'NAME_1' value to the $Options array
                $Options[] = [
                    'value' => $feature->properties->NAME_3,
                    'label' => $feature->properties->NAME_3
                ];
            }
            $properties[$key] = $feature->properties;
        }
        
        // Remove duplicate values and re-index the array
        $Options = array_values(array_unique($Options, SORT_REGULAR));

        // getting the boundary Municipality
        $Region1_MuniCities = file_get_contents(public_path('shapefile/Region1_MuniCities.geojson'));
        $Region1_MuniCities_GeojsonData = json_decode($Region1_MuniCities);

        // Initialize an array to store filtered features
        $filteredFeatures = [];

        // Iterate over each option

        // Filter features based on provinceName and MuniCities and Barangays
        $filteredFeatures[$index] = array_filter($Region1_MuniCities_GeojsonData->features, function($feature) use ($provinceName, $muniName) {
            return isset($feature->properties->NAME_1) && $feature->properties->NAME_1 === $provinceName && isset($feature->properties->NAME_2) && $feature->properties->NAME_2 === $muniName;
        });

        $mergedFeatures = [];
        foreach ($filteredFeatures as $features) {
            $mergedFeatures = array_merge($mergedFeatures, $features);
        }

        $Region1_MuniCities_GeojsonData = [
            'type' => 'FeatureCollection',
            'features' => $mergedFeatures,
        ];

        // getting the boundary Barangays
        $Region1_Barangays = file_get_contents(public_path('shapefile/Region1_Barangays.geojson'));
        $Region1_Barangays_GeojsonData = json_decode($Region1_Barangays);

        // Initialize an array to store filtered features
        $filteredFeatures = [];

        // Iterate over each option
        foreach ($Options as $index => $value) {
            $Barangays = $value['value'];

            // Filter features based on provinceName and Barangays
            $filteredFeatures[$index] = array_filter($Region1_Barangays_GeojsonData->features, function($feature) use ($provinceName, $muniName, $Barangays) {
                return isset($feature->properties->NAME_1) && $feature->properties->NAME_1 === $provinceName && isset($feature->properties->NAME_2) && $feature->properties->NAME_2 === $muniName && $feature->properties->NAME_3 === $Barangays;
            });
        }

        $mergedFeatures = [];
        foreach ($filteredFeatures as $features) {
            $mergedFeatures = array_merge($mergedFeatures, $features);
        }

        $Region1_Barangays_GeojsonData = [
            'type' => 'FeatureCollection',
            'features' => $mergedFeatures,
        ];

        $chartData = [];
        foreach ($Options as $index => $value) {
            // Initialize counters for each trend
            $accretionCount = 0;
            $erosionCount = 0;
            $stableCount = 0;
        
            // Iterate over features to count occurrences of each trend
            foreach ($geojsonMuniData['features'] as $feature) {
                // Use $value from the outer loop
                if ($feature->properties->NAME_2 === $muniName && $feature->properties->NAME_3 === $value['value']) {
                    // Increment counters based on trend
                    if ($request->layerName == 'epr' && isset($feature->properties->EPR_trend)) {
                        switch ($feature->properties->EPR_trend) {
                            case 'accretion':
                                $accretionCount++;
                                break;
                            case 'erosion':
                                $erosionCount++;
                                break;
                            case 'stable':
                                $stableCount++;
                                break;
                        }
                    } elseif ($request->layerName == 'nsm' && isset($feature->properties->NSM_trend)) {
                        switch ($feature->properties->NSM_trend) {
                            case 'accretion':
                                $accretionCount++;
                                break;
                            case 'erosion':
                                $erosionCount++;
                                break;
                            case 'stable':
                                $stableCount++;
                                break;
                        }
                    }
                }
            }
        
            // Calculate percentages
            $totalFeaturesCount = count($geojsonMuniData['features']);
            $x = $accretionCount;
            $z = $erosionCount;
            $t = $stableCount;
        
            // Create chart data object
            $gData = [
                'name' => $value['value'],
                'y' => round((($x + $t + $z) / $totalFeaturesCount) * 100, 2), // Calculate the 't' value as the remainder
                'x' => round(($x / ($x + $t + $z)) * 100, 2),
                'z' => round(($z / ($x + $t + $z)) * 100, 2),
                't' => round(($t / ($x + $t + $z)) * 100, 2),
            ];
        
            // Store the chart data for this value in the array
            $chartData[$index] = $gData;
        }

        

        if ($geojsonMuniData) {
            // Decode the GeoJSON content

            return response()->json([
                'chartData' => $chartData,
                'Region1_Barangays_GeojsonData' => $Region1_Barangays_GeojsonData,
                'Region1_MuniCities_GeojsonData' => $Region1_MuniCities_GeojsonData,
                'data' => $geojsonMuniData,
                'Options' => $Options,
                'properties' => $properties,
            ]);
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }

    public function getBarangaysData(Request $request){

        if($request->layerName == 'epr' || $request->layerName == 'nsm'){
            if($request->layerName == 'epr'){
                $geojsonContent = file_get_contents(public_path('shapefile/Region1_EPR.geojson'));
                $geojsonData = json_decode($geojsonContent);
            }
            if($request->layerName == 'nsm'){
                $geojsonContent = file_get_contents(public_path('shapefile/Region1_NSM.geojson'));
                $geojsonData = json_decode($geojsonContent);
            }
        }

        // Filter features based on the NAME_1 property equal to "Ilocos Norte"
        $provinceName = $request->provinceName;
        $muniName = $request->muniName;
        $brgyName = $request->brgyName;
        $filteredFeatures = array_filter($geojsonData->features, function($feature) use ($provinceName, $muniName, $brgyName) {
            return isset($feature->properties->NAME_1) && $feature->properties->NAME_1 === $provinceName && $feature->properties->NAME_2 === $muniName && $feature->properties->NAME_3 === $brgyName;
        });

        $newArray = [];
        $i = 0;
        foreach ($filteredFeatures as $index => $value) {
            $newArray[$i] = $value;
            $i++;
        }  

        // Construct GeoJSON FeatureCollection
        $geojsonBrgyData = [
            'type' => 'FeatureCollection',
            'features' => $newArray,
        ];

        $properties = [];
        $Options = [];

        foreach ($geojsonBrgyData['features'] as $key => $feature) {
            $properties[$key] = $feature->properties;
        }


        // getting the boundary Municipality
        $Region1_Barangays = file_get_contents(public_path('shapefile/Region1_Barangays.geojson'));
        $Region1_Barangays_GeojsonData = json_decode($Region1_Barangays);

        // Initialize an array to store filtered features

        // Iterate over each option

        // Filter features based on provinceName and Barangays and Barangays
        $filteredFeatures = array_filter($Region1_Barangays_GeojsonData->features, function($feature) use ($provinceName, $muniName, $brgyName) {
            return isset($feature->properties->NAME_1) && $feature->properties->NAME_1 === $provinceName && isset($feature->properties->NAME_2) && $feature->properties->NAME_2 === $muniName && $feature->properties->NAME_3 === $brgyName;
        });

        $newArray = [];
        $i = 0;
        foreach ($filteredFeatures as $index => $value) {
            $newArray[$i] = $value;
            $i++;
        }  

        // Construct GeoJSON FeatureCollection
        $Region1_Barangays_GeojsonData = [
            'type' => 'FeatureCollection',
            'features' => $newArray,
        ];

        $Options = ['Accreting', 'Eroded', 'Stable'];
        $chartData = [];

        $accretionCount = 0;
        $erosionCount = 0;
        $stableCount = 0;
    
        // Iterate over features to count occurrences of each trend
        foreach ($geojsonBrgyData['features'] as $feature) {
            // Use $value from the outer loop
            if ($feature->properties->NAME_2 === $muniName && $feature->properties->NAME_3 === $brgyName) {
                // Increment counters based on trend
                if ($request->layerName == 'epr' && isset($feature->properties->EPR_trend)) {
                    switch ($feature->properties->EPR_trend) {
                        case 'accretion':
                            $accretionCount++;
                            break;
                        case 'erosion':
                            $erosionCount++;
                            break;
                        case 'stable':
                            $stableCount++;
                            break;
                    }
                } elseif ($request->layerName == 'nsm' && isset($feature->properties->NSM_trend)) {
                    switch ($feature->properties->NSM_trend) {
                        case 'accretion':
                            $accretionCount++;
                            break;
                        case 'erosion':
                            $erosionCount++;
                            break;
                        case 'stable':
                            $stableCount++;
                            break;
                    }
                }
            }
        }
    
        // Calculate total count
        $totalFeaturesCount = count($geojsonBrgyData['features']);

        // Store the chart data for this value in the array
        $chartData[0] = [
            'name' => 'Accreting',
            'y' => round(($accretionCount / $totalFeaturesCount) * 100, 2),
        ];
        $chartData[1] = [
            'name' => 'Eroded',
            'y' => round(($erosionCount / $totalFeaturesCount) * 100, 2),
        ];
        $chartData[2] = [
            'name' => 'Stable',
            'y' => round(($stableCount / $totalFeaturesCount) * 100, 2),
        ];
        
        if ($geojsonBrgyData) {
            // Decode the GeoJSON content

            return response()->json([
                'chartData' => $chartData,
                'Region1_Barangays_GeojsonData' => $Region1_Barangays_GeojsonData,
                'data' => $geojsonBrgyData,
                'properties' => $properties,
            ]);
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }
}