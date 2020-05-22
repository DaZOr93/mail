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
        foreach ($signatures as $signature) {

            $sign = Signature::where('id', $signature['id'])->first();
            $sign->delete();
        }

    }
}
