<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ListController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function execute() {
        return response()->json(User::withCount('transactions')->paginate(15));
    }
}
