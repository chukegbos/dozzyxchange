<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Account;
use Redirect;
use Auth;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\CryptoTransaction;
use App\Crypto;

class LiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    public function confirm($confirmation_code)
    {
        $user = User::where('confirmation_code', $confirmation_code)->first();
        if($user){
            $user->confirmed = 1;
            $user->confirmation_code = null;
            $user->save();
            return Redirect::route('home')->with('success', 'Email confirmed.');
        }
        else{
           return Redirect::route('home')->with('success', 'Email confirmed.'); 
        }
    }

    public function callback()
    {
        $secret = '6b387ad2af72137aa893a12a6c812656';
        //$txid = $_GET['txid'];
        //$value = $_GET['value'];
        //$status = $_GET['status'];
        //$addr = $_GET['addr'];

        $txid = request('txid');
        $value = request('value');
        $status = request('status');
        $addr = request('addr');

        $transaction = CryptoTransaction::where('addr', $addr)->first();
        //Match secret for security
        if (request('secret') != $secret) {
            return;
        }


        if ($status == 1) {
            $transaction->txid = $txid;
            $transaction->status = 1;
            $transaction->value = $value;
            $transaction->update();
            return;
        }

        if ($status == 2) {

            $crypto = $transaction->crypto_id;
            $get_crypto = Crypto::where('deleted_at', NULL)->find($crypto);
            $buying_rate = $get_crypto->buying_rate;
            $amount_rec = $buying_rate * $value;

            $transaction->txid = $txid;
            $transaction->status = 2;
            $transaction->value = $value;
            $transaction->amount_rec = $amount_rec;
            $transaction->update();

            $account = new Account();
            $account->user_id = $transaction->user_id;
            $account->txid = $transaction->txid;
            $account->type = 'credit';
            $account->amount = $transaction->amount_rec;
            $account->purpose = 'Recieved payment for crypto transaction '.$transaction->txid;
            $account->save();

            $user = User::where('deleted_at', NULL)->find($transaction->user_id);
            $user->balance = $user->balance + $transaction->amount_rec;
            $user->update();
            return;
        }
    }
}
