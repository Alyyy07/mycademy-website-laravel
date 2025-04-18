<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('materi/images', $fileName, 'public');

            return response()->json([
                'url' => asset('storage/' . $filePath),
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function delete(Request $request)
    {

        $imageUrl = $request->imageUrl;

        if (!$imageUrl) {
            return response()->json(['error' => 'Missing imageUrl'], 400);
        }

        $path = str_replace(asset('storage') . '/', '', $imageUrl);
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return response()->json(['message' => 'Image deleted']);
        }

        return response()->json(['error' => 'File not found'], 404);
    }
}
