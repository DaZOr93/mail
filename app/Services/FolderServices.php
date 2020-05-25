<?php


namespace App\Services;


use App\Models\Folders;
use App\Models\Letter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FolderServices
{

    public function index()
    {
        $user_id = Auth::user()->id;

        return Folders::where('user_id', $user_id)->get();
    }

    public function getForSettings($limit)
    {
        $user_id = Auth::user()->id;

        return Folders::where('user_id', $user_id)->paginate($limit);
    }

    public function update($request)
    {
        foreach ($request->all() as $item) {
            $folder = Folders::find($item['id']);
            $folder->name = $item['name'];
            $folder->slug = Str::slug($item['name']);
            $folder->description = $item['description'] ?? '';
            $folder->color = $item['color'] ?? '';
            $folder->color_name = $item['color_name'] ?? '';
            $folder->save();
        }

        return response()->json('updated');
    }

    public function delete($request)
    {
        $userAuth = Auth::user()->id;
        $folders = Folders::where('user_id', $userAuth)->get();

        foreach ($folders as $folder) {
            if (in_array($folder->id, $request->all())) {
                Letter::where('folder_id', $folder->id)->update(['folder_id' => null]);
                $folder->delete();
            };
        }

        return 'deleted';
    }

    public function store($request)
    {
        $userAuth = Auth::user()->id;

        $folder = new Folders();
        $folder->user_id = $userAuth;
        $folder->name = $request['name'];
        $folder->description = $request['description'];
        $folder->color = $request['color'];
        $folder->color_name = $request['color_name'];
        $folder->slug = Str::slug($request['name']);
        $folder->save();

        return 'stored';
    }

}
