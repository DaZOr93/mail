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

        return Signature::where('user_id', $user_id)->orderBy('id', 'desc')->get();

    }

    public function save($signatures)
    {
        $user_id = 1;


        foreach ($signatures->all() as $signature) {
            if($signature['id'] =='default'){
                $signature['id'];
                $idDefault =  $signature['idDefault'];
            }
            if(($signature['id']) && ($signature['id'] !='default')){
                $oldSignature = Signature::find($signature['id']);
                if(($oldSignature->name != $signature['name']) || ($oldSignature->text != $signature['text']) ){
                    $oldSignature->name = $signature['name'];
                    $oldSignature->text = $signature['text'];
                    $oldSignature->update();


                }
                $id[] = $signature['id'];

            }
            if(empty($signature['id'])){
                $sign = new Signature();
                $sign->name = $signature['name'];
                $sign->text = $signature['text'];
                $sign->user_id = $user_id;
                if($idDefault == $signature['name'].$signature['text'] ){
                    $sign->save();
                    $idDefault= $sign->id;
                }
                else{
                    $sign->save();
                }

                $id[ ]= $sign->id;
            }
        }

        Signature::whereNotIn('id', $id)->Where('user_id',$user_id)->delete();
        Signature::Where('id', $idDefault)->update(['default' => 1]);
        Signature::where('id', '!=', $idDefault)->Where('user_id',$user_id)->update(['default' => 0]);





    }
}
