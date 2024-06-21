<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Storage;

class StorageController extends Controller
{
    public function postApi(Request $request){
        $Storage = new Storage;
        $Storage->msg = $request->msg;
        $Storage->save();
    }

    public function getApi($msg){
        $Storage = new Storage;
        $Storage->msg = $msg;
        $Storage->save();
    }

    public function getMsg(){
        return Storage::latest()->first();
    }
}
