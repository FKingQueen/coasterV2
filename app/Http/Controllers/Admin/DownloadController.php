<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Download;
use File;
use Illuminate\Support\Facades\Mail;
use App\Mail\DownloadMail;

class DownloadController extends Controller
{
    public function getDownload(){
        return Download::with('downloadList')->orderBy('id', 'desc')->get();
    }
    public function uploadDownload(Request $request)
    {
        // Validate the request
        $request->validate([
            'file' => 'required|file' // Ensure it's a file
        ]);

        $file = $request->file('file'); // Access the uploaded file
        $timestamp = time(); // Get the current timestamp
        $extensions = $file->getClientOriginalExtension(); // Get the original file extension
        $fileName = Auth::id() . '_' . $timestamp . '.' . $extensions; // Construct the filename with timestamp and original extension

        // Use the storeAs method to save the filews 
        $file->move(public_path('download'), $fileName);

        return $fileName;
    }
    public function sendEmail(Request $request){
        foreach($request->attachments as $key => $attach){
            $filePath[$key] = public_path('download' . DIRECTORY_SEPARATOR . $attach);
        };

        Mail::to($request->recipient)->send(new DownloadMail($request, $filePath));

        try {
            // Send email
            Mail::to($request->recipient)->send(new DownloadMail($request, $filePath));
    
            // Check if email was not failed
            if (count(Mail::failures()) > 0) {
                return response()->json([
                    'message' => 'Failed to send email.',
                    'status' => 'failed'
                ], 500);
            }

            $Download = Download::find($request->id);

            $Download->delete();
    
            // Email sent successfully
            return response()->json([
                'message' => 'Email sent successfully!',
                'status' => 'success'
            ], 200);
        } catch (Exception $e) {
            // Handle any errors
            return response()->json([
                'message' => 'An error occurred while sending the email: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
        }

        return "Email is Sent.";
    }
}
