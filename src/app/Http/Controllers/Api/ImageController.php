<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;
use App\Orm\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class ImageController extends Controller
{


    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', Rule::dimensions()->minWidth(400)->minHeight(300)->maxHeight(2000)->maxWidth(2000)]
        ]);

        $originalFileName = $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storePublicly('', 'images');
        $prefix = Storage::disk('images')->getDriver()->getAdapter()->getPathPrefix();
        ImageOptimizer::optimize($prefix . $path);

        $image = new Image;
        $image->uid = $path;
        $image->creator_id = $request->user()->id;
        $image->filename = $originalFileName;
        $image->save();

        return response(new ImageResource($image), 201);
    }


}