<?php

namespace App\Http\Controllers\API\Rate;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use Illuminate\Http\Request;

class ListController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function execute() {
        return response()->json([Rate::all()]);
    }
}
