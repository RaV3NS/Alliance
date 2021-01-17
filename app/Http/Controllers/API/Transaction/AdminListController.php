<?php

namespace App\Http\Controllers\API\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminListController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function execute() {
        return response()->json(Transaction::with('user')->paginate(15));
    }
}
