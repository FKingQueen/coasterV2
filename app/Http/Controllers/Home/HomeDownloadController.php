<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Download;

class HomeDownloadController extends Controller
{
    public function storeDownload(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'agency' => 'required',
            'purpose' => 'required',
        ]);

        // return $request;
        Download::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'agency' => $request->agency,
            'purpose' => $request->purpose,
        ]);

        return $validated;
    }
}
