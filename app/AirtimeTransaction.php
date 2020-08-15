<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\User;

class AirtimeTransaction extends Model
{
    use SoftDeletes;
    protected $table = 'airtime_transactions';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'network_id', 'sender_phone', 'amount', 'paying', 'rec_number', 'status', 'pop', 'ref_id'
    ];

    protected $dates = [
        'deleted_at', 
    ];
}
