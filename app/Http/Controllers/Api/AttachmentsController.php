<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttachmentsRequest;
use App\Models\Attachments;

class AttachmentsController extends Controller
{
    public function store(StoreAttachmentsRequest $request)
    {
        $attach = new Attachments();
        $attach->letter_id = $request->draftId;
        $attach->name = $request->file('file')->getClientOriginalName();
        $attach->path = $request->file('file')->store('\sending');
        $attach->mime_type =substr( $attach->name, strrpos( $attach->name, '.') + 1);

        $attach->save();

        return response()->json([$attach->path, $attach->mime_type ,  $attach->name] , 200);
    }

    public function delete($path)
    {
         Attachments::where('path' , "\sending/{$path}")->first()->delete();
         unlink('storage/app/sending/' . $path);

         return response()->json('deleted' , 200);
    }

}
