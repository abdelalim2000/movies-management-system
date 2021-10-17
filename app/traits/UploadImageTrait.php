<?php

namespace App\traits;

use App\Models\Image;
use Illuminate\Support\Facades\File;

trait UploadImageTrait
{
    public function uploadImage($request, $inputName, $folderName, $image_name, $disk, $imageable_id, $imageable_type)
    {
        if ($request->hasFile($inputName)) {
            $image = $request->file($inputName);
            $name = $image_name . uniqid() . '.' . $image->getClientOriginalExtension();
            Image::query()->create([
                'path' => 'uploads/' . $folderName . '/' . $name,
                'imageable_id' => $imageable_id,
                'imageable_type' => $imageable_type
            ]);
            return $image->storeAs($folderName, $name, $disk);
        }
        return null;
    }

    public function deleteImage($request, $inputName, $path, $image_id)
    {
        if ($request->hasFile($inputName)) {
            if (File::exists(public_path($path))) {
                File::delete(public_path($path));
            }
            return Image::query()->find($image_id)->delete();
        }
        return null;
    }

    public function imageDelete($path, $image_id)
    {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
        return Image::query()->find($image_id)->delete();
    }
}
