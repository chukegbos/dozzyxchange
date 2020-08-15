<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Account;
use Auth;
use App\User;

class Account extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'amount', 'type', 'purpose', 'txid'
    ];

    protected $dates = [
        'deleted_at', 'due_date'
    ];
}
