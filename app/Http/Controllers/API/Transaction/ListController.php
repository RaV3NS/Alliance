<?php

namespace App\Http\Controllers\API\Transaction;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function execute(Request $request) {
        $user = $request->has('user') ? User::findOrFail($request->user) : Auth::user();
        return response()->json($user->transactions()->paginate(15));
    }
}
