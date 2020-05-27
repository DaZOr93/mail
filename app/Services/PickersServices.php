<?php


namespace App\Services;


use App\Models\Folders;
use App\Models\Letter;
use App\Models\Pickers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PickersServices extends ConnectServices
{

    public function index()
    {
        $user_ud = Auth::user()->id;

        return Pickers::where('user_id', $user_ud)->whereNotNull('folder_name')->get();
    }

    /**
     * @param $request
     * @return JsonResponse|void
     */
    public function storePickers($request)
    {
        //создать сборщик
        $data = $request;
        $picker = new Pickers();
        $picker->user_id = Auth::user()->id;
        $picker->email = $data['email'];
        $picker->folder_name = $data['email'];
        $picker->password = $data['password'];
        $picker->driver = $data['driver'];
        $picker->port = $data['port'];
        $picker->save();

        //создать папку
        $folder = new Folders();
        $folder->user_id = Auth::user()->id;
        $folder->name = $data['email'];
        $folder->slug = $data['email'];
        $folder->pickers = 1;
        $folder->description = 'Сборщик почты для ящика <' . $data['email'] . '>';
        $folder->save();

        return;
    }


    public function check($request)
    {
        $request = (object)$request;
        $this->connect($request);

        return Pickers::find($request->id)->update(['status' => 1]);
    }

    public function delete($request)
    {
        Pickers::find($request->id)->delete();
        Folders::where('slug' , $request->email)->first()->delete();
        Letter::where('folder_id' , $request->id)->delete();

        return;
    }
}
