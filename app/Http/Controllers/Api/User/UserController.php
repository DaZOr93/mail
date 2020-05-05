<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
   public function index()
   {
       $user = Auth::user();
       return response()->json($user);
   }
}
