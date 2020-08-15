<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\User;

class CryptoTransaction extends Model
{
    use SoftDeletes;
    protected $table = 'crypto_transactions';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'crypto_id', 'type', 'value', 'txid', 'status', 'addr', 'amount_rec'
    ];

    protected $dates = [
        'deleted_at', 
    ];
}

