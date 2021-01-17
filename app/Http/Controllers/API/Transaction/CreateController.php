<?php

namespace App\Http\Controllers\API\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Transaction\Create;
use App\Models\Rate;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class CreateController extends Controller
{
    /**
     * @param Create $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function execute(Create $request) {
        $from_currency = Rate::where('name', $request->pair1)->first();
        $to_currency = Rate::where('name', $request->pair2)->first();

        Transaction::create([
           'user_id' => Auth::user()->id,
           'from_currency' => $from_currency->id,
           'to_currency' => $to_currency->id,
           'base_amount' => $request->amount,
           'result_amount' => $request->amount * ($from_currency->rate / $to_currency->rate),
           'wallet' => $request->wallet,
           'status' => 'pending'
        ]);

        return response()->json(['success' => 'Запрос на обмен средств отправлен. Ожидайте зачисления в течении 24 часов']);
    }
}
