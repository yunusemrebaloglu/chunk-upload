<?php

namespace YunusEmreBaloglu\ChunkUpload\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChunkUploadController extends BaseController
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required',
            'name' => 'required|string',
        ]);
        $file = $request->file('file');
        $path = Storage::disk(config('chunk-upload.disk'))->path($file->getClientOriginalName());

        File::append($path, $file->get());
        if ($request->has('is_last') && $request->boolean('is_last')) {
            if (pathinfo($path, PATHINFO_EXTENSION) == 'part')
                $extension = explode(".", pathinfo($path, PATHINFO_FILENAME))[1];
            else
                $extension = $request->file->extension();
            $random_name = Str::random(40);
            $fileName = $random_name . "." . $extension;
            File::move($path, Storage::disk(config('chunk-upload.disk'))->path($fileName));
            return response()->json(['name' => $fileName]);
        }
        return response()->json(['uploaded' => true]);
    }

    public function delete_file($file)
    {
        return Storage::disk(config('chunk-upload.disk'))->delete($file);
    }
}
