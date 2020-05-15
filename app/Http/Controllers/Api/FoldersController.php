<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Folders;
use Illuminate\Http\Request;

class FoldersController extends Controller
{
    public function index()
    {
        return response()->json(Folders::get());
    }
}
