<?php

namespace App\Http\Controllers;

use App\Airtime;
use App\AirtimeTransaction;
use Illuminate\Http\Request;
use App\Line;
use Auth;
use App\User;
use App\Account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use DB;

class AirtimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $airtimes = Airtime::where('deleted_at', NULL)->get();
        return view('airtime', compact('airtimes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:250',
            'rate' => 'required|string|max:250',
            'image' => 'required|mimes:png,jpeg,jpg',
            'pin_change' => 'required|string|max:250',
            'transfer_code' => 'required|string|max:250',
        ]);

        if ($request->file('image')) {
            $file = $request->file('image');
            $image = Storage::disk('public')->putFile('lines', $file);
        } 
        else
        {
            $image = NULL;
        }

        Airtime::create([
            'name' => $request['name'],
            'rate' => $request['rate'],
            'image' => $image,
            'pin_change' => $request['pin_change'],
            'transfer_code' => $request['transfer_code'],
        ]);

        $status = ucfirst($request['name']).' added successfuly';
        //return redirect()->route('leave')->withErrors(['You have left the class']);
        return redirect()->back()->with('success', $status );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Airtime  $Airtime
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $airtime = Airtime::where('deleted_at', NULL)->find($id);
        $lines = Line::where('deleted_at', NULL)->where('airtime_id', $airtime->id)->get();
        return view('lines', compact('lines', 'airtime'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Airtime  $Airtime
     * @return \Illuminate\Http\Response
     */
    public function edit($ref_id)
    {   
        $transaction = AirtimeTransaction::where('deleted_at', NULL)->where('ref_id', $ref_id)->first();
        $transaction->status = 'approved';
        $transaction->update();

        $account = new Account();
        $account->user_id = $transaction->user_id;
        $account->txid = $transaction->ref_id;
        $account->type = 'credit';
        $account->amount = $transaction->paying;
        $account->purpose = 'Recieved payment for selling of airtime '.$transaction->ref_id;
        $account->save();

        $user = User::where('deleted_at', NULL)->find($transaction->user_id);
        $user->balance = $user->balance + $transaction->paying;
        $user->update();

        $status = 'Transaction approved successfuly';
        return redirect()->back()->with('success', $status );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Airtime  $Airtime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:250',
            'rate' => 'required|string|max:250',
            'image' => 'mimes:png,jpeg,jpg',
            'pin_change' => 'required|string|max:250',
            'transfer_code' => 'required|string|max:250',
        ]);

        $airtime = Airtime::where('deleted_at', NULL)->find($id);
        if ($request->file('image')) {
            $file = $request->file('image');
            $image = Storage::disk('public')->putFile('airtime', $file);
        } 
        else
        {
            $image = $airtime->image;
        }

        $airtime->update([
            'name' => $request['name'],
            'rate' => $request['rate'],
            'pin_change' => $request['pin_change'],
            'transfer_code' => $request['transfer_code'],
            'image' => $image,
        ]);

        $status = ucfirst($request['name']).' updated successfuly';
        //return redirect()->route('leave')->withErrors(['You have left the class']);
        return redirect()->back()->with('success', $status );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Airtime  $Airtime
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Airtime::destroy($id);
        return redirect()->back()->with('success', 'Network deleted!');
    }

    public function transaction_airtime()
    {
        $transactions = AirtimeTransaction::where('airtime_transactions.deleted_at', NULL)
            ->orderBy('airtime_transactions.created_at', 'Desc')
            ->join('airtimes', 'airtime_transactions.network_id', '=', 'airtimes.id')
            ->join('users', 'airtime_transactions.user_id', '=', 'users.id')
            ->get();
        return view('airtime_transaction', compact('transactions'));
    }

    public function delete_airtime($ref_id)
    {
        $airtime = AirtimeTransaction::where('ref_id', $ref_id)->first(); 
        AirtimeTransaction::destroy($airtime->id);
        return back();
    }
}
