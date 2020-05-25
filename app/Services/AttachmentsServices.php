<?php


namespace App\Services;


use App\Models\Attachments;

class AttachmentsServices
{


    /**
     * @param $letter_id
     * @return mixed
     */
    public function index($letter_id)
    {
        return Attachments::where('letter_id', $letter_id)->get();
    }

    /**
     * @param $request
     * @return array
     */
    public function store($request)
    {
        $attach = new Attachments();
        $attach->letter_id = $request->draftId;
        $attach->name = $request->file('file')->getClientOriginalName();
        $attach->path = $request->file('file')->store('/sending');
        $attach->mime_type = substr($attach->name, strrpos($attach->name, '.') + 1);

        $attach->save();

        return ['path' => $attach->path, 'mime_type' => $attach->mime_type, 'name' => $attach->name];
    }

    /**
     * @param $path
     */
    public function destroy($path)
    {
        Attachments::where('path', "sending/{$path}")->first()->delete();
        unlink('storage/app/sending/' . $path);

        return;
    }
}
