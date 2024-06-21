<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Inventory;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InventoryImport;
use DB;


class InventoryController extends Controller
{
    public function getInventory(){
        if(Auth::user()->role_id == 1){
            return Inventory::orderBy('id', 'desc')->get();
        } else {
            return Inventory::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        }
    }
    
    public function storeInventory(Request $request){

        $newInventory = new Inventory;
        $newInventory->user_id = Auth::id();
        $newInventory->image = $request->image;
        $newInventory->coastalID = $request->coastalID;
        $newInventory->province = $request->province;
        $newInventory->coastalProtection = $request->coastalProtection;
        $newInventory->latitude = $request->latitude;
        $newInventory->longitude = $request->longitude;
        $newInventory->locationType = $request->locationType;
        $newInventory->yearCompleted = $request->yearCompleted;
        $newInventory->length = $request->length;
        $newInventory->heightRange = $request->heightRange;
        $newInventory->primaryMaterial = $request->primaryMaterial;
        $newInventory->primaryMaterial = $request->primaryMaterial;
        $newInventory->conditionRating = $request->conditionRating;
        $newInventory->crDesc = $request->crDesc;
        $newInventory->priorityRating = $request->priorityRating; 
        $newInventory->prDesc = $request->prDesc; 
        $newInventory->save();

        return $request->all();
    }

    public function deleteImageInventory(Request $request){
        $fileName = $request->imageName;
        $this->deleteFileFromServe($fileName);
        return 'done';
    }

    public function deleteFileFromServe($fileName){
        $filePath = public_path().'/inventory/'.$fileName;
        if(file_exists($filePath)){
            @unlink($filePath);
        }
        return;
    }

    public function deleteInventory(Request $request){
        // return $request;
        $Inventory = Inventory::find($request->id);
        $fileName = $Inventory->image;

        $filePath = public_path().'/inventory/'.$fileName;
        if(file_exists($filePath)){
            @unlink($filePath);
        }
        $Inventory->delete();
        return $fileName;
    }

    public function uploadInventory(Request $request){
        $request->validate([
            'file' => 'required'
        ]); 
        $file = $request->file;
        $picName = time().'.webp';

        $img = \Image::make($file)->encode('webp');

        if($img->width()>=800){
            $img->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $img->save(public_path('/inventory/'.$picName));

        // $request->file->move(public_path('uploads/high'),$picName);
        return $picName;
    }

    public function getInventoryEdit($id){
        $inventory = Inventory::where('id', $id)->get();
        return $inventory;
    }

    public function updateInventory(Request $request){

        DB::table('inventories')
        ->where('id', $request->id)
        ->update([
        'province' => $request->province,
        'image' => $request->image,
        'coastalID' => $request->coastalID,
        'province' => $request->province,
        'coastalProtection' => $request->coastalProtection,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'locationType' => $request->locationType,
        'yearCompleted' => $request->yearCompleted,
        'length' => $request->length,
        'heightRange' => $request->heightRange,
        'primaryMaterial' => $request->primaryMaterial,
        'conditionRating' => $request->conditionRating,
        'crDesc' => $request->crDesc,
        'priorityRating' => $request->priorityRating, 
        'prDesc' => $request->prDesc, 
        ]);

        return;
    } 

    public function importInventory(Request $request){
        $path = $request->file('file')->getRealPath();

        $res = Excel::import(new InventoryImport, $request->file);
        
        if($res){
            return "success";
        }
        return "failed";
       
    }

}
