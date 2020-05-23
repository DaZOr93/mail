<?php


namespace App\Services;

use App\Models\Signature;
use Illuminate\Http\JsonResponse;


class SignaturesService
{
    /**
     * @param array $data
     *
     * @return JsonResponse
     */
    public function index()
    {
        $user_id = 1;

        return Signature::where('user_id', $user_id)->get();

    }

    public function save($signatures)
    {
        $user_id = 1;


        foreach ($signatures->all() as $signature) {
            if($signature['id']){
                $oldSignature = Signature::find($signature['id']);
                if(($oldSignature->name != $signature['name']) || ($oldSignature->text != $signature['text']) || ($oldSignature->default != $signature['default']) ){
                    $oldSignature->name = $signature['name'];
                    $oldSignature->text = $signature['text'];
                    $oldSignature->default = $signature['default'];
                    $oldSignature->update();


                }
                $id[] = $signature['id'];

            }
            if(empty($signature['id'])){
                $sign = new Signature();
                $sign->name = $signature['name'];
                $sign->text = $signature['text'];
                $sign->user_id = $user_id;
                $sign->save();
                $id[ ]= $sign->id;
            }

        }

        $signq = Signature::whereNotIn('id', $id)->Where('user_id',$user_id)->delete();


    }
}
