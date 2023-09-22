<?php

namespace App\Http\Controllers\Image;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ImageController extends Controller
{
    public function index($id)
    {
        $folder = Folder::findOrFail($id);

        $count_images = Image::where('folder_id', $folder->id)->count();
        $all_images = Image::where('folder_id', $folder->id)->inRandomOrder()->get()->toArray();
        $final_images = $count_images ? $this->partition($all_images, 3) : [];

        return response()->json(['folder' => $folder, 'images' => $final_images]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'images' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 400, 'errors' => $validator->errors()->toArray()]);
        }

        $folder = Folder::findOrFail(request()->folder_id);

        $folder_name = str_replace(' ', '_', strtolower($folder->name));
        $user_name = str_replace(' ', '_', strtolower(auth()->user()->name));

        if (request()->hasFile('images')) {
            foreach (request()->file('images') as $key => $image) {
                $unique_name = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $filename = '/' . $user_name . '/' . $folder_name . '/' . $unique_name;
                $image->move(public_path($user_name . '/' . $folder_name), $unique_name);

                $filesize = number_format(File::size(public_path($user_name . '/' . $folder_name . '/' . $unique_name)) / 1048576, 3) . ' MB';

                Image::create([
                    'filename' => $filename,
                    'filesize' => $filesize,
                    'folder_id' => $folder->id
                ]);
            }
        }

        $noun = count(request()->images) > 1 ? 'Images' : 'Image';

        return response()->json(['code' => 200, 'message' => 'Upload ' . $noun . ' Successfully!']);
    }


    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        $image->delete();
        return response()->json(['message' => 'Deleted Image Successfully!']);
    }

    protected function partition($main_array, $size)
    {
        $total_count = count($main_array);
        $divided = floor($total_count / $size);

        $remainder = $total_count % $size;

        $small_array = array();
        $start = 0;
        for ($p = 0; $p < $size; $p++) {
            $length = ($p < $remainder) ? $divided + 1 : $divided;
            $small_array[$p] = array_slice($main_array, $start, $length);
            $start += $length;
        }

        return $small_array;
    }
}
