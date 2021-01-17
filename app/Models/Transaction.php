<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['from_currency', 'to_currency', 'base_amount', 'result_amount', 'user_id', 'status', 'wallet'];

    protected $with = ['fromCurrency', 'toCurrency'];

    public function fromCurrency() {
        return $this->belongsTo('App\Models\Rate', 'from_currency');
    }

    public function toCurrency() {
        return $this->belongsTo('App\Models\Rate', 'to_currency');
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
