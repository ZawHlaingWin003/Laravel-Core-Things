<?php

namespace App\Http\Controllers\Image;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FolderController extends Controller
{
    public function index()
    {
        return view('pages.image_upload.folder.index');
    }

    public function getFolders()
    {
        $folders = Folder::where('user_id', auth()->user()->id)->get();
        return response()->json($folders);
    }

    public function create()
    {
        return view('pages.image_upload.folder.create');
    }

    public function store()
    {

        request()->validate([
            'name' => 'required|unique:folders,name'
        ]);

        Folder::create([
            'name' => request()->name,
            'user_id' => auth()->user()->id
        ]);

        // return response()->json(['message' => 'Create Folder Successfully!']);
        return redirect()->route('folder.index')->with('success', 'Success!');
    }

    public function show($id)
    {
        $folder = Folder::findOrFail($id);
        return view('pages.image_upload.image.index', compact('folder'));
    }

    public function edit($id)
    {
        //
    }

    public function update($id)
    {
        $folder = Folder::findOrFail($id);
        $validator = Validator::make(request()->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()){
            return response()->json(['code' => 400, 'errors'=> $validator->errors()->toArray()]);
        }

        $folder->update([
            'name' => request()->name
        ]);

        return response()->json(['code' => 200, 'message' => 'Update Folder Name Successfully!']);
    }

    public function destroy($id)
    {
        $folder = Folder::findOrFail($id);
        $folder->delete();

        return response()->json(['message' => 'Delete Folder Successfully!']);
    }
}