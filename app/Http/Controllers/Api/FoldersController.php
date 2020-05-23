<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Folders;
use App\Models\Letter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FoldersController extends Controller
{
    public function index()
    {
        $user_id =  Auth::user()->id;

        return response()->json(Folders::where('user_id' , $user_id)->get());
    }

    public function update(Request $request)
    {
        foreach ($request->all() as $item) {
           $folder = Folders::find($item['id']);
           $folder->name = $item['name'];
           $folder->slug = Str::slug($item['name']);
           $folder->description = $item['description'];
           $folder->color = $item['color'];
           $folder->color_name = $item['color_name'];
           $folder->save();
        }

        return response()->json('updated');
    }

    public function delete(Request $request){
       $userAuth = Auth::user()->id;
       $folders = Folders::where('user_id' , $userAuth)->get();

       foreach ($folders as $folder) {
           if(in_array($folder->id, $request->all())) {
               Letter::where('folder_id', $folder->id)->update(['folder_id' => null]);
               $folder->delete();
           };
       }
       return response()->json('deleted');
    }
}
