<?php

namespace App\Http\Controllers;

use App\Crypto;
use App\CryptoTransaction;
use Illuminate\Http\Request;
use App\Btc;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use DB;

class CryptoController extends Controller
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
        $cryptos = Crypto::where('deleted_at', NULL)->get();
        return view('crypto', compact('cryptos'));
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
            'selling_rate' => 'required|string|max:250',
            'buying_rate' => 'required|string|max:250',
            'image' => 'required|mimes:png,jpeg,jpg',
        ]);

        if ($request->file('image')) {
            $file = $request->file('image');
            $image = Storage::disk('public')->putFile('btc', $file);
        } 
        else
        {
            $image = NULL;
        }

        Crypto::create([
            'name' => $request['name'],
            'selling_rate' => $request['selling_rate'],
            'buying_rate' => $request['buying_rate'],
            'image' => $image,
        ]);

        $status = ucfirst($request['name']).' added successfuly';
        //return redirect()->route('leave')->withErrors(['You have left the class']);
        return redirect()->back()->with('success', $status );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Crypto  $crypto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $crypto = Crypto::where('deleted_at', NULL)->find($id);
        $btcs = Btc::where('deleted_at', NULL)->where('crypto_id', $crypto->id)->get();
        return view('coin', compact('btcs', 'crypto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Crypto  $crypto
     * @return \Illuminate\Http\Response
     */
    public function edit(Crypto $crypto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Crypto  $crypto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:250',
            'selling_rate' => 'required|string|max:250',
            'buying_rate' => 'required|string|max:250',
            'image' => 'mimes:png,jpeg,jpg',
        ]);

        $crypto = Crypto::where('deleted_at', NULL)->find($id);
        if ($request->file('image')) {
            $file = $request->file('image');
            $image = Storage::disk('public')->putFile('btc', $file);
        } 
        else
        {
            $image = $crypto->image;
        }

        $crypto->update([
            'name' => $request['name'],
            'selling_rate' => $request['selling_rate'],
            'buying_rate' => $request['buying_rate'],
            'image' => $image,
        ]);

        $status = ucfirst($request['name']).' updated successfuly';
        //return redirect()->route('leave')->withErrors(['You have left the class']);
        return redirect()->back()->with('success', $status );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Crypto  $crypto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Crypto::destroy($id);
        return redirect()->back()->with('success', 'Crypto deleted!');
    }

    public function transaction_crypto()
    {
        $transactions = CryptoTransaction::where('crypto_transactions.deleted_at', NULL)
            ->orderBy('crypto_transactions.created_at', 'Desc')
            ->join('users', 'crypto_transactions.user_id', '=', 'users.id')
            ->get();
        return view('crypto_transaction', compact('transactions'));
    }

}
