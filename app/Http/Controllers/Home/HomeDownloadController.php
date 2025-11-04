<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Download;
use App\Models\DownloadList;

class HomeDownloadController extends Controller
{
    public function submitDownload(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'agency' => 'required',
            'purpose' => 'required',
        ]);

        Download::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'agency' => $request->agency,
            'purpose' => $request->purpose,
        ]);

        for ($i = 0; $i < count($request->data); $i++) {
            DownloadList::create([
                'download_id' => Download::latest()->first()->id,
                'name' => $request->data[$i],
            ]);
        }

        return $request;
    }
}
