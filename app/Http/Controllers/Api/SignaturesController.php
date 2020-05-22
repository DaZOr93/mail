<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SignaturesService;

class SignaturesController extends Controller
{
    protected $signaturesService;

    public function __construct(SignaturesService $signaturesService)
    {
        $this->signaturesService = $signaturesService;
    }
    public function index()
    {
        return response()->json($this->signaturesService->index(), 200);
    }

    public function save($signatures)
    {

        return response()->json($this->signaturesService->save($signatures), 200);
    }
    //
}
